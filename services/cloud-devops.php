<?php
/**
 * Cloud & DevOps — the ninth bespoke service page.
 *
 * Built after absoluteapplabs.com/cloud-devops-services, section for section,
 * in iThrive's own words: hero, why the practice earns its place, the five
 * stages, six services, the band, the working process, six reasons, five
 * questions, close.
 *
 * ONE DELIBERATE DEPARTURE. The reference's working-process block is the same
 * three steps it prints on its custom-product page — discovery call, statement
 * of understanding, execution. Repeating our own version of that would break
 * the rule this site is built under, so the three beats are here in
 * cloud-specific words and in a different form: a terminal transcript, which is
 * where this work actually happens.
 *
 * ON COMPONENTS. Nine components across the eight earlier pages were measured
 * rendering nothing, every one of them computing layout inside
 * requestAnimationFrame or painting to a canvas. Origin Kit's registry is
 * largely WebGL and its fetch quota — three a day, five a week — was spent on
 * the Custom Product page, so nothing new could be pulled for this one and
 * nothing already vendored is both unused and working.
 *
 * So this page is built rather than fetched, and the hero is the case for that
 * being fine: a real 3D orbit, interactive, that is laid out and correct before
 * a single frame runs.
 *
 * Theme: the site's ramp, with this page's own type — Chivo, Karla and Azeret
 * Mono. The motif is the ORBIT: concentric tracks with gates on them and a
 * pulse part way round, lit behind and dashed ahead. Cloud is not a setup you
 * finish, it is a circuit that keeps running, and the work is always somewhere
 * on it.
 *
 * Pictures come from tools/cloud-art.mjs; every slot prefers a photograph from
 * assets/img/cloud/photo/ the moment one lands.
 */

declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/config.php';

$svc = service('cloud-devops');

$page      = 'services';
$pageTitle = 'Cloud & DevOps Services in Chennai';
$pageDesc  = 'iThrive Software builds cloud that keeps improving — infrastructure as code, CI/CD, '
           . 'observability and cost control, run as a living system rather than a one-time setup.';
$ogImage   = 'service-' . $svc['group_slug'];

/* ---------------------------------------------------------------------------
 * Content
 * ------------------------------------------------------------------------ */

/** The hero orbit's gate labels, outermost ring first. */
$gates = ['commit', 'build', 'test', 'scan', 'stage', 'deploy', 'observe', 'tune'];

$stats = [
    ['6pm Fri', 'When a fix should still be shippable'],
    ['< 15 min', 'Commit to production, typical'],
    ['1 cmd',    'Rebuild any environment from code'],
    ['24/7',     'Alerting that pages us, not you'],
];

/** What the practice actually buys — four. */
$gains = [
    ['01', 'Releases stop being events',
     'Shipping becomes a thing that happens several times a day and nobody schedules a call for. The change is cultural, but it is bought with automation.'],
    ['02', 'The bill comes down',
     'Right-sizing, reserved capacity, autoscaling and killing what nothing uses. Most cloud bills we inherit have twenty to forty percent in them that no workload needs.'],
    ['03', 'Reliability and security are built in',
     'Least privilege, secrets in a managed store, dependency scanning in CI and encryption by default — decided once in code rather than remembered per deploy.'],
    ['04', 'Downtime stops being routine',
     'Blue-green deploys, health checks and automatic rollback. A bad release becomes a two-minute reversal rather than an evening.'],
];

/** The five stages of the loop. */
$stages = [
    ['01', 'Architect', 'Map the cloud you actually have',
     'Not the diagram from two years ago — the real account. Every running resource, what it costs, what depends on it and what nothing has touched in six months. Most engagements find their first savings here, before any change is made.'],
    ['02', 'Automate', 'Remove the manual release friction',
     'Every step between a commit and production gets written down as code: build, test, scan, sign, deploy. Anything that currently needs a person to remember it is a step that will eventually be forgotten at the worst moment.'],
    ['03', 'Deploy', 'Activate workloads with control',
     'Blue-green or canary, health-gated, feature-flagged and reversible. A deploy should be a config change with a rollback path, not an event with a bridge call and a rota.'],
    ['04', 'Optimise', 'Improve cost, speed and security together',
     'Right-size instances, tune the queries the traces show, close the permissions nobody needs and cache what is fetched a thousand times. All three usually move together, because they usually share a cause.'],
    ['05', 'Evolve', 'Keep it modern, continuously',
     'Runtimes, base images and dependencies stay current on a schedule rather than in an emergency. This is the stage that decides whether year three is a tune-up or a migration.'],
];

