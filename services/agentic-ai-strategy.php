<?php
/**
 * Enterprise Agentic AI Strategy & Swarm Architecture Advisory
 *
 * Enterprise AI Service Page engineered with modern dark cyber UI,
 * 6 Core Capabilities, 5 Strategic ROI Advantages, 5-Step Process Roadmap,
 * 3 Deployment Frameworks, Tech Stack Arena, and 10 Detailed FAQs with Schema.org JSON-LD.
 */

declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/config.php';

$page         = 'services';
$pageTitle    = 'Enterprise Agentic AI Strategy & Swarm Architecture Advisory';
$pageDesc     = 'Architecting autonomous agentic frameworks, multi-agent communication topologies, MCP protocol integrations, and deterministic safety guardrails for enterprise automation.';
$ogImage      = 'assets/img/services/svc-07-agentic-strategy.jpg';

/* ---------------------------------------------------------------------------
 * Content Definitions
 * ------------------------------------------------------------------------ */

$stats = [['99.5%', 'Strategy Success Rate'], ['4.2x', 'Operational Velocity Multiple'], ['200+', 'Agent Architecture Audits'], ['100%', 'Deterministic Guardrails']];

$disciplines = [['01', 'Multi-Agent Swarm Topology Architecture', 'Designing hierarchical orchestrator-worker, debate, and consensus swarms tailored to complex cross-functional business processes.'], ['02', 'Model Context Protocol (MCP) Blueprinting', 'Establishing standardized, secure MCP server and client architectures to bridge agents with enterprise databases, APIs, and tools.'], ['03', 'Deterministic Guardrails & Safety Triaging', 'Implementing semantic firewalls, prompt injection defense layers, and automated critic reflection loops that eliminate hallucinations.'], ['04', 'LangGraph State Machine & Cyclical Routing', 'Defining resilient graph states, checkpointing mechanisms, error-recovery nodes, and rollback states for complex multi-step workflows.'], ['05', 'Tool Execution Sandboxing & RBAC Governance', 'Architecting isolated Docker/Wasm execution sandboxes with strict credential brokering and role-based action permissions.'], ['06', 'Agentic ROI & Labor Unit Economics Modeling', 'Quantifying task deflection rates, token unit economics, and operational velocity gains to build an indisputable CFO business case.']];

$benefits = [['01', 'De-Risked Agentic Transformation', 'Validate agent feasibility, tool safety, and token budgets before embarking on complex multi-agent engineering.'], ['02', 'Deterministic, Self-Healing Execution', 'Graph-based state architectures self-correct execution errors rather than crashing or looping indefinitely.'], ['03', 'Standardized Model Context Protocol (MCP)', 'Future-proof tool integrations with open MCP standards, avoiding brittle proprietary agent connectors.'], ['04', 'Ironclad Data Sovereignty & VPC Security', 'Design agentic swarms hosted inside your private cloud with zero data leakage to public model training queues.'], ['05', 'Clear Phased Production Roadmap', 'Step-by-step implementation milestones with unambiguous KPIs, risk mitigations, and team enablement plans.']];

$steps = [['01', 'Workflow Friction & Agentic Opportunity Audit', 'Mapping high-value operational processes across engineering, sales, ERP, and customer operations suitable for agentic delegation.'], ['02', 'Agent Topology & State Graph Design', 'Drafting multi-agent interaction protocols, state schemas, memory persistence strategies, and tool boundaries.'], ['03', 'Security, MCP & Guardrail Specification', 'Defining deterministic safety constraints, human-in-the-loop escalation gates, and secure MCP gateway architectures.'], ['04', 'Sandbox Architecture Prototyping', 'Building a lightweight LangGraph prototype with live tool calls to benchmark accuracy, latency, and token economics.'], ['05', 'Executive Roadmap & Governance Handover', 'Delivering the production architecture blueprint, vendor selection matrix, and operational change management guidelines.']];

$models = [['01', 'Agentic Strategy Sprint', 'A 2-week intensive advisory engagement delivering an Agentic Opportunity Matrix, LangGraph state blueprint, and ROI model.', ['2-week deep dive', 'State architecture design', 'Executive roadmap']], ['02', 'Enterprise Swarm Architecture Design', 'A 4-week complete architectural specification covering multi-agent topologies, MCP integrations, safety gates, and VPC sizing.', ['Full MCP blueprint', 'Guardrail specification', 'Cost & latency modeling']], ['03', 'Retained Fractional Chief Agentic Officer', 'Ongoing strategic guidance, quarterly agentic maturity reviews, architecture audits, and model evaluation in CI/CD.', ['Bi-weekly architecture syncs', 'Priority engineering advisory', 'Continuous roadmap tuning']]];

$techStack = ['LangGraph', 'MCP (Model Context Protocol)', 'AutoGen', 'CrewAI', 'LlamaIndex', 'NeMo Guardrails', 'OpenTelemetry', 'Docker', 'AWS Bedrock', 'vLLM'];

