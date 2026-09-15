<?php
/**
 * Agentic AI Integration & Enterprise Middleware Services
 *
 * Enterprise AI Service Page engineered with modern dark cyber UI,
 * 6 Core Capabilities, 5 Strategic ROI Advantages, 5-Step Process Roadmap,
 * 3 Deployment Frameworks, Tech Stack Arena, and 10 Detailed FAQs with Schema.org JSON-LD.
 */

declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/config.php';

$page         = 'services';
$pageTitle    = 'Agentic AI Integration & Enterprise Middleware Services';
$pageDesc     = 'Seamlessly connect autonomous agents to legacy databases, ERP systems, CRM pipelines, and external APIs via Model Context Protocol (MCP) and secure microservices.';
$ogImage      = 'assets/img/services/svc-11-agentic-integration.jpg';

/* ---------------------------------------------------------------------------
 * Content Definitions
 * ------------------------------------------------------------------------ */

$stats = [['150+', 'Enterprise System Connectors'], ['<20ms', 'Middleware Proxy Latency'], ['100%', 'Zero-Trust Data Governance'], ['99.99%', 'Message Delivery Reliability']];

$disciplines = [['01', 'Model Context Protocol (MCP) Server Engineering', 'Building robust, standardized MCP servers that expose your internal databases, tools, and business APIs to any MCP-compliant agent.'], ['02', 'Secure Enterprise API Gateways & Token Brokering', 'Implementing high-performance API gateways that manage short-lived authentication tokens, rate limits, and RBAC permissions for agent tool calls.'], ['03', 'Bi-Directional Database & Change Data Capture (CDC)', 'Real-time streaming integration with PostgreSQL, MySQL, MongoDB, and Snowflake via Debezium and Kafka for instant vector synchronization.'], ['04', 'Non-Invasive Sidecar Architecture for Legacy Systems', 'Deploying lightweight sidecar proxies alongside legacy mainframes and ERPs, adding AI capabilities without modifying core legacy code.'], ['05', 'Event-Driven Webhook & Pub/Sub Meshes', 'Architecting asynchronous event meshes that trigger autonomous agent workflows instantly upon CRM updates, email receipts, or system alerts.'], ['06', 'Zero-Trust Auditing & Transaction Rollback', 'Configuring atomic database transactions, immutable audit logging, and automated rollback mechanisms for agent-initiated modifications.']];

$benefits = [['01', 'Standardized & Future-Proof Connectivity', 'Adopt open Model Context Protocol (MCP) standards, preventing vendor lock-in with proprietary agent frameworks.'], ['02', 'Zero-Trust Enterprise Security', 'Agents never access raw credentials; all actions are governed by strict token scopes, rate limits, and audit logs.'], ['03', 'Non-Invasive Legacy Modernization', 'Add cutting-edge autonomous capabilities to older ERP and CRM systems without risky, costly codebase rewrites.'], ['04', 'Sub-20ms Ultra-Low Latency Execution', 'Optimized Go and Python middleware gateways ensure instantaneous data retrieval and tool execution.'], ['05', 'Deterministic Error Handling & Rollbacks', 'Failed tool executions are caught gracefully with automatic state rollbacks, preventing database corruption.']];

$steps = [['01', 'Enterprise System & API Inventory', 'Auditing target applications (SAP, Salesforce, Jira, DBs), authentication protocols, and mapping required agent tool scopes.'], ['02', 'MCP Server & Gateway Architecture', 'Designing Model Context Protocol (MCP) servers, API data schemas, Pydantic type validators, and security proxies.'], ['03', 'Sandbox Connector Development & Testing', 'Building and benchmarking middleware connectors in an isolated staging environment with mock enterprise data.'], ['04', 'Security Audit & RBAC Configuration', 'Enforcing least-privilege token brokering, rate limiting, PII redaction, and compliance logging.'], ['05', 'Production Deployment & CDC Streaming', 'Deploying containerized MCP clusters on Kubernetes with real-time Change Data Capture and OpenTelemetry monitoring.']];

$models = [['01', 'MCP Gateway Sprint', 'A 3-week sprint developing and deploying standardized MCP server connectors for your core databases and primary CRM/ERP.', ['3-week implementation', 'Up to 5 enterprise connectors', 'Full MCP compliance']], ['02', 'Enterprise Agentic Middleware Platform', 'Full-scale integration platform connecting agents to dozens of enterprise services with bi-directional CDC streaming and RBAC.', ['Full CDC event streaming', 'Zero-trust auth gateway', 'Sub-20ms latency SLA']], ['03', 'Retained Integration & AgentOps Support', 'Continuous maintenance of enterprise connectors, API version upgrades, security patch management, and 24/7 monitoring.', ['Ongoing API maintenance', 'Dedicated integration engineer', '24/7 SLA & support']]];

$techStack = ['Model Context Protocol (MCP)', 'FastAPI', 'Go', 'gRPC', 'Kafka', 'Debezium', 'PostgreSQL', 'Redis', 'Docker', 'Kubernetes'];

