<?php
declare(strict_types=1);

$page      = 'company';
$pageTitle = 'About — Product Engineering in Python';
$pageDesc  = 'iThrive Software is a product engineering company building intelligent platforms in Python for businesses that have outgrown off-the-shelf software.';

require dirname(__DIR__) . '/includes/header.php';

component('page-hero', [
    'art'     => 'about',
    'eyebrow' => ABOUT['eyebrow'],
    'title'   => ABOUT['title'],
    'lead'    => ABOUT['lead'],
]);
?>

<section class="section section--flush-top">
  <div class="shell split">
    <div>
      <?php foreach (ABOUT['body'] as $i => $para): ?>
        <p class="prose" data-reveal style="--d:<?= $i ?>;font-size:1.02rem"><?= e($para) ?></p>
      <?php endforeach; ?>
    </div>

    <aside class="detail-aside">
      <span class="aside-art" aria-hidden="true">
        <img src="<?= e(asset('assets/img/art/sec-glance.svg')) ?>"
             width="560" height="420" loading="lazy" decoding="async" draggable="false" alt="">
      </span>
      <h2>At a glance</h2>
      <dl class="detail-meta">
        <div><dt>Founded on</dt><dd>Python, Agentic AI and Cloud Architecture</dd></div>
        <div><dt>Head office</dt><dd><?= e(SITE_HQ) ?></dd></div>
        <div><dt>Team</dt><dd>Senior product engineers only — no junior bench</dd></div>
        <div><dt>Engagements</dt><dd>Fixed-scope projects, dedicated squads, on-demand specialists</dd></div>
      </dl>
      <a class="btn btn-primary btn-block" href="<?= e(url('contact.php')) ?>">Start Your Project<?= icon('arrow') ?></a>
    </aside>
  </div>
</section>

<section class="section section--panel">
  <div class="shell">
    <?php component('section-head', [
        'eyebrow' => 'How We Operate',
        'title'   => 'Four commitments we will be held to',
        'art'     => 'sec-commitments',
    ]); ?>

    <div class="grid grid-4">
      <?php foreach (ABOUT['values'] as $i => $value): ?>
        <?php component('feature-card', ['item' => $value, 'index' => $i]); ?>
      <?php endforeach; ?>
    </div>

    <div style="margin-top:56px">
      <?php component('stats-band', ['stats' => ABOUT_STATS]); ?>
    </div>
  </div>
</section>

<section class="section">
  <div class="shell">
    <?php component('section-head', [
        'eyebrow' => 'The Work',
        'title'   => 'Judge us on what is running in production',
        'lead'    => 'Four of the ten platforms we have shipped. Each one replaced a manual process that somebody was doing by hand every single day.',
    ]); ?>

    <div class="case-grid">
      <?php foreach (featured_case_studies(2) as $i => $study): ?>
        <?php component('case-study-card', ['study' => $study, 'index' => $i]); ?>
      <?php endforeach; ?>
    </div>

    <div class="section-foot" data-reveal>
      <a class="btn btn-ghost" href="<?= e(url('case-studies.php')) ?>">All case studies<?= icon('arrow') ?></a>
    </div>
  </div>
</section>

<section class="section section--panel">
  <div class="shell">
    <?php component('section-head', [
        'eyebrow' => 'Client Voices',
        'title'   => 'What the people who signed off say',
        'art'     => 'sec-testimonial',
    ]); ?>
    <?php component('testimonial-slider'); ?>
  </div>
</section>

<?php
component('cta', ['cta' => [
    'eyebrow'   => 'Start Your Project',
    'title'     => 'Bring us the workflow nobody wants to own.',
    'body'      => 'The best briefs we get are one honest paragraph about something that is quietly costing a team hours every week.',
    'primary'   => ['label' => 'Start Your Project', 'href' => 'contact.php'],
    'secondary' => ['label' => 'How we work', 'href' => 'company/process.php'],
]]);

require dirname(__DIR__) . '/includes/footer.php';
