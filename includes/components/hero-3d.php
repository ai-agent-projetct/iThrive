<?php
/**
 * Home page hero — copy on the left, the WebGL neural ring on the right.
 *
 * The stage renders a CSS orb immediately; hero-scene.js fades it out once
 * WebGL is up, so the hero is never empty and never breaks without it.
 */

declare(strict_types=1);

$hero = $hero ?? HOME_HERO;
?>
<section class="hero">
  <div class="shell hero-inner">
    <div>
      <p class="hero-badge" data-reveal>
        <b>AI-First</b><?= e($hero['eyebrow']) ?>
      </p>

      <h1 class="hero-title" data-reveal style="--d:1">
        We Build <em>Intelligent Apps &amp; AI Platforms</em> That Scale Your Business.
      </h1>

      <p class="hero-lead" data-reveal style="--d:2"><?= e($hero['lead']) ?></p>

      <div class="hero-actions" data-reveal style="--d:3">
        <button class="btn btn-primary" type="button" data-modal-open>
          <?= e($hero['primary']['label']) ?><?= icon('arrow') ?>
        </button>
        <a class="btn btn-ghost" href="<?= e(url($hero['secondary']['href'])) ?>">
          <?= icon('play') ?><?= e($hero['secondary']['label']) ?>
        </a>
      </div>

      <div class="hero-trust" data-reveal style="--d:4">
        <span><strong>Python</strong> &amp; Agentic AI</span>
        <span><strong>Cloud</strong> Architecture</span>
        <span><strong>Web</strong>, <strong>Mobile</strong> &amp; ERP</span>
      </div>
    </div>

    <div class="hero-stage<?= SPLINE_SCENE !== '' ? ' hero-stage--spline' : '' ?>" id="heroStage" data-reveal style="--d:2">
      <?php if (SPLINE_SCENE !== ''): ?>
        <?php component('spline-hero'); ?>
      <?php else: ?>
        <div class="hero-orb"></div>
        <div class="hero-canvas" id="heroCanvas" role="img"
             aria-label="A rotating neural ring of connected nodes representing Ithrive's Python and agentic AI engine."></div>
      <?php endif; ?>

      <?php foreach (HOME_HERO_STATS as $stat): ?>
        <div class="hero-chip">
          <?= icon($stat['icon']) ?>
          <span>
            <span class="hero-chip-value"><?= e($stat['value']) ?></span>
            <span class="hero-chip-label"><?= e($stat['label']) ?></span>
          </span>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
