<?php
/**
 * Web Development — the second page that leaves the shared service layout.
 *
 * It earns the exception the same way the mobile page did: this is the page
 * meant to rank for "website development company in Chennai" and its sibling
 * city terms, which needs far more copy, far more structured data and a set of
 * sections the shared template has no concept of.
 *
 * The scroll experience is a walkthrough. Each section carries data-room, and
 * assets/js/web-rooms.js turns those into rooms in a 3D corridor behind the
 * page — scrolling walks a figure forward, and each section plays its entrance
 * as the figure arrives. Every word stays real HTML in front of the canvas:
 * text inside a WebGL context is text no crawler and no answer engine reads,
 * which would defeat the point of the page.
 *
 * Copy lives in includes/content-web.php.
 */

declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/config.php';

$svc = service('web-development');

$page      = 'services';
$pageTitle = 'Website Development Company in Chennai, Coimbatore & Bangalore';
$pageDesc  = 'iThrive Software builds custom websites, web applications and e-commerce platforms '
           . 'across Chennai, Coimbatore, Bangalore and India — fast, accessible, and built to rank.';
$ogImage   = 'service-' . $svc['group_slug'];

/**
 * The structured data does the heavy lifting for AEO. Five things are declared:
 * the service itself with its catalogue, the price tiers as real Offers, the
 * six-step build as a HowTo, the ten answers as a FAQPage, and each studio as
 * a LocalBusiness so the city queries have somewhere to land.
 */
$schema = [
    '@type'       => 'Service',
    'name'        => 'Website Development',
    'serviceType' => 'Web Development',
    'description' => WEB_HERO['lead'],
    'url'         => canonical('services/web-development.php'),
    'provider'    => ['@type' => 'Organization', 'name' => SITE_NAME, 'url' => canonical('')],
    'areaServed'  => [
        ['@type' => 'City',  'name' => 'Chennai'],
        ['@type' => 'City',  'name' => 'Coimbatore'],
        ['@type' => 'City',  'name' => 'Bangalore'],
        ['@type' => 'State', 'name' => 'Tamil Nadu'],
        ['@type' => 'Country', 'name' => 'India'],
    ],
    'hasOfferCatalog' => [
        '@type'           => 'OfferCatalog',
        'name'            => 'Website development services',
        'itemListElement' => array_map(static fn (array $s): array => [
            '@type'       => 'Offer',
            'itemOffered' => ['@type' => 'Service', 'name' => $s['title'], 'description' => $s['body']],
        ], WEB_SERVICES),
    ],
];

// Extra graph nodes, merged by the schema component.
$schemaExtra = [
    [
        '@type'       => 'HowTo',
        'name'        => 'How iThrive Software builds a website',
        'description' => 'The six stages of a website build, from discovery to launch and support.',
        'totalTime'   => 'P5W',
        'step'        => array_values(array_map(static fn (int $i, array $s): array => [
            '@type'    => 'HowToStep',
            'position' => $i + 1,
            'name'     => $s['title'],
            'text'     => $s['body'],
        ], array_keys(WEB_PROCESS), WEB_PROCESS)),
    ],
    [
        '@type'      => 'FAQPage',
        'name'       => 'Website development — frequently asked questions',
        'speakable'  => [
            '@type'       => 'SpeakableSpecification',
            'cssSelector' => ['.web-faq summary', '.web-faq p'],
        ],
        'mainEntity' => array_map(static fn (array $f): array => [
            '@type'          => 'Question',
            'name'           => $f['q'],
            'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f['a']],
        ], WEB_FAQ),
    ],
    [
        '@type'           => 'ItemList',
        'name'            => 'Websites built by iThrive Software',
        'itemListElement' => array_values(array_filter(array_map(static function (int $i, array $wk) {
            if (empty($wk['url'])) {
                return null;
            }

            return [
                '@type'    => 'ListItem',
                'position' => $i + 1,
                'name'     => $wk['name'],
                'url'      => $wk['url'],
            ];
        }, array_keys(WEB_WORK), WEB_WORK))),
    ],
];

