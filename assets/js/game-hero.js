/**
 * The Game Development hero — a real 3D endless runner.
 *
 *     move the mouse -> the rocket moves -> avoid the rocks -> the score climbs
 *
 * The previous hero was a parallax of DOM layers. It could not sell forward
 * motion, because nothing was actually receding: a flat scene slid sideways.
 * This is three.js with a chase camera, so depth is real and the world genuinely
 * comes at you.
 *
 * three r160 is already vendored at assets/vendor/three/three.module.js for the
 * mobile page's universe, so this imports it directly rather than adding a
 * bundle step. Nothing else is downloaded.
 *
 * REFERENCE. Built from the four stills, primarily the third — a rocket over
 * low-poly peaks under stars, already lit in cyan. The moon placement and the
 * low horizon come from the fourth. The composition the whole thing protects is
 * the one the recording had:
 *
 *     moon -> horizon -> obstacles -> rocket -> score
 *
 * FAILING SAFE. WebGL is not guaranteed: no GPU, a lost context, a browser that
 * refuses. The CSS night scene stays in the markup underneath this canvas and
 * is what a visitor sees if the renderer never starts. Nine components on this
 * site have shipped blank rectangles; this one cannot.
 */
import * as THREE from '../vendor/three/three.module.js';

const hero = document.querySelector('[data-flight]');
const canvas = hero && hero.querySelector('[data-game-canvas]');
if (!hero || !canvas) throw new Error('[game] no mount');

const scoreEl = hero.querySelector('[data-score]');
const overlay = hero.querySelector('[data-overlay]');
const overlayTitle = hero.querySelector('[data-overlay-title]');
const overlaySub = hero.querySelector('[data-overlay-sub]');
const restartBtn = hero.querySelector('[data-start]');

/* ---------------------------------------------------------------------------
 * Tuning — all of it here, none of it buried in the loop.
 * ------------------------------------------------------------------------ */

const LANE = 26;            /* half-width of the playable corridor, world units */
const SPAWN_Z = -420;       /* where obstacles appear, ahead of the camera */
const DESPAWN_Z = 40;       /* where they are recycled, behind it */

const SPEED_START = 78;     /* world units per second */
const SPEED_MAX = 168;
const SPEED_RAMP = 2.4;     /* added per second of survival */

const GAP_START = 34;       /* world units between obstacle rows at the start */
const GAP_MIN = 17;

const STEER_KEY = 34;       /* units per second on the keyboard */
const EASE = 6.5;           /* how hard the rocket chases the target lane */
const BANK = 0.055;         /* radians of roll per unit of lateral speed */

const HIT_X = 3.4;          /* half-widths summed; generous, so it feels fair */
const HIT_Z = 3.2;

const POOL = 26;            /* obstacles alive at once — pooled, never created */
const SCENERY = 40;         /* small rocks for texture */
const PEAKS = 22;           /* distant silhouettes on the horizon */

const reduced = window.matchMedia('(prefers-reduced-motion: reduce)');

/* ---------------------------------------------------------------------------
 * Renderer, scene, camera
 * ------------------------------------------------------------------------ */

let renderer;
try {
  renderer = new THREE.WebGLRenderer({
    canvas,
    antialias: window.devicePixelRatio < 2,
    powerPreference: 'high-performance',
  });
} catch (e) {
  /* No WebGL. The CSS scene underneath is already correct, so leave it. */
  hero.classList.add('is-fallback');
  throw e;
}

renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 2));

const scene = new THREE.Scene();

/*
 * The sky is a LIT gradient, not a black void.
 *
 * The reference is a bright flat orange sky with a mid-tone ground and dark
 * silhouettes on top — high contrast, and legible at a glance. A near-black
 * night keeps the mood and loses all of that, which is why the first pass read
 * as pitch dark. So this is the same contrast structure moved to violet: a
 * luminous purple sky, a mid-tone purple ground, and obstacles that read as
 * silhouettes against both.
 */
const HORIZON = 0x8a5cc4;      /* where sky meets ground — the brightest band */

