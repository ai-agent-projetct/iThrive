<?php
/**
 * Every piece of site copy lives here so templates stay purely structural.
 *
 * Constants are grouped: home page sections first, then the service catalogue,
 * proprietary products, case studies, and the smaller company pages.
 */

declare(strict_types=1);

// ---------------------------------------------------------------------------
// Home
// ---------------------------------------------------------------------------

const HOME_HERO = [
    'eyebrow'  => 'Incubating a Culture of Innovation & AI-First Excellence',
    'title'    => 'We Build Intelligent Apps & AI Platforms That Scale Your Business.',
    'lead'     => 'From Agentic AI ecosystems to custom Python-backed platforms, iThrive Software bridges the gap between businesses and their customers.',
    'primary'  => ['label' => 'Start Your Project', 'href' => 'contact.php'],
    'secondary'=> ['label' => 'See Our Work',       'href' => 'case-studies.php'],
];

/** Floating chips that orbit the 3D hero mesh. */
const HOME_HERO_STATS = [
    ['value' => '10+',    'label' => 'Enterprise AI Apps Built', 'icon' => 'sparkles'],
    ['value' => '99.9%',  'label' => 'Platform Uptime',          'icon' => 'gauge'],
    ['value' => 'Python', 'label' => 'Agentic AI Engine',        'icon' => 'brain'],
];

const HOME_STATEMENT = 'Every product we ship starts as a bridge — between a business and the customer it has not reached yet. We engineer that bridge in Python, wire intelligence through it, and run it in the cloud at enterprise scale.';

/**
 * Extra sections for the mobile app development service page.
 *
 * Ported from the ai-agent-projetct/mobile-app-page repository, whose complete
 * implementation is a React/Vite app; this is the same content and the same
 * arithmetic rebuilt on this site's own components, since nothing here has a
 * build step or Tailwind.
 */
const MOBILE_APP_FUNCTIONS = [
    ['icon' => 'layers',     'title' => 'Flutter & React Native dual store',
     'body' => 'Chosen per project on real criteria — existing team skills, native module needs and animation load — shipping to both the App Store and Google Play.'],
    ['icon' => 'refresh',    'title' => 'Offline-first data sync engine',
     'body' => 'Local SQLite or Hive persistence with conflict-aware sync, so the app stays usable in a lift, a basement or a rural dead spot.'],
    ['icon' => 'network',    'title' => 'Real-time WebSockets & GPS',
     'body' => 'Live location, instant chat and presence over WebSockets, with battery-conscious location handling and background workers.'],
    ['icon' => 'message',    'title' => 'Push notifications & deep linking',
     'body' => 'Segmented pushes and deep links that survive a cold start and land the user on the right in-app screen rather than the home tab.'],
    ['icon' => 'rocket',     'title' => 'Store release management',
     'body' => 'Submission, staged rollouts, screenshot assets and the Apple and Google review cycles handled by engineers who have done it before.'],
    ['icon' => 'gauge',      'title' => 'Crash & performance monitoring',
     'body' => 'Sentry, Crashlytics and store vitals wired into the first build, backed by a triage process rather than an unwatched dashboard.'],
];

/**
 * The cost estimator.
 *
 * Prices are the ones the source repository ships. They are quoted in rupees
 * with a dollar column, and the multiplier applies to platform plus features.
 */
const MOBILE_APP_ESTIMATOR = [
    'platforms' => [
        ['id' => 'ios',     'label' => 'Native iOS',      'inr' => 180000, 'usd' => 2400],
        ['id' => 'android', 'label' => 'Native Android',  'inr' => 180000, 'usd' => 2400],
        ['id' => 'both',    'label' => 'Cross-platform',  'inr' => 280000, 'usd' => 3600],
    ],
    'design' => [
        ['id' => 'minimal', 'label' => 'Standard UI',        'mult' => 1.0,  'note' => 'Clean native components'],
        ['id' => 'premium', 'label' => 'Custom UI',          'mult' => 1.25, 'note' => 'Micro-animations and dark mode'],
        ['id' => '3d',      'label' => 'Interactive 3D & AR','mult' => 1.5,  'note' => 'WebGL, 3D models, glassmorphism'],
    ],
    'features' => [
        ['id' => 'auth',     'label' => 'Biometric auth & OTP',            'inr' => 25000, 'usd' => 350],
        ['id' => 'payments', 'label' => 'UPI / Stripe payment gateway',    'inr' => 35000, 'usd' => 450],
        ['id' => 'push',     'label' => 'Push notifications & messaging',  'inr' => 20000, 'usd' => 250],
        ['id' => 'gps',      'label' => 'Live GPS location & maps',        'inr' => 40000, 'usd' => 500],
        ['id' => 'chat',     'label' => 'Realtime chat & audio calls',     'inr' => 45000, 'usd' => 600],
        ['id' => 'ai',       'label' => 'On-device AI assistant',          'inr' => 65000, 'usd' => 850],
        ['id' => 'admin',    'label' => 'Web admin dashboard & analytics', 'inr' => 50000, 'usd' => 650],
    ],
    'defaults' => ['platform' => 'both', 'design' => 'premium', 'features' => ['auth', 'payments', 'push']],
];

/**
 * Chapters of the scroll-scrubbed services film.
 *
 * `at` is the second the card is fully legible, read off a one-frame-per-second
 * contact sheet of the source film rather than guessed. Each chapter links to
 * the service the card actually names, so the film doubles as navigation.
 */
const SERVICES_FILM = [
    'eyebrow' => 'The Work, In Motion',
    'title'   => 'Scroll the film. Every card is a service.',
    'lead'    => 'Seventeen seconds of what we build, tied to the scroll wheel. '
               . 'Stop anywhere and open that service.',
    'duration' => 17.36,
    'chapters' => [
        ['at' => 1.2,  'label' => 'AI-Native Product Development', 'href' => 'services/ai-native-product-development.php'],
        ['at' => 2.4,  'label' => 'AI Enablement for Existing Products', 'href' => 'services/ai-enablement.php'],
        ['at' => 3.5,  'label' => 'AI Solutions for eCommerce', 'href' => 'services/ai-for-ecommerce.php'],
        ['at' => 5.1,  'label' => 'Micro SaaS Development', 'href' => 'services/micro-saas-development.php'],
        ['at' => 6.2,  'label' => 'Custom Product Development', 'href' => 'services/custom-product-development.php'],
        ['at' => 7.3,  'label' => 'Mobile App Development', 'href' => 'services/mobile-app-development.php'],
        ['at' => 8.6,  'label' => 'Software Development', 'href' => 'services/web-development.php'],
        ['at' => 10.1, 'label' => 'E-Commerce App Development', 'href' => 'services/ecommerce-development.php'],
        ['at' => 11.2, 'label' => 'React JS Development', 'href' => 'services/reactjs-development.php'],
        ['at' => 14.0, 'label' => 'Every service we run', 'href' => 'services.php'],
    ],
];

const HOME_SERVICES_HEAD = [
    'eyebrow' => 'What We Do',
    'title'   => 'A full-stack engineering partner for the AI era',
    'lead'    => 'Four practices, one team. Pick the model that fits where your product is today — greenfield AI build, modernisation of what you already run, or an embedded squad that plugs into yours.',
];

/**
 * The film below this heading carries the four-point argument as animation.
 * These paragraphs are the same case in prose — visible, indexable copy that
 * names every service line, which a scroll-scrubbed video cannot do for a
 * crawler or an answer engine.
 */
const HOME_WHY = [
    'eyebrow' => 'Why iThrive',
    'title'   => 'Engineering depth, not agency theatre',
    'body'    => [
        'At iThrive, engineering depth comes first. We build scalable, secure, and high-performance '
        . 'digital products designed around real business outcomes—not temporary solutions or '
        . 'agency-style execution. Our expertise covers AI-first product development, AI-native '
        . 'applications, AI enablement, AI solutions for eCommerce, Micro SaaS development, custom '
        . 'software development, product modernization, cloud and DevOps. We help businesses turn '
        . 'ideas into production-ready products while improving existing platforms through modern '
        . 'architecture, automation, intelligent workflows, and cloud-native engineering. Every '
        . 'solution is designed to be reliable, maintainable, and ready to evolve as your business grows.',

        'Our engineering capabilities extend across the complete digital product lifecycle, from POC '
        . 'and MVP development to full-scale product engineering. We provide mobile app development, '
        . 'web development, eCommerce development, React JS development, dedicated engineering teams, '
        . 'and on-demand technical resources. Whether launching a new product, modernizing legacy '
        . 'software, or adding AI capabilities to an existing platform, iThrive combines product '
        . 'thinking, engineering expertise, and agile execution to deliver measurable results, faster '
        . 'time-to-market, and long-term technology value.',
    ],
];

const HOME_STATS_BAND = [
    ['value' => '10+',  'label' => 'Enterprise platforms shipped'],
    ['value' => '8',    'label' => 'Industries served'],
    ['value' => '40%',  'label' => 'Average process time removed'],
    ['value' => '99.9%','label' => 'Uptime across managed products'],
];

const HOME_CTA = [
    'eyebrow' => 'Start Your Project',
    'title'   => 'Tell us what you are trying to automate.',
    'body'    => 'Send a paragraph about the workflow that is slowing you down. You will get a written build plan — scope, stack and a realistic timeline — inside two working days.',
    'primary' => ['label' => 'Start Your Project', 'href' => 'contact.php'],
    'secondary' => ['label' => 'Browse case studies', 'href' => 'case-studies.php'],
];

// ---------------------------------------------------------------------------
// Process — the 3-step execution pipeline
// ---------------------------------------------------------------------------

const PROCESS = [
    'eyebrow' => 'How We Work',
    'title'   => '3-Step Execution',
    'lead'    => 'Discovery, Clarity, Execution. Three gates, each ending in something you can hold — not a status call.',
    'steps'   => [
        [
            'number' => '01',
            'key'    => 'discovery',
            'icon'   => 'search',
            'title'  => 'Discovery',
            'body'   => 'We sit with the people doing the work and map the real workflow — including the spreadsheet nobody mentions. Every manual handoff gets timed and costed.',
            'points' => ['Stakeholder workshops', 'Workflow and data audit', 'AI feasibility scoring', 'Risk and compliance review'],
            'output' => 'Opportunity map with effort-vs-impact scoring',
        ],
        [
            'number' => '02',
            'key'    => 'clarity',
            'icon'   => 'compass',
            'title'  => 'Clarity',
            'body'   => 'Scope is fixed in writing before a line of production code exists. Architecture, model strategy, interfaces and the success metric we will be judged on.',
            'points' => ['Solution architecture', 'Clickable prototype', 'Model and data strategy', 'Fixed scope and timeline'],
            'output' => 'Signed-off build plan and prototype',
        ],
        [
            'number' => '03',
            'key'    => 'execution',
            'icon'   => 'rocket',
            'title'  => 'Execution',
            'body'   => 'Two-week increments, demoed live. CI/CD, observability and rollback ship with the first release, so going to production is a routine event rather than an incident.',
            'points' => ['Fortnightly shipping cadence', 'Automated test and deploy', 'Live observability dashboards', 'Hypercare and handover'],
            'output' => 'Production platform, documented and owned by you',
        ],
    ],
];

// ---------------------------------------------------------------------------
// Services catalogue
// ---------------------------------------------------------------------------

