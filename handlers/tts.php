<?php
/**
 * Text-to-speech proxy.
 *
 * Browsers only speak a language when a voice for it is installed, and Tamil,
 * Malayalam, Kannada and Telugu voices are absent on most desktops. Synthesising
 * server-side sidesteps that entirely: the browser just plays audio, so the
 * device needs no voices at all.
 *
 * Two backends:
 *
 *   'google'  (default) — Google Translate's TTS endpoint. No key, no signup,
 *             covers all six languages. It is an undocumented endpoint, so treat
 *             it as a good default rather than a guarantee: it is rate limited
 *             per IP and could change without notice.
 *
 *   a URL     — your own service. POST {"text","lang"} -> audio bytes. Point
 *             TTS_ENDPOINT at an AI4Bharat Indic-TTS deployment for production
 *             quality and no third-party dependency.
 *
 * Proxied rather than called from the browser so the backend and any
 * credentials stay server-side and the same rate limit applies.
 */

declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/config.php';
require_once dirname(__DIR__) . '/includes/ai.php';

header('X-Content-Type-Options: nosniff');

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
    http_response_code(405);
    exit;
}

$body = json_decode(file_get_contents('php://input') ?: '', true);
$text = trim((string) ($body['text'] ?? ''));
$lang = assistant_language((string) ($body['lang'] ?? 'en'));

if ($text === '') {
    http_response_code(400);
    exit;
}

// Synthesis cost and latency scale with length, and this is a public endpoint.
$text = mb_substr($text, 0, 900);

// Shares the chat endpoint's budget so voice cannot be used to bypass it.
$now = time();
$_SESSION['tts_hits'] = array_values(array_filter(
    $_SESSION['tts_hits'] ?? [],
    static fn (int $t): bool => $t > $now - AI_RATE_WINDOW_SECONDS
));

if (count($_SESSION['tts_hits']) >= AI_RATE_MAX_PER_WINDOW) {
    http_response_code(429);
    exit;
}

$_SESSION['tts_hits'][] = $now;

/**
 * Split on sentence boundaries under a byte budget.
 *
 * The Google endpoint truncates long input, so anything sizeable has to be
 * requested in pieces and concatenated. MP3 frames can be joined end to end,
 * which is why the parts play as one clip.
 */
function tts_chunks(string $text, int $limit = 180): array
{
    $parts  = preg_split('/(?<=[.!?।॥])\s+/u', $text) ?: [$text];
    $chunks = [];
    $buffer = '';

    foreach ($parts as $part) {
        if ($buffer !== '' && mb_strlen($buffer . ' ' . $part) > $limit) {
            $chunks[] = $buffer;
            $buffer   = '';
        }
        // A single sentence over the limit still has to be broken up.
        while (mb_strlen($part) > $limit) {
            $chunks[] = mb_substr($part, 0, $limit);
            $part     = mb_substr($part, $limit);
        }
        $buffer = $buffer === '' ? $part : $buffer . ' ' . $part;
    }

    if (trim($buffer) !== '') {
        $chunks[] = $buffer;
    }

    return array_slice(array_filter($chunks, static fn (string $c): bool => trim($c) !== ''), 0, 8);
}

/** Fetch one chunk of speech from Google Translate's TTS endpoint. */
function tts_google(string $text, string $code): ?string
{
    $url = 'https://translate.google.com/translate_tts?' . http_build_query([
        'ie'      => 'UTF-8',
        'q'       => $text,
        'tl'      => $code,
        'client'  => 'tw-ob',
        'total'   => 1,
        'idx'     => 0,
        'textlen' => mb_strlen($text),
    ]);

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT        => 20,
        CURLOPT_FOLLOWLOCATION => true,
        // The endpoint rejects requests without a browser user agent.
        CURLOPT_USERAGENT      => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 '
                                . '(KHTML, like Gecko) Chrome/120.0 Safari/537.36',
        CURLOPT_HTTPHEADER     => ['Referer: https://translate.google.com/'],
    ]);
    ai_curl_ca($ch);

    $audio  = curl_exec($ch);
    $status = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return ($audio !== false && $status === 200 && $audio !== '') ? $audio : null;
}

if (!function_exists('curl_init')) {
    http_response_code(503);
    exit;
}

/**
 * Sarvam AI — the preferred backend when a key is configured.
 *
 * Purpose-built for Indian languages, which is precisely where browser voices
 * fall down. Returns base64 WAV chunks, one per input string.
 */
function tts_sarvam(string $text, string $bcp47): ?string
{
    $ch = curl_init('https://api.sarvam.ai/text-to-speech');
    curl_setopt_array($ch, [
        CURLOPT_POST           => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT        => 30,
        CURLOPT_HTTPHEADER     => [
            'Content-Type: application/json',
            'api-subscription-key: ' . SARVAM_API_KEY,
        ],
        CURLOPT_POSTFIELDS     => json_encode([
            'text'                 => $text,
            'target_language_code' => $bcp47,
            'speaker'              => SARVAM_SPEAKER,
            'model'                => 'bulbul:v2',
        ], JSON_UNESCAPED_UNICODE),
    ]);
    ai_curl_ca($ch);

    $raw    = curl_exec($ch);
    $status = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($raw === false || $status >= 400) {
        error_log("Ithrive TTS: sarvam returned {$status}");

        return null;
    }

    $data  = json_decode((string) $raw, true);
    $audio = $data['audios'][0] ?? null;

    return is_string($audio) ? (base64_decode($audio, true) ?: null) : null;
}

// Sarvam first when configured, then an explicit endpoint, then the default.
if (SARVAM_API_KEY !== '') {
    $audio = '';
    foreach (tts_chunks($text, 450) as $chunk) {
        $part = tts_sarvam($chunk, $lang['bcp47']);
        if ($part === null) {
            break;
        }
        $audio .= $part;
    }

    if ($audio !== '') {
        header('Content-Type: audio/wav');
        header('Cache-Control: private, max-age=600');
        echo $audio;
        exit;
    }
    // Sarvam failed — fall through to the backend below rather than go silent.
}

$backend = TTS_ENDPOINT === '' ? 'google' : TTS_ENDPOINT;

if ($backend === 'google') {
    $audio = '';
    foreach (tts_chunks($text) as $chunk) {
        $part = tts_google($chunk, $lang['code']);
        if ($part === null) {
            break;
        }
        $audio .= $part;   // MP3 frames concatenate cleanly
    }

    if ($audio === '') {
        error_log('Ithrive TTS: google backend returned nothing for ' . $lang['code']);
        http_response_code(502);
        exit;
    }

    header('Content-Type: audio/mpeg');
    header('Cache-Control: private, max-age=600');
    echo $audio;
    exit;
}

// Custom service — the AI4Bharat Indic-TTS path.
$ch = curl_init($backend);
curl_setopt_array($ch, [
    CURLOPT_POST           => true,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT        => 25,
    CURLOPT_HTTPHEADER     => ['Content-Type: application/json'],
    CURLOPT_POSTFIELDS     => json_encode(['text' => $text, 'lang' => $lang['code']]),
]);
ai_curl_ca($ch);

$audio  = curl_exec($ch);
$status = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
$type   = (string) curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
curl_close($ch);

if ($audio === false || $status >= 400 || $audio === '') {
    error_log("Ithrive TTS: upstream returned {$status}");
    http_response_code(502);
    exit;
}

header('Content-Type: ' . ($type !== '' ? $type : 'audio/mpeg'));
header('Cache-Control: private, max-age=600');
echo $audio;
