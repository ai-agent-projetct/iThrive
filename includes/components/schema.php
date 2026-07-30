<?php
/**
 * JSON-LD structured data.
 *
 * Every page emits Organization + WebSite (identified by a stable @id so other
 * nodes can reference them rather than repeat themselves) and a BreadcrumbList
 * derived from the URL. Pages that are a Service, an Article or a case study
 * add their own node by setting $schema before including the header.
 *
 * @var array|null $schema Extra page-specific node.
 */

declare(strict_types=1);

$origin = site_origin();
$orgId  = $origin . '/#organization';
$graph  = [];

$graph[] = [
    '@type'       => 'Organization',
    '@id'         => $orgId,
    'name'        => SITE_NAME,
    'alternateName' => SITE_SHORT,
    'url'         => $origin . url('index.php'),
    'description' => SITE_TAGLINE,
    'email'       => SITE_EMAIL,
    'telephone'   => SITE_PHONE,
    'logo'        => [
        '@type' => 'ImageObject',
        'url'   => $origin . asset('assets/img/logo-mark.svg'),
    ],
    'address'     => [
        '@type'          => 'PostalAddress',
        'addressLocality'=> 'Coimbatore',
        'addressRegion'  => 'Tamil Nadu',
        'addressCountry' => 'IN',
    ],
    'knowsAbout'  => [
        'Artificial Intelligence', 'Agentic AI', 'Python development',
        'Machine learning engineering', 'Cloud architecture',
        'Mobile app development', 'Enterprise resource planning',
    ],
];

$graph[] = [
    '@type'     => 'WebSite',
    '@id'       => $origin . '/#website',
    'url'       => $origin . url('index.php'),
    'name'      => SITE_NAME,
    'publisher' => ['@id' => $orgId],
    'inLanguage'=> 'en',
];

// Breadcrumbs, built from the request path so every page gets them for free.
$path  = trim(preg_replace('#/index\.php$#', '', strtok((string) ($_SERVER['REQUEST_URI'] ?? ''), '?') ?: ''), '/');
$parts = array_values(array_filter(explode('/', $path)));

if ($parts !== []) {
    $items = [[
        '@type'    => 'ListItem',
        'position' => 1,
        'name'     => 'Home',
        'item'     => $origin . url('index.php'),
    ]];

    $trail = '';
    foreach ($parts as $i => $part) {
        $trail .= '/' . $part;
        $label  = ucwords(str_replace('-', ' ', preg_replace('/\.php$/', '', $part) ?? $part));
        $items[] = [
            '@type'    => 'ListItem',
            'position' => $i + 2,
            'name'     => $label,
            'item'     => $origin . $trail,
        ];
    }

    $graph[] = ['@type' => 'BreadcrumbList', 'itemListElement' => $items];
}

if (!empty($schema)) {
    // Page-specific nodes always belong to this organisation.
    $schema['provider'] ??= ['@id' => $orgId];
    $graph[] = $schema;
}

echo json_ld(['@context' => 'https://schema.org', '@graph' => $graph]);
