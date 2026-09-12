import React, { useRef, useState, useEffect, useMemo } from 'react';
import { motion, useScroll, useTransform, useSpring } from 'framer-motion';

/**
 * CinematicCardDeck
 *
 * Exact Framer Cinematic Card Deck component for iThrive On-Demand disciplines.
 * 3D sticky scroll stack where cards peel upward, rotate along the X-axis,
 * and dissolve with dynamic ambient glow and progress controls.
 */

const DEFAULT_DISCIPLINES = [
  {
    num: '01',
    title: 'Mobile App Developers',
    tagline: 'iOS, Android & Flutter specialists',
    desc: 'Native Swift/Kotlin and cross-platform Flutter engineers who ship production apps to both stores. People who have already navigated Apple Review and Google Play policies and won.',
    tags: ['Swift', 'Kotlin', 'Flutter', 'App Store', 'Core Web Vitals'],
    image: 'assets/img/ondemand/photo/role-01a.jpg',
    color: '#00F2FE',
  },
  {
    num: '02',
    title: 'Full-Stack Developers',
    tagline: 'Schema to screen without handovers',
    desc: 'TypeScript, Next.js, Node.js, and relational schema design. The right choice when your backlog bottleneck is overall velocity rather than a hyperspecialized silo.',
    tags: ['Next.js', 'Node.js', 'PostgreSQL', 'GraphQL', 'Tailwind'],
    image: 'assets/img/ondemand/photo/role-02a.jpg',
    color: '#38BDF8',
  },
  {
    num: '03',
    title: 'Front-End Developers',
    tagline: 'Pixel-perfect, performance-first UIs',
    desc: 'React and modern TypeScript built strictly against your design system. Measured on interaction fidelity, accessibility, and sub-second Core Web Vitals.',
    tags: ['React', 'TypeScript', 'Tailwind', 'Design Systems', 'Vite'],
    image: 'assets/img/ondemand/photo/role-03a.jpg',
    color: '#6366F1',
  },
  {
    num: '04',
    title: 'Back-End Developers',
    tagline: 'Fault-tolerant distributed architectures',
    desc: 'Python, Node, and Go behind microservices and APIs engineered for failure modes, circuit-breaking, queue reliability, and high-concurrency workloads.',
    tags: ['Python', 'Go', 'FastAPI', 'Redis', 'Docker / K8s'],
    image: 'assets/img/ondemand/photo/role-04a.jpg',
    color: '#9D4EDD',
  },
  {
    num: '05',
    title: 'E-Commerce Developers',
    tagline: 'High-conversion checkout & storefronts',
    desc: 'Headless Shopify, Medusa, WooCommerce, and custom payment gateways where a 100ms latency reduction translates directly into measurable top-line revenue.',
    tags: ['Shopify Plus', 'Stripe', 'Headless', 'Medusa', 'High-Scale'],
    image: 'assets/img/ondemand/photo/role-05a.jpg',
    color: '#EC4899',
  },
];