function skyTexture() {
  const c = document.createElement('canvas');
  c.width = 4;
  c.height = 256;
  const ctx = c.getContext('2d');
  const g = ctx.createLinearGradient(0, 0, 0, 256);
  g.addColorStop(0.00, '#1a0f2b');
  g.addColorStop(0.34, '#3a1f5e');
  g.addColorStop(0.62, '#6b3f9e');
  g.addColorStop(0.80, '#a86fd4');
  g.addColorStop(0.94, '#c79ae0');
  g.addColorStop(1.00, '#8a5cc4');
  ctx.fillStyle = g;
  ctx.fillRect(0, 0, 4, 256);

  return new THREE.CanvasTexture(c);
}

const sky = new THREE.Mesh(
  new THREE.SphereGeometry(1100, 32, 20),
  new THREE.MeshBasicMaterial({ map: skyTexture(), side: THREE.BackSide, fog: false, depthWrite: false })
);
scene.add(sky);

/* Fog is the horizon colour, so distant ground dissolves into the sky rather
   than ending on a hard line. */
scene.fog = new THREE.Fog(HORIZON, 220, 900);

const camera = new THREE.PerspectiveCamera(62, 1, 0.6, 1400);
/* Above and behind, looking DOWN the corridor. A near-level camera sees the
   rocket end-on and it reads as a blob; from here its length is visible and the
   ground carries the sense of speed. */
/* Low and close, as in the recording. A high camera flattens the ground into a
   band and nothing appears to move; from down here the plane stretches away and
   the perspective rush does the work. */
/* Back far enough that the craft is small in frame, as it is in the recording —
   close in, it foreshortens into a chevron and stops reading as a dart. */
camera.position.set(0, 12.5, 30);
camera.lookAt(0, 8.4, -95);

/* --------------------------------------------------------------- lighting -- */

/* Moonlight: one cool directional from where the moon actually is, so the rim
   light on the rocks agrees with the sky. */
const moonLight = new THREE.DirectionalLight(0xe6d4ff, 2.2);
moonLight.position.set(-70, 60, -260);
scene.add(moonLight);

/* Generous ambient on purpose. The reference is a flat, evenly lit scene where
   shape reads from silhouette rather than from shading, and that is what keeps
   it legible at speed. */
scene.add(new THREE.AmbientLight(0x8f6fd0, 1.9));

const fill = new THREE.DirectionalLight(0xc9a8ef, 0.75);
fill.position.set(30, 26, 90);
scene.add(fill);

/* Almost horizontal, across the direction of travel. This is what makes the
   terrain's slopes read: a light from overhead lights every facet the same and
   the relief disappears. */
const graze = new THREE.DirectionalLight(0xd8b4ff, 1.1);
graze.position.set(120, 8, -20);
scene.add(graze);

const engineLight = new THREE.PointLight(0x4ef0e0, 1.1, 38, 2);
engineLight.position.set(0, 5, 6);
scene.add(engineLight);

/* ---------------------------------------------------------------------------
 * Sky: moon, halo, stars
 * ------------------------------------------------------------------------ */

/** A radial-gradient sprite, used for the moon's halo and the engine bloom. */
function glowTexture(inner, outer) {
  const c = document.createElement('canvas');
  c.width = c.height = 128;
  const g = c.getContext('2d').createRadialGradient(64, 64, 0, 64, 64, 64);
  g.addColorStop(0, inner);
  g.addColorStop(0.35, outer);
  g.addColorStop(1, 'rgba(0,0,0,0)');
  const ctx = c.getContext('2d');
  ctx.fillStyle = g;
  ctx.fillRect(0, 0, 128, 128);

  return new THREE.CanvasTexture(c);
}

/* The moon, low on the horizon and dominant — the reference's sun had that job
   and this has to inherit it. */
const moon = new THREE.Mesh(
  new THREE.SphereGeometry(58, 40, 40),
  new THREE.MeshBasicMaterial({ color: 0xf6ecff, fog: false })
);
moon.position.set(-64, 76, -620);
scene.add(moon);