/** Six services. */
$services = [
    ['01', 'Cloud strategy and migration',
     'Workloads moved to AWS, GCP or Azure against a roadmap tied to what the business needs, not a generic checklist. Lift-and-shift where that is honestly right, re-architecture where it is not.'],
    ['02', 'CI/CD implementation',
     'Commit to production without waiting on a manual approval that exists because someone was once burned. Tests, scans and signing in the pipeline, with the gates that matter kept and the ceremony removed.'],
    ['03', 'Infrastructure as code',
     'Terraform-defined environments that can be destroyed and rebuilt identically, staging that genuinely matches production, and the end of "works on my machine" as an explanation.'],
    ['04', 'Cloud-native development',
     'Containers, managed services and microservices where they earn their place. We split a system along the seams that need to deploy independently — not along the lines that look tidy on a diagram.'],
    ['05', 'Monitoring and security',
     'Metrics, logs and traces that answer a question rather than fill a dashboard. Alerts tuned to page a human only when a human is needed, and scanning that blocks a merge rather than filing a ticket.'],
    ['06', 'DevOps consulting',
     'We are not here to sell you tools. The work is the operating model — ownership, on-call, review, release cadence — because a perfect pipeline in a team that cannot deploy on a Friday has not fixed anything.'],
];

/**
 * The working process, as it actually reads.
 *
 * Three beats, cloud-specific. A transcript rather than three cards, because a
 * card grid for this exists elsewhere on the site and this is the surface the
 * work is genuinely done on.
 */
$transcript = [
    ['01', '$ ithrive discovery --30min',
     'A call, not a questionnaire',
     'Thirty minutes on what you run, what it costs, and which deploy most recently went wrong. We ask what breaks, who gets paged and what the workaround is. No deck, and nothing to sign.'],
    ['02', '$ ithrive plan --write',
     'The findings, in writing',
     'A few days later you get the account as we found it: what is over-provisioned, what is exposed, what is undocumented, and a phased plan with an engagement model and a budget range. Including the phases we think you should not start yet.'],
    ['03', '$ ithrive ship --every-two-weeks',
     'Delivery you can watch',
     'Two-week increments against your own repository and your own cloud accounts, from the first commit. Every change reviewable, every environment reproducible, and a monthly cost and uptime summary sent whether it flatters us or not.'],
];

/** Why us — six. */
$fit = [
    ['01', 'Engineers, not tool resellers',   'The people configuring your pipeline have shipped products through one. We recommend the boring option more often than the interesting one.'],
    ['02', 'Deployments with no ceremony',    'Automated, health-gated and reversible. If a release needs a bridge call, we have not finished the work.'],
    ['03', 'Scaling shaped by the product',   'Capacity planned against what your product actually does under load, not against a reference architecture.'],
    ['04', 'Real visibility across the stack','Metrics, logs and traces that let you answer a new question at 2am, rather than a dashboard nobody reads at noon.'],
    ['05', 'Security inside every release',   'Scanning, least privilege and managed secrets in the pipeline. Security that lives outside the release is security that gets skipped.'],
    ['06', 'No annual rebuild',               'Kept current continuously, so there is never a quarter set aside to catch the platform up with itself.'],
];

