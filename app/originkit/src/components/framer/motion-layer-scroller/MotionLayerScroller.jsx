import React, { useRef, useEffect, useState, useMemo, useCallback } from 'react';
import { motion, AnimatePresence, useMotionValue, useTransform, useSpring, useVelocity } from 'framer-motion';

/**
 * MotionLayerScroller
 *
 * Exact Framer MotionLayerScroller component ported for iThrive On-Demand benefits.
 * 3D isometric perspective layer scroller with dynamic velocity tilt,
 * depth of field blur, and mouse wheel / drag inertia.
 */

const DEFAULT_BENEFITS = [
  {
    num: '01',
    title: 'Experience you are not paying to grow',
    subtitle: '7+ Years Seniority Floor',
    desc: "Seven years minimum across every discipline. The costly mistakes and learning curves already happened on somebody else's product, not on your production roadmap.",
    image: '/assets/img/ondemand/photo/benefit-01.jpg',
    accent: '#00F2FE',
  },
  {
    num: '02',
    title: 'Your own team stays on the core',
    subtitle: 'Zero Context Switching',
    desc: 'The mission-critical work that only your founding team can do stays protected with your core engineers. The heavy sprint throughput and integrations come from us.',
    image: '/assets/img/ondemand/photo/benefit-02.jpg',
    accent: '#38BDF8',
  },
  {
    num: '03',
    title: 'Peaks stop becoming slippage',
    subtitle: 'Elastic Sprint Capacity',
    desc: 'Take an entire squad for a quarterly surge or major release, rather than committing to a permanent six-month hiring cycle for a transient delivery crunch.',
    image: '/assets/img/ondemand/photo/benefit-03.jpg',
    accent: '#6366F1',
  },
  {
    num: '04',
    title: 'Skills you cannot justify full time',
    subtitle: 'Specialists On Tap',
    desc: 'Need a payment gateway compliance auditor or WebSockets architect for six weeks? Hiring one full-time is impossible; embedding one from our bench is trivial.',
    image: '/assets/img/ondemand/photo/benefit-04.jpg',
    accent: '#9D4EDD',
  },
  {
    num: '05',
    title: 'A live bench, not a job advert',
    subtitle: '48-Hour Shortlists',
    desc: 'Named, vetted engineers ready to pull tickets inside forty-eight hours, compared to an exhausting agency recruiting cycle measured in quarters.',
    image: '/assets/img/ondemand/photo/benefit-05.jpg',
    accent: '#EC4899',
  },
];

