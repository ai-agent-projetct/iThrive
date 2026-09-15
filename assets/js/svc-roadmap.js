/**
 * The five-phase roadmap, drawn in 3D — sixteen different ways.
 *
 * Every AI service page has a five-phase section, and giving all sixteen the
 * same diagram made the pages feel like one page repeated. So the mechanic
 * changes per page and matches that page's motif, the same motif its images are
 * briefed against in docs/image-prompts.md: the orchestration page orbits, the
 * RPA page repeats, the integration page couples two unlike sides together.
 *
 * The page picks one with data-roadmap="<variant>". An unknown name falls back
 * to the path, so a new page is never broken by a typo.
 *
 * Three rules hold across all sixteen:
 *
 *  - No text in the canvas. Every phase name, duration and description stays in
 *    the cards below. Text baked into a WebGL context is text no crawler and no
 *    screen reader reads, and these pages exist to rank.
 *
 *  - The cards drive the active phase, not a timer. Hover or focus a card and
 *    its node lights; otherwise the card nearest the middle of the viewport
 *    wins. The canvas follows the reading position rather than competing.
 *
 *  - Additive. No WebGL, reduced motion, or this file blocked: the host stays
 *    collapsed and the cards are the whole section.
 */

import * as THREE from 'three';

const host = document.querySelector('[data-roadmap]');

if (host && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
  start(host);
}

