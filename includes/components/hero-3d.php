<?php
/**
 * Home page hero.
 *
 * The neural orb used to live here; it now anchors the AI assistant section
 * further down the page, where it is interactive rather than decorative. This
 * hero is a single centred column so the headline carries the fold on its own.
 */

declare(strict_types=1);

$hero = $hero ?? HOME_HERO;
?>
<section class="hero hero--center">
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
  </div>
</section>