$faqs = [
    ['What does a cloud partner actually do, beyond the initial setup?',
     'Setting cloud up is the small part. The work is operating it: aligning infrastructure decisions to what the product needs, changing the architecture as usage changes, keeping the cost curve under the growth curve, and making sure a deploy stays a non-event. A partner who hands over a working account and leaves has sold you a snapshot of something that only stays useful if it keeps moving.'],
    ['Why hire a partner rather than build the capability in-house?',
     'Eventually you should have it in-house, and we will help you get there — a good engagement ends with your team owning the pipeline and the runbooks. The case for bringing someone in is speed and scar tissue: you get patterns already proven across other products instead of learning them from your own outages. What you should not do is hire one DevOps engineer and make them solely responsible; that is a single point of failure with a pager.'],
    ['Is this continuous, or a one-off project?',
     'Both models exist and we will tell you which you need. A bounded piece — a migration, a pipeline build, a cost review — is a project with an end. But cloud left alone decays: dependencies fall out of support, instances stay sized for last year, and permissions accumulate. Most clients start with a bounded project and continue on a monthly basis once they can see what it prevents.'],
    ['Why is our cloud bill rising when usage is flat?',
     'Almost always one of five things: instances sized for a peak that never recurred, storage and snapshots nothing prunes, data transfer between zones that a placement change would remove, orphaned resources from experiments nobody deleted, and on-demand pricing on workloads that have run continuously for two years. A cost review finds these in about a week, and the first pass usually pays for itself.'],
    ['Our deployments still fail even with CI/CD. Is that normal?',
     'It is common, and it usually means the pipeline automates the steps without reproducing the environment. If staging differs from production in any way that matters, CI/CD delivers a broken change faster rather than catching it. The fix is infrastructure as code so environments are identical by construction, health-gated deploys so a bad release stops itself, and automatic rollback so failure is a two-minute reversal instead of an evening.'],
];

$extraHead = '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>'
    . '<link rel="stylesheet" href="https://fonts.googleapis.com/css2?'
    . 'family=Chivo:wght@400;500;600;700;800'
    . '&family=Karla:wght@400;500;600;700'
    . '&family=Azeret+Mono:wght@400;500;600;700&display=swap">'
    . '<link rel="stylesheet" href="' . e(asset('assets/css/cloud.css')) . '">';

/* The five questions as schema, the same treatment the other bespoke pages get. */
$schemaExtra = [
    [
        '@type'      => 'FAQPage',
        'name'       => 'Cloud and DevOps — frequently asked questions',
        'mainEntity' => array_map(static fn (array $f): array => [
            '@type'          => 'Question',
            'name'           => $f[0],
            'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f[1]],
        ], $faqs),
    ],
];

require dirname(__DIR__) . '/includes/header.php';

$img = static function (string $rel): string {
    [$set, $file] = explode('/', $rel, 2);
    $photo = 'assets/img/cloud/photo/' . $set . '-' . $file;

    return asset(is_file(ROOT_PATH . '/' . $photo) ? $photo : 'assets/img/cloud/' . $rel);
};
?>

