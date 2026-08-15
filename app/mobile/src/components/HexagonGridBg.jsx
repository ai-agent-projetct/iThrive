import React, { useEffect, useRef } from 'react';

/**
 * Interactive Hexagon Grid Layer with 7 Mouse-X Position Color Zones
 * Color 1 (Full Left): Electric Cyan (#00bfff)
 * Color 2 (Half Left from Middle): Azure Blue (#0099ff)
 * Color 3 (Slight Left from Middle): Royal Blue (#1a75ff)
 * Color 4 (Middle): Cobalt Royal Blue (#2b56f5)
 * Color 5 (Slight Right from Middle): Electric Indigo (#4b32ea)
 * Color 6 (Half Right from Middle): Deep Blue Purple (#7c3aed)
 * Color 7 (Full Right): Vibrant Violet Magenta (#d946ef)
 */
export default function HexagonGridBg() {
  const canvasRef = useRef(null);

  useEffect(() => {
    const canvas = canvasRef.current;
    if (!canvas) return;

    const ctx = canvas.getContext('2d');
    let animationFrameId;

    let width = (canvas.width = window.innerWidth);
    let height = (canvas.height = window.innerHeight);

    const handleResize = () => {
      width = canvas.width = window.innerWidth;
      height = canvas.height = window.innerHeight;
    };
    window.addEventListener('resize', handleResize);

    let mouse = { x: width / 2, y: height / 2 };
    const handleMouseMove = (e) => {
      mouse.x = e.clientX;
      mouse.y = e.clientY;
    };
    window.addEventListener('mousemove', handleMouseMove);

    // 7 Exact Color Stops from User Request & Logo Palette
    const colorStops = [
      { r: 0, g: 191, b: 255, hex: '#00bfff' },   // 1. Full Left: Electric Cyan
      { r: 0, g: 153, b: 255, hex: '#0099ff' },   // 2. Half Left: Azure Blue
      { r: 26, g: 117, b: 255, hex: '#1a75ff' },  // 3. Slight Left: Royal Blue
      { r: 43, g: 86, b: 245, hex: '#2b56f5' },   // 4. Middle: Cobalt Royal Blue
      { r: 75, g: 50, b: 234, hex: '#4b32ea' },   // 5. Slight Right: Electric Indigo
      { r: 124, g: 58, b: 237, hex: '#7c3aed' },  // 6. Half Right: Deep Blue Purple
      { r: 217, g: 70, b: 239, hex: '#d946ef' }   // 7. Full Right: Violet Magenta
    ];

    // Helper to get active color based on mouse horizontal position (0.0 to 1.0)
    const getZoneColor = (xRatio) => {
      const clamped = Math.max(0, Math.min(1, xRatio));
      const indexFloat = clamped * (colorStops.length - 1);
      const idx = Math.floor(indexFloat);
      const nextIdx = Math.min(colorStops.length - 1, idx + 1);
      const factor = indexFloat - idx;

      const c1 = colorStops[idx];
      const c2 = colorStops[nextIdx];

      const r = Math.round(c1.r + (c2.r - c1.r) * factor);
      const g = Math.round(c1.g + (c2.g - c1.g) * factor);
      const b = Math.round(c1.b + (c2.b - c1.b) * factor);

      return { r, g, b, rgbStr: `${r}, ${g}, ${b}` };
    };

    const hexRadius = 30;
    const hexWidth = Math.sqrt(3) * hexRadius;
    const sideLength = (3 / 2) * hexRadius;

    // Draw Hexagon Cell with Mouse-Position Reactive Color
    const drawHexagon = (x, y, radius, hoverIntensity, activeColor) => {
      ctx.beginPath();
      for (let i = 0; i < 6; i++) {
        const angle = (Math.PI / 3) * i - Math.PI / 6;
        const hx = x + radius * Math.cos(angle);
        const hy = y + radius * Math.sin(angle);
        if (i === 0) ctx.moveTo(hx, hy);
        else ctx.lineTo(hx, hy);
      }
      ctx.closePath();

      if (hoverIntensity > 0.04) {
        const strokeAlpha = Math.min(0.98, hoverIntensity * 1.1);
        const fillAlpha = Math.min(0.35, hoverIntensity * 0.3);

        ctx.fillStyle = `rgba(${activeColor.rgbStr}, ${fillAlpha})`;
        ctx.fill();

        ctx.strokeStyle = `rgba(${activeColor.rgbStr}, ${strokeAlpha})`;
        ctx.lineWidth = 2.4;
        ctx.shadowColor = `rgb(${activeColor.rgbStr})`;
        ctx.shadowBlur = 18 * hoverIntensity;
      } else {
        // Dark Base Grid
        ctx.fillStyle = 'rgba(3, 6, 17, 0.4)';
        ctx.fill();

        ctx.strokeStyle = 'rgba(43, 86, 245, 0.08)';
        ctx.lineWidth = 0.8;
        ctx.shadowBlur = 0;
      }

      ctx.stroke();
    };

    const render = () => {
      ctx.clearRect(0, 0, width, height);

      const cols = Math.ceil(width / hexWidth) + 2;
      const rows = Math.ceil(height / sideLength) + 2;

      // Determine color zone based on mouse horizontal X position
      const mouseRatio = mouse.x / width;
      const activeColor = getZoneColor(mouseRatio);

      for (let r = -1; r < rows; r++) {
        for (let c = -1; c < cols; c++) {
          let x = c * hexWidth;
          let y = r * sideLength;

          if (r % 2 !== 0) {
            x += hexWidth / 2;
          }

          const dx = mouse.x - x;
          const dy = mouse.y - y;
          const dist = Math.sqrt(dx * dx + dy * dy);

          let hoverIntensity = 0;
          if (dist < 220) {
            hoverIntensity = 1 - dist / 220;
          }

          drawHexagon(x, y, hexRadius, hoverIntensity, activeColor);
        }
      }

      animationFrameId = requestAnimationFrame(render);
    };

    render();

    return () => {
      window.removeEventListener('resize', handleResize);
      window.removeEventListener('mousemove', handleMouseMove);
      cancelAnimationFrame(animationFrameId);
    };
  }, []);

  return (
    <canvas
      ref={canvasRef}
      className="fixed inset-0 pointer-events-none z-0 opacity-95"
    />
  );
}
