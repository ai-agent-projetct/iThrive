/**
 * Page-wide depth for the AI service pages.
 *
 * Three things, all additive, all reading the page's data-theme:
 *
 *  1. An ambient WebGL field behind the hero — sixteen variants, one per theme,
 *     tinted from the theme's own accent so it belongs to the page it sits on.
 *  2. Pointer tilt on cards and on the hero artwork. This only ever writes CSS
 *     custom properties (--rx, --ry, --mx, --my); svc-theme.css owns the actual
 *     transform, so the hover lift it already had and this tilt compose instead
 *     of overwriting each other.
 *  3. Depth on entry — sections settle forward as they scroll in, once.
 *
 * Nothing here is load-bearing. No WebGL, reduced motion, or this file blocked
 * and the page is the fully styled static design: svc-theme.css paints its
 * resting state, which is the correct one.
 *
 * Pointer work is rAF-throttled and writes to one element per frame, so it does
 * not force layout. The hero field pauses when the tab is hidden and when it
 * scrolls out of view — it is decoration and should not cost a phone battery.
 */

import * as THREE from 'three';

// Started at the foot of this module, not here: FIELDS below is a const, and a
// const is not hoisted the way a function declaration is, so calling init()
// from up here would hit it in the temporal dead zone.
const page = document.querySelector('.svc-page[data-theme]');

function init(page) {
  const still = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  const coarse = window.matchMedia('(pointer: coarse)').matches;

  depthOnEntry(page, still);
  if (!still && !coarse) tilt(page);
  if (!still) heroField(page);
}

/* ---------------------------------------------------------------------------
   1. Depth on entry

   Marks the things worth settling forward, then lets one observer add .is-in.
   The CSS resting state is "in", so if this never runs the page still looks
   right — the class only removes an offset, it does not create the layout.
   --------------------------------------------------------------------------- */

function depthOnEntry(page, still) {
  const targets = page.querySelectorAll(
    '.svc-card, .svc-benefit-card, .svc-model-card, .svc-step-card, .svc-stat-card'
  );
  if (!targets.length) return;

  const revealNow = () => targets.forEach((el) => el.classList.add('is-in'));

  if (still || !('IntersectionObserver' in window)) { revealNow(); return; }

  // The hidden state is created by script, so it must never outlive the thing
  // that undoes it. A document that is hidden -- a background tab, a prerender,
  // a headless render -- gets no IntersectionObserver callbacks at all, so
  // hiding the cards there could strand them at opacity 0. These pages are
  // written to rank; content that can be left invisible is not an acceptable
  // failure mode. So nothing is hidden until the document is actually visible
  // and the observer can be trusted to fire.
  if (document.hidden) {
    document.addEventListener('visibilitychange', function once() {
      if (document.hidden) return;
      document.removeEventListener('visibilitychange', once);
      arm();
    });
    return;
  }

  arm();

  function arm() {
    targets.forEach((el, i) => {
      el.dataset.depth = '';
      // A small stagger across each row, capped so a long grid never crawls.
      el.style.transitionDelay = `${Math.min(i % 6, 5) * 55}ms`;
    });

    let heard = false; // has the observer ever delivered anything?

    const io = new IntersectionObserver((entries) => {
      heard = true;
      entries.forEach((e) => {
        if (!e.isIntersecting) return;
        e.target.classList.add('is-in');
        io.unobserve(e.target); // settle once, not on every pass
      });
    }, { rootMargin: '0px 0px -12% 0px', threshold: 0.12 });

    targets.forEach((el) => io.observe(el));

    // Belt and braces: if the observer has delivered NOTHING after four
    // seconds it is not working, rather than the reader simply not having
    // scrolled yet, so reveal everything. Gated on `heard` because a blanket
    // timer would otherwise punish anyone who spends more than four seconds on
    // the hero by dumping every card in at once.
    setTimeout(() => {
      if (heard) return;
      targets.forEach((el) => {
        el.style.transitionDelay = '0ms';
        el.classList.add('is-in');
      });
      io.disconnect();
    }, 4000);
  }
}

