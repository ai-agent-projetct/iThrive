<?php
/**
 * Custom Product Development — the seventh bespoke service page.
 *
 * Built after absoluteapplabs.com/custom-product-development, section for
 * section, in iThrive's own words: hero, the four ways an unaligned build
 * hurts, six layers of expertise, the band, three process steps, the stack,
 * six advantages, three engagement models, five questions, close.
 *
 * ON COMPONENTS. The no-repeat rule holds — nothing here appears on any other
 * page — and by this page it costs something, so here is the honest position.
 *
 * Seven components across the six earlier pages were measured rendering
 * NOTHING: the PoC cube, the ReactJS liquid carousel, the team arc, the brush
 * reveal, the hover reveal, the dot grid, the motion gallery and the water
 * ripple. Every one computed its layout inside requestAnimationFrame or painted
 * to a canvas, and a tab that never gets a frame gets an empty rectangle. That
 * disqualifies most of what is left in the registry, which is largely WebGL.
 *
 * Three survived triage and are used here, none of them on any other page:
 *
 *   hero      Text Lift        every letter extruded as a stack of itself,
 *                              lifting on hover — spans and transforms, so the
 *                              headline is readable at first paint
 *   layers    Bento Gallery    the six-layer expertise grid
 *   models    Interactive Book a real 3D book you turn, for the three
 *                              engagement models
 *
 * Everything else — the hero's strata stack included — is CSS with its geometry
 * written at render time. That is the only 3D approach that has rendered
 * reliably here, and it is why the Dedicated Team hero had to be rebuilt.
 *
 * Theme: the site's own ramp, and its own type — Sora, Manrope and IBM Plex
 * Mono, none of which the other six pages use. What makes the page its own is
 * the STRATA motif: isometric plates stacked with the seams lit. A custom
 * product is layers built to fit each other rather than one bought thing bent
 * into shape, and that is the shape of it.
 *
 * Pictures come from tools/custom-art.mjs; every slot prefers a photograph from
 * assets/img/custom/photo/ the moment one lands.
 */

declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/config.php';

$svc = service('custom-product-development');

$page      = 'services';
$pageTitle = 'Custom Product Development Company in Chennai';
$pageDesc  = 'iThrive Software builds custom digital products end to end — frontend, backend, mobile, '
           . 'data, cloud and the integrations between them — aligned under one architecture.';
$ogImage   = 'service-' . $svc['group_slug'];

/* ---------------------------------------------------------------------------
 * Content
 * ------------------------------------------------------------------------ */

/** The hero's strata plates, bottom of the stack first. */
$plates = [
    ['05', 'Integrations', 'The systems you already run'],
    ['04', 'Cloud',        'Where it runs, and what it costs'],
    ['03', 'Data',         'The model underneath everything'],
    ['02', 'Services',     'The rules, in one place'],
    ['01', 'Interface',    'What your people actually touch'],
];

$stats = [
    ['12-20', 'Weeks to first production release'],
    ['1',     'Architecture, not six vendors'],
    ['100%',  'Source and IP, yours from week one'],
    ['30-40%', 'Of team time lost to fragmentation'],
];

/** The four ways an unaligned build hurts. */
$flaws = [
    ['01', 'Fragmented delivery',
     'Four vendors, four conventions, four ideas of what "done" means. The integration work nobody scoped becomes the project.'],
    ['02', 'Releases that slip',
     'A change to the interface waits on a change to the service, which waits on a migration. Every release becomes a negotiation.'],
    ['03', 'Integrations that wobble',
     'The connector was written once, against one version, with no retries. It works until the other side changes something.'],
    ['04', 'Debt you did not choose',
     'Shortcuts taken to hit a date nobody wrote down, in code nobody owns. It compounds quietly and surfaces as "everything takes longer now".'],
];

