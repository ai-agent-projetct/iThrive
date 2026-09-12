"use client";

import React, { useState, useEffect, useMemo, useRef } from "react";
import { motion, useTransform, useSpring, useMotionValue, animate } from "framer-motion";
import { ArrowRight, Sparkles, Shield, Cpu, Zap, Layers } from "lucide-react";

// --- Types ---
export type AnimationPhase = "scatter" | "line" | "circle" | "bottom-strip";

export interface MobileFunctionItem {
    title: string;
    tag?: string;
    desc?: string;
    image: string;
    actionLabel?: string;
}

interface FlipCardProps {
    src: string;
    index: number;
    total: number;
    phase: AnimationPhase;
    target: { x: number; y: number; rotation: number; scale: number; opacity: number };
    itemData?: MobileFunctionItem;
    darkMode?: boolean;
    isHovered?: boolean;
    isAnyHovered?: boolean;
    onHover?: (hovering: boolean) => void;
    onSelect?: () => void;
}

// --- FlipCard Component with Substantially Bigger Card Size & Zero Overlap ---
const IMG_WIDTH = 200;  // 200px width for bold presence
const IMG_HEIGHT = 280; // 280px height for rich readability and visual depth

export function FlipCard({
    src,
    index,
    total,
    phase,
    target,
    itemData,
    darkMode = true,
    isHovered = false,
    isAnyHovered = false,
    onHover,
    onSelect,
}: FlipCardProps) {
    const hasMountedRef = useRef(false);
    const [wasRecentlyHovered, setWasRecentlyHovered] = useState(false);

    useEffect(() => {
        if (!hasMountedRef.current) {
            hasMountedRef.current = true;
            return;
        }
        if (!isHovered) {
            setWasRecentlyHovered(true);
            const timer = setTimeout(() => {
                setWasRecentlyHovered(false);
            }, 450);
            return () => clearTimeout(timer);
        } else {
            setWasRecentlyHovered(false);
        }
    }, [isHovered]);

    const activeZIndex = isHovered || wasRecentlyHovered ? 999 : index + 1;

    return (
        <motion.div
            animate={{
                x: target.x,
                y: isHovered ? target.y - 50 : target.y,
                rotate: isHovered ? 0 : target.rotation,
                scale: isHovered ? (target.scale * 1.18) : target.scale,
                opacity: isHovered ? 1 : (isAnyHovered ? 0.35 : target.opacity),
            }}
            transition={{
                type: "spring",
                stiffness: isHovered ? 85 : 42,
                damping: isHovered ? 15 : 17,
            }}
            style={{
                position: "absolute",
                width: IMG_WIDTH,
                height: IMG_HEIGHT,
                transformStyle: "preserve-3d",
                perspective: "1200px",
                zIndex: activeZIndex,
            }}
            className="cursor-pointer group"
            onMouseEnter={() => {
                if (onHover) onHover(true);
            }}
            onMouseLeave={() => {
                if (onHover) onHover(false);
            }}
            onClick={onSelect}
        >
            <motion.div
                className="relative h-full w-full rounded-2xl shadow-2xl transition-all duration-300"
                style={{
                    transformStyle: "preserve-3d",
                    WebkitTransformStyle: "preserve-3d",
                }}
                animate={{
                    rotateY: isHovered ? 180 : 0,
                }}
                transition={{
                    duration: 0.55,
                    type: "spring",
                    stiffness: 240,
                    damping: 22,
                }}
            >
                {/* Front Face */}
                <div
                    className="absolute inset-0 h-full w-full overflow-hidden rounded-2xl border-2 border-cyan-500/35 bg-slate-950 shadow-xl shadow-black/80"
                    style={{
                        backfaceVisibility: "hidden",
                        WebkitBackfaceVisibility: "hidden",
                    }}
                >
                    <img
                        src={src}
                        alt={itemData?.title || `hero-${index}`}
                        className="h-full w-full object-cover select-none pointer-events-none filter contrast-110 saturate-110"
                        loading="lazy"
                    />
                    <div className="absolute inset-0 bg-gradient-to-t from-slate-950/95 via-slate-950/35 to-transparent" />
                    
                    {/* Front Badge */}
                    <div className="absolute top-2.5 left-2.5 px-2.5 py-1 rounded-md bg-slate-950/85 border border-cyan-500/40 text-[10px] font-mono font-bold text-cyan-300 backdrop-blur-md shadow-md">
                        {itemData?.tag || `#${index + 1}`}
                    </div>

                    {/* Front Title Teaser */}
                    <div className="absolute bottom-3 left-3 right-3 text-left">
                        <p className="text-sm font-extrabold text-white leading-tight drop-shadow-md truncate">
                            {itemData?.title || "Mobile Architecture"}
                        </p>
                        <span className="text-[10px] text-cyan-400 font-mono flex items-center gap-1 mt-1 font-semibold">
                            Hover to Flip Specs &rarr;
                        </span>
                    </div>
                </div>

                {/* Back Face (Specifications & Architecture Details) */}
                <div
                    className="absolute inset-0 h-full w-full overflow-hidden rounded-2xl p-4 sm:p-5 flex flex-col justify-between border-2 border-cyan-400/90 bg-[#020617] text-white shadow-2xl shadow-cyan-500/30"
                    style={{
                        backfaceVisibility: "hidden",
                        WebkitBackfaceVisibility: "hidden",
                        transform: "rotateY(180deg)",
                    }}
                >
                    <div className="text-left w-full space-y-2.5">
                        {/* Header Tag & Status */}
                        <div className="flex items-center justify-between gap-2">
                            <span className="px-2.5 py-0.5 rounded bg-cyan-950/90 border border-cyan-500/40 text-[10px] font-mono font-bold text-cyan-300 uppercase tracking-wider truncate">
                                {itemData?.tag || "SPEC"}
                            </span>
                            <span className="inline-flex items-center gap-1 text-[9px] font-mono font-semibold text-emerald-400 bg-emerald-950/60 border border-emerald-500/30 px-1.5 py-0.5 rounded">
                                <span className="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse" />
                                READY
                            </span>
                        </div>

                        {/* Title */}
                        <div>
                            <h4 className="text-sm sm:text-base font-black text-slate-100 leading-snug">
                                {itemData?.title || "Core Mobile Module"}
                            </h4>
                            <div className="w-8 h-0.5 bg-gradient-to-r from-cyan-400 to-transparent rounded-full mt-1.5" />
                        </div>

                        {/* Description (Full text, comfortably styled) */}
                        <p className="text-[11.5px] text-slate-300 leading-relaxed">
                            {itemData?.desc || "Production-grade enterprise mobile architecture module."}
                        </p>

                        {/* Architecture highlights */}
                        <div className="flex items-center gap-1.5 flex-wrap pt-0.5">
                            <span className="px-2 py-0.5 rounded text-[9px] font-mono bg-slate-900 border border-slate-700/80 text-slate-300">
                                Clean Arch
                            </span>
                            <span className="px-2 py-0.5 rounded text-[9px] font-mono bg-cyan-950/50 border border-cyan-500/30 text-cyan-300">
                                Zero Jank
                            </span>
                        </div>
                    </div>

                    {/* Bottom Inspect Specs Action */}
                    <div className="w-full pt-2.5 border-t border-slate-800">
                        <button
                            type="button"
                            onClick={(e) => {
                                e.stopPropagation();
                                if (onSelect) onSelect();
                            }}
                            className="w-full py-2 px-3 rounded-lg bg-cyan-500/20 hover:bg-cyan-500/35 border border-cyan-400/60 text-xs font-bold text-cyan-200 hover:text-white flex items-center justify-center gap-1.5 transition-all shadow-md shadow-cyan-950/50 hover:shadow-cyan-500/30"
                        >
                            <span>Inspect Specs</span>
                            <ArrowRight className="w-3.5 h-3.5 text-cyan-300" />
                        </button>
                    </div>
                </div>
            </motion.div>
        </motion.div>
    );
}

