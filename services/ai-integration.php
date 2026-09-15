<?php
/**
 * Enterprise AI Integration & Legacy System Modernization
 *
 * Enterprise AI Service Page engineered with modern dark cyber UI,
 * 6 Core Capabilities, 5 Strategic ROI Advantages, 5-Step Process Roadmap,
 * 3 Deployment Frameworks, Tech Stack Arena, and 10 Detailed FAQs with Schema.org JSON-LD.
 */

declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/config.php';

$page         = 'services';
$pageTitle    = 'Enterprise AI Integration & Legacy System Modernization';
$pageDesc     = 'Modernize enterprise software by embedding predictive models, generative AI endpoints, and vector search directly into existing web, mobile, and cloud applications.';
$ogImage      = 'assets/img/services/svc-12-ai-integration.jpg';

/* ---------------------------------------------------------------------------
 * Content Definitions
 * ------------------------------------------------------------------------ */

$stats = [['80%', 'Faster Modernization Velocity'], ['99.95%', 'AI Endpoint Reliability'], ['30+', 'Enterprise System Adapters'], ['0 Hours', 'Core System Downtime']];

$disciplines = [['01', 'Non-Invasive Sidecar AI Microservices', 'Deploying modular microservices alongside existing web and desktop software, providing AI capabilities without touching core legacy code.'], ['02', 'Unified REST & GraphQL AI API Gateways', 'Designing high-throughput API gateways that consolidate multiple LLM providers, embedding models, and custom ML endpoints into a single unified endpoint.'], ['03', 'Real-Time Streaming SSE & WebSocket Bridges', 'Engineering ultra-low latency Server-Sent Events (SSE) and WebSocket conduits for token-by-token streaming responses in web and mobile UIs.'], ['04', 'Semantic Caching & Prompt Acceleration', 'Implementing Redis-based semantic vector caches that serve identical or similar AI queries in <5ms while cutting cloud token costs by up to 70%.'], ['05', 'Enterprise SSO & Role-Based Auth Bridging', 'Seamlessly integrating AI endpoints with Okta, Azure AD, OAuth2, and SAML so user permissions and security policies are strictly respected.'], ['06', 'Hybrid & Multi-Cloud AI Deployment', 'Bridging on-premise core infrastructure with elastic cloud GPUs and private VPC model hosting for maximum cost and compute flexibility.']];

$benefits = [['01', 'Zero-Downtime Non-Invasive Modernization', 'Add state-of-the-art AI features to your applications without risky, multi-year core system rewrites.'], ['02', 'Drastic Reduction in Operational Latency', 'Semantic caching and optimized streaming conduits deliver instant, fluid AI interactions for end users.'], ['03', 'Complete Vendor & Model Independence', 'Hot-swap underlying AI models (OpenAI, Claude, Llama) behind a unified gateway without modifying client apps.'], ['04', 'Enterprise-Grade Identity & Governance', 'Enforce strict corporate access policies, SSO authentication, and detailed audit trails across all AI requests.'], ['05', 'Up to 70% Lower Token Inference Bills', 'Smart model routing and semantic caching dramatically reduce repetitive API calls to commercial LLMs.']];

$steps = [['01', 'Legacy Architecture & Data Flow Audit', 'Evaluating your current application architecture, network topology, user auth flow, and identifying prime AI integration points.'], ['02', 'AI Gateway & Microservice Design', 'Architecting unified API schemas, semantic caching layers, streaming protocols, and authentication bridges.'], ['03', 'Connector & Sidecar Development', 'Developing containerized microservices and client SDKs that interface seamlessly with your existing codebase.'], ['04', 'Staging Integration & Load Testing', 'Benchmarking throughput, concurrency, latency under peak load, and verifying fallback routing on model failures.'], ['05', 'Production Zero-Downtime Rollout', 'Deploying via blue-green or canary releases on Kubernetes with 24/7 observability and health telemetry.']];

