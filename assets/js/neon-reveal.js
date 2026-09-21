/**
 * Tear reveal — two registered renders of one scene, the front one erased by
 * the pointer in organic patches that heal back over a few seconds.
 *
 * The back layer is an <img> the markup already holds; the front layer is
 * painted to a <canvas> on top of it and punched through with a mask. That
 * mask is a low-resolution scalar field: pointer strokes add energy, every
 * frame decays it, and the field is thresholded against a static noise texture
 * — the threshold is what gives the tear a ragged edge instead of a soft
 * airbrush circle.
 *
 * The first paint happens synchronously inside init, not inside rAF, so a tab
 * that never gets a frame still shows the front layer rather than an empty
 * rectangle.
 *
 * Markup contract, per instance:
 *
 *   <div data-neon-reveal data-front="…front.webp">
 *     <img …back.webp>          the layer the tear reveals
 *     <canvas></canvas>         the layer the tear is torn out of
 *   </div>
 *
 * Geometry comes from three custom properties, read off the stage so each
 * instance can answer its own media queries:
 *
 *   --fit-cover  1 = fill the frame (crop), 0 = fit the whole frame in
 *   --fit-ar     the art's height / width, used by the fit case
 *   --fit-y      where the fitted art sits vertically, 0..1
 */

const MASK_MAX  = 440;   // longest edge of the field, in cells
const DECAY     = 0.982; // per frame — the tear heals in ~3s
const THRESHOLD = 0.5;
const NOISE_AMT = 0.42;  // how much the noise ruffles the tear's edge

