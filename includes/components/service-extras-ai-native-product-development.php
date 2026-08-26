<?php
/**
 * Extra sections for the AI-Native Product Development page.
 *
 * Structure follows the brief: a 360° service ring, AI-first engineering, use
 * cases by industry behind tabs, the agile cadence, the stack, and the closing
 * claim. The copy is written for this site rather than lifted — the sections
 * and the technologies match, the sentences are ours, because publishing a
 * competitor's prose is both their copyright and a duplicate-content problem
 * on the page that is meant to rank.
 *
 * The template picks this file up automatically from its name; nothing is
 * registered anywhere and the other fourteen service pages are untouched.
 *
 * @var array $svc The service, from service().
 */

declare(strict_types=1);

/** The 360° ring — every stage of a product, in the order it happens. */
$stages = [
    ['icon' => 'lightbulb', 'title' => 'Product strategy and prototyping',
     'body' => 'We agree what is worth building before anyone writes code. Feature shaping, '
             . 'wireframes and a clickable prototype, so the idea is tested against real users '
             . 'while changing it still costs an afternoon.'],
    ['icon' => 'rocket', 'title' => 'MVP development',
     'body' => 'The smallest version that can earn a real opinion. We ship the features that '
             . 'carry the value first, put it in front of users, and let what comes back decide '
             . 'the next sprint rather than a roadmap written in month one.'],
    ['icon' => 'brain', 'title' => 'AI integration',
     'body' => 'Retrieval, predictions, agents and language interfaces built into the product '
             . 'itself. If the AI could be removed without anyone noticing, it was decoration — '
             . 'we build it where it does the work.'],
    ['icon' => 'smartphone', 'title' => 'Web and mobile app development',
     'body' => 'One product across browser and phone, on an architecture that survives the '
             . 'second year: typed APIs, a component library your team can extend, and page '
             . 'budgets we hold ourselves to.'],
    ['icon' => 'cloud', 'title' => 'Cloud and DevOps',
     'body' => 'Deployed on AWS, Google Cloud or Azure with containers, CI/CD and monitoring '
             . 'wired in from the first commit — so releasing is a routine Tuesday rather than '
             . 'an event someone has to be awake for.'],
    ['icon' => 'refresh', 'title' => 'Ongoing enhancement and maintenance',
     'body' => 'We stay after launch. New features, performance work, dependency upgrades and '
             . 'the unglamorous fixes that keep a product from quietly rotting into something '
             . 'nobody wants to touch.'],
];

/** What "AI-first" means in practice, rather than as a claim. */
$aiFirst = [
    ['icon' => 'trending-up', 'title' => 'Predictive analytics on user behaviour',
     'body' => 'Models that see churn, intent and demand coming while there is still time to act on them.'],
    ['icon' => 'message', 'title' => 'Chatbots and NLP for support',
     'body' => 'Assistants grounded in your own documentation, answering around the clock and escalating cleanly when they should.'],
    ['icon' => 'sparkles', 'title' => 'Recommendations and personalisation',
     'body' => 'Ranking tuned on your data, so what each person sees first is the thing most likely to be right for them.'],
    ['icon' => 'search', 'title' => 'Computer vision for image-based insight',
     'body' => 'Reading documents, inspecting products and classifying photographs at a volume nobody can staff for.'],
    ['icon' => 'workflow', 'title' => 'Workflow automation for internal tools',
     'body' => 'The repeated internal decisions — triage, routing, reconciliation — handled by an agent with an approval gate where it counts.'],
];

/**
 * Use cases behind tabs.
 *
 * Tabbed with radio inputs and CSS rather than JavaScript: it works before any
 * script runs, it is keyboard-operable and screen-reader-announced for free,
 * and it is a third of the code a hand-rolled tablist would be.
 */
