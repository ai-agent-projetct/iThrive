<?php
/**
 * Home page hero.
 *
 * The copy holds the left, the character holds the right, and she is not in a
 * frame: her own lit background is the section's background, so she bleeds off
 * the right edge and melts into it down the left side of her column. That is
 * the whole trick — the frames are opaque rectangles, and the gradient behind
 * the hero is mixed to meet them.
 *
 * She is sixty-four frames of a head turning through a circle; the pointer's
 * angle around her face picks the one you see, so she watches the cursor
 * anywhere on the page and meets your eye when it comes near her. See
 * assets/js/character.js. The robot she replaced still stands in the Cloud &
 * DevOps hero.
 *
 * The cursor hint beside her is shown until the first pointer move and then
 * fades for good — character.js marks the document once it has seen one.
 */

declare(strict_types=1);

$hero = $hero ?? HOME_HERO;

// Tells includes/footer.php to import the character module.
$GLOBALS['ithrive_needs_character'] = true;

/* The strip along the foot of the hero. Five routes we actually sell, each to
   its own page — no placeholder tiles. */
$heroStrip = [
    ['smartphone', 'Mobile App',   'Development', 'services/mobile-app-development.php'],
    ['code',       'Web',          'Development', 'services/web-development.php'],
    ['bot',        'AI Agent',     'Solutions',   'services/ai-agent-solutions.php'],
    ['cloud',      'Cloud &',      'DevOps',      'services/cloud-devops.php'],
    ['package',    'Product',      'Development', 'services/custom-product-development.php'],
];
?>
<section class="hero hero--character">
  <div class="hero-sky" aria-hidden="true"></div>

  <?php /* She stands in the whole hero, not in a column of it: her frames are
           drawn across this canvas and feathered into the gradient above, so
           there is no box around her. The scrim after it keeps the copy
           readable where she passes behind it. */ ?>
  <canvas class="hero-character" data-character-canvas
          data-base="<?= e(url('assets/img/character')) ?>"
          data-version="<?= e((string) @filemtime(ROOT_PATH . '/assets/img/character/center.webp')) ?>"
          role="img"
          aria-label="The iThrive character in a branded cap, who turns to follow your pointer and looks straight at you when it comes near her."></canvas>
  <div class="hero-scrim" aria-hidden="true"></div>

  <div class="shell hero-char-inner">
    <div class="hero-copy">
      <p class="hero-kicker" data-reveal>Ideas <span>•</span> Technology <span>•</span> People</p>

      <h1 class="hero-title hero-title--xl" data-reveal style="--d:1">
        We Build <em>Intelligent Apps &amp; AI Platforms</em> That Scale Your Business.
      </h1>

      <p class="hero-lead" data-reveal style="--d:2"><?= e($hero['lead']) ?></p>

      <div class="hero-actions" data-reveal style="--d:3">
        <button class="btn btn-primary" type="button" data-modal-open>
          <?= e($hero['primary']['label']) ?><?= icon('arrow') ?>
        </button>
        <a class="btn btn-ghost" href="<?= e(url($hero['secondary']['href'])) ?>">
          <?= e($hero['secondary']['label']) ?>
        </a>
      </div>

      <?php /* The assistant kept its route into the page; it used to be a pill
               floating over the visual, where it now competes with her. */ ?>
      <a class="hero-ai-link" href="#ai-assistant" data-reveal style="--d:4">
        <span class="hero-orb-dot" aria-hidden="true"></span>
        Talk to iThrive AI — six languages, out loud<?= icon('arrow') ?>
      </a>

      <dl class="hero-figures" data-reveal style="--d:5">
        <?php foreach (HOME_HERO_STATS as $stat): ?>
          <div class="hero-figure">
            <dt><?= e($stat['value']) ?></dt>
            <dd><?= e($stat['label']) ?></dd>
          </div>
        <?php endforeach; ?>
      </dl>
    </div>

  </div>

  <?php /* Shown until the pointer first moves, then gone for good.
           aria-hidden because it is an instruction for a mouse, and there is
           nothing here for a keyboard or a screen reader to act on. */ ?>
  <div class="hero-hint" aria-hidden="true">
    <span class="hero-hint-dot"></span>
    <svg class="hero-hint-curve" viewBox="0 0 120 60" fill="none">
      <path d="M4 6 C 40 2, 78 14, 104 44" stroke="currentColor" stroke-width="2"
            stroke-linecap="round" stroke-dasharray="3 7"/>
      <path d="M96 30 L104 44 L88 44" stroke="currentColor" stroke-width="2"
            stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
    <span class="hero-hint-text">Move your mouse</span>
  </div>

  <nav class="hero-strip" aria-label="What we build">
    <div class="shell hero-strip-inner">
      <?php foreach ($heroStrip as [$ic, $top, $bottom, $href]): ?>
        <a class="hero-strip-item" href="<?= e(url($href)) ?>">
          <span class="hero-strip-icon"><?= icon($ic) ?></span>
          <span class="hero-strip-label"><?= e($top) ?><br><?= e($bottom) ?></span>
        </a>
      <?php endforeach; ?>
    </div>
  </nav>
</section>
