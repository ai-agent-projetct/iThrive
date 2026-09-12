import React, { useState, useEffect, useRef, useMemo, useCallback } from 'react';

/**
 * 3D Infinite Perspective Card Gallery
 * Reverse-engineered from https://3dinfinitecardgallery.framer.website/
 *
 * Architecture & Fixes:
 * - Dual opposing 3D rails (Left: +railRotation, Right: -railRotation)
 * - pointer-events: 'none' on perspective & scene 2D containers so clicks penetrate to cards
 * - Dynamic z-index = Math.round(10000 + z) to enforce true depth sorting for hit-testing
 * - pointer-events: 'auto' on card items with cursor: 'pointer'
 * - Drag scrubbing & touch gesture support
 * - Rich Inspection Modal with Previous / Next navigation, Escape key handler, and smooth backdrop
 */

export default function InfinitePerspectiveGallery({
  speed = 220,
  autoplay = true,
  pauseOnHover = true,
  perspective = 1000,
  parallaxEnabled = true,
  parallaxAmount = 2.5,
  disableParallaxOnMobile = true,
  spacing = 280,
  cardWidth = 299,
  cardHeight = 380,
  railEdgeInset = 0,
  railRotation = 70,
  backgroundColor = 'transparent',
  depthEffectIntensity = 0.75,
  maxBlur = 3.5,
  farOpacity = 0.38,
  tunnelFadeLength = 220,
  nearScale = 1.08,
  shadowIntensity = 1.0,
  images = [],
  style = {},
}) {
  const containerRef = useRef(null);
  const perspectiveRef = useRef(null);
  const sceneRef = useRef(null);
  const leftCardsRef = useRef([]);
  const rightCardsRef = useRef([]);
  const railLateralOffsetRef = useRef(220);
  const positionsRef = useRef([]);
  const rafIdRef = useRef(null);
  const lastTimeRef = useRef(0);
  const isPausedRef = useRef(false);
  const isHoveredContainerRef = useRef(false);
  const isTouchRef = useRef(false);
  const targetRotYRef = useRef(0);
  const targetRotXRef = useRef(0);
  const currentRotYRef = useRef(0);
  const currentRotXRef = useRef(0);

  // Drag interaction refs
  const isDraggingRef = useRef(false);
  const [isDragging, setIsDragging] = useState(false);
  const dragStartXRef = useRef(0);
  const dragStartYRef = useRef(0);
  const dragStartPositionsRef = useRef([]);
  const hasDraggedRef = useRef(false);

  const [activeModalItem, setActiveModalItem] = useState(null);
  const [dimensions, setDimensions] = useState({
    w: typeof window !== 'undefined' ? window.innerWidth : 1200,
    cardW: cardWidth,
    cardH: cardHeight,
    spacing: spacing,
    rotation: railRotation,
  });

  // Normalize image and reason data
  const normalizedItems = useMemo(() => {
    if (!images || images.length === 0) return [];
    return images.map((item, idx) => ({
      id: `reason-${item.num || idx + 1}`,
      num: item.num || String(idx + 1).padStart(2, '0'),
      title: item.title || `Reason ${idx + 1}`,
      desc: item.desc || item.alt || '',
      imageSrc: item.src || item.imageSrc || (item.image && item.image.src) || '',
      alt: item.alt || item.title || `Reason ${idx + 1}`,
    }));
  }, [images]);

  const T = useMemo(() => Math.max(8, normalizedItems.length), [normalizedItems.length]);
  const E = useMemo(() => T * Math.max(1, dimensions.spacing), [T, dimensions.spacing]);

  // Handle touch device detection
  useEffect(() => {
    if (typeof window !== 'undefined') {
      const coarse = window.matchMedia('(pointer: coarse)');
      isTouchRef.current = coarse.matches || 'ontouchstart' in window || navigator.maxTouchPoints > 0;
    }
  }, []);

  // Update responsive dimensions and rail offsets
  const updateLayout = useCallback(() => {
    const el = containerRef.current;
    if (!el) return;
    const clientW = el.clientWidth || window.innerWidth;

    let cw = cardWidth;
    let ch = cardHeight;
    let sp = spacing;
    let rot = railRotation;

    if (clientW < 640) {
      cw = 160;
      ch = 220;
      sp = 160;
      rot = 56;
    } else if (clientW < 960) {
      cw = 220;
      ch = 300;
      sp = 220;
      rot = 64;
    }

    setDimensions({
      w: clientW,
      cardW: cw,
      cardH: ch,
      spacing: sp,
      rotation: rot,
    });

    railLateralOffsetRef.current = Math.max(0, clientW * 0.5 - cw * 0.5 - railEdgeInset);
  }, [cardWidth, cardHeight, spacing, railRotation, railEdgeInset]);

  useEffect(() => {
    updateLayout();
    window.addEventListener('resize', updateLayout);
    return () => window.removeEventListener('resize', updateLayout);
  }, [updateLayout]);

  // Update scene parallax tilt
  const updateParallax = useCallback(() => {
    const scene = sceneRef.current;
    if (scene) {
      scene.style.transform = `rotateX(${currentRotXRef.current.toFixed(3)}deg) rotateY(${currentRotYRef.current.toFixed(3)}deg)`;
    }
  }, []);

  // 3D transform computation for both rails with dynamic z-index for hit testing
  const updateCardTransforms = useCallback(
    (positions) => {
      const rot = dimensions.rotation;
      const r = railLateralOffsetRef.current;
      const nearZ = Math.max(dimensions.cardH, dimensions.cardW) * 1.2;
      const farZ = -E;
      const spanZ = nearZ - farZ;
      const fadeLen = Math.max(0, tunnelFadeLength);
      const easeFn = (p) => p + (1 - Math.pow(1 - p, 3) - p) * depthEffectIntensity;
      const touchMod = isTouchRef.current ? 0.5 : 1.0;
      const effBlur = maxBlur * touchMod;
      const effShadow = shadowIntensity * touchMod;

      for (let i = 0; i < T; i++) {
        const z = positions[i];
        const rawProgress = Math.max(0, Math.min(1, (z - farZ) / spanZ));
        const f = easeFn(rawProgress);
        const scale = 1 + (nearScale - 1) * f;
        const fade = fadeLen <= 0 ? 1 : Math.max(0, Math.min(1, (z - farZ) / fadeLen));
        const opacity = (farOpacity + (1 - farOpacity) * f) * fade;
        const blur = effBlur * (1 - f);
        const brightness = 0.72 + 0.28 * f;

        const shadowV = 8 + 22 * f;
        const shadowY = 18 + 44 * f;
        const shadowSpread = 10 + 16 * f;
        const shadowA1 = (0.1 + 0.22 * f) * effShadow;
        const shadowA2 = (0.07 + 0.16 * f) * effShadow;

        const filterCss = `blur(${blur.toFixed(2)}px) brightness(${brightness.toFixed(3)})`;
        const shadowCss = `0px ${shadowV.toFixed(1)}px ${shadowY.toFixed(1)}px rgba(0,0,0,${shadowA1.toFixed(3)}), 0px ${Math.max(1, shadowV * 0.18).toFixed(1)}px ${shadowSpread.toFixed(1)}px rgba(0,242,254,${shadowA2.toFixed(3)})`;
        // Exact integer z-index ensures proper front-to-back pointer event hit testing
        const cardZIndex = `${Math.round(10000 + z)}`;

        // Left rail element
        const leftEl = leftCardsRef.current[i];
        if (leftEl) {
          leftEl.style.transform = `translate3d(calc(-50% - ${r}px), -50%, ${z}px) rotateY(${rot}deg) scale(${scale})`;
          leftEl.style.opacity = `${opacity}`;
          leftEl.style.filter = filterCss;
          leftEl.style.boxShadow = shadowCss;
          leftEl.style.zIndex = cardZIndex;
        }

        // Right rail element
        const rightEl = rightCardsRef.current[i];
        if (rightEl) {
          rightEl.style.transform = `translate3d(calc(-50% + ${r}px), -50%, ${z}px) rotateY(${-rot}deg) scale(${scale})`;
          rightEl.style.opacity = `${opacity}`;
          rightEl.style.filter = filterCss;
          rightEl.style.boxShadow = shadowCss;
          rightEl.style.zIndex = cardZIndex;
        }
      }
    },
    [
      T,
      E,
      dimensions.cardH,
      dimensions.cardW,
      dimensions.rotation,
      tunnelFadeLength,
      depthEffectIntensity,
      maxBlur,
      shadowIntensity,
      nearScale,
      farOpacity,
    ]
  );

  // Initialize card positions
  useEffect(() => {
    const farZ = -E;
    positionsRef.current = Array.from({ length: T }, (_, idx) => farZ + idx * dimensions.spacing);
    updateCardTransforms(positionsRef.current);
  }, [T, E, dimensions.spacing, updateCardTransforms]);

  // Main animation rAF loop
  useEffect(() => {
    if (!autoplay) return;

    const nearZ = Math.max(dimensions.cardH, dimensions.cardW) * 1.2;
    const positions = positionsRef.current;

    const tick = (timestamp) => {
      if (lastTimeRef.current === 0) lastTimeRef.current = timestamp;
      const delta = Math.min(0.05, (timestamp - lastTimeRef.current) / 1000);
      lastTimeRef.current = timestamp;

      // Parallax lerp
      currentRotXRef.current += (targetRotXRef.current - currentRotXRef.current) * 0.08;
      currentRotYRef.current += (targetRotYRef.current - currentRotYRef.current) * 0.08;
      updateParallax();

      if (!isPausedRef.current && !activeModalItem && !isDraggingRef.current) {
        const offset = speed * delta;
        for (let i = 0; i < T; i++) {
          let pos = positions[i] + offset;
          if (pos > nearZ) {
            pos -= E;
          }
          positions[i] = pos;
        }
        updateCardTransforms(positions);
      }

      rafIdRef.current = requestAnimationFrame(tick);
    };

    rafIdRef.current = requestAnimationFrame(tick);

    return () => {
      lastTimeRef.current = 0;
      if (rafIdRef.current) {
        cancelAnimationFrame(rafIdRef.current);
        rafIdRef.current = null;
      }
    };
  }, [autoplay, speed, T, E, dimensions.cardH, dimensions.cardW, updateCardTransforms, updateParallax, activeModalItem]);

  // Mouse Parallax handlers
  const handlePointerMove = useCallback(
    (e) => {
      if (!parallaxEnabled || (disableParallaxOnMobile && isTouchRef.current)) return;
      const el = containerRef.current;
      if (!el) return;
      const rect = el.getBoundingClientRect();
      if (rect.width <= 0 || rect.height <= 0) return;

      const normX = (e.clientX - rect.left) / rect.width;
      const normY = (e.clientY - rect.top) / rect.height;
      const dirX = (normX - 0.5) * 2;
      const dirY = (normY - 0.5) * 2;
      const amt = Math.max(0, Math.min(8, parallaxAmount));

      targetRotYRef.current = dirX * amt;
      targetRotXRef.current = dirY * -amt;
    },
    [parallaxEnabled, disableParallaxOnMobile, parallaxAmount]
  );

  const handlePointerLeave = useCallback(() => {
    targetRotYRef.current = 0;
    targetRotXRef.current = 0;
  }, []);

  const handleMouseEnter = useCallback(() => {
    isHoveredContainerRef.current = true;
    if (pauseOnHover) {
      isPausedRef.current = true;
    }
  }, [pauseOnHover]);

  const handleMouseLeave = useCallback(() => {
    isHoveredContainerRef.current = false;
    isPausedRef.current = false;
    handlePointerLeave();
  }, [handlePointerLeave]);

  // Pointer drag scrubbing handlers
  const handlePointerDown = useCallback((e) => {
    if (e.button !== undefined && e.button !== 0) return;
    isDraggingRef.current = true;
    hasDraggedRef.current = false;
    dragStartXRef.current = e.clientX;
    dragStartYRef.current = e.clientY;
    dragStartPositionsRef.current = [...positionsRef.current];
  }, []);

  const handlePointerMoveWithDrag = useCallback(
    (e) => {
      handlePointerMove(e);
      if (!isDraggingRef.current) return;

      const dx = e.clientX - dragStartXRef.current;
      const dy = e.clientY - dragStartYRef.current;

      if (!hasDraggedRef.current && Math.hypot(dx, dy) > 8) {
        hasDraggedRef.current = true;
        setIsDragging(true);
      }

      if (hasDraggedRef.current && dragStartPositionsRef.current.length === T) {
        const nearZ = Math.max(dimensions.cardH, dimensions.cardW) * 1.2;
        const positions = positionsRef.current;
        const dragDelta = -dy * 3.2 + dx * 1.8;

        for (let i = 0; i < T; i++) {
          let pos = dragStartPositionsRef.current[i] + dragDelta;
          while (pos > nearZ) pos -= E;
          while (pos < -E) pos += E;
          positions[i] = pos;
        }
        updateCardTransforms(positions);
      }
    },
    [handlePointerMove, dimensions.cardH, dimensions.cardW, T, E, updateCardTransforms]
  );

  const handlePointerUp = useCallback(() => {
    if (isDraggingRef.current) {
      isDraggingRef.current = false;
      setIsDragging(false);
      setTimeout(() => {
        hasDraggedRef.current = false;
      }, 60);
    }
  }, []);

  // Modal navigation helpers
  const handlePrevReason = useCallback(() => {
    if (!activeModalItem || normalizedItems.length === 0) return;
    const currIdx = normalizedItems.findIndex((it) => it.num === activeModalItem.num);
    const prevIdx = (currIdx - 1 + normalizedItems.length) % normalizedItems.length;
    setActiveModalItem(normalizedItems[prevIdx]);
  }, [activeModalItem, normalizedItems]);

  const handleNextReason = useCallback(() => {
    if (!activeModalItem || normalizedItems.length === 0) return;
    const currIdx = normalizedItems.findIndex((it) => it.num === activeModalItem.num);
    const nextIdx = (currIdx + 1) % normalizedItems.length;
    setActiveModalItem(normalizedItems[nextIdx]);
  }, [activeModalItem, normalizedItems]);

  // Keyboard navigation for modal
  useEffect(() => {
    if (!activeModalItem) return;
    const handleKeyDown = (e) => {
      if (e.key === 'Escape') {
        setActiveModalItem(null);
      } else if (e.key === 'ArrowLeft') {
        handlePrevReason();
      } else if (e.key === 'ArrowRight') {
        handleNextReason();
      }
    };
    window.addEventListener('keydown', handleKeyDown);
    return () => window.removeEventListener('keydown', handleKeyDown);
  }, [activeModalItem, handlePrevReason, handleNextReason]);

  // Items distribution for left and right rails
  const leftRailItems = useMemo(() => {
    return Array.from({ length: T }, (_, idx) => {
      const item = normalizedItems[idx % normalizedItems.length];
      return { ...item, railIndex: idx, railSide: 'left' };
    });
  }, [T, normalizedItems]);

  const rightRailItems = useMemo(() => {
    const half = Math.floor(normalizedItems.length / 2) || 1;
    return Array.from({ length: T }, (_, idx) => {
      const item = normalizedItems[(idx + half) % normalizedItems.length];
      return { ...item, railIndex: idx, railSide: 'right' };
    });
  }, [T, normalizedItems]);

  const renderCardContent = (item) => (
    <div
      style={{
        position: 'relative',
        width: '100%',
        height: '100%',
        borderRadius: 16,
        overflow: 'hidden',
        border: '1px solid rgba(0, 242, 254, 0.28)',
        backgroundColor: '#070D1E',
        userSelect: 'none',
        cursor: 'pointer',
        transition: 'border-color 0.2s ease',
      }}
    >
      {/* Background Image */}
      {item.imageSrc ? (
        <img
          src={item.imageSrc}
          alt={item.alt}
          loading="lazy"
          style={{
            position: 'absolute',
            inset: 0,
            width: '100%',
            height: '100%',
            objectFit: 'cover',
            display: 'block',
            filter: 'contrast(1.08) saturate(1.1)',
          }}
        />
      ) : (
        <div
          style={{
            position: 'absolute',
            inset: 0,
            background: 'linear-gradient(135deg, #0EA5E9 0%, #2563EB 100%)',
          }}
        />
      )}

      {/* Cyberpunk Dark Glassmorphism Overlay */}
      <div
        style={{
          position: 'absolute',
          inset: 0,
          background:
            'linear-gradient(180deg, rgba(6, 11, 24, 0.25) 0%, rgba(6, 11, 24, 0.65) 45%, rgba(6, 11, 24, 0.96) 100%)',
          display: 'flex',
          flexDirection: 'column',
          justifyContent: 'space-between',
          padding: '16px',
        }}
      >
        {/* Top Header Badge */}
        <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center' }}>
          <span
            style={{
              fontFamily: "'JetBrains Mono', monospace",
              fontSize: '10px',
              fontWeight: 700,
              letterSpacing: '0.08em',
              textTransform: 'uppercase',
              color: '#00F2FE',
              background: 'rgba(0, 242, 254, 0.14)',
              border: '1px solid rgba(0, 242, 254, 0.45)',
              padding: '3px 8px',
              borderRadius: '4px',
              boxShadow: '0 0 12px rgba(0, 242, 254, 0.3)',
            }}
          >
            REASON #{item.num}
          </span>

          <span
            style={{
              width: '6px',
              height: '6px',
              borderRadius: '50%',
              backgroundColor: '#00F2FE',
              boxShadow: '0 0 8px #00F2FE',
            }}
          />
        </div>

        {/* Bottom Content Area */}
        <div>
          <h4
            style={{
              fontFamily: "'Space Grotesk', 'Inter', sans-serif",
              fontSize: dimensions.cardW < 200 ? '14px' : '17px',
              fontWeight: 700,
              color: '#FFFFFF',
              margin: '0 0 6px 0',
              lineHeight: 1.25,
              textShadow: '0 2px 8px rgba(0,0,0,0.85)',
            }}
          >
            {item.title}
          </h4>
          {dimensions.cardW >= 200 && (
            <p
              style={{
                fontFamily: "'Inter', sans-serif",
                fontSize: '12px',
                color: '#94A3B8',
                margin: '0 0 8px 0',
                lineHeight: 1.45,
                display: '-webkit-box',
                WebkitLineClamp: 3,
                WebkitBoxOrient: 'vertical',
                overflow: 'hidden',
                textOverflow: 'ellipsis',
              }}
            >
              {item.desc}
            </p>
          )}
          <div
            style={{
              display: 'flex',
              alignItems: 'center',
              gap: '6px',
              color: '#00F2FE',
              fontSize: '11px',
              fontFamily: "'JetBrains Mono', monospace",
              fontWeight: 600,
              letterSpacing: '0.04em',
              textTransform: 'uppercase',
            }}
          >
            <span>Inspect reason</span>
            <span style={{ fontSize: '13px' }}>→</span>
          </div>
        </div>
      </div>
    </div>
  );

  return (
    <div
      ref={containerRef}
      onPointerDown={handlePointerDown}
      onPointerMove={handlePointerMoveWithDrag}
      onPointerUp={handlePointerUp}
      onPointerCancel={handlePointerUp}
      onPointerLeave={handlePointerLeave}
      onMouseEnter={handleMouseEnter}
      onMouseLeave={handleMouseLeave}
      style={{
        position: 'relative',
        width: '100%',
        height: '620px',
        overflow: 'hidden',
        background: backgroundColor,
        touchAction: 'pan-y',
        borderRadius: 24,
        cursor: isDragging ? 'grabbing' : 'default',
        ...style,
      }}
    >
      {/* 3D Perspective Stage — pointerEvents: 'none' ensures ray-testing passes directly to cards */}
      <div
        ref={perspectiveRef}
        style={{
          position: 'absolute',
          inset: 0,
          perspective: `${perspective}px`,
          perspectiveOrigin: '50% 50%',
          transformStyle: 'preserve-3d',
          pointerEvents: 'none',
        }}
      >
        <div
          ref={sceneRef}
          style={{
            position: 'absolute',
            inset: 0,
            transformStyle: 'preserve-3d',
            transform: 'rotateX(0deg) rotateY(0deg)',
            transition: 'none',
            willChange: 'transform',
            pointerEvents: 'none',
          }}
        >
          {/* Dual Rail Cards */}
          {leftRailItems.map((leftItem, idx) => {
            const rightItem = rightRailItems[idx];
            return (
              <React.Fragment key={`rail-pair-${idx}`}>
                {/* Left Rail Card */}
                <div
                  ref={(el) => {
                    if (el) leftCardsRef.current[idx] = el;
                  }}
                  onClick={(e) => {
                    e.stopPropagation();
                    if (!hasDraggedRef.current) setActiveModalItem(leftItem);
                  }}
                  onMouseEnter={(e) => {
                    if (pauseOnHover) isPausedRef.current = true;
                    e.currentTarget.style.borderColor = 'rgba(0, 242, 254, 0.8)';
                  }}
                  onMouseLeave={(e) => {
                    if (pauseOnHover && !isHoveredContainerRef.current) isPausedRef.current = false;
                    e.currentTarget.style.borderColor = 'rgba(0, 242, 254, 0.28)';
                  }}
                  role="button"
                  tabIndex={0}
                  aria-label={`Inspect ${leftItem.title}`}
                  style={{
                    position: 'absolute',
                    top: '50%',
                    left: '50%',
                    width: dimensions.cardW,
                    height: dimensions.cardH,
                    borderRadius: 16,
                    overflow: 'hidden',
                    backfaceVisibility: 'hidden',
                    transformStyle: 'preserve-3d',
                    willChange: 'transform, opacity, filter, box-shadow',
                    pointerEvents: 'auto',
                    cursor: 'pointer',
                  }}
                >
                  {renderCardContent(leftItem)}
                </div>

                {/* Right Rail Card */}
                <div
                  ref={(el) => {
                    if (el) rightCardsRef.current[idx] = el;
                  }}
                  onClick={(e) => {
                    e.stopPropagation();
                    if (!hasDraggedRef.current) setActiveModalItem(rightItem);
                  }}
                  onMouseEnter={(e) => {
                    if (pauseOnHover) isPausedRef.current = true;
                    e.currentTarget.style.borderColor = 'rgba(0, 242, 254, 0.8)';
                  }}
                  onMouseLeave={(e) => {
                    if (pauseOnHover && !isHoveredContainerRef.current) isPausedRef.current = false;
                    e.currentTarget.style.borderColor = 'rgba(0, 242, 254, 0.28)';
                  }}
                  role="button"
                  tabIndex={0}
                  aria-label={`Inspect ${rightItem.title}`}
                  style={{
                    position: 'absolute',
                    top: '50%',
                    left: '50%',
                    width: dimensions.cardW,
                    height: dimensions.cardH,
                    borderRadius: 16,
                    overflow: 'hidden',
                    backfaceVisibility: 'hidden',
                    transformStyle: 'preserve-3d',
                    willChange: 'transform, opacity, filter, box-shadow',
                    pointerEvents: 'auto',
                    cursor: 'pointer',
                  }}
                >
                  {renderCardContent(rightItem)}
                </div>
              </React.Fragment>
            );
          })}
        </div>
      </div>

      {/* Center Open Horizon HUD Accent */}
      <div
        style={{
          position: 'absolute',
          top: '50%',
          left: '50%',
          transform: 'translate(-50%, -50%)',
          pointerEvents: 'none',
          display: 'flex',
          flexDirection: 'column',
          alignItems: 'center',
          gap: '8px',
          opacity: 0.85,
        }}
      >
        <div
          style={{
            width: '1px',
            height: '40px',
            background: 'linear-gradient(180deg, rgba(0,242,254,0) 0%, #00F2FE 100%)',
          }}
        />
        <span
          style={{
            fontFamily: "'JetBrains Mono', monospace",
            fontSize: '11px',
            letterSpacing: '0.14em',
            textTransform: 'uppercase',
            color: '#00F2FE',
            background: 'rgba(3, 7, 18, 0.75)',
            border: '1px solid rgba(0, 242, 254, 0.3)',
            padding: '4px 12px',
            borderRadius: '20px',
            backdropFilter: 'blur(8px)',
            boxShadow: '0 0 15px rgba(0,242,254,0.18)',
          }}
        >
          16 Core Principles
        </span>
        <div
          style={{
            width: '1px',
            height: '40px',
            background: 'linear-gradient(180deg, #00F2FE 0%, rgba(0,242,254,0) 100%)',
          }}
        />
      </div>

      {/* Top and Bottom Horizon Vignettes */}
      <div
        style={{
          position: 'absolute',
          top: 0,
          left: 0,
          right: 0,
          height: '90px',
          background: 'linear-gradient(180deg, #030712 0%, rgba(3,7,18,0) 100%)',
          pointerEvents: 'none',
        }}
      />
      <div
        style={{
          position: 'absolute',
          bottom: 0,
          left: 0,
          right: 0,
          height: '90px',
          background: 'linear-gradient(0deg, #030712 0%, rgba(3,7,18,0) 100%)',
          pointerEvents: 'none',
        }}
      />

      {/* Left and Right Vignettes for depth transition */}
      <div
        style={{
          position: 'absolute',
          top: 0,
          left: 0,
          bottom: 0,
          width: '50px',
          background: 'linear-gradient(90deg, #030712 0%, rgba(3,7,18,0) 100%)',
          pointerEvents: 'none',
        }}
      />
      <div
        style={{
          position: 'absolute',
          top: 0,
          right: 0,
          bottom: 0,
          width: '50px',
          background: 'linear-gradient(270deg, #030712 0%, rgba(3,7,18,0) 100%)',
          pointerEvents: 'none',
        }}
      />

      {/* Interactive Detail Modal when clicking any card */}
      {activeModalItem && (
        <div
          style={{
            position: 'absolute',
            inset: 0,
            zIndex: 100000,
            background: 'rgba(3, 7, 18, 0.88)',
            backdropFilter: 'blur(16px)',
            display: 'flex',
            alignItems: 'center',
            justifyContent: 'center',
            padding: '24px',
            animation: 'fadeIn 0.2s ease-out',
            pointerEvents: 'auto',
          }}
          onClick={() => setActiveModalItem(null)}
        >
          <div
            style={{
              position: 'relative',
              maxWidth: '580px',
              width: '100%',
              backgroundColor: '#070D1E',
              border: '1px solid rgba(0, 242, 254, 0.45)',
              borderRadius: '20px',
              overflow: 'hidden',
              boxShadow: '0 25px 50px -12px rgba(0, 0, 0, 0.85), 0 0 35px rgba(0, 242, 254, 0.3)',
            }}
            onClick={(e) => e.stopPropagation()}
          >
            {/* Top Bar with Badge, Counter and Close Icon */}
            <div
              style={{
                display: 'flex',
                alignItems: 'center',
                justifyContent: 'space-between',
                padding: '16px 20px',
                borderBottom: '1px solid rgba(0, 242, 254, 0.15)',
                background: 'rgba(6, 11, 24, 0.6)',
              }}
            >
              <div style={{ display: 'flex', alignItems: 'center', gap: '10px' }}>
                <span
                  style={{
                    fontFamily: "'JetBrains Mono', monospace",
                    fontSize: '11px',
                    fontWeight: 700,
                    letterSpacing: '0.08em',
                    color: '#00F2FE',
                    background: 'rgba(0, 242, 254, 0.12)',
                    border: '1px solid rgba(0, 242, 254, 0.4)',
                    padding: '4px 10px',
                    borderRadius: '4px',
                  }}
                >
                  REASON #{activeModalItem.num}
                </span>
                <span
                  style={{
                    fontFamily: "'Space Grotesk', sans-serif",
                    fontSize: '12px',
                    color: '#64748B',
                  }}
                >
                  {normalizedItems.findIndex((it) => it.num === activeModalItem.num) + 1} of {normalizedItems.length}
                </span>
              </div>

              <button
                type="button"
                onClick={() => setActiveModalItem(null)}
                aria-label="Close"
                style={{
                  background: 'rgba(255, 255, 255, 0.06)',
                  border: '1px solid rgba(255, 255, 255, 0.12)',
                  borderRadius: '50%',
                  width: '32px',
                  height: '32px',
                  display: 'flex',
                  alignItems: 'center',
                  justifyContent: 'center',
                  color: '#94A3B8',
                  cursor: 'pointer',
                  fontSize: '16px',
                  lineHeight: 1,
                  transition: 'all 0.15s ease',
                }}
                onMouseEnter={(e) => {
                  e.currentTarget.style.color = '#FFFFFF';
                  e.currentTarget.style.borderColor = 'rgba(0, 242, 254, 0.5)';
                  e.currentTarget.style.backgroundColor = 'rgba(0, 242, 254, 0.15)';
                }}
                onMouseLeave={(e) => {
                  e.currentTarget.style.color = '#94A3B8';
                  e.currentTarget.style.borderColor = 'rgba(255, 255, 255, 0.12)';
                  e.currentTarget.style.backgroundColor = 'rgba(255, 255, 255, 0.06)';
                }}
              >
                ✕
              </button>
            </div>

            {/* Artwork Banner */}
            {activeModalItem.imageSrc && (
              <div style={{ position: 'relative', width: '100%', height: '220px', overflow: 'hidden' }}>
                <img
                  src={activeModalItem.imageSrc}
                  alt={activeModalItem.alt}
                  style={{
                    width: '100%',
                    height: '100%',
                    objectFit: 'cover',
                    filter: 'contrast(1.05) saturate(1.1)',
                  }}
                />
                <div
                  style={{
                    position: 'absolute',
                    inset: 0,
                    background:
                      'linear-gradient(180deg, rgba(7,13,30,0) 0%, rgba(7,13,30,0.85) 70%, rgba(7,13,30,1) 100%)',
                  }}
                />
              </div>
            )}

            {/* Content Body */}
            <div style={{ padding: '24px 24px 20px 24px' }}>
              <h3
                style={{
                  fontFamily: "'Space Grotesk', sans-serif",
                  fontSize: '22px',
                  fontWeight: 700,
                  color: '#FFFFFF',
                  margin: '0 0 12px 0',
                  lineHeight: 1.25,
                }}
              >
                {activeModalItem.title}
              </h3>
              <p
                style={{
                  fontFamily: "'Inter', sans-serif",
                  fontSize: '15px',
                  color: '#CBD5E1',
                  lineHeight: 1.65,
                  margin: '0 0 24px 0',
                }}
              >
                {activeModalItem.desc}
              </p>

              {/* Bottom Actions: Prev / Next Buttons */}
              <div
                style={{
                  display: 'flex',
                  alignItems: 'center',
                  justifyContent: 'space-between',
                  paddingTop: '16px',
                  borderTop: '1px solid rgba(255, 255, 255, 0.08)',
                }}
              >
                <div style={{ display: 'flex', gap: '8px' }}>
                  <button
                    type="button"
                    onClick={handlePrevReason}
                    style={{
                      background: 'rgba(255, 255, 255, 0.06)',
                      color: '#E2E8F0',
                      border: '1px solid rgba(255, 255, 255, 0.15)',
                      borderRadius: '8px',
                      padding: '8px 14px',
                      fontSize: '13px',
                      fontWeight: 600,
                      cursor: 'pointer',
                      fontFamily: "'Space Grotesk', sans-serif",
                      display: 'flex',
                      alignItems: 'center',
                      gap: '6px',
                      transition: 'all 0.15s ease',
                    }}
                    onMouseEnter={(e) => {
                      e.currentTarget.style.borderColor = '#00F2FE';
                      e.currentTarget.style.color = '#00F2FE';
                    }}
                    onMouseLeave={(e) => {
                      e.currentTarget.style.borderColor = 'rgba(255, 255, 255, 0.15)';
                      e.currentTarget.style.color = '#E2E8F0';
                    }}
                  >
                    ← Previous
                  </button>

                  <button
                    type="button"
                    onClick={handleNextReason}
                    style={{
                      background: 'rgba(255, 255, 255, 0.06)',
                      color: '#E2E8F0',
                      border: '1px solid rgba(255, 255, 255, 0.15)',
                      borderRadius: '8px',
                      padding: '8px 14px',
                      fontSize: '13px',
                      fontWeight: 600,
                      cursor: 'pointer',
                      fontFamily: "'Space Grotesk', sans-serif",
                      display: 'flex',
                      alignItems: 'center',
                      gap: '6px',
                      transition: 'all 0.15s ease',
                    }}
                    onMouseEnter={(e) => {
                      e.currentTarget.style.borderColor = '#00F2FE';
                      e.currentTarget.style.color = '#00F2FE';
                    }}
                    onMouseLeave={(e) => {
                      e.currentTarget.style.borderColor = 'rgba(255, 255, 255, 0.15)';
                      e.currentTarget.style.color = '#E2E8F0';
                    }}
                  >
                    Next →
                  </button>
                </div>

                <button
                  type="button"
                  onClick={() => setActiveModalItem(null)}
                  style={{
                    background: 'linear-gradient(135deg, #00F2FE 0%, #4FACFE 100%)',
                    color: '#030712',
                    border: 'none',
                    borderRadius: '8px',
                    padding: '8px 18px',
                    fontSize: '13px',
                    fontWeight: 700,
                    cursor: 'pointer',
                    fontFamily: "'Space Grotesk', sans-serif",
                    boxShadow: '0 0 15px rgba(0, 242, 254, 0.3)',
                  }}
                >
                  Close
                </button>
              </div>
            </div>
          </div>
        </div>
      )}
    </div>
  );
}
