/**
 * The On-Demand Resources page's own behaviour.
 *
 * Two things: the hero's shape trail, and the three hiring-model cards
 * tilting toward the pointer.
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


  /* ======================================================================
     The hero's shape trail
     ======================================================================

     After Framer's TrailShapes ($10, nothing a third party can vendor), built
     from its live demo: shapes spawn under the pointer and fade.

     Each shape is a plain element with a CSS animation and removes itself on
     animationend. No rAF loop drives it — the compositor does — which is the
     one lesson this site has learned the hard way: everything on these pages
     that computed its own frames has at some point rendered nothing.
     ====================================================================== */

  const hero = document.querySelector('[data-trail]');

  if (hero && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    const layer = hero.querySelector('[data-trail-layer]');

    /* Four forms, drawn once and cloned. Building the SVG string per shape
       would parse markup on every pointer move. */
    const FORMS = [
      '<svg viewBox="0 0 40 40"><circle cx="20" cy="20" r="17" fill="none" stroke="currentColor" stroke-width="3"/></svg>',
      '<svg viewBox="0 0 40 40"><rect x="6" y="6" width="28" height="28" rx="8" fill="none" stroke="currentColor" stroke-width="3"/></svg>',
      '<svg viewBox="0 0 40 40"><path d="M20 4 36 34H4Z" fill="none" stroke="currentColor" stroke-width="3" stroke-linejoin="round"/></svg>',
      '<svg viewBox="0 0 40 40"><path d="M20 5 35 20 20 35 5 20Z" fill="none" stroke="currentColor" stroke-width="3" stroke-linejoin="round"/></svg>',
    ];
    const COLOURS = ['#00F2FE', '#4EA8FF', '#9D4EDD'];

    /* Far enough apart that the trail reads as shapes rather than a smear,
       and few enough that a fast sweep does not append hundreds of nodes. */
    const MIN_GAP = 58;

    let lastX = null;
    let lastY = null;

    hero.addEventListener('pointermove', (e) => {
      const box = hero.getBoundingClientRect();
      const x = e.clientX - box.left;
      const y = e.clientY - box.top;

      if (lastX !== null && Math.hypot(x - lastX, y - lastY) < MIN_GAP) return;
      lastX = x;
      lastY = y;

      const shape = document.createElement('span');
      shape.className = 'od-trail-shape';
      shape.innerHTML = FORMS[(Math.random() * FORMS.length) | 0];
      shape.style.color = COLOURS[(Math.random() * COLOURS.length) | 0];
      shape.style.setProperty('--x', x.toFixed(0) + 'px');
      shape.style.setProperty('--y', y.toFixed(0) + 'px');
      shape.style.setProperty('--s', (26 + Math.random() * 30).toFixed(0) + 'px');
      shape.style.setProperty('--r', (Math.random() * 90 - 45).toFixed(0) + 'deg');

      /* Its own animation is what removes it, so nothing accumulates even if
         the pointer never leaves. */
      shape.addEventListener('animationend', () => shape.remove());
      layer.appendChild(shape);
    });

    hero.addEventListener('pointerleave', () => { lastX = null; lastY = null; });
  }

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
