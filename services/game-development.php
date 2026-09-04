<?php
/**
 * Game Development — the tenth bespoke service page.
 *
 * Laid out after macrobiangames.com section for section: hero, the industries
 * served, the expertise block with its stat band and capability cards, the work
 * grid, the client proof, the process, the questions and the close.
 *
 * WHAT IS DELIBERATELY NOT COPIED, and why. The reference carries "350+ Games
 * Delivered", "10+ Years in Game Dev", six shipped titles and a wall of client
 * logos including Toyota and Amazon, each with a signed testimonial. Those are
 * that company's record, not ours. Reproducing them — or inventing our own
 * equivalents — would put fabricated credentials on a page that asks people to
 * spend money, so the structure is theirs and every claim in it is ours:
 *
 *   stat band     capability facts, not a delivery count we have not earned
 *   work grid     the kinds of build we take on, framed as capability rather
 *                 than as shipped titles with invented names
 *   clients       the real ten from CASE_STUDIES, described as what they are —
 *                 iThrive's clients across sectors, not game studios
 *
 * If there are real shipped titles to name, they belong in CASE_STUDIES and
 * this page will pick them up.
 *
 * THE HERO. The brief is the Spline flight scene from the recording: a ship
 * over dunes under two suns, in our palette rather than its orange. That scene
 * cannot be embedded yet — the recording shows "No edit access for this file",
 * so it is a community file that has to be duplicated into the account before
 * Spline will export it. See GAME_SPLINE_SCENE in config.php for the four
 * steps.
 *
 * So the hero is built here to the same composition, at night — two moons, a
 * dune horizon, spires receding, a ship that answers the pointer — and the
 * moment GAME_SPLINE_SCENE is set the real scene takes over. Nothing else on
 * the page changes.
 *
 * Theme: the site's ramp, with this page's own type — Archivo, Public Sans and
 * DM Mono. The motif is the SPRITE: a coarse pixel grid with a glyph lit in it,
 * loose pixels around it and a scanline across the plate.
 *
 * Pictures come from tools/game-art.mjs; every slot prefers a photograph from
 * assets/img/game/photo/ the moment one lands.
 */

declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/config.php';

$svc = service('game-development');

$page      = 'services';
$pageTitle = 'Game Development Company in Chennai — Unity, Unreal, AR/VR';
$pageDesc  = 'iThrive Software builds games, simulations and game-based learning in Unity and '
           . 'Unreal — for entertainment, enterprise training and EdTech, across mobile, web and XR.';
$ogImage   = 'service-' . $svc['group_slug'];

/* ---------------------------------------------------------------------------
 * Content
 * ------------------------------------------------------------------------ */

/** The three audiences, as the reference orders them. */
$industries = [
    ['01', 'Enterprises', 'Training, simulation, gamification',
     'Procedure-accurate simulations and gamified training that make a competency measurable instead of assumed. Built for the tasks where getting it wrong on the job is expensive, and scored so completion means something.'],
    ['02', 'Studios and publishers', 'End-to-end game development',
     'From a playable prototype of the core loop through to a shipped build. We work as the engineering team, or alongside yours where the design and art already exist and the production capacity does not.'],
    ['03', 'EdTech', 'Game-based learning',
     'Learning games that hold attention and still map onto a curriculum — K-12, early years and skills. The mechanic carries the pedagogy rather than decorating it, which is the difference between a game and a quiz with sound effects.'],
];

/**
 * The stat band.
 *
 * Capability facts, deliberately. The reference's equivalent counts games
 * delivered and years in the industry; those are its record and we have not
 * earned an equivalent, so nothing here is a number we cannot stand behind.
 */
$stats = [
    ['60 fps',   'Frame target on mid-range devices'],
    ['5',        'Build targets from one project'],
    ['Playable', 'Prototype before production art'],
    ['100%',     'Source, assets and IP, yours'],
];

