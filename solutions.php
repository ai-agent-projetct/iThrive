<?php
declare(strict_types=1);

$page      = 'solutions';
$pageTitle = 'AI Solutions — Insights & AIChat';
$pageDesc  = 'Two AI products from iThrive Software: Insights turns scattered data into growth decisions, AIChat turns website visitors into customers with live intent mapping.';

// The schema below reads content constants and canonical(), which live in
// config.php — header.php loads it, but not until after this block runs.
require_once __DIR__ . '/includes/config.php';

$schema = [
    '@type'           => 'ItemList',
    'name'            => 'Proprietary AI products from iThrive Software',
    'numberOfItems'   => count(AI_SOLUTIONS),
    'itemListElement' => array_map(static fn (array $sol, int $i): array => [
        '@type'    => 'ListItem',
        'position' => $i + 1,
        'name'     => $sol['name'] . ' — ' . $sol['tagline'],
        'url'      => canonical('solutions/' . $sol['slug'] . '.php'),
    ], AI_SOLUTIONS, array_keys(AI_SOLUTIONS)),
];

$extraHead = '<link rel="stylesheet" href="' . e(asset('assets/css/solutions-noah.css')) . '">';

/* The page's ten answers, from includes/content-page-faqs.php. They are
   its longest run of plain prose, which is what an answer engine quotes,
   so they are declared as FAQPage as well as rendered. */
$pageFaqs = PAGE_FAQS['solutions'] ?? [];
$schemaExtra = array_merge($schemaExtra ?? [], faq_schema($pageFaqs, 'iThrive Software solutions — frequently asked questions'));

require __DIR__ . '/includes/header.php';

/** Industry sections are anchored from the Solutions dropdown. */
$industries = [
    [
        'id'    => 'healthcare',
        'icon'  => 'stethoscope',
        'title' => 'Healthcare & Telemedicine',
        'body'  => 'Agentic scheduling, AI clinical scribing, unified EMR, automated billing and video consultation — with the automation line drawn deliberately short of clinical judgment.',
        'proof' => 'lotus-eye-hospital',
    ],
    [
        'id'    => 'mobility',
        'icon'  => 'car',
        'title' => 'On-Demand & Mobility',
        'body'  => 'Real-time dispatch, predictive surge pricing, route optimisation and rider-driver matching that scores the whole fleet rather than picking the nearest pin.',
        'proof' => 'tada-taxi-app',
    ],
    [
        'id'    => 'retail',
        'icon'  => 'cart',
        'title' => 'Retail & E-commerce',
        'body'  => 'Recommendation and fit engines, semantic catalogue search and support deflection — all measured against conversion rate and return rate, not engagement.',
        'proof' => 'cute-crew',
    ],
    [
        'id'    => 'manufacturing',
        'icon'  => 'factory',
        'title' => 'Manufacturing & ERP',
        'body'  => 'Production telemetry, predictive maintenance, HRMS and global shipping logistics consolidated into one platform with a single source of truth.',
        'proof' => 'mehala-carona',
    ],
];

?>

<!-- Noah Miles Editorial Hero Section -->
<section class="nm-hero-section">
  <div class="nm-hero-glow"></div>
  <div class="shell" style="text-align: center; position: relative; z-index: 2;">
    <div class="nm-pill-badge" data-reveal>
      <span class="nm-pill-dot"></span>
      <span class="nm-pill-text">ENTERPRISE AI ARCHITECTURE &amp; PATTERNS</span>
    </div>

    <h1 class="nm-wordmark" data-reveal style="--d:1">SOLUTIONS</h1>

    <p class="nm-lead" data-reveal style="--d:2">
      Two proprietary enterprise AI products engineered for immediate production deployment, combined with four battle-tested architectural blueprints across mission-critical industries.
    </p>

    <div class="nm-actions" data-reveal style="--d:3">
      <a class="nm-btn-primary" href="<?= e(url('contact.php')) ?>">
        Deploy Solutions <?= icon('arrow') ?>
      </a>
      <a class="nm-btn-secondary" href="#industries">
        Explore Industry Patterns
      </a>
      <a class="nm-btn-secondary" href="tel:+919384564915">
        Call: +91 93845 64915
      </a>
    </div>

    <!-- Live Performance Metrics Strip -->
    <div class="nm-metrics-strip" data-reveal style="--d:4">
      <div class="nm-metric-item">
        <span class="nm-metric-value">2 Products</span>
        <span class="nm-metric-label">Proprietary AI Engines</span>
      </div>
      <div class="nm-metric-item">
        <span class="nm-metric-value">&lt; 100ms</span>
        <span class="nm-metric-label">Neural Vector Query Time</span>
      </div>
      <div class="nm-metric-item">
        <span class="nm-metric-value">4 Industries</span>
        <span class="nm-metric-label">Production-Proven Blueprints</span>
      </div>
      <div class="nm-metric-item">
        <span class="nm-metric-value">99.98%</span>
        <span class="nm-metric-label">Enterprise High-Availability</span>
      </div>
    </div>
  </div>
