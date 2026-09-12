import React, { useState, useRef, useEffect, useCallback, useMemo } from 'react';

// Curated 44 technologies matching SOFT_STACK from iThrive
const TECH_DATA = [
  // Backend
  { id: 'python', name: 'Python', category: 'Backend', icon: '/assets/img/tech/python.svg', desc: 'Core language for APIs, data & AI pipelines' },
  { id: 'django', name: 'Django', category: 'Backend', icon: '/assets/img/tech/django.svg', desc: 'High-level Python web framework for rapid build' },
  { id: 'fastapi', name: 'FastAPI', category: 'Backend', icon: '/assets/img/tech/fastapi.svg', desc: 'High-performance asynchronous Python API framework' },
  { id: 'nodedotjs', name: 'Node.js', category: 'Backend', icon: '/assets/img/tech/nodedotjs.svg', desc: 'Event-driven runtime for scalable microservices' },
  { id: 'php', name: 'PHP', category: 'Backend', icon: '/assets/img/tech/php.svg', desc: 'Server scripting engine powering enterprise web' },
  { id: 'laravel', name: 'Laravel', category: 'Backend', icon: '/assets/img/tech/laravel.svg', desc: 'Elegant PHP framework for expressive backends' },
  { id: 'openjdk', name: 'Java', category: 'Backend', icon: '/assets/img/tech/openjdk.svg', desc: 'Enterprise-grade high-throughput architecture' },
  { id: 'dotnet', name: '.NET', category: 'Backend', icon: '/assets/img/tech/dotnet.svg', desc: 'High-performance cross-platform Microsoft framework' },
  { id: 'go', name: 'Go', category: 'Backend', icon: '/assets/img/tech/go.svg', desc: 'Concurrent systems programming for microservices' },
  { id: 'express', name: 'Express', category: 'Backend', icon: '/assets/img/tech/express.svg', desc: 'Fast, minimalist web framework for Node.js' },

  // Frontend
  { id: 'react', name: 'React', category: 'Frontend', icon: '/assets/img/tech/react.svg', desc: 'Component-based library for dynamic user interfaces' },
  { id: 'nextdotjs', name: 'Next.js', category: 'Frontend', icon: '/assets/img/tech/nextdotjs.svg', desc: 'Production React framework with SSR & Edge rendering' },
  { id: 'vuedotjs', name: 'Vue.js', category: 'Frontend', icon: '/assets/img/tech/vuedotjs.svg', desc: 'Progressive JavaScript framework for modern SPAs' },
  { id: 'typescript', name: 'TypeScript', category: 'Frontend', icon: '/assets/img/tech/typescript.svg', desc: 'Strictly typed JavaScript for robust engineering' },
  { id: 'tailwindcss', name: 'Tailwind CSS', category: 'Frontend', icon: '/assets/img/tech/tailwindcss.svg', desc: 'Utility-first CSS framework for custom design systems' },
  { id: 'threedotjs', name: 'Three.js', category: 'Frontend', icon: '/assets/img/tech/threedotjs.svg', desc: 'Hardware-accelerated 3D WebGL graphics in browser' },
  { id: 'vite', name: 'Vite', category: 'Frontend', icon: '/assets/img/tech/vite.svg', desc: 'Blazing fast next-generation frontend bundler' },
  { id: 'angular', name: 'Angular', category: 'Frontend', icon: '/assets/img/tech/angular.svg', desc: 'Comprehensive enterprise frontend application platform' },

  // Mobile
  { id: 'flutter', name: 'Flutter', category: 'Mobile', icon: '/assets/img/tech/flutter.svg', desc: 'Multi-platform native apps with Dart & Skia rendering' },
  { id: 'reactnative', name: 'React Native', category: 'Mobile', icon: '/assets/img/tech/react.svg', desc: 'Native iOS & Android mobile apps with React core' },
  { id: 'swift', name: 'Swift', category: 'Mobile', icon: '/assets/img/tech/swift.svg', desc: 'High-performance native iOS and macOS development' },
  { id: 'kotlin', name: 'Kotlin', category: 'Mobile', icon: '/assets/img/tech/kotlin.svg', desc: 'Modern native Android development with coroutines' },

  // Data
  { id: 'postgresql', name: 'PostgreSQL', category: 'Data', icon: '/assets/img/tech/postgresql.svg', desc: 'Advanced open-source relational database with pgvector' },
  { id: 'mysql', name: 'MySQL', category: 'Data', icon: '/assets/img/tech/mysql.svg', desc: 'Battle-tested relational database for high concurrency' },
  { id: 'mongodb', name: 'MongoDB', category: 'Data', icon: '/assets/img/tech/mongodb.svg', desc: 'Document database for flexible schema & streaming' },
  { id: 'redis', name: 'Redis', category: 'Data', icon: '/assets/img/tech/redis.svg', desc: 'Ultra-fast in-memory key-value cache and message broker' },
  { id: 'apacheairflow', name: 'Airflow', category: 'Data', icon: '/assets/img/tech/apacheairflow.svg', desc: 'Programmatic data workflow orchestration & ETL' },
  { id: 'dbt', name: 'dbt', category: 'Data', icon: '/assets/img/tech/dbt.svg', desc: 'Data transformation & analytics engineering workflow' },
  { id: 'opensearch', name: 'OpenSearch', category: 'Data', icon: '/assets/img/tech/opensearch.svg', desc: 'Distributed search and analytics engine for text & logs' },

  // AI & ML
  { id: 'anthropic', name: 'Claude / Anthropic', category: 'AI & ML', icon: '/assets/img/tech/anthropic.svg', desc: 'Frontier reasoning AI models for complex code & workflows' },
  { id: 'openai', name: 'OpenAI / GPT-4o', category: 'AI & ML', icon: '/assets/img/tech/openai.svg', desc: 'Multimodal GPT-4o, reasoning models & Whisper embeddings' },
  { id: 'pytorch', name: 'PyTorch', category: 'AI & ML', icon: '/assets/img/tech/pytorch.svg', desc: 'Deep learning research and production neural models' },
  { id: 'tensorflow', name: 'TensorFlow', category: 'AI & ML', icon: '/assets/img/tech/tensorflow.svg', desc: 'End-to-end machine learning platform & edge inference' },
  { id: 'scikitlearn', name: 'scikit-learn', category: 'AI & ML', icon: '/assets/img/tech/scikitlearn.svg', desc: 'Classical predictive machine learning & statistical models' },
  { id: 'langchain', name: 'LangChain', category: 'AI & ML', icon: '/assets/img/tech/langchain.svg', desc: 'Framework for compound AI systems and autonomous agents' },
  { id: 'pandas', name: 'Pandas', category: 'AI & ML', icon: '/assets/img/tech/pandas.svg', desc: 'Data structures & fast analysis toolkit for AI pipelines' },

  // Cloud & DevOps
  { id: 'aws', name: 'AWS', category: 'Cloud & DevOps', icon: '/assets/img/tech/amazonwebservices.svg', desc: 'Comprehensive cloud compute, serverless & global storage' },
  { id: 'azure', name: 'Azure', category: 'Cloud & DevOps', icon: '/assets/img/tech/azure.svg', desc: 'Enterprise cloud infrastructure and cognitive services' },
  { id: 'gcp', name: 'Google Cloud', category: 'Cloud & DevOps', icon: '/assets/img/tech/googlecloud.svg', desc: 'BigQuery data analytics, Kubernetes Engine & Vertex AI' },
  { id: 'docker', name: 'Docker', category: 'Cloud & DevOps', icon: '/assets/img/tech/docker.svg', desc: 'Containerization for consistent deployment across stages' },
  { id: 'kubernetes', name: 'Kubernetes', category: 'Cloud & DevOps', icon: '/assets/img/tech/kubernetes.svg', desc: 'Automated container orchestration and cluster auto-scaling' },
  { id: 'terraform', name: 'Terraform', category: 'Cloud & DevOps', icon: '/assets/img/tech/terraform.svg', desc: 'Declarative infrastructure as code for multi-cloud stacks' },
  { id: 'githubactions', name: 'GitHub Actions', category: 'Cloud & DevOps', icon: '/assets/img/tech/githubactions.svg', desc: 'Automated CI/CD pipelines & quality enforcement' },
  { id: 'grafana', name: 'Grafana', category: 'Cloud & DevOps', icon: '/assets/img/tech/grafana.svg', desc: 'Real-time observability dashboards, telemetry & alerts' }
];

