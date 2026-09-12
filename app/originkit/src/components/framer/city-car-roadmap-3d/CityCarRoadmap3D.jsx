import React, { useRef, useState, useEffect, useCallback } from 'react';
import * as THREE from 'three';

// ── Track Circuit Constants ──────────────────────────────────────────────
const W = -60.0;
const E = 65.0;
const N = 50.0;
const S = -80.0;
const R = 8.0;

const L_W = (N - R) - (S + R); // 114
const L_NW = 0.5 * Math.PI * R; // 12.56637
const L_N = (E - R) - (W + R);  // 109
const L_NE = L_NW;
const L_E = L_W;
const L_SE = L_NW;
const L_S = L_N;
const L_SW = L_NW;

const TOTAL_TRACK_LENGTH = L_W + L_NW + L_N + L_NE + L_E + L_SE + L_S + L_SW; // 496.26548

// Precise track positioning function - 100% continuous and locked strictly on road
function getTrackState(dist) {
  let d = dist % TOTAL_TRACK_LENGTH;
  if (d < 0) d += TOTAL_TRACK_LENGTH;

  // 1. West Avenue: heading North (+Z)
  if (d < L_W) {
    return {
      x: W,
      z: (S + R) + d,
      angle: 0.0,
    };
  }
  d -= L_W;

  // 2. NW Corner Arc: smooth 90-degree turn from North to East
  if (d < L_NW) {
    const f = d / L_NW;
    const theta = Math.PI - f * (0.5 * Math.PI);
    const x = (W + R) + R * Math.cos(theta);
    const z = (N - R) + R * Math.sin(theta);
    const angle = Math.atan2(Math.sin(theta), -Math.cos(theta));
    return { x, z, angle };
  }
  d -= L_NW;

  // 3. North Avenue: heading East (+X)
  if (d < L_N) {
    return {
      x: (W + R) + d,
      z: N,
      angle: Math.PI / 2,
    };
  }
  d -= L_N;

  // 4. NE Corner Arc: smooth 90-degree turn from East to South
  if (d < L_NE) {
    const f = d / L_NE;
    const theta = 0.5 * Math.PI - f * (0.5 * Math.PI);
    const x = (E - R) + R * Math.cos(theta);
    const z = (N - R) + R * Math.sin(theta);
    const angle = Math.atan2(Math.sin(theta), -Math.cos(theta));
    return { x, z, angle };
  }
  d -= L_NE;

  // 5. East Avenue: heading South (-Z)
  if (d < L_E) {
    return {
      x: E,
      z: (N - R) - d,
      angle: Math.PI,
    };
  }
  d -= L_E;

  // 6. SE Corner Arc: smooth 90-degree turn from South to West
  if (d < L_SE) {
    const f = d / L_SE;
    const theta = 0.0 - f * (0.5 * Math.PI);
    const x = (E - R) + R * Math.cos(theta);
    const z = (S + R) + R * Math.sin(theta);
    const angle = Math.atan2(Math.sin(theta), -Math.cos(theta));
    return { x, z, angle };
  }
  d -= L_SE;

  // 7. South Avenue: heading West (-X)
  if (d < L_S) {
    return {
      x: (E - R) - d,
      z: S,
      angle: -Math.PI / 2,
    };
  }
  d -= L_S;

  // 8. SW Corner Arc: smooth 90-degree turn from West to North
  const f = d / L_SW;
  const theta = -0.5 * Math.PI - f * (0.5 * Math.PI);
  const x = (W + R) + R * Math.cos(theta);
  const z = (S + R) + R * Math.sin(theta);
  const angle = Math.atan2(Math.sin(theta), -Math.cos(theta));
  return { x, z, angle };
}

// Detect when car is approaching or navigating a corner arc
function isInCorner(dist) {
  let d = ((dist % TOTAL_TRACK_LENGTH) + TOTAL_TRACK_LENGTH) % TOTAL_TRACK_LENGTH;
  // West Avenue: [0, L_W)
  if (d < L_W - 8.0) return false;
  d -= L_W;
  // Approaching or in NW corner:
  if (d < L_NW + 6.0) return true;
  d -= L_NW;
  // North Avenue:
  if (d < L_N - 8.0) return false;
  d -= L_N;
  // NE corner:
  if (d < L_NE + 6.0) return true;
  d -= L_NE;
  // East Avenue:
  if (d < L_E - 8.0) return false;
  d -= L_E;
  // SE corner:
  if (d < L_SE + 6.0) return true;
  d -= L_SE;
  // South Avenue:
  if (d < L_S - 8.0) return false;
  d -= L_S;
  // SW corner:
  return true;
}

// 7 Delivery Stages mapped to exact track distance locations
const STAGES = [
  {
    num: '01',
    title: 'Ideation & Discovery',
    district: 'Downtown Innovation Plaza',
    tagline: 'Interrogate the problem before the code',
    deliverable: 'Signed Architecture Blueprint & Scope',
    duration: '2 Weeks',
    body: 'We interrogate the problem before the solution. What is the cost of the current workflow, in hours and in errors, and what would "fixed" look like on a Tuesday?',
    icon: '💡',
    accent: '#00f2fe',
    trackDist: 22.0, // z = -50 on West Ave
  },
  {
    num: '02',
    title: 'Project Planning',
    district: 'Strategy Square & Roadmap Avenue',
    tagline: 'Milestones you can argue with',
    deliverable: 'Sprint Roadmap & Work Breakdown',
    duration: '1–2 Weeks',
    body: 'Scope split into releases, each one shippable. Milestones, owners, dependencies and the assumptions the estimate rests on, written down where you can inspect them.',
    icon: '📋',
    accent: '#38bdf8',
    trackDist: 82.0, // z = 10 on West Ave
  },
  {
    num: '03',
    title: 'Design & Architecture',
    district: 'Creative Quarter & UI Boulevard',
    tagline: 'Clickable before it is coded',
    deliverable: 'Interactive Prototype & Data Contracts',
    duration: '2–3 Weeks',
    body: 'Data model, service boundaries, integration contracts and interface design, reviewed together. The expensive mistakes are all made here — so this is where we go thoroughly.',
    icon: '📐',
    accent: '#818cf8',
    trackDist: 163.57, // x = -15 on North Ave
  },
  {
    num: '04',
    title: 'Development Sprints',
    district: 'Tech District & Sprint Works',
    tagline: 'Fortnightly production releases',
    deliverable: 'Working Software Every Sprint',
    duration: '6–14 Weeks',
    body: 'Two-week iterations against a live environment you can open. Working software every fortnight beats a status report every week.',
    icon: '💻',
    accent: '#c084fc',
    trackDist: 213.57, // x = 35 on North Ave
  },
  {
    num: '05',
    title: 'Testing & QA Matrix',
    district: 'Reliability Lab & Security Way',
    tagline: 'Automated suites & load verification',
    deliverable: 'Zero-Vulnerability QA Audit',
    duration: '2 Weeks',
    body: 'Automated regression, integration tests against real sandboxes, load tests at your expected peak, and a manual pass on the workflows that carry money.',
    icon: '🛡️',
    accent: '#34d399',
    trackDist: 275.13, // z = 15 on East Ave
  },
  {
    num: '06',
    title: 'Production Launch',
    district: 'Launch Tower & DevOps Center',
    tagline: 'Rehearsed migration & zero downtime',
    deliverable: 'Live Production Deployment & Runbook',
    duration: '1–2 Weeks',
    body: 'Migration rehearsed on a replica of production, cutover executed to an exact checklist, rollback tested before it is ever needed, and training for your end-users.',
    icon: '🚀',
    accent: '#fbbf24',
    trackDist: 335.13, // z = -45 on East Ave
  },
  {
    num: '07',
    title: 'Evolution & SLA',
    district: 'Metropolis Hub & Future Growth',
    tagline: 'Monitoring, SLAs & continuing roadmap',
    deliverable: 'Managed 24/7 SLA & Roadmap Scaling',
    duration: 'Ongoing Retainer',
    body: 'Continuous monitoring, high-uptime SLAs, and an iterative roadmap that moves with your market. Most clients stay with us for release three and four, not just release one.',
    icon: '🔄',
    accent: '#00f2fe',
    trackDist: 426.70, // x = 5 on South Ave
  },
];

