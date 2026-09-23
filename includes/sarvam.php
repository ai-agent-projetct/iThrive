<?php
/**
 * Sarvam AI — the language layer for the assistant.
 *
 * The site already used Sarvam for one thing: speaking an answer aloud in the
 * five Indic languages, because browsers have no voices for them. It was doing
 * nothing about the harder half of the problem, which is that the answers were
 * only ever written in English. A Tamil visitor got a Tamil sentence that said
 * "here is iThrive's official answer" followed by an English paragraph.
 *
 * Sarvam is the right tool for both halves. Three of its endpoints are used:
 *
 *   /translate    both directions. The question is translated INTO English so
 *                 it can be matched against a corpus indexed in English, and
 *                 the answer is translated OUT of English into the visitor's
 *                 language. Source detection is automatic, which matters
 *                 because people type Tamil in Latin script as often as not.
 *
 *   /text-lid     language identification, used when the visitor has not
 *                 chosen a language in the UI and we have to infer it.
 *
 *   /v1/chat/completions
 *                 sarvam-105b-conversations, used to phrase a grounded answer
 *                 conversationally rather than reciting the stored one. Strictly
 *                 optional: the retrieved answer is returned as-is when the
 *                 model is unavailable, so this never becomes a dependency.
 *
 * TRANSLATION IS CACHED ON DISK, and that is what makes this affordable. The
 * answers are static text: a given answer in Tamil is the same today as
 * tomorrow, so it is translated once and read from disk forever after. Only a
 * question the site has never been asked in that language costs an API call.
 */

declare(strict_types=1);

/** Sarvam's language codes, from the short codes the assistant uses. */
const SARVAM_LANGS = [
    'en' => 'en-IN',
    'ta' => 'ta-IN',
    'ml' => 'ml-IN',
    'kn' => 'kn-IN',
    'te' => 'te-IN',
    'hi' => 'hi-IN',
];

/** The conversational model. sarvam-m was deprecated; 105b reasons but is slow. */
const SARVAM_CHAT_MODEL = 'sarvam-105b-conversations';

/** True when a key is configured and curl exists to use it. */
function sarvam_enabled(): bool
{
    return SARVAM_API_KEY !== '' && function_exists('curl_init');
}

/** Short code to Sarvam's code, defaulting to English. */
function sarvam_lang(string $code): string
{
    return SARVAM_LANGS[$code] ?? 'en-IN';
}

/** Sarvam's code back to the short code the assistant uses. */
function sarvam_short_lang(string $code): string
{
    $short = strtolower(substr($code, 0, 2));

    return isset(SARVAM_LANGS[$short]) ? $short : 'en';
}

/**
 * One POST to Sarvam. Returns the decoded body, or null on any failure.
 *
 * Never throws and never surfaces an error to the visitor: every caller has a
 * working answer already and is only trying to improve it, so a failure here
 * degrades the reply rather than breaking it.
 */
function sarvam_post(string $url, array $body, int $timeout = 20): ?array
{
    if (!sarvam_enabled()) {
        return null;
    }

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_POST           => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT        => $timeout,
        CURLOPT_HTTPHEADER     => [
            'Content-Type: application/json',
            'api-subscription-key: ' . SARVAM_API_KEY,
        ],
        CURLOPT_POSTFIELDS     => json_encode($body, JSON_UNESCAPED_UNICODE),
    ]);
    curl_ca_bundle($ch);

    $raw    = curl_exec($ch);
    $status = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $err    = curl_error($ch);
    curl_close($ch);

    if ($raw === false || $status >= 400) {
        error_log(sprintf(
            'iThrive Sarvam: %s returned %d %s %s',
            basename($url),
            $status,
            $err,
            is_string($raw) ? mb_substr($raw, 0, 200) : ''
        ));

        return null;
    }

    $data = json_decode((string) $raw, true);

    return is_array($data) ? $data : null;
}

