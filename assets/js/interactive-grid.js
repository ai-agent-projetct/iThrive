/**
 * Interactive Grid — a port of Origin Kit's component.
 *
 * A hover-reactive logo grid that lifts each card and its neighbours in 3D,
 * with an optional glow pulse. Built to the component's documented behaviour:
 *
 *   - Hover lifts the card and ripples into its four neighbours, for a
 *     fabric-pull feel rather than a single card popping on its own.
 *   - Leaving is debounced, so moving between adjacent cards keeps the
 *     formation intact instead of collapsing and rebuilding on every gap.
 *   - An optional two-colour glow pulse breathes on the raised cards.
 *   - Perspective and independent X/Y tilt apply to the whole grid.
 *   - Columns, rows, gap, padding, corner radius and logo scale configurable.
 *   - Per-card shadow with its own colour, independent of the glow.
 *
 * Props map to data attributes, keeping the component's own defaults:
 * columns 7, rows 6, gap 0, rounded 8, logoScale 3, perspective 1600,
 * rotateX 0, rotateY 0, glowIntensity 50.
 *
 * The lift is CSS — one custom property per card, written on pointer move.
 * Doing it in script per frame would be forty-two style writes a frame for an
 * effect the compositor can hold on its own.
 */

(function () {
  'use strict';

  const num = (el, key, fallback) => {
    const v = parseFloat(el.dataset[key]);

    return Number.isFinite(v) ? v : fallback;
  };

  document.querySelectorAll('[data-igrid]').forEach((grid) => {
    if (grid.dataset.igridReady) return;
    grid.dataset.igridReady = '1';

    const cards = Array.from(grid.querySelectorAll('[data-igrid-card]'));
    if (!cards.length) return;

    const columns = Math.max(1, Math.round(num(grid, 'columns', 7)));
    const perspective = num(grid, 'perspective', 1600);
    const rotateX = num(grid, 'rotateX', 0);
    const rotateY = num(grid, 'rotateY', 0);

    grid.style.setProperty('--igrid-cols', String(columns));
    grid.style.perspective = perspective + 'px';
    grid.style.setProperty('--igrid-rx', rotateX + 'deg');
    grid.style.setProperty('--igrid-ry', rotateY + 'deg');

    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
      grid.classList.add('igrid--live');

      return;   // The grid is still a grid; it simply does not move.
    }

    /*
     * The four neighbours of a card, by grid position. Precomputed once: the
     * ripple has to know them on every pointer move, and recomputing an index
     * into rows and columns per event is work the layout already did.
     */
    const neighbours = cards.map((_, i) => {
      const col = i % columns;
      const out = [];
      if (col > 0) out.push(i - 1);
      if (col < columns - 1) out.push(i + 1);
      out.push(i - columns, i + columns);

      return out.filter((n) => n >= 0 && n < cards.length);
    });

    let leaveTimer = 0;

    function raise(index) {
      clearTimeout(leaveTimer);

      cards.forEach((card, i) => {
        let lift = 0;
        if (i === index) lift = 1;
        else if (neighbours[index].indexOf(i) !== -1) lift = 0.45;

        card.style.setProperty('--lift', String(lift));
        card.classList.toggle('is-raised', lift > 0);
      });
    }

    function settle() {
      // Debounced, so crossing the seam between two cards does not drop the
      // whole formation for a frame and pull it back up again.
      clearTimeout(leaveTimer);
      leaveTimer = setTimeout(() => {
        for (const card of cards) {
          card.style.setProperty('--lift', '0');
          card.classList.remove('is-raised');
        }
      }, 90);
    }

    cards.forEach((card, i) => {
      card.addEventListener('pointerenter', () => raise(i));
      card.addEventListener('focus', () => raise(i));
    });
    grid.addEventListener('pointerleave', settle);
    grid.addEventListener('focusout', settle);

    grid.classList.add('igrid--live');
  });
})();
