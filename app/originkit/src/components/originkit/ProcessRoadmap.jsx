import React, { useEffect, useMemo, useRef, useState } from 'react';
import { Compass, FileText, Layers, Users, Rocket } from 'lucide-react';

/**
 * ProcessRoadmap — Exact Winding SVG Roadmap from Mobile App Development
 *
 * Drives sideways tracking and 3D popping stop cards as the user scrolls.
 * Adapted for the 5 On-Demand engagement steps.
 */

const DEFAULT_STAGES = [
  {
    num: '01',
    at: 0.080,
    side: 'top',
    icon: Compass,
    title: 'Define the Spec',
    tagline: 'Need analysis & role definition',
    desc: 'You send the brief, the repo or a 20-minute voice memo. We reply with the shape of the squad, seniorities and a clean fixed or monthly model.',
    duration: 'Inside 2 Hours',
    out: 'Squad recommendation & spec',
    image: '/assets/img/ondemand/step/01.jpg',
  },
  {
    num: '02',
    at: 0.280,
    side: 'bottom',
    icon: FileText,
    title: 'Commercials & Commitment',
    tagline: 'Transparent rates & deliverables',
    desc: 'Roles, rates, start dates and the scope as we understand it, in writing, before anyone is committed.',
    duration: '24 Hours',
    out: 'Transparent rate card',
    image: '/assets/img/ondemand/step/02.jpg',
  },
  {
    num: '03',
    at: 0.480,
    side: 'top',
    icon: Layers,
    title: 'Pick the Engagement Model',
    tagline: 'Fixed, monthly or hybrid',
    desc: 'Fixed cost, monthly per engineer, or a hybrid of the two. The engineers do not change; only who carries the risk.',
    duration: '1 Day',
    out: 'Agreed engagement structure',
    image: '/assets/img/ondemand/step/03.jpg',
  },
  {
    num: '04',
    at: 0.680,
    side: 'bottom',
    icon: Users,
    title: 'Meet Your Named Engineers',
    tagline: 'Direct code & architecture interviews',
    desc: 'Named individuals, not an anonymous pool. Interview them if you want to — most clients approve after the second technical conversation.',
    duration: '2–3 Days',
    out: 'Named engineer confirmation',
    image: '/assets/img/ondemand/step/04.jpg',
  },
  {
    num: '05',
    at: 0.880,
    side: 'top',
    icon: Rocket,
    title: 'Day 1 Sprint Integration',
    tagline: 'Live in your repository & standups',
    desc: 'Into your standup, your board and your repository. Commits ship from Day 1. Billing begins the day they do, not before.',
    duration: 'Day 1',
    out: 'Active commits & sprint delivery',
    image: '/assets/img/ondemand/step/05.jpg',
  },
];

const ROAD_W = 3400;
const ROAD_H = 620;
const ROAD_D = `M 0 430
  C 260 430, 360 300, 620 300
  S 980 470, 1240 470
  S 1600 190, 1860 190
  S 2220 400, 2480 400
  S 2840 240, 3100 240
  S 3320 330, ${ROAD_W} 330`;