/** Capability cards — five, as the reference. */
$capabilities = [
    ['01', 'End-to-end game expertise',
     'Concept, core loop, production, ship and the live period after it. The part most teams underestimate is the last one, and it is where a game either finds an audience or quietly does not.'],
    ['02', 'Unity and Unreal specialists',
     'C# in Unity and C++ with Blueprints in Unreal, targeting mobile, WebGL, desktop and console-class hardware from a single project rather than a fork per platform.'],
    ['03', 'Simulation and XR',
     'Headset and handheld AR/VR built against the comfort budget first — frame time, locomotion, session length — because those constraints cannot be retrofitted once the scene exists.'],
    ['04', 'Built to be measured',
     'Analytics, remote config and A/B testing wired in from the prototype. Retention and session length are the only honest verdict on whether a loop works.'],
    ['05', 'Engineering discipline, applied to games',
     'Version control that handles binary assets, CI that produces a signed build every day, and a performance budget agreed before the first model is imported.'],
];

/**
 * The work grid.
 *
 * Kinds of build, not named titles. Everything here describes work we are set
 * up to do; nothing claims a specific game shipped under a specific name.
 */
$work = [
    ['01', 'Casual and hyper-casual',
     'A loop measured in seconds, tuned relentlessly against retention. The engineering problem is not complexity, it is build size, cold-start time and an ad and IAP layer that does not ruin the feel.'],
    ['02', 'Puzzle and narrative',
     'Systems for level authoring, progression and save state that let designers produce content without an engineer in the loop for every change.'],
    ['03', 'Enterprise simulation',
     'Procedure-accurate scenarios with assessment, scoring and reporting into the LMS you already run, for onboarding and certification.'],
    ['04', 'Game-based learning',
     'Curriculum-aligned mechanics with progression, adaptivity and a teacher-facing view of where a cohort is actually struggling.'],
    ['05', 'AR and VR experiences',
     'Marker and world-tracked AR on ARKit and ARCore, and room-scale VR — built to the comfort and thermal budget of the device that will actually run it.'],
    ['06', 'Digital twins and interactive 3D',
     'Real equipment, sites or product configurators rendered interactively in the browser or on a headset, driven by live data rather than a canned animation.'],
];

/** The process — four steps. */
$process = [
    ['01', 'Play the idea',
     'A discovery session on the audience, the platform and the loop. We are trying to find the thirty seconds a player will repeat, because everything else is built on top of it.'],
    ['02', 'Grey-box prototype',
     'The loop, playable, with no art. It is cheap, it is ugly, and it answers the only question that matters at this stage. Plenty of ideas change shape here, which is the point of doing it before the art budget is spent.'],
    ['03', 'Production',
     'Art, audio, content and systems in two-week increments with a build on device every Friday. Performance budget enforced in CI rather than discovered at submission.'],
    ['04', 'Ship and operate',
     'Store submission, launch, then the live period: telemetry, remote config, content updates and the balance changes that come from watching real players rather than the design document.'],
];

$faqs = [
    ['Do you build in Unity or Unreal?',
     'Both, and the choice follows the product rather than a preference. Unity is usually right for mobile, 2D, AR and cross-platform learning and training work — smaller builds, faster iteration, and the wider talent pool for handover. Unreal earns its place when the bar is visual fidelity on desktop or console. We will tell you which case you are in during discovery, and we will say so if a game engine is the wrong tool entirely, which happens more often than you would expect for training work.'],
    ['How much does a game cost to build?',
     'It depends on the loop and the content volume, not on the number of screens. A playable prototype of a core loop is typically ₹3L to ₹7L and takes three to six weeks. A complete casual or learning title generally lands between ₹12L and ₹35L; a simulation with assessment and LMS integration between ₹18L and ₹45L; and anything targeting console-class fidelity is a different conversation. Content is the variable that moves the number most — a hundred levels costs more than a hundred screens.'],
    ['Can you take over a project someone else started?',
     'Regularly, and it starts with a paid audit rather than a quote: the project structure, asset pipeline, build settings, source control history and the actual frame profile on target hardware. Half-finished game projects hide their cost in places a code review does not reach — an asset pipeline nobody can rebuild, or a scene that only runs on the machine it was made on. We would rather find that in week one than commit to a date around it.'],
    ['Will the game run on low-end phones?',
     'That is a decision, and it should be made before production rather than discovered at the end. We agree the minimum device and the frame target during discovery, then hold the build to it in CI — asset budgets, atlasing, LODs, draw calls and download size all follow from that one choice. Deciding it late is the single most common reason a game ships late, because the fix is rework rather than optimisation.'],
    ['Who owns the game, the code and the art?',
     'You do, completely, and on milestone sign-off we transfer the repository itself rather than a zip — full history, branches, CI and the asset sources, not just the exported files. Store listings, signing keys and third-party accounts move into your name at the same time. There is nothing held back as leverage and no engine or middleware licence that routes through us.'],
];