/** Which language a piece of text is in, as a short code, or null. */
function sarvam_detect(string $text): ?string
{
    $text = trim($text);
    if ($text === '') {
        return null;
    }

    /* Script is decisive and free. Only Latin text is genuinely ambiguous —
       it may be English, or any of the five typed phonetically — so only that
       case is worth an API call. */
    $byScript = [
        'ta' => '/\p{Tamil}/u',
        'ml' => '/\p{Malayalam}/u',
        'kn' => '/\p{Kannada}/u',
        'te' => '/\p{Telugu}/u',
        'hi' => '/\p{Devanagari}/u',
    ];

    foreach ($byScript as $code => $pattern) {
        if (preg_match($pattern, $text)) {
            return $code;
        }
    }

    $data = sarvam_post('https://api.sarvam.ai/text-lid', ['input' => $text], 10);
    $code = $data['language_code'] ?? null;

    return is_string($code) ? sarvam_short_lang($code) : null;
}

/** Where a translation is kept once it has been paid for. */
function sarvam_cache_path(string $text, string $to, string $from): string
{
    $key = hash('sha256', $from . '>' . $to . '|' . $text);

    return STORAGE_PATH . '/cache/translations/' . $to . '/' . substr($key, 0, 2) . '/' . $key . '.txt';
}

/**
 * Split text for the translator, on sentence boundaries where possible.
 *
 * The translate endpoint takes roughly a thousand characters. Several answers
 * in the corpus are longer, and cutting one mid-sentence produces a translation
 * that reads as though it was cut mid-sentence.
 *
 * @return array<int, string>
 */
function sarvam_chunks(string $text, int $limit = 900): array
{
    if (mb_strlen($text) <= $limit) {
        return [$text];
    }

    $sentences = preg_split('/(?<=[.!?])\s+/u', $text, -1, PREG_SPLIT_NO_EMPTY) ?: [$text];
    $chunks    = [];
    $current   = '';

    foreach ($sentences as $s) {
        if ($current !== '' && mb_strlen($current . ' ' . $s) > $limit) {
            $chunks[] = $current;
            $current  = $s;

            continue;
        }
        $current = $current === '' ? $s : $current . ' ' . $s;
    }

    if ($current !== '') {
        $chunks[] = $current;
    }

    // A single sentence longer than the limit still has to go somewhere.
    $out = [];
    foreach ($chunks as $c) {
        if (mb_strlen($c) <= $limit) {
            $out[] = $c;

            continue;
        }
        foreach (str_split($c, $limit) as $part) {
            $out[] = $part;
        }
    }

    return $out;
}

/**
 * Translate text, reading from disk when we have translated it before.
 *
 * Returns null rather than the original on failure, so a caller can tell the
 * difference between "translated" and "could not translate" and decide what to
 * show. Passing the same language in and out is a no-op.
 */
function sarvam_translate(string $text, string $to, string $from = 'auto', bool $cacheOnly = false): ?string
{
    $text = trim($text);
    if ($text === '' || $to === $from) {
        return $text;
    }

    if (!isset(SARVAM_LANGS[$to])) {
        return null;
    }

    $cache = sarvam_cache_path($text, $to, $from);
    if (is_file($cache)) {
        $hit = file_get_contents($cache);
        if (is_string($hit) && $hit !== '') {
            return $hit;
        }
    }

    // Secondary text — a related question, a label — is worth showing
    // translated when we already have it and is not worth making the visitor
    // wait on a network call for. Warm the cache with tools/warm-translations.php
    // and these stop being misses.
    if ($cacheOnly || !sarvam_enabled()) {
        return null;
    }

    $parts = [];
    foreach (sarvam_chunks($text) as $chunk) {
        $data = sarvam_post('https://api.sarvam.ai/translate', [
            'input'                => $chunk,
            'source_language_code' => $from === 'auto' ? 'auto' : sarvam_lang($from),
            'target_language_code' => sarvam_lang($to),
            'mode'                 => 'formal',
            'model'                => 'mayura:v1',
        ], 25);

        $piece = $data['translated_text'] ?? null;
        if (!is_string($piece) || $piece === '') {
            return null;            // a partial translation is worse than none
        }
        $parts[] = $piece;
    }

    $result = implode(' ', $parts);

    if (!is_dir(dirname($cache))) {
        @mkdir(dirname($cache), 0775, true);
    }
    if (is_dir(dirname($cache))) {
        @file_put_contents($cache, $result);
    }

    return $result;
}

