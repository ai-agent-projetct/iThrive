<?php
/**
 * ReactJS Development — the third service page off the shared layout.
 *
 * Built after absoluteapplabs.com/reactjs-development-company-in-chennai,
 * section for section, in iThrive's own words.
 *
 * It wears the SITE's palette like the other two, weighted differently again so
 * the three do not read as one template run three times. The MVP page is
 * cyan-forward around a magazine; the PoC page sits at the blue-violet end
 * around a blueprint; this one is CYAN-TEAL around a component graph — orbit
 * rings, connector lines, and the bracket marks of JSX.
 *
 * Its Framer components are disjoint from the other two pages' again:
 *
 *   hero bg     Interactive Pattern    a dot field that reacts to the pointer
 *   hero        Liquid Glass Carousel  three.js and gsap: panels that refract
 *                                      and stretch as they are dragged
 *   compare     Split Reveal           drag between a legacy frontend and React
 *   process     Scroll Timeline        the five build stages
 *   industries  Physics Sticker Wall   twelve tiles you can throw around
 *
 * On the 3D hero: the first version reused the PoC page's Scroll 3D Slider on
 * its `cards` preset, on the belief that the free 3D components were spent. A
 * fuller sweep of the marketplace — all two hundred-odd listings rather than
 * the front page — turned up this one, which is its own WebGL scene and owes
 * nothing to the other two pages.
 *
 * Two more were fetched and rejected as canvas exports, whose props are
 * per-instance ids with the content baked into variants: Expand-OnHover List
 * and Service Card UI. Those sections are built here instead.
 *
 * Every picture is rendered from markup by tools/react-art.mjs, and every slot
 * prefers a photograph from assets/img/react/photo/ the moment one exists.
 *
 * Degrades: every Framer host has real markup around it, so with the island
 * absent the page still reads completely and a crawler sees all of it.
 */

declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/config.php';

$svc = service('reactjs-development');

$page      = 'services';
$pageTitle = 'ReactJS Development Company in Chennai';
$pageDesc  = 'iThrive Software builds React front ends that stay fast as they grow — measured '
           . 'rendering budgets, typed components, and an architecture you will not have to rebuild.';
$ogImage   = 'service-' . $svc['group_slug'];

/* ---------------------------------------------------------------------------
 * Content
 * ------------------------------------------------------------------------ */

/** The hero's panels: [n, title, the line under it]. */
$deck = [
    ['01', 'Components that compose',   'Boundaries drawn once, so the next feature is an addition'],
    ['02', 'State that stays predictable', 'Ownership decided up front, not discovered in a bug'],
    ['03', 'Renders you can budget',    'A count you agreed to, enforced by the build'],
    ['04', 'Types that catch it early', 'The failure happens in CI rather than in front of a user'],
    ['05', 'Bundles that stay small',   'Split on the routes people actually take'],
    ['06', 'A frontend that lasts',     'Still quick, and still pleasant to work in, at year two'],
];

$stats = [
    ['6+', 'Years shipping React'],
    ['50+', 'Engineers on the bench'],
    ['4.9/5', 'Average client rating'],
    ['1M+', 'Users on apps we built'],
];

/** Why React is the right choice — the four claims under the argument. */
$claims = [
    'Fast, responsive interfaces',
    'A frontend that stays maintainable',
    'Room to iterate without rewrites',
    'Architecture that adapts as you grow',
];

/** What we do — six. */
$doing = [
    ['01', 'Custom application development',
     'A React application built around your product logic and your user journeys, with an architecture meant to carry a roadmap rather than just the first release.'],
    ['02', 'Single-page applications',
     'Component architecture and modern routing, so the app loads once and stays quick — fewer drop-offs on the paths that actually earn money.'],
    ['03', 'UI and design-system implementation',
     'Your design system turned into typed, accessible components that keep the intent of the design instead of approximating it.'],
    ['04', 'Modernisation and migration',
     'Legacy front ends moved to React a route at a time, behind a switch, with the old app still serving traffic until the new one has earned it.'],
    ['05', 'Backend integration',
     'REST, GraphQL, microservices or your own cloud services, with data flow and caching designed rather than improvised.'],
    ['06', 'Performance engineering',
     'Rendering, state and bundle structure reviewed against a budget — the re-renders and payload that make an app feel slow as it grows.'],
];

