<?php
/**
 * Enterprise RAG Development & Contextual Vector Retrieval Services
 *
 * Enterprise AI Service Page engineered with modern dark cyber UI,
 * 6 Core Capabilities, 5 Strategic ROI Advantages, 5-Step Process Roadmap,
 * 3 Deployment Frameworks, Tech Stack Arena, and 10 Detailed FAQs with Schema.org JSON-LD.
 */

declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/config.php';

$page         = 'services';
$pageTitle    = 'Enterprise RAG Development & Contextual Vector Retrieval Services';
$pageDesc     = 'Production-grade GraphRAG, hybrid dense-sparse vector search, self-corrective retrieval, and dynamic chunking architectures for zero-hallucination enterprise intelligence.';
$ogImage      = 'assets/img/services/svc-05-rag-dev.jpg';

/* ---------------------------------------------------------------------------
 * Content Definitions
 * ------------------------------------------------------------------------ */

$stats = [['99.4%', 'Retrieval Precision Rate'], ['<50ms', 'Hybrid Vector Search Latency'], ['100M+', 'Documents Indexed & Queried'], ['0%', 'Public Training Data Leakage']];

$disciplines = [['01', 'GraphRAG & Knowledge Graph Synthesis', 'Constructing automated entity-relationship graphs on top of vector indices to enable multi-hop reasoning across thousands of interconnected enterprise documents.'], ['02', 'Hybrid Dense & Sparse Search (BM25 + ColBERT)', 'Fusing keyword-exact BM25 retrieval with deep semantic vector embeddings and late-interaction rerankers (Cohere, BGE) for 99%+ recall.'], ['03', 'Dynamic & Propositional Semantic Chunking', 'Replacing arbitrary token splitting with structural, document-aware semantic boundary detection and proposition chunking for pristine context preservation.'], ['04', 'Self-RAG & Adaptive Query Reformulation', 'Autonomous reflection loops that evaluate retrieval relevance, detect hallucination risks in real-time, and reformulate queries dynamically when context is insufficient.'], ['05', 'Vector Database Topology & Sharding', 'Production clustering, indexing, and sharding across Qdrant, Milvus, Pinecone, and pgvector with enterprise role-based access control (RBAC).'], ['06', 'Multimodal Document Intelligence & OCR Parsing', 'End-to-end ingestion pipelines for complex PDFs, scanned tables, technical schematics, audio recordings, and video transcripts with layout-aware visual chunking.']];

$benefits = [['01', 'Zero-Hallucination Factual Grounding', 'Every generated response is backed by exact semantic citations and verified line-level source attributions.'], ['02', 'Deep Cross-Document Multi-Hop Reasoning', 'GraphRAG traces relationships across disparate contracts, audits, and codebases to answer complex strategic queries.'], ['03', 'Sub-50ms Retrieval Latency', 'Optimized HNSW vector indexing and GPU-accelerated embedding models guarantee real-time query performance at scale.'], ['04', 'Granular Access Control & RBAC Ingestion', 'Documents are filtered by user permissions at retrieval time, guaranteeing users only query documents they are authorized to see.'], ['05', 'Private Cloud & Air-Gapped Hosting', 'Vector databases and embedding models run entirely inside your private VPC with zero telemetry sent to public cloud providers.']];

$steps = [['01', 'Enterprise Data Audit & Chunking Strategy', 'Analyzing document formats, unstructured silos, relational databases, and designing optimized metadata extraction schemas.'], ['02', 'Knowledge Graph & Embedding Pipeline', 'Vectorizing documents, building entity-relationship graphs, and benchmarking embedding models against domain terminology.'], ['03', 'Reranker & RAG Guardrail Integration', 'Implementing hybrid search algorithms, reciprocal rank fusion (RRF), cross-encoder rerankers, and citation verification hooks.'], ['04', 'Production Benchmark & Latency Tuning', 'Evaluating context precision, context recall, faithfulness with RAGAS, and optimizing cache layers for sub-50ms responses.'], ['05', 'Enterprise Deployment & RBAC Rollout', 'Deploying high-availability vector clusters on Kubernetes, connecting live enterprise data syncs, and enabling continuous indexing.']];

$models = [['01', 'GraphRAG Rapid PoC', 'A 3-week sprint building a fully functional GraphRAG prototype on your core documentation with verified citation benchmarking.', ['3-week implementation', 'Up to 50,000 documents', 'Precision scorecard']], ['02', 'Enterprise Knowledge Core', 'Full-scale RAG architecture integrated with Slack, Confluence, SharePoint, and relational ERP systems with dynamic RBAC filtering.', ['Multi-source data sync', 'Graph + Vector hybrid', 'Sub-100ms response SLA']], ['03', 'Dedicated RAG Infrastructure', 'Custom-hosted Qdrant/Milvus clusters, private VPC embedding endpoints, and continuous fine-tuning of domain rerankers.', ['Air-gapped private VPC', 'Unlimited document scaling', '24/7 cluster monitoring']]];

