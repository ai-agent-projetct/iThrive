<?php
/**
 * iThrive AI - Featured Case Studies Grid
 * Path: sections/case-studies.php
 */
?>
<section id="case-studies" class="section-padding">
    <div class="container">
        <!-- Section Header -->
        <div style="text-align: center; max-width: 820px; margin: 0 auto 4rem;">
            <div class="section-tag">
                <span class="dot"></span>
                <span>PROVEN TRACK RECORD</span>
            </div>
            <h2 class="section-title">
                Featured <span class="text-gradient">Case Studies &amp; Impact</span>
            </h2>
            <p class="section-desc center">
                Explore how we have engineered production AI systems that drive measurable efficiency gains, clinical diagnostic accuracy, and enterprise scalability.
            </p>
        </div>

        <!-- Case Studies Grid -->
        <div class="case-studies-grid">
            
            <!-- 1. Lotus Eye Hospital AI -->
            <div class="case-card corner-bracket-wrap">
                <div class="case-preview-wrap">
                    <video autoplay muted loop playsinline poster="<?= e(asset('assets/img/aidev/case-study-medical-ai.jpg')) ?>">
                        <source src="<?= e(asset('videos/aidev/ai_healthcare.mp4')) ?>" type="video/mp4">
                    </video>
                    <span class="case-tag-badge">HEALTHCARE AI</span>
                </div>
                <div class="case-body">
                    <div>
                        <h3 class="case-title">Lotus Eye Hospital AI Diagnostic System</h3>
                        <p style="font-size: 0.88rem; color: var(--text-muted); line-height: 1.5;">
                            High-precision retinal scan segmentation and automated patient triage engine reducing specialist review time by 68%.
                        </p>
                    </div>
                    <div>
                        <div class="case-result-pill">
                            <i class="fa-solid fa-arrow-trend-up"></i> 99.4% Diagnostic Accuracy
                        </div>
                        <div style="margin-top: 1rem;">
                            <button onclick="openVideoModal('<?= e(asset('videos/aidev/ai_healthcare.mp4')) ?>', 'Lotus Eye Hospital - AI Clinical Triage Demo')" class="btn btn-secondary btn-sm" style="width: 100%;">
                                <i class="fa-solid fa-play"></i> Watch Case Study
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. Vetora Telematics AI -->
            <div class="case-card corner-bracket-wrap">
                <div class="case-preview-wrap">
                    <video autoplay muted loop playsinline poster="<?= e(asset('assets/img/aidev/case-study-fleet-ai.jpg')) ?>">
                        <source src="<?= e(asset('videos/aidev/taxi_ai.mp4')) ?>" type="video/mp4">
                    </video>
                    <span class="case-tag-badge">LOGISTICS &amp; MOBILITY</span>
                </div>
                <div class="case-body">
                    <div>
                        <h3 class="case-title">Vetora Predictive Fleet Telematics</h3>
                        <p style="font-size: 0.88rem; color: var(--text-muted); line-height: 1.5;">
                            Real-time AI engine for vehicle maintenance anomaly alerts, driver safety scoring, and dynamic multi-point routing.
                        </p>
                    </div>
                    <div>
                        <div class="case-result-pill">
                            <i class="fa-solid fa-arrow-trend-up"></i> 24% Fuel Cost Savings
                        </div>
                        <div style="margin-top: 1rem;">
                            <button onclick="openVideoModal('<?= e(asset('videos/aidev/taxi_ai.mp4')) ?>', 'Vetora - Autonomous Fleet Telematics AI')" class="btn btn-secondary btn-sm" style="width: 100%;">
                                <i class="fa-solid fa-play"></i> Watch Case Study
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. Pakka Local AI -->
            <div class="case-card corner-bracket-wrap">
                <div class="case-preview-wrap">
                    <video autoplay muted loop playsinline poster="<?= e(asset('assets/img/aidev/case-study-voice-ai.jpg')) ?>">
                        <source src="<?= e(asset('videos/aidev/foodtime.mp4')) ?>" type="video/mp4">
                    </video>
                    <span class="case-tag-badge">E-COMMERCE &amp; RETAIL</span>
                </div>
                <div class="case-body">
                    <div>
                        <h3 class="case-title">Pakka Local Hyperlocal Commerce AI</h3>
                        <p style="font-size: 0.88rem; color: var(--text-muted); line-height: 1.5;">
                            Conversational voice-driven ordering assistant and dynamic predictive merchant inventory balancing for urban micro-hubs.
                        </p>
                    </div>
                    <div>
                        <div class="case-result-pill">
                            <i class="fa-solid fa-arrow-trend-up"></i> 3.4x Conversion Growth
                        </div>
                        <div style="margin-top: 1rem;">
                            <button onclick="openVideoModal('<?= e(asset('videos/aidev/foodtime.mp4')) ?>', 'Pakka Local - Conversational Ordering AI')" class="btn btn-secondary btn-sm" style="width: 100%;">
                                <i class="fa-solid fa-play"></i> Watch Case Study
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 4. Cute Crew Multimodal App -->
            <div class="case-card corner-bracket-wrap">
                <div class="case-preview-wrap">
                    <video autoplay muted loop playsinline poster="<?= e(asset('assets/img/aidev/case-study-biotech-ai.jpg')) ?>">
                        <source src="<?= e(asset('videos/aidev/meetoo_dating.mp4')) ?>" type="video/mp4">
                    </video>
                    <span class="case-tag-badge">BIOTECH &amp; AI</span>
                </div>
                <div class="case-body">
                    <div>
                        <h3 class="case-title">AstraBio Genomic AI Synthesis Platform</h3>
                        <p style="font-size: 0.88rem; color: var(--text-muted); line-height: 1.5;">
                            High-throughput protein folding models, molecular docking simulations, and automated clinical trial biomarker analysis.
                        </p>
                    </div>
                    <div>
                        <div class="case-result-pill">
                            <i class="fa-solid fa-arrow-trend-up"></i> 4.8x Discovery Velocity
                        </div>
                        <div style="margin-top: 1rem;">
                            <button onclick="openVideoModal('<?= e(asset('videos/aidev/meetoo_dating.mp4')) ?>', 'AstraBio - Genomic AI & Protein Folding')" class="btn btn-secondary btn-sm" style="width: 100%;">
                                <i class="fa-solid fa-play"></i> Watch Case Study
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 5. Coonoor Club Luxury Hospitality -->
            <div class="case-card corner-bracket-wrap">
                <div class="case-preview-wrap">
                    <video autoplay muted loop playsinline poster="<?= e(asset('assets/img/aidev/resource-developer-workbench.jpg')) ?>">
                        <source src="<?= e(asset('videos/aidev/foodtime.mp4')) ?>" type="video/mp4">
                    </video>
                    <span class="case-tag-badge">HOSPITALITY AI</span>
                </div>
                <div class="case-body">
                    <div>
                        <h3 class="case-title">Coonoor Club Elite AI Concierge</h3>
                        <p style="font-size: 0.88rem; color: var(--text-muted); line-height: 1.5;">
                            Bespoke multilingual reservation bot with VIP preference memory, dining recommendation engines, and member portal.
                        </p>
                    </div>
                    <div>
                        <div class="case-result-pill">
                            <i class="fa-solid fa-arrow-trend-up"></i> 98% Satisfaction Score
                        </div>
                        <div style="margin-top: 1rem;">
                            <button onclick="openVideoModal('<?= e(asset('videos/aidev/foodtime.mp4')) ?>', 'Coonoor Club - AI Concierge Platform')" class="btn btn-secondary btn-sm" style="width: 100%;">
                                <i class="fa-solid fa-play"></i> Watch Case Study
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 6. Digital Office 3D Workspace -->
            <div class="case-card corner-bracket-wrap">
                <div class="case-preview-wrap">
                    <video autoplay muted loop playsinline poster="<?= e(asset('assets/img/aidev/industry-smartcity-ai.jpg')) ?>">
                        <source src="<?= e(asset('videos/aidev/ai_healthcare.mp4')) ?>" type="video/mp4">
                    </video>
                    <span class="case-tag-badge">3D WEB &amp; AGENTS</span>
                </div>
                <div class="case-body">
                    <div>
                        <h3 class="case-title">Digital Office 3D Intelligent Workspace</h3>
                        <p style="font-size: 0.88rem; color: var(--text-muted); line-height: 1.5;">
                            Immersive WebGL 3D virtual office space integrated with autonomous AI co-pilots executing task management and data queries.
                        </p>
                    </div>
                    <div>
                        <div class="case-result-pill">
                            <i class="fa-solid fa-arrow-trend-up"></i> 40% Productivity Lift
                        </div>
                        <div style="margin-top: 1rem;">
                            <button onclick="openVideoModal('<?= e(asset('videos/aidev/ai_healthcare.mp4')) ?>', 'Digital Office 3D - Interactive AI Workspaces')" class="btn btn-secondary btn-sm" style="width: 100%;">
                                <i class="fa-solid fa-play"></i> Watch Case Study
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
