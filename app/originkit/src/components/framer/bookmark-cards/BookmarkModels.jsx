import React from 'react';
import { motion } from 'framer-motion';

const MODELS = [
  {
    id: 'dedicated',
    tag: '— Dedicated Team®',
    title: 'Full Team.',
    subtitle: 'Long-term velocity & roadmap ownership',
    quote: 'A dedicated sprint squad embedded inside your repo and daily standup.',
    accent: '#00F2FE',
    accentRgb: '0, 242, 254',
    image: '/assets/img/ondemand/model/01.jpg',
    activeIndex: 0,
    features: [
      '1 to 5 Senior Engineers (7+ yrs)',
      'Monthly predictable billing',
      'Scalable either direction in 30 days',
      'Direct Slack, Jira & GitHub access',
    ],
  },
  {
    id: 'pod',
    tag: '— Velocity Pod®',
    title: 'Pod Model.',
    subtitle: 'Autonomous feature delivery squad',
    quote: 'Cross-functional triad (Tech Lead + 2 Senior Devs) driving releases.',
    accent: '#9D4EDD',
    accentRgb: '157, 78, 221',
    image: '/assets/img/ondemand/model/02.jpg',
    activeIndex: 1,
    features: [
      'Tech Lead + 2 Full-Stack Engineers',
      'End-to-end feature ownership',
      'Bi-weekly milestone commitments',
      'Zero recruiter or placement fees',
    ],
  },
  {
    id: 'fractional',
    tag: '— Fractional Specialist®',
    title: 'On-Demand.',
    subtitle: 'Specialist hours & architectural review',
    quote: 'Targeted expertise for architecture audits, AI pipelines, or sprint crunches.',
    accent: '#EC4899',
    accentRgb: '236, 72, 153',
    image: '/assets/img/ondemand/model/03.jpg',
    activeIndex: 2,
    features: [
      'Principal & Staff Architects',
      '20 to 80 hours/month reserve',
      'Critical code & security reviews',
      'Available inside 48 hours notice',
    ],
  },
];

export default function BookmarkModels(props) {
  const models = props.models && props.models.length > 0 ? props.models : MODELS;
  return (
    <div
      style={{
        width: '100%',
        maxWidth: '1240px',
        margin: '0 auto',
        padding: '20px 0',
      }}
    >
      <div
        style={{
          display: 'grid',
          gridTemplateColumns: 'repeat(auto-fit, minmax(320px, 1fr))',
          gap: '32px',
          alignItems: 'stretch',
        }}
      >
        {models.map((model) => (
          <BookmarkCard key={model.id} model={model} />
        ))}
      </div>
    </div>
  );
}