const SERVICES = [
    [
        'slug'  => 'ai-first',
        'title' => 'AI-First Product Development',
        'lead'  => 'Products where the intelligence is the product — agents, reasoning pipelines and models that make a decision rather than render a page.',
        'icon'  => 'brain',
        'items' => [
            [
                'slug'  => 'ai-native-product-development',
                'title' => 'AI-Native Product Development',
                'icon'  => 'sparkles',
                'short' => 'Greenfield platforms designed around an agentic core, where the model is the primary interface rather than a bolted-on assistant.',
                'lead'  => 'Most "AI products" are a chat box glued to an existing CRUD app. An AI-native product is architected the other way round: the agent owns the workflow, and the interface exists to supervise it.',
                'capabilities' => [
                    ['title' => 'Agentic workflow design', 'body' => 'Multi-step agents built on LangGraph with explicit state machines, tool contracts and human approval gates at the steps that matter.'],
                    ['title' => 'Retrieval architecture',  'body' => 'Chunking, embedding and hybrid retrieval tuned against your own corpus, with reranking and citation so answers are traceable to a source document.'],
                    ['title' => 'Evaluation harness',      'body' => 'A golden dataset and automated eval suite that runs on every prompt or model change, so quality regressions are caught in CI rather than by customers.'],
                    ['title' => 'Guardrails and fallbacks','body' => 'Schema-validated outputs, cost ceilings, prompt-injection filtering and a deterministic fallback path for every agent action.'],
                    ['title' => 'Human-in-the-loop UX',    'body' => 'Review queues, confidence surfacing and one-click correction, so your team supervises the agent instead of babysitting it.'],
                    ['title' => 'Observability',           'body' => 'Full trace capture on every agent run — tokens, latency, tool calls and cost, broken down per customer and per feature.'],
                ],
                'outcomes' => [
                    ['value' => '6-10 wks', 'label' => 'Greenfield agent in production'],
                    ['value' => '60%+',     'label' => 'Manual steps typically removed'],
                    ['value' => '100%',     'label' => 'Agent runs traced and costed'],
                ],
                'stack' => ['Python', 'FastAPI', 'LangGraph', 'PostgreSQL + pgvector', 'Celery', 'Redis', 'Docker', 'AWS'],
            ],
            [
                'slug'  => 'ai-enablement',
                'title' => 'AI Enablement for Existing Products',
                'icon'  => 'refresh',
                'short' => 'Add intelligence to the platform you already run, without a rewrite and without destabilising the revenue it carries.',
                'lead'  => 'You already have a working product and paying customers. The job is to add intelligence to it without touching the parts that earn money — so we build alongside, not through.',
                'capabilities' => [
                    ['title' => 'AI opportunity audit',   'body' => 'We instrument the existing product, find where users stall or support tickets cluster, and rank the candidate AI features by effort against measured impact.'],
                    ['title' => 'Sidecar architecture',   'body' => 'Intelligence ships as a separate service behind a feature flag. Your monolith keeps running; the AI layer can be switched off in one call.'],
                    ['title' => 'Data readiness work',    'body' => 'Extraction, cleaning and embedding of the operational data already sitting in your database, files and ticket history.'],
                    ['title' => 'Incremental rollout',    'body' => 'Shadow mode first, then a cohort, then general availability — each stage gated on the eval metrics agreed up front.'],
                    ['title' => 'Cost control',           'body' => 'Model routing, caching and prompt compression so unit economics stay sane once the feature reaches your whole user base.'],
                    ['title' => 'Team handover',          'body' => 'Your engineers pair with ours through the build and own the runbook at the end. No permanent dependency on us.'],
                ],
                'outcomes' => [
                    ['value' => '0',      'label' => 'Rewrites required'],
                    ['value' => '2-4 wks','label' => 'From audit to first shipped feature'],
                    ['value' => '1 flag', 'label' => 'To disable the entire AI layer'],
                ],
                'stack' => ['Python', 'FastAPI', 'Feature flags', 'pgvector', 'Redis', 'OpenTelemetry', 'Docker'],
            ],
            [
                'slug'  => 'ai-for-ecommerce',
                'title' => 'AI Solutions for eCommerce',
                'icon'  => 'cart',
                'short' => 'Recommendation, sizing, search and support intelligence that moves conversion and cuts returns on storefronts you already operate.',
                'lead'  => 'E-commerce AI only counts if it shows up in two numbers: conversion rate and return rate. Everything we build for retail is measured against those.',
                'capabilities' => [
                    ['title' => 'Recommendation engines', 'body' => 'Behavioural and content-based recommenders trained on your own order history, served with sub-50ms latency at the product and cart level.'],
                    ['title' => 'Fit and sizing models',  'body' => 'Size-recommendation engines built from returns data and product measurements — the single highest-leverage return-rate lever in apparel.'],
                    ['title' => 'Semantic search',        'body' => 'Natural-language catalogue search that understands "something warm for a two year old" instead of matching keywords against product titles.'],
                    ['title' => 'Intent-based merchandising', 'body' => 'Live session scoring that changes what a visitor sees based on where they actually are in the buying decision.'],
                    ['title' => 'Support deflection',     'body' => 'Order-aware assistants wired into your OMS, resolving "where is my order" and returns initiation without a human touch.'],
                    ['title' => 'Demand forecasting',     'body' => 'SKU-level forecasting that feeds purchasing, so stockouts on your best sellers stop being a monthly surprise.'],
                ],
                'outcomes' => [
                    ['value' => '28%',   'label' => 'Return-rate reduction achieved'],
                    ['value' => '<50ms', 'label' => 'Recommendation serving latency'],
                    ['value' => '3-6 wks','label' => 'Typical time to first uplift'],
                ],
                'stack' => ['Python', 'FastAPI', 'scikit-learn', 'PyTorch', 'OpenSearch', 'Redis', 'Shopify / WooCommerce APIs'],
            ],
        ],
    ],
    [
        'slug'  => 'product-engineering',
        'title' => 'Digital Product Engineering',
        'lead'  => 'The platform underneath the intelligence — built to be handed over, scaled and maintained by your own team.',
        'icon'  => 'layers',
        'items' => [
            [
                'slug'  => 'micro-saas-development',
                'title' => 'Micro SaaS Development',
                'icon'  => 'package',
                'short' => 'Focused, single-problem SaaS products taken from idea to first paying customer without enterprise-scale overhead.',
                'lead'  => 'A micro SaaS lives or dies on time-to-first-customer. We ship the smallest thing that can take money, then grow it on evidence rather than roadmap optimism.',
                'capabilities' => [
                    ['title' => 'Multi-tenancy from day one', 'body' => 'Row-level tenant isolation, per-tenant configuration and a plan model that will not need re-architecting at customer fifty.'],
                    ['title' => 'Billing and subscriptions',  'body' => 'Stripe or Razorpay wired to real entitlements — trials, upgrades, dunning and proration handled rather than stubbed.'],
                    ['title' => 'Self-serve onboarding',      'body' => 'Signup, workspace creation, invites and an activation path that gets a new account to value without a sales call.'],
                    ['title' => 'Usage metering',             'body' => 'Event-level usage tracking that feeds both the pricing model and your understanding of which features earn their keep.'],
                    ['title' => 'Product analytics',          'body' => 'Funnel and retention instrumentation installed at build time, so the first churn conversation has data behind it.'],
                    ['title' => 'Lean infrastructure',        'body' => 'A deployment footprint sized for early revenue — usually a single container platform and a managed database, not a Kubernetes estate.'],
                ],
                'outcomes' => [
                    ['value' => '8-12 wks','label' => 'Idea to revenue-ready product'],
                    ['value' => 'Day 1',   'label' => 'Multi-tenant and billable'],
                    ['value' => 'Zero',    'label' => 'Re-architecture at scale-up'],
                ],
                'stack' => ['Python', 'Django / FastAPI', 'PostgreSQL', 'Stripe', 'React', 'Docker', 'Render / AWS'],
            ],
            [
                'slug'  => 'custom-product-development',
                'title' => 'Custom Product Development',
                'icon'  => 'code',
                'short' => 'Bespoke platforms for operations that no off-the-shelf tool models correctly — built to your workflow, not around it.',
                'lead'  => 'Every business eventually hits the workflow that no SaaS product supports. That is where custom development stops being a luxury and starts being cheaper than the workarounds.',
                'capabilities' => [
                    ['title' => 'Domain modelling',        'body' => 'We model your actual entities and their real rules — the exceptions included — before any interface is drawn.'],
                    ['title' => 'Role-based access',       'body' => 'Permission systems that survive contact with reality: delegated approval, temporary access and a full audit trail.'],
                    ['title' => 'Integration layer',       'body' => 'Typed connectors to the ERP, accounting system, payment gateway and hardware you already run, with retries and reconciliation.'],
                    ['title' => 'Workflow automation',     'body' => 'Background jobs, scheduled processes and event-driven steps that replace the manual chase currently living in email.'],
                    ['title' => 'Reporting and exports',   'body' => 'The reports management actually asks for, generated on schedule and delivered where they are read.'],
                    ['title' => 'Documented handover',     'body' => 'Architecture notes, runbooks and a working local environment, so another team could pick this up without us.'],
                ],
                'outcomes' => [
                    ['value' => '100%',    'label' => 'Workflow coverage, exceptions included'],
                    ['value' => 'Full',    'label' => 'Source ownership and documentation'],
                    ['value' => '12-20 wks','label' => 'Typical first production release'],
                ],
                'stack' => ['Python', 'Django', 'PostgreSQL', 'Celery', 'React', 'Docker', 'AWS / Azure'],
            ],
            [
                'slug'  => 'product-modernization',
                'title' => 'Product Modernization',
                'icon'  => 'git-branch',
                'short' => 'Strangle the legacy system incrementally — no big-bang rewrite, no frozen feature roadmap for a year.',
                'lead'  => 'Rewrites fail because they ask a business to stand still. We modernise by routing traffic away from the old system one capability at a time, with both running until the last one moves.',
                'capabilities' => [
                    ['title' => 'Legacy assessment',      'body' => 'Static analysis, dependency mapping and a candid report on what is worth keeping, what to wrap, and what to delete.'],
                    ['title' => 'Strangler-fig migration','body' => 'A routing layer in front of the legacy app lets new services take over endpoints one at a time, reversibly.'],
                    ['title' => 'Data migration',         'body' => 'Dual-write, backfill and reconciliation scripts with verifiable row counts — not a weekend cutover and a prayer.'],
                    ['title' => 'Test net first',         'body' => 'Characterisation tests around current behaviour before anything moves, so regressions are visible immediately.'],
                    ['title' => 'Framework and runtime upgrades', 'body' => 'PHP, Python 2 and end-of-life framework versions brought current, with the security debt cleared as part of the work.'],
                    ['title' => 'Zero-downtime cutover',  'body' => 'Blue-green deploys and feature-flagged switches so each migration step is a config change, not an outage window.'],
                ],
                'outcomes' => [
                    ['value' => '0 hrs',  'label' => 'Planned downtime at cutover'],
                    ['value' => 'Always', 'label' => 'Rollback path per migration step'],
                    ['value' => 'Live',   'label' => 'Feature delivery continues throughout'],
                ],
                'stack' => ['Python', 'Django', 'Legacy PHP / .NET bridges', 'PostgreSQL', 'Nginx', 'Docker', 'Terraform'],
            ],
            [
                'slug'  => 'cloud-devops',
                'title' => 'Cloud & DevOps',
                'icon'  => 'cloud',
                'short' => 'Infrastructure as code, CI/CD and observability — so deploying is boring and outages are short.',
                'lead'  => 'Good infrastructure is invisible. The measure is how quickly you can ship a fix at 6pm on a Friday and how fast you know when something breaks.',
                'capabilities' => [
                    ['title' => 'Infrastructure as code', 'body' => 'Terraform-defined environments that can be destroyed and rebuilt identically, with staging matching production.'],
                    ['title' => 'CI/CD pipelines',        'body' => 'Test, build, scan and deploy automated end to end, with environment promotion and one-command rollback.'],
                    ['title' => 'Containerisation',       'body' => 'Multi-stage Docker builds and orchestration sized to your load — ECS or a managed platform before Kubernetes, unless Kubernetes is genuinely warranted.'],
                    ['title' => 'Observability',          'body' => 'Structured logs, metrics, traces and alerts that page a human only when a human is needed.'],
                    ['title' => 'Cost engineering',       'body' => 'Right-sizing, autoscaling policies and spot usage, with a monthly cost report broken down by service.'],
                    ['title' => 'Security baseline',      'body' => 'Secret management, least-privilege IAM, dependency scanning and automated patching in the pipeline.'],
                ],
                'outcomes' => [
                    ['value' => '<10 min','label' => 'Commit to production'],
                    ['value' => '99.9%',  'label' => 'Uptime across managed platforms'],
                    ['value' => '1 cmd',  'label' => 'Full environment rebuild'],
                ],
                'stack' => ['Terraform', 'Docker', 'GitHub Actions', 'AWS', 'Grafana', 'Prometheus', 'Sentry'],
            ],
        ],
    ],
    [
        'slug'  => 'engagement',
        'title' => 'Engagement Models',
        'lead'  => 'When you need capacity rather than a project — senior engineers embedded in your team, under your process.',
        'icon'  => 'users',
        'items' => [
            [
                'slug'  => 'dedicated-engineering-team',
                'title' => 'Dedicated Engineering Team',
                'icon'  => 'users',
                'short' => 'A ring-fenced squad — engineers, QA and a tech lead — working only on your roadmap, in your rituals.',
                'lead'  => 'A dedicated team is not staff augmentation with a nicer name. It is a standing squad with its own lead, its own quality bar, and one backlog: yours.',
                'capabilities' => [
                    ['title' => 'Ring-fenced allocation', 'body' => 'The team works on your product and nothing else. No silent context-switching to whoever shouted loudest this week.'],
                    ['title' => 'Embedded rituals',       'body' => 'Your standups, your board, your definition of done. We adapt to your process rather than exporting ours.'],
                    ['title' => 'Technical leadership',   'body' => 'A lead who owns architecture decisions and code review, so quality does not depend on your CTO reviewing every pull request.'],
                    ['title' => 'Elastic composition',    'body' => 'Scale the squad up for a push and back down after, with a month of notice and no renegotiation.'],
                    ['title' => 'Knowledge retention',    'body' => 'Documentation and pairing built into the cadence, so team changes do not reset your institutional memory.'],
                    ['title' => 'Transparent reporting',  'body' => 'Velocity, cycle time and escaped-defect rate reported monthly, whether the numbers flatter us or not.'],
                ],
                'outcomes' => [
                    ['value' => '2 wks',  'label' => 'Typical time to a productive squad'],
                    ['value' => '100%',   'label' => 'Allocation to your backlog'],
                    ['value' => '30 days','label' => 'Notice to resize or exit'],
                ],
                'stack' => ['Python', 'React', 'React Native', 'PostgreSQL', 'AWS', 'Jira / Linear'],
            ],
            [
                'slug'  => 'on-demand-resources',
                'title' => 'Dedicated On-demand Resources',
                'icon'  => 'clock',
                'short' => 'Individual senior specialists — AI, backend, mobile, DevOps — booked by the month against a real gap in your team.',
                'lead'  => 'Sometimes the gap is one person-shaped: an ML engineer for a quarter, a DevOps specialist to clear the deployment backlog. This is that, without a twelve-month contract.',
                'capabilities' => [
                    ['title' => 'Specialist roles',      'body' => 'AI/ML engineers, Python backend, React and React Native, DevOps, and QA automation — vetted and available by the month.'],
                    ['title' => 'Direct reporting',      'body' => 'The resource reports into your lead and sits in your tooling. We handle contracts, cover and continuity in the background.'],
                    ['title' => 'Fast start',            'body' => 'Shortlist within a week, working within two — including access, environment setup and codebase onboarding.'],
                    ['title' => 'Overlap hours',         'body' => 'Guaranteed working-hour overlap with your timezone, agreed before start rather than negotiated after.'],
                    ['title' => 'Backfill guarantee',    'body' => 'If someone leaves, we cover the handover at our cost. Continuity is our problem, not yours.'],
                    ['title' => 'No lock-in',            'body' => 'Monthly rolling with thirty days notice. Hire the person directly if it works out — we will not stand in the way.'],
                ],
                'outcomes' => [
                    ['value' => '5 days', 'label' => 'To a vetted shortlist'],
                    ['value' => '4+ hrs', 'label' => 'Guaranteed timezone overlap'],
                    ['value' => 'Monthly','label' => 'Rolling commitment'],
                ],
                'stack' => ['Python', 'PyTorch', 'React', 'React Native', 'Terraform', 'Playwright'],
            ],
        ],
    ],
    [
        'slug'  => 'core',
        'title' => 'Core Services',
        'lead'  => 'The application engineering that everything else sits on — web, mobile, commerce and the fast proofs that de-risk them.',
        'icon'  => 'monitor',
        'items' => [
            [
                'slug'  => 'mobile-app-development',
                'title' => 'Mobile App Development',
                'icon'  => 'smartphone',
                'short' => 'Cross-platform apps in Flutter and React Native, shipped to both stores from one codebase and one team.',
                'lead'  => 'Two stores, one codebase, no compromise on the parts users actually feel — launch time, scroll performance and offline behaviour.',
                'capabilities' => [
                    ['title' => 'Flutter and React Native', 'body' => 'Chosen per project on real criteria — existing team skills, native module needs and animation load — not on preference.'],
                    ['title' => 'Offline-first data',       'body' => 'Local persistence with conflict-aware sync, so the app stays usable in a lift, a basement or rural coverage.'],
                    ['title' => 'Real-time features',       'body' => 'Live tracking, chat and presence over WebSockets, with battery-conscious location handling.'],
                    ['title' => 'Push and deep linking',    'body' => 'Segmented push notifications and deep links that survive cold start and land the user on the right screen.'],
                    ['title' => 'Store release management', 'body' => 'App Store and Play Console submission, staged rollouts, and the review-rejection cycle handled by people who have been through it.'],
                    ['title' => 'Crash and performance monitoring', 'body' => 'Sentry and store vitals wired from the first build, with a triage process rather than a dashboard nobody opens.'],
                ],
                'outcomes' => [
                    ['value' => '2 stores','label' => 'From a single codebase'],
                    ['value' => '<2s',     'label' => 'Cold start on mid-range devices'],
                    ['value' => 'Offline', 'label' => 'Core flows work without signal'],
                ],
                'stack' => ['Flutter', 'React Native', 'Python / FastAPI', 'Firebase', 'WebSockets', 'Sentry'],
            ],
            [
                'slug'  => 'flutter-app-development',
                'title' => 'Flutter App Development',
                'icon'  => 'smartphone',
                'short' => 'One Dart codebase shipped to iOS, Android, web and desktop — drawn by Flutter itself, so both stores look identical.',
                'lead'  => 'Flutter does not wrap each platform’s widgets, it draws every pixel through its own engine. That is why a Flutter app looks the same on both stores, animates at the display’s full refresh rate, and costs a fraction of building the same product twice.',
                'capabilities' => [
                    ['title' => 'Single Dart codebase',     'body' => 'iOS, Android, web and desktop from one source, with platform channels into Swift or Kotlin wherever a plugin does not already exist.'],
                    ['title' => 'Impeller rendering',       'body' => 'Flutter’s own renderer rather than a bridge to native widgets — predictable frame times, and no jank the first time an animation runs.'],
                    ['title' => 'State architecture',       'body' => 'Riverpod or BLoC chosen for the product rather than the fashion, with boundaries drawn so a screen can be tested without a device.'],
                    ['title' => 'Native integrations',      'body' => 'Camera, GPS, Bluetooth, biometrics, background tasks, push and in-app purchases, wired through platform channels and tested on real hardware.'],
                    ['title' => 'On-device intelligence',   'body' => 'TensorFlow Lite and Gemini Nano running inside the app, so inference survives a lost signal and the data never leaves the handset.'],
                    ['title' => 'Store release management', 'body' => 'One codebase produces both builds, so iOS and Android ship together — signing, data-safety declarations and the review cycle handled end to end.'],
                ],
                'outcomes' => [
                    ['value' => '1 codebase', 'label' => 'Two stores, plus web and desktop'],
                    ['value' => '120 FPS',    'label' => 'On displays that support it'],
                    ['value' => '30–50%',   'label' => 'Below the cost of two native builds'],
                ],
                'stack' => ['Flutter', 'Dart', 'Riverpod', 'BLoC', 'Firebase', 'Python / FastAPI', 'TensorFlow Lite'],
            ],
            [
                'slug'  => 'web-development',
                'title' => 'Web Development',
                'icon'  => 'globe',
                'short' => 'Fast, accessible, server-rendered web platforms that hold up under load and rank well without a plugin.',
                'lead'  => 'A web platform is judged on three things it cannot fake: how fast it loads, whether it works for everyone, and whether search engines can read it.',
                'capabilities' => [
                    ['title' => 'Performance budgets',   'body' => 'Core Web Vitals treated as a build-failing constraint, not a post-launch clean-up task.'],
                    ['title' => 'Accessibility',         'body' => 'WCAG 2.2 AA as the baseline — keyboard paths, focus management, contrast and screen-reader semantics tested, not assumed.'],
                    ['title' => 'Technical SEO',         'body' => 'Server-rendered markup, structured data, clean URLs and sitemaps built into the framework rather than bolted on.'],
                    ['title' => 'CMS integration',       'body' => 'Editing interfaces your marketing team can actually use, with preview and scheduled publishing.'],
                    ['title' => 'Design system',         'body' => 'A documented component library with tokens, so the tenth page costs a fraction of the first.'],
                    ['title' => 'Analytics and consent', 'body' => 'Privacy-respecting analytics with a consent layer that satisfies GDPR without wrecking your data.'],
                ],
                'outcomes' => [
                    ['value' => '90+',    'label' => 'Lighthouse performance target'],
                    ['value' => 'WCAG AA','label' => 'Accessibility baseline'],
                    ['value' => 'SSR',    'label' => 'Rendered for search engines'],
                ],
                'stack' => ['Python', 'Django', 'PHP', 'React', 'PostgreSQL', 'Nginx', 'Cloudflare'],
            ],
            [
                'slug'  => 'ecommerce-development',
                'title' => 'E-commerce Development',
                'icon'  => 'cart',
                'short' => 'Storefronts and checkout flows engineered around conversion, with the operational back office to match.',
                'lead'  => 'The storefront is the easy half. What decides whether an e-commerce business works is checkout completion, inventory truth and how returns are handled.',
                'capabilities' => [
                    ['title' => 'Checkout optimisation',  'body' => 'Fewer steps, saved addresses, wallet support and honest shipping costs shown before the final screen.'],
                    ['title' => 'Payments and wallets',   'body' => 'Razorpay, Stripe, UPI and COD reconciliation, with webhook-driven order state that survives a failed callback.'],
                    ['title' => 'Inventory and OMS',      'body' => 'Real stock counts across channels, with reservation logic that prevents overselling during a spike.'],
                    ['title' => 'Catalogue and merchandising', 'body' => 'Variant modelling, faceted search and merchandising rules your team controls without a developer.'],
                    ['title' => 'Returns and support',    'body' => 'Self-serve returns wired to the OMS, because the returns process is where repeat custom is won or lost.'],
                    ['title' => 'Headless or platform',   'body' => 'Shopify, WooCommerce or a custom Python stack — chosen on your margin structure and catalogue complexity.'],
                ],
                'outcomes' => [
                    ['value' => '28%',  'label' => 'Return-rate reduction delivered'],
                    ['value' => 'Multi','label' => 'Channel inventory kept in sync'],
                    ['value' => 'UPI+', 'label' => 'Full Indian payments coverage'],
                ],
                'stack' => ['Python', 'Django', 'Shopify', 'WooCommerce', 'Razorpay', 'React', 'OpenSearch'],
            ],
            [
                'slug'  => 'reactjs-development',
                'title' => 'React JS Development',
                'icon'  => 'code',
                'short' => 'Complex front-ends — dashboards, consoles and data-dense interfaces — built to stay maintainable past year one.',
                'lead'  => 'React makes it easy to start and easy to make a mess. The work is in the state model, the component boundaries and the render discipline that keep a large app fast.',
                'capabilities' => [
                    ['title' => 'State architecture',    'body' => 'Server state, client state and form state handled by tools suited to each, instead of one global store carrying everything.'],
                    ['title' => 'Data-dense interfaces', 'body' => 'Virtualised tables, live charts and multi-pane consoles that stay smooth at tens of thousands of rows.'],
                    ['title' => 'Design system build',   'body' => 'Token-driven component libraries with Storybook documentation and visual regression tests.'],
                    ['title' => 'Type safety',           'body' => 'TypeScript end to end, with API types generated from the backend schema so contract drift breaks the build.'],
                    ['title' => 'Testing strategy',      'body' => 'Component tests where logic lives and Playwright journeys over the paths that generate revenue.'],
                    ['title' => 'Render performance',    'body' => 'Profiling-led optimisation — memoisation, code splitting and suspense boundaries applied where the flame graph says, not everywhere.'],
                ],
                'outcomes' => [
                    ['value' => '60fps','label' => 'On data-dense views'],
                    ['value' => '100%', 'label' => 'TypeScript coverage'],
                    ['value' => 'Auto', 'label' => 'API types generated from schema'],
                ],
                'stack' => ['React', 'TypeScript', 'TanStack Query', 'Vite', 'Storybook', 'Playwright'],
            ],
            [
                'slug'  => 'poc-development',
                'title' => 'POC Development',
                'icon'  => 'lightbulb',
                'short' => 'A focused two-to-four week proof that answers one technical question before you commit a budget to it.',
                'lead'  => 'A proof of concept exists to kill or confirm an assumption cheaply. It has one question, one success criterion, and a deadline — and it is allowed to fail.',
                'capabilities' => [
                    ['title' => 'One question, defined', 'body' => 'We write down the single question and the numeric threshold that counts as a yes, before starting.'],
                    ['title' => 'Model and data probing','body' => 'Fastest possible test of whether your data supports the outcome — usually the real risk in an AI proposal.'],
                    ['title' => 'Throwaway by design',   'body' => 'Built for speed, not longevity, and labelled as such. Nobody gets pressured to ship the prototype.'],
                    ['title' => 'Honest reporting',      'body' => 'A written result including the negative case. A well-run POC that says no has done its job and saved you a quarter.'],
                    ['title' => 'Cost and latency modelling', 'body' => 'Projected unit economics at your real volume, so a technically viable idea does not become a commercially dead one later.'],
                    ['title' => 'Production roadmap',    'body' => 'If the answer is yes, you get the architecture and estimate for the real build in the same document.'],
                ],
                'outcomes' => [
                    ['value' => '2-4 wks','label' => 'Fixed duration'],
                    ['value' => '1',      'label' => 'Question answered definitively'],
                    ['value' => 'Fixed',  'label' => 'Price agreed up front'],
                ],
                'stack' => ['Python', 'Jupyter', 'FastAPI', 'PyTorch', 'Streamlit', 'Docker'],
            ],
            [
                'slug'  => 'mvp-development',
                'title' => 'MVP Development',
                'icon'  => 'rocket',
                'short' => 'The smallest complete product that can win a real customer — built properly enough to keep after it works.',
                'lead'  => 'An MVP is not a demo. It takes real users, real data and real money — and the code survives the first hundred customers rather than being thrown away at fifty.',
                'capabilities' => [
                    ['title' => 'Scope negotiation',    'body' => 'A hard conversation about what is genuinely required for launch, and a written list of what is explicitly not in v1.'],
                    ['title' => 'Complete core loop',   'body' => 'One user journey working end to end — signup through to the moment value is delivered — rather than five half-built ones.'],
                    ['title' => 'Production hygiene',   'body' => 'Auth, backups, error tracking and deploy automation from the first release. These are cheap now and expensive later.'],
                    ['title' => 'Instrumentation',      'body' => 'Activation and retention tracked from day one, so post-launch decisions come from data rather than the loudest opinion.'],
                    ['title' => 'Launch support',       'body' => 'Fast-turnaround fixes through the first weeks live, when the real bugs surface.'],
                    ['title' => 'A scalable base',      'body' => 'Architecture chosen so v2 is an extension, not a rewrite — the single most common MVP failure.'],
                ],
                'outcomes' => [
                    ['value' => '8-12 wks','label' => 'Concept to live product'],
                    ['value' => 'Day 1',   'label' => 'Analytics and error tracking live'],
                    ['value' => 'No',      'label' => 'Rewrite needed for v2'],
                ],
                'stack' => ['Python', 'FastAPI / Django', 'React', 'React Native', 'PostgreSQL', 'Stripe', 'AWS'],
            ],
        ],
    ],
];

