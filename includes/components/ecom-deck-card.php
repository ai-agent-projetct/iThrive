<?php
/**
 * One card in the e-commerce deck.
 *
 * The picture sits on its own plane behind the copy and lifts away from it on
 * hover, which is the depth the Originkit Depth Gallery would have given the
 * section had it been available on this account. Everything is CSS: no island,
 * no WebGL, and the whole card is readable with scripts off.
 *
 * @var string   $num    Two-digit index shown in the corner, e.g. '03'.
 * @var string   $tag    Kind of thing this is — 'Architecture', 'Rail'.
 * @var string   $title
 * @var string   $sub    One line under the title.
 * @var string   $desc   The paragraph.
 * @var string[] $points Three proof points.
 * @var string   $stat   Short figure shown against the picture.
 * @var string   $image  Path under the project root.
 * @var string   $alt
 * @var int      $index  Stagger index for the reveal.
 */

declare(strict_types=1);

$points = $points ?? [];
$index  = $index ?? 0;
?>
<article class="ecom-deck-card" data-reveal style="--d:<?= (int) ($index % 3) ?>">
  <figure class="ecom-deck-fig">
    <img src="<?= e(asset($image)) ?>" width="800" height="533"
         alt="<?= e($alt) ?>" loading="lazy" decoding="async">
    <span class="ecom-deck-num"><?= e($num) ?></span>
    <?php if (!empty($stat)): ?>
      <span class="ecom-deck-stat"><?= e($stat) ?></span>
    <?php endif; ?>
  </figure>

  <div class="ecom-deck-body">
    <p class="ecom-deck-tag"><?= e($tag) ?></p>
    <h3 class="ecom-deck-title"><?= e($title) ?></h3>
    <p class="ecom-deck-sub"><?= e($sub) ?></p>
    <p class="ecom-deck-desc"><?= e($desc) ?></p>

    <?php if ($points !== []): ?>
      <ul class="ecom-deck-points">
        <?php foreach ($points as $point): ?>
          <li><?= icon('check', 'icon ecom-deck-tick') ?><span><?= e($point) ?></span></li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>

    <button class="ecom-deck-cta" type="button" data-modal-open data-modal-service="<?= e($title) ?>">
      Talk to an engineer<?= icon('arrow') ?>
    </button>
  </div>
</article>
