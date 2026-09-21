<?php
/**
 * Custom AI Agent Development & Autonomous Tool Engineering
 *
 * Enterprise AI Service Page engineered with modern dark cyber UI,
 * 6 Core Capabilities, 5 Strategic ROI Advantages, 5-Step Process Roadmap,
 * 3 Deployment Frameworks, Tech Stack Arena, and 10 Detailed FAQs with Schema.org JSON-LD.
 */

declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/config.php';

$page         = 'services';
$pageTitle    = 'Custom AI Agent Development Services';
$pageDesc     = 'Custom AI agent development with persistent memory, typed tool binding, LangGraph state machines and multi-step reasoning — built for your systems.';
$ogImage      = 'assets/img/services/svc-08-custom-agents.jpg';

/* ---------------------------------------------------------------------------
 * Content Definitions
 * ------------------------------------------------------------------------ */

$stats = [['<300ms', 'Agent Reaction Time'], ['99.8%', 'Tool Execution Accuracy'], ['500+', 'Custom Tool Connectors'], ['24/7', 'Autonomous Execution Uptime']];

$disciplines = [['01', 'Dynamic Tool & API Binding', 'Writing high-precision OpenAPI schemas and Model Context Protocol (MCP) server endpoints allowing agents to execute complex queries and transactions.'], ['02', 'Persistent Memory & Knowledge Graph State', 'Implementing dual memory architectures combining short-term working state memory with long-term vector embeddings and user entity graphs.'], ['03', 'LangGraph Cyclical Reasoning Loops', 'Constructing cyclic state graphs with conditional edge branching, state checkpointing, and dynamic retry mechanisms for complex problem solving.'], ['04', 'Multimodal Input & Document Ingestion', 'Equipping agents to parse and reason across PDFs, spreadsheets, technical blueprints, voice recordings, and video feeds in real time.'], ['05', 'Self-Correction & Reflection Engines', 'Embedding critic agents and automated validation loops that review outputs against business rules before committing changes to production.'], ['06', 'Human-in-the-Loop Threshold Gateways', 'Configuring fine-grained confidence score gates that route ambiguous or high-risk actions to human reviewers via Slack or Microsoft Teams.']];

$benefits = [['01', 'Tailored to Proprietary Business Logic', 'Agents reason with deep context of your internal nomenclature, data models, and standard operating procedures.'], ['02', 'Flawless API & Database Execution', 'Zero-error tool calling with Pydantic type validation, schema enforcement, and transaction rollbacks.'], ['03', 'Persistent Long-Term Memory', 'Agents remember user preferences, historical project decisions, and corporate context across months of interactions.'], ['04', '24/7 Autonomous Task Resolution', 'Continuous background execution that processes queues, syncs data, and handles customer inquiries without human downtime.'], ['05', 'Private Cloud & Air-Gapped Security', 'Deployable entirely inside your private VPC or on-premise infrastructure with zero external data leakage.']];

$steps = [['01', 'SOP Discovery & Tool Inventory', 'Analyzing your operational workflows, mapping required software tools, and drafting comprehensive agent action specifications.'], ['02', 'Agent State Graph & Prompt Engineering', 'Designing LangGraph state machines, few-shot prompt libraries, and deterministic reflection guardrails.'], ['03', 'Custom Tool & MCP Development', 'Building secure REST/GraphQL API wrappers, database connectors, and Wasm/Docker execution sandboxes.'], ['04', 'Supervised Sandbox Benchmarking', 'Testing the custom agent on historical edge cases, measuring tool selection accuracy, latency, and failure recovery.'], ['05', 'Production Deployment & Telemetry', 'Deploying high-availability agent clusters with OpenTelemetry tracing, LangSmith observability, and 24/7 health monitoring.']];

$models = [['01', 'Single Specialized Custom Agent', 'A 3-week engagement delivering a dedicated autonomous agent fine-tuned for a single high-impact workflow (e.g., automated QA or invoice triage).', ['3-week sprint', 'Custom tool connectors', 'Full LangSmith telemetry']], ['02', 'Autonomous Agent Squad', 'A 6-week project engineering a coordinated multi-agent squad integrated with your CRM, ERP, and internal databases.', ['Multi-agent collaboration', 'Custom vector memory', 'Human-in-the-loop dashboard']], ['03', 'Dedicated Agent Engineering Squad', 'An ongoing dedicated engineering squad continuously building, expanding, and optimizing custom agents across all company departments.', ['Dedicated LangGraph engineers', 'Continuous tool development', '24/7 SLA & maintenance']]];

$techStack = ['LangGraph', 'Pydantic', 'FastAPI', 'MCP', 'Qdrant', 'PostgreSQL', 'Docker', 'LangSmith', 'Python', 'Redis'];

