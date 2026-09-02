<?php declare(strict_types=1); ?>

<?php
/*
 * iThrive AI, on every page.
 *
 * The assistant used to sit on the home page alone. It is the same grounded
 * agent the chat widget talks to, it already answers in six languages, and it
 * already speaks through handlers/tts.php rather than relying on a voice being
 * installed on the device — so there was no reason for it to be reachable from
 * one route out of thirty.
 *
 * Rendered here, inside <main>, so it is the last thing on every page before
 * the footer. The home page composes it itself, higher up where it belongs in
 * that page's argument, so it is skipped here to avoid a second copy and a
 * duplicate id. Any route that does not want it sets $noAssistant before
 * including this file.
 */
if (($page ?? '') !== 'home' && empty($noAssistant)) {
    component('ai-assistant');
    // Tells the script block below to bring its behaviour and its orb.
    $GLOBALS['ithrive_has_assistant'] = true;
}
?>
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

<?php /* The orb. hero-scene.js draws it into [data-orb-canvas], which is the
         assistant's face as well as the home hero's — so it is needed wherever
         the assistant rendered, not only where a page asked for a hero scene.
         Without it the CSS orb stands in, which is why nothing here is gated on
         WebGL. */ ?>
<?php $orbScene = $heroScene ?? (!empty($GLOBALS['ithrive_has_assistant']) ? 'neural' : ''); ?>
<?php if (!empty($orbScene)): ?>
<script type="module" src="<?= e(asset('assets/js/hero-scene.js')) ?>" data-scene="<?= e($orbScene) ?>"></script>
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
<?php /* The staged, scroll-driven layer and its two 3D pieces. Scoped to the
         pages that opt in, so no other route pays for them. */ ?>
<?php if (($bodyClass ?? '') === 'lusion'): ?>
<script src="<?= e(asset('assets/js/lusion-stage.js')) ?>" defer></script>
<script src="<?= e(asset('assets/js/word-globe.js')) ?>" defer></script>
<script type="module" src="<?= e(asset('assets/js/object-field.js')) ?>"></script>
<?php /* Origin Kit's components are React, as the registry ships them, so they
         come in as an island bundle — see app/originkit. */ ?>
<script type="module" src="<?= e(asset('assets/dist/originkit/originkit.js')) ?>"></script>
<?php endif; ?>

<script src="<?= e(asset('assets/js/main.js')) ?>" defer></script>
<script src="<?= e(asset('assets/js/chat.js')) ?>" defer></script>
<script src="<?= e(asset('assets/js/depth.js')) ?>" defer></script>
<?php /* The hexagon field is site-wide; it removes itself on touch and
         under reduced motion, and idles when the pointer stops. */ ?>
<script src="<?= e(asset('assets/js/hexbg.js')) ?>" defer></script>
<script src="<?= e(asset('assets/js/scrub.js')) ?>" defer></script>
<?php /* The assistant's behaviour, wherever it rendered — the home page's own
         copy included. */ ?>
<?php if (($page ?? '') === 'home' || !empty($GLOBALS['ithrive_has_assistant'])): ?>
<script src="<?= e(asset('assets/js/assistant.js')) ?>" defer></script>
<?php endif; ?>
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
<script src="<?= e(asset('assets/js/film.js')) ?>" defer></script>
<?php endif; ?>
</body>
</html>