/** Technology combinations — seven. */
$stacks = [
    ['01', 'Full stack (MERN)',            'MongoDB, Express, React and Node. Fast to iterate on, and one language across the whole thing keeps a small team quick.', ['MongoDB', 'Express', 'React', 'Node']],
    ['02', 'React + TypeScript + Firebase', 'Types on the front end and a managed backend for auth, data and scale — the fastest route to a stable product without infrastructure work.', ['TypeScript', 'Firebase', 'Auth']],
    ['03', 'React + Redux + GraphQL',       'Predictable state as features multiply, and only the data a screen needs on the wire. For data-heavy workflows that must stay responsive.', ['Redux', 'GraphQL', 'Apollo']],
    ['04', 'React + TypeScript + Django',   'Where the business logic is complex and the security model matters. Strong typing at both ends and a backend built for structure.', ['TypeScript', 'Django', 'Postgres']],
    ['05', 'React + Material UI + FastAPI',  'A polished interface over high-throughput Python APIs. Suits products with heavy interaction and large request volumes.', ['Material UI', 'FastAPI', 'Python']],
    ['06', 'React + Redux + Firebase',      'Real-time by default, with consistent UI state across clients. Dashboards, collaborative tools, anything with live data.', ['Redux', 'Realtime', 'Firebase']],
    ['07', 'React + AI-assisted delivery',  'We use AI coding tools internally for generation, refactoring and consistency checks. It reduces the mechanical work; it does not review itself.', ['Codegen', 'Review', 'Standards']],
];

/** How we build — five stages. */
$stages = [
    ['01', 'Requirements',  'We start with how the product is actually used, who it serves and what counts as success — user flows, business goals and a performance budget, written down before anything is designed.'],
    ['02', 'Structuring',   'Component boundaries, state ownership and routing decided up front. Most React codebases that become unmaintainable were never structured, only grown.'],
    ['03', 'Development',   'Typed components against the design system, reviewed in small pieces, with the app running on real data from the first week.'],
    ['04', 'Validation',    'Accessibility, Core Web Vitals and render counts treated as build-failing constraints rather than a post-launch clean-up.'],
    ['05', 'Scaling',       'Code splitting, caching and monitoring in place before traffic arrives, so growth is a graph rather than an incident.'],
];

/**
 * Who we build for — twelve, each with the reason it is actually different.
 *
 * The heading promises a reason and the first version of this section did not
 * give one: twelve names in a list and nothing to click. A sector list without
 * the reason is decoration, so each one now says what specifically changes
 * about a React front end when it is built for that industry.
 */
$industries = [
    ['01', 'On-demand',
     'Everything on screen is live at once — the map, the ETA, the driver. The work is keeping all three honest without re-rendering the world every second.'],
    ['02', 'Healthcare',
     'Clinicians work fast and cannot afford ambiguity. Contrast, focus order and error states are the product here, and much of it is a legal requirement rather than a preference.'],
    ['03', 'Media',
     'Content volume breaks naive rendering first. Virtualised lists, an image budget, and a bundle that does not grow every time the catalogue does.'],
    ['04', 'Travel',
     'Search has to stay responsive while price, availability and currency all move underneath it — usually on the worst connection of the user\'s week.'],
    ['05', 'Restaurant',
     'Used one-handed, in a hurry, often on an old phone. Tap targets, offline tolerance, and a menu that renders before somebody gives up on it.'],
    ['06', 'E-commerce',
     'Every hundred milliseconds is measurable in revenue. The critical path to the first product and to checkout is essentially the whole brief.'],
    ['07', 'EduTech',
     'Long sessions and heavy state — progress, attempts, media. Losing a learner\'s place costs more than being slightly slow ever would.'],
    ['08', 'Logistics',
     'Dense operational screens used all day by people who know them well. Keyboard flow and information density beat whitespace every time.'],
    ['09', 'Real estate',
     'Image-heavy by nature. Galleries, maps and floorplans that load in the order people actually browse them, not the order they appear in the DOM.'],
    ['10', 'Grocery',
     'Large baskets, constant edits, substitutions. State that stays correct while somebody changes their mind fifteen times.'],
    ['11', 'Food delivery',
     'Three parties watching one order. The customer, the kitchen and the rider have to see the same truth at the same moment.'],
    ['12', 'Entertainment',
     'Playback is the product and everything else defers to it — no layout shift, no blocking script, no dropped frame.'],
];

