<?php
/**
 * Optional Spline 3D scene for the home hero.
 *
 * Spline only serves a scene to the public once it has been exported — the
 * editor URL (app.spline.design/file/…) is account-gated and returns 403 to
 * anyone else. So this component renders only when SPLINE_SCENE is set to a
 * published runtime URL; otherwise index.php keeps the Three.js neural hero.
 *
 * To switch it on:
 *   1. Open the scene in Spline → Export → Code → Public URL / Viewer.
 *   2. Copy the .splinecode URL (looks like
 *      https://prod.spline.design/<id>/scene.splinecode).
 *   3. Set SPLINE_SCENE in includes/config.php to that URL.
 *
 * The <spline-viewer> element streams the scene itself, so nothing is bundled
 * and the page still renders if Spline is unreachable.
 */

declare(strict_types=1);

if (!defined('SPLINE_SCENE') || SPLINE_SCENE === '') {
    return;
}
?>
<div class="spline-stage" id="splineStage" data-spline>
  <!-- Held back until the viewer signals it has loaded, so visitors never see
       a blank rectangle while the scene streams in. -->
  <div class="spline-fallback" aria-hidden="true">
    <div class="hero-orb"></div>
  </div>

  <spline-viewer
    url="<?= e(SPLINE_SCENE) ?>"
    loading-anim-type="none"
    events-target="global"
    role="img"
    aria-label="An interactive 3D scene representing Ithrive's AI platform engineering."></spline-viewer>
</div>

<script type="module"
        src="https://unpkg.com/@splinetool/viewer@1.9.48/build/spline-viewer.js"
        crossorigin="anonymous"></script>
