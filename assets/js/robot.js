import * as THREE from 'three';

/* ------------------------------------------------------------------ *
 *  Interactive 3D robot mascot
 *
 *  Tracking : head yaws/pitches toward the pointer, eyes lead the head, the
 *             arms reach after it, and the torso counter-rotates so the turn
 *             reads as a twist.
 *  Idle     : after 2.5s of stillness he recentres and cycles through eight
 *             behaviours (blink, look around, wave, tilt, sleep, alert,
 *             double take, grumpy).
 *  Always   : hover bob, thruster pulse, autonomous blink.
 *
 *  The whole scene is built at module load, so this file is imported only once
 *  a mount is on the page — see includes/footer.php.
 * ------------------------------------------------------------------ */

const CYAN = 0x22c7e8;
const DEG = Math.PI / 180;

const canvas = document.querySelector('[data-robot-canvas]');
const readout = document.querySelector('[data-robot-readout]');

/* The chest badge is resolved by PHP so it works from any directory depth. */
const BADGE_URL = canvas.dataset.robotBadge || 'assets/img/robot-badge.png';

const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
const isTouch = window.matchMedia('(hover: none)').matches;

/* ------------------------------------------------------------------ *
 *  Renderer / scene / camera
 * ------------------------------------------------------------------ */

const renderer = new THREE.WebGLRenderer({ canvas, antialias: true, alpha: true });
renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
renderer.outputColorSpace = THREE.SRGBColorSpace;
renderer.toneMapping = THREE.ACESFilmicToneMapping;
renderer.toneMappingExposure = 1.05;

const scene = new THREE.Scene();
const camera = new THREE.PerspectiveCamera(32, 1, 0.1, 100);
/* Camera y matches its target so the view axis stays horizontal — that lets
   resize() change only z without needing to re-aim. The distance leaves room
   above the helmet for the bob and the `alert` hop to play without clipping. */
camera.position.set(0, -0.12, 9);
camera.lookAt(0, -0.12, 0);

/* Studio environment, generated in-canvas so there are no external assets.
   Without this the chrome and clearcoat have nothing to reflect. */
function studioEnvironment() {
  const c = document.createElement('canvas');
  c.width = 512; c.height = 256;
  const g = c.getContext('2d');

  g.fillStyle = '#0b0d10';
  g.fillRect(0, 0, 512, 256);

  const blob = (x, y, r, color, alpha) => {
    const grad = g.createRadialGradient(x, y, 0, x, y, r);
    grad.addColorStop(0, color);
    grad.addColorStop(1, 'rgba(0,0,0,0)');
    g.globalAlpha = alpha;
    g.fillStyle = grad;
    g.fillRect(0, 0, 512, 256);
    g.globalAlpha = 1;
  };

  /* Deliberately featureless: a flat top-to-bottom gradient with no bright
     spots anywhere. Any localised bright area in here gets mirrored back as a
     white dot on the shell, which is exactly what we do not want. */
  const sky = g.createLinearGradient(0, 0, 0, 256);
  sky.addColorStop(0.00, '#8f9aa8');
  sky.addColorStop(0.50, '#4a5158');
  sky.addColorStop(1.00, '#20242a');
  g.fillStyle = sky;
  g.fillRect(0, 0, 512, 256);

  const tex = new THREE.CanvasTexture(c);
  tex.mapping = THREE.EquirectangularReflectionMapping;
  tex.colorSpace = THREE.SRGBColorSpace;

  const pmrem = new THREE.PMREMGenerator(renderer);
  const env = pmrem.fromEquirectangular(tex).texture;
  pmrem.dispose();
  tex.dispose();
  return env;
}
scene.environment = studioEnvironment();

/* A directional light is an infinitely small source, so it burns a pinpoint
   specular hotspot into anything glossy — that is the "camera flash" look.
   These are kept low and the lost brightness is made back on the hemisphere
   term, which is broad and produces no hotspot of its own. */
scene.add(new THREE.HemisphereLight(0xdfe9ff, 0x1a1c1f, 1.75));

const keyLight = new THREE.DirectionalLight(0xffffff, 1.25);
keyLight.position.set(-3.2, 4.4, 4.2);
scene.add(keyLight);

const rimLight = new THREE.DirectionalLight(0x63dcff, 1.05);
rimLight.position.set(-5, 0.6, -2.4);
scene.add(rimLight);

const fillLight = new THREE.DirectionalLight(0xbcd2ff, 0.45);
fillLight.position.set(4, -1.4, 2.6);
scene.add(fillLight);

/* ------------------------------------------------------------------ *
 *  Materials
 * ------------------------------------------------------------------ */

/* Roughness is deliberately well off zero everywhere. A near-mirror surface
   concentrates each light into a pinpoint hotspot; spreading the specular lobe
   keeps the sheen but stops it blowing out to pure white. */
/* No specular anywhere on the shell. specularIntensity 0 zeroes the dielectric
   F0 so direct lights cannot burn a highlight, metalness 0 removes the metallic
   lobe, and clearcoat is off because it is a second specular layer of its own.
   What is left is pure diffuse shading plus a flat, even environment tint. */
const shellMat = new THREE.MeshPhysicalMaterial({
  color: 0xf2f4f7, metalness: 0, roughness: 0.62,
  clearcoat: 0, specularIntensity: 0, envMapIntensity: 0.30
});

const metalMat = new THREE.MeshPhysicalMaterial({
  color: 0x7d848c, metalness: 0.55, roughness: 0.72,
  clearcoat: 0, specularIntensity: 0, envMapIntensity: 0.35
});

const darkMat = new THREE.MeshPhysicalMaterial({
  color: 0x24272b, metalness: 0.55, roughness: 0.55, envMapIntensity: 0.8
});

const rubberMat = new THREE.MeshStandardMaterial({
  color: 0x1b1d20, metalness: 0.1, roughness: 0.88
});

const glowMat = () => new THREE.MeshStandardMaterial({
  color: CYAN, emissive: CYAN, emissiveIntensity: 2.4,
  metalness: 0, roughness: 0.4, toneMapped: false
});

