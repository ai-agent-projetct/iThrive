import React, {
  useCallback,
  useEffect,
  useLayoutEffect,
  useMemo,
  useRef,
  useState,
} from 'react';

const LAYOUT = [
  // ---------------------------- LEFT WALL ----------------------------
  { surface: 'left', offset: -0.34, cross: 0.3, span: 0.62, depth: 0.045, index: 0 },
  { surface: 'left', offset: 0.36, cross: 0.22, span: 0.3, depth: 0.075, index: 8 },
  { surface: 'left', offset: 0.06, cross: 0.4, span: 0.7, depth: 0.145, index: 1 },
  { surface: 'left', offset: -0.52, cross: 0.18, span: 0.42, depth: 0.205, index: 9 },
  { surface: 'left', offset: 0.44, cross: 0.26, span: 0.52, depth: 0.255, index: 2 },
  { surface: 'left', offset: -0.18, cross: 0.34, span: 0.44, depth: 0.335, index: 10 },
  { surface: 'left', offset: 0.2, cross: 0.3, span: 0.66, depth: 0.395, index: 3 },
  { surface: 'left', offset: -0.46, cross: 0.24, span: 0.36, depth: 0.475, index: 4 },
  { surface: 'left', offset: 0.3, cross: 0.2, span: 0.3, depth: 0.535, index: 11 },
  { surface: 'left', offset: -0.1, cross: 0.36, span: 0.58, depth: 0.605, index: 5 },
  { surface: 'left', offset: 0.48, cross: 0.22, span: 0.4, depth: 0.695, index: 2 },
  { surface: 'left', offset: -0.36, cross: 0.28, span: 0.5, depth: 0.775, index: 6 },
  { surface: 'left', offset: 0.14, cross: 0.24, span: 0.34, depth: 0.865, index: 6 },
  { surface: 'left', offset: -0.28, cross: 0.3, span: 0.46, depth: 0.935, index: 7 },

  // --------------------------- RIGHT WALL ----------------------------
  { surface: 'right', offset: 0.32, cross: 0.26, span: 0.44, depth: 0.03, index: 4 },
  { surface: 'right', offset: -0.24, cross: 0.36, span: 0.68, depth: 0.095, index: 8 },
  { surface: 'right', offset: 0.5, cross: 0.18, span: 0.28, depth: 0.17, index: 2 },
  { surface: 'right', offset: -0.06, cross: 0.42, span: 0.56, depth: 0.23, index: 9 },
  { surface: 'right', offset: 0.38, cross: 0.24, span: 0.38, depth: 0.31, index: 10 },
  { surface: 'right', offset: -0.44, cross: 0.22, span: 0.46, depth: 0.37, index: 0 },
  { surface: 'right', offset: 0.1, cross: 0.34, span: 0.64, depth: 0.445, index: 11 },
  { surface: 'right', offset: -0.34, cross: 0.28, span: 0.34, depth: 0.52, index: 3 },
  { surface: 'right', offset: 0.44, cross: 0.2, span: 0.42, depth: 0.585, index: 1 },
  { surface: 'right', offset: -0.14, cross: 0.32, span: 0.52, depth: 0.665, index: 4 },
  { surface: 'right', offset: 0.26, cross: 0.24, span: 0.3, depth: 0.74, index: 1 },
  { surface: 'right', offset: -0.48, cross: 0.26, span: 0.48, depth: 0.82, index: 6 },
  { surface: 'right', offset: 0.06, cross: 0.3, span: 0.4, depth: 0.9, index: 5 },

  // ----------------------------- CEILING -----------------------------
  { surface: 'ceiling', offset: -0.22, cross: 0.4, span: 0.7, depth: 0.115, index: 2 },
  { surface: 'ceiling', offset: 0.34, cross: 0.28, span: 0.44, depth: 0.29, index: 4 },
  { surface: 'ceiling', offset: -0.06, cross: 0.46, span: 0.8, depth: 0.43, index: 5 },
  { surface: 'ceiling', offset: 0.4, cross: 0.24, span: 0.36, depth: 0.61, index: 6 },
  { surface: 'ceiling', offset: -0.3, cross: 0.36, span: 0.6, depth: 0.78, index: 9 },
  { surface: 'ceiling', offset: 0.18, cross: 0.3, span: 0.42, depth: 0.925, index: 2 },

  // ------------------------------ FLOOR ------------------------------
  { surface: 'floor', offset: 0.3, cross: 0.26, span: 0.4, depth: 0.06, index: 1 },
  { surface: 'floor', offset: -0.34, cross: 0.3, span: 0.52, depth: 0.16, index: 3 },
  { surface: 'floor', offset: 0.08, cross: 0.22, span: 0.3, depth: 0.245, index: 5 },
  { surface: 'floor', offset: 0.42, cross: 0.24, span: 0.44, depth: 0.355, index: 7 },
  { surface: 'floor', offset: -0.2, cross: 0.34, span: 0.58, depth: 0.47, index: 10 },
  { surface: 'floor', offset: 0.24, cross: 0.2, span: 0.28, depth: 0.56, index: 3 },
  { surface: 'floor', offset: -0.44, cross: 0.26, span: 0.46, depth: 0.68, index: 0 },
  { surface: 'floor', offset: 0.12, cross: 0.3, span: 0.5, depth: 0.8, index: 8 },
  { surface: 'floor', offset: -0.16, cross: 0.24, span: 0.34, depth: 0.89, index: 4 },
  { surface: 'floor', offset: 0.36, cross: 0.28, span: 0.42, depth: 0.96, index: 11 },
];

