<?php
/**
 * Hire Dedicated Agentic AI Developers & Autonomous Swarm Engineers
 *
 * Enterprise AI Service Page engineered with modern dark cyber UI,
 * 6 Core Capabilities, 5 Strategic ROI Advantages, 5-Step Process Roadmap,
 * 3 Deployment Frameworks, Tech Stack Arena, and 10 Detailed FAQs with Schema.org JSON-LD.
 */

declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/config.php';

$page         = 'services';
$pageTitle    = 'Hire Dedicated Agentic AI Developers & Autonomous Swarm Engineers';
$pageDesc     = 'Hire pre-vetted top 1% Agentic AI engineers, LangGraph specialists, PyTorch researchers, and AI systems architects ready to deploy into your sprint within 48 hours.';
$ogImage      = 'assets/img/services/svc-16-hire-agentic-developers.jpg';

/* ---------------------------------------------------------------------------
 * Content Definitions
 * ------------------------------------------------------------------------ */

$stats = [['Top 1%', 'Pre-Vetted AI Engineering Talent'], ['48 Hours', 'Rapid Onboarding Velocity'], ['100%', 'Timezone Alignment Guarantee'], ['0', 'Recruitment & Sourcing Overhead']];

$disciplines = [['01', 'Autonomous Agent & Swarm Architects', 'Senior engineers specializing in LangGraph, multi-agent consensus protocols, state checkpointing, and hierarchical orchestrator topologies.'], ['02', 'LangGraph & State Machine Developers', 'Hands-on Python/TypeScript developers building cyclic state graphs, custom tool execution sandboxes, and human-in-the-loop workflows.'], ['03', 'Vector Database & GraphRAG Specialists', 'Engineers proficient in Qdrant, Milvus, pgvector, hybrid search algorithms, knowledge graphs, and multimodal parsing pipelines.'], ['04', 'LLM Fine-Tuning & Quantization Experts', 'ML researchers experienced in LoRA, QLoRA, DPO, vLLM, TensorRT-LLM, and deploying private SLMs on isolated Kubernetes VPCs.'], ['05', 'AgentOps & AI Infrastructure SREs', 'DevOps engineers setting up OpenTelemetry tracing, LangSmith observability, token cost governance, and CI/CD evaluation harnesses.'], ['06', 'Full-Stack AI Middleware & Web Developers', 'Full-stack engineers building modern AI user interfaces, real-time SSE streaming conduits, FastAPI backends, and MCP servers.']];

$benefits = [['01', 'Immediate Sprint Integration (48h)', 'Skip months of tedious recruiting. Our pre-vetted engineers onboard and write production code in 48 hours.'], ['02', 'Top 1% Elite Technical Caliber', 'Every engineer passes rigorous live technical challenges on LangGraph, vector search, and distributed systems.'], ['03', 'Seamless Timezone Alignment', 'Our developers work directly inside your working hours, attend daily standups, and communicate via Slack.'], ['04', 'Zero Recruitment & Overhead Risk', 'Flexible monthly engagements with simple scaling: add or scale down developers as sprint demands change.'], ['05', 'Complete IP & Code Ownership', '100% of the code, models, prompts, and architecture created by your dedicated engineers belongs entirely to you.']];

$steps = [['01', 'Technical Requirements & Stack Discovery', 'Understanding your project goals, required AI frameworks (LangGraph, PyTorch, RAG), and ideal developer seniority.'], ['02', 'Candidate Curation & Profile Matching', 'Matching your requirements against our pre-vetted roster and presenting the top 2 to 3 candidate profiles within 24 hours.'], ['03', 'Direct Technical Interview', 'Conducting a direct 1-on-1 technical interview with the candidate to assess culture fit and domain expertise.'], ['04', '48-Hour Onboarding & Tool Access', 'Adding the engineer to your GitHub, Slack, Jira, and development environments with NDA and security protocols.'], ['05', 'Continuous Sprint Delivery & Account Management', 'The engineer contributes to daily standups, commits clean PRs, supported by a dedicated iThrive delivery manager.']];

