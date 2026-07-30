<?php
declare(strict_types=1);

$page      = 'company';
$pageTitle = 'Start Your Project — Contact Ithrive Software Solutions';
$pageDesc  = 'Tell Ithrive Software Solutions what you are trying to build or automate. You will get a written build plan — scope, stack and timeline — within two working days.';

require __DIR__ . '/includes/header.php';

$sent   = flash_take('sent');
$errors = flash_take('errors') ?? [];
$old    = flash_take('old') ?? [];

/** Service detail pages link here with ?service=<slug> to pre-select. */
$preselect = null;
if (!empty($_GET['service'])) {
    foreach (all_services() as $svc) {
        if ($svc['slug'] === $_GET['service']) {
            $preselect = $svc['title'];
            break;
        }
    }
}

component('page-hero', [
    'art'     => 'contact',
    'eyebrow' => 'Start Your Project',
    'title'   => 'Tell us what you are trying to automate.',
    'lead'    => 'Send a paragraph about the workflow that is slowing you down. A senior engineer reads every brief, and you will get scope, stack and a realistic timeline in writing within two working days.',
]);
?>

<section class="section section--flush-top">
  <div class="shell split">
    <div>
      <?php if ($sent): ?>
        <div class="alert alert--ok" role="status">
          <?= icon('check') ?>
          <div>
            <strong>Brief received.</strong> We have logged it and will come back to you within two working days.
            If it is urgent, email <?= e(SITE_EMAIL) ?> directly.
          </div>
        </div>
      <?php elseif ($errors): ?>
        <div class="alert alert--bad" role="alert">
          <?= icon('close') ?>
          <div>Something in the form needs fixing — the fields below are marked.</div>
        </div>
      <?php endif; ?>

      <?php component('contact-form', [
          'idPrefix' => 'page',
          'service'  => $preselect,
          'old'      => $old,
          'errors'   => $errors,
      ]); ?>
    </div>

    <aside class="detail-aside">
      <h2>Direct lines</h2>
      <dl class="detail-meta">
        <?php foreach (CONTACT_CHANNELS as $channel): ?>
          <div>
            <dt><?= e($channel['label']) ?></dt>
            <dd>
              <?php if ($channel['href'] !== null): ?>
                <a href="<?= e($channel['href']) ?>"><?= icon($channel['icon']) ?><?= e($channel['value']) ?></a>
              <?php else: ?>
                <?= e($channel['value']) ?>
              <?php endif; ?>
            </dd>
          </div>
        <?php endforeach; ?>
      </dl>

      <h2>What happens next</h2>
      <ul class="check-list" style="margin-top:0">
        <li><span class="check-dot"><?= icon('check') ?></span>A senior engineer reads your brief — not a sales inbox.</li>
        <li><span class="check-dot"><?= icon('check') ?></span>We reply with questions or a written build plan.</li>
        <li><span class="check-dot"><?= icon('check') ?></span>If we are the wrong fit, we say so and point you elsewhere.</li>
      </ul>
    </aside>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
