<?php
/**
 * Service tile linking to its dedicated detail page.
 *
 * @var array $item   One entry from a SERVICES group.
 * @var int   $index  Stagger index for the reveal animation.
 */

declare(strict_types=1);

$index = $index ?? 0;
$slug  = $item['slug'] ?? '';

$parentSlug = $parentSlug ?? '';

// Determine image for the service card
$photo = null;
global $page;
$isHome = ($page ?? '') === 'home' || in_array($_SERVER['REQUEST_URI'] ?? '', ['/', '/index.php', ''], true);
$isServicesPage = basename($_SERVER['SCRIPT_NAME'] ?? '') === 'services.php' || in_array($_SERVER['REQUEST_URI'] ?? '', ['/services.php', 'services.php'], true);

if ($isHome && is_file(ROOT_PATH . '/assets/img/home/services/' . $slug . '.jpg')) {
    $photo = 'assets/img/home/services/' . $slug . '.jpg';
} elseif ($isServicesPage && is_file(ROOT_PATH . '/assets/img/services-page/cards/' . $slug . '.jpg')) {
    $photo = 'assets/img/services-page/cards/' . $slug . '.jpg';
} elseif (!empty($parentSlug) && is_file(ROOT_PATH . '/assets/img/sibling-cards/' . $parentSlug . '-' . $slug . '.jpg')) {
    $photo = 'assets/img/sibling-cards/' . $parentSlug . '-' . $slug . '.jpg';
}

if ($photo === null && !empty($item['photo'])) {
    $candidates = [
        'assets/img/cards/photo/' . $item['photo'] . '.jpg',
        'assets/img/' . $item['photo'] . '.jpg',
        'assets/img/' . $item['photo'],
    ];
    foreach ($candidates as $c) {
        if (is_file(ROOT_PATH . '/' . $c)) { $photo = $c; break; }
    }
}

if ($photo === null && $slug !== '') {
    $special = [
        'ai-development-company'      => 'assets/img/aidev/human-ai-collaboration.jpg',
        'ai-enablement'               => 'assets/img/aidev/solutions/genai.jpg',
        'software-development'        => 'assets/img/software-hero-poster.jpg',
        'mobile-app-development'      => 'assets/img/pages/apps/mobile-architecture.jpg',
        'flutter-app-development'     => 'assets/img/pages/apps/flutter-codebase.jpg',
        'web-development'             => 'assets/img/pages/services-surfaces.jpg',
        'game-development'            => 'assets/img/game/hero/01.jpg',
        'ecommerce-development'       => 'assets/img/pages/services/ecommerce-development.jpg',
    ];

    $candidates = [
        'assets/img/pages/services/photo/' . $slug . '.jpg',
        'assets/img/pages/services/' . $slug . '.jpg',
        $special[$slug] ?? null,
    ];

    foreach ($candidates as $c) {
        if ($c !== null && is_file(ROOT_PATH . '/' . $c)) {
            $photo = $c;
            break;
        }
    }
}
?>
<a class="card<?= $photo !== null ? ' card--photo' : '' ?>" href="<?= e(url('services/' . $item['slug'] . '.php')) ?>" data-reveal style="--d:<?= (int) $index ?>">
  <?php if ($photo !== null): ?>
    <figure class="card-figure">
      <img src="<?= e(asset($photo)) ?>" width="600" height="400" alt="<?= e($item['title']) ?>" loading="lazy" decoding="async">
      <?php if (!empty($item['icon'])): ?><span class="card-figure-icon"><?= icon($item['icon']) ?></span><?php endif; ?>
    </figure>
  <?php else: ?>
    <span class="card-icon"><?= icon($item['icon']) ?></span>
  <?php endif; ?>

  <h3 class="card-title"><?= e($item['title']) ?></h3>
  <p class="card-body"><?= e($item['short']) ?></p>

  <?php if (!empty($item['stack'])): ?>
    <ul class="tag-row">
      <?php foreach (array_slice($item['stack'], 0, 3) as $tag): ?><li class="tag"><?= e($tag) ?></li><?php endforeach; ?>
    </ul>
  <?php endif; ?>

  <span class="card-link">Explore service<?= icon('arrow') ?></span>
</a>
