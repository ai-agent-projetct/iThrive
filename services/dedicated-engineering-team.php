<?php
/**
 * Dedicated Engineering Team — the fourth service page off the shared layout.
 *
 * Built after absoluteapplabs.com/dedicated-software-development-team, section
 * for section, in iThrive's own words.
 *
 * THE CONSTRAINT ON THIS ONE: no component may repeat from the other three
 * bespoke pages. Every Framer component below is mounted here for the first
 * time on this site, and the two that were vendored longest ago — Curved
 * Gallery Arc and Apple Glass Stack — had been registered for months without
 * ever appearing on a page.
 *
 *   hero        Curved Gallery Arc    a draggable 3D arc of the ten roles
 *   why         Circle Expand Card    four cards that open from a circle
 *   roles       Image Scroller        the ten disciplines, scrolled
 *   band        Gradient Bars         a bar field behind the quote
 *   process     Sticky Scroll Story   the four steps, one at a time
 *   proof       Apple Glass Stack     five commitments in glass
 *   close       Ambient Background    drifting blobs under the last word
 *
 * SPLINE: the hero is wired for it and will use it the moment a scene exists.
 * Spline has no authoring API — a .splinecode URL is only produced by the
 * Spline editor against an account — so this cannot be generated from here.
 * includes/components/spline-hero.php already handles the embed; set
 * SPLINE_SCENE (or SPLINE_SCENE_TEAM for this page alone) and the arc below
 * steps aside for it. Until then the arc is the live 3D hero, so the page is
 * complete either way rather than waiting on a scene that may never come.
 *
 * Theme: the site's own ramp, unchanged — #00F2FE into #4EA8FF into #9D4EDD,
 * exactly as style.css defines it. This page shipped once in amber on the
 * theory that a colour of its own would keep four dark pages apart; it did,
 * and it also stopped looking like the same website. What separates this page
 * is its layout, its components and its roster motif, not its hue.
 *
 * Every picture is rendered by tools/team-art.mjs and every slot prefers a
 * photograph from assets/img/team/photo/ the moment one lands.
 */

declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/config.php';

$svc = service('dedicated-engineering-team');

$page      = 'services';
$pageTitle = 'Hire a Dedicated Engineering Team in Chennai';
$pageDesc  = 'iThrive Software embeds senior engineers into your workflow — your roadmap, your '
           . 'repository, your standards, and a team you can scale up or down without a hiring cycle.';
$ogImage   = 'service-' . $svc['group_slug'];

/* ---------------------------------------------------------------------------
 * Content
 * ------------------------------------------------------------------------ */

$stats = [
    ['6+',   'Years placing engineering teams'],
    ['90%',  'Of clients extend the engagement'],
    ['70%',  'Less than a local senior hire'],
    ['2wk',  'From call to team in your standup'],
];

/** Why build alone — four. */
$why = [
    ['01', 'Seniors, not learners',
     'Seven to twelve years each. People who have already made the expensive mistakes somewhere else and will not be making them on your product.'],
    ['02', 'Shorter release cycles',
     'A team that adopts your cadence rather than importing its own. Agile in the sense of shipping fortnightly, not in the sense of a certificate.'],
    ['03', 'You keep the wheel',
     'You set the roadmap and the priorities. We supply the people, the standards and complete visibility of what they are doing with your time.'],
    ['04', 'Scale without a hiring cycle',
     'Add two engineers for a quarter, drop back after. No notice periods, no severance, no eighteen-month commitment for eight weeks of work.'],
];

/** The ten disciplines. */
$roles = [
    ['01', 'Front-end engineers',   'React and TypeScript to a design system, accessible and measured against a performance budget rather than a screenshot.'],
    ['02', 'Back-end engineers',    'Python, Java and Go behind APIs that hold up — designed for the failure modes, not just the happy path.'],
    ['03', 'UI/UX designers',       'Research, wireframes and a system your engineers can actually build, handed over as components rather than pictures.'],
    ['04', 'Full-stack engineers',  'People who can carry a feature from schema to screen without three handovers and a week of waiting.'],
    ['05', 'QA engineers',          'Automation-first, in your pipeline. The point is catching it in CI, not filing it after a customer did.'],
    ['06', 'Data engineers',        'Pipelines, warehousing and the modelling underneath them, so the numbers a dashboard shows can be trusted.'],
    ['07', 'DevOps engineers',      'CI/CD, infrastructure as code and observability, with rollback rehearsed rather than assumed.'],
    ['08', 'AI engineers',          'Retrieval, agents and evaluation harnesses — the part that decides whether an AI feature survives contact with users.'],
    ['09', 'Business analysts',     'The person who works out what the requirement actually is before eight people build the wrong version of it.'],
    ['10', 'Delivery managers',     'One person accountable for the cadence, the risks and the honest status — including when it is not good.'],
];

