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
/* The character stands in this hero and follows the pointer — the same module the
   home page's character uses, pointed at his own frames. */
$GLOBALS['ithrive_needs_character'] = true;
/* The roles deck and the advantages carousel are island components, so the
   bundle has to load whether or not a gallery elsewhere on the page asks for
   it. */
$GLOBALS['ithrive_needs_originkit'] = true;
$pageTitle    = 'Hire AI Agent Developers in India';
$pageDesc     = 'Hire vetted agentic AI engineers, LangGraph specialists and AI systems architects from India — inside your sprint in about 48 hours, billed monthly.';
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
/* ---------------------------------------------------------------------------
 * Atmospheric treatment
 *
 * Built in the idiom of a cinematic studio site: one persistent WebGL field
 * fixed behind the whole document, film grain over everything, sparse
 * wide-tracked capitals and a lot of empty space, paced like a title sequence.
 *
 * service-custom.css still supplies every colour — the cyan and violet are
 * unchanged. hire-atmos.css changes density, rhythm and scale, not hue.
 *
 * No entry gate: sites in this idiom often open with one, but putting the
 * content of a page written to rank behind a click would cost more than the
 * flourish is worth.
 * ------------------------------------------------------------------------ */
$extraHead = '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>'
    . '<link rel="stylesheet" href="https://fonts.googleapis.com/css2?'
    . 'family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;600;700'
    . '&family=Space+Grotesk:wght@500;600;700;800&display=swap">'
    . '<link rel="stylesheet" href="' . e(asset('assets/css/service-custom.css')) . '">'
    . '<link rel="stylesheet" href="' . e(asset('assets/css/hire-atmos.css')) . '">'
    . '<script type="module" src="' . e(asset('assets/js/hire-atmos.js')) . '"></script>';

/** The sections a visitor can reach from the markers floating in the field. */
$navNodes = [
    ['roles',      'Six Roles'],
    ['advantages', 'Advantages'],
    ['process',    'Roadmap'],
    ['models',     'Engagement'],
    ['stack',      'Stack'],
    ['faq',        'FAQs'],
];

require dirname(__DIR__) . '/includes/header.php';
?>

<?php /* .svc-page too, so the design tokens the roadmap, tech stack and FAQ
         blocks are written against still resolve. */ ?>
