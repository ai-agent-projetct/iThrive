<?php
declare(strict_types=1);

$page      = 'case-studies';
$pageTitle = 'Case Studies — AI, Web, Mobile & ERP';
$pageDesc  = 'Platforms in production across healthcare, mobility, civic tech, manufacturing, tourism and retail — built by iThrive Software in Python.';

// The schema below reads content constants and canonical(), which live in
// config.php — header.php loads it, but not until after this block runs.
require_once __DIR__ . '/includes/config.php';

$schema = [
    '@type'           => 'ItemList',
    'name'            => 'iThrive Software case studies',
    'numberOfItems'   => count(CASE_STUDIES),
    'itemListElement' => array_map(static fn (array $cs, int $i): array => [
        '@type'    => 'ListItem',
        'position' => $i + 1,
        'name'     => $cs['client'] . ' — ' . $cs['headline'],
        'url'      => canonical('case-studies/' . $cs['slug'] . '.php'),
    ], CASE_STUDIES, array_keys(CASE_STUDIES)),
];

require __DIR__ . '/includes/header.php';

/**
 * The hall.
 *
 * Its data goes out as JSON on the element rather than being re-declared in
 * JavaScript, so the scene and the list below it are fed by the same array and
 * cannot drift apart.
 */
$hallData = array_map(static fn (array $cs): array => [
    'client'   => $cs['client'],
    'headline' => $cs['headline'],
    'industry' => $cs['industry'],
    'accent'   => $cs['accent'],
    'logo'     => !empty($cs['logo']) ? asset('assets/img/clients/' . $cs['logo']) : null,
    'href'     => url('case-studies/' . $cs['slug'] . '.php'),
], CASE_STUDIES);
?>

<?php /* The hall is the hero — the first thing on the page, the way the
         reference opens straight into the room rather than onto a title card.
         The heading sits over it and fades as you walk in, driven by --hall-p,
         which the scene publishes as it moves.

         It is written so the scene is an enhancement, not a dependency: with no
         WebGL, under reduced motion, or on a phone, the section collapses to a
         normal full-height hero and the same heading is still the page's h1. */ ?>
<section class="hall" data-hall data-studies='<?= e(json_encode($hallData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)) ?>'>
  <div class="hall-sticky">
    <div class="hall-stage" data-hall-canvas></div>

    <div class="hall-hero">
      <div class="shell">
        <p class="hall-eyebrow"><span class="hall-rule" aria-hidden="true"></span>Case Studies</p>
        <h1 class="hall-title">Every build here closed a gap somebody was living with.</h1>
        <?php /* Worded to hold up whether or not the hall runs — the phone and
                 reduced-motion versions of this page have no hall to walk, so
                 the instruction to walk it lives in .hall-hint, which only
                 appears when the scene does. */ ?>
        <p class="hall-lead">
          Every one of these is a platform running in production. Open any of them
          to read the workaround it replaced and what changed afterwards.
        </p>
      </div>
    </div>

    <span class="hall-tip" data-hall-tip hidden></span>

    <p class="hall-hint" aria-hidden="true"><?= icon('compass') ?>Scroll to walk &middot; click a frame to open it</p>
  </div>
</section>

<?php
/**
 * What the hall is a hall of.
 *
 * The old title card, moved down and given something to say. Left is how to
 * read a case study; right is the work itself — real screenshots of live sites
 * from assets/img/work, not stock, so the section proves its own point.
 */
$anatomy = [
    ['icon' => 'search',   'title' => 'The workaround it replaced',
     'body' => 'Every project starts as a spreadsheet, a WhatsApp group or a phone call somebody makes twice a day. We name that first, because it is the thing being measured against.'],
    ['icon' => 'layers',   'title' => 'What we actually built',
     'body' => 'The architecture, the stack and the decisions behind them — including the ones we would make differently now. Python on the backend in almost every case.'],
    ['icon' => 'trending-up', 'title' => 'What changed afterwards',
     'body' => 'Numbers from production, not from a pitch deck: wait times, conversion, hours returned to a team. Where a number is an estimate, it says so.'],
];

