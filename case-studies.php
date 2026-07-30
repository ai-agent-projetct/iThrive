<?php
declare(strict_types=1);

$page      = 'case-studies';
$pageTitle = 'Case Studies — AI Platforms, Web, Mobile & ERP | Ithrive Software Solutions';
$pageDesc  = 'Ten platforms in production across healthcare, mobility, civic tech, manufacturing, tourism, hospitality and retail — built by Ithrive Software Solutions in Python.';

require __DIR__ . '/includes/header.php';

component('page-hero', [
    'art'     => 'proof',
    'eyebrow' => 'Case Studies',
    'title'   => 'Ten platforms, each closing a gap someone was living with.',
    'lead'    => 'Filter by what you are building. Every study covers the actual challenge, what we engineered, and the value the client measured afterwards.',
]);
?>

<section class="section section--flush-top">
  <div class="shell">
    <div class="filter-tabs" data-filters role="group" aria-label="Filter case studies">
      <button class="filter-tab is-active" type="button" data-filter="all" aria-pressed="true">All work</button>
      <?php foreach (CASE_FILTERS as $key => $label): ?>
        <button class="filter-tab" type="button" data-filter="<?= e($key) ?>" aria-pressed="false"><?= e($label) ?></button>
      <?php endforeach; ?>
    </div>

    <div class="case-grid">
      <?php foreach (CASE_STUDIES as $i => $study): ?>
        <?php component('case-study-card', ['study' => $study, 'index' => $i % 2]); ?>
      <?php endforeach; ?>
    </div>

    <p class="section-lead" data-filter-empty hidden style="text-align:center;margin-top:30px">
      Nothing in that category yet — try another filter.
    </p>
  </div>
</section>

<section class="section section--panel">
  <div class="shell">
    <?php component('section-head', [
        'eyebrow' => 'By The Numbers',
        'title'   => 'What ten builds add up to',
    ]); ?>
    <?php component('stats-band'); ?>
  </div>
</section>

<?php
component('cta', ['cta' => [
    'eyebrow'   => 'Start Your Project',
    'title'     => 'Your problem probably rhymes with one of these.',
    'body'      => 'Send us the workflow that is costing you time. We will tell you which of these builds it most resembles and what it would take.',
    'primary'   => ['label' => 'Start Your Project', 'href' => 'contact.php'],
    'secondary' => ['label' => 'How we work', 'href' => 'company/process.php'],
]]);

require __DIR__ . '/includes/footer.php';
