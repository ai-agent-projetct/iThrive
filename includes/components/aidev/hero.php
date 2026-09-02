<?php
/**
 * iThrive AI - ChainGPT-Style Hero Section with Interactive 3D Robot & Prompt Bar
 * Path: sections/hero.php
 */
?>
<section id="hero" class="hero-section">
    <!-- Background Canvas Mesh & Glow Orbs -->
    <canvas id="hero-mesh-canvas" class="hero-bg-canvas"></canvas>
    <div class="hero-ambient-glow hero-glow-1"></div>
    <div class="hero-ambient-glow hero-glow-2"></div>

    <?php /* The robot owns the whole section rather than a panel in the corner:
             he stands behind the copy, and the pointer drives him from anywhere
             over it. See assets/js/aidev/spline-robot.js. */ ?>
    <div id="spline-robot" class="spline-robot"
         data-runtime="<?= e(asset('assets/vendor/spline/spline-runtime.js')) ?>"
         data-scene="<?= e(asset('assets/vendor/spline/robot.splinecode')) ?>">
        <span class="spline-robot-wash" aria-hidden="true"></span>
        <canvas aria-label="Interactive 3D robot that follows your cursor"></canvas>
    </div>

    <div class="container">
        <div class="hero-grid-layout">
            <!-- Left Hero Content -->
            <div class="hero-content">
                <!-- Live Ticker -->
                <div class="hero-ticker-box">
                    <div class="ticker-pulse"></div>
                    <span id="hero-ticker-target" class="ticker-text">
                        BUILD A CUSTOM ENTERPRISE LLM &amp; RAG AGENT
                    </span>
                </div>

                <!-- H1 Headline -->
                <h1 class="hero-h1">
                    Unleash the Power of <br>
                    <span class="text-gradient">Artificial Intelligence</span>
                </h1>

                <p class="hero-subhead">
                    India’s leading <strong>AI Development Company</strong> engineering production-grade Large Language Models, Generative AI pipelines, Autonomous Agentic workflows, Computer Vision, and 3D web systems for high-growth enterprises worldwide.
                </p>

                <!-- ChainGPT Interactive Prompt Bar -->
                <div class="hero-prompt-bar">
                    <input type="text" id="hero-prompt-input" class="hero-prompt-input" placeholder="Ask AI: What solution do you want to build? (e.g. Healthcare RAG, Vision OCR...)" onkeydown="if(event.key==='Enter'){event.preventDefault();submitHeroPrompt();}">
                    <button type="button" class="hero-prompt-btn" onclick="submitHeroPrompt()">
                        <span>Generate Plan</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </div>

                <!-- Quick Prompt Selector Pills -->
                <div class="hero-prompt-pills">
                    <span class="prompt-pill" onclick="setHeroPrompt('Build an enterprise RAG pipeline on proprietary PDFs')">
                        <i class="fa-solid fa-bolt" style="color: var(--accent-cyan);"></i> Enterprise RAG
                    </span>
                    <span class="prompt-pill" onclick="setHeroPrompt('Fine-tune custom Llama 3.1 for private healthcare compliance')">
                        <i class="fa-solid fa-brain" style="color: var(--accent-blue);"></i> Fine-Tune LLM
                    </span>
                    <span class="prompt-pill" onclick="setHeroPrompt('Deploy real-time optical defect detection in manufacturing')">
                        <i class="fa-solid fa-eye" style="color: var(--accent-violet);"></i> Vision OCR
                    </span>
                    <span class="prompt-pill" onclick="setHeroPrompt('Build multilingual voicebot in 25+ Indian languages')">
                        <i class="fa-solid fa-headset" style="color: var(--accent-magenta);"></i> Voicebot
                    </span>
                </div>

                <!-- Main CTA Buttons -->
                <div class="hero-cta-group">
                    <a href="#contact" class="btn btn-primary btn-lg">
                        <span>Book Free AI Consultation</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                    <button onclick="openVideoModal('<?= e(asset('videos/aidev/ai_healthcare.mp4')) ?>', 'iThrive Enterprise AI Diagnostics &amp; Autonomous Workflows')" class="btn btn-secondary btn-lg">
                        <i class="fa-solid fa-circle-play" style="color: var(--accent-magenta); font-size: 1.25rem;"></i>
                        <span>Watch AI Demo</span>
                    </button>
                </div>

                <!-- India Hub City Badges -->
                <div>
                    <div style="font-size: 0.8rem; color: var(--text-muted); font-family: var(--font-mono); margin-bottom: 0.6rem; text-transform: uppercase; letter-spacing: 0.05em;">
                        <i class="fa-solid fa-network-wired" style="color: var(--accent-cyan);"></i> Engineering Centers &amp; Delivery Hubs:
                    </div>
                    <div class="hero-location-badges">
                        <span class="loc-badge"><i class="fa-solid fa-location-dot" style="color: var(--accent-cyan);"></i> Chennai HQ</span>
                        <span class="loc-badge"><i class="fa-solid fa-location-dot" style="color: var(--accent-blue);"></i> Bangalore</span>
                        <span class="loc-badge"><i class="fa-solid fa-location-dot" style="color: var(--accent-violet);"></i> Hyderabad</span>
                        <span class="loc-badge"><i class="fa-solid fa-location-dot" style="color: var(--accent-magenta);"></i> Coimbatore</span>
                        <span class="loc-badge"><i class="fa-solid fa-globe" style="color: #10B981;"></i> USA &amp; UK Delivery</span>
                    </div>
                </div>
            </div>

            <?php /* The right-hand panel is gone: the robot is no longer a
                     picture beside the copy, he is the room it stands in. Its
                     caption survives as a marker at the foot of the section. */ ?>
        </div>

        <div class="robot-hud-tag robot-hud-tag--floating">
            <span class="robot-status-dot"></span>
            <span>iThrive AI Cognitive Robot · 360° Interactive Gaze Active</span>
        </div>
    </div>
</section>

<script>
function setHeroPrompt(text) {
    const input = document.getElementById('hero-prompt-input');
    if (input) {
        input.value = text;
        input.focus();
    }
}
function submitHeroPrompt() {
    const input = document.getElementById('hero-prompt-input');
    const val = input ? input.value.trim() : '';
    if (val && window.TNChat) {
        window.TNChat.open();
        const chatInput = document.getElementById('tn-input');
        if (chatInput) {
            chatInput.value = val;
            window.TNChat.send();
        }
    } else {
        const contactSection = document.getElementById('contact');
        if (contactSection) contactSection.scrollIntoView({ behavior: 'smooth' });
    }
}
</script>
