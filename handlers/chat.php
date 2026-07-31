<?php
/**
 * Ithrive AIChat — JSON endpoint behind the site chat widget.
 *
 * POST { "message": "..." }  ->  { "reply": "...", "state": "...", "captured": bool }
 *
 * Conversation history lives in the PHP session, so the client sends only the
 * new message and cannot forge earlier turns or inject a system prompt.
 */

declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/config.php';
require_once dirname(__DIR__) . '/includes/ai.php';
require_once dirname(__DIR__) . '/includes/ai-local.php';

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');
header('X-Content-Type-Options: nosniff');

/** Emit a JSON response and stop. */
$send = static function (array $payload, int $status = 200): never {
    http_response_code($status);
    echo json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    exit;
};

/**
 * What we say when the model is unavailable, refuses, or errors. Written so a
 * visitor still gets somewhere useful rather than a dead widget.
 */
$fallback = static function (string $reason): string {
    return match ($reason) {
        'rate_limited' => 'You are sending messages faster than I can answer. Give me a few seconds — or email '
            . SITE_EMAIL . ' and a person will pick it up.',
        'session_full' => 'We have covered a lot here. To take it further, email ' . SITE_EMAIL
            . ' or use the Start Your Project form — a senior engineer reads every brief.',
        'refused'      => 'I am not able to help with that one. If it is about a project, email ' . SITE_EMAIL
            . ' and a person will take a look.',
        default        => 'I cannot reach my assistant service right now. You can browse our services and case studies '
            . 'from the menu, or email ' . SITE_EMAIL . ' — we reply within two working days.',
    };
};

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
    $send(['error' => 'method_not_allowed'], 405);
}

// ---- Input -----------------------------------------------------------------

$raw = file_get_contents('php://input') ?: '';
$body = json_decode($raw, true);

if (!is_array($body)) {
    $send(['error' => 'bad_request'], 400);
}

$message = trim((string) ($body['message'] ?? ''));

// Language is chosen in the UI; anything unrecognised falls back to English.
$lang = assistant_language((string) ($body['lang'] ?? 'en'))['code'];

if ($message === '') {
    $send(['error' => 'empty_message'], 400);
}

if (mb_strlen($message) > AI_MAX_MESSAGE_CHARS) {
    $message = mb_substr($message, 0, AI_MAX_MESSAGE_CHARS);
}

// ---- Rate limiting ---------------------------------------------------------

$now = time();
$_SESSION['chat_hits'] = array_values(array_filter(
    $_SESSION['chat_hits'] ?? [],
    static fn (int $t): bool => $t > $now - AI_RATE_WINDOW_SECONDS
));

if (count($_SESSION['chat_hits']) >= AI_RATE_MAX_PER_WINDOW) {
    $send(['reply' => $fallback('rate_limited'), 'state' => 'rate_limited', 'captured' => false]);
}

$_SESSION['chat_hits'][] = $now;

/** @var array<int, array{role: string, content: string}> $history */
$history = $_SESSION['chat_history'] ?? [];

if (count($history) / 2 >= AI_MAX_SESSION_TURNS) {
    $send(['reply' => $fallback('session_full'), 'state' => 'session_full', 'captured' => false]);
}

// ---- Build the request -----------------------------------------------------

$history[] = ['role' => 'user', 'content' => $message];

// Only the most recent turns are replayed; the system prompt carries the rest.
$window = array_slice($history, -(AI_MAX_HISTORY_TURNS * 2));

$result = ai_run($window, ai_chat_system($lang), 'low', 4000);

if ($result['error'] !== null || $result['text'] === '') {
    if ($result['error'] !== null && $result['error'] !== 'refused') {
        error_log('Ithrive AIChat unavailable: ' . $result['error'] . ' (' . ai_unavailable_reason() . ')');
    }

    // No model available — answer from site content instead of giving up. The
    // visitor still gets a real answer about Ithrive; only the phrasing is
    // canned rather than generated.
    if ($result['error'] !== 'refused') {
        // The seventy-question answer book first — it is the authoritative
        // source and covers pricing and timelines the site pages do not. Site
        // content second, for contact details and the like. Anything else gets
        // the demo boundary, which is the whole point of the demo.
        $faq   = faq_answer($message, $lang);
        $state = 'faq';

        if ($faq['matched']) {
            $reply = $faq['text'];
        } else {
            $local = ai_local_answer($message, $lang);
            $reply = $local['matched'] ? $local['text'] : faq_demo_reply($lang);
            $state = $local['matched'] ? 'local' : 'demo_boundary';
        }

        $history[] = ['role' => 'assistant', 'content' => $reply];
        $_SESSION['chat_history'] = array_slice($history, -(AI_MAX_HISTORY_TURNS * 2));

        $send([
            'reply'    => $reply,
            'state'    => $state,
            'faq'      => $faq['id'],
            'lang'     => $lang,
            'captured' => false,
        ]);
    }

    // The failed turn is not kept — the next message starts from clean history.
    $send([
        'reply'    => $fallback($result['error'] ?? 'unavailable'),
        'state'    => 'fallback',
        'captured' => false,
    ]);
}

$history[] = ['role' => 'assistant', 'content' => $result['text']];
$_SESSION['chat_history'] = array_slice($history, -(AI_MAX_HISTORY_TURNS * 2));

// ---- Log the exchange ------------------------------------------------------

ai_append_storage('conversations.ndjson', [
    'session_id'  => session_id(),
    'at'          => gmdate('c'),
    'visitor'     => $message,
    'assistant'   => $result['text'],
    'tool_rounds' => $result['iterations'],
    'usage'       => $result['usage'],
    'captured'    => isset($result['side']['lead']),
    'escalated'   => isset($result['side']['escalation']),
]);

$send([
    'reply'     => $result['text'],
    'state'     => 'ok',
    'captured'  => isset($result['side']['lead']),
    'escalated' => isset($result['side']['escalation']),
]);
