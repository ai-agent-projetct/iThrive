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
$pageTitle = 'Hire Dedicated Developers in India';
$pageDesc  = 'Senior developers on demand — one engineer or a squad, inside your workflow, billed monthly and scalable on thirty days\\\' notice. Chennai and Coimbatore.';
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

/** Sixteen reasons — the advantage. */
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
    ['07', 'Zero ramp-up tax',
     'Engineers hit the ground running with production setups on Day 1. No two-week wilderness wandering through undocumented dependencies.'],
    ['08', 'Seniority without headcount lock',
     'Principal-grade architecture chops during delivery crunches without permanent balance-sheet liabilities or long-term overhead.'],
    ['09', 'Timezone synchronization',
     'Engineers scheduled for complete overlap with your core team, agile standups, sprint plannings, and Slack / Teams channels.'],
    ['10', 'Clean code that your team owns',
     'Zero proprietary lock-in. Everything is linted, documented, and tested to your existing repository standards.'],
    ['11', 'Flexible scaling on 30 days\' notice',
     'Scale from one developer to five or wind down smoothly with zero severance friction and complete contractual clarity.'],
    ['12', 'Real-world battle testing',
     'Our engineers have navigated App Store reviews, Black Friday traffic spikes, and high-concurrency cloud migrations.'],
    ['13', 'Rigorous security by default',
     'OWASP principles, zero-trust secrets management, and automated sanitization built directly into every pull request.'],
    ['14', 'Continuous peer backup',
     'Every embedded engineer is backed by our internal domain leads, unblocking architectural edge cases in hours rather than days.'],
    ['15', 'Direct communication',
     'Direct conversations with the engineer writing your code in standups and pair reviews. No intermediaries or account managers.'],
    ['16', 'Relentless delivery velocity',
     'A dependable cadence of working software shipped every sprint, turning stalled roadmaps into closed pull requests.'],
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
           Hero — full page, with a shape trail under the pointer

           After Framer's TrailShapes ($10, no module a third party can vendor),
           built from its live demo at trailshapes.framer.website rather than
           from the listing: the demo spawns SVG shapes that follow the cursor
           and fade, and that is what this does.

           Built on CSS animations rather than a rAF loop, deliberately. Every
           WebGL and rAF component on this site has at some point rendered a
           blank rectangle on a tab that never got a frame; a CSS animation
           runs off the compositor and a shape that never animates is still a
           shape. The hero also reads completely with no script at all.
           --------------------------------------------------------------- */ ?>
  <section class="od-hero" data-trail>
    <div class="od-trail-layer" data-trail-layer aria-hidden="true"></div>

    <div class="od-shell od-hero-inner">
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

      <div class="od-actions od-actions--mid">
        <button class="od-btn od-btn--primary" type="button"
                data-modal-open data-modal-service="On-Demand Resources">
          Connect with our team<?= icon('arrow') ?>
        </button>
        <a class="od-btn od-btn--ghost" href="#od-roles">See the five disciplines</a>
      </div>

      <?php /*
         WebGPU Volumetric Light Flare with iThrive Logo & 5-color light cycle
         Adapted from Next.js Flare (vgpu.sh/preview/nextjs-flare)
      */ ?>
      <div class="od-flare-host"
           data-ok="nextjs-flare"
           data-props='<?= e(json_encode([
               'beamIntensity' => 1.15,
               'spotFocus'     => 0.35,
               'extension'     => 0.60,
               'scatter'       => 1.0,
               'rimIntensity'  => 1.2,
           ], JSON_THROW_ON_ERROR)) ?>'></div>

      <ul class="od-stats od-stats--mid">
        <?php foreach ($stats as [$v, $l]): ?>
          <li><strong><?= e($v) ?></strong><span><?= e($l) ?></span></li>
        <?php endforeach; ?>
      </ul>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           The opening argument
           --------------------------------------------------------------- */ ?>
  <section class="od-sec od-open">
    <div class="od-shell">
      <div class="od-open-grid">
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

      <div class="od-open-art" style="margin-top: clamp(28px, 4vw, 44px); border-radius: 20px; overflow: hidden; border: 1px solid rgba(0, 242, 254, 0.22); box-shadow: 0 20px 60px rgba(0, 0, 0, 0.6); position: relative;">
        <img src="<?= e($img('open/01.jpg')) ?>" width="1200" height="600"
             alt="Engineers resolving delivery bottlenecks" loading="lazy" decoding="async"
             style="width: 100%; height: auto; max-height: 480px; object-fit: cover; display: block;">
        <div style="position: absolute; inset: 0; background: linear-gradient(180deg, rgba(6, 11, 24, 0.05) 50%, rgba(6, 11, 24, 0.85) 100%); pointer-events: none;"></div>
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
          Energy Beam Flare: Volumetric suction flare & particle aura. Select any discipline to align the energy beam and explore full-stack capabilities.
        </p>
      </div>

      <div class="od-beam-host"
           data-ok="energy-beam-disciplines"
           data-props='<?= e(json_encode([
               'disciplines' => array_map(function($r) use ($img) {
                   $colors = ['#00F2FE', '#38BDF8', '#6366F1', '#9D4EDD', '#EC4899'];
                   $rgbs = [
                       [0.00, 0.949, 0.996],
                       [0.22, 0.741, 0.973],
                       [0.388, 0.400, 0.945],
                       [0.616, 0.306, 0.867],
                       [0.925, 0.282, 0.600]
                   ];
                   $taglines = [
                       'Architecture through UI',
                       'Native-grade mobile UX',
                       'Pixel-perfect, Web Vitals first',
                       'Fault-tolerant distributed systems',
                       'High-conversion storefronts'
                   ];
                   $tagList = [
                       ['Next.js', 'React', 'Node.js', 'PostgreSQL', 'GraphQL'],
                       ['Flutter', 'React Native', 'Swift', 'Kotlin', 'SQLite'],
                       ['React', 'TypeScript', 'Tailwind', 'Design Systems', 'Web Vitals'],
                       ['Python', 'Go', 'FastAPI', 'Redis', 'Docker', 'Kafka'],
                       ['Shopify Plus', 'Stripe', 'Headless', 'Medusa', 'Next Commerce']
                   ];
                   $idx = ((int)$r[0] - 1) % 5;
                   return [
                       'num'     => $r[0],
                       'title'   => $r[1],
                       'tagline' => $taglines[$idx],
                       'desc'    => $r[2],
                       'tags'    => $tagList[$idx],
                       'image'   => $img('role/' . $r[0] . 'a.jpg'),
                       'color'   => $colors[$idx],
                       'rgb'     => $rgbs[$idx],
                   ];
               }, $roles)
           ], JSON_THROW_ON_ERROR)) ?>'>
      </div>

      <div class="sr-only">
        <?php foreach ($roles as [$n, $title, $body]): ?>
          <article>
            <span><?= e($n) ?></span>
            <h3><?= e($title) ?></h3>
            <p><?= e($body) ?></p>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           Band — a dot field behind it
           --------------------------------------------------------------- */ ?>
  <section class="od-band">
    <div class="od-band-bg" aria-hidden="true"></div>
    <div class="od-band-backdrop" style="position: absolute; inset: 0; z-index: 0; overflow: hidden; pointer-events: none;">
      <img src="<?= e($img('band/01.jpg')) ?>" width="1600" height="600" alt=""
           style="width: 100%; height: 100%; object-fit: cover; opacity: 0.18; filter: saturate(1.2) contrast(1.15);">
      <div style="position: absolute; inset: 0; background: linear-gradient(90deg, rgba(6, 11, 24, 0.95) 0%, rgba(6, 11, 24, 0.7) 50%, rgba(6, 11, 24, 0.95) 100%), linear-gradient(180deg, rgba(6, 11, 24, 0.9) 0%, transparent 40%, rgba(6, 11, 24, 0.9) 100%);"></div>
    </div>

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
        <p class="od-sub">
          Motion Layer Scroller: 3D isometric perspective layer stack. Wheel scroll or drag to explore how dedicated capacity transforms delivery.
        </p>
      </div>

      <div class="od-scroller-host"
           data-ok="motion-layer-scroller"
           data-props='<?= e(json_encode([
               'items' => array_map(function($b, $idx) use ($img) {
                   $colors = ['#00F2FE', '#38BDF8', '#6366F1', '#9D4EDD', '#EC4899'];
                   return [
                       'num'      => $b[0],
                       'title'    => $b[1],
                       'subtitle' => 'Engineering Advantage ' . $b[0],
                       'desc'     => $b[2],
                       'image'    => $img('benefit/' . $b[0] . '.jpg'),
                       'accent'   => $colors[$idx % 5],
                   ];
               }, $benefits, array_keys($benefits))
           ], JSON_THROW_ON_ERROR)) ?>'>
      </div>

      <dl class="sr-only">
        <?php foreach ($benefits as [$n, $title, $body]): ?>
          <div>
            <dt><?= e($n) ?>. <?= e($title) ?></dt>
            <dd><?= e($body) ?></dd>
          </div>
        <?php endforeach; ?>
      </dl>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           The five steps — Process Roadmap (Winding SVG Roadmap)
           --------------------------------------------------------------- */ ?>
  <div class="od-roadmap-mount"
       data-ok="process-roadmap"
       data-props='<?= e(json_encode([
           'stages' => array_map(function($s, $idx) use ($img) {
               $offsets = [0.08, 0.28, 0.48, 0.68, 0.88];
               $taglines = [
                   'Technical scope & bench alignment',
                   'Transparent rates & deliverables',
                   'Fixed, monthly or hybrid',
                   'Direct code & architecture interviews',
                   'Live in your repository & standups'
               ];
               $durations = ['48 Hours', '24 Hours', '1 Day', '2–3 Days', 'Day 1'];
               $deliverables = [
                   'Scoped engineer profile',
                   'Transparent rate card',
                   'Agreed engagement structure',
                   'Named engineer confirmation',
                   'Active commits & sprint delivery'
               ];
               return [
                   'num'      => $s[0],
                   'at'       => $offsets[$idx],
                   'side'     => $idx % 2 === 0 ? 'top' : 'bottom',
                   'title'    => $s[1],
                   'tagline'  => $taglines[$idx],
                   'desc'     => $s[2],
                   'duration' => $durations[$idx],
                   'out'      => $deliverables[$idx],
                   'image'    => $img('step/' . $s[0] . '.jpg'),
               ];
           }, $steps, array_keys($steps))
       ], JSON_THROW_ON_ERROR)) ?>'>
  </div>

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

      <div class="od-bookmark-models-host"
           data-ok="bookmark-models"
           data-props='<?= e(json_encode([
               'models' => array_map(function($m, $idx) use ($img) {
                   $tags = ['— DEDICATED TEAM®', '— VELOCITY POD®', '— FRACTIONAL SPECIALIST®'];
                   $subtitles = [
                       'Long-term velocity & roadmap ownership',
                       'Autonomous feature delivery squad',
                       'Specialist hours & architectural review'
                   ];
                   $accents = ['#00F2FE', '#9D4EDD', '#EC4899'];
                   $rgbs = ['0, 242, 254', '157, 78, 221', '236, 72, 153'];
                   $titles = ['Full Team.', 'Pod Model.', 'On-Demand.'];
                   $featureLists = [
                       [
                           '1 to 5 Senior Engineers (7+ yrs)',
                           'Monthly predictable billing',
                           'Scalable either direction in 30 days',
                           'Direct Slack, Jira & GitHub access'
                       ],
                       [
                           'Tech Lead + 2 Full-Stack Engineers',
                           'End-to-end feature ownership',
                           'Bi-weekly milestone commitments',
                           'Zero recruiter or placement fees'
                       ],
                       [
                           'Principal & Staff Architects',
                           '20 to 80 hours/month reserve',
                           'Critical code & security reviews',
                           'Available inside 48 hours notice'
                       ]
                   ];
                   return [
                       'id'        => 'model-' . $m[0],
                       'tag'       => $tags[$idx],
                       'title'     => $titles[$idx],
                       'subtitle'  => $subtitles[$idx],
                       'quote'     => $m[2],
                       'accent'    => $accents[$idx],
                       'accentRgb' => $rgbs[$idx],
                       'image'     => $img('model/' . $m[0] . '.jpg'),
                       'activeIndex' => $idx,
                       'features'  => $featureLists[$idx]
                   ];
               }, $models, array_keys($models))
           ], JSON_THROW_ON_ERROR)) ?>'>
      </div>

      <div class="sr-only">
        <?php foreach ($models as $i => [$n, $title, $body, $tags]): ?>
          <article>
            <span><?= e($n) ?></span>
            <h3><?= e($title) ?></h3>
            <p><?= e($body) ?></p>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           Tech Stack Dropzone — Matter.js physics pill spawner
           --------------------------------------------------------------- */ ?>
  <section class="od-sec od-dropzone-sec">
    <div class="od-shell">
      <div class="od-head od-head--mid">
        <p class="od-eyebrow"><span class="od-pulse" aria-hidden="true"></span>Engineering Bench</p>
        <h2 class="od-title">Production tech stacks<br><em>our engineers master</em></h2>
        <p class="od-sub">
          Interactive physics dropzone: click anywhere in the arena to drop new tech capsules, or drag and fling them across the floor.
        </p>
      </div>

      <div class="od-dropzone-host"
           data-ok="tech-dropzone"
           data-props='{"height": 520, "gravity": 1.1, "restitution": 0.62}'></div>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           Mid CTA
           --------------------------------------------------------------- */ ?>
  <section class="od-midcta" style="position: relative; overflow: hidden;">
    <div class="od-midcta-backdrop" style="position: absolute; inset: 0; z-index: 0; pointer-events: none;">
      <img src="<?= e($img('midcta/01.jpg')) ?>" width="1600" height="600" alt=""
           style="width: 100%; height: 100%; object-fit: cover; opacity: 0.16; filter: saturate(1.2) contrast(1.1);">
      <div style="position: absolute; inset: 0; background: linear-gradient(180deg, rgba(6, 11, 24, 0.92) 0%, rgba(6, 11, 24, 0.75) 50%, rgba(6, 11, 24, 0.92) 100%);"></div>
    </div>
    <div class="od-shell" style="position: relative; z-index: 1;">
      <h2>Let your ideas meet people<br><em>who can actually build them</em></h2>
      <button class="od-btn od-btn--primary" type="button"
              data-modal-open data-modal-service="On-Demand Resources">
        Talk with our resources<?= icon('arrow') ?>
      </button>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           Sixteen reasons — 3D Infinite Perspective Card Gallery
           --------------------------------------------------------------- */ ?>
  <section class="od-sec od-advantage">
    <div class="od-shell">
      <div class="od-head od-head--mid">
        <p class="od-eyebrow"><span class="od-pulse" aria-hidden="true"></span>The advantage</p>
        <h2 class="od-title">Sixteen reasons teams keep<br>the <em>engineers they borrowed</em></h2>
        <p class="od-sub">
          Dual 3D Perspective Gallery: Pan cursor for perspective tilt, hover to pause, or click any card to inspect all sixteen reasons engineering leaders retain iThrive teams sprint after sprint.
        </p>
      </div>

      <div class="od-perspective-gallery-host"
           data-ok="infinite-perspective-gallery"
           data-props='<?= e(json_encode([
               'images' => array_map(function($a) use ($img) {
                   return [
                       'num'   => $a[0],
                       'title' => $a[1],
                       'desc'  => $a[2],
                       'src'   => $img('adv/' . $a[0] . '.jpg'),
                   ];
               }, $advantage),
               'speed'                => 220,
               'autoplay'             => true,
               'pauseOnHover'         => true,
               'perspective'          => 1000,
               'parallaxEnabled'      => true,
               'parallaxAmount'       => 2.5,
               'spacing'              => 280,
               'cardWidth'            => 299,
               'cardHeight'           => 380,
               'railRotation'         => 70,
               'depthEffectIntensity' => 0.75,
               'maxBlur'              => 3.5,
               'farOpacity'           => 0.38,
               'tunnelFadeLength'     => 220,
               'nearScale'            => 1.08,
               'shadowIntensity'      => 1.0,
           ], JSON_THROW_ON_ERROR)) ?>'>
      </div>

      <div class="sr-only">
        <?php foreach ($advantage as [$n, $title, $body]): ?>
          <article>
            <span><?= e($n) ?></span>
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
    <?php /* A CSS wash. This was Framer's WebGL Water Ripples; with zero
             animation frames its context never drew, so the section closed on
             a flat rectangle. The picture underneath is real and the drift is
             a CSS animation, so both survive a tab that never animates. */ ?>
    <div class="od-close-wrap" aria-hidden="true">
      <img class="od-close-img" src="<?= e($img('close/01.jpg')) ?>"
           width="1600" height="700" alt="" loading="lazy" decoding="async">
      <div class="od-close-wash"></div>
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

<script type="module" src="<?= e(url('assets/dist/originkit/originkit.js')) ?>"></script>
<script src="<?= e(asset('assets/js/ondemand-page.js')) ?>" defer></script>
<script src="<?= e(asset('assets/js/webgl-poster.js')) ?>" defer></script>

<?php
require dirname(__DIR__) . '/includes/footer.php';
