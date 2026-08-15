<?php
/**
 * Scroll-scrubbed services film.
 *
 * Full-bleed and chrome-free: no heading, no chapter list, no frame. The
 * section is four viewports tall, the film inside is sticky, and scroll
 * position drives `currentTime` — so the page itself is the scrubber.
 *
 * The one piece of UI is the button, and it follows the playhead: every card in
 * the film names a service, so whatever is on screen is what the button opens.
 *
 * The film sits on the page background rather than in a card, and its edges are
 * masked into that background, so it reads as a section of the page rather than
 * a video embedded in one.
 *
 * Degrades in three steps: no JavaScript leaves a normal video and a working
 * link; touch or reduced-motion plays it inline instead of scrubbing, since
 * seek-per-frame is not reliable on mobile; a missing file drops the section.
 */

declare(strict_types=1);

$film   = SERVICES_FILM;
$src    = ROOT_PATH . '/assets/video/services-film.mp4';
$mobile = ROOT_PATH . '/assets/video/services-film-mobile.mp4';
$poster = ROOT_PATH . '/assets/video/services-film-poster.jpg';

if (!is_file($src)) {
    return;
}
?>
<?php
// The chapter marks travel as data rather than as markup, because the rail they
// used to drive is gone — the button is the only thing that consumes them now.
$marks = array_map(
    static fn (array $c): array => ['at' => $c['at'], 'label' => $c['label'], 'href' => url($c['href'])],
    $film['chapters']
);
?>
<section class="film" data-film
         data-film-duration="<?= e((string) $film['duration']) ?>"
         data-film-chapters='<?= e(json_encode($marks, JSON_UNESCAPED_SLASHES)) ?>'
         aria-label="iThrive services film">

  <div class="film-track">
    <div class="film-sticky">
      <?php /* preload="auto" is not optional here: scrubbing can only be smooth
               if the frames are already buffered. */ ?>
      <video class="film-video" data-film-video
             muted playsinline preload="auto" disablepictureinpicture
             <?= is_file($poster) ? 'poster="' . e(asset('assets/video/services-film-poster.jpg')) . '"' : '' ?>>
        <?php if (is_file($mobile)): ?>
          <source src="<?= e(asset('assets/video/services-film-mobile.mp4')) ?>" type="video/mp4" media="(max-width: 860px)">
        <?php endif; ?>
        <source src="<?= e(asset('assets/video/services-film.mp4')) ?>" type="video/mp4">
      </video>

      <!-- Follows the playhead: always opens the service currently on screen. -->
      <a class="film-cta" data-film-cta href="<?= e(url($film['chapters'][0]['href'])) ?>">
        <span class="film-cta-label" data-film-cta-label><?= e($film['chapters'][0]['label']) ?></span>
        <?= icon('arrow') ?>
      </a>

      <?php /* Hidden from view but present for keyboard and screen-reader users,
               who cannot scroll-scrub to reach a service. */ ?>
      <ul class="film-links sr-only">
        <?php foreach ($film['chapters'] as $chapter): ?>
          <li><a href="<?= e(url($chapter['href'])) ?>"><?= e($chapter['label']) ?></a></li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
</section>
