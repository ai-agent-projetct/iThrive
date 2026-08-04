<?php
/**
 * Copy this file to includes/secrets.php and fill in a key.
 *
 * secrets.php is git-ignored. Prefer setting the key in the server environment
 * instead — it takes precedence over this file and keeps the key off disk.
 *
 * Either key makes the assistant think. Anthropic is used when both are set:
 * it is the stronger model and the only one wired to the lead-capture tools.
 * Gemini has a free tier, so it is the quickest way to a working assistant with
 * no billing account — ai.google.dev/gemini-api/docs/api-key.
 */

declare(strict_types=1);

return [
    'anthropic_api_key' => '',   // sk-ant-...
    'gemini_api_key'    => '',   // AIza...
];