/* ---------------------------------------------------------------------------
   2. Pointer tilt

   One listener on the page, not one per card, and one rAF in flight at a time.
   getBoundingClientRect is read only for the card actually under the pointer.
   --------------------------------------------------------------------------- */

function tilt(page) {
  const SEL = '.svc-card, .svc-benefit-card, .svc-model-card, .svc-step-card, .svc-stat-card';
  const MAX = 5; // degrees. Past about six this stops reading as depth and
                 // starts reading as a broken card.

  let pending = null, frame = 0, current = null;

  const clear = (el) => {
    if (!el) return;
    el.style.setProperty('--rx', '0deg');
    el.style.setProperty('--ry', '0deg');
  };

  const apply = () => {
    frame = 0;
    const ev = pending;
    pending = null;
    if (!ev) return;

    const card = ev.target.closest ? ev.target.closest(SEL) : null;
    if (card !== current) { clear(current); current = card; }
    if (!card) return;

    const r = card.getBoundingClientRect();
    if (!r.width || !r.height) return;

    const px = (ev.clientX - r.left) / r.width;
    const py = (ev.clientY - r.top) / r.height;

    card.style.setProperty('--ry', `${(px - 0.5) * 2 * MAX}deg`);
    card.style.setProperty('--rx', `${(0.5 - py) * 2 * MAX}deg`);
    card.style.setProperty('--mx', `${px * 100}%`);
    card.style.setProperty('--my', `${py * 100}%`);
  };

  page.addEventListener('pointermove', (e) => {
    pending = e;
    if (!frame) frame = requestAnimationFrame(apply);
  }, { passive: true });

  page.addEventListener('pointerleave', () => { clear(current); current = null; }, { passive: true });

  // The hero artwork tilts against the whole hero, not against itself, so it
  // reads as a plane sitting in the scene rather than a widget.
  const hero = page.querySelector('.svc-hero');
  const art = page.querySelector('.svc-hero-art');
  if (!hero || !art) return;

  let hp = null, hf = 0;
  const applyHero = () => {
    hf = 0;
    const ev = hp;
    hp = null;
    if (!ev) return;
    const r = hero.getBoundingClientRect();
    if (!r.width || !r.height) return;
    const px = (ev.clientX - r.left) / r.width - 0.5;
    const py = (ev.clientY - r.top) / r.height - 0.5;
    art.style.setProperty('--art-ry', `${px * 7}deg`);
    art.style.setProperty('--art-rx', `${4 - py * 5}deg`);
  };

  hero.addEventListener('pointermove', (e) => {
    hp = e;
    if (!hf) hf = requestAnimationFrame(applyHero);
  }, { passive: true });

  hero.addEventListener('pointerleave', () => {
    art.style.setProperty('--art-ry', '0deg');
    art.style.setProperty('--art-rx', '4deg');
  }, { passive: true });
}

/* ---------------------------------------------------------------------------
   3. The ambient hero field

   Sixteen variants keyed to data-theme. Each is a particle geometry with its
   own arrangement and motion, tinted from the theme's --cyan so the canvas and
   the CSS never disagree about what colour the page is.

   Deliberately particles rather than solid geometry: this sits behind live
   text, and anything with hard edges competes with the headline.
   --------------------------------------------------------------------------- */

