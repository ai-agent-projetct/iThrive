<?php
/**
 * Copy for services/software-development.php.
 *
 * Kept out of content.php for the same reason content-web.php is: this is one
 * page's worth of long-form copy, and folding it into the shared content file
 * would make that file harder to work in for every other page.
 *
 * The money figures in SOFT_INVESTMENT and SOFT_TIMELINE are indicative bands
 * for a discovery conversation, not a quote. They are marked as such in the UI.
 */

declare(strict_types=1);

const SOFT_HERO = [
    'eyebrow'   => 'Custom Software Development',
    'title'     => 'Software that behaves like the business it was built for.',
    'lead'      => 'iThrive Software designs, engineers and runs custom platforms for enterprises and '
                 . 'funded startups — from Chennai and Coimbatore, in Python, with intelligence wired '
                 . 'through the product rather than bolted on the side.',
    'primary'   => ['label' => 'Start your project',   'href' => 'contact.php'],
    'secondary' => ['label' => 'See how we build',     'href' => '#build'],
    'scroll'    => 'Scroll to explore',
];

const SOFT_STATS = [
    ['value' => '10+',   'label' => 'Enterprise platforms in production'],
    ['value' => '8',     'label' => 'Industries delivered into'],
    ['value' => '40%',   'label' => 'Average manual process removed'],
    ['value' => '99.9%', 'label' => 'Uptime across managed products'],
];

const SOFT_INTRO = [
    'eyebrow' => 'What We Do',
    'title'   => 'Most companies do not need more software. They need the right software.',
    'body'    => [
        'Off-the-shelf tools are built for the average of a thousand companies. The parts of your '
        . 'business that actually make money are the parts that are not average — and those are the '
        . 'parts every packaged product asks you to change to fit it.',

        'Custom software runs the other way around. We start from the workflow that is costing you '
        . 'hours, model it exactly as your team describes it, and build a system that removes the '
        . 'manual step instead of documenting it. What comes out is yours: the source, the data, the '
        . 'deployment, the roadmap.',

        'Every engagement is run by senior engineers who sat in your discovery workshop. There is no '
        . 'handover to a delivery team that was not in the room, because that handover is where most '
        . 'software projects quietly lose the plot.',
    ],
    'pillars' => [
        ['icon' => 'code',  'title' => 'Custom Software Development', 'body' => 'Systems modelled on your workflow, not a vendor’s idea of it.'],
        ['icon' => 'brain', 'title' => 'AI & Automation',             'body' => 'Models and agents inside the product, doing work a person used to do.'],
    ],
];

/**
 * The service catalogue. Each entry drives one panel of the pinned scroll
 * theatre, so `stage` names the formation the 3D scene morphs into and `metric`
 * is the single number the panel leads with.
 */
