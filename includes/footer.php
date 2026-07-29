<?php declare(strict_types=1); ?>
</main>

<footer class="site-footer">
  <div class="shell">
    <div class="footer-grid">
      <div class="footer-brand">
        <a class="brand" href="<?= e(url('index.php')) ?>" aria-label="<?= e(SITE_NAME) ?> home">
          <img class="brand-mark" src="<?= e(asset('assets/img/logo-mark.svg')) ?>" width="120" height="120" alt="">
          <span class="brand-text">
            <span class="brand-name">Ithrive</span>
            <span class="brand-sub">Software Solutions</span>
          </span>
        </a>
        <p>AI-powered, intelligent platforms built in Python. We bridge the gap between businesses and the customers they have not reached yet.</p>

        <div class="footer-contact">
          <a href="mailto:<?= e(SITE_EMAIL) ?>"><?= icon('mail') ?><?= e(SITE_EMAIL) ?></a>
          <a href="tel:<?= e(str_replace(' ', '', SITE_PHONE)) ?>"><?= icon('phone') ?><?= e(SITE_PHONE) ?></a>
          <span><?= icon('pin') ?><?= e(SITE_HQ) ?></span>
        </div>
      </div>

      <?php foreach (FOOTER_COLUMNS as $heading => $links): ?>
        <nav class="footer-col" aria-label="<?= e($heading) ?>">
          <h2 class="footer-head"><?= e($heading) ?></h2>
          <ul>
            <?php foreach ($links as $link): ?>
              <li><a href="<?= e(url($link['href'])) ?>"><?= e($link['label']) ?></a></li>
            <?php endforeach; ?>
          </ul>
        </nav>
      <?php endforeach; ?>
    </div>

    <div class="footer-base">
      <p>&copy; <?= e(SITE_YEAR) ?> <?= e(SITE_NAME) ?>. All rights reserved.</p>
      <p>Python &middot; Agentic AI &middot; Cloud Architecture</p>
    </div>
  </div>
</footer>

<?php component('contact-modal'); ?>

<?php if (!empty($heroScene)): ?>
<script type="module" src="<?= e(asset('assets/js/hero-scene.js')) ?>" data-scene="<?= e($heroScene) ?>"></script>
<?php endif; ?>
<script src="<?= e(asset('assets/js/main.js')) ?>" defer></script>
</body>
</html>
