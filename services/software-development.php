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

$extraHead = '<link rel="stylesheet" href="' . e(asset('assets/css/software.css')) . '">';

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

  <!-- ── What we do ─────────────────────────────────────────────────── -->
  <section class="section" data-stage="blueprint">
    <div class="shell">
      <div class="sd-intro-grid">
        <div>
          <p class="eyebrow" data-sd-reveal><?= e(SOFT_INTRO['eyebrow']) ?></p>
          <h2 class="section-title" style="text-align:left" data-sd-reveal><?= e(SOFT_INTRO['title']) ?></h2>
          <div class="sd-intro-copy" style="margin-top:22px">
            <?php foreach (SOFT_INTRO['body'] as $i => $para): ?>
              <p data-sd-reveal style="--d:<?= $i + 1 ?>"><?= e($para) ?></p>
            <?php endforeach; ?>
          </div>
        </div>

        <div>
          <?php foreach (SOFT_INTRO['pillars'] as $i => $pillar): ?>
            <div class="sd-pillar" data-sd-reveal style="--d:<?= $i + 2 ?>">
              <?= icon($pillar['icon']) ?>
              <h3><?= e($pillar['title']) ?></h3>
              <p><?= e($pillar['body']) ?></p>
            </div>
          <?php endforeach; ?>
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
          <?php foreach (SOFT_SERVICES as $i => $svc): ?>
            <article class="sd-service" data-stage="<?= e($svc['stage']) ?>" data-service="<?= $i ?>">
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

  <!-- ── Build modes · the interactive panel ────────────────────────── -->
  <section class="section section--panel" data-stage="ship">
    <div class="shell">
      <?php component('section-head', [
          'eyebrow' => 'What We Build',
          'title'   => 'Pick the shape closest to what you need',
          'lead'    => 'Six shapes cover most of what walks through the door. Yours will not match one exactly — that is rather the point of building it.',
      ]); ?>

      <div class="sd-modes">
        <div class="sd-tablist" role="tablist" aria-label="Types of software we build">
          <?php foreach (SOFT_MODES as $i => $mode): ?>
            <button class="sd-tab<?= $i === 0 ? ' is-active' : '' ?>"
                    type="button"
                    role="tab"
                    id="sd-tab-<?= e($mode['key']) ?>"
                    aria-controls="sd-panel-<?= e($mode['key']) ?>"
                    aria-selected="<?= $i === 0 ? 'true' : 'false' ?>"
                    tabindex="<?= $i === 0 ? '0' : '-1' ?>"
                    data-mode-tab="<?= e($mode['key']) ?>">
              <?= icon($mode['icon']) ?><?= e($mode['label']) ?>
            </button>
          <?php endforeach; ?>
        </div>

        <div>
          <?php foreach (SOFT_MODES as $i => $mode): ?>
            <div class="sd-panel"
                 role="tabpanel"
                 id="sd-panel-<?= e($mode['key']) ?>"
                 aria-labelledby="sd-tab-<?= e($mode['key']) ?>"
                 data-mode-panel="<?= e($mode['key']) ?>"
                 <?= $i === 0 ? '' : 'hidden' ?>>
              <div>
                <h3><?= e($mode['title']) ?></h3>
                <p><?= e($mode['body']) ?></p>
              </div>

              <?php /* Schematic on purpose. It shows the shape of an application
                       without pretending to be a screenshot of software that
                       does not exist yet. */ ?>
              <div class="sd-window">
                <div class="sd-window-bar">
                  <span class="sd-window-dots"><i></i><i></i><i></i></span>
                  <span class="sd-window-url"><?= e($mode['chrome']) ?></span>
                </div>
                <ul class="sd-window-rows">
                  <?php foreach ($mode['rows'] as $row): ?>
                    <li class="tone-<?= e($row['tone']) ?>">
                      <span><?= e($row['label']) ?></span>
                      <b><?= e($row['value']) ?></b>
                    </li>
                  <?php endforeach; ?>
                </ul>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
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
        <?php foreach (SOFT_MATRIX as $cell): ?>
          <?php
            $chipClass = match ($cell['tag']) {
                'Included' => ' sd-chip--included',
                'On scope' => ' sd-chip--scope',
                default    => '',
            };
          ?>
          <article class="sd-cell">
            <span class="sd-chip<?= $chipClass ?>"><?= e($cell['tag']) ?></span>
            <?= icon($cell['icon']) ?>
            <h3><?= e($cell['title']) ?></h3>
            <p><?= e($cell['body']) ?></p>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- ── Process ────────────────────────────────────────────────────── -->
  <section class="section section--panel" data-stage="blueprint">
    <div class="shell">
      <?php component('section-head', [
          'eyebrow' => 'How We Deliver',
          'title'   => 'Seven stages, and you can see the work at every one',
          'lead'    => 'No stage ends with a document nobody reads. Each one ends with something you can open, argue with, or use.',
      ]); ?>

      <ol class="sd-pipeline">
        <?php foreach (SOFT_PROCESS as $i => $step): ?>
          <li class="sd-step" data-sd-reveal>
            <span class="sd-step-num"><?= str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT) ?></span>
            <h3><?= e($step['title']) ?></h3>
            <p><?= e($step['body']) ?></p>
          </li>
        <?php endforeach; ?>
      </ol>
    </div>
  </section>

  <!-- ── Emerging technology ────────────────────────────────────────── -->
  <section class="section" data-stage="intelligence">
    <div class="shell">
      <?php component('section-head', [
          'eyebrow' => 'Technology',
          'title'   => 'The newer tools, used where they actually pay',
          'lead'    => 'Every one of these has a legitimate use and a fashionable one. We will tell you which of the two you are looking at.',
      ]); ?>

      <div class="sd-tech">
        <?php foreach (SOFT_TECHNOLOGIES as $tech): ?>
          <article data-sd-reveal>
            <?= icon($tech['icon']) ?>
            <h3><?= e($tech['title']) ?></h3>
            <p><?= e($tech['body']) ?></p>
          </article>
        <?php endforeach; ?>
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
        <?php foreach (SOFT_MODELS as $model): ?>
          <article class="sd-model" data-sd-reveal>
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

  <!-- ── Investment ─────────────────────────────────────────────────── -->
  <section class="section" data-stage="blueprint">
    <div class="shell">
      <?php component('section-head', [
          'eyebrow' => 'Investment',
          'title'   => 'What custom software costs in Chennai',
          'lead'    => 'Published ranges, so you can tell in a minute whether we are in your bracket. The estimate you get is a real number with the assumptions attached.',
      ]); ?>

      <div class="sd-tiers">
        <?php foreach (SOFT_INVESTMENT['tiers'] as $tier): ?>
          <article class="sd-tier<?= !empty($tier['featured']) ? ' sd-tier--featured' : '' ?>" data-sd-reveal>
            <p class="sd-tier-name"><?= e($tier['tier']) ?></p>
            <p class="sd-tier-range"><?= e($tier['range']) ?></p>
            <p class="sd-tier-time"><?= e($tier['time']) ?></p>
            <p class="sd-tier-best"><?= e($tier['best']) ?></p>
            <ul class="sd-tier-items">
              <?php foreach ($tier['items'] as $item): ?>
                <li><?= icon('check') ?><span><?= e($item) ?></span></li>
              <?php endforeach; ?>
            </ul>
          </article>
        <?php endforeach; ?>
      </div>

      <p class="sd-note"><?= icon('lightbulb') ?><span><?= e(SOFT_INVESTMENT['note']) ?></span></p>
    </div>
  </section>

  <!-- ── Industry timings ───────────────────────────────────────────── -->
  <section class="section section--tight" data-stage="blueprint">
    <div class="shell">
      <?php component('section-head', [
          'eyebrow' => 'By Sector',
          'title'   => 'Typical cost and time to launch',
          'lead'    => 'Averages across the work we have delivered in each sector. Yours will land somewhere on these ranges once the integrations are known.',
      ]); ?>

      <div class="sd-table-wrap" data-sd-reveal>
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
  </section>

  <!-- ── What moves the number ──────────────────────────────────────── -->
  <section class="section" data-stage="build">
    <div class="shell">
      <?php component('section-head', [
          'eyebrow' => 'Cost Drivers',
          'title'   => 'Six things that move the estimate',
          'lead'    => 'If you want a cheaper build, these are the levers. Cutting the design budget is not one of them.',
      ]); ?>

      <div class="sd-factors">
        <?php foreach (SOFT_COST_FACTORS as $factor): ?>
          <article class="sd-factor" data-sd-reveal>
            <?= icon($factor['icon']) ?>
            <h3><?= e($factor['title']) ?></h3>
            <p><?= e($factor['body']) ?></p>
          </article>
        <?php endforeach; ?>
      </div>
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

<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