export default function ProcessRoadmap(props) {
  const stages = props.stages || DEFAULT_STAGES;
  const sectionRef = useRef(null);
  const pathRef = useRef(null);
  const sceneRef = useRef(null);

  const [len, setLen] = useState(0);
  const [progress, setProgress] = useState(0);

  const reduce = useMemo(
    () => typeof window !== 'undefined' && window.matchMedia('(prefers-reduced-motion: reduce)').matches,
    []
  );

  useEffect(() => {
    if (pathRef.current) setLen(pathRef.current.getTotalLength());
  }, []);

  useEffect(() => {
    if (reduce) {
      setProgress(1);
      return;
    }

    let raf = 0;
    let onScreen = true;

    const frame = () => {
      raf = requestAnimationFrame(frame);
      if (!onScreen) return;

      const el = sectionRef.current;
      if (!el) return;

      const r = el.getBoundingClientRect();
      const range = r.height - window.innerHeight;
      const next = range <= 0 ? 0 : Math.min(1, Math.max(0, -r.top / range));

      setProgress((prev) => (Math.abs(prev - next) > 0.0004 ? next : prev));
    };

    const io = 'IntersectionObserver' in window
      ? new IntersectionObserver(([e]) => { onScreen = e.isIntersecting; }, { threshold: 0 })
      : null;
    if (io && sectionRef.current) io.observe(sectionRef.current);

    raf = requestAnimationFrame(frame);

    return () => {
      cancelAnimationFrame(raf);
      if (io) io.disconnect();
    };
  }, [reduce]);

  const points = useMemo(() => {
    const path = pathRef.current;
    if (!path || !len) return [];

    return stages.map((s) => {
      const p = path.getPointAtLength(s.at * len);
      return { x: p.x, y: p.y };
    });
  }, [len, stages]);

  const traveller = useMemo(() => {
    const path = pathRef.current;
    if (!path || !len) return null;

    return path.getPointAtLength(Math.max(0.004, progress) * len);
  }, [len, progress]);

  // Translate entire road scene sideways under the traveller
  const shift = traveller ? Math.min(0, Math.max(-(ROAD_W - 1100), 520 - traveller.x)) : 0;

  return (
    <section ref={sectionRef} id="process" className="roadmap" style={{ height: '420vh' }}>
      <div className="roadmap-sticky">
        <div className="roadmap-head">
          <p
            style={{
              display: 'inline-flex',
              alignItems: 'center',
              gap: '8px',
              fontSize: '13px',
              fontWeight: 700,
              color: '#00F2FE',
              letterSpacing: '0.08em',
              textTransform: 'uppercase',
              marginBottom: '10px',
            }}
          >
            <span style={{ width: '8px', height: '8px', borderRadius: '50%', background: '#00F2FE', boxShadow: '0 0 10px #00F2FE' }} />
            Engagement Roadmap
          </p>
          <h2 style={{ fontSize: 'clamp(2rem, 3.8vw, 3rem)', fontWeight: 900, color: '#F8FAFC', letterSpacing: '-0.02em', margin: 0 }}>
            Hiring from us is <span style={{ color: '#00E5FF' }}>five steps</span>
          </h2>
          <p className="roadmap-progress">
            <span style={{ width: `${Math.round(progress * 100)}%` }} />
          </p>
        </div>

        <div
          ref={sceneRef}
          className="roadmap-scene"
          style={{ transform: `translate3d(${shift}px,0,0)` }}
        >
          <svg
            className="roadmap-svg"
            width={ROAD_W}
            height={ROAD_H}
            viewBox={`0 0 ${ROAD_W} ${ROAD_H}`}
            aria-hidden="true"
          >
            <defs>
              <linearGradient id="tarmac-od" x1="0" y1="0" x2="1" y2="0">
                <stop offset="0" stopColor="#00E5FF" />
                <stop offset="0.3" stopColor="#38BDF8" />
                <stop offset="0.6" stopColor="#6366F1" />
                <stop offset="1" stopColor="#A855F7" />
              </linearGradient>
              <filter id="roadGlow-od" x="-20%" y="-60%" width="140%" height="220%">
                <feGaussianBlur stdDeviation="14" result="b" />
                <feMerge>
                  <feMergeNode in="b" />
                  <feMergeNode in="SourceGraphic" />
                </feMerge>
              </filter>
            </defs>

            {/* Base road */}
            <path d={ROAD_D} className="road-base" />

            {/* Drawn glowing road */}
            <path
              ref={pathRef}
              d={ROAD_D}
              className="road-live"
              stroke="url(#tarmac-od)"
              filter="url(#roadGlow-od)"
              style={len ? { strokeDasharray: len, strokeDashoffset: len * (1 - progress) } : undefined}
            />

            {/* Centre dashes */}
            <path
              d={ROAD_D}
              className="road-dashes"
              style={len ? { strokeDasharray: '26 30', strokeDashoffset: -progress * len * 0.6 } : undefined}
            />

            {/* Stems to stop cards */}
            {points.map((p, i) => {
              const s = stages[i];
              const live = progress >= s.at - 0.02;
              const end = s.side === 'top' ? p.y - 96 : p.y + 96;

              return (
                <line
                  key={s.num}
                  x1={p.x}
                  y1={p.y}
                  x2={p.x}
                  y2={live ? end : p.y}
                  className={`road-stem${live ? ' is-live' : ''}`}
                />
              );
            })}
          </svg>

          {/* Traveller Orb */}
          {traveller && (
            <span
              className="roadmap-traveller"
              style={{ transform: `translate3d(${traveller.x}px, ${traveller.y}px, 0) translate(-50%, -50%)` }}
            >
              <span className="roadmap-traveller-core" />
            </span>
          )}

          {/* Stop Cards */}
          {points.map((p, i) => {
            const s = stages[i];
            const Icon = s.icon || Compass;
            const live = progress >= s.at - 0.02;
            const passed = progress > s.at + 0.10;

            return (
              <article
                key={s.num}
                className={`roadmap-stop roadmap-stop--${s.side}${live ? ' is-live' : ''}${passed ? ' is-passed' : ''}`}
                style={{ left: p.x, top: s.side === 'top' ? p.y - 104 : p.y + 104 }}
              >
                <header>
                  <span className="roadmap-num">{s.num}</span>
                  <span className="roadmap-icon"><Icon className="w-4 h-4" /></span>
                </header>

                {s.image && (
                  <div style={{
                    width: '100%',
                    height: '84px',
                    borderRadius: '10px',
                    overflow: 'hidden',
                    margin: '8px 0 10px',
                    background: '#040714',
                    border: '1px solid rgba(255, 255, 255, 0.1)',
                  }}>
                    <img
                      src={s.image}
                      alt={s.title}
                      style={{ width: '100%', height: '100%', objectFit: 'cover' }}
                      loading="lazy"
                    />
                  </div>
                )}

                <h3>{s.title}</h3>
                <p className="roadmap-tagline">{s.tagline}</p>
                <p className="roadmap-desc">{s.desc}</p>

                <footer>
                  <span className="roadmap-duration">{s.duration}</span>
                  <span className="roadmap-out">{s.out}</span>
                </footer>
              </article>
            );
          })}
        </div>

        <p className="roadmap-hint" aria-hidden="true">Keep scrolling — the road builds ahead of you</p>
      </div>

      {/* Screen Reader List */}
      <ul className="sr-only">
        {stages.map((s) => (
          <li key={s.num}>
            {s.num}. {s.title} — {s.tagline}. {s.desc} Duration: {s.duration}. Deliverable: {s.out}.
          </li>
        ))}
      </ul>
    </section>
  );
}