// ---------------------------------------------------------------------------
// Proprietary AI products
// ---------------------------------------------------------------------------

const AI_SOLUTIONS = [
    [
        'slug'    => 'ithrive-insights',
        'name'    => 'iThrive Insights',
        'icon'    => 'bar-chart',
        'accent'  => 'cyan',
        'tagline' => 'Turn scattered marketing and operational data into growth-driving AI decisions.',
        'short'   => 'Your ad platforms, CRM, storefront and finance data unified into one model — then read by an agent that tells you what to change this week.',
        'lead'    => 'Most businesses do not have a data problem, they have a seventeen-dashboard problem. iThrive Insights collapses those into one semantic model and puts an analyst agent on top of it.',
        'features' => [
            ['icon' => 'database',    'photo' => 'insights-01', 'title' => 'Unified data model',      'body' => 'Connectors for Google Ads, Meta, GA4, HubSpot, Shopify, Razorpay and your own Postgres, resolved into one consistent set of entities and metrics.'],
            ['icon' => 'brain',       'photo' => 'insights-02', 'title' => 'Analyst agent',           'body' => 'Ask in plain language, get an answer with the SQL it ran and the assumptions it made. Every figure traces back to a source row.'],
            ['icon' => 'trending-up', 'photo' => 'insights-03', 'title' => 'Attribution modelling',   'body' => 'Multi-touch attribution across paid, organic and direct, so budget decisions rest on contribution rather than last-click.'],
            ['icon' => 'zap',         'photo' => 'insights-04', 'title' => 'Anomaly detection',       'body' => 'Continuous monitoring on every key metric, alerting on a genuine break in pattern instead of ordinary weekly noise.'],
            ['icon' => 'target',      'photo' => 'insights-05', 'title' => 'Recommended actions',     'body' => 'Weekly ranked recommendations — shift this budget, pause that campaign, restock this SKU — each with the expected effect stated.'],
            ['icon' => 'users',       'photo' => 'insights-06', 'title' => 'Cohort intelligence',     'body' => 'Automatic customer segmentation by behaviour and value, with churn risk scored per cohort.'],
        ],
        'metrics' => [
            ['value' => '17→1', 'label' => 'Dashboards replaced'],
            ['value' => '<30s', 'label' => 'Question to sourced answer'],
            ['value' => 'Weekly','label' => 'Ranked action list delivered'],
        ],
        'stack' => ['Python', 'dbt', 'DuckDB', 'PostgreSQL', 'LangGraph', 'React'],
    ],
    [
        'slug'    => 'ithrive-aichat',
        'name'    => 'iThrive AIChat',
        'icon'    => 'message',
        'accent'  => 'purple',
        'tagline' => 'Turn every website visitor into a paying customer with real-time intent mapping.',
        'short'   => 'A site assistant that reads buying intent live, answers from your own content, and routes a genuinely hot lead to a human before they leave.',
        'lead'    => 'A chat widget that answers questions is a support tool. iThrive AIChat scores intent on every message and changes its own objective — inform, qualify, or hand over — based on what the visitor is actually doing.',
        'features' => [
            ['icon' => 'target',   'photo' => 'aichat-01', 'title' => 'Real-time intent mapping', 'body' => 'Every message and page event feeds a live intent score, separating a researcher from a buyer inside the first two exchanges.'],
            ['icon' => 'search',   'photo' => 'aichat-02', 'title' => 'Grounded answers',         'body' => 'Responses drawn from your own site, docs and pricing with citations — and an honest "I do not know" rather than an invented answer.'],
            ['icon' => 'workflow', 'photo' => 'aichat-03', 'title' => 'Qualification flows',      'body' => 'Your qualification criteria encoded as agent objectives, gathering budget, timeline and authority conversationally.'],
            ['icon' => 'phone',    'photo' => 'aichat-04', 'title' => 'Live handover',            'body' => 'High-intent conversations escalate to a human in Slack or your CRM with the full transcript and score attached.'],
            ['icon' => 'calendar', 'photo' => 'aichat-05', 'title' => 'Direct booking',           'body' => 'Calendar integration so a qualified visitor books the call inside the chat rather than being sent to a form.'],
            ['icon' => 'shield',   'photo' => 'aichat-06', 'title' => 'Guardrails',               'body' => 'Topic boundaries, prompt-injection filtering and a full audit log of every conversation the agent has had.'],
        ],
        'metrics' => [
            ['value' => '2 msgs','label' => 'To a reliable intent score'],
            ['value' => '24/7',  'label' => 'Qualified lead capture'],
            ['value' => '100%',  'label' => 'Answers cited to source'],
        ],
        'stack' => ['Python', 'FastAPI', 'LangGraph', 'pgvector', 'WebSockets', 'React'],
    ],
];