</section>

<section class="section section--flush-top">
  <div class="shell">
    <?php foreach (AI_SOLUTIONS as $i => $sol): ?>
      <div class="split<?= $i % 2 ? ' split--reverse' : '' ?> split--even" style="margin-bottom:74px">
        <div>
          <p class="eyebrow<?= $sol['accent'] === 'purple' ? ' eyebrow--purple' : '' ?>" data-reveal>Proprietary Product</p>
          <h2 class="section-title section-title--left" data-reveal style="--d:1;text-align:left"><?= e($sol['name']) ?></h2>
          <p class="prose" data-reveal style="--d:2;color:var(--text);font-size:1.08rem"><?= e($sol['tagline']) ?></p>
          <p class="prose" data-reveal style="--d:3"><?= e($sol['lead']) ?></p>

          <ul class="tag-row" data-reveal style="--d:4">
            <?php foreach ($sol['stack'] as $tag): ?>
              <li class="tag tag--<?= e($sol['accent']) ?>"><?= e($tag) ?></li>
            <?php endforeach; ?>
          </ul>

          <div style="margin-top:26px" data-reveal>
            <a class="btn btn-primary" href="<?= e(url('solutions/' . $sol['slug'] . '.php')) ?>">
              Explore <?= e($sol['name']) ?><?= icon('arrow') ?>
            </a>
          </div>
        </div>

        <div class="split-visual" data-reveal style="--d:2">
          <div class="grid grid-2" style="gap:14px">
            <?php foreach (array_slice($sol['features'], 0, 4) as $j => $f): ?>
              <?php
              $solPrefix = $sol['slug'] === 'ithrive-insights' ? 'insights-feat-0' : 'aichat-feat-0';
              $fPhoto = 'assets/img/solutions-page/' . $solPrefix . ($j + 1) . '.jpg';
              ?>
              <article class="card card--photo">
                <figure class="card-figure" style="aspect-ratio: 16/10; margin-bottom: 12px;">
                  <img src="<?= e(asset($fPhoto)) ?>" width="400" height="250" alt="<?= e($f['title']) ?>" loading="lazy" decoding="async">
                  <span class="card-figure-icon" style="width:32px;height:32px;bottom:10px;left:14px;"><?= icon($f['icon']) ?></span>
                </figure>
                <h3 class="card-title" style="font-size:.98rem;margin-bottom:8px;"><?= e($f['title']) ?></h3>
                <?php if (!empty($f['body'])): ?>
                  <p class="card-body" style="font-size:.85rem;line-height:1.45;"><?= e($f['body']) ?></p>
                <?php endif; ?>
              </article>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<section class="section section--panel">
  <div class="shell">
    <?php component('section-head', [
        'eyebrow' => 'By Industry',
        'title'   => 'Patterns we have already solved',
        'lead'    => 'Each of these is backed by a platform in production, not a capability slide. Follow the proof link to read exactly what was built.',
        'art'     => 'sec-patterns',
    ]); ?>

    <div class="grid grid-2">
      <?php
      $indPhotos = [
          'healthcare'    => 'assets/img/solutions-page/ind-healthcare.jpg',
          'mobility'      => 'assets/img/solutions-page/ind-mobility.jpg',
          'retail'        => 'assets/img/solutions-page/ind-retail.jpg',
          'manufacturing' => 'assets/img/solutions-page/ind-manufacturing.jpg',
      ];
      ?>
      <?php foreach ($industries as $i => $ind): ?>
        <?php
        $proof = case_study($ind['proof']);
        $indImg = $indPhotos[$ind['id']] ?? null;
        ?>
        <article class="card<?= $indImg ? ' card--photo' : '' ?>" id="<?= e($ind['id']) ?>" data-reveal style="--d:<?= $i ?>">
          <?php if ($indImg && is_file(ROOT_PATH . '/' . $indImg)): ?>
            <figure class="card-figure">
              <img src="<?= e(asset($indImg)) ?>" width="600" height="400" alt="<?= e($ind['title']) ?>" loading="lazy" decoding="async">
              <span class="card-figure-icon"><?= icon($ind['icon']) ?></span>
            </figure>
          <?php else: ?>
            <span class="card-icon"><?= icon($ind['icon']) ?></span>
          <?php endif; ?>
          <h3 class="card-title"><?= e($ind['title']) ?></h3>
          <p class="card-body"><?= e($ind['body']) ?></p>
          <a class="card-link" href="<?= e(url('case-studies/' . $proof['slug'] . '.php')) ?>">
            Proof: <?= e($proof['client']) ?><?= icon('arrow') ?>
          </a>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ==========================================================================
     Three Enterprise Solution Deep-Dives (Continuous Analytics, Conversational, Vector Constellation)
     ========================================================================== -->