foreach (WEB_LOCATIONS as $loc) {
    $schemaExtra[] = [
        '@type'       => 'LocalBusiness',
        'name'        => SITE_NAME . ' — ' . $loc['city'],
        'description' => $loc['body'],
        'url'         => canonical('services/web-development.php') . '#' . strtolower($loc['city']),
        'email'       => SITE_EMAIL,
        'address'     => [
            '@type'           => 'PostalAddress',
            'addressLocality' => $loc['city'],
            'addressRegion'   => $loc['region'],
            'addressCountry'  => 'IN',
        ],
        'areaServed'  => ['@type' => 'City', 'name' => $loc['city']],
    ];
}

require dirname(__DIR__) . '/includes/header.php';
?>

<?php /* The corridor. Fixed behind everything, purely decorative, and absent
         entirely without WebGL or with reduced motion asked for. */ ?>
<div class="rooms" data-rooms aria-hidden="true"></div>

<div class="web-page">

  <!-- ── Room 1 · The Brief ─────────────────────────────────────────── -->
  <section class="section web-hero" id="brief"
           data-room="brief" data-room-hue="188" data-room-label="The Brief">
    <div class="shell">
      <p class="eyebrow"><?= e(WEB_HERO['eyebrow']) ?></p>
      <h1 class="web-h1"><?= e(WEB_HERO['title']) ?></h1>
      <p class="web-lead"><?= e(WEB_HERO['lead']) ?></p>

      <div class="web-cta-row">
        <a class="btn btn-primary" href="<?= e(url(WEB_HERO['primary']['href'])) ?>">
          <?= e(WEB_HERO['primary']['label']) ?><?= icon('arrow') ?>
        </a>
        <a class="btn btn-ghost" href="<?= e(WEB_HERO['secondary']['href']) ?>">
          <?= e(WEB_HERO['secondary']['label']) ?>
        </a>
      </div>

      <ul class="web-stats">
        <?php foreach (WEB_STATS as $stat): ?>
          <li>
            <span class="web-stat-value"><?= e($stat['value']) ?></span>
            <span class="web-stat-label"><?= e($stat['label']) ?></span>
          </li>
        <?php endforeach; ?>
      </ul>

      <?php /* The 3D showcase — the sites we have shipped, as cards that burst
               out of a laptop screen as you zoom in. */ ?>
      <?php component('web-universe'); ?>
    </div>
  </section>

  <!-- ── Why it matters ─────────────────────────────────────────────── -->
  <section class="section section--tight web-intro">
    <div class="shell">
      <?php component('section-head', ['eyebrow' => WEB_INTRO['eyebrow'], 'title' => WEB_INTRO['title']]); ?>
      <div class="web-intro-copy">
        <?php foreach (WEB_INTRO['body'] as $para): ?>
          <p><?= e($para) ?></p>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <?php /* The reference the client sent (bestbeanbestcup.com.au) gets its 3D
           feel from oversized kinetic type with imagery moving behind it, not
           from WebGL — the site has no Three.js and no WebGL context at all.
           This is that technique: the fill inside the letterforms is a strip of
           the eight sites we have shipped, and it travels as the page scrolls.
           background-clip on text is the whole trick. */ ?>
  <section class="kinetic" aria-label="Websites built in Chennai, Coimbatore and Bangalore">
    <div class="kinetic-track" data-kinetic>
      <p class="kinetic-word" aria-hidden="true">WEBSITES</p>
      <p class="kinetic-word kinetic-word--alt" aria-hidden="true">THAT&nbsp;RANK</p>
    </div>
    <p class="kinetic-sr sr-only">
      iThrive Software has built websites for Coonoor Club, Lotus Eye Hospital, Cute Crew,
      Central Adventures, Madura Grandeur, Bharani Beauty Clinic, Aruvanaa and LogiSethu.
    </p>
  </section>

  <!-- ── Room 2 · The Workshop ──────────────────────────────────────── -->
  <section class="section web-build" id="build"
           data-room="build" data-room-hue="206" data-room-label="The Workshop">
    <div class="shell">
      <?php component('section-head', [
          'eyebrow' => 'What We Build',
          'title'   => 'Website development services, end to end',
          'lead'    => 'Ten things we are asked for most. Every one of them is delivered by the same '
                     . 'senior team, on the same performance and accessibility budget.',
      ]); ?>

      <div class="grid grid-3 web-cards">
        <?php foreach (WEB_SERVICES as $i => $s): ?>
          <article class="card web-card" style="--i: <?= $i ?>">
            <span class="web-card-icon"><?= icon($s['icon']) ?></span>
            <h3 class="card-title"><?= e($s['title']) ?></h3>
            <p class="card-body"><?= e($s['body']) ?></p>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- ── Room 3 · The Line ──────────────────────────────────────────── -->
  <section class="section web-process" id="process"
           data-room="process" data-room-hue="224" data-room-label="The Line">
    <div class="shell">
      <?php component('section-head', [
          'eyebrow' => 'How It Runs',
          'title'   => 'Six stages, with a date against each one',
          'lead'    => 'The whole schedule is agreed before anything is designed. You can open a staging '
                     . 'URL from the first development sprint onward.',
      ]); ?>

      <ol class="web-steps">
        <?php foreach (WEB_PROCESS as $i => $step): ?>
          <li class="web-step" style="--i: <?= $i ?>">
            <span class="web-step-num"><?= str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT) ?></span>
            <div class="web-step-body">
              <h3><?= e($step['title']) ?></h3>
              <p><?= e($step['body']) ?></p>
              <span class="web-step-days"><?= icon('clock') ?><?= e($step['days']) ?></span>
            </div>
          </li>
        <?php endforeach; ?>
      </ol>
    </div>
  </section>

  <!-- ── Room 4 · The Gallery ───────────────────────────────────────── -->
  <?php /* Full-bleed panels that slide sideways, the way 2025.unseen.co moves:
           one site per screen, the capture playing behind the copy, and the
           whole thing driven by the scroll you spend crossing the section.

           The clips are scroll-throughs of the live sites, captured and encoded
           rather than screenshotted — a still of a website tells you nothing
           about how it behaves. MP4 rather than GIF: same autoplay-loop, a
           fraction of the weight, and it can be told not to download until the
           panel is close. */ ?>
  <section class="section hscroll hwork-full" id="work"
           data-room="work" data-room-hue="258" data-room-label="The Gallery"
           data-hscroll>
    <div class="hscroll-stage">
      <ol class="hscroll-track" data-hscroll-track>

        <li class="hpanel hpanel--intro">
          <div class="hpanel-intro">
            <p class="eyebrow">Selected Work</p>
            <h2 class="hpanel-intro-title">Websites we<br>have shipped</h2>
            <p class="hpanel-intro-lead">
              Keep scrolling — the work moves sideways. Every panel is a live site,
              playing as it scrolls.
            </p>
          </div>
        </li>

        <?php foreach (WEB_WORK as $i => $wk): ?>
          <li class="hpanel" style="--tint: <?= e($wk['tint']) ?>">
            <?php $clip = ROOT_PATH . '/assets/video/work/' . $wk['slug'] . '.mp4'; ?>

            <?php if (is_file($clip)): ?>
              <?php /* preload="none": eight clips is more than anyone will watch,
                       so nothing downloads until hscroll.js says the panel is
                       near. The poster is the still we already had. */ ?>
              <video class="hpanel-media" data-hpanel-video
                     muted loop playsinline preload="none" disablepictureinpicture
                     poster="<?= e(asset('assets/img/work/' . $wk['slug'] . '.jpg')) ?>"
                     data-src="<?= e(asset('assets/video/work/' . $wk['slug'] . '.mp4')) ?>"></video>
            <?php else: ?>
              <img class="hpanel-media" src="<?= e(asset('assets/img/work/' . $wk['slug'] . '.jpg')) ?>"
                   width="1280" height="720" loading="lazy" decoding="async"
                   alt="<?= e($wk['name'] . ' website built by ' . SITE_NAME) ?>">
            <?php endif; ?>

            <span class="hpanel-scrim" aria-hidden="true"></span>

            <div class="hpanel-copy">
              <p class="hpanel-tag">
                [<?= e(strtoupper($wk['kind'])) ?>] [<?= e($wk['year']) ?>]
              </p>
              <h3 class="hpanel-name"><?= e($wk['name']) ?></h3>
              <p class="hpanel-note"><?= e($wk['note']) ?></p>
              <?php if ($wk['url']): ?>
                <a class="hpanel-link" href="<?= e($wk['url']) ?>" target="_blank" rel="noopener">
                  Visit the site<?= icon('arrow-up-right') ?>
                </a>
              <?php endif; ?>
            </div>

            <span class="hpanel-index" aria-hidden="true">
              [US_<?= str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT) ?>_<?= e(substr($wk['year'], -2)) ?>]
            </span>
          </li>
        <?php endforeach; ?>

        <li class="hpanel hpanel--end">
          <div class="hpanel-intro">
            <h2 class="hpanel-intro-title">Your site<br>could be next.</h2>
            <a class="btn btn-primary" href="<?= e(url('contact.php')) ?>">Start your project<?= icon('arrow') ?></a>
          </div>
        </li>
      </ol>

      <span class="hscroll-progress" aria-hidden="true"><span data-hscroll-bar></span></span>
    </div>
  </section>

  <!-- ── Room 5 · The Engine Room ───────────────────────────────────── -->
  <section class="section web-stack" id="stack"
           data-room="stack" data-room-hue="276" data-room-label="The Engine Room">
    <div class="shell">
      <?php component('section-head', [
          'eyebrow' => 'The Stack',
          'title'   => 'What we build websites with',
          'lead'    => 'Chosen for what the project needs. A brochure site does not need the stack a '
                     . 'booking platform does, and pretending otherwise is how budgets disappear.',
      ]); ?>

      <div class="web-stack-grid">
        <?php
        $stackGroups = [
            'Front end'  => ['React', 'Next.js', 'TypeScript', 'Tailwind', 'Vite', 'Alpine.js'],
            'Back end'   => ['Python', 'Django', 'FastAPI', 'PHP 8', 'Laravel', 'Node.js'],
            'Data'       => ['PostgreSQL', 'MySQL', 'Redis', 'Elasticsearch'],
            'Content'    => ['WordPress', 'Headless CMS', 'Sanity', 'Custom admin'],
            'Commerce'   => ['WooCommerce', 'Razorpay', 'Stripe', 'UPI'],
            'Infra'      => ['Nginx', 'Cloudflare', 'AWS', 'Docker', 'GitHub Actions'],
        ];
        foreach ($stackGroups as $groupName => $tools): ?>
          <div class="web-stack-group">
            <h3><?= e($groupName) ?></h3>
            <ul>
              <?php foreach ($tools as $t): ?><li><?= e($t) ?></li><?php endforeach; ?>
            </ul>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- ── Room 6 · The Floor ─────────────────────────────────────────── -->
  <?php /* An icon wall. The detail is not printed under every tile — it arrives
           when you point at one, so the grid reads as a set of marks rather
           than twelve paragraphs. The copy is in the markup either way, so it
           is there for a crawler and for anyone using a keyboard. */ ?>
  <section class="section web-industries" id="industries"
           data-room="industries" data-room-hue="292" data-room-label="The Floor">
    <div class="shell">
      <?php component('section-head', [
          'eyebrow' => 'Industries',
          'title'   => 'Sectors we have shipped into',
          'lead'    => 'Each one has its own conversion problem. Hover a sector to see what it is.',
      ]); ?>

      <ul class="sector-wall">
        <?php foreach (WEB_INDUSTRIES as $i => $ind): ?>
          <li class="sector" tabindex="0" style="--i: <?= $i ?>">
            <span class="sector-icon"><?= icon($ind['icon']) ?></span>
            <span class="sector-name"><?= e($ind['title']) ?></span>
            <span class="sector-body"><?= e($ind['body']) ?></span>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </section>

  <?php /* The rate card is gone. A price grid answers a question people ask
           later than this; what belongs here is the same single call the mobile
           page makes at this point in the scroll. */ ?>
  <section class="section web-quote-cta">
    <div class="shell">
      <h2 class="web-quote-title">
        Looking for a reliable <span class="web-quote-accent">website development partner?</span>
      </h2>
      <p class="web-quote-lead">
        iThrive Software builds custom websites, e-commerce platforms and web applications for
        businesses in Chennai, Coimbatore, Bangalore and across India — scoped, priced and dated
        in writing before a line is written.
      </p>
      <div class="web-quote-actions">
        <a class="btn btn-primary" href="<?= e(url('contact.php')) ?>">
          Request Free Proposal &amp; Quote<?= icon('arrow') ?>
        </a>
        <a class="btn btn-ghost" href="#work">See the work</a>
      </div>
    </div>
  </section>

  <!-- ── Why us ─────────────────────────────────────────────────────── -->
  <?php /* Origin Kit's Swipe Stack: a fanned 3D deck where the top card drags,
           flicks to the back past a threshold, and snaps home on a short swipe.
           The cards are real headings and copy rather than a canvas — this page
           has to rank, and a drawn deck would be an empty box to everything
           except a human with a mouse. */ ?>
  <section class="section web-why">
    <div class="shell">
      <?php component('section-head', [
          'eyebrow' => 'Why iThrive',
          'title'   => 'What is different about working with us',
          'lead'    => 'Drag the top card, or use the arrow keys. Six of them, and they cycle.',
      ]); ?>

      <div class="swipe-wrap">
        <div class="swipe-stack" data-swipe-stack
             data-threshold="50" data-tilt-start="0" data-tilt="-45" data-x-offset="10"
             role="group" aria-roledescription="card deck"
             aria-label="What is different about working with iThrive Software">
          <?php foreach (WEB_WHY as $i => $why): ?>
            <article class="swipe-card" data-swipe-card
                     style="--tint: <?= e(['#00F2FE', '#4EA8FF', '#9D4EDD', '#2FA36B', '#F2649B', '#C8A24A'][$i % 6]) ?>">
              <span class="swipe-num"><?= str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT) ?> / <?= count(WEB_WHY) ?></span>
              <h3 class="swipe-title"><?= e($why['title']) ?></h3>
              <p class="swipe-body"><?= e($why['body']) ?></p>
            </article>
          <?php endforeach; ?>
        </div>

        <button class="swipe-next" type="button" data-swipe-next>
          Next<?= icon('arrow') ?>
        </button>
      </div>
    </div>
  </section>

  <!-- ── Room 7 · The Map Room ──────────────────────────────────────── -->
  <section class="section section--panel web-locations" id="locations"
           data-room="locations" data-room-hue="310" data-room-label="The Map Room">
    <div class="shell">
      <?php component('section-head', [
          'eyebrow' => 'Where We Work',
          'title'   => 'Website development across Tamil Nadu, Bangalore and India',
          'lead'    => 'Three studios, one delivery team. Discovery and design sign-off happen on-site '
                     . 'in any of the three cities; everything after that runs against a staging URL.',
      ]); ?>

      <div class="web-city-grid">
        <?php foreach (WEB_LOCATIONS as $i => $loc): ?>
          <article class="web-city" id="<?= e(strtolower($loc['city'])) ?>" style="--i: <?= $i ?>">
            <span class="web-city-pin"><?= icon('pin') ?></span>
            <h3><?= e($loc['heading']) ?></h3>
            <p class="web-city-region"><?= e($loc['city']) ?>, <?= e($loc['region']) ?></p>
            <p><?= e($loc['body']) ?></p>
          </article>
        <?php endforeach; ?>
      </div>

      <p class="web-reach">
        We also deliver remotely to clients across <strong>Tamil Nadu</strong> — Madurai, Trichy, Salem,
        Erode, Tirupur and the Nilgiris — and to businesses anywhere in <strong>India</strong>.
      </p>
    </div>
  </section>

  <!-- ── FAQ ────────────────────────────────────────────────────────── -->
  <section class="section web-faq">
    <div class="shell">
      <?php component('section-head', [
          'eyebrow' => 'Questions',
          'title'   => 'Website development, answered straight',
      ]); ?>

      <div class="web-faq-list">
        <?php foreach (WEB_FAQ as $i => $f): ?>
          <details class="faq-item"<?= $i === 0 ? ' open' : '' ?>>
            <summary>
              <span><?= e($f['q']) ?></span>
              <?= icon('chevron', 'icon faq-caret') ?>
            </summary>
            <p><?= e($f['a']) ?></p>
          </details>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <?php component('cta', ['cta' => [
      'eyebrow'   => 'Start Your Project',
      'title'     => 'Tell us what the website has to achieve.',
      'body'      => 'Send a paragraph about your business and what the site needs to do. You will get '
                   . 'scope, a fixed price and a delivery date in writing within two working days.',
      'primary'   => ['label' => 'Get a Website Quote', 'href' => 'contact.php'],
      'secondary' => ['label' => 'See all services',    'href' => 'services.php'],
  ]]); ?>

</div>

<script type="module" src="<?= e(asset('assets/js/web-rooms.js')) ?>"></script>
<script src="<?= e(asset('assets/js/work-canvas.js')) ?>" defer></script>
<script src="<?= e(asset('assets/js/hscroll.js')) ?>" defer></script>
<script src="<?= e(asset('assets/js/swipe-stack.js')) ?>" defer></script>

<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
