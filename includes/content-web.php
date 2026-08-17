<?php
/**
 * Copy for the Web Development service page.
 *
 * Split out of content.php because this one page carries more copy than the
 * whole service catalogue put together — it is the page meant to rank for
 * "website development company in Chennai" and its sibling city terms, and
 * ranking for those means actually answering the questions people ask before
 * they enquire, at length, in words a crawler and an answer engine can read.
 *
 * The section order follows what the Chennai market already publishes — the
 * pattern is consistent across zerozilla, jayamwebsolutions and istudiotech:
 * value proposition, what you get, how it runs, proof, stack, industries,
 * pricing shape, locations, questions. What is different here is that the
 * claims are specific and checkable rather than superlative.
 */

declare(strict_types=1);

const WEB_HERO = [
    'eyebrow' => 'Website Development Company in Chennai, Coimbatore & Bangalore',
    'title'   => 'Websites engineered to load fast, rank well and keep working',
    'lead'    => 'iThrive Software builds custom websites, web applications and e-commerce platforms for '
               . 'businesses across Chennai, Coimbatore, Bangalore and the rest of India — server-rendered, '
               . 'accessible, and measured against Core Web Vitals before they ship.',
    'primary'   => ['label' => 'Get a Website Quote', 'href' => 'contact.php'],
    'secondary' => ['label' => 'Walk Through Our Work', 'href' => '#work'],
];

/** Counters under the hero. Every figure here is one we can point at. */
const WEB_STATS = [
    ['value' => '90+',      'label' => 'Lighthouse performance target, enforced in CI'],
    ['value' => '8',        'label' => 'Live client websites in this portfolio'],
    ['value' => '3',        'label' => 'Delivery studios — Chennai, Coimbatore, Bangalore'],
    ['value' => 'WCAG 2.2', 'label' => 'AA accessibility baseline on every build'],
];

/**
 * The rooms the visitor walks through. Each one is a real page section; the
 * 3D walkthrough behind the page uses these to know where the camera is and
 * what to light, so the list is the single source of truth for both.
 */
const WEB_ROOMS = [
    ['id' => 'brief',     'label' => 'The Brief',      'hue' => 188],
    ['id' => 'build',     'label' => 'The Workshop',   'hue' => 206],
    ['id' => 'process',   'label' => 'The Line',       'hue' => 224],
    ['id' => 'work',      'label' => 'The Gallery',    'hue' => 258],
    ['id' => 'stack',     'label' => 'The Engine Room','hue' => 276],
    ['id' => 'industries','label' => 'The Floor',      'hue' => 292],
    ['id' => 'locations', 'label' => 'The Map Room',   'hue' => 310],
];

const WEB_INTRO = [
    'eyebrow' => 'Why It Matters',
    'title'   => 'Your website is the only salesperson that never sleeps',
    'body'    => [
        'For most businesses in Tamil Nadu the website is no longer the brochure — it is the first '
        . 'meeting. Someone searches, lands, and decides within a few seconds whether you look like a '
        . 'company worth calling. That judgement is made on load speed, clarity and whether the thing '
        . 'works on the phone they are holding, long before anyone reads your About page.',

        'It is also the only marketing asset you own outright. Rented reach on social platforms changes '
        . 'with every algorithm update; a website that ranks keeps earning. That is why we treat search '
        . 'visibility, accessibility and performance as engineering constraints written into the build, '
        . 'not as a clean-up phase after launch when the budget has already gone.',
    ],
];

/**
 * What we actually build. Ten entries, because that is the shape of the
 * category and a visitor arriving from a long-tail search needs to find their
 * exact phrase on the page.
 */