const MOBILE_KEEP_EVERY = 2;
const DEPTH_SPAN_SCALE = 2.2;
const BOOST_MAX = 2.6;
const BOOST_EASE = 1.4;

function clamp(v, min, max) {
  return v < min ? min : v > max ? max : v;
}

function resolveImage(value) {
  if (!value) return { src: '', srcSet: '', alt: '' };
  if (typeof value === 'string') return { src: value, srcSet: '', alt: '' };
  return {
    src: typeof value.src === 'string' ? value.src : '',
    srcSet: typeof value.srcSet === 'string' ? value.srcSet : '',
    alt: typeof value.alt === 'string' ? value.alt : (value.title || ''),
    num: value.num || '',
    title: value.title || '',
    desc: value.desc || '',
  };
}

function withAlpha(color, alpha) {
  const c = (color || '#FFFFFF').trim();
  const a = clamp(alpha, 0, 1);
  if (c.startsWith('rgb')) {
    const parts = c
      .slice(c.indexOf('(') + 1, c.lastIndexOf(')'))
      .split(/[,\s/]+/)
      .filter(Boolean)
      .map(Number);
    const [r = 255, g = 255, b = 255] = parts;
    const baseAlpha = parts.length > 3 && !Number.isNaN(parts[3]) ? parts[3] : 1;
    return `rgba(${r}, ${g}, ${b}, ${a * baseAlpha})`;
  }
  if (c.startsWith('hsl')) {
    const inner = c.slice(c.indexOf('(') + 1, c.lastIndexOf(')')).split('/')[0];
    return `hsl(${inner.trim()} / ${a})`;
  }
  const clean = c.replace('#', '');
  const full =
    clean.length === 3
      ? clean.split('').map((ch) => ch + ch).join('')
      : clean.slice(0, 6);
  const int = parseInt(full, 16);
  if (Number.isNaN(int)) return `rgba(255, 255, 255, ${a})`;
  return `rgba(${(int >> 16) & 255}, ${(int >> 8) & 255}, ${int & 255}, ${a})`;
}

function surfaceTransform(surface, geo, offset) {
  switch (surface) {
    case 'left':
      return `translate3d(${-geo.halfWidth}px, ${offset * geo.halfHeight}px, 0px) rotateY(90deg)`;
    case 'right':
      return `translate3d(${geo.halfWidth}px, ${offset * geo.halfHeight}px, 0px) rotateY(-90deg)`;
    case 'ceiling':
      return `translate3d(${offset * geo.halfWidth}px, ${-geo.halfHeight}px, 0px) rotateX(-90deg)`;
    case 'floor':
    default:
      return `translate3d(${offset * geo.halfWidth}px, ${geo.halfHeight}px, 0px) rotateX(90deg)`;
  }
}

