<?php
/**
 * The assistant's answer book — 70 questions Ithrive answers, and nothing else.
 *
 * This is the demo agent's entire world. A question that matches an entry here
 * gets that answer; anything else gets the demo boundary reply and an offer to
 * connect a human. That is deliberate: a demo that answers everything proves
 * nothing about a grounded agent, and a demo that invents an answer is worse
 * than one that declines.
 *
 * Each entry carries:
 *   id    stable identifier, used in logs and tests
 *   cat   category slug, see FAQ_CATEGORIES
 *   q     the canonical question, in English
 *   a     the answer, written to be *spoken* as well as read — no markdown
 *         bullets, because the TTS layer reads this text aloud verbatim
 *   terms extra matching vocabulary that does not appear in the question
 *
 * Questions arrive in six languages. Rather than storing six translations of
 * every question — 350 fixed strings that only match if the visitor phrases it
 * exactly the way we guessed — FAQ_LEXICON maps the vocabulary of each language
 * onto the English terms below. That matches paraphrases too, which is what
 * people actually type.
 */

declare(strict_types=1);

const FAQ_CATEGORIES = [
    'engagement'   => 'General Business & Engagement Models',
    'ai-native'    => 'AI-First & AI-Native Product Development',
    'ai-assistant' => 'AI Enablement & AI Integrated Assistants',
    'apps'         => 'Mobile App & Web Development',
    'ecommerce'    => 'E-Commerce Development & AI for Retail',
    'saas'         => 'Micro SaaS, POC & MVP Development',
    'modernise'    => 'Digital Product Engineering, Modernization & ERP',
    'cloud'        => 'Cloud, DevOps & Infrastructure',
    'growth'       => 'Ideation, Business Growth & ROI Strategy',
];

