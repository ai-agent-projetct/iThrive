<?php
/**
 * Product Modernization — the eighth bespoke service page.
 *
 * Built after absoluteapplabs.com/product-modernization-services, section for
 * section, in iThrive's own words: hero, the price of doing nothing, five ways
 * we build the advantage, the band, a five-step journey, six reasons, three
 * engagement options, five questions, close.
 *
 * ON COMPONENTS, and this page is where that account has to be honest.
 *
 * Eight components across the seven earlier pages were measured rendering
 * NOTHING, every one of them because it computed its layout inside
 * requestAnimationFrame or painted to a canvas. That has emptied the pool: the
 * Origin Kit registry is 403 components but overwhelmingly WebGL, and its fetch
 * quota (three a day, five a week) was spent building the Custom Product page.
 *
 * So this page uses ONE registry component, and it is one I had previously
 * written off by mistake:
 *
 *   reasons   Dot Grid Background   a pointer-reactive dot field
 *
 * It was recorded as "0 lit pixels of 1600 sampled" on the On-Demand page. That
 * was never the component. Its host had no height, and the same bug — a
 * percentage height resolving against a parent whose computed height is auto —
 * had already silently emptied the Custom Product page's bento. Given an
 * explicit height it paints correctly. motion-gallery, ripple and
 * curved-gallery-arc were re-tested the same way and genuinely do not.
 *
 * Everything else here is built rather than fetched, and that is not a
 * consolation prize: every CSS section on these eight pages has rendered, and
 * eight fetched components have not.
 *
 * Theme: the site's ramp, with this page's own type — Bricolage Grotesque,
 * Figtree and Space Mono. The motif is the STRANGLER FIG, which is the name of
 * the technique the page sells: a routing layer in front of the legacy system,
 * new services taking it over one endpoint at a time, both running until the
 * last one moves. The hero is that, made literal and put under your pointer.
 *
 * Pictures come from tools/modern-art.mjs; every slot prefers a photograph from
 * assets/img/modern/photo/ the moment one lands.
 */

declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/config.php';

$svc = service('product-modernization');

$page      = 'services';
$pageTitle = 'Product Modernization Services in Chennai';
$pageDesc  = 'iThrive Software modernises legacy products incrementally — a routing layer in front, '
           . 'services taken over one at a time, no big-bang rewrite and no frozen roadmap.';
$ogImage   = 'service-' . $svc['group_slug'];

/* ---------------------------------------------------------------------------
 * Content
 * ------------------------------------------------------------------------ */

/** The hero wall. Eight tiles, each with a legacy face and the modern one. */
$wall = [
    ['01', '09', 'Auth'],
    ['02', '10', 'Billing'],
    ['03', '11', 'Search'],
    ['04', '12', 'Reports'],
    ['05', '13', 'Orders'],
    ['06', '14', 'Admin'],
    ['07', '15', 'Notify'],
    ['08', '16', 'Files'],
];

$stats = [
    ['0 hrs',  'Planned downtime at cutover'],
    ['Always', 'Rollback path, every step'],
    ['Live',   'Feature delivery continues'],
    ['30-40%', 'Of team time lost to debt'],
];

/** The price of doing nothing — four. */
$risks = [
    ['01', 'Development slows down',
     'Every change touches something fragile, so every estimate grows a buffer. The team is not slower; the code is charging interest.'],
    ['02', 'Maintenance costs climb',
     'Old runtimes need specialists, unsupported dependencies need workarounds, and the hosting bill reflects an architecture nobody would choose today.'],
    ['03', 'The foundation is exposed',
     'An end-of-life framework stops getting security patches. The vulnerability is not hypothetical — it is published, and it is public.'],
    ['04', 'Customers feel it first',
     'Slow pages, dated flows and features competitors shipped two years ago. Churn is the last symptom to appear and the hardest to reverse.'],
];

