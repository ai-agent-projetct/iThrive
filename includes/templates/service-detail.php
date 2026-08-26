<?php
/**
 * Shared template behind every /services/*.php route.
 *
 * Route files set $serviceSlug and include this — so each service keeps a real
 * URL of its own while the layout lives in one place.
 *
 * @var string $serviceSlug
 */

declare(strict_types=1);

require_once dirname(__DIR__) . '/config.php';

$svc = service($serviceSlug);

$page      = 'services';
$pageTitle = $svc['title'];
$pageDesc  = $svc['short'];
$ogImage   = 'service-' . $svc['group_slug'];

$schema = [
    '@type'       => 'Service',
    'name'        => $svc['title'],
    'serviceType' => $svc['group'],
    'description' => $svc['lead'],
    'areaServed'  => 'Worldwide',
    'url'         => canonical('services/' . $svc['slug'] . '.php'),
    'hasOfferCatalog' => [
        '@type'           => 'OfferCatalog',
        'name'            => $svc['title'] . ' capabilities',
        'itemListElement' => array_map(static fn (array $c): array => [
            '@type' => 'Offer',
            'itemOffered' => ['@type' => 'Service', 'name' => $c['title'], 'description' => $c['body']],
        ], $svc['capabilities']),
    ],
];

require dirname(__DIR__) . '/header.php';

/* A route can hand this template its own hero — ai-native-product-development
   does. Everything below the hero is the same for every service. */
if (!empty($heroComponent)) {
    component($heroComponent, ['svc' => $svc]);
} else {
    component('page-hero', [
        // Each service group has its own artwork, so the fifteen detail pages stay
        // visually distinct from one another without fifteen bespoke drawings.
        'art'     => $svc['group_slug'],
        'crumb'   => ['label' => 'All services', 'href' => 'services.php'],
        'eyebrow' => $svc['group'],
        'title'   => $svc['title'],
        'lead'    => $svc['lead'],
    ]);
}
?>

<section class="section section--flush-top">
  <div class="shell">
    <?php component('stats-band', ['stats' => array_map(
        static fn (array $o): array => ['value' => $o['value'], 'label' => $o['label']],
        $svc['outcomes']
    )]); ?>
  </div>
</section>

<?php /* The capabilities grid, on every service page but the one that opts
         into the staged treatment — that page replaces this whole section with
         Origin Kit's Stacked Carousel, in its extras file. */ ?>
<?php if (($bodyClass ?? '') !== 'lusion'): ?>
<section class="section">
  <div class="shell">
    <?php component('section-head', [
        'eyebrow' => 'What This Includes',
        'title'   => 'Capabilities you get, spelled out',
        'lead'    => 'No line item here is aspirational — each one is something we have shipped on a platform that is live today.',
        'art'     => 'sec-capabilities',
    ]); ?>

    <div class="grid grid-3">
      <?php foreach ($svc['capabilities'] as $i => $cap): ?>
        <article class="card card--numbered" data-reveal style="--d:<?= $i % 3 ?>">
          <span class="card-num"><?= str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT) ?></span>
          <h3 class="card-title"><?= e($cap['title']) ?></h3>
          <p class="card-body"><?= e($cap['body']) ?></p>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php
/**
 * Per-service extras.
 *
 * A service with more to say than the shared layout allows drops a
 * `service-extras-{slug}` component in and it appears here. Nothing to register,
 * and the other fourteen pages are untouched.
 */
if (is_file(__DIR__ . '/../components/service-extras-' . $svc['slug'] . '.php')) {
    // Passed explicitly: component() scopes its own variables, so an extras
    // file that reads $svc has to be handed it.
    component('service-extras-' . $svc['slug'], ['svc' => $svc]);
}
?>

<section class="section section--panel">
  <div class="shell split">
    <div>
      <p class="eyebrow" data-reveal>The Stack</p>
      <h2 class="section-title section-title--left" data-reveal style="--d:1">What we deliver it on</h2>
      <p class="prose" data-reveal style="--d:2">
        Python end to end wherever it earns its place — one language across API, data pipeline and model layer keeps the
        team small and the feedback loop short. Everything here is a deliberate choice we can defend, not a default.
      </p>

      <ul class="tag-row" data-reveal style="--d:3">
        <?php foreach ($svc['stack'] as $tag): ?><li class="tag tag--cyan"><?= e($tag) ?></li><?php endforeach; ?>
      </ul>

      <div data-reveal style="--d:4;margin-top:28px">
        <button class="btn btn-primary" type="button" data-modal-open data-modal-service="<?= e($svc['title']) ?>">
          Scope this service<?= icon('arrow') ?>
        </button>
      </div>
    </div>

    <div class="split-visual" data-reveal style="--d:2">
      <?php component('process-pipeline-compact'); ?>
    </div>
  </div>
</section>

<section class="section">
  <div class="shell">
    <?php component('section-head', [
        'eyebrow' => 'Proof',
        'title'   => 'Where we have done this before',
        'lead'    => 'The closest matches in our portfolio by stack and problem shape.',
    ]); ?>

    <div class="case-grid">
      <?php foreach (related_case_studies($svc['stack'], 2) as $i => $study): ?>
        <?php component('case-study-card', ['study' => $study, 'index' => $i]); ?>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section section--panel section--tight">
  <div class="shell">
    <?php component('section-head', [
        'eyebrow' => $svc['group'],
        'title'   => 'Other services in this group',
    ]); ?>

    <div class="grid grid-3">
      <?php
      $siblings = array_values(array_filter(
          all_services(),
          static fn (array $s): bool => $s['group_slug'] === $svc['group_slug'] && $s['slug'] !== $svc['slug']
      ));
      foreach ($siblings as $i => $sibling) {
          component('service-card', ['item' => $sibling, 'index' => $i % 3]);
      }
      ?>
    </div>
  </div>
</section>

<?php
component('cta', ['cta' => [
    'eyebrow'   => 'Start Your Project',
    'title'     => 'Tell us what you need built.',
    'body'      => 'Describe the workflow and we will come back with scope, stack and a realistic timeline in writing — within two working days.',
    'primary'   => ['label' => 'Start Your Project', 'href' => 'contact.php'],
    'secondary' => ['label' => 'All services', 'href' => 'services.php'],
]]);

require dirname(__DIR__) . '/footer.php';
