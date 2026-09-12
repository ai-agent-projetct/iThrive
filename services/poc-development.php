<?php
/**
 * PoC Development — with Spline & MotionSites Inspired 3D WebGL Engine & 30 New Photographic Images
 * Built with OriginKit, Three.js 3D Gimbal Stage, and 3D Tilt Cards
 */

declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/config.php';

$svc = service('poc-development');

$page      = 'services';
$bodyClass = 'poc-3d-body';
$hasOriginKit = true;
$pageTitle = 'PoC Development Company in Chennai & Global Delivery Hubs — 3D Verification Engine';
$pageDesc  = 'iThrive Software builds proofs of concept in two to four weeks — one question, one numeric threshold, and an honest answer before budget is committed.';
$ogImage   = 'service-' . $svc['group_slug'];

/* ---------------------------------------------------------------------------
 * Content: 30 Dedicated Photographic Image Assets in assets/img/poc-3d/
 * ------------------------------------------------------------------------ */

/** 1. The 6 3D Verification Cards in the Hero Cylinder Stage */
$heroFaces = [
    [
        'id'       => 'VERIFY-01',
        'question' => 'Can the data carry it?',
        'sub'      => 'High-throughput data ingestion pipelines benchmarked for zero packet drops.',
        'img'      => 'assets/img/poc-3d/poc-01-data-pipeline.jpg',
        'tag'      => 'DATA STREAM',
        'verdict'  => 'PASS // 120MB/s',
    ],
    [
        'id'       => 'VERIFY-02',
        'question' => 'Will the model hold at load?',
        'sub'      => 'Stress-testing LLMs and neural models under 10,000 concurrent streaming inference requests.',
        'img'      => 'assets/img/poc-3d/poc-02-model-load.jpg',
        'tag'      => 'AI INFERENCE',
        'verdict'  => 'PASS // 18ms SLA',
    ],
    [
        'id'       => 'VERIFY-03',
        'question' => 'Does the integration exist?',
        'sub'      => 'Proving bi-directional ERP, CRM, and banking API connectivity before committing architecture.',
        'img'      => 'assets/img/poc-3d/poc-03-integration.jpg',
        'tag'      => 'API TOPOLOGY',
        'verdict'  => 'PASS // < 24ms',
    ],
    [
        'id'       => 'VERIFY-04',
        'question' => 'Is the latency survivable?',
        'sub'      => 'Sub-15ms edge network execution tested under simulated real-world network packet loss.',
        'img'      => 'assets/img/poc-3d/poc-04-latency.jpg',
        'tag'      => 'EDGE LATENCY',
        'verdict'  => 'PASS // 14.8ms',
    ],
    [
        'id'       => 'VERIFY-05',
        'question' => 'What does it cost per call?',
        'sub'      => 'Calculating exact GPU token unit economics to ensure commercial sustainability at scale.',
        'img'      => 'assets/img/poc-3d/poc-05-cost-calc.jpg',
        'tag'      => 'UNIT ECONOMICS',
        'verdict'  => 'PASS // $0.00042',
    ],
    [
        'id'       => 'VERIFY-06',
        'question' => 'Should this be built at all?',
        'sub'      => 'Empirical go/no-go recommendation backed by hard laboratory telemetry and user metrics.',
        'img'      => 'assets/img/poc-3d/poc-06-verdict.jpg',
        'tag'      => 'DECISION GATE',
        'verdict'  => 'GO // 99.8% CONF',
    ],
];

$stats = [
    ['2–4', 'Weeks, question to verdict'],
    ['1', 'Question per proof'],
    ['100%', 'Findings written down'],
    ['~8%', 'Of a full build budget'],
];

