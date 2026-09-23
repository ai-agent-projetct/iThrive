<?php
declare(strict_types=1);

$page      = 'services';
$pageTitle = 'Enterprise AI Engineering Services';
$pageDesc  = 'Sixteen enterprise AI engineering practices: AI strategy, generative AI, agentic AI and multi-agent swarms, and autonomous enterprise automation.';

require_once __DIR__ . '/includes/config.php';

$allServicesList = [
    [
        'slug'     => 'ai-consulting',
        'title'    => 'AI Consulting & Strategy',
        'category' => 'AI Strategy & Advisory',
        'cat_id'   => 'strategy',
        'badge'    => 'PRACTICE 01',
        'image'    => 'assets/img/services/svc-01-ai-consulting.jpg',
        'lead'     => 'Strategic AI roadmaps, technical feasibility audits, unit economics modeling, and compliance frameworks for enterprise scale.',
        'metrics'  => ['99.9% Audit Pass', '4.2x ROI Model', '14-Day Delivery'],
        'stack'    => ['Python', 'FastAPI', 'LangGraph', 'AWS', 'Azure'],
    ],
    [
        'slug'     => 'gen-ai-development',
        'title'    => 'Generative AI Development',
        'category' => 'Generative AI & Products',
        'cat_id'   => 'genai',
        'badge'    => 'PRACTICE 02',
        'image'    => 'assets/img/services/svc-02-gen-ai-dev.jpg',
        'lead'     => 'Custom LLM fine-tuning, domain foundation models, multimodal inference engines, and low-latency private deployment.',
        'metrics'  => ['<35ms Latency', '80% Token Reduction', '100% On-Prem / VPC'],
        'stack'    => ['PyTorch', 'vLLM', 'Hugging Face', 'DeepSpeed', 'Triton'],
    ],
    [
        'slug'     => 'ai-chatbot-development',
        'title'    => 'AI Chatbot Development',
        'category' => 'Generative AI & Products',
        'cat_id'   => 'genai',
        'badge'    => 'PRACTICE 03',
        'image'    => 'assets/img/services/svc-03-ai-chatbot.jpg',
        'lead'     => 'Next-generation conversational agents with multi-turn memory, CRM integration, voice orchestration, and zero hallucination.',
        'metrics'  => ['82% Deflection', '<150ms First Token', '99.4% F1 Accuracy'],
        'stack'    => ['LangChain', 'FastAPI', 'Redis', 'WebSockets', 'Whisper'],
    ],
    [
        'slug'     => 'ai-copilot-development',
        'title'    => 'AI Copilot Development',
        'category' => 'Generative AI & Products',
        'cat_id'   => 'genai',
        'badge'    => 'PRACTICE 04',
        'image'    => 'assets/img/services/svc-04-ai-copilot.jpg',
        'lead'     => 'Context-aware enterprise copilots embedded into IDEs, SaaS platforms, and internal backoffices with proactive semantic assistance.',
        'metrics'  => ['40% Dev Uplift', '0-Context Leaks', '24/7 Inline Intelligence'],
        'stack'    => ['Electron', 'TypeScript', 'LangGraph', 'pgvector', 'Ollama'],
    ],
    [
        'slug'     => 'rag-development',
        'title'    => 'RAG Systems Development',
        'category' => 'Generative AI & Products',
        'cat_id'   => 'genai',
        'badge'    => 'PRACTICE 05',
        'image'    => 'assets/img/services/svc-05-rag-dev.jpg',
        'lead'     => 'Hybrid vector + BM25 keyword retrieval, Knowledge Graph RAG, reranking, and citation-backed deterministic synthesis.',
        'metrics'  => ['99.8% Groundedness', '<80ms Retrieval', '10M+ Chunk Corpus'],
        'stack'    => ['Qdrant', 'Pinecone', 'Neo4j', 'LlamaIndex', 'Cohere'],
    ],
    [
        'slug'     => 'computer-vision-development',
        'title'    => 'Computer Vision Development',
        'category' => 'Generative AI & Products',
        'cat_id'   => 'genai',
        'badge'    => 'PRACTICE 06',
        'image'    => 'assets/img/services/svc-06-computer-vision.jpg',
        'lead'     => 'Real-time object detection, automated visual defect inspection, spatial intelligence, and multimodal edge inferencing.',
        'metrics'  => ['60 FPS Live Edge', '99.7% Precision', '50ms Pipeline'],
        'stack'    => ['YOLOv10', 'OpenCV', 'TensorRT', 'PyTorch', 'NVIDIA Jetson'],
    ],
    [
        'slug'     => 'agentic-ai-strategy',
        'title'    => 'Agentic AI Strategy & Advisory',
        'category' => 'AI Strategy & Advisory',
        'cat_id'   => 'strategy',
        'badge'    => 'PRACTICE 07',
        'image'    => 'assets/img/services/svc-07-agentic-strategy.jpg',
        'lead'     => 'Autonomous operating model design, swarm architecture feasibility, governance policies, and safety validation for agent networks.',
        'metrics'  => ['100% Policy Cover', '5x Operational Velocity', '0 Unsupervised Breaches'],
        'stack'    => ['LangGraph', 'CrewAI', 'OpenTelemetry', 'Python', 'AWS Bedrock'],
    ],
    [
        'slug'     => 'custom-agent-development',
        'title'    => 'Custom AI Agent Development',
        'category' => 'Agentic AI & Swarms',
        'cat_id'   => 'agents',
        'badge'    => 'PRACTICE 08',
        'image'    => 'assets/img/services/svc-08-custom-agents.jpg',
        'lead'     => 'Goal-driven autonomous agents with deterministic state machines, sandboxed tool execution, and self-correcting logic loops.',
        'metrics'  => ['99.9% Task Success', '<2s Cycle Time', '100% Tool Contract Safety'],
        'stack'    => ['LangGraph', 'Python', 'FastAPI', 'Docker Sandbox', 'PostgreSQL'],
    ],
    [
        'slug'     => 'ai-agent-solutions',
        'title'    => 'Enterprise AI Agent Solutions',
        'category' => 'Agentic AI & Swarms',
        'cat_id'   => 'agents',
        'badge'    => 'PRACTICE 09',
        'image'    => 'assets/img/services/svc-09-agent-solutions.jpg',
        'lead'     => 'Turnkey domain-specialized agent suites for automated Sales outreach, Customer Operations, HRMS onboarding, and Financial reconciliation.',
        'metrics'  => ['75% Manual Cut', '24/7 Operations', '10x Pipeline Scalability'],
        'stack'    => ['LangChain', 'CrewAI', 'Celery', 'Redis', 'Kafka'],
    ],
    [
        'slug'     => 'multi-agent-orchestration',
        'title'    => 'Multi-Agent Orchestration',
        'category' => 'Agentic AI & Swarms',
        'cat_id'   => 'agents',
        'badge'    => 'PRACTICE 10',
        'image'    => 'assets/img/services/svc-10-multi-agent-mesh.jpg',
        'lead'     => 'Hierarchical and peer-to-peer agent mesh networks, consensus routing, distributed memory fabrics, and deadlock prevention.',
        'metrics'  => ['100+ Agent Swarms', '0 Circular Deadlocks', '<15ms IPC'],
        'stack'    => ['AutoGen', 'CrewAI', 'LangGraph', 'RabbitMQ', 'Redis Streams'],
    ],
    [
        'slug'     => 'agentic-ai-integration',
        'title'    => 'Agentic AI Integration',
        'category' => 'AI Strategy & Advisory',
        'cat_id'   => 'strategy',
        'badge'    => 'PRACTICE 11',
        'image'    => 'assets/img/services/svc-11-agent-integrations.jpg',
        'lead'     => 'Deep MCP protocol integration, structured tool contracts, and bidirectional integration with Salesforce, SAP, Jira, and Slack.',
        'metrics'  => ['100+ Pre-built Connectors', 'Sub-second Sync', 'Zero Data Leakage'],
        'stack'    => ['Model Context Protocol (MCP)', 'FastAPI', 'GraphQL', 'OAuth2', 'Kafka'],
    ],
    [
        'slug'     => 'ai-integration',
        'title'    => 'Enterprise AI Integration',
        'category' => 'AI Strategy & Advisory',
        'cat_id'   => 'strategy',
        'badge'    => 'PRACTICE 12',
        'image'    => 'assets/img/services/svc-12-ai-integration.jpg',
        'lead'     => 'Zero-downtime sidecar AI integration into legacy monoliths, real-time feature flags, secure API gateways, and private LLM routing.',
        'metrics'  => ['0 Monolith Rewrites', '<10ms Gateway Hop', '99.99% High Availability'],
        'stack'    => ['Envoy', 'FastAPI', 'Redis', 'OpenTelemetry', 'Kubernetes'],
    ],
    [
        'slug'     => 'autonomous-workflow-automation',
        'title'    => 'Autonomous Workflow Automation',
        'category' => 'Agentic AI & Swarms',
        'cat_id'   => 'agents',
        'badge'    => 'PRACTICE 13',
        'image'    => 'assets/img/services/svc-13-workflow-auto.jpg',
        'lead'     => 'End-to-end self-healing business processes, automated document verification, OCR extraction, and multi-tier exception routing.',
        'metrics'  => ['90% Touchless Flow', '99.95% Extraction Accuracy', '6x Throughput'],
        'stack'    => ['Temporal.io', 'LangGraph', 'Tesseract OCR', 'Python', 'PostgreSQL'],
    ],
    [
        'slug'     => 'agent-operations-support',
        'title'    => 'Agent Operations & SRE Support',
        'category' => 'Enterprise Automation',
        'cat_id'   => 'automation',
        'badge'    => 'PRACTICE 14',
        'image'    => 'assets/img/services/svc-14-agent-ops.jpg',
        'lead'     => 'Continuous 24/7 telemetry for agent fleets, automated prompt regression test benches, model drift alerts, and cost guardrails.',
        'metrics'  => ['24/7 SRE Coverage', '<15min Incident SLA', '100% Token Traceability'],
        'stack'    => ['Langfuse', 'Arize Phoenix', 'Prometheus', 'Grafana', 'Sentry'],
    ],
    [
        'slug'     => 'rpa-development',
        'title'    => 'Intelligent RPA Development',
        'category' => 'Enterprise Automation',
        'cat_id'   => 'automation',
        'badge'    => 'PRACTICE 15',
        'image'    => 'assets/img/services/svc-15-intelligent-rpa.jpg',
        'lead'     => 'Vision-augmented robotic process automation bots that interact with legacy desktop UIs, ERP portals, and virtual desktops flawlessly.',
        'metrics'  => ['0 Fragile Selectors', '99.9% Screen OCR', '12x Speedup'],
        'stack'    => ['Playwright', 'Selenium', 'Computer Vision', 'Python', 'UiPath Bridge'],
    ],
    [
        'slug'     => 'hire-agentic-ai-developers',
        'title'    => 'Hire Agentic AI Developers',
        'category' => 'Enterprise Automation',
        'cat_id'   => 'automation',
        'badge'    => 'PRACTICE 16',
        'image'    => 'assets/img/services/svc-16-hire-agentic-developers.jpg',
        'lead'     => 'Dedicated principal AI engineers, LangGraph/Python specialists, and swarm architects vetted for enterprise production and deployed in 48h.',
        'metrics'  => ['48-Hour Deployment', 'Top 1% Senior Talent', 'Guaranteed Timezone Sync'],
        'stack'    => ['Python', 'LangGraph', 'PyTorch', 'CrewAI', 'AWS / Azure Cloud'],
    ],
];

