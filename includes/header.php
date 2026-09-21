<?php
/**
 * @var string      $page       Current nav slug — matches a key of NAV_ITEMS.
 * @var string      $pageTitle  <title> text.
 * @var string      $pageDesc   Meta description.
 * @var string|null $heroScene  3D hero preset: neural | mesh | orbit | null.
 */

declare(strict_types=1);

require_once __DIR__ . '/config.php';

$page      = $page      ?? 'home';
$bodyClass = $bodyClass ?? null;
$pageTitle = $pageTitle ?? SITE_NAME;
$pageDesc  = $pageDesc  ?? SITE_TAGLINE;
$heroScene = $heroScene ?? null;

/**
 * Pages set a plain, human title; the SERP-length trimming happens here so no
 * individual page has to remember the 60/160 character budgets.
 */
$metaTitle = seo_title($pageTitle);
$metaDesc  = seo_description($pageDesc);
$metaUrl   = canonical();

/** Per-page share image, falling back to the site-wide one. */
$ogSlug  = $ogImage ?? ($page === 'home' ? 'default' : $page);
$ogFile  = 'assets/img/og/' . $ogSlug . '.png';
$ogImg   = is_file(ROOT_PATH . '/' . $ogFile) ? $ogFile : 'assets/img/og/default.png';
$ogAbs   = site_origin() . asset($ogImg);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($metaTitle) ?></title>
<meta name="description" content="<?= e($metaDesc) ?>">
<link rel="canonical" href="<?= e($metaUrl) ?>">
<meta name="theme-color" content="#0B0F17">
<meta name="color-scheme" content="dark">
<?php /* An internal tool sets $robots = 'noindex, nofollow' before including
         this; everything public keeps the default. */ ?>
<meta name="robots" content="<?= e($robots ?? 'index, follow, max-image-preview:large, max-snippet:-1') ?>">

<meta property="og:site_name" content="<?= e(SITE_NAME) ?>">
<meta property="og:title" content="<?= e($metaTitle) ?>">
<meta property="og:description" content="<?= e($metaDesc) ?>">
<meta property="og:type" content="<?= e($ogType ?? 'website') ?>">
<meta property="og:url" content="<?= e($metaUrl) ?>">
<meta property="og:image" content="<?= e($ogAbs) ?>">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:locale" content="en_IN">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?= e($metaTitle) ?>">
<meta name="twitter:description" content="<?= e($metaDesc) ?>">
<meta name="twitter:image" content="<?= e($ogAbs) ?>">

<link rel="icon" type="image/svg+xml" href="<?= e(asset('assets/img/favicon.svg')) ?>">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= e(asset('assets/css/style.css')) ?>">
<?php component('schema', [
    'schema'      => $schema ?? null,
    'schemaExtra' => $schemaExtra ?? null,
]); ?>
<?php /* Unconditional: an import map only declares where a bare specifier
         resolves to, it does not fetch anything, and it has to be in the
         document before the first module that uses one. It was gated on the
         hero scene until the web development page's corridor became a second
         thing that imports `three`. */ ?>
<script type="importmap">
{ "imports": { "three": "<?= e(asset('assets/vendor/three/three.module.js')) ?>" } }
</script>
<?php /* A page that needs its own fonts or stylesheet sets $extraHead before
         including this. It is raw markup by contract, so it is echoed as-is. */ ?>
<?= $extraHead ?? '' ?>
</head>
<?php /* $bodyClass lets one route opt into a treatment the other pages in
         its section do not get — ai-native-product-development uses it for
         the staged, scroll-driven layer. */ ?>
<body class="page-<?= e($page) ?><?= !empty($bodyClass) ? ' ' . e($bodyClass) : '' ?>">

<a class="skip-link" href="#main">Skip to content</a>

<header class="site-header" id="siteHeader">
  <div class="shell header-inner">
    <a class="brand" href="<?= e(url('index.php')) ?>" aria-label="<?= e(SITE_NAME) ?> home">
      <img class="brand-mark" src="<?= e(asset('assets/img/logo-mark.png')) ?>" width="120" height="120" alt="<?= e(SITE_NAME) ?>" decoding="async">
      <span class="brand-text">
        <span class="brand-name">iThrive</span>
        <span class="brand-sub">Software</span>
      </span>
    </a>

    <nav class="site-nav" id="siteNav" aria-label="Primary">
      <?php foreach (NAV_ITEMS as $slug => $item): ?>
        <?php $hasMenu = !empty($item['menu']); ?>
        <div class="nav-item<?= $hasMenu ? ' has-menu' : '' ?>">
          <a class="nav-link<?= $page === $slug ? ' is-active' : '' ?>"
             href="<?= e(url($item['href'])) ?>"
             <?= $page === $slug ? 'aria-current="page"' : '' ?>
             <?= $hasMenu ? 'aria-expanded="false" aria-haspopup="true"' : '' ?>>
            <?= e($item['label']) ?>
            <?= $hasMenu ? icon('chevron', 'icon nav-caret') : '' ?>
          </a>

          <?php if ($hasMenu): ?>
            <?php $cols = count($item['menu']['columns']); ?>
            <div class="nav-panel<?= empty($item['menu']['feature']) ? ' nav-panel--narrow' : '' ?>">
              <?php /* Card header, after the reference: a title and a one-line
                       tagline, the menu's call to action on the right, then a
                       divider. The CTA used to sit in a promo strip at the foot
                       of the panel; up here it is visible without reading the
                       whole list first. */ ?>
              <?php if (!empty($item['menu']['title'])): ?>
                <div class="nav-panel-head">
                  <div>
                    <p class="nav-panel-title"><?= e($item['menu']['title']) ?></p>
                    <?php if (!empty($item['menu']['tagline'])): ?>
                      <p class="nav-panel-tagline"><?= e($item['menu']['tagline']) ?></p>
                    <?php endif; ?>
                  </div>
                  <?php if (!empty($item['menu']['feature']['cta'])): $cta = $item['menu']['feature']['cta']; ?>
                    <a class="btn btn-primary btn-sm nav-panel-cta" href="<?= e(url($cta['href'])) ?>">
                      <?= e($cta['label']) ?><?= icon('arrow') ?>
                    </a>
                  <?php endif; ?>
                </div>
              <?php endif; ?>
              <?php /* --cols is the real column count. The grid used to be a
                       fixed five for every menu, so the two-column menus sat
                       squeezed into two fifths of their own panel. */ ?>
              <div class="nav-panel-cols" style="--cols: <?= (int) $cols ?>">
                <?php foreach ($item['menu']['columns'] as $col): ?>
                  <div class="nav-col">
                    <p class="nav-col-head"><?= e($col['heading']) ?></p>
                    <ul>
                      <?php foreach ($col['links'] as $link): ?>
                        <li><a href="<?= e(url($link['href'])) ?>"><?= e($link['label']) ?></a></li>
                      <?php endforeach; ?>
                    </ul>
                  </div>
                <?php endforeach; ?>
              </div>

            </div>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>

      <button class="btn btn-primary nav-cta" type="button" data-modal-open>Start Your Project</button>
    </nav>

    <button class="nav-toggle" id="navToggle" type="button"
            aria-controls="siteNav" aria-expanded="false" aria-label="Open menu">
      <?= icon('menu', 'icon nav-toggle-open') ?>
      <?= icon('close', 'icon nav-toggle-close') ?>
    </button>
  </div>
</header>

<main id="main">
