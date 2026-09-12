<?php
/**
 * Dedicated Engineering Team — the fourth service page off the shared layout.
 *
 * Built after absoluteapplabs.com/dedicated-software-development-team, section
 * for section, in iThrive's own words.
 *
 * THE CONSTRAINT ON THIS ONE: no component may repeat from the other three
 * bespoke pages. Every Framer component below is mounted here for the first
 * time on this site, and the two that were vendored longest ago — Curved
 * Gallery Arc and Apple Glass Stack — had been registered for months without
 * ever appearing on a page.
 *
 *   hero        Curved Gallery Arc    a draggable 3D arc of the ten roles
 *   why         Circle Expand Card    four cards that open from a circle
 *   roles       Image Scroller        the ten disciplines, scrolled
 *   band        Gradient Bars         a bar field behind the quote
 *   process     Sticky Scroll Story   the four steps, one at a time
 *   proof       Apple Glass Stack     five commitments in glass
 *   close       Ambient Background    drifting blobs under the last word
 *
 * SPLINE: the hero is wired for it and will use it the moment a scene exists.
 * Spline has no authoring API — a .splinecode URL is only produced by the
 * Spline editor against an account — so this cannot be generated from here.
 * includes/components/spline-hero.php already handles the embed; set
 * SPLINE_SCENE (or SPLINE_SCENE_TEAM for this page alone) and the arc below
 * steps aside for it. Until then the arc is the live 3D hero, so the page is
 * complete either way rather than waiting on a scene that may never come.
 *
 * Theme: the site's own ramp, unchanged — #00F2FE into #4EA8FF into #9D4EDD,
 * exactly as style.css defines it. This page shipped once in amber on the
 * theory that a colour of its own would keep four dark pages apart; it did,
 * and it also stopped looking like the same website. What separates this page
 * is its layout, its components and its roster motif, not its hue.
 *
 * Every picture is rendered by tools/team-art.mjs and every slot prefers a
 * photograph from assets/img/team/photo/ the moment one lands.
 */

declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/config.php';

$svc = service('dedicated-engineering-team');

$page      = 'services';
$pageTitle = 'Hire a Dedicated Engineering Team in Chennai';
$pageDesc  = 'iThrive Software embeds senior engineers into your workflow — your roadmap, your '
           . 'repository, your standards, and a team you can scale up or down without a hiring cycle.';
$ogImage   = 'service-' . $svc['group_slug'];

/* ---------------------------------------------------------------------------
 * Content
 * ------------------------------------------------------------------------ */

$stats = [
    ['6+',   'Years placing engineering teams'],
    ['90%',  'Of clients extend the engagement'],
    ['70%',  'Less than a local senior hire'],
    ['2wk',  'From call to team in your standup'],
];

/** Why build alone — four. */
$why = [
    ['01', 'Seniors, not learners',
     'Seven to twelve years each. People who have already made the expensive mistakes somewhere else and will not be making them on your product.'],
    ['02', 'Shorter release cycles',
     'A team that adopts your cadence rather than importing its own. Agile in the sense of shipping fortnightly, not in the sense of a certificate.'],
    ['03', 'You keep the wheel',
     'You set the roadmap and the priorities. We supply the people, the standards and complete visibility of what they are doing with your time.'],
    ['04', 'Scale without a hiring cycle',
     'Add two engineers for a quarter, drop back after. No notice periods, no severance, no eighteen-month commitment for eight weeks of work.'],
];

/** The ten disciplines. */
$roles = [
    ['01', 'Front-end engineers',   'React and TypeScript to a design system, accessible and measured against a performance budget rather than a screenshot.'],
    ['02', 'Back-end engineers',    'Python, Java and Go behind APIs that hold up — designed for the failure modes, not just the happy path.'],
    ['03', 'UI/UX designers',       'Research, wireframes and a system your engineers can actually build, handed over as components rather than pictures.'],
    ['04', 'Full-stack engineers',  'People who can carry a feature from schema to screen without three handovers and a week of waiting.'],
    ['05', 'QA engineers',          'Automation-first, in your pipeline. The point is catching it in CI, not filing it after a customer did.'],
    ['06', 'Data engineers',        'Pipelines, warehousing and the modelling underneath them, so the numbers a dashboard shows can be trusted.'],
    ['07', 'DevOps engineers',      'CI/CD, infrastructure as code and observability, with rollback rehearsed rather than assumed.'],
    ['08', 'AI engineers',          'Retrieval, agents and evaluation harnesses — the part that decides whether an AI feature survives contact with users.'],
    ['09', 'Business analysts',     'The person who works out what the requirement actually is before eight people build the wrong version of it.'],
    ['10', 'Delivery managers',     'One person accountable for the cadence, the risks and the honest status — including when it is not good.'],
];