$pageStack = [
    ['slug' => 'analysis', 'title' => 'Measurement & Analysis', 'icon' => 'bar-chart',
     'blurb' => 'Timing the process before proposing to automate it.',
     'items' => [
         ['name' => 'Python', 'logo' => 'python'],
         ['name' => 'pandas', 'logo' => 'pandas'],
         ['name' => 'scikit-learn', 'logo' => 'scikitlearn'],
         ['name' => 'PostgreSQL', 'logo' => 'postgresql'],
     ]],
    ['slug' => 'models', 'title' => 'Models & Evaluation', 'icon' => 'brain',
     'blurb' => 'Benchmarked on your tasks, not on a public leaderboard.',
     'items' => [
         ['name' => 'OpenAI', 'logo' => 'openai'],
         ['name' => 'Anthropic', 'logo' => 'anthropic'],
         ['name' => 'LangChain', 'logo' => 'langchain'],
         ['name' => 'PyTorch', 'logo' => 'pytorch'],
     ]],
    ['slug' => 'platform', 'title' => 'Target Platform', 'icon' => 'cloud',
     'blurb' => 'Where the recommendation would actually be deployed.',
     'items' => [
         ['name' => 'Docker', 'logo' => 'docker'],
         ['name' => 'AWS', 'logo' => 'amazonwebservices'],
         ['name' => 'Azure', 'logo' => 'azure'],
         ['name' => 'Grafana', 'logo' => 'grafana'],
     ]],
];

$faqs = [['What is the fundamental difference between standard GenAI and Agentic AI?', 'Standard Generative AI responds passively to a single prompt with text. Agentic AI operates autonomously by reasoning, planning multi-step actions, maintaining persistent memory, calling external software tools/APIs, evaluating its own results, and executing until a goal is achieved.'], ['What is Model Context Protocol (MCP) and why is it central to your strategy?', 'Model Context Protocol (MCP) is an open standard created by Anthropic that standardizes how AI agents securely discover and interact with external data sources and tools. It prevents vendor lock-in and allows seamless integration with enterprise systems without rewriting custom glue code.'], ['Which agentic framework do you recommend: LangGraph, AutoGen, or CrewAI?', 'For deterministic enterprise production, we predominantly architect with LangGraph because its cyclic graph state machine provides deterministic control, human-in-the-loop checkpointing, and fault tolerance. AutoGen and CrewAI are excellent for conversational simulation and rapid role-playing prototyping.'], ['How do you prevent autonomous agents from making catastrophic errors or looping infinitely?', 'We implement deterministic guardrails, maximum recursion depth limits, schema-validated JSON outputs, and automated reflection critic nodes. Any action exceeding predefined risk or cost thresholds requires mandatory human sign-off.'], ['How do you handle data security when agents interact with enterprise databases?', 'We design read-only replicas, schema-restricted service accounts, and tool execution sandboxes. Agents never receive raw database credentials; all actions pass through an authenticated MCP gateway with comprehensive audit logging.'], ['How do you model the ROI and compute costs of multi-agent swarms?', 'We simulate the average agent steps, token input/output volumes, model routing strategies (using smaller SLMs for routing and larger LLMs for complex reasoning), and quantify labor hours saved to deliver a predictable unit cost per resolved task.'], ['What is the role of human-in-the-loop (HITL) in an autonomous agentic architecture?', 'Human-in-the-loop provides confidence-based escalation gates. Routine low-risk actions execute autonomously at lightspeed, while high-risk decisions (financial transfers, database modifications, contract approvals) trigger immediate review requests to human operators via Slack or Teams.'], ['Can we deploy agentic AI swarms within our private VPC or on-premise cloud?', 'Yes. We design architectures that run on self-hosted open-weights models (such as Llama 3, Mistral, and DeepSeek) using vLLM or Ollama on private Kubernetes clusters inside your AWS, Azure, or GCP VPC.'], ['How long does an Agentic AI strategy engagement take?', 'Our focused Agentic Strategy Sprint takes 2 weeks, while a comprehensive multi-department enterprise swarm architecture audit takes 3 to 4 weeks.'], ['Do you provide the engineering teams to implement the strategy?', 'Yes. iThrive provides end-to-end capabilities from high-level agentic advisory to specialized LangGraph engineering squads that build, test, and deploy the entire autonomous system into production.']];

