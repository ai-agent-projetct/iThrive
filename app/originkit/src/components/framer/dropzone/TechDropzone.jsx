import React, { useEffect, useRef, useState } from 'react';
import Matter from 'matter-js';

const TECH_LOGOS = [
  {
    name: 'React',
    color: '#61DAFB',
    svg: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="-11.5 -10.23 23 20.46"><circle cx="0" cy="0" r="2.05" fill="#61dafb"/><g stroke="#61dafb" stroke-width="1" fill="none"><ellipse rx="11" ry="4.2"/><ellipse rx="11" ry="4.2" transform="rotate(60)"/><ellipse rx="11" ry="4.2" transform="rotate(120)"/></g></svg>`,
  },
  {
    name: 'TypeScript',
    color: '#3178C6',
    svg: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 128 128"><rect width="128" height="128" rx="24" fill="#3178C6"/><path fill="#fff" d="M38 52h52v12H68v50H50V64H38zm45 32c5-3 10-4 15-4 5 0 9 2 9 6 0 3-3 6-9 8l-6 2c-10 4-15 9-15 19 0 13 10 20 25 20 7 0 14-2 19-5l-4-11c-5 3-10 5-15 5-5 0-9-2-9-6 0-3 3-5 8-7l6-2c11-4 16-10 16-19 0-12-9-19-24-19-7 0-14 1-19 4z"/></svg>`,
  },
  {
    name: 'Next.js',
    color: '#FFFFFF',
    svg: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 128 128"><circle cx="64" cy="64" r="62" fill="#000" stroke="#fff" stroke-width="4"/><path fill="#fff" d="M102 108 46 36h-8v56h8V48l51 66a64 64 0 0 0 5-6z"/><path fill="#fff" d="M82 36h8v32h-8z"/></svg>`,
  },
  {
    name: 'Node.js',
    color: '#539E43',
    svg: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 128 128"><path fill="#539E43" d="m64 8 50 29v58L64 124 14 95V37zm0 20c-18 0-24 9-24 19 0 18 24 14 24 23 0 3-2 5-8 5-7 0-13-3-18-7v13c5 4 12 6 18 6 18 0 25-9 25-20 0-18-24-14-24-23 0-3 3-5 7-5 6 0 11 2 16 6V33c-5-3-11-5-16-5z"/></svg>`,
  },
  {
    name: 'Python',
    color: '#FFD43B',
    svg: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 128 128"><path fill="#3776AB" d="M63 9c-27 0-25 12-25 12l.03 12.5h25.47v3.6H28S9 35 9 63.5s16.5 27.5 16.5 27.5h9.8v-13.8s-.5-16.5 16.2-16.5h25.4V34.5s2.5-25.5-13.9-25.5zm-14.2 8.3a4.1 4.1 0 1 1 0 8.3 4.1 4.1 0 0 1 0-8.3z"/><path fill="#FFD43B" d="M65 119c27 0 25-12 25-12l-.03-12.5H64.5v-3.6H100s19 2.1 19-26.4-16.5-27.5-16.5-27.5h-9.8v13.8s.5 16.5-16.2 16.5H51.1v26.7s-2.5 25.5 13.9 25.5zm14.2-8.3a4.1 4.1 0 1 1 0-8.3 4.1 4.1 0 0 1 0 8.3z"/></svg>`,
  },
  {
    name: 'Docker',
    color: '#2496ED',
    svg: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 128 128"><path fill="#2496ED" d="M123 60c-3 0-11 2-15 7-1-6-5-10-10-12-1 0-3 2-3 2s-3-7-12-8c-2 0-8 1-13 6H4v20c0 23 18 38 47 38 34 0 58-18 64-46 4 0 9-4 8-7zm-70-6h13v12H53zm-16 0h13v12H37zm-16 0h13v12H21zm16-15h13v12H37zm16 0h13v12H53zm16 0h13v12H69zm16 15h13v12H85zm0-15h13v12H85zm-16-15h13v12H69z"/></svg>`,
  },
  {
    name: 'Kubernetes',
    color: '#326CE5',
    svg: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 128 128"><path fill="#326CE5" d="m64 12 45 26v52L64 116 19 90V38zm0 18a34 34 0 1 0 0 68 34 34 0 0 0 0-68zm0 12 16 27H48zm-19 6 12 7-6 11zm38 0 6 11-12 7zm-15 15h12v14h-12z"/></svg>`,
  },
  {
    name: 'AWS',
    color: '#FF9900',
    svg: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 128 128"><path fill="#FF9900" d="M37 77c-7 5-14 8-22 8-11 0-14-8-7-15 5-5 18-7 29-7zm0-24c-19 0-33 7-36 21-2 12 4 23 18 23 10 0 19-5 25-12v10h12V33H37zm32 40c4 3 10 5 16 5 9 0 14-4 14-11 0-6-4-9-13-12-14-4-21-9-21-20 0-11 9-19 23-19 8 0 14 2 18 5l-4 10c-3-2-8-4-14-4-7 0-11 3-11 8 0 5 4 8 13 11 15 5 21 11 21 21s-9 21-26 21c-8 0-17-3-22-6zm-47 22c27 15 62 14 87-2l3 5c-27 18-66 19-95 3z"/></svg>`,
  },
  {
    name: 'PostgreSQL',
    color: '#4169E1',
    svg: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 128 128"><path fill="#4169E1" d="M64 10c-26 0-40 20-40 46 0 19 8 32 17 40-2 6-6 13-13 18 11 1 23-4 29-12 4 1 8 2 13 2 30 0 46-24 46-52 0-26-17-42-52-42zm-8 22c7 0 12 5 12 12s-5 12-12 12-12-5-12-12 5-12 12-12zm24 48c-7 6-17 10-28 10-4 0-8-1-11-2 4-5 7-11 8-18 8 3 17 4 26 4 2 0 4 0 5 6z"/></svg>`,
  },
  {
    name: 'GraphQL',
    color: '#E10098',
    svg: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 128 128"><path fill="#E10098" d="M64 12a8 8 0 1 0 0 16 8 8 0 0 0 0-16zm-45 26a8 8 0 1 0 8 14 8 8 0 0 0-8-14zm90 0a8 8 0 1 0-8 14 8 8 0 0 0 8-14zm-76 52a8 8 0 1 0 14 8 8 8 0 0 0-14-8zm62 0a8 8 0 1 0-14 8 8 8 0 0 0 14-8zM64 26 24 49l11 44 29 23 29-23 11-44zm0 15 30 52H34zm-22 3 44 26H20zm44 0L42 70h44zM64 104 42 74h44z"/></svg>`,
  },
  {
    name: 'FastAPI',
    color: '#059669',
    svg: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 128 128"><circle cx="64" cy="64" r="56" fill="#059669"/><path fill="#fff" d="M69 22 36 70h26l-7 36 37-48H66z"/></svg>`,
  },
  {
    name: 'Swift',
    color: '#F05138',
    svg: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 128 128"><path fill="#F05138" d="M116 83c-9 16-24 29-41 35 24-11 39-30 41-45-7 5-15 8-24 9 12-8 21-20 25-34-11 7-23 11-35 12 18-18 24-40 18-50-2 2-33 34-47 52C42 47 37 32 37 16c-3 10-6 24 1 39-16-9-27-24-29-26 1 4 10 24 24 35-12-1-24-6-29-10 4 8 14 18 24 22-13 2-25-1-28-3 5 9 17 17 31 18-12 5-26 5-32 3 13 14 36 21 57 17 32-6 53-24 61-28z"/></svg>`,
  },
  {
    name: 'Go',
    color: '#00ADD8',
    svg: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 128 128"><path fill="#00ADD8" d="M38 48c-12 0-21 9-21 21s9 21 21 21c10 0 18-7 20-16H38v-9h31c0 19-14 34-31 34-19 0-33-14-33-30s14-30 33-30c9 0 17 3 23 9l-7 7c-4-4-10-7-16-7zm58 0c-18 0-32 14-32 30s14 30 32 30 32-14 32-30-14-30-32-30zm0 11c11 0 20 9 20 19s-9 19-20 19-20-9-20-19 9-19 20-19z"/></svg>`,
  },
  {
    name: 'Redis',
    color: '#DC382D',
    svg: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 128 128"><path fill="#DC382D" d="M64 12 12 36l52 24 52-24zm0 28L28 47l36 17 36-17zM12 48v24l52 24V72zm104 0L64 72v24l52-24zM12 84v24l52 24v-24zm104 0-52 24v24l52-24z"/></svg>`,
  },
  {
    name: 'Kafka',
    color: '#FFFFFF',
    svg: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 128 128"><circle cx="34" cy="64" r="14" fill="#fff"/><circle cx="94" cy="34" r="14" fill="#fff"/><circle cx="94" cy="94" r="14" fill="#fff"/><path stroke="#fff" stroke-width="8" d="m44 58 40-18m-40 24 40 18"/></svg>`,
  },
  {
    name: 'PyTorch',
    color: '#EE4C2C',
    svg: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 128 128"><path fill="#EE4C2C" d="M78 20a6 6 0 1 0 0 12 6 6 0 0 0 0-12zM64 24c-22 0-40 18-40 40 0 16 10 30 24 36v-14c-7-4-12-12-12-22 0-13 11-24 24-24 7 0 13 3 17 8l10-10c-7-9-17-14-27-14zm14 26-10 10c4 4 6 9 6 15 0 12-10 21-22 22v14c20-1 36-17 36-37 0-9-4-17-10-24z"/></svg>`,
  },
  {
    name: 'LangChain',
    color: '#22C55E',
    svg: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 128 128"><rect width="128" height="128" rx="28" fill="#1C3C3C"/><path fill="#22C55E" d="M42 40a16 16 0 0 0-16 16v16a16 16 0 0 0 32 0V56a16 16 0 0 0-16-16zm44 16a16 16 0 0 0-16 16v16a16 16 0 0 0 32 0V72a16 16 0 0 0-16-16z"/><path fill="#E2E8F0" d="M50 64h28v8H50z"/></svg>`,
  },
  {
    name: 'Flutter',
    color: '#60A5FA',
    svg: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 128 128"><path fill="#02569B" d="M80 12 36 56l15 15L95 27zm0 50-32 32 16 16 48-48zm-1 30-15 15 15 15h28L92 107z"/></svg>`,
  },
];

