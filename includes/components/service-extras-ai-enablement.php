<?php
/**
 * Extra sections for AI Enablement for Existing Products.
 *
 * Structure follows the two reference pages: absoluteapplabs' argument (your
 * product cannot stay static → what we add → use cases by industry → what you
 * achieve → the agile cadence → the closing claim) with Trionova's depth folded
 * in (core capabilities, an enterprise stack, a six-phase roadmap, and the
 * compliance frame).
 *
 * The copy is written for this site. The sections match, the capabilities match,
 * the technologies match; the sentences are ours, because republishing a
 * competitor's prose is their copyright and our duplicate content on the page
 * that is meant to rank.
 *
 * Colour comes from body.aleph in the stylesheet — every component below is the
 * site's own, reading tokens that page redefines, so none of them needed a
 * light-theme variant written by hand.
 *
 * @var array $svc The service, from service().
 */

declare(strict_types=1);

/** What gets added to a product that already works. */
$adds = [
    ['icon' => 'trending-up', 'title' => 'Behavioural pattern mapping',
     'body' => 'Read the micro-interactions you already log — where people hesitate, backtrack '
             . 'and give up — and turn them into intent you can act on before anyone files a ticket.'],
    ['icon' => 'target', 'title' => 'Decision intelligence layers',
     'body' => 'The product proposes the next best action rather than waiting to be told. Ranked, '
             . 'explained, and overridable, so nobody is asked to trust a number they cannot question.'],
    ['icon' => 'sparkles', 'title' => 'Micro-personalisation',
     'body' => 'Content, workflow and layout adapt to the individual rather than to a segment '
             . 'they were filed under eighteen months ago.'],
    ['icon' => 'bot', 'title' => 'Embedded agents',
     'body' => 'Autonomous workers for the repetitive middle of your product — scheduling, '
             . 'approvals, reconciliation, data sync — with an approval gate wherever one belongs.'],
    ['icon' => 'shield', 'title' => 'Proactive issue resolution',
     'body' => 'Predict the failure and resolve it before the user meets it, from the system '
             . 'signals and the support history you are already sitting on.'],
    ['icon' => 'refresh', 'title' => 'Legacy system enhancement',
     'body' => 'The intelligence ships as a sidecar behind a feature flag. Your existing stack '
             . 'keeps running untouched, and the whole layer switches off in one call.'],
];

/** Use cases, by industry. Tabbed with radios — no JavaScript required. */
$cases = [
    ['key' => 'retail', 'tab' => 'Retail', 'icon' => 'cart',
     'title' => 'More sales out of the commerce platform you already run',
     'body' => 'Recommendations ranked on real behaviour, search that understands a sentence, and '
             . 'segments that update themselves — added to your storefront rather than replacing it.',
     'points' => ['Behavioural product recommendations', 'Natural-language search over your catalogue',
                  'Segmentation from live behaviour, not last year\'s export', 'Upsell flows tuned per shopper']],

    ['key' => 'healthcare', 'tab' => 'Healthcare', 'icon' => 'stethoscope',
     'title' => 'Proactive care flows on top of the systems you have',
     'body' => 'Triage, routing and reminders that predict the no-show and fill the slot, with the '
             . 'EHR left exactly where it is. Access control and audit are part of the build.',
     'points' => ['Smart appointment routing', 'Predictive care alerts', 'Conversational symptom intake',
                  'EHR enrichment without EHR replacement']],

    ['key' => 'saas', 'tab' => 'SaaS', 'icon' => 'bar-chart',
     'title' => 'A product that gets stickier without a new release cycle',
     'body' => 'Usage prediction, in-app modelling and analytics people actually open — the layers '
             . 'that make an existing subscription harder to cancel.',
     'points' => ['Analytics and reporting people read', 'In-app behaviour modelling',
                  'Onboarding that adapts per account', 'Support bots that reach out first']],

    ['key' => 'logistics', 'tab' => 'Logistics', 'icon' => 'car',
     'title' => 'Predictive intelligence inside your existing fleet platform',
     'body' => 'Sequencing under real constraints, arrival estimates that revise as the day goes '
             . 'wrong, and maintenance predicted before the vehicle stops.',
     'points' => ['Live delivery prediction', 'Route and fuel optimisation',
                  'Demand forecasting for inventory', 'Automated incident alerting']],

    ['key' => 'fintech', 'tab' => 'FinTech', 'icon' => 'shield',
     'title' => 'Sharper decisions inside the platform you are regulated on',
     'body' => 'Fraud detection, risk scoring and personalised insight added to your decision path '
             . '— with the explainability a regulator will ask for built in from the start.',
     'points' => ['Anomaly detection on live transactions', 'AI-assisted KYC workflows',
                  'Real-time transaction analysis', 'Predictive credit scoring, explained']],
];

