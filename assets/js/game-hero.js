/**
 * The Game Development hero — a real 3D flight over a desert.
 *
 *     move the mouse -> the ship goes there -> click to boost -> miss the spires
 *
 * REFERENCE. Rebuilt from the Spline recording frame by frame, because the first
 * pass got three things wrong and they were the three that mattered.
 *
 *   The palette. It was a violet night with stars. The reference is a dust-red
 *   desert under a huge low sun, with a second small sun high and right, and
 *   enough haze that everything far away dissolves into the sky. Silhouette is
 *   the whole visual idea and the night version had none.
 *
 *   The spires. They were small jittered cones — crooked lumps rather than
 *   landscape. In the reference they are tall, smooth and CONCAVE, sharpening to
 *   a point, and they tower over the ship: the biggest are thirty times its
 *   length. That is why the reference reads as flying through a place, and the
 *   first pass read as dodging pebbles.
 *
 *   The flight. It was one lane, 26 units wide, at a fixed height — you could
 *   only slide left and right along a corridor, which is why it felt like there
 *   was nowhere to go. Here the map is 300 units either side and 130 units tall,
 *   the pointer flies the ship to wherever it is, and you can go OVER a spire
 *   instead of around it. The ground is solid, so flying low is a real risk
 *   rather than a decoration.
 *
 * three r160 is already vendored for the mobile page's universe, so this imports
 * it directly rather than adding a bundle step. Nothing else is downloaded.
 *
 * FAILING SAFE. WebGL is not guaranteed: no GPU, a lost context, a browser that
 * refuses. The CSS scene stays in the markup underneath this canvas and is what
 * a visitor sees if the renderer never starts.
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

const MAP = 300;            /* half-width of the world the ship may roam */
/* The reference flies LOW — the ship hugs the dunes and the spires tower over
   it. A high ceiling turns the same scene into a map viewed from above, which
   is the one thing that would throw away the scale of the peaks. */
const FLY_MIN = 13;         /* floor of the flight envelope, above the dunes */
const FLY_MAX = 96;         /* ceiling */
const FLY_START = 26;

const TILE = 700;           /* depth of one ground tile */
const TILE_W = 1800;        /* and its width — wider than the map, so no edge */

const SPAWN_Z = -900;       /* where spires appear, ahead of the camera */
const DESPAWN_Z = 60;       /* where they are recycled, behind it */

const SPEED_START = 86;     /* world units per second */
const SPEED_MAX = 190;
const SPEED_RAMP = 2.2;     /* added per second of survival */
const BOOST = 2.8;          /* multiplier while the pointer is held */

const STEER_KEY = 150;      /* units per second on the keyboard */
const EASE = 4.6;           /* how hard the ship chases the pointer */
const BANK = 0.0075;        /* radians of roll per unit of lateral speed */

const SHIP_R = 3.0;         /* collision radius around the ship */

const POOL = 34;            /* spires alive at once — pooled, never created */
const TREES = 26;           /* dead trees for texture */
const RANGE = 9;            /* the distant silhouettes on the horizon */

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
 * The sky, sampled off the recording rather than guessed: a muted orange-red
 * overhead warming to a bright band at the horizon. The brightest thing in the
 * frame is the horizon, which is what makes every spire in front of it read as
 * a silhouette.
 */
const HORIZON = 0x7b3ec4;

function skyTexture() {
  const c = document.createElement('canvas');
  c.width = 4;
  c.height = 256;
  const ctx = c.getContext('2d');
  /* The stops are bunched into the upper half on purpose. A camera looking
     along the ground only ever sees the band between the sphere's pole and its
     equator, so a gradient spread evenly over the whole sphere shows as one
     flat wash — which is what made the first pass look washed out. */
  const g = ctx.createLinearGradient(0, 0, 0, 256);
  g.addColorStop(0.00, '#05070e');    /* --ink, straight overhead */
  g.addColorStop(0.28, '#120a26');
  g.addColorStop(0.40, '#23124a');
  g.addColorStop(0.47, '#3f1d78');
  g.addColorStop(0.495, '#9d4edd');   /* --purple, a thin band at the line */
  g.addColorStop(0.50, '#2f6bbf');    /* the brand ramp's blue, below it */
  g.addColorStop(1.00, '#2f6bbf');
  ctx.fillStyle = g;
  ctx.fillRect(0, 0, 4, 256);

  return new THREE.CanvasTexture(c);
}

const sky = new THREE.Mesh(
  new THREE.SphereGeometry(1600, 32, 20),
  new THREE.MeshBasicMaterial({ map: skyTexture(), side: THREE.BackSide, fog: false, depthWrite: false })
);
scene.add(sky);

/* Dense on purpose. In the reference the haze is doing half the work — the far
   range is barely darker than the sky, and that is what gives the distance. */
scene.fog = new THREE.Fog(0x5b2c95, 420, 2000);

const camera = new THREE.PerspectiveCamera(64, 1, 0.6, 2600);
camera.position.set(0, 26, 34);

/* --------------------------------------------------------------- lighting -- */

/* The moon is ahead of the ship, so everything between the two is backlit.
   That single decision is what produces the silhouettes. */
const moonLight = new THREE.DirectionalLight(0xd8e6ff, 2.4);
moonLight.position.set(0, 120, -900);
scene.add(moonLight);

