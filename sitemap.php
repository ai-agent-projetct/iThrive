<?php
/**
 * XML sitemap, generated from the content layer so it can never drift out of
 * sync with the routes that actually exist.
 *
 * Served at /sitemap.xml via the rewrite in .htaccess.
 */

declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';

header('Content-Type: application/xml; charset=utf-8');

/** @var array<string, array{0: string, 1: string}> path => [changefreq, priority] */
$routes = [
    'index.php'            => ['weekly',  '1.0'],
    'services.php'         => ['monthly', '0.9'],
    // Listed by hand: this landing page has no entry in SERVICES, so the loop
    // over all_services() below never reaches it.
    'services/software-development.php'   => ['monthly', '0.9'],
    'services/ai-development-company.php' => ['monthly', '0.9'],
    'solutions.php'        => ['monthly', '0.9'],
    'case-studies.php'     => ['monthly', '0.9'],
    'company/about.php'    => ['yearly',  '0.7'],
    'company/process.php'  => ['yearly',  '0.7'],
    'company/careers.php'  => ['monthly', '0.6'],
    'faq.php'              => ['monthly', '0.8'],
    'blog.php'             => ['weekly',  '0.7'],
    'contact.php'          => ['yearly',  '0.8'],
];

foreach (all_services() as $svc) {
    $routes['services/' . $svc['slug'] . '.php'] = ['monthly', '0.8'];
}
foreach (AI_SOLUTIONS as $sol) {
    $routes['solutions/' . $sol['slug'] . '.php'] = ['monthly', '0.8'];
}
foreach (CASE_STUDIES as $study) {
    $routes['case-studies/' . $study['slug'] . '.php'] = ['monthly', '0.8'];
}

$today = gmdate('Y-m-d');

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

foreach ($routes as $path => [$freq, $priority]) {
    // Home canonicalises to the bare origin, matching the canonical tag.
    $loc = $path === 'index.php' ? site_origin() . url('') : canonical($path);
    echo "  <url>\n"
        . '    <loc>' . e(rtrim($loc, '/') . ($path === 'index.php' ? '/' : '')) . "</loc>\n"
        . '    <lastmod>' . $today . "</lastmod>\n"
        . '    <changefreq>' . $freq . "</changefreq>\n"
        . '    <priority>' . $priority . "</priority>\n"
        . "  </url>\n";
}

echo '</urlset>' . "\n";
