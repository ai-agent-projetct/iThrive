/**
 * OriginKit Interactive Droplets WebGL Component
 * Exact raymarched liquid distance field with exponential smooth minimum & quintic 3D noise
 * Reference: https://www.originkit.dev/components/interactive-droplets?preset=base
 */

import * as THREE from '/assets/vendor/three/three.module.js';

const MAX_TRAIL = 20;
const IDLE_DELAY = 0.6; // Seconds before idle drift initiates

// Default OriginKit "base" configuration
const DEFAULT_PRESET = {
  droplet: '#968BA1',
  sheen: '#BFBFC5',
  trail: 20,
  dropSize: 7,
  merge: 6,
  lag: 10,
  idleOn: true,
  idle: { speed: 8, spread: 10 },
  restOn: true,
  rest: { x: 74, y: 65, size: 4 },
  shimmer: 20,
  glow: 3,
  contrast: 18,
  sizePercent: 160
};

export const DROPLET_PRESETS = {
  base: {
    label: 'Base (Pearl Sheen)',
    droplet: '#968BA1',
    sheen: '#BFBFC5',
    trail: 20,
    dropSize: 7,
    merge: 6,
    lag: 10,
    idleOn: true,
    idle: { speed: 8, spread: 10 },
    restOn: true,
    rest: { x: 74, y: 65, size: 4 },
    shimmer: 20,
    glow: 3,
    contrast: 18,
    sizePercent: 160
  },
  react: {
    label: 'React Brand (Cyan // Violet)',
    droplet: '#00D8FF',
    sheen: '#7C3AED',
    trail: 20,
    dropSize: 8,
    merge: 7,
    lag: 12,
    idleOn: true,
    idle: { speed: 9, spread: 11 },
    restOn: true,
    rest: { x: 72, y: 62, size: 4 },
    shimmer: 22,
    glow: 3,
    contrast: 18,
    sizePercent: 165
  },
  mint: {
    label: 'Cyber Mint // Cyan',
    droplet: '#00FF9D',
    sheen: '#00F2FE',
    trail: 20,
    dropSize: 7,
    merge: 6,
    lag: 11,
    idleOn: true,
    idle: { speed: 8, spread: 10 },
    restOn: true,
    rest: { x: 74, y: 65, size: 4 },
    shimmer: 20,
    glow: 3,
    contrast: 18,
    sizePercent: 160
  },
  silver: {
    label: 'Liquid Chrome // Silver',
    droplet: '#E2E8F0',
    sheen: '#94A3B8',
    trail: 20,
    dropSize: 7,
    merge: 6,
    lag: 10,
    idleOn: true,
    idle: { speed: 7, spread: 9 },
    restOn: true,
    rest: { x: 74, y: 65, size: 4 },
    shimmer: 18,
    glow: 2,
    contrast: 18,
    sizePercent: 160
  },
  ember: {
    label: 'Volcanic Lava // Ember',
    droplet: '#FF4500',
    sheen: '#FFA500',
    trail: 20,
    dropSize: 8,
    merge: 7,
    lag: 11,
    idleOn: true,
    idle: { speed: 8, spread: 11 },
    restOn: true,
    rest: { x: 72, y: 65, size: 4 },
    shimmer: 22,
    glow: 3,
    contrast: 18,
    sizePercent: 160
  }
};

function clamp(v, min, max, fallback) {
  const n = typeof v === 'number' && isFinite(v) ? v : fallback;
  return Math.max(min, Math.min(max, n));
}

