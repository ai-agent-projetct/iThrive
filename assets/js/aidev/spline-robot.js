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
   * Make him watch the whole page, not just his own corner.
   *
   * Spline normalises the pointer against the canvas rect. He now occupies the
   * right-hand side of the hero, so everywhere else — the headline, the prompt
   * bar, the buttons — is off that rect, the normalised value runs past the
   * range his look-at accepts, and he saturates. Measured: inside his box the
   * head swings [-0.09,-0.26] to [0.60,0.32]; across the entire left half of the
   * page it moved 0.02 and stared at the corner. That reads exactly as "the
   * mouse only works in the box", because effectively it did.
   *
   * So the real pointer is mapped from the viewport onto his rect and replayed
   * there. Wherever the cursor is on the page, he gets a proportional position
   * inside his own frame and turns to it — which is what the reference does.
   *
   * Notes on the mechanics:
   * - The canvas keeps its own pointer events, so the scene's built-in hover and
   *   click reactions still fire when you are actually over him.
   * - Replays are flagged and skipped on the way back in, or dispatching on the
   *   canvas would bubble to window and feed itself forever.
   * - Coalesced into one rAF, so a fast mouse costs one dispatch per frame
   *   rather than one per event.
   */
  function followWholePage() {
    let queued = 0;
    let px = 0;
    let py = 0;

    const replay = () => {
      queued = 0;
      const r = canvas.getBoundingClientRect();
      if (!r.width || !r.height) return;

      const x = r.left + (px / window.innerWidth) * r.width;
      const y = r.top + (py / window.innerHeight) * r.height;

      ['pointermove', 'mousemove'].forEach((type) => {
        const Ctor = type === 'pointermove' && window.PointerEvent ? PointerEvent : MouseEvent;
        const ev = new Ctor(type, {
          clientX: x, clientY: y, bubbles: true, cancelable: true,
          pointerType: 'mouse', view: window,
        });
        ev.spliceReplay = true;
        canvas.dispatchEvent(ev);
      });
    };

    window.addEventListener('pointermove', (e) => {
      if (e.spliceReplay) return;
      px = e.clientX;
      py = e.clientY;
      if (!queued) queued = requestAnimationFrame(replay);
    }, { passive: true });
  }

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
           * Colour, and the reason it is done to the light rather than to him.
           *
           * The scene is lit for a white studio, so on this page he was a black
           * shape with no edges. Painting the meshes brand-cyan does fix that —
           * I tried it — but a flat repaint throws away the gloss and the panel
           * seams that make him look machined, and it stops being the robot from
           * the reference.
           *
           * Tinting the light instead keeps the body black and lays cyan along
           * every edge it catches: shoulders, forearms, knees, the collar. He
           * reads immediately, he is the page's colour, and he is still himself.
           */
          const ACCENT = '#22D3EE';   // the page's primary accent
          const LIFT = 2.1;           // authored for white; this page is not

          app.getAllObjects().forEach((obj) => {
            if (!obj || !/light/i.test(obj.type || '')) return;
            try {
              obj.color = ACCENT;
              if (typeof obj.intensity === 'number') obj.intensity *= LIFT;
            } catch (e) {
              /* A scene without a settable light is simply left as authored. */
            }
          });

          mount.classList.add('is-live');
          // Handy for checking his rig from the console; nothing reads it.
          window.__splineRobot = app;
          followWholePage();
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
