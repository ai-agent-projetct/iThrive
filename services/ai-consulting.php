<?php
/**
 * Enterprise AI Consulting & Strategic Advisory Services
 *
 * Enterprise AI Service Page engineered with modern dark cyber UI,
 * 6 Core Capabilities, 5 Strategic ROI Advantages, 5-Step Process Roadmap,
 * 3 Deployment Frameworks, Tech Stack Arena, and 10 Detailed FAQs with Schema.org JSON-LD.
 */

declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/config.php';

$page         = 'services';
$pageTitle    = 'Enterprise AI Consulting & Strategic Advisory Services';
$pageDesc     = 'Strategic AI roadmaps, technical feasibility audits, ROI modeling, and governance frameworks designed for high-scale enterprise production.';
$ogImage      = 'assets/img/services/svc-01-ai-consulting.jpg';

/* ---------------------------------------------------------------------------
 * Content Definitions
 * ------------------------------------------------------------------------ */

$stats = [['99.2%', 'Strategy Feasibility Rate'], ['3.8x', 'Average AI ROI Multiple'], ['150+', 'Enterprise Audits Conducted'], ['100%', 'Data Sovereignty Compliance']];

$disciplines = [['01', 'Enterprise AI Readiness & Workflow Auditing', 'Deep-dive operational discovery identifying high-friction enterprise bottlenecks across engineering, finance, operations, and sales where AI yields immediate 10x ROI.'], ['02', 'Model Selection & Architecture Sizing', 'Objective evaluation between proprietary LLMs (OpenAI, Claude, Gemini) versus private self-hosted SLMs (Llama, Mistral, DeepSeek) based on latency, security, and cost unit economics.'], ['03', 'Data Lake & Knowledge Governance', 'Audit, cleaning, vectorization, and compliance architecture for enterprise document repositories, unstructured silos, and relational databases.'], ['04', 'Safety, Compliance & NIST AI RMF', 'Formulating robust enterprise guardrails, prompt injection defenses, PII redaction protocols, and audit logs compliant with SOC 2, HIPAA, and GDPR.'], ['05', 'Commercial Cost Modeling & Unit Economics', 'Forecasting token consumption, GPU compute sizing, infrastructure hosting costs, and milestone-based ROI deliverables before writing a single line of code.'], ['06', 'Executive Advisory & Change Management', 'Hands-on technical workshops, executive roadmapping sessions, and internal team enablement ensuring seamless adoption across all business units.']];

$benefits = [['01', 'De-Risked AI Investments', 'Eliminate expensive trial-and-error by validating architectural feasibility, token costs, and model capabilities before development begins.'], ['02', 'Accelerated Time-to-Production', 'Go from conceptual discovery to working production MVP in weeks rather than quarters using our battle-tested implementation blueprints.'], ['03', 'Complete Data Sovereignty', 'Ensure your proprietary corporate data is never exposed to public foundation models or third-party training pipelines.'], ['04', 'Optimized Compute & Token Unit Economics', 'Reduce ongoing operational inference bills by up to 80% through smart model routing, semantic caching, and prompt compression.'], ['05', 'Vendor-Neutral Architecture', 'Retain full technology independence with modular software abstractions that allow hot-swapping underlying AI models as benchmarks evolve.']];

$steps = [['01', 'Discovery & Operational Audit', 'Mapping internal workflows, interviewing department heads, and identifying highest-leverage AI automation candidates.'], ['02', 'Technical Feasibility & Data Profiling', 'Assessing data quality, API availability, security requirements, and latency constraints across candidate use cases.'], ['03', 'Architecture & Model Sizing Blueprint', 'Designing comprehensive system topologies, model routing tiers, guardrail layers, and detailed cost projections.'], ['04', 'Sandbox PoC & Risk Validation', 'Building an isolated Proof of Concept to benchmark accuracy, latency, and user experience with real enterprise data.'], ['05', 'Strategic Roadmap & Delivery Handover', 'Delivering a phased execution plan, architectural blueprints, vendor matrix, and organizational change guidelines.']];

