<?php
/**
 * Computer Vision Development & Edge AI Vision Systems
 *
 * Enterprise AI Service Page engineered with modern dark cyber UI,
 * 6 Core Capabilities, 5 Strategic ROI Advantages, 5-Step Process Roadmap,
 * 3 Deployment Frameworks, Tech Stack Arena, and 10 Detailed FAQs with Schema.org JSON-LD.
 */

declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/config.php';

$page         = 'services';
$pageTitle    = 'Computer Vision Development & Edge AI Vision Systems';
$pageDesc     = 'Real-time edge & cloud computer vision: sub-10ms defect detection, autonomous OCR, spatial intelligence, biometric authentication, and multi-camera video analytics.';
$ogImage      = 'assets/img/services/svc-06-computer-vision.jpg';

/* ---------------------------------------------------------------------------
 * Content Definitions
 * ------------------------------------------------------------------------ */

$stats = [['99.8%', 'Visual Defect Precision'], ['<10ms', 'Edge Camera Inference Latency'], ['100+', 'Production Vision Pipelines'], ['30 FPS', 'Real-Time 4K Video Analytics']];

$disciplines = [['01', 'Manufacturing Defect & Quality Inspection', 'Real-time surface anomaly detection, micro-crack identification, and component assembly verification at production line speeds exceeding 1,000 items per minute.'], ['02', 'Multi-Camera Tracking & Spatial Intelligence', 'Cross-camera re-identification, real-time footfall heatmaps, queue dwell analysis, and spatial asset tracking in retail, warehouses, and smart cities.'], ['03', 'Autonomous Document OCR & Table Extraction', 'Multimodal OCR for handwritten invoices, medical prescriptions, shipping manifests, and passports with structured JSON extraction and database sync.'], ['04', 'Edge AI & Embedded Neural Deployment', 'Model quantization (INT8/FP16), TensorRT optimization, and containerized deployment on NVIDIA Jetson, Raspberry Pi, and industrial edge gateways.'], ['05', 'Biometric Authentication & Anti-Spoofing', '3D liveness detection, facial recognition, and emotion analytics engineered for frictionless KYC verification and high-security access control.'], ['06', 'Vision-Language Models (VLM) & Visual Q&A', 'Integrating multimodal models (GPT-4o Vision, Gemini Flash, PaliGemma) for natural language reasoning over images, video feeds, and technical schematics.']];

$benefits = [['01', '99.8%+ Flawless Quality Assurance', 'Eliminate defective product shipments with automated sub-millimeter visual precision.'], ['02', 'Sub-10ms Ultra-Low Latency Inference', 'Optimized TensorRT models execute instantly on edge cameras without requiring cloud round-trips.'], ['03', '80% Reduction in Visual Labor Costs', 'Automate repetitive manual scanning, counting, sorting, and document transcription 24/7.'], ['04', 'Extreme Ruggedized Edge Reliability', 'Edge systems operate continuously in offline environments, intermittent network areas, and harsh factory conditions.'], ['05', 'Actionable Real-Time Operational Alerts', 'Instant push alerts, automated conveyor halts, and ERP webhook triggers the millisecond an anomaly is detected.']];

$steps = [['01', 'Visual Dataset Curation & Labelling', 'Collecting, augmenting, and annotating high-resolution image/video datasets with bounding boxes, segmentation masks, and keypoints.'], ['02', 'Custom Model Training & Transfer Learning', 'Training and fine-tuning YOLOv10, Segment Anything (SAM), Mask R-CNN, and custom CNN/Transformer backbones.'], ['03', 'TensorRT & Hardware Quantization', 'Optimizing models with INT8 quantization, graph pruning, and kernel tuning for target edge GPUs and neural processing units.'], ['04', 'Factory Floor & Camera Pilot', 'Deploying and testing vision pipelines in live production environments, calibrating lighting variations and camera angles.'], ['05', 'Cloud Telemetry & Fleet Management', 'Deploying edge container updates over-the-air (OTA), real-time health monitoring, and active learning retraining loops.']];

$models = [['01', 'Edge Vision Proof of Concept', 'A 4-week on-site or lab pilot delivering a custom vision model benchmarked on your specific hardware and defect samples.', ['4-week sprint', 'Custom dataset annotation', 'Edge benchmark report']], ['02', 'Industrial Production Vision System', 'End-to-end multi-camera vision pipeline integrated with your PLC controllers, conveyor belts, and ERP systems.', ['Full edge + cloud deployment', 'Sub-15ms inference SLA', 'Automated alert dashboard']], ['03', 'Enterprise Vision AI Retainer', 'Continuous dataset collection, model retraining, OTA edge firmware updates, and 24/7 vision cluster monitoring.', ['Continuous active learning', 'Fleet OTA management', 'Dedicated computer vision engineer']]];

$techStack = ['YOLOv10', 'TensorRT', 'OpenCV', 'PyTorch', 'DeepStream', 'NVIDIA Jetson', 'ONNX', 'Segment Anything', 'PaddleOCR', 'Docker'];

