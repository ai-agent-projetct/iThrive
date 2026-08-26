<?php declare(strict_types=1); ?>
</main>

<footer class="site-footer">
  <div class="shell">
    <div class="footer-grid">
      <div class="footer-brand">
        <a class="brand" href="<?= e(url('index.php')) ?>" aria-label="<?= e(SITE_NAME) ?> home">
          <img class="brand-mark" src="<?= e(asset('assets/img/logo-mark.png')) ?>" width="120" height="120" alt="" decoding="async">
          <span class="brand-text">
            <span class="brand-name">iThrive</span>
            <span class="brand-sub">Software</span>
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

<?php
component('contact-modal');
component('chat-widget');
?>

<?php if (!empty($heroScene)): ?>
<script type="module" src="<?= e(asset('assets/js/hero-scene.js')) ?>" data-scene="<?= e($heroScene) ?>"></script>
<?php endif; ?>
<?php /* robot.js builds its scene at module load, so it is imported only where a
         mount actually rendered — that keeps the 40KB off every other route.
         Gated on its own flag rather than on $heroScene, or a page with a robot
         and no hero scene silently gets no robot. */ ?>
<?php if (!empty($GLOBALS['ithrive_needs_robot'])): ?>
<script type="module">
  if (document.querySelector('[data-robot-canvas]')) {
    import('<?= e(asset('assets/js/robot.js')) ?>');
  }
</script>
<?php endif; ?>
<?php /* Eyes drawn onto the film's robot, on the pages that stage him. */ ?>
<?php if (!empty($GLOBALS['ithrive_needs_film_robot'])): ?>
<script src="<?= e(asset('assets/js/film-robot.js')) ?>" defer></script>
<?php endif; ?>
<script src="<?= e(asset('assets/js/main.js')) ?>" defer></script>
<script src="<?= e(asset('assets/js/chat.js')) ?>" defer></script>
<script src="<?= e(asset('assets/js/depth.js')) ?>" defer></script>
<?php /* The hexagon field is site-wide; it removes itself on touch and
         under reduced motion, and idles when the pointer stops. */ ?>
<script src="<?= e(asset('assets/js/hexbg.js')) ?>" defer></script>
<script src="<?= e(asset('assets/js/scrub.js')) ?>" defer></script>
<?php /* Loaded wherever components/watch-eyes.php actually rendered. */ ?>
<?php if (!empty($GLOBALS['ithrive_needs_eyes'])): ?>
<script src="<?= e(asset('assets/js/eyes.js')) ?>" defer></script>
<?php endif; ?>
<?php if ($page === 'home'): ?>
<script src="<?= e(asset('assets/js/warp.js')) ?>" defer></script>
<script src="<?= e(asset('assets/js/process-panels.js')) ?>" defer></script>
<script src="<?= e(asset('assets/js/round-carousel.js')) ?>" defer></script>
<script src="<?= e(asset('assets/js/entry-gate.js')) ?>" defer></script>
<script src="<?= e(asset('assets/js/tech-stack.js')) ?>" defer></script>
<script src="<?= e(asset('assets/js/tech-magnet.js')) ?>" defer></script>
<script src="<?= e(asset('assets/js/assistant.js')) ?>" defer></script>
<script src="<?= e(asset('assets/js/film.js')) ?>" defer></script>
<?php endif; ?>
</body>
</html>