function start(mount) {
  const nodes = [...mount.querySelectorAll('[data-roadmap-node]')];
  if (nodes.length < 2) return;

  let renderer;
  try {
    renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true, powerPreference: 'high-performance' });
  } catch (err) {
    return;
  }

  const CYAN = 0x00f2fe, BLUE = 0x4ea8ff, PURPLE = 0x9d4edd, INK = 0x0b0f17;
  const count = nodes.length;
  const coarse = window.matchMedia('(pointer: coarse)').matches;
  const variant = mount.dataset.roadmap || 'path';

  const W = () => mount.clientWidth || 960;
  const H = () => mount.clientHeight || 280;

  renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, coarse ? 1.5 : 1.75));
  renderer.setSize(W(), H());
  mount.appendChild(renderer.domElement);
  mount.classList.add('is-live');

  const scene = new THREE.Scene();
  scene.fog = new THREE.Fog(INK, 20, 70);
  const camera = new THREE.PerspectiveCamera(46, W() / H(), 0.1, 140);

  const hue = (i) => new THREE.Color(CYAN).lerp(new THREE.Color(PURPLE), count < 2 ? 0 : i / (count - 1));
  const lineMat = (c, o) => new THREE.LineBasicMaterial({ color: c, transparent: true, opacity: o });
  const addLine = (pts, c, o) => {
    const l = new THREE.Line(new THREE.BufferGeometry().setFromPoints(pts), lineMat(c, o));
    scene.add(l);
    return l;
  };

  /* ---- sixteen layouts -------------------------------------------------
     Each returns the phase positions; anything else it adds to the scene is
     that variant's own scenery. Positions drive the markers, which are shared. */

  const LAYOUTS = {
    // A travelled path. Consulting: one route chosen out of many.
    path() {
      const curve = new THREE.CatmullRomCurve3([
        new THREE.Vector3(-13, -0.6, -2), new THREE.Vector3(-6.5, 0.9, 1.5),
        new THREE.Vector3(0, -0.4, -1), new THREE.Vector3(6.5, 1.0, 1.5),
        new THREE.Vector3(13, -0.2, -2),
      ]);
      addLine(curve.getPoints(200), BLUE, 0.3);
      return Array.from({ length: count }, (_, i) => curve.getPointAt(i / (count - 1)));
    },

    // Particles converging. Generative AI: chaos resolving into structure.
    converge() {
      const pos = new Float32Array(600 * 3);
      for (let i = 0; i < 600; i++) {
        const t = Math.random();
        pos[i * 3] = -16 + t * 32 + (Math.random() - 0.5) * 3;
        pos[i * 3 + 1] = (Math.random() - 0.5) * (1 - t) * 11;
        pos[i * 3 + 2] = (Math.random() - 0.5) * (1 - t) * 11;
      }
      const g = new THREE.BufferGeometry();
      g.setAttribute('position', new THREE.BufferAttribute(pos, 3));
      scene.add(new THREE.Points(g, new THREE.PointsMaterial({
        size: 0.1, color: BLUE, transparent: true, opacity: 0.5,
        blending: THREE.AdditiveBlending, depthWrite: false,
      })));
      return spread((i) => new THREE.Vector3(-13 + i * (26 / (count - 1)), 0, 0));
    },

    // Expanding rings. Chatbot: one turn answering the last.
    rings() {
      return spread((i) => {
        const x = -13 + i * (26 / (count - 1));
        const r = 1.1 + i * 0.5;
        const pts = [];
        for (let a = 0; a <= 64; a++) {
          const th = (a / 64) * Math.PI * 2;
          pts.push(new THREE.Vector3(x, Math.cos(th) * r, Math.sin(th) * r));
        }
        addLine(pts, hue(i).getHex(), 0.22);
        return new THREE.Vector3(x, 0, 0);
      });
    },

    // Twin rails, one leading. Copilot: a guide beside the work.
    rails() {
      [-1.5, 1.5].forEach((z, k) => {
        addLine([new THREE.Vector3(-14, 0, z), new THREE.Vector3(14, 0, z)], k ? CYAN : BLUE, k ? 0.4 : 0.22);
      });
      return spread((i) => new THREE.Vector3(-13 + i * (26 / (count - 1)), 0, -1.5));
    },

    // Stacked layers, one drawn out. RAG: retrieval from the archive.
    layers() {
      return spread((i) => {
        const x = -13 + i * (26 / (count - 1));
        for (let k = 0; k < 4; k++) {
          const y = -1.6 + k * 1.1;
          addLine([
            new THREE.Vector3(x - 1.5, y, -1.5), new THREE.Vector3(x + 1.5, y, -1.5),
            new THREE.Vector3(x + 1.5, y, 1.5), new THREE.Vector3(x - 1.5, y, 1.5),
            new THREE.Vector3(x - 1.5, y, -1.5),
          ], BLUE, 0.16);
        }
        return new THREE.Vector3(x, 1.7, 0);
      });
    },

    // A sweeping bar. Computer vision: the scanning beam.
    scan() {
      const bar = addLine([new THREE.Vector3(0, -4, 0), new THREE.Vector3(0, 4, 0)], CYAN, 0.75);
      extras.bar = bar;
      addLine([new THREE.Vector3(-14, -3.2, 0), new THREE.Vector3(14, -3.2, 0)], BLUE, 0.25);
      return spread((i) => new THREE.Vector3(-13 + i * (26 / (count - 1)), 0, 0));
    },

    // A splitting trunk. Strategy: the branching path.
    branch() {
      const pts = [];
      return spread((i) => {
        const x = -13 + i * (26 / (count - 1));
        const y = i === 0 ? 0 : (i % 2 ? 1.6 : -1.6) * (i / count);
        const p = new THREE.Vector3(x, y, 0);
        if (pts.length) addLine([pts[pts.length - 1], p], BLUE, 0.3);
        // a pruned branch, to show the paths not taken
        if (i > 0 && i < count - 1) {
          addLine([p, new THREE.Vector3(x + 3, y + (i % 2 ? 2.4 : -2.4), -1)], BLUE, 0.1);
        }
        pts.push(p);
        return p;
      });
    },

    // Blocks stacking. Custom agents: modular assembly.
    stack() {
      return spread((i) => {
        const x = -13 + i * (26 / (count - 1));
        const h = 0.5 + i * 0.42;
        const box = new THREE.LineSegments(
          new THREE.EdgesGeometry(new THREE.BoxGeometry(2.2, h, 2.2)),
          lineMat(hue(i).getHex(), 0.3)
        );
        box.position.set(x, -2 + h / 2, 0);
        scene.add(box);
        return new THREE.Vector3(x, -2 + h + 0.7, 0);
      });
    },

    // A shelf of identical units. Agent solutions: the catalogue.
    grid() {
      return spread((i) => {
        const x = -13 + i * (26 / (count - 1));
        for (let r = 0; r < 3; r++) {
          const cell = new THREE.LineSegments(
            new THREE.EdgesGeometry(new THREE.BoxGeometry(1.7, 1.1, 1.7)),
            lineMat(BLUE, 0.14)
          );
          cell.position.set(x, -2.4 + r * 1.35, 0);
          scene.add(cell);
        }
        return new THREE.Vector3(x, 2.1, 0);
      });
    },

    // Nodes orbiting a hub. Orchestration: the conducted system.
    orbit() {
      const hub = new THREE.Mesh(
        new THREE.SphereGeometry(0.7, 20, 20),
        new THREE.MeshBasicMaterial({ color: CYAN, transparent: true, opacity: 0.5 })
      );
      scene.add(hub);
      extras.hub = hub;
      return spread((i) => {
        const a = (i / count) * Math.PI * 2;
        const r = 7.5;
        const p = new THREE.Vector3(Math.cos(a) * r, Math.sin(a) * r * 0.42, Math.sin(a) * 2.5);
        addLine([new THREE.Vector3(0, 0, 0), p], BLUE, 0.16);
        return p;
      });
    },

    // Two unlike sides, coupled. Agentic integration: the contract layer.
    couple() {
      [-3.2, 3.2].forEach((y, k) => {
        addLine([new THREE.Vector3(-14, y, 0), new THREE.Vector3(14, y, 0)], k ? PURPLE : CYAN, 0.26);
      });
      return spread((i) => {
        const x = -13 + i * (26 / (count - 1));
        addLine([new THREE.Vector3(x, -3.2, 0), new THREE.Vector3(x, 3.2, 0)], BLUE, 0.22);
        return new THREE.Vector3(x, 0, 0);
      });
    },

    // One gate, many spokes. AI integration: the central gateway.
    hub() {
      const ring = new THREE.Mesh(
        new THREE.TorusGeometry(1.5, 0.07, 10, 48),
        new THREE.MeshBasicMaterial({ color: CYAN, transparent: true, opacity: 0.4 })
      );
      scene.add(ring);
      extras.hub = ring;
      return spread((i) => {
        const a = -Math.PI / 2 + ((i + 0.5) / count) * Math.PI * 2;
        const p = new THREE.Vector3(Math.cos(a) * 8.5, Math.sin(a) * 3.6, 0);
        addLine([new THREE.Vector3(Math.cos(a) * 1.7, Math.sin(a) * 1.7, 0), p], BLUE, 0.2);
        return p;
      });
    },

    // A conveyor of tiles. Workflow automation: the moving queue.
    conveyor() {
      for (let k = 0; k < 2; k++) {
        addLine([new THREE.Vector3(-14, -1.6 + k * 3.2, 0), new THREE.Vector3(14, -1.6 + k * 3.2, 0)], BLUE, 0.22);
      }
      return spread((i) => {
        const x = -13 + i * (26 / (count - 1));
        const tile = new THREE.LineSegments(
          new THREE.EdgesGeometry(new THREE.PlaneGeometry(2.4, 2.4)),
          lineMat(hue(i).getHex(), 0.26)
        );
        tile.position.set(x, 0, 0);
        scene.add(tile);
        return new THREE.Vector3(x, 0, 0.6);
      });
    },

    // A bank of dials. Agent operations: the instrument panel.
    dials() {
      return spread((i) => {
        const x = -13 + i * (26 / (count - 1));
        const pts = [];
        for (let a = 0; a <= 40; a++) {
          const th = Math.PI * 0.15 + (a / 40) * Math.PI * 0.7;
          pts.push(new THREE.Vector3(x + Math.cos(th) * 2, Math.sin(th) * 2 - 0.6, 0));
        }
        addLine(pts, hue(i).getHex(), 0.3);
        return new THREE.Vector3(x, 1.5, 0);
      });
    },

    // A repeating cycle. RPA: the mechanism that never varies.
    cycle() {
      return spread((i) => {
        const x = -13 + i * (26 / (count - 1));
        const pts = [];
        for (let a = 0; a <= 48; a++) {
          const th = (a / 48) * Math.PI * 2;
          pts.push(new THREE.Vector3(x + Math.cos(th) * 1.9, Math.sin(th) * 1.9, 0));
        }
        addLine(pts, BLUE, 0.2);
        if (i < count - 1) {
          const nx = -13 + (i + 1) * (26 / (count - 1));
          addLine([new THREE.Vector3(x + 1.9, 0, 0), new THREE.Vector3(nx - 1.9, 0, 0)], CYAN, 0.28);
        }
        return new THREE.Vector3(x, 0, 0);
      });
    },

    // An interlocking lattice. Hiring: a team that carries load together.
    lattice() {
      const p = spread((i) => {
        const x = -13 + i * (26 / (count - 1));
        return new THREE.Vector3(x, i % 2 ? 1.5 : -1.5, i % 2 ? -1 : 1);
      });
      for (let i = 0; i < p.length; i++) {
        for (let j = i + 1; j < p.length; j++) {
          if (j - i <= 2) addLine([p[i], p[j]], BLUE, j - i === 1 ? 0.3 : 0.12);
        }
      }
      return p;
    },
  };

  function spread(fn) { return Array.from({ length: count }, (_, i) => fn(i)); }

  const extras = {};
  const build = LAYOUTS[variant] || LAYOUTS.path;
  const points = build();

  /* ---- the phase markers, shared by every layout ----------------------- */

  const ringGeo = new THREE.TorusGeometry(0.6, 0.05, 10, 36);
  const coreGeo = new THREE.SphereGeometry(0.19, 16, 16);
  const markers = points.map((p, i) => {
    const colour = hue(i);
    const group = new THREE.Group();
    group.position.copy(p);
    const ring = new THREE.Mesh(ringGeo, new THREE.MeshBasicMaterial({ color: colour, transparent: true, opacity: 0.4 }));
    const core = new THREE.Mesh(coreGeo, new THREE.MeshBasicMaterial({ color: colour, transparent: true, opacity: 0.7 }));
    group.add(ring, core);
    scene.add(group);
    return { group, ring, core, lit: 0 };
  });

  // Frame whatever the layout produced, so no variant needs its own camera.
  //
  // Bounds come from the scene, not just the phase positions, so a layout's own
  // scenery (the scan bar, the stacked blocks, the orbit ring) is inside the
  // shot. Points are skipped on purpose: the generative page's particle field is
  // meant to run off the edges rather than pull the camera back.
  //
  // These hosts are about 4:1, so fitting only the vertical field — which is
  // what a naive framing does — leaves the diagram filling a quarter of the
  // width. Fit both axes and take whichever needs more room.
  const mid = new THREE.Vector3();
  const box = new THREE.Box3();

  function reframe() {
    box.makeEmpty();
    scene.traverse((o) => {
      if (o.isPoints || !o.geometry) return;
      box.expandByObject(o);
    });
    if (box.isEmpty()) box.setFromPoints(points);
    box.getCenter(mid);

    const size = box.getSize(new THREE.Vector3());
    const halfV = Math.tan(THREE.MathUtils.degToRad(camera.fov / 2));
    const halfH = halfV * camera.aspect;
    const dist = Math.max(size.x / 2 / halfH, size.y / 2 / halfV) * 1.2 + 3;

    camera.position.set(mid.x, mid.y + size.y * 0.12 + 0.6, dist);
    camera.lookAt(mid);
    baseY = camera.position.y;
  }
  let baseY = 0;
  reframe();

  /* ---- which phase is active ------------------------------------------- */

  const cards = [...document.querySelectorAll('[data-roadmap-step]')];
  let active = 0, pinned = null, queued = false;

  cards.forEach((card) => {
    const i = Number(card.dataset.roadmapStep);
    card.addEventListener('pointerenter', () => { pinned = i; });
    card.addEventListener('pointerleave', () => { pinned = null; });
    card.addEventListener('focusin', () => { pinned = i; });
    card.addEventListener('focusout', () => { pinned = null; });
  });

  const pick = () => {
    queued = false;
    if (pinned !== null) { active = pinned; return; }
    if (!cards.length) return;
    const m = window.innerHeight / 2;
    let best = 0, bd = Infinity;
    cards.forEach((c) => {
      const r = c.getBoundingClientRect();
      const d = Math.abs(r.top + r.height / 2 - m);
      if (d < bd) { bd = d; best = Number(c.dataset.roadmapStep); }
    });
    active = best;
  };
  window.addEventListener('scroll', () => { if (!queued) { queued = true; requestAnimationFrame(pick); } }, { passive: true });
  pick();

  /* ---- pointer parallax ------------------------------------------------ */

  const ptr = { x: 0, tx: 0 };
  if (!coarse) {
    mount.addEventListener('pointermove', (e) => {
      const r = mount.getBoundingClientRect();
      ptr.tx = ((e.clientX - r.left) / r.width - 0.5) * 2;
    }, { passive: true });
    mount.addEventListener('pointerleave', () => { ptr.tx = 0; });
  }

  /* ---- loop ------------------------------------------------------------ */

  const clock = new THREE.Clock();
  let running = true;
  document.addEventListener('visibilitychange', () => {
    running = !document.hidden;
    if (running) { clock.getDelta(); requestAnimationFrame(frame); }
  });

  function frame() {
    if (!running) return;
    requestAnimationFrame(frame);
    const dt = Math.min(clock.getDelta(), 0.05);
    const t = clock.elapsedTime;
    const k = 1 - Math.pow(0.002, dt);

    markers.forEach((m, i) => {
      m.lit += ((i === active ? 1 : 0) - m.lit) * k;
      m.group.scale.setScalar(1 + m.lit * 0.5 + Math.sin(t * 1.6 + i) * 0.02);
      m.ring.material.opacity = 0.32 + m.lit * 0.55;
      m.core.material.opacity = 0.5 + m.lit * 0.45;
      m.ring.rotation.z = t * (0.25 + i * 0.05);
      m.ring.rotation.x = Math.PI / 2.6;
    });

    // Per-variant scenery that has to react to the active phase.
    if (extras.bar && markers[active]) {
      extras.bar.position.x += (markers[active].group.position.x - extras.bar.position.x) * k;
    }
    if (extras.hub) {
      extras.hub.rotation.z = t * 0.3;
      extras.hub.rotation.x = Math.PI / 2.4;
    }

    ptr.x += (ptr.tx - ptr.x) * k * 0.6;
    camera.position.x = mid.x + ptr.x * 2.4;
    camera.position.y = baseY + Math.sin(t * 0.5) * 0.12;
    camera.lookAt(mid);
    renderer.render(scene, camera);
  }
  requestAnimationFrame(frame);

  /* ---- resize ---------------------------------------------------------- */

  let timer;
  window.addEventListener('resize', () => {
    clearTimeout(timer);
    timer = setTimeout(() => {
      camera.aspect = W() / H();
      camera.updateProjectionMatrix();
      renderer.setSize(W(), H());
      reframe(); // the fit depends on aspect, so a new width needs a new distance
    }, 150);
  }, { passive: true });
}
