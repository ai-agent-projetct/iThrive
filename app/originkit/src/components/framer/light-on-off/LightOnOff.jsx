import React, { useState } from 'react';

/**
 * Light: Off/On interactive component
 * Recreates the Framer component by Victoria with exact visual fidelity,
 * dual independent room lights, glassmorphic interactive toggles,
 * smooth cross-fading illumination, and progressive blur text footer.
 */
export default function LightOnOff({
  baseSrc = '/assets/img/light-on-off/base.jpg',
  topLightSrc = '/assets/img/light-on-off/top-light.png',
  bottomLightSrc = '/assets/img/light-on-off/bottom-light.png',
  title = 'Light On/Off',
  subtitle = 'component',
  initialTop = true,
  initialBottom = true,
  className = '',
}) {
  const [topLight, setTopLight] = useState(initialTop);
  const [bottomLight, setBottomLight] = useState(initialBottom);

  return (
    <div
      className={`light-card-wrapper ${className}`}
      style={{
        position: 'relative',
        width: '100%',
        maxWidth: '512px',
        height: 'clamp(440px, 55vw, 600px)',
        aspectRatio: '512 / 600',
        borderRadius: 'clamp(28px, 6vw, 64px)',
        overflow: 'hidden',
        boxShadow: '0 30px 60px -12px rgba(0, 0, 0, 0.6), 0 0 0 1px rgba(255, 255, 255, 0.08)',
        background: '#0a0d12',
        margin: '0 auto',
        userSelect: 'none',
        WebkitUserSelect: 'none',
      }}
    >
      {/* 1. Base Image (Dark House) */}
      <img
        src={baseSrc}
        alt="Architectural structure at night"
        style={{
          position: 'absolute',
          inset: 0,
          width: '100%',
          height: '100%',
          objectFit: 'cover',
          display: 'block',
          zIndex: 1,
        }}
        loading="eager"
      />

      {/* 2. Top Window Light Overlay */}
      <img
        src={topLightSrc}
        alt=""
        aria-hidden="true"
        style={{
          position: 'absolute',
          inset: 0,
          width: '100%',
          height: '100%',
          objectFit: 'cover',
          display: 'block',
          zIndex: 2,
          opacity: topLight ? 0 : 1,
          transition: 'opacity 0.5s cubic-bezier(0.4, 0, 0.2, 1)',
          pointerEvents: 'none',
        }}
      />

      {/* 3. Bottom Window Light Overlay */}
      <img
        src={bottomLightSrc}
        alt=""
        aria-hidden="true"
        style={{
          position: 'absolute',
          inset: 0,
          width: '100%',
          height: '100%',
          objectFit: 'cover',
          display: 'block',
          zIndex: 3,
          opacity: bottomLight ? 0 : 1,
          transition: 'opacity 0.5s cubic-bezier(0.4, 0, 0.2, 1)',
          pointerEvents: 'none',
        }}
      />

      {/* 4. Top Floor Toggle Switch */}
      <button
        type="button"
        aria-label={`Turn top light ${topLight ? 'off' : 'on'}`}
        data-framer-name="top-switch"
        onClick={() => setTopLight((prev) => !prev)}
        style={{
          position: 'absolute',
          top: '15%',
          left: '21.5%',
          width: 'clamp(48px, 11vw, 64px)',
          height: 'clamp(48px, 11vw, 64px)',
          borderRadius: '50%',
          background: 'rgba(59, 58, 58, 0.65)',
          backdropFilter: 'blur(8px)',
          WebkitBackdropFilter: 'blur(8px)',
          border: '1px solid rgba(255, 255, 255, 0.15)',
          color: '#ffffff',
          fontFamily: "'Poppins', sans-serif",
          fontSize: 'clamp(12px, 2.5vw, 15px)',
          fontWeight: 500,
          cursor: 'pointer',
          zIndex: 10,
          display: 'flex',
          alignItems: 'center',
          justifyContent: 'center',
          padding: 0,
          outline: 'none',
          boxShadow: '0 6px 16px rgba(0, 0, 0, 0.35)',
          transition: 'transform 0.2s cubic-bezier(0.34, 1.56, 0.64, 1), background-color 0.2s ease, box-shadow 0.2s ease',
        }}
        onMouseEnter={(e) => {
          e.currentTarget.style.transform = 'scale(1.09)';
          e.currentTarget.style.backgroundColor = 'rgba(78, 77, 77, 0.8)';
          e.currentTarget.style.boxShadow = '0 8px 24px rgba(0, 0, 0, 0.5), 0 0 16px rgba(255, 220, 150, 0.2)';
        }}
        onMouseLeave={(e) => {
          e.currentTarget.style.transform = 'scale(1)';
          e.currentTarget.style.backgroundColor = 'rgba(59, 58, 58, 0.65)';
          e.currentTarget.style.boxShadow = '0 6px 16px rgba(0, 0, 0, 0.35)';
        }}
        onMouseDown={(e) => {
          e.currentTarget.style.transform = 'scale(0.94)';
        }}
        onMouseUp={(e) => {
          e.currentTarget.style.transform = 'scale(1.09)';
        }}
      >
        {topLight ? 'off' : 'on'}
      </button>

      {/* 5. Bottom Floor Toggle Switch */}
      <button
        type="button"
        aria-label={`Turn bottom light ${bottomLight ? 'off' : 'on'}`}
        data-framer-name="bottom-switch"
        onClick={() => setBottomLight((prev) => !prev)}
        style={{
          position: 'absolute',
          top: '42%',
          left: '68.3%',
          width: 'clamp(48px, 11vw, 64px)',
          height: 'clamp(48px, 11vw, 64px)',
          borderRadius: '50%',
          background: 'rgba(59, 58, 58, 0.65)',
          backdropFilter: 'blur(8px)',
          WebkitBackdropFilter: 'blur(8px)',
          border: '1px solid rgba(255, 255, 255, 0.15)',
          color: '#ffffff',
          fontFamily: "'Poppins', sans-serif",
          fontSize: 'clamp(12px, 2.5vw, 15px)',
          fontWeight: 500,
          cursor: 'pointer',
          zIndex: 10,
          display: 'flex',
          alignItems: 'center',
          justifyContent: 'center',
          padding: 0,
          outline: 'none',
          boxShadow: '0 6px 16px rgba(0, 0, 0, 0.35)',
          transition: 'transform 0.2s cubic-bezier(0.34, 1.56, 0.64, 1), background-color 0.2s ease, box-shadow 0.2s ease',
        }}
        onMouseEnter={(e) => {
          e.currentTarget.style.transform = 'scale(1.09)';
          e.currentTarget.style.backgroundColor = 'rgba(78, 77, 77, 0.8)';
          e.currentTarget.style.boxShadow = '0 8px 24px rgba(0, 0, 0, 0.5), 0 0 16px rgba(255, 220, 150, 0.2)';
        }}
        onMouseLeave={(e) => {
          e.currentTarget.style.transform = 'scale(1)';
          e.currentTarget.style.backgroundColor = 'rgba(59, 58, 58, 0.65)';
          e.currentTarget.style.boxShadow = '0 6px 16px rgba(0, 0, 0, 0.35)';
        }}
        onMouseDown={(e) => {
          e.currentTarget.style.transform = 'scale(0.94)';
        }}
        onMouseUp={(e) => {
          e.currentTarget.style.transform = 'scale(1.09)';
        }}
      >
        {bottomLight ? 'off' : 'on'}
      </button>

      {/* 6. Progressive Blur Backdrop at Bottom */}
      <div
        aria-hidden="true"
        style={{
          position: 'absolute',
          bottom: 0,
          left: 0,
          right: 0,
          height: '42%',
          background: 'linear-gradient(to top, rgba(0, 0, 0, 0.85) 0%, rgba(0, 0, 0, 0.35) 60%, transparent 100%)',
          backdropFilter: 'blur(2px)',
          WebkitBackdropFilter: 'blur(2px)',
          maskImage: 'linear-gradient(to top, black 40%, transparent 100%)',
          WebkitMaskImage: 'linear-gradient(to top, black 40%, transparent 100%)',
          zIndex: 4,
          pointerEvents: 'none',
        }}
      />

      {/* 7. Typography Overlay (Light On/Off component) */}
      <div
        style={{
          position: 'absolute',
          bottom: 'clamp(24px, 5vw, 42px)',
          left: 'clamp(24px, 6vw, 44px)',
          right: 'clamp(24px, 6vw, 44px)',
          zIndex: 10,
          pointerEvents: 'none',
        }}
      >
        <h3
          style={{
            fontFamily: "'Poppins', sans-serif",
            fontSize: 'clamp(1.9rem, 4.8vw, 3.4rem)',
            fontWeight: 100,
            lineHeight: 1.15,
            letterSpacing: '-0.02em',
            color: '#ffffff',
            margin: 0,
            padding: 0,
            textShadow: '0 2px 14px rgba(0, 0, 0, 0.4)',
          }}
        >
          {title}
        </h3>
        <p
          style={{
            fontFamily: "'Poppins', sans-serif",
            fontSize: 'clamp(0.85rem, 1.8vw, 1.05rem)',
            fontWeight: 600,
            lineHeight: 1.2,
            letterSpacing: '0.02em',
            color: 'rgba(255, 255, 255, 0.45)',
            margin: '6px 0 0 0',
            padding: 0,
          }}
        >
          {subtitle}
        </p>
      </div>
    </div>
  );
}
