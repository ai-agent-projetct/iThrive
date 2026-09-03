<?php
/**
 * The five AI functions, as the home page's own stacking deck.
 *
 * This is not a lookalike. It emits the same `.pstack` / `.ppanel` markup the
 * home page's "3-Step Execution: Discovery → Clarity → Execution" section uses,
 * wears the same CSS out of style.css, and is driven by the same
 * assets/js/process-panels.js — so the colour, the tilt and the word-lighting
 * are identical by construction rather than by resemblance.
 *
 * What that buys, and why the hand-rolled version before it was wrong:
 *
 * - THE BEND. A panel tips by exactly how far the NEXT panel has risen over it
 *   (the script's `--exit`, 0 to 1), about its own base — transform-origin
 *   50% 100%, rotateX up to 26deg. The version this replaces tipped each card
 *   on its own scroll progress, so it started folding while it was still the
 *   card being read, and had gone flat by the time anything covered it.
 * - THE COLOUR. Each panel is a slice of the logo gradient, cyan #03D1F5
 *   through #0B8AE2 and #2E45D2 into violet #8B3FEF, with its own ink because
 *   no single text colour is legible across that range.
 * - THE GAPS. A spacer sits BETWEEN panels and never after the last one, so the
 *   deck ends on the final panel instead of on an empty void — which is what
 *   the tail-spacer version left on screen.
 *
 * Content is the five services this page's OfferCatalog declares, so the markup
 * and the structured data say the same thing.
 */

declare(strict_types=1);

/** The five, in the order the page's OfferCatalog lists them. */
$functions = [
    [
        'number' => '01',
        'key'    => 'language',
        'title'  => 'Custom LLMs & RAG',
        'body'   => 'Models adapted to your own corpus rather than prompted at it — domain fine-tuning, '
                  . 'hybrid retrieval and reranking, with every answer traceable to the document it came from.',
        'output' => 'A grounded model with citations, and an eval suite that runs on every change',
        'points' => ['LoRA / QLoRA fine-tuning', 'Hybrid retrieval and reranking', 'Answer-level citations', 'Golden-dataset eval harness'],
    ],
    [
        'number' => '02',
        'key'    => 'autonomy',
        'title'  => 'Autonomous Agents',
        'body'   => 'Multi-step agents with explicit state, typed tool contracts and an approval gate '
                  . 'wherever a wrong move would cost something. Every run traced, costed and replayable.',
        'output' => 'An agent in production with a human gate on the steps that matter',
        'points' => ['LangGraph state machines', 'Typed tool contracts', 'Human-in-the-loop approval', 'Full run traces and cost'],
    ],
    [
        'number' => '03',
        'key'    => 'vision',
        'title'  => 'Vision & OCR',
        'body'   => 'Reading documents, inspecting product and classifying images at a volume nobody can '
                  . 'staff for — with the confidence score surfaced, so a person sees the cases the model is unsure about.',
        'output' => 'A pipeline that routes the uncertain cases to a human instead of guessing',
        'points' => ['YOLO / SAM detection', 'Document and invoice AI', 'Optical defect detection', 'Confidence-based routing'],
    ],
    [
        'number' => '04',
        'key'    => 'conversation',
        'title'  => 'Voicebots & Chatbots',
        'body'   => 'Assistants that answer in the language the customer actually speaks, grounded in your '
                  . 'documentation, escalating cleanly to a human the moment they should stop guessing.',
        'output' => 'An assistant across 25+ languages that knows when to hand over',
        'points' => ['25+ Indian and world languages', 'Speech to text and back', 'Grounded, sourced answers', 'Clean human escalation'],
    ],
    [
        'number' => '05',
        'key'    => 'modernisation',
        'title'  => 'AI Modernisation',
        'body'   => 'Intelligence added to the platform you already run, as a service alongside it rather '
                  . 'than a rewrite through it — behind a feature flag, switched off in one call.',
        'output' => 'Your existing product, smarter, with the old path still one flag away',
        'points' => ['Sidecar architecture', 'Behind a feature flag', 'No rewrite of what earns', 'Rollback in one call'],
    ],
];

/**
 * The panels are the logo's gradient, cut into slices — the same four stops and
 * the same per-panel ink the home page uses, so the two decks are the same
 * colour. Five panels across a three-slice ramp, so the cycle repeats.
 */
$tints = [
    ['#03D1F5', '#0B8AE2', '#04121A', '#FFFFFF'],
    ['#0B8AE2', '#2E45D2', '#FFFFFF', '#0B1020'],
    ['#2E45D2', '#8B3FEF', '#FFFFFF', '#0B1020'],
];
?>
<section id="functions" class="section-padding stackrev">
  <div class="container">

    <div class="stackrev-head">
      <span class="section-badge"><span class="dot"></span> WHAT WE ACTUALLY BUILD</span>
      <h2 class="section-title">The Five <span class="gradient-text">AI Functions</span> We Ship</h2>
      <p class="section-subtitle">
        Not a menu of everything possible — the five things this team puts into production,
        and what each one is held to once it is there.
      </p>
    </div>

    <div class="pstack" data-pstack>
      <?php foreach ($functions as $i => $fn): ?>
        <?php [$from, $to, $ink, $onInk] = $tints[$i % 3]; ?>

        <section class="ppanel"
                 style="--from: <?= e($from) ?>; --to: <?= e($to) ?>; --ink: <?= e($ink) ?>; --on-ink: <?= e($onInk) ?>; --i: <?= $i ?>"
                 aria-labelledby="fn-<?= e($fn['key']) ?>">

          <div class="ppanel-inner">
            <header class="ppanel-head">
              <h3 class="ppanel-title" id="fn-<?= e($fn['key']) ?>"><?= e($fn['title']) ?></h3>
              <span class="ppanel-num" aria-hidden="true"><?= e($fn['number']) ?></span>
            </header>

            <div class="ppanel-cols">
              <div class="ppanel-col">
                <p class="ppanel-label"><span class="ppanel-dot" aria-hidden="true"></span>What it is</p>
                <?php /* data-lit is split into words by the script and lit as the
                         panel passes; the sentence is complete in the markup, so
                         with no JavaScript it simply reads. */ ?>
                <p class="ppanel-say" data-lit><?= e($fn['body']) ?></p>
              </div>

              <div class="ppanel-col">
                <p class="ppanel-label"><span class="ppanel-dot" aria-hidden="true"></span>What you get</p>
                <p class="ppanel-say" data-lit><?= e($fn['output']) ?></p>
              </div>
            </div>

            <div class="ppanel-cta">
              <a class="ppanel-pill" href="<?= e(url('contact.php')) ?>">
                Talk to an engineer<?= icon('arrow') ?>
              </a>
            </div>

            <ul class="ppanel-points">
              <?php foreach ($fn['points'] as $point): ?>
                <li><span class="ppanel-tick"><?= icon('check') ?></span><?= e($point) ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
        </section>

        <?php /* A spacer, not a wrapper — wrapping a panel scopes its sticky to
                 that wrapper and it scrolls away instead of being covered. And
                 only BETWEEN panels: a spacer after the last one is the empty
                 void this section used to end on. */ ?>
        <?php if ($i < count($functions) - 1): ?>
          <div class="ppanel-gap" aria-hidden="true"></div>
        <?php endif; ?>
      <?php endforeach; ?>
    </div>

  </div>
</section>
