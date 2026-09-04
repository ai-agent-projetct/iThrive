<?php
/**
 * PoC Development — the second service page that is not the shared layout.
 *
 * Built after absoluteapplabs.com/poc-development-company, section for section,
 * in iThrive's own words and with iThrive's own position on what a proof of
 * concept is: one question, one numeric threshold, and permission to fail.
 *
 * It wears the SITE's palette, like the MVP page — ink #0B0F17 under the cyan /
 * blue / violet ramp in style.css. What separates the two pages is where they
 * sit on that ramp and what they are made of. The MVP page is cyan-forward and
 * built around a magazine; this one leans to the BLUE-VIOLET end and is built
 * around a blueprint: hairline grids, corner ticks, mono evidence labels, and a
 * verdict stamped on every card.
 *
 * Its Framer components are deliberately disjoint from the MVP page's, so the
 * two read as different pages rather than one template run twice:
 *
 *   hero        Scroll 3D Slider     a real three.js cube you drag
 *   process     Steps Flow           the five-step engagement
 *   sectors     Depth Blur Carousel  a curved, blurred card run
 *
 * Three more from the marketplace were fetched and rejected: FAQ Accordion,
 * Expanded Card and Feature Flipper are canvas exports whose props are
 * per-instance ids with the content baked into variants, so our own copy cannot
 * be handed to them. Those three sections are built here instead — the FAQ on
 * <details>, which is better for a crawler anyway.
 *
 * Every picture is rendered from markup by tools/poc-art.mjs, and every slot
 * prefers a photograph from assets/img/poc/photo/ the moment one exists — see
 * $img below. The photographs are briefed in tools/site-photos.mjs.
 *
 * Degrades: every Framer host has real markup around it, so with the island
 * absent the page still reads completely and a crawler sees all of it.
 */

declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/config.php';

$svc = service('poc-development');

$page      = 'services';
$pageTitle = 'PoC Development Company in Chennai';
$pageDesc  = 'iThrive Software builds proofs of concept in two to four weeks — one question, one '
           . 'numeric threshold, and an honest answer you can act on before the budget is committed.';
$ogImage   = 'service-' . $svc['group_slug'];

/* ---------------------------------------------------------------------------
 * Content
 * ------------------------------------------------------------------------ */

/** The hero's 3D cube faces. */
$faces = [
    ['01', 'Can the data carry it?'],
    ['02', 'Will the model hold at load?'],
    ['03', 'Does the integration exist?'],
    ['04', 'Is the latency survivable?'],
    ['05', 'What does it cost per call?'],
    ['06', 'Should this be built at all?'],
];

$stats = [
    ['2–4', 'Weeks, question to verdict'],
    ['1', 'Question per proof'],
    ['100%', 'Findings written down'],
    ['~8%', 'Of a full build budget'],
];

/** What you gain by starting with a PoC first — three. */
$gain = [
    ['01', 'Risk, found early', 'Feasibility problems are cheapest on the day they are discovered and most expensive the week before launch. A proof drags them to the front.', 'De-risk'],
    ['02', 'Money not spent', 'A proof costs a fraction of the build it protects. The ones that come back negative save the most, which is the part nobody puts on a slide.', 'Cost'],
    ['03', 'Confidence you can show', 'A working artefact ends a debate that a document cannot. Boards, buyers and engineers all believe the same running thing.', 'Evidence'],
];

/** What goes into the PoC we build for you — eight. */
$inside = [
    ['01', 'Feasibility assessment',      'Your concept is put against technical viability, data readiness and the commercial logic, before a line is written.'],
    ['02', 'Architecture and approach',   'The shape the real system would take is drawn now, so a positive proof leads into a build rather than a rewrite.'],
    ['03', 'Technical risk register',     'The things most likely to break the build are named, ranked and each given a cheap way to test it.'],
    ['04', 'Rapid build of the core',     'Only the part of the idea that carries the risk gets built. Everything else is stubbed without apology.'],
    ['05', 'Backend workflow validation', 'Logic and data flows are run end to end, because the engine is usually where a promising idea actually fails.'],
    ['06', 'API and integration testing', 'Every system you must connect to is exercised for real. "There is an API" and "the API works" are different findings.'],
    ['07', 'Demo-ready delivery',         'The proof is cleaned up into something you can put in front of a board, a customer or an investor without narrating it.'],
    ['08', 'MVP roadmap and costing',     'What was learned becomes a scoped plan with a number against it — what to build, what to drop, what it will take.'],
];

