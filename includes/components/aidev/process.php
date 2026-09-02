<?php
/**
 * iThrive AI - Section 4: 6-Step AI SDLC Process (Framer StimulatedSlider Component)
 * Path: sections/process.php
 */
?>
<section id="process" class="section-fullscreen-16-9 stimulated-slider-section">
    <div class="container-16-9">
        <!-- Section Header & HUD inside 16:9 Container -->
        <div class="section-header-16-9">
            <div style="text-align: center; margin-bottom: 0.65rem;">
                <div class="section-tag" style="margin-bottom: 0.35rem;">
                    <span class="dot"></span>
                    <span>SYSTEMATIC 6-STEP SDLC</span>
                </div>
                <h2 class="section-title" style="font-size: 1.85rem; margin-bottom: 0.35rem;">
                    Our 6-Step <span class="text-gradient">AI Development Process</span>
                </h2>
            </div>

            <!-- 6-Step Top Quick Selection Pills -->
            <div class="quick-pills-bar">
                <button class="quick-pill-btn slider-pill-btn active" data-step-target="0"><i class="fa-solid fa-magnifying-glass-chart"></i> 01 Discovery</button>
                <button class="quick-pill-btn slider-pill-btn" data-step-target="1"><i class="fa-solid fa-database"></i> 02 Ingestion</button>
                <button class="quick-pill-btn slider-pill-btn" data-step-target="2"><i class="fa-solid fa-brain"></i> 03 Tuning</button>
                <button class="quick-pill-btn slider-pill-btn" data-step-target="3"><i class="fa-solid fa-shield-virus"></i> 04 Audits</button>
                <button class="quick-pill-btn slider-pill-btn" data-step-target="4"><i class="fa-solid fa-rocket"></i> 05 Deploy</button>
                <button class="quick-pill-btn slider-pill-btn" data-step-target="5"><i class="fa-solid fa-gauge-high"></i> 06 MLOps</button>
            </div>
        </div>

        <!-- Framer StimulatedSlider Container -->
        <div class="stimulated-slider-container" id="stimulated-slider-root">
            
            <!-- Edge Click Navigation Zones -->
            <button class="slider-edge-click edge-left" id="slider-edge-prev" aria-label="Previous Step"></button>
            <button class="slider-edge-click edge-right" id="slider-edge-next" aria-label="Next Step"></button>

            <!-- Dynamic Sliding Track -->
            <div class="stimulated-slider-track" id="stimulated-slider-track">
                
                <!-- Slide 01: Discovery & Feasibility -->
                <div class="stimulated-slide-card corner-bracket-wrap active" data-index="0" data-img="<?= e(asset('assets/img/aidev/human-with-tech-engineer.jpg')) ?>" data-deliverable="AI Architecture Blueprint" data-tag="FEASIBILITY & AUDIT">
                    <div class="slide-card-media">
                        <img src="<?= e(asset('assets/img/aidev/human-with-tech-engineer.jpg')) ?>" alt="Discovery &amp; Feasibility" loading="eager" draggable="false">
                        <span class="slide-step-badge">STEP 01</span>
                        <span class="slide-tag-pill">AUDIT &amp; ROI</span>
                    </div>
                    <div class="slide-card-body">
                        <div class="slide-icon-row">
                            <div class="slide-icon-box cyan"><i class="fa-solid fa-magnifying-glass-chart"></i></div>
                            <h3 class="slide-title">Discovery &amp; Feasibility</h3>
                        </div>
                        <p class="slide-desc">
                            We evaluate proprietary data, audit token economics, analyze security boundaries, and architect high-ROI production roadmaps.
                        </p>
                        <div class="slide-deliverable-box">
                            <i class="fa-solid fa-file-contract" style="color: var(--accent-cyan);"></i>
                            <span>Blueprint: AI System Specification</span>
                        </div>
                    </div>
                </div>

                <!-- Slide 02: Data Ingestion & ETL -->
                <div class="stimulated-slide-card corner-bracket-wrap" data-index="1" data-img="<?= e(asset('assets/img/aidev/process-step-data-etl.jpg')) ?>" data-deliverable="Clean Vector Knowledge Lake" data-tag="VECTOR INGESTION">
                    <div class="slide-card-media">
                        <img src="<?= e(asset('assets/img/aidev/process-step-data-etl.jpg')) ?>" alt="Data Ingestion &amp; ETL" loading="eager" draggable="false">
                        <span class="slide-step-badge">STEP 02</span>
                        <span class="slide-tag-pill">VECTOR ETL</span>
                    </div>
                    <div class="slide-card-body">
                        <div class="slide-icon-row">
                            <div class="slide-icon-box blue"><i class="fa-solid fa-database"></i></div>
                            <h3 class="slide-title">Data Ingestion &amp; ETL</h3>
                        </div>
                        <p class="slide-desc">
                            Automated document parsing, semantic chunking, high-dimensional vector embeddings, and enterprise PII masking.
                        </p>
                        <div class="slide-deliverable-box">
                            <i class="fa-solid fa-server" style="color: var(--accent-blue);"></i>
                            <span>Lake: Clean Vector Embeddings</span>
                        </div>
                    </div>
                </div>

                <!-- Slide 03: Model Tuning & RAG -->
                <div class="stimulated-slide-card corner-bracket-wrap" data-index="2" data-img="<?= e(asset('assets/img/aidev/human-ai-collaboration.jpg')) ?>" data-deliverable="Fine-Tuned Model Checkpoint" data-tag="LORA & LANGGRAPH">
                    <div class="slide-card-media">
                        <img src="<?= e(asset('assets/img/aidev/human-ai-collaboration.jpg')) ?>" alt="Model Tuning &amp; RAG" loading="eager" draggable="false">
                        <span class="slide-step-badge">STEP 03</span>
                        <span class="slide-tag-pill">LORA TUNING</span>
                    </div>
                    <div class="slide-card-body">
                        <div class="slide-icon-row">
                            <div class="slide-icon-box magenta"><i class="fa-solid fa-brain"></i></div>
                            <h3 class="slide-title">Model Tuning &amp; RAG</h3>
                        </div>
                        <p class="slide-desc">
                            Domain LoRA / QLoRA fine-tuning, context compression, private RAG pipelines, and LangGraph multi-agent cognitive flows.
                        </p>
                        <div class="slide-deliverable-box">
                            <i class="fa-solid fa-microchip" style="color: var(--accent-magenta);"></i>
                            <span>Model: Fine-Tuned Weights</span>
                        </div>
                    </div>
                </div>

                <!-- Slide 04: Safety & Bias Audits -->
                <div class="stimulated-slide-card corner-bracket-wrap" data-index="3" data-img="<?= e(asset('assets/img/aidev/process-step-security-audit.jpg')) ?>" data-deliverable="Zero-Leakage Audit Certificate" data-tag="SECURITY & NIST">
                    <div class="slide-card-media">
                        <img src="<?= e(asset('assets/img/aidev/process-step-security-audit.jpg')) ?>" alt="Safety &amp; Bias Audits" loading="eager" draggable="false">
                        <span class="slide-step-badge">STEP 04</span>
                        <span class="slide-tag-pill">RED TEAMING</span>
                    </div>
                    <div class="slide-card-body">
                        <div class="slide-icon-row">
                            <div class="slide-icon-box violet"><i class="fa-solid fa-shield-virus"></i></div>
                            <h3 class="slide-title">Safety &amp; Bias Audits</h3>
                        </div>
                        <p class="slide-desc">
                            Automated red-teaming for hallucination thresholds, jailbreak defense, latency stress testing, and NIST AI RMF governance.
                        </p>
                        <div class="slide-deliverable-box">
                            <i class="fa-solid fa-shield-halved" style="color: var(--accent-violet);"></i>
                            <span>Audit: Zero-Leakage Certificate</span>
                        </div>
                    </div>
                </div>

                <!-- Slide 05: Deploy & Integrate -->
                <div class="stimulated-slide-card corner-bracket-wrap" data-index="4" data-img="<?= e(asset('assets/img/aidev/ithrive-innovation-lab.jpg')) ?>" data-deliverable="Production Microservice Endpoints" data-tag="VLLM CLUSTERS">
                    <div class="slide-card-media">
                        <img src="<?= e(asset('assets/img/aidev/ithrive-innovation-lab.jpg')) ?>" alt="Deploy &amp; Integrate" loading="eager" draggable="false">
                        <span class="slide-step-badge">STEP 05</span>
                        <span class="slide-tag-pill">KUBERNETES</span>
                    </div>
                    <div class="slide-card-body">
                        <div class="slide-icon-row">
                            <div class="slide-icon-box green"><i class="fa-solid fa-rocket"></i></div>
                            <h3 class="slide-title">Deploy &amp; Integrate</h3>
                        </div>
                        <p class="slide-desc">
                            Kubernetes microservice clusters, vLLM / Triton acceleration on AWS/Azure/GCP, and non-invasive enterprise CRM connectors.
                        </p>
                        <div class="slide-deliverable-box">
                            <i class="fa-solid fa-network-wired" style="color: #10B981;"></i>
                            <span>Deploy: High-Throughput APIs</span>
                        </div>
                    </div>
                </div>

                <!-- Slide 06: MLOps & SLA Support -->
                <div class="stimulated-slide-card corner-bracket-wrap" data-index="5" data-img="<?= e(asset('assets/img/aidev/case-study-fleet-ai.jpg')) ?>" data-deliverable="24/7 Telemetry &amp; SLA Guarantee" data-tag="99.8% SLA">
                    <div class="slide-card-media">
                        <img src="<?= e(asset('assets/img/aidev/case-study-fleet-ai.jpg')) ?>" alt="MLOps &amp; SLA Support" loading="eager" draggable="false">
                        <span class="slide-step-badge">STEP 06</span>
                        <span class="slide-tag-pill">24/7 MLOPS</span>
                    </div>
                    <div class="slide-card-body">
                        <div class="slide-icon-row">
                            <div class="slide-icon-box cyan"><i class="fa-solid fa-gauge-high"></i></div>
                            <h3 class="slide-title">MLOps &amp; SLA Support</h3>
                        </div>
                        <p class="slide-desc">
                            Real-time telemetry, model drift detection, automated re-training triggers, and 24/7 enterprise 99.8% uptime SLA guarantee.
                        </p>
                        <div class="slide-deliverable-box">
                            <i class="fa-solid fa-clock" style="color: var(--accent-cyan);"></i>
                            <span>SLA: 24/7 Uptime &amp; Telemetry</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Controls Row -->
        <div class="liquid-controls-bar" style="margin-top: 0.5rem;">
            <button class="liquid-nav-btn" id="slider-btn-prev" aria-label="Previous Step">
                <i class="fa-solid fa-arrow-left"></i>
            </button>
            
            <div class="rotunda-hint-pill">
                <i class="fa-solid fa-computer-mouse"></i>
                <span>SCROLL OR CLICK EDGES TO NAVIGATE STEPS</span>
            </div>

            <button class="liquid-nav-btn" id="slider-btn-next" aria-label="Next Step">
                <i class="fa-solid fa-arrow-right"></i>
            </button>
        </div>
    </div>
</section>

