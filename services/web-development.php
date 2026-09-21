<?php
/**
 * Web Development — the second page that leaves the shared service layout.
 *
 * It earns the exception the same way the mobile page did: this is the page
 * meant to rank for "website development company in Chennai" and its sibling
 * city terms, which needs far more copy, far more structured data and a set of
 * sections the shared template has no concept of.
 *
 * The scroll experience is a walkthrough. Each section carries data-room, and
 * assets/js/web-rooms.js turns those into rooms in a 3D corridor behind the
 * page — scrolling walks a figure forward, and each section plays its entrance
 * as the figure arrives. Every word stays real HTML in front of the canvas:
 * text inside a WebGL context is text no crawler and no answer engine reads,
 * which would defeat the point of the page.
 *
 * Copy lives in includes/content-web.php.
 */

declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/config.php';

$svc = service('web-development');

$page      = 'services';
$pageTitle = 'Web Development Company in India';
$pageDesc  = 'Custom websites, web apps and e-commerce platforms built in Chennai, Coimbatore and Bangalore for clients across India and abroad — fast and built to rank.';
$ogImage   = 'service-' . $svc['group_slug'];

/**
 * The structured data does the heavy lifting for AEO. Five things are declared:
 * the service itself with its catalogue, the price tiers as real Offers, the
 * six-step build as a HowTo, the ten answers as a FAQPage, and each studio as
 * a LocalBusiness so the city queries have somewhere to land.
 */
$schema = [
    '@type'       => 'Service',
    'name'        => 'Website Development',
    'serviceType' => 'Web Development',
    'description' => WEB_HERO['lead'],
    'url'         => canonical('services/web-development.php'),
    'provider'    => ['@type' => 'Organization', 'name' => SITE_NAME, 'url' => canonical('')],
    'areaServed'  => areas_served(),
    'hasOfferCatalog' => [
        '@type'           => 'OfferCatalog',
        'name'            => 'Website development services',
        'itemListElement' => array_map(static fn (array $s): array => [
            '@type'       => 'Offer',
            'itemOffered' => ['@type' => 'Service', 'name' => $s['title'], 'description' => $s['body']],
        ], WEB_SERVICES),
    ],
];

// Extra graph nodes, merged by the schema component.
$schemaExtra = [
    [
        '@type'       => 'HowTo',
        'name'        => 'How iThrive Software builds a website',
        'description' => 'The six stages of a website build, from discovery to launch and support.',
        'totalTime'   => 'P5W',
        'step'        => array_values(array_map(static fn (int $i, array $s): array => [
            '@type'    => 'HowToStep',
            'position' => $i + 1,
            'name'     => $s['title'],
            'text'     => $s['body'],
        ], array_keys(WEB_PROCESS), WEB_PROCESS)),
    ],
    [
        '@type'      => 'FAQPage',
        'name'       => 'Website development — frequently asked questions',
        'speakable'  => [
            '@type'       => 'SpeakableSpecification',
            'cssSelector' => ['.web-faq summary', '.web-faq p'],
        ],
        'mainEntity' => array_map(static fn (array $f): array => [
            '@type'          => 'Question',
            'name'           => $f['q'],
            'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f['a']],
        ], WEB_FAQ),
    ],
    [
        '@type'           => 'ItemList',
        'name'            => 'Websites built by iThrive Software',
        'itemListElement' => array_values(array_filter(array_map(static function (int $i, array $wk) {
            if (empty($wk['url'])) {
                return null;
            }

            return [
                '@type'    => 'ListItem',
                'position' => $i + 1,
                'name'     => $wk['name'],
                'url'      => $wk['url'],
            ];
        }, array_keys(WEB_WORK), WEB_WORK))),
    ],
];

foreach (WEB_LOCATIONS as $loc) {
    $schemaExtra[] = [
        '@type'       => 'LocalBusiness',
        'name'        => SITE_NAME . ' — ' . $loc['city'],
        'description' => $loc['body'],
        'url'         => canonical('services/web-development.php') . '#' . strtolower($loc['city']),
        'email'       => SITE_EMAIL,
        'address'     => [
            '@type'           => 'PostalAddress',
            'addressLocality' => $loc['city'],
            'addressRegion'   => $loc['region'],
            'addressCountry'  => 'IN',
        ],
        'areaServed'  => ['@type' => 'City', 'name' => $loc['city']],
    ];
}

$extraHead = '<link rel="stylesheet" href="' . e(asset('assets/css/animos-web-3d.css')) . '">'
           . '<link rel="stylesheet" href="' . e(asset('assets/css/web-originkit.css')) . '">';

require dirname(__DIR__) . '/includes/header.php';
?>

<?php /* The corridor. Fixed behind everything, purely decorative, and absent
         entirely without WebGL or with reduced motion asked for. */ ?>
<div class="rooms" data-rooms aria-hidden="true"></div>