/* The halo. Real bloom needs EffectComposer and the r160 post-processing passes
   are not vendored, so this is an additive sprite instead — cheaper, and at this
   scale indistinguishable. */
const halo = new THREE.Sprite(new THREE.SpriteMaterial({
  map: glowTexture('rgba(245,232,255,0.9)', 'rgba(190,140,240,0.3)'),
  blending: THREE.AdditiveBlending,
  depthWrite: false,
  fog: false,
}));
halo.position.copy(moon.position);
halo.scale.set(420, 420, 1);
scene.add(halo);

/* Stars: one Points cloud, kept sparse — the brief asks for a minimal sky. */
{
  const n = 420;
  const pos = new Float32Array(n * 3);
  for (let i = 0; i < n; i++) {
    const r = 700 + Math.random() * 200;
    const th = Math.random() * Math.PI * 2;
    const ph = Math.random() * 0.42 + 0.06;      /* upper sky only */
    pos[i * 3] = Math.cos(th) * Math.sin(ph) * r;
    pos[i * 3 + 1] = Math.cos(ph) * r * 0.9 + 40;
    pos[i * 3 + 2] = Math.sin(th) * Math.sin(ph) * r - 200;
  }
  const g = new THREE.BufferGeometry();
  g.setAttribute('position', new THREE.BufferAttribute(pos, 3));
  scene.add(new THREE.Points(g, new THREE.PointsMaterial({
    color: 0xf2e6ff, size: 2.2, sizeAttenuation: false,
    transparent: true, opacity: 0.6, fog: false,
  })));
}

/* ---------------------------------------------------------------------------
 * Ground
 * ------------------------------------------------------------------------ */

/*
 * Two tiles leapfrogging each other.
 *
 * A single infinite plane cannot show motion — there is nothing on it to move.
 * Two displaced tiles that swap places as they pass the camera give the ground
 * texture that sells speed, with no allocation at runtime.
 */
const TILE = 520;
/*
 * Mid-tone, so the dark obstacles on it read as silhouettes — the reference's
 * relationship between ground and rock, in violet.
 *
 * The mottling matters as much as the colour. A smooth plane has nothing on it
 * to watch go past, so however fast the world moves it looks still; this gives
 * the surface features the eye can track.
 */
function groundTexture() {
  const c = document.createElement('canvas');
  c.width = c.height = 256;
  const ctx = c.getContext('2d');
  ctx.fillStyle = '#4a3270';
  ctx.fillRect(0, 0, 256, 256);

  let seed = 7;
  const rnd = () => ((seed = (seed * 1103515245 + 12345) & 0x7fffffff) / 0x7fffffff);

  for (let i = 0; i < 90; i++) {
    const r = 10 + rnd() * 42;
    const g = ctx.createRadialGradient(rnd() * 256, rnd() * 256, 0, 0, 0, r);
    ctx.save();
    ctx.translate(rnd() * 256, rnd() * 256);
    const grd = ctx.createRadialGradient(0, 0, 0, 0, 0, r);
    const light = rnd() > 0.5;
    grd.addColorStop(0, light ? 'rgba(126,90,175,0.5)' : 'rgba(48,30,80,0.5)');
    grd.addColorStop(1, 'rgba(0,0,0,0)');
    ctx.fillStyle = grd;
    ctx.beginPath();
    ctx.arc(0, 0, r, 0, Math.PI * 2);
    ctx.fill();
    ctx.restore();
  }

  const t = new THREE.CanvasTexture(c);
  t.wrapS = t.wrapT = THREE.RepeatWrapping;
  t.repeat.set(5, 4);

  return t;
}

const groundMat = new THREE.MeshLambertMaterial({
  color: 0xffffff, map: groundTexture(), flatShading: true,
});
const tiles = [];

