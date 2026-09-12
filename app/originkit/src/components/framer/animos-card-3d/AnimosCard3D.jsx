import React, { useState, useRef } from 'react';

const TECH_CARDS = [
  {
    id: 'ai',
    num: '01',
    name: 'AI & Machine Learning',
    category: 'Agentic Workflows & Retrieval',
    tagline: 'Intelligence embedded directly into the transaction',
    badge: 'Production Proven',
    legitimateUse: 'Retrieval over private company documents, forecasting on internal history, and multi-step autonomous agents that finish a task rather than propose one.',
    fashionableUse: 'A generic chatbot floating in the bottom-right corner answering questions nobody asked.',
    metrics: [
      { label: 'Latency', value: '180ms', sub: 'Streaming token response' },
      { label: 'Accuracy', value: '99.4%', sub: 'With human-in-the-loop review' },
      { label: 'Cost Reduction', value: '−42%', sub: 'Manual data entry removed' },
    ],
    stack: ['LangGraph', 'Claude 3.5 / GPT-4o', 'pgvector', 'FastAPI', 'Whisper'],
    accentColor: '#00f2fe',
    glowColor: 'rgba(0, 242, 254, 0.4)',
    illustration: 'brain',
  },
  {
    id: 'iot',
    num: '02',
    name: 'IoT & Edge Telemetry',
    category: 'Connected Hardware & Fleet',
    tagline: 'Telemetry ingestion that survives an offline factory floor',
    badge: 'Mission Critical',
    legitimateUse: 'Local edge buffering on gateways, MQTT queues that replay on reconnect, and real-time anomaly detection before machine failure.',
    fashionableUse: 'Connecting a commodity sensor to a dashboard with no automated threshold alerting.',
    metrics: [
      { label: 'Ingestion', value: '50k/sec', sub: 'Time-series data points' },
      { label: 'Offline Buffer', value: '72 Hours', sub: 'Autonomous edge memory' },
      { label: 'Failure Warning', value: '15 Min', sub: 'Predictive alert window' },
    ],
    stack: ['MQTT / EMQX', 'TimescaleDB', 'Rust / C++', 'Docker Edge', 'Grafana'],
    accentColor: '#38bdf8',
    glowColor: 'rgba(56, 189, 248, 0.4)',
    illustration: 'cpu',
  },
  {
    id: 'ar',
    num: '03',
    name: 'AR & Immersive 3D',
    category: 'Browser WebGL & Visualizers',
    tagline: 'WebGL that runs instantly without an app install',
    badge: 'High Conversion',
    legitimateUse: 'Interactive 3D product configurators, guided industrial maintenance overlays, and spatial floor plans directly in Chrome or Safari.',
    fashionableUse: 'An empty metaverse showroom that takes 45 seconds to load and crashes mobile phones.',
    metrics: [
      { label: 'Load Time', value: '< 1.2s', sub: 'Progressive asset streaming' },
      { label: 'Frame Rate', value: '60 FPS', sub: 'Locked on mobile & desktop' },
      { label: 'Conversion Lift', value: '+34%', sub: 'On interactive 3D checkouts' },
    ],
    stack: ['Three.js / WebGL', 'GLTF / Draco', 'WebXR', 'Vite', 'Canvas Post-FX'],
    accentColor: '#a855f7',
    glowColor: 'rgba(168, 85, 247, 0.4)',
    illustration: 'globe',
  },
  {
    id: 'ledger',
    num: '04',
    name: 'Blockchain & Tamper-Evident Ledgers',
    category: 'Provenance & Settlement Rails',
    tagline: 'Audit trails where immutability genuinely earns its cost',
    badge: 'Zero-Trust Audit',
    legitimateUse: 'Multi-party supply chain provenance, pharmaceutical batch tracking, and cryptographic signature logs where participants cannot trust a single central database.',
    fashionableUse: 'Putting customer loyalty points or ticket barcodes on a public blockchain with high gas fees.',
    metrics: [
      { label: 'Verification', value: 'Cryptographic', sub: 'Zero-knowledge proofs' },
      { label: 'Audit Speed', value: 'Instant', sub: 'Automated regulator proof' },
      { label: 'Tamper Risk', value: '0.0%', sub: 'Mathematically immutable' },
    ],
    stack: ['Hyperledger / EVM', 'IPFS', 'Solidity', 'Python Web3', 'PostgreSQL Mirror'],
    accentColor: '#34d399',
    glowColor: 'rgba(52, 211, 153, 0.4)',
    illustration: 'lock',
  },
  {
    id: 'rpa',
    num: '05',
    name: 'Robotic Process Automation',
    category: 'Legacy Bridge & Document Robots',
    tagline: 'The bridge for legacy software with zero modern APIs',
    badge: 'Immediate ROI',
    legitimateUse: 'Headless automation navigating 20-year-old banking/ERP desktop clients, extracting scanned invoices, and syncing state without an expensive ERP overhaul.',
    fashionableUse: 'Automating a process that could be solved with a simple 5-line webhook.',
    metrics: [
      { label: 'Error Rate', value: '0.01%', sub: 'Across 100k monthly docs' },
      { label: 'Cycle Time', value: '45 Sec', sub: 'Down from 25 min manual' },
      { label: 'ROI Timeline', value: '6 Weeks', sub: 'Full capital payback' },
    ],
    stack: ['Playwright Core', 'OCR / Vision AI', 'Celery Workers', 'Redis', 'Python'],
    accentColor: '#f59e0b',
    glowColor: 'rgba(245, 158, 11, 0.4)',
    illustration: 'workflow',
  },
];