/** Schema.org Structured Data with FAQPage & Service */
$schema = [
    '@context' => 'https://schema.org',
    '@graph' => [
        [
            '@type' => 'Service',
            'name' => 'Enterprise Agentic AI Strategy & Swarm Architecture Advisory',
            'serviceType' => 'Agentic AI & Swarm Engineering',
            'description' => 'Architecting autonomous agentic frameworks, multi-agent communication topologies, MCP protocol integrations, and deterministic safety guardrails for enterprise automation.',
            'url' => canonical('services/agentic-ai-strategy.php'),
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

<div class="svc-page" data-theme="strategy">

  <!-- =========================================================================
       HERO SECTION: Cyber Eyebrow, Gradient Headline & Action CTAs
       ========================================================================= -->
  <section class="svc-hero">
    <div class="svc-shell svc-hero-inner">
      <p class="svc-eyebrow"><span class="svc-pulse" aria-hidden="true"></span>Enterprise Agentic AI Strategy · Swarm Topology Advisory</p>

      <h1 class="svc-h1">
        Agentic AI Strategy For<br><em>Autonomous Enterprise Execution</em>
      </h1>

      <p class="svc-lead">
        Architecting autonomous agentic frameworks, multi-agent communication topologies, Model Context Protocol (MCP) integrations, and deterministic safety guardrails for enterprise automation.
      </p>

      <div class="svc-actions svc-actions--mid">
        <button class="svc-btn svc-btn--primary" type="button"
                data-modal-open data-modal-service="Enterprise Agentic AI Strategy & Swarm Architecture Advisory">
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
        <img src="<?= e(asset('assets/img/services/svc-07-agentic-strategy.jpg')) ?>" width="1200" height="700"
             alt="Enterprise Agentic AI Strategy & Swarm Architecture Advisory Architecture" fetchpriority="high" decoding="async">
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
          <h2 class="svc-title">Single prompts are obsolete;<br><em>agentic state machines govern the future</em></h2>
        </div>
        <div class="svc-open-copy">
          <p>Simple prompt-and-response LLM wrappers cannot solve complex multi-step enterprise workflows. Without autonomous planning, reflection, persistent memory, and deterministic tool execution, AI systems hallucinate, loop infinitely, and fail in production.</p>
          <p>Our Agentic AI Strategy practice architects resilient multi-agent cognitive topologies using LangGraph, Model Context Protocol (MCP), and cyclic graph state machines. We design structured orchestrator-worker networks with strict human-in-the-loop guardrails that transform manual operational friction into self-executing autonomous workflows.</p>
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
        <h2 class="svc-title">Six strategic agentic disciplines<br>guiding <em>autonomous maturity</em></h2>
        <p class="svc-sub">From agentic state machine design to Model Context Protocol enterprise architectures.</p>
      </div>

      <?php /* The 6 images for this section, shown in depth rather than as
               card corners. Falls back to a plain grid of the same images if the
               island never mounts -- see includes/components/svc-gallery.php. */ ?>
      <?php component('svc-gallery', [
          'images'  => array_filter([svc_img('07', 3, 1), svc_img('07', 3, 2), svc_img('07', 3, 3), svc_img('07', 3, 4), svc_img('07', 3, 5), svc_img('07', 3, 6)]),
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
                data-modal-open data-modal-service="Enterprise Agentic AI Strategy & Swarm Architecture Advisory">
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
        <h2 class="svc-title">Five strategic business advantages<br>of our <em>Agentic Ai Strategy</em></h2>
        <p class="svc-sub">
          Explore the architectural advantages that guarantee high concurrency, zero data leakage, and rapid payback timelines.
        </p>
      </div>

      <?php /* The 5 images for this section, shown in depth rather than as
               card corners. Falls back to a plain grid of the same images if the
               island never mounts -- see includes/components/svc-gallery.php. */ ?>
      <?php component('svc-gallery', [
          'images'  => array_filter([svc_img('07', 5, 1), svc_img('07', 5, 2), svc_img('07', 5, 3), svc_img('07', 5, 4), svc_img('07', 5, 5)]),
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
      <div class="svc-roadmap" data-roadmap="branch" aria-hidden="true">
        <?php foreach ($steps as $idx => [$num, $sTitle]): ?>
          <span data-roadmap-node="<?= $idx ?>" data-label="<?= e($sTitle) ?>"></span>
        <?php endforeach; ?>
      </div>
      <?php /* The 3 images for this section, shown in depth rather than as
               card corners. Falls back to a plain grid of the same images if the
               island never mounts -- see includes/components/svc-gallery.php. */ ?>
      <?php component('svc-gallery', [
          'images'  => array_filter([svc_img('07', 6, 1), svc_img('07', 6, 2), svc_img('07', 6, 3)]),
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
        <h2 class="svc-title">Three ways to engage our<br><em>Agentic Ai Strategy Practice</em></h2>
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
                    data-modal-open data-modal-service="Enterprise Agentic AI Strategy & Swarm Architecture Advisory (Model <?= e($num) ?>)">
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
            <img src="<?= e(asset('assets/img/services/svc-07-agentic-strategy.jpg')) ?>" width="900" height="700"
                 alt="Enterprise Agentic AI Strategy & Swarm Architecture Advisory FAQ Consultation" loading="lazy" decoding="async">
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
      <h2>Ready to build or scale your<br><em>Agentic Ai Strategy System?</em></h2>
      <p class="svc-close-lead">
        Discuss your technical requirements, latency constraints, and data governance policies directly with our Lead AI Systems Architects. Receive an actionable feasibility audit and prototype blueprint within 48 hours.
      </p>
      <div class="svc-actions svc-actions--mid">
        <button class="svc-btn svc-btn--primary" type="button"
                data-modal-open data-modal-service="Enterprise Agentic AI Strategy & Swarm Architecture Advisory">
          Start 48-Hour Technical Discovery<?= icon('arrow') ?>
        </button>
      </div>
    </div>
  </section>

</div>

<?php
require dirname(__DIR__) . '/includes/footer.php';
