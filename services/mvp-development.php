<?php
/**
 * MVP Development — the one service page that is not the shared layout.
 *
 * Built after absoluteapplabs.com/mvp-development-company, section for section,
 * but written in iThrive's own words and given its own theme: signal amber and
 * electric lime on warm charcoal, deliberately not the cyan-and-violet the AI
 * Development Company page wears. See assets/css/mvp.css.
 *
 * Nine of its sections are Framer marketplace components, running as Framer
 * publishes them. They arrive through the Origin Kit island the same way the AI
 * page runs the Cover Flow Gallery: a `[data-ok]` host with its props as JSON,
 * mounted lazily once it is near the viewport.
 *
 *   hero          3D Magazine          orbit and flip a real WebGL book
 *   hero line     Typewriter Effect    the headline's second line cycles
 *   marquee       Infinity Text        a curved kinetic band
 *   compare       Split Reveal         drag between two scopes
 *   why           Card Showcase        auto-advancing progress cards
 *   inside        Glass Stack          glassmorphic panels
 *   band          Gradient Motion BG   a moving gradient behind the quote
 *   industries    Curved Gallery Arc   a draggable 3D arc
 *   process       Scroll Timeline      scroll-driven milestones
 *
 * All ten were vendored with tools/fetch-framer.mjs, which walks each module's
 * own imports and rewrites only the remote URLs — everything else is
 * byte-for-byte what Framer serves, so any of them can be re-fetched and
 * dropped over the old copy. Every one is free and published; nothing here is
 * a lookalike of a paid component.
 *
 * The pictures are all rendered from markup by tools/mvp-art.mjs, in the same
 * palette: eight portrait pages for the magazine, five cards, five panel
 * backgrounds, eight industry squares and the before/after pair.
 *
 * Degrades: every Framer host has real markup around it — headings, copy, the
 * FAQ in <details> elements — so with the island absent the page still reads
 * completely and a crawler sees all of it. The magazine's own pages are also
 * listed as an ordinary <ol> for the same reason.
 */

declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/config.php';

$svc = service('mvp-development');

$page      = 'services';
$pageTitle = 'MVP Development Company in Chennai';
$pageDesc  = 'iThrive Software builds minimum viable products in twelve weeks — one metric, six '
           . 'features, real users and full source ownership from day one.';
$ogImage   = 'service-' . $svc['group_slug'];

/* ---------------------------------------------------------------------------
 * Content
 * ------------------------------------------------------------------------ */

/** The magazine's pages, in order. Eight images, rendered by tools/mvp-art.mjs. */
$playbook = [
    ['01', 'Front cover — The MVP Playbook'],
    ['02', 'Week 0 — one metric, agreed in writing'],
    ['03', 'Weeks 1–2 — scope, negotiated down'],
    ['04', 'Weeks 3–8 — the core loop, end to end'],
    ['05', 'Weeks 9–10 — production hygiene, not polish'],
    ['06', 'Weeks 11–12 — real users, not a demo day'],
    ['07', 'Day one — you own all of it'],
    ['08', 'Back cover — build only what can be wrong in public'],
];

$stats = [
    ['12', 'Weeks, idea to first release'],
    ['6', 'Features in a typical v1'],
    ['100%', 'Source and IP, yours'],
    ['40+', 'MVPs shipped since 2019'],
];

/** The five reasons an MVP beats a full build — the card showcase. */
$why = [
    ['01', 'Evidence over opinion', 'A room full of senior opinions is not data. Twelve weeks and a live cohort is — and the cohort disagrees with the room more often than anyone expects.', 'Validation'],
    ['02', 'A tenth of the burn',   'A full build spends the budget before a single user has proved anything about it. An MVP spends a tenth, and buys the same answer.', 'Cost'],
    ['03', 'Traction raises rounds','Investors fund a curve. A pitch deck describes one; a released product with instrumented usage produces one.', 'Funding'],
    ['04', 'The architecture survives', 'Small does not mean throwaway. What we write in week three is the thing that scales in year two, because it was written that way.', 'Engineering'],
    ['05', 'A real stop condition', 'If the number does not move, you stop — having spent twelve weeks rather than two years, and knowing exactly why.', 'Discipline'],
];

