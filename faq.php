<?php
/**
 * The answer book, published.
 *
 * All seventy questions already existed in includes/faq.php, but only the chat
 * assistant could see them — no crawler, and no AI assistant, ever read a word.
 * They are the most extractable content on this site: specific, factual, priced
 * and dated, which is exactly what a model will quote. This page publishes them
 * with FAQPage schema so they can be.
 */

declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';

$page      = 'company';
$pageTitle = 'Frequently Asked Questions';
$pageDesc  = 'Seventy straight answers on what iThrive Software builds, what it costs, how long '
           . 'it takes and how an engagement runs — pricing, timelines, IP, support and AI.';
$ogImage   = 'company';

/**
 * FAQPage, the whole book.
 *
 * Google's guidance is that every Q&A in the markup must be visible on the
 * page, so this is built from the same array the page renders rather than a
 * curated subset.
 */
$schema = [
    '@type'      => 'FAQPage',
    'name'       => 'iThrive Software — frequently asked questions',
    'url'        => canonical('faq.php'),
    // Marks what a voice assistant should read out. The questions and answers
    // are written to be spoken — that is why the answer book has no markdown.
    'speakable'  => [
        '@type'       => 'SpeakableSpecification',
        'cssSelector' => ['.faq-item summary', '.faq-item p'],
    ],
    'mainEntity' => array_map(static fn (array $entry): array => [
        '@type'          => 'Question',
        'name'           => $entry['q'],
        'acceptedAnswer' => ['@type' => 'Answer', 'text' => $entry['a']],
    ], FAQ),
];

require __DIR__ . '/includes/header.php';

component('page-hero', [
    'art'     => 'process',
    'crumb'   => ['label' => 'Company', 'href' => 'company/about.php'],
    'eyebrow' => 'Answers',
    'title'   => 'Seventy questions, answered straight',
    'lead'    => 'Pricing, timelines, ownership, support and AI — the things people ask before '
               . 'they sign, with real numbers rather than "it depends".',
]);

// Group the flat book by its categories so the page has a navigable shape.
$byCategory = [];
foreach (FAQ as $entry) {
    $byCategory[$entry['cat']][] = $entry;
}
?>

<section class="section section--flush-top">
  <div class="shell">
    <nav class="faq-jump" aria-label="Question categories">
      <?php foreach (FAQ_CATEGORIES as $slug => $label): ?>
        <?php if (empty($byCategory[$slug])) continue; ?>
        <a href="#<?= e($slug) ?>"><?= e($label) ?>
          <span><?= count($byCategory[$slug]) ?></span>
        </a>
      <?php endforeach; ?>
    </nav>
  </div>
</section>

<?php foreach (FAQ_CATEGORIES as $slug => $label): ?>
  <?php if (empty($byCategory[$slug])) continue; ?>

  <section class="section section--tight<?= array_search($slug, array_keys(FAQ_CATEGORIES), true) % 2 ? ' section--panel' : '' ?>" id="<?= e($slug) ?>">
    <div class="shell">
      <h2 class="section-title section-title--left" data-reveal><?= e($label) ?></h2>

      <?php /* <details> rather than a JavaScript accordion: it is open to
               find-in-page, it prints, and its content is in the DOM for a
               crawler whether or not the panel is expanded. */ ?>
      <div class="faq-list">
        <?php foreach ($byCategory[$slug] as $entry): ?>
          <details class="faq-item" id="<?= e($entry['id']) ?>">
            <summary>
              <span><?= e($entry['q']) ?></span>
              <?= icon('chevron', 'icon faq-caret') ?>
            </summary>
            <p><?= e($entry['a']) ?></p>
          </details>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
<?php endforeach; ?>

<?php
?>

<section class="section section--tight">
  <div class="shell">
    <?php component('page-figure', ['src' => 'faq-panels', 'caption' => 'Seventy of these started as questions somebody actually asked us.']); ?>
  </div>
</section>

<?php
?>

<section class="section section--tight">
  <div class="shell">
    <?php component('page-figure', ['src' => 'faq-support', 'caption' => 'When the answer here is not enough, a person picks it up.']); ?>
  </div>
</section>

<?php
?>

<section class="section section--tight">
  <div class="shell">
    <?php component('page-figure', ['src' => 'faq-knowledge-graph', 'caption' => 'Every answer on this page is also fed to the assistant, in six languages.']); ?>
  </div>
</section>

<?php
component('cta', ['cta' => [
    'eyebrow'   => 'Still Deciding?',
    'title'     => 'Ask the one we have not answered.',
    'body'      => 'Describe what you are trying to build. You will get scope, stack and a realistic timeline in writing, within two working days.',
    'primary'   => ['label' => 'Start Your Project', 'href' => 'contact.php'],
    'secondary' => ['label' => 'See the work', 'href' => 'case-studies.php'],
]]);

require __DIR__ . '/includes/footer.php';
