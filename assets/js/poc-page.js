/**
 * The PoC Development page's own behaviour.
 *
 * Three small things, none of which the Framer islands cover:
 *
 *   1. the eight scope cards, one open at a time
 *   2. the sector tabs under the carousel
 *   3. the reveal-on-scroll used by two grids
 *
 * The honeycomb is NOT here. assets/js/hexbg.js already draws it on every page
 * from includes/footer.php; the MVP page once carried a second copy of its own
 * and the two fought, which is worth not repeating.
 */
(function () {
  'use strict';

  /* ======================================================================
     1. Scope cards — one open at a time
     ====================================================================== */

  const inside = document.querySelector('[data-inside]');

  if (inside) {
    const cards = Array.from(inside.querySelectorAll('[data-inside-card]'));

    const open = (card) => {
      for (const c of cards) {
        const on = c === card;
        c.classList.toggle('is-open', on);
        c.setAttribute('aria-expanded', on ? 'true' : 'false');
      }
    };

    for (const card of cards) {
      card.addEventListener('click', () => open(card));

      /* role="button" gets keyboard activation from us, not from the browser.
         Space is prevented so the page does not scroll under the press. */
      card.addEventListener('keydown', (e) => {
        if (e.key !== 'Enter' && e.key !== ' ') return;
        e.preventDefault();
        open(card);
      });
    }
  }

  /* ======================================================================
     2. Sector tabs
     ====================================================================== */

  const sectors = document.querySelector('[data-sectors]');

  if (sectors) {
    const tabs = Array.from(sectors.querySelectorAll('[data-sector-tab]'));
    const panels = Array.from(sectors.querySelectorAll('[data-sector-panel]'));

    const show = (i) => {
      tabs.forEach((t, n) => {
        const on = n === i;
        t.classList.toggle('is-on', on);
        t.setAttribute('aria-selected', on ? 'true' : 'false');
      });
      panels.forEach((p, n) => {
        const on = n === i;
        p.classList.toggle('is-on', on);
        /* hidden rather than display, so the panel keeps its own layout rules. */
        p.hidden = !on;
      });
    };

    tabs.forEach((t, i) => {
      t.addEventListener('click', () => show(i));

      /* Left/right arrows move between tabs, which is what a tablist owes a
         keyboard user. */
      t.addEventListener('keydown', (e) => {
        const step = e.key === 'ArrowRight' ? 1 : e.key === 'ArrowLeft' ? -1 : 0;
        if (!step) return;
        e.preventDefault();
        const next = (i + step + tabs.length) % tabs.length;
        tabs[next].focus();
        show(next);
      });
    });
  }

  /* Reveal-on-scroll is NOT here either: main.js already observes every
     [data-reveal] on the site and adds .is-in. This file only owns the two
     behaviours above. */
}());
