import React, { useState, useEffect, useRef, useCallback } from 'react';

const COMMITMENTS = [
  {
    id: 1,
    num: '01',
    title: 'Seniors stay on the project',
    tagline: 'Zero pitch-team bait & switch',
    body: 'The engineer who scoped your build writes the first commit. No pitch team, no junior handover, no bench rotation.',
    proof: 'First sprint code review with the exact engineering lead you met during discovery.',
    badge: 'Senior Squad Lead',
    accent: '#00f2fe',
    icon: (
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
        <circle cx="9" cy="7" r="4" />
        <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
      </svg>
    )
  },
  {
    id: 2,
    num: '02',
    title: 'You own everything',
    tagline: 'Day-one IP & infrastructure escrow-free',
    body: 'Repository, cloud accounts, domain DNS and data records are in your name from week one, never held hostage or transferred late.',
    proof: 'Organization invite to your own GitHub & root billing credentials on AWS/GCP.',
    badge: '100% Client IP',
    accent: '#38bdf8',
    icon: (
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
        <polyline points="16 18 22 12 16 6" />
        <polyline points="8 6 2 12 8 18" />
      </svg>
    )
  },
  {
    id: 3,
    num: '03',
    title: 'AI as engineering, not garnish',
    tagline: 'Measurable workflow automation',
    body: 'We deploy AI where it cuts hours and removes error. Where an algorithm adds risk or nondeterministic hallucination, we tell you frankly.',
    proof: 'Benchmarked token latency, verifiable ground-truth retrieval accuracy, and cost tracking.',
    badge: 'Utility-First AI',
    accent: '#a855f7',
    icon: (
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
        <path d="M12 2a4 4 0 0 1 4 4c0 1.1-.5 2.1-1.2 2.8L17 11a5 5 0 0 1-5 5v4" />
        <path d="M12 2a4 4 0 0 0-4 4c0 1.1.5 2.1 1.2 2.8L7 11a5 5 0 0 0 5 5" />
        <circle cx="12" cy="12" r="2" />
      </svg>
    )
  },
  {
    id: 4,
    num: '04',
    title: 'Fortnightly working software',
    tagline: 'Live deploy every 14 days',
    body: 'Every two weeks there is a staging URL you can open on your phone. Real software beats status decks every single time.',
    proof: 'Staging environment demo URL updated fortnightly with passing end-to-end tests.',
    badge: 'Bi-Weekly Sandbox',
    accent: '#22c55e',
    icon: (
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
        <circle cx="12" cy="12" r="10" />
        <polyline points="12 6 12 12 16 14" />
      </svg>
    )
  },
  {
    id: 5,
    num: '05',
    title: 'Security is part of the build',
    tagline: 'OWASP hardened from design to ship',
    body: 'Threat modeling at architecture, dependency audits and secrets management before launch. No hardcoded keys, no open s3 buckets.',
    proof: 'Automated CI vulnerability scans, OWASP Top-10 compliance audit, and least-privilege IAM policies.',
    badge: 'Zero-Trust Pipeline',
    accent: '#eab308',
    icon: (
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
      </svg>
    )
  },
  {
    id: 6,
    num: '06',
    title: 'We stay after launch',
    tagline: 'Roadmap continuity & guaranteed SLA',
    body: 'Most clients are on their 3rd or 4th release with us. Software that no one maintains begins decaying in month two.',
    proof: '99.9% uptime SLA, operational runbooks, and monthly roadmap iteration squad.',
    badge: 'Long-Term Evolution',
    accent: '#ec4899',
    icon: (
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
        <polyline points="23 6 13.5 15.5 8.5 10.5 1 18" />
        <polyline points="17 6 23 6 23 12" />
      </svg>
    )
  }
];