$pageStack = [
    ['slug' => 'vision', 'title' => 'Vision & Training', 'icon' => 'search',
     'blurb' => 'Detection, classification and the training loop behind them.',
     'items' => [
         ['name' => 'PyTorch', 'logo' => 'pytorch'],
         ['name' => 'TensorFlow', 'logo' => 'tensorflow'],
         ['name' => 'scikit-learn', 'logo' => 'scikitlearn'],
         ['name' => 'Python', 'logo' => 'python'],
     ]],
    ['slug' => 'data', 'title' => 'Data & Labelling', 'icon' => 'database',
     'blurb' => 'The labelled set, drawn from your own cameras.',
     'items' => [
         ['name' => 'pandas', 'logo' => 'pandas'],
         ['name' => 'PostgreSQL', 'logo' => 'postgresql'],
         ['name' => 'OpenSearch', 'logo' => 'opensearch'],
         ['name' => 'Redis', 'logo' => 'redis'],
     ]],
    ['slug' => 'platform', 'title' => 'Edge & Operations', 'icon' => 'cloud',
     'blurb' => 'Inference next to the camera, monitored centrally.',
     'items' => [
         ['name' => 'Docker', 'logo' => 'docker'],
         ['name' => 'Kubernetes', 'logo' => 'kubernetes'],
         ['name' => 'Google Cloud', 'logo' => 'googlecloud'],
         ['name' => 'Grafana', 'logo' => 'grafana'],
     ]],
];

$faqs = [['What hardware do you support for edge computer vision deployment?', 'We support NVIDIA Jetson (Nano, Orin Nano, Xavier, AGX Orin), Intel OpenVINO x86/ARM processors, Google Coral TPUs, Hailo AI processors, and industrial smart cameras with embedded NPUs.'], ['Can your computer vision models run completely offline without internet?', 'Yes. Our edge vision pipelines run 100% locally on on-premise hardware, processing video streams and triggering PLC relays in real time without transmitting data outside your facility.'], ['How many frames per second (FPS) can your vision models achieve?', 'Depending on the model architecture and target hardware, our TensorRT-optimized models achieve between 30 FPS to 120+ FPS on 1080p/4K streams, maintaining sub-10ms per-frame latency.'], ['How do you handle lighting fluctuations and dusty environments in factories?', 'We incorporate synthetic data augmentation (simulating shadows, dust, lens blur, and variable Lux levels) and auto-calibrating camera exposures during preprocessing to ensure 99.8% precision under variable physical conditions.'], ['How do you extract data from complex tables and handwritten forms?', 'We use layout-aware multimodal OCR pipelines (combining YOLO for table detection with PaddleOCR and Vision-Language Models) to extract tabular structures and handwriting directly into structured JSON.'], ['How do you prevent biometric spoofing in facial recognition systems?', 'We integrate active and passive 3D liveness detection (analyzing micro-textures, depth maps, and infrared reflections) to defeat printed photo, video replay, and 3D silicone mask spoofing attacks.'], ['Can your models detect small micro-defects on fast-moving assembly lines?', 'Yes. We use high-resolution patch-based defect segmentation models and high-speed industrial global-shutter cameras to detect defects as small as 0.05mm at conveyor speeds.'], ['How do you train vision models when defect sample data is extremely rare?', 'We utilize advanced generative diffusion models (ControlNet, GANs) to synthesize realistic defect variations, and deploy few-shot anomaly detection models (such as PatchCore) that learn from normal samples.'], ['Can computer vision integrate directly with our PLC or SCADA systems?', 'Yes. Our edge gateways communicate directly with PLCs via Modbus, OPC-UA, MQTT, and digital I/O pins to trigger immediate mechanical rejections or line halts.'], ['What is the typical development timeline for a custom computer vision solution?', 'A custom proof of concept takes 3 to 4 weeks. Full industrial integration and edge fleet deployment typically require 6 to 10 weeks depending on camera integration complexity.']];

