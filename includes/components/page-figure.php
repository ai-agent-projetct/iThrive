<?php
/**
 * A full-width picture band for pages that were carrying no photography.
 *
 * Most routes only ever had the line-art section marks and the logo. This is
 * the band that gives them an actual picture, sized and cropped the same way
 * everywhere so the pages stay a set rather than becoming a scrapbook.
 *
 * Decorative by default: the alt text is empty unless a caption is supplied,
 * because a mood shot beside prose that already says the same thing is noise to
 * a screen reader. Pass 'alt' when the picture genuinely carries information.
 *
 * @var string  $src     Basename in assets/img/pages, without extension.
 * @var string  $alt     Optional. Describes the picture when it is informative.
 * @var string  $caption Optional. Shown under the frame, and implies alt text.
 * @var string  $ratio   Optional CSS aspect-ratio; defaults to a wide band.
 */

declare(strict_types=1);

/* A bare name lives in assets/img/pages; a name containing a slash is a path
   relative to assets/img, so a page can point at its own picture set. */
$rel  = str_contains($src, '/') ? 'assets/img/' . $src . '.jpg' : 'assets/img/pages/' . $src . '.jpg';
$file = ROOT_PATH . '/' . $rel;

/* No file, no empty frame. */
if (!is_file($file)) {
    return;
}

$caption = $caption ?? '';
$alt     = $alt ?? '';
$ratio   = $ratio ?? '21 / 8';
?>
<figure class="pfig" style="--pfig-ratio: <?= e($ratio) ?>">
  <div class="pfig-frame">
    <img src="<?= e(asset($rel)) ?>"
         alt="<?= e($alt !== '' ? $alt : $caption) ?>"
         loading="lazy" decoding="async">
  </div>
  <?php if ($caption !== ''): ?>
    <figcaption class="pfig-caption"><?= e($caption) ?></figcaption>
  <?php endif; ?>
</figure>
