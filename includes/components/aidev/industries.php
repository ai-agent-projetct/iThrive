<?php
/**
 * iThrive AI - Section 6: Industries We Transform (OriginKit Rotunda Carousel)
 * Path: sections/industries.php
 */
?>
<section id="industries" class="section-fullscreen-16-9 rotunda-section">
    <div class="container-16-9">
        <!-- Section Header & Quick-Switch Pills inside 16:9 Container -->
        <div class="section-header-16-9">
            <div style="text-align: center; margin-bottom: 0.65rem;">
                <div class="section-tag" style="margin-bottom: 0.35rem;">
                    <span class="dot"></span>
                    <span>DOMAIN EXPERTISE</span>
                </div>
                <h2 class="section-title" style="font-size: 1.85rem; margin-bottom: 0.35rem;">
                    Industries We Transform With <span class="text-gradient">Intelligent AI</span>
                </h2>
            </div>

            <!-- 6-Industry Quick-Switch Selector Pills -->
            <div class="quick-pills-bar" id="rotunda-industry-pills">
                <span class="quick-pill-btn active" data-index="0"><i class="fa-solid fa-heart-pulse"></i> 01 Healthcare</span>
                <span class="quick-pill-btn" data-index="1"><i class="fa-solid fa-chart-line"></i> 02 FinTech &amp; Banking</span>
                <span class="quick-pill-btn" data-index="2"><i class="fa-solid fa-cart-shopping"></i> 03 Retail &amp; Commerce</span>
                <span class="quick-pill-btn" data-index="3"><i class="fa-solid fa-industry"></i> 04 Manufacturing 4.0</span>
                <span class="quick-pill-btn" data-index="4"><i class="fa-solid fa-truck-fast"></i> 05 Fleet &amp; Logistics</span>
                <span class="quick-pill-btn" data-index="5"><i class="fa-solid fa-city"></i> 06 PropTech &amp; Cities</span>
            </div>

            <!-- Live Active Industry HUD Floating Card -->
            <div class="rotunda-info-card">
                <div class="rotunda-badge"><i class="fa-solid fa-brain"></i> PRODUCTION AI DEPLOYMENT</div>
                <h3 id="rotunda-hud-title" class="rotunda-hud-title">Healthcare &amp; Life Sciences</h3>
                <p id="rotunda-hud-desc" class="rotunda-hud-desc">AI retinal scan segmentation, MRI/CT pathology detection &amp; HIPAA clinical transcription.</p>
                <div class="rotunda-metric-row">
                    <span id="rotunda-hud-metric" class="rotunda-hud-metric"><i class="fa-solid fa-circle-check"></i> 99.4% Diagnostic Accuracy</span>
                    <a href="#contact" class="rotunda-action-btn">Deploy Architecture <i class="fa-solid fa-arrow-right"></i></a>
                </div>
            </div>
        </div>

        <?php /* The ring the carousel actually builds into. This shipped as an
                 empty <canvas id="rotunda-canvas">, which nothing in the CSS or
                 the JS has ever referred to — while rotunda-carousel.js looks
                 for #rotunda-3d-ring and the stylesheet fully dresses it. With
                 the canvas here the section rendered its pills and its heading
                 above 500px of nothing. This is a CSS 3D ring, not WebGL. */ ?>
        <div class="rotunda-carousel-container" id="rotunda-carousel-container">
            <div class="rotunda-3d-ring" id="rotunda-3d-ring"></div>
        </div>

        <!-- Bottom Controls -->
        <div class="rotunda-controls-bar">
            <button class="rotunda-nav-btn" id="rotunda-btn-prev" aria-label="Rotate Left">
                <i class="fa-solid fa-arrow-left"></i>
            </button>
            
            <div class="rotunda-hint-pill">
                <i class="fa-solid fa-hand-pointer"></i>
                <span>DRAG WALL OR CLICK PILLS TO ROTATE</span>
            </div>

            <div class="rotunda-counter" id="rotunda-hud-count">
                01 / 06
            </div>

            <button class="rotunda-nav-btn" id="rotunda-btn-next" aria-label="Rotate Right">
                <i class="fa-solid fa-arrow-right"></i>
            </button>
        </div>
    </div>
</section>
