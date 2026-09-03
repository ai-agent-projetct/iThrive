<?php
/**
 * Our 6-Step AI Development Process — the mobile page's roadmap, stood upright.
 *
 * The reference is the "Our Process Flow" section on
 * /services/mobile-app-development.php: a road that draws itself as you scroll,
 * a traveller riding it, and stops that pop in on arrival and recede once passed.
 * That one runs horizontally — the scene is sticky and slides sideways so
 * vertical scroll becomes travel along the road. This is the same object turned
 * 90 degrees, which removes the trick entirely: scrolling down IS travel, so the
 * scene needs no sticky and no sideways shift.
 *
 * Everything else is kept:
 *  - The road is a real SVG path. The unbuilt road is one stroke, the built road
 *    a second drawn on with strokeDashoffset, so the tarmac is genuinely laid
 *    ahead of the traveller rather than revealed from behind a mask.
 *  - The traveller's position comes from getPointAtLength on that same path, and
 *    each stop's arrival threshold is found by searching the path for its own
 *    point — nothing is hand-timed, so the curve can be redrawn and the cards
 *    still light in the right order.
 *  - Stops alternate either side of the road, rise on arrival and settle back
 *    once passed, so there is always one card worth reading.
 *
 * What is new here is the picture: the six images this section already carried
 * ride in the cards, which is what the brief asked for.
 *
 * The SVG stretches with preserveAspectRatio="none" and every stroke carries
 * vector-effect="non-scaling-stroke": the scene's height is fixed in pixels (a
 * card has to fit) while its width is the container's, so the two axes scale
 * differently and only non-scaling strokes survive that without going oval.
 * Because the box scales, a point in user units is a percentage of it, which is
 * how the cards and stems stay welded to the road at any width.
 *
 * Degrades: with no JavaScript the road sits unbuilt and every card is present,
 * in order, fully readable. Reduced motion gets the finished road and all six
 * cards up at once. Below 900px the road becomes a plain left rail and the
 * cards stack, because a snaking road needs width it does not have there.
 */

declare(strict_types=1);

/**
 * The scene's geometry, in SVG user units. ROW is the vertical pitch between
 * stops and therefore the height a card has to live in; the path below is drawn
 * to cross the centre line of each row, alternating side.
 */
$row  = 520;   // a card measures ~470px tall; the pitch has to clear it
$roadW = 1200;
$roadH = $row * 6;

/**
 * The road: a long vertical snake, ±90 either side of centre. Each stop sits
 * exactly on a control point, so the card coordinates below are the path's own
 * and not an approximation of it.
 *
 * The amplitude is a trade, and ±120 lost it: every unit the road swings toward
 * a card is a unit taken off that card's gutter, and at ±120 the outer edge of a
 * card sat 56px from the window on a 1440 screen — tighter than anything else on
 * the page. ±90 still reads as a snake and leaves each card 37% of the scene.
 */
$roadD = 'M 600 0'
       . ' C 600 100, 510 155, 510 260'
       . ' S 690 620, 690 780'
       . ' S 510 1140, 510 1300'
       . ' S 690 1660, 690 1820'
       . ' S 510 2180, 510 2340'
       . ' S 690 2700, 690 2860'
       . ' L 690 ' . $roadH;

/**
 * x/y are the point on the road; side follows from x. Everything else is the
 * content this section has always carried, plus a duration per stage.
 */