function computeUniformsConfig(cfg) {
  const idle = cfg.idle || DEFAULT_PRESET.idle;
  const rest = cfg.rest || DEFAULT_PRESET.rest;

  return {
    count: clamp(cfg.trail, 1, MAX_TRAIL, DEFAULT_PRESET.trail),
    head: 0.03 + clamp(cfg.dropSize, 1, 20, DEFAULT_PRESET.dropSize) * 0.0075,
    blend: 2 + (21 - clamp(cfg.merge, 1, 20, DEFAULT_PRESET.merge)) * 0.6,
    lagRate: 2 + clamp(cfg.lag, 1, 20, DEFAULT_PRESET.lag) * 1.2,
    shimmer: clamp(cfg.shimmer, 0, 20, DEFAULT_PRESET.shimmer) * 0.05,
    intensity: (10 + clamp(cfg.glow, 1, 10, DEFAULT_PRESET.glow)) * 0.19,
    contrast: 1 + clamp(cfg.contrast, 1, 20, DEFAULT_PRESET.contrast) * 0.5,
    idleRate: clamp(idle.speed, 1, 20, DEFAULT_PRESET.idle.speed) * 0.09,
    idleSpread: clamp(idle.spread, 1, 20, DEFAULT_PRESET.idle.spread) * 0.055,
    restRadius: 0.15 + clamp(rest.size, 1, 20, DEFAULT_PRESET.rest.size) * 0.0285,
    restX: clamp(rest.x, 0, 100, DEFAULT_PRESET.rest.x) / 50 - 1,
    restY: 1 - clamp(rest.y, 0, 100, DEFAULT_PRESET.rest.y) / 50,
    zoom: 100 / clamp(cfg.sizePercent, 20, 300, DEFAULT_PRESET.sizePercent)
  };
}

const VERTEX_SHADER = `
varying vec2 vUv;
void main() {
    vUv = uv;
    gl_Position = vec4(position.xy, 0.0, 1.0);
}
`;

const FRAGMENT_SHADER = `
precision highp float;

#define MAX_TRAIL 20
#define EPS 1e-4
#define DETAIL 5.0

varying vec2 vUv;

uniform float uTime;
uniform vec2 uAspect;
uniform float uZoom;
uniform vec2 uTrail[MAX_TRAIL];
uniform float uCount;
uniform float uHead;
uniform float uBlend;
uniform float uRestOn;
uniform vec2 uRestPos;
uniform float uRestRadius;
uniform vec3 uDroplet;
uniform vec3 uSheen;
uniform float uIntensity;
uniform float uContrast;

float rnd3D(vec3 p) {
    return fract(sin(dot(p, vec3(12.9898, 78.233, 37.719))) * 43758.5453123);
}

float noise3D(vec3 p) {
    vec3 i = floor(p);
    vec3 f = fract(p);
    // Quintic interpolation to prevent visible cell creases
    vec3 u = f * f * f * (f * (f * 6.0 - 15.0) + 10.0);

    float a000 = rnd3D(i);
    float a100 = rnd3D(i + vec3(1.0, 0.0, 0.0));
    float a010 = rnd3D(i + vec3(0.0, 1.0, 0.0));
    float a110 = rnd3D(i + vec3(1.0, 1.0, 0.0));
    float a001 = rnd3D(i + vec3(0.0, 0.0, 1.0));
    float a101 = rnd3D(i + vec3(1.0, 0.0, 1.0));
    float a011 = rnd3D(i + vec3(0.0, 1.0, 1.0));
    float a111 = rnd3D(i + vec3(1.0, 1.0, 1.0));

    return mix(
        mix(mix(a000, a100, u.x), mix(a010, a110, u.x), u.y),
        mix(mix(a001, a101, u.x), mix(a011, a111, u.x), u.y),
        u.z
    );
}

// Exponential smooth minimum for seamless bead fusion
float smoothMin(float d1, float d2, float k) {
    return -log(exp(-k * d1) + exp(-k * d2)) / k;
}

float sdSphere(vec3 p, vec3 centre, float r) {
    return length(p - centre) - r;
}

float map(vec3 p) {
    float d = 1e5;

    for (int i = 0; i < MAX_TRAIL; i++) {
        if (float(i) >= uCount) break;
        float fi = float(i);
        // Tapering radii toward the tail
        float r = uHead * (uCount - fi) / uCount;
        vec3 centre = vec3(uTrail[i] * uAspect * uZoom, 0.0);
        d = smoothMin(d, sdSphere(p, centre, r), uBlend);
    }

    if (uRestOn > 0.5) {
        vec3 centre = vec3(uRestPos * uAspect * uZoom, 0.0);
        d = smoothMin(d, sdSphere(p, centre, uRestRadius), uBlend);
    }

    return d;
}

vec3 generateNormal(vec3 p) {
    return normalize(vec3(
        map(p + vec3(EPS, 0.0, 0.0)) - map(p + vec3(-EPS, 0.0, 0.0)),
        map(p + vec3(0.0, EPS, 0.0)) - map(p + vec3(0.0, -EPS, 0.0)),
        map(p + vec3(0.0, 0.0, EPS)) - map(p + vec3(0.0, 0.0, -EPS))
    ));
}

vec3 dropletColor(vec3 normal, vec3 rayDir) {
    vec3 reflectDir = reflect(rayDir, normal);
    // Counter-drifting 3D noise fields
    float noisePos = noise3D(reflectDir * DETAIL + uTime);
    float noiseNeg = noise3D(reflectDir * DETAIL - uTime);
    // Normalizing so pow() creates wet specular streaks without blowing out to solid white
    return (uDroplet * noisePos + uSheen * noiseNeg) * 0.5;
}

void main() {
    vec2 p = (vUv * 2.0 - 1.0) * uAspect * uZoom;

    // Orthographic raymarching
    vec3 rayDir = vec3(0.0, 0.0, -1.0);
    vec3 ray = vec3(p, 1.0);

    float dist = 1e5;
    for (int i = 0; i < 32; i++) {
        dist = map(ray);
        ray += rayDir * dist * 0.9;
        if (dist < EPS) break;
        if (ray.z < -2.0) break;
    }

    // Anti-aliased ramped edge
    float a = 1.0 - smoothstep(0.0, 0.006 * uZoom, dist);
    if (a <= 0.0) discard;

    vec3 normal = generateNormal(ray);
    vec3 baseSample = dropletColor(normal, rayDir);
    // Contrast power creates "wet surface with hot streaks"
    vec3 sheenStreak = pow(baseSample, vec3(uContrast)) * uIntensity * 2.5;
    vec3 bodyGlow = mix(uDroplet * 0.25, uSheen * 0.4, clamp(dot(normal, vec3(0.3, 0.3, 0.9)), 0.0, 1.0));
    vec3 col = bodyGlow + sheenStreak;

    gl_FragColor = vec4(col * a, a);
}
`;