/** Schema.org Structured Data with FAQPage & Service */
$schema = [
    '@context' => 'https://schema.org',
    '@graph' => [
        [
            '@type' => 'Service',
            'name' => 'Computer Vision Development & Edge AI Vision Systems',
            'serviceType' => 'AI-First Product Development',
            'description' => 'Real-time edge & cloud computer vision: sub-10ms defect detection, autonomous OCR, spatial intelligence, biometric authentication, and multi-camera video analytics.',
            'url' => canonical('services/computer-vision-development.php'),
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

<div class="svc-page" data-theme="optical">

  <!-- =========================================================================
       HERO SECTION: Cyber Eyebrow, Gradient Headline & Action CTAs
       ========================================================================= -->
  <section class="svc-hero">
    <div class="svc-shell svc-hero-inner">
      <p class="svc-eyebrow"><span class="svc-pulse" aria-hidden="true"></span>Edge & Cloud Vision AI · Sub-10ms Inference</p>

      <h1 class="svc-h1">
        Computer Vision Development For<br><em>Real-Time Visual Intelligence</em>
      </h1>

      <p class="svc-lead">
        Real-time edge & cloud computer vision: sub-10ms defect detection, autonomous OCR, spatial intelligence, biometric authentication, and multi-camera video analytics.
      </p>

      <div class="svc-actions svc-actions--mid">
        <button class="svc-btn svc-btn--primary" type="button"
                data-modal-open data-modal-service="Computer Vision Development & Edge AI Vision Systems">
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
        <img src="<?= e(asset('assets/img/services/svc-06-computer-vision.jpg')) ?>" width="1200" height="700"
             alt="Computer Vision Development & Edge AI Vision Systems Architecture" fetchpriority="high" decoding="async">
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
          <h2 class="svc-title">Manual visual inspection is slow and error-prone;<br><em>edge AI vision operates at lightspeed</em></h2>
        </div>
        <div class="svc-open-copy">
          <p>Industrial inspection, logistics tracking, automated surveillance, and document verification suffer when dependent on manual human review. Eye fatigue, inconsistent grading, and high operational costs lead to defective shipments, security oversights, and delayed processing.</p>
          <p>We build high-performance Computer Vision systems engineered for edge devices (NVIDIA Jetson, Intel OpenVINO) and distributed cloud clusters. From sub-10ms manufacturing quality inspection to multi-camera spatial tracking and automated document OCR, our models deliver flawless visual comprehension at 30+ FPS.</p>
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
        <h2 class="svc-title">Six computer vision disciplines<br>transforming <em>physical operations</em></h2>
        <p class="svc-sub">From industrial automated inspection to multimodal visual language models.</p>
      </div>

      <?php /* The 6 images for this section, shown in depth rather than as
               card corners. Falls back to a plain grid of the same images if the
               island never mounts -- see includes/components/svc-gallery.php. */ ?>
      <?php component('svc-gallery', [
          'images'  => array_filter([svc_img('06', 3, 1), svc_img('06', 3, 2), svc_img('06', 3, 3), svc_img('06', 3, 4), svc_img('06', 3, 5), svc_img('06', 3, 6)]),
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
                data-modal-open data-modal-service="Computer Vision Development & Edge AI Vision Systems">
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
        <h2 class="svc-title">Five strategic business advantages<br>of our <em>Computer Vision Development</em></h2>
        <p class="svc-sub">
          Explore the architectural advantages that guarantee high concurrency, zero data leakage, and rapid payback timelines.
        </p>
      </div>

      <?php /* The 5 images for this section, shown in depth rather than as
               card corners. Falls back to a plain grid of the same images if the
               island never mounts -- see includes/components/svc-gallery.php. */ ?>
      <?php component('svc-gallery', [
          'images'  => array_filter([svc_img('06', 5, 1), svc_img('06', 5, 2), svc_img('06', 5, 3), svc_img('06', 5, 4), svc_img('06', 5, 5)]),
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
      <div class="svc-roadmap" data-roadmap="scan" aria-hidden="true">
        <?php foreach ($steps as $idx => [$num, $sTitle]): ?>
          <span data-roadmap-node="<?= $idx ?>" data-label="<?= e($sTitle) ?>"></span>
        <?php endforeach; ?>
      </div>
      <?php /* The 3 images for this section, shown in depth rather than as
               card corners. Falls back to a plain grid of the same images if the
               island never mounts -- see includes/components/svc-gallery.php. */ ?>
      <?php component('svc-gallery', [
          'images'  => array_filter([svc_img('06', 6, 1), svc_img('06', 6, 2), svc_img('06', 6, 3)]),
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
        <h2 class="svc-title">Three ways to engage our<br><em>Computer Vision Development Practice</em></h2>
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
                    data-modal-open data-modal-service="Computer Vision Development & Edge AI Vision Systems (Model <?= e($num) ?>)">
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
            <img src="<?= e(asset('assets/img/services/svc-06-computer-vision.jpg')) ?>" width="900" height="700"
                 alt="Computer Vision Development & Edge AI Vision Systems FAQ Consultation" loading="lazy" decoding="async">
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
      <h2>Ready to build or scale your<br><em>Computer Vision Development System?</em></h2>
      <p class="svc-close-lead">
        Discuss your technical requirements, latency constraints, and data governance policies directly with our Lead AI Systems Architects. Receive an actionable feasibility audit and prototype blueprint within 48 hours.
      </p>
      <div class="svc-actions svc-actions--mid">
        <button class="svc-btn svc-btn--primary" type="button"
                data-modal-open data-modal-service="Computer Vision Development & Edge AI Vision Systems">
          Start 48-Hour Technical Discovery<?= icon('arrow') ?>
        </button>
      </div>
    </div>
  </section>

</div>

<?php
require dirname(__DIR__) . '/includes/footer.php';
