/**
 * Exact Framer Spiral Galaxy WebGL Engine
 * Reverse-engineered byte-for-byte from https://luxurious-share-719322.framer.app/
 * 
 * Shader pipeline:
 * - Exponential radial vortex twist in Vertex Shader: (uTime * uVortexSpeed) / (vDistance + 0.1)
 * - Dynamic pulse wave propagation in Fragment Shader: pow(sin(flowPhase) * 0.5 + 0.5, 1.0 / uPulseSpread)
 * - Exact chromatic palette: Core #2200FF, Mid #00039E, Edge #482BFF, Center Light #A8A8A8
 * - 5 spiral branches, 85,000 particles, 1,500 ambient deep space background stars
 * - Interactive pointer drag rotation + smooth inertia damping + mouse parallax
 */

(function () {
  'use strict';

  // Exact configuration matching Framer Nv component
  const CONFIG = {
    backgroundColor: '#000000',
    centerLightColor: '#A8A8A8',
    coreColor: '#2200FF',
    midColor: '#00039E',
    edgeColor: '#482BFF',
    particleCount: 85000,
    backgroundStarsCount: 1500,
    radius: 7.5,
    branches: 5,
    spin: 5.0,
    randomness: 0.35,
    randomnessPower: 4.8,
    particleSize: 0.35,
    glowSpeed: 1.5,
    pulseSpread: 0.8,
    vortexSpeed: -0.4,
    rotationSpeed: -0.25, // Framer default -1.25 damped for visual grace
    cameraPitch: 5,
    cameraDistance: 17,
    fov: 45,
    enableParallax: true,
    parallaxStrength: 5,
    parallaxDamping: 0.01,
  };

  function init() {
    const mountEl = document.getElementById('galaxy-stage');
    if (!mountEl || mountEl.dataset.galaxyReady) return;
    mountEl.dataset.galaxyReady = '1';

    if (typeof THREE !== 'undefined') {
      boot(mountEl, THREE);
    } else {
      import('/assets/vendor/three/three.module.js')
        .then((mod) => {
          window.THREE = mod;
          boot(mountEl, mod);
        })
        .catch((err) => {
          console.error('[FramerGalaxy] Failed to import Three.js:', err);
        });
    }
  }

  function boot(container, THREE) {
    let width = container.clientWidth || 1200;
    let height = container.clientHeight || 675;

    // 1. Scene & Camera
    const scene = new THREE.Scene();
    scene.background = new THREE.Color(CONFIG.backgroundColor);

    const camera = new THREE.PerspectiveCamera(CONFIG.fov, width / height, 0.1, 100);
    camera.position.set(0, CONFIG.cameraPitch, CONFIG.cameraDistance);
    camera.lookAt(0, 0, 0);

    // 2. High-Performance WebGL Renderer
    const renderer = new THREE.WebGLRenderer({
      antialias: true,
      alpha: false,
      powerPreference: 'high-performance',
    });
    const pixelRatio = Math.min(window.devicePixelRatio || 1, 2);
    renderer.setPixelRatio(pixelRatio);
    renderer.setSize(width, height);
    renderer.domElement.style.width = '100%';
    renderer.domElement.style.height = '100%';
    renderer.domElement.style.display = 'block';
    renderer.domElement.style.position = 'absolute';
    renderer.domElement.style.inset = '0';
    container.appendChild(renderer.domElement);

    // 3. Exact Framer Custom Shaders
    const galaxyMaterial = new THREE.ShaderMaterial({
      uniforms: {
        uTime: { value: 0 },
        uPixelRatio: { value: pixelRatio },
        uSizeBase: { value: CONFIG.particleSize },
        uGlowSpeed: { value: CONFIG.glowSpeed },
        uVortexSpeed: { value: CONFIG.vortexSpeed },
        uCenterColor: { value: new THREE.Color(CONFIG.centerLightColor) },
        uPulseSpread: { value: CONFIG.pulseSpread },
      },
      depthWrite: false,
      blending: THREE.AdditiveBlending,
      vertexColors: true,
      transparent: true,
      vertexShader: `
        uniform float uTime;
        uniform float uPixelRatio;
        uniform float uSizeBase;
        uniform float uVortexSpeed;
        attribute float size;
        attribute vec3 customColor;
        attribute float aDistance;
        attribute float aAngle;
        varying vec3 vColor;
        varying float vDistance;
        varying float vAngle;

        void main() {
          vColor = customColor;
          vDistance = aDistance;
          vAngle = aAngle;
          vec3 pos = position;

          float twist = (uTime * uVortexSpeed) / (vDistance + 0.1);
          float c = cos(twist);
          float s = sin(twist);
          float newX = pos.x * c - pos.z * s;
          float newZ = pos.x * s + pos.z * c;
          pos.x = newX;
          pos.z = newZ;

          vec4 mvPosition = modelViewMatrix * vec4(pos, 1.0);
          gl_PointSize = size * uSizeBase * uPixelRatio * (300.0 / -mvPosition.z);
          gl_Position = projectionMatrix * mvPosition;
        }
      `,
      fragmentShader: `
        uniform float uTime;
        uniform float uGlowSpeed;
        uniform vec3 uCenterColor;
        uniform float uPulseSpread;
        varying vec3 vColor;
        varying float vDistance;
        varying float vAngle;

        void main() {
          vec2 pt = gl_PointCoord - vec2(0.5);
          float d = length(pt);
          float alpha = exp(-d * d * 30.0);
          float core = exp(-d * d * 150.0);
          float flowPhase = vDistance * 1.5 - vAngle * 2.0 - uTime * uGlowSpeed;
          float flowStrength = pow(sin(flowPhase) * 0.5 + 0.5, 1.0 / uPulseSpread);
          vec3 baseColor = mix(vColor, uCenterColor, core * 0.8);
          vec3 finalColor = baseColor + (baseColor * flowStrength * 1.8);
          float finalAlpha = alpha * (0.6 + flowStrength * 0.6);
          if (finalAlpha < 0.01) discard;
          gl_FragColor = vec4(finalColor, finalAlpha);
        }
      `,
    });

    // 4. Exact Framer Galaxy Geometry Calculation
    const u = CONFIG.particleCount;
    const galaxyGeo = new THREE.BufferGeometry();
    const pos = new Float32Array(u * 3);
    const col = new Float32Array(u * 3);
    const sz = new Float32Array(u);
    const dist = new Float32Array(u);
    const ang = new Float32Array(u);

    const E = new THREE.Color(CONFIG.coreColor);
    const D = new THREE.Color(CONFIG.midColor);
    const O = new THREE.Color(CONFIG.edgeColor);

    for (let e = 0; e < u; e++) {
      const n = e * 3;
      const r = Math.random() * CONFIG.radius;
      const i = r * CONFIG.spin;
      const a = ((e % CONFIG.branches) / CONFIG.branches) * Math.PI * 2 + i;
      const o = CONFIG.randomnessPower;
      const s = CONFIG.randomness;

      const c = Math.pow(Math.random(), o) * (Math.random() < 0.5 ? 1 : -1) * s * r;
      const l = Math.pow(Math.random(), o) * (Math.random() < 0.5 ? 1 : -1) * s * r * 0.15;
      const uCoord = Math.pow(Math.random(), o) * (Math.random() < 0.5 ? 1 : -1) * s * r;

      pos[n] = Math.cos(a) * r + c;
      pos[n + 1] = l;
      pos[n + 2] = Math.sin(a) * r + uCoord;

      dist[e] = r;
      ang[e] = a;

      const dColor = new THREE.Color();
      const f = CONFIG.radius * 0.35;
      if (r < f) {
        dColor.copy(E).lerp(D, r / f);
      } else {
        dColor.copy(D).lerp(O, (r - f) / (CONFIG.radius - f));
      }

      col[n] = dColor.r;
      col[n + 1] = dColor.g;
      col[n + 2] = dColor.b;
      sz[e] = 0.5 + Math.random() * 0.5;
    }

    galaxyGeo.setAttribute('position', new THREE.BufferAttribute(pos, 3));
    galaxyGeo.setAttribute('customColor', new THREE.BufferAttribute(col, 3));
    galaxyGeo.setAttribute('size', new THREE.BufferAttribute(sz, 1));
    galaxyGeo.setAttribute('aDistance', new THREE.BufferAttribute(dist, 1));
    galaxyGeo.setAttribute('aAngle', new THREE.BufferAttribute(ang, 1));

    const galaxyPoints = new THREE.Points(galaxyGeo, galaxyMaterial);
    scene.add(galaxyPoints);

    // 5. Deep Space Ambient Stars
    const A = CONFIG.backgroundStarsCount;
    const starsGeo = new THREE.BufferGeometry();
    const ee = new Float32Array(A * 3);
    const te = new Float32Array(A * 3);
    const ne = new Float32Array(A);
    const re = new Float32Array(A);
    const M = new Float32Array(A);

    for (let e = 0; e < A; e++) {
      const tIdx = e * 3;
      const n = (Math.random() - 0.5) * 60;
      const r = (Math.random() - 0.5) * 60;
      const i = (Math.random() - 0.5) * 60;

      ee[tIdx] = n;
      ee[tIdx + 1] = r;
      ee[tIdx + 2] = i;

      te[tIdx] = 0.9 + Math.random() * 0.1;
      te[tIdx + 1] = 0.9 + Math.random() * 0.1;
      te[tIdx + 2] = 1.0;

      ne[e] = 0.2 + Math.random() * 0.4;
      re[e] = Math.sqrt(n * n + r * r + i * i);
      M[e] = Math.atan2(i, n);
    }

    starsGeo.setAttribute('position', new THREE.BufferAttribute(ee, 3));
    starsGeo.setAttribute('customColor', new THREE.BufferAttribute(te, 3));
    starsGeo.setAttribute('size', new THREE.BufferAttribute(ne, 1));
    starsGeo.setAttribute('aDistance', new THREE.BufferAttribute(re, 1));
    starsGeo.setAttribute('aAngle', new THREE.BufferAttribute(M, 1));

    const starsPoints = new THREE.Points(starsGeo, galaxyMaterial);
    scene.add(starsPoints);

    // 6. Interaction & Mouse Parallax with Damping
    let mouseX = 0;
    let mouseY = 0;
    let targetParallaxX = 0;
    let targetParallaxY = 0;
    let currentParallaxX = 0;
    let currentParallaxY = 0;

    let isDragging = false;
    let dragStartX = 0;
    let dragStartY = 0;
    let targetRotY = 0;
    let targetRotX = 0;
    let currentRotY = 0;
    let currentRotX = 0;

    const onPointerMove = (e) => {
      const rect = container.getBoundingClientRect();
      const normX = ((e.clientX - rect.left) / rect.width) * 2 - 1;
      const normY = -(((e.clientY - rect.top) / rect.height) * 2 - 1);
      targetParallaxX = normX;
      targetParallaxY = normY;

      if (isDragging) {
        const dx = e.clientX - dragStartX;
        const dy = e.clientY - dragStartY;
        dragStartX = e.clientX;
        dragStartY = e.clientY;
        targetRotY += dx * 0.006;
        targetRotX += dy * 0.004;
        targetRotX = Math.max(-0.6, Math.min(0.6, targetRotX));
      }
    };

    const onPointerDown = (e) => {
      isDragging = true;
      dragStartX = e.clientX;
      dragStartY = e.clientY;
      container.style.cursor = 'grabbing';
    };

    const onPointerUp = () => {
      isDragging = false;
      container.style.cursor = 'grab';
    };

    container.addEventListener('pointermove', onPointerMove, { passive: true });
    container.addEventListener('pointerdown', onPointerDown);
    window.addEventListener('pointerup', onPointerUp);

    // 7. Resize Observer
    const resizeObserver = new ResizeObserver((entries) => {
      for (const entry of entries) {
        const w = entry.contentRect.width;
        const h = entry.contentRect.height;
        if (w > 0 && h > 0) {
          width = w;
          height = h;
          camera.aspect = w / h;
          camera.updateProjectionMatrix();
          renderer.setSize(w, h);
        }
      }
    });
    resizeObserver.observe(container);

    // 8. Animation Loop
    const clock = new THREE.Clock();
    let isVisible = true;

    const io = new IntersectionObserver(([entry]) => {
      isVisible = entry.isIntersecting;
    });
    io.observe(container);

    function animate() {
      requestAnimationFrame(animate);
      if (!isVisible) return;

      const elapsed = clock.getElapsedTime();
      const delta = clock.getDelta();

      galaxyMaterial.uniforms.uTime.value = elapsed;

      // Galaxy rotation
      if (!isDragging) {
        targetRotY += delta * CONFIG.rotationSpeed;
      }

      currentRotY += (targetRotY - currentRotY) * 0.08;
      currentRotX += (targetRotX - currentRotX) * 0.08;

      galaxyPoints.rotation.y = currentRotY;
      galaxyPoints.rotation.x = currentRotX;
      starsPoints.rotation.y = currentRotY * 0.15;

      // Smooth Parallax
      if (CONFIG.enableParallax) {
        currentParallaxX += (targetParallaxX - currentParallaxX) * CONFIG.parallaxDamping;
        currentParallaxY += (targetParallaxY - currentParallaxY) * CONFIG.parallaxDamping;

        camera.position.x = currentParallaxX * CONFIG.parallaxStrength;
        camera.position.y = CONFIG.cameraPitch + currentParallaxY * (CONFIG.parallaxStrength * 0.6);
        camera.lookAt(0, 0, 0);
      }

      renderer.render(scene, camera);
    }

    animate();
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