$models = [['01', 'Dedicated AI Specialist (1 Developer)', 'A dedicated full-time Agentic AI developer integrated directly into your engineering team for 3, 6, or 12+ months.', ['Full-time 40h/week', 'Direct Slack & GitHub access', '48-hour onboarding']], ['02', 'Dedicated AI Engineering Squad (3–5 Developers)', 'A complete cross-functional squad comprising an AI Architect, LangGraph Developer, and Frontend/AI Middleware Engineer.', ['Lead AI Architect + Developers', 'Full sprint accountability', 'Bi-weekly milestone demos']], ['03', 'Fractional AI Architect / CAIO', 'Strategic technical advisory, weekly architecture design reviews, and model benchmarking for executive leadership.', ['10–20 hours/month', 'Executive roadmap reviews', 'Priority technical advisory']]];

$techStack = ['LangGraph', 'Python', 'PyTorch', 'vLLM', 'Qdrant', 'FastAPI', 'TypeScript', 'Docker', 'Kubernetes', 'MCP'];

$pageStack = [
    ['slug' => 'languages', 'title' => 'Languages', 'icon' => 'code',
     'blurb' => 'What our engineers write in your repository.',
     'items' => [
         ['name' => 'Python', 'logo' => 'python'],
         ['name' => 'TypeScript', 'logo' => 'typescript'],
         ['name' => 'Go', 'logo' => 'go'],
         ['name' => 'Java', 'logo' => 'openjdk'],
     ]],
    ['slug' => 'ai', 'title' => 'AI Specialisms', 'icon' => 'brain',
     'blurb' => 'Retrieval, orchestration, evaluation and inference cost.',
     'items' => [
         ['name' => 'LangChain', 'logo' => 'langchain'],
         ['name' => 'OpenAI', 'logo' => 'openai'],
         ['name' => 'Anthropic', 'logo' => 'anthropic'],
         ['name' => 'PyTorch', 'logo' => 'pytorch'],
     ]],
    ['slug' => 'platform', 'title' => 'Delivery', 'icon' => 'cloud',
     'blurb' => 'Your pipeline, your review process, your accounts.',
     'items' => [
         ['name' => 'Docker', 'logo' => 'docker'],
         ['name' => 'Kubernetes', 'logo' => 'kubernetes'],
         ['name' => 'PostgreSQL', 'logo' => 'postgresql'],
         ['name' => 'GitHub Actions', 'logo' => 'githubactions'],
     ]],
];

$faqs = [['How quickly can a dedicated Agentic AI developer join our team?', 'We match and onboard pre-vetted developers within 48 to 72 hours. You interview the candidates directly and they can begin writing code on your next sprint.'], ['How do you vet and evaluate your AI engineers?', 'Our rigorous 4-stage vetting process evaluates algorithmic problem solving, hands-on LangGraph state machine development, vector search architecture, and live system design challenges. Only the top 1% of applicants are selected.'], ['What timezone will our dedicated AI developer work in?', 'Our developers provide 100% timezone overlap with your team across North America, Europe, India, and APAC. They participate in your daily standups, sprint planning, and Slack channels.'], ['Do we own the intellectual property (IP) and code written by the developers?', 'Yes. You maintain 100% ownership of all source code, models, prompts, datasets, and intellectual property produced during the engagement.'], ['Can we hire a single engineer or an entire squad?', 'Both. You can hire a single specialized developer (e.g., a LangGraph expert) or scale up to a full cross-functional AI squad (Architect, ML Engineer, Backend Developer, and QA).'], ['What happens if a developer is not the right fit for our project?', 'We offer a 14-day zero-risk trial period. If you feel the candidate is not the perfect fit, we will replace them immediately at no additional cost.'], ['What AI tools and frameworks are your developers experienced in?', 'Our developers specialize in LangGraph, Model Context Protocol (MCP), PyTorch, vLLM, LlamaIndex, Qdrant, Milvus, Hugging Face, FastAPI, Docker, and Kubernetes.'], ['How does billing and contract duration work?', 'We operate on straightforward monthly billing with no long-term lock-in. You can scale your team up or down with a standard 30-day notice.'], ['Will the developer work exclusively on our project?', 'Yes. All our dedicated developers work 100% exclusively on your project full-time (40 hours per week) with no split focus on other clients.'], ['Can your developers work within our secure private cloud or on-premise repositories?', 'Yes. Our engineers adhere to enterprise security protocols, connecting via your corporate VPN, hardware tokens, and private GitHub/GitLab organizations with strict NDA compliance.']];

