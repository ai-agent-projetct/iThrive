<?php
/**
 * @var array $stats  List of value / label pairs.
 */

declare(strict_types=1);

$stats = $stats ?? HOME_STATS_BAND;
?>
<div class="stats-band" data-reveal>
  <?php foreach ($stats as $stat): ?>
    <div class="stat-cell">
      <div class="stat-value"><?= e($stat['value']) ?></div>
      <div class="stat-label"><?= e($stat['label']) ?></div>
    </div>
  <?php endforeach; ?>
</div>
