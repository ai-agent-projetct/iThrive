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

/**
 * The three panels are the "Start Your Project" gradient, cut into thirds.
 *
 * --grad runs #00F2FE at 0%, #4EA8FF at 45%, #9D4EDD at 100%. Sampling it at
 * thirds gives each panel its own slice, so scrolling the deck walks the same
 * gradient the button uses rather than showing three unrelated colours.
 *
 * The ink is the button's too. A full-screen panel in these colours is bright,
 * and white text on #00F2FE is unreadable — the brand already answers that by
 * pairing the gradient with #04121A, so the panels do the same.
 */
$tints = [
    ['#00F2FE', '#39BCFF'],
    ['#39BCFF', '#6C86F2'],
    ['#6C86F2', '#9D4EDD'],
];
?>
<div class="pstack" data-pstack>
  <?php foreach (PROCESS['steps'] as $i => $step): ?>
    <?php [$from, $to] = $tints[$i % 3]; ?>

    <section class="ppanel"
             style="--from: <?= e($from) ?>; --to: <?= e($to) ?>; --i: <?= $i ?>"
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

    <?php /* A spacer, not a wrapper. The panels have to stay direct children
             so they stick against the whole deck and keep stacking; wrapping
             each one scopes its sticky to that wrapper and it scrolls away
             instead of being covered. The spacer just buys scroll, so a panel
             sits readable before the next rises over it. */ ?>
    <?php if ($i < count(PROCESS['steps']) - 1): ?>
      <div class="ppanel-gap" aria-hidden="true"></div>
    <?php endif; ?>
  <?php endforeach; ?>
</div>