$pageStack = [
    ['slug' => 'agents', 'title' => 'Agent Runtime', 'icon' => 'bot',
     'blurb' => 'Tools, state and the loop that decides the next step.',
     'items' => [
         ['name' => 'LangChain', 'logo' => 'langchain'],
         ['name' => 'OpenAI', 'logo' => 'openai'],
         ['name' => 'Anthropic', 'logo' => 'anthropic'],
         ['name' => 'Python', 'logo' => 'python'],
     ]],
    ['slug' => 'services', 'title' => 'Services & State', 'icon' => 'database',
     'blurb' => 'What the agent calls, and what it remembers.',
     'items' => [
         ['name' => 'FastAPI', 'logo' => 'fastapi'],
         ['name' => 'Celery', 'logo' => 'celery'],
         ['name' => 'Redis', 'logo' => 'redis'],
         ['name' => 'PostgreSQL', 'logo' => 'postgresql'],
     ]],
    ['slug' => 'platform', 'title' => 'Platform & Operations', 'icon' => 'cloud',
     'blurb' => 'Deployment, traces and a costed run.',
     'items' => [
         ['name' => 'Docker', 'logo' => 'docker'],
         ['name' => 'Kubernetes', 'logo' => 'kubernetes'],
         ['name' => 'Terraform', 'logo' => 'terraform'],
         ['name' => 'Grafana', 'logo' => 'grafana'],
     ]],
];

$faqs = [['What is a custom AI agent and how does it work?', 'A custom AI agent is an autonomous software program that combines a reasoning LLM with memory, planning state machines (like LangGraph), and custom tool integrations (APIs, databases). It receives a high-level goal, breaks it into sequential steps, calls external tools to gather data or execute actions, verifies its own work, and completes the task autonomously.'], ['How do you ensure agents execute tool calls and API requests accurately?', 'We use strict Pydantic schema validation, structured JSON outputs, deterministic error-handling fallbacks, and multi-step verification checks to ensure every tool call matches exact API requirements before execution.'], ['What systems and software can your custom agents integrate with?', 'Our agents can integrate with virtually any system with an API or database: Jira, GitHub, Salesforce, HubSpot, Zoho, SAP, NetSuite, PostgreSQL, Snowflake, Twilio, Slack, and custom in-house enterprise backends.'], ['How do agents maintain memory across different sessions and conversations?', 'We implement a dual-layer memory system: short-term state memory stored in Redis/PostgreSQL checkpoints, and long-term semantic memory stored in vector databases (Qdrant, pgvector) with entity-relationship knowledge graphs.'], ['How do you handle security and credential management for agent tool execution?', 'Agents never receive raw API keys or database passwords. All tool calls route through an authenticated proxy/MCP server with short-lived tokens, rate limiting, and role-based access control.'], ['Can custom agents write code, execute scripts, or run database queries safely?', 'Yes. For code or query execution, we run agents inside ephemeral, sandboxed Docker containers or WebAssembly (Wasm) micro-VMs with strict network isolation and resource limits.'], ['How does the agent handle ambiguous user instructions or edge cases?', 'When confidence scores fall below a predefined threshold, the agent pauses execution, formulates clarifying questions, or escalates the task to a human supervisor via Slack or Teams.'], ['Can we deploy our custom agents on our private cloud or on-premise hardware?', 'Yes. Our custom agents can be containerized and deployed on Kubernetes inside your private AWS, GCP, Azure VPC, or on-premise data center with zero data egress.'], ['What frameworks do you use to build custom AI agents?', 'We primarily use LangGraph, Python, FastAPI, Model Context Protocol (MCP), Pydantic, Redis, and LangSmith for state-of-the-art enterprise reliability and observability.'], ['How long does it take to build and deploy a custom AI agent into production?', 'A single specialized custom agent is typically production-ready in 3 to 4 weeks. Complex multi-agent systems with extensive enterprise integrations take 6 to 8 weeks.']];

