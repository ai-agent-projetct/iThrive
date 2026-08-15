import React, { useState, useRef, useEffect } from 'react';
import { 
  ArrowRight, HeartPulse, Car, Utensils, Heart, Volume2, VolumeX, CheckCircle2
} from 'lucide-react';
import MouseOverText from './MouseOverText';
import { playClickSound, playHoverSound } from './AudioEngine';

export default function AppSimulatorSection({ onOpenConsultation }) {
  const [activeAppIndex, setActiveAppIndex] = useState(0);
  const [isMuted, setIsMuted] = useState(true);
  const [scrollPercent, setScrollPercent] = useState(0);
  const [isLocked, setIsLocked] = useState(true);

  const sectionRef = useRef(null);
  const videoRef = useRef(null);
  const targetTimeRef = useRef(0);
  const smoothTimeRef = useRef(0);
  const animationFrameRef = useRef(null);

  const apps = [
    {
      id: 'taxi_ai',
      name: 'Taxi AI App',
      category: 'Logistics & AI Ride Dispatch',
      badge: 'Python + PostGIS + WebSockets',
      icon: Car,
      video: '/videos/taxi_ai.mp4',
      tagline: 'Real-Time Driver Dispatch & Spatial GPS Tracking',
      desc: 'Sub-second driver matching algorithm, real-time route optimization, and spatial PostGIS map tracking scrubbing smoothly.',
      features: ['Sub-Second Driver Matching', 'Live Spatial GPS Map', 'Dynamic Fare Estimator', 'In-App Instant Audio Call']
    },
    {
      id: 'meetoo',
      name: 'MeeToo',
      category: 'Social & Matchmaking',
      badge: 'React Native + Node.js + WebRTC',
      icon: Heart,
      video: '/videos/meetoo_dating.mp4',
      tagline: 'AI Compatibility & Live Video Matchmaking',
      desc: 'Location-based matchmaking platform with real-time video chat, AI personality compatibility score, and anti-spoofing selfie verification.',
      features: ['Real-time Video Matchmaking', 'AI Personality Score', 'Location Geofence Pulse', 'Biometric Selfie Verification']
    },
    {
      id: 'foodtime',
      name: 'FoodTime',
      category: 'Food & Grocery Delivery',
      badge: 'Flutter + Django + Stripe',
      icon: Utensils,
      video: '/videos/foodtime.mp4',
      tagline: 'Hyperlocal Kitchen Kiosk & Delivery Track',
      desc: 'Personalized food ordering platform with real-time kitchen status sync, sub-25 min delivery algorithm, and 1-click UPI checkout.',
      features: ['Sub-25 Min Delivery SLA', 'Kitchen Order Kiosk Sync', 'Live Driver Delivery Map', '1-Click UPI & Card Checkout']
    },
    {
      id: 'ai_healthcare',
      name: 'AI Health Care',
      category: 'Digital Health & Telemedicine',
      badge: 'Swift 6 + CoreML + WebRTC',
      icon: HeartPulse,
      video: '/videos/ai_healthcare.mp4',
      tagline: 'AI Symptom Diagnostic & Telehealth',
      desc: 'Embedded AI symptom checker, doctor appointment booking, real-time Bluetooth heart monitor sync, and HIPAA-compliant digital prescriptions.',
      features: ['CoreML Symptom Diagnostic', 'HD Video Tele-consultation', 'Bluetooth Vitals Monitor Sync', 'HIPAA 100% Compliant']
    }
  ];

  const currentApp = apps[activeAppIndex];

  // 4K Ultra-Crisp Smooth Frame Lerp Loop (60 FPS)
  useEffect(() => {
    const video = videoRef.current;
    if (!video) return;

    targetTimeRef.current = 0;
    smoothTimeRef.current = 0;
    video.currentTime = 0;

    let isRunning = true;

    const updateVideoFrame = () => {
      if (!isRunning) return;

      if (video && video.duration) {
        const diff = targetTimeRef.current - smoothTimeRef.current;
        if (Math.abs(diff) > 0.002) {
          // 0.12 rather than 0.35: a low factor glides the playhead over
          // roughly fifteen frames instead of snapping in three, which is
          // the difference between stepping and gliding.
          smoothTimeRef.current += diff * 0.12;
          const want = Math.max(0, Math.min(video.duration, smoothTimeRef.current));
          if (!video.seeking && Math.abs(video.currentTime - want) > 1 / 48) {
            video.currentTime = want;
          }
          
          const pct = Math.round((smoothTimeRef.current / video.duration) * 100);
          setScrollPercent(pct);
        }
      }

      animationFrameRef.current = requestAnimationFrame(updateVideoFrame);
    };

    animationFrameRef.current = requestAnimationFrame(updateVideoFrame);

    return () => {
      isRunning = false;
      if (animationFrameRef.current) cancelAnimationFrame(animationFrameRef.current);
    };
  }, [activeAppIndex]);

  // Strict Section Wheel Interception & Automatic Unlocking Engine
  useEffect(() => {
    const sectionEl = sectionRef.current;
    if (!sectionEl) return;

    const handleWheel = (e) => {
      const video = videoRef.current;
      if (!video || !video.duration) return;

      const rect = sectionEl.getBoundingClientRect();
      const inView = rect.top <= 80 && rect.bottom >= window.innerHeight - 80;

      if (!inView) return;

      const duration = video.duration;
      const curTime = targetTimeRef.current;
      const delta = e.deltaY;

      if (delta > 0) {
        if (curTime < duration - 0.15) {
          e.preventDefault();
          e.stopPropagation();
          targetTimeRef.current = Math.min(duration, curTime + delta * 0.0022);
          setIsLocked(true);
        } else {
          targetTimeRef.current = duration;
          setScrollPercent(100);
          setIsLocked(false);
        }
      } else if (delta < 0) {
        if (curTime > 0.15) {
          e.preventDefault();
          e.stopPropagation();
          targetTimeRef.current = Math.max(0, curTime + delta * 0.0022);
          setIsLocked(true);
        } else {
          targetTimeRef.current = 0;
          setScrollPercent(0);
          setIsLocked(false);
        }
      }
    };

    window.addEventListener('wheel', handleWheel, { passive: false });
    return () => window.removeEventListener('wheel', handleWheel);
  }, [activeAppIndex]);

  return (
    <section
      ref={sectionRef}
      id="simulator"
      className="relative bg-slate-950 border-t border-b border-slate-800/80 w-full min-h-screen overflow-hidden"
    >
      {/*
        Three bands, not overlays. The heading and app tabs sit ABOVE the video
        and the app details BELOW it, so nothing covers the footage — the whole
        point of the stage is the video, and floating chrome on top of it was
        hiding the thing it was describing.

        The section is exactly one viewport tall. It used to be 350vh, but the
        scrub is driven by the wheel handler rather than by scroll position, so
        the extra 250vh was pure dead space the visitor had to scroll past after
        the video finished.
      */}
      <div className="min-h-screen w-full flex flex-col justify-center bg-black">

        {/* ---- ABOVE THE VIDEO: title + the four app tabs ---- */}
        <div className="shrink-0 w-full px-4 sm:px-8 lg:px-12 pb-3 text-center space-y-3 site-header-clear">
          <h2 className="text-2xl sm:text-3xl md:text-4xl font-black font-heading tracking-tight text-white">
            Experience Our <MouseOverText text="Interactive UI/UX Mobile Apps" variant="glow" className="text-cyan-400" />
          </h2>

          <div className="flex justify-center items-center gap-2 sm:gap-3 flex-wrap">
            {apps.map((app, idx) => {
              const Icon = app.icon;
              const isActive = activeAppIndex === idx;
              return (
                <button
                  key={app.id}
                  onClick={() => {
                    playClickSound();
                    setActiveAppIndex(idx);
                  }}
                  onMouseEnter={() => playHoverSound()}
                  className={`px-5 py-2 text-xs sm:text-sm font-bold transition-all flex items-center gap-2 rounded-full ${
                    isActive
                      ? 'btn-ithrive-pill scale-105 shadow-xl shadow-cyan-500/50'
                      : 'btn-ithrive-outline opacity-85 hover:opacity-100 border-slate-700'
                  }`}
                >
                  <Icon className="w-4 h-4" />
                  <span>{app.name}</span>
                </button>
              );
            })}
          </div>
        </div>

        {/* ---- THE VIDEO: uncovered, taking whatever height is left ---- */}
        {/* A real 16:9 box, not "whatever height is left" — the footage is
            1920x1080, so anything else crops it. */}
        <div className="relative w-full aspect-video shrink-0">
          <video
            ref={videoRef}
            key={currentApp.video}
            src={currentApp.video}
            muted={isMuted}
            playsInline
            preload="auto"
            style={{
              objectFit: 'cover',
              transform: 'translate3d(0,0,0)',
              backfaceVisibility: 'hidden'
            }}
            className="w-full h-full"
          />
        </div>

        {/* ---- BELOW THE VIDEO: what you are looking at, and the CTA ---- */}
        <div className="shrink-0 w-full px-4 sm:px-8 lg:px-12 py-4 flex flex-col md:flex-row justify-between items-start md:items-center gap-3">

          <div className="space-y-1">
            <h3 className="text-lg sm:text-xl font-black text-white font-heading">
              {currentApp.name} — <span className="text-cyan-400 font-medium text-sm">{currentApp.tagline}</span>
            </h3>

            <div className="hidden sm:flex items-center gap-2 flex-wrap">
              {currentApp.features.map((feat, fIdx) => (
                <span key={fIdx} className="px-2.5 py-0.5 rounded-lg bg-slate-900/90 border border-slate-800 text-[11px] font-semibold text-slate-300 flex items-center gap-1.5">
                  <CheckCircle2 className="w-3 h-3 text-cyan-400" />
                  {feat}
                </span>
              ))}
            </div>
          </div>

          <div className="flex items-center gap-3 shrink-0">
            <button
              onClick={() => setIsMuted(!isMuted)}
              className="p-2 rounded-lg bg-slate-900 text-slate-300 hover:text-cyan-400 border border-slate-800 transition-colors"
              title={isMuted ? 'Unmute audio' : 'Mute audio'}
            >
              {isMuted ? <VolumeX className="w-4 h-4" /> : <Volume2 className="w-4 h-4" />}
            </button>

            <button
              onClick={onOpenConsultation}
              className="btn-ithrive-pill px-7 py-3 text-xs sm:text-sm font-extrabold uppercase tracking-wider flex items-center justify-center gap-2 shadow-2xl"
            >
              <span>Build {currentApp.name}</span>
              <ArrowRight className="w-4 h-4" />
            </button>
          </div>

        </div>

      </div>
    </section>
  );
}
