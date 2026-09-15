<?php
/**
 * AgentOps, Telemetry & Continuous AI Operations Support
 *
 * Enterprise AI Service Page engineered with modern dark cyber UI,
 * 6 Core Capabilities, 5 Strategic ROI Advantages, 5-Step Process Roadmap,
 * 3 Deployment Frameworks, Tech Stack Arena, and 10 Detailed FAQs with Schema.org JSON-LD.
 */

declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/config.php';

$page         = 'services';
$pageTitle    = 'AgentOps, Telemetry & Continuous AI Operations Support';
$pageDesc     = '24/7 AgentOps monitoring, token cost tracking, hallucination drift detection, latency optimization, and automated model evaluation for production AI systems.';
$ogImage      = 'assets/img/services/svc-14-agent-operations.jpg';

/* ---------------------------------------------------------------------------
 * Content Definitions
 * ------------------------------------------------------------------------ */

$stats = [['99.99%', 'Agent Fleet Uptime'], ['Real-Time', 'Token Cost & Budget Telemetry'], ['<1 Hour', 'Mean Time to Remediation'], ['100%', 'Traceability on Agent Tool Calls']];

$disciplines = [['01', 'Full-Stack Distributed Tracing (OpenTelemetry)', 'Capturing every agent step, tool call, prompt payload, token count, and latency metric in a centralized observability mesh.'], ['02', 'Hallucination & Semantic Drift Continuous Monitoring', 'Automated real-time evaluation hooks that score factual groundedness, relevance, and safety on live production agent interactions.'], ['03', 'Real-Time Token Budget & Cost Governance', 'Setting granular cost caps per user, department, and workflow with automated rate-throttling and anomaly alerts.'], ['04', 'Automated CI/CD Regression Evaluation', 'Benchmarking updated prompts, tool definitions, and new foundation models against golden enterprise test datasets before production rollout.'], ['05', 'Latency Optimization & Semantic Caching SRE', 'Continuous profiling of Time-To-First-Token (TTFT), prompt compression, and vector cache hit rates to maximize performance.'], ['06', '24/7 AI SRE Incident Response & Support', 'Dedicated AI reliability engineers providing 24/7 on-call coverage, automated failure failovers, and root cause analysis.']];

$benefits = [['01', 'Guaranteed 99.99% Production Uptime', 'Proactive monitoring and automated failover routing prevent agent downtime and service disruptions.'], ['02', 'Full Traceability on Every Decision', 'Inspect the exact reasoning chain, tool inputs, and intermediate outputs for every agent execution.'], ['03', 'Up to 50% Reduction in Ongoing Token Costs', 'Eliminate runaway compute loops, optimize prompt tokens, and enforce strict spending controls.'], ['04', 'Zero Factual & Semantic Drift', 'Continuous automated benchmarking catches model performance regressions before they impact users.'], ['05', 'Enterprise Compliance & SOC 2 Auditing', 'Maintain immutable logs of all agent actions, data access, and human approvals for regulatory audits.']];

$steps = [['01', 'Agent Telemetry & Tracing Instrumenting', 'Integrating OpenTelemetry, LangSmith, and Prometheus collectors across all your agent microservices and tool endpoints.'], ['02', 'Evaluation Benchmark & Golden Dataset Setup', 'Establishing domain-specific golden test suites to measure accuracy, groundedness, and latency in CI/CD pipelines.'], ['03', 'Cost Governance & Alert Threshold Configuration', 'Setting up per-tenant token budgets, circuit breakers, and PagerDuty/Slack real-time incident escalation alerts.'], ['04', 'Performance Profiling & Cache Tuning', 'Analyzing production query patterns, tuning semantic cache hit rates, and compressing high-overhead system prompts.'], ['05', '24/7 Managed Operations Handover', 'Transitioning fleet management to our 24/7 AI SRE operations center with continuous health monitoring and monthly reviews.']];

$models = [['01', 'AgentOps Setup Sprint', 'A 2-week implementation integrating OpenTelemetry, LangSmith, cost tracking dashboards, and automated CI/CD evaluation harnesses.', ['2-week setup', 'Full tracing integration', 'Cost & budget dashboards']], ['02', 'Managed AgentOps & SRE (Standard)', 'Continuous 24/7 agent fleet monitoring, drift detection, incident triage, and monthly prompt/model optimization.', ['24/7 telemetry monitoring', '1-hour critical response SLA', 'Monthly cost optimization']], ['03', 'Enterprise Dedicated AI SRE Squad', 'Dedicated AI reliability engineers embedded in your team providing 24/7 on-call coverage, custom eval harnesses, and infrastructure SRE.', ['Dedicated AI SRE engineers', '15-minute response SLA', 'Continuous CI/CD evals']]];

