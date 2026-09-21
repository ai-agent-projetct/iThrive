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
$platformsSliderProps = [
    /* The label is the slide's whole caption: the overlay renders one
       nowrap line, so it carries the platform and the number that
       matters rather than a paragraph it would clip. */
    'slides' => [
        ['image' => asset('assets/img/ecommerce-dev/arch-01-shopify.jpg'), 'title' => 'Shopify Plus & Hydrogen · 10,000 orders a minute'],
        ['image' => asset('assets/img/ecommerce-dev/arch-02-woocommerce.jpg'), 'title' => 'Enterprise WooCommerce · Redis-cached at scale'],
        ['image' => asset('assets/img/ecommerce-dev/arch-03-magento.jpg'), 'title' => 'Adobe Commerce · B2B tiered pricing'],
        ['image' => asset('assets/img/ecommerce-dev/arch-04-python.jpg'), 'title' => 'Custom Python & Django · zero platform fees'],
        ['image' => asset('assets/img/ecommerce-dev/arch-05-medusa.jpg'), 'title' => 'MedusaJS Headless · composable Node.js'],
        ['image' => asset('assets/img/ecommerce-dev/arch-06-mobile.jpg'), 'title' => 'Native mobile storefronts · 4.9★ rated'],
    ],
    'backgroundColor' => '#0B0F17',
    'direction' => 'horizontal',
    'borderRadius' => 0,
    'slideSize' => [
        'aspectRatio' => 1.5,
        'minHeight' => 1.25,
        'maxHeight' => 1.55,
        'gap' => 0.08,
        'randomHeights' => false,
        'activeScale' => 1.05,
    ],
    'effect' => [
        'preset' => 'cards',
        'distortionStrength' => 1.5,
        'perspective' => 45,
        'rotation' => 40,
        'depth' => 2.5,
    ],
    'autoplay' => [
        'enabled' => true,
        'speed' => 22,
    ],
    'snap' => [
        'enabled' => true,
        'strength' => 25,
    ],
    'showOverlay' => true,
    'overlayColor' => '#3EE1FF',
    'overlaySize' => 18,
    'counterSize' => 13,
    'overlayPosition' => 'bottom-left',
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

  <!-- Interactive 3D WebGL Cube/Slider (Full Screen 16:9, Not in Box) -->
  <div class="ecom-3d-stage ecom-3d-stage--scroll3d" data-reveal>
    <div class="ecom-3d-stage-header">
      <div class="ecom-3d-pill">
        <span class="pulse-dot" style="width:7px;height:7px;border-radius:50%;background:#3EE1FF;box-shadow:0 0 8px #3EE1FF;"></span>
        Framer 3D WebGL Horizon Slider
      </div>
      <div class="ecom-3d-hint">16:9 Full Screen • Continuous 3D Rotation • Drag / Wheel</div>
    </div>
    <div class="ecom-3d-stage-body">
      <div data-ok="scroll-3d-slider" data-props="<?= htmlspecialchars(json_encode($platformsSliderProps, JSON_UNESCAPED_SLASHES), ENT_QUOTES, 'UTF-8') ?>"></div>
    </div>
  </div>

</section>

<!-- =========================================================================
     SECTION 6: PAYMENT RAILS & CHECKOUT SECURITY (CATEGORY 3 - 5 IMAGES)
     ========================================================================= -->
<?php
/*
 * The rails ride the liquid carousel rather than the depth-blur one: this is
 * the same set of five pictures, but each panel carries its own label and
 * description, so the copy lives on the card instead of in a grid repeating it
 * underneath. card-showcase would also have done it — it is already used
 * further down this page, and two of them would read as one component twice.
 */
$railsCarouselProps = [
    'projects' => [
        ['brand' => 'UPI Autopay & QR Engine',  'description' => 'Deep-linked UPI intent routing across PhonePe, Google Pay and Paytm, with automated fallback retry rails.', 'image' => ['src' => asset('assets/img/ecommerce-dev/rail-01-upi.jpg'), 'alt' => 'UPI Autopay and QR engine']],
        ['brand' => 'Global Stripe Rails',      'description' => 'Cross-border multi-currency transactions, automatic tax remittance and local payment methods for 135+ countries.', 'image' => ['src' => asset('assets/img/ecommerce-dev/rail-02-stripe.jpg'), 'alt' => 'Global Stripe payment rails']],
        ['brand' => 'One-Tap Digital Wallets',  'description' => 'Instant authentication and pre-filled shipping addresses through Apple Pay, Google Pay and OTP pre-fill.', 'image' => ['src' => asset('assets/img/ecommerce-dev/rail-03-wallets.jpg'), 'alt' => 'One-tap digital wallets']],
        ['brand' => 'COD & RTO Risk Defence',   'description' => 'Predictive scoring on addresses and buyer history that converts high-risk cash-on-delivery orders to prepaid.', 'image' => ['src' => asset('assets/img/ecommerce-dev/rail-04-fraud.jpg'), 'alt' => 'Cash on delivery and RTO risk defence']],
        ['brand' => 'PCI-DSS Token Vault',      'description' => 'Zero plaintext card retention: end-to-end client tokenisation and HSM encryption that keeps you audit-proof.', 'image' => ['src' => asset('assets/img/ecommerce-dev/rail-05-pci-dss.jpg'), 'alt' => 'PCI-DSS token vault']],
    ],
    'panelHeight'      => 460,
    'gap'              => 20,
    'glide'            => 0.08,
    'wheelSensitivity' => 1,
    'snap'             => true,
    'lensShape'        => 'circle',
    'lensRotation'     => 0,
    'lensWidth'        => 0.22,
    'lensHeight'       => 0.82,
    'lensX'            => 0.0,
    'lensY'            => 0.5,
    'dispersion'       => 16,
    'zoom'             => 0.12,
    'blur'             => 0,
    'glow'             => 5.5,
    'blueRing'         => 6.5,
    'blueColor'        => '#3EE1FF',
    'shimmer'          => true,
    'rimWave'          => 0.65,
    'entryAnimation'   => false,
    'focusScale'       => 1.15,
    'background'       => 'rgba(0, 0, 0, 0)',
    'foreground'       => '#EAF0FA',
    'showLabels'       => true,
    'showCursor'       => true,
];
?>
<section class="section ecom-section-16-9" id="payment-rails">
  <div class="ecom-widescreen-shell">
    <?php component('section-head', [
        'eyebrow' => 'Category 03 • Payment Rails & Security',
        'title'   => 'Transaction Rails That Never Drop A Conversion',
        'lead'    => 'Resilient gateway fallbacks, fraud mitigation, and tokenized payment pipelines that maximize authorization rates.',
    ]); ?>
  </div>

  <!-- Interactive 3D Depth Blur Carousel (Full Screen 16:9, Not in Box) -->
  <div class="ecom-3d-stage ecom-3d-stage--liquid" data-reveal>
    <div class="ecom-3d-stage-header">
      <div class="ecom-3d-pill">
        <span class="pulse-dot" style="width:7px;height:7px;border-radius:50%;background:#3EE1FF;box-shadow:0 0 8px #3EE1FF;"></span>
        Liquid Lens Payment Rails
      </div>
      <div class="ecom-3d-hint">16:9 Full Screen • Liquid Lens • Drag / Wheel</div>
    </div>
    <div class="ecom-3d-stage-body">
      <div data-ok="liquid-carousel" data-props="<?= htmlspecialchars(json_encode($railsCarouselProps, JSON_UNESCAPED_SLASHES), ENT_QUOTES, 'UTF-8') ?>"></div>
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
