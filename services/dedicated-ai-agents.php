<?php
/**
 * Dedicated AI Agents — Autonomous Agentic AI Workforces for Enterprise.
 *
 * Modeled identically after on-demand-resources.php with full OriginKit
 * WebGL and Framer components:
 *
 *   hero      Tear reveal — daylight plate torn to the neon night one beneath
 *             (shared assets/js/neon-reveal.js; replaced the WebGPU flare)
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
$pageTitle = 'AI Agent Development Company in India';
$pageDesc  = 'iThrive Software is an AI agent development company in India, building autonomous agents and multi-agent systems for sales, support, finance and HR.';
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

/**
 * Industries. Eight verticals where an agent has a job description rather than
 * a demo — the sectors the enquiries actually come from.
 */
$industries = [
    ['building',    'Banking & Financial Services', 'Reconciliation queues, KYC review, exception handling and customer correspondence — every action logged against the record it touched.'],
    ['stethoscope', 'Healthcare & Diagnostics',     'Intake summarisation, coding support, prior-authorisation paperwork and follow-up scheduling. Drafting only where care is decided.'],
    ['cart',        'Retail & eCommerce',           'Catalogue enrichment, pricing surveillance, returns triage and support deflection across the channels your customers actually use.'],
    ['factory',     'Manufacturing & Supply Chain', 'Purchase-order matching, supplier chasing, quality-report reading and shortage escalation between your ERP and the floor.'],
    ['message',     'Telecom & Subscription',       'Plan changes, churn saves, billing disputes and field-dispatch coordination handled end to end with a human on the exceptions.'],
    ['zap',         'Energy & Utilities',           'Meter-data validation, outage correspondence, compliance filings and anomaly review across estates too large to read by hand.'],
    ['terminal',    'Enterprise IT & DevOps',       'Ticket triage, runbook execution, dependency upgrades and release notes — agents inside the pipeline, not beside it.'],
    ['users',       'Customer Operations',          'First-line resolution, case summarisation and CRM hygiene, with the handover to a person written into the workflow.'],
];

/**
 * Governance. The reference sites call this "ethical AI"; on an engineering
 * page it is six mechanisms, because a principle you cannot point at in the
 * code is a disclaimer rather than a control.
 */
$governance = [
    ['target',  'A written decision boundary',   'Before an agent ships we agree, on paper, which decisions it owns, which it only drafts, and which it must escalate. That document is the spec.'],
    ['check',   'Human sign-off where it counts','Anything that moves money, changes an entitlement or touches clinical care is drafted by the agent and approved by a person. No exceptions bolted on later.'],
    ['search',  'A full action trail',           'Every tool call, input and output is recorded against the record it touched, so an auditor can reconstruct what happened without reading a model log.'],
    ['lock',    'Your data stays yours',         'Agents run against your tenancy and your keys. Nothing is used to train a shared model, and residency is configured before the first deployment.'],
    ['gauge',   'Evaluated before promotion',    'Each agent is scored against a fixed set of your own cases, and a release that regresses on that set does not reach production.'],
    ['refresh', 'A stop and a rollback',         'One switch halts a squad mid-run, and every autonomous action has a defined reversal. Autonomy you cannot stop is not autonomy, it is exposure.'],
];

/**
 * Structured data. The page had none, which for a page meant to rank for
 * "Agentic AI development company in India" is the single largest omission —
 * the FAQ answers below are exactly what an answer engine quotes.
 */
$schema = [
    '@type'       => 'Service',
    'name'        => 'Agentic AI Development',
    'serviceType' => 'Agentic AI Development',
    'description' => 'Design, engineering and operation of autonomous AI agents and multi-agent '
                   . 'systems for enterprises across India.',
    'url'         => canonical('services/dedicated-ai-agents.php'),
    'provider'    => ['@type' => 'Organization', 'name' => SITE_NAME, 'url' => canonical('')],
    'areaServed'  => areas_served(),
    'hasOfferCatalog' => [
        '@type'           => 'OfferCatalog',
        'name'            => 'Agentic AI development services',
        'itemListElement' => array_map(static fn (array $r): array => [
            '@type'       => 'Offer',
            'itemOffered' => ['@type' => 'Service', 'name' => $r[1], 'description' => $r[2]],
        ], $roles),
    ],
];

$schemaExtra = [
    [
        '@type'      => 'FAQPage',
        'name'       => 'Agentic AI development — frequently asked questions',
        'speakable'  => [
            '@type'       => 'SpeakableSpecification',
            'cssSelector' => ['.od-faq-item summary', '.od-faq-body p'],
        ],
        'mainEntity' => array_map(static fn (array $f): array => [
            '@type'          => 'Question',
            'name'           => $f[0],
            'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f[1]],
        ], $faqs),
    ],
];

require dirname(__DIR__) . '/includes/header.php';

$img = static function (string $rel): string {
    $photo = 'assets/img/ai-agents/' . $rel;
    return asset(is_file(ROOT_PATH . '/' . $photo) ? $photo : 'assets/img/ai-agents/' . $rel);
};
?>