<div class="web-page">

  <!-- ── Room 1 · The Brief ─────────────────────────────────────────── -->
  <section class="section web-hero" id="brief"
           data-room="brief" data-room-hue="188" data-room-label="The Brief">
    <div class="shell">
      <p class="eyebrow"><?= e(WEB_HERO['eyebrow']) ?></p>
      <h1 class="web-h1">
        Websites that load in milliseconds and<br>
        <span class="web-h1-lift" data-ok="text-lift"
              data-props='<?= e(json_encode([
                  'text'        => 'RANK ON PAGE ONE',
                  'direction'   => 'bottomRight',
                  'depth'       => 8,
                  'spread'      => 1,
                  'expand'      => 14,
                  'fade'        => true,
                  'filled'      => true,
                  'stroke'      => 0,
                  'frontColor'  => '#EAF0FA',
                  'depthColor'  => '#00f2fe',
                  'font'        => [
                      'fontFamily'    => 'inherit',
                      'fontWeight'    => 800,
                      'fontSize'      => 'clamp(2rem, 1rem + 3.2vw, 3.8rem)',
                      'letterSpacing' => '-0.02em',
                      'lineHeight'    => '1.08',
                  ],
              ], JSON_THROW_ON_ERROR)) ?>'>
          RANK ON PAGE ONE
        </span>
      </h1>
      <p class="web-lead"><?= e(WEB_HERO['lead']) ?></p>

      <div class="web-cta-row">
        <a class="btn btn-primary" href="<?= e(url(WEB_HERO['primary']['href'])) ?>">
          <?= e(WEB_HERO['primary']['label']) ?><?= icon('arrow') ?>
        </a>
        <a class="btn btn-ghost" href="<?= e(WEB_HERO['secondary']['href']) ?>">
          <?= e(WEB_HERO['secondary']['label']) ?>
        </a>
      </div>

      <ul class="web-stats">
        <?php foreach (WEB_STATS as $stat): ?>
          <li>
            <span class="web-stat-value"><?= e($stat['value']) ?></span>
            <span class="web-stat-label"><?= e($stat['label']) ?></span>
          </li>
        <?php endforeach; ?>
      </ul>

      <?php /* The 3D showcase — the sites we have shipped, as cards that burst
               out of a laptop screen as you zoom in. */ ?>
      <?php component('web-universe'); ?>
    </div>
  </section>

  <!-- ── Why it matters ─────────────────────────────────────────────── -->
  <section class="section section--tight web-intro">
    <div class="shell">
      <?php component('section-head', ['eyebrow' => WEB_INTRO['eyebrow'], 'title' => WEB_INTRO['title']]); ?>
      <div class="web-scroll-zoom-mount">
        <div data-ok="scroll-zoom-reveal"
             data-props='<?= e(json_encode([
                 'leftText'           => 'YOUR WEBSITE IS',
                 'rightText'          => 'NEVER SLEEPING',
                 'buttonText'         => '3D Architecture Blueprint',
                 'buttonLink'         => '#build',
                 'image'              => asset('assets/img/web-dev/web-hero-architecture.jpg'),
                 'textColor'          => '#FFFFFF',
                 'buttonTextColor'    => '#00F2FE',
                 'buttonBgColor'      => 'rgba(2, 4, 10, 0.85)',
                 'animationStiffness' => 95,
                 'animationDamping'   => 24,
                 'animationMass'      => 0.6,
                 'iconType'           => 'arrow',
             ], JSON_THROW_ON_ERROR)) ?>'>
          <noscript>
            <img src="<?= e(asset('assets/img/web-dev/web-hero-architecture.jpg')) ?>" alt="3D Web Development Architecture" style="width:100%;height:100%;object-fit:cover;display:block;">
          </noscript>
        </div>
      </div>
      <div class="web-intro-copy">
        <?php foreach (WEB_INTRO['body'] as $para): ?>
          <p><?= e($para) ?></p>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <?php /* Kinetic marquee powered by Origin Kit's Infinity Text */ ?>
  <section class="kinetic" aria-label="Websites built in Chennai, Coimbatore and Bangalore" style="padding: 24px 0; overflow: hidden; background: rgba(2, 4, 10, 0.94); border-top: 1px solid rgba(0, 242, 254, 0.18); border-bottom: 1px solid rgba(0, 242, 254, 0.18);">
    <div data-ok="infinity-text"
         data-props='<?= e(json_encode([
             'items' => [
                 'SUB-SECOND LCP ACROSS INDIA & GLOBAL EDGES',
                 'WCAG 2.2 AA ACCESSIBILITY IN EVERY SPRINT',
                 'CUSTOM NEXT.JS 15 & REACT 19 ARCHITECTURES',
                 'ZERO VENDOR LOCK-IN · 100% CODE OWNERSHIP',
                 'ENGINEERED IN CHENNAI, COIMBATORE & BANGALORE',
                 'STRUCTURED SCHEMA KNOWLEDGE GRAPHS FOR AEO',
             ],
             'font'  => [
                 'fontSize'      => 'clamp(1.3rem, 2.4vw, 2.1rem)',
                 'fontWeight'    => 800,
                 'letterSpacing' => '0.04em',
                 'lineHeight'    => '1.3',
                 'fontFamily'    => 'monospace',
             ],
             'color' => '#00f2fe',
             'speed' => 24,
         ], JSON_THROW_ON_ERROR)) ?>'>
      <div class="kinetic-track" data-kinetic>
        <p class="kinetic-word" aria-hidden="true">WEBSITES</p>
        <p class="kinetic-word kinetic-word--alt" aria-hidden="true">THAT&nbsp;RANK</p>
      </div>
    </div>
    <p class="kinetic-sr sr-only">
      iThrive Software has built websites for Coonoor Club, Lotus Eye Hospital, Cute Crew,
      Central Adventures, Madura Grandeur, Bharani Beauty Clinic, Aruvanaa and LogiSethu.
    </p>
  </section>

  <!-- ── Room 2 · The Workshop ──────────────────────────────────────── -->
  <section class="section web-build" id="build"
           data-room="build" data-room-hue="206" data-room-label="The Workshop">
    <div class="shell">
      <?php component('section-head', [
          'eyebrow' => 'What We Build',
          'title'   => 'Website development services, end to end',
          'lead'    => 'Ten things we are asked for most. Every one of them is delivered by the same '
                     . 'senior team, on the same performance and accessibility budget.',
      ]); ?>

      <?php
      $animosServices = [
          [
              'id'             => 'custom',
              'num'            => '01',
              'name'           => 'Custom Web Development',
              'category'       => 'Enterprise Architecture & Micro-Frontends',
              'tagline'        => 'Engineered from scratch for exact business workflows',
              'badge'          => 'Production Proven',
              'image'          => asset('assets/img/web-dev/web-arch-01.jpg'),
              'legitimateUse'  => 'Custom business portals, multi-tenant SaaS interfaces, and bespoke checkout flows that commoditized templates cannot handle without breaking.',
              'fashionableUse' => 'Installing 48 commercial WordPress plugins for features that require 30 lines of clean, tested TypeScript.',
              'metrics'        => [
                  ['label' => 'Global LCP', 'value' => '< 0.8s', 'sub' => 'Sub-second paint across edges'],
                  ['label' => 'Type Safety', 'value' => '100%', 'sub' => 'Zero runtime type exceptions'],
                  ['label' => 'Uptime SLA', 'value' => '99.99%', 'sub' => 'Resilient cloud architecture'],
              ],
              'stack'          => ['Next.js 15', 'React 19', 'TypeScript', 'Tailwind CSS', 'Node.js / FastAPI'],
              'accentColor'    => '#00f2fe',
              'glowColor'      => 'rgba(0, 242, 254, 0.4)',
          ],
          [
              'id'             => 'responsive',
              'num'            => '02',
              'name'           => 'Responsive Web Design',
              'category'       => 'Mobile-First & Adaptive Layouts',
              'tagline'        => 'Interfaces that perform flawlessly from 320px phones to 4K displays',
              'badge'          => 'Fluid Viewports',
              'image'          => asset('assets/img/web-dev/web-arch-02.jpg'),
              'legitimateUse'  => 'Complex touch gestures, dynamic viewports on modern folding devices, and low-latency mobile checkout where every millisecond counts.',
              'fashionableUse' => 'Collapsing a desktop table into an unscrollable horizontal overflow on mobile screens.',
              'metrics'        => [
                  ['label' => 'Mobile Score', 'value' => '99/100', 'sub' => 'Google Mobile Usability'],
                  ['label' => 'Frame Rate', 'value' => '60 FPS', 'sub' => 'Hardware-accelerated layout'],
                  ['label' => 'Bounce Drop', 'value' => '−38%', 'sub' => 'Faster mobile interaction'],
              ],
              'stack'          => ['Modern CSS', 'Container Queries', 'Tailwind', 'Framer Motion'],
              'accentColor'    => '#38bdf8',
              'glowColor'      => 'rgba(56, 189, 248, 0.4)',
          ],
          [
              'id'             => 'webapp',
              'num'            => '03',
              'name'           => 'Web Application Development',
              'category'       => 'Real-Time Data & Interactive SPAs',
              'tagline'        => 'Complex state management and real-time streaming interfaces',
              'badge'          => 'High Concurrency',
              'image'          => asset('assets/img/web-dev/web-arch-03.jpg'),
              'legitimateUse'  => 'Real-time analytics dashboards, collaborative team boards, and offline-first PWA applications.',
              'fashionableUse' => 'Re-rendering the entire DOM tree on every keystroke inside a form.',
              'metrics'        => [
                  ['label' => 'Sync Latency', 'value' => '< 45ms', 'sub' => 'WebSocket streaming data'],
                  ['label' => 'Offline Ready', 'value' => '100%', 'sub' => 'Service worker local cache'],
                  ['label' => 'State Recovery', 'value' => 'Instant', 'sub' => 'Optimistic UI update bus'],
              ],
              'stack'          => ['React', 'Zustand / TanStack', 'WebSockets', 'PostgreSQL', 'Redis'],
              'accentColor'    => '#a855f7',
              'glowColor'      => 'rgba(168, 85, 247, 0.4)',
          ],
          [
              'id'             => 'ecommerce',
              'num'            => '04',
              'name'           => 'E-Commerce Websites',
              'category'       => 'High-Throughput Commerce & Checkout',
              'tagline'        => 'High-conversion checkouts engineered for zero cart friction',
              'badge'          => 'Conversion Engine',
              'image'          => asset('assets/img/web-dev/web-arch-04.jpg'),
              'legitimateUse'  => 'Flash sales with 10k concurrent shoppers, instant UPI/card completion, and ERP inventory synchronization.',
              'fashionableUse' => 'A 6-step checkout with 4 redirect hops that loses 60% of buyers at the payment step.',
              'metrics'        => [
                  ['label' => 'Conversion Lift', 'value' => '+28%', 'sub' => 'Streamlined 1-click checkout'],
                  ['label' => 'Peak Concurrency', 'value' => '15k Req/s', 'sub' => 'Zero-downtime flash sales'],
                  ['label' => 'Payment Rate', 'value' => '99.2%', 'sub' => 'Direct gateway auto-retry'],
              ],
              'stack'          => ['Next.js Commerce', 'Stripe / Razorpay', 'Shopify API', 'PostgreSQL Mirror'],
              'accentColor'    => '#34d399',
              'glowColor'      => 'rgba(52, 211, 153, 0.4)',
          ],
          [
              'id'             => 'cms',
              'num'            => '05',
              'name'           => 'CMS & WordPress Development',
              'category'       => 'Headless CMS & Content Systems',
              'tagline'        => 'Empowering editors without compromising speed or security',
              'badge'          => 'Editorial Freedom',
              'image'          => asset('assets/img/web-dev/web-arch-05.jpg'),
              'legitimateUse'  => 'Custom Gutenberg blocks, scheduled publishing, and headless GraphQL front ends that keep WordPress safe behind firewalls.',
              'fashionableUse' => 'Buying bloated commercial themes that bundle 120MB of unused JavaScript.',
              'metrics'        => [
                  ['label' => 'Publish Speed', 'value' => '5x Faster', 'sub' => 'Zero dev reliance for copy'],
                  ['label' => 'Attack Surface', 'value' => 'Zero', 'sub' => 'Headless static edge builds'],
                  ['label' => 'CDN Hit Ratio', 'value' => '98.6%', 'sub' => 'Cached at the closest POP'],
              ],
              'stack'          => ['Headless WordPress', 'Sanity CMS', 'GraphQL', 'Next.js', 'Vercel / Cloudflare'],
              'accentColor'    => '#f59e0b',
              'glowColor'      => 'rgba(245, 158, 11, 0.4)',
          ],
          [
              'id'             => 'redesign',
              'num'            => '06',
              'name'           => 'Website Redesign & Migration',
              'category'       => 'Technical Migration & Replatforming',
              'tagline'        => 'Modernize architecture without dropping hard-won organic traffic',
              'badge'          => 'Zero Ranking Loss',
              'image'          => asset('assets/img/web-dev/web-arch-06.jpg'),
              'legitimateUse'  => '1-to-1 301 redirect parity, preserved structured data, and zero 404 dead links during corporate domain cutover.',
              'fashionableUse' => 'Flipping DNS on a Friday night without redirect mappings and losing 80% of Google rankings.',
              'metrics'        => [
                  ['label' => 'Rankings Kept', 'value' => '100%', 'sub' => 'Zero organic search loss'],
                  ['label' => 'URL Parity', 'value' => '10k+ Paths', 'sub' => 'Automated redirect audits'],
                  ['label' => 'Speed Jump', 'value' => '+300%', 'sub' => 'Core Web Vitals greenline'],
              ],
              'stack'          => ['Cloudflare Workers', 'Automated Crawler Audits', 'Python Scrapy', 'Next.js'],
              'accentColor'    => '#ec4899',
              'glowColor'      => 'rgba(236, 72, 153, 0.4)',
          ],
          [
              'id'             => 'seo',
              'num'            => '07',
              'name'           => 'Technical SEO Implementation',
              'category'       => 'Engineered Crawlability & Schema',
              'tagline'        => 'Structured data and server rendering that engines love to index',
              'badge'          => 'Search Authority',
              'image'          => asset('assets/img/web-dev/web-arch-07.jpg'),
              'legitimateUse'  => 'JSON-LD semantic knowledge graphs, canonical structures, clean XML sitemaps, and server-side rendering for AI answer engines.',
              'fashionableUse' => 'Keyword stuffing in meta tags and expecting rankings without semantic schema.',
              'metrics'        => [
                  ['label' => 'Index Velocity', 'value' => '< 24 Hours', 'sub' => 'For fresh content publish'],
                  ['label' => 'Rich Snippets', 'value' => '100% Eligible', 'sub' => 'Valid schema across pages'],
                  ['label' => 'Organic Lift', 'value' => '+140%', 'sub' => 'Over 6-month average'],
              ],
              'stack'          => ['Schema.org JSON-LD', 'Next.js SSR', 'Search Console API', 'Lighthouse CI'],
              'accentColor'    => '#06b6d4',
              'glowColor'      => 'rgba(6, 182, 212, 0.4)',
          ],
          [
              'id'             => 'vitals',
              'num'            => '08',
              'name'           => 'Core Web Vitals & Speed Optimisation',
              'category'       => 'Performance Budgets & CI Enforcement',
              'tagline'        => 'Hard CI performance thresholds that block slow pull requests',
              'badge'          => 'Sub-Second Speed',
              'image'          => asset('assets/img/web-dev/web-arch-08.jpg'),
              'legitimateUse'  => 'Sub-100ms TTFB via edge compute, modern image formats (AVIF/WebP), zero layout shifts (CLS < 0.02), and instantaneous INP.',
              'fashionableUse' => 'Slapping a caching plugin over bloated 15MB assets and calling it optimized.',
              'metrics'        => [
                  ['label' => 'Lighthouse', 'value' => '100/100', 'sub' => 'Performance & SEO score'],
                  ['label' => 'LCP Paint', 'value' => '0.65s', 'sub' => 'Well below 2.5s threshold'],
                  ['label' => 'Layout Shift', 'value' => '0.001', 'sub' => 'Zero visual content jumps'],
              ],
              'stack'          => ['Edge CDNs', 'Vite / Webpack Optim', 'AVIF / WebP', 'Critical CSS'],
              'accentColor'    => '#10b981',
              'glowColor'      => 'rgba(16, 185, 129, 0.4)',
          ],
          [
              'id'             => 'accessibility',
              'num'            => '09',
              'name'           => 'Web Accessibility (WCAG 2.2 AA)',
              'category'       => 'Universal Access & Legal Immunity',
              'tagline'        => 'Universal access tested with actual assistive hardware',
              'badge'          => 'Inclusive By Design',
              'image'          => asset('assets/img/web-dev/web-arch-09.jpg'),
              'legitimateUse'  => 'Full keyboard navigation, screen reader ARIA landmarks, sufficient contrast ratios, and legal immunity against ADA/WCAG lawsuits.',
              'fashionableUse' => 'Adding a cheap third-party accessibility overlay widget that violates privacy and fails basic screen readers.',
              'metrics'        => [
                  ['label' => 'WCAG Standard', 'value' => '2.2 AA', 'sub' => 'Certified compliant standard'],
                  ['label' => 'Keyboard Path', 'value' => '100% Accessible', 'sub' => 'Zero focus trap issues'],
                  ['label' => 'Contrast Ratio', 'value' => '> 7:1', 'sub' => 'Exceeds AAA typography standard'],
              ],
              'stack'          => ['Axe Core CI', 'NVDA / VoiceOver', 'Radix Primitives', 'Semantic HTML5'],
              'accentColor'    => '#8b5cf6',
              'glowColor'      => 'rgba(139, 92, 246, 0.4)',
          ],
          [
              'id'             => 'maintenance',
              'num'            => '10',
              'name'           => 'Website Maintenance & Support',
              'category'       => '24/7 Monitoring & Engineering Retainer',
              'tagline'        => 'A senior engineer who knows your codebase and answers in minutes',
              'badge'          => 'Enterprise SLA',
              'image'          => asset('assets/img/web-dev/web-arch-10.jpg'),
              'legitimateUse'  => 'Proactive weekly security patches, automated hourly database backups, 15-minute emergency SLA, and zero junior handoff.',
              'fashionableUse' => 'A support ticket queue where tickets sit untouched for 5 days before an automated robot replies.',
              'metrics'        => [
                  ['label' => 'SLA Response', 'value' => '< 15 Min', 'sub' => 'Critical incident resolution'],
                  ['label' => 'Uptime Guard', 'value' => '24/7/365', 'sub' => 'Global heartbeat polling'],
                  ['label' => 'Backup Cycle', 'value' => '6 Hours', 'sub' => 'Automated off-site replication'],
              ],
              'stack'          => ['Datadog / Sentry', 'GitHub Actions', 'Docker Containers', 'AWS / DigitalOcean'],
              'accentColor'    => '#f43f5e',
              'glowColor'      => 'rgba(244, 63, 94, 0.4)',
          ],
      ];
      $first = $animosServices[0];
      ?>

      <!-- ── Animos 3D Interactive Showcase ── -->
      <div class="animos-showcase-wrap" data-animos-showcase>
        <!-- JSON Data for instant client engine -->
        <script type="application/json" id="animos-services-data"><?= json_encode($animosServices, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>

        <div class="animos-controls-bar">
          <!-- Category / Service Navigation Pills -->
          <div class="animos-tabs-nav" role="tablist" aria-label="Web Development Services">
            <?php foreach ($animosServices as $idx => $svc): ?>
              <button type="button" class="animos-tab-btn<?= $idx === 0 ? ' is-active' : '' ?>"
                      data-animos-tab="<?= $idx ?>"
                      role="tab"
                      aria-selected="<?= $idx === 0 ? 'true' : 'false' ?>"
                      style="--active-accent: <?= e($svc['accentColor']) ?>">
                <span class="animos-tab-num"><?= e($svc['num']) ?></span>
                <span><?= e($svc['name']) ?></span>
              </button>
            <?php endforeach; ?>
          </div>

          <!-- View Mode Toggle -->
          <div class="animos-view-toggle">
            <button type="button" class="animos-toggle-btn is-active" data-view-toggle="studio" title="3D Animos Studio View">
              ✦ 3D Studio
            </button>
            <button type="button" class="animos-toggle-btn" data-view-toggle="matrix" title="All Services Grid Matrix">
              ▦ Matrix
            </button>
          </div>
        </div>

        <!-- 3D Perspective Stage -->
        <div class="animos-stage" data-view-studio>
          <div class="animos-card-container" data-animos-card style="--card-accent: <?= e($first['accentColor']) ?>; --card-accent-alpha: <?= e($first['glowColor']) ?>; --card-glow: <?= e($first['glowColor']) ?>;">
            <!-- External 3D Gyro Rings -->
            <div class="animos-gyro-ring-1" aria-hidden="true"></div>
            <div class="animos-gyro-ring-2" aria-hidden="true"></div>

            <!-- Card Body -->
            <div class="animos-card-body">
              <div class="animos-sheen" aria-hidden="true"></div>
              <div class="animos-aura" aria-hidden="true"></div>

              <!-- Top Bar -->
              <div class="animos-layer animos-topbar">
                <div class="animos-num-badge">
                  <span class="animos-num-tag" data-animos-num><?= e($first['num']) ?></span>
                  <span class="animos-cat-label" data-animos-cat><?= e($first['category']) ?></span>
                </div>
                <span class="animos-badge-pill" data-animos-badge>✦ <?= e($first['badge']) ?></span>
              </div>

              <!-- Title & Tagline -->
              <div class="animos-layer animos-title-block">
                <h3 class="animos-title" data-animos-title><?= e($first['name']) ?></h3>
                <p class="animos-tagline" data-animos-tagline><?= e($first['tagline']) ?></p>
              </div>

              <!-- 3D Architecture Visual Frame -->
              <div class="animos-layer animos-visual-frame">
                <img class="animos-visual-img" data-animos-img src="<?= e($first['image']) ?>" alt="<?= e($first['name']) ?>" loading="lazy" decoding="async">
                <div class="animos-visual-overlay" aria-hidden="true"></div>
                <span class="animos-visual-crosshair" data-animos-crosshair>SYS::CUSTOM_v3D</span>
              </div>

              <!-- Reality Check: Legitimate vs Commodity -->
              <div class="animos-layer animos-reality-check">
                <div class="animos-check-box animos-check-box--pos">
                  <div class="animos-check-head">
                    <span>✓</span>
                    <span class="animos-check-title">Where It Actually Pays</span>
                  </div>
                  <p class="animos-check-body" data-animos-legit><?= e($first['legitimateUse']) ?></p>
                </div>
                <div class="animos-check-box animos-check-box--neg">
                  <div class="animos-check-head">
                    <span>✕</span>
                    <span class="animos-check-title">The Commodity Waste</span>
                  </div>
                  <p class="animos-check-body" data-animos-waste><?= e($first['fashionableUse']) ?></p>
                </div>
              </div>

              <!-- Metrics Triad -->
              <div class="animos-layer animos-metrics-row" data-animos-metrics>
                <?php foreach ($first['metrics'] as $m): ?>
                  <div class="animos-metric-tile">
                    <span class="animos-metric-val"><?= e($m['value']) ?></span>
                    <span class="animos-metric-label"><?= e($m['label']) ?></span>
                    <span class="animos-metric-sub"><?= e($m['sub']) ?></span>
                  </div>
                <?php endforeach; ?>
              </div>

              <!-- Production Tech Stack Tags -->
              <div class="animos-layer animos-stack-row" data-animos-stack>
                <span class="animos-stack-lead">Engineered In:</span>
                <?php foreach ($first['stack'] as $item): ?>
                  <span class="animos-stack-tag"><?= e($item) ?></span>
                <?php endforeach; ?>
              </div>

              <!-- Footer Navigation -->
              <div class="animos-layer animos-card-foot">
                <div class="animos-nav-arrows">
                  <button type="button" class="animos-arrow-btn" data-animos-prev aria-label="Previous Service">&larr;</button>
                  <div class="animos-step-dots">
                    <?php foreach ($animosServices as $idx => $svc): ?>
                      <button type="button" class="animos-dot<?= $idx === 0 ? ' is-active' : '' ?>" data-animos-dot="<?= $idx ?>" aria-label="Jump to service <?= $idx + 1 ?>"></button>
                    <?php endforeach; ?>
                  </div>
                  <button type="button" class="animos-arrow-btn" data-animos-next aria-label="Next Service">&rarr;</button>
                </div>

                <a class="animos-action-link" data-animos-action href="<?= e(url('contact.php?service=' . urlencode($first['name']))) ?>">
                  <span>Start with this service</span>
                  <?= icon('arrow') ?>
                </a>
              </div>
            </div>
          </div>
        </div>

        <!-- Full Crawlable Semantic Matrix View -->
        <div class="animos-matrix-grid" data-view-matrix hidden>
          <?php foreach ($animosServices as $idx => $svc): ?>
            <article class="animos-matrix-card">
              <figure class="animos-matrix-figure">
                <img src="<?= e($svc['image']) ?>" alt="<?= e($svc['name']) ?>" loading="lazy" decoding="async">
                <span class="animos-matrix-num"><?= e($svc['num']) ?></span>
              </figure>
              <div class="animos-matrix-body">
                <h3 class="animos-matrix-title"><?= e($svc['name']) ?></h3>
                <p class="animos-matrix-desc"><?= e($svc['legitimateUse']) ?></p>
                <div class="animos-matrix-tags">
                  <?php foreach ($svc['stack'] as $st): ?>
                    <span><?= e($st) ?></span>
                  <?php endforeach; ?>
                </div>
              </div>
            </article>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </section>

  <!-- ── Room 3 · The Line ──────────────────────────────────────────── -->
  <section class="section web-process" id="process"
           data-room="process" data-room-hue="224" data-room-label="The Line">
    <div class="shell">
      <?php component('section-head', [
          'eyebrow' => 'How It Runs',
          'title'   => 'Six stages, with a date against each one',
          'lead'    => 'The whole schedule is agreed before anything is designed. You can open a staging '
                     . 'URL from the first development sprint onward.',
      ]); ?>

      <?php
      $procImages = [
          'assets/img/web-dev/web-proc-01.jpg',
          'assets/img/web-dev/web-proc-02.jpg',
          'assets/img/web-dev/web-proc-03.jpg',
          'assets/img/web-dev/web-proc-04.jpg',
          'assets/img/web-dev/web-proc-05.jpg',
          'assets/img/web-dev/web-proc-06.jpg',
      ];
      $procDates = [
          'WEEK 1 · DAYS 1–5',
          'WEEK 2 · DAYS 6–12',
          'WEEKS 3–4 · DAYS 13–26',
          'WEEKS 5–8 · DAYS 27–55',
          'WEEK 9 · DAYS 56–63',
          'WEEK 10+ · DAY 64 ONWARD',
      ];
      $procMilestones = array_values(array_map(static fn (int $i, array $s): array => [
          'title'    => $s['title'],
          'date'     => $procDates[$i] ?? ('STAGE ' . ($i + 1) . ' · ' . $s['days']),
          'caption'  => $s['days'] . ' · ' . substr($s['body'], 0, 48) . '...',
          'flipText' => $s['body'],
          'image'    => asset($procImages[$i % count($procImages)]),
      ], array_keys(WEB_PROCESS), WEB_PROCESS));
      ?>

      <!-- Framer 3D Polaroid Timeline: Six Stages with Explicit Dates -->
      <div class="web-polaroid-timeline-mount"
           data-ok="polaroid-timeline"
           data-props='<?= e(json_encode([
               'milestones'      => $procMilestones,
               'stringColor'     => '#00f2fe',
               'pinColor'        => '#00f2fe',
               'pinGlowColor'    => '#00f2fe',
               'curveStyle'      => 'wavy',
               'stringThickness' => 3,
               'pinSize'         => 36,
           ], JSON_THROW_ON_ERROR)) ?>'>
      </div>
    </div>
  </section>

  <!-- ── Room 4 · The Gallery ───────────────────────────────────────── -->
  <section class="section hscroll hwork-full" id="work"
           data-room="work" data-room-hue="258" data-room-label="The Gallery"
           data-hscroll>
    <div class="shell" style="margin-bottom: 24px;">
      <?php
      $workImages = array_map(
          static fn (array $wk): string => asset('assets/img/work/' . $wk['slug'] . '.jpg'),
          WEB_WORK
      );
      ?>
      <div class="web-work-coverflow-island">
        <div data-ok="coverflow-gallery"
             data-props='<?= e(json_encode([
                 'images' => $workImages,
                 'layout' => [
                     'cardWidth'  => 360,
                     'cardHeight' => 460,
                     'gap'        => 75,
                     'radius'     => 18,
                 ],
                 'depth' => [
                     'perspective'       => 1200,
                     'rotation'          => 45,
                     'scaleFalloff'      => 4,
                     'minScale'          => 0.58,
                     'opacityFalloff'    => 6,
                     'minOpacity'        => 1,
                     'brightnessFalloff' => 0.08,
                 ],
                 'motionSettings' => [
                     'interaction'     => 'drag',
                     'activeIndex'     => 2,
                     'springPreset'    => 'Bouncy',
                     'dragSensitivity' => 1,
                 ],
                 'styleSettings' => [
                     'backgroundColor' => 'transparent',
                     'borderWidth'     => 1,
                     'borderColor'     => 'rgba(0, 242, 254, 0.35)',
                     'shadow'          => true,
                     'shadowColor'     => 'rgba(0, 0, 0, 0.75)',
                     'shadowBlur'      => 40,
                     'shadowY'         => 18,
                     'activeGlow'      => true,
                     'glowColor'       => 'rgba(0, 242, 254, 0.5)',
                 ],
                 'indicators' => [
                     'showDots' => true,
                 ],
             ], JSON_THROW_ON_ERROR)) ?>'>
        </div>
        <p class="web-gallery-hint">
          <?= icon('compass') ?> Drag horizontally to rotate through 3D client platforms
        </p>
      </div>
    </div>

    <div class="hscroll-stage">
      <ol class="hscroll-track" data-hscroll-track>

        <li class="hpanel hpanel--intro">
          <div class="hpanel-intro">
            <p class="eyebrow">Selected Work</p>
            <h2 class="hpanel-intro-title">Websites we<br>have shipped</h2>
            <p class="hpanel-intro-lead">
              Keep scrolling — the work moves sideways. Every panel is a live site,
              playing as it scrolls.
            </p>
          </div>
        </li>

        <?php foreach (WEB_WORK as $i => $wk): ?>
          <li class="hpanel" style="--tint: <?= e($wk['tint']) ?>">
            <?php $clip = ROOT_PATH . '/assets/video/work/' . $wk['slug'] . '.mp4'; ?>

            <?php if (is_file($clip)): ?>
              <?php /* preload="none": eight clips is more than anyone will watch,
                       so nothing downloads until hscroll.js says the panel is
                       near. The poster is the still we already had. */ ?>
              <video class="hpanel-media" data-hpanel-video
                     muted loop playsinline preload="none" disablepictureinpicture
                     poster="<?= e(asset('assets/img/work/' . $wk['slug'] . '.jpg')) ?>"
                     data-src="<?= e(asset('assets/video/work/' . $wk['slug'] . '.mp4')) ?>"></video>
            <?php else: ?>
              <img class="hpanel-media" src="<?= e(asset('assets/img/work/' . $wk['slug'] . '.jpg')) ?>"
                   width="1280" height="720" loading="lazy" decoding="async"
                   alt="<?= e($wk['name'] . ' website built by ' . SITE_NAME) ?>">
            <?php endif; ?>

            <span class="hpanel-scrim" aria-hidden="true"></span>

            <div class="hpanel-copy">
              <p class="hpanel-tag">
                [<?= e(strtoupper($wk['kind'])) ?>] [<?= e($wk['year']) ?>]
              </p>
              <h3 class="hpanel-name"><?= e($wk['name']) ?></h3>
              <p class="hpanel-note"><?= e($wk['note']) ?></p>
              <?php if ($wk['url']): ?>
                <a class="hpanel-link" href="<?= e($wk['url']) ?>" target="_blank" rel="noopener">
                  Visit the site<?= icon('arrow-up-right') ?>
                </a>
              <?php endif; ?>
            </div>

            <span class="hpanel-index" aria-hidden="true">
              [US_<?= str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT) ?>_<?= e(substr($wk['year'], -2)) ?>]
            </span>
          </li>
        <?php endforeach; ?>

        <li class="hpanel hpanel--end">
          <div class="hpanel-intro">
            <h2 class="hpanel-intro-title">Your site<br>could be next.</h2>
            <a class="btn btn-primary" href="<?= e(url('contact.php')) ?>">Start your project<?= icon('arrow') ?></a>
          </div>
        </li>
      </ol>

      <span class="hscroll-progress" aria-hidden="true"><span data-hscroll-bar></span></span>
    </div>
  </section>

  <!-- ── Room 5 · The Engine Room ───────────────────────────────────── -->
  <section class="section web-stack" id="stack"
           data-room="stack" data-room-hue="276" data-room-label="The Engine Room">
    <div class="shell">
      <?php component('section-head', [
          'eyebrow' => 'The Stack',
          'title'   => 'What we build websites with',
          'lead'    => 'Chosen for what the project needs. A brochure site does not need the stack a '
                     . 'booking platform does, and pretending otherwise is how budgets disappear.',
      ]); ?>

      <!-- Origin Kit 3D Arc Wall -->
      <div class="web-arc-wall-wrap">
        <div data-ok="arc-3d-wall"></div>
      </div>
    </div>
  </section>

  <!-- ── Room 6 · The Floor ─────────────────────────────────────────── -->
  <section class="section web-industries" id="industries"
           data-room="industries" data-room-hue="292" data-room-label="The Floor">
    <div class="shell">
      <?php component('section-head', [
          'eyebrow' => 'Industries',
          'title'   => 'Sectors we have shipped into',
          'lead'    => 'Each one has its own conversion problem. Hover a sector to see what it is.',
      ]); ?>

      <?php
      $sectorFileMap = [
          1  => 'sector-01-healthcare.jpg',
          2  => 'sector-02-hospitality.jpg',
          3  => 'sector-03-retail.jpg',
          4  => 'sector-04-education.jpg',
          5  => 'sector-05-manufacturing.jpg',
          6  => 'sector-06-logistics.jpg',
          7  => 'sector-07-travel.jpg',
          8  => 'sector-08-professional.jpg',
          9  => 'sector-09-food.jpg',
          10 => 'sector-10-wellness.jpg',
          11 => 'sector-11-fashion.jpg',
          12 => 'sector-12-aerospace.jpg',
      ];
      $industryImages = array_map(static fn (int $n): array => [
          'src'   => asset('assets/img/web-dev/sectors/' . $sectorFileMap[$n]),
          'alt'   => WEB_INDUSTRIES[$n - 1]['title'] ?? 'Industry vertical',
          'badge' => 'SECTOR ' . str_pad((string) $n, 2, '0', STR_PAD_LEFT),
          'title' => WEB_INDUSTRIES[$n - 1]['title'] ?? 'Industry vertical',
      ], range(1, 12));
      ?>

      <!-- Origin Kit 3D Bento Gallery -->
      <div class="web-bento-wrap">
        <div data-ok="bento-gallery" style="width: 100%; height: 100%;"
             data-props='<?= e(json_encode([
                 'images'            => $industryImages,
                 'gridColumns'       => 4,
                 'gridRows'          => 3,
                 'gap'               => 12,
                 'borderRadius'      => 16,
                 'backgroundColor'   => 'transparent',
                 'opacity'           => 0.94,
                 'showOverlay'       => true,
                 'overlayColor'      => '#02040a',
                 'overlayOpacity'    => 0.22,
                 'enableLightbox'    => true,
                 'animationDuration' => 0.35,
                 'grayscaleOnHover'  => false,
             ], JSON_THROW_ON_ERROR)) ?>'>
        </div>
      </div>
    </div>
  </section>

  <!-- ── Mid-Page CTA with Origin Kit Light On/Off ── -->
  <section class="section web-quote-cta" style="position: relative; overflow: hidden;">
    <div class="shell" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 44px; align-items: center;">
      <div class="web-quote-content">
        <h2 class="web-quote-title">
          Looking for a reliable <span class="web-quote-accent">website development partner?</span>
        </h2>
        <p class="web-quote-lead">
          iThrive Software builds custom websites, e-commerce platforms and web applications for
          businesses in Chennai, Coimbatore, Bangalore and across India — scoped, priced and dated
          in writing before a line is written.
        </p>
        <div class="web-quote-actions">
          <a class="btn btn-primary" href="<?= e(url('contact.php')) ?>">
            Request Free Proposal &amp; Quote<?= icon('arrow') ?>
          </a>
          <a class="btn btn-ghost" href="#work">See the work</a>
        </div>
      </div>

      <div class="web-quote-interactive">
        <div data-ok="light-on-off"
             data-props='<?= e(json_encode([
                 'baseSrc'        => asset('assets/img/light-on-off/base.jpg'),
                 'topLightSrc'    => asset('assets/img/light-on-off/top-light.png'),
                 'bottomLightSrc' => asset('assets/img/light-on-off/bottom-light.png'),
                 'title'          => 'Power Up Your Project',
                 'subtitle'       => 'Switch On Development',
                 'initialTop'     => true,
                 'initialBottom'  => true,
             ], JSON_THROW_ON_ERROR)) ?>'>
        </div>
      </div>
    </div>
  </section>

  <!-- ── Why us ─────────────────────────────────────────────────────── -->
  <?php /* Origin Kit's Swipe Stack: a fanned 3D deck where the top card drags,
           flicks to the back past a threshold, and snaps home on a short swipe.
           The cards are real headings and copy rather than a canvas — this page
           has to rank, and a drawn deck would be an empty box to everything
           except a human with a mouse. */ ?>
  <section class="section web-why">
    <div class="shell">
      <?php component('section-head', [
          'eyebrow' => 'Why iThrive',
          'title'   => 'What is different about working with us',
          'lead'    => 'Drag the top card, or use the arrow keys. Six of them, and they cycle.',
      ]); ?>

      <div class="swipe-wrap">
        <?php
        $whyArtImages = [
            'assets/img/web-dev/why/realtime-01-fixed-contract.jpg',
            'assets/img/web-dev/why/realtime-02-senior-engineers.jpg',
            'assets/img/web-dev/why/realtime-03-ip-ownership.jpg',
            'assets/img/web-dev/why/realtime-04-lighthouse-speed.jpg',
            'assets/img/web-dev/why/realtime-05-cms-architecture.jpg',
            'assets/img/web-dev/why/realtime-06-dedicated-engineer.jpg',
        ];
        $whyDeck = array_map(static fn (string $img): array => [
            'src' => asset($img),
        ], $whyArtImages);
        ?>
        <div class="web-ok-swipe-container">
          <div data-ok="swipe-stack"
               data-props='<?= e(json_encode([
                   'images'         => $whyDeck,
                   'cardWidth'      => 440,
                   'cardHeight'     => 560,
                   'cardRadius'     => 18,
                   'swipeThreshold' => 50,
                   'tiltAngleStart' => 0,
                   'tiltAngle'      => -14,
                   'xOffset'        => 20,
               ], JSON_THROW_ON_ERROR)) ?>'>
            <div class="swipe-stack" data-swipe-stack
                 data-threshold="50" data-tilt-start="0" data-tilt="-14" data-x-offset="12"
                 role="group" aria-roledescription="card deck"
                 aria-label="What is different about working with iThrive Software">
              <?php foreach (WEB_WHY as $i => $why): ?>
                <article class="swipe-card" data-swipe-card
                         style="--tint: <?= e(['#00F2FE', '#4EA8FF', '#9D4EDD', '#2FA36B', '#F2649B', '#C8A24A'][$i % 6]) ?>">
                  <span class="swipe-art" aria-hidden="true">
                    <img src="<?= e(asset($whyArtImages[$i % count($whyArtImages)])) ?>"
                         width="600" height="400" loading="lazy" decoding="async"
                         draggable="false" alt="<?= e($why['title']) ?>">
                  </span>
                  <span class="swipe-num"><?= str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT) ?> / <?= count(WEB_WHY) ?></span>
                  <h3 class="swipe-title"><?= e($why['title']) ?></h3>
                  <p class="swipe-body"><?= e($why['body']) ?></p>
                </article>
              <?php endforeach; ?>
            </div>
          </div>

          <button class="swipe-next" type="button" data-swipe-next>
            Next<?= icon('arrow') ?>
          </button>
        </div>
      </div>
    </div>
  </section>

  <!-- ── Room 7 · The Map Room ──────────────────────────────────────── -->
  <section class="section section--panel web-locations" id="locations"
           data-room="locations" data-room-hue="310" data-room-label="The Map Room">
    <div class="shell">
      <?php
      $polaroidPhotos = [
          [
              'id'        => 'chennai',
              'src'       => asset('assets/img/web-dev/city-chennai.jpg'),
              'alt'       => 'Chennai Engineering Studio — Guindy Tech Corridor',
              'col'       => 'left',
              'angle'     => -7,
              'speed'     => 1.15,
              'topOffset' => 90,
          ],
          [
              'id'        => 'coimbatore',
              'src'       => asset('assets/img/web-dev/city-coimbatore.jpg'),
              'alt'       => 'Coimbatore Development Hub — TIDEL Park Belt',
              'col'       => 'center',
              'angle'     => 5,
              'speed'     => 0.95,
              'topOffset' => 120,
          ],
          [
              'id'        => 'bangalore',
              'src'       => asset('assets/img/web-dev/city-bangalore.jpg'),
              'alt'       => 'Bangalore Innovation Lab — Outer Ring Road Tech Hub',
              'col'       => 'right',
              'angle'     => 8,
              'speed'     => 1.1,
              'topOffset' => 105,
          ],
      ];
      ?>

      <!-- Origin Kit 3D Polaroid Scroll Showcase: Three Physical Studios -->
      <div class="web-polaroid-mount" data-ok="polaroid-scroll"
           data-props='<?= e(json_encode([
               'eyebrow' => 'Three Physical Studios',
               'title'   => 'Chennai · Coimbatore · Bangalore',
               'photos'  => $polaroidPhotos,
           ], JSON_THROW_ON_ERROR)) ?>'>
      </div>

      <p class="web-reach">
        We also deliver remotely to clients across <strong>Tamil Nadu</strong> — Madurai, Trichy, Salem,
        Erode, Tirupur and the Nilgiris — and to businesses anywhere in <strong>India</strong>.
      </p>
    </div>
  </section>

  <!-- ── FAQ ────────────────────────────────────────────────────────── -->
  <section class="section web-faq">
    <div class="shell">
      <?php component('section-head', [
          'eyebrow' => 'Questions',
          'title'   => 'Website development, answered straight',
      ]); ?>

      <div class="web-faq-list">
        <?php foreach (WEB_FAQ as $i => $f): ?>
          <details class="faq-item"<?= $i === 0 ? ' open' : '' ?>>
            <summary>
              <span><?= e($f['q']) ?></span>
              <?= icon('chevron', 'icon faq-caret') ?>
            </summary>
            <p><?= e($f['a']) ?></p>
          </details>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <?php component('cta', ['cta' => [
      'eyebrow'   => 'Start Your Project',
      'title'     => 'Tell us what the website has to achieve.',
      'body'      => 'Send a paragraph about your business and what the site needs to do. You will get '
                   . 'scope, a fixed price and a delivery date in writing within two working days.',
      'primary'   => ['label' => 'Get a Website Quote', 'href' => 'contact.php'],
      'secondary' => ['label' => 'See all services',    'href' => 'services.php'],
  ]]); ?>

</div>

<script type="module" src="<?= e(asset('assets/js/web-rooms.js')) ?>"></script>
<script src="<?= e(asset('assets/js/work-canvas.js')) ?>" defer></script>
<script src="<?= e(asset('assets/js/hscroll.js')) ?>" defer></script>
<script src="<?= e(asset('assets/js/swipe-stack.js')) ?>" defer></script>
<script src="<?= e(asset('assets/js/animos-web-3d.js')) ?>" defer></script>
<script type="module" src="<?= e(url('assets/dist/originkit/originkit.js')) ?>"></script>

<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
