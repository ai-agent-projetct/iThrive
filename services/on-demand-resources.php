<?php
/**
 * On-Demand Resources — the fifth service page off the shared layout.
 *
 * Built after absoluteapplabs.com/hire-dedicated-developers-in-chennai, section
 * for section, in iThrive's own words.
 *
 * The no-repeat rule still holds. Every Framer component here is mounted for
 * the first time on this site; across the five bespoke pages there are now
 * twenty-nine of them and not one appears on two pages.
 *
 *   hero      Interactive Book     a real 3D book you open and turn
 *   roles     Image Hover Reveal   one picture revealing another under the cursor
 *   band      Dot Grid BG          a dot field behind the quote
 *   benefits  Bento Gallery        five benefits in a bento grid
 *   steps     Motion Gallery       the five steps of engaging us
 *   close     WebGL Water Ripples  the last word under moving water
 *
 * Two of those draw inside requestAnimationFrame and paint nothing before the
 * first frame — the book and the ripple. Both therefore carry the poster from
 * assets/js/webgl-poster.js, which is what stopped the PoC and ReactJS heroes
 * being empty rectangles on a tab that never got a frame.
 *
 * Theme: the site's own ramp, unchanged. The Dedicated Team page tried a colour
 * of its own and it stopped looking like the same website; what separates the
 * five pages is layout, components and motif. This one's motif is AVAILABILITY
 * — signal bars, pulse marks and a capacity rule.
 *
 * Every picture is rendered by tools/ondemand-art.mjs and every slot prefers a
 * photograph from assets/img/ondemand/photo/ the moment one lands.
 */

declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/config.php';

$svc = service('on-demand-resources');

$page      = 'services';
$pageTitle = 'Hire Dedicated Developers in Chennai | On-Demand Engineering';
$pageDesc  = 'iThrive Software supplies senior developers on demand — one engineer or a squad, '
           . 'inside your workflow, billed monthly and scalable on thirty days\' notice.';
$ogImage   = 'service-' . $svc['group_slug'];

/* ---------------------------------------------------------------------------
 * Content
 * ------------------------------------------------------------------------ */

/** The hero book's pages. */
$book = [
    ['01', 'Peak weeks, covered'],
    ['02', 'One engineer or a squad'],
    ['03', 'Inside your workflow'],
    ['04', 'Billed by the month'],
    ['05', 'Thirty days either way'],
    ['06', 'Your repository, always'],
];

$stats = [
    ['48h',  'To a shortlist of named people'],
    ['5',    'Disciplines on the bench'],
    ['30d',  'Notice, up or down'],
    ['100%', 'Code in your accounts'],
];

/** The five disciplines you can take. */
$roles = [
    ['01', 'Mobile app developers',
     'Native and Flutter, shipping to both stores. People who have already argued with App Review and won.'],
    ['02', 'Full-stack developers',
     'Schema to screen without a handover. The right choice when the gap is throughput rather than a specialism.'],
    ['03', 'Front-end developers',
     'React and TypeScript against a design system, measured on Core Web Vitals rather than on a screenshot.'],
    ['04', 'Back-end developers',
     'Python, Node and Go behind APIs designed for their failure modes, not only the happy path.'],
    ['05', 'E-commerce developers',
     'Storefronts, checkout and payment integrations, where a hundred milliseconds is measurable in revenue.'],
];

/** Why take people on demand — five. */
$benefits = [
    ['01', 'Experience you are not paying to grow',
     'Seven years minimum. The learning happened on somebody else\'s product.'],
    ['02', 'Your own team stays on the core',
     'The work that only your people can do stays with your people. The rest comes from here.'],
    ['03', 'Peaks stop becoming slippage',
     'A quarter of extra capacity for a quarter, rather than a permanent hire for a temporary problem.'],
    ['04', 'Skills you cannot justify full time',
     'You need a payments specialist for six weeks a year. Hiring one is absurd; borrowing one is not.'],
    ['05', 'A bench, not a job advert',
     'Named people in about forty-eight hours, against a hiring cycle measured in months.'],
];

/** How engaging us works — five steps. */
$steps = [
    ['01', 'Consultation',
     'A call about the work. What you are building, what your team already covers, and where the gap actually is.'],
    ['02', 'Estimate',
     'Roles, rates, start dates and the scope as we understand it, in writing, before anyone is committed.'],
    ['03', 'Pick the model',
     'Fixed cost, monthly, or a hybrid of the two. The engineers do not change; only who carries the risk.'],
    ['04', 'Meet the people',
     'Named individuals, not a pool. Interview them if you want to — most clients stop after the second.'],
    ['05', 'They start',
     'Into your standup, your board and your repository. Billing begins the day they do, not before.'],
];

