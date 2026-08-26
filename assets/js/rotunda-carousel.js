import * as THREE from 'three';

/* ------------------------------------------------------------------ *
 *  Rotunda Carousel — a port of Origin Kit's component.
 *
 *  The camera sits inside a cylinder of panels, so dragging sweeps the curved
 *  wall past the viewer rather than spinning a drum in front of them. Built to
 *  the component's documented behaviour:
 *
 *   - The camera is strictly inside the ring, so nothing on the wall can
 *     occlude anything else: no depth test, no sorting, no face culling.
 *   - Dragging inverts the projection. The pointer ray is un-pitched and
 *     re-intersected with the cylinder on every move, so the wall point you
 *     grabbed stays pinned under the cursor instead of scrubbing at a fixed
 *     rate — which is what makes it feel like a wall rather than a slider.
 *   - Ring radius is derived from the panels: R = n × (width + gap) / 2π, so
 *     panel proportions stay the picture's aspect and gaps show background
 *     rather than the far wall.
 *   - Each panel's texture is resampled into a power-of-two canvas for mipmaps
 *     and anisotropic filtering, so panels near the silhouette do not smear.
 *   - Flick velocity is floored on frame time and capped, so a high-polling
 *     pointer cannot launch the ring into dozens of turns a second.
 *
 *  Props map to data attributes with the component's defaults: panelWidth 2000,
 *  panelHeight 1340, gap 0, rounded 3, distance 90, tilt 0, speed 100,
 *  background #0B0A10.
 *
 *  The difference, again: the panels are drawn from this section's own copy
 *  rather than being photographs, and every one is real markup underneath.
 * ------------------------------------------------------------------ */

const MOUNT = document.querySelector('[data-rotunda]');
if (MOUNT && !MOUNT.dataset.rotundaReady) {
  MOUNT.dataset.rotundaReady = '1';
  build(MOUNT);
}

