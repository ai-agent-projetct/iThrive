<?php
/**
 * Case studies as Origin Kit's Round Carousel.
 *
 * A ring of cards turning in 3D, draggable, with momentum. The geometry and
 * the motion live in assets/js/round-carousel.js and match the component's
 * defaults exactly; this is the markup and the content.
 *
 * The faces are real case study cards rather than the component's background
 * images. Each carries the client, the headline and a link, so the ring is
 * something a crawler can read and a keyboard can reach — ten divs painted
 * with background-image would be ten empty boxes on the page that carries the
 * proof.
 *
 * Every card is rendered twice: once facing out, once mirrored behind it and
 * dimmed. That is how the component builds the ring, and it is what you see
 * through the gaps as the far side turns past.
 */

declare(strict_types=1);

$studies = CASE_STUDIES;
?>
<div class="rc" data-round-carousel
     data-image-width="380" data-spacing="3" data-speed="7"
     data-direction="right" data-drag="true" data-sensitivity="5"
     data-tilt="-7" data-perspective="3000" data-inner-dim="3.5"
     role="group" aria-roledescription="carousel"
     aria-label="Case studies — drag to turn the ring">

  <div class="rc-tilt" data-rc-tilt>
    <div class="rc-ring" data-rc-ring>
      <?php foreach ($studies as $study): ?>
        <div class="rc-item" data-rc-item>

          <?php /* Front face. */ ?>
          <a class="rc-face" href="<?= e(url('case-studies/' . $study['slug'] . '.php')) ?>"
             style="--accent: <?= e($study['accent']) ?>">
            <span class="rc-logo"><?= client_logo($study, 'rc-logo-img') ?></span>
            <span class="rc-client"><?= e($study['client']) ?></span>
            <span class="rc-headline"><?= e($study['headline']) ?></span>
            <span class="rc-industry"><?= e($study['industry']) ?></span>
            <span class="rc-cta">View case study<?= icon('arrow') ?></span>
          </a>

          <?php /* The same card, mirrored and dimmed — what shows on the far
                   side of the ring. Hidden from assistive tech and from the
                   tab order, because it is the identical card twice. */ ?>
          <span class="rc-face rc-face--back" data-rc-back aria-hidden="true"
                style="--accent: <?= e($study['accent']) ?>">
            <span class="rc-logo"><?= client_logo($study, 'rc-logo-img') ?></span>
            <span class="rc-client"><?= e($study['client']) ?></span>
            <span class="rc-headline"><?= e($study['headline']) ?></span>
            <span class="rc-industry"><?= e($study['industry']) ?></span>
            <span class="rc-cta">View case study<?= icon('arrow') ?></span>
          </span>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

  <p class="rc-hint" aria-hidden="true"><?= icon('compass') ?>Drag to turn</p>
</div>
