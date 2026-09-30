<?php
/**
 * Check the .htaccess denial list blocks what it must and nothing else.
 *
 * These two RedirectMatch lines are the site's real access control — Apache
 * sits behind the nginx proxy in production and reads them — so a careless edit
 * is a data leak or an outage. Dropping the trailing slash from the directory
 * pattern would 404 every URL beginning "app", including /application-...;
 * forgetting a directory leaves its source on public display, which is how
 * app/mobile/src/App.jsx came to be readable.
 *
 * Apache and PHP both use PCRE, so the patterns are read straight out of the
 * file and tested as written rather than copied here to drift apart.
 *
 *   php tools/htaccess-denylist-check.php
 */

declare(strict_types=1);

$htaccess = dirname(__DIR__) . '/.htaccess';
$rules    = [];

foreach (file($htaccess, FILE_IGNORE_NEW_LINES) ?: [] as $line) {
    if (preg_match('/^\s*RedirectMatch\s+404\s+(\S+)\s*$/', $line, $m) === 1) {
        $rules[] = $m[1];
    }
}

if ($rules === []) {
    exit("No RedirectMatch 404 rules found in .htaccess — did the file move?\n");
}

printf("%d denial rules\n\n", count($rules));

/** Would Apache 404 this path? */
$denied = static function (string $path) use ($rules): bool {
    foreach ($rules as $rule) {
        if (preg_match('#' . $rule . '#', $path) === 1) {
            return true;
        }
    }

    return false;
};

/* Must be refused: sources, dependencies, visitor data, repository metadata. */
$mustDeny = [
    '/app/mobile/src/App.jsx',
    '/app/originkit/src/embed.jsx',
    '/storage/enquiries.ndjson',
    '/storage/cache/translations/ta/00/abc.txt',
    '/includes/secrets.php',
    '/includes/config.php',
    '/vendor/autoload.php',
    '/docs/image-prompts.md',
    '/graphify-out/graph.json',
    '/.tools/serve.mjs',
    '/.github/workflows/deploy.yml',
    '/composer.json',
    '/composer.lock',
    '/README.md',
    '/package.json',
    '/package-lock.json',
];

/* Must still be served. The near-misses matter most: a pattern without its
   trailing slash swallows every one of the first four. */
$mustServe = [
    '/apps/',
    '/application-development.php',
    '/appointment',
    '/storages/x.php',
    '/includes-of-interest.php',
    '/docs.php',
    '/',
    '/index.php',
    '/faq.php',
    '/contact.php',
    '/services/cloud-devops.php',
    '/services/mobile-app-development.php',
    '/locations/chennai.php',
    '/handlers/chat.php',
    '/assets/dist/mobile/mobile-app.js',
    '/assets/css/style.css',
    '/videos/taxi_ai.mp4',
    '/robots.txt',
    '/sitemap.xml',
];

$failed = 0;

foreach ($mustDeny as $path) {
    if (!$denied($path)) {
        printf("  LEAK    %s is served and must not be\n", $path);
        $failed++;
    }
}

foreach ($mustServe as $path) {
    if ($denied($path)) {
        printf("  BROKEN  %s is refused and must not be\n", $path);
        $failed++;
    }
}

printf("%d paths checked, %d wrong\n", count($mustDeny) + count($mustServe), $failed);

exit($failed === 0 ? 0 : 1);
