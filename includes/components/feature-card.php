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

/*
 * A photograph, if one has been shot for this card. Same convention as
 * page-figure.php: the slug names a file, and the card falls back to the icon
 * tile until that file exists — so the markup can be wired before the
 * photography run that fills it in has finished.
 */
$photo = null;
if (!empty($item['photo'])) {
    $rel = 'assets/img/cards/photo/' . $item['photo'] . '.jpg';
    if (is_file(ROOT_PATH . '/' . $rel)) {
        $photo = $rel;
    }
}
?>
<<?= $Tag ?> class="card<?= $photo !== null ? ' card--photo' : '' ?>" data-reveal style="--d:<?= (int) $index ?>"<?= $href !== null ? ' href="' . e(url($href)) . '"' : '' ?>>
  <?php if ($photo !== null): ?>
    <figure class="card-figure">
      <img src="<?= e(asset($photo)) ?>" width="600" height="400" alt="" loading="lazy" decoding="async">
      <?php if (!empty($item['icon'])): ?><span class="card-figure-icon"><?= icon($item['icon']) ?></span><?php endif; ?>
    </figure>
  <?php elseif (!empty($item['icon'])): ?>
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
