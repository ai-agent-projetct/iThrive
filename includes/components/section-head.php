<?php
/**
 * @var string      $eyebrow
 * @var string      $title
 * @var string|null $lead
 * @var bool        $left   Left-align instead of centring.
 * @var string|null $art    Name of an illustration in assets/img/art, without
 *                          the extension. Opt-in: sections that carry their own
 *                          imagery below the heading do not want a second mark.
 */

declare(strict_types=1);

$lead = $lead ?? null;
$left = $left ?? false;
$art  = $art ?? null;

// A missing file is a typo, not a reason to emit a broken image.
if ($art !== null && !is_file(ROOT_PATH . '/assets/img/art/' . $art . '.svg')) {
    $art = null;
}
?>
<div class="section-head<?= $left ? ' section-head--left' : '' ?><?= $art ? ' section-head--art' : '' ?>">
  <?php if ($art !== null): ?>
    <?php /* Decoration: the drawing restates the heading beside it, so it is
             hidden from assistive tech rather than described twice. */ ?>
    <span class="section-head-art" aria-hidden="true">
      <img src="<?= e(asset('assets/img/art/' . $art . '.svg')) ?>"
           width="560" height="420" loading="lazy" decoding="async" draggable="false" alt="">
    </span>
  <?php endif; ?>

  <div class="section-head-text">
    <?php if (!empty($eyebrow)): ?><p class="eyebrow" data-reveal><?= e($eyebrow) ?></p><?php endif; ?>
    <h2 class="section-title" data-reveal style="--d:1"><?= e($title) ?></h2>
    <?php if ($lead !== null): ?><p class="section-lead" data-reveal style="--d:2"><?= e($lead) ?></p><?php endif; ?>
  </div>
</div>
