<?php
/**
 * Micro-SaaS Product Development — the sixth service page off the shared layout.
 *
 * Built after absoluteapplabs.com/microsaas-product-development, section for
 * section, in iThrive's own words.
 *
 * ON COMPONENTS. The no-repeat rule holds — nothing here appears on another
 * page — but this page is deliberately lighter on Framer than the five before
 * it, and that is a conclusion rather than a shortcut. Six components across
 * those pages were measured rendering NOTHING: the PoC cube, the React liquid
 * carousel, the team arc, the brush reveal, the hover reveal, the dot grid,
 * the motion gallery and the water ripple. Every one of them computed its
 * layout inside requestAnimationFrame or painted to a canvas, and a tab that
 * never gets a frame got an empty rectangle.
 *
 * Two survived that triage. Only one is used:
 *
 *   clients   Blur Flow Logos      logos that swap with a blur, replacing
 *                                  client-logo-grid, which is already on the
 *                                  home page and two other service pages
 *
 * Eye Follow Button was the other, and it is dropped on the no-repeat rule.
 * components/watch-eyes.php already puts a pair of tracking eyes on the entry
 * gate, which is the first thing every visitor sees, so a second pair here
 * would read as the same idea twice however differently it is built.
 *
 * Everything else — including the 3D hero — is CSS with its geometry written
 * at render time, the approach that fixed the Dedicated Team hero after its
 * Framer component left ten cards stacked at one point.
 *
 * Theme: the site's own ramp. What makes this page its own is the APERTURE —
 * nested squares turning as they narrow onto a single lit point, which is the
 * shape of a product aimed at exactly one job.
 *
 * Pictures come from tools/saas-art.mjs; every slot prefers a photograph from
 * assets/img/saas/photo/ the moment one lands.
 */

declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/config.php';

$svc = service('micro-saas-development');

$page      = 'services';
$pageTitle = 'Micro-SaaS Product Development Company in Chennai';
$pageDesc  = 'iThrive Software builds micro-SaaS products — one job, done properly, cloud-native '
           . 'and instrumented, in front of paying users while the idea is still cheap to change.';
$ogImage   = 'service-' . $svc['group_slug'];

/* ---------------------------------------------------------------------------
 * Content
 * ------------------------------------------------------------------------ */

/** The hero's shard stack. */
$shards = [
    ['01', 'One job, done properly'],
    ['02', 'Cloud-native from day one'],
    ['03', 'Priced before it is built'],
    ['04', 'Instrumented, not guessed'],
    ['05', 'Small enough to change'],
    ['06', 'Yours, entirely'],
];

$stats = [
    ['9mo',  'Typical idea to market fit'],
    ['1',    'Job the product does well'],
    ['3',    'Clouds we build across'],
    ['100%', 'Source and IP, yours'],
];

/** The framework — six. */
$framework = [
    ['01', 'Product discovery and strategy',
     'The market, the specific pain, and the one thing the product has to do better than a spreadsheet. Most micro-SaaS that fails was aimed at a job nobody was actually paying to solve.'],
    ['02', 'UI/UX design for SaaS',
     'Interfaces for people who will use this every working day. Density over decoration, and the complicated task made ordinary rather than made pretty.'],
    ['03', 'MVP development',
     'The lean version that can be sold. Narrow enough to finish, complete enough that someone will put a card in — which is the only market signal that means anything.'],
    ['04', 'AI-powered features',
     'Where the product genuinely benefits: anticipating the next action, drafting the tedious part, ranking a queue. Not a chat widget bolted on so the pitch can say AI.'],
    ['05', 'Cloud-native engineering',
     'AWS, GCP or Azure, built for the bill as well as the load. A micro-SaaS with enterprise infrastructure costs is a hobby with extra steps.'],
    ['06', 'Ongoing management',
     'Feature work, scaling and the unglamorous maintenance that decides whether year two is profitable or a rewrite.'],
];