/** The five-step engagement. */
$steps = [
    ['01', 'Discovery call',        'Thirty minutes. You describe the idea and the constraint around it; we say plainly whether a proof is the right instrument, and what it would have to answer.'],
    ['02', 'The question, in writing', 'We send back one question, one numeric threshold that counts as a yes, a fixed scope and a fixed price. Nothing starts until you recognise your problem in it.'],
    ['03', 'Build the smallest test', 'Two to four weeks on the risky part only. You see it running each week, not a status report about it.'],
    ['04', 'Verdict and roadmap',   'A working proof, the number it produced, and an honest reading of it — including when the honest reading is no. With it comes the MVP plan and its cost.'],
    ['05', 'Your call, your code',  'Continue into an MVP with us, hand it to your own team, or use it to raise. The repository is yours from the first commit either way.'],
];

/** Sectors we have proved ideas in — six, four examples each. */
$sectors = [
    ['01', 'Retail', 'Ideas tested against real catalogue and basket data before a rollout is committed.', [
        'Size and fit recommendation engines',
        'Stock movement and replenishment models',
        'In-store companion experience probes',
        'Purchase intent and churn forecasting',
    ]],
    ['02', 'Healthcare', 'Proofs run inside the constraints that actually govern the sector — accuracy, auditability and consent.', [
        'Continuous patient monitoring pipelines',
        'Diagnostic decision support probes',
        'Triage and appointment routing agents',
        'Clinical document extraction at volume',
    ]],
    ['03', 'SaaS and enterprise', 'Whether a concept survives real teams, real permissions and real data volume.', [
        'Role and permission model validation',
        'Process automation and orchestration',
        'Unified reporting over live pipelines',
        'Cross-system integration feasibility',
    ]],
    ['04', 'Logistics', 'Ideas put under real movement, real timing and the messiness of the depot.', [
        'Route and load optimisation engines',
        'Shipment tracking and exception alerting',
        'Warehouse workflow automation',
        'Fleet telemetry and utilisation models',
    ]],
    ['05', 'FinTech', 'Where the compliance question is usually the real question, and is tested first.', [
        'Fraud and anomaly detection models',
        'Alternative credit scoring probes',
        'Identity and document verification flows',
        'Real-time payment workflow tests',
    ]],
    ['06', 'E-commerce', 'Concepts measured against a real funnel rather than a designed one.', [
        'Recommendation and merchandising models',
        'Checkout and recovery flow experiments',
        'Semantic search and product discovery',
        'Demand planning and pricing probes',
    ]],
];

/** Why choose iThrive for a proof — four. */
$why = [
    ['01', 'Built like the real system, small', 'The proof uses the architecture the product would use. That is why a yes from us converts into a build instead of starting one over.'],
    ['02', 'A number, not an impression',       'Every proof carries one threshold agreed in advance. It passes or it does not, and we report the reading either way.'],
    ['03', 'We are willing to say no',          'A proof that comes back negative has done its job. We would rather lose the build than sell you one we already know is wrong.'],
    ['04', 'Yours from the first commit',       'Repository, infrastructure and accounts are in your name on day one. There is no version of this where we hold the work hostage.'],
];

