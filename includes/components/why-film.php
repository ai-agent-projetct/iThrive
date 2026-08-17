<?php
/**
 * "Why iThrive" — the argument, as a scroll-scrubbed film.
 *
 * This replaces four static cards. The film contains the same points and four
 * more, animated as a card slider, so scrolling reads them rather than the
 * visitor scanning a grid and leaving.
 *
 * Two sections, not one. The heading sits in a normal section above so the film
 * below it can take the entire viewport — a heading inside the pinned stage
 * would eat the height the film needs, and overlaying it on the picture is not
 * an option here.
 *
 * The clip is square and the viewport is not, so the sides are filled with an
 * ambient wash sampled from the film itself and the picture's vertical edges
 * are masked into it. That reads as one lit frame rather than a video sitting
 * in a black box. Cropping the square to fill instead would cut the tops and
 * bottoms off the cards, which are the content.
 *
 * The prose above the film is the same argument in text. A scroll-scrubbed
 * video is invisible to a crawler and to an answer engine, so the case has to
 * exist in words somewhere — and it is better as readable copy under the
 * heading than as a caption hidden from the people who visit the page.
 */

declare(strict_types=1);

$src    = ROOT_PATH . '/videos/why-film.mp4';
$mobile = ROOT_PATH . '/videos/why-film-mobile.mp4';
$poster = ROOT_PATH . '/assets/img/why-film-poster.jpg';

if (!is_file($src)) {
    return;
}
?>
<section class="section section--tight why-film-intro">
  <div class="shell">
    <?php component('section-head', [
        'eyebrow' => HOME_WHY['eyebrow'],
        'title'   => HOME_WHY['title'],
    ]); ?>

    <div class="why-film-copy">
      <?php foreach (HOME_WHY['body'] as $para): ?>
        <p><?= e($para) ?></p>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="why-film" data-scrub data-scrub-duration="15" aria-label="<?= e(HOME_WHY['title']) ?>">
  <div class="why-film-track">
    <div class="why-film-sticky">
      <figure class="why-film-stage">
        <div class="why-film-frame">
          <?php /* preload="auto": scrubbing is only smooth once the frames are
                   buffered, and this clip is small enough to fetch up front. */ ?>
          <video class="why-film-video" data-scrub-video
                 muted playsinline preload="auto" disablepictureinpicture
                 <?= is_file($poster) ? 'poster="' . e(asset('assets/img/why-film-poster.jpg')) . '"' : '' ?>>
            <?php if (is_file($mobile)): ?>
              <source src="<?= e(asset('videos/why-film-mobile.mp4')) ?>" type="video/mp4" media="(max-width: 860px)">
            <?php endif; ?>
            <source src="<?= e(asset('videos/why-film.mp4')) ?>" type="video/mp4">
          </video>
        </div>
      </figure>

      <span class="why-film-progress" aria-hidden="true"><span data-scrub-bar></span></span>
    </div>
  </div>
</section>