const SOFT_SERVICES = [
    [
        'num'    => '01',
        'icon'   => 'compass',
        'stage'  => 'brief',
        'title'  => 'Software Consulting',
        'body'   => 'Before anyone writes code we map the system you already have — the spreadsheets, '
                  . 'the WhatsApp approvals, the two people who know how billing really works. You get '
                  . 'a written architecture, a build sequence and an honest view of what not to build.',
        'points' => ['Current-state and process audit', 'Target architecture and build sequence', 'Buy / build / integrate decision', 'Written estimate with assumptions'],
        'metric' => ['value' => '2 weeks', 'label' => 'Typical discovery'],
    ],
    [
        'num'    => '02',
        'icon'   => 'package',
        'stage'  => 'build',
        'title'  => 'Custom Product Development',
        'body'   => 'The core practice. Multi-tenant platforms, operations systems, portals, internal '
                  . 'tools and customer-facing products — built in Python, deployed on infrastructure '
                  . 'you own, documented well enough that another team could pick it up.',
        'points' => ['Web platforms and admin systems', 'Multi-tenant SaaS products', 'Operations and field applications', 'Embedded and device-adjacent software'],
        'metric' => ['value' => '6–14 wks', 'label' => 'First production release'],
    ],
    [
        'num'    => '03',
        'icon'   => 'workflow',
        'stage'  => 'integrate',
        'title'  => 'Software Integration',
        'body'   => 'Your ERP, your CRM, the accounting package, the payment gateway, the logistics '
                  . 'partner’s API and the machine on the factory floor — talking to each other through '
                  . 'one contract layer instead of six brittle exports.',
        'points' => ['ERP, CRM and accounting integrations', 'Payment, KYC and logistics APIs', 'Event pipelines and webhooks', 'Legacy adapters for systems with no API'],
        'metric' => ['value' => '30+', 'label' => 'Third-party systems wired'],
    ],
    [
        'num'    => '04',
        'icon'   => 'monitor',
        'stage'  => 'ship',
        'title'  => 'Web Application Development',
        'body'   => 'Applications that hold up on a mid-range Android phone on a patchy connection, '
                  . 'because that is what your customers are actually using. Accessible, fast, and '
                  . 'measured against real device budgets rather than a laptop on office wifi.',
        'points' => ['Customer portals and dashboards', 'Progressive web applications', 'Design systems and component libraries', 'Performance and accessibility budgets'],
        'metric' => ['value' => '<1.5s', 'label' => 'Target LCP on 4G'],
    ],
    [
        'num'    => '05',
        'icon'   => 'brain',
        'stage'  => 'intelligence',
        'title'  => 'AI & Automation Engineering',
        'body'   => 'Retrieval over your own documents, agents that complete a workflow end to end, '
                  . 'forecasting on your own history. Every AI feature ships with a boundary: what it '
                  . 'decides, what it only drafts, and where a human still signs.',
        'points' => ['Retrieval-augmented assistants on your data', 'Document and vision pipelines', 'Forecasting and anomaly detection', 'Agentic workflows with human sign-off'],
        'metric' => ['value' => '40%', 'label' => 'Manual effort removed'],
    ],
    [
        'num'    => '06',
        'icon'   => 'cloud',
        'stage'  => 'scale',
        'title'  => 'Cloud, DevOps & Managed Run',
        'body'   => 'Infrastructure as code, a pipeline that deploys on merge, monitoring that pages a '
                  . 'human before a customer notices, and a monthly bill you can read. We hand over the '
                  . 'keys — or keep running it, whichever costs you less.',
        'points' => ['AWS, Azure and GCP provisioning', 'CI/CD, IaC and environment parity', 'Observability, alerting and on-call', 'Cost engineering and rightsizing'],
        'metric' => ['value' => '99.9%', 'label' => 'Managed uptime'],
    ],
];

/**
 * The interactive build-mode switcher. Each mode swaps the mock window in the
 * panel beside it — the page's one properly interactive toy.
 */
