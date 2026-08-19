<?php
declare(strict_types=1);

$page      = 'services';
$pageTitle = 'Services — AI, Product Engineering, Cloud';
$pageDesc  = 'AI-native product development, AI enablement, micro SaaS, modernization, cloud and DevOps, dedicated teams, mobile, web and e-commerce — all built in Python.';

// The schema below reads content constants and canonical(), which live in
// config.php — header.php loads it, but not until after this block runs.
require_once __DIR__ . '/includes/config.php';

$schema = [
    '@type'           => 'ItemList',
    'name'            => 'Services offered by iThrive Software',
    'itemListOrder'   => 'https://schema.org/ItemListUnordered',
    'numberOfItems'   => count(all_services()),
    'itemListElement' => array_map(static fn (array $svc, int $i): array => [
        '@type'    => 'ListItem',
        'position' => $i + 1,
        'name'     => $svc['title'],
        'url'      => canonical('services/' . $svc['slug'] . '.php'),
    ], all_services(), array_keys(all_services())),
];

require __DIR__ . '/includes/header.php';

component('page-hero', [
    'art'     => 'core',
    'eyebrow' => 'Services',
    'title'   => 'Engineering practices, not a menu of deliverables.',
    'lead'    => 'Fifteen services across four groups. Every one of them is delivered by senior engineers who were in your discovery workshop, and every one ends with something running in production that you own.',
    'actions' => [
        ['label' => 'Talk to an engineer', 'href' => 'contact.php'],
        ['label' => 'See the work',        'href' => 'case-studies.php'],
    ],
]);
?>

<section class="section section--flush-top">
  <div class="shell">
    <?php component('services-matrix'); ?>
  </div>
</section>

<section class="section section--panel">
  <div class="shell">
    <?php component('section-head', [
        'eyebrow' => PROCESS['eyebrow'],
        'title'   => 'How an engagement actually runs',
        'lead'    => PROCESS['lead'],
        'art'     => 'sec-engagement',
    ]); ?>
    <?php component('process-pipeline'); ?>
  </div>
</section>

<section class="section">
  <div class="shell">
    <?php component('section-head', [
        'eyebrow' => 'Every Service',
        'title'   => 'The full catalogue',
        'lead'    => 'Each service has its own page covering capabilities, typical outcomes and the stack we deliver it on.',
        'art'     => 'sec-catalogue',
    ]); ?>

    <div class="grid grid-3">
      <?php foreach (all_services() as $i => $item): ?>
        <?php component('service-card', ['item' => $item, 'index' => $i % 3]); ?>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php
component('cta', ['cta' => [
    'eyebrow'   => 'Start Your Project',
    'title'     => 'Not sure which of these you need?',
    'body'      => 'Most engagements start as one thing and turn out to be another. Describe the problem rather than the solution and we will tell you which service actually fits.',
    'primary'   => ['label' => 'Start Your Project', 'href' => 'contact.php'],
    'secondary' => ['label' => 'Read the case studies', 'href' => 'case-studies.php'],
]]);

require __DIR__ . '/includes/footer.php';
