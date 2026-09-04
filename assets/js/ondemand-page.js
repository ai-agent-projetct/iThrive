/**
 * The On-Demand Resources page's own behaviour.
 *
 * One thing: the three hiring-model cards tilt toward the pointer. Everything
 * else on the page is a Framer island or plain CSS.
 *
 * The tilt is written as two custom properties and the transform stays in CSS,
 * so there is one place that decides how a card looks. The listener is on the
 * GRID rather than on each card: the pointer is then tracked in the gaps
 * between them too, which is where per-card listeners leave one frozen at its
 * last angle.
 *
 * Not here: the honeycomb (assets/js/hexbg.js draws it site-wide), the
 * reveal-on-scroll (main.js observes every [data-reveal]), and the WebGL
 * posters (assets/js/webgl-poster.js). All three were duplicated on an earlier
 * page once and the copies fought the originals.
 */
(function () {
  'use strict';

  const grid = document.querySelector('[data-models]');
  if (!grid) return;

  const cards = Array.from(grid.querySelectorAll('[data-model]'));
  if (!cards.length) return;

  /* Reduced motion, or a device with no real hover, gets the cards flat. */
  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
  if (!window.matchMedia('(hover: hover)').matches) return;

  /* Degrees. Past about this the card text starts to distort. */
  const MAX = 7;

  let raf = 0;
  let pointer = null;

  const paint = () => {
    raf = 0;
    if (!pointer) return;

    for (const card of cards) {
      const r = card.getBoundingClientRect();
      const dx = (pointer.x - (r.left + r.width / 2)) / (r.width / 2);
      const dy = (pointer.y - (r.top + r.height / 2)) / (r.height / 2);

      /* Falls off with distance, so the whole row does not lean at once. */
      const fade = Math.max(0, 1 - Math.hypot(dx, dy) / 2.4);

      card.style.setProperty('--ry', (dx * MAX * fade).toFixed(2) + 'deg');
      card.style.setProperty('--rx', (-dy * MAX * fade).toFixed(2) + 'deg');
    }
  };

  grid.addEventListener('pointermove', (e) => {
    pointer = { x: e.clientX, y: e.clientY };
    if (!raf) raf = requestAnimationFrame(paint);
  });

  grid.addEventListener('pointerleave', () => {
    pointer = null;
    for (const card of cards) {
      card.style.setProperty('--ry', '0deg');
      card.style.setProperty('--rx', '0deg');
    }
  });
}());