const WEB_SERVICES = [
    [
        'icon'  => 'globe',
        'title' => 'Custom Website Development',
        'body'  => 'Bespoke websites built from a design system rather than a purchased theme, so the '
                 . 'tenth page costs a fraction of the first and nothing breaks when you edit it.',
    ],
    [
        'icon'  => 'layers',
        'title' => 'Responsive Web Design',
        'body'  => 'One codebase that holds its layout from a 360px budget Android to an ultrawide '
                 . 'desktop, tested on real viewport sizes rather than a designer\'s three artboards.',
    ],
    [
        'icon'  => 'code',
        'title' => 'Web Application Development',
        'body'  => 'Dashboards, portals, booking engines and internal tools — stateful products that '
                 . 'happen to run in a browser, with authentication, roles and audit trails.',
    ],
    [
        'icon'  => 'cart',
        'title' => 'E-Commerce Website Development',
        'body'  => 'Storefronts with UPI, Razorpay and COD reconciliation, stock that stays truthful '
                 . 'during a spike, and a checkout measured on completion rate rather than looks.',
    ],
    [
        'icon'  => 'edit',
        'title' => 'CMS & WordPress Development',
        'body'  => 'Editing interfaces your marketing team can use without a developer — preview, '
                 . 'scheduled publishing and roles — on WordPress, a headless CMS, or a custom admin.',
    ],
    [
        'icon'  => 'refresh',
        'title' => 'Website Redesign & Migration',
        'body'  => 'Rebuilding a dated site without losing the rankings it already has: redirect maps, '
                 . 'preserved URL structure and a staged cutover instead of a Friday-night switch.',
    ],
    [
        'icon'  => 'search',
        'title' => 'Technical SEO Implementation',
        'body'  => 'Server-rendered markup, structured data, clean URLs, sitemaps and hreflang built '
                 . 'into the framework — the part of SEO that is engineering, not content.',
    ],
    [
        'icon'  => 'gauge',
        'title' => 'Core Web Vitals & Speed Optimisation',
        'body'  => 'LCP, INP and CLS treated as build-failing budgets. If a pull request makes the site '
                 . 'slower than the agreed threshold, it does not merge.',
    ],
    [
        'icon'  => 'shield',
        'title' => 'Web Accessibility (WCAG 2.2 AA)',
        'body'  => 'Keyboard paths, focus management, contrast and screen-reader semantics tested with '
                 . 'real assistive technology, not asserted by a plugin badge in the footer.',
    ],
    [
        'icon'  => 'wrench',
        'title' => 'Website Maintenance & Support',
        'body'  => 'Patching, uptime monitoring, backups and a named engineer who answers — an ongoing '
                 . 'retainer rather than a number that stops working after handover.',
    ],
];

/** HowTo schema is generated from this, so the steps are written to be read aloud. */
const WEB_PROCESS = [
    [
        'title' => 'Discovery and requirement mapping',
        'body'  => 'We start with what the site has to achieve commercially — enquiries, orders, '
                 . 'bookings — then work backwards to pages, content and integrations. You get a written '
                 . 'scope with a fixed price and a delivery date before anything is designed.',
        'days'  => '3–5 days',
    ],
    [
        'title' => 'Information architecture and wireframes',
        'body'  => 'Page structure, navigation and URL hierarchy agreed as low-fidelity wireframes. '
                 . 'Doing this before visual design is what keeps SEO structure and content from being '
                 . 'retrofitted later.',
        'days'  => '4–6 days',
    ],
    [
        'title' => 'Visual design and prototype',
        'body'  => 'A design system — type scale, colour tokens, components — rather than a stack of '
                 . 'page mockups, delivered as a clickable prototype so you can use the site before it '
                 . 'is built.',
        'days'  => '1–2 weeks',
    ],
    [
        'title' => 'Development and integration',
        'body'  => 'Front end and back end built together in two-week sprints against a staging URL you '
                 . 'can open any day. Payments, CRM, WhatsApp, analytics and CMS wired as they land.',
        'days'  => '3–6 weeks',
    ],
    [
        'title' => 'Testing, performance and accessibility',
        'body'  => 'Cross-browser and real-device testing, Lighthouse budgets enforced in CI, WCAG 2.2 '
                 . 'AA audit, and a full SEO pass — redirects, schema, sitemap, robots — before launch.',
        'days'  => '5–8 days',
    ],
    [
        'title' => 'Launch and ongoing support',
        'body'  => 'DNS cutover with rollback ready, Search Console and analytics verified on day one, '
                 . 'then a support retainer with a named engineer rather than a ticket queue.',
        'days'  => 'Ongoing',
    ],
];

/**
 * The portfolio. Screenshots are captured from the live sites; the shot files
 * live in assets/img/work. `tint` seeds the gallery tile glow so each project
 * reads distinctly while the canvas is still loading.
 */