/** Why choose us — five. */
$why = [
    ['01', 'Performance-led builds',    'A render and bundle budget is agreed before the first component, and the build fails when it is exceeded. Speed is a constraint here, not a phase.'],
    ['02', 'Product-focused engineering', 'We ask what the screen is for. If a requested feature will not move the number it is meant to move, you hear that in discovery.'],
    ['03', 'Adaptive front ends',       'Component boundaries drawn so tomorrow\'s feature is an addition rather than a refactor of everything it touches.'],
    ['04', 'Scalable architecture',     'State ownership, routing and data flow designed once, deliberately — the decisions that are ruinous to change at year two.'],
    ['05', 'Structured delivery',       'Fortnightly demos on real data, and an honest reading of what is and is not done. Slippage surfaces at week two, not month four.'],
];

$faqs = [
    ['Can you integrate React with our existing backend or a legacy system?',
     'Yes, and it is most of what we do. React talks to REST, GraphQL and older SOAP or server-rendered endpoints equally well, and the integration is designed so data flow stays stable while the interface improves. Where the legacy system is the constraint, we put a thin layer in front of it rather than waiting for it to be replaced.'],
    ['Do you take on React migrations from another framework?',
     'Regularly — from Angular, Vue, jQuery and server-rendered templates. It runs route by route behind a switch: the old application keeps serving traffic while new routes take over one at a time, each one reversible. A rewrite that asks the business to stand still for a year is the version that fails.'],
    ['Our frontend feels slow and fragmented. Can that be fixed without starting over?',
     'Usually, yes. Slowness in a React app is normally a small number of specific causes — unnecessary re-renders, state held too high, an unsplit bundle, images and fonts nobody budgeted. We measure first and report what we find, including when the honest answer is that the architecture is the problem and a rebuild is cheaper.'],
    ['How do we see progress, and how do we know what is really done?',
     'A demo on real data every fortnight, the repository in your own account from the first commit, and the same board we use. "Done" means merged, deployed and instrumented, not written and awaiting integration.'],
    ['Why React rather than another framework?',
     'Mostly for reasons that are not technical: the hiring pool, the library ecosystem and the fact that another team can pick it up without you. Where something else genuinely fits better we will say so — this is a service page, not a position we have to defend.'],
];

$extraHead = '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>'
    . '<link rel="stylesheet" href="https://fonts.googleapis.com/css2?'
    . 'family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;600;700'
    . '&family=Space+Grotesk:wght@400;500;600;700&display=swap">'
    . '<link rel="stylesheet" href="' . e(asset('assets/css/react.css')) . '">';

require dirname(__DIR__) . '/includes/header.php';

/**
 * The picture for a slot, preferring a photograph.
 *
 * Same convention as the MVP and PoC pages: a real photograph in
 * assets/img/react/photo/<set>-<n>.jpg wins over the drawn composition in
 * assets/img/react/<set>/<n>.jpg, so the set can be filled a few at a time with
 * no edit here.
 */
