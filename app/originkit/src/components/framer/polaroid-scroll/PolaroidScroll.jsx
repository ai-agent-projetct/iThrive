import React, { useRef, useState, useEffect } from 'react';

// Six visual software build photographic prints
const POLAROID_PHOTOS = [
  {
    id: 'photo-1',
    src: '/assets/img/custom/photo/layer-06.jpg',
    alt: 'Custom Enterprise Platform Architecture',
    col: 'left',
    angle: -8,
    speed: 1.15,
    topOffset: 85, // initial percentage
  },
  {
    id: 'photo-2',
    src: '/assets/img/pages/services/photo/micro-saas-development.jpg',
    alt: 'Multi-Tenant Cloud SaaS Infrastructure',
    col: 'center',
    angle: 5,
    speed: 0.95,
    topOffset: 125,
  },
  {
    id: 'photo-3',
    src: '/assets/img/cloud/photo/step-01.jpg',
    alt: 'AI-Native Retrieval & Agent Workflows',
    col: 'right',
    angle: 9,
    speed: 1.1,
    topOffset: 100,
  },
  {
    id: 'photo-4',
    src: '/assets/img/pages/services/photo/ai-for-ecommerce.jpg',
    alt: 'High-Volume Commerce Transaction Systems',
    col: 'left',
    angle: -6,
    speed: 1.05,
    topOffset: 185,
  },
  {
    id: 'photo-5',
    src: '/assets/img/pages/apps/photo/flutter-codebase.jpg',
    alt: 'Cross-Platform Field Operations Engineering',
    col: 'center',
    angle: 7,
    speed: 1.2,
    topOffset: 220,
  },
  {
    id: 'photo-6',
    src: '/assets/img/custom/photo/layer-01.jpg',
    alt: 'Real-Time Insights & Analytics Pipeline',
    col: 'right',
    angle: -5,
    speed: 0.92,
    topOffset: 195,
  },
];