const SOFT_MODES = [
    [
        'key'   => 'platform',
        'label' => 'Operations platform',
        'icon'  => 'layers',
        'title' => 'The system your operations team lives in',
        'body'  => 'Roles, approvals, audit trail, exports and the one screen that answers “where is my order”. Built once, fits exactly.',
        'chrome'=> 'ops.yourcompany.com',
        'rows'  => [
            ['label' => 'Open work orders',  'value' => '148',    'tone' => 'cyan'],
            ['label' => 'Awaiting approval', 'value' => '12',     'tone' => 'amber'],
            ['label' => 'SLA breaches',      'value' => '0',      'tone' => 'good'],
            ['label' => 'Sync — SAP',        'value' => 'Healthy','tone' => 'good'],
        ],
    ],
    [
        'key'   => 'saas',
        'label' => 'Multi-tenant SaaS',
        'icon'  => 'package',
        'title' => 'A product you can sell, not just use',
        'body'  => 'Tenancy, plans, metering, billing and per-customer configuration designed in from day one, because retrofitting tenancy is a rewrite.',
        'chrome'=> 'app.yourproduct.io',
        'rows'  => [
            ['label' => 'Active tenants',    'value' => '312',     'tone' => 'cyan'],
            ['label' => 'MRR',               'value' => '₹18.4L',  'tone' => 'good'],
            ['label' => 'Seats provisioned', 'value' => '4,880',   'tone' => 'plain'],
            ['label' => 'Plan changes today','value' => '7',       'tone' => 'purple'],
        ],
    ],
    [
        'key'   => 'ai',
        'label' => 'AI-native product',
        'icon'  => 'brain',
        'title' => 'Intelligence in the workflow, not in a chat box',
        'body'  => 'The model reads your documents, drafts the output and shows its source. A person approves. That boundary is the design, not a limitation.',
        'chrome'=> 'assist.yourcompany.com',
        'rows'  => [
            ['label' => 'Documents indexed', 'value' => '92,411',  'tone' => 'cyan'],
            ['label' => 'Drafts today',      'value' => '634',     'tone' => 'purple'],
            ['label' => 'Human approved',    'value' => '96%',     'tone' => 'good'],
            ['label' => 'Avg. handling time','value' => '−41%',    'tone' => 'good'],
        ],
    ],
    [
        'key'   => 'commerce',
        'label' => 'Commerce',
        'icon'  => 'cart',
        'title' => 'Storefronts that survive a campaign spike',
        'body'  => 'Catalogue, checkout, payments, returns and the inventory truth behind them — integrated with whatever runs your warehouse today.',
        'chrome'=> 'shop.yourbrand.com',
        'rows'  => [
            ['label' => 'Orders / hour',     'value' => '1,240',   'tone' => 'cyan'],
            ['label' => 'Checkout success',  'value' => '98.6%',   'tone' => 'good'],
            ['label' => 'p95 response',      'value' => '210ms',   'tone' => 'good'],
            ['label' => 'Stock mismatches',  'value' => '0',       'tone' => 'good'],
        ],
    ],
    [
        'key'   => 'field',
        'label' => 'Field & mobile',
        'icon'  => 'smartphone',
        'title' => 'Works where the signal does not',
        'body'  => 'Offline-first capture, queued sync, photo and signature evidence, and a back office that sees it the moment the device reconnects.',
        'chrome'=> 'field.yourcompany.com',
        'rows'  => [
            ['label' => 'Devices in field',  'value' => '86',      'tone' => 'cyan'],
            ['label' => 'Queued offline',    'value' => '31',      'tone' => 'amber'],
            ['label' => 'Synced today',      'value' => '2,104',   'tone' => 'good'],
            ['label' => 'Failed uploads',    'value' => '0',       'tone' => 'good'],
        ],
    ],
    [
        'key'   => 'data',
        'label' => 'Data & reporting',
        'icon'  => 'bar-chart',
        'title' => 'One number, one definition, one place',
        'body'  => 'A warehouse your finance and operations teams both agree with, and reporting that does not need a person to assemble it every Monday.',
        'chrome'=> 'insights.yourcompany.com',
        'rows'  => [
            ['label' => 'Pipelines green',   'value' => '24 / 24', 'tone' => 'good'],
            ['label' => 'Freshness',         'value' => '4 min',   'tone' => 'cyan'],
            ['label' => 'Reports automated', 'value' => '38',      'tone' => 'purple'],
            ['label' => 'Manual reconciles', 'value' => '—',       'tone' => 'plain'],
        ],
    ],
];

/** Twelve things that come with the build. `tag` renders as a chip. */
const SOFT_MATRIX = [
    ['icon' => 'git-branch', 'title' => 'Source in your repo',      'body' => 'Every commit, from day one, in an organisation you own.',            'tag' => 'Included'],
    ['icon' => 'shield',     'title' => 'Security review',          'body' => 'OWASP pass, dependency audit and secrets hygiene before release.',   'tag' => 'Included'],
    ['icon' => 'terminal',   'title' => 'CI/CD pipeline',           'body' => 'Tests, build and deploy on merge — no one ships from a laptop.',     'tag' => 'Included'],
    ['icon' => 'gauge',      'title' => 'Performance budgets',      'body' => 'Page and API budgets agreed up front and enforced in CI.',           'tag' => 'Included'],
    ['icon' => 'users',      'title' => 'Role-based access',        'body' => 'Permissions modelled on your org chart, with a real audit trail.',   'tag' => 'Included'],
    ['icon' => 'database',   'title' => 'Data migration',           'body' => 'Your existing records moved, reconciled and signed off.',            'tag' => 'Included'],
    ['icon' => 'refresh',    'title' => 'Zero-downtime releases',   'body' => 'Blue-green or rolling deploys, with a tested rollback path.',        'tag' => 'Included'],
    ['icon' => 'search',     'title' => 'Observability',            'body' => 'Logs, traces and dashboards that name the failing dependency.',      'tag' => 'Included'],
    ['icon' => 'edit',       'title' => 'Written handover',         'body' => 'Architecture, runbooks and decisions, not just inline comments.',    'tag' => 'Included'],
    ['icon' => 'brain',      'title' => 'AI feature layer',         'body' => 'Retrieval, drafting and agents scoped to your own data.',            'tag' => 'On scope'],
    ['icon' => 'lock',       'title' => 'Compliance support',       'body' => 'DPDP, HIPAA-aligned and SOC 2 evidence work alongside your auditor.','tag' => 'On scope'],
    ['icon' => 'wrench',     'title' => 'Managed run & on-call',    'body' => 'We keep operating it after launch, on a monthly retainer.',          'tag' => 'Optional'],
];

