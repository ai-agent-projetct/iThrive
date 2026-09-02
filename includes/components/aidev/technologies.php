<?php
/**
 * iThrive AI - Section 5: Interactive Technologies Grid (OriginKit Interactive Grid Base Preset)
 * Path: sections/technologies.php
 */
?>
<section id="technologies" class="section-padding interactive-grid-section">
    <div class="container">
        <!-- Section Header -->
        <div style="text-align: center; max-width: 820px; margin: 0 auto 2.75rem;">
            <div class="section-tag">
                <span class="dot"></span>
                <span>INTERACTIVE ENGINEERING ECOSYSTEM</span>
            </div>
            <h2 class="section-title">
                Technologies &amp; <span class="text-gradient">Toolchains We Master</span>
            </h2>
            <p class="section-desc center">
                Move your cursor over the interactive matrix to illuminate neural frameworks, private foundation models, vector databases, and accelerated inference runtimes.
            </p>
        </div>

        <!-- Filter Tabs -->
        <div class="tech-tabs-wrapper">
            <div class="tech-tabs">
                <button class="tech-tab-btn active" data-filter="all">
                    <i class="fa-solid fa-layer-group"></i>
                    <span>All Technologies</span>
                </button>
                <button class="tech-tab-btn" data-filter="genai">
                    <i class="fa-solid fa-brain"></i>
                    <span>Generative AI &amp; LLMs</span>
                </button>
                <button class="tech-tab-btn" data-filter="frameworks">
                    <i class="fa-solid fa-microchip"></i>
                    <span>ML &amp; Frameworks</span>
                </button>
                <button class="tech-tab-btn" data-filter="vision">
                    <i class="fa-solid fa-eye"></i>
                    <span>Vision &amp; Speech</span>
                </button>
                <button class="tech-tab-btn" data-filter="vectordb">
                    <i class="fa-solid fa-database"></i>
                    <span>Vector Databases</span>
                </button>
                <button class="tech-tab-btn" data-filter="cloud">
                    <i class="fa-solid fa-cloud"></i>
                    <span>Cloud &amp; MLOps</span>
                </button>
            </div>
        </div>

        <!-- Interactive Grid Container with Mouse Spotlight Proximity Glow -->
        <div class="interactive-grid-container" id="interactive-tech-grid">
            <div class="grid-spotlight-glow" id="grid-spotlight"></div>
            
            <div class="tech-grid">
                
                <!-- 1. Generative AI & LLMs -->
                <div class="tech-card interactive-cell" data-category="genai">
                    <div class="tech-icon"><i class="fa-solid fa-brain" style="color: var(--accent-cyan);"></i></div>
                    <div class="tech-name">Meta Llama 3.1</div>
                    <div class="tech-cat">Open Foundation LLM</div>
                </div>

                <div class="tech-card interactive-cell" data-category="genai">
                    <div class="tech-icon"><i class="fa-solid fa-atom" style="color: var(--accent-blue);"></i></div>
                    <div class="tech-name">DeepSeek V2.5 &amp; R1</div>
                    <div class="tech-cat">Reasoning &amp; Code LLM</div>
                </div>

                <div class="tech-card interactive-cell" data-category="genai">
                    <div class="tech-icon"><i class="fa-solid fa-robot" style="color: var(--accent-magenta);"></i></div>
                    <div class="tech-name">Claude &amp; GPT-4o</div>
                    <div class="tech-cat">Frontier Multimodal APIs</div>
                </div>

                <div class="tech-card interactive-cell" data-category="genai">
                    <div class="tech-icon"><i class="fa-solid fa-network-wired" style="color: var(--accent-violet);"></i></div>
                    <div class="tech-name">LangGraph &amp; Agents</div>
                    <div class="tech-cat">Cognitive Multi-Agent Graphs</div>
                </div>

                <div class="tech-card interactive-cell" data-category="genai">
                    <div class="tech-icon"><i class="fa-solid fa-face-smile-wink" style="color: #FFD21E;"></i></div>
                    <div class="tech-name">Hugging Face</div>
                    <div class="tech-cat">Transformers &amp; Hub</div>
                </div>

                <div class="tech-card interactive-cell" data-category="genai">
                    <div class="tech-icon"><i class="fa-solid fa-bolt" style="color: var(--accent-cyan);"></i></div>
                    <div class="tech-name">vLLM &amp; Triton</div>
                    <div class="tech-cat">High-Throughput Inference</div>
                </div>

                <!-- 2. ML & Frameworks -->
                <div class="tech-card interactive-cell" data-category="frameworks">
                    <div class="tech-icon"><i class="fa-brands fa-python" style="color: #3776AB;"></i></div>
                    <div class="tech-name">Python 3.12</div>
                    <div class="tech-cat">Core AI Language</div>
                </div>

                <div class="tech-card interactive-cell" data-category="frameworks">
                    <div class="tech-icon"><i class="fa-solid fa-fire-flame-curved" style="color: #EE4C2C;"></i></div>
                    <div class="tech-name">PyTorch 2.x</div>
                    <div class="tech-cat">Deep Learning Engine</div>
                </div>

                <div class="tech-card interactive-cell" data-category="frameworks">
                    <div class="tech-icon"><i class="fa-solid fa-diagram-project" style="color: #FF6F00;"></i></div>
                    <div class="tech-name">TensorFlow</div>
                    <div class="tech-cat">Neural Framework</div>
                </div>

                <div class="tech-card interactive-cell" data-category="frameworks">
                    <div class="tech-icon"><i class="fa-solid fa-microchip" style="color: #76B900;"></i></div>
                    <div class="tech-name">NVIDIA TensorRT</div>
                    <div class="tech-cat">Edge Hardware Acceleration</div>
                </div>

                <div class="tech-card interactive-cell" data-category="frameworks">
                    <div class="tech-icon"><i class="fa-solid fa-cubes" style="color: #4285F4;"></i></div>
                    <div class="tech-name">JAX &amp; Flax</div>
                    <div class="tech-cat">High-Performance AutoDiff</div>
                </div>

                <div class="tech-card interactive-cell" data-category="frameworks">
                    <div class="tech-icon"><i class="fa-solid fa-arrows-spin" style="color: #005CED;"></i></div>
                    <div class="tech-name">ONNX Runtime</div>
                    <div class="tech-cat">Cross-Platform Execution</div>
                </div>

                <!-- 3. Vision & Speech -->
                <div class="tech-card interactive-cell" data-category="vision">
                    <div class="tech-icon"><i class="fa-solid fa-eye" style="color: var(--accent-cyan);"></i></div>
                    <div class="tech-name">YOLOv10 &amp; OpenCV</div>
                    <div class="tech-cat">Real-Time Object Vision</div>
                </div>

                <div class="tech-card interactive-cell" data-category="vision">
                    <div class="tech-icon"><i class="fa-solid fa-microphone-lines" style="color: #10B981;"></i></div>
                    <div class="tech-name">OpenAI Whisper</div>
                    <div class="tech-cat">Speech-to-Text Audio</div>
                </div>

                <div class="tech-card interactive-cell" data-category="vision">
                    <div class="tech-icon"><i class="fa-solid fa-wand-magic-sparkles" style="color: var(--accent-magenta);"></i></div>
                    <div class="tech-name">Stable Diffusion 3</div>
                    <div class="tech-cat">Image &amp; Video Generation</div>
                </div>

                <div class="tech-card interactive-cell" data-category="vision">
                    <div class="tech-icon"><i class="fa-solid fa-volume-high" style="color: #3B82F6;"></i></div>
                    <div class="tech-name">ElevenLabs Voice AI</div>
                    <div class="tech-cat">Neural Voice Synthesis</div>
                </div>

                <div class="tech-card interactive-cell" data-category="vision">
                    <div class="tech-icon"><i class="fa-solid fa-vector-square" style="color: #00C4CC;"></i></div>
                    <div class="tech-name">SAM 2 Vision</div>
                    <div class="tech-cat">Segment Anything Masks</div>
                </div>

                <div class="tech-card interactive-cell" data-category="vision">
                    <div class="tech-icon"><i class="fa-solid fa-file-invoice" style="color: #F59E0B;"></i></div>
                    <div class="tech-name">PaddleOCR &amp; DocAI</div>
                    <div class="tech-cat">Document Intelligence</div>
                </div>

                <!-- 4. Vector Databases -->
                <div class="tech-card interactive-cell" data-category="vectordb">
                    <div class="tech-icon"><i class="fa-solid fa-database" style="color: var(--accent-blue);"></i></div>
                    <div class="tech-name">Pinecone</div>
                    <div class="tech-cat">Managed Vector Database</div>
                </div>

                <div class="tech-card interactive-cell" data-category="vectordb">
                    <div class="tech-icon"><i class="fa-solid fa-server" style="color: var(--accent-violet);"></i></div>
                    <div class="tech-name">Milvus &amp; Qdrant</div>
                    <div class="tech-cat">Distributed Vector Search</div>
                </div>

                <div class="tech-card interactive-cell" data-category="vectordb">
                    <div class="tech-icon"><i class="fa-solid fa-hard-drive" style="color: #336791;"></i></div>
                    <div class="tech-name">pgvector</div>
                    <div class="tech-cat">PostgreSQL Vector Search</div>
                </div>

                <div class="tech-card interactive-cell" data-category="vectordb">
                    <div class="tech-icon"><i class="fa-solid fa-layer-group" style="color: #10B981;"></i></div>
                    <div class="tech-name">Weaviate</div>
                    <div class="tech-cat">Semantic Vector Graph</div>
                </div>

                <div class="tech-card interactive-cell" data-category="vectordb">
                    <div class="tech-icon"><i class="fa-solid fa-circle-nodes" style="color: #FFD21E;"></i></div>
                    <div class="tech-name">ChromaDB</div>
                    <div class="tech-cat">Local Embedding Store</div>
                </div>

                <div class="tech-card interactive-cell" data-category="vectordb">
                    <div class="tech-icon"><i class="fa-solid fa-network-wired" style="color: #0081FB;"></i></div>
                    <div class="tech-name">FAISS (Meta AI)</div>
                    <div class="tech-cat">Dense Vector Indexing</div>
                </div>

                <!-- 5. Cloud & MLOps -->
                <div class="tech-card interactive-cell" data-category="cloud">
                    <div class="tech-icon"><i class="fa-brands fa-aws" style="color: #FF9900;"></i></div>
                    <div class="tech-name">AWS Bedrock &amp; SageMaker</div>
                    <div class="tech-cat">Cloud GPU Infrastructure</div>
                </div>

                <div class="tech-card interactive-cell" data-category="cloud">
                    <div class="tech-icon"><i class="fa-brands fa-microsoft" style="color: #00A4EF;"></i></div>
                    <div class="tech-name">Azure OpenAI &amp; ML</div>
                    <div class="tech-cat">Enterprise Cloud AI</div>
                </div>

                <div class="tech-card interactive-cell" data-category="cloud">
                    <div class="tech-icon"><i class="fa-brands fa-google" style="color: #4285F4;"></i></div>
                    <div class="tech-name">Google Vertex AI</div>
                    <div class="tech-cat">Gemini Model Ecosystem</div>
                </div>

                <div class="tech-card interactive-cell" data-category="cloud">
                    <div class="tech-icon"><i class="fa-brands fa-docker" style="color: #2496ED;"></i></div>
                    <div class="tech-name">Kubernetes &amp; MLflow</div>
                    <div class="tech-cat">MLOps Orchestration</div>
                </div>

                <div class="tech-card interactive-cell" data-category="cloud">
                    <div class="tech-icon"><i class="fa-solid fa-chart-pie" style="color: #FFBE00;"></i></div>
                    <div class="tech-name">Weights &amp; Biases</div>
                    <div class="tech-cat">Experiment Tracking</div>
                </div>

                <div class="tech-card interactive-cell" data-category="cloud">
                    <div class="tech-icon"><i class="fa-solid fa-sun" style="color: #028CF0;"></i></div>
                    <div class="tech-name">Ray &amp; vLLM Cluster</div>
                    <div class="tech-cat">Distributed GPU Clusters</div>
                </div>

            </div>
        </div>
    </div>
</section>