/** Schema.org Structured Data with FAQPage & Service */
$schema = [
    '@context' => 'https://schema.org',
    '@graph' => [
        [
            '@type' => 'Service',
            'name' => 'Hire Dedicated Agentic AI Developers & Autonomous Swarm Engineers',
            'serviceType' => 'Agentic AI & Swarm Engineering',
            'description' => 'Hire pre-vetted top 1% Agentic AI engineers, LangGraph specialists, PyTorch researchers, and AI systems architects ready to deploy into your sprint within 48 hours.',
            'url' => canonical('services/hire-agentic-ai-developers.php'),
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
/* ---------------------------------------------------------------------------
 * The galaxy treatment
 *
 * This page is built like services.php: the same stylesheets in the same order
 * (galaxy first, then the service design system, whose tokens the roadmap,
 * step cards, tech stack and FAQ below still rely on) and the same WebGL
 * engine.
 *
 * galaxy-nodes.js is the addition. On services.php the galaxy is decorative
 * and the links sit in a flat grid beneath it; here each section of this page
 * is a marker on the disc that turns with it and is clickable. Those markers
 * are real anchors, so without the script they stay a plain row of in-page
 * links and every section remains reachable.
 * ------------------------------------------------------------------------ */
$extraHead = '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>'
    . '<link rel="stylesheet" href="https://fonts.googleapis.com/css2?'
    . 'family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;600;700'
    . '&family=Space+Grotesk:wght@500;600;700;800&display=swap">'
    . '<link rel="stylesheet" href="' . e(asset('assets/css/services-galaxy.css')) . '">'
    . '<link rel="stylesheet" href="' . e(asset('assets/css/service-custom.css')) . '">'
    . '<script type="module" src="' . e(asset('assets/js/framer-galaxy.js')) . '"></script>'
    . '<script type="module" src="' . e(asset('assets/js/galaxy-nodes.js')) . '"></script>';

/** The sections a visitor can fly to from inside the galaxy. */
$galaxyNodes = [
    ['advantage',   'Why Hire Here'],
    ['disciplines', 'Six Roles'],
    ['benefits',    'Advantages'],
    ['process',     'Hiring Roadmap'],
    ['models',      'Engagement'],
    ['stack',       'Tech Stack'],
    ['faq',         'FAQs'],
];

require dirname(__DIR__) . '/includes/header.php';
?>

<?php /* Both classes: the galaxy look, plus .svc-page so the design tokens the
         roadmap and card blocks below are written against still resolve. */ ?>
<div class="svc-galaxy-page svc-page">

  <!-- =========================================================================
       HERO: galaxy stage with one clickable marker per section
       ========================================================================= -->
  <section class="svc-galaxy-hero">
    <div class="shell" style="text-align:center;">
      <div class="svc-pill-badge" data-reveal>
        <span class="svc-pill-dot"></span>
        <span class="svc-pill-text">TOP 1% AGENTIC ENGINEERS · 48-HOUR ONBOARDING</span>
      </div>

      <h1 class="svc-hero-title" data-reveal style="--d:1">
        Hire Dedicated Agentic AI Developers
      </h1>

      <p class="svc-hero-lead" data-reveal style="--d:2">
        Pre-vetted top 1% Agentic AI engineers, LangGraph specialists, PyTorch researchers
        and AI systems architects, ready to deploy into your sprint within 48 hours.
      </p>

      <div class="svc-hero-ctas" data-reveal style="--d:3">
        <a class="svc-btn-primary" href="<?= e(url('contact.php')) ?>">
          Hire an AI Engineer <?= icon('arrow') ?>
        </a>
        <a class="svc-btn-secondary" href="#disciplines">Explore 6 Specialist Roles</a>
        <a class="svc-btn-secondary" href="tel:+919384564915">Call: +91 93845 64915</a>
      </div>

      <!-- 3D galaxy: drag to rotate, click a marker to jump to that section -->
      <div class="svc-galaxy-container" data-reveal style="--d:4">
        <div class="svc-galaxy-stage" id="galaxy-stage">
          <div class="svc-galaxy-hud">
            <span class="svc-galaxy-badge">85k Particle Neural Mesh Engine</span>
            <span style="font-family:'Space Grotesk',sans-serif;font-size:11px;color:#64748B;">
              Interactive 3D Section Navigator
            </span>
          </div>

          <?php /* Real in-page links. galaxy-nodes.js positions them on the
                   disc; with no script they are simply a centred row. */ ?>
          <nav class="svc-galaxy-nodes" data-galaxy-nodes aria-label="Jump to a section of this page">
            <?php foreach ($galaxyNodes as $i => [$anchor, $label]): ?>
              <a class="svc-galaxy-node" data-galaxy-node href="#<?= e($anchor) ?>">
                <span class="svc-galaxy-node-idx"><?= e(str_pad((string)($i + 1), 2, '0', STR_PAD_LEFT)) ?></span>
                <span><?= e($label) ?></span>
              </a>
            <?php endforeach; ?>
          </nav>

          <div class="svc-galaxy-hint">Drag to rotate · Click a marker to jump to that section</div>
        </div>
      </div>

      <!-- Engagement headline numbers -->
      <div class="svc-matrix-grid" style="grid-template-columns:repeat(auto-fit,minmax(200px,1fr));margin-top:34px;">
        <?php foreach ($stats as $i => [$figure, $caption]): ?>
          <div class="svc-matrix-card" data-reveal style="--d:<?= $i + 1 ?>;text-align:center;">
            <div class="svc-card-body">
              <h3 class="svc-card-title" style="font-size:2rem;"><?= e($figure) ?></h3>
              <p class="svc-card-desc"><?= e($caption) ?></p>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- =========================================================================
       1. WHY HIRE HERE
       ========================================================================= -->
  <section class="svc-section" id="advantage">
    <div class="shell">
      <div class="svc-sec-head" data-reveal>
        <span class="svc-eyebrow">THE HIRING ADVANTAGE</span>
        <h2 class="svc-title">Recruiting agentic engineers takes months;<br>this takes 48 hours</h2>
        <p class="svc-lead">
          The scarce skill is not Python — it is having shipped a stateful, tool-using agent into
          production and lived with what it does on week six. Our engineers have. They arrive
          having already made the mistakes you would otherwise pay to discover.
        </p>
      </div>
    </div>
  </section>

  <!-- =========================================================================
       2. SIX SPECIALIST ROLES
       ========================================================================= -->
  <section class="svc-section svc-section--panel" id="disciplines">
    <div class="shell">
      <div class="svc-sec-head" data-reveal>
        <span class="svc-eyebrow">SPECIALIST ROLES</span>
        <h2 class="svc-title">Six roles you can hire into your sprint</h2>
        <p class="svc-lead">Each one is a working engineer, not a generalist with an AI course behind them.</p>
      </div>

      <div class="svc-matrix-grid">
        <?php foreach ($disciplines as $i => [$num, $title, $copy]): ?>
          <?php $fig = svc_img('16', 3, $i + 1); ?>
          <div class="svc-matrix-card" data-reveal style="--d:<?= ($i % 4) + 1 ?>">
            <?php if ($fig): ?>
              <div class="svc-card-img-wrap">
                <img src="<?= e($fig) ?>" alt="<?= e($title) ?>" loading="lazy">
                <span class="svc-card-badge"><?= e($num) ?></span>
              </div>
            <?php endif; ?>
            <div class="svc-card-body">
              <?php if (!$fig): ?><span class="svc-card-group"><?= e($num) ?></span><?php endif; ?>
              <h3 class="svc-card-title"><?= e($title) ?></h3>
              <p class="svc-card-desc"><?= e($copy) ?></p>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- =========================================================================
       3. STRATEGIC ADVANTAGES
       ========================================================================= -->
  <section class="svc-section" id="benefits">
    <div class="shell">
      <div class="svc-sec-head" data-reveal>
        <span class="svc-eyebrow">WHY TEAMS STAY</span>
        <h2 class="svc-title">Five advantages of hiring dedicated AI engineers</h2>
        <p class="svc-lead">Flexible monthly engagements, full IP ownership, and no recruitment overhead.</p>
      </div>

      <div class="svc-matrix-grid" style="grid-template-columns:repeat(auto-fit,minmax(300px,1fr));">
        <?php foreach ($benefits as $i => [$num, $title, $copy]): ?>
          <?php $fig = svc_img('16', 5, $i + 1); ?>
          <div class="svc-matrix-card" data-reveal style="--d:<?= ($i % 4) + 1 ?>">
            <?php if ($fig): ?>
              <div class="svc-card-img-wrap">
                <img src="<?= e($fig) ?>" alt="<?= e($title) ?>" loading="lazy">
                <span class="svc-card-badge"><?= e($num) ?></span>
              </div>
            <?php endif; ?>
            <div class="svc-card-body">
              <?php if (!$fig): ?><span class="svc-card-group"><?= e($num) ?></span><?php endif; ?>
              <h3 class="svc-card-title"><?= e($title) ?></h3>
              <p class="svc-card-desc"><?= e($copy) ?></p>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- =========================================================================
       4. HIRING ROADMAP — the 3D lattice roadmap plus the phase cards
       ========================================================================= -->
  <section class="svc-section svc-section--panel" id="process">
    <div class="shell">
      <div class="svc-sec-head" data-reveal>
        <span class="svc-eyebrow">HIRING ROADMAP</span>
        <h2 class="svc-title">From requirement to first commit in five steps</h2>
        <p class="svc-lead">Most engagements reach a merged pull request inside the first week.</p>
      </div>

      <?php $GLOBALS['ithrive_needs_roadmap'] = true; ?>
      <div class="svc-roadmap" data-roadmap="lattice" aria-hidden="true">
        <?php foreach ($steps as $idx => [$sNum, $sTitle, $sCopy]): ?>
          <span data-roadmap-node="<?= $idx ?>" data-label="<?= e($sTitle) ?>"></span>
        <?php endforeach; ?>
      </div>

      <?php $s6 = array_filter([svc_img('16', 6, 1), svc_img('16', 6, 2), svc_img('16', 6, 3)]); ?>
      <?php if ($s6): ?>
        <div class="svc-s6-strip">
          <?php foreach ($s6 as $src): ?>
            <figure class="svc-card-fig"><img src="<?= e($src) ?>" alt="" loading="lazy"></figure>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

      <div class="svc-matrix-grid" style="grid-template-columns:repeat(auto-fit,minmax(240px,1fr));">
        <?php foreach ($steps as $idx => [$sNum, $sTitle, $sCopy]): ?>
          <div class="svc-matrix-card" data-roadmap-step="<?= $idx ?>" data-reveal style="--d:<?= $idx + 1 ?>">
            <div class="svc-card-body">
              <span class="svc-card-group">Phase <?= e($sNum) ?></span>
              <h3 class="svc-card-title"><?= e($sTitle) ?></h3>
              <p class="svc-card-desc"><?= e($sCopy) ?></p>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- =========================================================================
       5. ENGAGEMENT MODELS
       ========================================================================= -->
  <section class="svc-section" id="models">
    <div class="shell">
      <div class="svc-sec-head" data-reveal>
        <span class="svc-eyebrow">ENGAGEMENT MODELS</span>
        <h2 class="svc-title">Three ways to bring our engineers on</h2>
        <p class="svc-lead">Monthly billing, 30-day notice, and a 14-day replacement window on every model.</p>
      </div>

      <div class="svc-matrix-grid" style="grid-template-columns:repeat(auto-fit,minmax(320px,1fr));">
        <?php foreach ($models as $i => [$num, $title, $copy, $features]): ?>
          <div class="svc-matrix-card" data-reveal style="--d:<?= $i + 1 ?>">
            <div class="svc-card-body">
              <span class="svc-card-group"><?= e($num) ?></span>
              <h3 class="svc-card-title"><?= e($title) ?></h3>
              <p class="svc-card-desc"><?= e($copy) ?></p>
              <div style="display:flex;flex-wrap:wrap;gap:6px;margin:12px 0 16px;">
                <?php foreach ($features as $feature): ?>
                  <span style="font-family:'Space Grotesk',monospace;font-size:11px;font-weight:600;padding:3px 8px;border-radius:4px;background:rgba(0,242,254,0.08);color:#00F2FE;border:1px solid rgba(0,242,254,0.2);">
                    <?= e($feature) ?>
                  </span>
                <?php endforeach; ?>
              </div>
              <a class="svc-card-link" href="<?= e(url('contact.php')) ?>">Discuss this model <?= icon('arrow') ?></a>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- =========================================================================
       6. TECH STACK
       ========================================================================= -->
  <section class="svc-section svc-section--panel" id="stack">
    <div class="shell">
      <div class="svc-sec-head" data-reveal>
        <span class="svc-eyebrow">TECHNOLOGY STACK</span>
        <h2 class="svc-title">What our engineers work in</h2>
        <p class="svc-lead">Your pipeline, your review process, your accounts — we work inside them.</p>
      </div>

      <?php component('tech-stack', ['groups' => $pageStack]); ?>
    </div>
  </section>

  <!-- =========================================================================
       7. FAQ
       ========================================================================= -->
  <section class="svc-section" id="faq">
    <div class="shell">
      <div class="svc-sec-head" data-reveal>
        <span class="svc-eyebrow">HIRING FAQ</span>
        <h2 class="svc-title">Frequently asked questions</h2>
        <p class="svc-lead">Vetting, timezones, IP ownership and what happens if a developer is not the right fit.</p>
      </div>

      <div class="svc-faq-list">
        <?php foreach ($faqs as $i => [$q, $a]): ?>
          <details class="svc-faq-item"<?= $i === 0 ? ' open' : '' ?>>
            <summary class="svc-faq-q">
              <span><?= e($q) ?></span>
              <span class="svc-faq-indicator" aria-hidden="true"></span>
            </summary>
            <div class="svc-faq-a"><p><?= e($a) ?></p></div>
          </details>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- =========================================================================
       8. CLOSING CTA
       ========================================================================= -->
  <section class="svc-section svc-section--panel">
    <div class="shell" style="text-align:center;">
      <div class="svc-sec-head" data-reveal style="margin-bottom:24px;">
        <h2 class="svc-title">Tell us the role, and interview someone this week</h2>
        <p class="svc-lead" style="margin-inline:auto;">
          Send the stack and the seniority you need. We come back with two or three profiles
          inside 24 hours, and you interview them directly.
        </p>
      </div>
      <div class="svc-hero-ctas" data-reveal>
        <a class="svc-btn-primary" href="<?= e(url('contact.php')) ?>">Hire an AI Engineer <?= icon('arrow') ?></a>
        <a class="svc-btn-secondary" href="tel:+919384564915">Call: +91 93845 64915</a>
      </div>
    </div>
  </section>

</div>

<?php
require dirname(__DIR__) . '/includes/footer.php';