$pageStack = [
    ['slug' => 'integration', 'title' => 'Contract Layer', 'icon' => 'workflow',
     'blurb' => 'One typed surface in front of every system.',
     'items' => [
         ['name' => 'FastAPI', 'logo' => 'fastapi'],
         ['name' => 'Node.js', 'logo' => 'nodedotjs'],
         ['name' => 'GraphQL', 'logo' => 'graphql'],
         ['name' => 'Python', 'logo' => 'python'],
     ]],
    ['slug' => 'systems', 'title' => 'Systems of Record', 'icon' => 'database',
     'blurb' => 'The ERP, CRM and databases the agent reaches.',
     'items' => [
         ['name' => 'PostgreSQL', 'logo' => 'postgresql'],
         ['name' => 'MySQL', 'logo' => 'mysql'],
         ['name' => 'MongoDB', 'logo' => 'mongodb'],
         ['name' => 'Redis', 'logo' => 'redis'],
     ]],
    ['slug' => 'platform', 'title' => 'Delivery & Operations', 'icon' => 'cloud',
     'blurb' => 'Scoped credentials, idempotent writes, a full trail.',
     'items' => [
         ['name' => 'Docker', 'logo' => 'docker'],
         ['name' => 'Kubernetes', 'logo' => 'kubernetes'],
         ['name' => 'Terraform', 'logo' => 'terraform'],
         ['name' => 'GitHub Actions', 'logo' => 'githubactions'],
     ]],
];

$faqs = [['What is Model Context Protocol (MCP) and why is it essential for agent integration?', 'Model Context Protocol (MCP) is an open standard that unifies how AI models and agents securely connect to external tools, databases, and enterprise systems. It provides a standardized client-server protocol, eliminating the need to write fragile custom integrations for every new agent or LLM.'], ["How do you ensure agents don't accidentally corrupt or delete production database records?", 'We enforce strict security controls: read-only database replicas for data queries, parameterized queries that eliminate SQL injection, schema-level permission boundaries, and atomic transaction wrappers that automatically rollback on error.'], ['Can you connect autonomous AI agents to legacy on-premise ERP systems like SAP or AS/400?', 'Yes. We deploy lightweight sidecar proxies and message queues inside your secure network that translate modern REST/gRPC/MCP agent requests into legacy RPC, SOAP, or database protocols.'], ['How do agents receive real-time updates when data changes in our CRM or database?', 'We configure Change Data Capture (CDC) pipelines using Debezium and Kafka. When a record changes in your database or CRM, a webhook or event is published immediately to the agentic event mesh.'], ['How do you manage authentication and API keys for AI agents?', 'Agents authenticate via an OAuth2/mTLS token broker that generates short-lived, least-privilege access tokens. Agents never see master secrets or root credentials.'], ['What latency does your agentic middleware add to tool execution?', 'Our Go and FastAPI middleware proxies are engineered for high-concurrency enterprise workloads, adding less than 20ms of overhead to tool calls.'], ['Can your integration handle high-volume batch processing across millions of records?', 'Yes. We implement asynchronous worker pools and Redis task queues that process millions of records in parallel with automatic rate-limit throttling to prevent downstream system overload.'], ['How do you redact sensitive customer PII before sending context to AI agents?', 'Our middleware includes an automated PII redaction layer that masks credit card numbers, social security numbers, and health records in real time before data enters the agent context.'], ['Can we deploy the agentic integration layer inside our private cloud?', 'Yes. All MCP servers, gateways, and message brokers are fully containerized with Docker and Helm charts for seamless deployment inside your AWS, Azure, GCP VPC, or on-premise data center.'], ['How long does it take to integrate an autonomous agent with our enterprise systems?', 'Standard integrations for popular systems (Salesforce, PostgreSQL, Jira, Slack) take 1 to 2 weeks. Custom legacy ERP or proprietary database integrations typically take 3 to 4 weeks.']];

