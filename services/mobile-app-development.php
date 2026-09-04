<?php
/**
 * Mobile App Development — the one page that is not the shared service layout.
 *
 * The page itself is the React build from ai-agent-projetct/mobile-app-page,
 * mounted into this template so it renders exactly as designed, while the
 * site's real header, navigation, footer, chat widget and schema stay in place
 * around it. Source and build config live in app/mobile; see its README.
 *
 * Rebuild after changing anything under app/mobile/src:
 *     cd app/mobile && npm install && npm run build
 */

declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/config.php';

$svc = service('mobile-app-development');

$page      = 'services';
$pageTitle = 'Mobile App Development in Chennai';
$pageDesc  = 'iThrive Software engineers iOS, Android, Flutter and AI mobile apps for '
           . 'enterprises and startups, from studios in Chennai and Coimbatore.';
$ogImage   = 'service-' . $svc['group_slug'];

$schema = [
    '@type'       => 'Service',
    'name'        => $svc['title'],
    'serviceType' => $svc['group'],
    'description' => $svc['lead'],
    'url'         => canonical('services/mobile-app-development.php'),
    'areaServed'  => [
        ['@type' => 'City', 'name' => 'Chennai'],
        ['@type' => 'City', 'name' => 'Coimbatore'],
    ],
    // The other service pages carry this through the shared template; this page
    // builds its own schema, so it was the only one missing a catalogue.
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
 * The eleven answers, as schema.
 *
 * The Flutter page has published its ten this way since it launched. This page
 * — the larger of the two, and the one the FAQ was actually written for — had
 * neither the schema nor a server-rendered copy, because its answers live
 * inside the React bundle and nothing reads them until the bundle executes.
 */
$schemaExtra = [
    [
        '@type'      => 'FAQPage',
        'name'       => 'Mobile app development — frequently asked questions',
        'speakable'  => [
            '@type'       => 'SpeakableSpecification',
            'cssSelector' => ['.mobile-faq dt', '.mobile-faq dd'],
        ],
        'mainEntity' => array_map(static fn (array $f): array => [
            '@type'          => 'Question',
            'name'           => $f['q'],
            'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f['a']],
        ], MOBILE_FAQ),
    ],
];

// The page ships its own type ramp; these are the families the design was
// drawn in and are not in the site's global stylesheet.
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
      <?php /* A real H1, not the shared section-head (which emits an H2). The
               page body is client-rendered, so without this a crawler that does
               not execute JavaScript sees no heading at all. */ ?>
      <p class="eyebrow"><?= e($svc['group']) ?></p>
      <h1 class="section-title">Mobile App Development Company in Chennai &amp; Coimbatore</h1>
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
        <a class="btn btn-primary" href="<?= e(url('contact.php')) ?>">Start your project<?= icon('arrow') ?></a>
      </div>
    </div>
  </section>
</noscript>

<?php /* The FAQ again, in the server response.
         The React section renders these same eleven questions, but only after
         its JavaScript runs. An answer engine reading the raw HTML would
         otherwise find nothing, which would waste the one part of this page
         written specifically to be quoted. Visually hidden, not display:none —
         hidden text is still indexed, and this is the same content the page
         renders. Matches what the Flutter page has always done. */ ?>
<dl class="mobile-faq sr-only">
  <?php foreach (MOBILE_FAQ as $f): ?>
    <dt><?= e($f['q']) ?></dt>
    <dd><?= e($f['a']) ?></dd>
  <?php endforeach; ?>
</dl>

<?php /* The hero's 3D scene loads its Three.js scripts at runtime, so it needs to
         know where the site root is — BASE_URL is empty at the domain root and
         a path when the site lives in a subdirectory. */ ?>
<?php /* Root-absolute, always. A bare relative path would resolve against
         /services/ and 404 — this page is one directory deep. */ ?>
<script>window.__ithriveBase = <?= json_encode(BASE_URL . '/') ?>;</script>
<script type="module" src="<?= e(asset('assets/dist/mobile/mobile-app.js')) ?>"></script>

<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