$models = [['01', 'Executive AI Strategy Sprint', 'A focused 2-week engagement delivering a comprehensive AI opportunity map, technical feasibility report, and architectural blueprint.', ['2-week intensive discovery', 'Use case prioritization matrix', 'Executive presentation']], ['02', 'Comprehensive Architecture Audit', 'A 4-week deep-dive covering data pipeline profiling, legacy API integration design, model benchmarking, and compliance auditing.', ['Full data & API profiling', 'Infrastructure & GPU cost modeling', 'Security & NIST alignment']], ['03', 'Retained Enterprise AI Advisory', 'Ongoing fractional Chief AI Officer advisory, monthly architecture reviews, model evaluation in CI, and vendor negotiation support.', ['Dedicated AI Lead Architect', 'Bi-weekly sprint reviews', 'Priority architectural support']]];

$techStack = ['LangGraph', 'PyTorch', 'vLLM', 'AWS Bedrock', 'Azure OpenAI', 'NVIDIA NeMo', 'Qdrant', 'OpenTelemetry', 'Kubernetes'];

/**
 * The same stack, grouped and mapped to the logos vendored in assets/img/tech.
 * Passed to the shared tech-stack component, which renders these tiles and then
 * promotes them to an interactive orbit. Only names with a real logo file are
 * listed: a tile whose svg is missing renders without an image and reads as a
 * mistake rather than a design.
 */
$pageStack = [
    ['slug' => 'models', 'title' => 'Models & Frameworks', 'icon' => 'brain',
     'blurb' => 'What the reasoning actually runs on, and the harness around it.',
     'items' => [
         ['name' => 'PyTorch', 'logo' => 'pytorch'],
         ['name' => 'LangChain', 'logo' => 'langchain'],
         ['name' => 'OpenAI', 'logo' => 'openai'],
         ['name' => 'Anthropic', 'logo' => 'anthropic'],
         ['name' => 'TensorFlow', 'logo' => 'tensorflow'],
         ['name' => 'scikit-learn', 'logo' => 'scikitlearn'],
     ]],
    ['slug' => 'data', 'title' => 'Data & Retrieval', 'icon' => 'database',
     'blurb' => 'Where your own corpus lives and how a passage is found in it.',
     'items' => [
         ['name' => 'PostgreSQL', 'logo' => 'postgresql'],
         ['name' => 'OpenSearch', 'logo' => 'opensearch'],
         ['name' => 'Redis', 'logo' => 'redis'],
         ['name' => 'pandas', 'logo' => 'pandas'],
     ]],
    ['slug' => 'platform', 'title' => 'Platform & Operations', 'icon' => 'cloud',
     'blurb' => 'What it is deployed on, and what tells you it is still healthy.',
     'items' => [
         ['name' => 'Kubernetes', 'logo' => 'kubernetes'],
         ['name' => 'Docker', 'logo' => 'docker'],
         ['name' => 'AWS', 'logo' => 'amazonwebservices'],
         ['name' => 'Azure', 'logo' => 'azure'],
         ['name' => 'Terraform', 'logo' => 'terraform'],
         ['name' => 'Grafana', 'logo' => 'grafana'],
     ]],
];

