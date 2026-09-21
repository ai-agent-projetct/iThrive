<?php
/**
 * How working with us from outside India actually goes.
 *
 * This is the page the overseas queries land on — "AI development company for
 * US clients", "hire AI agent developers from India" — and it exists instead of
 * a fabricated page per foreign city. Everything on it is true of every
 * overseas client: the team is in India, the overlap is real, the contract and
 * the IP terms are the same.
 */

declare(strict_types=1);

$page      = 'company';
$pageTitle = 'AI Development for US, UK & Gulf Clients';
$pageDesc  = 'How working with iThrive Software from outside India goes: hours of overlap with '
           . 'US, UK, Canadian and Gulf teams, your IP from day one, and engineers in your standup.';

require_once __DIR__ . '/../includes/config.php';

$schema = [
    '@type'       => 'Service',
    'name'        => 'Offshore AI and software development from India',
    'serviceType' => 'Software Development',
    'description' => $pageDesc,
    'url'         => canonical('locations/global-delivery.php'),
    'areaServed'  => areas_served(),
];

/* Time zones rather than marketing claims: these are the overlaps an Indian
   working day (10:00-19:00 IST) genuinely has, and they are what a buyer
   abroad is actually asking about. */
$overlaps = [
    ['region' => 'United Kingdom & Ireland', 'zone' => 'GMT / BST', 'overlap' => '5 to 6 hours', 'note' => 'Your morning is our afternoon. Same-day turnaround on anything raised before lunch.'],
    ['region' => 'United Arab Emirates & Gulf', 'zone' => 'GST', 'overlap' => '7 to 8 hours', 'note' => 'Ninety minutes apart. For practical purposes we keep the same working day.'],
    ['region' => 'United States — East', 'zone' => 'ET', 'overlap' => '2 to 3 hours', 'note' => 'A 09:00 ET standup is 18:30 IST — late in our day, but inside it. We agree the window up front.'],
    ['region' => 'United States — West', 'zone' => 'PT', 'overlap' => '1 to 2 hours', 'note' => 'One fixed window a day, agreed up front, plus written handover on both ends of it.'],
    ['region' => 'Canada', 'zone' => 'ET / PT', 'overlap' => '1 to 3 hours', 'note' => 'The same arrangement as the US, by whichever coast you are on.'],
    ['region' => 'Singapore & Australia', 'zone' => 'SGT / AEST', 'overlap' => '4 to 6 hours', 'note' => 'Our morning is your afternoon; reviews land before your day ends.'],
];

$terms = [
    ['title' => 'Your IP from the first commit',   'body' => 'The code is yours as it is written, in your repository, under your licence. There is no assignment at the end of the project because there is nothing to assign.'],
    ['title' => 'Billing you can plan around',     'body' => 'Fixed-scope work is billed against milestones; a dedicated team is billed monthly and scales on thirty days\' notice. The currency and the contracting entity are settled before the first invoice, not after it.'],
    ['title' => 'Data stays in your account',      'body' => 'We deploy into your cloud tenancy. Your documents and your model traffic do not have to cross into ours for us to build on them.'],
    ['title' => 'One team, not a rotating bench',  'body' => 'The engineers you meet in week one are the ones who write it. Replacements are announced and handed over, not silently swapped.'],
];

$faqs = [
    ['Can you work US or UK hours?',
     'Partly, and we would rather say so plainly. The UK and the Gulf overlap most of our day. For US hours we hold a late shift that covers 09:00 to 12:00 ET, with written handover either side. Nobody works nights to keep up a pretence of full overlap.'],
    ['Do you have an office in the US, Canada or the UK?',
     'No. The team is in India — Chennai, Coimbatore, Bangalore, Hyderabad and Ahmedabad — and we work with clients abroad remotely. We would rather tell you that than list an address that is a mailbox.'],
    ['Who owns the code and the models?',
     'You do, from the first commit, including fine-tuned model weights and the evaluation sets we build to test them.'],
    ['How do payments and contracts work?',
     'Monthly invoicing in your currency, under a contract in your jurisdiction if you prefer. Fixed-scope work is billed on milestones; dedicated teams are billed monthly and scale on thirty days\' notice.'],
    ['How do you handle security reviews?',
     'We answer the questionnaire, deploy into your environment and hand over the access model, audit trail and retention rules as part of the build — not as a document written afterwards to pass a review.'],
];

