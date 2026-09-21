<?php
/**
 * E-Commerce Development — bespoke service architecture.
 *
 * Section 1: Hero Film Scrub (ecom-film)
 * Section 2: OriginKit Fibre Arc WebGL Component with brand logo palette
 * Section 3: Performance Benchmarks & Outcome Band
 * Section 4: Core Capabilities (Category 1 - 6 Images)
 * Section 5: Commerce Platforms & Architecture (Category 2 - 6 Images)
 * Section 6: Payment Rails & Checkout Security (Category 3 - 5 Images)
 * Section 7: OMS, Warehouse & Logistics (Category 4 - 5 Images)
 * Section 8: AI Merchandising & Conversion Growth (Category 5 - 4 Images)
 * Section 9: Enterprise Case Studies & Production Proof (Category 6 - 4 Images)
 * Section 10: The Stack & Engineering Architecture
 * Section 11: E-Commerce FAQ
 * Section 12: Project Scoping CTA
 */

declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/config.php';

$svc = service('ecommerce-development');

$page      = 'services';
$pageTitle = 'E-Commerce App Development Services';
$pageDesc  = 'High-performance mobile commerce: native iOS and Android shopping apps, headless storefronts, sub-400ms checkout funnels and enterprise OMS integration.';
$ogImage   = 'service-' . $svc['group_slug'];

$extraHead = '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer">' . "\n"
           . '<link rel="stylesheet" href="' . e(asset('assets/css/ecommerce.css')) . '">';

$schema = [
    '@type'       => 'Service',
    'name'        => 'E-Commerce Development',
    'serviceType' => 'E-Commerce Development',
    'description' => $svc['lead'],
    'url'         => canonical('services/ecommerce-development.php'),
    'provider'    => ['@type' => 'Organization', 'name' => SITE_NAME, 'url' => canonical('')],
    'hasOfferCatalog' => [
        '@type'           => 'OfferCatalog',
        'name'            => 'E-Commerce development capabilities',
        'itemListElement' => array_map(static fn (array $c): array => [
            '@type'       => 'Offer',
            'itemOffered' => ['@type' => 'Service', 'name' => $c['title'], 'description' => $c['body']],
        ], $svc['capabilities']),
    ],
];

require dirname(__DIR__) . '/includes/header.php';
?>

<!-- =========================================================================
     SECTION 1: HERO FILM SCRUB
     ========================================================================= -->
<?php
component('film-hero', [
    'video' => 'ecom-film',
    'label' => 'E-commerce development at iThrive',
    'track' => '550vh',
    'ease'  => '0.06',
]);
?>

<!-- =========================================================================
     SECTION 2: ENTERPRISE E-COMMERCE APP DEVELOPMENT & MOBILE COMMERCE
     ========================================================================= -->
<section class="section ecom-app-section" id="mobile-commerce">
  <div class="ecom-app-bg-glow"></div>

  <div class="ecom-widescreen-shell ecom-app-content">
    <div class="ecom-app-badge" data-reveal>
      <span class="pulse-dot" style="width:8px;height:8px;border-radius:50%;background:#3EE1FF;box-shadow:0 0 8px #3EE1FF;"></span>
      Next-Gen Mobile Commerce Architecture • iOS &amp; Android • Sub-400ms Biometric Checkout • Real-Time OMS
    </div>

    <?php /* The h1 of the page: the film hero above it carries only the
             picture, so without this the page had no h1 at all. */ ?>
    <h1 class="ecom-app-title" data-reveal style="--d:1">
      E-Commerce App Development &amp; <span class="text-gradient">High-Conversion Mobile Shopping Engines</span>
    </h1>

    <p class="ecom-app-lead" data-reveal style="--d:2">
      We engineer native iOS &amp; Android shopping apps, headless Hydrogen &amp; Next.js storefronts, and autonomous checkout engines built to maximize average order value (AOV), slash cart abandonment, and deliver 60FPS fluid mobile shopping experiences at enterprise scale.
    </p>

    <div class="ecom-app-actions" data-reveal style="--d:3;display:flex;gap:16px;flex-wrap:wrap;">
      <button class="btn btn-primary" type="button" data-modal-open data-modal-service="E-Commerce App Development">
        Consult Our E-Commerce App Engineers<?= icon('arrow') ?>
      </button>
      <a class="btn btn-ghost" href="#capabilities">Explore All 30 Capabilities</a>
    </div>

    <!-- 4 Pillars: E-Commerce App Architecture & Mobile Commerce Engineering -->
    <div class="ecom-app-grid">
      <div class="ecom-app-card" data-reveal style="--d:2">
        <div class="ecom-app-card-num">01 / NATIVE MOBILE SHOPPING APPS</div>
        <h3 class="ecom-app-card-title">Flutter &amp; React Native Dual-Store Mastery</h3>
        <p class="ecom-app-card-desc">Fluid 60FPS shopping experiences built for iOS and Android. Native device capabilities including biometric Face ID checkout, haptic feedback, camera-based visual barcode &amp; product search, instant push notifications, and offline catalog browsing with local SQLite sync.</p>
      </div>

      <div class="ecom-app-card" data-reveal style="--d:3">
        <div class="ecom-app-card-num">02 / 1-CLICK INSTANT CHECKOUT &amp; PAYMENTS</div>
        <h3 class="ecom-app-card-title">Frictionless Conversion &amp; Smart Fraud Shield</h3>
        <p class="ecom-app-card-desc">Eliminating checkout drop-offs with 1-tap checkout flows, auto-filling addresses, native UPI intent linking (PhonePe, Google Pay, Paytm), Apple Pay &amp; Google Wallet, and AI-driven dynamic COD risk scoring to stop costly RTO losses before dispatch.</p>
      </div>

      <div class="ecom-app-card" data-reveal style="--d:4">
        <div class="ecom-app-card-num">03 / REAL-TIME OMS &amp; HYPERLOCAL GPS TRACKING</div>
        <h3 class="ecom-app-card-title">Omnichannel Inventory &amp; Live Dispatch Telemetry</h3>
        <p class="ecom-app-card-desc">Live WebSocket connections providing customers with real-time delivery tracking on interactive maps, instant push notifications for order milestones (Packed, Dispatched, Out for Delivery), and automated split-shipment routing from the nearest fulfillment node.</p>
      </div>

      <div class="ecom-app-card" data-reveal style="--d:5">
        <div class="ecom-app-card-num">04 / ON-DEVICE AI MERCHANDISING</div>
        <h3 class="ecom-app-card-title">Neural Recommendations &amp; Dynamic Upsells</h3>
        <p class="ecom-app-card-desc">Sub-50ms personalized product feeds, dynamic bundle upsells at cart level, visual similarity search powered by vector embeddings, and real-time inventory counter scarcity badges that demonstrably lift conversion rates by 35%+.</p>
      </div>
    </div>

    <!-- Live Mobile App Architecture Telemetry Showcase -->
    <div class="ecom-app-showcase" data-reveal style="--d:6">
      <div>
        <span style="font-family:var(--mono, monospace);font-size:0.78rem;font-weight:700;color:#00F2FE;letter-spacing:0.12em;text-transform:uppercase;display:block;margin-bottom:8px;">
          PRODUCTION BENCHMARKS // ENTERPRISE COMMERCE APP
        </span>
        <h3 style="font-size:clamp(1.3rem, 2vw, 1.7rem);font-weight:800;color:#FFF;margin-bottom:12px;line-height:1.2;">
          Engineered for Peak Flash Sales &amp; Sub-Second Mobile Interactions
        </h3>
        <p style="font-size:0.92rem;color:#94A3B8;line-height:1.6;margin:0;">
          Our mobile e-commerce applications are tested under simulated multi-tenant loads of 100,000+ concurrent shoppers. Built-in distributed edge caching, background payload pre-fetching, and resilient payment gateway retries protect revenue during high-traffic drops.
        </p>
      </div>
      <div class="ecom-app-specs">
        <div class="ecom-app-spec-box">
          <div class="val">&lt; 400ms</div>
          <div class="lbl">Biometric 1-Tap Checkout Time</div>
        </div>
        <div class="ecom-app-spec-box">
          <div class="val">99.98%</div>
          <div class="lbl">App Crash-Free User Sessions</div>
        </div>
        <div class="ecom-app-spec-box">
          <div class="val">-42%</div>
          <div class="lbl">Cart Abandonment Rate Reduction</div>
        </div>
        <div class="ecom-app-spec-box">
          <div class="val">100k+</div>
          <div class="lbl">Concurrent Shoppers Supported</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- =========================================================================
     SECTION 3: OUTCOME BENCHMARKS BAND
     ========================================================================= -->
