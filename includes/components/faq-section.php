<?php
/**
 * A page's questions, rendered the way every FAQ on this site is rendered.
 *
 * The service pages grew their own copy of this markup inside
 * templates/service-detail.php, and then the case studies, the solutions and
 * the hub pages all needed the same thing. This is that markup, once.
 *
 * <details> rather than a scripted accordion, for the same reasons faq.php uses
 * it: it opens to find-in-page, it prints, it works before any JavaScript
 * arrives, and every answer sits in the DOM whether or not its panel is open —
 * which is what lets a crawler and an answer engine read the whole set.
 *
 * Expects:
 *   faqs    array of ['q' => string, 'a' => string]; nothing renders if empty
 *   eyebrow small label above the heading
 *   title   the heading
 *   lead    one line under it, optional
 *   id      section id, defaults to "faq" so #faq links land here
 */

declare(strict_types=1);

$faqs = $faqs ?? [];
if ($faqs === []) {
    return;
}

$eyebrow = $eyebrow ?? 'Questions';
$title   = $title ?? 'Frequently asked questions';
$lead    = $lead ?? '';
$id      = $id ?? 'faq';
?>
<section class="section" id="<?= e($id) ?>">
  <div class="shell">
    <?php component('section-head', array_filter([
        'eyebrow' => $eyebrow,
        'title'   => $title,
        'lead'    => $lead,
    ])); ?>

    <div class="faq-list">
      <?php foreach ($faqs as $i => $f): ?>
        <details class="faq-item"<?= $i === 0 ? ' open' : '' ?>>
          <summary>
            <span><?= e($f['q']) ?></span>
            <?= icon('chevron', 'icon faq-caret') ?>
          </summary>
          <p><?= e($f['a']) ?></p>
        </details>
      <?php endforeach; ?>
    </div>
  </div>
</section>