$cases = [
    ['key' => 'retail', 'tab' => 'Retail', 'icon' => 'cart',
     'title' => 'A recommendation engine for your storefront',
     'body' => 'Product suggestions ranked on what each shopper has actually browsed, bought and '
             . 'abandoned, rather than on what is being promoted this week. It lifts basket size '
             . 'because it is right more often, not because it is louder.',
     'points' => ['Behavioural and session-based ranking', 'Cold-start handling for new catalogue items', 'Measured against a held-out control, not a dashboard']],

    ['key' => 'healthcare', 'tab' => 'Healthcare', 'icon' => 'stethoscope',
     'title' => 'A patient portal that predicts the no-shows',
     'body' => 'Scheduling, reminders and a triage assistant on call at three in the morning, with '
             . 'the appointments most likely to be missed flagged early enough to fill the slot. '
             . 'Access controls and audit trails are part of the build, not a later hardening pass.',
     'points' => ['No-show prediction feeding the reminder schedule', 'Conversational triage grounded in your protocols', 'Role-based access with a full audit trail']],

    ['key' => 'saas', 'tab' => 'SaaS / Enterprise', 'icon' => 'bar-chart',
     'title' => 'An analytics surface that answers questions',
     'body' => 'Dashboards people actually open, because they can ask in their own words and get a '
             . 'number with the query behind it. Forecasts and anomaly alerts sit alongside the '
             . 'reporting rather than in a separate tool nobody logs into.',
     'points' => ['Natural-language querying over your warehouse', 'Anomaly detection that pages someone', 'Every figure traceable to the query that produced it']],

    ['key' => 'logistics', 'tab' => 'Logistics', 'icon' => 'car',
     'title' => 'Route optimisation with honest ETAs',
     'body' => 'Sequencing that accounts for traffic, service time and driver hours, and arrival '
             . 'estimates that are updated as the day goes wrong. Fewer kilometres per drop, and '
             . 'a customer who is told the truth before they have to ring and ask.',
     'points' => ['Multi-stop sequencing under real constraints', 'Live ETAs that revise as conditions change', 'Cost per delivery tracked against the old plan']],
];

/** The cadence. Three habits, not a methodology diagram. */
$agile = [
    ['title' => 'A demo every two weeks',
     'body' => 'Working software on a call, not a status document. If a fortnight has passed with nothing to show, that is the thing worth discussing.'],
    ['title' => 'Sprints you can see into',
     'body' => 'The board is yours to read. What is in progress, what slipped and why, without waiting for a weekly summary to find out.'],
    ['title' => 'Feedback that changes the next sprint',
     'body' => 'What comes back from the demo is scoped into the sprint after it. That loop is the whole point of working this way.'],
];

/**
 * The stack.
 *
 * The brief's reference page names AWS, GCP, Azure, Docker, Kubernetes and
 * CI/CD inline and has no stack section of its own, so this is those, grouped
 * and completed with what an AI product actually needs around them. Marks come
 * from assets/img/tech, which already carries all of them.
 */
$stack = [
    ['title' => 'AI and machine learning', 'icon' => 'brain',
     'items' => ['python', 'pytorch', 'tensorflow', 'openai', 'langchain', 'scikitlearn', 'pandas']],
    ['title' => 'Cloud and DevOps', 'icon' => 'cloud',
     'items' => ['amazonwebservices', 'googlecloud', 'azure', 'docker', 'kubernetes', 'terraform', 'githubactions']],
    ['title' => 'Product and data layer', 'icon' => 'database',
     'items' => ['fastapi', 'django', 'postgresql', 'redis', 'celery', 'opensearch']],
    ['title' => 'Interfaces', 'icon' => 'monitor',
     'items' => ['react', 'nextdotjs', 'typescript', 'flutter', 'tailwindcss']],
];

/** Pretty names for the marks, which are filed under their Simple Icons slug. */
$techName = [
    'python' => 'Python', 'pytorch' => 'PyTorch', 'tensorflow' => 'TensorFlow',
    'openai' => 'OpenAI', 'langchain' => 'LangChain', 'scikitlearn' => 'scikit-learn',
    'pandas' => 'pandas', 'amazonwebservices' => 'AWS', 'googlecloud' => 'Google Cloud',
    'azure' => 'Azure', 'docker' => 'Docker', 'kubernetes' => 'Kubernetes',
    'terraform' => 'Terraform', 'githubactions' => 'GitHub Actions', 'fastapi' => 'FastAPI',
    'django' => 'Django', 'postgresql' => 'PostgreSQL', 'redis' => 'Redis',
    'celery' => 'Celery', 'opensearch' => 'OpenSearch', 'react' => 'React',
    'nextdotjs' => 'Next.js', 'typescript' => 'TypeScript', 'flutter' => 'Flutter',
    'tailwindcss' => 'Tailwind CSS',
];
?>

