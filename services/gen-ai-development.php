<?php
/**
 * Generative AI Development & Custom Foundation Model Services
 *
 * Enterprise AI Service Page engineered with modern dark cyber UI,
 * 6 Core Capabilities, 5 Strategic ROI Advantages, 5-Step Process Roadmap,
 * 3 Deployment Frameworks, Tech Stack Arena, and 10 Detailed FAQs with Schema.org JSON-LD.
 */

declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/config.php';

$page         = 'services';
$pageTitle    = 'Generative AI Development Services';
$pageDesc     = 'Custom generative AI built for enterprise scale: LoRA and QLoRA domain fine-tuning, multimodal generation, synthetic data and private foundation models.';
$ogImage      = 'assets/img/services/svc-02-gen-ai-dev.jpg';

/* ---------------------------------------------------------------------------
 * Content Definitions
 * ------------------------------------------------------------------------ */

$stats = [['<50ms', 'Token Generation Latency'], ['99.7%', 'JSON Schema Accuracy'], ['85%', 'Inference Cost Reduction'], ['100%', 'Private VPC Isolation']];

$disciplines = [['01', 'Domain-Specific LLM Fine-Tuning', 'Custom adaptation of open foundation models (Llama, Mistral, Qwen, DeepSeek) using LoRA, QLoRA, and full-weight parameter tuning on domain datasets.'], ['02', 'Multimodal Diffusion & Vision-Language Models', 'Developing custom vision-language models and image/audio generation pipelines for automated design, medical scanning, and product rendering.'], ['03', 'High-Throughput Inference Optimization', 'Deploying vLLM, TensorRT-LLM, and Triton inference servers with continuous batching, FlashAttention-2, and dynamic quantization (FP8, INT4).'], ['04', 'Synthetic Data Generation & Data Augmentation', 'Creating statistically validated, privacy-preserving synthetic training datasets to bootstrap specialized models without compromising PII.'], ['05', 'Deterministic Guardrails & Output Validation', 'Enforcing strict Pydantic JSON schema constraints, regex grammar masks, and semantic safety filters to guarantee 100% structured model responses.'], ['06', 'Private Cloud & On-Premise VPC Deployment', 'Full air-gapped deployment inside your AWS, Azure, GCP VPCs or on-premise Kubernetes GPU clusters with zero external model dependencies.']];

$benefits = [['01', 'Superior Domain Accuracy', 'Fine-tuned models outperform generic frontier models on your specific company terminology, legal clauses, and technical schemas.'], ['02', 'Massive Cost Efficiency', 'Self-hosted distilled models reduce token costs by up to 85% compared to commercial API pay-per-token models at enterprise scale.'], ['03', 'Sub-50ms Low-Latency Inference', 'Optimized inference engines deliver ultra-fast streaming responses critical for real-time customer experiences and automated pipelines.'], ['04', 'Zero Data Leakage & Total IP Control', 'Your training data, model weights, and inference prompts remain 100% proprietary inside your private VPC perimeter.'], ['05', 'Customizable Output Formatting', 'Guarantee perfect structured JSON outputs that plug directly into downstream relational databases and software services without parsing errors.']];

$steps = [['01', 'Data Curation & Alignment', 'Extracting, deduplicating, tokenizing, and formatting private enterprise datasets into high-quality instruction-tuning pairs.'], ['02', 'Baseline Evaluation & Benchmarking', 'Establishing rigorous evaluation metrics (BLEU, ROUGE, BERTScore, human evals) against existing models.'], ['03', 'LoRA & Instruction Fine-Tuning', 'Executing distributed multi-GPU training runs with hyperparameter optimization and loss curve convergence monitoring.'], ['04', 'Quantization & Inference Serving', 'Compiling fine-tuned weights to FP8/INT4 using TensorRT-LLM and benchmarking throughput under peak concurrent load.'], ['05', 'Production Deployment & Continuous MLOps', 'Rolling out to Kubernetes GPU nodes with automated drift monitoring, canary routing, and scheduled retraining pipelines.']];

