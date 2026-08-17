/**
 * Hexagon field that lights under the cursor and shifts hue across the screen.
 *
 * A vanilla port of the mobile app page's HexagonGridBg, so every PHP page gets
 * the same behaviour without loading React. Two things happen at once: cells
 * near the pointer light up, and the colour they light up in is chosen by where
 * the pointer sits horizontally — cyan at the left edge through royal blue in
 * the middle to violet magenta at the right.
 *
 * Two changes from the React original, both because this runs on every page
 * rather than one:
 *
 *  - Only the cells near the pointer are drawn. The original walked the whole
 *    grid every frame — roughly 1,500 hexagons at 1440x900 — and drew each one
 *    even when it was a dark cell nobody could see. Here the dim base grid is
 *    painted once to an offscreen canvas and blitted, and only the ~60 cells
 *    inside the light radius are drawn per frame.
 *  - It idles. With no pointer movement for a second the loop stops rendering
 *    and parks until the next move, so a page left open costs nothing.
 *
 * Skipped entirely on touch and under prefers-reduced-motion.
 */

(function () {
  'use strict';

  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
  if (window.matchMedia('(pointer: coarse)').matches) return;

  const canvas = document.createElement('canvas');
  canvas.className = 'hex-bg';
  canvas.setAttribute('aria-hidden', 'true');
  document.body.prepend(canvas);

  const ctx = canvas.getContext('2d');
  const base = document.createElement('canvas');
  const bctx = base.getContext('2d');

  /** The seven zones, left edge to right. */
  const STOPS = [
    [0, 191, 255],    // electric cyan
    [0, 153, 255],    // azure
    [26, 117, 255],   // royal blue
    [43, 86, 245],    // cobalt
    [75, 50, 234],    // electric indigo
    [124, 58, 237],   // deep blue purple
    [217, 70, 239],   // violet magenta
  ];

  const R = 30;                        // hex radius
  const HW = Math.sqrt(3) * R;         // horizontal spacing
  const HS = 1.5 * R;                  // row spacing
  const REACH = 220;                   // how far the light carries

  let w = 0, h = 0, dpr = 1;
  const mouse = { x: -9999, y: -9999 };
  let lastMove = 0;
  let raf = 0;

  const zoneColour = (ratio) => {
    const t = Math.max(0, Math.min(1, ratio)) * (STOPS.length - 1);
    const i = Math.floor(t);
    const j = Math.min(STOPS.length - 1, i + 1);
    const f = t - i;
    const a = STOPS[i], b = STOPS[j];

    return `${Math.round(a[0] + (b[0] - a[0]) * f)}, `
         + `${Math.round(a[1] + (b[1] - a[1]) * f)}, `
         + `${Math.round(a[2] + (b[2] - a[2]) * f)}`;
  };

  const hexPath = (c, x, y) => {
    c.beginPath();
    for (let i = 0; i < 6; i++) {
      const a = (Math.PI / 3) * i - Math.PI / 6;
      const hx = x + R * Math.cos(a);
      const hy = y + R * Math.sin(a);
      if (i === 0) c.moveTo(hx, hy); else c.lineTo(hx, hy);
    }
    c.closePath();
  };

  /** The dim grid, painted once per resize rather than per frame. */
  function paintBase() {
    base.width = w * dpr;
    base.height = h * dpr;
    bctx.setTransform(dpr, 0, 0, dpr, 0, 0);
    bctx.clearRect(0, 0, w, h);
    bctx.strokeStyle = 'rgba(43, 86, 245, .085)';
    bctx.lineWidth = 0.8;

    for (let r = -1, rows = Math.ceil(h / HS) + 2; r < rows; r++) {
      for (let c = -1, cols = Math.ceil(w / HW) + 2; c < cols; c++) {
        const x = c * HW + (r % 2 ? HW / 2 : 0);
        hexPath(bctx, x, r * HS);
        bctx.stroke();
      }
    }
  }

  const resize = () => {
    dpr = Math.min(window.devicePixelRatio || 1, 2);
    w = window.innerWidth;
    h = window.innerHeight;
    canvas.width = w * dpr;
    canvas.height = h * dpr;
    canvas.style.width = w + 'px';
    canvas.style.height = h + 'px';
    ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
    paintBase();
  };

  function frame() {
    raf = requestAnimationFrame(frame);

    // Idle once the pointer has been still for a second.
    if (performance.now() - lastMove > 1000) return;

    ctx.clearRect(0, 0, w, h);
    ctx.drawImage(base, 0, 0, w, h);

    const rgb = zoneColour(mouse.x / w);

    // Walk only the rows and columns that can reach the pointer.
    const r0 = Math.max(-1, Math.floor((mouse.y - REACH) / HS));
    const r1 = Math.ceil((mouse.y + REACH) / HS);
    const c0 = Math.max(-1, Math.floor((mouse.x - REACH) / HW) - 1);
    const c1 = Math.ceil((mouse.x + REACH) / HW) + 1;

    for (let r = r0; r <= r1; r++) {
      for (let c = c0; c <= c1; c++) {
        const x = c * HW + (r % 2 ? HW / 2 : 0);
        const y = r * HS;
        const dx = mouse.x - x;
        const dy = mouse.y - y;
        const dist = Math.hypot(dx, dy);
        if (dist >= REACH) continue;

        const heat = 1 - dist / REACH;
        if (heat <= 0.04) continue;

        hexPath(ctx, x, y);
        ctx.fillStyle = `rgba(${rgb}, ${Math.min(0.32, heat * 0.28)})`;
        ctx.fill();
        ctx.strokeStyle = `rgba(${rgb}, ${Math.min(0.95, heat * 1.05)})`;
        ctx.lineWidth = 2.2;
        ctx.shadowColor = `rgb(${rgb})`;
        ctx.shadowBlur = 16 * heat;
        ctx.stroke();
        ctx.shadowBlur = 0;
      }
    }
  }

  window.addEventListener('pointermove', (e) => {
    mouse.x = e.clientX;
    mouse.y = e.clientY;
    lastMove = performance.now();
  }, { passive: true });

  window.addEventListener('resize', resize);
  resize();
  raf = requestAnimationFrame(frame);
})();