function tileSize(spec, geo, scale, gap) {
  const isWall = spec.surface === 'left' || spec.surface === 'right';
  const acrossExtent = isWall ? geo.halfHeight * 2 : geo.halfWidth * 2;
  const across = acrossExtent * spec.cross * scale;
  const along = geo.bay * spec.span * scale * DEPTH_SPAN_SCALE;
  const width = isWall ? along : across;
  const height = isWall ? across : along;
  return {
    width: Math.max(8, width - gap),
    height: Math.max(8, height - gap),
  };
}

function TunnelTile({ spec, geo, scale, gap, image, placeholderColor, registerRef }) {
  const { width, height } = tileSize(spec, geo, scale, gap);
  const style = {
    position: 'absolute',
    left: '50%',
    top: '50%',
    width,
    height,
    marginLeft: -width / 2,
    marginTop: -height / 2,
    transformStyle: 'preserve-3d',
    overflow: 'hidden',
    backgroundColor: placeholderColor,
    borderRadius: '14px',
    border: '1px solid rgba(0, 242, 254, 0.35)',
    boxShadow: '0 16px 45px rgba(0, 0, 0, 0.85), 0 0 25px rgba(0, 242, 254, 0.18)',
  };

  const sizes = `${Math.max(16, Math.round(width * 1.6))}px`;

  return (
    <div ref={registerRef} style={style}>
      {image.src ? (
        <>
          <img
            src={image.src}
            srcSet={image.srcSet || undefined}
            sizes={image.srcSet ? sizes : undefined}
            alt={image.alt || image.title || ''}
            draggable={false}
            loading="lazy"
            decoding="async"
            style={{
              width: '100%',
              height: '100%',
              objectFit: 'cover',
              display: 'block',
              borderRadius: 0,
              pointerEvents: 'none',
              userSelect: 'none',
              opacity: 0.88,
              filter: 'contrast(1.05) saturate(1.1)',
            }}
          />
          <div
            style={{
              position: 'absolute',
              inset: 0,
              background:
                'linear-gradient(180deg, rgba(3,7,18,0.1) 0%, rgba(3,7,18,0.4) 40%, rgba(3,7,18,0.92) 100%)',
              pointerEvents: 'none',
            }}
          />
          {(image.num || image.title) && (
            <div
              style={{
                position: 'absolute',
                bottom: '12px',
                left: '12px',
                right: '12px',
                pointerEvents: 'none',
                display: 'flex',
                flexDirection: 'column',
                gap: '2px',
              }}
            >
              {image.num && (
                <span
                  style={{
                    fontFamily: 'monospace',
                    fontSize: '11px',
                    fontWeight: 700,
                    letterSpacing: '0.12em',
                    color: '#00F2FE',
                    textTransform: 'uppercase',
                    textShadow: '0 0 10px rgba(0,242,254,0.5)',
                  }}
                >
                  REASON #{image.num}
                </span>
              )}
              {image.title && (
                <h4
                  style={{
                    margin: 0,
                    fontSize: '13px',
                    fontWeight: 600,
                    lineHeight: 1.25,
                    color: '#F8FAFC',
                    textShadow: '0 2px 6px rgba(0,0,0,0.9)',
                  }}
                >
                  {image.title}
                </h4>
              )}
            </div>
          )}
        </>
      ) : null}
    </div>
  );
}

function TunnelFrame({ geo, lineColor, thickness, registerRef }) {
  const w = geo.halfWidth * 2;
  const h = geo.halfHeight * 2;
  const t = thickness;
  const sideHeight = Math.max(0, h - t * 2);
  const bar = (extra) => ({
    position: 'absolute',
    backgroundColor: lineColor,
    ...extra,
  });
  return (
    <div
      ref={registerRef}
      style={{
        position: 'absolute',
        left: '50%',
        top: '50%',
        width: w,
        height: h,
        marginLeft: -w / 2,
        marginTop: -h / 2,
        transformStyle: 'preserve-3d',
        pointerEvents: 'none',
      }}
    >
      <div style={bar({ left: 0, top: 0, width: w, height: t })} />
      <div style={bar({ left: 0, bottom: 0, width: w, height: t })} />
      <div style={bar({ left: 0, top: t, width: t, height: sideHeight })} />
      <div style={bar({ right: 0, top: t, width: t, height: sideHeight })} />
    </div>
  );
}

