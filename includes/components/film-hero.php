<?php
/**
 * A scroll-scrubbed film, sat above a page's ordinary hero.
 *
 * The clip fills the viewport and its playhead is tied to how far you have
 * scrolled through the section: assets/js/scrub.js binds any [data-scrub]
 * section holding a [data-scrub-video].
 *
 * This carries nothing but the picture. Whatever hero follows it keeps the h1
 * and the copy, which is the only version of them a crawler can read — a
 * scrubbed film is invisible to one.
 *
 * The clips it plays are cut all-intra, a keyframe every third frame. That is
 * the whole difference between a seek that lands on the frame asked for and one
 * that walks backwards to find a keyframe first.
 *
 * Degrades: touch and reduced-motion skip the scrub and play the clip inline,
 * which scrub.js handles; no JavaScript at all leaves the poster frame.
 *
 * @var string $video  Basename in videos/. `-mobile` and a poster of the same
 *                     name in assets/img/ are used when they exist.
 * @var string $label  Accessible name for the section.
 * @var string $track  Section height. This is the speed dial: the clip is
 *                     mapped across the height MINUS the one viewport the
 *                     sticky stage occupies. The site's slowest films run about
 *                     420px of scroll per second of footage.
 * @var string $ease   How hard the playhead is pulled toward the scroll
 *                     position each frame. Lower is smoother and laggier.
 */

declare(strict_types=1);

$src    = ROOT_PATH . '/videos/' . $video . '.mp4';
$mobile = ROOT_PATH . '/videos/' . $video . '-mobile.mp4';
$poster = ROOT_PATH . '/assets/img/' . $video . '-poster.jpg';

/* No clip, no empty viewports of sticky scrolling. */
if (!is_file($src)) {
    return;
}

$track = $track ?? '1300vh';
$ease  = $ease  ?? '0.06';
?>
<section class="afilm" data-scrub data-scrub-ease="<?= e($ease) ?>"
         style="--track:<?= e($track) ?>" aria-label="<?= e($label) ?>">
  <div class="afilm-track">
    <div class="afilm-sticky">
      <?php /* preload="auto": a scrub is only smooth once the frames are
               buffered — a seek into an unbuffered region paints nothing. */ ?>
      <video class="afilm-video" data-scrub-video
             muted playsinline preload="auto" disablepictureinpicture
             <?= is_file($poster) ? 'poster="' . e(asset('assets/img/' . $video . '-poster.jpg')) . '"' : '' ?>>
        <?php if (is_file($mobile)): ?>
          <source src="<?= e(asset('videos/' . $video . '-mobile.mp4')) ?>" type="video/mp4" media="(max-width: 860px)">
        <?php endif; ?>
        <source src="<?= e(asset('videos/' . $video . '.mp4')) ?>" type="video/mp4">
      </video>

      <?php /* Enough darkening at the top edge to keep the fixed header legible
               over any frame. Nothing else sits on the film. */ ?>
      <div class="afilm-scrim" aria-hidden="true"></div>

      <span class="afilm-progress" aria-hidden="true"><span data-scrub-bar></span></span>
    </div>
  </div>
</section>
