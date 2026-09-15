<?php
/**
 * AI Chatbot & Conversational Voice AI Development Company
 *
 * Enterprise AI Service Page engineered with modern dark cyber UI,
 * 6 Core Capabilities, 5 Strategic ROI Advantages, 5-Step Process Roadmap,
 * 3 Deployment Frameworks, Tech Stack Arena, and 10 Detailed FAQs with Schema.org JSON-LD.
 */

declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/config.php';

$page         = 'services';
$pageTitle    = 'AI Chatbot & Conversational Voice AI Development Company';
$pageDesc     = 'Sub-400ms conversational AI voicebots and omnichannel chatbots in 25+ languages across WhatsApp, Web, and telephony with direct CRM and ERP synchronization.';
$ogImage      = 'assets/img/services/svc-03-ai-chatbot.jpg';

/* ---------------------------------------------------------------------------
 * Content Definitions
 * ------------------------------------------------------------------------ */

$stats = [['<400ms', 'Voice Call Audio Latency'], ['25+', 'Regional & Indian Languages'], ['82%', 'First-Contact Resolution'], ['24/7', 'Omnichannel Availability']];

$disciplines = [['01', 'Sub-400ms Conversational Voicebots', 'Telephony-integrated voice agents with human-grade prosody, natural breathing, and real-time speech-to-speech streaming pipelines.'], ['02', 'Multilingual WhatsApp & Web Chatbots', 'Omnichannel bots supporting 25+ Indian and global languages, processing text, voice notes, and document uploads seamlessly.'], ['03', 'CRM & ERP Bi-Directional Synchronization', 'Live bi-directional sync with Salesforce, HubSpot, Zoho, SAP, and Zendesk, automating lead qualification, appointment booking, and order tracking.'], ['04', 'Real-Time Interruption & Sentiment Handling', 'Full-duplex audio processing that pauses speaking instantly when the caller speaks and adapts tone based on detected customer sentiment.'], ['05', 'Human-in-the-Loop Escalation', 'Seamless, zero-friction handoff to human support representatives with complete conversation summaries and recommended response drafts.'], ['06', 'Enterprise Security & PCI-DSS Compliance', 'End-to-end encrypted voice streams, automated PII/PCI redaction for credit card payments, and SOC 2 Type II audit logging.']];

$benefits = [['01', '80%+ Support Queue Deflection', 'Resolve routine customer queries, returns, and order lookups autonomously without human operator intervention.'], ['02', 'Sub-400ms Human-Like Conversation', 'Ultra-fast audio response times eliminate awkward pauses, delivering a fluid conversational experience indistinguishable from a human.'], ['03', 'Massive Regional Market Reach', 'Engage customers natively in Hindi, Tamil, Telugu, Kannada, Bengali, and 20+ other languages with cultural nuance.'], ['04', '24/7/365 Non-Stop Sales Pipeline', 'Capture, qualify, and book sales meetings around the clock across global time zones with zero delay.'], ['05', 'Continuous Learning & Analytics', 'Real-time conversation analytics dashboards identify customer pain points, churn signals, and conversion trends.']];

$steps = [['01', 'Conversation Architecture & Scripting', 'Mapping user intents, dialogue state machines, API tool contracts, and brand persona voice tone.'], ['02', 'Knowledge Base & Tool Binding', 'Indexing enterprise FAQs, product manuals, and connecting API endpoints for live data lookups.'], ['03', 'Speech & Telephony Pipeline Setup', 'Integrating SIP/PSTN telephony (Twilio, Exotel) with low-latency streaming STT, LLM reasoning, and TTS engines.'], ['04', 'Multilingual & Accent Fine-Tuning', 'Testing voice recognition accuracy across diverse regional accents and acoustic noise environments.'], ['05', 'Production Launch & Telemetry', 'Deploying across WhatsApp, mobile apps, and phone lines with real-time call recording and sentiment dashboards.']];

$models = [['01', 'Omnichannel Web & WhatsApp Bot', 'Production text chatbot integrated into your website, WhatsApp Business API, and CRM in 3 weeks.', ['WhatsApp & Web widget', 'CRM lead capture & booking', 'Knowledge base RAG search']], ['02', 'Autonomous Voice Telephony Agent', 'Sub-400ms voicebot deployed to your incoming and outgoing phone numbers for automated support and qualification.', ['Twilio/Exotel SIP integration', 'Real-time interruption handling', 'Live human agent handoff']], ['03', 'Enterprise Contact Center AI Swarm', 'Full contact center modernization with voice, chat, multilingual support, and automated CRM wrap-up notes.', ['Multi-agent telephony swarm', '25+ languages with Sarvam AI', 'Custom private VPC hosting']]];

