<?php
/**
 * Interactive tech stack.
 *
 * One category is shown at a time — there is no "all" view, so picking
 * "AI & Machine Learning" shows that group's technologies and nothing else.
 * The first group is active server-side, so the section is correct before any
 * JavaScript runs; tech-stack.js then promotes it to an orbital field.
 */

declare(strict_types=1);

$groups = TECH_STACK;
?>
<div class="techstack" data-techstack data-tech-base="<?= e(url('assets/img/tech/')) ?>">
  <div class="tech-tabs" role="tablist" aria-label="Technology categories">
    <?php foreach ($groups as $i => $g): ?>
      <button class="tech-tab<?= $i === 0 ? ' is-active' : '' ?>" type="button" role="tab"
              data-tech-filter="<?= e($g['slug']) ?>"
              aria-selected="<?= $i === 0 ? 'true' : 'false' ?>">
        <?= icon($g['icon']) ?><?= e($g['title']) ?>
        <span class="tech-count"><?= count($g['items']) ?></span>
      </button>
    <?php endforeach; ?>
  </div>

  <div class="tech-stage">
    <!-- Promoted to an interactive orbit by tech-stack.js. -->
    <div class="tech-orbit" data-tech-orbit aria-hidden="true"></div>

    <div class="tech-readout" data-tech-readout hidden>
      <p class="tech-readout-name"></p>
      <p class="tech-readout-group"></p>
    </div>
  </div>

  <div class="tech-groups" data-tech-groups>
    <?php foreach ($groups as $i => $g): ?>
      <section class="tech-group" data-tech-group="<?= e($g['slug']) ?>"
               <?= $i === 0 ? '' : 'hidden' ?>>
        <header class="tech-group-head">
          <span class="tech-group-icon"><?= icon($g['icon']) ?></span>
          <div>
            <h3><?= e($g['title']) ?></h3>
            <p><?= e($g['blurb']) ?></p>
          </div>
        </header>

        <ul class="tech-list">
          <?php foreach ($g['items'] as $item): ?>
            <li class="tech-tile"
                data-tech-name="<?= e($item['name']) ?>"
                data-tech-logo="<?= e($item['logo']) ?>"
                data-tech-cat="<?= e($g['slug']) ?>"
                data-tech-group-title="<?= e($g['title']) ?>">
              <img src="<?= e(asset('assets/img/tech/' . $item['logo'] . '.svg')) ?>"
                   alt="" width="28" height="28" loading="lazy" decoding="async">
              <span><?= e($item['name']) ?></span>
            </li>
          <?php endforeach; ?>
        </ul>
      </section>
    <?php endforeach; ?>
  </div>
</div>
