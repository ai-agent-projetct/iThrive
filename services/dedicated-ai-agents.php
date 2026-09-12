<?php
/**
 * Dedicated AI Agents — Autonomous Agentic AI Workforces for Enterprise.
 *
 * Modeled identically after on-demand-resources.php with full OriginKit
 * WebGL and Framer components:
 *
 *   hero      Volumetric Light Flare with interactive light cycle
 *   roles     Energy Beam Flare: 5 specialized Agentic AI disciplines
 *   band      Neural backdrop with immediate deployment CTA
 *   benefits  Motion Layer Scroller: 5 3D isometric perspective cards
 *   steps     Process Roadmap: 5-step winding SVG deployment roadmap
 *   models    Bookmark Models: 3 commercial hiring & deployment structures
 *   dropzone  Tech Stack Dropzone: Physics-driven capsule arena
 *   advantage Dual 3D Infinite Perspective Gallery: 16 reasons with 16 photos
 *   faq       Enterprise Q&A on security, tools, voice AI and scaling
 *   close     Water Ripple wash with closing consultation CTA
 */

declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/config.php';

$svc = service('dedicated-ai-agents');

$page      = 'services';
$hasOriginKit = true;
$pageTitle = 'Dedicated AI Agents | Hire Autonomous Agentic AI Workforces';
$pageDesc  = 'Deploy dedicated autonomous AI agents for Software Development, Sales, Marketing, Operations, ERP tasks, HRMS, and Voice Calls. Hire ready-to-deploy agents or build custom agentic swarms scaled to N agents.';
$ogImage   = 'service-' . $svc['group_slug'];

/* ---------------------------------------------------------------------------
 * Content
 * ------------------------------------------------------------------------ */

$stats = [
    ['24/7',  'Continuous Autonomous Execution'],
    ['10x',   'Operational Velocity Multiplier'],
    ['100+',  'Pre-Trained Agent Archetypes'],
    ['100%',  'Custom Business & API Integration'],
];

/** The five Agentic AI disciplines you can deploy. */
$roles = [
    ['01', 'Full-Stack Software Engineering Agents',
     'Autonomous coding, automated pull request reviews, schema migrations, unit test synthesis, and self-healing bug remediation running 24/7 directly inside your repositories.'],
    ['02', 'Sales, CRM & Autonomous Voice Call Agents',
     'Sub-400ms conversational voice calling for inbound qualification and outbound follow-ups, with automatic CRM pipeline updates, call summarization, and calendar booking.'],
    ['03', 'Marketing & Digital Growth Swarms',
     'Continuous multimodal content creation, programmatic SEO, dynamic ad copy generation, algorithmic bidding, and real-time social media campaign distribution.'],
    ['04', 'ERP, Ledger & Repetitive Task Automation Agents',
     'Robotic reconciliation of complex ERP ledgers, invoice OCR parsing, automated supply chain synchronization, and cross-database data migration with zero manual error.'],
    ['05', 'HRMS, Operations & Business Understanding Agents',
     'Intelligent candidate screening, automated employee onboarding, SOP compliance verification, and deep contextual knowledge synthesis across distributed teams.'],
];

/** Five core benefits of deploying dedicated Agentic AI. */
$benefits = [
    ['01', '24/7 Non-Stop Autonomous Execution',
     'Agents do not experience context decay, shift fatigue, or timezone disconnects. Your operational velocity compounds continuously around the clock.'],
    ['02', 'Deep Domain & Business Context Understanding',
     'Trained and grounded on your private documentation, internal SOPs, databases, and APIs. Agents reason with the nuanced domain expertise of your best operators.'],
    ['03', 'Elastic Swarm Scalability (1 to N Agents)',
     'Instantly deploy one dedicated specialist agent or spin up an entire swarm of fifty synchronized workers during traffic spikes with zero recruitment overhead.'],
    ['04', 'Multi-Agent Collaboration & Reflection Loops',
     'Autonomous orchestrator, planner, executor, and critic agent topologies verify every output, execute unit tests, and self-correct before presenting final results.'],
    ['05', 'Enterprise Private VPC & Zero-Leak Security',
     'Hosted securely in your private cloud, on-premise Kubernetes cluster, or isolated VPC. Your proprietary business data never leaks to public foundation models.'],
];