export default function AnimosCard3D(props = {}) {
  const cards = props.cards && props.cards.length ? props.cards : TECH_CARDS;
  const [selectedIdx, setSelectedIdx] = useState(0);
  const cardRef = useRef(null);
  const [tilt, setTilt] = useState({ rx: 0, ry: 0, px: 50, py: 50 });

  const active = cards[selectedIdx] || cards[0];

  const handleMouseMove = (e) => {
    if (!cardRef.current) return;
    const rect = cardRef.current.getBoundingClientRect();
    const x = e.clientX - rect.left;
    const y = e.clientY - rect.top;
    
    // Percentage from center (-1 to 1)
    const normX = (x / rect.width - 0.5) * 2;
    const normY = (y / rect.height - 0.5) * 2;

    // 3D rotation angles in degrees (max 16 deg)
    const ry = normX * 16;
    const rx = -normY * 16;
    const px = (x / rect.width) * 100;
    const py = (y / rect.height) * 100;

    setTilt({ rx, ry, px, py });
  };

  const handleMouseLeave = () => {
    setTilt({ rx: 0, ry: 0, px: 50, py: 50 });
  };

  return (
    <div className="animos-showcase-wrap" style={{
      width: '100%',
      maxWidth: '1240px',
      margin: '0 auto',
      position: 'relative',
    }}>
      {/* Technology Category Selector Tabs */}
      <div style={{
        display: 'flex',
        justifyContent: 'center',
        flexWrap: 'wrap',
        gap: '10px',
        marginBottom: '36px',
        position: 'relative',
        zIndex: 10,
      }}>
        {cards.map((t, idx) => {
          const isSelected = selectedIdx === idx;
          return (
            <button
              key={t.id}
              onClick={() => setSelectedIdx(idx)}
              style={{
                background: isSelected ? 'rgba(0, 242, 254, 0.16)' : 'rgba(15, 23, 42, 0.65)',
                border: `1px solid ${isSelected ? t.accentColor : 'rgba(255, 255, 255, 0.1)'}`,
                color: isSelected ? '#ffffff' : 'rgba(255, 255, 255, 0.65)',
                padding: '10px 20px',
                borderRadius: '999px',
                cursor: 'pointer',
                fontSize: '0.88rem',
                fontWeight: isSelected ? 700 : 500,
                display: 'flex',
                alignItems: 'center',
                gap: '8px',
                transition: 'all 0.25s cubic-bezier(0.16, 1, 0.3, 1)',
                backdropFilter: 'blur(8px)',
                boxShadow: isSelected ? `0 0 20px ${t.accentColor}30` : 'none',
              }}
            >
              <span style={{
                fontFamily: 'monospace',
                fontSize: '0.76rem',
                color: isSelected ? t.accentColor : 'rgba(255, 255, 255, 0.4)',
                fontWeight: 700,
              }}>
                {t.num}
              </span>
              <span>{t.name}</span>
            </button>
          );
        })}
      </div>

      {/* 3D Perspective Stage */}
      <div style={{
        perspective: '1200px',
        display: 'flex',
        justifyContent: 'center',
        alignItems: 'center',
        padding: '20px 0',
      }}>
        {/* The 3D Floating Animos Card */}
        <div
          ref={cardRef}
          onMouseMove={handleMouseMove}
          onMouseLeave={handleMouseLeave}
          style={{
            width: '100%',
            maxWidth: '820px',
            transform: `rotateX(${tilt.rx}deg) rotateY(${tilt.ry}deg)`,
            transformStyle: 'preserve-3d',
            transition: 'transform 0.12s ease-out',
            borderRadius: '24px',
            position: 'relative',
            cursor: 'crosshair',
          }}
        >
          {/* External 3D Gyro Ring Tilt Effect */}
          <div style={{
            position: 'absolute',
            top: '-20px',
            left: '-20px',
            right: '-20px',
            bottom: '-20px',
            border: `1px dashed ${active.accentColor}40`,
            borderRadius: '32px',
            transform: 'translateZ(-25px) rotate(-1deg)',
            pointerEvents: 'none',
          }} />
          <div style={{
            position: 'absolute',
            top: '-40px',
            left: '-40px',
            right: '-40px',
            bottom: '-40px',
            border: '1px solid rgba(255, 255, 255, 0.04)',
            borderRadius: '44px',
            transform: 'translateZ(-50px) rotate(1.5deg)',
            pointerEvents: 'none',
          }} />

          {/* Main Card Body */}
          <div style={{
            background: 'linear-gradient(145deg, rgba(20, 27, 45, 0.95) 0%, rgba(8, 12, 22, 0.98) 100%)',
            border: '1px solid rgba(255, 255, 255, 0.14)',
            borderRadius: '24px',
            padding: '40px',
            boxShadow: `0 35px 80px -15px rgba(0, 0, 0, 0.85), 0 0 50px ${active.glowColor}`,
            position: 'relative',
            overflow: 'hidden',
          }}>
            {/* Dynamic Specular Sheen responding to cursor */}
            <div style={{
              position: 'absolute',
              top: 0,
              left: 0,
              right: 0,
              bottom: 0,
              background: `radial-gradient(circle 380px at ${tilt.px}% ${tilt.py}%, rgba(255, 255, 255, 0.12) 0%, transparent 80%)`,
              pointerEvents: 'none',
              borderRadius: '24px',
            }} />

            {/* Glowing Accent Aura */}
            <div style={{
              position: 'absolute',
              top: '-80px',
              right: '-80px',
              width: '280px',
              height: '280px',
              background: `radial-gradient(circle, ${active.accentColor}30 0%, transparent 70%)`,
              filter: 'blur(50px)',
              pointerEvents: 'none',
            }} />

            {/* Top Bar: Badge & Tagline */}
            <div style={{
              display: 'flex',
              justifyContent: 'space-between',
              alignItems: 'center',
              marginBottom: '20px',
              transform: 'translateZ(30px)',
            }}>
              <div style={{ display: 'flex', alignItems: 'center', gap: '10px' }}>
                <span style={{
                  background: 'rgba(255, 255, 255, 0.08)',
                  color: active.accentColor,
                  fontFamily: 'monospace',
                  fontSize: '0.8rem',
                  fontWeight: 700,
                  padding: '4px 10px',
                  borderRadius: '6px',
                  border: `1px solid ${active.accentColor}40`,
                }}>
                  {active.num}
                </span>
                <span style={{
                  fontSize: '0.82rem',
                  color: 'rgba(255, 255, 255, 0.65)',
                  textTransform: 'uppercase',
                  letterSpacing: '0.12em',
                  fontWeight: 600,
                }}>
                  {active.category}
                </span>
              </div>

              <span style={{
                background: `linear-gradient(90deg, ${active.accentColor}25, transparent)`,
                border: `1px solid ${active.accentColor}60`,
                color: '#fff',
                fontSize: '0.78rem',
                fontWeight: 700,
                padding: '4px 14px',
                borderRadius: '999px',
                letterSpacing: '0.04em',
                boxShadow: `0 0 12px ${active.accentColor}40`,
              }}>
                ✦ {active.badge}
              </span>
            </div>

            {/* Title & Tagline */}
            <div style={{ transform: 'translateZ(45px)', marginBottom: '28px' }}>
              <h3 style={{
                fontSize: 'clamp(1.7rem, 2.8vw, 2.3rem)',
                fontWeight: 800,
                color: '#ffffff',
                letterSpacing: '-0.02em',
                margin: '0 0 8px 0',
              }}>
                {active.name}
              </h3>
              <p style={{
                fontSize: '1.05rem',
                color: active.accentColor,
                fontWeight: 600,
                margin: 0,
              }}>
                {active.tagline}
              </p>
            </div>

            {/* 3D Visual Architecture Frame */}
            {active.image && (
              <div style={{
                transform: 'translateZ(40px)',
                marginBottom: '28px',
                borderRadius: '16px',
                overflow: 'hidden',
                border: `1px solid ${active.accentColor}50`,
                aspectRatio: '16 / 9',
                maxHeight: '280px',
                position: 'relative',
                boxShadow: `0 16px 36px -10px rgba(0, 0, 0, 0.9), 0 0 24px ${active.accentColor}30`,
              }}>
                <img
                  src={active.image}
                  alt={active.name}
                  style={{ width: '100%', height: '100%', objectFit: 'cover', display: 'block' }}
                  loading="lazy"
                />
                <div style={{
                  position: 'absolute',
                  inset: 0,
                  background: 'linear-gradient(180deg, transparent 60%, rgba(2, 4, 10, 0.75) 100%)',
                  pointerEvents: 'none',
                }} />
              </div>
            )}

            {/* The Reality Check: Legitimate vs Fashionable comparison */}
            <div style={{
              display: 'grid',
              gridTemplateColumns: 'repeat(auto-fit, minmax(300px, 1fr))',
              gap: '16px',
              marginBottom: '32px',
              transform: 'translateZ(25px)',
            }}>
              {/* Legitimate Use */}
              <div style={{
                background: 'rgba(16, 185, 129, 0.08)',
                border: '1px solid rgba(16, 185, 129, 0.25)',
                borderRadius: '14px',
                padding: '18px 20px',
              }}>
                <div style={{ display: 'flex', alignItems: 'center', gap: '8px', marginBottom: '8px' }}>
                  <span style={{ color: '#10b981', fontWeight: 800, fontSize: '0.95rem' }}>✓</span>
                  <b style={{ color: '#10b981', fontSize: '0.85rem', textTransform: 'uppercase', letterSpacing: '0.08em' }}>
                    Where It Actually Pays
                  </b>
                </div>
                <p style={{ fontSize: '0.88rem', color: 'rgba(255, 255, 255, 0.85)', lineHeight: 1.55, margin: 0 }}>
                  {active.legitimateUse}
                </p>
              </div>

              {/* Fashionable Use */}
              <div style={{
                background: 'rgba(239, 68, 68, 0.08)',
                border: '1px solid rgba(239, 68, 68, 0.25)',
                borderRadius: '14px',
                padding: '18px 20px',
              }}>
                <div style={{ display: 'flex', alignItems: 'center', gap: '8px', marginBottom: '8px' }}>
                  <span style={{ color: '#ef4444', fontWeight: 800, fontSize: '0.95rem' }}>✕</span>
                  <b style={{ color: '#ef4444', fontSize: '0.85rem', textTransform: 'uppercase', letterSpacing: '0.08em' }}>
                    The Fashionable Waste
                  </b>
                </div>
                <p style={{ fontSize: '0.88rem', color: 'rgba(255, 255, 255, 0.7)', lineHeight: 1.55, margin: 0 }}>
                  {active.fashionableUse}
                </p>
              </div>
            </div>

            {/* Metrics Triad */}
            <div style={{
              display: 'grid',
              gridTemplateColumns: 'repeat(3, 1fr)',
              gap: '14px',
              marginBottom: '28px',
              transform: 'translateZ(35px)',
            }}>
              {active.metrics.map((m, mIdx) => (
                <div key={mIdx} style={{
                  background: 'rgba(255, 255, 255, 0.03)',
                  border: '1px solid rgba(255, 255, 255, 0.08)',
                  borderRadius: '12px',
                  padding: '16px',
                  textAlign: 'center',
                }}>
                  <span style={{
                    display: 'block',
                    fontFamily: 'monospace',
                    fontSize: 'clamp(1.3rem, 2vw, 1.7rem)',
                    fontWeight: 800,
                    color: active.accentColor,
                    letterSpacing: '-0.02em',
                  }}>
                    {m.value}
                  </span>
                  <span style={{ display: 'block', fontSize: '0.84rem', fontWeight: 700, color: '#fff', marginTop: '2px' }}>
                    {m.label}
                  </span>
                  <span style={{ display: 'block', fontSize: '0.72rem', color: 'rgba(255, 255, 255, 0.5)', marginTop: '2px' }}>
                    {m.sub}
                  </span>
                </div>
              ))}
            </div>

            {/* Production Tech Stack Tags */}
            <div style={{
              display: 'flex',
              flexWrap: 'wrap',
              alignItems: 'center',
              gap: '8px',
              transform: 'translateZ(20px)',
            }}>
              <span style={{ fontSize: '0.76rem', color: 'rgba(255, 255, 255, 0.45)', textTransform: 'uppercase', letterSpacing: '0.1em', fontWeight: 600, marginRight: '6px' }}>
                Engineered In:
              </span>
              {active.stack.map((item, sIdx) => (
                <span key={sIdx} style={{
                  background: 'rgba(255, 255, 255, 0.06)',
                  border: '1px solid rgba(255, 255, 255, 0.1)',
                  borderRadius: '6px',
                  padding: '4px 12px',
                  fontSize: '0.78rem',
                  color: 'rgba(255, 255, 255, 0.85)',
                  fontFamily: 'monospace',
                }}>
                  {item}
                </span>
              ))}
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}