const WEB_WORK = [
    [
        'slug' => 'coonoor-club', 'name' => 'Coonoor Club', 'url' => 'https://www.coonoorclub.com/',
        'kind' => 'Heritage club platform', 'year' => '2026', 'tint' => '#C8A24A',
        'note' => 'Membership, room booking and event management for a club established in 1885, with a members-only area behind authentication.',
    ],
    [
        'slug' => 'lotus-eye', 'name' => 'Lotus Eye Hospital', 'url' => 'https://www.lotuseye.org/',
        'kind' => 'Multi-branch hospital', 'year' => '2026', 'tint' => '#1BA6DF',
        'note' => 'Appointment booking across branches, treatment and doctor directories, and a structured-data layout built to rank for clinical searches.',
    ],
    [
        'slug' => 'cute-crew', 'name' => 'Cute Crew', 'url' => 'https://cute-crew.vercel.app/',
        'kind' => 'Kids fashion e-commerce', 'year' => '2026', 'tint' => '#F2649B',
        'note' => 'Catalogue with variant modelling, faceted search and a checkout built around completion rate for boys, girls, newborn and toddler ranges.',
    ],
    [
        'slug' => 'central-adventures', 'name' => 'Central Adventures', 'url' => 'https://centraladventures.in/',
        'kind' => 'Travel and holidays', 'year' => '2026', 'tint' => '#2FA36B',
        'note' => 'Tour packages, itinerary pages and enquiry capture for a travel operator, with content structured so each destination earns its own search entry.',
    ],
    [
        'slug' => 'madura-grandeur', 'name' => 'Madura Grandeur', 'url' => 'https://maduragrandeur.com/',
        'kind' => 'Hospitality', 'year' => '2026', 'tint' => '#B8863B',
        'note' => 'Rooms, tariffs and direct booking enquiry for a hotel — built to convert visitors before they reach an aggregator that charges commission.',
    ],
    [
        'slug' => 'bharani-beauty', 'name' => 'Bharani Beauty Clinic', 'url' => 'https://bharanibeautyclinic.com/',
        'kind' => 'Beauty and makeup studio', 'year' => '2026', 'tint' => '#D9557F',
        'note' => 'Service menus, bridal packages and appointment enquiry for a premium makeup studio, tuned for local search and mobile-first traffic.',
    ],
    [
        'slug' => 'aruvanaa', 'name' => 'Aruvanaa', 'url' => 'https://aruvanaa.com/',
        'kind' => 'Brand website', 'year' => '2026', 'tint' => '#6E56CF',
        'note' => 'A brand-led marketing site with a component library behind it, so new campaign pages ship without a developer rebuilding the layout.',
    ],
    [
        'slug' => 'logisethu', 'name' => 'LogiSethu', 'url' => null,
        'kind' => 'Logistics platform', 'year' => '2026', 'tint' => '#00C2A8',
        'note' => 'A corporate platform for a logistics operator, with a scroll-driven 3D hero and a film-led narrative running through the service pages.',
    ],
];

/**
 * Sectors, as an icon wall.
 *
 * Each entry names a line icon drawn in functions.php. The body copy is not
 * shown until the tile is hovered — the grid reads as a wall of marks, and the
 * detail arrives when you point at one, which is what the reference does.
 */
const WEB_INDUSTRIES = [
    ['icon' => 'stethoscope', 'title' => 'Healthcare',    'body' => 'Appointment flows, doctor directories and branch pages with medical structured data.'],
    ['icon' => 'building',    'title' => 'Hospitality',   'body' => 'Direct booking enquiry that keeps margin away from aggregator commissions.'],
    ['icon' => 'cart',        'title' => 'Retail',        'body' => 'Catalogue, checkout and stock truth across every channel you sell on.'],
    ['icon' => 'lightbulb',   'title' => 'Education',     'body' => 'Admissions journeys, course catalogues and parent-facing announcements.'],
    ['icon' => 'factory',     'title' => 'Manufacturing', 'body' => 'Product catalogues, spec sheets and distributor enquiry routing.'],
    ['icon' => 'car',         'title' => 'Logistics',     'body' => 'Tracking portals, rate enquiry and operations dashboards behind login.'],
    ['icon' => 'plane',       'title' => 'Travel',        'body' => 'Itineraries and destination pages structured to earn their own search entries.'],
    ['icon' => 'target',      'title' => 'Professional',  'body' => 'Credibility-led sites where the enquiry form is the entire conversion.'],
    ['icon' => 'utensils',    'title' => 'Food',          'body' => 'Menus, ordering and delivery windows that survive a Friday-night rush.'],
    ['icon' => 'heart',       'title' => 'Wellness',      'body' => 'Class timetables, memberships and bookings that fill quiet hours.'],
    ['icon' => 'shirt',       'title' => 'Fashion',       'body' => 'Variant-heavy catalogues and lookbooks that load fast on a phone.'],
    ['icon' => 'drone',       'title' => 'Aerospace',     'body' => 'Technical product pages, training programmes and compliance documentation.'],
];

