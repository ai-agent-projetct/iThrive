<?php
/**
 * Text-to-speech proxy.
 *
 * Browsers only speak a language when a voice for it is installed, and Tamil,
 * Malayalam, Kannada and Telugu voices are missing on most desktops — so
 * in-browser speech cannot be relied on for them. When TTS_ENDPOINT is set,
 * the assistant posts here and we relay to that service.
 *
 * The endpoint is proxied rather than called from the browser so its URL and
 * any credentials stay server-side, and so the same rate limiting applies.
 *
 * Upstream contract: POST {"text": "...", "lang": "ta"} -> audio bytes.
 */

declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/config.php';
require_once dirname(__DIR__) . '/includes/ai.php';

header('X-Content-Type-Options: nosniff');

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
    http_response_code(405);
    exit;
}

if (TTS_ENDPOINT === '') {
    http_response_code(503);
    header('Content-Type: application/json');
    echo json_encode(['error' => 'tts_not_configured']);
    exit;
}

$body = json_decode(file_get_contents('php://input') ?: '', true);
$text = trim((string) ($body['text'] ?? ''));
$lang = assistant_language((string) ($body['lang'] ?? 'en'))['code'];

if ($text === '') {
    http_response_code(400);
    exit;
}

// Synthesis cost scales with length, and this is a public endpoint.
$text = mb_substr($text, 0, 1200);

// Same per-session budget as the chat endpoint, so voice cannot be used to
// bypass the limit that protects the model.
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

$ch = curl_init(TTS_ENDPOINT);
curl_setopt_array($ch, [
    CURLOPT_POST           => true,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT        => 25,
    CURLOPT_HTTPHEADER     => ['Content-Type: application/json'],
    CURLOPT_POSTFIELDS     => json_encode(['text' => $text, 'lang' => $lang]),
]);

$audio = curl_exec($ch);
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