/* Opaque on purpose: it is the dark glass the face glows through, and it must
   occlude the white shell behind it. */
const visorMat = new THREE.MeshPhysicalMaterial({
  color: 0x090b0e, metalness: 0, roughness: 0.75,
  clearcoat: 0, specularIntensity: 0,
  side: THREE.DoubleSide, envMapIntensity: 0.05
});

/* Radial-gradient sprite used to fake bloom — there is no post-processing
   pass here, so every emissive part gets an additive halo behind it. */
function haloTexture() {
  const c = document.createElement('canvas');
  c.width = c.height = 128;
  const g = c.getContext('2d');
  const grad = g.createRadialGradient(64, 64, 0, 64, 64, 64);
  grad.addColorStop(0.0, 'rgba(150,240,255,0.95)');
  grad.addColorStop(0.35, 'rgba(34,199,232,0.35)');
  grad.addColorStop(1.0, 'rgba(34,199,232,0)');
  g.fillStyle = grad;
  g.fillRect(0, 0, 128, 128);
  return new THREE.CanvasTexture(c);
}
const HALO = haloTexture();

function halo(size, opacity) {
  const s = new THREE.Sprite(new THREE.SpriteMaterial({
    map: HALO, transparent: true, depthWrite: false,
    blending: THREE.AdditiveBlending, opacity, toneMapped: false
  }));
  s.scale.set(size, size, 1);
  s.userData.baseOpacity = opacity;
  return s;
}

/* Halos are camera-facing sprites, so one parented to the head keeps drawing
   as a full disc even after the head turns away — which reads as a glowing
   circle floating off the face. Each of these carries the direction it is
   supposed to be seen from, and gets faded out as that direction turns away
   from the camera. */
const facingHalos = [];
function faceHalo(sprite, nx, ny, nz, floor) {
  sprite.userData.normal = new THREE.Vector3(nx, ny, nz).normalize();
  /* `floor` is how much glow survives when the surface has turned away. The
     eye halo goes to zero (it is the one that drifts off the silhouette); the
     ear pods keep a floor so they do not lose their glow at rest, since their
     normals point sideways and would otherwise always read as facing away. */
  sprite.userData.floor = floor;
  facingHalos.push(sprite);
  return sprite;
}

/* ------------------------------------------------------------------ *
 *  Eye canvas — one texture, redrawn each frame.
 *  This is what makes every expression possible: the eyes are not
 *  geometry, they are a drawing that can become any shape.
 * ------------------------------------------------------------------ */

const eyeCanvas = document.createElement('canvas');
eyeCanvas.width = 512;
eyeCanvas.height = 256;
const ectx = eyeCanvas.getContext('2d');
const eyeTexture = new THREE.CanvasTexture(eyeCanvas);
eyeTexture.colorSpace = THREE.SRGBColorSpace;

/* Big and well separated — eye size is most of what reads as "cute". These x
   values are pulled inward to compensate for the wide visor band, so the eyes
   land ~22 deg either side of the nose rather than wrapping onto the temples. */
const EYE_L = 162, EYE_R = 350, EYE_Y = 126;
const EYE_W = 100, EYE_H = 132;

function roundedRect(g, x, y, w, h, r) {
  const rr = Math.min(r, h / 2, w / 2);
  g.beginPath();
  g.moveTo(x - w / 2 + rr, y - h / 2);
  g.lineTo(x + w / 2 - rr, y - h / 2);
  g.quadraticCurveTo(x + w / 2, y - h / 2, x + w / 2, y - h / 2 + rr);
  g.lineTo(x + w / 2, y + h / 2 - rr);
  g.quadraticCurveTo(x + w / 2, y + h / 2, x + w / 2 - rr, y + h / 2);
  g.lineTo(x - w / 2 + rr, y + h / 2);
  g.quadraticCurveTo(x - w / 2, y + h / 2, x - w / 2, y + h / 2 - rr);
  g.lineTo(x - w / 2, y - h / 2 + rr);
  g.quadraticCurveTo(x - w / 2, y - h / 2, x - w / 2 + rr, y - h / 2);
  g.closePath();
  g.fill();
}

/* shape: 'normal' | 'sleep' | 'happy' | 'curious' | 'angry' | 'surprised' */
function drawEyes({ offsetX, offsetY, openness, width, shape, glow }) {
  ectx.clearRect(0, 0, 512, 256);
  ectx.save();
  ectx.lineCap = 'round';
  ectx.lineJoin = 'round';

  const w = EYE_W * width;
  const h = Math.max(5, EYE_H * openness);

  /* Two passes: a wide soft bloom, then a hot near-white core on top. That
     doubled pass is what sells "glowing panel" instead of "flat cyan shape". */
  const passes = [
    { color: '#22c7e8', blur: 46 * glow, lw: 20, scale: 1.0 },
    { color: '#eafcff', blur: 16 * glow, lw: 11, scale: 0.66 }
  ];

  for (const pass of passes) {
    ectx.shadowColor = 'rgba(90, 225, 255, 0.95)';
    ectx.shadowBlur = pass.blur;
    ectx.fillStyle = pass.color;
    ectx.strokeStyle = pass.color;

    for (const [i, cx] of [EYE_L, EYE_R].entries()) {
      const x = cx + offsetX;
      const y = EYE_Y + offsetY;
      const m = i === 0 ? 1 : -1;          // mirror the right eye
      const s = pass.scale;

      if (shape === 'sleep') {
        // Drooping lids — the BOTTOM half of the arc, so this never reads as
        // the happy "^ ^" face, which uses the top half.
        ectx.lineWidth = pass.lw * 0.9;
        ectx.beginPath();
        ectx.arc(x, y - 18, 46 * (s * 0.4 + 0.6), Math.PI * 0.14, Math.PI * 0.86);
        ectx.stroke();

      } else if (shape === 'happy') {
        // "^ ^" — upward crescents, the classic delighted face
        ectx.lineWidth = pass.lw;
        ectx.beginPath();
        ectx.arc(x, y + 40, 52 * (s * 0.35 + 0.65), Math.PI * 1.14, Math.PI * 1.86);
        ectx.stroke();

      } else if (shape === 'curious') {
        // ">  <" — leaning inward, quizzical
        ectx.lineWidth = pass.lw;
        ectx.beginPath();
        ectx.moveTo(x - 30 * m, y - 40);
        ectx.lineTo(x + 28 * m, y);
        ectx.lineTo(x - 30 * m, y + 40);
        ectx.stroke();

      } else if (shape === 'angry') {
        // slanted brow-heavy bars
        ectx.save();
        ectx.translate(x, y);
        ectx.rotate(m * 0.32);
        roundedRect(ectx, 0, 0, w * 0.92, h * 0.62, 20);
        ectx.restore();

      } else if (shape === 'surprised') {
        ectx.beginPath();
        ectx.arc(x, y, (w * 0.56) * (s * 0.3 + 0.7), 0, Math.PI * 2);
        ectx.fill();

      } else {
        roundedRect(ectx, x, y, w * (s * 0.28 + 0.72), h * (s * 0.28 + 0.72), 38);
      }
    }
  }
  ectx.restore();
  eyeTexture.needsUpdate = true;
}