<section class="section section--flush-top">
  <div class="ecom-widescreen-shell">
    <?php component('stats-band', ['stats' => [
        ['value' => '<400ms', 'label' => 'Native app checkout completion'],
        ['value' => '<800ms', 'label' => 'Headless storefront time-to-interactive'],
        ['value' => '99.98%', 'label' => 'Gateway authorization success rate'],
        ['value' => '35%+',   'label' => 'Mobile conversion rate uplift'],
    ]]); ?>
  </div>
</section>

<!-- =========================================================================
     SECTION 4: CORE CAPABILITIES (CATEGORY 1 - 6 IMAGES)
     ========================================================================= -->
<section class="section ecom-section-16-9" id="capabilities">
  <div class="ecom-widescreen-shell">
    <?php component('section-head', [
        'eyebrow' => 'Category 01 • Core Capabilities',
        'title'   => 'Conversion-Engineered Storefront Infrastructure',
        'lead'    => 'No line item here is aspirational — each capability runs live in production across high-traffic retail brands.',
        'art'     => 'sec-capabilities',
    ]); ?>
  </div>

  <div class="ecom-widescreen-shell">
    <div class="ecom-cards-grid">
      <!-- 01 -->
      <article class="ecom-img-card" data-reveal style="--d:0">
        <figure class="ecom-img-figure">
          <img src="<?= e(asset('assets/img/ecommerce-dev/cap-01-checkout.jpg')) ?>" width="800" height="533" alt="Checkout Optimisation" loading="eager" decoding="async">
          <span class="ecom-img-badge">CAPABILITY 01</span>
          <span class="ecom-img-stat">&lt; 850ms TTI</span>
        </figure>
        <div class="ecom-img-content">
          <h3 class="ecom-img-title">Checkout Optimisation</h3>
          <p class="ecom-img-desc">Fewer screens, saved addresses, biometric wallet support, and transparent shipping costs calculated before the final step.</p>
        </div>
      </article>

      <!-- 02 -->
      <article class="ecom-img-card" data-reveal style="--d:1">
        <figure class="ecom-img-figure">
          <img src="<?= e(asset('assets/img/ecommerce-dev/cap-02-payments.jpg')) ?>" width="800" height="533" alt="Payments and Wallets" loading="eager" decoding="async">
          <span class="ecom-img-badge">CAPABILITY 02</span>
          <span class="ecom-img-stat">99.98% SUCCESS</span>
        </figure>
        <div class="ecom-img-content">
          <h3 class="ecom-img-title">Payments & Multi-Gateway</h3>
          <p class="ecom-img-desc">Razorpay, Stripe, UPI Autopay, and COD reconciliation with webhook-driven order state that survives network drops.</p>
        </div>
      </article>

      <!-- 03 -->
      <article class="ecom-img-card" data-reveal style="--d:2">
        <figure class="ecom-img-figure">
          <img src="<?= e(asset('assets/img/ecommerce-dev/cap-03-inventory.jpg')) ?>" width="800" height="533" alt="Inventory and OMS" loading="eager" decoding="async">
          <span class="ecom-img-badge">CAPABILITY 03</span>
          <span class="ecom-img-stat">0.00% OVERSELL</span>
        </figure>
        <div class="ecom-img-content">
          <h3 class="ecom-img-title">Inventory & Distributed OMS</h3>
          <p class="ecom-img-desc">Real-time stock counts across channels with atomic reservation locks preventing overselling during traffic flash spikes.</p>
        </div>
      </article>

      <!-- 04 -->
      <article class="ecom-img-card" data-reveal style="--d:0">
        <figure class="ecom-img-figure">
          <img src="<?= e(asset('assets/img/ecommerce-dev/cap-04-catalog.jpg')) ?>" width="800" height="533" alt="Catalogue and Merchandising" loading="eager" decoding="async">
          <span class="ecom-img-badge">CAPABILITY 04</span>
          <span class="ecom-img-stat">50k+ QPS</span>
        </figure>
        <div class="ecom-img-content">
          <h3 class="ecom-img-title">Catalogue & Merchandising</h3>
          <p class="ecom-img-desc">Complex variant modelling, sub-second faceted filtering, and dynamic visual merchandising rules your marketing team controls.</p>
        </div>
      </article>

      <!-- 05 -->
      <article class="ecom-img-card" data-reveal style="--d:1">
        <figure class="ecom-img-figure">
          <img src="<?= e(asset('assets/img/ecommerce-dev/cap-05-returns.jpg')) ?>" width="800" height="533" alt="Returns and Support" loading="eager" decoding="async">
          <span class="ecom-img-badge">CAPABILITY 05</span>
          <span class="ecom-img-stat">-28% RTO RATE</span>
        </figure>
        <div class="ecom-img-content">
          <h3 class="ecom-img-title">Returns & Reverse Logistics</h3>
          <p class="ecom-img-desc">Self-serve automated returns portal directly integrated into WMS, turning return friction into repeat customer loyalty.</p>
        </div>
      </article>

      <!-- 06 -->
      <article class="ecom-img-card" data-reveal style="--d:2">
        <figure class="ecom-img-figure">
          <img src="<?= e(asset('assets/img/ecommerce-dev/cap-06-headless.jpg')) ?>" width="800" height="533" alt="Headless Commerce Core" loading="eager" decoding="async">
          <span class="ecom-img-badge">CAPABILITY 06</span>
          <span class="ecom-img-stat">100% LIGHTHOUSE</span>
        </figure>
        <div class="ecom-img-content">
          <h3 class="ecom-img-title">Headless Commerce Core</h3>
          <p class="ecom-img-desc">Decoupled edge frontends built on Hydrogen and Next.js, serving cached storefronts globally with instantaneous navigation.</p>
        </div>
      </article>
    </div>
  </div>
