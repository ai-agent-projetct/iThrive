<?php
/**
 * Enterprise AI Agent Solutions & Autonomous Workforce Platforms
 *
 * Enterprise AI Service Page engineered with modern dark cyber UI,
 * 6 Core Capabilities, 5 Strategic ROI Advantages, 5-Step Process Roadmap,
 * 3 Deployment Frameworks, Tech Stack Arena, and 10 Detailed FAQs with Schema.org JSON-LD.
 */

declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/config.php';

$page         = 'services';
$pageTitle    = 'Enterprise AI Agent Solutions & Autonomous Workforce Platforms';
$pageDesc     = 'Deploy turnkey autonomous agent solutions across engineering, sales pipelines, customer success, ERP ledger reconciliation, and supply chain logistics.';
$ogImage      = 'assets/img/services/svc-09-agent-solutions.jpg';

/* ---------------------------------------------------------------------------
 * Content Definitions
 * ------------------------------------------------------------------------ */

$stats = [['10x', 'Operational Velocity Multiple'], ['85%', 'Repetitive Task Deflection Rate'], ['50+', 'Pre-Trained Agent Archetypes'], ['99.9%', 'System Execution Uptime']];

$disciplines = [['01', 'Autonomous Software Engineering & QA Swarms', 'Automating code review, pull request testing, schema migration validation, and self-healing bug fixes directly inside GitHub and GitLab.'], ['02', 'Sales Pipeline & Conversational Voice SDRs', 'Sub-400ms voice call agents and email swarms that qualify inbound leads, book calendar meetings, and update CRM records automatically.'], ['03', 'ERP & Financial Ledger Reconciliation Agents', 'Automated three-way invoice matching, bank reconciliation, expense audit parsing, and SAP/NetSuite data sync with 100% accuracy.'], ['04', 'Customer Success & Triage Swarms', 'Omnichannel customer resolution agents across Zendesk, Intercom, and WhatsApp resolving 80%+ of inquiries without human escalation.'], ['05', 'Supply Chain & Logistics Dispatch Agents', 'Automated shipment tracking, freight rate negotiation parsing, customs manifest compliance, and vendor delay remediation.'], ['06', 'HR Talent Screening & Employee Onboarding', 'Semantic resume ranking, automated preliminary screening questionnaires, and interactive onboarding assistance for new hires.']];

$benefits = [['01', 'Immediate Time-to-Value', 'Deploy pre-built, domain-tested agent solution archetypes inside your existing enterprise tools in days rather than months.'], ['02', 'Massive Operational Deflection', 'Deflect 85%+ of repetitive, manual operational tasks so your core human teams focus on high-leverage strategic growth.'], ['03', 'Seamless Cross-Departmental Coordination', 'Agents pass structured context across sales, engineering, operations, and finance with zero information loss.'], ['04', 'Unbroken 24/7 Continuous Execution', 'Enterprise agent swarms work indefatigably across all time zones, clearing backlogs and delivering reports by dawn.'], ['05', 'Strict Enterprise Compliance & Auditing', 'Every agent decision and tool execution is recorded with full audit trails meeting SOC 2 and ISO 27001 standards.']];

$steps = [['01', 'Departmental Workflow Assessment', 'Auditing current operational bottlenecks, tool permissions, and selecting high-ROI agent solution archetypes.'], ['02', 'Tool Binding & Context Grounding', 'Connecting agent solutions to your Salesforce, SAP, Jira, Slack, and database systems with strict RBAC.'], ['03', 'Pilot Sandbox Benchmarking', 'Running agent solutions in parallel with human operators to evaluate deflection rates, accuracy, and latency.'], ['04', 'Production Phased Rollout', 'Gradually increasing autonomous execution thresholds while maintaining human supervisor review on critical edge cases.'], ['05', 'Continuous Optimization & Tuning', 'Monitoring operational throughput, token consumption, user feedback, and refining agent prompts via active learning.']];

$models = [['01', 'Departmental Agent Solution', 'Deploy a complete turnkey agent solution suite for one department (e.g., Sales SDR or Customer Support) with standard tool connectors.', ['1-week deployment', 'Standard CRM/ERP integration', '99.5% uptime SLA']], ['02', 'Cross-Functional Swarm Suite', 'Integrated multi-agent workforce spanning Sales, Engineering, and Finance with custom tool binding and bi-directional sync.', ['Cross-department routing', 'Custom API connectors', 'Human-in-the-loop portal']], ['03', 'Enterprise Autonomous Workforce', 'Full organizational transformation with dedicated private VPC deployment, unlimited agent scaling, and fractional AI architect.', ['Air-gapped private cloud', 'Unlimited N-agent scale', '24/7 SRE monitoring']]];