/** 2. Why Starting With a Proof Changes Everything (4 Cards) */
$whyFirst = [
    [
        'num'   => '01',
        'title' => 'Risk Found in Week One',
        'desc'  => 'Feasibility problems are cheapest on the day they are discovered and most expensive the week before launch. A proof drags them to the front.',
        'img'   => 'assets/img/poc-3d/poc-07-early-risk.jpg',
        'badge' => 'DE-RISK',
    ],
    [
        'num'   => '02',
        'title' => 'Capital Protected from Rewrites',
        'desc'  => 'A proof costs a fraction of the build it protects. The ones that come back negative save hundreds of thousands in discarded engineering hours.',
        'img'   => 'assets/img/poc-3d/poc-08-capital-saved.jpg',
        'badge' => 'COST CONTROL',
    ],
    [
        'num'   => '03',
        'title' => 'Confidence Stakeholders Can Touch',
        'desc'  => 'A working artifact ends a debate that a presentation cannot. Boards, enterprise buyers, and developers all believe the same running software.',
        'img'   => 'assets/img/poc-3d/poc-09-working-proof.jpg',
        'badge' => 'EVIDENCE',
    ],
    [
        'num'   => '04',
        'title' => 'Built Small & Surgically Focused',
        'desc'  => 'Only the core assumptions carry risk. Everything else is stubbed cleanly so you learn the truth without vanity padding.',
        'img'   => 'assets/img/poc-3d/poc-10-small-test.jpg',
        'badge' => 'FOCUS',
    ],
];

/** 3. Eight Core Deliverables of Every Proof (8 Cards) */
$inside = [
    [
        'num'   => '01',
        'title' => 'Feasibility Assessment',
        'desc'  => 'Your concept is benchmarked against technical viability, data readiness, and unit economics before a line of production code is written.',
        'img'   => 'assets/img/poc-3d/poc-11-feasibility.jpg',
        'badge' => 'DELIVERABLE 01',
    ],
    [
        'num'   => '02',
        'title' => 'Architecture & Approach',
        'desc'  => 'The shape the real system would take is drawn now, so a positive proof leads directly into an MVP rather than a total rewrite.',
        'img'   => 'assets/img/poc-3d/poc-12-arch-approach.jpg',
        'badge' => 'DELIVERABLE 02',
    ],
    [
        'num'   => '03',
        'title' => 'Technical Risk Register',
        'desc'  => 'The components most likely to break the build are named, ranked, and each given a cheap, quantifiable test gate.',
        'img'   => 'assets/img/poc-3d/poc-13-risk-register.jpg',
        'badge' => 'DELIVERABLE 03',
    ],
    [
        'num'   => '04',
        'title' => 'Rapid Build of the Core',
        'desc'  => 'Only the part of the idea that carries systemic risk gets compiled. Peripheral administration and styling are set aside.',
        'img'   => 'assets/img/poc-3d/poc-14-rapid-build.jpg',
        'badge' => 'DELIVERABLE 04',
    ],
    [
        'num'   => '05',
        'title' => 'Backend Workflow Validation',
        'desc'  => 'Logic and data flows are executed end-to-end under synthetic load, because the engine is where promising concepts usually fail.',
        'img'   => 'assets/img/poc-3d/poc-15-workflow-val.jpg',
        'badge' => 'DELIVERABLE 05',
    ],
    [
        'num'   => '06',
        'title' => 'API & Integration Testing',
        'desc'  => 'Every external system you must connect to is exercised for real. "There is an API" and "the API works under load" are different findings.',
        'img'   => 'assets/img/poc-3d/poc-16-api-test.jpg',
        'badge' => 'DELIVERABLE 06',
    ],
    [
        'num'   => '07',
        'title' => 'Demo-Ready Delivery',
        'desc'  => 'The proof is packaged into an interactive build you can demo to a board, customer, or investor without having to apologize for it.',
        'img'   => 'assets/img/poc-3d/poc-17-demo-delivery.jpg',
        'badge' => 'DELIVERABLE 07',
    ],
    [
        'num'   => '08',
        'title' => 'MVP Roadmap & Costing',
        'desc'  => 'What was learned becomes a scoped production roadmap with fixed numbers — what to build, what to drop, and exact delivery milestones.',
        'img'   => 'assets/img/poc-3d/poc-18-mvp-roadmap.jpg',
        'badge' => 'DELIVERABLE 08',
    ],
];

