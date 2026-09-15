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
    'agentic'      => 'Agentic AI, Agents & Autonomy',
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
    [
        'id' => 'q139', 'cat' => 'page-faq',
        'q' => 'We need blockchain. Do you have developers for that?',
        'a' => 'We build the surrounding product — wallets, custody integrations, on-chain reads, '
            . 'settlement reconciliation — and we work with specialist contract auditors for the '
            . 'on-chain part rather than pretending to be them. We will also ask what the chain is '
            . 'buying you. It is the right answer for a genuinely trustless multi-party ledger and '
            . 'the wrong one for most things a database already does well, and we would rather have '
            . 'that conversation before the invoice.',
        'terms' => 'blockchain web3 crypto smart contract solidity ledger wallet custody on chain nft token defi',
        // Published on services/custom-product-development.php
    ],
    [
        'id' => 'q140', 'cat' => 'page-faq',
        'q' => 'Why should we modernise at all? It still works.',
        'a' => 'Because "still works" and "stable" are different things. A product that has run for '
            . 'years without a catastrophe is usually not stable, it is stagnant: development is '
            . 'slowing, maintenance costs are climbing, the framework has stopped receiving security '
            . 'patches, and customers are comparing you to something built more recently. '
            . 'Modernisation reduces the operational bill, closes the vulnerabilities and buys back '
            . 'the agility to ship. If your system genuinely is fine, we will tell you that instead.',
        'terms' => 'modernise modernize why bother still works legacy stagnant technical debt upgrade old system worth it',
        // Published on services/product-modernization.php
    ],
    [
        'id' => 'q141', 'cat' => 'page-faq',
        'q' => 'Will modernisation disrupt what we are running now?',
        'a' => 'That is what the approach is designed to prevent. A routing layer goes in front of the '
            . 'legacy system and new services take over endpoints one at a time, with both running '
            . 'until the last one moves. Each step is feature-flagged and reversible, cutovers are '
            . 'blue-green, and planned downtime is zero. Your feature roadmap keeps shipping '
            . 'throughout — being asked to stand still for a year is why big-bang rewrites fail.',
        'terms' => 'disrupt disruption downtime outage operations running now migration risk cutover parallel rollback strangler',
        // Published on services/product-modernization.php
    ],
    [
        'id' => 'q142', 'cat' => 'page-faq',
        'q' => 'Can modernisation be shaped around our business?',
        'a' => 'It has to be. The order of work is decided by your constraints, not by a reference '
            . 'architecture: the compliance deadline, the integration that breaks most often, the '
            . 'module your team most dreads touching. We sequence around those, and we are explicit '
            . 'about what we are deliberately not doing yet and why.',
        'terms' => 'customised customized tailored shaped around our business bespoke sequence priorities constraints roadmap order',
        // Published on services/product-modernization.php
    ],
    [
        'id' => 'q143', 'cat' => 'page-faq',
        'q' => 'Why hire a cloud partner rather than build the capability in-house?',
        'a' => 'Eventually you should have it in-house, and we will help you get there — a good '
            . 'engagement ends with your team owning the pipeline and the runbooks. The case for '
            . 'bringing someone in is speed and scar tissue: you get patterns already proven across '
            . 'other products instead of learning them from your own outages. What you should not do '
            . 'is hire one DevOps engineer and make them solely responsible; that is a single point '
            . 'of failure with a pager.',
        'terms' => 'hire partner in house internal team build capability outsource devops engineer why not ourselves',
        // Published on services/cloud-devops.php
    ],
    [
        'id' => 'q144', 'cat' => 'page-faq',
        'q' => 'Is cloud and DevOps work continuous, or a one-off project?',
        'a' => 'Both models exist and we will tell you which you need. A bounded piece — a migration, '
            . 'a pipeline build, a cost review — is a project with an end. But cloud left alone '
            . 'decays: dependencies fall out of support, instances stay sized for last year, and '
            . 'permissions accumulate. Most clients start with a bounded project and continue on a '
            . 'monthly basis once they can see what it prevents.',
        'terms' => 'continuous ongoing one off project retainer monthly initial deployment improvement engagement shape',
        // Published on services/cloud-devops.php
    ],
    [
        'id' => 'q145', 'cat' => 'page-faq',
        'q' => 'Why is our cloud bill rising when usage is flat?',
        'a' => 'Almost always one of five things: instances sized for a peak that never recurred, '
            . 'storage and snapshots nothing prunes, data transfer between zones that a placement '
            . 'change would remove, orphaned resources from experiments nobody deleted, and '
            . 'on-demand pricing on workloads that have run continuously for two years. A cost '
            . 'review finds these in about a week, and the first pass usually pays for itself.',
        'terms' => 'cloud bill cost rising increasing spend usage flat aws azure gcp invoice waste savings finops over provisioned',
        // Published on services/cloud-devops.php
    ],
    [
        'id' => 'q146', 'cat' => 'page-faq',
        'q' => 'Do you build games in Unity or Unreal?',
        'a' => 'Both, and the choice follows the product rather than a preference. Unity is usually '
            . 'right for mobile, 2D, AR and cross-platform learning and training work — smaller '
            . 'builds, faster iteration, and a wider talent pool for handover. Unreal earns its '
            . 'place when the bar is visual fidelity on desktop or console. We will tell you which '
            . 'case you are in during discovery, and we will say so if a game engine is the wrong '
            . 'tool entirely, which happens more often than you would expect for training work.',
        'terms' => 'unity unreal engine godot game build which choose c# blueprints 2d 3d mobile console fidelity',
        // Published on services/game-development.php
    ],
    // ---- 12. Agentic AI: agents, squads and autonomy ----------------------
    // Added for the sixteen agentic and AI service pages. Every entry carries a
    // wide `terms` string on purpose: faq-brain normalises a Tamil, Malayalam,
    // Kannada, Telugu or Hindi question into these English concepts, so the
    // breadth of this field is what makes the answer reachable in six
    // languages without storing a single translated string.

    [
        'id' => 'q147', 'cat' => 'agentic',
        'q' => 'What is an AI agent, in plain terms?',
        'a' => 'Software that is given a goal, a set of tools it may use, and permission to take several '
             . 'steps on its own to reach that goal. The difference from ordinary automation is that the '
             . 'sequence is not fixed in advance: the agent decides what to do next based on what it finds. '
             . 'The difference from a chatbot is that it acts rather than only answers.',
        'terms' => 'agent what is agentic ai meaning define definition explain autonomous software bot',
    ],
    [
        'id' => 'q148', 'cat' => 'agentic',
        'q' => 'How is an AI agent different from RPA or a macro?',
        'a' => 'RPA follows a script you wrote and breaks when the screen or the data shifts. An agent is '
             . 'given an objective and works out the steps, so it handles variation a script cannot. RPA is '
             . 'cheaper and more predictable where the process never changes, which is why we still build '
             . 'plenty of it, and often combine the two: the agent makes the judgement, the robot does the '
             . 'clicking.',
        'terms' => 'agent vs rpa difference macro script automation compare robotic process which better',
    ],
    [
        'id' => 'q149', 'cat' => 'agentic',
        'q' => 'Will an AI agent replace our staff?',
        'a' => 'Not in the deployments we run, and we would rather say that plainly than sell a headcount '
             . 'promise. Agents take the high-volume, rule-governed part of a queue; the exceptions still '
             . 'need experienced people, and the backlog a team was deferring usually gets picked up. If '
             . 'headcount reduction is the actual goal, say so at the start, because it changes which '
             . 'workflow you should choose and how accurate it has to be before going live.',
        'terms' => 'replace staff job loss redundancy people headcount employees fired workers impact team',
    ],
    [
        'id' => 'q150', 'cat' => 'agentic',
        'q' => 'How do you stop an agent from doing something damaging?',
        'a' => 'By bounding what it can reach rather than trusting it to behave. Every capability is an '
             . 'explicit tool with its own permissions, anything above a threshold you set waits for a '
             . 'human, and one switch halts a run mid-flight. An agent that can call anything is an agent '
             . 'nobody can reason about, so we never build one.',
        'terms' => 'safety safe control stop danger risk damage guardrail permission limit prevent mistake',
    ],
    [
        'id' => 'q151', 'cat' => 'agentic',
        'q' => 'Can we stop an agent in the middle of a run?',
        'a' => 'Yes. One switch halts the agent or the whole squad, and every autonomous action has a '
             . 'defined reversal. We treat that as a requirement rather than a feature: autonomy you '
             . 'cannot stop is not autonomy, it is exposure.',
        'terms' => 'stop halt kill switch cancel abort pause emergency shutdown rollback reverse undo',
    ],
    [
        'id' => 'q152', 'cat' => 'agentic',
        'q' => 'What happens when an agent gets something wrong?',
        'a' => 'It depends what it was allowed to do. Actions above your threshold were only ever drafts '
             . 'waiting for approval, so a wrong one is corrected before it lands. Below the threshold, '
             . 'every action has a defined reversal and a full trail of what it touched, so the fix is a '
             . 'rollback rather than an investigation.',
        'terms' => 'wrong mistake error incorrect fail failure bad output fix correct recover what if',
    ],
    [
        'id' => 'q153', 'cat' => 'agentic',
        'q' => 'Do we need multiple agents or will one do?',
        'a' => 'One, almost always, to begin with. Multi-agent systems earn their extra machinery only when '
             . 'a process genuinely has separable roles needing different skills or permissions. A crowd of '
             . 'agents is harder to debug and rarely better than a single agent with more tools.',
        'terms' => 'multiple agents multi agent how many one swarm squad team orchestration need several',
    ],
    [
        'id' => 'q154', 'cat' => 'agentic',
        'q' => 'How long does it take to get a first agent into production?',
        'a' => 'Four to eight weeks for a custom agent, or three to seven days if a ready-made archetype '
             . 'fits your job. The variable is integration count far more than agent complexity: one system '
             . 'in and one out is quick, six systems that disagree with each other is a different project.',
        'terms' => 'how long time duration timeline weeks fast quick deliver production launch when ready',
    ],
    [
        'id' => 'q155', 'cat' => 'agentic',
        'q' => 'What does it cost to run an agent?',
        'a' => 'Usually cents rather than rupees per completed task, but it depends on how many steps each '
             . 'run takes and how much context it carries. We model it during the build and set a per-run '
             . 'cost ceiling, because an agent that loops is an agent that spends.',
        'terms' => 'cost price run cheap expensive token spend budget monthly per task economics rupees',
    ],
    [
        'id' => 'q156', 'cat' => 'agentic',
        'q' => 'Should we buy a ready-made agent or build a custom one?',
        'a' => 'Buy the archetype when the job is one most businesses share — support triage, invoice '
             . 'extraction, reconciliation — because the engineering is already done and it runs in days. '
             . 'Build custom when the workflow encodes something proprietary, or when an archetype has been '
             . 'tried and hit a wall. An archetype that stops fitting becomes the specification for the '
             . 'custom build rather than wasted money.',
        'terms' => 'buy build custom ready made off shelf archetype prebuilt which better choose decide',
    ],
    [
        'id' => 'q157', 'cat' => 'agentic',
        'q' => 'What is prompt injection and should we worry about it?',
        'a' => 'It is when text inside a document or web page an agent reads tries to issue it instructions. '
             . 'You should worry about it exactly as much as your agent has permissions. We treat untrusted '
             . 'content as data and never as instruction, and scope tool access so a successful injection '
             . 'cannot reach anything the agent was not already allowed to touch.',
        'terms' => 'prompt injection security attack hack jailbreak malicious hijack manipulate exploit safe',
    ],
    [
        'id' => 'q158', 'cat' => 'agentic',
        'q' => 'How do you test something that gives different answers each time?',
        'a' => 'With a golden set — a fixed collection of your real cases, scored on every prompt and model '
             . 'change. You are not testing for an identical string, you are testing that the outcome is '
             . 'still correct. A release that regresses on that set does not ship.',
        'terms' => 'test testing quality evaluation qa nondeterministic random different answers verify check',
    ],
    [
        'id' => 'q159', 'cat' => 'agentic',
        'q' => 'Can we watch an agent work before letting it act?',
        'a' => 'Yes, and we recommend it. Shadow mode runs the agent alongside your team without acting, '
             . 'and its decisions are compared against theirs until the numbers justify letting it act. '
             . 'Usually a fortnight. It also reliably surfaces places where two of your own people would '
             . 'have decided differently.',
        'terms' => 'shadow mode trial pilot watch observe test run parallel before live trust prove safe',
    ],
    [
        'id' => 'q160', 'cat' => 'agentic',
        'q' => 'Who is responsible when an agent makes a decision?',
        'a' => 'You are, which is precisely why the decision boundary is written down before anything ships. '
             . 'We agree on paper which decisions the agent owns, which it only drafts, and which it must '
             . 'escalate. Anything touching money, entitlement or clinical care is drafted and signed by a '
             . 'person.',
        'terms' => 'responsible liability accountable who blame legal decision authority sign off approve',
    ],
    [
        'id' => 'q161', 'cat' => 'agentic',
        'q' => 'Can an agent work with our ERP, CRM or ticketing system?',
        'a' => 'Yes — SAP, Dynamics, Salesforce, Zoho, Tally, NetSuite, Jira, Zendesk and in-house '
             . 'databases. Systems with no API are reached by file, database or interface automation and '
             . 'wrapped behind a proper contract layer, so the rest of the system never has to know the '
             . 'difference.',
        'terms' => 'erp crm integrate connect sap salesforce zoho tally netsuite jira zendesk system api',
    ],
    [
        'id' => 'q162', 'cat' => 'agentic',
        'q' => 'Our ERP has no API. Can anything still be automated?',
        'a' => 'Usually yes. We use whatever it does expose — scheduled file drops, a database view, or '
             . 'interface automation — and put a contract layer in front of it. When the vendor eventually '
             . 'ships an API, you swap the adapter and nothing above it changes.',
        'terms' => 'no api legacy old system cannot integrate erp closed vendor export file database access',
    ],
    [
        'id' => 'q163', 'cat' => 'agentic',
        'q' => 'How do you make sure a retry does not create a duplicate payment?',
        'a' => 'Every write is idempotent and carries a correlation id, so repeating it is safe by '
             . 'construction. This is the most common way agent integrations cause real damage — a timeout '
             . 'that looks like a failure, retried, becoming two invoices — and it is prevented at the '
             . 'integration layer rather than left to the agent.',
        'terms' => 'duplicate retry double payment invoice twice idempotent timeout safe write error repeat',
    ],
    [
        'id' => 'q164', 'cat' => 'agentic',
        'q' => 'Can we audit what an agent did and why?',
        'a' => 'Yes. Every tool call is recorded against the record it touched, with inputs, outputs and the '
             . 'run it belonged to, so an auditor can reconstruct a decision without reading a model log. '
             . 'That is the form the question actually arrives in when a regulator or an enterprise customer '
             . 'asks.',
        'terms' => 'audit trail log history evidence compliance regulator track record proof who did what',
    ],
    [
        'id' => 'q165', 'cat' => 'agentic',
        'q' => 'What workflow should we automate first?',
        'a' => 'Rarely the one that demonstrates best. We score candidates on volume, handling time, error '
             . 'rate, how reversible the actions are, and how much context lives only in one person\'s head. '
             . 'The winner is usually an unglamorous queue nobody enjoys, and that is exactly why it works.',
        'terms' => 'first which workflow start begin pilot choose select priority best use case where start',
    ],
    [
        'id' => 'q166', 'cat' => 'agentic',
        'q' => 'How do we know we are ready for agents at all?',
        'a' => 'Three tests. Are the rules written down somewhere other than in people\'s heads? Are the '
             . 'actions reversible if one is wrong? Can you measure today what good looks like? A no to any '
             . 'of those is not a blocker, but it tells you what phase one actually is — and it is usually '
             . 'not the agent.',
        'terms' => 'ready readiness prepared prerequisite before start suitable fit assess evaluate maturity',
    ],
    [
        'id' => 'q167', 'cat' => 'agentic',
        'q' => 'What if our processes are not documented?',
        'a' => 'That is the normal starting position rather than a disqualification. The first phase becomes '
             . 'establishing what actually happens, which differs from the process document more often than '
             . 'not. It takes longer, and it is worth doing regardless of whether you build the agent.',
        'terms' => 'not documented undocumented no process sop missing documentation unclear rules messy',
    ],
    [
        'id' => 'q168', 'cat' => 'agentic',
        'q' => 'Can an agent handle exceptions, or only the easy cases?',
        'a' => 'It handles the cases you have rules for and routes the rest to a person with its working '
             . 'shown. The measure of a good deployment is how few reach that queue, not that none do. Any '
             . 'design promising zero exceptions is a design that will handle some cases wrongly instead.',
        'terms' => 'exception edge case unusual difficult handle escalate human queue review fallback',
    ],
    [
        'id' => 'q169', 'cat' => 'agentic',
        'q' => 'Does our data leave our systems?',
        'a' => 'Only if you allow it. We run against enterprise endpoints with training disabled, or against '
             . 'open-weight models inside your own infrastructure where residency or contract terms require '
             . 'it. That decision is made before the first line of code, because retrofitting it is a '
             . 'migration.',
        'terms' => 'data leave privacy residency confidential secure cloud onpremise local training share',
    ],
    [
        'id' => 'q170', 'cat' => 'agentic',
        'q' => 'Can agents run entirely on our own servers?',
        'a' => 'Yes, with open-weight models served in your environment. It costs more in engineering and '
             . 'hardware than a hosted API, and below a certain volume a hosted endpoint is genuinely '
             . 'cheaper. For regulated data or restrictive customer contracts it is frequently the only '
             . 'acceptable answer, and we model both before recommending.',
        'terms' => 'on premise onprem self hosted local server own infrastructure private offline air gapped',
    ],
    [
        'id' => 'q171', 'cat' => 'agentic',
        'q' => 'What happens when the AI model we are using is discontinued?',
        'a' => 'We re-run your evaluation set against the replacement, re-tune, and cut over only if it '
             . 'holds. Providers deprecate versions with limited notice, and the teams that get hurt are '
             . 'the ones with no test set to measure the change against. This is what an operations '
             . 'retainer is for.',
        'terms' => 'model deprecated discontinued version change upgrade migrate obsolete provider sunset',
    ],
    [
        'id' => 'q172', 'cat' => 'agentic',
        'q' => 'Do agents get less accurate over time?',
        'a' => 'They do, quietly, unless something is watching. Model versions change under you, your '
             . 'policies change around them, and the mix of cases arriving drifts. We re-run the golden set '
             . 'on a schedule so the decline is caught by us rather than reported by your customer.',
        'terms' => 'drift accuracy degrade worse over time decline maintain monitor quality decay stale',
    ],
    [
        'id' => 'q173', 'cat' => 'agentic',
        'q' => 'Can you take over agents another company built?',
        'a' => 'Regularly, starting with a paid audit: architecture, prompts, tool permissions, whether an '
             . 'evaluation set exists, and what the failure paths actually do. Taking over an agent without '
             . 'that audit is how a support engagement turns into an unplanned rebuild.',
        'terms' => 'take over inherit existing another vendor rescue fix someone else built maintain legacy',
    ],
    [
        'id' => 'q174', 'cat' => 'agentic',
        'q' => 'Who owns the agent and its prompts when the project ends?',
        'a' => 'You do — repository, prompts, evaluation set and infrastructure, all in your accounts from '
             . 'the first week rather than transferred at the end. There is no framework of ours that you '
             . 'end up licensing instead of owning.',
        'terms' => 'own ownership ip intellectual property code prompts source who owns rights transfer',
    ],
    [
        'id' => 'q175', 'cat' => 'agentic',
        'q' => 'Can our own team learn to run this after you leave?',
        'a' => 'That is the intended ending. Your engineers pair with ours through the build and hold the '
             . 'runbook, dashboards and evaluation set at the end. Several clients run their own operations '
             . 'after six months and keep us only for model migrations.',
        'terms' => 'handover train our team learn internal knowledge transfer maintain ourselves after leave',
    ],
    [
        'id' => 'q176', 'cat' => 'agentic',
        'q' => 'What if we want to stop using agents altogether?',
        'a' => 'Then the rollback plan gets used and the workflow returns to its manual path, which is why '
             . 'every autonomous action has a defined reversal. It has happened once, for a process whose '
             . 'rules changed faster than the agent could be retrained. Unwinding cleanly beats defending a '
             . 'decision that stopped making sense.',
        'terms' => 'stop using remove revert cancel discontinue abandon undo go back manual exit reverse',
    ],
    // ---- 13. Generative AI, RAG, chatbots, copilots and vision ------------

    [
        'id' => 'q177', 'cat' => 'ai-native',
        'q' => 'What is RAG and why do we keep hearing about it?',
        'a' => 'Retrieval-augmented generation. Instead of hoping a model already knows your business, you '
             . 'fetch the relevant passages from your own documents and hand them to it with the question. '
             . 'You hear about it constantly because it is the cheapest honest way to make a model answer '
             . 'from your material rather than from the internet.',
        'terms' => 'rag retrieval augmented generation what is meaning explain define vector search grounding',
    ],
    [
        'id' => 'q178', 'cat' => 'ai-native',
        'q' => 'Our AI gives vague or generic answers. What is wrong?',
        'a' => 'Retrieval, nine times out of ten. The model was never shown the right passage, so it '
             . 'answered from general knowledge and sounded plausible doing it. Before touching prompts we '
             . 'measure whether the correct passage is being fetched at all; if it is not, no amount of '
             . 'prompt rewriting fixes it.',
        'terms' => 'vague generic wrong answer bad quality poor irrelevant not accurate useless improve fix',
    ],
    [
        'id' => 'q179', 'cat' => 'ai-native',
        'q' => 'Why not just paste everything into the prompt now that context windows are huge?',
        'a' => 'Cost and precision. A large context is paid for on every single call and spreads attention '
             . 'across irrelevant material, which measurably lowers answer quality on specific questions. '
             . 'Long context is genuinely good for reasoning over one big document; it is a poor substitute '
             . 'for retrieval across ten thousand of them.',
        'terms' => 'context window long large paste everything instead of rag why not big token limit',
    ],
    [
        'id' => 'q180', 'cat' => 'ai-native',
        'q' => 'How do you stop AI from making things up?',
        'a' => 'Three mechanisms, none of which is telling it not to. Answers are grounded in your sources '
             . 'and cite them, outputs are validated against a schema before anything downstream accepts '
             . 'them, and the system is scored on a fixed set of your real cases before release. Where a '
             . 'claim cannot be grounded, it is designed to say so rather than fill the gap.',
        'terms' => 'hallucination making up invent false wrong fabricate lie made up untrue accuracy prevent',
    ],
    [
        'id' => 'q181', 'cat' => 'ai-native',
        'q' => 'What happens if we withdraw a policy the AI has been quoting?',
        'a' => 'Re-indexing runs on change, and deletions propagate. This matters more than it sounds: an '
             . 'assistant confidently quoting a policy you retired last quarter is worse than one that says '
             . 'it does not know, because nobody double-checks an answer that sounds right.',
        'terms' => 'outdated old policy withdraw remove delete stale update refresh change document obsolete',
    ],
    [
        'id' => 'q182', 'cat' => 'ai-native',
        'q' => 'Can the AI be stopped from showing documents people should not see?',
        'a' => 'Yes, and permissions are enforced at retrieval rather than filtered out of the answer '
             . 'afterwards. The distinction matters: a system that fetches a restricted document and then '
             . 'tries not to mention it has already put it into the model context.',
        'terms' => 'permission access control restricted confidential who can see security role private leak',
    ],
    [
        'id' => 'q183', 'cat' => 'ai-native',
        'q' => 'Do we need a special vector database?',
        'a' => 'Usually not at first. pgvector inside the PostgreSQL you already run handles corpora well '
             . 'into the millions of chunks and saves you a whole extra piece of infrastructure to operate. '
             . 'We move to a dedicated store when scale or latency genuinely demand it, which is later than '
             . 'most vendors suggest.',
        'terms' => 'vector database pinecone weaviate pgvector need special store embedding infrastructure',
    ],
    [
        'id' => 'q184', 'cat' => 'ai-native',
        'q' => 'What kinds of documents can be used?',
        'a' => 'PDFs including scanned ones, Word and Excel files, wiki and Confluence pages, ticket '
             . 'history, email archives and database records. Scanned and inconsistently formatted '
             . 'paperwork is where the real work goes — far more than in the embedding step.',
        'terms' => 'documents pdf word excel scan file type support ingest upload confluence wiki email data',
    ],
    [
        'id' => 'q185', 'cat' => 'ai-native',
        'q' => 'What if two of our documents contradict each other?',
        'a' => 'The system dates and ranks sources rather than pretending the conflict is absent. It '
             . 'prefers the most recent authoritative version, shows which document each claim came from, '
             . 'and where two current sources genuinely disagree it says so. Surfacing the contradiction is '
             . 'usually worth more than resolving it silently.',
        'terms' => 'contradict conflict disagree two documents different answers inconsistent which correct',
    ],
    [
        'id' => 'q186', 'cat' => 'ai-assistant',
        'q' => 'How is an AI chatbot different from the one our helpdesk already includes?',
        'a' => 'Most bundled bots match keywords against a list of canned replies. A modern one answers '
             . 'from your actual documentation and product data, cites where the answer came from, and can '
             . 'take real actions like checking an order. The difference shows on the questions nobody '
             . 'wrote a canned reply for, which is most of them.',
        'terms' => 'chatbot different helpdesk zendesk freshdesk builtin included bot compare better why',
    ],
    [
        'id' => 'q187', 'cat' => 'ai-assistant',
        'q' => 'What deflection rate is realistic for a support bot?',
        'a' => 'Sixty percent or better of first-line volume once the content behind it is in reasonable '
             . 'shape — and the content is almost always the limiting factor rather than the model. We '
             . 'report the unanswered questions weekly, because that list is the roadmap for both the bot '
             . 'and your documentation.',
        'terms' => 'deflection rate percent how many tickets reduce support volume savings realistic expect',
    ],
    [
        'id' => 'q188', 'cat' => 'ai-assistant',
        'q' => 'What happens when the bot does not know something?',
        'a' => 'It says so and hands over, with the conversation attached so the customer does not have to '
             . 'repeat themselves. That path is designed first rather than bolted on. A bot that guesses '
             . 'confidently when unsure does more damage to trust than one that escalates twice as often.',
        'terms' => 'bot does not know unknown escalate handover human agent transfer fallback unsure fail',
    ],
    [
        'id' => 'q189', 'cat' => 'ai-assistant',
        'q' => 'Can a chatbot work on WhatsApp?',
        'a' => 'Yes — WhatsApp Business, web widget, in-app, and inside your helpdesk as an agent assist, '
             . 'all running off one backend. That single backend is the point: it stops answers drifting '
             . 'between channels, which is the usual failure when each channel gets its own bot.',
        'terms' => 'whatsapp channel web widget app mobile sms instagram facebook messenger where deploy',
    ],
    [
        'id' => 'q190', 'cat' => 'ai-assistant',
        'q' => 'Can it answer in Tamil, Hindi or other Indian languages?',
        'a' => 'Yes, and it answers in whichever language the question was asked in. The source content '
             . 'stays in one place rather than being maintained per language, which is what stops '
             . 'translations going stale at different rates. We test the specific languages you need '
             . 'before committing to them.',
        'terms' => 'tamil hindi malayalam kannada telugu language indian regional multilingual translate local',
    ],
    [
        'id' => 'q191', 'cat' => 'ai-assistant',
        'q' => 'Can the assistant speak, not just type?',
        'a' => 'Yes. The site already ships server-side speech for Indian languages, because browsers only '
             . 'speak a language when a voice for it is installed and Tamil, Malayalam, Kannada and Telugu '
             . 'voices are absent from most Windows desktops. With a speech provider configured, every '
             . 'supported language gets a real voice.',
        'terms' => 'voice speak audio tts text to speech listen speech sound talk read aloud accessibility',
    ],
    [
        'id' => 'q192', 'cat' => 'ai-assistant',
        'q' => 'Who maintains the chatbot answers after launch?',
        'a' => 'Your team owns the content and the bot reads it. That is deliberate — the moment answers '
             . 'live somewhere only we can edit, you have a dependency nobody asked for. We provide the '
             . 'review queue and the weekly gap report, and can run maintenance on a retainer if you would '
             . 'rather not.',
        'terms' => 'maintain update answers content who manages after launch ongoing edit change ourselves',
    ],
    [
        'id' => 'q193', 'cat' => 'ai-assistant',
        'q' => 'What is an AI copilot and how is it different from a chatbot?',
        'a' => 'Where it lives and who it serves. A chatbot is a destination your customer visits with a '
             . 'question. A copilot sits inside a screen your own team already works in, sees what they are '
             . 'looking at, and offers help without being asked a question at all. The hard part is '
             . 'context, not conversation.',
        'terms' => 'copilot assistant difference chatbot what is inline sidebar internal staff tool helper',
    ],
    [
        'id' => 'q194', 'cat' => 'ai-assistant',
        'q' => 'Does a copilot act on its own?',
        'a' => 'No — it proposes and a person accepts. Anything that writes to a system needs an explicit '
             . 'confirmation rather than an inference. If you want something that acts autonomously, that '
             . 'is agent work and a different engagement.',
        'terms' => 'copilot act automatic autonomous permission confirm approve write change safe control',
    ],
    [
        'id' => 'q195', 'cat' => 'ai-assistant',
        'q' => 'How do we know whether a copilot is actually helping?',
        'a' => 'Accept, edit and reject are recorded per suggestion, so you can see acceptance rate by '
             . 'feature and by user group. That is both the quality signal and the training data for the '
             . 'next iteration. A copilot with a low acceptance rate is not a copilot, it is a distraction, '
             . 'and the numbers say which one you have.',
        'terms' => 'copilot measure roi working useful adoption acceptance metrics value prove worth track',
    ],
    [
        'id' => 'q196', 'cat' => 'ai-assistant',
        'q' => 'Can a copilot be added to software we did not build?',
        'a' => 'Sometimes. If the product has an API or an extension point, yes. If it is a closed desktop '
             . 'application with neither, the honest answer is usually no — and the alternative is '
             . 'automation around it rather than a copilot inside it.',
        'terms' => 'copilot third party software existing application add integrate closed vendor product',
    ],
    [
        'id' => 'q197', 'cat' => 'ai-native',
        'q' => 'How many images do you need to train computer vision?',
        'a' => 'Fewer than people expect for a narrow task — a few hundred well-chosen examples per class '
             . 'often produces a useful first model. Coverage matters far more than volume: images from '
             . 'your actual cameras, your actual lighting, and crucially your actual failure cases.',
        'terms' => 'computer vision images how many training data dataset photos samples need collect label',
    ],
    [
        'id' => 'q198', 'cat' => 'ai-native',
        'q' => 'Why do computer vision projects fail more often than other AI work?',
        'a' => 'Because they are usually validated on tidy sample images and then deployed against a '
             . 'smeared lens in poor light at an angle nobody anticipated. The model is rarely the problem. '
             . 'We insist on collecting from the real environment first, which occasionally means the '
             . 'honest first deliverable is a camera and lighting recommendation.',
        'terms' => 'vision fail problem difficult why hard camera lighting real world accuracy deployment',
    ],
    [
        'id' => 'q199', 'cat' => 'ai-native',
        'q' => 'Does video have to leave our premises for AI inspection?',
        'a' => 'No. Inference can run on the edge next to the camera, which keeps footage on site and means '
             . 'a network outage does not stop the line. That is the usual choice for factory and field '
             . 'deployments, and often the only acceptable one where people appear in frame.',
        'terms' => 'video privacy edge on site cloud upload footage leave premises local camera offline',
    ],
    [
        'id' => 'q200', 'cat' => 'ai-native',
        'q' => 'Can AI read our handwritten forms and invoices?',
        'a' => 'Yes — printed and handwritten forms, invoices, IDs and delivery notes. It is a different '
             . 'pipeline from scene inspection but the same engagement, and it is particularly worth doing '
             . 'where a template-based OCR tool has already been tried and defeated by inconsistent '
             . 'layouts.',
        'terms' => 'ocr handwriting read invoice form document scan extract paper bill receipt id capture',
    ],
    [
        'id' => 'q201', 'cat' => 'ai-native',
        'q' => 'What happens to a vision model when our product or packaging changes?',
        'a' => 'It needs new examples, and the system is built expecting that. Low-confidence frames route '
             . 'to a person for review and their corrections feed the next training round, so a change '
             . 'degrades performance temporarily rather than breaking it. Without that loop, a vision model '
             . 'quietly decays until someone notices yield dropping.',
        'terms' => 'product change packaging new model retrain update degrade maintain vision adapt drift',
    ],
    [
        'id' => 'q202', 'cat' => 'ai-delivery',
        'q' => 'Which AI model do you use, and can we choose?',
        'a' => 'Whichever wins on your tasks — we benchmark rather than assume, and you see the results. In '
             . 'practice a large model handles the difficult minority of cases and a small cheap one '
             . 'handles the bulk, with routing between them. A proposal that names one fixed model is a '
             . 'warning sign: the leaderboard moves every few months and the architecture should not have '
             . 'to.',
        'terms' => 'which model gpt claude gemini llama choose select best compare openai anthropic choice',
    ],
    [
        'id' => 'q203', 'cat' => 'ai-delivery',
        'q' => 'How do you keep AI running costs under control?',
        'a' => 'Routing cheap work to small models, caching what repeats, compressing prompts, and setting '
             . 'token and cost ceilings per run. Together those routinely cut inference cost by more than '
             . 'half. We model cost per thousand operations before building rather than discovering it on '
             . 'an invoice.',
        'terms' => 'cost control expensive reduce cheap token spend bill budget optimise savings inference',
    ],
    [
        'id' => 'q204', 'cat' => 'ai-delivery',
        'q' => 'Is our data used to train the AI provider models?',
        'a' => 'No. We run against enterprise endpoints with training disabled, or against open-weight '
             . 'models inside your own infrastructure where residency or contract terms require it. That '
             . 'decision is made before the first line of code, because retrofitting it is a migration '
             . 'rather than a setting.',
        'terms' => 'training data privacy used confidential leak share provider openai secure gdpr dpdp',
    ],
    [
        'id' => 'q205', 'cat' => 'ai-delivery',
        'q' => 'What does an AI evaluation set actually do for us?',
        'a' => 'It converts "the AI seems worse today" into a number. A fixed collection of your real cases '
             . 'is scored on every prompt change, model change and provider update, so a regression is '
             . 'caught in CI rather than by a customer. It is the single artefact that separates a '
             . 'maintainable AI system from a demo.',
        'terms' => 'evaluation eval golden set test quality measure benchmark regression accuracy score why',
    ],
    [
        'id' => 'q206', 'cat' => 'ai-delivery',
        'q' => 'Can you work with an AI feature another vendor built for us?',
        'a' => 'Yes, starting with a paid audit: architecture, prompts, tool permissions, whether an '
             . 'evaluation set exists, and what happens on failure. Taking one over without that audit is '
             . 'how a support engagement quietly becomes a rebuild, which helps nobody.',
        'terms' => 'another vendor existing take over inherit audit fix rescue previous developer maintain',
    ],
    // ---- 14. Automation, integration and running it afterwards ------------

    [
        'id' => 'q207', 'cat' => 'agentic',
        'q' => 'Is RPA obsolete now that most systems have APIs?',
        'a' => 'Not in India, and not soon. Plenty of the systems running real businesses here — older '
             . 'ERPs, government portals, bank interfaces, industry-specific desktop software — expose '
             . 'nothing usable and the vendor has no plan to change that. RPA is the bridge for exactly '
             . 'those, and far cheaper than the migration that would otherwise be required.',
        'terms' => 'rpa obsolete dead outdated still useful api replace robotic automation worth it relevant',
    ],
    [
        'id' => 'q208', 'cat' => 'agentic',
        'q' => 'Our robots break whenever a screen changes. Can that be avoided?',
        'a' => 'Largely, yes, by engineering them rather than recording them. Recorders capture screen '
             . 'coordinates and shatter on the first layout change. Driving stable element identifiers, '
             . 'handling waits explicitly and defining behaviour on every failure turns a vendor redesign '
             . 'into a fix rather than a rebuild.',
        'terms' => 'robot break fragile screen change layout maintenance brittle fail update selector fix',
    ],
    [
        'id' => 'q209', 'cat' => 'agentic',
        'q' => 'What is the difference between attended and unattended automation?',
        'a' => 'An attended robot runs on someone\'s desktop and helps them with a step while they work. An '
             . 'unattended one runs on a server against a queue with nobody watching. Unattended work needs '
             . 'stronger exception handling for the obvious reason: there is no human present to notice '
             . 'something has gone strange.',
        'terms' => 'attended unattended difference desktop server scheduled background automation types',
    ],
    [
        'id' => 'q210', 'cat' => 'agentic',
        'q' => 'How quickly does automation pay for itself?',
        'a' => 'For a genuinely repetitive task with real volume, usually within a few months. We size that '
             . 'before building by timing the current process, and if the honest sum does not clear the '
             . 'build cost inside a year we say so rather than proceeding.',
        'terms' => 'roi payback worth cost benefit justify business case savings return months investment',
    ],
    [
        'id' => 'q211', 'cat' => 'agentic',
        'q' => 'Is it safe to give automation our system passwords?',
        'a' => 'It is, provided the robot gets its own identity rather than borrowing a person\'s. Each one '
             . 'has credentials scoped to exactly what it needs, kept in a managed secret store, with every '
             . 'action logged against the record it touched. Sharing an employee login with a robot is the '
             . 'practice to avoid, and it is unfortunately common.',
        'terms' => 'password credentials security robot login share account safe secret key access risky',
    ],
    [
        'id' => 'q212', 'cat' => 'agentic',
        'q' => 'What is the difference between automating a task and automating a workflow?',
        'a' => 'A task saves minutes; a workflow removes a queue. The test is whether a case can travel '
             . 'from arrival to resolution without a person re-entering it somewhere in the middle. Most '
             . 'automation programmes stop at tasks and then wonder why nothing changed downstream.',
        'terms' => 'task workflow difference end to end process automate partial full queue scope meaning',
    ],
    [
        'id' => 'q213', 'cat' => 'agentic',
        'q' => 'Where should the decision rules for an automated workflow live?',
        'a' => 'In version control alongside the workflow, so changing how cases are decided is a '
             . 'reviewable commit rather than a prompt somebody edited on a Friday. For anything touching '
             . 'money or entitlement, being able to say exactly what the rule was on a given date matters '
             . 'more than convenience.',
        'terms' => 'rules policy where stored change decision logic version control edit update governance',
    ],
    [
        'id' => 'q214', 'cat' => 'agentic',
        'q' => 'How much manual work does workflow automation actually remove?',
        'a' => 'Forty percent or more of handling time is typical on a well-chosen workflow, and we measure '
             . 'the before honestly so the after means something. Treat anyone quoting ninety percent with '
             . 'suspicion: that number usually counts the happy path and ignores the exception queue '
             . 'entirely.',
        'terms' => 'how much save time reduce manual percent effort savings efficiency realistic expect',
    ],
    [
        'id' => 'q215', 'cat' => 'modernise',
        'q' => 'Can AI work with our old ERP that has no API?',
        'a' => 'Usually yes. We use whatever it does expose — scheduled file drops, a database view, or '
             . 'interface automation — and put a proper contract layer in front of it. When the vendor '
             . 'eventually ships an API you swap the adapter and nothing above it has to change.',
        'terms' => 'old erp legacy no api integrate connect ancient system tally sap outdated software bridge',
    ],
    [
        'id' => 'q216', 'cat' => 'modernise',
        'q' => 'Will connecting AI slow our existing systems down?',
        'a' => 'It should not, and it is designed against: rate limits per connector, caching for reads '
             . 'that repeat, and queueing for writes so a burst does not arrive at your ERP all at once. '
             . 'Worth taking seriously, because agents generate load in patterns no human user ever would.',
        'terms' => 'slow performance load impact existing system speed degrade server capacity overload',
    ],
    [
        'id' => 'q217', 'cat' => 'modernise',
        'q' => 'Do we have to replace our current systems to use AI?',
        'a' => 'Almost never, and anyone who says otherwise is selling a rewrite. The usual shape is a '
             . 'layer beside what you run, reading and writing through a contract, with the existing system '
             . 'untouched. Replacement becomes the answer only when the system itself is the constraint.',
        'terms' => 'replace existing system rewrite migrate keep current must change upgrade whole new',
    ],
    [
        'id' => 'q218', 'cat' => 'ai-delivery',
        'q' => 'Who is accountable if an AI system makes a costly mistake?',
        'a' => 'You are, which is exactly why the decision boundary is agreed in writing before anything '
             . 'ships: what the system decides, what it only drafts, and what it must escalate. Anything '
             . 'touching money, entitlement or clinical care is drafted by the system and signed by a '
             . 'person.',
        'terms' => 'accountable liable responsible mistake costly error legal blame insurance risk who fault',
    ],
    [
        'id' => 'q219', 'cat' => 'ai-delivery',
        'q' => 'What evidence can you produce if a regulator asks how a decision was made?',
        'a' => 'The full action trail: every tool call recorded against the record it touched, with inputs, '
             . 'outputs and the run it belonged to. An auditor can reconstruct a decision without reading a '
             . 'model log, which is the form the question actually arrives in.',
        'terms' => 'regulator audit evidence compliance proof explain decision rbi irdai sebi hipaa report',
    ],
    [
        'id' => 'q220', 'cat' => 'ai-delivery',
        'q' => 'Does India\'s DPDP Act affect what we can build?',
        'a' => 'It affects where personal data goes, how long you keep it, and what you can evidence about '
             . 'both — so it shapes architecture rather than blocking it. We design for residency and '
             . 'retention up front and produce the records your auditor asks for. We are not your lawyers, '
             . 'and for regulated work we expect to sit alongside your counsel.',
        'terms' => 'dpdp act india data protection law compliance legal privacy regulation personal gdpr',
    ],
    [
        'id' => 'q221', 'cat' => 'ai-delivery',
        'q' => 'Can everything run inside our own infrastructure?',
        'a' => 'Yes, with open-weight models served in your environment and local embedding, so no content '
             . 'leaves. It costs more in engineering and hardware than a hosted API, and below a certain '
             . 'volume hosted is genuinely cheaper. For regulated data or restrictive customer contracts it '
             . 'is frequently the only acceptable answer.',
        'terms' => 'on premise self host private cloud own server local air gapped offline data residency',
    ],
    [
        'id' => 'q222', 'cat' => 'ai-delivery',
        'q' => 'What happens to our AI system if we stop working with you?',
        'a' => 'It keeps running, because it was never dependent on us. Repository, prompts, evaluation '
             . 'set, infrastructure accounts and runbooks are yours from the first week rather than handed '
             . 'over at the end. Several clients run their own operations after six months and keep us only '
             . 'for model migrations.',
        'terms' => 'stop working leave exit end contract dependency lock in handover continue own transfer',
    ],
    [
        'id' => 'q223', 'cat' => 'engagement',
        'q' => 'Do we need an AI strategy before we build anything?',
        'a' => 'You need one before you build the third thing. For a first, well-understood use case, a '
             . 'strategy engagement can be overhead. Once several departments want their own AI features, '
             . 'the absence of a strategy shows up as duplicated effort and an unreadable bill.',
        'terms' => 'strategy first consulting before build need roadmap planning necessary start approach',
    ],
    [
        'id' => 'q224', 'cat' => 'engagement',
        'q' => 'Will you tell us not to build something?',
        'a' => 'Regularly, and it is a normal outcome rather than a failed engagement. If a packaged '
             . 'product models your workflow well, a licence is cheaper than a build and we say so in '
             . 'writing. We make our money on the builds worth building.',
        'terms' => 'not build recommend against honest buy instead licence advice dont waste money truth',
    ],
    [
        'id' => 'q225', 'cat' => 'engagement',
        'q' => 'Can we hire your AI engineers into our own team?',
        'a' => 'Yes, as an embedded arrangement: named people working in your repository, your tracker and '
             . 'your stand-up, monthly and resizable monthly. Not a rotating pool — context is most of the '
             . 'value after the first month, and a pool destroys it.',
        'terms' => 'hire engineers developers staff augmentation embed team resource dedicated rent people',
    ],
    [
        'id' => 'q226', 'cat' => 'engagement',
        'q' => 'Can we trial your engineers before committing?',
        'a' => 'Yes — a paid two-week trial on a real piece of your backlog, which we recommend and most '
             . 'clients take. It tells you more than any interview, and it is what we would want in your '
             . 'position.',
        'terms' => 'trial test try before commit pilot evaluate engineers sample two week prove quality',
    ],
    [
        'id' => 'q227', 'cat' => 'engagement',
        'q' => 'What is the minimum commitment for a dedicated engineer?',
        'a' => 'Monthly, and resizable monthly. A team you cannot resize is a hire with extra steps and '
             . 'none of the benefits. Most engagements run three to nine months and step down as your own '
             . 'team picks the work up.',
        'terms' => 'minimum commitment contract length monthly notice period cancel scale down flexible',
    ],
    [
        'id' => 'q228', 'cat' => 'growth',
        'q' => 'Which of our departments should try AI first?',
        'a' => 'The one with a queue, written rules and reversible actions — usually support, finance '
             . 'operations or document handling. Sales and marketing feel like the obvious first choice and '
             . 'are frequently the worst, because the work is judgement-heavy and success is hard to '
             . 'measure honestly.',
        'terms' => 'which department first start pilot sales marketing finance hr support operations best',
    ],
    [
        'id' => 'q229', 'cat' => 'growth',
        'q' => 'How do we measure whether an AI project actually worked?',
        'a' => 'Decide the number before building, not after. Cases handled, handling time, deflection '
             . 'rate, error rate and cost per case are the usual ones, measured in the same way before and '
             . 'after. A project with no baseline cannot be evaluated, only defended.',
        'terms' => 'measure success roi metrics kpi prove worked value baseline evaluate results track',
    ],
    [
        'id' => 'q230', 'cat' => 'growth',
        'q' => 'Our last AI pilot stalled. What usually causes that?',
        'a' => 'In the ones we are asked to rescue, almost always the workflow chosen. Either its rules '
             . 'were never actually written down, or two departments disagreed about what they are, and no '
             . 'model resolves a policy dispute. The second most common cause is a pilot with no evaluation '
             . 'set, so nobody could say whether it was good enough to continue.',
        'terms' => 'pilot stalled failed poc stuck abandoned why fail unsuccessful restart rescue lessons',
    ],
    [
        'id' => 'q231', 'cat' => 'growth',
        'q' => 'How long before we see something real, not a demo?',
        'a' => 'Three to eight weeks for most first features, depending on integration count. A demo can '
             . 'exist in days; the gap between the two is the evaluation set, the validation, the failure '
             . 'paths and the cost controls — which is also the gap between something that impresses in a '
             . 'meeting and something you can leave switched on.',
        'terms' => 'how long real production not demo timeline weeks deliver first value quick see results',
    ],
    [
        'id' => 'q232', 'cat' => 'cloud',
        'q' => 'Do we need a GPU server to run AI?',
        'a' => 'Usually not. Hosted model APIs need no hardware at all, and most workloads never justify '
             . 'buying GPUs. You need your own when data residency forbids a hosted API, when volume makes '
             . 'per-token pricing worse than hardware, or for vision models running at the edge.',
        'terms' => 'gpu server hardware buy nvidia infrastructure need expensive machine compute requirement',
    ],
    [
        'id' => 'q233', 'cat' => 'cloud',
        'q' => 'How do you stop AI spend getting out of control across teams?',
        'a' => 'One gateway every call routes through, with per-team keys, quotas and cost attribution. The '
             . 'common failure is not one expensive feature — it is twenty teams each making calls nobody '
             . 'is tracking until the invoice lands.',
        'terms' => 'ai spend control cost runaway bill budget teams quota track attribute finance expensive',
    ],
    [
        'id' => 'q234', 'cat' => 'cloud',
        'q' => 'What happens when our AI provider has an outage?',
        'a' => 'With a gateway in front, traffic fails over to a secondary provider or a smaller local '
             . 'model, so an outage degrades a feature rather than taking down an application. Without that '
             . 'layer, every integration inherits the provider\'s availability directly.',
        'terms' => 'outage down provider fails availability uptime backup fallback redundancy disaster',
    ],
    [
        'id' => 'q235', 'cat' => 'ai-delivery',
        'q' => 'Do AI systems need maintenance, or are they finished at launch?',
        'a' => 'They need it more than ordinary software, not less. Model versions change under you, your '
             . 'policies change around them, and the mix of incoming cases drifts. Left alone, an AI system '
             . 'gets quietly less accurate while sounding exactly as confident as it did on day one.',
        'terms' => 'maintenance ongoing support after launch finished done upkeep retainer monitor degrade',
    ],
    [
        'id' => 'q236', 'cat' => 'ai-delivery',
        'q' => 'How would we even notice if the AI got worse?',
        'a' => 'Without monitoring, usually from a customer complaint. With it, from the scheduled re-run '
             . 'of your evaluation set, plus live tracking of refusal rates, tool failures and schema '
             . 'violations. The whole point of an operations retainer is that we see it before your users '
             . 'do.',
        'terms' => 'notice worse degrade detect monitor alert quality drop accuracy decline spot problem',
    ],
    // ---- 15. Voice, Indian languages, industries and commercials ----------

    [
        'id' => 'q237', 'cat' => 'ai-assistant',
        'q' => 'Can an AI assistant hold a conversation in Tamil or Hindi?',
        'a' => 'Yes, in all six languages this site supports: English, Tamil, Malayalam, Kannada, Telugu '
             . 'and Hindi. It answers in the language it was asked in, and the underlying content is '
             . 'maintained once in one place rather than separately per language, which is what stops '
             . 'translations going stale at different rates.',
        'terms' => 'tamil hindi malayalam kannada telugu conversation language indian regional speak native',
    ],
    [
        'id' => 'q238', 'cat' => 'ai-assistant',
        'q' => 'Do you store a separate copy of every answer in every language?',
        'a' => 'No, deliberately. That approach needs hundreds of fixed strings and still misses, because '
             . 'people rarely phrase a question the way you guessed they would. Instead a question in any '
             . 'supported language is normalised into the concepts the answer book indexes, then scored the '
             . 'same way an English one is. Paraphrases match, and so do the mixed-script questions people '
             . 'actually type on Indian keyboards.',
        'terms' => 'translate stored copy each language separate translation how works multilingual matching',
    ],
    [
        'id' => 'q239', 'cat' => 'ai-assistant',
        'q' => 'Why does the assistant speak some languages but not others in my browser?',
        'a' => 'Because a browser only speaks a language when a voice for it is installed, and Tamil, '
             . 'Malayalam, Kannada and Telugu voices are missing from most Windows desktops. That is why '
             . 'the site supports a server-side speech provider: with one configured, every supported '
             . 'language gets a real voice regardless of what the device has.',
        'terms' => 'voice not working silent no sound speech missing browser windows language tts problem',
    ],
    [
        'id' => 'q240', 'cat' => 'ai-assistant',
        'q' => 'Can customers talk to the system instead of typing?',
        'a' => 'Yes — speech in and speech out, including the Indian languages. It matters most for field '
             . 'staff with gloves or a phone in a pocket, and for customers who are comfortable speaking a '
             . 'language they are less comfortable typing. That second group is larger than most product '
             . 'teams assume.',
        'terms' => 'voice input speak talk microphone speech to text dictate call audio hands free customer',
    ],
    [
        'id' => 'q241', 'cat' => 'ai-assistant',
        'q' => 'Can an AI agent answer phone calls?',
        'a' => 'Yes, for defined jobs: qualifying an inbound enquiry, confirming an appointment, chasing a '
             . 'document. Under about four hundred milliseconds of round-trip latency it feels like a '
             . 'conversation; above it, people talk over it. We scope voice tightly, because a voice agent '
             . 'that mishandles an edge case annoys a customer far faster than a chat one.',
        'terms' => 'phone call voice agent ivr inbound outbound telephony answer calls automated speaking',
    ],
    [
        'id' => 'q242', 'cat' => 'ecommerce',
        'q' => 'What does AI actually do for an online store?',
        'a' => 'Three things reliably: better search and recommendations, automated catalogue enrichment, '
             . 'and support deflection on order and returns questions. Everything else is worth piloting '
             . 'before believing. Recommendation quality depends on your own behavioural data, so a new '
             . 'store sees less lift than an established one.',
        'terms' => 'ecommerce store online retail shop ai what does help sales recommendation search catalog',
    ],
    [
        'id' => 'q243', 'cat' => 'ecommerce',
        'q' => 'Can AI write our product descriptions?',
        'a' => 'Yes, and catalogue enrichment is one of the clearest wins — thousands of descriptions, '
             . 'attributes and alt texts generated from what you already hold, in your own tone. Expect to '
             . 'review a sample rather than every line, and to keep a human on anything where a wrong '
             . 'claim would be a compliance problem.',
        'terms' => 'product description write catalog content generate copy seo attributes bulk listing',
    ],
    [
        'id' => 'q244', 'cat' => 'ecommerce',
        'q' => 'Will AI reduce our returns?',
        'a' => 'It can, mostly by fixing the things that cause returns — vague descriptions, missing '
             . 'dimensions, poor size guidance and mismatched images. The measurable reductions we have '
             . 'seen came from better pre-purchase information, not from a model predicting who will '
             . 'return something.',
        'terms' => 'returns reduce refund rate exchange size fit prediction ecommerce decrease problem',
    ],
    [
        'id' => 'q245', 'cat' => 'apps',
        'q' => 'Can AI features work in a mobile app offline?',
        'a' => 'Partly. Small on-device models handle classification, extraction and voice capture without '
             . 'a connection; anything needing a large model queues until the device reconnects. For field '
             . 'apps we design the offline path first, because a feature that fails without signal is a '
             . 'feature that fails in exactly the place it was needed.',
        'terms' => 'offline mobile app no internet connection field device on device sync queue signal',
    ],
    [
        'id' => 'q246', 'cat' => 'apps',
        'q' => 'Does adding AI make our app slower or bigger?',
        'a' => 'Bigger only if a model ships inside the binary, which we avoid unless offline demands it. '
             . 'Slower only if a call sits in the critical path of a screen, which is a design choice '
             . 'rather than a necessity — AI work belongs off the render path, with the interface showing '
             . 'progress rather than blocking.',
        'terms' => 'app size slow performance bigger heavy bundle speed lag battery impact mobile add',
    ],
    [
        'id' => 'q247', 'cat' => 'saas',
        'q' => 'We are a small SaaS. Is agentic AI out of our reach?',
        'a' => 'No, and the archetype route exists precisely for this: a proven agent configured against '
             . 'your systems in days rather than a custom build over months. What is genuinely out of reach '
             . 'for a small team is operating a bespoke multi-agent system without anyone to watch it.',
        'terms' => 'small business startup afford cheap budget limited resources smb feasible expensive',
    ],
    [
        'id' => 'q248', 'cat' => 'saas',
        'q' => 'Should we build AI features into our SaaS or integrate an existing one?',
        'a' => 'Integrate unless the AI is the product. If a customer would switch to you because of that '
             . 'feature, build it and own the quality. If it is table stakes that everyone will have next '
             . 'year, integrate and spend your engineering where you actually differ.',
        'terms' => 'build integrate saas feature own third party differentiate product decision buy make',
    ],
    [
        'id' => 'q249', 'cat' => 'saas',
        'q' => 'How do we price an AI feature when inference costs money every time?',
        'a' => 'Meter it, cap it, and know your cost per action before launch. The failure we see most is a '
             . 'flat-price tier with an uncapped AI feature inside it, where the heaviest ten percent of '
             . 'users quietly consume the margin of the other ninety.',
        'terms' => 'price pricing saas ai feature charge cost per user margin meter usage tier monetise',
    ],
    [
        'id' => 'q250', 'cat' => 'ai-delivery',
        'q' => 'How do you handle security testing for an AI system?',
        'a' => 'The usual application review — dependencies, secrets, permissions, OWASP pass — plus the '
             . 'AI-specific ones: prompt injection through any content the system reads, tool permission '
             . 'scope, and whether a crafted input can make it reach data the user is not entitled to. The '
             . 'second set is what a conventional pen test misses.',
        'terms' => 'security test pentest vulnerability owasp review hack safe audit assessment penetration',
    ],
    [
        'id' => 'q251', 'cat' => 'ai-delivery',
        'q' => 'Can an AI system be tricked by a malicious document?',
        'a' => 'It can be attempted, and the defence is architectural rather than hopeful. Untrusted '
             . 'content is treated as data and never as instruction, and tool access is scoped so a '
             . 'successful injection cannot reach anything the system was not already permitted to touch. '
             . 'You bound the blast radius rather than trusting the model to resist.',
        'terms' => 'malicious document attack inject trick manipulate poison hostile content hack exploit',
    ],
    [
        'id' => 'q252', 'cat' => 'ai-delivery',
        'q' => 'What does an AI project actually cost?',
        'a' => 'A focused first feature usually lands in the low lakhs; a production platform several teams '
             . 'depend on runs considerably higher. The number moves most on integration count, whether '
             . 'data has to be migrated, and whether the environment is regulated. We give a written '
             . 'estimate with the assumptions attached so you can see what would change it.',
        'terms' => 'cost price budget how much expensive quote estimate lakhs rupees project fee charges',
    ],
    [
        'id' => 'q253', 'cat' => 'ai-delivery',
        'q' => 'Why do AI quotes vary so wildly between vendors?',
        'a' => 'Usually because they are quoting different things. A demo costs a fraction of a system with '
             . 'an evaluation set, failure paths, permissions and monitoring. When comparing, ask each '
             . 'vendor what happens when the model is wrong — the answer separates the two prices '
             . 'immediately.',
        'terms' => 'quote vary different price compare vendors cheap expensive why difference proposal',
    ],
    [
        'id' => 'q254', 'cat' => 'engagement',
        'q' => 'Do you work with companies outside India?',
        'a' => 'Yes — we deliver across India, the Gulf and the United States, and work in your timezone '
             . 'for the overlap that matters. Being physically present helps most during discovery, when '
             . 'sitting in a room with the people whose workflow you are modelling is worth a great deal.',
        'terms' => 'outside india international overseas usa uk gulf dubai global remote timezone abroad',
    ],
    [
        'id' => 'q255', 'cat' => 'engagement',
        'q' => 'Where are your teams based?',
        'a' => 'Chennai and Coimbatore, with delivery across India and abroad. For clients in Tamil Nadu '
             . 'that means we can be in the room for discovery, which consistently produces a better audit '
             . 'than a remote one — the exceptions people never mention on a call tend to surface when you '
             . 'are watching the work happen.',
        'terms' => 'location office where based chennai coimbatore bangalore india city address local team',
    ],
    [
        'id' => 'q256', 'cat' => 'growth',
        'q' => 'Everyone is talking about agents. Are we behind?',
        'a' => 'Probably not. Most organisations talking about agents are running pilots, not production '
             . 'systems, and a good number of those pilots will be quietly shelved. Being second with a '
             . 'workflow that actually works beats being first with a demo, and the groundwork that makes '
             . 'agents viable — written rules, clean data, measurable outcomes — is worth doing regardless.',
        'terms' => 'behind competitors everyone else late catch up fomo market trend industry pressure',
    ],
    [
        'id' => 'q257', 'cat' => 'growth',
        'q' => 'What is the smallest sensible first step?',
        'a' => 'Pick one queue, measure how long it takes today, and automate the majority case with a '
             . 'person on the exceptions. It is unglamorous, it is finishable in weeks, and it produces the '
             . 'one thing every later phase depends on: a real number for how well this works in your '
             . 'organisation.',
        'terms' => 'smallest first step start begin minimum pilot try small simple cheap test where begin',
    ],
    [
        'id' => 'q258', 'cat' => 'modernise',
        'q' => 'Our data is messy. Do we have to clean it first?',
        'a' => 'Some of it, and less than you fear. Retrieval tolerates messy prose surprisingly well; what '
             . 'it does not tolerate is the same concept recorded three different ways across three '
             . 'systems. We sample your real records early and tell you which subset actually needs work '
             . 'before anything can be built on it.',
        'terms' => 'messy data dirty clean quality unstructured prepare ready garbage poor incomplete fix',
    ],
    [
        'id' => 'q259', 'cat' => 'modernise',
        'q' => 'How much historical data do we need?',
        'a' => 'For retrieval and document work, none — it answers from what exists today. For forecasting '
             . 'or anomaly detection you want at least a year, ideally two, and it has to be consistently '
             . 'recorded across that span. A decade of history with a system change in the middle is often '
             . 'worth less than two clean years.',
        'terms' => 'historical data how much years need training amount volume enough history records',
    ],
    [
        'id' => 'q260', 'cat' => 'ai-native',
        'q' => 'What is the difference between fine-tuning and retrieval?',
        'a' => 'Retrieval gives the model your facts at question time; fine-tuning teaches it your style or '
             . 'a narrow task. Most business problems are facts problems, so retrieval is the usual answer '
             . 'and it updates the moment a document changes. Fine-tuning earns its place for consistent '
             . 'formatting or a specialised classification, not for keeping knowledge current.',
        'terms' => 'fine tuning training retrieval rag difference which better custom model teach adapt',
    ],
    [
        'id' => 'q261', 'cat' => 'ai-native',
        'q' => 'Do we need to train our own model?',
        'a' => 'Almost certainly not. Training a model from scratch is a research budget, and for the vast '
             . 'majority of business problems a good retrieval setup over an existing model beats it on '
             . 'both cost and accuracy. Fine-tuning an open-weight model is occasionally worthwhile; '
             . 'starting from nothing essentially never is.',
        'terms' => 'train own model custom build from scratch proprietary llm need our own develop',
    ],
    [
        'id' => 'q262', 'cat' => 'agentic',
        'q' => 'Can agents and humans work the same queue together?',
        'a' => 'Yes, and it is the shape most deployments settle into. The agent takes the majority case, '
             . 'routes anything low-confidence or out-of-policy to a person with its reasoning attached, '
             . 'and the person\'s correction is recorded. Fully autonomous queues are rarer than the '
             . 'marketing suggests, and usually less valuable.',
        'terms' => 'human agent together hybrid queue collaborate mixed team work alongside share handoff',
    ],
    [
        'id' => 'q263', 'cat' => 'agentic',
        'q' => 'How many agents would a mid-sized company realistically run?',
        'a' => 'Two to five in the first year, not twenty. Each one needs an owner, an evaluation set and '
             . 'somewhere its exceptions land. Organisations that deploy a dozen quickly discover that '
             . 'operating them is the real cost, and that half were solving problems nobody had measured.',
        'terms' => 'how many agents realistic number typical company run deploy scale first year count',
    ],
    [
        'id' => 'q264', 'cat' => 'engagement',
        'q' => 'What do you need from us to start?',
        'a' => 'Someone who owns the outcome, someone who knows where the data actually lives, and an hour '
             . 'or two with the people who do the work being considered. That last group is the one usually '
             . 'left out and the one that matters most — they know the exceptions, and the exceptions '
             . 'decide whether any of this is feasible.',
        'terms' => 'what need from us start requirements prepare kickoff involve people time commitment',
    ],
    [
        'id' => 'q265', 'cat' => 'engagement',
        'q' => 'Can you work alongside our existing development team?',
        'a' => 'Yes, and that is the common arrangement rather than the exception. We work in your '
             . 'repository, your tracker and your review process, and your engineers pair with ours through '
             . 'the build. If an engagement is not reducing your dependence on us over time, it is not '
             . 'working properly.',
        'terms' => 'work with our team existing developers alongside collaborate internal pair augment',
    ],
    [
        'id' => 'q266', 'cat' => 'engagement',
        'q' => 'What happens in the first two weeks?',
        'a' => 'We measure rather than build. The processes under consideration get timed — volume, '
             . 'handling time, error rate, rework — and scored on how reversible their actions are and how '
             . 'much context lives only in someone\'s head. You get a written recommendation at the end, '
             . 'including anything we think you should not build yet.',
        'terms' => 'first two weeks start begin what happens initial phase discovery kickoff onboarding',
    ],

    /* ======================================================================
       The ten answers published on each of the sixteen AI service pages.

       Added once each, not once per language. faq-brain.php normalises a
       Tamil, Malayalam, Kannada, Telugu or Hindi question into the English
       concepts below and scores it against every entry, so one entry answers
       in all six languages -- and catches paraphrases, which a stored
       translation never does. The Indic vocabulary for this new subject
       matter lives in FAQ_LEXICON.

       'terms' deliberately avoids repeating the question's own words:
       faq_match() already scores a question-text hit at two points, so the
       index is spent on synonyms and domain vocabulary instead.
       ====================================================================== */

    // ---- AI Consulting ---- (services/ai-consulting.php)

    [
        'id' => 'q267', 'cat' => 'page-faq',
        'q' => 'What is the primary goal of an Enterprise AI Consulting engagement?',
        'a' => 'Our AI consulting engagements evaluate your operational workflows, identify '
             . 'high-leverage automation opportunities, determine technical and financial '
             . 'feasibility, and deliver an actionable production architecture that guarantees '
             . 'measurable ROI.',
        'terms' => 'consulting consultant advisory strategy roadmap audit feasibility assessment '
             . 'readiness governance roi business case actionable architecture automation '
             . 'deliver determine engagements evaluate financial guarantees high identify',
    ],
    [
        'id' => 'q268', 'cat' => 'page-faq',
        'q' => 'How do you determine whether an enterprise should use an open-source model or a '
             . 'commercial API?',
        'a' => 'We evaluate your specific use case against data sovereignty requirements, latency '
             . 'constraints, token volume, and budget. For regulated industries with strict '
             . 'privacy needs or massive token volumes, fine-tuned open-source models (like Llama '
             . 'or Mistral on private VPCs) often deliver 80% lower cost and total privacy. For '
             . 'generalized reasoning with variable load, commercial APIs with enterprise '
             . 'zero-retention agreements may be recommended.',
        'terms' => 'consulting consultant advisory strategy roadmap audit feasibility assessment '
             . 'readiness governance roi business case privacy token against agreements apis '
             . 'budget constraints cost deliver evaluate fine',
    ],
    [
        'id' => 'q269', 'cat' => 'page-faq',
        'q' => 'How do you calculate the projected ROI of an AI initiative before building?',
        'a' => 'We quantify the exact baseline hours spent on manual workflows, error rates, '
             . 'customer wait times, and direct labor costs, then model the efficiency uplift, '
             . 'labor deflection, and compute hosting expenses to provide an unambiguous net ROI '
             . 'and payback timeline.',
        'terms' => 'consulting consultant advisory strategy roadmap audit feasibility assessment '
             . 'readiness governance roi business case labor baseline compute costs '
             . 'deflection direct efficiency error exact expenses hosting hours',
    ],
    [
        'id' => 'q270', 'cat' => 'page-faq',
        'q' => 'How do you ensure our sensitive business data remains private during the audit?',
        'a' => 'All discovery and prototyping are conducted under strict mutual NDAs using '
             . 'air-gapped sandboxes or private VPC enclaves. Your proprietary data is never '
             . 'logged, stored on unauthorized machines, or sent to public foundation model '
             . 'training queues.',
        'terms' => 'consulting consultant advisory strategy roadmap audit feasibility assessment '
             . 'readiness governance roi business case conducted discovery enclaves '
             . 'foundation gapped logged machines mutual ndas never proprietary prototyping',
    ],
    [
        'id' => 'q271', 'cat' => 'page-faq',
        'q' => 'What deliverables do we receive at the conclusion of the consulting engagement?',
        'a' => 'You receive a complete Executive AI Roadmap, Technical Architecture Blueprints, '
             . 'Data Readiness & Governance Audit, Model Sizing & Cost Projection Report, and a '
             . 'step-by-step Implementation Plan ready for engineering execution.',
        'terms' => 'consulting consultant advisory strategy roadmap audit feasibility assessment '
             . 'readiness governance roi business case step architecture blueprints complete '
             . 'cost engineering execution executive implementation plan',
    ],
    [
        'id' => 'q272', 'cat' => 'page-faq',
        'q' => 'Can you help modernize our existing legacy software systems with AI?',
        'a' => 'Yes. We specialize in non-invasive modernization patterns, such as sidecar '
             . 'microservices and universal API gateways, allowing you to add cutting-edge AI '
             . 'capabilities without rewriting or destabilizing your revenue-generating legacy '
             . 'applications.',
        'terms' => 'consulting consultant advisory strategy roadmap audit feasibility assessment '
             . 'readiness governance roi business case allowing applications capabilities '
             . 'cutting destabilizing edge gateways generating invasive microservices '
             . 'modernization patterns',
    ],
    [
        'id' => 'q273', 'cat' => 'page-faq',
        'q' => 'How long does a typical AI consulting and discovery engagement take?',
        'a' => 'Our standard AI Strategy Sprint runs for 2 weeks, while deep-dive '
             . 'multi-department enterprise architecture audits typically span 3 to 4 weeks '
             . 'depending on organizational complexity.',
        'terms' => 'consulting consultant advisory strategy roadmap audit feasibility assessment '
             . 'readiness governance roi business case weeks architecture audits complexity '
             . 'deep department depending dive multi organizational runs span',
    ],
    [
        'id' => 'q274', 'cat' => 'page-faq',
        'q' => 'How do you address AI safety, hallucinations, and prompt injection risks?',
        'a' => 'We design multi-tier defense architectures incorporating deterministic guardrails '
             . '(such as NeMo Guardrails and Llama Guard), schema-constrained JSON outputs, '
             . 'semantic chunk validation, and automated red-teaming harnesses.',
        'terms' => 'consulting consultant advisory strategy roadmap audit feasibility assessment '
             . 'readiness governance roi business case guardrails architectures automated '
             . 'chunk constrained defense design deterministic guard harnesses incorporating '
             . 'json',
    ],
    [
        'id' => 'q275', 'cat' => 'page-faq',
        'q' => 'Do you provide the engineering team to build the solution after consulting?',
        'a' => 'Yes. iThrive provides end-to-end capabilities: from strategic advisory and '
             . 'architectural blueprinting to dedicated full-stack AI engineering squads that '
             . 'build, test, and maintain the production platform.',
        'terms' => 'consulting consultant advisory strategy roadmap audit feasibility assessment '
             . 'readiness governance roi business case architectural blueprinting '
             . 'capabilities dedicated full maintain platform squads stack strategic test',
    ],
    [
        'id' => 'q276', 'cat' => 'page-faq',
        'q' => 'How do you handle change management and user adoption across our workforce?',
        'a' => 'We structure intuitive human-in-the-loop interfaces, comprehensive role-based '
             . 'training modules, and gradual cohort rollouts with confidence scoring, ensuring '
             . 'your employees view AI as an empowering copilot rather than an unpredictable '
             . 'disruption.',
        'terms' => 'consulting consultant advisory strategy roadmap audit feasibility assessment '
             . 'readiness governance roi business case based cohort comprehensive confidence '
             . 'copilot disruption employees empowering ensuring gradual human interfaces',
    ],

    // ---- Generative AI Development ---- (services/gen-ai-development.php)

    [
        'id' => 'q277', 'cat' => 'page-faq',
        'q' => 'What is the difference between Generative AI fine-tuning and RAG?',
        'a' => 'RAG (Retrieval-Augmented Generation) injects dynamic contextual documents into a '
             . 'generic model prompt at runtime, while Fine-Tuning fundamentally modifies the '
             . 'model weights so it learns domain vocabulary, tone, and complex reasoning '
             . 'patterns directly. We frequently combine both: a fine-tuned domain model querying '
             . 'an enterprise vector database.',
        'terms' => 'generative genai llm foundation model finetune finetuning lora qlora '
             . 'diffusion synthetic prompt training custom domain augmented combine complex '
             . 'contextual database directly documents dynamic frequently fundamentally '
             . 'generation',
    ],
    [
        'id' => 'q278', 'cat' => 'page-faq',
        'q' => 'How do you prevent hallucinations in Generative AI applications?',
        'a' => 'We implement multi-layered safeguards: temperature minimization, '
             . 'schema-constrained decoding (e.g., Guidance, Outlines), citation-enforced '
             . 'retrieval, and secondary validator models that verify all factual assertions '
             . 'before delivering output.',
        'terms' => 'generative genai llm foundation model finetune finetuning lora qlora '
             . 'diffusion synthetic prompt training custom assertions citation constrained '
             . 'decoding delivering enforced factual guidance implement layered minimization '
             . 'multi',
    ],
    [
        'id' => 'q279', 'cat' => 'page-faq',
        'q' => 'Can you deploy Generative AI models inside our private cloud or on-premise '
             . 'servers?',
        'a' => 'Yes. 100% of our enterprise Generative AI deployments can be hosted inside your '
             . 'private AWS, Azure, GCP VPCs or on-premise air-gapped GPU servers (using '
             . 'Kubernetes and vLLM/TensorRT) with zero outbound internet connectivity.',
        'terms' => 'generative genai llm foundation model finetune finetuning lora qlora '
             . 'diffusion synthetic prompt training custom azure connectivity deployments '
             . 'gapped hosted internet kubernetes outbound tensorrt vllm vpcs zero',
    ],
    [
        'id' => 'q280', 'cat' => 'page-faq',
        'q' => 'How much training data is required to fine-tune a domain model?',
        'a' => 'With parameter-efficient fine-tuning (LoRA/QLoRA), high-quality domain adaptation '
             . 'can be achieved with as few as 1,000 to 10,000 meticulously formatted instruction '
             . 'pairs. We also synthesize high-quality training data from your raw historical '
             . 'documents.',
        'terms' => 'generative genai llm foundation model finetune finetuning lora qlora '
             . 'diffusion synthetic prompt training custom high quality achieved adaptation '
             . 'documents efficient formatted historical instruction meticulously pairs',
    ],
    [
        'id' => 'q281', 'cat' => 'page-faq',
        'q' => 'What hardware and GPU infrastructure is required to run self-hosted models?',
        'a' => 'Quantized 7B to 14B parameter models run with ultra-low latency on single '
             . 'commercial GPUs (e.g., NVIDIA L4, A10G, or RTX 4090), while 70B parameter models '
             . 'require multi-GPU nodes (such as 2x to 4x NVIDIA A100/H100). We right-size the '
             . 'architecture to minimize cloud bills.',
        'terms' => 'generative genai llm foundation model finetune finetuning lora qlora '
             . 'diffusion synthetic prompt training custom nvidia parameter 4090 a100 a10g '
             . 'architecture bills cloud commercial gpus h100 latency',
    ],
    [
        'id' => 'q282', 'cat' => 'page-faq',
        'q' => 'How do fine-tuned models compare to GPT-4 in performance?',
        'a' => 'On generalized open-ended knowledge, frontier models excel; however, on specific '
             . 'enterprise tasks (such as medical diagnosis coding, financial ledger '
             . 'classification, or proprietary code syntax), a tailored 8B or 70B model routinely '
             . 'matches or exceeds GPT-4 while running at 85% lower cost.',
        'terms' => 'generative genai llm foundation model finetune finetuning lora qlora '
             . 'diffusion synthetic prompt training custom classification code coding cost '
             . 'diagnosis ended exceeds excel financial frontier generalized however',
    ],
    [
        'id' => 'q283', 'cat' => 'page-faq',
        'q' => 'What multimodal capabilities can you build into Generative AI systems?',
        'a' => 'We build systems capable of processing and generating text, high-resolution '
             . 'imagery, audio voice streams, tabular financial data, and complex PDF blueprints '
             . 'in unified cognitive workflows.',
        'terms' => 'generative genai llm foundation model finetune finetuning lora qlora '
             . 'diffusion synthetic prompt training custom audio blueprints capable cognitive '
             . 'complex financial generating high imagery processing resolution streams',
    ],
    [
        'id' => 'q284', 'cat' => 'page-faq',
        'q' => 'How do you handle data privacy and copyright considerations?',
        'a' => 'All models are trained exclusively on your licensed enterprise data and '
             . 'permissible open-source foundation weights. Your corporate IP remains strictly '
             . 'yours, with full legal and copyright indemnification frameworks.',
        'terms' => 'generative genai llm foundation model finetune finetuning lora qlora '
             . 'diffusion synthetic prompt training custom corporate exclusively frameworks '
             . 'full indemnification legal licensed open permissible remains source',
    ],
    [
        'id' => 'q285', 'cat' => 'page-faq',
        'q' => 'What is the average timeline to build and deploy a custom Generative AI solution? '
             . 'What is the average timeline to build and deploy a custom Generative AI solution?',
        'a' => 'A focused Proof of Concept is delivered in 2 to 3 weeks, while a full-scale '
             . 'enterprise production platform typically ships in 6 to 10 weeks.',
        'terms' => 'generative genai llm foundation model finetune finetuning lora qlora '
             . 'diffusion synthetic prompt training custom weeks concept delivered focused '
             . 'full platform proof scale ships typically while',
    ],
    [
        'id' => 'q286', 'cat' => 'page-faq',
        'q' => 'Do you provide continuous monitoring and model retraining?',
        'a' => 'Yes. Our AgentOps and MLOps telemetry infrastructure monitors prompt drift, '
             . 'latency anomalies, token costs, and user feedback in real-time, triggering '
             . 'automated retraining pipelines as new data is ingested.',
        'terms' => 'generative genai llm foundation model finetune finetuning lora qlora '
             . 'diffusion synthetic prompt training custom agentops anomalies automated costs '
             . 'drift feedback infrastructure ingested latency mlops monitors pipelines',
    ],

    // ---- AI Chatbot & Voicebot Development ---- (services/ai-chatbot-development.php)

    [
        'id' => 'q287', 'cat' => 'page-faq',
        'q' => 'How realistic do your AI voicebots sound over phone calls?',
        'a' => 'Our voicebots achieve human-grade naturalness with sub-400ms end-to-end audio '
             . 'latency, expressive prosody, dynamic pauses, and full-duplex interruption '
             . 'handling that stops speaking immediately when the user speaks.',
        'terms' => 'chatbot chat bot voicebot conversational assistant whatsapp telephony ivr '
             . 'multilingual support desk 400ms achieve audio duplex dynamic expressive full '
             . 'grade handling human immediately interruption',
    ],
    [
        'id' => 'q288', 'cat' => 'page-faq',
        'q' => 'Which messaging platforms and channels do you support?',
        'a' => 'We deploy conversational agents across WhatsApp Business API, Web widgets, iOS & '
             . 'Android mobile SDKs, Facebook Messenger, Telegram, Instagram DMs, and standard '
             . 'telephone lines (PSTN/SIP).',
        'terms' => 'chatbot chat bot voicebot conversational assistant whatsapp telephony ivr '
             . 'multilingual support desk across agents android deploy facebook instagram '
             . 'lines messenger mobile pstn sdks',
    ],
    [
        'id' => 'q289', 'cat' => 'page-faq',
        'q' => 'Can the bot access our private customer database to check order status?',
        'a' => 'Yes. Our bots utilize secure tool-calling contracts to query your internal '
             . 'databases, ERPs, and OMS in real time, securely retrieving order tracking, '
             . 'invoice details, and account balances.',
        'terms' => 'chatbot chat bot voicebot conversational assistant whatsapp telephony ivr '
             . 'multilingual support desk account balances bots calling contracts databases '
             . 'details erps internal invoice query real',
    ],
    [
        'id' => 'q290', 'cat' => 'page-faq',
        'q' => 'How does the bot handle regional Indian languages and accents?',
        'a' => 'We integrate advanced phonetic speech models (including Sarvam AI and Whisper '
             . 'Indic) fine-tuned on regional dialects, supporting English, Hindi, Tamil, Telugu, '
             . 'Kannada, Malayalam, Marathi, Bengali, and Gujarati.',
        'terms' => 'chatbot chat bot voicebot conversational assistant whatsapp telephony ivr '
             . 'multilingual support desk advanced bengali dialects english fine gujarati '
             . 'hindi including indic integrate kannada malayalam',
    ],
    [
        'id' => 'q291', 'cat' => 'page-faq',
        'q' => 'What happens when a customer asks a question the bot cannot answer?',
        'a' => 'The bot gracefully summarizes the conversation history, flags the intent '
             . 'confidence score, and routes the caller to a live human agent with the transcript '
             . 'pre-loaded on their screen.',
        'terms' => 'chatbot chat bot voicebot conversational assistant whatsapp telephony ivr '
             . 'multilingual support desk agent caller confidence conversation flags '
             . 'gracefully history human intent live loaded routes',
    ],
    [
        'id' => 'q292', 'cat' => 'page-faq',
        'q' => 'Is customer voice and chat data encrypted and compliant?',
        'a' => 'Yes. All data streams are encrypted with TLS 1.3 in transit and AES-256 at rest. '
             . 'Sensitive PII, credit card numbers, and passwords are automatically masked before '
             . 'logging, adhering to PCI-DSS, SOC 2, and GDPR.',
        'terms' => 'chatbot chat bot voicebot conversational assistant whatsapp telephony ivr '
             . 'multilingual support desk adhering automatically card credit gdpr logging '
             . 'masked numbers passwords rest sensitive streams',
    ],
    [
        'id' => 'q293', 'cat' => 'page-faq',
        'q' => 'Can the chatbot take customer payments directly in chat?',
        'a' => 'Yes. We integrate secure payment gateway webhooks (Stripe, Razorpay, UPI '
             . 'deep-links) enabling customers to complete purchases and pay invoices directly '
             . 'within WhatsApp or web chat.',
        'terms' => 'chatbot chat bot voicebot conversational assistant whatsapp telephony ivr '
             . 'multilingual support desk complete deep enabling gateway integrate invoices '
             . 'links payment purchases razorpay secure stripe',
    ],
    [
        'id' => 'q294', 'cat' => 'page-faq',
        'q' => 'How long does it take to train the chatbot on our company knowledge?',
        'a' => 'Using our high-speed vector ingestion pipeline, we can index hundreds of company '
             . 'PDF manuals, FAQs, and help center articles in less than 48 hours.',
        'terms' => 'chatbot chat bot voicebot conversational assistant whatsapp telephony ivr '
             . 'multilingual support desk articles center faqs help high hours hundreds index '
             . 'ingestion less manuals pipeline',
    ],
    [
        'id' => 'q295', 'cat' => 'page-faq',
        'q' => 'Can the bot handle cold outreach and inbound sales qualification calls?',
        'a' => 'Yes. Our voice agents are widely deployed for outbound lead follow-up, webinar '
             . 'reminders, abandoned cart re-engagement, and inbound qualification with direct '
             . 'calendar scheduling.',
        'terms' => 'chatbot chat bot voicebot conversational assistant whatsapp telephony ivr '
             . 'multilingual support desk abandoned agents calendar cart deployed direct '
             . 'engagement follow lead outbound reminders scheduling',
    ],
    [
        'id' => 'q296', 'cat' => 'page-faq',
        'q' => 'How are pricing and operational token costs structured for conversational bots?',
        'a' => 'We offer transparent models: fixed engineering setup and deployment tiers with '
             . 'predictable infrastructure costs, minimizing token overhead through semantic '
             . 'caching.',
        'terms' => 'chatbot chat bot voicebot conversational assistant whatsapp telephony ivr '
             . 'multilingual support desk caching deployment engineering fixed infrastructure '
             . 'minimizing offer overhead predictable semantic setup through',
    ],

    // ---- AI Copilot Development ---- (services/ai-copilot-development.php)

    [
        'id' => 'q297', 'cat' => 'page-faq',
        'q' => 'How does an AI Copilot differ from a standard AI Chatbot?',
        'a' => 'While chatbots generally operate in a standalone chat window answering generic '
             . 'queries, a Copilot is deeply embedded into the active software workspace, '
             . 'continuously aware of the user?s cursor position, open document, selected data, '
             . 'and permissions, providing proactive inline assistance.',
        'terms' => 'copilot assistant inapp embedded sidekick productivity domain expert workflow '
             . 'helper active answering assistance aware chat chatbots continuously cursor '
             . 'deeply document generally',
    ],
    [
        'id' => 'q298', 'cat' => 'page-faq',
        'q' => 'Can a custom copilot be embedded into our existing React or Vue web app?',
        'a' => 'Yes. We provide lightweight, customizable npm packages and web components that '
             . 'integrate into your frontend in hours, connecting securely to your backend via '
             . 'WebSockets or streaming HTTP.',
        'terms' => 'copilot assistant inapp embedded sidekick productivity domain expert workflow '
             . 'helper backend components connecting customizable frontend hours http '
             . 'integrate lightweight packages securely streaming',
    ],
    [
        'id' => 'q299', 'cat' => 'page-faq',
        'q' => 'How do you keep latency low enough for inline autocomplete (<100ms)?',
        'a' => 'We deploy quantized small language models (SLMs) on edge GPU clusters combined '
             . 'with speculative decoding, local client caching, and preemptive background '
             . 'context pre-fetching.',
        'terms' => 'copilot assistant inapp embedded sidekick productivity domain expert workflow '
             . 'helper background caching clusters combined context decoding deploy edge '
             . 'fetching language local preemptive',
    ],
    [
        'id' => 'q300', 'cat' => 'page-faq',
        'q' => 'Is our codebase or customer data sent to third-party AI companies?',
        'a' => 'No. We configure private cloud deployments (AWS Bedrock, Azure OpenAI with '
             . 'zero-data retention, or self-hosted vLLM on your VPC) so your proprietary data '
             . 'never leaves your infrastructure.',
        'terms' => 'copilot assistant inapp embedded sidekick productivity domain expert workflow '
             . 'helper azure bedrock cloud configure deployments hosted infrastructure leaves '
             . 'never openai private proprietary',
    ],
    [
        'id' => 'q301', 'cat' => 'page-faq',
        'q' => 'Can the copilot execute actions on behalf of the user, such as creating records? '
             . 'Can the copilot execute actions on behalf of the user, such as creating records?',
        'a' => 'Yes. Using secure tool-calling and API contracts, the copilot can draft '
             . 'transactions, create Jira tickets, trigger database updates, and send emails, '
             . 'with optional human-confirmation modals.',
        'terms' => 'copilot assistant inapp embedded sidekick productivity domain expert workflow '
             . 'helper calling confirmation contracts create database draft emails human jira '
             . 'modals optional secure',
    ],
    [
        'id' => 'q302', 'cat' => 'page-faq',
        'q' => 'How do you handle complex permissions and multi-tenant security?',
        'a' => 'The copilot inherits the active user session token and role-based access control '
             . '(RBAC) rules. It physically cannot retrieve or generate information that the '
             . 'requesting user is not authorized to view.',
        'terms' => 'copilot assistant inapp embedded sidekick productivity domain expert workflow '
             . 'helper user access active authorized based cannot control generate '
             . 'information inherits physically',
    ],
    [
        'id' => 'q303', 'cat' => 'page-faq',
        'q' => 'Can the copilot convert plain English into database SQL queries safely?',
        'a' => 'Yes. Our NL-to-SQL copilot engines parse your database schema, generate read-only '
             . 'parameterized queries, validate syntax against SQL injection vectors, and execute '
             . 'with strict query timeouts.',
        'terms' => 'copilot assistant inapp embedded sidekick productivity domain expert workflow '
             . 'helper against engines execute generate injection parameterized parse query '
             . 'read schema strict syntax',
    ],
    [
        'id' => 'q304', 'cat' => 'page-faq',
        'q' => 'What telemetry and analytics are provided to measure copilot usage?',
        'a' => 'We provide comprehensive dashboards tracking suggestion acceptance rates, daily '
             . 'active users, average latency, token costs per user, and estimated time saved per '
             . 'operator.',
        'terms' => 'copilot assistant inapp embedded sidekick productivity domain expert workflow '
             . 'helper acceptance active average comprehensive costs daily dashboards '
             . 'estimated latency operator rates saved',
    ],
    [
        'id' => 'q305', 'cat' => 'page-faq',
        'q' => 'Can we build a copilot for our desktop application (Electron, Windows, macOS)?',
        'a' => 'Yes. We engineer native desktop extensions, system tray copilots, and Electron '
             . 'integrations that interact with local file systems and desktop applications.',
        'terms' => 'copilot assistant inapp embedded sidekick productivity domain expert workflow '
             . 'helper applications copilots engineer extensions file integrations interact '
             . 'local native tray',
    ],
    [
        'id' => 'q306', 'cat' => 'page-faq',
        'q' => 'What is the typical timeline to launch an in-app copilot for our SaaS?',
        'a' => 'A working production copilot MVP is typically delivered in 4 to 6 weeks, with '
             . 'iterative refinement based on user feedback.',
        'terms' => 'copilot assistant inapp embedded sidekick productivity domain expert workflow '
             . 'helper based delivered feedback iterative refinement typically user weeks '
             . 'working',
    ],

    // ---- RAG Development ---- (services/rag-development.php)

    [
        'id' => 'q307', 'cat' => 'page-faq',
        'q' => 'What is the difference between standard naive RAG and GraphRAG?',
        'a' => 'Standard naive RAG splits text into arbitrary chunks and uses cosine similarity, '
             . 'which loses relational context across documents. GraphRAG extracts entities, '
             . 'relationships, and claims into an interconnected knowledge graph, allowing the '
             . 'LLM to perform complex multi-hop reasoning across thousands of interconnected '
             . 'enterprise files with superior accuracy.',
        'terms' => 'rag retrieval vector embedding search knowledge base grounding hallucination '
             . 'citation chunking reranking qdrant document across interconnected accuracy '
             . 'allowing arbitrary chunks claims complex context cosine documents entities',
    ],
    [
        'id' => 'q308', 'cat' => 'page-faq',
        'q' => 'How do you prevent hallucinations in your enterprise RAG implementations?',
        'a' => 'We implement a 4-tier verification protocol: hybrid semantic reranking, context '
             . 'relevance filtering, token citation validation, and automated Self-RAG reflection '
             . 'checks that reject or regenerate any claim lacking verifiable source attribution.',
        'terms' => 'rag retrieval vector embedding search knowledge base grounding hallucination '
             . 'citation chunking reranking qdrant document attribution automated checks '
             . 'claim context filtering hybrid implement lacking protocol reflection',
    ],
    [
        'id' => 'q309', 'cat' => 'page-faq',
        'q' => 'How do you enforce role-based access control (RBAC) in vector search?',
        'a' => 'We implement pre-filtering and post-filtering metadata hooks that map user tokens '
             . 'directly to document access lists at retrieval time. Unauthorized users never '
             . 'receive vector chunks from restricted files, guaranteeing absolute data '
             . 'governance.',
        'terms' => 'rag retrieval vector embedding search knowledge base grounding hallucination '
             . 'citation chunking reranking qdrant document filtering absolute chunks '
             . 'directly files governance guaranteeing hooks implement lists metadata',
    ],
    [
        'id' => 'q310', 'cat' => 'page-faq',
        'q' => 'Which vector databases do you recommend for enterprise production?',
        'a' => 'We deploy and optimize Qdrant, Milvus, pgvector, and Pinecone depending on your '
             . 'workload, sharding requirements, on-premise constraints, and latency targets. For '
             . 'self-hosted VPC setups, Qdrant and Milvus offer exceptional throughput and '
             . 'filtering.',
        'terms' => 'rag retrieval vector embedding search knowledge base grounding hallucination '
             . 'citation chunking reranking qdrant document milvus constraints depending '
             . 'deploy exceptional filtering hosted latency offer optimize pgvector',
    ],
    [
        'id' => 'q311', 'cat' => 'page-faq',
        'q' => 'Can your RAG pipelines handle complex multimodal files like scanned PDFs and '
             . 'financial tables?',
        'a' => 'Yes. We deploy vision-language parsing models and layout-aware OCR engines (such '
             . 'as Unstructured, Nougat, and ColPali) that preserve tabular structure, nested '
             . 'headers, and visual charts directly into markdown embeddings.',
        'terms' => 'rag retrieval vector embedding search knowledge base grounding hallucination '
             . 'citation chunking reranking qdrant document aware charts colpali deploy '
             . 'directly embeddings engines headers language layout markdown nested',
    ],
    [
        'id' => 'q312', 'cat' => 'page-faq',
        'q' => 'How do you keep vector indices updated with real-time enterprise data changes?',
        'a' => 'We build event-driven CDC (Change Data Capture) pipelines using Kafka, Debezium, '
             . 'and webhook listeners that automatically update, re-chunk, and re-embed modified '
             . 'documents in real time with zero system downtime.',
        'terms' => 'rag retrieval vector embedding search knowledge base grounding hallucination '
             . 'citation chunking reranking qdrant document automatically capture change '
             . 'chunk debezium documents downtime driven embed event kafka listeners',
    ],
    [
        'id' => 'q313', 'cat' => 'page-faq',
        'q' => 'What metrics do you use to evaluate RAG retrieval accuracy?',
        'a' => 'We benchmark using RAGAS and TruLens frameworks measuring Context Relevance, '
             . 'Groundedness, Answer Relevance, Context Precision, and Faithfulness against '
             . 'curated golden test datasets.',
        'terms' => 'rag retrieval vector embedding search knowledge base grounding hallucination '
             . 'citation chunking reranking qdrant document context relevance against answer '
             . 'benchmark curated datasets faithfulness frameworks golden groundedness '
             . 'measuring',
    ],
    [
        'id' => 'q314', 'cat' => 'page-faq',
        'q' => 'Can we run our entire RAG pipeline inside an air-gapped private cloud?',
        'a' => 'Yes. All components—embedding models, vector databases, rerankers, and local LLMs '
             . '(vLLM)—can be deployed 100% on-premise or within isolated AWS/GCP/Azure VPCs with '
             . 'zero external internet dependencies.',
        'terms' => 'rag retrieval vector embedding search knowledge base grounding hallucination '
             . 'citation chunking reranking qdrant document azure components databases '
             . 'dependencies deployed external internet isolated llms local premise',
    ],
    [
        'id' => 'q315', 'cat' => 'page-faq',
        'q' => 'What is hybrid search and why is it necessary?',
        'a' => 'Hybrid search combines dense vector retrieval (capturing semantic meaning) with '
             . 'sparse lexical retrieval like BM25 (capturing exact product names, error codes, '
             . 'and SKUs). Merging both via Reciprocal Rank Fusion delivers industry-leading '
             . 'search precision.',
        'terms' => 'rag retrieval vector embedding search knowledge base grounding hallucination '
             . 'citation chunking reranking qdrant document capturing bm25 codes combines '
             . 'delivers dense error exact fusion industry leading',
    ],
    [
        'id' => 'q316', 'cat' => 'page-faq',
        'q' => 'How long does it take to deploy an enterprise RAG system into production?',
        'a' => 'A specialized proof of concept is typically live within 2 to 3 weeks, while full '
             . 'enterprise deployment across multi-department repositories with RBAC takes 4 to 6 '
             . 'weeks.',
        'terms' => 'rag retrieval vector embedding search knowledge base grounding hallucination '
             . 'citation chunking reranking qdrant document weeks across concept department '
             . 'deployment full live multi proof rbac repositories specialized',
    ],

    // ---- Computer Vision Development ---- (services/computer-vision-development.php)

    [
        'id' => 'q317', 'cat' => 'page-faq',
        'q' => 'What hardware do you support for edge computer vision deployment?',
        'a' => 'We support NVIDIA Jetson (Nano, Orin Nano, Xavier, AGX Orin), Intel OpenVINO '
             . 'x86/ARM processors, Google Coral TPUs, Hailo AI processors, and industrial smart '
             . 'cameras with embedded NPUs.',
        'terms' => 'vision image video camera detection recognition ocr inspection defect edge '
             . 'yolo annotation visual nano orin processors cameras coral embedded google '
             . 'hailo industrial intel jetson npus',
    ],
    [
        'id' => 'q318', 'cat' => 'page-faq',
        'q' => 'Can your computer vision models run completely offline without internet?',
        'a' => 'Yes. Our edge vision pipelines run 100% locally on on-premise hardware, '
             . 'processing video streams and triggering PLC relays in real time without '
             . 'transmitting data outside your facility.',
        'terms' => 'vision image video camera detection recognition ocr inspection defect edge '
             . 'yolo annotation visual facility hardware locally outside pipelines premise '
             . 'processing real relays streams time',
    ],
    [
        'id' => 'q319', 'cat' => 'page-faq',
        'q' => 'How many frames per second (FPS) can your vision models achieve?',
        'a' => 'Depending on the model architecture and target hardware, our TensorRT-optimized '
             . 'models achieve between 30 FPS to 120+ FPS on 1080p/4K streams, maintaining '
             . 'sub-10ms per-frame latency.',
        'terms' => 'vision image video camera detection recognition ocr inspection defect edge '
             . 'yolo annotation visual 1080p 10ms architecture depending frame hardware '
             . 'latency maintaining optimized streams target tensorrt',
    ],
    [
        'id' => 'q320', 'cat' => 'page-faq',
        'q' => 'How do you handle lighting fluctuations and dusty environments in factories?',
        'a' => 'We incorporate synthetic data augmentation (simulating shadows, dust, lens blur, '
             . 'and variable Lux levels) and auto-calibrating camera exposures during '
             . 'preprocessing to ensure 99.8% precision under variable physical conditions.',
        'terms' => 'vision image video camera detection recognition ocr inspection defect edge '
             . 'yolo annotation visual variable augmentation auto blur calibrating conditions '
             . 'dust ensure exposures incorporate lens',
    ],
    [
        'id' => 'q321', 'cat' => 'page-faq',
        'q' => 'How do you extract data from complex tables and handwritten forms?',
        'a' => 'We use layout-aware multimodal OCR pipelines (combining YOLO for table detection '
             . 'with PaddleOCR and Vision-Language Models) to extract tabular structures and '
             . 'handwriting directly into structured JSON.',
        'terms' => 'vision image video camera detection recognition ocr inspection defect edge '
             . 'yolo annotation visual aware combining directly handwriting json language '
             . 'layout multimodal paddleocr pipelines structured',
    ],
    [
        'id' => 'q322', 'cat' => 'page-faq',
        'q' => 'How do you prevent biometric spoofing in facial recognition systems?',
        'a' => 'We integrate active and passive 3D liveness detection (analyzing micro-textures, '
             . 'depth maps, and infrared reflections) to defeat printed photo, video replay, and '
             . '3D silicone mask spoofing attacks.',
        'terms' => 'vision image video camera detection recognition ocr inspection defect edge '
             . 'yolo annotation visual active analyzing attacks defeat depth infrared '
             . 'integrate liveness maps mask micro',
    ],
    [
        'id' => 'q323', 'cat' => 'page-faq',
        'q' => 'Can your models detect small micro-defects on fast-moving assembly lines?',
        'a' => 'Yes. We use high-resolution patch-based defect segmentation models and high-speed '
             . 'industrial global-shutter cameras to detect defects as small as 0.05mm at '
             . 'conveyor speeds.',
        'terms' => 'vision image video camera detection recognition ocr inspection defect edge '
             . 'yolo annotation visual high 05mm based cameras conveyor global industrial '
             . 'patch resolution segmentation shutter',
    ],
    [
        'id' => 'q324', 'cat' => 'page-faq',
        'q' => 'How do you train vision models when defect sample data is extremely rare?',
        'a' => 'We utilize advanced generative diffusion models (ControlNet, GANs) to synthesize '
             . 'realistic defect variations, and deploy few-shot anomaly detection models (such '
             . 'as PatchCore) that learn from normal samples.',
        'terms' => 'vision image video camera detection recognition ocr inspection defect edge '
             . 'yolo annotation visual advanced anomaly controlnet deploy diffusion gans '
             . 'generative learn normal patchcore realistic',
    ],
    [
        'id' => 'q325', 'cat' => 'page-faq',
        'q' => 'Can computer vision integrate directly with our PLC or SCADA systems?',
        'a' => 'Yes. Our edge gateways communicate directly with PLCs via Modbus, OPC-UA, MQTT, '
             . 'and digital I/O pins to trigger immediate mechanical rejections or line halts.',
        'terms' => 'vision image video camera detection recognition ocr inspection defect edge '
             . 'yolo annotation visual communicate digital gateways halts immediate line '
             . 'mechanical modbus mqtt pins plcs',
    ],
    [
        'id' => 'q326', 'cat' => 'page-faq',
        'q' => 'What is the typical development timeline for a custom computer vision solution?',
        'a' => 'A custom proof of concept takes 3 to 4 weeks. Full industrial integration and '
             . 'edge fleet deployment typically require 6 to 10 weeks depending on camera '
             . 'integration complexity.',
        'terms' => 'vision image video camera detection recognition ocr inspection defect edge '
             . 'yolo annotation visual integration weeks complexity concept depending '
             . 'deployment fleet full industrial proof',
    ],

    // ---- Agentic AI Strategy ---- (services/agentic-ai-strategy.php)

    [
        'id' => 'q327', 'cat' => 'page-faq',
        'q' => 'What is the fundamental difference between standard GenAI and Agentic AI?',
        'a' => 'Standard Generative AI responds passively to a single prompt with text. Agentic '
             . 'AI operates autonomously by reasoning, planning multi-step actions, maintaining '
             . 'persistent memory, calling external software tools/APIs, evaluating its own '
             . 'results, and executing until a goal is achieved.',
        'terms' => 'strategy agentic roadmap maturity operating model governance pilot adoption '
             . 'prioritisation business case achieved actions apis autonomously calling '
             . 'evaluating executing external generative goal maintaining memory',
    ],
    [
        'id' => 'q328', 'cat' => 'page-faq',
        'q' => 'What is Model Context Protocol (MCP) and why is it central to your strategy?',
        'a' => 'Model Context Protocol (MCP) is an open standard created by Anthropic that '
             . 'standardizes how AI agents securely discover and interact with external data '
             . 'sources and tools. It prevents vendor lock-in and allows seamless integration '
             . 'with enterprise systems without rewriting custom glue code.',
        'terms' => 'strategy agentic roadmap maturity operating model governance pilot adoption '
             . 'prioritisation business case agents allows anthropic code created custom '
             . 'discover external glue integration interact lock',
    ],
    [
        'id' => 'q329', 'cat' => 'page-faq',
        'q' => 'Which agentic framework do you recommend: LangGraph, AutoGen, or CrewAI?',
        'a' => 'For deterministic enterprise production, we predominantly architect with '
             . 'LangGraph because its cyclic graph state machine provides deterministic control, '
             . 'human-in-the-loop checkpointing, and fault tolerance. AutoGen and CrewAI are '
             . 'excellent for conversational simulation and rapid role-playing prototyping.',
        'terms' => 'strategy agentic roadmap maturity operating model governance pilot adoption '
             . 'prioritisation business case deterministic architect because checkpointing '
             . 'control conversational cyclic excellent fault graph human loop',
    ],
    [
        'id' => 'q330', 'cat' => 'page-faq',
        'q' => 'How do you prevent autonomous agents from making catastrophic errors or looping '
             . 'infinitely?',
        'a' => 'We implement deterministic guardrails, maximum recursion depth limits, '
             . 'schema-validated JSON outputs, and automated reflection critic nodes. Any action '
             . 'exceeding predefined risk or cost thresholds requires mandatory human sign-off.',
        'terms' => 'strategy agentic roadmap maturity operating model governance pilot adoption '
             . 'prioritisation business case action automated cost critic depth deterministic '
             . 'exceeding guardrails human implement json limits',
    ],
    [
        'id' => 'q331', 'cat' => 'page-faq',
        'q' => 'How do you handle data security when agents interact with enterprise databases?',
        'a' => 'We design read-only replicas, schema-restricted service accounts, and tool '
             . 'execution sandboxes. Agents never receive raw database credentials; all actions '
             . 'pass through an authenticated MCP gateway with comprehensive audit logging.',
        'terms' => 'strategy agentic roadmap maturity operating model governance pilot adoption '
             . 'prioritisation business case accounts actions audit authenticated '
             . 'comprehensive credentials database design execution gateway logging never',
    ],
    [
        'id' => 'q332', 'cat' => 'page-faq',
        'q' => 'How do you model the ROI and compute costs of multi-agent swarms?',
        'a' => 'We simulate the average agent steps, token input/output volumes, model routing '
             . 'strategies (using smaller SLMs for routing and larger LLMs for complex '
             . 'reasoning), and quantify labor hours saved to deliver a predictable unit cost per '
             . 'resolved task.',
        'terms' => 'strategy agentic roadmap maturity operating model governance pilot adoption '
             . 'prioritisation business case routing average complex cost deliver hours input '
             . 'labor larger llms output predictable',
    ],
    [
        'id' => 'q333', 'cat' => 'page-faq',
        'q' => 'What is the role of human-in-the-loop (HITL) in an autonomous agentic '
             . 'architecture?',
        'a' => 'Human-in-the-loop provides confidence-based escalation gates. Routine low-risk '
             . 'actions execute autonomously at lightspeed, while high-risk decisions (financial '
             . 'transfers, database modifications, contract approvals) trigger immediate review '
             . 'requests to human operators via Slack or Teams.',
        'terms' => 'strategy agentic roadmap maturity operating model governance pilot adoption '
             . 'prioritisation business case risk actions approvals autonomously based '
             . 'confidence contract database decisions escalation execute financial',
    ],
    [
        'id' => 'q334', 'cat' => 'page-faq',
        'q' => 'Can we deploy agentic AI swarms within our private VPC or on-premise cloud?',
        'a' => 'Yes. We design architectures that run on self-hosted open-weights models (such as '
             . 'Llama 3, Mistral, and DeepSeek) using vLLM or Ollama on private Kubernetes '
             . 'clusters inside your AWS, Azure, or GCP VPC.',
        'terms' => 'strategy agentic roadmap maturity operating model governance pilot adoption '
             . 'prioritisation business case architectures azure clusters deepseek design '
             . 'hosted inside kubernetes llama mistral ollama open',
    ],
    [
        'id' => 'q335', 'cat' => 'page-faq',
        'q' => 'How long does an Agentic AI strategy engagement take?',
        'a' => 'Our focused Agentic Strategy Sprint takes 2 weeks, while a comprehensive '
             . 'multi-department enterprise swarm architecture audit takes 3 to 4 weeks.',
        'terms' => 'strategy agentic roadmap maturity operating model governance pilot adoption '
             . 'prioritisation business case weeks architecture audit comprehensive '
             . 'department focused multi sprint swarm while',
    ],
    [
        'id' => 'q336', 'cat' => 'page-faq',
        'q' => 'Do you provide the engineering teams to implement the strategy?',
        'a' => 'Yes. iThrive provides end-to-end capabilities from high-level agentic advisory to '
             . 'specialized LangGraph engineering squads that build, test, and deploy the entire '
             . 'autonomous system into production.',
        'terms' => 'strategy agentic roadmap maturity operating model governance pilot adoption '
             . 'prioritisation business case advisory autonomous capabilities deploy entire '
             . 'high langgraph level specialized squads test',
    ],

    // ---- Custom AI Agent Development ---- (services/custom-agent-development.php)

    [
        'id' => 'q337', 'cat' => 'page-faq',
        'q' => 'What is a custom AI agent and how does it work?',
        'a' => 'A custom AI agent is an autonomous software program that combines a reasoning LLM '
             . 'with memory, planning state machines (like LangGraph), and custom tool '
             . 'integrations (APIs, databases). It receives a high-level goal, breaks it into '
             . 'sequential steps, calls external tools to gather data or execute actions, '
             . 'verifies its own work, and completes the task autonomously.',
        'terms' => 'custom agent bespoke tool calling langgraph state machine autonomous build '
             . 'tailored actions apis autonomously breaks calls combines completes databases '
             . 'execute external gather',
    ],
    [
        'id' => 'q338', 'cat' => 'page-faq',
        'q' => 'How do you ensure agents execute tool calls and API requests accurately?',
        'a' => 'We use strict Pydantic schema validation, structured JSON outputs, deterministic '
             . 'error-handling fallbacks, and multi-step verification checks to ensure every tool '
             . 'call matches exact API requirements before execution.',
        'terms' => 'custom agent bespoke tool calling langgraph state machine autonomous build '
             . 'tailored call checks deterministic error every exact execution fallbacks '
             . 'handling json matches multi',
    ],
    [
        'id' => 'q339', 'cat' => 'page-faq',
        'q' => 'What systems and software can your custom agents integrate with?',
        'a' => 'Our agents can integrate with virtually any system with an API or database: Jira, '
             . 'GitHub, Salesforce, HubSpot, Zoho, SAP, NetSuite, PostgreSQL, Snowflake, Twilio, '
             . 'Slack, and custom in-house enterprise backends.',
        'terms' => 'custom agent bespoke tool calling langgraph state machine autonomous build '
             . 'tailored backends database github house hubspot jira netsuite postgresql '
             . 'salesforce slack snowflake twilio',
    ],
    [
        'id' => 'q340', 'cat' => 'page-faq',
        'q' => 'How do agents maintain memory across different sessions and conversations?',
        'a' => 'We implement a dual-layer memory system: short-term state memory stored in '
             . 'Redis/PostgreSQL checkpoints, and long-term semantic memory stored in vector '
             . 'databases (Qdrant, pgvector) with entity-relationship knowledge graphs.',
        'terms' => 'custom agent bespoke tool calling langgraph state machine autonomous build '
             . 'tailored stored term checkpoints databases dual entity graphs implement '
             . 'knowledge layer pgvector postgresql',
    ],
    [
        'id' => 'q341', 'cat' => 'page-faq',
        'q' => 'How do you handle security and credential management for agent tool execution?',
        'a' => 'Agents never receive raw API keys or database passwords. All tool calls route '
             . 'through an authenticated proxy/MCP server with short-lived tokens, rate limiting, '
             . 'and role-based access control.',
        'terms' => 'custom agent bespoke tool calling langgraph state machine autonomous build '
             . 'tailored access agents authenticated based calls control database keys '
             . 'limiting lived never passwords',
    ],
    [
        'id' => 'q342', 'cat' => 'page-faq',
        'q' => 'Can custom agents write code, execute scripts, or run database queries safely?',
        'a' => 'Yes. For code or query execution, we run agents inside ephemeral, sandboxed '
             . 'Docker containers or WebAssembly (Wasm) micro-VMs with strict network isolation '
             . 'and resource limits.',
        'terms' => 'custom agent bespoke tool calling langgraph state machine autonomous build '
             . 'tailored containers docker ephemeral execution inside isolation limits micro '
             . 'network query resource sandboxed',
    ],
    [
        'id' => 'q343', 'cat' => 'page-faq',
        'q' => 'How does the agent handle ambiguous user instructions or edge cases?',
        'a' => 'When confidence scores fall below a predefined threshold, the agent pauses '
             . 'execution, formulates clarifying questions, or escalates the task to a human '
             . 'supervisor via Slack or Teams.',
        'terms' => 'custom agent bespoke tool calling langgraph state machine autonomous build '
             . 'tailored clarifying confidence escalates execution fall formulates human '
             . 'pauses predefined questions scores slack',
    ],
    [
        'id' => 'q344', 'cat' => 'page-faq',
        'q' => 'Can we deploy our custom agents on our private cloud or on-premise hardware?',
        'a' => 'Yes. Our custom agents can be containerized and deployed on Kubernetes inside '
             . 'your private AWS, GCP, Azure VPC, or on-premise data center with zero data '
             . 'egress.',
        'terms' => 'custom agent bespoke tool calling langgraph state machine autonomous build '
             . 'tailored azure center containerized deployed egress inside kubernetes zero',
    ],
    [
        'id' => 'q345', 'cat' => 'page-faq',
        'q' => 'What frameworks do you use to build custom AI agents?',
        'a' => 'We primarily use LangGraph, Python, FastAPI, Model Context Protocol (MCP), '
             . 'Pydantic, Redis, and LangSmith for state-of-the-art enterprise reliability and '
             . 'observability.',
        'terms' => 'custom agent bespoke tool calling langgraph state machine autonomous build '
             . 'tailored context fastapi langsmith observability primarily protocol pydantic '
             . 'python redis reliability',
    ],
    [
        'id' => 'q346', 'cat' => 'page-faq',
        'q' => 'How long does it take to build and deploy a custom AI agent into production?',
        'a' => 'A single specialized custom agent is typically production-ready in 3 to 4 weeks. '
             . 'Complex multi-agent systems with extensive enterprise integrations take 6 to 8 '
             . 'weeks.',
        'terms' => 'custom agent bespoke tool calling langgraph state machine autonomous build '
             . 'tailored weeks complex extensive integrations multi ready single specialized '
             . 'typically',
    ],

    // ---- AI Agent Solutions ---- (services/ai-agent-solutions.php)

    [
        'id' => 'q347', 'cat' => 'page-faq',
        'q' => 'What makes an AI Agent Solution different from standard SaaS software?',
        'a' => 'Standard SaaS software requires manual human operation and rigid button-clicking. '
             . 'An AI Agent Solution acts as an autonomous digital worker that reasons, plans, '
             . 'executes multi-step workflows, interacts with multiple software systems '
             . 'simultaneously, and solves problems with minimal human intervention.',
        'terms' => 'agent solution prebuilt catalogue offtheshelf packaged ready deploy library '
             . 'template human acts autonomous button clicking digital executes interacts '
             . 'intervention manual minimal multi',
    ],
    [
        'id' => 'q348', 'cat' => 'page-faq',
        'q' => 'Can we deploy your pre-built agent solutions into our existing software stack?',
        'a' => 'Yes. Our agent solutions connect directly to your existing tools (Salesforce, '
             . 'HubSpot, Jira, SAP, Zendesk, Slack, GitHub) via secure APIs without requiring you '
             . 'to replace your current tech stack.',
        'terms' => 'agent solution prebuilt catalogue offtheshelf packaged ready deploy library '
             . 'template apis connect current directly github hubspot jira replace requiring '
             . 'salesforce secure slack',
    ],
    [
        'id' => 'q349', 'cat' => 'page-faq',
        'q' => 'How quickly can an enterprise deploy an AI agent solution?',
        'a' => 'Our pre-built agent archetypes (such as Sales SDRs, customer triage, and code '
             . 'review agents) can be integrated and live in your sandbox within 48 to 72 hours. '
             . 'Custom domain integrations typically take 2 to 3 weeks.',
        'terms' => 'agent solution prebuilt catalogue offtheshelf packaged ready deploy library '
             . 'template agents archetypes built code custom domain hours integrated '
             . 'integrations live review sales',
    ],
    [
        'id' => 'q350', 'cat' => 'page-faq',
        'q' => 'How do voice SDR agents handle phone conversations with customers?',
        'a' => 'Our voice SDR agents operate with sub-400ms latency, natural speech cadence, and '
             . 'real-time interruption handling. They qualify prospect interest, answer technical '
             . 'questions from your knowledge base, and book meetings directly into your '
             . 'calendar.',
        'terms' => 'agent solution prebuilt catalogue offtheshelf packaged ready deploy library '
             . 'template 400ms answer base book cadence calendar directly handling interest '
             . 'interruption knowledge latency',
    ],
    [
        'id' => 'q351', 'cat' => 'page-faq',
        'q' => 'How do financial ledger agents ensure zero calculation errors?',
        'a' => 'Financial agents do not rely on probabilistic LLM math. They use deterministic '
             . 'Python scripts, SQL verification queries, and strict three-way matching '
             . 'algorithms to validate all financial calculations before logging transactions.',
        'terms' => 'agent solution prebuilt catalogue offtheshelf packaged ready deploy library '
             . 'template algorithms calculations deterministic logging matching math '
             . 'probabilistic python queries rely scripts strict',
    ],
    [
        'id' => 'q352', 'cat' => 'page-faq',
        'q' => 'What happens when an agent encounters an edge case it cannot solve?',
        'a' => 'The agent uses automated confidence scoring. If confidence drops below a set '
             . 'threshold, it gracefully pauses and sends a detailed briefing with recommended '
             . 'actions to a human supervisor via Slack or Teams.',
        'terms' => 'agent solution prebuilt catalogue offtheshelf packaged ready deploy library '
             . 'template confidence actions automated briefing detailed drops gracefully '
             . 'human pauses recommended scoring sends',
    ],
    [
        'id' => 'q353', 'cat' => 'page-faq',
        'q' => 'Are your agent solutions compliant with SOC 2, HIPAA, and GDPR regulations?',
        'a' => 'Yes. We implement end-to-end encryption, strict zero-retention data policies, '
             . 'granular RBAC access controls, and comprehensive immutable audit logging.',
        'terms' => 'agent solution prebuilt catalogue offtheshelf packaged ready deploy library '
             . 'template access audit comprehensive controls encryption granular immutable '
             . 'implement logging policies rbac retention',
    ],
    [
        'id' => 'q354', 'cat' => 'page-faq',
        'q' => 'How many autonomous agents can run simultaneously in an enterprise?',
        'a' => 'Our architecture supports elastic horizontal scaling to N agents. You can run 5 '
             . 'agents or 500 agents concurrently handling millions of events with automated load '
             . 'balancing.',
        'terms' => 'agent solution prebuilt catalogue offtheshelf packaged ready deploy library '
             . 'template architecture automated balancing concurrently elastic events '
             . 'handling horizontal load millions scaling supports',
    ],
    [
        'id' => 'q355', 'cat' => 'page-faq',
        'q' => 'Can we customize the personality, tone, and guardrails of the agents?',
        'a' => 'Yes. We fully configure system prompts, brand guidelines, tone of voice, '
             . 'terminology glossaries, and deterministic safety rules to match your company '
             . 'culture.',
        'terms' => 'agent solution prebuilt catalogue offtheshelf packaged ready deploy library '
             . 'template brand configure culture deterministic fully glossaries guidelines '
             . 'match prompts rules safety terminology',
    ],
    [
        'id' => 'q356', 'cat' => 'page-faq',
        'q' => 'What ongoing support and maintenance do you provide after deployment?',
        'a' => 'We provide 24/7 AgentOps monitoring, latency and hallucination tracking, prompt '
             . 'fine-tuning, automated error recovery, and monthly architecture optimization '
             . 'reviews.',
        'terms' => 'agent solution prebuilt catalogue offtheshelf packaged ready deploy library '
             . 'template agentops architecture automated error fine hallucination latency '
             . 'monitoring monthly optimization prompt recovery',
    ],

    // ---- Multi-Agent Orchestration ---- (services/multi-agent-orchestration.php)

    [
        'id' => 'q357', 'cat' => 'page-faq',
        'q' => 'What is Multi-Agent Orchestration and why is it better than a single agent?',
        'a' => 'Multi-Agent Orchestration coordinates multiple specialized AI agents working '
             . 'together toward a common goal. Instead of overloading a single prompt with too '
             . 'many instructions, each agent specializes in one specific discipline (e.g., '
             . 'Planner, Researcher, Coder, Critic). This modularity prevents context overload, '
             . 'reduces hallucinations, and enables parallel task execution.',
        'terms' => 'orchestration multiagent swarm consensus coordination hierarchy delegation '
             . 'supervisor routing handoff agents coder common context coordinates critic '
             . 'discipline enables execution goal hallucinations instead',
    ],
    [
        'id' => 'q358', 'cat' => 'page-faq',
        'q' => 'How do agents communicate and share context with one another?',
        'a' => 'Agents communicate through structured message-passing protocols over a shared '
             . 'state graph (such as LangGraph\'s state dictionary) or distributed message queues '
             . '(Kafka, Redis, gRPC). They exchange structured JSON payloads containing task '
             . 'status, findings, and next-step recommendations.',
        'terms' => 'orchestration multiagent swarm consensus coordination hierarchy delegation '
             . 'supervisor routing handoff message state structured containing dictionary '
             . 'distributed exchange findings graph grpc json kafka',
    ],
    [
        'id' => 'q359', 'cat' => 'page-faq',
        'q' => 'How do you prevent multi-agent swarms from getting stuck in infinite loops or '
             . 'deadlocks?',
        'a' => 'We implement deterministic graph state machines with strict turn counters, '
             . 'semantic convergence checks, and automated circuit breakers. If agents fail to '
             . 'reach consensus within a configured threshold, the supervisor invokes a fallback '
             . 'resolution or alerts a human operator.',
        'terms' => 'orchestration multiagent swarm consensus coordination hierarchy delegation '
             . 'supervisor routing handoff agents alerts automated breakers checks circuit '
             . 'configured convergence counters deterministic fail',
    ],
    [
        'id' => 'q360', 'cat' => 'page-faq',
        'q' => 'What is the role of a Critic or Auditor agent in a multi-agent swarm?',
        'a' => 'A Critic agent acts as an automated quality inspector. It receives the draft '
             . 'output produced by worker agents, evaluates it against predefined business rules, '
             . 'syntax guidelines, or citation facts, and either approves the output or sends it '
             . 'back with actionable feedback for correction.',
        'terms' => 'orchestration multiagent swarm consensus coordination hierarchy delegation '
             . 'supervisor routing handoff output actionable acts against agents approves '
             . 'automated back citation correction draft either',
    ],
    [
        'id' => 'q361', 'cat' => 'page-faq',
        'q' => 'How do you manage compute and token costs across multi-agent systems?',
        'a' => 'We use hierarchical model routing: lightweight, low-cost SLMs (e.g., Llama 3 8B '
             . 'or Claude Haiku) handle simple extraction and routing sub-tasks, while frontier '
             . 'models (e.g., Claude 3.5 Sonnet or GPT-4o) are invoked only for complex strategic '
             . 'reasoning and final synthesis.',
        'terms' => 'orchestration multiagent swarm consensus coordination hierarchy delegation '
             . 'supervisor routing handoff claude complex cost extraction final frontier '
             . 'haiku handle hierarchical invoked lightweight',
    ],
    [
        'id' => 'q362', 'cat' => 'page-faq',
        'q' => 'Can multi-agent swarms execute actions in parallel?',
        'a' => 'Yes. LangGraph and asynchronous Python allow the supervisor agent to fan out '
             . 'multiple independent sub-tasks concurrently across dozens of worker nodes, '
             . 'reducing end-to-end execution time by up to 90%.',
        'terms' => 'orchestration multiagent swarm consensus coordination hierarchy delegation '
             . 'supervisor routing handoff across allow asynchronous concurrently dozens '
             . 'execution independent langgraph multiple nodes python reducing',
    ],
    [
        'id' => 'q363', 'cat' => 'page-faq',
        'q' => 'How do you monitor and debug complex multi-agent interactions in real time?',
        'a' => 'We integrate LangSmith, Phoenix Arize, and OpenTelemetry to provide visual '
             . 'execution graphs, message traces, latency breakdowns, and token cost metrics for '
             . 'every single agent interaction.',
        'terms' => 'orchestration multiagent swarm consensus coordination hierarchy delegation '
             . 'supervisor routing handoff arize breakdowns cost every execution graphs '
             . 'integrate interaction langsmith latency message metrics',
    ],
    [
        'id' => 'q364', 'cat' => 'page-faq',
        'q' => 'Can we integrate agents built on different frameworks (e.g., LangGraph and '
             . 'AutoGen)?',
        'a' => 'Yes. We build standardized Model Context Protocol (MCP) and REST/gRPC wrappers '
             . 'around individual agents, allowing heterogeneous agents across different '
             . 'frameworks to collaborate seamlessly.',
        'terms' => 'orchestration multiagent swarm consensus coordination hierarchy delegation '
             . 'supervisor routing handoff across allowing around collaborate context grpc '
             . 'heterogeneous individual protocol rest seamlessly standardized',
    ],
    [
        'id' => 'q365', 'cat' => 'page-faq',
        'q' => 'How does human-in-the-loop work in a multi-agent system?',
        'a' => 'The orchestration graph can include dedicated Human-in-the-Loop checkpoint nodes '
             . 'where execution pauses, serializes its state, and waits for a manager\'s review '
             . 'via Slack, Microsoft Teams, or a custom web dashboard before proceeding.',
        'terms' => 'orchestration multiagent swarm consensus coordination hierarchy delegation '
             . 'supervisor routing handoff checkpoint custom dashboard dedicated execution '
             . 'graph include manager microsoft nodes pauses',
    ],
    [
        'id' => 'q366', 'cat' => 'page-faq',
        'q' => 'How long does it take to engineer and deploy an enterprise multi-agent swarm?',
        'a' => 'A 3-agent proof of concept is typically operational in 3 to 4 weeks, while '
             . 'complex enterprise swarms with extensive API integrations require 6 to 8 weeks.',
        'terms' => 'orchestration multiagent swarm consensus coordination hierarchy delegation '
             . 'supervisor routing handoff weeks complex concept extensive integrations '
             . 'operational proof require swarms typically while',
    ],

    // ---- Agentic AI Integration ---- (services/agentic-ai-integration.php)

    [
        'id' => 'q367', 'cat' => 'page-faq',
        'q' => 'What is Model Context Protocol (MCP) and why is it essential for agent '
             . 'integration?',
        'a' => 'Model Context Protocol (MCP) is an open standard that unifies how AI models and '
             . 'agents securely connect to external tools, databases, and enterprise systems. It '
             . 'provides a standardized client-server protocol, eliminating the need to write '
             . 'fragile custom integrations for every new agent or LLM.',
        'terms' => 'integration middleware connector api erp crm legacy contract schema '
             . 'interoperability bridge agents connect custom databases eliminating every '
             . 'external fragile integrations open securely server',
    ],
    [
        'id' => 'q368', 'cat' => 'page-faq',
        'q' => 'How do you ensure agents don\'t accidentally corrupt or delete production '
             . 'database records?',
        'a' => 'We enforce strict security controls: read-only database replicas for data '
             . 'queries, parameterized queries that eliminate SQL injection, schema-level '
             . 'permission boundaries, and atomic transaction wrappers that automatically '
             . 'rollback on error.',
        'terms' => 'integration middleware connector api erp crm legacy contract schema '
             . 'interoperability bridge queries atomic automatically boundaries controls '
             . 'eliminate enforce error injection level parameterized permission',
    ],
    [
        'id' => 'q369', 'cat' => 'page-faq',
        'q' => 'Can you connect autonomous AI agents to legacy on-premise ERP systems like SAP or '
             . 'AS/400?',
        'a' => 'Yes. We deploy lightweight sidecar proxies and message queues inside your secure '
             . 'network that translate modern REST/gRPC/MCP agent requests into legacy RPC, SOAP, '
             . 'or database protocols.',
        'terms' => 'integration middleware connector api erp crm legacy contract schema '
             . 'interoperability bridge agent database deploy grpc inside lightweight message '
             . 'modern network protocols proxies queues',
    ],
    [
        'id' => 'q370', 'cat' => 'page-faq',
        'q' => 'How do agents receive real-time updates when data changes in our CRM or database? '
             . 'How do agents receive real-time updates when data changes in our CRM or database?',
        'a' => 'We configure Change Data Capture (CDC) pipelines using Debezium and Kafka. When a '
             . 'record changes in your database or CRM, a webhook or event is published '
             . 'immediately to the agentic event mesh.',
        'terms' => 'integration middleware connector api erp crm legacy contract schema '
             . 'interoperability bridge event agentic capture change configure debezium '
             . 'immediately kafka mesh pipelines published record',
    ],
    [
        'id' => 'q371', 'cat' => 'page-faq',
        'q' => 'How do you manage authentication and API keys for AI agents?',
        'a' => 'Agents authenticate via an OAuth2/mTLS token broker that generates short-lived, '
             . 'least-privilege access tokens. Agents never see master secrets or root '
             . 'credentials.',
        'terms' => 'integration middleware connector api erp crm legacy contract schema '
             . 'interoperability bridge access authenticate broker credentials generates '
             . 'least lived master mtls never oauth2 privilege',
    ],
    [
        'id' => 'q372', 'cat' => 'page-faq',
        'q' => 'What latency does your agentic middleware add to tool execution?',
        'a' => 'Our Go and FastAPI middleware proxies are engineered for high-concurrency '
             . 'enterprise workloads, adding less than 20ms of overhead to tool calls.',
        'terms' => 'integration middleware connector api erp crm legacy contract schema '
             . 'interoperability bridge 20ms adding calls concurrency engineered fastapi high '
             . 'less overhead proxies workloads',
    ],
    [
        'id' => 'q373', 'cat' => 'page-faq',
        'q' => 'Can your integration handle high-volume batch processing across millions of '
             . 'records?',
        'a' => 'Yes. We implement asynchronous worker pools and Redis task queues that process '
             . 'millions of records in parallel with automatic rate-limit throttling to prevent '
             . 'downstream system overload.',
        'terms' => 'integration middleware connector api erp crm legacy contract schema '
             . 'interoperability bridge asynchronous automatic downstream implement limit '
             . 'overload parallel pools prevent process queues rate',
    ],
    [
        'id' => 'q374', 'cat' => 'page-faq',
        'q' => 'How do you redact sensitive customer PII before sending context to AI agents?',
        'a' => 'Our middleware includes an automated PII redaction layer that masks credit card '
             . 'numbers, social security numbers, and health records in real time before data '
             . 'enters the agent context.',
        'terms' => 'integration middleware connector api erp crm legacy contract schema '
             . 'interoperability bridge numbers agent automated card credit enters health '
             . 'includes layer masks real',
    ],
    [
        'id' => 'q375', 'cat' => 'page-faq',
        'q' => 'Can we deploy the agentic integration layer inside our private cloud?',
        'a' => 'Yes. All MCP servers, gateways, and message brokers are fully containerized with '
             . 'Docker and Helm charts for seamless deployment inside your AWS, Azure, GCP VPC, '
             . 'or on-premise data center.',
        'terms' => 'integration middleware connector api erp crm legacy contract schema '
             . 'interoperability bridge azure brokers center charts containerized deployment '
             . 'docker fully gateways helm message premise',
    ],
    [
        'id' => 'q376', 'cat' => 'page-faq',
        'q' => 'How long does it take to integrate an autonomous agent with our enterprise '
             . 'systems?',
        'a' => 'Standard integrations for popular systems (Salesforce, PostgreSQL, Jira, Slack) '
             . 'take 1 to 2 weeks. Custom legacy ERP or proprietary database integrations '
             . 'typically take 3 to 4 weeks.',
        'terms' => 'integration middleware connector api erp crm legacy contract schema '
             . 'interoperability bridge integrations weeks custom database jira popular '
             . 'postgresql proprietary salesforce slack standard',
    ],

    // ---- AI Integration Services ---- (services/ai-integration.php)

    [
        'id' => 'q377', 'cat' => 'page-faq',
        'q' => 'How do you integrate AI into our legacy application without breaking existing '
             . 'features?',
        'a' => 'We use non-invasive architectural patterns such as sidecar microservices and API '
             . 'gateway facades. Your legacy application makes standard REST or webhook calls to '
             . 'our AI gateway, leaving your core business logic completely untouched and stable.',
        'terms' => 'integration gateway api existing system legacy connect embed plug erp crm '
             . 'data pipeline architectural calls completely core facades invasive leaving '
             . 'logic microservices patterns rest',
    ],
    [
        'id' => 'q378', 'cat' => 'page-faq',
        'q' => 'Can we switch between different AI models in the future without changing our '
             . 'application code?',
        'a' => 'Yes. Our unified AI gateway abstracts model providers behind a standardized API. '
             . 'You can switch from OpenAI to Claude or to an on-premise fine-tuned Llama model '
             . 'with a single configuration flag without updating your application.',
        'terms' => 'integration gateway api existing system legacy connect embed plug erp crm '
             . 'data pipeline abstracts behind claude configuration fine flag llama openai '
             . 'premise providers single',
    ],
    [
        'id' => 'q379', 'cat' => 'page-faq',
        'q' => 'How do you handle token-by-token streaming in web and mobile applications?',
        'a' => 'We implement Server-Sent Events (SSE) and WebSocket streaming protocols that '
             . 'deliver generated tokens to client user interfaces in real time with sub-50ms '
             . 'Time-To-First-Token (TTFT).',
        'terms' => 'integration gateway api existing system legacy connect embed plug erp crm '
             . 'data pipeline time 50ms deliver events first generated implement interfaces '
             . 'protocols real sent server',
    ],
    [
        'id' => 'q380', 'cat' => 'page-faq',
        'q' => 'What is semantic caching and how does it save cloud costs?',
        'a' => 'Semantic caching uses vector embeddings to recognize when a new user query has '
             . 'the same meaning as a previously answered query. It serves the cached answer in '
             . '<5ms, eliminating redundant LLM API calls and reducing token costs by up to 70%.',
        'terms' => 'integration gateway api existing system legacy connect embed plug erp crm '
             . 'data pipeline query answer answered cached calls eliminating embeddings '
             . 'meaning previously recognize reducing redundant',
    ],
    [
        'id' => 'q381', 'cat' => 'page-faq',
        'q' => 'How do you integrate AI capabilities with our corporate Single Sign-On (SSO)?',
        'a' => 'Our AI middleware integrates directly with your existing Identity Providers '
             . '(Okta, Azure AD, Keycloak, PingIdentity) via OAuth2 and SAML, ensuring user roles '
             . 'and permission boundaries are enforced at the AI layer.',
        'terms' => 'integration gateway api existing system legacy connect embed plug erp crm '
             . 'data pipeline azure boundaries directly enforced ensuring identity integrates '
             . 'keycloak layer middleware oauth2',
    ],
    [
        'id' => 'q382', 'cat' => 'page-faq',
        'q' => 'Can the AI integration run inside our private VPC or on-premise infrastructure?',
        'a' => 'Yes. All our integration gateways, caching microservices, and self-hosted model '
             . 'backends are containerized with Docker and deployable in any private cloud or '
             . 'bare-metal environment.',
        'terms' => 'integration gateway api existing system legacy connect embed plug erp crm '
             . 'data pipeline backends bare caching cloud containerized deployable docker '
             . 'environment gateways hosted metal microservices',
    ],
    [
        'id' => 'q383', 'cat' => 'page-faq',
        'q' => 'What happens if an external AI provider experiences an outage?',
        'a' => 'Our gateway features automated fallback and circuit breaker routing. If a primary '
             . 'model API fails or exceeds latency thresholds, requests are instantly routed to a '
             . 'secondary model or localized cache without user interruption.',
        'terms' => 'integration gateway api existing system legacy connect embed plug erp crm '
             . 'data pipeline automated breaker cache circuit exceeds fails fallback features '
             . 'instantly interruption latency',
    ],
    [
        'id' => 'q384', 'cat' => 'page-faq',
        'q' => 'How do you monitor the performance and costs of integrated AI features?',
        'a' => 'We provide centralized telemetry dashboards powered by OpenTelemetry and '
             . 'Prometheus, tracking request counts, token consumption, response latency, and '
             . 'error rates per user and department.',
        'terms' => 'integration gateway api existing system legacy connect embed plug erp crm '
             . 'data pipeline centralized consumption counts dashboards department error '
             . 'latency opentelemetry powered prometheus rates request',
    ],
    [
        'id' => 'q385', 'cat' => 'page-faq',
        'q' => 'Is AI integration compliant with data privacy regulations like GDPR and HIPAA?',
        'a' => 'Yes. We configure zero-data-retention headers, client-side PII redaction, and '
             . 'encrypted data transit (TLS 1.3) to ensure full compliance with global regulatory '
             . 'standards.',
        'terms' => 'integration gateway api existing system legacy connect embed plug erp crm '
             . 'data pipeline compliance configure encrypted ensure full global headers '
             . 'redaction regulatory retention side standards',
    ],
    [
        'id' => 'q386', 'cat' => 'page-faq',
        'q' => 'How long does it take to integrate AI into an existing enterprise application?',
        'a' => 'A standard integration sprint connecting an AI feature or semantic search into an '
             . 'existing application typically takes 2 to 3 weeks. Comprehensive enterprise '
             . 'platform modernizations take 4 to 6 weeks.',
        'terms' => 'integration gateway api existing system legacy connect embed plug erp crm '
             . 'data pipeline weeks comprehensive connecting feature modernizations platform '
             . 'search semantic sprint standard typically',
    ],

    // ---- Autonomous Workflow Automation ---- (services/autonomous-workflow-automation.php)

    [
        'id' => 'q387', 'cat' => 'page-faq',
        'q' => 'What is the difference between traditional RPA/scripts and Autonomous Workflow '
             . 'Automation?',
        'a' => 'Traditional RPA relies on rigid, hardcoded rules and coordinates via fragile UI '
             . 'selectors that break upon any minor website or data update. Autonomous Workflow '
             . 'Automation uses LLMs and cognitive agent loops that understand context, parse '
             . 'unstructured data, and dynamically adapt execution when errors occur.',
        'terms' => 'workflow automation process orchestrate approval queue selfhealing trigger '
             . 'pipeline endtoend adapt agent break cognitive context coordinates dynamically '
             . 'errors execution fragile hardcoded llms',
    ],
    [
        'id' => 'q388', 'cat' => 'page-faq',
        'q' => 'How does the \'self-healing\' capability work in practice?',
        'a' => 'When a pipeline step fails (such as an API schema change or missing data field), '
             . 'the agent analyzes the error message, determines alternative tool paths or '
             . 'parameter transformations, and retries the action dynamically without crashing '
             . 'the workflow.',
        'terms' => 'workflow automation process orchestrate approval queue selfhealing trigger '
             . 'pipeline endtoend action agent alternative analyzes change crashing '
             . 'determines dynamically error fails field message',
    ],
    [
        'id' => 'q389', 'cat' => 'page-faq',
        'q' => 'Can autonomous workflows process unstructured scanned documents and PDFs?',
        'a' => 'Yes. We incorporate multimodal vision-language parsing models and OCR engines '
             . 'that extract complex tables, handwritten notes, and nested metadata directly into '
             . 'validated JSON schemas.',
        'terms' => 'workflow automation process orchestrate approval queue selfhealing trigger '
             . 'pipeline endtoend complex directly engines extract handwritten incorporate '
             . 'json language metadata multimodal nested notes',
    ],
    [
        'id' => 'q390', 'cat' => 'page-faq',
        'q' => 'What systems can your autonomous workflow pipelines connect with?',
        'a' => 'We connect with Salesforce, HubSpot, SAP, NetSuite, Jira, GitHub, Slack, Gmail, '
             . 'Outlook, PostgreSQL, Snowflake, Twilio, Stripe, and custom in-house REST/GraphQL '
             . 'APIs.',
        'terms' => 'workflow automation process orchestrate approval queue selfhealing trigger '
             . 'pipeline endtoend apis custom github gmail graphql house hubspot jira '
             . 'netsuite outlook postgresql rest',
    ],
    [
        'id' => 'q391', 'cat' => 'page-faq',
        'q' => 'How do you guarantee that automated workflows don\'t perform unintended actions? '
             . 'How do you guarantee that automated workflows don\'t perform unintended actions?',
        'a' => 'We implement deterministic guardrails, Pydantic type validation, schema boundary '
             . 'checks, and human-in-the-loop approval thresholds for high-stakes actions like '
             . 'financial transfers.',
        'terms' => 'workflow automation process orchestrate approval queue selfhealing trigger '
             . 'pipeline endtoend boundary checks deterministic financial guardrails high '
             . 'human implement like loop pydantic',
    ],
    [
        'id' => 'q392', 'cat' => 'page-faq',
        'q' => 'What happens if an external API or database is temporarily unavailable?',
        'a' => 'Our workflows utilize distributed state engines (like Temporal and Celery) that '
             . 'maintain durable execution state, automatically queueing retries with exponential '
             . 'backoff until the service recovers.',
        'terms' => 'workflow automation process orchestrate approval queue selfhealing trigger '
             . 'pipeline endtoend state automatically backoff celery distributed durable '
             . 'engines execution exponential like maintain queueing',
    ],
    [
        'id' => 'q393', 'cat' => 'page-faq',
        'q' => 'Can workflows be deployed inside our private cloud or on-premise infrastructure? '
             . 'Can workflows be deployed inside our private cloud or on-premise infrastructure?',
        'a' => 'Yes. All workflow engines, agentic workers, and data stores are containerized and '
             . 'deployable within your private AWS, Azure, GCP VPC, or on-premise Kubernetes '
             . 'clusters.',
        'terms' => 'workflow automation process orchestrate approval queue selfhealing trigger '
             . 'pipeline endtoend agentic azure clusters containerized deployable engines '
             . 'kubernetes stores within workers',
    ],
    [
        'id' => 'q394', 'cat' => 'page-faq',
        'q' => 'How do human operators review edge cases or flagged anomalies?',
        'a' => 'We provide intuitive human-in-the-loop review interfaces and Slack/Teams '
             . 'interactive cards where operators can inspect flagged anomalies and approve or '
             . 'modify actions with a single click.',
        'terms' => 'workflow automation process orchestrate approval queue selfhealing trigger '
             . 'pipeline endtoend actions approve cards click inspect interactive interfaces '
             . 'intuitive loop modify single slack',
    ],
    [
        'id' => 'q395', 'cat' => 'page-faq',
        'q' => 'How do you monitor workflow health and measure performance gains?',
        'a' => 'We provide real-time dashboards displaying task volume, completion rates, average '
             . 'execution speed, self-healing recovery events, and net labor hours saved.',
        'terms' => 'workflow automation process orchestrate approval queue selfhealing trigger '
             . 'pipeline endtoend average completion dashboards displaying events execution '
             . 'healing hours labor rates real recovery',
    ],
    [
        'id' => 'q396', 'cat' => 'page-faq',
        'q' => 'How long does it take to automate a complex enterprise workflow?',
        'a' => 'A single high-impact workflow is typically designed, tested, and deployed into '
             . 'production in 3 to 4 weeks. Multi-process enterprise suites take 6 to 8 weeks.',
        'terms' => 'workflow automation process orchestrate approval queue selfhealing trigger '
             . 'pipeline endtoend weeks deployed designed high impact multi single suites '
             . 'tested typically',
    ],

    // ---- Agent Operations & Support ---- (services/agent-operations-support.php)

    [
        'id' => 'q397', 'cat' => 'page-faq',
        'q' => 'What is AgentOps and why is it necessary for production AI systems?',
        'a' => 'AgentOps (Agent Operations) is the discipline of monitoring, evaluating, and '
             . 'maintaining autonomous AI agents in production. Unlike traditional software, AI '
             . 'agents are non-deterministic; AgentOps provides continuous distributed tracing, '
             . 'hallucination detection, cost governance, and automated testing to ensure agents '
             . 'operate reliably and cost-effectively.',
        'terms' => 'agentops operations monitoring observability telemetry tracing logging cost '
             . 'token drift alert sre maintenance support agents agent automated autonomous '
             . 'continuous detection deterministic discipline distributed effectively ensure',
    ],
    [
        'id' => 'q398', 'cat' => 'page-faq',
        'q' => 'How do you monitor agent tool calls and reasoning chains in real time?',
        'a' => 'We instrument your agents with OpenTelemetry and LangSmith, capturing every step: '
             . 'prompt inputs, LLM reasoning tokens, tool selection, API payloads, execution '
             . 'latency, and final responses in interactive trace visualizations.',
        'terms' => 'agentops operations monitoring observability telemetry tracing logging cost '
             . 'token drift alert sre maintenance support agents capturing every execution '
             . 'final inputs instrument interactive langsmith latency opentelemetry payloads',
    ],
    [
        'id' => 'q399', 'cat' => 'page-faq',
        'q' => 'How do you detect model drift and hallucinations automatically?',
        'a' => 'We run continuous evaluation hooks (using RAGAS, TruLens, and LLM-as-a-judge '
             . 'models) on production sampling streams to evaluate factual groundedness, context '
             . 'precision, and safety scores against historical baselines.',
        'terms' => 'agentops operations monitoring observability telemetry tracing logging cost '
             . 'token drift alert sre maintenance support against baselines context '
             . 'continuous evaluate evaluation factual groundedness historical hooks judge '
             . 'precision',
    ],
    [
        'id' => 'q400', 'cat' => 'page-faq',
        'q' => 'How do you prevent runaway token bills and unexpected cloud costs?',
        'a' => 'We configure hard token spending caps, anomaly detection alerts, and '
             . 'rate-limiting middleware that automatically throttles or halts agent execution if '
             . 'an agent gets stuck in a repetitive loop.',
        'terms' => 'agentops operations monitoring observability telemetry tracing logging cost '
             . 'token drift alert sre maintenance support agent alerts anomaly automatically '
             . 'caps configure detection execution gets halts hard limiting',
    ],
    [
        'id' => 'q401', 'cat' => 'page-faq',
        'q' => 'What happens when an AI foundation model API goes down?',
        'a' => 'Our AgentOps architecture includes automated circuit breakers and multi-provider '
             . 'failover routing. If OpenAI or Anthropic experiences an outage, requests are '
             . 'instantly routed to an alternative foundation model or local vLLM backup.',
        'terms' => 'agentops operations monitoring observability telemetry tracing logging cost '
             . 'token drift alert sre maintenance support alternative anthropic architecture '
             . 'automated backup breakers circuit experiences failover includes instantly',
    ],
    [
        'id' => 'q402', 'cat' => 'page-faq',
        'q' => 'Can AgentOps telemetry be hosted in our private VPC without external data '
             . 'leakage?',
        'a' => 'Yes. We deploy self-hosted observability stacks (Prometheus, Grafana, Arize '
             . 'Phoenix, Jaeger) entirely inside your private cloud with zero data transmitted to '
             . 'third parties.',
        'terms' => 'agentops operations monitoring observability telemetry tracing logging cost '
             . 'token drift alert sre maintenance support arize cloud deploy entirely grafana '
             . 'inside jaeger parties phoenix prometheus self',
    ],
    [
        'id' => 'q403', 'cat' => 'page-faq',
        'q' => 'How do you test agent prompt updates before deploying to production?',
        'a' => 'We integrate automated evaluation harnesses into your CI/CD pipeline that run '
             . 'regression test suites across hundreds of golden use cases, ensuring prompt '
             . 'updates improve performance without breaking existing capabilities.',
        'terms' => 'agentops operations monitoring observability telemetry tracing logging cost '
             . 'token drift alert sre maintenance support across automated breaking '
             . 'capabilities cases ensuring evaluation existing golden harnesses hundreds '
             . 'improve',
    ],
    [
        'id' => 'q404', 'cat' => 'page-faq',
        'q' => 'What is your Mean Time to Remediation (MTTR) for critical agent incidents?',
        'a' => 'Our standard enterprise SLA provides a 1-hour critical response time, while '
             . 'dedicated AI SRE enterprise tiers provide a 15-minute response SLA with 24/7 '
             . 'active coverage.',
        'terms' => 'agentops operations monitoring observability telemetry tracing logging cost '
             . 'token drift alert sre maintenance support response active coverage dedicated '
             . 'hour minute standard tiers while',
    ],
    [
        'id' => 'q405', 'cat' => 'page-faq',
        'q' => 'Do you support multi-cloud and hybrid on-premise agent deployments?',
        'a' => 'Yes. Our AgentOps telemetry and SRE practices support agents deployed across AWS, '
             . 'Azure, GCP, and bare-metal on-premise Kubernetes clusters.',
        'terms' => 'agentops operations monitoring observability telemetry tracing logging cost '
             . 'token drift alert sre maintenance support across agents azure bare clusters '
             . 'deployed kubernetes metal practices',
    ],
    [
        'id' => 'q406', 'cat' => 'page-faq',
        'q' => 'How long does it take to integrate AgentOps observability into our existing AI '
             . 'systems?',
        'a' => 'A comprehensive AgentOps setup sprint instrumenting all microservices, '
             . 'dashboards, and alert channels typically takes 2 weeks.',
        'terms' => 'agentops operations monitoring observability telemetry tracing logging cost '
             . 'token drift alert sre maintenance support channels comprehensive dashboards '
             . 'instrumenting microservices setup sprint typically weeks',
    ],

    // ---- RPA Development ---- (services/rpa-development.php)

    [
        'id' => 'q407', 'cat' => 'page-faq',
        'q' => 'How is Cognitive RPA different from traditional RPA tools like UiPath?',
        'a' => 'Traditional RPA relies on rigid element coordinates and XPath selectors that '
             . 'break whenever a UI updates. Cognitive RPA combines computer vision and '
             . 'multimodal LLMs to understand the screen visually and semantically like a human '
             . 'operator, making it resilient to UI changes.',
        'terms' => 'rpa robotic process automation bot uipath macro repetitive rules screen '
             . 'scraping legacy task break changes combines computer coordinates element '
             . 'human llms making multimodal operator relies',
    ],
    [
        'id' => 'q408', 'cat' => 'page-faq',
        'q' => 'Can Cognitive RPA automate legacy desktop applications and terminal emulators?',
        'a' => 'Yes. We automate legacy Windows desktop applications, AS/400 terminal emulators, '
             . 'SAP GUI, and Citrix virtual desktop sessions using vision-driven OCR and '
             . 'keyboard/mouse emulation.',
        'terms' => 'rpa robotic process automation bot uipath macro repetitive rules screen '
             . 'scraping legacy task citrix driven emulation keyboard mouse sessions virtual '
             . 'vision windows',
    ],
    [
        'id' => 'q409', 'cat' => 'page-faq',
        'q' => 'What is the difference between Attended and Unattended RPA bots?',
        'a' => 'Attended bots run on an employee\'s local machine, acting as a copilot that '
             . 'assists with tasks on demand. Unattended bots run autonomously on background '
             . 'virtual machines to process high-volume batch queues 24/7.',
        'terms' => 'rpa robotic process automation bot uipath macro repetitive rules screen '
             . 'scraping legacy task acting assists autonomously background batch copilot '
             . 'demand employee high local machine machines',
    ],
    [
        'id' => 'q410', 'cat' => 'page-faq',
        'q' => 'How do Cognitive RPA bots handle unstructured invoices and scanned documents?',
        'a' => 'Bots use multimodal OCR and layout-aware vision models to extract tabular data, '
             . 'line items, and totals directly into structured JSON, verifying sums against '
             . 'database records before saving.',
        'terms' => 'rpa robotic process automation bot uipath macro repetitive rules screen '
             . 'scraping legacy task against aware database directly extract items json '
             . 'layout line multimodal records saving',
    ],
    [
        'id' => 'q411', 'cat' => 'page-faq',
        'q' => 'How do you securely manage passwords and credentials for bots?',
        'a' => 'Bots retrieve short-lived credentials from encrypted enterprise key vaults (such '
             . 'as HashiCorp Vault or AWS Secrets Manager). Passwords are never hardcoded or '
             . 'exposed in logs.',
        'terms' => 'rpa robotic process automation bot uipath macro repetitive rules screen '
             . 'scraping legacy task encrypted exposed hardcoded hashicorp lived logs manager '
             . 'never retrieve secrets short vault',
    ],
    [
        'id' => 'q412', 'cat' => 'page-faq',
        'q' => 'What happens if a website displays a CAPTCHA or unexpected popup?',
        'a' => 'Our bots utilize cognitive vision reasoning to recognize and handle routine '
             . 'popups gracefully. For high-security CAPTCHAs, the bot can escalate to a human '
             . 'operator or solve approved accessibility challenges.',
        'terms' => 'rpa robotic process automation bot uipath macro repetitive rules screen '
             . 'scraping legacy task accessibility approved bots captchas challenges '
             . 'cognitive escalate gracefully handle high human operator',
    ],
    [
        'id' => 'q413', 'cat' => 'page-faq',
        'q' => 'How do bots handle sudden changes in web page layouts?',
        'a' => 'Our bots use semantic vision anchors and multi-modal grounding rather than rigid '
             . 'XPaths. If a button moves to a new location or changes color, the bot visually '
             . 'locates it by its semantic label and intent.',
        'terms' => 'rpa robotic process automation bot uipath macro repetitive rules screen '
             . 'scraping legacy task semantic anchors button color grounding intent label '
             . 'locates location modal moves multi',
    ],
    [
        'id' => 'q414', 'cat' => 'page-faq',
        'q' => 'Can Cognitive RPA integrate directly with backend databases and APIs?',
        'a' => 'Yes. When APIs are available, bots execute direct REST/SQL calls for maximum '
             . 'speed, and switch to visual UI automation only when interacting with legacy '
             . 'frontends.',
        'terms' => 'rpa robotic process automation bot uipath macro repetitive rules screen '
             . 'scraping legacy task available bots calls direct execute frontends '
             . 'interacting maximum rest speed',
    ],
    [
        'id' => 'q415', 'cat' => 'page-faq',
        'q' => 'How do you ensure enterprise compliance and auditability for RPA actions?',
        'a' => 'Every bot action, keystroke, and database modification is recorded in immutable '
             . 'audit logs. We can also record encrypted video sessions of bot executions for '
             . 'compliance audits.',
        'terms' => 'rpa robotic process automation bot uipath macro repetitive rules screen '
             . 'scraping legacy task action audit audits database encrypted every executions '
             . 'immutable keystroke logs modification record',
    ],
    [
        'id' => 'q416', 'cat' => 'page-faq',
        'q' => 'How long does it take to develop and deploy a Cognitive RPA bot?',
        'a' => 'A single high-impact cognitive bot is typically operational in 2 to 3 weeks. '
             . 'Comprehensive enterprise multi-bot fleet rollouts take 4 to 6 weeks.',
        'terms' => 'rpa robotic process automation bot uipath macro repetitive rules screen '
             . 'scraping legacy task weeks comprehensive fleet high impact multi operational '
             . 'rollouts single typically',
    ],

    // ---- Hire Agentic AI Developers ---- (services/hire-agentic-ai-developers.php)

    [
        'id' => 'q417', 'cat' => 'page-faq',
        'q' => 'How quickly can a dedicated Agentic AI developer join our team?',
        'a' => 'We match and onboard pre-vetted developers within 48 to 72 hours. You interview '
             . 'the candidates directly and they can begin writing code on your next sprint.',
        'terms' => 'hire hiring recruit staff developer engineer talent team squad onboard '
             . 'contract augmentation dedicated begin candidates code developers directly '
             . 'hours interview match next sprint vetted',
    ],
    [
        'id' => 'q418', 'cat' => 'page-faq',
        'q' => 'How do you vet and evaluate your AI engineers?',
        'a' => 'Our rigorous 4-stage vetting process evaluates algorithmic problem solving, '
             . 'hands-on LangGraph state machine development, vector search architecture, and '
             . 'live system design challenges. Only the top 1% of applicants are selected.',
        'terms' => 'hire hiring recruit staff developer engineer talent team squad onboard '
             . 'contract augmentation dedicated algorithmic applicants architecture '
             . 'challenges design evaluates hands langgraph live machine problem process',
    ],
    [
        'id' => 'q419', 'cat' => 'page-faq',
        'q' => 'What timezone will our dedicated AI developer work in?',
        'a' => 'Our developers provide 100% timezone overlap with your team across North America, '
             . 'Europe, India, and APAC. They participate in your daily standups, sprint '
             . 'planning, and Slack channels.',
        'terms' => 'hire hiring recruit staff developer engineer talent team squad onboard '
             . 'contract augmentation dedicated across america apac channels daily developers '
             . 'europe india north overlap participate planning',
    ],
    [
        'id' => 'q420', 'cat' => 'page-faq',
        'q' => 'Do we own the intellectual property (IP) and code written by the developers?',
        'a' => 'Yes. You maintain 100% ownership of all source code, models, prompts, datasets, '
             . 'and intellectual property produced during the engagement.',
        'terms' => 'hire hiring recruit staff developer engineer talent team squad onboard '
             . 'contract augmentation dedicated datasets engagement maintain ownership '
             . 'produced prompts source',
    ],
    [
        'id' => 'q421', 'cat' => 'page-faq',
        'q' => 'Can we hire a single engineer or an entire squad?',
        'a' => 'Both. You can hire a single specialized developer (e.g., a LangGraph expert) or '
             . 'scale up to a full cross-functional AI squad (Architect, ML Engineer, Backend '
             . 'Developer, and QA).',
        'terms' => 'hire hiring recruit staff developer engineer talent team squad onboard '
             . 'contract augmentation dedicated architect backend cross expert full '
             . 'functional langgraph scale specialized',
    ],
    [
        'id' => 'q422', 'cat' => 'page-faq',
        'q' => 'What happens if a developer is not the right fit for our project?',
        'a' => 'We offer a 14-day zero-risk trial period. If you feel the candidate is not the '
             . 'perfect fit, we will replace them immediately at no additional cost.',
        'terms' => 'hire hiring recruit staff developer engineer talent team squad onboard '
             . 'contract augmentation dedicated additional candidate cost feel immediately '
             . 'offer perfect period replace risk trial zero',
    ],
    [
        'id' => 'q423', 'cat' => 'page-faq',
        'q' => 'What AI tools and frameworks are your developers experienced in?',
        'a' => 'Our developers specialize in LangGraph, Model Context Protocol (MCP), PyTorch, '
             . 'vLLM, LlamaIndex, Qdrant, Milvus, Hugging Face, FastAPI, Docker, and Kubernetes.',
        'terms' => 'hire hiring recruit staff developer engineer talent team squad onboard '
             . 'contract augmentation dedicated context docker face fastapi hugging '
             . 'kubernetes langgraph llamaindex milvus protocol pytorch qdrant',
    ],
    [
        'id' => 'q424', 'cat' => 'page-faq',
        'q' => 'How does billing and contract duration work?',
        'a' => 'We operate on straightforward monthly billing with no long-term lock-in. You can '
             . 'scale your team up or down with a standard 30-day notice.',
        'terms' => 'hire hiring recruit staff developer engineer talent team squad onboard '
             . 'contract augmentation dedicated lock monthly notice operate scale standard '
             . 'straightforward term',
    ],
    [
        'id' => 'q425', 'cat' => 'page-faq',
        'q' => 'Will the developer work exclusively on our project?',
        'a' => 'Yes. All our dedicated developers work 100% exclusively on your project full-time '
             . '(40 hours per week) with no split focus on other clients.',
        'terms' => 'hire hiring recruit staff developer engineer talent team squad onboard '
             . 'contract augmentation dedicated developers focus full hours split time week',
    ],
    [
        'id' => 'q426', 'cat' => 'page-faq',
        'q' => 'Can your developers work within our secure private cloud or on-premise '
             . 'repositories?',
        'a' => 'Yes. Our engineers adhere to enterprise security protocols, connecting via your '
             . 'corporate VPN, hardware tokens, and private GitHub/GitLab organizations with '
             . 'strict NDA compliance.',
        'terms' => 'hire hiring recruit staff developer engineer talent team squad onboard '
             . 'contract augmentation dedicated adhere compliance connecting corporate '
             . 'engineers github gitlab hardware organizations protocols security strict',
    ],
];