// ---------------------------------------------------------------------------
// Case studies
// ---------------------------------------------------------------------------

/** Filter tabs on /case-studies. `all` is prepended by the template. */
const CASE_FILTERS = [
    'ai-apps'       => 'AI Apps',
    'web-platforms' => 'Web Platforms',
    'mobile'        => 'Mobile',
    'ecommerce'     => 'E-commerce',
    'enterprise-erp'=> 'Enterprise ERP',
];

const CASE_STUDIES = [
    [
        'slug'      => 'tada-taxi-app',
        'client'    => 'Tada',
        'title'     => 'Tada Taxi App',
        'headline'  => 'AI dispatch that cut rider wait times by 40%',
        'url'       => 'https://tada.global/',
        'industry'  => 'On-Demand Transportation & Mobility',
        'icon'      => 'car',
        'accent'    => '#FFC400',
        'logo'      => 'tada-taxi-app.png',
        'mock'      => 'mobile',
        'featured'  => true,
        'categories'=> ['mobile', 'ai-apps'],
        'summary'   => 'A real-time AI ride-hailing platform with predictive surge pricing, optimal driver dispatch and dynamic route optimisation.',
        'challenge' => 'Inefficient rider-driver matching leading to high wait times and revenue leaks. Dispatch was effectively nearest-available, which stranded drivers in low-demand pockets and left riders in dense zones waiting through repeated declines.',
        'solution'  => 'We developed a real-time AI-powered ride-hailing mobile application built on Python backend logic, with custom algorithms for predictive surge pricing, optimal driver dispatching and dynamic route optimisation. Dispatch scores every candidate driver against ETA, acceptance likelihood and post-trip repositioning value rather than raw distance.',
        'value'     => 'Bridged the gap between customer and ride provider, cutting wait times by 40% and optimising driver payouts.',
        'metrics'   => [
            ['value' => '40%',  'label' => 'Lower average rider wait'],
            ['value' => '<1s',  'label' => 'Dispatch decision latency'],
            ['value' => '24/7', 'label' => 'Live fleet optimisation'],
        ],
        'features'  => [
            ['icon' => 'pin',         'title' => 'Live tracking',        'body' => 'Sub-second driver position streaming over WebSockets with battery-aware location sampling on the driver app.'],
            ['icon' => 'brain',       'title' => 'AI dispatch',          'body' => 'Every request scored across the available fleet on ETA, historical acceptance rate and repositioning value.'],
            ['icon' => 'trending-up', 'title' => 'Predictive surge',     'body' => 'Demand forecast per zone on a fifteen-minute horizon, so pricing moves before the shortage rather than after it.'],
            ['icon' => 'compass',     'title' => 'Route optimisation',   'body' => 'Continuous re-routing against live traffic, with driver-facing turn guidance and accurate rider ETAs.'],
            ['icon' => 'gauge',       'title' => 'Driver earnings view', 'body' => 'Transparent per-trip breakdown and heat maps showing where the next fare is most likely to come from.'],
            ['icon' => 'shield',      'title' => 'Trip safety',          'body' => 'Share-trip links, SOS escalation and anomaly detection on route deviation.'],
        ],
        'stack'     => ['Python', 'FastAPI', 'PostgreSQL + PostGIS', 'Redis', 'WebSockets', 'React Native', 'AWS'],
        'screens'   => ['Rider booking', 'Live trip tracking', 'Driver dispatch queue', 'Earnings dashboard'],
        'badges'    => ['play', 'web'],
    ],
    [
        'slug'      => 'toing-food-delivery',
        'client'    => 'Toing',
        'title'     => 'Toing — Food Delivery App',
        'headline'  => 'Personalised ordering that lifted repeat orders 35%',
        'url'       => 'https://www.toingit.com/',
        'industry'  => 'On-Demand Food & Quick Commerce',
        'icon'      => 'utensils',
        'accent'    => '#FF4FD8',
        'logo'      => 'toing-food-delivery.png',
        'mock'      => 'mobile',
        'featured'  => true,
        'categories'=> ['mobile', 'ai-apps'],
        'summary'   => 'A full-stack AI food delivery app with a habit-based recommendation engine and dynamic delivery route assignment.',
        'challenge' => 'Order delays and a lack of personalised restaurant recommendations. Every user saw the same ranked list regardless of order history, and delivery assignment ignored kitchen preparation time — so riders queued at restaurants while food went cold elsewhere.',
        'solution'  => 'We engineered a full-stack AI food delivery mobile app in Python, implementing intelligent recommendation engines based on user ordering habits and dynamic delivery route assignment. Rider allocation is timed against predicted kitchen-ready time rather than order placement, and batching only groups orders whose routes genuinely overlap.',
        'value'     => 'Streamlined logistics between restaurants, drivers and consumers, boosting repeat order rate by 35%.',
        'metrics'   => [
            ['value' => '35%',  'label' => 'Higher repeat order rate'],
            ['value' => '~9min','label' => 'Cut from average delivery time'],
            ['value' => '3x',   'label' => 'Order batching efficiency'],
        ],
        'features'  => [
            ['icon' => 'sparkles',  'title' => 'Habit-based recommendations', 'body' => 'Ranking trained on each user\'s ordering history, time of day and repeat behaviour instead of a global popularity list.'],
            ['icon' => 'clock',     'title' => 'Kitchen-time prediction',     'body' => 'Per-restaurant, per-dish preparation forecasting that drives when a rider is dispatched.'],
            ['icon' => 'compass',   'title' => 'Dynamic route assignment',    'body' => 'Live batching and sequencing across active riders, re-optimised as new orders land.'],
            ['icon' => 'monitor',   'title' => 'Partner dashboard',           'body' => 'Restaurant-side console for menu, availability, prep-time tuning and settlement visibility.'],
            ['icon' => 'pin',       'title' => 'Order tracking',              'body' => 'Live map from kitchen acceptance to doorstep, with honest ETA updates rather than a fixed countdown.'],
            ['icon' => 'cart',      'title' => 'Quick commerce mode',         'body' => 'Separate fulfilment path for grocery and convenience orders with different batching rules.'],
        ],
        'stack'     => ['Python', 'Django', 'Celery', 'PostgreSQL', 'Redis', 'Flutter', 'Firebase'],
        'screens'   => ['Personalised feed', 'Order tracking', 'Restaurant console', 'Rider batching view'],
        'badges'    => ['play', 'app', 'web'],
    ],
    [
        'slug'      => 'urimai-kural',
        'client'    => 'Urimai Kural',
        'title'     => 'Urimai Kural App',
        'headline'  => 'Auto-routing citizen grievances to the right officer',
        'url'       => 'https://www.urimaikural.in/admin/login.php',
        'industry'  => 'Civic Tech & Community Grievance Management',
        'icon'      => 'building',
        'accent'    => '#F5C518',
        'logo'      => 'urimai-kural.png',
        'mock'      => 'both',
        'featured'  => true,
        'categories'=> ['web-platforms', 'ai-apps'],
        'summary'   => 'An AI-driven public management platform that categorises incoming voice and text grievances and routes them to the responsible officer.',
        'challenge' => 'Complex manual administrative workflows delaying citizen request resolutions. Every grievance arrived as free text or a voice note, was read by a clerk, and was forwarded by hand — so routing errors were common and nothing was measurable.',
        'solution'  => 'We built an AI-driven public management app and admin engine in Python that systematically analyses, auto-categorises and routes incoming public voice and text requests to the relevant officer. Tamil and English voice notes are transcribed, classified by department and urgency, deduplicated against existing open cases, and assigned with an SLA clock attached.',
        'value'     => 'Resolved administrative delays by closing the communication gap between citizens and service providers.',
        'metrics'   => [
            ['value' => 'Auto',  'label' => 'Categorisation and routing'],
            ['value' => '2 langs','label' => 'Tamil and English voice intake'],
            ['value' => 'SLA',   'label' => 'Clock on every open case'],
        ],
        'features'  => [
            ['icon' => 'message',   'title' => 'Voice and text intake',   'body' => 'Citizens submit in Tamil or English by voice note or text; transcription and normalisation happen server-side.'],
            ['icon' => 'workflow',  'title' => 'Auto-categorisation',     'body' => 'Department, category and urgency classified on submission, with low-confidence cases flagged for human review.'],
            ['icon' => 'users',     'title' => 'Officer routing',         'body' => 'Assignment by jurisdiction and department, with escalation when an SLA is about to breach.'],
            ['icon' => 'bar-chart', 'title' => 'Analytics dashboard',     'body' => 'Volume, resolution time and backlog by ward and department — the first time this data existed at all.'],
            ['icon' => 'smartphone','title' => 'Citizen app',             'body' => 'Case status, officer response and reopen flow, so a citizen is never left guessing.'],
            ['icon' => 'shield',    'title' => 'Audit trail',             'body' => 'Every status change, reassignment and comment logged immutably for accountability review.'],
        ],
        'stack'     => ['Python', 'Django', 'PostgreSQL', 'Whisper', 'Celery', 'React', 'PHP admin bridge'],
        'screens'   => ['Admin case queue', 'Ward analytics', 'Citizen app view', 'Officer assignment'],
        'badges'    => ['web', 'play'],
    ],
    [
        'slug'      => 'de-drone-world',
        'client'    => 'DE Drone World',
        'title'     => 'DE Drone World',
        'headline'  => 'Automated admissions and contracts for a drone academy',
        'url'       => 'https://thedroneworld.in/',
        'industry'  => 'EdTech, Drone Technology & Aerospace Training',
        'icon'      => 'drone',
        'accent'    => '#4FA3D1',
        'logo'      => 'de-drone-world.png',
        'mock'      => 'desktop',
        'featured'  => true,
        'categories'=> ['web-platforms'],
        'summary'   => 'An intelligent web platform automating drone pilot course admissions, contract lifecycle management and commercial service booking.',
        'challenge' => 'Friction in student admissions, course enrolments and commercial drone service contracts. Admissions ran on email and spreadsheets, DGCA documentation was chased manually, and every commercial quote was drafted from scratch.',
        'solution'  => 'We developed an intelligent web platform with Python automated workflows for drone pilot course admissions, contract lifecycle management and service booking. Applicants upload documents once, validation and eligibility checks run automatically, and cohort seats are allocated by rule rather than by inbox order.',
        'value'     => 'Eliminated operational manual work and filled the gap between drone service seekers, students and the academy.',
        'metrics'   => [
            ['value' => 'Auto', 'label' => 'Eligibility and document checks'],
            ['value' => 'Rule', 'label' => 'Based cohort seat allocation'],
            ['value' => 'One',  'label' => 'System for training and services'],
        ],
        'features'  => [
            ['icon' => 'workflow',  'title' => 'Admissions pipeline',     'body' => 'Application, document upload, verification, payment and seat allocation as one automated flow with status visible to the applicant.'],
            ['icon' => 'shield',    'title' => 'Document validation',     'body' => 'Automated checks on identity, medical and eligibility documents, with exceptions routed to an administrator.'],
            ['icon' => 'package',   'title' => 'Contract lifecycle',      'body' => 'Templated commercial contracts generated from quote parameters, tracked through approval, signature and renewal.'],
            ['icon' => 'calendar',  'title' => 'Service booking',         'body' => 'Commercial drone survey and mapping jobs booked against pilot and equipment availability.'],
            ['icon' => 'monitor',   'title' => 'Course delivery',         'body' => 'Cohort scheduling, attendance, assessment records and certification issuance in one place.'],
            ['icon' => 'bar-chart', 'title' => 'Operations reporting',    'body' => 'Enrolment funnel, cohort utilisation and commercial pipeline reported without a spreadsheet export.'],
        ],
        'stack'     => ['Python', 'Django', 'PostgreSQL', 'Celery', 'React', 'AWS S3', 'Razorpay'],
        'screens'   => ['Admissions dashboard', 'Contract generator', 'Cohort scheduler', 'Service booking'],
        'badges'    => ['web'],
    ],
    [
        'slug'      => 'central-adventures',
        'client'    => 'Central Adventures',
        'title'     => 'Central Adventures & Holidays',
        'headline'  => 'Auto-generated group tour itineraries and quotes',
        'url'       => 'https://centraladventures.in/',
        'industry'  => 'Tourism, Group Travel & Educational Tours',
        'icon'      => 'plane',
        'accent'    => '#2DD4A7',
        'logo'      => 'central-adventures.png',
        'mock'      => 'desktop',
        'featured'  => false,
        'categories'=> ['web-platforms', 'ai-apps'],
        'summary'   => 'An interactive portal that builds tailored educational-tour itineraries and priced quotes for schools and colleges automatically.',
        'challenge' => 'Schools and colleges struggled to get custom quotes and manage large group tour bookings seamlessly. Each enquiry meant a manual itinerary draft and a pricing spreadsheet, so response took days and the quote often arrived after the institution had decided.',
        'solution'  => 'We architected an interactive web portal powered by Python AI tools that automatically generates tailored travel itineraries and quotes for educational institutions. Group size, age band, budget and learning objectives drive itinerary assembly from a structured inventory of destinations, transport and accommodation, with live pricing and margin rules applied.',
        'value'     => 'Direct connection between academic institutions and tourism planners, scaling group booking conversions by 50%.',
        'metrics'   => [
            ['value' => '50%',   'label' => 'More group bookings converted'],
            ['value' => 'Minutes','label' => 'Enquiry to priced itinerary'],
            ['value' => 'Live',  'label' => 'Margin-aware quote pricing'],
        ],
        'features'  => [
            ['icon' => 'sparkles',  'title' => 'Itinerary generation',  'body' => 'Day-by-day plans assembled from destination inventory against group size, age band, duration and stated learning objectives.'],
            ['icon' => 'bar-chart', 'title' => 'Dynamic quoting',       'body' => 'Transport, accommodation and entry costs priced live with margin rules, producing an institution-ready PDF.'],
            ['icon' => 'users',     'title' => 'Group management',      'body' => 'Participant rosters, consent forms, dietary and medical notes collected through a shareable coordinator link.'],
            ['icon' => 'calendar',  'title' => 'Availability engine',   'body' => 'Real-time checks against coach, guide and accommodation capacity before a quote is issued.'],
            ['icon' => 'globe',     'title' => 'Destination library',   'body' => 'Structured content per destination — activities, duration, safety notes and curriculum links.'],
            ['icon' => 'workflow',  'title' => 'Booking pipeline',      'body' => 'Enquiry through quote, approval, deposit and final payment tracked as a single visible pipeline.'],
        ],
        'stack'     => ['Python', 'Django', 'PostgreSQL', 'WeasyPrint', 'React', 'Razorpay'],
        'screens'   => ['Itinerary builder', 'Quote generator', 'Group roster', 'Booking pipeline'],
        'badges'    => ['web'],
    ],
    [
        'slug'      => 'cute-crew',
        'client'    => 'Cute Crew',
        'title'     => 'Cute Crew — Kids E-Commerce',
        'headline'  => 'A fit engine that cut returns by 28%',
        'url'       => 'https://cute-crew.vercel.app/',
        'industry'  => 'E-Commerce / Children\'s Fashion',
        'icon'      => 'shirt',
        'accent'    => '#FF5A4E',
        'logo'      => 'cute-crew.png',
        'mock'      => 'both',
        'featured'  => true,
        'categories'=> ['ecommerce', 'ai-apps'],
        'summary'   => 'A kids fashion storefront with an AI right-fit and age recommendation engine built to attack the return rate directly.',
        'challenge' => 'Parents struggled to select exact clothing sizes and suitable fabrics for growing kids online. Size labels vary wildly between brands, children grow between order and delivery, and the result was a return rate that ate the category margin.',
        'solution'  => 'We built a custom AI-driven e-commerce web application in Python featuring an intelligent Right-Fit & Age Recommendation Engine. It combines the child\'s age, height and weight with garment measurements and historical return reasons per SKU to recommend a size and flag fabric suitability for the season.',
        'value'     => 'Solved size confusion, reduced product returns by 28%, and created a smooth shopping journey from seller to buyer.',
        'metrics'   => [
            ['value' => '28%',   'label' => 'Fewer product returns'],
            ['value' => 'Per-SKU','label' => 'Fit model, not a global chart'],
            ['value' => 'Multi', 'label' => 'Child profiles per account'],
        ],
        'features'  => [
            ['icon' => 'target',   'title' => 'Right-fit engine',       'body' => 'Size recommendation from child measurements against per-SKU garment data and that SKU\'s historical return reasons.'],
            ['icon' => 'users',    'title' => 'Child profiles',         'body' => 'Multiple children per account with growth tracked over time, so recommendations improve with each order.'],
            ['icon' => 'sparkles', 'title' => 'Fabric guidance',        'body' => 'Season and skin-sensitivity guidance surfaced at the point of choice rather than buried in the description.'],
            ['icon' => 'cart',     'title' => 'Streamlined checkout',   'body' => 'Saved addresses, wallet and UPI support, and honest delivery estimates before the payment screen.'],
            ['icon' => 'refresh',  'title' => 'Self-serve returns',     'body' => 'Reason-coded returns that feed straight back into the fit model as training signal.'],
            ['icon' => 'search',   'title' => 'Semantic search',        'body' => 'Natural-language catalogue search that handles "warm outfit for a two year old" properly.'],
        ],
        'stack'     => ['Python', 'FastAPI', 'PostgreSQL', 'scikit-learn', 'Next.js', 'Razorpay', 'Vercel'],
        'screens'   => ['Storefront', 'Fit recommender modal', 'Child profile', 'Cart and checkout'],
        'badges'    => ['web'],
    ],
    [
        'slug'      => 'lotus-eye-hospital',
        'client'    => 'Lotus Eye Hospital',
        'title'     => 'Lotus Eye Hospital — Agentic Healthcare Platform',
        'headline'  => 'An autonomous agent running the full patient journey',
        'url'       => 'https://www.lotuseye.org/',
        'industry'  => 'Healthcare & Telemedicine',
        'icon'      => 'stethoscope',
        'accent'    => '#35B7E8',
        'logo'      => 'lotus-eye-hospital.png',
        'mock'      => 'both',
        'featured'  => true,
        'categories'=> ['ai-apps', 'web-platforms'],
        'summary'   => 'A Practo-class agentic platform with AI scribe, EMR, automated billing, pharmacy dispatch and video consultation.',
        'challenge' => 'Overwhelmed front-desk staff, missed appointments and fragmented patient record tracking. Scheduling, records, billing and pharmacy each lived in a separate system, so every patient interaction required a human to reconcile them.',
        'solution'  => 'We built a Practo-like Agentic AI Platform powered by Python, with scribe capabilities. The autonomous agent handles appointment scheduling, doctor availability checks, electronic medical records, automated billing, pharmacy dispatch and video consultations — acting across all four systems rather than sitting beside them, with clinical decisions always left to the clinician.',
        'value'     => 'Automated the end-to-end patient care journey, enabling on-time appointments and instant record accessibility for doctors and patients.',
        'metrics'   => [
            ['value' => 'End-to-end','label' => 'Patient journey automated'],
            ['value' => 'Live',      'label' => 'AI scribe during consultation'],
            ['value' => 'Instant',   'label' => 'Record access for clinicians'],
        ],
        'features'  => [
            ['icon' => 'bot',        'title' => 'Scheduling agent',      'body' => 'Books, reschedules and confirms appointments against live doctor availability, handling the follow-up chase autonomously.'],
            ['icon' => 'message',    'title' => 'AI scribe',             'body' => 'Consultation transcribed and structured into a draft clinical note, presented to the doctor for review and sign-off — never filed unsupervised.'],
            ['icon' => 'database',   'title' => 'Unified EMR',           'body' => 'One patient record spanning visits, prescriptions, imaging and billing, accessible in a single click from the consultation view.'],
            ['icon' => 'monitor',    'title' => 'Video consultation',    'body' => 'In-platform teleconsultation with the record open alongside and prescription issued at the end of the call.'],
            ['icon' => 'package',    'title' => 'Pharmacy dispatch',     'body' => 'Prescriptions routed to the in-house pharmacy with stock check, preparation and dispatch tracking.'],
            ['icon' => 'bar-chart',  'title' => 'Automated billing',     'body' => 'Charges assembled from the encounter itself, with insurance and package rules applied before the patient reaches the counter.'],
        ],
        'stack'     => ['Python', 'FastAPI', 'LangGraph', 'PostgreSQL', 'Whisper', 'WebRTC', 'React', 'AWS'],
        'screens'   => ['Clinician dashboard', 'AI scribe transcript', 'Video consultation', 'Pharmacy dispatch'],
        'badges'    => ['web', 'play', 'app'],
    ],
    [
        'slug'      => 'coonoor-club',
        'client'    => 'Coonoor Club',
        'title'     => 'Coonoor Club — Heritage Club Management',
        'headline'  => 'Member wallets, bookings and renewals, all online',
        'url'       => 'https://www.coonoorclub.com/',
        'industry'  => 'Hospitality & Private Club Management',
        'icon'      => 'building',
        'accent'    => '#C9A227',
        'logo'      => 'coonoor-club.png',
        'mock'      => 'desktop',
        'featured'  => false,
        'categories'=> ['web-platforms'],
        'summary'   => 'A member portal with wallet recharge, room, table and bar booking, and automated membership renewal tracking.',
        'challenge' => 'Friction in offline bar, room and dining table reservations for members, alongside membership renewal tracking. Bookings were taken by phone into a paper register, wallet balances were reconciled by hand, and renewals were chased individually.',
        'solution'  => 'We developed a full-featured web portal with member login, admin panel, a dynamic wallet recharge system and an online room, table and bar booking engine powered by Python backend services. Member wallets settle against consumption in real time, and renewals run on an automated reminder and payment schedule.',
        'value'     => 'Connected club administration with members, enabling automated wallet renewals and hassle-free amenity bookings.',
        'metrics'   => [
            ['value' => 'Real-time','label' => 'Wallet balance and settlement'],
            ['value' => '3',        'label' => 'Booking types in one engine'],
            ['value' => 'Auto',     'label' => 'Renewal reminders and payment'],
        ],
        'features'  => [
            ['icon' => 'users',    'title' => 'Member portal',        'body' => 'Login, profile, dependants, wallet balance and complete consumption history in one view.'],
            ['icon' => 'zap',      'title' => 'Wallet recharge',      'body' => 'Online top-up with auto-recharge thresholds and instant settlement against bar and dining consumption.'],
            ['icon' => 'calendar', 'title' => 'Booking engine',       'body' => 'Rooms, dining tables and bar seating booked against live availability with club-specific rules and blackout dates.'],
            ['icon' => 'refresh',  'title' => 'Membership renewals',  'body' => 'Automated reminder schedule, online payment and lapse handling without administrator chasing.'],
            ['icon' => 'monitor',  'title' => 'Admin console',        'body' => 'Occupancy, consumption, outstanding balances and member records managed from one back office.'],
            ['icon' => 'bar-chart','title' => 'Club reporting',       'body' => 'Revenue by amenity, member activity and outstanding dues reported for the committee on schedule.'],
        ],
        'stack'     => ['Python', 'Django', 'PostgreSQL', 'Razorpay', 'React', 'Nginx'],
        'screens'   => ['Member dashboard', 'Wallet recharge', 'Room booking calendar', 'Admin console'],
        'badges'    => ['web'],
    ],
    [
        'slug'      => 'jaumo',
        'client'    => 'Jaumo',
        'title'     => 'Jaumo — Next-Gen Dating Application',
        'headline'  => 'Compatibility matching over surface-level swiping',
        'url'       => 'https://www.jaumo.com/en',
        'industry'  => 'Social Networking & Matchmaking',
        'icon'      => 'heart',
        'accent'    => '#FF8045',
        'logo'      => 'jaumo.svg',
        'mock'      => 'mobile',
        'featured'  => false,
        'categories'=> ['mobile', 'ai-apps'],
        'summary'   => 'A feature-rich dating app with Python personality-matching algorithms and a Blind Date mode built on behavioural compatibility.',
        'challenge' => 'Traditional superficial matching leads to low conversation quality. Photo-first ranking produced plenty of matches and very few conversations that survived past the third message.',
        'solution'  => 'We built a feature-rich mobile app integrating Python AI personality-matching algorithms and a Blind Date feature that pairs users on deep psychological and behavioural compatibility. Compatibility is scored from an onboarding inventory plus observed in-app behaviour, and Blind Date reveals photos only after a conversation has genuinely started.',
        'value'     => 'Enhanced user engagement and created meaningful dates by bridging the gap between like-minded individuals.',
        'metrics'   => [
            ['value' => 'Behavioural','label' => 'Signals beyond the profile'],
            ['value' => 'Blind',      'label' => 'Date mode, photos revealed later'],
            ['value' => 'Live',       'label' => 'Compatibility re-scoring'],
        ],
        'features'  => [
            ['icon' => 'brain',    'title' => 'Personality matching', 'body' => 'Compatibility scored from an onboarding inventory and refined continuously by observed in-app behaviour.'],
            ['icon' => 'heart',    'title' => 'Blind Date mode',      'body' => 'Photos stay hidden until a conversation reaches a genuine exchange threshold, inverting the usual order.'],
            ['icon' => 'message',  'title' => 'Conversation quality', 'body' => 'Prompts and icebreakers generated from shared traits, with quality signals feeding back into ranking.'],
            ['icon' => 'bar-chart','title' => 'Compatibility graph',  'body' => 'A readable breakdown of why two people were matched, across values, interests and interaction style.'],
            ['icon' => 'shield',   'title' => 'Safety and moderation','body' => 'Photo verification, automated abuse detection, blocking and reporting flows built in from launch.'],
            ['icon' => 'zap',      'title' => 'Real-time chat',       'body' => 'Low-latency messaging with presence, typing indicators, media sharing and delivery state.'],
        ],
        'stack'     => ['Python', 'FastAPI', 'PostgreSQL', 'Redis', 'scikit-learn', 'React Native', 'WebSockets'],
        'screens'   => ['Discovery swipe', 'Compatibility graph', 'Blind Date chat', 'Profile and verification'],
        'badges'    => ['play', 'app'],
    ],
    [
        'slug'      => 'mehala-carona',
        'client'    => 'Mehala Carona Textiles',
        'title'     => 'Mehala Carona Textiles — Enterprise AI ERP',
        'headline'  => 'One ERP across the factory floor, HR and global shipping',
        'url'       => 'https://mehala.in/',
        'industry'  => 'Textile Manufacturing & Import/Export',
        'icon'      => 'factory',
        'accent'    => '#A96BE8',
        'logo'      => 'mehala-carona.png',
        'mock'      => 'desktop',
        'featured'  => true,
        'categories'=> ['enterprise-erp', 'ai-apps'],
        'summary'   => 'A monolithic ERP with Python AI data pipelines covering machinery maintenance, sales, HRMS, live production tracking and global shipping logistics.',
        'challenge' => 'Fragmented machinery tracking, HRMS, production bottlenecks and complex import/export logistics. Each function ran on its own system or spreadsheet, so nobody could answer a question that crossed two departments without a day of reconciliation.',
        'solution'  => 'We engineered a monolithic Enterprise Resource Planning platform built with Python AI data pipelines, integrating machinery maintenance, sales, HRMS, real-time production tracking and global shipping logistics. Machine telemetry streams into a single warehouse where maintenance forecasting, production planning and shipment tracking all read from the same source of truth.',
        'value'     => 'Complete end-to-end operational visibility, eliminating communication siloes across factory floors and management.',
        'metrics'   => [
            ['value' => '5→1',     'label' => 'Systems consolidated into one ERP'],
            ['value' => 'Real-time','label' => 'Production floor telemetry'],
            ['value' => 'Predictive','label' => 'Machinery maintenance scheduling'],
        ],
        'features'  => [
            ['icon' => 'factory',    'title' => 'Production tracking',   'body' => 'Live output, shift performance and bottleneck detection per line, visible on the floor and in management reporting.'],
            ['icon' => 'gauge',      'title' => 'Machinery telemetry',   'body' => 'Machine-level monitoring with predictive maintenance scheduling driven by run hours and fault patterns.'],
            ['icon' => 'users',      'title' => 'HRMS',                  'body' => 'Attendance, shift rostering, payroll inputs and compliance records for a multi-shift factory workforce.'],
            ['icon' => 'globe',      'title' => 'Import/export logistics','body' => 'Shipment, documentation and customs tracking across international consignments in one pipeline.'],
            ['icon' => 'trending-up','title' => 'Sales and orders',      'body' => 'Order book through to dispatch, with capacity-aware promising rather than optimistic dates.'],
            ['icon' => 'bar-chart',  'title' => 'Control tower',         'body' => 'A single multi-screen view across production, maintenance, workforce and shipping for management.'],
        ],
        'stack'     => ['Python', 'Django', 'PostgreSQL', 'Apache Airflow', 'Pandas', 'React', 'Docker', 'Azure'],
        'screens'   => ['ERP control tower', 'Machinery telemetry', 'HRMS roster', 'Shipping pipeline'],
        'badges'    => ['web'],
    ],
];