<?php
/*
 * Origin Kit's Stacked Carousel, standing where the capabilities grid used to.
 *
 * The registry's own source at the `custom-style` preset — 514x380 cards at
 * speed 80 — unmodified, in app/originkit. Only two props are passed:
 *
 *   images  the preset's are blob: URLs from originkit.dev, which resolve on
 *           that site and nowhere else. Props spread after the preset, so ours
 *           win. These are the six capability cards, in order — the same six
 *           the preset was built around. Everything else it sets is left alone.
 *   style   the component's host carries minWidth 1200 / minHeight 800, which
 *           would force the page wider than the viewport. `style` spreads last
 *           inside the component, so this is where that is undone.
 *   card    bigger than the preset's 514x380, and at the artwork's own 3:2
 *           rather than the preset's 1.35:1 — the cards were being stretched
 *           vertically, which on a picture that is mostly a dashboard shows as
 *           squashed type.
 *
 * The heading is real text above it. The cards carry their titles and copy in
 * the artwork, which a crawler cannot read, so the section says what it is
 * before the deck starts turning.
 */
$deckShots = [];
foreach (range(1, 6) as $n) {
    $file = 'assets/img/capabilities/cap-' . str_pad((string) $n, 2, '0', STR_PAD_LEFT) . '.jpg';
    if (is_file(ROOT_PATH . '/' . $file)) {
        $deckShots[] = asset($file);
    }
}

/*
 * Handed to the deck backwards, on purpose.
 *
 * A plane's z rises with its index and the camera looks down -z, so the higher
 * the index the nearer the card. Drifting forward, each card is followed by the
 * one with the next index DOWN — so the list is walked in reverse as the deck
 * passes you, and 01..06 arrives as 06..01. Reversing here puts them back in
 * order without touching the component, which is the registry's and should stay
 * byte-for-byte what it shipped.
 */
$deckShots = array_reverse($deckShots);
?>
<section class="section lz" data-stage>
  <div class="shell">
    <?php component('section-head', [
        'eyebrow' => 'What This Includes',
        'title'   => 'Capabilities you get, spelled out',
        'lead'    => 'No line item here is aspirational — each one is something we have '
                   . 'shipped on a platform that is live today.',
    ]); ?>
  </div>

  <div class="ok-deck" data-ok="stacked-carousel" aria-hidden="true"
       data-props='<?= e(json_encode([
           'images'     => $deckShots,
           'cardWidth'  => 780,
           'cardHeight' => 520,
           'style'      => ['minWidth' => 0, 'minHeight' => 0],
       ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)) ?>'></div>
</section>

<section class="section lz" data-stage>
  <?php /* The object field, after lusion.co: a cluster of tumbling solids that
           the scroll turns and the pointer pushes aside. Decorative, and the
           section reads exactly the same without it. */ ?>
  <div class="lz-field" data-object-field aria-hidden="true"></div>

  <div class="shell">
    <?php component('section-head', [
        'eyebrow' => 'End To End',
        'title'   => 'Our 360° product development services',
        'lead'    => 'One team across every stage of the product, from shaping the idea to keeping '
                   . 'it healthy in production — strategy, design, AI and engineering in a single '
                   . 'process rather than four handovers.',
        'art'     => 'sec-360',
    ]); ?>

    <div class="grid grid-3">
      <?php foreach ($stages as $i => $s): ?>
        <article class="card card--numbered" data-reveal style="--d:<?= $i % 3 ?>">
          <span class="card-num"><?= str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT) ?></span>
          <span class="card-icon"><?= icon($s['icon']) ?></span>
          <h3 class="card-title"><?= e($s['title']) ?></h3>
          <p class="card-body"><?= e($s['body']) ?></p>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section section--panel lz" data-stage>
  <div class="shell split">
    <div>
      <p class="eyebrow" data-reveal>AI-First Product Engineering</p>
      <h2 class="section-title section-title--left" data-reveal data-lz-split style="--d:1">The model sits at the centre, not on the side</h2>
      <p class="prose" data-reveal style="--d:2">
        Adding a chat box to a finished product is the cheapest possible use of a model and the
        least useful. These are the places we build intelligence into the product itself, where it
        changes what the software can do rather than how it introduces itself.
      </p>

      <ul class="aifirst" data-reveal style="--d:3">
        <?php foreach ($aiFirst as $item): ?>
          <li>
            <span class="aifirst-icon"><?= icon($item['icon']) ?></span>
            <div>
              <h3><?= e($item['title']) ?></h3>
              <p><?= e($item['body']) ?></p>
            </div>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>

    <div class="split-visual" data-reveal style="--d:2">
      <img src="<?= e(asset('assets/img/art/sec-ai-core.svg')) ?>"
           width="560" height="420" loading="lazy" decoding="async" draggable="false" alt="">
    </div>
  </div>