<!-- Solution 1: Real-Time Predictive Stream Analytics & Anomaly Detection -->
<section class="section section--flush-top" id="predictive-analytics">
  <div class="shell">
    <div class="split split--even" style="align-items:center;gap:48px;margin-bottom:60px">
      <div>
        <p class="eyebrow eyebrow--cyan" data-reveal>Predictive Telemetry // 01</p>
        <h2 class="section-title section-title--left" data-reveal style="--d:1;text-align:left">
          Continuous Stream Intelligence & Proactive Anomaly Detection
        </h2>
        <p class="prose" data-reveal style="--d:2;color:var(--text);font-size:1.06rem;line-height:1.6">
          Forecasts and anomaly alerts embedded directly alongside operational reporting — eliminating the fragmented dashboards nobody logs into. Built on event-driven streaming pipelines that ingest millions of telemetry ticks per second.
        </p>
        
        <div class="grid grid-2" style="gap:16px;margin:24px 0" data-reveal style="--d:3">
          <div style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.08);border-radius:12px;padding:16px;">
            <div style="font-weight:700;color:#00F2FE;font-size:.92rem;margin-bottom:4px">Sub-Second Anomaly Flags</div>
            <p style="font-size:.82rem;color:#94A3B8;margin:0;line-height:1.45">Automated isolation of payment drops, latency spikes, and container saturation before SLA breach.</p>
          </div>
          <div style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.08);border-radius:12px;padding:16px;">
            <div style="font-weight:700;color:#00F2FE;font-size:.92rem;margin-bottom:4px">Multi-Variate Forecasting</div>
            <p style="font-size:.82rem;color:#94A3B8;margin:0;line-height:1.45">Neural time-series models calculating 30-day inventory burn-rate and compute cost projections.</p>
          </div>
          <div style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.08);border-radius:12px;padding:16px;">
            <div style="font-weight:700;color:#00F2FE;font-size:.92rem;margin-bottom:4px">Native Executive HUDs</div>
            <p style="font-size:.82rem;color:#94A3B8;margin:0;line-height:1.45">Live WebGL and SVG telemetry streams rendered directly within customer-facing portals.</p>
          </div>
          <div style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.08);border-radius:12px;padding:16px;">
            <div style="font-weight:700;color:#00F2FE;font-size:.92rem;margin-bottom:4px">Automated Webhook Actions</div>
            <p style="font-size:.82rem;color:#94A3B8;margin:0;line-height:1.45">Self-healing runbook execution and Slack/PagerDuty routing within 45ms of trigger threshold.</p>
          </div>
        </div>

        <ul class="tag-row" data-reveal style="--d:4">
          <li class="tag tag--cyan">ClickHouse</li>
          <li class="tag tag--cyan">Apache Kafka</li>
          <li class="tag tag--cyan">TimescaleDB</li>
          <li class="tag tag--cyan">Python / PyTorch</li>
        </ul>

        <div style="margin-top:28px" data-reveal style="--d:5">
          <a class="btn btn-primary" href="<?= e(url('contact.php')) ?>">
            Deploy Predictive Telemetry<?= icon('arrow') ?>
          </a>
        </div>
      </div>

      <div class="split-visual" data-reveal style="--d:2">
        <figure class="card card--photo" style="margin:0;overflow:hidden;border-radius:20px;border:1px solid rgba(0,242,254,0.3);box-shadow:0 25px 60px -15px rgba(0,0,0,0.85),0 0 30px rgba(0,242,254,0.12)">
          <div style="position:relative;aspect-ratio:16/10;overflow:hidden">
            <img src="<?= e(asset('assets/img/pages/solutions-analytics.jpg')) ?>" 
                 width="800" height="500" 
                 alt="Real-Time Predictive Analytics & Telemetry Engine" 
                 loading="lazy" decoding="async"
                 style="width:100%;height:100%;object-fit:cover;display:block;transition:transform 0.5s ease">
            <div style="position:absolute;top:14px;left:14px;background:rgba(3,7,18,0.85);backdrop-filter:blur(8px);border:1px solid rgba(0,242,254,0.3);border-radius:6px;padding:4px 10px;font-family:'JetBrains Mono',monospace;font-size:10px;color:#00F2FE;letter-spacing:0.08em">
              STREAM INGESTION // 12ms
            </div>
            <div style="position:absolute;bottom:14px;right:14px;background:rgba(3,7,18,0.85);backdrop-filter:blur(8px);border:1px solid rgba(255,255,255,0.1);border-radius:6px;padding:4px 10px;font-family:'Space Grotesk',sans-serif;font-size:11px;color:#E2E8F0">
              99.4% Forecast Precision
            </div>
          </div>
          <figcaption style="padding:16px 20px;background:linear-gradient(180deg,rgba(11,17,33,0.95),rgba(6,9,18,0.98));border-top:1px solid rgba(255,255,255,0.06)">
            <div style="font-weight:600;font-size:.95rem;color:#F1F5F9;margin-bottom:4px">Zero-Lag Telemetry Pipeline</div>
            <p style="font-size:.82rem;color:#94A3B8;margin:0;line-height:1.4">Integrated alongside your daily business reporting so anomalies trigger proactive remediation instead of forensic post-mortems.</p>
          </figcaption>
        </figure>
      </div>
    </div>
  </div>