function TunnelSurfaceLine({ surface, offset, geo, lineColor, thickness }) {
  const isWall = surface === 'left' || surface === 'right';
  const width = isWall ? geo.depth : thickness;
  const height = isWall ? thickness : geo.depth;
  const base = surfaceTransform(surface, geo, offset);
  const dir = surface === 'left' || surface === 'ceiling' ? 1 : -1;
  const shift = isWall
    ? `translate3d(${dir * (geo.depth / 2)}px, 0px, 0px)`
    : `translate3d(0px, ${dir * (geo.depth / 2)}px, 0px)`;
  return (
    <div
      style={{
        position: 'absolute',
        left: '50%',
        top: '50%',
        width,
        height,
        marginLeft: -width / 2,
        marginTop: -height / 2,
        backgroundColor: lineColor,
        transform: `${base} ${shift}`,
        transformStyle: 'preserve-3d',
        pointerEvents: 'none',
      }}
    />
  );
}

function TunnelGrid({ geo, frameCount, lineColor, thickness, registerFrame }) {
  const frames = useMemo(() => Array.from({ length: frameCount }, (_, i) => i), [frameCount]);
  const lines = useMemo(
    () => [
      { surface: 'left', offset: -1 },
      { surface: 'left', offset: -0.34 },
      { surface: 'left', offset: 0.34 },
      { surface: 'left', offset: 1 },
      { surface: 'right', offset: -1 },
      { surface: 'right', offset: -0.34 },
      { surface: 'right', offset: 0.34 },
      { surface: 'right', offset: 1 },
      { surface: 'ceiling', offset: -0.5 },
      { surface: 'ceiling', offset: 0.5 },
      { surface: 'floor', offset: -0.5 },
      { surface: 'floor', offset: 0.5 },
    ],
    []
  );
  return (
    <div style={{ position: 'absolute', inset: 0, transformStyle: 'preserve-3d' }}>
      {lines.map((l, i) => (
        <TunnelSurfaceLine
          key={`line-${i}`}
          surface={l.surface}
          offset={l.offset}
          geo={geo}
          lineColor={lineColor}
          thickness={thickness}
        />
      ))}
      {frames.map((i) => (
        <TunnelFrame
          key={`frame-${i}`}
          geo={geo}
          lineColor={lineColor}
          thickness={thickness}
          registerRef={registerFrame(i)}
        />
      ))}
    </div>
  );
}

