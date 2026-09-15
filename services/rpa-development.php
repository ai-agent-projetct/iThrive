<?php
/**
 * Cognitive RPA Development & Next-Gen Robotic Process Automation
 *
 * Enterprise AI Service Page engineered with modern dark cyber UI,
 * 6 Core Capabilities, 5 Strategic ROI Advantages, 5-Step Process Roadmap,
 * 3 Deployment Frameworks, Tech Stack Arena, and 10 Detailed FAQs with Schema.org JSON-LD.
 */

declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/config.php';

$page         = 'services';
$pageTitle    = 'Cognitive RPA Development & Next-Gen Robotic Process Automation';
$pageDesc     = 'Upgrade brittle legacy scripts to cognitive RPA powered by computer vision, LLM reasoning, adaptive UI scraping, and intelligent document processing.';
$ogImage      = 'assets/img/services/svc-15-rpa-development.jpg';

/* ---------------------------------------------------------------------------
 * Content Definitions
 * ------------------------------------------------------------------------ */

$stats = [['90%', 'Reduction in Script Breakage'], ['10x', 'Faster Task Execution'], ['100%', 'Accurate Document Extraction'], ['4.5x', 'Average Enterprise ROI Multiple']];

$disciplines = [['01', 'Vision-Driven UI & Web Browser Automation', 'Using computer vision and multimodal LLMs to identify buttons, forms, and tables dynamically without relying on brittle DOM selectors.'], ['02', 'Cognitive Document & Invoice Processing', 'Automated intake, OCR, validation, and database entry for invoices, tax forms, insurance claims, and shipping manifests.'], ['03', 'Legacy Desktop & Mainframe Terminal Scraping', 'Automating data entry and extraction across terminal emulators, Citrix virtual desktops, and legacy Windows desktop applications.'], ['04', 'Adaptive Self-Healing UI Selectors', 'Bots dynamically recalculate element coordinates when UI layouts change, maintaining 99.9% uptime without code edits.'], ['05', 'Attended & Unattended Swarm Deployment', 'Deploying background unattended bots for high-volume batch processing and attended desktop assistants for frontline employees.'], ['06', 'Enterprise Security & Audit Compliance', 'Encrypted credential vaults, role-based bot access permissions, and immutable session video logs meeting SOC 2 and HIPAA requirements.']];

$benefits = [['01', '90% Reduction in Maintenance Overhead', 'Cognitive vision selectors self-heal when websites and software interfaces update.'], ['02', '10x Acceleration in Process Speed', 'Complete complex multi-application data transfers in seconds with zero human transcription lag.'], ['03', 'Flawless Data Accuracy & Zero Error', 'Eliminate manual data entry typos, ensuring 100% data integrity across all enterprise records.'], ['04', 'Non-Invasive System Modernization', 'Automate legacy mainframe and desktop applications without requiring expensive API development.'], ['05', 'Fast 4.5x Return on Investment', 'Recoup implementation costs in months through massive labor deflection and accelerated processing.']];

$steps = [['01', 'Process Discovery & Feasibility Audit', 'Recording human user workflows, identifying automation opportunities, and quantifying ROI and time savings.'], ['02', 'Cognitive Architecture & Bot Design', 'Designing vision navigation pipelines, document extraction schemas, and error-recovery fallback logic.'], ['03', 'Bot Development & Tool Sandboxing', 'Developing containerized bots using Playwright, Python, and vision models with encrypted credential vaults.'], ['04', 'Stress Testing & UI Shift Chaos Trials', 'Testing bots against intentional UI modifications, unexpected popups, and malformed inputs.'], ['05', 'Production Deployment & Fleet Orchestration', 'Deploying attended and unattended bot swarms on secure VMs with 24/7 centralized health monitoring.']];

$models = [['01', 'Cognitive RPA Pilot', 'A 3-week sprint building a resilient cognitive RPA bot for your highest-friction manual desktop or web workflow.', ['3-week implementation', 'Vision-driven UI navigation', 'Full error logging']], ['02', 'Enterprise RPA Fleet Suite', 'Comprehensive automation suite deploying multiple unattended bots across legacy ERPs, desktop apps, and document portals.', ['Multi-bot orchestration', 'Legacy desktop & web support', '99.8% execution SLA']], ['03', 'Dedicated RPA Engineering Squad', 'Continuous bot development, new process automation rollouts, UI maintenance, and 24/7 bot fleet monitoring.', ['Continuous bot expansion', 'Dedicated RPA engineers', '24/7 SLA & support']]];

$techStack = ['Python', 'Playwright', 'OpenCV', 'PaddleOCR', 'Docker', 'PostgreSQL', 'Temporal.io', 'Selenium', 'Redis', 'Kubernetes'];