// ---------------------------------------------------------------------------
// Assistant languages
// ---------------------------------------------------------------------------

/**
 * Languages iThrive AI speaks.
 *
 * `bcp47` drives both speech recognition and voice selection. Recognition is
 * performed by the browser's speech service and works for all six regardless
 * of what is installed locally; speech *output* depends on a voice being
 * present on the device, which for the Indic five often means none — see
 * TTS_ENDPOINT in config.php for the server-side path.
 */
const ASSISTANT_LANGUAGES = [
    ['code' => 'en', 'bcp47' => 'en-IN', 'name' => 'English',   'native' => 'English'],
    ['code' => 'ta', 'bcp47' => 'ta-IN', 'name' => 'Tamil',     'native' => 'தமிழ்'],
    ['code' => 'ml', 'bcp47' => 'ml-IN', 'name' => 'Malayalam', 'native' => 'മലയാളം'],
    ['code' => 'kn', 'bcp47' => 'kn-IN', 'name' => 'Kannada',   'native' => 'ಕನ್ನಡ'],
    ['code' => 'te', 'bcp47' => 'te-IN', 'name' => 'Telugu',    'native' => 'తెలుగు'],
    ['code' => 'hi', 'bcp47' => 'hi-IN', 'name' => 'Hindi',     'native' => 'हिन्दी'],
];