/* ------------------------------------------------------------------ *
 *  Build the robot
 * ------------------------------------------------------------------ */

const root = new THREE.Group();
scene.add(root);

const hover = new THREE.Group();      // vertical bob
root.add(hover);

const body = new THREE.Group();       // counter-rotates against the head
hover.add(body);

/* --- torso --- */
const torso = new THREE.Mesh(new THREE.SphereGeometry(0.78, 64, 48), shellMat);
torso.scale.set(1, 1.12, 0.97);
torso.position.y = -0.42;
body.add(torso);

const collar = new THREE.Mesh(new THREE.CylinderGeometry(0.3, 0.36, 0.2, 40), metalMat);
collar.position.y = 0.33;
body.add(collar);

const beltRing = new THREE.Mesh(new THREE.TorusGeometry(0.66, 0.05, 20, 64), metalMat);
beltRing.rotation.x = Math.PI / 2;
beltRing.position.y = -0.5;
body.add(beltRing);

/* ---- chest emblem ----------------------------------------------------- *
 * Defaults to the cyan triangle, then swaps in the Ithrive mark if it loads.
 * Loading is async and failure is silent, so a missing badge just leaves the
 * triangle rather than breaking the scene.
 * ---------------------------------------------------------------------- */
const LOGO_SIZE = 0.42;

const emblem = new THREE.Mesh(new THREE.CircleGeometry(0.12, 3), glowMat());
emblem.position.set(0, -0.22, 0.752);
/* A 3-segment circle puts its first vertex at +X, so this rotates the point
   down rather than sideways. */
emblem.rotation.z = -Math.PI / 2;
body.add(emblem);

const emblemHalo = halo(0.62, 0.5);
emblemHalo.position.set(0, -0.22, 0.79);
body.add(emblemHalo);

let logoPlate = null;

new THREE.TextureLoader().load(
  BADGE_URL,
  (tex) => {
    tex.colorSpace = THREE.SRGBColorSpace;
    tex.anisotropy = renderer.capabilities.getMaxAnisotropy();

    /* Wrap the badge onto the ACTUAL torso ellipsoid rather than onto a guessed
       sphere. With a guessed radius the corners fell behind the real surface
       and got clipped, so the logo showed up with its edges eaten. Each vertex
       is placed on the torso surface at its own (x, y) and nudged out by a
       hair, so the whole mark stays visible however it curves. */
    const PLATE_Y = -0.20;
    const w = LOGO_SIZE, h = LOGO_SIZE;
    const plate = new THREE.Mesh(
      new THREE.PlaneGeometry(w, h, 24, 24),
      new THREE.MeshBasicMaterial({
        map: tex, transparent: true, depthWrite: false, toneMapped: false
      })
    );
    const p = plate.geometry.attributes.position;
    for (let i = 0; i < p.count; i++) {
      const x = p.getX(i);
      const yWorld = PLATE_Y + p.getY(i);
      const k = 1
        - (x / TORSO_R.x) * (x / TORSO_R.x)
        - ((yWorld - TORSO_C.y) / TORSO_R.y) * ((yWorld - TORSO_C.y) / TORSO_R.y);
      p.setZ(i, TORSO_R.z * Math.sqrt(Math.max(0, k)) + 0.014);
    }
    p.needsUpdate = true;

    plate.position.set(0, PLATE_Y, 0);
    plate.renderOrder = 3;
    body.add(plate);

    emblem.visible = false;               // retire the placeholder triangle
    emblemHalo.material.opacity = 0.22;   // keep only a soft backlight
    logoPlate = plate;

    /* The load lands asynchronously. If the render loop happens to be paused
       (off-screen, hidden tab, reduced motion) nothing would repaint and the
       badge would silently never appear, so force one frame here. */
    renderer.render(scene, camera);
  },
  undefined,
  () => { /* no logo file — keep the triangle */ }
);

/* --- thruster --- */
const thrusterShell = new THREE.Mesh(new THREE.CylinderGeometry(0.42, 0.2, 0.34, 40), metalMat);
thrusterShell.position.y = -1.2;
body.add(thrusterShell);

const thrusterCore = new THREE.Mesh(new THREE.ConeGeometry(0.2, 0.5, 36), glowMat());
thrusterCore.position.y = -1.6;
thrusterCore.rotation.x = Math.PI;
body.add(thrusterCore);

const thrusterHalo = halo(1.5, 0.72);
thrusterHalo.position.y = -1.62;
body.add(thrusterHalo);

/* --- arms ---
 *
 * A real three-joint chain (shoulder -> elbow -> wrist) driven by two-bone IK,
 * so the hand gets placed at a point in space and the elbow works out where to
 * go. The previous version was a single rigid hinge, which is why it read as a
 * stick rather than an arm.
 */
const UPPER_LEN = 0.42;
const FORE_LEN = 0.40;