// 20 Core Mobile Capabilities Styled with Dark AI-Theme Assets
const base = typeof window !== 'undefined' ? (window.__ithriveBase || '/') : '/';
const capFolder = typeof window !== 'undefined' && window.location && window.location.pathname.includes('flutter') ? 'flutter-dev' : 'mobile-dev';

export const DEFAULT_FUNCTION_ITEMS: MobileFunctionItem[] = [
    { title: "Dual Store Architecture", tag: "Store Sync", desc: "Single Dart codebase targeting Apple App Store and Google Play with zero performance loss.", image: `${base}assets/img/${capFolder}/morph-01-dual-store.jpg` },
    { title: "Offline SQLite & Hive", tag: "Local Persistence", desc: "Sub-millisecond local queries with automatic conflict-free cloud sync.", image: `${base}assets/img/${capFolder}/morph-02-offline-sync.jpg` },
    { title: "Sub-Second GPS Routing", tag: "Spatial Geofence", desc: "Battery-optimized live vehicle tracking and geofence entry triggers.", image: `${base}assets/img/${capFolder}/morph-03-realtime-gps.jpg` },
    { title: "Universal Deep Linking", tag: "Smart Routing", desc: "Cold-boot deep link routing straight to checkout or nested tabs.", image: `${base}assets/img/${capFolder}/morph-04-deep-link.jpg` },
    { title: "On-Device Neural Core", tag: "CoreML & TFLite", desc: "Embedded vision and local AI inference running without internet connection.", image: `${base}assets/img/${capFolder}/morph-05-neural-core.jpg` },
    { title: "120 FPS Impeller Physics", tag: "UI Ergonomics", desc: "Buttery smooth GPU micro-interactions and zero-jank screen transitions.", image: `${base}assets/img/${capFolder}/morph-06-impeller-physics.jpg` },
    { title: "Hardware Keystore MDM", tag: "Zero-Trust", desc: "Secure Enclave biometric encryption and dynamic certificate pinning.", image: `${base}assets/img/${capFolder}/morph-07-keystore-security.jpg` },
    { title: "Instant FinTech Rails", tag: "UPI & Apple Pay", desc: "Seamless in-app checkout with automated retry queues and fraud telemetry.", image: `${base}assets/img/${capFolder}/morph-08-fintech-rails.jpg` },
    { title: "Multilingual Voice Chat", tag: "WebRTC Audio", desc: "Crystal clear bidirectional audio channels with noise suppression.", image: `${base}assets/img/${capFolder}/morph-09-voice-chat.jpg` },
    { title: "Robotic Fleet Dispatch", tag: "Logistics Engine", desc: "Automated warehouse and delivery routing with real-time ETA matrices.", image: `${base}assets/img/${capFolder}/morph-10-fleet-dispatch.jpg` },
    { title: "HIPAA Telehealth Stream", tag: "Medical Video", desc: "End-to-end encrypted video consults with live biometric HUD overlays.", image: `${base}assets/img/${capFolder}/morph-11-telehealth.jpg` },
    { title: "Dark Glassmorphic UI", tag: "Spatial 3D", desc: "Luxury dark glass cards with customizable neon glow palettes.", image: `${base}assets/img/${capFolder}/morph-12-glassmorphism.jpg` },
    { title: "Dedicated Cloud Clusters", tag: "A100 & H100", desc: "High-concurrency backend services with sub-50ms roundtrip latency.", image: `${base}assets/img/${capFolder}/morph-13-cloud-clusters.jpg` },
    { title: "Automated Fastlane CI/CD", tag: "DevOps Pipeline", desc: "Zero-touch TestFlight distributions and multi-track Play Store releases.", image: `${base}assets/img/${capFolder}/morph-14-fastlane-cicd.jpg` },
    { title: "Real-Time Sentry Vitals", tag: "Observability", desc: "Crash telemetry, ANR diagnostics, and memory leak stack tracing.", image: `${base}assets/img/${capFolder}/morph-15-sentry-telemetry.jpg` },
    { title: "Clean BLoC State Flow", tag: "State Machine", desc: "Unidirectional architecture with 100% testable business logic.", image: `${base}assets/img/${capFolder}/morph-16-bloc-state.jpg` },
    { title: "Biometric Security Audit", tag: "OWASP Mobile", desc: "Anti-reverse-engineering protection and tamper-evident payload verification.", image: `${base}assets/img/${capFolder}/morph-17-security-audit.jpg` },
    { title: "Autonomous Scaling Hubs", tag: "Enterprise Scale", desc: "Multi-region redundancy across India, USA, and Singapore clusters.", image: `${base}assets/img/${capFolder}/morph-18-scaling-hubs.jpg` },
    { title: "Chennai Engineering Lab", tag: "Anna Salai Lab", desc: "Senior mobile architects delivering sprint-by-sprint development.", image: `${base}assets/img/${capFolder}/morph-19-chennai-lab.jpg` },
    { title: "1-on-1 Scoping Sprint", tag: "Tech Consultation", desc: "Direct consultation with lead mobile solutions architect.", image: `${base}assets/img/${capFolder}/morph-20-consultation-sprint.jpg` },
];