/** Look up one language by its short code, falling back to English. */
function assistant_language(string $code): array
{
    foreach (ASSISTANT_LANGUAGES as $lang) {
        if ($lang['code'] === $code) {
            return $lang;
        }
    }

    return ASSISTANT_LANGUAGES[0];
}

/**
 * UI and fallback strings per language, so the assistant stays in-language even
 * when it is answering from the offline brain rather than the model.
 */
const ASSISTANT_STRINGS = [
    'en' => [
        'prompt'   => 'Tap to speak',
        'listening'=> 'Listening…',
        'thinking' => 'Thinking…',
        'speaking' => 'Speaking…',
        'placeholder' => 'Type a question, or tap the orb to speak…',
        'offtopic' => 'I only cover iThrive — what we build and the platforms we have shipped. An iThrive AI Agent trained on your own business would answer that properly. Email %s to talk about one.',
        'nudge'    => 'Ask me about iThrive or our services and I will answer in detail — try "what do you build with Python and AI?"',
        'novoice'  => 'Your device has no %s voice installed, so answers appear as text.',
    ],
    'ta' => [
        'prompt'   => 'பேச தட்டவும்',
        'listening'=> 'கேட்கிறேன்…',
        'thinking' => 'யோசிக்கிறேன்…',
        'speaking' => 'பேசுகிறேன்…',
        'placeholder' => 'கேள்வியை தட்டச்சு செய்யவும், அல்லது பேச கோளத்தை தட்டவும்…',
        'offtopic' => 'நான் iThrive பற்றி மட்டுமே பதிலளிக்கிறேன். உங்கள் நிறுவனத்திற்கென பயிற்சி பெற்ற iThrive AI Agent அதற்கு சரியாக பதிலளிக்கும். %s என்ற முகவரிக்கு எழுதுங்கள்.',
        'nudge'    => 'iThrive அல்லது எங்கள் சேவைகள் பற்றி கேளுங்கள் — விரிவாக பதிலளிக்கிறேன்.',
        'novoice'  => 'உங்கள் சாதனத்தில் %s குரல் நிறுவப்படவில்லை, எனவே பதில்கள் உரையாக காட்டப்படும்.',
    ],
    'ml' => [
        'prompt'   => 'സംസാരിക്കാൻ ടാപ്പ് ചെയ്യുക',
        'listening'=> 'കേൾക്കുന്നു…',
        'thinking' => 'ചിന്തിക്കുന്നു…',
        'speaking' => 'സംസാരിക്കുന്നു…',
        'placeholder' => 'ചോദ്യം ടൈപ്പ് ചെയ്യുക, അല്ലെങ്കിൽ സംസാരിക്കാൻ ടാപ്പ് ചെയ്യുക…',
        'offtopic' => 'ഞാൻ iThrive-നെക്കുറിച്ച് മാത്രമേ ഉത്തരം നൽകൂ. നിങ്ങളുടെ ബിസിനസ്സിനായി പരിശീലിപ്പിച്ച ഒരു iThrive AI Agent അതിന് ശരിയായി ഉത്തരം നൽകും. %s എന്ന വിലാസത്തിൽ എഴുതുക.',
        'nudge'    => 'iThrive അല്ലെങ്കിൽ ഞങ്ങളുടെ സേവനങ്ങളെക്കുറിച്ച് ചോദിക്കൂ — വിശദമായി ഉത്തരം നൽകാം.',
        'novoice'  => 'നിങ്ങളുടെ ഉപകരണത്തിൽ %s ശബ്ദം ഇല്ല, അതിനാൽ ഉത്തരങ്ങൾ ടെക്സ്റ്റായി കാണിക്കും.',
    ],
    'kn' => [
        'prompt'   => 'ಮಾತನಾಡಲು ಟ್ಯಾಪ್ ಮಾಡಿ',
        'listening'=> 'ಕೇಳುತ್ತಿದ್ದೇನೆ…',
        'thinking' => 'ಯೋಚಿಸುತ್ತಿದ್ದೇನೆ…',
        'speaking' => 'ಮಾತನಾಡುತ್ತಿದ್ದೇನೆ…',
        'placeholder' => 'ಪ್ರಶ್ನೆ ಟೈಪ್ ಮಾಡಿ, ಅಥವಾ ಮಾತನಾಡಲು ಟ್ಯಾಪ್ ಮಾಡಿ…',
        'offtopic' => 'ನಾನು iThrive ಬಗ್ಗೆ ಮಾತ್ರ ಉತ್ತರಿಸುತ್ತೇನೆ. ನಿಮ್ಮ ವ್ಯವಹಾರಕ್ಕಾಗಿ ತರಬೇತಿ ಪಡೆದ iThrive AI Agent ಅದಕ್ಕೆ ಸರಿಯಾಗಿ ಉತ್ತರಿಸುತ್ತದೆ. %s ಗೆ ಬರೆಯಿರಿ.',
        'nudge'    => 'iThrive ಅಥವಾ ನಮ್ಮ ಸೇವೆಗಳ ಬಗ್ಗೆ ಕೇಳಿ — ವಿವರವಾಗಿ ಉತ್ತರಿಸುತ್ತೇನೆ.',
        'novoice'  => 'ನಿಮ್ಮ ಸಾಧನದಲ್ಲಿ %s ಧ್ವನಿ ಇಲ್ಲ, ಆದ್ದರಿಂದ ಉತ್ತರಗಳು ಪಠ್ಯವಾಗಿ ಕಾಣಿಸುತ್ತವೆ.',
    ],
    'te' => [
        'prompt'   => 'మాట్లాడటానికి నొక్కండి',
        'listening'=> 'వింటున్నాను…',
        'thinking' => 'ఆలోచిస్తున్నాను…',
        'speaking' => 'మాట్లాడుతున్నాను…',
        'placeholder' => 'ప్రశ్న టైప్ చేయండి, లేదా మాట్లాడటానికి నొక్కండి…',
        'offtopic' => 'నేను iThrive గురించి మాత్రమే సమాధానం ఇస్తాను. మీ వ్యాపారం కోసం శిక్షణ పొందిన iThrive AI Agent దానికి సరిగ్గా సమాధానం ఇస్తుంది. %s కు రాయండి.',
        'nudge'    => 'iThrive లేదా మా సేవల గురించి అడగండి — వివరంగా సమాధానం ఇస్తాను.',
        'novoice'  => 'మీ పరికరంలో %s వాయిస్ లేదు, కాబట్టి సమాధానాలు టెక్స్ట్‌గా కనిపిస్తాయి.',
    ],
    'hi' => [
        'prompt'   => 'बोलने के लिए टैप करें',
        'listening'=> 'सुन रहा हूँ…',
        'thinking' => 'सोच रहा हूँ…',
        'speaking' => 'बोल रहा हूँ…',
        'placeholder' => 'प्रश्न टाइप करें, या बोलने के लिए टैप करें…',
        'offtopic' => 'मैं केवल iThrive के बारे में उत्तर देता हूँ। आपके व्यवसाय के लिए प्रशिक्षित iThrive AI Agent उसका सही उत्तर देगा। %s पर लिखें।',
        'nudge'    => 'iThrive या हमारी सेवाओं के बारे में पूछें — मैं विस्तार से उत्तर दूँगा।',
        'novoice'  => 'आपके डिवाइस में %s आवाज़ नहीं है, इसलिए उत्तर टेक्स्ट में दिखेंगे।',
    ],
];

/**
 * Answers the offline brain gives, in every language it supports.
 *
 * These cover the four highest-traffic intents plus a lead-in used when the
 * answer comes from a service or case study record. Placeholders are filled with
 * sprintf in the order noted on each line.
 */
/**
 * Suggested questions under the assistant, translated for every language.
 *
 * Keyed by answer-book id. The chip shows the visitor's language; clicking it
 * sends the canonical English question from FAQ, so the match is guaranteed
 * rather than dependent on how well a translation happens to hit the lexicon.
 */
const ASSISTANT_PROMPTS = [
    'q2' => [
        'en' => 'What engagement models does iThrive offer?',
        'ta' => 'iThrive என்ன ஒப்பந்த முறைகளை வழங்குகிறது?',
        'ml' => 'iThrive എന്തൊക്കെ എൻഗേജ്‌മെന്റ് മോഡലുകൾ നൽകുന്നു?',
        'kn' => 'iThrive ಯಾವ ಒಪ್ಪಂದ ಮಾದರಿಗಳನ್ನು ನೀಡುತ್ತದೆ?',
        'te' => 'iThrive ఏ ఎంగేజ్‌మెంట్ మోడల్‌లను అందిస్తుంది?',
        'hi' => 'iThrive कौन-कौन से एंगेजमेंट मॉडल देता है?',
    ],
    'q9' => [
        'en' => 'How much does it cost to build a full AI-Native product?',
        'ta' => 'முழு AI-Native தயாரிப்பை உருவாக்க என்ன விலை ஆகும்?',
        'ml' => 'ഒരു പൂർണ്ണ AI-Native ഉൽപ്പന്നം നിർമ്മിക്കാൻ എന്ത് ചെലവ് വരും?',
        'kn' => 'ಸಂಪೂರ್ಣ AI-Native ಉತ್ಪನ್ನ ನಿರ್ಮಿಸಲು ಎಷ್ಟು ವೆಚ್ಚವಾಗುತ್ತದೆ?',
        'te' => 'పూర్తి AI-Native ఉత్పత్తిని నిర్మించడానికి ఎంత ఖర్చు అవుతుంది?',
        'hi' => 'पूरा AI-Native प्रोडक्ट बनाने में कितनी लागत आती है?',
    ],
    'q8' => [
        'en' => 'What is the difference between AI-First and AI-Native?',
        'ta' => 'AI-First மற்றும் AI-Native இடையே உள்ள வித்தியாசம் என்ன?',
        'ml' => 'AI-First-ഉം AI-Native-ഉം തമ്മിലുള്ള വ്യത്യാസം എന്താണ്?',
        'kn' => 'AI-First ಮತ್ತು AI-Native ನಡುವಿನ ವ್ಯತ್ಯಾಸವೇನು?',
        'te' => 'AI-First మరియు AI-Native మధ్య తేడా ఏమిటి?',
        'hi' => 'AI-First और AI-Native में क्या अंतर है?',
    ],
    'q68' => [
        'en' => 'What steps should I take to start a project with iThrive?',
        'ta' => 'iThrive உடன் ஒரு திட்டத்தைத் தொடங்க என்ன படிகள்?',
        'ml' => 'iThrive-നൊപ്പം ഒരു പ്രോജക്ട് തുടങ്ങാൻ എന്തൊക്കെ ചെയ്യണം?',
        'kn' => 'iThrive ಜೊತೆ ಯೋಜನೆ ಪ್ರಾರಂಭಿಸಲು ಯಾವ ಹಂತಗಳು?',
        'te' => 'iThrive తో ప్రాజెక్ట్ ప్రారంభించడానికి ఏ దశలు?',
        'hi' => 'iThrive के साथ प्रोजेक्ट शुरू करने के लिए क्या करना होगा?',
    ],
];

