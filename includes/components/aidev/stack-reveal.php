<?php
/**
 * The functions, as a stack that builds itself as you scroll.
 *
 * Modelled on stack-scroll-reveal.framer.ai. Measured rather than guessed: that
 * component is four `position: sticky` cards pinned at staggered offsets
 * (0, 265, 270, 275px) carrying STATIC scales (1.12, 1.071, 0.956, 0.838). The
 * scales never change as you scroll — so the whole pile-up is plain CSS
 * stickiness, not a scroll-driven animation, and it needs no JavaScript here
 * either. Each card pins a little lower and a little smaller than the one
 * before, so they collect into a deck with every card's head still showing.
 *
 * The tilt as a card arrives is the one genuinely animated part, and it runs on
 * a scroll-driven `animation-timeline: view()`. Where that is unsupported the
 * cards simply arrive upright — the stack, which is the point, is unaffected.
 *
 * The reference fills its cards with case studies. These are what this page
 * actually sells: the five services its structured data declares, so the markup
 * and the schema tell an answer engine the same story.
 *
 * @see assets/css/ai-dev-fixes.css for the stack itself.
 */

declare(strict_types=1);

/** The five, in the order the page's OfferCatalog lists them. */
$functions = [
    [
        'tag'   => 'Language',
        'title' => 'Custom LLM fine-tuning and RAG pipelines',
        'body'  => 'Models adapted to your own corpus rather than prompted at it — domain '
                 . 'fine-tuning, hybrid retrieval and reranking, with every answer traceable '
                 . 'to the document it came from.',
        'chips' => ['LoRA / QLoRA', 'Hybrid retrieval', 'Citations', 'Eval harness'],
    ],
    [
        'tag'   => 'Autonomy',
        'title' => 'Autonomous agent workflows',
        'body'  => 'Multi-step agents with explicit state, typed tool contracts and an approval '
                 . 'gate wherever a wrong move would cost something. Every run traced, costed '
                 . 'and replayable.',
        'chips' => ['LangGraph', 'Tool contracts', 'Human-in-the-loop', 'Full traces'],
    ],
    [
        'tag'   => 'Vision',
        'title' => 'Computer vision and OCR intelligence',
        'body'  => 'Reading documents, inspecting product and classifying images at a volume '
                 . 'nobody can staff for — with the confidence score surfaced, so a person sees '
                 . 'the cases the model is unsure about.',
        'chips' => ['YOLO / SAM', 'Document AI', 'Defect detection', 'Confidence routing'],
    ],
    [
        'tag'   => 'Conversation',
        'title' => 'Multilingual voicebots and chatbots',
        'body'  => 'Assistants that answer in the language the customer actually speaks, '
                 . 'grounded in your documentation, escalating cleanly to a human the moment '
                 . 'they should stop guessing.',
        'chips' => ['25+ languages', 'Speech to text', 'Grounded answers', 'Clean escalation'],
    ],
    [
        'tag'   => 'Modernisation',
        'title' => 'Enterprise system AI modernisation',
        'body'  => 'Intelligence added to the platform you already run, as a service alongside '
                 . 'it rather than a rewrite through it — behind a feature flag, switched off '
                 . 'in one call.',
        'chips' => ['Sidecar architecture', 'Feature flagged', 'No rewrite', 'Rollback in one call'],
    ],
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

    <?php /* --i drives both the pin offset and the scale, so adding a sixth card
             needs nothing here but a sixth row in the array above. */ ?>
    <div class="stackrev-list">
      <?php foreach ($functions as $i => $fn): ?>
        <article class="stackrev-card" style="--i:<?= (int) $i ?>">
          <div class="stackrev-card-top">
            <span class="stackrev-num"><?= sprintf('%02d', $i + 1) ?></span>
            <span class="stackrev-tag"><?= e($fn['tag']) ?></span>
          </div>

          <h3 class="stackrev-title"><?= e($fn['title']) ?></h3>
          <p class="stackrev-body"><?= e($fn['body']) ?></p>

          <ul class="stackrev-chips">
            <?php foreach ($fn['chips'] as $chip): ?>
              <li><?= e($chip) ?></li>
            <?php endforeach; ?>
          </ul>
        </article>
      <?php endforeach; ?>

      <?php /* The last card's runway.
               A sticky element is constrained by its parent's CONTENT box, and
               it cannot be pushed past that box minus its own bottom margin. So
               giving the last card a margin does nothing: the margin pushes the
               content edge down and is then subtracted straight back off, and
               its sticky window stays at zero — measured at 41px against 762px
               for the card before it, which is why the fifth one scrolled by
               without ever pinning. Padding on the list is no use either, being
               outside the content box. It needs a SIBLING, and this is it. */ ?>
      <span class="stackrev-tail" aria-hidden="true"></span>
    </div>

  </div>
</section>
