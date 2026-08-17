/**
 * Eyes that follow the cursor.
 *
 * Drives every `[data-eyes]` on the page — the home page's entry gate and the
 * 404 — by translating the `[data-eyes-iris]` groups inside it. The lens clips
 * each iris, so this only has to aim; it can never push a pupil outside its eye.
 *
 * The motion is a spring, not a lerp. A lerp arrives at the target and stops
 * dead, which reads as mechanical. The small overshoot a spring gives is what
 * makes an eye look like it flicked to something.
 *
 * Skipped under prefers-reduced-motion, where the mark simply sits still.
 */

(function () {
  'use strict';

  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

  const marks = Array.from(document.querySelectorAll('[data-eyes]'));
  if (!marks.length) return;

  // Travel in the SVG's own viewBox units.
  const REACH = 15;

  const rigs = marks.map((svg) => ({
    svg,
    lids: svg.querySelector('[data-eyes-lids]'),
    irises: Array.from(svg.querySelectorAll('[data-eyes-iris]')).map((g) => ({
      g, x: 0, y: 0, vx: 0, vy: 0, tx: 0, ty: 0,
    })),
  })).filter((r) => r.irises.length);

  if (!rigs.length) return;

  let pointerSeen = false;

  function aim(cx, cy) {
    pointerSeen = true;
    for (const rig of rigs) {
      for (const iris of rig.irises) {
        const r = iris.g.getBoundingClientRect();
        // A hidden or detached mark measures zero; leave its aim alone.
        if (!r.width) continue;

        const dx = cx - (r.left + r.width / 2);
        const dy = cy - (r.top + r.height / 2);
        const d = Math.hypot(dx, dy) || 1;

        // Damped by distance, so a cursor parked far away does not peg the eyes
        // at full deflection and hold them there.
        const pull = Math.min(1, d / 420);
        iris.tx = (dx / d) * REACH * pull;
        iris.ty = (dy / d) * REACH * pull * 0.78;
      }
    }
  }

  function frame() {
    requestAnimationFrame(frame);

    for (const rig of rigs) {
      if (!rig.svg.isConnected) continue;

      for (const iris of rig.irises) {
        // Stiffness pulls toward the target; damping bleeds the overshoot.
        iris.vx = (iris.vx + (iris.tx - iris.x) * 0.14) * 0.76;
        iris.vy = (iris.vy + (iris.ty - iris.y) * 0.14) * 0.76;
        iris.x += iris.vx;
        iris.y += iris.vy;
        iris.g.setAttribute('transform', `translate(${iris.x.toFixed(2)} ${iris.y.toFixed(2)})`);
      }
    }
  }

  window.addEventListener('pointermove', (e) => aim(e.clientX, e.clientY), { passive: true });

  // Nothing has moved yet, so look around rather than stare blankly.
  const wander = setInterval(() => {
    if (pointerSeen) { clearInterval(wander); return; }
    aim(
      window.innerWidth / 2 + (Math.random() - 0.5) * window.innerWidth * 0.8,
      window.innerHeight / 2 + (Math.random() - 0.5) * window.innerHeight * 0.6
    );
  }, 1400);

  setInterval(() => {
    for (const rig of rigs) {
      if (!rig.lids || !rig.svg.isConnected) continue;
      rig.lids.classList.add('watch-lids--shut');
      setTimeout(() => rig.lids.classList.remove('watch-lids--shut'), 130);
    }
  }, 4600);

  requestAnimationFrame(frame);
})();
