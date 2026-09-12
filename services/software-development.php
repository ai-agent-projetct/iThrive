<?php
/**
 * Custom Software Development — the third page that leaves the shared service
 * layout, and the only one built as a single scroll experience.
 *
 * The brief was a poly.app-class site: one continuous 3D backdrop, sections
 * that re-form it as you pass them, and interaction rather than a stack of
 * cards. That is what this is — assets/js/software-stage.js runs one point
 * field behind the whole document, and each section declares the formation it
 * wants through `data-stage`.
 *
 * The rule the experience is built around: every word is real HTML in front of
 * the canvas. Nothing that matters for search, for an answer engine or for a
 * screen reader lives inside the WebGL context, and the page is complete with
 * JavaScript disabled — the backdrop simply never appears.
 *
 * Copy lives in includes/content-software.php.
 */

declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/config.php';

$page      = 'services';
$pageTitle = 'Custom Software Development Company in Chennai & Coimbatore';
$pageDesc  = 'iThrive Software builds custom software, enterprise platforms and AI-native products '
           . 'for businesses across Chennai, Coimbatore and India — owned by you, run in production.';
$ogImage   = 'services';

/** Service, catalogue and the three long-form graph nodes AEO actually reads. */
$schema = [
    '@type'       => 'Service',
    'name'        => 'Custom Software Development',
    'serviceType' => 'Software Development',
    'description' => SOFT_HERO['lead'],
    'url'         => canonical('services/software-development.php'),
    'provider'    => ['@type' => 'Organization', 'name' => SITE_NAME, 'url' => canonical('')],
    'areaServed'  => [
        ['@type' => 'City',    'name' => 'Chennai'],
        ['@type' => 'City',    'name' => 'Coimbatore'],
        ['@type' => 'City',    'name' => 'Bangalore'],
        ['@type' => 'State',   'name' => 'Tamil Nadu'],
        ['@type' => 'Country', 'name' => 'India'],
    ],
    'hasOfferCatalog' => [
        '@type'           => 'OfferCatalog',
        'name'            => 'Custom software development services',
        'itemListElement' => array_map(static fn (array $s): array => [
            '@type'       => 'Offer',
            'itemOffered' => ['@type' => 'Service', 'name' => $s['title'], 'description' => $s['body']],
        ], SOFT_SERVICES),
    ],
];

$schemaExtra = [
    [
        '@type'       => 'HowTo',
        'name'        => 'How iThrive Software delivers a custom software project',
        'description' => 'The seven stages of a custom software engagement, from ideation to support.',
        'totalTime'   => 'P16W',
        'step'        => array_values(array_map(static fn (int $i, array $s): array => [
            '@type'    => 'HowToStep',
            'position' => $i + 1,
            'name'     => $s['title'],
            'text'     => $s['body'],
        ], array_keys(SOFT_PROCESS), SOFT_PROCESS)),
    ],
    [
        '@type'      => 'FAQPage',
        'name'       => 'Custom software development — frequently asked questions',
        'speakable'  => [
            '@type'       => 'SpeakableSpecification',
            'cssSelector' => ['.sd-faq summary', '.sd-faq p'],
        ],
        'mainEntity' => array_map(static fn (array $f): array => [
            '@type'          => 'Question',
            'name'           => $f['q'],
            'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f['a']],
        ], SOFT_FAQ),
    ],
];
// No BreadcrumbList here: the schema component already derives one from the URL
// for every page, and a second one would compete with it.

$extraHead = '<link rel="preconnect" href="https://fonts.googleapis.com">'
    . '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>'
    . '<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;500;600;700&display=swap" rel="stylesheet">'
    . '<link rel="stylesheet" href="' . e(asset('assets/css/software.css')) . '">';

require dirname(__DIR__) . '/includes/header.php';
?>

<?php /* The point field. Fixed behind everything, decorative, and absent
         entirely without WebGL or with reduced motion asked for. */ ?>
<div class="sd-stage" data-sd-stage aria-hidden="true"></div>