$pageStack = [
    ['slug' => 'automation', 'title' => 'Automation Runtime', 'icon' => 'cpu',
     'blurb' => 'Driving systems that were never given an API.',
     'items' => [
         ['name' => 'Python', 'logo' => 'python'],
         ['name' => 'Celery', 'logo' => 'celery'],
         ['name' => 'Node.js', 'logo' => 'nodedotjs'],
         ['name' => 'FastAPI', 'logo' => 'fastapi'],
     ]],
    ['slug' => 'systems', 'title' => 'Target Systems', 'icon' => 'database',
     'blurb' => 'The ERPs, portals and databases the robots work against.',
     'items' => [
         ['name' => 'PostgreSQL', 'logo' => 'postgresql'],
         ['name' => 'MySQL', 'logo' => 'mysql'],
         ['name' => 'MongoDB', 'logo' => 'mongodb'],
         ['name' => 'Redis', 'logo' => 'redis'],
     ]],
    ['slug' => 'platform', 'title' => 'Scheduling & Operations', 'icon' => 'cloud',
     'blurb' => 'Queues, retries and an auditable run history.',
     'items' => [
         ['name' => 'Docker', 'logo' => 'docker'],
         ['name' => 'Kubernetes', 'logo' => 'kubernetes'],
         ['name' => 'Jenkins', 'logo' => 'jenkins'],
         ['name' => 'GitHub Actions', 'logo' => 'githubactions'],
     ]],
];

$faqs = [['How is Cognitive RPA different from traditional RPA tools like UiPath?', 'Traditional RPA relies on rigid element coordinates and XPath selectors that break whenever a UI updates. Cognitive RPA combines computer vision and multimodal LLMs to understand the screen visually and semantically like a human operator, making it resilient to UI changes.'], ['Can Cognitive RPA automate legacy desktop applications and terminal emulators?', 'Yes. We automate legacy Windows desktop applications, AS/400 terminal emulators, SAP GUI, and Citrix virtual desktop sessions using vision-driven OCR and keyboard/mouse emulation.'], ['What is the difference between Attended and Unattended RPA bots?', "Attended bots run on an employee's local machine, acting as a copilot that assists with tasks on demand. Unattended bots run autonomously on background virtual machines to process high-volume batch queues 24/7."], ['How do Cognitive RPA bots handle unstructured invoices and scanned documents?', 'Bots use multimodal OCR and layout-aware vision models to extract tabular data, line items, and totals directly into structured JSON, verifying sums against database records before saving.'], ['How do you securely manage passwords and credentials for bots?', 'Bots retrieve short-lived credentials from encrypted enterprise key vaults (such as HashiCorp Vault or AWS Secrets Manager). Passwords are never hardcoded or exposed in logs.'], ['What happens if a website displays a CAPTCHA or unexpected popup?', 'Our bots utilize cognitive vision reasoning to recognize and handle routine popups gracefully. For high-security CAPTCHAs, the bot can escalate to a human operator or solve approved accessibility challenges.'], ['How do bots handle sudden changes in web page layouts?', 'Our bots use semantic vision anchors and multi-modal grounding rather than rigid XPaths. If a button moves to a new location or changes color, the bot visually locates it by its semantic label and intent.'], ['Can Cognitive RPA integrate directly with backend databases and APIs?', 'Yes. When APIs are available, bots execute direct REST/SQL calls for maximum speed, and switch to visual UI automation only when interacting with legacy frontends.'], ['How do you ensure enterprise compliance and auditability for RPA actions?', 'Every bot action, keystroke, and database modification is recorded in immutable audit logs. We can also record encrypted video sessions of bot executions for compliance audits.'], ['How long does it take to develop and deploy a Cognitive RPA bot?', 'A single high-impact cognitive bot is typically operational in 2 to 3 weeks. Comprehensive enterprise multi-bot fleet rollouts take 4 to 6 weeks.']];

