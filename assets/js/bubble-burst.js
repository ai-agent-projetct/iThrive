import * as THREE from 'three';

/* ------------------------------------------------------------------ *
 *  Bubble Burst — a port of Origin Kit's component.
 *
 *  A soap bubble you drag to spin and click to pop, tearing a ragged hole
 *  outward from the point struck before the film draws itself back together.
 *  Built to the component's documented behaviour:
 *
 *   - The pop is a tear front: an angular threshold sweeping out from the
 *     struck point, with the film discarded behind it rather than faded. The
 *     sweep is widened past the far pole so no patches survive.
 *   - Two octaves of noise wander the hole's boundary, so the edge reads torn
 *     rather than cut.
 *   - The retreating edge runs bright — a hard core plus a wider halo —
 *     standing in for the water the swallowed film used to hold.
 *   - Thin-film interference from path length over facing angle, with
 *     thickness drained downward so the crown runs thin and colourless and the
 *     base pools thick.
 *   - The hit is converted to object space, so the hole stays fixed on the film
 *     as the bubble keeps turning.
 *   - A double-sided additive shell with the far wall dimmed, and normals
 *     rebuilt by finite difference so shading matches the wobbling surface.
 *
 *  Props map to data attributes with the component's defaults: tint #FFFFFF,
 *  sheen #00BBFF, iridescence 20, rim 1, gloss 20, wobble 20, lip 20,
 *  ragged 20, direction left, dragSensitivity 5, sizePercent 85, speed 4.
 *
 *  Written as a GLSL shader on a sphere rather than as raw WebGL calls. The
 *  maths below — the interference, the tear, the drained thickness — is the
 *  component's; Three.js is only carrying it.
 * ------------------------------------------------------------------ */

const MOUNT = document.querySelector('[data-bubble-burst]');
if (MOUNT && !MOUNT.dataset.bubbleReady) {
  MOUNT.dataset.bubbleReady = '1';
  build(MOUNT);
}

