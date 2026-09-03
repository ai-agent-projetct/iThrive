<?php
/**
 * MVP Development — the one service page that is not the shared layout.
 *
 * Built after absoluteapplabs.com/mvp-development-company, section for section,
 * in iThrive's own words.
 *
 * It wears the SITE's palette rather than one of its own. An earlier pass gave
 * it amber and lime on warm charcoal; against every other route that read as a
 * different site rather than a different page, so the colours are style.css's
 * own tokens now — ink #0B0F17 under the cyan / blue / violet ramp — and what
 * makes this page distinct is its layout and its components.
 *
 * Six sections are Framer marketplace components, running as Framer publishes
 * them. They arrive through the Origin Kit island the same way the AI page runs
 * the Cover Flow Gallery: a `[data-ok]` host with its props as JSON, mounted
 * lazily once it is near the viewport.
 *
 *   hero        3D Magazine          orbit and flip a real WebGL book
 *   hero line   Typewriter Effect    the headline's second line cycles
 *   why         Card Showcase        auto-advancing progress cards
 *   inside      Glass Stack          glassmorphic panels
 *   band        Gradient Motion BG   a moving gradient behind the quote
 *   industries  Curved Gallery Arc   a draggable 3D arc
 *
 * Two sections are this page's own, deliberately:
 *
 *   advantages  five alternating image/text rows
 *   process     six steps; clicking one opens its card
 *
 * The process stepper was going to be Framer's Workflow Cards, but that and
 * Pixel Hover Card are both canvas exports whose props are per-instance ids
 * with the content baked into variants — six steps of our own copy cannot be
 * handed to them. Built here instead, with the same click-to-open behaviour.
 *
 * Every picture is rendered from markup by tools/mvp-art.mjs, in the same
 * palette: eight magazine pages, one opening band, five card motifs, five
 * advantage panels, five panel grounds, eight industry squares, six step
 * illustrations, six reason heads and one beside the FAQ.
 *
 * Degrades: every Framer host has real markup around it — headings, copy, the
 * FAQ in <details>, the stepper's six cards — so with the island absent the
 * page still reads completely and a crawler sees all of it.
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

/** The magazine's pages, in order. */
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

/** Why an MVP beats a full build — the card showcase. */
$why = [
    ['01', 'Evidence over opinion', 'A room full of senior opinions is not data. Twelve weeks and a live cohort is — and the cohort disagrees with the room more often than anyone expects.', 'Validation'],
    ['02', 'A tenth of the burn',   'A full build spends the budget before a single user has proved anything about it. An MVP spends a tenth, and buys the same answer.', 'Cost'],
    ['03', 'Traction raises rounds','Investors fund a curve. A pitch deck describes one; a released product with instrumented usage produces one.', 'Funding'],
    ['04', 'The architecture survives', 'Small does not mean throwaway. What we write in week three is the thing that scales in year two, because it was written that way.', 'Engineering'],
    ['05', 'A real stop condition', 'If the number does not move, you stop — having spent twelve weeks rather than two years, and knowing exactly why.', 'Discipline'],
];

/** The advantage of an MVP-first approach — five alternating rows. */
$advantages = [
    ['01', 'Build What Users Actually Need',
     'Features are chosen from what a real cohort does, not from the loudest opinion in the room. '
     . 'Every release is instrumented, so the next set of features is argued from behaviour rather than from a workshop.'],
    ['02', 'Reduce Development Costs by 60%',
     'Six features instead of forty, and no rebuild of work nobody wanted. Most of the saving is not in '
     . 'building faster — it is in the thirty-four things that never get built at all.'],
    ['03', 'Speed to Market With Real Insights',
     'Live in twelve weeks with analytics from day one. You reach the market while the idea is still '
     . 'yours alone, and you reach the second release aimed by data instead of by another round of guessing.'],
    ['04', 'Agile Product Development',
     'Two-week sprints against real data, with an installable build at the end of every one. Priorities '
     . 'can change between sprints without renegotiating the contract, and slippage shows up in week four rather than month seven.'],
    ['05', 'Validate Your Hypothesis Quickly and Cheaply',
     'One number, one threshold, one date, agreed before anything is scoped. If it does not move you stop '
     . '— twelve weeks in, with the answer and most of the budget still in hand.'],
];

