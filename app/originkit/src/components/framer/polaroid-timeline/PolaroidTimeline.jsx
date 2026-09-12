import React, { useState, useRef, useEffect, useMemo, useCallback } from "react";
import { motion, useScroll, useSpring } from "framer-motion";

function hexToRgba(hex, alpha) {
  if (!hex) return `rgba(0, 242, 254, ${alpha})`;
  if (hex.startsWith("rgba")) {
    return hex.replace(/[\d.]+\)$/g, `${alpha})`);
  }
  if (hex.startsWith("rgb(")) {
    return hex.replace("rgb(", "rgba(").replace(")", `, ${alpha})`);
  }
  const clean = hex.replace("#", "");
  const num = parseInt(clean.length === 3 ? clean.split("").map((c) => c + c).join("") : clean, 16);
  return `rgba(${(num >> 16) & 255}, ${(num >> 8) & 255}, ${num & 255}, ${alpha})`;
}

// ---------------------------------------------------------------------------
// 3D Map Pin Component
// ---------------------------------------------------------------------------
function Pin({ isActive, pinColor = "#00f2fe", pinSize = 36, glowColor = "#00f2fe", onClick }) {
  const headSize = pinSize;
  const stemHeight = pinSize * 0.85;
  const stemWidth = pinSize * 0.12;
  const totalHeight = headSize + stemHeight;

  return (
    <motion.div
      onClick={onClick}
      animate={{
        scale: isActive ? 1.15 : 1,
        rotate: isActive ? [0, -3, 3, -2, 2, 0] : 0,
      }}
      transition={{
        type: "spring",
        stiffness: 400,
        damping: 25,
        rotate: { duration: 0.6, ease: "easeInOut", times: [0, 0.2, 0.4, 0.6, 0.8, 1] },
      }}
      style={{
        position: "relative",
        width: headSize,
        height: totalHeight,
        flexShrink: 0,
        transformOrigin: "bottom center",
        cursor: "pointer",
      }}
    >
      {/* Active Pulse Glow Halo */}
      <motion.div
        initial={{ opacity: 0, scale: 1 }}
        animate={{
          opacity: isActive ? [0.45, 0.85, 0.45] : 0,
          scale: isActive ? [1, 1.35, 1] : 1,
        }}
        transition={{
          opacity: { duration: isActive ? 2.2 : 0.6, repeat: isActive ? Infinity : 0, ease: "easeInOut" },
          scale: { duration: isActive ? 2.2 : 0.6, repeat: isActive ? Infinity : 0, ease: "easeInOut" },
        }}
        style={{
          position: "absolute",
          top: headSize * -0.3,
          left: headSize * -0.3,
          width: headSize * 1.6,
          height: headSize * 1.6,
          borderRadius: "50%",
          background: `radial-gradient(circle, ${hexToRgba(glowColor, 0.45)} 0%, ${hexToRgba(glowColor, 0.2)} 40%, transparent 70%)`,
          pointerEvents: "none",
        }}
      />

      {/* Pin Head Sphere with Specular Sheen */}
      <motion.div
        animate={{
          boxShadow: isActive
            ? `0 6px 22px ${hexToRgba(pinColor, 0.5)}, 0 2px 8px rgba(0,0,0,0.6)`
            : "0 3px 10px rgba(0,0,0,0.45)",
        }}
        style={{
          position: "absolute",
          top: 0,
          left: "50%",
          transform: "translateX(-50%)",
          width: headSize,
          height: headSize,
          borderRadius: "50%",
          background: pinColor,
        }}
      >
        <div
          style={{
            position: "absolute",
            inset: 0,
            borderRadius: "50%",
            boxShadow:
              "inset 0 -8px 16px rgba(0,0,0,0.4), inset 0 6px 10px rgba(255,255,255,0.45)",
          }}
        />
        <div
          style={{
            position: "absolute",
            top: "14%",
            left: "20%",
            width: "32%",
            height: "28%",
            background: "rgba(255,255,255,0.85)",
            borderRadius: "50%",
            filter: "blur(2px)",
          }}
        />
        <div
          style={{
            position: "absolute",
            top: "18%",
            left: "26%",
            width: "14%",
            height: "12%",
            background: "rgba(255,255,255,0.95)",
            borderRadius: "50%",
          }}
        />
      </motion.div>

      {/* Needle Stem */}
      <div
        style={{
          position: "absolute",
          bottom: 0,
          left: "50%",
          transform: "translateX(-50%)",
          width: stemWidth,
          height: stemHeight,
          background: "linear-gradient(90deg, #888 0%, #ddd 30%, #fff 50%, #bbb 80%, #666 100%)",
          borderRadius: `${stemWidth / 2}px`,
          boxShadow: "0 2px 4px rgba(0,0,0,0.4)",
        }}
      />
      <div
        style={{
          position: "absolute",
          bottom: -stemHeight * 0.15,
          left: "50%",
          transform: "translateX(-50%)",
          width: 0,
          height: 0,
          borderLeft: `${stemWidth * 0.6}px solid transparent`,
          borderRight: `${stemWidth * 0.6}px solid transparent`,
          borderTop: `${stemHeight * 0.2}px solid #555`,
        }}
      />
    </motion.div>
  );
}