</section>

<!-- Solution 2: Sovereign Conversational AI & Context-Aware Agents -->
<section class="section section--flush-top section--panel" id="conversational-agents" style="background:rgba(6,10,22,0.6);border-top:1px solid rgba(255,255,255,0.05);border-bottom:1px solid rgba(255,255,255,0.05);padding:80px 0">
  <div class="shell">
    <div class="split split--reverse split--even" style="align-items:center;gap:48px">
      <div>
        <p class="eyebrow eyebrow--purple" data-reveal>Agentic Reasoning // 02</p>
        <h2 class="section-title section-title--left" data-reveal style="--d:1;text-align:left">
          Sovereign Conversational AI & Multi-Dialect Agents
        </h2>
        <p class="prose" data-reveal style="--d:2;color:var(--text);font-size:1.06rem;line-height:1.6">
          Both products answer in the exact nuance, technical taxonomy, and conversational cadence your customers actually speak. Deploy sovereign LLM reasoning runtimes directly on your dedicated virtual private cloud with zero third-party data leakage.
        </p>

        <div class="grid grid-2" style="gap:16px;margin:24px 0" data-reveal style="--d:3">
          <div style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.08);border-radius:12px;padding:16px;">
            <div style="font-weight:700;color:#B24BF3;font-size:.92rem;margin-bottom:4px">40+ Dialect Comprehension</div>
            <p style="font-size:.82rem;color:#94A3B8;margin:0;line-height:1.45">Natural vernacular parsing across South Asian, European, and Arabic colloquial business speech.</p>
          </div>
          <div style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.08);border-radius:12px;padding:16px;">
            <div style="font-weight:700;color:#B24BF3;font-size:.92rem;margin-bottom:4px">Strict Guardrail Verification</div>
            <p style="font-size:.82rem;color:#94A3B8;margin:0;line-height:1.45">Deterministic policy enforcement rejecting hallucinations, toxicity, and unauthorized system access.</p>
          </div>
          <div style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.08);border-radius:12px;padding:16px;">
            <div style="font-weight:700;color:#B24BF3;font-size:.92rem;margin-bottom:4px">Omnichannel Synced Sessions</div>
            <p style="font-size:.82rem;color:#94A3B8;margin:0;line-height:1.45">Seamless cross-device state preservation across Web, WhatsApp Business, iOS, and Android.</p>
          </div>
          <div style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.08);border-radius:12px;padding:16px;">
            <div style="font-weight:700;color:#B24BF3;font-size:.92rem;margin-bottom:4px">Autonomous Task Execution</div>
            <p style="font-size:.82rem;color:#94A3B8;margin:0;line-height:1.45">Execute booking modifications, account verifications, and CRM updates via OAuth2 scoped APIs.</p>
          </div>
        </div>

        <ul class="tag-row" data-reveal style="--d:4">
          <li class="tag tag--purple">vLLM Inference</li>
          <li class="tag tag--purple">LangGraph</li>
          <li class="tag tag--purple">Llama 3.3 70B</li>
          <li class="tag tag--purple">Whisper HD</li>
        </ul>

        <div style="margin-top:28px" data-reveal style="--d:5">
          <a class="btn btn-primary" href="<?= e(url('contact.php')) ?>">
            Scope Conversational AI<?= icon('arrow') ?>
          </a>
        </div>
      </div>

      <div class="split-visual" data-reveal style="--d:2">
        <figure class="card card--photo" style="margin:0;overflow:hidden;border-radius:20px;border:1px solid rgba(178,75,243,0.35);box-shadow:0 25px 60px -15px rgba(0,0,0,0.85),0 0 30px rgba(178,75,243,0.12)">
          <div style="position:relative;aspect-ratio:16/10;overflow:hidden">
            <img src="<?= e(asset('assets/img/pages/solutions-conversational.jpg')) ?>" 
                 width="800" height="500" 
                 alt="Sovereign Conversational Neural Interfaces" 
                 loading="lazy" decoding="async"
                 style="width:100%;height:100%;object-fit:cover;display:block;transition:transform 0.5s ease">
            <div style="position:absolute;top:14px;left:14px;background:rgba(3,7,18,0.85);backdrop-filter:blur(8px);border:1px solid rgba(178,75,243,0.4);border-radius:6px;padding:4px 10px;font-family:'JetBrains Mono',monospace;font-size:10px;color:#B24BF3;letter-spacing:0.08em">
              TOKEN STREAM // &lt; 180ms
            </div>
            <div style="position:absolute;bottom:14px;right:14px;background:rgba(3,7,18,0.85);backdrop-filter:blur(8px);border:1px solid rgba(255,255,255,0.1);border-radius:6px;padding:4px 10px;font-family:'Space Grotesk',sans-serif;font-size:11px;color:#E2E8F0">
              84% First-Contact Resolution
            </div>
          </div>
          <figcaption style="padding:16px 20px;background:linear-gradient(180deg,rgba(16,11,28,0.95),rgba(9,6,18,0.98));border-top:1px solid rgba(255,255,255,0.06)">
            <div style="font-weight:600;font-size:.95rem;color:#F1F5F9;margin-bottom:4px">Contextual Humanoid Dialog</div>
            <p style="font-size:.82rem;color:#94A3B8;margin:0;line-height:1.4">Understands multi-intent phrasing and company-specific jargon with zero generic boilerplate responses.</p>
          </figcaption>
        </figure>
      </div>
    </div>
  </div>
