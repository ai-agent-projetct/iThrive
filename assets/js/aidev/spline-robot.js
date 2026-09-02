/**
 * The hero robot: the Spline scene itself, not a rebuild of it.
 *
 * The reference (splinerobot.framer.website) is a Spline scene, so the only way
 * to have "the same robot with the same functionality" is to run the same
 * scene — the rig, the materials and the cursor-following behaviour are all
 * baked into it, and a hand-written three.js lookalike is a different robot that
 * merely resembles this one.
 *
 * Scene and runtime are both vendored under assets/vendor/spline rather than
 * pulled from Spline's CDN at page load: hot-linking someone else's scene means
 * the hero breaks the day they move it, and it puts our traffic on their
 * bandwidth. See the page for the provenance note.
 *
 * Colour: the scene is authored for a white studio, and this page is nearly
 * black — a glossy black robot on it is a silhouette. Rather than recolour him
 * into a different robot, the lights are lifted so his gloss and the dot-matrix
 * eyes carry the form, and the page puts a brand-coloured wash behind him for
 * the silhouette to sit against. He stays the robot from the reference.
 *
 * Degrades: no WebGL, reduced motion, or a failed load all leave the poster
 * still that the markup already carries. Nothing here is load-bearing.
 */

(function () {
  'use strict';

  const mount = document.getElementById('spline-robot');
  if (!mount) return;

  const canvas = mount.querySelector('canvas');
  if (!canvas) return;

  // A 3.5MB scene and runtime is not worth fetching for someone who has asked
  // for less motion, or for a browser that cannot draw it.
  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
  try {
    const probe = document.createElement('canvas');
    if (!(probe.getContext('webgl2') || probe.getContext('webgl'))) return;
  } catch (e) {
    return;
  }

  const RUNTIME = mount.dataset.runtime;
  const SCENE = mount.dataset.scene;
  if (!RUNTIME || !SCENE) return;

  /*
   * Only load once he is near the viewport. He is the hero, so that is almost
   * immediately — but it keeps the scene off the wire for anyone who lands deep
   * in the page from a link, and it means the fetch never competes with the
   * rest of the hero painting.
   */
  const start = () => {
    import(RUNTIME)
      .then(({ Application }) => {
        const app = new Application(canvas);

        return app.load(SCENE).then(() => {
          /*
           * Lift the scene's own lights. Authored against white, they leave him
           * unreadable on this background; this is the smallest change that
           * makes him legible without touching what he is.
           */
          ['Point Light', 'Directional Light', 'Spot Light'].forEach((name) => {
            const light = app.findObjectByName(name);
            if (light && typeof light.intensity === 'number') {
              light.intensity = light.intensity * 1.9;
            }
          });

          mount.classList.add('is-live');
          return app;
        });
      })
      .catch((err) => {
        // The poster underneath is already the fallback; just say why.
        console.warn('[spline-robot] scene did not load:', err);
      });
  };

  if ('IntersectionObserver' in window) {
    const io = new IntersectionObserver((entries) => {
      if (entries.some((e) => e.isIntersecting)) {
        io.disconnect();
        start();
      }
    }, { rootMargin: '200px' });
    io.observe(mount);
  } else {
    start();
  }
})();