$schema = [
    '@type'           => 'ItemList',
    'name'            => 'Enterprise AI Services offered by iThrive Software',
    'itemListOrder'   => 'https://schema.org/ItemListUnordered',
    'numberOfItems'   => count($allServicesList),
    'itemListElement' => array_map(static fn (array $svc, int $i): array => [
        '@type'    => 'ListItem',
        'position' => $i + 1,
        'name'     => $svc['title'],
        'url'      => canonical('services/' . $svc['slug'] . '.php'),
    ], $allServicesList, array_keys($allServicesList)),
];

$extraHead = '<link rel="stylesheet" href="' . e(asset('assets/css/services-galaxy.css')) . '">' .
             '<link rel="stylesheet" href="' . e(asset('assets/css/service-custom.css')) . '">' .
             '<script type="module" src="' . e(asset('assets/js/framer-galaxy.js')) . '"></script>';

/* The page's ten answers, from includes/content-page-faqs.php. They are
   its longest run of plain prose, which is what an answer engine quotes,
   so they are declared as FAQPage as well as rendered. */
$pageFaqs = PAGE_FAQS['services'] ?? [];
$schemaExtra = array_merge($schemaExtra ?? [], faq_schema($pageFaqs, 'iThrive Software services — frequently asked questions'));

require __DIR__ . '/includes/header.php';
?>