$techStack = ['GraphRAG', 'Qdrant', 'Milvus', 'LlamaIndex', 'LangChain', 'Cohere Rerank', 'ColBERT', 'pgvector', 'FastEmbed', 'Docker'];

$pageStack = [
    ['slug' => 'retrieval', 'title' => 'Retrieval & Index', 'icon' => 'search',
     'blurb' => 'Hybrid search over your own corpus, reranked.',
     'items' => [
         ['name' => 'OpenSearch', 'logo' => 'opensearch'],
         ['name' => 'PostgreSQL', 'logo' => 'postgresql'],
         ['name' => 'pandas', 'logo' => 'pandas'],
         ['name' => 'Python', 'logo' => 'python'],
     ]],
    ['slug' => 'models', 'title' => 'Models & Embeddings', 'icon' => 'brain',
     'blurb' => 'What reads the passage once it has been found.',
     'items' => [
         ['name' => 'OpenAI', 'logo' => 'openai'],
         ['name' => 'Anthropic', 'logo' => 'anthropic'],
         ['name' => 'LangChain', 'logo' => 'langchain'],
         ['name' => 'PyTorch', 'logo' => 'pytorch'],
     ]],
    ['slug' => 'platform', 'title' => 'Pipelines & Operations', 'icon' => 'cloud',
     'blurb' => 'Ingestion on a schedule, and re-indexing on change.',
     'items' => [
         ['name' => 'FastAPI', 'logo' => 'fastapi'],
         ['name' => 'Celery', 'logo' => 'celery'],
         ['name' => 'Redis', 'logo' => 'redis'],
         ['name' => 'Docker', 'logo' => 'docker'],
     ]],
];

$faqs = [['What is the difference between standard naive RAG and GraphRAG?', 'Standard naive RAG splits text into arbitrary chunks and uses cosine similarity, which loses relational context across documents. GraphRAG extracts entities, relationships, and claims into an interconnected knowledge graph, allowing the LLM to perform complex multi-hop reasoning across thousands of interconnected enterprise files with superior accuracy.'], ['How do you prevent hallucinations in your enterprise RAG implementations?', 'We implement a 4-tier verification protocol: hybrid semantic reranking, context relevance filtering, token citation validation, and automated Self-RAG reflection checks that reject or regenerate any claim lacking verifiable source attribution.'], ['How do you enforce role-based access control (RBAC) in vector search?', 'We implement pre-filtering and post-filtering metadata hooks that map user tokens directly to document access lists at retrieval time. Unauthorized users never receive vector chunks from restricted files, guaranteeing absolute data governance.'], ['Which vector databases do you recommend for enterprise production?', 'We deploy and optimize Qdrant, Milvus, pgvector, and Pinecone depending on your workload, sharding requirements, on-premise constraints, and latency targets. For self-hosted VPC setups, Qdrant and Milvus offer exceptional throughput and filtering.'], ['Can your RAG pipelines handle complex multimodal files like scanned PDFs and financial tables?', 'Yes. We deploy vision-language parsing models and layout-aware OCR engines (such as Unstructured, Nougat, and ColPali) that preserve tabular structure, nested headers, and visual charts directly into markdown embeddings.'], ['How do you keep vector indices updated with real-time enterprise data changes?', 'We build event-driven CDC (Change Data Capture) pipelines using Kafka, Debezium, and webhook listeners that automatically update, re-chunk, and re-embed modified documents in real time with zero system downtime.'], ['What metrics do you use to evaluate RAG retrieval accuracy?', 'We benchmark using RAGAS and TruLens frameworks measuring Context Relevance, Groundedness, Answer Relevance, Context Precision, and Faithfulness against curated golden test datasets.'], ['Can we run our entire RAG pipeline inside an air-gapped private cloud?', 'Yes. All components—embedding models, vector databases, rerankers, and local LLMs (vLLM)—can be deployed 100% on-premise or within isolated AWS/GCP/Azure VPCs with zero external internet dependencies.'], ['What is hybrid search and why is it necessary?', 'Hybrid search combines dense vector retrieval (capturing semantic meaning) with sparse lexical retrieval like BM25 (capturing exact product names, error codes, and SKUs). Merging both via Reciprocal Rank Fusion delivers industry-leading search precision.'], ['How long does it take to deploy an enterprise RAG system into production?', 'A specialized proof of concept is typically live within 2 to 3 weeks, while full enterprise deployment across multi-department repositories with RBAC takes 4 to 6 weeks.']];