/* Generous, and violet — the ambient is what sets the colour of everything
   that is not directly lit, which here is most of the landscape. */
scene.add(new THREE.AmbientLight(0x53279a, 1.35));

/* Almost horizontal, across the direction of travel — this is what makes the
   dune slopes read. A light from overhead lights every facet the same and the
   relief disappears. Cyan, so the ridges catch the other half of the brand
   ramp and the ground is not one flat purple. */
const graze = new THREE.DirectionalLight(0x3fd8f0, 1.15);
graze.position.set(240, 26, 60);
scene.add(graze);

const engineLight = new THREE.PointLight(0x4ef0e0, 1.2, 46, 2);
scene.add(engineLight);

/* ---------------------------------------------------------------------------
 * Sky: the two suns
 * ------------------------------------------------------------------------ */

/** A radial-gradient sprite, used for the sun haloes and the engine bloom. */
function glowTexture(inner, outer) {
  const c = document.createElement('canvas');
  c.width = c.height = 128;
  const ctx = c.getContext('2d');
  const g = ctx.createRadialGradient(64, 64, 0, 64, 64, 64);
  g.addColorStop(0, inner);
  g.addColorStop(0.35, outer);
  g.addColorStop(1, 'rgba(0,0,0,0)');
  ctx.fillStyle = g;
  ctx.fillRect(0, 0, 128, 128);

  return new THREE.CanvasTexture(c);
}

/**
 * The moon's face. A flat white disc reads as a hole cut in the sky; craters
 * are what make it a body. Drawn once into a texture rather than modelled,
 * because at this distance nothing of the relief would survive anyway.
 */
function moonTexture() {
  const c = document.createElement('canvas');
  c.width = c.height = 256;
  const ctx = c.getContext('2d');
  ctx.fillStyle = '#eaf0fa';
  ctx.fillRect(0, 0, 256, 256);

  let seed = 31;
  const rnd = () => ((seed = (seed * 1103515245 + 12345) & 0x7fffffff) / 0x7fffffff);

  for (let i = 0; i < 26; i++) {
    const r = 6 + rnd() * 24;
    const x = rnd() * 256;
    const y = rnd() * 256;
    const g = ctx.createRadialGradient(x, y, 0, x, y, r);
    g.addColorStop(0, 'rgba(176,190,222,0.55)');
    g.addColorStop(0.72, 'rgba(198,210,236,0.30)');
    g.addColorStop(1, 'rgba(255,255,255,0)');
    ctx.fillStyle = g;
    ctx.beginPath();
    ctx.arc(x, y, r, 0, Math.PI * 2);
    ctx.fill();
  }

  return new THREE.CanvasTexture(c);
}

/* The big one, sitting ON the horizon: big enough to be the thing the frame is
   built around, and low enough that the land cuts its lower third. */
const moon = new THREE.Mesh(
  new THREE.SphereGeometry(210, 40, 40),
  new THREE.MeshBasicMaterial({ map: moonTexture(), fog: false })
);
moon.position.set(-30, 130, -1480);
scene.add(moon);

const halo = new THREE.Sprite(new THREE.SpriteMaterial({
  map: glowTexture('rgba(226,236,255,0.55)', 'rgba(157,78,221,0.18)'),
  blending: THREE.AdditiveBlending, depthWrite: false, fog: false,
}));
halo.position.copy(moon.position);
/* Tight. An additive sprite this far out covers a huge angle of sky, and a
   generous one lifts the whole gradient toward lavender — which is what was
   bleaching the night out of it. */
halo.scale.set(330, 330, 1);
scene.add(halo);

/* And a second, small and high to the right, in the brand's cyan — one glance
   and the sky is not a stock night, it is this site's. */
const moon2 = new THREE.Mesh(
  new THREE.SphereGeometry(30, 24, 24),
  new THREE.MeshBasicMaterial({ color: 0x8df4ff, fog: false })
);
moon2.position.set(430, 330, -1420);
scene.add(moon2);

const halo2 = new THREE.Sprite(new THREE.SpriteMaterial({
  map: glowTexture('rgba(141,244,255,0.55)', 'rgba(0,242,254,0.18)'),
  blending: THREE.AdditiveBlending, depthWrite: false, fog: false,
}));
halo2.position.copy(moon2.position);
halo2.scale.set(165, 165, 1);
scene.add(halo2);

/* Stars, thinning toward the horizon where the haze takes over. They cost one
   draw call and they are most of what makes it read as night. */
{
  const n = 520;
  const pos = new Float32Array(n * 3);
  for (let i = 0; i < n; i++) {
    const r = 1300 + Math.random() * 250;
    const th = Math.random() * Math.PI * 2;
    const ph = Math.random() * 0.46 + 0.05;      /* upper sky only */
    pos[i * 3] = Math.cos(th) * Math.sin(ph) * r;
    pos[i * 3 + 1] = Math.cos(ph) * r * 0.92 + 60;
    pos[i * 3 + 2] = Math.sin(th) * Math.sin(ph) * r - 300;
  }
  const g = new THREE.BufferGeometry();
  g.setAttribute('position', new THREE.BufferAttribute(pos, 3));
  scene.add(new THREE.Points(g, new THREE.PointsMaterial({
    color: 0xe8f2ff, size: 2.4, sizeAttenuation: false,
    transparent: true, opacity: 0.7, fog: false,
  })));
}