export function initNeonReveal(stage) {
  const veil = stage.querySelector('canvas');
  if (!veil || !stage.dataset.front) return;

  const ctx   = veil.getContext('2d');
  const front = new Image();
  front.src = stage.dataset.front;

  let W = 0, H = 0, mw = 0, mh = 0, cell = 1;
  let field, noise, maskCanvas, mctx, mdata;
  let last = null, energy = 0, running = false, lastFrame = 0;

  /* Value noise: a coarse random lattice, smoothstep-interpolated. Built once
     per resize; a static texture is enough to break up the edge. */
  function buildNoise() {
    const G = 26, g = new Float32Array((G + 1) * (G + 1));
    for (let i = 0; i < g.length; i++) g[i] = Math.random();
    const sm = t => t * t * (3 - 2 * t);
    noise = new Float32Array(mw * mh);
    for (let y = 0; y < mh; y++) {
      const fy = y / mh * G, y0 = Math.floor(fy), ty = sm(fy - y0);
      for (let x = 0; x < mw; x++) {
        const fx = x / mw * G, x0 = Math.floor(fx), tx = sm(fx - x0);
        const a = g[y0 * (G + 1) + x0],       b = g[y0 * (G + 1) + x0 + 1];
        const c = g[(y0 + 1) * (G + 1) + x0], d = g[(y0 + 1) * (G + 1) + x0 + 1];
        const top = a + (b - a) * tx, bot = c + (d - c) * tx;
        noise[y * mw + x] = top + (bot - top) * ty;
      }
    }
  }

  function resize() {
    const dpr = Math.min(devicePixelRatio || 1, 2);
    W = stage.clientWidth; H = stage.clientHeight;
    if (!W || !H) return;
    veil.width = Math.round(W * dpr); veil.height = Math.round(H * dpr);
    veil.style.width = W + 'px'; veil.style.height = H + 'px';

    const s = MASK_MAX / Math.max(W, H);
    mw = Math.max(2, Math.round(W * s)); mh = Math.max(2, Math.round(H * s));
    cell = W / mw;

    field = new Float32Array(mw * mh);
    maskCanvas = maskCanvas || document.createElement('canvas');
    maskCanvas.width = mw; maskCanvas.height = mh;
    mctx = maskCanvas.getContext('2d');
    mdata = mctx.createImageData(mw, mh);
    for (let i = 0; i < mw * mh; i++) {           // white pixels; only alpha moves
      mdata.data[i * 4] = mdata.data[i * 4 + 1] = mdata.data[i * 4 + 2] = 255;
    }
    buildNoise();
    energy = 0; last = null;
    draw();
  }

  /* The box the art covers, and the rect it covers it with — mirrors the CSS
     on the back <img> in both modes so the two layers stay registered. */
  function fitBox() {
    const css = getComputedStyle(stage);
    if (parseFloat(css.getPropertyValue('--fit-cover')) === 1) return { x: 0, y: 0, w: W, h: H };
    const ar  = parseFloat(css.getPropertyValue('--fit-ar')) || 0.5628;
    const h   = W * ar;
    const top = parseFloat(css.getPropertyValue('--fit-top'));   // px, when the art is pinned
    const y   = Number.isFinite(top) ? top : (H - h) * (parseFloat(css.getPropertyValue('--fit-y')) || 0.5);
    return { x: 0, y, w: W, h };
  }

  function fitRect(box, iw, ih) {
    const s = Math.max(box.w / iw, box.h / ih), w = iw * s, h = ih * s;
    return { x: box.x + (box.w - w) * 0.5, y: box.y + (box.h - h) * 0.5, w, h };
  }

  function stamp(x, y) {
    const r = Math.max(14, Math.min(mw, mh) * 0.19), r2 = r * r;
    const x0 = Math.max(0, (x - r) | 0), x1 = Math.min(mw - 1, (x + r) | 0);
    const y0 = Math.max(0, (y - r) | 0), y1 = Math.min(mh - 1, (y + r) | 0);
    for (let j = y0; j <= y1; j++) {
      const dy = j - y;
      for (let i = x0; i <= x1; i++) {
        const dx = i - x, d2 = dx * dx + dy * dy;
        if (d2 > r2) continue;
        const f = 1 - d2 / r2;
        const k = j * mw + i;
        field[k] = Math.min(1.35, field[k] + f * f * 0.34);
      }
    }
    energy = 1;
  }

  function onMove(clientX, clientY) {
    if (!field) return;
    const rect = stage.getBoundingClientRect();
    const x = (clientX - rect.left) / cell, y = (clientY - rect.top) / cell;
    if (last) {                                   // interpolate, so fast moves stay solid
      const dx = x - last.x, dy = y - last.y;
      const steps = Math.min(24, Math.ceil(Math.hypot(dx, dy) / 4));
      for (let i = 1; i <= steps; i++) stamp(last.x + dx * i / steps, last.y + dy * i / steps);
    }
    stamp(x, y);
    last = { x, y };
    stage.classList.add('is-touched');
    /* The heal runs on rAF, but the tear itself must not depend on one ever
       arriving: an occluded or throttled tab hands out no frames, and the old
       code both skipped the paint and latched `running`, so the hero stayed
       whole for good once that happened. Paint here when a frame has not been
       seen recently — when rAF is healthy tick() keeps lastFrame current and
       this never fires. */
    if (performance.now() - lastFrame > 120) { lastFrame = performance.now(); draw(); }
    if (!running) { running = true; requestAnimationFrame(tick); }
  }

  function draw() {
    if (!front.complete || !front.naturalWidth || !W) return;
    const d = ctx.canvas.width / W;
    ctx.setTransform(d, 0, 0, d, 0, 0);
    ctx.globalCompositeOperation = 'source-over';
    ctx.clearRect(0, 0, W, H);
    const iw = front.naturalWidth, ih = front.naturalHeight;
    ctx.filter = 'blur(48px) saturate(1.15)';     // the bleed, so the fit case has no bars
    ctx.drawImage(front, -W * 0.06, -H * 0.06, W * 1.12, H * 1.12);
    ctx.filter = 'none';
    const box = fitBox(), r = fitRect(box, iw, ih);
    ctx.save();
    ctx.beginPath(); ctx.rect(box.x, box.y, box.w, box.h); ctx.clip();
    ctx.drawImage(front, r.x, r.y, r.w, r.h);
    ctx.restore();

    if (energy > 0) {
      const px = mdata.data;
      for (let i = 0, n = mw * mh; i < n; i++) {
        px[i * 4 + 3] = field[i] + noise[i] * NOISE_AMT > THRESHOLD ? 255 : 0;
      }
      mctx.putImageData(mdata, 0, 0);
      ctx.globalCompositeOperation = 'destination-out';
      ctx.imageSmoothingEnabled = true;
      ctx.drawImage(maskCanvas, 0, 0, W, H);      // punches the tear through the front layer
      ctx.globalCompositeOperation = 'source-over';
    }
  }

  function tick() {
    lastFrame = performance.now();
    let max = 0;
    for (let i = 0, n = field.length; i < n; i++) {
      const v = field[i] * DECAY;
      field[i] = v < 0.002 ? 0 : v;
      if (v > max) max = v;
    }
    energy = max;
    draw();
    if (energy > 0) requestAnimationFrame(tick);
    else { running = false; last = null; }
  }

  front.addEventListener('load', draw);
  /* Observing the stage rather than the window: it also catches the case where
     the page lays out at zero (loaded in a hidden tab) and gets its size later. */
  new ResizeObserver(resize).observe(stage);
  stage.addEventListener('pointermove', e => onMove(e.clientX, e.clientY));
  stage.addEventListener('pointerleave', () => { last = null; });
  stage.addEventListener('touchmove', e => {
    const t = e.touches[0]; if (t) onMove(t.clientX, t.clientY);
  }, { passive: true });

  resize();
}

document.querySelectorAll('[data-neon-reveal]').forEach(initNeonReveal);
