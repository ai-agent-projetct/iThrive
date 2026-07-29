<?php
/**
 * Generic glass card with an icon tile.
 *
 * @var array  $item   icon / title / body (+ optional tags, href)
 * @var int    $index  Stagger index for the reveal animation.
 */

declare(strict_types=1);

$index = $index ?? 0;
$href  = $item['href'] ?? null;
$Tag   = $href !== null ? 'a' : 'article';
?>
<<?= $Tag ?> class="card" data-reveal style="--d:<?= (int) $index ?>"<?= $href !== null ? ' href="' . e(url($href)) . '"' : '' ?>>
  <?php if (!empty($item['icon'])): ?>
    <span class="card-icon"><?= icon($item['icon']) ?></span>
  <?php endif; ?>
  <h3 class="card-title"><?= e($item['title']) ?></h3>
  <p class="card-body"><?= e($item['body'] ?? $item['short'] ?? '') ?></p>

  <?php if (!empty($item['tags'])): ?>
    <ul class="tag-row">
      <?php foreach ($item['tags'] as $tag): ?><li class="tag"><?= e($tag) ?></li><?php endforeach; ?>
    </ul>
  <?php endif; ?>

  <?php if ($href !== null): ?>
    <span class="card-link">Learn more<?= icon('arrow') ?></span>
  <?php endif; ?>
</<?= $Tag ?>>
