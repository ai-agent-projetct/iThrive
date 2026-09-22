/**
 * The character in the home hero — she looks wherever the pointer goes.
 *
 * Sixty-four frames of a head turning through a full circle, plus a centre
 * frame where she looks straight out. The pointer's angle around her face
 * picks the frame; inside a small deadzone she meets your eye instead.
 *
 * Three things keep it smooth, and they are the difference between this and a
 * loop that stutters:
 *
 *   Decode once. Frames become ImageBitmaps at load, so a draw is a blit
 *   rather than a decode. An <img> redrawn every frame is what makes this kind
 *   of thing chug.
 *
 *   Draw only on change. The canvas is repainted when the chosen frame differs
 *   from the one on screen, not sixty times a second regardless. Holding still
 *   costs nothing.
 *
 *   Ease in real time. Both the pointer lerp and the angular lerp are raised to
 *   the frame's delta, so the motion lands the same on a 60Hz panel and a 144Hz
 *   one instead of running faster on the quicker screen.
 *
 * The loop is stopped while the hero is off screen or the tab is hidden, and
 * under prefers-reduced-motion she simply holds the centre frame.
 */

const FRAME_COUNT = 64;
const BASE = document.currentScript?.dataset?.base || '/assets/img/character';

/* Lerp weights, expressed per 60Hz frame and corrected for real delta below. */
const POINTER_EASE = 0.26;
const ANGLE_EASE = 0.22;

/* She holds eye contact while the pointer is within this share of the stage. */
const DEADZONE = 0.16;

/* Where the face sits inside the frame, where that point is placed in the
   stage, and how much of the stage's height the figure fills. These are the
   home hero's; a page tunes them on the canvas itself, because the robot on
   the hire page stands in a different place to her. */
const DEFAULTS = {
  faceX: 0.5,
  faceY: 0.46,
  stageX: 0.655,
  stageY: 0.44,
  fill: 1.0,
};

const canvas = document.querySelector('[data-character-canvas]');

