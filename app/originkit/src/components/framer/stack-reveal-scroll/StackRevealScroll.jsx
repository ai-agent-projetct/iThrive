import { useEffect, useRef, useState } from 'react';
import { motion, useScroll, useSpring, useTransform } from 'framer-motion';

function getBreakpoint(width) {
  if (width < 640) return 'mobile';
  if (width < 1024) return 'tablet';
  return 'desktop';
}

function PanelCard({
  item,
  index,
  smoothProgress,
  start,
  end,
  sliver,
  isNarrow,
  borderWidth,
  borderColor,
  panelPadding,
  numberContentGap,
  headingDescriptionGap,
  headingMaxWidth,
  descriptionMaxWidth,
  numberFont,
  headingFont,
  descriptionFont,
}) {
  const x = useTransform(
    smoothProgress,
    index === 0 ? [0, 0.001] : [start, end],
    index === 0 ? ['0vw', '0vw'] : ['100vw', `${index * sliver}vw`],
    { clamp: true }
  );

  const numberRef = useRef(null);
  const [numberHeight, setNumberHeight] = useState(null);

  useEffect(() => {
    const el = numberRef.current;
    if (!el || typeof ResizeObserver === 'undefined') return;
    setNumberHeight(el.offsetHeight);
    const ro = new ResizeObserver(() => setNumberHeight(el.offsetHeight));
    ro.observe(el);
    return () => ro.disconnect();
  }, [item.bigText, isNarrow]);

  const panelBg = item.bgColor || '#06080e';
  const panelBorder = item.borderColor || borderColor;
  const numColor = item.numberColor || item.titleColor || '#22d3ee';
  const titleColor = item.titleColor || '#ffffff';
  const descColor = item.descriptionColor || 'rgba(255, 255, 255, 0.75)';

  return (
    <motion.div
      style={{
        position: 'absolute',
        inset: 0,
        background: panelBg,
        x,
        zIndex: index + 1,
        boxShadow: index > 0 ? '-24px 0 48px rgba(0, 0, 0, 0.7), -4px 0 16px rgba(0, 0, 0, 0.5)' : 'none',
        overflow: 'hidden',
      }}
    >
      {/* Ambient glow */}
      <div
        style={{
          position: 'absolute',
          top: '-10%',
          right: '-5%',
          width: '550px',
          height: '550px',
          borderRadius: '50%',
          background: `radial-gradient(circle, ${numColor}22 0%, transparent 70%)`,
          pointerEvents: 'none',
          zIndex: 0,
        }}
      />

      <div
        style={{
          position: 'absolute',
          inset: 0,
          boxSizing: 'border-box',
          padding: isNarrow ? '32px 24px 72px 24px' : panelPadding,
          display: 'flex',
          flexDirection: 'column',
          justifyContent: isNarrow ? 'center' : 'flex-end',
          alignItems: 'flex-start',
          borderLeft: borderWidth > 0 && index > 0 ? `${borderWidth}px solid ${panelBorder}` : 'none',
          zIndex: 1,
        }}
      >
        <div
          style={{
            display: 'flex',
            flexDirection: isNarrow ? 'column' : 'row',
            alignItems: isNarrow ? 'flex-start' : 'center',
            gap: `${numberContentGap}px`,
            width: '100%',
            minWidth: 0,
          }}
        >
          {/* Big Number */}
          <div
            ref={numberRef}
            style={{
              flex: '0 0 auto',
              color: numColor,
              userSelect: 'none',
              fontFamily: '"Space Grotesk", system-ui, sans-serif',
              fontWeight: 700,
              fontSize: isNarrow ? 'clamp(100px, 24vw, 180px)' : 'clamp(200px, 20vw, 340px)',
              lineHeight: 0.8,
              letterSpacing: '-0.04em',
              ...numberFont,
            }}
          >
            {item.bigText ?? (index + 1)}
          </div>

          {/* Title & Description Block */}
          <div
            style={{
              flex: '0 1 auto',
              display: 'flex',
              flexDirection: 'column',
              justifyContent: 'center',
              gap: `${headingDescriptionGap}px`,
              maxWidth: descriptionMaxWidth,
              minWidth: 0,
              paddingBottom: isNarrow ? 0 : '16px',
            }}
          >
            {item.badge && (
              <div
                style={{
                  color: numColor,
                  fontSize: '13px',
                  fontWeight: 600,
                  letterSpacing: '0.12em',
                  textTransform: 'uppercase',
                  marginBottom: '4px',
                  display: 'flex',
                  alignItems: 'center',
                  gap: '8px',
                }}
              >
                <span
                  style={{
                    width: '6px',
                    height: '6px',
                    borderRadius: '50%',
                    background: numColor,
                    boxShadow: `0 0 10px ${numColor}`,
                    display: 'inline-block',
                  }}
                />
                {item.badge}
              </div>
            )}
            <h3
              style={{
                margin: 0,
                maxWidth: headingMaxWidth,
                color: titleColor,
                fontFamily: '"Space Grotesk", system-ui, sans-serif',
                fontWeight: 700,
                fontSize: isNarrow ? '24px' : 'clamp(26px, 2.4vw, 36px)',
                lineHeight: 1.2,
                letterSpacing: '-0.02em',
                ...headingFont,
              }}
            >
              {item.title}
            </h3>
            <p
              style={{
                margin: 0,
                maxWidth: descriptionMaxWidth,
                color: descColor,
                fontFamily: '"Inter", system-ui, sans-serif',
                fontWeight: 400,
                fontSize: isNarrow ? '15px' : 'clamp(15px, 1.25vw, 18px)',
                lineHeight: 1.6,
                opacity: 0.9,
                ...descriptionFont,
              }}
            >
              {item.description}
            </p>
            {item.tag && (
              <div
                style={{
                  display: 'inline-flex',
                  alignItems: 'center',
                  gap: '6px',
                  marginTop: '10px',
                  padding: '5px 12px',
                  borderRadius: '999px',
                  background: 'rgba(255, 255, 255, 0.05)',
                  border: `1px solid ${panelBorder || 'rgba(255, 255, 255, 0.12)'}`,
                  color: numColor,
                  fontSize: '12px',
                  fontWeight: 600,
                  letterSpacing: '0.04em',
                  textTransform: 'uppercase',
                  width: 'fit-content',
                }}
              >
                <span>{item.tag}</span>
                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5">
                  <path d="M5 12h14M12 5l7 7-7 7" strokeLinecap="round" strokeLinejoin="round"/>
                </svg>
              </div>
            )}
          </div>
        </div>
      </div>
    </motion.div>
  );
}