/** Verticals — five, three points each. */
$verticals = [
    ['01', 'E-commerce SaaS',
     'Inventory that stays honest and carts that get recovered, on a storefront where a hundred milliseconds is measurable in revenue.',
     ['Stock levels that do not drift out of true',
      'Abandoned carts recovered automatically',
      'Recommendations that respond to the session']],
    ['02', 'Healthcare SaaS',
     'Patient-facing work inside the constraints that actually govern the sector — consent, auditability and accuracy before anything else.',
     ['Secure messaging without the paperwork',
      'No-shows cut with automated reminders',
      'Insight that supports a clinician, never replaces one']],
    ['03', 'Finance SaaS',
     'Reporting and reconciliation that stop being manual, with the audit trail built in rather than added when someone asks.',
     ['Real-time reporting with no spreadsheet step',
      'Expenses and budgets tracked as they happen',
      'Compliance evidence produced as a by-product']],
    ['04', 'EdTech SaaS',
     'Long sessions and heavy state — progress, attempts, media. Losing a learner\'s place costs more than being slightly slow ever would.',
     ['Adaptive paths built per learner',
      'Feedback and marking automated where it is safe to',
      'Course delivery that scales past the cohort']],
    ['05', 'Enterprise SaaS',
     'The internal tool that replaces four spreadsheets and a weekly meeting, built to survive real permissions and real data volume.',
     ['Repetitive process automated end to end',
      'One source of truth across departments',
      'Decisions made from live data, not last month\'s']],
];

/** The advantage — four. */
$advantage = [
    ['01', 'We have scaled these before',
     'The difficult part of SaaS is not the first release, it is the second year — pricing changes, tenancy, migrations. We have done that part.'],
    ['02', 'AI where it earns its place',
     'Features that anticipate, draft or rank. We will tell you when a model adds nothing that a well-chosen default would not.'],
    ['03', 'Cloud-native, and cost-aware',
     'Built across AWS, GCP and Azure, with the infrastructure bill treated as a product constraint rather than a surprise.'],
    ['04', 'Strategy, not just delivery',
     'What to build, what to charge, what to leave out. A micro-SaaS lives or dies on the last of those.'],
];

$faqs = [
    ['What can a micro-SaaS product actually include?',
     'Everything a full SaaS can — auth, billing, tenancy, integrations, AI features, an admin side — the difference is scope, not sophistication. A micro-SaaS does one job for one audience and refuses the rest, which is what lets a small team ship it and keep it running profitably.'],
    ['Why choose micro-SaaS over building the full platform?',
     'Because the full platform is a bet you cannot afford to lose, and this one is. A narrow product reaches paying users in months rather than years, and what they do with it tells you which of your assumptions were wrong while changing them is still cheap. If the narrow version cannot find users, the broad one would not have either.'],
    ['Can it integrate with the systems we already run?',
     'Yes, and for most micro-SaaS that is the product. The value is usually in sitting between two systems that do not talk — so REST, GraphQL, webhooks and the older endpoints too, designed so a change at their end does not take yours down.'],
    ['What support comes after launch?',
     'Feature work, scaling, dependency and security updates, and monitoring that pages us rather than you. Priced monthly and cancellable — we would rather keep the work by being worth keeping.'],
    ['What makes yours different?',
     'Mostly that we will argue with the scope. Plenty of teams will build the thing you described; the useful part is the conversation about which third of it actually needs to exist for launch, and we would rather have that before the invoice than after it.'],
];

$extraHead = '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>'
    . '<link rel="stylesheet" href="https://fonts.googleapis.com/css2?'
    . 'family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;600;700'
    . '&family=Space+Grotesk:wght@400;500;600;700&display=swap">'
    . '<link rel="stylesheet" href="' . e(asset('assets/css/saas.css')) . '">';

require dirname(__DIR__) . '/includes/header.php';

$img = static function (string $rel): string {
    [$set, $file] = explode('/', $rel, 2);
    $photo = 'assets/img/saas/photo/' . $set . '-' . $file;

    return asset(is_file(ROOT_PATH . '/' . $photo) ? $photo : 'assets/img/saas/' . $rel);
};
?>

