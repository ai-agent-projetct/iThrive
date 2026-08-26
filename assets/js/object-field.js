import * as THREE from 'three';

/* ------------------------------------------------------------------ *
 *  The object field.
 *
 *  lusion.co's signature: a loose cluster of identical solids — six-armed
 *  jacks — tumbling inside a rounded stage, in a palette of white, grey,
 *  near-black and one saturated blue. Nothing about it is a diagram; it is a
 *  material study, and that is why it reads as a studio rather than a chart.
 *
 *  Rebuilt here rather than mimicked with CSS, because the whole effect is
 *  specular: the light rolls across a curved glossy surface as the piece turns,
 *  and a flat shape cannot do that.
 *
 *  Two things drive it. Scroll turns the whole cluster, so the field is tied to
 *  where you are on the page rather than running on a timer. The pointer pushes
 *  the nearest pieces aside, which is what makes it feel like objects rather
 *  than a video.
 *
 *  Every piece is the same two geometries instanced by reuse, so a field of
 *  twenty is still two buffers on the GPU.
 * ------------------------------------------------------------------ */

const MOUNT = document.querySelector('[data-object-field]');
if (MOUNT && !MOUNT.dataset.fieldReady) {
  MOUNT.dataset.fieldReady = '1';
  build(MOUNT);
}