const FIELDS = {
  // slug:        [count, build(i, n) -> [x, y, z],                 motion]
  consulting:   [520, (t, i) => [(t - 0.5) * 60, Math.sin(i * 0.7) * 14, -i % 30], 'drift'],
  generative:   [900, (t, i) => [(Math.random() - 0.5) * 60, (Math.random() - 0.5) * 34, -Math.random() * 40], 'bloom'],
  conversation: [600, (t) => { const a = t * Math.PI * 8, r = 6 + t * 18;
                   return [Math.cos(a) * r, Math.sin(a) * r * 0.5, -t * 30]; }, 'pulse'],
  copilot:      [560, (t, i) => [(t - 0.5) * 64, (i % 7 - 3) * 4.5, -(i % 22)], 'stream'],
  archive:      [640, (t, i) => [(t - 0.5) * 62, ((i % 9) - 4) * 3.8, -(i % 26)], 'drift'],
  optical:      [700, (t, i) => [(t - 0.5) * 62, ((i % 40) - 20) * 0.9, -(i % 18)], 'scanline'],
  strategy:     [480, (t, i) => [(Math.round(t * 12) - 6) * 5, ((i % 11) - 5) * 3.4, -(i % 20)], 'drift'],
  workshop:     [520, (t, i) => [(Math.round(t * 16) - 8) * 4, ((i % 8) - 4) * 4.2, -(i % 16)], 'stream'],
  catalogue:    [560, (t, i) => [(Math.round(t * 18) - 9) * 3.6, ((i % 10) - 5) * 3.6, -(i % 14)], 'drift'],
  swarm:        [820, (t, i) => { const a = t * Math.PI * 2, r = 10 + (i % 5) * 4;
                   return [Math.cos(a) * r * 1.8, Math.sin(a) * r * 0.8, -(i % 30)]; }, 'orbit'],
  contract:     [600, (t, i) => [(t - 0.5) * 64, (i % 2 ? 1 : -1) * (6 + (i % 6)), -(i % 22)], 'weave'],
  gateway:      [620, (t, i) => { const a = t * Math.PI * 2;
                   return [Math.cos(a) * (8 + i % 16), Math.sin(a) * (5 + i % 10), -(i % 24)]; }, 'pulse'],
  flow:         [680, (t, i) => [(t - 0.5) * 68, ((i % 6) - 2.5) * 5, -(i % 20)], 'stream'],
  telemetry:    [600, (t, i) => [(t - 0.5) * 62, Math.sin(t * Math.PI * 10 + i) * 10, -(i % 18)], 'jitter'],
  mechanism:    [560, (t, i) => { const a = (i % 12) / 12 * Math.PI * 2, r = 4 + (i % 4);
                   return [(t - 0.5) * 60, Math.sin(a) * r, Math.cos(a) * r - (i % 20)]; }, 'orbit'],
  team:         [540, (t, i) => [(t - 0.5) * 58, ((i % 7) - 3) * 4.6, -(i % 24)], 'drift'],
};

