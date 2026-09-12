<?php
declare(strict_types=1);

$page      = 'services';
$pageTitle = 'Services — 15 Engineering Practices in Python, AI & Cloud';
$pageDesc  = 'Fifteen specialized engineering practices across four disciplines: AI-native product engineering, SaaS, modernization, cloud infrastructure, and mobile systems.';

require_once __DIR__ . '/includes/config.php';

$schema = [
    '@type'           => 'ItemList',
    'name'            => 'Services offered by iThrive Software',
    'itemListOrder'   => 'https://schema.org/ItemListUnordered',
    'numberOfItems'   => count(all_services()),
    'itemListElement' => array_map(static fn (array $svc, int $i): array => [
        '@type'    => 'ListItem',
        'position' => $i + 1,
        'name'     => $svc['title'],
        'url'      => canonical('services/' . $svc['slug'] . '.php'),
    ], all_services(), array_keys(all_services())),
];

$extraHead = '<link rel="stylesheet" href="' . e(asset('assets/css/services-galaxy.css')) . '">' .
             '<script type="module" src="' . e(asset('assets/js/framer-galaxy.js')) . '"></script>';

require __DIR__ . '/includes/header.php';
?>

<div class="svc-galaxy-page">
  <!-- 1. Framer 3D Particle Spiral Galaxy Hero -->
  <section class="svc-galaxy-hero">
    <div class="shell" style="text-align: center;">
      <div class="svc-pill-badge" data-reveal>
        <span class="svc-pill-dot"></span>
        <span class="svc-pill-text">CONTINUOUS ENGINEERING INFRASTRUCTURE</span>
      </div>

      <h1 class="svc-hero-title" data-reveal style="--d:1">
        Engineering Practices, Not a Menu of Deliverables
      </h1>

      <p class="svc-hero-lead" data-reveal style="--d:2">
        Fifteen specialized practices across four engineering disciplines. Every platform is built in Python, Agentic AI, and Cloud Architecture, delivered by senior engineers from our 5 regional hubs.
      </p>

      <div class="svc-hero-ctas" data-reveal style="--d:3">
        <a class="svc-btn-primary" href="<?= e(url('contact.php')) ?>">
          Talk to an Engineer <?= icon('arrow') ?>
        </a>
        <a class="svc-btn-secondary" href="#matrix">
          Explore 15 Practices
        </a>
        <a class="svc-btn-secondary" href="tel:+919384564915">
          Call: +91 93845 64915
        </a>
      </div>

      <!-- 3D Spiral Galaxy Stage (55,000 Particles, Three.js) -->
      <div class="svc-galaxy-container" data-reveal style="--d:4">
        <div class="svc-galaxy-stage" id="galaxy-stage">
          <div class="svc-galaxy-hud">
            <span class="svc-galaxy-badge">85k Spiral Galaxy Engine</span>
            <span style="font-family:'Space Grotesk',sans-serif;font-size:11px;color:#64748B;">16:9 Interactive Galaxy Hero</span>
          </div>
          <div class="svc-galaxy-hint">Drag to rotate 3D galaxy · Auto-orbiting</div>
        </div>
      </div>
    </div>
  </section>

  <!-- 2. Services Matrix (15 Core Practices with 15 Images) -->
  <section class="svc-section" id="matrix">
    <div class="shell">
      <div class="svc-sec-head" data-reveal>
        <span class="svc-eyebrow">ENGINEERING PRACTICES & DISCIPLINES</span>
        <h2 class="svc-title">Fifteen Specialized Practices Across Four Engineering Disciplines</h2>
        <p class="svc-lead">
          Every platform is built in Python, Agentic AI, and Cloud Architecture — delivered by senior engineers from our 5 regional engineering hubs in Chennai, Coimbatore, Bangalore, Hyderabad, and Ahmedabad.
        </p>
      </div>

      <div class="svc-matrix-grid">
        <!-- 1. AI Native -->
        <a class="svc-matrix-card" href="<?= e(url('services/ai-native-product-development.php')) ?>" data-reveal style="--d:1">
          <div class="svc-card-img-wrap">
            <img src="<?= e(asset('assets/img/services-3d/svc-01-ai-native.jpg')) ?>" alt="AI-Native Product Development" loading="lazy">
            <span class="svc-card-badge">DISCIPLINE 01</span>
          </div>
          <div class="svc-card-body">
            <span class="svc-card-group">AI & Intelligent Systems</span>
            <h3 class="svc-card-title">AI-Native Product Dev</h3>
            <p class="svc-card-desc">Ground-up platforms engineered around neural network inference, vector search, and dynamic cognitive loops.</p>
            <span class="svc-card-link">Explore Architecture <?= icon('arrow') ?></span>
          </div>
        </a>

        <!-- 2. AI Enablement -->
        <a class="svc-matrix-card" href="<?= e(url('services/ai-enablement.php')) ?>" data-reveal style="--d:2">
          <div class="svc-card-img-wrap">
            <img src="<?= e(asset('assets/img/services-3d/svc-02-ai-enablement.jpg')) ?>" alt="Enterprise AI Enablement" loading="lazy">
            <span class="svc-card-badge">DISCIPLINE 02</span>
          </div>
          <div class="svc-card-body">
            <span class="svc-card-group">AI & Intelligent Systems</span>
            <h3 class="svc-card-title">AI Enablement</h3>
            <p class="svc-card-desc">Embedding intelligence into mature enterprise software through private LLM fine-tuning and secure local inference.</p>
            <span class="svc-card-link">Explore Architecture <?= icon('arrow') ?></span>
          </div>
        </a>

        <!-- 3. Agentic AI -->
        <a class="svc-matrix-card" href="<?= e(url('services/agentic-ai-development.php')) ?>" data-reveal style="--d:3">
          <div class="svc-card-img-wrap">
            <img src="<?= e(asset('assets/img/services-3d/svc-03-agentic-ai.jpg')) ?>" alt="Autonomous Agent Swarms" loading="lazy">
            <span class="svc-card-badge">DISCIPLINE 03</span>
          </div>
          <div class="svc-card-body">
            <span class="svc-card-group">AI & Intelligent Systems</span>
            <h3 class="svc-card-title">Agentic AI Systems</h3>
            <p class="svc-card-desc">Self-orchestrating multi-agent networks that execute mission-critical domain workflows without human intervention.</p>
            <span class="svc-card-link">Explore Architecture <?= icon('arrow') ?></span>
          </div>
        </a>

        <!-- 4. MLOps -->
        <a class="svc-matrix-card" href="<?= e(url('services/ai-development.php')) ?>" data-reveal style="--d:4">
          <div class="svc-card-img-wrap">
            <img src="<?= e(asset('assets/img/services-3d/svc-04-mlops.jpg')) ?>" alt="MLOps & Inference Rails" loading="lazy">
            <span class="svc-card-badge">DISCIPLINE 04</span>
          </div>
          <div class="svc-card-body">
            <span class="svc-card-group">AI & Intelligent Systems</span>
            <h3 class="svc-card-title">MLOps & Inference Rails</h3>
            <p class="svc-card-desc">Continuous training pipelines, model quantization, drift telemetry, and low-latency GPU serving clusters.</p>
            <span class="svc-card-link">Explore Architecture <?= icon('arrow') ?></span>
          </div>
        </a>

        <!-- 5. Micro SaaS -->
        <a class="svc-matrix-card" href="<?= e(url('services/micro-saas-development.php')) ?>" data-reveal style="--d:5">
          <div class="svc-card-img-wrap">
            <img src="<?= e(asset('assets/img/services-3d/svc-05-micro-saas.jpg')) ?>" alt="Micro SaaS Engineering" loading="lazy">
            <span class="svc-card-badge">DISCIPLINE 05</span>
          </div>
          <div class="svc-card-body">
            <span class="svc-card-group">Product & SaaS</span>
            <h3 class="svc-card-title">Micro SaaS Engineering</h3>
            <p class="svc-card-desc">Multi-tenant, self-serve software products engineered for high margin and minimal cloud overhead.</p>
            <span class="svc-card-link">Explore Architecture <?= icon('arrow') ?></span>
          </div>
        </a>

        <!-- 6. Custom Software -->
        <a class="svc-matrix-card" href="<?= e(url('services/custom-software-development.php')) ?>" data-reveal style="--d:6">
          <div class="svc-card-img-wrap">
            <img src="<?= e(asset('assets/img/services-3d/svc-06-custom-software.jpg')) ?>" alt="Custom Software Systems" loading="lazy">
            <span class="svc-card-badge">DISCIPLINE 06</span>
          </div>
          <div class="svc-card-body">
            <span class="svc-card-group">Product & SaaS</span>
            <h3 class="svc-card-title">Custom Software Systems</h3>
            <p class="svc-card-desc">Bespoke operational backbones built in Python for businesses that have outgrown off-the-shelf software.</p>
            <span class="svc-card-link">Explore Architecture <?= icon('arrow') ?></span>
          </div>
        </a>

        <!-- 7. Rapid MVP -->
        <a class="svc-matrix-card" href="<?= e(url('services/mvp-development.php')) ?>" data-reveal style="--d:7">
          <div class="svc-card-img-wrap">
            <img src="<?= e(asset('assets/img/services-3d/svc-07-mvp.jpg')) ?>" alt="30-Day Rapid MVP" loading="lazy">
            <span class="svc-card-badge">DISCIPLINE 07</span>
          </div>
          <div class="svc-card-body">
            <span class="svc-card-group">Product & SaaS</span>
            <h3 class="svc-card-title">Rapid MVP Foundry</h3>
            <p class="svc-card-desc">Production-grade minimum viable products scoped, built, and shipped into live customer hands in 30 days.</p>
            <span class="svc-card-link">Explore Architecture <?= icon('arrow') ?></span>
          </div>
        </a>

        <!-- 8. Modernization -->
        <a class="svc-matrix-card" href="<?= e(url('services/modernization.php')) ?>" data-reveal style="--d:8">
          <div class="svc-card-img-wrap">
            <img src="<?= e(asset('assets/img/services-3d/svc-08-modernization.jpg')) ?>" alt="Legacy Architecture Modernization" loading="lazy">
            <span class="svc-card-badge">DISCIPLINE 08</span>
          </div>
          <div class="svc-card-body">
            <span class="svc-card-group">Product & SaaS</span>
            <h3 class="svc-card-title">Legacy Modernization</h3>
            <p class="svc-card-desc">Incremental straggler-pattern migration of fragile monolithic codebases into resilient microservices.</p>
            <span class="svc-card-link">Explore Architecture <?= icon('arrow') ?></span>
          </div>
        </a>

        <!-- 9. Web Development -->
        <a class="svc-matrix-card" href="<?= e(url('services/web-development.php')) ?>" data-reveal style="--d:9">
          <div class="svc-card-img-wrap">
            <img src="<?= e(asset('assets/img/services-3d/svc-09-web-dev.jpg')) ?>" alt="Modern Web Applications" loading="lazy">
            <span class="svc-card-badge">DISCIPLINE 09</span>
          </div>
          <div class="svc-card-body">
            <span class="svc-card-group">Web & Mobile</span>
            <h3 class="svc-card-title">Modern Web Apps</h3>
            <p class="svc-card-desc">High-speed React, Next.js, and Python web portals delivering sub-50ms API responses and 60FPS UX.</p>
            <span class="svc-card-link">Explore Architecture <?= icon('arrow') ?></span>
          </div>
        </a>

        <!-- 10. Mobile Apps -->
        <a class="svc-matrix-card" href="<?= e(url('services/mobile-development.php')) ?>" data-reveal style="--d:10">
          <div class="svc-card-img-wrap">
            <img src="<?= e(asset('assets/img/services-3d/svc-10-mobile-apps.jpg')) ?>" alt="Cross-Platform Mobile" loading="lazy">
            <span class="svc-card-badge">DISCIPLINE 10</span>
          </div>
          <div class="svc-card-body">
            <span class="svc-card-group">Web & Mobile</span>
            <h3 class="svc-card-title">Cross-Platform Mobile</h3>
            <p class="svc-card-desc">Native Flutter and React Native mobile applications with offline-first synchronisation and hardware access.</p>
            <span class="svc-card-link">Explore Architecture <?= icon('arrow') ?></span>
          </div>
        </a>

        <!-- 11. E-Commerce -->
        <a class="svc-matrix-card" href="<?= e(url('services/ecommerce-development.php')) ?>" data-reveal style="--d:11">
          <div class="svc-card-img-wrap">
            <img src="<?= e(asset('assets/img/services-3d/svc-11-ecommerce.jpg')) ?>" alt="Enterprise Commerce Engines" loading="lazy">
            <span class="svc-card-badge">DISCIPLINE 11</span>
          </div>
          <div class="svc-card-body">
            <span class="svc-card-group">Web & Mobile</span>
            <h3 class="svc-card-title">Enterprise E-Commerce</h3>
            <p class="svc-card-desc">Headless commerce architectures, 1-click biometric checkout, and sub-second payment gateway mesh.</p>
            <span class="svc-card-link">Explore Architecture <?= icon('arrow') ?></span>
          </div>
        </a>

        <!-- 12. Game Development -->
        <a class="svc-matrix-card" href="<?= e(url('services/game-development.php')) ?>" data-reveal style="--d:12">
          <div class="svc-card-img-wrap">
            <img src="<?= e(asset('assets/img/services-3d/svc-12-game-dev.jpg')) ?>" alt="Interactive 3D Games" loading="lazy">
            <span class="svc-card-badge">DISCIPLINE 12</span>
          </div>
          <div class="svc-card-body">
            <span class="svc-card-group">Web & Mobile</span>
            <h3 class="svc-card-title">Interactive 3D & Games</h3>
            <p class="svc-card-desc">High-fidelity Three.js, WebGL shader pipelines, and real-time multiplayer browser experiences.</p>
            <span class="svc-card-link">Explore Architecture <?= icon('arrow') ?></span>
          </div>
        </a>

        <!-- 13. Cloud & DevOps -->
        <a class="svc-matrix-card" href="<?= e(url('services/cloud-and-devops.php')) ?>" data-reveal style="--d:13">
          <div class="svc-card-img-wrap">
            <img src="<?= e(asset('assets/img/services-3d/svc-13-cloud-devops.jpg')) ?>" alt="Cloud & DevOps" loading="lazy">
            <span class="svc-card-badge">DISCIPLINE 13</span>
          </div>
          <div class="svc-card-body">
            <span class="svc-card-group">Cloud & Teams</span>
            <h3 class="svc-card-title">Cloud Architecture & SRE</h3>
            <p class="svc-card-desc">Terraform declarative infrastructure, Kubernetes cluster hardening, and automated CI/CD canary rollouts.</p>
            <span class="svc-card-link">Explore Architecture <?= icon('arrow') ?></span>
          </div>
        </a>

        <!-- 14. Dedicated Teams -->
        <a class="svc-matrix-card" href="<?= e(url('services/dedicated-teams.php')) ?>" data-reveal style="--d:14">
          <div class="svc-card-img-wrap">
            <img src="<?= e(asset('assets/img/services-3d/svc-14-dedicated-teams.jpg')) ?>" alt="Dedicated Squads" loading="lazy">
            <span class="svc-card-badge">DISCIPLINE 14</span>
          </div>
          <div class="svc-card-body">
            <span class="svc-card-group">Cloud & Teams</span>
            <h3 class="svc-card-title">Dedicated Engineering Squads</h3>
            <p class="svc-card-desc">Self-contained teams of senior product engineers, architects, and QA specialists embedded into your roadmap.</p>
            <span class="svc-card-link">Explore Architecture <?= icon('arrow') ?></span>
          </div>
        </a>

        <!-- 15. On-Demand Talent -->
        <a class="svc-matrix-card" href="<?= e(url('services/ondemand.php')) ?>" data-reveal style="--d:15">
          <div class="svc-card-img-wrap">
            <img src="<?= e(asset('assets/img/services-3d/svc-15-ondemand.jpg')) ?>" alt="On-Demand Specialists" loading="lazy">
            <span class="svc-card-badge">DISCIPLINE 15</span>
          </div>
          <div class="svc-card-body">
            <span class="svc-card-group">Cloud & Teams</span>
            <h3 class="svc-card-title">On-Demand Specialists</h3>
            <p class="svc-card-desc">Elastic principal engineer capacity deployed within 48 hours for critical architectural milestones.</p>
            <span class="svc-card-link">Explore Architecture <?= icon('arrow') ?></span>
          </div>
        </a>
      </div>
    </div>
  </section>

  <!-- 3. Architecture Blueprint (4 Images) -->
  <section class="svc-section svc-section--panel">
    <div class="shell">
      <div class="svc-sec-head" data-reveal>
        <span class="svc-eyebrow">SYSTEM BLUEPRINT</span>
        <h2 class="svc-title">Every System Drawn Out Before a Line is Written</h2>
        <p class="svc-lead">
          We model data flows, state machines, and failover boundaries up front to avoid costly mid-project redesigns.
        </p>
      </div>

      <div class="svc-matrix-grid" style="grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));">
        <div class="svc-matrix-card" data-reveal style="--d:1">
          <div class="svc-card-img-wrap">
            <img src="<?= e(asset('assets/img/services-3d/svc-arch-01-api-gateway.jpg')) ?>" alt="Distributed API Gateway" loading="lazy">
          </div>
          <div class="svc-card-body">
            <h3 class="svc-card-title" style="font-size:1.15rem;">Distributed API Gateway</h3>
            <p class="svc-card-desc">Global routing mesh with intelligent rate limiting, protocol translation, and mutual TLS token verification.</p>
          </div>
        </div>

        <div class="svc-matrix-card" data-reveal style="--d:2">
          <div class="svc-card-img-wrap">
            <img src="<?= e(asset('assets/img/services-3d/svc-arch-02-streaming.jpg')) ?>" alt="Kafka Event Streaming" loading="lazy">
          </div>
          <div class="svc-card-body">
            <h3 class="svc-card-title" style="font-size:1.15rem;">Event-Driven Streaming</h3>
            <p class="svc-card-desc">Kafka and Flink pipelines delivering sub-10ms event processing for real-time stateful computation.</p>
          </div>
        </div>

        <div class="svc-matrix-card" data-reveal style="--d:3">
          <div class="svc-card-img-wrap">
            <img src="<?= e(asset('assets/img/services-3d/svc-arch-03-security.jpg')) ?>" alt="Zero-Trust Security Vault" loading="lazy">
          </div>
          <div class="svc-card-body">
            <h3 class="svc-card-title" style="font-size:1.15rem;">Zero-Trust Security Vault</h3>
            <p class="svc-card-desc">Hardware security module (HSM) key isolation, automated credential rotation, and continuous compliance telemetry.</p>
          </div>
        </div>

        <div class="svc-matrix-card" data-reveal style="--d:4">
          <div class="svc-card-img-wrap">
            <img src="<?= e(asset('assets/img/services-3d/svc-arch-04-observability.jpg')) ?>" alt="Nanosecond Observability" loading="lazy">
          </div>
          <div class="svc-card-body">
            <h3 class="svc-card-title" style="font-size:1.15rem;">Nanosecond Observability</h3>
            <p class="svc-card-desc">Distributed OpenTelemetry tracing and structured logging providing deep visibility into every microservice interaction.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- 4. How an Engagement Actually Runs (5 Images) -->
  <section class="svc-section">
    <div class="shell">
      <div class="svc-sec-head" data-reveal>
        <span class="svc-eyebrow">PROCESS PIPELINE</span>
        <h2 class="svc-title">How an Engagement Actually Runs</h2>
        <p class="svc-lead">
          Five transparent stages designed to eliminate surprises, align stakeholders, and ensure steady progress.
        </p>
      </div>

      <div class="svc-matrix-grid" style="grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));">
        <div class="svc-matrix-card" data-reveal style="--d:1">
          <div class="svc-card-img-wrap">
            <img src="<?= e(asset('assets/img/services-3d/svc-proc-01-discovery.jpg')) ?>" alt="Technical Discovery" loading="lazy">
          </div>
          <div class="svc-card-body">
            <span class="svc-card-group">PHASE 01</span>
            <h3 class="svc-card-title" style="font-size:1.1rem;">Technical Discovery</h3>
            <p class="svc-card-desc">Comprehensive system mapping, domain modeling, and concrete architectural agreements.</p>
          </div>
        </div>

        <div class="svc-matrix-card" data-reveal style="--d:2">
          <div class="svc-card-img-wrap">
            <img src="<?= e(asset('assets/img/services-3d/svc-proc-02-prototype.jpg')) ?>" alt="Rapid 3D Prototyping" loading="lazy">
          </div>
          <div class="svc-card-body">
            <span class="svc-card-group">PHASE 02</span>
            <h3 class="svc-card-title" style="font-size:1.1rem;">Rapid Prototyping</h3>
            <p class="svc-card-desc">Interactive prototype proving performance feasibility and critical user interaction flows.</p>
          </div>
        </div>

        <div class="svc-matrix-card" data-reveal style="--d:3">
          <div class="svc-card-img-wrap">
            <img src="<?= e(asset('assets/img/services-3d/svc-proc-03-sprint.jpg')) ?>" alt="High-Velocity Sprints" loading="lazy">
          </div>
          <div class="svc-card-body">
            <span class="svc-card-group">PHASE 03</span>
            <h3 class="svc-card-title" style="font-size:1.1rem;">Bi-Weekly Sprints</h3>
            <p class="svc-card-desc">Relentless code shipping with automated tests and working software demos every two weeks.</p>
          </div>
        </div>

        <div class="svc-matrix-card" data-reveal style="--d:4">
          <div class="svc-card-img-wrap">
            <img src="<?= e(asset('assets/img/services-3d/svc-proc-04-deployment.jpg')) ?>" alt="Zero-Downtime Release" loading="lazy">
          </div>
          <div class="svc-card-body">
            <span class="svc-card-group">PHASE 04</span>
            <h3 class="svc-card-title" style="font-size:1.1rem;">Zero-Downtime Deploy</h3>
            <p class="svc-card-desc">Canary rollout to production with automated health checks and instant rollback safety.</p>
          </div>
        </div>

        <div class="svc-matrix-card" data-reveal style="--d:5">
          <div class="svc-card-img-wrap">
            <img src="<?= e(asset('assets/img/services-3d/svc-proc-05-telemetry.jpg')) ?>" alt="24/7 System Telemetry" loading="lazy">
          </div>
          <div class="svc-card-body">
            <span class="svc-card-group">PHASE 05</span>
            <h3 class="svc-card-title" style="font-size:1.1rem;">Continuous Telemetry</h3>
            <p class="svc-card-desc">Real-time production auditing, error tracking, and SLA verification across cloud regions.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- 5. Three Engagement Models (3 Images) -->
  <section class="svc-section svc-section--panel">
    <div class="shell">
      <div class="svc-sec-head" data-reveal>
        <span class="svc-eyebrow">ENGAGEMENT MODELS</span>
        <h2 class="svc-title">Choose How We Work Together</h2>
        <p class="svc-lead">
          From turnkey milestone delivery to embedded pods and on-demand architecture advisory.
        </p>
      </div>

      <div class="svc-matrix-grid" style="grid-template-columns: repeat(auto-fit, minmax(340px, 1fr));">
        <div class="svc-matrix-card" data-reveal style="--d:1">
          <div class="svc-card-img-wrap">
            <img src="<?= e(asset('assets/img/services-3d/svc-eng-01-fixed.jpg')) ?>" alt="Fixed-Scope Commitments" loading="lazy">
          </div>
          <div class="svc-card-body">
            <h3 class="svc-card-title">Fixed-Scope Projects</h3>
            <p class="svc-card-desc">A defined scope, a firm budget, and a guaranteed ship date. Ideal for discrete platforms, rewrites, and MVPs.</p>
          </div>
        </div>

        <div class="svc-matrix-card" data-reveal style="--d:2">
          <div class="svc-card-img-wrap">
            <img src="<?= e(asset('assets/img/services-3d/svc-eng-02-squad.jpg')) ?>" alt="Dedicated Product Squad" loading="lazy">
          </div>
          <div class="svc-card-body">
            <h3 class="svc-card-title">Dedicated Squads</h3>
            <p class="svc-card-desc">An integrated team of senior product engineers who own your roadmap and ship daily production code.</p>
          </div>
        </div>

        <div class="svc-matrix-card" data-reveal style="--d:3">
          <div class="svc-card-img-wrap">
            <img src="<?= e(asset('assets/img/services-3d/svc-eng-03-advisory.jpg')) ?>" alt="Principal Advisory" loading="lazy">
          </div>
          <div class="svc-card-body">
            <h3 class="svc-card-title">Principal Advisory</h3>
            <p class="svc-card-desc">Direct access to principal architects for architecture reviews, performance profiling, and AI roadmaps.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- 6. Production Proof & Case Studies (3 Images) -->
  <section class="svc-section">
    <div class="shell">
      <div class="svc-sec-head" data-reveal>
        <span class="svc-eyebrow">PRODUCTION PROOF</span>
        <h2 class="svc-title">Built and Running at Scale</h2>
        <p class="svc-lead">
          Real platforms engineered for concurrency, handling millions of requests every day.
        </p>
      </div>

      <div class="svc-matrix-grid" style="grid-template-columns: repeat(auto-fit, minmax(340px, 1fr));">
        <div class="svc-matrix-card" data-reveal style="--d:1">
          <div class="svc-card-img-wrap">
            <img src="<?= e(asset('assets/img/services-3d/svc-case-01-fintech.jpg')) ?>" alt="Global Fintech Rails" loading="lazy">
          </div>
          <div class="svc-card-body">
            <h3 class="svc-card-title">Global Multi-Currency Rails</h3>
            <p class="svc-card-desc">Cross-border payment infrastructure with sub-5ms settlement and automatic currency reconciliation.</p>
          </div>
        </div>

        <div class="svc-matrix-card" data-reveal style="--d:2">
          <div class="svc-card-img-wrap">
            <img src="<?= e(asset('assets/img/services-3d/svc-case-02-telecom.jpg')) ?>" alt="10M+ Events Telecom Mesh" loading="lazy">
          </div>
          <div class="svc-card-body">
            <h3 class="svc-card-title">Autonomous Telecom Mesh</h3>
            <p class="svc-card-desc">Distributed event processing engine handling 10,000,000+ network events per second with zero drop.</p>
          </div>
        </div>

        <div class="svc-matrix-card" data-reveal style="--d:3">
          <div class="svc-card-img-wrap">
            <img src="<?= e(asset('assets/img/services-3d/svc-case-03-logistics.jpg')) ?>" alt="Intelligent Supply Chain" loading="lazy">
          </div>
          <div class="svc-card-body">
            <h3 class="svc-card-title">Intelligent Supply Chain</h3>
            <p class="svc-card-desc">Real-time telemetry and predictive inventory dispatch across nationwide warehouse networks.</p>
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
      'title'     => 'Bring us the workflow nobody wants to own.',
      'body'      => 'Tell us what is quietly costing your engineering team hours every week. Call +91 93845 64915 or write to info@ithrivesoftware.com.',
      'primary'   => ['label' => 'Start Your Project', 'href' => 'contact.php'],
      'secondary' => ['label' => 'Call: +91 93845 64915', 'href' => 'tel:+919384564915'],
  ]]);
  ?>
</div>

<?php
require __DIR__ . '/includes/footer.php';