/** What the work is worth. */
$achieve = [
    ['value' => 'Zero', 'label' => 'Rewrites required',
     'body' => 'The AI layer runs beside your product, not through it. Nothing in the revenue path is touched.'],
    ['value' => '2–4 wks', 'label' => 'To the first shipped feature',
     'body' => 'From audit to something live behind a flag, because we build on the architecture you already have.'],
    ['value' => '1 flag', 'label' => 'To turn the whole layer off',
     'body' => 'Every feature ships behind a switch. If it misbehaves at 3am, the rollback is one call.'],
];

/** Trionova's core capability set, in our words. */
$core = [
    ['icon' => 'brain',       'title' => 'Machine learning',            'body' => 'Supervised, unsupervised and reinforcement models trained on your own operational data.'],
    ['icon' => 'sparkles',    'title' => 'Generative AI',               'body' => 'Text, code and image generation wired into the workflow that needed it, not bolted on beside it.'],
    ['icon' => 'message',     'title' => 'Natural language processing', 'body' => 'Assistants, speech and contextual understanding grounded in your documentation.'],
    ['icon' => 'workflow',    'title' => 'Robotic process automation',  'body' => 'The repetitive middle of a process, handled — with a human gate wherever one belongs.'],
    ['icon' => 'search',      'title' => 'Computer vision',             'body' => 'Document reading, inspection and classification at a volume nobody can staff for.'],
    ['icon' => 'bar-chart',   'title' => 'Data science and analytics',  'body' => 'The numbers behind behaviour and operations, in a form somebody will actually act on.'],
    ['icon' => 'trending-up', 'title' => 'Predictive and prescriptive', 'body' => 'What is about to happen, and what to do about it, on your own history.'],
    ['icon' => 'bot',         'title' => 'Conversational AI',           'body' => 'Agents that hold a thread, escalate cleanly, and never invent a policy.'],
    ['icon' => 'cpu',         'title' => 'Edge AI',                     'body' => 'Inference at the device when a round trip to a datacentre is too slow to be useful.'],
    ['icon' => 'heart',       'title' => 'Sentiment analysis',          'body' => 'Reading tone so a support path can change before a customer escalates.'],
    ['icon' => 'lightbulb',   'title' => 'Explainable AI',              'body' => 'Interpretability and audit trails, because a regulated decision has to be defensible.'],
    ['icon' => 'zap',         'title' => 'Efficient AI',                'body' => 'Model routing, caching and quantisation, so unit economics survive general availability.'],
];

/** The stack, following Trionova's categories. */
$stack = [
    ['title' => 'Languages and frameworks', 'icon' => 'code',
     'items' => ['python', 'pytorch', 'tensorflow', 'scikitlearn', 'pandas']],
    ['title' => 'Models and orchestration', 'icon' => 'brain',
     'items' => ['openai', 'langchain', 'fastapi', 'celery', 'apacheairflow']],
    ['title' => 'Data and retrieval', 'icon' => 'database',
     'items' => ['postgresql', 'redis', 'opensearch', 'mongodb', 'mysql']],
    ['title' => 'Cloud and MLOps', 'icon' => 'cloud',
     'items' => ['amazonwebservices', 'googlecloud', 'azure', 'docker', 'kubernetes', 'terraform', 'githubactions', 'grafana']],
];

