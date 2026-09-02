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
   * TWO SOURCES OF TRUTH WAS THE BUG. The canvas also received the real pointer
   * natively whenever the cursor was over it, so the scene got both positions,
   * alternating every frame. Logged, dragging across the page:
   *
   *     1200(real) 1416(mapped) 1240(real) 1434(mapped) 1280(real) ...
   *
   * — two targets 215px apart, sixty times a second. Over him it juddered; off
   * him only the mapped one arrived and it moved cleanly, so the two halves of
   * the page behaved differently and the far side read as lag. The native
   * pointermove is now stopped before it reaches the canvas, so exactly one
   * position drives him, everywhere.
   *
   * Notes on the mechanics:
   * - Only `pointermove`/`mousemove` are blocked. down, up, click and over still
   *   reach the canvas, so the scene's own click reaction survives.
   * - Blocking happens in the capture phase on the mount, which the event passes
   *   through on its way down. Doing it on the canvas itself is unreliable: at
   *   the target, listeners run in registration order regardless of the capture
   *   flag, so the scene's own handler could still go first.
   * - Replays are flagged and skipped on the way back in, or dispatching on the
   *   canvas would feed itself forever.
   * - The position is eased toward the pointer rather than snapped to it, and
   *   the loop keeps running for a moment after the mouse stops so the motion
   *   settles instead of halting. This is what actually makes it smooth.
   * - The loop idles when he is off screen, and stops once it has caught up.
   */
  function followWholePage() {
    /* How hard the aim is pulled toward the cursor each frame. Low is smooth
       and trailing, high is snappy and abrupt; this is the compromise. */
    const EASE = 0.16;
    /* Below this many pixels the aim has arrived and the loop can stop. */
    const SETTLED = 0.4;

    let raf = 0;
    let onScreen = true;
    let havePointer = false;
    let targetX = 0, targetY = 0;   // where the cursor actually is
    let aimX = 0, aimY = 0;         // where he is currently looking

    /* One source of truth: the scene never sees the raw pointer. */
    ['pointermove', 'mousemove'].forEach((type) => {
      mount.addEventListener(type, (e) => {
        if (!e.spliceReplay) e.stopPropagation();
      }, true);
    });

    const send = (x, y) => {
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

    const frame = () => {
      const r = canvas.getBoundingClientRect();
      if (!r.width || !r.height) { raf = 0; return; }

      aimX += (targetX - aimX) * EASE;
      aimY += (targetY - aimY) * EASE;

      send(
        r.left + (aimX / window.innerWidth) * r.width,
        r.top + (aimY / window.innerHeight) * r.height
      );

      // Keep going until the aim has caught up with the cursor.
      if (Math.abs(targetX - aimX) < SETTLED && Math.abs(targetY - aimY) < SETTLED) {
        aimX = targetX;
        aimY = targetY;
        raf = 0;
        return;
      }
      raf = requestAnimationFrame(frame);
    };

    const wake = () => {
      if (!raf && onScreen && havePointer) raf = requestAnimationFrame(frame);
    };

    window.addEventListener('pointermove', (e) => {
      if (e.spliceReplay) return;
      targetX = e.clientX;
      targetY = e.clientY;
      if (!havePointer) {           // first sighting: start from where he is
        havePointer = true;
        aimX = targetX;
        aimY = targetY;
      }
      wake();
      /* CAPTURE, and it has to be. The mount's own capture listener above stops
         native pointermove so the scene cannot see it — and propagation stopped
         there never bubbles back to window, so a bubble-phase listener here
         would go deaf the moment the cursor was over him. Window capture is the
         first step of the journey, before anything can stop it. */
    }, { passive: true, capture: true });

    if ('IntersectionObserver' in window) {
      new IntersectionObserver(([entry]) => {
        onScreen = entry.isIntersecting;
        if (onScreen) wake();
      }, { threshold: 0 }).observe(mount);
    }
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

          /*
           * The head, and why this one colour.
           *
           * `color` is the material's albedo — the gloss lives in its roughness
           * and its reflections, which this does not touch. So a DARK, saturated
           * value tints the visor while the highlight sweeping its crown and the
           * reflection down its face survive: it reads as coloured glass. A
           * bright one does not. Tried on the way here: #22D3EE turned the shell
           * into flat cyan plastic and the depth vanished, and #8B2FC9 was not
           * much better. This is dark enough to stay glass.
           *
           * Violet against the cyan the lights lay on his body is the headline's
           * own gradient, which runs cyan to violet directly above him.
           *
           * `Head 2` is the shell mesh; `Head` is the empty that parents it and
           * has no material of its own.
           */
          const HEAD_GLASS = '#2A1B5E';

          app.getAllObjects().forEach((obj) => {
            if (obj && obj.name === 'Head 2' && obj.type === 'Mesh') {
              try {
                obj.color = HEAD_GLASS;
              } catch (e) {
                /* Leave the head as authored rather than fail the whole scene. */
              }
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
