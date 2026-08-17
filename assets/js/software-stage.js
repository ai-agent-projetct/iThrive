/**
 * The stage behind the custom software development page.
 *
 * One point field, fixed behind the whole document, that re-forms itself as you
 * scroll. Each section declares `data-stage="<formation>"`; when a section takes
 * the viewport, the field morphs into that formation — scattered notes become a
 * blueprint lattice, the lattice stacks into modules, the modules wire together,
 * the wiring becomes a stream, the stream becomes a mind, the mind becomes a
 * planet. It is the story the copy tells, drawn once behind all of it.
 *
 * Three decisions worth knowing about:
 *
 *  - The canvas is decoration and carries no text. Every word on the page is
 *    real HTML in front of it, because this page exists to rank and text baked
 *    into a WebGL context is text no crawler and no answer engine reads.
 *
 *  - One geometry, seven formations. Each formation is a precomputed float
 *    array of the same length, and morphing is a per-point lerp between two of
 *    them. That keeps the whole scene at a single draw call for the field plus
 *    one for the core, which is what makes it safe to run behind a long page on
 *    a mid-range Android device.
 *
 *  - Point colour is fixed per point, not per formation. Recolouring on every
 *    transition looks like a theme change rather than the same material being
 *    rearranged, which is the opposite of the intended read.
 *
 * Skipped entirely under prefers-reduced-motion and if WebGL will not start. In
 * both cases the page is unchanged except that the backdrop stays flat.
 */

import * as THREE from 'three';

const host = document.querySelector('[data-sd-stage]');
if (host && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
  start(host);
}