/* ---------------------------------------------------------------------------
 * Ground
 * ------------------------------------------------------------------------ */

/*
 * The dunes are an analytic function rather than baked noise, for one reason:
 * the ship can now fly low enough to hit the ground, so the game has to be able
 * to ASK how high the sand is under a given point. Displacing the mesh and
 * testing against the same function keeps the two honest.
 *
 * Every z term is an integer multiple of 2*PI/TILE, so the surface meets itself
 * exactly when a tile wraps and there is no seam to see.
 */
const KZ = (Math.PI * 2) / TILE;

function dune(x, z) {
  return Math.sin(x * 0.0115) * 6.5
       + Math.cos(z * KZ * 3) * 5.0
       + Math.sin(x * 0.004 + z * KZ * 2) * 3.8
       + Math.cos(z * KZ * 5 - x * 0.006) * 2.4;
}

/* Mottling matters as much as colour: a smooth plane has nothing on it to watch
   go past, so however fast the world moves it looks still. */
function groundTexture() {
  const c = document.createElement('canvas');
  c.width = c.height = 256;
  const ctx = c.getContext('2d');
  ctx.fillStyle = '#2b1550';
  ctx.fillRect(0, 0, 256, 256);

  let seed = 7;
  const rnd = () => ((seed = (seed * 1103515245 + 12345) & 0x7fffffff) / 0x7fffffff);

  for (let i = 0; i < 90; i++) {
    const r = 12 + rnd() * 46;
    ctx.save();
    ctx.translate(rnd() * 256, rnd() * 256);
    const grd = ctx.createRadialGradient(0, 0, 0, 0, 0, r);
    const light = rnd() > 0.5;
    grd.addColorStop(0, light ? 'rgba(104,58,166,0.45)' : 'rgba(26,14,48,0.45)');
    grd.addColorStop(1, 'rgba(0,0,0,0)');
    ctx.fillStyle = grd;
    ctx.beginPath();
    ctx.arc(0, 0, r, 0, Math.PI * 2);
    ctx.fill();
    ctx.restore();
  }

  const t = new THREE.CanvasTexture(c);
  t.wrapS = t.wrapT = THREE.RepeatWrapping;
  t.repeat.set(9, 5);

  return t;
}

const groundMat = new THREE.MeshLambertMaterial({
  color: 0xffffff, map: groundTexture(), flatShading: true,
});
const tiles = [];

for (let i = 0; i < 2; i++) {
  const g = new THREE.PlaneGeometry(TILE_W, TILE, 72, 54);
  const p = g.attributes.position;

  /* No corridor damping any more. The whole map undulates, because the whole
     map is now flyable — flattening a lane through the middle was part of what
     made the old scene feel like a tunnel. */
  for (let v = 0; v < p.count; v++) {
    p.setZ(v, dune(p.getX(v), p.getY(v)));
  }
  g.computeVertexNormals();

  const m = new THREE.Mesh(g, groundMat);
  m.rotation.x = -Math.PI / 2;
  m.position.set(0, 0, -i * TILE);
  scene.add(m);
  tiles.push(m);
}

/** How high the sand is under a world point — the same function the mesh uses. */
function groundAt(x, zWorld) {
  for (const m of tiles) {
    /* The plane is rotated, so local +Y runs into the screen as world -Z. */
    const ly = m.position.z - zWorld;
    if (ly >= -TILE / 2 && ly <= TILE / 2) return dune(x, ly);
  }

  return 0;
}

/* ---------------------------------------------------------------------------
 * Geometry the pools share. Created once, never per-obstacle.
 * ------------------------------------------------------------------------ */

/**
 * A peak.
 *
 * The profile is concave — wide at the ground, pulling in fast, then running
 * almost straight to a sharp point. That alone is the difference between rock
 * and a traffic cone.
 *
 * But a lathe of that profile is perfectly round, and perfectly round is the
 * other half of why the first version looked like a prop. Real rock has ridges
 * running down it and gullies between them. So each column of the lathe gets
 * its own radius multiplier, held down the whole height: that turns the surface
 * into vertical ribs and clefts, which flat shading then breaks into facets.
 * A little per-vertex noise on top keeps any two ribs from matching, and the
 * strength fades out toward the point, where real peaks are simplest.
 */
