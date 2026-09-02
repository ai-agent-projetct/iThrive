<?php
/**
 * iThrive AI - Section 3: Liquid Glass Carousel Component (Framer liquid-glass-carousel-SkrkTr)
 * Path: sections/awards-strip.php
 */
?>
<section class="section-padding liquid-glass-section" style="padding-top: 3.5rem; padding-bottom: 5rem; position: relative; overflow: hidden;">
    <div class="container">
        <!-- Section Header -->
        <div style="text-align: center; max-width: 780px; margin: 0 auto 2.5rem;">
            <div class="section-tag">
                <span class="dot"></span>
                <span>ENTERPRISE ACCREDITATIONS</span>
            </div>
            <h2 class="section-title">
                Certified AI Partner &amp; <span class="text-gradient">Security Benchmarks</span>
            </h2>
            <p class="section-desc center">
                Engineered with certified cloud frameworks, NVIDIA GPU clusters, and ISO/SOC 2 Type II governance standards. Drag, scroll or use controls to inspect our credentials through the optical liquid glass lens.
            </p>
        </div>

        <!-- WebGL Three.js Optical Liquid Glass Carousel Stage -->
        <div class="liquid-glass-wrapper corner-bracket-wrap">
            <div class="corner-bracket-bottom-left"></div>
            <div class="corner-bracket-bottom-right"></div>
            
            <!-- Live Active Partner Info HUD -->
            <div class="liquid-info-hud">
                <div class="liquid-hud-badge"><i class="fa-solid fa-certificate"></i> CERTIFIED ENTERPRISE CREDENTIAL</div>
                <h3 id="liquid-partner-title" class="liquid-partner-title">AWS Certified AI &amp; ML Partner</h3>
                <p id="liquid-partner-desc" class="liquid-partner-desc">High-throughput AWS Bedrock foundation models, SageMaker distributed clusters &amp; P5 GPU clusters.</p>
            </div>

            <!-- WebGL Canvas Container -->
            <div id="liquid-glass-stage" class="liquid-glass-stage"></div>

            <!-- Controls Row -->
            <div class="liquid-controls-bar">
                <button class="liquid-nav-btn" id="liquid-btn-prev" aria-label="Previous Partner">
                    <i class="fa-solid fa-arrow-left"></i>
                </button>
                
                <div class="liquid-dots-wrap" id="liquid-dots">
                    <span class="liquid-dot active" data-index="0"></span>
                    <span class="liquid-dot" data-index="1"></span>
                    <span class="liquid-dot" data-index="2"></span>
                    <span class="liquid-dot" data-index="3"></span>
                    <span class="liquid-dot" data-index="4"></span>
                    <span class="liquid-dot" data-index="5"></span>
                </div>

                <div class="liquid-counter-badge" id="liquid-counter">
                    01 / 06
                </div>

                <button class="liquid-nav-btn" id="liquid-btn-next" aria-label="Next Partner">
                    <i class="fa-solid fa-arrow-right"></i>
                </button>
            </div>
        </div>
    </div>
</section>
