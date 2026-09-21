/*
 * Floating Gallery — Originkit
 *
 * Cards drift upward through the frame on their own slow currents; clicking one
 * brings it to the centre and scales it to fit, clicking again lets it go. The
 * layout slots are fixed percentages, so the arrangement is the same shape at
 * every width and only the card size changes.
 *
 * Vendored from the Originkit source. Two changes from it: `animate` comes from
 * framer-motion, which is what this bundle already ships (the original imports
 * `motion/react`, the same function under the newer package name), and the host
 * has no hard minimum size, because it is dropped into a 16:9 stage that is
 * narrower than 1200px on a phone and would otherwise overflow the page.
 */

import * as React from 'react';
import { useRef, useEffect, useState, useCallback } from 'react';
import { animate } from 'framer-motion';

type Motion = {
  type?: 'spring' | 'tween' | 'keyframes' | 'inertia';
  duration?: number;
  ease?: [number, number, number, number];
  delay?: number;
  stiffness?: number;
  damping?: number;
  mass?: number;
  bounce?: number;
  restSpeed?: number;
  restDelta?: number;
};

interface GalleryImage {
  src?: string;
  alt?: string;
  link?: string;
}

interface Props {
  images?: GalleryImage[];
  background?: string;
  cardWidth?: number;
  cardHeight?: number;
  rounded?: number;
  speed?: number;
  reach?: number;
  fade?: number;
  transition?: Motion;
  style?: React.CSSProperties;
}

const DEFAULT_CARD_W = 220;
const DEFAULT_CARD_H = 280;
const SPEED_REF = 40;
const ZOOM = 1.6;
const ZOOM_FIT = 0.9;

type Particle = {
  x: number;
  y: number;
  dx: number;
  dy: number;
  z: number;
  targetZ: number;
  w: number;
  h: number;
  mult: number;
};

function hash01(i: number): number {
  const s = Math.sin(i * 127.1 + 311.7) * 43758.5453;
  return s - Math.floor(s);
}

/* Slot geometry in percentages of the host, so the composition holds its shape
   at any size. A gallery with more images than slots wraps around the list. */
const LAYOUT: ReadonlyArray<{ w: number; h: number; x: number; y: number }> = [
  { w: 220, h: 280, x: 12, y: 10 },
  { w: 260, h: 200, x: 42, y: 35 },
  { w: 200, h: 260, x: 74, y: 8 },
  { w: 240, h: 240, x: 26, y: 62 },
  { w: 220, h: 300, x: 60, y: 74 },
  { w: 180, h: 220, x: 88, y: 48 },
];

function roundedClip(w: number, h: number, pct: number): string {
  const t = Math.max(0, Math.min(100, pct)) / 100;
  const short = Math.min(w, h);
  const insetX = (t * (w - short)) / 2;
  const insetY = (t * (h - short)) / 2;
  return `inset(${insetY}px ${insetX}px round ${(t * short) / 2}px)`;
}

