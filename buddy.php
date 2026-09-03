<?php
/**
 * Buddy — full-screen hero after the Framer reference.
 *
 * Two stacked renders of the same scene: the blanket shot in front, the neon
 * shot behind. Moving the pointer erases the front layer in organic, torn
 * patches that heal back over a few seconds, so the scene keeps returning to
 * the blanket. The erase runs on a low-resolution scalar field: pointer
 * strokes add energy, every frame decays it, and the field is thresholded
 * against a static noise texture — that threshold is what gives the tear its
 * ragged edge instead of a soft airbrush circle.
 */
declare(strict_types=1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Buddy — Your day just got a little easier</title>
<meta name="description" content="Plan your day, stay on track, and get things done with a buddy that's always by your side.">
<meta name="theme-color" content="#0b0716">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Archivo:wght@400;500;600&family=Inter:wght@400;500;600;800&display=swap" rel="stylesheet">
<style>
:root{
  --ink:#fff;
  --pill:#fff;
  --pill-ink:#141414;
  --pad:clamp(20px, 3.2vw, 44px);
  --fit-y:.5;             /* where contained art sits vertically (portrait only) */
  --fit-cover:1;          /* 1 = fill the frame, 0 = fit the whole 16:9 frame in */
}
*{box-sizing:border-box}
html,body{margin:0;height:100%}
body{
  background:#0b0716;color:var(--ink);
  font-family:Inter, system-ui, sans-serif;
  -webkit-font-smoothing:antialiased;
  overflow:hidden;
}

/* ---- stage ------------------------------------------------------------ */
.stage{position:relative;height:100dvh;width:100%;overflow:hidden;cursor:crosshair}
.layer{position:absolute;inset:0;width:100%;height:100%;pointer-events:none}
/* The whole square is always on screen; the leftover area is filled with a
   blurred, over-scaled copy of the same shot so there are no letterbox bars. */
.layer--bleed{
  /* Stretched, not cropped: the fill then takes its colour from the image's
     own edges, so the seam against the contained art disappears. */
  background:url(assets/img/buddy/buddy-neon-wide.webp) 0 0/100% 100% no-repeat;
  filter:blur(48px) saturate(1.15);transform:scale(1.12);
}
.layer--back{object-fit:cover;object-position:50% 50%}
.layer--veil{display:block}
.stage__scrim{
  position:absolute;inset:0;pointer-events:none;
  /* The front layer is near-white, so the scrim has to carry legibility for
     white type on both layers: heavy at the edges, a light wash through the
     middle so the art still reads. */
  background:
    linear-gradient(180deg,
      rgba(8,5,18,.74) 0%,
      rgba(8,5,18,.16) 22%,
      rgba(8,5,18,.16) 42%,
      rgba(8,5,18,.62) 78%,
      rgba(8,5,18,.93) 100%);
}

/* ---- nav -------------------------------------------------------------- */
.nav{
  position:absolute;top:0;left:0;right:0;z-index:3;
  display:flex;align-items:center;justify-content:space-between;
  gap:24px;padding:18px var(--pad);
}
.brand{display:flex;align-items:center;gap:12px;text-decoration:none;color:var(--ink)}
.brand img{width:30px;height:30px;border-radius:9px;display:block}
.brand span{font-family:Archivo,sans-serif;font-size:1.55rem;font-weight:500;letter-spacing:-.025em}
.nav__links{display:flex;align-items:center;gap:4px}
.nav__links a{
  font-family:Archivo,sans-serif;font-size:1rem;font-weight:500;letter-spacing:-.04em;
  color:var(--ink);text-decoration:none;padding:8px 20px;border-radius:999px;
  opacity:.9;transition:opacity .2s, background-color .2s;
}
.nav__links a:hover{opacity:1;background:rgba(255,255,255,.12)}

/* ---- pill button ------------------------------------------------------ */
.pill{
  display:inline-flex;align-items:center;justify-content:center;
  background:var(--pill);color:var(--pill-ink);text-decoration:none;
  border-radius:999px;padding:12px 24px;
  font-family:Archivo,sans-serif;font-size:.94rem;font-weight:600;letter-spacing:.025em;
  transition:transform .25s cubic-bezier(.16,1,.3,1), box-shadow .25s;
}
.pill:hover{transform:translateY(-2px);box-shadow:0 10px 30px rgba(0,0,0,.35)}

/* ---- bottom band ------------------------------------------------------ */
.band{
  position:absolute;left:0;right:0;bottom:0;z-index:2;
  display:flex;align-items:flex-end;justify-content:space-between;
  gap:40px;padding:0 var(--pad) clamp(28px,4.4vh,56px);
}
.eyebrow{
  display:flex;align-items:center;gap:10px;margin:0 0 22px;
  font-size:.875rem;font-weight:600;letter-spacing:.01em;text-transform:uppercase;
}
.eyebrow svg{width:14px;height:14px;flex:none}
h1{
  margin:0;text-transform:uppercase;
  font-size:clamp(2.5rem, 5.6vw, 5.4rem);
  font-weight:800;line-height:.86;letter-spacing:-.045em;
}
.support{max-width:34ch;text-align:right;margin-left:auto}
.support p{margin:0 0 26px;font-size:clamp(1rem,1.35vw,1.25rem);line-height:1.2;letter-spacing:-.01em}
.band > *{animation:rise .9s cubic-bezier(.16,1,.3,1) both;animation-delay:.15s}
.band > *:last-child{animation-delay:.3s}
@keyframes rise{from{opacity:0;transform:translateY(26px)}to{opacity:1;transform:none}}

/* Fades out for good once the visitor has moved the pointer. */
.hint{
  position:absolute;left:50%;top:calc(50% + 60px);transform:translateX(-50%);
  z-index:2;margin:0;font-size:.78rem;font-weight:500;letter-spacing:.16em;
  text-transform:uppercase;color:rgba(255,255,255,.72);pointer-events:none;
  text-shadow:0 2px 14px rgba(0,0,0,.55);
  animation:pulse 2.6s ease-in-out infinite;transition:opacity .5s;
}
.is-touched .hint{animation:none;opacity:0}
@keyframes pulse{0%,100%{opacity:.5}50%{opacity:1}}

@media (max-width:860px){
  /* Portrait can't crop a 16:9 frame and keep the pair in shot, so it fits the
     whole frame instead, held high with the copy in the clear space below. */
  :root{--fit-y:.3;--fit-cover:0}
  /* A square window onto the middle of the frame: the invented side panels are
     cropped away and the pair still fills the width. */
  .layer--back{
    inset:auto;left:0;width:100%;height:100vw;
    top:calc((100dvh - 100vw) * var(--fit-y));
  }
  .nav__links{display:none}
  .band{flex-direction:column;align-items:flex-start;gap:26px}
  .support{text-align:left;margin-left:0;max-width:38ch}
  .support p{margin-bottom:20px}
}
@media (prefers-reduced-motion:reduce){ .band > *,.hint{animation:none} }
</style>
</head>
<body>

<main class="stage" id="stage">
  <div class="layer layer--bleed"></div>
  <img class="layer layer--back" id="back" src="assets/img/buddy/buddy-neon-wide.webp" alt="Two friendly robots on a couch under neon signs" fetchpriority="high">
  <canvas class="layer layer--veil" id="veil"></canvas>
  <div class="stage__scrim"></div>

  <nav class="nav">
    <a class="brand" href="#">
      <img src="assets/img/logo-mark.png" width="30" height="30" alt="">
      <span>Buddy</span>
    </a>
    <div class="nav__links">
      <a href="#">Home</a>
      <a href="#">About</a>
      <a href="#">Features</a>
      <a href="#">Pricing</a>
    </div>
    <a class="pill" href="#">DOWNLOAD NOW</a>
  </nav>

  <p class="hint">Move to reveal</p>

  <div class="band">
    <div>
      <p class="eyebrow">
        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 0l2.4 7.2L21.6 9.6 14.4 12 12 19.2 9.6 12 2.4 9.6 9.6 7.2z"/></svg>
        Your personal productivity buddy
      </p>
      <h1>Your day just<br>got a little<br>easier.</h1>
    </div>

    <div class="support">
      <p>Plan your day, stay on track, and get things done with a buddy that&rsquo;s always by your side.</p>
      <a class="pill" href="#">MEET YOUR BUDDY</a>
    </div>
  </div>
</main>

<script>
(() => {
  const stage = document.getElementById('stage');
  const veil  = document.getElementById('veil');
  const ctx   = veil.getContext('2d');

  const front = new Image();
  front.src = 'assets/img/buddy/buddy-couch-wide.webp';

  const MASK_MAX  = 440;   // longest edge of the field, in cells
  const DECAY     = 0.982; // per frame — the tear heals in ~3s
  const THRESHOLD = 0.5;
  const NOISE_AMT = 0.42;  // how much the noise ruffles the tear's edge

  let W = 0, H = 0, mw = 0, mh = 0, cell = 1;
  let field, noise, maskCanvas, mctx, mdata;
  let last = null, energy = 0, running = false;

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

  /* `object-fit` in numbers, so the front canvas crops exactly like the back
     <img>: contain for the artwork, cover (over-scaled) for the blurred bleed. */
  /* The box the art covers, and the rect it covers it with — mirrors the CSS
     on .layer--back in both modes so the two layers stay registered. */
  function fitBox() {
    const css   = getComputedStyle(document.documentElement);
    const cover = parseFloat(css.getPropertyValue('--fit-cover')) === 1;
    if (cover) return { x: 0, y: 0, w: W, h: H };
    const posY = parseFloat(css.getPropertyValue('--fit-y')) || 0.5;
    return { x: 0, y: (H - W) * posY, w: W, h: W };   // square window
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
    if (!running) { running = true; requestAnimationFrame(tick); }
  }

  function draw() {
    if (!front.complete || !front.naturalWidth) return;
    const d = ctx.canvas.width / W;
    ctx.setTransform(d, 0, 0, d, 0, 0);
    ctx.globalCompositeOperation = 'source-over';
    ctx.clearRect(0, 0, W, H);
    const iw = front.naturalWidth, ih = front.naturalHeight;
    ctx.filter = 'blur(48px) saturate(1.15)';
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
  addEventListener('resize', resize);
  stage.addEventListener('pointermove', e => onMove(e.clientX, e.clientY));
  stage.addEventListener('pointerleave', () => { last = null; });
  stage.addEventListener('touchmove', e => {
    const t = e.touches[0]; if (t) onMove(t.clientX, t.clientY);
  }, { passive: true });

  resize();
})();
</script>

</body>
</html>
