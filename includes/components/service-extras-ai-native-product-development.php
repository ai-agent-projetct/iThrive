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
    ['art' => 'agile-demo', 'title' => 'A demo every two weeks',
     'body' => 'Working software on a call, not a status document. If a fortnight has passed with nothing to show, that is the thing worth discussing.'],
    ['art' => 'agile-sprint', 'title' => 'Sprints you can see into',
     'body' => 'The board is yours to read. What is in progress, what slipped and why, without waiting for a weekly summary to find out.'],
    ['art' => 'agile-feedback', 'title' => 'Feedback that changes the next sprint',
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

      <?php /* Origin Kit's Hover Image Reveal. The rows are the real list —
               headings and sentences — so with no pointer, on a phone, or under
               reduced motion the section is simply read. */ ?>
      <ol class="agile hr" data-reveal data-hover-reveal style="--d:3"
          <?php /* offsetX is negative because the rows sit in the right column:
                   the component's default pushes the window right, which lands
                   it on top of the very text it is illustrating. */ ?>
          data-image-width="300" data-image-height="380" data-rounded="16"
          data-offset-x="-400" data-offset-y="0" data-follow-strength="0">
        <?php foreach ($agile as $i => $a): ?>
          <li data-hr-row>
            <span class="agile-num"><?= str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT) ?></span>
            <div>
              <h3><?= e($a['title']) ?></h3>
              <p><?= e($a['body']) ?></p>
            </div>
          </li>
        <?php endforeach; ?>

        <?php /* The cursor-following window and the reel inside it. Decorative
                 — every picture restates the row it belongs to. */ ?>
        <span class="hr-window" data-hr-window aria-hidden="true">
          <span class="hr-reel" data-hr-reel>
            <?php foreach ($agile as $a): ?>
              <span class="hr-frame">
                <img src="<?= e(asset('assets/img/art/' . $a['art'] . '.svg')) ?>"
                     width="560" height="420" loading="lazy" decoding="async" draggable="false" alt="">
              </span>
            <?php endforeach; ?>
          </span>
        </span>
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
          <?php /* Origin Kit's Interactive Grid: hovering a card lifts it and
                   ripples into its four neighbours. Each card keeps its
                   technology's name as text, so the grid is still a readable
                   list of the stack and not forty logos with no labels. */ ?>
          <ul class="techwall-list igrid" data-igrid
              data-columns="4" data-rounded="8" data-logo-scale="3"
              data-perspective="1600" data-rotate-x="0" data-rotate-y="0"
              data-glow-intensity="50">
            <?php foreach ($g['items'] as $slug): ?>
              <?php if (!is_file(ROOT_PATH . '/assets/img/tech/' . $slug . '.svg')) { continue; } ?>
              <li class="igrid-card" data-igrid-card tabindex="0">
                <img src="<?= e(asset('assets/img/tech/' . $slug . '.svg')) ?>"
                     width="26" height="26" loading="lazy" decoding="async" alt="">
                <span><?= e($techName[$slug] ?? $slug) ?></span>
              </li>
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
      <div class="claim-actions">
        <a class="btn btn-primary" data-magnet href="<?= e(url('contact.php')) ?>">Talk to an engineer<?= icon('arrow') ?></a>
        <a class="btn btn-ghost" data-magnet href="<?= e(url('case-studies.php')) ?>">See what we have shipped</a>
      </div>
    </div>
  </div>
</section>
