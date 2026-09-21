<?php
/**
 * Shared template behind every /locations/*.php route.
 *
 * One page per studio we actually work from. The page answers the query it is
 * named for — "AI development company in Chennai" and its siblings — with what
 * that studio does, which services come out of it, and how working with it
 * goes. Cities we only sell into are covered by areas_served() and the global
 * delivery page; there is deliberately no page here for a place with no team.
 *
 * @var string $locationSlug
 */

declare(strict_types=1);

require_once dirname(__DIR__) . '/config.php';

$loc = location($locationSlug);

if ($loc === null) {
    http_response_code(404);
    require dirname(__DIR__, 2) . '/404.php';
    return;
}

$page      = 'company';
$pageTitle = $loc['keyword'];
$pageDesc  = seo_description($loc['lead'] . ' Studios in ' . SITE_HQ . '.', 155);
$ogImage   = 'default';

$locUrl = canonical('locations/' . $loc['slug'] . '.php');

/*
 * ProfessionalService rather than LocalBusiness: we publish the city and the
 * region, not a street address, and a LocalBusiness node without one is a
 * rich-result claim we cannot back. Fill in a street address here the day a
 * studio has a verified Business Profile and this becomes the stronger node.
 */
$schema = [
    '@type'       => 'ProfessionalService',
    'name'        => SITE_NAME . ' — ' . $loc['city'],
    'description' => $loc['lead'],
    'url'         => $locUrl,
    'address'     => [
        '@type'           => 'PostalAddress',
        'addressLocality' => $loc['city'],
        'addressRegion'   => $loc['region'],
        'addressCountry'  => 'IN',
    ],
    'areaServed'  => [
        ['@type' => 'City',  'name' => $loc['city']],
        ['@type' => 'State', 'name' => $loc['region']],
    ],
    'email'       => SITE_EMAIL,
    ...(site_phone() !== null ? ['telephone' => site_phone()] : []),
];

$schemaExtra = [[
    '@type'      => 'FAQPage',
    'name'       => $loc['keyword'] . ' — frequently asked questions',
    'mainEntity' => array_map(static fn (array $faq): array => [
        '@type'          => 'Question',
        'name'           => $faq[0],
        'acceptedAnswer' => ['@type' => 'Answer', 'text' => $faq[1]],
    ], $loc['faqs']),
]];

require dirname(__DIR__) . '/header.php';

component('page-hero', [
    'crumb'   => ['label' => 'About iThrive', 'href' => 'company/about.php'],
    'eyebrow' => $loc['city'] . ' · ' . $loc['region'],
    'title'   => $loc['keyword'],
    'lead'    => $loc['lead'],
    'actions' => [
        ['label' => 'Talk to the ' . $loc['city'] . ' team', 'href' => 'contact.php'],
        ['label' => 'See all services', 'href' => 'services.php'],
    ],
]);
?>

<section class="section section--flush-top">
  <div class="shell split">
    <div>
      <p class="eyebrow" data-reveal><?= e($loc['role']) ?></p>
      <h2 class="section-title section-title--left" data-reveal style="--d:1">
        What we build in <?= e($loc['city']) ?>
      </h2>
      <p class="prose" data-reveal style="--d:2"><?= e($loc['body']) ?></p>
    </div>

    <?php /* The hub picture from the about page, which is the one photograph
             that exists for each studio. */ ?>
    <?php component('page-figure', [
        'src'   => 'about-3d/' . basename($loc['image'], '.jpg'),
        'ratio' => '3 / 2',
        'alt'   => $loc['city'] . ' studio — ' . strtolower($loc['role']),
    ]); ?>
  </div>
</section>

<section class="section section--panel">
  <div class="shell">
    <?php component('section-head', [
        'eyebrow' => 'Focus',
        'title'   => 'Three things this studio owns',
        'lead'    => 'Every project draws on all five studios; these are the parts that are led from ' . $loc['city'] . '.',
    ]); ?>

    <div class="grid grid-3">
      <?php foreach ($loc['focus'] as $i => $item): ?>
        <?php component('feature-card', ['item' => $item, 'index' => $i % 3]); ?>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section">
  <div class="shell">
    <?php component('section-head', [
        'eyebrow' => 'Services',
        'title'   => 'Delivered from ' . $loc['city'],
        'lead'    => 'The full catalogue is available to every client wherever they are — these are the ones this studio leads.',
    ]); ?>

    <div class="grid grid-2">
      <?php foreach ($loc['services'] as $slug): ?>
        <?php $svc = location_service($slug); ?>
        <a class="card" href="<?= e(url('services/' . $slug . '.php')) ?>" data-reveal>
          <h3 class="card-title"><?= e($svc['title']) ?></h3>
          <p class="card-body"><?= e($svc['short']) ?></p>
          <span class="card-link">Read more<?= icon('arrow') ?></span>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section section--panel">
  <div class="shell">
    <?php component('section-head', [
        'eyebrow' => 'Questions',
        'title'   => 'Working with the ' . $loc['city'] . ' studio',
    ]); ?>

    <div class="faq-list">
      <?php foreach ($loc['faqs'] as $i => [$q, $a]): ?>
        <details class="faq-item"<?= $i === 0 ? ' open' : '' ?>>
          <summary>
            <span><?= e($q) ?></span>
            <?= icon('chevron', 'icon faq-caret') ?>
          </summary>
          <p><?= e($a) ?></p>
        </details>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section">
  <div class="shell">
    <?php component('section-head', [
        'eyebrow' => 'The other studios',
        'title'   => 'Four more places this work comes from',
        'lead'    => 'One company, five studios. A project is staffed from whichever of them the work belongs in.',
    ]); ?>

    <div class="grid grid-4">
      <?php foreach (LOCATIONS as $i => $other): ?>
        <?php if ($other['slug'] === $loc['slug']) { continue; } ?>
        <a class="card" href="<?= e(url('locations/' . $other['slug'] . '.php')) ?>" data-reveal style="--d:<?= $i ?>">
          <h3 class="card-title"><?= e($other['city']) ?></h3>
          <p class="card-body"><?= e($other['role']) ?></p>
        </a>
      <?php endforeach; ?>
    </div>

    <div class="section-foot" data-reveal>
      <a class="btn btn-ghost" href="<?= e(url('locations/global-delivery.php')) ?>">
        Working with us from outside India<?= icon('arrow') ?>
      </a>
    </div>
  </div>
</section>

<?php component('cta', ['cta' => [
    'eyebrow'   => $loc['city'],
    'title'     => 'Start a project with the ' . $loc['city'] . ' studio',
    'body'      => 'Tell us what you are trying to build. You will get an engineer on the call, not an account manager.',
    'primary'   => ['label' => 'Start your project', 'href' => 'contact.php'],
    'secondary' => ['label' => 'See our work', 'href' => 'case-studies.php'],
]]); ?>

<?php require dirname(__DIR__) . '/footer.php'; ?>