for (let i = 0; i < 2; i++) {
  const g = new THREE.PlaneGeometry(760, TILE, 40, 34);
  const p = g.attributes.position;

  for (let v = 0; v < p.count; v++) {
    const x = p.getX(v);
    const y = p.getY(v);
    /* Low, broad undulation. The corridor the rocket flies is kept flat so the
       ground never rises through the gameplay plane. */
    /* Strong enough that slopes shade differently as they pass, which is what
       makes the ground read as ground. Damped near the middle so the corridor
       the player flies stays clear, and the whole range stays well under the
       flight height either way. */
    const corridor = Math.min(1, Math.abs(x) / (LANE + 16));
    p.setZ(v, (Math.sin(x * 0.028) * 5.5 + Math.cos(y * 0.021) * 4.4
             + Math.sin((x + y) * 0.011) * 3.2) * (0.28 + corridor * 0.72));
  }
  g.computeVertexNormals();

  const m = new THREE.Mesh(g, groundMat);
  m.rotation.x = -Math.PI / 2;
  m.position.set(0, 0, -i * TILE);
  scene.add(m);
  tiles.push(m);
}

/* ---------------------------------------------------------------------------
 * Geometry the pools share. Created once, never per-obstacle.
 * ------------------------------------------------------------------------ */

/** An irregular monolith — a cone with its ring vertices jittered. */
function monolith(radius, height, seed) {
  const g = new THREE.ConeGeometry(radius, height, 6, 2);
  const p = g.attributes.position;
  let s = seed;
  const rnd = () => ((s = (s * 1103515245 + 12345) & 0x7fffffff) / 0x7fffffff);

  for (let v = 0; v < p.count; v++) {
    if (p.getY(v) < height * 0.48) {
      p.setX(v, p.getX(v) * (0.72 + rnd() * 0.7));
      p.setZ(v, p.getZ(v) * (0.72 + rnd() * 0.7));
    }
  }
  g.computeVertexNormals();

  return g;
}

const rockGeos = [monolith(7, 34, 11), monolith(9, 24, 29), monolith(5.4, 46, 71)];
/* Dark against the lit ground, exactly as in the reference — the obstacles are
   silhouettes, and silhouette is what a player reads at speed. */
const rockMat = new THREE.MeshLambertMaterial({ color: 0x1c1033, flatShading: true });

/* ---------------------------------------------------------------------------
 * Obstacle pool
 * ------------------------------------------------------------------------ */

const obstacles = [];

for (let i = 0; i < POOL; i++) {
  const mesh = new THREE.Mesh(rockGeos[i % rockGeos.length], rockMat);
  mesh.visible = false;
  scene.add(mesh);
  obstacles.push({ mesh, active: false, scored: false, x: 0 });
}

/* Scenery: the same rocks, well outside the corridor, purely for parallax. */
const scenery = [];
for (let i = 0; i < SCENERY; i++) {
  const mesh = new THREE.Mesh(rockGeos[i % rockGeos.length], rockMat);
  const side = i % 2 ? 1 : -1;
  mesh.position.set(side * (LANE + 34 + Math.random() * 210), 0, -Math.random() * TILE * 2);
  const s = 0.55 + Math.random() * 1.05;
  mesh.scale.set(s, s * (0.9 + Math.random() * 1.3), s);
  mesh.rotation.y = Math.random() * Math.PI;
  scene.add(mesh);
  scenery.push(mesh);
}

/* Distant peaks: big, far, and moving slowly, which is what gives the horizon
   depth without costing anything. */
const peaks = [];
/* Distant range: lighter than the near rock, because haze lifts everything far
   away toward the sky colour. */
const peakMat = new THREE.MeshLambertMaterial({ color: 0x3b2560, flatShading: true });
for (let i = 0; i < PEAKS; i++) {
  const mesh = new THREE.Mesh(rockGeos[i % rockGeos.length], peakMat);
  /* Sunk below the ground plane so only the upper silhouette shows, which is
     what makes them read as distant range rather than nearby spikes. */
  mesh.position.set((Math.random() - 0.5) * 1700, -16, -880 - Math.random() * 950);
  const s = 5.5 + Math.random() * 8;
  mesh.scale.set(s * 1.5, s * (1.15 + Math.random() * 0.85), s * 1.5);
  mesh.rotation.y = Math.random() * Math.PI;
  scene.add(mesh);
  peaks.push(mesh);
}

