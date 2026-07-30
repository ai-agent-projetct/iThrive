<?php
/**
 * Infinite client strip. The track is duplicated so the CSS translate of -50%
 * lands exactly on a seam.
 */

declare(strict_types=1);

$clients = CASE_STUDIES;
?>
<div class="marquee" role="region" aria-label="Clients we have built for">
  <div class="marquee-track">
    <?php for ($pass = 0; $pass < 2; $pass++): ?>
      <?php foreach ($clients as $client): ?>
        <a class="marquee-item" href="<?= e(url('case-studies/' . $client['slug'] . '.php')) ?>"
           title="<?= e($client['client']) ?>"
           <?= $pass === 1 ? 'aria-hidden="true" tabindex="-1"' : '' ?>>
          <?= client_logo($client) ?>
        </a>
      <?php endforeach; ?>
    <?php endfor; ?>
  </div>
</div>
