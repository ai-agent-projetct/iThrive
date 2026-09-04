/**
 * Keep a WebGL hero from ever being an empty rectangle.
 *
 * Two of the bespoke service pages put a Framer WebGL component in the hero —
 * the PoC page's three.js cube and the ReactJS page's liquid-glass carousel.
 * Both compute everything they draw inside a requestAnimationFrame loop, so
 * until the first frame runs they paint nothing at all. The Dedicated Team
 * page had the same class of bug with a CSS component and it read, correctly,
 * as a broken hero.
 *
 * A frame normally does run. But "normally" covers a lot of ground: a tab
 * restored in the background, reduced-motion or battery-saver modes that
 * throttle rAF to nothing, a context lost on a machine with no GPU, an
 * embedded webview. In every one of those the hero is a hole in the page.
 *
 * So each of those heroes now carries a poster — the same content as flat
 * markup — which is what you see until the scene has genuinely drawn. The
 * poster is removed only on proof: a canvas exists, has real dimensions, and
 * at least two animation frames have actually elapsed. One frame is not proof;
 * a throttled tab can fire a single frame and then stop.
 *
 * Failing safe means leaving the poster up. If the check is wrong the visitor
 * sees flat cards instead of a moving scene, which is a far smaller problem
 * than the blank box this exists to prevent.
 */
(function () {
  'use strict';

  const hosts = Array.from(document.querySelectorAll('[data-webgl-poster]'));
  if (!hosts.length) return;

  /* Long enough for a scene to compile shaders and upload textures on a slow
     machine, short enough that nobody is left staring at a still. */
  const GIVE_UP_AFTER = 12000;

  /*
   * A canvas can exist, be the right size, and still be showing nothing.
   *
   * The clearest case is the brush-reveal logo: its canvas is filled with the
   * cover colour and only clears as the reveal animates, so handing over the
   * moment two frames had elapsed swapped a readable poster for a flat
   * near-black rectangle. A stage may therefore declare how long its content
   * needs before it is worth looking at, and the handover waits that out.
   */
  const dwellOf = (stage) => Number(stage.dataset.posterDwell || 0);

  for (const host of hosts) {
    const stage = host.querySelector('[data-webgl-stage]');
    if (!stage) continue;

    const started = Date.now();
    const dwell = dwellOf(stage);
    let frames = 0;

    const settle = () => {
      const canvas = stage.querySelector('canvas');
      const painted = canvas
        && canvas.width > 1
        && canvas.height > 1
        && frames >= 2
        && Date.now() - started >= dwell;

      if (painted) {
        host.classList.add('is-live');

        return;
      }

      if (Date.now() - started > GIVE_UP_AFTER) return;   /* poster stays */

      frames++;
      requestAnimationFrame(settle);
    };

    /* If rAF never fires, settle() never runs again and the poster simply
       stays — which is the whole point. */
    requestAnimationFrame(settle);
  }
}());