/** How the engagement runs — four steps. */
$steps = [
    ['01', 'Tell us the shape',
     'A call about the work, not a CV parade. What you are building, what your team already covers, and the gap you actually need filled.'],
    ['02', 'We assemble it',
     'Within about two weeks you meet named people with the skills the work needs — not a pool, not a promise, the individuals who will do it.'],
    ['03', 'They join your cadence',
     'Your standup, your board, your repository, your definition of done. They report the way your own engineers report.'],
    ['04', 'Scale as it changes',
     'Grow the team for a push, shrink it after. Thirty days\' notice either way and no penalty for being honest about what you need.'],
];

/** Five commitments. */
$proof = [
    ['Transparent pricing',      'A rate card, per role, per month. No margin hidden inside a blended day rate you cannot interrogate.'],
    ['Your cadence, not ours',   'We adopt your rituals and tooling. An embedded team that needs its own process is not embedded.'],
    ['People in weeks',          'Roughly two weeks from the call to somebody in your standup, because the bench is real rather than aspirational.'],
    ['The whole discipline',     'Ten roles from one place, so the gap you find in month three does not start a new procurement.'],
    ['Everything is yours',      'Repository, infrastructure and documentation in your accounts from day one. Nothing to extract if we part ways.'],
];

/** Hiring models — three. */
$models = [
    ['01', 'Fixed cost',
     'A defined scope, a fixed price and a date. Right when the requirement is genuinely settled and you want the risk on our side of the table.',
     ['Defined scope', 'Fixed price', 'Risk on us']],
    ['02', 'Time and materials',
     'You pay for the engineers you have, by the month, and change your mind as often as the product needs you to. Most engagements end up here.',
     ['Monthly', 'Scale freely', 'No fixed scope']],
    ['03', 'Hybrid',
     'A fixed-price core with a flexible team around it. The parts you are sure of are priced; the parts still moving are not forced to pretend.',
     ['Fixed core', 'Flexible edge', 'Predictable floor']],
];

$faqs = [
    ['What can your dedicated engineers actually do?',
     'The ten disciplines above, and they are staffed as a team rather than as individuals — a front-end engineer here comes with the back-end, QA and DevOps people who make their work shippable. Where we do not have the skill in-house we say so rather than putting a near-miss on the invoice.'],
    ['Can we scale the team up or down mid-project?',
     'Yes, on thirty days\' notice in either direction, and without a penalty. That flexibility is most of the reason to use an embedded team rather than hire — if changing your mind is expensive you have just bought the worst parts of both models.'],
    ['When is a dedicated team the wrong answer?',
     'When the work is genuinely finite and well specified — that is a fixed-price project, and we will tell you so. A dedicated team earns its keep when the roadmap is long enough that the context your engineers build up is worth more than the flexibility you give away.'],
    ['How does hiring actually work?',
     'A call, then a written proposal naming roles, rates and start dates. You interview the individuals if you want to; most clients interview the first two and stop. Nobody is billed before they are in your standup.'],
    ['Who manages them day to day?',
     'You do, on the work. We handle employment, performance, cover for leave and replacement if somebody is not right — and replacement is our cost, not yours. You should be directing engineers, not administering them.'],
];

$extraHead = '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>'
    . '<link rel="stylesheet" href="https://fonts.googleapis.com/css2?'
    . 'family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;600;700'
    . '&family=Space+Grotesk:wght@400;500;600;700&display=swap">'
    . '<link rel="stylesheet" href="' . e(asset('assets/css/team.css')) . '">';

require dirname(__DIR__) . '/includes/header.php';

/** Photograph first, drawn composition second — the site-wide convention. */
$img = static function (string $rel): string {
    [$set, $file] = explode('/', $rel, 2);
    $photo = 'assets/img/team/photo/' . $set . '-' . $file;

    return asset(is_file(ROOT_PATH . '/' . $photo) ? $photo : 'assets/img/team/' . $rel);
};