export class InteractiveDroplets {
  constructor(container, options = {}) {
    this.container = container;
    this.cfg = { ...DEFAULT_PRESET, ...options };
    this.disposed = false;
    this.frameId = 0;
    this.lastT = performance.now();
    this.time = 0;
    this.idleFor = IDLE_DELAY;
    this.target = new THREE.Vector2(0, 0);

    // Renderer setup
    this.renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true, powerPreference: 'high-performance' });
    this.renderer.setClearColor(0x000000, 0);
    this.renderer.outputColorSpace = THREE.SRGBColorSpace;

    const dom = this.renderer.domElement;
    dom.style.cssText = 'position: absolute; inset: 0; width: 100%; height: 100%; display: block; touch-action: none;';
    this.container.appendChild(dom);

    // Scene & Camera
    this.scene = new THREE.Scene();
    this.camera = new THREE.Camera();

    // Trail nodes initialization
    this.trail = Array.from({ length: MAX_TRAIL }, () => new THREE.Vector2(0, 0));

    const derived = computeUniformsConfig(this.cfg);

    this.uniforms = {
      uTime: { value: 0 },
      uAspect: { value: new THREE.Vector2(1, 1) },
      uZoom: { value: derived.zoom },
      uTrail: { value: this.trail },
      uCount: { value: derived.count },
      uHead: { value: derived.head },
      uBlend: { value: derived.blend },
      uRestOn: { value: this.cfg.restOn ? 1.0 : 0.0 },
      uRestPos: { value: new THREE.Vector2(derived.restX, derived.restY) },
      uRestRadius: { value: derived.restRadius },
      uDroplet: { value: new THREE.Color(this.cfg.droplet) },
      uSheen: { value: new THREE.Color(this.cfg.sheen) },
      uIntensity: { value: derived.intensity },
      uContrast: { value: derived.contrast }
    };

    this.geometry = new THREE.PlaneGeometry(2, 2);
    this.material = new THREE.ShaderMaterial({
      vertexShader: VERTEX_SHADER,
      fragmentShader: FRAGMENT_SHADER,
      uniforms: this.uniforms,
      transparent: true,
      depthTest: false,
      depthWrite: false
    });

    const quad = new THREE.Mesh(this.geometry, this.material);
    quad.frustumCulled = false;
    this.scene.add(quad);

    // Bind event handlers
    this.onPointerMove = this.onPointerMove.bind(this);
    this.onPointerDown = this.onPointerDown.bind(this);

    window.addEventListener('pointermove', this.onPointerMove, { passive: true });
    this.container.addEventListener('pointerdown', this.onPointerDown, { passive: true });

    // Initial size
    this.setSize(this.container.clientWidth || 800, this.container.clientHeight || 600);

    // ResizeObserver
    this.resizeObserver = new ResizeObserver(() => {
      if (this.disposed) return;
      this.setSize(this.container.clientWidth, this.container.clientHeight);
    });
    this.resizeObserver.observe(this.container);

    this.start();
  }

  onPointerMove(e) {
    if (this.disposed) return;
    const rect = this.container.getBoundingClientRect();
    if (rect.width <= 0 || rect.height <= 0) return;

    // Normalizing coordinates
    const nx = ((e.clientX - rect.left) / rect.width) * 2 - 1;
    const ny = -(((e.clientY - rect.top) / rect.height) * 2 - 1);

    this.target.set(nx, ny);
    this.idleFor = 0;
  }

  onPointerDown(e) {
    if (this.disposed) return;
    this.onPointerMove(e);
    this.trail[0].copy(this.target);
  }

  setSize(w, h) {
    if (this.disposed) return;
    const width = Math.max(1, w);
    const height = Math.max(1, h);
    const pr = Math.min(window.devicePixelRatio || 1, 1.5);

    this.renderer.setPixelRatio(pr);
    this.renderer.setSize(width, height, false);

    const minDim = Math.min(width, height);
    this.uniforms.uAspect.value.set(width / minDim, height / minDim);
  }

  setPreset(presetKey) {
    const preset = DROPLET_PRESETS[presetKey];
    if (!preset) return;
    this.updateConfig(preset);
  }

  updateConfig(cfg) {
    if (this.disposed) return;
    this.cfg = { ...this.cfg, ...cfg };
    const derived = computeUniformsConfig(this.cfg);

    this.uniforms.uZoom.value = derived.zoom;
    this.uniforms.uCount.value = derived.count;
    this.uniforms.uHead.value = derived.head;
    this.uniforms.uBlend.value = derived.blend;
    this.uniforms.uRestOn.value = this.cfg.restOn ? 1.0 : 0.0;
    this.uniforms.uRestPos.value.set(derived.restX, derived.restY);
    this.uniforms.uRestRadius.value = derived.restRadius;
    this.uniforms.uDroplet.value.set(this.cfg.droplet);
    this.uniforms.uSheen.value.set(this.cfg.sheen);
    this.uniforms.uIntensity.value = derived.intensity;
    this.uniforms.uContrast.value = derived.contrast;
  }

  toggleIdle(enable) {
    this.cfg.idleOn = enable !== undefined ? enable : !this.cfg.idleOn;
  }

  toggleRest(enable) {
    this.cfg.restOn = enable !== undefined ? enable : !this.cfg.restOn;
    this.uniforms.uRestOn.value = this.cfg.restOn ? 1.0 : 0.0;
  }

  start() {
    this.lastT = performance.now();
    const animate = () => {
      if (this.disposed) return;
      this.frameId = requestAnimationFrame(animate);
      this.step();
    };
    this.frameId = requestAnimationFrame(animate);
  }

  step() {
    if (this.disposed) return;

    const now = performance.now();
    let dt = (now - this.lastT) / 1000;
    this.lastT = now;

    if (!isFinite(dt) || dt < 0) dt = 0;
    if (dt > 0.05) dt = 0.05;

    const derived = computeUniformsConfig(this.cfg);
    this.time += dt * derived.shimmer;
    this.idleFor += dt;

    let tx = this.target.x;
    let ty = this.target.y;

    // Idle drift when cursor settles
    if (this.cfg.idleOn && this.idleFor > IDLE_DELAY) {
      const sec = now / 1000;
      tx += Math.sin(sec * derived.idleRate * 1.7) * derived.idleSpread * 1.3;
      ty += Math.sin(sec * derived.idleRate * 1.1 + 1.3) * derived.idleSpread;
    }

    // Head node eases at double speed for dynamic stretch
    const pHead = 1 - Math.exp(-dt * derived.lagRate * 2.0);
    const pBody = 1 - Math.exp(-dt * derived.lagRate);

    this.trail[0].x += (tx - this.trail[0].x) * pHead;
    this.trail[0].y += (ty - this.trail[0].y) * pHead;

    // Subsequent trail beads interpolate toward predecessor
    for (let i = 1; i < MAX_TRAIL; i++) {
      this.trail[i].lerp(this.trail[i - 1], pBody);
    }

    this.uniforms.uTime.value = this.time;
    this.renderer.render(this.scene, this.camera);
  }

  dispose() {
    this.disposed = true;
    cancelAnimationFrame(this.frameId);
    window.removeEventListener('pointermove', this.onPointerMove);
    this.container.removeEventListener('pointerdown', this.onPointerDown);
    if (this.resizeObserver) this.resizeObserver.disconnect();

    this.geometry.dispose();
    this.material.dispose();
    this.renderer.dispose();

    const dom = this.renderer.domElement;
    if (dom && dom.parentNode) {
      dom.parentNode.removeChild(dom);
    }
  }
}

