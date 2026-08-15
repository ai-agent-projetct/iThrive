<?php
/**
 * Shared template behind every /solutions/*.php route.
 *
 * @var string $solutionSlug
 */

declare(strict_types=1);

require_once dirname(__DIR__) . '/config.php';

$sol = solution($solutionSlug);

$page      = 'solutions';
// The tagline is a full sentence — keeping it in the title pushed these two
// pages past 125 characters, so it lives in the description instead.
$pageTitle = $sol['name'];
$pageDesc  = $sol['tagline'] . ' ' . $sol['short'];
$ogImage   = 'solution-' . $sol['slug'];

$schema = [
    '@type'          => 'SoftwareApplication',
    'name'           => $sol['name'],
    'applicationCategory' => 'BusinessApplication',
    'operatingSystem'=> 'Web',
    'description'    => $sol['lead'],
    'url'            => canonical('solutions/' . $sol['slug'] . '.php'),
    'featureList'    => array_map(static fn (array $f): string => $f['title'], $sol['features']),
    'offers'         => ['@type' => 'Offer', 'availability' => 'https://schema.org/InStock'],
];

require dirname(__DIR__) . '/header.php';

component('page-hero', [
    'art'     => $sol['slug'] === 'ithrive-aichat' ? 'aichat' : 'insights',
    'crumb'   => ['label' => 'All solutions', 'href' => 'solutions.php'],
    'eyebrow' => 'Proprietary AI Product',
    'title'   => $sol['name'],
    'lead'    => $sol['tagline'],
]);
?>

<section class="section section--flush-top">
  <div class="shell">
    <p class="section-lead" data-reveal style="max-width:74ch;font-size:1.06rem;color:var(--text)">
      <?= e($sol['lead']) ?>
    </p>

    <div style="margin-top:38px">
      <?php component('stats-band', ['stats' => array_map(
          static fn (array $m): array => ['value' => $m['value'], 'label' => $m['label']],
          $sol['metrics']
      )]); ?>
    </div>
  </div>
</section>

<section class="section">
  <div class="shell">
    <?php component('section-head', [
        'eyebrow' => 'Capabilities',
        'title'   => 'What ' . $sol['name'] . ' does',
        'lead'    => 'Deployed into your environment, on your infrastructure, connected to your own data.',
    ]); ?>

    <div class="grid grid-3">
      <?php foreach ($sol['features'] as $i => $feature): ?>
        <?php component('feature-card', ['item' => $feature, 'index' => $i % 3]); ?>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section section--panel">
  <div class="shell split">
    <div>
      <p class="eyebrow<?= $sol['accent'] === 'purple' ? ' eyebrow--purple' : '' ?>" data-reveal>Under The Hood</p>
      <h2 class="section-title section-title--left" data-reveal style="--d:1">Built on the same stack we hand to clients</h2>
      <p class="prose" data-reveal style="--d:2">
        There is no separate "product codebase" running on secret infrastructure. <?= e($sol['name']) ?> is Python,
        deployed with the same CI/CD and observability we set up on every engagement — which is why we can put it into
        your environment rather than asking you to send data to ours.
      </p>

      <ul class="tag-row" data-reveal style="--d:3">
        <?php foreach ($sol['stack'] as $tag): ?>
          <li class="tag tag--<?= e($sol['accent']) ?>"><?= e($tag) ?></li>
        <?php endforeach; ?>
      </ul>

      <div data-reveal style="--d:4;margin-top:28px">
        <button class="btn btn-primary" type="button" data-modal-open data-modal-service="Not sure yet — help me scope it">
          Deploy <?= e($sol['name']) ?><?= icon('arrow') ?>
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
        'eyebrow' => 'The Other Product',
        'title'   => 'Both, if the problem needs both',
        'lead'    => 'Insights tells you what to change; AIChat is often where the change gets made. They share an identity layer and read the same customer records.',
    ]); ?>

    <div class="grid grid-2">
      <?php foreach (AI_SOLUTIONS as $i => $other): ?>
        <a class="card" href="<?= e(url('solutions/' . $other['slug'] . '.php')) ?>" data-reveal style="--d:<?= $i ?>">
          <span class="card-icon"><?= icon($other['icon']) ?></span>
          <h3 class="card-title"><?= e($other['name']) ?><?= $other['slug'] === $sol['slug'] ? ' — you are here' : '' ?></h3>
          <p class="card-body"><?= e($other['tagline']) ?></p>
          <span class="card-link"><?= $other['slug'] === $sol['slug'] ? 'Back to top' : 'Explore ' . e($other['name']) ?><?= icon('arrow') ?></span>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php
component('cta', ['cta' => [
    'eyebrow'   => 'Start Your Project',
    'title'     => 'Want ' . $sol['name'] . ' running against your own data?',
    'body'      => 'Tell us what you would connect it to. We will scope the integration and tell you honestly whether it earns its keep at your volume.',
    'primary'   => ['label' => 'Start Your Project', 'href' => 'contact.php'],
    'secondary' => ['label' => 'All solutions', 'href' => 'solutions.php'],
]]);

require dirname(__DIR__) . '/footer.php';
