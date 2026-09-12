<?php
/**
 * The 3-step execution pipeline: Discovery -> Clarity -> Execution.
 */

declare(strict_types=1);
?>
<div class="pipeline">
  <?php
  $isServicesPage = ($page ?? '') === 'services' || str_contains($_SERVER['REQUEST_URI'] ?? '', 'services.php');
  $stepPhotos = $isServicesPage ? [
      'discovery' => 'assets/img/services-page/process-deliver.jpg',
      'clarity'   => 'assets/img/services-page/process-scale.jpg',
      'execution' => 'assets/img/services-page/process-quality.jpg',
  ] : [
      'discovery' => 'assets/img/pages/process-workshop.jpg',
      'clarity'   => 'assets/img/pages/process-sprint-board.jpg',
      'execution' => 'assets/img/pages/process-pipeline.jpg',
  ];
  ?>
  <?php foreach (PROCESS['steps'] as $i => $step): ?>
    <article class="step" id="<?= e($step['key']) ?>" data-reveal style="--d:<?= $i ?>">
      <?php if (!empty($stepPhotos[$step['key']])): ?>
        <figure style="border-radius: 12px; overflow: hidden; margin-bottom: 20px; aspect-ratio: 16/9; border: 1px solid var(--line); background: var(--glass-hi);">
          <img src="<?= e(asset($stepPhotos[$step['key']])) ?>" width="600" height="338" alt="<?= e($step['title']) ?>" style="width: 100%; height: 100%; object-fit: cover; display: block;" loading="lazy" decoding="async">
        </figure>
      <?php endif; ?>
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
