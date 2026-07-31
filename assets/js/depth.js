/**
 * Depth — 3D motion for the services matrix and other card grids.
 *
 * Cards sit on a shared perspective plane and respond to the pointer with a
 * real tilt, a lifting glare and layered parallax on their contents, so the
 * grid reads as physical objects rather than flat panels. Scrolling gives each
 * card its own entrance in depth.
 *
 * No dependency: this uses transforms and rAF directly. GSAP would give a nicer
 * easing API but would be ~70KB over the wire for motion this simple, and the
 * site has no build step to tree-shake it.
 *
 * Respects prefers-reduced-motion, and is skipped entirely on touch, where
 * there is no pointer to track and the tilt only gets in the way of tapping.
 */

(function () {
  'use strict';

  const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  const coarse = window.matchMedia('(pointer: coarse)').matches;
  if (reduceMotion || coarse) return;

  const MAX_TILT = 7;      // degrees; past ~8 it stops reading as depth and starts distorting text
  const LIFT     = 16;     // px toward the viewer on hover

  /* ------------------------------------------------------------ tilt cards */

  const cards = Array.from(document.querySelectorAll(
    '.svc-panel .card, .tech-group, .case-card .card, #services .card'
  ));

  cards.forEach((card) => {
    card.classList.add('has-depth');

    // The glare is a child rather than a background so it can move
    // independently of the card's own transform.
    const glare = document.createElement('span');
    glare.className = 'depth-glare';
    glare.setAttribute('aria-hidden', 'true');
    card.appendChild(glare);

    let raf = 0;
    let tx = 0, ty = 0, tz = 0, gx = 50, gy = 50;
    let cx = 0, cy = 0, cz = 0;

    const render = () => {
      raf = 0;
      // Ease toward the target so the card feels weighted, not glued to the cursor.
      cx += (tx - cx) * 0.12;
      cy += (ty - cy) * 0.12;
      cz += (tz - cz) * 0.12;

      card.style.transform =
        `perspective(900px) rotateX(${cy.toFixed(2)}deg) rotateY(${cx.toFixed(2)}deg) translateZ(${cz.toFixed(1)}px)`;
      glare.style.setProperty('--gx', gx + '%');
      glare.style.setProperty('--gy', gy + '%');

      if (Math.abs(tx - cx) > 0.01 || Math.abs(ty - cy) > 0.01 || Math.abs(tz - cz) > 0.05) {
        raf = requestAnimationFrame(render);
      }
    };

    const kick = () => { if (!raf) raf = requestAnimationFrame(render); };

    card.addEventListener('pointermove', (e) => {
      const r = card.getBoundingClientRect();
      const px = (e.clientX - r.left) / r.width;
      const py = (e.clientY - r.top) / r.height;

      tx = (px - 0.5) * MAX_TILT * 2;
      ty = (0.5 - py) * MAX_TILT * 2;
      tz = LIFT;
      gx = px * 100;
      gy = py * 100;
      card.style.setProperty('--glare-o', '1');
      kick();
    }, { passive: true });

    card.addEventListener('pointerleave', () => {
      tx = ty = tz = 0;
      card.style.setProperty('--glare-o', '0');
      kick();
    });
  });

  /* ------------------------------------------------- depth entrance on scroll */

  if (!('IntersectionObserver' in window)) return;

  const enter = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (!entry.isIntersecting) return;
      entry.target.classList.add('depth-in');
      enter.unobserve(entry.target);
    });
  }, { rootMargin: '0px 0px -8% 0px', threshold: 0.1 });

  cards.forEach((c, i) => {
    // Stagger within a row so a grid resolves left-to-right rather than at once.
    c.style.setProperty('--depth-delay', (i % 3) * 90 + 'ms');
    c.classList.add('depth-pending');
    enter.observe(c);
  });

  /* ----------------------------------------------- section parallax backdrop */

  const layers = Array.from(document.querySelectorAll('[data-parallax]'));
  if (layers.length === 0) return;

  let ticking = false;
  const onScroll = () => {
    if (ticking) return;
    ticking = true;
    requestAnimationFrame(() => {
      ticking = false;
      const vh = window.innerHeight;
      for (const el of layers) {
        const r = el.getBoundingClientRect();
        if (r.bottom < 0 || r.top > vh) continue;
        // -1..1 across the viewport, so the layer drifts as the section passes.
        const progress = (r.top + r.height / 2 - vh / 2) / vh;
        const depth = parseFloat(el.dataset.parallax) || 20;
        el.style.transform = `translate3d(0, ${(progress * depth).toFixed(1)}px, 0)`;
      }
    });
  };

  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();
})();