$techStack = ['OpenTelemetry', 'LangSmith', 'Prometheus', 'Grafana', 'Arize Phoenix', 'RAGAS', 'Python', 'Kubernetes', 'PagerDuty', 'Docker'];

$pageStack = [
    ['slug' => 'observability', 'title' => 'Observability', 'icon' => 'gauge',
     'blurb' => 'What tells you accuracy slipped before a customer does.',
     'items' => [
         ['name' => 'Grafana', 'logo' => 'grafana'],
         ['name' => 'OpenSearch', 'logo' => 'opensearch'],
         ['name' => 'Python', 'logo' => 'python'],
         ['name' => 'PostgreSQL', 'logo' => 'postgresql'],
     ]],
    ['slug' => 'models', 'title' => 'Models & Evaluation', 'icon' => 'brain',
     'blurb' => 'The golden set, re-run on every upstream change.',
     'items' => [
         ['name' => 'OpenAI', 'logo' => 'openai'],
         ['name' => 'Anthropic', 'logo' => 'anthropic'],
         ['name' => 'LangChain', 'logo' => 'langchain'],
         ['name' => 'PyTorch', 'logo' => 'pytorch'],
     ]],
    ['slug' => 'platform', 'title' => 'Release & Rollback', 'icon' => 'cloud',
     'blurb' => 'A defined stop and a tested way back.',
     'items' => [
         ['name' => 'Kubernetes', 'logo' => 'kubernetes'],
         ['name' => 'Docker', 'logo' => 'docker'],
         ['name' => 'Terraform', 'logo' => 'terraform'],
         ['name' => 'GitHub Actions', 'logo' => 'githubactions'],
     ]],
];

$faqs = [['What is AgentOps and why is it necessary for production AI systems?', 'AgentOps (Agent Operations) is the discipline of monitoring, evaluating, and maintaining autonomous AI agents in production. Unlike traditional software, AI agents are non-deterministic; AgentOps provides continuous distributed tracing, hallucination detection, cost governance, and automated testing to ensure agents operate reliably and cost-effectively.'], ['How do you monitor agent tool calls and reasoning chains in real time?', 'We instrument your agents with OpenTelemetry and LangSmith, capturing every step: prompt inputs, LLM reasoning tokens, tool selection, API payloads, execution latency, and final responses in interactive trace visualizations.'], ['How do you detect model drift and hallucinations automatically?', 'We run continuous evaluation hooks (using RAGAS, TruLens, and LLM-as-a-judge models) on production sampling streams to evaluate factual groundedness, context precision, and safety scores against historical baselines.'], ['How do you prevent runaway token bills and unexpected cloud costs?', 'We configure hard token spending caps, anomaly detection alerts, and rate-limiting middleware that automatically throttles or halts agent execution if an agent gets stuck in a repetitive loop.'], ['What happens when an AI foundation model API goes down?', 'Our AgentOps architecture includes automated circuit breakers and multi-provider failover routing. If OpenAI or Anthropic experiences an outage, requests are instantly routed to an alternative foundation model or local vLLM backup.'], ['Can AgentOps telemetry be hosted in our private VPC without external data leakage?', 'Yes. We deploy self-hosted observability stacks (Prometheus, Grafana, Arize Phoenix, Jaeger) entirely inside your private cloud with zero data transmitted to third parties.'], ['How do you test agent prompt updates before deploying to production?', 'We integrate automated evaluation harnesses into your CI/CD pipeline that run regression test suites across hundreds of golden use cases, ensuring prompt updates improve performance without breaking existing capabilities.'], ['What is your Mean Time to Remediation (MTTR) for critical agent incidents?', 'Our standard enterprise SLA provides a 1-hour critical response time, while dedicated AI SRE enterprise tiers provide a 15-minute response SLA with 24/7 active coverage.'], ['Do you support multi-cloud and hybrid on-premise agent deployments?', 'Yes. Our AgentOps telemetry and SRE practices support agents deployed across AWS, Azure, GCP, and bare-metal on-premise Kubernetes clusters.'], ['How long does it take to integrate AgentOps observability into our existing AI systems?', 'A comprehensive AgentOps setup sprint instrumenting all microservices, dashboards, and alert channels typically takes 2 weeks.']];

