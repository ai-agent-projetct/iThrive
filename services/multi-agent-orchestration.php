<?php
/**
 * Multi-Agent Orchestration & Autonomous Swarm Engineering
 *
 * Enterprise AI Service Page engineered with modern dark cyber UI,
 * 6 Core Capabilities, 5 Strategic ROI Advantages, 5-Step Process Roadmap,
 * 3 Deployment Frameworks, Tech Stack Arena, and 10 Detailed FAQs with Schema.org JSON-LD.
 */

declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/config.php';

$page         = 'services';
$pageTitle    = 'Multi-Agent Orchestration Services';
$pageDesc     = 'Hierarchical multi-agent swarms: supervisor handoff, shared memory design, deadlock control and replayable runs, built with LangGraph and AutoGen.';
$ogImage      = 'assets/img/services/svc-10-multi-agent-orchestration.jpg';

/* ---------------------------------------------------------------------------
 * Content Definitions
 * ------------------------------------------------------------------------ */

$stats = [['N-Agent', 'Elastic Swarm Scalability'], ['99.9%', 'Consensus Reliability Rate'], ['<50ms', 'Inter-Agent Message Latency'], ['0%', 'Deadlock & Loop Risk']];

$disciplines = [['01', 'Hierarchical Supervisor-Worker Topologies', 'Designing lead orchestrator agents that decompose high-level business goals, dynamically assign tasks to specialized worker agents, and synthesize final results.'], ['02', 'Agent-to-Agent Debate & Consensus Protocols', 'Implementing multi-agent verification loops where planner, executor, and critic agents debate and vote on solutions before execution.'], ['03', 'Dynamic Sub-Task Delegation & Parallelism', 'Executing dozens of independent data gathering, analysis, and transformation tasks in parallel across worker agents with zero latency lag.'], ['04', 'LangGraph Cyclic State Management & Routing', 'Building deterministic state graphs with conditional branching, shared memory stores, and checkpointed state recovery.'], ['05', 'Deadlock Prevention & Circuit Breakers', 'Implementing finite state machines, maximum turn constraints, and semantic divergence detectors that prevent infinite loops and runaway compute.'], ['06', 'Distributed Agent Mesh & MCP Protocol', 'Connecting heterogeneous agents built on different frameworks via standardized Model Context Protocol (MCP) and gRPC streaming backbones.']];

$benefits = [['01', 'Flawless Execution on Complex Initiatives', 'Decompose massive enterprise workflows into manageable sub-tasks executed by domain specialist agents.'], ['02', 'Self-Correcting Reflection Loops', 'Critic and auditor agents review all code, calculations, and content before outputs are finalized.'], ['03', 'High-Throughput Parallel Processing', 'Execute hundreds of sub-tasks concurrently across cloud clusters, reducing completion time by 90%.'], ['04', 'Resilient Fault Tolerance & Recovery', 'If an individual worker agent encounters a tool error, the supervisor dynamically retries or reassigns the sub-task.'], ['05', 'Optimized Token & Compute Costs', 'Route simple sub-tasks to fast, lightweight SLMs while reserving massive frontier models exclusively for high-level synthesis.']];

$steps = [['01', 'Workflow Decomposition & Role Profiling', 'Analyzing the target business workflow, defining clear agent roles (Planner, Researcher, Coder, Critic), and specifying input/output schemas.'], ['02', 'Orchestration State Graph Architecture', 'Designing the LangGraph state machine, message-passing protocol, shared memory architecture, and escalation branches.'], ['03', 'Agent Tool Binding & Consensus Calibration', 'Connecting specialized tools to individual agents and calibrating voting/debate thresholds for reliable consensus.'], ['04', 'Stress Testing & Loop Simulation', 'Subjecting the swarm to edge cases, high concurrency, and synthetic failures to verify deadlock prevention and circuit breakers.'], ['05', 'Production Deployment & Swarm Observability', 'Deploying the swarm on Kubernetes with LangSmith/OpenTelemetry tracing to visualize inter-agent communication in real time.']];

