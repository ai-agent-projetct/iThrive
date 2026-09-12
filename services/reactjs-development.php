<?php
/**
 * ReactJS Development — with Forbes Legacy Pass 3D Video Hero & 30 New Images
 * Inspired by https://kerembalku.com/ (Forbes Legacy Pass)
 */

declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/config.php';

$svc = service('reactjs-development');

$page      = 'services';
$hasOriginKit = true;
$pageTitle = 'ReactJS Development Company in Chennai — High-Velocity 3D Frontends';
$pageDesc  = 'iThrive Software builds React front ends that stay fast as they grow — measured rendering budgets, typed components, and an architecture you will not have to rebuild.';
$ogImage   = 'service-' . $svc['group_slug'];

$extraHead = '<link rel="stylesheet" href="' . e(asset('assets/css/react-forbes.css')) . '">' .
             '<script type="module" src="' . e(asset('assets/js/interactive-droplets.js')) . '"></script>' .
             '<script type="module" src="' . e(asset('assets/js/forbes-legacy-pass.js')) . '"></script>';

require dirname(__DIR__) . '/includes/header.php';

/** The 6 Forbes Legacy Pass cards in the continuous 3D loop */
$passCards = [
    [
        'id'    => 'VIP-01',
        'title' => 'Components that compose',
        'desc'  => 'Boundaries drawn once, so the next feature is an addition without refactoring existing trees.',
        'img'   => 'assets/img/react-3d/pass-01-components.jpg',
        'tag'   => 'COMPOSABLE ARCH',
    ],
    [
        'id'    => 'VIP-02',
        'title' => 'State that stays predictable',
        'desc'  => 'Ownership decided up front with Zustand & Redux Toolkit, never discovered in a production bug.',
        'img'   => 'assets/img/react-3d/pass-02-state.jpg',
        'tag'   => 'FLUX MESH',
    ],
    [
        'id'    => 'VIP-03',
        'title' => 'Renders you can budget',
        'desc'  => 'A strict render count enforced by the CI build and monitored with React Profiler.',
        'img'   => 'assets/img/react-3d/pass-03-budget.jpg',
        'tag'   => '60FPS BUDGET',
    ],
    [
        'id'    => 'VIP-04',
        'title' => 'Types that catch it early',
        'desc'  => 'Strict TypeScript and runtime Zod validation so failures happen in CI rather than in production.',
        'img'   => 'assets/img/react-3d/pass-04-types.jpg',
        'tag'   => 'STRICT TYPES',
    ],
    [
        'id'    => 'VIP-05',
        'title' => 'Bundles that stay small',
        'desc'  => 'Intelligent route code-splitting, tree-shaking, and lazy hydration for sub-second TTI.',
        'img'   => 'assets/img/react-3d/pass-05-bundles.jpg',
        'tag'   => 'LEAN BUNDLES',
    ],
    [
        'id'    => 'VIP-06',
        'title' => 'A frontend that lasts',
        'desc'  => 'Engineered on React 19 Server Components and actions — still quick and enjoyable at year two.',
        'img'   => 'assets/img/react-3d/pass-06-longevity.jpg',
        'tag'   => 'REACT 19 CORE',
    ],
];
?>