</section>

<!-- =========================================================================
     SECTION 5: COMMERCE PLATFORMS & ARCHITECTURE (CATEGORY 2 - 6 IMAGES)
     ========================================================================= -->
<?php
/*
 * Platforms: the pictures ride Originkit's Magazine Flip — a corridor of pages
 * you drag or scroll through, tap one and it turns to face you — and the
 * writing lives in the deck cards below, which is where a reader (and a search
 * engine) can actually take it in.
 */
$platformPages = [
    ['arch-01-shopify.jpg',     'Shopify Plus and Hydrogen storefronts'],
    ['arch-02-woocommerce.jpg', 'Enterprise WooCommerce at scale'],
    ['arch-03-magento.jpg',     'Adobe Commerce B2B workflows'],
    ['arch-04-python.jpg',      'Custom Python and Django commerce'],
    ['arch-05-medusa.jpg',      'MedusaJS headless commerce'],
    ['arch-06-mobile.jpg',      'Native mobile storefronts'],
];

$platformFlipProps = [
    'images' => array_map(static fn (array $p): array => [
        'image' => ['src' => asset('assets/img/ecommerce-dev/' . $p[0]), 'alt' => $p[1]],
    ], $platformPages),
    'background' => 'transparent',
    // 12 pages over 6 pictures: the corridor repeats the set twice, which reads
    // as a magazine rather than as six planes in a row.
    'pages'      => 12,
    'spacing'    => 5,
    /* Straight on and larger: with a tilt the corridor rides up into the top
       third of a 16:9 stage and leaves the rest of it empty. */
    'tilt'       => 0,
    'turn'       => 0,
    'pageWidth'  => 820,
    'pageHeight' => 560,
    'scrollSens' => 4,
    'travel'     => ['drift' => 1.4, 'smoothing' => 5, 'wave' => 4],
    'view'       => ['tap' => true, 'zoom' => 6, 'speed' => 5],
];

