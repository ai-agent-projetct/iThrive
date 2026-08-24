/**
 * The gallery hall — case studies as boards standing in a lit corridor.
 *
 * After wonderland.studio, from frames captured off the live site rather than
 * from memory. What that hall actually is:
 *
 *   - Warm, not cool. Olive-green striated walls, tan stone columns, and a
 *     near-black wet floor. There is no blue in it.
 *   - The work stands on the floor on its own boards, angled toward the
 *     walking line — it is not hung flat on the walls.
 *   - A strip of amber light glows along the bottom edge of every board.
 *   - Trapezoid ceiling fixtures run the length of the hall in a row, and they
 *     are the rhythm that sells the depth.
 *   - The floor mirrors everything, smeared and vertical.
 *   - Heavy warm fog; the far end goes black.
 *
 * One deliberate difference. Wonderland renders its whole page into one WebGL2
 * canvas — measured: the document never scrolls, there are zero <img> elements
 * and the only DOM text is its nav. Here the hall is the presentation and every
 * case study is also real markup behind it. Wonderland can afford to be a
 * texture; the page that carries the proof cannot.
 *
 * Requires three r128, vendored in assets/vendor/three128.
 */

window.ithriveHall = function (mount) {
  if (!mount || mount.dataset.hallReady) return;
  mount.dataset.hallReady = '1';

  const HOST = mount.closest('[data-hall]') || mount;
  const DATA = JSON.parse(HOST.dataset.studies || '[]');
  if (!DATA.length) return;

  const boxW = () => mount.clientWidth || window.innerWidth;
  const boxH = () => mount.clientHeight || window.innerHeight;

  let renderer;
  try {
    renderer = new THREE.WebGLRenderer({ antialias: true, alpha: false, powerPreference: 'high-performance' });
  } catch (e) {
    return; // No WebGL. The list behind this is the page.
  }

  renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 1.75));
  renderer.setSize(boxW(), boxH());
  renderer.outputEncoding = THREE.sRGBEncoding;
  renderer.toneMapping = THREE.ACESFilmicToneMapping;
  renderer.toneMappingExposure = 1.0;
  mount.appendChild(renderer.domElement);

  /* ---- palette, sampled from the reference ------------------------------ */

  const NIGHT = 0x0b0a06;   // the dark the hall fades into
  const OLIVE = 0x24230f;   // striated wall
  const STONE = 0x574c34;   // columns
  const AMBER = 0xffbe1a;   // ceiling fixtures and the strip under each board

  const scene = new THREE.Scene();
  scene.background = new THREE.Color(NIGHT);
  scene.fog = new THREE.Fog(NIGHT, 11, 62);

  const camera = new THREE.PerspectiveCamera(56, boxW() / boxH(), 0.1, 200);

  /* ---- hall ------------------------------------------------------------- */

  const HALL_W = 15;
  const HALL_H = 8.5;
  const STEP = 11;
  const EYE = 2.35;
  const END = -(DATA.length * STEP) - 8;
  const LEN = Math.abs(END) + 40;

  /** Vertical streaks, the way the reference's walls are textured. */
  function wallTexture() {
    const c = document.createElement('canvas');
    c.width = 256; c.height = 512;
    const x = c.getContext('2d');
    x.fillStyle = '#31301c';
    x.fillRect(0, 0, 256, 512);
    for (let i = 0; i < 420; i++) {
      const w = 1 + Math.random() * 3;
      const h = 60 + Math.random() * 380;
      const g = Math.random();
      x.fillStyle = `rgba(${90 + g * 70 | 0},${86 + g * 66 | 0},${38 + g * 30 | 0},${0.06 + Math.random() * 0.2})`;
      x.fillRect(Math.random() * 256, Math.random() * 512 - h / 2, w, h);
    }
    const t = new THREE.CanvasTexture(c);
    t.wrapS = t.wrapT = THREE.RepeatWrapping;
    t.repeat.set(LEN / 9, 1);
    t.encoding = THREE.sRGBEncoding;

    return t;
  }

  const wallMat = new THREE.MeshStandardMaterial({
    map: wallTexture(), color: OLIVE, roughness: 0.95, metalness: 0.02,
  });

  for (const side of [-1, 1]) {
    const wall = new THREE.Mesh(new THREE.PlaneGeometry(LEN, HALL_H), wallMat);
    wall.rotation.y = side * -Math.PI / 2;
    wall.position.set((side * HALL_W) / 2, HALL_H / 2, END / 2);
    scene.add(wall);
  }

  // Wet floor. Low roughness and high metalness is what streaks the boards
  // downward the way standing water does, without a second render pass.
  const floor = new THREE.Mesh(
    new THREE.PlaneGeometry(HALL_W, LEN),
    new THREE.MeshStandardMaterial({ color: 0x070603, roughness: 0.14, metalness: 0.92 })
  );
  floor.rotation.x = -Math.PI / 2;
  floor.position.z = END / 2;
  scene.add(floor);

  const ceiling = new THREE.Mesh(
    new THREE.PlaneGeometry(HALL_W, LEN),
    new THREE.MeshStandardMaterial({ color: 0x14120a, roughness: 0.95 })
  );
  ceiling.rotation.x = Math.PI / 2;
  ceiling.position.set(0, HALL_H, END / 2);
  scene.add(ceiling);

  /* ---- columns ---------------------------------------------------------- */

  const stoneMat = new THREE.MeshStandardMaterial({ color: STONE, roughness: 0.88, metalness: 0.03 });
  const shaft = new THREE.CylinderGeometry(0.46, 0.52, HALL_H - 1.1, 16);
  const cap = new THREE.BoxGeometry(1.5, 0.42, 1.5);

  for (let z = -8 + STEP / 2; z > END; z -= STEP) {
    for (const side of [-1, 1]) {
      const x = side * (HALL_W / 2 - 0.95);
      const col = new THREE.Mesh(shaft, stoneMat);
      col.position.set(x, (HALL_H - 1.1) / 2 + 0.55, z);
      scene.add(col);
      // A capital and a base, or they read as pipes rather than columns.
      for (const y of [HALL_H - 0.21, 0.21]) {
        const block = new THREE.Mesh(cap, stoneMat);
        block.position.set(x, y, z);
        scene.add(block);
      }
    }
  }

  /* ---- ceiling fixtures ------------------------------------------------- */

  // The repeating amber trapezoids are what carry the depth in the reference —
  // remove them and the hall reads as a tube.
  const fixtureMat = new THREE.MeshBasicMaterial({ color: AMBER });
  const fixtureGeo = new THREE.PlaneGeometry(1.9, 0.92);

  for (let z = -2; z > END; z -= STEP / 2) {
    const fx = new THREE.Mesh(fixtureGeo, fixtureMat);
    fx.rotation.x = Math.PI / 2;
    fx.position.set(0, HALL_H - 0.08, z);
    scene.add(fx);

    const glow = new THREE.PointLight(AMBER, 0.62, 11, 2);
    glow.position.set(0, HALL_H - 0.7, z);
    scene.add(glow);
  }

  scene.add(new THREE.AmbientLight(0x2a2614, 0.42));

  /* ---- the work --------------------------------------------------------- */

  function makePlate(study, logoImg) {
    const W = 760, H = 500;
    const c = document.createElement('canvas');
    c.width = W; c.height = H;
    const x = c.getContext('2d');

    x.fillStyle = '#0e0d09';
    x.fillRect(0, 0, W, H);
    const g = x.createLinearGradient(0, 0, W, H);
    g.addColorStop(0, study.accent + '40');
    g.addColorStop(1, '#0e0d09');
    x.fillStyle = g;
    x.fillRect(0, 0, W, H);

    if (logoImg) {
      const s = Math.min(260 / logoImg.naturalWidth, 96 / logoImg.naturalHeight);
      const lw = logoImg.naturalWidth * s, lh = logoImg.naturalHeight * s;
      x.fillStyle = '#F4F6FA';
      x.beginPath();
      x.roundRect(48, 46, lw + 36, lh + 36, 14);
      x.fill();
      x.drawImage(logoImg, 66, 64, lw, lh);
    }

    x.fillStyle = 'rgba(255,255,255,.98)';
    x.font = '700 46px Outfit, Segoe UI, sans-serif';
    x.fillText(study.client, 48, 282);

    x.fillStyle = 'rgba(232,226,206,.82)';
    x.font = '400 26px Outfit, Segoe UI, sans-serif';
    wrap(x, study.headline, 48, 332, W - 96, 35, 3);

    x.fillStyle = study.accent;
    x.font = '700 19px Outfit, Segoe UI, sans-serif';
    x.fillText(String(study.industry || '').toUpperCase().slice(0, 40), 48, H - 40);

    const tex = new THREE.CanvasTexture(c);
    tex.encoding = THREE.sRGBEncoding;
    tex.anisotropy = 8;

    return tex;
  }

  function wrap(ctx, text, x0, y0, maxW, lh, maxLines) {
    const words = String(text).split(' ');
    let line = '', y = y0, n = 0;
    for (const w of words) {
      const next = line ? line + ' ' + w : w;
      if (ctx.measureText(next).width > maxW && line) {
        ctx.fillText(line, x0, y);
        line = w; y += lh;
        if (++n >= maxLines - 1) break;
      } else line = next;
    }
    ctx.fillText(line, x0, y);
  }

  /* ---- boards ----------------------------------------------------------- */

  const frames = [];
  const BW = 4.5, BH = 2.95;       // the artwork itself
  const BASE_Y = 0.42;             // the board stands on the floor

  const woodMat = new THREE.MeshStandardMaterial({ color: 0x4a3b26, roughness: 0.72, metalness: 0.08 });
  const stripMat = new THREE.MeshBasicMaterial({ color: 0xff8c1a });

  DATA.forEach((study, i) => {
    const side = i % 2 === 0 ? -1 : 1;
    const z = -10 - i * STEP;
    const accent = new THREE.Color(study.accent);

    const group = new THREE.Group();
    group.position.set(side * 4.1, 0, z);
    // Angled in toward the middle of the hall, the way the reference's boards
    // face whoever is walking rather than sitting flat against a wall.
    group.rotation.y = side * 0.42;
    scene.add(group);

    const frameH = BH + 0.55;
    const surround = new THREE.Mesh(new THREE.BoxGeometry(BW + 0.55, frameH, 0.22), woodMat);
    surround.position.y = BASE_Y + frameH / 2;
    group.add(surround);

    const plate = new THREE.Mesh(
      new THREE.PlaneGeometry(BW, BH),
      new THREE.MeshBasicMaterial({ color: 0x2a2a2a })
    );
    plate.position.set(0, BASE_Y + frameH / 2 + 0.08, 0.13);
    group.add(plate);

    const paint = (img) => {
      plate.material.map = makePlate(study, img);
      plate.material.color.set(0xffffff);
      plate.material.needsUpdate = true;
    };
    if (study.logo) {
      const img = new Image();
      img.decoding = 'async';
      img.onload = () => paint(img);
      img.onerror = () => paint(null);
      img.src = study.logo;
    } else paint(null);

    // The amber strip along the bottom edge — the detail that makes these read
    // as lit exhibits rather than posters.
    const strip = new THREE.Mesh(new THREE.PlaneGeometry(BW + 0.4, 0.09), stripMat);
    strip.position.set(0, BASE_Y + 0.06, 0.14);
    group.add(strip);

    const stripLight = new THREE.PointLight(0xff8c1a, 2.2, 9, 2);
    stripLight.position.set(0, BASE_Y + 0.3, 0.9);
    group.add(stripLight);

    // Feet.
    for (const fx of [-1, 1]) {
      const foot = new THREE.Mesh(new THREE.BoxGeometry(0.5, BASE_Y, 1.1), woodMat);
      foot.position.set(fx * (BW / 2 - 0.2), BASE_Y / 2, 0);
      group.add(foot);
    }

    // What the wet floor throws back: the plate again, upside down, dimmed and
    // stretched. Cheaper than a mirror pass and reads the same at this angle.
    const echo = new THREE.Mesh(
      new THREE.PlaneGeometry(BW, BH),
      new THREE.MeshBasicMaterial({ color: accent, transparent: true, opacity: 0.1, side: THREE.DoubleSide })
    );
    echo.position.set(0, -(BASE_Y + frameH / 2) + 0.05, 0.13);
    echo.scale.y = -1.45;
    group.add(echo);

    // A wash of the client's colour on the wall behind its board.
    const lamp = new THREE.PointLight(accent, 0, 20, 2);
    lamp.position.set(0, BASE_Y + frameH / 2, 1.6);
    group.add(lamp);

    frames.push({ group, plate, lamp, stripLight, study, z, lit: 0 });
  });

  /* ---- scroll ----------------------------------------------------------- */

  let camZ = 0, onScreen = true, lastP = -1;

  function progress() {
    const r = HOST.getBoundingClientRect();
    const range = r.height - window.innerHeight;

    return range <= 0 ? 0 : Math.min(1, Math.max(0, -r.top / range));
  }

  /* ---- pointer ---------------------------------------------------------- */

  const ray = new THREE.Raycaster();
  const ndc = new THREE.Vector2(-2, -2);
  let hovered = null;
  const tip = HOST.querySelector('[data-hall-tip]');

  // The pickable set, built once. A board is picked by its plate — the artwork
  // face — so the surround, the feet and the glow strip are not click targets.
  const plates = frames.map((f) => f.plate);
  const byPlate = new Map(frames.map((f) => [f.plate, f]));

  /** Which board is under a point on the canvas, right now. */
  function pick() {
    // lookAt sets the rotation but the world matrix is only rebuilt at render,
    // so without this the ray is cast from where the camera was last frame.
    camera.updateMatrixWorld();
    ray.setFromCamera(ndc, camera);
    const hits = ray.intersectObjects(plates, false);

    return hits.length ? byPlate.get(hits[0].object) : null;
  }

  renderer.domElement.addEventListener('pointermove', (e) => {
    const r = renderer.domElement.getBoundingClientRect();
    ndc.x = ((e.clientX - r.left) / r.width) * 2 - 1;
    ndc.y = -((e.clientY - r.top) / r.height) * 2 + 1;
    if (tip) {
      tip.style.left = (e.clientX - r.left) + 'px';
      tip.style.top = (e.clientY - r.top) + 'px';
    }
  });
  renderer.domElement.addEventListener('pointerleave', () => ndc.set(-2, -2));

  /**
   * The click casts its own ray instead of trusting the last drawn frame.
   *
   * The camera is still easing toward the scroll position, so the board under
   * the cursor when the frame was drawn is not always the board under it when
   * the click lands — clicking a board you could plainly see highlighted would
   * miss, intermittently, depending only on how long the pointer had been
   * still. Casting here, against the camera as it is at this instant, makes the
   * click land on what is actually under it.
   */
  renderer.domElement.addEventListener('click', () => {
    const hit = pick();
    if (hit) window.location.href = hit.study.href;
  });

  /* ---- loop ------------------------------------------------------------- */

  function frame() {
    requestAnimationFrame(frame);
    if (!onScreen) return;

    // The walk, published to CSS so the title over the hall can fade out as you
    // step into it. Written only when it actually moves, because setting a
    // custom property invalidates style every time it is touched.
    const p = progress();
    if (Math.abs(p - lastP) > 0.002) {
      lastP = p;
      HOST.style.setProperty('--hall-p', p.toFixed(3));
    }

    camZ += (p * END - camZ) * 0.085;
    camera.position.set(0, EYE, camZ + 8);
    camera.lookAt(0, EYE - 0.1, camZ - 12);

    const now = pick();

    if (now !== hovered) {
      hovered = now;
      renderer.domElement.style.cursor = hovered ? 'pointer' : 'default';
      if (tip) {
        tip.hidden = !hovered;
        if (hovered) tip.textContent = hovered.study.client + ' — open case study';
      }
    }

    for (const f of frames) {
      const near = Math.max(0, 1 - Math.abs(camZ - f.z) / (STEP * 2.2));
      const want = near * (f === hovered ? 1.8 : 1);
      f.lit += (want - f.lit) * 0.1;
      f.lamp.intensity = f.lit * 5;
      f.stripLight.intensity = 1.1 + f.lit * 2.2;
    }

    renderer.render(scene, camera);
  }

  if ('IntersectionObserver' in window) {
    new IntersectionObserver(([e]) => { onScreen = e.isIntersecting; }, { threshold: 0 }).observe(HOST);
  }

  window.addEventListener('resize', () => {
    camera.aspect = boxW() / boxH();
    camera.updateProjectionMatrix();
    renderer.setSize(boxW(), boxH());
  });
  if ('ResizeObserver' in window) {
    new ResizeObserver(() => window.dispatchEvent(new Event('resize'))).observe(mount);
  }

  HOST.classList.add('hall--live');
  requestAnimationFrame(frame);
};