<div class="od od--ai-agents">

  <?php /* ---------------------------------------------------------------
           Hero — tear reveal, the shared assets/js/neon-reveal.js treatment.

           One scene shot twice: daylight in front, the same frame at neon
           night behind. The pointer erases the front layer in ragged patches
           that heal over a few seconds.

           No cursor shape trail here. It is a second pointer-reactive field,
           and two of them over each other read as noise rather than as either
           one — the same reason neon.php hides the honeycomb behind its hero.
           Dropping data-trail is safe: ondemand-page.js guards on the element
           existing.
           --------------------------------------------------------------- */ ?>
  <section class="od-hero od-hero--reveal" data-neon-reveal
           data-front="<?= e(asset('assets/img/robot/robot-day-wide.webp')) ?>">
    <div class="od-reveal-bleed" aria-hidden="true"></div>
    <img class="od-reveal-back" src="<?= e(asset('assets/img/robot/robot-night-wide.webp')) ?>"
         width="1672" height="941"
         alt="The iThrive robot leaning on a black car, the city behind it lit in neon at night"
         fetchpriority="high" decoding="async">
    <canvas class="od-reveal-veil"></canvas>
    <div class="od-reveal-scrim" aria-hidden="true"></div>

    <p class="od-reveal-hint">Move to reveal</p>

    <div class="od-shell od-reveal-band">
      <div>
        <p class="od-eyebrow"><span class="od-pulse" aria-hidden="true"></span>Agentic AI Development · India</p>

        <h1 class="od-h1">
          Agentic AI Development<br>
          <em>Company in India</em>
        </h1>

        <div class="od-actions">
          <button class="od-btn od-btn--primary" type="button"
                  data-modal-open data-modal-service="Dedicated AI Agents">
            Deploy Dedicated AI Agents<?= icon('arrow') ?>
          </button>
          <a class="od-btn od-btn--ghost" href="#od-roles">Explore 5 Agent Disciplines</a>
        </div>
      </div>

    </div>

    <ul class="od-stats od-shell od-reveal-stats">
      <?php foreach ($stats as [$v, $l]): ?>
        <li><strong><?= e($v) ?></strong><span><?= e($l) ?></span></li>
      <?php endforeach; ?>
    </ul>
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
            We build and deploy dedicated autonomous AI Agents for all your works: Full-Stack Development, Marketing, Sales, Operations, Digital Marketing, ERP Task Automation, HRMS, and Autonomous Voice Calling. Directly hire our ready-to-deploy Agentic AI or let us engineer a custom dedicated swarm scaled to <em>N</em> agents tailored to your exact business needs.
          </p>
          <p>
            Traditional staffing creates inevitable bottlenecks: manual handovers, context fragmentation, delayed responses, and human fatigue across high-frequency operations. Every time a ticket sits waiting between development, marketing, sales, and ERP data entry, revenue velocity stalls.
          </p>
          <p>
            Dedicated AI Agents eliminate these friction points entirely. By continuously executing across code repositories, voice telephony lines, CRM pipelines, and enterprise ledgers, an autonomous agent swarm achieves in minutes what previously took weeks of coordination — with zero context decay and 24/7 reliability.
          </p>
        </div>
      </div>

      <?php /* -----------------------------------------------------------
           The agent floor — the render turned into a scene you can walk a
           pointer across.

           Depth is real perspective, not a parallax fake: the stage owns the
           `perspective`, and the plate and the marker plane sit inside it at
           different translateZ, so rotating their shared parent swings the
           markers through a wider arc than the plate behind them.

           Coordinates are percentages of the plate, so they hold at every
           width — the art and the markers scale together.
           ----------------------------------------------------------- */ ?>
      <?php
      /** [n, name, what it does, centre x%, centre y%, width%] — the x/y/w
       *  frame each label already printed on the plate, so the hotspot IS the
       *  label rather than a second marker sitting on top of it. */
      $floor = [
          ['01', 'Project Manager',     'Plans sprints, tracks dependencies and keeps every other agent unblocked.',      22.9, 28.9, 8.4],
          ['02', 'Software Developer',  'Ships features end to end, from schema migration to reviewed pull request.',     33.3, 28.9, 8.9],
          ['03', 'Frontend Developer',  'Builds the interface, wires state and holds the design system honest.',          44.6, 28.9, 9.5],
          ['04', 'Backend Developer',   'Owns services, queues and data integrity under load.',                           55.5, 28.9, 9.3],
          ['05', 'UI/UX Developer',     'Turns flows into layouts, and layouts into components that survive contact.',    65.0, 28.9, 9.4],
          ['06', 'Data Analyst',        'Answers the questions the dashboard cannot, and says how confident it is.',      23.9, 37.1, 7.2],
          ['07', 'Data Scientist',      'Builds and retrains the models the rest of the floor reasons with.',             33.1, 37.1, 7.2],
          ['08', 'Research Agent',      'Reads everything published in your space and reports only what changed.',        44.9, 37.1, 8.0],
          ['09', 'Marketing Agent',     'Runs multimodal content and campaign distribution on a continuous loop.',        56.3, 37.1, 8.7],
          ['10', 'SEO Agent',           'Programmatic SEO, intent clustering and technical fixes filed as tickets.',      68.0, 37.1, 6.9],
          ['11', 'Sales Agent',         'Qualifies inbound, follows up outbound and keeps the CRM pipeline true.',        20.7, 46.2, 7.0],
          ['12', 'Customer Support',    'Deflects the repeat questions and escalates the ones that deserve a human.',     33.0, 46.2, 9.3],
          ['13', 'Finance Agent',       'Reconciles ledgers, parses invoices and flags the variance before close.',       46.7, 46.2, 7.7],
          ['14', 'HR Agent',            'Onboards, verifies SOP compliance and answers policy without a ticket.',         59.9, 46.2, 6.5],
          ['15', 'Recruiter',           'Screens semantically, schedules itself and compresses the hiring cycle.',        74.5, 46.2, 6.6],
          ['16', 'Email Agent',         'Triages the inbox, drafts the reply and never loses a thread.',                  19.9, 59.1, 8.1],
          ['17', 'Meeting Assistant',   'Joins, transcribes, extracts the decisions and files the follow-ups.',           33.4, 59.1, 9.3],
          ['18', 'Knowledge Agent',     'Holds the institutional memory and cites where every answer came from.',         48.2, 59.1, 9.7],
          ['19', 'Strategy Agent',      'Models the options, argues both sides and shows its working.',                   62.3, 59.1, 9.9],
          ['20', 'Executive Assistant', 'Guards the calendar, prepares the brief and chases what was promised.',          79.9, 59.1, 11.2],
      ];
      ?>
      <div class="od-floor" data-agent-floor>
        <div class="od-floor-tilt" data-floor-tilt>
          <img class="od-floor-plate" src="<?= e($img('open/agent-floor.webp')) ?>"
               width="1672" height="941"
               alt="An iThrive floor of autonomous AI agents at work, each desk labelled with its role"
               loading="lazy" decoding="async">

          <div class="od-floor-markers" data-floor-markers>
            <?php foreach ($floor as [$n, $name, $desc, $x, $y, $w]): ?>
              <button class="od-floor-pin" type="button"
                      style="--x: <?= $x ?>%; --y: <?= $y ?>%; --w: <?= $w ?>%;"
                      data-agent="<?= e($name) ?>" data-n="<?= e($n) ?>" data-desc="<?= e($desc) ?>"
                      aria-label="<?= e($name . '. ' . $desc) ?>"></button>
            <?php endforeach; ?>
          </div>
        </div>

        <div class="od-floor-card" data-floor-card hidden>
          <span class="od-floor-card-n" data-floor-card-n></span>
          <strong data-floor-card-name></strong>
          <span data-floor-card-desc></span>
        </div>

        <p class="od-floor-hint">Move across the floor — hover or tap an agent</p>
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
           Industries. Eight verticals, because "we serve every industry" is
           the claim every competitor makes and none of them can evidence.
           --------------------------------------------------------------- */ ?>
  <section class="od-sec od-industries" id="od-industries">
    <div class="od-shell">
      <p class="od-eyebrow"><span class="od-pulse" aria-hidden="true"></span>Industries</p>
      <h2 class="od-title">Where an agent already<br>holds <em>a job description</em></h2>
      <p class="od-sub">
        Agentic AI development in India concentrates in eight sectors. In each one the useful
        question is never what a model can generate — it is which step of the working day an agent
        can take off a desk without anyone losing sight of where it went.
      </p>

      <ul class="od-verticals">
        <?php foreach ($industries as [$ic, $name, $body]): ?>
          <li class="od-vertical">
            <?= icon($ic, 'icon od-vertical-icon') ?>
            <h3><?= e($name) ?></h3>
            <p><?= e($body) ?></p>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           Governance. Six mechanisms rather than six values — a principle
           you cannot point at in the code is a disclaimer, not a control.
           --------------------------------------------------------------- */ ?>
  <section class="od-sec od-governance" id="od-governance">
    <div class="od-shell">
      <p class="od-eyebrow"><span class="od-pulse" aria-hidden="true"></span>Governance</p>
      <h2 class="od-title">Autonomy is only useful<br>when it is <em>bounded on purpose</em></h2>
      <p class="od-sub">
        Every agent we ship carries a boundary: what it decides, what it only drafts, and where a
        person still signs. These six are mechanisms in the build, not promises in a policy page.
      </p>

      <ul class="od-guards">
        <?php foreach ($governance as [$ic, $name, $body]): ?>
          <li class="od-guard">
            <?= icon($ic, 'icon od-guard-icon') ?>
            <h3><?= e($name) ?></h3>
            <p><?= e($body) ?></p>
          </li>
        <?php endforeach; ?>
      </ul>
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
<script type="module" src="<?= e(asset('assets/js/neon-reveal.js')) ?>"></script>
<script type="module" src="<?= e(asset('assets/js/agent-floor.js')) ?>"></script>

<?php
require dirname(__DIR__) . '/includes/footer.php';