</section>

<section class="section lz" data-stage>
  <div class="shell">
    <?php component('section-head', [
        'eyebrow' => 'Use Cases',
        'title'   => 'What we could build together',
        'lead'    => 'Four shapes of problem we have solved before. Pick the one closest to yours '
                   . '— the closer the match, the more of the estimate is memory rather than guesswork.',
        'art'     => 'sec-usecases',
    ]); ?>

    <?php /* Radio-driven tabs: correct before any JavaScript runs, keyboard
             operable and announced without a line of ARIA plumbing. */ ?>
    <div class="uctabs" data-reveal>
      <?php /* Every radio is a direct child, ahead of both the tab bar and the
               panels, because `~` only reaches later siblings — nesting them in
               the bar is what stops the panels resolving at all. */ ?>
      <?php foreach ($cases as $i => $c): ?>
        <input class="sr-only uctabs-radio" type="radio" name="usecase"
               id="uc-<?= e($c['key']) ?>" value="<?= e($c['key']) ?>"
               <?= $i === 0 ? 'checked' : '' ?>>
      <?php endforeach; ?>

      <div class="uctabs-bar" role="group" aria-label="Choose an industry">
        <?php foreach ($cases as $c): ?>
          <label class="uctabs-tab" for="uc-<?= e($c['key']) ?>">
            <?= icon($c['icon']) ?><?= e($c['tab']) ?>
          </label>
        <?php endforeach; ?>
      </div>

      <?php foreach ($cases as $c): ?>
        <article class="uctabs-panel" data-uc="<?= e($c['key']) ?>">
          <h3 class="uctabs-title"><?= e($c['title']) ?></h3>
          <p class="uctabs-body"><?= e($c['body']) ?></p>
          <ul class="uctabs-points">
            <?php foreach ($c['points'] as $point): ?>
              <li><span class="uctabs-tick"><?= icon('check') ?></span><?= e($point) ?></li>
            <?php endforeach; ?>
          </ul>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section section--panel lz" data-stage>
  <div class="shell split">
    <div class="split-visual" data-reveal>
      <img src="<?= e(asset('assets/img/art/sec-agile.svg')) ?>"
           width="560" height="420" loading="lazy" decoding="async" draggable="false" alt="">
    </div>

    <div>
      <p class="eyebrow" data-reveal>How We Work</p>
      <h2 class="section-title section-title--left" data-reveal data-lz-split style="--d:1">Our agile approach</h2>
      <p class="prose" data-reveal style="--d:2">
        Two-week cycles, and you are in all of them. The point is not the ceremony — it is that
        you never wait a quarter to find out the thing being built is not the thing you wanted.
      </p>

      <ol class="agile" data-reveal style="--d:3">
        <?php foreach ($agile as $i => $a): ?>
          <li>
            <span class="agile-num"><?= str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT) ?></span>
            <div>
              <h3><?= e($a['title']) ?></h3>
              <p><?= e($a['body']) ?></p>
            </div>
          </li>
        <?php endforeach; ?>
      </ol>
    </div>
  </div>
</section>

