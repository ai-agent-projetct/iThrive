/**
 * The Dedicated Engineering Team page's own behaviour.
 *
 * Two things: the hero arc spins under a drag, and the three hiring-model
 * cards turn over when clicked. Everything else is a Framer island or CSS.
 *
 * The arc's LAYOUT is not here — every card's place on the ring is computed in
 * CSS from its own --i, so it is correct before this file runs and stays
 * correct if it never does. This only adds the drag offset.
 *
 * Not here: the honeycomb (assets/js/hexbg.js draws it on every page) and
 * reveal-on-scroll (main.js observes every [data-reveal] site-wide). Both were
 * duplicated on an earlier page and the copies fought the originals.
 */
(function () {
  'use strict';

  /* ======================================================================
     1. The hero arc — drag to spin it
     ====================================================================== */

  const arc = document.querySelector('[data-arc]');

  if (arc) {
    const ring = arc.querySelector('[data-arc-ring]');
    const cards = arc.querySelectorAll('.tm-arc-card').length || 10;
    /* One card's worth of ring per this many pixels dragged. */
    const PX_PER_CARD = 90;

    let angle = 0;
    let from = null;
    let base = 0;

    const set = (a) => { angle = a; ring.style.setProperty('--r', a.toFixed(2)); };

    arc.addEventListener('pointerdown', (e) => {
      from = e.clientX;
      base = angle;
      arc.classList.add('is-dragging');
      arc.setPointerCapture(e.pointerId);
    });

    arc.addEventListener('pointermove', (e) => {
      if (from === null) return;
      set(base + (e.clientX - from) * (360 / cards) / PX_PER_CARD);
    });

    const release = () => {
      if (from === null) return;
      from = null;
      arc.classList.remove('is-dragging');
      /* Settle on the nearest card, so a card is always facing front. */
      const step = 360 / cards;
      set(Math.round(angle / step) * step);
    };

    arc.addEventListener('pointerup', release);
    arc.addEventListener('pointercancel', release);
  }

  /* ======================================================================
     2. The hiring-model cards
     ====================================================================== */

  const section = document.querySelector('[data-models]');
  if (!section) return;

  const cards = Array.from(section.querySelectorAll('[data-model]'));

  const turn = (card) => {
    const now = !card.classList.contains('is-turned');
    card.classList.toggle('is-turned', now);
    card.setAttribute('aria-pressed', now ? 'true' : 'false');
  };

  for (const card of cards) {
    card.addEventListener('click', () => turn(card));

    /* role="button" gets keyboard activation from us. Space is prevented so
       the page does not scroll out from under the press. */
    card.addEventListener('keydown', (e) => {
      if (e.key !== 'Enter' && e.key !== ' ') return;
      e.preventDefault();
      turn(card);
    });
  }
}());
