/**
 * Tech stack orbit.
 *
 * Reads the categorised tiles already in the DOM and promotes them to an
 * interactive orbital field. One category is shown at a time — selecting a
 * category rebuilds the orbit with only that group's logos.
 *
 * Progressive by design: without this the tiles are already a complete,
 * readable tech stack, and the first category is active server-side.
 */

(function () {
  'use strict';

  const root = document.querySelector('[data-techstack]');
  if (!root) return;

  const stage   = root.querySelector('.tech-stage');
  const orbit   = root.querySelector('[data-tech-orbit]');
  const readout = root.querySelector('[data-tech-readout]');
  const tabs    = Array.from(root.querySelectorAll('[data-tech-filter]'));
  if (!orbit || tabs.length === 0) return;

  const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  const base = root.dataset.techBase || 'assets/img/tech/';

  /** Every tile, grouped by category, read once from the server-rendered list. */
  const byCat = {};
  root.querySelectorAll('.tech-tile').forEach((t) => {
    (byCat[t.dataset.techCat] ||= []).push({
      name:  t.dataset.techName,
      logo:  t.dataset.techLogo,
      group: t.dataset.techGroupTitle,
    });
  });

  let active = tabs[0].dataset.techFilter;

  /* ----------------------------------------------------------------- select */

  // Category switching works at every screen size; only the orbit is
  // desktop-only, so this is wired before the width check below.
  function select(cat) {
    active = cat;

    tabs.forEach((b) => {
      const on = b.dataset.techFilter === cat;
      b.classList.toggle('is-active', on);
      b.setAttribute('aria-selected', String(on));
    });

    root.querySelectorAll('[data-tech-group]').forEach((g) => {
      g.hidden = g.dataset.techGroup !== cat;
    });

    if (root.classList.contains('is-live')) buildOrbit(cat);
  }

  tabs.forEach((b) => b.addEventListener('click', () => select(b.dataset.techFilter)));

  if (window.matchMedia('(max-width: 720px)').matches) return;

  root.classList.add('is-live');
  orbit.removeAttribute('aria-hidden');

  /* ------------------------------------------------------------ build nodes */

  let nodes = [];

  function buildOrbit(cat) {
    orbit.textContent = '';
    readout.hidden = true;

    nodes = (byCat[cat] || []).map((tech, i) => {
      const el = document.createElement('button');
      el.type = 'button';
      el.className = 'tech-node';
      el.setAttribute('aria-label', `${tech.name} — ${tech.group}`);
      el.innerHTML = '<img alt="" width="26" height="26" loading="lazy">'
                   + '<span></span>';
      el.querySelector('img').src = `${base}${tech.logo}.svg`;
      el.querySelector('span').textContent = tech.name;
      orbit.appendChild(el);

      el.addEventListener('pointerenter', () => show(tech));
      el.addEventListener('focus', () => show(tech));
      el.addEventListener('pointerleave', hide);
      el.addEventListener('blur', hide);

      // Golden-angle spacing across two rings so nothing clumps.
      const ring = i % 2;
      return {
        el, ring,
        angle: i * 2.39996,
        speed: (0.11 + ring * 0.04) * (ring ? -1 : 1),
        x: 0, y: 0, vx: 0, vy: 0,
      };
    });
  }

  const show = (t) => {
    readout.hidden = false;
    readout.querySelector('.tech-readout-name').textContent = t.name;
    readout.querySelector('.tech-readout-group').textContent = t.group;
  };
  const hide = () => { readout.hidden = true; };

  buildOrbit(active);

  /* ---------------------------------------------------------------- pointer */

  const pointer = { x: 0, y: 0, inside: false };

  stage.addEventListener('pointermove', (e) => {
    const r = stage.getBoundingClientRect();
    pointer.x = e.clientX - r.left - r.width / 2;
    pointer.y = e.clientY - r.top - r.height / 2;
    pointer.inside = true;
  }, { passive: true });

  stage.addEventListener('pointerleave', () => { pointer.inside = false; });

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
    if (!visible || w === 0 || nodes.length === 0) return;

    t += reduceMotion ? 0 : 0.006;
    const radius = Math.min(w, h * 1.6) * 0.5;

    for (const n of nodes) {
      const rr = radius * (0.46 + n.ring * 0.3);
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

      n.vx = (n.vx + (tx - n.x) * 0.08) * 0.78;
      n.vy = (n.vy + (ty - n.y) * 0.08) * 0.78;
      n.x += n.vx;
      n.y += n.vy;

      const depth = 0.74 + 0.26 * ((Math.sin(a) + 1) / 2);
      n.el.style.transform = `translate3d(${n.x.toFixed(1)}px, ${n.y.toFixed(1)}px, 0) scale(${depth.toFixed(3)})`;
      n.el.style.zIndex = String(Math.round(depth * 100));
      n.el.style.opacity = String(0.62 + depth * 0.38);
    }
  }

  frame();
})();
