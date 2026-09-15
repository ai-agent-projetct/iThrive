<?php
/**
 * Custom AI Copilot Development & Domain Decision Engines
 *
 * Enterprise AI Service Page engineered with modern dark cyber UI,
 * 6 Core Capabilities, 5 Strategic ROI Advantages, 5-Step Process Roadmap,
 * 3 Deployment Frameworks, Tech Stack Arena, and 10 Detailed FAQs with Schema.org JSON-LD.
 */

declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/config.php';

$page         = 'services';
$pageTitle    = 'Custom AI Copilot Development & Domain Decision Engines';
$pageDesc     = 'Purpose-built cognitive AI copilots embedded into your SaaS, IDE, or internal enterprise dashboards that anticipate user actions and automate complex decision workflows.';
$ogImage      = 'assets/img/services/svc-04-ai-copilot.jpg';

/* ---------------------------------------------------------------------------
 * Content Definitions
 * ------------------------------------------------------------------------ */

$stats = [['4.2x', 'Operator Velocity Multiplier'], ['94%', 'Code & Form Auto-Completion'], ['<80ms', 'Context Retrieval Latency'], ['100%', 'Zero Data Leakage Guarantee']];

$disciplines = [['01', 'Embedded In-App Workspace Copilots', 'Floating conversational and inline assistance bars integrated directly into React, Vue, Angular, or Electron applications.'], ['02', 'Developer IDE & Code Generation Copilots', 'VS Code and JetBrains extensions fine-tuned on internal company SDKs, private libraries, and architectural conventions.'], ['03', 'Natural Language-to-SQL & Analytics Engines', 'Translating natural language business questions into optimized, schema-validated SQL queries with automated visual chart rendering.'], ['04', 'Context-Aware Form & Document Auto-Drafting', 'Predictive auto-fill for complex legal filings, medical notes, insurance claims, and engineering specifications.'], ['05', 'Multi-Modal Screen & Visual Inspection Copilots', 'Real-time analysis of user canvas states, CAD diagrams, UI mockups, and radiology scans with inline annotations.'], ['06', 'Role-Based Context & Security Guardrails', 'Fine-grained permission enforcement ensuring copilots only access and generate data permitted by the user?s role.']];

$benefits = [['01', '4x+ Operational Productivity Uplift', 'Empower operators to execute multi-step workflows with single-keystroke completions and natural language commands.'], ['02', 'Drastically Reduced Software Onboarding', 'New employees become proficient in complex enterprise platforms on day one with an intelligent guide explaining every step.'], ['03', 'Zero Context-Switching Overhead', 'Operators receive actionable answers and automate tasks without leaving their primary application window.'], ['04', 'Guaranteed Data Privacy in Private VPC', 'All user context, active documents, and copilot prompts remain strictly inside your private cloud perimeter.'], ['05', 'Measurable Feature Engagement Lift', 'Boost software retention and user satisfaction by transforming passive dashboards into interactive decision engines.']];

$steps = [['01', 'Workspace Context & UX Mapping', 'Defining integration entry points (inline ghost text, sidebars, modal triggers) and user interaction flows.'], ['02', 'Context Retrieval & Embedding Pipeline', 'Building fast local and server-side state collectors that summarize active user screens and open documents.'], ['03', 'Prompt Engineering & Few-Shot Alignment', 'Crafting domain-specific system prompts, tool schemas, and error-recovery routines.'], ['04', 'SDK & Extension Frontend Integration', 'Implementing lightweight, non-blocking UI components with streaming token rendering and keyboard shortcuts.'], ['05', 'Telemetry & Feedback Loop Rollout', 'Deploying telemetry to capture acceptance rates, keystroke savings, latency metrics, and user corrections.']];

$models = [['01', 'SaaS Copilot MVP', 'A 4-week sprint embedding a contextual AI assistant into your existing web application with RAG document search.', ['React/Vue SDK integration', 'Contextual document retrieval', 'Streaming token UI']], ['02', 'Custom Developer IDE Copilot', 'A bespoke VS Code / JetBrains extension trained on your private repositories and internal API schemas.', ['Custom language server protocol', 'Private model hosting', 'Autocomplete & refactoring']], ['03', 'Enterprise Operations Copilot Suite', 'A full-scale copilot deployment across ERP, CRM, and internal dashboards with natural language SQL and action triggers.', ['Multi-system tool integration', 'Role-based access controls', 'Dedicated MLOps maintenance']]];

$techStack = ['TypeScript', 'React', 'LangChain', 'FastAPI', 'pgvector', 'OpenSearch', 'Docker', 'WebSockets', 'Triton'];