const ASSISTANT_ANSWERS = [
    'en' => [
        'contact' => 'Email %1$s or call %2$s. We are based in %3$s. Send a paragraph about the workflow you want to fix and you will get a written build plan — scope, stack and a realistic timeline — within two working days.',
        // Used when site_phone() is null: the same sentence without the call clause.
        'contact_nophone' => 'Email %1$s. We are based in %2$s. Send a paragraph about the workflow you want to fix and you will get a written build plan — scope, stack and a realistic timeline — within two working days.',
        'process' => 'Every engagement runs through three gates.',
        'price'   => 'Pricing depends on scope, so we do not publish a rate card — and I will not guess at a number. You describe the workflow, we run a discovery pass, and you get a fixed scope and price in writing before any production code is written. Email %1$s to start.',
        'hiring'  => 'We are hiring: %1$s. Everyone here writes code, talks to clients and owns something in production. Send your work to %2$s.',
        'services' => 'We build AI-powered platforms, web and mobile applications in Python. Four practices:',
        'found'   => 'Here is what we have on that:',
    ],
    'ta' => [
        'contact' => '%1$s க்கு மின்னஞ்சல் அனுப்புங்கள் அல்லது %2$s ஐ அழையுங்கள். நாங்கள் %3$s இல் உள்ளோம். நீங்கள் சரிசெய்ய விரும்பும் பணிப்பாய்வு பற்றி ஒரு பத்தி எழுதுங்கள் — இரண்டு வேலை நாட்களுக்குள் திட்டம், தொழில்நுட்பம் மற்றும் கால அட்டவணையுடன் எழுத்துப்பூர்வ திட்டம் கிடைக்கும்.',
        // Used when site_phone() is null: the same sentence without the call clause.
        'contact_nophone' => '%1$s க்கு மின்னஞ்சல் அனுப்புங்கள். நாங்கள் %2$s இல் உள்ளோம். நீங்கள் சரிசெய்ய விரும்பும் பணிப்பாய்வு பற்றி ஒரு பத்தி எழுதுங்கள் — இரண்டு வேலை நாட்களுக்குள் திட்டம், தொழில்நுட்பம் மற்றும் கால அட்டவணையுடன் எழுத்துப்பூர்வ திட்டம் கிடைக்கும்.',
        'process' => 'ஒவ்வொரு ஒப்பந்தமும் மூன்று நிலைகளில் நடக்கிறது.',
        'price'   => 'விலை பணியின் அளவைப் பொறுத்தது, எனவே நாங்கள் நிலையான விலைப்பட்டியல் வெளியிடுவதில்லை — நான் ஒரு எண்ணை ஊகிக்க மாட்டேன். நீங்கள் பணிப்பாய்வை விவரிக்கிறீர்கள், நாங்கள் ஆய்வு செய்கிறோம், பின்னர் எழுத்துப்பூர்வமாக நிலையான விலை தருகிறோம். தொடங்க %1$s க்கு எழுதுங்கள்.',
        'hiring'  => 'நாங்கள் பணியமர்த்துகிறோம்: %1$s. உங்கள் பணியை %2$s க்கு அனுப்புங்கள்.',
        'services' => 'நாங்கள் Python இல் AI இயங்கும் தளங்கள், இணையதளங்கள் மற்றும் மொபைல் செயலிகளை உருவாக்குகிறோம். நான்கு பிரிவுகள்:',
        'found'   => 'அதைப் பற்றி எங்களிடம் உள்ள விவரம்:',
    ],
    'ml' => [
        'contact' => '%1$s എന്ന വിലാസത്തിൽ ഇമെയിൽ അയക്കുക അല്ലെങ്കിൽ %2$s എന്ന നമ്പറിൽ വിളിക്കുക. ഞങ്ങൾ %3$s ആണ്. നിങ്ങൾ പരിഹരിക്കാൻ ആഗ്രഹിക്കുന്ന വർക്ക്ഫ്ലോയെക്കുറിച്ച് ഒരു ഖണ്ഡിക അയക്കുക — രണ്ട് പ്രവൃത്തി ദിവസത്തിനുള്ളിൽ എഴുതിയ പദ്ധതി ലഭിക്കും.',
        // Used when site_phone() is null: the same sentence without the call clause.
        'contact_nophone' => '%1$s എന്ന വിലാസത്തിൽ ഇമെയിൽ അയക്കുക. ഞങ്ങൾ %2$s ആണ്. നിങ്ങൾ പരിഹരിക്കാൻ ആഗ്രഹിക്കുന്ന വർക്ക്ഫ്ലോയെക്കുറിച്ച് ഒരു ഖണ്ഡിക അയക്കുക — രണ്ട് പ്രവൃത്തി ദിവസത്തിനുള്ളിൽ എഴുതിയ പദ്ധതി ലഭിക്കും.',
        'process' => 'ഓരോ ഇടപാടും മൂന്ന് ഘട്ടങ്ങളിലൂടെ കടന്നുപോകുന്നു.',
        'price'   => 'വില പ്രവൃത്തിയുടെ വ്യാപ്തിയെ ആശ്രയിച്ചിരിക്കുന്നു, അതിനാൽ ഞങ്ങൾ നിരക്ക് പട്ടിക പ്രസിദ്ധീകരിക്കുന്നില്ല — ഞാൻ ഒരു സംഖ്യ ഊഹിക്കില്ല. നിങ്ങൾ വർക്ക്ഫ്ലോ വിവരിക്കുക, ഞങ്ങൾ പഠിക്കും, തുടർന്ന് എഴുതി വില നൽകും. തുടങ്ങാൻ %1$s എന്ന വിലാസത്തിൽ എഴുതുക.',
        'hiring'  => 'ഞങ്ങൾ നിയമിക്കുന്നു: %1$s. നിങ്ങളുടെ ജോലി %2$s ലേക്ക് അയക്കുക.',
        'services' => 'ഞങ്ങൾ Python-ൽ AI പ്ലാറ്റ്ഫോമുകൾ, വെബ്, മൊബൈൽ ആപ്ലിക്കേഷനുകൾ നിർമ്മിക്കുന്നു. നാല് വിഭാഗങ്ങൾ:',
        'found'   => 'അതിനെക്കുറിച്ച് ഞങ്ങളുടെ പക്കലുള്ളത്:',
    ],
    'kn' => [
        'contact' => '%1$s ಗೆ ಇಮೇಲ್ ಮಾಡಿ ಅಥವಾ %2$s ಗೆ ಕರೆ ಮಾಡಿ. ನಾವು %3$s ನಲ್ಲಿದ್ದೇವೆ. ನೀವು ಸರಿಪಡಿಸಲು ಬಯಸುವ ಕೆಲಸದ ಹರಿವಿನ ಬಗ್ಗೆ ಒಂದು ಪ್ಯಾರಾ ಕಳುಹಿಸಿ — ಎರಡು ಕೆಲಸದ ದಿನಗಳಲ್ಲಿ ಲಿಖಿತ ಯೋಜನೆ ಸಿಗುತ್ತದೆ.',
        // Used when site_phone() is null: the same sentence without the call clause.
        'contact_nophone' => '%1$s ಗೆ ಇಮೇಲ್ ಮಾಡಿ. ನಾವು %2$s ನಲ್ಲಿದ್ದೇವೆ. ನೀವು ಸರಿಪಡಿಸಲು ಬಯಸುವ ಕೆಲಸದ ಹರಿವಿನ ಬಗ್ಗೆ ಒಂದು ಪ್ಯಾರಾ ಕಳುಹಿಸಿ — ಎರಡು ಕೆಲಸದ ದಿನಗಳಲ್ಲಿ ಲಿಖಿತ ಯೋಜನೆ ಸಿಗುತ್ತದೆ.',
        'process' => 'ಪ್ರತಿ ಒಪ್ಪಂದವೂ ಮೂರು ಹಂತಗಳ ಮೂಲಕ ಸಾಗುತ್ತದೆ.',
        'price'   => 'ಬೆಲೆ ಕೆಲಸದ ವ್ಯಾಪ್ತಿಯನ್ನು ಅವಲಂಬಿಸಿದೆ, ಆದ್ದರಿಂದ ನಾವು ದರ ಪಟ್ಟಿ ಪ್ರಕಟಿಸುವುದಿಲ್ಲ — ನಾನು ಸಂಖ್ಯೆಯನ್ನು ಊಹಿಸುವುದಿಲ್ಲ. ನೀವು ಕೆಲಸವನ್ನು ವಿವರಿಸಿ, ನಾವು ಪರಿಶೀಲಿಸುತ್ತೇವೆ, ನಂತರ ಲಿಖಿತವಾಗಿ ನಿಗದಿತ ಬೆಲೆ ನೀಡುತ್ತೇವೆ. %1$s ಗೆ ಬರೆಯಿರಿ.',
        'hiring'  => 'ನಾವು ನೇಮಕ ಮಾಡುತ್ತಿದ್ದೇವೆ: %1$s. ನಿಮ್ಮ ಕೆಲಸವನ್ನು %2$s ಗೆ ಕಳುಹಿಸಿ.',
        'services' => 'ನಾವು Python ನಲ್ಲಿ AI ಚಾಲಿತ ವೇದಿಕೆಗಳು, ವೆಬ್ ಮತ್ತು ಮೊಬೈಲ್ ಅಪ್ಲಿಕೇಶನ್‌ಗಳನ್ನು ನಿರ್ಮಿಸುತ್ತೇವೆ. ನಾಲ್ಕು ವಿಭಾಗಗಳು:',
        'found'   => 'ಅದರ ಬಗ್ಗೆ ನಮ್ಮ ಬಳಿ ಇರುವ ವಿವರ:',
    ],
    'te' => [
        'contact' => '%1$s కు ఇమెయిల్ చేయండి లేదా %2$s కు కాల్ చేయండి. మేము %3$s లో ఉన్నాము. మీరు సరిచేయాలనుకుంటున్న పని విధానం గురించి ఒక పేరా పంపండి — రెండు పని దినాల్లో రాతపూర్వక ప్రణాళిక అందుతుంది.',
        // Used when site_phone() is null: the same sentence without the call clause.
        'contact_nophone' => '%1$s కు ఇమెయిల్ చేయండి. మేము %2$s లో ఉన్నాము. మీరు సరిచేయాలనుకుంటున్న పని విధానం గురించి ఒక పేరా పంపండి — రెండు పని దినాల్లో రాతపూర్వక ప్రణాళిక అందుతుంది.',
        'process' => 'ప్రతి ఒప్పందం మూడు దశల ద్వారా సాగుతుంది.',
        'price'   => 'ధర పని పరిధిపై ఆధారపడి ఉంటుంది, కాబట్టి మేము రేటు జాబితా ప్రచురించము — నేను ఒక సంఖ్యను ఊహించను. మీరు పనిని వివరించండి, మేము పరిశీలిస్తాము, ఆపై రాతపూర్వకంగా నిర్ణీత ధర ఇస్తాము. %1$s కు రాయండి.',
        'hiring'  => 'మేము నియామకాలు చేస్తున్నాము: %1$s. మీ పనిని %2$s కు పంపండి.',
        'services' => 'మేము Python లో AI ఆధారిత ప్లాట్‌ఫారమ్‌లు, వెబ్ మరియు మొబైల్ అప్లికేషన్‌లను నిర్మిస్తాము. నాలుగు విభాగాలు:',
        'found'   => 'దాని గురించి మా వద్ద ఉన్న వివరాలు:',
    ],
    'hi' => [
        'contact' => '%1$s पर ईमेल करें या %2$s पर कॉल करें। हम %3$s में हैं। जिस प्रक्रिया को आप ठीक करना चाहते हैं उसके बारे में एक पैराग्राफ भेजें — दो कार्य दिवसों में लिखित योजना मिलेगी।',
        // Used when site_phone() is null: the same sentence without the call clause.
        'contact_nophone' => '%1$s पर ईमेल करें। हम %2$s में हैं। जिस प्रक्रिया को आप ठीक करना चाहते हैं उसके बारे में एक पैराग्राफ भेजें — दो कार्य दिवसों में लिखित योजना मिलेगी।',
        'process' => 'हर एंगेजमेंट तीन चरणों से गुजरता है।',
        'price'   => 'कीमत काम के दायरे पर निर्भर करती है, इसलिए हम रेट कार्ड प्रकाशित नहीं करते — और मैं कोई संख्या अनुमान से नहीं बताऊँगा। आप प्रक्रिया बताइए, हम जाँच करेंगे, फिर लिखित में निश्चित कीमत देंगे। शुरू करने के लिए %1$s पर लिखें।',
        'hiring'  => 'हम भर्ती कर रहे हैं: %1$s. अपना काम %2$s पर भेजें।',
        'services' => 'हम Python में AI संचालित प्लेटफ़ॉर्म, वेब और मोबाइल ऐप्लिकेशन बनाते हैं। चार श्रेणियाँ:',
        'found'   => 'इस बारे में हमारे पास यह जानकारी है:',
    ],
];

// ---------------------------------------------------------------------------
// Technology stack
// ---------------------------------------------------------------------------

const TECH_STACK_HEAD = [
    'eyebrow' => 'Tech Stack',
    'title'   => 'The tools we actually ship with',
    'lead'    => 'Not a logo wall of everything that exists. This is what is running in the ten platforms in our portfolio — grouped by where it sits in the stack.',
];

/**
 * Each entry: label, the ring it orbits on (0 = innermost), and a hue in
 * degrees used for its node colour in the interactive view.
 */