export default function InfiniteImageTunnel({
  images = [],
  startText = 'Explore Tunnel',
  showStartButton = false,
  autoStart = true,
  animationSpeed = 1,
  pauseOnHover = false,
  clickToToggle = true,
  mouseParallax = true,
  reducedMotion = false,
  perspective = 1800,
  tunnelDepth = 5200,
  backgroundColor = '#030712',
  showGrid = true,
  gridColor = '#00F2FE',
  gridOpacity = 0.28,
  gridThickness = 1,
  tileGap = 16,
  imageTileScale = 1.32,
  style = {},
}) {
  const containerRef = useRef(null);
  const sceneRef = useRef(null);
  const tileRefs = useRef([]);
  const frameRefs = useRef([]);
  const [size, setSize] = useState({ width: 1200, height: 680 });
  const [started, setStarted] = useState(autoStart);
  const [paused, setPaused] = useState(false);

  const rectRef = useRef(null);
  useLayoutEffect(() => {
    const el = containerRef.current;
    if (!el || typeof ResizeObserver === 'undefined') return;
    const apply = () => {
      const rect = el.getBoundingClientRect();
      rectRef.current = rect;
      if (rect.width > 0 && rect.height > 0) {
        setSize((prev) =>
          Math.abs(prev.width - rect.width) < 1 && Math.abs(prev.height - rect.height) < 1
            ? prev
            : { width: rect.width, height: rect.height }
        );
      }
    };
    apply();
    const ro = new ResizeObserver(apply);
    ro.observe(el);
    const invalidate = () => {
      rectRef.current = null;
    };
    window.addEventListener('scroll', invalidate, { passive: true });
    window.addEventListener('resize', invalidate, { passive: true });
    return () => {
      ro.disconnect();
      window.removeEventListener('scroll', invalidate);
      window.removeEventListener('resize', invalidate);
    };
  }, []);

  const isCompact = size.width < 640;
  const depth = clamp(tunnelDepth, 1000, 10000);
  const frameCount = isCompact ? 14 : 20;

  const geo = useMemo(
    () => ({
      halfWidth: Math.max(120, size.width / 2),
      halfHeight: Math.max(90, size.height / 2),
      depth,
      bay: depth / frameCount,
    }),
    [size.width, size.height, depth, frameCount]
  );

  const effectivePerspective = useMemo(() => {
    const base = clamp(perspective, 500, 3000);
    const ratio = clamp(size.width / 1400, 0.55, 1);
    return Math.round(base * ratio);
  }, [perspective, size.width]);

  const layout = useMemo(
    () => (isCompact ? LAYOUT.filter((_, i) => i % MOBILE_KEEP_EVERY !== 1) : LAYOUT),
    [isCompact]
  );

  const imageList = useMemo(() => {
    return (images || []).map(resolveImage).filter((e) => Boolean(e.src));
  }, [images]);

  const emptyImage = useMemo(() => ({ src: '', srcSet: '', alt: '' }), []);

  const tileZ = useRef(new Float64Array(0));
  const frameZ = useRef(new Float64Array(0));
  const baseTransforms = useRef([]);
  const rafRef = useRef(null);
  const lastTimeRef = useRef(0);
  const rampRef = useRef(autoStart ? 1 : 0);
  const boostRef = useRef(1);
  const holdRef = useRef(false);
  const pointerRef = useRef({ x: 0, y: 0 });
  const pointerTargetRef = useRef({ x: 0, y: 0 });
  const lastTileStyle = useRef([]);
  const lastFrameStyle = useRef([]);
  const lastSceneTransform = useRef({ x: Number.NaN, y: Number.NaN });
  const startedRef = useRef(started);
  const pausedRef = useRef(paused);
  const hoverRef = useRef(false);
  const visibleRef = useRef(true);
  const wakeRef = useRef(() => {});

  startedRef.current = started;
  pausedRef.current = paused;

  const seedDepths = useCallback(() => {
    const t = new Float64Array(layout.length);
    for (let i = 0; i < layout.length; i++) t[i] = layout[i].depth * depth;
    tileZ.current = t;

    const f = new Float64Array(frameCount);
    for (let i = 0; i < frameCount; i++) f[i] = (i / frameCount) * depth;
    frameZ.current = f;

    lastTileStyle.current = [];
    lastFrameStyle.current = [];
  }, [layout, depth, frameCount]);

  useEffect(() => {
    seedDepths();
  }, [seedDepths]);

  useEffect(() => {
    baseTransforms.current = layout.map((spec) => {
      const base = surfaceTransform(spec.surface, geo, spec.offset);
      const spin = spec.rotate ? ` rotateZ(${spec.rotate}deg)` : '';
      return `${base}${spin}`;
    });
    lastTileStyle.current = [];
  }, [layout, geo]);

  useEffect(() => {
    const el = containerRef.current;
    if (!el || typeof IntersectionObserver === 'undefined') return;
    const io = new IntersectionObserver(
      (entries) => {
        const next = entries.some((e) => e.isIntersecting);
        const was = visibleRef.current;
        visibleRef.current = next;
        if (next && !was) wakeRef.current();
      },
      { threshold: 0 }
    );
    io.observe(el);
    return () => io.disconnect();
  }, []);

  useEffect(() => {
    if (!mouseParallax) return;
    const el = containerRef.current;
    if (!el) return;
    const onMove = (e) => {
      let rect = rectRef.current;
      if (!rect) {
        rect = el.getBoundingClientRect();
        rectRef.current = rect;
      }
      if (rect.width === 0 || rect.height === 0) return;
      pointerTargetRef.current = {
        x: clamp((e.clientX - rect.left) / rect.width - 0.5, -0.5, 0.5),
        y: clamp((e.clientY - rect.top) / rect.height - 0.5, -0.5, 0.5),
      };
    };
    const onLeave = () => {
      pointerTargetRef.current = { x: 0, y: 0 };
    };
    el.addEventListener('pointermove', onMove, { passive: true });
    el.addEventListener('pointerleave', onLeave, { passive: true });
    return () => {
      el.removeEventListener('pointermove', onMove);
      el.removeEventListener('pointerleave', onLeave);
    };
  }, [mouseParallax]);

  useEffect(() => {
    const el = containerRef.current;
    if (!el) return;
    const release = () => {
      holdRef.current = false;
    };
    const onDown = () => {
      holdRef.current = true;
    };
    const opts = { passive: true };
    el.addEventListener('pointerdown', onDown, opts);
    el.addEventListener('pointerup', release, opts);
    el.addEventListener('pointercancel', release, opts);
    el.addEventListener('pointerleave', release, opts);
    return () => {
      el.removeEventListener('pointerdown', onDown);
      el.removeEventListener('pointerup', release);
      el.removeEventListener('pointercancel', release);
      el.removeEventListener('pointerleave', release);
    };
  }, []);

  const writeFrame = useCallback(() => {
    const scene = sceneRef.current;
    if (scene && mouseParallax) {
      const p = pointerRef.current;
      const last = lastSceneTransform.current;
      if (
        Number.isNaN(last.x) ||
        Math.abs(p.x - last.x) > 5e-4 ||
        Math.abs(p.y - last.y) > 5e-4
      ) {
        scene.style.transform = `rotateY(${p.x * 7}deg) rotateX(${-p.y * 5}deg)`;
        last.x = p.x;
        last.y = p.y;
      }
    }
    const z = tileZ.current;
    const fadeStart = depth * 0.72;
    const fadeSpan = depth * 0.28;
    const tileCache = lastTileStyle.current;
    for (let i = 0; i < z.length; i++) {
      const el = tileRefs.current[i];
      if (!el) continue;
      const zi = z[i];
      const transform = `translate3d(0px, 0px, ${-zi}px) ${baseTransforms.current[i] || ''}`;
      const opacity = zi > fadeStart ? String(clamp(1 - (zi - fadeStart) / fadeSpan, 0, 1)) : '1';
      const prev = tileCache[i];
      if (!prev) {
        el.style.transform = transform;
        el.style.opacity = opacity;
        tileCache[i] = { t: transform, o: opacity };
        continue;
      }
      if (prev.t !== transform) {
        el.style.transform = transform;
        prev.t = transform;
      }
      if (prev.o !== opacity) {
        el.style.opacity = opacity;
        prev.o = opacity;
      }
    }
    const fz = frameZ.current;
    const frameCache = lastFrameStyle.current;
    for (let i = 0; i < fz.length; i++) {
      const el = frameRefs.current[i];
      if (!el) continue;
      const zi = fz[i];
      const transform = `translate3d(0px, 0px, ${-zi}px)`;
      const opacity = zi > fadeStart ? String(clamp(1 - (zi - fadeStart) / fadeSpan, 0, 1)) : '1';
      const prev = frameCache[i];
      if (!prev) {
        el.style.transform = transform;
        el.style.opacity = opacity;
        frameCache[i] = { t: transform, o: opacity };
        continue;
      }
      if (prev.t !== transform) {
        el.style.transform = transform;
        prev.t = transform;
      }
      if (prev.o !== opacity) {
        el.style.opacity = opacity;
        prev.o = opacity;
      }
    }
  }, [depth, mouseParallax]);

  useEffect(() => {
    const NEAR = -Math.max(200, geo.halfWidth * 0.4);
    const speedBase = 320 * clamp(animationSpeed, 0.1, 5);

    const shouldSchedule = () => {
      if (typeof document !== 'undefined' && document.hidden) return false;
      if (!visibleRef.current) return false;
      if (reducedMotion) {
        const p = pointerRef.current;
        const t = pointerTargetRef.current;
        return (
          rampRef.current > 0.001 ||
          Math.abs(boostRef.current - 1) > 0.001 ||
          Math.abs(p.x - t.x) > 0.001 ||
          Math.abs(p.y - t.y) > 0.001
        );
      }
      return true;
    };

    const stop = () => {
      if (rafRef.current !== null) cancelAnimationFrame(rafRef.current);
      rafRef.current = null;
      lastTimeRef.current = 0;
    };

    const tick = (time) => {
      const last = lastTimeRef.current || time;
      lastTimeRef.current = time;
      const dt = Math.min(0.05, (time - last) / 1000);
      const hoverPause = pauseOnHover && hoverRef.current;
      const running =
        startedRef.current &&
        !pausedRef.current &&
        !hoverPause &&
        !reducedMotion &&
        visibleRef.current;

      const target = running ? 1 : 0;
      rampRef.current += (target - rampRef.current) * Math.min(1, dt * 2.4);

      const boostTarget = running && holdRef.current ? BOOST_MAX : 1;
      boostRef.current += (boostTarget - boostRef.current) * Math.min(1, dt * BOOST_EASE);

      const idle = reducedMotion ? 0 : 0.035;
      const factor = idle + (1 - idle) * rampRef.current;
      const delta = speedBase * factor * boostRef.current * dt;

      if (delta > 0) {
        const z = tileZ.current;
        for (let i = 0; i < z.length; i++) {
          let v = z[i] - delta;
          if (v < NEAR) v += depth;
          z[i] = v;
        }
        const fz = frameZ.current;
        for (let i = 0; i < fz.length; i++) {
          let v = fz[i] - delta;
          if (v < NEAR) v += depth;
          fz[i] = v;
        }
      }

      const p = pointerRef.current;
      const t = pointerTargetRef.current;
      p.x += (t.x - p.x) * Math.min(1, dt * 3);
      p.y += (t.y - p.y) * Math.min(1, dt * 3);

      writeFrame();

      if (shouldSchedule()) {
        rafRef.current = requestAnimationFrame(tick);
      } else {
        stop();
      }
    };

    const wake = () => {
      if (rafRef.current !== null) return;
      if (!shouldSchedule()) return;
      lastTimeRef.current = 0;
      rafRef.current = requestAnimationFrame(tick);
    };

    wakeRef.current = wake;
    writeFrame();
    wake();

    const onVisibilityChange = () => {
      if (document.hidden) stop();
      else wake();
    };

    document.addEventListener('visibilitychange', onVisibilityChange);
    return () => {
      document.removeEventListener('visibilitychange', onVisibilityChange);
      wakeRef.current = () => {};
      stop();
    };
  }, [animationSpeed, depth, geo.halfWidth, pauseOnHover, reducedMotion, writeFrame]);

  useEffect(() => {
    setStarted(autoStart);
    if (!autoStart) rampRef.current = 0;
  }, [autoStart]);

  const handleSceneClick = useCallback(() => {
    if (!clickToToggle || !startedRef.current) return;
    setPaused((p) => !p);
    wakeRef.current();
  }, [clickToToggle]);

  const lineColor = withAlpha(gridColor, gridOpacity);
  const thickness = clamp(gridThickness, 0.5, 3);
  const vignetteColor = withAlpha(backgroundColor, 0.95);
  const vignetteTransparent = withAlpha(backgroundColor, 0);
  const tilePlaceholderColor = '#05070E';

  const containerStyle = {
    position: 'relative',
    width: '100%',
    height: '680px',
    overflow: 'hidden',
    backgroundColor: backgroundColor,
    perspective: `${effectivePerspective}px`,
    perspectiveOrigin: '50% 50%',
    touchAction: 'manipulation',
    contain: 'layout paint',
    borderRadius: '24px',
    border: '1px solid rgba(255, 255, 255, 0.08)',
    boxShadow: '0 30px 80px -20px rgba(0,0,0,0.85), inset 0 0 40px rgba(0,242,254,0.03)',
    cursor: paused ? 'pointer' : 'grab',
    ...style,
  };

  return (
    <div
      ref={containerRef}
      style={containerStyle}
      onPointerEnter={() => {
        hoverRef.current = true;
      }}
      onPointerLeave={() => {
        hoverRef.current = false;
        wakeRef.current();
      }}
      onClick={handleSceneClick}
    >
      <div
        ref={sceneRef}
        style={{
          position: 'absolute',
          inset: 0,
          transformStyle: 'preserve-3d',
          willChange: 'transform',
          pointerEvents: 'none',
        }}
      >
        <div
          style={{
            position: 'absolute',
            left: '50%',
            top: '50%',
            width: geo.halfWidth * 2,
            height: geo.halfHeight * 2,
            marginLeft: -geo.halfWidth,
            marginTop: -geo.halfHeight,
            transform: `translate3d(0px, 0px, ${-depth}px)`,
            backgroundColor: backgroundColor,
            transformStyle: 'preserve-3d',
          }}
        />
        {showGrid && (
          <TunnelGrid
            geo={geo}
            frameCount={frameCount}
            lineColor={lineColor}
            thickness={thickness}
            registerFrame={(i) => (el) => {
              frameRefs.current[i] = el;
            }}
          />
        )}
        <div style={{ position: 'absolute', inset: 0, transformStyle: 'preserve-3d' }}>
          {layout.map((spec, i) => (
            <TunnelTile
              key={`${spec.surface}-${i}`}
              spec={spec}
              geo={geo}
              scale={clamp(imageTileScale, 0.5, 2)}
              gap={clamp(tileGap, 0, 100)}
              image={imageList.length > 0 ? imageList[spec.index % imageList.length] : emptyImage}
              placeholderColor={tilePlaceholderColor}
              registerRef={(el) => {
                tileRefs.current[i] = el;
              }}
            />
          ))}
        </div>
      </div>

      {/* Radial vignette fade towards edges */}
      <div
        style={{
          position: 'absolute',
          inset: 0,
          pointerEvents: 'none',
          background: `radial-gradient(circle at 50% 50%, ${vignetteTransparent} 55%, ${vignetteColor} 92%)`,
        }}
      />

      {/* Floating HUD controls bar */}
      <div
        style={{
          position: 'absolute',
          bottom: '20px',
          left: '50%',
          transform: 'translateX(-50%)',
          display: 'inline-flex',
          alignItems: 'center',
          gap: '12px',
          padding: '8px 18px',
          borderRadius: '999px',
          background: 'rgba(7, 12, 27, 0.85)',
          border: '1px solid rgba(255, 255, 255, 0.12)',
          backdropFilter: 'blur(16px)',
          WebkitBackdropFilter: 'blur(16px)',
          color: '#94A3B8',
          fontSize: '12px',
          pointerEvents: 'none',
          zIndex: 10,
          boxShadow: '0 8px 30px rgba(0, 0, 0, 0.5)',
        }}
      >
        <span
          style={{
            width: '8px',
            height: '8px',
            borderRadius: '50%',
            backgroundColor: paused ? '#F59E0B' : '#10B981',
            boxShadow: paused
              ? '0 0 8px rgba(245, 158, 11, 0.8)'
              : '0 0 8px rgba(16, 185, 129, 0.8)',
          }}
        />
        <span style={{ color: '#E2E8F0', fontWeight: 500 }}>
          {paused ? 'Tunnel Paused (Click anywhere to resume)' : 'Active Flythrough'}
        </span>
        <span style={{ color: '#64748B' }}>•</span>
        <span style={{ display: 'inline-block' }}>Move mouse to pan</span>
        <span style={{ color: '#64748B' }}>•</span>
        <span style={{ display: 'inline-block' }}>Hold click to boost</span>
      </div>
    </div>
  );
}
