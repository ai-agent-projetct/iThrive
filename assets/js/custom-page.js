/**
 * The Custom Product Development page's own behaviour.
 *
 * Three things: the hero's strata stack spreading under the pointer, the six
 * expertise layers opening, and the stack tabs.
 *
 * Every one writes a custom property or toggles a class and leaves the look to
 * CSS, so there is one place that decides how anything appears — and the page
 * is fully laid out before this file runs at all. That ordering is the point:
 * seven components on this site have rendered nothing because they computed
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
     Hero — the layers pull apart as the pointer crosses them
     ======================================================================

     --s is extra separation in pixels, added to the 46px the CSS already
     places between plates. A visitor who never moves a pointer, and a browser
     that never runs this file, still gets the correct stack.
     ====================================================================== */

  const strata = document.querySelector('[data-strata]');
  const inner = strata && strata.querySelector('[data-strata-inner]');

  if (inner
      && !window.matchMedia('(prefers-reduced-motion: reduce)').matches
      && window.matchMedia('(hover: hover)').matches) {

    /* Pixels of extra air at full spread. Past about this the top plate leaves
       the stage on a laptop screen. */
    const MAX = 34;

    let raf = 0;
    let target = 0;

    const paint = () => {
      raf = 0;
      inner.style.setProperty('--s', target.toFixed(1) + 'px');
    };

    strata.addEventListener('pointermove', (e) => {
      const r = strata.getBoundingClientRect();

      /* Spread grows as the pointer nears the stage's centre, so crossing the
         hero opens the layers and leaving closes them. */
      const dx = (e.clientX - (r.left + r.width * 0.72)) / (r.width * 0.45);
      const dy = (e.clientY - (r.top + r.height / 2)) / (r.height / 2);
      target = MAX * Math.max(0, 1 - Math.hypot(dx, dy));

      if (!raf) raf = requestAnimationFrame(paint);
    });

    strata.addEventListener('pointerleave', () => {
      target = 0;
      if (!raf) raf = requestAnimationFrame(paint);
    });
  }

  /* The legend names the layers square to the screen, since text riding the
     plates' 56-degree tip is unreadable. Hovering an entry lights its plate,
     which is what ties the two halves together. */
  const legend = document.querySelector('[data-legend]');

  if (legend && inner) {
    const plates = Array.from(inner.querySelectorAll('[data-plate]'));

    for (const item of legend.querySelectorAll('[data-legend-item]')) {
      const plate = plates[Number(item.dataset.legendItem)];
      if (!plate) continue;

      item.addEventListener('pointerenter', () => plate.classList.add('is-lit'));
      item.addEventListener('pointerleave', () => plate.classList.remove('is-lit'));
    }
  }

  /* ======================================================================
     Expertise — one layer open at a time
     ====================================================================== */

  const layers = Array.from(document.querySelectorAll('[data-layer]'));

  if (layers.length) {
    const open = (layer) => {
      for (const other of layers) {
        const on = other === layer;
        other.classList.toggle('is-open', on);
        other.setAttribute('aria-expanded', on ? 'true' : 'false');
      }
    };

    for (const layer of layers) {
      layer.addEventListener('click', () => open(layer));

      /* role="button" carries no keyboard behaviour of its own. */
      layer.addEventListener('keydown', (e) => {
        if (e.key !== 'Enter' && e.key !== ' ') return;
        e.preventDefault();
        open(layer);
      });
    }
  }

  /* ======================================================================
     The stack — tabs
     ====================================================================== */

  const stack = document.querySelector('[data-stack]');
  if (!stack) return;

  const tabs = Array.from(stack.querySelectorAll('[data-stack-tab]'));
  const panels = Array.from(stack.querySelectorAll('[data-stack-panel]'));
  if (!tabs.length || !panels.length) return;

  const show = (index) => {
    tabs.forEach((tab, i) => {
      const on = i === index;
      tab.classList.toggle('is-on', on);
      tab.setAttribute('aria-selected', on ? 'true' : 'false');
    });

    panels.forEach((panel, i) => { panel.hidden = i !== index; });
  };

  tabs.forEach((tab, i) => {
    tab.addEventListener('click', () => show(i));

    /* Arrow keys across a tablist, which is what a screen reader expects. */
    tab.addEventListener('keydown', (e) => {
      const step = e.key === 'ArrowRight' ? 1 : e.key === 'ArrowLeft' ? -1 : 0;
      if (!step) return;
      e.preventDefault();
      const next = (i + step + tabs.length) % tabs.length;
      show(next);
      tabs[next].focus();
    });
  });
}());
