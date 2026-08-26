<?php
/**
 * AI-Native Product Development hero.
 *
 * The hero is the reference film itself — that robot, in that field, with that
 * lighting. Not a rebuild of him: a rebuild is not him.
 *
 * What the film cannot do on its own is look at you, so assets/js/film-robot.js
 * draws glowing eyes and a mouth onto the dark visor he already has, and those
 * follow your pointer. The visor is a fixed point in the frame — across the
 * whole twelve seconds his head moves two pixels — so it needs measuring once,
 * not tracking.
 *
 * Nothing here is load-bearing: no JavaScript leaves the film playing, and a
 * browser that will not autoplay leaves the poster frame. Either way the copy
 * and the calls to action are ordinary markup on top.
 *
 * @var array $svc The service, from service().
 */

declare(strict_types=1);

// Tells includes/footer.php to load the overlay. Same idiom as the eyes.
$GLOBALS['ithrive_needs_film_robot'] = true;
?>
<section class="rhero">

  <?php /* The film. Decorative and muted — it is the picture, not something
           anyone is being asked to sit and watch. */ ?>
  <div class="rhero-film" data-film-robot aria-hidden="true">
    <video class="rhero-video"
           src="<?= e(asset('assets/video/ai-robot-film.mp4')) ?>"
           poster="<?= e(asset('assets/video/ai-robot-film-poster.jpg')) ?>"
           autoplay muted loop playsinline preload="auto"></video>
    <canvas class="rhero-eyes"></canvas>
  </div>

  <?php /* Darkens the left of the frame so the copy has something to sit on,
           without touching the robot on the right. */ ?>
  <div class="rhero-scrim" aria-hidden="true"></div>

  <div class="shell rhero-inner">
    <div class="rhero-copy">
      <p class="eyebrow" data-reveal><?= e($svc['group']) ?></p>
      <h1 class="rhero-title" data-reveal style="--d:1"><?= e($svc['title']) ?></h1>
      <p class="rhero-lead" data-reveal style="--d:2"><?= e($svc['lead']) ?></p>

      <div class="rhero-actions" data-reveal style="--d:3">
        <a class="btn btn-primary" href="<?= e(url('contact.php')) ?>">
          Start Your Project<?= icon('arrow') ?>
        </a>
        <a class="btn btn-ghost" href="<?= e(url('services.php')) ?>">All services</a>
      </div>

      <?php if (!empty($svc['outcomes'])): ?>
        <ul class="rhero-stats" data-reveal style="--d:4">
          <?php foreach (array_slice($svc['outcomes'], 0, 3) as $out): ?>
            <li>
              <span class="rhero-stat-value"><?= e($out['value']) ?></span>
              <span class="rhero-stat-label"><?= e($out['label']) ?></span>
            </li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
    </div>
  </div>

  <p class="rhero-hint" aria-hidden="true"><?= icon('compass') ?>Move your pointer — he watches</p>
</section>