$techStack = ['LangGraph', 'Python', 'Salesforce API', 'SAP Connector', 'HubSpot', 'Jira API', 'Twilio Voice', 'Qdrant', 'Docker', 'Kubernetes'];

$pageStack = [
    ['slug' => 'agents', 'title' => 'Archetype Runtime', 'icon' => 'rocket',
     'blurb' => 'The proven agent, configured against your systems.',
     'items' => [
         ['name' => 'LangChain', 'logo' => 'langchain'],
         ['name' => 'OpenAI', 'logo' => 'openai'],
         ['name' => 'Anthropic', 'logo' => 'anthropic'],
         ['name' => 'Python', 'logo' => 'python'],
     ]],
    ['slug' => 'data', 'title' => 'Your Data', 'icon' => 'database',
     'blurb' => 'Pointed at your records, your terminology, your thresholds.',
     'items' => [
         ['name' => 'PostgreSQL', 'logo' => 'postgresql'],
         ['name' => 'Redis', 'logo' => 'redis'],
         ['name' => 'OpenSearch', 'logo' => 'opensearch'],
         ['name' => 'MongoDB', 'logo' => 'mongodb'],
     ]],
    ['slug' => 'platform', 'title' => 'Deployment', 'icon' => 'cloud',
     'blurb' => 'Live in days because the build is already done.',
     'items' => [
         ['name' => 'Docker', 'logo' => 'docker'],
         ['name' => 'Kubernetes', 'logo' => 'kubernetes'],
         ['name' => 'AWS', 'logo' => 'amazonwebservices'],
         ['name' => 'Grafana', 'logo' => 'grafana'],
     ]],
];

$faqs = [['What makes an AI Agent Solution different from standard SaaS software?', 'Standard SaaS software requires manual human operation and rigid button-clicking. An AI Agent Solution acts as an autonomous digital worker that reasons, plans, executes multi-step workflows, interacts with multiple software systems simultaneously, and solves problems with minimal human intervention.'], ['Can we deploy your pre-built agent solutions into our existing software stack?', 'Yes. Our agent solutions connect directly to your existing tools (Salesforce, HubSpot, Jira, SAP, Zendesk, Slack, GitHub) via secure APIs without requiring you to replace your current tech stack.'], ['How quickly can an enterprise deploy an AI agent solution?', 'Our pre-built agent archetypes (such as Sales SDRs, customer triage, and code review agents) can be integrated and live in your sandbox within 48 to 72 hours. Custom domain integrations typically take 2 to 3 weeks.'], ['How do voice SDR agents handle phone conversations with customers?', 'Our voice SDR agents operate with sub-400ms latency, natural speech cadence, and real-time interruption handling. They qualify prospect interest, answer technical questions from your knowledge base, and book meetings directly into your calendar.'], ['How do financial ledger agents ensure zero calculation errors?', 'Financial agents do not rely on probabilistic LLM math. They use deterministic Python scripts, SQL verification queries, and strict three-way matching algorithms to validate all financial calculations before logging transactions.'], ['What happens when an agent encounters an edge case it cannot solve?', 'The agent uses automated confidence scoring. If confidence drops below a set threshold, it gracefully pauses and sends a detailed briefing with recommended actions to a human supervisor via Slack or Teams.'], ['Are your agent solutions compliant with SOC 2, HIPAA, and GDPR regulations?', 'Yes. We implement end-to-end encryption, strict zero-retention data policies, granular RBAC access controls, and comprehensive immutable audit logging.'], ['How many autonomous agents can run simultaneously in an enterprise?', 'Our architecture supports elastic horizontal scaling to N agents. You can run 5 agents or 500 agents concurrently handling millions of events with automated load balancing.'], ['Can we customize the personality, tone, and guardrails of the agents?', 'Yes. We fully configure system prompts, brand guidelines, tone of voice, terminology glossaries, and deterministic safety rules to match your company culture.'], ['What ongoing support and maintenance do you provide after deployment?', 'We provide 24/7 AgentOps monitoring, latency and hallucination tracking, prompt fine-tuning, automated error recovery, and monthly architecture optimization reviews.']];

