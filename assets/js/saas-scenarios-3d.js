/**
 * iThrive Micro-SaaS - Interactive 3D Client Scenario & Architecture Blueprint Engine
 * Real-time Three.js WebGL Scene rendering the active microservice architecture
 * corresponding to real-world client search queries & scenarios.
 * Zero round rings - pure high-tech orthogonal isometric cyber architecture.
 */

import * as THREE from 'three';

export function initScenarios3D() {
  const container = document.getElementById('msScenario3DViewport');
  const canvas = document.getElementById('msScenario3DCanvas');

  if (!container || !canvas) return;

  let width = container.clientWidth || 500;
  let height = container.clientHeight || 460;

  const scene = new THREE.Scene();
  scene.fog = new THREE.FogExp2(0x0b0f17, 0.04);

  const camera = new THREE.PerspectiveCamera(40, width / height, 0.1, 100);
  camera.position.set(4.5, 4.2, 5.8);
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
    console.warn('WebGL not available for SaaS Scenario 3D:', e);
    return;
  }

  renderer.setSize(width, height);
  renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 2));

  const root = new THREE.Group();
  scene.add(root);

  // Lighting
  const ambientLight = new THREE.AmbientLight(0x0e1726, 2.0);
  scene.add(ambientLight);

  const keyLight = new THREE.DirectionalLight(0xffffff, 2.4);
  keyLight.position.set(5, 8, 6);
  scene.add(keyLight);

  const cyanLight = new THREE.PointLight(0x00f2fe, 3.5, 15);
  cyanLight.position.set(-3, 3, 2);
  scene.add(cyanLight);

  const purpleLight = new THREE.PointLight(0x9d4edd, 3.0, 15);
  purpleLight.position.set(3, 2, -2);
  scene.add(purpleLight);

  // 1. Isometric Cyber Platform (Rectangular, NO Round Rings)
  const baseGeo = new THREE.BoxGeometry(4.8, 0.15, 4.8);
  const baseMat = new THREE.MeshStandardMaterial({
    color: 0x08101a,
    metalness: 0.85,
    roughness: 0.2,
    emissive: 0x030810
  });
  const baseMesh = new THREE.Mesh(baseGeo, baseMat);
  baseMesh.position.y = -0.5;
  root.add(baseMesh);

  // Platform Edge Highlight
  const baseEdgeGeo = new THREE.EdgesGeometry(baseGeo);
  const baseEdgeMat = new THREE.LineBasicMaterial({ color: 0x00f2fe, transparent: true, opacity: 0.6 });
  const baseEdges = new THREE.LineSegments(baseEdgeGeo, baseEdgeMat);
  baseMesh.add(baseEdges);

  // Platform Surface Grid
  const gridHelper = new THREE.GridHelper(4.8, 12, 0x00f2fe, 0x14283c);
  gridHelper.position.y = -0.42;
  root.add(gridHelper);

  // 2. 3D Architectural Nodes
  const nodeDefs = [
    { id: 'gateway', name: 'Edge Gateway', pos: [-1.4, -0.1, 1.4], size: [0.9, 0.6, 0.9], color: 0x00f2fe },
    { id: 'compute', name: 'Serverless Core', pos: [0, 0.15, 0], size: [1.2, 1.1, 1.2], color: 0x9d4edd },
    { id: 'database', name: 'Tenant RLS Vault', pos: [1.4, 0.05, 1.4], size: [0.9, 0.9, 0.9], color: 0x00f2fe },
    { id: 'ai', name: 'Private AI Engine', pos: [0, 0.45, -1.4], size: [0.85, 0.85, 0.85], color: 0x4ea8ff },
    { id: 'billing', name: 'Stripe Metering', pos: [1.5, -0.15, -1.2], size: [0.75, 0.5, 0.75], color: 0x9d4edd },
    { id: 'portal', name: 'Client UI Portal', pos: [-1.4, -0.15, -1.2], size: [0.75, 0.5, 0.75], color: 0x00f2fe }
  ];

  const nodeMeshes = {};
  nodeDefs.forEach(def => {
    const geo = new THREE.BoxGeometry(...def.size);
    const mat = new THREE.MeshStandardMaterial({
      color: 0x0a1424,
      metalness: 0.8,
      roughness: 0.25,
      emissive: def.color,
      emissiveIntensity: 0.15
    });
    const mesh = new THREE.Mesh(geo, mat);
    mesh.position.set(...def.pos);

    const edgeGeo = new THREE.EdgesGeometry(geo);
    const edgeMat = new THREE.LineBasicMaterial({ color: def.color, transparent: true, opacity: 0.75 });
    const edges = new THREE.LineSegments(edgeGeo, edgeMat);
    mesh.add(edges);

    // Glowing top beacon
    const beaconGeo = new THREE.BoxGeometry(0.12, 0.12, 0.12);
    const beaconMat = new THREE.MeshBasicMaterial({ color: def.color });
    const beacon = new THREE.Mesh(beaconGeo, beaconMat);
    beacon.position.y = def.size[1] / 2 + 0.08;
    mesh.add(beacon);

    root.add(mesh);
    nodeMeshes[def.id] = { mesh, mat, edges, edgeMat, beacon, beaconMat, def, basePos: mesh.position.clone() };
  });

  // 3. Laser Conduit Connections
  const conduitDefs = [
    ['gateway', 'compute'],
    ['compute', 'database'],
    ['compute', 'ai'],
    ['compute', 'billing'],
    ['gateway', 'portal'],
    ['ai', 'database']
  ];

  const conduitLines = [];
  conduitDefs.forEach(([fromId, toId]) => {
    const p1 = nodeMeshes[fromId].mesh.position;
    const p2 = nodeMeshes[toId].mesh.position;
    const pts = [p1.clone().setY(-0.35), p2.clone().setY(-0.35)];
    const geo = new THREE.BufferGeometry().setFromPoints(pts);
    const mat = new THREE.LineBasicMaterial({ color: 0x00f2fe, transparent: true, opacity: 0.4 });
    const line = new THREE.Line(geo, mat);
    root.add(line);
    conduitLines.push({ line, fromId, toId, mat });
  });

  // 4. Data Packets (Pulsing cubes travelling along conduits)
  const packetCount = 8;
  const packetGeo = new THREE.BoxGeometry(0.08, 0.08, 0.08);
  const packetMat = new THREE.MeshBasicMaterial({ color: 0x00f2fe });
  const packets = [];

  for (let i = 0; i < packetCount; i++) {
    const pMesh = new THREE.Mesh(packetGeo, packetMat);
    root.add(pMesh);
    packets.push({
      mesh: pMesh,
      conduitIdx: i % conduitDefs.length,
      progress: Math.random(),
      speed: 0.4 + Math.random() * 0.3
    });
  }

  // Active scenario logic
  const scenarioNodeMap = {
    spreadsheet: ['gateway', 'compute', 'database', 'billing'],
    copilot: ['gateway', 'compute', 'ai', 'database'],
    whitelabel: ['gateway', 'portal', 'compute', 'database', 'billing'],
    pivot: ['portal', 'compute', 'ai', 'billing']
  };

  let activeScenario = 'spreadsheet';

  window.setScenario3D = function(scenarioId) {
    activeScenario = scenarioId;
    const activeNodes = scenarioNodeMap[scenarioId] || nodeDefs.map(d => d.id);

    Object.keys(nodeMeshes).forEach(id => {
      const n = nodeMeshes[id];
      const isActive = activeNodes.includes(id);

      if (isActive) {
        n.mat.emissiveIntensity = 0.55;
        n.edgeMat.opacity = 1.0;
        n.mesh.scale.set(1.08, 1.08, 1.08);
      } else {
        n.mat.emissiveIntensity = 0.08;
        n.edgeMat.opacity = 0.25;
        n.mesh.scale.set(0.95, 0.95, 0.95);
      }
    });

    conduitLines.forEach(c => {
      const active = activeNodes.includes(c.fromId) && activeNodes.includes(c.toId);
      c.mat.opacity = active ? 0.9 : 0.15;
      c.mat.color.setHex(active ? 0x00f2fe : 0x14283c);
    });
  };

  // Initial call
  window.setScenario3D('spreadsheet');

  // Drag controls
  let isDragging = false;
  let previousMouseX = 0;
  let previousMouseY = 0;
  let targetRotY = 0.4;
  let targetRotX = 0.1;

  container.addEventListener('pointerdown', (e) => {
    isDragging = true;
    previousMouseX = e.clientX;
    previousMouseY = e.clientY;
    container.style.cursor = 'grabbing';
  });

  window.addEventListener('pointerup', () => {
    isDragging = false;
    if (container) container.style.cursor = 'grab';
  });

  container.addEventListener('pointermove', (e) => {
    if (!isDragging) return;
    const deltaX = e.clientX - previousMouseX;
    const deltaY = e.clientY - previousMouseY;
    targetRotY += deltaX * 0.008;
    targetRotX += deltaY * 0.006;
    targetRotX = Math.max(-0.4, Math.min(0.6, targetRotX));
    previousMouseX = e.clientX;
    previousMouseY = e.clientY;
  });

  // Animation Loop
  let clock = new THREE.Clock();

  function animate() {
    requestAnimationFrame(animate);
    const delta = clock.getDelta();
    const time = clock.getElapsedTime();

    // Idle rotation when not dragging
    if (!isDragging) {
      targetRotY += 0.002;
    }

    root.rotation.y += (targetRotY - root.rotation.y) * 0.08;
    root.rotation.x += (targetRotX - root.rotation.x) * 0.08;

    // Node subtle breathing
    Object.values(nodeMeshes).forEach((n, idx) => {
      n.mesh.position.y = n.basePos.y + Math.sin(time * 2 + idx) * 0.02;
      n.beacon.scale.setScalar(0.9 + Math.sin(time * 4 + idx) * 0.2);
    });

    // Move data packets
    packets.forEach(p => {
      p.progress += p.speed * delta;
      if (p.progress >= 1.0) p.progress = 0;

      const [fromId, toId] = conduitDefs[p.conduitIdx];
      const p1 = nodeMeshes[fromId].mesh.position;
      const p2 = nodeMeshes[toId].mesh.position;
      p.mesh.position.lerpVectors(p1, p2, p.progress);
      p.mesh.position.y = -0.35;
    });

    renderer.render(scene, camera);
  }

  animate();

  window.addEventListener('resize', () => {
    if (!container || !renderer) return;
    width = container.clientWidth || 500;
    height = container.clientHeight || 460;
    camera.aspect = width / height;
    camera.updateProjectionMatrix();
    renderer.setSize(width, height);
  });
}