$schemaExtra = [[
    '@type'      => 'FAQPage',
    'name'       => 'Working with iThrive Software from outside India',
    'mainEntity' => array_map(static fn (array $f): array => [
        '@type'          => 'Question',
        'name'           => $f[0],
        'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f[1]],
    ], $faqs),
]];

require __DIR__ . '/../includes/header.php';

component('page-hero', [
    'crumb'   => ['label' => 'About iThrive', 'href' => 'company/about.php'],
    'eyebrow' => 'Global delivery',
    'title'   => 'Working with us from outside India',
    'lead'    => 'Five studios in India, clients in the US, Canada, the UK, the Gulf and Australia. '
               . 'Here is the honest version of how that works — hours, contracts, IP and security.',
    'actions' => [
        ['label' => 'Start your project', 'href' => 'contact.php'],
        ['label' => 'See our work', 'href' => 'case-studies.php'],
    ],
]);
?>

<section class="section section--flush-top">
  <div class="shell">
    <?php component('section-head', [
        'eyebrow' => 'Hours',
        'title'   => 'How much of your day we actually share',
        'lead'    => 'Our working day is 10:00 to 19:00 IST. These are the real overlaps, not the ones that look best on a slide.',
    ]); ?>

    <div class="grid grid-3">
      <?php foreach ($overlaps as $i => $o): ?>
        <article class="card" data-reveal style="--d:<?= $i % 3 ?>">
          <h3 class="card-title"><?= e($o['region']) ?></h3>
          <p class="card-body">
            <strong><?= e($o['overlap']) ?></strong> of overlap · <?= e($o['zone']) ?><br>
            <?= e($o['note']) ?>
          </p>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section section--panel">
  <div class="shell">
    <?php component('section-head', [
        'eyebrow' => 'Terms',
        'title'   => 'The four questions every overseas client asks first',
    ]); ?>

    <div class="grid grid-2">
      <?php foreach ($terms as $i => $item): ?>
        <?php component('feature-card', ['item' => $item, 'index' => $i % 2]); ?>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section">
  <div class="shell">
    <?php component('section-head', [
        'eyebrow' => 'Where the work happens',
        'title'   => 'The five studios behind it',
        'lead'    => 'Your project is staffed from whichever of them the work belongs in.',
    ]); ?>

    <div class="grid grid-3">
      <?php foreach (LOCATIONS as $i => $loc): ?>
        <a class="card" href="<?= e(url('locations/' . $loc['slug'] . '.php')) ?>" data-reveal style="--d:<?= $i % 3 ?>">
          <h3 class="card-title"><?= e($loc['city']) ?></h3>
          <p class="card-body"><?= e($loc['role']) ?></p>
          <span class="card-link">Read more<?= icon('arrow') ?></span>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section section--panel">
  <div class="shell">
    <?php component('section-head', ['eyebrow' => 'Questions', 'title' => 'Working with an Indian team']); ?>

    <div class="faq-list">
      <?php foreach ($faqs as $i => [$q, $a]): ?>
        <details class="faq-item"<?= $i === 0 ? ' open' : '' ?>>
          <summary>
            <span><?= e($q) ?></span>
            <?= icon('chevron', 'icon faq-caret') ?>
          </summary>
          <p><?= e($a) ?></p>
        </details>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php component('cta', ['cta' => [
    'eyebrow'   => 'Global delivery',
    'title'     => 'Tell us what you are building',
    'body'      => 'An engineer joins the first call. If the time zones do not work, we will say so on that call rather than three weeks in.',
    'primary'   => ['label' => 'Start your project', 'href' => 'contact.php'],
    'secondary' => ['label' => 'See all services', 'href' => 'services.php'],
]]); ?>

<?php require __DIR__ . '/../includes/footer.php'; ?>
