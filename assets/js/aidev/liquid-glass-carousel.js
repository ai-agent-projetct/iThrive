/**
 * iThrive AI - Liquid Glass Carousel (Framer liquid-glass-carousel-SkrkTr)
 * WebGL / Three.js Optical Shader Engine with Chromatic Dispersion & Fluid Refraction
 * Path: assets/js/liquid-glass-carousel.js
 */

(function () {
  'use strict';

  // Fragment Shader with sdRoundBox, fluid wave refraction, chromatic dispersion, neon blue ring & shimmer
  const fragmentShader = `
    #define PI 3.14159265
    precision highp float;
    varying vec2 vUv;
    uniform sampler2D uTex;
    uniform vec2  uRes;
    uniform vec2  uCenter;
    uniform float uSizeX;
    uniform float uSizeY;
    uniform float uAspect;
    uniform float uZoom;
    uniform float uDispersion;
    uniform float uBlur;
    uniform float uGlow;
    uniform float uWhiteGlow;
    uniform float uNovaSize;
    uniform float uBlueRing;
    uniform float uRingRadius;
    uniform float uRingWidth;
    uniform float uShimmer;
    uniform float uShimmerFreq;
    uniform float uShimmerSpeed;
    uniform float uShimmerDepth;
    uniform float uTime;
    uniform float uRimStart;
    uniform float uRimTangential;
    uniform float uRimInward;
    uniform float uRimFreq1;
    uniform float uRimFreq2;
    uniform vec3  uBlueColor;
    uniform float uRimLine;
    uniform float uRimLinePos;
    uniform float uRimLineWidth;
    uniform float uShape;
    uniform float uSquareRound;
    uniform float uRotation;
    uniform int   uSamples;

    const int MAX_SAMPLES = 16;

    float sdRoundBox(vec2 p, vec2 b, float r) {
        vec2 q = abs(p) - b + r;
        return min(max(q.x, q.y), 0.0) + length(max(q, 0.0)) - r;
    }

    vec3 glassLens(vec2 center, float aspectCorrect, out float outA) {
        vec2 p = vUv - center;
        p.x *= aspectCorrect;
        float ca = cos(uRotation), sa = sin(uRotation);
        p = mat2(ca, -sa, sa, ca) * p;
        vec2 halfSize = vec2(uSizeX, uSizeY);
        float dist = length(p / halfSize);
        outA = 0.0;

        float maskND;
        if (uShape > 0.5) {
            float corner = min(uSizeX, uSizeY) * clamp(uSquareRound, 0.0, 1.0);
            float sd = sdRoundBox(p, halfSize, corner);
            maskND = 1.0 + sd / min(uSizeX, uSizeY);
        } else {
            maskND = dist;
        }

        if (maskND > 1.0) return vec3(0.0);

        float shapeND = clamp(maskND, 0.0, 1.0);
        float nd = clamp(dist, 0.0, 1.0);
        vec2 offset = vUv - center;
        vec2 radialDir = normalize(offset + 1e-6);
        vec2 tangentDir = vec2(-radialDir.y, radialDir.x);
        float angle = atan(p.y, p.x);

        float pull = uZoom * 0.30 * nd * nd;
        float rimStrength = smoothstep(uRimStart, 1.0, nd);
        float fluidWave = sin(angle * uRimFreq1) * 0.55 +
                          sin(angle * uRimFreq2) * 0.25;
        float rScreen = (uSizeX + uSizeY) * 0.5;

        vec2 rimOff = tangentDir * fluidWave * rimStrength *
                      rScreen * uRimTangential;
        vec2 rimPull = -radialDir * rimStrength * rScreen * uRimInward;
        vec2 baseUV = center + offset * (1.0 - pull) + rimOff + rimPull;

        float rimMask = smoothstep(0.55, 1.0, nd);
        vec2 dispDir = offset * uDispersion * 0.004 * rimMask;

        int count = uSamples;
        if (count < 2) count = 2;
        if (count > MAX_SAMPLES) count = MAX_SAMPLES;

        vec3 col = vec3(0.0);
        vec3 caW = vec3(0.0);

        for (int i = 0; i < MAX_SAMPLES; i++) {
            if (i >= count) break;

            float t = float(i) / float(count - 1);
            vec2 sUV = baseUV + dispDir * (t - 0.5);
            vec3 sampleColor = texture2D(uTex, sUV).rgb;

            vec3 weight = vec3(
                exp(-pow((t - 0.00) / 0.38, 2.0)),
                exp(-pow((t - 0.50) / 0.38, 2.0)),
                exp(-pow((t - 1.00) / 0.38, 2.0))
            );

            col += sampleColor * weight;
            caW += weight;
        }

        col /= max(caW, vec3(0.001));

        float blurFade = 1.0 - smoothstep(0.72, 0.98, nd);

        if (uBlur > 0.01 && blurFade > 0.01) {
            vec2 blurRad = vec2(uBlur) / uRes * blurFade;
            vec3 bcol = vec3(0.0);
            float totalWeight = 0.0;

            for (float a = 0.0; a < PI * 2.0; a += PI * 2.0 / 6.0) {
                for (float rr = 0.4; rr <= 1.001; rr += 0.3) {
                    vec2 o = vec2(cos(a), sin(a)) * blurRad * rr;
                    float weight = 1.0 - rr * 0.38;
                    bcol += texture2D(uTex, baseUV + o).rgb * weight;
                    totalWeight += weight;
                }
            }

            col = mix(bcol / totalWeight, col, rimMask);
        }

        col *= mix(0.91, 1.0, smoothstep(0.0, 0.38, shapeND));

        float r2 = shapeND * shapeND * 0.25;
        float gs = max(uNovaSize * uGlow * 0.003, 0.004);
        float nova = exp(-r2 / gs) + exp(-r2 / (gs * 7.0)) * 0.18;

        nova *= uWhiteGlow * (uGlow / 17.0) * 1.15;
        col += vec3(nova);

        float dC = shapeND * 0.5;
        float tR = clamp(uRingRadius, 0.1, 0.49);
        float rW = max(uRingWidth, 0.003);

        float ring = exp(-pow((dC - tR) / rW, 2.0));
        ring *= uBlueRing * (uGlow / 17.0) * 1.8;

        if (uShimmer > 0.5) {
            ring *= sin(angle * uShimmerFreq + uTime * uShimmerSpeed) *
                    uShimmerDepth + (1.0 - uShimmerDepth);
        }

        float aura = exp(-pow((dC - tR) / (rW * 6.0), 2.0)) *
                     0.28 * uBlueRing * (uGlow / 17.0);

        col += uBlueColor * (ring + aura);

        col += vec3(
            exp(
                -pow(
                    (dC - uRimLinePos) /
                    max(uRimLineWidth, 0.0001),
                    2.0
                )
            ) * uRimLine
        );

        outA = smoothstep(1.0, 0.93, maskND);

        return col;
    }

    void main() {
        vec3 outputColor = texture2D(uTex, vUv).rgb;
        float alpha = 0.0;
        vec3 lensColor = glassLens(uCenter, uAspect, alpha);
        outputColor = mix(outputColor, lensColor, alpha);
        gl_FragColor = vec4(outputColor, 1.0);
    }
  `;

  // Certified Partner Projects Data
  const partnerProjects = [
    {
      brand: 'AWS Certified AI & ML Partner',
      subtitle: 'AMAZON WEB SERVICES',
      description: 'High-throughput AWS Bedrock foundation models, SageMaker distributed clusters & P5 GPU clusters.',
      badge: 'AWS Bedrock · P5 GPU Clusters',
      color: '#FF9900',
      icon: 'fa-brands fa-aws'
    },
    {
      brand: 'Microsoft Azure OpenAI Partner',
      subtitle: 'MICROSOFT CLOUD',
      description: 'Enterprise GPT-4o deployments, Azure AI Search hybrid vector indexing & zero-retention private security.',
      badge: 'Azure AI Foundry · GPT-4o Ready',
      color: '#00A4EF',
      icon: 'fa-brands fa-microsoft'
    },
    {
      brand: 'Google Cloud Vertex AI Certified',
      subtitle: 'GOOGLE CLOUD PLATFORM',
      description: 'Gemini 1.5 Pro multimodal processing, TPU v5e acceleration clusters & BigQuery ML pipelines.',
      badge: 'Gemini 1.5 Pro · TPU v5e',
      color: '#4285F4',
      icon: 'fa-brands fa-google'
    },
    {
      brand: 'NVIDIA AI Accelerated Compute',
      subtitle: 'NVIDIA AI ECOSYSTEM',
      description: 'TensorRT-LLM optimization, Triton inference microservices, Jetson edge vision & H100 GPU pods.',
      badge: 'TensorRT-LLM · Triton Server',
      color: '#76B900',
      icon: 'fa-solid fa-microchip'
    },
    {
      brand: 'ISO 27001 & SOC 2 Type II Certified',
      subtitle: 'SECURITY & COMPLIANCE',
      description: 'Full-lifecycle information security governance, encrypted token pipelines & HIPAA/GDPR data residency.',
      badge: 'ISO/IEC 27001:2022 · SOC 2',
      color: '#10B981',
      icon: 'fa-solid fa-shield-halved'
    },
    {
      brand: "Top AI Development Firm in India",
      subtitle: 'CHENNAI & BANGALORE HUBS',
      description: 'Ranked among India\'s elite AI delivery organizations with engineering centers across South India.',
      badge: 'Chennai · Bangalore · Hyderabad',
      color: '#D946EF',
      icon: 'fa-solid fa-trophy'
    }
  ];

  function createProceduralCardTexture(project, index) {
    const canvas = document.createElement('canvas');
    canvas.width = 1200;
    canvas.height = 800;
    const ctx = canvas.getContext('2d');

    // Deep high-tech background gradient
    const bgGrad = ctx.createLinearGradient(0, 0, 1200, 800);
    bgGrad.addColorStop(0, '#090d1f');
    bgGrad.addColorStop(0.5, '#050713');
    bgGrad.addColorStop(1, '#0e122b');
    ctx.fillStyle = bgGrad;
    ctx.fillRect(0, 0, canvas.width, canvas.height);

    // Glowing corner cyber brackets
    ctx.strokeStyle = project.color;
    ctx.lineWidth = 4;
    ctx.strokeRect(30, 30, 1140, 740);

    // Accent Glow Radial
    const glow = ctx.createRadialGradient(600, 350, 20, 600, 350, 480);
    glow.addColorStop(0, `${project.color}33`);
    glow.addColorStop(1, 'transparent');
    ctx.fillStyle = glow;
    ctx.fillRect(0, 0, canvas.width, canvas.height);

    // Top Subtitle / Tag
    ctx.font = '700 24px "SF Mono", "Fira Code", monospace';
    ctx.fillStyle = project.color;
    ctx.fillText(project.subtitle.toUpperCase(), 70, 100);

    // Step Indicator
    ctx.fillStyle = '#64748b';
    ctx.font = '700 24px monospace';
    ctx.textAlign = 'right';
    ctx.fillText(`0${index + 1} / 06`, 1130, 100);
    ctx.textAlign = 'left';

    // Main Brand Title
    ctx.fillStyle = '#ffffff';
    ctx.font = '800 48px Inter, system-ui, sans-serif';
    ctx.fillText(project.brand, 70, 220);

    // Description text
    ctx.fillStyle = '#94a3b8';
    ctx.font = '400 26px Inter, system-ui, sans-serif';
    const words = project.description.split(' ');
    let line = '';
    let y = 310;
    for (let n = 0; n < words.length; n++) {
      const testLine = line + words[n] + ' ';
      const metrics = ctx.measureText(testLine);
      if (metrics.width > 1050 && n > 0) {
        ctx.fillText(line, 70, y);
        line = words[n] + ' ';
        y += 42;
      } else {
        line = testLine;
      }
    }
    ctx.fillText(line, 70, y);

    // Pill Badge at Bottom
    ctx.fillStyle = `${project.color}22`;
    if (ctx.roundRect) {
      ctx.roundRect(70, 670, 480, 56, [12]);
    } else {
      ctx.rect(70, 670, 480, 56);
    }
    ctx.fill();
    ctx.stroke();

    ctx.fillStyle = '#ffffff';
    ctx.font = '700 22px "SF Mono", monospace';
    ctx.fillText(project.badge, 95, 705);

    const texture = new THREE.CanvasTexture(canvas);
    // colorSpace is r152+; this page runs three r128, where the same thing is
    // called encoding. Setting both leaves whichever build is loaded correct,
    // rather than silently drawing these cards in linear space.
    texture.colorSpace = THREE.SRGBColorSpace;
    if (THREE.sRGBEncoding !== undefined) texture.encoding = THREE.sRGBEncoding;
    texture.needsUpdate = true;
    return texture;
  }

  function initLiquidGlassCarousel() {
    const mount = document.getElementById('liquid-glass-stage');
    if (!mount || typeof THREE === 'undefined') return;

    // Clear previous children
    mount.innerHTML = '';

    let W = Math.max(320, mount.clientWidth);
    let H = Math.max(480, mount.clientHeight || 540);

    const cfg = {
      panelHeight: 380,
      gap: 20,
      glide: 0.075,
      wheelSensitivity: 0.9,
      snap: true,
      snapDistance: 80,
      snapDelay: 120,
      speedShrink: 60,
      lensShape: 'square',
      lensRotation: 0,
      lensWidth: 0.52,
      lensHeight: 0.78,
      lensX: 0.5,
      lensY: 0.5,
      dispersion: 14.0,
      zoom: 0.18,
      blur: 0.0,
      glow: 5.5,
      blueRing: 5.0,
      blueColor: '#22d3ee',
      shimmer: true,
      rimWave: 0.55,
      focusScale: 1.15
    };

    const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
    const dpr = Math.min(window.devicePixelRatio || 1, 2);
    renderer.setPixelRatio(dpr);
    renderer.setSize(W, H);
    renderer.setClearColor(0x000000, 0);
    renderer.domElement.style.width = '100%';
    renderer.domElement.style.height = '100%';
    renderer.domElement.style.display = 'block';
    renderer.domElement.style.touchAction = 'none';
    mount.appendChild(renderer.domElement);

    const scene = new THREE.Scene();
    const camera = new THREE.OrthographicCamera(-W / 2, W / 2, H / 2, -H / 2, -100, 100);
    camera.position.z = 10;

    const sources = partnerProjects.map((p, i) => ({
      aspect: 1.5,
      texture: createProceduralCardTexture(p, i)
    }));

    const panelHeightPx = () => {
      const isMobile = window.innerWidth < 768;
      return isMobile ? Math.min(260, H * 0.58) : Math.min(cfg.panelHeight, H * 0.72);
    };

    const gapPx = () => cfg.gap;
    const slotWidth = (i) => sources[i].aspect * panelHeightPx() + gapPx();

    let offsets = [];
    let totalWidth = 0;

    function recomputeTotal() {
      offsets = [];
      let sum = 0;
      sources.forEach((_, idx) => {
        offsets.push(sum);
        sum += slotWidth(idx);
      });
      totalWidth = Math.max(sum, 1);
    }
    recomputeTotal();

    function centerForIndex(idx) {
      const count = sources.length;
      const loop = Math.floor(idx / count);
      const sourceIdx = ((idx % count) + count) % count;
      return offsets[sourceIdx] + slotWidth(sourceIdx) / 2 - gapPx() / 2 + loop * totalWidth;
    }

    function nearestIndex(value) {
      let best = 0;
      let bestDistance = Infinity;
      for (let i = 0; i < sources.length; i++) {
        const center = offsets[i] + slotWidth(i) / 2 - gapPx() / 2;
        const loop = Math.round((value - center) / totalWidth);
        const distance = Math.abs(center + loop * totalWidth - value);
        if (distance < bestDistance) {
          bestDistance = distance;
          best = i + loop * sources.length;
        }
      }
      return best;
    }

    function centerSourceIndex(value) {
      let best = 0;
      let bestDistance = Infinity;
      for (let i = 0; i < sources.length; i++) {
        const center = offsets[i] + slotWidth(i) / 2 - gapPx() / 2;
        const loop = Math.round((value - center) / totalWidth);
        const distance = Math.abs(center + loop * totalWidth - value);
        if (distance < bestDistance) {
          bestDistance = distance;
          best = i;
        }
      }
      return best;
    }

    const REPEATS = 4;
    const pool = [];
    for (let repeat = 0; repeat < REPEATS; repeat++) {
      for (let i = 0; i < sources.length; i++) {
        const material = new THREE.MeshBasicMaterial({
          map: sources[i].texture,
          transparent: true
        });
        const mesh = new THREE.Mesh(new THREE.PlaneGeometry(1, 1), material);
        scene.add(mesh);
        pool.push({ mesh, material, sourceIndex: i });
      }
    }

    let scroll = centerForIndex(0);
    let target = scroll;
    let previousScroll = scroll;
    let scrollEnergy = 0;
    let lastWheelAt = 0;
    let snapArmed = false;
    let lastCenter = -1;

    let rt = new THREE.WebGLRenderTarget(W * dpr, H * dpr);
    const lensScene = new THREE.Scene();
    const lensCamera = new THREE.OrthographicCamera(-1, 1, 1, -1, 0, 1);

    const lensUniforms = {
      uTex: { value: rt.texture },
      uRes: { value: new THREE.Vector2(W * dpr, H * dpr) },
      uCenter: { value: new THREE.Vector2(cfg.lensX, cfg.lensY) },
      uSizeX: { value: cfg.lensWidth },
      uSizeY: { value: cfg.lensHeight },
      uShape: { value: 1.0 },
      uSquareRound: { value: 0.12 },
      uRotation: { value: 0 },
      uAspect: { value: W / H },
      uZoom: { value: cfg.zoom },
      uDispersion: { value: cfg.dispersion },
      uBlur: { value: cfg.blur },
      uGlow: { value: cfg.glow },
      uWhiteGlow: { value: 0.24 },
      uNovaSize: { value: 12 },
      uBlueRing: { value: cfg.blueRing },
      uRingRadius: { value: 0.49 },
      uRingWidth: { value: 0.014 },
      uShimmer: { value: 1.0 },
      uShimmerFreq: { value: 12 },
      uShimmerSpeed: { value: 3.5 },
      uShimmerDepth: { value: 0.12 },
      uTime: { value: 0 },
      uRimStart: { value: 0.58 },
      uRimTangential: { value: cfg.rimWave },
      uRimInward: { value: 0.0 },
      uRimFreq1: { value: 2.0 },
      uRimFreq2: { value: 1.0 },
      uBlueColor: { value: new THREE.Color(cfg.blueColor) },
      uRimLine: { value: 1.4 },
      uRimLinePos: { value: 0.488 },
      uRimLineWidth: { value: 0.003 },
      uSamples: { value: 16 }
    };

    const lensMaterial = new THREE.ShaderMaterial({
      uniforms: lensUniforms,
      vertexShader: `
        varying vec2 vUv;
        void main() {
          vUv = uv;
          gl_Position = vec4(position.xy, 0.0, 1.0);
        }
      `,
      fragmentShader
    });

    const lensQuad = new THREE.Mesh(new THREE.PlaneGeometry(2, 2), lensMaterial);
    lensScene.add(lensQuad);

    function layout() {
      const half = W / 2;
      const currentPanelHeight = panelHeightPx();
      const currentGap = gapPx();
      const buffer = currentPanelHeight * 1.5;

      pool.forEach((item, poolIndex) => {
        const repeat = Math.floor(poolIndex / sources.length);
        const sourceIndex = item.sourceIndex;
        const source = sources[sourceIndex];
        const centerInLoop = offsets[sourceIndex] + slotWidth(sourceIndex) / 2 - currentGap / 2;

        let x = centerInLoop - scroll;
        x = ((x % totalWidth) + totalWidth) % totalWidth;
        x += (repeat - Math.floor(REPEATS / 2)) * totalWidth;
        if (x > half + totalWidth) x -= totalWidth * REPEATS;

        const centerX = x;
        if (centerX < -half - buffer || centerX > half + buffer) {
          item.mesh.visible = false;
          return;
        }

        const shrink = 1 - 0.2 * scrollEnergy;
        const height = currentPanelHeight * shrink;
        const width = source.aspect * currentPanelHeight * shrink;

        item.mesh.visible = true;
        item.mesh.position.set(centerX, 0, 0);
        item.mesh.scale.set(width, height, 1);
      });
    }

    let dragPointerId = null;
    let dragOriginX = 0;
    let dragOriginTarget = 0;

    function onWheel(e) {
      e.preventDefault();
      target += (e.deltaY || e.deltaX) * cfg.wheelSensitivity;
      lastWheelAt = performance.now();
      snapArmed = true;
    }

    function onPointerDown(e) {
      if (e.pointerType === 'mouse' && e.button !== 0) return;
      dragPointerId = e.pointerId;
      dragOriginX = e.clientX;
      dragOriginTarget = target;
      renderer.domElement.setPointerCapture?.(e.pointerId);
    }

    function onPointerMove(e) {
      if (dragPointerId === e.pointerId) {
        const dx = e.clientX - dragOriginX;
        target = dragOriginTarget - dx * cfg.wheelSensitivity;
        lastWheelAt = performance.now();
        snapArmed = true;
      }
    }

    function onPointerUp(e) {
      if (dragPointerId !== e.pointerId) return;
      renderer.domElement.releasePointerCapture?.(e.pointerId);
      dragPointerId = null;
      lastWheelAt = performance.now();
      snapArmed = true;
    }

    renderer.domElement.addEventListener('wheel', onWheel, { passive: false });
    renderer.domElement.addEventListener('pointerdown', onPointerDown);
    renderer.domElement.addEventListener('pointermove', onPointerMove);
    renderer.domElement.addEventListener('pointerup', onPointerUp);
    renderer.domElement.addEventListener('pointercancel', onPointerUp);

    const btnPrev = document.getElementById('liquid-btn-prev');
    const btnNext = document.getElementById('liquid-btn-next');
    const dotsContainer = document.getElementById('liquid-dots');

    const partnerPillsContainer = document.getElementById('liquid-partner-pills');

    function updateActiveUI(index) {
      const p = partnerProjects[index];
      const titleEl = document.getElementById('liquid-partner-title');
      const descEl = document.getElementById('liquid-partner-desc');
      const counterEl = document.getElementById('liquid-counter');

      if (titleEl && p) titleEl.textContent = p.brand;
      if (descEl && p) descEl.textContent = p.description;
      if (counterEl) counterEl.textContent = `0${index + 1} / 06`;

      if (dotsContainer) {
        const dots = dotsContainer.querySelectorAll('.liquid-dot');
        dots.forEach((dot, idx) => {
          dot.classList.toggle('active', idx === index);
        });
      }

      if (partnerPillsContainer) {
        const pills = partnerPillsContainer.querySelectorAll('.quick-pill-btn');
        pills.forEach((pill, idx) => {
          pill.classList.toggle('active', idx === index);
        });
      }
    }

    if (partnerPillsContainer) {
      partnerPillsContainer.addEventListener('click', (e) => {
        const pill = e.target.closest('.quick-pill-btn');
        if (pill) {
          const idx = parseInt(pill.getAttribute('data-index'), 10);
          if (!isNaN(idx)) {
            target = centerForIndex(idx);
            snapArmed = false;
          }
        }
      });
    }

    if (btnPrev) {
      btnPrev.addEventListener('click', () => {
        target = centerForIndex(nearestIndex(target) - 1);
        snapArmed = false;
      });
    }

    if (btnNext) {
      btnNext.addEventListener('click', () => {
        target = centerForIndex(nearestIndex(target) + 1);
        snapArmed = false;
      });
    }

    if (dotsContainer) {
      dotsContainer.addEventListener('click', (e) => {
        const dot = e.target.closest('.liquid-dot');
        if (dot) {
          const idx = parseInt(dot.getAttribute('data-index'), 10);
          target = centerForIndex(idx);
          snapArmed = false;
        }
      });
    }

    function renderFrame() {
      if (cfg.snap && snapArmed && Math.abs(target - scroll) < cfg.snapDistance && performance.now() - lastWheelAt > cfg.snapDelay) {
        target = centerForIndex(nearestIndex(target));
        snapArmed = false;
      }

      scroll += (target - scroll) * cfg.glide;

      const centerIndex = centerSourceIndex(scroll);
      if (centerIndex !== lastCenter) {
        lastCenter = centerIndex;
        updateActiveUI(centerIndex);
      }

      const speed = scroll - previousScroll;
      previousScroll = scroll;
      const normalized = Math.min(1, Math.abs(speed) / cfg.speedShrink);
      const energyEase = normalized > scrollEnergy ? 0.25 : 0.06;
      scrollEnergy += (normalized - scrollEnergy) * energyEase;

      layout();

      lensUniforms.uAspect.value = W / H;
      lensUniforms.uTime.value = performance.now() * 0.001;

      renderer.setRenderTarget(rt);
      renderer.render(scene, camera);
      renderer.setRenderTarget(null);
      renderer.render(lensScene, lensCamera);

      requestAnimationFrame(renderFrame);
    }
    renderFrame();

    function onResize() {
      W = Math.max(320, mount.clientWidth);
      H = Math.max(480, mount.clientHeight || 540);
      renderer.setSize(W, H);
      camera.left = -W / 2;
      camera.right = W / 2;
      camera.top = H / 2;
      camera.bottom = -H / 2;
      camera.updateProjectionMatrix();
      rt.setSize(W * dpr, H * dpr);
      lensUniforms.uRes.value.set(W * dpr, H * dpr);
      recomputeTotal();
    }

    const resizeObserver = new ResizeObserver(onResize);
    resizeObserver.observe(mount);
  }

  function tryInitLiquidGlassCarousel() {
    if (typeof THREE === 'undefined') {
      setTimeout(tryInitLiquidGlassCarousel, 50);
      return;
    }
    const mount = document.getElementById('liquid-glass-stage') || document.getElementById('liquid-glass-carousel-root');
    if (!mount) {
      setTimeout(tryInitLiquidGlassCarousel, 50);
      return;
    }
    initLiquidGlassCarousel();
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', tryInitLiquidGlassCarousel);
  } else {
    tryInitLiquidGlassCarousel();
  }
})();