function buildArm(side) {
  const shoulder = new THREE.Group();
  shoulder.position.set(0.84 * side, -0.10, 0.08);
  shoulder.add(new THREE.Mesh(new THREE.SphereGeometry(0.17, 32, 24), rubberMat));

  const upper = new THREE.Mesh(
    new THREE.CapsuleGeometry(0.115, UPPER_LEN - 0.16, 8, 24), shellMat);
  upper.position.y = -UPPER_LEN / 2;
  shoulder.add(upper);

  const elbow = new THREE.Group();
  elbow.position.y = -UPPER_LEN;
  shoulder.add(elbow);
  elbow.add(new THREE.Mesh(new THREE.SphereGeometry(0.125, 28, 20), rubberMat));

  const fore = new THREE.Mesh(
    new THREE.CapsuleGeometry(0.105, FORE_LEN - 0.16, 8, 24), shellMat);
  fore.position.y = -FORE_LEN / 2;
  elbow.add(fore);

  const wrist = new THREE.Group();
  wrist.position.y = -FORE_LEN;
  elbow.add(wrist);

  const hand = new THREE.Mesh(new THREE.SphereGeometry(0.19, 32, 24), shellMat);
  hand.scale.set(1, 0.92, 0.86);
  hand.position.y = -0.12;
  wrist.add(hand);

  /* three stubby fingers, each on its own pivot so they can curl */
  const fingers = [];
  for (let f = -1; f <= 1; f++) {
    const pivot = new THREE.Group();
    pivot.position.set(f * 0.10, -0.20, 0.04);
    const finger = new THREE.Mesh(new THREE.CapsuleGeometry(0.048, 0.1, 6, 16), shellMat);
    finger.position.y = -0.07;
    pivot.add(finger);
    pivot.userData.spread = f * 0.22;
    wrist.add(pivot);
    fingers.push(pivot);
  }

  body.add(shoulder);

  return {
    side, shoulder, elbow, wrist, fingers,
    /* spring state for the IK target, in body space */
    pos: new THREE.Vector3(),
    vel: new THREE.Vector3()
  };
}
const armL = buildArm(1);
const armR = buildArm(-1);

/* Where a hand rests when nothing is happening: out to the side and slightly
   forward of the belly, so it can never sink into the torso. */
function restTarget(side, out) {
  /* Kept just inside max reach (0.80 from the shoulder) so the arm hangs
     nearly straight with a hint of bend, rather than being clamped. */
  return out.set(0.93 * side, -0.84, 0.32);
}
restTarget(1, armL.pos);
restTarget(-1, armR.pos);

/* ---- two-bone IK ------------------------------------------------------ *
 * Place the wrist at `target` (body space). The law of cosines gives the
 * elbow bend; the shoulder aims straight down the line to the target and is
 * then rotated off it by a1, so the two bones close the triangle.
 * ---------------------------------------------------------------------- */
const _dir = new THREE.Vector3();
const _down = new THREE.Vector3(0, -1, 0);
const _perp = new THREE.Vector3();
const _pole = new THREE.Vector3();
const _elbowPos = new THREE.Vector3();
const _tmp = new THREE.Vector3();
const _rel = new THREE.Vector3();
const _invQ = new THREE.Quaternion();

/* The torso is a sphere of r=0.78 scaled (1, 1.12, 0.97) centred at y=-0.42.
   Collision is done against that ellipsoid rather than against axis limits,
   because "keep x beyond 0.46" is meaningless when the body is 0.78 wide. */
const TORSO_C = new THREE.Vector3(0, -0.42, 0);
const TORSO_R = new THREE.Vector3(0.78, 0.874, 0.757);

/* The head, for arm collision: helmet r=0.95 scaled 1.04 in x, sitting at
   body-local y=0.95. Without this the hand sinks into the skull on the wave. */
const HEAD_C = new THREE.Vector3(0, 0.95, 0);
const HEAD_R = 0.97;

function pushOutOfSphere(p, c, r) {
  _rel.copy(p).sub(c);
  const d = _rel.length();
  if (d >= r) return false;
  if (d < 1e-6) { p.set(c.x, c.y - r, c.z); return true; }
  p.copy(c).addScaledVector(_rel.divideScalar(d), r);
  return true;
}

/* Push p out to the surface of the torso ellipsoid inflated by `margin`
   (the radius of whatever part is being kept clear, plus a visible gap). */
function pushOutOfTorso(p, margin) {
  const rx = TORSO_R.x + margin, ry = TORSO_R.y + margin, rz = TORSO_R.z + margin;
  _rel.set((p.x - TORSO_C.x) / rx, (p.y - TORSO_C.y) / ry, (p.z - TORSO_C.z) / rz);
  const len = _rel.length();
  if (len >= 1 || len < 1e-6) return false;
  _rel.divideScalar(len);
  p.set(TORSO_C.x + _rel.x * rx, TORSO_C.y + _rel.y * ry, TORSO_C.z + _rel.z * rz);
  return true;
}

/* The hand sphere hangs HAND_DROP beyond the wrist, so the wrist has to stay
   that much further out or the hand dips back into the belly. */
const HAND_DROP = 0.12;
const HAND_RAD = 0.19;
const WRIST_CLEAR = HAND_RAD + HAND_DROP + 0.04;

