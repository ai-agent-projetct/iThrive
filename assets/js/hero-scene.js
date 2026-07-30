/**
 * Hero scene — a glowing neural ring of nodes wrapped around a Python-blue
 * mesh sphere, rotating slowly in 3D space.
 *
 * Everything is drawn with LineSegments and Points rather than lit geometry:
 * no textures to load, and the whole thing stays under a couple of thousand
 * vertices so it is cheap on integrated GPUs.
 *
 * The CSS orb underneath stays visible until this module has rendered its
 * first frame, so a WebGL failure degrades to a static gradient instead of a
 * hole in the layout.
 */

import * as THREE from 'three';

// The scene is reused by the hero and by the voice assistant section, so it
// binds to data hooks rather than one hard-coded id.
const stage = document.querySelector('[data-orb-stage]');
const mount = document.querySelector('[data-orb-canvas]');

const CYAN = new THREE.Color('#00F2FE');
const PURPLE = new THREE.Color('#9D4EDD');
const BLUE = new THREE.Color('#3B82F6');

const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

/** Base X rotation, in radians — the angle the neural ring is viewed from. */
const TILT = 0.34;

function build() {
  if (!stage || !mount) return;

  let renderer;
  try {
    renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true, powerPreference: 'low-power' });
  } catch {
    return; // No WebGL — the CSS orb stays.
  }

  const size = () => Math.max(mount.clientWidth, 1);

  renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
  renderer.setSize(size(), size(), false);
  mount.appendChild(renderer.domElement);

  const scene = new THREE.Scene();
  const camera = new THREE.PerspectiveCamera(42, 1, 0.1, 100);
  // The ring sits at radius 3.3, so the camera has to sit far enough back that
  // its widest points clear the frame: half-height = z * tan(fov/2).
  camera.position.set(0, 0, 11);

  const world = new THREE.Group();
  scene.add(world);

  // ---- Core sphere: a wireframe icosahedron, doubled up for depth ----------

  const coreGeo = new THREE.IcosahedronGeometry(2.05, 2);
  const core = new THREE.LineSegments(
    new THREE.WireframeGeometry(coreGeo),
    new THREE.LineBasicMaterial({ color: BLUE, transparent: true, opacity: 0.22 })
  );
  world.add(core);

  const shell = new THREE.LineSegments(
    new THREE.WireframeGeometry(new THREE.IcosahedronGeometry(2.62, 1)),
    new THREE.LineBasicMaterial({ color: PURPLE, transparent: true, opacity: 0.28 })
  );
  world.add(shell);

  // ---- Neural ring: nodes on a torus band, wired to their neighbours -------

  const NODE_COUNT = 64;
  const RING_R = 3.3;
  const nodes = [];

  for (let i = 0; i < NODE_COUNT; i++) {
    const t = (i / NODE_COUNT) * Math.PI * 2;
    // Two interleaved bands, tilted apart, so the ring reads as a shell.
    const band = i % 2 === 0 ? 1 : -1;
    const wobble = Math.sin(t * 3) * 0.42;

    nodes.push(new THREE.Vector3(
      Math.cos(t) * RING_R,
      Math.sin(t * 2) * 0.55 + wobble * band,
      Math.sin(t) * RING_R
    ));
  }

  const nodeGeo = new THREE.BufferGeometry().setFromPoints(nodes);
  nodeGeo.setAttribute('color', new THREE.Float32BufferAttribute(
    nodes.flatMap((_, i) => {
      const c = CYAN.clone().lerp(PURPLE, i / NODE_COUNT);
      return [c.r, c.g, c.b];
    }), 3
  ));

  const ring = new THREE.Points(nodeGeo, new THREE.PointsMaterial({
    size: 0.13,
    vertexColors: true,
    transparent: true,
    opacity: 0.95,
    sizeAttenuation: true,
  }));
  world.add(ring);

  // Chords between nodes that happen to be close — the "synapse" look.
  const chordPoints = [];
  const chordColors = [];
  for (let i = 0; i < NODE_COUNT; i++) {
    for (let j = i + 1; j < NODE_COUNT; j++) {
      if (nodes[i].distanceTo(nodes[j]) > 1.5) continue;
      const c = CYAN.clone().lerp(PURPLE, (i + j) / (NODE_COUNT * 2));
      chordPoints.push(nodes[i], nodes[j]);
      chordColors.push(c.r, c.g, c.b, c.r, c.g, c.b);
    }
  }

  const chordGeo = new THREE.BufferGeometry().setFromPoints(chordPoints);
  chordGeo.setAttribute('color', new THREE.Float32BufferAttribute(chordColors, 3));
  const chords = new THREE.LineSegments(chordGeo, new THREE.LineBasicMaterial({
    vertexColors: true,
    transparent: true,
    opacity: 0.34,
  }));
  world.add(chords);

  // ---- Dust field ---------------------------------------------------------

  const DUST = 220;
  const dust = new Float32Array(DUST * 3);
  for (let i = 0; i < DUST; i++) {
    const r = 3.6 + Math.random() * 3.4;
    const theta = Math.random() * Math.PI * 2;
    const phi = Math.acos(2 * Math.random() - 1);
    dust[i * 3] = r * Math.sin(phi) * Math.cos(theta);
    dust[i * 3 + 1] = r * Math.cos(phi) * 0.62;
    dust[i * 3 + 2] = r * Math.sin(phi) * Math.sin(theta);
  }

  const dustGeo = new THREE.BufferGeometry();
  dustGeo.setAttribute('position', new THREE.BufferAttribute(dust, 3));
  world.add(new THREE.Points(dustGeo, new THREE.PointsMaterial({
    size: 0.035,
    color: CYAN,
    transparent: true,
    opacity: 0.5,
  })));

  // ---- Interaction --------------------------------------------------------

  const pointer = { x: 0, y: 0 };
  const target = { x: 0, y: 0 };

  if (!reduceMotion) {
    window.addEventListener('pointermove', (event) => {
      const rect = stage.getBoundingClientRect();
      target.x = ((event.clientX - rect.left) / rect.width - 0.5) * 0.5;
      target.y = ((event.clientY - rect.top) / rect.height - 0.5) * 0.4;
    }, { passive: true });
  }

  const resize = () => {
    const s = size();
    renderer.setSize(s, s, false);
    camera.aspect = 1;
    camera.updateProjectionMatrix();
  };
  window.addEventListener('resize', resize);
  resize();

  // Pause when the hero scrolls out of view — no point burning frames on it.
  let visible = true;
  if ('IntersectionObserver' in window) {
    new IntersectionObserver(([entry]) => { visible = entry.isIntersecting; }, { threshold: 0 })
      .observe(stage);
  }

  const clock = new THREE.Clock();
  let started = false;
  let spinRate = 0.12;
  let spinPhase = 0;

  /**
   * Voice-assistant state. The orb is the assistant's face, so it has to read
   * differently while it is listening, thinking and speaking — exposed as a
   * tiny API rather than letting assistant.js reach into the scene.
   */
  const STATES = {
    idle:      { spin: 0.12, pulse: 0.00, tint: CYAN,   glow: 1.00 },
    listening: { spin: 0.30, pulse: 0.16, tint: CYAN,   glow: 1.55 },
    thinking:  { spin: 0.75, pulse: 0.07, tint: PURPLE, glow: 1.30 },
    speaking:  { spin: 0.20, pulse: 0.26, tint: BLUE,   glow: 1.70 },
  };
  let state = STATES.idle;
  let level = 0;      // live mic/− speech amplitude, 0..1
  let mix = 0;        // eased blend toward the active state

  window.ithriveOrb = {
    setState(name) { state = STATES[name] || STATES.idle; },
    setLevel(v)    { level = Math.max(0, Math.min(1, v)); },
  };

  function frame() {
    requestAnimationFrame(frame);
    if (!visible) return;

    const t = clock.getElapsedTime();

    pointer.x += (target.x - pointer.x) * 0.04;
    pointer.y += (target.y - pointer.y) * 0.04;

    // Ease toward the active state so transitions never snap.
    mix += ((state === STATES.idle ? 0 : 1) - mix) * 0.06;

    spinRate += (state.spin - spinRate) * 0.05;
    spinPhase += spinRate * 0.016;

    world.rotation.y = (reduceMotion ? 0.4 : spinPhase) + pointer.x;
    // TILT keeps the ring reading as a ring — without it the band is viewed
    // almost edge-on and collapses into two horizontal lines.
    world.rotation.x = TILT + Math.sin(t * 0.22) * 0.12 + pointer.y;

    // Breathe with the voice: amplitude while speaking, a steady pulse while
    // listening or thinking.
    const beat = Math.sin(t * (state === STATES.thinking ? 7 : 3.4));
    const swell = 1 + state.pulse * (0.45 * beat + 0.55 * level) * mix;
    world.scale.setScalar(swell);

    ring.material.opacity = 0.95;
    chords.material.opacity = 0.34 + 0.3 * mix * (0.4 + level * 0.6);
    core.material.color.lerp(state.tint, 0.03);
    shell.material.opacity = 0.28 * state.glow;

    core.rotation.y = -t * 0.08;
    shell.rotation.x = t * 0.05;
    ring.rotation.z = Math.sin(t * 0.3) * 0.06;

    renderer.render(scene, camera);

    if (!started) {
      started = true;
      stage.classList.add('is-live');
    }
  }

  frame();
}

build();