/* num, tag, title, subtitle, description, three proof points, stat */
$platformDeck = [
    ['01', 'Architecture', 'Shopify Plus & Hydrogen', 'Liquid apps and a React storefront on the edge',
     'Bespoke Liquid apps, custom Hydrogen React storefronts and Storefront API optimisations that scale past 10,000 orders a minute.',
     ['Custom Hydrogen React storefront', 'Storefront API query budgets', 'Checkout extensibility, not scripts'], 'Global edge'],
    ['02', 'Architecture', 'Enterprise WooCommerce', 'WordPress kept fast under real load',
     'Decoupled database read-replicas, Redis object caching and tailored checkout flows that keep WordPress quick at enterprise volume.',
     ['Read-replica database split', 'Redis object cache', 'Rewritten checkout flow'], 'Enterprise WP'],
    ['03', 'Architecture', 'Adobe Commerce / Magento', 'Built for B2B buyers and complex catalogues',
     'Enterprise B2B buyer workflows, tiered volume pricing, quotation requests and multi-store catalogue hierarchies.',
     ['Tiered volume pricing', 'Quote-to-order workflow', 'Multi-store catalogue trees'], 'B2B tiered'],
    ['04', 'Architecture', 'Custom Python & Django', 'No platform fees and no ceiling',
     'Zero platform fees and unlimited extensibility: a high-concurrency order ledger written in Python, FastAPI and PostgreSQL.',
     ['High-concurrency order ledger', 'FastAPI service layer', 'PostgreSQL as the source of truth'], 'Zero lock-in'],
    ['05', 'Architecture', 'MedusaJS Headless Engine', 'Composable commerce in Node.js',
     'Modern open-source commerce with pluggable modules for cart, tax, fulfilment and customer segments.',
     ['Pluggable cart and tax modules', 'Own the data model', 'Fulfilment providers swappable'], 'Headless Node'],
    ['06', 'Architecture', 'Native Mobile Storefronts', 'A shop that lives on the home screen',
     'High-speed native iOS and Android apps with biometric Apple Pay and UPI payments, personalised pushes and offline carts.',
     ['Biometric Apple Pay and UPI', 'Personalised push campaigns', 'Carts that survive no signal'], '4.9 rating'],
];
?>
<section class="section section--panel ecom-section-16-9" id="platforms">
  <div class="ecom-widescreen-shell">
    <?php component('section-head', [
        'eyebrow' => 'Category 02 • Platforms & Architecture',
        'title'   => 'Architectures Chosen On Margin & Growth',
        'lead'    => 'We build on the exact platform matched to your catalog complexity, SKU turnover, and backend ERP requirements.',
    ]); ?>
  </div>

  <div class="ecom-3d-stage ecom-3d-stage--magazine" data-reveal>
    <div class="ecom-3d-stage-header">
      <div class="ecom-3d-pill">
        <span class="pulse-dot" style="width:7px;height:7px;border-radius:50%;background:#3EE1FF;box-shadow:0 0 8px #3EE1FF;"></span>
        Six Commerce Architectures
      </div>
      <div class="ecom-3d-hint">Drag or Scroll the Corridor • Tap a Page to Hold It Up</div>
    </div>
    <div class="ecom-3d-stage-body">
      <div data-ok="magazine-flip" data-props="<?= htmlspecialchars(json_encode($platformFlipProps, JSON_UNESCAPED_SLASHES), ENT_QUOTES, 'UTF-8') ?>"></div>
    </div>
  </div>

  <div class="ecom-widescreen-shell">
    <div class="ecom-deck">
      <?php foreach ($platformDeck as $i => [$num, $tag, $title, $sub, $desc, $points, $stat]): ?>
        <?php component('ecom-deck-card', [
            'num' => $num, 'tag' => $tag, 'title' => $title, 'sub' => $sub,
            'desc' => $desc, 'points' => $points, 'stat' => $stat,
            'image' => 'assets/img/ecommerce-dev/' . $platformPages[$i][0],
            'alt' => $platformPages[$i][1], 'index' => $i,
        ]); ?>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- =========================================================================
     SECTION 6: PAYMENT RAILS & CHECKOUT SECURITY (CATEGORY 3 - 5 IMAGES)
     ========================================================================= -->
<?php
/*
 * Payment rails: five deck cards, same shape as the platform set. Originkit's
 * Depth Gallery was the ask here, but it is a paid component this account
 * cannot fetch, so the cards carry the depth themselves — the picture sits on
 * its own plane behind the copy and lifts on hover.
 */
$railsDeck = [
    ['01', 'Rail', 'UPI Autopay & QR Engine', 'Every Indian wallet, one intent flow',
     'Deep-linked UPI intent routing across PhonePe, Google Pay and Paytm, with automated fallback retry rails.',
     ['Deep-linked intent routing', 'Autopay mandates and reminders', 'Automatic retry on a failed rail'],
     '99.9% UPI', 'rail-01-upi.jpg', 'UPI Autopay and QR engine'],
    ['02', 'Rail', 'Global Stripe Rails', 'Sell in the buyer\'s own currency',
     'Cross-border multi-currency transactions, automatic tax remittance and local payment methods for 135+ countries.',
     ['Multi-currency presentment', 'Automatic tax remittance', 'Local methods per market'],
     '135+ currencies', 'rail-02-stripe.jpg', 'Global Stripe payment rails'],
    ['03', 'Rail', 'One-Tap Digital Wallets', 'Checkout before the doubt arrives',
     'Instant customer authentication and pre-filled shipping addresses through Apple Pay, Google Pay and OTP pre-fill.',
     ['Apple Pay and Google Pay', 'Address pre-fill from the wallet', 'OTP read without leaving checkout'],
     '1-tap checkout', 'rail-03-wallets.jpg', 'One-tap digital wallets'],
    ['04', 'Rail', 'COD & RTO Risk Defence', 'The order that never should have shipped',
     'Predictive scoring on addresses and buyer history that converts high-risk cash-on-delivery orders to prepaid before dispatch.',
     ['Address and history scoring', 'Prepaid nudge at the risky order', 'Courier serviceability checks'],
     '94% accuracy', 'rail-04-fraud.jpg', 'Cash on delivery and RTO risk defence'],
    ['05', 'Rail', 'PCI-DSS Token Vault', 'Card data you never have to hold',
     'Zero plaintext card retention: end-to-end client tokenisation and HSM encryption that keeps you audit-proof.',
     ['Client-side tokenisation', 'HSM-held keys', 'Nothing in plaintext, ever'],
     'Audit-proof', 'rail-05-pci-dss.jpg', 'PCI-DSS token vault'],
];
?>
<section class="section ecom-section-16-9" id="payment-rails">
  <div class="ecom-widescreen-shell">
    <?php component('section-head', [
        'eyebrow' => 'Category 03 • Payment Rails & Security',
        'title'   => 'Transaction Rails That Never Drop A Conversion',
        'lead'    => 'Resilient gateway fallbacks, fraud mitigation, and tokenized payment pipelines that maximize authorization rates.',
    ]); ?>

    <div class="ecom-deck ecom-deck--rails">
      <?php foreach ($railsDeck as $i => [$num, $tag, $title, $sub, $desc, $points, $stat, $img, $alt]): ?>
        <?php component('ecom-deck-card', [
            'num' => $num, 'tag' => $tag, 'title' => $title, 'sub' => $sub,
            'desc' => $desc, 'points' => $points, 'stat' => $stat,
            'image' => 'assets/img/ecommerce-dev/' . $img, 'alt' => $alt, 'index' => $i,
        ]); ?>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- =========================================================================
     SECTION 7: OPERATIONS, WAREHOUSE & LOGISTICS (CATEGORY 4 - 5 IMAGES)
     ========================================================================= -->
