<?php
/**
 * Web Universe — the 3D showcase in the web development hero.
 *
 * The mount point and script loader only; the scene itself is vanilla Three.js
 * in assets/js/web-universe.js, kept as a straight copy of the source so it can
 * be re-synced when that file changes.
 *
 * The data-wu hooks below are what the scene looks for. The standalone page's
 * "Web Universe / 3D Website Showcase" title block and FPS chip are left out:
 * inside a hero they read as a second heading competing with the real one.
 */

declare(strict_types=1);
?>
<div class="wu" data-web-universe>
  <div class="wu-glow" aria-hidden="true"></div>
  <div class="wu-stage" data-wu="canvas"></div>

  <div class="wu-loader" data-wu="loader" aria-hidden="true">
    <span class="wu-ring"></span>
  </div>

  <div class="wu-controls">
    <button type="button" class="wu-btn is-active" data-wu="btnRotate" title="Auto-rotate" aria-label="Toggle auto-rotate">&#10227;</button>
    <button type="button" class="wu-btn" data-wu="btnBurst" title="Pin sites open" aria-label="Pin sites open">&#10038;</button>
    <button type="button" class="wu-btn" data-wu="btnReset" title="Reset view" aria-label="Reset view">&#8962;</button>
  </div>

  <div class="wu-tooltip" data-wu="tooltip" aria-hidden="true">
    <span class="wu-t-name" data-wu="ttName"></span>
    <span class="wu-t-url" data-wu="ttUrl"></span>
  </div>

  <p class="wu-badge" data-wu="badge" aria-hidden="true">
    <span class="wu-pulse"></span>Zoom in to expand the sites &middot; drag to orbit &middot; click one
  </p>

  <?php /* The sites are drawn into WebGL, so nothing above is text a crawler
           can read. This is the same list in markup. */ ?>
  <ul class="sr-only">
    <li>Coonoor Club — coonorclub.com</li>
    <li>Cute Crew — cutecrew.in</li>
    <li>LogiSethu — logisethu.com</li>
    <li>Central Adventures — centraladv.in</li>
    <li>Aruvanaa — aruvanaa.com</li>
    <li>Madura Grandeur — maduragrandeur.com</li>
    <li>Bharani Beauty Clinic — bharanibeautyclinic.com</li>
    <li>Lotus Eye Hospital — lotuseye.org</li>
    <li>Drone World — thedroneworld.in</li>
    <li>Erode Public School — erodepublicschool.in</li>
  </ul>
</div>

<script>
(function () {
  var mount = document.querySelector('[data-web-universe] [data-wu="canvas"]');
  if (!mount) return;

  // Skipped where a heavy WebGL scene is unwanted or unaffordable.
  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    document.querySelector('[data-web-universe]').hidden = true;
    return;
  }

  var base = <?= json_encode(BASE_URL . '/') ?>;
  var files = [
    'assets/vendor/three128/three.min.js',
    'assets/vendor/three128/OrbitControls.js',
    'assets/js/web-universe.js'
  ];

  // Classic scripts, strictly in order — each depends on the one before, and a
  // parallel load would race OrbitControls ahead of THREE.
  files.reduce(function (chain, url) {
    return chain.then(function () {
      return new Promise(function (resolve, reject) {
        var found = document.querySelector('script[data-wu-src="' + url + '"]');
        if (found) {
          if (found.dataset.loaded) resolve();
          else found.addEventListener('load', function () { resolve(); }, { once: true });
          return;
        }
        var el = document.createElement('script');
        el.src = base + url;
        el.dataset.wuSrc = url;
        el.onload = function () { el.dataset.loaded = '1'; resolve(); };
        el.onerror = function () { reject(new Error('failed to load ' + url)); };
        document.head.appendChild(el);
      });
    });
  }, Promise.resolve())
    .then(function () { if (window.ithriveWebUniverse) window.ithriveWebUniverse(mount); })
    .catch(function () {
      // No WebGL, or a script blocked: drop the block rather than leave a hole.
      var host = document.querySelector('[data-web-universe]');
      if (host) host.hidden = true;
    });
})();
</script>