<section class="section lz" data-stage>
  <div class="shell">
    <?php component('section-head', [
        'eyebrow' => 'Technology',
        'title'   => 'The stack we build AI products on',
        'lead'    => 'Chosen because we run them in production and can defend each one, not because '
                   . 'they were on a slide. Cloud is whichever of the three you are already on.',
    ]); ?>

    <?php /* Origin Kit's Word Globe, fed the section's own technology names —
             the sphere is literally woven out of the stack it introduces. The
             names are in the list below either way, because a canvas is
             invisible to a crawler. */ ?>
    <div class="lz-globe" data-word-globe aria-hidden="true"
         data-word="<?= e(implode(' · ', array_map(static fn (string $k): string => $techName[$k] ?? $k, array_merge(...array_column($stack, 'items'))))) ?>"
         data-twist="50" data-letter-spacing="1150" data-speed="7"
         data-rotation-side="counterclockwise" data-color="#9BE6FB"
         data-font-size="15"></div>

    <div class="techwall">
      <?php foreach ($stack as $g): ?>
        <section class="techwall-group" data-reveal>
          <h3 class="techwall-head"><span><?= icon($g['icon']) ?></span><?= e($g['title']) ?></h3>
          <?php
          // Origin Kit's Interactive Grid, mounted by app/originkit. Its props
          // are the registry's own; the logos are this group's.
          $logos = array_values(array_map(
              static fn (string $k): array => ['src' => asset('assets/img/tech/' . $k . '.svg')],
              array_filter($g['items'], static fn (string $k): bool => is_file(ROOT_PATH . '/assets/img/tech/' . $k . '.svg'))
          ));
          ?>
          <div class="ok-grid" data-ok="interactive-grid" aria-hidden="true"
               data-props='<?= e(json_encode([
                   'images'        => $logos,
                   'columns'       => 4,
                   'rows'          => 2,
                   'gap'           => 8,
                   'padding'       => '0px',
                   'rounded'       => 8,
                   'logoScale'     => 4,
                   'cardFill'      => '#0B0F17',
                   'cardBorder'    => '#232A38',
                   'shadow'        => true,
                   'cardShadow'    => 'rgba(3, 209, 245, 0.18)',
                   'glow'          => true,
                   'glowStart'     => 'rgba(3, 209, 245, 0.5)',
                   'glowEnd'       => '#03D1F5',
                   'glowIntensity' => 50,
                   'perspective'   => 1600,
                   'rotateX'       => 0,
                   'rotateY'       => 0,
               ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)) ?>'></div>

          <?php /* The grid paints logos with no labels, so the names stay here
                   as text — this is the section that claims the stack. */ ?>
          <ul class="techwall-names">
            <?php foreach ($g['items'] as $slug): ?>
              <li><?= e($techName[$slug] ?? $slug) ?></li>
            <?php endforeach; ?>
          </ul>
        </section>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section section--tight lz" data-stage>
  <div class="shell">
    <?php /* The claim, attributed. The figures are PwC's, not measurements of
             ours, and the sentence says so. */ ?>
    <div class="claim" data-reveal>
      <p class="claim-eyebrow"><?= icon('zap') ?>The pace has already moved</p>
      <h2 class="claim-title" data-lz-split>Your competitors are shipping in half the time</h2>
      <p class="claim-body">
        PwC's research puts the effect of AI on product work at up to half the development time and
        around a third off R&amp;D cost. Whether or not those are your numbers, the direction is not
        in dispute — and the gap compounds every quarter you wait.
      </p>
      <?php
      // Origin Kit's Swipe Stack, dealt from the sites we have shipped.
      $deck = array_values(array_map(
          static fn (array $w): array => ['src' => asset('assets/img/work/' . $w['slug'] . '.jpg')],
          array_filter(WEB_WORK, static fn (array $w): bool => is_file(ROOT_PATH . '/assets/img/work/' . $w['slug'] . '.jpg'))
      ));
      ?>
      <div class="ok-stack" data-ok="swipe-stack" aria-hidden="true"
           data-props='<?= e(json_encode([
               'images'         => $deck,
               'cardWidth'      => 300,
               'cardHeight'     => 400,
               'cardRadius'     => 4,
               'swipeThreshold' => 50,
               'tiltAngleStart' => 0,
               'tiltAngle'      => -45,
               'xOffset'        => 200,
           ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)) ?>'></div>
      <p class="ok-stack-hint" aria-hidden="true"><?= icon('compass') ?>Drag a card to send it to the back</p>

      <div class="claim-actions">
        <a class="btn btn-primary" data-magnet href="<?= e(url('contact.php')) ?>">Talk to an engineer<?= icon('arrow') ?></a>
        <a class="btn btn-ghost" data-magnet href="<?= e(url('case-studies.php')) ?>">See what we have shipped</a>
      </div>
    </div>
  </div>
</section>