<?php
/*
 * The five fulfilment pictures drift through the frame on their own currents;
 * a click brings one to the centre at full size and a second click lets it go.
 * See app/originkit/src/components/originkit/floating-gallery.tsx.
 */
$omsGalleryProps = [
    'images' => [
        ['src' => asset('assets/img/ecommerce-dev/oms-01-warehouse.jpg'),  'alt' => 'Multi-warehouse dispatch routing'],
        ['src' => asset('assets/img/ecommerce-dev/oms-02-shipping.jpg'),   'alt' => 'Multi-courier AWB aggregation'],
        ['src' => asset('assets/img/ecommerce-dev/oms-03-flash-sales.jpg'),'alt' => 'Flash-sale concurrency protection'],
        ['src' => asset('assets/img/ecommerce-dev/oms-04-wms-barcode.jpg'),'alt' => 'Barcode pick and pack in the warehouse'],
        ['src' => asset('assets/img/ecommerce-dev/oms-05-tracking.jpg'),   'alt' => 'Live milestone tracking for buyers'],
    ],
    'background' => 'transparent',
    'cardWidth'  => 320,
    'cardHeight' => 400,
    'rounded'    => 14,
    'speed'      => 34,
    'fade'       => 14,
];
?>
<section class="section section--panel ecom-section-16-9" id="operations-logistics">
  <div class="ecom-widescreen-shell">
    <?php component('section-head', [
        'eyebrow' => 'Category 04 • OMS, Logistics & Fulfillment',
        'title'   => 'Operational Back Office That Keeps Promises',
        'lead'    => 'Automated warehouse routing, carrier rate bargaining, and live milestone visibility from dock to doorstep.',
    ]); ?>
  </div>

  <!-- Floating gallery: drifting cards, click one to bring it forward -->
  <div class="ecom-3d-stage ecom-3d-stage--floating" data-reveal>
    <div class="ecom-3d-stage-header">
      <div class="ecom-3d-pill">
        <span class="pulse-dot" style="width:7px;height:7px;border-radius:50%;background:#3EE1FF;box-shadow:0 0 8px #3EE1FF;"></span>
        OriginKit Floating Gallery
      </div>
      <div class="ecom-3d-hint">16:9 Full Screen • Endless Drift • Click a Card to Enlarge</div>
    </div>
    <div class="ecom-3d-stage-body">
      <div data-ok="floating-gallery" data-props="<?= htmlspecialchars(json_encode($omsGalleryProps, JSON_UNESCAPED_SLASHES), ENT_QUOTES, 'UTF-8') ?>"></div>
    </div>
  </div>

  <div class="ecom-widescreen-shell">
    <div class="ecom-cards-grid ecom-cards-grid--5">
      <!-- 18 -->
      <article class="ecom-img-card" data-reveal style="--d:0">
        <figure class="ecom-img-figure">
          <img src="<?= e(asset('assets/img/ecommerce-dev/oms-01-warehouse.jpg')) ?>" width="800" height="533" alt="Smart Node Routing" loading="eager" decoding="async">
          <span class="ecom-img-badge">LOGISTICS 01</span>
          <span class="ecom-img-stat">NEXT-DAY</span>
        </figure>
        <div class="ecom-img-content">
          <h3 class="ecom-img-title">Smart Node Routing</h3>
          <p class="ecom-img-desc">Dynamic multi-warehouse dispatch algorithms route shipments from the closest hub, slashing delivery times and freight costs.</p>
        </div>
      </article>

      <!-- 19 -->
      <article class="ecom-img-card" data-reveal style="--d:1">
        <figure class="ecom-img-figure">
          <img src="<?= e(asset('assets/img/ecommerce-dev/oms-02-shipping.jpg')) ?>" width="800" height="533" alt="Multi-Courier Aggregation" loading="eager" decoding="async">
          <span class="ecom-img-badge">LOGISTICS 02</span>
          <span class="ecom-img-stat">AUTO AWB</span>
        </figure>
        <div class="ecom-img-content">
          <h3 class="ecom-img-title">Courier Aggregation</h3>
          <p class="ecom-img-desc">Instant AWB generation across Bluedart, Delhivery, and Shiprocket with automatic SLA-based carrier selection.</p>
        </div>
      </article>

      <!-- 20 -->
      <article class="ecom-img-card" data-reveal style="--d:2">
        <figure class="ecom-img-figure">
          <img src="<?= e(asset('assets/img/ecommerce-dev/oms-03-flash-sales.jpg')) ?>" width="800" height="533" alt="Flash-Sale Concurrency Protection" loading="eager" decoding="async">
          <span class="ecom-img-badge">LOGISTICS 03</span>
          <span class="ecom-img-stat">100k REQ/SEC</span>
        </figure>
        <div class="ecom-img-content">
          <h3 class="ecom-img-title">Flash-Sale Concurrency</h3>
          <p class="ecom-img-desc">Redis atomic queues and token-bucket rate limiting guarantee zero server crashes during high-demand product drops.</p>
        </div>
      </article>

      <!-- 21 -->
      <article class="ecom-img-card" data-reveal style="--d:3">
        <figure class="ecom-img-figure">
          <img src="<?= e(asset('assets/img/ecommerce-dev/oms-04-wms-barcode.jpg')) ?>" width="800" height="533" alt="Barcode Pick & Pack WMS" loading="eager" decoding="async">
          <span class="ecom-img-badge">LOGISTICS 04</span>
          <span class="ecom-img-stat">99.99% ACCURACY</span>
        </figure>
        <div class="ecom-img-content">
          <h3 class="ecom-img-title">Barcode Scanner WMS</h3>
          <p class="ecom-img-desc">Direct handheld barcode scanner integrations for pick-list verification, eliminating packing errors at the dispatch line.</p>
        </div>
      </article>

      <!-- 22 -->
      <article class="ecom-img-card" data-reveal style="--d:4">
        <figure class="ecom-img-figure">
          <img src="<?= e(asset('assets/img/ecommerce-dev/oms-05-tracking.jpg')) ?>" width="800" height="533" alt="Live Milestone Tracking" loading="eager" decoding="async">
          <span class="ecom-img-badge">LOGISTICS 05</span>
          <span class="ecom-img-stat">REAL-TIME GPS</span>
        </figure>
        <div class="ecom-img-content">
          <h3 class="ecom-img-title">Live Tracking & Alerts</h3>
          <p class="ecom-img-desc">Branded tracking portals with real-time status updates delivered directly to buyers via WhatsApp and SMS webhooks.</p>
        </div>
      </article>
    </div>
  </div>
