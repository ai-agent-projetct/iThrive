import React, { useRef, useState, useEffect } from 'react';
import * as THREE from 'three';

const STAGES_DATA = [
  {
    num: '01',
    title: 'Ideation & Discovery',
    tagline: 'Interrogate the problem before the code',
    deliverable: 'Signed Architecture Blueprint & Scope',
    duration: '2 Weeks',
    body: 'We interrogate the problem before the solution. What is the cost of the current workflow, in hours and in errors, and what would “fixed” look like on a Tuesday?',
    icon: '💡',
    stationColor: '#00f2fe',
    splineT: 0.05,
  },
  {
    num: '02',
    title: 'Project Planning',
    tagline: 'Milestones you can argue with',
    deliverable: 'Sprint Roadmap & Work Breakdown',
    duration: '1–2 Weeks',
    body: 'Scope split into releases, each one shippable. Milestones, owners, dependencies and the assumptions the estimate rests on, written down where you can inspect them.',
    icon: '📋',
    stationColor: '#38bdf8',
    splineT: 0.20,
  },
  {
    num: '03',
    title: 'Design & Architecture',
    tagline: 'Clickable before it is coded',
    deliverable: 'Interactive Prototype & Schemas',
    duration: '2–3 Weeks',
    body: 'Data model, service boundaries, integration contracts and interface design, reviewed together. The expensive mistakes are all made here — so this is where we go thoroughly.',
    icon: '📐',
    stationColor: '#818cf8',
    splineT: 0.36,
  },
  {
    num: '04',
    title: 'Development Sprints',
    tagline: 'Fortnightly production releases',
    deliverable: 'Working Software Every Sprint',
    duration: '6–14 Weeks',
    body: 'Two-week iterations against a live environment you can open. Working software every fortnight beats a status report every week.',
    icon: '💻',
    stationColor: '#c084fc',
    splineT: 0.52,
  },
  {
    num: '05',
    title: 'Testing & QA Matrix',
    tagline: 'Automated suites & load verification',
    deliverable: 'Zero-Vulnerability QA Audit',
    duration: '2 Weeks',
    body: 'Automated regression, integration tests against real sandboxes, load tests at your expected peak, and a manual pass on the workflows that carry money.',
    icon: '🛡️',
    stationColor: '#34d399',
    splineT: 0.68,
  },
  {
    num: '06',
    title: 'Production Launch',
    tagline: 'Tested rollback & rehearsed cutover',
    deliverable: 'Live Production Cutover',
    duration: '1 Week',
    body: 'Migration rehearsed on a copy of production, cutover run to a checklist, rollback tested before it is needed. Training for the team who will use it daily.',
    icon: '🚀',
    stationColor: '#fbbf24',
    splineT: 0.83,
  },
  {
    num: '07',
    title: 'Support & Evolution',
    tagline: 'Monitoring, SLA & continuing roadmap',
    deliverable: '99.9% Uptime & Release Cadence',
    duration: 'Continuous',
    body: 'Continuous observability, an SLA, and a roadmap that keeps moving. Most of our clients are on their third or fourth release with us, not their first.',
    icon: '🛰️',
    stationColor: '#f43f5e',
    splineT: 0.96,
  },
];

