<?php
declare(strict_types=1);

$page         = 'company';
$hasOriginKit = true;
$pageTitle    = 'About — Perpetual Product Engineering Across 5 Indian Hubs';
$pageDesc  = 'iThrive Software is a premier product engineering firm building intelligent platforms in Python, Agentic AI, and Cloud Architecture across Chennai, Coimbatore, Bangalore, Hyderabad, and Ahmedabad.';

require_once dirname(__DIR__) . '/includes/config.php';

$extraHead = '<link rel="stylesheet" href="' . e(asset('assets/css/about-perpetualx.css')) . '">';

require dirname(__DIR__) . '/includes/header.php';
?>

<div class="px-page">
  <!-- 1. PerpetualX Hero Section with 3D Chromatic Logo -->
  <section class="px-hero">
    <div class="shell" style="text-align: center;">
      <div class="px-pill-badge" data-reveal>
        <span class="px-pill-dot"></span>
        <span class="px-pill-text">NEXT-GEN PRODUCT ENGINEERING ECOSYSTEM</span>
      </div>

      <h1 class="px-hero-title" data-reveal style="--d:1">
        Architecting the Continuous Intelligence Layer for Global Enterprise Platforms
      </h1>

      <p class="px-hero-lead" data-reveal style="--d:2">
        We design, build, and deploy mission-critical software systems in Python, Agentic AI, and Cloud Infrastructure. Operating across Chennai, Coimbatore, Bangalore, Hyderabad, and Ahmedabad.
      </p>

      <div class="px-hero-ctas" data-reveal style="--d:3">
        <a class="px-btn-primary" href="<?= e(url('contact.php')) ?>">
          Start Your Project <?= icon('arrow') ?>
        </a>
        <a class="px-btn-secondary" href="#hubs">
          Explore 5 Indian Hubs
        </a>
        <a class="px-btn-secondary" href="tel:+919384564915">
          Call: +91 93845 64915
        </a>
      </div>

      <!-- Authentic 3D Chromatic Brand Mark Hero (Interactive Three.js WebGL, Seamless Surface Blending) -->
      <div class="px-chromatic-hero-stage" data-reveal style="--d:4">
        <div data-ok="chromatic-logo"
             data-props='{
               "svgUrl": "<?= e(asset("assets/img/logo-mark-accurate.svg")) ?>",
               "autoRotate": true,
               "autoRotateSpeed": 0.45,
               "scale": 0.88,
               "extrudeDepth": 3.0,
               "bevelSize": 0.35,
               "bevelThickness": 0.8,
               "initialPreset": "animated",
               "showControls": true
             }'>
        </div>
      </div>

      <!-- Hero 4 Visual Telemetry Cards -->
      <div class="px-hero-visual-strip" data-reveal style="--d:5">
        <div class="px-visual-card">
          <img src="<?= e(asset('assets/img/about-3d/about-hero-01-vision.jpg')) ?>" alt="Global Neural Grid" loading="lazy">
          <div class="px-visual-info">
            <div class="px-visual-meta">CORE 01 // FOUNDATION</div>
            <div class="px-visual-title">Global Neural Grid</div>
          </div>
        </div>
        <div class="px-visual-card">
          <img src="<?= e(asset('assets/img/about-3d/about-hero-02-architecture.jpg')) ?>" alt="Distributed Cloud Fabric" loading="lazy">
          <div class="px-visual-info">
            <div class="px-visual-meta">CORE 02 // SCALE</div>
            <div class="px-visual-title">Distributed Cloud Fabric</div>
          </div>
        </div>
        <div class="px-visual-card">
          <img src="<?= e(asset('assets/img/about-3d/about-hero-03-telemetry.jpg')) ?>" alt="Real-Time Observability" loading="lazy">
          <div class="px-visual-info">
            <div class="px-visual-meta">CORE 03 // TELEMETRY</div>
            <div class="px-visual-title">Real-Time Observability</div>
          </div>
        </div>
        <div class="px-visual-card">
          <img src="<?= e(asset('assets/img/about-3d/about-hero-04-spatial.jpg')) ?>" alt="Spatial Interface Matrix" loading="lazy">
          <div class="px-visual-info">
            <div class="px-visual-meta">CORE 04 // INTERFACE</div>
            <div class="px-visual-title">Spatial Interface Matrix</div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- 2. Five Innovation Hubs Across India -->
  <section class="px-section" id="hubs">
    <div class="shell">
      <div class="px-sec-head" data-reveal>
        <span class="px-eyebrow">NATIONAL DELIVERY NETWORK</span>
        <h2 class="px-title">Five Specialized Innovation Hubs Across India</h2>
        <p class="px-lead">
          Deep regional engineering talent united into a single, high-velocity delivery mesh. Each hub anchors dedicated engineering disciplines with zero junior bench.
        </p>
      </div>

      <div class="px-hubs-grid">
        <!-- Hub 1: Chennai -->
        <div class="px-hub-card" data-reveal style="--d:1">
          <div class="px-hub-img-wrap">
            <img src="<?= e(asset('assets/img/about-3d/about-hub-01-chennai.jpg')) ?>" alt="Chennai Innovation Hub" loading="lazy">
            <span class="px-hub-tag">DEEP TECH & AI</span>
          </div>
          <div class="px-hub-body">
            <h3 class="px-hub-city">Chennai</h3>
            <p class="px-hub-role">Deep Tech, AI & OMR Digital Corridor</p>
            <p class="px-hub-desc">
              Anchored along Chennai’s Rajiv Gandhi Salai (OMR) tech expressway. Drives our proprietary Agentic AI swarms, custom LLM fine-tuning, and high-concurrency neural inference pipelines.
            </p>
            <div class="px-hub-tags">
              <span class="px-hub-pill">OMR Corridor</span>
              <span class="px-hub-pill">Agentic AI</span>
              <span class="px-hub-pill">Model Serving</span>
            </div>
          </div>
        </div>

        <!-- Hub 2: Coimbatore -->
        <div class="px-hub-card" data-reveal style="--d:2">
          <div class="px-hub-img-wrap">
            <img src="<?= e(asset('assets/img/about-3d/about-hub-02-coimbatore.jpg')) ?>" alt="Coimbatore R&D Campus" loading="lazy">
            <span class="px-hub-tag">PRODUCT ENGINEERING</span>
          </div>
          <div class="px-hub-body">
            <h3 class="px-hub-city">Coimbatore</h3>
            <p class="px-hub-role">Advanced Systems & Embedded Core</p>
            <p class="px-hub-desc">
              Our core product engineering foundry. Focuses on high-performance Python backends, Cython modules, asynchronous queuing with Celery/Redis, and robust enterprise software architectures.
            </p>
            <div class="px-hub-tags">
              <span class="px-hub-pill">Python Core</span>
              <span class="px-hub-pill">Cython</span>
              <span class="px-hub-pill">Async Architecture</span>
            </div>
          </div>
        </div>

        <!-- Hub 3: Bangalore -->
        <div class="px-hub-card" data-reveal style="--d:3">
          <div class="px-hub-img-wrap">
            <img src="<?= e(asset('assets/img/about-3d/about-hub-03-bangalore.jpg')) ?>" alt="Bangalore Cloud Lab" loading="lazy">
            <span class="px-hub-tag">CLOUD INFRASTRUCTURE</span>
          </div>
          <div class="px-hub-body">
            <h3 class="px-hub-city">Bangalore</h3>
            <p class="px-hub-role">Cloud Native & Microservices Scale</p>
            <p class="px-hub-desc">
              Situated in India’s premier Silicon Valley. Leads multi-cloud Kubernetes clustering, Terraform infrastructure-as-code, and microservices scaling for high-throughput global platforms.
            </p>
            <div class="px-hub-tags">
              <span class="px-hub-pill">Kubernetes</span>
              <span class="px-hub-pill">Multi-Cloud</span>
              <span class="px-hub-pill">Zero-Downtime</span>
            </div>
          </div>
        </div>

        <!-- Hub 4: Hyderabad -->
        <div class="px-hub-card" data-reveal style="--d:4">
          <div class="px-hub-img-wrap">
            <img src="<?= e(asset('assets/img/about-3d/about-hub-04-hyderabad.jpg')) ?>" alt="Hyderabad Data Vault" loading="lazy">
            <span class="px-hub-tag">SECURITY & DATA</span>
          </div>
          <div class="px-hub-body">
            <h3 class="px-hub-city">Hyderabad</h3>
            <p class="px-hub-role">Enterprise Distributed Data & Cyber Shield</p>
            <p class="px-hub-desc">
              Specialized in Zero-Trust security architectures, Hardware Security Module (HSM) integrations, real-time Kafka event streaming, and SOC2/HIPAA compliance engineering.
            </p>
            <div class="px-hub-tags">
              <span class="px-hub-pill">Zero Trust</span>
              <span class="px-hub-pill">Kafka Streaming</span>
              <span class="px-hub-pill">HSM Vaults</span>
            </div>
          </div>
        </div>

        <!-- Hub 5: Ahmedabad -->
        <div class="px-hub-card" data-reveal style="--d:5">
          <div class="px-hub-img-wrap">
            <img src="<?= e(asset('assets/img/about-3d/about-hub-05-ahmedabad.jpg')) ?>" alt="Ahmedabad Fintech Tower" loading="lazy">
            <span class="px-hub-tag">FINTECH & COMMERCE</span>
          </div>
          <div class="px-hub-body">
            <h3 class="px-hub-city">Ahmedabad</h3>
            <p class="px-hub-role">High-Frequency Rails & Cross-Border Transacting</p>
            <p class="px-hub-desc">
              Engineers enterprise commerce platforms, cross-border settlement rails (UPI, Stripe, Swift), algorithmic transaction routing, and large-scale B2B supply chain engines.
            </p>
            <div class="px-hub-tags">
              <span class="px-hub-pill">Fintech Rails</span>
              <span class="px-hub-pill">Global Commerce</span>
              <span class="px-hub-pill">Sub-5ms Clearing</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Contact & Direct Connect Banner -->
      <div class="px-contact-strip" data-reveal>
        <div class="px-contact-details">
          <div class="px-contact-item">
            <span class="px-contact-label">Direct Phone Line</span>
            <a class="px-contact-value" href="tel:+919384564915">+91 93845 64915</a>
          </div>
          <div class="px-contact-item">
            <span class="px-contact-label">Official Correspondence</span>
            <a class="px-contact-value" href="mailto:info@ithrivesoftware.com">info@ithrivesoftware.com</a>
          </div>
          <div class="px-contact-item">
            <span class="px-contact-label">Headquartered Hubs</span>
            <span class="px-contact-value" style="font-size:1.1rem;color:#E2E8F0;">
              Chennai · Coimbatore · Bangalore · Hyderabad · Ahmedabad
            </span>
          </div>
        </div>
        <a class="px-btn-primary" href="<?= e(url('contact.php')) ?>">
          Schedule Technical Call <?= icon('arrow') ?>
        </a>
      </div>
    </div>
  </section>

  <!-- 3. Engineering Disciplines & Capabilities (6 Cards) -->
  <section class="px-section px-section--panel">
    <div class="shell">
      <div class="px-sec-head" data-reveal>
        <span class="px-eyebrow">ENGINEERING CAPABILITIES</span>
        <h2 class="px-title">Precision Product Engineering Built for Concurrency</h2>
        <p class="px-lead">
          Every architecture is engineered from the ground up to run reliably under heavy enterprise load with sub-second latency.
        </p>
      </div>

      <div class="px-grid-6">
        <div class="px-cap-card" data-reveal style="--d:1">
          <img src="<?= e(asset('assets/img/about-3d/about-cap-01-agentic-ai.jpg')) ?>" alt="Autonomous Agent Swarms" loading="lazy">
          <div class="px-cap-content">
            <span class="px-cap-num">DISCIPLINE 01</span>
            <h3 class="px-cap-title">Autonomous Agent Swarms</h3>
            <p class="px-cap-body">Multi-agent orchestrations with LangGraph and AutoGen capable of planning, executing, and self-correcting multi-step workflows without human bottlenecks.</p>
          </div>
        </div>

        <div class="px-cap-card" data-reveal style="--d:2">
          <img src="<?= e(asset('assets/img/about-3d/about-cap-02-python-core.jpg')) ?>" alt="High-Concurrency Python" loading="lazy">
          <div class="px-cap-content">
            <span class="px-cap-num">DISCIPLINE 02</span>
            <h3 class="px-cap-title">High-Concurrency Python</h3>
            <p class="px-cap-body">FastAPI, Cython, uvloop, and async workers engineered to sustain 50,000+ requests per second on minimal cloud footprint.</p>
          </div>
        </div>

        <div class="px-cap-card" data-reveal style="--d:3">
          <img src="<?= e(asset('assets/img/about-3d/about-cap-03-cloud-mesh.jpg')) ?>" alt="Terraform & Hybrid Cloud" loading="lazy">
          <div class="px-cap-content">
            <span class="px-cap-num">DISCIPLINE 03</span>
            <h3 class="px-cap-title">Terraform & Hybrid Cloud</h3>
            <p class="px-cap-body">Immutable declarative infrastructure across AWS, GCP, and Azure with automated failovers and ephemeral preview environments.</p>
          </div>
        </div>

        <div class="px-cap-card" data-reveal style="--d:4">
          <img src="<?= e(asset('assets/img/about-3d/about-cap-04-realtime-data.jpg')) ?>" alt="Event-Driven Streaming" loading="lazy">
          <div class="px-cap-content">
            <span class="px-cap-num">DISCIPLINE 04</span>
            <h3 class="px-cap-title">Event-Driven Streaming</h3>
            <p class="px-cap-body">Apache Kafka, Apache Flink, and Redis streams delivering sub-10 millisecond event processing for algorithmic workloads.</p>
          </div>
        </div>

        <div class="px-cap-card" data-reveal style="--d:5">
          <img src="<?= e(asset('assets/img/about-3d/about-cap-05-zero-trust.jpg')) ?>" alt="Zero-Trust Cryptography" loading="lazy">
          <div class="px-cap-content">
            <span class="px-cap-num">DISCIPLINE 05</span>
            <h3 class="px-cap-title">Zero-Trust Cryptography</h3>
            <p class="px-cap-body">Hardware security enclave signing, mutual TLS (mTLS), and strict role-based tokenization protecting sensitive enterprise data.</p>
          </div>
        </div>

        <div class="px-cap-card" data-reveal style="--d:6">
          <img src="<?= e(asset('assets/img/about-3d/about-cap-06-ui-systems.jpg')) ?>" alt="Spatial UI/UX Systems" loading="lazy">
          <div class="px-cap-content">
            <span class="px-cap-num">DISCIPLINE 06</span>
            <h3 class="px-cap-title">Spatial UI/UX Systems</h3>
            <p class="px-cap-body">Fluid 60FPS interfaces powered by Three.js, WebGL shaders, React 19, and rigorous design tokens designed for dense information displays.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- 4. Four Core Commitments (4 Cards) -->
  <section class="px-section">
    <div class="shell">
      <div class="px-sec-head" data-reveal>
        <span class="px-eyebrow">HOW WE OPERATE</span>
        <h2 class="px-title">Four Commitments We Will Be Held To</h2>
        <p class="px-lead">
          We operate as true engineering partners. These four pillars govern every engagement from sprint kickoff to production release.
        </p>
      </div>

      <div class="px-grid-4">
        <div class="px-commit-card" data-reveal style="--d:1">
          <img src="<?= e(asset('assets/img/about-3d/about-val-01-craft.jpg')) ?>" alt="Engineering Craftsmanship" loading="lazy">
          <div class="px-commit-body">
            <h3 class="px-commit-title">Engineering Craftsmanship</h3>
            <p class="px-commit-desc">Zero code smells, 100% strict typing, and comprehensive automated test suites run before every single pull request merges.</p>
          </div>
        </div>

        <div class="px-commit-card" data-reveal style="--d:2">
          <img src="<?= e(asset('assets/img/about-3d/about-val-02-transparency.jpg')) ?>" alt="Radical Transparency" loading="lazy">
          <div class="px-commit-body">
            <h3 class="px-commit-title">Radical Transparency</h3>
            <p class="px-commit-desc">Direct access to live Git branches, deployment logs, and real-time observability telemetry. No hidden work, no vanity metrics.</p>
          </div>
        </div>

        <div class="px-commit-card" data-reveal style="--d:3">
          <img src="<?= e(asset('assets/img/about-3d/about-val-03-ownership.jpg')) ?>" alt="Principal Ownership" loading="lazy">
          <div class="px-commit-body">
            <h3 class="px-commit-title">Principal Ownership</h3>
            <p class="px-commit-desc">Senior product architects who write and review production code daily. We do not bill for senior names and delegate to junior benches.</p>
          </div>
        </div>

        <div class="px-commit-card" data-reveal style="--d:4">
          <img src="<?= e(asset('assets/img/about-3d/about-val-04-velocity.jpg')) ?>" alt="Relentless Velocity" loading="lazy">
          <div class="px-commit-body">
            <h3 class="px-commit-title">Relentless Velocity</h3>
            <p class="px-commit-desc">Continuous deployment pipelines that deliver working, tested software features to staging and production environments every 24 hours.</p>
          </div>
        </div>
      </div>

      <div style="margin-top:56px" data-reveal>
        <?php component('stats-band', ['stats' => ABOUT_STATS]); ?>
      </div>
    </div>
  </section>

  <!-- 5. Technical Leadership & Council (4 Cards) -->
  <section class="px-section px-section--panel">
    <div class="shell">
      <div class="px-sec-head" data-reveal>
        <span class="px-eyebrow">ENGINEERING LEADERSHIP</span>
        <h2 class="px-title">Senior Product Engineers Only — Zero Junior Bench</h2>
        <p class="px-lead">
          Our squads are led by principal engineers with deep experience across distributed systems, kernel tuning, and production AI architectures.
        </p>
      </div>

      <div class="px-team-grid">
        <div class="px-team-card" data-reveal style="--d:1">
          <img src="<?= e(asset('assets/img/about-3d/about-team-01-principal-arch.jpg')) ?>" alt="Systems Architecture Council" loading="lazy">
          <div class="px-team-body">
            <span class="px-team-role">PRINCIPAL COUNCIL</span>
            <h3 class="px-team-name">Systems Architecture</h3>
            <p class="px-team-desc">Audits distributed data models, caching layers, and high-concurrency protocols across all enterprise projects.</p>
          </div>
        </div>

        <div class="px-team-card" data-reveal style="--d:2">
          <img src="<?= e(asset('assets/img/about-3d/about-team-02-ai-research.jpg')) ?>" alt="Neural Optimization Squad" loading="lazy">
          <div class="px-team-body">
            <span class="px-team-role">AI RESEARCH</span>
            <h3 class="px-team-name">Neural Optimization</h3>
            <p class="px-team-desc">Focuses on model fine-tuning, tensor quantization (GGUF/AWQ), and vector database clustering for low latency.</p>
          </div>
        </div>

        <div class="px-team-card" data-reveal style="--d:3">
          <img src="<?= e(asset('assets/img/about-3d/about-team-03-cloud-ops.jpg')) ?>" alt="Distributed Reliability SRE" loading="lazy">
          <div class="px-team-body">
            <span class="px-team-role">SRE & DEVOPS</span>
            <h3 class="px-team-name">Distributed Reliability</h3>
            <p class="px-team-desc">Maintains 99.99% uptime guarantees through automated chaos testing, multi-region failover, and zero-trust mesh.</p>
          </div>
        </div>

        <div class="px-team-card" data-reveal style="--d:4">
          <img src="<?= e(asset('assets/img/about-3d/about-team-04-spatial-lab.jpg')) ?>" alt="Next-Gen Interface Lab" loading="lazy">
          <div class="px-team-body">
            <span class="px-team-role">CREATIVE COMPUTE</span>
            <h3 class="px-team-name">Next-Gen Interface Lab</h3>
            <p class="px-team-desc">Engineers real-time WebGL/WebGPU shaders, Framer motion physics, and tactile interaction design.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- 6. Production Proof & Case Studies (4 Cards) -->
  <section class="px-section">
    <div class="shell">
      <div class="px-sec-head" data-reveal>
        <span class="px-eyebrow">THE WORK</span>
        <h2 class="px-title">Judge Us on What is Running in Production</h2>
        <p class="px-lead">
          Real enterprise platforms deployed and tested under extreme production conditions.
        </p>
      </div>

      <div class="px-grid-4">
        <div class="px-commit-card" data-reveal style="--d:1">
          <img src="<?= e(asset('assets/img/about-3d/about-case-01-telecom.jpg')) ?>" alt="Global Telecom Mesh" loading="lazy">
          <div class="px-commit-body">
            <h3 class="px-commit-title">Global Telecom Mesh</h3>
            <p class="px-commit-desc">Processes 10,000,000+ events per second with automated anomaly detection and sub-10ms alerting.</p>
          </div>
        </div>

        <div class="px-commit-card" data-reveal style="--d:2">
          <img src="<?= e(asset('assets/img/about-3d/about-case-02-fintech.jpg')) ?>" alt="Ultra-Fast Settlement" loading="lazy">
          <div class="px-commit-body">
            <h3 class="px-commit-title">Ultra-Fast Settlement Rails</h3>
            <p class="px-commit-desc">Cross-border multi-currency clearing engine with sub-5ms transaction latency and zero-reconciliation errors.</p>
          </div>
        </div>

        <div class="px-commit-card" data-reveal style="--d:3">
          <img src="<?= e(asset('assets/img/about-3d/about-case-03-healthtech.jpg')) ?>" alt="Neural Health Platform" loading="lazy">
          <div class="px-commit-body">
            <h3 class="px-commit-title">Neural Health Platform</h3>
            <p class="px-commit-desc">HIPAA-compliant distributed medical imaging diagnostic mesh serving over 250+ enterprise hospital networks.</p>
          </div>
        </div>

        <div class="px-commit-card" data-reveal style="--d:4">
          <img src="<?= e(asset('assets/img/about-3d/about-case-04-supplychain.jpg')) ?>" alt="Autonomous Supply Chain" loading="lazy">
          <div class="px-commit-body">
            <h3 class="px-commit-title">Autonomous Supply Chain</h3>
            <p class="px-commit-desc">Real-time GPS fleet telemetry and predictive warehouse dispatch handling 500,000 packages daily.</p>
          </div>
        </div>
      </div>

      <div class="section-foot" data-reveal style="text-align: center; margin-top: 40px;">
        <a class="btn btn-ghost" href="<?= e(url('case-studies.php')) ?>">All Case Studies <?= icon('arrow') ?></a>
      </div>
    </div>
  </section>

  <!-- 7. Future Labs & R&D (3 Cards) -->
  <section class="px-section px-section--panel">
    <div class="shell">
      <div class="px-sec-head" data-reveal>
        <span class="px-eyebrow">INNOVATION LABS</span>
        <h2 class="px-title">Pioneering the Next Frontier of Digital Infrastructure</h2>
        <p class="px-lead">
          Continuous research in post-quantum security, self-healing networks, and ultra-quantized edge intelligence.
        </p>
      </div>

      <div class="px-grid-4" style="grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));">
        <div class="px-commit-card" data-reveal style="--d:1">
          <img src="<?= e(asset('assets/img/about-3d/about-lab-01-quantum.jpg')) ?>" alt="Post-Quantum Cryptography" loading="lazy">
          <div class="px-commit-body">
            <h3 class="px-commit-title">Post-Quantum Cryptography</h3>
            <p class="px-commit-desc">Lattice-based encryption and quantum-resistant key exchange algorithms embedded into cloud transport layers.</p>
          </div>
        </div>

        <div class="px-commit-card" data-reveal style="--d:2">
          <img src="<?= e(asset('assets/img/about-3d/about-lab-02-autonomous.jpg')) ?>" alt="Self-Healing Cloud Clusters" loading="lazy">
          <div class="px-commit-body">
            <h3 class="px-commit-title">Self-Healing Cloud Clusters</h3>
            <p class="px-commit-desc">Agentic Kubernetes controllers that diagnose container anomalies and rebalance compute nodes autonomously.</p>
          </div>
        </div>

        <div class="px-commit-card" data-reveal style="--d:3">
          <img src="<?= e(asset('assets/img/about-3d/about-lab-03-edge-ai.jpg')) ?>" alt="Edge Tensor Acceleration" loading="lazy">
          <div class="px-commit-body">
            <h3 class="px-commit-title">Edge Tensor Acceleration</h3>
            <p class="px-commit-desc">Ultra-compact 2-bit quantized neural networks optimized for local on-device hardware accelerators.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- 8. Testimonials Section -->
  <section class="px-section">
    <div class="shell">
      <div class="px-sec-head" data-reveal>
        <span class="px-eyebrow">CLIENT VOICES</span>
        <h2 class="px-title">What the People Who Signed Off Say</h2>
        <p class="px-lead">Direct feedback from CTOs, Founders, and Engineering Leaders who built with us.</p>
      </div>
      <?php component('testimonial-slider'); ?>
    </div>
  </section>

  <!-- 9. PerpetualX Call to Action -->
  <?php
  component('cta', ['cta' => [
      'eyebrow'   => 'Start Your Project',
      'title'     => 'Bring us the workflow nobody wants to own.',
      'body'      => 'Our senior engineering squads in Chennai, Coimbatore, Bangalore, Hyderabad, and Ahmedabad are ready to deploy. Reach out directly or call +91 93845 64915.',
      'primary'   => ['label' => 'Start Your Project', 'href' => 'contact.php'],
      'secondary' => ['label' => 'Call: +91 93845 64915', 'href' => 'tel:+919384564915'],
  ]]);
  ?>