// Auto-initialize on page load
document.addEventListener('DOMContentLoaded', () => {
  const container = document.getElementById('react-droplets-canvas') ||
                    document.querySelector('[data-originkit="interactive-droplets"]');

  if (!container) return;

  const initialPreset = container.dataset.preset || 'base';
  const instance = new InteractiveDroplets(container, DROPLET_PRESETS[initialPreset] || DEFAULT_PRESET);
  window.interactiveDropletsInstance = instance;

  // Preset buttons handler
  const buttons = document.querySelectorAll('.droplet-preset-btn');
  const chipLabel = document.getElementById('droplet-hud-chip-label');

  buttons.forEach(btn => {
    btn.addEventListener('click', () => {
      buttons.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      const style = btn.dataset.style;
      instance.setPreset(style);

      if (chipLabel && DROPLET_PRESETS[style]) {
        chipLabel.innerHTML = `
          <span class="poc-chip-pulse"></span>
          ORIGINKIT // INTERACTIVE DROPLETS [${DROPLET_PRESETS[style].label.toUpperCase()}]
        `;
      }
    });
  });

  // Mode toggles (Idle & Rest)
  const idleToggle = document.getElementById('droplet-toggle-idle');
  if (idleToggle) {
    idleToggle.addEventListener('click', () => {
      idleToggle.classList.toggle('active');
      const isOn = idleToggle.classList.contains('active');
      instance.toggleIdle(isOn);
      idleToggle.textContent = isOn ? 'Idle Drift: ON' : 'Idle Drift: OFF';
    });
  }

  const restToggle = document.getElementById('droplet-toggle-rest');
  if (restToggle) {
    restToggle.addEventListener('click', () => {
      restToggle.classList.toggle('active');
      const isOn = restToggle.classList.contains('active');
      instance.toggleRest(isOn);
      restToggle.textContent = isOn ? 'Resting Drop: ON' : 'Resting Drop: OFF';
    });
  }
});