<div class="react-forbes-page">
  <!-- 1. OriginKit Interactive Droplets WebGL Hero (Split 3D Layout) -->
  <section class="forbes-hero-section" id="react-hero">
    <div class="shell" style="position: relative; z-index: 5;">
      <div class="react-hero-split-grid">

        <!-- Left Column: Content, CTAs, Performance Gates -->
        <div class="react-hero-content-col">
          <div class="forbes-pill-badge" data-reveal>
            <span class="forbes-pill-dot"></span>
            <span class="forbes-pill-text">ORIGINKIT INTERACTIVE DROPLETS // PRESET: BASE // REACT ARCHITECTURE</span>
          </div>

          <h1 class="forbes-hero-title" data-reveal style="--d:1">
            ReactJS Development Services<br>
            <em>High-Velocity 3D Frontends &amp; Concurrent Scale</em>
          </h1>

          <p class="forbes-hero-lead" data-reveal style="--d:2">
            We engineer high-concurrency React web applications and interactive 3D frontends that stay 60FPS fast as they scale — measured rendering budgets, typed components, and long-term durability. Delivered by our specialized React engineering squads across Chennai, Coimbatore, Bangalore, Hyderabad, and Ahmedabad.
          </p>

          <div class="forbes-hero-ctas" data-reveal style="--d:3">
            <a class="forbes-btn-primary" href="<?= e(url('contact.php')) ?>">
              Start Your React Build <?= icon('arrow') ?>
            </a>
            <a class="forbes-btn-secondary" href="#capabilities">
              Explore Capabilities
            </a>
            <a class="forbes-btn-secondary" href="tel:+919384564915">
              Call: +91 93845 64915
            </a>
          </div>

          <!-- 4 Performance Gate Cards (2x2 Grid) -->
          <div class="react-hero-stats-grid" data-reveal style="--d:4">
            <div style="background:rgba(13,19,32,0.85);border:1px solid rgba(0,242,254,0.35);border-radius:14px;padding:18px 16px;box-shadow:0 10px 25px rgba(0,0,0,0.5);backdrop-filter:blur(8px);">
              <div style="font-family:'Space Grotesk',sans-serif;font-size:2rem;font-weight:800;color:#00F2FE;line-height:1;">60 FPS</div>
              <div style="font-family:'Inter',sans-serif;font-size:.78rem;color:#94A3B8;margin-top:6px;text-transform:uppercase;letter-spacing:0.06em;">Sub-16ms Frame Budget</div>
            </div>
            <div style="background:rgba(13,19,32,0.85);border:1px solid rgba(78,168,255,0.35);border-radius:14px;padding:18px 16px;box-shadow:0 10px 25px rgba(0,0,0,0.5);backdrop-filter:blur(8px);">
              <div style="font-family:'Space Grotesk',sans-serif;font-size:2rem;font-weight:800;color:#4EA8FF;line-height:1;">React 19</div>
              <div style="font-family:'Inter',sans-serif;font-size:.78rem;color:#94A3B8;margin-top:6px;text-transform:uppercase;letter-spacing:0.06em;">Server Components &amp; Actions</div>
            </div>
            <div style="background:rgba(13,19,32,0.85);border:1px solid rgba(178,75,243,0.35);border-radius:14px;padding:18px 16px;box-shadow:0 10px 25px rgba(0,0,0,0.5);backdrop-filter:blur(8px);">
              <div style="font-family:'Space Grotesk',sans-serif;font-size:2rem;font-weight:800;color:#B24BF3;line-height:1;">&lt;100ms</div>
              <div style="font-family:'Inter',sans-serif;font-size:.78rem;color:#94A3B8;margin-top:6px;text-transform:uppercase;letter-spacing:0.06em;">Sub-Second TTI Hydration</div>
            </div>
            <div style="background:rgba(13,19,32,0.85);border:1px solid rgba(0,255,157,0.35);border-radius:14px;padding:18px 16px;box-shadow:0 10px 25px rgba(0,0,0,0.5);backdrop-filter:blur(8px);">
              <div style="font-family:'Space Grotesk',sans-serif;font-size:2rem;font-weight:800;color:#00FF9D;line-height:1;">5 Hubs</div>
              <div style="font-family:'Inter',sans-serif;font-size:.78rem;color:#94A3B8;margin-top:6px;text-transform:uppercase;letter-spacing:0.06em;">Chennai, BLR, HYD, CBE, AHD</div>
            </div>
          </div>
        </div>

        <!-- Right Column: OriginKit Interactive Droplets WebGL Stage -->
        <div class="react-hero-stage-col" data-reveal style="--d:5">
          <div class="react-3d-stage-wrap">
            <div class="react-3d-stage" id="react-droplets-stage">
              <!-- WebGL OriginKit Interactive Droplets Canvas Host -->
              <div id="react-droplets-canvas" data-originkit="interactive-droplets" data-preset="base"></div>

              <!-- HUD Telemetry Top Bar -->
              <div class="droplet-stage-hud">
                <div class="droplet-hud-left">
                  <span class="droplet-hud-chip" id="droplet-hud-chip-label">
                    <span class="poc-chip-pulse"></span>
                    ORIGINKIT // INTERACTIVE DROPLETS [PRESET: BASE]
                  </span>
                </div>
                <div class="droplet-hud-controls">
                  <button type="button" class="droplet-preset-btn active" data-style="base">Base</button>
                  <button type="button" class="droplet-preset-btn" data-style="react">React</button>
                  <button type="button" class="droplet-preset-btn" data-style="mint">Mint</button>
                  <button type="button" class="droplet-preset-btn" data-style="silver">Silver</button>
                  <button type="button" class="droplet-preset-btn" data-style="ember">Ember</button>
                  <button type="button" class="droplet-view-btn active" id="droplet-toggle-idle">Idle: ON</button>
                  <button type="button" class="droplet-view-btn active" id="droplet-toggle-rest">Rest: ON</button>
                </div>
              </div>

              <div class="droplet-stage-bottom-hint">
                <span style="color:#00D8FF;">✦</span> Move cursor to trail liquid beads · Fuses into fluid mass on stop
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- 2. Forbes Legacy Pass 6-Card 3D Video Architecture Section -->
  <section class="react-sec react-sec--panel" style="padding-top: 60px; padding-bottom: 70px;">
    <div class="shell" style="text-align: center;">
      <div class="forbes-pill-badge" data-reveal>
        <span class="forbes-pill-dot"></span>
        <span class="forbes-pill-text">FORBES LEGACY PASS // 6-CARD 3D CYLINDER ARCHITECTURE</span>
      </div>
      <h2 class="react-title" data-reveal style="--d:1" style="margin-bottom: 16px;">
        Interactive 3D Component Architecture
      </h2>
      <p class="react-lead" data-reveal style="--d:2" style="max-width: 800px; margin: 0 auto 36px;">
        Explore six core architecture boundaries engineered into every enterprise React engagement.
      </p>

      <!-- Forbes Legacy Pass 16:9 Stage with 4K Video Background & 6-Card 3D Cylinder Loop -->
      <div class="forbes-stage-wrap" data-reveal style="--d:3">
        <div class="forbes-stage" id="forbes-stage">
          <!-- Background Video from Kerem Balku Forbes Legacy Pass -->
          <video class="forbes-bg-video" autoplay muted loop playsinline preload="auto">
            <source src="<?= e(asset('assets/video/legacy-pass-hero-4-video.webm')) ?>" type="video/webm">
          </video>
          <div class="forbes-stage-overlay"></div>

          <!-- HUD Telemetry Overlay -->
          <div class="forbes-hud-info">
            <span class="forbes-hud-badge">Forbes Legacy Pass Engine</span>
            <span style="font-family:'Space Grotesk',sans-serif;font-size:11px;color:#94A3B8;">6-Card 3D Loop // 60FPS</span>
          </div>
          <div class="forbes-hud-hint">Drag or scroll to rotate 3D pass cards · Continuous Loop</div>

          <!-- 3D Carousel Cylinder holding the 6 VIP Access Cards -->
          <div class="forbes-carousel" id="forbes-carousel">
            <?php foreach ($passCards as $card): ?>
              <div class="forbes-pass-card">
                <div class="forbes-card-header">
                  <div class="forbes-card-chip">
                    <div class="forbes-chip-icon"></div>
                    <span class="forbes-card-id"><?= e($card['id']) ?></span>
                  </div>
                  <span class="forbes-pass-tag"><?= e($card['tag']) ?></span>
                </div>

                <div class="forbes-card-img-wrap">
                  <img src="<?= e(asset($card['img'])) ?>" alt="<?= e($card['title']) ?>" loading="lazy">
                </div>

                <div class="forbes-card-body">
                  <h3 class="forbes-card-title"><?= e($card['title']) ?></h3>
                  <p class="forbes-card-desc"><?= e($card['desc']) ?></p>
                  
                  <div class="forbes-card-footer">
                    <span class="forbes-barcode">REACT // 2026.V4</span>
                    <span style="font-family:'JetBrains Mono',monospace;font-size:10px;color:#00F2FE;font-weight:700;">ACTIVE PASS</span>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- 2. Why React / Architecture Pillars (4 Images) -->
  <section class="react-sec react-sec--panel">
    <div class="shell">
      <div class="react-sec-head" data-reveal>
        <span class="react-eyebrow">ARCHITECTURAL ADVANTAGES</span>
        <h2 class="react-title">Why React is the Standard for High-Concurrency Frontends</h2>
        <p class="react-lead">
          Four foundational guarantees that protect your engineering velocity and user experience.
        </p>
      </div>

      <div class="react-grid" style="grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));">
        <div class="react-card" data-reveal style="--d:1">
          <div class="react-card-img-wrap">
            <img src="<?= e(asset('assets/img/react-3d/arch-01-speed.jpg')) ?>" alt="60FPS Concurrent UX" loading="lazy">
            <span class="react-card-badge">PILLAR 01</span>
          </div>
          <div class="react-card-body">
            <h3 class="react-card-title">Fast, Responsive Interfaces</h3>
            <p class="react-card-desc">Sub-16ms frame budgets and concurrent React transitions ensuring silky smooth interactions even under data-heavy workflows.</p>
          </div>
        </div>

        <div class="react-card" data-reveal style="--d:2">
          <div class="react-card-img-wrap">
            <img src="<?= e(asset('assets/img/react-3d/arch-02-maintain.jpg')) ?>" alt="Modular Design Systems" loading="lazy">
            <span class="react-card-badge">PILLAR 02</span>
          </div>
          <div class="react-card-body">
            <h3 class="react-card-title">A Frontend That Stays Maintainable</h3>
            <p class="react-card-desc">Strict component boundaries and isolated state containers that prevent regressions as team size doubles.</p>
          </div>
        </div>

        <div class="react-card" data-reveal style="--d:3">
          <div class="react-card-img-wrap">
            <img src="<?= e(asset('assets/img/react-3d/arch-03-iterate.jpg')) ?>" alt="High-Velocity Iteration" loading="lazy">
            <span class="react-card-badge">PILLAR 03</span>
          </div>
          <div class="react-card-body">
            <h3 class="react-card-title">Room to Iterate Without Rewrites</h3>
            <p class="react-card-desc">Modular feature slices and clean dependency injection allow incremental roadmap evolutions without rip-and-replace cycles.</p>
          </div>
        </div>

        <div class="react-card" data-reveal style="--d:4">
          <div class="react-card-img-wrap">
            <img src="<?= e(asset('assets/img/react-3d/arch-04-scale.jpg')) ?>" alt="Enterprise Scale" loading="lazy">
            <span class="react-card-badge">PILLAR 04</span>
          </div>
          <div class="react-card-body">
            <h3 class="react-card-title">Architecture That Adapts as You Grow</h3>
            <p class="react-card-desc">From single-page web applications to micro-frontends and multi-tenant platforms handling millions of daily active users.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- 3. What We Do / Core Capabilities (6 Images) -->
  <section class="react-sec" id="capabilities">
    <div class="shell">
      <div class="react-sec-head" data-reveal>
        <span class="react-eyebrow">WHAT WE DELIVER</span>
        <h2 class="react-title">Six Specialized React Development Practices</h2>
        <p class="react-lead">
          From custom greenfield web applications to complex legacy codebase modernizations.
        </p>
      </div>

      <div class="react-grid">
        <div class="react-card" data-reveal style="--d:1">
          <div class="react-card-img-wrap">
            <img src="<?= e(asset('assets/img/react-3d/do-01-custom-app.jpg')) ?>" alt="Custom Application Development" loading="lazy">
            <span class="react-card-badge">PRACTICE 01</span>
          </div>
          <div class="react-card-body">
            <span class="react-card-group">Bespoke Engineering</span>
            <h3 class="react-card-title">Custom Application Development</h3>
            <p class="react-card-desc">A tailored React front end built around your domain logic, user journeys, and enterprise security policies.</p>
          </div>
        </div>

        <div class="react-card" data-reveal style="--d:2">
          <div class="react-card-img-wrap">
            <img src="<?= e(asset('assets/img/react-3d/do-02-spa.jpg')) ?>" alt="Single-Page Applications" loading="lazy">
            <span class="react-card-badge">PRACTICE 02</span>
          </div>
          <div class="react-card-body">
            <span class="react-card-group">Web Performance</span>
            <h3 class="react-card-title">Single-Page Applications (SPAs)</h3>
            <p class="react-card-desc">Zero full-page reloads, instant client-side transitions, and optimistic data mutations for frictionless user flows.</p>
          </div>
        </div>

        <div class="react-card" data-reveal style="--d:3">
          <div class="react-card-img-wrap">
            <img src="<?= e(asset('assets/img/react-3d/do-03-design-sys.jpg')) ?>" alt="Design System Implementation" loading="lazy">
            <span class="react-card-badge">PRACTICE 03</span>
          </div>
          <div class="react-card-body">
            <span class="react-card-group">UI Architecture</span>
            <h3 class="react-card-title">Design System Engineering</h3>
            <p class="react-card-desc">Figma designs translated into strictly typed, accessible component libraries powered by Tailwind CSS and Radix UI.</p>
          </div>
        </div>

        <div class="react-card" data-reveal style="--d:4">
          <div class="react-card-img-wrap">
            <img src="<?= e(asset('assets/img/react-3d/do-04-migration.jpg')) ?>" alt="Legacy Modernization" loading="lazy">
            <span class="react-card-badge">PRACTICE 04</span>
          </div>
          <div class="react-card-body">
            <span class="react-card-group">Modernization</span>
            <h3 class="react-card-title">Modernization &amp; Migration</h3>
            <p class="react-card-desc">Moving legacy jQuery, Angular, or monolith frontends to modern React one route at a time with zero service downtime.</p>
          </div>
        </div>

        <div class="react-card" data-reveal style="--d:5">
          <div class="react-card-img-wrap">
            <img src="<?= e(asset('assets/img/react-3d/do-05-backend-int.jpg')) ?>" alt="High-Speed Backend API" loading="lazy">
            <span class="react-card-badge">PRACTICE 05</span>
          </div>
          <div class="react-card-body">
            <span class="react-card-group">Integration</span>
            <h3 class="react-card-title">Backend &amp; Cloud Integration</h3>
            <p class="react-card-desc">Robust data fetching architectures using TanStack Query, GraphQL Apollo, and WebSockets with automatic retry and caching.</p>
          </div>
        </div>

        <div class="react-card" data-reveal style="--d:6">
          <div class="react-card-img-wrap">
            <img src="<?= e(asset('assets/img/react-3d/do-06-perf-audit.jpg')) ?>" alt="React Perf Profiling" loading="lazy">
            <span class="react-card-badge">PRACTICE 06</span>
          </div>
          <div class="react-card-body">
            <span class="react-card-group">Optimization</span>
            <h3 class="react-card-title">Performance Engineering</h3>
            <p class="react-card-desc">Eliminating unnecessary re-renders, profiling memory leaks, and tuning Core Web Vitals to achieve 98+ Lighthouse scores.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- 4. Technology Stacks & Ecosystems (7 Images) -->
  <section class="react-sec react-sec--panel">
    <div class="shell">
      <div class="react-sec-head" data-reveal>
        <span class="react-eyebrow">TECH STACKS</span>
        <h2 class="react-title">Seven Production-Grade React Ecosystems</h2>
        <p class="react-lead">
          Carefully selected stack pairings tailored for performance, delivery speed, and operational resilience.
        </p>
      </div>

      <div class="react-grid">
        <div class="react-card" data-reveal style="--d:1">
          <div class="react-card-img-wrap">
            <img src="<?= e(asset('assets/img/react-3d/stack-01-mern.jpg')) ?>" alt="Full Stack MERN" loading="lazy">
            <span class="react-card-badge">STACK 01</span>
          </div>
          <div class="react-card-body">
            <h3 class="react-card-title">Full Stack MERN</h3>
            <p class="react-card-desc">MongoDB, Express, React, and Node.js. Unified language across client and server for rapid iteration and prototyping.</p>
            <div class="react-card-tags">
              <span class="react-card-pill">MongoDB</span>
              <span class="react-card-pill">Express</span>
              <span class="react-card-pill">React</span>
              <span class="react-card-pill">Node.js</span>
            </div>
          </div>
        </div>

        <div class="react-card" data-reveal style="--d:2">
          <div class="react-card-img-wrap">
            <img src="<?= e(asset('assets/img/react-3d/stack-02-firebase.jpg')) ?>" alt="React + TS + Firebase" loading="lazy">
            <span class="react-card-badge">STACK 02</span>
          </div>
          <div class="react-card-body">
            <h3 class="react-card-title">React + TypeScript + Firebase</h3>
            <p class="react-card-desc">Strict TypeScript typing combined with Firebase Realtime DB, Firestore, and Edge Auth for instant enterprise MVPs.</p>
            <div class="react-card-tags">
              <span class="react-card-pill">TypeScript</span>
              <span class="react-card-pill">Firebase</span>
              <span class="react-card-pill">Edge Auth</span>
            </div>
          </div>
        </div>

        <div class="react-card" data-reveal style="--d:3">
          <div class="react-card-img-wrap">
            <img src="<?= e(asset('assets/img/react-3d/stack-03-nextjs.jpg')) ?>" alt="Next.js App Router" loading="lazy">
            <span class="react-card-badge">STACK 03</span>
          </div>
          <div class="react-card-body">
            <h3 class="react-card-title">Next.js App Router &amp; SSR</h3>
            <p class="react-card-desc">Server-Side Rendering, Static Site Generation, and Streaming SSR with React Server Components for maximum SEO and speed.</p>
            <div class="react-card-tags">
              <span class="react-card-pill">Next.js 15</span>
              <span class="react-card-pill">Server Components</span>
              <span class="react-card-pill">Edge Vercel</span>
            </div>
          </div>
        </div>

        <div class="react-card" data-reveal style="--d:4">
          <div class="react-card-img-wrap">
            <img src="<?= e(asset('assets/img/react-3d/stack-04-python.jpg')) ?>" alt="React + FastAPI Python" loading="lazy">
            <span class="react-card-badge">STACK 04</span>
          </div>
          <div class="react-card-body">
            <h3 class="react-card-title">React + FastAPI Python</h3>
            <p class="react-card-desc">High-concurrency async Python backends paired with snappy React front ends for AI and algorithmic computation.</p>
            <div class="react-card-tags">
              <span class="react-card-pill">FastAPI</span>
              <span class="react-card-pill">Python 3.12</span>
              <span class="react-card-pill">Uvloop</span>
            </div>
          </div>
        </div>

        <div class="react-card" data-reveal style="--d:5">
          <div class="react-card-img-wrap">
            <img src="<?= e(asset('assets/img/react-3d/stack-05-mobile.jpg')) ?>" alt="React Native Cross-Platform" loading="lazy">
            <span class="react-card-badge">STACK 05</span>
          </div>
          <div class="react-card-body">
            <h3 class="react-card-title">React Native Cross-Platform</h3>
            <p class="react-card-desc">Share 85%+ of business logic between web and native iOS/Android mobile apps without sacrificing 60FPS fluid gestures.</p>
            <div class="react-card-tags">
              <span class="react-card-pill">React Native</span>
              <span class="react-card-pill">iOS</span>
              <span class="react-card-pill">Android</span>
            </div>
          </div>
        </div>

        <div class="react-card" data-reveal style="--d:6">
          <div class="react-card-img-wrap">
            <img src="<?= e(asset('assets/img/react-3d/stack-06-threejs.jpg')) ?>" alt="React Three Fiber" loading="lazy">
            <span class="react-card-badge">STACK 06</span>
          </div>
          <div class="react-card-body">
            <h3 class="react-card-title">React Three Fiber (R3F)</h3>
            <p class="react-card-desc">Declarative 3D scenes, WebGL shaders, and physics engines integrated natively into the React component tree.</p>
            <div class="react-card-tags">
              <span class="react-card-pill">Three.js</span>
              <span class="react-card-pill">R3F</span>
              <span class="react-card-pill">Shaders</span>
            </div>
          </div>
        </div>

        <div class="react-card" data-reveal style="--d:7">
          <div class="react-card-img-wrap">
            <img src="<?= e(asset('assets/img/react-3d/stack-07-microfront.jpg')) ?>" alt="Micro-Frontends Mesh" loading="lazy">
            <span class="react-card-badge">STACK 07</span>
          </div>
          <div class="react-card-body">
            <h3 class="react-card-title">Micro-Frontends Mesh</h3>
            <p class="react-card-desc">Webpack Module Federation enabling autonomous squad deployments across large enterprise engineering teams.</p>
            <div class="react-card-tags">
              <span class="react-card-pill">Module Federation</span>
              <span class="react-card-pill">Vite</span>
              <span class="react-card-pill">Decoupled</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- 5. Industry Solutions (4 Images) -->
  <section class="react-sec">
    <div class="shell">
      <div class="react-sec-head" data-reveal>
        <span class="react-eyebrow">DOMAINS IN PRODUCTION</span>
        <h2 class="react-title">Engineered for High-Stakes Industries</h2>
        <p class="react-lead">
          Delivering critical performance where data accuracy and low latency directly impact revenue.
        </p>
      </div>

      <div class="react-grid" style="grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));">
        <div class="react-card" data-reveal style="--d:1">
          <div class="react-card-img-wrap">
            <img src="<?= e(asset('assets/img/react-3d/ind-01-fintech.jpg')) ?>" alt="Fintech & Trading Rails" loading="lazy">
          </div>
          <div class="react-card-body">
            <h3 class="react-card-title">Fintech &amp; Trading Rails</h3>
            <p class="react-card-desc">High-frequency order books, live candle charts, and sub-millisecond price ticks without browser thread freezing.</p>
          </div>
        </div>

        <div class="react-card" data-reveal style="--d:2">
          <div class="react-card-img-wrap">
            <img src="<?= e(asset('assets/img/react-3d/ind-02-health.jpg')) ?>" alt="Healthcare & Clinical Portals" loading="lazy">
          </div>
          <div class="react-card-body">
            <h3 class="react-card-title">Healthcare &amp; Telemedicine</h3>
            <p class="react-card-desc">HIPAA-compliant EHR portals, real-time WebRTC consultations, and medical imaging visualizers.</p>
          </div>
        </div>

        <div class="react-card" data-reveal style="--d:3">
          <div class="react-card-img-wrap">
            <img src="<?= e(asset('assets/img/react-3d/ind-03-commerce.jpg')) ?>" alt="High-AOV Headless Commerce" loading="lazy">
          </div>
          <div class="react-card-body">
            <h3 class="react-card-title">High-AOV Headless Commerce</h3>
            <p class="react-card-desc">Sub-400ms shopping carts, instant faceted filters, and 3D product previews driving 30%+ conversion lift.</p>
          </div>
        </div>

        <div class="react-card" data-reveal style="--d:4">
          <div class="react-card-img-wrap">
            <img src="<?= e(asset('assets/img/react-3d/ind-04-saas.jpg')) ?>" alt="Enterprise B2B SaaS" loading="lazy">
          </div>
          <div class="react-card-body">
            <h3 class="react-card-title">Enterprise B2B SaaS</h3>
            <p class="react-card-desc">Multi-tenant workspaces, granular permission matrices, and dense real-time data table management.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- 6. Case Studies & Benchmarks (3 Images) -->
  <section class="react-sec react-sec--panel">
    <div class="shell">
      <div class="react-sec-head" data-reveal>
        <span class="react-eyebrow">PRODUCTION BENCHMARKS</span>
        <h2 class="react-title">Tested Under Real Production Workloads</h2>
        <p class="react-lead">
          Verified metrics from live React platforms engineered and supported by our engineering squads.
        </p>
      </div>

      <div class="react-grid" style="grid-template-columns: repeat(auto-fit, minmax(340px, 1fr));">
        <div class="react-card" data-reveal style="--d:1">
          <div class="react-card-img-wrap">
            <img src="<?= e(asset('assets/img/react-3d/case-01-brokerage.jpg')) ?>" alt="Trading Terminal Proof" loading="lazy">
          </div>
          <div class="react-card-body">
            <span class="react-card-group">&lt; 40ms Latency</span>
            <h3 class="react-card-title">Institutional Trading Platform</h3>
            <p class="react-card-desc">Real-time level 2 order book streaming 5,000 price updates per second with zero UI thread lag.</p>
          </div>
        </div>

        <div class="react-card" data-reveal style="--d:2">
          <div class="react-card-img-wrap">
            <img src="<?= e(asset('assets/img/react-3d/case-02-telehealth.jpg')) ?>" alt="Global Telehealth Mesh" loading="lazy">
          </div>
          <div class="react-card-body">
            <span class="react-card-group">99.99% Reliability</span>
            <h3 class="react-card-title">Global Telehealth Portal</h3>
            <p class="react-card-desc">Zero-latency patient monitoring dashboard handling 250,000 concurrent encrypted video consultations.</p>
          </div>
        </div>

        <div class="react-card" data-reveal style="--d:3">
          <div class="react-card-img-wrap">
            <img src="<?= e(asset('assets/img/react-3d/case-03-logistics.jpg')) ?>" alt="Fleet Dispatch Console" loading="lazy">
          </div>
          <div class="react-card-body">
            <span class="react-card-group">60FPS Canvas</span>
            <h3 class="react-card-title">Fleet Dispatch Command Center</h3>
            <p class="react-card-desc">WebGL-accelerated vehicle telemetry map rendering 50,000 active delivery couriers in real time.</p>
          </div>
        </div>
      </div>

      <div class="section-foot" data-reveal style="text-align: center; margin-top: 40px;">
        <a class="btn btn-ghost" href="<?= e(url('case-studies.php')) ?>">All Case Studies <?= icon('arrow') ?></a>
      </div>
    </div>
  </section>

  <!-- 7. Call to Action -->
  <?php
  component('cta', ['cta' => [
      'eyebrow'   => 'Start Your Project',
      'title'     => 'Bring us the React frontend that needs to be fast.',
      'body'      => 'Our senior React engineers in Chennai, Coimbatore, Bangalore, Hyderabad, and Ahmedabad are ready to build. Call +91 93845 64915 or email info@ithrivesoftware.com.',
      'primary'   => ['label' => 'Start Your React Project', 'href' => 'contact.php'],
      'secondary' => ['label' => 'Call: +91 93845 64915', 'href' => 'tel:+919384564915'],
  ]]);
  ?>
</div>

<?php
require dirname(__DIR__) . '/includes/footer.php';