/** What is actually inside an MVP — the glass stack. */
$inside = [
    ['The core loop, end to end', 'One complete journey a real person can finish: sign in, do the thing, get the result, and have a reason to come back tomorrow. Not a happy path that only works in the demo.'],
    ['Auth, roles and billing',   'Real authentication, real permissions, and Stripe or Razorpay wired up properly. An MVP that cannot take money cannot test whether anyone would pay.'],
    ['One integration that matters', 'The single system your product is useless without — your CRM, your ERP, the bank, the carrier — done properly rather than five done as stubs.'],
    ['Instrumentation from day one', 'Events on the loop, funnels, error tracking and cost per user. The metric you agreed in week zero has to be readable without anyone exporting a spreadsheet.'],
    ['The admin nobody budgets for', 'Support needs to reset a password, refund an order and see why a job failed. Skipping this is the most common reason an MVP dies of operations rather than of demand.'],
];

/** Eight industries — the curved arc. */
$industries = [
    ['01', 'FinTech',       'KYC, ledgers and reconciliation'],
    ['02', 'HealthTech',    'Triage, records and consent'],
    ['03', 'Logistics',     'Dispatch, tracking and proof of delivery'],
    ['04', 'Retail',        'Catalogue, checkout and returns'],
    ['05', 'EdTech',        'Cohorts, progress and assessment'],
    ['06', 'PropTech',      'Listings, tours and agreements'],
    ['07', 'Manufacturing', 'Line data, quality and downtime'],
    ['08', 'Media',         'Ingest, rights and distribution'],
];

/** The twelve weeks — the scroll timeline. bg/fg are the component's own keys. */
$timeline = [
    ['bg' => '#0B0B0E', 'fg' => '#FF8A3D', 'year' => '00', 'eyebrow' => '01/ Week 0 — discovery and the one metric',
     'desc' => 'Two days with the people who will actually use it. We leave with the single number that decides whether this MVP worked, a threshold against it, and a date.'],
    ['bg' => '#FF8A3D', 'fg' => '#14100B', 'year' => '02', 'eyebrow' => '02/ Weeks 1–2 — scope, negotiated down',
     'desc' => 'Your list has forty items. Six can move the metric. The other thirty-four go on a roadmap you can still see — the hardest fortnight of the build, and the cheapest.'],
    ['bg' => '#101016', 'fg' => '#C6FF4A', 'year' => '08', 'eyebrow' => '03/ Weeks 3–8 — the core loop, built',
     'desc' => 'Two-week sprints against real data, with something installable at the end of each one. Slippage shows up in week four rather than month seven.'],
    ['bg' => '#C6FF4A', 'fg' => '#12140A', 'year' => '10', 'eyebrow' => '04/ Weeks 9–10 — production hygiene',
     'desc' => 'Auth, roles, backups, rate limits, error tracking and the admin screen. The unglamorous half that decides whether the MVP survives its first hundred users.'],
    ['bg' => '#0B0B0E', 'fg' => '#F4F4F6', 'year' => '12', 'eyebrow' => '05/ Weeks 11–12 — real users, watched',
     'desc' => 'We release to a real cohort, instrument the loop and watch the metric for a fortnight. You get numbers, not an opinion about numbers.'],
    ['bg' => '#161620', 'fg' => '#FF8A3D', 'year' => '13+', 'eyebrow' => '06/ After — ship, stop, or scale',
     'desc' => 'Three honest outcomes, decided by the number rather than by whoever is most senior in the room. Two of them save you a year.'],
];

/** Why teams pick iThrive for this. */
$reasons = [
    ['01', 'We argue the scope down', 'Most agencies quote your list back to you because the list is the invoice. We will tell you which six items matter and put the rest on a roadmap, in writing, before we start.'],
    ['02', 'Senior engineers only',   'No practice-on-your-project staffing. The people in the discovery call are the people who write the code, and there are fewer of them than you expect.'],
    ['03', 'Installable every Friday','A build you can run yourself at the end of every sprint. Progress is something you hold, not a status report you read.'],
    ['04', 'Full ownership, day one', 'The repository, cloud accounts, domain, signing keys and Figma files go into your name with history intact — including the right to take it elsewhere.'],
    ['05', 'Built to survive success','Modular services, typed end to end, CI/CD and a schema that does not need replacing at ten thousand users. Small is not the same as temporary.'],
    ['06', '90-day warranty',         'Any defect traceable to our code is fixed at our expense, same-business-day response, targeted within 72 hours by severity.'],
];

