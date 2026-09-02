<?php
/**
 * iThrive AI - ChainGPT-Style Solutions Section with Interactive Scroll & Video Deck
 * Path: sections/solutions.php
 */
?>
<section id="solutions" class="section-padding">
    <div class="container">
        <!-- Section Header -->
        <div style="text-align: center; max-width: 820px; margin: 0 auto 3.5rem;">
            <div class="section-tag">
                <span class="dot"></span>
                <span>ENGINEERING CAPABILITIES</span>
            </div>
            <h2 class="section-title">
                Our Enterprise <span class="text-gradient">AI Solutions</span>
            </h2>
            <p class="section-desc center">
                Explore our full-lifecycle AI systems. Hover or click any solution below to preview the live interactive neural pipeline and video demonstration.
            </p>
        </div>

        <!-- Interactive Split Video Showcase Deck (ChainGPT exact pattern) -->
        <div class="solutions-deck-layout">
            
            <!-- Left Column: 01–09 Solution Selectors -->
            <div class="solutions-selector-rail">
                
                <!-- 01: AI Strategy & Consulting -->
                <div class="solution-deck-item active" data-solution-index="01" data-video-src="<?= e(asset('videos/aidev/ai_healthcare.mp4')) ?>" data-title="01: AI Strategy & Enterprise Feasibility" data-desc="Strategic enterprise roadmapping, LLM compute budget audits, and ROI feasibility assessments." data-tag="STRATEGY & FEASIBILITY" data-latency="Sub-200ms" data-accuracy="99.8%">
                    <div class="sol-deck-header">
                        <span class="sol-num">01</span>
                        <div class="sol-deck-title-wrap">
                            <h3 class="sol-title">AI Strategy &amp; Consulting</h3>
                            <span class="sol-mini-tag">ENTERPRISE AUDIT</span>
                        </div>
                    </div>
                    <p class="sol-desc">
                        Enterprise AI maturity auditing, architecture selection, and PoC feasibility to maximize ROI before writing model code.
                    </p>
                    <ul class="sol-features">
                        <li><i class="fa-solid fa-check"></i> Enterprise AI Maturity Auditing</li>
                        <li><i class="fa-solid fa-check"></i> Architecture &amp; Tech Stack Selection</li>
                        <li><i class="fa-solid fa-check"></i> Proof-of-Concept (PoC) Feasibility</li>
                    </ul>
                </div>

                <!-- 02: Custom AI Product Development -->
                <div class="solution-deck-item" data-solution-index="02" data-video-src="<?= e(asset('videos/aidev/taxi_ai.mp4')) ?>" data-title="02: Custom AI Product & 3D SaaS Development" data-desc="Bespoke AI platforms, full-stack microservices, 3D WebGL interfaces, and mobile applications." data-tag="PRODUCT & 3D WEB" data-latency="Sub-100ms" data-accuracy="99.6%">
                    <div class="sol-deck-header">
                        <span class="sol-num">02</span>
                        <div class="sol-deck-title-wrap">
                            <h3 class="sol-title">Custom AI Product Development</h3>
                            <span class="sol-mini-tag">FULL-STACK SAAS & 3D</span>
                        </div>
                    </div>
                    <p class="sol-desc">
                        Bespoke AI-powered web SaaS platforms, mobile applications, and 3D digital interactive products tailored to your proprietary workflows.
                    </p>
                    <ul class="sol-features">
                        <li><i class="fa-solid fa-check"></i> Full-Stack AI SaaS Platforms</li>
                        <li><i class="fa-solid fa-check"></i> WebGL 3D Interactive Interfaces</li>
                        <li><i class="fa-solid fa-check"></i> High-Throughput Microservice APIs</li>
                    </ul>
                </div>

                <!-- 03: Generative AI & Autonomous LLM Agents -->
                <div class="solution-deck-item" data-solution-index="03" data-video-src="<?= e(asset('videos/aidev/ai_healthcare.mp4')) ?>" data-title="03: Generative AI & Autonomous LLM Agents" data-desc="Domain fine-tuned LLMs, private RAG knowledge retrieval, and LangGraph multi-agent orchestration." data-tag="LLMS & RAG AGENTS" data-latency="Sub-400ms" data-accuracy="99.4%">
                    <div class="sol-deck-header">
                        <span class="sol-num">03</span>
                        <div class="sol-deck-title-wrap">
                            <h3 class="sol-title">Generative AI &amp; LLM Agents</h3>
                            <span class="sol-mini-tag">RAG & LORA TUNING</span>
                        </div>
                    </div>
                    <p class="sol-desc">
                        Custom fine-tuned LLMs, private RAG pipelines on your knowledge base, and autonomous decision-making agents executing multi-step jobs.
                    </p>
                    <ul class="sol-features">
                        <li><i class="fa-solid fa-check"></i> Retrieval-Augmented Generation (RAG)</li>
                        <li><i class="fa-solid fa-check"></i> LoRA &amp; QLoRA Model Fine-Tuning</li>
                        <li><i class="fa-solid fa-check"></i> Multi-Agent Orchestration (LangGraph)</li>
                    </ul>
                </div>

                <!-- 04: Conversational AI & Multilingual Voicebots -->
                <div class="solution-deck-item" data-solution-index="04" data-video-src="<?= e(asset('videos/aidev/foodtime.mp4')) ?>" data-title="04: Conversational AI & Multilingual Voicebots" data-desc="Ultra-low latency conversational voicebots in 25+ Indian and global languages with emotion recognition." data-tag="VOICEBOTS & NLP" data-latency="Sub-350ms" data-accuracy="99.2%">
                    <div class="sol-deck-header">
                        <span class="sol-num">04</span>
                        <div class="sol-deck-title-wrap">
                            <h3 class="sol-title">Conversational AI &amp; Voicebots</h3>
                            <span class="sol-mini-tag">25+ LANGUAGES</span>
                        </div>
                    </div>
                    <p class="sol-desc">
                        Ultra-low-latency voice agents and contextual chatbots conducting human-like conversations across 25+ Indian and international languages.
                    </p>
                    <ul class="sol-features">
                        <li><i class="fa-solid fa-check"></i> Multilingual NLP (Tamil, Hindi, Telugu, English)</li>
                        <li><i class="fa-solid fa-check"></i> Real-Time Speech-to-Speech Inferencing</li>
                        <li><i class="fa-solid fa-check"></i> Omnichannel CRM Integration (WhatsApp, Web)</li>
                    </ul>
                </div>

                <!-- 05: Computer Vision, OCR & Video AI -->
                <div class="solution-deck-item" data-solution-index="05" data-video-src="<?= e(asset('videos/aidev/ai_healthcare.mp4')) ?>" data-title="05: Computer Vision, OCR & Video AI" data-desc="YOLOv10 object tracking, industrial defect inspection, document OCR extraction, and video generation." data-tag="VISION & VIDEO AI" data-latency="60 FPS" data-accuracy="99.7%">
                    <div class="sol-deck-header">
                        <span class="sol-num">05</span>
                        <div class="sol-deck-title-wrap">
                            <h3 class="sol-title">Computer Vision, OCR &amp; Video AI</h3>
                            <span class="sol-mini-tag">YOLOV10 & OCR</span>
                        </div>
                    </div>
                    <p class="sol-desc">
                        Advanced visual intelligence for industrial defect inspection, real-time video surveillance, medical imaging scans, and document extraction.
                    </p>
                    <ul class="sol-features">
                        <li><i class="fa-solid fa-check"></i> Real-Time Object Tracking (YOLOv10)</li>
                        <li><i class="fa-solid fa-check"></i> Invoice, Passport &amp; Document OCR</li>
                        <li><i class="fa-solid fa-check"></i> Generative Video &amp; Animation Pipelines</li>
                    </ul>
                </div>

                <!-- 06: Enterprise AI Integration -->
                <div class="solution-deck-item" data-solution-index="06" data-video-src="<?= e(asset('videos/aidev/taxi_ai.mp4')) ?>" data-title="06: Enterprise System AI Integration" data-desc="Seamlessly inject predictive and generative capabilities into SAP, Salesforce, Oracle, and data lakes." data-tag="SYSTEM INTEGRATION" data-latency="Sub-50ms" data-accuracy="99.9%">
                    <div class="sol-deck-header">
                        <span class="sol-num">06</span>
                        <div class="sol-deck-title-wrap">
                            <h3 class="sol-title">Enterprise AI Integration</h3>
                            <span class="sol-mini-tag">SAP & SALESFORCE</span>
                        </div>
                    </div>
                    <p class="sol-desc">
                        Seamlessly inject predictive and generative capabilities into your legacy ERP, CRM, HRMS, and data lakes without operational disruptions.
                    </p>
                    <ul class="sol-features">
                        <li><i class="fa-solid fa-check"></i> SAP, Salesforce &amp; Oracle Connectors</li>
                        <li><i class="fa-solid fa-check"></i> Vector DB Ingestion (Pinecone / Milvus)</li>
                        <li><i class="fa-solid fa-check"></i> Zero-Downtime Microservice Pipelines</li>
                    </ul>
                </div>

                <!-- 07: Predictive Analytics & BI -->
                <div class="solution-deck-item" data-solution-index="07" data-video-src="<?= e(asset('videos/aidev/meetoo_dating.mp4')) ?>" data-title="07: Predictive Business Analytics & Forecasting" data-desc="Time-series financial forecasting, customer churn models, dynamic pricing, and anomaly detection." data-tag="PREDICTIVE BI" data-latency="Real-Time" data-accuracy="98.9%">
                    <div class="sol-deck-header">
                        <span class="sol-num">07</span>
                        <div class="sol-deck-title-wrap">
                            <h3 class="sol-title">Predictive Analytics &amp; BI</h3>
                            <span class="sol-mini-tag">TIME-SERIES ML</span>
                        </div>
                    </div>
                    <p class="sol-desc">
                        Transform historical raw data into high-precision predictive forecasts, dynamic pricing engines, customer churn models, and dashboards.
                    </p>
                    <ul class="sol-features">
                        <li><i class="fa-solid fa-check"></i> Financial &amp; Demand Forecasting</li>
                        <li><i class="fa-solid fa-check"></i> Churn &amp; Lifetime Value (LTV) Modeling</li>
                        <li><i class="fa-solid fa-check"></i> Real-time Anomaly Alert Engines</li>
                    </ul>
                </div>

                <!-- 08: AI Security & Governance -->
                <div class="solution-deck-item" data-solution-index="08" data-video-src="<?= e(asset('videos/aidev/ai_healthcare.mp4')) ?>" data-title="08: AI Security, Governance & Compliance" data-desc="Real-time prompt injection defense, automatic PII masking, hallucination mitigation, and ISO 27001 auditing." data-tag="SECURITY VAULT" data-latency="Zero-Leakage" data-accuracy="ISO 27001">
                    <div class="sol-deck-header">
                        <span class="sol-num">08</span>
                        <div class="sol-deck-title-wrap">
                            <h3 class="sol-title">AI Security &amp; Compliance</h3>
                            <span class="sol-mini-tag">NIST AI RMF</span>
                        </div>
                    </div>
                    <p class="sol-desc">
                        Hardened AI guardrails, PII data sanitization, hallucination mitigation, and full regulatory alignment with ISO 27001, GDPR, and NIST AI RMF.
                    </p>
                    <ul class="sol-features">
                        <li><i class="fa-solid fa-check"></i> Real-Time Prompt Injection Defense</li>
                        <li><i class="fa-solid fa-check"></i> Automatic PII &amp; Sensitive Data Redaction</li>
                        <li><i class="fa-solid fa-check"></i> Full Audit Trails &amp; RBAC Control</li>
                    </ul>
                </div>

                <!-- 09: Edge AI, Robotics & IoT -->
                <div class="solution-deck-item" data-solution-index="09" data-video-src="<?= e(asset('videos/aidev/taxi_ai.mp4')) ?>" data-title="09: Edge AI, Robotics & Smart IoT" data-desc="INT8 quantized neural models running on NVIDIA Jetson, drones, and IoT hardware with zero cloud lag." data-tag="EDGE TENSORRT" data-latency="Sub-5ms" data-accuracy="99.5%">
                    <div class="sol-deck-header">
                        <span class="sol-num">09</span>
                        <div class="sol-deck-title-wrap">
                            <h3 class="sol-title">Edge AI, Robotics &amp; IoT</h3>
                            <span class="sol-mini-tag">NVIDIA JETSON</span>
                        </div>
                    </div>
                    <p class="sol-desc">
                        Ultra-compact, quantized neural networks running directly on edge hardware, NVIDIA Jetson, drones, and smart IoT sensors with sub-ms latency.
                    </p>
                    <ul class="sol-features">
                        <li><i class="fa-solid fa-check"></i> Model Quantization (INT8 / FP16 TensorRT)</li>
                        <li><i class="fa-solid fa-check"></i> NVIDIA Jetson &amp; Raspberry Pi Deployments</li>
                        <li><i class="fa-solid fa-check"></i> Zero-Cloud Offline Inference</li>
                    </ul>
                </div>
            </div>

            <!-- Right Column: Sticky Cyber Glass Video Showcase Deck -->
            <div class="solutions-video-sticky-deck">
                <div class="deck-video-frame corner-bracket-wrap">
                    <div class="corner-bracket-bottom-left"></div>
                    <div class="corner-bracket-bottom-right"></div>

                    <!-- Video Header Bar -->
                    <div class="deck-video-topbar">
                        <div class="deck-live-indicator">
                            <span class="deck-live-dot"></span>
                            <span id="deck-solution-tag">LIVE DEMO · STRATEGY & FEASIBILITY</span>
                        </div>
                        <div class="deck-hud-badges">
                            <span class="deck-hud-pill" id="deck-latency-pill"><i class="fa-solid fa-gauge-high"></i> Latency: Sub-200ms</span>
                            <span class="deck-hud-pill" id="deck-accuracy-pill"><i class="fa-solid fa-bullseye"></i> Accuracy: 99.8%</span>
                        </div>
                    </div>

                    <!-- Active Scrollable Video Player with HUD & Scrub Sync -->
                    <div class="deck-video-player-container">
                        <video id="deck-live-video" autoplay muted loop playsinline poster="<?= e(asset('assets/img/aidev/ithrive-robot-companion.jpg')) ?>">
                            <source src="<?= e(asset('videos/aidev/solutions-scroll-video.mp4')) ?>" type="video/mp4">
                        </video>
                        <div class="deck-video-glow-overlay"></div>
                        <div class="deck-scroll-scrub-indicator">
                            <div class="deck-scroll-scrub-fill" id="deck-scroll-scrub-fill"></div>
                        </div>
                        <div class="deck-scroll-pill-badge" id="deck-scroll-pill-badge">
                            <i class="fa-solid fa-arrows-up-down"></i> SCROLL SYNC · <span id="deck-scroll-pct">0%</span>
                        </div>
                    </div>

                    <!-- Video Details & Direct CTAs -->
                    <div class="deck-video-footer">
                        <div>
                            <h4 id="deck-video-title" class="deck-video-h4">01: AI Strategy &amp; Enterprise Feasibility</h4>
                            <p id="deck-video-desc" class="deck-video-p">Strategic enterprise roadmapping, LLM compute budget audits, and ROI feasibility assessments.</p>
                        </div>
                        
                        <div class="deck-cta-row">
                            <a href="#contact" class="btn btn-primary btn-sm">
                                <span>Deploy This Solution</span>
                                <i class="fa-solid fa-arrow-right"></i>
                            </a>
                            <button id="deck-expand-btn" class="btn btn-secondary btn-sm" onclick="expandDeckVideo()">
                                <i class="fa-solid fa-expand"></i>
                                <span>Full Screen</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
