<?php
/**
 * Case study grid tile with its device mock preview.
 *
 * @var array $study
 * @var int   $index
 */

declare(strict_types=1);

$index = $index ?? 0;
?>
<div class="case-card is-shown"
     data-categories="<?= e(implode(' ', $study['categories'])) ?>"
     data-reveal style="--d:<?= (int) $index ?>">
  <article class="card" style="--accent: <?= e($study['accent']) ?>">
    <div class="case-mock">
      <?php component('mock-window', ['study' => $study, 'compact' => true]); ?>
    </div>

    <p class="case-industry"><?= icon($study['icon']) ?><?= e($study['industry']) ?></p>
    <h3 class="case-title"><?= e($study['title']) ?></h3>
    <p class="case-headline"><?= e($study['headline']) ?></p>

    <ul class="tag-row">
      <?php foreach (array_slice($study['stack'], 0, 4) as $tag): ?><li class="tag"><?= e($tag) ?></li><?php endforeach; ?>
    </ul>

    <div class="case-foot">
      <a class="btn-link" href="<?= e(url('case-studies/' . $study['slug'] . '.php')) ?>">
        Read the case study<?= icon('arrow') ?>
      </a>
    </div>
  </article>
</div>