function start(mount) {
  const sections = Array.from(document.querySelectorAll('[data-stage]'));
  if (!sections.length) return;

  let renderer;
  try {
    renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true, powerPreference: 'high-performance' });
  } catch (err) {
    return; // No WebGL. The CSS backdrop underneath is already correct.
  }

  const coarse = window.matchMedia('(pointer: coarse)').matches;

  // Point budget scales with the device, not with the viewport: a phone that
  // rotates to landscape should not suddenly be asked to draw twice as much.
  const COUNT = coarse ? 1500 : 3000;

  renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, coarse ? 1.5 : 1.75));
  renderer.setSize(window.innerWidth, window.innerHeight);
  renderer.domElement.setAttribute('aria-hidden', 'true');
  mount.appendChild(renderer.domElement);

  const scene  = new THREE.Scene();
  const camera = new THREE.PerspectiveCamera(52, window.innerWidth / window.innerHeight, 0.1, 200);
  camera.position.set(0, 0, 34);

  /* ---- palette --------------------------------------------------------- */

  // The site's three accents. Sampling between them by point index rather than
  // by position keeps the gradient stable while the shape moves.
  const CYAN   = new THREE.Color(0x00f2fe);
  const BLUE   = new THREE.Color(0x4ea8ff);
  const PURPLE = new THREE.Color(0x9d4edd);

  /* ---- formations ------------------------------------------------------ */

  /**
   * Deterministic pseudo-random, so the field is identical on every load and on
   * every device. Math.random() here would make the "same material rearranged"
   * read fall apart between morphs.
   */
  let seed = 20260817;
  const rand = () => {
    seed = (seed * 1664525 + 1013904223) % 4294967296;
    return seed / 4294967296;
  };

  const TAU = Math.PI * 2;

  /** Scattered notes: the problem before anyone has ordered it. */
  const brief = (i, out) => {
    const r = 8 + rand() * 12;
    const theta = rand() * TAU;
    const phi = Math.acos(2 * rand() - 1);
    out[0] = r * Math.sin(phi) * Math.cos(theta);
    out[1] = r * Math.sin(phi) * Math.sin(theta) * 0.7;
    out[2] = r * Math.cos(phi);
  };

  /** The blueprint: a flat lattice, gently warped, seen at an angle. */
  const blueprint = (i, out) => {
    const side = Math.ceil(Math.sqrt(COUNT));
    const x = (i % side) / (side - 1) - 0.5;
    const z = Math.floor(i / side) / (side - 1) - 0.5;
    out[0] = x * 42;
    out[2] = z * 42;
    out[1] = Math.sin(x * 7) * Math.cos(z * 7) * 1.6 - 3;
  };

  /** Modules: a hollow cube shell, the way a system diagram stacks. */
  const build = (i, out) => {
    const side = 11;
    const cell = 22 / (side - 1);
    let x = i % side;
    let y = Math.floor(i / side) % side;
    let z = Math.floor(i / (side * side)) % side;
    // Push interior points to the nearest face so the cube reads as a shell.
    const edge = Math.min(x, side - 1 - x, y, side - 1 - y, z, side - 1 - z);
    if (edge > 0) {
      const pick = Math.floor(rand() * 3);
      if (pick === 0) x = rand() < 0.5 ? 0 : side - 1;
      else if (pick === 1) y = rand() < 0.5 ? 0 : side - 1;
      else z = rand() < 0.5 ? 0 : side - 1;
    }
    out[0] = x * cell - 11;
    out[1] = y * cell - 11;
    out[2] = z * cell - 11;
  };

  /** Integration: three interlocked rings, the systems finally talking. */
  const integrate = (i, out) => {
    const ring = i % 3;
    const t = (i / COUNT) * TAU * 6;
    const R = 13, r = 3.4;
    const cx = Math.cos(t) * (R + r * Math.cos(t * 5));
    const cy = Math.sin(t) * (R + r * Math.cos(t * 5));
    const cz = r * Math.sin(t * 5);
    if (ring === 0)      { out[0] = cx;  out[1] = cy;  out[2] = cz; }
    else if (ring === 1) { out[0] = cx;  out[1] = cz;  out[2] = cy; }
    else                 { out[0] = cz;  out[1] = cy;  out[2] = cx; }
  };

  /** Release: a stream running forward, everything pointed the same way. */
  const ship = (i, out) => {
    const t = i / COUNT;
    const lane = i % 5;
    const spin = t * TAU * 3;
    const radius = 3 + lane * 1.5;
    out[0] = Math.cos(spin + lane) * radius;
    out[1] = Math.sin(spin + lane) * radius * 0.8;
    out[2] = (t - 0.5) * 54;
  };

  /** Intelligence: layered shells with a denser core — a mind, not a ball. */
  const intelligence = (i, out) => {
    const golden = Math.PI * (3 - Math.sqrt(5));
    const shell = i % 3;
    const y = 1 - (i / (COUNT - 1)) * 2;
    const radius = Math.sqrt(Math.max(0, 1 - y * y));
    const theta = golden * i;
    const R = [6.5, 11, 14.5][shell] + Math.sin(i * 0.35) * 0.6;
    out[0] = Math.cos(theta) * radius * R;
    out[1] = y * R * 0.92;
    out[2] = Math.sin(theta) * radius * R;
  };

  /** Scale: a globe with a wide orbit around it. */
  const scaleForm = (i, out) => {
    if (i % 7 === 0) {                       // orbital band
      const t = (i / COUNT) * TAU * 4;
      out[0] = Math.cos(t) * 20;
      out[1] = Math.sin(t * 2) * 1.6;
      out[2] = Math.sin(t) * 20;
      return;
    }
    const lat = Math.floor(i / 26) % 22;     // lat/long lattice, not noise
    const lon = i % 26;
    const phi = (lat / 21) * Math.PI;
    const theta = (lon / 26) * TAU;
    const R = 12.5;
    out[0] = R * Math.sin(phi) * Math.cos(theta);
    out[1] = R * Math.cos(phi);
    out[2] = R * Math.sin(phi) * Math.sin(theta);
  };

  const BUILDERS = {
    brief,
    blueprint,
    build,
    integrate,
    ship,
    intelligence,
    scale: scaleForm,
  };

  /** Precompute every formation once, up front. */
  const FORMS = {};
  const scratch = [0, 0, 0];
  for (const [name, builder] of Object.entries(BUILDERS)) {
    const arr = new Float32Array(COUNT * 3);
    seed = 20260817; // same seed per formation, so a point keeps its character
    for (let i = 0; i < COUNT; i++) {
      builder(i, scratch);
      arr[i * 3] = scratch[0];
      arr[i * 3 + 1] = scratch[1];
      arr[i * 3 + 2] = scratch[2];
    }
    FORMS[name] = arr;
  }

  /* ---- the field ------------------------------------------------------- */

  const positions = new Float32Array(FORMS.brief);
  const colors    = new Float32Array(COUNT * 3);
  const mixed     = new THREE.Color();

  for (let i = 0; i < COUNT; i++) {
    const t = i / COUNT;
    // Two-stop ramp: cyan through blue for the first half, blue to purple after.
    mixed.copy(t < 0.5 ? CYAN.clone().lerp(BLUE, t * 2) : BLUE.clone().lerp(PURPLE, (t - 0.5) * 2));
    colors[i * 3] = mixed.r;
    colors[i * 3 + 1] = mixed.g;
    colors[i * 3 + 2] = mixed.b;
  }

  const geometry = new THREE.BufferGeometry();
  geometry.setAttribute('position', new THREE.BufferAttribute(positions, 3));
  geometry.setAttribute('color', new THREE.BufferAttribute(colors, 3));

  const field = new THREE.Points(geometry, new THREE.PointsMaterial({
    size: coarse ? 0.19 : 0.16,
    vertexColors: true,
    transparent: true,
    opacity: 0.92,
    depthWrite: false,
    blending: THREE.AdditiveBlending,
    sizeAttenuation: true,
  }));
  scene.add(field);

  // A wire core the field forms around. It carries the light when the field is
  // sparse (the blueprint and the stream), so the frame never looks empty.
  const core = new THREE.LineSegments(
    new THREE.EdgesGeometry(new THREE.IcosahedronGeometry(4.2, 1)),
    new THREE.LineBasicMaterial({ color: 0x4ea8ff, transparent: true, opacity: 0.22, blending: THREE.AdditiveBlending, depthWrite: false })
  );
  scene.add(core);

  /* ---- morph state ----------------------------------------------------- */

  const from = new Float32Array(FORMS.brief);
  let to = FORMS.brief;
  let morph = 1;                // 1 = settled on `to`
  let current = 'brief';

  /** Per-formation camera framing and core presence. */
  const LOOK = {
    brief:        { z: 36, y: 0,    tilt: 0.10, core: 0.10, spin: 0.05 },
    blueprint:    { z: 30, y: 7,    tilt: 0.55, core: 0.05, spin: 0.02 },
    build:        { z: 40, y: 2,    tilt: 0.16, core: 0.30, spin: 0.09 },
    integrate:    { z: 38, y: 0,    tilt: 0.12, core: 0.34, spin: 0.13 },
    ship:         { z: 26, y: 0,    tilt: 0.05, core: 0.20, spin: 0.04 },
    intelligence: { z: 34, y: 0,    tilt: 0.10, core: 0.42, spin: 0.11 },
    scale:        { z: 42, y: 3,    tilt: 0.22, core: 0.26, spin: 0.07 },
  };

  let look = { ...LOOK.brief };
  const target = { ...LOOK.brief };

  function setStage(name) {
    if (!FORMS[name] || name === current) return;
    // Freeze wherever the morph currently is, so a fast scroll through three
    // sections reads as one continuous re-forming rather than a snap.
    const pos = geometry.attributes.position.array;
    from.set(pos);
    to = FORMS[name];
    morph = 0;
    current = name;
    Object.assign(target, LOOK[name]);
  }

  /* ---- what the page is looking at ------------------------------------- */

  // The section closest to the middle of the viewport wins. An IntersectionObserver
  // with a thin band would flip twice on a fast scroll; measuring on scroll is
  // both cheaper to reason about and stable.
  let ticking = false;
  const pickStage = () => {
    ticking = false;
    const mid = window.innerHeight / 2;
    let best = null;
    let bestDist = Infinity;
    for (const el of sections) {
      const rect = el.getBoundingClientRect();
      if (rect.bottom < 0 || rect.top > window.innerHeight) continue;
      const dist = Math.abs(rect.top + rect.height / 2 - mid);
      if (dist < bestDist) { bestDist = dist; best = el; }
    }
    if (best) setStage(best.dataset.stage);
  };

  const onScroll = () => {
    if (!ticking) { ticking = true; requestAnimationFrame(pickStage); }
  };

  window.addEventListener('scroll', onScroll, { passive: true });
  pickStage();

  /* ---- pointer parallax ------------------------------------------------ */

  const pointer = { x: 0, y: 0, tx: 0, ty: 0 };
  if (!coarse) {
    window.addEventListener('pointermove', (e) => {
      pointer.tx = (e.clientX / window.innerWidth - 0.5) * 2;
      pointer.ty = (e.clientY / window.innerHeight - 0.5) * 2;
    }, { passive: true });
  }

  /* ---- loop ------------------------------------------------------------ */

  const clock = new THREE.Clock();
  let spin = 0;
  let running = true;
  let revealed = false;

  document.addEventListener('visibilitychange', () => {
    running = !document.hidden;
    if (running) { clock.getDelta(); requestAnimationFrame(frame); }
  });

  function frame() {
    if (!running) return;
    requestAnimationFrame(frame);

    const dt = Math.min(clock.getDelta(), 0.05);
    const time = clock.elapsedTime;

    // Morph. easeInOutCubic over roughly 1.1s, then hold.
    if (morph < 1) {
      morph = Math.min(1, morph + dt / 1.1);
      const t = morph < 0.5 ? 4 * morph ** 3 : 1 - Math.pow(-2 * morph + 2, 3) / 2;
      const pos = geometry.attributes.position.array;
      for (let i = 0; i < pos.length; i++) {
        pos[i] = from[i] + (to[i] - from[i]) * t;
      }
      geometry.attributes.position.needsUpdate = true;
    }

    // Breathing, so a settled formation is never completely static.
    const breathe = 1 + Math.sin(time * 0.6) * 0.012;
    field.scale.setScalar(breathe);

    // Framing eases toward the active formation's look.
    const k = 1 - Math.pow(0.001, dt);
    look.z    += (target.z    - look.z)    * k;
    look.y    += (target.y    - look.y)    * k;
    look.tilt += (target.tilt - look.tilt) * k;
    look.core += (target.core - look.core) * k;
    look.spin += (target.spin - look.spin) * k;

    pointer.x += (pointer.tx - pointer.x) * k * 0.5;
    pointer.y += (pointer.ty - pointer.y) * k * 0.5;

    spin += look.spin * dt;
    field.rotation.y = spin + pointer.x * 0.18;
    field.rotation.x = look.tilt + pointer.y * 0.10;

    core.rotation.y = -spin * 1.6;
    core.rotation.x = spin * 0.7;
    core.material.opacity = look.core;
    core.scale.setScalar(0.9 + Math.sin(time * 0.9) * 0.05);

    camera.position.z = look.z;
    camera.position.y = look.y;
    camera.lookAt(0, 0, 0);

    renderer.render(scene, camera);

    // Fade the host in only once there is something in it. Revealing the
    // element before the first frame shows a blank rectangle over the page
    // backdrop for however long the shader compile takes.
    if (!revealed) {
      revealed = true;
      mount.classList.add('sd-stage--live');
    }
  }

  requestAnimationFrame(frame);

  /* ---- resize ---------------------------------------------------------- */

  let resizeTimer;
  window.addEventListener('resize', () => {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(() => {
      camera.aspect = window.innerWidth / window.innerHeight;
      camera.updateProjectionMatrix();
      renderer.setSize(window.innerWidth, window.innerHeight);
      pickStage();
    }, 150);
  }, { passive: true });
}