$models = [['01', 'Multi-Agent Swarm PoC', 'A 3-week sprint building a functional 3-agent orchestration swarm (Supervisor, Specialist, Critic) for a targeted enterprise workflow.', ['3-week rapid build', '3 specialized agents', 'Full state tracing']], ['02', 'Enterprise Swarm Production System', 'Full-scale multi-agent orchestration platform with 5 to 15 synchronized worker agents integrated with your enterprise databases and APIs.', ['Complex graph topology', 'Custom tool binding', 'Sub-100ms messaging']], ['03', 'Dedicated Swarm Engineering Team', 'Ongoing multi-agent swarm development, new agent archetype rollouts, continuous fine-tuning, and 24/7 cluster management.', ['Dedicated swarm engineers', 'Continuous topology tuning', '24/7 SLA & telemetry']]];

$techStack = ['LangGraph', 'AutoGen', 'CrewAI', 'Python', 'gRPC', 'Redis', 'Kafka', 'Qdrant', 'LangSmith', 'Docker'];

$pageStack = [
    ['slug' => 'orchestration', 'title' => 'Orchestration', 'icon' => 'network',
     'blurb' => 'The state machine that owns a run, and can halt it.',
     'items' => [
         ['name' => 'LangChain', 'logo' => 'langchain'],
         ['name' => 'Python', 'logo' => 'python'],
         ['name' => 'Celery', 'logo' => 'celery'],
         ['name' => 'Airflow', 'logo' => 'apacheairflow'],
     ]],
    ['slug' => 'models', 'title' => 'Models per Role', 'icon' => 'brain',
     'blurb' => 'A different model per role where that earns its cost.',
     'items' => [
         ['name' => 'OpenAI', 'logo' => 'openai'],
         ['name' => 'Anthropic', 'logo' => 'anthropic'],
         ['name' => 'PyTorch', 'logo' => 'pytorch'],
         ['name' => 'TensorFlow', 'logo' => 'tensorflow'],
     ]],
    ['slug' => 'platform', 'title' => 'Runtime & Traces', 'icon' => 'cloud',
     'blurb' => 'Replayable runs, because the system is not deterministic.',
     'items' => [
         ['name' => 'Kubernetes', 'logo' => 'kubernetes'],
         ['name' => 'Docker', 'logo' => 'docker'],
         ['name' => 'Redis', 'logo' => 'redis'],
         ['name' => 'Grafana', 'logo' => 'grafana'],
     ]],
];