export default function StackRevealScroll(props) {
  const {
    panels = [],
    topSpacing = 0,
    panelHeight = 100,
    sliverDesktop = 9.7,
    sliverTablet = 6.0,
    sliverMobile = 4.0,
    revealRatio = 0.55,
    scrollTransition = { type: 'spring', stiffness: 260, damping: 32, mass: 1 },
    numberFont = {},
    headingFont = {},
    descriptionFont = {},
    headingMaxWidth = 460,
    descriptionMaxWidth = 480,
    numberContentGap = 28,
    headingDescriptionGap = 10,
    panelPadding = '40px clamp(24px, 4vw, 64px)',
    containerBg = 'transparent',
    borderWidth = 1,
    borderColor = 'rgba(255, 255, 255, 0.12)',
  } = props;

  const containerRef = useRef(null);
  const [breakpoint, setBreakpoint] = useState('desktop');

  useEffect(() => {
    const el = containerRef.current;
    if (!el || typeof ResizeObserver === 'undefined') return;
    setBreakpoint(getBreakpoint(el.offsetWidth));
    const ro = new ResizeObserver(([entry]) => {
      const w = entry?.contentRect?.width ?? el.offsetWidth;
      setBreakpoint(getBreakpoint(w));
    });
    ro.observe(el);
    return () => ro.disconnect();
  }, []);

  const isNarrow = breakpoint === 'mobile';
  const sliver = breakpoint === 'mobile' ? sliverMobile : breakpoint === 'tablet' ? sliverTablet : sliverDesktop;
  const count = Math.max(panels.length, 1);
  const totalHeightVh = topSpacing + count * panelHeight;

  const { scrollYProgress } = useScroll({
    target: containerRef,
    offset: ['start start', 'end end'],
  });

  const smoothProgress = useSpring(scrollYProgress, scrollTransition);

  const startOffset = totalHeightVh > 0 ? topSpacing / totalHeightVh : 0;
  const availableScroll = 1 - startOffset;
  const step = availableScroll / count;

  return (
    <div
      ref={containerRef}
      style={{
        position: 'relative',
        width: '100%',
        height: `${totalHeightVh}vh`,
        background: containerBg,
      }}
    >
      {topSpacing > 0 && <div style={{ width: '100%', height: `${topSpacing}vh` }} />}
      <div
        style={{
          position: 'sticky',
          top: 0,
          width: '100%',
          height: '100vh',
          overflow: 'hidden',
          background: containerBg,
        }}
      >
        {panels.map((item, index) => {
          const start = startOffset + index * step * 0.85;
          const end = Math.min(start + step * revealRatio, 1);

          return (
            <PanelCard
              key={index}
              item={item}
              index={index}
              smoothProgress={smoothProgress}
              start={start}
              end={end}
              sliver={sliver}
              isNarrow={isNarrow}
              borderWidth={borderWidth}
              borderColor={borderColor}
              panelPadding={panelPadding}
              numberContentGap={numberContentGap}
              headingDescriptionGap={headingDescriptionGap}
              headingMaxWidth={headingMaxWidth}
              descriptionMaxWidth={descriptionMaxWidth}
              numberFont={numberFont}
              headingFont={headingFont}
              descriptionFont={descriptionFont}
            />
          );
        })}
      </div>
    </div>
  );
}