$pageStack = [
    ['slug' => 'surface', 'title' => 'Product Surface', 'icon' => 'monitor',
     'blurb' => 'The screen the copilot lives inside.',
     'items' => [
         ['name' => 'React', 'logo' => 'react'],
         ['name' => 'TypeScript', 'logo' => 'typescript'],
         ['name' => 'Next.js', 'logo' => 'nextdotjs'],
         ['name' => 'Tailwind', 'logo' => 'tailwindcss'],
     ]],
    ['slug' => 'models', 'title' => 'Models & Context', 'icon' => 'brain',
     'blurb' => 'What it suggests, grounded in what the user is looking at.',
     'items' => [
         ['name' => 'OpenAI', 'logo' => 'openai'],
         ['name' => 'Anthropic', 'logo' => 'anthropic'],
         ['name' => 'LangChain', 'logo' => 'langchain'],
         ['name' => 'Python', 'logo' => 'python'],
     ]],
    ['slug' => 'platform', 'title' => 'Services & Operations', 'icon' => 'cloud',
     'blurb' => 'The API behind the panel, and its cost per seat.',
     'items' => [
         ['name' => 'FastAPI', 'logo' => 'fastapi'],
         ['name' => 'PostgreSQL', 'logo' => 'postgresql'],
         ['name' => 'Redis', 'logo' => 'redis'],
         ['name' => 'Docker', 'logo' => 'docker'],
     ]],
];

$faqs = [['How does an AI Copilot differ from a standard AI Chatbot?', 'While chatbots generally operate in a standalone chat window answering generic queries, a Copilot is deeply embedded into the active software workspace, continuously aware of the user?s cursor position, open document, selected data, and permissions, providing proactive inline assistance.'], ['Can a custom copilot be embedded into our existing React or Vue web app?', 'Yes. We provide lightweight, customizable npm packages and web components that integrate into your frontend in hours, connecting securely to your backend via WebSockets or streaming HTTP.'], ['How do you keep latency low enough for inline autocomplete (<100ms)?', 'We deploy quantized small language models (SLMs) on edge GPU clusters combined with speculative decoding, local client caching, and preemptive background context pre-fetching.'], ['Is our codebase or customer data sent to third-party AI companies?', 'No. We configure private cloud deployments (AWS Bedrock, Azure OpenAI with zero-data retention, or self-hosted vLLM on your VPC) so your proprietary data never leaves your infrastructure.'], ['Can the copilot execute actions on behalf of the user, such as creating records?', 'Yes. Using secure tool-calling and API contracts, the copilot can draft transactions, create Jira tickets, trigger database updates, and send emails, with optional human-confirmation modals.'], ['How do you handle complex permissions and multi-tenant security?', 'The copilot inherits the active user session token and role-based access control (RBAC) rules. It physically cannot retrieve or generate information that the requesting user is not authorized to view.'], ['Can the copilot convert plain English into database SQL queries safely?', 'Yes. Our NL-to-SQL copilot engines parse your database schema, generate read-only parameterized queries, validate syntax against SQL injection vectors, and execute with strict query timeouts.'], ['What telemetry and analytics are provided to measure copilot usage?', 'We provide comprehensive dashboards tracking suggestion acceptance rates, daily active users, average latency, token costs per user, and estimated time saved per operator.'], ['Can we build a copilot for our desktop application (Electron, Windows, macOS)?', 'Yes. We engineer native desktop extensions, system tray copilots, and Electron integrations that interact with local file systems and desktop applications.'], ['What is the typical timeline to launch an in-app copilot for our SaaS?', 'A working production copilot MVP is typically delivered in 4 to 6 weeks, with iterative refinement based on user feedback.']];

