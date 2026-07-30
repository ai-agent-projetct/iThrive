/**
 * Tech stack orbit.
 *
 * Reads the categorised list already in the DOM and promotes it to an
 * interactive orbital field: nodes drift on rings, follow the pointer, respond
 * to hover, and dim when a category filter is active.
 *
 * Progressive by design — if this never runs, the underlying list is a
 * complete, readable tech stack section on its own.
 */

(function () {
  'use strict';

  const root = document.querySelector('[data-techstack]');
  if (!root) return;

  const stage   = root.querySelector('.tech-stage');
  const orbit   = root.querySelector('[data-tech-orbit]');
  const readout = root.querySelector('[data-tech-readout]');
  const chips   = Array.from(root.querySelectorAll('.tech-chip'));
  if (!orbit || chips.length === 0) return;

  const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  /* ----------------------------------------------------------------- filter */

  // Wired before the orbit so category filtering works at every screen size —
  // only the orbit itself is desktop-only. Reassigned below once nodes exist.
  let dimNodes = () => {};
  let active = 'all';

  const applyFilter = (cat) => {
    active = cat;
    root.querySelectorAll('[data-tech-filter]').forEach((b) => {
      const on = b.dataset.techFilter === cat;
      b.classList.toggle('is-active', on);
      b.setAttribute('aria-selected', String(on));
    });
    root.querySelectorAll('[data-tech-group]').forEach((g) => {
      g.hidden = cat !== 'all' && g.dataset.techGroup !== cat;
    });
    dimNodes(cat);
  };

  root.querySelectorAll('[data-tech-filter]').forEach((b) => {
    b.addEventListener('click', () => applyFilter(b.dataset.techFilter));
  });

  // Below this the orbit costs more than it gives, so the list stays as-is.
  if (window.matchMedia('(max-width: 720px)').matches) return;

  root.classList.add('is-live');

  /* ------------------------------------------------------------ build nodes */

  const nodes = chips.map((chip, i) => {
    const el = document.createElement('button');
    el.type = 'button';
    el.className = 'tech-node';
    el.textContent = chip.dataset.techName;
    el.dataset.cat = chip.dataset.techCat;
    el.style.setProperty('--hue', chip.dataset.techHue);
    el.setAttribute('aria-label', `${chip.dataset.techName} — ${chip.dataset.techGroupTitle}`);
    orbit.appendChild(el);

    // Distribute across three rings, golden-angle spaced so nothing clumps.
    const ring = i % 3;
    return {
      el,
      cat: chip.dataset.techCat,
      group: chip.dataset.techGroupTitle,
      name: chip.dataset.techName,
      ring,
      angle: i * 2.39996,
      speed: (0.10 + ring * 0.035) * (ring % 2 ? -1 : 1),
      x: 0, y: 0, vx: 0, vy: 0,
    };
  });

  orbit.removeAttribute('aria-hidden');

  /* ---------------------------------------------------------------- pointer */

  const pointer = { x: 0, y: 0, inside: false };

  stage.addEventListener('pointermove', (e) => {
    const r = stage.getBoundingClientRect();
    pointer.x = e.clientX - r.left - r.width / 2;
    pointer.y = e.clientY - r.top - r.height / 2;
    pointer.inside = true;
  }, { passive: true });

  stage.addEventListener('pointerleave', () => { pointer.inside = false; });

  // Now that nodes exist, let the filter dim them too.
  dimNodes = (cat) => {
    nodes.forEach((n) => n.el.classList.toggle('is-dim', cat !== 'all' && n.cat !== cat));
  };

  /* ---------------------------------------------------------------- readout */

  const show = (n) => {
    readout.hidden = false;
    readout.querySelector('.tech-readout-name').textContent = n.name;
    readout.querySelector('.tech-readout-group').textContent = n.group;
  };
  const hide = () => { readout.hidden = true; };

  nodes.forEach((n) => {
    n.el.addEventListener('pointerenter', () => show(n));
    n.el.addEventListener('focus', () => show(n));
    n.el.addEventListener('pointerleave', hide);
    n.el.addEventListener('blur', hide);
    // Clicking a node filters to its category — the orbit doubles as the tabs.
    n.el.addEventListener('click', () => applyFilter(active === n.cat ? 'all' : n.cat));
  });

  /* ------------------------------------------------------------------- loop */

  let w = 0, h = 0;
  const measure = () => {
    const r = stage.getBoundingClientRect();
    w = r.width; h = r.height;
  };
  measure();
  window.addEventListener('resize', measure);

  let visible = true;
  if ('IntersectionObserver' in window) {
    new IntersectionObserver(([e]) => { visible = e.isIntersecting; }, { threshold: 0 }).observe(stage);
  }

  let t = 0;
  function frame() {
    requestAnimationFrame(frame);
    if (!visible || w === 0) return;

    t += reduceMotion ? 0 : 0.006;
    const radius = Math.min(w, h * 1.6) * 0.5;

    for (const n of nodes) {
      const rr = radius * (0.42 + n.ring * 0.24);
      const a  = n.angle + t * n.speed * 6;
      let tx = Math.cos(a) * rr;
      let ty = Math.sin(a) * rr * 0.52;

      // Nodes lean away from the cursor, which makes the field feel physical.
      if (pointer.inside) {
        const dx = tx - pointer.x, dy = ty - pointer.y;
        const d2 = dx * dx + dy * dy;
        if (d2 < 26000) {
          const f = (1 - d2 / 26000) * 34;
          const d = Math.sqrt(d2) || 1;
          tx += (dx / d) * f;
          ty += (dy / d) * f;
        }
      }

      n.vx += (tx - n.x) * 0.08;
      n.vy += (ty - n.y) * 0.08;
      n.vx *= 0.78;
      n.vy *= 0.78;
      n.x += n.vx;
      n.y += n.vy;

      // Far side of the orbit sits back a little.
      const depth = 0.72 + 0.28 * ((Math.sin(a) + 1) / 2);
      n.el.style.transform = `translate3d(${n.x.toFixed(1)}px, ${n.y.toFixed(1)}px, 0) scale(${depth.toFixed(3)})`;
      n.el.style.zIndex = String(Math.round(depth * 100));
      n.el.style.opacity = n.el.classList.contains('is-dim') ? '0.18' : String(0.55 + depth * 0.45);
    }
  }

  frame();
})();
