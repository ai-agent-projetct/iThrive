<?php
/**
 * Testimonial carousel. Works without JavaScript as a vertical stack — main.js
 * upgrades it to a slider once it finds the `data-slider` hook.
 */

declare(strict_types=1);
?>
<div class="slider" data-slider>
  <div class="slider-viewport">
    <div class="slider-track" data-slider-track>
      <?php foreach (TESTIMONIALS as $t): ?>
        <div class="slider-slide">
          <figure class="quote-card">
            <span class="quote-mark"><?= icon('quote') ?></span>
            <blockquote class="quote-text">&ldquo;<?= e($t['quote']) ?>&rdquo;</blockquote>
            <figcaption>
              <div class="quote-name"><?= e($t['name']) ?></div>
              <div class="quote-role"><?= e($t['role']) ?></div>
            </figcaption>
          </figure>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

  <div class="slider-nav">
    <button class="slider-btn slider-btn--prev" type="button" data-slider-prev aria-label="Previous testimonial"><?= icon('arrow') ?></button>
    <div class="slider-dots" data-slider-dots></div>
    <button class="slider-btn" type="button" data-slider-next aria-label="Next testimonial"><?= icon('arrow') ?></button>
  </div>
</div>
