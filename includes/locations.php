<?php
/**
 * The five studios, as pages.
 *
 * Each entry describes a place the company actually works from — the hub copy
 * on company/about.php is the same material, written longer here. Nothing in
 * this file invents an office: a city we only sell into belongs in
 * areas_served(), not in this list, and the overseas markets are covered by
 * the single global-delivery page rather than one fabricated page per city.
 *
 * `services` are slugs from SERVICES; `keyword` is the phrase the page is
 * written to answer, and it is what the title, the h1 and the schema all say.
 */

declare(strict_types=1);

const LOCATIONS = [
    [
        'slug'     => 'chennai',
        'city'     => 'Chennai',
        'region'   => 'Tamil Nadu',
        'keyword'  => 'AI Development Company in Chennai',
        'role'     => 'Deep tech, AI and the OMR digital corridor',
        'image'    => 'assets/img/about-3d/about-hub-01-chennai.jpg',
        'lead'     => 'Our Chennai studio anchors the AI work: agentic systems, custom model '
                    . 'fine-tuning and the inference pipelines that carry them in production.',
        'body'     => 'Chennai is where most of our AI engineering happens. The team here builds '
                    . 'autonomous agent systems, fine-tunes models on client corpora and runs the '
                    . 'high-concurrency inference that sits behind them — the work that needs '
                    . 'people in one room arguing about an evaluation set. Clients along the OMR '
                    . 'corridor get on-site workshops; everyone else gets the same team over '
                    . 'video, in their own standup.',
        'focus'    => [
            ['title' => 'Agentic AI systems',  'body' => 'Multi-agent squads with supervisor handoff, shared memory and a halt switch — designed, evaluated and operated from here.'],
            ['title' => 'Custom model work',   'body' => 'LoRA and QLoRA fine-tuning on your own corpus, with the evaluation harness that proves the tuned model is actually better.'],
            ['title' => 'Inference at scale',  'body' => 'Model serving sized for concurrency rather than a demo: batching, caching, cost ceilings and the telemetry to see all three.'],
        ],
        'services' => ['ai-agent-solutions', 'custom-agent-development', 'rag-development', 'gen-ai-development'],
        'faqs'     => [
            ['Do you meet clients in Chennai in person?',
             'Yes. Discovery workshops and review sessions happen on site for clients in and around Chennai, including the OMR and Guindy corridors. The engineering itself runs the same way for every client, wherever they are.'],
            ['Which AI services are delivered from the Chennai studio?',
             'AI agent development, RAG systems, generative AI and model fine-tuning, plus the AgentOps work that keeps them accurate after launch.'],
            ['Can you work with our in-house team in Chennai?',
             'That is the usual shape. Our engineers join your repository and your standup, and your team holds the runbook at the end — a permanent dependency on us is not the goal.'],
        ],
    ],
    [
        'slug'     => 'coimbatore',
        'city'     => 'Coimbatore',
        'region'   => 'Tamil Nadu',
        'keyword'  => 'Software Development Company in Coimbatore',
        'role'     => 'Product engineering and the Python core',
        'image'    => 'assets/img/about-3d/about-hub-02-coimbatore.jpg',
        'lead'     => 'The Coimbatore studio is our product engineering foundry — Python backends, '
                    . 'async architecture and the enterprise systems built on them.',
        'body'     => 'Coimbatore builds the platforms. Python services, asynchronous queues, the '
                    . 'data layer and the integrations that hold an enterprise system together — '
                    . 'including the manufacturing and textile clients the city is full of, where '
                    . 'the software has to survive a shop floor rather than a demo. Products that '
                    . 'start as an MVP here are the same codebase two years later, which is the '
                    . 'point.',
        'focus'    => [
            ['title' => 'Python platforms',     'body' => 'FastAPI and Django services, Celery workers and PostgreSQL schemas designed for the load they will actually see.'],
            ['title' => 'Manufacturing systems','body' => 'ERP, production tracking and quality systems for manufacturers across Coimbatore and Tiruppur, wired to the machines and the paperwork both.'],
            ['title' => 'MVP to production',    'body' => 'Twelve-week MVPs that do not have to be thrown away when the idea works — one architecture, carried forward.'],
        ],
        'services' => ['software-development', 'mvp-development', 'custom-product-development', 'cloud-devops'],
        'faqs'     => [
            ['What does the Coimbatore team build?',
             'Custom software and enterprise platforms: Python backends, integrations, data layers and the cloud infrastructure they run on, including systems for manufacturing clients across Coimbatore and Tiruppur.'],
            ['Can you take over a product another agency built?',
             'Yes. We put a routing layer in front and take services over one at a time, so there is no big-bang rewrite and no frozen roadmap while it happens.'],
            ['Do you work with startups in Coimbatore?',
             'Yes — most start as a twelve-week MVP with one metric to prove, full source ownership from day one, and no lock-in to us afterwards.'],
        ],
    ],
    [
        'slug'     => 'bangalore',
        'city'     => 'Bangalore',
        'region'   => 'Karnataka',
        'keyword'  => 'AI & Cloud Development Company in Bangalore',
        'role'     => 'Cloud-native scale and microservices',
        'image'    => 'assets/img/about-3d/about-hub-03-bangalore.jpg',
        'lead'     => 'The Bangalore team runs the cloud side: Kubernetes, infrastructure as code '
                    . 'and the scaling work behind high-throughput platforms.',
        'body'     => 'Bangalore handles what happens when a platform has to hold up. Multi-cloud '
                    . 'Kubernetes, Terraform-managed infrastructure, zero-downtime releases and '
                    . 'the cost control that stops a successful launch becoming an expensive one. '
                    . 'Most of the AI platforms we build elsewhere are deployed and operated '
                    . 'through the pipelines this team owns.',
        'focus'    => [
            ['title' => 'Kubernetes and IaC',   'body' => 'Clusters and environments defined in Terraform, reproducible from an empty account, reviewed like any other code.'],
            ['title' => 'Zero-downtime release','body' => 'Blue-green and canary deploys with a rollback that has been tested rather than assumed.'],
            ['title' => 'Cloud cost control',   'body' => 'Spend attributed per service and per customer, with the inference bill broken out — the line that surprises people on AI platforms.'],
        ],
        'services' => ['cloud-devops', 'ai-integration', 'agentic-ai-integration', 'dedicated-engineering-team'],
        'faqs'     => [
            ['Do you have an office in Bangalore?',
             'We work from a Bangalore hub focused on cloud infrastructure and platform scale. Client meetings happen there or over video, whichever suits you.'],
            ['Can you take over our existing AWS or Azure setup?',
             'Yes. We start with an audit of what is running and what it costs, then move it to infrastructure as code incrementally rather than rebuilding it in one go.'],
            ['Do you provide dedicated engineers to Bangalore product teams?',
             'Yes — senior engineers embedded in your workflow, billed monthly and scalable on thirty days\' notice.'],
        ],
    ],
    [
        'slug'     => 'hyderabad',
        'city'     => 'Hyderabad',
        'region'   => 'Telangana',
        'keyword'  => 'AI Development Company in Hyderabad',
        'role'     => 'Data engineering and security',
        'image'    => 'assets/img/about-3d/about-hub-04-hyderabad.jpg',
        'lead'     => 'Hyderabad covers the data and security side: pipelines, governance and the '
                    . 'controls an enterprise audit asks about.',
        'body'     => 'An AI system is only as good as the data behind it and only as safe as the '
                    . 'controls around it. The Hyderabad team builds the pipelines that feed '
                    . 'retrieval and training, and the access model, audit trail and retention '
                    . 'rules that let a regulated business actually put one into production.',
        'focus'    => [
            ['title' => 'Data pipelines',    'body' => 'Ingestion, cleaning and indexing for retrieval systems, run on a schedule with the removals handled as carefully as the additions.'],
            ['title' => 'Access and audit',  'body' => 'Per-agent service identities, least-privilege scopes and a full action trail an auditor can reconstruct a decision from.'],
            ['title' => 'Governance',        'body' => 'Retention, residency and approval gates written down as policy and enforced in code rather than in a document nobody reads.'],
        ],
        'services' => ['rag-development', 'ai-consulting', 'agent-operations-support', 'computer-vision-development'],
        'faqs'     => [
            ['What is built from Hyderabad?',
             'Data engineering for AI systems — retrieval pipelines, indexing and refresh — along with the access control, audit trail and governance work around them.'],
            ['Can our data stay inside our own environment?',
             'Yes. We deploy into your cloud account or on your infrastructure, so your documents and model traffic never have to leave it.'],
            ['Do you help with AI governance and compliance reviews?',
             'Yes. We write the access model, retention rules and approval gates as part of the build, and hand over the evidence a security review asks for.'],
        ],
    ],
    [
        'slug'     => 'ahmedabad',
        'city'     => 'Ahmedabad',
        'region'   => 'Gujarat',
        'keyword'  => 'AI & Fintech Development Company in Ahmedabad',
        'role'     => 'Fintech platforms and transaction systems',
        'image'    => 'assets/img/about-3d/about-hub-05-ahmedabad.jpg',
        'lead'     => 'Ahmedabad works on transaction-heavy systems: payments, ledgers and the '
                    . 'automation around them.',
        'body'     => 'Money systems are unforgiving about correctness, and that is what this team '
                    . 'is organised around: idempotent writes, reconciliation that catches its own '
                    . 'mistakes, and automation that routes anything it is unsure about to a person '
                    . 'with its reasoning attached. The same discipline carries into the workflow '
                    . 'automation we build for finance and operations teams.',
        'focus'    => [
            ['title' => 'Payments and ledgers', 'body' => 'UPI and gateway integrations, double-entry ledgers and reconciliation that is designed to be re-run safely.'],
            ['title' => 'Finance automation',   'body' => 'Invoice intake, matching and exception routing run by agents, with people on the cases that need judgement.'],
            ['title' => 'Audit-grade trails',   'body' => 'Every automated action attributable to a run and a record, because "the system did it" is not an answer in a finance review.'],
        ],
        'services' => ['autonomous-workflow-automation', 'rpa-development', 'ai-copilot-development', 'ecommerce-development'],
        'faqs'     => [
            ['What kind of work does the Ahmedabad team take on?',
             'Transaction-heavy systems: payments, ledgers, reconciliation and the finance and operations automation built around them.'],
            ['Do you build UPI and payment gateway integrations?',
             'Yes, including the parts people skip — idempotent writes, retries that cannot double-charge, and reconciliation against the gateway\'s own settlement files.'],
            ['Can agents be trusted with financial actions?',
             'Only with gates. Anything above a threshold you set routes to a queue with the agent\'s reasoning attached and waits for a person. That gate is part of the build, not a setting added later.'],
        ],
    ],
];

/**
 * Landing pages a studio leads that are not entries in SERVICES.
 *
 * services/software-development.php is its own page rather than a catalogue
 * service — the sitemap lists it by hand for the same reason — so service()
 * throws on it. Anything named here is rendered from this instead.
 */
const LOCATION_PAGES = [
    'software-development' => [
        'title' => 'Custom Software Development',
        'short' => 'Enterprise platforms and custom software built end to end, in Python, and handed over running.',
    ],
];

/** The card copy for a slug a location links to, from either source. */
function location_service(string $slug): array
{
    if (isset(LOCATION_PAGES[$slug])) {
        return LOCATION_PAGES[$slug];
    }

    $svc = service($slug);

    return ['title' => $svc['title'], 'short' => $svc['short']];
}

/** One location by slug, or null. */
function location(string $slug): ?array
{
    foreach (LOCATIONS as $loc) {
        if ($loc['slug'] === $slug) {
            return $loc;
        }
    }

    return null;
}
