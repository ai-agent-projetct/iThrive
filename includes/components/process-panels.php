<?php
/**
 * The three steps as stacking full-screen panels.
 *
 * After averlo.co's service section, measured rather than guessed at: each
 * panel is a full-viewport gradient card that sticks while the next one slides
 * up over it, so the section reads as a deck being dealt rather than a list
 * being scrolled. Inside each: the title top-left, an oversized step number
 * top-right, a two-column detail row divided by hairlines, a pill link, and a
 * row of deliverables along the bottom.
 *
 * The one behaviour worth naming is the text: the statement in each column
 * starts dim and lights word by word as the panel crosses the viewport. That
 * is what assets/js/process-panels.js does, and it is the detail that makes the
 * section feel authored rather than laid out.
 *
 * Content is PROCESS from content.php — the same three steps the process page
 * uses, so the two can never disagree.
 */

declare(strict_types=1);

/** A hue per step, running cyan to violet across the deck. */
$tints = [
    ['#062b3a', '#0b4f63', '#00F2FE'],
    ['#0b1f4d', '#1d3b8f', '#4EA8FF'],
    ['#2a1150', '#5b2a94', '#9D4EDD'],
];
?>
<div class="pstack" data-pstack>
  <?php foreach (PROCESS['steps'] as $i => $step): ?>
    <?php [$from, $to, $accent] = $tints[$i % 3]; ?>

    <section class="ppanel"
             style="--from: <?= e($from) ?>; --to: <?= e($to) ?>; --accent: <?= e($accent) ?>; --i: <?= $i ?>"
             aria-labelledby="pstep-<?= e($step['key']) ?>">

      <div class="ppanel-inner">
        <header class="ppanel-head">
          <h3 class="ppanel-title" id="pstep-<?= e($step['key']) ?>">
            <?= e($step['title']) ?>
          </h3>
          <span class="ppanel-num" aria-hidden="true"><?= e($step['number']) ?></span>
        </header>

        <div class="ppanel-cols">
          <div class="ppanel-col">
            <p class="ppanel-label"><span class="ppanel-dot" aria-hidden="true"></span>What happens</p>
            <?php /* data-lit is split into words by the script and lit as the
                     panel passes. The text is plain and complete in the markup,
                     so with no JavaScript it simply reads. */ ?>
            <p class="ppanel-say" data-lit><?= e($step['body']) ?></p>
          </div>

          <div class="ppanel-col">
            <p class="ppanel-label"><span class="ppanel-dot" aria-hidden="true"></span>What you get</p>
            <p class="ppanel-say" data-lit><?= e($step['output']) ?></p>
          </div>
        </div>

        <div class="ppanel-cta">
          <a class="ppanel-pill" href="<?= e(url('company/process.php')) ?>">
            Explore in detail<?= icon('arrow') ?>
          </a>
        </div>

        <ul class="ppanel-points">
          <?php foreach ($step['points'] as $point): ?>
            <li><span class="ppanel-tick"><?= icon('check') ?></span><?= e($point) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    </section>
  <?php endforeach; ?>
</div>
