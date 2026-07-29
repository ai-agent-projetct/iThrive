<?php
/**
 * Vertical, condensed variant of the 3-step pipeline for sidebars and
 * half-width columns.
 */

declare(strict_types=1);
?>
<div class="pipeline-mini">
  <?php foreach (PROCESS['steps'] as $step): ?>
    <div class="mini-step">
      <span class="mini-num"><?= e($step['number']) ?></span>
      <div>
        <h3><?= e($step['title']) ?></h3>
        <p><?= e($step['output']) ?></p>
      </div>
    </div>
  <?php endforeach; ?>
</div>
