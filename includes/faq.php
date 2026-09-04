<?php
/**
 * The assistant's answer book — 70 questions iThrive answers, and nothing else.
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
    'ai-delivery'  => 'AI Development: Delivery, Cost, Compliance & Ownership',
    'page-faq'     => 'Answers Published on the Service Pages Themselves',
];

const FAQ = [

    // ---- 1. General business & engagement models --------------------------

    [
        'id' => 'q1', 'cat' => 'engagement',
        'q' => 'What makes iThrive Software different from traditional IT outsourcing agencies?',
        'a' => 'iThrive operates on an AI-First and AI-Native product development paradigm. Rather than '
             . 'writing code manually line by line, we use AI agent swarms and generative workflows to '
             . 'design, write, test and deploy code three to five times faster, combined with strict '
             . 'senior engineer oversight on every change.',
        'terms' => 'different difference outsourcing agency competitor unique better why choose vendor',
    ],
    [
        'id' => 'q2', 'cat' => 'engagement',
        'q' => 'What engagement models does iThrive offer?',
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
        'q' => 'How does iThrive protect client intellectual property and data?',
        'a' => 'Every engagement signs a strict non-disclosure agreement and a master services agreement. '
             . 'One hundred percent of the code, the IP rights and the trained AI models belong to you. '
             . 'Private LLM deployments are isolated, so your data is never used to train public '
             . 'foundation models.',
        'terms' => 'ip intellectual property data protection nda msa agreement sign security '
                 . 'confidential ownership own code privacy legal contract',
    ],
    [
        'id' => 'q5', 'cat' => 'engagement',
        'q' => 'Can iThrive work with startups that only have an idea written on paper?',
        'a' => 'Yes. Through the Idea-to-Words to Product workflow we take raw thoughts, napkin sketches '
             . 'or a verbal brief, run them through rapid discovery workshops, and produce interactive UI '
             . 'wireframes, technical specifications and a prototype within days.',
        'terms' => 'startup idea paper napkin early stage founder just an idea concept begin no spec',
    ],
    [
        'id' => 'q6', 'cat' => 'engagement',
        'q' => 'How does iThrive manage communication across different time zones?',
        'a' => 'Teams use asynchronous tools — Slack, Jira, GitHub and Notion — alongside daily or weekly '
             . 'overlapping synchronous standups. Each client gets a dedicated scrum master or product '
             . 'manager as a single point of contact.',
        'terms' => 'communication time zone timezone remote offshore standup meeting reporting contact',
    ],
    [
        'id' => 'q7', 'cat' => 'engagement',
        'q' => 'Does iThrive provide post-launch maintenance and support?',
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
        'q' => 'How does iThrive prevent AI hallucinations in business applications?',
        'a' => 'By deploying retrieval-augmented generation pipelines, deterministic fallback rules, '
             . 'continuous evaluation benchmarks such as Ragas and TruLens, and human-in-the-loop '
             . 'approval steps wherever sensitive data is involved.',
        'terms' => 'hallucination accuracy wrong answer reliability rag guardrail trust evaluation',
    ],
    [
        'id' => 'q12', 'cat' => 'ai-native',
        'q' => 'What AI stack does iThrive use?',
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
        'q' => 'Can iThrive build autonomous AI agents that execute complex tasks independently?',
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
        'q' => 'How does iThrive train an AI assistant on private company data?',
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
        'q' => 'What tech stacks does iThrive use for mobile app development?',
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
        'q' => 'Does iThrive handle Apple App Store and Google Play Store submissions?',
        'a' => 'Yes. We manage the entire process: developer account setup, store guideline compliance, '
             . 'assets, privacy disclosures and handling the approval reviews.',
        'terms' => 'app store play store submission publish release apple google review approval upload',
    ],
    [
        'id' => 'q28', 'cat' => 'apps',
        'q' => 'What frameworks does iThrive use for modern web development?',
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
        'q' => 'How does iThrive ensure web and mobile apps are responsive and fast?',
        'a' => 'Server-side rendering with Next.js, automated code splitting, image optimisation, edge '
             . 'CDN distribution and rigorous Lighthouse performance auditing.',
        'terms' => 'performance fast speed responsive optimisation load time lighthouse seo core web vitals',
    ],
    [
        'id' => 'q32', 'cat' => 'apps',
        'q' => 'Can iThrive build offline-first mobile applications?',
        'a' => 'Yes, using local databases such as SQLite, WatermelonDB or Hive, with automatic '
             . 'synchronisation engines that push data to the cloud once connectivity returns.',
        'terms' => 'offline first no internet sync local database connectivity field app',
    ],

    // ---- 5. E-commerce & retail AI -----------------------------------------

    [
        'id' => 'q33', 'cat' => 'ecommerce',
        'q' => 'What AI solutions does iThrive offer specifically for e-commerce?',
        'a' => 'Personalised product recommendation engines, visual search where the shopper searches by '
             . 'photo, AI virtual try-ons, dynamic pricing algorithms, automated cataloguing and tagging, '
             . 'and twenty-four-seven conversational sales assistants.',
        'terms' => 'ecommerce ai retail recommendation visual search try on dynamic pricing shop store online',
    ],
    [
        'id' => 'q34', 'cat' => 'ecommerce',
        'q' => 'What platforms does iThrive build e-commerce solutions on?',
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
        'q' => 'Can iThrive integrate custom payment gateways and multi-currency support?',
        'a' => 'Yes. Complete integrations with Stripe, PayPal, Razorpay, Adyen, Apple Pay and crypto '
             . 'gateways, with real-time multi-currency conversion.',
        'terms' => 'payment gateway stripe paypal razorpay currency checkout integrate multi currency',
    ],
    [
        'id' => 'q39', 'cat' => 'ecommerce',
        'q' => 'Can iThrive automate product description generation and SEO tagging for large catalogues?',
        'a' => 'Yes. We build automated LLM pipelines that ingest raw product specifications and images '
             . 'and generate SEO-optimised descriptions, metadata and alt tags across thousands of SKUs '
             . 'in minutes.',
        'terms' => 'product description seo tag catalogue sku automate generate content bulk listing',
    ],

    // ---- 6. Micro SaaS, POC & MVP ------------------------------------------

    [
        'id' => 'q40', 'cat' => 'saas',
        'q' => 'What is a Micro SaaS, and why build one with iThrive?',
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
        'q' => 'What key components are included in an iThrive MVP delivery?',
        'a' => 'User authentication, the core functionality, payment and subscription integration through '
             . 'Stripe, a basic admin dashboard, analytics tracking, clean UI and UX, and a scalable '
             . 'cloud hosting setup.',
        'terms' => 'mvp includes deliverable scope components what do i get features delivery',
    ],
    [
        'id' => 'q47', 'cat' => 'saas',
        'q' => 'How does iThrive ensure an MVP does not accumulate massive technical debt?',
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
        'q' => 'Can iThrive modernize legacy desktop software into a modern web cloud application?',
        'a' => 'Yes. We extract the underlying business logic and database schemas and re-architect them '
             . 'into modern web frameworks such as React and Node, hosted on AWS or GCP.',
        'terms' => 'desktop software legacy convert web cloud migrate vb access old application rewrite',
    ],
    [
        'id' => 'q53', 'cat' => 'modernise',
        'q' => 'How does iThrive prevent downtime during software modernization?',
        'a' => 'Strangler fig migration patterns, shadow deployments, database replication and feature '
             . 'flags, so the new system rolls out incrementally alongside the legacy one.',
        'terms' => 'downtime migration risk cutover safe rollout zero downtime business continuity',
    ],
    [
        'id' => 'q54', 'cat' => 'modernise',
        'q' => 'What is digital product engineering at iThrive?',
        'a' => 'A holistic engineering approach combining human-centred UI and UX design, cloud '
             . 'architecture, system security, automated QA, DevOps pipelines and continuous product '
             . 'evolution analytics.',
        'terms' => 'digital product engineering what is meaning approach holistic discipline',
    ],
    [
        'id' => 'q55', 'cat' => 'modernise',
        'q' => 'Does iThrive help legacy businesses digitize paper-heavy workflows?',
        'a' => 'Yes, by deploying custom AI document processing pipelines that ingest physical PDFs, '
             . 'handwritten notes and images, extracting the unstructured data straight into digital SQL '
             . 'or NoSQL databases.',
        'terms' => 'paper digitize document processing ocr handwritten pdf scan manual workflow automate',
    ],

    // ---- 8. Cloud, DevOps & infrastructure ---------------------------------

    [
        'id' => 'q56', 'cat' => 'cloud',
        'q' => 'Which cloud platforms does iThrive specialize in?',
        'a' => 'Amazon Web Services, Google Cloud Platform, Microsoft Azure, Vercel and Cloudflare.',
        'terms' => 'cloud platform aws gcp azure vercel cloudflare host hosting provider vendor '
                 . 'infrastructure services offering specialize',
    ],
    [
        'id' => 'q57', 'cat' => 'cloud',
        'q' => 'What DevOps services does iThrive provide?',
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
        'q' => 'How does iThrive ensure high availability and 99.99% uptime for AI applications?',
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
        'q' => 'What is the Idea-to-Words workflow at iThrive?',
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
        'q' => 'How does iThrive help non-technical founders manage tech teams effectively?',
        'a' => 'Clear product roadmaps in plain language, transparent Jira tracking, weekly video demos '
             . 'of working software, and dedicated product managers who translate business goals into '
             . 'developer tasks.',
        'terms' => 'non technical founder manage team cto oversight roadmap tracking demo plain language',
    ],
    [
        'id' => 'q68', 'cat' => 'growth',
        'q' => 'What steps should a business take today to start a project with iThrive?',
        'a' => 'Four steps. Schedule an initial discovery call. Take part in a two-day Idea-to-Words '
             . 'architecture review. Receive a detailed proposal with fixed milestone pricing and a '
             . 'project timeline. Then kick off development within five business days.',
        'terms' => 'how to start begin next step get started onboard process first step engage today',
    ],
    [
        'id' => 'q69', 'cat' => 'growth',
        'q' => 'Can iThrive assist with product pitch decks and technical documentation for investor fundraising?',
        'a' => 'Yes. We build functional interactive click-dummies, system architecture diagrams, '
             . 'technical whitepapers and ROI projection models that founders present to angel investors '
             . 'and VCs.',
        'terms' => 'pitch deck investor fundraising documentation whitepaper diagram prototype demo vc angel',
    ],
    [
        'id' => 'q70', 'cat' => 'growth',
        'q' => 'What is the long-term competitive advantage of building an AI-First product with iThrive today?',
        'a' => 'Software is shifting from static tools to dynamic, learning platforms. Building AI-First '
             . 'today means your platform continuously captures data, learns user preferences, automates '
             . 'internal costs and stays ahead of competitors still running legacy systems.',
        'terms' => 'competitive advantage long term future why now strategy ahead moat legacy competitors',
    ],
    // ---- 10. AI development: delivery, cost, compliance, ownership --------
    //
    // Drawn from the AI Development Company page's own accordion, which the
    // brain had never been given, plus the gaps its content left. Measured
    // before adding these: "do you do computer vision and OCR" fell straight
    // through to the demo boundary, and "are you an AI development company in
    // Bangalore" matched an unrelated entry about what AI-First means.

    [
        'id' => 'q71', 'cat' => 'ai-delivery',
        'q' => 'How long does it take to build a custom enterprise AI solution?',
        'a' => 'It depends on scope and how ready your data is. A proof of concept or an interactive '
             . 'MVP typically takes four to six weeks. An enterprise production system - domain LLM '
             . 'fine-tuning, RAG ingestion pipelines, an automated evaluation suite and legacy ERP '
             . 'integration - generally runs three to six months.',
        'terms' => 'how long timeline duration weeks months build enterprise ai solution poc mvp delivery time schedule',
    ],
    [
        'id' => 'q72', 'cat' => 'ai-delivery',
        'q' => 'How much does AI development cost in India compared to Western agencies?',
        'a' => 'Building with an AI development company in India typically costs 50 to 65 per cent less '
             . 'than a comparable US or European firm. Focused MVPs and chatbots generally land between '
             . '$15,000 and $50,000; large multimodal LLM architectures with distributed compute run '
             . 'from $80,000 to $200,000 and up.',
        'terms' => 'cost price pricing budget how much india cheaper western usa europe compare rate expensive dollars',
    ],
    [
        'id' => 'q73', 'cat' => 'ai-delivery',
        'q' => 'Can your AI models integrate into our existing ERP, CRM and legacy databases?',
        'a' => 'Yes. We build non-invasive REST microservices, GraphQL APIs and middleware connectors '
             . 'that talk to SAP, Salesforce, Microsoft Dynamics, Oracle and proprietary SQL or NoSQL '
             . 'data lakes - without downtime and without disrupting daily operations.',
        'terms' => 'integrate integration erp crm legacy database sap salesforce dynamics oracle existing systems connect middleware api',
    ],
    [
        'id' => 'q74', 'cat' => 'ai-delivery',
        'q' => 'Who owns the intellectual property, the model weights and the data?',
        'a' => 'You do - 100 per cent. Proprietary datasets, fine-tuned model checkpoints, vector '
             . 'embeddings and custom codebases all belong to your organisation on completion. We sign '
             . 'a bilateral NDA before any discovery discussion begins.',
        'terms' => 'ip intellectual property own ownership weights data nda rights code belongs licence copyright',
    ],
    [
        'id' => 'q75', 'cat' => 'ai-delivery',
        'q' => 'Why build a custom AI model instead of just using public APIs like ChatGPT?',
        'a' => 'Generic APIs are fine for simple tasks. Enterprise systems tend to need guaranteed zero '
             . 'data leakage, sub-100ms latency, deterministic accuracy rather than hallucination, and a '
             . 'fixed compute cost instead of per-token pricing that balloons at scale. A custom '
             . 'fine-tuned model runs privately in your own environment.',
        'terms' => 'custom model versus public api chatgpt openai why build own private latency hallucination token cost scale',
    ],
    [
        'id' => 'q76', 'cat' => 'ai-delivery',
        'q' => 'How do you ensure data security, GDPR and HIPAA compliance?',
        'a' => 'We work to ISO/IEC 27001, SOC 2 Type II and the NIST AI Risk Management Framework. '
             . 'Pipelines carry automatic PII redaction, end-to-end encryption in transit and at rest, '
             . 'role-based access control, and deployment inside isolated virtual private clouds.',
        'terms' => 'security gdpr hipaa compliance iso 27001 soc2 nist governance pii encryption rbac vpc privacy audit safe',
    ],
    [
        'id' => 'q77', 'cat' => 'ai-delivery',
        'q' => 'What happens after launch? Do you provide MLOps and model maintenance?',
        'a' => 'Yes. Continuous post-launch support and MLOps: 24/7 telemetry monitoring, model drift '
             . 'detection, automated re-training triggers as new data arrives, security patching, and '
             . 'dedicated SLA response times.',
        'terms' => 'after launch support maintenance mlops monitoring drift retraining sla ongoing post production upkeep',
    ],
    [
        'id' => 'q78', 'cat' => 'ai-delivery',
        'q' => 'Are you an AI development company in Chennai, Bangalore, Hyderabad and Coimbatore?',
        'a' => 'Yes. iThrive builds AI systems from engineering centres in Chennai, Bangalore, Hyderabad '
             . 'and Coimbatore, delivering to clients across India, the USA, the UK, Singapore and the '
             . 'UAE. See /services/ai-development-company.php',
        'terms' => 'ai development company city chennai bangalore bengaluru hyderabad coimbatore india location office where based near me',
    ],
    [
        'id' => 'q79', 'cat' => 'ai-delivery',
        'q' => 'Do you build computer vision and OCR systems?',
        'a' => 'Yes. Document and invoice reading, optical defect detection on a production line, '
             . 'medical imaging support and image classification at volumes nobody can staff for - '
             . 'built on YOLO, SAM and document AI models, with the confidence score surfaced so a '
             . 'person reviews the cases the model is unsure about.',
        'terms' => 'computer vision ocr image detection yolo sam document ai invoice defect inspection recognition scanning visual camera',
    ],
    [
        'id' => 'q80', 'cat' => 'ai-delivery',
        'q' => 'Can you build a multilingual voicebot or chatbot?',
        'a' => 'Yes - assistants that answer in the language the customer actually speaks, across 25+ '
             . 'Indian and international languages, grounded in your own documentation and escalating '
             . 'cleanly to a human the moment they should stop guessing. The assistant on this site is '
             . 'one, answering in English, Tamil, Malayalam, Kannada, Telugu and Hindi.',
        'terms' => 'voicebot chatbot voice assistant multilingual language tamil hindi telugu kannada malayalam speech ivr call bot conversational',
    ],

    // ---- 11. Answers the individual pages already published ---------------
    //
    // software-development, web-development and flutter-app-development each
    // carry ten question-and-answer pairs on the page itself. None had ever
    // reached the answer book, so the assistant could not answer one of them
    // even though the words were already written and approved. Harvested
    // verbatim rather than rewritten - the page and the assistant should not
    // give two different answers to the same question.

    [
        'id' => 'q81', 'cat' => 'page-faq',
        'q' => 'How do I know whether we need custom software at all?',
        'a' => 'Start with the workflow, not the software. If the process that costs you the most time is '
            . 'one a packaged tool models well, buy the tool — we will tell you so. Custom is worth it when '
            . 'the workflow is specific to how you compete, when you are paying for integration workarounds '
            . 'every month, or when per-seat licensing has quietly become larger than a build would have '
            . 'been.',
        'terms' => 'know whether need custom software development platform system erp bespoke',
    ],
    [
        'id' => 'q82', 'cat' => 'page-faq',
        'q' => 'What does custom software development cost in Chennai?',
        'a' => 'A focused first release generally lands between ₹4L and ₹9L; a production platform several '
            . 'teams depend on between ₹10L and ₹25L; core enterprise systems above ₹25L. The variables '
            . 'that move the number most are the count of integrations, whether the data has to be '
            . 'migrated, and whether the environment is regulated. We give a written estimate with the '
            . 'assumptions listed, so you can see what would change it.',
        'terms' => 'custom software development cost chennai platform system erp bespoke',
    ],
    [
        'id' => 'q83', 'cat' => 'page-faq',
        'q' => 'How long does a project take?',
        'a' => 'Discovery is about two weeks. A first production release is typically six to fourteen weeks '
            . 'after that, depending on scope. You see working software every fortnight throughout, so the '
            . 'timeline is visible rather than promised.',
        'terms' => 'long project take custom software development platform system erp bespoke',
    ],
    [
        'id' => 'q84', 'cat' => 'page-faq',
        'q' => 'Can you integrate with the systems we already run?',
        'a' => 'Yes — that is most of what enterprise work is. We integrate with ERPs, CRMs, accounting '
            . 'packages, payment gateways, logistics partners and hardware on the floor. Where a system has '
            . 'no API, we use file, database or UI-level automation and put a proper contract layer in '
            . 'front of it so the rest of your software does not have to know.',
        'terms' => 'integrate systems already run custom software development platform system erp bespoke',
    ],
    [
        'id' => 'q85', 'cat' => 'page-faq',
        'q' => 'Who owns the code and the data?',
        'a' => 'You do, from the first week. The repository sits in your organisation, cloud accounts are in '
            . 'your name, and domains and data never route through us. There is no escrow clause because '
            . 'there is nothing to escrow.',
        'terms' => 'owns code data custom software development platform system erp bespoke',
    ],
    [
        'id' => 'q86', 'cat' => 'page-faq',
        'q' => 'How do you handle security?',
        'a' => 'Threat modelling during design, least-privilege access, encryption in transit and at rest, '
            . 'secrets in a managed store rather than the repository, dependency scanning in CI, and an '
            . 'OWASP-aligned review before launch. For regulated work we produce the evidence your auditor '
            . 'asks for and sit in that review with you.',
        'terms' => 'handle security custom software development platform system erp bespoke',
    ],
    [
        'id' => 'q87', 'cat' => 'page-faq',
        'q' => 'What happens after launch?',
        'a' => 'Either we hand over — with runbooks, architecture documentation and a training session — or '
            . 'we keep running it on a monthly retainer with monitoring, an SLA and a continuing roadmap. '
            . 'Both are normal; the choice is usually about whether you have an internal team to receive '
            . 'it.',
        'terms' => 'happens launch custom software development platform system erp bespoke',
    ],
    [
        'id' => 'q88', 'cat' => 'page-faq',
        'q' => 'Do you work with startups or only enterprises?',
        'a' => 'Both. For startups the useful shape is a tight first release aimed at proving one thing, '
            . 'then iterating on what real users do. For enterprises it is usually modernisation or a '
            . 'platform several departments depend on. The engineering discipline is the same; the '
            . 'sequencing is not.',
        'terms' => 'work startups only enterprises custom software development platform system erp bespoke',
    ],
    [
        'id' => 'q89', 'cat' => 'page-faq',
        'q' => 'Can you take over software someone else built?',
        'a' => 'Regularly. We start with a paid audit — architecture, dependency and security review, plus '
            . 'an honest assessment of what should be kept. Taking over a codebase without that audit is '
            . 'how a rescue becomes a rewrite by accident.',
        'terms' => 'take software someone else built custom development platform system erp bespoke',
    ],
    [
        'id' => 'q90', 'cat' => 'page-faq',
        'q' => 'Where do you work from, and does that matter?',
        'a' => 'Our studios are in Coimbatore and Chennai, and we deliver across India, the Gulf and the '
            . 'United States. It matters mainly for the first phase: being able to sit in a room with the '
            . 'people whose workflow you are modelling makes discovery considerably better.',
        'terms' => 'work matter custom software development platform system erp bespoke',
    ],
    [
        'id' => 'q91', 'cat' => 'page-faq',
        'q' => 'How much does website development cost in Chennai?',
        'a' => 'A business website from iThrive Software costs between ₹65,000 and ₹1,50,000 and takes three '
            . 'to five weeks. An e-commerce platform runs ₹1,80,000 to ₹4,50,000 over six to ten weeks, and '
            . 'a custom web application ₹3,50,000 to ₹9,00,000 over eight to sixteen weeks. The price is '
            . 'fixed in writing before work starts, and covers design, development, technical SEO, '
            . 'accessibility testing and launch.',
        'terms' => 'website development cost chennai web site online presence seo google',
    ],
    [
        'id' => 'q92', 'cat' => 'page-faq',
        'q' => 'How long does it take to build a website?',
        'a' => 'Three to five weeks for a business website, six to ten weeks for an e-commerce store, and '
            . 'eight to sixteen weeks for a web application. The largest variable is content: projects '
            . 'where copy and photography are ready typically finish at the shorter end of the range.',
        'terms' => 'long take build website web site online presence seo google',
    ],
    [
        'id' => 'q93', 'cat' => 'page-faq',
        'q' => 'Do you work with businesses outside Chennai and Coimbatore?',
        'a' => 'Yes. iThrive Software delivers to clients across Tamil Nadu, Bangalore and the rest of '
            . 'India, and has studios in Chennai, Coimbatore and Bangalore. Discovery and design sign-off '
            . 'can be done on-site for clients in those three cities; delivery runs remotely against a '
            . 'staging URL you can open at any time.',
        'terms' => 'work businesses outside chennai coimbatore website web site online presence seo google',
    ],
    [
        'id' => 'q94', 'cat' => 'page-faq',
        'q' => 'Will my website rank on Google?',
        'a' => 'The engineering that ranking depends on is included: server-rendered markup, structured '
            . 'data, clean URL structure, sitemaps, redirects and Core Web Vitals inside Google\'s '
            . 'thresholds. No agency can honestly promise a position, because ranking also depends on '
            . 'content, competition and domain history — but the technical foundation is built in rather '
            . 'than sold back to you later.',
        'terms' => 'website rank google web site online presence seo',
    ],
    [
        'id' => 'q95', 'cat' => 'page-faq',
        'q' => 'Do I own the website and the code?',
        'a' => 'Yes, completely. Code, domain, hosting accounts and content belong to you from day one and '
            . 'live in your own repositories and accounts. iThrive Software does not hold your domain, does '
            . 'not use proprietary licences you have to keep renting, and hands over full access at launch.',
        'terms' => 'own website code web site online presence seo google',
    ],
    [
        'id' => 'q96', 'cat' => 'page-faq',
        'q' => 'Can you redesign my existing website without losing my Google rankings?',
        'a' => 'Yes. A redesign begins with a crawl of the existing site to record every indexed URL, then a '
            . 'redirect map that preserves them. URL structure is kept wherever it already works, and the '
            . 'cutover is staged with rollback ready rather than switched over in one go.',
        'terms' => 'redesign existing website without losing google rankings web site online presence seo',
    ],
    [
        'id' => 'q97', 'cat' => 'page-faq',
        'q' => 'What technology do you build websites with?',
        'a' => 'Mostly Python with Django or FastAPI on the back end, React or server-rendered PHP on the '
            . 'front end, PostgreSQL for data, and Nginx with Cloudflare in front. WordPress is used when a '
            . 'client\'s team already knows it and the site is content-led. The stack is chosen for what the '
            . 'project needs, not for what is fashionable.',
        'terms' => 'technology build websites website web site online presence seo google',
    ],
    [
        'id' => 'q98', 'cat' => 'page-faq',
        'q' => 'Do you provide website maintenance after launch?',
        'a' => 'Yes. Maintenance retainers cover security patching, backups, uptime monitoring, content '
            . 'updates and a named engineer with an agreed response window. Sites launched without a '
            . 'retainer still receive a 30-day defect warranty.',
        'terms' => 'provide website maintenance launch web site online presence seo google',
    ],
    [
        'id' => 'q99', 'cat' => 'page-faq',
        'q' => 'Will my website work properly on mobile phones?',
        'a' => 'Every site is built mobile-first and tested on real devices, not just a resized desktop '
            . 'browser. Layouts hold from a 360-pixel Android screen upward, and performance budgets are '
            . 'measured on a mid-range device on 4G rather than on a developer\'s laptop.',
        'terms' => 'website work properly mobile phones web site online presence seo google',
    ],
    [
        'id' => 'q100', 'cat' => 'page-faq',
        'q' => 'Can you integrate payments, WhatsApp and my CRM?',
        'a' => 'Yes. Razorpay, Stripe, UPI and cash-on-delivery reconciliation, WhatsApp Business enquiry '
            . 'routing, and CRM integrations including Zoho, HubSpot and Salesforce are all standard work. '
            . 'Integrations are wired during development sprints rather than bolted on after launch.',
        'terms' => 'integrate payments whatsapp crm website web site online presence seo google',
    ],
    [
        'id' => 'q101', 'cat' => 'page-faq',
        'q' => 'Why choose iThrive Software as your Flutter app development company in Chennai?',
        'a' => 'iThrive Software is a Flutter app development company in Chennai with studios in Coimbatore '
            . 'and Bangalore, building production Flutter apps in Dart for iOS, Android, web and desktop '
            . 'from a single codebase. You get 100% source code and IP ownership, fixed milestone pricing '
            . 'agreed in writing before work starts, a signed NDA, and store submission handled end to end '
            . 'for both Apple App Store and Google Play.',
        'terms' => 'choose ithrive software flutter app development company chennai dart cross platform ios android',
    ],
    [
        'id' => 'q102', 'cat' => 'page-faq',
        'q' => 'How much does Flutter app development cost in India?',
        'a' => 'A basic Flutter app costs ₹2,20,000 to ₹3,80,000 and a feature-rich build with payments, '
            . 'live location or on-device AI runs ₹6,50,000 to ₹12,00,000. Those are Indian market averages '
            . 'for 2026. Flutter is what keeps them 30 to 50 percent below the cost of building separate '
            . 'native iOS and Android apps, because one Dart codebase ships to both stores instead of two '
            . 'teams building the same product twice.',
        'terms' => 'flutter app development cost india dart cross platform ios android',
    ],
    [
        'id' => 'q103', 'cat' => 'page-faq',
        'q' => 'How long does it take to build a Flutter app?',
        'a' => 'Five to seven weeks for a straightforward Flutter app, seven to ten weeks for most builds, '
            . 'and ten to fourteen weeks for a regulated or AI-heavy one such as fintech or healthcare. '
            . 'iThrive Software works in two-week sprints with an installable build every Friday, so '
            . 'progress is something you run on your own phone rather than read in a status report.',
        'terms' => 'long take build flutter app dart cross platform ios android',
    ],
    [
        'id' => 'q104', 'cat' => 'page-faq',
        'q' => 'Is Flutter better than React Native for app development?',
        'a' => 'For most products, yes, and the reason is rendering. Flutter draws every pixel itself '
            . 'through its Impeller engine rather than bridging to each platform’s native widgets, so an '
            . 'app looks and behaves identically on iOS and Android and animation holds up at 120 FPS on '
            . 'displays that support it. React Native remains the better answer when a team is already deep '
            . 'in JavaScript or the app leans heavily on native modules. iThrive Software builds both and '
            . 'will say which one your project actually needs.',
        'terms' => 'flutter better react native app development dart cross platform ios android',
    ],
    [
        'id' => 'q105', 'cat' => 'page-faq',
        'q' => 'Can a Flutter app do everything a native app can?',
        'a' => 'Yes. Camera, GPS, Bluetooth, biometrics, background tasks, push notifications, in-app '
            . 'purchases and on-device machine learning are all available to Flutter through platform '
            . 'channels, and where a plugin does not exist iThrive Software writes the native Swift or '
            . 'Kotlin side. The practical limit is not capability but very specialised platform features on '
            . 'release day, which sometimes need a native shim for a few weeks.',
        'terms' => 'flutter app everything native dart cross platform ios android',
    ],
    [
        'id' => 'q106', 'cat' => 'page-faq',
        'q' => 'Do you build Flutter apps for clients outside Chennai?',
        'a' => 'Yes. iThrive Software delivers Flutter app development across Tamil Nadu, Bangalore and the '
            . 'rest of India, with studios in Chennai, Coimbatore and Bangalore. Discovery and design '
            . 'sign-off can happen on-site in any of those three cities; delivery runs remotely with an '
            . 'installable build each sprint.',
        'terms' => 'build flutter apps clients outside chennai dart cross platform app ios android',
    ],
    [
        'id' => 'q107', 'cat' => 'page-faq',
        'q' => 'Will I own the Flutter source code and the IP?',
        'a' => 'Yes, completely. On milestone sign-off iThrive Software transfers the GitHub or GitLab '
            . 'organisation itself rather than a zip file, with commit history, branches and CI pipelines '
            . 'intact. Cloud accounts, the Apple Developer and Google Play listings, signing keys, '
            . 'environment secrets and the Figma files move into your name at the same time.',
        'terms' => 'own flutter source code dart cross platform app ios android',
    ],
    [
        'id' => 'q108', 'cat' => 'page-faq',
        'q' => 'Do you handle App Store and Google Play submission for Flutter apps?',
        'a' => 'Yes. App signing, screenshots, privacy and data-safety declarations, metadata and the '
            . 'review-rejection cycle are all handled for both stores until the app is live. One Flutter '
            . 'codebase produces both builds, so a release goes to iOS and Android together rather than one '
            . 'lagging the other by a sprint.',
        'terms' => 'handle app store google play submission flutter apps dart cross platform ios android',
    ],
    [
        'id' => 'q109', 'cat' => 'page-faq',
        'q' => 'What support do you provide after a Flutter app launches?',
        'a' => 'Every build ships with a 90-day warranty at no cost: any defect traceable to our code is '
            . 'fixed at our expense, same-business-day response, fix targeted within 72 hours by severity. '
            . 'After that, annual plans cover Flutter and Dart SDK upgrades, OS releases and dependency '
            . 'drift — the work that keeps an app installable and submittable three years on, which is the '
            . 'real risk over that horizon.',
        'terms' => 'support provide flutter app launches dart cross platform ios android',
    ],
    [
        'id' => 'q110', 'cat' => 'page-faq',
        'q' => 'Can you convert an existing native or React Native app to Flutter?',
        'a' => 'Yes. iThrive Software migrates existing iOS, Android and React Native apps to Flutter, '
            . 'usually screen by screen behind the existing shell so the app stays shippable throughout '
            . 'rather than going dark for a rewrite. The starting point is an audit of the current codebase '
            . 'and its analytics, so the migration order follows what users actually touch.',
        'terms' => 'convert existing native react app flutter dart cross platform ios android',
    ],

    // ---- 12. Pages that published no FAQ of their own ----------------------
    //
    // AI Enablement, AI-Native Product Development and E-commerce Development
    // each ran without a single question and answer, on the site or in the
    // book, so the assistant had nothing to say about three of the services it
    // sells. Written from what those pages actually claim, so the page and the
    // assistant cannot contradict each other. Filed under the existing
    // categories rather than a new one, because that is where a reader looking
    // for them would go.

    [
        'id' => 'q111', 'cat' => 'ai-assistant',
        'q' => 'Can you add AI to our existing product without a rewrite?',
        'a' => 'Yes — that is the whole point of the enablement work. Intelligence ships as a separate '
            . 'service alongside your platform rather than through it, behind a feature flag. Your existing '
            . 'product keeps running untouched, and the AI layer can be switched off in one call if it '
            . 'misbehaves.',
        'terms' => 'add ai existing product rewrite sidecar alongside feature flag enable enablement retrofit legacy without rebuild',
    ],
    [
        'id' => 'q112', 'cat' => 'ai-assistant',
        'q' => 'How do you decide which AI features are actually worth building?',
        'a' => 'We instrument the product you already have, find where users stall and where support tickets '
            . 'cluster, then rank the candidate features by effort against measured impact. The audit comes '
            . 'before the build, so the first thing we ship is the one with evidence behind it.',
        'terms' => 'which ai features worth building audit opportunity prioritise roi evidence impact stall tickets decide',
    ],
    [
        'id' => 'q113', 'cat' => 'ai-assistant',
        'q' => 'What happens if the AI gets something wrong in production?',
        'a' => 'Every agent action has a deterministic fallback path and, where a wrong move would cost '
            . 'something, a human approval gate. Outputs are schema-validated, there are cost ceilings, and '
            . 'every run is traced — so when something is wrong you can see exactly which step did it and '
            . 'roll back that step.',
        'terms' => 'ai wrong mistake error production fallback guardrail approval rollback hallucination safety trace incident',
    ],
    [
        'id' => 'q114', 'cat' => 'ai-assistant',
        'q' => 'Will adding AI slow our existing product down?',
        'a' => 'No, because it does not sit in the request path unless it has to. The intelligence runs as '
            . 'its own service with its own scaling, and where a response has to be synchronous we hold it '
            . 'to a latency budget agreed up front and fall back to the non-AI path if it is exceeded.',
        'terms' => 'slow performance latency speed impact existing product degrade response time budget synchronous',
    ],
    [
        'id' => 'q115', 'cat' => 'ai-native',
        'q' => 'What is the difference between an AI-native product and one with AI bolted on?',
        'a' => 'A bolted-on product is a normal application with a chat box added. An AI-native one is '
            . 'architected the other way round: the agent owns the workflow and the interface exists so a '
            . 'person can supervise it. That changes the data model, the permissions and the error '
            . 'handling, which is why it is hard to retrofit.',
        'terms' => 'ai native versus bolted on difference chat box architecture agent owns workflow greenfield rethink',
    ],
    [
        'id' => 'q116', 'cat' => 'ai-native',
        'q' => 'How do you stop an AI product from hallucinating?',
        'a' => 'Retrieval grounded in your own corpus with citations back to the source document, '
            . 'schema-validated outputs so a malformed answer fails rather than ships, and an evaluation '
            . 'harness with a golden dataset that runs on every prompt or model change. Quality regressions '
            . 'get caught in CI rather than by customers.',
        'terms' => 'hallucinate hallucination accuracy wrong answers grounding citations eval harness golden dataset quality regression rag',
    ],
    [
        'id' => 'q117', 'cat' => 'ai-native',
        'q' => 'How long does it take to get an agentic product into production?',
        'a' => 'Six to ten weeks for a greenfield agent in production. That covers the agent design, the '
            . 'retrieval architecture, the evaluation suite and the observability — not a demo, but the '
            . 'version with the guardrails and the traces that let you run it in front of customers.',
        'terms' => 'how long agentic agent production timeline weeks greenfield ai native build ship launch',
    ],
    [
        'id' => 'q118', 'cat' => 'ai-native',
        'q' => 'How do you measure whether an AI feature is working?',
        'a' => 'Against the number it was built to move, agreed before the build starts, and measured '
            . 'against a held-out control rather than a dashboard. Every agent run is traced and costed per '
            . 'customer and per feature, so the benefit and the bill are both visible.',
        'terms' => 'measure success metrics roi working evaluate control group traced costed observability proof value',
    ],
    [
        'id' => 'q119', 'cat' => 'ecommerce',
        'q' => 'Do you build on Shopify, or custom?',
        'a' => 'Both, and the choice follows the catalogue rather than fashion. Shopify Plus and headless '
            . 'Shopify with a Next.js storefront where the commerce engine is standard; a custom Node.js or '
            . 'Python engine where pricing, bundling or fulfilment rules are specific enough that fighting '
            . 'a platform costs more than building one.',
        'terms' => 'shopify custom headless woocommerce platform choose ecommerce build storefront nextjs magento which',
    ],
    [
        'id' => 'q120', 'cat' => 'ecommerce',
        'q' => 'Can you migrate our existing store without losing SEO or order history?',
        'a' => 'Yes. URLs are mapped one to one with 301 redirects before launch, structured data is carried '
            . 'across, and order and customer history is migrated and reconciled against the old system '
            . 'before the switch. We keep the old store live until the counts match.',
        'terms' => 'migrate migration existing store seo rankings order history data move replatform redirect 301 lose traffic',
    ],
    [
        'id' => 'q121', 'cat' => 'ecommerce',
        'q' => 'What does AI actually do for an e-commerce store?',
        'a' => 'Ranking that reflects what each shopper has browsed, bought and abandoned rather than what '
            . 'is being promoted this week; semantic catalogue search that understands a description '
            . 'instead of matching keywords; and support deflection on the questions that repeat. Measured '
            . 'on conversion and return rate, not on engagement.',
        'terms' => 'ai ecommerce retail recommendation personalisation search conversion basket returns deflection ranking product discovery',
    ],
    [
        'id' => 'q122', 'cat' => 'ecommerce',
        'q' => 'Can you integrate payments, WhatsApp and our logistics provider?',
        'a' => 'Yes — Razorpay, Stripe, PayU and UPI for payments, WhatsApp Business for order updates and '
            . 'support, and the major Indian courier aggregators for fulfilment and tracking. These are '
            . 'integrations we have shipped before rather than ones we would be exploring on your budget.',
        'terms' => 'integrate payments razorpay stripe upi whatsapp logistics courier shipping delivery tracking fulfilment gateway',
    ],
    [
        'id' => 'q123', 'cat' => 'saas',
        'q' => 'How do you decide what goes into an MVP and what gets cut?',
        'a' => 'We start from the single number the product has to move, agreed in writing before any '
            . 'scoping. Anything that cannot move that number in the first release goes on a roadmap you '
            . 'can still see, rather than into the build. A typical arrival list has forty items and a '
            . 'typical first release has six. That fortnight of arguing is the cheapest work on the '
            . 'project, and skipping it is why most failed MVPs were never really an MVP.',
        'terms' => 'mvp scope what goes in cut features prioritise decide minimum viable roadmap trim six features one metric',
    ],
    [
        'id' => 'q124', 'cat' => 'saas',
        'q' => 'Will an MVP have to be rewritten when it succeeds?',
        'a' => 'Not if it was built properly. iThrive Software writes an MVP on modular services, typed '
            . 'end to end, with CI/CD and a database schema that does not need replacing at ten thousand '
            . 'users. Small is a scope decision, not a quality one. What is deliberately left out is '
            . 'features, never the foundations — which is why our MVPs grow into the product rather than '
            . 'being thrown away in month six.',
        'terms' => 'mvp rewrite throwaway scale later technical debt architecture prototype production quality foundations grow',
    ],
    [
        'id' => 'q125', 'cat' => 'saas',
        'q' => 'What happens after the MVP launches?',
        'a' => 'We release to a real cohort, instrument the loop and watch the agreed metric for a '
            . 'fortnight. Then there are three honest outcomes: scale it, change it, or stop — decided by '
            . 'the number rather than by whoever is most senior in the room. Two of those three save you '
            . 'a year. Every build also carries a 90-day warranty: any defect traceable to our code is '
            . 'fixed at our expense.',
        'terms' => 'after mvp launch next steps iterate scale stop pivot cohort metric warranty support post launch',
    ],

    // ---- 12. Published on a service page but previously unanswerable -------
    //
    // A coverage pass compared every question rendered on the site against this
    // book. 147 of 160 matched; these thirteen did not, so a visitor who asked
    // the assistant a question printed on the page in front of them got the
    // demo boundary reply instead of the answer sitting a few pixels above.
    //
    // The answers are lifted verbatim from the pages that publish them, so the
    // two cannot drift. What is written here is the `terms` — and the missing
    // vocabulary is exactly why each one missed: "How long does a project
    // take?" and "What do I actually get at the end?" carry almost no
    // distinguishing words of their own.

    [
        'id' => 'q126', 'cat' => 'apps',
        'q' => 'Once the final payment is made, how is the code delivered to us?',
        'a' => 'On milestone sign-off we transfer the GitHub or GitLab organisation itself, not a zip file — '
             . 'full commit history, branches and CI pipelines intact. Cloud accounts, the Apple Developer '
             . 'and Google Play listings, signing keys, environment secrets and the Figma files move into '
             . 'your name at the same time. You also get architecture notes and a working local setup, so a '
             . 'different team could take over without ever speaking to us. Nothing is held back as '
             . 'leverage.',
        'terms' => 'code delivery deliver handover final payment repository github gitlab transfer zip keys secrets',
        // Published on services/mobile-app-development.php
    ],
    [
        'id' => 'q127', 'cat' => 'apps',
        'q' => 'How does the iThrive support team actually work day to day?',
        'a' => 'You get a named engineer who worked on your build, not a ticket queue and a stranger. '
             . 'Support runs on a shared Slack or Teams channel plus email, with a tracked board you can '
             . 'see. Response targets are one business hour for anything production-down, same business day '
             . 'for a broken feature, and two working days for everything else. Every month you get an '
             . 'uptime, crash-free-rate and cost summary — sent whether the reading is flattering or not.',
        'terms' => 'support team day to day named engineer slack teams response targets sla monthly report',
        // Published on services/mobile-app-development.php
    ],
    [
        'id' => 'q128', 'cat' => 'engagement',
        'q' => 'What can your dedicated engineers actually do?',
        'a' => 'The ten disciplines above, and they are staffed as a team rather than as individuals — a '
             . 'front-end engineer here comes with the back-end, QA and DevOps people who make their work '
             . 'shippable. Where we do not have the skill in-house we say so rather than putting a near-miss '
             . 'on the invoice.',
        'terms' => 'dedicated engineers skills disciplines capability what can they do team roles staffed',
        // Published on services/dedicated-engineering-team.php
    ],
    [
        'id' => 'q129', 'cat' => 'engagement',
        'q' => 'How does hiring actually work?',
        'a' => 'A call, then a written proposal naming roles, rates and start dates. You interview the '
             . 'individuals if you want to; most clients interview the first two and stop. Nobody is billed '
             . 'before they are in your standup.',
        'terms' => 'hiring hire process work proposal interview rates start dates onboard how',
        // Published on services/dedicated-engineering-team.php
    ],
    [
        'id' => 'q130', 'cat' => 'engagement',
        'q' => 'Who manages them day to day?',
        'a' => 'You do, on the work. We handle employment, performance, cover for leave and replacement if '
             . 'somebody is not right — and replacement is our cost, not yours. You should be directing '
             . 'engineers, not administering them.',
        'terms' => 'manages management day to day who manage direct supervise performance leave replacement',
        // Published on services/dedicated-engineering-team.php
    ],
    [
        'id' => 'q131', 'cat' => 'engagement',
        'q' => 'What do we actually get by taking developers on demand?',
        'a' => 'Capacity in about forty-eight hours instead of a hiring cycle, seniority you are not paying '
             . 'to develop, and the ability to change your mind — up or down on thirty days\' notice. What '
             . 'you give up is the permanence, which matters if the work is genuinely open-ended.',
        'terms' => 'on demand developers benefit get capacity forty eight hours seniority scale notice',
        // Published on services/on-demand-resources.php
    ],
    [
        'id' => 'q132', 'cat' => 'engagement',
        'q' => 'How do we judge whether an engineer is any good?',
        'a' => 'Interview them; we will not put a wall between you and the person doing the work. Beyond '
             . 'that, ask for a code review rather than a CV walk-through — an hour looking at how somebody '
             . 'reasons about a real change tells you more than any amount of talking about frameworks.',
        'terms' => 'judge assess evaluate engineer good quality skill test trial vet screening',
        // Published on services/on-demand-resources.php
    ],
    [
        'id' => 'q133', 'cat' => 'engagement',
        'q' => 'What should we look for in the person?',
        'a' => 'Less than you would think about the specific stack, and more about how they handle not '
             . 'knowing something. The frameworks change every three years; the habits of writing things '
             . 'down, asking early and being honest about status do not.',
        'terms' => 'look for person candidate qualities choose pick selecting engineer traits',
        // Published on services/on-demand-resources.php
    ],
    [
        'id' => 'q134', 'cat' => 'saas',
        'q' => 'What should a PoC actually include?',
        'a' => 'The risky part and nothing else. One question, the smallest thing that can answer it, real '
             . 'data wherever it exists, and the measurement written down. Authentication, admin screens and '
             . 'polish are deliberately absent — putting them in is how a proof quietly turns into a slow '
             . 'first build.',
        'terms' => 'poc proof of concept include scope contain deliverable what is in',
        // Published on services/poc-development.php
    ],
    [
        'id' => 'q135', 'cat' => 'saas',
        'q' => 'What do I actually get at the end?',
        'a' => 'A running proof you can demonstrate, the source and infrastructure in your own accounts, the '
             . 'measurement against the agreed threshold, a written account of what we found — including '
             . 'anything that surprised us — and a scoped MVP plan with a cost against it.',
        'terms' => 'get at the end deliverable output receive final handover what do i get',
        // Published on services/poc-development.php
    ],
    [
        'id' => 'q136', 'cat' => 'apps',
        'q' => 'Our frontend feels slow and fragmented. Can that be fixed without starting over?',
        'a' => 'Usually, yes. Slowness in a React app is normally a small number of specific causes — '
             . 'unnecessary re-renders, state held too high, an unsplit bundle, images and fonts nobody '
             . 'budgeted. We measure first and report what we find, including when the honest answer is that '
             . 'the architecture is the problem and a rebuild is cheaper.',
        'terms' => 'frontend slow fragmented fix without rewrite starting over performance react refactor incremental',
        // Published on services/reactjs-development.php
    ],
    [
        'id' => 'q137', 'cat' => 'engagement',
        'q' => 'How do we see progress, and how do we know what is really done?',
        'a' => 'A demo on real data every fortnight, the repository in your own account from the first '
             . 'commit, and the same board we use. "Done" means merged, deployed and instrumented, not '
             . 'written and awaiting integration.',
        'terms' => 'progress visibility see track know done demo sprint report status transparency',
        // Published on services/reactjs-development.php
    ],
    [
        'id' => 'q138', 'cat' => 'engagement',
        'q' => 'How long does a project take?',
        'a' => 'Discovery is about two weeks. A first production release is typically six to fourteen weeks '
             . 'after that, depending on scope. You see working software every fortnight throughout, so the '
             . 'timeline is visible rather than promised.',
        'terms' => 'project duration length timeline how long take weeks months delivery schedule',
        // Published on services/software-development.php
    ],
];