/* ---------------------------------------------------------------------------
 * The rocket
 * ------------------------------------------------------------------------ */

const rocket = new THREE.Group();
{
  /*
   * The dart, built from the recording rather than from imagination.
   *
   * It is a slim blade with a NOTCHED V TAIL — not a cone. From behind, a cone
   * shows only its circular base and reads as a blob, which is what the first
   * pass shipped. This is an extruded outline, so the notch and the swept edges
   * are visible from the chase camera.
   *
   * The engines are the other half of it: two separate nacelles held OUTBOARD
   * and angled away from the body, each with its own teal flame. In the
   * reference they are clearly detached from the hull, and that gap is most of
   * what makes the silhouette recognisable.
   */
  const outline = new THREE.Shape();
  outline.moveTo(0, 4.6);          /* nose — long, the dart is roughly 4:1 */
  outline.lineTo(0.86, -1.6);      /* right trailing edge */
  outline.lineTo(0, -0.2);         /* the V notch */
  outline.lineTo(-0.86, -1.6);     /* left trailing edge */
  outline.closePath();

  const body = new THREE.Mesh(
    new THREE.ExtrudeGeometry(outline, { depth: 0.26, bevelEnabled: false }),
    new THREE.MeshStandardMaterial({
      color: 0xffffff, roughness: 0.3, metalness: 0.25,
      emissive: 0xd8e4ff, emissiveIntensity: 0.5, flatShading: true,
    })
  );
  body.rotation.x = -Math.PI / 2;   /* lay it flat, nose toward -Z */
  body.position.y = -0.13;
  rocket.add(body);

  const nacelleMat = new THREE.MeshStandardMaterial({
    color: 0xe8edfa, roughness: 0.4, metalness: 0.36,
    emissive: 0x8a72b8, emissiveIntensity: 0.35, flatShading: true,
  });
  const flameMat = new THREE.MeshBasicMaterial({ color: 0x5df3e6 });

  for (const side of [-1, 1]) {
    const pod = new THREE.Group();

    const shell = new THREE.Mesh(new THREE.CylinderGeometry(0.3, 0.26, 1.35, 10), nacelleMat);
    shell.rotation.x = Math.PI / 2;
    pod.add(shell);

    const flame = new THREE.Mesh(new THREE.ConeGeometry(0.17, 2.3, 8), flameMat);
    flame.rotation.x = -Math.PI / 2;   /* taper pointing backwards */
    flame.position.z = 1.85;
    pod.add(flame);

    pod.position.set(side * 0.92, 0, 0.55);
    pod.rotation.y = side * -0.17;     /* splayed outward, as in the reference */
    rocket.add(pod);
  }

  const plume = new THREE.Sprite(new THREE.SpriteMaterial({
    map: glowTexture('rgba(190,252,246,0.7)', 'rgba(60,230,220,0.22)'),
    blending: THREE.AdditiveBlending, depthWrite: false, fog: false,
  }));
  plume.position.set(0, -0.1, 4.6);
  plume.scale.set(1.15, 2.6, 1);
  rocket.add(plume);
  rocket.userData.plume = plume;
}
rocket.position.set(0, 8, 0);
rocket.scale.setScalar(1.75);
scene.add(rocket);

/* The exhaust trail: a short ribbon of additive sprites that lag behind. */
const trail = [];
for (let i = 0; i < 14; i++) {
  const s = new THREE.Sprite(new THREE.SpriteMaterial({
    map: glowTexture('rgba(170,250,240,0.65)', 'rgba(60,230,220,0.2)'),
    blending: THREE.AdditiveBlending, depthWrite: false, fog: false,
    opacity: 1 - i / 14,
  }));
  s.scale.setScalar(1.5 - i * 0.1);
  scene.add(s);
  trail.push({ sprite: s, x: 0, y: 6, z: 6 });
}

