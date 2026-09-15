/**
 * The five-phase roadmap, drawn as a path in 3D.
 *
 * Shared by the sixteen AI service pages. It reads the phases out of the DOM
 * rather than carrying its own copy, so a page that changes a phase name does
 * not also have to change a script.
 *
 * Three decisions worth knowing about:
 *
 *  - The canvas carries no words. Every phase name, duration and description
 *    stays in the cards below it. Text baked into a WebGL context is text no
 *    crawler and no screen reader will ever read, and these pages exist to
 *    rank.
 *
 *  - The active phase is driven by the cards, not by a timer. Hovering or
 *    focusing a step card lights its node; otherwise the node nearest the
 *    middle of the viewport is the active one. So the 3D follows the reading
 *    position instead of competing with it.
 *
 *  - It is additive. Without WebGL, under prefers-reduced-motion, or with this
 *    file blocked, the host stays empty and collapsed and the cards are the
 *    whole section. Nothing below depends on it.
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
    return; // No WebGL. The cards below are already the complete section.
  }

  const CYAN   = 0x00f2fe;
  const BLUE   = 0x4ea8ff;
  const PURPLE = 0x9d4edd;
  const INK    = 0x0b0f17;

  const count = nodes.length;
  const coarse = window.matchMedia('(pointer: coarse)').matches;

  const width  = () => mount.clientWidth || 960;
  const height = () => mount.clientHeight || 260;

  renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, coarse ? 1.5 : 1.75));
  renderer.setSize(width(), height());
  mount.appendChild(renderer.domElement);
  mount.classList.add('is-live');

  const scene = new THREE.Scene();
  scene.fog = new THREE.Fog(INK, 18, 62);

  const camera = new THREE.PerspectiveCamera(46, width() / height(), 0.1, 120);
  camera.position.set(0, 3.4, 15);

  /* ---- the path -------------------------------------------------------- */

  // A gentle S so the line reads as a journey rather than a ruler. The phases
  // sit at even intervals along it, which is what makes the spacing legible.
  const curve = new THREE.CatmullRomCurve3([
    new THREE.Vector3(-13, -0.6, -2),
    new THREE.Vector3(-6.5, 0.9, 1.5),
    new THREE.Vector3(0, -0.4, -1),
    new THREE.Vector3(6.5, 1.0, 1.5),
    new THREE.Vector3(13, -0.2, -2),
  ]);

  const line = new THREE.Line(
    new THREE.BufferGeometry().setFromPoints(curve.getPoints(220)),
    new THREE.LineBasicMaterial({ color: BLUE, transparent: true, opacity: 0.32 })
  );
  scene.add(line);

  // A brighter segment that runs ahead of the active phase, so the path reads
  // as travelled-so-far rather than as decoration.
  const travelled = new THREE.Line(
    new THREE.BufferGeometry().setFromPoints(curve.getPoints(220)),
    new THREE.LineBasicMaterial({ color: CYAN, transparent: true, opacity: 0.9 })
  );
  travelled.geometry.setDrawRange(0, 2);
  scene.add(travelled);

  /* ---- the phase markers ----------------------------------------------- */

  const markers = [];
  const ringGeo = new THREE.TorusGeometry(0.62, 0.055, 10, 40);
  const coreGeo = new THREE.SphereGeometry(0.2, 18, 18);

  for (let i = 0; i < count; i++) {
    const at = curve.getPointAt(i / (count - 1));
    const hue = i / Math.max(1, count - 1);
    const colour = new THREE.Color(CYAN).lerp(new THREE.Color(PURPLE), hue);

    const group = new THREE.Group();
    group.position.copy(at);

    const ring = new THREE.Mesh(ringGeo, new THREE.MeshBasicMaterial({
      color: colour, transparent: true, opacity: 0.42,
    }));
    const core = new THREE.Mesh(coreGeo, new THREE.MeshBasicMaterial({
      color: colour, transparent: true, opacity: 0.75,
    }));

    group.add(ring, core);
    scene.add(group);
    markers.push({ group, ring, core, colour, lit: 0, target: 0 });
  }

  /* ---- which phase is active ------------------------------------------- */

  // The cards own this. Hover or focus wins; otherwise whichever card is
  // nearest the middle of the viewport.
  const cards = [...document.querySelectorAll('[data-roadmap-step]')];
  let active = 0;
  let pinned = null;

  cards.forEach((card) => {
    const idx = Number(card.dataset.roadmapStep);
    const pin = () => { pinned = idx; };
    const release = () => { pinned = null; };
    card.addEventListener('pointerenter', pin);
    card.addEventListener('pointerleave', release);
    card.addEventListener('focusin', pin);
    card.addEventListener('focusout', release);
  });

  let queued = false;
  const pickActive = () => {
    queued = false;
    if (pinned !== null) { active = pinned; return; }
    if (!cards.length) return;
    const mid = window.innerHeight / 2;
    let best = 0;
    let bestDist = Infinity;
    cards.forEach((card) => {
      const r = card.getBoundingClientRect();
      const d = Math.abs(r.top + r.height / 2 - mid);
      if (d < bestDist) { bestDist = d; best = Number(card.dataset.roadmapStep); }
    });
    active = best;
  };

  window.addEventListener('scroll', () => {
    if (!queued) { queued = true; requestAnimationFrame(pickActive); }
  }, { passive: true });
  pickActive();

  /* ---- pointer parallax ------------------------------------------------- */

  const pointer = { x: 0, tx: 0 };
  if (!coarse) {
    mount.addEventListener('pointermove', (e) => {
      const r = mount.getBoundingClientRect();
      pointer.tx = ((e.clientX - r.left) / r.width - 0.5) * 2;
    }, { passive: true });
    mount.addEventListener('pointerleave', () => { pointer.tx = 0; });
  }

  /* ---- loop ------------------------------------------------------------- */

  const clock = new THREE.Clock();
  let running = true;

  document.addEventListener('visibilitychange', () => {
    running = !document.hidden;
    if (running) { clock.getDelta(); requestAnimationFrame(frame); }
  });

  const TOTAL = 220;

  function frame() {
    if (!running) return;
    requestAnimationFrame(frame);

    const dt = Math.min(clock.getDelta(), 0.05);
    const t  = clock.elapsedTime;
    const k  = 1 - Math.pow(0.002, dt);

    markers.forEach((m, i) => {
      m.target = i === active ? 1 : 0;
      m.lit += (m.target - m.lit) * k;

      const scale = 1 + m.lit * 0.5 + Math.sin(t * 1.6 + i) * 0.02;
      m.group.scale.setScalar(scale);
      m.ring.material.opacity = 0.34 + m.lit * 0.55;
      m.core.material.opacity = 0.55 + m.lit * 0.45;
      m.ring.rotation.z = t * (0.25 + i * 0.05);
      m.ring.rotation.x = Math.PI / 2.6;
    });

    // The travelled portion stops at the active marker.
    const reach = Math.round((active / Math.max(1, count - 1)) * TOTAL) + 2;
    const shown = travelled.geometry.drawRange.count;
    travelled.geometry.setDrawRange(0, Math.round(shown + (reach - shown) * k));

    pointer.x += (pointer.tx - pointer.x) * k * 0.6;
    camera.position.x = pointer.x * 2.2;
    camera.position.y = 3.4 + Math.sin(t * 0.5) * 0.12;
    camera.lookAt(0, 0, 0);

    renderer.render(scene, camera);
  }

  requestAnimationFrame(frame);

  /* ---- resize ----------------------------------------------------------- */

  let timer;
  window.addEventListener('resize', () => {
    clearTimeout(timer);
    timer = setTimeout(() => {
      camera.aspect = width() / height();
      camera.updateProjectionMatrix();
      renderer.setSize(width(), height());
    }, 150);
  }, { passive: true });
}
