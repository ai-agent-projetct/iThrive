<?php
/**
 * AI Enablement hero — after amaterasu.ai/aleph's "Clear Paths Ahead".
 *
 * The reference builds its whole page into two WebGL canvases: measured, the
 * document never scrolls, there are zero images and zero videos, and the scroll
 * is virtualised inside the scene. What it looks like is one persistent
 * rim-lit figure on a pale ground, a particle field inside its head that
 * changes state as you advance, copy fading in and out at the left, a small-caps
 * section label at the bottom, and a circular scroll control at the right.
 *
 * Rebuilt here as a real hero over real markup rather than as a canvas. The
 * figure is our own robot, cut out of the reference film; the particle field
 * over its head is assets/js/aleph.js, which also drives the copy and the label.
 *
 * The palette is the reference's, measured off it: a pale aqua ground, deep
 * navy #1B2978 for type, aqua #75CDD6 for accents. It is scoped to body.aleph
 * in the stylesheet so the rest of the site keeps its own dark theme.
 *
 * Everything degrades. No JavaScript leaves the figure, the heading and the
 * lead; no WebGL leaves the same. The copy is never inside the canvas.
 *
 * @var array $svc The service, from service().
 */

declare(strict_types=1);

$GLOBALS['ithrive_needs_aleph'] = true;

/**
 * The scenes.
 *
 * The reference advances through named states as you scroll, each swapping the
 * copy and changing what the particle field is doing. These are ours, and the
 * `field` value is what assets/js/aleph.js reads to decide how the particles
 * behave: scattered, gathering, or settled into a lattice.
 */
$scenes = [
    ['key' => 'chaos',   'label' => 'From scattered to systematic', 'field' => 'chaos',
     'lead' => 'Your product already generates the signal — clicks, tickets, abandoned flows, '
             . 'half-finished forms. Today it is noise nobody reads.'],
    ['key' => 'order',   'label' => 'From noise to signal', 'field' => 'order',
     'lead' => 'We instrument what is already there and turn it into something a model can '
             . 'learn from, without touching the parts of the product that earn money.'],
    ['key' => 'paths',   'label' => 'Clear paths ahead', 'field' => 'lattice',
     'lead' => 'Then the product starts answering for itself: ranking what matters, predicting '
             . 'what breaks, and handling the work nobody should be doing by hand.'],
];
?>
<section class="alx" data-aleph>

  <?php /* The ground. A pale aqua wash with the reference's circle field over
           it — decorative, and drawn in CSS so it costs nothing. */ ?>
  <div class="alx-ground" aria-hidden="true"></div>
  <div class="alx-circles" aria-hidden="true"></div>

  <div class="alx-stage">
    <?php /* The figure. Cut out of the film, so he reads as a rim-lit form on
             the pale ground exactly as the reference's does. */ ?>
    <img class="alx-figure" src="<?= e(asset('assets/img/art/robot-bust.png')) ?>"
         width="1000" height="960" decoding="async" draggable="false"
         alt="A robot standing in profile, lit from behind.">

    <?php /* The particle field over his head — the reference's signature. */ ?>
    <canvas class="alx-field" data-aleph-field aria-hidden="true"></canvas>
  </div>

  <div class="shell alx-copy">
    <p class="alx-eyebrow"><?= e($svc['group']) ?></p>

    <?php /* Two-tone, as the reference sets its headings: the first line in a
             lighter tint, the second in full navy. */ ?>
    <h1 class="alx-title">
      <span class="alx-title-a">Add intelligence</span>
      <span class="alx-title-b">without a rewrite</span>
    </h1>

    <?php /* One lead per scene, cross-faded by the script. All three are in the
             markup, so with no JavaScript the section simply reads as three
             sentences. */ ?>
    <div class="alx-leads">
      <?php foreach ($scenes as $i => $sc): ?>
        <p class="alx-lead<?= $i === 0 ? ' is-on' : '' ?>" data-aleph-lead="<?= e($sc['field']) ?>">
          <?= e($sc['lead']) ?>
        </p>
      <?php endforeach; ?>
    </div>

    <div class="alx-actions">
      <a class="alx-btn" href="<?= e(url('contact.php')) ?>">Talk to an engineer<?= icon('arrow') ?></a>
      <a class="alx-btn alx-btn--ghost" href="#what-we-add">See what we add</a>
    </div>
  </div>

  <?php /* The bottom-left scene label and the scroll control, both the
           reference's furniture. */ ?>
  <p class="alx-label" data-aleph-label aria-hidden="true">
    <span class="alx-dot"></span><span data-aleph-label-text><?= e($scenes[0]['label']) ?></span>
  </p>

  <a class="alx-scroll" href="#what-we-add" aria-label="Skip to the detail">
    <span aria-hidden="true"><?= icon('chevron') ?></span>
  </a>
</section>