/* Debris for the crash, pooled like everything else. */
const debris = [];
{
  const geo = new THREE.TetrahedronGeometry(0.9);
  const mat = new THREE.MeshBasicMaterial({ color: 0xc9a8ef });
  for (let i = 0; i < 18; i++) {
    const m = new THREE.Mesh(geo, mat);
    m.visible = false;
    scene.add(m);
    debris.push({ mesh: m, vx: 0, vy: 0, vz: 0, life: 0 });
  }
}

/* ---------------------------------------------------------------------------
 * State
 * ------------------------------------------------------------------------ */

let running = false;
let over = false;
let raf = 0;
let last = 0;

let speed = SPEED_START;
let travelled = 0;
let score = 0;
let best = 0;

let shipX = 0;
let targetX = 0;
let shipVX = 0;
let nextSpawn = 0;

const keys = { left: false, right: false };

try {
  best = Number(window.localStorage.getItem('ithrive-flight-best') || 0) || 0;
} catch (e) {
  best = 0;                     /* private windows throw on access, not on read */
}

/* ---------------------------------------------------------------------------
 * Spawning
 * ------------------------------------------------------------------------ */

function spawnRow() {
  /* One gap the rocket can fit through, placed somewhere across the corridor;
     rocks either side of it. Generating the GAP rather than the rocks is what
     guarantees every row is passable. */
  const gapCentre = (Math.random() * 2 - 1) * (LANE - 9);
  const gapHalf = 7.5 + Math.random() * 3;

  let placed = 0;
  for (const ob of obstacles) {
    if (ob.active || placed >= 3) continue;

    const side = placed === 0 ? -1 : 1;
    const span = LANE - (gapCentre + side * gapHalf) * side;
    if (span < 6) { placed++; continue; }

    const x = gapCentre + side * (gapHalf + 3 + Math.random() * Math.max(1, span - 6));
    if (Math.abs(x) > LANE + 10) { placed++; continue; }

    ob.active = true;
    ob.scored = false;
    ob.x = x;
    ob.mesh.visible = true;
    ob.mesh.position.set(x, 0, SPAWN_Z);
    const s = 1.15 + Math.random() * 1.15;
    ob.mesh.scale.set(s, s * (0.9 + Math.random() * 1.1), s);
    ob.mesh.rotation.y = Math.random() * Math.PI;
    placed++;
  }
}

function resetRun() {
  for (const ob of obstacles) { ob.active = false; ob.mesh.visible = false; }
  for (const d of debris) { d.life = 0; d.mesh.visible = false; }

  speed = SPEED_START;
  travelled = 0;
  score = 0;
  shipX = 0;
  targetX = 0;
  shipVX = 0;
  nextSpawn = 90;
  rocket.visible = true;
  rocket.position.set(0, 8, 0);
  if (scoreEl) scoreEl.textContent = '0';
}

function crash() {
  running = false;
  over = true;
  hero.classList.remove('is-playing');
  hero.classList.add('is-over');

  /* A short burst where the rocket was, then it disappears. */
  for (const d of debris) {
    d.mesh.visible = true;
    d.mesh.position.copy(rocket.position);
    d.vx = (Math.random() - 0.5) * 34;
    d.vy = Math.random() * 26;
    d.vz = (Math.random() - 0.5) * 34 + 12;
    d.life = 1;
  }
  rocket.visible = false;

  if (score > best) {
    best = score;
    try { window.localStorage.setItem('ithrive-flight-best', String(best)); } catch (e) { /* not stored */ }
  }

  if (overlayTitle) overlayTitle.textContent = 'Crashed';
  if (overlaySub) overlaySub.textContent = 'Score ' + score + (best ? ' · best ' + best : '');
  if (overlay) overlay.hidden = false;
}

/* ---------------------------------------------------------------------------
 * The loop
 * ------------------------------------------------------------------------ */

