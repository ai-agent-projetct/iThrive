<?php
/**
 * @var string      $eyebrow
 * @var string      $title
 * @var string|null $lead
 * @var bool        $left   Left-align instead of centring.
 */

declare(strict_types=1);

$lead = $lead ?? null;
$left = $left ?? false;
?>
<div class="section-head<?= $left ? ' section-head--left' : '' ?>">
  <?php if (!empty($eyebrow)): ?><p class="eyebrow" data-reveal><?= e($eyebrow) ?></p><?php endif; ?>
  <h2 class="section-title" data-reveal style="--d:1"><?= e($title) ?></h2>
  <?php if ($lead !== null): ?><p class="section-lead" data-reveal style="--d:2"><?= e($lead) ?></p><?php endif; ?>
</div>