/**
 * Translate many texts at once, in parallel.
 *
 * One at a time the translator costs about 1.1 seconds per call, which is
 * fine for a visitor waiting on one answer and hopeless for warming nine
 * thousand. Eight in flight at once costs about 0.13 seconds each and Sarvam
 * accepts it without complaint, so the whole corpus becomes twenty minutes
 * rather than three hours.
 *
 * Cache is consulted first and written after, exactly as the single-text path
 * does, so the two are interchangeable and a half-finished run resumes.
 *
 * @param  array<int, string> $texts
 * @return array<string, string|null>  keyed by the original text
 */
function sarvam_translate_many(array $texts, string $to, string $from = 'en', int $concurrency = 8): array
{
    $out = [];
    $todo = [];                    // flat list of chunks still to fetch

    foreach (array_unique($texts) as $text) {
        $text = trim($text);
        if ($text === '' || $to === $from || !isset(SARVAM_LANGS[$to])) {
            $out[$text] = $text === '' ? '' : null;

            continue;
        }

        $cache = sarvam_cache_path($text, $to, $from);
        if (is_file($cache)) {
            $hit = file_get_contents($cache);
            if (is_string($hit) && $hit !== '') {
                $out[$text] = $hit;

                continue;
            }
        }

        $out[$text] = null;        // pending until its chunks come back

        foreach (sarvam_chunks($text) as $n => $chunk) {
            $todo[] = ['text' => $text, 'n' => $n, 'chunk' => $chunk];
        }
    }

    if ($todo === [] || !sarvam_enabled()) {
        return $out;
    }

    $pieces  = [];                 // text => [chunk index => translation]
    $pending = array_chunk($todo, max(1, $concurrency));
    $retries = 0;

    while (($batch = array_shift($pending)) !== null) {
        $mh      = curl_multi_init();
        $handles = [];

        foreach ($batch as $i => $job) {
            $ch = curl_init('https://api.sarvam.ai/translate');
            curl_setopt_array($ch, [
                CURLOPT_POST           => true,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT        => 40,
                CURLOPT_CONNECTTIMEOUT => 15,
                /*
                 * A fresh connection per request, and no keep-alive left behind.
                 *
                 * Without these the first burst of eight succeeds and the second
                 * hangs indefinitely — not slow, stopped, with the handles
                 * reporting "still running" and no bytes ever arriving. The
                 * cause is outside libcurl: a TLS-inspecting proxy (antivirus on
                 * a developer machine, a corporate gateway) accepts the reused
                 * connection and then never speaks on it. Paying for a new
                 * handshake each time costs a few milliseconds and removes a
                 * failure that costs everything.
                 */
                CURLOPT_FRESH_CONNECT  => true,
                CURLOPT_HTTPHEADER     => [
                    'Content-Type: application/json',
                    'api-subscription-key: ' . SARVAM_API_KEY,
                ],
                CURLOPT_POSTFIELDS     => json_encode([
                    'input'                => $job['chunk'],
                    'source_language_code' => $from === 'auto' ? 'auto' : sarvam_lang($from),
                    'target_language_code' => sarvam_lang($to),
                    'mode'                 => 'formal',
                    'model'                => 'mayura:v1',
                ], JSON_UNESCAPED_UNICODE),
            ]);
            curl_ca_bundle($ch);
            curl_multi_add_handle($mh, $ch);
            $handles[$i] = $ch;
        }

        /* A wall clock as well as libcurl's own timeouts. If the pool wedges —
           and it can, for the reason above — the batch is abandoned and its
           texts are simply left uncached for the next run to pick up, rather
           than stopping the job forever. */
        $deadline = microtime(true) + 75.0;

        do {
            $status = curl_multi_exec($mh, $running);
            if ($running) {
                curl_multi_select($mh, 0.5);
            }
        } while ($running && $status === CURLM_OK && microtime(true) < $deadline);

        $throttled = [];

        foreach ($handles as $i => $ch) {
            $raw  = curl_multi_getcontent($ch);
            $code = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_multi_remove_handle($mh, $ch);
            curl_close($ch);

            /* 429 is not a failure, it is "slow down". Sarvam throttles a
               sustained eight-wide burst after a few hundred calls; dropping
               those texts would leave permanent holes in the cache for no
               reason other than impatience. Re-queue and wait. */
            if ($code === 429) {
                $throttled[] = $batch[$i];

                continue;
            }

            if ($code !== 200 || !is_string($raw)) {
                /* Record WHY, once. A batch that silently reports "failed" sent
                   a long job chasing connection theories when the API was
                   plainly answering "No credits available" every time. */
                $why = 'HTTP ' . $code;
                if (is_string($raw) && $raw !== '') {
                    $decoded = json_decode($raw, true);
                    $why .= ': ' . (string) ($decoded['error']['message'] ?? mb_substr($raw, 0, 120));
                    $reason = (string) ($decoded['error']['code'] ?? '');
                    if ($reason !== '') {
                        $GLOBALS['sarvam_last_error_code'] = $reason;
                    }
                }
                $GLOBALS['sarvam_last_error'] = $why;

                continue;
            }

            $data  = json_decode($raw, true);
            $piece = $data['translated_text'] ?? null;
            if (is_string($piece) && $piece !== '') {
                $pieces[$batch[$i]['text']][$batch[$i]['n']] = $piece;
            }
        }

        curl_multi_close($mh);

        if ($throttled !== []) {
            /* Back off, then retry in halves — a narrower burst is what the
               limiter is asking for. Capped so a genuinely exhausted quota
               cannot loop here forever; those texts stay uncached and the next
               run picks them up. */
            if ($retries < 40) {
                $retries++;
                sleep(min(8, 1 + intdiv($retries, 4)));

                $half = max(1, (int) ceil(count($throttled) / 2));
                foreach (array_chunk($throttled, $half) as $part) {
                    array_unshift($pending, $part);
                }
            } else {
                $GLOBALS['sarvam_last_error'] = 'HTTP 429: rate limited repeatedly, gave up on ' . count($throttled) . ' chunks';
            }
        }
    }

    // Reassemble, and only accept a text whose every chunk came back.
    foreach ($pieces as $text => $parts) {
        $expected = count(sarvam_chunks($text));
        if (count($parts) !== $expected) {
            continue;              // a partial translation is worse than none
        }

        ksort($parts);
        $joined = implode(' ', $parts);
        $out[$text] = $joined;

        $cache = sarvam_cache_path($text, $to, $from);
        if (!is_dir(dirname($cache))) {
            @mkdir(dirname($cache), 0775, true);
        }
        if (is_dir(dirname($cache))) {
            @file_put_contents($cache, $joined);
        }
    }

    return $out;
}