const FAQ = [

    // ---- 1. General business & engagement models --------------------------

    [
        'id' => 'q1', 'cat' => 'engagement',
        'q' => 'What makes Ithrive Software different from traditional IT outsourcing agencies?',
        'a' => 'Ithrive operates on an AI-First and AI-Native product development paradigm. Rather than '
             . 'writing code manually line by line, we use AI agent swarms and generative workflows to '
             . 'design, write, test and deploy code three to five times faster, combined with strict '
             . 'senior engineer oversight on every change.',
        'terms' => 'different difference outsourcing agency competitor unique better why choose vendor',
    ],
    [
        'id' => 'q2', 'cat' => 'engagement',
        'q' => 'What engagement models does Ithrive offer?',
        'a' => 'Three. Fixed-price project, best for MVPs and proofs of concept with well-defined scope. '
             . 'Dedicated engineering team, a complete managed team of developers, designers, QA, project '
             . 'manager and AI engineers working exclusively on your product. And dedicated on-demand '
             . 'resources, where you scale specialised individual roles such as an LLM prompt engineer or '
             . 'a React developer on a monthly or hourly basis.',
        'terms' => 'engagement model hire contract fixed price dedicated team on demand resources options',
    ],
    [
        'id' => 'q3', 'cat' => 'engagement',
        'q' => 'What is the average timeline to hire and onboard a dedicated engineering team?',
        'a' => 'Three to seven business days for developers from our existing stack pools, and ten to '
             . 'fourteen days for specialised AI and machine learning roles.',
        'terms' => 'onboard onboarding hire timeline how long team start ramp up days',
    ],
    [
        'id' => 'q4', 'cat' => 'engagement',
        'q' => 'How does Ithrive protect client intellectual property and data?',
        'a' => 'Every engagement signs a strict non-disclosure agreement and a master services agreement. '
             . 'One hundred percent of the code, the IP rights and the trained AI models belong to you. '
             . 'Private LLM deployments are isolated, so your data is never used to train public '
             . 'foundation models.',
        'terms' => 'ip intellectual property data protection nda msa agreement sign security '
                 . 'confidential ownership own code privacy legal contract',
    ],
    [
        'id' => 'q5', 'cat' => 'engagement',
        'q' => 'Can Ithrive work with startups that only have an idea written on paper?',
        'a' => 'Yes. Through the Idea-to-Words to Product workflow we take raw thoughts, napkin sketches '
             . 'or a verbal brief, run them through rapid discovery workshops, and produce interactive UI '
             . 'wireframes, technical specifications and a prototype within days.',
        'terms' => 'startup idea paper napkin early stage founder just an idea concept begin no spec',
    ],
    [
        'id' => 'q6', 'cat' => 'engagement',
        'q' => 'How does Ithrive manage communication across different time zones?',
        'a' => 'Teams use asynchronous tools — Slack, Jira, GitHub and Notion — alongside daily or weekly '
             . 'overlapping synchronous standups. Each client gets a dedicated scrum master or product '
             . 'manager as a single point of contact.',
        'terms' => 'communication time zone timezone remote offshore standup meeting reporting contact',
    ],
    [
        'id' => 'q7', 'cat' => 'engagement',
        'q' => 'Does Ithrive provide post-launch maintenance and support?',
        'a' => 'Yes. We offer SLA-backed maintenance packages covering server and cloud monitoring, bug '
             . 'fixes, third-party API updates, LLM cost optimisation and feature enhancements.',
        'terms' => 'maintenance support post launch after launch sla warranty bug fix ongoing amc',
    ],

    // ---- 2. AI-First & AI-Native product development -----------------------

    [
        'id' => 'q8', 'cat' => 'ai-native',
        'q' => 'What is the difference between AI-First and AI-Native product development?',
        'a' => 'AI-First refers to the development process itself: using AI tools and agent swarms across '
             . 'ideation, design, coding, testing and deployment to build software about fifty percent '
             . 'faster. AI-Native refers to the architecture of the product: core functionality relies '
             . 'intrinsically on AI models — adaptive UI, predictive logic, autonomous agents — rather '
             . 'than attaching a chatbot as an afterthought.',
        'terms' => 'ai first ai native difference meaning definition architecture paradigm',
    ],
    [
        'id' => 'q9', 'cat' => 'ai-native',
        'q' => 'How much does it cost to build a full AI-Native product from scratch?',
        'a' => 'A basic AI-Native app or MVP is fifteen to thirty-five thousand dollars. A mid-tier '
             . 'commercial platform is thirty-five to eighty thousand. An enterprise AI ecosystem is '
             . 'eighty thousand to two hundred thousand and above.',
        'terms' => 'cost price budget how much ai native product scratch build dollars quote pricing',
    ],
    [
        'id' => 'q10', 'cat' => 'ai-native',
        'q' => 'What is the typical development timeline for an AI-Native product?',
        'a' => 'A proof of concept takes one to three weeks. An MVP takes four to eight weeks. A full '
             . 'production release takes twelve to twenty weeks.',
        'terms' => 'timeline how long duration weeks schedule delivery ai native',
    ],
    [
        'id' => 'q11', 'cat' => 'ai-native',
        'q' => 'How does Ithrive prevent AI hallucinations in business applications?',
        'a' => 'By deploying retrieval-augmented generation pipelines, deterministic fallback rules, '
             . 'continuous evaluation benchmarks such as Ragas and TruLens, and human-in-the-loop '
             . 'approval steps wherever sensitive data is involved.',
        'terms' => 'hallucination accuracy wrong answer reliability rag guardrail trust evaluation',
    ],
    [
        'id' => 'q12', 'cat' => 'ai-native',
        'q' => 'What AI stack does Ithrive use?',
        'a' => 'Models: OpenAI GPT-4o, Anthropic Claude 3.5 Sonnet, Llama 3, Mistral and Google Gemini. '
             . 'Frameworks and orchestration: LangChain, LlamaIndex, AutoGen and CrewAI. Vector '
             . 'databases: Pinecone, Qdrant, Weaviate and Pgvector.',
        'terms' => 'ai stack model llm framework vector database langchain openai claude tools technology',
    ],
    [
        'id' => 'q13', 'cat' => 'ai-native',
        'q' => 'What are the recurring API and compute costs for running an AI-Native product?',
        'a' => 'Monthly LLM compute and API costs range from about fifty dollars a month for an '
             . 'early-stage MVP on pay-as-you-go APIs, to fifteen hundred to five thousand dollars a '
             . 'month and above for heavy-traffic enterprise applications. We implement caching with '
             . 'GPTCache and semantic routing, which cuts token costs by up to sixty percent.',
        'terms' => 'recurring cost monthly api compute token running cost opex inference bill',
    ],
    [
        'id' => 'q14', 'cat' => 'ai-native',
        'q' => 'How does an AI-First product increase company valuation for startups seeking investors?',
        'a' => 'AI-Native products scale exponentially with lower headcount, deliver higher gross '
             . 'margins, build proprietary data moats, and offer personalised user retention that '
             . 'traditional static software cannot match.',
        'terms' => 'valuation investor funding vc raise startup value multiple moat margin',
    ],
    [
        'id' => 'q15', 'cat' => 'ai-native',
        'q' => 'Can Ithrive build autonomous AI agents that execute complex tasks independently?',
        'a' => 'Yes. We build multi-agent workflows on CrewAI and LangGraph capable of reading emails, '
             . 'processing documents, querying databases, running calculations and updating external '
             . 'systems without human intervention.',
        'terms' => 'autonomous agent agentic multi agent workflow automation independent execute tasks',
    ],
    [
        'id' => 'q16', 'cat' => 'ai-native',
        'q' => 'Is open-source AI like Llama 3 better than proprietary AI like OpenAI for my product?',
        'a' => 'Open-source models such as Llama or Mistral are ideal if you need strict data privacy, '
             . 'zero third-party API dependencies, or want to host locally on private cloud servers. '
             . 'Proprietary models such as OpenAI or Claude are ideal for complex reasoning, rapid MVP '
             . 'launches and zero GPU infrastructure overhead.',
        'terms' => 'open source proprietary llama mistral openai claude self host compare which model better',
    ],

    // ---- 3. AI enablement & integrated assistants --------------------------

    [
        'id' => 'q17', 'cat' => 'ai-assistant',
        'q' => 'What is AI Enablement for existing products?',
        'a' => 'It is the process of retrofitting established web or mobile software with intelligent '
             . 'features — predictive analytics, automated reporting, semantic search or conversational '
             . 'workflows — without rebuilding the core platform.',
        'terms' => 'ai enablement existing product retrofit add ai legacy upgrade integrate intelligence',
    ],
    [
        'id' => 'q18', 'cat' => 'ai-assistant',
        'q' => 'How can a business implement an AI integrated assistant immediately?',
        'a' => 'Three low-friction integration paths. Embeddable widgets, where you drop a light '
             . 'JavaScript snippet into your web app. A RAG knowledge base, connecting internal '
             . 'databases, Notion or PDFs to a vector engine. Or an API proxy, placing an AI layer '
             . 'between your existing frontend and backend services in ten to fourteen days.',
        'terms' => 'implement assistant quickly immediately integration widget embed fastest path deploy',
    ],
    [
        'id' => 'q19', 'cat' => 'ai-assistant',
        'q' => 'How much does it cost to build and integrate a custom AI assistant?',
        'a' => 'A basic AI assistant doing RAG over your business documents is five to twelve thousand '
             . 'dollars. An advanced assistant that executes actions through API integrations is twelve '
             . 'to twenty-five thousand.',
        'terms' => 'cost price assistant chatbot how much build integrate custom budget',
    ],
    [
        'id' => 'q20', 'cat' => 'ai-assistant',
        'q' => 'How long does it take to deploy an operational custom AI assistant?',
        'a' => 'A functional pilot takes two to three weeks. Full system integration takes four to six '
             . 'weeks.',
        'terms' => 'how long deploy assistant chatbot timeline weeks pilot launch build make create',
    ],
    [
        'id' => 'q21', 'cat' => 'ai-assistant',
        'q' => 'What tasks can an AI assistant handle for internal staff or end customers?',
        'a' => 'Customer support, automated ticket resolution, contract and document summarisation, '
             . 'database querying in natural language through text-to-SQL, dynamic scheduling, and '
             . 'personalised product recommendations.',
        'terms' => 'tasks assistant capabilities what can it do support ticket summarise schedule staff',
    ],
    [
        'id' => 'q22', 'cat' => 'ai-assistant',
        'q' => 'Can the AI assistant act on behalf of the user, such as booking an appointment or changing an order?',
        'a' => 'Yes. Through function calling and API tool binding the assistant can trigger backend '
             . 'actions securely, after validating the user’s authorisation.',
        'terms' => 'act on behalf book appointment change order take action function calling agent do things',
    ],
    [
        'id' => 'q23', 'cat' => 'ai-assistant',
        'q' => 'How does Ithrive train an AI assistant on private company data?',
        'a' => 'Rather than fine-tuning models from scratch, which is expensive and goes stale, we use '
             . 'retrieval-augmented generation. Private data is vectorised and retrieved dynamically, '
             . 'which guarantees real-time accuracy and zero leakage into external LLMs.',
        'terms' => 'train private data company documents fine tune rag knowledge base internal confidential',
    ],
    [
        'id' => 'q24', 'cat' => 'ai-assistant',
        'q' => 'How do we measure the ROI of an integrated AI assistant?',
        'a' => 'Reduction in support ticket volume, typically forty to seventy percent. Faster response '
             . 'time, seconds instead of hours. Improved customer retention. And hours saved per employee '
             . 'each week.',
        'terms' => 'roi return on investment measure metrics kpi payback benefit savings justify',
    ],

    // ---- 4. Mobile app & web development -----------------------------------

    [
        'id' => 'q25', 'cat' => 'apps',
        'q' => 'What tech stacks does Ithrive use for mobile app development?',
        'a' => 'Cross-platform: Flutter and React Native, for faster time to market from a single '
             . 'codebase across iOS and Android. Native: Swift for iOS and Kotlin for Android, for '
             . 'hardware-intensive applications.',
        'terms' => 'mobile stack technology flutter react native swift kotlin ios android cross platform',
    ],
    [
        'id' => 'q26', 'cat' => 'apps',
        'q' => 'What is the cost and timeline for developing a cross-platform mobile app?',
        'a' => 'A simple mobile app MVP is ten to twenty-two thousand dollars over six to eight weeks. '
             . 'Medium complexity is twenty-two to forty-five thousand over ten to fourteen weeks. An '
             . 'enterprise mobile platform is forty-five to ninety thousand and above, over sixteen to '
             . 'twenty-four weeks.',
        'terms' => 'mobile app cost price timeline how much how long android ios build budget weeks',
    ],
    [
        'id' => 'q27', 'cat' => 'apps',
        'q' => 'Does Ithrive handle Apple App Store and Google Play Store submissions?',
        'a' => 'Yes. We manage the entire process: developer account setup, store guideline compliance, '
             . 'assets, privacy disclosures and handling the approval reviews.',
        'terms' => 'app store play store submission publish release apple google review approval upload',
    ],
    [
        'id' => 'q28', 'cat' => 'apps',
        'q' => 'What frameworks does Ithrive use for modern web development?',
        'a' => 'Frontend: React, Next.js, Vue, TypeScript and Tailwind CSS. Backend: Node.js, Python with '
             . 'FastAPI or Django, Go, PostgreSQL and MongoDB.',
        'terms' => 'web framework frontend backend react next vue node python stack technology',
    ],
    [
        'id' => 'q29', 'cat' => 'apps',
        'q' => 'How much does custom web application development cost?',
        'a' => 'A startup web app MVP is eight to eighteen thousand dollars. A complex SaaS web '
             . 'application is twenty to sixty thousand.',
        'terms' => 'web app cost price how much website application development budget saas',
    ],
    [
        'id' => 'q30', 'cat' => 'apps',
        'q' => 'Why is React recommended for product development?',
        'a' => 'React gives you a modular component-based architecture, exceptional performance through '
             . 'the virtual DOM, a massive ecosystem and fast rendering — which suits high-growth SaaS '
             . 'products and AI dashboards.',
        'terms' => 'react why recommended benefit advantage javascript library frontend choose',
    ],
    [
        'id' => 'q31', 'cat' => 'apps',
        'q' => 'How does Ithrive ensure web and mobile apps are responsive and fast?',
        'a' => 'Server-side rendering with Next.js, automated code splitting, image optimisation, edge '
             . 'CDN distribution and rigorous Lighthouse performance auditing.',
        'terms' => 'performance fast speed responsive optimisation load time lighthouse seo core web vitals',
    ],
    [
        'id' => 'q32', 'cat' => 'apps',
        'q' => 'Can Ithrive build offline-first mobile applications?',
        'a' => 'Yes, using local databases such as SQLite, WatermelonDB or Hive, with automatic '
             . 'synchronisation engines that push data to the cloud once connectivity returns.',
        'terms' => 'offline first no internet sync local database connectivity field app',
    ],

    // ---- 5. E-commerce & retail AI -----------------------------------------

    [
        'id' => 'q33', 'cat' => 'ecommerce',
        'q' => 'What AI solutions does Ithrive offer specifically for e-commerce?',
        'a' => 'Personalised product recommendation engines, visual search where the shopper searches by '
             . 'photo, AI virtual try-ons, dynamic pricing algorithms, automated cataloguing and tagging, '
             . 'and twenty-four-seven conversational sales assistants.',
        'terms' => 'ecommerce ai retail recommendation visual search try on dynamic pricing shop store online',
    ],
    [
        'id' => 'q34', 'cat' => 'ecommerce',
        'q' => 'What platforms does Ithrive build e-commerce solutions on?',
        'a' => 'Headless e-commerce with Next.js and the Shopify Storefront API, custom Node.js or Python '
             . 'e-commerce engines, Shopify Plus, and WooCommerce.',
        'terms' => 'ecommerce platform shopify woocommerce headless magento which platform store',
    ],
    [
        'id' => 'q35', 'cat' => 'ecommerce',
        'q' => 'How much does an AI-powered e-commerce platform cost to develop?',
        'a' => 'A custom Shopify or headless storefront with basic AI is twelve to twenty-five thousand '
             . 'dollars. A custom AI e-commerce marketplace is thirty to seventy-five thousand.',
        'terms' => 'ecommerce cost price how much online store marketplace budget shop',
    ],
    [
        'id' => 'q36', 'cat' => 'ecommerce',
        'q' => 'What is the development timeline for an e-commerce platform?',
        'a' => 'Standard e-commerce setups take four to eight weeks. Custom AI marketplaces take twelve '
             . 'to sixteen weeks.',
        'terms' => 'ecommerce timeline how long weeks delivery store marketplace',
    ],
    [
        'id' => 'q37', 'cat' => 'ecommerce',
        'q' => 'How does an AI sales assistant increase e-commerce conversion rates?',
        'a' => 'It interacts with shoppers like an in-store consultant — answering sizing questions, '
             . 'cross-selling matching items and offering targeted discounts to abandoners — which '
             . 'typically raises conversion by fifteen to thirty percent.',
        'terms' => 'conversion rate sales assistant increase revenue cart abandonment upsell shopper',
    ],
    [
        'id' => 'q38', 'cat' => 'ecommerce',
        'q' => 'Can Ithrive integrate custom payment gateways and multi-currency support?',
        'a' => 'Yes. Complete integrations with Stripe, PayPal, Razorpay, Adyen, Apple Pay and crypto '
             . 'gateways, with real-time multi-currency conversion.',
        'terms' => 'payment gateway stripe paypal razorpay currency checkout integrate multi currency',
    ],
    [
        'id' => 'q39', 'cat' => 'ecommerce',
        'q' => 'Can Ithrive automate product description generation and SEO tagging for large catalogues?',
        'a' => 'Yes. We build automated LLM pipelines that ingest raw product specifications and images '
             . 'and generate SEO-optimised descriptions, metadata and alt tags across thousands of SKUs '
             . 'in minutes.',
        'terms' => 'product description seo tag catalogue sku automate generate content bulk listing',
    ],

    // ---- 6. Micro SaaS, POC & MVP ------------------------------------------

    [
        'id' => 'q40', 'cat' => 'saas',
        'q' => 'What is a Micro SaaS, and why build one with Ithrive?',
        'a' => 'A Micro SaaS is a lean, focused software product targeting a niche problem with minimal '
             . 'operational overhead. We build them in two to four weeks using pre-built AI modules and '
             . 'boilerplate architectures.',
        'terms' => 'micro saas what is niche small product lean subscription indie',
    ],
    [
        'id' => 'q41', 'cat' => 'saas',
        'q' => 'How much does it cost to build a Micro SaaS?',
        'a' => 'Five to fifteen thousand dollars, depending on feature scope and third-party API '
             . 'dependencies.',
        'terms' => 'micro saas cost price how much budget',
    ],
    [
        'id' => 'q42', 'cat' => 'saas',
        'q' => 'What is the timeline for Micro SaaS development?',
        'a' => 'Two to five weeks from initial scope to live deployment.',
        'terms' => 'micro saas timeline how long weeks delivery',
    ],
    [
        'id' => 'q43', 'cat' => 'saas',
        'q' => 'What is the difference between a proof of concept and a minimum viable product?',
        'a' => 'A POC tests technical feasibility — can this specific AI or algorithm actually work. An '
             . 'MVP tests market viability — will users interact with, and pay for, a functional core '
             . 'version of the product.',
        'terms' => 'poc mvp difference proof of concept minimum viable product prototype meaning compare',
    ],
    [
        'id' => 'q44', 'cat' => 'saas',
        'q' => 'How much does POC development cost, and how long does it take?',
        'a' => 'Three to eight thousand dollars, over one to two weeks.',
        'terms' => 'poc cost price timeline how much how long proof of concept',
    ],
    [
        'id' => 'q45', 'cat' => 'saas',
        'q' => 'How much does MVP development cost, and how long does it take?',
        'a' => 'Ten to twenty-five thousand dollars, over four to eight weeks.',
        'terms' => 'mvp cost price timeline how much how long minimum viable product',
    ],
    [
        'id' => 'q46', 'cat' => 'saas',
        'q' => 'What key components are included in an Ithrive MVP delivery?',
        'a' => 'User authentication, the core functionality, payment and subscription integration through '
             . 'Stripe, a basic admin dashboard, analytics tracking, clean UI and UX, and a scalable '
             . 'cloud hosting setup.',
        'terms' => 'mvp includes deliverable scope components what do i get features delivery',
    ],
    [
        'id' => 'q47', 'cat' => 'saas',
        'q' => 'How does Ithrive ensure an MVP does not accumulate massive technical debt?',
        'a' => 'Modular micro-service architecture, clean code standards, comprehensive TypeScript '
             . 'typing, automated CI/CD pipelines and scalable database schemas from day one.',
        'terms' => 'technical debt code quality maintainable refactor architecture standards scale later',
    ],

    // ---- 7. Modernisation & ERP --------------------------------------------

    [
        'id' => 'q48', 'cat' => 'modernise',
        'q' => 'What is product modernization?',
        'a' => 'Upgrading legacy monolithic applications into cloud-native, microservice-based, '
             . 'AI-enabled architectures — improving speed, security, UI, UX and scalability without '
             . 'losing the underlying business logic or data.',
        'terms' => 'modernization modernisation legacy monolith upgrade rewrite migrate what is',
    ],
    [
        'id' => 'q49', 'cat' => 'modernise',
        'q' => 'How much does it cost to build a custom ERP system or modernize a legacy platform?',
        'a' => 'A modular custom ERP for a small or medium business is thirty to seventy thousand '
             . 'dollars. Enterprise legacy modernisation or ERP is seventy thousand to a hundred and '
             . 'eighty thousand and above.',
        'terms' => 'erp cost price how much modernization legacy budget enterprise system',
    ],
    [
        'id' => 'q50', 'cat' => 'modernise',
        'q' => 'What is the timeline for an ERP development or product modernization project?',
        'a' => 'Phased rollouts typically span twelve to twenty-six weeks, which lets business operations '
             . 'keep running without downtime.',
        'terms' => 'erp timeline how long weeks modernization rollout phased delivery',
    ],
    [
        'id' => 'q51', 'cat' => 'modernise',
        'q' => 'How can AI be integrated into custom ERP software?',
        'a' => 'Intelligent inventory forecasting, automated invoice and receipt parsing with OCR and '
             . 'LLMs, predictive equipment maintenance alerts, and voice or chat query tools for '
             . 'operations managers.',
        'terms' => 'erp ai integrate inventory forecast invoice ocr predictive maintenance operations',
    ],
    [
        'id' => 'q52', 'cat' => 'modernise',
        'q' => 'Can Ithrive modernize legacy desktop software into a modern web cloud application?',
        'a' => 'Yes. We extract the underlying business logic and database schemas and re-architect them '
             . 'into modern web frameworks such as React and Node, hosted on AWS or GCP.',
        'terms' => 'desktop software legacy convert web cloud migrate vb access old application rewrite',
    ],
    [
        'id' => 'q53', 'cat' => 'modernise',
        'q' => 'How does Ithrive prevent downtime during software modernization?',
        'a' => 'Strangler fig migration patterns, shadow deployments, database replication and feature '
             . 'flags, so the new system rolls out incrementally alongside the legacy one.',
        'terms' => 'downtime migration risk cutover safe rollout zero downtime business continuity',
    ],
    [
        'id' => 'q54', 'cat' => 'modernise',
        'q' => 'What is digital product engineering at Ithrive?',
        'a' => 'A holistic engineering approach combining human-centred UI and UX design, cloud '
             . 'architecture, system security, automated QA, DevOps pipelines and continuous product '
             . 'evolution analytics.',
        'terms' => 'digital product engineering what is meaning approach holistic discipline',
    ],
    [
        'id' => 'q55', 'cat' => 'modernise',
        'q' => 'Does Ithrive help legacy businesses digitize paper-heavy workflows?',
        'a' => 'Yes, by deploying custom AI document processing pipelines that ingest physical PDFs, '
             . 'handwritten notes and images, extracting the unstructured data straight into digital SQL '
             . 'or NoSQL databases.',
        'terms' => 'paper digitize document processing ocr handwritten pdf scan manual workflow automate',
    ],

    // ---- 8. Cloud, DevOps & infrastructure ---------------------------------

    [
        'id' => 'q56', 'cat' => 'cloud',
        'q' => 'Which cloud platforms does Ithrive specialize in?',
        'a' => 'Amazon Web Services, Google Cloud Platform, Microsoft Azure, Vercel and Cloudflare.',
        'terms' => 'cloud platform aws gcp azure vercel cloudflare host hosting provider vendor '
                 . 'infrastructure services offering specialize',
    ],
    [
        'id' => 'q57', 'cat' => 'cloud',
        'q' => 'What DevOps services does Ithrive provide?',
        'a' => 'CI/CD pipeline setup with GitHub Actions or GitLab CI, containerisation with Docker and '
             . 'Kubernetes, infrastructure as code with Terraform, load balancing, auto-scaling and '
             . 'security auditing.',
        'terms' => 'devops services cicd docker kubernetes terraform pipeline automation infrastructure',
    ],
    [
        'id' => 'q58', 'cat' => 'cloud',
        'q' => 'How much does a cloud and DevOps setup cost for a new product?',
        'a' => 'Initial environment setup is two and a half to seven and a half thousand dollars. Monthly '
             . 'infrastructure management runs five hundred to two thousand dollars a month.',
        'terms' => 'devops cloud cost price how much setup monthly infrastructure budget',
    ],
    [
        'id' => 'q59', 'cat' => 'cloud',
        'q' => 'How does Ithrive ensure high availability and 99.99% uptime for AI applications?',
        'a' => 'Multi-region redundancy, serverless auto-scaling on AWS Lambda or Cloud Run, failover API '
             . 'endpoints and caching layers.',
        'terms' => 'uptime high availability reliability sla redundancy failover scale downtime',
    ],
    [
        'id' => 'q60', 'cat' => 'cloud',
        'q' => 'How do you control unpredictable server costs with AI workloads?',
        'a' => 'Model routing, which directs simple queries to cheap models such as GPT-4o-mini and '
             . 'complex ones to Claude 3.5 Sonnet, plus token limits, response caching and concurrency '
             . 'throttling.',
        'terms' => 'server cost control unpredictable bill token spend optimise cheaper reduce budget',
    ],
    [
        'id' => 'q61', 'cat' => 'cloud',
        'q' => 'What monitoring and observability tools are integrated into deployed products?',
        'a' => 'Datadog, Sentry for error tracking, Prometheus and Grafana, LogRocket, and specialised AI '
             . 'monitoring tools such as LangSmith and Helicone.',
        'terms' => 'monitoring observability logging alerting sentry datadog grafana tools errors',
    ],

    // ---- 9. Ideation, growth & ROI -----------------------------------------

    [
        'id' => 'q62', 'cat' => 'growth',
        'q' => 'What is the Idea-to-Words workflow at Ithrive?',
        'a' => 'It is our workshop process where business leaders explain their product vision in natural '
             . 'language. We use AI tools to break those words into user stories, technical architecture '
             . 'diagrams, database schemas and clickable wireframes within forty-eight to seventy-two '
             . 'hours.',
        'terms' => 'idea to words workflow workshop discovery process vision requirement gathering',
    ],
    [
        'id' => 'q63', 'cat' => 'growth',
        'q' => 'What software stack is best to rapidly launch and scale a new software business?',
        'a' => 'Next.js with React, Node.js or Python with FastAPI, PostgreSQL, Supabase or Firebase, '
             . 'Tailwind CSS, Vercel or AWS, and OpenAI or Claude APIs. That stack gives maximum speed, '
             . 'low starting cost and near-infinite scalability.',
        'terms' => 'best stack recommend launch scale startup technology choice architecture new business',
    ],
    [
        'id' => 'q64', 'cat' => 'growth',
        'q' => 'What kind of revenue growth can a business expect after developing an AI-integrated product?',
        'a' => 'It is market dependent, but businesses modernising with AI routinely report a thirty to '
             . 'fifty percent reduction in customer acquisition cost through automated personalised '
             . 'onboarding, two to four times expansion in lifetime value as AI features drive daily '
             . 'active engagement, and a forty to sixty percent reduction in operational serving costs.',
        'terms' => 'revenue growth expect results roi cac ltv business impact benefit numbers',
    ],
    [
        'id' => 'q65', 'cat' => 'growth',
        'q' => 'How does embedding an AI assistant accelerate user retention in software products?',
        'a' => 'An AI assistant lowers the learning curve. Users get instant answers and complete actions '
             . 'through conversation rather than navigating complex menus, which dramatically reduces '
             . 'onboarding drop-off.',
        'terms' => 'retention churn onboarding engagement assistant user adoption stickiness',
    ],
    [
        'id' => 'q66', 'cat' => 'growth',
        'q' => 'Is it better to build custom software or buy off-the-shelf SaaS subscriptions?',
        'a' => 'Buy for standard administrative tasks — generic accounting such as QuickBooks. Build for '
             . 'your core value proposition, unique workflows, customer-facing interactions and '
             . 'proprietary data processes, because those are your competitive moat.',
        'terms' => 'build vs buy custom software off the shelf saas subscription decide better which',
    ],
    [
        'id' => 'q67', 'cat' => 'growth',
        'q' => 'How does Ithrive help non-technical founders manage tech teams effectively?',
        'a' => 'Clear product roadmaps in plain language, transparent Jira tracking, weekly video demos '
             . 'of working software, and dedicated product managers who translate business goals into '
             . 'developer tasks.',
        'terms' => 'non technical founder manage team cto oversight roadmap tracking demo plain language',
    ],
    [
        'id' => 'q68', 'cat' => 'growth',
        'q' => 'What steps should a business take today to start a project with Ithrive?',
        'a' => 'Four steps. Schedule an initial discovery call. Take part in a two-day Idea-to-Words '
             . 'architecture review. Receive a detailed proposal with fixed milestone pricing and a '
             . 'project timeline. Then kick off development within five business days.',
        'terms' => 'how to start begin next step get started onboard process first step engage today',
    ],
    [
        'id' => 'q69', 'cat' => 'growth',
        'q' => 'Can Ithrive assist with product pitch decks and technical documentation for investor fundraising?',
        'a' => 'Yes. We build functional interactive click-dummies, system architecture diagrams, '
             . 'technical whitepapers and ROI projection models that founders present to angel investors '
             . 'and VCs.',
        'terms' => 'pitch deck investor fundraising documentation whitepaper diagram prototype demo vc angel',
    ],
    [
        'id' => 'q70', 'cat' => 'growth',
        'q' => 'What is the long-term competitive advantage of building an AI-First product with Ithrive today?',
        'a' => 'Software is shifting from static tools to dynamic, learning platforms. Building AI-First '
             . 'today means your platform continuously captures data, learns user preferences, automates '
             . 'internal costs and stays ahead of competitors still running legacy systems.',
        'terms' => 'competitive advantage long term future why now strategy ahead moat legacy competitors',
    ],
];
