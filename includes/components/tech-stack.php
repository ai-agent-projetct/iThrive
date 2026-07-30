<?php
/**
 * Interactive tech stack.
 *
 * An orbital canvas where every technology is a node you can drag, hover and
 * filter, backed by a real categorised list. The list is the markup that ships;
 * tech-stack.js promotes it to the canvas, so with JavaScript off — or on a
 * screen reader — this is still a complete, readable tech stack section.
 */

declare(strict_types=1);

$groups = TECH_STACK;
$total  = array_sum(array_map(static fn (array $g): int => count($g['items']), $groups));
?>
<div class="techstack" data-techstack>
  <div class="tech-tabs" role="tablist" aria-label="Technology categories">
    <button class="tech-tab is-active" type="button" data-tech-filter="all" aria-selected="true">
      All <span class="tech-count"><?= (int) $total ?></span>
    </button>
    <?php foreach ($groups as $g): ?>
      <button class="tech-tab" type="button" data-tech-filter="<?= e($g['slug']) ?>" aria-selected="false">
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
      <section class="tech-group" data-tech-group="<?= e($g['slug']) ?>" data-reveal style="--d:<?= $i % 3 ?>">
        <header class="tech-group-head">
          <span class="tech-group-icon"><?= icon($g['icon']) ?></span>
          <div>
            <h3><?= e($g['title']) ?></h3>
            <p><?= e($g['blurb']) ?></p>
          </div>
        </header>

        <ul class="tech-list">
          <?php foreach ($g['items'] as $item): ?>
            <li class="tech-chip"
                data-tech-name="<?= e($item['name']) ?>"
                data-tech-hue="<?= (int) $item['hue'] ?>"
                data-tech-cat="<?= e($g['slug']) ?>"
                data-tech-group-title="<?= e($g['title']) ?>"
                style="--hue: <?= (int) $item['hue'] ?>">
              <?= e($item['name']) ?>
            </li>
          <?php endforeach; ?>
        </ul>
      </section>
    <?php endforeach; ?>
  </div>
</div>