function solveArm(arm, target) {
  const min = Math.abs(UPPER_LEN - FORE_LEN) + 0.03;
  const max = UPPER_LEN + FORE_LEN - 0.02;

  /* Reach and body-clearance fight each other: pushing the target off the
     torso can shove it out of reach, and pulling it back into reach can shove
     it into the torso. Alternate the two projections until they agree — a few
     passes is plenty, and it leaves the target satisfying both. */
  for (let i = 0; i < 4; i++) {
    pushOutOfTorso(target, WRIST_CLEAR);
    pushOutOfSphere(target, HEAD_C, HEAD_R + WRIST_CLEAR);
    _tmp.copy(target).sub(arm.shoulder.position);
    const L = _tmp.length();
    if (L > max) target.copy(arm.shoulder.position).addScaledVector(_tmp, max / L);
    else if (L < min && L > 1e-6) target.copy(arm.shoulder.position).addScaledVector(_tmp, min / L);
  }

  _dir.copy(target).sub(arm.shoulder.position);
  const reach = _dir.length();
  if (reach < 1e-5) return 0;
  const d = THREE.MathUtils.clamp(reach, min, max);
  _dir.divideScalar(reach);

  const cosA1 = (d * d + UPPER_LEN * UPPER_LEN - FORE_LEN * FORE_LEN) / (2 * d * UPPER_LEN);
  const a1 = Math.acos(THREE.MathUtils.clamp(cosA1, -1, 1));

  /* Pole vector: the plane the elbow bends in. Pointing it outward and a
     little back is what keeps the elbow off the ribs — bending about a fixed
     local axis sent it straight through the torso. */
  _pole.set(arm.side, -0.10, -0.40).normalize();
  _perp.copy(_pole).addScaledVector(_dir, -_pole.dot(_dir));
  if (_perp.lengthSq() < 1e-6) _perp.set(arm.side, 0, 0);
  _perp.normalize();

  /* Solve the elbow's position directly, then keep it out of the body too. */
  _elbowPos.copy(arm.shoulder.position)
    .addScaledVector(_dir, UPPER_LEN * Math.cos(a1))
    .addScaledVector(_perp, UPPER_LEN * Math.sin(a1));
  /* Clearing the elbow by more than its own radius also lifts the upper-arm
     segment between shoulder and elbow off the ribs. */
  pushOutOfTorso(_elbowPos, 0.21);
  pushOutOfSphere(_elbowPos, HEAD_C, HEAD_R + 0.16);

  /* Upper arm aims at the elbow... */
  _tmp.copy(_elbowPos).sub(arm.shoulder.position).normalize();
  arm.shoulder.quaternion.setFromUnitVectors(_down, _tmp);

  /* ...and the forearm aims from the elbow to the target, converted into the
     shoulder's frame because the elbow group is parented to it. */
  _tmp.copy(target).sub(_elbowPos).normalize();
  _invQ.copy(arm.shoulder.quaternion).invert();
  _tmp.applyQuaternion(_invQ);
  arm.elbow.quaternion.setFromUnitVectors(_down, _tmp);

  return d / max;                       // 0..1, how extended the arm is
}

/* Under-damped spring. This is what separates "expensive" motion from a lerp:
   the hand overshoots its target slightly and settles, instead of easing in on
   a dead exponential curve. Substepped so a long frame cannot blow it up. */
const _handTarget = new THREE.Vector3();
const _cursorPt = new THREE.Vector3();
const _hn = new THREE.Vector3();
const _hv = new THREE.Vector3();
const _hp = new THREE.Vector3();
const _hq = new THREE.Quaternion();

const _accel = new THREE.Vector3();
function springTo(pos, vel, target, k, zeta, dt) {
  const c = 2 * Math.sqrt(k) * zeta;
  const steps = Math.min(8, Math.max(1, Math.ceil(dt / (1 / 120))));
  const hStep = dt / steps;
  for (let i = 0; i < steps; i++) {
    _accel.copy(target).sub(pos).multiplyScalar(k).addScaledVector(vel, -c);
    vel.addScaledVector(_accel, hStep);
    pos.addScaledVector(vel, hStep);
  }
}

/* --- head --- */
const head = new THREE.Group();
head.position.y = 0.95;
body.add(head);

const helmet = new THREE.Mesh(new THREE.SphereGeometry(0.95, 64, 48), shellMat);
helmet.scale.set(1.04, 1, 0.99);
head.add(helmet);

/* In three.js SphereGeometry, x = -r·cos(phi)·sin(theta) and z = r·sin(phi)·sin(theta),
   so phi = 0 lands on -X and the FRONT of the head (+Z) is phi = PI/2. Getting
   this wrong wraps the face around the side of the skull. */
const FRONT = Math.PI / 2;

/* Visor band — a slice of a slightly LARGER sphere, so it sits on the outside
   of the helmet. theta puts it just above the equator, which is what reads as
   "cute" rather than "stern". */
const V_PHILEN = 2.15, V_PHI0 = FRONT - V_PHILEN / 2;
const V_TH0 = 0.92, V_THLEN = 0.86;

const visor = new THREE.Mesh(
  new THREE.SphereGeometry(0.968, 96, 48, V_PHI0, V_PHILEN, V_TH0, V_THLEN),
  visorMat
);
visor.scale.set(1.04, 1, 0.99);
head.add(visor);

/* The face: the eye canvas mapped onto a band a hair proud of the visor, so
   it reads as light coming through the glass. Sphere UVs run u across phi and
   v across theta, so the canvas lands on the band without distortion. */
const face = new THREE.Mesh(
  new THREE.SphereGeometry(0.995, 96, 48, V_PHI0, V_PHILEN, V_TH0, V_THLEN),
  new THREE.MeshBasicMaterial({
    map: eyeTexture, transparent: true, depthWrite: false,
    blending: THREE.AdditiveBlending, toneMapped: false
  })
);
face.scale.set(1.04, 1, 0.99);
face.renderOrder = 4;
head.add(face);

/* No sprite halo over the visor. A camera-facing disc big enough to read as
   eye-glow gets depth-clipped by the helmet, and against the near-black visor
   that clip boundary shows up as a hard circular edge that slides around as
   the head turns. The eyes carry their own two-pass glow on the canvas
   (wide cyan bloom + hot core), which needs no help. */

/* side panels + ear pods — the panels belong on ±X, i.e. phi 0 and PI */
for (const side of [1, -1]) {
  const panelCentre = side === 1 ? Math.PI : 0;
  const panel = new THREE.Mesh(
    new THREE.SphereGeometry(0.955, 40, 32, panelCentre - 0.42, 0.84, 0.6, 1.0),
    darkMat
  );
  panel.scale.set(1.04, 1, 0.99);
  head.add(panel);

  const pod = new THREE.Mesh(new THREE.CylinderGeometry(0.23, 0.23, 0.14, 36), darkMat);
  pod.rotation.z = Math.PI / 2;
  pod.position.set(0.96 * side, 0.02, 0);
  head.add(pod);

  const podRing = new THREE.Mesh(new THREE.TorusGeometry(0.155, 0.035, 16, 40), glowMat());
  podRing.rotation.y = Math.PI / 2;
  podRing.position.set(1.02 * side, 0.02, 0);
  head.add(podRing);

  const podHalo = halo(0.8, 0.45);
  podHalo.position.set(1.06 * side, 0.02, 0);
  /* angled forward so the pods still catch light head-on, not only in profile */
  faceHalo(podHalo, side * 0.75, 0, 0.66, 0.3);
  head.add(podHalo);

  /* small antenna nub */
  const nub = new THREE.Mesh(new THREE.CapsuleGeometry(0.05, 0.12, 6, 16), metalMat);
  nub.position.set(0.55 * side, 0.78, -0.2);
  nub.rotation.z = side * 0.5;
  head.add(nub);
}