/** Ids from includes/faq.php, so the assistant answers these too, in six languages. */
$faqIds = ['q45', 'q123', 'q43', 'q46', 'q124', 'q47', 'q125'];
$faqs   = array_values(array_filter(FAQ, static fn (array $e): bool => in_array($e['id'], $faqIds, true)));

$schema = [
    '@type'       => 'Service',
    'name'        => 'MVP Development',
    'serviceType' => $svc['group'],
    'description' => $pageDesc,
    'url'         => canonical('services/mvp-development.php'),
    'provider'    => ['@type' => 'Organization', 'name' => SITE_NAME, 'url' => canonical('')],
    'areaServed'  => [
        ['@type' => 'City',    'name' => 'Chennai'],
        ['@type' => 'City',    'name' => 'Bangalore'],
        ['@type' => 'City',    'name' => 'Coimbatore'],
        ['@type' => 'Country', 'name' => 'India'],
    ],
    'hasOfferCatalog' => [
        '@type'           => 'OfferCatalog',
        'name'            => 'MVP development capabilities',
        'itemListElement' => array_map(static fn (array $i): array => [
            '@type'       => 'Offer',
            'itemOffered' => ['@type' => 'Service', 'name' => $i[0], 'description' => $i[1]],
        ], $inside),
    ],
];

/* The page's own display and mono faces, and its stylesheet. */
$extraHead = '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>'
    . '<link rel="stylesheet" href="https://fonts.googleapis.com/css2?'
    . 'family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;600;700'
    . '&family=Outfit:wght@700;800;900&family=Space+Grotesk:wght@400;500;600;700&display=swap">'
    . '<link rel="stylesheet" href="' . e(asset('assets/css/mvp.css')) . '">';

require dirname(__DIR__) . '/includes/header.php';

/** Absolute URLs for the components, which take image props as plain strings. */
$img = static fn (string $rel): string => asset('assets/img/mvp/' . $rel);
?>