export default function HoldUs3D() {
  const [activeIndex, setActiveIndex] = useState(0);
  const [isHovered, setIsHovered] = useState(false);
  const [tilt, setTilt] = useState({ x: 0, y: 0 });
  const [isDragging, setIsDragging] = useState(false);
  const [isMobile, setIsMobile] = useState(typeof window !== 'undefined' ? window.innerWidth < 640 : false);
  const dragStartX = useRef(0);
  const currentRotation = useRef(0);
  const targetRotation = useRef(0);
  const stageRef = useRef(null);
  const animFrameId = useRef(null);

  useEffect(() => {
    const handleResize = () => setIsMobile(window.innerWidth < 640);
    window.addEventListener('resize', handleResize);
    return () => window.removeEventListener('resize', handleResize);
  }, []);

  const total = COMMITMENTS.length;
  const angleStep = 360 / total;
  const radius = isMobile ? 180 : 440;
  const cardW = isMobile ? 240 : 360;

  // Set target rotation based on active index
  useEffect(() => {
    targetRotation.current = -activeIndex * angleStep;
  }, [activeIndex, angleStep]);

  // Smooth rotation animation loop
  useEffect(() => {
    const loop = () => {
      if (!isDragging) {
        currentRotation.current += (targetRotation.current - currentRotation.current) * 0.12;
      }
      if (stageRef.current) {
        stageRef.current.style.transform = `rotateY(${currentRotation.current}deg)`;
      }
      animFrameId.current = requestAnimationFrame(loop);
    };
    animFrameId.current = requestAnimationFrame(loop);
    return () => cancelAnimationFrame(animFrameId.current);
  }, [isDragging]);

  // Auto-advance every 6 seconds when not hovered
  useEffect(() => {
    if (isHovered || isDragging) return;
    const timer = setInterval(() => {
      setActiveIndex((prev) => (prev + 1) % total);
    }, 6000);
    return () => clearInterval(timer);
  }, [isHovered, isDragging, total]);

  // Card mouse move tilt
  const handleMouseMove = useCallback((e) => {
    const rect = e.currentTarget.getBoundingClientRect();
    const x = (e.clientX - rect.left) / rect.width - 0.5;
    const y = (e.clientY - rect.top) / rect.height - 0.5;
    setTilt({ x: x * 15, y: -y * 15 });
  }, []);

  const handleMouseLeave = useCallback(() => {
    setTilt({ x: 0, y: 0 });
    setIsHovered(false);
  }, []);

  // Pointer drag gestures for 3D rotation
  const handlePointerDown = (e) => {
    setIsDragging(true);
    dragStartX.current = e.clientX;
  };

  const handlePointerMove = (e) => {
    if (!isDragging) return;
    const deltaX = e.clientX - dragStartX.current;
    dragStartX.current = e.clientX;
    currentRotation.current += deltaX * 0.35;
  };

  const handlePointerUp = () => {
    if (!isDragging) return;
    setIsDragging(false);
    // Snap to nearest card
    const rawIndex = Math.round(-currentRotation.current / angleStep);
    const normalizedIndex = ((rawIndex % total) + total) % total;
    setActiveIndex(normalizedIndex);
    targetRotation.current = -rawIndex * angleStep;
  };

  const goToNext = () => setActiveIndex((prev) => (prev + 1) % total);
  const goToPrev = () => setActiveIndex((prev) => (prev - 1 + total) % total);

  const activeItem = COMMITMENTS[activeIndex];

  return (
    <div 
      className="sd-holdus-container"
      onMouseEnter={() => setIsHovered(true)}
      onMouseLeave={handleMouseLeave}
      style={{
        position: 'relative',
        width: '100%',
        minHeight: '620px',
        padding: '24px 0 40px',
        display: 'flex',
        flexDirection: 'column',
        alignItems: 'center',
        justifyContent: 'center',
        overflow: 'hidden',
        userSelect: 'none'
      }}
    >
      {/* Background Holographic Halo */}
      <div 
        style={{
          position: 'absolute',
          top: '50%',
          left: '50%',
          transform: 'translate(-50%, -50%)',
          width: '750px',
          height: '500px',
          background: `radial-gradient(ellipse at center, ${activeItem.accent}1f 0%, rgba(168, 85, 247, 0.08) 45%, transparent 70%)`,
          pointerEvents: 'none',
          filter: 'blur(60px)',
          transition: 'background 0.8s ease',
          zIndex: 0
        }} 
      />

      {/* 3D Spatial Ring Viewport */}
      <div 
        className="sd-holdus-viewport"
        onPointerDown={handlePointerDown}
        onPointerMove={handlePointerMove}
        onPointerUp={handlePointerUp}
        onPointerLeave={handlePointerUp}
        style={{
          position: 'relative',
          width: '100%',
          maxWidth: '1100px',
          height: isMobile ? '400px' : '460px',
          perspective: isMobile ? '1000px' : '1300px',
          perspectiveOrigin: '50% 48%',
          cursor: isDragging ? 'grabbing' : 'grab',
          zIndex: 1
        }}
      >
        <div 
          ref={stageRef}
          className="sd-holdus-stage"
          style={{
            position: 'absolute',
            width: '100%',
            height: '100%',
            transformStyle: 'preserve-3d',
            transition: isDragging ? 'none' : 'transform 0.1s linear'
          }}
        >
          {COMMITMENTS.map((item, idx) => {
            const itemAngle = idx * angleStep;
            const isActive = idx === activeIndex;

            return (
              <div
                key={item.id}
                onClick={(e) => {
                  e.stopPropagation();
                  setActiveIndex(idx);
                }}
                onMouseMove={isActive ? handleMouseMove : undefined}
                className={`sd-holdus-card ${isActive ? 'is-active' : ''}`}
                style={{
                  position: 'absolute',
                  top: '50%',
                  left: '50%',
                  width: isMobile ? '240px' : '360px',
                  height: isMobile ? '365px' : '410px',
                  marginLeft: isMobile ? '-120px' : '-180px',
                  marginTop: isMobile ? '-182px' : '-205px',
                  transform: `rotateY(${itemAngle}deg) translateZ(${radius}px) ${
                    isActive ? `rotateX(${tilt.y}deg) rotateY(${tilt.x}deg) scale(1.04)` : 'scale(0.88)'
                  }`,
                  transformStyle: 'preserve-3d',
                  borderRadius: isMobile ? '18px' : '24px',
                  background: isActive
                    ? 'linear-gradient(145deg, rgba(16, 24, 45, 0.94), rgba(7, 12, 26, 0.97))'
                    : 'linear-gradient(145deg, rgba(12, 18, 34, 0.65), rgba(6, 9, 20, 0.8))',
                  border: isActive
                    ? `1.5px solid ${item.accent}99`
                    : '1px solid rgba(255, 255, 255, 0.08)',
                  boxShadow: isActive
                    ? `0 24px 60px rgba(0, 0, 0, 0.8), 0 0 35px ${item.accent}33`
                    : '0 12px 30px rgba(0, 0, 0, 0.5)',
                  backdropFilter: 'blur(16px)',
                  WebkitBackdropFilter: 'blur(16px)',
                  padding: isMobile ? '20px 18px' : '28px 26px',
                  display: 'flex',
                  flexDirection: 'column',
                  justifyContent: 'space-between',
                  opacity: isActive ? 1 : 0.45,
                  filter: isActive ? 'none' : 'blur(1.5px)',
                  transition: isDragging 
                    ? 'opacity 0.3s ease, filter 0.3s ease' 
                    : 'opacity 0.4s ease, filter 0.4s ease, border-color 0.4s ease, box-shadow 0.4s ease',
                  cursor: isActive ? 'default' : 'pointer'
                }}
              >
                {/* Top Bar: Icon + Num + Badge */}
                <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between' }}>
                  <div 
                    style={{
                      width: '44px',
                      height: '44px',
                      borderRadius: '12px',
                      background: `rgba(255, 255, 255, 0.05)`,
                      border: `1px solid ${isActive ? item.accent : 'rgba(255, 255, 255, 0.1)'}`,
                      display: 'grid',
                      placeItems: 'center',
                      color: item.accent,
                      boxShadow: isActive ? `0 0 16px ${item.accent}40` : 'none',
                      transition: 'all 0.3s ease'
                    }}
                  >
                    {item.icon}
                  </div>
                  <div style={{ display: 'flex', alignItems: 'center', gap: '8px' }}>
                    <span 
                      style={{
                        fontSize: '0.72rem',
                        fontWeight: '700',
                        letterSpacing: '0.08em',
                        textTransform: 'uppercase',
                        padding: '4px 10px',
                        borderRadius: '999px',
                        background: `${item.accent}1a`,
                        border: `1px solid ${item.accent}4d`,
                        color: item.accent
                      }}
                    >
                      {item.badge}
                    </span>
                    <span 
                      style={{
                        fontFamily: 'monospace',
                        fontWeight: '800',
                        fontSize: '0.86rem',
                        color: 'rgba(255, 255, 255, 0.4)'
                      }}
                    >
                      {item.num}
                    </span>
                  </div>
                </div>

                {/* Content Block */}
                <div style={{ margin: '18px 0 12px' }}>
                  <span 
                    style={{
                      display: 'block',
                      fontSize: '0.76rem',
                      fontWeight: '700',
                      letterSpacing: '0.06em',
                      textTransform: 'uppercase',
                      color: item.accent,
                      marginBottom: '6px'
                    }}
                  >
                    {item.tagline}
                  </span>
                  <h3 
                    style={{
                      fontSize: '1.24rem',
                      fontWeight: '700',
                      color: '#ffffff',
                      lineHeight: '1.3',
                      letterSpacing: '-0.01em',
                      marginBottom: '10px'
                    }}
                  >
                    {item.title}
                  </h3>
                  <p 
                    style={{
                      fontSize: '0.88rem',
                      lineHeight: '1.6',
                      color: 'rgba(203, 213, 225, 0.88)',
                      margin: 0
                    }}
                  >
                    {item.body}
                  </p>
                </div>

                {/* Proof Verification Box */}
                <div 
                  style={{
                    padding: '12px 14px',
                    borderRadius: '12px',
                    background: 'rgba(0, 0, 0, 0.35)',
                    border: '1px solid rgba(255, 255, 255, 0.08)',
                    fontSize: '0.78rem',
                    color: 'rgba(255, 255, 255, 0.85)',
                    lineHeight: '1.45',
                    display: 'flex',
                    alignItems: 'flex-start',
                    gap: '8px'
                  }}
                >
                  <span style={{ color: item.accent, flexShrink: 0, fontWeight: '700' }}>✓</span>
                  <div>
                    <strong style={{ color: '#ffffff', display: 'block', fontSize: '0.72rem', textTransform: 'uppercase', letterSpacing: '0.05em', marginBottom: '2px' }}>
                      Month-1 Checkable Proof
                    </strong>
                    <span>{item.proof}</span>
                  </div>
                </div>
              </div>
            );
          })}
        </div>
      </div>

      {/* Orbit Controls & Scrubber */}
      <div 
        style={{
          display: 'flex',
          alignItems: 'center',
          justifyContent: 'center',
          gap: '20px',
          marginTop: '28px',
          zIndex: 2
        }}
      >
        <button
          type="button"
          onClick={goToPrev}
          aria-label="Previous commitment"
          style={{
            width: '40px',
            height: '40px',
            borderRadius: '50%',
            background: 'rgba(255, 255, 255, 0.05)',
            border: '1px solid rgba(255, 255, 255, 0.15)',
            color: '#ffffff',
            display: 'grid',
            placeItems: 'center',
            cursor: 'pointer',
            transition: 'all 0.25s ease'
          }}
          onMouseEnter={(e) => {
            e.currentTarget.style.borderColor = activeItem.accent;
            e.currentTarget.style.boxShadow = `0 0 14px ${activeItem.accent}40`;
          }}
          onMouseLeave={(e) => {
            e.currentTarget.style.borderColor = 'rgba(255, 255, 255, 0.15)';
            e.currentTarget.style.boxShadow = 'none';
          }}
        >
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5" strokeLinecap="round" strokeLinejoin="round">
            <polyline points="15 18 9 12 15 6" />
          </svg>
        </button>

        {/* Scrubber Dots */}
        <div style={{ display: 'flex', alignItems: 'center', gap: '8px' }}>
          {COMMITMENTS.map((c, i) => (
            <button
              key={c.id}
              type="button"
              onClick={() => setActiveIndex(i)}
              aria-label={`Go to commitment ${c.num}`}
              style={{
                width: i === activeIndex ? '28px' : '8px',
                height: '8px',
                borderRadius: '999px',
                background: i === activeIndex ? activeItem.accent : 'rgba(255, 255, 255, 0.2)',
                border: 'none',
                cursor: 'pointer',
                transition: 'all 0.3s cubic-bezier(0.16, 1, 0.3, 1)',
                boxShadow: i === activeIndex ? `0 0 10px ${activeItem.accent}` : 'none'
              }}
            />
          ))}
        </div>

        <button
          type="button"
          onClick={goToNext}
          aria-label="Next commitment"
          style={{
            width: '40px',
            height: '40px',
            borderRadius: '50%',
            background: 'rgba(255, 255, 255, 0.05)',
            border: '1px solid rgba(255, 255, 255, 0.15)',
            color: '#ffffff',
            display: 'grid',
            placeItems: 'center',
            cursor: 'pointer',
            transition: 'all 0.25s ease'
          }}
          onMouseEnter={(e) => {
            e.currentTarget.style.borderColor = activeItem.accent;
            e.currentTarget.style.boxShadow = `0 0 14px ${activeItem.accent}40`;
          }}
          onMouseLeave={(e) => {
            e.currentTarget.style.borderColor = 'rgba(255, 255, 255, 0.15)';
            e.currentTarget.style.boxShadow = 'none';
          }}
        >
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5" strokeLinecap="round" strokeLinejoin="round">
            <polyline points="9 18 15 12 9 6" />
          </svg>
        </button>
      </div>

      {/* Swipe / Drag Hint */}
      <span style={{ fontSize: '0.74rem', color: 'rgba(255, 255, 255, 0.4)', marginTop: '12px', letterSpacing: '0.04em' }}>
        ⇄ Drag to rotate the 3D commitment orbit • Click card to focus
      </span>
    </div>
  );
}