// Five of the shipped sites, chosen for how differently they photograph.
$shots = array_values(array_filter(
    WEB_WORK,
    static fn (array $w): bool => in_array($w['slug'], ['coonoor-club', 'lotus-eye', 'cute-crew', 'madura-grandeur', 'central-adventures'], true)
));
?>

<section class="section csintro">
  <div class="shell csintro-grid">

    <div class="csintro-say">
      <?php component('section-head', [
          'eyebrow' => 'How to read these',
          'title'   => 'Problem, build, result — in that order, every time.',
          'lead'    => 'Platforms and websites in production across healthcare, mobility, '
                     . 'civic tech, manufacturing, tourism and retail. They are written to the '
                     . 'same shape so you can compare them, and so you can find the one that '
                     . 'rhymes with your own problem.',
          'left'    => true,
      ]); ?>

      <ul class="csintro-list">
        <?php foreach ($anatomy as $item): ?>
          <li class="csintro-item">
            <span class="csintro-icon"><?= icon($item['icon']) ?></span>
            <div>
              <h3 class="csintro-title"><?= e($item['title']) ?></h3>
              <p class="csintro-body"><?= e($item['body']) ?></p>
            </div>
          </li>
        <?php endforeach; ?>
      </ul>

      <div class="csintro-cta">
        <a class="btn btn-primary" href="<?= e(url('contact.php')) ?>">Start Your Project<?= icon('arrow') ?></a>
        <a class="btn btn-ghost" href="<?= e(url('company/process.php')) ?>">How we work</a>
      </div>
    </div>

    <?php /* Loading is lazy and every shot is sized, so this column costs the
             hero nothing — the hall is already holding a WebGL context. */ ?>
    <div class="csintro-shots" aria-label="Sites and platforms currently in production">
      <?php foreach ($shots as $i => $wk): ?>
        <figure class="csshot csshot--<?= $i + 1 ?>" style="--tint: <?= e($wk['tint']) ?>">
          <img src="<?= e(asset('assets/img/work/' . $wk['slug'] . '.jpg')) ?>"
               alt="<?= e($wk['name']) ?> — <?= e($wk['kind']) ?>"
               width="640" height="400" loading="lazy" decoding="async">
          <figcaption>
            <span class="csshot-name"><?= e($wk['name']) ?></span>
            <span class="csshot-kind"><?= e($wk['kind']) ?></span>
          </figcaption>
        </figure>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php /* The work itself. The hall is the presentation; this is the content, and
         it stays in the markup either way — wonderland.studio can afford to be
         a canvas with nothing behind it, but the page that carries the proof
         cannot. Visually hidden only once the hall is actually running. */ ?>
<section class="section section--flush-top hall-list">
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
        'title'   => 'What these builds add up to',
        'art'     => 'sec-glance',
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

?>
<?php /* three r128 is a classic script, so the files load strictly in order —
         the scene cannot parse before THREE exists. Skipped entirely under
         reduced motion, where the list below is the whole page. */ ?>
<script>
(function () {
  var mount = document.querySelector('[data-hall-canvas]');
  if (!mount) return;
  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
  if (window.matchMedia('(max-width: 860px)').matches) return;

  var base = <?= json_encode(BASE_URL . '/') ?>;
  ['assets/vendor/three128/three.min.js', 'assets/js/gallery-hall.js'].reduce(function (chain, url) {
    return chain.then(function () {
      return new Promise(function (ok, fail) {
        var el = document.createElement('script');
        el.src = base + url;
        el.onload = ok;
        el.onerror = function () { fail(new Error(url)); };
        document.head.appendChild(el);
      });
    });
  }, Promise.resolve())
    .then(function () { if (window.ithriveHall) window.ithriveHall(mount); })
    .catch(function () {
      // No WebGL or a blocked script. Nothing to undo: without the hall--live
      // class the section is already a plain full-height hero carrying the h1,
      // and the case study grid below it stays visible.
    });
})();
</script>
<?php
require __DIR__ . '/includes/footer.php';
