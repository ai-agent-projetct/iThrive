import * as THREE from 'three';

/* ------------------------------------------------------------------ *
 *  The humanoid from the reference film, rebuilt as a rig you can drive.
 *
 *  Modelled from frames of the film rather than from memory: white glossy
 *  shell panels over a dark charcoal under-suit, rounded helmet with a near-
 *  black visor, pauldrons, segmented arms with visible elbows, plated thighs
 *  and dark boots. Lit the way the film lights it — a cool key from above and
 *  in front, and a hard blue rim from behind, which is what separates a white
 *  robot from a black background.
 *
 *  Everything is primitives. There is no model to download, nothing to wait
 *  for, and the whole body is a few hundred triangles, so it runs on the
 *  integrated GPU in a laptop.
 *
 *  Tracking: the head turns to the pointer, the eyes lead it, the chest
 *  counter-twists so the turn reads through the body, and the arm on the
 *  pointer's side reaches for it — shoulder, elbow and wrist, so the hand
 *  arrives rather than the whole arm swinging as one plank.
 *
 *  Idle: breathing, a slow weight shift between the feet, and blinking.
 *
 *  The canvas is transparent. The flower field behind it is the video in
 *  components/hero-robot.php, so the robot composites onto real footage
 *  instead of a rendered floor that would never match it.
 * ------------------------------------------------------------------ */

const MOUNT = document.querySelector('[data-field-robot]');

if (MOUNT && !MOUNT.dataset.fieldRobotReady) {
  MOUNT.dataset.fieldRobotReady = '1';
  build(MOUNT);
}