/** The seven stages, drawn as a scroll-driven pipeline. */
const SOFT_PROCESS = [
    ['title' => 'Ideation',              'body' => 'We interrogate the problem before the solution. What is the cost of the current workflow, in hours and in errors, and what would “fixed” look like on a Tuesday?'],
    ['title' => 'Project planning',      'body' => 'Scope split into releases, each one shippable. Milestones, owners, dependencies and the assumptions the estimate rests on, written down where you can argue with them.'],
    ['title' => 'Design & architecture', 'body' => 'Data model, service boundaries, integration contracts and interface design, reviewed together. The expensive mistakes are all made at this stage — so this is where we go slowly.'],
    ['title' => 'Development',           'body' => 'Two-week iterations against a live environment you can open. Working software every fortnight beats a status report every week.'],
    ['title' => 'Testing & QA',          'body' => 'Automated regression, integration tests against real sandboxes, load tests at your expected peak, and a manual pass on the workflows that carry money.'],
    ['title' => 'Launch',                'body' => 'Migration rehearsed on a copy of production, cutover run to a checklist, rollback tested before it is needed. Training for the people who will use it daily.'],
    ['title' => 'Support & evolution',   'body' => 'Monitoring, an SLA, and a roadmap that keeps moving. Most of our clients are on their third or fourth release with us, not their first.'],
];

/** Emerging-tech capability blocks. */
const SOFT_TECHNOLOGIES = [
    ['icon' => 'brain',    'title' => 'AI & Machine Learning',  'body' => 'Retrieval over private documents, forecasting on your own history, computer vision on the line, and agents that finish a task rather than suggest one.'],
    ['icon' => 'cpu',      'title' => 'IoT & Connected Devices','body' => 'Telemetry ingestion, device registries, edge buffering and dashboards that survive a factory network dropping for an hour.'],
    ['icon' => 'globe',    'title' => 'AR & Immersive',         'body' => 'Product configurators, guided maintenance overlays and WebGL experiences that run in a browser without an app install.'],
    ['icon' => 'lock',     'title' => 'Blockchain & Ledgers',   'body' => 'Provenance, tamper-evident audit trails and settlement rails — used where an immutable record genuinely earns its cost.'],
    ['icon' => 'workflow', 'title' => 'Robotic Process Automation', 'body' => 'The bridge for systems with no API: UI automation and document robots that retire a repetitive job without a vendor migration.'],
];

/** Stack, grouped the way an engineer would answer the question. */
const SOFT_STACK = [
    ['title' => 'Backend',        'icon' => 'terminal', 'items' => ['Python', 'Django', 'FastAPI', 'Node.js', 'PHP / Laravel', 'Java', '.NET', 'Go']],
    ['title' => 'Front end',      'icon' => 'monitor',  'items' => ['React', 'Next.js', 'Vue', 'TypeScript', 'Tailwind', 'Three.js', 'Vite', 'HTMX']],
    ['title' => 'Mobile',         'icon' => 'smartphone','items' => ['Flutter', 'React Native', 'Swift', 'Kotlin', 'Expo', 'Ionic']],
    ['title' => 'Data',           'icon' => 'database', 'items' => ['PostgreSQL', 'MySQL', 'MongoDB', 'Redis', 'ClickHouse', 'BigQuery', 'Elasticsearch', 'pgvector']],
    ['title' => 'AI & ML',        'icon' => 'brain',    'items' => ['Claude', 'OpenAI', 'LangGraph', 'PyTorch', 'scikit-learn', 'Hugging Face', 'Whisper', 'OpenCV']],
    ['title' => 'Cloud & DevOps', 'icon' => 'cloud',    'items' => ['AWS', 'Azure', 'GCP', 'Docker', 'Kubernetes', 'Terraform', 'GitHub Actions', 'Grafana']],
];

