<?php
/**
 * The 6-Layer iThrive AI Stack — as an arced focus carousel.
 *
 * After the Arced Focus Carousel at arcedfocuscarousel.framer.website. That is a
 * published Framer site rather than a marketplace component, so it ships no
 * module to run; what it does publish is the finished thing, and every number
 * below was measured off it in a real browser at 1440x900 rather than guessed:
 *
 *   angle step   23.5 degrees between neighbours (measured -94, -70.5, -47,
 *                -23.5, 0, +23.5 ... on nine cards)
 *   arc radius   660px at a 1440 stage, i.e. 0.46 x the stage width
 *   rotation     each card is rotated to the arc's tangent — its own angle
 *   scale        1.5 at the focus, 0.94 one out, 0.80 from two out
 *   opacity      1.0 at the focus, then 0.764, 0.668, and 0.65 from three out
 *   z-index      descends hard from the focus, so neighbours tuck behind it
 *
 * The layout consequence worth naming: the arms run off the bottom of the stage
 * and are clipped. That is the reference's own look — the fan is wider than the
 * window it is seen through — and the copy sits in the gap between the arms.
 *
 * Two deliberate departures, both asked for:
 *  - The cards are 4:3 and big (320x240 base, 480x360 at the focus). The
 *    reference's are 4:5 portrait.
 *  - Six layers, not the four this section used to list. Retrieval, and
 *    experience-and-MLOps, were inside other layers and are now their own; the
 *    old layer 4 carried UI, security and compliance in one card and has been
 *    split, which is the honest shape of the stack anyway.
 *
 * Six cards on a symmetric arc cannot be symmetric: the wrap puts three on the
 * left and two on the right. The extra one sits on the LEFT, where the layers
 * already passed belong.
 *
 * Degrades: with no JavaScript every layer's name, description and technology
 * list is present and readable — the cards simply sit unarced and all six copy
 * blocks show. The 3D neural core below is untouched and still its own thing.
 */

declare(strict_types=1);

