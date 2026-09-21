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

/* Where her face sits inside the square frame. */
const FACE_X = 0.5;
const FACE_Y = 0.46;

const canvas = document.querySelector('[data-character-canvas]');

if (canvas) {
  const ctx = canvas.getContext('2d', { alpha: true });
  const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  const base = canvas.dataset.base || BASE;

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

  async function bitmap(url) {
    const res = await fetch(url, { cache: 'force-cache' });
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
    /* The frames are square and the stage is square, so this is a straight
       cover fit; the max() keeps it covering if the stage is ever not. */
    const scale = Math.max(w / frame.width, h / frame.height);
    const dw = frame.width * scale;
    const dh = frame.height * scale;
    ctx.clearRect(0, 0, w, h);
    ctx.drawImage(frame, (w - dw) / 2, (h - dh) / 2, dw, dh);
    painted = frame;
  }

  /* ---------------------------------------------------------------- loop */

  function frameFor() {
    if (reduced || !pointer.moved) return centre;

    const r = canvas.getBoundingClientRect();
    const faceX = r.left + r.width * FACE_X;
    const faceY = r.top + r.height * FACE_Y;
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
    const dx = pointer.sx - (r.left + r.width * FACE_X);
    const dy = pointer.sy - (r.top + r.height * FACE_Y);
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
