/**
 * The MVP Development page's own two behaviours.
 *
 *  1. The reactive hexagon field behind the page.
 *  2. The process stepper: click a step, its card opens.
 *
 * Both degrade to nothing: with this file absent the page keeps its ordinary
 * background and every step's card is simply shown in a stack.
 */

(function () {
  'use strict';

  const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  /* ======================================================================
     1. The hexagon field
     ======================================================================

     After the mobile app page's HexagonGridBg, which this site already runs:
     a honeycomb that lights up around the pointer, and whose colour is taken
     from where the pointer sits across the width — cyan at the left edge,
     through blue, to violet at the right. Same seven stops, so the two pages
     agree; drawn in vanilla JS here because this page has no React island of
     its own to hang a component on.
     ====================================================================== */

  const canvas = document.querySelector('[data-mvp-hex]');

  if (canvas && !reduced) {
    const ctx = canvas.getContext('2d');

    /* The site's ramp, cyan #00F2FE to violet #9D4EDD, sampled at seven stops
       so the transition across the screen is smooth rather than a two-colour
       crossfade. */
    const STOPS = [
      [0, 242, 254], [0, 190, 255], [78, 168, 255], [90, 130, 245],
      [120, 100, 235], [157, 78, 221], [190, 90, 230],
    ];

    const RADIUS = 26;                       // hexagon size
    const REACH = 210;                       // how far the pointer lights
    const W = Math.sqrt(3) * RADIUS;         // horizontal pitch
    const H = 1.5 * RADIUS;                  // vertical pitch

    let w = 0;
    let h = 0;
    let dpr = 1;
    let mx = -9999;
    let my = -9999;
    let raf = 0;

    function size() {
      dpr = Math.min(2, window.devicePixelRatio || 1);
      w = canvas.clientWidth;
      h = canvas.clientHeight;
      canvas.width = Math.round(w * dpr);
      canvas.height = Math.round(h * dpr);
      ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
    }

    /** The colour for a pointer sitting at `ratio` across the width. */
    function zone(ratio) {
      const t = Math.max(0, Math.min(1, ratio)) * (STOPS.length - 1);
      const i = Math.floor(t);
      const j = Math.min(STOPS.length - 1, i + 1);
      const f = t - i;
      const a = STOPS[i];
      const b = STOPS[j];

      return [
        Math.round(a[0] + (b[0] - a[0]) * f),
        Math.round(a[1] + (b[1] - a[1]) * f),
        Math.round(a[2] + (b[2] - a[2]) * f),
      ].join(', ');
    }

    function hexPath(x, y) {
      ctx.beginPath();
      for (let i = 0; i < 6; i++) {
        const a = (Math.PI / 3) * i - Math.PI / 6;
        const hx = x + RADIUS * Math.cos(a);
        const hy = y + RADIUS * Math.sin(a);
        if (i === 0) ctx.moveTo(hx, hy); else ctx.lineTo(hx, hy);
      }
      ctx.closePath();
    }

    function frame() {
      raf = 0;
      ctx.clearRect(0, 0, w, h);

      const rgb = zone(mx / Math.max(1, w));
      const cols = Math.ceil(w / W) + 2;
      const rows = Math.ceil(h / H) + 2;

      for (let r = -1; r < rows; r++) {
        for (let c = -1; c < cols; c++) {
          const x = c * W + (r % 2 ? W / 2 : 0);
          const y = r * H;

          const dx = mx - x;
          const dy = my - y;
          const d = Math.sqrt(dx * dx + dy * dy);
          if (d > REACH) continue;           // unlit cells are not drawn at all

          const lit = 1 - d / REACH;
          hexPath(x, y);
          ctx.fillStyle = `rgba(${rgb}, ${(lit * 0.16).toFixed(3)})`;
          ctx.fill();
          ctx.strokeStyle = `rgba(${rgb}, ${(lit * 0.62).toFixed(3)})`;
          ctx.lineWidth = 1.4;
          ctx.stroke();
        }
      }
    }

    /*
     * Only the cells near the pointer are drawn, and only when the pointer has
     * moved. A full-screen honeycomb redrawn every frame was 6,000 paths a
     * frame for a decoration nobody is looking at.
     */
    function schedule() {
      if (!raf) raf = requestAnimationFrame(frame);
    }

    window.addEventListener('pointermove', (e) => {
      mx = e.clientX;
      my = e.clientY;
      schedule();
    }, { passive: true });

    window.addEventListener('pointerleave', () => {
      mx = my = -9999;
      schedule();
    }, { passive: true });

    window.addEventListener('resize', () => { size(); schedule(); }, { passive: true });

    size();
    canvas.classList.add('is-live');
  }

  /* ======================================================================
     2. The process stepper
     ====================================================================== */

  const stepper = document.querySelector('[data-stepper]');

  if (stepper) {
    const steps = Array.from(stepper.querySelectorAll('[data-step]'));
    const cards = Array.from(stepper.querySelectorAll('[data-stepcard]'));

    function open(i) {
      steps.forEach((s, n) => {
        s.setAttribute('aria-selected', n === i ? 'true' : 'false');
        s.tabIndex = n === i ? 0 : -1;
      });
      cards.forEach((c, n) => c.classList.toggle('is-open', n === i));
    }

    steps.forEach((s, i) => {
      s.addEventListener('click', () => open(i));

      /* Arrow keys move between steps, which is what a tablist should do and
         what a keyboard user will already expect from one. */
      s.addEventListener('keydown', (e) => {
        const d = e.key === 'ArrowDown' || e.key === 'ArrowRight' ? 1
          : e.key === 'ArrowUp' || e.key === 'ArrowLeft' ? -1 : 0;
        if (!d) return;
        e.preventDefault();
        const next = (i + d + steps.length) % steps.length;
        open(next);
        steps[next].focus();
      });
    });

    /* `is-live` is what switches the CSS from "show every card" to "show the
       open one", so it goes on only once the handlers are attached. */
    stepper.classList.add('is-live');
    open(0);
  }
})();