$models = [['01', 'Proof of Concept Model Tuning', 'A 3-week sprint fine-tuning a specialized SLM on your dataset, demonstrating measurable accuracy uplift and latency benchmarks.', ['Dataset formatting & curation', 'LoRA fine-tuning run', 'Comparative benchmark report']], ['02', 'Production Model & API Pipeline', 'Full engineering of fine-tuned weights, TensorRT inference cluster, schema guardrails, and secure API microservice.', ['Multi-GPU training cluster', 'Sub-50ms inference setup', 'Pydantic schema validation']], ['03', 'Enterprise GenAI Platform', 'End-to-end generative AI ecosystem with custom multimodal models, automated synthetic data pipelines, and private VPC deployment.', ['Private VPC Kubernetes hosting', 'Automated retraining CI/CD', '24/7 dedicated MLOps support']]];

$techStack = ['PyTorch', 'Hugging Face', 'vLLM', 'TensorRT-LLM', 'Triton Inference Server', 'LangChain', 'DeepSpeed', 'Kubernetes', 'NVIDIA GPUs'];

$pageStack = [
    ['slug' => 'models', 'title' => 'Models & Frameworks', 'icon' => 'brain',
     'blurb' => 'What the generation runs on, and the harness around it.',
     'items' => [
         ['name' => 'PyTorch', 'logo' => 'pytorch'],
         ['name' => 'OpenAI', 'logo' => 'openai'],
         ['name' => 'Anthropic', 'logo' => 'anthropic'],
         ['name' => 'TensorFlow', 'logo' => 'tensorflow'],
         ['name' => 'LangChain', 'logo' => 'langchain'],
         ['name' => 'Python', 'logo' => 'python'],
     ]],
    ['slug' => 'data', 'title' => 'Grounding & Data', 'icon' => 'database',
     'blurb' => 'The corpus a generated answer is checked against.',
     'items' => [
         ['name' => 'PostgreSQL', 'logo' => 'postgresql'],
         ['name' => 'OpenSearch', 'logo' => 'opensearch'],
         ['name' => 'Redis', 'logo' => 'redis'],
         ['name' => 'pandas', 'logo' => 'pandas'],
     ]],
    ['slug' => 'platform', 'title' => 'Platform & Operations', 'icon' => 'cloud',
     'blurb' => 'Where it runs and what proves it still works.',
     'items' => [
         ['name' => 'Docker', 'logo' => 'docker'],
         ['name' => 'Kubernetes', 'logo' => 'kubernetes'],
         ['name' => 'AWS', 'logo' => 'amazonwebservices'],
         ['name' => 'Grafana', 'logo' => 'grafana'],
     ]],
];

