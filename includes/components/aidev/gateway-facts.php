<?php
/**
 * iThrive AI - Gateway Quick-Facts Row
 * Path: sections/gateway-facts.php
 */
?>
<section class="section-padding" style="padding-top: 0; padding-bottom: 4rem;">
    <div class="container">
        <div class="glass-panel corner-bracket-wrap" style="padding: 3rem 2.5rem; border: 1px solid rgba(34, 211, 238, 0.25); background: radial-gradient(circle at center, rgba(34, 211, 238, 0.08) 0%, rgba(11, 14, 28, 0.95) 75%); position: relative;">
            <div class="corner-bracket-bottom-left"></div>
            <div class="corner-bracket-bottom-right"></div>

            <div style="display: grid; grid-template-columns: 1.2fr 1fr; gap: 3rem; align-items: center;">
                
                <!-- Left: 3 Gateway Stats -->
                <div>
                    <div class="section-tag" style="margin-bottom: 1.5rem;">
                        <span class="dot"></span>
                        <span>HUMAN EXPERTISE + MACHINE INTELLIGENCE</span>
                    </div>
                    <h3 style="font-size: 1.85rem; margin-bottom: 2rem; color: #FFF;">
                        Bridging <span class="text-gradient">Deep Neural Research</span> &amp; Production Scale
                    </h3>

                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; text-align: left;">
                        <div style="border-left: 2px solid var(--accent-cyan); padding-left: 1rem;">
                            <div style="font-size: 2.2rem; font-weight: 800; font-family: var(--font-heading);" class="text-gradient">12+</div>
                            <div style="font-size: 0.82rem; color: var(--text-secondary); margin-top: 0.25rem;">
                                <strong>ML Frameworks</strong><br>PyTorch, vLLM, LangGraph
                            </div>
                        </div>

                        <div style="border-left: 2px solid var(--accent-blue); padding-left: 1rem;">
                            <div style="font-size: 2.2rem; font-weight: 800; font-family: var(--font-heading);" class="text-gradient">85+</div>
                            <div style="font-size: 0.82rem; color: var(--text-secondary); margin-top: 0.25rem;">
                                <strong>AI Systems</strong><br>Shipped in Production
                            </div>
                        </div>

                        <div style="border-left: 2px solid var(--accent-magenta); padding-left: 1rem;">
                            <div style="font-size: 2.2rem; font-weight: 800; font-family: var(--font-heading);" class="text-gradient">4 Hubs</div>
                            <div style="font-size: 0.82rem; color: var(--text-secondary); margin-top: 0.25rem;">
                                <strong>India AI Labs</strong><br>Chennai, BLR, HYD, CBE
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: High-Tech Visual Image Showcase -->
                <div class="corner-bracket-wrap" style="position: relative; border-radius: 18px; overflow: hidden; border: 1px solid rgba(34, 211, 238, 0.35); box-shadow: 0 20px 50px rgba(0, 0, 0, 0.8), 0 0 35px rgba(34, 211, 238, 0.2);">
                    <img src="<?= e(asset('assets/img/aidev/human-with-tech-engineer.jpg')) ?>" alt="iThrive AI Research Scientist with Holographic Neural Networks" style="width: 100%; height: 260px; object-fit: cover; display: block;">
                    <div style="position: absolute; bottom: 0; left: 0; right: 0; padding: 1rem 1.25rem; background: linear-gradient(0deg, rgba(5, 6, 15, 0.95) 0%, transparent 100%); display: flex; align-items: center; justify-content: space-between;">
                        <span style="font-family: var(--font-mono); font-size: 0.76rem; color: var(--accent-cyan);"><i class="fa-solid fa-atom"></i> iThrive AI Neural Research Lab</span>
                        <span style="font-family: var(--font-mono); font-size: 0.72rem; color: #10B981;"><i class="fa-solid fa-circle-check"></i> Active Telemetry</span>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
