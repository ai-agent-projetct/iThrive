<?php
/**
 * Flutter App Development.
 *
 * Same page as Mobile App Development, and deliberately so: the client asked
 * for every feature of that page with Flutter keywords. It mounts the same
 * React build — the same 3D app universe, simulator, builder, tech magnet,
 * roadmap, estimator and contact flow — and selects the Flutter variant, which
 * swaps the headline, the lead, the highlight cards, the section titles, the
 * studio block and the whole FAQ.
 *
 * The variant is chosen before the module loads, from app/mobile/src/variant.js.
 * Forking the components instead would have guaranteed the two pages drift the
 * first time either was edited.
 *
 * Rebuild after changing anything under app/mobile/src:
 *     cd app/mobile && npm install && npm run build
 */

declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/config.php';

$svc = service('flutter-app-development');

$page      = 'services';
$pageTitle = 'Flutter App Development Company in Chennai, Bangalore & Coimbatore';
$pageDesc  = 'iThrive Software builds production Flutter apps in Dart for iOS, Android, web and '
           . 'desktop from one codebase — for businesses in Chennai, Bangalore, Coimbatore and across India.';
$ogImage   = 'service-' . $svc['group_slug'];

/**
 * Service, with the capability catalogue and the five city terms this page is
 * written to answer. The cities are declared as areaServed rather than repeated
 * through the copy, which is what stops the page reading as five near-duplicate
 * paragraphs with the noun swapped.
 */
$schema = [
    '@type'       => 'Service',
    'name'        => 'Flutter App Development',
    'serviceType' => 'Flutter App Development',
    'description' => $svc['lead'],
    'url'         => canonical('services/flutter-app-development.php'),
    'provider'    => ['@type' => 'Organization', 'name' => SITE_NAME, 'url' => canonical('')],
    'areaServed'  => [
        ['@type' => 'City',    'name' => 'Chennai'],
        ['@type' => 'City',    'name' => 'Bangalore'],
        ['@type' => 'City',    'name' => 'Coimbatore'],
        ['@type' => 'State',   'name' => 'Tamil Nadu'],
        ['@type' => 'Country', 'name' => 'India'],
    ],
    'hasOfferCatalog' => [
        '@type'           => 'OfferCatalog',
        'name'            => $svc['title'] . ' capabilities',
        'itemListElement' => array_map(static fn (array $c): array => [
            '@type'       => 'Offer',
            'itemOffered' => ['@type' => 'Service', 'name' => $c['title'], 'description' => $c['body']],
        ], $svc['capabilities']),
    ],
];

/**
 * The answers, mirroring the ten the React FAQ renders.
 *
 * They are duplicated here rather than shared because the page body is
 * client-rendered: without this, the answer set exists only after JavaScript
 * runs, and the surface it is written for — an assistant quoting a page it
 * never executed — would never see a word of it.
 */
$schemaExtra = [
    [
        '@type'      => 'FAQPage',
        'name'       => 'Flutter app development — frequently asked questions',
        'speakable'  => [
            '@type'       => 'SpeakableSpecification',
            'cssSelector' => ['.flutter-faq dt', '.flutter-faq dd'],
        ],
        'mainEntity' => array_map(static fn (array $f): array => [
            '@type'          => 'Question',
            'name'           => $f['q'],
            'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f['a']],
        ], FLUTTER_FAQ),
    ],
];

foreach ([['Chennai', 'Tamil Nadu'], ['Bangalore', 'Karnataka'], ['Coimbatore', 'Tamil Nadu']] as [$city, $region]) {
    $schemaExtra[] = [
        '@type'       => 'LocalBusiness',
        'name'        => SITE_NAME . ' — Flutter App Development, ' . $city,
        'description' => 'Flutter App Development Company in ' . $city
                       . ' — iOS, Android, web and desktop apps from one Dart codebase.',
        'url'         => canonical('services/flutter-app-development.php') . '#' . strtolower($city),
        'email'       => SITE_EMAIL,
        'address'     => [
            '@type'           => 'PostalAddress',
            'addressLocality' => $city,
            'addressRegion'   => $region,
            'addressCountry'  => 'IN',
        ],
        'areaServed'  => ['@type' => 'City', 'name' => $city],
    ];
}

// The page ships its own type ramp; these are the families the design was drawn
// in and are not in the site's global stylesheet.
$extraHead = '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>'
    . '<link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;600'
    . '&family=Outfit:wght@400;500;600;700;800;900'
    . '&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">'
    . '<link rel="stylesheet" href="' . e(asset('assets/dist/mobile/mobile-app.css')) . '">';

require dirname(__DIR__) . '/includes/header.php';
?>

<?php /* React mounts here. Without JavaScript the fallback below is what a
         visitor — or a crawler that does not execute scripts — gets, so the
         page is never an empty div. */ ?>
<div id="ithrive-mobile-root"></div>

<noscript>
  <section class="section">
    <div class="shell">
      <p class="eyebrow">Flutter App Development Company in Chennai</p>
      <h1 class="section-title">Flutter App Development Company in Chennai, Bangalore &amp; Coimbatore</h1>
      <p class="section-lead"><?= e($svc['lead']) ?></p>

      <div class="grid grid-3">
        <?php foreach ($svc['capabilities'] as $i => $cap): ?>
          <article class="card card--numbered">
            <span class="card-num"><?= str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT) ?></span>
            <h3 class="card-title"><?= e($cap['title']) ?></h3>
            <p class="card-body"><?= e($cap['body']) ?></p>
          </article>
        <?php endforeach; ?>
      </div>

      <div class="section-foot">
        <a class="btn btn-primary" href="<?= e(url('contact.php')) ?>">Start your Flutter project<?= icon('arrow') ?></a>
      </div>
    </div>
  </section>
</noscript>

<?php /* The FAQ again, in the server response.
         The React section renders the same ten questions, but only after its
         JavaScript runs. An answer engine reading the raw HTML would otherwise
         find nothing, which would waste the one part of this page written
         specifically to be quoted. Visually hidden, not display:none — hidden
         text is still indexed, and this is the same content the page renders. */ ?>
<dl class="flutter-faq sr-only">
  <?php foreach (FLUTTER_FAQ as $f): ?>
    <dt><?= e($f['q']) ?></dt>
    <dd><?= e($f['a']) ?></dd>
  <?php endforeach; ?>
</dl>

<?php /* The hero's 3D scene loads its scripts at runtime, so it needs to know
         where the site root is. Root-absolute, always — a bare relative path
         would resolve against /services/ and 404. */ ?>
<script>
  window.__ithriveBase = <?= json_encode(BASE_URL . '/') ?>;
  window.__ithriveVariant = 'flutter';
</script>
<script type="module" src="<?= e(asset('assets/dist/mobile/mobile-app.js')) ?>"></script>

<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