export default function RoadPipeline3D() {
  const mountRef = useRef(null);
  const containerRef = useRef(null);
  const [activeStage, setActiveStage] = useState(0);
  const [scrollPct, setScrollPct] = useState(0);
  const [isAutoTour, setIsAutoTour] = useState(false);

  // References for Three.js objects accessible across hooks
  const stateRef = useRef({
    scene: null,
    camera: null,
    renderer: null,
    curve: null,
    traveler: null,
    targetLookAt: new THREE.Vector3(0, 0, 0),
    currentLookAt: new THREE.Vector3(0, 0, 0),
    targetCamPos: new THREE.Vector3(0, 25, 45),
    currentCamPos: new THREE.Vector3(0, 25, 45),
    stations: [],
    animId: null,
  });

  useEffect(() => {
    const container = mountRef.current;
    if (!container) return;
    const width = container.clientWidth || window.innerWidth;
    const height = container.clientHeight || 750;

    // 1. Scene & Camera
    const scene = new THREE.Scene();
    scene.fog = new THREE.FogExp2(0x060912, 0.012);

    const camera = new THREE.PerspectiveCamera(45, width / height, 0.1, 1000);
    camera.position.set(0, 28, 48);

    const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true, powerPreference: 'high-performance' });
    renderer.setSize(width, height);
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
    renderer.shadowMap.enabled = true;
    renderer.shadowMap.type = THREE.PCFSoftShadowMap;
    renderer.toneMapping = THREE.ACESFilmicToneMapping;
    renderer.toneMappingExposure = 1.2;
    container.appendChild(renderer.domElement);

    // 2. Lighting
    const ambientLight = new THREE.AmbientLight(0xffffff, 0.8);
    scene.add(ambientLight);

    const mainLight = new THREE.DirectionalLight(0x00f2fe, 2.5);
    mainLight.position.set(30, 50, 40);
    mainLight.castShadow = true;
    mainLight.shadow.mapSize.width = 1024;
    mainLight.shadow.mapSize.height = 1024;
    scene.add(mainLight);

    const fillLight = new THREE.DirectionalLight(0xa855f7, 1.8);
    fillLight.position.set(-30, 40, -30);
    scene.add(fillLight);

    const bottomGlow = new THREE.PointLight(0x00f2fe, 3, 60);
    bottomGlow.position.set(0, -10, 0);
    scene.add(bottomGlow);

    // 3. Define the 3D Road Curve with dramatic winding S-curves and a 360-degree loop!
    const curvePoints = [
      new THREE.Vector3(-45, 0, -25),   // Start: Ideation
      new THREE.Vector3(-32, 4, -12),
      new THREE.Vector3(-22, 1, 5),     // Planning
      new THREE.Vector3(-12, 3, 20),
      new THREE.Vector3(-2, 2, 8),      // Design
      // The 360-degree vertical loop-de-loop:
      new THREE.Vector3(5, 5, -5),
      new THREE.Vector3(8, 14, -10),
      new THREE.Vector3(6, 22, -4),
      new THREE.Vector3(2, 15, 4),
      new THREE.Vector3(5, 6, 8),       // Loop exits into Development
      new THREE.Vector3(14, 2, 18),     // Development
      new THREE.Vector3(25, 4, 8),      // Testing & QA
      new THREE.Vector3(34, 7, -8),     // Launch
      new THREE.Vector3(44, 12, -22),   // Support & Evolution
    ];
    const curve = new THREE.CatmullRomCurve3(curvePoints);
    curve.curveType = 'centripetal';
    curve.tension = 0.5;

    // 4. Extrude the 3D Ribbon Road
    // We create a cross-section shape for the road
    const roadWidth = 3.6;
    const roadThickness = 0.25;
    const shape = new THREE.Shape();
    shape.moveTo(-roadWidth / 2, -roadThickness / 2);
    shape.lineTo(roadWidth / 2, -roadThickness / 2);
    shape.lineTo(roadWidth / 2, roadThickness / 2);
    shape.lineTo(-roadWidth / 2, roadThickness / 2);
    shape.closePath();

    const extrudeSettings = {
      steps: 320,
      bevelEnabled: false,
      extrudePath: curve,
    };
    const roadGeo = new THREE.ExtrudeGeometry(shape, extrudeSettings);
    const roadMat = new THREE.MeshStandardMaterial({
      color: 0x121826,
      roughness: 0.6,
      metalness: 0.2,
    });
    const roadMesh = new THREE.Mesh(roadGeo, roadMat);
    roadMesh.receiveShadow = true;
    scene.add(roadMesh);

    // Glowing road curbs / neon rails
    const curbRadius = 0.12;
    const curbGeo = new THREE.TubeGeometry(curve, 320, curbRadius, 8, false);
    const curbMatLeft = new THREE.MeshBasicMaterial({ color: 0x00f2fe });
    const curbMatRight = new THREE.MeshBasicMaterial({ color: 0xa855f7 });
    
    const curbMeshLeft = new THREE.Mesh(curbGeo, curbMatLeft);
    curbMeshLeft.position.y += 0.2;
    scene.add(curbMeshLeft);

    // Dashed road lane markings along the center
    const dashPoints = curve.getSpacedPoints(180);
    const dashGeo = new THREE.BufferGeometry().setFromPoints(dashPoints);
    const dashMat = new THREE.LineDashedMaterial({
      color: 0xffffff,
      dashSize: 1.4,
      gapSize: 1.0,
      linewidth: 3,
    });
    const dashLine = new THREE.Line(dashGeo, dashMat);
    dashLine.computeLineDistances();
    dashLine.position.y += 0.22;
    scene.add(dashLine);

    // 5. 3D Station Dioramas along the road
    const stations = [];
    STAGES_DATA.forEach((stage, idx) => {
      const pt = curve.getPointAt(stage.splineT);
      const tangent = curve.getTangentAt(stage.splineT).normalize();
      const normal = new THREE.Vector3(0, 1, 0).cross(tangent).normalize();
      
      const stationGroup = new THREE.Group();
      // Offset slightly to the side of the road
      const sideOffset = (idx % 2 === 0 ? 1 : -1) * 3.8;
      stationGroup.position.copy(pt).add(normal.clone().multiplyScalar(sideOffset));
      stationGroup.position.y += 0.5;

      // Diorama Base Platform (Floating hexagonal or circular podium)
      const podiumGeo = new THREE.CylinderGeometry(2.4, 2.8, 0.4, 6);
      const podiumMat = new THREE.MeshStandardMaterial({
        color: 0x0f172a,
        roughness: 0.3,
        metalness: 0.8,
        emissive: new THREE.Color(stage.stationColor).multiplyScalar(0.2),
      });
      const podium = new THREE.Mesh(podiumGeo, podiumMat);
      podium.receiveShadow = true;
      stationGroup.add(podium);

      // Glowing Base Ring
      const ringGeo = new THREE.TorusGeometry(2.7, 0.08, 16, 32);
      const ringMat = new THREE.MeshBasicMaterial({ color: stage.stationColor });
      const ring = new THREE.Mesh(ringGeo, ringMat);
      ring.rotation.x = Math.PI / 2;
      ring.position.y = 0.22;
      stationGroup.add(ring);

      // Distinct 3D Icon Artifact on Podium
      if (idx === 0) {
        // Ideation: Glowing Lightbulb / Core
        const bulbGeo = new THREE.SphereGeometry(0.8, 16, 16);
        const bulbMat = new THREE.MeshStandardMaterial({
          color: 0x00f2fe,
          emissive: 0x00f2fe,
          emissiveIntensity: 1.5,
          roughness: 0.1,
        });
        const bulb = new THREE.Mesh(bulbGeo, bulbMat);
        bulb.position.y = 1.6;
        stationGroup.add(bulb);

        // Holographic Orbiting Ring
        const hRingGeo = new THREE.TorusGeometry(1.4, 0.04, 16, 32);
        const hRing = new THREE.Mesh(hRingGeo, new THREE.MeshBasicMaterial({ color: 0x38bdf8 }));
        hRing.position.y = 1.6;
        hRing.rotation.x = 0.6;
        stationGroup.add(hRing);
      } else if (idx === 1) {
        // Planning: 3 Gantt Milestone Pillars
        for (let p = -1; p <= 1; p++) {
          const colGeo = new THREE.BoxGeometry(0.4, 1.2 + Math.abs(p) * 0.6, 0.4);
          const colMat = new THREE.MeshStandardMaterial({
            color: 0x38bdf8,
            emissive: 0x38bdf8,
            emissiveIntensity: 0.6,
            metalness: 0.7,
          });
          const col = new THREE.Mesh(colGeo, colMat);
          col.position.set(p * 0.7, (1.2 + Math.abs(p) * 0.6) / 2 + 0.2, 0);
          stationGroup.add(col);
        }
      } else if (idx === 2) {
        // Design & Architecture: Floating Blueprint Layers
        for (let l = 0; l < 3; l++) {
          const sheetGeo = new THREE.BoxGeometry(1.6, 0.04, 1.2);
          const sheetMat = new THREE.MeshStandardMaterial({
            color: 0x818cf8,
            emissive: 0x818cf8,
            emissiveIntensity: 0.4 + l * 0.3,
            transparent: true,
            opacity: 0.85,
          });
          const sheet = new THREE.Mesh(sheetGeo, sheetMat);
          sheet.position.set(0, 0.8 + l * 0.5, 0);
          sheet.rotation.y = (l * Math.PI) / 8;
          stationGroup.add(sheet);
        }
      } else if (idx === 3) {
        // Development: 3D Terminal & Screen Matrices
        const termGeo = new THREE.BoxGeometry(1.8, 1.1, 0.1);
        const termMat = new THREE.MeshStandardMaterial({
          color: 0x1e1b4b,
          emissive: 0xc084fc,
          emissiveIntensity: 0.8,
        });
        const term = new THREE.Mesh(termGeo, termMat);
        term.position.set(0, 1.4, 0);
        term.rotation.y = -Math.PI / 6;
        stationGroup.add(term);
      } else if (idx === 4) {
        // Testing & QA: Security Radar & Shield
        const shieldGeo = new THREE.OctahedronGeometry(0.9, 0);
        const shieldMat = new THREE.MeshStandardMaterial({
          color: 0x34d399,
          emissive: 0x34d399,
          emissiveIntensity: 0.9,
          wireframe: true,
        });
        const shield = new THREE.Mesh(shieldGeo, shieldMat);
        shield.position.y = 1.5;
        stationGroup.add(shield);
      } else if (idx === 5) {
        // Launch: Rocket Cone & Booster
        const rocketGeo = new THREE.ConeGeometry(0.7, 1.8, 8);
        const rocketMat = new THREE.MeshStandardMaterial({
          color: 0xfbbf24,
          emissive: 0xf59e0b,
          emissiveIntensity: 0.8,
          metalness: 0.9,
        });
        const rocket = new THREE.Mesh(rocketGeo, rocketMat);
        rocket.position.y = 1.6;
        stationGroup.add(rocket);
      } else if (idx === 6) {
        // Support: Satellite & Orbit Nodes
        const satGeo = new THREE.DodecahedronGeometry(0.8, 0);
        const satMat = new THREE.MeshStandardMaterial({
          color: 0xf43f5e,
          emissive: 0xf43f5e,
          emissiveIntensity: 1.0,
        });
        const sat = new THREE.Mesh(satGeo, satMat);
        sat.position.y = 1.6;
        stationGroup.add(sat);
      }

      // Vertical stem linking diorama to the road
      const stemGeo = new THREE.CylinderGeometry(0.06, 0.06, sideOffset);
      const stemMat = new THREE.MeshBasicMaterial({ color: stage.stationColor, transparent: true, opacity: 0.7 });
      const stem = new THREE.Mesh(stemGeo, stemMat);
      stem.position.copy(pt).add(normal.clone().multiplyScalar(sideOffset / 2));
      stem.position.y = 0.2;
      stem.rotation.z = Math.PI / 2;
      scene.add(stem);

      scene.add(stationGroup);
      stations.push({ group: stationGroup, splineT: stage.splineT, ...stage });
    });

    // 6. 3D Cyber Traveler / Drone on the Road
    const travelerGroup = new THREE.Group();
    const droneBodyGeo = new THREE.BoxGeometry(1.2, 0.35, 1.8);
    const droneBodyMat = new THREE.MeshStandardMaterial({
      color: 0x0284c7,
      emissive: 0x00f2fe,
      emissiveIntensity: 0.9,
      metalness: 0.8,
      roughness: 0.2,
    });
    const droneBody = new THREE.Mesh(droneBodyGeo, droneBodyMat);
    droneBody.castShadow = true;
    travelerGroup.add(droneBody);

    // Glowing headlights
    for (let s = -1; s <= 1; s += 2) {
      const lightGeo = new THREE.SphereGeometry(0.14, 8, 8);
      const lightMat = new THREE.MeshBasicMaterial({ color: 0x00f2fe });
      const lightMesh = new THREE.Mesh(lightGeo, lightMat);
      lightMesh.position.set(s * 0.45, 0, 0.9);
      travelerGroup.add(lightMesh);
    }

    scene.add(travelerGroup);

    // 7. Ambient Particle Dust in the 3D space
    const particleCount = 600;
    const particleGeo = new THREE.BufferGeometry();
    const particlePositions = new Float32Array(particleCount * 3);
    for (let i = 0; i < particleCount * 3; i += 3) {
      particlePositions[i] = (Math.random() - 0.5) * 120;
      particlePositions[i + 1] = Math.random() * 40 - 5;
      particlePositions[i + 2] = (Math.random() - 0.5) * 100;
    }
    particleGeo.setAttribute('position', new THREE.BufferAttribute(particlePositions, 3));
    const particleMat = new THREE.PointsMaterial({
      color: 0x38bdf8,
      size: 0.35,
      transparent: true,
      opacity: 0.6,
    });
    const particles = new THREE.Points(particleGeo, particleMat);
    scene.add(particles);

    // Store in ref
    stateRef.current = {
      scene,
      camera,
      renderer,
      curve,
      traveler: travelerGroup,
      targetLookAt: new THREE.Vector3(-45, 2, -25),
      currentLookAt: new THREE.Vector3(-45, 2, -25),
      targetCamPos: new THREE.Vector3(-45, 12, 5),
      currentCamPos: new THREE.Vector3(-45, 12, 5),
      stations,
      particles,
      animId: null,
    };

    // Animation loop
    let clock = new THREE.Clock();
    const animate = () => {
      const delta = clock.getDelta();
      const elapsed = clock.getElapsedTime();

      // Animate road dashes offset to simulate forward flow
      dashMat.dashOffset -= delta * 4;

      // Animate particles floating gently
      particles.rotation.y = elapsed * 0.02;

      // Animate stations bobbing and rotating slightly
      stations.forEach((st, i) => {
        st.group.rotation.y = Math.sin(elapsed * 0.8 + i) * 0.15;
        const iconChild = st.group.children[2];
        if (iconChild) {
          iconChild.position.y = 1.4 + Math.sin(elapsed * 1.5 + i) * 0.12;
          iconChild.rotation.y = elapsed * 0.6 + i;
        }
      });

      // Smooth camera interpolation
      const { camera, targetCamPos, currentCamPos, targetLookAt, currentLookAt } = stateRef.current;
      currentCamPos.lerp(targetCamPos, 0.05);
      camera.position.copy(currentCamPos);

      currentLookAt.lerp(targetLookAt, 0.06);
      camera.lookAt(currentLookAt);

      renderer.render(scene, camera);
      stateRef.current.animId = requestAnimationFrame(animate);
    };
    animate();

    // Resize listener
    const handleResize = () => {
      if (!container || !renderer || !camera) return;
      const w = container.clientWidth || window.innerWidth;
      const h = container.clientHeight || 750;
      camera.aspect = w / h;
      camera.updateProjectionMatrix();
      renderer.setSize(w, h);
    };
    window.addEventListener('resize', handleResize);

    return () => {
      window.removeEventListener('resize', handleResize);
      if (stateRef.current.animId) cancelAnimationFrame(stateRef.current.animId);
      if (renderer.domElement && container.contains(renderer.domElement)) {
        container.removeChild(renderer.domElement);
      }
      renderer.dispose();
    };
  }, []);

  // Update Camera & Traveler when activeStage changes or user scrolls
  const updateToStage = (idx) => {
    setActiveStage(idx);
    const stage = STAGES_DATA[idx];
    const { curve, traveler } = stateRef.current;
    if (!curve) return;

    const t = stage.splineT;
    const pt = curve.getPointAt(t);
    const tangent = curve.getTangentAt(t).normalize();
    const normal = new THREE.Vector3(0, 1, 0).cross(tangent).normalize();

    // Move traveler along the road
    if (traveler) {
      traveler.position.copy(pt).add(new THREE.Vector3(0, 0.35, 0));
      traveler.quaternion.setFromUnitVectors(new THREE.Vector3(0, 0, 1), tangent);
    }

    // Set cinematic camera position looking down at this station
    const camOffset = tangent.clone().multiplyScalar(-14).add(new THREE.Vector3(0, 9, 0)).add(normal.clone().multiplyScalar(idx % 2 === 0 ? 8 : -8));
    stateRef.current.targetCamPos.copy(pt).add(camOffset);
    stateRef.current.targetLookAt.copy(pt).add(new THREE.Vector3(0, 1.5, 0));
  };

  // Trigger initial stage update once curve is built
  useEffect(() => {
    const timer = setTimeout(() => updateToStage(0), 100);
    return () => clearTimeout(timer);
  }, []);

  // Auto-tour timer
  useEffect(() => {
    if (!isAutoTour) return;
    const interval = setInterval(() => {
      setActiveStage((prev) => {
        const next = (prev + 1) % STAGES_DATA.length;
        updateToStage(next);
        return next;
      });
    }, 4500);
    return () => clearInterval(interval);
  }, [isAutoTour]);

  const curr = STAGES_DATA[activeStage];

  return (
    <div ref={containerRef} className="road-3d-pipeline-container" style={{
      position: 'relative',
      width: '100%',
      minHeight: '800px',
      background: 'radial-gradient(ellipse at 50% 40%, rgba(15, 23, 42, 0.95) 0%, #030712 100%)',
      borderRadius: '24px',
      border: '1px solid rgba(0, 242, 254, 0.18)',
      overflow: 'hidden',
      boxShadow: '0 25px 50px -12px rgba(0, 0, 0, 0.7)',
    }}>
      {/* 3D WebGL Canvas Mount */}
      <div ref={mountRef} style={{
        position: 'absolute',
        top: 0,
        left: 0,
        width: '100%',
        height: '100%',
        zIndex: 1,
      }} />

      {/* Top Controls & Navigation Bar */}
      <div style={{
        position: 'relative',
        zIndex: 10,
        padding: '24px 28px',
        display: 'flex',
        flexWrap: 'wrap',
        alignItems: 'center',
        justifyContent: 'space-between',
        gap: '16px',
        background: 'linear-gradient(180deg, rgba(6, 9, 18, 0.85) 0%, transparent 100%)',
        backdropFilter: 'blur(8px)',
      }}>
        <div>
          <div style={{ display: 'flex', alignItems: 'center', gap: '8px', marginBottom: '4px' }}>
            <span style={{
              width: '8px',
              height: '8px',
              borderRadius: '50%',
              background: '#00f2fe',
              boxShadow: '0 0 10px #00f2fe',
              display: 'inline-block',
            }} />
            <span style={{ fontSize: '0.78rem', color: '#00f2fe', textTransform: 'uppercase', letterSpacing: '0.14em', fontWeight: 700 }}>
              Interactive 3D Pipeline
            </span>
          </div>
          <h3 style={{ fontSize: 'clamp(1.3rem, 2vw, 1.7rem)', color: '#fff', fontWeight: 700, margin: 0 }}>
            Seven Stages — Follow the Build in 3D
          </h3>
        </div>

        {/* Auto-Tour Toggle */}
        <button
          onClick={() => setIsAutoTour(!isAutoTour)}
          style={{
            background: isAutoTour ? 'rgba(0, 242, 254, 0.2)' : 'rgba(255, 255, 255, 0.06)',
            border: `1px solid ${isAutoTour ? '#00f2fe' : 'rgba(255, 255, 255, 0.15)'}`,
            color: isAutoTour ? '#00f2fe' : '#fff',
            padding: '8px 18px',
            borderRadius: '999px',
            cursor: 'pointer',
            fontSize: '0.85rem',
            fontWeight: 600,
            display: 'flex',
            alignItems: 'center',
            gap: '8px',
            transition: 'all 0.2s ease',
          }}
        >
          <span>{isAutoTour ? '⏸ Pause 3D Flight' : '▶ 3D Auto Tour'}</span>
        </button>
      </div>

      {/* Stage Selector Pills (1 to 7) */}
      <div style={{
        position: 'relative',
        zIndex: 10,
        padding: '0 28px',
        display: 'flex',
        gap: '8px',
        overflowX: 'auto',
        scrollbarWidth: 'none',
      }}>
        {STAGES_DATA.map((st, i) => {
          const isSelected = activeStage === i;
          return (
            <button
              key={st.num}
              onClick={() => { setIsAutoTour(false); updateToStage(i); }}
              style={{
                background: isSelected ? 'rgba(0, 242, 254, 0.18)' : 'rgba(15, 23, 42, 0.65)',
                border: `1px solid ${isSelected ? st.stationColor : 'rgba(255, 255, 255, 0.08)'}`,
                color: isSelected ? '#ffffff' : 'rgba(255, 255, 255, 0.65)',
                padding: '10px 16px',
                borderRadius: '12px',
                cursor: 'pointer',
                display: 'flex',
                alignItems: 'center',
                gap: '8px',
                whiteSpace: 'nowrap',
                transition: 'all 0.2s ease',
                backdropFilter: 'blur(8px)',
                boxShadow: isSelected ? `0 0 16px ${st.stationColor}40` : 'none',
              }}
            >
              <span style={{
                fontFamily: 'monospace',
                fontWeight: 700,
                fontSize: '0.8rem',
                color: isSelected ? st.stationColor : 'rgba(255, 255, 255, 0.4)',
              }}>
                {st.num}
              </span>
              <span style={{ fontSize: '0.88rem', fontWeight: isSelected ? 700 : 500 }}>
                {st.title}
              </span>
            </button>
          );
        })}
      </div>

      {/* Active Stage Holographic Info Card Overlay */}
      <div style={{
        position: 'absolute',
        bottom: '28px',
        left: '28px',
        zIndex: 10,
        maxWidth: '480px',
        width: 'calc(100% - 56px)',
        background: 'rgba(11, 17, 32, 0.88)',
        backdropFilter: 'blur(16px)',
        border: `1px solid ${curr.stationColor}50`,
        borderRadius: '18px',
        padding: '24px',
        boxShadow: `0 20px 50px rgba(0, 0, 0, 0.8), 0 0 30px ${curr.stationColor}25`,
        animation: 'fadeIn 0.3s ease',
      }}>
        <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', marginBottom: '12px' }}>
          <div style={{ display: 'flex', alignItems: 'center', gap: '10px' }}>
            <span style={{
              fontSize: '1.4rem',
              width: '40px',
              height: '40px',
              borderRadius: '10px',
              background: `${curr.stationColor}20`,
              display: 'flex',
              alignItems: 'center',
              justifyContent: 'center',
            }}>
              {curr.icon}
            </span>
            <div>
              <span style={{
                fontFamily: 'monospace',
                fontWeight: 700,
                fontSize: '0.78rem',
                color: curr.stationColor,
                letterSpacing: '0.1em',
              }}>
                STAGE {curr.num} OF 07
              </span>
              <h4 style={{ fontSize: '1.25rem', fontWeight: 700, color: '#fff', margin: 0 }}>
                {curr.title}
              </h4>
            </div>
          </div>
          <span style={{
            fontSize: '0.75rem',
            color: '#fff',
            background: 'rgba(255, 255, 255, 0.1)',
            padding: '4px 10px',
            borderRadius: '999px',
            fontWeight: 600,
          }}>
            {curr.duration}
          </span>
        </div>

        <p style={{
          fontSize: '0.9rem',
          color: 'rgba(255, 255, 255, 0.75)',
          lineHeight: 1.55,
          marginBottom: '18px',
        }}>
          {curr.body}
        </p>

        {/* Deliverable Pill */}
        <div style={{
          background: 'rgba(0, 0, 0, 0.4)',
          border: '1px solid rgba(255, 255, 255, 0.08)',
          borderRadius: '10px',
          padding: '10px 14px',
          display: 'flex',
          alignItems: 'center',
          justifyContent: 'space-between',
        }}>
          <span style={{ fontSize: '0.78rem', color: 'rgba(255, 255, 255, 0.5)' }}>Output Deliverable:</span>
          <span style={{ fontSize: '0.82rem', color: curr.stationColor, fontWeight: 700 }}>
            ✓ {curr.deliverable}
          </span>
        </div>

        {/* Next / Prev Stepper */}
        <div style={{ display: 'flex', justifyContent: 'space-between', marginTop: '16px' }}>
          <button
            disabled={activeStage === 0}
            onClick={() => updateToStage(activeStage - 1)}
            style={{
              background: 'transparent',
              border: 'none',
              color: activeStage === 0 ? 'rgba(255,255,255,0.2)' : '#fff',
              cursor: activeStage === 0 ? 'default' : 'pointer',
              fontSize: '0.82rem',
              fontWeight: 600,
            }}
          >
            &larr; Previous Stage
          </button>
          <button
            disabled={activeStage === STAGES_DATA.length - 1}
            onClick={() => updateToStage(activeStage + 1)}
            style={{
              background: 'transparent',
              border: 'none',
              color: activeStage === STAGES_DATA.length - 1 ? 'rgba(255,255,255,0.2)' : curr.stationColor,
              cursor: activeStage === STAGES_DATA.length - 1 ? 'default' : 'pointer',
              fontSize: '0.82rem',
              fontWeight: 700,
            }}
          >
            Next Stage &rarr;
          </button>
        </div>
      </div>
    </div>
  );
}
