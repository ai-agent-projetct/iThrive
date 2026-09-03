<?php
/**
 * AI Development Company — ported from the ai-agent-projetct/AI-Development-company-
 * build and dropped into this site.
 *
 * That repository is a standalone single-page site with its own header, nav,
 * footer and 85KB stylesheet. Only the sixteen content sections came across.
 * The chrome did not: this page wears iThrive's header, nav, footer, chat widget
 * and contact modal like every other route, so it is part of the site rather
 * than a second site pasted into it.
 *
 * How the two design systems are kept apart:
 *
 * - The whole page sits inside `.aidev`, and assets/css/ai-dev.css is the source
 *   stylesheet with every selector rewritten to live under it — `:root`, `html`
 *   and `body` all collapse onto the wrapper, so its custom properties, its
 *   background and its typography stop at the wrapper's edge and cannot reach
 *   the shared header or footer. The transform was mechanical (postcss), not
 *   hand-edited, so the section styles are byte-for-byte the ones they were
 *   authored against.
 * - The stylesheet and scripts load only here, through $extraHead and the block
 *   at the foot of this file. No other route pays for any of it.
 *
 * Two things the source pulled from a CDN are vendored instead, matching how
 * this site already treats three: assets/vendor/three/three.r128.min.js. The
 * source's 3D scripts are written against r128's global THREE, and the r160
 * module this site imports elsewhere has a different API — so both live in the
 * tree and neither is loaded on a page that does not want it.
 *
 * Font Awesome is the one exception and still comes from cdnjs: the sections
 * carry 228 icons as <i class="fa-..."> elements, and this site's icon() helper
 * is an SVG set with different names. Rewriting all 228 was out of scope for a
 * port; if the CDN is unwanted the icons are the thing to convert.
 *
 * The videos and images were re-encoded on the way in — the source ships them
 * at 4K, which was 322MB of case-study footage for one page.
 */

declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/config.php';

$page      = 'services';
$pageTitle = 'AI Development Company in Chennai, Bangalore & India';
$pageDesc  = 'iThrive Software is an AI development company in Chennai, Bangalore, Hyderabad and '
           . 'Coimbatore — custom LLMs, enterprise RAG, autonomous AI agents, computer vision and '
           . 'production AI platforms.';
$ogImage   = 'service-ai-first';

/**
 * The source page's structured data, rewritten onto this site's identity and
 * this URL. The catalogue is what an answer engine reads to know what is on
 * offer, so it keeps all five services the sections actually describe.
 */
$schema = [
    '@type'       => 'Service',
    'name'        => 'AI Development',
    'serviceType' => 'AI Development',
    'description' => $pageDesc,
    'url'         => canonical('services/ai-development-company.php'),
    'provider'    => ['@type' => 'Organization', 'name' => SITE_NAME, 'url' => canonical('')],
    'areaServed'  => [
        ['@type' => 'City',    'name' => 'Chennai'],
        ['@type' => 'City',    'name' => 'Bangalore'],
        ['@type' => 'City',    'name' => 'Hyderabad'],
        ['@type' => 'City',    'name' => 'Coimbatore'],
        ['@type' => 'Country', 'name' => 'India'],
    ],
    'hasOfferCatalog' => [
        '@type' => 'OfferCatalog',
        'name'  => 'AI Development Services',
        'itemListElement' => array_map(
            static fn (string $s): array => [
                '@type' => 'Offer',
                'itemOffered' => ['@type' => 'Service', 'name' => $s],
            ],
            [
                'Custom LLM fine-tuning and RAG pipelines',
                'Autonomous AI agent workflows',
                'Computer vision and OCR intelligence',
                'Multilingual voicebots and chatbots',
                'Enterprise system AI modernisation',
            ]
        ),
    ],
];