/** How deploying dedicated AI agents works — five steps. */
$steps = [
    ['01', 'Workflow Audit & Discovery',
     'A strategic deep-dive into your operational workflows, identifying high-friction bottlenecks across engineering, sales, ERP, marketing, or HR where agents yield immediate 10x ROI.'],
    ['02', 'Architecture & Tool Binding',
     'Designing custom multi-agent topologies, fine-tuning task prompts, and securely binding agent execution tools to your APIs, databases, CRM, and ERP systems.'],
    ['03', 'Supervised Sandbox Pilot',
     'Agents execute in a controlled sandbox with strict human-in-the-loop oversight, verifying decision accuracy, safety guardrails, and compliance against historical benchmarks.'],
    ['04', 'Live Autonomous Rollout',
     'Full deployment into your production ecosystem: standups, Slack/Teams bots, automated CI/CD pipelines, ERP task queues, and live voice telephony lines.'],
    ['05', 'Continuous Memory & Optimization',
     'Agents accumulate persistent vector memory, refine internal heuristics from user feedback, and continuously improve throughput through reinforcement fine-tuning.'],
];

/** Commercial deployment models — three. */
$models = [
    ['01', 'Plug & Play Ready Agents',
     'Pre-trained, battle-tested autonomous agents for standard CRM, marketing, voice calls, or code QA. Deployed and active inside your tools within 48 hours.',
     ['Instant 48h setup', 'Standard tool integrations', 'Predictable monthly fee']],
    ['02', 'Dedicated Custom Agent Squad',
     'Bespoke agentic swarms engineered for your proprietary ERP, internal data schemas, and complex business logic with custom tool orchestration.',
     ['Tailored to your SOPs', 'Custom API & DB bindings', 'Human-in-the-loop controls']],
    ['03', 'Enterprise Autonomous Ecosystem',
     'Full-scale organizational transformation with private SLMs, isolated VPC cluster deployment, unlimited N-agent scaling, and a dedicated AI systems architect.',
     ['Private cloud VPC', 'Unlimited horizontal scale', 'Continuous fine-tuning']],
];

/** Sixteen reasons — the advantage. */
$advantage = [
    ['01', 'Multi-Agent Swarm Orchestration',
     'Hierarchical orchestrators divide complex enterprise initiatives into parallel subtasks, synthesizing cross-functional results with zero human intervention.'],
    ['02', 'Autonomous Voice & Conversational AI',
     'Ultra-low latency conversational voice agents handle hundreds of simultaneous customer calls with human-like intonation, real-time sentiment, and CRM booking.'],
    ['03', 'Robotic ERP & Repetitive Data Sync',
     'Zero-error reconciliation of enterprise ERP systems, automating invoice intake, ledger matching, and vendor communications at speeds no human team can match.'],
    ['04', 'Full-Stack Self-Healing Codegen',
     'Engineering agents write features, run automated test suites, fix lint errors, and submit clean, peer-reviewed pull requests directly to GitHub and GitLab.'],
    ['05', 'Multimodal Document & Contract Understanding',
     'Extract actionable entities, compliance risks, and financial summaries from thousands of complex PDFs, legal contracts, and scanned receipts in minutes.'],
    ['06', 'Self-Correcting Reflection Loops',
     'Every agent output is audited by an internal critic agent before execution, ensuring hallucinations are caught and corrected before reaching production.'],
    ['07', 'Native Tool & External API Execution',
     'Agents call REST APIs, execute SQL queries, trigger webhooks, query vector databases, and manipulate headless browsers with precision.'],
    ['08', 'Omnichannel CRM Real-Time Synchronization',
     'Instant, bi-directional synchronization across Salesforce, HubSpot, Zoho, and internal databases, ensuring every customer interaction is logged atomically.'],
    ['09', 'Algorithmic Digital Marketing & Ad Optimization',
     'Dynamic ad spend reallocation, automated multivariate creative testing, and autonomous keyword bid adjustments driven by real-time conversion signals.'],
    ['10', 'Automated HR Candidate Screening',
     'Semantic resume evaluation, automated technical screening questionnaires, and calendar scheduling that compress the hiring cycle from months to days.'],
    ['11', 'Zero-Latency 24/7 Autonomous Uptime',
     'An indefatigable digital workforce operating across global time zones, clearing queues while your executive team sleeps and delivering reports by dawn.'],
    ['12', 'Private VPC & On-Premise Deployment',
     'Full deployment flexibility within your AWS, GCP, Azure VPC or on-premise air-gapped data centers with SOC2 and HIPAA compliance safeguards.'],
    ['13', 'Horizontal N-Agent Swarm Elasticity',
     'Scale from a single triage agent to a 100-node cluster during Black Friday, product launches, or quarterly reporting crunches with single-click elasticity.'],
    ['14', 'Human-in-the-Loop Safety & Approval Gates',
     'Configurable confidence thresholds: routine actions execute autonomously, while high-value transactions or sensitive decisions require human manager sign-off.'],
    ['15', 'Persistent Vector Memory & Knowledge Graph',
     'Long-term contextual memory retains user preferences, historical project decisions, and corporate terminology across weeks and months of execution.'],
    ['16', 'Continuous Self-Improvement & Model Fine-Tuning',
     'Reinforcement learning from human feedback (RLHF) and automated failure-case indexing enable your dedicated agents to grow more accurate every single day.'],
];

