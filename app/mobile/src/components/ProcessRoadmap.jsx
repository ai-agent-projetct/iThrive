import React, { useEffect, useMemo, useRef, useState } from 'react';
import {
  Compass, Palette, Code2, ShieldCheck, Rocket, Layers, RefreshCw, Sparkles,
} from 'lucide-react';
import MouseOverText from './MouseOverText';

/**
 * The roadmap — a road that draws itself as you scroll.
 *
 * The carousel it replaces asked the visitor to operate a control. This asks
 * nothing: scrolling the page drives everything, which is the one gesture
 * people already make.
 *
 * What makes it worth the code rather than being eight boxes in a row:
 *
 *  - The road is a real SVG path and every stop is positioned by asking that
 *    path where it is — `getPointAtLength` at the stop's own fraction. Nothing
 *    is placed by hand, so the curve can be redrawn or a stage inserted and the
 *    markers, stems and cards all follow it automatically.
 *  - The tarmac is drawn on with `strokeDashoffset`, so the road is genuinely
 *    built ahead of the traveller rather than revealed from behind a mask.
 *  - The scene tracks sideways as you scroll down, so vertical scroll becomes
 *    travel along the road.
 *  - Each stop pops in 3D on arrival — it rises off the page, rotates level and
 *    its stem grows down to the tarmac — and settles back as you pass it, so
 *    the section always has one thing worth reading.
 *
 * Reduced motion gets the same content as a plain, complete list.
 */

const STAGES = [
  { num: '01', at: 0.040, side: 'top', icon: Compass,
    title: 'Discovery & Architecture Blueprint', tagline: 'Technical scope & stack selection',
    desc: 'We sit with the people doing the work today, map the workflow, and agree the one number that decides whether this build succeeded.',
    duration: '1 week', out: 'Signed scope & architecture' },
  { num: '02', at: 0.163, side: 'bottom', icon: Palette,
    title: 'UI/UX Design & Prototyping', tagline: 'Clickable before it is coded',
    desc: 'Wireframes to a clickable prototype you can put in front of a real user, so the arguments happen on a screen and not in a sprint.',
    duration: '2 weeks', out: 'Interactive prototype' },
  { num: '03', at: 0.286, side: 'top', icon: Code2,
    title: 'Agile Development Sprints', tagline: 'A build every Friday',
    desc: 'Two-week sprints against real data, with an installable build at the end of each one. Slippage shows up in week two, not month four.',
    duration: '4–8 weeks', out: 'Test builds, fortnightly' },
  { num: '04', at: 0.409, side: 'bottom', icon: ShieldCheck,
    title: 'Security & QA Audit', tagline: 'Penetration testing & device matrix',
    desc: 'Automated suites, a real device matrix and a penetration pass, because the first security review should not be the App Store review.',
    duration: '1 week', out: 'Release candidate' },
  { num: '05', at: 0.531, side: 'top', icon: Rocket,
    title: 'Store Launch', tagline: 'App Store & Play Console',
    desc: 'Signing, metadata, screenshots, privacy disclosures and the review cycles — handled by people who have shipped through them before.',
    duration: '1–2 weeks', out: 'Live on both stores' },
  { num: '06', at: 0.654, side: 'bottom', icon: Layers,
    title: 'Source Code & IP Handover', tagline: 'Everything, in your name',
    desc: 'Repositories, cloud accounts, store listings and signing keys transfer to you, with notes good enough for another team to take over.',
    duration: '2 days', out: '100% IP transfer' },
  { num: '07', at: 0.777, side: 'top', icon: RefreshCw,
    title: 'Analytics & Iteration', tagline: 'Crash vitals & funnels',
    desc: 'Sentry, Crashlytics and store vitals wired to a triage process, and a release train that ships against what the data actually shows.',
    duration: 'Ongoing', out: 'Monthly vitals report' },
  { num: '08', at: 0.900, side: 'bottom', icon: Sparkles,
    title: 'Scale & AI Enablement', tagline: 'Growth features that compound',
    desc: 'Once the core is stable we add what compounds — recommendations, assistants, on-device intelligence — each behind a number it must move.',
    duration: 'Quarterly', out: 'Product roadmap' },
];

/** The road. A long, gentle S so the stops alternate naturally above and below. */
const ROAD_W = 3400;
const ROAD_H = 620;
const ROAD_D = `M 0 430
  C 260 430, 360 300, 620 300
  S 980 470, 1240 470
  S 1600 190, 1860 190
  S 2220 400, 2480 400
  S 2840 240, 3100 240
  S 3320 330, ${ROAD_W} 330`;