/** Schema.org Structured Data with FAQPage & Service */
$schema = [
    '@context' => 'https://schema.org',
    '@graph' => [
        [
            '@type' => 'Service',
            'name' => 'Custom AI Copilot Development & Domain Decision Engines',
            'serviceType' => 'AI-First Product Development',
            'description' => 'Purpose-built cognitive AI copilots embedded into your SaaS, IDE, or internal enterprise dashboards that anticipate user actions and automate complex decision workflows.',
            'url' => canonical('services/ai-copilot-development.php'),
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

<div class="svc-page" data-theme="copilot">

  <!-- =========================================================================
       HERO SECTION: Cyber Eyebrow, Gradient Headline & Action CTAs
       ========================================================================= -->
  <section class="svc-hero">
    <div class="svc-shell svc-hero-inner">
      <p class="svc-eyebrow"><span class="svc-pulse" aria-hidden="true"></span>Cognitive Software Copilots ? In-App Contextual Intelligence</p>

      <h1 class="svc-h1">
        Custom AI Copilot Development For<br><em>10x Human Operator Velocity</em>
      </h1>

      <p class="svc-lead">
        Purpose-built cognitive AI copilots embedded into your SaaS, IDE, or internal enterprise dashboards that anticipate user actions and automate complex decision workflows.
      </p>

      <div class="svc-actions svc-actions--mid">
        <button class="svc-btn svc-btn--primary" type="button"
                data-modal-open data-modal-service="Custom AI Copilot Development & Domain Decision Engines">
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
        <img src="<?= e(asset('assets/img/services/svc-04-ai-copilot.jpg')) ?>" width="1200" height="700"
             alt="Custom AI Copilot Development & Domain Decision Engines Architecture" fetchpriority="high" decoding="async">
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
          <h2 class="svc-title">Static dashboards overwhelm users;<br><em>intelligent copilots guide action</em></h2>
        </div>
        <div class="svc-open-copy">
          <p>Complex enterprise software forces operators to navigate dozens of menus, write arcane queries, and manually cross-reference disparate data sources. This cognitive friction creates operational bottlenecks and slows decision-making.</p>
          <p>We engineer context-aware AI copilots that live directly inside your software interfaces. By continuously observing user context, active document states, and historical workflows, our copilots anticipate intent, draft complex actions, and synthesize multidimensional insights in real time.</p>
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
        <h2 class="svc-title">Six core AI copilot disciplines<br>for <em>in-product intelligence</em></h2>
        <p class="svc-sub">Engineered for seamless UI embedding and deep workspace integration.</p>
      </div>

      <?php /* The 6 images for this section, shown in depth rather than as
               card corners. Falls back to a plain grid of the same images if the
               island never mounts -- see includes/components/svc-gallery.php. */ ?>
      <?php component('svc-gallery', [
          'images'  => array_filter([svc_img('04', 3, 1), svc_img('04', 3, 2), svc_img('04', 3, 3), svc_img('04', 3, 4), svc_img('04', 3, 5), svc_img('04', 3, 6)]),
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
                data-modal-open data-modal-service="Custom AI Copilot Development & Domain Decision Engines">
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
        <h2 class="svc-title">Five strategic business advantages<br>of our <em>Ai Copilot Development</em></h2>
        <p class="svc-sub">
          Explore the architectural advantages that guarantee high concurrency, zero data leakage, and rapid payback timelines.
        </p>
      </div>

      <?php /* The 5 images for this section, shown in depth rather than as
               card corners. Falls back to a plain grid of the same images if the
               island never mounts -- see includes/components/svc-gallery.php. */ ?>
      <?php component('svc-gallery', [
          'images'  => array_filter([svc_img('04', 5, 1), svc_img('04', 5, 2), svc_img('04', 5, 3), svc_img('04', 5, 4), svc_img('04', 5, 5)]),
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
      <div class="svc-roadmap" data-roadmap="rails" aria-hidden="true">
        <?php foreach ($steps as $idx => [$num, $sTitle]): ?>
          <span data-roadmap-node="<?= $idx ?>" data-label="<?= e($sTitle) ?>"></span>
        <?php endforeach; ?>
      </div>
      <?php /* The 3 images for this section, shown in depth rather than as
               card corners. Falls back to a plain grid of the same images if the
               island never mounts -- see includes/components/svc-gallery.php. */ ?>
      <?php component('svc-gallery', [
          'images'  => array_filter([svc_img('04', 6, 1), svc_img('04', 6, 2), svc_img('04', 6, 3)]),
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
        <h2 class="svc-title">Three ways to engage our<br><em>Ai Copilot Development Practice</em></h2>
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
                    data-modal-open data-modal-service="Custom AI Copilot Development & Domain Decision Engines (Model <?= e($num) ?>)">
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
            <img src="<?= e(asset('assets/img/services/svc-04-ai-copilot.jpg')) ?>" width="900" height="700"
                 alt="Custom AI Copilot Development & Domain Decision Engines FAQ Consultation" loading="lazy" decoding="async">
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
      <h2>Ready to build or scale your<br><em>Ai Copilot Development System?</em></h2>
      <p class="svc-close-lead">
        Discuss your technical requirements, latency constraints, and data governance policies directly with our Lead AI Systems Architects. Receive an actionable feasibility audit and prototype blueprint within 48 hours.
      </p>
      <div class="svc-actions svc-actions--mid">
        <button class="svc-btn svc-btn--primary" type="button"
                data-modal-open data-modal-service="Custom AI Copilot Development & Domain Decision Engines">
          Start 48-Hour Technical Discovery<?= icon('arrow') ?>
        </button>
      </div>
    </div>
  </section>

</div>

<?php
require dirname(__DIR__) . '/includes/footer.php';