/** Hiring models — three. */
$models = [
    ['01', 'Fixed cost',
     'A settled scope, a fixed price, a date. The right answer when the requirement genuinely is not moving.',
     ['Settled scope', 'Fixed price', 'Risk on us']],
    ['02', 'Monthly per engineer',
     'You pay for who you have, by the month, and change your mind as often as the product needs. Most land here.',
     ['Per person', 'Scale freely', 'No fixed scope']],
    ['03', 'Hybrid',
     'A priced core with a flexible team around it — the parts you are sure of costed, the parts still moving not forced to pretend.',
     ['Priced core', 'Flexible edge', 'Predictable floor']],
];

/** Six reasons — the advantage. */
$advantage = [
    ['01', 'We look for the angle',
     'A brief is a starting point, not a checklist. If there is a cheaper way to get the same outcome you will hear it before we quote for the expensive one.'],
    ['02', 'Depth where it gets hard',
     'Modern frameworks are the easy part. What you are buying is the judgement that shows up when the requirement turns out to be more complicated than it looked.'],
    ['03', 'We fit your way of working',
     'Your rituals, your board, your tooling. An embedded engineer who needs their own process is not embedded, they are a subcontractor with extra steps.'],
    ['04', 'Control, amplified',
     'You direct the work and see everything: the same board, the same repository, the same standup. Nothing is reported to you second-hand.'],
    ['05', 'We ask what it is for',
     'Understanding why a thing is being built is what lets an engineer make the hundred small decisions a spec never covers.'],
    ['06', 'The bench keeps improving',
     'Internal review, shared standards and time to learn. You get the compounding of that without paying for the training budget.'],
];

$faqs = [
    ['What do we actually get by taking developers on demand?',
     'Capacity in about forty-eight hours instead of a hiring cycle, seniority you are not paying to develop, and the ability to change your mind — up or down on thirty days\' notice. What you give up is the permanence, which matters if the work is genuinely open-ended.'],
    ['How do we judge whether an engineer is any good?',
     'Interview them; we will not put a wall between you and the person doing the work. Beyond that, ask for a code review rather than a CV walk-through — an hour looking at how somebody reasons about a real change tells you more than any amount of talking about frameworks.'],
    ['What should we look for in the person?',
     'Less than you would think about the specific stack, and more about how they handle not knowing something. The frameworks change every three years; the habits of writing things down, asking early and being honest about status do not.'],
    ['When is this the wrong thing to buy?',
     'When the knowledge needs to stay in the building permanently, or when the work is one small well-specified piece — that is a fixed-price project. We would rather say so on the call than sell you a monthly engagement you will resent by month three.'],
];

$extraHead = '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>'
    . '<link rel="stylesheet" href="https://fonts.googleapis.com/css2?'
    . 'family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;600;700'
    . '&family=Space+Grotesk:wght@400;500;600;700&display=swap">'
    . '<link rel="stylesheet" href="' . e(asset('assets/css/ondemand.css')) . '">';

require dirname(__DIR__) . '/includes/header.php';

$img = static function (string $rel): string {
    [$set, $file] = explode('/', $rel, 2);
    $photo = 'assets/img/ondemand/photo/' . $set . '-' . $file;

    return asset(is_file(ROOT_PATH . '/' . $photo) ? $photo : 'assets/img/ondemand/' . $rel);
};

$imgAbs = static fn (string $rel): string => site_origin() . $img($rel);
?>

