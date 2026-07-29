<?php
declare(strict_types=1);

$page      = 'company';
$pageTitle = 'Careers — Senior engineers, real scope | Ithrive Software Solutions';
$pageDesc  = 'Ithrive Software Solutions hires senior Python, AI/ML, React and DevOps engineers who want to own a problem end to end rather than work a ticket queue.';

require dirname(__DIR__) . '/includes/header.php';

component('page-hero', [
    'eyebrow' => CAREERS['eyebrow'],
    'title'   => CAREERS['title'],
    'lead'    => CAREERS['lead'],
]);
?>

<section class="section section--flush-top">
  <div class="shell">
    <div class="grid grid-4">
      <?php foreach (CAREERS['perks'] as $i => $perk): ?>
        <?php component('feature-card', ['item' => $perk, 'index' => $i]); ?>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section section--panel">
  <div class="shell">
    <?php component('section-head', [
        'eyebrow' => 'Open Roles',
        'title'   => 'Four seats we are actively filling',
        'lead'    => 'No role here is a ticket queue. You will talk to clients, own architecture decisions, and be accountable for something running in production.',
    ]); ?>

    <div class="grid" style="gap:16px">
      <?php foreach (CAREERS['roles'] as $i => $role): ?>
        <article class="card role-card" data-reveal style="--d:<?= $i ?>">
          <div>
            <h3 class="role-title"><?= e($role['title']) ?></h3>
            <ul class="role-meta">
              <li class="tag tag--cyan"><?= e($role['type']) ?></li>
              <li class="tag"><?= e($role['location']) ?></li>
            </ul>
            <p class="role-body"><?= e($role['body']) ?></p>
          </div>

          <a class="btn btn-ghost" href="mailto:<?= e(SITE_EMAIL) ?>?subject=<?= e(rawurlencode('Application — ' . $role['title'])) ?>">
            Apply by email<?= icon('arrow') ?>
          </a>
        </article>
      <?php endforeach; ?>
    </div>

    <p class="section-lead" data-reveal style="text-align:center;margin:38px auto 0">
      Nothing listed that fits? Send your work to <a class="btn-link" href="mailto:<?= e(SITE_EMAIL) ?>"><?= e(SITE_EMAIL) ?></a>
      anyway — we read every one, and we have hired off the back of a good repository more than once.
    </p>
  </div>
</section>

<?php
component('cta', ['cta' => [
    'eyebrow'   => 'Work With Us',
    'title'     => 'Or come to us as a client instead.',
    'body'      => 'If you are here because you liked how we describe engineering, that usually means we would build well for you too.',
    'primary'   => ['label' => 'Start Your Project', 'href' => 'contact.php'],
    'secondary' => ['label' => 'How we work', 'href' => 'company/process.php'],
]]);

require dirname(__DIR__) . '/includes/footer.php';