$techStack = ['Twilio / Exotel', 'Sarvam AI', 'LiveKit', 'Whisper', 'FastAPI', 'LangGraph', 'PostgreSQL', 'Redis', 'WebSockets'];

$pageStack = [
    ['slug' => 'models', 'title' => 'Models & Retrieval', 'icon' => 'brain',
     'blurb' => 'What answers, and what it answers from.',
     'items' => [
         ['name' => 'OpenAI', 'logo' => 'openai'],
         ['name' => 'Anthropic', 'logo' => 'anthropic'],
         ['name' => 'LangChain', 'logo' => 'langchain'],
         ['name' => 'Python', 'logo' => 'python'],
     ]],
    ['slug' => 'channels', 'title' => 'Channels & Interface', 'icon' => 'message',
     'blurb' => 'Web, in-app and messaging, off one backend.',
     'items' => [
         ['name' => 'FastAPI', 'logo' => 'fastapi'],
         ['name' => 'Node.js', 'logo' => 'nodedotjs'],
         ['name' => 'React', 'logo' => 'react'],
         ['name' => 'TypeScript', 'logo' => 'typescript'],
     ]],
    ['slug' => 'platform', 'title' => 'Platform & Operations', 'icon' => 'cloud',
     'blurb' => 'Session state, deployment and the metrics that matter.',
     'items' => [
         ['name' => 'Redis', 'logo' => 'redis'],
         ['name' => 'PostgreSQL', 'logo' => 'postgresql'],
         ['name' => 'Docker', 'logo' => 'docker'],
         ['name' => 'Grafana', 'logo' => 'grafana'],
     ]],
];

$faqs = [['How realistic do your AI voicebots sound over phone calls?', 'Our voicebots achieve human-grade naturalness with sub-400ms end-to-end audio latency, expressive prosody, dynamic pauses, and full-duplex interruption handling that stops speaking immediately when the user speaks.'], ['Which messaging platforms and channels do you support?', 'We deploy conversational agents across WhatsApp Business API, Web widgets, iOS & Android mobile SDKs, Facebook Messenger, Telegram, Instagram DMs, and standard telephone lines (PSTN/SIP).'], ['Can the bot access our private customer database to check order status?', 'Yes. Our bots utilize secure tool-calling contracts to query your internal databases, ERPs, and OMS in real time, securely retrieving order tracking, invoice details, and account balances.'], ['How does the bot handle regional Indian languages and accents?', 'We integrate advanced phonetic speech models (including Sarvam AI and Whisper Indic) fine-tuned on regional dialects, supporting English, Hindi, Tamil, Telugu, Kannada, Malayalam, Marathi, Bengali, and Gujarati.'], ['What happens when a customer asks a question the bot cannot answer?', 'The bot gracefully summarizes the conversation history, flags the intent confidence score, and routes the caller to a live human agent with the transcript pre-loaded on their screen.'], ['Is customer voice and chat data encrypted and compliant?', 'Yes. All data streams are encrypted with TLS 1.3 in transit and AES-256 at rest. Sensitive PII, credit card numbers, and passwords are automatically masked before logging, adhering to PCI-DSS, SOC 2, and GDPR.'], ['Can the chatbot take customer payments directly in chat?', 'Yes. We integrate secure payment gateway webhooks (Stripe, Razorpay, UPI deep-links) enabling customers to complete purchases and pay invoices directly within WhatsApp or web chat.'], ['How long does it take to train the chatbot on our company knowledge?', 'Using our high-speed vector ingestion pipeline, we can index hundreds of company PDF manuals, FAQs, and help center articles in less than 48 hours.'], ['Can the bot handle cold outreach and inbound sales qualification calls?', 'Yes. Our voice agents are widely deployed for outbound lead follow-up, webinar reminders, abandoned cart re-engagement, and inbound qualification with direct calendar scheduling.'], ['How are pricing and operational token costs structured for conversational bots?', 'We offer transparent models: fixed engineering setup and deployment tiers with predictable infrastructure costs, minimizing token overhead through semantic caching.']];

