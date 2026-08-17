<?php
/**
 * "Why iThrive" — the argument, as a scroll-scrubbed film.
 *
 * This replaces four static cards. The film contains the same points and four
 * more, animated as a card slider, so scrolling reads them rather than the
 * visitor scanning a grid and leaving.
 *
 * The clip is square. The stage is 16:9 with the film's own backdrop colour
 * behind it, so the frame reads as full-bleed with no visible letterbox —
 * cropping a square to 16:9 would cut the tops and bottoms off the cards,
 * which are the content.
 */

declare(strict_types=1);

$src    = ROOT_PATH . '/videos/why-film.mp4';
$poster = ROOT_PATH . '/assets/img/why-film-poster.jpg';

if (!is_file($src)) {
    return;
}
?>
<section class="section why-film" data-scrub data-scrub-duration="15">
  <div class="why-film-track">
    <div class="why-film-sticky">
      <div class="shell">
        <?php component('section-head', [
            'eyebrow' => HOME_WHY['eyebrow'],
            'title'   => HOME_WHY['title'],
        ]); ?>

        <figure class="why-film-stage">
          <?php /* preload="auto": scrubbing is only smooth once the frames are
                   buffered, and this clip is small enough to fetch up front. */ ?>
          <video class="why-film-video" data-scrub-video
                 muted playsinline preload="auto" disablepictureinpicture
                 <?= is_file($poster) ? 'poster="' . e(asset('assets/img/why-film-poster.jpg')) . '"' : '' ?>>
            <source src="<?= e(asset('videos/why-film.mp4')) ?>" type="video/mp4">
          </video>

          <span class="why-film-progress" aria-hidden="true"><span data-scrub-bar></span></span>

          <figcaption class="sr-only">
            <?php foreach (HOME_WHY['items'] as $item): ?>
              <?= e($item['title']) ?>: <?= e($item['body']) ?>
            <?php endforeach; ?>
          </figcaption>
        </figure>
      </div>
    </div>
  </div>
</section>
