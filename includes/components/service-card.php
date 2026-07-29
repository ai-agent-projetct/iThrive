<?php
/**
 * Service tile linking to its dedicated detail page.
 *
 * @var array $item   One entry from a SERVICES group.
 * @var int   $index  Stagger index for the reveal animation.
 */

declare(strict_types=1);

$index = $index ?? 0;
?>
<a class="card" href="<?= e(url('services/' . $item['slug'] . '.php')) ?>" data-reveal style="--d:<?= (int) $index ?>">
  <span class="card-icon"><?= icon($item['icon']) ?></span>
  <h3 class="card-title"><?= e($item['title']) ?></h3>
  <p class="card-body"><?= e($item['short']) ?></p>

  <?php if (!empty($item['stack'])): ?>
    <ul class="tag-row">
      <?php foreach (array_slice($item['stack'], 0, 3) as $tag): ?><li class="tag"><?= e($tag) ?></li><?php endforeach; ?>
    </ul>
  <?php endif; ?>

  <span class="card-link">Explore service<?= icon('arrow') ?></span>
</a>
