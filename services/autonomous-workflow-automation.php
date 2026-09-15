<?php
/**
 * Autonomous Workflow Automation & Self-Healing Agentic Pipelines
 *
 * Enterprise AI Service Page engineered with modern dark cyber UI,
 * 6 Core Capabilities, 5 Strategic ROI Advantages, 5-Step Process Roadmap,
 * 3 Deployment Frameworks, Tech Stack Arena, and 10 Detailed FAQs with Schema.org JSON-LD.
 */

declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/config.php';

$page         = 'services';
$pageTitle    = 'Autonomous Workflow Automation & Self-Healing Agentic Pipelines';
$pageDesc     = 'End-to-end intelligent process automation with self-healing decision trees, multimodal document parsing, adaptive exception routing, and 24/7 autonomous execution.';
$ogImage      = 'assets/img/services/svc-13-workflow-automation.jpg';

/* ---------------------------------------------------------------------------
 * Content Definitions
 * ------------------------------------------------------------------------ */

$stats = [['92%', 'Autonomous Task Resolution'], ['10x', 'End-to-End Speedup'], ['0%', 'Manual Transcription Error'], ['24/7', 'Continuous Pipeline Execution']];

$disciplines = [['01', 'Self-Healing Exception Remediation', 'Autonomous error-recovery nodes that inspect stack traces, adjust parameters, reformulate queries, and self-correct without manual intervention.'], ['02', 'Multimodal Document & Invoice Extraction', 'End-to-end cognitive intake for unstructured PDFs, scanned receipts, bill of ladings, and contracts with structured JSON database sync.'], ['03', 'Event-Driven Trigger & Webhook Meshes', 'Real-time reactive orchestration responding to emails, database commits, webhooks, and IoT sensor streams in milliseconds.'], ['04', 'Cross-System Orchestration & Sync', 'Coordinating multi-step transactions across disparate SaaS applications, legacy ERPs, CRMs, and internal databases atomically.'], ['05', 'Cognitive Decision Routing & Triage', 'Intelligent semantic classification of inbound requests, customer tickets, and financial approvals routing to optimal workflows.'], ['06', 'Human-in-the-Loop Review Portals', 'Intuitive management consoles that surface low-confidence anomalies for single-click human verification before committing state.']];

$benefits = [['01', '92%+ Touchless Task Completion', 'Free human staff from tedious data entry, document transcription, and manual ticket escalation.'], ['02', 'Resilient Self-Healing Architecture', 'Automated error recovery prevents pipeline halts caused by minor data format shifts or API hiccups.'], ['03', '10x Operational Throughput', 'Execute complex multi-step workflows in seconds that previously required hours of human coordination.'], ['04', 'Flawless Data Accuracy', 'Eliminate human transcription fatigue, ensuring 100% data consistency across all connected systems.'], ['05', 'Comprehensive Audit & Compliance Trails', 'Every automated decision, tool invocation, and human approval is immutably logged for regulatory compliance.']];

$steps = [['01', 'Process Mapping & Friction Analysis', 'Identifying high-volume repetitive workflows, quantifying error rates, and establishing baseline turnaround times.'], ['02', 'Agentic State Machine & Schema Design', 'Designing LangGraph workflow states, Pydantic data validation models, and self-healing error recovery routes.'], ['03', 'Connector & Tool Integration', 'Connecting ERP, CRM, email, and database endpoints via secure REST, webhook, and MCP interfaces.'], ['04', 'Sandbox Simulation & Chaos Testing', 'Simulating malformed inputs, API timeouts, and edge cases to verify self-healing exception handling.'], ['05', 'Production Deployment & Continuous Telemetry', 'Rolling out live automated pipelines with 24/7 health monitoring and real-time SLA alerting.']];

$models = [['01', 'Workflow Automation Sprint', 'A 3-week engagement delivering a dedicated self-healing automation pipeline for a critical operational process.', ['3-week implementation', 'Self-healing error recovery', 'Full audit dashboard']], ['02', 'Enterprise Automation Core', 'Comprehensive multi-process automation suite connecting Sales, Operations, and Finance systems with human-in-the-loop gates.', ['Cross-department workflows', 'Multimodal document intake', '99.9% uptime SLA']], ['03', 'Autonomous Automation Retainer', 'Continuous workflow development, new process onboarding, pipeline optimization, and 24/7 SRE monitoring.', ['Continuous workflow expansion', 'Dedicated automation squad', '24/7 SLA & support']]];

$techStack = ['LangGraph', 'Temporal.io', 'Python', 'FastAPI', 'Redis', 'Kafka', 'Docker', 'PostgreSQL', 'OpenTelemetry', 'Celery'];

