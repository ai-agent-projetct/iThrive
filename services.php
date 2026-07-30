<?php
declare(strict_types=1);

$page      = 'services';
$pageTitle = 'Services — AI, Product Engineering & Cloud | Ithrive Software Solutions';
$pageDesc  = 'AI-native product development, AI enablement, micro SaaS, product modernization, cloud and DevOps, dedicated engineering teams, mobile, web and e-commerce development in Python.';

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