/** Six layers of expertise. */
$layers = [
    ['01', 'Frontend engineering',
     'React, Next.js, Angular and Vue, in TypeScript. Interfaces for people who use them all day — density over decoration, and accessible because it was built that way rather than audited later.',
     ['react', 'nextdotjs', 'angular', 'typescript']],
    ['02', 'Backend engineering',
     'Python with Django or FastAPI, Node, Laravel and .NET. The rules live in one place, the API is typed, and the thing that runs at 3am has a runbook.',
     ['python', 'django', 'fastapi', 'nodedotjs']],
    ['03', 'Mobile applications',
     'Flutter and React Native where one codebase serves, Swift and Kotlin where it genuinely does not. We will tell you which case you are in before the estimate.',
     ['flutter', 'swift', 'kotlin', 'react']],
    ['04', 'Data and storage',
     'PostgreSQL, MySQL, MongoDB, Redis and OpenSearch. Modelled from your real entities and their real exceptions, because the exceptions are what break a bought tool.',
     ['postgresql', 'mongodb', 'redis', 'mysql']],
    ['05', 'Cloud and DevOps',
     'AWS, GCP and Azure with Docker, Kubernetes and Terraform. CI that runs the tests, deploys that roll back, and a bill treated as a design constraint.',
     ['amazonwebservices', 'googlecloud', 'docker', 'kubernetes']],
    ['06', 'APIs and integration',
     'REST, GraphQL and the older endpoints too. Typed connectors to the ERP, the gateway and the hardware on the floor, with retries and reconciliation built in.',
     ['graphql', 'stripe', 'razorpay', 'celery']],
];

/** Three process steps. */
$steps = [
    ['01', 'A 30-minute call',
     'You describe the workflow that costs you the most time. We ask what breaks, who works around it, and what the workaround costs. No deck, and no obligation.'],
    ['02', 'A written understanding',
     'Within a few days you get scope, architecture, engagement model and a budget range in writing — including the part we think you should not build yet, and why.'],
    ['03', 'Delivery you can watch',
     'Two-week sprints with working software at the end of each. Your repository, your cloud accounts, from the first commit. You see progress rather than hear about it.'],
];

/** The stack, by group. Five tabs, as on the reference. */
$stack = [
    ['Front end',   ['react', 'nextdotjs', 'angular', 'vuedotjs', 'typescript', 'tailwindcss', 'vite', 'threedotjs']],
    ['Back end',    ['python', 'django', 'fastapi', 'nodedotjs', 'express', 'laravel', 'dotnet', 'openjdk', 'php']],
    ['Databases',   ['postgresql', 'mysql', 'mongodb', 'redis', 'firebase', 'opensearch']],
    ['Cloud & DevOps', ['amazonwebservices', 'googlecloud', 'azure', 'docker', 'kubernetes', 'terraform', 'jenkins', 'githubactions', 'grafana']],
    ['Integrations', ['graphql', 'stripe', 'razorpay', 'upi', 'openai', 'langchain', 'celery', 'shopify']],
];

/** Six advantages. */
$edges = [
    ['01', 'Full-stack under one architecture',
     'Every layer decided together, by people who have to live with all of them. There is no seam where one vendor stops caring.'],
    ['02', 'Faster to something real',
     'AI-assisted delivery with senior review on every change. The speed comes from writing less throwaway work, not from skipping the review.'],
    ['03', 'Built to hold its shape',
     'Load, tenancy and the second year designed for at the start, because retrofitting any of the three is a rewrite wearing a smaller name.'],
    ['04', 'Interfaces people can use',
     'Designed for the person doing the task forty times a day, not for the screenshot. Tested on real content, at real volume.'],
    ['05', 'Engagement that can change',
     'Fixed price, time and materials, or a mix. You are not locked into the model that suited the first month for the whole build.'],
    ['06', 'Handover, not hostage',
     'Architecture notes, runbooks and a working local environment. Another team could pick this up without ever speaking to us, and that is the point.'],
];