// ---------------------------------------------------------------------------
// 3D Polaroid Flip Card Component
// ---------------------------------------------------------------------------
function PolaroidCard({
  image,
  title,
  date,
  caption,
  flipText,
  isActive,
  tiltAngle = 0,
  borderThickness = 12,
  shadowIntensity = 1,
  flipSpeed = 0.6,
  index = 0,
  onImageClick,
}) {
  const [isFlipped, setIsFlipped] = useState(false);
  const cardWidth = 230;
  const cardHeight = 295;

  const tapeAngles = [-5, 4, -3, 5, -4, 3];
  const tapeAngle = tapeAngles[index % tapeAngles.length];

  const tapeGradients = [
    "linear-gradient(180deg, rgba(0, 242, 254, 0.85) 0%, rgba(0, 242, 254, 0.65) 100%)",
    "linear-gradient(180deg, rgba(168, 85, 247, 0.85) 0%, rgba(168, 85, 247, 0.65) 100%)",
    "linear-gradient(180deg, rgba(0, 242, 254, 0.8) 0%, rgba(168, 85, 247, 0.7) 100%)",
    "linear-gradient(180deg, rgba(59, 130, 246, 0.85) 0%, rgba(59, 130, 246, 0.65) 100%)",
    "linear-gradient(180deg, rgba(0, 242, 254, 0.9) 0%, rgba(0, 242, 254, 0.7) 100%)",
    "linear-gradient(180deg, rgba(168, 85, 247, 0.9) 0%, rgba(168, 85, 247, 0.7) 100%)",
  ];
  const tapeBg = tapeGradients[index % tapeGradients.length];

  return (
    <motion.div
      initial={{ opacity: 0, y: 30, scale: 0.9, rotateZ: tiltAngle - 4 }}
      animate={{
        opacity: isActive ? 1 : 0.45,
        y: isActive ? 0 : 12,
        rotateZ: tiltAngle,
        scale: isActive ? 1 : 0.94,
      }}
      whileHover={{
        scale: isActive ? 1.05 : 0.96,
        y: isActive ? -8 : 6,
        rotateZ: isActive ? tiltAngle * 0.4 : tiltAngle,
      }}
      transition={{
        duration: 0.5,
        ease: [0.4, 0, 0.2, 1],
        scale: { type: "spring", stiffness: 300, damping: 25 },
      }}
      onHoverStart={() => setIsFlipped(true)}
      onHoverEnd={() => setIsFlipped(false)}
      onClick={() => setIsFlipped(!isFlipped)}
      style={{
        perspective: 1200,
        cursor: "pointer",
        position: "relative",
      }}
    >
      <motion.div
        animate={{ rotateY: isFlipped ? 180 : 0 }}
        transition={{ duration: flipSpeed, ease: [0.4, 0, 0.2, 1] }}
        style={{
          width: cardWidth,
          height: cardHeight,
          transformStyle: "preserve-3d",
          position: "relative",
        }}
      >
        {/* FRONT SIDE: Authentic Polaroid Photo */}
        <motion.div
          animate={{
            boxShadow: isActive
              ? `0 ${14 * shadowIntensity}px ${36 * shadowIntensity}px rgba(0, 0, 0, 0.9), 0 0 25px rgba(0, 242, 254, 0.22)`
              : `0 ${6 * shadowIntensity}px ${16 * shadowIntensity}px rgba(0, 0, 0, 0.65)`,
          }}
          style={{
            position: "absolute",
            width: "100%",
            height: "100%",
            backfaceVisibility: "hidden",
            background: "linear-gradient(180deg, #FFFFFF 0%, #F8F9FA 60%, #F1F3F5 100%)",
            borderRadius: 8,
            padding: borderThickness,
            paddingBottom: borderThickness * 3.4,
            border: "1px solid rgba(255, 255, 255, 0.3)",
          }}
        >
          {/* Inner Photo Area */}
          <div
            onClick={(e) => {
              e.stopPropagation();
              onImageClick?.();
            }}
            style={{
              width: "100%",
              height: cardHeight - borderThickness * 4.6,
              overflow: "hidden",
              background: "#0a0e1a",
              borderRadius: 3,
              position: "relative",
              boxShadow: "inset 0 0 12px rgba(0, 0, 0, 0.3)",
            }}
          >
            <img
              src={image}
              alt={title}
              style={{
                width: "100%",
                height: "100%",
                objectFit: "cover",
                display: "block",
              }}
            />
            {/* Subtle Vignette & Film Grain */}
            <div
              style={{
                position: "absolute",
                inset: 0,
                background:
                  "linear-gradient(180deg, rgba(2, 4, 10, 0.1) 0%, rgba(2, 4, 10, 0.45) 100%)",
                pointerEvents: "none",
              }}
            />
            {/* Corner Zoom Badge */}
            <div
              style={{
                position: "absolute",
                bottom: 6,
                right: 6,
                background: "rgba(2, 4, 10, 0.75)",
                backdropFilter: "blur(4px)",
                padding: "2px 6px",
                borderRadius: 4,
                fontSize: 9,
                fontFamily: "monospace",
                color: "#00F2FE",
                border: "1px solid rgba(0, 242, 254, 0.3)",
              }}
            >
              ZOOM
            </div>
          </div>

          {/* Polaroid Bottom Caption & Date */}
          <div
            style={{
              position: "absolute",
              bottom: borderThickness * 0.9,
              left: borderThickness,
              right: borderThickness,
              textAlign: "left",
            }}
          >
            <div
              style={{
                fontSize: 12.5,
                color: "#1E293B",
                fontWeight: 700,
                letterSpacing: "-0.01em",
                lineHeight: 1.25,
                whiteSpace: "nowrap",
                overflow: "hidden",
                textOverflow: "ellipsis",
              }}
            >
              {caption || title}
            </div>
            <div
              style={{
                fontSize: 10.5,
                color: "#0284C7",
                fontFamily: "'Fira Code', monospace",
                fontWeight: 600,
                marginTop: 2,
                letterSpacing: "0.02em",
              }}
            >
              {date}
            </div>
          </div>

          {/* Decorative Sticky Tape at Top */}
          <div
            style={{
              position: "absolute",
              top: -9,
              left: "50%",
              transform: `translateX(-50%) rotate(${tapeAngle}deg)`,
              width: 54,
              height: 18,
              background: tapeBg,
              borderRadius: 2,
              boxShadow: "0 2px 6px rgba(0, 0, 0, 0.25)",
              opacity: 0.92,
              backdropFilter: "blur(2px)",
            }}
          />
        </motion.div>

        {/* BACK SIDE: Lined Index Card with Detailed Deliverables */}
        <div
          style={{
            position: "absolute",
            width: "100%",
            height: "100%",
            backfaceVisibility: "hidden",
            transform: "rotateY(180deg)",
            background: "linear-gradient(180deg, #090E1A 0%, #040711 100%)",
            borderRadius: 8,
            padding: "20px 18px",
            boxShadow: `0 ${12 * shadowIntensity}px ${32 * shadowIntensity}px rgba(0, 0, 0, 0.9), 0 0 25px rgba(0, 242, 254, 0.18)`,
            display: "flex",
            flexDirection: "column",
            justifyContent: "space-between",
            border: "1px solid rgba(0, 242, 254, 0.35)",
            overflow: "hidden",
            color: "#FFFFFF",
          }}
        >
          {/* Vertical Red Accent Line */}
          <div
            style={{
              position: "absolute",
              top: 0,
              left: 22,
              width: 2,
              height: "100%",
              background: "#00F2FE",
              opacity: 0.5,
            }}
          />

          {/* Header Info */}
          <div style={{ paddingLeft: 14, position: "relative", zIndex: 1 }}>
            <div
              style={{
                fontFamily: "'Fira Code', monospace",
                fontSize: 10,
                fontWeight: 800,
                color: "#00F2FE",
                textTransform: "uppercase",
                letterSpacing: "0.08em",
                marginBottom: 4,
              }}
            >
              {date}
            </div>
            <h4
              style={{
                fontSize: 15,
                fontWeight: 800,
                color: "#FFFFFF",
                margin: 0,
                lineHeight: 1.25,
              }}
            >
              {title}
            </h4>
          </div>

          {/* Narrative / Deliverables on Back */}
          <div style={{ paddingLeft: 14, position: "relative", zIndex: 1 }}>
            <p
              style={{
                margin: 0,
                fontSize: 11.5,
                lineHeight: 1.55,
                color: "#CBD5E1",
              }}
            >
              {flipText}
            </p>
          </div>

          {/* Footer Action */}
          <div
            style={{
              paddingLeft: 14,
              display: "flex",
              alignItems: "center",
              justifyContent: "space-between",
              borderTop: "1px solid rgba(255, 255, 255, 0.1)",
              paddingTop: 8,
              fontSize: 10,
              fontFamily: "'Fira Code', monospace",
              color: "rgba(0, 242, 254, 0.8)",
            }}
          >
            <span>STAGE 0{index + 1}</span>
            <span>FLIP ↺</span>
          </div>
        </div>
      </motion.div>
    </motion.div>
  );
}

