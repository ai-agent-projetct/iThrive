import React, { useState, useEffect, useRef } from 'react';
import * as THREE from 'three';

const DRIVERS = [
  {
    id: 1,
    key: 'complexity',
    num: '01',
    title: 'System Complexity',
    subsystem: 'Workflow Engine & State Machine',
    body: 'One workflow with clear rules is cheap. Six workflows that disagree with each other is where the cost lives.',
    impact: '+20% to +45%',
    level: 'High',
    color: '#00f2fe',
    cheaper: 'Isolate the critical path for launch; defer non-standard branch logic to Phase 2.',
    reality: 'Contradictory rules require deterministic state machines and combinatorial automated testing.'
  },
  {
    id: 2,
    key: 'integrations',
    num: '02',
    title: 'Integrations',
    subsystem: 'API Gateway & Circuit Breakers',
    body: 'Every external system adds contract work, sandbox access, error handling and a failure mode to design for.',
    impact: '+30% to +60%',
    level: 'Critical',
    color: '#38bdf8',
    cheaper: 'Standard webhook ingestion with asynchronous queue buffering.',
    reality: 'Legacy ERPs and bespoke billing systems require custom transformation layers and retry queues.'
  },
  {
    id: 3,
    key: 'ai',
    num: '03',
    title: 'AI Components',
    subsystem: 'Neural Vector & RAG Pipeline',
    body: 'Retrieval on clean documents is quick. Extraction from scanned, inconsistent paperwork is a project of its own.',
    impact: '+25% to +50%',
    level: 'Medium-High',
    color: '#a855f7',
    cheaper: 'Pre-formatted digital JSON/markdown pipelines with prompt caching.',
    reality: 'Noisy scanned PDFs require multi-modal OCR, human approval workflows, and fallback evaluation.'
  },
  {
    id: 4,
    key: 'compliance',
    num: '04',
    title: 'Compliance & Security',
    subsystem: 'Encrypted Vault & Audit Trails',
    body: 'Regulated data brings audit trails, residency, retention rules and evidence — real engineering, not paperwork.',
    impact: '+35% to +70%',
    level: 'Critical',
    color: '#eab308',
    cheaper: 'VPC-isolated encryption at rest with automated rolling database snapshots.',
    reality: 'DPDP / HIPAA / SOC 2 requires column-level encryption, tamper-evident audit logs, and auditor verification.'
  },
  {
    id: 5,
    key: 'scale',
    num: '05',
    title: 'Concurrency & Scale',
    subsystem: 'Distributed Pods & L2 Cache',
    body: 'A hundred internal users and a hundred thousand public ones are different architectures, not different server sizes.',
    impact: '+40% to +85%',
    level: 'Very High',
    color: '#22c55e',
    cheaper: 'Single-region deployment with PgBouncer connection pooling and CDN caching.',
    reality: '100k+ concurrent users requires horizontal pod auto-scaling, distributed locks, and zero-downtime migrations.'
  },
  {
    id: 6,
    key: 'migration',
    num: '06',
    title: 'Data Migration',
    subsystem: 'ETL Pipeline & Schema Reconciliation',
    body: 'Moving a decade of records with inconsistent history is often the largest single line in the estimate.',
    impact: '+30% to +65%',
    level: 'High',
    color: '#ec4899',
    cheaper: 'Point-in-time cutover (migrate active 12-month records, archive legacy in cold storage).',
    reality: 'Orphan foreign keys and dirty records require custom automated reconciliation pipelines with rollback dry-runs.'
  }
];