function step(dt) {
  /* --- steering ------------------------------------------------------- */
  if (keys.left) targetX -= STEER_KEY * dt;
  if (keys.right) targetX += STEER_KEY * dt;
  targetX = Math.max(-LANE + 3, Math.min(LANE - 3, targetX));

  const prevX = shipX;
  shipX += (targetX - shipX) * Math.min(1, dt * EASE);
  shipVX = (shipX - prevX) / Math.max(dt, 0.0001);

  rocket.position.x = shipX;
  rocket.rotation.z = -shipVX * BANK;
  rocket.rotation.y = -shipVX * 0.006;

  /* Engine flicker, and the light that follows it. */
  const flick = 0.9 + Math.sin(performance.now() * 0.02) * 0.1;
  rocket.userData.plume.scale.set(1.15 * flick, 2.6 * flick, 1);
  engineLight.position.set(shipX, 8, 6);

  /* The camera trails the rocket rather than tracking it exactly, which is what
     gives the movement weight. */
  camera.position.x += (shipX * 0.55 - camera.position.x) * Math.min(1, dt * 3.4);
  camera.position.y = 12.5;
  camera.lookAt(shipX * 0.3, 8.4, -95);

  /* --- trail ---------------------------------------------------------- */
  for (let i = trail.length - 1; i > 0; i--) {
    trail[i].x = trail[i - 1].x;
    trail[i].y = trail[i - 1].y;
    trail[i].z = trail[i - 1].z;
  }
  trail[0].x = shipX;
  trail[0].y = 8;
  trail[0].z = 13;
  for (let i = 0; i < trail.length; i++) {
    const t = trail[i];
    t.z += speed * dt * 0.34 * i * 0.1;
    trail[i].sprite.position.set(t.x, t.y, t.z);
  }

  if (!running) return;

  /* --- forward motion -------------------------------------------------- */
  speed = Math.min(SPEED_MAX, speed + SPEED_RAMP * dt);
  const dz = speed * dt;
  travelled += dz;

  const nextScore = Math.floor(travelled / 18);
  if (nextScore !== score) {
    score = nextScore;
    if (scoreEl) scoreEl.textContent = String(score);
  }

  /* Ground and scenery scroll toward the camera and wrap. */
  for (const m of tiles) {
    m.position.z += dz;
    if (m.position.z > TILE) m.position.z -= TILE * 2;
  }
  for (const m of scenery) {
    m.position.z += dz;
    if (m.position.z > DESPAWN_Z) {
      m.position.z -= TILE * 2;
      m.position.x = (m.position.x < 0 ? -1 : 1) * (LANE + 34 + Math.random() * 210);
    }
  }
  for (const m of peaks) {
    m.position.z += dz * 0.14;
    if (m.position.z > -420) m.position.z -= 1100;
  }

  /* --- obstacles ------------------------------------------------------- */
  nextSpawn -= dz;
  if (nextSpawn <= 0) {
    spawnRow();
    const gap = Math.max(GAP_MIN, GAP_START - travelled / 900);
    nextSpawn = gap + Math.random() * 12;
  }

  for (const ob of obstacles) {
    if (!ob.active) continue;
    ob.mesh.position.z += dz;

    if (!ob.scored && ob.mesh.position.z > rocket.position.z - HIT_Z
        && ob.mesh.position.z < rocket.position.z + HIT_Z) {
      ob.scored = true;
      if (Math.abs(ob.x - shipX) < HIT_X + ob.mesh.scale.x * 5) {
        crash();

        return;
      }
    }

    if (ob.mesh.position.z > DESPAWN_Z) {
      ob.active = false;
      ob.mesh.visible = false;
    }
  }
}

function stepDebris(dt) {
  for (const d of debris) {
    if (d.life <= 0) continue;
    d.life -= dt * 0.7;
    d.vy -= 42 * dt;
    d.mesh.position.x += d.vx * dt;
    d.mesh.position.y += d.vy * dt;
    d.mesh.position.z += d.vz * dt;
    d.mesh.rotation.x += dt * 6;
    d.mesh.rotation.y += dt * 4;
    if (d.life <= 0) d.mesh.visible = false;
  }
}