/** Absolute, for components that only accept an http(s) src. */
$imgAbs = static fn (string $rel): string => site_origin() . $img($rel);

/* This page's own Spline scene if one is set, otherwise the shared one. */
$splineScene = (defined('SPLINE_SCENE_TEAM') && SPLINE_SCENE_TEAM !== '')
    ? SPLINE_SCENE_TEAM
    : (defined('SPLINE_SCENE') ? SPLINE_SCENE : '');
?>

<div class="tm">

  <?php /* ---------------------------------------------------------------
           Hero — Dedicated Engineering Team Copy with 3D Metallic Cube Grid
           --------------------------------------------------------------- */ ?>
  <section class="tm-hero">
    <div class="tm-shell tm-hero-grid">
      <div class="tm-hero-copy">
        <p class="tm-eyebrow"><span class="tm-seat" aria-hidden="true"></span>Dedicated Engineering Team · Chennai</p>

        <h1 class="tm-h1">
          Senior engineers, in your<br>
          standup <span class="tm-grad">in two weeks</span>
        </h1>

        <p class="tm-lead">
          Not an agency at arm's length and not a CV pool. A named team of seven-to-twelve-year
          engineers who take your roadmap, your repository and your definition of done — and who you
          can grow or shrink on thirty days' notice as the work changes.
        </p>

        <div class="tm-actions">
          <button class="tm-btn tm-btn--primary" type="button"
                  data-modal-open data-modal-service="Dedicated Engineering Team">
            Get your team<?= icon('arrow') ?>
          </button>
          <a class="tm-btn tm-btn--ghost" href="#tm-roles">See the ten roles</a>
        </div>

        <ul class="tm-stats">
          <?php foreach ($stats as [$v, $l]): ?>
            <li><strong><?= e($v) ?></strong><span><?= e($l) ?></span></li>
          <?php endforeach; ?>
        </ul>
      </div>

      <div class="tm-hero-stage tm-metallic-hero" id="stage">
        <!-- 3D WebGL Metallic Cube Grid Canvas -->
        <canvas id="metallic-cube-grid-canvas"></canvas>
        <div class="tm-metallic-vignette" aria-hidden="true"></div>

        <!-- Floating Interactive Control Dock with Drag Hint -->
        <div class="tm-metallic-controls">
          <div class="tm-ctrl-hint" title="Click and drag to rotate the 3D cube grid in real time">
            <span class="tm-hint-icon">✦</span>
            <span>Drag to Orbit</span>
          </div>
          <div class="tm-ctrl-divider" aria-hidden="true"></div>
          <div class="tm-ctrl-group">
            <span class="tm-ctrl-label">Mode:</span>
            <button type="button" class="tm-ctrl-pill is-active" data-cube-preset="Wave">Wave</button>
            <button type="button" class="tm-ctrl-pill" data-cube-preset="Rubik">Rubik</button>
            <button type="button" class="tm-ctrl-pill" data-cube-preset="Float">Float</button>
            <button type="button" class="tm-ctrl-pill" data-cube-preset="Helix">Helix</button>
            <button type="button" class="tm-ctrl-pill" data-cube-preset="Pulse">Pulse</button>
            <button type="button" class="tm-ctrl-pill" data-cube-preset="Scatter">Scatter</button>
          </div>
          <div class="tm-ctrl-divider" aria-hidden="true"></div>
          <div class="tm-ctrl-group">
            <span class="tm-ctrl-label">Finish:</span>
            <button type="button" class="tm-ctrl-pill is-active" data-cube-matcap="PolishedMetal">Chrome</button>
            <button type="button" class="tm-ctrl-pill" data-cube-matcap="TechBlue">Tech Blue</button>
            <button type="button" class="tm-ctrl-pill" data-cube-matcap="GoldMetal">Gold</button>
            <button type="button" class="tm-ctrl-pill" data-cube-matcap="DarkMetal">Dark</button>
          </div>
        </div>
      </div>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           The opening argument
           --------------------------------------------------------------- */ ?>
  <section class="tm-sec tm-open">
    <div class="tm-shell tm-open-grid">
      <div>
        <p class="tm-eyebrow"><span class="tm-seat" aria-hidden="true"></span>How this works</p>
        <h2 class="tm-title">Tell us the shape of the gap.<br><em>We staff it, you steer it.</em></h2>
      </div>
      <div class="tm-open-copy">
        <p>
          Every product hits the same wall eventually: the roadmap is longer than the team. Hiring
          takes a quarter and commits you for years; an agency takes the work away and hands back
          something you did not watch being built. Neither is what you wanted.
        </p>
        <p>
          An embedded team is the third option. The engineers are ours to employ, cover and replace,
          and yours to direct — same standup, same board, same repository, same definition of done.
          You get the capacity without the hiring cycle and the visibility without the management
          overhead.
        </p>
      </div>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           Why build alone — Framer's Circle Expand Card, four of them
           The 4 highlight colors extracted from user's uploaded theme swatches:
           1: #1bd7fe (Electric Cyan), 2: #3fb6ff (Sky Blue),
           3: #6094f8 (Periwinkle Blue), 4: #7976ec (Cyber Violet)
           --------------------------------------------------------------- */ ?>
  <?php
  $whyColors = ['#1bd7fe', '#3fb6ff', '#6094f8', '#7976ec'];
  ?>
  <section class="tm-sec tm-why">
    <div class="tm-shell">
      <div class="tm-head">
        <p class="tm-eyebrow"><span class="tm-seat" aria-hidden="true"></span>Why not alone</p>
        <h2 class="tm-title">Why build alone, when the<br>expertise is <em>a team away</em></h2>
        <p class="tm-sub">
          Cross-functional teams ship roughly two and a half times faster than the same people
          working in sequence. Hover a card — it opens from the circle.
        </p>
      </div>

      <div class="tm-why-grid">
        <?php foreach ($why as $i => [$n, $title, $body]): ?>
          <?php $cardAccent = $whyColors[$i % 4]; ?>
          <figure class="tm-why-card" data-reveal style="--d:<?= $i % 4 ?>; --why-accent: <?= e($cardAccent) ?>;">
            <div class="tm-why-host"
                 data-ok="circle-expand-card"
                 data-props='<?= e(json_encode([
                     'image'              => ['src' => $imgAbs('why/' . $n . '.jpg'), 'alt' => $title],
                     'category'           => $n,
                     'title'              => $title,
                     'subtitle'           => '',
                     'link'               => '',
                     'newTab'             => false,
                     'layout'             => 'titleBottomLeft',
                     'overlay'            => 'rgba(8, 10, 16, 0.42)',
                     'cardRadius'         => '18px',
                     'padding'            => '22px',
                     'showTextMask'       => true,
                     'textMaskColor'      => 'rgba(8, 10, 16, 0.55)',
                     'categoryColor'      => $cardAccent,
                     'categoryHoverColor' => '#080a10',
                     'iconGroup'          => [
                         'backgroundColor'     => $cardAccent,
                         'backgroundHoverColor' => $cardAccent,
                         'size'                => 24,
                         'padding'             => '15px',
                     ],
                 ], JSON_THROW_ON_ERROR)) ?>'></div>
            <figcaption><?= e($body) ?></figcaption>
          </figure>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           The ten roles — Framer's Image Scroller, plus the list in words
           --------------------------------------------------------------- */ ?>
  <section class="tm-sec tm-roles" id="tm-roles">
    <div class="tm-shell">
      <div class="tm-head">
        <p class="tm-eyebrow"><span class="tm-seat" aria-hidden="true"></span>The bench</p>
        <h2 class="tm-title">From concept to completion:<br><em>ten disciplines</em>, one bench</h2>
        <p class="tm-sub">
          You rarely need one of these. You need four of them who have worked together before, which
          is the whole argument for taking a team rather than assembling one.
        </p>
      </div>
    </div>

    <div class="tm-shell tm-liquid-shell">
      <div class="tm-liquid-stage-wrap corner-bracket-wrap">
        <div class="corner-bracket-bottom-left"></div>
        <div class="corner-bracket-bottom-right"></div>
        <div class="tm-liquid-edge tm-liquid-edge--left" aria-hidden="true"></div>
        <div class="tm-liquid-edge tm-liquid-edge--right" aria-hidden="true"></div>

        <div class="tm-liquid-host"
             data-ok="liquid-carousel"
             data-props='<?= e(json_encode([
                 'projects' => array_map(static fn (array $r): array => [
                     'brand'       => $r[0] . ' · ' . $r[1],
                     'description' => $r[2],
                     'image'       => ['src' => $imgAbs('role/' . $r[0] . '.jpg'), 'alt' => $r[1]],
                 ], $roles),
                 'panelHeight'      => 440,
                 'gap'              => 20,
                 'glide'            => 0.08,
                 'wheelSensitivity' => 1,
                 'snap'             => true,
                 'lensShape'        => 'circle',
                 'lensRotation'     => 0,
                 'lensWidth'        => 0.22,
                 'lensHeight'       => 0.82,
                 'lensX'            => 0.0,
                 'lensY'            => 0.5,
                 'dispersion'       => 16,
                 'zoom'             => 0.12,
                 'blur'             => 0,
                 'glow'             => 5.5,
                 'blueRing'         => 6.5,
                 'blueColor'        => '#1bd7fe',
                 'shimmer'          => true,
                 'rimWave'          => 0.65,
                 'entryAnimation'   => false,
                 'focusScale'       => 1.15,
                 'background'       => 'rgba(0, 0, 0, 0)',
                 'foreground'       => '#EAF0FA',
                 'showLabels'       => true,
                 'showCursor'       => true,
             ], JSON_THROW_ON_ERROR)) ?>'></div>
      </div>
    </div>

    <div class="tm-shell">
      <dl class="tm-role-list">
        <?php foreach ($roles as [$n, $title, $body]): ?>
          <div class="tm-role-row">
            <dt><span class="tm-role-num"><?= e($n) ?></span><?= e($title) ?></dt>
            <dd><?= e($body) ?></dd>
          </div>
        <?php endforeach; ?>
      </dl>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           Band — Framer's Gradient Bars behind it
           --------------------------------------------------------------- */ ?>
  <section class="tm-band">
    <div class="tm-band-bg" aria-hidden="true"
         data-ok="g-bars"
         data-props='<?= e(json_encode([
             'numBars'   => 34,
             'barWidth'  => 3,
             'barHeight' => 240,
         ], JSON_THROW_ON_ERROR)) ?>'></div>

    <div class="tm-shell tm-band-inner">
      <h2>Your product and our engineers.<br><em>One team, one board.</em></h2>
      <button class="tm-btn tm-btn--primary" type="button"
              data-modal-open data-modal-service="Dedicated Engineering Team">
        Show me how<?= icon('arrow') ?>
      </button>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           The four steps — Scroll Split Cards
           --------------------------------------------------------------- */ ?>
  <section class="tm-sec tm-process">
    <div class="tm-shell">
      <div class="tm-head">
        <p class="tm-eyebrow"><span class="tm-seat" aria-hidden="true"></span>The engagement</p>
        <h2 class="tm-title">Where collaboration meets<br><em>a bench that is already there</em></h2>
        <p class="tm-sub">
          Scroll down to explore how each phase stacks seamlessly into your workflow.
        </p>
      </div>
    </div>

    <div class="tm-stack-reveal-wrap">
      <div data-ok="stack-reveal-scroll"
           data-props='<?= e(json_encode([
               'panels' => [
                   [
                       'bigText' => '1',
                       'badge' => 'Phase 01 · Discovery',
                       'title' => 'Tell us the shape',
                       'description' => 'A call about the work, not a CV parade. What you are building, what your team already covers, and the gap you actually need filled.',
                       'tag' => 'Discovery Call',
                       'bgColor' => 'linear-gradient(145deg, #081d2e 0%, #04111c 100%)',
                       'numberColor' => '#22d3ee',
                       'titleColor' => '#ffffff',
                       'descriptionColor' => '#94a3b8',
                       'borderColor' => 'rgba(34, 211, 238, 0.45)'
                   ],
                   [
                       'bigText' => '2',
                       'badge' => 'Phase 02 · Assembly',
                       'title' => 'We assemble it',
                       'description' => 'Within about two weeks you meet named people with the skills the work needs — not a pool, not a promise, the individuals who will do it.',
                       'tag' => 'Two-Week Match',
                       'bgColor' => 'linear-gradient(145deg, #0a1c42 0%, #050f24 100%)',
                       'numberColor' => '#38bdf8',
                       'titleColor' => '#ffffff',
                       'descriptionColor' => '#94a3b8',
                       'borderColor' => 'rgba(56, 189, 248, 0.45)'
                   ],
                   [
                       'bigText' => '3',
                       'badge' => 'Phase 03 · Integration',
                       'title' => 'They join your cadence',
                       'description' => 'Your standup, your board, your repository, your definition of done. They report the way your own engineers report.',
                       'tag' => 'Day One Standup',
                       'bgColor' => 'linear-gradient(145deg, #161245 0%, #0a0824 100%)',
                       'numberColor' => '#818cf8',
                       'titleColor' => '#ffffff',
                       'descriptionColor' => '#94a3b8',
                       'borderColor' => 'rgba(129, 140, 248, 0.45)'
                   ],
                   [
                       'bigText' => '4',
                       'badge' => 'Phase 04 · Scale',
                       'title' => 'Scale as it changes',
                       'description' => 'Grow the team for a push, shrink it after. Thirty days\' notice either way and no penalty for being honest about what you need.',
                       'tag' => 'Quarterly Elasticity',
                       'bgColor' => 'linear-gradient(145deg, #240d42 0%, #110522 100%)',
                       'numberColor' => '#c084fc',
                       'titleColor' => '#ffffff',
                       'descriptionColor' => '#94a3b8',
                       'borderColor' => 'rgba(192, 132, 252, 0.45)'
                   ]
               ],
               'panelHeight' => 100,
               'revealRatio' => 0.55,
               'sliverDesktop' => 9.7,
               'sliverTablet' => 6.0,
               'sliverMobile' => 4.0,
               'containerBg' => '#06080e',
               'borderWidth' => 1,
               'panelPadding' => '40px 24px'
           ], JSON_THROW_ON_ERROR)) ?>'>
      </div>
    </div>

    <div class="tm-shell tm-process-cta">
      <button class="tm-btn tm-btn--ghost" type="button"
              data-modal-open data-modal-service="Dedicated Engineering Team">
        Schedule a call<?= icon('arrow') ?>
      </button>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           Five commitments — Framer's Stack Reveal Scroll
           --------------------------------------------------------------- */ ?>
  <section class="tm-sec tm-proof">
    <div class="tm-shell">
      <div class="tm-head tm-head--mid">
        <p class="tm-eyebrow"><span class="tm-seat" aria-hidden="true"></span>What you can hold us to</p>
        <h2 class="tm-title">Fifty-plus teams have run<br>this <em>arrangement with us</em></h2>
        <p class="tm-sub">
          Six years, a hundred-odd projects, and the same five commitments in every contract —
          not because they are impressive, but because they are the things that go wrong.
        </p>
      </div>

      <div class="tm-stack-container" data-stack-container>
        <div class="tm-stack-deck">
          <?php foreach ($proof as $i => [$t, $b]): ?>
            <article class="tm-stack-card" data-stack-card style="--i: <?= $i ?>; --n: <?= count($proof) ?>;">
              <figure class="tm-stack-art">
                <img src="<?= e($imgAbs('proof/' . str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT) . '.jpg')) ?>"
                     alt="<?= e($t) ?>" loading="lazy" decoding="async">
                <div class="tm-stack-scrim"></div>
              </figure>
              <div class="tm-stack-content">
                <header class="tm-stack-header">
                  <span class="tm-stack-num">Commitment 0<?= $i + 1 ?></span>
                  <span class="tm-stack-status">Guaranteed in Contract</span>
                </header>
                <h3 class="tm-stack-title"><?= e($t) ?></h3>
                <p class="tm-stack-body"><?= e($b) ?></p>
                <div class="tm-stack-footer">
                  <span class="tm-stack-check"><?= icon('check') ?> SLA Backed</span>
                  <span class="tm-stack-dot"></span>
                </div>
              </div>
            </article>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           Hiring models — three, built here, flipping in 3D
           --------------------------------------------------------------- */ ?>
  <section class="tm-sec tm-models" data-models>
    <div class="tm-shell">
      <div class="tm-head">
        <p class="tm-eyebrow"><span class="tm-seat" aria-hidden="true"></span>Commercials</p>
        <h2 class="tm-title">Three ways to <em>buy the same team</em></h2>
        <p class="tm-sub">
          The engineers do not change between these; only who carries the risk of the scope moving.
          Click a card to turn it over.
        </p>
      </div>

      <div class="tm-model-grid">
        <?php foreach ($models as $i => [$n, $title, $body, $tags]): ?>
          <div class="tm-model" data-model role="button" tabindex="0"
               aria-pressed="false" style="--d:<?= $i ?>">
            <div class="tm-model-inner">
              <div class="tm-model-face tm-model-front">
                <figure class="tm-model-art">
                  <img src="<?= e($img('model/' . $n . '.jpg')) ?>" width="800" height="600"
                       alt="" loading="lazy" decoding="async">
                </figure>
                <span class="tm-model-num"><?= e($n) ?></span>
                <h3><?= e($title) ?></h3>
                <p class="tm-model-turn">Turn it over<?= icon('arrow') ?></p>
              </div>
              <div class="tm-model-face tm-model-back">
                <h3><?= e($title) ?></h3>
                <p><?= e($body) ?></p>
                <ul class="tm-tags">
                  <?php foreach ($tags as $t): ?><li><?= e($t) ?></li><?php endforeach; ?>
                </ul>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           FAQ
           --------------------------------------------------------------- */ ?>
  <section class="tm-sec tm-faq">
    <div class="tm-shell tm-faq-grid">
      <div class="tm-faq-side">
        <p class="tm-eyebrow"><span class="tm-seat" aria-hidden="true"></span>FAQ</p>
        <h2 class="tm-title">What people ask<br>before they <em>commit</em></h2>
        <figure class="tm-faq-art">
          <img src="<?= e($img('faq/01.jpg')) ?>" width="800" height="600"
               alt="" loading="lazy" decoding="async">
        </figure>
      </div>

      <div class="tm-faq-list">
        <?php foreach ($faqs as $i => [$q, $a]): ?>
          <details class="tm-faq-item"<?= $i === 0 ? ' open' : '' ?>>
            <summary><?= e($q) ?><span class="tm-faq-mark" aria-hidden="true"></span></summary>
            <div class="tm-faq-body"><p><?= e($a) ?></p></div>
          </details>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           Close — Framer's Ambient Background drifting under it
           --------------------------------------------------------------- */ ?>
  <section class="tm-close">
    <div class="tm-close-bg" aria-hidden="true"
         data-ok="ambient-background"
         data-props='<?= e(json_encode([
             'baseColor'       => 'rgba(0, 0, 0, 0)',
             'color1'          => 'rgba(0, 242, 254, 0.18)',
             'color2'          => 'rgba(78, 168, 255, 0.16)',
             'color3'          => 'rgba(157, 78, 221, 0.18)',
             'blurAmount'      => 90,
             'speedMultiplier' => 0.45,
         ], JSON_THROW_ON_ERROR)) ?>'></div>

    <div class="tm-shell">
      <p class="tm-eyebrow"><span class="tm-seat" aria-hidden="true"></span>Next step</p>
      <h2>Consistency you can count on.<br><em>A team that stops feeling outsourced.</em></h2>
      <p class="tm-close-lead">
        Tell us what your roadmap needs and which parts your own team already covers. If an embedded
        team is the right instrument you will have named people and a rate card within a week. If it
        is not, we will say which of the other two you actually want.
      </p>
      <div class="tm-actions tm-actions--mid">
        <button class="tm-btn tm-btn--primary" type="button"
                data-modal-open data-modal-service="Dedicated Engineering Team">
          Start the conversation<?= icon('arrow') ?>
        </button>
      </div>
    </div>
  </section>

</div>

<?php /* The island that carries the Framer components — all seven on this page
         are mounted here for the first time on the site. */ ?>
<script type="module" src="<?= e(url('assets/dist/originkit/originkit.js')) ?>"></script>

<?php /* Metallic Cube Grid 3D Three.js & Controls */ ?>
<script src="<?= e(asset('assets/vendor/three128/three.min.js')) ?>"></script>
<script src="<?= e(asset('assets/vendor/three128/OrbitControls.js')) ?>"></script>
<script src="<?= e(asset('assets/js/metallic-cube-grid.js')) ?>" defer></script>

<?php /* This page's own behaviour: the three flipping model cards. */ ?>
<script src="<?= e(asset('assets/js/team-page.js')) ?>" defer></script>

<?php
require dirname(__DIR__) . '/includes/footer.php';