/**
 * Translate a visitor's question into English for matching.
 *
 * Two mechanisms, in order of reliability. Sarvam reads a whole sentence and
 * returns a real English question, which is what the corpus is indexed on.
 * Where it is unavailable the existing FAQ_LEXICON still folds Indic vocabulary
 * onto English terms — cruder, but it has been answering questions for months
 * and there is no reason to throw it away.
 *
 * @return array{text: string, lang: string, via: string}
 */
function sarvam_question_to_english(string $question, string $declared = 'en'): array
{
    $lang = $declared;

    if ($lang === 'en') {
        // The visitor may have left the picker on English and typed Tamil.
        $detected = sarvam_detect($question);
        if ($detected !== null) {
            $lang = $detected;
        }
    }

    if ($lang === 'en') {
        return ['text' => $question, 'lang' => 'en', 'via' => 'none'];
    }

    $english = sarvam_translate($question, 'en', 'auto');
    if ($english !== null && $english !== '') {
        return ['text' => $english, 'lang' => $lang, 'via' => 'sarvam'];
    }

    return [
        'text' => function_exists('faq_normalise') ? faq_normalise($question) : $question,
        'lang' => $lang,
        'via'  => 'lexicon',
    ];
}

/**
 * Ask the conversational model, grounded in supplied context.
 *
 * Used to phrase an answer rather than to find one: the context is always the
 * text we retrieved, and the instruction is to answer from it alone. That is
 * the difference between a model that can be wrong about iThrive and one that
 * can only be wrong about wording.
 */
function sarvam_chat(array $messages, int $maxTokens = 400, float $temperature = 0.2): ?string
{
    $data = sarvam_post('https://api.sarvam.ai/v1/chat/completions', [
        'model'       => SARVAM_CHAT_MODEL,
        'messages'    => $messages,
        'max_tokens'  => $maxTokens,
        'temperature' => $temperature,
    ], 30);

    $text = $data['choices'][0]['message']['content'] ?? null;

    return (is_string($text) && trim($text) !== '') ? trim($text) : null;
}
