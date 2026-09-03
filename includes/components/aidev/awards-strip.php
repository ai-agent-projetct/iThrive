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
                Engineered with certified cloud frameworks, NVIDIA GPU clusters, and ISO/SOC 2 Type II governance standards. Drag the gallery to bring any credential to the front.
            </p>
        </div>

        <!-- WebGL Three.js Optical Liquid Glass Carousel Stage -->
        <?php /*
            Framer's Cover Flow Gallery, running here as the component Framer
            publishes it — see app/originkit/src/components/framer. It is React,
            so it arrives through the island bundle: this div is the mount, and
            data-props is handed straight to the component.

            The six cards are the credentials this section has always listed.
            They are photographs of the subject matter, not certification marks:
            an ISO or SOC 2 badge drawn by an image model would be a claim to an
            accreditation rather than a picture of one.

            The old liquid-glass canvas and its HUD are gone with it. The HUD
            read from that carousel's index and would have sat on the first
            card's text for ever once the carousel underneath it changed.
        */ ?>
        <div class="liquid-glass-wrapper corner-bracket-wrap">
            <div class="corner-bracket-bottom-left"></div>
            <div class="corner-bracket-bottom-right"></div>

            <div class="coverflow-mount"
                 data-ok="coverflow-gallery"
                 data-props='<?= e(json_encode([
                     /* Designed cards, not photographs. Each is real markup
                        rendered at 520x660 — twice the gallery's 260x330, so the
                        type stays sharp — from tools/credential-cards.html. An
                        image model cannot set "ISO/IEC 27001" or "TensorRT"
                        without mangling them, and a credential card is mostly
                        words. The photographs those cards replaced now illustrate
                        the sections further down the page. */
                     'images' => array_map(
                         static fn (string $f): string => asset('assets/img/aidev/cards/' . $f . '.png'),
                         ['aws', 'microsoft', 'google', 'nvidia', 'security', 'hubs']
                     ),
                     'layout'  => ['cardWidth' => 260, 'cardHeight' => 330, 'gap' => 94, 'radius' => 18],
                     'depth'   => ['perspective' => 1200, 'rotation' => 45, 'scaleFalloff' => 4,
                                   'minScale' => 0.56, 'opacityFalloff' => 6, 'minOpacity' => 1,
                                   'brightnessFalloff' => 0.09],
                     /* 'drag' is the component's own default and the thing the
                        reference demonstrates — the nearest card glides to the
                        front as you pull across the stage. It is also load
                        bearing: the drag handlers are gated on this exact value,
                        so setting it to 'autoplay' silently turns dragging off,
                        which is most of the component. Opens on card three so the
                        fan is balanced rather than running off one side. */
                     'motionSettings' => ['interaction' => 'drag', 'activeIndex' => 2,
                                          'springPreset' => 'Bouncy', 'dragSensitivity' => 1],
                     'styleSettings'  => ['backgroundColor' => 'transparent', 'borderWidth' => 1,
                                          'borderColor' => 'rgba(0, 242, 254, 0.28)', 'shadow' => true,
                                          'shadowColor' => 'rgba(0, 0, 0, 0.65)', 'shadowBlur' => 44,
                                          'shadowY' => 20, 'activeGlow' => true,
                                          'glowColor' => 'rgba(0, 242, 254, 0.45)'],
                     'indicators'     => ['showDots' => true,
                                          'dotColor' => 'rgba(255, 255, 255, 0.28)',
                                          'dotActiveColor' => '#00F2FE'],
                 ], JSON_UNESCAPED_SLASHES)) ?>'>
            </div>

            <?php /* The credential names, which the gallery itself does not
                     carry — it shows pictures. Real markup either way, so a
                     crawler reads the list even though the cards are canvas-like
                     to it. */ ?>
            <ul class="coverflow-legend">
                <?php foreach ([
                    'Amazon Web Services',
                    'Microsoft Cloud',
                    'Google Cloud Platform',
                    'NVIDIA AI Ecosystem',
                    'Security &amp; Compliance',
                    'Chennai &amp; Bangalore Hubs',
                ] as $name): ?>
                    <li><?= $name ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</section>
