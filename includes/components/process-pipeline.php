<?php
/**
 * The 3-step execution pipeline: Discovery -> Clarity -> Execution.
 */

declare(strict_types=1);
?>
<div class="pipeline">
  <?php foreach (PROCESS['steps'] as $i => $step): ?>
    <article class="step" id="<?= e($step['key']) ?>" data-reveal style="--d:<?= $i ?>">
      <div class="step-num"><?= e($step['number']) ?></div>
      <span class="step-icon"><?= icon($step['icon']) ?></span>
      <h3><?= e($step['title']) ?></h3>
      <p><?= e($step['body']) ?></p>

      <ul class="step-points">
        <?php foreach ($step['points'] as $point): ?>
          <li><?= icon('check') ?><?= e($point) ?></li>
        <?php endforeach; ?>
      </ul>

      <p class="step-output"><b>You walk away with</b><?= e($step['output']) ?></p>
    </article>
  <?php endforeach; ?>
</div>