/* The page's own stylesheet, its fonts, and the icon set its markup expects. */
$extraHead = <<<HTML
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600;700&family=Space+Grotesk:wght@400;500;600;700;800&family=Outfit:wght@400;500;600;700;800;900&display=swap">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer">
<link rel="stylesheet" href="
HTML;
$extraHead .= e(asset('assets/css/ai-dev.css')) . '">';
/* Corrections to the ported sheet, kept in their own file so ai-dev.css stays
   a regenerable transform of the source. Loaded after it, so these win. */
$extraHead .= '<link rel="stylesheet" href="' . e(asset('assets/css/ai-dev-fixes.css')) . '">';

require dirname(__DIR__) . '/includes/header.php';
?>

<?php /* Everything the ported stylesheet styles lives under this one class. */ ?>
<div class="aidev">

  <?php /* The order is the source page's own, section for section. */ ?>
  <?php foreach ([
      'hero',            // 3D robot, prompt bar and ticker
      'stats-bar',       // trust stats
      'stack-reveal',    // section 3: the five functions, as a sticky deck
      'awards-strip',    // certifications marquee
      'solutions',       // numbered rail 01–09 with the video showcase
      'gateway-facts',   // quick-facts row
      'ecosystem',       // 4-layer architecture stack
      'process',         // 6-step development process
      'technologies',    // technology matrix filter grid
      'industries',      // industries we transform
      'compliance',      // security, ISO 27001, AI governance
      'why-us',          // the advantage, and the Indian AI hubs
      'case-studies',    // featured work and video highlights
      'testimonials',    // client testimonials
      'blog-insights',   // insights, benchmarks and the video strip
      'faq',             // accordion
      'cta-contact',     // closing CTA and the RFP form
      'video-modal',     // the dialog the solutions rail plays into
  ] as $section) {
      component('aidev/' . $section);
  } ?>

</div>

<?php /* The page's behaviour, in the source's own load order: the WebGL engine
         first, then the three scenes that need it, then the carousels, then
         main.js, which wires the counters, filters, accordion and forms.

         `defer` rather than the source's bare tags — these sit inside <main>
         rather than at the end of <body>, and defer is what guarantees they
         still run after the document is parsed, in this order. */ ?>
<?php /* Two of the ported scripts carry asset paths in their own data, written
         relative to a site root this page is not at. They read the real
         directories from here rather than hard-coding /assets/, because
         BASE_URL can be a subdirectory on some installs. Inline, so it is set
         before any deferred script runs. */ ?>
<script>
  document.documentElement.dataset.aidevAssets = <?= json_encode(url('assets/img/aidev/')) ?>;
  document.documentElement.dataset.aidevVideos = <?= json_encode(url('videos/aidev/')) ?>;
</script>

<script defer src="<?= e(asset('assets/vendor/three/three.r128.min.js')) ?>"></script>
<?php foreach ([
    'particle-mesh',
    'neural-core-3d',
    'liquid-glass-carousel',
    'rotunda-carousel',
    'main',
] as $script): ?>
<script defer src="<?= e(asset('assets/js/aidev/' . $script . '.js')) ?>"></script>
<?php endforeach; ?>

<?php /* The hero robot. A module, because it imports the Spline runtime — and
         it replaces the port's own robot-3d.js, which is no longer loaded: that
         one hand-built a lookalike, and the brief was this robot. */ ?>
<script type="module" src="<?= e(asset('assets/js/aidev/spline-robot.js')) ?>"></script>

<?php /* The React island. It carries Framer's Cover Flow Gallery, which section
         four runs — see includes/components/aidev/awards-strip.php. The footer
         loads this bundle only for $bodyClass 'lusion', which this page is not,
         so it asks for it here. Mounts are lazy: the bundle attaches nothing
         until a [data-ok] host is near the viewport. */ ?>
<script type="module" src="<?= e(asset('assets/dist/originkit/originkit.js')) ?>"></script>

<?php
require dirname(__DIR__) . '/includes/footer.php';
