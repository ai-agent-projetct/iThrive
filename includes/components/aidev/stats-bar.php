<?php
/**
 * iThrive AI - Section 2: Interactive Drag Elements Playground (OriginKit Base Preset)
 * Framer-Motion style DragElements with physics, inertia momentum, boundary spring constraints & selectedOnTop z-index stack
 * Path: sections/stats-bar.php
 */
?>
<section id="stats-playground" class="section-fullscreen-16-9 drag-elements-section">
    <div class="container-16-9">
        <!-- Section Header & Reset Controls -->
        <div class="section-header-16-9">
            <div class="section-tag">
                <span class="dot"></span>
                <span>ORIGINKIT DRAGGABLE INTELLIGENCE PLAYGROUND</span>
            </div>
            <h2 class="section-title">
                Enterprise AI Scale &amp; <span class="text-gradient">Live Architecture Nodes</span>
            </h2>
            <p class="section-desc center" style="margin-bottom: 0.85rem;">
                Interact with our production scale and verified engineering milestones. Drag, flick, toss, and stack any node freely across the canvas.
            </p>
            <div class="drag-hud-actions-inline">
                <button type="button" id="reset-drag-btn" class="quick-pill-btn" title="Reset node positions">
                    <i class="fa-solid fa-rotate-left"></i> <span>Reset Card Positions</span>
                </button>
            </div>
        </div>

        <!-- Interactive Draggable Constraints Stage (DragElements Container - Borderless Full Screen) -->
        <div class="drag-elements-stage" id="drag-elements-container">
            <div class="drag-grid-overlay"></div>
            <div class="drag-ambient-glow"></div>

                <!-- 1. Draggable Card: 10+ Years Enterprise -->
                <div class="drag-item drag-card corner-bracket-wrap" data-index="0" style="left: 4%; top: 12%;">
                    <div class="drag-card-glow-border"></div>
                    <div class="drag-card-header">
                        <span class="drag-badge cyan"><i class="fa-solid fa-map-location-dot"></i> INDIA AI HUBS</span>
                        <div class="drag-handle-dots"><i class="fa-solid fa-grip-vertical"></i></div>
                    </div>
                    <div class="drag-card-body">
                        <div class="drag-stat-num text-gradient">10+</div>
                        <h4 class="drag-card-title">Years Enterprise Engineering</h4>
                        <p class="drag-card-sub">Chennai HQ Lab with high-tech delivery pods in Bangalore, Hyderabad &amp; Coimbatore.</p>
                        <div class="drag-card-footer">
                            <span class="drag-mini-tag">4 Delivery Hubs</span>
                            <span class="drag-mini-tag">ISO 27001</span>
                        </div>
                    </div>
                </div>

                <!-- 2. Draggable Card: 85+ AI & ML Systems -->
                <div class="drag-item drag-card corner-bracket-wrap" data-index="1" style="left: 36%; top: 6%;">
                    <div class="drag-card-glow-border magenta"></div>
                    <div class="drag-card-header">
                        <span class="drag-badge magenta"><i class="fa-solid fa-brain"></i> PRODUCTION SCALE</span>
                        <div class="drag-handle-dots"><i class="fa-solid fa-grip-vertical"></i></div>
                    </div>
                    <div class="drag-card-body">
                        <div class="drag-stat-num text-gradient-magenta">85+</div>
                        <h4 class="drag-card-title">AI Systems Deployed</h4>
                        <p class="drag-card-sub">Fine-tuned LLMs, Enterprise RAG systems &amp; autonomous workflow agents in production.</p>
                        <div class="drag-card-footer">
                            <span class="drag-mini-tag"><i class="fa-solid fa-check"></i> Zero Data Leakage</span>
                            <span class="drag-mini-tag"><i class="fa-solid fa-lock"></i> Private Cloud VPC</span>
                        </div>
                    </div>
                </div>

                <!-- 3. Draggable Card: 99.8% SLA & Accuracy -->
                <div class="drag-item drag-card corner-bracket-wrap" data-index="2" style="left: 68%; top: 10%;">
                    <div class="drag-card-glow-border green"></div>
                    <div class="drag-card-header">
                        <span class="drag-badge green"><i class="fa-solid fa-shield-halved"></i> RELIABILITY SLA</span>
                        <div class="drag-handle-dots"><i class="fa-solid fa-grip-vertical"></i></div>
                    </div>
                    <div class="drag-card-body">
                        <div class="drag-stat-num text-gradient-green">99.8%</div>
                        <h4 class="drag-card-title">Model Accuracy &amp; Uptime</h4>
                        <p class="drag-card-sub">Real-time MLOps telemetry, continuous drift monitoring &amp; automated fallback failovers.</p>
                        <div class="drag-card-footer">
                            <span class="drag-mini-tag">Sub-100ms Inference</span>
                            <span class="drag-mini-tag">24/7 SLA Ops</span>
                        </div>
                    </div>
                </div>

                <!-- 4. Draggable Card: 15+ Core Industries -->
                <div class="drag-item drag-card corner-bracket-wrap" data-index="3" style="left: 52%; top: 52%;">
                    <div class="drag-card-glow-border blue"></div>
                    <div class="drag-card-header">
                        <span class="drag-badge blue"><i class="fa-solid fa-building-columns"></i> DOMAIN EXPERTISE</span>
                        <div class="drag-handle-dots"><i class="fa-solid fa-grip-vertical"></i></div>
                    </div>
                    <div class="drag-card-body">
                        <div class="drag-stat-num text-gradient-blue">15+</div>
                        <h4 class="drag-card-title">Industries Transformed</h4>
                        <p class="drag-card-sub">Clinical Healthcare, Banking &amp; FinTech, Autonomous Fleet Logistics, Retail &amp; PropTech.</p>
                        <div class="drag-card-footer">
                            <span class="drag-mini-tag">HIPAA &amp; SOC 2</span>
                            <span class="drag-mini-tag">Turnkey Engineering</span>
                        </div>
                    </div>
                </div>

                <!-- 5. Draggable Pill Badge: Voicebot Node -->
                <div class="drag-item drag-pill" data-index="4" style="left: 6%; top: 62%;">
                    <div class="drag-pill-icon cyan"><i class="fa-solid fa-microphone-lines"></i></div>
                    <div class="drag-pill-info">
                        <strong>Multilingual Voicebots</strong>
                        <span>25+ Indic Languages · sub-400ms Audio Latency</span>
                    </div>
                    <div class="drag-pill-arrow"><i class="fa-solid fa-arrow-right"></i></div>
                </div>

                <!-- 6. Draggable Pill Badge: Computer Vision Node -->
                <div class="drag-item drag-pill" data-index="5" style="left: 26%; top: 75%;">
                    <div class="drag-pill-icon magenta"><i class="fa-solid fa-eye"></i></div>
                    <div class="drag-pill-info">
                        <strong>YOLOv10 Vision AI</strong>
                        <span>60 FPS Defect Vision &amp; Retinal Scan OCR</span>
                    </div>
                    <div class="drag-pill-arrow"><i class="fa-solid fa-arrow-right"></i></div>
                </div>

                <!-- 7. Draggable Pill Badge: Cost Efficiency Chip -->
                <div class="drag-item drag-pill" data-index="6" style="left: 72%; top: 66%;">
                    <div class="drag-pill-icon green"><i class="fa-solid fa-coins"></i></div>
                    <div class="drag-pill-info">
                        <strong>60% Cost Efficiency</strong>
                        <span>Global Standards vs US/EU · 100% IP Ownership</span>
                    </div>
                    <div class="drag-pill-arrow"><i class="fa-solid fa-arrow-right"></i></div>
                </div>

                <!-- 8. Draggable Pill Badge: LangGraph Agent Node -->
                <div class="drag-item drag-pill" data-index="7" style="left: 18%; top: 44%;">
                    <div class="drag-pill-icon blue"><i class="fa-solid fa-network-wired"></i></div>
                    <div class="drag-pill-info">
                        <strong>Autonomous Agents</strong>
                        <span>LangGraph &amp; Llama 3.1 Function-Calling Copilots</span>
                    </div>
                    <div class="drag-pill-arrow"><i class="fa-solid fa-arrow-right"></i></div>
                </div>

            </div>
        </div>
</section>