/** Three engagement models. */
$models = [
    ['01', 'Fixed cost',
     'For a scope both sides can describe in writing. A fixed quote and a dated plan up front, so the budget is predictable and a change is a conversation rather than an invoice surprise.',
     'Best when the requirements are settled and the deadline is external.'],
    ['02', 'Time and materials',
     'For work whose shape will change as you learn. You are billed for the hours worked, and the team scales up or down as the roadmap moves.',
     'Best when discovery is ongoing and the backlog is still being argued about.'],
    ['03', 'Hybrid',
     'A fixed-price core for the part that is genuinely settled, with a time-and-materials band around the part that is not. Most builds of any size are honestly this shape.',
     'Best when the foundation is clear but the edges are still being learned.'],
];

$faqs = [
    ['How long does it take to build a custom product?',
     'Discovery is about two weeks. A first production release is typically six to fourteen weeks after that for a focused product, and twelve to twenty for a platform several teams depend on. The variables are integration count and how settled the rules are — not the number of screens. You see working software every fortnight throughout, so the timeline is visible rather than promised.'],
    ['What kinds of products do you build?',
     'Internal platforms that replace a spreadsheet estate, customer-facing portals, marketplaces, booking and dispatch systems, ERP and CRM extensions, and the integration layers between systems that were never designed to talk. The common thread is a workflow with real exceptions in it — that is the case where a bought tool starts costing more in workarounds than a built one costs outright.'],
    ['We need blockchain. Do you have developers for that?',
     'We build the surrounding product — wallets, custody integrations, on-chain reads, settlement reconciliation — and we work with specialist contract auditors for the on-chain part rather than pretending to be them. We will also ask what the chain is buying you. It is the right answer for a genuinely trustless multi-party ledger and the wrong one for most things a database already does well, and we would rather have that conversation before the invoice.'],
    ['How do you ensure quality and reliability?',
     'Tests written with the feature rather than after it, CI that blocks a merge on a failure, code review by a senior engineer on every change, and staging that matches production closely enough to be worth having. After launch: monitoring that pages us rather than you, error tracking, and a 90-day warranty on any defect traceable to our code.'],
    ['Should we build an SPA or a multi-page application?',
     'It depends on who is using it. A tool your staff live in all day wants a single-page application: state persists, navigation is instant, and the page-load cost is paid once. Anything that has to be found on Google, or opened on a slow phone once a month, wants server-rendered pages. Plenty of products are honestly both — an SPA behind the login and rendered pages in front of it — and that is what we usually recommend.'],
];

$extraHead = '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>'
    . '<link rel="stylesheet" href="https://fonts.googleapis.com/css2?'
    . 'family=Sora:wght@400;500;600;700;800'
    . '&family=Manrope:wght@400;500;600;700'
    . '&family=IBM+Plex+Mono:wght@400;500;600&display=swap">'
    . '<link rel="stylesheet" href="' . e(asset('assets/css/custom.css')) . '">';

/* The five questions above, as schema — the same treatment the Flutter and
   mobile pages get, so an answer engine reading the raw HTML finds them. */
