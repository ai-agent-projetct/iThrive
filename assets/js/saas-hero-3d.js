/**
 * iThrive Micro-SaaS - Advanced 3D Architectural Fan Deck Engine
 * Real-time Three.js WebGL Scene rendering 6 Photorealistic 3D Architecture Slabs
 * with full Drag Sweeping, Mouse Wheel Scrolling, Arrow Navigation,
 * Mode Transitions, and Raycast Telemetry HUD.
 */

import * as THREE from 'three';

export function initHero3D() {
  const container = document.getElementById('msHero3DViewport');
  const canvas = document.getElementById('msHero3DCanvas');
  const hudEl = document.getElementById('msHero3DHud');

  if (!container || !canvas) return;

  let width = container.clientWidth || 540;
  let height = container.clientHeight || 560;

  // 1. Scene, Camera, Renderer
  const scene = new THREE.Scene();
  scene.fog = new THREE.FogExp2(0x0b0f17, 0.035);

  const camera = new THREE.PerspectiveCamera(45, width / height, 0.1, 100);
  camera.position.set(0, 0.3, 6.8);
  camera.lookAt(0, 0, 0);

  let renderer;
  try {
    renderer = new THREE.WebGLRenderer({
      canvas: canvas,
      alpha: true,
      antialias: true,
      powerPreference: 'high-performance'
    });
  } catch (e) {
    console.warn('WebGL not available for SaaS 3D Hero:', e);
    return;
  }

  renderer.setSize(width, height);
  renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 2));

  const masterGroup = new THREE.Group();
  scene.add(masterGroup);

  // 2. Lighting
  const ambientLight = new THREE.AmbientLight(0x0e1726, 2.4);
  scene.add(ambientLight);

  const keyLight = new THREE.DirectionalLight(0xffffff, 2.5);
  keyLight.position.set(3, 5, 5);
  scene.add(keyLight);

  const cyanFill = new THREE.PointLight(0x00f2fe, 4.2, 20);
  cyanFill.position.set(-3.5, 2, 4);
  scene.add(cyanFill);

  const purpleFill = new THREE.PointLight(0x9d4edd, 3.8, 20);
  purpleFill.position.set(3.5, -2, 3);
  scene.add(purpleFill);

  // 3. Orthogonal Cyber Base Grid (NO Round Rings)
  const gridHelper = new THREE.GridHelper(12, 24, 0x00f2fe, 0x14283c);
  gridHelper.position.y = -2.2;
  masterGroup.add(gridHelper);

  // Ambient Cyber Dust Particles
  const pCount = 100;
  const pGeo = new THREE.BufferGeometry();
  const pPos = new Float32Array(pCount * 3);
  for (let i = 0; i < pCount * 3; i += 3) {
    pPos[i] = (Math.random() - 0.5) * 12;
    pPos[i + 1] = (Math.random() - 0.5) * 8;
    pPos[i + 2] = (Math.random() - 0.5) * 8;
  }
  pGeo.setAttribute('position', new THREE.BufferAttribute(pPos, 3));
  const pMat = new THREE.PointsMaterial({
    color: 0x00f2fe,
    size: 0.05,
    transparent: true,
    opacity: 0.55
  });
  const particles = new THREE.Points(pGeo, pMat);
  masterGroup.add(particles);

  // 4. Load 6 Photorealistic 3D Shard Assets into 3D Glass Slabs
  const shardMeta = [
    { num: '01', title: 'Niche Scope Triage', role: 'Feature Strip & Problem Isolation', latency: '12ms' },
    { num: '02', title: 'Cloud Tenancy Core', role: 'Zero-Leakage Multi-Tenancy & RLS', latency: '18ms' },
    { num: '03', title: 'Edge Microservice Bus', role: 'Serverless Event Distribution', latency: '9ms' },
    { num: '04', title: 'AI Anticipation Node', role: 'Context Vector & RAG Pipeline', latency: '24ms' },
    { num: '05', title: 'Automated CI/CD Ops', role: 'Isolated Pods & Canary Deploy', latency: '14ms' },
    { num: '06', title: 'Zero-Trust Tenant Vault', role: 'AES-256 Crypt & Role Permissions', latency: '8ms' }
  ];

  const textureLoader = new THREE.TextureLoader();
  const cardGroup = new THREE.Group();
  masterGroup.add(cardGroup);

  const cards = [];
  const cardWidth = 2.0;
  const cardHeight = 2.7;
  const cardDepth = 0.06;

  const slabGeo = new THREE.BoxGeometry(cardWidth, cardHeight, cardDepth);
  const edgeGeo = new THREE.EdgesGeometry(slabGeo);

  shardMeta.forEach((meta, idx) => {
    const texPath = `/assets/img/saas/photo/shard-0${idx + 1}.jpg`;
    const texture = textureLoader.load(texPath);
    texture.colorSpace = THREE.SRGBColorSpace;

    const sideMat = new THREE.MeshStandardMaterial({
      color: 0x09101d,
      metalness: 0.85,
      roughness: 0.25,
      emissive: 0x040810
    });

    const frontMat = new THREE.MeshStandardMaterial({
      map: texture,
      roughness: 0.2,
      metalness: 0.25,
      emissive: 0x00f2fe,
      emissiveIntensity: 0.06
    });

    const materials = [sideMat, sideMat, sideMat, sideMat, frontMat, sideMat];
    const mesh = new THREE.Mesh(slabGeo, materials);
    mesh.castShadow = true;
    mesh.userData = { index: idx, meta: meta };

    const edgeMat = new THREE.LineBasicMaterial({
      color: idx % 2 === 0 ? 0x00f2fe : 0x9d4edd,
      transparent: true,
      opacity: 0.75
    });
    const edgeLines = new THREE.LineSegments(edgeGeo, edgeMat);
    mesh.add(edgeLines);

    cardGroup.add(mesh);
    cards.push({ mesh, edgeLines, edgeMat, frontMat, meta, index: idx });
  });

  // Connecting Fiber-Optic Circuit Lines
  const conduitMat = new THREE.LineBasicMaterial({ color: 0x00f2fe, transparent: true, opacity: 0.35 });
  const conduitPts = [];
  for (let i = 0; i < cards.length - 1; i++) {
    conduitPts.push(new THREE.Vector3(), new THREE.Vector3());
  }
  const conduitGeo = new THREE.BufferGeometry().setFromPoints(conduitPts);
  const conduitLines = new THREE.LineSegments(conduitGeo, conduitMat);
  cardGroup.add(conduitLines);

  function updateConduits() {
    const pos = conduitGeo.attributes.position;
    if (!pos) return;
    for (let i = 0; i < cards.length - 1; i++) {
      const p1 = cards[i].mesh.position;
      const p2 = cards[i + 1].mesh.position;
      pos.setXYZ(i * 2, p1.x, p1.y - 1.25, p1.z);
      pos.setXYZ(i * 2 + 1, p2.x, p2.y - 1.25, p2.z);
    }
    pos.needsUpdate = true;
  }

  // 5. MOTION & SCROLLING STATE
  let activeMode = 'fan'; // 'fan', 'blueprint', 'matrix'
  let currentFocus = 0.0;  // Continuous float tracking position
  let targetFocus = 0;     // Target integer card (0 to 5)
  let isDragging = false;
  let startPointerX = 0;
  let startFocus = 0;
  let lastDragTime = 0;
  let hoveredCard = null;

  // Pagination & Arrow Elements
  const prevBtn = container.querySelector('.ms-arrow-prev');
  const nextBtn = container.querySelector('.ms-arrow-next');
  const dotBtns = container.querySelectorAll('[data-hero-dot]');

  function updateActiveUI(index) {
    const rounded = Math.max(0, Math.min(cards.length - 1, Math.round(index)));
    dotBtns.forEach((dot, i) => {
      dot.classList.toggle('is-active', i === rounded);
    });

    if (hudEl) {
      const item = shardMeta[rounded];
      hudEl.innerHTML = `
        <div class="ms-hud-tag">STAGE ${item.num} // ACTIVE ARCHITECTURE SLAB</div>
        <div class="ms-hud-name">${item.title}</div>
        <div class="ms-hud-spec">${item.role}</div>
        <div class="ms-hud-metrics">
          <span>EDGE LATENCY: <strong>${item.latency}</strong></span>
          <span>STATUS: <strong style="color:#00f2fe;">OPERATIONAL</strong></span>
        </div>
      `;
      hudEl.style.opacity = '1';
    }
  }

  // Initial HUD update
  updateActiveUI(0);

  // Arrow Clicks
  if (prevBtn) {
    prevBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      targetFocus = Math.max(0, targetFocus - 1);
    });
  }
  if (nextBtn) {
    nextBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      targetFocus = Math.min(cards.length - 1, targetFocus + 1);
    });
  }

  // Dot Clicks
  dotBtns.forEach((dot, i) => {
    dot.addEventListener('click', (e) => {
      e.stopPropagation();
      targetFocus = i;
    });
  });

  // 6. POINTER DRAG & SWEEPING PHYSICS
  container.addEventListener('pointerdown', (e) => {
    // Ignore clicks on arrows/dots
    if (e.target.closest('.ms-hero-nav-arrow') || e.target.closest('.ms-hero-pagination')) return;
    isDragging = true;
    startPointerX = e.clientX;
    startFocus = currentFocus;
    lastDragTime = performance.now();
    container.style.cursor = 'grabbing';
    container.setPointerCapture(e.pointerId);
  });

  container.addEventListener('pointermove', (e) => {
    if (!isDragging) return;
    const deltaX = e.clientX - startPointerX;
    // Travel per card: ~140px per card sweep
    const offsetDelta = -deltaX / 140;
    currentFocus = Math.max(-0.4, Math.min(cards.length - 0.6, startFocus + offsetDelta));
    targetFocus = Math.round(currentFocus);
  });

  function releasePointer(e) {
    if (!isDragging) return;
    isDragging = false;
    container.style.cursor = 'grab';
    if (e.pointerId !== undefined && container.hasPointerCapture(e.pointerId)) {
      container.releasePointerCapture(e.pointerId);
    }
    // Snap to nearest card
    targetFocus = Math.max(0, Math.min(cards.length - 1, Math.round(currentFocus)));
  }

  container.addEventListener('pointerup', releasePointer);
  container.addEventListener('pointercancel', releasePointer);

  // 7. MOUSE WHEEL SCROLLING OVER BANNER
  container.addEventListener('wheel', (e) => {
    // If delta is largely horizontal, or holding shift, or deliberate scroll
    if (Math.abs(e.deltaY) > 25 || Math.abs(e.deltaX) > 25) {
      e.preventDefault(); // Prevent vertical jump while cycling cards
      const dir = (e.deltaY > 0 || e.deltaX > 0) ? 1 : -1;
      targetFocus = Math.max(0, Math.min(cards.length - 1, targetFocus + dir));
    }
  }, { passive: false });

  // 8. RAYCAST CLICK TO SELECT ANY SLAB
  const raycaster = new THREE.Raycaster();
  const mouse = new THREE.Vector2(-999, -999);

  container.addEventListener('pointermove', (e) => {
    const rect = container.getBoundingClientRect();
    mouse.x = ((e.clientX - rect.left) / rect.width) * 2 - 1;
    mouse.y = -((e.clientY - rect.top) / rect.height) * 2 + 1;
  });

  container.addEventListener('click', (e) => {
    if (e.target.closest('.ms-hero-nav-arrow') || e.target.closest('.ms-hero-pagination')) return;
    raycaster.setFromCamera(mouse, camera);
    const intersects = raycaster.intersectObjects(cards.map(c => c.mesh));
    if (intersects.length > 0) {
      const hitIndex = intersects[0].object.userData.index;
      targetFocus = hitIndex;
    }
  });

  // 9. MODE SWITCHER CONTROLS
  const modeBtns = document.querySelectorAll('[data-hero-3d-mode]');
  modeBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      modeBtns.forEach(b => b.classList.toggle('is-active', b === btn));
      activeMode = btn.getAttribute('data-hero-3d-mode') || 'fan';
    });
  });

  // 10. ANIMATION LOOP
  const clock = new THREE.Clock();
  let lastRounded = 0;

  function animate() {
    requestAnimationFrame(animate);
    const delta = clock.getDelta();
    const time = clock.getElapsedTime();

    // Smooth spring toward target focus when not actively dragging
    if (!isDragging) {
      currentFocus += (targetFocus - currentFocus) * 0.12;
    }

    const roundedFocus = Math.round(currentFocus);
    if (roundedFocus !== lastRounded) {
      lastRounded = roundedFocus;
      updateActiveUI(roundedFocus);
    }

    // Gentle ambient dust drift
    particles.rotation.y = time * 0.03;

    // Subtle master camera parallax tilt
    const targetMasterRotY = (mouse.x > -900 ? mouse.x * 0.12 : 0);
    const targetMasterRotX = (mouse.y > -900 ? -mouse.y * 0.08 : 0);
    masterGroup.rotation.y += (targetMasterRotY - masterGroup.rotation.y) * 0.06;
    masterGroup.rotation.x += (targetMasterRotX - masterGroup.rotation.x) * 0.06;

    // Position each card based on its signed distance from currentFocus
    cards.forEach((c, i) => {
      const d = i - currentFocus;
      const absD = Math.abs(d);

      let targetPos = new THREE.Vector3();
      let targetRot = new THREE.Euler();
      let targetScale = 1.0;

      if (activeMode === 'fan') {
        // Dynamic Sweeping 3D Fan Arc
        targetPos.x = d * 1.35;
        targetPos.y = -Math.pow(d, 2) * 0.09 + 0.15 + Math.sin(time * 1.5 + i * 0.7) * 0.03;
        targetPos.z = -Math.min(4.5, absD * 0.85);

        targetRot.x = 0.05;
        targetRot.y = -d * 0.22;
        targetRot.z = -d * 0.04;

        targetScale = Math.max(0.85, 1.08 - absD * 0.08);

      } else if (activeMode === 'blueprint') {
        // Vertical Exploded Tower Hierarchy
        const layerOffset = (i - currentFocus);
        targetPos.x = (i % 2 === 0 ? -1.3 : 1.3);
        targetPos.y = -layerOffset * 1.3;
        targetPos.z = -Math.abs(layerOffset) * 0.5;

        targetRot.x = 0.22;
        targetRot.y = (i % 2 === 0 ? 0.35 : -0.35);
        targetRot.z = (i % 2 === 0 ? -0.05 : 0.05);

        targetScale = Math.max(0.8, 1.05 - Math.abs(layerOffset) * 0.1);

      } else {
        // 3D Isometric Matrix Grid
        const col = i % 3;
        const row = Math.floor(i / 3);
        const shiftX = (currentFocus - 2.5) * 0.8;
        targetPos.x = (col - 1) * 2.2 - shiftX;
        targetPos.y = (row === 0 ? 1.25 : -1.25);
        targetPos.z = (1 - col) * 0.2;

        targetRot.x = 0.12;
        targetRot.y = -0.22;
        targetRot.z = 0;

        targetScale = 0.95;
      }

      // Center card highlight
      const isFocused = (absD < 0.5);
      if (isFocused) {
        c.edgeLines.material.color.setHex(0x00f2fe);
        c.edgeLines.material.opacity = 1.0;
        c.frontMat.emissiveIntensity = 0.25;
      } else {
        c.edgeLines.material.color.setHex(i % 2 === 0 ? 0x00f2fe : 0x9d4edd);
        c.edgeLines.material.opacity = Math.max(0.35, 0.75 - absD * 0.15);
        c.frontMat.emissiveIntensity = 0.04;
      }

      // Smooth lerp
      c.mesh.position.lerp(targetPos, 0.12);
      c.mesh.rotation.x += (targetRot.x - c.mesh.rotation.x) * 0.12;
      c.mesh.rotation.y += (targetRot.y - c.mesh.rotation.y) * 0.12;
      c.mesh.rotation.z += (targetRot.z - c.mesh.rotation.z) * 0.12;
      c.mesh.scale.setScalar(c.mesh.scale.x + (targetScale - c.mesh.scale.x) * 0.12);
    });

    updateConduits();
    renderer.render(scene, camera);
  }

  animate();

  // Resize handler
  window.addEventListener('resize', () => {
    if (!container || !renderer) return;
    width = container.clientWidth || 540;
    height = container.clientHeight || 560;
    camera.aspect = width / height;
    camera.updateProjectionMatrix();
    renderer.setSize(width, height);
  });
}
