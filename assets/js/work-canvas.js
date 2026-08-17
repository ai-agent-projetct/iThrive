/**
 * The gallery — an infinite canvas of the sites we have shipped.
 *
 * Drag it, throw it, wheel to zoom. The grid tiles forever in both axes, so
 * there is no edge to hit and no "page 2": you wander, which is the right verb
 * for looking at work.
 *
 * Modelled on Origin Kit's Infinity Canvas — momentum with friction, wheel
 * zoom about the cursor, per-tile parallax drift — but written against a 2D
 * canvas rather than a React/Framer component, because this page already runs
 * a WebGL corridor behind it and a second animation framework to look at eight
 * JPEGs would be a poor trade.
 *
 * How the infinity works: the world is one grid of N tiles repeated on a fixed
 * pitch. To draw, we work out which grid cells fall inside the viewport right
 * now and draw only those, taking each cell's image by its wrapped index. Cost
 * is proportional to what is on screen, not to how far you have travelled, so
 * you can drag for a minute and it costs exactly the same as the first frame.
 *
 * Falls back to a plain responsive grid of links when the canvas cannot run,
 * which is also what a crawler and a keyboard user get — the markup underneath
 * is a real list of anchors, and it stays in the DOM either way.
 */

/* The kinetic band's image fill travels with scroll. It lives here rather than
   in its own file because it is nine lines and shares the same page. */