export default function EstimateDrivers3D() {
  const [activeDriver, setActiveDriver] = useState(0);
  const [isMobile, setIsMobile] = useState(typeof window !== 'undefined' ? window.innerWidth < 880 : false);
  const mountRef = useRef(null);
  const sceneRef = useRef(null);
  const rendererRef = useRef(null);
  const cameraRef = useRef(null);
  const slabsRef = useRef([]);
  const animFrameRef = useRef(null);
  const isInteracting = useRef(false);
  const mousePos = useRef({ x: 0, y: 0 });
  const activeDriverRef = useRef(0);

  useEffect(() => {
    const handleResize = () => setIsMobile(window.innerWidth < 880);
    window.addEventListener('resize', handleResize);
    return () => window.removeEventListener('resize', handleResize);
  }, []);

  useEffect(() => {
    activeDriverRef.current = activeDriver;
  }, [activeDriver]);

  useEffect(() => {
    const container = mountRef.current;
    if (!container) return;

    const width = container.clientWidth || 480;
    const height = container.clientHeight || 460;

    // Three.js Scene Setup
    const scene = new THREE.Scene();
    sceneRef.current = scene;

    // Isometric-style Perspective Camera
    const camera = new THREE.PerspectiveCamera(38, width / height, 0.1, 1000);
    camera.position.set(18, 14, 18);
    camera.lookAt(0, 0, 0);
    cameraRef.current = camera;

    const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
    renderer.setSize(width, height);
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
    renderer.toneMapping = THREE.ACESFilmicToneMapping;
    renderer.toneMappingExposure = 1.1;
    container.appendChild(renderer.domElement);
    rendererRef.current = renderer;

    // Ambient and Directional Lights
    const ambientLight = new THREE.AmbientLight(0x0f172a, 3.5);
    scene.add(ambientLight);

    const dirLight = new THREE.DirectionalLight(0x38bdf8, 2.5);
    dirLight.position.set(10, 20, 15);
    scene.add(dirLight);

    const backLight = new THREE.DirectionalLight(0xa855f7, 2.0);
    backLight.position.set(-15, -10, -15);
    scene.add(backLight);

    // Group for the 6 isometric architectural slabs
    const stackGroup = new THREE.Group();
    scene.add(stackGroup);

    const slabMeshes = [];
    const slabCount = 6;
    const slabSpacing = 1.65;
    const totalHeight = (slabCount - 1) * slabSpacing;

    DRIVERS.forEach((d, i) => {
      const slabGeometry = new THREE.BoxGeometry(6.4, 0.55, 6.4);
      
      const slabMaterial = new THREE.MeshPhysicalMaterial({
        color: new THREE.Color(d.color),
        metalness: 0.15,
        roughness: 0.25,
        transmission: 0.72,
        thickness: 1.2,
        transparent: true,
        opacity: 0.85,
        reflectivity: 0.9,
        clearcoat: 0.8
      });

      const slabMesh = new THREE.Mesh(slabGeometry, slabMaterial);
      const baseY = (i - (slabCount - 1) / 2) * slabSpacing;
      slabMesh.position.set(0, baseY, 0);

      // Edges wireframe for high-tech aesthetic
      const edges = new THREE.EdgesGeometry(slabGeometry);
      const lineMaterial = new THREE.LineBasicMaterial({ 
        color: new THREE.Color(d.color),
        transparent: true,
        opacity: 0.95,
        linewidth: 1.5
      });
      const wireframe = new THREE.LineSegments(edges, lineMaterial);
      slabMesh.add(wireframe);

      // Core glow light inside each slab
      const innerCoreGeom = new THREE.BoxGeometry(5.2, 0.2, 5.2);
      const innerCoreMat = new THREE.MeshBasicMaterial({
        color: new THREE.Color(d.color),
        transparent: true,
        opacity: 0.35
      });
      const innerCore = new THREE.Mesh(innerCoreGeom, innerCoreMat);
      slabMesh.add(innerCore);

      stackGroup.add(slabMesh);
      slabMeshes.push({
        mesh: slabMesh,
        baseY,
        driverIndex: i,
        color: d.color
      });
    });

    slabsRef.current = slabMeshes;

    // Base pedestal grid
    const gridHelper = new THREE.GridHelper(16, 16, 0x00f2fe, 0x1e293b);
    gridHelper.position.y = -totalHeight / 2 - 1.2;
    scene.add(gridHelper);

    // Floating particles
    const particleCount = 120;
    const particleGeom = new THREE.BufferGeometry();
    const particlePositions = new Float32Array(particleCount * 3);
    for (let p = 0; p < particleCount * 3; p += 3) {
      particlePositions[p] = (Math.random() - 0.5) * 22;
      particlePositions[p + 1] = (Math.random() - 0.5) * 16;
      particlePositions[p + 2] = (Math.random() - 0.5) * 22;
    }
    particleGeom.setAttribute('position', new THREE.BufferAttribute(particlePositions, 3));
    const particleMat = new THREE.PointsMaterial({
      color: 0x38bdf8,
      size: 0.12,
      transparent: true,
      opacity: 0.6
    });
    const particles = new THREE.Points(particleGeom, particleMat);
    scene.add(particles);

    // Pointer rotation controls
    let startX = 0;
    let startY = 0;
    let targetRotY = Math.PI / 4;
    let targetRotX = 0;

    const onPointerDown = (e) => {
      isInteracting.current = true;
      startX = e.clientX;
      startY = e.clientY;
    };

    const onPointerMove = (e) => {
      if (!isInteracting.current) return;
      const dx = e.clientX - startX;
      const dy = e.clientY - startY;
      startX = e.clientX;
      startY = e.clientY;
      targetRotY += dx * 0.008;
      targetRotX = Math.max(-0.4, Math.min(0.4, targetRotX + dy * 0.008));
    };

    const onPointerUp = () => {
      isInteracting.current = false;
    };

    container.addEventListener('pointerdown', onPointerDown);
    window.addEventListener('pointermove', onPointerMove);
    window.addEventListener('pointerup', onPointerUp);

    // Animation Loop
    let clock = new THREE.Clock();
    const animate = () => {
      const delta = clock.getDelta();
      const elapsed = clock.getElapsedTime();

      // Smooth stack rotation
      if (!isInteracting.current) {
        targetRotY += delta * 0.22;
      }
      stackGroup.rotation.y += (targetRotY - stackGroup.rotation.y) * 0.08;
      stackGroup.rotation.x += (targetRotX - stackGroup.rotation.x) * 0.08;

      // Pulse and elevate active slab
      const currentActive = activeDriverRef.current;
      slabMeshes.forEach((item) => {
        const isSelected = item.driverIndex === currentActive;
        const targetElevation = isSelected ? item.baseY + 1.2 : item.baseY;
        item.mesh.position.y += (targetElevation - item.mesh.position.y) * 0.12;

        const targetScale = isSelected ? 1.08 : 1.0;
        item.mesh.scale.x += (targetScale - item.mesh.scale.x) * 0.12;
        item.mesh.scale.z += (targetScale - item.mesh.scale.z) * 0.12;

        // Visual pulse
        if (isSelected) {
          item.mesh.material.opacity = 0.95 + Math.sin(elapsed * 4) * 0.05;
        } else {
          item.mesh.material.opacity = 0.55;
        }
      });

      // Subtle particle float
      particles.rotation.y = elapsed * 0.04;

      renderer.render(scene, camera);
      animFrameRef.current = requestAnimationFrame(animate);
    };

    animFrameRef.current = requestAnimationFrame(animate);

    const handleResize = () => {
      if (!container || !renderer || !camera) return;
      const w = container.clientWidth;
      const h = container.clientHeight;
      camera.aspect = w / h;
      camera.updateProjectionMatrix();
      renderer.setSize(w, h);
    };

    window.addEventListener('resize', handleResize);

    return () => {
      cancelAnimationFrame(animFrameRef.current);
      window.removeEventListener('resize', handleResize);
      container.removeEventListener('pointerdown', onPointerDown);
      window.removeEventListener('pointermove', onPointerMove);
      window.removeEventListener('pointerup', onPointerUp);
      if (renderer.domElement && renderer.domElement.parentNode) {
        renderer.domElement.parentNode.removeChild(renderer.domElement);
      }
      renderer.dispose();
    };
  }, []);

  const activeData = DRIVERS[activeDriver];

  return (
    <div 
      className="sd-drivers-3d-root"
      style={{
        position: 'relative',
        width: '100%',
        padding: '20px 0 30px',
        display: 'grid',
        gridTemplateColumns: isMobile ? '1fr' : 'minmax(320px, 1.15fr) minmax(320px, 1fr)',
        gap: isMobile ? '24px' : '32px',
        alignItems: 'center'
      }}
    >
      {/* Column 1: Interactive 3D Isometric Viewport */}
      <div 
        style={{
          position: 'relative',
          width: '100%',
          height: isMobile ? '340px' : '520px',
          borderRadius: isMobile ? '18px' : '24px',
          background: 'radial-gradient(ellipse at center, rgba(14, 23, 42, 0.75) 0%, rgba(5, 8, 17, 0.95) 100%)',
          border: '1px solid rgba(255, 255, 255, 0.1)',
          boxShadow: '0 24px 60px rgba(0, 0, 0, 0.6), inset 0 0 40px rgba(0, 242, 254, 0.05)',
          overflow: 'hidden',
          display: 'flex',
          flexDirection: 'column',
          justifyContent: 'space-between'
        }}
      >
        {/* Top HUD overlay */}
        <div 
          style={{
            position: 'absolute',
            top: '20px',
            left: '20px',
            right: '20px',
            display: 'flex',
            alignItems: 'center',
            justifyContent: 'space-between',
            zIndex: 10,
            pointerEvents: 'none'
          }}
        >
          <div style={{ display: 'flex', alignItems: 'center', gap: '8px' }}>
            <span 
              style={{
                width: '8px',
                height: '8px',
                borderRadius: '50%',
                background: activeData.color,
                boxShadow: `0 0 10px ${activeData.color}`
              }} 
            />
            <span style={{ fontSize: '0.75rem', fontWeight: '700', letterSpacing: '0.08em', textTransform: 'uppercase', color: '#ffffff' }}>
              3D Architecture Matrix
            </span>
          </div>
          <span 
            style={{
              fontSize: '0.72rem',
              fontWeight: '700',
              padding: '4px 10px',
              borderRadius: '999px',
              background: 'rgba(0, 0, 0, 0.6)',
              border: `1px solid ${activeData.color}66`,
              color: activeData.color
            }}
          >
            Active Layer: {activeData.num} / 06
          </span>
        </div>

        {/* Three.js Canvas Container */}
        <div 
          ref={mountRef} 
          style={{ 
            width: '100%', 
            height: '100%', 
            cursor: 'grab' 
          }} 
        />

        {/* Bottom 3D Hint */}
        <div 
          style={{
            position: 'absolute',
            bottom: '16px',
            left: '0',
            right: '0',
            textAlign: 'center',
            fontSize: '0.72rem',
            color: 'rgba(255, 255, 255, 0.45)',
            zIndex: 10,
            pointerEvents: 'none'
          }}
        >
          ⇄ Drag to rotate isometric perspective • Click layers to elevate
        </div>
      </div>

      {/* Column 2: Interactive Lever Studio Console */}
      <div style={{ display: 'flex', flexDirection: 'column', gap: '20px' }}>
        {/* Active Driver Telemetry Card */}
        <div 
          style={{
            padding: '28px 28px',
            borderRadius: '20px',
            background: 'linear-gradient(145deg, rgba(16, 24, 45, 0.94), rgba(7, 12, 26, 0.98))',
            border: `1.5px solid ${activeData.color}80`,
            boxShadow: `0 16px 40px rgba(0, 0, 0, 0.5), 0 0 30px ${activeData.color}26`,
            position: 'relative',
            overflow: 'hidden'
          }}
        >
          {/* Top Line: Subsystem + Multiplier */}
          <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', marginBottom: '12px' }}>
            <span 
              style={{
                fontSize: '0.74rem',
                fontWeight: '700',
                letterSpacing: '0.08em',
                textTransform: 'uppercase',
                color: activeData.color
              }}
            >
              {activeData.subsystem}
            </span>
            <div 
              style={{
                display: 'inline-flex',
                alignItems: 'center',
                gap: '6px',
                padding: '4px 12px',
                borderRadius: '999px',
                background: `${activeData.color}1a`,
                border: `1px solid ${activeData.color}4d`,
                color: activeData.color,
                fontSize: '0.82rem',
                fontWeight: '800'
              }}
            >
              <span>Estimate Impact:</span>
              <span>{activeData.impact}</span>
            </div>
          </div>

          <h3 
            style={{
              fontSize: '1.4rem',
              fontWeight: '700',
              color: '#ffffff',
              lineHeight: '1.25',
              marginBottom: '10px'
            }}
          >
            {activeData.title}
          </h3>

          <p 
            style={{
              fontSize: '0.92rem',
              lineHeight: '1.65',
              color: 'rgba(203, 213, 225, 0.9)',
              margin: '0 0 20px'
            }}
          >
            {activeData.body}
          </p>

          {/* Trade-off Comparison Grid */}
          <div 
            style={{
              display: 'grid',
              gridTemplateColumns: isMobile ? '1fr' : '1fr 1fr',
              gap: '12px',
              paddingTop: '16px',
              borderTop: '1px solid rgba(255, 255, 255, 0.08)'
            }}
          >
            <div 
              style={{
                padding: '12px 14px',
                borderRadius: '12px',
                background: 'rgba(34, 197, 94, 0.06)',
                border: '1px solid rgba(34, 197, 94, 0.2)'
              }}
            >
              <strong style={{ display: 'block', fontSize: '0.72rem', color: '#22c55e', textTransform: 'uppercase', letterSpacing: '0.06em', marginBottom: '4px' }}>
                Cheaper Path
              </strong>
              <span style={{ fontSize: '0.78rem', color: 'rgba(255, 255, 255, 0.85)', lineHeight: '1.45' }}>
                {activeData.cheaper}
              </span>
            </div>

            <div 
              style={{
                padding: '12px 14px',
                borderRadius: '12px',
                background: 'rgba(236, 72, 153, 0.06)',
                border: '1px solid rgba(236, 72, 153, 0.2)'
              }}
            >
              <strong style={{ display: 'block', fontSize: '0.72rem', color: '#ec4899', textTransform: 'uppercase', letterSpacing: '0.06em', marginBottom: '4px' }}>
                Production Reality
              </strong>
              <span style={{ fontSize: '0.78rem', color: 'rgba(255, 255, 255, 0.85)', lineHeight: '1.45' }}>
                {activeData.reality}
              </span>
            </div>
          </div>
        </div>

        {/* 6 Interactive Lever Selection Pills */}
        <div 
          style={{
            display: 'grid',
            gridTemplateColumns: isMobile ? 'repeat(2, 1fr)' : 'repeat(3, 1fr)',
            gap: '10px'
          }}
        >
          {DRIVERS.map((driver, idx) => {
            const isSelected = idx === activeDriver;
            return (
              <button
                key={driver.id}
                type="button"
                onClick={() => setActiveDriver(idx)}
                style={{
                  display: 'flex',
                  alignItems: 'center',
                  gap: '8px',
                  padding: '12px 14px',
                  borderRadius: '14px',
                  background: isSelected 
                    ? `linear-gradient(135deg, ${driver.color}26, rgba(15, 23, 42, 0.9))`
                    : 'rgba(15, 23, 42, 0.55)',
                  border: isSelected ? `1.5px solid ${driver.color}` : '1px solid rgba(255, 255, 255, 0.08)',
                  cursor: 'pointer',
                  textAlign: 'left',
                  transition: 'all 0.25s cubic-bezier(0.16, 1, 0.3, 1)',
                  boxShadow: isSelected ? `0 6px 16px ${driver.color}33` : 'none'
                }}
              >
                <span 
                  style={{
                    fontFamily: 'monospace',
                    fontSize: '0.76rem',
                    fontWeight: '800',
                    color: isSelected ? driver.color : 'rgba(255, 255, 255, 0.4)'
                  }}
                >
                  {driver.num}
                </span>
                <span 
                  style={{
                    fontSize: '0.82rem',
                    fontWeight: '600',
                    color: isSelected ? '#ffffff' : 'rgba(255, 255, 255, 0.75)',
                    whiteSpace: 'nowrap',
                    overflow: 'hidden',
                    textOverflow: 'ellipsis'
                  }}
                >
                  {driver.title}
                </span>
              </button>
            );
          })}
        </div>
      </div>
    </div>
  );
}