<div class="sd-page" data-software-page>
  <div class="sd-progress" data-sd-progress aria-hidden="true"></div>

  <?php /*
     ── The film ────────────────────────────────────────────────────────
     The hero is the clip, and scrolling is what plays it: assets/js/scrub.js
     binds any [data-scrub] section holding a [data-scrub-video] and ties the
     playhead to how far you have scrolled through it. Same mechanism as the AI
     Enablement hero, same .afilm styles, so this adds markup and no CSS.

     --track is the whole speed dial. 2600vh leaves 2500vh of travel for 64
     seconds of film — about 420 pixels of scrolling per second, the slowest
     walk on the site. data-scrub-ease softens how hard the playhead is pulled
     toward that position; 0.05 glides where the 0.16 default snaps.

     Cut all-intra (a keyframe every third frame), which is what lets a seek
     land on the frame asked for instead of walking back to find one.

     Degrades: touch and reduced-motion skip the scrub and play it inline, which
     scrub.js handles; no JavaScript leaves the poster. Nothing here is content —
     every word is in the hero below, where a crawler can read it.
  */ ?>
  <section class="afilm" data-scrub data-scrub-ease="0.05" style="--track:2600vh"
           aria-label="Custom software development at iThrive">
    <div class="afilm-track">
      <div class="afilm-sticky">
        <?php /* preload="auto": a scrub is only smooth once the frames are
                 buffered — a seek into an unbuffered region paints nothing. */ ?>
        <video class="afilm-video" data-scrub-video
               muted playsinline preload="auto" disablepictureinpicture
               poster="<?= e(asset('assets/img/software-film-poster.jpg')) ?>">
          <source src="<?= e(asset('videos/software-film-mobile.mp4')) ?>" type="video/mp4" media="(max-width: 860px)">
          <source src="<?= e(asset('videos/software-film.mp4')) ?>" type="video/mp4">
        </video>

        <div class="afilm-scrim" aria-hidden="true"></div>
        <span class="afilm-progress" aria-hidden="true"><span data-scrub-bar></span></span>
      </div>
    </div>
  </section>

  <!-- ── Section 2 · the problem, unordered ─────────────────────────── -->
  <section class="sd-hero" data-stage="brief">
    <?php /* The hero plate: this page playing on a laptop in a lit room, with a
             slow push-in. Decoration only — every word below is real HTML in
             front of it, and the poster carries the still if the clip never
             loads. muted+playsinline+loop is what lets it autoplay at all. */ ?>
    <div class="sd-hero-film" aria-hidden="true">
      <video class="sd-hero-video" muted loop autoplay playsinline preload="metadata"
             disablepictureinpicture poster="<?= e(asset('assets/img/software-hero-poster.jpg')) ?>">
        <source src="<?= e(asset('assets/video/software-hero.mp4')) ?>" type="video/mp4">
      </video>
      <span class="sd-hero-scrim"></span>
    </div>

    <div class="shell">
      <div class="sd-hero-inner">
        <p class="eyebrow" data-sd-reveal><?= e(SOFT_HERO['eyebrow']) ?></p>

        <h1 class="sd-h1" data-sd-reveal style="--d:1">
          Software that behaves like <em>the business it was built for</em>.
        </h1>

        <p class="sd-lead" data-sd-reveal style="--d:2"><?= e(SOFT_HERO['lead']) ?></p>

        <div class="sd-cta-row" data-sd-reveal style="--d:3">
          <button class="btn btn-primary" type="button" data-modal-open>
            <?= e(SOFT_HERO['primary']['label']) ?><?= icon('arrow') ?>
          </button>
          <a class="btn btn-ghost" href="<?= e(SOFT_HERO['secondary']['href']) ?>">
            <?= e(SOFT_HERO['secondary']['label']) ?>
          </a>
        </div>

        <ul class="sd-stats" data-sd-reveal style="--d:4">
          <?php foreach (SOFT_STATS as $stat): ?>
            <li>
              <span class="sd-stat-value" data-count><?= e($stat['value']) ?></span>
              <span class="sd-stat-label"><?= e($stat['label']) ?></span>
            </li>
          <?php endforeach; ?>
        </ul>

        <p class="sd-scroll-cue" data-sd-reveal style="--d:5"><?= e(SOFT_HERO['scroll']) ?></p>
      </div>
    </div>
  </section>

  <!-- ── What we do · Light: Off/On Showcase ────────────────────────── -->
  <section class="section sd-intro-section" data-stage="blueprint">
    <div class="shell">
      <div class="sd-intro-grid">
        <div class="sd-intro-words">
          <p class="eyebrow" data-sd-reveal><?= e(SOFT_INTRO['eyebrow']) ?></p>
          <h2 class="section-title" style="text-align:left" data-sd-reveal><?= e(SOFT_INTRO['title']) ?></h2>
          <div class="sd-intro-copy" style="margin-top:22px">
            <?php foreach (SOFT_INTRO['body'] as $i => $para): ?>
              <p data-sd-reveal style="--d:<?= $i + 1 ?>"><?= e($para) ?></p>
            <?php endforeach; ?>
          </div>
        </div>

        <div class="sd-intro-interactive">
          <div data-ok="light-on-off"
               data-props='<?= e(json_encode([
                   'baseSrc'        => asset('assets/img/light-on-off/base.jpg'),
                   'topLightSrc'    => asset('assets/img/light-on-off/top-light.png'),
                   'bottomLightSrc' => asset('assets/img/light-on-off/bottom-light.png'),
                   'title'          => 'Light On/Off',
                   'subtitle'       => 'component',
                   'initialTop'     => true,
                   'initialBottom'  => true,
               ], JSON_THROW_ON_ERROR)) ?>'>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ── The theatre · services, with the rail tracking the scroll ──── -->
  <section class="section" id="build">
    <div class="shell">
      <div class="sd-theatre">
        <aside class="sd-rail">
          <p class="eyebrow">Services</p>
          <h2 class="section-title" style="text-align:left;font-size:clamp(1.7rem,3vw,2.3rem)">
            Six practices, one delivery team.
          </h2>
          <ul class="sd-rail-list" aria-hidden="true">
            <?php foreach (SOFT_SERVICES as $i => $svc): ?>
              <li data-rail="<?= $i ?>"><?= e($svc['title']) ?></li>
            <?php endforeach; ?>
          </ul>
        </aside>

        <div>
          <?php
          $servicePhotos = [
              'assets/img/pages/contact-consultation.jpg',
              'assets/img/pages/services/photo/custom-product-development.jpg',
              'assets/img/custom/photo/layer-06.jpg',
              'assets/img/pages/services/photo/reactjs-development.jpg',
              'assets/img/pages/apps/photo/mobile-architecture.jpg',
              'assets/img/pages/services/photo/cloud-devops.jpg',
          ];
          ?>
          <?php foreach (SOFT_SERVICES as $i => $svc): ?>
            <article class="sd-service" data-stage="<?= e($svc['stage']) ?>" data-service="<?= $i ?>">
              <figure style="aspect-ratio: 21/9; border-radius: 14px; overflow: hidden; margin-bottom: 20px; border: 1px solid var(--line); background: var(--glass-hi);">
                <img src="<?= e(asset($servicePhotos[$i % count($servicePhotos)])) ?>" alt="<?= e($svc['title']) ?>" style="width:100%;height:100%;object-fit:cover;display:block;" loading="lazy" decoding="async">
              </figure>
              <div class="sd-service-head">
                <span class="sd-service-icon"><?= icon($svc['icon']) ?></span>
                <div>
                  <span class="sd-service-num"><?= e($svc['num']) ?></span>
                  <h3><?= e($svc['title']) ?></h3>
                </div>
              </div>

              <p><?= e($svc['body']) ?></p>

              <div class="sd-service-foot">
                <ul class="sd-points">
                  <?php foreach ($svc['points'] as $point): ?>
                    <li><?= icon('check') ?><span><?= e($point) ?></span></li>
                  <?php endforeach; ?>
                </ul>
                <p class="sd-metric">
                  <b><?= e($svc['metric']['value']) ?></b>
                  <span><?= e($svc['metric']['label']) ?></span>
                </p>
              </div>
            </article>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </section>

  <!-- ── Build modes · Polaroid Scroll Showcase ─────────────────────── -->
  <section class="sd-polaroid-section" data-stage="ship" id="what-we-build" style="position:relative;overflow:visible;">
    <div data-ok="polaroid-scroll"
         data-props='<?= e(json_encode([
             'eyebrow' => 'What We Build',
             'title'   => 'Pick the shape closest to what you need',
         ], JSON_THROW_ON_ERROR)) ?>'>
    </div>
  </section>

  <!-- ── What every build includes ──────────────────────────────────── -->
  <section class="section" data-stage="build">
    <div class="shell">
      <?php component('section-head', [
          'eyebrow' => 'In Every Build',
          'title'   => 'The things that are not features, and are not optional',
          'lead'    => 'These do not appear on a feature list, and they are the difference between software that survives its second year and software that does not.',
      ]); ?>

      <div class="sd-matrix">
        <?php
        $matrixPhotos = [
            'assets/img/pages/apps/photo/flutter-codebase.jpg',
            'assets/img/cloud/photo/svc-03.jpg',
            'assets/img/cloud/photo/svc-02.jpg',
            'assets/img/cloud/photo/fit-03.jpg',
            'assets/img/custom/photo/layer-02.jpg',
            'assets/img/cloud/photo/svc-01.jpg',
            'assets/img/cloud/photo/svc-06.jpg',
            'assets/img/cloud/photo/svc-05.jpg',
            'assets/img/web-dev/web-arch-03.jpg',
            'assets/img/insights/cap-03.jpg',
            'assets/img/custom/photo/step-01.jpg',
            'assets/img/pages/faq-support.jpg',
        ];
        ?>
        <?php foreach (SOFT_MATRIX as $i => $cell): ?>
          <?php
            $chipClass = match ($cell['tag']) {
                'Included' => ' sd-chip--included',
                'On scope' => ' sd-chip--scope',
                default    => '',
            };
          ?>
          <article class="sd-cell">
            <figure style="aspect-ratio:16/9; border-radius:8px; overflow:hidden; margin:0 0 14px; border:1px solid var(--line); background:var(--glass-hi);">
              <img src="<?= e(asset($matrixPhotos[$i % count($matrixPhotos)])) ?>" alt="<?= e($cell['title']) ?>" style="width:100%;height:100%;object-fit:cover;display:block;" loading="lazy" decoding="async">
            </figure>
            <span class="sd-chip<?= $chipClass ?>"><?= e($cell['tag']) ?></span>
            <?= icon($cell['icon']) ?>
            <h3><?= e($cell['title']) ?></h3>
            <p><?= e($cell['body']) ?></p>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- ── Process · 3D Road Pipeline Workflow ───────────────────────── -->
  <section class="section section--panel" data-stage="blueprint" id="process-pipeline">
    <div class="shell">
      <?php component('section-head', [
          'eyebrow' => 'How We Deliver',
          'title'   => 'Seven stages, and you can see the work at every one',
          'lead'    => 'No stage ends with a document nobody reads. Each one ends with something you can open, argue with, or use.',
      ]); ?>

      <div class="sd-3d-pipeline-wrapper" style="margin-top: 36px;">
        <div data-ok="city-car-roadmap-3d"></div>
      </div>
    </div>
  </section>

  <!-- ── Emerging technology · Animos 3D Interactive Card Showcase ──── -->
  <section class="section" data-stage="intelligence" id="emerging-tech">
    <div class="shell">
      <?php component('section-head', [
          'eyebrow' => 'Technology',
          'title'   => 'The newer tools, used where they actually pay',
          'lead'    => 'Every one of these has a legitimate use and a fashionable one. We will tell you which of the two you are looking at.',
      ]); ?>

      <div class="sd-animos-wrapper" style="margin-top: 36px;">
        <div data-ok="animos-card-3d"></div>
      </div>
    </div>
  </section>

  <!-- ── Stack ──────────────────────────────────────────────────────── -->
  <section class="section" data-stage="integrate">
    <div class="shell">
      <?php component('section-head', [
          'eyebrow' => 'Tech Stack',
          'title'   => 'What we build on',
          'lead'    => 'Python-first for the backend, because the same language runs the API, the data pipeline and the model. The rest is chosen per project, not per habit.',
      ]); ?>

      <div class="sd-stack-arc-wrapper" style="margin-top: 36px;">
        <div data-ok="arc-3d-wall"></div>
      </div>
      <noscript>
        <div class="sd-stack">
          <?php foreach (SOFT_STACK as $group): ?>
            <div class="sd-stack-group" data-sd-reveal>
              <p class="sd-stack-head"><?= icon($group['icon']) ?><?= e($group['title']) ?></p>
              <ul class="sd-stack-items">
                <?php foreach ($group['items'] as $item): ?>
                  <li><?= e($item) ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
          <?php endforeach; ?>
        </div>
      </noscript>
    </div>
  </section>

  <!-- ── Custom vs off-the-shelf ────────────────────────────────────── -->
  <section class="section section--panel" data-stage="build">
    <div class="shell">
      <?php component('section-head', [
          'eyebrow' => 'Decide Honestly',
          'title'   => SOFT_COMPARE['title'],
          'lead'    => SOFT_COMPARE['lead'],
      ]); ?>

      <div class="sd-compare" data-sd-reveal>
        <table>
          <caption class="sr-only">Custom software compared with off-the-shelf products</caption>
          <thead>
            <tr>
              <th scope="col">Consideration</th>
              <th scope="col"><?= e(SOFT_COMPARE['cols'][0]) ?></th>
              <th scope="col"><?= e(SOFT_COMPARE['cols'][1]) ?></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach (SOFT_COMPARE['rows'] as $row): ?>
              <tr>
                <th scope="row"><?= e($row['label']) ?></th>
                <td class="is-custom"><?= e($row['custom']) ?></td>
                <td><?= e($row['shelf']) ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </section>

  <!-- ── Engagement models ──────────────────────────────────────────── -->
  <section class="section" data-stage="integrate">
    <div class="shell">
      <?php component('section-head', [
          'eyebrow' => 'Engagement Models',
          'title'   => 'Three ways to work with us',
          'lead'    => 'The model should follow the certainty of the scope. Fixed price on an uncertain scope only moves the risk into the change requests.',
      ]); ?>

      <div class="sd-models">
        <?php
        $modelPhotos = [
            'assets/img/services-page/process-scale.jpg',
            'assets/img/services-page/process-deliver.jpg',
            'assets/img/pages/careers-pairing.jpg',
        ];
        ?>
        <?php foreach (SOFT_MODELS as $i => $model): ?>
          <article class="sd-model" data-sd-reveal>
            <figure style="aspect-ratio:16/10; border-radius:12px; overflow:hidden; margin:0 0 18px; border:1px solid var(--line); background:var(--glass-hi);">
              <img src="<?= e(asset($modelPhotos[$i % count($modelPhotos)])) ?>" alt="<?= e($model['title']) ?>" style="width:100%;height:100%;object-fit:cover;display:block;" loading="lazy" decoding="async">
            </figure>
            <?= icon($model['icon']) ?>
            <h3><?= e($model['title']) ?></h3>
            <p><?= e($model['body']) ?></p>
            <ul class="sd-model-meta">
              <?php foreach ($model['meta'] as $meta): ?>
                <li><?= icon('check') ?><span><?= e($meta) ?></span></li>
              <?php endforeach; ?>
            </ul>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- ── Industries ─────────────────────────────────────────────────── -->
  <section class="section" data-stage="scale">
    <div class="shell">
      <?php component('section-head', [
          'eyebrow' => 'Industries',
          'title'   => 'Where the work has been',
          'lead'    => 'Domain knowledge is not a slide. It is knowing that a hospital’s day starts at handover and a logistics day starts at loading, and building the screens accordingly.',
      ]); ?>

      <div class="sd-industries" data-sd-reveal>
        <?php foreach (SOFT_INDUSTRIES as $industry): ?>
          <span class="sd-industry"><?= icon($industry['icon']) ?><?= e($industry['label']) ?></span>
        <?php endforeach; ?>
      </div>

      <div style="margin-top:44px">
        <?php component('client-logo-grid'); ?>
      </div>
    </div>
  </section>

  <!-- ── Selected work ──────────────────────────────────────────────── -->
  <section class="section" data-stage="ship">
    <div class="shell">
      <?php component('section-head', [
          'eyebrow' => 'Selected Work',
          'title'   => 'Software we built and still run',
          'lead'    => 'Each of these is in production with real users. The numbers are the client’s, not ours.',
      ]); ?>

      <div class="grid grid-3">
        <?php foreach (featured_case_studies(3) as $i => $study): ?>
          <?php component('case-study-card', ['study' => $study, 'index' => $i]); ?>
        <?php endforeach; ?>
      </div>

      <div class="section-foot" style="margin-top:36px;text-align:center">
        <a class="btn btn-ghost" href="<?= e(url('case-studies.php')) ?>">See every case study<?= icon('arrow') ?></a>
      </div>
    </div>
  </section>

  <!-- ── Why iThrive ────────────────────────────────────────────────── -->
  <section class="section section--panel" data-stage="intelligence">
    <div class="shell">
      <?php component('section-head', [
          'eyebrow' => 'Why iThrive',
          'title'   => 'Six things you can hold us to',
          'lead'    => 'Not values. Commitments, each one checkable in the first month of an engagement.',
      ]); ?>

      <div data-ok="hold-us-3d"></div>
      <noscript>
        <div class="sd-why">
          <?php foreach (SOFT_WHY as $why): ?>
            <article data-sd-reveal>
              <?= icon($why['icon']) ?>
              <div>
                <h3><?= e($why['title']) ?></h3>
                <p><?= e($why['body']) ?></p>
              </div>
            </article>
          <?php endforeach; ?>
        </div>
      </noscript>
    </div>
  </section>

  <!-- ── Testimonials ───────────────────────────────────────────────── -->
  <section class="section" data-stage="scale">
    <div class="shell">
      <?php component('section-head', [
          'eyebrow' => 'Clients',
          'title'   => 'What the people who signed it off said',
      ]); ?>
      <?php component('testimonial-slider'); ?>
    </div>
  </section>

  <!-- ── Investment & Sector Timings · Click-to-Reveal CTA ─────────── -->
  <section class="section sd-cost-section" data-stage="blueprint" id="cost-breakdown">
    <div class="shell">
      <!-- High-Converting Click-to-Reveal CTA Card -->
      <div class="sd-cost-cta-card" data-sd-reveal>
        <div class="sd-cost-cta-badge">
          <span class="sd-cost-pulse"></span>
          <span><?= e(SOFT_INVESTMENT['eyebrow'] ?? 'Cost & Planning') ?> • AI-Accelerated Pricing</span>
        </div>

        <h2 class="sd-cost-cta-heading">
          Custom Software Development Cost <span class="text-gradient">in Chennai</span>
        </h2>

        <p class="sd-cost-cta-subtext">
          <?= e(SOFT_INVESTMENT['lead'] ?? 'How much does custom software cost in the AI era? With modern AI-accelerated engineering, boilerplate development time has dropped by ~40% — fundamentally reducing build costs while shipping battle-tested production code.') ?>
        </p>

        <div class="sd-cost-cta-actions">
          <button type="button" class="btn btn-primary sd-cost-toggle-btn" data-cost-toggle aria-expanded="false" aria-controls="cost-breakdown-drawer">
            <span class="sd-cost-toggle-icon"><?= icon('layers') ?></span>
            <span class="sd-cost-toggle-text"><?= e(SOFT_INVESTMENT['cta_button'] ?? 'View Detailed Pricing & Timelines') ?></span>
            <span class="sd-cost-toggle-badge"><?= e(SOFT_INVESTMENT['cta_sub'] ?? 'AI-Accelerated Rates — Click to Reveal') ?></span>
            <svg class="sd-cost-toggle-arrow" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 12 15 18 9"></polyline></svg>
          </button>
          <button type="button" class="btn btn-ghost sd-cost-quote-btn" data-modal-open>
            Request Scoped Estimate<?= icon('arrow') ?>
          </button>
        </div>

        <div class="sd-cost-teaser-pills">
          <div class="sd-cost-teaser-pill">
            <span class="sd-teaser-dot"></span>
            <span>MVP / First Release: <strong>from ₹2.5 Lakhs</strong></span>
          </div>
          <div class="sd-cost-teaser-pill">
            <span class="sd-teaser-dot"></span>
            <span>Launch Timeline: <strong>3 to 6 Weeks</strong></span>
          </div>
          <div class="sd-cost-teaser-pill">
            <span class="sd-teaser-dot"></span>
            <span>IP Ownership: <strong>100% Yours on Day One</strong></span>
          </div>
        </div>
      </div>

      <!-- Collapsible Cost & Timeline Drawer (Hidden by default, revealed on click) -->
      <div class="sd-cost-drawer" data-cost-drawer id="cost-breakdown-drawer" aria-hidden="true">
        <div class="sd-cost-drawer-inner">
          <div class="sd-cost-banner">
            <div class="sd-cost-banner-icon"><?= icon('brain') ?></div>
            <div>
              <h4>The ~40% AI Cost Advantage</h4>
              <p>By leveraging AI coding copilots, automated test generation, and intelligent schema scaffolding, our senior engineers eliminate repetitive boilerplate. You pay for core domain logic, security hardening, and resilient system architecture — not manual typing.</p>
            </div>
          </div>

          <div class="sd-tiers" style="margin-top: 32px;">
            <?php
            $tierPhotos = [
                'assets/img/pages/services/photo/mvp-development.jpg',
                'assets/img/pages/services/photo/micro-saas-development.jpg',
                'assets/img/cloud/photo/step-01.jpg',
            ];
            ?>
            <?php foreach (SOFT_INVESTMENT['tiers'] as $i => $tier): ?>
              <article class="sd-tier<?= !empty($tier['featured']) ? ' sd-tier--featured' : '' ?>">
                <figure style="aspect-ratio:16/9; border-radius:10px; overflow:hidden; margin:0 0 16px; border:1px solid var(--line); background:var(--glass-hi);">
                  <img src="<?= e(asset($tierPhotos[$i % count($tierPhotos)])) ?>" alt="<?= e($tier['tier']) ?>" style="width:100%;height:100%;object-fit:cover;display:block;" loading="lazy" decoding="async">
                </figure>
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:6px;">
                  <span class="sd-tier-name"><?= e($tier['tier']) ?></span>
                  <?php if (!empty($tier['featured'])): ?>
                    <span class="sd-tier-badge">Most Popular</span>
                  <?php endif; ?>
                </div>
                <p class="sd-tier-range"><?= e($tier['range']) ?></p>
                <p class="sd-tier-time">⏱ <?= e($tier['time']) ?></p>
                <p class="sd-tier-best"><?= e($tier['best']) ?></p>
                <ul class="sd-tier-items">
                  <?php foreach ($tier['items'] as $item): ?>
                    <li><?= icon('check') ?><span><?= e($item) ?></span></li>
                  <?php endforeach; ?>
                </ul>
              </article>
            <?php endforeach; ?>
          </div>

          <p class="sd-note" style="margin-top: 24px;"><?= icon('lightbulb') ?><span><?= e(SOFT_INVESTMENT['note']) ?></span></p>

          <div class="sd-timeline-block" style="margin-top: 48px;">
            <div style="margin-bottom: 20px;">
              <p class="eyebrow" style="margin-bottom: 4px;">Sector Breakdown</p>
              <h3 style="font-size: clamp(1.2rem, 2vw, 1.5rem); color: var(--text);">Indicative Custom Software Investment by Sector</h3>
            </div>
            <div class="sd-table-wrap">
              <table class="sd-table">
                <caption class="sr-only">Indicative custom software cost and launch time by sector</caption>
                <thead>
                  <tr>
                    <th scope="col">Sector</th>
                    <th scope="col">Essential build</th>
                    <th scope="col">Advanced build</th>
                    <th scope="col">Time to launch</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach (SOFT_TIMELINE as $row): ?>
                    <tr>
                      <th scope="row"><?= e($row['sector']) ?></th>
                      <td><?= e($row['basic']) ?></td>
                      <td><?= e($row['advanced']) ?></td>
                      <td><?= e($row['time']) ?></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>

          <div class="sd-cost-cta-footer" style="text-align: center; margin-top: 40px; padding: 28px; background: rgba(0, 242, 254, 0.04); border: 1px solid rgba(0, 242, 254, 0.2); border-radius: var(--radius);">
            <h4 style="font-size: 1.15rem; margin-bottom: 8px; color: #fff;">Need an exact quote for your technical specification?</h4>
            <p style="font-size: 0.9rem; color: var(--text-dim); max-width: 560px; margin: 0 auto 20px;">Get a detailed breakdown with architecture diagrams, API contract estimates, and exact milestone delivery schedules.</p>
            <button class="btn btn-primary" type="button" data-modal-open>
              Request Scoped Estimate<?= icon('arrow') ?>
            </button>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ── What moves the number ──────────────────────────────────────── -->
  <section class="section" data-stage="build">
    <div class="shell">
      <?php component('section-head', [
          'eyebrow' => 'Cost Drivers',
          'title'   => 'Six things that move the estimate',
          'lead'    => 'If you want a cheaper build, these are the levers. Cutting the design budget is not one of them.',
      ]); ?>

      <div data-ok="estimate-drivers-3d"></div>
      <noscript>
        <div class="sd-factors">
          <?php
          $factorPhotos = [
              'assets/img/custom/photo/flaw-02.jpg',
              'assets/img/custom/photo/flaw-01.jpg',
              'assets/img/pages/services/photo/ai-for-ecommerce.jpg',
              'assets/img/cloud/photo/fit-01.jpg',
              'assets/img/cloud/photo/svc-04.jpg',
              'assets/img/pages/services/photo/product-modernization.jpg',
          ];
          ?>
          <?php foreach (SOFT_COST_FACTORS as $i => $factor): ?>
            <article class="sd-factor">
              <figure style="aspect-ratio:16/9; border-radius:10px; overflow:hidden; margin:0 0 14px; border:1px solid var(--line); background:var(--glass-hi);">
                <img src="<?= e(asset($factorPhotos[$i % count($factorPhotos)])) ?>" alt="<?= e($factor['title']) ?>" style="width:100%;height:100%;object-fit:cover;display:block;" loading="lazy" decoding="async">
              </figure>
              <?= icon($factor['icon']) ?>
              <h3><?= e($factor['title']) ?></h3>
              <p><?= e($factor['body']) ?></p>
            </article>
          <?php endforeach; ?>
        </div>
      </noscript>
    </div>
  </section>

  <!-- ── FAQ ────────────────────────────────────────────────────────── -->
  <section class="section section--panel" data-stage="intelligence">
    <div class="shell">
      <?php component('section-head', [
          'eyebrow' => 'Questions',
          'title'   => 'The ten questions we are always asked',
      ]); ?>

      <div class="sd-faq" data-sd-faq>
        <?php foreach (SOFT_FAQ as $item): ?>
          <details>
            <summary><span><?= e($item['q']) ?></span><?= icon('chevron') ?></summary>
            <p><?= e($item['a']) ?></p>
          </details>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <?php component('cta', ['cta' => SOFT_CTA]); ?>

  <!-- ── Enquiry ────────────────────────────────────────────────────── -->
  <section class="section section--tight" id="enquiry" data-stage="scale">
    <div class="shell">
      <?php component('section-head', [
          'eyebrow' => 'Talk To An Engineer',
          'title'   => 'Tell us what is slowing you down',
          'lead'    => 'The first reply comes from the engineer who would run the build, not from an account manager.',
      ]); ?>

      <div style="max-width:760px;margin:0 auto">
        <?php component('contact-form', ['idPrefix' => 'sd', 'service' => 'Custom Software Development']); ?>
      </div>
    </div>
  </section>
</div>

<script src="<?= e(asset('assets/js/software.js')) ?>" defer></script>
<script type="module" src="<?= e(asset('assets/js/software-stage.js')) ?>"></script>
<script type="module" src="<?= e(url('assets/dist/originkit/originkit.js')) ?>"></script>

<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