function build(mount) {
  let renderer;
  try {
    renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true, powerPreference: 'high-performance' });
  } catch (e) {
    return;   // No WebGL. The section reads perfectly well without it.
  }

  const boxW = () => mount.clientWidth || 640;
  const boxH = () => mount.clientHeight || 480;

  renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 1.9));
  renderer.setSize(boxW(), boxH());
  renderer.outputColorSpace = THREE.SRGBColorSpace;
  renderer.toneMapping = THREE.ACESFilmicToneMapping;
  renderer.toneMappingExposure = 1.05;
  mount.appendChild(renderer.domElement);

  const scene = new THREE.Scene();
  const camera = new THREE.PerspectiveCamera(38, boxW() / boxH(), 0.1, 100);
  camera.position.set(0, 0, 15);

  /* ---- materials: the logo's own gradient ------------------------------ */

  /*
   * Sampled from assets/img/logo-mark.png rather than borrowed from the
   * reference: the mark runs bright cyan through two blues into violet. The
   * reference's navy, white and black are its brand, not ours, so the cluster
   * walks the logo instead.
   */
  const mats = [0x03D1F5, 0x2FA8E8, 0x0B6CD4, 0x0940C4, 0x4A3AE8, 0x7D42F4].map(
    (color) => new THREE.MeshPhysicalMaterial({
      color, roughness: 0.23, metalness: 0.1, clearcoat: 0.95, clearcoatRoughness: 0.12,
    })
  );

  /* ---- lighting -------------------------------------------------------- */

  const key = new THREE.DirectionalLight(0xffffff, 3.1);
  key.position.set(4, 7, 6);
  scene.add(key);

  const fill = new THREE.DirectionalLight(0x6fa8ff, 1.5);
  fill.position.set(-6, -2, 4);
  scene.add(fill);

  const rim = new THREE.DirectionalLight(0x9ecdff, 2.2);
  rim.position.set(-3, 4, -7);
  scene.add(rim);

  scene.add(new THREE.HemisphereLight(0xbcd4ff, 0x0a0d16, 0.7));

  /* ---- the jack -------------------------------------------------------- */

  // One arm, reused six times per piece and shared across every piece: two
  // geometries total on the GPU no matter how many are on screen.
  const armGeo = new THREE.CylinderGeometry(0.3, 0.3, 1.5, 20, 1, false);
  const capGeo = new THREE.SphereGeometry(0.3, 20, 14);

  function jack(mat) {
    const g = new THREE.Group();
    // Three cylinders through the origin on X, Y and Z gives the six arms.
    for (const axis of ['x', 'y', 'z']) {
      const arm = new THREE.Mesh(armGeo, mat);
      if (axis === 'x') arm.rotation.z = Math.PI / 2;
      if (axis === 'z') arm.rotation.x = Math.PI / 2;
      g.add(arm);
      for (const s of [-1, 1]) {
        const cap = new THREE.Mesh(capGeo, mat);
        cap.position[axis] = s * 0.75;
        g.add(cap);
      }
    }

    return g;
  }

  /* ---- the cluster ----------------------------------------------------- */

  const cluster = new THREE.Group();
  scene.add(cluster);

  const COUNT = 19;
  const pieces = [];

  for (let i = 0; i < COUNT; i++) {
    const mat = mats[i % mats.length];
    const piece = jack(mat);

    // Fibonacci placement in a squashed ball — even coverage, no clumping, and
    // no two runs looking different because there is no randomness in it.
    const t = (i + 0.5) / COUNT;
    const inc = Math.acos(1 - 2 * t);
    const az = Math.PI * (1 + Math.sqrt(5)) * i;
    const r = 3.1 + (i % 3) * 0.72;

    const home = new THREE.Vector3(
      Math.sin(inc) * Math.cos(az) * r * 1.45,
      Math.sin(inc) * Math.sin(az) * r * 0.92,
      Math.cos(inc) * r
    );
    piece.position.copy(home);

    const s = 0.62 + (i % 4) * 0.12;
    piece.scale.setScalar(s);
    piece.rotation.set(az, inc, t * 6.2);

    cluster.add(piece);
    pieces.push({
      piece,
      home,
      offset: new THREE.Vector3(),
      spin: new THREE.Vector3((i % 5 - 2) * 0.06, (i % 3 - 1) * 0.08, (i % 4 - 1.5) * 0.05),
    });
  }

  /* ---- pointer --------------------------------------------------------- */

  /*
   * Tracked on the window, not on the mount.
   *
   * The field sits at z-index -1 behind the section's own content, so the cards
   * and the copy swallow every pointer event before the canvas ever sees one —
   * listening on the element meant the cluster almost never reacted. The
   * position is converted through the mount's own rect instead.
   */
  const aim = new THREE.Vector2(0, 0);
  let pointerIn = false;

  window.addEventListener('pointermove', (e) => {
    const r = mount.getBoundingClientRect();
    aim.x = ((e.clientX - r.left) / r.width) * 2 - 1;
    aim.y = -((e.clientY - r.top) / r.height) * 2 + 1;
    // A margin either side, so the cluster starts reacting just before the
    // cursor crosses into the section rather than snapping on at the edge.
    pointerIn = aim.x > -1.35 && aim.x < 1.35 && aim.y > -1.35 && aim.y < 1.35;
  }, { passive: true });

  /* ---- loop ------------------------------------------------------------ */

  const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  let onScreen = false, raf = 0, last = 0;
  const _v = new THREE.Vector3();
  const _target = new THREE.Vector3();
  const _invQ = new THREE.Quaternion();

  function progress() {
    const r = mount.getBoundingClientRect();
    const range = window.innerHeight + r.height;

    return range <= 0 ? 0 : Math.min(1, Math.max(0, (window.innerHeight - r.top) / range));
  }

  function frame(now) {
    raf = requestAnimationFrame(frame);
    const dt = last ? Math.min((now - last) / 1000, 0.05) : 0;
    last = now;

    // Scroll turns the whole cluster; the pieces keep their own slow tumble.
    const p = progress();
    cluster.rotation.y = -0.9 + p * 1.8;
    cluster.rotation.x = -0.25 + p * 0.5;
    // Setting .rotation does not refresh .quaternion on its own, and the push
    // maths below reads the quaternion.
    cluster.quaternion.setFromEuler(cluster.rotation);

    for (const it of pieces) {
      if (!reduce) {
        it.piece.rotation.x += it.spin.x * dt;
        it.piece.rotation.y += it.spin.y * dt;
        it.piece.rotation.z += it.spin.z * dt;
      }

      /*
       * Shove away from the pointer, then ease back.
       *
       * Measured where the cursor actually is — on screen. The piece is
       * projected to normalised device coordinates and compared with the
       * pointer there, so "near the cursor" means near it in the picture rather
       * than near it in a rotating local space the viewer cannot see. The push
       * is then taken back through the camera and through the cluster's own
       * rotation, or a spinning cluster would scatter its pieces sideways.
       */
      _target.set(0, 0, 0);
      if (pointerIn) {
        _v.copy(it.home).applyQuaternion(cluster.quaternion).project(camera);
        const dx = _v.x - aim.x;
        const dy = (_v.y - aim.y) / Math.max(camera.aspect, 0.0001);
        const d = Math.hypot(dx, dy);
        const RADIUS = 0.42;      // in NDC — a little under half the viewport
        if (d < RADIUS && d > 1e-4) {
          const f = (1 - d / RADIUS) * 2.6;
          _target.set((dx / d) * f, (dy / d) * f, 0)
            .applyQuaternion(camera.quaternion)   // screen push -> world
            .applyQuaternion(_invQ.copy(cluster.quaternion).invert());  // -> local
        }
      }
      it.offset.lerp(_target, 0.12);
      it.piece.position.copy(it.home).add(it.offset);
    }

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
