/**
 * The stage behind the custom software development page.
 *
 * A corridor of application screens hanging in space, with a grid floor and
 * ceiling running away into fog. Scrolling flies the camera down it. The page's
 * copy rides over the top on glass, so the scene is never decoration behind a
 * wall of text — it is the thing you are looking at, and the text is what you
 * are reading while you look.
 *
 * Why it is built this way:
 *
 *  - The reference (poly.app) has no WebGL at all. Its depth comes from a
 *    pre-rendered 3D animation played back frame by frame on a fixed canvas as
 *    you scroll. That needs a rendered image sequence, which we do not have, so
 *    this does the same job live: one continuous camera dolly bound to scroll
 *    position, tangible lit objects, and real perspective.
 *
 *  - The objects are screens with drawn interfaces on them, not abstract
 *    shapes. A field of points reads as a background effect; something with a
 *    title bar and rows in it reads as an object in a room, which is the whole
 *    difference between "a site with a particle backdrop" and "a 3D site".
 *
 *  - Every interface drawn on a panel is generic — labels, bars, a chart. No
 *    claim, price or product name is ever baked into a texture, because nothing
 *    inside a WebGL context can be read by a crawler, a screen reader or an
 *    answer engine. All of those live in the HTML in front.
 *
 * Skipped entirely under prefers-reduced-motion and if WebGL will not start; in
 * both cases the page is unchanged except that the backdrop stays flat.
 */

import * as THREE from 'three';

const host = document.querySelector('[data-sd-stage]');
if (host && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
  start(host);
}