$faqs = [['What is Multi-Agent Orchestration and why is it better than a single agent?', 'Multi-Agent Orchestration coordinates multiple specialized AI agents working together toward a common goal. Instead of overloading a single prompt with too many instructions, each agent specializes in one specific discipline (e.g., Planner, Researcher, Coder, Critic). This modularity prevents context overload, reduces hallucinations, and enables parallel task execution.'], ['How do agents communicate and share context with one another?', "Agents communicate through structured message-passing protocols over a shared state graph (such as LangGraph's state dictionary) or distributed message queues (Kafka, Redis, gRPC). They exchange structured JSON payloads containing task status, findings, and next-step recommendations."], ['How do you prevent multi-agent swarms from getting stuck in infinite loops or deadlocks?', 'We implement deterministic graph state machines with strict turn counters, semantic convergence checks, and automated circuit breakers. If agents fail to reach consensus within a configured threshold, the supervisor invokes a fallback resolution or alerts a human operator.'], ['What is the role of a Critic or Auditor agent in a multi-agent swarm?', 'A Critic agent acts as an automated quality inspector. It receives the draft output produced by worker agents, evaluates it against predefined business rules, syntax guidelines, or citation facts, and either approves the output or sends it back with actionable feedback for correction.'], ['How do you manage compute and token costs across multi-agent systems?', 'We use hierarchical model routing: lightweight, low-cost SLMs (e.g., Llama 3 8B or Claude Haiku) handle simple extraction and routing sub-tasks, while frontier models (e.g., Claude 3.5 Sonnet or GPT-4o) are invoked only for complex strategic reasoning and final synthesis.'], ['Can multi-agent swarms execute actions in parallel?', 'Yes. LangGraph and asynchronous Python allow the supervisor agent to fan out multiple independent sub-tasks concurrently across dozens of worker nodes, reducing end-to-end execution time by up to 90%.'], ['How do you monitor and debug complex multi-agent interactions in real time?', 'We integrate LangSmith, Phoenix Arize, and OpenTelemetry to provide visual execution graphs, message traces, latency breakdowns, and token cost metrics for every single agent interaction.'], ['Can we integrate agents built on different frameworks (e.g., LangGraph and AutoGen)?', 'Yes. We build standardized Model Context Protocol (MCP) and REST/gRPC wrappers around individual agents, allowing heterogeneous agents across different frameworks to collaborate seamlessly.'], ['How does human-in-the-loop work in a multi-agent system?', "The orchestration graph can include dedicated Human-in-the-Loop checkpoint nodes where execution pauses, serializes its state, and waits for a manager's review via Slack, Microsoft Teams, or a custom web dashboard before proceeding."], ['How long does it take to engineer and deploy an enterprise multi-agent swarm?', 'A 3-agent proof of concept is typically operational in 3 to 4 weeks, while complex enterprise swarms with extensive API integrations require 6 to 8 weeks.']];