function peak(radius, height, sides, seed) {
  let s = seed;
  const rnd = () => ((s = (s * 1103515245 + 12345) & 0x7fffffff) / 0x7fffffff);

  /* The profile itself wanders, so the OUTLINE gains shoulders and waists.
     A clean power curve draws a clean triangle, and a clean triangle is what
     read as a prop however the surface was shaded. Smoothed once, so it is a
     mountain and not a fir tree. */
  const N = 14;
  const wob = new Array(N + 1).fill(0).map(() => 0.84 + rnd() * 0.34);
  for (let i = 1; i < N; i++) wob[i] = (wob[i - 1] + wob[i] + wob[i + 1]) / 3;
  wob[N] = 1;

  const pts = [];
  for (let i = 0; i <= N; i++) {
    const t = i / N;
    pts.push(new THREE.Vector2(radius * Math.pow(1 - t, 1.4) * wob[i] + 0.02, height * t));
  }

  const g = new THREE.LatheGeometry(pts, sides);
  const p = g.attributes.position;

  /* One multiplier per column, reused all the way up — this is the ridge. */
  const ribs = new Array(sides + 1).fill(0).map(() => 0.74 + rnd() * 0.52);

  for (let v = 0; v < p.count; v++) {
    const x = p.getX(v);
    const y = p.getY(v);
    const z = p.getZ(v);
    const r = Math.hypot(x, z);
    if (r < 0.001) continue;

    const a = Math.atan2(z, x);
    const col = ribs[Math.round(((a + Math.PI) / (Math.PI * 2)) * sides) % sides];
    const t = Math.max(0, Math.min(1, y / height));

    /* Strongest at the base, gone at the tip. */
    const k = (col * (1 - t) + t) + (rnd() - 0.5) * 0.13 * (1 - t);
    p.setX(v, x * k);
    p.setZ(v, z * k);
    p.setY(v, y + (rnd() - 0.5) * height * 0.025);
  }
  g.computeVertexNormals();

  return g;
}

/* Four builds, all of them tall and none of them the same shape. The
   proportion is the reference's: a base about a fifth of the height. */
const SPIRE_H = [190, 250, 130, 215];
const SPIRE_R = [38, 46, 30, 34];
const spireGeos = SPIRE_H.map((h, i) => peak(SPIRE_R[i], h, 11 + i * 2, 17 + i * 131));

/* Dark and desaturated, so they sit against the lit horizon as shapes. The fog
   lifts the far ones toward the sky on its own. */
/* Dark, but not black. A pure silhouette throws away every facet the ridges
   were built for — the shapes have to catch enough light to be read as rock
   rather than as cut-out triangles. */
const spireMat = new THREE.MeshLambertMaterial({ color: 0x2e1758, flatShading: true });
const rangeMat = new THREE.MeshLambertMaterial({ color: 0x412470, flatShading: true });

/** A bare tree: a trunk and a few forked branches, black against the sand. */
function deadTree(seed) {
  let s = seed;
  const rnd = () => ((s = (s * 1103515245 + 12345) & 0x7fffffff) / 0x7fffffff);

  const g = new THREE.Group();
  const mat = new THREE.MeshLambertMaterial({ color: 0x140a26, flatShading: true });

  const trunk = new THREE.Mesh(new THREE.CylinderGeometry(0.22, 0.5, 7, 5), mat);
  trunk.position.y = 3.5;
  g.add(trunk);

  for (let i = 0; i < 4; i++) {
    const len = 3.4 + rnd() * 2.6;
    const b = new THREE.Mesh(new THREE.CylinderGeometry(0.1, 0.2, len, 4), mat);
    const a = (i / 4) * Math.PI * 2 + rnd();
    b.position.set(Math.cos(a) * len * 0.3, 6.4 + len * 0.36, Math.sin(a) * len * 0.3);
    b.rotation.z = Math.cos(a) * -0.75;
    b.rotation.x = Math.sin(a) * 0.75;
    g.add(b);
  }

  return g;
}

/* ---------------------------------------------------------------------------
 * Ground lettering
 *
 * The recording writes on the desert — the score lies on the sand behind the
 * ship, CLICK TO BOOST is painted across a slope ahead, CRUSHED lands where you
 * died. It is the signature of the thing, and it is only a canvas on a plane.
 * ------------------------------------------------------------------------ */

function lettering(width, height, px) {
  const c = document.createElement('canvas');
  c.width = width;
  c.height = height;
  const ctx = c.getContext('2d');
  const tex = new THREE.CanvasTexture(c);

  const mesh = new THREE.Mesh(
    new THREE.PlaneGeometry(1, height / width),
    new THREE.MeshBasicMaterial({ map: tex, transparent: true, depthWrite: false, fog: true })
  );
  mesh.rotation.x = -Math.PI / 2;      /* lay it on the sand */

  function write(text) {
    ctx.clearRect(0, 0, width, height);
    ctx.font = `700 ${px}px "Segoe UI", system-ui, sans-serif`;
    ctx.textAlign = 'center';
    ctx.textBaseline = 'middle';
    ctx.shadowColor = 'rgba(255,238,210,0.95)';
    ctx.shadowBlur = px * 0.5;
    ctx.fillStyle = '#fff6ea';
    ctx.fillText(text, width / 2, height / 2);
    ctx.fillText(text, width / 2, height / 2);
    tex.needsUpdate = true;
  }

  return { mesh, write };
}

/* The score, trailing the ship on the sand. */
const scoreText = lettering(512, 256, 150);
scoreText.mesh.scale.setScalar(52);
scene.add(scoreText.mesh);

/* The hint, painted across the desert ahead and recycled as it passes. */
const hintText = lettering(1024, 256, 140);
hintText.write('CLICK TO BOOST');
hintText.mesh.scale.setScalar(300);
hintText.mesh.position.set(90, 3, -1200);
hintText.mesh.rotation.z = 0.42;
scene.add(hintText.mesh);

/* And the epitaph. */
const crushText = lettering(1024, 256, 150);
crushText.write('CRUSHED');
crushText.mesh.scale.setScalar(260);
crushText.mesh.visible = false;
scene.add(crushText.mesh);