$faqs = [
    ['What does a proof of concept cost, and what moves the number?',
     'Most sit between two and four weeks of a small team, which is roughly eight per cent of the build it is protecting. What moves it is the number of live systems we have to integrate with, whether usable data already exists, and whether a model has to be trained rather than evaluated. You get a fixed price against a fixed question before anything starts.'],
    ['What should a PoC actually include?',
     'The risky part and nothing else. One question, the smallest thing that can answer it, real data wherever it exists, and the measurement written down. Authentication, admin screens and polish are deliberately absent — putting them in is how a proof quietly turns into a slow first build.'],
    ['How do I know whether my idea needs a proof at all?',
     'If you can name a specific thing that would sink the project and nobody can currently say whether it is true, that is a proof. If the risk is really about whether people want it, you want an MVP in front of users instead, and we will say so on the call rather than sell you the smaller piece of work.'],
    ['Does a proof speed up the MVP afterwards?',
     'Yes, and mostly by subtraction. The architecture is already chosen and tested, the integrations are known quantities, and the features that turned out not to matter have been removed before anyone paid to build them. Teams that run a proof first generally reach a released MVP sooner even counting the weeks the proof took.'],
    ['What do I actually get at the end?',
     'A running proof you can demonstrate, the source and infrastructure in your own accounts, the measurement against the agreed threshold, a written account of what we found — including anything that surprised us — and a scoped MVP plan with a cost against it.'],
];

$extraHead = '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>'
    . '<link rel="stylesheet" href="https://fonts.googleapis.com/css2?'
    . 'family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;600;700'
    . '&family=Space+Grotesk:wght@400;500;600;700&display=swap">'
    . '<link rel="stylesheet" href="' . e(asset('assets/css/poc.css')) . '">';

require dirname(__DIR__) . '/includes/header.php';

/**
 * The picture for a slot, preferring a photograph.
 *
 * assets/img/poc/photo/<set>-<n>.jpg is a real photograph briefed in
 * tools/site-photos.mjs; assets/img/poc/<set>/<n>.jpg is the drawn composition
 * tools/poc-art.mjs makes. The photograph wins wherever one exists, so the set
 * can be filled a few at a time with no edit here. Same convention as the MVP
 * page and as includes/components/page-figure.php.
 */
$img = static function (string $rel): string {
    [$set, $file] = explode('/', $rel, 2);
    $photo = 'assets/img/poc/photo/' . $set . '-' . $file;

    return asset(is_file(ROOT_PATH . '/' . $photo) ? $photo : 'assets/img/poc/' . $rel);
};
?>

