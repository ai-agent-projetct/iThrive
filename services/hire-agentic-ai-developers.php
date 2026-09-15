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

$extraHead = '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>'
    . '<link rel="stylesheet" href="https://fonts.googleapis.com/css2?'
    . 'family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;600;700'
    . '&family=Space+Grotesk:wght@500;600;700;800&display=swap">'
    . '<link rel="stylesheet" href="' . e(asset('assets/css/service-custom.css')) . '">'
    . '<link rel="stylesheet" href="' . e(asset('assets/css/svc-theme.css')) . '">';
$GLOBALS['ithrive_needs_svc3d'] = true;

require dirname(__DIR__) . '/includes/header.php';
?>

<div class="svc-page" data-theme="team">

  <!-- =========================================================================
       HERO SECTION: Cyber Eyebrow, Gradient Headline & Action CTAs
       ========================================================================= -->
  <section class="svc-hero">
    <div class="svc-shell svc-hero-inner">
      <p class="svc-eyebrow"><span class="svc-pulse" aria-hidden="true"></span>Top 1% Agentic Engineers · 48-Hour Onboarding</p>

      <h1 class="svc-h1">
        Hire Dedicated Agentic AI Developers For<br><em>High-Velocity Production AI</em>
      </h1>

      <p class="svc-lead">
        Hire pre-vetted top 1% Agentic AI engineers, LangGraph specialists, PyTorch researchers, and AI systems architects ready to deploy into your sprint within 48 hours.
      </p>

      <div class="svc-actions svc-actions--mid">
        <button class="svc-btn svc-btn--primary" type="button"
                data-modal-open data-modal-service="Hire Dedicated Agentic AI Developers & Autonomous Swarm Engineers">
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
        <img src="<?= e(asset('assets/img/services/svc-16-hire-agentic-developers.jpg')) ?>" width="1200" height="700"
             alt="Hire Dedicated Agentic AI Developers & Autonomous Swarm Engineers Architecture" fetchpriority="high" decoding="async">
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
          <h2 class="svc-title">Hiring top AI talent is difficult and slow;<br><em>our dedicated engineers start in 48 hours</em></h2>
        </div>
        <div class="svc-open-copy">
          <p>Finding production-proven AI engineers who deeply understand LangGraph cyclic state machines, Model Context Protocol (MCP), fine-tuning, and vector retrieval takes 6+ months and hundreds of recruiting hours. Most applicants understand basic prompting but lack distributed systems engineering skills.</p>
          <p>We provide pre-vetted, top 1% dedicated Agentic AI Developers, LangGraph architects, and AI SREs ready to integrate directly into your sprint within 48 hours. Our engineers have built battle-tested multi-agent swarms, custom RAG pipelines, and private SLM architectures for leading enterprises globally.</p>
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
        <h2 class="svc-title">Six specialized engineering profiles<br>available for <em>immediate hire</em></h2>
        <p class="svc-sub">From LangGraph swarm architects to LLM fine-tuning specialists and AgentOps SREs.</p>
      </div>

      <div class="svc-cards-grid">
        <?php foreach ($disciplines as $i => [$num, $dTitle, $dDesc]): ?>
          <?php $fig = svc_img('16', 3, $i + 1); ?>
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
                data-modal-open data-modal-service="Hire Dedicated Agentic AI Developers & Autonomous Swarm Engineers">
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
        <h2 class="svc-title">Five strategic business advantages<br>of our <em>Hire Agentic Ai Developers</em></h2>
        <p class="svc-sub">
          Explore the architectural advantages that guarantee high concurrency, zero data leakage, and rapid payback timelines.
        </p>
      </div>

      <div class="svc-benefits-grid">
        <?php foreach ($benefits as $i => [$num, $bTitle, $bDesc]): ?>
          <?php $fig = svc_img('16', 5, $i + 1); ?>
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
      <div class="svc-roadmap" data-roadmap="lattice" aria-hidden="true">
        <?php foreach ($steps as $idx => [$num, $sTitle]): ?>
          <span data-roadmap-node="<?= $idx ?>" data-label="<?= e($sTitle) ?>"></span>
        <?php endforeach; ?>
      </div>

      <?php
      $s6 = array_filter([svc_img('16', 6, 1), svc_img('16', 6, 2), svc_img('16', 6, 3)]);
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
        <h2 class="svc-title">Three ways to engage our<br><em>Hire Agentic Ai Developers Practice</em></h2>
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
                    data-modal-open data-modal-service="Hire Dedicated Agentic AI Developers & Autonomous Swarm Engineers (Model <?= e($num) ?>)">
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
            <img src="<?= e(asset('assets/img/services/svc-16-hire-agentic-developers.jpg')) ?>" width="900" height="700"
                 alt="Hire Dedicated Agentic AI Developers & Autonomous Swarm Engineers FAQ Consultation" loading="lazy" decoding="async">
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
      <h2>Ready to build or scale your<br><em>Hire Agentic Ai Developers System?</em></h2>
      <p class="svc-close-lead">
        Discuss your technical requirements, latency constraints, and data governance policies directly with our Lead AI Systems Architects. Receive an actionable feasibility audit and prototype blueprint within 48 hours.
      </p>
      <div class="svc-actions svc-actions--mid">
        <button class="svc-btn svc-btn--primary" type="button"
                data-modal-open data-modal-service="Hire Dedicated Agentic AI Developers & Autonomous Swarm Engineers">
          Start 48-Hour Technical Discovery<?= icon('arrow') ?>
        </button>
      </div>
    </div>
  </section>

</div>

<?php
require dirname(__DIR__) . '/includes/footer.php';
