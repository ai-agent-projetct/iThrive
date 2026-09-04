/**
 * The Product Modernization page's own behaviour.
 *
 * Three things: the hero wall's migration front following the pointer, the
 * five-panel drum turning, and the journey rail opening one stop at a time.
 *
 * Every one writes a custom property or toggles a class and leaves the look to
 * CSS, so there is one place that decides how anything appears — and the page
 * is fully laid out before this file runs at all. That ordering is the point:
 * eight components on this site have rendered nothing because they computed
 * their layout in a frame that never came.
 *
 * Not here: the honeycomb (assets/js/hexbg.js draws it site-wide), the
 * reveal-on-scroll (main.js observes every [data-reveal]) and the lead modal
 * (main.js owns [data-modal-open]). Copies of those fought the originals on an
 * earlier page.
 */
(function () {
  'use strict';

  /* ======================================================================
     The wall — the pointer advances the migration front
     ======================================================================

     --front is a single number from 0 to 1. CSS turns each tile from it and
     from the tile's own --t, so a visitor who never moves a pointer still sees
     a wall that is correctly half migrated.
     ====================================================================== */

  const wall = document.querySelector('[data-wall]');
  const inner = wall && wall.querySelector('[data-wall-inner]');
  const pct = wall && wall.querySelector('[data-wall-pct]');

  if (inner && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    /* Where the front rests when nothing is pointing at it. Matches the CSS,
       so the first pointer move does not jump. */
    const REST = 0.52;

    let raf = 0;
    let front = REST;

    const paint = () => {
      raf = 0;
      inner.style.setProperty('--front', front.toFixed(3));
      if (pct) pct.textContent = Math.round(front * 100) + '%';
    };

    const set = (v) => {
      front = Math.min(1, Math.max(0, v));
      if (!raf) raf = requestAnimationFrame(paint);
    };

    /* Listening on the whole hero rather than the grid: the pointer is then
       tracked in the gaps between tiles too, which is where a per-tile handler
       leaves the front stuck at its last value. */
    wall.addEventListener('pointermove', (e) => {
      const r = inner.getBoundingClientRect();

      /* The front is measured along the same diagonal the CSS uses, so moving
         down and right advances it exactly as the tiles expect. */
      const x = (e.clientX - r.left) / r.width;
      const y = (e.clientY - r.top) / r.height;
      set((x + y) / 2);
    });

    wall.addEventListener('pointerleave', () => set(REST));
  }

  /* ======================================================================
     The drum — five panels on a cylinder
     ====================================================================== */

  const drum = document.querySelector('[data-drum]');

  if (drum) {
    const cylinder = drum.querySelector('[data-drum-inner]');
    const panels = Array.from(drum.querySelectorAll('[data-panel]'));
    const dots = Array.from(drum.querySelectorAll('[data-drum-dot]'));

    if (cylinder && panels.length && dots.length) {
      const turn = (index) => {
        cylinder.style.setProperty('--a', String(index));

        panels.forEach((p, i) => p.classList.toggle('is-front', i === index));
        dots.forEach((d, i) => {
          const on = i === index;
          d.classList.toggle('is-on', on);
          d.setAttribute('aria-selected', on ? 'true' : 'false');
        });
      };

      dots.forEach((dot, i) => {
        dot.addEventListener('click', () => turn(i));

        /* Arrow keys across a tablist, which is what a screen reader expects. */
        dot.addEventListener('keydown', (e) => {
          const step = e.key === 'ArrowDown' || e.key === 'ArrowRight' ? 1
            : e.key === 'ArrowUp' || e.key === 'ArrowLeft' ? -1 : 0;
          if (!step) return;
          e.preventDefault();
          const next = (i + step + dots.length) % dots.length;
          turn(next);
          dots[next].focus();
        });
      });
    }
  }

  /* ======================================================================
     The rail — one stop open at a time
     ====================================================================== */

  const stops = Array.from(document.querySelectorAll('[data-stop]'));
  if (!stops.length) return;

  const open = (stop) => {
    for (const other of stops) {
      const on = other === stop;
      other.classList.toggle('is-open', on);
      other.setAttribute('aria-expanded', on ? 'true' : 'false');
    }
  };

  for (const stop of stops) {
    stop.addEventListener('click', () => open(stop));

    /* role="button" carries no keyboard behaviour of its own. */
    stop.addEventListener('keydown', (e) => {
      if (e.key !== 'Enter' && e.key !== ' ') return;
      e.preventDefault();
      open(stop);
    });
  }
}());