/** 4. Five-Step Engagement Process (5 Steps) */
$steps = [
    [
        'num'   => '01',
        'title' => 'Discovery Call',
        'text'  => 'Thirty minutes. You describe the idea and constraints; we say plainly whether a proof is the right instrument, and what it must answer.',
        'img'   => 'assets/img/poc-3d/poc-19-discovery.jpg',
    ],
    [
        'num'   => '02',
        'title' => 'The Question, in Writing',
        'text'  => 'We declare one question, one numeric threshold that counts as a yes, a fixed scope, and a fixed price before any build commences.',
        'img'   => 'assets/img/poc-3d/poc-20-hypothesis.jpg',
    ],
    [
        'num'   => '03',
        'title' => 'Build the Smallest Test',
        'text'  => 'Two to four weeks focused on the risky component only. You inspect running software each week, never abstract slide decks.',
        'img'   => 'assets/img/poc-3d/poc-21-sprint-build.jpg',
    ],
    [
        'num'   => '04',
        'title' => 'Verdict & Roadmap',
        'text'  => 'A working proof, the empirical telemetry it produced, and an honest verdict — including when the recommendation is not to proceed.',
        'img'   => 'assets/img/poc-3d/poc-22-verdict-report.jpg',
    ],
    [
        'num'   => '05',
        'title' => 'Your Call, Your Code',
        'text'  => 'Proceed to an MVP with us, hand it to your internal squads, or use it to raise capital. Full Git repository and IP are yours on day one.',
        'img'   => 'assets/img/poc-3d/poc-23-code-handover.jpg',
    ],
];

/** 5. Industry Proof Domains (4 Sectors) */
$sectors = [
    [
        'num'   => '01',
        'title' => 'FinTech & Algorithmic Rails',
        'desc'  => 'Real-time anomaly detection, sub-millisecond payment settlement, and compliance verification models under live financial market feeds.',
        'img'   => 'assets/img/poc-3d/poc-24-fintech-proof.jpg',
        'badge' => 'FINTECH',
    ],
    [
        'num'   => '02',
        'title' => 'Healthcare & Clinical Telemetry',
        'desc'  => 'HIPAA-compliant patient diagnostic pipelines, encrypted WebRTC telemedicine sessions, and clinical document AI extraction.',
        'img'   => 'assets/img/poc-3d/poc-25-health-proof.jpg',
        'badge' => 'HEALTHCARE',
    ],
    [
        'num'   => '03',
        'title' => 'Logistics & Fleet Optimization',
        'desc'  => 'Multi-depot route dispatch engines, real-time vehicle telemetry models, and automated warehouse inventory allocation algorithms.',
        'img'   => 'assets/img/poc-3d/poc-26-logistics-proof.jpg',
        'badge' => 'LOGISTICS',
    ],
    [
        'num'   => '04',
        'title' => 'High-Volume Headless Commerce',
        'desc'  => 'Sub-400ms biometric checkout funnels, AI visual search merchandising, and real-time inventory reservation under high traffic.',
        'img'   => 'assets/img/poc-3d/poc-27-commerce-proof.jpg',
        'badge' => 'COMMERCE',
    ],
];

/** 6. Production Benchmarks & Stress Tests (3 Benchmarks) */
$benchmarks = [
    [
        'num'   => '01',
        'title' => 'Edge AI Neural Inference',
        'desc'  => 'Demonstrated 14.2ms model response time on edge hardware accelerators with zero cloud roundtrip dependency.',
        'img'   => 'assets/img/poc-3d/poc-28-benchmark-edge.jpg',
        'badge' => '14.2ms INFERENCE',
    ],
    [
        'num'   => '02',
        'title' => 'Zero-Trust Cryptographic Handshake',
        'desc'  => 'Zero-knowledge proof authentication passing automated penetration testing with 100% cryptographic integrity.',
        'img'   => 'assets/img/poc-3d/poc-29-benchmark-auth.jpg',
        'badge' => '0 VULNERABILITIES',
    ],
    [
        'num'   => '03',
        'title' => 'High-Concurrency Event Pipeline',
        'desc'  => 'Validated 100,000 messages per second sustained throughput across distributed microservices with zero queue drop.',
        'img'   => 'assets/img/poc-3d/poc-30-benchmark-scale.jpg',
        'badge' => '100K MSG/SEC',
    ],
];