/* ---------------------------------------------------------------------------
 * Spires: the obstacle pool, the near field and the far range
 * ------------------------------------------------------------------------ */

const obstacles = [];

for (let i = 0; i < POOL; i++) {
  const k = i % spireGeos.length;
  const mesh = new THREE.Mesh(spireGeos[k], spireMat);
  mesh.visible = false;
  scene.add(mesh);
  obstacles.push({ mesh, active: false, kind: k, r: 0, h: 0 });
}

/** Put one spire somewhere ahead. `near` biases it toward the ship's own lane. */
function placeSpire(ob, z, nearX) {
  const k = Math.floor(Math.random() * spireGeos.length);
  ob.kind = k;
  ob.mesh.geometry = spireGeos[k];

  /* Big, and varied. The smallest here still stands ten ship-lengths tall. */
  const s = 0.55 + Math.random() * 1.15;
  const tall = 0.8 + Math.random() * 0.9;
  ob.mesh.scale.set(s, s * tall, s);
  ob.r = SPIRE_R[k] * s;
  ob.h = SPIRE_H[k] * s * tall;

  const x = nearX === null
    ? (Math.random() * 2 - 1) * MAP
    : nearX + (Math.random() * 2 - 1) * 150;

  ob.mesh.position.set(Math.max(-MAP - 60, Math.min(MAP + 60, x)), 0, z);
  ob.mesh.rotation.y = Math.random() * Math.PI;
  /* A few degrees off vertical. Nothing in a landscape stands perfectly
     upright, and the lean is what stops a field of them reading as a set. */
  ob.mesh.rotation.z = (Math.random() - 0.5) * 0.13;
  ob.mesh.rotation.x = (Math.random() - 0.5) * 0.09;
  ob.mesh.visible = true;
  ob.active = true;
}

/* Trees, scattered wide and recycled like everything else. */
const trees = [];
{
  const builds = [deadTree(3), deadTree(17), deadTree(91)];
  for (let i = 0; i < TREES; i++) {
    const t = builds[i % 3].clone();
    t.position.set((Math.random() * 2 - 1) * (MAP + 260), 0, -Math.random() * TILE * 2);
    const s = 0.9 + Math.random() * 1.9;
    t.scale.setScalar(s);
    t.rotation.y = Math.random() * Math.PI;
    scene.add(t);
    trees.push(t);
  }
}

/* The far range: big, slow, and hazed almost to the sky colour. It is what puts
   a horizon in the picture rather than an empty band. */
const range = [];
for (let i = 0; i < RANGE; i++) {
  const mesh = new THREE.Mesh(spireGeos[i % spireGeos.length], rangeMat);
  mesh.position.set((Math.random() - 0.5) * 3600, -30, -1150 - Math.random() * 850);
  const s = 1.5 + Math.random() * 1.9;
  mesh.scale.set(s, s * (0.9 + Math.random() * 0.8), s);
  mesh.rotation.y = Math.random() * Math.PI;
  scene.add(mesh);
  range.push(mesh);
}

/* ---------------------------------------------------------------------------
 * The ship
 * ------------------------------------------------------------------------ */

const rocket = new THREE.Group();
{
  /*
   * A slim blade with a notched V tail, and two engine nacelles held outboard
   * and splayed away from the hull. That gap between hull and engines is most
   * of what makes the silhouette recognisable in the reference.
   */
  const outline = new THREE.Shape();
  outline.moveTo(0, 4.6);          /* nose — roughly 4:1 */
  outline.lineTo(0.86, -1.6);
  outline.lineTo(0, -0.2);         /* the V notch */
  outline.lineTo(-0.86, -1.6);
  outline.closePath();

  const body = new THREE.Mesh(
    new THREE.ExtrudeGeometry(outline, { depth: 0.26, bevelEnabled: false }),
    new THREE.MeshStandardMaterial({
      color: 0xffffff, roughness: 0.3, metalness: 0.2,
      emissive: 0xffe6d2, emissiveIntensity: 0.45, flatShading: true,
    })
  );
  body.rotation.x = -Math.PI / 2;   /* lay it flat, nose toward -Z */
  body.position.y = -0.13;
  rocket.add(body);

  const nacelleMat = new THREE.MeshStandardMaterial({
    color: 0xf2f6ff, roughness: 0.4, metalness: 0.3,
    emissive: 0xbfa08c, emissiveIntensity: 0.3, flatShading: true,
  });
  const flameMat = new THREE.MeshBasicMaterial({ color: 0x5df3e6 });
  const flames = [];

  for (const side of [-1, 1]) {
    const pod = new THREE.Group();

    const shell = new THREE.Mesh(new THREE.CylinderGeometry(0.3, 0.26, 1.35, 10), nacelleMat);
    shell.rotation.x = Math.PI / 2;
    pod.add(shell);

    const flame = new THREE.Mesh(new THREE.ConeGeometry(0.17, 2.3, 8), flameMat);
    flame.rotation.x = -Math.PI / 2;   /* taper pointing backwards */
    flame.position.z = 1.85;
    pod.add(flame);
    flames.push(flame);

    pod.position.set(side * 0.92, 0, 0.55);
    pod.rotation.y = side * -0.17;
    rocket.add(pod);
  }
  rocket.userData.flames = flames;

  const plume = new THREE.Sprite(new THREE.SpriteMaterial({
    map: glowTexture('rgba(190,252,246,0.7)', 'rgba(60,230,220,0.22)'),
    blending: THREE.AdditiveBlending, depthWrite: false, fog: false,
  }));
  /* Small. An additive sprite scaled to the hull swallows the dart behind a
     white ball, and the silhouette is the whole point of the craft. */
  plume.position.set(0, -0.1, 3.4);
  plume.scale.set(0.8, 1.7, 1);
  rocket.add(plume);
  rocket.userData.plume = plume;
}
rocket.scale.setScalar(2.4);
scene.add(rocket);