/** Schema.org Structured Data with FAQPage & Service */
$schema = [
    '@context' => 'https://schema.org',
    '@graph' => [
        [
            '@type' => 'Service',
            'name' => 'Multi-Agent Orchestration & Autonomous Swarm Engineering',
            'serviceType' => 'Agentic AI & Swarm Engineering',
            'description' => 'Engineering hierarchical multi-agent swarms, consensus mechanisms, dynamic sub-task delegation, and distributed agentic mesh networks with LangGraph and AutoGen.',
            'url' => canonical('services/multi-agent-orchestration.php'),
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

<div class="svc-page" data-theme="swarm">

  <!-- =========================================================================
       HERO SECTION: Cyber Eyebrow, Gradient Headline & Action CTAs
       ========================================================================= -->
  <section class="svc-hero">
    <div class="svc-shell svc-hero-inner">
      <p class="svc-eyebrow"><span class="svc-pulse" aria-hidden="true"></span>Multi-Agent Swarm Orchestration · Distributed Consensus</p>

      <h1 class="svc-h1">
        Multi-Agent Orchestration For<br><em>Autonomous Swarm Intelligence</em>
      </h1>

      <p class="svc-lead">
        Engineering hierarchical multi-agent swarms, consensus mechanisms, dynamic sub-task delegation, and distributed agentic mesh networks with LangGraph and AutoGen.
      </p>

      <div class="svc-actions svc-actions--mid">
        <button class="svc-btn svc-btn--primary" type="button"
                data-modal-open data-modal-service="Multi-Agent Orchestration & Autonomous Swarm Engineering">
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
        <img src="<?= e(asset('assets/img/services/svc-10-multi-agent-orchestration.jpg')) ?>" width="1200" height="700"
             alt="Multi-Agent Orchestration & Autonomous Swarm Engineering Architecture" fetchpriority="high" decoding="async">
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
          <h2 class="svc-title">Single agents fail at complex tasks;<br><em>orchestrated swarms divide and conquer</em></h2>
        </div>
        <div class="svc-open-copy">
          <p>When a single AI agent is asked to execute a massive enterprise initiative (e.g., auditing an entire codebase, reconciling thousands of cross-border invoices, or conducting deep market research), context windows fill up, reasoning degrades, and hallucination rates skyrocket.</p>
          <p>We engineer sophisticated Multi-Agent Orchestration architectures that break complex enterprise goals into hierarchical sub-tasks executed by specialized agent swarms. Utilizing LangGraph state graphs, dynamic debate protocols, and distributed consensus mechanisms, our multi-agent systems achieve superhuman execution accuracy with built-in reflection.</p>
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
        <h2 class="svc-title">Six multi-agent orchestration disciplines<br>for <em>swarm intelligence</em></h2>
        <p class="svc-sub">From hierarchical supervisor topologies to distributed agent communication protocols.</p>
      </div>

      <?php /* The 6 images for this section, shown in depth rather than as
               card corners. Falls back to a plain grid of the same images if the
               island never mounts -- see includes/components/svc-gallery.php. */ ?>
      <?php component('svc-gallery', [
          'images'  => array_filter([svc_img('10', 3, 1), svc_img('10', 3, 2), svc_img('10', 3, 3), svc_img('10', 3, 4), svc_img('10', 3, 5), svc_img('10', 3, 6)]),
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
                data-modal-open data-modal-service="Multi-Agent Orchestration & Autonomous Swarm Engineering">
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
        <h2 class="svc-title">Five strategic business advantages<br>of our <em>Multi Agent Orchestration</em></h2>
        <p class="svc-sub">
          Explore the architectural advantages that guarantee high concurrency, zero data leakage, and rapid payback timelines.
        </p>
      </div>

      <?php /* The 5 images for this section, shown in depth rather than as
               card corners. Falls back to a plain grid of the same images if the
               island never mounts -- see includes/components/svc-gallery.php. */ ?>
      <?php component('svc-gallery', [
          'images'  => array_filter([svc_img('10', 5, 1), svc_img('10', 5, 2), svc_img('10', 5, 3), svc_img('10', 5, 4), svc_img('10', 5, 5)]),
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
      <div class="svc-roadmap" data-roadmap="orbit" aria-hidden="true">
        <?php foreach ($steps as $idx => [$num, $sTitle]): ?>
          <span data-roadmap-node="<?= $idx ?>" data-label="<?= e($sTitle) ?>"></span>
        <?php endforeach; ?>
      </div>
      <?php /* The 3 images for this section, shown in depth rather than as
               card corners. Falls back to a plain grid of the same images if the
               island never mounts -- see includes/components/svc-gallery.php. */ ?>
      <?php component('svc-gallery', [
          'images'  => array_filter([svc_img('10', 6, 1), svc_img('10', 6, 2), svc_img('10', 6, 3)]),
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
        <h2 class="svc-title">Three ways to engage our<br><em>Multi Agent Orchestration Practice</em></h2>
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
                    data-modal-open data-modal-service="Multi-Agent Orchestration & Autonomous Swarm Engineering (Model <?= e($num) ?>)">
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
            <img src="<?= e(asset('assets/img/services/svc-10-multi-agent-orchestration.jpg')) ?>" width="900" height="700"
                 alt="Multi-Agent Orchestration & Autonomous Swarm Engineering FAQ Consultation" loading="lazy" decoding="async">
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
      <h2>Ready to build or scale your<br><em>Multi Agent Orchestration System?</em></h2>
      <p class="svc-close-lead">
        Discuss your technical requirements, latency constraints, and data governance policies directly with our Lead AI Systems Architects. Receive an actionable feasibility audit and prototype blueprint within 48 hours.
      </p>
      <div class="svc-actions svc-actions--mid">
        <button class="svc-btn svc-btn--primary" type="button"
                data-modal-open data-modal-service="Multi-Agent Orchestration & Autonomous Swarm Engineering">
          Start 48-Hour Technical Discovery<?= icon('arrow') ?>
        </button>
      </div>
    </div>
  </section>

</div>

<?php
require dirname(__DIR__) . '/includes/footer.php';