export default function TechDropzone(props) {
  const { height = 540, gravity = 1.1, restitution = 0.62, friction = 0.15 } = props;

  const containerRef = useRef(null);
  const canvasRef = useRef(null);
  const engineRef = useRef(null);
  const runnerRef = useRef(null);
  const pillsRef = useRef([]);
  const boundariesRef = useRef([]);
  const dragRef = useRef({ body: null, points: [] });
  const [pillCount, setPillCount] = useState(0);
  const logoImageCache = useRef(new Map());

  // Preload SVG logo images into image cache
  useEffect(() => {
    TECH_LOGOS.forEach((tech) => {
      if (!logoImageCache.current.has(tech.name)) {
        const img = new Image();
        img.src = `data:image/svg+xml;utf8,${encodeURIComponent(tech.svg)}`;
        logoImageCache.current.set(tech.name, img);
      }
    });
  }, []);

  useEffect(() => {
    const container = containerRef.current;
    const canvas = canvasRef.current;
    if (!container || !canvas) return;

    const ctx = canvas.getContext('2d');
    if (!ctx) return;

    const { Engine, Runner, Bodies, Composite, Body, Query } = Matter;

    let isDisposed = false;
    let rafId = 0;

    const engine = Engine.create({
      enableSleeping: false,
      positionIterations: 10,
      velocityIterations: 8,
    });
    engine.gravity.y = gravity;
    engineRef.current = engine;

    const runner = Runner.create();
    runnerRef.current = runner;

    const setSize = () => {
      const rect = container.getBoundingClientRect();
      const dpr = Math.min(2, window.devicePixelRatio || 1);
      const w = Math.max(300, rect.width);
      const h = height;

      canvas.width = Math.floor(w * dpr);
      canvas.height = Math.floor(h * dpr);
      canvas.style.width = `${w}px`;
      canvas.style.height = `${h}px`;

      ctx.setTransform(dpr, 0, 0, dpr, 0, 0);

      // Arena Boundaries
      if (boundariesRef.current.length > 0) {
        Composite.remove(engine.world, boundariesRef.current);
      }
      const wallT = 120;
      const floor = Bodies.rectangle(w / 2, h + wallT / 2, w * 2, wallT, {
        isStatic: true,
        restitution: 0.4,
        friction: 0.8,
      });
      const leftWall = Bodies.rectangle(-wallT / 2, h / 2, wallT, h * 3, {
        isStatic: true,
        restitution: 0.5,
        friction: 0.1,
      });
      const rightWall = Bodies.rectangle(w + wallT / 2, h / 2, wallT, h * 3, {
        isStatic: true,
        restitution: 0.5,
        friction: 0.1,
      });

      boundariesRef.current = [floor, leftWall, rightWall];
      Composite.add(engine.world, boundariesRef.current);
    };

    setSize();

    // Spawn pill function (pill shaped rigid body with tech logo)
    const spawnPill = (tech, x, y, vx = 0, vy = 0) => {
      const pw = 84;
      const ph = 50;
      const radius = 25;

      const body = Bodies.rectangle(x, y, pw, ph, {
        chamfer: { radius },
        restitution,
        friction,
        frictionAir: 0.015,
        density: 0.002,
        angle: (Math.random() - 0.5) * 0.5,
      });

      if (vx || vy) {
        Body.setVelocity(body, { x: vx, y: vy });
      }

      Composite.add(engine.world, body);
      const entry = { body, tech, w: pw, h: ph, radius };
      pillsRef.current.push(entry);
      setPillCount(pillsRef.current.length);
      return entry;
    };

    // Initial batch spawn
    const rect = container.getBoundingClientRect();
    const w = Math.max(300, rect.width);
    TECH_LOGOS.forEach((tech, i) => {
      const col = i % 6;
      const row = Math.floor(i / 6);
      const x = 70 + col * ((w - 140) / 5) + (Math.random() - 0.5) * 30;
      const y = 50 + row * 55 + Math.random() * 20;
      spawnPill(tech, x, y, (Math.random() - 0.5) * 2, Math.random() * 2);
    });

    // Pointer Drag & Drop interaction
    let activeDrag = null;

    const onPointerDown = (e) => {
      const cRect = canvas.getBoundingClientRect();
      const px = e.clientX - cRect.left;
      const py = e.clientY - cRect.top;

      const bodies = pillsRef.current.map((p) => p.body);
      const clicked = Query.point(bodies, { x: px, y: py });

      if (clicked.length > 0) {
        const body = clicked[0];
        activeDrag = {
          body,
          prevX: px,
          prevY: py,
          vx: 0,
          vy: 0,
        };
        Body.setStatic(body, false);
      } else {
        // Drop new random tech logo pill
        const randomTech = TECH_LOGOS[Math.floor(Math.random() * TECH_LOGOS.length)];
        spawnPill(randomTech, px, py, (Math.random() - 0.5) * 4, -2);
      }
    };

    const onPointerMove = (e) => {
      if (!activeDrag) return;
      const cRect = canvas.getBoundingClientRect();
      const px = e.clientX - cRect.left;
      const py = e.clientY - cRect.top;

      activeDrag.vx = px - activeDrag.prevX;
      activeDrag.vy = py - activeDrag.prevY;
      activeDrag.prevX = px;
      activeDrag.prevY = py;

      Body.setPosition(activeDrag.body, { x: px, y: py });
      Body.setVelocity(activeDrag.body, { x: 0, y: 0 });
    };

    const onPointerUp = () => {
      if (activeDrag) {
        Body.setVelocity(activeDrag.body, {
          x: Math.max(-16, Math.min(16, activeDrag.vx * 0.85)),
          y: Math.max(-16, Math.min(16, activeDrag.vy * 0.85)),
        });
        activeDrag = null;
      }
    };

    canvas.addEventListener('pointerdown', onPointerDown);
    window.addEventListener('pointermove', onPointerMove);
    window.addEventListener('pointerup', onPointerUp);

    // Canvas Render Loop
    const render = () => {
      if (isDisposed) return;
      const rect = container.getBoundingClientRect();
      const w = Math.max(300, rect.width);
      const h = height;

      // Dark background
      ctx.fillStyle = '#030612';
      ctx.fillRect(0, 0, w, h);

      // Arena ambient grid
      ctx.strokeStyle = 'rgba(255, 255, 255, 0.025)';
      ctx.lineWidth = 1;
      const grid = 36;
      for (let x = 0; x < w; x += grid) {
        ctx.beginPath();
        ctx.moveTo(x, 0);
        ctx.lineTo(x, h);
        ctx.stroke();
      }
      for (let y = 0; y < h; y += grid) {
        ctx.beginPath();
        ctx.moveTo(0, y);
        ctx.lineTo(w, y);
        ctx.stroke();
      }

      // Render Each Pill with Official Tech Logo
      pillsRef.current.forEach((pill) => {
        const { body, tech, w: pw, h: ph, radius } = pill;
        if (body.position.y > height + 60) {
          Body.setPosition(body, { x: Math.max(60, Math.min(w - 60, body.position.x)), y: 40 });
          Body.setVelocity(body, { x: 0, y: 1 });
        }
        if (body.position.x < -60 || body.position.x > w + 60) {
          Body.setPosition(body, { x: w / 2, y: 40 });
        }
        const x = body.position.x;
        const y = body.position.y;
        const angle = body.angle;

        ctx.save();
        ctx.translate(x, y);
        ctx.rotate(angle);

        // Safe rounded pill
        ctx.beginPath();
        const sx = -pw / 2, sy = -ph / 2;
        ctx.moveTo(sx + radius, sy);
        ctx.lineTo(sx + pw - radius, sy);
        ctx.quadraticCurveTo(sx + pw, sy, sx + pw, sy + radius);
        ctx.lineTo(sx + pw, sy + ph - radius);
        ctx.quadraticCurveTo(sx + pw, sy + ph, sx + pw - radius, sy + ph);
        ctx.lineTo(sx + radius, sy + ph);
        ctx.quadraticCurveTo(sx, sy + ph, sx, sy + ph - radius);
        ctx.lineTo(sx, sy + radius);
        ctx.quadraticCurveTo(sx, sy, sx + radius, sy);
        ctx.closePath();

        // Capsule fill
        const fillGrad = ctx.createLinearGradient(-pw / 2, -ph / 2, pw / 2, ph / 2);
        fillGrad.addColorStop(0, 'rgba(12, 20, 38, 0.96)');
        fillGrad.addColorStop(1, 'rgba(6, 11, 24, 0.98)');
        ctx.fillStyle = fillGrad;
        ctx.fill();

        // Border glow
        ctx.lineWidth = 1.5;
        ctx.strokeStyle = `${tech.color}80`;
        ctx.stroke();

        // Ambient glow behind logo
        ctx.save();
        ctx.shadowColor = tech.color;
        ctx.shadowBlur = 12;
        ctx.fillStyle = `${tech.color}20`;
        ctx.beginPath();
        ctx.arc(0, 0, 16, 0, Math.PI * 2);
        ctx.fill();
        ctx.restore();

        // Draw Official Tech Logo
        const img = logoImageCache.current.get(tech.name);
        if (img && img.complete) {
          const iconSize = 28;
          ctx.drawImage(img, -iconSize / 2, -iconSize / 2, iconSize, iconSize);
        } else {
          // Fallback text if image decoding in flight
          ctx.font = '800 12px "Inter", sans-serif';
          ctx.fillStyle = tech.color;
          ctx.textAlign = 'center';
          ctx.textBaseline = 'middle';
          ctx.fillText(tech.name, 0, 0);
        }

        ctx.restore();
      });

      rafId = requestAnimationFrame(render);
    };

    Runner.run(runner, engine);
    rafId = requestAnimationFrame(render);

    const ro = new ResizeObserver(setSize);
    ro.observe(container);

    return () => {
      isDisposed = true;
      cancelAnimationFrame(rafId);
      canvas.removeEventListener('pointerdown', onPointerDown);
      window.removeEventListener('pointermove', onPointerMove);
      window.removeEventListener('pointerup', onPointerUp);
      ro.disconnect();
      Runner.stop(runner);
      Composite.clear(engine.world, false);
      Engine.clear(engine);
    };
  }, [gravity, restitution, friction, height]);

  return (
    <div
      ref={containerRef}
      style={{
        position: 'relative',
        width: '100%',
        height: `${height}px`,
        overflow: 'hidden',
        background: '#030612',
        borderRadius: '24px',
        border: '1px solid rgba(255, 255, 255, 0.08)',
        boxShadow: '0 30px 80px -20px rgba(0, 0, 0, 0.85)',
        touchAction: 'none',
        userSelect: 'none',
      }}
    >
      <canvas
        ref={canvasRef}
        style={{
          display: 'block',
          width: '100%',
          height: '100%',
          cursor: 'pointer',
        }}
      />

      {/* Top Banner */}
      <div
        style={{
          position: 'absolute',
          top: 18,
          left: 22,
          display: 'flex',
          flexDirection: 'column',
          gap: '4px',
          pointerEvents: 'none',
        }}
      >
        <div style={{ display: 'flex', alignItems: 'center', gap: '8px' }}>
          <span
            style={{
              width: '7px',
              height: '7px',
              borderRadius: '50%',
              background: '#00F2FE',
              boxShadow: '0 0 8px #00F2FE',
            }}
          />
          <span
            style={{
              fontSize: '11px',
              fontFamily: 'Fira Code, monospace',
              fontWeight: 800,
              color: '#00F2FE',
              letterSpacing: '0.08em',
              textTransform: 'uppercase',
            }}
          >
            Engineering Tech Stack Dropzone
          </span>
        </div>
        <p
          style={{
            margin: 0,
            fontSize: '12px',
            color: 'rgba(203, 213, 225, 0.65)',
            fontFamily: 'Inter, sans-serif',
          }}
        >
          Click anywhere to drop tech logos · Drag & toss to collide
        </p>
      </div>

      {/* Bottom Counter Pill */}
      <div
        style={{
          position: 'absolute',
          bottom: 18,
          left: '50%',
          transform: 'translateX(-50%)',
          display: 'flex',
          alignItems: 'center',
          gap: '10px',
          padding: '6px 16px',
          borderRadius: '999px',
          background: 'rgba(6, 11, 24, 0.8)',
          backdropFilter: 'blur(12px)',
          border: '1px solid rgba(255, 255, 255, 0.12)',
          color: 'rgba(226, 232, 240, 0.85)',
          fontSize: '12px',
          fontFamily: 'Inter, sans-serif',
          pointerEvents: 'none',
        }}
      >
        <span style={{ color: '#F59E0B' }}>⚡</span>
        <span>Interactive Rigid-Body Arena</span>
        <span
          style={{
            padding: '2px 8px',
            borderRadius: '999px',
            background: 'rgba(0, 242, 254, 0.15)',
            border: '1px solid rgba(0, 242, 254, 0.3)',
            color: '#00F2FE',
            fontSize: '11px',
            fontFamily: 'Fira Code, monospace',
            fontWeight: 700,
          }}
        >
          {pillCount} Logos Active
        </span>
      </div>
    </div>
  );
}