$extraHead = '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>'
    . '<link rel="stylesheet" href="https://fonts.googleapis.com/css2?'
    . 'family=Archivo:wght@400;500;600;700;800'
    . '&family=Public+Sans:wght@400;500;600;700'
    . '&family=DM+Mono:wght@400;500&display=swap">'
    . '<link rel="stylesheet" href="' . e(asset('assets/css/game.css')) . '">';

$schemaExtra = [
    [
        '@type'      => 'FAQPage',
        'name'       => 'Game development — frequently asked questions',
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
    $photo = 'assets/img/game/photo/' . $set . '-' . $file;

    return asset(is_file(ROOT_PATH . '/' . $photo) ? $photo : 'assets/img/game/' . $rel);
};

$hasSpline = defined('GAME_SPLINE_SCENE') && GAME_SPLINE_SCENE !== '';
?>

<div class="gm<?= $hasSpline ? ' gm--spline' : '' ?>">

  <?php /* ---------------------------------------------------------------
           Hero — the flight scene

           A night sky: two moons, a starfield thinning toward the horizon, dune
           ridges lit along their rims, spires receding, and a ship that leans
           toward the pointer. Built to the composition in the recording but at
           night and in our ramp, rather than its orange daylight.

           It stands alone in the strict sense: the section carries no copy at
           all, only the scene and a scroll cue. The headline and everything
           else moved into gm-intro below it.

           When GAME_SPLINE_SCENE is set, Spline's own viewer streams the real
           scene on top of this and the built version becomes the thing a
           visitor sees while it loads, or instead of it if Spline is
           unreachable. That ordering is the point: the page never has a hole
           in it waiting on a third party.
           --------------------------------------------------------------- */ ?>
  <section class="gm-hero" data-flight>
    <div class="gm-sky" aria-hidden="true">
      <?php
      /*
       * The starfield, as one element carrying a long box-shadow list.
       *
       * Generated rather than hand-placed, but from a FIXED seed, so the sky is
       * identical on every render and every machine — a random field would
       * reshuffle on each request and make the hero impossible to review
       * against a screenshot.
       */
      $seed = 20260909;
      $rand = static function (int $max) use (&$seed): int {
          $seed = ($seed * 1103515245 + 12345) & 0x7FFFFFFF;

          return (int) ($seed / 0x7FFFFFFF * $max);
      };

      $stars = [];
      for ($i = 0; $i < 90; $i++) {
          // Thinner toward the horizon, as a real sky is.
          $x = $rand(100);
          $y = $rand(46);
          $a = (110 - $y * 1.6) / 100;
          $stars[] = sprintf('%dvw %dvh 0 %dpx rgba(233,244,255,%.2f)',
              $x, $y, $rand(10) > 7 ? 1 : 0, max(0.18, min(0.9, $a)));
      }
      ?>
      <span class="gm-stars" style="box-shadow: <?= e(implode(', ', $stars)) ?>;"></span>

      <span class="gm-moon gm-moon--near"></span>
      <span class="gm-moon gm-moon--far"></span>
      <span class="gm-haze"></span>

      <?php /* Three dune bands, each drifting at its own rate. */ ?>
      <?php foreach ([0, 1, 2] as $band): ?>
        <span class="gm-dune" style="--band: <?= $band ?>;"></span>
      <?php endforeach; ?>

      <?php /* Spires, placed across the horizon and pulled toward the camera. */ ?>
      <div class="gm-spires">
        <?php foreach ([[8, 0, 0.9], [22, 1, 0.6], [34, 2, 1.15], [58, 0, 0.75], [71, 1, 1.3], [86, 2, 0.85], [94, 0, 0.6]] as $i => [$x, $lane, $h]): ?>
          <span class="gm-spire" style="--x: <?= $x ?>%; --lane: <?= $lane ?>; --h: <?= $h ?>; --i: <?= $i ?>;"></span>
        <?php endforeach; ?>
      </div>

      <?php /* The ship. Leans and banks toward the pointer. */ ?>
      <div class="gm-ship" data-ship>
        <svg viewBox="0 0 60 90" aria-hidden="true">
          <path d="M30 2 L44 58 L30 50 L16 58 Z" fill="#EAF0FA"/>
          <path d="M30 2 L30 50 L16 58 Z" fill="#B9C7DC"/>
          <ellipse cx="21" cy="62" rx="5.5" ry="11" fill="#00F2FE" opacity="0.9"/>
          <ellipse cx="39" cy="62" rx="5.5" ry="11" fill="#9D4EDD" opacity="0.9"/>
          <ellipse cx="21" cy="70" rx="3" ry="16" fill="#00F2FE" opacity="0.45"/>
          <ellipse cx="39" cy="70" rx="3" ry="16" fill="#9D4EDD" opacity="0.45"/>
        </svg>
      </div>
    </div>

    <?php if ($hasSpline): ?>
      <?php /* The real scene, once it exists. Streamed by Spline's own viewer,
               so nothing is bundled and the built hero above stays as the
               fallback if Spline cannot be reached. */ ?>
      <div class="gm-spline" data-spline-stage>
        <spline-viewer
          url="<?= e(GAME_SPLINE_SCENE) ?>"
          loading-anim-type="none"
          events-target="global"
          role="img"
          aria-label="An interactive 3D flight scene over an alien landscape."></spline-viewer>
      </div>
      <script type="module"
              src="https://unpkg.com/@splinetool/viewer@1.9.48/build/spline-viewer.js"
              crossorigin="anonymous"></script>
    <?php endif; ?>

    <?php /* The only thing over the scene: a cue that there is more below it. */ ?>
    <a class="gm-scroll" href="#gm-intro" aria-label="Skip to the introduction">
      <span aria-hidden="true"></span>
    </a>
  </section>

  <?php /* ---------------------------------------------------------------
           The introduction

           The headline, the lead and the stat band live here rather than over
           the scene. The hero above carries nothing at all, which is what
           "stand alone" asked for — and it also fixes the thing the phone
           layout kept fighting, where the moon and the lead paragraph wanted
           the same third of the screen.

           The h1 is here, so the page still opens on a real heading for a
           crawler even though the first screen is a picture.
           --------------------------------------------------------------- */ ?>
  <section class="gm-sec gm-intro" id="gm-intro">
    <div class="gm-shell">
      <p class="gm-eyebrow"><span class="gm-mark" aria-hidden="true"></span>Game Development · Chennai</p>

      <h1 class="gm-h1">
        Games that engage,<br>
        <em>educate and entertain</em>
      </h1>

      <p class="gm-lead">
        Built in Unity and Unreal for entertainment, enterprise training and EdTech — prototyped
        playable before a single production asset is made, and held to a frame budget from the first
        commit to the last update.
      </p>

      <div class="gm-actions">
        <button class="gm-btn gm-btn--primary" type="button"
                data-modal-open data-modal-service="Game Development">
          Start your game<?= icon('arrow') ?>
        </button>
        <a class="gm-btn gm-btn--ghost" href="#gm-work">See what we build</a>
      </div>

      <ul class="gm-stats">
        <?php foreach ($stats as [$v, $l]): ?>
          <li><strong><?= e($v) ?></strong><span><?= e($l) ?></span></li>
        <?php endforeach; ?>
      </ul>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           Industries we serve — three
           --------------------------------------------------------------- */ ?>
  <section class="gm-sec gm-ind" data-ind>
    <div class="gm-shell">
      <div class="gm-head">
        <p class="gm-eyebrow"><span class="gm-mark" aria-hidden="true"></span>Industries we serve</p>
        <h2 class="gm-title">Solutions for<br><em>every vision</em></h2>
      </div>

      <div class="gm-ind-grid">
        <?php foreach ($industries as $i => [$n, $name, $kicker, $body]): ?>
          <article class="gm-ind-card<?= $i === 0 ? ' is-open' : '' ?>" data-ind-card
                   role="button" tabindex="0" aria-expanded="<?= $i === 0 ? 'true' : 'false' ?>">
            <figure>
              <img src="<?= e($img('ind/' . $n . '.jpg')) ?>" width="860" height="620"
                   alt="" loading="lazy" decoding="async">
            </figure>
            <div class="gm-ind-body">
              <span class="gm-num"><?= e($n) ?></span>
              <h3><?= e($name) ?></h3>
              <p class="gm-ind-kicker"><?= e($kicker) ?></p>
              <div class="gm-ind-panel"><p><?= e($body) ?></p></div>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           Expertise — the capability cards
           --------------------------------------------------------------- */ ?>
  <section class="gm-sec gm-cap">
    <div class="gm-shell">
      <div class="gm-head">
        <p class="gm-eyebrow"><span class="gm-mark" aria-hidden="true"></span>Our expertise</p>
        <h2 class="gm-title">Game development<br><em>you can trust</em></h2>
        <p class="gm-sub">
          A game is a product with a loop instead of a funnel. The engineering discipline is the same
          one we bring to everything else; what changes is that the thing being measured is whether
          somebody wants to play it again tomorrow.
        </p>
      </div>

      <div class="gm-cap-grid">
        <?php foreach ($capabilities as $i => [$n, $title, $body]): ?>
          <article class="gm-cap-card" data-reveal style="--d:<?= $i % 3 ?>">
            <figure>
              <img src="<?= e($img('cap/' . $n . '.jpg')) ?>" width="760" height="500"
                   alt="" loading="lazy" decoding="async">
            </figure>
            <div class="gm-cap-body">
              <span class="gm-num"><?= e($n) ?></span>
              <h3><?= e($title) ?></h3>
              <p><?= e($body) ?></p>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           What we build — six

           The reference's equivalent lists six shipped titles. Ours lists the
           kinds of build, because inventing titles we have not shipped would
           put fabricated credentials on a page that asks for money.
           --------------------------------------------------------------- */ ?>
  <section class="gm-sec gm-work" id="gm-work">
    <div class="gm-shell">
      <div class="gm-head">
        <p class="gm-eyebrow"><span class="gm-mark" aria-hidden="true"></span>What we build</p>
        <h2 class="gm-title">Six kinds of build,<br>one <em>engineering standard</em></h2>
      </div>

      <div class="gm-work-grid">
        <?php foreach ($work as $i => [$n, $title, $body]): ?>
          <article class="gm-work-card" data-reveal style="--d:<?= $i % 3 ?>">
            <figure>
              <img src="<?= e($img('work/' . $n . '.jpg')) ?>" width="820" height="560"
                   alt="" loading="lazy" decoding="async">
              <span class="gm-crt" aria-hidden="true"></span>
            </figure>
            <div class="gm-work-body">
              <span class="gm-num"><?= e($n) ?></span>
              <h3><?= e($title) ?></h3>
              <p><?= e($body) ?></p>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           Proven results, real clients

           The site's own ten, described as what they are: iThrive's clients
           across sectors. Not presented as game studios, and not padded with
           logos we have no relationship with.
           --------------------------------------------------------------- */ ?>
  <section class="gm-sec gm-clients">
    <div class="gm-shell">
      <div class="gm-head gm-head--mid">
        <p class="gm-eyebrow"><span class="gm-mark" aria-hidden="true"></span>Proven results</p>
        <h2 class="gm-title">Real clients,<br><em>real products</em></h2>
        <p class="gm-sub">
          Game work is new for us as a named service; the engineering behind it is not. These are the
          products we have shipped across mobility, healthcare, retail and media — the same team, the
          same standard.
        </p>
      </div>

      <ul class="gm-client-grid">
        <?php foreach (CASE_STUDIES as $study): ?>
          <li>
            <a href="<?= e(url('case-studies/' . $study['slug'] . '.php')) ?>"
               title="<?= e($study['client']) ?>">
              <?= client_logo($study) ?>
              <span><?= e($study['industry']) ?></span>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           The process — four steps
           --------------------------------------------------------------- */ ?>
  <section class="gm-sec gm-process">
    <div class="gm-shell">
      <div class="gm-head">
        <p class="gm-eyebrow"><span class="gm-mark" aria-hidden="true"></span>How we work</p>
        <h2 class="gm-title">Playable first,<br><em>pretty second</em></h2>
        <p class="gm-sub">
          The order matters more here than anywhere else we work. A loop that is not fun in grey
          boxes does not become fun when the art arrives — it just becomes expensive.
        </p>
      </div>

      <ol class="gm-steps">
        <?php foreach ($process as $i => [$n, $title, $body]): ?>
          <li class="gm-step" data-reveal style="--d:<?= $i % 4 ?>">
            <figure>
              <img src="<?= e($img('step/' . $n . '.jpg')) ?>" width="800" height="520"
                   alt="" loading="lazy" decoding="async">
            </figure>
            <span class="gm-num"><?= e($n) ?></span>
            <h3><?= e($title) ?></h3>
            <p><?= e($body) ?></p>
          </li>
        <?php endforeach; ?>
      </ol>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           FAQ
           --------------------------------------------------------------- */ ?>
  <section class="gm-sec gm-faq">
    <div class="gm-shell gm-faq-grid">
      <div class="gm-faq-side">
        <p class="gm-eyebrow"><span class="gm-mark" aria-hidden="true"></span>FAQ</p>
        <h2 class="gm-title">What studios and<br>trainers <em>ask first</em></h2>
        <figure class="gm-faq-art">
          <img src="<?= e($img('faq/01.jpg')) ?>" width="800" height="620"
               alt="" loading="lazy" decoding="async">
        </figure>
      </div>

      <div class="gm-faq-list">
        <?php foreach ($faqs as $i => [$q, $a]): ?>
          <details class="gm-faq-item"<?= $i === 0 ? ' open' : '' ?>>
            <summary><?= e($q) ?><span class="gm-faq-mark" aria-hidden="true"></span></summary>
            <div class="gm-faq-body"><p><?= e($a) ?></p></div>
          </details>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           Close
           --------------------------------------------------------------- */ ?>
  <section class="gm-close">
    <div class="gm-close-wash" aria-hidden="true"></div>
    <div class="gm-shell">
      <p class="gm-eyebrow"><span class="gm-mark" aria-hidden="true"></span>Next step</p>
      <h2>Not sure where to start?<br><em>Tell us the idea.</em></h2>
      <p class="gm-close-lead">
        Describe the loop, the audience and the device it has to run on. If there is a game in it you
        will get a scope, a prototype plan and a budget range within a week — and if what you
        actually need is a simulation, an app or nothing at all, you will get that answer instead.
      </p>
      <div class="gm-actions gm-actions--mid">
        <button class="gm-btn gm-btn--primary" type="button"
                data-modal-open data-modal-service="Game Development">
          Talk about your idea<?= icon('arrow') ?>
        </button>
      </div>
    </div>
  </section>

</div>

<script src="<?= e(asset('assets/js/game-page.js')) ?>" defer></script>

<?php
require dirname(__DIR__) . '/includes/footer.php';
