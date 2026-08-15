<?php
/**
 * Home page hero.
 *
 * Two columns: the headline carries the left, and the interactive 3D robot
 * mascot holds the right. He is not a picture — he tracks the pointer across
 * the whole page with his head, eyes and arms, and runs idle behaviours when
 * you leave him alone. WebGL failure leaves the glow plate behind him, so the
 * column is never an empty box.
 *
 * Nothing floats over him — the proof points sit under the copy on the left,
 * where they are read rather than dodged.
 */

declare(strict_types=1);

$hero = $hero ?? HOME_HERO;
?>
<section class="hero hero--split">
  <div class="shell hero-inner">
    <div class="hero-copy">
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

      <div class="hero-stats" data-reveal style="--d:4">
        <?php foreach (HOME_HERO_STATS as $stat): ?>
          <div class="hero-stat">
            <?= icon($stat['icon']) ?>
            <span>
              <span class="hero-chip-value"><?= e($stat['value']) ?></span>
              <span class="hero-chip-label"><?= e($stat['label']) ?></span>
            </span>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="hero-visual" data-reveal style="--d:2">
      <?php /* Above the stage, not below it: the floating chat launcher owns
               the bottom-right corner, and the two would collide there. */ ?>
      <a class="hero-orb-cta" href="#ai-assistant">
        <span class="hero-orb-dot" aria-hidden="true"></span>
        Talk to iThrive AI — six languages, out loud
        <?= icon('arrow') ?>
      </a>

      <div class="hero-stage hero-stage--robot">
        <div class="hero-glow" aria-hidden="true"></div>
        <?php /* data-robot-canvas is the hook robot.js binds to, and the badge
                 URL is resolved here so the chest mark loads from any depth. */ ?>
        <canvas class="hero-robot" data-robot-canvas
                data-robot-badge="<?= e(asset('assets/img/robot-badge.png')) ?>"
                role="img"
                aria-label="An interactive 3D robot mascot wearing the iThrive mark, whose head, eyes and arms follow your pointer."></canvas>
      </div>
    </div>
  </div>
</section>
