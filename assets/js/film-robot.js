/**
 * The film's robot, given eyes.
 *
 * The hero is the reference film itself — that robot, in that field, with that
 * lighting. Nothing here is a rebuild of him, because a rebuild is not him.
 *
 * What the film cannot do on its own is look at you. It is twelve seconds of a
 * figure standing almost perfectly still: measured across the whole clip his
 * head moves two pixels in a 1928-wide frame, and there is no turn, no reach,
 * no second angle anywhere in it to cut to. So the thing that follows your
 * pointer is what can honestly follow it — his eyes, and his mouth, drawn as
 * glowing light onto the dark visor he already has. The rest of the response is
 * the whole picture leaning, which is parallax, not animation.
 *
 * Because he holds still, the visor needs no tracking: it is a fixed point in
 * the source frame, measured off it, and mapped through whatever size the video
 * is actually being drawn at.
 */

(function () {
  'use strict';

  const HOST = document.querySelector('[data-film-robot]');
  if (!HOST) return;

  const video = HOST.querySelector('video');
  const canvas = HOST.querySelector('canvas');
  if (!video || !canvas) return;

  const ctx = canvas.getContext('2d');
  if (!ctx) return;

  /* ---- where he is, in the source frame --------------------------------- */

  // Measured off the footage: the helmet's dark face plate is centred here and
  // is this wide, in a 1928x1072 frame. He does not move, so these are constants
  // rather than something tracked per frame.
  const SRC_W = 1928, SRC_H = 1072;
  const VISOR_X = 990, VISOR_Y = 331, VISOR_W = 44;

  /*
   * Framing. The film is a wide shot and he is small in it — fine for a film,
   * far too small for a hero — so it is pushed in past "cover" and anchored on
   * him: the point SRC lands at the point DST, and he ends up right of centre
   * with the copy on the left.
   */
  const SRC_X = 990 / SRC_W, SRC_Y = 470 / SRC_H;   // his chest, in the frame
  const DST_Y = 0.5;                                // where that goes on screen

  /* ---- fit the video to the box ourselves ------------------------------- */

  /*
   * object-fit would do this, but then the mapping from source pixels to screen
   * pixels lives inside the browser and has to be reverse-engineered to place
   * the eyes. Sizing the video here means the same numbers draw it and place
   * them, so they cannot drift apart.
   */
  let fit = { scale: 1, x: 0, y: 0 };

  function layout() {
    const W = HOST.clientWidth;
    const H = HOST.clientHeight;
    if (!W || !H) return;

    // Narrow screens give the film its own band above the copy rather than
    // sitting behind it, so he is centred there and pushed in less.
    const narrow = W < 900;
    const DST_X = narrow ? 0.5 : 0.62;
    const zoom = narrow ? 1.15 : 1.5;
    const scale = Math.max(W / SRC_W, H / SRC_H) * zoom;
    const w = SRC_W * scale;
    const h = SRC_H * scale;

    // Anchored on him, then clamped so no edge of the film pulls into frame.
    const x = Math.min(0, Math.max(W - w, W * DST_X - w * SRC_X));
    const y = Math.min(0, Math.max(H - h, H * DST_Y - h * SRC_Y));

    fit = { scale, x, y };

    video.style.width = w + 'px';
    video.style.height = h + 'px';
    video.style.left = x + 'px';
    video.style.top = y + 'px';

    const dpr = Math.min(window.devicePixelRatio || 1, 2);
    canvas.width = W * dpr;
    canvas.height = H * dpr;
    canvas.style.width = W + 'px';
    canvas.style.height = H + 'px';
    ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
  }

  layout();
  window.addEventListener('resize', layout);
  if ('ResizeObserver' in window) new ResizeObserver(layout).observe(HOST);
  video.addEventListener('loadedmetadata', layout);

  /* ---- the pointer ------------------------------------------------------ */

  const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  const aim = { x: 0, y: 0 };
  let lastMove = 0;

  window.addEventListener('pointermove', (e) => {
    aim.x = (e.clientX / window.innerWidth) * 2 - 1;
    aim.y = (e.clientY / window.innerHeight) * 2 - 1;
    lastMove = performance.now();
  }, { passive: true });

  /* ---- draw ------------------------------------------------------------- */

  const lerp = (a, b, t) => a + (b - a) * t;
  const cur = { x: 0, y: 0, open: 1, px: 0, py: 0 };
  let t = 0, blink = 0, nextBlink = 2.4, last = 0, onScreen = true;

  if ('IntersectionObserver' in window) {
    new IntersectionObserver(([e]) => { onScreen = e.isIntersecting; }, { threshold: 0 })
      .observe(HOST);
  }

  function frame(now) {
    requestAnimationFrame(frame);
    if (!onScreen || !fit.scale) return;

    const dt = last ? Math.min((now - last) / 1000, 0.05) : 0;
    last = now;
    t += dt;

    // Left alone for a few seconds he stops staring and glances about.
    const idle = now - lastMove > 3400 || reduce;
    const ax = idle ? Math.sin(t * 0.4) * 0.55 : aim.x;
    const ay = idle ? Math.sin(t * 0.29) * 0.3 : aim.y;

    cur.x = lerp(cur.x, ax, 0.11);
    cur.y = lerp(cur.y, ay, 0.11);

    // The whole picture leans a little the other way — it is the only depth cue
    // a static frame can offer, and it is what makes the eyes feel attached to
    // something rather than painted on the glass.
    cur.px = lerp(cur.px, -ax * 10, 0.06);
    cur.py = lerp(cur.py, -ay * 6, 0.06);
    video.style.transform = 'translate3d(' + cur.px.toFixed(2) + 'px,' + cur.py.toFixed(2) + 'px,0) scale(1.02)';

    blink += dt;
    if (blink > nextBlink) {
      const p = (blink - nextBlink) / 0.12;
      cur.open = p < 1 ? Math.abs(1 - p * 2) : 1;
      if (p >= 1) { blink = 0; nextBlink = 2 + Math.random() * 3.4; }
    }

    draw();
  }

  function draw() {
    const W = HOST.clientWidth, H = HOST.clientHeight;
    ctx.clearRect(0, 0, W, H);

    // Source pixel -> screen pixel, through the same fit that drew the video,
    // plus the parallax the video itself is carrying.
    const cx = fit.x + VISOR_X * fit.scale + cur.px;
    const cy = fit.y + VISOR_Y * fit.scale + cur.py;
    const u = (VISOR_W * fit.scale) / 44;   // one unit = one source pixel of visor

    if (cx < -80 || cx > W + 80) return;

    // How far the eyes may travel inside the visor: a couple of source pixels.
    const ox = cur.x * 3.4 * u;
    const oy = cur.y * 2.1 * u;

    const eyeGap = 9 * u;
    const eyeW = 7.5 * u;
    const eyeH = Math.max(0.9 * u, 4.6 * u * cur.open);
    const eyeY = cy + oy - 1.5 * u;

    ctx.save();
    ctx.lineCap = 'round';
    ctx.lineJoin = 'round';

    // Two passes: a wide soft bloom, then a hot near-white core. That is what
    // reads as light coming through the visor rather than a sticker on it.
    for (const p of [
      { color: 'rgba(120, 226, 255, .85)', blur: 13 * u, s: 1 },
      { color: 'rgba(240, 253, 255, 1)',   blur: 4 * u,  s: 0.58 },
    ]) {
      ctx.shadowColor = 'rgba(120, 226, 255, .95)';
      ctx.shadowBlur = p.blur;
      ctx.fillStyle = p.color;
      ctx.strokeStyle = p.color;
      ctx.lineWidth = 1.5 * u * p.s;

      for (const side of [-1, 1]) {
        const ex = cx + ox + side * eyeGap;
        const w = eyeW * (p.s * 0.3 + 0.7);
        const h = eyeH * (p.s * 0.3 + 0.7);
        ctx.beginPath();
        ctx.roundRect(ex - w / 2, eyeY - h / 2, w, h, 1.6 * u);
        ctx.fill();
      }

      // A quiet smile, low on the visor. It closes with the blink, so the whole
      // face reacts rather than just the eyes.
      const my = cy + oy * 0.6 + 8.5 * u;
      ctx.beginPath();
      ctx.arc(cx + ox * 0.6, my - 3.4 * u, 6.2 * u * (p.s * 0.3 + 0.7),
              Math.PI * 0.22, Math.PI * 0.78);
      ctx.stroke();
    }
    ctx.restore();
  }

  requestAnimationFrame(frame);
  HOST.classList.add('is-live');
})();