/** Bottom of the stack first, the way it is built. */
$layers = [
    [
        'n'     => '01',
        'key'   => 'data',
        'tint'  => '#00E5FF',
        'icon'  => 'fa-database',
        'title' => 'Data Ingestion &amp; Vector Infrastructure',
        'lede'  => 'The floor everything else stands on',
        'body'  => 'Automated document parsing, semantic chunking, high-dimensional embeddings, hybrid '
                 . 'indexing and streaming ETL. This layer decides whether anything above it can answer correctly.',
        'pills' => ['Pinecone', 'Milvus', 'Qdrant', 'pgvector'],
    ],
    [
        'n'     => '02',
        'key'   => 'models',
        'tint'  => '#3B82F6',
        'icon'  => 'fa-microchip',
        'title' => 'Foundation Models, Fine-Tuning &amp; Quantisation',
        'lede'  => 'Adapted to your domain, sized to your traffic',
        'body'  => 'Domain-adapted LLMs, parameter-efficient LoRA and QLoRA adapters, INT8 and FP16 '
                 . 'quantisation, and high-throughput serving clusters provisioned against real load rather than a demo.',
        'pills' => ['Llama 3.1', 'Mistral', 'LoRA / QLoRA', 'vLLM / Triton'],
    ],
    [
        'n'     => '03',
        'key'   => 'retrieval',
        'tint'  => '#6366F1',
        'icon'  => 'fa-magnifying-glass-chart',
        'title' => 'Retrieval &amp; Knowledge Grounding',
        'lede'  => 'Every answer traceable to a document',
        'body'  => 'Hybrid dense-and-sparse retrieval with cross-encoder reranking, context compression to '
                 . 'fit the window, and citation tracking — so a claim can always be followed back to where it came from.',
        'pills' => ['Hybrid BM25 + dense', 'Cross-encoder rerank', 'Context compression', 'Answer citations'],
    ],
    [
        'n'     => '04',
        'key'   => 'agents',
        'tint'  => '#A855F7',
        'icon'  => 'fa-brain',
        'title' => 'Agentic Orchestration &amp; Autonomous Tools',
        'lede'  => 'Multi-step work, with a gate on the costly steps',
        'body'  => 'Cognitive state machines, asynchronous job dispatch, long-term memory and typed function '
                 . 'calling, with a human approval gate wherever a wrong move would cost something real.',
        'pills' => ['LangGraph', 'CrewAI', 'AutoGen', 'FastAPI'],
    ],
    [
        'n'     => '05',
        'key'   => 'guardrails',
        'tint'  => '#E040FB',
        'icon'  => 'fa-shield-halved',
        'title' => 'Evaluation, Safety &amp; Compliance Guardrails',
        'lede'  => 'The regression suite you can show an auditor',
        'body'  => 'A golden dataset run on every prompt and model change, red-teaming for injection and '
                 . 'jailbreaks, PII masking, RBAC, and an ISO/IEC 27001 and NIST AI RMF trail that predates the audit.',
        'pills' => ['Golden-set evals', 'Injection defence', 'PII masking', 'NIST AI RMF'],
    ],
    [
        'n'     => '06',
        'key'   => 'delivery',
        'tint'  => '#10B981',
        'icon'  => 'fa-gauge-high',
        'title' => 'Experience, Delivery &amp; MLOps',
        'lede'  => 'The part that carries on after launch',
        'body'  => 'WebGL and Flutter front ends over the stack, drift detection with automated re-training '
                 . 'triggers, cost per query on a dashboard, and a 99.8% uptime SLA with a person behind it.',
        'pills' => ['WebGL / Three.js', 'Flutter AI', 'Drift detection', '99.8% SLA'],
    ],
];
?>
<section id="ecosystem" class="section-padding arced">
    <div class="container">
        <div class="arced-head">
            <div class="section-tag"><span class="dot"></span><span>SYSTEM ARCHITECTURE</span></div>
            <h2 class="section-title">The 6-Layer <span class="text-gradient">iThrive AI Stack</span></h2>
            <p class="section-desc center">
                Six decoupled layers — ingestion, models, retrieval, orchestration, guardrails and delivery —
                each replaceable without taking the ones above it down.
            </p>
        </div>
    </div>

    <div class="arced-stage" data-arced>

        <?php /* The arc. Cards are buttons: focusing a layer is an action, and
                 that is what makes it reachable by keyboard for free. */ ?>
        <div class="arced-arc" data-arced-arc>
            <?php foreach ($layers as $i => $l): ?>
                <button type="button" class="arced-card<?= $i === 0 ? ' is-focus' : '' ?>"
                        data-arced-card data-i="<?= $i ?>"
                        style="--tint: <?= e($l['tint']) ?>;"
                        aria-label="Layer <?= e($l['n']) ?>: <?= e(strip_tags(html_entity_decode($l['title']))) ?>">
                    <img src="<?= e(asset('assets/img/aidev/stack/layer-' . $l['n'] . '.jpg')) ?>"
                         alt="" width="1200" height="900" loading="lazy" decoding="async" draggable="false">
                </button>
            <?php endforeach; ?>
        </div>

        <?php /* The copy for the focused layer. All six are in the markup and
                 only one is shown, so the section reads completely with the
                 script absent and an answer engine sees every layer. */ ?>
        <div class="arced-copy">
            <button type="button" class="arced-nav arced-prev" data-arced-prev aria-label="Previous layer">
                <i class="fa-solid fa-chevron-left"></i>
            </button>

            <div class="arced-panels">
                <?php foreach ($layers as $i => $l): ?>
                    <article class="arced-panel<?= $i === 0 ? ' is-shown' : '' ?>"
                             data-arced-panel data-i="<?= $i ?>" style="--tint: <?= e($l['tint']) ?>;">
                        <p class="arced-eyebrow">
                            <i class="fa-solid <?= e($l['icon']) ?>"></i>
                            LAYER <?= e($l['n']) ?> · <?= e($l['lede']) ?>
                        </p>
                        <h3 class="arced-title"><?= $l['title'] ?></h3>
                        <p class="arced-body"><?= e($l['body']) ?></p>
                        <ul class="arced-pills">
                            <?php foreach ($l['pills'] as $pill): ?>
                                <li><?= e($pill) ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <a class="arced-cta" href="<?= e(url('contact.php')) ?>">
                            Talk through this layer<?= icon('arrow') ?>
                        </a>
                    </article>
                <?php endforeach; ?>
            </div>

            <button type="button" class="arced-nav arced-next" data-arced-next aria-label="Next layer">
                <i class="fa-solid fa-chevron-right"></i>
            </button>
        </div>

        <div class="arced-dots" data-arced-dots role="tablist" aria-label="Stack layers">
            <?php foreach ($layers as $i => $l): ?>
                <button type="button" class="arced-dot<?= $i === 0 ? ' is-on' : '' ?>"
                        data-arced-dot data-i="<?= $i ?>" role="tab"
                        aria-selected="<?= $i === 0 ? 'true' : 'false' ?>"
                        aria-label="Layer <?= e($l['n']) ?>"></button>
            <?php endforeach; ?>
        </div>
    </div>

    <?php /* The 3D neural core the section has always carried. It is genuinely
             interactive and driven by assets/js/aidev/neural-core-3d.js, so it
             stays — it just sits below the stack now rather than beside it, the
             carousel having taken the full width. */ ?>
    <div class="container">
        <div class="glass-panel corner-bracket-wrap arced-core">
            <div class="corner-bracket-bottom-left"></div>
            <div class="corner-bracket-bottom-right"></div>

            <div id="neural-core-3d-stage" class="neural-core-3d-stage corner-bracket-wrap" style="margin-bottom: 1.25rem;">
                <canvas id="neural-core-3d-canvas"></canvas>

                <div class="neural-core-hud-top">
                    <span class="neural-live-badge"><i class="fa-solid fa-brain"></i> 3D QUANTUM NEURAL MATRIX</span>
                    <span class="neural-dim-badge" id="neural-core-mode">MODE: FULL STACK</span>
                </div>

                <div class="neural-core-hud-bottom">
                    <span><i class="fa-solid fa-arrows-spin"></i> DRAG TO ROTATE 3D CORE</span>
                    <span id="neural-core-metric"><i class="fa-solid fa-bolt" style="color: var(--accent-cyan);"></i> 1536-D EMBEDDINGS</span>
                </div>
            </div>

            <div class="arced-core-foot">
                <div>
                    <div class="arced-core-name">iThrive Neural Matrix (v3.4)</div>
                    <div class="arced-core-sub">Interactive 3D WebGL vector synaptic core · real-time physics</div>
                </div>
                <div class="arced-core-stat">
                    <span><i class="fa-solid fa-gauge-high"></i> 42ms latency</span>
                    <div>99.4% precision</div>
                </div>
            </div>
        </div>
    </div>
</section>
