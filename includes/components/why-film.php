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
 * The clip is square, so on a landscape screen it can never fill the width —
 * cropping it to do so would cut the tops and bottoms off the cards, which are
 * the content. The stage therefore holds the picture at full height on the left
 * and the prose in the column beside it, which is that leftover width used
 * rather than left dark. Behind both sits an ambient wash sampled from the film
 * itself, and the picture's vertical edges are masked into it so the frame ends
 * in light rather than on a line.
 *
 * The prose is also the only version of this argument a crawler or an answer
 * engine can read: a scroll-scrubbed film is invisible to both.
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
  </div>
</section>

<section class="why-film" data-scrub data-scrub-duration="15" aria-label="<?= e(HOME_WHY['title']) ?>">
  <div class="why-film-track">
    <div class="why-film-sticky">
      <div class="why-film-stage">
        <figure class="why-film-frame">
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
        </figure>

        <?php /* The square leaves a tall gap beside it on any landscape screen.
                 This is what goes in it — the film's argument in words, held
                 beside the picture rather than over it. */ ?>
        <div class="why-film-copy">
          <?php foreach (HOME_WHY['body'] as $para): ?>
            <p><?= e($para) ?></p>
          <?php endforeach; ?>
        </div>
      </div>

      <span class="why-film-progress" aria-hidden="true"><span data-scrub-bar></span></span>
    </div>
  </div>
</section>