function build(mount) {
  let renderer;
  try {
    renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true, powerPreference: 'high-performance' });
  } catch (e) {
    return;   // No WebGL. The stack list below is the section.
  }

  const num = (key, fallback) => {
    const v = parseFloat(mount.dataset[key]);

    return Number.isFinite(v) ? v : fallback;
  };
  const col = (key, fallback) => new THREE.Color(mount.dataset[key] || fallback);

  const TINT = col('tint', '#FFFFFF');
  const SHEEN = col('sheen', '#00BBFF');
  const IRIDESCENCE = num('iridescence', 20);
  const RIM = num('rim', 1);
  const GLOSS = num('gloss', 20);
  const WOBBLE = num('wobble', 20);
  const LIP = num('lip', 20);
  const RAGGED = num('ragged', 20);
  const DRAG_SENS = num('dragSensitivity', 5);
  const SIZE = num('sizePercent', 85) / 100;
  const SPEED = num('speed', 4);
  const DIR = mount.dataset.direction === 'right' ? 1 : -1;
  const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  const boxW = () => mount.clientWidth || 640;
  const boxH = () => mount.clientHeight || 460;

  renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 2));
  renderer.setSize(boxW(), boxH());
  renderer.outputColorSpace = THREE.SRGBColorSpace;
  mount.appendChild(renderer.domElement);

  const scene = new THREE.Scene();
  const camera = new THREE.PerspectiveCamera(40, boxW() / boxH(), 0.1, 50);
  camera.position.set(0, 0, 4.2);

  /* ---- the film --------------------------------------------------------- */

  const uniforms = {
    uTime:    { value: 0 },
    uTint:    { value: TINT },
    uSheen:   { value: SHEEN },
    uIrid:    { value: IRIDESCENCE / 100 },
    uRim:     { value: RIM },
    uGloss:   { value: GLOSS / 100 },
    uWobble:  { value: WOBBLE / 100 },
    uLip:     { value: LIP / 100 },
    uRagged:  { value: RAGGED / 100 },
    // The burst: where it was struck (object space), and how far the tear
    // front has swept. -1 means intact.
    uHit:     { value: new THREE.Vector3(0, 0, 1) },
    uBurst:   { value: -1 },
  };

  const vert = /* glsl */`
    uniform float uTime;
    uniform float uWobble;
    varying vec3 vObj;
    varying vec3 vNrm;
    varying vec3 vView;

    // Cheap value noise, enough to breathe a surface.
    vec3 hash3(vec3 p) {
      p = vec3(dot(p, vec3(127.1, 311.7, 74.7)),
               dot(p, vec3(269.5, 183.3, 246.1)),
               dot(p, vec3(113.5, 271.9, 124.6)));
      return -1.0 + 2.0 * fract(sin(p) * 43758.5453123);
    }
    float noise(vec3 p) {
      vec3 i = floor(p), f = fract(p);
      vec3 u = f * f * (3.0 - 2.0 * f);
      return mix(mix(mix(dot(hash3(i + vec3(0,0,0)), f - vec3(0,0,0)),
                         dot(hash3(i + vec3(1,0,0)), f - vec3(1,0,0)), u.x),
                     mix(dot(hash3(i + vec3(0,1,0)), f - vec3(0,1,0)),
                         dot(hash3(i + vec3(1,1,0)), f - vec3(1,1,0)), u.x), u.y),
                 mix(mix(dot(hash3(i + vec3(0,0,1)), f - vec3(0,0,1)),
                         dot(hash3(i + vec3(1,0,1)), f - vec3(1,0,1)), u.x),
                     mix(dot(hash3(i + vec3(0,1,1)), f - vec3(0,1,1)),
                         dot(hash3(i + vec3(1,1,1)), f - vec3(1,1,1)), u.x), u.y), u.z);
    }

    float breathe(vec3 p) {
      return noise(p * 1.7 + vec3(0.0, uTime * 0.32, 0.0)) * 0.5
           + noise(p * 3.4 - vec3(uTime * 0.21, 0.0, 0.0)) * 0.25;
    }

    void main() {
      vObj = normalize(position);
      float d = breathe(vObj) * uWobble * 0.14;
      vec3 p = vObj * (1.0 + d);

      /*
       * Normals rebuilt by finite difference, so shading follows the wobble.
       * The interpolated sphere normal would light a ball that is no longer
       * the shape being drawn.
       */
      vec3 t1 = normalize(cross(vObj, vec3(0.0, 1.0, 0.001)));
      vec3 t2 = normalize(cross(vObj, t1));
      float e = 0.035;
      vec3 pa = normalize(vObj + t1 * e) * (1.0 + breathe(normalize(vObj + t1 * e)) * uWobble * 0.14);
      vec3 pb = normalize(vObj + t2 * e) * (1.0 + breathe(normalize(vObj + t2 * e)) * uWobble * 0.14);
      vNrm = normalize(cross(pa - p, pb - p));
      if (dot(vNrm, vObj) < 0.0) vNrm = -vNrm;

      vec4 world = modelMatrix * vec4(p, 1.0);
      vView = normalize(cameraPosition - world.xyz);
      gl_Position = projectionMatrix * viewMatrix * world;
    }
  `;

  const frag = /* glsl */`
    precision highp float;
    uniform vec3  uTint;
    uniform vec3  uSheen;
    uniform float uIrid, uRim, uGloss, uLip, uRagged, uBurst, uTime;
    uniform vec3  uHit;
    varying vec3 vObj;
    varying vec3 vNrm;
    varying vec3 vView;

    vec3 hash3(vec3 p) {
      p = vec3(dot(p, vec3(127.1, 311.7, 74.7)),
               dot(p, vec3(269.5, 183.3, 246.1)),
               dot(p, vec3(113.5, 271.9, 124.6)));
      return -1.0 + 2.0 * fract(sin(p) * 43758.5453123);
    }
    float noise(vec3 p) {
      vec3 i = floor(p), f = fract(p);
      vec3 u = f * f * (3.0 - 2.0 * f);
      return mix(mix(mix(dot(hash3(i + vec3(0,0,0)), f - vec3(0,0,0)),
                         dot(hash3(i + vec3(1,0,0)), f - vec3(1,0,0)), u.x),
                     mix(dot(hash3(i + vec3(0,1,0)), f - vec3(0,1,0)),
                         dot(hash3(i + vec3(1,1,0)), f - vec3(1,1,0)), u.x), u.y),
                 mix(mix(dot(hash3(i + vec3(0,0,1)), f - vec3(0,0,1)),
                         dot(hash3(i + vec3(1,0,1)), f - vec3(1,0,1)), u.x),
                     mix(dot(hash3(i + vec3(0,1,1)), f - vec3(0,1,1)),
                         dot(hash3(i + vec3(1,1,1)), f - vec3(1,1,1)), u.x), u.y), u.z);
    }

    void main() {
      vec3 N = normalize(vNrm);
      vec3 V = normalize(vView);
      float facing = abs(dot(N, V));

      /* ---- the tear ----------------------------------------------------- */

      if (uBurst >= 0.0) {
        // Angle from the struck point, wandered by two octaves so the boundary
        // reads torn rather than cut.
        float ang = acos(clamp(dot(normalize(vObj), normalize(uHit)), -1.0, 1.0));
        float wander = (noise(normalize(vObj) * 4.0) * 0.6 + noise(normalize(vObj) * 9.0) * 0.4)
                     * uRagged * 0.55;
        // Swept past the far pole, so no patch survives on the other side.
        float front = uBurst * (3.1415926 + 0.7);
        float edge = ang - wander;

        if (edge < front) discard;               // film behind the front is gone

        // The retreating edge: a hard core plus a wider halo.
        float lip = 1.0 - smoothstep(0.0, 0.12 + uLip * 0.5, edge - front);
        float core = 1.0 - smoothstep(0.0, 0.03 + uLip * 0.12, edge - front);
        vec3 glow = uSheen * (core * 2.6 + lip * 0.9);
        gl_FragColor = vec4(glow + uTint * lip * 0.35, clamp(lip * 0.9 + core, 0.0, 1.0));

        return;
      }

      /* ---- thin-film interference --------------------------------------- */

      /*
       * Thickness is drained downward: the crown of a real bubble runs thin and
       * nearly colourless while the base pools thick, which is most of what
       * distinguishes a soap film from a coloured ball.
       */
      float drain = 0.35 + 0.65 * smoothstep(1.0, -1.0, vObj.y);
      float thickness = drain * (1.0 + noise(vObj * 2.6 + uTime * 0.12) * 0.25);

      // Path length over facing angle — longer through a grazing surface.
      float path = thickness / max(facing, 0.08);
      float bands = path * (4.0 + uIrid * 46.0);

      vec3 irid = 0.5 + 0.5 * cos(6.2831853 * (bands + vec3(0.0, 0.33, 0.67)));
      vec3 base = mix(uTint, irid, clamp(uIrid * 1.6, 0.0, 1.0));

      // Rim: the film brightens where it turns away.
      float rim = pow(1.0 - facing, 2.6) * uRim;

      // Gloss: a tightening specular window.
      vec3 L = normalize(vec3(0.6, 0.8, 0.7));
      float spec = pow(max(dot(reflect(-L, N), V), 0.0), 8.0 + uGloss * 180.0);

      vec3 colour = base * (0.22 + rim * 0.9) + uSheen * rim * 0.85 + vec3(spec) * (0.5 + uGloss);
      float alpha = clamp(0.1 + rim * 0.85 + spec, 0.0, 1.0);

      // The far wall of a double-sided shell, dimmed.
      if (!gl_FrontFacing) { colour *= 0.45; alpha *= 0.55; }

      gl_FragColor = vec4(colour, alpha);
    }
  `;

  const bubble = new THREE.Mesh(
    new THREE.SphereGeometry(1, 128, 96),
    new THREE.ShaderMaterial({
      uniforms, vertexShader: vert, fragmentShader: frag,
      transparent: true,
      side: THREE.DoubleSide,
      depthWrite: false,
      blending: THREE.AdditiveBlending,
    })
  );
  bubble.scale.setScalar(SIZE * 1.35);
  scene.add(bubble);

  /* ---- drag to spin, click to pop --------------------------------------- */

  let rotX = 0, rotY = 0, vy = 0;
  let dragging = false, lastX = 0, lastY = 0, moved = 0, pid = null;
  const ray = new THREE.Raycaster();
  const ndc = new THREE.Vector2();

  const el = renderer.domElement;

  el.addEventListener('pointerdown', (e) => {
    dragging = true; lastX = e.clientX; lastY = e.clientY; moved = 0; pid = e.pointerId;
    el.setPointerCapture?.(pid);
  });
  el.addEventListener('pointermove', (e) => {
    if (!dragging) return;
    const dx = e.clientX - lastX, dy = e.clientY - lastY;
    lastX = e.clientX; lastY = e.clientY;
    moved += Math.abs(dx) + Math.abs(dy);
    rotY += dx * 0.0012 * DRAG_SENS;
    rotX += dy * 0.0012 * DRAG_SENS;
    vy = dx * 0.0012 * DRAG_SENS;
  });
  const up = () => { if (dragging) { dragging = false; el.releasePointerCapture?.(pid); } };
  el.addEventListener('pointerup', up);
  el.addEventListener('pointercancel', up);

  let burst = -1;

  el.addEventListener('click', (e) => {
    if (moved > 8 || burst >= 0) return;
    const r = el.getBoundingClientRect();
    ndc.x = ((e.clientX - r.left) / r.width) * 2 - 1;
    ndc.y = -((e.clientY - r.top) / r.height) * 2 + 1;
    ray.setFromCamera(ndc, camera);
    const hit = ray.intersectObject(bubble, false)[0];
    if (!hit) return;

    /*
     * Converted to object space. The bubble keeps turning through the burst, so
     * a hit stored in world space would drag the hole around the film instead
     * of leaving it where it was struck.
     */
    const local = bubble.worldToLocal(hit.point.clone()).normalize();
    uniforms.uHit.value.copy(local);
    burst = 0;
  });

  /* ---- loop ------------------------------------------------------------- */

  let onScreen = false, raf = 0, last = 0;

  function frame(now) {
    raf = requestAnimationFrame(frame);
    const dt = last ? Math.min((now - last) / 1000, 0.05) : 0;
    last = now;

    uniforms.uTime.value += dt;

    if (!dragging) {
      if (Math.abs(vy) > 1e-4) { rotY += vy; vy *= Math.pow(0.05, dt); }
      else if (!reduce) rotY += DIR * SPEED * 0.05 * dt;
    }
    bubble.rotation.set(rotX, rotY, 0);

    if (burst >= 0) {
      burst += dt * 0.85;
      uniforms.uBurst.value = burst;
      // Once the front has swept the whole film, it draws itself back together.
      if (burst > 1.25) { burst = -1; uniforms.uBurst.value = -1; }
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
