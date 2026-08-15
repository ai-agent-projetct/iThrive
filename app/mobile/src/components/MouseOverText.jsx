import React, { useState } from 'react';
import { playHoverSound, playClickSound } from './AudioEngine';

/**
 * MouseOverText component
 * Default state: Pure Crisp White (#ffffff)
 * Mouseover state: Dynamic iThrive Blue (#00bfff / #2b56f5) with neon text shadow
 */
export default function MouseOverText({
  text,
  children,
  className = '',
  hoverColor = '#00bfff',
  variant = 'glow',
  as = 'span',
  onClick
}) {
  const [isHovered, setIsHovered] = useState(false);
  const [activeHoverColor, setActiveHoverColor] = useState('#00bfff');

  const Component = as;

  const handleMouseMove = (e) => {
    // Determine 7 mouse X zone color
    const ratio = e.clientX / window.innerWidth;
    let col = '#00bfff';
    if (ratio < 0.14) col = '#00bfff';       // 1. Full Left: Electric Cyan
    else if (ratio < 0.28) col = '#0099ff';  // 2. Half Left: Azure Blue
    else if (ratio < 0.42) col = '#1a75ff';  // 3. Slight Left: Royal Blue
    else if (ratio < 0.57) col = '#2b56f5';  // 4. Middle: Cobalt Blue
    else if (ratio < 0.71) col = '#4b32ea';  // 5. Slight Right: Indigo
    else if (ratio < 0.85) col = '#7c3aed';  // 6. Half Right: Purple
    else col = '#d946ef';                    // 7. Full Right: Magenta

    setActiveHoverColor(col);
  };

  const handleMouseEnter = (e) => {
    setIsHovered(true);
    handleMouseMove(e);
    playHoverSound();
  };

  const handleClick = (e) => {
    playClickSound();
    if (onClick) onClick(e);
  };

  // Split-letter interactive text (Default White -> Hover Electric Blue)
  if (text && (variant === 'split' || variant === 'letters')) {
    const words = text.split(' ');
    return (
      <Component 
        className={`inline-block ${className}`}
        onClick={handleClick}
        onMouseMove={handleMouseMove}
      >
        {words.map((word, wIdx) => (
          <span key={wIdx} className="inline-block mr-2.5 whitespace-nowrap">
            {word.split('').map((char, cIdx) => (
              <span
                key={cIdx}
                className="inline-block text-white transition-all duration-200 cursor-pointer select-none"
                style={{
                  transitionDelay: `${cIdx * 20}ms`
                }}
                onMouseEnter={(e) => {
                  playHoverSound();
                  e.currentTarget.style.color = activeHoverColor;
                  e.currentTarget.style.textShadow = `0 0 18px ${activeHoverColor}, 0 0 36px #2b56f5`;
                  e.currentTarget.style.transform = 'translateY(-3px) scale(1.15)';
                }}
                onMouseLeave={(e) => {
                  e.currentTarget.style.color = '#ffffff';
                  e.currentTarget.style.textShadow = '';
                  e.currentTarget.style.transform = '';
                }}
              >
                {char}
              </span>
            ))}
          </span>
        ))}
      </Component>
    );
  }

  const getStyle = () => {
    if (!isHovered) return { color: '#ffffff' };

    return {
      color: activeHoverColor,
      textShadow: `0 0 20px ${activeHoverColor}, 0 0 40px #2b56f5`,
      transform: 'translateY(-2px)'
    };
  };

  return (
    <Component
      className={`transition-all duration-300 cursor-pointer text-white ${className}`}
      style={getStyle()}
      onMouseEnter={handleMouseEnter}
      onMouseLeave={() => setIsHovered(false)}
      onMouseMove={handleMouseMove}
      onClick={handleClick}
    >
      {text || children}
    </Component>
  );
}