/** Building the competitive advantage — five. */
$advantages = [
    ['01', 'UI/UX re-engineering',
     'We rebuild the interface around what people actually do with it, not around the screens that happen to exist. Old flows get shortened, dead ends get removed, and the design system that comes out of it makes the next change cheap.'],
    ['02', 'Infrastructure consulting',
     'An honest read on what to move, what to containerise, what to automate and what to leave exactly where it is. Not every workload belongs in the cloud, and we will say so.'],
    ['03', 'Cloud migration and optimisation',
     'On-premise to AWS, GCP or Azure, then the part most migrations skip: right-sizing, reserved capacity and autoscaling, so the bill goes down rather than sideways.'],
    ['04', 'Technology modernisation',
     'End-of-life runtimes and frameworks brought current — PHP, Python 2, old .NET, unsupported Node — with the accumulated security debt cleared as part of the same work.'],
    ['05', 'Architecture modernisation',
     'A monolith becomes services one seam at a time, chosen by what actually needs to deploy independently. We do not split a system into twelve pieces because a diagram looked better that way.'],
];

/** The journey — five steps. */
$journey = [
    ['01', 'Assessment and strategy',
     'Static analysis, dependency mapping and a candid report: what is worth keeping, what to wrap, what to delete. You get a phased roadmap with timelines and milestones before anyone touches the code.'],
    ['02', 'The test net',
     'Characterisation tests around current behaviour go in first. Until the old system is described by tests, nothing can move without the risk of silently changing what it does.'],
    ['03', 'Re-engineering',
     'A routing layer goes in front, and services take over endpoints one at a time. Both systems run together, every step is reversible, and your roadmap keeps shipping throughout.'],
    ['04', 'Enhancement',
     'Once the foundation holds, the product stops being merely functional. This is where the features you have been unable to build for two years become ordinary work.'],
    ['05', 'Ongoing support',
     'Monitoring, dependency upgrades and a named engineer. Modernisation that is not maintained becomes the next legacy system in about four years.'],
];

/** Why us — six. */
$reasons = [
    ['01', 'Strategic expertise',   'We have done the migration that goes wrong. The value is knowing which seam to cut first and which to leave alone until later.'],
    ['02', 'Minimal disruption',    'Both systems run in parallel behind a routing layer. There is no weekend cutover and no frozen feature roadmap.'],
    ['03', 'Forward-thinking stack','Chosen for the second year, not the launch. We will tell you when the exciting option is the one that will hurt in eighteen months.'],
    ['04', 'Ongoing support',       'A named engineer, response targets in writing, and a monthly report sent whether the reading flatters us or not.'],
    ['05', 'Quality assurance',     'Characterisation tests before anything moves, CI that blocks on a failure, and reconciliation with verifiable row counts on every data migration.'],
    ['06', 'Timely delivery',       'Two-week increments with something working at the end of each. A slipping migration is visible in a fortnight, not a quarter.'],
];

/** Engagement options — three, written for modernisation specifically. */
$models = [
    ['01', 'Fixed cost',
     'Right for a bounded phase — the assessment, a framework upgrade, a single service extracted. A fixed quote and a dated plan, with no hidden fees.',
     'Most clients start here, with the assessment.'],
    ['02', 'Time and materials',
     'Right for the migration itself, where what you find in the legacy system changes what comes next. Billed for hours worked, scaled up or down as the work moves.',
     'The honest model for the middle of a migration.'],
    ['03', 'Hybrid',
     'A fixed price for the phases that are genuinely settled, moving to hourly for enhancement and the things the codebase has not told you yet.',
     'What most modernisation programmes actually become.'],
];

$faqs = [
    ['Why should we modernise at all? It still works.',
     'Because "still works" and "stable" are different things. A product that has run for years without a catastrophe is usually not stable, it is stagnant: development is slowing, maintenance costs are climbing, the framework has stopped receiving security patches, and customers are comparing you to something built more recently. Modernisation reduces the operational bill, closes the vulnerabilities and buys back the agility to ship. If your system genuinely is fine, we will tell you that instead.'],
    ['How long does modernisation take?',
     'The assessment is two to three weeks and gives you a phased roadmap. After that it depends entirely on the seams: a framework and runtime upgrade is often six to ten weeks, extracting the first service from a monolith eight to sixteen, and a full architecture migration runs across quarters rather than weeks. Because the work is incremental you get value at the end of each phase rather than at the end of the programme, and you can stop between phases.'],
    ['Will it disrupt what we are running now?',
     'That is what the approach is designed to prevent. A routing layer goes in front of the legacy system and new services take over endpoints one at a time, with both running until the last one moves. Each step is feature-flagged and reversible, cutovers are blue-green, and planned downtime is zero. Your feature roadmap keeps shipping throughout — being asked to stand still for a year is why big-bang rewrites fail.'],
    ['Can it be shaped around our business?',
     'It has to be. The order of work is decided by your constraints, not by a reference architecture: the compliance deadline, the integration that breaks most often, the module your team most dreads touching. We sequence around those, and we are explicit about what we are deliberately not doing yet and why.'],
    ['What support do we get during and after?',
     'During: two-week increments, a shared channel, and a named engineer who has worked on your code. After: monitoring, dependency and security upgrades, and a rolling agreement with agreed response windows. The last part matters more than it sounds — a modernisation that is not maintained is simply the next legacy system, about four years out.'],
];