$img = static function (string $rel): string {
    [$set, $file] = explode('/', $rel, 2);
    $photo = 'assets/img/react/photo/' . $set . '-' . $file;

    return asset(is_file(ROOT_PATH . '/' . $photo) ? $photo : 'assets/img/react/' . $rel);
};

/** Absolute, for the components that only accept an http(s) src. */
$imgAbs = static fn (string $rel): string => site_origin() . $img($rel);
?>

<div class="rjs">

  <?php /* ---------------------------------------------------------------
           Hero — a pointer-reactive dot field behind a three.js card deck
           --------------------------------------------------------------- */ ?>
  <section class="rjs-hero">
    <?php /* Framer's Interactive Pattern. Sits behind the hero and answers the
             pointer; the site's honeycomb still shows through both, because
             nothing here paints an opaque background. */ ?>
    <div class="rjs-hero-field" aria-hidden="true"
         data-ok="interactive-pattern"
         data-props='<?= e(json_encode([
             'gridType'        => 'dots',
             'showBackground'  => false,
             'dotColor'        => 'rgba(0, 242, 254, 0.30)',
             'dotSize'         => 3,
             'spacing'         => 46,
             'proximityRadius' => 190,
         ], JSON_THROW_ON_ERROR)) ?>'></div>

    <div class="rjs-shell rjs-hero-grid">
      <div class="rjs-hero-copy">
        <p class="rjs-eyebrow"><span class="rjs-brk" aria-hidden="true">&lt;</span>ReactJS Development · Chennai<span class="rjs-brk" aria-hidden="true">/&gt;</span></p>

        <h1 class="rjs-h1">
          React front ends that are<br>
          <em>still fast in year two</em>
        </h1>

        <p class="rjs-lead">
          Most React apps do not start slow, they become slow — one unbudgeted render, one piece of
          state held too high, one bundle nobody split. We build the front end with those decisions
          made deliberately at the start, and a performance budget the build enforces.
        </p>

        <div class="rjs-actions">
          <button class="rjs-btn rjs-btn--primary" type="button"
                  data-modal-open data-modal-service="ReactJS Development">
            Talk to a React engineer<?= icon('arrow') ?>
          </button>
          <a class="rjs-btn rjs-btn--ghost" href="#rjs-process">How we build</a>
        </div>

        <ul class="rjs-stats">
          <?php foreach ($stats as [$v, $l]): ?>
            <li><strong><?= e($v) ?></strong><span><?= e($l) ?></span></li>
          <?php endforeach; ?>
        </ul>
      </div>

      <?php /* Framer's Liquid Glass Carousel — three.js and gsap, panels that
               refract and stretch as they move. Its own component rather than
               a second preset of the PoC page's slider, which is what this
               hero used first and which was too close to that page. */ ?>
      <div class="rjs-hero-stage">
        <?php /* Same poster treatment as the PoC hero: the liquid carousel
                 paints nothing before its first animation frame. */ ?>
        <div class="rjs-deck-wrap" data-webgl-poster>
        <div class="rjs-deck-host" data-webgl-stage
             data-ok="liquid-carousel"
             data-props='<?= e(json_encode([
                 'projects' => array_map(static fn (array $d): array => [
                     /* `image` is an object here — the component reads
                        project.image?.src — not the bare string the PoC page's
                        slider takes. Absolute, so the texture loader is not
                        left resolving a relative path. */
                     'image'       => ['src' => $imgAbs('deck/' . $d[0] . '.jpg'), 'alt' => $d[1]],
                     'brand'       => $d[1],
                     'description' => $d[2],
                 ], $deck),
                 'panelHeight'      => 300,
                 'gap'              => 34,
                 /* Slow. Every one of these pages has had to have its motion
                    brought down at least once. */
                 'glide'            => 0.05,
                 'wheelSensitivity' => 0.55,
                 'snap'             => true,
                 'snapDistance'     => 70,
                 'snapDelay'        => 130,
             ], JSON_THROW_ON_ERROR)) ?>'>
          <noscript>
            <ul class="rjs-deck-list">
              <?php foreach ($deck as [$n, $t]): ?><li><?= e($t) ?></li><?php endforeach; ?>
            </ul>
          </noscript>
        </div>
          <div class="rjs-poster" aria-hidden="true">
            <ul>
              <?php foreach ($deck as [$n, $t, $sub]): ?>
                <li><span><?= e($n) ?></span><strong><?= e($t) ?></strong><em><?= e($sub) ?></em></li>
              <?php endforeach; ?>
            </ul>
          </div>
        </div>

        <p class="rjs-stage-hint">Drag the panels · what we actually optimise for</p>
      </div>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           Why React — the argument, with a draggable before/after
           --------------------------------------------------------------- */ ?>
  <section class="rjs-sec rjs-why">
    <div class="rjs-shell rjs-split">
      <div class="rjs-split-copy">
        <p class="rjs-eyebrow"><span class="rjs-brk" aria-hidden="true">&lt;</span>The case for React<span class="rjs-brk" aria-hidden="true">/&gt;</span></p>
        <h2 class="rjs-title">Why React is<br><em>the right choice</em></h2>

        <p>
          What counts as fast does not stay still. An interface that felt quick two years ago is
          merely average now, and products increasingly compete on how they feel as much as on what
          they do. When a screen hesitates, users read it as the product being unreliable — and they
          are usually right, because the same causes that make it slow make it fragile.
        </p>
        <p>
          Traditional front ends tend to hit a ceiling as products grow. Each feature adds a little
          coupling, releases take longer, and eventually the team is negotiating with the codebase
          rather than building in it. React does not prevent that on its own; a deliberate component
          architecture does, and that is the part we are actually selling.
        </p>

        <ul class="rjs-claims">
          <?php foreach ($claims as $c): ?><li><?= e($c) ?></li><?php endforeach; ?>
        </ul>
      </div>

      <?php /* Framer's Split Reveal — drag between the two states. Its handle
               is the interaction; the caption says what is being compared. */ ?>
      <figure class="rjs-split-art">
        <div class="rjs-split-host"
             data-ok="split-reveal"
             data-props='<?= e(json_encode([
                 'beforeImage' => ['src' => $imgAbs('compare/01.jpg'), 'alt' => 'A legacy front end under load'],
                 'afterImage'  => ['src' => $imgAbs('compare/02.jpg'), 'alt' => 'The same product rebuilt in React'],
                 'initialPosition' => 46,
             ], JSON_THROW_ON_ERROR)) ?>'>
          <noscript><img src="<?= e($img('compare/02.jpg')) ?>" width="900" height="700" alt=""></noscript>
        </div>
        <figcaption>Drag: the same product before and after the front end was rebuilt</figcaption>
      </figure>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           What we do — six, click to open
           --------------------------------------------------------------- */ ?>
  <section class="rjs-sec rjs-doing" data-doing>
    <div class="rjs-shell">
      <div class="rjs-head">
        <p class="rjs-eyebrow"><span class="rjs-brk" aria-hidden="true">&lt;</span>What we do<span class="rjs-brk" aria-hidden="true">/&gt;</span></p>
        <h2 class="rjs-title">Six things we are<br>actually <em>engaged to build</em></h2>
      </div>

      <div class="rjs-doing-grid">
        <?php foreach ($doing as $i => [$n, $title, $body]): ?>
          <article class="rjs-doing-card<?= $i === 0 ? ' is-open' : '' ?>"
                   data-doing-card role="button" tabindex="0"
                   aria-expanded="<?= $i === 0 ? 'true' : 'false' ?>" style="--d:<?= $i % 3 ?>">
            <span class="rjs-doing-num"><?= e($n) ?></span>
            <h3 class="rjs-doing-title"><?= e($title) ?></h3>
            <div class="rjs-doing-panel">
              <figure class="rjs-doing-art">
                <img src="<?= e($img('doing/' . $n . '.jpg')) ?>" width="800" height="500"
                     alt="" loading="lazy" decoding="async">
              </figure>
              <p><?= e($body) ?></p>
            </div>
            <span class="rjs-doing-more" aria-hidden="true"></span>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           Band
           --------------------------------------------------------------- */ ?>
  <section class="rjs-band">
    <div class="rjs-shell rjs-band-inner">
      <h2>React front ends that earn trust<br><em>every time someone opens them</em></h2>
      <button class="rjs-btn rjs-btn--primary" type="button"
              data-modal-open data-modal-service="ReactJS Development">
        Explore React solutions<?= icon('arrow') ?>
      </button>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           Technology combinations — seven
           --------------------------------------------------------------- */ ?>
  <section class="rjs-sec rjs-stacks">
    <div class="rjs-shell">
      <div class="rjs-head">
        <p class="rjs-eyebrow"><span class="rjs-brk" aria-hidden="true">&lt;</span>Stacks<span class="rjs-brk" aria-hidden="true">/&gt;</span></p>
        <h2 class="rjs-title">The combinations we build<br><em>high-impact React apps</em> on</h2>
        <p class="rjs-sub">
          React on its own is a view layer. What decides whether a product holds up is everything
          around it — so these are the seven pairings we actually run, and what each one is for.
        </p>
      </div>

      <div class="rjs-stack-grid">
        <?php foreach ($stacks as $i => [$n, $title, $body, $tags]): ?>
          <article class="rjs-stack-card" data-reveal style="--d:<?= $i % 3 ?>">
            <figure class="rjs-stack-art">
              <img src="<?= e($img('stack/' . $n . '.jpg')) ?>" width="800" height="500"
                   alt="" loading="lazy" decoding="async">
              <span class="rjs-stack-num"><?= e($n) ?></span>
            </figure>
            <div class="rjs-stack-body">
              <h3><?= e($title) ?></h3>
              <p><?= e($body) ?></p>
              <ul class="rjs-tags">
                <?php foreach ($tags as $t): ?><li><?= e($t) ?></li><?php endforeach; ?>
              </ul>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           How we build — Framer's Scroll Timeline, five stages
           --------------------------------------------------------------- */ ?>
  <section class="rjs-sec rjs-process" id="rjs-process">
    <div class="rjs-shell">
      <div class="rjs-head">
        <p class="rjs-eyebrow"><span class="rjs-brk" aria-hidden="true">&lt;</span>Process<span class="rjs-brk" aria-hidden="true">/&gt;</span></p>
        <h2 class="rjs-title">How we build your<br><em>React applications</em></h2>
      </div>
    </div>

    <div class="rjs-timeline-host"
         data-ok="scroll-timeline"
         data-props='<?= e(json_encode([
             'items' => array_map(static fn (array $s): array => [
                 'eyebrow' => $s[0] . '/ ' . $s[1],
                 'desc'    => $s[2],
                 'year'    => $s[1],
                 'bg'      => '#0E1420',
                 'fg'      => '#EAF6FA',
             ], $stages),
             'labelFont'   => ['fontSize' => 13, 'fontWeight' => 600, 'letterSpacing' => '0.18em'],
             'labelOpacity' => 0.75,
             'descFont'    => ['fontSize' => 16, 'lineHeight' => '1.7em'],
             'yearFont'    => ['fontSize' => 74, 'fontWeight' => 700, 'letterSpacing' => '-0.04em'],
         ], JSON_THROW_ON_ERROR)) ?>'>
      <?php /* The same five stages in plain markup, so the section is complete
               before the island mounts and for anything that never runs it. */ ?>
      <ol class="rjs-stage-fallback">
        <?php foreach ($stages as [$n, $t, $b]): ?>
          <li><strong><?= e($n) ?> · <?= e($t) ?></strong><span><?= e($b) ?></span></li>
        <?php endforeach; ?>
      </ol>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           Industries — Framer's Physics Sticker Wall, and a readable list
           --------------------------------------------------------------- */ ?>
  <section class="rjs-sec rjs-industries">
    <div class="rjs-shell">
      <div class="rjs-head rjs-head--mid">
        <p class="rjs-eyebrow"><span class="rjs-brk" aria-hidden="true">&lt;</span>Who we build for<span class="rjs-brk" aria-hidden="true">/&gt;</span></p>
        <h2 class="rjs-title">Twelve sectors, and the<br>reason that <em>matters</em></h2>
        <p class="rjs-sub">
          Every sector arrives with a different idea of what an interface owes its user, and a build
          that ignores that ships something technically correct and practically wrong. Throw the
          stickers around if you like — then pick a sector below and it will tell you exactly what
          changes about the front end when we build for it.
        </p>
      </div>
    </div>

    <?php /* The wall takes at most ten pictures and throws stickerCount of
             them, so twelve tiles are drawn from ten images by design. */ ?>
    <div class="rjs-wall-host"
         data-ok="physics-sticker-wall"
         data-props='<?= e(json_encode([
             'images' => array_map(
                 static fn (array $s): array => ['src' => $imgAbs('sector/' . $s[0] . '.jpg'), 'alt' => $s[1]],
                 array_slice($industries, 0, 10)
             ),
             'background'      => 'rgba(0, 0, 0, 0)',
             'stickerCount'    => 12,
             'stickerSize'     => 108,
             'sizeRandomness'  => 0.28,
             'gravityStrength' => 0.7,
             'restitution'     => 0.52,
             'friction'        => 0.12,
         ], JSON_THROW_ON_ERROR)) ?>'></div>

    <div class="rjs-shell">
      <?php /* Twelve tiles that tilt toward the pointer in real 3D — a
               perspective on the grid and a rotate on each card, driven from
               pointermove — and open the sector's reason when clicked. The
               first version of this was a flat, inert list. */ ?>
      <div class="rjs-sector-grid" data-sectors role="tablist" aria-label="Sectors we build for">
        <?php foreach ($industries as $i => [$n, $name, $reason]): ?>
          <button class="rjs-sector-tile<?= $i === 0 ? ' is-on' : '' ?>" type="button"
                  role="tab" aria-selected="<?= $i === 0 ? 'true' : 'false' ?>"
                  aria-controls="rjs-sector-<?= e($n) ?>" data-sector-tile="<?= $i ?>">
            <span class="rjs-tile-inner">
              <span class="rjs-tile-num"><?= e($n) ?></span>
              <span class="rjs-tile-name"><?= e($name) ?></span>
            </span>
          </button>
        <?php endforeach; ?>
      </div>

      <?php foreach ($industries as $i => [$n, $name, $reason]): ?>
        <div class="rjs-sector-panel" id="rjs-sector-<?= e($n) ?>" role="tabpanel"
             data-sector-panel="<?= $i ?>"<?= $i === 0 ? '' : ' hidden' ?>>
          <?php /* Framer's Dithering Hover on the panel's picture: a dithered
                   zone that follows the cursor across it. Only the open panel
                   mounts one, so twelve canvases are never built at once. */ ?>
          <div class="rjs-sector-art"
               data-ok="dithering-hover"
               data-props='<?= e(json_encode([
                   'image'    => ['src' => $imgAbs('sector/' . $n . '.jpg'), 'alt' => $name],
                   'ovalSize' => 220,
                   'dotSize'  => 5,
               ], JSON_THROW_ON_ERROR)) ?>'>
            <noscript><img src="<?= e($img('sector/' . $n . '.jpg')) ?>" width="600" height="600" alt=""></noscript>
          </div>

          <div class="rjs-sector-body">
            <p class="rjs-sector-kicker"><?= e($n) ?> · <?= e($name) ?></p>
            <h3>What changes when we build for <em><?= e(strtolower($name)) ?></em></h3>
            <p><?= e($reason) ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           Mid CTA
           --------------------------------------------------------------- */ ?>
  <section class="rjs-midcta">
    <div class="rjs-shell">
      <h2>Build a frontend you will not need<br><em>to rebuild in a year</em></h2>
      <button class="rjs-btn rjs-btn--primary" type="button"
              data-modal-open data-modal-service="ReactJS Development">
        Start a technical conversation<?= icon('arrow') ?>
      </button>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           Why choose us — five
           --------------------------------------------------------------- */ ?>
  <section class="rjs-sec rjs-choose">
    <div class="rjs-shell">
      <div class="rjs-head">
        <p class="rjs-eyebrow"><span class="rjs-brk" aria-hidden="true">&lt;</span>Why iThrive<span class="rjs-brk" aria-hidden="true">/&gt;</span></p>
        <h2 class="rjs-title">Why choose us for<br><em>ReactJS development</em></h2>
        <p class="rjs-sub">
          We are a frontend team that turns up where the structure is missing. The work is not
          shipping screens — it is leaving behind a foundation the next two years of features can be
          built on without renegotiating the whole thing.
        </p>
      </div>

      <div class="rjs-choose-grid">
        <?php foreach ($why as $i => [$n, $title, $body]): ?>
          <article class="rjs-choose-card" data-reveal style="--d:<?= $i % 3 ?>">
            <figure class="rjs-choose-art">
              <img src="<?= e($img('why/' . $n . '.jpg')) ?>" width="800" height="520"
                   alt="" loading="lazy" decoding="async">
            </figure>
            <div class="rjs-choose-body">
              <span class="rjs-num"><?= e($n) ?></span>
              <h3><?= e($title) ?></h3>
              <p><?= e($body) ?></p>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           FAQ
           --------------------------------------------------------------- */ ?>
  <section class="rjs-sec rjs-faq">
    <div class="rjs-shell rjs-faq-grid">
      <div class="rjs-faq-side">
        <p class="rjs-eyebrow"><span class="rjs-brk" aria-hidden="true">&lt;</span>FAQ<span class="rjs-brk" aria-hidden="true">/&gt;</span></p>
        <h2 class="rjs-title">What teams ask<br><em>before they start</em></h2>
        <figure class="rjs-faq-art">
          <img src="<?= e($img('faq/01.jpg')) ?>" width="800" height="600"
               alt="" loading="lazy" decoding="async">
        </figure>
      </div>

      <div class="rjs-faq-list">
        <?php foreach ($faqs as $i => [$q, $a]): ?>
          <details class="rjs-faq-item"<?= $i === 0 ? ' open' : '' ?>>
            <summary><?= e($q) ?><span class="rjs-faq-mark" aria-hidden="true"></span></summary>
            <div class="rjs-faq-body"><p><?= e($a) ?></p></div>
          </details>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           Trusted by — the site's own logo grid
           --------------------------------------------------------------- */ ?>
  <section class="rjs-sec rjs-trusted">
    <div class="rjs-shell">
      <div class="rjs-head rjs-head--mid">
        <p class="rjs-eyebrow"><span class="rjs-brk" aria-hidden="true">&lt;</span>Trusted by<span class="rjs-brk" aria-hidden="true">/&gt;</span></p>
        <h2 class="rjs-title">Teams who let us near<br>their <em>front end</em></h2>
      </div>
      <?php component('client-logo-grid'); ?>
    </div>
  </section>

</div>

<?php /* The island that carries the Framer components. Mounts are lazy; three.js
         and matter-js are separate chunks fetched only by this page's hero and
         its sticker wall. */ ?>
<script type="module" src="<?= e(asset('assets/dist/originkit/originkit.js')) ?>"></script>

<?php /* This page's own behaviour: the six "what we do" cards. */ ?>
<script src="<?= e(asset('assets/js/react-page.js')) ?>" defer></script>
<script src="<?= e(asset('assets/js/webgl-poster.js')) ?>" defer></script>

<?php
require dirname(__DIR__) . '/includes/footer.php';
