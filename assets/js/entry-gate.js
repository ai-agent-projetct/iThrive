/**
 * Entry gate behaviour — eyes that follow the cursor, and the door.
 *
 * The gate is `hidden` in the markup and only ever revealed from here. That
 * ordering is deliberate: if this script fails to load, or WebGL/JS is off, or
 * the browser is a crawler that does not run scripts, the page is simply the
 * page. Nothing is gated by something that might not run.
 *
 * The pupils use a spring rather than a lerp. A lerp reaches the target and
 * stops dead, which reads as mechanical; the small overshoot from a spring is
 * what makes an eye look like it flicked to something.
 */

(function () {
  'use strict';

  const gate = document.querySelector('[data-gate]');
  if (!gate) return;

  // A decorative interstitial is exactly what this setting is asking us to skip.
  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

  /**
   * Ask once, then leave people alone for half a day.
   *
   * sessionStorage was the first instinct and it is wrong: it is scoped per tab,
   * so opening the site in a second tab gates you again, which is exactly the
   * behaviour that makes an intro feel like an obstacle. localStorage with a
   * window means a first-time visitor gets the intro, someone browsing the site
   * and coming back does not, and a genuinely new visit tomorrow does.
   */
  const KEY = 'ithrive-gate-seen';
  const WINDOW = 12 * 60 * 60 * 1000;
  try {
    const at = Number(localStorage.getItem(KEY) || 0);
    if (at && Date.now() - at < WINDOW) return;
  } catch (e) { /* storage blocked — show it, the gate is dismissible anyway */ }

  const irises = Array.from(gate.querySelectorAll('[data-gate-iris]'));
  const lids = gate.querySelector('[data-gate-lids]');
  const enter = gate.querySelector('[data-gate-enter]');
  const skip = gate.querySelector('[data-gate-skip]');

  /**
   * Promote to a direct child of <body> before showing it.
   *
   * The stylesheet gives every body child `position: relative; z-index: 1`, so
   * <main> is a stacking context and anything inside it is capped at that layer
   * — the gate's z-index of 300 could not get above the header's 90 while it
   * lived in the page body. Moving it is safe here because the element does
   * nothing at all until this script touches it.
   */
  document.body.appendChild(gate);

  gate.hidden = false;
  document.documentElement.classList.add('gate-open');
  requestAnimationFrame(() => gate.classList.add('gate--in'));
  if (enter) enter.focus({ preventScroll: true });

  /* ---- the watching ---------------------------------------------------- */

  // Travel is in the SVG's own units, and stays inside the lens because each
  // iris is clipped by its eye.
  const REACH = 15;

  const eye = irises.map(() => ({ x: 0, y: 0, vx: 0, vy: 0, tx: 0, ty: 0 }));
  let pointerSeen = false;
  let raf = 0;

  function aim(cx, cy) {
    pointerSeen = true;
    irises.forEach((g, i) => {
      const r = g.getBoundingClientRect();
      const dx = cx - (r.left + r.width / 2);
      const dy = cy - (r.top + r.height / 2);
      const d = Math.hypot(dx, dy) || 1;
      // Normalised direction, damped by distance so a cursor parked far away
      // does not peg the eyes at full deflection forever.
      const pull = Math.min(1, d / 420);
      eye[i].tx = (dx / d) * REACH * pull;
      eye[i].ty = (dy / d) * REACH * pull * 0.78;
    });
  }

  function frame() {
    raf = requestAnimationFrame(frame);

    for (let i = 0; i < irises.length; i++) {
      const e = eye[i];
      // Spring: stiffness pulls toward target, damping bleeds the overshoot.
      e.vx = (e.vx + (e.tx - e.x) * 0.14) * 0.76;
      e.vy = (e.vy + (e.ty - e.y) * 0.14) * 0.76;
      e.x += e.vx;
      e.y += e.vy;
      irises[i].setAttribute('transform', `translate(${e.x.toFixed(2)} ${e.y.toFixed(2)})`);
    }
  }

  window.addEventListener('pointermove', (ev) => aim(ev.clientX, ev.clientY), { passive: true });

  // Nothing has moved yet, so look around on its own rather than staring blankly.
  let wander = setInterval(() => {
    if (pointerSeen) { clearInterval(wander); wander = 0; return; }
    aim(
      window.innerWidth / 2 + (Math.random() - 0.5) * window.innerWidth * 0.8,
      window.innerHeight / 2 + (Math.random() - 0.5) * window.innerHeight * 0.6
    );
  }, 1400);

  const blink = setInterval(() => {
    if (!lids) return;
    lids.classList.add('gate-lids--shut');
    setTimeout(() => lids.classList.remove('gate-lids--shut'), 130);
  }, 4600);

  raf = requestAnimationFrame(frame);

  /* ---- the door -------------------------------------------------------- */

  let closing = false;

  function open() {
    if (closing) return;
    closing = true;

    try { localStorage.setItem(KEY, String(Date.now())); } catch (e) { /* storage blocked */ }

    clearInterval(blink);
    if (wander) clearInterval(wander);

    gate.classList.remove('gate--in');
    gate.classList.add('gate--out');
    document.documentElement.classList.remove('gate-open');

    // Removed rather than left transparent on top of the page — a full-viewport
    // element with pointer events is not something to leave lying around.
    const done = () => {
      cancelAnimationFrame(raf);
      gate.remove();
    };
    gate.addEventListener('transitionend', done, { once: true });
    setTimeout(done, 1100);
  }

  if (enter) enter.addEventListener('click', open);
  if (skip) skip.addEventListener('click', open);

  // Never a dead end: escape, or a click on the backdrop, both let you past.
  document.addEventListener('keydown', (ev) => {
    if (ev.key === 'Escape') open();
  });
  gate.addEventListener('click', (ev) => {
    if (ev.target === gate) open();
  });
})();