/* contact shadow so he does not float in a vacuum */
const shadowTex = (() => {
  const c = document.createElement('canvas');
  c.width = c.height = 128;
  const g = c.getContext('2d');
  const grad = g.createRadialGradient(64, 64, 0, 64, 64, 64);
  grad.addColorStop(0, 'rgba(0,0,0,0.55)');
  grad.addColorStop(1, 'rgba(0,0,0,0)');
  g.fillStyle = grad;
  g.fillRect(0, 0, 128, 128);
  return new THREE.CanvasTexture(c);
})();
const contactShadow = new THREE.Mesh(
  new THREE.PlaneGeometry(3, 3),
  new THREE.MeshBasicMaterial({ map: shadowTex, transparent: true, depthWrite: false })
);
contactShadow.rotation.x = -Math.PI / 2;
contactShadow.position.y = -2.42;
root.add(contactShadow);

/* ------------------------------------------------------------------ *
 *  Pointer input — the handler only stores coordinates.
 * ------------------------------------------------------------------ */

const pointer = { x: 0, y: 0, px: 0, py: 0, near: 0 };
let lastMoveAt = -Infinity;

if (!isTouch) {
  window.addEventListener('pointermove', (e) => {
    pointer.x = (e.clientX / window.innerWidth) * 2 - 1;
    pointer.y = (e.clientY / window.innerHeight) * 2 - 1;
    pointer.px = e.clientX;
    pointer.py = e.clientY;
    lastMoveAt = performance.now();
  }, { passive: true });
}

/* ------------------------------------------------------------------ *
 *  Idle behaviours
 *
 *  Each returns targets that override tracking for its duration.
 *  `p` is normalised progress 0..1.
 * ------------------------------------------------------------------ */

const IDLE_ACTIONS = [
  {
    name: 'blink',
    duration: 0.9,
    run: (p, t) => {
      if (p > 0.2 && p < 0.34) t.openness = 0.06;
    }
  },
  {
    name: 'look around',
    duration: 4.2,
    run: (p, t) => {
      const a = p < 0.42 ? 1 : (p < 0.55 ? 0 : -1);
      const s = p < 0.42 ? 0.9 : (p < 0.55 ? 0 : 0.75);
      t.yaw = a * 26 * DEG;
      t.eyeX = a * 40 * s;
      t.pitch = (p > 0.55 ? -6 : 4) * DEG;
    }
  },
  {
    name: 'wave',
    duration: 2.6,
    run: (p, t) => {
      const lift = Math.min(1, p / 0.22) * (1 - Math.max(0, (p - 0.78) / 0.22));
      t.waveLift = lift;
      t.armRWave = Math.sin(p * Math.PI * 6) * lift;
      t.shape = 'happy';
      t.roll = -5 * DEG * lift;
    }
  },
  {
    name: 'curious tilt',
    duration: 2.8,
    run: (p, t) => {
      const ease = Math.min(1, p / 0.2) * (1 - Math.max(0, (p - 0.8) / 0.2));
      t.roll = 15 * DEG * ease;
      t.pitch = -5 * DEG * ease;
      if (p > 0.25 && p < 0.8) t.shape = 'curious';
    }
  },
  {
    name: 'sleep',
    duration: 5.4,
    run: (p, t) => {
      const ease = Math.min(1, p / 0.18) * (1 - Math.max(0, (p - 0.84) / 0.16));
      t.shape = 'sleep';
      t.pitch = 11 * DEG * ease;
      t.bodyY = -0.14 * ease;
      t.bobScale = 1 - 0.45 * ease;
      t.glow = 1 - 0.45 * ease;
    }
  },
  {
    name: 'alert',
    duration: 1.5,
    run: (p, t) => {
      const hop = Math.sin(Math.min(1, p / 0.45) * Math.PI);
      t.bodyY = 0.34 * hop;
      t.pitch = -9 * DEG * hop;
      if (p < 0.32) { t.glow = 2.1; t.width = 1.14; t.shape = 'happy'; }
    }
  },
  {
    name: 'double take',
    duration: 2.2,
    run: (p, t) => {
      if (p < 0.14) { t.shape = 'surprised'; t.glow = 2.2; t.pitch = -7 * DEG; }
      else if (p < 0.5) { t.shape = 'surprised'; t.yaw = -18 * DEG; t.eyeX = -34; }
      else if (p < 0.8) { t.shape = 'surprised'; t.yaw = 18 * DEG; t.eyeX = 34; }
      else t.shape = 'happy';
    }
  },
  {
    name: 'grumpy',
    duration: 2.6,
    run: (p, t) => {
      const ease = Math.min(1, p / 0.22) * (1 - Math.max(0, (p - 0.76) / 0.24));
      t.shape = p > 0.12 && p < 0.88 ? 'angry' : 'normal';
      t.pitch = 8 * DEG * ease;
      t.roll = -7 * DEG * ease;
      t.glow = 1 + 0.5 * ease;
      t.bodyY = -0.07 * ease;
    }
  }
];

let currentAction = null;
let actionStartedAt = 0;
let nextActionAt = 0;
let lastActionName = '';

function pickAction(now) {
  let next;
  do {
    next = IDLE_ACTIONS[(Math.random() * IDLE_ACTIONS.length) | 0];
  } while (IDLE_ACTIONS.length > 1 && next.name === lastActionName);
  lastActionName = next.name;
  currentAction = next;
  actionStartedAt = now;
}

/* ------------------------------------------------------------------ *
 *  Animation loop
 * ------------------------------------------------------------------ */