<div class="svc-galaxy-page">
  <!-- 1. Framer 3D Particle Spiral Galaxy Hero -->
  <section class="svc-galaxy-hero">
    <div class="shell" style="text-align: center;">
      <div class="svc-pill-badge" data-reveal>
        <span class="svc-pill-dot"></span>
        <span class="svc-pill-text">ENTERPRISE AGENTIC & GENERATIVE AI INFRASTRUCTURE</span>
      </div>

      <h1 class="svc-hero-title" data-reveal style="--d:1">
        16 Specialized Enterprise AI Engineering Practices
      </h1>

      <p class="svc-hero-lead" data-reveal style="--d:2">
        From custom autonomous agent swarms and hybrid RAG pipelines to fine-tuned foundation models and enterprise AI integrations. Built on Python, LangGraph, and cloud infrastructure, delivered by senior engineers across 5 regional hubs.
      </p>

      <div class="svc-hero-ctas" data-reveal style="--d:3">
        <a class="svc-btn-primary" href="<?= e(url('contact.php')) ?>">
          Talk to an AI Architect <?= icon('arrow') ?>
        </a>
        <a class="svc-btn-secondary" href="#matrix">
          Explore 16 AI Practices
        </a>
        <a class="svc-btn-secondary" href="tel:+919384564915">
          Call: +91 93845 64915
        </a>
      </div>

      <!-- 3D Spiral Galaxy Stage (Three.js) -->
      <div class="svc-galaxy-container" data-reveal style="--d:4">
        <div class="svc-galaxy-stage" id="galaxy-stage">
          <div class="svc-galaxy-hud">
            <span class="svc-galaxy-badge">85k Particle Neural Mesh Engine</span>
            <span style="font-family:'Space Grotesk',sans-serif;font-size:11px;color:#64748B;">Interactive 3D Galaxy Viewport</span>
          </div>
          <div class="svc-galaxy-hint">Drag to rotate 3D galaxy · Real-time auto-orbit</div>
        </div>
      </div>
    </div>
  </section>

  <!-- 2. Services Matrix: All 16 Dedicated Practices -->
  <section class="svc-section" id="matrix">
    <div class="shell">
      <div class="svc-sec-head" data-reveal>
        <span class="svc-eyebrow">COMPREHENSIVE AI CAPABILITIES</span>
        <h2 class="svc-title">16 Enterprise AI Practices Engineered for Production Scale</h2>
        <p class="svc-lead">
          Every practice is delivered with hardened security, deterministic guardrails, zero-hallucination validation, and 100% full source ownership.
        </p>
      </div>

      <div class="svc-matrix-grid">
        <?php foreach ($allServicesList as $i => $svc): ?>
          <a class="svc-matrix-card" href="<?= e(url('services/' . $svc['slug'] . '.php')) ?>" data-reveal style="--d:<?= ($i % 4) + 1 ?>">
            <div class="svc-card-img-wrap">
              <img src="<?= e(asset($svc['image'])) ?>" alt="<?= e($svc['title']) ?>" loading="lazy">
              <span class="svc-card-badge"><?= e($svc['badge']) ?></span>
            </div>
            <div class="svc-card-body">
              <span class="svc-card-group"><?= e($svc['category']) ?></span>
              <h3 class="svc-card-title"><?= e($svc['title']) ?></h3>
              <p class="svc-card-desc"><?= e($svc['lead']) ?></p>

              <div style="display:flex;flex-wrap:wrap;gap:6px;margin:12px 0 16px;">
                <?php foreach ($svc['metrics'] as $metric): ?>
                  <span style="font-family:'Space Grotesk',monospace;font-size:11px;font-weight:600;padding:3px 8px;border-radius:4px;background:rgba(0,242,254,0.08);color:#00F2FE;border:1px solid rgba(0,242,254,0.2);">
                    <?= e($metric) ?>
                  </span>
                <?php endforeach; ?>
              </div>

              <span class="svc-card-link">Explore Architecture & 10 FAQs <?= icon('arrow') ?></span>
            </div>
          </a>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- 3. Enterprise Architecture Blueprint (4 Cards) -->
  <section class="svc-section svc-section--panel">
    <div class="shell">
      <div class="svc-sec-head" data-reveal>
        <span class="svc-eyebrow">SYSTEM BLUEPRINT</span>
        <h2 class="svc-title">Every AI System Drawn Out Before a Single Line is Written</h2>
        <p class="svc-lead">
          We model state machine loops, memory retrieval trees, tool contract sandboxes, and failover boundaries up front to guarantee production SLA.
        </p>
      </div>

      <div class="svc-matrix-grid" style="grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));">
        <div class="svc-matrix-card" data-reveal style="--d:1">
          <div class="svc-card-img-wrap">
            <img src="<?= e(asset('assets/img/services-3d/svc-arch-01-api-gateway.jpg')) ?>" alt="Distributed AI Gateway" loading="lazy">
          </div>
          <div class="svc-card-body">
            <h3 class="svc-card-title" style="font-size:1.15rem;">Distributed Model Gateway</h3>
            <p class="svc-card-desc">Intelligent model routing mesh with semantic caching, token rate limiting, multi-tenant isolation, and cost ceilings.</p>
          </div>
        </div>

        <div class="svc-matrix-card" data-reveal style="--d:2">
          <div class="svc-card-img-wrap">
            <img src="<?= e(asset('assets/img/services-3d/svc-arch-02-streaming.jpg')) ?>" alt="Real-time Event Fabric" loading="lazy">
          </div>
          <div class="svc-card-body">
            <h3 class="svc-card-title" style="font-size:1.15rem;">Event-Driven Agent Fabric</h3>
            <p class="svc-card-desc">Kafka, Celery, and Redis Streams pipelines delivering sub-15ms agent-to-agent inter-process communication.</p>
          </div>
        </div>

        <div class="svc-matrix-card" data-reveal style="--d:3">
          <div class="svc-card-img-wrap">
            <img src="<?= e(asset('assets/img/services-3d/svc-arch-03-security.jpg')) ?>" alt="Zero-Trust AI Vault" loading="lazy">
          </div>
          <div class="svc-card-body">
            <h3 class="svc-card-title" style="font-size:1.15rem;">Zero-Trust Guardrail Vault</h3>
            <p class="svc-card-desc">Schema validation, prompt injection defense, sandboxed code execution, and deterministic fallback circuits.</p>
          </div>
        </div>

        <div class="svc-matrix-card" data-reveal style="--d:4">
          <div class="svc-card-img-wrap">
            <img src="<?= e(asset('assets/img/services-3d/svc-arch-04-observability.jpg')) ?>" alt="OpenTelemetry Observability" loading="lazy">
          </div>
          <div class="svc-card-body">
            <h3 class="svc-card-title" style="font-size:1.15rem;">Nanosecond AI Observability</h3>
            <p class="svc-card-desc">Full trace capture on every prompt, tool call, token count, and latency hop via Langfuse and OpenTelemetry.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- 4. How an Engagement Runs (5 Stages) -->
  <section class="svc-section">
    <div class="shell">
      <div class="svc-sec-head" data-reveal>
        <span class="svc-eyebrow">PROCESS PIPELINE</span>
        <h2 class="svc-title">From AI Audit to Production Deployment in 5 Phases</h2>
        <p class="svc-lead">
          A structured, milestone-gated engineering methodology engineered to de-risk investment and ship enterprise AI fast.
        </p>
      </div>

      <div class="svc-matrix-grid" style="grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));">
        <div class="svc-matrix-card" data-reveal style="--d:1">
          <div class="svc-card-img-wrap">
            <img src="<?= e(asset('assets/img/services-3d/svc-proc-01-discovery.jpg')) ?>" alt="Technical Discovery & AI Audit" loading="lazy">
          </div>
          <div class="svc-card-body">
            <span class="svc-card-group">PHASE 01 · WEEK 1</span>
            <h3 class="svc-card-title" style="font-size:1.1rem;">AI Audit & Discovery</h3>
            <p class="svc-card-desc">Data readiness audit, workflow opportunity scoring, architecture blueprints, and ROI validation.</p>
          </div>
        </div>

        <div class="svc-matrix-card" data-reveal style="--d:2">
          <div class="svc-card-img-wrap">
            <img src="<?= e(asset('assets/img/services-3d/svc-proc-02-prototype.jpg')) ?>" alt="Agent Prototype & Eval Harness" loading="lazy">
          </div>
          <div class="svc-card-body">
            <span class="svc-card-group">PHASE 02 · WEEK 2-3</span>
            <h3 class="svc-card-title" style="font-size:1.1rem;">Prototype & Eval Bench</h3>
            <p class="svc-card-desc">Working proof-of-concept with golden dataset automated evals verifying precision and accuracy.</p>
          </div>
        </div>

        <div class="svc-matrix-card" data-reveal style="--d:3">
          <div class="svc-card-img-wrap">
            <img src="<?= e(asset('assets/img/services-3d/svc-proc-03-sprint.jpg')) ?>" alt="Core Engineering Sprints" loading="lazy">
          </div>
          <div class="svc-card-body">
            <span class="svc-card-group">PHASE 03 · WEEK 4-8</span>
            <h3 class="svc-card-title" style="font-size:1.1rem;">Hardened Engineering</h3>
            <p class="svc-card-desc">Agent state machines, vector database indexing, ERP/CRM tool contracts, and UI integration.</p>
          </div>
        </div>

        <div class="svc-matrix-card" data-reveal style="--d:4">
          <div class="svc-card-img-wrap">
            <img src="<?= e(asset('assets/img/services-3d/svc-proc-04-deployment.jpg')) ?>" alt="Zero-Downtime Deployment" loading="lazy">
          </div>
          <div class="svc-card-body">
            <span class="svc-card-group">PHASE 04 · WEEK 9-10</span>
            <h3 class="svc-card-title" style="font-size:1.1rem;">Zero-Downtime Rollout</h3>
            <p class="svc-card-desc">Shadow mode staging, canary deployment, load stress testing, and seamless cutover.</p>
          </div>
        </div>

        <div class="svc-matrix-card" data-reveal style="--d:5">
          <div class="svc-card-img-wrap">
            <img src="<?= e(asset('assets/img/services-3d/svc-proc-05-telemetry.jpg')) ?>" alt="24/7 Agent Operations" loading="lazy">
          </div>
          <div class="svc-card-body">
            <span class="svc-card-group">PHASE 05 · CONTINUOUS</span>
            <h3 class="svc-card-title" style="font-size:1.1rem;">24/7 Agent SRE</h3>
            <p class="svc-card-desc">Real-time drift telemetry, token budgeting, prompt versioning, and continuous model optimization.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- 5. Commercial Deployment Models -->
  <section class="svc-section svc-section--panel">
    <div class="shell">
      <div class="svc-sec-head" data-reveal>
        <span class="svc-eyebrow">COMMERCIAL FRAMEWORKS</span>
        <h2 class="svc-title">Flexible Engagement Models to Match Your Roadmap</h2>
        <p class="svc-lead">
          From turnkey fixed-scope agent systems to dedicated AI squads and on-demand principal advisory.
        </p>
      </div>

      <div class="svc-matrix-grid" style="grid-template-columns: repeat(auto-fit, minmax(340px, 1fr));">
        <div class="svc-matrix-card" data-reveal style="--d:1">
          <div class="svc-card-img-wrap">
            <img src="<?= e(asset('assets/img/services-3d/svc-eng-01-fixed.jpg')) ?>" alt="Fixed-Scope Turnkey AI Systems" loading="lazy">
          </div>
          <div class="svc-card-body">
            <h3 class="svc-card-title">Turnkey Fixed-Scope Projects</h3>
            <p class="svc-card-desc">Guaranteed delivery dates, deterministic milestone pricing, and complete IP handover for MVPs, RAG pipelines, and agent suites.</p>
          </div>
        </div>

        <div class="svc-matrix-card" data-reveal style="--d:2">
          <div class="svc-card-img-wrap">
            <img src="<?= e(asset('assets/img/services-3d/svc-eng-02-squad.jpg')) ?>" alt="Dedicated AI Engineering Squad" loading="lazy">
          </div>
          <div class="svc-card-body">
            <h3 class="svc-card-title">Dedicated AI Squads</h3>
            <p class="svc-card-desc">An integrated team of senior AI engineers, Python developers, and tech leads embedded directly into your rituals and backlog.</p>
          </div>
        </div>

        <div class="svc-matrix-card" data-reveal style="--d:3">
          <div class="svc-card-img-wrap">
            <img src="<?= e(asset('assets/img/services-3d/svc-eng-03-advisory.jpg')) ?>" alt="Principal AI Advisory" loading="lazy">
          </div>
          <div class="svc-card-body">
            <h3 class="svc-card-title">Principal AI Advisory</h3>
            <p class="svc-card-desc">On-demand access to principal AI architects for high-stakes design reviews, GPU cluster optimization, and model safety audits.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- 6. Production Proof & Case Studies -->
  <section class="svc-section">
    <div class="shell">
      <div class="svc-sec-head" data-reveal>
        <span class="svc-eyebrow">ENTERPRISE PROOF</span>
        <h2 class="svc-title">Built and Running at Scale Across Global Enterprises</h2>
        <p class="svc-lead">
          Real agentic workflows and AI platforms processing millions of transactions and tokens every day.
        </p>
      </div>

      <div class="svc-matrix-grid" style="grid-template-columns: repeat(auto-fit, minmax(340px, 1fr));">
        <div class="svc-matrix-card" data-reveal style="--d:1">
          <div class="svc-card-img-wrap">
            <img src="<?= e(asset('assets/img/services-3d/svc-case-01-fintech.jpg')) ?>" alt="Lotus Eye Hospital Healthcare AI" loading="lazy">
          </div>
          <div class="svc-card-body">
            <h3 class="svc-card-title">Lotus Eye Hospital — Agentic Healthcare</h3>
            <p class="svc-card-desc">Multi-agent clinical triage, automated diagnostic report summarization, and EMR EHR integration handling 100k+ patients.</p>
          </div>
        </div>

        <div class="svc-matrix-card" data-reveal style="--d:2">
          <div class="svc-card-img-wrap">
            <img src="<?= e(asset('assets/img/services-3d/svc-case-02-telecom.jpg')) ?>" alt="Mehala Carona Enterprise AI ERP" loading="lazy">
          </div>
          <div class="svc-card-body">
            <h3 class="svc-card-title">Mehala Carona — Enterprise AI ERP</h3>
            <p class="svc-card-desc">Autonomous inventory forecasting, invoice OCR reconciliation, and supplier multi-agent communication network.</p>
          </div>
        </div>

        <div class="svc-matrix-card" data-reveal style="--d:3">
          <div class="svc-card-img-wrap">
            <img src="<?= e(asset('assets/img/services-3d/svc-case-03-logistics.jpg')) ?>" alt="Tada AI Ride-Hailing Mesh" loading="lazy">
          </div>
          <div class="svc-card-body">
            <h3 class="svc-card-title">Tada — AI Ride-Hailing Mesh</h3>
            <p class="svc-card-desc">Sub-second dynamic pricing algorithms, route optimization, and autonomous dispatch processing 50k+ daily rides.</p>
          </div>
        </div>
      </div>

      <div class="section-foot" data-reveal style="text-align: center; margin-top: 40px;">
        <a class="btn btn-ghost" href="<?= e(url('case-studies.php')) ?>">All Case Studies <?= icon('arrow') ?></a>
      </div>
    </div>
  </section>

  <!-- 7. Call to Action -->
  <?php
  component('faq-section', [
      'faqs'    => $pageFaqs,
      'eyebrow' => 'Questions',
      'title'   => 'Choosing the right service',
      'lead'    => 'Which one you need, when you do not need AI at all, and how we price.',
  ]);

  component('cta', ['cta' => [
      'eyebrow'   => 'Start Your AI Transformation',
      'title'     => 'Bring us the complex AI workflow nobody wants to own.',
      'body'      => 'Tell us where manual operational friction is costing your business money. Call +91 93845 64915 or write to info@ithrivesoftware.com.',
      'primary'   => ['label' => 'Start Your AI Project', 'href' => 'contact.php'],
      'secondary' => ['label' => 'Call: +91 93845 64915', 'href' => 'tel:+919384564915'],
  ]]);
  ?>
</div>

<?php
require __DIR__ . '/includes/footer.php';