export default function FloatingGallery(props: Props) {
  const {
    images = [],
    background = 'transparent',
    cardWidth = 220,
    cardHeight = 280,
    rounded = 16,
    speed = 50,
    reach = 260,
    fade = 0,
    transition = { ease: [0, 0, 0.58, 1], mass: 1, type: 'tween', damping: 60, duration: 0.25, stiffness: 800 },
    style,
  } = props;

  /* The slot geometry was drawn against a ~1200px stage. Below that the cards
     grow into each other and the composition disappears, so they shrink with
     the host rather than being clipped by it. */
  const [fit, setFit] = useState(1);

  const slotSX = (Math.max(1, cardWidth) / DEFAULT_CARD_W) * fit;
  const slotSY = (Math.max(1, cardHeight) / DEFAULT_CARD_H) * fit;

  const rootRef = useRef<HTMLDivElement>(null);
  const partsRef = useRef<Particle[]>([]);
  const nodesRef = useRef<Array<HTMLDivElement | null>>([]);
  const sizeRef = useRef({ w: 0, h: 0 });
  const pointerRef = useRef({ x: 0, y: 0, active: false });
  const [zoomed, setZoomed] = useState<number | null>(null);

  const transitionRef = useRef(transition);
  transitionRef.current = transition;

  const zoomAnims = useRef<Array<{ stop: () => void } | null>>([]);

  const zoomedRef = useRef<number | null>(null);
  zoomedRef.current = zoomed;

  const cfgRef = useRef({ speed, reach, fade });
  cfgRef.current = { speed, reach, fade };

  const items = images && images.length ? images : [];
  const count = items.length;

  const seed = useCallback(() => {
    const { w: W, h: H } = sizeRef.current;
    if (!W || !H) return;
    partsRef.current = items.map((_im, i) => {
      const slot = LAYOUT[i % LAYOUT.length];
      const w = slot.w * slotSX;
      const h = slot.h * slotSY;
      const prev = partsRef.current[i];
      return {
        x: (slot.x / 100) * W - w / 2,
        y: prev ? prev.y : (slot.y / 100) * H - h / 2,
        dx: prev ? prev.dx : 0,
        dy: prev ? prev.dy : 0,
        z: prev ? prev.z : 0,
        targetZ: prev ? prev.targetZ : 0,
        w,
        h,
        mult: 0.65 + hash01(i) * 0.7,
      };
    });
  }, [count, slotSX, slotSY]);

  useEffect(() => {
    const root = rootRef.current;
    if (!root) return;

    const measure = () => {
      sizeRef.current = { w: root.offsetWidth, h: root.offsetHeight };
      setFit(Math.max(0.42, Math.min(1, root.offsetWidth / 1200)));
      seed();
    };
    measure();
    const ro = new ResizeObserver(measure);
    ro.observe(root);
    return () => ro.disconnect();
  }, [seed]);

  useEffect(() => {
    let raf = 0;
    let last = performance.now();

    const tick = (now: number) => {
      raf = requestAnimationFrame(tick);

      const dt = Math.min(0.05, (now - last) / 1000);
      last = now;

      const { w: W, h: H } = sizeRef.current;
      if (!W || !H) return;

      const cfg = cfgRef.current;
      const drift = (Math.max(0, cfg.speed) / 50) * SPEED_REF;
      const fadePx = (Math.max(0, Math.min(100, cfg.fade)) / 100) * (H / 2);
      const zi = zoomedRef.current;
      const kOut = 1 - Math.exp(-8 * dt);

      for (let i = 0; i < partsRef.current.length; i++) {
        const a = partsRef.current[i];
        const node = nodesRef.current[i];
        if (!node) continue;
        const frozen = zi === i;

        if (!frozen) {
          a.y += drift * a.mult * dt;

          const span = H + a.h;
          if (a.y > H) a.y -= span;
          else if (a.y < -a.h) a.y += span;
        }

        a.dx += (0 - a.dx) * kOut;
        a.dy += (0 - a.dy) * kOut;

        const targetZ = frozen ? 1 : 0;
        if (a.targetZ !== targetZ) {
          a.targetZ = targetZ;
          zoomAnims.current[i]?.stop();
          const from = a.z;
          const delta = targetZ - from;
          zoomAnims.current[i] = animate(0, 1, {
            ...transitionRef.current,
            onUpdate: (t: number) => {
              a.z = from + delta * t;
            },
            onComplete: () => {
              zoomAnims.current[i] = null;
            },
          }) as unknown as { stop: () => void };
        }

        const baseX = a.x + a.dx;
        const baseY = a.y + a.dy;
        const z = a.z;
        const px = baseX + ((W - a.w) / 2 - baseX) * z;
        const py = baseY + ((H - a.h) / 2 - baseY) * z;

        const zoomFit = Math.min(ZOOM, (W * ZOOM_FIT) / Math.max(1, a.w), (H * ZOOM_FIT) / Math.max(1, a.h));
        const s = 1 + (zoomFit - 1) * z;

        node.style.transform = `translate3d(${px}px, ${py}px, 0) scale(${s})`;
        node.style.zIndex = z > 0.001 ? '999' : '1';

        if (fadePx > 0) {
          const cy = a.y + a.h / 2;
          const edge = Math.min(cy, H - cy);
          const o = Math.max(0, Math.min(1, edge / fadePx));
          node.style.opacity = `${o + (1 - o) * z}`;
        } else {
          node.style.opacity = '1';
        }
      }
    };

    raf = requestAnimationFrame(tick);
    return () => cancelAnimationFrame(raf);
  }, []);

  const onPointerMove = (e: React.PointerEvent) => {
    const root = rootRef.current;
    if (!root) return;
    const r = root.getBoundingClientRect();
    const sx = r.width ? root.offsetWidth / r.width : 1;
    const sy = r.height ? root.offsetHeight / r.height : 1;
    pointerRef.current = {
      x: (e.clientX - r.left) * sx,
      y: (e.clientY - r.top) * sy,
      active: true,
    };
  };
  const onPointerLeave = () => {
    pointerRef.current.active = false;
  };

  return (
    <div
      ref={rootRef}
      onPointerMove={onPointerMove}
      onPointerLeave={onPointerLeave}
      onClick={() => {
        if (zoomed !== null) setZoomed(null);
      }}
      style={{
        width: '100%',
        height: '100%',
        minHeight: 420,
        position: 'relative',
        overflow: 'hidden',
        background,
        isolation: 'isolate',
        touchAction: 'none',
        ...style,
      }}
    >
      {items.map((im, i) => {
        const slot = LAYOUT[i % LAYOUT.length];
        const w = slot.w * slotSX;
        const h = slot.h * slotSY;
        const isZoom = zoomed === i;
        const link = im.link || '';

        const activate = (e?: React.SyntheticEvent) => {
          e?.stopPropagation();
          if (isZoom && link) {
            window.open(link, '_blank', 'noopener');
            return;
          }
          if (zoomed !== null) {
            setZoomed(null);
            return;
          }
          setZoomed(i);
        };

        return (
          <div
            key={i}
            ref={(n) => {
              nodesRef.current[i] = n;
            }}
            onClick={activate}
            role="button"
            tabIndex={0}
            aria-pressed={isZoom}
            aria-label={im.alt || undefined}
            onKeyDown={(e) => {
              if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                activate(e);
              }
            }}
            style={{
              position: 'absolute',
              top: 0,
              left: 0,
              width: w,
              height: h,
              clipPath: roundedClip(w, h, rounded),
              cursor: 'pointer',
              userSelect: 'none',
              background: 'rgba(255,255,255,0.06)',
              filter: isZoom
                ? 'drop-shadow(0 30px 40px rgba(0,0,0,0.55))'
                : 'drop-shadow(0 10px 15px rgba(0,0,0,0.35))',
              transition: 'box-shadow 240ms ease',
              willChange: 'transform',
            }}
          >
            {im.src ? (
              <img
                src={im.src}
                alt={im.alt || ''}
                draggable={false}
                style={{
                  width: '100%',
                  height: '100%',
                  objectFit: 'cover',
                  display: 'block',
                  pointerEvents: 'none',
                }}
              />
            ) : null}
          </div>
        );
      })}
    </div>
  );
}

FloatingGallery.displayName = 'Floating Gallery';