export default function CityCarRoadmap3D() {
  const mountRef = useRef(null);
  const containerRef = useRef(null);
  const [activeStage, setActiveStage] = useState(0);
  const [speedKmH, setSpeedKmH] = useState(0);
  const [isDriving, setIsDriving] = useState(false);
  const [isAutoCruise, setIsAutoCruise] = useState(false);
  const [isMobile, setIsMobile] = useState(false);
  const [showScrollHint, setShowScrollHint] = useState(true);

  useEffect(() => {
    const checkMobile = () => {
      setIsMobile(window.innerWidth <= 768);
    };
    checkMobile();
    window.addEventListener('resize', checkMobile);
    return () => window.removeEventListener('resize', checkMobile);
  }, []);

  const activeStageRef = useRef(0);
  activeStageRef.current = activeStage;
  const driveToStageRef = useRef(null);
  const handleWheelRef = useRef(null);
  const lastSpeedUpdate = useRef(0);
  const cameraLookTarget = useRef(new THREE.Vector3(-60, 2, -50));

  // Shared animation state
  const sceneState = useRef({
    car: null,
    wheels: [],
    headlights: [],
    checkpoints: [],
    currentDist: STAGES[0].trackDist,
    targetDist: STAGES[0].trackDist,
    currentAngle: 0,
    camera: null,
    isCruising: false,
    speed: 0,
    cruiseTimer: null,
    touchStartY: 0,
    touchStartX: 0,
  });

  // Navigate smoothly to stage along the road
  const driveToStage = useCallback((stageIdx) => {
    setActiveStage(stageIdx);
    activeStageRef.current = stageIdx;
    setIsDriving(true);
    setShowScrollHint(false);

    const targetStage = STAGES[stageIdx];
    let dest = targetStage.trackDist;
    const cur = sceneState.current.currentDist;

    // Ensure car moves forward naturally along the circuit:
    // If destination is smaller than current, add track length so it drives forward through the loop
    const curMod = ((cur % TOTAL_TRACK_LENGTH) + TOTAL_TRACK_LENGTH) % TOTAL_TRACK_LENGTH;
    let diff = dest - curMod;
    if (diff < 0) diff += TOTAL_TRACK_LENGTH;

    sceneState.current.targetDist = cur + diff;
  }, []);
  driveToStageRef.current = driveToStage;

  const toggleAutoCruise = () => {
    const next = !isAutoCruise;
    setIsAutoCruise(next);
    sceneState.current.isCruising = next;
    setShowScrollHint(false);
    if (next && !isDriving) {
      const nextIdx = (activeStageRef.current + 1) % STAGES.length;
      driveToStage(nextIdx);
    }
  };

  // --- Mouse Wheel Scroll Handler ---
  // When user scrolls mouse wheel over the roadmap, car drives forward / backward smoothly along the road!
  const handleWheel = useCallback((e) => {
    // Only capture scroll when within roadmap bounds
    e.preventDefault();
    setShowScrollHint(false);

    // Disable auto cruise if user manually scrolls
    if (sceneState.current.isCruising) {
      sceneState.current.isCruising = false;
      setIsAutoCruise(false);
    }

    // Scroll delta forward or backward
    const scrollDelta = e.deltaY * 0.18;
    sceneState.current.targetDist += scrollDelta;
    setIsDriving(true);
  }, []);
  handleWheelRef.current = handleWheel;

  // --- Touch Scrub Handler for Mobile ---
  const handleTouchStart = (e) => {
    if (e.touches.length === 1) {
      sceneState.current.touchStartY = e.touches[0].clientY;
      sceneState.current.touchStartX = e.touches[0].clientX;
    }
  };

  const handleTouchMove = (e) => {
    if (e.touches.length === 1) {
      const dy = sceneState.current.touchStartY - e.touches[0].clientY;
      const dx = sceneState.current.touchStartX - e.touches[0].clientX;
      const delta = Math.abs(dy) > Math.abs(dx) ? dy : dx;

      if (Math.abs(delta) > 5) {
        e.preventDefault();
        setShowScrollHint(false);
        if (sceneState.current.isCruising) {
          sceneState.current.isCruising = false;
          setIsAutoCruise(false);
        }
        sceneState.current.targetDist += delta * 0.35;
        sceneState.current.touchStartY = e.touches[0].clientY;
        sceneState.current.touchStartX = e.touches[0].clientX;
        setIsDriving(true);
      }
    }
  };

  useEffect(() => {
    const mount = mountRef.current;
    if (!mount) return;

    const width = mount.clientWidth || 900;
    const height = mount.clientHeight || (window.innerWidth <= 768 ? 440 : 640);

    // Three.js Scene Setup
    const scene = new THREE.Scene();
    scene.background = new THREE.Color(0x060911);
    scene.fog = new THREE.FogExp2(0x060911, 0.005);

    const initialPos = getTrackState(STAGES[0].trackDist);
    const camera = new THREE.PerspectiveCamera(45, width / height, 0.5, 1200);
    camera.position.set(initialPos.x - 18, 20, initialPos.z - 28);
    camera.lookAt(initialPos.x, 2, initialPos.z);
    sceneState.current.camera = camera;

    const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: false, powerPreference: 'high-performance' });
    renderer.setSize(width, height);
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
    renderer.shadowMap.enabled = true;
    renderer.shadowMap.type = THREE.PCFSoftShadowMap;
    renderer.toneMapping = THREE.ACESFilmicToneMapping;
    renderer.toneMappingExposure = 1.25;
    mount.appendChild(renderer.domElement);

    // Lighting
    const ambientLight = new THREE.AmbientLight(0x1e293b, 2.2);
    scene.add(ambientLight);

    const moonLight = new THREE.DirectionalLight(0x93c5fd, 1.8);
    moonLight.position.set(40, 150, 60);
    moonLight.castShadow = true;
    moonLight.shadow.mapSize.width = 1024;
    moonLight.shadow.mapSize.height = 1024;
    scene.add(moonLight);

    const skylineLight = new THREE.PointLight(0x00f2fe, 2.2, 450);
    skylineLight.position.set(0, 50, 0);
    scene.add(skylineLight);

    // Ground Plane
    const groundGeo = new THREE.PlaneGeometry(600, 600);
    const groundMat = new THREE.MeshStandardMaterial({ color: 0x050811, roughness: 0.95 });
    const ground = new THREE.Mesh(groundGeo, groundMat);
    ground.rotation.x = -Math.PI / 2;
    ground.receiveShadow = true;
    scene.add(ground);

    // Road Materials
    const roadMat = new THREE.MeshStandardMaterial({ color: 0x0e1422, roughness: 0.75 });
    const cyanGlowMat = new THREE.MeshBasicMaterial({ color: 0x00f2fe, transparent: true, opacity: 0.5 });
    const stripeMat = new THREE.MeshBasicMaterial({ color: 0xffffff, transparent: true, opacity: 0.75 });

    const createRoadSegment = (x, z, length, isHorizontal) => {
      const roadW = 16;
      const w = isHorizontal ? length : roadW;
      const h = isHorizontal ? roadW : length;
      const roadMesh = new THREE.Mesh(new THREE.PlaneGeometry(w, h), roadMat);
      roadMesh.rotation.x = -Math.PI / 2;
      roadMesh.position.set(x, 0.05, z);
      roadMesh.receiveShadow = true;
      scene.add(roadMesh);

      // Glowing curb lines
      const edgeGeo = new THREE.PlaneGeometry(isHorizontal ? length : 0.5, isHorizontal ? 0.5 : length);
      const edge1 = new THREE.Mesh(edgeGeo, cyanGlowMat);
      edge1.rotation.x = -Math.PI / 2;
      edge1.position.set(x + (isHorizontal ? 0 : 7.8), 0.08, z + (isHorizontal ? 7.8 : 0));
      scene.add(edge1);

      const edge2 = new THREE.Mesh(edgeGeo, cyanGlowMat);
      edge2.rotation.x = -Math.PI / 2;
      edge2.position.set(x - (isHorizontal ? 0 : 7.8), 0.08, z - (isHorizontal ? 7.8 : 0));
      scene.add(edge2);

      // Dashed lane divider
      const numDashes = Math.floor(length / 8);
      for (let d = 0; d < numDashes; d++) {
        const dash = new THREE.Mesh(
          new THREE.PlaneGeometry(isHorizontal ? 3.5 : 0.5, isHorizontal ? 0.5 : 3.5),
          stripeMat
        );
        dash.rotation.x = -Math.PI / 2;
        const offset = -length / 2 + d * 8 + 4;
        dash.position.set(
          x + (isHorizontal ? offset : 0),
          0.09,
          z + (isHorizontal ? 0 : offset)
        );
        scene.add(dash);
      }
    };

    createRoadSegment(-60, -15, 140, false); // West Avenue
    createRoadSegment(2.5, 50, 135, true);   // North Avenue
    createRoadSegment(65, -15, 140, false);  // East Avenue
    createRoadSegment(2.5, -80, 135, true);  // South Avenue

    // Street Lamps along roads
    const createStreetLamp = (x, z) => {
      const pole = new THREE.Mesh(
        new THREE.CylinderGeometry(0.18, 0.25, 6, 8),
        new THREE.MeshStandardMaterial({ color: 0x334155 })
      );
      pole.position.set(x, 3, z);
      scene.add(pole);

      const lampArm = new THREE.Mesh(
        new THREE.BoxGeometry(1.5, 0.2, 0.2),
        new THREE.MeshStandardMaterial({ color: 0x475569 })
      );
      lampArm.position.set(x > 0 ? x - 0.7 : x + 0.7, 5.9, z);
      scene.add(lampArm);

      const lightOrb = new THREE.Mesh(
        new THREE.SphereGeometry(0.4, 8, 8),
        new THREE.MeshBasicMaterial({ color: 0x38bdf8 })
      );
      lightOrb.position.set(x > 0 ? x - 1.2 : x + 1.2, 5.7, z);
      scene.add(lightOrb);
    };

    for (let z = -70; z <= 40; z += 35) {
      createStreetLamp(-70, z);
      createStreetLamp(75, z);
    }
    for (let x = -40; x <= 45; x += 35) {
      createStreetLamp(x, 60);
      createStreetLamp(x, -90);
    }

    // Outer Perimeter Towers (Safe from camera lines)
    const buildingColors = [0x0f172a, 0x111c34, 0x162447, 0x0c1222, 0x182848];
    const windowColors = [0x38bdf8, 0x00f2fe, 0xa855f7, 0xfacc15, 0xffffff];

    const createTower = (x, z, w, d, h) => {
      const bMat = new THREE.MeshStandardMaterial({
        color: buildingColors[Math.floor(Math.random() * buildingColors.length)],
        roughness: 0.35,
        metalness: 0.4,
      });
      const bMesh = new THREE.Mesh(new THREE.BoxGeometry(w, h, d), bMat);
      bMesh.position.set(x, h / 2, z);
      bMesh.castShadow = true;
      bMesh.receiveShadow = true;
      scene.add(bMesh);

      const winCount = Math.floor(h / 8);
      for (let i = 1; i < winCount; i++) {
        const winColor = windowColors[Math.floor(Math.random() * windowColors.length)];
        const win = new THREE.Mesh(
          new THREE.BoxGeometry(w + 0.2, 1.4, d + 0.2),
          new THREE.MeshBasicMaterial({ color: winColor, transparent: true, opacity: 0.8 })
        );
        win.position.set(x, i * 8, z);
        scene.add(win);
      }

      if (h > 50) {
        const antenna = new THREE.Mesh(
          new THREE.CylinderGeometry(0.2, 0.4, 8, 8),
          new THREE.MeshBasicMaterial({ color: 0xef4444 })
        );
        antenna.position.set(x, h + 4, z);
        scene.add(antenna);
      }
    };

    const perimeterTowers = [
      [-100, -70, 32, 30, 75], [-102, -25, 28, 32, 90], [-100, 20, 30, 30, 65], [-98, 65, 32, 28, 80],
      [-40, 85, 35, 26, 70], [5, 88, 38, 28, 95], [50, 85, 36, 26, 75],
      [105, 55, 30, 30, 80], [108, 10, 32, 34, 92], [105, -35, 30, 32, 70], [105, -75, 32, 30, 85],
      [45, -115, 35, 26, 68], [0, -118, 40, 28, 85], [-45, -115, 35, 26, 75],
      [-105, 105, 40, 40, 110], [110, 105, 40, 40, 105], [110, -115, 40, 40, 115], [-105, -115, 40, 40, 100]
    ];

    perimeterTowers.forEach(([tx, tz, tw, td, th]) => {
      createTower(tx, tz, tw, td, th);
    });

    // Center Plaza Low-Rise Hub
    const createCenterPavilion = (x, z, w, d, h, color) => {
      const pMesh = new THREE.Mesh(
        new THREE.BoxGeometry(w, h, d),
        new THREE.MeshStandardMaterial({ color: 0x0f172a, roughness: 0.3, metalness: 0.5 })
      );
      pMesh.position.set(x, h / 2, z);
      scene.add(pMesh);

      const edge = new THREE.Mesh(
        new THREE.BoxGeometry(w + 0.4, 0.4, d + 0.4),
        new THREE.MeshBasicMaterial({ color })
      );
      edge.position.set(x, h, z);
      scene.add(edge);
    };

    createCenterPavilion(-20, -15, 24, 20, 8, 0x00f2fe);
    createCenterPavilion(25, -15, 24, 20, 9, 0xa855f7);
    createCenterPavilion(2, 12, 34, 18, 7, 0x38bdf8);
    createCenterPavilion(2, -45, 32, 18, 6, 0x34d399);

    const spireGeo = new THREE.CylinderGeometry(1.2, 2.5, 22, 6);
    const spireMat = new THREE.MeshStandardMaterial({
      color: 0x0284c7,
      emissive: 0x00f2fe,
      emissiveIntensity: 0.6,
      roughness: 0.2,
      wireframe: true,
    });
    const centralSpire = new THREE.Mesh(spireGeo, spireMat);
    centralSpire.position.set(2, 11, -15);
    scene.add(centralSpire);

    // 7 Stage Checkpoint Gates along the circuit
    const checkpointObjects = [];
    STAGES.forEach((st) => {
      const group = new THREE.Group();
      const posState = getTrackState(st.trackDist);
      group.position.set(posState.x, 0, posState.z);

      const isVerticalAvenue = Math.abs(posState.angle) < 0.1 || Math.abs(posState.angle - Math.PI) < 0.1;

      const pillarMat = new THREE.MeshStandardMaterial({ color: 0x111c34, roughness: 0.2 });
      const archMat = new THREE.MeshBasicMaterial({ color: new THREE.Color(st.accent) });

      const p1 = new THREE.Mesh(new THREE.BoxGeometry(1.0, 9, 1.0), pillarMat);
      p1.position.set(isVerticalAvenue ? -9 : 0, 4.5, isVerticalAvenue ? 0 : -9);
      group.add(p1);

      const p2 = new THREE.Mesh(new THREE.BoxGeometry(1.0, 9, 1.0), pillarMat);
      p2.position.set(isVerticalAvenue ? 9 : 0, 4.5, isVerticalAvenue ? 0 : 9);
      group.add(p2);

      const beamGeo = new THREE.BoxGeometry(isVerticalAvenue ? 19 : 1.4, 0.9, isVerticalAvenue ? 1.4 : 19);
      const beam = new THREE.Mesh(beamGeo, archMat);
      beam.position.set(0, 9, 0);
      group.add(beam);

      const diamondGeo = new THREE.OctahedronGeometry(1.8, 0);
      const diamondMat = new THREE.MeshStandardMaterial({
        color: new THREE.Color(st.accent),
        emissive: new THREE.Color(st.accent),
        emissiveIntensity: 0.8,
        roughness: 0.2,
      });
      const diamond = new THREE.Mesh(diamondGeo, diamondMat);
      diamond.position.set(0, 13, 0);
      group.add(diamond);

      const ringGeo = new THREE.TorusGeometry(2.6, 0.14, 8, 24);
      const ringMat = new THREE.MeshBasicMaterial({ color: new THREE.Color(st.accent), wireframe: true });
      const ring = new THREE.Mesh(ringGeo, ringMat);
      ring.position.set(0, 13, 0);
      ring.rotation.x = Math.PI / 2;
      group.add(ring);

      const gRingGeo = new THREE.RingGeometry(3.5, 4.2, 32);
      const gRing = new THREE.Mesh(
        gRingGeo,
        new THREE.MeshBasicMaterial({ color: new THREE.Color(st.accent), side: THREE.DoubleSide })
      );
      gRing.rotation.x = -Math.PI / 2;
      gRing.position.y = 0.12;
      group.add(gRing);

      scene.add(group);
      checkpointObjects.push({ group, diamond, ring, accent: st.accent });
    });
    sceneState.current.checkpoints = checkpointObjects;

    // The 3D Cyber Sports Car
    const carGroup = new THREE.Group();
    carGroup.position.set(initialPos.x, 0.2, initialPos.z);
    carGroup.rotation.y = initialPos.angle;

    const bodyMat = new THREE.MeshStandardMaterial({ color: 0x0284c7, metalness: 0.85, roughness: 0.2 });
    const bodyGeo = new THREE.BoxGeometry(2.8, 0.85, 5.4);
    const body = new THREE.Mesh(bodyGeo, bodyMat);
    body.position.y = 0.65;
    body.castShadow = true;
    carGroup.add(body);

    const cabinMat = new THREE.MeshStandardMaterial({ color: 0x070b14, roughness: 0.1, metalness: 0.9 });
    const cabinGeo = new THREE.BoxGeometry(2.3, 0.75, 2.8);
    const cabin = new THREE.Mesh(cabinGeo, cabinMat);
    cabin.position.set(0, 1.25, -0.2);
    cabin.castShadow = true;
    carGroup.add(cabin);

    const wingMat = new THREE.MeshStandardMaterial({ color: 0x0369a1 });
    const wing = new THREE.Mesh(new THREE.BoxGeometry(2.9, 0.15, 0.8), wingMat);
    wing.position.set(0, 1.45, -2.4);
    carGroup.add(wing);

    // Twin LED headlights & road beam lights
    const hlGeo = new THREE.BoxGeometry(0.55, 0.25, 0.2);
    const hlMat = new THREE.MeshBasicMaterial({ color: 0x38bdf8 });
    const hlL = new THREE.Mesh(hlGeo, hlMat);
    hlL.position.set(-1.0, 0.7, 2.75);
    carGroup.add(hlL);
    const hlR = new THREE.Mesh(hlGeo, hlMat);
    hlR.position.set(1.0, 0.7, 2.75);
    carGroup.add(hlR);

    const spotL = new THREE.SpotLight(0x7dd3fc, 3.5, 45, Math.PI / 6, 0.5, 1.2);
    spotL.position.set(-1.0, 0.8, 2.8);
    spotL.target.position.set(-1.0, 0, 15);
    carGroup.add(spotL);
    carGroup.add(spotL.target);

    const spotR = new THREE.SpotLight(0x7dd3fc, 3.5, 45, Math.PI / 6, 0.5, 1.2);
    spotR.position.set(1.0, 0.8, 2.8);
    spotR.target.position.set(1.0, 0, 15);
    carGroup.add(spotR);
    carGroup.add(spotR.target);

    // Taillight bar
    const tailMat = new THREE.MeshBasicMaterial({ color: 0xff1e56 });
    const tailBar = new THREE.Mesh(new THREE.BoxGeometry(2.5, 0.2, 0.15), tailMat);
    tailBar.position.set(0, 0.75, -2.72);
    carGroup.add(tailBar);

    // Wheels
    const wheelMat = new THREE.MeshStandardMaterial({ color: 0x1e293b, roughness: 0.8 });
    const rimMat = new THREE.MeshBasicMaterial({ color: 0x00f2fe });
    const wheels = [];
    const wheelPositions = [
      [-1.5, 0.45, 1.6],
      [1.5, 0.45, 1.6],
      [-1.5, 0.45, -1.6],
      [1.5, 0.45, -1.6],
    ];

    wheelPositions.forEach(([wx, wy, wz]) => {
      const wGroup = new THREE.Group();
      wGroup.position.set(wx, wy, wz);

      const tire = new THREE.Mesh(new THREE.CylinderGeometry(0.48, 0.48, 0.4, 16), wheelMat);
      tire.rotation.z = Math.PI / 2;
      wGroup.add(tire);

      const rim = new THREE.Mesh(new THREE.CylinderGeometry(0.24, 0.24, 0.42, 12), rimMat);
      rim.rotation.z = Math.PI / 2;
      wGroup.add(rim);

      carGroup.add(wGroup);
      wheels.push(wGroup);
    });

    scene.add(carGroup);
    sceneState.current.car = carGroup;
    sceneState.current.wheels = wheels;

    // --- Main Animation Loop with Continuous Road Physics ---
    let animationFrameId;
    let clock = new THREE.Clock();
    let lastDist = sceneState.current.currentDist;

    const animate = () => {
      animationFrameId = requestAnimationFrame(animate);
      const delta = clock.getDelta();
      const time = clock.getElapsedTime();

      centralSpire.rotation.y += 0.01;

      // Animate checkpoint holograms
      sceneState.current.checkpoints.forEach((cp, i) => {
        if (cp.diamond) {
          cp.diamond.rotation.y += 0.02;
          cp.diamond.position.y = 13 + Math.sin(time * 2.5 + i) * 0.4;
        }
        if (cp.ring) {
          cp.ring.rotation.z += 0.03;
        }
      });

      const car = sceneState.current.car;
      if (car) {
        let curDist = sceneState.current.currentDist;
        const targetDist = sceneState.current.targetDist;
        const distDiff = targetDist - curDist;

        if (Math.abs(distDiff) > 0.08) {
          const inCorner = isInCorner(curDist);

          // Smooth square-root deceleration: gracefully decels as car nears destination
          const decelStep = Math.sqrt(Math.abs(distDiff)) * 0.38;
          // Speed limit: 1.15 in corners to smoothly carve turns without whipping; 2.2 on straightaways
          const maxStep = inCorner ? 1.15 : 2.2;
          const stepMag = Math.min(maxStep, Math.max(0.04, decelStep));
          const step = Math.sign(distDiff) * stepMag;

          curDist += step;
          sceneState.current.currentDist = curDist;

          // Compute instantaneous speed and throttle React updates
          const dDist = Math.abs(curDist - lastDist);
          const computedSpeed = Math.min((dDist / Math.max(delta, 0.016)) * 2.2, 65);
          sceneState.current.speed = THREE.MathUtils.lerp(sceneState.current.speed, computedSpeed, 0.15);

          const now = performance.now();
          if (now - lastSpeedUpdate.current > 120) {
            lastSpeedUpdate.current = now;
            setSpeedKmH(Math.round(sceneState.current.speed));
            setIsDriving(true);
          }

          // Exact track state strictly on road
          const state = getTrackState(curDist);
          car.position.set(state.x, 0.2, state.z);

          // Smooth heading angle steering
          let angleDiff = state.angle - car.rotation.y;
          while (angleDiff < -Math.PI) angleDiff += Math.PI * 2;
          while (angleDiff > Math.PI) angleDiff -= Math.PI * 2;

          // Faster alignment in corners so car never slides crab-wise
          const steerRate = inCorner ? 0.38 : 0.22;
          car.rotation.y += angleDiff * steerRate;

          // Front wheels steer into turn
          const steerAngle = THREE.MathUtils.clamp(angleDiff * 1.5, -0.45, 0.45);
          if (sceneState.current.wheels.length >= 2) {
            sceneState.current.wheels[0].rotation.y = steerAngle;
            sceneState.current.wheels[1].rotation.y = steerAngle;
          }

          // Spin wheels based on road movement
          const wheelDir = Math.sign(step);
          sceneState.current.wheels.forEach((w) => {
            w.rotation.x += wheelDir * sceneState.current.speed * 0.018;
          });

          // Continuous unified camera follow rig (NEVER jumps when driving or turning)
          const camDist = 30;
          const camHeight = 18;
          const camAngle = car.rotation.y + 0.20; // gentle 3/4 chase angle
          const desiredCamPos = new THREE.Vector3(
            car.position.x - Math.sin(camAngle) * camDist,
            car.position.y + camHeight,
            car.position.z - Math.cos(camAngle) * camDist
          );
          camera.position.lerp(desiredCamPos, 0.06);

          const desiredLookAt = new THREE.Vector3(car.position.x, car.position.y + 2.2, car.position.z);
          cameraLookTarget.current.lerp(desiredLookAt, 0.10);
          camera.lookAt(cameraLookTarget.current);

          // Update active stage pill based on closest milestone distance
          const normDist = ((curDist % TOTAL_TRACK_LENGTH) + TOTAL_TRACK_LENGTH) % TOTAL_TRACK_LENGTH;
          let closestIdx = 0;
          let minGap = Infinity;
          STAGES.forEach((st, idx) => {
            let gap = Math.abs(st.trackDist - normDist);
            if (gap > TOTAL_TRACK_LENGTH / 2) gap = TOTAL_TRACK_LENGTH - gap;
            if (gap < minGap) {
              minGap = gap;
              closestIdx = idx;
            }
          });
          if (closestIdx !== activeStageRef.current && minGap < 10) {
            activeStageRef.current = closestIdx;
            setActiveStage(closestIdx);
          }
        } else {
          // Stopped / Idling gently at checkpoint
          curDist = targetDist;
          sceneState.current.currentDist = curDist;
          sceneState.current.speed = 0;

          if (isDriving) {
            setIsDriving(false);
            setSpeedKmH(0);
          }

          car.position.y = 0.2 + Math.sin(time * 3) * 0.03;

          // Same continuous camera rig while resting - perfectly stable, zero snap!
          const camDist = 28;
          const camHeight = 17;
          const camAngle = car.rotation.y + 0.20;
          const restingCamPos = new THREE.Vector3(
            car.position.x - Math.sin(camAngle) * camDist,
            car.position.y + camHeight,
            car.position.z - Math.cos(camAngle) * camDist
          );
          camera.position.lerp(restingCamPos, 0.04);

          const desiredLookAt = new THREE.Vector3(car.position.x, car.position.y + 2.2, car.position.z);
          cameraLookTarget.current.lerp(desiredLookAt, 0.08);
          camera.lookAt(cameraLookTarget.current);

          // Straighten front wheels when resting
          if (sceneState.current.wheels.length >= 2) {
            sceneState.current.wheels[0].rotation.y *= 0.88;
            sceneState.current.wheels[1].rotation.y *= 0.88;
          }

          // Auto cruise step
          if (sceneState.current.isCruising && !sceneState.current.cruiseTimer) {
            sceneState.current.cruiseTimer = setTimeout(() => {
              sceneState.current.cruiseTimer = null;
              const next = (activeStageRef.current + 1) % STAGES.length;
              driveToStageRef.current?.(next);
            }, 2600);
          }
        }

        lastDist = curDist;
      }

      renderer.render(scene, camera);
    };

    animate();

    const handleResize = () => {
      if (!mount) return;
      const nw = mount.clientWidth;
      const nh = mount.clientHeight;
      camera.aspect = nw / nh;
      camera.updateProjectionMatrix();
      renderer.setSize(nw, nh);
    };

    window.addEventListener('resize', handleResize);

    // Attach wheel event to mount container via stable ref
    const domElem = renderer.domElement;
    const onWheel = (e) => handleWheelRef.current?.(e);
    domElem.addEventListener('wheel', onWheel, { passive: false });

    return () => {
      cancelAnimationFrame(animationFrameId);
      window.removeEventListener('resize', handleResize);
      domElem.removeEventListener('wheel', onWheel);
      if (mount.contains(renderer.domElement)) {
        mount.removeChild(renderer.domElement);
      }
      renderer.dispose();
    };
  }, []); // Scene only mounts ONCE! Zero canvas remounting!

  const curr = STAGES[activeStage];

  return (
    <div
      ref={containerRef}
      className="city-roadmap-wrapper"
      style={{
        position: 'relative',
        width: '100%',
        maxWidth: '1440px',
        margin: '0 auto',
        userSelect: 'none',
      }}
      onTouchStart={handleTouchStart}
      onTouchMove={handleTouchMove}
    >
      {/* 3D Game Container */}
      <div
        style={{
          position: 'relative',
          width: '100%',
          height: isMobile ? '440px' : '640px',
          borderRadius: '24px',
          overflow: 'hidden',
          background: '#060911',
          boxShadow: '0 30px 80px rgba(0, 0, 0, 0.9), 0 0 0 1px rgba(255, 255, 255, 0.08)',
        }}
      >
        {/* Three.js WebGL Mount Canvas */}
        <div
          ref={mountRef}
          style={{
            position: 'absolute',
            inset: 0,
            width: '100%',
            height: '100%',
            cursor: 'grab',
          }}
        />

        {/* --- Top Control HUD Bar --- */}
        <div
          style={{
            position: 'absolute',
            top: 0,
            left: 0,
            right: 0,
            padding: '16px 20px 10px 20px',
            background: 'linear-gradient(180deg, rgba(6, 9, 17, 0.95) 0%, rgba(6, 9, 17, 0.6) 70%, rgba(6, 9, 17, 0) 100%)',
            pointerEvents: 'none',
            zIndex: 20,
            display: 'flex',
            flexDirection: 'column',
            gap: '10px',
          }}
        >
          {/* Status badge + HUD buttons */}
          <div
            style={{
              display: 'flex',
              alignItems: 'center',
              justifyContent: 'space-between',
              flexWrap: 'wrap',
              gap: '10px',
              pointerEvents: 'auto',
            }}
          >
            <div style={{ display: 'flex', alignItems: 'center', gap: '8px' }}>
              <span
                style={{
                  width: '8px',
                  height: '8px',
                  borderRadius: '50%',
                  background: '#00f2fe',
                  boxShadow: '0 0 10px #00f2fe',
                  display: 'inline-block',
                }}
              />
              <span
                style={{
                  fontSize: '0.74rem',
                  fontWeight: 800,
                  letterSpacing: '0.12em',
                  textTransform: 'uppercase',
                  color: '#00f2fe',
                }}
              >
                STAGE {curr.num} OF 07: {curr.title}
              </span>
            </div>

            <div style={{ display: 'flex', alignItems: 'center', gap: '8px' }}>
              {/* Telemetry pill */}
              <div
                style={{
                  display: 'flex',
                  alignItems: 'center',
                  gap: '10px',
                  background: 'rgba(15, 23, 42, 0.85)',
                  backdropFilter: 'blur(12px)',
                  border: '1px solid rgba(255, 255, 255, 0.1)',
                  borderRadius: '10px',
                  padding: '5px 10px',
                }}
              >
                <div style={{ fontSize: '0.82rem', fontWeight: 800, color: '#00f2fe', fontFamily: 'monospace' }}>
                  {speedKmH} <span style={{ fontSize: '0.62rem' }}>KM/H</span>
                </div>
                <div style={{ width: '1px', height: '16px', background: 'rgba(255, 255, 255, 0.15)' }} />
                <div
                  style={{
                    fontSize: '0.7rem',
                    fontWeight: 700,
                    color: isDriving ? '#38bdf8' : '#fbbf24',
                  }}
                >
                  {isDriving ? '⚡ CRUISING' : '📍 CHECKPOINT'}
                </div>
              </div>

              {/* Next Stage Button */}
              <button
                onClick={() => {
                  const nextIdx = (activeStage + 1) % STAGES.length;
                  driveToStage(nextIdx);
                }}
                style={{
                  background: 'linear-gradient(135deg, #00f2fe 0%, #0284c7 100%)',
                  color: '#070b14',
                  border: 'none',
                  borderRadius: '10px',
                  padding: '6px 14px',
                  fontSize: '0.78rem',
                  fontWeight: 700,
                  cursor: 'pointer',
                  display: 'flex',
                  alignItems: 'center',
                  gap: '5px',
                  boxShadow: '0 4px 14px rgba(0, 242, 254, 0.35)',
                  transition: 'transform 0.2s',
                }}
                onMouseEnter={(e) => (e.currentTarget.style.transform = 'translateY(-1px)')}
                onMouseLeave={(e) => (e.currentTarget.style.transform = 'translateY(0)')}
              >
                ▶ Next
              </button>

              {/* Auto Cruise Toggle */}
              <button
                onClick={toggleAutoCruise}
                style={{
                  background: isAutoCruise ? 'rgba(0, 242, 254, 0.15)' : 'rgba(15, 23, 42, 0.85)',
                  border: isAutoCruise ? '1px solid #00f2fe' : '1px solid rgba(255, 255, 255, 0.1)',
                  color: isAutoCruise ? '#00f2fe' : '#ffffff',
                  borderRadius: '10px',
                  padding: '6px 12px',
                  fontSize: '0.75rem',
                  fontWeight: 600,
                  cursor: 'pointer',
                  display: 'flex',
                  alignItems: 'center',
                  gap: '4px',
                  backdropFilter: 'blur(12px)',
                }}
              >
                🎮 {isAutoCruise ? 'Auto ON' : 'Auto'}
              </button>
            </div>
          </div>

          {/* 7 Stage Pills Navigation */}
          <div
            style={{
              display: 'flex',
              gap: '6px',
              overflowX: 'auto',
              paddingBottom: '2px',
              pointerEvents: 'auto',
              scrollbarWidth: 'none',
              msOverflowStyle: 'none',
            }}
          >
            {STAGES.map((st, idx) => {
              const isActive = idx === activeStage;
              return (
                <button
                  key={st.num}
                  onClick={() => driveToStage(idx)}
                  style={{
                    flex: '0 0 auto',
                    display: 'flex',
                    alignItems: 'center',
                    gap: '5px',
                    padding: '5px 10px',
                    borderRadius: '8px',
                    border: isActive ? `1.5px solid ${st.accent}` : '1px solid rgba(255, 255, 255, 0.08)',
                    background: isActive ? 'rgba(15, 23, 42, 0.92)' : 'rgba(15, 23, 42, 0.55)',
                    color: isActive ? '#ffffff' : 'rgba(255, 255, 255, 0.65)',
                    fontSize: '0.72rem',
                    fontWeight: isActive ? 700 : 500,
                    cursor: 'pointer',
                    boxShadow: isActive ? `0 0 12px ${st.accent}33` : 'none',
                    backdropFilter: 'blur(8px)',
                    transition: 'all 0.2s ease',
                  }}
                >
                  <span
                    style={{
                      fontSize: '0.68rem',
                      fontWeight: 800,
                      color: st.accent,
                      background: 'rgba(255,255,255,0.06)',
                      padding: '1px 4px',
                      borderRadius: '3px',
                    }}
                  >
                    {st.num}
                  </span>
                  <span>{st.title}</span>
                </button>
              );
            })}
          </div>
        </div>

        {/* --- Mouse Scroll Visual Discovery Hint --- */}
        {showScrollHint && (
          <div
            style={{
              position: 'absolute',
              top: isMobile ? '146px' : '95px',
              left: '50%',
              transform: 'translateX(-50%)',
              background: 'rgba(15, 23, 42, 0.85)',
              backdropFilter: 'blur(14px)',
              border: '1px solid rgba(0, 242, 254, 0.3)',
              borderRadius: '20px',
              padding: '6px 16px',
              fontSize: '0.74rem',
              fontWeight: 600,
              color: '#38bdf8',
              display: 'flex',
              alignItems: 'center',
              gap: '6px',
              pointerEvents: 'none',
              zIndex: 15,
              boxShadow: '0 4px 20px rgba(0, 0, 0, 0.5)',
              animation: 'pulse 2s infinite',
            }}
          >
            <span>🖱️</span>
            <span>{isMobile ? 'Swipe to drive along road' : 'Scroll mouse wheel to drive along roadmap'}</span>
          </div>
        )}

        {/* --- Desktop Checkpoint Mission Card --- */}
        {!isMobile && (
          <div
            style={{
              position: 'absolute',
              bottom: '20px',
              left: '20px',
              maxWidth: '400px',
              width: 'calc(100% - 40px)',
              background: 'rgba(9, 14, 26, 0.9)',
              backdropFilter: 'blur(20px)',
              border: `1px solid ${curr.accent}44`,
              borderRadius: '16px',
              padding: '18px 20px',
              boxShadow: `0 20px 50px rgba(0, 0, 0, 0.85), 0 0 30px ${curr.accent}22`,
              zIndex: 25,
            }}
          >
            <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', marginBottom: '8px' }}>
              <div style={{ display: 'flex', alignItems: 'center', gap: '8px' }}>
                <span
                  style={{
                    fontSize: '1.1rem',
                    display: 'flex',
                    alignItems: 'center',
                    justifyContent: 'center',
                    width: '32px',
                    height: '32px',
                    borderRadius: '8px',
                    background: `${curr.accent}22`,
                    border: `1px solid ${curr.accent}44`,
                  }}
                >
                  {curr.icon}
                </span>
                <div>
                  <div style={{ fontSize: '0.64rem', fontWeight: 800, letterSpacing: '0.12em', color: curr.accent, textTransform: 'uppercase' }}>
                    CHECKPOINT {curr.num} OF 07
                  </div>
                  <h3 style={{ fontSize: '1.02rem', fontWeight: 700, color: '#ffffff', margin: 0 }}>
                    {curr.title}
                  </h3>
                </div>
              </div>

              <div
                style={{
                  fontSize: '0.7rem',
                  fontWeight: 600,
                  color: '#ffffff',
                  background: 'rgba(255, 255, 255, 0.08)',
                  padding: '3px 8px',
                  borderRadius: '16px',
                  border: '1px solid rgba(255, 255, 255, 0.1)',
                }}
              >
                ⏱ {curr.duration}
              </div>
            </div>

            <div style={{ fontSize: '0.74rem', color: 'rgba(255, 255, 255, 0.45)', marginBottom: '8px' }}>
              📍 {curr.district}
            </div>

            <p
              style={{
                fontSize: '0.82rem',
                lineHeight: 1.5,
                color: 'rgba(255, 255, 255, 0.85)',
                margin: '0 0 12px 0',
              }}
            >
              {curr.body}
            </p>

            <div
              style={{
                paddingTop: '10px',
                borderTop: '1px solid rgba(255, 255, 255, 0.08)',
                display: 'flex',
                alignItems: 'center',
                justifyContent: 'space-between',
                gap: '10px',
              }}
            >
              <div>
                <div style={{ fontSize: '0.62rem', color: 'rgba(255, 255, 255, 0.45)', letterSpacing: '0.08em', textTransform: 'uppercase', fontWeight: 600 }}>
                  STAGE DELIVERABLE
                </div>
                <div style={{ fontSize: '0.78rem', fontWeight: 700, color: '#ffffff', display: 'flex', alignItems: 'center', gap: '4px' }}>
                  <span style={{ color: curr.accent }}>✓</span> {curr.deliverable}
                </div>
              </div>

              <button
                onClick={() => {
                  const nextIdx = (activeStage + 1) % STAGES.length;
                  driveToStage(nextIdx);
                }}
                style={{
                  background: 'rgba(255, 255, 255, 0.06)',
                  border: '1px solid rgba(255, 255, 255, 0.15)',
                  borderRadius: '8px',
                  padding: '5px 10px',
                  fontSize: '0.72rem',
                  fontWeight: 600,
                  color: '#ffffff',
                  cursor: 'pointer',
                  whiteSpace: 'nowrap',
                }}
              >
                Next Stage →
              </button>
            </div>
          </div>
        )}
      </div>

      {/* --- Mobile Checkpoint Mission Card --- */}
      {isMobile && (
        <div
          style={{
            marginTop: '12px',
            background: 'rgba(9, 14, 26, 0.95)',
            border: `1px solid ${curr.accent}44`,
            borderRadius: '16px',
            padding: '16px 18px',
            boxShadow: `0 10px 30px rgba(0, 0, 0, 0.6), 0 0 20px ${curr.accent}15`,
          }}
        >
          <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', marginBottom: '8px' }}>
            <div style={{ display: 'flex', alignItems: 'center', gap: '8px' }}>
              <span
                style={{
                  fontSize: '1rem',
                  display: 'flex',
                  alignItems: 'center',
                  justifyContent: 'center',
                  width: '30px',
                  height: '30px',
                  borderRadius: '8px',
                  background: `${curr.accent}22`,
                  border: `1px solid ${curr.accent}44`,
                }}
              >
                {curr.icon}
              </span>
              <div>
                <div style={{ fontSize: '0.62rem', fontWeight: 800, letterSpacing: '0.12em', color: curr.accent, textTransform: 'uppercase' }}>
                  CHECKPOINT {curr.num} OF 07
                </div>
                <h3 style={{ fontSize: '0.98rem', fontWeight: 700, color: '#ffffff', margin: 0 }}>
                  {curr.title}
                </h3>
              </div>
            </div>

            <div
              style={{
                fontSize: '0.68rem',
                fontWeight: 600,
                color: '#ffffff',
                background: 'rgba(255, 255, 255, 0.08)',
                padding: '3px 8px',
                borderRadius: '16px',
                border: '1px solid rgba(255, 255, 255, 0.1)',
              }}
            >
              ⏱ {curr.duration}
            </div>
          </div>

          <div style={{ fontSize: '0.72rem', color: 'rgba(255, 255, 255, 0.45)', marginBottom: '8px' }}>
            📍 {curr.district}
          </div>

          <p
            style={{
              fontSize: '0.8rem',
              lineHeight: 1.5,
              color: 'rgba(255, 255, 255, 0.85)',
              margin: '0 0 10px 0',
            }}
          >
            {curr.body}
          </p>

          <div
            style={{
              paddingTop: '10px',
              borderTop: '1px solid rgba(255, 255, 255, 0.08)',
              display: 'flex',
              alignItems: 'center',
              justifyContent: 'space-between',
              gap: '10px',
            }}
          >
            <div>
              <div style={{ fontSize: '0.6rem', color: 'rgba(255, 255, 255, 0.45)', letterSpacing: '0.08em', textTransform: 'uppercase', fontWeight: 600 }}>
                STAGE DELIVERABLE
              </div>
              <div style={{ fontSize: '0.76rem', fontWeight: 700, color: '#ffffff' }}>
                <span style={{ color: curr.accent }}>✓</span> {curr.deliverable}
              </div>
            </div>

            <button
              onClick={() => {
                const nextIdx = (activeStage + 1) % STAGES.length;
                driveToStage(nextIdx);
              }}
              style={{
                background: 'linear-gradient(135deg, #00f2fe 0%, #0284c7 100%)',
                color: '#070b14',
                border: 'none',
                borderRadius: '8px',
                padding: '6px 12px',
                fontSize: '0.72rem',
                fontWeight: 700,
                cursor: 'pointer',
                whiteSpace: 'nowrap',
              }}
            >
              Next Stage →
            </button>
          </div>
        </div>
      )}
    </div>
  );
}
