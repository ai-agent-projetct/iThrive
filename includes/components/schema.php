<?php
/**
 * JSON-LD structured data.
 *
 * Every page emits Organization + WebSite (identified by a stable @id so other
 * nodes can reference them rather than repeat themselves) and a BreadcrumbList
 * derived from the URL. Pages that are a Service, an Article or a case study
 * add their own node by setting $schema before including the header.
 *
 * @var array|null  $schema      Extra page-specific node, or a document with an @graph.
 * @var array|null  $schemaExtra Further nodes, added as they are.
 * @var string|null $pageTitle   Plain page title, for the last breadcrumb.
 * @var string|null $metaTitle   The <title>, for the WebPage node.
 * @var string|null $metaDesc    The meta description.
 * @var string|null $metaUrl     The canonical URL.
 * @var string|null $ogAbs       The share image, absolute.
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
    'url'         => $origin . url(''),
    'description' => SITE_TAGLINE,
    'email'       => SITE_EMAIL,
    // Omitted entirely while SITE_PHONE is the placeholder — see site_phone().
    ...(site_phone() !== null ? ['telephone' => site_phone()] : []),
    'logo'        => [
        '@type'  => 'ImageObject',
        // The mark the site actually renders. This pointed at the old SVG
        // approximation, so every consumer of the feed had the wrong logo.
        'url'    => $origin . asset('assets/img/logo-mark.png'),
        'width'  => 512,
        'height' => 512,
    ],
    'address'     => office_postal_address(office('chennai')),
    // Six offices. `address` only takes one, so all of them are listed here —
    // an assistant asked "where is iThrive based" reads this, not the prose,
    // and now gets a street and a postcode rather than a city name.
    'location'    => array_map(
        static fn (array $office): array => [
            '@type'   => 'Place',
            'name'    => SITE_NAME . ' — ' . $office['city'],
            'address' => office_postal_address($office),
        ],
        array_values(OFFICES),
    ),
    // The markets served, as Place nodes rather than the word "Worldwide" —
    // a query with a country or city in it has something to match against.
    'areaServed'   => areas_served(),
    'contactPoint' => [
        '@type'             => 'ContactPoint',
        'contactType'       => 'sales',
        'email'             => SITE_EMAIL,
        ...(site_phone() !== null ? ['telephone' => site_phone()] : []),
        'areaServed'        => 'Worldwide',
        'availableLanguage' => ['en', 'ta', 'ml', 'kn', 'te', 'hi'],
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
    'url'       => $origin . url(''),
    'name'      => SITE_NAME,
    'description' => SITE_TAGLINE,
    'publisher' => ['@id' => $orgId],
    'inLanguage'=> 'en-IN',
];

// Breadcrumbs, built from the canonical path so every page gets them for free.
// A crumb has to be a page someone can land on: /services resolves to
// services.php, but /company and /locations are bare folders, so those levels
// are skipped rather than handed to Google as links that 403.
$pageUrl = $metaUrl ?? canonical();
$path    = trim((string) parse_url($pageUrl, PHP_URL_PATH), '/');
$base    = trim(BASE_URL, '/');
if ($base !== '' && str_starts_with($path, $base)) {
    $path = trim(substr($path, strlen($base)), '/');
}
$parts = array_values(array_filter(explode('/', $path)));
$crumbId = $pageUrl . '#breadcrumb';
$hasCrumbs = false;

if ($parts !== []) {
    $items = [['name' => 'Home', 'item' => $origin . url('')]];

    foreach ($parts as $i => $part) {
        $slug = preg_replace('/\.php$/', '', $part) ?? $part;
        if ($i === count($parts) - 1) {
            // The page's own title, not its slug: "AI Consulting Services",
            // where ucwords() on the slug produced "Ai Consulting".
            $items[] = ['name' => trim($pageTitle ?? '') ?: ucwords(str_replace('-', ' ', $slug)), 'item' => $pageUrl];
        } elseif (is_file(ROOT_PATH . '/' . ($rel = implode('/', array_slice($parts, 0, $i + 1)) . '.php'))) {
            $items[] = ['name' => ucwords(str_replace('-', ' ', $slug)), 'item' => canonical($rel)];
        }
    }

    $graph[] = [
        '@type'           => 'BreadcrumbList',
        '@id'             => $crumbId,
        'itemListElement' => array_map(
            static fn (array $item, int $i): array => ['@type' => 'ListItem', 'position' => $i + 1] + $item,
            $items,
            array_keys($items),
        ),
    ];
    $hasCrumbs = true;
}

// The page's own nodes. Most pages hand over one node; the AI service pages
// hand over a whole document — @context plus an @graph of Service and FAQPage.
// Appended as it was, that document became a single untyped node nested inside
// this graph, and the Service and FAQ on sixteen pages were invisible.
$pageNodes = [];
if (!empty($schema) && is_array($schema)) {
    $pageNodes = isset($schema['@graph']) && is_array($schema['@graph']) ? $schema['@graph'] : [$schema];
}

$mainId = null;
foreach ($pageNodes as $node) {
    if (!is_array($node) || empty($node['@type'])) {
        continue;
    }
    unset($node['@context']);
    if (!in_array($node['@type'], ['FAQPage', 'BreadcrumbList', 'HowTo', 'ItemList'], true)) {
        // Page-specific nodes always belong to this organisation — by
        // reference, rather than as a second, thinner copy of it.
        if (in_array($node['@type'], ['ProfessionalService', 'LocalBusiness'], true)) {
            // A studio is a business in its own right, so it belongs to the
            // organisation as a branch; `provider` is not a property it has.
            $node['parentOrganization'] ??= ['@id' => $orgId];
        } elseif (!isset($node['provider']) || ($node['provider']['name'] ?? null) === SITE_NAME) {
            $node['provider'] = ['@id' => $orgId];
        }
        if (($node['author']['name'] ?? null) === SITE_NAME) {
            $node['author'] = ['@id' => $orgId];
        }
        if ($node['@type'] === 'Article') {
            $node['publisher'] ??= ['@id' => $orgId];
            $node['image']     ??= $ogAbs ?? null;
            $node['mainEntityOfPage'] ??= $pageUrl;
        }
        $node['@id'] ??= $pageUrl . '#' . strtolower((string) $node['@type']);
        $mainId ??= $node['@id'];
    }
    $graph[] = $node;
}

// A page may declare further nodes that are not services and so must not be
// given a provider — a HowTo, an FAQPage, a LocalBusiness per city. The web
// development page is the first to need more than one.
if (!empty($schemaExtra) && is_array($schemaExtra)) {
    foreach ($schemaExtra as $node) {
        if (is_array($node) && !empty($node['@type'])) {
            $graph[] = $node;
        }
    }
}

// The page itself. This is what ties everything above together: which site it
// belongs to, who it is about, what it mainly describes and where it sits in
// the breadcrumb trail — the connections an answer engine follows when it
// decides whose words to quote.
$graph[] = array_filter([
    '@type'              => 'WebPage',
    '@id'                => $pageUrl . '#webpage',
    'url'                => $pageUrl,
    'name'               => $metaTitle ?? SITE_NAME,
    'description'        => $metaDesc ?? SITE_TAGLINE,
    'inLanguage'         => 'en-IN',
    'isPartOf'           => ['@id' => $origin . '/#website'],
    'about'              => ['@id' => $orgId],
    'publisher'          => ['@id' => $orgId],
    'mainEntity'         => $mainId !== null ? ['@id' => $mainId] : null,
    'breadcrumb'         => $hasCrumbs ? ['@id' => $crumbId] : null,
    'primaryImageOfPage' => !empty($ogAbs) ? [
        '@type' => 'ImageObject', 'url' => $ogAbs, 'width' => 1200, 'height' => 630,
    ] : null,
    // The headline and the lead paragraph — the two lines that answer "what is
    // this page" — marked as the parts a voice assistant should read out.
    'speakable'          => [
        '@type'       => 'SpeakableSpecification',
        'cssSelector' => ['h1', '.hero-lead', '.svc-lead', '.page-lead'],
    ],
], static fn ($v): bool => $v !== null);

echo json_ld(['@context' => 'https://schema.org', '@graph' => $graph]);