/** Engagement shapes, so the pricing question is answered before it is asked. */
const WEB_TIERS = [
    [
        'name'  => 'Business Website',
        'price' => '₹65,000 – ₹1,50,000',
        'time'  => '3–5 weeks',
        'for'   => 'Firms that need a credible, fast, findable presence.',
        'items' => ['Up to 12 pages', 'Design system and CMS', 'Technical SEO and schema', 'Core Web Vitals budget', 'Enquiry forms and analytics'],
    ],
    [
        'name'  => 'E-Commerce Platform',
        'price' => '₹1,80,000 – ₹4,50,000',
        'time'  => '6–10 weeks',
        'for'   => 'Retailers selling direct with real inventory.',
        'items' => ['Catalogue and variants', 'UPI, Razorpay, COD', 'Order and stock management', 'Faceted search', 'Abandoned-cart recovery'],
        'featured' => true,
    ],
    [
        'name'  => 'Web Application',
        'price' => '₹3,50,000 – ₹9,00,000',
        'time'  => '8–16 weeks',
        'for'   => 'Portals, dashboards and internal tools.',
        'items' => ['Authentication and roles', 'Custom business logic', 'Third-party integrations', 'Audit trails', 'Cloud deployment and CI/CD'],
    ],
];

/**
 * Location copy. Each city gets a real paragraph rather than a swapped noun,
 * because a page that says the same sentence three times with the city changed
 * is the pattern search engines have been demoting for years.
 */
const WEB_LOCATIONS = [
    [
        'city'    => 'Chennai',
        'region'  => 'Tamil Nadu',
        'heading' => 'Website Development Company in Chennai',
        'body'    => 'Chennai is where most of our enquiries start — manufacturing exporters on the GST '
                   . 'Road corridor, hospitals and clinics across the city, and retailers who have '
                   . 'outgrown a marketplace-only presence. We work with Chennai clients on-site for '
                   . 'discovery and design sign-off, then remotely through delivery.',
    ],
    [
        'city'    => 'Coimbatore',
        'region'  => 'Tamil Nadu',
        'heading' => 'Website Development Company in Coimbatore',
        'body'    => 'Our Coimbatore studio serves the textile, engineering and education businesses of '
                   . 'the Kongu belt, along with hospitality across the Nilgiris. Coonoor Club and '
                   . 'Madura Grandeur were both built out of this office.',
    ],
    [
        'city'    => 'Bangalore',
        'region'  => 'Karnataka',
        'heading' => 'Website Development Company in Bangalore',
        'body'    => 'For Bangalore we mostly build product surfaces rather than brochures — marketing '
                   . 'sites that ship campaign pages without engineering time, documentation portals, '
                   . 'and dashboards for funded startups that need to look established quickly.',
    ],
];

const WEB_WHY = [
    ['title' => 'A fixed price before we start',      'body' => 'Written scope, fixed cost and a delivery date agreed up front. Change requests are quoted separately rather than absorbed silently and blamed at the end.'],
    ['title' => 'Senior engineers, not a junior bench','body' => 'The people in your discovery call write the code. There is no handoff to a trainee team after the contract is signed.'],
    ['title' => 'You own everything',                 'body' => 'Code, domain, hosting and content are yours from day one, in your own repositories and accounts. No hostage hosting and no licence you have to keep renting.'],
    ['title' => 'Speed is a contract term',           'body' => 'Core Web Vitals thresholds are written into the scope and enforced in CI, so "we will optimise it later" never becomes your problem.'],
    ['title' => 'Built to be edited',                 'body' => 'Every site ships with a CMS your team can actually operate, and a handover session recorded so the knowledge does not leave with one person.'],
    ['title' => 'Support that answers',               'body' => 'A named engineer, an agreed response window, and a maintenance retainer that covers patching, backups and uptime monitoring.'],
];