/** How the engagement runs — four steps. */
$steps = [
    ['01', 'Tell us the shape',
     'A call about the work, not a CV parade. What you are building, what your team already covers, and the gap you actually need filled.'],
    ['02', 'We assemble it',
     'Within about two weeks you meet named people with the skills the work needs — not a pool, not a promise, the individuals who will do it.'],
    ['03', 'They join your cadence',
     'Your standup, your board, your repository, your definition of done. They report the way your own engineers report.'],
    ['04', 'Scale as it changes',
     'Grow the team for a push, shrink it after. Thirty days\' notice either way and no penalty for being honest about what you need.'],
];

/** Five commitments. */
$proof = [
    ['Transparent pricing',      'A rate card, per role, per month. No margin hidden inside a blended day rate you cannot interrogate.'],
    ['Your cadence, not ours',   'We adopt your rituals and tooling. An embedded team that needs its own process is not embedded.'],
    ['People in weeks',          'Roughly two weeks from the call to somebody in your standup, because the bench is real rather than aspirational.'],
    ['The whole discipline',     'Ten roles from one place, so the gap you find in month three does not start a new procurement.'],
    ['Everything is yours',      'Repository, infrastructure and documentation in your accounts from day one. Nothing to extract if we part ways.'],
];

/** Hiring models — three. */
$models = [
    ['01', 'Fixed cost',
     'A defined scope, a fixed price and a date. Right when the requirement is genuinely settled and you want the risk on our side of the table.',
     ['Defined scope', 'Fixed price', 'Risk on us']],
    ['02', 'Time and materials',
     'You pay for the engineers you have, by the month, and change your mind as often as the product needs you to. Most engagements end up here.',
     ['Monthly', 'Scale freely', 'No fixed scope']],
    ['03', 'Hybrid',
     'A fixed-price core with a flexible team around it. The parts you are sure of are priced; the parts still moving are not forced to pretend.',
     ['Fixed core', 'Flexible edge', 'Predictable floor']],
];

$faqs = [
    ['What can your dedicated engineers actually do?',
     'The ten disciplines above, and they are staffed as a team rather than as individuals — a front-end engineer here comes with the back-end, QA and DevOps people who make their work shippable. Where we do not have the skill in-house we say so rather than putting a near-miss on the invoice.'],
    ['Can we scale the team up or down mid-project?',
     'Yes, on thirty days\' notice in either direction, and without a penalty. That flexibility is most of the reason to use an embedded team rather than hire — if changing your mind is expensive you have just bought the worst parts of both models.'],
    ['When is a dedicated team the wrong answer?',
     'When the work is genuinely finite and well specified — that is a fixed-price project, and we will tell you so. A dedicated team earns its keep when the roadmap is long enough that the context your engineers build up is worth more than the flexibility you give away.'],
    ['How does hiring actually work?',
     'A call, then a written proposal naming roles, rates and start dates. You interview the individuals if you want to; most clients interview the first two and stop. Nobody is billed before they are in your standup.'],
    ['Who manages them day to day?',
     'You do, on the work. We handle employment, performance, cover for leave and replacement if somebody is not right — and replacement is our cost, not yours. You should be directing engineers, not administering them.'],
];

$extraHead = '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>'
    . '<link rel="stylesheet" href="https://fonts.googleapis.com/css2?'
    . 'family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;600;700'
    . '&family=Space+Grotesk:wght@400;500;600;700&display=swap">'
    . '<link rel="stylesheet" href="' . e(asset('assets/css/team.css')) . '">';

require dirname(__DIR__) . '/includes/header.php';