(function () {
  const track = document.querySelector('[data-kinetic]');
  if (!track || window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

  let raf = 0;
  const onScroll = () => {
    if (raf) return;
    raf = requestAnimationFrame(() => {
      raf = 0;
      const r = track.getBoundingClientRect();
      // -1 well below the fold, +1 well above it.
      const t = (window.innerHeight / 2 - (r.top + r.height / 2)) / window.innerHeight;
      track.style.setProperty('--shift', (t * 520).toFixed(1) + 'px');
    });
  };
  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();
})();

(function () {
  'use strict';

  const root = document.querySelector('[data-work-canvas]');
  if (!root) return;

  const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  if (reduce) return; // The static list underneath is the whole experience.

  const items = Array.from(root.querySelectorAll('[data-work-item]')).map((el) => ({
    src: el.dataset.shot || null,
    name: el.dataset.name,
    kind: el.dataset.kind,
    // A tile with no shot is a text card — same canvas, drawn rather than
    // photographed. That is what lets this serve both the site gallery and the
    // "what is different" wall without a second implementation.
    body: el.dataset.body || null,
    tint: el.dataset.tint || '#1b2540',
    href: el.getAttribute('href') || null,
    img: null,
    ready: false,
  }));
  if (!items.length) return;

  const canvas = document.createElement('canvas');
  canvas.className = 'work-canvas';
  canvas.setAttribute('role', 'presentation');
  root.prepend(canvas);

  const ctx = canvas.getContext('2d', { alpha: true });

  /* ---- world ----------------------------------------------------------- */

  const TILE_W = 420;          // tile size in world units
  const TILE_H = 263;          // 1.6:1, matching the captures
  const GAP_X = 84;
  const GAP_Y = 96;
  const COLS = 4;              // grid is COLS wide before it repeats

  const PITCH_X = TILE_W + GAP_X;
  const PITCH_Y = TILE_H + GAP_Y;
  const ROWS = Math.ceil(items.length / COLS);
  const WORLD_W = COLS * PITCH_X;
  const WORLD_H = ROWS * PITCH_Y;

  let w = 0, h = 0, dpr = 1;
  let camX = 0, camY = 0;      // world point at viewport centre
  let vX = 0, vY = 0;          // momentum
  let zoom = 1, zoomTarget = 1;

  let dragging = false, moved = 0;
  let lastX = 0, lastY = 0, downX = 0, downY = 0;
  let hover = null;
  let raf = 0, onScreen = false;

  /* ---- images ---------------------------------------------------------- */

  items.forEach((it) => {
    if (!it.src) return;
    const img = new Image();
    img.decoding = 'async';
    img.src = it.src;
    img.onload = () => { it.img = img; it.ready = true; };
  });

  /** Wrap to a width, in canvas units. */
  function wrap(text, maxW) {
    const words = String(text).split(' ');
    const lines = [];
    let line = '';
    for (const w of words) {
      const next = line ? line + ' ' + w : w;
      if (ctx.measureText(next).width > maxW && line) { lines.push(line); line = w; }
      else line = next;
    }
    if (line) lines.push(line);

    return lines;
  }

  /* ---- sizing ---------------------------------------------------------- */

  function resize() {
    const r = root.getBoundingClientRect();
    dpr = Math.min(window.devicePixelRatio || 1, 2);
    w = Math.max(1, Math.round(r.width));
    h = Math.max(1, Math.round(r.height));
    canvas.width = w * dpr;
    canvas.height = h * dpr;
    canvas.style.width = w + 'px';
    canvas.style.height = h + 'px';
    ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
  }

  /* ---- drawing --------------------------------------------------------- */

  const roundRect = (x, y, rw, rh, r) => {
    ctx.beginPath();
    ctx.moveTo(x + r, y);
    ctx.arcTo(x + rw, y, x + rw, y + rh, r);
    ctx.arcTo(x + rw, y + rh, x, y + rh, r);
    ctx.arcTo(x, y + rh, x, y, r);
    ctx.arcTo(x, y, x + rw, y, r);
    ctx.closePath();
  };

  // Positive modulo — JS's % keeps the sign of the dividend, which would tear
  // the grid the moment you drag past the origin.
  const mod = (n, m) => ((n % m) + m) % m;

  function draw() {
    ctx.clearRect(0, 0, w, h);

    const z = zoom;
    const halfW = w / (2 * z);
    const halfY = h / (2 * z);

    // Which grid cells can be seen right now.
    const c0 = Math.floor((camX - halfW) / PITCH_X) - 1;
    const c1 = Math.ceil((camX + halfW) / PITCH_X) + 1;
    const r0 = Math.floor((camY - halfY) / PITCH_Y) - 1;
    const r1 = Math.ceil((camY + halfY) / PITCH_Y) + 1;

    hover = null;

    for (let r = r0; r <= r1; r++) {
      for (let c = c0; c <= c1; c++) {
        // Wrapped index — this is what makes the grid infinite.
        const idx = mod(mod(r, ROWS) * COLS + mod(c, COLS), items.length);
        const it = items[idx];

        // Parallax drift: alternate rows lag slightly, so the field has depth
        // instead of moving as one rigid sheet.
        const drift = ((mod(c, 3) - 1) * 26) + Math.sin(r * 1.7) * 18;

        const wx = c * PITCH_X;
        const wy = r * PITCH_Y + drift;

        // World to screen.
        const sx = (wx - camX) * z + w / 2;
        const sy = (wy - camY) * z + h / 2;
        const sw = TILE_W * z;
        const sh = TILE_H * z;

        if (sx + sw < -40 || sx > w + 40 || sy + sh < -40 || sy > h + 40) continue;

        const isHover = pointer.x >= sx && pointer.x <= sx + sw && pointer.y >= sy && pointer.y <= sy + sh;
        if (isHover) hover = it;

        ctx.save();
        roundRect(sx, sy, sw, sh, 14 * z);
        ctx.clip();

        if (it.ready) {
          ctx.drawImage(it.img, sx, sy, sw, sh);
        } else if (it.body) {
          // Text tile: tinted panel, heading, wrapped body.
          ctx.fillStyle = '#0E1524';
          ctx.fillRect(sx, sy, sw, sh);
          const wash = ctx.createLinearGradient(sx, sy, sx + sw, sy + sh);
          wash.addColorStop(0, it.tint + '55');
          wash.addColorStop(1, 'rgba(10,16,28,0)');
          ctx.fillStyle = wash;
          ctx.fillRect(sx, sy, sw, sh);

          const pad = 26 * z;
          ctx.fillStyle = 'rgba(255,255,255,.96)';
          ctx.font = `700 ${Math.round(20 * z)}px Outfit, Segoe UI, sans-serif`;
          wrap(it.name, sw - pad * 2).slice(0, 2).forEach((ln, k) => {
            ctx.fillText(ln, sx + pad, sy + pad + 20 * z + k * 24 * z);
          });

          ctx.fillStyle = 'rgba(190,205,235,.72)';
          ctx.font = `400 ${Math.round(13 * z)}px Outfit, Segoe UI, sans-serif`;
          wrap(it.body, sw - pad * 2).slice(0, 7).forEach((ln, k) => {
            ctx.fillText(ln, sx + pad, sy + pad + 84 * z + k * 19 * z);
          });
        } else {
          ctx.fillStyle = '#101728';
          ctx.fillRect(sx, sy, sw, sh);
        }

        // Unhovered tiles sit back behind a scrim so the one under the cursor
        // is obviously the subject.
        ctx.fillStyle = isHover ? 'rgba(4,8,18,0.04)' : 'rgba(4,8,18,0.42)';
        ctx.fillRect(sx, sy, sw, sh);
        ctx.restore();

        ctx.strokeStyle = isHover ? 'rgba(0,242,254,0.85)' : 'rgba(120,150,220,0.20)';
        ctx.lineWidth = isHover ? 2 : 1;
        roundRect(sx + 0.5, sy + 0.5, sw - 1, sh - 1, 14 * z);
        ctx.stroke();

        // Captions only once the tile is big enough to read them.
        if (z > 0.55 && !it.body) {
          ctx.fillStyle = isHover ? 'rgba(255,255,255,0.98)' : 'rgba(226,236,255,0.62)';
          ctx.font = `600 ${Math.round(15 * z)}px Outfit, Segoe UI, sans-serif`;
          ctx.fillText(it.name, sx + 16 * z, sy + sh + 24 * z);
          ctx.fillStyle = 'rgba(150,170,210,0.55)';
          ctx.font = `400 ${Math.round(12.5 * z)}px Outfit, Segoe UI, sans-serif`;
          ctx.fillText(it.kind, sx + 16 * z, sy + sh + 42 * z);
        }
      }
    }

    canvas.style.cursor = dragging ? 'grabbing' : (hover && hover.href ? 'pointer' : 'grab');
  }

  /* ---- loop ------------------------------------------------------------ */

  function tick() {
    raf = requestAnimationFrame(tick);
    if (!onScreen) return;

    if (!dragging) {
      // Friction. Below a pixel a frame it is not motion, it is jitter.
      camX += vX; camY += vY;
      vX *= 0.94; vY *= 0.94;
      if (Math.abs(vX) < 0.02) vX = 0;
      if (Math.abs(vY) < 0.02) vY = 0;
    }

    zoom += (zoomTarget - zoom) * 0.14;
    draw();
  }

  /* ---- input ----------------------------------------------------------- */

  const pointer = { x: -9999, y: -9999 };

  canvas.addEventListener('pointerdown', (e) => {
    dragging = true; moved = 0;
    lastX = downX = e.clientX;
    lastY = downY = e.clientY;
    vX = vY = 0;
    canvas.setPointerCapture(e.pointerId);
  });

  canvas.addEventListener('pointermove', (e) => {
    const r = canvas.getBoundingClientRect();
    pointer.x = e.clientX - r.left;
    pointer.y = e.clientY - r.top;
    if (!dragging) return;

    const dx = (e.clientX - lastX) / zoom;
    const dy = (e.clientY - lastY) / zoom;
    camX -= dx; camY -= dy;
    vX = -dx; vY = -dy;
    moved += Math.abs(dx) + Math.abs(dy);
    lastX = e.clientX; lastY = e.clientY;
  });

  const release = () => { dragging = false; };
  canvas.addEventListener('pointerup', (e) => {
    release();
    // A drag that barely moved was a click. Ten pixels of slack, because a
    // click on a trackpad is never perfectly still.
    if (moved < 10 && hover && hover.href) window.open(hover.href, '_blank', 'noopener');
  });
  canvas.addEventListener('pointercancel', release);
  canvas.addEventListener('pointerleave', () => { pointer.x = pointer.y = -9999; });

  canvas.addEventListener('wheel', (e) => {
    e.preventDefault();
    const r = canvas.getBoundingClientRect();
    const px = e.clientX - r.left;
    const py = e.clientY - r.top;

    // Zoom about the cursor: keep the world point under the pointer fixed.
    const before = { x: camX + (px - w / 2) / zoom, y: camY + (py - h / 2) / zoom };
    zoomTarget = Math.min(2.2, Math.max(0.32, zoomTarget * (e.deltaY > 0 ? 0.9 : 1.1)));
    const after = { x: camX + (px - w / 2) / zoomTarget, y: camY + (py - h / 2) / zoomTarget };
    camX += before.x - after.x;
    camY += before.y - after.y;
  }, { passive: false });

  // Keyboard: the canvas is a convenience, so arrows nudge and +/- zoom. The
  // real keyboard path is the anchor list underneath, which stays focusable.
  canvas.tabIndex = 0;
  canvas.addEventListener('keydown', (e) => {
    const N = 120 / zoom;
    if (e.key === 'ArrowLeft') camX -= N;
    else if (e.key === 'ArrowRight') camX += N;
    else if (e.key === 'ArrowUp') camY -= N;
    else if (e.key === 'ArrowDown') camY += N;
    else if (e.key === '+' || e.key === '=') zoomTarget = Math.min(2.2, zoomTarget * 1.18);
    else if (e.key === '-') zoomTarget = Math.max(0.32, zoomTarget / 1.18);
    else return;
    e.preventDefault();
  });

  window.addEventListener('resize', resize);

  if ('IntersectionObserver' in window) {
    new IntersectionObserver(([e]) => { onScreen = e.isIntersecting; }, { threshold: 0 }).observe(root);
  } else {
    onScreen = true;
  }

  // Start part-way into the world so the opening view is a field of tiles
  // rather than the top-left corner of one.
  camX = WORLD_W * 0.5;
  camY = WORLD_H * 0.5;

  resize();
  root.classList.add('work--canvas-live');
  raf = requestAnimationFrame(tick);
})();