$faqs = [['What is the primary goal of an Enterprise AI Consulting engagement?', 'Our AI consulting engagements evaluate your operational workflows, identify high-leverage automation opportunities, determine technical and financial feasibility, and deliver an actionable production architecture that guarantees measurable ROI.'], ['How do you determine whether an enterprise should use an open-source model or a commercial API?', 'We evaluate your specific use case against data sovereignty requirements, latency constraints, token volume, and budget. For regulated industries with strict privacy needs or massive token volumes, fine-tuned open-source models (like Llama or Mistral on private VPCs) often deliver 80% lower cost and total privacy. For generalized reasoning with variable load, commercial APIs with enterprise zero-retention agreements may be recommended.'], ['How do you calculate the projected ROI of an AI initiative before building?', 'We quantify the exact baseline hours spent on manual workflows, error rates, customer wait times, and direct labor costs, then model the efficiency uplift, labor deflection, and compute hosting expenses to provide an unambiguous net ROI and payback timeline.'], ['How do you ensure our sensitive business data remains private during the audit?', 'All discovery and prototyping are conducted under strict mutual NDAs using air-gapped sandboxes or private VPC enclaves. Your proprietary data is never logged, stored on unauthorized machines, or sent to public foundation model training queues.'], ['What deliverables do we receive at the conclusion of the consulting engagement?', 'You receive a complete Executive AI Roadmap, Technical Architecture Blueprints, Data Readiness & Governance Audit, Model Sizing & Cost Projection Report, and a step-by-step Implementation Plan ready for engineering execution.'], ['Can you help modernize our existing legacy software systems with AI?', 'Yes. We specialize in non-invasive modernization patterns, such as sidecar microservices and universal API gateways, allowing you to add cutting-edge AI capabilities without rewriting or destabilizing your revenue-generating legacy applications.'], ['How long does a typical AI consulting and discovery engagement take?', 'Our standard AI Strategy Sprint runs for 2 weeks, while deep-dive multi-department enterprise architecture audits typically span 3 to 4 weeks depending on organizational complexity.'], ['How do you address AI safety, hallucinations, and prompt injection risks?', 'We design multi-tier defense architectures incorporating deterministic guardrails (such as NeMo Guardrails and Llama Guard), schema-constrained JSON outputs, semantic chunk validation, and automated red-teaming harnesses.'], ['Do you provide the engineering team to build the solution after consulting?', 'Yes. iThrive provides end-to-end capabilities: from strategic advisory and architectural blueprinting to dedicated full-stack AI engineering squads that build, test, and maintain the production platform.'], ['How do you handle change management and user adoption across our workforce?', 'We structure intuitive human-in-the-loop interfaces, comprehensive role-based training modules, and gradual cohort rollouts with confidence scoring, ensuring your employees view AI as an empowering copilot rather than an unpredictable disruption.']];