/** Custom vs packaged, as a comparison table rather than a sales claim. */
const SOFT_COMPARE = [
    'title' => 'Custom build or off-the-shelf?',
    'lead'  => 'Sometimes the honest answer is that you should buy the licence. Here is where the line actually falls.',
    'cols'  => ['Custom software', 'Off-the-shelf'],
    'rows'  => [
        ['label' => 'Fit to your workflow',   'custom' => 'Modelled on how your team already works',        'shelf' => 'Your team changes to fit the product'],
        ['label' => 'Cost shape',             'custom' => 'Higher up front, no per-seat escalation',        'shelf' => 'Low to start, grows with every seat and module'],
        ['label' => 'Integration',            'custom' => 'Built into your existing systems by design',     'shelf' => 'Whatever the vendor’s connector supports'],
        ['label' => 'Data & compliance',      'custom' => 'Your infrastructure, your residency, your audit','shelf' => 'Vendor’s region and vendor’s retention policy'],
        ['label' => 'Change requests',        'custom' => 'A sprint',                                       'shelf' => 'A feature request on someone else’s roadmap'],
        ['label' => 'Ownership',              'custom' => 'Source, data and deployment are yours',          'shelf' => 'Access ends when the subscription does'],
        ['label' => 'Best when',              'custom' => 'The workflow is your competitive advantage',      'shelf' => 'The workflow is genuinely commodity'],
    ],
];

/** Engagement models. */
const SOFT_MODELS = [
    [
        'icon'  => 'target',
        'title' => 'Fixed scope, fixed price',
        'body'  => 'For work that can be specified precisely — a defined integration, a migration, a first release with a locked feature list.',
        'meta'  => ['Best for defined scope', 'Milestone billing', 'Change requests priced separately'],
    ],
    [
        'icon'  => 'gauge',
        'title' => 'Time & materials',
        'body'  => 'For products that will learn from their own users. You get a rate card, a monthly cap and the ability to change direction between iterations without a contract amendment.',
        'meta'  => ['Best for evolving products', 'Monthly cap agreed up front', 'Stop or scale any month'],
    ],
    [
        'icon'  => 'users',
        'title' => 'Dedicated team',
        'body'  => 'A named squad — engineers, QA, a lead — working only on your product, in your tools and your stand-up. Extends your team without the hiring cycle.',
        'meta'  => ['Best for a long roadmap', 'Named people, not a pool', 'Monthly per-seat rate'],
    ],
];

/** Industries. */
const SOFT_INDUSTRIES = [
    ['icon' => 'stethoscope', 'label' => 'Healthcare'],
    ['icon' => 'car',         'label' => 'Mobility & logistics'],
    ['icon' => 'cart',        'label' => 'Retail & eCommerce'],
    ['icon' => 'factory',     'label' => 'Manufacturing'],
    ['icon' => 'building',    'label' => 'Real estate'],
    ['icon' => 'bar-chart',   'label' => 'Finance & fintech'],
    ['icon' => 'lightbulb',   'label' => 'EdTech'],
    ['icon' => 'utensils',    'label' => 'Food & hospitality'],
    ['icon' => 'plane',       'label' => 'Travel'],
    ['icon' => 'drone',       'label' => 'Drones & field ops'],
    ['icon' => 'heart',       'label' => 'Non-profit'],
    ['icon' => 'package',     'label' => 'B2B SaaS'],
];