export default function MotionLayerScroller(props) {
  const {
    items = DEFAULT_BENEFITS,
    backgroundColor = 'transparent',
    scrollSensitivity = 0.6,
    perspective = 1800,
    cameraTilt = -22,
    cameraRotation = -42,
    minLayers = 15,
    autoPlay = { enabled: true, mode: 'continuous', speed: 35 },
  } = props;

  const containerRef = useRef(null);
  const [containerSize, setContainerSize] = useState({ width: 0, height: 0 });
  const [selectedCard, setSelectedCard] = useState(null);

  const scrollY = useMotionValue(0);
  const smoothScroll = useSpring(scrollY, { stiffness: 100, damping: 28 });

  const numLinked = items?.length || 0;
  const totalLayers = Math.max(minLayers, numLinked > 0 ? numLinked * 3 : minLayers);
  const layerSpacing = 160;

  // Wheel handling
  const handleWheel = useCallback((e) => {
    e.preventDefault();
    const factor = e.deltaMode === 1 ? 16 : e.deltaMode === 2 ? window.innerHeight : 1;
    const delta = e.deltaY * factor * scrollSensitivity;
    scrollY.set(scrollY.get() + delta);
  }, [scrollSensitivity, scrollY]);

  useEffect(() => {
    const container = containerRef.current;
    if (!container) return;
    const updateSize = () => {
      setContainerSize({ width: container.offsetWidth, height: container.offsetHeight });
    };
    updateSize();
    const ro = new ResizeObserver(updateSize);
    ro.observe(container);
    container.addEventListener('wheel', handleWheel, { passive: false });
    return () => {
      ro.disconnect();
      container.removeEventListener('wheel', handleWheel);
    };
  }, [handleWheel]);

  // Pointer drag handling
  const isDraggingRef = useRef(false);
  const dragMovedRef = useRef(false);
  const dragStartYRef = useRef(0);
  const dragStartScrollRef = useRef(0);

  const handlePointerDown = (e) => {
    // Only capture if clicking background, not a card layer
    isDraggingRef.current = true;
    dragMovedRef.current = false;
    dragStartYRef.current = e.clientY;
    dragStartScrollRef.current = scrollY.get();
  };

  const handlePointerMove = (e) => {
    if (!isDraggingRef.current) return;
    const dy = dragStartYRef.current - e.clientY;
    if (Math.abs(dy) > 5) {
      dragMovedRef.current = true;
      try {
        e.currentTarget.setPointerCapture?.(e.pointerId);
      } catch {}
    }
    scrollY.set(dragStartScrollRef.current + dy * 1.5);
  };

  const handlePointerUp = (e) => {
    isDraggingRef.current = false;
    try {
      e.currentTarget.releasePointerCapture?.(e.pointerId);
    } catch {}
  };

  // AutoPlay loop
  useEffect(() => {
    if (!autoPlay?.enabled) return;
    let rafId = 0;
    let lastTime = performance.now();
    const animate = (now) => {
      const dt = (now - lastTime) / 1000;
      lastTime = now;
      if (!isDraggingRef.current) {
        scrollY.set(scrollY.get() + (autoPlay.speed || 35) * dt);
      }
      rafId = requestAnimationFrame(animate);
    };
    rafId = requestAnimationFrame(animate);
    return () => cancelAnimationFrame(rafId);
  }, [autoPlay, scrollY]);

  // Velocity dynamic tilt
  const scrollVelocity = useVelocity(smoothScroll);
  const smoothVelocity = useSpring(scrollVelocity, { stiffness: 100, damping: 30 });
  const velocityRotation = useTransform(smoothVelocity, [-1000, 0, 1000], [-6, 0, 6]);
  const sceneRotateX = useTransform(velocityRotation, (offset) => cameraTilt + offset);

  return (
    <div
      style={{
        position: 'relative',
        width: '100%',
        height: '620px',
        overflow: 'hidden',
        background: backgroundColor,
        borderRadius: '24px',
        border: '1px solid rgba(255, 255, 255, 0.08)',
        boxShadow: '0 30px 90px -20px rgba(0, 0, 0, 0.7)',
        userSelect: 'none',
      }}
    >
      <div
        ref={containerRef}
        onPointerDown={handlePointerDown}
        onPointerMove={handlePointerMove}
        onPointerUp={handlePointerUp}
        onPointerCancel={handlePointerUp}
        style={{
          width: '100%',
          height: '100%',
          position: 'relative',
          overflow: 'hidden',
          perspective: `${perspective}px`,
          perspectiveOrigin: '50% 50%',
          transformStyle: 'preserve-3d',
          cursor: 'grab',
          touchAction: 'none',
        }}
      >
        <motion.div
          className="motion-scroller-scene"
          style={{
            position: 'absolute',
            width: '100%',
            height: '100%',
            transformStyle: 'preserve-3d',
            transformOrigin: '50% 50%',
            rotateX: sceneRotateX,
            rotateY: cameraRotation,
            pointerEvents: 'none',
          }}
        >
          {Array.from({ length: totalLayers }).map((_, index) => {
            const item = items[index % items.length];
            return (
              <ScrollerLayer
                key={index}
                index={index}
                totalLayers={totalLayers}
                spacing={layerSpacing}
                smoothScroll={smoothScroll}
                item={item}
                onSelect={setSelectedCard}
              />
            );
          })}
        </motion.div>
      </div>

      {/* Scroller Hint Overlay */}
      <div
        style={{
          position: 'absolute',
          bottom: 18,
          left: '50%',
          transform: 'translateX(-50%)',
          display: 'flex',
          alignItems: 'center',
          gap: '8px',
          padding: '6px 14px',
          borderRadius: '999px',
          background: 'rgba(7, 12, 24, 0.75)',
          backdropFilter: 'blur(12px)',
          border: '1px solid rgba(255, 255, 255, 0.12)',
          color: 'rgba(203, 213, 225, 0.85)',
          fontSize: '12px',
          fontFamily: 'Fira Code, monospace',
          pointerEvents: 'none',
          zIndex: 20,
        }}
      >
        <span style={{ width: '6px', height: '6px', borderRadius: '50%', background: '#38BDF8', boxShadow: '0 0 8px #38BDF8' }} />
        Wheel or drag to navigate · Click any card to zoom in
      </div>

      {/* Zoom Modal Overlay */}
      <AnimatePresence>
        {selectedCard && (
          <motion.div
            initial={{ opacity: 0 }}
            animate={{ opacity: 1 }}
            exit={{ opacity: 0 }}
            onClick={() => setSelectedCard(null)}
            style={{
              position: 'absolute',
              inset: 0,
              zIndex: 100000,
              background: 'rgba(3, 6, 16, 0.88)',
              backdropFilter: 'blur(24px)',
              display: 'flex',
              alignItems: 'center',
              justifyContent: 'center',
              padding: '20px',
              cursor: 'zoom-out',
            }}
          >
            <motion.div
              initial={{ scale: 0.85, y: 30, opacity: 0 }}
              animate={{ scale: 1, y: 0, opacity: 1 }}
              exit={{ scale: 0.9, y: 20, opacity: 0 }}
              transition={{ type: 'spring', damping: 26, stiffness: 320 }}
              onClick={(e) => e.stopPropagation()}
              style={{
                position: 'relative',
                width: 'min(620px, 95%)',
                background: '#070C1B',
                borderRadius: '24px',
                border: `1px solid ${selectedCard.accent}80`,
                boxShadow: `0 30px 90px rgba(0, 0, 0, 0.95), 0 0 60px ${selectedCard.accent}33`,
                overflow: 'hidden',
                cursor: 'default',
              }}
            >
              {/* Close Button */}
              <button
                type="button"
                onClick={() => setSelectedCard(null)}
                style={{
                  position: 'absolute',
                  top: '16px',
                  right: '16px',
                  zIndex: 10,
                  width: '36px',
                  height: '36px',
                  borderRadius: '50%',
                  background: 'rgba(255, 255, 255, 0.1)',
                  border: '1px solid rgba(255, 255, 255, 0.2)',
                  color: '#FFFFFF',
                  fontSize: '18px',
                  display: 'flex',
                  alignItems: 'center',
                  justifyContent: 'center',
                  cursor: 'pointer',
                }}
              >
                ✕
              </button>

              {/* Graphic Banner */}
              <div style={{ position: 'relative', height: '220px', overflow: 'hidden', background: '#02050E' }}>
                <img
                  src={selectedCard.image}
                  alt={selectedCard.title}
                  style={{ width: '100%', height: '100%', objectFit: 'cover' }}
                />
                <div
                  style={{
                    position: 'absolute',
                    inset: 0,
                    background: `linear-gradient(to top, #070C1B 0%, rgba(7, 12, 27, 0.3) 100%)`,
                  }}
                />
                <div
                  style={{
                    position: 'absolute',
                    bottom: '16px',
                    left: '24px',
                    display: 'flex',
                    alignItems: 'center',
                    gap: '10px',
                  }}
                >
                  <span
                    style={{
                      fontFamily: 'Fira Code, monospace',
                      fontSize: '13px',
                      fontWeight: 800,
                      color: selectedCard.accent,
                      padding: '4px 10px',
                      borderRadius: '999px',
                      background: `${selectedCard.accent}26`,
                      border: `1px solid ${selectedCard.accent}66`,
                    }}
                  >
                    {selectedCard.num}
                  </span>
                  <span
                    style={{
                      fontSize: '12px',
                      fontWeight: 700,
                      color: '#E2E8F0',
                      letterSpacing: '0.08em',
                      textTransform: 'uppercase',
                    }}
                  >
                    {selectedCard.subtitle}
                  </span>
                </div>
              </div>

              {/* Content Body */}
              <div style={{ padding: '24px 28px' }}>
                <h3
                  style={{
                    fontSize: '22px',
                    fontWeight: 800,
                    color: '#F8FAFC',
                    lineHeight: 1.25,
                    letterSpacing: '-0.02em',
                    margin: '0 0 14px',
                  }}
                >
                  {selectedCard.title}
                </h3>

                <p
                  style={{
                    fontSize: '14px',
                    lineHeight: 1.7,
                    color: '#CBD5E1',
                    margin: '0 0 24px',
                  }}
                >
                  {selectedCard.desc}
                </p>

                <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', borderTop: '1px solid rgba(255, 255, 255, 0.08)', paddingTop: '18px' }}>
                  <span style={{ fontSize: '12px', color: '#94A3B8', fontFamily: 'Fira Code, monospace' }}>
                    Impact: Production-ready delivery
                  </span>
                  <button
                    type="button"
                    className="od-btn od-btn--primary"
                    data-modal-open
                    data-modal-service={`Engineering Change: ${selectedCard.title}`}
                    style={{
                      background: `linear-gradient(90deg, ${selectedCard.accent}, #3B82F6)`,
                      color: '#040711',
                      fontWeight: 800,
                      fontSize: '13px',
                      padding: '10px 18px',
                      borderRadius: '10px',
                      boxShadow: `0 6px 20px ${selectedCard.accent}40`,
                      cursor: 'pointer',
                    }}
                  >
                    Deploy this change →
                  </button>
                </div>
              </div>
            </motion.div>
          </motion.div>
        )}
      </AnimatePresence>
    </div>
  );
}