function BookmarkCard({ model }) {
  const { tag, title, subtitle, quote, accent, accentRgb, image, activeIndex, features } = model;

  return (
    <motion.article
      whileHover={{ y: -8 }}
      transition={{ duration: 0.3, ease: [0.16, 1, 0.3, 1] }}
      style={{
        position: 'relative',
        background: '#070C1B',
        borderTopLeftRadius: '32px',
        borderBottomRightRadius: '32px',
        borderTopRightRadius: '16px',
        borderBottomLeftRadius: '16px',
        border: `1px solid rgba(${accentRgb}, 0.25)`,
        boxShadow: `0 24px 60px -15px rgba(0, 0, 0, 0.8), 0 0 30px rgba(${accentRgb}, 0.12)`,
        padding: '24px',
        display: 'flex',
        flexDirection: 'column',
        justifyContent: 'space-between',
        minHeight: '520px',
        overflow: 'hidden',
      }}
    >
      {/* Top Stepped Tab */}
      <div
        style={{
          display: 'flex',
          justifyContent: 'space-between',
          alignItems: 'center',
          marginBottom: '16px',
        }}
      >
        <div
          style={{
            display: 'inline-flex',
            alignItems: 'center',
            gap: '8px',
            padding: '6px 14px',
            borderRadius: '999px',
            background: `rgba(${accentRgb}, 0.1)`,
            border: `1px solid rgba(${accentRgb}, 0.3)`,
          }}
        >
          <span
            style={{
              fontFamily: 'Inter, sans-serif',
              fontSize: '11px',
              fontWeight: 700,
              color: accent,
              letterSpacing: '0.04em',
              textTransform: 'uppercase',
            }}
          >
            {tag}
          </span>
        </div>

        {/* Status Indicator */}
        <span
          style={{
            display: 'inline-flex',
            alignItems: 'center',
            gap: '6px',
            fontSize: '11px',
            color: 'rgba(203, 213, 225, 0.65)',
            fontFamily: 'Fira Code, monospace',
          }}
        >
          <span
            style={{
              width: '6px',
              height: '6px',
              borderRadius: '50%',
              background: accent,
              boxShadow: `0 0 8px ${accent}`,
            }}
          />
          Ready to Deploy
        </span>
      </div>

      {/* 3D Wave Visual Preview Box */}
      <div
        style={{
          position: 'relative',
          height: '160px',
          borderRadius: '18px',
          overflow: 'hidden',
          background: '#02050E',
          border: '1px solid rgba(255, 255, 255, 0.1)',
          marginBottom: '20px',
        }}
      >
        <img
          src={image}
          alt={title}
          style={{
            width: '100%',
            height: '100%',
            objectFit: 'cover',
            filter: 'contrast(1.08) brightness(0.95)',
          }}
          loading="lazy"
        />
        <div
          style={{
            position: 'absolute',
            inset: 0,
            background: `linear-gradient(180deg, rgba(7, 12, 27, 0.1) 0%, rgba(7, 12, 27, 0.85) 100%)`,
          }}
        />
        {/* Overlay quote */}
        <p
          style={{
            position: 'absolute',
            bottom: '12px',
            left: '14px',
            right: '14px',
            margin: 0,
            fontSize: '12px',
            lineHeight: 1.45,
            color: '#FFFFFF',
            fontWeight: 500,
            textShadow: '0 2px 8px rgba(0, 0, 0, 0.8)',
          }}
        >
          {quote}
        </p>
      </div>

      {/* Bold Headline & Subtitle */}
      <div style={{ marginBottom: '20px' }}>
        <h3
          style={{
            fontSize: 'clamp(2rem, 3vw, 2.6rem)',
            fontWeight: 800,
            color: '#F8FAFC',
            lineHeight: 1.1,
            letterSpacing: '-0.03em',
            margin: '0 0 8px',
          }}
        >
          {title}
        </h3>
        <p
          style={{
            fontSize: '13px',
            color: '#94A3B8',
            margin: 0,
            lineHeight: 1.5,
          }}
        >
          {subtitle}
        </p>
      </div>

      {/* Feature Bullet List */}
      <ul
        style={{
          listStyle: 'none',
          padding: 0,
          margin: '0 0 24px',
          display: 'flex',
          flexDirection: 'column',
          gap: '8px',
        }}
      >
        {features.map((feat, i) => (
          <li
            key={i}
            style={{
              display: 'flex',
              alignItems: 'center',
              gap: '10px',
              fontSize: '13px',
              color: '#CBD5E1',
            }}
          >
            <span
              style={{
                width: '16px',
                height: '16px',
                borderRadius: '50%',
                background: `rgba(${accentRgb}, 0.15)`,
                border: `1px solid rgba(${accentRgb}, 0.4)`,
                display: 'flex',
                alignItems: 'center',
                justifyContent: 'center',
                fontSize: '9px',
                color: accent,
                fontWeight: 800,
                flexShrink: 0,
              }}
            >
              ✓
            </span>
            <span>{feat}</span>
          </li>
        ))}
      </ul>

      {/* Bottom Notch & CTA Row */}
      <div
        style={{
          display: 'flex',
          alignItems: 'center',
          justifyContent: 'space-between',
          borderTop: '1px solid rgba(255, 255, 255, 0.08)',
          paddingTop: '16px',
        }}
      >
        {/* Pagination Dots */}
        <div style={{ display: 'flex', alignItems: 'center', gap: '6px' }}>
          {[0, 1, 2].map((idx) => {
            const isDotActive = activeIndex === idx;
            return (
              <span
                key={idx}
                style={{
                  width: isDotActive ? '18px' : '6px',
                  height: '6px',
                  borderRadius: '999px',
                  background: isDotActive ? accent : 'rgba(255, 255, 255, 0.15)',
                  boxShadow: isDotActive ? `0 0 8px ${accent}` : 'none',
                  transition: 'all 0.3s ease',
                }}
              />
            );
          })}
        </div>

        {/* CTA Button */}
        <button
          type="button"
          className="od-btn od-btn--primary"
          data-modal-open
          data-modal-service={`Engagement Model: ${title}`}
          style={{
            background: `linear-gradient(90deg, ${accent}, #3B82F6)`,
            color: '#040711',
            fontWeight: 800,
            fontSize: '12px',
            padding: '8px 16px',
            borderRadius: '999px',
            boxShadow: `0 4px 14px rgba(${accentRgb}, 0.35)`,
            cursor: 'pointer',
          }}
        >
          Select model →
        </button>
      </div>
    </motion.article>
  );
}
