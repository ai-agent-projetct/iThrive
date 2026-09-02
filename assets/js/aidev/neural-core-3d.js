/**
 * iThrive AI - Interactive 3D Quantum Neural Core Matrix
 * Real-time WebGL Synaptic Lattice, Gyroscopic Energy Rings & Floating Vector Tokens
 * Built with Three.js for Section 8: The 4-Layer iThrive AI Stack
 */

(function () {
  'use strict';

  function initNeuralCore3D() {
    const stage = document.getElementById('neural-core-3d-stage');
    const canvas = document.getElementById('neural-core-3d-canvas');
    const modeBadge = document.getElementById('neural-core-mode');
    const metricBadge = document.getElementById('neural-core-metric');

    if (!stage || !canvas || typeof THREE === 'undefined') return;

    let width = stage.clientWidth || 460;
    let height = stage.clientHeight || 420;

    // -------------------------------------------------------------
    // 1. Scene, Camera & Renderer
    // -------------------------------------------------------------
    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(45, width / height, 0.1, 1000);
    camera.position.set(0, 0, 5.8);

    const renderer = new THREE.WebGLRenderer({
      canvas: canvas,
      alpha: true,
      antialias: true,
      powerPreference: 'high-performance'
    });
    renderer.setSize(width, height);
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));

    // Master Neural Group (Rotatable by User)
    const masterGroup = new THREE.Group();
    scene.add(masterGroup);

    // -------------------------------------------------------------
    // 2. Central Quantum Neural Core (Glowing Inner Lattice)
    // -------------------------------------------------------------
    // Inner Core Sphere
    const innerCoreGeo = new THREE.SphereGeometry(1.05, 32, 32);
    const innerCoreMat = new THREE.MeshStandardMaterial({
      color: 0x070b1e,
      roughness: 0.2,
      metalness: 0.8,
      emissive: 0x140d3a,
      emissiveIntensity: 0.6
    });
    const innerCoreMesh = new THREE.Mesh(innerCoreGeo, innerCoreMat);
    masterGroup.add(innerCoreMesh);

    // Synaptic Geodesic Lattice (Wireframe Layer)
    const icoGeo = new THREE.IcosahedronGeometry(1.4, 2);
    const icoWireMat = new THREE.MeshBasicMaterial({
      color: 0x22d3ee,
      wireframe: true,
      transparent: true,
      opacity: 0.55
    });
    const icoMesh = new THREE.Mesh(icoGeo, icoWireMat);
    masterGroup.add(icoMesh);

    // Synaptic Nodes (Glowing Spheres at Vertices)
    const icoPositions = icoGeo.attributes.position;
    const nodeCount = icoPositions.count;
    const nodeGeo = new THREE.SphereGeometry(0.045, 8, 8);
    const nodeMat = new THREE.MeshBasicMaterial({ color: 0x22d3ee });
    const nodesInstanced = new THREE.InstancedMesh(nodeGeo, nodeMat, nodeCount);

    const dummy = new THREE.Object3D();
    for (let i = 0; i < nodeCount; i++) {
      dummy.position.set(
        icoPositions.getX(i),
        icoPositions.getY(i),
        icoPositions.getZ(i)
      );
      dummy.updateMatrix();
      nodesInstanced.setMatrixAt(i, dummy.matrix);
    }
    masterGroup.add(nodesInstanced);

    // Outer Geodesic Shell (Magenta Synaptic Layer)
    const outerIcoGeo = new THREE.IcosahedronGeometry(1.85, 1);
    const outerIcoMat = new THREE.MeshBasicMaterial({
      color: 0xd946ef,
      wireframe: true,
      transparent: true,
      opacity: 0.3
    });
    const outerIcoMesh = new THREE.Mesh(outerIcoGeo, outerIcoMat);
    masterGroup.add(outerIcoMesh);

    // -------------------------------------------------------------
    // 3. Gyroscopic Quantum Energy Rings
    // -------------------------------------------------------------
    function createGlowRing(radius, tube, color, opacity) {
      const geo = new THREE.TorusGeometry(radius, tube, 16, 80);
      const mat = new THREE.MeshBasicMaterial({
        color: color,
        transparent: true,
        opacity: opacity
      });
      return new THREE.Mesh(geo, mat);
    }

    const ring1 = createGlowRing(2.1, 0.02, 0x22d3ee, 0.75);
    ring1.rotation.x = Math.PI / 3;
    masterGroup.add(ring1);

    const ring2 = createGlowRing(2.3, 0.018, 0x8b2fc9, 0.65);
    ring2.rotation.y = Math.PI / 4;
    ring2.rotation.z = Math.PI / 6;
    masterGroup.add(ring2);

    const ring3 = createGlowRing(2.5, 0.015, 0xd946ef, 0.55);
    ring3.rotation.x = -Math.PI / 4;
    ring3.rotation.y = Math.PI / 3;
    masterGroup.add(ring3);

    // -------------------------------------------------------------
    // 4. Floating 3D Vector Tokens & Knowledge Data Nodes
    // -------------------------------------------------------------
    const tokenGroup = new THREE.Group();
    const tokenGeo = new THREE.BoxGeometry(0.12, 0.12, 0.12);
    const tokenMat1 = new THREE.MeshBasicMaterial({ color: 0x22d3ee, wireframe: true });
    const tokenMat2 = new THREE.MeshBasicMaterial({ color: 0x38bdf8 });
    const tokenMat3 = new THREE.MeshBasicMaterial({ color: 0xd946ef, wireframe: true });

    const tokens = [];
    for (let i = 0; i < 16; i++) {
      const mat = i % 3 === 0 ? tokenMat1 : i % 3 === 1 ? tokenMat2 : tokenMat3;
      const tMesh = new THREE.Mesh(tokenGeo, mat);
      const angle = (i / 16) * Math.PI * 2;
      const dist = 2.0 + Math.random() * 0.7;
      tMesh.position.set(
        Math.cos(angle) * dist,
        (Math.random() - 0.5) * 1.8,
        Math.sin(angle) * dist
      );
      tMesh.userData = {
        speed: 0.01 + Math.random() * 0.02,
        rotSpeed: 0.02 + Math.random() * 0.03,
        angle: angle,
        dist: dist,
        yBase: tMesh.position.y
      };
      tokenGroup.add(tMesh);
      tokens.push(tMesh);
    }
    masterGroup.add(tokenGroup);

    // -------------------------------------------------------------
    // 5. Ambient Neural Particle Swarm (Vector Field)
    // -------------------------------------------------------------
    const pCount = 220;
    const pPositions = new Float32Array(pCount * 3);
    const pColors = new Float32Array(pCount * 3);
    const c1 = new THREE.Color(0x22d3ee);
    const c2 = new THREE.Color(0xd946ef);

    for (let i = 0; i < pCount; i++) {
      const radius = 1.2 + Math.random() * 2.2;
      const theta = Math.random() * Math.PI * 2;
      const phi = Math.acos(Math.random() * 2 - 1);

      pPositions[i * 3] = radius * Math.sin(phi) * Math.cos(theta);
      pPositions[i * 3 + 1] = radius * Math.sin(phi) * Math.sin(theta);
      pPositions[i * 3 + 2] = radius * Math.cos(phi);

      const col = Math.random() > 0.5 ? c1 : c2;
      pColors[i * 3] = col.r;
      pColors[i * 3 + 1] = col.g;
      pColors[i * 3 + 2] = col.b;
    }

    const pGeo = new THREE.BufferGeometry();
    pGeo.setAttribute('position', new THREE.BufferAttribute(pPositions, 3));
    pGeo.setAttribute('color', new THREE.BufferAttribute(pColors, 3));

    const pMat = new THREE.PointsMaterial({
      size: 0.035,
      vertexColors: true,
      transparent: true,
      opacity: 0.75,
      blending: THREE.AdditiveBlending
    });
    const particleField = new THREE.Points(pGeo, pMat);
    masterGroup.add(particleField);

    // -------------------------------------------------------------
    // 6. Lighting
    // -------------------------------------------------------------
    const ambientLight = new THREE.AmbientLight(0x0c1024, 2.0);
    scene.add(ambientLight);

    const coreLightCyan = new THREE.PointLight(0x22d3ee, 3.5, 8);
    coreLightCyan.position.set(0, 0, 0);
    masterGroup.add(coreLightCyan);

    const keyLight = new THREE.DirectionalLight(0x38bdf8, 2.0);
    keyLight.position.set(4, 5, 4);
    scene.add(keyLight);

    const fillLight = new THREE.DirectionalLight(0xd946ef, 1.8);
    fillLight.position.set(-4, -3, 3);
    scene.add(fillLight);

    // -------------------------------------------------------------
    // 7. Interactive Drag & Mouse Orbital Controls
    // -------------------------------------------------------------
    let isDragging = false;
    let previousMousePosition = { x: 0, y: 0 };
    let targetRotation = { x: 0.2, y: 0.3 };
    let currentRotation = { x: 0.2, y: 0.3 };
    let autoRotateSpeed = 0.005;

    stage.addEventListener('mousedown', (e) => {
      isDragging = true;
      previousMousePosition = { x: e.clientX, y: e.clientY };
    });

    window.addEventListener('mousemove', (e) => {
      if (isDragging) {
        const deltaX = e.clientX - previousMousePosition.x;
        const deltaY = e.clientY - previousMousePosition.y;

        targetRotation.y += deltaX * 0.008;
        targetRotation.x += deltaY * 0.008;

        previousMousePosition = { x: e.clientX, y: e.clientY };
      }
    });

    window.addEventListener('mouseup', () => {
      isDragging = false;
    });

    // Touch Support for Mobile
    stage.addEventListener('touchstart', (e) => {
      if (e.touches.length === 1) {
        isDragging = true;
        previousMousePosition = { x: e.touches[0].clientX, y: e.touches[0].clientY };
      }
    }, { passive: true });

    window.addEventListener('touchmove', (e) => {
      if (isDragging && e.touches.length === 1) {
        const deltaX = e.touches[0].clientX - previousMousePosition.x;
        const deltaY = e.touches[0].clientY - previousMousePosition.y;

        targetRotation.y += deltaX * 0.008;
        targetRotation.x += deltaY * 0.008;

        previousMousePosition = { x: e.touches[0].clientX, y: e.touches[0].clientY };
      }
    }, { passive: true });

    window.addEventListener('touchend', () => {
      isDragging = false;
    });

    // -------------------------------------------------------------
    // 8. 4-Layer Card Interactivity (Reactivity on Left Cards)
    // -------------------------------------------------------------
    const layerCards = document.querySelectorAll('.eco-layer-card');
    const layerThemes = [
      { name: 'LAYER 04: UI & GUARDRAILS', metric: 'NIST AI RMF · 3D WEBGL', color: 0xd946ef },
      { name: 'LAYER 03: AGENTIC ORCHESTRATION', metric: 'LANGGRAPH · CREWAI', color: 0x8b2fc9 },
      { name: 'LAYER 02: FOUNDATION MODELS', metric: 'LLAMA 3.1 · FP16 TRITON', color: 0x3b82f6 },
      { name: 'LAYER 01: DATA & VECTOR INFRA', metric: '1536-D VECTOR EMBEDDINGS', color: 0x22d3ee }
    ];

    layerCards.forEach((card, idx) => {
      card.addEventListener('mouseenter', () => {
        const theme = layerThemes[idx] || layerThemes[3];
        if (modeBadge) modeBadge.textContent = theme.name;
        if (metricBadge) metricBadge.innerHTML = `<i class="fa-solid fa-bolt" style="color: var(--accent-cyan);"></i> ${theme.metric}`;
        
        // Highlight 3D Core Color
        coreLightCyan.color.setHex(theme.color);
        icoWireMat.color.setHex(theme.color);
        autoRotateSpeed = 0.018;
      });

      card.addEventListener('mouseleave', () => {
        if (modeBadge) modeBadge.textContent = 'MODE: FULL STACK';
        if (metricBadge) metricBadge.innerHTML = `<i class="fa-solid fa-bolt" style="color: var(--accent-cyan);"></i> 1536-D EMBEDDINGS`;
        coreLightCyan.color.setHex(0x22d3ee);
        icoWireMat.color.setHex(0x22d3ee);
        autoRotateSpeed = 0.005;
      });
    });

    // -------------------------------------------------------------
    // 9. Resize Handling
    // -------------------------------------------------------------
    function onResize() {
      if (!stage || !renderer) return;
      const w = stage.clientWidth || 460;
      const h = stage.clientHeight || 420;
      if (w > 0 && h > 0) {
        camera.aspect = w / h;
        camera.updateProjectionMatrix();
        renderer.setSize(w, h);
        renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
      }
    }

    window.addEventListener('resize', onResize);
    if (window.ResizeObserver) {
      const ro = new ResizeObserver(() => onResize());
      ro.observe(stage);
    }
    setTimeout(onResize, 100);

    // -------------------------------------------------------------
    // 10. Animation Loop
    // -------------------------------------------------------------
    const clock = new THREE.Clock();

    function animate() {
      requestAnimationFrame(animate);
      const elapsed = clock.getElapsedTime();

      // Idle Rotation & Inertia Lerp
      if (!isDragging) {
        targetRotation.y += autoRotateSpeed;
      }
      currentRotation.x += (targetRotation.x - currentRotation.x) * 0.08;
      currentRotation.y += (targetRotation.y - currentRotation.y) * 0.08;

      masterGroup.rotation.x = currentRotation.x;
      masterGroup.rotation.y = currentRotation.y;

      // Internal Layer Counter-Rotations
      icoMesh.rotation.y = -elapsed * 0.15;
      icoMesh.rotation.x = Math.sin(elapsed * 0.3) * 0.1;

      outerIcoMesh.rotation.y = elapsed * 0.22;
      outerIcoMesh.rotation.z = Math.cos(elapsed * 0.25) * 0.15;

      ring1.rotation.z = elapsed * 0.35;
      ring2.rotation.x = elapsed * 0.28;
      ring3.rotation.y = -elapsed * 0.32;

      // Core Breathing Pulse
      const pulse = 1.0 + Math.sin(elapsed * 2.8) * 0.05;
      innerCoreMesh.scale.setScalar(pulse);
      coreLightCyan.intensity = 3.0 + Math.sin(elapsed * 3.5) * 1.2;

      // Orbiting Vector Tokens
      tokens.forEach((t) => {
        t.userData.angle += t.userData.speed;
        t.position.x = Math.cos(t.userData.angle) * t.userData.dist;
        t.position.z = Math.sin(t.userData.angle) * t.userData.dist;
        t.position.y = t.userData.yBase + Math.sin(elapsed * 2.0 + t.userData.angle) * 0.2;
        t.rotation.x += t.userData.rotSpeed;
        t.rotation.y += t.userData.rotSpeed;
      });

      particleField.rotation.y = elapsed * 0.04;

      renderer.render(scene, camera);
    }

    animate();
  }

  function tryInitNeuralCore3D() {
    if (typeof THREE === 'undefined') {
      setTimeout(tryInitNeuralCore3D, 50);
      return;
    }
    const stage = document.getElementById('neural-core-3d-stage');
    const canvas = document.getElementById('neural-core-3d-canvas');
    if (!stage || !canvas) {
      setTimeout(tryInitNeuralCore3D, 50);
      return;
    }
    initNeuralCore3D();
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', tryInitNeuralCore3D);
  } else {
    tryInitNeuralCore3D();
  }
})();