function start(mount) {
  let renderer;
  try {
    renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true, powerPreference: 'high-performance' });
  } catch (err) {
    return; // No WebGL. The CSS backdrop underneath is already correct.
  }

  const coarse = window.matchMedia('(pointer: coarse)').matches;

  const INK    = 0x0b0f17;
  const CYAN   = 0x00f2fe;
  const BLUE   = 0x4ea8ff;
  const PURPLE = 0x9d4edd;

  renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, coarse ? 1.5 : 1.75));
  renderer.setSize(window.innerWidth, window.innerHeight);
  mount.appendChild(renderer.domElement);

  const scene = new THREE.Scene();
  // Fog does two jobs: it sells the length of the corridor, and it hides the
  // far end so nothing has to be modelled beyond it.
  scene.fog = new THREE.Fog(INK, 34, 165);

  const camera = new THREE.PerspectiveCamera(58, window.innerWidth / window.innerHeight, 0.1, 240);

  scene.add(new THREE.AmbientLight(0xffffff, 1.1));

  /* ---- the interfaces drawn on the panels ------------------------------ */

  /**
   * Draws one generic application screen to a canvas, used as a texture.
   * `kind` picks the layout; nothing here carries meaning.
   */
  function screenTexture(kind, accent) {
    const W = 512, H = 320;
    const c = document.createElement('canvas');
    c.width = W; c.height = H;
    const g = c.getContext('2d');

    const hex = '#' + accent.toString(16).padStart(6, '0');

    // Lighter than the page ink on purpose: a screen the same colour as the
    // room it hangs in is a rectangle you cannot see.
    g.fillStyle = '#131C2C';
    g.fillRect(0, 0, W, H);

    // Title bar with the three dots every window has.
    g.fillStyle = 'rgba(255,255,255,.05)';
    g.fillRect(0, 0, W, 38);
    g.fillStyle = 'rgba(255,255,255,.22)';
    [18, 34, 50].forEach((x) => { g.beginPath(); g.arc(x, 19, 4.5, 0, Math.PI * 2); g.fill(); });
    g.fillStyle = 'rgba(255,255,255,.14)';
    g.fillRect(150, 13, 212, 12);

    g.strokeStyle = 'rgba(255,255,255,.10)';
    g.lineWidth = 2;
    g.strokeRect(1, 1, W - 2, H - 2);

    if (kind === 0) {                                   // list / table
      for (let i = 0; i < 6; i++) {
        const y = 62 + i * 40;
        g.fillStyle = 'rgba(255,255,255,.09)';
        g.fillRect(24, y, 150 + (i % 3) * 60, 11);
        g.fillStyle = i % 3 === 0 ? hex : 'rgba(255,255,255,.16)';
        g.fillRect(W - 96, y - 2, 68, 15);
      }
    } else if (kind === 1) {                            // bar chart
      const base = H - 34;
      for (let i = 0; i < 9; i++) {
        const h = 26 + Math.abs(Math.sin(i * 1.7)) * 150;
        g.fillStyle = i === 5 ? hex : 'rgba(255,255,255,.13)';
        g.fillRect(34 + i * 50, base - h, 30, h);
      }
    } else if (kind === 2) {                            // code
      for (let i = 0; i < 8; i++) {
        const y = 60 + i * 30;
        g.fillStyle = 'rgba(255,255,255,.07)';
        g.fillRect(22, y, 22, 10);
        g.fillStyle = i % 4 === 1 ? hex : 'rgba(255,255,255,.14)';
        g.fillRect(60 + (i % 3) * 22, y, 120 + (i % 4) * 70, 10);
      }
    } else if (kind === 3) {                            // stat tiles
      for (let i = 0; i < 4; i++) {
        const x = 24 + (i % 2) * 240, y = 60 + Math.floor(i / 2) * 120;
        g.fillStyle = 'rgba(255,255,255,.045)';
        g.fillRect(x, y, 216, 100);
        g.fillStyle = i === 0 ? hex : 'rgba(255,255,255,.5)';
        g.fillRect(x + 18, y + 26, 90, 22);
        g.fillStyle = 'rgba(255,255,255,.12)';
        g.fillRect(x + 18, y + 62, 150, 10);
      }
    } else {                                            // line graph
      g.strokeStyle = hex;
      g.lineWidth = 3;
      g.beginPath();
      for (let x = 0; x <= 460; x += 20) {
        const y = 200 - Math.sin(x / 58) * 62 - x * 0.12;
        x === 0 ? g.moveTo(x + 26, y) : g.lineTo(x + 26, y);
      }
      g.stroke();
      g.strokeStyle = 'rgba(255,255,255,.08)';
      g.lineWidth = 1;
      for (let i = 1; i < 5; i++) {
        g.beginPath(); g.moveTo(24, 60 + i * 50); g.lineTo(W - 24, 60 + i * 50); g.stroke();
      }
    }

    const tex = new THREE.CanvasTexture(c);
    tex.colorSpace = THREE.SRGBColorSpace;
    tex.anisotropy = 4;
    return tex;
  }

  const textures = [0, 1, 2, 3, 4].map((k, i) => screenTexture(k, [CYAN, PURPLE, BLUE, CYAN, PURPLE][i]));

  /* ---- the corridor ---------------------------------------------------- */

  const CORRIDOR_START = 16;    // nearest panel, in world units
  const CORRIDOR_END   = -235;  // furthest
  const PANELS = coarse ? 16 : 26;

  let seed = 20260818;
  const rand = () => {
    seed = (seed * 1664525 + 1013904223) % 4294967296;
    return seed / 4294967296;
  };

  const panels = [];
  const panelGeo = new THREE.PlaneGeometry(1, 1);

  for (let i = 0; i < PANELS; i++) {
    const t = i / (PANELS - 1);
    const z = CORRIDOR_START + (CORRIDOR_END - CORRIDOR_START) * t + (rand() - 0.5) * 6;

    // Panels are pushed out of the middle of the frame so the camera flies
    // between them rather than into them, and so the copy in the centre of the
    // page always has somewhere clear to sit.
    const side = i % 2 === 0 ? -1 : 1;
    const x = side * (7 + rand() * 12);
    const y = (rand() - 0.5) * 15;

    const w = 9 + rand() * 7;
    const h = w * 0.625;

    const group = new THREE.Group();
    group.position.set(x, y, z);
    // Angled inward, as if the corridor's walls were made of screens.
    group.rotation.y = -side * (0.24 + rand() * 0.22);
    group.rotation.z = (rand() - 0.5) * 0.06;

    const face = new THREE.Mesh(panelGeo, new THREE.MeshBasicMaterial({
      map: textures[i % textures.length],
      transparent: true,
      opacity: 0.95,
      fog: true,
    }));
    face.scale.set(w, h, 1);
    group.add(face);

    // A lit edge, which is what makes a flat plane read as a physical object.
    const edge = new THREE.LineSegments(
      new THREE.EdgesGeometry(new THREE.PlaneGeometry(w, h)),
      new THREE.LineBasicMaterial({
        color: [CYAN, PURPLE, BLUE][i % 3],
        transparent: true,
        opacity: 0.68,
        fog: true,
      })
    );
    group.add(edge);

    scene.add(group);
    panels.push({ group, drift: 0.1 + rand() * 0.3, phase: rand() * Math.PI * 2, baseY: y });
  }

  /* ---- floor, ceiling and dust ----------------------------------------- */

  // Two grids give the corridor a top and a bottom. Without them the panels
  // float in nothing and the depth stops reading.
  [-13, 13].forEach((y) => {
    const grid = new THREE.GridHelper(300, 60, CYAN, BLUE);
    grid.position.set(0, y, -110);
    grid.material.transparent = true;
    grid.material.opacity = 0.17;
    grid.material.fog = true;
    scene.add(grid);
  });

  // Dust, so the space between the panels is not empty.
  const DUST = coarse ? 500 : 1100;
  const dustPos = new Float32Array(DUST * 3);
  for (let i = 0; i < DUST; i++) {
    dustPos[i * 3]     = (rand() - 0.5) * 90;
    dustPos[i * 3 + 1] = (rand() - 0.5) * 34;
    dustPos[i * 3 + 2] = CORRIDOR_START + (CORRIDOR_END - CORRIDOR_START) * rand();
  }
  const dustGeo = new THREE.BufferGeometry();
  dustGeo.setAttribute('position', new THREE.BufferAttribute(dustPos, 3));
  scene.add(new THREE.Points(dustGeo, new THREE.PointsMaterial({
    size: 0.13,
    color: BLUE,
    transparent: true,
    opacity: 0.5,
    depthWrite: false,
    blending: THREE.AdditiveBlending,
    fog: true,
  })));

  /* ---- scroll drives the camera ---------------------------------------- */

  // One continuous dolly bound to document scroll — the same relationship a
  // scrubbed frame sequence has, which is what makes the movement feel authored
  // rather than idle.
  const CAM_START = 30;
  const CAM_END   = -212;

  let progress = 0;
  let targetProgress = 0;
  let queued = false;

  const readScroll = () => {
    queued = false;
    const max = document.documentElement.scrollHeight - window.innerHeight;
    targetProgress = max > 0 ? Math.min(1, Math.max(0, window.scrollY / max)) : 0;
  };

  window.addEventListener('scroll', () => {
    if (!queued) { queued = true; requestAnimationFrame(readScroll); }
  }, { passive: true });

  readScroll();
  progress = targetProgress;

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
    const k = 1 - Math.pow(0.0015, dt);

    // Easing the scroll value rather than reading it raw is what stops the
    // camera snapping on a trackpad flick.
    progress += (targetProgress - progress) * k;

    pointer.x += (pointer.tx - pointer.x) * k * 0.4;
    pointer.y += (pointer.ty - pointer.y) * k * 0.4;

    camera.position.z = CAM_START + (CAM_END - CAM_START) * progress;
    // A slow lateral weave, so the flight is not a straight line down a tube.
    camera.position.x = Math.sin(progress * Math.PI * 2.2) * 4.5 + pointer.x * 2.4;
    camera.position.y = Math.sin(progress * Math.PI * 1.5) * 2.2 - pointer.y * 1.6;
    camera.rotation.y = -pointer.x * 0.05;
    camera.rotation.x = pointer.y * 0.03;

    // Panels breathe in place so a paused page is still alive.
    for (const p of panels) {
      p.group.position.y = p.baseY + Math.sin(time * p.drift + p.phase) * 0.5;
      p.group.rotation.z = Math.sin(time * p.drift * 0.7 + p.phase) * 0.02;
    }

    renderer.render(scene, camera);

    if (!revealed) {
      revealed = true;
      mount.classList.add('sd-stage--live');
      document.documentElement.classList.add('sd-has-stage');
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
      readScroll();
    }, 150);
  }, { passive: true });
}