/** Schema.org Structured Data with FAQPage & Service */
$schema = [
    '@context' => 'https://schema.org',
    '@graph' => [
        [
            '@type' => 'Service',
            'name' => 'Agentic AI Integration & Enterprise Middleware Services',
            'serviceType' => 'Enterprise Integration & Systems',
            'description' => 'Seamlessly connect autonomous agents to legacy databases, ERP systems, CRM pipelines, and external APIs via Model Context Protocol (MCP) and secure microservices.',
            'url' => canonical('services/agentic-ai-integration.php'),
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

<div class="svc-page" data-theme="contract">

  <!-- =========================================================================
       HERO SECTION: Cyber Eyebrow, Gradient Headline & Action CTAs
       ========================================================================= -->
  <section class="svc-hero">
    <div class="svc-shell svc-hero-inner">
      <p class="svc-eyebrow"><span class="svc-pulse" aria-hidden="true"></span>Agentic Middleware & MCP · Zero-Trust Integration</p>

      <h1 class="svc-h1">
        Agentic AI Integration For<br><em>Unified Enterprise Connectivity</em>
      </h1>

      <p class="svc-lead">
        Seamlessly connect autonomous agents to legacy databases, ERP systems, CRM pipelines, and external APIs via Model Context Protocol (MCP) and secure microservices.
      </p>

      <div class="svc-actions svc-actions--mid">
        <button class="svc-btn svc-btn--primary" type="button"
                data-modal-open data-modal-service="Agentic AI Integration & Enterprise Middleware Services">
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
        <img src="<?= e(asset('assets/img/services/svc-11-agentic-integration.jpg')) ?>" width="1200" height="700"
             alt="Agentic AI Integration & Enterprise Middleware Services Architecture" fetchpriority="high" decoding="async">
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
          <h2 class="svc-title">Agents without integrations are isolated toys;<br><em>connected agents drive business value</em></h2>
        </div>
        <div class="svc-open-copy">
          <p>Deploying an autonomous agent is useless if it cannot securely read your PostgreSQL database, trigger an SAP inventory update, query Salesforce, or execute a Jira ticket action. Custom point-to-point glue code is brittle, hard to maintain, and creates dangerous security vulnerabilities.</p>
          <p>We engineer robust Agentic AI Integration middleware that connects autonomous agents to your entire enterprise software ecosystem. Using the standardized Model Context Protocol (MCP), secure sidecar microservices, and event-driven webhooks, we enable agents to interact with your legacy systems safely, deterministically, and with zero-trust governance.</p>
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
        <h2 class="svc-title">Six agentic integration disciplines<br>for <em>enterprise connectivity</em></h2>
        <p class="svc-sub">From Model Context Protocol (MCP) servers to secure database proxies and event streaming.</p>
      </div>

      <?php /* The 6 images for this section, shown in depth rather than as
               card corners. Falls back to a plain grid of the same images if the
               island never mounts -- see includes/components/svc-gallery.php. */ ?>
      <?php component('svc-gallery', [
          'images'  => array_filter([svc_img('11', 3, 1), svc_img('11', 3, 2), svc_img('11', 3, 3), svc_img('11', 3, 4), svc_img('11', 3, 5), svc_img('11', 3, 6)]),
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
                data-modal-open data-modal-service="Agentic AI Integration & Enterprise Middleware Services">
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
        <h2 class="svc-title">Five strategic business advantages<br>of our <em>Agentic Ai Integration</em></h2>
        <p class="svc-sub">
          Explore the architectural advantages that guarantee high concurrency, zero data leakage, and rapid payback timelines.
        </p>
      </div>

      <?php /* The 5 images for this section, shown in depth rather than as
               card corners. Falls back to a plain grid of the same images if the
               island never mounts -- see includes/components/svc-gallery.php. */ ?>
      <?php component('svc-gallery', [
          'images'  => array_filter([svc_img('11', 5, 1), svc_img('11', 5, 2), svc_img('11', 5, 3), svc_img('11', 5, 4), svc_img('11', 5, 5)]),
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
      <div class="svc-roadmap" data-roadmap="couple" aria-hidden="true">
        <?php foreach ($steps as $idx => [$num, $sTitle]): ?>
          <span data-roadmap-node="<?= $idx ?>" data-label="<?= e($sTitle) ?>"></span>
        <?php endforeach; ?>
      </div>
      <?php /* The 3 images for this section, shown in depth rather than as
               card corners. Falls back to a plain grid of the same images if the
               island never mounts -- see includes/components/svc-gallery.php. */ ?>
      <?php component('svc-gallery', [
          'images'  => array_filter([svc_img('11', 6, 1), svc_img('11', 6, 2), svc_img('11', 6, 3)]),
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
        <h2 class="svc-title">Three ways to engage our<br><em>Agentic Ai Integration Practice</em></h2>
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
                    data-modal-open data-modal-service="Agentic AI Integration & Enterprise Middleware Services (Model <?= e($num) ?>)">
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
            <img src="<?= e(asset('assets/img/services/svc-11-agentic-integration.jpg')) ?>" width="900" height="700"
                 alt="Agentic AI Integration & Enterprise Middleware Services FAQ Consultation" loading="lazy" decoding="async">
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
      <h2>Ready to build or scale your<br><em>Agentic Ai Integration System?</em></h2>
      <p class="svc-close-lead">
        Discuss your technical requirements, latency constraints, and data governance policies directly with our Lead AI Systems Architects. Receive an actionable feasibility audit and prototype blueprint within 48 hours.
      </p>
      <div class="svc-actions svc-actions--mid">
        <button class="svc-btn svc-btn--primary" type="button"
                data-modal-open data-modal-service="Agentic AI Integration & Enterprise Middleware Services">
          Start 48-Hour Technical Discovery<?= icon('arrow') ?>
        </button>
      </div>
    </div>
  </section>

</div>

<?php
require dirname(__DIR__) . '/includes/footer.php';
