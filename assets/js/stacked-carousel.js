import * as THREE from 'three';

/* ------------------------------------------------------------------ *
 *  Stacked Carousel — a port of Origin Kit's component.
 *
 *  A deck of planes stacked in Z, tilted in view and scrolled endlessly by the
 *  wheel; hovering a card flattens it toward the camera and pushes its
 *  neighbours apart. Built to the component's documented behaviour:
 *
 *   - One quad per card, painter-sorted back to front by view depth.
 *   - Hover tweens the card's local rotation to the inverse of the deck's,
 *     flattening it square to the camera over 1.2s.
 *   - Wheel input accumulates into a damped scroll that settles, over a
 *     continuous idle drift that never stops.
 *   - Ray/plane picking against front faces only, so there is no second
 *     invisible hit-test geometry.
 *   - The deck is always at least 20 planes deep, cycling a shorter list so the
 *     stack still reads as a stack.
 *   - Delta-time corrected, so the drift runs at the same rate at 60 and 120Hz.
 *
 *  Props map to data attributes with the component's defaults: cardWidth 420,
 *  cardHeight 300, gap 100, direction forward, speed 100, camera pitch/yaw.
 *
 *  Two differences, both because this is a service page rather than a gallery.
 *  The reference takes photographs; these cards are drawn — each capability
 *  rendered to a canvas with its number, title and sentence, so the deck shows
 *  the section's actual content. And every one of those is also real markup
 *  underneath, because a crawler cannot read a texture.
 *
 *  Three.js rather than raw WebGL1: the same one-quad-per-card geometry and the
 *  same sort, without hand-rolling the context.
 * ------------------------------------------------------------------ */

const MOUNT = document.querySelector('[data-stacked-carousel]');
if (MOUNT && !MOUNT.dataset.stackedReady) {
  MOUNT.dataset.stackedReady = '1';
  build(MOUNT);
}