const TECH_STACK = [
    [
        'slug'  => 'ai',
        'title' => 'AI & Machine Learning',
        'icon'  => 'brain',
        'blurb' => 'Agentic workflows, retrieval and model evaluation — the layer that makes a product decide rather than just store.',
        'items' => [
            ['name' => 'Python', 'hue' => 190, 'logo' => 'python'],
            ['name' => 'LangGraph', 'hue' => 200, 'logo' => 'langchain'],
            ['name' => 'PyTorch', 'hue' => 205, 'logo' => 'pytorch'],
            ['name' => 'TensorFlow', 'hue' => 210, 'logo' => 'tensorflow'],
            ['name' => 'scikit-learn', 'hue' => 215, 'logo' => 'scikitlearn'],
            ['name' => 'Whisper', 'hue' => 220, 'logo' => 'openai'],
            ['name' => 'pgvector', 'hue' => 225, 'logo' => 'postgresql'],
            ['name' => 'OpenSearch', 'hue' => 230, 'logo' => 'opensearch'],
        ],
    ],
    [
        'slug'  => 'backend',
        'title' => 'Backend & APIs',
        'icon'  => 'terminal',
        'blurb' => 'Typed, tested services. Python first, with the JVM and .NET where a client already runs them.',
        'items' => [
            ['name' => 'FastAPI', 'hue' => 235, 'logo' => 'fastapi'],
            ['name' => 'Django', 'hue' => 240, 'logo' => 'django'],
            ['name' => 'Node.js', 'hue' => 245, 'logo' => 'nodedotjs'],
            ['name' => 'Express', 'hue' => 250, 'logo' => 'express'],
            ['name' => 'Laravel', 'hue' => 255, 'logo' => 'laravel'],
            ['name' => 'PHP', 'hue' => 260, 'logo' => 'php'],
            ['name' => 'Java', 'hue' => 265, 'logo' => 'openjdk'],
            ['name' => '.NET', 'hue' => 270, 'logo' => 'dotnet'],
            ['name' => 'Celery', 'hue' => 275, 'logo' => 'celery'],
            ['name' => 'GraphQL', 'hue' => 280, 'logo' => 'graphql'],
        ],
    ],
    [
        'slug'  => 'frontend',
        'title' => 'Web & Frontend',
        'icon'  => 'code',
        'blurb' => 'Data-dense interfaces that stay fast past year one, and marketing sites that pass Core Web Vitals.',
        'items' => [
            ['name' => 'React', 'hue' => 185, 'logo' => 'react'],
            ['name' => 'Next.js', 'hue' => 188, 'logo' => 'nextdotjs'],
            ['name' => 'TypeScript', 'hue' => 192, 'logo' => 'typescript'],
            ['name' => 'Angular', 'hue' => 196, 'logo' => 'angular'],
            ['name' => 'Vue', 'hue' => 200, 'logo' => 'vuedotjs'],
            ['name' => 'Three.js', 'hue' => 204, 'logo' => 'threedotjs'],
            ['name' => 'Tailwind', 'hue' => 208, 'logo' => 'tailwindcss'],
            ['name' => 'Vite', 'hue' => 212, 'logo' => 'vite'],
        ],
    ],
    [
        'slug'  => 'mobile',
        'title' => 'Mobile',
        'icon'  => 'smartphone',
        'blurb' => 'Two stores from one codebase, without giving up launch time or offline behaviour.',
        'items' => [
            ['name' => 'Flutter', 'hue' => 290, 'logo' => 'flutter'],
            ['name' => 'React Native', 'hue' => 295, 'logo' => 'react'],
            ['name' => 'Kotlin', 'hue' => 300, 'logo' => 'kotlin'],
            ['name' => 'Swift', 'hue' => 305, 'logo' => 'swift'],
            ['name' => 'Firebase', 'hue' => 310, 'logo' => 'firebase'],
        ],
    ],
    [
        'slug'  => 'data',
        'title' => 'Data & Storage',
        'icon'  => 'database',
        'blurb' => 'Relational by default, with the warehouse and stream layers the ERP and analytics work needs.',
        'items' => [
            ['name' => 'PostgreSQL', 'hue' => 170, 'logo' => 'postgresql'],
            ['name' => 'MySQL', 'hue' => 174, 'logo' => 'mysql'],
            ['name' => 'MongoDB', 'hue' => 178, 'logo' => 'mongodb'],
            ['name' => 'Redis', 'hue' => 182, 'logo' => 'redis'],
            ['name' => 'PostGIS', 'hue' => 186, 'logo' => 'postgresql'],
            ['name' => 'Airflow', 'hue' => 190, 'logo' => 'apacheairflow'],
            ['name' => 'dbt', 'hue' => 194, 'logo' => 'dbt'],
            ['name' => 'Pandas', 'hue' => 198, 'logo' => 'pandas'],
        ],
    ],
    [
        'slug'  => 'cloud',
        'title' => 'Cloud & DevOps',
        'icon'  => 'cloud',
        'blurb' => 'Infrastructure as code, pipelines that deploy in minutes, and observability that pages a human only when one is needed.',
        'items' => [
            ['name' => 'AWS', 'hue' => 320, 'logo' => 'amazonwebservices'],
            ['name' => 'Azure', 'hue' => 325, 'logo' => 'azure'],
            ['name' => 'Google Cloud', 'hue' => 330, 'logo' => 'googlecloud'],
            ['name' => 'Docker', 'hue' => 335, 'logo' => 'docker'],
            ['name' => 'Kubernetes', 'hue' => 340, 'logo' => 'kubernetes'],
            ['name' => 'Terraform', 'hue' => 345, 'logo' => 'terraform'],
            ['name' => 'GitHub Actions', 'hue' => 350, 'logo' => 'githubactions'],
            ['name' => 'Jenkins', 'hue' => 355, 'logo' => 'jenkins'],
            ['name' => 'Grafana', 'hue' => 358, 'logo' => 'grafana'],
        ],
    ],
    [
        'slug'  => 'commerce',
        'title' => 'Commerce & Payments',
        'icon'  => 'cart',
        'blurb' => 'Storefronts and the money rails behind them, including full Indian payments coverage.',
        'items' => [
            ['name' => 'Shopify', 'hue' => 150, 'logo' => 'shopify'],
            ['name' => 'WooCommerce', 'hue' => 155, 'logo' => 'woocommerce'],
            ['name' => 'Razorpay', 'hue' => 160, 'logo' => 'razorpay'],
            ['name' => 'Stripe', 'hue' => 165, 'logo' => 'stripe'],
            ['name' => 'UPI', 'hue' => 168, 'logo' => 'upi'],
        ],
    ],
];

// ---------------------------------------------------------------------------
// Social proof
// ---------------------------------------------------------------------------

const TESTIMONIALS = [
    [
        'quote'  => 'The dispatch rewrite paid for itself in a quarter. What stood out was that they argued us out of two features we asked for and were right both times.',
        'name'   => 'Operations Director',
        'role'   => 'On-demand mobility platform',
        'icon'   => 'car',
    ],
    [
        'quote'  => 'We had been told a rewrite was the only option. iThrive migrated us capability by capability with the old system live throughout, and we never stopped shipping features.',
        'name'   => 'Head of Technology',
        'role'   => 'Manufacturing group',
        'icon'   => 'factory',
    ],
    [
        'quote'  => 'The AI scribe is the first piece of clinical software our doctors asked to have extended rather than removed. It drafts, they sign — that boundary was the point.',
        'name'   => 'Medical Superintendent',
        'role'   => 'Multi-speciality hospital',
        'icon'   => 'stethoscope',
    ],
    [
        'quote'  => 'Returns were eating the category. They went straight at the fit problem with our own returns data instead of selling us a generic recommendation engine.',
        'name'   => 'Founder',
        'role'   => 'Children\'s fashion retailer',
        'icon'   => 'shirt',
    ],
];

// ---------------------------------------------------------------------------
// Company pages
// ---------------------------------------------------------------------------

const ABOUT = [
    'eyebrow' => 'About iThrive',
    'title'   => 'We incubate a culture of innovation and AI-first excellence.',
    'lead'    => 'iThrive Software is a product engineering company building intelligent platforms in Python for businesses that have outgrown off-the-shelf software.',
    'body'    => [
        'We started from a simple observation: most companies do not need more software, they need the gap closed between what their operation does and what their customers experience. That gap is usually a manual handoff — a phone call, a spreadsheet, a person re-typing something that already exists in a database.',
        'Every platform in our portfolio closes one of those gaps. A dispatch engine that decides in under a second. A grievance system that reads a voice note in Tamil and routes it to the right officer. An ERP that lets a factory manager answer a question that spans four departments without waiting a day for reconciliation.',
        'We build these in Python because one language across API, data pipeline and model layer keeps teams small and decisions fast. We build them AI-first because the interesting problems now sit in judgment rather than storage. And we hand them over documented, because a platform you cannot maintain without us is not an asset.',
    ],
    'values'  => [
        ['icon' => 'target',   'photo' => 'about-01', 'title' => 'Outcome over output',   'body' => 'We agree the number we will be judged on before the work starts, and report against it even when it is unflattering.'],
        ['icon' => 'search',   'photo' => 'about-02', 'title' => 'Argue early',           'body' => 'If the requested feature is wrong, we say so in discovery rather than building it and invoicing for it.'],
        ['icon' => 'layers',   'photo' => 'about-03', 'title' => 'Build to hand over',    'body' => 'Documentation, runbooks and pairing are part of delivery. Lock-in is a business model we decline to have.'],
        ['icon' => 'shield',   'photo' => 'about-04', 'title' => 'Boring where it counts','body' => 'Novel in the model layer, deliberately conventional in auth, payments and deployment.'],
    ],
];

const ABOUT_STATS = [
    ['value' => '10+', 'label' => 'Enterprise platforms shipped'],
    ['value' => '8',   'label' => 'Industries served'],
    ['value' => '6',   'label' => 'Countries reached by our products'],
    ['value' => '100%','label' => 'Source code handed to clients'],
];

const CAREERS = [
    'eyebrow' => 'Careers',
    'title'   => 'Senior engineers who would rather own a problem than a ticket.',
    'lead'    => 'We hire few people and give each of them real scope. Everyone here writes code, talks to clients, and is accountable for something in production.',
    'perks'   => [
        ['icon' => 'brain',    'photo' => 'careers-01', 'title' => 'Real AI work',        'body' => 'Agentic systems and production ML, not a chat widget bolted onto a CRUD app for a demo.'],
        ['icon' => 'users',    'photo' => 'careers-02', 'title' => 'Small teams',         'body' => 'Squads of three to five with direct client contact. No layer of account managers between you and the problem.'],
        ['icon' => 'clock',    'photo' => 'careers-03', 'title' => 'Sane delivery',       'body' => 'Fortnightly cadence and honest estimates. Crunch is treated as a planning failure, because it is one.'],
        ['icon' => 'lightbulb','photo' => 'careers-04', 'title' => 'Learning budget',     'body' => 'Annual budget and dedicated time for courses, conferences and certification.'],
    ],
    'roles'   => [
        ['title' => 'Senior Python Engineer (AI Platforms)', 'type' => 'Full-time', 'location' => 'Coimbatore / Remote', 'body' => 'FastAPI, LangGraph and PostgreSQL. You will own an agentic platform end to end, including the eval harness that keeps it honest.'],
        ['title' => 'Machine Learning Engineer',             'type' => 'Full-time', 'location' => 'Coimbatore / Remote', 'body' => 'Retrieval architecture, model evaluation and cost engineering across client platforms in healthcare, retail and mobility.'],
        ['title' => 'Senior React / React Native Engineer',  'type' => 'Full-time', 'location' => 'Coimbatore / Remote', 'body' => 'Data-dense consoles and cross-platform mobile apps. TypeScript throughout, with a real design system behind it.'],
        ['title' => 'DevOps Engineer',                       'type' => 'Full-time', 'location' => 'Remote',              'body' => 'Terraform, AWS and GitHub Actions across a portfolio of production platforms. You will own the deployment story for all of them.'],
    ],
];

const BLOG_POSTS = [
    [
        'title'    => 'Why your AI feature belongs in a sidecar, not your monolith',
        'excerpt'  => 'Shipping intelligence into a revenue-carrying product is an architecture problem before it is a model problem. The sidecar pattern, feature flags, and why you want a switch that turns the whole thing off.',
        'category' => 'Architecture',
        'date'     => '2026-07-14',
        'read'     => '8 min read',
        'icon'     => 'layers',
    ],
    [
        'title'    => 'Evaluation harnesses: the part of agentic AI nobody demos',
        'excerpt'  => 'A golden dataset and an automated eval suite are the difference between an agent you can change and one nobody dares touch. What to measure, and how to make regressions fail CI.',
        'category' => 'AI Engineering',
        'date'     => '2026-06-30',
        'read'     => '11 min read',
        'icon'     => 'target',
    ],
    [
        'title'    => 'Strangler-fig migrations: modernising without freezing the roadmap',
        'excerpt'  => 'Rewrites fail because they ask a business to stand still for a year. Routing capability away from a legacy system one endpoint at a time, with a rollback path at every step.',
        'category' => 'Modernisation',
        'date'     => '2026-06-12',
        'read'     => '9 min read',
        'icon'     => 'git-branch',
    ],
    [
        'title'    => 'What a size-recommendation engine actually needs (it is not more ML)',
        'excerpt'  => 'The 28% return-rate reduction came from per-SKU garment measurements and reason-coded returns, not from a bigger model. A note on where the leverage really sits in retail AI.',
        'category' => 'Retail AI',
        'date'     => '2026-05-28',
        'read'     => '7 min read',
        'icon'     => 'shirt',
    ],
    [
        'title'    => 'Agentic scheduling in a hospital: where we drew the automation line',
        'excerpt'  => 'The agent books, reschedules, chases and bills. It drafts clinical notes and never files them. How we decided which decisions an autonomous system was allowed to own.',
        'category' => 'Healthcare AI',
        'date'     => '2026-05-09',
        'read'     => '12 min read',
        'icon'     => 'stethoscope',
    ],
    [
        'title'    => 'Python end to end: the case for one language across API, pipeline and model',
        'excerpt'  => 'Polyglot stacks are defensible at scale and expensive before it. Why FastAPI, Celery and PyTorch in one repo keeps a five-person team faster than a fifteen-person one.',
        'category' => 'Engineering',
        'date'     => '2026-04-22',
        'read'     => '6 min read',
        'icon'     => 'code',
    ],
];

// ---------------------------------------------------------------------------
// Contact
// ---------------------------------------------------------------------------

const CONTACT_SERVICES = [
    // The software development landing page pre-selects this, and the submit
    // handler validates against this list — so it has to exist here.
    'Custom Software Development',
    'AI-Native Product Development',
    'AI Enablement for Existing Products',
    'AI Solutions for eCommerce',
    'Micro SaaS Development',
    'Custom Product Development',
    'Product Modernization',
    'Cloud & DevOps',
    'Dedicated Engineering Team',
    'Dedicated On-demand Resources',
    'Mobile App Development',
    'Web Development',
    'E-commerce Development',
    'React JS Development',
    'POC Development',
    'MVP Development',
    'Not sure yet — help me scope it',
];

const CONTACT_BUDGETS = [
    'Under $10k',
    '$10k – $25k',
    '$25k – $50k',
    '$50k – $100k',
    '$100k+',
    'Not decided yet',
];

/**
 * The channels the contact page lists.
 *
 * A function rather than a const because the phone row has to disappear while
 * SITE_PHONE is the placeholder, and a const expression cannot call site_phone().
 */
function contact_channels(): array
{
    $channels = [
        ['icon' => 'mail', 'label' => 'Email', 'value' => SITE_EMAIL, 'href' => 'mailto:' . SITE_EMAIL],
    ];

    if (site_phone() !== null) {
        $channels[] = ['icon' => 'phone', 'label' => 'Phone',
                       'value' => site_phone(), 'href' => 'tel:' . site_phone()];
    }

    $channels[] = ['icon' => 'pin',   'label' => 'Head Office', 'value' => SITE_HQ, 'href' => null];
    $channels[] = ['icon' => 'clock', 'label' => 'Response',
                   'value' => 'Within 2 working days', 'href' => null];

    return $channels;
}
