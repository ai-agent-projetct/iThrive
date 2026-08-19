<?php
declare(strict_types=1);

$page      = 'company';
$pageTitle = 'How We Work — Discovery to Execution';
$pageDesc  = 'iThrive Software runs every engagement through three gates: Discovery, Clarity and Execution. Each one ends in something you can hold, not a status call.';

// The schema below reads content constants and canonical(), which live in
// config.php — header.php loads it, but not until after this block runs.
require_once dirname(__DIR__) . '/includes/config.php';

/**
 * HowTo, because "how does an engagement work" is a question an answer engine
 * gets asked verbatim and this page is the answer to it.
 */
$schema = [
    '@type'       => 'HowTo',
    'name'        => 'How an engagement runs at iThrive Software',
    'description' => PROCESS['lead'],
    'totalTime'   => 'P8W',
    'step'        => array_map(static fn (array $s, int $i): array => [
        '@type'    => 'HowToStep',
        'position' => $i + 1,
        'name'     => $s['title'],
        'text'     => $s['body'],
        'url'      => canonical('company/process.php') . '#step-' . ($i + 1),
    ], PROCESS['steps'], array_keys(PROCESS['steps'])),
];

require dirname(__DIR__) . '/includes/header.php';

component('page-hero', [
    'art'     => 'process',
    'eyebrow' => PROCESS['eyebrow'],
    'title'   => 'Three gates. Each one ends in something you can hold.',
    'lead'    => PROCESS['lead'],
]);
?>

<section class="section section--flush-top">
  <div class="shell">
    <?php component('process-pipeline'); ?>
  </div>
</section>

<section class="section section--panel">
  <div class="shell">
    <?php component('section-head', [
        'eyebrow' => 'Ground Rules',
        'title'   => 'The parts of delivery we do not negotiate',
        'lead'    => 'These exist because we have watched each one go wrong on somebody else\'s project.',
        'art'     => 'sec-commitments',
    ]); ?>

    <div class="grid grid-3">
      <?php
      $rules = [
          ['icon' => 'target',   'title' => 'One success metric, agreed in writing', 'body' => 'Before the build starts we write down the number that decides whether this worked, and we report against it even when the reading is unflattering.'],
          ['icon' => 'calendar', 'title' => 'Fortnightly demos on real data',        'body' => 'Every second week you see the actual system running, not a deck about it. Slippage surfaces at week two rather than month four.'],
          ['icon' => 'shield',   'title' => 'Production hygiene from release one',   'body' => 'Auth, backups, error tracking, CI/CD and rollback ship with the first deploy. These are cheap now and ruinous to retrofit.'],
          ['icon' => 'search',   'title' => 'We argue in discovery, not in invoicing','body' => 'If a requested feature is wrong, you hear it before it is built. Building something we know is a mistake and charging for it is not a service.'],
          ['icon' => 'layers',   'title' => 'Everything is documented to hand over',  'body' => 'Architecture notes, runbooks and a working local environment. Another team should be able to pick this up without calling us.'],
          ['icon' => 'lock',     'title' => 'You own the source, always',             'body' => 'Repositories, infrastructure and accounts are in your name from day one. There is no version of this where we hold your product hostage.'],
      ];
      foreach ($rules as $i => $rule) {
          component('feature-card', ['item' => $rule, 'index' => $i % 3]);
      }
      ?>
    </div>
  </div>
</section>

<section class="section">
  <div class="shell split">
    <div>
      <p class="eyebrow" data-reveal>Engagement Models</p>
      <h2 class="section-title section-title--left" data-reveal style="--d:1">Pick the shape that fits where you are</h2>
      <p class="prose" data-reveal style="--d:2">
        A fixed-scope project suits a defined outcome with a deadline. A dedicated squad suits a roadmap that will keep
        moving. On-demand specialists suit a gap that is one person wide. We will tell you which one you actually need,
        including when that answer is the cheapest of the three.
      </p>

      <ul class="check-list" data-reveal style="--d:3">
        <li><span class="check-dot"><?= icon('check') ?></span>Fixed-scope project — agreed deliverable, agreed price</li>
        <li><span class="check-dot"><?= icon('check') ?></span>Dedicated engineering team — ring-fenced squad, your rituals</li>
        <li><span class="check-dot"><?= icon('check') ?></span>On-demand specialists — monthly rolling, thirty days notice</li>
      </ul>

      <div style="margin-top:28px" data-reveal>
        <a class="btn btn-primary" href="<?= e(url('services.php')) ?>">Compare engagement models<?= icon('arrow') ?></a>
      </div>
    </div>

    <div class="split-visual" data-reveal style="--d:2">
      <?php component('stats-band', ['stats' => [
          ['value' => '2 wks',  'label' => 'To a productive squad'],
          ['value' => '<10min', 'label' => 'Commit to production'],
          ['value' => '99.9%',  'label' => 'Uptime we run at'],
          ['value' => '30 days','label' => 'Notice to resize or exit'],
      ]]); ?>
    </div>
  </div>
</section>

<?php
component('cta', ['cta' => [
    'eyebrow'   => 'Start Your Project',
    'title'     => 'Discovery starts with one honest paragraph.',
    'body'      => 'Describe the workflow, not the solution. We will come back with what we would build and what it would take.',
    'primary'   => ['label' => 'Start Your Project', 'href' => 'contact.php'],
    'secondary' => ['label' => 'See the work', 'href' => 'case-studies.php'],
]]);

require dirname(__DIR__) . '/includes/footer.php';