/* current (damped) values */
const cur = {
  yaw: 0, pitch: 0, roll: 0,
  eyeX: 0, eyeY: 0, openness: 1, width: 1, glow: 1,
  bodyY: 0, armR: 0
};

let blinkAt = 3 + Math.random() * 3;
let clockT = 0;
let visible = true;
let running = false;

const damp = (current, target, lambda, dt) =>
  current + (target - current) * (1 - Math.exp(-lambda * dt));

function frame(nowMs) {
  if (!running) return;
  requestAnimationFrame(frame);

  const dt = Math.min(0.05, clock.getDelta());
  clockT += dt;
  const now = nowMs;

  const idleFor = (now - lastMoveAt) / 1000;
  const isIdle = isTouch || idleFor > 2.5;

  /* ---- targets, starting from the tracking pose ---- */
  const t = {
    yaw: 0, pitch: 0, roll: 0,
    eyeX: 0, eyeY: 0, openness: 1, width: 1, glow: 1,
    bodyY: 0, armR: 0, armRWave: 0,
    reaching: 0, waveLift: 0,
    shape: 'normal', bobScale: 1
  };

  if (!isIdle) {
    /* head follows the pointer, clamped */
    t.yaw = THREE.MathUtils.clamp(pointer.x, -1, 1) * 35 * DEG;
    /* Asymmetric on purpose: the camera sits below head height, so tilting up
       swings the visor out of view much faster than tilting down does. Looking
       up is therefore limited far more tightly, to keep the face readable. */
    const py = THREE.MathUtils.clamp(pointer.y, -1, 1);
    t.pitch = py * (py < 0 ? 11 : 22) * DEG;

    /* Eyes lead the head by chasing the RESIDUAL between where the head is
       currently aimed and where the cursor is. They dart ahead while the head
       is still turning, then recentre as it catches up. Leading off the raw
       pointer instead would stack the offset on top of an already-turned head
       and wrap the eyes off the side of the visor at full yaw. The small
       second term keeps a little steady-state bias toward the cursor. */
    const yawNorm = cur.yaw / (35 * DEG);
    const pitchNorm = cur.pitch / (22 * DEG);
    t.eyeX = THREE.MathUtils.clamp((pointer.x - yawNorm) * 2.2, -1, 1) * 34
           + THREE.MathUtils.clamp(pointer.x, -1, 1) * 12;
    t.eyeY = THREE.MathUtils.clamp((pointer.y - pitchNorm) * 2.2, -1, 1) * 18
           + THREE.MathUtils.clamp(pointer.y, -1, 1) * 8;

    /* proximity: widen and brighten when the cursor comes close. The head's
       NDC is relative to the canvas, not the window, so it has to be mapped
       through the canvas box — the mascot lives in a hero column, not
       full-bleed. */
    const proj = new THREE.Vector3(0, 0.95, 0).project(camera);
    const cr = canvas.getBoundingClientRect();
    const hx = cr.left + (proj.x * 0.5 + 0.5) * cr.width;
    const hy = cr.top + (-proj.y * 0.5 + 0.5) * cr.height;
    const dist = Math.hypot(pointer.px - hx, pointer.py - hy);
    pointer.near = THREE.MathUtils.clamp(1 - dist / 150, 0, 1);
    t.glow = 1 + 0.2 * pointer.near;
    t.width = 1 + 0.12 * pointer.near;

    t.reaching = 1;

    currentAction = null;
    nextActionAt = 0;
  } else {
    /* idle: recentre, then run behaviours with 2-4s gaps */
    if (!currentAction) {
      if (!nextActionAt) nextActionAt = now + 700;
      if (now >= nextActionAt) pickAction(now);
    }
    if (currentAction) {
      const p = (now - actionStartedAt) / 1000 / currentAction.duration;
      if (p >= 1) {
        currentAction = null;
        nextActionAt = now + 2000 + Math.random() * 2000;
      } else {
        currentAction.run(p, t);
      }
    }
  }

  /* autonomous blink, every 4-7s, regardless of state */
  blinkAt -= dt;
  if (blinkAt <= 0) blinkAt = 4 + Math.random() * 3;
  if (blinkAt > 4 && blinkAt < 4.12 && t.shape === 'normal') t.openness = 0.06;

  /* ---- damping ---- */
  const L = reducedMotion ? 60 : 9;
  cur.yaw = damp(cur.yaw, t.yaw, L, dt);
  cur.pitch = damp(cur.pitch, t.pitch, L, dt);
  cur.roll = damp(cur.roll, t.roll, L, dt);
  cur.eyeX = damp(cur.eyeX, t.eyeX, 14, dt);
  cur.eyeY = damp(cur.eyeY, t.eyeY, 14, dt);
  cur.openness = damp(cur.openness, t.openness, 34, dt);
  cur.width = damp(cur.width, t.width, 12, dt);
  cur.glow = damp(cur.glow, t.glow, 10, dt);
  cur.bodyY = damp(cur.bodyY, t.bodyY, 8, dt);
  cur.armR = damp(cur.armR, t.armR, 10, dt);

  /* ---- apply ---- */
  /* Positive rotation.x tilts the face DOWN, and clientY grows downward, so
     pitch maps straight through with no negation. Every idle action's pitch
     reads the same way: positive looks down, negative looks up. */
  head.rotation.set(cur.pitch, cur.yaw, cur.roll);
  body.rotation.y = cur.yaw * 0.3;          // torso counter-twist
  body.rotation.z = -cur.roll * 0.25;

  /* ---- arms: pick a hand target, spring toward it, then solve IK ---- */
  for (const arm of [armL, armR]) {
    restTarget(arm.side, _handTarget);

    if (t.reaching) {
      /* A point in body space that follows the cursor, out in front of the
         chest. The arm on the cursor's side commits to it much harder, which
         is what stops both hands mirroring each other like a puppet. */
      _cursorPt.set(pointer.x * 1.55, -pointer.y * 0.80 - 0.52, 0.92);
      const near = THREE.MathUtils.clamp(0.5 + 0.5 * pointer.x * arm.side, 0, 1);
      _handTarget.lerp(_cursorPt, 0.30 + 0.55 * near);
    }

    if (t.waveLift) {
      /* the wave is just another hand target: up, out, and oscillating */
      _cursorPt.set(arm.side * (0.98 + t.armRWave * 0.20), 0.28, 0.44);
      if (arm === armR) _handTarget.lerp(_cursorPt, t.waveLift);
    }

    /* Keep the hand on its own side, then push it clear of the torso itself.
       The margin is the hand's radius (0.19) plus a visible gap, so the hand
       SURFACE never touches the body rather than just its centre. */
    _handTarget.x = arm.side > 0
      ? Math.max(0.10, _handTarget.x)
      : Math.min(-0.10, _handTarget.x);

    springTo(arm.pos, arm.vel, _handTarget, 150, 0.62, dt);
    const ext = solveArm(arm, arm.pos);

    /* Secondary motion: fingers splay as the arm extends and curl as it
       relaxes, and the wrist cocks back slightly when reaching. */
    const curl = THREE.MathUtils.clamp((ext - 0.55) / 0.4, 0, 1);
    arm.wrist.rotation.x = 0.22 - curl * 0.55;
    for (const f of arm.fingers) {
      f.rotation.z = f.userData.spread * (0.6 + curl * 0.9);
      f.rotation.x = 0.55 - curl * 0.85;
    }
  }

  /* hover bob + offset-phase roll so the loop never reads as mechanical */
  const bobAmp = reducedMotion ? 0 : 0.13 * (t.bobScale ?? 1);
  const bob = Math.sin(clockT * (Math.PI * 2 / 3)) * bobAmp;
  hover.position.y = bob + cur.bodyY;
  hover.rotation.z = reducedMotion ? 0 : Math.sin(clockT * 0.86 + 1.2) * 0.022;
  hover.rotation.x = reducedMotion ? 0 : Math.sin(clockT * 0.63) * 0.015;

  /* thruster pulses with the bob */
  const pulse = 0.72 + (bob / (bobAmp || 1)) * 0.18 + 0.1 * Math.sin(clockT * 5);
  thrusterHalo.material.opacity = Math.max(0.15, pulse * cur.glow);
  thrusterCore.material.emissiveIntensity = 2.2 + pulse * 0.9;
  emblemHalo.material.opacity = 0.35 + 0.2 * cur.glow;

  /* Fade each head halo by how squarely its surface faces the camera, so a
     turned head never leaves a glowing disc hanging beside the face. */
  for (const s of facingHalos) {
    _hn.copy(s.userData.normal).applyQuaternion(head.getWorldQuaternion(_hq));
    _hv.subVectors(camera.position, s.getWorldPosition(_hp)).normalize();
    const facing = THREE.MathUtils.clamp(_hn.dot(_hv), 0, 1);
    const f = s.userData.floor;
    s.material.opacity = s.userData.baseOpacity * (f + (1 - f) * facing * facing);
  }

  drawEyes({
    offsetX: cur.eyeX,
    offsetY: cur.eyeY,
    openness: cur.openness,
    width: cur.width,
    shape: t.shape,
    glow: cur.glow
  });

  if (readout) {
    readout.textContent = isIdle
      ? (currentAction ? currentAction.name : 'idle')
      : 'tracking';
  }

  renderer.render(scene, camera);
}

