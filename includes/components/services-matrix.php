<?php
/**
 * Tabbed services matrix. Falls back to the first group being visible when
 * JavaScript is unavailable, since `.is-active` is set server-side.
 */

declare(strict_types=1);
?>
<div data-tabs>
  <div class="svc-tabs" role="tablist" aria-label="Service groups">
    <?php foreach (SERVICES as $i => $group): ?>
      <button class="svc-tab<?= $i === 0 ? ' is-active' : '' ?>" type="button" role="tab"
              data-tab="<?= e($group['slug']) ?>" aria-selected="<?= $i === 0 ? 'true' : 'false' ?>">
        <?= icon($group['icon']) ?><?= e($group['title']) ?>
      </button>
    <?php endforeach; ?>
  </div>

  <?php foreach (SERVICES as $i => $group): ?>
    <div class="svc-panel<?= $i === 0 ? ' is-active' : '' ?>" data-panel="<?= e($group['slug']) ?>" role="tabpanel">
      <p class="svc-panel-lead"><?= e($group['lead']) ?></p>

      <div class="grid grid-3">
        <?php foreach ($group['items'] as $j => $item): ?>
          <?php component('service-card', ['item' => $item, 'index' => $j]); ?>
        <?php endforeach; ?>
      </div>
    </div>
  <?php endforeach; ?>
</div>