/* The exhaust trail: a short ribbon of additive sprites that lag behind. */
const trail = [];
for (let i = 0; i < 16; i++) {
  const s = new THREE.Sprite(new THREE.SpriteMaterial({
    map: glowTexture('rgba(170,250,240,0.6)', 'rgba(60,230,220,0.18)'),
    blending: THREE.AdditiveBlending, depthWrite: false, fog: false,
    opacity: 1 - i / 16,
  }));
  s.scale.setScalar(1.6 - i * 0.09);
  scene.add(s);
  trail.push({ sprite: s, x: 0, y: 0, z: 0 });
}

/* Debris for the crash, pooled like everything else. */
const debris = [];
{
  const geo = new THREE.TetrahedronGeometry(0.9);
  const mat = new THREE.MeshBasicMaterial({ color: 0xbfa6ff });
  for (let i = 0; i < 20; i++) {
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
let boosting = false;

let shipX = 0;
let shipY = FLY_START;
let targetX = 0;
let targetY = FLY_START;
let shipVX = 0;
let shipVY = 0;
let roll = 0;
let nextSpawn = 0;

const keys = { left: false, right: false, up: false, down: false };

try {
  best = Number(window.localStorage.getItem('ithrive-flight-best') || 0) || 0;
} catch (e) {
  best = 0;                     /* private windows throw on access, not on read */
}

/* ---------------------------------------------------------------------------
 * Run control
 * ------------------------------------------------------------------------ */

function resetRun() {
  for (const ob of obstacles) { ob.active = false; ob.mesh.visible = false; }
  for (const d of debris) { d.life = 0; d.mesh.visible = false; }

  /* Seed the field so the first seconds are not an empty plain. */
  let z = -320;
  for (const ob of obstacles) {
    if (z < SPAWN_Z) break;
    placeSpire(ob, z, null);
    z -= 120 + Math.random() * 170;
  }

  speed = SPEED_START;
  travelled = 0;
  score = 0;
  shipX = 0;
  shipY = FLY_START;
  targetX = 0;
  targetY = FLY_START;
  shipVX = 0;
  shipVY = 0;
  roll = 0;
  nextSpawn = 120;
  rocket.visible = true;
  crushText.mesh.visible = false;
  scoreText.mesh.visible = true;
  if (scoreEl) scoreEl.textContent = '0';
  scoreText.write('0');
}

function crash() {
  running = false;
  over = true;
  boosting = false;
  hero.classList.remove('is-playing');
  hero.classList.add('is-over');

  for (const d of debris) {
    d.mesh.visible = true;
    d.mesh.position.copy(rocket.position);
    d.vx = (Math.random() - 0.5) * 38;
    d.vy = Math.random() * 28;
    d.vz = (Math.random() - 0.5) * 38 + 14;
    d.life = 1;
  }
  rocket.visible = false;

  /* Where you died, written on the sand — as in the recording. */
  crushText.mesh.position.set(shipX, groundAt(shipX, -40) + 2.5, -40);
  crushText.mesh.rotation.z = 0.3;
  crushText.mesh.visible = true;
  scoreText.mesh.visible = false;

  if (score > best) {
    best = score;
    try { window.localStorage.setItem('ithrive-flight-best', String(best)); } catch (e) { /* not stored */ }
  }

  if (overlayTitle) overlayTitle.textContent = 'Crushed';
  if (overlaySub) overlaySub.textContent = 'Score ' + score + (best ? ' · best ' + best : '');
  if (overlay) overlay.hidden = false;
}

/* ---------------------------------------------------------------------------
 * The loop
 * ------------------------------------------------------------------------ */

function step(dt) {
  /* --- steering, in both axes ------------------------------------------ */
  if (keys.left) targetX -= STEER_KEY * dt;
  if (keys.right) targetX += STEER_KEY * dt;
  if (keys.up) targetY += STEER_KEY * 0.6 * dt;
  if (keys.down) targetY -= STEER_KEY * 0.6 * dt;

  targetX = Math.max(-MAP, Math.min(MAP, targetX));
  targetY = Math.max(FLY_MIN, Math.min(FLY_MAX, targetY));

  const prevX = shipX;
  const prevY = shipY;
  /* Frame-rate independent: the ship covers the same fraction of the distance
     per second of real time whatever the display is doing. */
  const k = 1 - Math.exp(-EASE * dt);
  shipX += (targetX - shipX) * k;
  shipY += (targetY - shipY) * k;
  shipVX = (shipX - prevX) / Math.max(dt, 0.0001);
  shipVY = (shipY - prevY) / Math.max(dt, 0.0001);

  rocket.position.set(shipX, shipY, 0);
  rocket.rotation.z = -shipVX * BANK;
  rocket.rotation.y = -shipVX * 0.0012;
  rocket.rotation.x = shipVY * 0.0016;

  /* Engine flicker, longer under boost, and the light that follows it. */
  const flick = 0.9 + Math.sin(performance.now() * 0.02) * 0.1;
  const push = boosting ? 2.1 : 1;
  rocket.userData.plume.scale.set(0.8 * flick * push, 1.7 * flick * push, 1);
  for (const f of rocket.userData.flames) f.scale.set(1, push, 1);
  engineLight.position.set(shipX, shipY, 6);
  engineLight.intensity = boosting ? 2.4 : 1.2;

  /* --- the camera ------------------------------------------------------ */
  /* It trails rather than tracks, and it ROLLS. The horizon tipping as you
     turn is most of what makes the reference feel like flight. */
  roll += (-shipVX * 0.0016 - roll) * Math.min(1, dt * 3.2);
  camera.position.x += (shipX * 0.82 - camera.position.x) * Math.min(1, dt * 3.6);
  camera.position.y += ((shipY + 14) - camera.position.y) * Math.min(1, dt * 3.0);
  camera.position.z = 34;
  camera.up.set(Math.sin(roll), Math.cos(roll), 0);
  /* Above the ship, aimed at the horizon rather than down at it. Two things
     fall out of that and both are the reference's: you see the dart's TOP, so
     it reads as a dart instead of a bar seen edge-on, and it sits low in frame
     with the horizon across the upper third, which is what makes the spires
     look as tall as they are. */
  camera.lookAt(shipX * 0.9, shipY + 8, -150);

  /* The field of view opening up is most of what sells the speed — the world
     widens and rushes past the edges. Without it a faster number just makes
     the ground scroll quicker and the ship feels no different. */
  const wantFov = boosting ? baseFov + 24 : baseFov;
  camera.fov += (wantFov - camera.fov) * Math.min(1, dt * 4.5);
  camera.updateProjectionMatrix();

  /* --- trail ----------------------------------------------------------- */
  for (let i = trail.length - 1; i > 0; i--) {
    trail[i].x = trail[i - 1].x;
    trail[i].y = trail[i - 1].y;
    trail[i].z = trail[i - 1].z;
  }
  trail[0].x = shipX;
  trail[0].y = shipY;
  trail[0].z = 13;
  for (let i = 0; i < trail.length; i++) {
    const t = trail[i];
    t.z += speed * dt * 0.34 * i * 0.1;
    trail[i].sprite.position.set(t.x, t.y, t.z);
  }

  /* The score lies on the sand behind the ship, following it. */
  scoreText.mesh.position.set(shipX, groundAt(shipX, 24) + 1.6, 24);

  if (!running) return;

  /* --- forward motion --------------------------------------------------- */
  speed = Math.min(SPEED_MAX, speed + SPEED_RAMP * dt);
  const dz = speed * (boosting ? BOOST : 1) * dt;
  travelled += dz;

  const nextScore = Math.floor(travelled / 18);
  if (nextScore !== score) {
    score = nextScore;
    if (scoreEl) scoreEl.textContent = String(score);
    scoreText.write(String(score));
  }

  /* Ground, trees and range scroll toward the camera and wrap. */
  for (const m of tiles) {
    m.position.z += dz;
    if (m.position.z > TILE) m.position.z -= TILE * 2;
  }
  for (const t of trees) {
    t.position.z += dz;
    if (t.position.z > DESPAWN_Z) {
      t.position.z -= TILE * 2;
      t.position.x = (Math.random() * 2 - 1) * (MAP + 260);
    }
    t.position.y = groundAt(t.position.x, t.position.z) - 1;
  }
  for (const m of range) {
    m.position.z += dz * 0.1;
    if (m.position.z > -900) m.position.z -= 1800;
  }

  hintText.mesh.position.z += dz;
  if (hintText.mesh.position.z > DESPAWN_Z) {
    hintText.mesh.position.z -= 2600 + Math.random() * 1400;
    hintText.mesh.position.x = (Math.random() * 2 - 1) * 200;
    hintText.mesh.rotation.z = (Math.random() - 0.5) * 0.9;
  }
  hintText.mesh.position.y = groundAt(hintText.mesh.position.x, hintText.mesh.position.z) + 2;

  /* --- spires ----------------------------------------------------------- */
  nextSpawn -= dz;
  if (nextSpawn <= 0) {
    const free = obstacles.find((o) => !o.active);
    /* Biased toward wherever the ship is, so the map stays alive around the
       player rather than filling the far edges nobody visits. */
    if (free) placeSpire(free, SPAWN_Z, Math.random() < 0.7 ? shipX : null);
    nextSpawn = 95 + Math.random() * 150;
  }

  for (const ob of obstacles) {
    if (!ob.active) continue;
    ob.mesh.position.z += dz;
    ob.mesh.position.y = groundAt(ob.mesh.position.x, ob.mesh.position.z) - 3;

    /* Collision in three dimensions, because over the top is now a real
       option: the spire's radius shrinks with height, so clearing it by
       flying high is exactly as forgiving as it looks. */
    const dx = shipX - ob.mesh.position.x;
    const dzz = -ob.mesh.position.z;
    if (Math.abs(dzz) < ob.r + 8 && Math.abs(dx) < ob.r + 8) {
      const h = shipY - ob.mesh.position.y;
      if (h < ob.h) {
        const rAtH = ob.r * Math.pow(1 - Math.max(0, Math.min(1, h / ob.h)), 1.4);
        if (Math.hypot(dx, dzz) < rAtH + SHIP_R) {
          crash();

          return;
        }
      }
    }

    if (ob.mesh.position.z > DESPAWN_Z) {
      ob.active = false;
      ob.mesh.visible = false;
    }
  }

  /* The sand is solid. Flying low is the fast line and it is also how you die. */
  if (shipY < groundAt(shipX, 0) + FLY_MIN * 0.42) {
    crash();
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
     the ship would teleport through a spire on the way back. */
  const dt = Math.min(0.05, (now - last) / 1000 || 0);
  last = now;

  step(dt);
  stepDebris(dt);
  renderer.render(scene, camera);
}

/* ---------------------------------------------------------------------------
 * Size
 * ------------------------------------------------------------------------ */

let baseFov = 64;

function resize() {
  /* Guarded: the hero can measure zero while the page is still laying out, and
     a 0x0 drawing buffer renders nothing at all for the rest of the session. */
  const w = hero.clientWidth || window.innerWidth || 1280;
  const h = hero.clientHeight || window.innerHeight || 720;
  renderer.setSize(w, h, false);
  camera.aspect = w / h;

  /* On a narrow screen a 64-degree horizontal view crops the sun out of the
     frame, and the composition keeps the sun in every aspect ratio. */
  baseFov = w / h < 1 ? 80 : 64;
  if (!boosting) camera.fov = baseFov;
  camera.updateProjectionMatrix();
}

resize();
window.addEventListener('resize', resize);
/* clientWidth is often 0 on the first pass; this catches the real size. */
if (window.ResizeObserver) new ResizeObserver(resize).observe(hero);

/* ---------------------------------------------------------------------------
 * Controls
 *
 * Bound to the window rather than to the hero: the HUD, the overlay and the
 * CSS sky all sit over the canvas, and any one of them swallowing the pointer
 * is enough to make the ship look like it cannot move.
 * ------------------------------------------------------------------------ */

function aim(clientX, clientY) {
  const r = hero.getBoundingClientRect();
  if (clientY < r.top || clientY > r.bottom) return;

  const nx = (clientX - (r.left + r.width / 2)) / (r.width / 2);
  const ny = (clientY - r.top) / r.height;          /* 0 at the top */

  /* 1.1 so the edges of the map are reachable without pinning the cursor to
     the very edge of the window. */
  targetX = Math.max(-MAP, Math.min(MAP, nx * MAP * 1.1));
  /* Screen down is world down, and the whole envelope is reachable. */
  targetY = FLY_MAX - Math.max(0, Math.min(1, (ny - 0.06) / 0.86)) * (FLY_MAX - FLY_MIN);
}

window.addEventListener('pointermove', (e) => aim(e.clientX, e.clientY));

hero.addEventListener('touchmove', (e) => {
  const t = e.touches[0];
  if (!t) return;
  aim(t.clientX, t.clientY);
  if (running) e.preventDefault();
}, { passive: false });

/* Click to boost — held, not toggled, exactly as the recording prompts. */
hero.addEventListener('pointerdown', (e) => {
  if (e.target.closest('button, a')) return;
  boosting = true;
});
window.addEventListener('pointerup', () => { boosting = false; });
window.addEventListener('pointercancel', () => { boosting = false; });

window.addEventListener('keydown', (e) => {
  if (e.key === 'ArrowLeft' || e.key === 'a' || e.key === 'A') keys.left = true;
  else if (e.key === 'ArrowRight' || e.key === 'd' || e.key === 'D') keys.right = true;
  else if (e.key === 'ArrowUp' || e.key === 'w' || e.key === 'W') keys.up = true;
  else if (e.key === 'ArrowDown' || e.key === 's' || e.key === 'S') keys.down = true;
  else if (e.key === 'Shift') boosting = true;
  else if ((e.key === 'Enter' || e.key === ' ') && over) { start(); return; }
  else return;

  /* Only swallow the keys while a run is on, or the page cannot be scrolled
     with the keyboard. */
  if (running) e.preventDefault();
});

window.addEventListener('keyup', (e) => {
  if (e.key === 'ArrowLeft' || e.key === 'a' || e.key === 'A') keys.left = false;
  if (e.key === 'ArrowRight' || e.key === 'd' || e.key === 'D') keys.right = false;
  if (e.key === 'ArrowUp' || e.key === 'w' || e.key === 'W') keys.up = false;
  if (e.key === 'ArrowDown' || e.key === 's' || e.key === 'S') keys.down = false;
  if (e.key === 'Shift') boosting = false;
});

/* A run continuing in a tab nobody is watching is a run lost unseen. */
document.addEventListener('visibilitychange', () => {
  if (document.hidden && running) {
    running = false;
    boosting = false;
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

/* The canvas is live either way — the world drifts and the suns sit there even
   before a run, so the hero is never a still picture. */
resetRun();
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