$extraHead = '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>'
    . '<link rel="stylesheet" href="https://fonts.googleapis.com/css2?'
    . 'family=Bricolage+Grotesque:opsz,wght@12..96,400;12..96,600;12..96,700;12..96,800'
    . '&family=Figtree:wght@400;500;600;700'
    . '&family=Space+Mono:wght@400;700&display=swap">'
    . '<link rel="stylesheet" href="' . e(asset('assets/css/modern.css')) . '">';

/* The five questions as schema, the same treatment the other bespoke pages get. */
$schemaExtra = [
    [
        '@type'      => 'FAQPage',
        'name'       => 'Product modernization — frequently asked questions',
        'mainEntity' => array_map(static fn (array $f): array => [
            '@type'          => 'Question',
            'name'           => $f[0],
            'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f[1]],
        ], $faqs),
    ],
];

require dirname(__DIR__) . '/includes/header.php';

$img = static function (string $rel): string {
    [$set, $file] = explode('/', $rel, 2);
    $photo = 'assets/img/modern/photo/' . $set . '-' . $file;

    return asset(is_file(ROOT_PATH . '/' . $photo) ? $photo : 'assets/img/modern/' . $rel);
};
?>

<div class="pm">

  <?php /* ---------------------------------------------------------------
           Hero — the migration wall

           Eight tiles, each a real two-sided 3D card: the legacy face in
           front, the modern one behind it. --front is how far the migration
           has reached along the diagonal, and each tile turns as the front
           passes its own --t. The whole thing is CSS min/max/calc, so at rest
           — no pointer, no script, no animation frame — the wall is already
           mid-migration and reads correctly. The pointer only moves --front.

           This is the page's argument rather than decoration: a routing layer
           in front, endpoints taken over one at a time, both sides running.
           --------------------------------------------------------------- */ ?>
    <?php /* ---------------------------------------------------------------
           Hero ? Interactive Dual-Layer Organic Scratch & Heal Hero
           --------------------------------------------------------------- */ ?>
  <section class="pm-hero pm-hero--interactive" id="heroStage">
    <!-- Back Layer: Robots WITH blanket at night -->
    <div class="pm-hero-bleed"></div>
    <img class="pm-hero-layer pm-hero-layer--back" id="heroBack"
         src="<?= e(asset('assets/img/buddy/buddy-neon-wide.webp')) ?>"
         alt="Robots with blanket at night" fetchpriority="high">
    <!-- Front Canvas Layer: Robots WITHOUT blanket -->
    <canvas class="pm-hero-layer pm-hero-layer--veil" id="heroVeil"></canvas>
    <div class="pm-hero-scrim" aria-hidden="true"></div>

    <div class="pm-shell pm-hero-grid">
      <div class="pm-hero-copy">
        <p class="pm-eyebrow"><span class="pm-mark" aria-hidden="true"></span>Product Modernization ? Chennai</p>

        <h1 class="pm-h1">
          Upgrade the architecture,<br>
          <em>not the whole business</em>
        </h1>

        <p class="pm-lead">
          Rewrites fail because they ask a company to stand still for a year. We put a routing layer
          in front of what you already run and move it across one capability at a time ? both
          systems live, every step reversible, your roadmap still shipping.
        </p>

        <div class="pm-actions">
          <button class="pm-btn pm-btn--primary" type="button"
                  data-modal-open data-modal-service="Product Modernization">
            Modernise my product<?= icon('arrow') ?>
          </button>
          <a class="pm-btn pm-btn--ghost" href="#pm-journey">See the journey</a>
        </div>

        <ul class="pm-stats">
          <?php foreach ($stats as [$v, $l]): ?>
            <li><strong><?= e($v) ?></strong><span><?= e($l) ?></span></li>
          <?php endforeach; ?>
        </ul>
      </div>

      <div class="pm-hero-cta-box">
        <div class="pm-hero-card">
          <p class="pm-hero-card-tag">? LIVE DUAL-STATE REVEAL</p>
          <h3>Interactive Strangler Architecture</h3>
          <p>Scratch or move your pointer over the canvas to peel back the legacy daytime layer and reveal the modernised night system underneath.</p>
          <p class="pm-hero-hint">? Move pointer across the hero to reveal</p>
        </div>
      </div>
    </div>
  </section>

  <style>
    .pm-hero--interactive {
      position: relative;
      min-height: clamp(680px, 92vh, 920px);
      display: flex;
      align-items: center;
      overflow: hidden;
      cursor: crosshair;
      padding: calc(var(--header-h, 76px) + 40px) 0 60px;
    }
    .pm-hero-bleed {
      position: absolute;
      inset: -5%;
      width: 110%;
      height: 110%;
      background: url('<?= e(asset('assets/img/buddy/buddy-neon-wide.webp')) ?>') center/cover no-repeat;
      filter: blur(48px) saturate(1.2);
      transform: scale(1.1);
      z-index: 0;
      pointer-events: none;
    }
    .pm-hero-layer {
      position: absolute;
      inset: 0;
      width: 100%;
      height: 100%;
      display: block;
      pointer-events: none;
    }
    .pm-hero-layer--back {
      object-fit: cover;
      object-position: center;
      z-index: 1;
    }
    .pm-hero-layer--veil {
      z-index: 2;
      pointer-events: auto;
    }
    .pm-hero-scrim {
      position: absolute;
      inset: 0;
      z-index: 3;
      pointer-events: none;
      background: linear-gradient(180deg,
        rgba(11, 7, 22, 0.72) 0%,
        rgba(11, 7, 22, 0.35) 40%,
        rgba(11, 7, 22, 0.85) 100%
      ),
      radial-gradient(ellipse at 25% 50%, rgba(11, 7, 22, 0.7) 0%, transparent 70%);
    }
    .pm-hero--interactive .pm-hero-grid {
      position: relative;
      z-index: 4;
      pointer-events: none;
    }
    .pm-hero--interactive .pm-actions,
    .pm-hero--interactive .pm-hero-card {
      pointer-events: auto;
    }
    .pm-hero-card {
      background: rgba(11, 7, 22, 0.65);
      backdrop-filter: blur(16px);
      -webkit-backdrop-filter: blur(16px);
      border: 1px solid rgba(255, 255, 255, 0.15);
      border-radius: 20px;
      padding: 28px;
      max-width: 380px;
      margin-left: auto;
      box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
    }
    .pm-hero-card-tag {
      font-family: var(--mono);
      font-size: 0.72rem;
      font-weight: 700;
      letter-spacing: 0.12em;
      color: var(--cyan);
      margin: 0 0 10px;
    }
    .pm-hero-card h3 {
      font-size: 1.25rem;
      font-weight: 700;
      margin: 0 0 10px;
      color: #fff;
    }
    .pm-hero-card p {
      font-family: var(--body);
      font-size: 0.92rem;
      line-height: 1.5;
      color: var(--dim);
      margin: 0 0 14px;
    }
    .pm-hero-hint {
      font-family: var(--mono) !important;
      font-size: 0.78rem !important;
      font-weight: 700;
      color: #fff !important;
      background: rgba(0, 242, 254, 0.12);
      border: 1px solid rgba(0, 242, 254, 0.25);
      padding: 6px 12px;
      border-radius: 999px;
      display: inline-block;
      margin: 0 !important;
      animation: pmPulse 2.5s infinite;
    }
    @keyframes pmPulse {
      0%, 100% { opacity: 0.6; }
      50% { opacity: 1; }
    }
    @media (max-width: 900px) {
      .pm-hero-card { margin-left: 0; margin-top: 24px; max-width: 100%; }
    }
  </style>

  <script>
  (function() {
    'use strict';
    const stage = document.getElementById('heroStage');
    const veil  = document.getElementById('heroVeil');
    if (!stage || !veil) return;
    const ctx = veil.getContext('2d');

    // First image: Robots on couch WITHOUT blanket
    const front = new Image();
    front.src = '<?= e(asset('assets/img/buddy/buddy-couch-noblanket.webp')) ?>';

    const MASK_MAX  = 440;
    const DECAY     = 0.982;
    const THRESHOLD = 0.5;
    const NOISE_AMT = 0.42;

    let W = 0, H = 0, mw = 0, mh = 0, cell = 1;
    let field, noise, maskCanvas, mctx, mdata;
    let last = null, energy = 0, running = false;

    function buildNoise() {
      const G = 26, g = new Float32Array((G + 1) * (G + 1));
      for (let i = 0; i < g.length; i++) g[i] = Math.random();
      const sm = t => t * t * (3 - 2 * t);
      noise = new Float32Array(mw * mh);
      for (let y = 0; y < mh; y++) {
        const fy = y / mh * G, y0 = Math.floor(fy), ty = sm(fy - y0);
        for (let x = 0; x < mw; x++) {
          const fx = x / mw * G, x0 = Math.floor(fx), tx = sm(fx - x0);
          const a = g[y0 * (G + 1) + x0],       b = g[y0 * (G + 1) + x0 + 1];
          const c = g[(y0 + 1) * (G + 1) + x0], d = g[(y0 + 1) * (G + 1) + x0 + 1];
          const top = a + (b - a) * tx, bot = c + (d - c) * tx;
          noise[y * mw + x] = top + (bot - top) * ty;
        }
      }
    }

    function resize() {
      const dpr = Math.min(window.devicePixelRatio || 1, 2);
      W = stage.clientWidth;
      H = stage.clientHeight;
      if (!W || !H) return;

      veil.width = Math.round(W * dpr);
      veil.height = Math.round(H * dpr);
      veil.style.width = W + 'px';
      veil.style.height = H + 'px';

      const s = MASK_MAX / Math.max(W, H);
      mw = Math.max(2, Math.round(W * s));
      mh = Math.max(2, Math.round(H * s));
      cell = W / mw;

      field = new Float32Array(mw * mh);
      maskCanvas = maskCanvas || document.createElement('canvas');
      maskCanvas.width = mw;
      maskCanvas.height = mh;
      mctx = maskCanvas.getContext('2d');
      mdata = mctx.createImageData(mw, mh);
      for (let i = 0; i < mw * mh; i++) {
        mdata.data[i * 4] = mdata.data[i * 4 + 1] = mdata.data[i * 4 + 2] = 255;
      }
      buildNoise();
      energy = 0;
      last = null;
      draw();
    }

    function fitRect(cw, ch, iw, ih) {
      const s = Math.max(cw / iw, ch / ih);
      const w = iw * s, h = ih * s;
      return { x: (cw - w) * 0.5, y: (ch - h) * 0.5, w, h };
    }

    function stamp(x, y) {
      const r = Math.max(14, Math.min(mw, mh) * 0.19), r2 = r * r;
      const x0 = Math.max(0, (x - r) | 0), x1 = Math.min(mw - 1, (x + r) | 0);
      const y0 = Math.max(0, (y - r) | 0), y1 = Math.min(mh - 1, (y + r) | 0);
      for (let j = y0; j <= y1; j++) {
        const dy = j - y;
        for (let i = x0; i <= x1; i++) {
          const dx = i - x, d2 = dx * dx + dy * dy;
          if (d2 > r2) continue;
          const f = 1 - d2 / r2;
          const k = j * mw + i;
          field[k] = Math.min(1.35, field[k] + f * f * 0.34);
        }
      }
      energy = 1;
    }

    function onMove(clientX, clientY) {
      const rect = stage.getBoundingClientRect();
      const x = (clientX - rect.left) / cell, y = (clientY - rect.top) / cell;
      if (last) {
        const dx = x - last.x, dy = y - last.y;
        const steps = Math.min(24, Math.ceil(Math.hypot(dx, dy) / 4));
        for (let i = 1; i <= steps; i++) stamp(last.x + dx * i / steps, last.y + dy * i / steps);
      }
      stamp(x, y);
      last = { x, y };
      if (!running) { running = true; requestAnimationFrame(tick); }
    }

    function draw() {
      if (!front.complete || !front.naturalWidth || !W || !H) return;
      const d = veil.width / W;
      ctx.setTransform(d, 0, 0, d, 0, 0);
      ctx.globalCompositeOperation = 'source-over';
      ctx.clearRect(0, 0, W, H);

      const iw = front.naturalWidth, ih = front.naturalHeight;
      const r = fitRect(W, H, iw, ih);
      ctx.drawImage(front, r.x, r.y, r.w, r.h);

      if (energy > 0) {
        const px = mdata.data;
        for (let i = 0, n = mw * mh; i < n; i++) {
          px[i * 4 + 3] = field[i] + noise[i] * NOISE_AMT > THRESHOLD ? 255 : 0;
        }
        mctx.putImageData(mdata, 0, 0);
        ctx.globalCompositeOperation = 'destination-out';
        ctx.imageSmoothingEnabled = true;
        ctx.drawImage(maskCanvas, 0, 0, W, H);
        ctx.globalCompositeOperation = 'source-over';
      }
    }

    function tick() {
      let max = 0;
      for (let i = 0, n = field.length; i < n; i++) {
        const v = field[i] * DECAY;
        field[i] = v < 0.002 ? 0 : v;
        if (v > max) max = v;
      }
      energy = max;
      draw();
      if (energy > 0) requestAnimationFrame(tick);
      else { running = false; last = null; }
    }

    front.addEventListener('load', draw);
    if (front.complete) draw();
    window.addEventListener('resize', resize);
    stage.addEventListener('pointermove', e => onMove(e.clientX, e.clientY));
    stage.addEventListener('pointerleave', () => { last = null; });
    stage.addEventListener('touchmove', e => {
      const t = e.touches[0]; if (t) onMove(t.clientX, t.clientY);
    }, { passive: true });

    resize();
  })();
  </script>

  <?php /* ---------------------------------------------------------------
           The price of doing nothing
           --------------------------------------------------------------- */ ?>
  <section class="pm-sec pm-risks">
    <div class="pm-shell">
      <div class="pm-head">
        <p class="pm-eyebrow"><span class="pm-mark" aria-hidden="true"></span>The cost of waiting</p>
        <h2 class="pm-title">The price of leaving it<br><em>exactly as it is</em></h2>
        <p class="pm-sub">
          It is easy to look at a product that has been in market for years and conclude that if it
          is not broken, it does not need fixing. It generates revenue, the team knows how to keep it
          running, and nothing has caught fire yet. What that usually describes is not stability but
          stagnation — and stagnation is the more expensive of the two, because technical debt
          charges interest whether or not anyone is looking at the account.
        </p>
      </div>

      <div class="pm-risk-grid">
        <?php foreach ($risks as $i => [$n, $title, $body]): ?>
          <article class="pm-risk" data-reveal style="--d:<?= $i % 4 ?>">
            <figure class="pm-risk-art">
              <img src="<?= e($img('risk/' . $n . '.jpg')) ?>" width="720" height="520"
                   alt="" loading="lazy" decoding="async">
            </figure>
            <div class="pm-risk-body">
              <span class="pm-num"><?= e($n) ?></span>
              <h3><?= e($title) ?></h3>
              <p><?= e($body) ?></p>
            </div>
            <?php /* The debt meter: fills further on each successive card. */ ?>
            <div class="pm-meter" aria-hidden="true"><span style="--f: <?= 42 + $i * 16 ?>%"></span></div>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           Building the advantage — a rolodex you turn

           Five panels on a cylinder. Same reason as the hero: the geometry is
           written from each panel's own --i, so the drum is correct before any
           script runs, and the buttons only change which face is fronted.
           --------------------------------------------------------------- */ ?>
  <section class="pm-sec pm-adv" data-drum>
    <div class="pm-shell">
      <div class="pm-head">
        <p class="pm-eyebrow"><span class="pm-mark" aria-hidden="true"></span>What we do</p>
        <h2 class="pm-title">Building your<br><em>competitive advantage</em></h2>
        <p class="pm-sub">Five ways a legacy product gets its future back. Turn the drum.</p>
      </div>

      <div class="pm-drum-wrap">
        <div class="pm-drum" data-drum-inner style="--n: <?= count($advantages) ?>;">
          <?php foreach ($advantages as $i => [$n, $title, $body]): ?>
            <article class="pm-panel<?= $i === 0 ? ' is-front' : '' ?>" data-panel="<?= $i ?>" style="--i: <?= $i ?>;">
              <figure>
                <img src="<?= e($img('adv/' . $n . '.jpg')) ?>" width="820" height="560"
                     alt="" loading="lazy" decoding="async">
              </figure>
              <div class="pm-panel-body">
                <span class="pm-num"><?= e($n) ?></span>
                <h3><?= e($title) ?></h3>
                <p><?= e($body) ?></p>
              </div>
            </article>
          <?php endforeach; ?>
        </div>

        <div class="pm-drum-nav" role="tablist" aria-label="Modernisation services">
          <?php foreach ($advantages as $i => [$n, $title]): ?>
            <button class="pm-drum-dot<?= $i === 0 ? ' is-on' : '' ?>" type="button" role="tab"
                    aria-selected="<?= $i === 0 ? 'true' : 'false' ?>"
                    data-drum-dot="<?= $i ?>"><span><?= e($n) ?></span><?= e($title) ?></button>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           Band
           --------------------------------------------------------------- */ ?>
  <section class="pm-band">
    <div class="pm-shell pm-band-inner">
      <div class="pm-band-front" aria-hidden="true"><i></i><i></i><i></i><i></i><i></i><i></i></div>
      <h2>Modernise before you have to.<br><em>The agility is the point.</em></h2>
      <button class="pm-btn pm-btn--primary" type="button"
              data-modal-open data-modal-service="Product Modernization">
        Talk to an expert<?= icon('arrow') ?>
      </button>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           The journey — five steps on a rail
           --------------------------------------------------------------- */ ?>
  <section class="pm-sec pm-journey" id="pm-journey" data-journey>
    <div class="pm-shell">
      <div class="pm-head">
        <p class="pm-eyebrow"><span class="pm-mark" aria-hidden="true"></span>The process</p>
        <h2 class="pm-title">Your modernisation<br><em>journey</em></h2>
        <p class="pm-sub">
          Five phases, and you can stop between any two of them with something working in your hands.
        </p>
      </div>

      <ol class="pm-rail">
        <?php foreach ($journey as $i => [$n, $title, $body]): ?>
          <li class="pm-stop<?= $i === 0 ? ' is-open' : '' ?>" data-stop
              role="button" tabindex="0" aria-expanded="<?= $i === 0 ? 'true' : 'false' ?>">
            <span class="pm-stop-dot" aria-hidden="true"></span>
            <div class="pm-stop-head">
              <span class="pm-num"><?= e($n) ?></span>
              <h3><?= e($title) ?></h3>
            </div>
            <div class="pm-stop-panel">
              <div>
                <figure>
                  <img src="<?= e($img('step/' . $n . '.jpg')) ?>" width="860" height="540"
                       alt="" loading="lazy" decoding="async">
                </figure>
                <p><?= e($body) ?></p>
              </div>
            </div>
          </li>
        <?php endforeach; ?>
      </ol>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           Why us — six, over Framer's pointer-reactive dot field

           The only registry component on this page. It was written off once as
           "0 lit pixels of 1600 sampled"; that was its host having no height,
           not the component. It has one here.
           --------------------------------------------------------------- */ ?>
  <section class="pm-sec pm-why">
    <div class="pm-why-dots"
         data-ok="dot-grid-bg"
         data-props='<?= e(json_encode([
             'dotColor'      => '#4EA8FF',
             'dotSize'       => 2.5,
             'dotSpacing'    => 30,
             'enableRevolve' => true,
             'orbitSpeed'    => 1.1,
             'impactRadius'  => 150,
             'scaleOnHover'  => 2.2,
         ], JSON_THROW_ON_ERROR)) ?>'></div>

    <div class="pm-shell">
      <div class="pm-head">
        <p class="pm-eyebrow"><span class="pm-mark" aria-hidden="true"></span>Why iThrive</p>
        <h2 class="pm-title">Why teams hand us<br>the <em>difficult system</em></h2>
        <p class="pm-sub">
          Businesses carrying a legacy product are usually not short of ideas — they are short of the
          room to build them. Every change is a struggle, the best engineers are the most frustrated,
          and the operational bill keeps rising for a system nobody would design this way today.
          Rebuilding the foundation is what gives the roadmap back.
        </p>
      </div>

      <div class="pm-why-grid">
        <?php foreach ($reasons as $i => [$n, $title, $body]): ?>
          <article class="pm-why-card" data-reveal style="--d:<?= $i % 3 ?>">
            <figure>
              <img src="<?= e($img('why/' . $n . '.jpg')) ?>" width="760" height="480"
                   alt="" loading="lazy" decoding="async">
            </figure>
            <span class="pm-num"><?= e($n) ?></span>
            <h3><?= e($title) ?></h3>
            <p><?= e($body) ?></p>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           Engagement options — three
           --------------------------------------------------------------- */ ?>
  <section class="pm-sec pm-models">
    <div class="pm-shell">
      <div class="pm-head pm-head--mid">
        <p class="pm-eyebrow"><span class="pm-mark" aria-hidden="true"></span>Engagement</p>
        <h2 class="pm-title">Flexible options,<br>because <em>migrations move</em></h2>
        <p class="pm-sub">
          A modernisation programme should not be boxed in by a contract written before anyone had
          read the codebase.
        </p>
      </div>

      <div class="pm-model-grid">
        <?php foreach ($models as $i => [$n, $title, $body, $when]): ?>
          <article class="pm-model" data-reveal style="--d:<?= $i ?>">
            <figure>
              <img src="<?= e($img('model/' . $n . '.jpg')) ?>" width="800" height="500"
                   alt="" loading="lazy" decoding="async">
            </figure>
            <div class="pm-model-body">
              <span class="pm-num"><?= e($n) ?></span>
              <h3><?= e($title) ?></h3>
              <p><?= e($body) ?></p>
              <p class="pm-model-when"><?= e($when) ?></p>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           FAQ
           --------------------------------------------------------------- */ ?>
  <section class="pm-sec pm-faq">
    <div class="pm-shell pm-faq-grid">
      <div class="pm-faq-side">
        <p class="pm-eyebrow"><span class="pm-mark" aria-hidden="true"></span>FAQ</p>
        <h2 class="pm-title">What people ask<br>before <em>they commit</em></h2>
        <figure class="pm-faq-art">
          <img src="<?= e($img('faq/01.jpg')) ?>" width="800" height="620"
               alt="" loading="lazy" decoding="async">
        </figure>
      </div>

      <div class="pm-faq-list">
        <?php foreach ($faqs as $i => [$q, $a]): ?>
          <details class="pm-faq-item"<?= $i === 0 ? ' open' : '' ?>>
            <?php /* The rail number is drawn by a CSS counter, not written here.
                     As real text inside <summary> it became part of the question:
                     screen readers announced "02 How long does modernisation
                     take?", and anything reading the rendered page — an answer
                     engine, our own coverage audit — saw the same. aria-hidden
                     does not help, because the text is still in the DOM. */ ?>
            <summary>
              <?= e($q) ?>
              <span class="pm-faq-mark" aria-hidden="true"></span>
            </summary>
            <div class="pm-faq-body"><p><?= e($a) ?></p></div>
          </details>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           Close
           --------------------------------------------------------------- */ ?>
  <section class="pm-close">
    <div class="pm-close-wash" aria-hidden="true"></div>
    <div class="pm-shell">
      <p class="pm-eyebrow"><span class="pm-mark" aria-hidden="true"></span>Next step</p>
      <h2>Want the system to evolve<br>as fast as <em>the roadmap?</em></h2>
      <p class="pm-close-lead">
        Tell us what the product runs on and which change your team most dreads making. The
        assessment comes back with a phased roadmap and a candid list of what to keep, what to wrap
        and what to delete — including the phases we think you should not start yet.
      </p>
      <div class="pm-actions pm-actions--mid">
        <button class="pm-btn pm-btn--primary" type="button"
                data-modal-open data-modal-service="Product Modernization">
          Book the assessment<?= icon('arrow') ?>
        </button>
      </div>
    </div>
  </section>

</div>

<script type="module" src="<?= e(url('assets/dist/originkit/originkit.js')) ?>"></script>
<script src="<?= e(asset('assets/js/modern-page.js')) ?>" defer></script>

<?php
require dirname(__DIR__) . '/includes/footer.php';