export default function ProcessRoadmap() {
  const sectionRef = useRef(null);
  const pathRef = useRef(null);
  const sceneRef = useRef(null);

  const [len, setLen] = useState(0);
  const [progress, setProgress] = useState(0);

  const reduce = useMemo(
    () => typeof window !== 'undefined' && window.matchMedia('(prefers-reduced-motion: reduce)').matches,
    []
  );

  // The path can only be measured once it is in the document.
  useEffect(() => {
    if (pathRef.current) setLen(pathRef.current.getTotalLength());
  }, []);

  /* ---- scroll drives everything ---------------------------------------- */

  useEffect(() => {
    if (reduce) { setProgress(1); return; }

    /**
     * Sample the section's position every frame while it is on screen.
     *
     * Two earlier versions failed here, both the same way. An eased follower
     * running in its own loop drifted behind the scrollbar and stalled, which
     * stranded the last stops so they could never light up. Reading only on
     * the scroll event was worse: the final event's frame samples a rect the
     * browser has not finished settling, and since no further events fire,
     * nothing is left to correct it — the road stopped short of the end.
     *
     * Sampling per frame cannot go stale. It costs one getBoundingClientRect
     * a frame, and only while the section is actually in view. The glide comes
     * from CSS transitions on the road and the traveller, where it cannot
     * desynchronise from the scrollbar.
     */
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

      // Only re-render when it has actually moved.
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

  /* ---- ask the road where each stop is --------------------------------- */

  const points = useMemo(() => {
    const path = pathRef.current;
    if (!path || !len) return [];

    return STAGES.map((s) => {
      const p = path.getPointAtLength(s.at * len);

      return { x: p.x, y: p.y };
    });
  }, [len]);

  const traveller = useMemo(() => {
    const path = pathRef.current;
    if (!path || !len) return null;

    return path.getPointAtLength(Math.max(0.004, progress) * len);
  }, [len, progress]);

  // Vertical scroll becomes sideways travel: keep the traveller near the middle
  // of the viewport and slide the whole scene under it.
  const shift = traveller ? Math.min(0, Math.max(-(ROAD_W - 1100), 520 - traveller.x)) : 0;

  return (
    <section ref={sectionRef} id="process" className="roadmap">
      <div className="roadmap-sticky">

        <div className="roadmap-head">
          <h2 className="text-3xl sm:text-4xl md:text-5xl font-black font-heading tracking-tight text-slate-100">
            Our <MouseOverText text="Process Flow" variant="glow" className="text-cyan-400" />
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
              <linearGradient id="tarmac" x1="0" y1="0" x2="1" y2="0">
                <stop offset="0" stopColor="#00E5FF" />
                <stop offset="0.5" stopColor="#3B82F6" />
                <stop offset="1" stopColor="#A855F7" />
              </linearGradient>
              <filter id="roadGlow" x="-20%" y="-60%" width="140%" height="220%">
                <feGaussianBlur stdDeviation="14" result="b" />
                <feMerge><feMergeNode in="b" /><feMergeNode in="SourceGraphic" /></feMerge>
              </filter>
            </defs>

            {/* The unbuilt road ahead. */}
            <path d={ROAD_D} className="road-base" />

            {/* The built road, drawn on as the traveller advances. */}
            <path
              ref={pathRef}
              d={ROAD_D}
              className="road-live"
              filter="url(#roadGlow)"
              style={len ? { strokeDasharray: len, strokeDashoffset: len * (1 - progress) } : undefined}
            />

            {/* Centre line, drawn with the road. */}
            <path
              d={ROAD_D}
              className="road-dashes"
              style={len ? { strokeDasharray: '26 30', strokeDashoffset: -progress * len * 0.6 } : undefined}
            />

            {/* Stems from the tarmac up or down to each card. */}
            {points.map((p, i) => {
              const s = STAGES[i];
              const live = progress >= s.at - 0.02;
              const end = s.side === 'top' ? p.y - 96 : p.y + 96;

              return (
                <line
                  key={s.num}
                  x1={p.x} y1={p.y}
                  x2={p.x} y2={live ? end : p.y}
                  className={`road-stem${live ? ' is-live' : ''}`}
                />
              );
            })}
          </svg>

          {/* The traveller. */}
          {traveller && (
            <span
              className="roadmap-traveller"
              style={{ transform: `translate3d(${traveller.x}px, ${traveller.y}px, 0) translate(-50%, -50%)` }}
            >
              <span className="roadmap-traveller-core" />
            </span>
          )}

          {/* The stops. */}
          {points.map((p, i) => {
            const s = STAGES[i];
            const Icon = s.icon;
            const live = progress >= s.at - 0.02;
            // Passed stops stay visible but recede, so the eye keeps the newest.
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

      {/* The same eight stages, readable without any of the above. */}
      <ul className="sr-only">
        {STAGES.map((s) => (
          <li key={s.num}>{s.num}. {s.title} — {s.tagline}. {s.desc} Duration: {s.duration}. Deliverable: {s.out}.</li>
        ))}
      </ul>
    </section>
  );
}