/** What is actually inside an MVP — the glass stack. */
$inside = [
    ['The core loop, end to end', 'One complete journey a real person can finish: sign in, do the thing, get the result, and have a reason to come back tomorrow. Not a happy path that only works in the demo.'],
    ['Auth, roles and billing',   'Real authentication, real permissions, and Stripe or Razorpay wired up properly. An MVP that cannot take money cannot test whether anyone would pay.'],
    ['One integration that matters', 'The single system your product is useless without — your CRM, your ERP, the bank, the carrier — done properly rather than five done as stubs.'],
    ['Instrumentation from day one', 'Events on the loop, funnels, error tracking and cost per user. The metric you agreed in week zero has to be readable without anyone exporting a spreadsheet.'],
    ['The admin nobody budgets for', 'Support needs to reset a password, refund an order and see why a job failed. Skipping this is the most common reason an MVP dies of operations rather than of demand.'],
];

/** Eight industries — the folder cards. */
$industries = [
    ['01', 'FinTech', 'KYC, ledgers and reconciliation',
     'The first thing a fintech MVP has to prove is that onboarding survives real identity checks. We build the KYC path, a double-entry ledger you can audit, and one reconciliation job — before any of the features people demo.',
     ['KYC / AML onboarding', 'Double-entry ledger', 'UPI and card rails', 'Reconciliation']],

    ['02', 'HealthTech', 'Triage, records and consent',
     'Consent and record access come first, because nothing else can go live without them. The MVP proves one clinical pathway end to end with an audit trail, rather than eight pathways that cannot be turned on.',
     ['Consent capture', 'Care pathway', 'ABDM / FHIR records', 'Audit trail']],

    ['03', 'Logistics', 'Dispatch, tracking and proof of delivery',
     'The loop that matters is assign, move, prove. We build dispatch, live tracking and proof of delivery for one lane, and only then argue about routing optimisation.',
     ['Dispatch board', 'Live tracking', 'Proof of delivery', 'Carrier APIs']],

    ['04', 'Retail', 'Catalogue, checkout and returns',
     'Checkout is the only screen that has to be perfect on day one. The MVP proves catalogue to payment to return on real stock, with the merchandising rules left for release two.',
     ['Catalogue and search', 'Checkout', 'Payments', 'Returns']],

    ['05', 'EdTech', 'Cohorts, progress and assessment',
     'An education MVP lives or dies on whether a cohort finishes something. We build enrolment, one full learning path and its assessment, then instrument completion.',
     ['Enrolment', 'Learning path', 'Assessment', 'Completion analytics']],

    ['06', 'PropTech', 'Listings, tours and agreements',
     'The proof is a booking that turns into a signed agreement. Listings, a scheduled tour and e-sign, on real inventory — the CRM integrations come after somebody has actually signed.',
     ['Listings', 'Tour scheduling', 'E-signature', 'Document vault']],

    ['07', 'Manufacturing', 'Line data, quality and downtime',
     'One line, instrumented properly, beats a plant-wide dashboard with nothing behind it. We take live data off a single line, flag the defects and account for the downtime.',
     ['OPC-UA / MQTT ingest', 'Quality flags', 'Downtime reasons', 'OEE']],

    ['08', 'Media', 'Ingest, rights and distribution',
     'Rights are the constraint everything else hangs off. The MVP proves ingest, a rights window that is actually enforced, and one distribution target.',
     ['Ingest pipeline', 'Rights windows', 'Transcode', 'One distribution target']],
];