/** Why us — six, each with something checkable behind it. */
const SOFT_WHY = [
    ['icon' => 'users',       'title' => 'Seniors stay on the project',  'body' => 'The engineer who scoped your build writes the first commit. No pitch team, no handover to a bench.'],
    ['icon' => 'code',        'title' => 'You own everything',           'body' => 'Repository, infrastructure accounts, domains and data are in your name from the first week, not transferred at the end.'],
    ['icon' => 'brain',       'title' => 'AI as engineering, not garnish','body' => 'We ship AI where it removes work and say so plainly where it would only add risk.'],
    ['icon' => 'clock',       'title' => 'Fortnightly working software',  'body' => 'Every two weeks there is a URL you can open. Progress is demonstrated, not reported.'],
    ['icon' => 'shield',      'title' => 'Security is part of the build', 'body' => 'Threat model at design, dependency and OWASP review before launch, secrets never in the repo.'],
    ['icon' => 'trending-up', 'title' => 'We stay after launch',          'body' => 'Most clients are on their third or fourth release with us. Software that no one maintains starts rotting in month two.'],
];

/**
 * Indicative investment bands. These are conversation-starters, deliberately
 * shown as ranges with the assumptions attached.
 */
const SOFT_INVESTMENT = [
    'note' => 'Indicative bands for planning, not a quote. A real number needs a scope conversation — '
            . 'the same build costs very differently with two integrations than with nine.',
    'tiers' => [
        ['tier' => 'Essential',  'range' => '₹4L – ₹9L',    'time' => '6–10 weeks',  'best' => 'A first release, an internal tool, or one workflow automated end to end.',    'items' => ['Up to 3 core modules', '1–2 integrations', 'Single tenant', 'Cloud deploy + CI/CD', '1 month post-launch support']],
        ['tier' => 'Growth',     'range' => '₹10L – ₹25L',  'time' => '3–5 months',  'best' => 'A production platform several teams depend on, or a SaaS product with paying tenants.', 'items' => ['6–12 modules', 'Role-based access & audit', 'Multi-tenant or multi-branch', 'Data migration', 'Observability + SLA', '3 months support'], 'featured' => true],
        ['tier' => 'Enterprise', 'range' => '₹25L+',        'time' => '6 months+',   'best' => 'Core systems, regulated environments, or a dedicated squad on a long roadmap.',   'items' => ['Bespoke architecture', 'Complex integration estate', 'AI/ML components', 'Compliance evidence', 'HA and DR', 'Managed run & on-call']],
    ],
];

/** Rough industry timings, for the table under the investment bands. */
const SOFT_TIMELINE = [
    ['sector' => 'Retail & eCommerce',   'basic' => '₹4L – ₹8L',   'advanced' => '₹18L – ₹40L', 'time' => '8–20 weeks'],
    ['sector' => 'Healthcare',           'basic' => '₹6L – ₹12L',  'advanced' => '₹25L – ₹60L', 'time' => '12–28 weeks'],
    ['sector' => 'Finance & fintech',    'basic' => '₹8L – ₹15L',  'advanced' => '₹30L – ₹75L', 'time' => '14–30 weeks'],
    ['sector' => 'Logistics & mobility', 'basic' => '₹5L – ₹10L',  'advanced' => '₹20L – ₹45L', 'time' => '10–24 weeks'],
    ['sector' => 'Manufacturing',        'basic' => '₹6L – ₹11L',  'advanced' => '₹22L – ₹50L', 'time' => '12–26 weeks'],
    ['sector' => 'Real estate',          'basic' => '₹4L – ₹8L',   'advanced' => '₹15L – ₹35L', 'time' => '8–18 weeks'],
    ['sector' => 'Education',            'basic' => '₹4L – ₹9L',   'advanced' => '₹16L – ₹38L', 'time' => '8–20 weeks'],
    ['sector' => 'Enterprise internal',  'basic' => '₹5L – ₹10L',  'advanced' => '₹20L – ₹55L', 'time' => '10–26 weeks'],
];

