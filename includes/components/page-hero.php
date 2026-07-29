<?php
/**
 * Compact hero for every page other than the home page.
 *
 * @var string      $eyebrow
 * @var string      $title
 * @var string|null $lead
 * @var array|null  $crumb    ['label' => ..., 'href' => ...]
 * @var array|null  $actions  List of ['label', 'href'] — the first is primary.
 */

declare(strict_types=1);

$lead    = $lead    ?? null;
$crumb   = $crumb   ?? null;
$actions = $actions ?? null;
?>
<section class="hero hero--page">
  <div class="shell hero-inner">
    <div>
      <?php if ($crumb !== null): ?>
        <a class="btn-link btn-link--back" href="<?= e(url($crumb['href'])) ?>" style="margin-bottom:18px">
          <?= icon('arrow') ?><?= e($crumb['label']) ?>
        </a>
      <?php endif; ?>

      <p class="eyebrow" data-reveal><?= e($eyebrow) ?></p>
      <h1 class="hero-title" data-reveal style="--d:1"><?= e($title) ?></h1>
      <?php if ($lead !== null): ?>
        <p class="hero-lead" data-reveal style="--d:2"><?= e($lead) ?></p>
      <?php endif; ?>

      <?php if ($actions !== null): ?>
        <div class="hero-actions" data-reveal style="--d:3">
          <?php foreach ($actions as $i => $action): ?>
            <a class="btn <?= $i === 0 ? 'btn-primary' : 'btn-ghost' ?>" href="<?= e(url($action['href'])) ?>">
              <?= e($action['label']) ?><?= $i === 0 ? icon('arrow') : '' ?>
            </a>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>