const clock = new THREE.Clock();

/* ------------------------------------------------------------------ *
 *  Lifecycle — never render off-screen or on a hidden tab
 * ------------------------------------------------------------------ */

function start() {
  if (running) return;
  running = true;
  /* ResizeObserver callbacks are delivered with the rendering steps, which a
     background tab suspends — so a page that loads hidden can be sized 0 and
     never hear about the real size. Re-check whenever the loop resumes. */
  resize();
  clock.getDelta();
  requestAnimationFrame(frame);
}
function stop() { running = false; }

function updateRunState() {
  if (visible && !document.hidden) start(); else stop();
}

new IntersectionObserver(([entry]) => {
  visible = entry.isIntersecting;
  updateRunState();
}, { threshold: 0.01 }).observe(canvas);

document.addEventListener('visibilitychange', updateRunState);

function resize() {
  const w = canvas.clientWidth || window.innerWidth;
  const h = canvas.clientHeight || window.innerHeight;

  /* A hidden or not-yet-laid-out tab reports 0 here. Sizing the renderer to
     0 would leave it stuck, because `window.resize` never fires for a change
     to the element's own box — hence the ResizeObserver below. */
  if (w < 1 || h < 1) return;

  renderer.setSize(w, h, false);
  camera.aspect = w / h;

  /* Frame him to the box he was given rather than to the window. He stands
     about 4.6 units tall and 3.2 wide with the arms out, so the distance is
     whichever of those two constraints binds first — that fills a hero column
     properly instead of leaving him a speck in the middle of it. */
  const halfFov = Math.tan(16 * DEG);
  camera.position.z = Math.max(4.6 / (2 * halfFov), 3.2 / (2 * halfFov * camera.aspect));
  camera.updateProjectionMatrix();

  /* Paint once so a paused or off-screen mascot is never a blank rectangle. */
  drawEyes({ offsetX: cur.eyeX, offsetY: cur.eyeY, openness: cur.openness,
             width: cur.width, shape: 'normal', glow: cur.glow });
  renderer.render(scene, camera);
}
window.addEventListener('resize', resize);
new ResizeObserver(resize).observe(canvas);
resize();

/* Add ?debug to the URL to expose the scene graph for inspection. */
if (new URLSearchParams(location.search).has('debug')) {
  window.__mascot = { scene, camera, renderer, root, head, body, face, visor,
                      armL, armR, eyeCanvas, drawEyes, cur, solveArm, restTarget,
                      pushOutOfTorso, facingHalos,
                      start, frame, setPointer: (x, y) => {
                        pointer.x = x; pointer.y = y;
                        pointer.px = (x * 0.5 + 0.5) * window.innerWidth;
                        pointer.py = (y * 0.5 + 0.5) * window.innerHeight;
                        lastMoveAt = performance.now();
                      } };
}

updateRunState();