function heroField(page) {
  const hero = page.querySelector('.svc-hero');
  if (!hero) return;

  const spec = FIELDS[page.dataset.theme];
  if (!spec) return; // unknown theme: the hero is simply not animated

  let renderer;
  try {
    renderer = new THREE.WebGLRenderer({ antialias: false, alpha: true, powerPreference: 'low-power' });
  } catch (err) {
    return; // no WebGL, and the CSS hero already stands on its own
  }

  const host = document.createElement('div');
  host.className = 'svc-hero-bg';
  host.setAttribute('aria-hidden', 'true');
  hero.prepend(host);

  const W = () => hero.clientWidth || 1200;
  const H = () => hero.clientHeight || 700;

  renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 1.5));
  renderer.setSize(W(), H());
  host.appendChild(renderer.domElement);

  const scene = new THREE.Scene();
  const camera = new THREE.PerspectiveCamera(58, W() / H(), 0.1, 200);
  camera.position.z = 34;

  const [count, place, motion] = spec;
  const pos = new Float32Array(count * 3);
  const seed = new Float32Array(count);

  for (let i = 0; i < count; i++) {
    const [x, y, z] = place(i / (count - 1), i);
    pos[i * 3] = x;
    pos[i * 3 + 1] = y;
    pos[i * 3 + 2] = z;
    seed[i] = Math.random() * Math.PI * 2;
  }

  const geo = new THREE.BufferGeometry();
  geo.setAttribute('position', new THREE.BufferAttribute(pos, 3));
  const home = pos.slice(); // the resting arrangement, to animate around

  // Tint from the theme's own accent, so canvas and CSS never disagree.
  const accent = getComputedStyle(page).getPropertyValue('--cyan').trim() || '#00F2FE';
  let colour;
  try {
    colour = new THREE.Color(accent);
  } catch (err) {
    colour = new THREE.Color(0x00f2fe);
  }

  const points = new THREE.Points(geo, new THREE.PointsMaterial({
    size: 0.22,
    color: colour,
    transparent: true,
    opacity: 0.55,
    blending: THREE.AdditiveBlending,
    depthWrite: false,
    sizeAttenuation: true,
  }));
  scene.add(points);

  /* --- run only while it is worth running --- */

  let onScreen = true, visible = !document.hidden, running = false;

  const io = 'IntersectionObserver' in window
    ? new IntersectionObserver(([e]) => { onScreen = e.isIntersecting; pump(); }, { threshold: 0 })
    : null;
  if (io) io.observe(hero);

  document.addEventListener('visibilitychange', () => { visible = !document.hidden; pump(); });

  function pump() {
    const should = onScreen && visible;
    if (should && !running) { running = true; clock.getDelta(); requestAnimationFrame(frame); }
    else if (!should) { running = false; }
  }

  /* --- pointer parallax, shared with the tilt above but cheap --- */

  const ptr = { x: 0, y: 0, tx: 0, ty: 0 };
  hero.addEventListener('pointermove', (e) => {
    const r = hero.getBoundingClientRect();
    ptr.tx = ((e.clientX - r.left) / r.width - 0.5) * 2;
    ptr.ty = ((e.clientY - r.top) / r.height - 0.5) * 2;
  }, { passive: true });
  hero.addEventListener('pointerleave', () => { ptr.tx = 0; ptr.ty = 0; }, { passive: true });

  const clock = new THREE.Clock();
  const attr = geo.attributes.position;

  function frame() {
    if (!running) return;
    requestAnimationFrame(frame);
    const dt = Math.min(clock.getDelta(), 0.05);
    const t = clock.elapsedTime;
    const k = 1 - Math.pow(0.05, dt);

    for (let i = 0; i < count; i++) {
      const j = i * 3;
      const s = seed[i];
      const hx = home[j], hy = home[j + 1], hz = home[j + 2];

      switch (motion) {
        case 'bloom':
          attr.array[j] = hx + Math.sin(t * 0.3 + s) * 2.2;
          attr.array[j + 1] = hy + Math.cos(t * 0.24 + s) * 2.2;
          break;
        case 'stream':
          // travels left to right, wrapping at the edge of the field
          attr.array[j] = ((hx + t * 3.2 + 34) % 68) - 34;
          attr.array[j + 1] = hy + Math.sin(t * 0.5 + s) * 0.5;
          break;
        case 'scanline':
          attr.array[j + 1] = hy + Math.sin(t * 1.4 + hx * 0.12) * 1.6;
          break;
        case 'pulse': {
          const p = 1 + Math.sin(t * 0.8 + s * 0.2) * 0.06;
          attr.array[j] = hx * p;
          attr.array[j + 1] = hy * p;
          break;
        }
        case 'orbit': {
          const a = t * 0.16;
          attr.array[j] = hx * Math.cos(a) - hz * Math.sin(a) * 0.3;
          attr.array[j + 2] = hz * Math.cos(a) + hx * Math.sin(a) * 0.3;
          break;
        }
        case 'weave':
          attr.array[j + 1] = hy + Math.sin(t * 0.9 + hx * 0.1) * 2.4;
          break;
        case 'jitter':
          attr.array[j + 1] = hy + Math.sin(t * 3 + s) * 0.7;
          break;
        default: // drift
          attr.array[j] = hx + Math.sin(t * 0.22 + s) * 1.4;
          attr.array[j + 1] = hy + Math.cos(t * 0.19 + s) * 1.4;
      }
    }
    attr.needsUpdate = true;

    ptr.x += (ptr.tx - ptr.x) * k * 0.5;
    ptr.y += (ptr.ty - ptr.y) * k * 0.5;
    camera.position.x = ptr.x * 4;
    camera.position.y = -ptr.y * 2.4;
    camera.lookAt(0, 0, -10);

    renderer.render(scene, camera);
  }

  pump();

  let timer;
  window.addEventListener('resize', () => {
    clearTimeout(timer);
    timer = setTimeout(() => {
      camera.aspect = W() / H();
      camera.updateProjectionMatrix();
      renderer.setSize(W(), H());
    }, 150);
  }, { passive: true });
}

/* Everything above is declarations; this is the only statement that runs on
   load, and it sits here so FIELDS is initialised before init() reads it. */
if (page) init(page);
