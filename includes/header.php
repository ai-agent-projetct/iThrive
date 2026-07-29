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
$pageTitle = $pageTitle ?? SITE_NAME;
$pageDesc  = $pageDesc  ?? SITE_TAGLINE;
$heroScene = $heroScene ?? null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($pageTitle) ?></title>
<meta name="description" content="<?= e($pageDesc) ?>">
<meta name="theme-color" content="#0B0F17">
<meta name="color-scheme" content="dark">
<meta property="og:site_name" content="<?= e(SITE_NAME) ?>">
<meta property="og:title" content="<?= e($pageTitle) ?>">
<meta property="og:description" content="<?= e($pageDesc) ?>">
<meta property="og:type" content="website">
<meta name="twitter:card" content="summary_large_image">
<link rel="icon" type="image/svg+xml" href="<?= e(asset('assets/img/favicon.svg')) ?>">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= e(asset('assets/css/style.css')) ?>">
<?php if ($heroScene !== null): ?>
<script type="importmap">
{ "imports": { "three": "<?= e(asset('assets/vendor/three/three.module.js')) ?>" } }
</script>
<?php endif; ?>
</head>
<body class="page-<?= e($page) ?>">

<a class="skip-link" href="#main">Skip to content</a>

<header class="site-header" id="siteHeader">
  <div class="shell header-inner">
    <a class="brand" href="<?= e(url('index.php')) ?>" aria-label="<?= e(SITE_NAME) ?> home">
      <img class="brand-mark" src="<?= e(asset('assets/img/logo-mark.svg')) ?>" width="120" height="120" alt="">
      <span class="brand-text">
        <span class="brand-name">Ithrive</span>
        <span class="brand-sub">Software Solutions</span>
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
            <div class="nav-panel<?= empty($item['menu']['feature']) ? ' nav-panel--narrow' : '' ?>">
              <div class="nav-panel-cols">
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

              <?php if (!empty($item['menu']['feature'])): $f = $item['menu']['feature']; ?>
                <div class="nav-feature">
                  <p class="nav-feature-eyebrow"><?= e($f['eyebrow']) ?></p>
                  <h3><?= e($f['title']) ?></h3>
                  <p><?= e($f['body']) ?></p>
                  <a class="btn btn-primary btn-sm" href="<?= e(url($f['cta']['href'])) ?>">
                    <?= e($f['cta']['label']) ?><?= icon('arrow') ?>
                  </a>
                </div>
              <?php endif; ?>
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