<div class="mvp">

  <?php /* ---------------------------------------------------------------
           Hero — a 3D magazine you can orbit, and a headline that types
           --------------------------------------------------------------- */ ?>
  <section class="mvp-hero">
    <div class="mvp-shell mvp-hero-grid">

      <div class="mvp-hero-copy">
        <p class="mvp-eyebrow">MVP Development Company · Chennai</p>

        <h1 class="mvp-h1">Launch an MVP that proves the idea</h1>

        <?php /* Framer's Typewriter Effect cycles the second line. The first
                 word is in the markup too, so the headline is never a blank
                 line before the island mounts — and a crawler reads a complete
                 sentence either way. */ ?>
        <p class="mvp-typeline">
          <span class="mvp-type-host"
                data-ok="typewriter-effect"
                data-props='<?= e(json_encode([
                    'words' => [
                        ['word' => 'in twelve weeks.'],
                        ['word' => 'with real users.'],
                        ['word' => 'not a slide deck.'],
                        ['word' => 'and you own the code.'],
                    ],
                    'typingSpeed'   => 62,
                    'deletingSpeed' => 34,
                    'pauseDuration' => 1700,
                    'cursorColor'   => '#FF8A3D',
                    'cursorWidth'   => 4,
                    'textColor'     => '#C6FF4A',
                    'font'          => ['fontSize' => 'inherit', 'fontWeight' => 900, 'letterSpacing' => '-0.045em'],
                ], JSON_THROW_ON_ERROR)) ?>'><noscript>in twelve weeks.</noscript></span>
        </p>

        <p class="mvp-lead">
          We build the smallest thing that can be wrong in public: one complete loop, six features,
          instrumented, in front of real users inside twelve weeks. Then the number tells you whether
          to scale it, change it or stop — while you can still afford all three.
        </p>

        <div class="mvp-actions">
          <button class="mvp-btn mvp-btn--primary" type="button"
                  data-modal-open data-modal-service="MVP Development">
            Start your MVP<?= icon('arrow') ?>
          </button>
          <a class="mvp-btn mvp-btn--ghost" href="#process">See the 12-week plan<?= icon('arrow') ?></a>
        </div>

        <div class="mvp-stats">
          <?php foreach ($stats as [$value, $label]): ?>
            <div class="mvp-stat"><b><?= e($value) ?></b><span><?= e($label) ?></span></div>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="mvp-hero-art">
        <?php /* Framer's 3D Magazine. Orbit it, flip it, throw it — it is a
                 real WebGL book, and its pages are the playbook this practice
                 actually runs. The engine is a megabyte, so embed.jsx imports
                 this one lazily and only a page that mounts it pays. */ ?>
        <div class="mvp-magazine"
             data-ok="magazine-3d"
             data-props='<?= e(json_encode([
                 'openAtPage' => 0,
                 'pages' => array_map(static fn (array $p): array => [
                     'type'  => 'image',
                     'gloss' => 34,
                     'image' => [
                         'src'       => $img('playbook/' . $p[0] . '.jpg'),
                         'srcSet'    => $img('playbook/' . $p[0] . '.jpg'),
                         'alt'       => $p[1],
                         'positionX' => '50%',
                         'positionY' => '50%',
                     ],
                 ], $playbook),
                 'pageConfig' => [
                     'pageSize' => ['sizeType' => 'preset', 'preset' => 'portrait-3-4',
                                    'width' => 1.28, 'height' => 1.71],
                     'fitMedia'   => 'stretch',
                     'hoverColor' => '#FF8A3D',
                     'gloss'      => 34,
                     'curve'      => 22,
                 ],
                 'animation' => [
                     'enterAnimation' => ['type' => 'none', 'speed' => 1, 'delay' => 0],
                     'autoFlip'       => ['enabled' => false, 'timing' => 2.5],
                     'float'          => ['enabled' => true, 'intensity' => 1,
                                          'speed' => 1.6, 'rotationIntensity' => 1.6],
                 ],
                 'shadow' => true,
                 /* Zoom is a trade against the frame: at 1.62 the cover ran off the
                    right edge and lost its last letters; at 1.15 the book was a
                    postage stamp in a 620px box. 1.22 is the value that still
                    fits the taller, narrower stage a phone gives it. */
                 'camera' => ['position' => ['x' => 0, 'y' => 0.95, 'z' => 3.3],
                              'rotation' => ['x' => 82, 'y' => 0, 'z' => 0], 'zoom' => 1.22, 'fov' => 45],
                 'orbitControls' => [
                     'enabled' => true,
                     'zoom'    => ['enabled' => false, 'min' => 0.1, 'max' => 10],
                     /*
                      * Both axes are clamped, and the azimuth is the one that
                      * matters: left infinite, a single sideways drag spins the
                      * book past edge-on and leaves the hero showing a white
                      * line. A generous cone still reads as free rotation, and
                      * cannot be left in a state nobody can read.
                      */
                     'rotation'=> ['enabled' => true, 'polarInfinite' => false,
                                   'polarMin' => 66, 'polarMax' => 104,
                                   'azimuthInfinite' => false,
                                   'azimuthMin' => -52, 'azimuthMax' => 52],
                     'enablePan' => false,
                 ],
                 'lights' => ['baseIntensity' => 0.95, 'lightsIntensity' => 1.5],
                 'canvasPreview' => true,
             ], JSON_THROW_ON_ERROR)) ?>'></div>

        <p class="mvp-mag-hint">Drag to orbit · click a page edge to turn it</p>

        <?php /* The same eight pages, readable with no WebGL and no script. */ ?>
        <ol class="sr-only">
          <?php foreach ($playbook as [, $caption]): ?><li><?= e($caption) ?></li><?php endforeach; ?>
        </ol>
      </div>

    </div>
  </section>

  <?php /* --- The six constraints, as a text wheel ---------------------------
           Framer publishes this as "Kinetic Text Slider"; its component is
           called InfiniteTextWheel, and that is what it is — a vertical wheel
           that curves its items around a centre and springs between them. It
           was in a 130px band first, which stacked all six words on one line. */ ?>
  <section class="mvp-sec mvp-sec--panel mvp-wheelsec">
    <div class="mvp-shell mvp-wheel-grid">
      <div>
        <p class="mvp-eyebrow">The Constraints</p>
        <h2 class="mvp-title">Six things we hold <b>every MVP</b> to</h2>
        <p class="mvp-sub">
          None of them is negotiable, and the first one decides the other five.
          Spin the wheel.
        </p>
      </div>

      <div class="mvp-wheel-host"
           data-ok="infinity-text"
           data-props='<?= e(json_encode([
               /* Plain strings: the component filters with item.trim(), so an
                  array of objects throws before it renders anything. */
               'items' => ['ONE METRIC', 'SIX FEATURES', 'TWELVE WEEKS',
                           'REAL USERS', 'YOUR CODE', 'SHIP OR STOP'],
               /*
                * lineHeight has to be a STRING here, and that is the whole
                * difference between a wheel and a pile.
                *
                * The component sets its row pitch to fontValueToPixels(lineHeight),
                * which returns a NUMBER unchanged — so lineHeight: 1 meant a row
                * height of one pixel and all six words landed on the same line.
                * A string under 3 with no unit is multiplied by the font size,
                * which is the ratio it was written to take.
                *
                * 'variant' is a Framer canvas font token and does nothing off it;
                * fontWeight and fontFamily are what actually reach the style.
                */
               'font'  => ['fontSize' => 46, 'lineHeight' => '1.28', 'letterSpacing' => '-0.04em',
                           'textAlign' => 'left', 'fontWeight' => 800,
                           'fontFamily' => "'Outfit', 'Space Grotesk', sans-serif"],
               'color'      => '#F4F4F6',
               'arrowColor' => '#FF8A3D',
               'arrowSize'  => 20,
               'arrowGap'   => 26,
               'sideGap'    => 30,
               'rowGap'     => 6,
               'curve'      => 74,
           ], JSON_THROW_ON_ERROR)) ?>'></div>
    </div>
  </section>

  <?php /* --- The scope argument, as a drag ------------------------------- */ ?>
  <section class="mvp-sec">
    <div class="mvp-shell">
      <div class="mvp-head">
        <p class="mvp-eyebrow">The Actual Problem</p>
        <h2 class="mvp-title">Most failed MVPs were never an <em>MVP</em></h2>
        <p class="mvp-sub">
          They were a full product with a smaller budget. Fourteen features, nine months, and the first
          honest signal arriving after the money has gone. Drag the handle: the left is the roadmap most
          founders arrive with, the right is what we agree to build first.
        </p>
      </div>

      <div class="mvp-compare"
           data-ok="split-reveal"
           data-props='<?= e(json_encode([
               'beforeImage'  => ['src' => $img('compare/before.jpg'), 'alt' => 'A fourteen-feature v1 roadmap'],
               'afterImage'   => ['src' => $img('compare/after.jpg'),  'alt' => 'A six-feature MVP scope'],
               'initialPosition' => 46,
               'fit'          => 'cover',
               'showHandle'   => true,
               'handleSize'   => 46,
               'handleColor'  => '#FF8A3D',
               'handleIconColor' => '#14100B',
               'dividerWidth' => 2,
               'dividerColor' => '#C6FF4A',
               'dividerShadow'=> true,
               'borderRadius' => '0px',
           ], JSON_THROW_ON_ERROR)) ?>'></div>

      <p class="mvp-compare-legend">
        <span><b>Left</b> — 14 features, ~9 months, first signal after launch</span>
        <span><b>Right</b> — 6 features, 12 weeks, first signal in week 13</span>
      </p>
    </div>
  </section>

  <?php /* --- Why an MVP wins ---------------------------------------------- */ ?>
  <section class="mvp-sec mvp-sec--panel">
    <div class="mvp-shell">
      <div class="mvp-head mvp-head--mid">
        <p class="mvp-eyebrow">Why MVP First</p>
        <h2 class="mvp-title">Five reasons an MVP beats a <b>full build</b></h2>
        <p class="mvp-sub">Not because it is cheaper. Because it answers the question sooner.</p>
      </div>

      <div class="mvp-cards-host"
           data-ok="card-showcase"
           data-props='<?= e(json_encode([
               'cards' => array_map(static fn (array $c): array => [
                   'number'      => $c[0],
                   'title'       => $c[1],
                   'description' => $c[2],
                   'tag'         => $c[3],
                   'image'       => ['src' => $img('why/' . $c[0] . '.jpg'), 'alt' => $c[1]],
               ], $why),
               'progressColor' => '#FF8A3D',
               'animationSpeed'=> 6,
               'loop'          => true,
               'textColor'     => '#F4F4F6',
               'numberColor'   => '#C6FF4A',
               'tagColor'      => '#FF8A3D',
               'imageRadius'   => 18,
               'padding'       => 0,
               'contentImageGap' => 40,
           ], JSON_THROW_ON_ERROR)) ?>'></div>

      <?php /* The five, as plain text, for a reader with no island. */ ?>
      <ul class="sr-only">
        <?php foreach ($why as $c): ?><li><?= e($c[0] . '. ' . $c[1] . ' — ' . $c[2]) ?></li><?php endforeach; ?>
      </ul>
    </div>
  </section>

  <?php /* --- What is inside ----------------------------------------------- */ ?>
  <section class="mvp-sec" id="inside">
    <div class="mvp-shell">
      <div class="mvp-head">
        <p class="mvp-eyebrow">Scope</p>
        <h2 class="mvp-title">What we actually build <em>inside</em> your MVP</h2>
        <p class="mvp-sub">
          Five things, every time. Everything else is a roadmap item pretending to be a requirement.
        </p>
      </div>

      <div class="mvp-stack-host"
           data-ok="glass-stack"
           data-props='<?= e(json_encode([
               'items' => array_map(static fn (array $i, int $n): array => [
                   'title' => $i[0],
                   'body'  => $i[1],
                   'backgroundImage' => ['src' => $img('inside/0' . ($n + 1) . '.jpg'), 'alt' => ''],
               ], $inside, array_keys($inside)),
               'direction'       => 'vertical',
               'gap'             => 18,
               'backgroundColor' => 'rgba(0,0,0,0)',
               'glassOpacity'    => 24,
               'borderRadius'    => 18,
               'padding'         => 30,
               'titleColor'      => '#F4F4F6',
               'bodyColor'       => 'rgba(244,244,246,0.72)',
               'hoverLift'       => 10,
               'containerPadding'=> 0,
               'backgroundBlur'  => 14,
           ], JSON_THROW_ON_ERROR)) ?>'></div>
    </div>
  </section>

  <?php /* --- Quote band over a moving gradient ----------------------------- */ ?>
  <section class="mvp-band">
    <div class="mvp-band-bg"
         data-ok="gradient-motion-bg"
         data-props='<?= e(json_encode([
             'colorStops'     => ['#FF8A3D', '#C6FF4A', '#7A3BFF'],
             'baseBackground' => '#08080B',
             'blendMode'      => 'screen',
             'opacity'        => 52,
             'contrast'       => 108,
             'shapeStyle'     => 'Blob',
             'blobCount'      => 3,
             'blurAmount'     => 150,
             'sizeMin'        => 55,
             'sizeMax'        => 88,
             'animate'        => true,
             'speed'          => 26,
             'motionStyle'    => 'Drift',
             'motionRange'    => 52,
             'seed'           => 12,
             'grainEnabled'   => true,
             'grainAmount'    => 12,
         ], JSON_THROW_ON_ERROR)) ?>'></div>

    <div class="mvp-shell">
      <div class="mvp-band-inner">
        <p class="mvp-band-quote">
          Ninety per cent of your product risk lives in the first ten per cent of the features.
          <span>Build that ten per cent, and nothing else.</span>
        </p>
        <div class="mvp-actions" style="justify-content:center">
          <button class="mvp-btn mvp-btn--primary" type="button"
                  data-modal-open data-modal-service="MVP Development">
            Scope my MVP<?= icon('arrow') ?>
          </button>
        </div>
      </div>
    </div>
  </section>

  <?php /* --- Industries ---------------------------------------------------- */ ?>
  <section class="mvp-sec">
    <div class="mvp-shell">
      <div class="mvp-head mvp-head--mid">
        <p class="mvp-eyebrow">Footprint</p>
        <h2 class="mvp-title">Where our MVPs have <b>gone live</b></h2>
        <p class="mvp-sub">Eight sectors, and the part of each one an MVP usually has to prove first. Drag the arc.</p>
      </div>
    </div>

    <div class="mvp-arc-host"
         data-ok="curved-gallery-arc"
         data-props='<?= e(json_encode([
             'images' => array_map(static fn (array $i): array => [
                 'src' => $img('industry/' . $i[0] . '.jpg'),
                 'alt' => $i[1] . ' — ' . $i[2],
             ], $industries),
             'backgroundColor' => 'rgba(0,0,0,0)',
             'cardSize'        => 250,
             'gap'             => 26,
             /* The fan only reads as an arc past about 150; below that the cards
                sit in what looks like an ordinary row. */
             'curve'           => 190,
             'perspective'     => 1500,
             'autoScrollSpeed' => 16,
             'dragSpeed'       => 1.1,
             'inertia'         => 0.94,
             'borderRadius'    => 18,
         ], JSON_THROW_ON_ERROR)) ?>'></div>

    <ul class="sr-only">
      <?php foreach ($industries as $i): ?><li><?= e($i[1] . ' — ' . $i[2]) ?></li><?php endforeach; ?>
    </ul>
  </section>

  <?php /* --- The twelve weeks ------------------------------------------------ */ ?>
  <section class="mvp-sec mvp-sec--tight" id="process">
    <div class="mvp-shell">
      <div class="mvp-head mvp-head--mid">
        <p class="mvp-eyebrow">The Twelve Weeks</p>
        <h2 class="mvp-title">How we turn a prototype into a <em>product</em></h2>
        <p class="mvp-sub">Six stages. Keep scrolling and each one takes the screen in turn.</p>
      </div>
    </div>

    <div class="mvp-timeline-host"
         data-ok="scroll-timeline"
         data-props='<?= e(json_encode(['items' => $timeline], JSON_THROW_ON_ERROR)) ?>'></div>

    <ol class="sr-only">
      <?php foreach ($timeline as $t): ?>
        <li><?= e($t['year'] . ' — ' . $t['eyebrow'] . '. ' . $t['desc']) ?></li>
      <?php endforeach; ?>
    </ol>
  </section>

  <?php /* --- Why us ------------------------------------------------------- */ ?>
  <section class="mvp-sec mvp-sec--panel">
    <div class="mvp-shell">
      <div class="mvp-head mvp-head--mid">
        <p class="mvp-eyebrow">Why iThrive</p>
        <h2 class="mvp-title">Six things you can hold us to</h2>
        <p class="mvp-sub">Every one of these is in the contract, not just on the page.</p>
      </div>

      <div class="mvp-reasons">
        <?php foreach ($reasons as [$n, $title, $body]): ?>
          <article class="mvp-reason">
            <span class="mvp-reason-n"><?= e($n) ?></span>
            <h3><?= e($title) ?></h3>
            <p><?= e($body) ?></p>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <?php /* --- FAQ ------------------------------------------------------------ */ ?>
  <section class="mvp-sec" id="faq">
    <div class="mvp-shell">
      <div class="mvp-head mvp-head--mid">
        <p class="mvp-eyebrow">Straight Answers</p>
        <h2 class="mvp-title">MVP development, <b>answered</b></h2>
        <p class="mvp-sub">
          The same answers iThrive AI gives — these come from the site's own answer book, so the
          assistant at the corner of this page will say the same thing in any of six languages.
        </p>
      </div>

      <div class="mvp-faq">
        <?php foreach ($faqs as $i => $entry): ?>
          <details class="mvp-q"<?= $i === 0 ? ' open' : '' ?>>
            <summary><?= e($entry['q']) ?></summary>
            <div class="mvp-q-body"><?= e($entry['a']) ?></div>
          </details>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <?php /* --- Closing --------------------------------------------------------- */ ?>
  <section class="mvp-sec mvp-final">
    <div class="mvp-shell">
      <div class="mvp-head mvp-head--mid">
        <p class="mvp-eyebrow">Start Your Project</p>
        <h2 class="mvp-title">Your idea, built in <em>weeks</em></h2>
        <p class="mvp-sub">
          Tell us the workflow and the number it has to move. We will come back with the six features
          we would build first, a twelve-week plan and a price — in writing, within two working days.
        </p>
      </div>

      <div class="mvp-actions">
        <button class="mvp-btn mvp-btn--primary" type="button"
                data-modal-open data-modal-service="MVP Development">
          Start your MVP<?= icon('arrow') ?>
        </button>
        <a class="mvp-btn mvp-btn--ghost" href="<?= e(url('services.php')) ?>">All services<?= icon('arrow') ?></a>
      </div>
    </div>
  </section>

</div>

<?php /* The island that carries all nine Framer components. Mounts are lazy:
         nothing is built until its host is near the viewport, and the
         magazine's WebGL engine is a separate chunk fetched only here. */ ?>
<script type="module" src="<?= e(asset('assets/dist/originkit/originkit.js')) ?>"></script>

<?php
require dirname(__DIR__) . '/includes/footer.php';