/** Schema.org Structured Data with FAQPage & Service */
$schema = [
    '@context' => 'https://schema.org',
    '@graph' => [
        [
            '@type' => 'Service',
            'name' => 'Enterprise RAG Development & Contextual Vector Retrieval Services',
            'serviceType' => 'AI-First Product Development',
            'description' => 'Production-grade GraphRAG, hybrid dense-sparse vector search, self-corrective retrieval, and dynamic chunking architectures for zero-hallucination enterprise intelligence.',
            'url' => canonical('services/rag-development.php'),
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
      <p class="svc-eyebrow"><span class="svc-pulse" aria-hidden="true"></span>Enterprise GraphRAG & Vector Search · Sub-50ms Precision</p>

      <h1 class="svc-h1">
        Enterprise RAG Development For<br><em>Zero-Hallucination Knowledge Retrieval</em>
      </h1>

      <p class="svc-lead">
        Production-grade GraphRAG, hybrid dense-sparse vector search, self-corrective retrieval, and dynamic chunking architectures engineered for zero-hallucination enterprise intelligence.
      </p>

      <div class="svc-actions svc-actions--mid">
        <button class="svc-btn svc-btn--primary" type="button"
                data-modal-open data-modal-service="Enterprise RAG Development & Contextual Vector Retrieval Services">
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
        <img src="<?= e(asset('assets/img/services/svc-05-rag-dev.jpg')) ?>" width="1200" height="700"
             alt="Enterprise RAG Development & Contextual Vector Retrieval Services Architecture" fetchpriority="high" decoding="async">
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
          <h2 class="svc-title">Standard vector search fails at scale;<br><em>GraphRAG delivers deterministic truth</em></h2>
        </div>
        <div class="svc-open-copy">
          <p>Naive RAG systems suffer from severe retrieval failure: loss of cross-document relationships, semantic chunk fragmentation, context window poisoning, and hallucinations during complex multi-hop queries. Simple cosine similarity over flat vector stores cannot grasp relational hierarchies across millions of enterprise files.</p>
          <p>We engineer next-generation Retrieval-Augmented Generation architectures combining Knowledge Graph indexing (GraphRAG), hybrid BM25 + dense semantic reranking, contextual chunk expansion, and self-corrective reflection loops. Your teams query petabytes of private data with sub-second latency and mathematical citation accuracy.</p>
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
        <h2 class="svc-title">Six advanced RAG disciplines<br>engineered for <em>enterprise scale</em></h2>
        <p class="svc-sub">From knowledge graph extraction to self-corrective multi-hop reasoning pipelines.</p>
      </div>

      <div class="svc-cards-grid">
        <?php foreach ($disciplines as $i => [$num, $dTitle, $dDesc]): ?>
          <?php $fig = svc_img('05', 3, $i + 1); ?>
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
                data-modal-open data-modal-service="Enterprise RAG Development & Contextual Vector Retrieval Services">
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
        <h2 class="svc-title">Five strategic business advantages<br>of our <em>Rag Development</em></h2>
        <p class="svc-sub">
          Explore the architectural advantages that guarantee high concurrency, zero data leakage, and rapid payback timelines.
        </p>
      </div>

      <div class="svc-benefits-grid">
        <?php foreach ($benefits as $i => [$num, $bTitle, $bDesc]): ?>
          <?php $fig = svc_img('05', 5, $i + 1); ?>
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
      $s6 = array_filter([svc_img('05', 6, 1), svc_img('05', 6, 2), svc_img('05', 6, 3)]);
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
        <h2 class="svc-title">Three ways to engage our<br><em>Rag Development Practice</em></h2>
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
                    data-modal-open data-modal-service="Enterprise RAG Development & Contextual Vector Retrieval Services (Model <?= e($num) ?>)">
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
            <img src="<?= e(asset('assets/img/services/svc-05-rag-dev.jpg')) ?>" width="900" height="700"
                 alt="Enterprise RAG Development & Contextual Vector Retrieval Services FAQ Consultation" loading="lazy" decoding="async">
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
      <h2>Ready to build or scale your<br><em>Rag Development System?</em></h2>
      <p class="svc-close-lead">
        Discuss your technical requirements, latency constraints, and data governance policies directly with our Lead AI Systems Architects. Receive an actionable feasibility audit and prototype blueprint within 48 hours.
      </p>
      <div class="svc-actions svc-actions--mid">
        <button class="svc-btn svc-btn--primary" type="button"
                data-modal-open data-modal-service="Enterprise RAG Development & Contextual Vector Retrieval Services">
          Start 48-Hour Technical Discovery<?= icon('arrow') ?>
        </button>
      </div>
    </div>
  </section>

</div>

<?php
require dirname(__DIR__) . '/includes/footer.php';