$models = [['01', 'AI Integration Sprint', 'A 3-week engagement integrating custom AI endpoints or RAG search into an existing web or mobile application.', ['3-week delivery', 'Unified API gateway', 'Semantic caching setup']], ['02', 'Enterprise AI Modernization Suite', 'Complete modernization of a legacy enterprise platform with sidecar microservices, real-time streaming, and SSO integration.', ['Full sidecar architecture', 'SSO/SAML auth bridge', 'High-availability SLA']], ['03', 'Continuous AI Integration & Support', 'Ongoing integration support, new model onboarding, latency tuning, and 24/7 microservice uptime management.', ['Continuous model updates', 'Dedicated integration squad', '24/7 cluster monitoring']]];

$techStack = ['FastAPI', 'Go', 'Redis', 'Kong Gateway', 'Docker', 'Kubernetes', 'GraphQL', 'WebSockets', 'Azure AD', 'Okta'];

$pageStack = [
    ['slug' => 'gateway', 'title' => 'Gateway & Serving', 'icon' => 'layers',
     'blurb' => 'One route every AI call passes through.',
     'items' => [
         ['name' => 'FastAPI', 'logo' => 'fastapi'],
         ['name' => 'Node.js', 'logo' => 'nodedotjs'],
         ['name' => 'GraphQL', 'logo' => 'graphql'],
         ['name' => 'Python', 'logo' => 'python'],
     ]],
    ['slug' => 'data', 'title' => 'Pipelines', 'icon' => 'database',
     'blurb' => 'Turning operational records into something a model can use.',
     'items' => [
         ['name' => 'Airflow', 'logo' => 'apacheairflow'],
         ['name' => 'dbt', 'logo' => 'dbt'],
         ['name' => 'PostgreSQL', 'logo' => 'postgresql'],
         ['name' => 'OpenSearch', 'logo' => 'opensearch'],
     ]],
    ['slug' => 'platform', 'title' => 'Platform & Cost', 'icon' => 'cloud',
     'blurb' => 'Quotas, attribution and a bill you can read.',
     'items' => [
         ['name' => 'Kubernetes', 'logo' => 'kubernetes'],
         ['name' => 'Docker', 'logo' => 'docker'],
         ['name' => 'Terraform', 'logo' => 'terraform'],
         ['name' => 'Grafana', 'logo' => 'grafana'],
     ]],
];

$faqs = [['How do you integrate AI into our legacy application without breaking existing features?', 'We use non-invasive architectural patterns such as sidecar microservices and API gateway facades. Your legacy application makes standard REST or webhook calls to our AI gateway, leaving your core business logic completely untouched and stable.'], ['Can we switch between different AI models in the future without changing our application code?', 'Yes. Our unified AI gateway abstracts model providers behind a standardized API. You can switch from OpenAI to Claude or to an on-premise fine-tuned Llama model with a single configuration flag without updating your application.'], ['How do you handle token-by-token streaming in web and mobile applications?', 'We implement Server-Sent Events (SSE) and WebSocket streaming protocols that deliver generated tokens to client user interfaces in real time with sub-50ms Time-To-First-Token (TTFT).'], ['What is semantic caching and how does it save cloud costs?', 'Semantic caching uses vector embeddings to recognize when a new user query has the same meaning as a previously answered query. It serves the cached answer in <5ms, eliminating redundant LLM API calls and reducing token costs by up to 70%.'], ['How do you integrate AI capabilities with our corporate Single Sign-On (SSO)?', 'Our AI middleware integrates directly with your existing Identity Providers (Okta, Azure AD, Keycloak, PingIdentity) via OAuth2 and SAML, ensuring user roles and permission boundaries are enforced at the AI layer.'], ['Can the AI integration run inside our private VPC or on-premise infrastructure?', 'Yes. All our integration gateways, caching microservices, and self-hosted model backends are containerized with Docker and deployable in any private cloud or bare-metal environment.'], ['What happens if an external AI provider experiences an outage?', 'Our gateway features automated fallback and circuit breaker routing. If a primary model API fails or exceeds latency thresholds, requests are instantly routed to a secondary model or localized cache without user interruption.'], ['How do you monitor the performance and costs of integrated AI features?', 'We provide centralized telemetry dashboards powered by OpenTelemetry and Prometheus, tracking request counts, token consumption, response latency, and error rates per user and department.'], ['Is AI integration compliant with data privacy regulations like GDPR and HIPAA?', 'Yes. We configure zero-data-retention headers, client-side PII redaction, and encrypted data transit (TLS 1.3) to ensure full compliance with global regulatory standards.'], ['How long does it take to integrate AI into an existing enterprise application?', 'A standard integration sprint connecting an AI feature or semantic search into an existing application typically takes 2 to 3 weeks. Comprehensive enterprise platform modernizations take 4 to 6 weeks.']];