$faqs = [
    ['Can we hire ready-made AI agents or do you build custom ones?',
     'Both. We have a robust library of pre-built, production-ready AI agents for CRM, customer support, conversational voice calls, content marketing, and code QA that deploy in 48 hours. Alternatively, our AI engineering team can architect, fine-tune, and deploy custom Agentic AI swarms tailored to your proprietary ERP, database schemas, and private business workflows.'],
    ['How many AI agents can we deploy to our business?',
     'There is no limit. Our agent orchestration architecture supports elastic horizontal scaling to N agents. Whether you need a single dedicated voice call agent or a 50-agent parallel swarm processing millions of ERP transactions, the system scales up or down dynamically based on your workload.'],
    ['How do you protect our private company data and IP?',
     'Your data sovereignty is paramount. We deploy dedicated AI agents inside your private cloud (AWS, Azure, GCP) or on-premise VPC. Your proprietary data is never used to train public foundation models, and all inter-agent communications utilize enterprise-grade encryption with zero-trust access controls.'],
    ['How realistic are your autonomous voice call AI agents?',
     'Our voice agents operate with sub-400ms end-to-end audio latency, human-grade natural speech cadence, and real-time interruption handling. They speak naturally, understand contextual nuance, qualify leads, navigate complex customer inquiries, and update your CRM calendar in real time.'],
    ['What tools and enterprise platforms do your agents integrate with?',
     'Our agents integrate natively with your existing tooling ecosystem: Jira, GitHub, GitLab, Salesforce, HubSpot, Zoho, SAP, NetSuite, Slack, Microsoft Teams, PostgreSQL, Snowflake, Twilio, Stripe, and custom REST/GraphQL APIs.'],
    ['How does human-in-the-loop oversight work?',
     'You maintain complete governance. We configure automated confidence scoring and threshold gates. Routine low-risk tasks execute autonomously, while high-stakes decisions (e.g., payouts, contract approvals, critical database deletes) pause and trigger an instant Slack/Teams approval request to your designated human manager.'],
];

$extraHead = '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>'
    . '<link rel="stylesheet" href="https://fonts.googleapis.com/css2?'
    . 'family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;600;700'
    . '&family=Space+Grotesk:wght@400;500;600;700&display=swap">'
    . '<link rel="stylesheet" href="' . e(asset('assets/css/ondemand.css')) . '">'
    . '<link rel="stylesheet" href="' . e(asset('assets/css/ai-agents.css')) . '">';

require dirname(__DIR__) . '/includes/header.php';

$img = static function (string $rel): string {
    $photo = 'assets/img/ai-agents/' . $rel;
    return asset(is_file(ROOT_PATH . '/' . $photo) ? $photo : 'assets/img/ai-agents/' . $rel);
};
?>