/** Schema.org Structured Data with FAQPage & Service */
$schema = [
    '@context' => 'https://schema.org',
    '@graph' => [
        [
            '@type' => 'Service',
            'name' => 'AgentOps, Telemetry & Continuous AI Operations Support',
            'serviceType' => 'Enterprise Integration & Systems',
            'description' => '24/7 AgentOps monitoring, token cost tracking, hallucination drift detection, latency optimization, and automated model evaluation for production AI systems.',
            'url' => canonical('services/agent-operations-support.php'),
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

<div class="svc-page" data-theme="telemetry">

  <!-- =========================================================================
       HERO SECTION: Cyber Eyebrow, Gradient Headline & Action CTAs
       ========================================================================= -->
  <section class="svc-hero">
    <div class="svc-shell svc-hero-inner">
      <p class="svc-eyebrow"><span class="svc-pulse" aria-hidden="true"></span>24/7 AgentOps & SRE · Continuous AI Observability</p>

      <h1 class="svc-h1">
        AgentOps & AI Operations For<br><em>Production Fleet Reliability</em>
      </h1>

      <p class="svc-lead">
        24/7 AgentOps monitoring, token cost tracking, hallucination drift detection, latency optimization, and automated model evaluation for production AI systems.
      </p>

      <div class="svc-actions svc-actions--mid">
        <button class="svc-btn svc-btn--primary" type="button"
                data-modal-open data-modal-service="AgentOps, Telemetry & Continuous AI Operations Support">
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
        <img src="<?= e(asset('assets/img/services/svc-14-agent-operations.jpg')) ?>" width="1200" height="700"
             alt="AgentOps, Telemetry & Continuous AI Operations Support Architecture" fetchpriority="high" decoding="async">
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
          <h2 class="svc-title">Deploying agents is only day one;<br><em>AgentOps ensures they never drift or fail</em></h2>
        </div>
        <div class="svc-open-copy">
          <p>Without rigorous continuous observability, enterprise AI agents in production suffer from silent hallucinations, prompt drift, sudden API latency spikes, and runaway token bills. Engineering teams are left blind when users complain about degraded reasoning or incorrect tool executions.</p>
          <p>We provide comprehensive 24/7 AgentOps and AI Operations Support. Utilizing OpenTelemetry, LangSmith, and automated evaluation harnesses, our dedicated AI Site Reliability Engineers (SREs) monitor your production agent fleet, enforce real-time cost caps, detect model drift, and continuously optimize throughput and reliability.</p>
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
        <h2 class="svc-title">Six AgentOps disciplines<br>for <em>mission-critical AI</em></h2>
        <p class="svc-sub">From full-stack distributed tracing to automated regression testing and cost governance.</p>
      </div>

      <div class="svc-cards-grid">
        <?php foreach ($disciplines as $i => [$num, $dTitle, $dDesc]): ?>
          <?php $fig = svc_img('14', 3, $i + 1); ?>
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
                data-modal-open data-modal-service="AgentOps, Telemetry & Continuous AI Operations Support">
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
        <h2 class="svc-title">Five strategic business advantages<br>of our <em>Agent Operations Support</em></h2>
        <p class="svc-sub">
          Explore the architectural advantages that guarantee high concurrency, zero data leakage, and rapid payback timelines.
        </p>
      </div>

      <div class="svc-benefits-grid">
        <?php foreach ($benefits as $i => [$num, $bTitle, $bDesc]): ?>
          <?php $fig = svc_img('14', 5, $i + 1); ?>
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
      <div class="svc-roadmap" data-roadmap="dials" aria-hidden="true">
        <?php foreach ($steps as $idx => [$num, $sTitle]): ?>
          <span data-roadmap-node="<?= $idx ?>" data-label="<?= e($sTitle) ?>"></span>
        <?php endforeach; ?>
      </div>

      <?php
      $s6 = array_filter([svc_img('14', 6, 1), svc_img('14', 6, 2), svc_img('14', 6, 3)]);
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
        <h2 class="svc-title">Three ways to engage our<br><em>Agent Operations Support Practice</em></h2>
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
                    data-modal-open data-modal-service="AgentOps, Telemetry & Continuous AI Operations Support (Model <?= e($num) ?>)">
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
            <img src="<?= e(asset('assets/img/services/svc-14-agent-operations.jpg')) ?>" width="900" height="700"
                 alt="AgentOps, Telemetry & Continuous AI Operations Support FAQ Consultation" loading="lazy" decoding="async">
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
      <h2>Ready to build or scale your<br><em>Agent Operations Support System?</em></h2>
      <p class="svc-close-lead">
        Discuss your technical requirements, latency constraints, and data governance policies directly with our Lead AI Systems Architects. Receive an actionable feasibility audit and prototype blueprint within 48 hours.
      </p>
      <div class="svc-actions svc-actions--mid">
        <button class="svc-btn svc-btn--primary" type="button"
                data-modal-open data-modal-service="AgentOps, Telemetry & Continuous AI Operations Support">
          Start 48-Hour Technical Discovery<?= icon('arrow') ?>
        </button>
      </div>
    </div>
  </section>

</div>

<?php
require dirname(__DIR__) . '/includes/footer.php';