<div class="hire-atmos svc-page">

  <?php /* The persistent field and the grain, behind everything. Both are
           decoration: with no WebGL the field is just a gradient. */ ?>
  <div class="hire-field" aria-hidden="true"></div>
  <div class="hire-grain" aria-hidden="true"></div>

  <!-- =========================================================================
       OPENING
       ========================================================================= -->
  <section class="hire-sec hire-hero">
    <?php /* She is drawn across the whole opening and feathered into it, the
             way the character is on the home page, so there is no box around
             him. The scrim after him keeps the headline readable where he
             passes behind it. */ ?>
    <div class="hire-sky" aria-hidden="true"></div>
    <canvas class="hire-character" data-character-canvas
            data-base="<?= e(url('assets/img/character')) ?>"
            data-version="<?= e((string) @filemtime(ROOT_PATH . '/assets/img/character/center.webp')) ?>"
            data-stage-x="0.74" data-stage-y="0.44" data-fill="0.92"
            role="img"
            aria-label="The iThrive character in a branded cap, who turns to follow your pointer and looks straight at you when it comes near her."></canvas>
    <div class="hire-character-scrim" aria-hidden="true"></div>

    <?php /* The same hint the home hero carries; character.js marks the
             document once it has seen the pointer move and it fades. */ ?>
    <div class="hero-hint" aria-hidden="true">
      <span class="hero-hint-dot"></span>
      <svg class="hero-hint-curve" viewBox="0 0 120 60" fill="none">
        <path d="M4 6 C 40 2, 78 14, 104 44" stroke="currentColor" stroke-width="2"
              stroke-linecap="round" stroke-dasharray="3 7"/>
        <path d="M96 30 L104 44 L88 44" stroke="currentColor" stroke-width="2"
              stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
      <span class="hero-hint-text">Move your mouse</span>
    </div>

    <div class="hire-shell">
      <p class="hire-eyebrow" data-rise>Top 1% Agentic Engineers — 48-Hour Onboarding</p>

      <h1 class="hire-h1" data-rise>
        Hire dedicated
        <em>agentic AI engineers</em>
      </h1>

      <p class="hire-hero-lead" data-rise>
        Pre-vetted LangGraph specialists, PyTorch researchers and AI systems architects —
        interviewed by you, writing production code inside your sprint within 48 hours.
      </p>

      <div class="hire-ctas" data-rise>
        <a class="hire-btn hire-btn--solid" href="<?= e(url('contact.php')) ?>">Hire an engineer</a>
        <a class="hire-btn" href="#roles">Six specialist roles</a>
        <a class="hire-btn" href="tel:+919384564915">+91 93845 64915</a>
      </div>

      <?php /* Real in-page links. hire-atmos.js floats them in the field; with
               no script they stay a plain wrapped row. */ ?>
      <nav class="hire-nodes" data-nodes aria-label="Jump to a section of this page">
        <?php foreach ($navNodes as $i => [$anchor, $label]): ?>
          <a class="hire-node" data-node href="#<?= e($anchor) ?>">
            <span class="hire-node-i"><?= e(str_pad((string)($i + 1), 2, '0', STR_PAD_LEFT)) ?></span>
            <span><?= e($label) ?></span>
          </a>
        <?php endforeach; ?>
      </nav>

      <p class="hire-cue" data-rise>Scroll</p>
    </div>
  </section>

  <!-- =========================================================================
       THE NUMBERS
       ========================================================================= -->
  <section class="hire-sec">
    <div class="hire-shell">
      <p class="hire-eyebrow" data-rise>The engagement</p>
      <h2 class="hire-h2" data-rise>Recruiting agentic engineers takes months.<br><em>This takes 48 hours.</em></h2>
      <p class="hire-lead" data-rise>
        The scarce skill is not Python. It is having shipped a stateful, tool-using agent into
        production and lived with what it does on week six. Our engineers have — they arrive
        having already made the mistakes you would otherwise pay to discover.
      </p>

      <?php /* Four figures standing in depth rather than four more rows. They
               sit on a shared perspective floor, angled away from the centre, and
               the one under the pointer turns to face you. Pure CSS, so it costs
               the page nothing and still reads as a different section. */ ?>
      <div class="hire-pillars" data-rise>
        <?php foreach ($stats as $i => [$figure, $caption]): ?>
          <div class="hire-pillar" style="--i:<?= $i ?>">
            <div class="hire-pillar-face">
              <span class="hire-pillar-n"><?= e(str_pad((string)($i + 1), 2, '0', STR_PAD_LEFT)) ?></span>
              <strong class="hire-pillar-fig"><?= e($figure) ?></strong>
              <span class="hire-pillar-cap"><?= e($caption) ?></span>
            </div>
            <span class="hire-pillar-floor" aria-hidden="true"></span>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- =========================================================================
       SIX ROLES — section 3 image slots
       ========================================================================= -->
  <section class="hire-sec" id="roles">
    <div class="hire-shell">
      <p class="hire-eyebrow" data-rise>Specialist roles</p>
      <h2 class="hire-h2" data-rise>Six roles you can hire<br><em>into your sprint</em></h2>
      <p class="hire-lead" data-rise>Each one is a working engineer, not a generalist with an AI course behind them.</p>

      <?php /* The six roles ride the card deck: number, role, what they do and
               their picture on one card, instead of a gallery above a list that
               repeats the same six names. */ ?>
      <div class="hire-deck" data-ok="card-showcase" data-props='<?= e(json_encode([
          'cards' => array_values(array_filter(array_map(
              static function (array $r, int $i): ?array {
                  $img = svc_img('16', 3, $i + 1);
                  return [
                      'number'      => $r[0],
                      'title'       => $r[1],
                      'description' => $r[2],
                      'tag'         => 'Specialist role',
                      'image'       => ['src' => $img ?? '', 'alt' => $r[1]],
                  ];
              },
              $disciplines,
              array_keys($disciplines)
          ))),
          'progressColor' => '#3EE1FF',
          'animationSpeed' => 6,
          'loop'          => true,
          'textColor'     => '#EAF0FA',
          'numberColor'   => 'rgba(234,240,250,.28)',
          'tagColor'      => '#9D4EDD',
      ], JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR)) ?>'></div>

      <?php /* Without the island the same six are a plain list, so the page is
               never a blank box and the words are always in the markup. */ ?>
      <noscript>
        <div class="hire-rows" style="margin-top:clamp(40px,6vh,72px);">
          <?php foreach ($disciplines as [$num, $title, $copy]): ?>
            <div class="hire-row">
              <span class="hire-row-n"><?= e($num) ?></span>
              <h3 class="hire-row-t"><?= e($title) ?></h3>
              <p class="hire-row-d"><?= e($copy) ?></p>
            </div>
          <?php endforeach; ?>
        </div>
      </noscript>
    </div>
  </section>

  <!-- =========================================================================
       ADVANTAGES — section 5 image slots
       ========================================================================= -->
  <section class="hire-sec" id="advantages">
    <div class="hire-shell">
      <p class="hire-eyebrow" data-rise>Why teams stay</p>
      <h2 class="hire-h2" data-rise>Five advantages of hiring<br><em>dedicated AI engineers</em></h2>
      <p class="hire-lead" data-rise>Flexible monthly engagements, full IP ownership, and no recruitment overhead.</p>

      <?php /* The five advantages ride the liquid lens — a different motion to
               the deck above, and again the words travel with the picture. */ ?>
      <div class="hire-liquid" data-ok="liquid-carousel" data-props='<?= e(json_encode([
          'projects' => array_values(array_map(
              static function (array $b, int $i): array {
                  $img = svc_img('16', 5, $i + 1);
                  return [
                      'brand'       => $b[1],
                      'description' => $b[2],
                      'image'       => ['src' => $img ?? '', 'alt' => $b[1]],
                  ];
              },
              $benefits,
              array_keys($benefits)
          )),
          'panelHeight'      => 460,
          'gap'              => 20,
          'glide'            => 0.08,
          'wheelSensitivity' => 1,
          'snap'             => true,
          'lensShape'        => 'circle',
          'lensWidth'        => 0.22,
          'lensHeight'       => 0.82,
          'lensX'            => 0.0,
          'lensY'            => 0.5,
          'dispersion'       => 16,
          'zoom'             => 0.12,
          'glow'             => 5.5,
          'blueRing'         => 6.5,
          'blueColor'        => '#3EE1FF',
          'shimmer'          => true,
          'focusScale'       => 1.15,
          'background'       => 'rgba(0,0,0,0)',
          'foreground'       => '#EAF0FA',
          'showLabels'       => true,
          'showCursor'       => true,
      ], JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR)) ?>'></div>

      <noscript>
        <div class="hire-rows" style="margin-top:clamp(40px,6vh,72px);">
          <?php foreach ($benefits as [$num, $title, $copy]): ?>
            <div class="hire-row">
              <span class="hire-row-n"><?= e($num) ?></span>
              <h3 class="hire-row-t"><?= e($title) ?></h3>
              <p class="hire-row-d"><?= e($copy) ?></p>
            </div>
          <?php endforeach; ?>
        </div>
      </noscript>
    </div>
  </section>

  <!-- =========================================================================
       ROADMAP — the lattice 3D diagram, section 6 image slots
       ========================================================================= -->
  <section class="hire-sec" id="process">
    <div class="hire-shell">
      <p class="hire-eyebrow" data-rise>Hiring roadmap</p>
      <h2 class="hire-h2" data-rise>From requirement to<br><em>first commit in five steps</em></h2>
      <p class="hire-lead" data-rise>Most engagements reach a merged pull request inside the first week.</p>

      <?php $GLOBALS['ithrive_needs_roadmap'] = true; ?>
      <div class="svc-roadmap" data-roadmap="lattice" aria-hidden="true">
        <?php foreach ($steps as $idx => [$sNum, $sTitle, $sCopy]): ?>
          <span data-roadmap-node="<?= $idx ?>" data-label="<?= e($sTitle) ?>"></span>
        <?php endforeach; ?>
      </div>
      <?php /* No gallery here. This section's three photographs now travel on
               the engagement cards below, and the roadmap lattice above is the
               picture — a stack of images would only make this read like the two
               sections before it. */ ?>
      <div class="hire-rows" style="margin-top:clamp(30px,4vh,56px);">
        <?php foreach ($steps as $idx => [$sNum, $sTitle, $sCopy]): ?>
          <div class="hire-row" data-roadmap-step="<?= $idx ?>" data-rise>
            <span class="hire-row-n"><?= e($sNum) ?></span>
            <h3 class="hire-row-t"><?= e($sTitle) ?></h3>
            <p class="hire-row-d"><?= e($sCopy) ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- =========================================================================
       ENGAGEMENT MODELS
       ========================================================================= -->
  <section class="hire-sec" id="models">
    <div class="hire-shell">
      <p class="hire-eyebrow" data-rise>Engagement models</p>
      <h2 class="hire-h2" data-rise>Three ways to bring<br><em>our engineers on</em></h2>
      <p class="hire-lead" data-rise style="margin-bottom:clamp(36px,5vh,60px);">
        Monthly billing, 30-day notice, and a 14-day replacement window on every model.
      </p>

      <?php /* The three models ride the bookmark deck: one card stands open at a
               time and the other two wait folded beside it, so the page stops
               presenting a third identical three-column card grid. The section's
               own photographs live on the cards. */ ?>
      <div class="hire-bookmarks" data-ok="bookmark-models" data-props='<?= e(json_encode([
          'models' => array_values(array_map(
              static function (array $m, int $i): array {
                  $accents = ['#3EE1FF', '#9D4EDD', '#EC4899'];
                  $rgbs    = ['62, 225, 255', '157, 78, 221', '236, 72, 153'];
                  $tags    = ['— DEDICATED SPECIALIST®', '— ENGINEERING SQUAD®', '— FRACTIONAL ARCHITECT®'];
                  $short   = ['One Engineer.', 'Full Squad.', 'Advisory.'];

                  return [
                      'id'          => 'hire-model-' . $m[0],
                      'tag'         => $tags[$i],
                      'title'       => $short[$i],
                      'subtitle'    => $m[1],
                      'quote'       => $m[2],
                      'accent'      => $accents[$i],
                      'accentRgb'   => $rgbs[$i],
                      'image'       => svc_img('16', 6, $i + 1) ?? '',
                      'activeIndex' => $i,
                      'features'    => $m[3],
                  ];
              },
              $models,
              array_keys($models)
          )),
      ], JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR)) ?>'></div>

      <?php /* Without the island the same three are plain cards, so the words are
               always in the markup and the section is never an empty box. */ ?>
      <noscript>
        <div class="hire-models">
          <?php foreach ($models as [$num, $title, $copy, $features]): ?>
            <div class="hire-model">
              <span class="hire-model-n"><?= e($num) ?></span>
              <h3 class="hire-model-t"><?= e($title) ?></h3>
              <p class="hire-model-d"><?= e($copy) ?></p>
              <ul class="hire-model-f">
                <?php foreach ($features as $feature): ?>
                  <li><?= e($feature) ?></li>
                <?php endforeach; ?>
              </ul>
              <a class="hire-btn" href="<?= e(url('contact.php')) ?>">Discuss</a>
            </div>
          <?php endforeach; ?>
        </div>
      </noscript>
    </div>
  </section>

  <!-- =========================================================================
       TECH STACK
       ========================================================================= -->
  <section class="hire-sec" id="stack">
    <div class="hire-shell">
      <p class="hire-eyebrow" data-rise>Technology stack</p>
      <h2 class="hire-h2" data-rise>What our engineers<br><em>work in</em></h2>
      <p class="hire-lead" data-rise style="margin-bottom:clamp(36px,5vh,60px);">
        Your pipeline, your review process, your accounts — we work inside them.
      </p>

      <div data-rise>
        <?php component('tech-stack', ['groups' => $pageStack]); ?>
      </div>
    </div>
  </section>

  <!-- =========================================================================
       FAQ
       ========================================================================= -->
  <section class="hire-sec" id="faq">
    <div class="hire-shell">
      <p class="hire-eyebrow" data-rise>Hiring FAQ</p>
      <h2 class="hire-h2" data-rise>Frequently asked<br><em>questions</em></h2>
      <p class="hire-lead" data-rise style="margin-bottom:clamp(36px,5vh,60px);">
        Vetting, timezones, IP ownership, and what happens if a developer is not the right fit.
      </p>

      <div class="svc-faq-list" data-rise>
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
       CLOSING
       ========================================================================= -->
  <section class="hire-sec">
    <div class="hire-shell">
      <p class="hire-eyebrow" data-rise>Next step</p>
      <h2 class="hire-h2" data-rise>Tell us the role, and<br><em>interview someone this week</em></h2>
      <p class="hire-lead" data-rise style="margin-bottom:34px;">
        Send the stack and the seniority you need. We come back with two or three profiles
        inside 24 hours, and you interview them directly.
      </p>
      <div class="hire-ctas" data-rise>
        <a class="hire-btn hire-btn--solid" href="<?= e(url('contact.php')) ?>">Hire an engineer</a>
        <a class="hire-btn" href="tel:+919384564915">+91 93845 64915</a>
      </div>
    </div>
  </section>

</div>

<?php
require dirname(__DIR__) . '/includes/footer.php';
