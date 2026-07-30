<?php
declare(strict_types=1);

$page      = 'solutions';
$pageTitle = 'AI Solutions — Ithrive Insights & Ithrive AIChat | Ithrive Software Solutions';
$pageDesc  = 'Two proprietary AI products from Ithrive: Insights turns scattered marketing and operational data into growth decisions; AIChat turns website visitors into customers with real-time intent mapping.';

require __DIR__ . '/includes/header.php';

/** Industry sections are anchored from the Solutions dropdown. */
$industries = [
    [
        'id'    => 'healthcare',
        'icon'  => 'stethoscope',
        'title' => 'Healthcare & Telemedicine',
        'body'  => 'Agentic scheduling, AI clinical scribing, unified EMR, automated billing and video consultation — with the automation line drawn deliberately short of clinical judgment.',
        'proof' => 'lotus-eye-hospital',
    ],
    [
        'id'    => 'mobility',
        'icon'  => 'car',
        'title' => 'On-Demand & Mobility',
        'body'  => 'Real-time dispatch, predictive surge pricing, route optimisation and rider-driver matching that scores the whole fleet rather than picking the nearest pin.',
        'proof' => 'tada-taxi-app',
    ],
    [
        'id'    => 'retail',
        'icon'  => 'cart',
        'title' => 'Retail & E-commerce',
        'body'  => 'Recommendation and fit engines, semantic catalogue search and support deflection — all measured against conversion rate and return rate, not engagement.',
        'proof' => 'cute-crew',
    ],
    [
        'id'    => 'manufacturing',
        'icon'  => 'factory',
        'title' => 'Manufacturing & ERP',
        'body'  => 'Production telemetry, predictive maintenance, HRMS and global shipping logistics consolidated into one platform with a single source of truth.',
        'proof' => 'mehala-carona',
    ],
];

component('page-hero', [
    'art'     => 'insights',
    'eyebrow' => 'Solutions',
    'title'   => 'Products we built, and the industries we built them in.',
    'lead'    => 'Two proprietary AI products available to deploy today, plus the industry patterns we have already solved for someone else — so your build starts further along than zero.',
]);
?>

<section class="section section--flush-top">
  <div class="shell">
    <?php foreach (AI_SOLUTIONS as $i => $sol): ?>
      <div class="split<?= $i % 2 ? ' split--reverse' : '' ?> split--even" style="margin-bottom:74px">
        <div>
          <p class="eyebrow<?= $sol['accent'] === 'purple' ? ' eyebrow--purple' : '' ?>" data-reveal>Proprietary Product</p>
          <h2 class="section-title section-title--left" data-reveal style="--d:1;text-align:left"><?= e($sol['name']) ?></h2>
          <p class="prose" data-reveal style="--d:2;color:var(--text);font-size:1.08rem"><?= e($sol['tagline']) ?></p>
          <p class="prose" data-reveal style="--d:3"><?= e($sol['lead']) ?></p>

          <ul class="tag-row" data-reveal style="--d:4">
            <?php foreach ($sol['stack'] as $tag): ?>
              <li class="tag tag--<?= e($sol['accent']) ?>"><?= e($tag) ?></li>
            <?php endforeach; ?>
          </ul>

          <div style="margin-top:26px" data-reveal>
            <a class="btn btn-primary" href="<?= e(url('solutions/' . $sol['slug'] . '.php')) ?>">
              Explore <?= e($sol['name']) ?><?= icon('arrow') ?>
            </a>
          </div>
        </div>

        <div class="split-visual" data-reveal style="--d:2">
          <div class="grid grid-2" style="gap:14px">
            <?php foreach (array_slice($sol['features'], 0, 4) as $j => $f): ?>
              <article class="card" style="padding:22px 20px">
                <span class="card-icon" style="width:40px;height:40px;margin-bottom:14px"><?= icon($f['icon']) ?></span>
                <h3 class="card-title" style="font-size:.98rem"><?= e($f['title']) ?></h3>
              </article>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<section class="section section--panel">
  <div class="shell">
    <?php component('section-head', [
        'eyebrow' => 'By Industry',
        'title'   => 'Patterns we have already solved',
        'lead'    => 'Each of these is backed by a platform in production, not a capability slide. Follow the proof link to read exactly what was built.',
    ]); ?>

    <div class="grid grid-2">
      <?php foreach ($industries as $i => $ind): ?>
        <?php $proof = case_study($ind['proof']); ?>
        <article class="card" id="<?= e($ind['id']) ?>" data-reveal style="--d:<?= $i ?>">
          <span class="card-icon"><?= icon($ind['icon']) ?></span>
          <h3 class="card-title"><?= e($ind['title']) ?></h3>
          <p class="card-body"><?= e($ind['body']) ?></p>
          <a class="card-link" href="<?= e(url('case-studies/' . $proof['slug'] . '.php')) ?>">
            Proof: <?= e($proof['client']) ?><?= icon('arrow') ?>
          </a>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php
component('cta', ['cta' => [
    'eyebrow'   => 'Start Your Project',
    'title'     => 'Want either product running against your own data?',
    'body'      => 'Both deploy into your environment on your infrastructure. Tell us what you are connecting and we will scope the integration.',
    'primary'   => ['label' => 'Start Your Project', 'href' => 'contact.php'],
    'secondary' => ['label' => 'See all services', 'href' => 'services.php'],
]]);

require __DIR__ . '/includes/footer.php';