</section>

<!-- =========================================================================
     SECTION 8: AI MERCHANDISING & CONVERSION GROWTH (CATEGORY 5 - 4 IMAGES)
     ========================================================================= -->
<?php
$aiShowcaseProps = [
    'cards' => [
        [
            'number' => '01',
            'title' => 'Neural Recommendations',
            'description' => 'Real-time collaborative filtering and cart bundle predictions tailored to shopper intent, lifting basket sizes by 34%.',
            'image' => [
                'src' => asset('assets/img/ecommerce-dev/ai-01-recs.jpg'),
                'alt' => 'Neural Recommendations',
            ],
            'tag' => '+34% AOV BOOST',
        ],
        [
            'number' => '02',
            'title' => 'Visual AI Search',
            'description' => 'Upload a photo to discover matching catalog items instantly using vector embeddings on fabrics, silhouettes, and colors.',
            'image' => [
                'src' => asset('assets/img/ecommerce-dev/ai-02-visual-search.jpg'),
                'alt' => 'Visual AI Search',
            ],
            'tag' => '< 150ms LATENCY',
        ],
        [
            'number' => '03',
            'title' => 'Dynamic Price Rules',
            'description' => 'Automated price elasticity models that respond to competitor feeds and inventory velocity while guarding margins.',
            'image' => [
                'src' => asset('assets/img/ecommerce-dev/ai-03-pricing.jpg'),
                'alt' => 'Dynamic Price Rules',
            ],
            'tag' => 'MARGIN OPTIMISED',
        ],
        [
            'number' => '04',
            'title' => 'RFM Customer Cohorts',
            'description' => 'Continuous recency-frequency-monetary clustering that triggers automated personalized offers to win back churned buyers.',
            'image' => [
                'src' => asset('assets/img/ecommerce-dev/ai-04-segments.jpg'),
                'alt' => 'RFM Customer Cohorts',
            ],
            'tag' => '3.8x RETENTION',
        ],
    ],
    'progressColor' => '#3EE1FF',
    'animationSpeed' => 4.5,
    'loop' => true,
    'textColor' => '#E0EDFF',
    'numberColor' => '#3EE1FF',
    'tagColor' => '#00F2FE',
    'imageRadius' => 16,
    'padding' => 36,
    'contentImageGap' => 18,
];
?>
<section class="section ecom-section-16-9" id="ai-merchandising">
  <div class="ecom-widescreen-shell">
    <?php component('section-head', [
        'eyebrow' => 'Category 05 • AI Merchandising',
        'title'   => 'Intelligent Discovery, Pricing & Retention',
        'lead'    => 'Embed machine learning into search, merchandising, and buyer retention to continuously lift Average Order Value.',
    ]); ?>
  </div>

  <!-- Interactive 3D Expanding Showcase Deck (Full Screen 16:9, Not in Box) -->
  <div class="ecom-3d-stage ecom-3d-stage--cardshowcase" data-reveal>
    <div class="ecom-3d-stage-header">
      <div class="ecom-3d-pill">
        <span class="pulse-dot" style="width:7px;height:7px;border-radius:50%;background:#3EE1FF;box-shadow:0 0 8px #3EE1FF;"></span>
        Framer 3D Expanding Showcase Deck
      </div>
      <div class="ecom-3d-hint">16:9 Full Screen • Dynamic Progress Timing • Click Card to Expand</div>
    </div>
    <div class="ecom-3d-stage-body">
      <div data-ok="card-showcase" data-props="<?= htmlspecialchars(json_encode($aiShowcaseProps, JSON_UNESCAPED_SLASHES), ENT_QUOTES, 'UTF-8') ?>"></div>
    </div>
  </div>

  <div class="ecom-widescreen-shell">
    <div class="ecom-cards-grid ecom-cards-grid--4">
      <!-- 23 -->
      <article class="ecom-img-card" data-reveal style="--d:0">
        <figure class="ecom-img-figure">
          <img src="<?= e(asset('assets/img/ecommerce-dev/ai-01-recs.jpg')) ?>" width="800" height="533" alt="Neural Recommendation Engine" loading="eager" decoding="async">
          <span class="ecom-img-badge">AI COMMERCE 01</span>
          <span class="ecom-img-stat">+34% AOV BOOST</span>
        </figure>
        <div class="ecom-img-content">
          <h3 class="ecom-img-title">Neural Recommendations</h3>
          <p class="ecom-img-desc">Real-time collaborative filtering and cart bundle predictions tailored to shopper intent, lifting basket sizes by 34%.</p>
        </div>
      </article>

      <!-- 24 -->
      <article class="ecom-img-card" data-reveal style="--d:1">
        <figure class="ecom-img-figure">
          <img src="<?= e(asset('assets/img/ecommerce-dev/ai-02-visual-search.jpg')) ?>" width="800" height="533" alt="Visual AI Product Search" loading="eager" decoding="async">
          <span class="ecom-img-badge">AI COMMERCE 02</span>
          <span class="ecom-img-stat">&lt; 150ms LATENCY</span>
        </figure>
        <div class="ecom-img-content">
          <h3 class="ecom-img-title">Visual AI Search</h3>
          <p class="ecom-img-desc">Upload a photo to discover matching catalog items instantly using vector embeddings on fabrics, silhouettes, and colors.</p>
        </div>
      </article>

      <!-- 25 -->
      <article class="ecom-img-card" data-reveal style="--d:2">
        <figure class="ecom-img-figure">
          <img src="<?= e(asset('assets/img/ecommerce-dev/ai-03-pricing.jpg')) ?>" width="800" height="533" alt="Algorithmic Dynamic Pricing" loading="eager" decoding="async">
          <span class="ecom-img-badge">AI COMMERCE 03</span>
          <span class="ecom-img-stat">MARGIN OPTIMISED</span>
        </figure>
        <div class="ecom-img-content">
          <h3 class="ecom-img-title">Dynamic Price Rules</h3>
          <p class="ecom-img-desc">Automated price elasticity models that respond to competitor feeds and inventory velocity while guarding margins.</p>
        </div>
      </article>

      <!-- 26 -->
      <article class="ecom-img-card" data-reveal style="--d:3">
        <figure class="ecom-img-figure">
          <img src="<?= e(asset('assets/img/ecommerce-dev/ai-04-segments.jpg')) ?>" width="800" height="533" alt="RFM Customer Cohorts" loading="eager" decoding="async">
          <span class="ecom-img-badge">AI COMMERCE 04</span>
          <span class="ecom-img-stat">3.8x RETENTION</span>
        </figure>
        <div class="ecom-img-content">
          <h3 class="ecom-img-title">RFM Customer Cohorts</h3>
          <p class="ecom-img-desc">Continuous recency-frequency-monetary clustering that triggers automated personalized offers to win back churned buyers.</p>
        </div>
      </article>
    </div>
  </div>