/** Photograph first, drawn composition second — the site-wide convention. */
$img = static function (string $rel): string {
    [$set, $file] = explode('/', $rel, 2);
    $photo = 'assets/img/team/photo/' . $set . '-' . $file;

    return asset(is_file(ROOT_PATH . '/' . $photo) ? $photo : 'assets/img/team/' . $rel);
};

/** Absolute, for components that only accept an http(s) src. */
$imgAbs = static fn (string $rel): string => site_origin() . $img($rel);

/* This page's own Spline scene if one is set, otherwise the shared one. */
$splineScene = (defined('SPLINE_SCENE_TEAM') && SPLINE_SCENE_TEAM !== '')
    ? SPLINE_SCENE_TEAM
    : (defined('SPLINE_SCENE') ? SPLINE_SCENE : '');
?>

<div class="tm">

  <?php /* ---------------------------------------------------------------
           Hero — Spline if a scene exists, otherwise a draggable 3D arc
           --------------------------------------------------------------- */ ?>
  <section class="tm-hero">
    <div class="tm-shell tm-hero-grid">
      <div class="tm-hero-copy">
        <p class="tm-eyebrow"><span class="tm-seat" aria-hidden="true"></span>Dedicated Engineering Team · Chennai</p>

        <h1 class="tm-h1">
          Senior engineers, in your<br>
          standup <em>in two weeks</em>
        </h1>

        <p class="tm-lead">
          Not an agency at arm's length and not a CV pool. A named team of seven-to-twelve-year
          engineers who take your roadmap, your repository and your definition of done — and who you
          can grow or shrink on thirty days' notice as the work changes.
        </p>

        <div class="tm-actions">
          <button class="tm-btn tm-btn--primary" type="button"
                  data-modal-open data-modal-service="Dedicated Engineering Team">
            Get your team<?= icon('arrow') ?>
          </button>
          <a class="tm-btn tm-btn--ghost" href="#tm-roles">See the ten roles</a>
        </div>

        <ul class="tm-stats">
          <?php foreach ($stats as [$v, $l]): ?>
            <li><strong><?= e($v) ?></strong><span><?= e($l) ?></span></li>
          <?php endforeach; ?>
        </ul>
      </div>

      <div class="tm-hero-stage">
        <?php if ($splineScene !== ''): ?>
          <?php /* A published Spline scene takes the stage when one exists. */ ?>
          <div class="tm-spline-host">
            <spline-viewer url="<?= e($splineScene) ?>" loading-anim-type="none"
                           events-target="global" role="img"
                           aria-label="An interactive 3D scene of a distributed engineering team."></spline-viewer>
          </div>
          <script type="module"
                  src="https://unpkg.com/@splinetool/viewer@1.9.48/build/spline-viewer.js"
                  crossorigin="anonymous"></script>
        <?php else: ?>
          <?php /*
             The arc, positioned in CSS rather than by a script.

             This was Framer's Curved Gallery Arc, which drives its rotateY and
             translateZ from a requestAnimationFrame loop. That means the cards
             carry transform:none until the first frame runs — and measured on
             the page every one of the ten sat at exactly the same point, so the
             hero was an empty box. Its own component; not a props mistake.

             Here each card's angle is written into the markup as --i, and the
             transform is a plain CSS rule. It is laid out by the time the first
             pixel is painted, with or without an animation frame. Dragging adds
             rotation on top of that rather than being the only thing that
             creates it.
          */ ?>
          <div class="tm-arc" data-arc style="--n: <?= count($roles) ?>;">
            <div class="tm-arc-ring" data-arc-ring>
              <?php foreach ($roles as $i => [$n, $title]): ?>
                <figure class="tm-arc-card" style="--i: <?= $i ?>;">
                  <img src="<?= e($img('role/' . $n . '.jpg')) ?>" width="420" height="420"
                       alt="<?= e($title) ?>" loading="lazy" decoding="async">
                  <figcaption><span><?= e($n) ?></span><?= e($title) ?></figcaption>
                </figure>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endif; ?>
        <p class="tm-stage-hint">Drag the arc · the ten disciplines on the bench</p>
      </div>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           The opening argument
           --------------------------------------------------------------- */ ?>
  <section class="tm-sec tm-open">
    <div class="tm-shell tm-open-grid">
      <div>
        <p class="tm-eyebrow"><span class="tm-seat" aria-hidden="true"></span>How this works</p>
        <h2 class="tm-title">Tell us the shape of the gap.<br><em>We staff it, you steer it.</em></h2>
      </div>
      <div class="tm-open-copy">
        <p>
          Every product hits the same wall eventually: the roadmap is longer than the team. Hiring
          takes a quarter and commits you for years; an agency takes the work away and hands back
          something you did not watch being built. Neither is what you wanted.
        </p>
        <p>
          An embedded team is the third option. The engineers are ours to employ, cover and replace,
          and yours to direct — same standup, same board, same repository, same definition of done.
          You get the capacity without the hiring cycle and the visibility without the management
          overhead.
        </p>
      </div>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           Why build alone — Framer's Circle Expand Card, four of them
           --------------------------------------------------------------- */ ?>
  <section class="tm-sec tm-why">
    <div class="tm-shell">
      <div class="tm-head">
        <p class="tm-eyebrow"><span class="tm-seat" aria-hidden="true"></span>Why not alone</p>
        <h2 class="tm-title">Why build alone, when the<br>expertise is <em>a team away</em></h2>
        <p class="tm-sub">
          Cross-functional teams ship roughly two and a half times faster than the same people
          working in sequence. Hover a card — it opens from the circle.
        </p>
      </div>

      <div class="tm-why-grid">
        <?php foreach ($why as $i => [$n, $title, $body]): ?>
          <figure class="tm-why-card" data-reveal style="--d:<?= $i % 4 ?>">
            <div class="tm-why-host"
                 data-ok="circle-expand-card"
                 data-props='<?= e(json_encode([
                     'image'         => ['src' => $imgAbs('why/' . $n . '.jpg'), 'alt' => $title],
                     'category'      => $n,
                     'title'         => $title,
                     'layout'        => 'titleBottomLeft',
                     'overlay'       => 'rgba(8, 10, 16, 0.42)',
                     'cardRadius'    => '18px',
                     'padding'       => '22px',
                     'showTextMask'  => true,
                     'textMaskColor' => 'rgba(8, 10, 16, 0.5)',
                 ], JSON_THROW_ON_ERROR)) ?>'></div>
            <figcaption><?= e($body) ?></figcaption>
          </figure>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           The ten roles — Framer's Image Scroller, plus the list in words
           --------------------------------------------------------------- */ ?>
  <section class="tm-sec tm-roles" id="tm-roles">
    <div class="tm-shell">
      <div class="tm-head">
        <p class="tm-eyebrow"><span class="tm-seat" aria-hidden="true"></span>The bench</p>
        <h2 class="tm-title">From concept to completion:<br><em>ten disciplines</em>, one bench</h2>
        <p class="tm-sub">
          You rarely need one of these. You need four of them who have worked together before, which
          is the whole argument for taking a team rather than assembling one.
        </p>
      </div>
    </div>

    <div class="tm-scroller-host"
         data-ok="image-scroller"
         data-props='<?= e(json_encode([
             'items' => array_map(static fn (array $r): array => [
                 'image' => ['src' => $imgAbs('role/' . $r[0] . '.jpg'), 'alt' => $r[1]],
                 'text'  => $r[1],
             ], $roles),
         ], JSON_THROW_ON_ERROR)) ?>'></div>

    <div class="tm-shell">
      <dl class="tm-role-list">
        <?php foreach ($roles as [$n, $title, $body]): ?>
          <div class="tm-role-row">
            <dt><span class="tm-role-num"><?= e($n) ?></span><?= e($title) ?></dt>
            <dd><?= e($body) ?></dd>
          </div>
        <?php endforeach; ?>
      </dl>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           Band — Framer's Gradient Bars behind it
           --------------------------------------------------------------- */ ?>
  <section class="tm-band">
    <div class="tm-band-bg" aria-hidden="true"
         data-ok="g-bars"
         data-props='<?= e(json_encode([
             'numBars'   => 34,
             'barWidth'  => 3,
             'barHeight' => 240,
         ], JSON_THROW_ON_ERROR)) ?>'></div>

    <div class="tm-shell tm-band-inner">
      <h2>Your product and our engineers.<br><em>One team, one board.</em></h2>
      <button class="tm-btn tm-btn--primary" type="button"
              data-modal-open data-modal-service="Dedicated Engineering Team">
        Show me how<?= icon('arrow') ?>
      </button>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           The four steps — Framer's Sticky Scroll Story
           --------------------------------------------------------------- */ ?>
  <section class="tm-sec tm-process">
    <div class="tm-shell">
      <div class="tm-head">
        <p class="tm-eyebrow"><span class="tm-seat" aria-hidden="true"></span>The engagement</p>
        <h2 class="tm-title">Where collaboration meets<br><em>a bench that is already there</em></h2>
      </div>
    </div>

    <div class="tm-story-host"
         data-ok="sticky-scroll-story"
         data-props='<?= e(json_encode([
             'texts' => array_map(
                 static fn (array $s): string => $s[0] . ' — ' . $s[1] . '. ' . $s[2],
                 $steps
             ),
             'font'  => ['fontSize' => '1.5rem', 'fontWeight' => 600, 'lineHeight' => '1.5em'],
         ], JSON_THROW_ON_ERROR)) ?>'>
      <?php /* The same four steps in plain markup, so the section is complete
               before the island mounts and for anything that never runs it. */ ?>
      <ol class="tm-step-fallback">
        <?php foreach ($steps as [$n, $t, $b]): ?>
          <li><strong><?= e($n) ?> · <?= e($t) ?></strong><span><?= e($b) ?></span></li>
        <?php endforeach; ?>
      </ol>
    </div>

    <div class="tm-shell tm-process-cta">
      <button class="tm-btn tm-btn--ghost" type="button"
              data-modal-open data-modal-service="Dedicated Engineering Team">
        Schedule a call<?= icon('arrow') ?>
      </button>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           Five commitments — Framer's Apple Glass Stack
           --------------------------------------------------------------- */ ?>
  <section class="tm-sec tm-proof">
    <div class="tm-shell">
      <div class="tm-head tm-head--mid">
        <p class="tm-eyebrow"><span class="tm-seat" aria-hidden="true"></span>What you can hold us to</p>
        <h2 class="tm-title">Fifty-plus teams have run<br>this <em>arrangement with us</em></h2>
        <p class="tm-sub">
          Six years, a hundred-odd projects, and the same five commitments in every contract —
          not because they are impressive, but because they are the things that go wrong.
        </p>
      </div>

      <?php /* The glass stack, given the props it actually needs.
               First pass passed only title and body and left it in a 320px
               box, so it laid five long items out in a ROW and clipped them —
               its own default is vertical and it has fonts, padding and colour
               of its own that were all sitting at Framer's defaults against
               this page's dark ground. */ ?>
      <div class="tm-glass-host"
           data-ok="glass-stack"
           data-props='<?= e(json_encode([
               'items' => array_map(static fn (array $p, int $i): array => [
                   'title'           => $p[0],
                   'body'            => $p[1],
                   'backgroundImage' => ['src' => $imgAbs('proof/' . str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT) . '.jpg'), 'alt' => $p[0]],
               ], $proof, array_keys($proof)),
               'direction'        => 'vertical',
               'gap'              => 18,
               'containerPadding' => 0,
               'allowOverflow'    => false,
               'backgroundColor'  => 'rgba(255, 255, 255, 0.06)',
               'glassOpacity'     => 0.85,
               'borderRadius'     => 20,
               'padding'          => 34,
               'titleFont'        => ['fontSize' => '24px', 'fontWeight' => 700, 'letterSpacing' => '-0.03em', 'lineHeight' => '1.2em'],
               'bodyFont'         => ['fontSize' => '15px', 'fontWeight' => 400, 'letterSpacing' => '-0.005em', 'lineHeight' => '1.65em'],
               'titleColor'       => '#EAF0FA',
               'bodyColor'        => '#9AA7BD',
           ], JSON_THROW_ON_ERROR)) ?>'>
        <ul class="tm-proof-fallback">
          <?php foreach ($proof as [$t, $b]): ?>
            <li><strong><?= e($t) ?></strong><span><?= e($b) ?></span></li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           Hiring models — three, built here, flipping in 3D
           --------------------------------------------------------------- */ ?>
  <section class="tm-sec tm-models" data-models>
    <div class="tm-shell">
      <div class="tm-head">
        <p class="tm-eyebrow"><span class="tm-seat" aria-hidden="true"></span>Commercials</p>
        <h2 class="tm-title">Three ways to <em>buy the same team</em></h2>
        <p class="tm-sub">
          The engineers do not change between these; only who carries the risk of the scope moving.
          Click a card to turn it over.
        </p>
      </div>

      <div class="tm-model-grid">
        <?php foreach ($models as $i => [$n, $title, $body, $tags]): ?>
          <div class="tm-model" data-model role="button" tabindex="0"
               aria-pressed="false" style="--d:<?= $i ?>">
            <div class="tm-model-inner">
              <div class="tm-model-face tm-model-front">
                <figure class="tm-model-art">
                  <img src="<?= e($img('model/' . $n . '.jpg')) ?>" width="800" height="600"
                       alt="" loading="lazy" decoding="async">
                </figure>
                <span class="tm-model-num"><?= e($n) ?></span>
                <h3><?= e($title) ?></h3>
                <p class="tm-model-turn">Turn it over<?= icon('arrow') ?></p>
              </div>
              <div class="tm-model-face tm-model-back">
                <h3><?= e($title) ?></h3>
                <p><?= e($body) ?></p>
                <ul class="tm-tags">
                  <?php foreach ($tags as $t): ?><li><?= e($t) ?></li><?php endforeach; ?>
                </ul>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           FAQ
           --------------------------------------------------------------- */ ?>
  <section class="tm-sec tm-faq">
    <div class="tm-shell tm-faq-grid">
      <div class="tm-faq-side">
        <p class="tm-eyebrow"><span class="tm-seat" aria-hidden="true"></span>FAQ</p>
        <h2 class="tm-title">What people ask<br>before they <em>commit</em></h2>
        <figure class="tm-faq-art">
          <img src="<?= e($img('faq/01.jpg')) ?>" width="800" height="600"
               alt="" loading="lazy" decoding="async">
        </figure>
      </div>

      <div class="tm-faq-list">
        <?php foreach ($faqs as $i => [$q, $a]): ?>
          <details class="tm-faq-item"<?= $i === 0 ? ' open' : '' ?>>
            <summary><?= e($q) ?><span class="tm-faq-mark" aria-hidden="true"></span></summary>
            <div class="tm-faq-body"><p><?= e($a) ?></p></div>
          </details>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           Close — Framer's Ambient Background drifting under it
           --------------------------------------------------------------- */ ?>
  <section class="tm-close">
    <div class="tm-close-bg" aria-hidden="true"
         data-ok="ambient-background"
         data-props='<?= e(json_encode([
             'baseColor'       => 'rgba(0, 0, 0, 0)',
             'color1'          => 'rgba(0, 242, 254, 0.18)',
             'color2'          => 'rgba(78, 168, 255, 0.16)',
             'color3'          => 'rgba(157, 78, 221, 0.18)',
             'blurAmount'      => 90,
             'speedMultiplier' => 0.45,
         ], JSON_THROW_ON_ERROR)) ?>'></div>

    <div class="tm-shell">
      <p class="tm-eyebrow"><span class="tm-seat" aria-hidden="true"></span>Next step</p>
      <h2>Consistency you can count on.<br><em>A team that stops feeling outsourced.</em></h2>
      <p class="tm-close-lead">
        Tell us what your roadmap needs and which parts your own team already covers. If an embedded
        team is the right instrument you will have named people and a rate card within a week. If it
        is not, we will say which of the other two you actually want.
      </p>
      <div class="tm-actions tm-actions--mid">
        <button class="tm-btn tm-btn--primary" type="button"
                data-modal-open data-modal-service="Dedicated Engineering Team">
          Start the conversation<?= icon('arrow') ?>
        </button>
      </div>
    </div>
  </section>

</div>

<?php /* The island that carries the Framer components — all seven on this page
         are mounted here for the first time on the site. */ ?>
<script type="module" src="<?= e(asset('assets/dist/originkit/originkit.js')) ?>"></script>

<?php /* This page's own behaviour: the three flipping model cards. */ ?>
<script src="<?= e(asset('assets/js/team-page.js')) ?>" defer></script>

<?php
require dirname(__DIR__) . '/includes/footer.php';
