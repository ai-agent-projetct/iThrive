import React, { useRef, useEffect, useState, startTransition } from "react";
import { motion, useScroll, useTransform, useSpring } from "framer-motion";

const RESPONSIVE = {
  desktop: {
    leftFont: "38px",
    rightFont: "38px",
    textWidth: "300px",
    centerFont: "24px",
    playSize: "52px",
    gap: "28px",
    startWidth: "16vw",
    startHeight: "7vh",
  },
  tablet: {
    leftFont: "28px",
    rightFont: "28px",
    textWidth: "220px",
    centerFont: "20px",
    playSize: "46px",
    gap: "20px",
    startWidth: "22vw",
    startHeight: "8vh",
  },
  mobile: {
    leftFont: "18px",
    rightFont: "18px",
    textWidth: "130px",
    centerFont: "15px",
    playSize: "38px",
    gap: "10px",
    startWidth: "28vw",
    startHeight: "8vh",
  },
};

const renderIcon = (iconType, screen, buttonBgColor, buttonTextColor) => {
  if (iconType === "none") return null;
  const current = RESPONSIVE[screen];
  const iconSize = screen === "mobile" ? 15 : 20;

  if (iconType === "play") {
    return (
      <div
        style={{
          display: "flex",
          alignItems: "center",
          justifyContent: "center",
          background: buttonBgColor,
          width: current.playSize,
          height: current.playSize,
          borderRadius: "50%",
          flexShrink: 0,
          border: "1px solid rgba(0, 242, 254, 0.4)",
          boxShadow: "0 0 16px rgba(0, 242, 254, 0.25)",
        }}
      >
        <div
          style={{
            position: "relative",
            left: "2px",
            borderStyle: "solid",
            borderWidth: screen === "mobile" ? "6px 0px 6px 12px" : "8px 0px 8px 16px",
            borderColor: `transparent transparent transparent ${buttonTextColor}`,
          }}
        />
      </div>
    );
  }

  return (
    <div
      style={{
        display: "flex",
        alignItems: "center",
        justifyContent: "center",
        background: buttonBgColor,
        width: current.playSize,
        height: current.playSize,
        borderRadius: "50%",
        flexShrink: 0,
        border: "1px solid rgba(0, 242, 254, 0.4)",
        boxShadow: "0 0 16px rgba(0, 242, 254, 0.25)",
      }}
    >
      <svg
        width={iconSize}
        height={iconSize}
        viewBox="0 0 24 24"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
      >
        <path
          d="M5 12H19M19 12L12 5M19 12L12 19"
          stroke={buttonTextColor}
          strokeWidth="2.5"
          strokeLinecap="round"
          strokeLinejoin="round"
        />
      </svg>
    </div>
  );
};

