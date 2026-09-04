/**
 * The Cloud & DevOps page's own behaviour.
 *
 * Two things: the hero orbit tilting under the pointer, and the stage dial.
 *
 * Both write a custom property or toggle a class and leave the look to CSS, so
 * there is one place that decides how anything appears — and the page is fully
 * laid out before this file runs at all. That ordering is the point: nine
 * components on this site have rendered nothing because they computed their
 * layout in a frame that never came. The orbit's rings, gates and dial pins are
 * all placed by CSS from their own custom properties, so with this file absent
 * the page is still correct — just still.
 *
 * Not here: the honeycomb (assets/js/hexbg.js draws it site-wide), the
 * reveal-on-scroll (main.js observes every [data-reveal]) and the lead modal
 * (main.js owns [data-modal-open]). Copies of those fought the originals on an
 * earlier page.
 */
(function () {
  'use strict';

  /* ======================================================================
     The orbit — the pointer leans the whole assembly
     ====================================================================== */

  const orbit = document.querySelector('[data-orbit]');
  const inner = orbit && orbit.querySelector('[data-orbit-inner]');

  if (inner
      && !window.matchMedia('(prefers-reduced-motion: reduce)').matches
      && window.matchMedia('(hover: hover)').matches) {

    /* Degrees either side of the resting 64. Past about this the rings go
       edge-on and the gates disappear into the line. */
    const LEAN = 12;

    let raf = 0;
    let tx = 0;
    let ty = 0;

    const paint = () => {
      raf = 0;
      inner.style.setProperty('--tx', tx.toFixed(2) + 'deg');
      inner.style.setProperty('--ty', ty.toFixed(2) + 'deg');
    };

    orbit.addEventListener('pointermove', (e) => {
      const r = inner.getBoundingClientRect();
      const dx = (e.clientX - (r.left + r.width / 2)) / (r.width / 2);
      const dy = (e.clientY - (r.top + r.height / 2)) / (r.height / 2);

      tx = Math.max(-1, Math.min(1, dy)) * -LEAN;
      ty = Math.max(-1, Math.min(1, dx)) * LEAN;

      if (!raf) raf = requestAnimationFrame(paint);
    });

    orbit.addEventListener('pointerleave', () => {
      tx = 0;
      ty = 0;
      if (!raf) raf = requestAnimationFrame(paint);
    });
  }

  /* ======================================================================
     The dial — five stages round a ring
     ====================================================================== */

  const dial = document.querySelector('[data-dial]');
  if (!dial) return;

  const pins = Array.from(dial.querySelectorAll('[data-dial-pin]'));
  const cards = Array.from(dial.querySelectorAll('[data-stage]'));
  if (!pins.length || !cards.length) return;

  const ring = dial.querySelector('[data-dial-inner]');

  const select = (index) => {
    if (ring) ring.style.setProperty('--sel', String(index));

    pins.forEach((p, i) => p.classList.toggle('is-on', i === index));
    cards.forEach((c, i) => {
      c.hidden = i !== index;
      c.classList.toggle('is-on', i === index);
    });
  };

  pins.forEach((pin, i) => {
    pin.addEventListener('click', () => select(i));

    /* Arrow keys round the dial, which is what a keyboard user will try. */
    pin.addEventListener('keydown', (e) => {
      const step = e.key === 'ArrowRight' || e.key === 'ArrowDown' ? 1
        : e.key === 'ArrowLeft' || e.key === 'ArrowUp' ? -1 : 0;
      if (!step) return;
      e.preventDefault();
      const next = (i + step + pins.length) % pins.length;
      select(next);
      pins[next].focus();
    });
  });
}());