$faqs = [['What is the difference between Generative AI fine-tuning and RAG?', 'RAG (Retrieval-Augmented Generation) injects dynamic contextual documents into a generic model prompt at runtime, while Fine-Tuning fundamentally modifies the model weights so it learns domain vocabulary, tone, and complex reasoning patterns directly. We frequently combine both: a fine-tuned domain model querying an enterprise vector database.'], ['How do you prevent hallucinations in Generative AI applications?', 'We implement multi-layered safeguards: temperature minimization, schema-constrained decoding (e.g., Guidance, Outlines), citation-enforced retrieval, and secondary validator models that verify all factual assertions before delivering output.'], ['Can you deploy Generative AI models inside our private cloud or on-premise servers?', 'Yes. 100% of our enterprise Generative AI deployments can be hosted inside your private AWS, Azure, GCP VPCs or on-premise air-gapped GPU servers (using Kubernetes and vLLM/TensorRT) with zero outbound internet connectivity.'], ['How much training data is required to fine-tune a domain model?', 'With parameter-efficient fine-tuning (LoRA/QLoRA), high-quality domain adaptation can be achieved with as few as 1,000 to 10,000 meticulously formatted instruction pairs. We also synthesize high-quality training data from your raw historical documents.'], ['What hardware and GPU infrastructure is required to run self-hosted models?', 'Quantized 7B to 14B parameter models run with ultra-low latency on single commercial GPUs (e.g., NVIDIA L4, A10G, or RTX 4090), while 70B parameter models require multi-GPU nodes (such as 2x to 4x NVIDIA A100/H100). We right-size the architecture to minimize cloud bills.'], ['How do fine-tuned models compare to GPT-4 in performance?', 'On generalized open-ended knowledge, frontier models excel; however, on specific enterprise tasks (such as medical diagnosis coding, financial ledger classification, or proprietary code syntax), a tailored 8B or 70B model routinely matches or exceeds GPT-4 while running at 85% lower cost.'], ['What multimodal capabilities can you build into Generative AI systems?', 'We build systems capable of processing and generating text, high-resolution imagery, audio voice streams, tabular financial data, and complex PDF blueprints in unified cognitive workflows.'], ['How do you handle data privacy and copyright considerations?', 'All models are trained exclusively on your licensed enterprise data and permissible open-source foundation weights. Your corporate IP remains strictly yours, with full legal and copyright indemnification frameworks.'], ['What is the average timeline to build and deploy a custom Generative AI solution?', 'A focused Proof of Concept is delivered in 2 to 3 weeks, while a full-scale enterprise production platform typically ships in 6 to 10 weeks.'], ['Do you provide continuous monitoring and model retraining?', 'Yes. Our AgentOps and MLOps telemetry infrastructure monitors prompt drift, latency anomalies, token costs, and user feedback in real-time, triggering automated retraining pipelines as new data is ingested.']];