/** Schema.org Structured Data with FAQPage & Service */
$schema = [
    '@context' => 'https://schema.org',
    '@graph' => [
        [
            '@type' => 'Service',
            'name' => 'AI Chatbot & Conversational Voice AI Development Company',
            'serviceType' => 'AI-First Product Development',
            'description' => 'Sub-400ms conversational AI voicebots and omnichannel chatbots in 25+ languages across WhatsApp, Web, and telephony with direct CRM and ERP synchronization.',
            'url' => canonical('services/ai-chatbot-development.php'),
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
      <p class="svc-eyebrow"><span class="svc-pulse" aria-hidden="true"></span>Conversational Voice & Chat AI ? Sub-400ms Telephony</p>

      <h1 class="svc-h1">
        AI Chatbot & Voicebot Development For<br><em>Instant Conversational Resolution</em>
      </h1>

      <p class="svc-lead">
        Sub-400ms conversational AI voicebots and multichannel chatbots in 25+ languages across WhatsApp, Web, and telephony with direct CRM and ERP synchronization.
      </p>

      <div class="svc-actions svc-actions--mid">
        <button class="svc-btn svc-btn--primary" type="button"
                data-modal-open data-modal-service="AI Chatbot & Conversational Voice AI Development Company">
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
        <img src="<?= e(asset('assets/img/services/svc-03-ai-chatbot.jpg')) ?>" width="1200" height="700"
             alt="AI Chatbot & Conversational Voice AI Development Company Architecture" fetchpriority="high" decoding="async">
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
          <h2 class="svc-title">Scripted bots frustrate users;<br><em>cognitive conversational agents convert</em></h2>
        </div>
        <div class="svc-open-copy">
          <p>Legacy rule-based chatbots fail the moment a user deviates from a rigid decision tree, causing customer churn and overwhelming human support queues. Customers demand fluid, human-like voice and text interactions that understand nuance, accents, interruptions, and context.</p>
          <p>We build ultra-low-latency conversational AI agents powered by state-of-the-art LLMs, neural speech synthesis, and real-time streaming telephony. Our bots understand complex intent, execute multi-turn transactions, and update your CRM and ERP systems instantly.</p>
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
        <h2 class="svc-title">Six conversational AI disciplines<br>for <em>omnichannel engagement</em></h2>
        <p class="svc-sub">From WhatsApp text agents to sub-400ms voice telephony bots.</p>
      </div>

      <div class="svc-cards-grid">
        <?php foreach ($disciplines as $i => [$num, $dTitle, $dDesc]): ?>
          <?php $fig = svc_img('03', 3, $i + 1); ?>
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
                data-modal-open data-modal-service="AI Chatbot & Conversational Voice AI Development Company">
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
        <h2 class="svc-title">Five strategic business advantages<br>of our <em>Ai Chatbot Development</em></h2>
        <p class="svc-sub">
          Explore the architectural advantages that guarantee high concurrency, zero data leakage, and rapid payback timelines.
        </p>
      </div>

      <div class="svc-benefits-grid">
        <?php foreach ($benefits as $i => [$num, $bTitle, $bDesc]): ?>
          <?php $fig = svc_img('03', 5, $i + 1); ?>
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
      <div class="svc-roadmap" data-roadmap aria-hidden="true">
        <?php foreach ($steps as $idx => [$num, $sTitle]): ?>
          <span data-roadmap-node="<?= $idx ?>" data-label="<?= e($sTitle) ?>"></span>
        <?php endforeach; ?>
      </div>

      <?php
      $s6 = array_filter([svc_img('03', 6, 1), svc_img('03', 6, 2), svc_img('03', 6, 3)]);
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
        <h2 class="svc-title">Three ways to engage our<br><em>Ai Chatbot Development Practice</em></h2>
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
                    data-modal-open data-modal-service="AI Chatbot & Conversational Voice AI Development Company (Model <?= e($num) ?>)">
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
            <img src="<?= e(asset('assets/img/services/svc-03-ai-chatbot.jpg')) ?>" width="900" height="700"
                 alt="AI Chatbot & Conversational Voice AI Development Company FAQ Consultation" loading="lazy" decoding="async">
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
      <h2>Ready to build or scale your<br><em>Ai Chatbot Development System?</em></h2>
      <p class="svc-close-lead">
        Discuss your technical requirements, latency constraints, and data governance policies directly with our Lead AI Systems Architects. Receive an actionable feasibility audit and prototype blueprint within 48 hours.
      </p>
      <div class="svc-actions svc-actions--mid">
        <button class="svc-btn svc-btn--primary" type="button"
                data-modal-open data-modal-service="AI Chatbot & Conversational Voice AI Development Company">
          Start 48-Hour Technical Discovery<?= icon('arrow') ?>
        </button>
      </div>
    </div>
  </section>

</div>

<?php
require dirname(__DIR__) . '/includes/footer.php';