function build(mount) {
  const items = Array.from(mount.querySelectorAll('[data-stacked-card]'));
  if (!items.length) return;

  let renderer;
  try {
    renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true, powerPreference: 'high-performance' });
  } catch (e) {
    return;   // No WebGL. The cards below are the section.
  }

  const num = (key, fallback) => {
    const v = parseFloat(mount.dataset[key]);

    return Number.isFinite(v) ? v : fallback;
  };

  const CARD_W = num('cardWidth', 420);
  const CARD_H = num('cardHeight', 300);
  const GAP = num('gap', 100);
  const SPEED = num('speed', 100);
  const PITCH = num('pitch', -11) * Math.PI / 180;
  const YAW = num('yaw', 17) * Math.PI / 180;
  const DIR = mount.dataset.direction === 'backward' ? -1 : 1;
  const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  const boxW = () => mount.clientWidth || 800;
  const boxH = () => mount.clientHeight || 520;

  renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 2));
  renderer.setSize(boxW(), boxH());
  renderer.outputColorSpace = THREE.SRGBColorSpace;
  mount.appendChild(renderer.domElement);

  const scene = new THREE.Scene();
  const camera = new THREE.PerspectiveCamera(42, boxW() / boxH(), 1, 12000);
  // Placed after the span is known — a fixed distance puts the lens inside the
  // deck, and the front cards then run straight past it.
  camera.position.set(0, 0, 1000);

  /* ---- one texture per card, drawn from its own markup ------------------ */

  function plate(el, index) {
    const S = 2;                       // 2x for crispness
    const c = document.createElement('canvas');
    c.width = CARD_W * S;
    c.height = CARD_H * S;
    const x = c.getContext('2d');

    const accent = el.dataset.accent || '#03D1F5';
    const title = el.dataset.title || '';
    const body = el.dataset.body || '';

    const r = 22 * S;
    x.fillStyle = '#0C1220';
    x.beginPath();
    x.roundRect(0, 0, c.width, c.height, r);
    x.fill();

    const g = x.createLinearGradient(0, 0, c.width, c.height);
    g.addColorStop(0, accent + '2E');
    g.addColorStop(1, 'rgba(12,18,32,0)');
    x.fillStyle = g;
    x.beginPath();
    x.roundRect(0, 0, c.width, c.height, r);
    x.fill();

    x.strokeStyle = 'rgba(255,255,255,.14)';
    x.lineWidth = 2 * S;
    x.beginPath();
    x.roundRect(1 * S, 1 * S, c.width - 2 * S, c.height - 2 * S, r);
    x.stroke();

    x.fillStyle = accent;
    x.font = '700 ' + 15 * S + 'px Outfit, Segoe UI, sans-serif';
    x.fillText(String(index + 1).padStart(2, '0'), 30 * S, 44 * S);

    x.fillStyle = '#FFFFFF';
    x.font = '700 ' + 25 * S + 'px Outfit, Segoe UI, sans-serif';
    wrap(x, title, 30 * S, 92 * S, (CARD_W - 60) * S, 31 * S, 2);

    x.fillStyle = 'rgba(226,233,246,.72)';
    x.font = '400 ' + 15 * S + 'px Outfit, Segoe UI, sans-serif';
    wrap(x, body, 30 * S, 168 * S, (CARD_W - 60) * S, 23 * S, 5);

    const t = new THREE.CanvasTexture(c);
    t.colorSpace = THREE.SRGBColorSpace;
    t.anisotropy = renderer.capabilities.getMaxAnisotropy();

    return t;
  }

  function wrap(x, text, left, top, width, lh, maxLines) {
    const words = String(text).split(/\s+/);
    let line = '', y = top, n = 0;
    for (const w of words) {
      const test = line ? line + ' ' + w : w;
      if (x.measureText(test).width > width && line) {
        x.fillText(line, left, y);
        y += lh;
        if (++n >= maxLines - 1) { line = w; break; }
        line = w;
      } else {
        line = test;
      }
    }
    if (line) {
      let out = line;
      while (x.measureText(out + '…').width > width && out.length > 4) out = out.slice(0, -1);
      x.fillText(out === line ? out : out + '…', left, y);
    }
  }

  /* ---- the deck --------------------------------------------------------- */

  // At least 20 planes deep, cycling the shorter list — the component's rule,
  // and the reason six cards still read as a stack rather than a short fan.
  const DEPTH = Math.max(20, items.length);
  const textures = items.map((el, i) => plate(el, i));

  const deck = new THREE.Group();
  deck.rotation.set(PITCH, YAW, 0);
  scene.add(deck);

  const geo = new THREE.PlaneGeometry(CARD_W, CARD_H);
  const planes = [];

  for (let i = 0; i < DEPTH; i++) {
    const idx = i % items.length;
    const mesh = new THREE.Mesh(geo, new THREE.MeshBasicMaterial({
      map: textures[idx], transparent: true, side: THREE.FrontSide, depthWrite: false,
    }));
    mesh.userData.slot = i;
    deck.add(mesh);
    planes.push({ mesh, idx, flat: 0, spread: 0 });
  }

  const SPAN = DEPTH * GAP;

  /*
   * The camera has to stand clear of the front of the deck. The stack is
   * centred on z = 0 and reaches SPAN/2 toward the viewer, so the lens goes
   * beyond that plus a working distance — close enough that the nearest card
   * fills most of the frame, far enough that it never passes behind the lens.
   */
  camera.position.z = SPAN / 2 + CARD_H * 1.9;
  // Nudged off centre so the fan, which leans with the yaw, sits in the middle
  // of the frame rather than running off the right edge.
  deck.position.x = -CARD_W * 0.22;

  /* ---- pointer ---------------------------------------------------------- */

  const ray = new THREE.Raycaster();
  const ndc = new THREE.Vector2(-2, -2);
  let hovered = -1;

  renderer.domElement.addEventListener('pointermove', (e) => {
    const r = renderer.domElement.getBoundingClientRect();
    ndc.x = ((e.clientX - r.left) / r.width) * 2 - 1;
    ndc.y = -((e.clientY - r.top) / r.height) * 2 + 1;
  }, { passive: true });
  renderer.domElement.addEventListener('pointerleave', () => ndc.set(-2, -2));

  // Clicking a card follows its link — the cards are real anchors underneath.
  renderer.domElement.addEventListener('click', () => {
    if (hovered < 0) return;
    const el = items[planes[hovered].idx];
    const href = el.dataset.href;
    if (href) window.location.href = href;
  });

  /* ---- scroll ----------------------------------------------------------- */

  let scroll = 0, wheelVel = 0;

  mount.addEventListener('wheel', (e) => {
    // Accumulates into a damped scroll that settles, over the idle drift.
    wheelVel += e.deltaY * 0.55;
  }, { passive: true });

  /* ---- loop ------------------------------------------------------------- */

  let onScreen = false, raf = 0, last = 0;
  const _q = new THREE.Quaternion();
  const _inv = new THREE.Quaternion();

  function frame(now) {
    raf = requestAnimationFrame(frame);
    const dt = last ? Math.min((now - last) / 1000, 0.05) : 0;
    last = now;

    // Delta-time corrected: the same rate at 60Hz and 120Hz.
    if (!reduce) scroll += DIR * SPEED * 0.28 * dt;
    scroll += wheelVel * dt;
    wheelVel *= Math.pow(0.02, dt);     // damped, frame-rate independent

    // Lay the deck out, wrapping endlessly through the span.
    for (const p of planes) {
      let z = (p.mesh.userData.slot * GAP + scroll) % SPAN;
      if (z < 0) z += SPAN;
      p.mesh.position.z = z - SPAN / 2;
    }

    // Picking: front faces only, no second hit-test geometry.
    ray.setFromCamera(ndc, camera);
    const hits = ray.intersectObjects(planes.map((p) => p.mesh), false);
    const now_h = hits.length ? planes.findIndex((p) => p.mesh === hits[0].object) : -1;
    if (now_h !== hovered) {
      hovered = now_h;
      renderer.domElement.style.cursor = hovered >= 0 && items[planes[hovered].idx].dataset.href
        ? 'pointer' : 'default';
    }

    // Hover flattens the card square to the camera by tweening its local
    // rotation to the inverse of the deck's, and pushes its neighbours apart.
    _inv.copy(deck.quaternion).invert();
    for (let i = 0; i < planes.length; i++) {
      const p = planes[i];
      const near = hovered >= 0 ? Math.abs(i - hovered) : 99;
      const wantFlat = i === hovered ? 1 : 0;
      const wantSpread = near === 0 ? 0 : near <= 2 ? (3 - near) * 26 : 0;

      // 1.2s to flatten, as the component specifies.
      p.flat += (wantFlat - p.flat) * Math.min(1, dt / 1.2 * 3.2);
      p.spread += (wantSpread - p.spread) * Math.min(1, dt * 6);

      _q.identity().slerp(_inv, p.flat);
      p.mesh.quaternion.copy(_q);
      p.mesh.position.z += (i < hovered ? -p.spread : i > hovered ? p.spread : 0);
      p.mesh.material.opacity = 1;
    }

    // Painter-sorted back to front by view depth.
    deck.children.sort((a, b) => a.position.z - b.position.z);
    deck.children.forEach((m, i) => { m.renderOrder = i; });

    renderer.render(scene, camera);
  }

  const resize = () => {
    camera.aspect = boxW() / boxH();
    camera.updateProjectionMatrix();
    renderer.setSize(boxW(), boxH());
  };
  window.addEventListener('resize', resize);
  if ('ResizeObserver' in window) new ResizeObserver(resize).observe(mount);

  if ('IntersectionObserver' in window) {
    new IntersectionObserver(([e]) => {
      onScreen = e.isIntersecting;
      if (onScreen && !raf) { last = 0; raf = requestAnimationFrame(frame); }
      if (!onScreen && raf) { cancelAnimationFrame(raf); raf = 0; }
    }, { threshold: 0 }).observe(mount);
  } else {
    onScreen = true;
    raf = requestAnimationFrame(frame);
  }

  mount.classList.add('is-live');
}