/** Schema.org Structured Data with FAQPage & Service */
$schema = [
    '@context' => 'https://schema.org',
    '@graph' => [
        [
            '@type' => 'Service',
            'name' => 'Enterprise AI Integration & Legacy System Modernization',
            'serviceType' => 'Enterprise Integration & Systems',
            'description' => 'Modernize enterprise software by embedding predictive models, generative AI endpoints, and vector search directly into existing web, mobile, and cloud applications.',
            'url' => canonical('services/ai-integration.php'),
            'provider' => [
                '@type' => 'Organization',
                'name' => SITE_NAME,
                'url' => canonical('')
            ],
            'areaServed' => [
                ['@type' => 'City', 'name' => 'Chennai'],
                ['@type' => 'City', 'name' => 'Bangalore'],
                ['@type' => 'City', 'name' => 'Hyderabad'],
                ['@type' => 'City', 'name' => 'Coimbatore'],
                ['@type' => 'Country', 'name' => 'India'],
                ['@type' => 'Country', 'name' => 'United States'],
                ['@type' => 'Country', 'name' => 'United Kingdom'],
                ['@type' => 'Country', 'name' => 'United Arab Emirates']
            ]
        ],
        [
            '@type' => 'FAQPage',
            'mainEntity' => array_map(static function(array $faq): array {
                return [
                    '@type' => 'Question',
                    'name' => $faq[0],
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => $faq[1]
                    ]
                ];
            }, $faqs)
        ]
    ]
];

$extraHead = '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>'
    . '<link rel="stylesheet" href="https://fonts.googleapis.com/css2?'
    . 'family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;600;700'
    . '&family=Space+Grotesk:wght@500;600;700;800&display=swap">'
    . '<link rel="stylesheet" href="' . e(asset('assets/css/service-custom.css')) . '">'
    . '<link rel="stylesheet" href="' . e(asset('assets/css/svc-theme.css')) . '">';
$GLOBALS['ithrive_needs_svc3d'] = true;

require dirname(__DIR__) . '/includes/header.php';
?>