function ScrollerLayer({ index, totalLayers, spacing, smoothScroll, item, onSelect }) {
  const [hovered, setHovered] = useState(false);
  const zInitial = -index * spacing;

  const layerZ = useTransform(smoothScroll, (val) => {
    const totalDepth = totalLayers * spacing;
    const currentZ = zInitial + val;
    const normalizedZ = ((currentZ % totalDepth) + totalDepth) % totalDepth;
    return normalizedZ - totalDepth * 0.5;
  });

  const scale = useTransform(
    layerZ,
    [-totalLayers * spacing * 0.5, 0, totalLayers * spacing * 0.5],
    [0.72, 1, 1.35]
  );

  const opacity = useTransform(
    layerZ,
    [-totalLayers * spacing * 0.5, -totalLayers * spacing * 0.2, 0, totalLayers * spacing * 0.2, totalLayers * spacing * 0.5],
    [0, 0.75, 1, 0.75, 0]
  );

  const blur = useTransform(
    layerZ,
    [-totalLayers * spacing * 0.5, -totalLayers * spacing * 0.15, 0, totalLayers * spacing * 0.15, totalLayers * spacing * 0.5],
    [10, 2, 0, 2, 10]
  );

  const filterValue = useTransform(blur, (b) => {
    if (hovered) return 'none';
    return b <= 0.2 ? 'none' : `blur(${b}px)`;
  });

  const zIndex = useTransform(layerZ, (z) => Math.round(5000 + z * 10));

  return (
    <motion.div
      style={{
        position: 'absolute',
        width: '420px',
        height: '240px',
        left: '50%',
        top: '50%',
        x: '-50%',
        y: '-50%',
        transformOrigin: '50% 50%',
        translateZ: layerZ,
        scale,
        opacity,
        filter: filterValue,
        zIndex: hovered ? 99999 : zIndex,
        borderRadius: '18px',
        border: `1px solid ${hovered ? item.accent : 'rgba(255, 255, 255, 0.15)'}`,
        boxShadow: hovered
          ? `0 20px 40px -10px ${item.accent}66, 0 0 25px ${item.accent}33`
          : '0 25px 50px -12px rgba(0, 0, 0, 0.75)',
        background: 'linear-gradient(135deg, rgba(8, 14, 30, 0.95) 0%, rgba(5, 9, 20, 0.98) 100%)',
        overflow: 'hidden',
        display: 'grid',
        gridTemplateColumns: '150px 1fr',
        pointerEvents: 'auto',
        cursor: 'pointer',
        transition: 'border-color 0.2s ease, box-shadow 0.2s ease',
      }}
      whileHover={{ scale: 1.06, y: '-56%' }}
      onHoverStart={() => setHovered(true)}
      onHoverEnd={() => setHovered(false)}
      onPointerDown={(e) => e.stopPropagation()}
      onClick={(e) => {
        e.stopPropagation();
        onSelect?.(item);
      }}
    >
      {/* Thumbnail */}
      <div style={{ position: 'relative', height: '100%', overflow: 'hidden', background: '#02050e' }}>
        <img
          src={item.image}
          alt={item.title}
          style={{
            width: '100%',
            height: '100%',
            objectFit: 'cover',
            filter: 'brightness(0.9) contrast(1.05)',
          }}
          loading="lazy"
        />
        <div
          style={{
            position: 'absolute',
            inset: 0,
            background: 'linear-gradient(90deg, transparent 40%, rgba(8, 14, 30, 0.95) 100%)',
          }}
        />
      </div>

      {/* Info */}
      <div
        style={{
          padding: '16px 18px',
          display: 'flex',
          flexDirection: 'column',
          justifyContent: 'center',
        }}
      >
        <div style={{ display: 'flex', alignItems: 'center', gap: '8px', marginBottom: '6px' }}>
          <span
            style={{
              fontFamily: 'Fira Code, monospace',
              fontSize: '11px',
              fontWeight: 800,
              color: item.accent,
              padding: '2px 7px',
              borderRadius: '999px',
              background: `${item.accent}1f`,
            }}
          >
            {item.num}
          </span>
          <span
            style={{
              fontSize: '11px',
              fontWeight: 600,
              color: '#94A3B8',
              letterSpacing: '0.04em',
              textTransform: 'uppercase',
            }}
          >
            {item.subtitle}
          </span>
        </div>

        <h4
          style={{
            fontSize: '15px',
            fontWeight: 700,
            color: '#F8FAFC',
            lineHeight: 1.3,
            margin: '0 0 6px',
          }}
        >
          {item.title}
        </h4>

        <p
          style={{
            fontSize: '12px',
            lineHeight: 1.5,
            color: '#A9B8CE',
            margin: 0,
            display: '-webkit-box',
            WebkitLineClamp: 3,
            WebkitBoxOrient: 'vertical',
            overflow: 'hidden',
          }}
        >
          {item.desc}
        </p>
      </div>
    </motion.div>
  );
}