/**
 * FAQ. This is the AEO surface — the answers are written to be quotable in
 * full by an assistant, which means each one is self-contained, names the
 * company, and carries a real number wherever a number exists.
 */
const WEB_FAQ = [
    [
        'q' => 'How much does website development cost in Chennai?',
        'a' => 'A business website from iThrive Software costs between ₹65,000 and ₹1,50,000 and takes '
             . 'three to five weeks. An e-commerce platform runs ₹1,80,000 to ₹4,50,000 over six to ten '
             . 'weeks, and a custom web application ₹3,50,000 to ₹9,00,000 over eight to sixteen weeks. '
             . 'The price is fixed in writing before work starts, and covers design, development, '
             . 'technical SEO, accessibility testing and launch.',
    ],
    [
        'q' => 'How long does it take to build a website?',
        'a' => 'Three to five weeks for a business website, six to ten weeks for an e-commerce store, '
             . 'and eight to sixteen weeks for a web application. The largest variable is content: '
             . 'projects where copy and photography are ready typically finish at the shorter end of '
             . 'the range.',
    ],
    [
        'q' => 'Do you work with businesses outside Chennai and Coimbatore?',
        'a' => 'Yes. iThrive Software delivers to clients across Tamil Nadu, Bangalore and the rest of '
             . 'India, and has studios in Chennai, Coimbatore and Bangalore. Discovery and design '
             . 'sign-off can be done on-site for clients in those three cities; delivery runs remotely '
             . 'against a staging URL you can open at any time.',
    ],
    [
        'q' => 'Will my website rank on Google?',
        'a' => 'The engineering that ranking depends on is included: server-rendered markup, structured '
             . 'data, clean URL structure, sitemaps, redirects and Core Web Vitals inside Google\'s '
             . 'thresholds. No agency can honestly promise a position, because ranking also depends on '
             . 'content, competition and domain history — but the technical foundation is built in '
             . 'rather than sold back to you later.',
    ],
    [
        'q' => 'Do I own the website and the code?',
        'a' => 'Yes, completely. Code, domain, hosting accounts and content belong to you from day one '
             . 'and live in your own repositories and accounts. iThrive Software does not hold your '
             . 'domain, does not use proprietary licences you have to keep renting, and hands over full '
             . 'access at launch.',
    ],
    [
        'q' => 'Can you redesign my existing website without losing my Google rankings?',
        'a' => 'Yes. A redesign begins with a crawl of the existing site to record every indexed URL, '
             . 'then a redirect map that preserves them. URL structure is kept wherever it already works, '
             . 'and the cutover is staged with rollback ready rather than switched over in one go.',
    ],
    [
        'q' => 'What technology do you build websites with?',
        'a' => 'Mostly Python with Django or FastAPI on the back end, React or server-rendered PHP on '
             . 'the front end, PostgreSQL for data, and Nginx with Cloudflare in front. WordPress is '
             . 'used when a client\'s team already knows it and the site is content-led. The stack is '
             . 'chosen for what the project needs, not for what is fashionable.',
    ],
    [
        'q' => 'Do you provide website maintenance after launch?',
        'a' => 'Yes. Maintenance retainers cover security patching, backups, uptime monitoring, content '
             . 'updates and a named engineer with an agreed response window. Sites launched without a '
             . 'retainer still receive a 30-day defect warranty.',
    ],
    [
        'q' => 'Will my website work properly on mobile phones?',
        'a' => 'Every site is built mobile-first and tested on real devices, not just a resized desktop '
             . 'browser. Layouts hold from a 360-pixel Android screen upward, and performance budgets '
             . 'are measured on a mid-range device on 4G rather than on a developer\'s laptop.',
    ],
    [
        'q' => 'Can you integrate payments, WhatsApp and my CRM?',
        'a' => 'Yes. Razorpay, Stripe, UPI and cash-on-delivery reconciliation, WhatsApp Business '
             . 'enquiry routing, and CRM integrations including Zoho, HubSpot and Salesforce are all '
             . 'standard work. Integrations are wired during development sprints rather than bolted on '
             . 'after launch.',
    ],
];
