<?php
declare(strict_types=1);

$page      = 'home';
$pageTitle = 'AI Platforms, Web & Mobile Apps';
$pageDesc  = 'iThrive Software builds AI-native platforms, web and mobile apps in Python — agentic AI ecosystems engineered for the cloud, from Chennai and Coimbatore.';
$heroScene = 'neural';   // loads the orb module for the AI assistant section

require __DIR__ . '/includes/header.php';

// The intro sits over the first section. It is `hidden` in the markup until its
// script reveals it, so the page is never gated by something that might not
// run, and everything below is present exactly as before.
component('entry-gate');

component('hero-3d');
component('client-logo-grid');
?>

<section class="section section--tight">
  <div class="shell">
    <p class="section-lead" data-reveal
       style="max-width:70ch;margin-inline:auto;text-align:center;font-size:1.16rem;color:var(--text)">
      <?= e(HOME_STATEMENT) ?>
    </p>
  </div>
</section>

<?php component('services-film'); ?>

<section class="section section--panel" id="services">
  <div class="shell">
    <?php component('section-head', HOME_SERVICES_HEAD); ?>
    <?php component('services-matrix'); ?>

    <div class="section-foot" data-reveal>
      <a class="btn btn-ghost" href="<?= e(url('services.php')) ?>">View all services<?= icon('arrow') ?></a>
    </div>
  </div>
</section>

<section class="section">
  <div class="shell">
    <?php component('section-head', [
        'eyebrow' => 'Proprietary AI Solutions',
        'title'   => 'Two products we built for ourselves first',
        'lead'    => 'Both started as internal tools. Both now run in client environments, deployed and supported by the same team that wrote them.',
        'art'     => 'aichat',
    ]); ?>

    <div class="grid grid-2">
      <?php foreach (AI_SOLUTIONS as $i => $sol): ?>
        <a class="card" href="<?= e(url('solutions/' . $sol['slug'] . '.php')) ?>" data-reveal style="--d:<?= $i ?>">
          <span class="card-icon"><?= icon($sol['icon']) ?></span>
          <h3 class="card-title"><?= e($sol['name']) ?></h3>
          <p class="card-body" style="color:var(--text);font-size:1rem;margin-bottom:10px"><?= e($sol['tagline']) ?></p>
          <p class="card-body"><?= e($sol['short']) ?></p>

          <ul class="tag-row">
            <?php foreach (array_slice($sol['stack'], 0, 4) as $tag): ?>
              <li class="tag tag--<?= e($sol['accent']) ?>"><?= e($tag) ?></li>
            <?php endforeach; ?>
          </ul>

          <span class="card-link">Explore <?= e($sol['name']) ?><?= icon('arrow') ?></span>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php component('ai-assistant'); ?>

<section class="section" id="tech-stack">
  <div class="shell">
    <?php component('section-head', TECH_STACK_HEAD); ?>
    <?php component('tech-stack'); ?>
  </div>
</section>

<section class="section section--panel" id="process">
  <div class="shell">
    <?php component('section-head', [
        'eyebrow' => PROCESS['eyebrow'],
        'title'   => PROCESS['title'] . ': Discovery → Clarity → Execution',
        'lead'    => PROCESS['lead'],
    ]); ?>
  </div>

  <?php /* Stacking full-screen panels, after averlo.co's service section. Full
           bleed, so outside the shell — a stacking deck constrained to a
           1220px column reads as a list of cards, not as a deck. The pipeline
           component still serves company/process.php. */ ?>
  <?php component('process-panels'); ?>
</section>

<?php /* data-warp turns this section into the scroll-warped grid — the cards
         lean by where they sit and shear by how fast you are moving. The
         content and the markup inside are untouched; warp.js finds the cards
         itself and writes two custom properties. */ ?>
<section class="section warp" data-warp>
  <div class="shell">
    <?php component('section-head', [
        'eyebrow' => 'Case Studies',
        'title'   => 'Platforms running in production right now',
        'lead'    => 'Ten builds across healthcare, mobility, manufacturing, civic tech and retail. Each one closed a gap between a business and the people it serves.',
    ]); ?>

    <div class="case-grid">
      <?php foreach (featured_case_studies(4) as $i => $study): ?>
        <?php component('case-study-card', ['study' => $study, 'index' => $i]); ?>
      <?php endforeach; ?>
    </div>

    <div class="section-foot" data-reveal>
      <a class="btn btn-ghost" href="<?= e(url('case-studies.php')) ?>">All 10 case studies<?= icon('arrow') ?></a>
    </div>
  </div>
</section>

<?php /* The four "why" cards and their artwork are now the scroll-scrubbed
         film — it carries the same points and four more. */ ?>
<?php component('why-film'); ?>

<section class="section section--panel section--tight">
  <div class="shell">
    <?php component('stats-band'); ?>
  </div>
</section>

<section class="section">
  <div class="shell">
    <?php component('section-head', [
        'eyebrow' => 'Client Voices',
        'title'   => 'What the people who signed off on the work say',
        'art'     => 'sec-testimonial',
    ]); ?>
    <?php component('testimonial-slider'); ?>
  </div>
</section>

<?php
component('cta', ['cta' => HOME_CTA]);

require __DIR__ . '/includes/footer.php';
