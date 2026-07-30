<?php
/**
 * Shared template behind every /case-studies/*.php route.
 *
 * @var string $studySlug
 */

declare(strict_types=1);

require_once dirname(__DIR__) . '/config.php';

$study = case_study($studySlug);

$page      = 'case-studies';
$pageTitle = $study['client'] . ': ' . $study['headline'];
$pageDesc  = $study['summary'];
$ogType    = 'article';
$ogImage   = 'case-' . $study['slug'];

$schema = [
    '@type'         => 'Article',
    'headline'      => $study['client'] . ': ' . $study['headline'],
    'description'   => $study['summary'],
    'articleSection'=> 'Case Study',
    'about'         => ['@type' => 'Thing', 'name' => $study['industry']],
    'url'           => canonical('case-studies/' . $study['slug'] . '.php'),
    'author'        => ['@type' => 'Organization', 'name' => SITE_NAME],
    'mentions'      => [
        '@type' => 'Organization',
        'name'  => $study['client'],
        'url'   => $study['url'],
    ],
    'keywords'      => implode(', ', array_merge($study['stack'], [$study['industry']])),
];

require dirname(__DIR__) . '/header.php';
?>

<section class="hero hero--page" style="--accent: <?= e($study['accent']) ?>">
  <div class="shell case-hero">
    <div>
      <a class="btn-link btn-link--back" href="<?= e(url('case-studies.php')) ?>" style="margin-bottom:18px">
        <?= icon('arrow') ?>All case studies
      </a>

      <div data-reveal style="margin-bottom:18px"><?= client_logo($study, 'logo-plate--lg') ?></div>
      <p class="case-industry" data-reveal><?= icon($study['icon']) ?><?= e($study['industry']) ?></p>
      <h1 class="hero-title" data-reveal style="--d:1;font-size:clamp(2rem,4.2vw,3.1rem)"><?= e($study['title']) ?></h1>
      <p class="hero-lead" data-reveal style="--d:2"><?= e($study['headline']) ?> &mdash; <?= e($study['summary']) ?></p>

      <ul class="tag-row" data-reveal style="--d:3">
        <?php foreach ($study['categories'] as $cat): ?>
          <li class="tag tag--cyan"><?= e(CASE_FILTERS[$cat] ?? $cat) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>

    <div class="case-hero-visual" data-reveal style="--d:2">
      <?php component('mock-window', ['study' => $study]); ?>
    </div>
  </div>
</section>

<section class="section section--flush-top" style="--accent: <?= e($study['accent']) ?>">
  <div class="shell">
    <div class="case-metrics" data-reveal>
      <?php foreach ($study['metrics'] as $metric): ?>
        <div class="case-metric"><b><?= e($metric['value']) ?></b><span><?= e($metric['label']) ?></span></div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section section--flush-top" style="--accent: <?= e($study['accent']) ?>">
  <div class="shell split">
    <div class="narrative">
      <article class="narrative-block" data-reveal>
        <h2><?= icon('target') ?>The Challenge</h2>
        <p><?= e($study['challenge']) ?></p>
      </article>

      <article class="narrative-block" data-reveal style="--d:1">
        <h2><?= icon('code') ?>The Ithrive Solution</h2>
        <p><?= e($study['solution']) ?></p>
      </article>

      <article class="narrative-block" data-reveal style="--d:2">
        <h2><?= icon('trending-up') ?>Value Delivered</h2>
        <p><?= e($study['value']) ?></p>
      </article>
    </div>

    <aside class="detail-aside">
      <h2>Project facts</h2>
      <dl class="detail-meta">
        <div><dt>Client</dt><dd><?= e($study['client']) ?></dd></div>
        <div><dt>Industry</dt><dd><?= e($study['industry']) ?></dd></div>
        <div>
          <dt>Client site</dt>
          <dd><a href="<?= e($study['url']) ?>" target="_blank" rel="noopener noreferrer">
            <?= icon('external') ?><?= e(parse_url($study['url'], PHP_URL_HOST) ?: $study['url']) ?>
          </a></dd>
        </div>
        <div><dt>Delivered</dt><dd><?= e(implode(', ', array_map(static fn (string $c): string => CASE_FILTERS[$c] ?? $c, $study['categories']))) ?></dd></div>
      </dl>

      <h2>Key screens</h2>
      <ul class="check-list" style="margin-top:0">
        <?php foreach ($study['screens'] as $screen): ?>
          <li><span class="check-dot"><?= icon('check') ?></span><?= e($screen) ?></li>
        <?php endforeach; ?>
      </ul>

      <div style="margin-top:24px">
        <button class="btn btn-primary btn-block" type="button" data-modal-open>Build something like this<?= icon('arrow') ?></button>
      </div>
    </aside>
  </div>
</section>

<section class="section section--panel" style="--accent: <?= e($study['accent']) ?>">
  <div class="shell">
    <?php component('section-head', [
        'eyebrow' => 'Inside The Build',
        'title'   => 'What we actually engineered',
        'lead'    => 'Six of the capabilities that made the difference, and why each one was there.',
    ]); ?>

    <div class="grid grid-3">
      <?php foreach ($study['features'] as $i => $feature): ?>
        <?php component('feature-card', ['item' => $feature, 'index' => $i % 3]); ?>
      <?php endforeach; ?>
    </div>

    <div class="section-foot" data-reveal>
      <ul class="tag-row" style="justify-content:center">
        <?php foreach ($study['stack'] as $tag): ?><li class="tag tag--cyan"><?= e($tag) ?></li><?php endforeach; ?>
      </ul>
    </div>
  </div>
</section>

<section class="section">
  <div class="shell">
    <?php component('section-head', [
        'eyebrow' => 'More Work',
        'title'   => 'Other platforms we have shipped',
    ]); ?>

    <div class="case-grid">
      <?php
      $others = array_values(array_filter(
          CASE_STUDIES,
          static fn (array $s): bool => $s['slug'] !== $study['slug']
              && array_intersect($s['categories'], $study['categories']) !== []
      ));
      if (count($others) < 2) {
          $others = array_values(array_filter(
              CASE_STUDIES,
              static fn (array $s): bool => $s['slug'] !== $study['slug']
          ));
      }
      foreach (array_slice($others, 0, 2) as $i => $other) {
          component('case-study-card', ['study' => $other, 'index' => $i]);
      }
      ?>
    </div>

    <div class="section-foot" data-reveal>
      <a class="btn btn-ghost" href="<?= e(url('case-studies.php')) ?>">All 10 case studies<?= icon('arrow') ?></a>
    </div>
  </div>
</section>

<?php
component('cta', ['cta' => [
    'eyebrow'   => 'Start Your Project',
    'title'     => 'Have a version of this problem?',
    'body'      => 'Most of what we build starts with someone describing a manual process they have stopped noticing. Send us yours.',
    'primary'   => ['label' => 'Start Your Project', 'href' => 'contact.php'],
    'secondary' => ['label' => 'See our services', 'href' => 'services.php'],
]]);

require dirname(__DIR__) . '/footer.php';