export default function CinematicCardDeck(props) {
  const cards = props.disciplines || DEFAULT_DISCIPLINES;
  const sectionRef = useRef(null);
  const [manualIndex, setManualIndex] = useState(null);

  const { scrollYProgress } = useScroll({
    target: sectionRef,
    offset: ['start start', 'end end'],
  });

  const smoothProgress = useSpring(scrollYProgress, {
    stiffness: 140,
    damping: 24,
    mass: 0.8,
  });

  const [activeIndex, setActiveIndex] = useState(0);

  useEffect(() => {
    return smoothProgress.on('change', (latest) => {
      if (manualIndex !== null) return;
      const total = cards.length;
      const idx = Math.min(total - 1, Math.max(0, Math.floor(latest * total * 0.98)));
      setActiveIndex(idx);
    });
  }, [smoothProgress, cards.length, manualIndex]);

  const activeCard = cards[manualIndex !== null ? manualIndex : activeIndex] || cards[0];

  return (
    <div
      ref={sectionRef}
      className="cinematic-deck-wrap"
      style={{
        position: 'relative',
        height: `${cards.length * 90}vh`,
        minHeight: '280vh',
      }}
    >
      <div
        className="cinematic-deck-sticky"
        style={{
          position: 'sticky',
          top: 0,
          height: '100vh',
          display: 'flex',
          flexDirection: 'column',
          alignItems: 'center',
          justifyContent: 'center',
          overflow: 'hidden',
          perspective: '1400px',
        }}
      >
        {/* Dynamic ambient radial glow shifting hue behind active card */}
        <div
          style={{
            position: 'absolute',
            width: '650px',
            height: '650px',
            borderRadius: '50%',
            background: `radial-gradient(circle, ${activeCard.color}40 0%, ${activeCard.color}10 45%, transparent 70%)`,
            filter: 'blur(90px)',
            pointerEvents: 'none',
            transition: 'background 0.6s ease',
            zIndex: 1,
          }}
        />

        {/* 3D Stack Stage */}
        <div
          style={{
            position: 'relative',
            width: 'min(940px, 92vw)',
            height: 'min(540px, 68vh)',
            transformStyle: 'preserve-3d',
            zIndex: 2,
          }}
        >
          {cards.map((card, i) => {
            return (
              <DeckCard
                key={card.num}
                card={card}
                index={i}
                total={cards.length}
                progress={smoothProgress}
                manualIndex={manualIndex}
              />
            );
          })}
        </div>

        {/* Progress Navigation Dots & Controls */}
        <div
          style={{
            position: 'relative',
            zIndex: 10,
            marginTop: '28px',
            display: 'flex',
            alignItems: 'center',
            gap: '12px',
            padding: '8px 16px',
            borderRadius: '999px',
            background: 'rgba(7, 12, 24, 0.75)',
            backdropFilter: 'blur(16px)',
            border: '1px solid rgba(255, 255, 255, 0.12)',
            boxShadow: '0 20px 40px rgba(0, 0, 0, 0.5)',
          }}
        >
          {cards.map((card, i) => {
            const isSelected = (manualIndex !== null ? manualIndex : activeIndex) === i;
            return (
              <button
                key={card.num}
                type="button"
                onClick={() => {
                  setManualIndex(i);
                  setActiveIndex(i);
                  setTimeout(() => setManualIndex(null), 3000);
                }}
                style={{
                  display: 'flex',
                  alignItems: 'center',
                  gap: '6px',
                  padding: isSelected ? '6px 14px' : '6px 10px',
                  borderRadius: '999px',
                  background: isSelected ? card.color : 'rgba(255, 255, 255, 0.05)',
                  color: isSelected ? '#040B14' : 'rgba(226, 232, 240, 0.65)',
                  fontWeight: isSelected ? 800 : 500,
                  fontSize: '12px',
                  fontFamily: 'Inter, sans-serif',
                  border: isSelected ? `1px solid ${card.color}` : '1px solid transparent',
                  cursor: 'pointer',
                  transition: 'all 0.3s cubic-bezier(0.16, 1, 0.3, 1)',
                }}
              >
                <span>{card.num}</span>
                {isSelected && <span>{card.title.split(' ')[0]}</span>}
              </button>
            );
          })}
        </div>

        <p
          style={{
            position: 'relative',
            zIndex: 10,
            marginTop: '12px',
            fontSize: '12px',
            color: 'rgba(148, 163, 184, 0.7)',
            fontFamily: 'Fira Code, monospace',
            letterSpacing: '0.04em',
          }}
        >
          Scroll or click to peel through disciplines
        </p>
      </div>
    </div>
  );
}

