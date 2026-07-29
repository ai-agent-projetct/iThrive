<?php
/**
 * Drains the lead-reply drafting queue. Run from cron:
 *
 *   * / 5 * * * *  cd /path/to/site && php .tools/draft-replies.php
 *
 * Drafts are written to storage/replies/ for a human to review and send.
 * Nothing here emails anybody.
 */

declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}

// config.php derives BASE_URL from $_SERVER, which CLI does not populate.
$_SERVER['SCRIPT_NAME']     ??= '/index.php';
$_SERVER['SCRIPT_FILENAME'] ??= dirname(__DIR__) . '/index.php';

require_once dirname(__DIR__) . '/includes/ai-reply.php';

if (!ai_enabled()) {
    fwrite(STDERR, "AI layer unavailable: " . ai_unavailable_reason() . PHP_EOL);
    exit(1);
}

$limit  = (int) ($argv[1] ?? 10);
$result = ai_drain_reply_queue($limit > 0 ? $limit : 10);

printf(
    "drafted=%d failed=%d remaining=%d%s",
    $result['processed'],
    $result['failed'],
    $result['remaining'],
    PHP_EOL
);

exit($result['failed'] > 0 && $result['processed'] === 0 ? 1 : 0);