<div class="ms">

  <?php /* ---------------------------------------------------------------
           Hero — a CSS 3D stack of shards that turns under the pointer

           Geometry written at render time from each card's --i, so the stack
           is laid out by first paint. The Dedicated Team page's hero was a
           Framer component that computed the same thing inside rAF, and it
           put all ten of its cards at one point until a frame ran.
           --------------------------------------------------------------- */ ?>
  <section class="ms-hero" data-stack>
    <div class="ms-hero-wash" aria-hidden="true"></div>

    <div class="ms-shell ms-hero-grid">
      <div class="ms-hero-copy">
        <p class="ms-eyebrow"><span class="ms-ap" aria-hidden="true"></span>Micro-SaaS Product Development · Chennai</p>

        <h1 class="ms-h1">
          One job, done so well<br>
          <em>people pay for it</em>
        </h1>

        <p class="ms-lead">
          A micro-SaaS is not a small version of a big product. It is a narrow one — a single job for
          a single audience, priced before it is built, in front of paying users while the idea is
          still cheap to change. Most SaaS takes eighteen months to find its market. This is the
          method that halves that.
        </p>

        <div class="ms-actions">
          <button class="ms-btn ms-btn--primary" type="button"
                  data-modal-open data-modal-service="Micro-SaaS Development">
            Turn an idea into SaaS<?= icon('arrow') ?>
          </button>
          <a class="ms-btn ms-btn--ghost" href="#ms-framework">See the framework</a>
        </div>

        <ul class="ms-stats">
          <?php foreach ($stats as [$v, $l]): ?>
            <li><strong><?= e($v) ?></strong><span><?= e($l) ?></span></li>
          <?php endforeach; ?>
        </ul>
      </div>

      <div class="ms-hero-stage">
        <div class="ms-stack" data-stack-inner style="--n: <?= count($shards) ?>;">
          <?php foreach ($shards as $i => [$n, $title]): ?>
            <figure class="ms-shard" style="--i: <?= $i ?>;">
              <img src="<?= e($img('shard/' . $n . '.jpg')) ?>" width="760" height="1000"
                   alt="" loading="<?= $i < 2 ? 'eager' : 'lazy' ?>" decoding="async">
              <figcaption><span><?= e($n) ?></span><?= e($title) ?></figcaption>
            </figure>
          <?php endforeach; ?>
        </div>
        <?php /* Both verbs, because touch has no hover and tapping is what
                 brings an outer shard to the middle there. */ ?>
        <p class="ms-stage-hint">Tap or hover a card · drag to sweep the fan</p>
      </div>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           The framework — six, click to open
           --------------------------------------------------------------- */ ?>
  <section class="ms-sec ms-framework" id="ms-framework" data-frame>
    <div class="ms-shell">
      <div class="ms-head">
        <p class="ms-eyebrow"><span class="ms-ap" aria-hidden="true"></span>The framework</p>
        <h2 class="ms-title">Our framework for<br>your <em>micro-SaaS success</em></h2>
        <p class="ms-sub">
          Six stages, in this order, because each one is cheaper than the mistake it prevents in the
          next. Open any of them.
        </p>
      </div>

      <div class="ms-frame-grid">
        <?php foreach ($framework as $i => [$n, $title, $body]): ?>
          <article class="ms-frame-card<?= $i === 0 ? ' is-open' : '' ?>"
                   data-frame-card role="button" tabindex="0"
                   aria-expanded="<?= $i === 0 ? 'true' : 'false' ?>" style="--d:<?= $i % 3 ?>">
            <figure class="ms-frame-art">
              <img src="<?= e($img('frame/' . $n . '.jpg')) ?>" width="800" height="500"
                   alt="" loading="lazy" decoding="async">
              <span class="ms-frame-num"><?= e($n) ?></span>
            </figure>
            <h3 class="ms-frame-title"><?= e($title) ?></h3>
            <div class="ms-frame-panel"><p><?= e($body) ?></p></div>
            <span class="ms-frame-more" aria-hidden="true"></span>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           Verticals — five, as tabs
           --------------------------------------------------------------- */ ?>
  <section class="ms-sec ms-verts" data-verts>
    <div class="ms-shell">
      <div class="ms-head">
        <p class="ms-eyebrow"><span class="ms-ap" aria-hidden="true"></span>Where it pays</p>
        <h2 class="ms-title">Turning a niche idea<br>into a <em>profitable business</em></h2>
      </div>

      <div class="ms-vert-tabs" role="tablist" aria-label="Verticals">
        <?php foreach ($verticals as $i => [$n, $name]): ?>
          <button class="ms-vert-tab<?= $i === 0 ? ' is-on' : '' ?>" type="button"
                  role="tab" aria-selected="<?= $i === 0 ? 'true' : 'false' ?>"
                  aria-controls="ms-vert-<?= e($n) ?>" data-vert-tab="<?= $i ?>"><?= e($name) ?></button>
        <?php endforeach; ?>
      </div>

      <?php foreach ($verticals as $i => [$n, $name, $blurb, $points]): ?>
        <div class="ms-vert-panel" id="ms-vert-<?= e($n) ?>" role="tabpanel"
             data-vert-panel="<?= $i ?>"<?= $i === 0 ? '' : ' hidden' ?>>
          <figure class="ms-vert-art">
            <img src="<?= e($img('vert/' . $n . '.jpg')) ?>" width="900" height="600"
                 alt="" loading="lazy" decoding="async">
          </figure>
          <div class="ms-vert-body">
            <p class="ms-vert-kicker"><?= e($n) ?> · <?= e($name) ?></p>
            <p class="ms-vert-blurb"><?= e($blurb) ?></p>
            <ul>
              <?php foreach ($points as $pt): ?><li><?= e($pt) ?></li><?php endforeach; ?>
            </ul>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           Band — the aperture, narrowing

           Five squares, each turned and scaled a step further in, closing on
           one lit point. Pure CSS keyframes, so it is running before any
           script has loaded.
           --------------------------------------------------------------- */ ?>
  <section class="ms-band">
    <img class="ms-band-bg" src="<?= e($img('hero/01.jpg')) ?>" width="1600" height="900"
         alt="" loading="lazy" decoding="async">

    <div class="ms-shell ms-band-inner">
      <div class="ms-aperture" aria-hidden="true">
        <?php for ($i = 0; $i < 5; $i++): ?>
          <span style="--i: <?= $i ?>;"></span>
        <?php endfor; ?>
        <b></b>
      </div>

      <h2>Build. Modernise. Monetise.<br><em>In that order.</em></h2>

      <button class="ms-btn ms-btn--primary" type="button"
              data-modal-open data-modal-service="Micro-SaaS Development">
        Bring your idea alive<?= icon('arrow') ?>
      </button>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           The advantage — four
           --------------------------------------------------------------- */ ?>
  <section class="ms-sec ms-advantage">
    <div class="ms-shell">
      <div class="ms-head">
        <p class="ms-eyebrow"><span class="ms-ap" aria-hidden="true"></span>Why us</p>
        <h2 class="ms-title">Your advantage in<br><em>micro-SaaS</em>, built with AI</h2>
        <p class="ms-sub">
          Your idea deserves more than code. Four things decide whether a micro-SaaS is a business or
          an expensive hobby, and none of them is the framework you build it in.
        </p>
      </div>

      <div class="ms-adv-grid">
        <?php foreach ($advantage as $i => [$n, $title, $body]): ?>
          <article class="ms-adv-card" data-reveal style="--d:<?= $i % 2 ?>">
            <figure class="ms-adv-art">
              <img src="<?= e($img('adv/' . $n . '.jpg')) ?>" width="800" height="500"
                   alt="" loading="lazy" decoding="async">
            </figure>
            <div class="ms-adv-body">
              <span class="ms-num"><?= e($n) ?></span>
              <h3><?= e($title) ?></h3>
              <p><?= e($body) ?></p>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           Who we have shipped for — Framer's Blur Flow Logo carousel

           Not components/client-logo-grid.php: that marquee is already on the
           home page, software-development and reactjs-development, and this
           page may not repeat a component. Same ten logos, driven through the
           Framer carousel instead — five at a time, swapping with a blur.

           The array is built from CASE_STUDIES so it cannot drift from the
           marquee, and any client without a logo file is skipped rather than
           rendered as an empty slot.
           --------------------------------------------------------------- */ ?>
  <section class="ms-sec ms-clients">
    <div class="ms-shell">
      <div class="ms-head ms-head--mid">
        <p class="ms-eyebrow"><span class="ms-ap" aria-hidden="true"></span>Shipped for</p>
        <h2 class="ms-title">Narrow products, real<br>users, <em>paying customers</em></h2>
      </div>

      <?php
      $logos = [];

      foreach (CASE_STUDIES as $study) {
          if (empty($study['logo'])) {
              continue;
          }

          $logos[] = [
              'image' => [
                  'src' => asset('assets/img/clients/' . $study['logo']),
                  'alt' => $study['client'] . ' logo',
              ],
              'name' => $study['client'],
              'link' => site_origin() . url('case-studies/' . $study['slug'] . '.php'),
          ];
      }
      ?>

      <div class="ms-logo-row"
           data-ok="logo-blur"
           data-props='<?= e(json_encode([
               'logos'        => $logos,
               'desktopCount' => 5,
               'mobileCount'  => 3,
               'logoHeight'   => 46,
               'gap'          => 40,
               'margin'       => 8,
               'background'   => 'transparent',
               /* The plates are dark-on-light artwork, so they are inverted by
                  CSS on this site rather than greyed down here. */
               'monochrome'   => ['enabled' => true, 'grayscale' => 100, 'opacity' => 0.62, 'hoverRestore' => true],
               'animation'    => [
                   'direction'     => 'up',
                   'interval'      => 3.4,
                   'stagger'       => 180,
                   'inDuration'    => 0.5,
                   'outDuration'   => 0.4,
                   'blur'          => 8,
                   'slideDistance' => 60,
               ],
           ], JSON_THROW_ON_ERROR)) ?>'></div>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           FAQ
           --------------------------------------------------------------- */ ?>
  <section class="ms-sec ms-faq">
    <div class="ms-shell ms-faq-grid">
      <div class="ms-faq-side">
        <p class="ms-eyebrow"><span class="ms-ap" aria-hidden="true"></span>FAQ</p>
        <h2 class="ms-title">What founders ask<br><em>before they commit</em></h2>
        <figure class="ms-faq-art">
          <img src="<?= e($img('faq/01.jpg')) ?>" width="800" height="600"
               alt="" loading="lazy" decoding="async">
        </figure>
      </div>

      <div class="ms-faq-list">
        <?php foreach ($faqs as $i => [$q, $a]): ?>
          <details class="ms-faq-item"<?= $i === 0 ? ' open' : '' ?>>
            <summary><?= e($q) ?><span class="ms-faq-mark" aria-hidden="true"></span></summary>
            <div class="ms-faq-body"><p><?= e($a) ?></p></div>
          </details>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           Close
           --------------------------------------------------------------- */ ?>
  <section class="ms-close">
    <div class="ms-close-wash" aria-hidden="true"></div>
    <div class="ms-shell">
      <p class="ms-eyebrow"><span class="ms-ap" aria-hidden="true"></span>Next step</p>
      <h2>Ready to validate the idea<br>and <em>turn it into paying users?</em></h2>
      <p class="ms-close-lead">
        Tell us the one job your product would do and who is currently doing it by hand. If it is a
        micro-SaaS you will have a scope, a price and a date within a week — and if the honest answer
        is that the market is too thin, you will get that instead.
      </p>
      <div class="ms-actions ms-actions--mid">
        <button class="ms-btn ms-btn--primary" type="button"
                data-modal-open data-modal-service="Micro-SaaS Development">
          Validate my idea<?= icon('arrow') ?>
        </button>
      </div>
    </div>
  </section>

</div>

<script type="module" src="<?= e(asset('assets/dist/originkit/originkit.js')) ?>"></script>
<script src="<?= e(asset('assets/js/saas-page.js')) ?>" defer></script>

<?php
require dirname(__DIR__) . '/includes/footer.php';