export default function ScrollZoomReveal(props) {
  const {
    image,
    videoUrl,
    autoPlay = false,
    loop = true,
    muted = true,
    leftText = "YOUR WEBSITE IS THE ONLY",
    rightText = "SALESPERSON THAT NEVER SLEEPS",
    buttonText = "3D Architecture Blueprint",
    buttonLink = "#build",
    textColor = "#FFFFFF",
    buttonTextColor = "#00F2FE",
    buttonBgColor = "rgba(2, 4, 10, 0.8)",
    animationStiffness = 90,
    animationDamping = 25,
    animationMass = 0.6,
    iconType = "arrow",
  } = props;

  const ref = useRef(null);
  const videoRef = useRef(null);
  const [isPlaying, setIsPlaying] = useState(autoPlay);
  const [screen, setScreen] = useState("desktop");

  useEffect(() => {
    const handleResize = () => {
      if (window.innerWidth <= 810) {
        startTransition(() => setScreen("mobile"));
      } else if (window.innerWidth <= 1280) {
        startTransition(() => setScreen("tablet"));
      } else {
        startTransition(() => setScreen("desktop"));
      }
    };
    handleResize();
    window.addEventListener("resize", handleResize);
    return () => window.removeEventListener("resize", handleResize);
  }, []);

  const current = RESPONSIVE[screen];
  const imageSrc =
    typeof image === "string"
      ? image
      : image?.src || "/assets/img/web-dev/web-hero-architecture.jpg";

  const { scrollYProgress } = useScroll({
    target: ref,
    offset: ["start start", "end end"],
  });

  const width = useTransform(scrollYProgress, [0, 1], [current.startWidth, "100%"]);
  const height = useTransform(scrollYProgress, [0, 1], [current.startHeight, "74vh"]);
  const rawRadius = useTransform(scrollYProgress, [0, 1], [40, 16]);
  const borderRadius = useSpring(rawRadius, {
    stiffness: animationStiffness,
    damping: animationDamping,
    mass: animationMass,
  });

  const centerTextOpacity = useTransform(scrollYProgress, [0.35, 0.65], [0, 1]);
  const centerTextY = useTransform(scrollYProgress, [0.35, 0.65], [40, 0]);

  const handlePlayClick = (e) => {
    if (videoUrl) {
      e.preventDefault();
      setIsPlaying(true);
      if (videoRef.current) videoRef.current.play();
    }
  };

  return (
    <section
      ref={ref}
      style={{
        height: "200vh",
        position: "relative",
        background: "transparent",
      }}
    >
      <div
        style={{
          position: "sticky",
          top: 72,
          height: "calc(100vh - 72px)",
          display: "flex",
          alignItems: "center",
          justifyContent: "center",
          gap: current.gap,
          padding: "0 24px",
          overflow: "hidden",
        }}
      >
        {/* Left Text */}
        <div
          style={{
            width: current.textWidth,
            textAlign: "right",
            fontWeight: 800,
            fontFamily: "'Space Grotesk', -apple-system, sans-serif",
            letterSpacing: "-0.03em",
            lineHeight: 1.1,
            color: textColor,
            fontSize: current.leftFont,
            textShadow: "0 0 20px rgba(0, 242, 254, 0.2)",
          }}
        >
          {leftText}
        </div>

        {/* Central Zooming Card / Portal */}
        <motion.div
          style={{
            width,
            height,
            borderRadius,
            overflow: "hidden",
            position: "relative",
            flexShrink: 0,
            background: "#02040a",
            border: "1px solid rgba(0, 242, 254, 0.35)",
            boxShadow:
              "0 25px 60px -15px rgba(0, 0, 0, 0.95), 0 0 45px rgba(0, 242, 254, 0.18)",
          }}
        >
          <motion.img
            src={imageSrc}
            alt={typeof image === "object" ? image.alt || "3D Architecture" : "3D Architecture"}
            style={{
              position: "absolute",
              left: "50%",
              top: "50%",
              width: "100%",
              height: "100%",
              objectFit: "cover",
              transform: "translate(-50%, -50%)",
              opacity: isPlaying ? 0 : 1,
              transition: "opacity 0.4s ease",
            }}
          />

          {/* Cyber Vignette Overlay */}
          <div
            style={{
              position: "absolute",
              inset: 0,
              background:
                "radial-gradient(circle at center, rgba(2, 4, 10, 0.15) 0%, rgba(2, 4, 10, 0.75) 100%)",
              pointerEvents: "none",
            }}
          />

          {videoUrl && (
            <video
              ref={videoRef}
              autoPlay={autoPlay}
              loop={loop}
              muted={muted}
              playsInline
              style={{
                position: "absolute",
                left: 0,
                top: 0,
                width: "100%",
                height: "100%",
                objectFit: "cover",
                opacity: isPlaying ? 1 : 0,
                pointerEvents: isPlaying ? "auto" : "none",
                transition: "opacity 0.4s ease",
              }}
            >
              <source src={videoUrl} type="video/mp4" />
            </video>
          )}

          {!isPlaying && (
            <motion.a
              href={buttonLink}
              onClick={handlePlayClick}
              aria-label={buttonText}
              style={{
                position: "absolute",
                top: "50%",
                left: "50%",
                translateX: "-50%",
                translateY: "-50%",
                opacity: centerTextOpacity,
                y: centerTextY,
                display: "flex",
                alignItems: "center",
                justifyContent: "center",
                gap: "14px",
                fontFamily: "'Space Grotesk', sans-serif",
                fontWeight: 700,
                color: "#FFFFFF",
                textAlign: "center",
                textDecoration: "none",
                whiteSpace: "nowrap",
                fontSize: current.centerFont,
                cursor: "pointer",
                zIndex: 10,
                background: "rgba(2, 4, 10, 0.75)",
                backdropFilter: "blur(12px)",
                padding: "14px 28px",
                borderRadius: "999px",
                border: "1px solid rgba(0, 242, 254, 0.4)",
                boxShadow:
                  "0 10px 30px rgba(0, 0, 0, 0.8), 0 0 25px rgba(0, 242, 254, 0.3)",
              }}
            >
              <span>{buttonText}</span>
              {renderIcon(iconType, screen, buttonBgColor, buttonTextColor)}
            </motion.a>
          )}
        </motion.div>

        {/* Right Text */}
        <div
          style={{
            width: current.textWidth,
            textAlign: "left",
            fontWeight: 800,
            fontFamily: "'Space Grotesk', -apple-system, sans-serif",
            letterSpacing: "-0.03em",
            lineHeight: 1.1,
            color: textColor,
            fontSize: current.rightFont,
            textShadow: "0 0 20px rgba(0, 242, 254, 0.2)",
          }}
        >
          {rightText}
        </div>
      </div>
    </section>
  );
}