/** Schema.org Structured Data with FAQPage & Service */
$schema = [
    '@context' => 'https://schema.org',
    '@graph' => [
        [
            '@type' => 'Service',
            'name' => 'Generative AI Development & Custom Foundation Model Services',
            'serviceType' => 'AI-First Product Development',
            'description' => 'Custom GenAI solutions engineered for enterprise scale: LoRA/QLoRA domain fine-tuning, multimodal diffusion, synthetic data generation, and private foundation models.',
            'url' => canonical('services/gen-ai-development.php'),
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

$extraHead = '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>'
    . '<link rel="stylesheet" href="https://fonts.googleapis.com/css2?'
    . 'family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;600;700'
    . '&family=Space+Grotesk:wght@500;600;700;800&display=swap">'
    . '<link rel="stylesheet" href="' . e(asset('assets/css/service-custom.css')) . '">'
    . '<link rel="stylesheet" href="' . e(asset('assets/css/svc-theme.css')) . '">';
$GLOBALS['ithrive_needs_svc3d'] = true;

require dirname(__DIR__) . '/includes/header.php';
?>

<div class="svc-page" data-theme="generative">

  <!-- =========================================================================
       HERO SECTION: Cyber Eyebrow, Gradient Headline & Action CTAs
       ========================================================================= -->
  <section class="svc-hero">
    <div class="svc-shell svc-hero-inner">
      <p class="svc-eyebrow"><span class="svc-pulse" aria-hidden="true"></span>Generative AI Engineering ? Private Cloud & VPC</p>

      <h1 class="svc-h1">
        Generative AI Development For<br><em>Proprietary Enterprise Intelligence</em>
      </h1>

      <p class="svc-lead">
        Custom GenAI solutions engineered for scale: LoRA/QLoRA domain fine-tuning, multimodal image/audio diffusion, synthetic data generation, and private foundation models.
      </p>

      <div class="svc-actions svc-actions--mid">
        <button class="svc-btn svc-btn--primary" type="button"
                data-modal-open data-modal-service="Generative AI Development & Custom Foundation Model Services">
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
        <img src="<?= e(asset('assets/img/services/svc-02-gen-ai-dev.jpg')) ?>" width="1200" height="700"
             alt="Generative AI Development & Custom Foundation Model Services Architecture" fetchpriority="high" decoding="async">
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
          <h2 class="svc-title">Generic foundation models are a commodity;<br><em>domain intelligence is your moat</em></h2>
        </div>
        <div class="svc-open-copy">
          <p>Off-the-shelf commercial LLMs lack understanding of your private industry taxonomy, proprietary product catalogs, internal data schemas, and complex business logic. Relying exclusively on raw public APIs leaves your intellectual property vulnerable and incurs soaring token bills at scale.</p>
          <p>We architect bespoke Generative AI platforms fine-tuned on your private enterprise data. Using parameter-efficient fine-tuning (PEFT), LoRA adapters, model distillation, and low-latency inference runtimes (vLLM, TensorRT-LLM), we deliver superior domain accuracy with complete data sovereignty.</p>
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
        <h2 class="svc-title">Six specialized Generative AI disciplines<br>built for <em>production throughput</em></h2>
        <p class="svc-sub">Engineered from raw tensor operations to distributed inference clusters.</p>
      </div>

      <?php /* The 6 images for this section, shown in depth rather than as
               card corners. Falls back to a plain grid of the same images if the
               island never mounts -- see includes/components/svc-gallery.php. */ ?>
      <?php component('svc-gallery', [
          'images'  => array_filter([svc_img('02', 3, 1), svc_img('02', 3, 2), svc_img('02', 3, 3), svc_img('02', 3, 4), svc_img('02', 3, 5), svc_img('02', 3, 6)]),
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
                data-modal-open data-modal-service="Generative AI Development & Custom Foundation Model Services">
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
        <h2 class="svc-title">Five strategic business advantages<br>of our <em>Gen Ai Development</em></h2>
        <p class="svc-sub">
          Explore the architectural advantages that guarantee high concurrency, zero data leakage, and rapid payback timelines.
        </p>
      </div>

      <?php /* The 5 images for this section, shown in depth rather than as
               card corners. Falls back to a plain grid of the same images if the
               island never mounts -- see includes/components/svc-gallery.php. */ ?>
      <?php component('svc-gallery', [
          'images'  => array_filter([svc_img('02', 5, 1), svc_img('02', 5, 2), svc_img('02', 5, 3), svc_img('02', 5, 4), svc_img('02', 5, 5)]),
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
      <div class="svc-roadmap" data-roadmap="converge" aria-hidden="true">
        <?php foreach ($steps as $idx => [$num, $sTitle]): ?>
          <span data-roadmap-node="<?= $idx ?>" data-label="<?= e($sTitle) ?>"></span>
        <?php endforeach; ?>
      </div>
      <?php /* The 3 images for this section, shown in depth rather than as
               card corners. Falls back to a plain grid of the same images if the
               island never mounts -- see includes/components/svc-gallery.php. */ ?>
      <?php component('svc-gallery', [
          'images'  => array_filter([svc_img('02', 6, 1), svc_img('02', 6, 2), svc_img('02', 6, 3)]),
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
        <h2 class="svc-title">Three ways to engage our<br><em>Gen Ai Development Practice</em></h2>
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
                    data-modal-open data-modal-service="Generative AI Development & Custom Foundation Model Services (Model <?= e($num) ?>)">
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
            <img src="<?= e(asset('assets/img/services/svc-02-gen-ai-dev.jpg')) ?>" width="900" height="700"
                 alt="Generative AI Development & Custom Foundation Model Services FAQ Consultation" loading="lazy" decoding="async">
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
      <h2>Ready to build or scale your<br><em>Gen Ai Development System?</em></h2>
      <p class="svc-close-lead">
        Discuss your technical requirements, latency constraints, and data governance policies directly with our Lead AI Systems Architects. Receive an actionable feasibility audit and prototype blueprint within 48 hours.
      </p>
      <div class="svc-actions svc-actions--mid">
        <button class="svc-btn svc-btn--primary" type="button"
                data-modal-open data-modal-service="Generative AI Development & Custom Foundation Model Services">
          Start 48-Hour Technical Discovery<?= icon('arrow') ?>
        </button>
      </div>
    </div>
  </section>

</div>

<?php
require dirname(__DIR__) . '/includes/footer.php';