/** Schema.org Structured Data with FAQPage & Service */
$schema = [
    '@context' => 'https://schema.org',
    '@graph' => [
        [
            '@type' => 'Service',
            'name' => 'Enterprise AI Agent Solutions & Autonomous Workforce Platforms',
            'serviceType' => 'Agentic AI & Swarm Engineering',
            'description' => 'Deploy turnkey autonomous agent solutions across engineering, sales pipelines, customer success, ERP ledger reconciliation, and supply chain logistics.',
            'url' => canonical('services/ai-agent-solutions.php'),
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

<div class="svc-page" data-theme="catalogue">

  <!-- =========================================================================
       HERO SECTION: Cyber Eyebrow, Gradient Headline & Action CTAs
       ========================================================================= -->
  <section class="svc-hero">
    <div class="svc-shell svc-hero-inner">
      <p class="svc-eyebrow"><span class="svc-pulse" aria-hidden="true"></span>Autonomous Enterprise Solutions · End-to-End Swarms</p>

      <h1 class="svc-h1">
        Enterprise AI Agent Solutions For<br><em>Autonomous Cross-Functional Scale</em>
      </h1>

      <p class="svc-lead">
        Deploy turnkey autonomous agent solutions across software engineering, sales pipelines, customer success, ERP ledger reconciliation, and supply chain logistics.
      </p>

      <div class="svc-actions svc-actions--mid">
        <button class="svc-btn svc-btn--primary" type="button"
                data-modal-open data-modal-service="Enterprise AI Agent Solutions & Autonomous Workforce Platforms">
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
        <img src="<?= e(asset('assets/img/services/svc-09-agent-solutions.jpg')) ?>" width="1200" height="700"
             alt="Enterprise AI Agent Solutions & Autonomous Workforce Platforms Architecture" fetchpriority="high" decoding="async">
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
          <h2 class="svc-title">Departmental silos slow down operations;<br><em>agent solutions connect your entire enterprise</em></h2>
        </div>
        <div class="svc-open-copy">
          <p>Enterprises struggle with fragmented data handoffs between sales, engineering, finance, and customer support. Manual data transcription, delayed approvals, and ticket bottlenecks across departments lead to lost revenue and customer frustration.</p>
          <p>We deliver comprehensive Enterprise AI Agent Solutions designed to automate end-to-end departmental operations. Whether deploying autonomous voice SDRs for sales, self-healing code review agents for engineering, or robotic ledger reconciliation bots for finance, our integrated agent swarms work 24/7 across your enterprise stack.</p>
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
        <h2 class="svc-title">Six turnkey agent solution suites<br>for <em>enterprise operations</em></h2>
        <p class="svc-sub">Production-ready autonomous workforce solutions tailored to specific corporate functions.</p>
      </div>

      <div class="svc-cards-grid">
        <?php foreach ($disciplines as $i => [$num, $dTitle, $dDesc]): ?>
          <?php $fig = svc_img('09', 3, $i + 1); ?>
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
                data-modal-open data-modal-service="Enterprise AI Agent Solutions & Autonomous Workforce Platforms">
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
        <h2 class="svc-title">Five strategic business advantages<br>of our <em>Ai Agent Solutions</em></h2>
        <p class="svc-sub">
          Explore the architectural advantages that guarantee high concurrency, zero data leakage, and rapid payback timelines.
        </p>
      </div>

      <div class="svc-benefits-grid">
        <?php foreach ($benefits as $i => [$num, $bTitle, $bDesc]): ?>
          <?php $fig = svc_img('09', 5, $i + 1); ?>
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
      <div class="svc-roadmap" data-roadmap="grid" aria-hidden="true">
        <?php foreach ($steps as $idx => [$num, $sTitle]): ?>
          <span data-roadmap-node="<?= $idx ?>" data-label="<?= e($sTitle) ?>"></span>
        <?php endforeach; ?>
      </div>

      <?php
      $s6 = array_filter([svc_img('09', 6, 1), svc_img('09', 6, 2), svc_img('09', 6, 3)]);
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
        <h2 class="svc-title">Three ways to engage our<br><em>Ai Agent Solutions Practice</em></h2>
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
                    data-modal-open data-modal-service="Enterprise AI Agent Solutions & Autonomous Workforce Platforms (Model <?= e($num) ?>)">
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
            <img src="<?= e(asset('assets/img/services/svc-09-agent-solutions.jpg')) ?>" width="900" height="700"
                 alt="Enterprise AI Agent Solutions & Autonomous Workforce Platforms FAQ Consultation" loading="lazy" decoding="async">
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
      <h2>Ready to build or scale your<br><em>Ai Agent Solutions System?</em></h2>
      <p class="svc-close-lead">
        Discuss your technical requirements, latency constraints, and data governance policies directly with our Lead AI Systems Architects. Receive an actionable feasibility audit and prototype blueprint within 48 hours.
      </p>
      <div class="svc-actions svc-actions--mid">
        <button class="svc-btn svc-btn--primary" type="button"
                data-modal-open data-modal-service="Enterprise AI Agent Solutions & Autonomous Workforce Platforms">
          Start 48-Hour Technical Discovery<?= icon('arrow') ?>
        </button>
      </div>
    </div>
  </section>

</div>

<?php
require dirname(__DIR__) . '/includes/footer.php';