/** What actually moves the number. */
const SOFT_COST_FACTORS = [
    ['icon' => 'layers',    'title' => 'System complexity',   'body' => 'One workflow with clear rules is cheap. Six workflows that disagree with each other is where the cost lives.'],
    ['icon' => 'workflow',  'title' => 'Integrations',        'body' => 'Every external system adds contract work, sandbox access, error handling and a failure mode to design for.'],
    ['icon' => 'brain',     'title' => 'AI components',       'body' => 'Retrieval on clean documents is quick. Extraction from scanned, inconsistent paperwork is a project of its own.'],
    ['icon' => 'shield',    'title' => 'Compliance',          'body' => 'Regulated data brings audit trails, residency, retention rules and evidence — real engineering, not paperwork.'],
    ['icon' => 'users',     'title' => 'Concurrency & scale', 'body' => 'A hundred internal users and a hundred thousand public ones are different architectures, not different server sizes.'],
    ['icon' => 'refresh',   'title' => 'Migration',           'body' => 'Moving a decade of records with inconsistent history is often the largest single line in the estimate.'],
];

/** FAQ — also emitted as FAQPage structured data. */
const SOFT_FAQ = [
    ['q' => 'How do I know whether we need custom software at all?',
     'a' => 'Start with the workflow, not the software. If the process that costs you the most time is one a packaged tool models well, buy the tool — we will tell you so. Custom is worth it when the workflow is specific to how you compete, when you are paying for integration workarounds every month, or when per-seat licensing has quietly become larger than a build would have been.'],

    ['q' => 'What does custom software development cost in Chennai?',
     'a' => 'A focused first release generally lands between ₹4L and ₹9L; a production platform several teams depend on between ₹10L and ₹25L; core enterprise systems above ₹25L. The variables that move the number most are the count of integrations, whether the data has to be migrated, and whether the environment is regulated. We give a written estimate with the assumptions listed, so you can see what would change it.'],

    ['q' => 'How long does a project take?',
     'a' => 'Discovery is about two weeks. A first production release is typically six to fourteen weeks after that, depending on scope. You see working software every fortnight throughout, so the timeline is visible rather than promised.'],

    ['q' => 'Can you integrate with the systems we already run?',
     'a' => 'Yes — that is most of what enterprise work is. We integrate with ERPs, CRMs, accounting packages, payment gateways, logistics partners and hardware on the floor. Where a system has no API, we use file, database or UI-level automation and put a proper contract layer in front of it so the rest of your software does not have to know.'],

    ['q' => 'Who owns the code and the data?',
     'a' => 'You do, from the first week. The repository sits in your organisation, cloud accounts are in your name, and domains and data never route through us. There is no escrow clause because there is nothing to escrow.'],

    ['q' => 'How do you handle security?',
     'a' => 'Threat modelling during design, least-privilege access, encryption in transit and at rest, secrets in a managed store rather than the repository, dependency scanning in CI, and an OWASP-aligned review before launch. For regulated work we produce the evidence your auditor asks for and sit in that review with you.'],

    ['q' => 'What happens after launch?',
     'a' => 'Either we hand over — with runbooks, architecture documentation and a training session — or we keep running it on a monthly retainer with monitoring, an SLA and a continuing roadmap. Both are normal; the choice is usually about whether you have an internal team to receive it.'],

    ['q' => 'Do you work with startups or only enterprises?',
     'a' => 'Both. For startups the useful shape is a tight first release aimed at proving one thing, then iterating on what real users do. For enterprises it is usually modernisation or a platform several departments depend on. The engineering discipline is the same; the sequencing is not.'],

    ['q' => 'Can you take over software someone else built?',
     'a' => 'Regularly. We start with a paid audit — architecture, dependency and security review, plus an honest assessment of what should be kept. Taking over a codebase without that audit is how a rescue becomes a rewrite by accident.'],

    ['q' => 'Where do you work from, and does that matter?',
     'a' => 'Our studios are in Coimbatore and Chennai, and we deliver across India, the Gulf and the United States. It matters mainly for the first phase: being able to sit in a room with the people whose workflow you are modelling makes discovery considerably better.'],
];

const SOFT_CTA = [
    'eyebrow'   => 'Start Your Project',
    'title'     => 'Describe the workflow, not the software.',
    'body'      => 'Send a paragraph about the process that is costing you the most time. You will get a '
                 . 'written build plan — scope, stack, sequence and a realistic timeline — inside two working days.',
    'primary'   => ['label' => 'Start your project',    'href' => 'contact.php'],
    'secondary' => ['label' => 'Read the case studies', 'href' => 'case-studies.php'],
];