<div class="svc-page" data-theme="gateway">

  <!-- =========================================================================
       HERO SECTION: Cyber Eyebrow, Gradient Headline & Action CTAs
       ========================================================================= -->
  <section class="svc-hero">
    <div class="svc-shell svc-hero-inner">
      <p class="svc-eyebrow"><span class="svc-pulse" aria-hidden="true"></span>Enterprise AI Modernization · Non-Invasive Architecture</p>

      <h1 class="svc-h1">
        Enterprise AI Integration For<br><em>Seamless Software Modernization</em>
      </h1>

      <p class="svc-lead">
        Modernize enterprise software by embedding predictive models, generative AI endpoints, and vector search directly into existing web, mobile, and cloud applications.
      </p>

      <div class="svc-actions svc-actions--mid">
        <button class="svc-btn svc-btn--primary" type="button"
                data-modal-open data-modal-service="Enterprise AI Integration & Legacy System Modernization">
          Consult Our AI Architects<?= icon('arrow') ?>
        </button>
        <a class="svc-btn svc-btn--ghost" href="#disciplines">Explore 6 Core Disciplines</a>
      </div>

      <!-- 4 KPI Metrics -->
      <ul class="svc-stats">
        <?php foreach ($stats as [$val, $lbl]): ?>
          <li class="svc-stat-card">
            <strong><?= e($val) ?></strong>
            <span><?= e($lbl) ?></span>
          </li>
        <?php endforeach; ?>
      </ul>

      <!-- Dedicated 3D Architecture Visual Asset -->
      <div class="svc-hero-art">
        <img src="<?= e(asset('assets/img/services/svc-12-ai-integration.jpg')) ?>" width="1200" height="700"
             alt="Enterprise AI Integration & Legacy System Modernization Architecture" fetchpriority="high" decoding="async">
      </div>
    </div>
  </section>

  <!-- =========================================================================
       ARCHITECTURAL ADVANTAGE
       ========================================================================= -->
  <section class="svc-sec svc-sec--dark" id="advantage">
    <div class="svc-shell">
      <div class="svc-open-grid">
        <div>
          <p class="svc-eyebrow"><span class="svc-pulse" aria-hidden="true"></span>Architectural Advantage</p>
          <h2 class="svc-title">Rewriting legacy software is slow and risky;<br><em>AI integration unlocks instant capabilities</em></h2>
        </div>
        <div class="svc-open-copy">
          <p>Enterprises sit on battle-tested legacy core systems that process billions in revenue. Ripping and replacing these applications to incorporate AI is prohibitively expensive, takes years, and introduces existential operational risk to the business.</p>
          <p>We specialize in non-invasive AI integration and legacy modernization. By deploying high-throughput AI microservices, universal API gateways, and streaming real-time bridges, we inject generative AI, automated semantic search, and predictive intelligence into your existing applications with zero disruption to daily operations.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- =========================================================================
       6 CORE DISCIPLINES & CAPABILITIES
       ========================================================================= -->
  <section class="svc-sec" id="disciplines">
    <div class="svc-shell">
      <div class="svc-head">
        <p class="svc-eyebrow"><span class="svc-pulse" aria-hidden="true"></span>Core Engineering Disciplines</p>
        <h2 class="svc-title">Six enterprise AI integration disciplines<br>for <em>modern software</em></h2>
        <p class="svc-sub">From non-invasive sidecars to streaming SSE bridges and hybrid multi-cloud topologies.</p>
      </div>

      <?php /* The 6 images for this section, shown in depth rather than as
               card corners. Falls back to a plain grid of the same images if the
               island never mounts -- see includes/components/svc-gallery.php. */ ?>
      <?php component('svc-gallery', [
          'images'  => array_filter([svc_img('12', 3, 1), svc_img('12', 3, 2), svc_img('12', 3, 3), svc_img('12', 3, 4), svc_img('12', 3, 5), svc_img('12', 3, 6)]),
          'variant' => 'deck',
          'label'   => 'Capability visuals',
      ]); ?>
      <div class="svc-cards-grid">
        <?php foreach ($disciplines as $i => [$num, $dTitle, $dDesc]): ?>
          <?php $fig = null; /* shown by the gallery above this grid */ ?>
          <article class="svc-card<?= $fig ? ' svc-card--figured' : '' ?>">
            <?php if ($fig): ?>
              <figure class="svc-card-fig">
                <img src="<?= e($fig) ?>" width="800" height="450" alt=""
                     loading="lazy" decoding="async">
              </figure>
            <?php endif; ?>
            <span class="svc-card-num"><?= e($num) ?></span>
            <h3><?= e($dTitle) ?></h3>
            <p><?= e($dDesc) ?></p>
            <ul class="svc-card-tags">
              <li>Production Ready</li>
              <li>Private VPC</li>
              <li>Deterministic</li>
            </ul>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- =========================================================================
       MID CTA BAND
       ========================================================================= -->
  <section class="svc-band">
    <div class="svc-shell">
      <h2>Deploy production-grade enterprise intelligence<br><em>engineered for measurable operational ROI</em></h2>
      <div class="svc-actions svc-actions--mid">
        <button class="svc-btn svc-btn--primary" type="button"
                data-modal-open data-modal-service="Enterprise AI Integration & Legacy System Modernization">
          Schedule Technical Consultation<?= icon('arrow') ?>
        </button>
      </div>
    </div>
  </section>

  <!-- =========================================================================
       5 STRATEGIC BUSINESS ADVANTAGES
       ========================================================================= -->
  <section class="svc-sec svc-sec--dark" id="benefits">
    <div class="svc-shell">
      <div class="svc-head">
        <p class="svc-eyebrow"><span class="svc-pulse" aria-hidden="true"></span>Strategic Impact</p>
        <h2 class="svc-title">Five strategic business advantages<br>of our <em>Ai Integration</em></h2>
        <p class="svc-sub">
          Explore the architectural advantages that guarantee high concurrency, zero data leakage, and rapid payback timelines.
        </p>
      </div>

      <?php /* The 5 images for this section, shown in depth rather than as
               card corners. Falls back to a plain grid of the same images if the
               island never mounts -- see includes/components/svc-gallery.php. */ ?>
      <?php component('svc-gallery', [
          'images'  => array_filter([svc_img('12', 5, 1), svc_img('12', 5, 2), svc_img('12', 5, 3), svc_img('12', 5, 4), svc_img('12', 5, 5)]),
          'variant' => 'coverflow',
          'label'   => 'Business impact visuals',
      ]); ?>
      <div class="svc-benefits-grid">
        <?php foreach ($benefits as $i => [$num, $bTitle, $bDesc]): ?>
          <?php $fig = null; /* shown by the gallery above this grid */ ?>
          <div class="svc-benefit-card<?= $fig ? ' svc-benefit-card--figured' : '' ?>">
            <?php if ($fig): ?>
              <figure class="svc-card-fig">
                <img src="<?= e($fig) ?>" width="800" height="450" alt=""
                     loading="lazy" decoding="async">
              </figure>
            <?php endif; ?>
            <span class="svc-card-num"><?= e($num) ?></span>
            <h3><?= e($bTitle) ?></h3>
            <p><?= e($bDesc) ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- =========================================================================
       5-STEP PRODUCTION ROADMAP
       ========================================================================= -->
  <section class="svc-sec" id="process">
    <div class="svc-shell">
      <div class="svc-head">
        <p class="svc-eyebrow"><span class="svc-pulse" aria-hidden="true"></span>Production Lifecycle</p>
        <h2 class="svc-title">Five-step roadmap from<br><em>discovery to production scale</em></h2>
        <p class="svc-sub">
          A disciplined, milestone-driven engineering methodology designed to validate feasibility and deploy at enterprise scale.
        </p>
      </div>

      <?php $GLOBALS['ithrive_needs_roadmap'] = true; ?>
      <div class="svc-roadmap" data-roadmap="hub" aria-hidden="true">
        <?php foreach ($steps as $idx => [$num, $sTitle]): ?>
          <span data-roadmap-node="<?= $idx ?>" data-label="<?= e($sTitle) ?>"></span>
        <?php endforeach; ?>
      </div>
      <?php /* The 3 images for this section, shown in depth rather than as
               card corners. Falls back to a plain grid of the same images if the
               island never mounts -- see includes/components/svc-gallery.php. */ ?>
      <?php component('svc-gallery', [
          'images'  => array_filter([svc_img('12', 6, 1), svc_img('12', 6, 2), svc_img('12', 6, 3)]),
          'variant' => 'stack',
          'label'   => 'Delivery phase visuals',
      ]); ?>


      <div class="svc-steps-grid">
        <?php 
        $durations = ['Week 1–2', 'Week 3–4', 'Week 5–6', 'Week 7–8', 'Continuous'];
        foreach ($steps as $idx => [$num, $sTitle, $sDesc]): 
        ?>
          <div class="svc-step-card" data-roadmap-step="<?= $idx ?>">
            <div class="svc-step-header">
              <span class="svc-step-phase">Phase <?= e($num) ?></span>
              <span class="svc-step-duration"><?= e($durations[$idx % 5]) ?></span>
            </div>
            <h3><?= e($sTitle) ?></h3>
            <p><?= e($sDesc) ?></p>
            <div class="svc-step-out">Verified Deliverable</div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- =========================================================================
       3 COMMERCIAL ENGAGEMENT MODELS
       ========================================================================= -->
  <section class="svc-sec svc-sec--dark" id="models">
    <div class="svc-shell">
      <div class="svc-head">
        <p class="svc-eyebrow"><span class="svc-pulse" aria-hidden="true"></span>Commercial Frameworks</p>
        <h2 class="svc-title">Three ways to engage our<br><em>Ai Integration Practice</em></h2>
        <p class="svc-sub">
          Flexible commercial models designed to scale smoothly from rapid proof of concept to dedicated enterprise squads.
        </p>
      </div>

      <div class="svc-models-grid">
        <?php 
        $tags = ['— RAPID SPRINT', '— PRODUCTION SUITE', '— DEDICATED SQUAD'];
        foreach ($models as $idx => [$num, $mTitle, $mDesc, $mFeats]): 
        ?>
          <div class="svc-model-card">
            <span class="svc-model-tag"><?= e($tags[$idx % 3]) ?></span>
            <h3><?= e($mTitle) ?></h3>
            <p><?= e($mDesc) ?></p>
            <ul class="svc-model-features">
              <?php foreach ($mFeats as $feat): ?>
                <li><?= icon('check') ?> <?= e($feat) ?></li>
              <?php endforeach; ?>
            </ul>
            <button class="svc-btn svc-btn--ghost" type="button"
                    data-modal-open data-modal-service="Enterprise AI Integration & Legacy System Modernization (Model <?= e($num) ?>)">
              Choose Model <?= e($num) ?><?= icon('arrow') ?>
            </button>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- =========================================================================
       TECH STACK ARENA
       ========================================================================= -->
  <section class="svc-sec" id="stack">
    <div class="svc-shell">
      <div class="svc-head svc-head--mid">
        <p class="svc-eyebrow"><span class="svc-pulse" aria-hidden="true"></span>Technology Stack</p>
        <h2 class="svc-title">Production frameworks &amp; models<br><em>powering our systems</em></h2>
        <p class="svc-sub">
          Battle-tested libraries, private foundation models, and distributed vector infrastructure.
        </p>
      </div>

      <?php component('tech-stack', ['groups' => $pageStack]); ?>
    </div>
  </section>

  <!-- =========================================================================
       10 IN-DEPTH TECHNICAL FAQS
       ========================================================================= -->
  <section class="svc-sec svc-sec--dark" id="faq">
    <div class="svc-shell">
      <div class="svc-faq-grid">
        <div class="svc-faq-side">
          <p class="svc-eyebrow"><span class="svc-pulse" aria-hidden="true"></span>Enterprise FAQ</p>
          <h2 class="svc-title">Frequently Asked<br><em>Technical Questions</em></h2>
          <p class="svc-sub">
            In-depth answers covering data privacy, latency, model selection, and production integration.
          </p>
          <figure class="svc-faq-art">
            <img src="<?= e(asset('assets/img/services/svc-12-ai-integration.jpg')) ?>" width="900" height="700"
                 alt="Enterprise AI Integration & Legacy System Modernization FAQ Consultation" loading="lazy" decoding="async">
          </figure>
        </div>

        <div class="svc-faq-list">
          <?php foreach ($faqs as $i => [$q, $a]): ?>
            <details class="svc-faq-item"<?= $i === 0 ? ' open' : '' ?>>
              <summary>
                <span><?= e($q) ?></span>
                <span class="svc-faq-indicator" aria-hidden="true"></span>
              </summary>
              <div class="svc-faq-body">
                <p><?= e($a) ?></p>
              </div>
            </details>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </section>

  <!-- =========================================================================
       CLOSING CONSULTATION CTA
       ========================================================================= -->
  <section class="svc-close">
    <div class="svc-shell svc-close-inner">
      <p class="svc-eyebrow"><span class="svc-pulse" aria-hidden="true"></span>Get Started</p>
      <h2>Ready to build or scale your<br><em>Ai Integration System?</em></h2>
      <p class="svc-close-lead">
        Discuss your technical requirements, latency constraints, and data governance policies directly with our Lead AI Systems Architects. Receive an actionable feasibility audit and prototype blueprint within 48 hours.
      </p>
      <div class="svc-actions svc-actions--mid">
        <button class="svc-btn svc-btn--primary" type="button"
                data-modal-open data-modal-service="Enterprise AI Integration & Legacy System Modernization">
          Start 48-Hour Technical Discovery<?= icon('arrow') ?>
        </button>
      </div>
    </div>
  </section>

</div>

<?php
require dirname(__DIR__) . '/includes/footer.php';