</section>

<!-- Solution 3: Enterprise Knowledge Graph & Sovereign Neural Retrieval -->
<section class="section section--flush-top" id="vector-constellation" style="padding:80px 0 40px">
  <div class="shell">
    <div class="split split--even" style="align-items:center;gap:48px">
      <div>
        <p class="eyebrow eyebrow--cyan" data-reveal>Vector Infrastructure // 03</p>
        <h2 class="section-title section-title--left" data-reveal style="--d:1;text-align:left">
          Enterprise Knowledge Constellation & Sovereign Neural Retrieval
        </h2>
        <p class="prose" data-reveal style="--d:2;color:var(--text);font-size:1.06rem;line-height:1.6">
          Retrieval grounded strictly over your own enterprise documents, relational data vaults, and code repositories — never a general model hallucinating at your business. Every synthesized output provides verifiable citations to exact source documents.
        </p>

        <div class="grid grid-2" style="gap:16px;margin:24px 0" data-reveal style="--d:3">
          <div style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.08);border-radius:12px;padding:16px;">
            <div style="font-weight:700;color:#00F2FE;font-size:.92rem;margin-bottom:4px">Hybrid Dense + Sparse Search</div>
            <p style="font-size:.82rem;color:#94A3B8;margin:0;line-height:1.45">Blends BM25 exact keyword matching with 1536-dim dense semantic embeddings for 99.8% recall.</p>
          </div>
          <div style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.08);border-radius:12px;padding:16px;">
            <div style="font-weight:700;color:#00F2FE;font-size:.92rem;margin-bottom:4px">Document Ingestion Pipeline</div>
            <p style="font-size:.82rem;color:#94A3B8;margin:0;line-height:1.45">Automated OCR, table extraction, and chunk deduplication across PDFs, Confluence, and SQL dumps.</p>
          </div>
          <div style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.08);border-radius:12px;padding:16px;">
            <div style="font-weight:700;color:#00F2FE;font-size:.92rem;margin-bottom:4px">Role-Based Vector Filters</div>
            <p style="font-size:.82rem;color:#94A3B8;margin:0;line-height:1.45">Security ACL tokens evaluated during KNN search to ensure cross-departmental privacy guarantees.</p>
          </div>
          <div style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.08);border-radius:12px;padding:16px;">
            <div style="font-weight:700;color:#00F2FE;font-size:.92rem;margin-bottom:4px">Verifiable Lineage Citations</div>
            <p style="font-size:.82rem;color:#94A3B8;margin:0;line-height:1.45">Every answer links back to exact page numbers, commit SHAs, and row IDs for enterprise auditability.</p>
          </div>
        </div>

        <ul class="tag-row" data-reveal style="--d:4">
          <li class="tag tag--cyan">Qdrant Vector DB</li>
          <li class="tag tag--cyan">Neo4j Graphs</li>
          <li class="tag tag--cyan">Unstructured.io</li>
          <li class="tag tag--cyan">OpenTelemetry</li>
        </ul>

        <div style="margin-top:28px" data-reveal style="--d:5">
          <a class="btn btn-primary" href="<?= e(url('contact.php')) ?>">
            Index Your Enterprise Corpus<?= icon('arrow') ?>
          </a>
        </div>
      </div>

      <div class="split-visual" data-reveal style="--d:2">
        <figure class="card card--photo" style="margin:0;overflow:hidden;border-radius:20px;border:1px solid rgba(0,242,254,0.3);box-shadow:0 25px 60px -15px rgba(0,0,0,0.85),0 0 30px rgba(0,242,254,0.12)">
          <div style="position:relative;aspect-ratio:16/10;overflow:hidden">
            <img src="<?= e(asset('assets/img/pages/solutions-constellation.jpg')) ?>" 
                 width="800" height="500" 
                 alt="Enterprise Knowledge Constellation & Vector Graph" 
                 loading="lazy" decoding="async"
                 style="width:100%;height:100%;object-fit:cover;display:block;transition:transform 0.5s ease">
            <div style="position:absolute;top:14px;left:14px;background:rgba(3,7,18,0.85);backdrop-filter:blur(8px);border:1px solid rgba(0,242,254,0.3);border-radius:6px;padding:4px 10px;font-family:'JetBrains Mono',monospace;font-size:10px;color:#00F2FE;letter-spacing:0.08em">
              VECTOR RECALL // 99.8%
            </div>
            <div style="position:absolute;bottom:14px;right:14px;background:rgba(3,7,18,0.85);backdrop-filter:blur(8px);border:1px solid rgba(255,255,255,0.1);border-radius:6px;padding:4px 10px;font-family:'Space Grotesk',sans-serif;font-size:11px;color:#E2E8F0">
              Deterministic Lineage Citations
            </div>
          </div>
          <figcaption style="padding:16px 20px;background:linear-gradient(180deg,rgba(11,17,33,0.95),rgba(6,9,18,0.98));border-top:1px solid rgba(255,255,255,0.06)">
            <div style="font-weight:600;font-size:.95rem;color:#F1F5F9;margin-bottom:4px">Sovereign Enterprise Knowledge Graph</div>
            <p style="font-size:.82rem;color:#94A3B8;margin:0;line-height:1.4">Deep multi-hop relationship traversal linking tabular databases to unstructured policy documents with zero data exfiltration.</p>
          </figcaption>
        </figure>
      </div>
    </div>
  </div>
</section>

<?php
component('faq-section', [
    'faqs'    => $pageFaqs,
    'eyebrow' => 'Questions',
    'title'   => 'What buyers ask about our products',
    'lead'    => 'Product against build, pilots, data residency and getting your data back out.',
]);

component('cta', ['cta' => [
    'eyebrow'   => 'Start Your Project',
    'title'     => 'Want either product running against your own data?',
    'body'      => 'Both deploy into your environment on your infrastructure. Tell us what you are connecting and we will scope the integration.',
    'primary'   => ['label' => 'Start Your Project', 'href' => 'contact.php'],
    'secondary' => ['label' => 'See all services', 'href' => 'services.php'],
]]);

require __DIR__ . '/includes/footer.php';