function build(mount) {
  const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  let renderer;
  try {
    renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true, powerPreference: 'high-performance' });
  } catch (e) {
    return;   // No WebGL. The field and the copy are the hero.
  }

  const boxW = () => mount.clientWidth || 640;
  const boxH = () => mount.clientHeight || 640;

  renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 2));
  renderer.setSize(boxW(), boxH());
  renderer.outputColorSpace = THREE.SRGBColorSpace;
  renderer.toneMapping = THREE.ACESFilmicToneMapping;
  renderer.toneMappingExposure = 1.15;
  mount.appendChild(renderer.domElement);

  const scene = new THREE.Scene();
  const camera = new THREE.PerspectiveCamera(34, boxW() / boxH(), 0.1, 60);
  camera.position.set(0, 1.54, 5.6);
  camera.lookAt(0, 1.42, 0);

  /* ---- materials, sampled from the film -------------------------------- */

  const SHELL = new THREE.MeshPhysicalMaterial({
    color: 0xe7ecf4, roughness: 0.3, metalness: 0.1,
    clearcoat: 0.85, clearcoatRoughness: 0.22,
  });
  const DARK = new THREE.MeshStandardMaterial({ color: 0x171a21, roughness: 0.44, metalness: 0.55 });
  const TRIM = new THREE.MeshStandardMaterial({ color: 0x2b313d, roughness: 0.32, metalness: 0.75 });
  const VISOR = new THREE.MeshPhysicalMaterial({
    color: 0x05070c, roughness: 0.06, metalness: 0.25, clearcoat: 1, clearcoatRoughness: 0.05,
  });

  /* ---- lighting -------------------------------------------------------- */

  // Key from above and in front, the way the film's overhead light falls.
  const key = new THREE.DirectionalLight(0xf2f7ff, 2.6);
  key.position.set(2.2, 6.2, 3.4);
  scene.add(key);

  // The hard blue rim from behind. Without this a white robot on a black
  // background has no edge at all — it is most of what the film is doing.
  const rim = new THREE.DirectionalLight(0x9ecdff, 3.4);
  rim.position.set(-2.6, 3.2, -4.2);
  scene.add(rim);

  const rim2 = new THREE.DirectionalLight(0x7fb4ff, 1.6);
  rim2.position.set(3.2, 2.4, -3.6);
  scene.add(rim2);

  scene.add(new THREE.HemisphereLight(0x8fb6ff, 0x080a10, 0.5));

  /* ---- the face -------------------------------------------------------- */

  // Eyes and mouth are a drawing, not geometry — that is what lets the face
  // hold an expression and blink without a single extra vertex.
  const faceCanvas = document.createElement('canvas');
  faceCanvas.width = 512;
  faceCanvas.height = 512;
  const fx = faceCanvas.getContext('2d');
  const faceTex = new THREE.CanvasTexture(faceCanvas);
  faceTex.colorSpace = THREE.SRGBColorSpace;

  const EYE_L = 186, EYE_R = 326, EYE_Y = 224, MOUTH_Y = 330;

  function drawFace(eyeX, eyeY, openness) {
    fx.clearRect(0, 0, 512, 512);
    fx.lineCap = 'round';
    fx.lineJoin = 'round';

    // Two passes — a wide soft bloom, then a hot near-white core. The doubled
    // pass is what reads as a lit panel rather than a flat cyan shape.
    for (const p of [
      { color: '#39d4f2', blur: 44, lw: 17, s: 1 },
      { color: '#ecfdff', blur: 14, lw: 9,  s: 0.6 },
    ]) {
      fx.shadowColor = 'rgba(105, 225, 255, .95)';
      fx.shadowBlur = p.blur;
      fx.strokeStyle = p.color;
      fx.fillStyle = p.color;
      fx.lineWidth = p.lw;

      const h = Math.max(3, 42 * openness);
      for (const cx of [EYE_L, EYE_R]) {
        const x = cx + eyeX, y = EYE_Y + eyeY;
        fx.beginPath();
        fx.roundRect(x - 30 * (p.s * 0.3 + 0.7), y - h / 2, 60 * (p.s * 0.3 + 0.7), h, 14);
        fx.fill();
      }

      // A calm, closed smile — the film's robot has no mouth at all, so this
      // is the one liberty taken, and it is kept quiet to match the face.
      const mx = (EYE_L + EYE_R) / 2 + eyeX * 0.4;
      const my = MOUTH_Y + eyeY * 0.4;
      fx.beginPath();
      fx.arc(mx, my - 16, 40 * (p.s * 0.3 + 0.7), Math.PI * 0.2, Math.PI * 0.8);
      fx.stroke();
    }
    fx.shadowBlur = 0;
    faceTex.needsUpdate = true;
  }
  drawFace(0, 0, 1);

  /* ---- rig ------------------------------------------------------------- */

  const joint = (parent, x, y, z) => {
    const g = new THREE.Group();
    g.position.set(x, y, z);
    parent.add(g);

    return g;
  };

  const put = (parent, geo, mat, x, y, z, sx, sy, sz) => {
    const m = new THREE.Mesh(geo, mat);
    m.position.set(x, y, z);
    if (sx !== undefined) m.scale.set(sx, sy, sz);
    parent.add(m);

    return m;
  };

  /*
   * Proportions measured off a frame of the film rather than guessed, as
   * fractions of standing height — this is what stops it reading as a toy:
   *
   *   head            14%      shoulder line   83%
   *   shoulder span   33%      hip line        54%
   *   waist           17%
   *
   * Standing height is 2.9 units, so: hips 1.57, shoulders 2.42, head top 2.9.
   * The suit is flat front-to-back and wide across — a plated chest, not a
   * barrel. Scaling Z below 1 on every torso mass is most of that.
   */
  const root = new THREE.Group();
  scene.add(root);

  const hips = joint(root, 0, 1.57, 0);

  // --- pelvis: narrow, dark, with a plated belt
  put(hips, new THREE.SphereGeometry(0.19, 24, 16), DARK, 0, -0.02, 0, 1.35, 0.85, 0.8);
  put(hips, new THREE.BoxGeometry(0.42, 0.12, 0.26), TRIM, 0, -0.1, 0.01);
  put(hips, new THREE.BoxGeometry(0.2, 0.14, 0.1), SHELL, 0, -0.06, 0.14);

  // --- torso: a dark core with white plates laid over the front of it
  const chest = joint(hips, 0, 0.1, 0);

  // the ribcage, wide and shallow, and white — the suit reads light
  put(chest, new THREE.CapsuleGeometry(0.2, 0.34, 8, 22), SHELL, 0, 0.3, 0, 1.55, 1, 0.78);
  // dark panels down each flank, which is where the film puts its shadow
  for (const s of [-1, 1]) {
    put(chest, new THREE.CapsuleGeometry(0.075, 0.32, 6, 14), DARK, s * 0.29, 0.3, 0, 1, 1, 0.72);
  }
  // waist, pinched and dark
  put(chest, new THREE.CapsuleGeometry(0.15, 0.14, 8, 18), DARK, 0, 0.06, 0, 1.25, 1, 0.8);
  // the chest plates — two slabs angled off the centre line, the V of the suit
  for (const s of [-1, 1]) {
    const plate = put(chest, new THREE.BoxGeometry(0.15, 0.32, 0.09), SHELL, s * 0.105, 0.36, 0.135);
    plate.rotation.z = -s * 0.16;
    plate.rotation.y = -s * 0.22;
  }
  // sternum
  put(chest, new THREE.BoxGeometry(0.09, 0.36, 0.1), SHELL, 0, 0.34, 0.16);
  // abdominal segments, stacked
  for (let i = 0; i < 3; i++) {
    put(chest, new THREE.BoxGeometry(0.26 - i * 0.03, 0.055, 0.13), TRIM, 0, 0.14 - i * 0.075, 0.11);
  }
  // upper back
  put(chest, new THREE.BoxGeometry(0.42, 0.32, 0.08), SHELL, 0, 0.36, -0.13);

  // --- neck + head
  const neck = joint(chest, 0, 0.63, 0);
  put(neck, new THREE.CylinderGeometry(0.062, 0.078, 0.1, 16), TRIM, 0, 0, 0);

  const head = joint(neck, 0, 0.16, 0);
  // helmet: a touch taller than wide, and flattened at the back
  put(head, new THREE.SphereGeometry(0.155, 28, 22), SHELL, 0, 0, -0.012, 1, 1.28, 1.06);

  /*
   * The visor.
   *
   * SphereGeometry's phi runs from -X, not from +Z — a patch built at phi 0
   * lands on the side of the head, which is exactly where this one was until
   * it was measured. Centring it on the face means starting a quarter turn
   * round.
   */
  // Wide enough that the face is still readable at full yaw — a narrower
  // patch edges out of view exactly when he turns to look at you.
  const VIS_PHI = Math.PI * 0.86;
  const visor = put(
    head,
    new THREE.SphereGeometry(0.152, 28, 22, Math.PI / 2 - VIS_PHI / 2, VIS_PHI, Math.PI * 0.3, Math.PI * 0.34),
    // Matched to the helmet's own scale, or the patch swells past it and the
    // whole head goes black.
    VISOR, 0, 0, -0.012, 1.06, 1.3, 1.14
  );
  visor.renderOrder = 1;
  // the seam down the middle of the visor, as in the film
  put(head, new THREE.BoxGeometry(0.011, 0.1, 0.012), TRIM, 0, 0.012, 0.176);
  // the ear housings either side
  for (const s of [-1, 1]) {
    put(head, new THREE.CapsuleGeometry(0.026, 0.05, 4, 10), TRIM, s * 0.152, 0.0, -0.01)
      .rotation.z = Math.PI / 2;
  }

  // the glowing face, floating just in front of the visor
  const face = new THREE.Mesh(
    new THREE.PlaneGeometry(0.21, 0.21),
    new THREE.MeshBasicMaterial({ map: faceTex, transparent: true, depthWrite: false, blending: THREE.AdditiveBlending })
  );
  face.position.set(0, 0.012, 0.182);
  face.renderOrder = 2;
  head.add(face);

  // --- arms
  const arms = [];
  for (const side of [-1, 1]) {
    const shoulder = joint(chest, side * 0.315, 0.5, 0);
    // pauldron, sitting on the shoulder line rather than floating beside it
    put(shoulder, new THREE.SphereGeometry(0.105, 20, 16), SHELL, side * 0.015, 0.005, 0, 1, 0.82, 0.95);

    const upper = joint(shoulder, 0, -0.04, 0);
    put(upper, new THREE.CapsuleGeometry(0.058, 0.2, 6, 14), SHELL, 0, -0.14, 0);
    put(upper, new THREE.CapsuleGeometry(0.052, 0.05, 6, 12), DARK, 0, -0.27, 0);

    const elbow = joint(upper, 0, -0.31, 0);
    const fore = joint(elbow, 0, 0, 0);
    put(fore, new THREE.CapsuleGeometry(0.05, 0.19, 6, 14), SHELL, 0, -0.13, 0);
    put(fore, new THREE.BoxGeometry(0.07, 0.12, 0.06), TRIM, 0, -0.2, 0.02);

    const wrist = joint(fore, 0, -0.28, 0);
    put(wrist, new THREE.BoxGeometry(0.075, 0.1, 0.045), DARK, 0, -0.05, 0);
    // four fingers and a thumb, enough that the hand reads as a hand
    for (let f = 0; f < 4; f++) {
      put(wrist, new THREE.CapsuleGeometry(0.011, 0.045, 4, 8), DARK, -0.027 + f * 0.018, -0.125, 0.004);
    }
    put(wrist, new THREE.CapsuleGeometry(0.012, 0.035, 4, 8), DARK, side * 0.04, -0.09, 0.012);

    arms.push({ side, shoulder, elbow, wrist });
  }

  // --- legs: 54% of the body, so they are long
  for (const side of [-1, 1]) {
    const hip = joint(hips, side * 0.125, -0.12, 0);
    // thigh: white plate over a dark core
    put(hip, new THREE.CapsuleGeometry(0.088, 0.36, 8, 16), SHELL, 0, -0.26, 0);
    put(hip, new THREE.CapsuleGeometry(0.05, 0.3, 6, 12), DARK, side * 0.06, -0.26, -0.04);

    const knee = joint(hip, 0, -0.58, 0);
    put(knee, new THREE.SphereGeometry(0.072, 16, 12), TRIM, 0, 0, 0);
    put(knee, new THREE.CapsuleGeometry(0.062, 0.3, 8, 16), DARK, 0, -0.22, 0);
    put(knee, new THREE.BoxGeometry(0.11, 0.32, 0.07), SHELL, 0, -0.2, 0.05);

    const ankle = joint(knee, 0, -0.5, 0);
    // boot
    put(ankle, new THREE.BoxGeometry(0.115, 0.1, 0.15), DARK, 0, -0.03, 0.01);
    put(ankle, new THREE.BoxGeometry(0.125, 0.055, 0.28), DARK, 0, -0.075, 0.06);
  }

  /* ---- pointer --------------------------------------------------------- */

  // Tracked across the whole window, not just the canvas: the robot is at the
  // side of a hero and should notice you reading the copy beside him.
  const aim = { x: 0, y: 0 };
  window.addEventListener('pointermove', (e) => {
    aim.x = (e.clientX / window.innerWidth) * 2 - 1;
    aim.y = (e.clientY / window.innerHeight) * 2 - 1;
    lastMove = performance.now();
  }, { passive: true });

  let lastMove = 0;

  /* ---- loop ------------------------------------------------------------ */

  let onScreen = true;
  if ('IntersectionObserver' in window) {
    new IntersectionObserver(([e]) => { onScreen = e.isIntersecting; }, { threshold: 0 }).observe(mount);
  }

  const resize = () => {
    camera.aspect = boxW() / boxH();
    camera.updateProjectionMatrix();
    renderer.setSize(boxW(), boxH());
  };
  window.addEventListener('resize', resize);
  if ('ResizeObserver' in window) new ResizeObserver(resize).observe(mount);

  const lerp = THREE.MathUtils.lerp;
  const clamp = THREE.MathUtils.clamp;

  // Everything eased toward a target rather than snapped, so a flick of the
  // mouse is followed rather than teleported to.
  const cur = { headY: 0, headX: 0, chestY: 0, eyeX: 0, eyeY: 0, open: 1, sway: 0 };
  let t = 0, blink = 0, nextBlink = 2.5;

  const clock = new THREE.Clock();

  function frame() {
    requestAnimationFrame(frame);
    if (!onScreen) return;

    const dt = Math.min(clock.getDelta(), 0.05);
    t += dt;

    // Idle after a few seconds of stillness: he stops staring and looks around.
    const idle = performance.now() - lastMove > 3200 || reduce;
    const ax = idle ? Math.sin(t * 0.42) * 0.5 : aim.x;
    const ay = idle ? Math.sin(t * 0.31) * 0.25 - 0.1 : aim.y;

    cur.headY = lerp(cur.headY, -ax * 0.48, 0.09);
    cur.headX = lerp(cur.headX, ay * 0.34, 0.09);
    cur.chestY = lerp(cur.chestY, -ax * 0.16, 0.05);
    cur.eyeX = lerp(cur.eyeX, -ax * 26, 0.14);
    cur.eyeY = lerp(cur.eyeY, ay * 16, 0.14);

    head.rotation.y = cur.headY;
    head.rotation.x = cur.headX;
    chest.rotation.y = cur.chestY;
    hips.rotation.y = cur.chestY * 0.35;

    // Breathing, and a slow shift of weight from one foot to the other.
    const breath = Math.sin(t * 1.15) * 0.008;
    chest.position.y = 0.12 + breath;
    cur.sway = lerp(cur.sway, Math.sin(t * 0.5) * 0.03, 0.05);
    root.position.x = cur.sway;
    root.rotation.z = cur.sway * 0.14;

    // Blink.
    blink += dt;
    if (blink > nextBlink) {
      const p = (blink - nextBlink) / 0.13;
      cur.open = p < 1 ? Math.abs(1 - p * 2) : 1;
      if (p >= 1) { blink = 0; nextBlink = 2 + Math.random() * 3.5; }
    }
    drawFace(cur.eyeX, cur.eyeY, cur.open);

    // The arms. The one on the pointer's side reaches for it; the other stays
    // near the body. Shoulder, elbow and wrist all move, so the hand arrives
    // at the target instead of the whole arm swinging as one plank.
    for (const arm of arms) {
      // -1..1 of how much this arm is the near one.
      const near = clamp(ax * arm.side * 1.6, -0.4, 1);
      const reach = idle ? 0 : Math.max(0, near);
      const lift = idle ? 0 : clamp(-ay, -0.3, 1);

      const swing = -reach * 1.15 - lift * 0.35;
      const out = arm.side * (0.14 + reach * 0.42);

      arm.shoulder.rotation.x = lerp(arm.shoulder.rotation.x, swing + Math.sin(t * 1.15 + arm.side) * 0.02, 0.07);
      arm.shoulder.rotation.z = lerp(arm.shoulder.rotation.z, out, 0.07);
      arm.elbow.rotation.x = lerp(arm.elbow.rotation.x, -0.22 - reach * 0.85, 0.07);
      arm.wrist.rotation.x = lerp(arm.wrist.rotation.x, -reach * 0.4, 0.07);
      arm.wrist.rotation.z = lerp(arm.wrist.rotation.z, -arm.side * reach * 0.3, 0.07);
    }

    renderer.render(scene, camera);
  }
  frame();

  mount.classList.add('is-live');
}
