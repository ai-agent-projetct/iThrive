/**
 * iThrive AI - Humanoid Robot & Bio-Luminescent Flower Meadow
 * Exact Match to Spline Scene (https://app.spline.design/file/8b9b5100-4168-4401-8f66-2d5ab24026fb)
 * Real-Time 60/120 FPS Viewport Mouse LookAt Tracking, Damped Lerp Kinematics,
 * Overhead Volumetric Spotlight, 340+ Swaying Bio-Luminescent Flowers, Embers & Interactive Audio
 */

(function () {
  'use strict';

  let currentTheme = 'black';
  let isScanningMode = false;
  let scanTimer = null;

  function initRobot3D() {
    const container = document.getElementById('robot-canvas-container');
    const canvas = document.getElementById('robot-3d-canvas');
    if (!container || !canvas || typeof THREE === 'undefined') return;

    let width = container.clientWidth || container.offsetWidth || 560;
    let height = container.clientHeight || container.offsetHeight || 600;

    // -------------------------------------------------------------
    // Scene, Camera & ACES Filmic Tone-Mapped WebGL Renderer
    // -------------------------------------------------------------
    const scene = new THREE.Scene();
    scene.fog = new THREE.FogExp2(0xffffff, 0.07);

    const camera = new THREE.PerspectiveCamera(40, width / height, 0.1, 100);
    camera.position.set(0, 0.22, 4.6);

    const renderer = new THREE.WebGLRenderer({
      canvas: canvas,
      alpha: false,
      antialias: true,
      powerPreference: 'high-performance'
    });
    renderer.setSize(width, height);
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
    renderer.setClearColor(0xffffff, 1);
    renderer.toneMapping = THREE.ACESFilmicToneMapping;
    renderer.toneMappingExposure = 1.3;
    renderer.shadowMap.enabled = true;
    renderer.shadowMap.type = THREE.PCFSoftShadowMap;

    // Master Root Groups
    const worldRoot = new THREE.Group();
    scene.add(worldRoot);

    const robotGroup = new THREE.Group();
    robotGroup.position.set(0, -0.42, 0);
    worldRoot.add(robotGroup);

    // -------------------------------------------------------------
    // Materials & Colorway Presets (Default Jet Black Armor)
    // -------------------------------------------------------------
    const themePalettes = {
      black: { armor: 0x0a0a0c, accent: 0x18181b, emissive: 0xffffff, glow: 0xffffff },
      white: { armor: 0xf1f5f9, accent: 0x00f0ff, emissive: 0x00f0ff, glow: 0x38bdf8 },
      cyan: { armor: 0x0f172a, accent: 0x00f0ff, emissive: 0x00f0ff, glow: 0x38bdf8 },
      violet: { armor: 0x1e1b4b, accent: 0xa855f7, emissive: 0xc084fc, glow: 0xd946ef },
      emerald: { armor: 0x022c22, accent: 0x10b981, emissive: 0x34d399, glow: 0x6ee7b7 },
      gold: { armor: 0x1c1917, accent: 0xf59e0b, emissive: 0xfbbf24, glow: 0xfcd34d }
    };

    const armorWhiteMat = new THREE.MeshStandardMaterial({
      color: themePalettes.black.armor,
      roughness: 0.22,
      metalness: 0.88
    });

    const armorDarkMat = new THREE.MeshStandardMaterial({
      color: 0x040406,
      roughness: 0.28,
      metalness: 0.95
    });

    const jointMetalMat = new THREE.MeshStandardMaterial({
      color: 0x1e1e24,
      roughness: 0.35,
      metalness: 0.96
    });

    const visorCyanMat = new THREE.MeshStandardMaterial({
      color: 0xffffff,
      emissive: 0xffffff,
      emissiveIntensity: 4.5,
      roughness: 0.05
    });

    const reactorCoreMat = new THREE.MeshStandardMaterial({
      color: 0xffffff,
      emissive: 0xffffff,
      emissiveIntensity: 4.5,
      roughness: 0.1
    });

    const accentTrimMat = new THREE.MeshStandardMaterial({
      color: 0x18181b,
      roughness: 0.3,
      metalness: 0.9
    });

    function updateMaterialsTheme(themeKey) {
      const pal = themePalettes[themeKey] || themePalettes.white;
      armorWhiteMat.color.setHex(pal.armor);
      visorCyanMat.color.setHex(pal.emissive);
      visorCyanMat.emissive.setHex(pal.emissive);
      reactorCoreMat.color.setHex(pal.glow);
      reactorCoreMat.emissive.setHex(pal.emissive);
      accentTrimMat.color.setHex(pal.accent);
    }

    // -------------------------------------------------------------
    // 1. BIO-LUMINESCENT FLOWER MEADOW (340+ Blooming Flowers)
    // -------------------------------------------------------------
    const meadowGroup = new THREE.Group();
    worldRoot.add(meadowGroup);

    // Floor Base Disc
    const floorGeo = new THREE.CircleGeometry(5.2, 64);
    const floorMat = new THREE.MeshStandardMaterial({
      color: 0x02050e,
      roughness: 0.9,
      metalness: 0.1
    });
    const floorMesh = new THREE.Mesh(floorGeo, floorMat);
    floorMesh.rotation.x = -Math.PI / 2;
    floorMesh.position.y = -1.84;
    meadowGroup.add(floorMesh);

    // Center Spotlight Pool Floor Highlight
    const poolGeo = new THREE.CircleGeometry(1.7, 48);
    const poolMat = new THREE.MeshStandardMaterial({
      color: 0x1e293b,
      emissive: 0x38bdf8,
      emissiveIntensity: 0.25,
      roughness: 0.6
    });
    const poolMesh = new THREE.Mesh(poolGeo, poolMat);
    poolMesh.rotation.x = -Math.PI / 2;
    poolMesh.position.y = -1.835;
    meadowGroup.add(poolMesh);

    // Flower Palettes matching reference video
    const centerColors = [0xffffff, 0xf0fdf4, 0xe0f2fe, 0xc7d2fe, 0x93c5fd];
    const midColors = [0x38bdf8, 0x2563eb, 0x0284c7, 0x818cf8, 0xa855f7, 0xc084fc, 0xe879f9];
    const outerColors = [0x1e1b4b, 0x312e81, 0x4c1d95, 0x1e293b, 0x581c87];

    const flowerStems = [];
    const stemDarkMat = new THREE.MeshStandardMaterial({ color: 0x071b10, roughness: 0.8 });

    function createFlower(x, y, z, colorHex, scale, type) {
      const fGroup = new THREE.Group();
      fGroup.position.set(x, y, z);
      fGroup.scale.setScalar(scale);

      const stemMesh = new THREE.Mesh(new THREE.CylinderGeometry(0.012, 0.02, 0.42, 5), stemDarkMat);
      stemMesh.position.y = 0.21;
      fGroup.add(stemMesh);

      const headGroup = new THREE.Group();
      headGroup.position.y = 0.42;

      // Center glowing core
      const coreMat = new THREE.MeshStandardMaterial({
        color: colorHex,
        emissive: colorHex,
        emissiveIntensity: 2.5,
        roughness: 0.2
      });
      const coreMesh = new THREE.Mesh(new THREE.SphereGeometry(0.04, 8, 8), coreMat);
      headGroup.add(coreMesh);

      // Petals
      const petalMat = new THREE.MeshStandardMaterial({
        color: colorHex,
        emissive: colorHex,
        emissiveIntensity: 0.8,
        roughness: 0.45,
        side: THREE.DoubleSide
      });

      if (type === 'bell') {
        for (let d = 0; d < 360; d += 72) {
          const rad = (d * Math.PI) / 180;
          const p = new THREE.Mesh(new THREE.ConeGeometry(0.035, 0.11, 4), petalMat);
          p.position.set(Math.sin(rad) * 0.05, 0.02, Math.cos(rad) * 0.05);
          p.rotation.set(0.35, rad, 0.15);
          headGroup.add(p);
        }
      } else {
        for (let d = 0; d < 360; d += 45) {
          const rad = (d * Math.PI) / 180;
          const p = new THREE.Mesh(new THREE.BoxGeometry(0.028, 0.008, 0.09), petalMat);
          p.position.set(Math.sin(rad) * 0.055, 0.015, Math.cos(rad) * 0.055);
          p.rotation.set(0.2, rad, 0);
          headGroup.add(p);
        }
      }

      fGroup.add(headGroup);
      meadowGroup.add(fGroup);

      flowerStems.push({
        stem: stemMesh,
        windPhase: x * 2.2 + z * 1.8
      });
    }

    // Populate Meadow
    const flowerCount = 320;
    for (let i = 0; i < flowerCount; i++) {
      const angle = Math.random() * Math.PI * 2;
      const r = Math.sqrt(Math.random()) * 4.8;
      if (r < 0.35) continue; // Keep standing area clear

      const x = Math.cos(angle) * r;
      const z = Math.sin(angle) * r;
      const y = -1.82 + (Math.random() - 0.5) * 0.06;

      let color;
      if (r < 1.4) {
        color = Math.random() < 0.65 ? centerColors[Math.floor(Math.random() * centerColors.length)] : midColors[Math.floor(Math.random() * midColors.length)];
      } else if (r < 3.2) {
        color = midColors[Math.floor(Math.random() * midColors.length)];
      } else {
        color = outerColors[Math.floor(Math.random() * outerColors.length)];
      }

      const type = Math.random() > 0.4 ? 'bell' : 'aster';
      const scale = 0.65 + Math.random() * 0.55;
      createFlower(x, y, z, color, scale, type);
    }

    // Bioluminescent Floating Pollen / Embers
    const pollenCount = 180;
    const pollenGeo = new THREE.BufferGeometry();
    const pollenPos = new Float32Array(pollenCount * 3);
    const pollenPhases = new Float32Array(pollenCount);

    for (let i = 0; i < pollenCount; i++) {
      const angle = Math.random() * Math.PI * 2;
      const r = Math.sqrt(Math.random()) * 3.8;
      pollenPos[i * 3] = Math.cos(angle) * r;
      pollenPos[i * 3 + 1] = Math.random() * 4.2 - 1.8;
      pollenPos[i * 3 + 2] = Math.sin(angle) * r;
      pollenPhases[i] = Math.random() * Math.PI * 2;
    }

    pollenGeo.setAttribute('position', new THREE.BufferAttribute(pollenPos, 3));
    const pollenMat = new THREE.PointsMaterial({
      color: 0x7dd3fc,
      size: 0.055,
      transparent: true,
      opacity: 0.85,
      blending: THREE.AdditiveBlending
    });
    const pollenMesh = new THREE.Points(pollenGeo, pollenMat);
    worldRoot.add(pollenMesh);


    // -------------------------------------------------------------
    // 2. HUMANOID ROBOT RIG HIERARCHY
    // -------------------------------------------------------------
    const lowerBodyGroup = new THREE.Group();
    lowerBodyGroup.position.set(0, -1.22, 0);
    robotGroup.add(lowerBodyGroup);

    // Pelvis Chassis & Center Jewel
    const pelvisMesh = new THREE.Mesh(new THREE.CylinderGeometry(0.34, 0.26, 0.24, 16), armorDarkMat);
    pelvisMesh.position.set(0, 0.42, 0);
    lowerBodyGroup.add(pelvisMesh);

    const pelvisPlate = new THREE.Mesh(new THREE.BoxGeometry(0.18, 0.16, 0.08), armorWhiteMat);
    pelvisPlate.position.set(0, 0.42, 0.18);
    lowerBodyGroup.add(pelvisPlate);

    const pelvisLed = new THREE.Mesh(new THREE.SphereGeometry(0.035, 12, 12), visorCyanMat);
    pelvisLed.position.set(0, 0.42, 0.22);
    lowerBodyGroup.add(pelvisLed);

    // Legs Function
    function buildLeg(side) {
      const legGroup = new THREE.Group();
      legGroup.position.set(side * 0.26, 0.32, 0);

      // Hip ball
      const hip = new THREE.Mesh(new THREE.SphereGeometry(0.13, 16, 16), jointMetalMat);
      legGroup.add(hip);

      // Thigh
      const thigh = new THREE.Mesh(new THREE.CylinderGeometry(0.14, 0.11, 0.52, 16), armorWhiteMat);
      thigh.position.set(side * 0.03, -0.32, 0);
      legGroup.add(thigh);

      // Knee
      const knee = new THREE.Mesh(new THREE.SphereGeometry(0.12, 16, 16), armorDarkMat);
      knee.position.set(side * 0.03, -0.62, 0.03);
      legGroup.add(knee);

      const kneeCap = new THREE.Mesh(new THREE.BoxGeometry(0.1, 0.1, 0.06), accentTrimMat);
      kneeCap.position.set(side * 0.03, -0.62, 0.12);
      legGroup.add(kneeCap);

      // Shin
      const shin = new THREE.Mesh(new THREE.CylinderGeometry(0.11, 0.13, 0.55, 16), armorWhiteMat);
      shin.position.set(side * 0.03, -0.94, 0.01);
      legGroup.add(shin);

      // Hydraulic strut
      const strut = new THREE.Mesh(new THREE.CylinderGeometry(0.03, 0.03, 0.42, 10), jointMetalMat);
      strut.position.set(side * 0.03, -0.92, -0.09);
      legGroup.add(strut);

      // Boot
      const boot = new THREE.Mesh(new THREE.BoxGeometry(0.19, 0.13, 0.38), armorDarkMat);
      boot.position.set(side * 0.03, -1.24, 0.09);
      legGroup.add(boot);

      const bootToe = new THREE.Mesh(new THREE.BoxGeometry(0.15, 0.09, 0.12), armorWhiteMat);
      bootToe.position.set(side * 0.03, -1.22, 0.22);
      legGroup.add(bootToe);

      return legGroup;
    }

    lowerBodyGroup.add(buildLeg(-1));
    lowerBodyGroup.add(buildLeg(1));

    // Torso Group (Upper Body)
    const torsoGroup = new THREE.Group();
    torsoGroup.position.set(0, -0.5, 0);
    robotGroup.add(torsoGroup);

    // Chest Plate
    const chestArmor = new THREE.Mesh(new THREE.CylinderGeometry(0.44, 0.31, 0.68, 16), armorWhiteMat);
    chestArmor.position.set(0, 0.36, 0);
    torsoGroup.add(chestArmor);

    const pectoralRidge = new THREE.Mesh(new THREE.BoxGeometry(0.34, 0.36, 0.14), armorWhiteMat);
    pectoralRidge.position.set(0, 0.42, 0.23);
    torsoGroup.add(pectoralRidge);

    const ribsMesh = new THREE.Mesh(new THREE.CylinderGeometry(0.29, 0.32, 0.24, 16), armorDarkMat);
    ribsMesh.position.set(0, 0.08, 0.04);
    torsoGroup.add(ribsMesh);

    const spineMesh = new THREE.Mesh(new THREE.BoxGeometry(0.2, 0.58, 0.14), jointMetalMat);
    spineMesh.position.set(0, 0.36, -0.22);
    torsoGroup.add(spineMesh);

    // ARC Reactor Core
    const reactorGroup = new THREE.Group();
    reactorGroup.position.set(0, 0.42, 0.29);
    const rHousing = new THREE.Mesh(new THREE.CylinderGeometry(0.14, 0.14, 0.06, 24), armorDarkMat);
    rHousing.rotation.x = Math.PI / 2;
    reactorGroup.add(rHousing);

    const rCore = new THREE.Mesh(new THREE.SphereGeometry(0.095, 20, 20), reactorCoreMat);
    rCore.position.z = 0.02;
    reactorGroup.add(rCore);

    const rRing = new THREE.Mesh(new THREE.TorusGeometry(0.115, 0.016, 12, 32), visorCyanMat);
    rRing.rotation.x = Math.PI / 2;
    rRing.position.z = 0.035;
    reactorGroup.add(rRing);
    torsoGroup.add(reactorGroup);

    // Shoulders
    function buildShoulder(side) {
      const sGroup = new THREE.Group();
      sGroup.position.set(side * 0.49, 0.56, 0);
      const pauldron = new THREE.Mesh(new THREE.SphereGeometry(0.19, 16, 16), armorWhiteMat);
      sGroup.add(pauldron);

      const trim = new THREE.Mesh(new THREE.BoxGeometry(0.11, 0.07, 0.24), accentTrimMat);
      trim.position.set(side * -0.05, 0.06, 0);
      sGroup.add(trim);
      return sGroup;
    }
    torsoGroup.add(buildShoulder(-1));
    torsoGroup.add(buildShoulder(1));

    // Arms
    function buildArm(side) {
      const aGroup = new THREE.Group();
      aGroup.position.set(side * 0.58, 0.46, 0);

      const bicep = new THREE.Mesh(new THREE.CylinderGeometry(0.085, 0.075, 0.42, 12), armorDarkMat);
      bicep.position.set(0, -0.24, 0);
      aGroup.add(bicep);

      const elbow = new THREE.Mesh(new THREE.SphereGeometry(0.085, 12, 12), jointMetalMat);
      elbow.position.set(0, -0.48, 0);
      aGroup.add(elbow);

      const forearm = new THREE.Mesh(new THREE.CylinderGeometry(0.082, 0.095, 0.42, 14), armorWhiteMat);
      forearm.position.set(0, -0.72, 0.02);
      aGroup.add(forearm);

      const hand = new THREE.Mesh(new THREE.BoxGeometry(0.075, 0.11, 0.1), armorDarkMat);
      hand.position.set(0, -0.96, 0.02);
      aGroup.add(hand);

      const fingers = new THREE.Mesh(new THREE.BoxGeometry(0.065, 0.08, 0.07), jointMetalMat);
      fingers.position.set(0, -1.03, 0.04);
      aGroup.add(fingers);

      return aGroup;
    }

    const leftArm = buildArm(-1);
    const rightArm = buildArm(1);
    torsoGroup.add(leftArm);
    torsoGroup.add(rightArm);

    // Neck & Head Assembly
    const neckGroup = new THREE.Group();
    neckGroup.position.set(0, 0.72, 0);
    torsoGroup.add(neckGroup);

    const neckMesh = new THREE.Mesh(new THREE.CylinderGeometry(0.095, 0.13, 0.18, 16), jointMetalMat);
    neckMesh.position.y = 0.07;
    neckGroup.add(neckMesh);

    const collarRing = new THREE.Mesh(new THREE.TorusGeometry(0.14, 0.016, 10, 24), visorCyanMat);
    collarRing.rotation.x = Math.PI / 2;
    collarRing.position.y = 0.06;
    neckGroup.add(collarRing);

    // Head
    const headGroup = new THREE.Group();
    headGroup.position.set(0, 0.24, 0);
    neckGroup.add(headGroup);

    const helmetBase = new THREE.Mesh(new THREE.BoxGeometry(0.35, 0.31, 0.35), armorWhiteMat);
    helmetBase.position.y = 0.11;
    headGroup.add(helmetBase);

    const helmetCrown = new THREE.Mesh(new THREE.SphereGeometry(0.185, 20, 16, 0, Math.PI * 2, 0, Math.PI / 2), armorWhiteMat);
    helmetCrown.position.set(0, 0.27, -0.02);
    headGroup.add(helmetCrown);

    const helmetJaw = new THREE.Mesh(new THREE.BoxGeometry(0.27, 0.13, 0.25), armorDarkMat);
    helmetJaw.position.set(0, -0.06, 0.06);
    headGroup.add(helmetJaw);

    // Ear Pods
    const leftEar = new THREE.Mesh(new THREE.CylinderGeometry(0.055, 0.055, 0.045, 16), accentTrimMat);
    leftEar.rotation.z = Math.PI / 2;
    leftEar.position.set(-0.195, 0.11, 0);
    headGroup.add(leftEar);

    const rightEar = new THREE.Mesh(new THREE.CylinderGeometry(0.055, 0.055, 0.045, 16), accentTrimMat);
    rightEar.rotation.z = Math.PI / 2;
    rightEar.position.set(0.195, 0.11, 0);
    headGroup.add(rightEar);

    // Visor LED Strip
    const visorGroup = new THREE.Group();
    visorGroup.position.set(0, 0.09, 0.17);
    const vFrame = new THREE.Mesh(new THREE.BoxGeometry(0.31, 0.11, 0.03), armorDarkMat);
    visorGroup.add(vFrame);

    const vLed = new THREE.Mesh(new THREE.BoxGeometry(0.27, 0.068, 0.02), visorCyanMat);
    vLed.position.z = 0.016;
    visorGroup.add(vLed);
    headGroup.add(visorGroup);

    // Gaze Laser Ray toward cursor
    const laserRay = new THREE.Mesh(
      new THREE.CylinderGeometry(0.003, 0.012, 2.8, 8),
      new THREE.MeshBasicMaterial({ color: 0x38bdf8, transparent: true, opacity: 0.45 })
    );
    laserRay.position.set(0, 0.09, 1.6);
    laserRay.rotation.x = Math.PI / 2;
    headGroup.add(laserRay);


    // -------------------------------------------------------------
    // 3. CINEMATIC LIGHTING SETUP (Overhead Spotlight & Dynamic Specular)
    // -------------------------------------------------------------
    // -------------------------------------------------------------
    // 3. STUDIO LIGHTING SETUP (High-Key Fill & Sculpting Rims)
    // -------------------------------------------------------------
    const ambLight = new THREE.AmbientLight(0xffffff, 1.2);
    scene.add(ambLight);

    // Main Overhead Studio Softbox Light
    const mainSpot = new THREE.DirectionalLight(0xffffff, 3.0);
    mainSpot.position.set(0, 8, 4);
    mainSpot.castShadow = true;
    scene.add(mainSpot);

    // Front Fill Key Light
    const frontFill = new THREE.DirectionalLight(0xffffff, 2.2);
    frontFill.position.set(2, 3, 5);
    scene.add(frontFill);

    // Dynamic Cursor Following Specular Light
    const cursorLight = new THREE.PointLight(0xffffff, 3.2, 8);
    cursorLight.position.set(0, 1, 3);
    scene.add(cursorLight);

    // Left Crisp Rim Light to sculpt black silhouette
    const leftRim = new THREE.PointLight(0xffffff, 4.5, 10);
    leftRim.position.set(-3.5, 2.0, -1.5);
    scene.add(leftRim);

    // Right Crisp Rim Light
    const rightRim = new THREE.PointLight(0xffffff, 4.5, 10);
    rightRim.position.set(3.5, 2.0, -1.5);
    scene.add(rightRim);

    // Ground Contact Drop Shadow
    const groundShadow = new THREE.Mesh(
      new THREE.CircleGeometry(3.2, 48),
      new THREE.MeshBasicMaterial({ color: 0xe2e8f0, transparent: true, opacity: 0.4 })
    );
    groundShadow.rotation.x = -Math.PI / 2;
    groundShadow.position.y = -1.82;
    scene.add(groundShadow);


    // -------------------------------------------------------------
    // Video Scrubbing Engine (Exact Spline 4K Mode)
    // -------------------------------------------------------------
    const videoEl = document.getElementById('robot-exact-video');
    const videoGlow = document.getElementById('robot-video-glow');
    const modeLabel = document.getElementById('robot-mode-label');
    const toggleBtnText = document.getElementById('robot-toggle-text');
    // 'video' or 'webgl'. The video engine wants a #robot-exact-video element,
    // which exists nowhere in the markup — so defaulting to it left the panel
    // rendering nothing at all, since the WebGL branch below is gated on this.
    // Fall back to the scene that is actually built.
    let activeEngine = videoEl ? 'video' : 'webgl';
    let currentVidTime = 0;
    let targetVidTime = 0;

    const videoThemeFilters = {
      white: 'none',
      cyan: 'hue-rotate(0deg) saturate(1.8) brightness(1.1)',
      violet: 'hue-rotate(75deg) saturate(2.2) brightness(1.15)',
      emerald: 'hue-rotate(220deg) saturate(2.4) brightness(1.05)',
      gold: 'hue-rotate(320deg) saturate(2.4) brightness(1.15)'
    };

    window.toggleRobotEngine = function () {
      if (activeEngine === 'video') {
        activeEngine = 'webgl';
        if (videoEl) videoEl.style.opacity = '0';
        if (canvas) {
          canvas.style.opacity = '1';
          canvas.style.pointerEvents = 'auto';
        }
        if (modeLabel) modeLabel.textContent = '3D WebGL Rig · Real-Time IK Active';
        if (toggleBtnText) toggleBtnText.textContent = 'Switch to Spline 4K';
      } else {
        activeEngine = 'video';
        if (videoEl) videoEl.style.opacity = '1';
        if (canvas) {
          canvas.style.opacity = '0';
          canvas.style.pointerEvents = 'none';
        }
        if (modeLabel) modeLabel.textContent = 'Exact Spline 4K · Mouse Tracking Active';
        if (toggleBtnText) toggleBtnText.textContent = 'Switch to 3D WebGL';
      }
    };

    // -------------------------------------------------------------
    // 4. MOUSE TRACKING & KINEMATICS LOOP
    // -------------------------------------------------------------
    let mouse = { x: 0, y: 0, targetX: 0, targetY: 0, yaw: 0, pitch: 0 };
    let clickEnergy = 0;

    function handleMouseMove(e) {
      const normX = ((e.clientX / window.innerWidth) - 0.5) * 2;
      const normY = ((e.clientY / window.innerHeight) - 0.5) * -2;
      mouse.targetX = normX;
      mouse.targetY = normY;

      // Video target time
      const hRatio = Math.max(0, Math.min(1, e.clientX / window.innerWidth));
      if (videoEl && videoEl.duration) {
        targetVidTime = hRatio * videoEl.duration;
      }

      // Update Specular Glow overlay position on video
      if (videoGlow) {
        const posX = (hRatio * 100).toFixed(1);
        const posY = (((e.clientY / window.innerHeight)) * 100).toFixed(1);
        videoGlow.style.background = `radial-gradient(circle 320px at ${posX}% ${posY}%, rgba(34, 211, 238, 0.4), transparent 70%)`;
      }
    }
    window.addEventListener('mousemove', handleMouseMove);

    container.addEventListener('click', () => {
      clickEnergy = 1.0;
    });

    // Global hooks for external controls
    window.triggerRobotScan = function () {
      isScanningMode = true;
      if (videoEl && activeEngine === 'video') {
        videoEl.play().catch(() => {});
      }
      clearTimeout(scanTimer);
      scanTimer = setTimeout(() => {
        isScanningMode = false;
        if (videoEl && activeEngine === 'video') {
          videoEl.pause();
        }
      }, 4500);
    };

    window.setRobot3DTheme = function (th) {
      currentTheme = th;
      updateMaterialsTheme(th);
      if (videoEl && videoThemeFilters[th]) {
        videoEl.style.filter = videoThemeFilters[th];
      }
    };

    // Resize Handler
    function onResize() {
      if (!container || !renderer || !camera) return;
      width = container.clientWidth || 560;
      height = container.clientHeight || 600;
      camera.aspect = width / height;
      camera.updateProjectionMatrix();
      renderer.setSize(width, height);
    }
    window.addEventListener('resize', onResize);

    const clock = new THREE.Clock();

    function animate() {
      requestAnimationFrame(animate);

      // Scrub video if in video mode
      if (activeEngine === 'video' && videoEl && videoEl.duration && !isScanningMode) {
        currentVidTime += (targetVidTime - currentVidTime) * 0.14;
        if (Math.abs(targetVidTime - currentVidTime) > 0.005) {
          videoEl.currentTime = currentVidTime;
        }
      }

      const t = clock.getElapsedTime();
      const delta = clock.getDelta() || 0.016;

      // 1. Calculate Target Yaw/Pitch
      let targetYaw = mouse.targetX * (Math.PI / 2.5);
      let targetPitch = -mouse.targetY * (Math.PI / 4.0);

      if (isScanningMode) {
        targetYaw = Math.sin(t * 2.5) * (Math.PI / 2.2);
        targetPitch = Math.cos(t * 1.8) * (Math.PI / 5.5);
      }

      // 2. Smooth Damped Lerp (60/120 FPS buttery smooth)
      const dampSpeed = 11;
      mouse.yaw += (targetYaw - mouse.yaw) * 0.1;
      mouse.pitch += (targetPitch - mouse.pitch) * 0.1;

      // 3. Apply to Head, Neck, Torso
      headGroup.rotation.y = mouse.yaw;
      headGroup.rotation.x = mouse.pitch;
      headGroup.rotation.z = -mouse.yaw * 0.18;

      neckGroup.rotation.y = mouse.yaw * 0.52;
      neckGroup.rotation.x = mouse.pitch * 0.42;

      torsoGroup.rotation.y = mouse.yaw * 0.26;
      torsoGroup.rotation.x = mouse.pitch * 0.22;
      torsoGroup.rotation.z = -mouse.yaw * 0.06;

      // 4. Arms Swaying & Counter-Balance
      leftArm.rotation.z = 0.18 + Math.sin(t * 1.6) * 0.03 + mouse.yaw * 0.08;
      leftArm.rotation.x = Math.cos(t * 1.4) * 0.03 - mouse.pitch * 0.08;

      rightArm.rotation.z = -0.18 - Math.sin(t * 1.6) * 0.03 + mouse.yaw * 0.08;
      rightArm.rotation.x = -Math.cos(t * 1.4) * 0.03 - mouse.pitch * 0.08;

      // 5. Breathing Stance
      const breath = Math.sin(t * 1.8) * 0.025;
      robotGroup.position.y = -0.42 + breath;

      // 6. Dynamic Cursor Specular Follow
      cursorLight.position.x += (mouse.targetX * 3.5 - cursorLight.position.x) * 0.08;
      cursorLight.position.y += (mouse.targetY * 2.5 + 0.5 - cursorLight.position.y) * 0.08;

      // 7. Click Energy Reaction Pulse
      if (clickEnergy > 0.01) {
        clickEnergy *= 0.94;
        rRing.scale.setScalar(1.0 + clickEnergy * 0.5);
        visorCyanMat.emissiveIntensity = 4.0 + clickEnergy * 3.0;
      } else {
        rRing.scale.setScalar(1.0);
        visorCyanMat.emissiveIntensity = 4.0;
      }

      // 8. Animate Flower Wind Sway
      for (let i = 0; i < flowerStems.length; i++) {
        const item = flowerStems[i];
        const swayX = Math.sin(t * 1.6 + item.windPhase) * 0.05;
        const swayZ = Math.cos(t * 1.3 + item.windPhase) * 0.05;
        item.stem.rotation.z = swayX;
        item.stem.rotation.x = swayZ;
      }

      // 9. Floating Pollen Particles
      const pArr = pollenGeo.attributes.position.array;
      for (let i = 0; i < pollenCount; i++) {
        pArr[i * 3 + 1] += 0.0035;
        pArr[i * 3] += Math.sin(t * 0.7 + pollenPhases[i]) * 0.0018;
        pArr[i * 3 + 2] += Math.cos(t * 0.7 + pollenPhases[i]) * 0.0018;
        if (pArr[i * 3 + 1] > 3.2) {
          pArr[i * 3 + 1] = -1.8;
          const angle = Math.random() * Math.PI * 2;
          const r = Math.sqrt(Math.random()) * 3.8;
          pArr[i * 3] = Math.cos(angle) * r;
          pArr[i * 3 + 2] = Math.sin(angle) * r;
        }
      }
      pollenGeo.attributes.position.needsUpdate = true;

      if (activeEngine === 'webgl') {
        renderer.render(scene, camera);
      }
    }

    animate();
  }

  function tryInitRobot3D() {
    if (typeof THREE === 'undefined') {
      setTimeout(tryInitRobot3D, 50);
      return;
    }
    const container = document.getElementById('robot-canvas-container');
    const canvas = document.getElementById('robot-3d-canvas');
    if (!container || !canvas) {
      setTimeout(tryInitRobot3D, 50);
      return;
    }
    initRobot3D();
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', tryInitRobot3D);
  } else {
    tryInitRobot3D();
  }
})();
