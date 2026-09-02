<?php
/**
 * iThrive AI - 4-Layer Ecosystem Architecture Stack
 * Path: sections/ecosystem.php
 */
?>
<section id="ecosystem" class="section-padding">
    <div class="container">
        <!-- Section Header -->
        <div style="text-align: center; max-width: 820px; margin: 0 auto 4rem;">
            <div class="section-tag">
                <span class="dot"></span>
                <span>SYSTEM ARCHITECTURE</span>
            </div>
            <h2 class="section-title">
                The 4-Layer <span class="text-gradient">iThrive AI Stack</span>
            </h2>
            <p class="section-desc center">
                Our enterprise architecture decouples data ingestion, foundational model fine-tuning, autonomous orchestration, and security guardrails into a robust, high-availability pipeline.
            </p>
        </div>

        <!-- 4-Layer Architecture with Neural Core Visual -->
        <div style="display: grid; grid-template-columns: 1.15fr 0.85fr; gap: 3rem; align-items: center;">
            
            <!-- Left: 4-Layer Architecture Stack -->
            <div class="ecosystem-diagram-container">
                
                <!-- Layer 4: Application & Guardrails -->
                <div class="eco-layer-card corner-bracket-wrap">
                    <div class="eco-layer-badge">
                        <i class="fa-solid fa-layer-group" style="color: var(--accent-magenta);"></i>
                        <span>LAYER 04</span>
                    </div>
                    <div class="eco-layer-info">
                        <h4>Enterprise UI, Security &amp; Compliance Guardrails</h4>
                        <p>WebGL 3D interfaces, Flutter mobile apps, real-time prompt-injection defense, PII masking &amp; ISO 27001 auditing.</p>
                    </div>
                    <div class="eco-tech-pills">
                        <span class="eco-pill">WebGL / Three.js</span>
                        <span class="eco-pill">Flutter AI</span>
                        <span class="eco-pill">NIST AI RMF</span>
                        <span class="eco-pill">RBAC Vault</span>
                    </div>
                </div>

                <!-- Layer 3: Agentic Orchestration -->
                <div class="eco-layer-card corner-bracket-wrap">
                    <div class="eco-layer-badge">
                        <i class="fa-solid fa-brain" style="color: var(--accent-violet);"></i>
                        <span>LAYER 03</span>
                    </div>
                    <div class="eco-layer-info">
                        <h4>Agentic Orchestration &amp; Autonomous Tools</h4>
                        <p>Multi-agent cognitive state-machines, asynchronous job dispatchers, long-term memory modules &amp; REST function-calling.</p>
                    </div>
                    <div class="eco-tech-pills">
                        <span class="eco-pill">LangGraph</span>
                        <span class="eco-pill">CrewAI</span>
                        <span class="eco-pill">AutoGen</span>
                        <span class="eco-pill">FastAPI</span>
                    </div>
                </div>

                <!-- Layer 2: Foundation Models -->
                <div class="eco-layer-card corner-bracket-wrap">
                    <div class="eco-layer-badge">
                        <i class="fa-solid fa-microchip" style="color: var(--accent-blue);"></i>
                        <span>LAYER 02</span>
                    </div>
                    <div class="eco-layer-info">
                        <h4>Foundation Models, Fine-Tuning &amp; Quantization</h4>
                        <p>Domain-adapted LLMs, parameter-efficient LoRA adapters, INT8/FP16 quantization &amp; high-throughput vLLM clusters.</p>
                    </div>
                    <div class="eco-tech-pills">
                        <span class="eco-pill">Llama 3.1 / DeepSeek</span>
                        <span class="eco-pill">Mistral</span>
                        <span class="eco-pill">LoRA / QLoRA</span>
                        <span class="eco-pill">vLLM / Triton</span>
                    </div>
                </div>

                <!-- Layer 1: Data & Vector Storage -->
                <div class="eco-layer-card corner-bracket-wrap">
                    <div class="eco-layer-badge">
                        <i class="fa-solid fa-database" style="color: var(--accent-cyan);"></i>
                        <span>LAYER 01</span>
                    </div>
                    <div class="eco-layer-info">
                        <h4>Data Ingestion &amp; Vector Infrastructure</h4>
                        <p>Automated document parsing, high-dimensional vector embeddings, hybrid semantic indexing &amp; real-time streaming ETL.</p>
                    </div>
                    <div class="eco-tech-pills">
                        <span class="eco-pill">Pinecone</span>
                        <span class="eco-pill">Milvus</span>
                        <span class="eco-pill">Qdrant</span>
                        <span class="eco-pill">pgvector</span>
                    </div>
                </div>

            </div>

            <!-- Right: Interactive 3D Quantum Neural Core Panel -->
            <div class="glass-panel corner-bracket-wrap" style="padding: 1.5rem; border: 1px solid rgba(139, 47, 201, 0.35); background: radial-gradient(circle at center, rgba(139, 47, 201, 0.1) 0%, rgba(11, 14, 28, 0.95) 80%); box-shadow: 0 25px 70px rgba(0, 0, 0, 0.9), 0 0 40px rgba(139, 47, 201, 0.25);">
                <div class="corner-bracket-bottom-left"></div>
                <div class="corner-bracket-bottom-right"></div>
                
                <!-- WebGL 3D Quantum Neural Core Canvas Stage -->
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

                <div style="display: flex; align-items: center; justify-content: space-between; border-top: 1px solid rgba(255, 255, 255, 0.08); padding-top: 1rem;">
                    <div>
                        <div style="font-weight: 700; color: #FFF; font-size: 1.05rem;">iThrive Neural Matrix (v3.4)</div>
                        <div style="font-size: 0.82rem; color: var(--text-muted);">Interactive 3D WebGL Vector Synaptic Core · Real-time Physics</div>
                    </div>
                    <div style="text-align: right;">
                        <span style="font-family: var(--font-mono); font-size: 0.82rem; color: #10B981; font-weight: 700;"><i class="fa-solid fa-gauge-high"></i> 42ms Latency</span>
                        <div style="font-size: 0.72rem; color: var(--accent-cyan);">99.4% Precision</div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