$techName = [
    'python' => 'Python', 'pytorch' => 'PyTorch', 'tensorflow' => 'TensorFlow',
    'scikitlearn' => 'scikit-learn', 'pandas' => 'pandas', 'openai' => 'OpenAI',
    'langchain' => 'LangChain', 'fastapi' => 'FastAPI', 'celery' => 'Celery',
    'apacheairflow' => 'Airflow', 'postgresql' => 'PostgreSQL', 'redis' => 'Redis',
    'opensearch' => 'OpenSearch', 'mongodb' => 'MongoDB', 'mysql' => 'MySQL',
    'amazonwebservices' => 'AWS', 'googlecloud' => 'Google Cloud', 'azure' => 'Azure',
    'docker' => 'Docker', 'kubernetes' => 'Kubernetes', 'terraform' => 'Terraform',
    'githubactions' => 'GitHub Actions', 'grafana' => 'Grafana',
];

/** The six-phase roadmap, after Trionova's. */
$roadmap = [
    ['title' => 'Discovery and alignment',      'body' => 'We instrument the product you already run, find where users stall and tickets cluster, and rank the candidates by effort against measured impact.'],
    ['title' => 'Data readiness',               'body' => 'Extraction, cleaning and embedding of the operational data already sitting in your database, your files and your ticket history.'],
    ['title' => 'Model development',            'body' => 'The models themselves, built to the use case rather than to a framework — and small wherever small is enough.'],
    ['title' => 'Training and evaluation',      'body' => 'A golden dataset and an eval suite before anything ships, so a regression is caught in CI rather than by a customer.'],
    ['title' => 'Deployment as a sidecar',      'body' => 'The layer goes live beside your product behind a feature flag. Shadow mode first, then a cohort, then everyone.'],
    ['title' => 'Monitoring and handover',      'body' => 'Drift watched, costs tracked, and your team taught to run it — the engagement ends, the capability does not.'],
];

/** The compliance frame, after Trionova's. */
$compliance = [
    'Regulation'  => ['GDPR', 'HIPAA', 'PCI-DSS', 'SOC 2', 'CCPA', 'DPA 2018'],
    'Standards'   => ['ISO/IEC 27001', 'ISO 9001', 'NIST AI RMF', 'IEEE AI standards', 'OECD AI principles'],
    'Practice'    => ['Explainable AI', 'Model governance', 'Bias and fairness testing', 'Audit-logged inference', 'Data residency controls'],
];
?>

<section class="section" id="what-we-add">
  <div class="shell">
    <?php component('section-head', [
        'eyebrow' => 'Better Experiences, Built On What You Have',
        'title'   => 'A power-up, not a rebuild',
        'lead'    => 'Your product already works and already earns. The job is to make it smarter '
                   . 'without destabilising the parts that pay for everything — so we build alongside '
                   . 'it, never through it.',
    ]); ?>

    <div class="grid grid-3">
      <?php foreach ($adds as $i => $a): ?>
        <article class="card card--numbered" data-reveal style="--d:<?= $i % 3 ?>">
          <span class="card-num"><?= str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT) ?></span>
          <span class="card-icon"><?= icon($a['icon']) ?></span>
          <h3 class="card-title"><?= e($a['title']) ?></h3>
          <p class="card-body"><?= e($a['body']) ?></p>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section section--panel">
  <div class="shell">
    <?php component('section-head', [
        'eyebrow' => 'Use Cases',
        'title'   => 'What we could enable together',
        'lead'    => 'AI is not only for new platforms. These are the layers we add to systems that '
                   . 'are already carrying customers — pick the one closest to yours.',
    ]); ?>

    <div class="uctabs" data-reveal>
      <?php foreach ($cases as $i => $c): ?>
        <input class="sr-only uctabs-radio" type="radio" name="aecase"
               id="ae-<?= e($c['key']) ?>" <?= $i === 0 ? 'checked' : '' ?>>
      <?php endforeach; ?>

      <div class="uctabs-bar" role="group" aria-label="Choose an industry">
        <?php foreach ($cases as $c): ?>
          <label class="uctabs-tab" for="ae-<?= e($c['key']) ?>"><?= icon($c['icon']) ?><?= e($c['tab']) ?></label>
        <?php endforeach; ?>
      </div>

      <?php foreach ($cases as $c): ?>
        <article class="uctabs-panel" data-ae="<?= e($c['key']) ?>">
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