/** The six steps. Click one and its card opens — see assets/js/mvp-page.js. */
$steps = [
    ['01', 'Start With Clear Goals', 'Week 0 · 2 days',
     'We run collaborative sessions with the people who will actually use the product, validate the idea '
     . 'against what the market already does, and leave with the single number this MVP has to move — with a '
     . 'threshold against it and a date. Nothing gets scoped until that number is written down.',
     ['One agreed metric', 'Signed success criteria', 'Market validation']],

    ['02', 'Identify the Essential Features', 'Weeks 1–2',
     'We narrow your idea to the minimum set of features that makes the MVP genuinely useful and genuinely '
     . 'testable. Your list usually has forty items on it; six of them can move the number. The other '
     . 'thirty-four go on a roadmap you can still see, in priority order, so nothing is lost — only deferred.',
     ['Feature ranking', 'A visible roadmap', 'Scope in writing']],

    ['03', 'Create the Basic Screens & Flow', 'Weeks 2–3',
     'We lay out the key screens and the interactions between them, so you know exactly how the MVP will '
     . 'behave before a line of it is written. Arguments about the flow happen on a clickable prototype '
     . 'rather than in a sprint, where they are ten times cheaper.',
     ['Wireframes', 'Clickable prototype', 'User flow map']],

    ['04', 'Build the Working MVP', 'Weeks 4–8',
     'We develop the core product: clean UI, a stable backend, and the primary features needed for real '
     . 'use. Two-week sprints against real data, with something installable at the end of each one, so '
     . 'progress is a build you run yourself rather than a status report you read.',
     ['Fortnightly builds', 'Production architecture', 'Real data, not fixtures']],

    ['05', 'Test & Launch', 'Weeks 9–12',
     'The MVP is tested for usability and performance — automated suites, a real device matrix, load under '
     . 'the traffic you actually expect — then launched where your users can reach it easily. Auth, backups, '
     . 'rate limits, error tracking and the admin screen all ship with it.',
     ['QA and load testing', 'Store or web launch', 'Monitoring from day one']],

    ['06', 'Review & Iterate Next Steps', 'Ongoing',
     'Our agile process runs on iterative sprints with regular reviews, so the MVP adapts to what users '
     . 'actually do rather than to what the plan assumed. We watch the number for a fortnight and then take '
     . 'one of three honest decisions: scale it, change it, or stop.',
     ['Cohort analytics', 'Sprint reviews', 'Scale, change or stop']],
];