$schemaExtra = [
    [
        '@type'      => 'FAQPage',
        'name'       => 'Custom product development — frequently asked questions',
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
    $photo = 'assets/img/custom/photo/' . $set . '-' . $file;

    return asset(is_file(ROOT_PATH . '/' . $photo) ? $photo : 'assets/img/custom/' . $rel);
};
?>

<div class="cpd">

  <?php /* ---------------------------------------------------------------
           Hero — a CSS 3D strata stack, and an extruded headline

           The plates are placed from each one's own --i, so the stack is laid
           out at first paint. Pointer movement only adds to that: the fallback
           if no frame ever runs is a correct, still stack rather than a hole.
           --------------------------------------------------------------- */ ?>
  <section class="cpd-hero" data-strata>
    <img class="cpd-hero-bg" src="<?= e($img('hero/01.jpg')) ?>" width="1800" height="1000"
         alt="" fetchpriority="high" decoding="async">
    <div class="cpd-hero-wash" aria-hidden="true"></div>

    <div class="cpd-shell cpd-hero-grid">
      <div class="cpd-hero-copy">
        <p class="cpd-eyebrow"><span class="cpd-mark" aria-hidden="true"></span>Custom Product Development · Chennai</p>

        <h1 class="cpd-h1">
          <span class="cpd-h1-lead">Where ideas become</span>
          <?php /* The island replaces this text with the same word, extruded.
                   A crawler, or a browser where the bundle never runs, reads
                   the heading exactly as written. */ ?>
          <span class="cpd-h1-lift" data-ok="text-lift"
                data-props='<?= e(json_encode([
                    'text'        => 'REAL PLATFORMS',
                    'direction'   => 'bottomRight',
                    'depth'       => 9,
                    'spread'      => 1,
                    'expand'      => 15,
                    'fade'        => true,
                    'filled'      => true,
                    'stroke'      => 0,
                    'frontColor'  => '#EAF0FA',
                    'depthColor'  => '#4EA8FF',
                    'strokeColor' => '#00F2FE',
                    'font'        => [
                        'fontFamily'    => 'Sora, system-ui, sans-serif',
                        'fontWeight'    => 800,
                        'fontSize'      => 'clamp(2.1rem, 5vw, 4rem)',
                        'letterSpacing' => '-0.04em',
                        'lineHeight'    => '1em',
                    ],
                ], JSON_THROW_ON_ERROR)) ?>'>REAL PLATFORMS</span>
        </h1>

        <p class="cpd-lead">
          Every business eventually hits the workflow no packaged tool models correctly. We build the
          product that does — frontend, backend, mobile, data, cloud and the integrations between
          them, decided together under one architecture instead of stitched together afterwards.
        </p>

        <div class="cpd-actions">
          <button class="cpd-btn cpd-btn--primary" type="button"
                  data-modal-open data-modal-service="Custom Product Development">
            Get a free consultation<?= icon('arrow') ?>
          </button>
          <a class="cpd-btn cpd-btn--ghost" href="#cpd-layers">See every layer</a>
        </div>

        <ul class="cpd-stats">
          <?php foreach ($stats as [$v, $l]): ?>
            <li><strong><?= e($v) ?></strong><span><?= e($l) ?></span></li>
          <?php endforeach; ?>
        </ul>
      </div>

      <div class="cpd-hero-stage">
        <?php /* The plates carry no text. They are tipped 56 degrees and turned
                 42, and a caption riding that transform is unreadable — the
                 first build put one on each and they came out as smears. The
                 legend below names them square to the screen instead, and
                 hovering an entry lights its plate. */ ?>
        <div class="cpd-strata" data-strata-inner style="--n: <?= count($plates) ?>;" aria-hidden="true">
          <?php foreach ($plates as $i => [$n]): ?>
            <figure class="cpd-plate" data-plate="<?= $i ?>" style="--i: <?= $i ?>;">
              <img src="<?= e($img('plate/' . $n . '.jpg')) ?>" width="760" height="460"
                   alt="" loading="<?= $i < 2 ? 'eager' : 'lazy' ?>" decoding="async">
            </figure>
          <?php endforeach; ?>
        </div>

        <ol class="cpd-legend" data-legend>
          <?php foreach (array_reverse($plates, true) as $i => [$n, $title, $sub]): ?>
            <li data-legend-item="<?= $i ?>">
              <span class="cpd-plate-n"><?= e($n) ?></span>
              <b><?= e($title) ?></b>
              <i><?= e($sub) ?></i>
            </li>
          <?php endforeach; ?>
        </ol>
      </div>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           The four ways an unaligned build hurts
           --------------------------------------------------------------- */ ?>
  <section class="cpd-sec cpd-flaws">
    <div class="cpd-shell">
      <div class="cpd-head">
        <p class="cpd-eyebrow"><span class="cpd-mark" aria-hidden="true"></span>What goes wrong</p>
        <h2 class="cpd-title">Do not let hidden flaws<br><em>slow your growth</em></h2>
        <p class="cpd-sub">
          When the layers are not built to fit, the product pays for it. Teams routinely lose thirty
          to forty percent of their engineering time to integration work and ageing technology — a
          frontend change that disrupts a backend process, a connector that stops being reliable, a
          system that will not scale without a rewrite. Aligning every layer under one strategy is
          what removes the bottleneck rather than moving it.
        </p>
      </div>

      <div class="cpd-flaw-grid">
        <?php foreach ($flaws as $i => [$n, $title, $body]): ?>
          <article class="cpd-flaw" data-reveal style="--d:<?= $i % 4 ?>">
            <figure class="cpd-flaw-art">
              <img src="<?= e($img('flaw/' . $n . '.jpg')) ?>" width="720" height="520"
                   alt="" loading="lazy" decoding="async">
            </figure>
            <span class="cpd-num"><?= e($n) ?></span>
            <h3><?= e($title) ?></h3>
            <p><?= e($body) ?></p>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           Expertise — six layers, with Bento Gallery carrying the pictures
           --------------------------------------------------------------- */ ?>
  <section class="cpd-sec cpd-layers" id="cpd-layers" data-layers>
    <div class="cpd-shell">
      <div class="cpd-head">
        <p class="cpd-eyebrow"><span class="cpd-mark" aria-hidden="true"></span>Our expertise</p>
        <h2 class="cpd-title">Every layer of your<br><em>digital product</em></h2>
        <p class="cpd-sub">
          Six disciplines, one team, one architecture. Choose a layer to see what we actually run in
          it — and what we would tell you not to.
        </p>
      </div>

      <div class="cpd-layer-wrap">
        <div class="cpd-layer-bento"
             data-ok="bento-gallery"
             data-props='<?= e(json_encode([
                 'images' => array_map(static fn (array $l): array => [
                     'src' => $img('layer/' . $l[0] . '.jpg'),
                     'alt' => $l[1],
                 ], $layers),
                 'gridColumns'       => 3,
                 'gridRows'          => 2,
                 'gap'               => 10,
                 'borderRadius'      => 14,
                 'backgroundColor'   => 'transparent',
                 'opacity'           => 0.92,
                 'showOverlay'       => true,
                 'overlayColor'      => '#0B0F17',
                 'overlayOpacity'    => 0.25,
                 'grayscaleOnHover'  => false,
                 'enableLightbox'    => false,
                 'animationDuration' => 0.35,
             ], JSON_THROW_ON_ERROR)) ?>'></div>

        <div class="cpd-layer-list">
          <?php foreach ($layers as $i => [$n, $title, $body, $logos]): ?>
            <article class="cpd-layer<?= $i === 0 ? ' is-open' : '' ?>" data-layer
                     role="button" tabindex="0" aria-expanded="<?= $i === 0 ? 'true' : 'false' ?>">
              <header>
                <span class="cpd-num"><?= e($n) ?></span>
                <h3><?= e($title) ?></h3>
                <span class="cpd-layer-mark" aria-hidden="true"></span>
              </header>
              <div class="cpd-layer-panel">
                <div>
                  <p><?= e($body) ?></p>
                  <ul class="cpd-chips">
                    <?php foreach ($logos as $slug): ?>
                      <li><img src="<?= e(asset('assets/img/tech/' . $slug . '.svg')) ?>"
                               width="18" height="18" alt="" loading="lazy" decoding="async"><?= e($slug) ?></li>
                    <?php endforeach; ?>
                  </ul>
                </div>
              </div>
            </article>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           Band
           --------------------------------------------------------------- */ ?>
  <section class="cpd-band">
    <div class="cpd-shell cpd-band-inner">
      <div class="cpd-band-rule" aria-hidden="true"><span></span><span></span><span></span></div>
      <h2>Build smarter products<br><em>with one full-stack team.</em></h2>
      <button class="cpd-btn cpd-btn--primary" type="button"
              data-modal-open data-modal-service="Custom Product Development">
        Start your project<?= icon('arrow') ?>
      </button>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           The working process — three steps
           --------------------------------------------------------------- */ ?>
  <section class="cpd-sec cpd-process">
    <div class="cpd-shell">
      <div class="cpd-head">
        <p class="cpd-eyebrow"><span class="cpd-mark" aria-hidden="true"></span>How we work</p>
        <h2 class="cpd-title">Three steps, and you<br>can stop at <em>any of them</em></h2>
        <p class="cpd-sub">
          Our approach is deliberately unglamorous and aimed at an outcome. Nothing below asks you to
          commit before you have something in writing.
        </p>
      </div>

      <ol class="cpd-steps">
        <?php foreach ($steps as $i => [$n, $title, $body]): ?>
          <li class="cpd-step" data-reveal style="--d:<?= $i ?>">
            <figure class="cpd-step-art">
              <img src="<?= e($img('step/' . $n . '.jpg')) ?>" width="860" height="540"
                   alt="" loading="lazy" decoding="async">
              <figcaption>Step <?= e($n) ?></figcaption>
            </figure>
            <h3><?= e($title) ?></h3>
            <p><?= e($body) ?></p>
          </li>
        <?php endforeach; ?>
      </ol>

      <div class="cpd-actions cpd-actions--mid">
        <button class="cpd-btn cpd-btn--ghost" type="button"
                data-modal-open data-modal-service="Custom Product Development">
          Book the 30-minute call<?= icon('arrow') ?>
        </button>
      </div>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           The stack — five groups, as tabs
           --------------------------------------------------------------- */ ?>
  <section class="cpd-sec cpd-stack" data-stack>
    <div class="cpd-shell">
      <div class="cpd-head cpd-head--mid">
        <p class="cpd-eyebrow"><span class="cpd-mark" aria-hidden="true"></span>The stack</p>
        <h2 class="cpd-title">Enabling innovation<br>with <em>next-gen tools</em></h2>
      </div>

      <div class="cpd-stack-tabs" role="tablist" aria-label="Technology groups">
        <?php foreach ($stack as $i => [$name]): ?>
          <button class="cpd-stack-tab<?= $i === 0 ? ' is-on' : '' ?>" type="button" role="tab"
                  aria-selected="<?= $i === 0 ? 'true' : 'false' ?>"
                  aria-controls="cpd-stack-<?= $i ?>" data-stack-tab="<?= $i ?>"><?= e($name) ?></button>
        <?php endforeach; ?>
      </div>

      <?php foreach ($stack as $i => [$name, $logos]): ?>
        <ul class="cpd-stack-panel" id="cpd-stack-<?= $i ?>" role="tabpanel"
            data-stack-panel="<?= $i ?>"<?= $i === 0 ? '' : ' hidden' ?>>
          <?php foreach ($logos as $slug): ?>
            <li>
              <img src="<?= e(asset('assets/img/tech/' . $slug . '.svg')) ?>"
                   width="34" height="34" alt="<?= e($slug) ?>" loading="lazy" decoding="async">
              <span><?= e($slug) ?></span>
            </li>
          <?php endforeach; ?>
        </ul>
      <?php endforeach; ?>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           Six advantages
           --------------------------------------------------------------- */ ?>
  <section class="cpd-sec cpd-edges">
    <div class="cpd-shell">
      <div class="cpd-head">
        <p class="cpd-eyebrow"><span class="cpd-mark" aria-hidden="true"></span>Why iThrive</p>
        <h2 class="cpd-title">Navigating your product<br>to <em>digital triumph</em></h2>
        <p class="cpd-sub">
          Startup or enterprise, you get one clear path to a product that holds its shape — without
          juggling multiple vendors and the seams between them.
        </p>
      </div>

      <div class="cpd-edge-grid">
        <?php foreach ($edges as $i => [$n, $title, $body]): ?>
          <article class="cpd-edge" data-reveal style="--d:<?= $i % 3 ?>">
            <figure class="cpd-edge-art">
              <img src="<?= e($img('edge/' . $n . '.jpg')) ?>" width="760" height="480"
                   alt="" loading="lazy" decoding="async">
            </figure>
            <div class="cpd-edge-body">
              <span class="cpd-num"><?= e($n) ?></span>
              <h3><?= e($title) ?></h3>
              <p><?= e($body) ?></p>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           Engagement models — the Interactive Book, plus the same three in text

           The book is the interaction; the list beside it is the content. A
           crawler, and anyone whose bundle never runs, reads all three models
           either way.
           --------------------------------------------------------------- */ ?>
  <section class="cpd-sec cpd-models">
    <div class="cpd-shell">
      <div class="cpd-head">
        <p class="cpd-eyebrow"><span class="cpd-mark" aria-hidden="true"></span>Engagement</p>
        <h2 class="cpd-title">Flexible paths to<br>your <em>custom product</em></h2>
        <p class="cpd-sub">Three ways to work with us. Turn the pages, or read them below.</p>
      </div>

      <div class="cpd-model-wrap">
        <div class="cpd-book"
             data-ok="flip-book-3d"
             data-props='<?= e(json_encode([
                 'frontCover'   => $img('model/01.jpg'),
                 'innerPages'   => [$img('model/02.jpg'), $img('model/03.jpg'), $img('model/04.jpg')],
                 'backCover'    => $img('model/05.jpg'),
                 'width'        => 300,
                 'height'       => 408,
                 'borderRadius' => 10,
                 /* Every one of these is read unconditionally — the component
                    dereferences shadow.color with no guard, so a missing
                    shadow object throws before it renders anything. */
                 'shadow'       => [
                     'color'   => '#00121A',
                     'opacity' => 0.55,
                     'offsetX' => 0,
                     'offsetY' => 26,
                     'blur'    => 60,
                     'spread'  => -12,
                 ],
             ], JSON_THROW_ON_ERROR)) ?>'></div>

        <div class="cpd-model-list">
          <?php foreach ($models as [$n, $title, $body, $when]): ?>
            <article class="cpd-model">
              <span class="cpd-num"><?= e($n) ?></span>
              <h3><?= e($title) ?></h3>
              <p><?= e($body) ?></p>
              <p class="cpd-model-when"><?= e($when) ?></p>
            </article>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           FAQ
           --------------------------------------------------------------- */ ?>
  <section class="cpd-sec cpd-faq">
    <div class="cpd-shell cpd-faq-grid">
      <div class="cpd-faq-side">
        <p class="cpd-eyebrow"><span class="cpd-mark" aria-hidden="true"></span>FAQ</p>
        <h2 class="cpd-title">The questions that<br>come up <em>every time</em></h2>
        <figure class="cpd-faq-art">
          <img src="<?= e($img('faq/01.jpg')) ?>" width="800" height="620"
               alt="" loading="lazy" decoding="async">
        </figure>
      </div>

      <div class="cpd-faq-list">
        <?php foreach ($faqs as $i => [$q, $a]): ?>
          <details class="cpd-faq-item"<?= $i === 0 ? ' open' : '' ?>>
            <summary><?= e($q) ?><span class="cpd-faq-mark" aria-hidden="true"></span></summary>
            <div class="cpd-faq-body"><p><?= e($a) ?></p></div>
          </details>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           Close
           --------------------------------------------------------------- */ ?>
  <section class="cpd-close">
    <div class="cpd-close-wash" aria-hidden="true"></div>
    <div class="cpd-shell">
      <p class="cpd-eyebrow"><span class="cpd-mark" aria-hidden="true"></span>Next step</p>
      <h2>Redefine your product<br>with <em>full-stack engineering</em></h2>
      <p class="cpd-close-lead">
        Tell us the workflow that costs you the most time and who is currently working around it. You
        will get scope, architecture and a budget range in writing within a week — including an
        honest answer if a packaged tool would serve you better.
      </p>
      <div class="cpd-actions cpd-actions--mid">
        <button class="cpd-btn cpd-btn--primary" type="button"
                data-modal-open data-modal-service="Custom Product Development">
          Get a free consultation<?= icon('arrow') ?>
        </button>
      </div>
    </div>
  </section>

</div>

<script type="module" src="<?= e(asset('assets/dist/originkit/originkit.js')) ?>"></script>
<script src="<?= e(asset('assets/js/custom-page.js')) ?>" defer></script>

<?php
require dirname(__DIR__) . '/includes/footer.php';
