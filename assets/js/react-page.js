/**
 * The ReactJS Development page's own behaviour.
 *
 * Two things: the six "what we do" cards, and the twelve sector tiles.
 * Everything else on the page is either a Framer island or plain CSS.
 *
 * Not here, deliberately:
 *   - the honeycomb, which assets/js/hexbg.js already draws on every page from
 *     includes/footer.php. The MVP page once carried a second copy and the two
 *     fought each other.
 *   - reveal-on-scroll, which main.js already runs for every [data-reveal] on
 *     the site, with the same --d stagger this page's cards use.
 *
 * Each block guards its own section and neither returns early on behalf of the
 * other: an earlier version bailed out of the whole file when the first
 * section was absent, which would have taken the second one with it.
 */
(function () {
  'use strict';

  /* ======================================================================
     1. What we do — six cards, one open at a time
     ====================================================================== */

  const doing = document.querySelector('[data-doing]');

  if (doing) {
    const cards = Array.from(doing.querySelectorAll('[data-doing-card]'));

    const open = (card) => {
      for (const c of cards) {
        const on = c === card;
        c.classList.toggle('is-open', on);
        c.setAttribute('aria-expanded', on ? 'true' : 'false');
      }
    };

    for (const card of cards) {
      card.addEventListener('click', () => open(card));

      /* role="button" gets keyboard activation from us, not the browser. Space
         is prevented so the page does not scroll out from under the press. */
      card.addEventListener('keydown', (e) => {
        if (e.key !== 'Enter' && e.key !== ' ') return;
        e.preventDefault();
        open(card);
      });
    }
  }

  /* ======================================================================
     2. The sector grid: twelve tiles that tilt, and open a reason
     ====================================================================== */

  const grid = document.querySelector('[data-sectors]');
  if (!grid) return;

  const tiles = Array.from(grid.querySelectorAll('[data-sector-tile]'));
  const panels = Array.from(document.querySelectorAll('[data-sector-panel]'));
  const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  /* --- tilt ------------------------------------------------------------- */

  /*
   * Each tile rotates toward the pointer. The rotation is written as two custom
   * properties and the transform itself lives in CSS, so there is one place
   * that decides what the tile looks like.
   *
   * Listening on the GRID rather than on twelve tiles: one listener, and the
   * pointer is tracked even in the gaps between them, which is where a
   * per-tile listener leaves a tile stuck at its last angle.
   */
  const MAX = 9;   /* degrees. More than this and the text starts to distort. */

  if (!reduced && window.matchMedia('(hover: hover)').matches) {
    let raf = 0;
    let pointer = null;

    const paint = () => {
      raf = 0;
      if (!pointer) return;

      for (const tile of tiles) {
        const r = tile.getBoundingClientRect();
        const dx = (pointer.x - (r.left + r.width / 2)) / (r.width / 2);
        const dy = (pointer.y - (r.top + r.height / 2)) / (r.height / 2);

        /* Beyond about one tile's distance the effect is noise, so it falls
           off to nothing rather than tilting the whole grid at once. */
        const reach = Math.hypot(dx, dy);
        const fade = Math.max(0, 1 - reach / 2.6);

        tile.style.setProperty('--ry', (dx * MAX * fade).toFixed(2) + 'deg');
        tile.style.setProperty('--rx', (-dy * MAX * fade).toFixed(2) + 'deg');
      }
    };

    grid.addEventListener('pointermove', (e) => {
      pointer = { x: e.clientX, y: e.clientY };
      if (!raf) raf = requestAnimationFrame(paint);
    });

    grid.addEventListener('pointerleave', () => {
      pointer = null;
      for (const tile of tiles) {
        tile.style.setProperty('--ry', '0deg');
        tile.style.setProperty('--rx', '0deg');
      }
    });
  }

  /* --- open ------------------------------------------------------------- */

  const show = (i) => {
    tiles.forEach((t, n) => {
      const on = n === i;
      t.classList.toggle('is-on', on);
      t.setAttribute('aria-selected', on ? 'true' : 'false');
    });
    panels.forEach((p, n) => { p.hidden = n !== i; });
  };

  tiles.forEach((t, i) => {
    t.addEventListener('click', () => show(i));

    /* Arrow keys move along the tablist, which is what a keyboard user is
       owed once these are tabs rather than a list. */
    t.addEventListener('keydown', (e) => {
      const step = e.key === 'ArrowRight' ? 1 : e.key === 'ArrowLeft' ? -1 : 0;
      if (!step) return;
      e.preventDefault();
      const next = (i + step + tiles.length) % tiles.length;
      tiles[next].focus();
      show(next);
    });
  });
}());
