/**
 * The Game Development page's own behaviour.
 *
 * Two things: the hero ship answering the pointer, and the three industry cards
 * opening one at a time.
 *
 * Both write a custom property or toggle a class and leave the look to CSS, so
 * the page is fully laid out before this file runs at all. With the script
 * absent the hero is still a correct scene — suns, dunes, spires and a centred
 * ship — because every position is a CSS default. Nine components on this site
 * have rendered nothing by computing their layout in a frame that never came.
 *
 * Not here: the honeycomb (assets/js/hexbg.js draws it site-wide), the
 * reveal-on-scroll (main.js observes every [data-reveal]) and the lead modal
 * (main.js owns [data-modal-open]).
 */
(function () {
  'use strict';

  /* ======================================================================
     The ship — leans toward the pointer
     ====================================================================== */

  const hero = document.querySelector('[data-flight]');
  const ship = hero && hero.querySelector('[data-ship]');

  if (ship
      && !window.matchMedia('(prefers-reduced-motion: reduce)').matches
      && window.matchMedia('(hover: hover)').matches) {

    /* How far the ship may travel from centre, and how far it may rise. The
       CSS turns --lx into the bank angle as well, so one number does both. */
    const SWING = 150;
    const LIFT = 46;

    let raf = 0;
    let lx = 0;
    let ly = 0;

    const paint = () => {
      raf = 0;
      ship.style.setProperty('--lx', lx.toFixed(1) + 'px');
      ship.style.setProperty('--ly', ly.toFixed(1) + 'px');
    };

    hero.addEventListener('pointermove', (e) => {
      const r = hero.getBoundingClientRect();
      const dx = (e.clientX - (r.left + r.width / 2)) / (r.width / 2);
      const dy = (e.clientY - (r.top + r.height / 2)) / (r.height / 2);

      lx = Math.max(-1, Math.min(1, dx)) * SWING;
      ly = Math.max(-1, Math.min(1, dy)) * LIFT;

      if (!raf) raf = requestAnimationFrame(paint);
    });

    hero.addEventListener('pointerleave', () => {
      lx = 0;
      ly = 0;
      if (!raf) raf = requestAnimationFrame(paint);
    });
  }

  /* ======================================================================
     Industries — one card open at a time
     ====================================================================== */

  const cards = Array.from(document.querySelectorAll('[data-ind-card]'));
  if (!cards.length) return;

  const open = (card) => {
    for (const other of cards) {
      const on = other === card;
      other.classList.toggle('is-open', on);
      other.setAttribute('aria-expanded', on ? 'true' : 'false');
    }
  };

  for (const card of cards) {
    card.addEventListener('click', () => open(card));

    /* role="button" carries no keyboard behaviour of its own. */
    card.addEventListener('keydown', (e) => {
      if (e.key !== 'Enter' && e.key !== ' ') return;
      e.preventDefault();
      open(card);
    });
  }
}());