</section>

<!-- =========================================================================
     SECTION 9: ENTERPRISE CASE STUDIES & PROOF (CATEGORY 6 - 4 IMAGES)
     ========================================================================= -->
<?php
$casesSwipeProps = [
    'images' => [
        ['src' => asset('assets/img/ecommerce-dev/case-01-luxury.jpg')],
        ['src' => asset('assets/img/ecommerce-dev/case-02-marketplace.jpg')],
        ['src' => asset('assets/img/ecommerce-dev/case-03-subscription.jpg')],
        ['src' => asset('assets/img/ecommerce-dev/case-04-b2b.jpg')],
    ],
    'cardWidth' => 380,
    'cardHeight' => 480,
    'cardRadius' => 20,
    'tiltAngle' => -22,
    'xOffset' => 190,
    'swipeThreshold' => 40,
];
?>
<section class="section section--panel ecom-section-16-9" id="case-studies">
  <div class="ecom-widescreen-shell">
    <?php component('section-head', [
        'eyebrow' => 'Category 06 • Production Proof',
        'title'   => 'Platforms Shipped & Scaling In Production',
        'lead'    => 'Real transactional scale across high-volume fashion, marketplaces, FMCG subscriptions, and B2B wholesale.',
    ]); ?>
  </div>

  <!-- Interactive 3D Swipe Stack (Full Screen 16:9, Not in Box) -->
  <div class="ecom-3d-stage ecom-3d-stage--swipestack" data-reveal>
    <div class="ecom-3d-stage-header">
      <div class="ecom-3d-pill">
        <span class="pulse-dot" style="width:7px;height:7px;border-radius:50%;background:#3EE1FF;box-shadow:0 0 8px #3EE1FF;"></span>
        OriginKit 3D Physics Swipe Stack
      </div>
      <div class="ecom-3d-hint">16:9 Full Screen • Swipe / Drag Left or Right • Spring Dynamics</div>
    </div>
    <div class="ecom-3d-stage-body">
      <div data-ok="swipe-stack" data-props="<?= htmlspecialchars(json_encode($casesSwipeProps, JSON_UNESCAPED_SLASHES), ENT_QUOTES, 'UTF-8') ?>"></div>
    </div>
  </div>

  <div class="ecom-widescreen-shell">
    <div class="ecom-cards-grid ecom-cards-grid--4">
      <!-- 27 -->
      <article class="ecom-img-card" data-reveal style="--d:0">
        <figure class="ecom-img-figure">
          <img src="<?= e(asset('assets/img/ecommerce-dev/case-01-luxury.jpg')) ?>" width="800" height="533" alt="D2C Luxury Apparel" loading="eager" decoding="async">
          <span class="ecom-img-badge">CASE STUDY 01</span>
          <span class="ecom-img-stat">120k ORDERS/DAY</span>
        </figure>
        <div class="ecom-img-content">
          <h3 class="ecom-img-title">D2C Luxury Fashion Brand</h3>
          <p class="ecom-img-desc">Headless Hydrogen storefront handling 120k orders during seasonal drops with custom 3D garment visualization and 0.7s page loads.</p>
        </div>
      </article>

      <!-- 28 -->
      <article class="ecom-img-card" data-reveal style="--d:1">
        <figure class="ecom-img-figure">
          <img src="<?= e(asset('assets/img/ecommerce-dev/case-02-marketplace.jpg')) ?>" width="800" height="533" alt="Multi-Vendor Marketplace" loading="eager" decoding="async">
          <span class="ecom-img-badge">CASE STUDY 02</span>
          <span class="ecom-img-stat">SPLIT ESCROW</span>
        </figure>
        <div class="ecom-img-content">
          <h3 class="ecom-img-title">Multi-Vendor Marketplace</h3>
          <p class="ecom-img-desc">Electronics multi-seller hub with automated split payouts, escrow holding, seller commissions, and unified customer checkout.</p>
        </div>
      </article>

      <!-- 29 -->
      <article class="ecom-img-card" data-reveal style="--d:2">
        <figure class="ecom-img-figure">
          <img src="<?= e(asset('assets/img/ecommerce-dev/case-03-subscription.jpg')) ?>" width="800" height="533" alt="FMCG Subscription Box" loading="eager" decoding="async">
          <span class="ecom-img-badge">CASE STUDY 03</span>
          <span class="ecom-img-stat">RECURRING MRR</span>
        </figure>
        <div class="ecom-img-content">
          <h3 class="ecom-img-title">FMCG Subscription Engine</h3>
          <p class="ecom-img-desc">Recurring wellness delivery engine with smart replenishment reminders, self-service box pauses, and 98.4% billing success.</p>
        </div>
      </article>

      <!-- 30 -->
      <article class="ecom-img-card" data-reveal style="--d:3">
        <figure class="ecom-img-figure">
          <img src="<?= e(asset('assets/img/ecommerce-dev/case-04-b2b.jpg')) ?>" width="800" height="533" alt="B2B Wholesale Portal" loading="eager" decoding="async">
          <span class="ecom-img-badge">CASE STUDY 04</span>
          <span class="ecom-img-stat">NET-30 INVOICING</span>
        </figure>
        <div class="ecom-img-content">
          <h3 class="ecom-img-title">B2B Wholesale Portal</h3>
          <p class="ecom-img-desc">Bulk purchasing portal with automated GST tax calculation, Net-30 credit limits, and custom quotation approval pipelines.</p>
        </div>
      </article>
    </div>
  </div>