<div class="poc">

  <?php /* ---------------------------------------------------------------
           Hero — a three.js cube you can drag, one question per face
           --------------------------------------------------------------- */ ?>
  <section class="poc-hero">
    <div class="poc-shell poc-hero-grid">

      <div class="poc-hero-copy">
        <p class="poc-eyebrow"><span class="poc-tick" aria-hidden="true"></span>PoC Development Company · Chennai</p>

        <h1 class="poc-h1">
          Prove it before you<br>
          <em>pay to build it</em>
        </h1>

        <p class="poc-lead">
          A proof of concept is not a small product. It is one question, one threshold that counts as a
          yes, and two to four weeks to find out — with permission to come back negative. That answer
          costs about eight per cent of the build it protects, and it is worth most on the days it says no.
        </p>

        <div class="poc-actions">
          <button class="poc-btn poc-btn--primary" type="button"
                  data-modal-open data-modal-service="PoC Development">
            Book a 30-minute call<?= icon('arrow') ?>
          </button>
          <a class="poc-btn poc-btn--ghost" href="#poc-process">See how it runs</a>
        </div>

        <ul class="poc-stats">
          <?php foreach ($stats as [$v, $l]): ?>
            <li><strong><?= e($v) ?></strong><span><?= e($l) ?></span></li>
          <?php endforeach; ?>
        </ul>
      </div>

      <?php /* Framer's Scroll 3D Slider on its cube preset — a real three.js
               scene, dragged and scrolled. The six questions are also listed
               in the <noscript> below so the hero says something without it. */ ?>
      <div class="poc-hero-stage">
        <div class="poc-cube-host"
             data-ok="scroll-3d-slider"
             data-props='<?= e(json_encode([
                 'slides' => array_map(static fn (array $f): array => [
                     'image' => $img('face/' . $f[0] . '.jpg'),
                     'title' => $f[1],
                 ], $faces),
                 'backgroundColor' => 'rgba(0, 0, 0, 0)',
                 'direction'       => 'horizontal',
                 'borderRadius'    => 0.02,
                 'slideSize' => [
                     'aspectRatio'   => 1.0,
                     'minHeight'     => 1.0,
                     'maxHeight'     => 1.35,
                     'gap'           => 0.06,
                     'randomHeights' => false,
                     'activeScale'   => 1.06,
                 ],
                 'effect' => [
                     'preset'      => 'cube',
                     'perspective' => 52,
                     'rotation'    => 45,
                     'depth'       => 1.9,
                 ],
                 'interactive'  => true,
                 'snap'         => ['enabled' => true, 'strength' => 26],
                 /* Slow: the MVP page's first pass span too fast to read and
                    had to be brought down twice. Starting there. */
                 'scrollTuning' => ['smoothing' => 9, 'momentum' => 62, 'wheelSpeed' => 9, 'dragSpeed' => 16],
                 'autoplay'     => ['enabled' => true, 'speed' => 9],
                 'showOverlay'  => true,
                 'overlayColor' => '#DCE6F5',
                 'overlaySize'  => 15,
                 'counterSize'  => 11,
             ], JSON_THROW_ON_ERROR)) ?>'>
          <noscript>
            <ul class="poc-face-list">
              <?php foreach ($faces as [$n, $q]): ?><li><?= e($q) ?></li><?php endforeach; ?>
            </ul>
          </noscript>
        </div>
        <p class="poc-stage-hint">Drag the cube · six questions a proof is built to answer</p>
      </div>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           Why starting with a proof changes the outcome
           --------------------------------------------------------------- */ ?>
  <section class="poc-sec poc-why-open">
    <div class="poc-shell poc-split">
      <div class="poc-split-copy">
        <p class="poc-eyebrow"><span class="poc-tick" aria-hidden="true"></span>The case for proving first</p>
        <h2 class="poc-title">Why starting with a proof changes<br><em>everything that comes after it</em></h2>

        <p>
          Every product starts as an idea that feels right and has not been tested. The pressure at that
          moment is to move — to get into design, to get a team on it, to show progress. It is a
          reasonable instinct, and it is where most of the expensive mistakes are made, because the
          questions about feasibility, data and cost are still unanswered while the commitments are
          already being signed.
        </p>
        <p>
          A proof answers them while the idea is still cheap to change. You find out what is real, what
          needs work, and what should wait — before the roadmap, the hires and the deadline have made
          those answers inconvenient. It is the only point in a project where being wrong costs almost
          nothing.
        </p>

        <ul class="poc-checks">
          <li>The risky assumption is named out loud, in writing</li>
          <li>One threshold decides it, agreed before we start</li>
          <li>A negative result ends the spend, and that is a win</li>
        </ul>
      </div>

      <figure class="poc-split-art">
        <img src="<?= e($img('open/01.jpg')) ?>" width="900" height="1100"
             alt="An engineer running an early feasibility test" loading="lazy" decoding="async">
        <figcaption>Week one of a proof: the risky part, and nothing else</figcaption>
      </figure>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           What you gain by starting with a proof — three, hover to lift
           --------------------------------------------------------------- */ ?>
  <section class="poc-sec poc-gain">
    <div class="poc-shell">
      <div class="poc-head">
        <p class="poc-eyebrow"><span class="poc-tick" aria-hidden="true"></span>What it buys you</p>
        <h2 class="poc-title">What do you gain by starting<br>with a <em>proof of concept</em> first?</h2>
      </div>

      <div class="poc-gain-grid">
        <?php foreach ($gain as $i => [$n, $title, $body, $tag]): ?>
          <article class="poc-gain-card" data-reveal style="--d:<?= $i ?>">
            <figure class="poc-gain-art">
              <img src="<?= e($img('gain/' . $n . '.jpg')) ?>" width="800" height="600"
                   alt="" loading="lazy" decoding="async">
              <span class="poc-gain-tag"><?= e($tag) ?></span>
            </figure>
            <div class="poc-gain-body">
              <span class="poc-num"><?= e($n) ?></span>
              <h3><?= e($title) ?></h3>
              <p><?= e($body) ?></p>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           What goes into the proof — eight, click to open
           --------------------------------------------------------------- */ ?>
  <section class="poc-sec poc-inside" data-inside>
    <div class="poc-shell">
      <div class="poc-head">
        <p class="poc-eyebrow"><span class="poc-tick" aria-hidden="true"></span>Scope</p>
        <h2 class="poc-title">What goes into the proof<br>we <em>build for you</em></h2>
        <p class="poc-sub">
          Eight things are in every engagement. Open one to see what it means in practice —
          and note what is deliberately absent: polish, admin screens, and anything that does not
          carry risk.
        </p>
      </div>

      <div class="poc-inside-grid">
        <?php foreach ($inside as $i => [$n, $title, $body]): ?>
          <article class="poc-inside-card<?= $i === 0 ? ' is-open' : '' ?>"
                   data-inside-card role="button" tabindex="0"
                   aria-expanded="<?= $i === 0 ? 'true' : 'false' ?>" style="--d:<?= $i % 4 ?>">
            <span class="poc-inside-num"><?= e($n) ?></span>
            <h3 class="poc-inside-title"><?= e($title) ?></h3>
            <div class="poc-inside-panel">
              <figure class="poc-inside-art">
                <img src="<?= e($img('inside/' . $n . '.jpg')) ?>" width="800" height="500"
                     alt="" loading="lazy" decoding="async">
              </figure>
              <p><?= e($body) ?></p>
            </div>
            <span class="poc-inside-more" aria-hidden="true"></span>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           Band — the marquee, on Framer's Infinity Text
           --------------------------------------------------------------- */ ?>
  <section class="poc-band">
    <div class="poc-band-rail"
         data-ok="infinity-text"
         data-props='<?= e(json_encode([
             'items' => [
                 'Every strong product starts with verified logic',
                 'One question',
                 'One threshold',
                 'An honest answer',
                 'Two to four weeks',
             ],
             'font'  => ['fontSize' => '1.6rem', 'fontWeight' => 700, 'letterSpacing' => '-0.02em', 'lineHeight' => '1.28'],
             'color' => '#DCE6F5',
             'speed' => 22,
             'gap'   => 56,
         ], JSON_THROW_ON_ERROR)) ?>'>
      <noscript>Every strong product starts with verified logic.</noscript>
    </div>

    <div class="poc-shell poc-band-cta">
      <p>Every strong product starts with verified logic.</p>
      <button class="poc-btn poc-btn--primary" type="button"
              data-modal-open data-modal-service="PoC Development">
        Build my proof<?= icon('arrow') ?>
      </button>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           The working process — Framer's Steps Flow, five steps
           --------------------------------------------------------------- */ ?>
  <section class="poc-sec poc-process" id="poc-process">
    <div class="poc-shell">
      <div class="poc-head">
        <p class="poc-eyebrow"><span class="poc-tick" aria-hidden="true"></span>How it runs</p>
        <h2 class="poc-title">Know our <em>working process</em></h2>
        <p class="poc-sub">
          Most expensive rework traces back to the same thing: the build started before anyone
          agreed what would count as success. These five steps exist to make that impossible.
        </p>
      </div>

      <div class="poc-steps-host"
           data-ok="steps-flow"
           data-props='<?= e(json_encode([
               'steps' => array_map(static fn (array $s): array => [
                   'number' => $s[0],
                   'title'  => $s[1],
                   'text'   => $s[2],
                   'image'  => $img('step/' . $s[0] . '.jpg'),
               ], $steps),
               'numberFont'  => ['fontSize' => 88, 'fontWeight' => 800, 'lineHeight' => '1.05', 'letterSpacing' => '-0.04em'],
               'numberColor' => 'rgba(78, 168, 255, 0.30)',
               'titleFont'   => ['fontSize' => 25, 'fontWeight' => 700, 'lineHeight' => '1.25', 'letterSpacing' => '-0.02em'],
               'titleColor'  => '#EAF1FB',
               'textFont'    => ['fontSize' => 15, 'lineHeight' => '1.7em'],
               'textColor'   => 'rgba(197, 211, 232, 0.78)',
               'accentColor' => '#4EA8FF',
               'lineColor'   => 'rgba(255, 255, 255, 0.12)',
               'cornerMaskColor' => 'rgba(0, 0, 0, 0)',
               'imageRadius' => 16,
               'lineWidth'   => 2,
               'dotSize'     => 11,
               'showDots'    => true,
               'cornerRadius' => 16,
               'gridGap'     => 56,
               'imageAnimation' => 'slideUp',
               'mobileBreakpoint' => 820,
           ], JSON_THROW_ON_ERROR)) ?>'>
        <?php /* The same five steps in plain markup, so the section is complete
                 before the island mounts and for anything that never runs it. */ ?>
        <ol class="poc-steps-fallback">
          <?php foreach ($steps as [$n, $t, $b]): ?>
            <li><strong><?= e($n) ?> · <?= e($t) ?></strong><span><?= e($b) ?></span></li>
          <?php endforeach; ?>
        </ol>
      </div>

      <div class="poc-process-cta">
        <button class="poc-btn poc-btn--ghost" type="button"
                data-modal-open data-modal-service="PoC Development">
          Let's validate your idea<?= icon('arrow') ?>
        </button>
      </div>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           Sectors — Framer's Depth Blur Carousel over a detail panel
           --------------------------------------------------------------- */ ?>
  <section class="poc-sec poc-sectors" data-sectors>
    <div class="poc-shell">
      <div class="poc-head">
        <p class="poc-eyebrow"><span class="poc-tick" aria-hidden="true"></span>Where we have proved things</p>
        <h2 class="poc-title">Ideas we have helped turn<br>into <em>proof across sectors</em></h2>
        <p class="poc-sub">Scroll the run, or pick a sector to see what we actually built there.</p>
      </div>
    </div>

    <?php /* This one needs ABSOLUTE urls. The component decides whether a slide
             is a picture or a CSS colour with
                 src.startsWith("http") || src.startsWith("data:")
             and treats anything else as a background shorthand — so a
             root-relative "/assets/…" silently became `background: /assets/…`,
             which is not valid CSS and painted nothing. site_origin() rather
             than editing the vendored file, which stays byte-for-byte Framer's. */ ?>
    <div class="poc-sectors-rail"
         data-ok="depth-blur-carousel"
         data-props='<?= e(json_encode([
             'images' => array_map(
                 static fn (array $s): string => site_origin() . $img('sector/' . $s[0] . '.jpg'),
                 $sectors
             ),
             'layoutProps' => [
                 'itemWidth' => 470, 'itemHeight' => 290,
                 'sideItemWidth' => 300, 'sideItemHeight' => 265, 'gap' => 58,
             ],
             'effectProps'  => ['maxRotation' => 62, 'perspective' => 620, 'scrollDamping' => 100],
             'stylingProps' => ['borderRadius' => 18],
             'blurProps'    => ['blurSpread' => 2, 'blurStrength' => 5],
         ], JSON_THROW_ON_ERROR)) ?>'></div>

    <div class="poc-shell">
      <div class="poc-sector-tabs" role="tablist" aria-label="Sectors">
        <?php foreach ($sectors as $i => [$n, $name]): ?>
          <button class="poc-sector-tab<?= $i === 0 ? ' is-on' : '' ?>" type="button"
                  role="tab" aria-selected="<?= $i === 0 ? 'true' : 'false' ?>"
                  aria-controls="poc-sector-<?= e($n) ?>" data-sector-tab="<?= $i ?>">
            <?= e($name) ?>
          </button>
        <?php endforeach; ?>
      </div>

      <?php foreach ($sectors as $i => [$n, $name, $blurb, $items]): ?>
        <div class="poc-sector-panel<?= $i === 0 ? ' is-on' : '' ?>" id="poc-sector-<?= e($n) ?>"
             role="tabpanel" data-sector-panel="<?= $i ?>"<?= $i === 0 ? '' : ' hidden' ?>>
          <figure class="poc-sector-art">
            <img src="<?= e($img('sector/' . $n . '.jpg')) ?>" width="900" height="600"
                 alt="" loading="lazy" decoding="async">
          </figure>
          <div class="poc-sector-body">
            <h3><?= e($name) ?></h3>
            <p><?= e($blurb) ?></p>
            <ul>
              <?php foreach ($items as $it): ?><li><?= e($it) ?></li><?php endforeach; ?>
            </ul>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           Mid CTA
           --------------------------------------------------------------- */ ?>
  <section class="poc-midcta">
    <div class="poc-shell">
      <h2>Not sure where to start?<br><em>Let us build the thing that proves it.</em></h2>
      <button class="poc-btn poc-btn--primary" type="button"
              data-modal-open data-modal-service="PoC Development">
        Let's build it<?= icon('arrow') ?>
      </button>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           Why choose us — four, on a blueprint grid
           --------------------------------------------------------------- */ ?>
  <section class="poc-sec poc-choose">
    <div class="poc-shell">
      <div class="poc-head poc-head--mid">
        <p class="poc-eyebrow"><span class="poc-tick" aria-hidden="true"></span>Why iThrive</p>
        <h2 class="poc-title">Why choose us for <em>PoC development</em></h2>
        <p class="poc-sub">
          We build the proof the way we would build the system, only smaller — the same architecture,
          the same integrations, the same constraints. That is what makes the answer transferable
          instead of merely encouraging.
        </p>
      </div>

      <div class="poc-choose-grid">
        <?php foreach ($why as $i => [$n, $title, $body]): ?>
          <article class="poc-choose-card" data-reveal style="--d:<?= $i % 2 ?>">
            <figure class="poc-choose-art">
              <img src="<?= e($img('why/' . $n . '.jpg')) ?>" width="800" height="520"
                   alt="" loading="lazy" decoding="async">
            </figure>
            <div class="poc-choose-body">
              <span class="poc-num"><?= e($n) ?></span>
              <h3><?= e($title) ?></h3>
              <p><?= e($body) ?></p>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           FAQ — <details>, because Framer's accordion is a canvas export
           --------------------------------------------------------------- */ ?>
  <section class="poc-sec poc-faq">
    <div class="poc-shell poc-faq-grid">
      <div class="poc-faq-side">
        <p class="poc-eyebrow"><span class="poc-tick" aria-hidden="true"></span>FAQ</p>
        <h2 class="poc-title">The questions we<br>get <em>every time</em></h2>
        <figure class="poc-faq-art">
          <img src="<?= e($img('faq/01.jpg')) ?>" width="800" height="600"
               alt="" loading="lazy" decoding="async">
        </figure>
        <p class="poc-faq-note">
          Something not covered? The thirty-minute call is the fastest way to an answer,
          and we will tell you if a proof is the wrong instrument for your problem.
        </p>
      </div>

      <div class="poc-faq-list">
        <?php foreach ($faqs as $i => [$q, $a]): ?>
          <details class="poc-faq-item"<?= $i === 0 ? ' open' : '' ?>>
            <summary><?= e($q) ?><span class="poc-faq-mark" aria-hidden="true"></span></summary>
            <div class="poc-faq-body"><p><?= e($a) ?></p></div>
          </details>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           Close
           --------------------------------------------------------------- */ ?>
  <section class="poc-close">
    <div class="poc-shell">
      <p class="poc-eyebrow"><span class="poc-tick" aria-hidden="true"></span>Next step</p>
      <h2>Your idea has a next step.<br><em>Start it with one question.</em></h2>
      <p class="poc-close-lead">
        Tell us the thing that would sink the project if it turned out to be false. If a proof is the
        right way to test it, you will have a fixed scope and a fixed price within a couple of days.
        If it is not, we will say that instead.
      </p>
      <div class="poc-actions poc-actions--mid">
        <button class="poc-btn poc-btn--primary" type="button"
                data-modal-open data-modal-service="PoC Development">
          Book the 30-minute call<?= icon('arrow') ?>
        </button>
        <a class="poc-btn poc-btn--ghost" href="<?= e(url('services/mvp-development.php')) ?>">
          Already proved it? See MVP development
        </a>
      </div>
    </div>
  </section>

</div>

<?php /* The island that carries the Framer components. Mounts are lazy: nothing
         is built until its host is near the viewport, and three.js is its own
         chunk fetched only by the hero's cube. */ ?>
<script type="module" src="<?= e(asset('assets/dist/originkit/originkit.js')) ?>"></script>

<?php /* This page's own two behaviours: the scope cards and the sector tabs. */ ?>
<script src="<?= e(asset('assets/js/poc-page.js')) ?>" defer></script>

<?php
require dirname(__DIR__) . '/includes/footer.php';