function frame(now) {
  raf = requestAnimationFrame(frame);

  /* Clamped, because a backgrounded tab returns with a multi-second delta and
     the rocket would teleport through a rock on the way back. */
  const dt = Math.min(0.05, (now - last) / 1000 || 0);
  last = now;

  step(dt);
  stepDebris(dt);
  renderer.render(scene, camera);
}

/* ---------------------------------------------------------------------------
 * Size
 * ------------------------------------------------------------------------ */

function resize() {
  const w = hero.clientWidth || window.innerWidth;
  const h = hero.clientHeight || window.innerHeight;
  renderer.setSize(w, h, false);
  camera.aspect = w / h;

  /* On a narrow screen a 62-degree horizontal view crops the moon out of the
     frame, and the brief keeps the moon in every aspect ratio. Widening the
     vertical FOV as the viewport narrows holds the composition. */
  camera.fov = w / h < 1 ? 78 : 62;
  camera.updateProjectionMatrix();
}

resize();
window.addEventListener('resize', resize);

/* ---------------------------------------------------------------------------
 * Controls
 * ------------------------------------------------------------------------ */

hero.addEventListener('pointermove', (e) => {
  const r = hero.getBoundingClientRect();
  const nx = (e.clientX - (r.left + r.width / 2)) / (r.width / 2);
  /* 1.15 so the edges of the corridor are reachable without pinning the cursor
     to the very edge of the window. */
  targetX = Math.max(-LANE + 3, Math.min(LANE - 3, nx * LANE * 1.15));
});

hero.addEventListener('touchmove', (e) => {
  const t = e.touches[0];
  if (!t) return;
  const r = hero.getBoundingClientRect();
  const nx = (t.clientX - (r.left + r.width / 2)) / (r.width / 2);
  targetX = Math.max(-LANE + 3, Math.min(LANE - 3, nx * LANE * 1.15));
  if (running) e.preventDefault();
}, { passive: false });

window.addEventListener('keydown', (e) => {
  if (e.key === 'ArrowLeft' || e.key === 'a' || e.key === 'A') keys.left = true;
  else if (e.key === 'ArrowRight' || e.key === 'd' || e.key === 'D') keys.right = true;
  else if ((e.key === 'Enter' || e.key === ' ') && over) { start(); return; }
  else return;

  /* Only swallow the arrows while a run is on, or the page cannot be scrolled
     with the keyboard. */
  if (running) e.preventDefault();
});

window.addEventListener('keyup', (e) => {
  if (e.key === 'ArrowLeft' || e.key === 'a' || e.key === 'A') keys.left = false;
  if (e.key === 'ArrowRight' || e.key === 'd' || e.key === 'D') keys.right = false;
});

/* A run continuing in a tab nobody is watching is a run lost unseen. */
document.addEventListener('visibilitychange', () => {
  if (document.hidden && running) {
    running = false;
    if (overlayTitle) overlayTitle.textContent = 'Paused';
    if (overlaySub) overlaySub.textContent = 'Score ' + score;
    if (overlay) overlay.hidden = false;
  }
});

/* ---------------------------------------------------------------------------
 * Start
 * ------------------------------------------------------------------------ */

function start() {
  resetRun();
  running = true;
  over = false;
  last = performance.now();
  hero.classList.add('is-playing');
  hero.classList.remove('is-over');
  if (overlay) overlay.hidden = true;
}

if (restartBtn) restartBtn.addEventListener('click', start);

/* The canvas is live either way — the world drifts and the moon sits there even
   before a run, so the hero is never a still picture. */
hero.classList.add('is-live');
raf = requestAnimationFrame(frame);

if (reduced.matches) {
  /* Motion sensitivity is the one case where starting unasked is wrong. The
     scene renders; the run waits to be asked for. */
  if (overlayTitle) overlayTitle.textContent = 'Fly it';
  if (overlaySub) overlaySub.textContent = 'Motion-heavy — press play when you want it';
  if (overlay) overlay.hidden = false;
} else {
  start();
}
