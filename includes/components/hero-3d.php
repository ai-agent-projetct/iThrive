<?php
/**
 * Home page hero.
 *
 * Two columns: the headline carries the left, and the character holds the
 * right. She is not a picture either — sixty-four frames of a head turning
 * through a circle, and the pointer's angle around her face picks the one you
 * see, so she watches the cursor anywhere on the page and meets your eye when
 * it comes near her. See assets/js/character.js.
 *
 * She replaced the 3D robot, who is still in assets/js/robot.js and still
 * stands in the Cloud & DevOps hero.
 *
 * Nothing floats over her — the proof points sit under the copy on the left,
 * where they are read rather than dodged.
 */

declare(strict_types=1);

$hero = $hero ?? HOME_HERO;

// Tells includes/footer.php to import the character module.
$GLOBALS['ithrive_needs_character'] = true;
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

      <div class="hero-stage hero-stage--character">
        <div class="hero-glow" aria-hidden="true"></div>
        <?php /* data-character-canvas is the hook character.js binds to; the
                 base path is resolved here so the frames load from any depth.
                 Nothing is drawn until the centre frame arrives, and the glow
                 plate behind holds the column until it does. */ ?>
        <canvas class="hero-character" data-character-canvas
                data-base="<?= e(url('assets/img/character')) ?>"
                role="img"
                aria-label="The iThrive character in a branded cap, who turns to follow your pointer and looks straight at you when it comes near her."></canvas>
      </div>
    </div>
  </div>
</section>
