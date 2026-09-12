/**
 * iThrive Micro-SaaS - Interactive 3D Architecture & Cost Configurator
 * Real-time Three.js WebGL Architecture Model + Dynamic Cost & ROI Engine.
 */

import * as THREE from 'three';

export function initConfigurator3D() {
  const container = document.getElementById('msConfig3DViewport');
  const canvas = document.getElementById('msConfig3DCanvas');

  if (!container || !canvas) return;

  let width = container.clientWidth || 540;
  let height = container.clientHeight || 460;

  // 1. Scene, Camera, Renderer
  const scene = new THREE.Scene();
  scene.fog = new THREE.FogExp2(0x0b0f17, 0.05);

  const camera = new THREE.PerspectiveCamera(40, width / height, 0.1, 100);
  camera.position.set(4.5, 4.2, 5.5);
  camera.lookAt(0, 0.2, 0);

  let renderer;
  try {
    renderer = new THREE.WebGLRenderer({
      canvas: canvas,
      alpha: true,
      antialias: true,
      powerPreference: 'high-performance'
    });
  } catch (e) {
    console.warn('WebGL not available for Configurator 3D');
    return;
  }

  renderer.setSize(width, height);
  renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 2));

  const modelGroup = new THREE.Group();
  scene.add(modelGroup);

  // 2. Lights
  const ambLight = new THREE.AmbientLight(0x0e1726, 3.0);
  scene.add(ambLight);

  const keyLight = new THREE.DirectionalLight(0x00f2fe, 3.0);
  keyLight.position.set(5, 8, 4);
  scene.add(keyLight);

  const fillLight = new THREE.PointLight(0x9d4edd, 2.5, 12);
  fillLight.position.set(-4, 3, -3);
  scene.add(fillLight);

  // 3. Base Platform Grid
  const baseGeo = new THREE.BoxGeometry(4.2, 0.15, 4.2);
  const baseMat = new THREE.MeshStandardMaterial({
    color: 0x090e18,
    metalness: 0.9,
    roughness: 0.2,
    emissive: 0x00f2fe,
    emissiveIntensity: 0.12
  });
  const basePlatform = new THREE.Mesh(baseGeo, baseMat);
  basePlatform.position.y = -0.08;
  modelGroup.add(basePlatform);

  // Grid lines on platform
  const gridHelper = new THREE.GridHelper(4.0, 8, 0x00f2fe, 0x1a2638);
  gridHelper.position.y = 0.01;
  modelGroup.add(gridHelper);

  // 4. Central Database Cylinder
  const dbGroup = new THREE.Group();
  const dbMat = new THREE.MeshStandardMaterial({
    color: 0x0a1424,
    metalness: 0.8,
    roughness: 0.2,
    emissive: 0x00f2fe,
    emissiveIntensity: 0.35
  });

  for (let l = 0; l < 3; l++) {
    const layerGeo = new THREE.CylinderGeometry(0.55, 0.55, 0.25, 24);
    const layerMesh = new THREE.Mesh(layerGeo, dbMat);
    layerMesh.position.y = 0.15 + l * 0.32;
    dbGroup.add(layerMesh);

    // Glowing rim ring
    const ringGeo = new THREE.TorusGeometry(0.57, 0.015, 8, 32);
    const ringMat = new THREE.MeshBasicMaterial({ color: 0x00f2fe });
    const ringMesh = new THREE.Mesh(ringGeo, ringMat);
    ringMesh.rotation.x = Math.PI / 2;
    ringMesh.position.y = 0.15 + l * 0.32;
    dbGroup.add(ringMesh);
  }
  dbGroup.position.set(-1.1, 0, -1.1);
  modelGroup.add(dbGroup);

  // 5. Dynamic Compute Modules (Lambda Serverless / Container Pods)
  const computePods = [];
  const podMat = new THREE.MeshStandardMaterial({
    color: 0x0c192c,
    metalness: 0.85,
    roughness: 0.15,
    emissive: 0x4ea8ff,
    emissiveIntensity: 0.4
  });

  function rebuildComputePods(count, colorHex) {
    computePods.forEach(p => modelGroup.remove(p));
    computePods.length = 0;

    const positions = [
      { x: 0.9, z: -1.1 },
      { x: 0.9, z: 0.2 },
      { x: 0.9, z: 1.4 },
      { x: -0.3, z: 1.4 },
      { x: -1.4, z: 1.4 },
      { x: -1.4, z: 0.2 }
    ];

    for (let i = 0; i < Math.min(count, positions.length); i++) {
      const pos = positions[i];
      const pMesh = new THREE.Group();

      const box = new THREE.Mesh(new THREE.BoxGeometry(0.65, 0.75, 0.65), podMat);
      box.position.y = 0.38;
      pMesh.add(box);

      const wire = new THREE.LineSegments(
        new THREE.EdgesGeometry(new THREE.BoxGeometry(0.65, 0.75, 0.65)),
        new THREE.LineBasicMaterial({ color: colorHex, transparent: true, opacity: 0.9 })
      );
      wire.position.y = 0.38;
      pMesh.add(wire);

      // Status LED
      const led = new THREE.Mesh(new THREE.SphereGeometry(0.06, 8, 8), new THREE.MeshBasicMaterial({ color: 0x00f2fe }));
      led.position.set(0, 0.82, 0);
      pMesh.add(led);

      pMesh.position.set(pos.x, 0, pos.z);
      modelGroup.add(pMesh);
      computePods.push(pMesh);
    }
  }

  // 6. Detachable AI Copilot Neural Node
  const aiGroup = new THREE.Group();
  const aiCore = new THREE.Mesh(
    new THREE.DodecahedronGeometry(0.42, 1),
    new THREE.MeshStandardMaterial({
      color: 0x1a0933,
      emissive: 0x9d4edd,
      emissiveIntensity: 0.8,
      roughness: 0.2,
      metalness: 0.8
    })
  );
  aiGroup.add(aiCore);

  const aiRing = new THREE.Mesh(
    new THREE.TorusGeometry(0.62, 0.02, 16, 40),
    new THREE.MeshBasicMaterial({ color: 0x9d4edd })
  );
  aiRing.rotation.x = Math.PI / 3;
  aiGroup.add(aiRing);

  aiGroup.position.set(0, 1.6, 0);
  modelGroup.add(aiGroup);

  // 7. Laser Conduits on Platform
  const laserMat = new THREE.LineBasicMaterial({ color: 0x00f2fe, transparent: true, opacity: 0.6 });
  const laserGeo = new THREE.BufferGeometry().setFromPoints([
    new THREE.Vector3(-1.1, 0.05, -1.1),
    new THREE.Vector3(0, 0.05, 0),
    new THREE.Vector3(0.9, 0.05, -1.1),
    new THREE.Vector3(0.9, 0.05, 0.2),
    new THREE.Vector3(0, 0.05, 0)
  ]);
  const laserLines = new THREE.Line(laserGeo, laserMat);
  modelGroup.add(laserLines);

  // Initial build with 3 pods (Solo MVP)
  rebuildComputePods(3, 0x00f2fe);

  // 8. State & UI Binding
  let currentScale = 'mvp'; // mvp, growth, enterprise
  let currentCloud = 'aws'; // aws, gcp, cloudflare
  const selectedAi = new Set(['anticipator', 'queue']);

  const pricingTable = {
    mvp: {
      aws: { cost: 18, time: '4–6 Weeks', users: '8 paying users @ $29/mo' },
      gcp: { cost: 26, time: '5–7 Weeks', users: '11 paying users @ $29/mo' },
      cloudflare: { cost: 12, time: '3–5 Weeks', users: '5 paying users @ $29/mo' }
    },
    growth: {
      aws: { cost: 48, time: '6–8 Weeks', users: '18 paying users @ $39/mo' },
      gcp: { cost: 64, time: '7–9 Weeks', users: '22 paying users @ $39/mo' },
      cloudflare: { cost: 35, time: '5–7 Weeks', users: '14 paying users @ $39/mo' }
    },
    enterprise: {
      aws: { cost: 120, time: '8–12 Weeks', users: '35 paying users @ $49/mo' },
      gcp: { cost: 145, time: '9–13 Weeks', users: '42 paying users @ $49/mo' },
      cloudflare: { cost: 89, time: '7–10 Weeks', users: '28 paying users @ $49/mo' }
    }
  };

  function updateConfigurator() {
    const data = pricingTable[currentScale][currentCloud];
    const costEl = document.getElementById('msConfigCost');
    const timeEl = document.getElementById('msConfigTime');
    const beEl = document.getElementById('msConfigBE');

    // Add small AI add-on costs
    let totalCost = data.cost + (selectedAi.size * 5);
    if (costEl) costEl.textContent = `$${totalCost} / month`;
    if (timeEl) timeEl.textContent = data.time;
    if (beEl) beEl.textContent = data.users;

    // 3D Visual update
    const podCount = currentScale === 'mvp' ? 3 : currentScale === 'growth' ? 5 : 6;
    const colorHex = currentCloud === 'aws' ? 0x00f2fe : currentCloud === 'gcp' ? 0x4ea8ff : 0x9d4edd;
    rebuildComputePods(podCount, colorHex);

    // AI Core visibility / pulsing
    aiGroup.visible = selectedAi.size > 0;
    aiCore.scale.setScalar(0.7 + selectedAi.size * 0.18);
  }

  // Bind Scope Buttons
  document.querySelectorAll('[data-config-scale]').forEach(btn => {
    btn.addEventListener('click', () => {
      document.querySelectorAll('[data-config-scale]').forEach(b => b.classList.remove('is-active'));
      btn.classList.add('is-active');
      currentScale = btn.dataset.configScale;
      updateConfigurator();
    });
  });

  // Bind Cloud Buttons
  document.querySelectorAll('[data-config-cloud]').forEach(btn => {
    btn.addEventListener('click', () => {
      document.querySelectorAll('[data-config-cloud]').forEach(b => b.classList.remove('is-active'));
      btn.classList.add('is-active');
      currentCloud = btn.dataset.configCloud;
      updateConfigurator();
    });
  });

  // Bind AI Checkboxes
  document.querySelectorAll('[data-config-ai]').forEach(chk => {
    chk.addEventListener('change', () => {
      const val = chk.dataset.configAi;
      if (chk.checked) selectedAi.add(val);
      else selectedAi.delete(val);
      updateConfigurator();
    });
  });

  // Bind Lock-in Scope Button
  const lockBtn = document.getElementById('msConfigLockBtn');
  if (lockBtn) {
    lockBtn.addEventListener('click', () => {
      const scopeSummary = `Selected Stack: Scale=${currentScale.toUpperCase()}, Cloud=${currentCloud.toUpperCase()}, AI=[${Array.from(selectedAi).join(', ')}]`;
      const modalTextarea = document.getElementById('modal-message');
      if (modalTextarea) {
        modalTextarea.value = `I want to build a Micro-SaaS with this architecture:\n- ${scopeSummary}\n- Target Launch: ${pricingTable[currentScale][currentCloud].time}\n\nPlease prepare our scope blueprint.`;
      }
      const openBtn = document.querySelector('[data-modal-open]');
      if (openBtn) openBtn.click();
    });
  }

  // 9. Mouse drag rotation on 3D canvas
  let isDragging = false;
  let prevMouseX = 0;
  let prevMouseY = 0;

  canvas.addEventListener('pointerdown', e => {
    isDragging = true;
    prevMouseX = e.clientX;
    prevMouseY = e.clientY;
  });

  window.addEventListener('pointermove', e => {
    if (!isDragging) return;
    const deltaX = e.clientX - prevMouseX;
    const deltaY = e.clientY - prevMouseY;
    modelGroup.rotation.y += deltaX * 0.008;
    camera.position.y = Math.max(1.8, Math.min(6.5, camera.position.y - deltaY * 0.015));
    camera.lookAt(0, 0.2, 0);
    prevMouseX = e.clientX;
    prevMouseY = e.clientY;
  });

  window.addEventListener('pointerup', () => { isDragging = false; });

  // 10. Animation Loop
  let clock = new THREE.Clock();

  function animate() {
    requestAnimationFrame(animate);
    const time = clock.getElapsedTime();

    if (!isDragging) {
      modelGroup.rotation.y += 0.004;
    }

    if (aiGroup.visible) {
      aiGroup.rotation.y = time * 0.8;
      aiRing.rotation.z = time * 0.6;
      aiGroup.position.y = 1.6 + Math.sin(time * 2.0) * 0.1;
    }

    // Pods slight hovering
    computePods.forEach((pod, idx) => {
      pod.position.y = Math.sin(time * 2.5 + idx * 0.8) * 0.04;
    });

    renderer.render(scene, camera);
  }

  animate();
  updateConfigurator();
}