$pageStack = [
    ['slug' => 'workflow', 'title' => 'Workflow Engine', 'icon' => 'workflow',
     'blurb' => 'Intake to resolution, with people on the exceptions.',
     'items' => [
         ['name' => 'Python', 'logo' => 'python'],
         ['name' => 'Celery', 'logo' => 'celery'],
         ['name' => 'Airflow', 'logo' => 'apacheairflow'],
         ['name' => 'FastAPI', 'logo' => 'fastapi'],
     ]],
    ['slug' => 'models', 'title' => 'Decisioning', 'icon' => 'brain',
     'blurb' => 'The judgement step, bounded by rules kept in version control.',
     'items' => [
         ['name' => 'OpenAI', 'logo' => 'openai'],
         ['name' => 'Anthropic', 'logo' => 'anthropic'],
         ['name' => 'LangChain', 'logo' => 'langchain'],
         ['name' => 'scikit-learn', 'logo' => 'scikitlearn'],
     ]],
    ['slug' => 'platform', 'title' => 'State & Reporting', 'icon' => 'cloud',
     'blurb' => 'Case state, throughput and the exception queue.',
     'items' => [
         ['name' => 'PostgreSQL', 'logo' => 'postgresql'],
         ['name' => 'Redis', 'logo' => 'redis'],
         ['name' => 'Docker', 'logo' => 'docker'],
         ['name' => 'Grafana', 'logo' => 'grafana'],
     ]],
];

$faqs = [['What is the difference between traditional RPA/scripts and Autonomous Workflow Automation?', 'Traditional RPA relies on rigid, hardcoded rules and coordinates via fragile UI selectors that break upon any minor website or data update. Autonomous Workflow Automation uses LLMs and cognitive agent loops that understand context, parse unstructured data, and dynamically adapt execution when errors occur.'], ["How does the 'self-healing' capability work in practice?", 'When a pipeline step fails (such as an API schema change or missing data field), the agent analyzes the error message, determines alternative tool paths or parameter transformations, and retries the action dynamically without crashing the workflow.'], ['Can autonomous workflows process unstructured scanned documents and PDFs?', 'Yes. We incorporate multimodal vision-language parsing models and OCR engines that extract complex tables, handwritten notes, and nested metadata directly into validated JSON schemas.'], ['What systems can your autonomous workflow pipelines connect with?', 'We connect with Salesforce, HubSpot, SAP, NetSuite, Jira, GitHub, Slack, Gmail, Outlook, PostgreSQL, Snowflake, Twilio, Stripe, and custom in-house REST/GraphQL APIs.'], ["How do you guarantee that automated workflows don't perform unintended actions?", 'We implement deterministic guardrails, Pydantic type validation, schema boundary checks, and human-in-the-loop approval thresholds for high-stakes actions like financial transfers.'], ['What happens if an external API or database is temporarily unavailable?', 'Our workflows utilize distributed state engines (like Temporal and Celery) that maintain durable execution state, automatically queueing retries with exponential backoff until the service recovers.'], ['Can workflows be deployed inside our private cloud or on-premise infrastructure?', 'Yes. All workflow engines, agentic workers, and data stores are containerized and deployable within your private AWS, Azure, GCP VPC, or on-premise Kubernetes clusters.'], ['How do human operators review edge cases or flagged anomalies?', 'We provide intuitive human-in-the-loop review interfaces and Slack/Teams interactive cards where operators can inspect flagged anomalies and approve or modify actions with a single click.'], ['How do you monitor workflow health and measure performance gains?', 'We provide real-time dashboards displaying task volume, completion rates, average execution speed, self-healing recovery events, and net labor hours saved.'], ['How long does it take to automate a complex enterprise workflow?', 'A single high-impact workflow is typically designed, tested, and deployed into production in 3 to 4 weeks. Multi-process enterprise suites take 6 to 8 weeks.']];

