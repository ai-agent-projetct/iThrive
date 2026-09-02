<?php
/**
 * iThrive AI - 3-Column Blog & Insights Strip
 * Path: sections/blog-insights.php
 */
?>
<section id="blog" class="section-padding">
    <div class="container">
        <!-- Section Header -->
        <div style="text-align: center; max-width: 820px; margin: 0 auto 4rem;">
            <div class="section-tag">
                <span class="dot"></span>
                <span>KNOWLEDGE BASE &amp; INSIGHTS</span>
            </div>
            <h2 class="section-title">
                AI Engineering <span class="text-gradient">Insights &amp; Video Walkthroughs</span>
            </h2>
            <p class="section-desc center">
                Deep-dives into LLM fine-tuning techniques, vector database benchmarks, responsible AI governance, and live interactive video demos.
            </p>
        </div>

        <!-- 3-Column Strip -->
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem;">
            
            <!-- Col 1: AI Engineering Blog -->
            <div class="glass-panel corner-bracket-wrap" style="padding: 1.75rem;">
                <div style="position: relative; border-radius: 12px; overflow: hidden; margin-bottom: 1.25rem;">
                    <img src="<?= e(asset('assets/img/aidev/resource-developer-workbench.jpg')) ?>" alt="AI Research and Code Guides" style="width: 100%; height: 160px; object-fit: cover; display: block;">
                </div>
                <div style="font-family: var(--font-mono); font-size: 0.8rem; color: var(--accent-cyan); text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 0.75rem; display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fa-solid fa-newspaper"></i> Latest Technical Articles
                </div>
                <h3 style="font-size: 1.2rem; margin-bottom: 1.25rem;">AI Research &amp; Code Guides</h3>
                
                <div style="display: flex; flex-direction: column; gap: 1.25rem;">
                    <div style="border-bottom: 1px solid rgba(255, 255, 255, 0.06); padding-bottom: 1rem;">
                        <a href="#contact" style="font-weight: 600; font-size: 0.95rem; color: var(--text-primary); display: block; margin-bottom: 0.35rem;">
                            How to Fine-Tune Llama 3.1 with QLoRA for Zero Data Leakage
                        </a>
                        <span style="font-size: 0.78rem; color: var(--text-muted); font-family: var(--font-mono);">Engineering Guide · 8 min read</span>
                    </div>

                    <div style="border-bottom: 1px solid rgba(255, 255, 255, 0.06); padding-bottom: 1rem;">
                        <a href="#contact" style="font-weight: 600; font-size: 0.95rem; color: var(--text-primary); display: block; margin-bottom: 0.35rem;">
                            Vector DB Benchmark: Pinecone vs. Milvus vs. pgvector at 10M Scale
                        </a>
                        <span style="font-size: 0.78rem; color: var(--text-muted); font-family: var(--font-mono);">Architecture Benchmark · 11 min read</span>
                    </div>

                    <div>
                        <a href="#contact" style="font-weight: 600; font-size: 0.95rem; color: var(--text-primary); display: block; margin-bottom: 0.35rem;">
                            Building Autonomous Agents with LangGraph &amp; Function Calling
                        </a>
                        <span style="font-size: 0.78rem; color: var(--text-muted); font-family: var(--font-mono);">Agentic Systems · 7 min read</span>
                    </div>
                </div>
            </div>

            <!-- Col 2: Enterprise Deep-Dives -->
            <div class="glass-panel corner-bracket-wrap" style="padding: 1.75rem;">
                <div style="position: relative; border-radius: 12px; overflow: hidden; margin-bottom: 1.25rem;">
                    <img src="<?= e(asset('assets/img/aidev/case-study-biotech-ai.jpg')) ?>" alt="Clinical and Commercial Enterprise Impact" style="width: 100%; height: 160px; object-fit: cover; display: block;">
                </div>
                <div style="font-family: var(--font-mono); font-size: 0.8rem; color: var(--accent-blue); text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 0.75rem; display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fa-solid fa-microscope"></i> Enterprise Case Studies
                </div>
                <h3 style="font-size: 1.2rem; margin-bottom: 1.25rem;">Clinical &amp; Commercial Impact</h3>
                
                <div style="display: flex; flex-direction: column; gap: 1.25rem;">
                    <div style="border-bottom: 1px solid rgba(255, 255, 255, 0.06); padding-bottom: 1rem;">
                        <a href="#contact" style="font-weight: 600; font-size: 0.95rem; color: var(--text-primary); display: block; margin-bottom: 0.35rem;">
                            Reducing LLM Inference Token Costs by 65% Using Semantic Cache &amp; vLLM
                        </a>
                        <span style="font-size: 0.78rem; color: #10B981; font-family: var(--font-mono);">$42,000 / mo Saved</span>
                    </div>

                    <div style="border-bottom: 1px solid rgba(255, 255, 255, 0.06); padding-bottom: 1rem;">
                        <a href="#contact" style="font-weight: 600; font-size: 0.95rem; color: var(--text-primary); display: block; margin-bottom: 0.35rem;">
                            HIPAA Compliant Medical Image AI: Hospital Pilot Case Study
                        </a>
                        <span style="font-size: 0.78rem; color: #10B981; font-family: var(--font-mono);">99.4% Accuracy Verified</span>
                    </div>

                    <div>
                        <a href="#contact" style="font-weight: 600; font-size: 0.95rem; color: var(--text-primary); display: block; margin-bottom: 0.35rem;">
                            Automating 80% of Customer Logistics Queries with Multilingual Voicebots
                        </a>
                        <span style="font-size: 0.78rem; color: #10B981; font-family: var(--font-mono);">sub-400ms Voice Latency</span>
                    </div>
                </div>
            </div>

            <!-- Col 3: Video Demos -->
            <div class="glass-panel corner-bracket-wrap" style="padding: 1.75rem;">
                <div style="position: relative; border-radius: 12px; overflow: hidden; margin-bottom: 1.25rem;">
                    <img src="<?= e(asset('assets/img/aidev/frosted-glass-ui-icons.jpg')) ?>" alt="Live AI System Demonstrations & Design System" style="width: 100%; height: 160px; object-fit: cover; display: block;">
                </div>
                <div style="font-family: var(--font-mono); font-size: 0.8rem; color: var(--accent-magenta); text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 0.75rem; display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fa-solid fa-circle-play"></i> Video Demonstrations
                </div>
                <h3 style="font-size: 1.2rem; margin-bottom: 1.25rem;">Live AI System Demos</h3>
                
                <div style="display: flex; flex-direction: column; gap: 1.25rem;">
                    <div style="border-bottom: 1px solid rgba(255, 255, 255, 0.06); padding-bottom: 1rem;">
                        <button onclick="openVideoModal('<?= e(asset('videos/aidev/ai_healthcare.mp4')) ?>', 'Clinical Diagnosis AI Demo')" style="background: none; border: none; text-align: left; cursor: pointer; padding: 0;">
                            <div style="font-weight: 600; font-size: 0.95rem; color: var(--text-primary); margin-bottom: 0.35rem;">
                                <i class="fa-solid fa-play" style="color: var(--accent-magenta); margin-right: 0.4rem;"></i> Clinical Diagnostic AI &amp; Patient Segmentation Demo
                            </div>
                            <span style="font-size: 0.78rem; color: var(--text-muted); font-family: var(--font-mono);">Video Demo · 4:12 mins</span>
                        </button>
                    </div>

                    <div style="border-bottom: 1px solid rgba(255, 255, 255, 0.06); padding-bottom: 1rem;">
                        <button onclick="openVideoModal('<?= e(asset('videos/aidev/taxi_ai.mp4')) ?>', 'Fleet Telematics AI Demo')" style="background: none; border: none; text-align: left; cursor: pointer; padding: 0;">
                            <div style="font-weight: 600; font-size: 0.95rem; color: var(--text-primary); margin-bottom: 0.35rem;">
                                <i class="fa-solid fa-play" style="color: var(--accent-cyan); margin-right: 0.4rem;"></i> Autonomous Fleet Dispatch &amp; Telematics Video
                            </div>
                            <span style="font-size: 0.78rem; color: var(--text-muted); font-family: var(--font-mono);">Video Demo · 3:45 mins</span>
                        </button>
                    </div>

                    <div>
                        <button onclick="openVideoModal('<?= e(asset('videos/aidev/foodtime.mp4')) ?>', 'Multilingual Conversational Commerce AI Demo')" style="background: none; border: none; text-align: left; cursor: pointer; padding: 0;">
                            <div style="font-weight: 600; font-size: 0.95rem; color: var(--text-primary); margin-bottom: 0.35rem;">
                                <i class="fa-solid fa-play" style="color: var(--accent-blue); margin-right: 0.4rem;"></i> Multilingual Voicebot &amp; NLP Ordering Demo
                            </div>
                            <span style="font-size: 0.78rem; color: var(--text-muted); font-family: var(--font-mono);">Video Demo · 5:20 mins</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
