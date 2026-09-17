/**
 * Phantom Gallery — a vanilla port of the Framer marketplace component by
 * Shaigexp (framer.com/marketplace/components/phantom-gallery).
 *
 * The maths is the component's own, read from its published bundle, and the
 * values below are the exact props its demo site runs with
 * (phantominfinitegallery.framer.website). Nothing is re-tuned.
 *
 * What it does, in the component's terms:
 *   - an endless 20 x 20 window of tiles, recentred on the scroll position
 *   - tiles bent onto a cylinder along one axis (arcAxis / arcMaxAngleDeg)
 *   - click-and-hold 120ms to zoom out to cellSize * zoomValue, pinned so the
 *     world point under the stage centre stays put; release to zoom back
 *   - drag to pan; throw to glide with frame-rate-independent friction
 *   - reverse-axis cursor parallax, eased
 *
 * The one structural difference from the React original: that version
 * re-renders all 400 tiles through React every animation frame. Here a fixed
 * pool of 400 elements is reused and only their styles are written, and the
 * loop only runs while the gallery is on screen.
 *
 * Markup contract:
 *   <div data-phantom-gallery aria-label="…">
 *     <script type="application/json">[{"title":"…","year":"…","src":"…"}]</script>
 *   </div>
 */

const DESKTOP = {
  cellSize: 320,
  cellPadding: 32,
  gap: 24,
  zoomValue: 0.9,
  arcAmount: 0.8,
  arcMaxAngleDeg: 25,
  arcAxis: 'vertical',
  edgeFade: 0,
  parallaxEnabled: true,
  parallaxStrength: 0.1,
  parallaxEase: 0.05,
  parallaxWhileDragging: true,
  inertiaEnabled: true,
  throwFriction: 0.958,
  throwVelocityScale: 1,
  throwMinSpeed: 80,
  throwMaxSpeed: 2500,
};

/* The demo's phone breakpoint (Framer's < 810px) overrides only the cell size. */
const PHONE_QUERY = '(max-width: 809.98px)';
const PHONE_CELL = 220;

const GRID = 20;     // tiles per side of the rendered window
const LEAD = 5;      // cells rendered behind the scroll origin

const clamp = (v, lo, hi) => Math.max(lo, Math.min(hi, v));
const rad = d => d * Math.PI / 180;

/* Pinned zoom: keep the world point under `center` fixed while the cell size
   goes from `from` to `to`. */
function pin(from, to, center, pos) {
  const wx = (center.x - pos.x) / from;
  const wy = (center.y - pos.y) / from;
  return { x: center.x - wx * to, y: center.y - wy * to };
}

/* Place a tile on the cylinder. Returns depth, rotation and how far toward the
   edge the tile sits (0 at centre, 1 at the edge). */
function arc(cx, cy, vw, vh, axis, maxDeg, amount) {
  const c = rad(maxDeg) * clamp(amount, 0, 1);
  if (c === 0) return { z: 0, yaw: 0, pitch: 0, edge: 0 };
  if (axis === 'horizontal') {
    const e = (cx - vw / 2) / (vw / 2), a = e * c;
    const z = -(vw / (2 * Math.sin(Math.max(0.001, c)))) * (Math.cos(a) - 1);
    return { z, yaw: -(a * 180) / Math.PI, pitch: 0, edge: Math.min(1, Math.abs(e)) };
  }
  const e = (cy - vh / 2) / (vh / 2), a = e * c;
  const z = -(vh / (2 * Math.sin(Math.max(0.001, c)))) * (Math.cos(a) - 1);
  return { z, yaw: 0, pitch: (a * 180) / Math.PI, edge: Math.min(1, Math.abs(e)) };
}