const TOTAL_IMAGES = 20;
const MAX_SCROLL = 3000;

const lerp = (start: number, end: number, t: number) => start * (1 - t) + end * t;

const lerpAngle = (start: number, end: number, t: number) => {
    let diff = (end - start) % 360;
    if (diff > 180) diff -= 360;
    if (diff < -180) diff += 360;
    return start + diff * t;
};

export interface IntroAnimationProps {
    images?: string[];
    items?: MobileFunctionItem[];
    title?: string;
    subtitle?: string;
    heading?: string;
    description?: string;
    darkMode?: boolean;
    onOpenConsultation?: (item?: MobileFunctionItem) => void;
    className?: string;
}

export default function IntroAnimation({
    images,
    items = DEFAULT_FUNCTION_ITEMS,
    title = "Built For High-Velocity Mobile Scale",
    subtitle = "SCROLL OR DRAG TO MORPH ARCHITECTURE",
    heading = "Core Mobile Functions Built Into Every App",
    description = "Every mobile app engineered by iThrive includes enterprise-grade foundation modules out of the box — zero boilerplate, maximum velocity, rock-solid stability.",
    darkMode = true,
    onOpenConsultation,
    className = "",
}: IntroAnimationProps) {
    const [introPhase, setIntroPhase] = useState<AnimationPhase>("scatter");
    const [containerSize, setContainerSize] = useState({ width: 0, height: 0 });
    const [hoveredIndex, setHoveredIndex] = useState<number | null>(null);
    const containerRef = useRef<HTMLDivElement>(null);

    const imageList = useMemo(() => {
        if (images && images.length >= TOTAL_IMAGES) return images.slice(0, TOTAL_IMAGES);
        if (items && items.length >= TOTAL_IMAGES) return items.slice(0, TOTAL_IMAGES).map(i => i.image);
        return DEFAULT_FUNCTION_ITEMS.map(i => i.image);
    }, [images, items]);

    useEffect(() => {
        if (!containerRef.current) return;

        const handleResize = (entries: ResizeObserverEntry[]) => {
            for (const entry of entries) {
                setContainerSize({
                    width: entry.contentRect.width,
                    height: entry.contentRect.height,
                });
            }
        };

        const observer = new ResizeObserver(handleResize);
        observer.observe(containerRef.current);

        setContainerSize({
            width: containerRef.current.offsetWidth,
            height: containerRef.current.offsetHeight,
        });

        return () => observer.disconnect();
    }, []);

    const virtualScroll = useMotionValue(0);
    const scrollRef = useRef(0);

    useEffect(() => {
        const container = containerRef.current;
        if (!container) return;

        const handleWheel = (e: WheelEvent) => {
            const current = scrollRef.current;
            const isScrollingDown = e.deltaY > 0;
            const isScrollingUp = e.deltaY < 0;

            if ((isScrollingDown && current < MAX_SCROLL) || (isScrollingUp && current > 0)) {
                e.preventDefault();
            }

            const newScroll = Math.min(Math.max(scrollRef.current + e.deltaY * 1.3, 0), MAX_SCROLL);
            scrollRef.current = newScroll;
            virtualScroll.set(newScroll);
        };

        let touchStartY = 0;
        const handleTouchStart = (e: TouchEvent) => {
            touchStartY = e.touches[0].clientY;
        };
        const handleTouchMove = (e: TouchEvent) => {
            const touchY = e.touches[0].clientY;
            const deltaY = (touchStartY - touchY) * 1.5;
            touchStartY = touchY;

            const newScroll = Math.min(Math.max(scrollRef.current + deltaY, 0), MAX_SCROLL);
            scrollRef.current = newScroll;
            virtualScroll.set(newScroll);
        };

        container.addEventListener("wheel", handleWheel, { passive: false });
        container.addEventListener("touchstart", handleTouchStart, { passive: true });
        container.addEventListener("touchmove", handleTouchMove, { passive: true });

        return () => {
            container.removeEventListener("wheel", handleWheel);
            container.removeEventListener("touchstart", handleTouchStart);
            container.removeEventListener("touchmove", handleTouchMove);
        };
    }, [virtualScroll]);

    const morphProgress = useTransform(virtualScroll, [0, 650], [0, 1]);
    const smoothMorph = useSpring(morphProgress, { stiffness: 45, damping: 20 });

    const scrollRotate = useTransform(virtualScroll, [650, 3000], [0, 360]);
    const smoothScrollRotate = useSpring(scrollRotate, { stiffness: 45, damping: 20 });

    const mouseX = useMotionValue(0);
    const smoothMouseX = useSpring(mouseX, { stiffness: 35, damping: 20 });

    useEffect(() => {
        const container = containerRef.current;
        if (!container) return;

        const handleMouseMove = (e: MouseEvent) => {
            const rect = container.getBoundingClientRect();
            const relativeX = e.clientX - rect.left;
            const normalizedX = (relativeX / rect.width) * 2 - 1;
            mouseX.set(normalizedX * 90);
        };
        container.addEventListener("mousemove", handleMouseMove);
        return () => container.removeEventListener("mousemove", handleMouseMove);
    }, [mouseX]);

    useEffect(() => {
        const timer1 = setTimeout(() => setIntroPhase("line"), 400);
        const timer2 = setTimeout(() => setIntroPhase("circle"), 2200);
        return () => {
            clearTimeout(timer1);
            clearTimeout(timer2);
        };
    }, []);

    const scatterPositions = useMemo(() => {
        return imageList.map(() => ({
            x: (Math.random() - 0.5) * 1400,
            y: (Math.random() - 0.5) * 900,
            rotation: (Math.random() - 0.5) * 160,
            scale: 0.7,
            opacity: 0,
        }));
    }, [imageList]);

    const [morphValue, setMorphValue] = useState(0);
    const [rotateValue, setRotateValue] = useState(0);
    const [parallaxValue, setParallaxValue] = useState(0);

    useEffect(() => {
        const unsubscribeMorph = smoothMorph.on("change", setMorphValue);
        const unsubscribeRotate = smoothScrollRotate.on("change", setRotateValue);
        const unsubscribeParallax = smoothMouseX.on("change", setParallaxValue);
        return () => {
            unsubscribeMorph();
            unsubscribeRotate();
            unsubscribeParallax();
        };
    }, [smoothMorph, smoothScrollRotate, smoothMouseX]);

    const contentOpacity = useTransform(smoothMorph, [0.75, 1], [0, 1]);
    const contentY = useTransform(smoothMorph, [0.75, 1], [25, 0]);

    const setScrollTarget = (targetVal: number) => {
        scrollRef.current = targetVal;
        animate(virtualScroll, targetVal, {
            duration: 0.85,
            ease: [0.16, 1, 0.3, 1],
        });
    };

    return (
        <div
            ref={containerRef}
            className={`relative w-full h-[960px] md:h-[1020px] overflow-hidden select-none ${
                darkMode ? 'bg-slate-950/90 text-slate-100' : 'bg-[#FAFAFA] text-gray-900'
            } ${className}`}
        >
            {/* Deep Ambient Background Glow */}
            {darkMode && (
                <div className="absolute inset-0 pointer-events-none overflow-hidden">
                    <div className="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[400px] bg-cyan-500/15 rounded-full blur-[140px]" />
                    <div className="absolute bottom-10 right-1/4 w-[600px] h-[300px] bg-purple-600/15 rounded-full blur-[140px]" />
                </div>
            )}

            {/* Quick Interactive Morph Controls */}
            <div className="absolute top-4 right-4 z-30 flex items-center gap-2">
                <button
                    type="button"
                    onClick={() => setScrollTarget(0)}
                    className="px-3 py-1.5 text-xs font-mono font-bold rounded-lg border border-slate-700 bg-slate-900/90 text-slate-300 hover:text-cyan-400 hover:border-cyan-500/60 transition-colors shadow-lg"
                    title="Circle Orbit Formation"
                >
                    Orbit
                </button>
                <button
                    type="button"
                    onClick={() => setScrollTarget(650)}
                    className="px-3 py-1.5 text-xs font-mono font-bold rounded-lg border border-slate-700 bg-slate-900/90 text-slate-300 hover:text-cyan-400 hover:border-cyan-500/60 transition-colors shadow-lg"
                    title="Rainbow Arc Formation"
                >
                    Arc View
                </button>
                <button
                    type="button"
                    onClick={() => setScrollTarget(2400)}
                    className="px-3 py-1.5 text-xs font-mono font-bold rounded-lg border border-cyan-500/50 bg-cyan-950/60 text-cyan-300 hover:bg-cyan-900/80 transition-colors shadow-lg shadow-cyan-950/50"
                    title="Shuffle through all 20 modules"
                >
                    Shuffle
                </button>
            </div>

            <div className="flex h-full w-full flex-col items-center justify-center perspective-1200">
                {/* Intro Center Text */}
                <div className="absolute z-0 flex flex-col items-center justify-center text-center pointer-events-none top-1/2 -translate-y-1/2 px-4">
                    <motion.h3
                        initial={{ opacity: 0, y: 20, filter: "blur(10px)" }}
                        animate={introPhase === "circle" && morphValue < 0.5 ? { opacity: 1 - morphValue * 2, y: 0, filter: "blur(0px)" } : { opacity: 0, filter: "blur(10px)" }}
                        transition={{ duration: 1 }}
                        className={`text-2xl sm:text-3xl md:text-4xl font-black font-heading tracking-tight ${darkMode ? 'text-white' : 'text-gray-800'}`}
                    >
                        {title}
                    </motion.h3>
                    <motion.p
                        initial={{ opacity: 0 }}
                        animate={introPhase === "circle" && morphValue < 0.5 ? { opacity: 0.8 - morphValue } : { opacity: 0 }}
                        transition={{ duration: 1, delay: 0.2 }}
                        className="mt-4 text-xs font-mono font-bold tracking-[0.25em] text-cyan-400 uppercase"
                    >
                        {subtitle}
                    </motion.p>
                </div>

                {/* Arc Active Status Pill */}
                <motion.div
                    style={{ opacity: contentOpacity, y: contentY }}
                    className="absolute top-6 left-6 z-20 hidden sm:flex items-center gap-2 pointer-events-none"
                >
                    <div className="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full border border-cyan-500/40 bg-slate-900/90 text-cyan-300 text-xs font-mono font-bold uppercase tracking-wider shadow-lg shadow-cyan-950/50 backdrop-blur-md">
                        <Sparkles className="w-3.5 h-3.5 text-cyan-400" />
                        20 Production Architecture Modules Fanned
                    </div>
                </motion.div>

                {/* Big 3D Flip Cards Stage */}
                <div className="relative flex items-center justify-center w-full h-full">
                    {imageList.slice(0, TOTAL_IMAGES).map((src, i) => {
                        let target = { x: 0, y: 0, rotation: 0, scale: 1, opacity: 1 };

                        if (introPhase === "scatter") {
                            target = scatterPositions[i] || { x: 0, y: 0, rotation: 0, scale: 0.7, opacity: 0 };
                        } else if (introPhase === "line") {
                            const lineSpacing = 200;
                            const lineTotalWidth = TOTAL_IMAGES * lineSpacing;
                            const lineX = i * lineSpacing - lineTotalWidth / 2;
                            target = { x: lineX, y: 0, rotation: 0, scale: 1, opacity: 1 };
                        } else {
                            const isMobile = containerSize.width < 768;
                            const minDimension = Math.min(containerSize.width || 900, containerSize.height || 960);

                            // Circle Phase (symmetric orbit around center 0, 0)
                            const circleRadius = Math.min(minDimension * 0.38, 360);
                            const circleAngle = (i / TOTAL_IMAGES) * 360;
                            const circleRad = (circleAngle * Math.PI) / 180;
                            const circlePos = {
                                x: Math.cos(circleRad) * circleRadius,
                                y: Math.sin(circleRad) * circleRadius,
                                rotation: circleAngle + 90,
                                scale: isMobile ? 0.76 : 0.94,
                            };

                            // Bottom Arc Phase (perfectly bounded fanned deck)
                            const arcRadius = isMobile ? 460 : 750;
                            const arcApexY = isMobile ? -60 : -100;
                            const arcCenterY = arcApexY + arcRadius;

                            const spreadAngle = isMobile ? 85 : 124;
                            const startAngle = -90 - (spreadAngle / 2);
                            const step = spreadAngle / (TOTAL_IMAGES - 1);

                            const scrollProgress = Math.min(Math.max(rotateValue / 360, 0), 1);
                            const maxRotation = spreadAngle * 0.55;
                            const boundedRotation = -scrollProgress * maxRotation;

                            const currentArcAngle = startAngle + (i * step) + boundedRotation;
                            const arcRad = (currentArcAngle * Math.PI) / 180;

                            const arcPos = {
                                x: Math.cos(arcRad) * arcRadius + parallaxValue,
                                y: Math.sin(arcRad) * arcRadius + arcCenterY,
                                rotation: currentArcAngle + 90,
                                scale: isMobile ? 0.80 : 1.02,
                            };

                            target = {
                                x: lerp(circlePos.x, arcPos.x, morphValue),
                                y: lerp(circlePos.y, arcPos.y, morphValue),
                                rotation: lerpAngle(circlePos.rotation, arcPos.rotation, morphValue),
                                scale: lerp(circlePos.scale, arcPos.scale, morphValue),
                                opacity: 1,
                            };
                        }

                        const itemData = items[i];
                        const isHovered = hoveredIndex === i;
                        const isAnyHovered = hoveredIndex !== null;

                        return (
                            <FlipCard
                                key={i}
                                src={src}
                                index={i}
                                total={TOTAL_IMAGES}
                                phase={introPhase}
                                target={target}
                                itemData={itemData}
                                darkMode={darkMode}
                                isHovered={isHovered}
                                isAnyHovered={isAnyHovered}
                                onHover={(hovering) => setHoveredIndex((prev) => (hovering ? i : (prev === i ? null : prev)))}
                                onSelect={() => {
                                    if (itemData && onOpenConsultation) {
                                        onOpenConsultation(itemData);
                                    }
                                }}
                            />
                        );
                    })}
                </div>

                {/* Bottom Helper Bar */}
                <div className="absolute bottom-4 left-1/2 -translate-x-1/2 z-20 flex items-center gap-3 px-5 py-2 rounded-full bg-slate-900/90 border border-slate-700/80 text-xs text-slate-300 backdrop-blur-md shadow-xl">
                    <span className="inline-block w-2.5 h-2.5 rounded-full bg-cyan-400 animate-pulse" />
                    <span>Hover cards to flip 3D specs • Scroll down or click buttons above to morph</span>
                </div>
            </div>
        </div>
    );
}