</section>

<!-- =========================================================================
     SECTION 10: INTERACTIVE ENGINEERING TECH STACK (30 TOOLCHAINS)
     ========================================================================= -->
<?php component('ecommerce/tech-stack'); ?>

<!-- =========================================================================
     SECTION 11: FREQUENTLY ASKED QUESTIONS
     ========================================================================= -->
<section class="section ecom-section-16-9" id="faq">
  <div class="ecom-widescreen-shell">
    <?php component('section-head', [
        'eyebrow' => 'Frequently Asked Questions',
        'title'   => 'Clear Answers on E-Commerce Architecture',
        'lead'    => 'Real questions on headless vs platform builds, migration downtime, and payment security.',
    ]); ?>

    <div class="grid grid-2" style="gap:28px;max-width:1440px;margin:0 auto;">
      <div class="card" style="padding:32px;">
        <h3 style="color:#FFF;font-size:1.15rem;margin-bottom:12px;">Should we choose Headless or a monolithic platform?</h3>
        <p style="color:#9AA7BD;line-height:1.6;font-size:0.95rem;">If your business is under 1,000 SKUs with standard checkout rules, a tuned Shopify Plus or WooCommerce platform delivers speed without overhead. If you have complex variant configuration, omnichannel apps, or high-volume international pricing, headless Hydrogen/Next.js delivers unmatched control.</p>
      </div>

      <div class="card" style="padding:32px;">
        <h3 style="color:#FFF;font-size:1.15rem;margin-bottom:12px;">How do you prevent overselling during flash sales?</h3>
        <p style="color:#9AA7BD;line-height:1.6;font-size:0.95rem;">We implement atomic inventory reservation queues in Redis. When a customer initiates checkout, stock is locked with a 10-minute TTL. If the payment fails or expires, stock is immediately released back to the pool with zero human intervention.</p>
      </div>

      <div class="card" style="padding:32px;">
        <h3 style="color:#FFF;font-size:1.15rem;margin-bottom:12px;">What is your strategy for reducing RTO on COD orders?</h3>
        <p style="color:#9AA7BD;line-height:1.6;font-size:0.95rem;">We deploy automated address verification, phone-number OTP validation, and ML risk scoring that flags high-RTO pincodes. High-risk orders are nudged toward partial online payment or incentivized with prepaid discounts.</p>
      </div>

      <div class="card" style="padding:32px;">
        <h3 style="color:#FFF;font-size:1.15rem;margin-bottom:12px;">Can we migrate from our existing store without losing SEO or orders?</h3>
        <p style="color:#9AA7BD;line-height:1.6;font-size:0.95rem;">Yes. We run parallel delta syncs of customers, orders, and products. URL structures are preserved with 1-to-1 301 redirects, and DNS cutover happens during low-traffic windows with zero downtime.</p>
      </div>
    </div>
  </div>
</section>

<!-- =========================================================================
     SECTION 12: CALL TO ACTION (CINEMATIC 16:9 WIDESCREEN)
     ========================================================================= -->
<section class="section ecom-section-16-9 ecom-cta-section" id="contact-cta">
  <div class="ecom-widescreen-shell">
    <div class="cta-panel ecom-cta-panel" data-reveal>
      <p class="eyebrow" style="justify-content:center">Start Your Commerce Build</p>
      <h2 class="section-title">Build An E-Commerce Platform That Never Slows Down.</h2>
      <p>Tell us about your catalog, transaction volume, and OMS integrations. We will return with a detailed technical scope and fixed timeline within two working days.</p>

      <div class="cta-actions">
        <button class="btn btn-primary" type="button" data-modal-open data-modal-service="<?= e($svc['title']) ?>">
          Start Your Project<?= icon('arrow') ?>
        </button>
        <a class="btn btn-ghost" href="<?= e(url('services.php')) ?>">All services</a>
      </div>
    </div>
  </div>
</section>
<script type="module" src="<?= e(url('assets/dist/originkit/originkit.js')) ?>"></script>
<?php
require dirname(__DIR__) . '/includes/footer.php';