/** Schema.org Structured Data with FAQPage & Service */
$schema = [
    '@context' => 'https://schema.org',
    '@graph' => [
        [
            '@type' => 'Service',
            'name' => 'Custom AI Agent Development & Autonomous Tool Engineering',
            'serviceType' => 'Agentic AI & Swarm Engineering',
            'description' => 'Engineering bespoke autonomous agents with persistent memory, dynamic tool binding, LangGraph state machines, and multi-step cognitive reasoning pipelines.',
            'url' => canonical('services/custom-agent-development.php'),
            'provider' => [
                '@type' => 'Organization',
                'name' => SITE_NAME,
                'url' => canonical('')
            ],
            'areaServed' => areas_served()
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

<div class="svc-page" data-theme="workshop">

  <!-- =========================================================================
       HERO SECTION: Cyber Eyebrow, Gradient Headline & Action CTAs
       ========================================================================= -->
  <section class="svc-hero">
    <div class="svc-shell svc-hero-inner">
      <p class="svc-eyebrow"><span class="svc-pulse" aria-hidden="true"></span>Custom Autonomous Agents · Bespoke Tool & API Binding</p>

      <h1 class="svc-h1">
        Custom AI Agent Development For<br><em>Autonomous Operational Execution</em>
      </h1>

      <p class="svc-lead">
        Engineering bespoke autonomous agents with persistent memory, dynamic tool binding, LangGraph state machines, and multi-step cognitive reasoning pipelines.
      </p>

      <div class="svc-actions svc-actions--mid">
        <button class="svc-btn svc-btn--primary" type="button"
                data-modal-open data-modal-service="Custom AI Agent Development & Autonomous Tool Engineering">
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
        <img src="<?= e(asset('assets/img/services/svc-08-custom-agents.jpg')) ?>" width="1200" height="700"
             alt="Custom AI Agent Development & Autonomous Tool Engineering Architecture" fetchpriority="high" decoding="async">
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
          <h2 class="svc-title">Generic AI tools lack domain mastery;<br><em>custom agents execute with precision</em></h2>
        </div>
        <div class="svc-open-copy">
          <p>Off-the-shelf chatbots cannot understand proprietary ERP data schemas, complex multi-step SOPs, or internal database relationships. When forced into complex enterprise workflows, generic AI breaks down due to lack of domain context and inability to execute reliable software tool calls.</p>
          <p>We engineer tailor-made autonomous AI agents specifically fine-tuned for your business logic, APIs, and operational workflows. Built on robust LangGraph state machines with persistent vector memory and secure tool-calling harnesses, our custom agents plan, execute, verify, and complete complex multi-system tasks around the clock.</p>
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
        <h2 class="svc-title">Six custom agent engineering disciplines<br>for <em>enterprise autonomy</em></h2>
        <p class="svc-sub">From custom tool binding to persistent contextual memory and self-correcting execution.</p>
      </div>

      <?php /* The 6 images for this section, shown in depth rather than as
               card corners. Falls back to a plain grid of the same images if the
               island never mounts -- see includes/components/svc-gallery.php. */ ?>
      <?php component('svc-gallery', [
          'images'  => array_filter([svc_img('08', 3, 1), svc_img('08', 3, 2), svc_img('08', 3, 3), svc_img('08', 3, 4), svc_img('08', 3, 5), svc_img('08', 3, 6)]),
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
                data-modal-open data-modal-service="Custom AI Agent Development & Autonomous Tool Engineering">
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
        <h2 class="svc-title">Five strategic business advantages<br>of our <em>Custom Agent Development</em></h2>
        <p class="svc-sub">
          Explore the architectural advantages that guarantee high concurrency, zero data leakage, and rapid payback timelines.
        </p>
      </div>

      <?php /* The 5 images for this section, shown in depth rather than as
               card corners. Falls back to a plain grid of the same images if the
               island never mounts -- see includes/components/svc-gallery.php. */ ?>
      <?php component('svc-gallery', [
          'images'  => array_filter([svc_img('08', 5, 1), svc_img('08', 5, 2), svc_img('08', 5, 3), svc_img('08', 5, 4), svc_img('08', 5, 5)]),
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
      <div class="svc-roadmap" data-roadmap="stack" aria-hidden="true">
        <?php foreach ($steps as $idx => [$num, $sTitle]): ?>
          <span data-roadmap-node="<?= $idx ?>" data-label="<?= e($sTitle) ?>"></span>
        <?php endforeach; ?>
      </div>
      <?php /* The 3 images for this section, shown in depth rather than as
               card corners. Falls back to a plain grid of the same images if the
               island never mounts -- see includes/components/svc-gallery.php. */ ?>
      <?php component('svc-gallery', [
          'images'  => array_filter([svc_img('08', 6, 1), svc_img('08', 6, 2), svc_img('08', 6, 3)]),
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
        <h2 class="svc-title">Three ways to engage our<br><em>Custom Agent Development Practice</em></h2>
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
                    data-modal-open data-modal-service="Custom AI Agent Development & Autonomous Tool Engineering (Model <?= e($num) ?>)">
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
            <img src="<?= e(asset('assets/img/services/svc-08-custom-agents.jpg')) ?>" width="900" height="700"
                 alt="Custom AI Agent Development & Autonomous Tool Engineering FAQ Consultation" loading="lazy" decoding="async">
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
      <h2>Ready to build or scale your<br><em>Custom Agent Development System?</em></h2>
      <p class="svc-close-lead">
        Discuss your technical requirements, latency constraints, and data governance policies directly with our Lead AI Systems Architects. Receive an actionable feasibility audit and prototype blueprint within 48 hours.
      </p>
      <div class="svc-actions svc-actions--mid">
        <button class="svc-btn svc-btn--primary" type="button"
                data-modal-open data-modal-service="Custom AI Agent Development & Autonomous Tool Engineering">
          Start 48-Hour Technical Discovery<?= icon('arrow') ?>
        </button>
      </div>
    </div>
  </section>

</div>

<?php
require dirname(__DIR__) . '/includes/footer.php';