/** Schema.org Structured Data with FAQPage & Service */
$schema = [
    '@context' => 'https://schema.org',
    '@graph' => [
        [
            '@type' => 'Service',
            'name' => 'Autonomous Workflow Automation & Self-Healing Agentic Pipelines',
            'serviceType' => 'Enterprise Integration & Systems',
            'description' => 'End-to-end intelligent process automation with self-healing decision trees, multimodal document parsing, adaptive exception routing, and 24/7 autonomous execution.',
            'url' => canonical('services/autonomous-workflow-automation.php'),
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

<div class="svc-page" data-theme="flow">

  <!-- =========================================================================
       HERO SECTION: Cyber Eyebrow, Gradient Headline & Action CTAs
       ========================================================================= -->
  <section class="svc-hero">
    <div class="svc-shell svc-hero-inner">
      <p class="svc-eyebrow"><span class="svc-pulse" aria-hidden="true"></span>Self-Healing Workflow Automation · 24/7 Execution</p>

      <h1 class="svc-h1">
        Autonomous Workflow Automation For<br><em>Resilient Operational Velocity</em>
      </h1>

      <p class="svc-lead">
        End-to-end intelligent process automation with self-healing decision trees, multimodal document parsing, adaptive exception routing, and 24/7 autonomous execution.
      </p>

      <div class="svc-actions svc-actions--mid">
        <button class="svc-btn svc-btn--primary" type="button"
                data-modal-open data-modal-service="Autonomous Workflow Automation & Self-Healing Agentic Pipelines">
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
        <img src="<?= e(asset('assets/img/services/svc-13-workflow-automation.jpg')) ?>" width="1200" height="700"
             alt="Autonomous Workflow Automation & Self-Healing Agentic Pipelines Architecture" fetchpriority="high" decoding="async">
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
          <h2 class="svc-title">Rigid automation scripts break easily;<br><em>agentic workflows adapt and self-heal</em></h2>
        </div>
        <div class="svc-open-copy">
          <p>Legacy automation workflows (traditional scripts, Zapier, basic RPA) collapse whenever an unexpected UI change, malformed document, or unhandled API error occurs. This fragility forces human teams to spend hours troubleshooting broken jobs and re-entering data manually.</p>
          <p>We engineer next-generation Autonomous Workflow Automation powered by cognitive agentic loops. When an anomaly or error occurs, our self-healing pipelines analyze the root cause, adapt their execution strategy, query fallback tools, and resolve the workflow autonomously — achieving 92%+ touchless task completion across your operations.</p>
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
        <h2 class="svc-title">Six autonomous automation disciplines<br>for <em>uninterrupted execution</em></h2>
        <p class="svc-sub">From self-healing exception remediation to multimodal document processing and event meshes.</p>
      </div>

      <div class="svc-cards-grid">
        <?php foreach ($disciplines as $i => [$num, $dTitle, $dDesc]): ?>
          <?php $fig = svc_img('13', 3, $i + 1); ?>
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
                data-modal-open data-modal-service="Autonomous Workflow Automation & Self-Healing Agentic Pipelines">
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
        <h2 class="svc-title">Five strategic business advantages<br>of our <em>Autonomous Workflow Automation</em></h2>
        <p class="svc-sub">
          Explore the architectural advantages that guarantee high concurrency, zero data leakage, and rapid payback timelines.
        </p>
      </div>

      <div class="svc-benefits-grid">
        <?php foreach ($benefits as $i => [$num, $bTitle, $bDesc]): ?>
          <?php $fig = svc_img('13', 5, $i + 1); ?>
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
      <div class="svc-roadmap" data-roadmap="conveyor" aria-hidden="true">
        <?php foreach ($steps as $idx => [$num, $sTitle]): ?>
          <span data-roadmap-node="<?= $idx ?>" data-label="<?= e($sTitle) ?>"></span>
        <?php endforeach; ?>
      </div>

      <?php
      $s6 = array_filter([svc_img('13', 6, 1), svc_img('13', 6, 2), svc_img('13', 6, 3)]);
      ?>
      <?php if ($s6): ?>
        <div class="svc-s6-strip">
          <?php foreach ($s6 as $src): ?>
            <figure><img src="<?= e($src) ?>" width="800" height="450" alt=""
                         loading="lazy" decoding="async"></figure>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

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
        <h2 class="svc-title">Three ways to engage our<br><em>Autonomous Workflow Automation Practice</em></h2>
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
                    data-modal-open data-modal-service="Autonomous Workflow Automation & Self-Healing Agentic Pipelines (Model <?= e($num) ?>)">
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
            <img src="<?= e(asset('assets/img/services/svc-13-workflow-automation.jpg')) ?>" width="900" height="700"
                 alt="Autonomous Workflow Automation & Self-Healing Agentic Pipelines FAQ Consultation" loading="lazy" decoding="async">
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
      <h2>Ready to build or scale your<br><em>Autonomous Workflow Automation System?</em></h2>
      <p class="svc-close-lead">
        Discuss your technical requirements, latency constraints, and data governance policies directly with our Lead AI Systems Architects. Receive an actionable feasibility audit and prototype blueprint within 48 hours.
      </p>
      <div class="svc-actions svc-actions--mid">
        <button class="svc-btn svc-btn--primary" type="button"
                data-modal-open data-modal-service="Autonomous Workflow Automation & Self-Healing Agentic Pipelines">
          Start 48-Hour Technical Discovery<?= icon('arrow') ?>
        </button>
      </div>
    </div>
  </section>

</div>

<?php
require dirname(__DIR__) . '/includes/footer.php';