<div class="od">

  <?php /* ---------------------------------------------------------------
           Hero — a 3D book you open, with a poster until it draws
           --------------------------------------------------------------- */ ?>
  <section class="od-hero">
    <div class="od-shell od-hero-grid">
      <div class="od-hero-copy">
        <p class="od-eyebrow"><span class="od-pulse" aria-hidden="true"></span>On-Demand Engineering · Chennai</p>

        <h1 class="od-h1">
          Capacity when the roadmap<br>
          <em>outruns the team</em>
        </h1>

        <p class="od-lead">
          One engineer or a squad of five, from a bench that already exists — named people in about
          forty-eight hours, working inside your standup and your repository, billed by the month and
          scalable in either direction on thirty days' notice.
        </p>

        <div class="od-actions">
          <button class="od-btn od-btn--primary" type="button"
                  data-modal-open data-modal-service="On-Demand Resources">
            Connect with our team<?= icon('arrow') ?>
          </button>
          <a class="od-btn od-btn--ghost" href="#od-roles">See the five disciplines</a>
        </div>

        <ul class="od-stats">
          <?php foreach ($stats as [$v, $l]): ?>
            <li><strong><?= e($v) ?></strong><span><?= e($l) ?></span></li>
          <?php endforeach; ?>
        </ul>
      </div>

      <?php
      /*
       * The logo, as the hero.
       *
       * Three states, in order of preference:
       *
       *   1. assets/models/logo.glb  — the client's own Meshy export, loaded as
       *      a real 3D object that spins and drags. Drop the file in and this
       *      takes over with no edit here.
       *   2. Framer's Brush Reveal over a glass plate — the logo covered, and
       *      rubbed clear under the cursor. tools/logo-plate.mjs bakes that
       *      plate, glass and all, because Brush Reveal takes ONE image.
       *   3. The poster, if neither draws a frame.
       *
       * The glass is built rather than bought: Framer's Dynamic Glass Logo is
       * £-gated at $12 and publishes no module a third party can vendor, so the
       * plate reproduces the look it describes from our own mark. It is not
       * that component and does not claim to be.
       */
      $logoGlb = is_file(ROOT_PATH . '/assets/models/logo.glb')
          ? asset('assets/models/logo.glb')
          : null;
      ?>
      <div class="od-hero-stage">
        <div class="od-book-wrap"<?= $logoGlb !== null ? ' data-webgl-poster' : '' ?>>
          <?php if ($logoGlb !== null): ?>
            <div class="od-book-host" data-webgl-stage
                 data-ok="logo-3d"
                 data-props='<?= e(json_encode([
                     'src'  => $logoGlb,
                     'spin' => 14,
                     'tilt' => -0.18,
                 ], JSON_THROW_ON_ERROR)) ?>'></div>
          <?php endif; ?>

          <?php /*
             The plate IS the hero until the 3D model lands — not a poster.

             This ran Framer's Brush Reveal first: the logo under a cover you
             rub off with the cursor. The premise is wrong for a hero. Its
             canvas starts as a solid near-black rectangle and only clears as
             the reveal animates, so the first thing anyone saw was a black
             box, and on any tab that does not animate it stayed one. The
             poster could not save it either — once a canvas exists and has
             painted, handing over is exactly the wrong move when what the
             canvas is painting is the cover.

             So the logo is simply shown. When assets/models/logo.glb exists
             the 3D model takes the stage above this and this becomes its
             fallback, which is the arrangement that was wanted all along.
          */ ?>
          <div class="od-poster" aria-hidden="true">
            <img class="od-poster-logo" src="<?= e($img('logo/plate.jpg')) ?>"
                 width="1400" height="900" alt="<?= e(SITE_NAME) ?>" decoding="async">
          </div>
        </div>
        <p class="od-stage-hint">Drop assets/models/logo.glb in and this becomes the 3D mark</p>
      </div>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           The opening argument
           --------------------------------------------------------------- */ ?>
  <section class="od-sec od-open">
    <div class="od-shell od-open-grid">
      <div>
        <p class="od-eyebrow"><span class="od-pulse" aria-hidden="true"></span>Why this works</p>
        <h2 class="od-title">Fragmented delivery is usually<br>a <em>capacity problem</em></h2>
      </div>
      <div class="od-open-copy">
        <p>
          Most stalled roadmaps are not a skill problem. They are three people doing five people's work
          and context-switching between them, which produces the specific kind of slowness where
          everything is in progress and nothing is finished.
        </p>
        <p>
          Someone working only on your project changes that quickly — fewer handovers, faster fixes, a
          codebase that stops accumulating half-done branches. The difference shows up in a fortnight,
          which is roughly how long it takes to notice you should have done it sooner.
        </p>
      </div>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           The five disciplines — hover reveals the second picture
           --------------------------------------------------------------- */ ?>
  <section class="od-sec od-roles" id="od-roles">
    <div class="od-shell">
      <div class="od-head">
        <p class="od-eyebrow"><span class="od-pulse" aria-hidden="true"></span>The bench</p>
        <h2 class="od-title">Five disciplines you can<br>take <em>one at a time</em></h2>
        <p class="od-sub">
          Hover a card and the picture changes under the cursor. Most engagements start with one
          person and grow — which is the point of taking them this way rather than hiring.
        </p>
      </div>

      <div class="od-role-grid">
        <?php foreach ($roles as $i => [$n, $title, $body]): ?>
          <article class="od-role-card" data-reveal style="--d:<?= $i % 3 ?>">
            <div class="od-role-art"
                 data-ok="image-hover-reveal"
                 data-props='<?= e(json_encode([
                     'baseImageUrl'   => $imgAbs('role/' . $n . 'a.jpg'),
                     'revealImageUrl' => $imgAbs('role/' . $n . 'b.jpg'),
                 ], JSON_THROW_ON_ERROR)) ?>'>
              <noscript><img src="<?= e($img('role/' . $n . 'a.jpg')) ?>" width="600" height="600" alt=""></noscript>
            </div>
            <div class="od-role-body">
              <span class="od-num"><?= e($n) ?></span>
              <h3><?= e($title) ?></h3>
              <p><?= e($body) ?></p>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           Band — a dot field behind it
           --------------------------------------------------------------- */ ?>
  <section class="od-band">
    <div class="od-band-bg" aria-hidden="true"
         data-ok="dot-grid-bg"
         data-props='<?= e(json_encode([
             'dotColor' => 'rgba(0, 242, 254, 0.34)',
             'dotSize'  => 2,
         ], JSON_THROW_ON_ERROR)) ?>'></div>

    <div class="od-shell od-band-inner">
      <h2>Build the team that takes<br><em>your product further</em></h2>
      <button class="od-btn od-btn--primary" type="button"
              data-modal-open data-modal-service="On-Demand Resources">
        Hire dedicated developers<?= icon('arrow') ?>
      </button>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           Benefits — a bento grid, with the five in words beneath
           --------------------------------------------------------------- */ ?>
  <section class="od-sec od-benefits">
    <div class="od-shell">
      <div class="od-head">
        <p class="od-eyebrow"><span class="od-pulse" aria-hidden="true"></span>What it buys</p>
        <h2 class="od-title">Five things a dedicated<br>team <em>actually changes</em></h2>
      </div>

      <div class="od-bento-host"
           data-ok="bento-gallery"
           data-props='<?= e(json_encode([
               'images' => array_map(
                   static fn (array $b): array => ['src' => $imgAbs('benefit/' . $b[0] . '.jpg'), 'alt' => $b[1]],
                   $benefits
               ),
           ], JSON_THROW_ON_ERROR)) ?>'></div>

      <dl class="od-benefit-list">
        <?php foreach ($benefits as [$n, $title, $body]): ?>
          <div class="od-benefit-row">
            <dt><span class="od-num"><?= e($n) ?></span><?= e($title) ?></dt>
            <dd><?= e($body) ?></dd>
          </div>
        <?php endforeach; ?>
      </dl>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           The five steps — Motion Gallery, and the steps in words
           --------------------------------------------------------------- */ ?>
  <section class="od-sec od-steps">
    <div class="od-shell">
      <div class="od-head od-head--mid">
        <p class="od-eyebrow"><span class="od-pulse" aria-hidden="true"></span>How it runs</p>
        <h2 class="od-title">Hiring from us is <em>five steps</em></h2>
      </div>
    </div>

    <div class="od-motion-host"
         data-ok="motion-gallery"
         data-props='<?= e(json_encode(array_merge(
             ['numImages' => count($steps)],
             array_reduce(
                 array_keys($steps),
                 static function (array $carry, int $i) use ($steps, $imgAbs): array {
                     $carry['image' . ($i + 1)] = ['src' => $imgAbs('step/' . $steps[$i][0] . '.jpg'), 'alt' => $steps[$i][1]];

                     return $carry;
                 },
                 []
             )
         ), JSON_THROW_ON_ERROR)) ?>'></div>

    <div class="od-shell">
      <ol class="od-step-list">
        <?php foreach ($steps as [$n, $title, $body]): ?>
          <li>
            <span class="od-step-num"><?= e($n) ?></span>
            <strong><?= e($title) ?></strong>
            <span class="od-step-body"><?= e($body) ?></span>
          </li>
        <?php endforeach; ?>
      </ol>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           Hiring models — three, tilting to the pointer
           --------------------------------------------------------------- */ ?>
  <section class="od-sec od-models" data-models>
    <div class="od-shell">
      <div class="od-head">
        <p class="od-eyebrow"><span class="od-pulse" aria-hidden="true"></span>Commercials</p>
        <h2 class="od-title">Three ways to buy<br>the <em>same engineers</em></h2>
        <p class="od-sub">
          The people do not change between these. Only who carries the risk of the scope moving does.
        </p>
      </div>

      <div class="od-model-grid">
        <?php foreach ($models as $i => [$n, $title, $body, $tags]): ?>
          <article class="od-model" data-model style="--d:<?= $i ?>">
            <figure class="od-model-art">
              <img src="<?= e($img('model/' . $n . '.jpg')) ?>" width="800" height="600"
                   alt="" loading="lazy" decoding="async">
            </figure>
            <div class="od-model-body">
              <span class="od-num"><?= e($n) ?></span>
              <h3><?= e($title) ?></h3>
              <p><?= e($body) ?></p>
              <ul class="od-tags">
                <?php foreach ($tags as $t): ?><li><?= e($t) ?></li><?php endforeach; ?>
              </ul>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           Mid CTA
           --------------------------------------------------------------- */ ?>
  <section class="od-midcta">
    <div class="od-shell">
      <h2>Let your ideas meet people<br><em>who can actually build them</em></h2>
      <button class="od-btn od-btn--primary" type="button"
              data-modal-open data-modal-service="On-Demand Resources">
        Talk with our resources<?= icon('arrow') ?>
      </button>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           Six reasons
           --------------------------------------------------------------- */ ?>
  <section class="od-sec od-advantage">
    <div class="od-shell">
      <div class="od-head">
        <p class="od-eyebrow"><span class="od-pulse" aria-hidden="true"></span>The advantage</p>
        <h2 class="od-title">Six reasons teams keep<br>the <em>engineers they borrowed</em></h2>
      </div>

      <div class="od-adv-grid">
        <?php foreach ($advantage as $i => [$n, $title, $body]): ?>
          <article class="od-adv-card" data-reveal style="--d:<?= $i % 3 ?>">
            <figure class="od-adv-art">
              <img src="<?= e($img('adv/' . $n . '.jpg')) ?>" width="800" height="500"
                   alt="" loading="lazy" decoding="async">
            </figure>
            <span class="od-num"><?= e($n) ?></span>
            <h3><?= e($title) ?></h3>
            <p><?= e($body) ?></p>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           FAQ
           --------------------------------------------------------------- */ ?>
  <section class="od-sec od-faq">
    <div class="od-shell od-faq-grid">
      <div class="od-faq-side">
        <p class="od-eyebrow"><span class="od-pulse" aria-hidden="true"></span>FAQ</p>
        <h2 class="od-title">What teams ask<br>before <em>borrowing people</em></h2>
        <figure class="od-faq-art">
          <img src="<?= e($img('faq/01.jpg')) ?>" width="800" height="600"
               alt="" loading="lazy" decoding="async">
        </figure>
      </div>

      <div class="od-faq-list">
        <?php foreach ($faqs as $i => [$q, $a]): ?>
          <details class="od-faq-item"<?= $i === 0 ? ' open' : '' ?>>
            <summary><?= e($q) ?><span class="od-faq-mark" aria-hidden="true"></span></summary>
            <div class="od-faq-body"><p><?= e($a) ?></p></div>
          </details>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           Close — under moving water, with a poster until it draws
           --------------------------------------------------------------- */ ?>
  <section class="od-close">
    <div class="od-close-wrap" data-webgl-poster>
      <div class="od-close-bg" data-webgl-stage aria-hidden="true"
           data-ok="ripple"
           data-props='<?= e(json_encode([
               'image'     => $imgAbs('close/01.jpg'),
               'intensity' => 0.35,
           ], JSON_THROW_ON_ERROR)) ?>'></div>
      <?php /* Flat, until the ripple has actually drawn a frame. */ ?>
      <div class="od-close-poster od-poster" aria-hidden="true"></div>
    </div>

    <div class="od-shell od-close-copy">
      <p class="od-eyebrow"><span class="od-pulse" aria-hidden="true"></span>Next step</p>
      <h2>Got a product ready for<br><em>its next step?</em></h2>
      <p class="od-close-lead">
        Tell us what the roadmap needs and what your own team already covers. If borrowing people is
        the right instrument you will have named engineers and a rate card inside a week — and if it
        is not, we will say which of the other two you actually want.
      </p>
      <div class="od-actions od-actions--mid">
        <button class="od-btn od-btn--primary" type="button"
                data-modal-open data-modal-service="On-Demand Resources">
          Hire our developers<?= icon('arrow') ?>
        </button>
      </div>
    </div>
  </section>

</div>

<script type="module" src="<?= e(asset('assets/dist/originkit/originkit.js')) ?>"></script>
<script src="<?= e(asset('assets/js/ondemand-page.js')) ?>" defer></script>
<script src="<?= e(asset('assets/js/webgl-poster.js')) ?>" defer></script>

<?php
require dirname(__DIR__) . '/includes/footer.php';