$faqs = [
    [
        'What does a proof of concept cost, and what moves the number?',
        'Most sit between two and four weeks of a focused squad, which is roughly eight per cent of the build it is protecting. What moves it is the number of live enterprise systems we must integrate with, whether usable data already exists, and whether a custom model must be trained. You get a fixed price against a fixed question before anything starts.'
    ],
    [
        'What should a PoC actually include?',
        'The risky part and nothing else. One question, the smallest software that can answer it, real data wherever it exists, and the empirical measurement written down. Auxiliary admin screens and cosmetic polish are deliberately absent — putting them in is how a proof quietly turns into a slow first build.'
    ],
    [
        'How do I know whether my idea needs a proof at all?',
        'If you can name a specific technical or unit-economic assumption that would sink the project if false, and nobody can currently prove it, that is a proof. If the question is whether customers want it, you want an MVP in front of users instead, and we will advise you so.'
    ],
    [
        'Does a proof speed up the subsequent MVP?',
        'Yes, and mostly by subtraction. The core architecture is already tested, the third-party integrations are known quantities, and assumptions that failed have been eliminated before anyone paid to build them into production.'
    ],
];

$extraHead = '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>'
    . '<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;600;700&family=Space+Grotesk:wght@400;500;600;700&display=swap">'
    . '<link rel="stylesheet" href="' . e(asset('assets/css/poc.css')) . '">'
    . '<link rel="stylesheet" href="' . e(asset('assets/css/poc-3d.css')) . '">'
    . '<script type="module" src="' . e(asset('assets/js/liquid-sphere.js')) . '"></script>'
    . '<script type="module" src="' . e(asset('assets/js/poc-3d-stage.js')) . '"></script>'
    . '<script type="module" src="' . e(asset('assets/js/smooth-image-cursor.js')) . '"></script>';

require dirname(__DIR__) . '/includes/header.php';
?>