function build(mount) {
  const items = Array.from(mount.querySelectorAll('[data-rotunda-panel]'));
  if (items.length < 3) return;

  let renderer;
  try {
    renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true, powerPreference: 'high-performance' });
  } catch (e) {
    return;
  }

  const num = (key, fallback) => {
    const v = parseFloat(mount.dataset[key]);

    return Number.isFinite(v) ? v : fallback;
  };

  const PANEL_W = num('panelWidth', 2000) / 1000;    // to world units
  const PANEL_H = num('panelHeight', 1340) / 1000;
  const GAP = num('gap', 0) / 1000;
  const ROUNDED = num('rounded', 3);
  const DISTANCE = num('distance', 90) / 100;
  const TILT = num('tilt', 0) * Math.PI / 180;
  const SPEED = num('speed', 100);
  const DAMPING = num('damping', 92) / 100;
  const HOVER_SLOW = num('hoverSlow', 80) / 100;
  const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  const boxW = () => mount.clientWidth || 800;
  const boxH = () => mount.clientHeight || 460;

  renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 2));
  renderer.setSize(boxW(), boxH());
  renderer.outputColorSpace = THREE.SRGBColorSpace;
  mount.appendChild(renderer.domElement);

  const scene = new THREE.Scene();
  const camera = new THREE.PerspectiveCamera(54, boxW() / boxH(), 0.01, 100);

  /* ---- the ring --------------------------------------------------------- */

  const n = items.length;
  // R = n × (width + gap) / 2π — the component's own derivation.
  const R = (n * (PANEL_W + GAP)) / (Math.PI * 2);

  const ring = new THREE.Group();
  scene.add(ring);

  /*
   * Power-of-two canvases, so mipmaps and anisotropy are available. A
   * non-power-of-two texture silently loses both in WebGL, and the panels near
   * the silhouette — the ones seen most obliquely — are exactly where that
   * shows as smearing.
   */
  function pot(v) { return Math.pow(2, Math.round(Math.log2(v))); }

  function panelTexture(el, i) {
    const W = pot(1024), H = pot(688);
    const c = document.createElement('canvas');
    c.width = W; c.height = H;
    const x = c.getContext('2d');

    const accent = el.dataset.accent || '#03D1F5';
    const r = (ROUNDED / 100) * Math.min(W, H) * 0.5;

    x.fillStyle = '#0C1220';
    x.beginPath(); x.roundRect(0, 0, W, H, r); x.fill();

    const g = x.createLinearGradient(0, 0, W, H);
    g.addColorStop(0, accent + '38');
    g.addColorStop(1, 'rgba(11,10,16,0)');
    x.fillStyle = g;
    x.beginPath(); x.roundRect(0, 0, W, H, r); x.fill();

    x.strokeStyle = 'rgba(255,255,255,.16)';
    x.lineWidth = 3;
    x.beginPath(); x.roundRect(2, 2, W - 4, H - 4, r); x.stroke();

    x.fillStyle = accent;
    x.font = '700 30px Outfit, Segoe UI, sans-serif';
    x.fillText(String(i + 1).padStart(2, '0'), 64, 96);

    x.fillStyle = '#FFFFFF';
    x.font = '700 54px Outfit, Segoe UI, sans-serif';
    wrap(x, el.dataset.title || '', 64, 190, W - 128, 64, 2);

    x.fillStyle = 'rgba(226,233,246,.74)';
    x.font = '400 30px Outfit, Segoe UI, sans-serif';
    wrap(x, el.dataset.body || '', 64, 340, W - 128, 44, 5);

    const t = new THREE.CanvasTexture(c);
    t.colorSpace = THREE.SRGBColorSpace;
    t.generateMipmaps = true;
    t.minFilter = THREE.LinearMipmapLinearFilter;
    t.anisotropy = renderer.capabilities.getMaxAnisotropy();

    return t;
  }

  function wrap(x, text, left, top, width, lh, maxLines) {
    const words = String(text).split(/\s+/);
    let line = '', y = top, k = 0;
    for (const w of words) {
      const test = line ? line + ' ' + w : w;
      if (x.measureText(test).width > width && line) {
        x.fillText(line, left, y); y += lh;
        if (++k >= maxLines - 1) { line = w; break; }
        line = w;
      } else { line = test; }
    }
    if (line) {
      let out = line;
      while (x.measureText(out + '…').width > width && out.length > 4) out = out.slice(0, -1);
      x.fillText(out === line ? out : out + '…', left, y);
    }
  }

  const geo = new THREE.PlaneGeometry(PANEL_W, PANEL_H, 12, 1);

  items.forEach((el, i) => {
    const mesh = new THREE.Mesh(geo, new THREE.MeshBasicMaterial({
      map: panelTexture(el, i),
      transparent: true,
      // Inside the ring nothing can occlude anything, so all three are off —
      // exactly what the component relies on.
      side: THREE.DoubleSide,
      depthTest: false,
      depthWrite: false,
    }));
    const a = (i / n) * Math.PI * 2;
    mesh.position.set(Math.sin(a) * R, 0, Math.cos(a) * R);
    mesh.lookAt(0, 0, 0);       // faces the camera at the centre
    mesh.userData.index = i;
    ring.add(mesh);
  });

  // The viewpoint backs away from the axis; at 0 the wall wraps evenly.
  camera.position.set(0, 0, R * DISTANCE * 0.42);
  camera.rotation.x = TILT;

  /* ---- drag: invert the projection -------------------------------------- */

  /**
   * The angle on the cylinder wall under a pointer position.
   *
   * This is the whole trick. Rather than turning the ring by some multiple of
   * the cursor's travel, the ray through the cursor is intersected with the
   * cylinder and the angle of that hit is taken; the difference between where
   * you grabbed and where you are now is exactly how far the wall must turn to
   * keep the grabbed point under the cursor.
   */
  const _ray = new THREE.Raycaster();
  const _ndc = new THREE.Vector2();

  function wallAngle(clientX, clientY) {
    const rect = renderer.domElement.getBoundingClientRect();
    _ndc.x = ((clientX - rect.left) / rect.width) * 2 - 1;
    _ndc.y = -((clientY - rect.top) / rect.height) * 2 + 1;
    _ray.setFromCamera(_ndc, camera);

    // Un-pitch: solve in the XZ plane, so a tilted view still grabs correctly.
    const o = _ray.ray.origin, d = _ray.ray.direction;
    const a = d.x * d.x + d.z * d.z;
    if (a < 1e-6) return null;
    const b = 2 * (o.x * d.x + o.z * d.z);
    const c = o.x * o.x + o.z * o.z - R * R;
    const disc = b * b - 4 * a * c;
    if (disc < 0) return null;

    // From inside the cylinder there is exactly one forward hit.
    const t = (-b + Math.sqrt(disc)) / (2 * a);
    if (t <= 0) return null;

    return Math.atan2(o.x + d.x * t, o.z + d.z * t);
  }

  let rot = 0, vel = 0;
  let dragging = false, grabAngle = 0, grabRot = 0, moved = 0, lastX = 0, captured = false, pid = null;
  let hovering = false, onScreen = false, raf = 0, last = 0;

  renderer.domElement.addEventListener('pointerdown', (e) => {
    const a = wallAngle(e.clientX, e.clientY);
    if (a === null) return;
    dragging = true;
    grabAngle = a;
    grabRot = rot;
    moved = 0;
    lastX = e.clientX;
    captured = false;
    pid = e.pointerId;
    vel = 0;
    mount.classList.add('is-grabbing');
  });

  renderer.domElement.addEventListener('pointermove', (e) => {
    hovering = true;
    if (!dragging) return;

    moved += Math.abs(e.clientX - lastX);
    lastX = e.clientX;
    if (!captured && moved > 6) {
      captured = true;
      renderer.domElement.setPointerCapture?.(pid);
    }

    const a = wallAngle(e.clientX, e.clientY);
    if (a === null) return;

    const prev = rot;
    // Pin the grabbed wall point under the cursor.
    rot = grabRot + (a - grabAngle);
    vel = rot - prev;
  });

  function release() {
    if (!dragging) return;
    dragging = false;
    if (captured) { renderer.domElement.releasePointerCapture?.(pid); captured = false; }
    mount.classList.remove('is-grabbing');
  }
  renderer.domElement.addEventListener('pointerup', release);
  renderer.domElement.addEventListener('pointercancel', release);
  renderer.domElement.addEventListener('pointerleave', () => { hovering = false; release(); });

  /* ---- loop ------------------------------------------------------------- */

  const MAX_VEL = 0.22;   // radians a frame — the cap the component describes

  function frame(now) {
    raf = requestAnimationFrame(frame);
    const dt = last ? Math.min((now - last) / 1000, 0.05) : 0;
    last = now;

    if (!dragging) {
      if (Math.abs(vel) > 1e-4) {
        // Floored on frame time and capped, so a 1000Hz pointer cannot launch
        // the ring into dozens of turns per second.
        const v = Math.max(-MAX_VEL, Math.min(MAX_VEL, vel));
        rot += v * (dt / 0.0166);
        vel *= Math.pow(DAMPING, dt / 0.0166);
      } else if (!reduce && SPEED) {
        // Resting the pointer on the wall slows the drift so a panel can be read.
        rot += SPEED * 0.00016 * (hovering ? 1 - HOVER_SLOW : 1) * (dt / 0.0166);
      }
    }

    ring.rotation.y = rot;
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