const CATEGORIES = ['All', 'Backend', 'Frontend', 'Mobile', 'Data', 'AI & ML', 'Cloud & DevOps'];

export default function Arc3DWall() {
  const containerRef = useRef(null);
  const wallRef = useRef(null);

  const [activeCategory, setActiveCategory] = useState('All');
  const [hoveredTech, setHoveredTech] = useState(null);
  const [isAutoDrift, setIsAutoDrift] = useState(true);
  const [isDragging, setIsDragging] = useState(false);
  const [containerSize, setContainerSize] = useState({ width: 1200, height: 600 });

  // Physics state
  const physicsRef = useRef({
    offsetX: 0,
    offsetY: 0,
    velocityX: 14,
    velocityY: 2.5,
    lastPointerX: 0,
    lastPointerY: 0,
    lastTime: performance.now(),
    isPointerDown: false,
    pointerSamples: [],
    cursorX: 600,
    cursorY: 300,
    hasCursor: false,
  });

  // Track container size
  useEffect(() => {
    const el = containerRef.current;
    if (!el) return;
    const ro = new ResizeObserver((entries) => {
      const entry = entries[0];
      if (entry) {
        setContainerSize({
          width: entry.contentRect.width,
          height: entry.contentRect.height,
        });
      }
    });
    ro.observe(el);
    return () => ro.disconnect();
  }, []);

  // Dimensions & Grid Configuration with generous spacing
  const isMobile = containerSize.width < 640;
  const TILE_W = isMobile ? 60 : 76;
  const TILE_H = isMobile ? 60 : 76;
  const GAP_X = isMobile ? 14 : 22; // enhanced breathing room
  const GAP_Y = isMobile ? 14 : 20;
  const SPAN_X = TILE_W + GAP_X;
  const SPAN_Y = TILE_H + GAP_Y;

  const COLS = isMobile ? 14 : 20; // columns in cylindrical circumference
  const ROWS = isMobile ? 5 : 7;   // vertical rows

  // Cylindrical Arc Math
  const RADIUS = isMobile ? 500 : Math.max(800, containerSize.width * 0.76);

  // Continuous animation loop
  useEffect(() => {
    let animId;
    const wallEl = wallRef.current;
    if (!wallEl) return;

    const render = (time) => {
      const p = physicsRef.current;
      const dt = Math.min(0.05, (time - p.lastTime) / 1000);
      p.lastTime = time;

      // Handle motion
      if (!p.isPointerDown) {
        // Friction damping for inertia
        p.velocityX *= Math.pow(0.94, dt * 60);
        p.velocityY *= Math.pow(0.94, dt * 60);

        // Auto-drift if enabled
        if (isAutoDrift) {
          const targetVx = 15; // px per second
          const targetVy = 2.8;
          p.velocityX += (targetVx - p.velocityX) * 0.035;
          p.velocityY += (targetVy - p.velocityY) * 0.035;
        }

        p.offsetX += p.velocityX * dt;
        p.offsetY += p.velocityY * dt;
      }

      // Update DOM tiles directly for maximum fluid performance
      const tileEls = wallEl.querySelectorAll('[data-tile-idx]');
      const centerX = containerSize.width / 2;
      const centerY = containerSize.height / 2;

      tileEls.forEach((tileEl) => {
        const c = parseInt(tileEl.getAttribute('data-col'), 10);
        const r = parseInt(tileEl.getAttribute('data-row'), 10);

        // Calculate continuous virtual position with wrapping
        const totalW = COLS * SPAN_X;
        const totalH = ROWS * SPAN_Y;

        let rawX = c * SPAN_X + p.offsetX;
        let rawY = r * SPAN_Y + p.offsetY;

        // Modulo wrap around center
        rawX = ((rawX % totalW) + totalW) % totalW;
        if (rawX > totalW / 2) rawX -= totalW;

        rawY = ((rawY % totalH) + totalH) % totalH;
        if (rawY > totalH / 2) rawY -= totalH;

        // Cylindrical angle
        const theta = rawX / RADIUS;
        const cosT = Math.cos(theta);
        const sinT = Math.sin(theta);

        // Amphitheater cylindrical 3D coordinates
        const x3d = centerX + RADIUS * sinT - TILE_W / 2;
        const z3d = RADIUS * (cosT - 1);
        const y3d = centerY + rawY - TILE_H / 2;

        // Spherical vertical tilt & horizontal Y-rotation
        const rotY = -theta * (180 / Math.PI);
        const rotX = -(rawY / RADIUS) * 15;

        // Scale & Opacity falloff as cards curve into depth
        const depthScale = Math.max(0.68, 0.72 + 0.38 * Math.max(0, cosT));
        const depthOpacity = Math.max(0.12, Math.pow(Math.max(0, cosT), 1.65));

        // Spotlight & Tilt near cursor
        let cursorTiltX = 0;
        let cursorTiltY = 0;
        let cursorBoost = 1;

        if (p.hasCursor && !p.isPointerDown) {
          const dx = p.cursorX - (x3d + TILE_W / 2);
          const dy = p.cursorY - (y3d + TILE_H / 2);
          const distSq = dx * dx + dy * dy;
          const maxDist = 280;
          if (distSq < maxDist * maxDist) {
            const dist = Math.sqrt(distSq);
            const proximity = 1 - dist / maxDist;
            cursorTiltX = -(dy / maxDist) * 18 * proximity;
            cursorTiltY = (dx / maxDist) * 18 * proximity;
            cursorBoost = 1 + 0.1 * proximity;
          }
        }

        const finalScale = depthScale * cursorBoost;
        const totalRotX = (rotX + cursorTiltX).toFixed(2);
        const totalRotY = (rotY + cursorTiltY).toFixed(2);

        // Apply 3D transform with hardware acceleration
        tileEl.style.transform = `translate3d(${x3d.toFixed(1)}px, ${y3d.toFixed(1)}px, ${z3d.toFixed(1)}px) rotateY(${totalRotY}deg) rotateX(${totalRotX}deg) scale(${finalScale.toFixed(3)})`;
        tileEl.style.opacity = depthOpacity.toFixed(2);
        tileEl.style.zIndex = Math.round(z3d + 2000);

        // Edge blur effect
        if (cosT < 0.62) {
          const blurAmount = ((0.62 - cosT) * 6).toFixed(1);
          tileEl.style.filter = `blur(${blurAmount}px)`;
        } else {
          tileEl.style.filter = 'none';
        }
      });

      animId = requestAnimationFrame(render);
    };

    animId = requestAnimationFrame(render);
    return () => cancelAnimationFrame(animId);
  }, [containerSize, COLS, ROWS, RADIUS, SPAN_X, SPAN_Y, TILE_W, TILE_H, isAutoDrift]);

  // Pointer Drag Handlers
  const handlePointerDown = useCallback((e) => {
    const p = physicsRef.current;
    p.isPointerDown = true;
    p.lastPointerX = e.clientX;
    p.lastPointerY = e.clientY;
    p.pointerSamples = [{ x: e.clientX, y: e.clientY, t: performance.now() }];
    setIsDragging(true);

    if (containerRef.current) {
      containerRef.current.setPointerCapture(e.pointerId);
    }
  }, []);

  const handlePointerMove = useCallback((e) => {
    const p = physicsRef.current;
    const rect = containerRef.current?.getBoundingClientRect();
    if (rect) {
      p.cursorX = e.clientX - rect.left;
      p.cursorY = e.clientY - rect.top;
      p.hasCursor = true;
    }

    if (!p.isPointerDown) return;

    const dx = e.clientX - p.lastPointerX;
    const dy = e.clientY - p.lastPointerY;
    p.lastPointerX = e.clientX;
    p.lastPointerY = e.clientY;

    p.offsetX += dx * 1.15;
    p.offsetY += dy * 1.15;

    const now = performance.now();
    p.pointerSamples.push({ x: e.clientX, y: e.clientY, t: now });
    while (p.pointerSamples.length > 6) p.pointerSamples.shift();
  }, []);

  const handlePointerUp = useCallback((e) => {
    const p = physicsRef.current;
    if (!p.isPointerDown) return;
    p.isPointerDown = false;
    setIsDragging(false);

    if (p.pointerSamples.length >= 2) {
      const first = p.pointerSamples[0];
      const last = p.pointerSamples[p.pointerSamples.length - 1];
      const dt = (last.t - first.t) / 1000;
      if (dt > 0.01) {
        p.velocityX = ((last.x - first.x) / dt) * 0.85;
        p.velocityY = ((last.y - first.y) / dt) * 0.85;
      }
    }
    p.pointerSamples = [];

    try {
      if (containerRef.current?.hasPointerCapture(e.pointerId)) {
        containerRef.current.releasePointerCapture(e.pointerId);
      }
    } catch {}
  }, []);

  // Mouse Wheel Scroll Handler
  const handleWheel = useCallback((e) => {
    const isHorizontal = Math.abs(e.deltaX) > Math.abs(e.deltaY);
    if (isHorizontal || e.shiftKey) {
      e.preventDefault();
      const p = physicsRef.current;
      p.offsetX -= e.deltaX * 0.9;
      p.velocityX = -e.deltaX * 4.0;
    }
  }, []);

  const handlePointerLeave = useCallback(() => {
    physicsRef.current.hasCursor = false;
  }, []);

  // Pre-generate grid tiles
  const gridTiles = useMemo(() => {
    const tiles = [];
    let idx = 0;
    for (let r = 0; r < ROWS; r++) {
      for (let c = 0; c < COLS; c++) {
        const tech = TECH_DATA[(r * COLS + c) % TECH_DATA.length];
        tiles.push({
          key: `${r}-${c}`,
          col: c,
          row: r,
          idx: idx++,
          tech,
        });
      }
    }
    return tiles;
  }, [ROWS, COLS]);

  return (
    <div
      style={{
        position: 'relative',
        width: '100%',
        maxWidth: '1360px',
        margin: '0 auto',
        padding: isMobile ? '12px 0' : '20px 0',
        userSelect: 'none',
      }}
    >
      {/* Category Filter Pills */}
      <div
        style={{
          display: 'flex',
          flexWrap: 'wrap',
          alignItems: 'center',
          justifyContent: 'center',
          gap: '10px',
          marginBottom: '22px',
          padding: '0 16px',
          zIndex: 30,
          position: 'relative',
        }}
      >
        {CATEGORIES.map((cat) => {
          const isActive = activeCategory === cat;
          const count = cat === 'All' ? TECH_DATA.length : TECH_DATA.filter((t) => t.category === cat).length;
          return (
            <button
              key={cat}
              type="button"
              onClick={() => setActiveCategory(cat)}
              style={{
                display: 'inline-flex',
                alignItems: 'center',
                gap: '8px',
                padding: isMobile ? '6px 14px' : '9px 18px',
                fontSize: isMobile ? '12px' : '13px',
                fontWeight: 600,
                borderRadius: '999px',
                border: isActive
                  ? '1px solid rgba(56, 189, 248, 0.85)'
                  : '1px solid rgba(255, 255, 255, 0.12)',
                background: isActive
                  ? 'linear-gradient(135deg, rgba(56, 189, 248, 0.25), rgba(14, 165, 233, 0.10))'
                  : 'rgba(255, 255, 255, 0.04)',
                color: isActive ? '#38bdf8' : '#cbd5e1',
                boxShadow: isActive
                  ? '0 0 20px -2px rgba(56, 189, 248, 0.4), inset 0 1px 0 rgba(255, 255, 255, 0.25)'
                  : 'none',
                cursor: 'pointer',
                transition: 'all 0.25s cubic-bezier(0.16, 1, 0.3, 1)',
                backdropFilter: 'blur(8px)',
              }}
            >
              <span>{cat}</span>
              <span
                style={{
                  fontSize: '11px',
                  fontWeight: 700,
                  opacity: isActive ? 1 : 0.6,
                  background: isActive ? 'rgba(56, 189, 248, 0.3)' : 'rgba(255, 255, 255, 0.08)',
                  padding: '2px 7px',
                  borderRadius: '10px',
                }}
              >
                {count}
              </span>
            </button>
          );
        })}
      </div>

      {/* Main 3D Amphitheater Stage */}
      <div
        ref={containerRef}
        onPointerDown={handlePointerDown}
        onPointerMove={handlePointerMove}
        onPointerUp={handlePointerUp}
        onPointerCancel={handlePointerUp}
        onPointerLeave={handlePointerLeave}
        onWheel={handleWheel}
        style={{
          position: 'relative',
          width: '100%',
          height: isMobile ? '460px' : '580px',
          borderRadius: '24px',
          overflow: 'hidden',
          background: 'radial-gradient(ellipse at 50% 40%, #151e30 0%, #0c121e 55%, #070a12 100%)',
          border: '1px solid rgba(255, 255, 255, 0.08)',
          boxShadow: '0 25px 60px -15px rgba(0, 0, 0, 0.6), inset 0 1px 0 rgba(255, 255, 255, 0.06)',
          cursor: isDragging ? 'grabbing' : 'grab',
          touchAction: 'none',
        }}
        role="region"
        aria-label="Arc 3D Technology Wall"
      >
        {/* Ambient Glow Orbs in Background */}
        <div
          style={{
            position: 'absolute',
            top: '20%',
            left: '25%',
            width: '450px',
            height: '450px',
            background: 'radial-gradient(circle, rgba(234, 179, 8, 0.12) 0%, transparent 65%)',
            filter: 'blur(50px)',
            pointerEvents: 'none',
          }}
        />
        <div
          style={{
            position: 'absolute',
            top: '30%',
            right: '20%',
            width: '400px',
            height: '400px',
            background: 'radial-gradient(circle, rgba(56, 189, 248, 0.14) 0%, transparent 70%)',
            filter: 'blur(55px)',
            pointerEvents: 'none',
          }}
        />

        {/* 3D Perspective Viewport */}
        <div
          ref={wallRef}
          style={{
            position: 'absolute',
            inset: 0,
            perspective: isMobile ? '800px' : '1100px',
            perspectiveOrigin: '50% 50%',
            transformStyle: 'preserve-3d',
            pointerEvents: 'none',
          }}
        >
          {gridTiles.map((tile) => {
            const isMatch = activeCategory === 'All' || tile.tech.category === activeCategory;
            const isHovered = hoveredTech?.id === tile.tech.id;

            return (
              <div
                key={tile.key}
                data-tile-idx={tile.idx}
                data-col={tile.col}
                data-row={tile.row}
                onPointerEnter={() => setHoveredTech(tile.tech)}
                onPointerLeave={() => setHoveredTech(null)}
                style={{
                  position: 'absolute',
                  top: 0,
                  left: 0,
                  width: `${TILE_W}px`,
                  height: `${TILE_H}px`,
                  borderRadius: '16px',
                  background: isMatch ? '#ffffff' : '#94a3b8',
                  boxShadow: isHovered
                    ? '0 20px 40px -6px rgba(56, 189, 248, 0.5), 0 0 24px rgba(56, 189, 248, 0.35)'
                    : isMatch && activeCategory !== 'All'
                    ? '0 12px 28px -4px rgba(56, 189, 248, 0.35), 0 0 14px rgba(56, 189, 248, 0.2), inset 0 1px 0 rgba(255, 255, 255, 0.9)'
                    : '0 10px 25px -4px rgba(0, 0, 0, 0.38), 0 2px 6px rgba(0, 0, 0, 0.16), inset 0 1px 0 rgba(255, 255, 255, 0.85)',
                  border: isHovered
                    ? '2px solid #38bdf8'
                    : isMatch && activeCategory !== 'All'
                    ? '2px solid #38bdf8'
                    : '1px solid rgba(255, 255, 255, 0.95)',
                  display: 'flex',
                  alignItems: 'center',
                  justifyContent: 'center',
                  willChange: 'transform, opacity',
                  contain: 'layout style',
                  backfaceVisibility: 'hidden',
                  WebkitBackfaceVisibility: 'hidden',
                  pointerEvents: 'auto',
                  cursor: 'pointer',
                  opacity: isMatch ? 1 : 0.18,
                  transition: 'background 0.3s ease, border 0.2s ease, box-shadow 0.2s ease, opacity 0.3s ease',
                }}
              >
                <img
                  src={tile.tech.icon}
                  alt={tile.tech.name}
                  loading="eager"
                  decoding="async"
                  draggable={false}
                  style={{
                    width: isMobile ? '32px' : '40px',
                    height: isMobile ? '32px' : '40px',
                    objectFit: 'contain',
                    pointerEvents: 'none',
                    userSelect: 'none',
                    transition: 'transform 0.2s ease, filter 0.3s ease',
                    transform: isHovered ? 'scale(1.15)' : 'scale(1)',
                    filter: isMatch ? 'none' : 'grayscale(100%) opacity(40%)',
                  }}
                  onError={(e) => {
                    e.target.style.display = 'none';
                    if (!e.target.parentNode.querySelector('span')) {
                      const span = document.createElement('span');
                      span.innerText = tile.tech.name.slice(0, 4);
                      span.style.cssText = 'font-weight: 800; font-size: 11px; color: #111827;';
                      e.target.parentNode.appendChild(span);
                    }
                  }}
                />
              </div>
            );
          })}
        </div>

        {/* Side Vignette Fades for Seamless Depth Falloff */}
        <div
          style={{
            position: 'absolute',
            top: 0,
            left: 0,
            bottom: 0,
            width: isMobile ? '50px' : '150px',
            background: 'linear-gradient(to right, #070a12 0%, rgba(7, 10, 18, 0.85) 50%, transparent 100%)',
            pointerEvents: 'none',
            zIndex: 10,
          }}
        />
        <div
          style={{
            position: 'absolute',
            top: 0,
            right: 0,
            bottom: 0,
            width: isMobile ? '50px' : '150px',
            background: 'linear-gradient(to left, #070a12 0%, rgba(7, 10, 18, 0.85) 50%, transparent 100%)',
            pointerEvents: 'none',
            zIndex: 10,
          }}
        />
        <div
          style={{
            position: 'absolute',
            top: 0,
            left: 0,
            right: 0,
            height: '70px',
            background: 'linear-gradient(to bottom, #070a12 0%, transparent 100%)',
            pointerEvents: 'none',
            zIndex: 10,
          }}
        />
        <div
          style={{
            position: 'absolute',
            bottom: 0,
            left: 0,
            right: 0,
            height: '90px',
            background: 'linear-gradient(to top, #070a12 0%, transparent 100%)',
            pointerEvents: 'none',
            zIndex: 10,
          }}
        />

        {/* Hovered Technology Floating Detail Badge */}
        {hoveredTech && (
          <div
            style={{
              position: 'absolute',
              top: '24px',
              left: '50%',
              transform: 'translateX(-50%)',
              background: 'rgba(15, 23, 42, 0.94)',
              border: '1px solid rgba(56, 189, 248, 0.6)',
              boxShadow: '0 14px 36px rgba(0, 0, 0, 0.7), 0 0 28px rgba(56, 189, 248, 0.3)',
              backdropFilter: 'blur(16px)',
              padding: '10px 22px',
              borderRadius: '999px',
              display: 'flex',
              alignItems: 'center',
              gap: '14px',
              zIndex: 40,
              pointerEvents: 'none',
              animation: 'arcTooltipPop 0.2s cubic-bezier(0.16, 1, 0.3, 1)',
            }}
          >
            <div
              style={{
                width: '32px',
                height: '32px',
                borderRadius: '8px',
                background: '#ffffff',
                display: 'flex',
                alignItems: 'center',
                justifyContent: 'center',
                padding: '5px',
                boxShadow: '0 2px 8px rgba(0,0,0,0.25)',
              }}
            >
              <img src={hoveredTech.icon} alt={hoveredTech.name} style={{ width: '100%', height: '100%', objectFit: 'contain' }} />
            </div>
            <div>
              <div style={{ display: 'flex', alignItems: 'center', gap: '8px' }}>
                <span style={{ fontSize: '15px', fontWeight: 700, color: '#f8fafc' }}>{hoveredTech.name}</span>
                <span
                  style={{
                    fontSize: '11px',
                    fontWeight: 700,
                    color: '#38bdf8',
                    background: 'rgba(56, 189, 248, 0.16)',
                    padding: '1px 8px',
                    borderRadius: '12px',
                    textTransform: 'uppercase',
                    letterSpacing: '0.04em',
                  }}
                >
                  {hoveredTech.category}
                </span>
              </div>
              <p style={{ margin: 0, fontSize: '12px', color: '#94a3b8', lineHeight: 1.3 }}>{hoveredTech.desc}</p>
            </div>
          </div>
        )}

        {/* Bottom Interactive Control Bar */}
        <div
          style={{
            position: 'absolute',
            bottom: '18px',
            left: '24px',
            right: '24px',
            display: 'flex',
            alignItems: 'center',
            justifyContent: 'space-between',
            zIndex: 30,
            pointerEvents: 'none',
          }}
        >
          {/* Hint Badge */}
          <div
            style={{
              display: 'inline-flex',
              alignItems: 'center',
              gap: '8px',
              background: 'rgba(15, 23, 42, 0.85)',
              border: '1px solid rgba(255, 255, 255, 0.12)',
              padding: '6px 16px',
              borderRadius: '999px',
              backdropFilter: 'blur(10px)',
              color: '#94a3b8',
              fontSize: isMobile ? '11px' : '12px',
              fontWeight: 500,
            }}
          >
            <span style={{ color: '#38bdf8' }}>✦</span>
            <span>{isMobile ? 'Swipe to rotate 3D Wall' : 'Drag or swipe to rotate 3D Tech Wall'}</span>
          </div>

          {/* Toggle Auto Drift */}
          <button
            type="button"
            onClick={(e) => {
              e.stopPropagation();
              setIsAutoDrift((prev) => !prev);
            }}
            style={{
              display: 'inline-flex',
              alignItems: 'center',
              gap: '6px',
              background: isAutoDrift ? 'rgba(56, 189, 248, 0.18)' : 'rgba(255, 255, 255, 0.08)',
              border: isAutoDrift ? '1px solid rgba(56, 189, 248, 0.4)' : '1px solid rgba(255, 255, 255, 0.1)',
              color: isAutoDrift ? '#38bdf8' : '#94a3b8',
              padding: '6px 14px',
              borderRadius: '999px',
              fontSize: '12px',
              fontWeight: 600,
              cursor: 'pointer',
              pointerEvents: 'auto',
              backdropFilter: 'blur(10px)',
              transition: 'all 0.2s ease',
            }}
          >
            <span
              style={{
                width: '7px',
                height: '7px',
                borderRadius: '50%',
                background: isAutoDrift ? '#38bdf8' : '#64748b',
                boxShadow: isAutoDrift ? '0 0 8px #38bdf8' : 'none',
              }}
            />
            <span>{isAutoDrift ? 'Auto-drift ON' : 'Auto-drift PAUSED'}</span>
          </button>
        </div>
      </div>

      <style>{`
        @keyframes arcTooltipPop {
          0% { opacity: 0; transform: translate(-50%, -6px) scale(0.96); }
          100% { opacity: 1; transform: translate(-50%, 0) scale(1); }
        }
      `}</style>
    </div>
  );
}
