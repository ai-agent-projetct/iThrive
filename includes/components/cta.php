<?php
/**
 * Closing call-to-action panel.
 *
 * @var array $cta  eyebrow / title / body / primary / secondary
 */

declare(strict_types=1);

$cta = $cta ?? HOME_CTA;
?>
<section class="section">
  <div class="shell">
    <div class="cta-panel" data-reveal>
      <?php if (!empty($cta['eyebrow'])): ?>
        <p class="eyebrow" style="justify-content:center"><?= e($cta['eyebrow']) ?></p>
      <?php endif; ?>
      <h2 class="section-title"><?= e($cta['title']) ?></h2>
      <p><?= e($cta['body']) ?></p>

      <div class="cta-actions">
        <button class="btn btn-primary" type="button" data-modal-open>
          <?= e($cta['primary']['label']) ?><?= icon('arrow') ?>
        </button>
        <?php if (!empty($cta['secondary'])): ?>
          <a class="btn btn-ghost" href="<?= e(url($cta['secondary']['href'])) ?>"><?= e($cta['secondary']['label']) ?></a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