export default function PolaroidScroll({
  title = "Pick the shape closest to what you need",
  eyebrow = "What We Build",
  photos = POLAROID_PHOTOS,
}) {
  const containerRef = useRef(null);
  const [scrollProgress, setScrollProgress] = useState(0);

  useEffect(() => {
    const handleScroll = () => {
      if (!containerRef.current) return;
      const rect = containerRef.current.getBoundingClientRect();
      const totalScrollable = rect.height - window.innerHeight;
      if (totalScrollable <= 0) return;

      const currentScroll = -rect.top;
      const progress = Math.max(0, Math.min(1, currentScroll / totalScrollable));
      setScrollProgress(progress);
    };

    window.addEventListener('scroll', handleScroll, { passive: true });
    handleScroll();
    return () => window.removeEventListener('scroll', handleScroll);
  }, []);

  return (
    <div
      ref={containerRef}
      className="polaroid-framer-section"
      style={{
        position: 'relative',
        height: '2800px', // Exact Framer travel depth
        background: 'transparent',
      }}
    >
      {/* Sticky Rounded Viewport matching polaroid-scroll.framer.ai */}
      <div
        className="polaroid-sticky-viewport"
        style={{
          position: 'sticky',
          top: '24px',
          height: 'calc(100vh - 48px)',
          minHeight: '680px',
          maxHeight: '940px',
          margin: '0 auto',
          width: 'calc(100% - 32px)',
          maxWidth: '1420px',
          borderRadius: '24px',
          background: '#12151c',
          boxShadow: '0 30px 80px rgba(0, 0, 0, 0.85), 0 0 0 1px rgba(255, 255, 255, 0.08)',
          overflow: 'hidden',
          display: 'flex',
          flexDirection: 'column',
          alignItems: 'center',
          justifyContent: 'center',
        }}
      >
        {/* Ambient Subtle Vignette */}
        <div
          style={{
            position: 'absolute',
            inset: 0,
            background: 'radial-gradient(ellipse at 50% 50%, rgba(255, 255, 255, 0.02) 0%, rgba(0, 0, 0, 0.65) 100%)',
            pointerEvents: 'none',
            zIndex: 1,
          }}
        />

        {/* Floating Header Banner - gracefully fades as scroll deepens */}
        <div
          style={{
            position: 'absolute',
            top: '32px',
            zIndex: 25,
            textAlign: 'center',
            pointerEvents: 'none',
            padding: '0 20px',
            opacity: Math.max(0, 1 - scrollProgress * 4),
            transform: `translateY(${-scrollProgress * 60}px)`,
            transition: 'opacity 0.2s ease-out, transform 0.2s ease-out',
          }}
        >
          <p
            style={{
              fontSize: '0.78rem',
              fontWeight: 700,
              letterSpacing: '0.16em',
              textTransform: 'uppercase',
              color: '#00f2fe',
              marginBottom: '6px',
            }}
          >
            {eyebrow}
          </p>
          <h2
            style={{
              fontSize: 'clamp(1.5rem, 2.8vw, 2.3rem)',
              fontWeight: 700,
              color: '#ffffff',
              letterSpacing: '-0.02em',
              margin: '0 0 8px 0',
            }}
          >
            {title}
          </h2>
          <p
            style={{
              fontSize: '0.85rem',
              color: 'rgba(255, 255, 255, 0.5)',
              margin: 0,
              letterSpacing: '0.04em',
            }}
          >
            ↓ Scroll Down ↓
          </p>
        </div>

        {/* Polaroid Cards Arena - exact Framer 3-column scroll physics */}
        <div
          className="polaroid-cards-canvas"
          style={{
            position: 'relative',
            width: '100%',
            height: '100%',
            overflow: 'hidden',
            zIndex: 5,
          }}
        >
          {photos.map((item, idx) => {
            // Column placement: left (-31%), center (0%), right (+31%)
            let xPos = 0;
            if (item.col === 'left') xPos = -31;
            else if (item.col === 'right') xPos = 31;
            else xPos = (idx % 2 === 0 ? -4 : 4);

            // Framer upward translation: starts from bottom/mid and glides upward smoothly
            const totalTravel = 260; // percent travel
            const currentY = item.topOffset - (scrollProgress * totalTravel * item.speed);
            
            // Subtle dynamic tilt rotation
            const rotation = item.angle + (Math.sin(scrollProgress * Math.PI + idx) * 2);

            return (
              <div
                key={item.id}
                className="framer-polaroid-card"
                style={{
                  position: 'absolute',
                  left: `calc(50% + ${xPos}%)`,
                  top: '50%',
                  transform: `translate(-50%, -50%) translateY(${currentY}%) rotate(${rotation}deg)`,
                  width: 'clamp(260px, 23vw, 350px)',
                  background: '#EDEDED', // Exact Framer photographic paper color
                  padding: '20px 20px 72px 20px', // Exact Framer Polaroid margin proportion (thick bottom lip)
                  borderRadius: '0px', // Sharp rectangular corners matching authentic Polaroid
                  boxShadow: 'rgba(0, 0, 0, 0.45) 0px 10px 30px 5px, rgba(0, 0, 0, 0.3) 0px 3px 10px 0px',
                  transition: 'transform 0.15s ease-out, box-shadow 0.25s ease',
                  cursor: 'grab',
                  willChange: 'transform',
                }}
                onMouseEnter={(e) => {
                  e.currentTarget.style.transform = `translate(-50%, -50%) translateY(${currentY}%) rotate(0deg) scale(1.05)`;
                  e.currentTarget.style.zIndex = '30';
                  e.currentTarget.style.boxShadow = 'rgba(0, 0, 0, 0.6) 0px 24px 60px 10px, 0 0 25px rgba(0, 242, 254, 0.3)';
                }}
                onMouseLeave={(e) => {
                  e.currentTarget.style.transform = `translate(-50%, -50%) translateY(${currentY}%) rotate(${rotation}deg)`;
                  e.currentTarget.style.zIndex = '10';
                  e.currentTarget.style.boxShadow = 'rgba(0, 0, 0, 0.45) 0px 10px 30px 5px, rgba(0, 0, 0, 0.3) 0px 3px 10px 0px';
                }}
              >
                {/* Photographic Print inside Polaroid frame */}
                <div
                  style={{
                    position: 'relative',
                    width: '100%',
                    aspectRatio: '385 / 460', // Exact Framer photographic aspect ratio
                    overflow: 'hidden',
                    background: '#0a0d14',
                    borderRadius: '0px',
                  }}
                >
                  <img
                    src={item.src}
                    alt={item.alt}
                    style={{
                      width: '100%',
                      height: '100%',
                      objectFit: 'cover',
                      display: 'block',
                      filter: 'contrast(1.08) saturate(0.95)',
                    }}
                    loading="lazy"
                    decoding="async"
                  />
                  {/* Subtle film print inner shadow */}
                  <div
                    style={{
                      position: 'absolute',
                      inset: 0,
                      boxShadow: 'inset 0 0 10px rgba(0, 0, 0, 0.35)',
                      pointerEvents: 'none',
                    }}
                  />
                </div>
              </div>
            );
          })}
        </div>
      </div>
    </div>
  );
}