<div class="poc-3d-page">

  <!-- 1. Hero Section with Smooth Image Cursor & OriginKit Liquid Sphere Stage (Split Layout) -->
  <section class="poc-hero-3d-section" id="poc-cursor-hero">
    <div class="shell" style="position: relative; z-index: 5;">
      <div class="poc-hero-split-grid">

        <!-- Left Column: Content, CTAs, Numeric Gates -->
        <div class="poc-hero-content-col">
          <div class="poc-pill-badge" data-reveal>
            <span class="poc-pill-dot"></span>
            <span class="poc-pill-text">POC DEVELOPMENT // 2–4 WEEK FEASIBILITY &amp; VALIDATION ENGINE</span>
          </div>

          <h1 class="poc-hero-title" data-reveal style="--d:1">
            PoC Development Services<br>
            <em>Prove It in 2–4 Weeks Before You Pay to Build</em>
          </h1>

          <p class="poc-hero-lead" data-reveal style="--d:2">
            A Proof of Concept (PoC) is not a miniature product. It is one critical question, one numeric threshold that counts as a yes, and permission to come back negative. Delivered by our specialized PoC engineering squads across Chennai, Coimbatore, Bangalore, Hyderabad, and Ahmedabad to de-risk your roadmap and protect capital.
          </p>

          <div class="poc-hero-ctas" data-reveal style="--d:3">
            <a class="poc-btn-primary" href="<?= e(url('contact.php')) ?>">
              Book 30-Min Discovery <?= icon('arrow') ?>
            </a>
            <a class="poc-btn-secondary" href="#deliverables">
              Explore Deliverables
            </a>
            <a class="poc-btn-secondary" href="tel:+919384564915">
              Call: +91 93845 64915
            </a>
          </div>

          <!-- 4 Numeric Proof Metric Gates (2x2 Grid) -->
          <div class="poc-hero-stats-grid" data-reveal style="--d:4">
            <div style="background:rgba(13,19,32,0.85);border:1px solid rgba(0,242,254,0.35);border-radius:14px;padding:18px 16px;box-shadow:0 10px 25px rgba(0,0,0,0.5);backdrop-filter:blur(8px);">
              <div style="font-family:'Space Grotesk',sans-serif;font-size:2rem;font-weight:800;color:#00F2FE;line-height:1;">2–4 Wks</div>
              <div style="font-family:'Inter',sans-serif;font-size:.78rem;color:#94A3B8;margin-top:6px;text-transform:uppercase;letter-spacing:0.06em;">Hypothesis to Verdict</div>
            </div>
            <div style="background:rgba(13,19,32,0.85);border:1px solid rgba(78,168,255,0.35);border-radius:14px;padding:18px 16px;box-shadow:0 10px 25px rgba(0,0,0,0.5);backdrop-filter:blur(8px);">
              <div style="font-family:'Space Grotesk',sans-serif;font-size:2rem;font-weight:800;color:#4EA8FF;line-height:1;">1 Gate</div>
              <div style="font-family:'Inter',sans-serif;font-size:.78rem;color:#94A3B8;margin-top:6px;text-transform:uppercase;letter-spacing:0.06em;">Numeric Threshold for Yes</div>
            </div>
            <div style="background:rgba(13,19,32,0.85);border:1px solid rgba(178,75,243,0.35);border-radius:14px;padding:18px 16px;box-shadow:0 10px 25px rgba(0,0,0,0.5);backdrop-filter:blur(8px);">
              <div style="font-family:'Space Grotesk',sans-serif;font-size:2rem;font-weight:800;color:#B24BF3;line-height:1;">~8% Cost</div>
              <div style="font-family:'Inter',sans-serif;font-size:.78rem;color:#94A3B8;margin-top:6px;text-transform:uppercase;letter-spacing:0.06em;">Of a Full Build Budget</div>
            </div>
            <div style="background:rgba(13,19,32,0.85);border:1px solid rgba(0,255,157,0.35);border-radius:14px;padding:18px 16px;box-shadow:0 10px 25px rgba(0,0,0,0.5);backdrop-filter:blur(8px);">
              <div style="font-family:'Space Grotesk',sans-serif;font-size:2rem;font-weight:800;color:#00FF9D;line-height:1;">5 Hubs</div>
              <div style="font-family:'Inter',sans-serif;font-size:.78rem;color:#94A3B8;margin-top:6px;text-transform:uppercase;letter-spacing:0.06em;">Chennai, BLR, HYD, CBE, AHD</div>
            </div>
          </div>
        </div>

        <!-- Right Column: 3D Stage (OriginKit Liquid Sphere WebGL2 Engine) -->
        <div class="poc-hero-stage-col" data-reveal style="--d:5">
          <div class="poc-3d-stage-wrap">
            <div class="poc-3d-stage" id="poc-stage-container">
              <!-- WebGL2 OriginKit Liquid Sphere Canvas Host -->
              <div id="poc-liquid-sphere-canvas" data-originkit="liquid-sphere" data-preset="logo3d"></div>

              <!-- HUD Telemetry Top Bar -->
              <div class="poc-stage-hud">
                <div class="poc-hud-left">
                  <span class="poc-hud-chip" id="poc-hud-chip-label">
                    <span class="poc-chip-pulse"></span>
                    ORIGINKIT // LIQUID SPHERE [LOGO 3D COLOUR]
                  </span>
                </div>
                <div class="poc-hud-controls">
                  <button type="button" class="poc-preset-btn active" data-style="logo3d">Logo 3D</button>
                  <button type="button" class="poc-preset-btn" data-style="mint">Mint (Base)</button>
                  <button type="button" class="poc-preset-btn" data-style="wave">Wave</button>
                  <button type="button" class="poc-preset-btn" data-style="frost">Frost</button>
                  <button type="button" class="poc-preset-btn" data-style="ember">Ember</button>
                  <button type="button" class="poc-preset-btn" data-style="magenta">Magenta</button>
                  <div class="poc-mode-toggle">
                    <button type="button" class="poc-view-btn active" data-view="sphere">Sphere</button>
                    <button type="button" class="poc-view-btn" data-view="both">With Cards</button>
                  </div>
                </div>
              </div>

              <!-- 3D Cylinder Carousel holding the 6 Verification Faces -->
              <div class="poc-3d-carousel" id="poc-cards-carousel" style="display: none;">
                <div class="poc-carousel-inner" id="poc-carousel">
                  <?php foreach ($heroFaces as $card): ?>
                    <div class="poc-3d-card">
                      <div class="poc-card-head">
                        <span class="poc-card-num"><?= e($card['id']) ?></span>
                        <span class="poc-card-tag"><?= e($card['tag']) ?></span>
                      </div>

                      <div class="poc-card-img-wrap">
                        <img src="<?= e(asset($card['img'])) ?>" alt="<?= e($card['question']) ?>" loading="lazy">
                      </div>

                      <div class="poc-card-content">
                        <div>
                          <h3 class="poc-card-question"><?= e($card['question']) ?></h3>
                          <p class="poc-card-sub"><?= e($card['sub']) ?></p>
                        </div>

                        <div class="poc-card-foot">
                          <span style="font-family:'JetBrains Mono',monospace;font-size:10px;color:#94A3B8;">AUDIT GATE</span>
                          <span class="poc-card-verdict"><?= e($card['verdict']) ?></span>
                        </div>
                      </div>
                    </div>
                  <?php endforeach; ?>
                </div>
              </div>

              <div class="poc-stage-bottom-hint">
                <span style="color:var(--poc-cyan);">✦</span> Drag to rotate liquid sphere in 3D · Hover to swell · Click for ripple
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- 2. Why Starting With a Proof Changes Everything (4 Cards) -->
  <section class="poc-section poc-section--panel">
    <div class="shell">
      <div class="poc-sec-head" data-reveal>
        <span class="poc-eyebrow">THE CASE FOR PROVING FIRST</span>
        <h2 class="poc-title">Why Starting with a Proof Changes<br><em>Everything That Follows</em></h2>
        <p class="poc-lead">
          Every product begins as an unproven assumption. Proving it while the software is still cheap to change protects your capital and technical velocity.
        </p>
      </div>

      <div class="poc-grid poc-grid--4">
        <?php foreach ($whyFirst as $i => $card): ?>
          <div class="poc-tilt-card" data-reveal style="--d:<?= $i ?>">
            <div class="poc-card-glare"></div>
            <div class="poc-img-wrap">
              <img src="<?= e(asset($card['img'])) ?>" alt="<?= e($card['title']) ?>" loading="lazy">
              <span class="poc-card-badge"><?= e($card['badge']) ?></span>
            </div>
            <div class="poc-card-info">
              <h3 class="poc-card-title"><?= e($card['title']) ?></h3>
              <p class="poc-card-desc"><?= e($card['desc']) ?></p>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- 3. Eight Core Deliverables Inside the Proof (8 Cards) -->
  <section class="poc-section" id="deliverables">
    <div class="shell">
      <div class="poc-sec-head" data-reveal>
        <span class="poc-eyebrow">SCOPE &amp; DELIVERABLES</span>
        <h2 class="poc-title">What Goes Into the Proof We <em>Build for You</em></h2>
        <p class="poc-lead">
          Eight concrete deliverables included in every engagement. No vanity padding, no administrative bloat — just the verified technical truth.
        </p>
      </div>

      <div class="poc-grid poc-grid--4">
        <?php foreach ($inside as $i => $card): ?>
          <div class="poc-tilt-card" data-reveal style="--d:<?= $i % 4 ?>">
            <div class="poc-card-glare"></div>
            <div class="poc-img-wrap">
              <img src="<?= e(asset($card['img'])) ?>" alt="<?= e($card['title']) ?>" loading="lazy">
              <span class="poc-card-badge"><?= e($card['badge']) ?></span>
            </div>
            <div class="poc-card-info">
              <h3 class="poc-card-title"><?= e($card['title']) ?></h3>
              <p class="poc-card-desc"><?= e($card['desc']) ?></p>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- High-Speed Infinity Text Marquee from OriginKit -->
  <div class="poc-band-rail"
       data-ok="infinity-text"
       data-props='<?= e(json_encode([
           'items' => [
               'Every strong product starts with verified logic',
               'One question',
               'One numeric threshold',
               'An honest answer in 2–4 weeks',
               'Zero-risk feasibility validation',
           ],
           'font'  => ['fontSize' => '1.5rem', 'fontWeight' => 700, 'letterSpacing' => '-0.02em', 'lineHeight' => '1.28'],
           'color' => '#DCE6F5',
           'speed' => 24,
           'gap'   => 56,
       ], JSON_THROW_ON_ERROR)) ?>'>
  </div>

  <!-- 4. Five-Step Engagement Process (OriginKit Steps-Flow + 5 3D Cards) -->
  <section class="poc-section poc-section--panel" id="poc-process">
    <div class="shell">
      <div class="poc-sec-head" data-reveal>
        <span class="poc-eyebrow">HOW IT RUNS</span>
        <h2 class="poc-title">Our Five-Step <em>Working Process</em></h2>
        <p class="poc-lead">
          From first constraint scoping to running code and documented empirical findings.
        </p>
      </div>

      <div class="poc-steps-host"
           data-ok="steps-flow"
           data-props='<?= e(json_encode([
               'steps' => array_map(static fn (array $s): array => [
                   'number' => $s['num'],
                   'title'  => $s['title'],
                   'text'   => $s['text'],
                   'image'  => asset($s['img']),
               ], $steps),
               'numberFont'  => ['fontSize' => 88, 'fontWeight' => 800, 'lineHeight' => '1.05', 'letterSpacing' => '-0.04em'],
               'numberColor' => 'rgba(78, 168, 255, 0.30)',
               'titleFont'   => ['fontSize' => 24, 'fontWeight' => 700, 'lineHeight' => '1.25', 'letterSpacing' => '-0.02em'],
               'titleColor'  => '#EAF1FB',
               'textFont'    => ['fontSize' => 15, 'lineHeight' => '1.7em'],
               'textColor'   => 'rgba(197, 211, 232, 0.78)',
               'accentColor' => '#4EA8FF',
               'lineColor'   => 'rgba(78, 168, 255, 0.25)',
               'cornerMaskColor' => 'rgba(0, 0, 0, 0)',
               'imageRadius' => 16,
               'lineWidth'   => 2,
               'dotSize'     => 11,
               'showDots'    => true,
               'cornerRadius' => 16,
               'gridGap'     => 48,
               'imageAnimation' => 'slideUp',
               'mobileBreakpoint' => 820,
           ], JSON_THROW_ON_ERROR)) ?>'>
      </div>

      <!-- Static Fallback Grid for Steps -->
      <div class="poc-grid poc-grid--3" style="margin-top: 40px;">
        <?php foreach ($steps as $i => $step): ?>
          <div class="poc-tilt-card" data-reveal style="--d:<?= $i ?>">
            <div class="poc-card-glare"></div>
            <div class="poc-img-wrap">
              <img src="<?= e(asset($step['img'])) ?>" alt="<?= e($step['title']) ?>" loading="lazy">
              <span class="poc-card-badge">STEP <?= e($step['num']) ?></span>
            </div>
            <div class="poc-card-info">
              <h3 class="poc-card-title"><?= e($step['title']) ?></h3>
              <p class="poc-card-desc"><?= e($step['text']) ?></p>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- 5. Industry Proof Domains (4 Sectors with 3D Tilt Cards) -->
  <section class="poc-section">
    <div class="shell">
      <div class="poc-sec-head" data-reveal>
        <span class="poc-eyebrow">PROVEN DOMAINS</span>
        <h2 class="poc-title">High-Stakes Sectors Where We <em>Prove Feasibility</em></h2>
        <p class="poc-lead">
          Testing complex assumptions in regulated, low-latency, and high-concurrency environments.
        </p>
      </div>

      <div class="poc-grid poc-grid--4">
        <?php foreach ($sectors as $i => $card): ?>
          <div class="poc-tilt-card" data-reveal style="--d:<?= $i ?>">
            <div class="poc-card-glare"></div>
            <div class="poc-img-wrap">
              <img src="<?= e(asset($card['img'])) ?>" alt="<?= e($card['title']) ?>" loading="lazy">
              <span class="poc-card-badge"><?= e($card['badge']) ?></span>
            </div>
            <div class="poc-card-info">
              <h3 class="poc-card-title"><?= e($card['title']) ?></h3>
              <p class="poc-card-desc"><?= e($card['desc']) ?></p>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- 6. Production Benchmarks (3 Cards) -->
  <section class="poc-section poc-section--panel">
    <div class="shell">
      <div class="poc-sec-head" data-reveal>
        <span class="poc-eyebrow">VERIFIED BENCHMARKS</span>
        <h2 class="poc-title">Empirical Results from <em>Live Test Benches</em></h2>
        <p class="poc-lead">
          Real numbers produced under simulated stress loads and verified across edge and cloud infrastructure.
        </p>
      </div>

      <div class="poc-grid poc-grid--3">
        <?php foreach ($benchmarks as $i => $card): ?>
          <div class="poc-tilt-card" data-reveal style="--d:<?= $i ?>">
            <div class="poc-card-glare"></div>
            <div class="poc-img-wrap">
              <img src="<?= e(asset($card['img'])) ?>" alt="<?= e($card['title']) ?>" loading="lazy">
              <span class="poc-card-badge"><?= e($card['badge']) ?></span>
            </div>
            <div class="poc-card-info">
              <h3 class="poc-card-title"><?= e($card['title']) ?></h3>
              <p class="poc-card-desc"><?= e($card['desc']) ?></p>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- 7. FAQ Section -->
  <section class="poc-section">
    <div class="shell" style="max-width: 920px;">
      <div class="poc-sec-head" data-reveal>
        <span class="poc-eyebrow">FAQ</span>
        <h2 class="poc-title">Questions We Get <em>Every Time</em></h2>
      </div>

      <div class="poc-faq-list">
        <?php foreach ($faqs as $i => [$q, $a]): ?>
          <details class="poc-faq-item"<?= $i === 0 ? ' open' : '' ?> style="margin-bottom: 16px; background: rgba(13, 19, 32, 0.7); border: 1px solid rgba(78, 168, 255, 0.2); border-radius: 12px; padding: 20px;">
            <summary style="font-family:'Space Grotesk',sans-serif; font-size:18px; font-weight:700; color:#FFFFFF; cursor:pointer; list-style:none; display:flex; justify-content:space-between; align-items:center;">
              <?= e($q) ?>
              <span style="color:var(--poc-cyan); font-size:20px;">+</span>
            </summary>
            <div style="margin-top: 14px; font-size:15px; line-height:1.7; color:#94A3B8;">
              <p style="margin:0;"><?= e($a) ?></p>
            </div>
          </details>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- 8. Call to Action -->
  <?php
  component('cta', ['cta' => [
      'eyebrow'   => 'Start Your Proof of Concept',
      'title'     => 'Have an unproven assumption? Let us build the test that proves it.',
      'body'      => 'Our senior engineering squads in Chennai, Coimbatore, Bangalore, Hyderabad, and Ahmedabad deliver working code and empirical answers in 2–4 weeks. Call +91 93845 64915 or email info@ithrivesoftware.com.',
      'primary'   => ['label' => 'Book a 30-Minute Discovery Call', 'href' => 'contact.php'],
      'secondary' => ['label' => 'Call: +91 93845 64915', 'href' => 'tel:+919384564915'],
  ]]);
  ?>

</div>

<!-- OriginKit Integration -->
<script type="module" src="<?= e(url('assets/dist/originkit/originkit.js')) ?>"></script>

<?php
require dirname(__DIR__) . '/includes/footer.php';