<section class="section">
  <div class="shell">
    <?php component('section-head', [
        'eyebrow' => 'What You Can Achieve',
        'title'   => 'The numbers that matter on an existing product',
        'lead'    => 'Not model accuracy — the three figures a team running a live platform actually asks about.',
    ]); ?>

    <div class="grid grid-3">
      <?php foreach ($achieve as $i => $a): ?>
        <article class="card" data-reveal style="--d:<?= $i ?>">
          <p class="ae-value"><?= e($a['value']) ?></p>
          <h3 class="card-title"><?= e($a['label']) ?></h3>
          <p class="card-body"><?= e($a['body']) ?></p>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section section--panel">
  <div class="shell">
    <?php component('section-head', [
        'eyebrow' => 'Core Capabilities',
        'title'   => 'What we can put inside your product',
        'lead'    => 'Twelve capabilities we run in production. Most engagements use three or four of them.',
    ]); ?>

    <div class="ae-core">
      <?php foreach ($core as $c): ?>
        <article class="ae-core-item" data-reveal>
          <span class="ae-core-icon"><?= icon($c['icon']) ?></span>
          <div>
            <h3><?= e($c['title']) ?></h3>
            <p><?= e($c['body']) ?></p>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section">
  <div class="shell">
    <?php component('section-head', [
        'eyebrow' => 'The Stack',
        'title'   => 'What we build the layer on',
        'lead'    => 'Chosen because we run them in production and can defend each one. Cloud is whichever of the three you are already on.',
    ]); ?>

    <div class="techwall">
      <?php foreach ($stack as $g): ?>
        <section class="techwall-group" data-reveal>
          <h3 class="techwall-head"><span><?= icon($g['icon']) ?></span><?= e($g['title']) ?></h3>
          <ul class="techwall-list">
            <?php foreach ($g['items'] as $slug): ?>
              <?php if (!is_file(ROOT_PATH . '/assets/img/tech/' . $slug . '.svg')) { continue; } ?>
              <li class="techwall-item">
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

<section class="section section--panel">
  <div class="shell">
    <?php component('section-head', [
        'eyebrow' => 'How We Get There',
        'title'   => 'Six phases, and you are in all of them',
        'lead'    => 'Two-week cycles with a demo at the close of each. The point is not the ceremony — '
                   . 'it is that you never wait a quarter to find out the thing being built is not the thing you wanted.',
    ]); ?>

    <ol class="ae-road">
      <?php foreach ($roadmap as $i => $r): ?>
        <li data-reveal style="--d:<?= $i % 3 ?>">
          <span class="ae-road-num"><?= str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT) ?></span>
          <h3><?= e($r['title']) ?></h3>
          <p><?= e($r['body']) ?></p>
        </li>
      <?php endforeach; ?>
    </ol>
  </div>
</section>

<section class="section">
  <div class="shell">
    <?php component('section-head', [
        'eyebrow' => 'Compliance',
        'title'   => 'The frame around every layer we ship',
        'lead'    => 'Adding intelligence to a product that already holds customer data does not lower the bar. It raises it.',
    ]); ?>

    <div class="ae-comply">
      <?php foreach ($compliance as $heading => $items): ?>
        <section data-reveal>
          <h3><?= e($heading) ?></h3>
          <ul>
            <?php foreach ($items as $item): ?><li><?= e($item) ?></li><?php endforeach; ?>
          </ul>
        </section>
      <?php endforeach; ?>
    </div>
  </div>
</section>