<div class="cd">

  <?php /* ---------------------------------------------------------------
           Hero — the orbit

           Three concentric rings tilted into 3D, each turning at its own rate,
           with the eight pipeline gates riding the outer one. Every position is
           written from the element's own --a and --r, so the whole system is
           laid out and correct at first paint. The pointer only changes the
           tilt of the assembly, and the spin is a CSS animation the compositor
           owns.

           Nine components on this site have rendered nothing by computing
           geometry like this inside requestAnimationFrame. This one cannot.
           --------------------------------------------------------------- */ ?>
  <section class="cd-hero" data-orbit>
    <img class="cd-hero-bg" src="<?= e($img('hero/01.jpg')) ?>" width="1800" height="1000"
         alt="" fetchpriority="high" decoding="async">
    <div class="cd-hero-wash" aria-hidden="true"></div>

    <div class="cd-shell cd-hero-grid">
      <div class="cd-hero-copy">
        <p class="cd-eyebrow"><span class="cd-mark" aria-hidden="true"></span>Cloud &amp; DevOps · Chennai</p>

        <h1 class="cd-h1">
          Cloud that keeps<br>
          <em>getting sharper</em>
        </h1>

        <p class="cd-lead">
          Most cloud stacks peak on day one and decay quietly after it. We treat yours as a circuit
          rather than a setup — architected, automated, deployed, tuned and brought current again,
          every month, while your product grows into it.
        </p>

        <div class="cd-actions">
          <button class="cd-btn cd-btn--primary" type="button"
                  data-modal-open data-modal-service="Cloud &amp; DevOps">
            Make my cloud future-ready<?= icon('arrow') ?>
          </button>
          <a class="cd-btn cd-btn--ghost" href="#cd-stages">See the five stages</a>
        </div>

        <ul class="cd-stats">
          <?php foreach ($stats as [$v, $l]): ?>
            <li><strong><?= e($v) ?></strong><span><?= e($l) ?></span></li>
          <?php endforeach; ?>
        </ul>
      </div>

      <div class="cd-hero-stage">
        <div class="cd-orbit" data-orbit-inner aria-hidden="true">
          <div class="cd-orbit-tilt">
            <?php /* Three tracks. The outer one carries the gates. */ ?>
            <?php foreach ([0, 1, 2] as $ring): ?>
              <div class="cd-ring" style="--ring: <?= $ring ?>;">
                <div class="cd-ring-spin">
                  <?php if ($ring === 0): ?>
                    <?php foreach ($gates as $g => $label): ?>
                      <span class="cd-gate" style="--a: <?= $g ?>;" data-gate="<?= $g ?>"></span>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </div>
              </div>
            <?php endforeach; ?>

            <figure class="cd-core">
              <img src="<?= e($img('core/01.jpg')) ?>" width="620" height="620"
                   alt="" fetchpriority="high" decoding="async">
            </figure>
          </div>
        </div>

        <?php /* The gate names square to the screen. Text riding a ring tilted
                 68 degrees is unreadable — the Custom Product page shipped that
                 mistake once and it came out as smears. */ ?>
        <ol class="cd-gate-list">
          <?php foreach ($gates as $g => $label): ?>
            <li><span><?= str_pad((string) ($g + 1), 2, '0', STR_PAD_LEFT) ?></span><?= e($label) ?></li>
          <?php endforeach; ?>
        </ol>
      </div>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           What it buys — four
           --------------------------------------------------------------- */ ?>
  <section class="cd-sec cd-gains">
    <div class="cd-shell">
      <div class="cd-head">
        <p class="cd-eyebrow"><span class="cd-mark" aria-hidden="true"></span>Why it matters</p>
        <h2 class="cd-title">Any product can be built.<br>Only some <em>keep improving</em></h2>
        <p class="cd-sub">
          The difference is rarely talent and almost never effort. It is friction: the manual step
          before a release, the environment that does not match, the alert nobody trusts. Cloud and
          DevOps is the practice of removing those, so the engineering you are already paying for
          shows up in production faster, more safely, and with less waste on the way.
        </p>
      </div>

      <div class="cd-gain-grid">
        <?php foreach ($gains as $i => [$n, $title, $body]): ?>
          <article class="cd-gain" data-reveal style="--d:<?= $i % 4 ?>">
            <figure>
              <img src="<?= e($img('gain/' . $n . '.jpg')) ?>" width="720" height="520"
                   alt="" loading="lazy" decoding="async">
            </figure>
            <div class="cd-gain-body">
              <span class="cd-num"><?= e($n) ?></span>
              <h3><?= e($title) ?></h3>
              <p><?= e($body) ?></p>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           The five stages — a radial dial

           The stages sit around a circle and the dial turns to bring one to
           the top. Placement comes from each stage's own --i, so the dial is
           correct before any script runs; the buttons only change --sel.
           --------------------------------------------------------------- */ ?>
  <section class="cd-sec cd-stages" id="cd-stages" data-dial>
    <div class="cd-shell">
      <div class="cd-head cd-head--mid">
        <p class="cd-eyebrow"><span class="cd-mark" aria-hidden="true"></span>The loop</p>
        <h2 class="cd-title">The five stages that turn<br>cloud into a <em>living system</em></h2>
      </div>

      <div class="cd-dial-wrap">
        <div class="cd-dial" data-dial-inner style="--n: <?= count($stages) ?>;">
          <div class="cd-dial-ring" aria-hidden="true"></div>
          <?php foreach ($stages as $i => [$n, $name]): ?>
            <button class="cd-dial-pin<?= $i === 0 ? ' is-on' : '' ?>" type="button"
                    style="--i: <?= $i ?>;" data-dial-pin="<?= $i ?>"
                    aria-label="<?= e($name) ?>">
              <span><?= e($n) ?></span>
              <b><?= e($name) ?></b>
            </button>
          <?php endforeach; ?>
        </div>

        <div class="cd-stage-cards">
          <?php foreach ($stages as $i => [$n, $name, $sub, $body]): ?>
            <article class="cd-stage-card<?= $i === 0 ? ' is-on' : '' ?>" data-stage="<?= $i ?>"<?= $i === 0 ? '' : ' hidden' ?>>
              <figure>
                <img src="<?= e($img('stage/' . $n . '.jpg')) ?>" width="760" height="760"
                     alt="" loading="lazy" decoding="async">
              </figure>
              <div>
                <span class="cd-num"><?= e($n) ?> · <?= e($name) ?></span>
                <h3><?= e($sub) ?></h3>
                <p><?= e($body) ?></p>
              </div>
            </article>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           Six services
           --------------------------------------------------------------- */ ?>
  <section class="cd-sec cd-svc">
    <div class="cd-shell">
      <div class="cd-head">
        <p class="cd-eyebrow"><span class="cd-mark" aria-hidden="true"></span>What we run</p>
        <h2 class="cd-title">Reinvent it with our<br><em>cloud and DevOps</em> services</h2>
      </div>

      <div class="cd-svc-grid">
        <?php foreach ($services as $i => [$n, $title, $body]): ?>
          <article class="cd-svc-card" data-reveal style="--d:<?= $i % 3 ?>">
            <figure>
              <img src="<?= e($img('svc/' . $n . '.jpg')) ?>" width="820" height="540"
                   alt="" loading="lazy" decoding="async">
              <span class="cd-scan" aria-hidden="true"></span>
            </figure>
            <div class="cd-svc-body">
              <span class="cd-num"><?= e($n) ?></span>
              <h3><?= e($title) ?></h3>
              <p><?= e($body) ?></p>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           Band
           --------------------------------------------------------------- */ ?>
  <section class="cd-band">
    <div class="cd-shell cd-band-inner">
      <div class="cd-band-pulse" aria-hidden="true"><i></i><i></i><i></i></div>
      <h2>Ready to move past<br><em>set it and forget it?</em></h2>
      <button class="cd-btn cd-btn--primary" type="button"
              data-modal-open data-modal-service="Cloud &amp; DevOps">
        Talk to our cloud team<?= icon('arrow') ?>
      </button>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           The working process — a transcript

           Three cards would have repeated the Custom Product page's shape. The
           same three beats, in cloud's own words, on the surface the work is
           actually done on.
           --------------------------------------------------------------- */ ?>
  <section class="cd-sec cd-process">
    <div class="cd-shell">
      <div class="cd-head">
        <p class="cd-eyebrow"><span class="cd-mark" aria-hidden="true"></span>How we start</p>
        <h2 class="cd-title">Three commands,<br>and <em>nothing to sign</em></h2>
        <p class="cd-sub">
          Most cloud setups slide into yesterday's architecture because nobody owns the month after
          launch. So the engagement is built around the opposite: small, visible, and reversible,
          starting with half an hour that costs you nothing.
        </p>
      </div>

      <div class="cd-term" data-term>
        <div class="cd-term-bar" aria-hidden="true">
          <i></i><i></i><i></i>
          <span>ithrive — cloud engagement</span>
        </div>

        <ol class="cd-term-body">
          <?php foreach ($transcript as $i => [$n, $cmd, $title, $body]): ?>
            <li class="cd-term-step" data-term-step data-index="<?= $i ?>">
              <p class="cd-term-cmd"><span aria-hidden="true">&rsaquo;</span><?= e($cmd) ?></p>
              <figure>
                <img src="<?= e($img('step/' . $n . '.jpg')) ?>" width="860" height="540"
                     alt="" loading="lazy" decoding="async">
              </figure>
              <div class="cd-term-out">
                <h3><?= e($title) ?></h3>
                <p><?= e($body) ?></p>
              </div>
            </li>
          <?php endforeach; ?>
        </ol>
      </div>

      <div class="cd-actions cd-actions--mid">
        <button class="cd-btn cd-btn--ghost" type="button"
                data-modal-open data-modal-service="Cloud &amp; DevOps">
          Book the 30-minute call<?= icon('arrow') ?>
        </button>
      </div>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           Why we are the better fit — six
           --------------------------------------------------------------- */ ?>
  <section class="cd-sec cd-fit">
    <div class="cd-shell">
      <div class="cd-head">
        <p class="cd-eyebrow"><span class="cd-mark" aria-hidden="true"></span>Why iThrive</p>
        <h2 class="cd-title">The infrastructure is<br>the means, not <em>the point</em></h2>
        <p class="cd-sub">
          Nobody buys cloud. What a business actually wants is that the product performs, ships
          quickly, scales without drama and does not become legacy again in three years. Cloud and
          DevOps is the mechanism; continuity, velocity and resilience are the thing being bought.
        </p>
      </div>

      <div class="cd-fit-grid">
        <?php foreach ($fit as $i => [$n, $title, $body]): ?>
          <article class="cd-fit-card" data-reveal style="--d:<?= $i % 3 ?>">
            <figure>
              <img src="<?= e($img('fit/' . $n . '.jpg')) ?>" width="760" height="480"
                   alt="" loading="lazy" decoding="async">
            </figure>
            <span class="cd-num"><?= e($n) ?></span>
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
  <section class="cd-sec cd-faq">
    <div class="cd-shell cd-faq-grid">
      <div class="cd-faq-side">
        <p class="cd-eyebrow"><span class="cd-mark" aria-hidden="true"></span>FAQ</p>
        <h2 class="cd-title">The questions worth<br><em>asking a cloud partner</em></h2>
        <figure class="cd-faq-art">
          <img src="<?= e($img('faq/01.jpg')) ?>" width="800" height="620"
               alt="" loading="lazy" decoding="async">
        </figure>
      </div>

      <div class="cd-faq-list">
        <?php foreach ($faqs as $i => [$q, $a]): ?>
          <details class="cd-faq-item"<?= $i === 0 ? ' open' : '' ?>>
            <summary><?= e($q) ?><span class="cd-faq-mark" aria-hidden="true"></span></summary>
            <div class="cd-faq-body"><p><?= e($a) ?></p></div>
          </details>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <?php /* ---------------------------------------------------------------
           Close
           --------------------------------------------------------------- */ ?>
  <section class="cd-close">
    <div class="cd-close-wash" aria-hidden="true"></div>
    <div class="cd-shell">
      <p class="cd-eyebrow"><span class="cd-mark" aria-hidden="true"></span>Next step</p>
      <h2>Want the cloud to evolve<br>as fast as <em>the product?</em></h2>
      <p class="cd-close-lead">
        Tell us what you run and which deploy most recently went wrong. You will get the account as
        we find it — over-provisioned, exposed or undocumented — with a phased plan and a budget
        range, including an honest note on anything we think is already fine.
      </p>
      <div class="cd-actions cd-actions--mid">
        <button class="cd-btn cd-btn--primary" type="button"
                data-modal-open data-modal-service="Cloud &amp; DevOps">
          Book the cloud review<?= icon('arrow') ?>
        </button>
      </div>
    </div>
  </section>

</div>

<script src="<?= e(asset('assets/js/cloud-page.js')) ?>" defer></script>

<?php
require dirname(__DIR__) . '/includes/footer.php';