<div class="od od--ai-agents">

  <?php /* ---------------------------------------------------------------
           Hero — full page with cursor shape trail & WebGPU NextjsFlare
           --------------------------------------------------------------- */ ?>
  <section class="od-hero" data-trail>
    <div class="od-trail-layer" data-trail-layer aria-hidden="true"></div>

    <div class="od-shell od-hero-inner">
      <p class="od-eyebrow"><span class="od-pulse" aria-hidden="true"></span>Autonomous Agentic AI Workforce · Global Enterprise</p>

      <h1 class="od-h1">
        Dedicated AI Agents For<br>
        <em>Every Sector Of Your Business</em>
      </h1>

      <p class="od-lead">
        We build and deploy dedicated autonomous AI Agents for all your works: Full-Stack Development, Marketing, Sales, Operations, Digital Marketing, ERP Task Automation, HRMS, and Autonomous Voice Calling. Directly hire our ready-to-deploy Agentic AI or let us engineer a custom dedicated swarm scaled to <em>N</em> agents tailored to your exact business needs.
      </p>

      <div class="od-actions od-actions--mid">
        <button class="od-btn od-btn--primary" type="button"
                data-modal-open data-modal-service="Dedicated AI Agents">
          Deploy Dedicated AI Agents<?= icon('arrow') ?>
        </button>
        <a class="od-btn od-btn--ghost" href="#od-roles">Explore 5 Agent Disciplines</a>
      </div>

      <?php /*
         WebGPU Volumetric Light Flare with iThrive Logo & 5-color light cycle
      */ ?>
      <div class="od-flare-host"
           data-ok="nextjs-flare"
           data-props='<?= e(json_encode([
               'beamIntensity' => 1.25,
               'spotFocus'     => 0.40,
               'extension'     => 0.65,
               'scatter'       => 1.1,
               'rimIntensity'  => 1.3,
           ], JSON_THROW_ON_ERROR)) ?>'></div>

      <ul class="od-stats od-stats--mid">
        <?php foreach ($stats as [$v, $l]): ?>
          <li><strong><?= e($v) ?></strong><span><?= e($l) ?></span></li>
        <?php endforeach; ?>
      </ul>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           The opening argument
           --------------------------------------------------------------- */ ?>
  <section class="od-sec od-open">
    <div class="od-shell">
      <div class="od-open-grid">
        <div>
          <p class="od-eyebrow"><span class="od-pulse" aria-hidden="true"></span>Why Agentic AI Outperforms</p>
          <h2 class="od-title">Modern operational friction is<br>an <em>autonomous execution problem</em></h2>
        </div>
        <div class="od-open-copy">
          <p>
            Traditional staffing creates inevitable bottlenecks: manual handovers, context fragmentation, delayed responses, and human fatigue across high-frequency operations. Every time a ticket sits waiting between development, marketing, sales, and ERP data entry, revenue velocity stalls.
          </p>
          <p>
            Dedicated AI Agents eliminate these friction points entirely. By continuously executing across code repositories, voice telephony lines, CRM pipelines, and enterprise ledgers, an autonomous agent swarm achieves in minutes what previously took weeks of coordination — with zero context decay and 24/7 reliability.
          </p>
        </div>
      </div>

      <div class="od-open-art" style="margin-top: clamp(28px, 4vw, 44px); border-radius: 20px; overflow: hidden; border: 1px solid rgba(0, 242, 254, 0.25); box-shadow: 0 20px 60px rgba(0, 0, 0, 0.6); position: relative;">
        <img src="<?= e($img('open/01.jpg')) ?>" width="1200" height="700"
             alt="Engineers supervising autonomous AI agent swarm telemetry" loading="lazy" decoding="async"
             style="width: 100%; height: auto; max-height: 480px; object-fit: cover; display: block;">
        <div style="position: absolute; inset: 0; background: linear-gradient(180deg, rgba(6, 11, 24, 0.05) 50%, rgba(6, 11, 24, 0.85) 100%); pointer-events: none;"></div>
      </div>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           The five disciplines — Energy Beam Volumetric Component
           --------------------------------------------------------------- */ ?>
  <section class="od-sec od-roles" id="od-roles">
    <div class="od-shell">
      <div class="od-head">
        <p class="od-eyebrow"><span class="od-pulse" aria-hidden="true"></span>Agent Archetypes</p>
        <h2 class="od-title">Five specialized agent squads<br>ready for <em>immediate deployment</em></h2>
        <p class="od-sub">
          Volumetric Energy Beam: Interactive suction flare & particle aura. Select any agent squad to focus the energy beam and inspect specialized capabilities across your operations.
        </p>
      </div>

      <div class="od-beam-host"
           data-ok="energy-beam-disciplines"
           data-props='<?= e(json_encode([
               'disciplines' => array_map(function($r) use ($img) {
                   $colors = ['#00F2FE', '#38BDF8', '#6366F1', '#9D4EDD', '#EC4899'];
                   $rgbs = [
                       [0.00, 0.949, 0.996],
                       [0.22, 0.741, 0.973],
                       [0.388, 0.400, 0.945],
                       [0.616, 0.306, 0.867],
                       [0.925, 0.282, 0.600]
                   ];
                   $taglines = [
                       'Autonomous codegen & self-healing review',
                       'Conversational voice & pipeline booking',
                       'Algorithmic ad scaling & content engine',
                       'Zero-error ERP & robotic data entry',
                       'Automated screening & SOP compliance'
                   ];
                   $tagList = [
                       ['Python', 'TypeScript', 'LangGraph', 'Docker', 'GitHub Actions'],
                       ['Twilio Voice', 'Whisper', 'Deepgram', 'Salesforce', 'HubSpot'],
                       ['Google Ads API', 'Meta API', 'SEO Matrix', 'Creative LLM', 'Analytics'],
                       ['SAP', 'NetSuite', 'Tally', 'PostgreSQL', 'OCR Pipeline'],
                       ['Workday', 'BambooHR', 'Resume Parser', 'Slack Bot', 'Notion RAG']
                   ];
                   $idx = ((int)$r[0] - 1) % 5;
                   return [
                       'num'     => $r[0],
                       'title'   => $r[1],
                       'tagline' => $taglines[$idx],
                       'desc'    => $r[2],
                       'tags'    => $tagList[$idx],
                       'image'   => $img('role/' . $r[0] . 'a.jpg'),
                       'color'   => $colors[$idx],
                       'rgb'     => $rgbs[$idx],
                   ];
               }, $roles)
           ], JSON_THROW_ON_ERROR)) ?>'>
      </div>

      <div class="sr-only">
        <?php foreach ($roles as [$n, $title, $body]): ?>
          <article>
            <span><?= e($n) ?></span>
            <h3><?= e($title) ?></h3>
            <p><?= e($body) ?></p>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           Band — a neural field backdrop
           --------------------------------------------------------------- */ ?>
  <section class="od-band">
    <div class="od-band-bg" aria-hidden="true"></div>
    <div class="od-band-backdrop" style="position: absolute; inset: 0; z-index: 0; overflow: hidden; pointer-events: none;">
      <img src="<?= e($img('band/01.jpg')) ?>" width="1200" height="700" alt=""
           style="width: 100%; height: 100%; object-fit: cover; opacity: 0.20; filter: saturate(1.2) contrast(1.15);">
      <div style="position: absolute; inset: 0; background: linear-gradient(90deg, rgba(6, 11, 24, 0.95) 0%, rgba(6, 11, 24, 0.7) 50%, rgba(6, 11, 24, 0.95) 100%), linear-gradient(180deg, rgba(6, 11, 24, 0.9) 0%, transparent 40%, rgba(6, 11, 24, 0.9) 100%);"></div>
    </div>

    <div class="od-shell od-band-inner">
      <h2>Deploy an autonomous AI workforce<br><em>that scales with your vision</em></h2>
      <button class="od-btn od-btn--primary" type="button"
              data-modal-open data-modal-service="Dedicated AI Agents">
        Hire Dedicated AI Agents<?= icon('arrow') ?>
      </button>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           Benefits — Motion Layer Scroller (3D isometric perspective cards)
           --------------------------------------------------------------- */ ?>
  <section class="od-sec od-benefits">
    <div class="od-shell">
      <div class="od-head">
        <p class="od-eyebrow"><span class="od-pulse" aria-hidden="true"></span>Strategic Value</p>
        <h2 class="od-title">Five architectural advantages<br>of <em>dedicated agentic swarms</em></h2>
        <p class="od-sub">
          Motion Layer Scroller: 3D isometric perspective layer stack. Wheel scroll or drag to explore how autonomous agent swarms transform organizational velocity.
        </p>
      </div>

      <div class="od-scroller-host"
           data-ok="motion-layer-scroller"
           data-props='<?= e(json_encode([
               'items' => array_map(function($b, $idx) use ($img) {
                   $colors = ['#00F2FE', '#38BDF8', '#6366F1', '#9D4EDD', '#EC4899'];
                   return [
                       'num'      => $b[0],
                       'title'    => $b[1],
                       'subtitle' => 'Agentic Advantage ' . $b[0],
                       'desc'     => $b[2],
                       'image'    => $img('benefit/' . $b[0] . '.jpg'),
                       'accent'   => $colors[$idx % 5],
                   ];
               }, $benefits, array_keys($benefits))
           ], JSON_THROW_ON_ERROR)) ?>'>
      </div>

      <dl class="sr-only">
        <?php foreach ($benefits as [$n, $title, $body]): ?>
          <div>
            <dt><?= e($n) ?>. <?= e($title) ?></dt>
            <dd><?= e($body) ?></dd>
          </div>
        <?php endforeach; ?>
      </dl>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           The five steps — Process Roadmap (Winding SVG Roadmap)
           --------------------------------------------------------------- */ ?>
  <div class="od-roadmap-mount"
       data-ok="process-roadmap"
       data-props='<?= e(json_encode([
           'stages' => array_map(function($s, $idx) use ($img) {
               $offsets = [0.08, 0.28, 0.48, 0.68, 0.88];
               $taglines = [
                   'Operational discovery & friction audit',
                   'Custom topology & API tool binding',
                   'Supervised sandbox & benchmark trial',
                   'Full autonomous dispatch & escalation',
                   'Vector memory & continuous tuning'
               ];
               $durations = ['48 Hours', '3–5 Days', '1 Week', 'Day 1', 'Continuous'];
               $deliverables = [
                   'Agentic opportunity matrix',
                   'Production API architecture',
                   'Verified accuracy scorecard',
                   'Live agent swarm in production',
                   'Active model fine-tuning loop'
               ];
               return [
                   'num'      => $s[0],
                   'at'       => $offsets[$idx],
                   'side'     => $idx % 2 === 0 ? 'top' : 'bottom',
                   'title'    => $s[1],
                   'tagline'  => $taglines[$idx],
                   'desc'     => $s[2],
                   'duration' => $durations[$idx],
                   'out'      => $deliverables[$idx],
                   'image'    => $img('step/' . $s[0] . '.jpg'),
               ];
           }, $steps, array_keys($steps))
       ], JSON_THROW_ON_ERROR)) ?>'>
  </div>

  <?php /* ---------------------------------------------------------------
           Hiring & Deployment models — Bookmark Models
           --------------------------------------------------------------- */ ?>
  <section class="od-sec od-models" data-models>
    <div class="od-shell">
      <div class="od-head">
        <p class="od-eyebrow"><span class="od-pulse" aria-hidden="true"></span>Deployment Frameworks</p>
        <h2 class="od-title">Three ways to deploy<br><em>dedicated agentic AI</em></h2>
        <p class="od-sub">
          Whether you need an instant plug-and-play role or a custom multi-agent enterprise swarm, our commercial models scale smoothly with your operations.
        </p>
      </div>

      <div class="od-bookmark-models-host"
           data-ok="bookmark-models"
           data-props='<?= e(json_encode([
               'models' => array_map(function($m, $idx) use ($img) {
                   $tags = ['— READY-MADE AGENT®', '— BESPOKE SQUAD®', '— ENTERPRISE CLUSTER®'];
                   $subtitles = [
                       'Instant plug-and-play autonomous roles',
                       'Custom-engineered swarm for your SOPs',
                       'Full private cloud autonomous transformation'
                   ];
                   $accents = ['#00F2FE', '#9D4EDD', '#EC4899'];
                   $rgbs = ['0, 242, 254', '157, 78, 221', '236, 72, 153'];
                   $titles = ['Ready Agents.', 'Custom Squad.', 'Autonomous Cluster.'];
                   $featureLists = [
                       [
                           'Deploy inside your tools in 48 hours',
                           'Pre-trained CRM, voice, QA & marketing roles',
                           'Standardized monthly subscription',
                           'Guaranteed 99.8% uptime SLA'
                       ],
                       [
                           'Engineered for proprietary internal SOPs',
                           'Direct integration with SAP, NetSuite & ERP',
                           'Custom tool use & private vector memory',
                           'Dedicated AI Systems Architect included'
                       ],
                       [
                           'Isolated private VPC / On-premise deploy',
                           'Unlimited horizontal N-agent scaling',
                           'Custom fine-tuned SLMs on your data',
                           'Complete SOC2, GDPR & data sovereignty'
                       ]
                   ];
                   return [
                       'id'        => 'model-' . $m[0],
                       'tag'       => $tags[$idx],
                       'title'     => $titles[$idx],
                       'subtitle'  => $subtitles[$idx],
                       'quote'     => $m[2],
                       'accent'    => $accents[$idx],
                       'accentRgb' => $rgbs[$idx],
                       'image'     => $img('model/' . $m[0] . '.jpg'),
                       'activeIndex' => $idx,
                       'features'  => $featureLists[$idx]
                   ];
               }, $models, array_keys($models))
           ], JSON_THROW_ON_ERROR)) ?>'>
      </div>

      <div class="sr-only">
        <?php foreach ($models as $i => [$n, $title, $body, $tags]): ?>
          <article>
            <span><?= e($n) ?></span>
            <h3><?= e($title) ?></h3>
            <p><?= e($body) ?></p>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           Tech Stack Dropzone — Matter.js physics pill spawner
           --------------------------------------------------------------- */ ?>
  <section class="od-sec od-dropzone-sec">
    <div class="od-shell">
      <div class="od-head od-head--mid">
        <p class="od-eyebrow"><span class="od-pulse" aria-hidden="true"></span>Agentic Technology Stack</p>
        <h2 class="od-title">Production frameworks & models<br><em>powering your agents</em></h2>
        <p class="od-sub">
          Interactive physics dropzone: click anywhere in the arena to drop new agentic model capsules, or drag and fling them across the floor.
        </p>
      </div>

      <div class="od-dropzone-host"
           data-ok="tech-dropzone"
           data-props='{"height": 520, "gravity": 1.1, "restitution": 0.62}'></div>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           Mid CTA
           --------------------------------------------------------------- */ ?>
  <section class="od-midcta" style="position: relative; overflow: hidden;">
    <div class="od-midcta-backdrop" style="position: absolute; inset: 0; z-index: 0; pointer-events: none;">
      <img src="<?= e($img('midcta/01.jpg')) ?>" width="1200" height="700" alt=""
           style="width: 100%; height: 100%; object-fit: cover; opacity: 0.18; filter: saturate(1.2) contrast(1.1);">
      <div style="position: absolute; inset: 0; background: linear-gradient(180deg, rgba(6, 11, 24, 0.92) 0%, rgba(6, 11, 24, 0.75) 50%, rgba(6, 11, 24, 0.92) 100%);"></div>
    </div>
    <div class="od-shell" style="position: relative; z-index: 1;">
      <h2>Ready to automate every sector<br><em>with dedicated Agentic AI?</em></h2>
      <button class="od-btn od-btn--primary" type="button"
              data-modal-open data-modal-service="Dedicated AI Agents">
        Commission Your AI Agents<?= icon('arrow') ?>
      </button>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           Sixteen reasons — Dual 3D Infinite Perspective Card Gallery
           --------------------------------------------------------------- */ ?>
  <section class="od-sec od-advantage">
    <div class="od-shell">
      <div class="od-head od-head--mid">
        <p class="od-eyebrow"><span class="od-pulse" aria-hidden="true"></span>The Agentic Advantage</p>
        <h2 class="od-title">Sixteen reasons enterprises<br><em>automate with our agents</em></h2>
        <p class="od-sub">
          Dual 3D Perspective Gallery: Pan cursor for perspective tilt, hover to pause, or click any card to inspect all sixteen reasons forward-thinking enterprises deploy iThrive dedicated AI agents.
        </p>
      </div>

      <div class="od-perspective-gallery-host"
           data-ok="infinite-perspective-gallery"
           data-props='<?= e(json_encode([
               'images' => array_map(function($a) use ($img) {
                   return [
                       'num'   => $a[0],
                       'title' => $a[1],
                       'desc'  => $a[2],
                       'src'   => $img('adv/' . $a[0] . '.jpg'),
                   ];
               }, $advantage),
               'speed'                => 220,
               'autoplay'             => true,
               'pauseOnHover'         => true,
               'perspective'          => 1000,
               'parallaxEnabled'      => true,
               'parallaxAmount'       => 2.5,
               'spacing'              => 280,
               'cardWidth'            => 299,
               'cardHeight'           => 380,
               'railRotation'         => 70,
               'depthEffectIntensity' => 0.75,
               'maxBlur'              => 3.5,
               'farOpacity'           => 0.38,
               'tunnelFadeLength'     => 220,
               'nearScale'            => 1.08,
               'shadowIntensity'      => 1.0,
           ], JSON_THROW_ON_ERROR)) ?>'>
      </div>

      <div class="sr-only">
        <?php foreach ($advantage as [$n, $title, $body]): ?>
          <article>
            <span><?= e($n) ?></span>
            <h3><?= e($title) ?></h3>
            <p><?= e($body) ?></p>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           FAQ
           --------------------------------------------------------------- */ ?>
  <section class="od-sec od-faq">
    <div class="od-shell od-faq-grid">
      <div class="od-faq-side">
        <p class="od-eyebrow"><span class="od-pulse" aria-hidden="true"></span>FAQ</p>
        <h2 class="od-title">What leaders ask<br>before <em>deploying agents</em></h2>
        <figure class="od-faq-art">
          <img src="<?= e($img('faq/01.jpg')) ?>" width="900" height="700"
               alt="Enterprise AI consultation" loading="lazy" decoding="async">
        </figure>
      </div>

      <div class="od-faq-list">
        <?php foreach ($faqs as $i => [$q, $a]): ?>
          <details class="od-faq-item"<?= $i === 0 ? ' open' : '' ?>>
            <summary><?= e($q) ?><span class="od-faq-mark" aria-hidden="true"></span></summary>
            <div class="od-faq-body"><p><?= e($a) ?></p></div>
          </details>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           Close — water ripple wash
           --------------------------------------------------------------- */ ?>
  <section class="od-close">
    <div class="od-close-wrap" aria-hidden="true">
      <img class="od-close-img" src="<?= e($img('close/01.jpg')) ?>"
           width="1200" height="700" alt="" loading="lazy" decoding="async">
      <div class="od-close-wash"></div>
    </div>

    <div class="od-shell od-close-copy">
      <p class="od-eyebrow"><span class="od-pulse" aria-hidden="true"></span>Next Step</p>
      <h2>Ready to build or hire your<br><em>dedicated AI agents?</em></h2>
      <p class="od-close-lead">
        Tell us where your operations face friction — whether in development, CRM, voice sales, or repetitive ERP tasks. Directly hire our pre-built autonomous agents or commission a bespoke agentic architecture scaled to your exact organizational requirements.
      </p>
      <div class="od-actions od-actions--mid">
        <button class="od-btn od-btn--primary" type="button"
                data-modal-open data-modal-service="Dedicated AI Agents">
          Hire Dedicated AI Agents<?= icon('arrow') ?>
        </button>
      </div>
    </div>
  </section>

</div>

<script type="module" src="<?= e(url('assets/dist/originkit/originkit.js')) ?>"></script>
<script src="<?= e(asset('assets/js/ondemand-page.js')) ?>" defer></script>
<script src="<?= e(asset('assets/js/webgl-poster.js')) ?>" defer></script>

<?php
require dirname(__DIR__) . '/includes/footer.php';