</div>

<script>
(function() {
  const stage = document.getElementById('aboutLogoStage');
  if (!stage) return;
  const emblem = stage.querySelector('.px-original-logo-emblem');
  let bounds = null;
  let rafId = null;

  function updateBounds() {
    bounds = stage.getBoundingClientRect();
  }

  window.addEventListener('resize', updateBounds, { passive: true });
  window.addEventListener('scroll', updateBounds, { passive: true });

  stage.addEventListener('mouseenter', () => {
    updateBounds();
  });

  stage.addEventListener('mousemove', (e) => {
    if (!bounds) updateBounds();
    const x = e.clientX - bounds.left;
    const y = e.clientY - bounds.top;
    const px = (x / bounds.width - 0.5) * 2;
    const py = (y / bounds.height - 0.5) * 2;

    if (rafId) cancelAnimationFrame(rafId);
    rafId = requestAnimationFrame(() => {
      const rotY = px * 22;
      const rotX = -py * 20;
      const tz = 28;
      if (emblem) {
        emblem.style.transform = `rotateX(${rotX.toFixed(2)}deg) rotateY(${rotY.toFixed(2)}deg) translateZ(${tz}px)`;
      }
    });
  });

  stage.addEventListener('mouseleave', () => {
    if (rafId) cancelAnimationFrame(rafId);
    if (emblem) {
      emblem.style.transform = 'rotateX(0deg) rotateY(0deg) translateZ(0px)';
    }
  });
})();
</script>

<?php
require dirname(__DIR__) . '/includes/footer.php';