/** Why teams pick iThrive for this. */
$reasons = [
    ['01', 'We argue the scope down', 'Most agencies quote your list back to you, because the list is the invoice. We will tell you which six items matter and put the rest on a roadmap, in writing, before we start.'],
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

/**
 * The picture for a slot, preferring a photograph.
 *
 * assets/img/mvp/photo/<set>-<n>.jpg is a real photograph made by
 * tools/mvp-photos.mjs; assets/img/mvp/<set>/<n>.jpg is the drawn composition
 * tools/mvp-art.mjs makes. The photograph wins wherever one exists, so the set
 * can be filled in a few at a time — the page picks up each new file with no
 * edit here — and the drawn version is what shows until then.
 */
$img = static function (string $rel): string {
    [$set, $file] = explode('/', $rel, 2);
    $photo = 'assets/img/mvp/photo/' . $set . '-' . $file;

    return asset(is_file(ROOT_PATH . '/' . $photo) ? $photo : 'assets/img/mvp/' . $rel);
};
?>

<div class="mvp">

  <?php /* The reactive honeycomb, behind everything. See assets/js/mvp-page.js. */ ?>
  <canvas class="mvp-hex" data-mvp-hex aria-hidden="true"></canvas>

  <?php /* ---------------------------------------------------------------
           Hero — a 3D magazine you can orbit, and a headline that types
           --------------------------------------------------------------- */ ?>
  <section class="mvp-hero">
    <div class="mvp-shell mvp-hero-grid">

      <div class="mvp-hero-copy">
        <p class="mvp-eyebrow">MVP Development Company · Chennai</p>

        <h1 class="mvp-h1">Launch an MVP that proves the idea</h1>

        <?php /* Framer's Typewriter Effect cycles the second line. The first
                 phrase is in the markup too, so the headline is never a blank
                 line before the island mounts. */ ?>
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
                    'pauseDuration' => 1800,
                    'cursorColor'   => '#9D4EDD',
                    'cursorWidth'   => 4,
                    'textColor'     => '#00F2FE',
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
          <a class="mvp-btn mvp-btn--ghost" href="#process">See the 6-step process<?= icon('arrow') ?></a>
        </div>

        <div class="mvp-stats">
          <?php foreach ($stats as [$value, $label]): ?>
            <div class="mvp-stat"><b><?= e($value) ?></b><span><?= e($label) ?></span></div>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="mvp-hero-art">
        <?php /* Framer's 3D Magazine. Orbit it, flip it — it is a real WebGL
                 book, and its pages are the playbook this practice runs. The
                 engine is a megabyte, so embed.jsx imports this one lazily and
                 only a page that mounts it pays. */ ?>
        <div class="mvp-magazine"
             data-ok="magazine-3d"
             data-props='<?= e(json_encode([
                 'openAtPage' => 0,
                 'pages' => array_map(static fn (array $p): array => [
                     'type'  => 'image',
                     'gloss' => 30,
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
                     'hoverColor' => '#00F2FE',
                     'gloss'      => 30,
                     'curve'      => 22,
                 ],
                 'animation' => [
                     'enterAnimation' => ['type' => 'none', 'speed' => 1, 'delay' => 0],
                     'autoFlip'       => ['enabled' => false, 'timing' => 2.5],
                     /* A slow breath rather than a spin. At the component's own
                        defaults (intensity 1, speed 2, rotation 2) the book
                        swung enough to be distracting beside body copy. */
                     'float'          => ['enabled' => true, 'intensity' => 0.10,
                                          'speed' => 0.22, 'rotationIntensity' => 0.09],
                 ],
                 'shadow' => true,
                 /*
                  * Swept against the real frame rather than guessed. 1.25 and
                  * above run the cover off the right edge and eat "EDITION 04";
                  * 0.95 fits with room to spare but reads small. 1.10 is the
                  * largest that keeps the whole cover inside the box.
                  *
                  * Camera x moves the book the SAME way, not the opposite: +0.9
                  * pushed it further right and started clipping again, so a
                  * small negative value is what centres it.
                  */
                 'camera' => ['position' => ['x' => -0.5, 'y' => 0.95, 'z' => 3.3],
                              'rotation' => ['x' => 82, 'y' => 0, 'z' => 0], 'zoom' => 1.10, 'fov' => 45],
                 'orbitControls' => [
                     'enabled' => true,
                     'zoom'    => ['enabled' => false, 'min' => 0.1, 'max' => 10],
                     /*
                      * Both axes clamped, and the azimuth is the one that
                      * matters: left infinite, one sideways drag spins the book
                      * past edge-on and leaves the hero showing a white line.
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

  <?php /* --- The opening statement ---------------------------------------- */ ?>
  <section class="mvp-sec mvp-sec--panel">
    <div class="mvp-shell mvp-intro-grid">
      <figure class="mvp-figure">
        <img src="<?= e($img('intro/01.jpg')) ?>" width="1680" height="640"
             alt="Twelve weeks from an idea to a number you can trust"
             loading="lazy" decoding="async">
      </figure>

      <div>
        <p class="mvp-eyebrow">MVP Development Services</p>
        <h2 class="mvp-title">Launch an MVP that validates your <em>product's potential</em></h2>
        <p class="mvp-sub">
          A minimum viable product is not a cheap version of your product. It is the smallest thing
          that can be wrong in public — the one loop that tells you, with real users and real numbers,
          whether the idea behind it holds up. We build that loop, ship it, and measure it.
        </p>

        <ul class="mvp-points">
          <li>One metric agreed in writing before anything is scoped, with a threshold and a date.</li>
          <li>Six features in a typical v1, and a visible roadmap for the thirty-four we deferred.</li>
          <li>Production architecture from week three, so success does not force a rewrite.</li>
          <li>The repository, the accounts and the keys in your name from day one.</li>
        </ul>
      </div>
    </div>
  </section>

  <?php /* --- Why an MVP wins ---------------------------------------------- */ ?>
  <section class="mvp-sec">
    <div class="mvp-shell">
      <div class="mvp-head mvp-head--mid">
        <p class="mvp-eyebrow">Why MVP First</p>
        <h2 class="mvp-title">Why MVPs are ideal for <b>launching new products</b></h2>
        <p class="mvp-sub">Not because they are cheaper. Because they answer the question sooner.</p>
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
               'progressColor' => '#00F2FE',
               'animationSpeed'=> 6,
               'loop'          => true,
               'textColor'     => '#EAF0FA',
               'numberColor'   => '#00F2FE',
               'tagColor'      => '#9D4EDD',
               'imageRadius'   => 18,
               'padding'       => 0,
               'contentImageGap' => 40,
           ], JSON_THROW_ON_ERROR)) ?>'></div>

      <ul class="sr-only">
        <?php foreach ($why as $c): ?><li><?= e($c[0] . '. ' . $c[1] . ' — ' . $c[2]) ?></li><?php endforeach; ?>
      </ul>
    </div>
  </section>

  <?php /* --- Advantage of an MVP-first approach ----------------------------- */ ?>
  <section class="mvp-sec mvp-sec--panel" id="advantages">
    <div class="mvp-shell">
      <div class="mvp-head mvp-head--mid">
        <p class="mvp-eyebrow">The Advantage</p>
        <h2 class="mvp-title">Advantage of an <em>MVP-first</em> approach</h2>
        <p class="mvp-sub">
          Five things you get from building the smallest useful version first — and one of them is
          simply the money you do not spend.
        </p>
      </div>

      <?php /* Framer's Animated Path, drawing the route the five advantages sit
               on: a dotted line with a lit dot travelling it, starting when the
               section comes into view. */ ?>
      <div class="mvp-path-band"
           data-ok="animated-path"
           data-props='<?= e(json_encode([
               'lineColor'    => 'rgba(234,240,250,0.22)',
               'dotColor'     => '#00F2FE',
               'strokeWidth'  => 1.6,
               'dashLength'   => 8,
               'gapLength'    => 9,
               'dotSize'      => 13,
               /* Slow. The default 130 sends the dot across in about a second,
                  which is a flicker rather than a journey. */
               'speed'        => 46,
               'trailLength'  => 0.34,
               'startDelay'   => 0.2,
               'startOnView'  => true,
               'showBase'     => true,
               'baseOpacity'  => 0.16,
           ], JSON_THROW_ON_ERROR)) ?>'></div>

      <div class="mvp-advantages">
        <?php foreach ($advantages as [$n, $title, $body]): ?>
          <article class="mvp-adv">
            <figure class="mvp-adv-art">
              <img src="<?= e($img('advantage/' . $n . '.jpg')) ?>" width="1200" height="800"
                   alt="<?= e($title) ?>" loading="lazy" decoding="async">
            </figure>
            <div>
              <span class="mvp-adv-n">Advantage <?= e($n) ?></span>
              <h3><?= e($title) ?></h3>
              <p><?= e($body) ?></p>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <?php /* --- What is inside, as an image trail ------------------------------ */ ?>
  <section class="mvp-sec" id="inside">
    <div class="mvp-shell">
      <div class="mvp-head mvp-head--mid">
        <p class="mvp-eyebrow">Scope</p>
        <h2 class="mvp-title">What we actually build <em>inside</em> your MVP</h2>
        <p class="mvp-sub">
          Five things, every time. Everything else is a roadmap item pretending to be a requirement.
          Move the cursor across the panel.
        </p>
      </div>

      <?php /* Framer's Image Trail Effect: the pictures follow the pointer and
               drift away behind it. It carries no text of its own, so the five
               items are listed underneath — which is also what a reader with no
               script gets. */ ?>
      <div class="mvp-trail-host"
           data-ok="image-trail"
           data-props='<?= e(json_encode([
               'images' => array_map(static fn (array $i, int $n): array => [
                   'src' => $img('trail/0' . ($n + 1) . '.jpg'),
                   'alt' => $i[0],
               ], $inside, array_keys($inside)),
               'itemWidth'     => 210,
               'aspectRatio'   => 1.25,
               'radius'        => 16,
               'threshold'     => 86,
               'duration'      => 1.1,
               'exitStyle'     => 'drift',
               'driftStrength' => 70,
               'maxRotation'   => 9,
               'background'    => 'rgba(0,0,0,0)',
               'cursorType'    => 'crosshair',
               'cursorSize'    => 30,
               'showHint'      => true,
               'hintText'      => 'Move your cursor',
               'hintColor'     => 'rgba(234,240,250,0.5)',
           ], JSON_THROW_ON_ERROR)) ?>'></div>

      <div class="mvp-trail-list">
        <?php foreach ($inside as $i => [$title, $body]): ?>
          <div class="mvp-trail-item">
            <i><?= e(str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT)) ?></i>
            <b><?= e($title) ?></b>
            <span><?= e($body) ?></span>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <?php /* --- Quote band over a moving gradient ----------------------------- */ ?>
  <section class="mvp-band">
    <div class="mvp-band-bg"
         data-ok="gradient-motion-bg"
         data-props='<?= e(json_encode([
             'colorStops'     => ['#00F2FE', '#4EA8FF', '#9D4EDD'],
             'baseBackground' => 'rgba(11,15,23,0)',
             'blendMode'      => 'screen',
             'opacity'        => 44,
             'contrast'       => 106,
             'shapeStyle'     => 'Blob',
             'blobCount'      => 3,
             'blurAmount'     => 170,
             'sizeMin'        => 55,
             'sizeMax'        => 88,
             'animate'        => true,
             /* Slower again. The component's default is 40; at 16 it still
                drifted faster than a sentence takes to read. */
             'speed'          => 7,
             'motionStyle'    => 'Drift',
             'motionRange'    => 34,
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

  <?php /* --- Industries, as folder cards ------------------------------------ */ ?>
  <section class="mvp-sec">
    <div class="mvp-shell">
      <div class="mvp-head mvp-head--mid">
        <p class="mvp-eyebrow">Footprint</p>
        <h2 class="mvp-title">Our MVP footprint across <b>industries</b></h2>
        <p class="mvp-sub">
          Eight sectors, and the part of each one an MVP has to prove before anything else is worth
          building. Hover a folder to look inside; click to keep it open.
        </p>
      </div>

      <?php /* After Framer's paid "Card — Folder" — see assets/css/mvp.css for
               what its description asks for and how this is built. */ ?>
      <div class="mvp-folders" data-folders>
        <?php /*
          An <article> with role="button", not a real <button>.

          A button's content model is phrasing content, so the h3, p and ul this
          card needs are invalid inside one — the parser hoists them straight
          back out, which is exactly what collapsed this grid the first time.
          role and tabindex give it the same keyboard behaviour without lying to
          the parser about what it contains.
        */ ?>
        <?php foreach ($industries as [$n, $name, $short, $proves, $chips]): ?>
          <article class="mvp-folder" data-folder role="button" tabindex="0"
                   aria-expanded="false" aria-label="<?= e($name) ?> — open for detail">
            <span class="mvp-folder-tab"><?= e($n) ?> · <?= e(strtoupper($name)) ?></span>

            <div class="mvp-folder-body">
              <figure class="mvp-folder-sheet">
                <img src="<?= e($img('industry/' . $n . '.jpg')) ?>" width="900" height="900"
                     alt="" loading="lazy" decoding="async">
              </figure>

              <div class="mvp-folder-flap">
                <h3><?= e($name) ?></h3>
                <p><?= e($short) ?></p>
              </div>
            </div>

            <div class="mvp-folder-inner">
              <p><?= e($proves) ?></p>
              <ul><?php foreach ($chips as $c): ?><li><?= e($c) ?></li><?php endforeach; ?></ul>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <?php /* --- The six steps, on a wheel -------------------------------------- */ ?>
  <section class="mvp-sec mvp-sec--panel" id="process">
    <div class="mvp-shell">
      <div class="mvp-head mvp-head--mid">
        <p class="mvp-eyebrow">The Process</p>
        <h2 class="mvp-title">How we turn prototypes into <b>scalable products</b></h2>
        <p class="mvp-sub">
          We break your idea into achievable milestones with our proven MVP development services,
          simplifying the entire product development cycle so every step feels clear, structured and
          within reach. Turn the dial, or click a step.
        </p>
      </div>

      <?php /* After Framer's paid "Wheel Timeline" — see assets/css/mvp.css and
               assets/js/mvp-page.js. --a is each marker's angle on the ring and
               --r its radius; the ring's own rotation is taken back off every
               marker so the numbers stay upright as it turns. */ ?>
      <div class="mvp-wheel" data-wheel>
        <div class="mvp-dial">
          <div class="mvp-ring" data-ring>
            <?php foreach ($steps as $i => [$n, $title]): ?>
              <button class="mvp-mark" type="button" role="tab" data-mark
                      id="mvp-mark-<?= e($n) ?>" aria-controls="mvp-wcard-<?= e($n) ?>"
                      aria-selected="<?= $i === 0 ? 'true' : 'false' ?>"
                      aria-label="Step <?= e($n) ?>: <?= e($title) ?>"
                      style="--a: <?= $i * 60 ?>deg; --r: 40cqmin;"><?= e($n) ?></button>
            <?php endforeach; ?>
          </div>

          <div class="mvp-hub">
            <div>
              <span class="mvp-hub-n" data-wheel-readout>01</span>
              <small>of six</small>
            </div>
          </div>

          <div class="mvp-dial-nav">
            <button type="button" data-wheel-prev aria-label="Previous step">&#8249;</button>
            <button type="button" data-wheel-next aria-label="Next step">&#8250;</button>
          </div>
        </div>

        <div class="mvp-wheelcards">
          <?php foreach ($steps as $i => [$n, $title, $when, $body, $meta]): ?>
            <article class="mvp-wheelcard<?= $i === 0 ? ' is-open' : '' ?>"
                     data-wheelcard role="tabpanel"
                     id="mvp-wcard-<?= e($n) ?>" aria-labelledby="mvp-mark-<?= e($n) ?>">
              <figure class="mvp-wheelcard-art">
                <img src="<?= e($img('step/' . $n . '.jpg')) ?>" width="1200" height="800"
                     alt="<?= e($title) ?>" loading="lazy" decoding="async">
              </figure>
              <div class="mvp-wheelcard-body">
                <p class="mvp-wheelcard-k">Step <?= e($n) ?> · <?= e($when) ?></p>
                <h3><?= e($title) ?></h3>
                <p><?= e($body) ?></p>
                <ul class="mvp-wheelcard-meta">
                  <?php foreach ($meta as $m): ?><li><?= e($m) ?></li><?php endforeach; ?>
                </ul>
              </div>
            </article>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </section>

  <?php /* --- Why us, on a sticky 3D helix -------------------------------------
           After Framer's paid "Sticky Spiral Steps", built from its live demo
           at stickyspiral.framer.website — see assets/css/mvp.css for what was
           measured off it and why the first attempt was wrong.
           --------------------------------------------------------------- */ ?>
  <section class="mvp-sec mvp-spiral" data-spiral>
    <div class="mvp-shell">
      <div class="mvp-head mvp-head--mid">
        <p class="mvp-eyebrow">Why iThrive</p>
        <h2 class="mvp-title">Why choose us for <em>MVP development</em></h2>
        <p class="mvp-sub">
          Six things you can hold us to — every one of them in the contract, not just on the page.
          Keep scrolling: the spiral turns one to the front at a time.
        </p>
      </div>
    </div>

    <div class="mvp-helix-track" data-helix-track>
      <div class="mvp-helix-stage">
        <div class="mvp-helix" data-helix>
          <?php foreach ($reasons as $i => [$n, $title, $body]): ?>
            <article class="mvp-helix-card<?= $i === 0 ? ' is-front' : '' ?>"
                     data-helix-card style="--k: <?= $i ?>;">
              <figure class="mvp-helix-art">
                <img src="<?= e($img('reason/' . $n . '.jpg')) ?>" width="600" height="420"
                     alt="" loading="lazy" decoding="async">
              </figure>
              <div class="mvp-helix-body">
                <h3><span><?= e((string) (int) $n) ?>.</span> <?= e($title) ?></h3>
                <div class="mvp-helix-rule" aria-hidden="true"></div>
                <p><?= e($body) ?></p>
              </div>
            </article>
          <?php endforeach; ?>
        </div>

        <p class="mvp-helix-hud">
          <span data-helix-label>01 / 06</span>
          <span class="mvp-helix-bar"><span data-helix-bar></span></span>
          <span>Scroll to turn</span>
        </p>
      </div>
    </div>
  </section>

  <?php /* --- FAQ ------------------------------------------------------------ */ ?>
  <section class="mvp-sec mvp-sec--panel" id="faq">
    <div class="mvp-shell mvp-faq-grid">
      <div>
        <p class="mvp-eyebrow">Straight Answers</p>
        <h2 class="mvp-title">MVP development, <b>answered</b></h2>
        <p class="mvp-sub">
          These come from the site's own answer book, so iThrive AI at the corner of this page will
          say the same thing in any of six languages.
        </p>
        <figure class="mvp-figure" style="margin-top:1.8rem">
          <img src="<?= e($img('faq/01.jpg')) ?>" width="1200" height="800"
               alt="" loading="lazy" decoding="async">
        </figure>
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

<?php /* The island that carries the Framer components. Mounts are lazy: nothing
         is built until its host is near the viewport, and the magazine's WebGL
         engine is a separate chunk fetched only here. */ ?>
<script type="module" src="<?= e(asset('assets/dist/originkit/originkit.js')) ?>"></script>

<?php /* The honeycomb and the stepper — this page's own two behaviours. */ ?>
<script src="<?= e(asset('assets/js/mvp-page.js')) ?>" defer></script>

<?php
require dirname(__DIR__) . '/includes/footer.php';