export function initPhantomGallery(root) {
  let items = [];
  try { items = JSON.parse(root.querySelector('script[type="application/json"]').textContent); }
  catch { return; }
  if (!items.length) return;

  const P = { ...DESKTOP };
  const phone = matchMedia(PHONE_QUERY);
  P.cellSize = phone.matches ? PHONE_CELL : DESKTOP.cellSize;

  /* ---- DOM: stage, world, tile pool, vignette -------------------------- */
  const world = document.createElement('div');
  world.className = 'pg-world';
  const pool = [];
  for (let i = 0; i < GRID * GRID; i++) {
    const tile = document.createElement('div');
    tile.className = 'pg-tile';
    tile.innerHTML = '<div class="pg-img"></div><div class="pg-cap"><span class="pg-t"></span><span class="pg-y"></span></div>';
    world.appendChild(tile);
    pool.push({ el: tile, img: tile.firstChild, t: tile.querySelector('.pg-t'), y: tile.querySelector('.pg-y'), idx: -1 });
  }
  const vignette = document.createElement('div');
  vignette.className = 'pg-vignette';
  root.append(world, vignette);
  root.style.setProperty('--pg-pad', P.cellPadding + 'px');
  root.style.setProperty('--pg-gap', P.gap + 'px');

  /* ---- state (names follow the original's roles) ----------------------- */
  let pos = { x: 0, y: 0 };          // rendered scroll
  let target = { x: 0, y: 0 };       // where scroll is easing to
  let size = P.cellSize;             // rendered cell size
  let sizeTarget = P.cellSize;
  let par = { x: 0, y: 0 };          // parallax, eased
  let parTarget = { x: 0, y: 0 };
  let throwOff = { x: 0, y: 0 };     // accumulated inertia offset
  let vel = { x: 0, y: 0 };
  let last = { x: 0, y: 0, t: 0 };
  let downAt = { x: 0, y: 0 };
  let dragStart = { x: 0, y: 0 };
  let throwing = false, down = false, dragging = false;
  let hold = 0, lastFrame = performance.now(), appliedSize = -1;
  let vp = { w: 0, h: 0 };

  const center = () => { const r = root.getBoundingClientRect(); return { x: r.width / 2, y: r.height / 2 }; };

  /* Fold a finished throw back into the scroll position so the next drag
     starts from where the tiles visibly are. */
  function bake() {
    const n = { x: pos.x + throwOff.x, y: pos.y + throwOff.y };
    pos = { ...n }; target = { ...n };
    throwOff = { x: 0, y: 0 };
    throwing = false;
  }

  /* ---- render ----------------------------------------------------------- */
  function render() {
    const V = size;
    if (V !== appliedSize) {
      for (const p of pool) { p.el.style.width = V + 'px'; p.el.style.height = V + 'px'; }
      appliedSize = V;
    }
    const c0 = Math.floor(-pos.x / V) - LEAD;
    const r0 = Math.floor(-pos.y / V) - LEAD;
    const w = vp.w || 1, h = vp.h || 1;
    let k = 0;
    for (let row = r0; row < r0 + GRID; row++) {
      for (let col = c0; col < c0 + GRID; col++) {
        const p = pool[k++];
        const idx = Math.abs((col + row * 3) % items.length);
        const x = col * V + pos.x + par.x + throwOff.x;
        const y = row * V + pos.y + par.y + throwOff.y;
        const a = arc(x + V / 2, y + V / 2, w, h, P.arcAxis, P.arcMaxAngleDeg, P.arcAmount);
        const scale = 1 - P.edgeFade * (a.edge * a.edge);
        const opacity = 1 - 0.4 * (a.edge * P.arcAmount);
        /* translate3d(x, y, z) at the head of the chain is equivalent to the
           original's left/top plus translate3d(0, 0, z) — the rotations still
           pivot on the tile's own centre — without a layout pass per tile. */
        p.el.style.transform = `translate3d(${x}px, ${y}px, ${a.z}px) rotateY(${a.yaw}deg) rotateX(${a.pitch}deg) scale(${scale})`;
        p.el.style.opacity = opacity;
        if (p.idx !== idx) {
          const it = items[idx];
          p.img.style.backgroundImage = `url("${it.src}")`;
          p.t.textContent = it.title;
          p.y.textContent = it.year;
          p.idx = idx;
        }
      }
    }
  }

  /* ---- frame ------------------------------------------------------------ */
  let raf = 0, visible = false;
  function frame() {
    const now = performance.now();
    const dt = Math.min(0.05, (now - lastFrame) / 1000);
    lastFrame = now;

    const ns = size + (sizeTarget - size) * 0.15;
    size = Math.abs(ns - sizeTarget) < 0.05 ? sizeTarget : ns;

    if (!dragging) {
      const nx = pos.x + (target.x - pos.x) * 0.15, ny = pos.y + (target.y - pos.y) * 0.15;
      pos = { x: Math.abs(nx - target.x) < 0.1 ? target.x : nx, y: Math.abs(ny - target.y) < 0.1 ? target.y : ny };
    }

    if (P.inertiaEnabled && throwing) {
      const f = P.throwFriction ** (dt * 60);
      vel.x *= f; vel.y *= f;
      if (Math.hypot(vel.x, vel.y) < 1) {
        const ang = Math.atan2(vel.y, vel.x);
        vel.x = Math.cos(ang) * 1e-4; vel.y = Math.sin(ang) * 1e-4;
      }
      throwOff = { x: throwOff.x + vel.x * dt, y: throwOff.y + vel.y * dt };
    }

    const e = P.parallaxEase;
    const to = P.parallaxEnabled && (P.parallaxWhileDragging || !dragging) ? parTarget : { x: 0, y: 0 };
    const px = par.x + (to.x - par.x) * e, py = par.y + (to.y - par.y) * e;
    par = { x: Math.abs(px - to.x) < 0.1 ? to.x : px, y: Math.abs(py - to.y) < 0.1 ? to.y : py };

    render();
    raf = visible ? requestAnimationFrame(frame) : 0;
  }

  /* ---- input ------------------------------------------------------------ */
  root.addEventListener('pointerdown', ev => {
    if (throwing || throwOff.x !== 0 || throwOff.y !== 0) bake();
    /* Capture can throw (InvalidPointerId) when the pointer is no longer
       active by the time the handler runs; losing capture is survivable,
       losing the rest of this handler is not. */
    try { root.setPointerCapture(ev.pointerId); } catch { /* keep going */ }
    down = true; dragging = false;
    root.classList.remove('is-grabbing');
    last = { x: ev.clientX, y: ev.clientY, t: performance.now() };
    vel = { x: 0, y: 0 };
    downAt = { x: ev.clientX, y: ev.clientY };
    dragStart = { ...pos };
    clearTimeout(hold);
    const fromSize = size;
    hold = setTimeout(() => {
      if (!dragging && down) {
        const to = P.cellSize * P.zoomValue;
        const at = { x: pos.x + throwOff.x, y: pos.y + throwOff.y };
        target = pin(fromSize, to, center(), at);
        sizeTarget = to;
      }
    }, 120);
  });

  root.addEventListener('pointermove', ev => {
    if (down) {
      const t = performance.now();
      const dt = Math.max(0.001, (t - last.t) / 1000);
      const vx = clamp(((ev.clientX - last.x) / dt) * P.throwVelocityScale, -P.throwMaxSpeed, P.throwMaxSpeed);
      const vy = clamp(((ev.clientY - last.y) / dt) * P.throwVelocityScale, -P.throwMaxSpeed, P.throwMaxSpeed);
      vel = { x: vx * 0.6 + vel.x * 0.4, y: vy * 0.6 + vel.y * 0.4 };
      last = { x: ev.clientX, y: ev.clientY, t };
    }

    if (P.parallaxEnabled && (P.parallaxWhileDragging || !dragging) && !(down || dragging)) {
      const r = root.getBoundingClientRect();
      parTarget = {
        x: (r.width / 2 - (ev.clientX - r.left)) * P.parallaxStrength,
        y: (r.height / 2 - (ev.clientY - r.top)) * P.parallaxStrength,
      };
    }

    if (!down) return;
    const dx = ev.clientX - downAt.x, dy = ev.clientY - downAt.y;
    if (!dragging && Math.hypot(dx, dy) > 4) {
      dragging = true;
      root.classList.add('is-grabbing');
      dragStart = { ...pos };
    }
    if (dragging) {
      pos = { x: dragStart.x + dx, y: dragStart.y + dy };
      target = { ...pos };
    }
  });

  function release() {
    if (!down) return;
    down = false;
    clearTimeout(hold);
    if (P.inertiaEnabled && Math.hypot(vel.x, vel.y) >= P.throwMinSpeed) {
      throwing = true;
    } else {
      throwing = false;
      throwOff = { x: 0, y: 0 };
    }
    dragging = false;
    root.classList.remove('is-grabbing');
    const at = { x: pos.x + throwOff.x, y: pos.y + throwOff.y };
    parTarget = { x: 0, y: 0 };
    target = pin(size, P.cellSize, center(), at);
    sizeTarget = P.cellSize;
  }
  root.addEventListener('pointerup', release);
  root.addEventListener('pointercancel', release);
  root.addEventListener('pointerleave', () => { parTarget = { x: 0, y: 0 }; });

  /* ---- size, breakpoint, visibility ------------------------------------ */
  new ResizeObserver(([entry]) => {
    vp = { w: entry.contentRect.width, h: entry.contentRect.height };
    if (!raf) render();
  }).observe(root);

  /* The original re-pins when its cellSize prop changes; the phone breakpoint
     is the only thing here that changes it. */
  phone.addEventListener('change', () => {
    const next = phone.matches ? PHONE_CELL : DESKTOP.cellSize;
    const at = { x: pos.x + throwOff.x, y: pos.y + throwOff.y };
    target = pin(size, next, center(), at);
    P.cellSize = next;
    sizeTarget = next;
  });

  new IntersectionObserver(([entry]) => {
    visible = entry.isIntersecting;
    if (visible && !raf) { lastFrame = performance.now(); raf = requestAnimationFrame(frame); }
  }).observe(root);

  render();
}

document.querySelectorAll('[data-phantom-gallery]').forEach(initPhantomGallery);