if (canvas) {
  const ctx = canvas.getContext('2d', { alpha: true });
  const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  const base = canvas.dataset.base || BASE;

  const num = (name, fallback) => {
    const v = parseFloat(canvas.dataset[name]);
    return Number.isFinite(v) ? v : fallback;
  };
  const FACE_X = num('faceX', DEFAULTS.faceX);
  const FACE_Y = num('faceY', DEFAULTS.faceY);
  const STAGE_X = num('stageX', DEFAULTS.stageX);
  const STAGE_Y = num('stageY', DEFAULTS.stageY);
  const FILL = num('fill', DEFAULTS.fill);

  const frames = new Array(FRAME_COUNT).fill(null);
  let centre = null;
  let painted = null;      // what is on the canvas right now
  let cssW = 0, cssH = 0;

  const pointer = { x: 0, y: 0, sx: 0, sy: 0, moved: false };
  let angle = -Math.PI / 2;
  let running = false;
  let visible = false;
  let raf = 0;
  let last = 0;

  /* ---------------------------------------------------------------- load */

  /* The version comes from the page, which stamps it from the frames' own
     mtime. Without it a browser that fetched an earlier set keeps serving it
     from cache for as long as it likes — which is how a fixed set of frames
     still looks broken on the machine that saw the old one. */
  const ver = canvas.dataset.version ? `?v=${encodeURIComponent(canvas.dataset.version)}` : '';

  async function bitmap(url) {
    const res = await fetch(url + ver, { cache: 'default' });
    if (!res.ok) throw new Error(url);
    return createImageBitmap(await res.blob());
  }

  async function load() {
    /* The centre frame first and on its own: it is the one she holds before a
       pointer ever moves, so the hero is never an empty box while the rest
       arrive. */
    try {
      centre = await bitmap(`${base}/center.webp`);
      /* Sized before the first paint on purpose: requestAnimationFrame does
         not run in a hidden tab, so a paint that waited for the loop would
         land in the canvas's default 300x150 buffer and be stretched to the
         stage. Sizing here means the hero is correct the moment she loads,
         whether or not the loop has ever ticked. */
      resize();
      paint(centre);
    } catch { /* the stage keeps its glow plate */ }

    /* Then the turn, four at a time — enough to fill quickly without taking
       the connection away from everything else the page still wants. */
    let next = 0;
    const worker = async () => {
      while (next < FRAME_COUNT) {
        const i = next++;
        try {
          frames[i] = await bitmap(`${base}/frame_${String(i).padStart(2, '0')}.webp`);
        } catch { /* a missing frame falls back to the centre at draw time */ }
      }
    };
    await Promise.all([worker(), worker(), worker(), worker()]);
  }

  /* --------------------------------------------------------------- paint */

  function resize() {
    const r = canvas.getBoundingClientRect();
    if (!r.width || !r.height) return false;
    const dpr = Math.min(window.devicePixelRatio || 1, 2);
    const w = Math.round(r.width * dpr);
    const h = Math.round(r.height * dpr);
    cssW = r.width;
    cssH = r.height;
    if (canvas.width !== w || canvas.height !== h) {
      canvas.width = w;
      canvas.height = h;
      painted = null;                 // the new buffer is blank
      return true;
    }
    return false;
  }

  function paint(frame) {
    if (!frame) return;
    const { width: w, height: h } = canvas;

    /* She is drawn whole — contained, not cropped — because the reference has
       her from cap to shirt. The stage is the whole hero, so height alone
       decides the scale and she is placed by her face. */
    const scale = (h * FILL) / frame.height;
    const dw = frame.width * scale;
    const dh = frame.height * scale;
    const x = w * STAGE_X - dw * FACE_X;
    const y = h * STAGE_Y - dh * FACE_Y;

    ctx.clearRect(0, 0, w, h);
    ctx.drawImage(frame, x, y, dw, dh);

    /* Her frame is an opaque rectangle with its own lit background, so every
       edge of it is feathered away here and the hero's gradient — mixed from
       these same colours — carries on where she stops. Done on the picture
       rather than on the element, because the element is the whole hero and
       she covers only part of it. */
    const fx = dw * 0.26;
    const fy = dh * 0.16;
    ctx.globalCompositeOperation = 'destination-out';

    const band = (x0, y0, x1, y1, rw, rh) => {
      const g = ctx.createLinearGradient(x0, y0, x1, y1);
      g.addColorStop(0, 'rgba(0,0,0,1)');
      g.addColorStop(1, 'rgba(0,0,0,0)');
      ctx.fillStyle = g;
      ctx.fillRect(Math.min(x0, x1), Math.min(y0, y1), rw, rh);
    };

    band(x, 0, x + fx, 0, fx, h);                       // left
    band(x + dw, 0, x + dw - fx, 0, fx, h);             // right
    band(0, y + dh, 0, y + dh - fy, w, fy);             // bottom
    band(0, y, 0, y + fy * 0.6, w, fy * 0.6);           // top, a lighter touch

    ctx.globalCompositeOperation = 'source-over';
    painted = frame;
  }

  /* ---------------------------------------------------------------- loop */

  function frameFor() {
    if (reduced || !pointer.moved) return centre;

    const r = canvas.getBoundingClientRect();
    const faceX = r.left + r.width * STAGE_X;
    const faceY = r.top + r.height * STAGE_Y;
    const dx = pointer.sx - faceX;
    const dy = pointer.sy - faceY;

    if (Math.hypot(dx, dy) < Math.min(r.width, r.height) * DEADZONE) return centre;

    const norm = ((angle % (Math.PI * 2)) + Math.PI * 2) % (Math.PI * 2);
    const i = Math.round((norm / (Math.PI * 2)) * FRAME_COUNT) % FRAME_COUNT;
    return frames[i] || centre;
  }

  function tick(now) {
    raf = 0;
    if (!running) return;

    const dt = Math.min(0.05, (now - last) / 1000) || 0;
    last = now;
    /* Frame-rate independent easing: the same motion on any refresh rate. */
    const kp = 1 - Math.pow(1 - POINTER_EASE, dt * 60);
    const ka = 1 - Math.pow(1 - ANGLE_EASE, dt * 60);

    pointer.sx += (pointer.x - pointer.sx) * kp;
    pointer.sy += (pointer.y - pointer.sy) * kp;

    const r = canvas.getBoundingClientRect();
    const dx = pointer.sx - (r.left + r.width * STAGE_X);
    const dy = pointer.sy - (r.top + r.height * STAGE_Y);
    if (pointer.moved) {
      let diff = Math.atan2(dy, dx) - angle;
      while (diff < -Math.PI) diff += Math.PI * 2;
      while (diff > Math.PI) diff -= Math.PI * 2;
      angle += diff * ka;
    }

    const resized = resize();
    const want = frameFor();
    if (want && (want !== painted || resized)) paint(want);

    raf = requestAnimationFrame(tick);
  }

  function start() {
    if (running || !visible || document.hidden) return;
    running = true;
    last = performance.now();
    resize();
    if (painted === null) paint(frameFor() || centre);
    raf = requestAnimationFrame(tick);
  }

  function stop() {
    running = false;
    if (raf) cancelAnimationFrame(raf);
    raf = 0;
  }

  /* --------------------------------------------------------------- input */

  if (!reduced) {
    window.addEventListener('pointermove', (e) => {
      pointer.x = e.clientX;
      pointer.y = e.clientY;
      if (!pointer.moved) {           // no lunge from the corner on the first move
        pointer.sx = e.clientX;
        pointer.sy = e.clientY;
        pointer.moved = true;
        /* The "move your mouse" hint has served its purpose. */
        document.documentElement.classList.add('has-pointer');
      }
      if (!running) start();
    }, { passive: true });

    /* Off the window, she goes back to looking at you. */
    document.addEventListener('mouseleave', () => { pointer.moved = false; });
  }

  new IntersectionObserver(([entry]) => {
    visible = entry.isIntersecting;
    if (visible) start(); else stop();
  }, { threshold: 0.01 }).observe(canvas);

  document.addEventListener('visibilitychange', () => {
    if (document.hidden) stop(); else start();
  });

  /* The stage is fluid, so the box changes without the window changing —
     a ResizeObserver catches both, and repaints at the new size. */
  new ResizeObserver(() => {
    const last = painted;
    if (resize()) paint(last || frameFor() || centre);
  }).observe(canvas);

  load();
}