// ---------------------------------------------------------------------------
// Main Polaroid Timeline Component
// ---------------------------------------------------------------------------
export default function PolaroidTimeline(props) {
  const {
    milestones = [],
    stringColor = "#00f2fe",
    pinColor = "#00f2fe",
    pinGlowColor = "#00f2fe",
    curveStyle = "wavy",
    stringThickness = 3,
    pinSize = 36,
  } = props;

  const containerRef = useRef(null);
  const pathRef = useRef(null);
  const [containerWidth, setContainerWidth] = useState(800);
  const [lightboxMilestone, setLightboxMilestone] = useState(null);

  useEffect(() => {
    const handleResize = () => {
      if (containerRef.current) {
        setContainerWidth(containerRef.current.offsetWidth);
      }
    };
    handleResize();
    window.addEventListener("resize", handleResize);
    return () => window.removeEventListener("resize", handleResize);
  }, []);

  const total = milestones.length;

  const { scrollYProgress } = useScroll({
    target: containerRef,
    offset: ["start 75%", "end 25%"],
  });

  const smoothProgress = useSpring(scrollYProgress, {
    stiffness: 280,
    damping: 45,
  });

  const [activeStep, setActiveStep] = useState(0);

  useEffect(() => {
    return smoothProgress.on("change", (latest) => {
      const step = Math.min(total - 1, Math.floor(latest * total * 1.05));
      setActiveStep(Math.max(0, step));
    });
  }, [smoothProgress, total]);

  // Generate Winding String Path
  const rowHeight = 270;
  const totalHeight = Math.max(700, total * rowHeight);

  const pathData = useMemo(() => {
    const centerX = containerWidth / 2;
    const amplitude = curveStyle === "gentle" ? 60 : curveStyle === "wavy" ? 110 : 160;
    const startY = 40;
    let d = `M ${centerX},${startY}`;

    for (let i = 0; i < total - 1; i++) {
      const y1 = startY + i * rowHeight;
      const y2 = startY + (i + 1) * rowHeight;
      const midY = (y1 + y2) / 2;
      const sign = i % 2 === 0 ? 1 : -1;
      const cpX = centerX + amplitude * sign;
      d += ` Q ${cpX},${midY} ${centerX},${y2}`;
    }

    return d;
  }, [containerWidth, total, curveStyle, rowHeight]);

  const scrollToMilestone = useCallback((index) => {
    if (!containerRef.current) return;
    const rect = containerRef.current.getBoundingClientRect();
    const targetY = window.scrollY + rect.top + index * rowHeight - 120;
    window.scrollTo({ top: targetY, behavior: "smooth" });
  }, [rowHeight]);

  return (
    <div
      ref={containerRef}
      style={{
        position: "relative",
        width: "100%",
        minHeight: totalHeight,
        margin: "0 auto",
        padding: "40px 0 60px",
      }}
    >
      {/* SVG String Path with Glowing Cyber Neon & Shadow */}
      <svg
        style={{
          position: "absolute",
          top: 0,
          left: 0,
          width: "100%",
          height: totalHeight,
          pointerEvents: "none",
          overflow: "visible",
          zIndex: 1,
        }}
      >
        <defs>
          <linearGradient id="neonStringGrad" x1="0%" y1="0%" x2="0%" y2="100%">
            <stop offset="0%" stopColor={stringColor} stopOpacity="0.8" />
            <stop offset="50%" stopColor="#A855F7" stopOpacity="0.9" />
            <stop offset="100%" stopColor={stringColor} stopOpacity="1" />
          </linearGradient>
          <filter id="stringGlow" x="-20%" y="-20%" width="140%" height="140%">
            <feGaussianBlur stdDeviation="5" result="blur" />
            <feComposite in="SourceGraphic" in2="blur" operator="over" />
          </filter>
        </defs>

        {/* Base guide track */}
        <path
          d={pathData}
          fill="none"
          stroke="rgba(255, 255, 255, 0.1)"
          strokeWidth={stringThickness}
          strokeDasharray="6 6"
        />

        {/* Ambient Neon Bloom */}
        <path
          d={pathData}
          fill="none"
          stroke={stringColor}
          strokeWidth={stringThickness * 3.5}
          strokeLinecap="round"
          opacity={0.25}
          style={{ filter: "blur(8px)" }}
        />

        {/* Glowing Active String */}
        <path
          ref={pathRef}
          d={pathData}
          fill="none"
          stroke="url(#neonStringGrad)"
          strokeWidth={stringThickness}
          strokeLinecap="round"
          filter="url(#stringGlow)"
        />
      </svg>

      {/* Alternating Milestone Rows with Central Pin */}
      <div
        style={{
          position: "relative",
          zIndex: 2,
          display: "flex",
          flexDirection: "column",
          gap: 0,
        }}
      >
        {milestones.map((m, idx) => {
          const isLeft = idx % 2 === 0;
          const tiltAngles = [-4, 5, -3, 4, -5, 3];
          const tilt = tiltAngles[idx % tiltAngles.length];
          const isActive = idx <= activeStep;

          return (
            <div
              key={idx}
              style={{
                display: "grid",
                gridTemplateColumns: "1fr 70px 1fr",
                alignItems: "center",
                height: rowHeight,
                width: "100%",
              }}
            >
              {/* Left Column */}
              <div
                style={{
                  display: "flex",
                  justifyContent: "flex-end",
                  paddingRight: 24,
                }}
              >
                {isLeft && (
                  <PolaroidCard
                    image={m.image}
                    title={m.title}
                    date={m.date}
                    caption={m.caption}
                    flipText={m.flipText}
                    isActive={isActive}
                    tiltAngle={tilt}
                    index={idx}
                    onImageClick={() => setLightboxMilestone(m)}
                  />
                )}
              </div>

              {/* Center Map Pin along String */}
              <div
                style={{
                  display: "flex",
                  justifyContent: "center",
                  alignItems: "center",
                  zIndex: 5,
                }}
              >
                <Pin
                  isActive={isActive}
                  pinColor={pinColor}
                  pinSize={pinSize}
                  glowColor={pinGlowColor}
                  onClick={() => scrollToMilestone(idx)}
                />
              </div>

              {/* Right Column */}
              <div
                style={{
                  display: "flex",
                  justifyContent: "flex-start",
                  paddingLeft: 24,
                }}
              >
                {!isLeft && (
                  <PolaroidCard
                    image={m.image}
                    title={m.title}
                    date={m.date}
                    caption={m.caption}
                    flipText={m.flipText}
                    isActive={isActive}
                    tiltAngle={tilt}
                    index={idx}
                    onImageClick={() => setLightboxMilestone(m)}
                  />
                )}
              </div>
            </div>
          );
        })}
      </div>

      {/* Lightbox Modal */}
      {lightboxMilestone && (
        <div
          onClick={() => setLightboxMilestone(null)}
          style={{
            position: "fixed",
            inset: 0,
            background: "rgba(2, 4, 10, 0.92)",
            backdropFilter: "blur(14px)",
            zIndex: 9999,
            display: "flex",
            alignItems: "center",
            justifyContent: "center",
            padding: 24,
            cursor: "zoom-out",
          }}
        >
          <div
            onClick={(e) => e.stopPropagation()}
            style={{
              position: "relative",
              maxWidth: 720,
              width: "100%",
              background: "#090E1A",
              borderRadius: 16,
              overflow: "hidden",
              border: "1px solid rgba(0, 242, 254, 0.4)",
              boxShadow: "0 25px 80px rgba(0, 0, 0, 0.95), 0 0 45px rgba(0, 242, 254, 0.25)",
              cursor: "default",
            }}
          >
            <div style={{ position: "relative", width: "100%", aspectRatio: "16/10" }}>
              <img
                src={lightboxMilestone.image}
                alt={lightboxMilestone.title}
                style={{ width: "100%", height: "100%", objectFit: "cover" }}
              />
            </div>
            <div style={{ padding: 24 }}>
              <div
                style={{
                  fontFamily: "'Fira Code', monospace",
                  fontSize: 12,
                  fontWeight: 800,
                  color: "#00F2FE",
                  marginBottom: 6,
                }}
              >
                {lightboxMilestone.date}
              </div>
              <h3 style={{ fontSize: 20, fontWeight: 800, color: "#FFFFFF", margin: "0 0 10px" }}>
                {lightboxMilestone.title}
              </h3>
              <p style={{ fontSize: 13.5, lineHeight: 1.6, color: "#CBD5E1", margin: 0 }}>
                {lightboxMilestone.flipText}
              </p>
            </div>
            <button
              onClick={() => setLightboxMilestone(null)}
              style={{
                position: "absolute",
                top: 16,
                right: 16,
                width: 36,
                height: 36,
                borderRadius: "50%",
                background: "rgba(2, 4, 10, 0.8)",
                border: "1px solid rgba(0, 242, 254, 0.4)",
                color: "#FFFFFF",
                fontSize: 18,
                cursor: "pointer",
                display: "flex",
                alignItems: "center",
                justifyContent: "center",
              }}
            >
              ✕
            </button>
          </div>
        </div>
      )}
    </div>
  );
}