/** Schema.org Structured Data with FAQPage & Service */
$schema = [
    '@context' => 'https://schema.org',
    '@graph' => [
        [
            '@type' => 'Service',
            'name' => 'Cognitive RPA Development & Next-Gen Robotic Process Automation',
            'serviceType' => 'Enterprise Integration & Systems',
            'description' => 'Upgrade brittle legacy scripts to cognitive RPA powered by computer vision, LLM reasoning, adaptive UI scraping, and intelligent document processing.',
            'url' => canonical('services/rpa-development.php'),
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
    . '<link rel="stylesheet" href="' . e(asset('assets/css/service-custom.css')) . '">';

require dirname(__DIR__) . '/includes/header.php';
?>

<div class="svc-page">

  <!-- =========================================================================
       HERO SECTION: Cyber Eyebrow, Gradient Headline & Action CTAs
       ========================================================================= -->
  <section class="svc-hero">
    <div class="svc-shell svc-hero-inner">
      <p class="svc-eyebrow"><span class="svc-pulse" aria-hidden="true"></span>Cognitive RPA · Adaptive Computer Vision Automation</p>

      <h1 class="svc-h1">
        Cognitive RPA Development For<br><em>Unbreakable Robotic Automation</em>
      </h1>

      <p class="svc-lead">
        Upgrade brittle legacy scripts to cognitive RPA powered by computer vision, LLM reasoning, adaptive UI scraping, and intelligent document processing.
      </p>

      <div class="svc-actions svc-actions--mid">
        <button class="svc-btn svc-btn--primary" type="button"
                data-modal-open data-modal-service="Cognitive RPA Development & Next-Gen Robotic Process Automation">
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
        <img src="<?= e(asset('assets/img/services/svc-15-rpa-development.jpg')) ?>" width="1200" height="700"
             alt="Cognitive RPA Development & Next-Gen Robotic Process Automation Architecture" fetchpriority="high" decoding="async">
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
          <h2 class="svc-title">Legacy RPA scripts break constantly;<br><em>cognitive bots adapt visually and contextually</em></h2>
        </div>
        <div class="svc-open-copy">
          <p>Traditional Robotic Process Automation tools (UiPath, Automation Anywhere) rely on rigid pixel coordinates and DOM XPath selectors. The moment a website layout shifts or a form field is renamed, the automation crashes, halting business operations and requiring constant developer maintenance.</p>
          <p>We engineer next-generation Cognitive RPA powered by computer vision, multimodal LLM reasoning, and adaptive browser automation. Our bots see the screen like human operators, understand document context semantically, and adapt to UI layout changes dynamically — delivering unbreakable, 24/7 robotic execution.</p>
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
        <h2 class="svc-title">Six cognitive RPA disciplines<br>for <em>resilient automation</em></h2>
        <p class="svc-sub">From vision-driven UI automation to multimodal document extraction and mainframe scraping.</p>
      </div>

      <div class="svc-cards-grid">
        <?php foreach ($disciplines as $i => [$num, $dTitle, $dDesc]): ?>
          <?php $fig = svc_img('15', 3, $i + 1); ?>
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
                data-modal-open data-modal-service="Cognitive RPA Development & Next-Gen Robotic Process Automation">
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
        <h2 class="svc-title">Five strategic business advantages<br>of our <em>Rpa Development</em></h2>
        <p class="svc-sub">
          Explore the architectural advantages that guarantee high concurrency, zero data leakage, and rapid payback timelines.
        </p>
      </div>

      <div class="svc-benefits-grid">
        <?php foreach ($benefits as $i => [$num, $bTitle, $bDesc]): ?>
          <?php $fig = svc_img('15', 5, $i + 1); ?>
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
      <div class="svc-roadmap" data-roadmap="cycle" aria-hidden="true">
        <?php foreach ($steps as $idx => [$num, $sTitle]): ?>
          <span data-roadmap-node="<?= $idx ?>" data-label="<?= e($sTitle) ?>"></span>
        <?php endforeach; ?>
      </div>

      <?php
      $s6 = array_filter([svc_img('15', 6, 1), svc_img('15', 6, 2), svc_img('15', 6, 3)]);
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
        <h2 class="svc-title">Three ways to engage our<br><em>Rpa Development Practice</em></h2>
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
                    data-modal-open data-modal-service="Cognitive RPA Development & Next-Gen Robotic Process Automation (Model <?= e($num) ?>)">
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
            <img src="<?= e(asset('assets/img/services/svc-15-rpa-development.jpg')) ?>" width="900" height="700"
                 alt="Cognitive RPA Development & Next-Gen Robotic Process Automation FAQ Consultation" loading="lazy" decoding="async">
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
      <h2>Ready to build or scale your<br><em>Rpa Development System?</em></h2>
      <p class="svc-close-lead">
        Discuss your technical requirements, latency constraints, and data governance policies directly with our Lead AI Systems Architects. Receive an actionable feasibility audit and prototype blueprint within 48 hours.
      </p>
      <div class="svc-actions svc-actions--mid">
        <button class="svc-btn svc-btn--primary" type="button"
                data-modal-open data-modal-service="Cognitive RPA Development & Next-Gen Robotic Process Automation">
          Start 48-Hour Technical Discovery<?= icon('arrow') ?>
        </button>
      </div>
    </div>
  </section>

</div>

<?php
require dirname(__DIR__) . '/includes/footer.php';