function DeckCard({ card, index, total, progress, manualIndex }) {
  const step = 1 / total;
  const start = index * step;
  const end = (index + 1) * step;

  // Custom transforms based on scroll
  const translateY = useTransform(progress, (p) => {
    if (manualIndex !== null) {
      const diff = index - manualIndex;
      if (diff < 0) return -180;
      if (diff === 0) return 0;
      return diff * 20;
    }
    if (p < start) {
      const depth = index - Math.floor(p / step);
      return depth * 14;
    }
    const f = (p - start) / step;
    return -f * 240;
  });

  const rotateX = useTransform(progress, (p) => {
    if (manualIndex !== null) {
      const diff = index - manualIndex;
      return diff < 0 ? -38 : 0;
    }
    if (p < start) return 0;
    const f = (p - start) / step;
    return -f * 42;
  });

  const scale = useTransform(progress, (p) => {
    if (manualIndex !== null) {
      const diff = index - manualIndex;
      if (diff < 0) return 0.88;
      if (diff === 0) return 1;
      return Math.max(0.85, 1 - diff * 0.05);
    }
    if (p < start) {
      const diff = index - Math.floor(p / step);
      return Math.max(0.86, 1 - diff * 0.04);
    }
    const f = (p - start) / step;
    return 1 - f * 0.12;
  });

  const opacity = useTransform(progress, (p) => {
    if (manualIndex !== null) {
      if (index === manualIndex) return 1;
      if (index < manualIndex) return 0;
      if (index === manualIndex + 1) return 1;
      return 0;
    }
    const activeF = p / step;
    const currentIdx = Math.floor(activeF);
    if (index < currentIdx) return 0;
    if (index === currentIdx) {
      const f = activeF - currentIdx;
      return f > 0.8 ? Math.max(0, (1 - f) / 0.2) : 1;
    }
    if (index === currentIdx + 1) {
      return 1;
    }
    return 0;
  });

  const zIndex = useTransform(progress, (p) => {
    if (manualIndex !== null) {
      return 100 - (index < manualIndex ? 50 : index - manualIndex);
    }
    const activeF = p / step;
    const currentIdx = Math.floor(activeF);
    if (index < currentIdx) return 10;
    if (index === currentIdx) return 80;
    return Math.max(10, 70 - (index - currentIdx));
  });

  return (
    <motion.article
      style={{
        position: 'absolute',
        inset: 0,
        borderRadius: '24px',
        overflow: 'hidden',
        background: '#060B18',
        border: '1px solid rgba(255, 255, 255, 0.14)',
        boxShadow: '0 30px 90px -20px rgba(0, 0, 0, 0.95), inset 0 1px 0 rgba(255, 255, 255, 0.15)',
        transformOrigin: '50% 100%',
        translateY,
        rotateX,
        scale,
        opacity,
        zIndex,
        display: 'grid',
        gridTemplateColumns: 'minmax(0, 1.2fr) minmax(0, 1fr)',
        transformStyle: 'preserve-3d',
        backfaceVisibility: 'hidden',
      }}
      className="cinematic-card-body"
    >
      {/* Left Info Panel */}
      <div
        style={{
          padding: 'clamp(24px, 4vw, 48px)',
          display: 'flex',
          flexDirection: 'column',
          justifyContent: 'space-between',
          zIndex: 2,
          background: '#060B18',
        }}
      >
        <div>
          <div
            style={{
              display: 'inline-flex',
              alignItems: 'center',
              gap: '10px',
              padding: '6px 14px',
              borderRadius: '999px',
              background: `${card.color}1a`,
              border: `1px solid ${card.color}4d`,
              marginBottom: '20px',
            }}
          >
            <span
              style={{
                fontFamily: 'Fira Code, monospace',
                fontSize: '13px',
                fontWeight: 800,
                color: card.color,
              }}
            >
              {card.num}
            </span>
            <span
              style={{
                fontSize: '12px',
                fontWeight: 600,
                color: '#E2E8F0',
                letterSpacing: '0.04em',
                textTransform: 'uppercase',
              }}
            >
              {card.tagline}
            </span>
          </div>

          <h3
            style={{
              fontSize: 'clamp(1.6rem, 2.6vw, 2.2rem)',
              fontWeight: 800,
              color: '#F8FAFC',
              lineHeight: 1.15,
              letterSpacing: '-0.02em',
              margin: '0 0 16px',
            }}
          >
            {card.title}
          </h3>

          <p
            style={{
              fontSize: 'clamp(0.9rem, 1.1vw, 1.05rem)',
              lineHeight: 1.65,
              color: '#94A3B8',
              margin: '0 0 24px',
            }}
          >
            {card.desc}
          </p>

          <div
            style={{
              display: 'flex',
              flexWrap: 'wrap',
              gap: '8px',
              marginBottom: '24px',
            }}
          >
            {card.tags.map((t) => (
              <span
                key={t}
                style={{
                  padding: '4px 10px',
                  borderRadius: '6px',
                  background: 'rgba(255, 255, 255, 0.05)',
                  border: '1px solid rgba(255, 255, 255, 0.08)',
                  fontSize: '11px',
                  fontFamily: 'Fira Code, monospace',
                  color: '#CBD5E1',
                }}
              >
                {t}
              </span>
            ))}
          </div>
        </div>

        <div style={{ display: 'flex', alignItems: 'center', gap: '14px' }}>
          <button
            type="button"
            className="od-btn od-btn--primary"
            data-modal-open
            data-modal-service={`Hire ${card.title}`}
            style={{
              background: `linear-gradient(90deg, ${card.color}, #3B82F6)`,
              color: '#050814',
              fontWeight: 800,
              boxShadow: `0 6px 20px ${card.color}40`,
            }}
          >
            Deploy this discipline →
          </button>
        </div>
      </div>

      {/* Right Art / Image Panel */}
      <div
        style={{
          position: 'relative',
          height: '100%',
          overflow: 'hidden',
          background: '#040711',
        }}
      >
        <img
          src={card.image}
          alt={card.title}
          style={{
            width: '100%',
            height: '100%',
            objectFit: 'cover',
            objectPosition: 'center',
            filter: 'brightness(0.92) contrast(1.05)',
          }}
          loading="lazy"
        />
        <div
          style={{
            position: 'absolute',
            inset: 0,
            background: 'linear-gradient(90deg, rgba(5, 9, 20, 0.9) 0%, transparent 40%), linear-gradient(180deg, transparent 60%, rgba(5, 9, 20, 0.8) 100%)',
            pointerEvents: 'none',
          }}
        />
      </div>
    </motion.article>
  );
}