/** Schema.org Structured Data with FAQPage & Service */
$schema = [
    '@context' => 'https://schema.org',
    '@graph' => [
        [
            '@type' => 'Service',
            'name' => 'Enterprise AI Consulting & Strategic Advisory Services',
            'serviceType' => 'AI Strategy & Advisory',
            'description' => 'Strategic AI roadmaps, technical feasibility audits, ROI modeling, and governance frameworks designed for high-scale enterprise production.',
            'url' => canonical('services/ai-consulting.php'),
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

<div class="svc-page" data-theme="consulting">

  <!-- =========================================================================
       HERO SECTION: Cyber Eyebrow, Gradient Headline & Action CTAs
       ========================================================================= -->
  <section class="svc-hero">
    <div class="svc-shell svc-hero-inner">
      <p class="svc-eyebrow"><span class="svc-pulse" aria-hidden="true"></span>Enterprise AI Strategy & Governance ? Global Consulting</p>

      <h1 class="svc-h1">
        Enterprise AI Consulting For<br><em>Measurable Business Value</em>
      </h1>

      <p class="svc-lead">
        Transform your business with strategic AI roadmap planning, feasibility audits, ROI modeling, vendor selection, and data readiness frameworks designed for high-scale production.
      </p>

      <div class="svc-actions svc-actions--mid">
        <button class="svc-btn svc-btn--primary" type="button"
                data-modal-open data-modal-service="Enterprise AI Consulting & Strategic Advisory Services">
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
        <img src="<?= e(asset('assets/img/services/svc-01-ai-consulting.jpg')) ?>" width="1200" height="700"
             alt="Enterprise AI Consulting & Strategic Advisory Services Architecture" fetchpriority="high" decoding="async">
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
          <h2 class="svc-title">Strategic AI success is an<br><em>architectural execution discipline</em></h2>
        </div>
        <div class="svc-open-copy">
          <p>Most enterprise AI initiatives stall in perpetual pilot purgatory due to inadequate data architecture, unpredictable token unit economics, and lack of deterministic safety guardrails. Without rigorous discovery, organizations waste millions experimenting with generic models that fail to integrate with core business systems.</p>
          <p>Our Enterprise AI Consulting methodology bridges the gap between executive vision and production engineering. We evaluate your workflows, quantify ROI down to the dollar, design private VPC topologies, and establish strict governance protocols that guarantee measurable operational velocity.</p>
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
        <h2 class="svc-title">Six strategic disciplines<br>guiding your <em>AI transformation</em></h2>
        <p class="svc-sub">From architectural discovery to organizational enablement, our advisory framework covers every layer of production AI readiness.</p>
      </div>

      <?php /* The 6 images for this section, shown in depth rather than as
               card corners. Falls back to a plain grid of the same images if the
               island never mounts -- see includes/components/svc-gallery.php. */ ?>
      <?php component('svc-gallery', [
          'images'  => array_filter([svc_img('01', 3, 1), svc_img('01', 3, 2), svc_img('01', 3, 3), svc_img('01', 3, 4), svc_img('01', 3, 5), svc_img('01', 3, 6)]),
          'variant' => 'deck',
          'label'   => 'Capability visuals',
      ]); ?>
      <div class="svc-cards-grid">
        <?php foreach ($disciplines as $i => [$num, $dTitle, $dDesc]): ?>
          <?php /* One image per discipline. svc_img() returns null until the
                   file is generated, so the card keeps its current shape in the
                   meantime rather than showing a broken frame. */ ?>
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
                data-modal-open data-modal-service="Enterprise AI Consulting & Strategic Advisory Services">
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
        <h2 class="svc-title">Five strategic business advantages<br>of our <em>Ai Consulting</em></h2>
        <p class="svc-sub">
          Explore the architectural advantages that guarantee high concurrency, zero data leakage, and rapid payback timelines.
        </p>
      </div>

      <?php /* The 5 images for this section, shown in depth rather than as
               card corners. Falls back to a plain grid of the same images if the
               island never mounts -- see includes/components/svc-gallery.php. */ ?>
      <?php component('svc-gallery', [
          'images'  => array_filter([svc_img('01', 5, 1), svc_img('01', 5, 2), svc_img('01', 5, 3), svc_img('01', 5, 4), svc_img('01', 5, 5)]),
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

      <?php /* The roadmap, drawn in 3D. Purely a visual of the five phases
               below it — every word stays in the cards, because text inside a
               WebGL context is text no crawler and no screen reader reads.
               svc-roadmap.js skips it entirely without WebGL or under reduced
               motion, and the cards are then the whole section. */ ?>
      <?php $GLOBALS['ithrive_needs_roadmap'] = true; ?>
      <div class="svc-roadmap" data-roadmap="path" aria-hidden="true">
        <?php foreach ($steps as $idx => [$num, $sTitle]): ?>
          <span data-roadmap-node="<?= $idx ?>" data-label="<?= e($sTitle) ?>"></span>
        <?php endforeach; ?>
      </div>

      <?php /* Three stills for this section. Absent until generated — see
               docs/image-prompts.md for the briefs. */ ?>
      <?php /* The 3 images for this section, shown in depth rather than as
               card corners. Falls back to a plain grid of the same images if the
               island never mounts -- see includes/components/svc-gallery.php. */ ?>
      <?php component('svc-gallery', [
          'images'  => array_filter([svc_img('01', 6, 1), svc_img('01', 6, 2), svc_img('01', 6, 3)]),
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
        <h2 class="svc-title">Three ways to engage our<br><em>Ai Consulting Practice</em></h2>
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
                    data-modal-open data-modal-service="Enterprise AI Consulting & Strategic Advisory Services (Model <?= e($num) ?>)">
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

      <?php /* The shared component: tiles server-side, promoted to an orbit
               by tech-stack.js. Fed this page's own stack rather than the
               site-wide one. */ ?>
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
            <img src="<?= e(asset('assets/img/services/svc-01-ai-consulting.jpg')) ?>" width="900" height="700"
                 alt="Enterprise AI Consulting & Strategic Advisory Services FAQ Consultation" loading="lazy" decoding="async">
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
      <h2>Ready to build or scale your<br><em>Ai Consulting System?</em></h2>
      <p class="svc-close-lead">
        Discuss your technical requirements, latency constraints, and data governance policies directly with our Lead AI Systems Architects. Receive an actionable feasibility audit and prototype blueprint within 48 hours.
      </p>
      <div class="svc-actions svc-actions--mid">
        <button class="svc-btn svc-btn--primary" type="button"
                data-modal-open data-modal-service="Enterprise AI Consulting & Strategic Advisory Services">
          Start 48-Hour Technical Discovery<?= icon('arrow') ?>
        </button>
      </div>
    </div>
  </section>

</div>

<?php
require dirname(__DIR__) . '/includes/footer.php';
