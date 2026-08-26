<?php
/**
 * AI-Native Product Development hero.
 *
 * Staged after the reference film: a near-black field, one cool light from
 * above, and a figure standing in flowers. The field is that film, cropped to
 * the band below its own robot so ours is the only one in frame; the light and
 * the dark are CSS; the robot is that film's own humanoid, rebuilt as a rig in
 * assets/js/field-robot.js so he can look at you — head, eyes, and the arm on
 * your side, which reaches.
 *
 * His canvas is transparent, so he composites onto the real footage rather than
 * standing on a rendered floor that would never match it.
 *
 * Nothing here is load-bearing for the page: no WebGL leaves the lit field and
 * the copy, and a browser that will not autoplay leaves the poster frame.
 *
 * @var array $svc The service, from service().
 */

declare(strict_types=1);

// Tells includes/footer.php to import the module. Same idiom as the eyes.
$GLOBALS['ithrive_needs_field_robot'] = true;
?>
<section class="rhero">

  <?php /* The field. Decorative, muted and inert — it is the floor of the
           picture, not something anyone needs to watch. */ ?>
  <div class="rhero-field" aria-hidden="true">
    <video class="rhero-video"
           src="<?= e(asset('assets/video/ai-field.mp4')) ?>"
           poster="<?= e(asset('assets/video/ai-field-poster.jpg')) ?>"
           autoplay muted loop playsinline preload="metadata"></video>
  </div>
  <div class="rhero-light" aria-hidden="true"></div>

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

    <div class="rhero-stage">
      <?php /* data-field-robot is the hook field-robot.js binds to. It appends
               its own canvas, so a WebGL failure leaves an empty box rather
               than a black rectangle where a canvas would have been. */ ?>
      <div class="rhero-robot" data-field-robot
           role="img"
           aria-label="An interactive 3D robot standing in a field of flowers, whose head, eyes and arms follow your pointer."></div>
    </div>
  </div>

  <p class="rhero-hint" aria-hidden="true"><?= icon('compass') ?>Move your pointer — he follows</p>
</section>