$steps = [
    ['num' => '01', 'x' => 510, 'y' => 260,  'side' => 'left',
     'icon' => 'fa-magnifying-glass-chart', 'tone' => 'cyan',
     'img' => 'human-with-tech-engineer', 'tag' => 'AUDIT & ROI',
     'title' => 'Discovery &amp; Feasibility',
     'lede'  => 'Before a line of code',
     'desc'  => 'We evaluate the proprietary data you already hold, audit token economics against real volumes, map the security boundary and rank the work by return rather than by novelty.',
     'time'  => '1–2 weeks',
     'out'   => 'Blueprint: AI system specification'],

    ['num' => '02', 'x' => 690, 'y' => 780,  'side' => 'right',
     'icon' => 'fa-database', 'tone' => 'blue',
     'img' => 'process-step-data-etl', 'tag' => 'VECTOR ETL',
     'title' => 'Data Ingestion &amp; ETL',
     'lede'  => 'The corpus, made usable',
     'desc'  => 'Document parsing, semantic chunking, high-dimensional embeddings and PII masking — the unglamorous half of every RAG system, and the half that decides whether it answers correctly.',
     'time'  => '2–3 weeks',
     'out'   => 'Lake: clean vector embeddings'],

    ['num' => '03', 'x' => 510, 'y' => 1300, 'side' => 'left',
     'icon' => 'fa-brain', 'tone' => 'magenta',
     'img' => 'human-ai-collaboration', 'tag' => 'LORA TUNING',
     'title' => 'Model Tuning &amp; RAG',
     'lede'  => 'Adapted, not just prompted',
     'desc'  => 'Domain LoRA and QLoRA fine-tuning, context compression, a private retrieval pipeline with reranking, and LangGraph flows where one model call is not enough to finish the job.',
     'time'  => '3–5 weeks',
     'out'   => 'Model: fine-tuned weights and an eval suite'],

    ['num' => '04', 'x' => 690, 'y' => 1820, 'side' => 'right',
     'icon' => 'fa-shield-virus', 'tone' => 'violet',
     'img' => 'process-step-security-audit', 'tag' => 'RED TEAMING',
     'title' => 'Safety &amp; Bias Audits',
     'lede'  => 'Broken here, not in production',
     'desc'  => 'Automated red-teaming against hallucination thresholds and jailbreaks, latency under stress, and the NIST AI Risk Management Framework applied as a checklist someone signs.',
     'time'  => '1–2 weeks',
     'out'   => 'Audit: zero-leakage certificate'],

    ['num' => '05', 'x' => 510, 'y' => 2340, 'side' => 'left',
     'icon' => 'fa-rocket', 'tone' => 'green',
     'img' => 'ithrive-innovation-lab', 'tag' => 'KUBERNETES',
     'title' => 'Deploy &amp; Integrate',
     'lede'  => 'Into your tenancy, not ours',
     'desc'  => 'Kubernetes services with vLLM or Triton acceleration on AWS, Azure or GCP, wired into the CRM and ERP you already run through connectors that need no downtime to install.',
     'time'  => '2–3 weeks',
     'out'   => 'Deploy: high-throughput production APIs'],

    ['num' => '06', 'x' => 690, 'y' => 2860, 'side' => 'right',
     'icon' => 'fa-gauge-high', 'tone' => 'cyan',
     'img' => 'case-study-fleet-ai', 'tag' => '24/7 MLOPS',
     'title' => 'MLOps &amp; SLA Support',
     'lede'  => 'The part that never ends',
     'desc'  => 'Real-time telemetry, drift detection with automated re-training triggers, cost per query on a dashboard, and a 99.8% uptime SLA with a person on the other end of it.',
     'time'  => 'Ongoing',
     'out'   => 'SLA: 24/7 uptime and telemetry'],
];
?>
<section id="process" class="vroad"
         data-vroad
         style="--road-w: <?= $roadW ?>; --road-h: <?= $roadH ?>;">

  <div class="container">
    <div class="vroad-head">
      <div class="section-tag"><span class="dot"></span><span>SYSTEMATIC 6-STEP SDLC</span></div>
      <h2 class="section-title">Our 6-Step <span class="text-gradient">AI Development Process</span></h2>
      <p class="vroad-sub">
        Six stages, in the order they actually happen. Scroll, and the road builds ahead of you.
      </p>
      <?php /* The same number the traveller is at, as a bar — the reference's
               own progress readout. Filled by the script. */ ?>
      <p class="vroad-progress" aria-hidden="true"><span></span></p>
    </div>
  </div>

  <div class="vroad-scene" data-vroad-scene>

    <svg class="vroad-svg"
         viewBox="0 0 <?= $roadW ?> <?= $roadH ?>"
         preserveAspectRatio="none"
         aria-hidden="true" focusable="false">
      <defs>
        <?php /* Vertical, so the gradient runs down the road rather than across
                 it — cyan into blue into violet, the logo's own ramp. */ ?>
        <linearGradient id="vroad-tarmac" x1="0" y1="0" x2="0" y2="1">
          <stop offset="0"   stop-color="#00E5FF"/>
          <stop offset="0.5" stop-color="#3B82F6"/>
          <stop offset="1"   stop-color="#A855F7"/>
        </linearGradient>
        <filter id="vroad-glow" x="-60%" y="-20%" width="220%" height="140%">
          <feGaussianBlur stdDeviation="10" result="b"/>
          <feMerge><feMergeNode in="b"/><feMergeNode in="SourceGraphic"/></feMerge>
        </filter>
      </defs>

      <?php /* The unbuilt road ahead. */ ?>
      <path class="vroad-base" d="<?= e($roadD) ?>" vector-effect="non-scaling-stroke"/>

      <?php /* The built road. The script sets stroke-dasharray/offset from the
               measured length, so with no script this simply stays undrawn. */ ?>
      <path class="vroad-live" data-vroad-path d="<?= e($roadD) ?>"
            filter="url(#vroad-glow)" vector-effect="non-scaling-stroke"/>

      <?php /* Centre line, laid with the road. */ ?>
      <path class="vroad-dashes" data-vroad-dashes d="<?= e($roadD) ?>"
            vector-effect="non-scaling-stroke"/>

      <?php /* A stem from the tarmac out to each card. Drawn at zero length and
               grown by the script on arrival. */ ?>
      <?php foreach ($steps as $s): ?>
        <?php $to = $s['side'] === 'left' ? $s['x'] - 70 : $s['x'] + 70; ?>
        <line class="vroad-stem" data-vroad-stem
              x1="<?= $s['x'] ?>" y1="<?= $s['y'] ?>"
              x2="<?= $s['x'] ?>" y2="<?= $s['y'] ?>"
              data-x2="<?= $to ?>" vector-effect="non-scaling-stroke"/>
      <?php endforeach; ?>
    </svg>

    <?php /* The traveller. Hidden until the script has a point for it. */ ?>
    <span class="vroad-traveller" data-vroad-traveller aria-hidden="true">
      <span class="vroad-traveller-core"></span>
    </span>

    <?php foreach ($steps as $s): ?>
      <?php
        /* Percentages of the scene box, which is exactly what a user-unit
           coordinate is once the SVG is stretched over it. */
        $topPc = round($s['y'] / $roadH * 100, 4);
        $gutPc = round(($s['side'] === 'left' ? $roadW - ($s['x'] - 70) : $s['x'] + 70) / $roadW * 100, 4);
      ?>
      <article class="vroad-stop vroad-stop--<?= e($s['side']) ?>"
               data-vroad-stop
               data-x="<?= $s['x'] ?>" data-y="<?= $s['y'] ?>"
               style="top: <?= $topPc ?>%; <?= $s['side'] === 'left' ? 'right' : 'left' ?>: <?= $gutPc ?>%;">

        <div class="vroad-photo">
          <img src="<?= e(asset('assets/img/aidev/' . $s['img'] . '.jpg')) ?>"
               alt="" width="1200" height="900" loading="lazy" decoding="async" draggable="false">
          <span class="vroad-badge">STEP <?= e($s['num']) ?></span>
          <span class="vroad-tag"><?= e($s['tag']) ?></span>
        </div>

        <div class="vroad-body">
          <header class="vroad-row">
            <span class="vroad-icon <?= e($s['tone']) ?>"><i class="fa-solid <?= e($s['icon']) ?>"></i></span>
            <h3 class="vroad-title"><?= $s['title'] ?></h3>
          </header>

          <p class="vroad-lede"><?= e($s['lede']) ?></p>
          <p class="vroad-desc"><?= e($s['desc']) ?></p>

          <footer class="vroad-foot">
            <span class="vroad-time"><i class="fa-regular fa-clock"></i><?= e($s['time']) ?></span>
            <span class="vroad-out"><?= e($s['out']) ?></span>
          </footer>
        </div>
      </article>
    <?php endforeach; ?>

  </div>
</section>
