import React from 'react';
import { 
  Sparkles, ArrowRight, ShieldCheck, Star, Smartphone, 
  MapPin, CheckCircle2, Award, Zap, Code2, Play
} from 'lucide-react';
import AppUniverse from './AppUniverse';
import MouseOverText from './MouseOverText';

export default function HeroSection({ 
  finishColor, 
  onFinishChange, 
  activeScreen, 
  onScreenChange,
  onOpenConsultation 
}) {
  return (
    <section className="relative min-h-screen pt-28 pb-16 md:pt-36 md:pb-24 overflow-hidden bg-radial-gradient">
      
      {/* Background Ambient Glow Orbs */}
      <div className="absolute top-1/4 left-10 w-[500px] h-[500px] rounded-full bg-blue-600/15 blur-[140px] pointer-events-none" />
      <div className="absolute top-1/3 right-10 w-[500px] h-[500px] rounded-full bg-purple-600/15 blur-[140px] pointer-events-none" />

      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        {/* Top Location & Rating Badge */}
        <div className="flex flex-wrap items-center justify-center md:justify-start gap-3 mb-6">
          <div className="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-slate-950/90 border border-blue-500/40 text-xs font-semibold text-cyan-400 shadow-xl backdrop-blur-md">
            <MapPin className="w-3.5 h-3.5 text-blue-400 animate-bounce" />
            <span>Top Mobile App Development Company in Chennai</span>
          </div>

          <div className="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-slate-900/80 border border-slate-800 text-xs font-medium text-slate-300">
            <div className="flex text-amber-400">
              <Star className="w-3.5 h-3.5 fill-current" />
              <Star className="w-3.5 h-3.5 fill-current" />
              <Star className="w-3.5 h-3.5 fill-current" />
              <Star className="w-3.5 h-3.5 fill-current" />
              <Star className="w-3.5 h-3.5 fill-current" />
            </div>
            <span className="font-bold text-white">4.9/5.0</span>
            <span className="text-slate-400">(150+ iOS & Android Apps)</span>
          </div>
        </div>

        <div className="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
          
          {/* Left Hero Text Column */}
          <div className="lg:col-span-7 space-y-6 text-center md:text-left">
            
            {/* Primary Required Banner Headline */}
            <h1 className="text-4xl sm:text-5xl md:text-6xl font-black font-heading tracking-tight leading-[1.1]">
              <MouseOverText 
                text="Mobile App Development" 
                variant="split"
                className="block text-white font-extrabold"
              />
              <span className="mt-2 block text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 via-blue-500 to-purple-500">
                <MouseOverText 
                  text="Company in Chennai" 
                  variant="glow"
                  className="inline-block"
                />
              </span>
            </h1>

            {/* Subtitle with Mouse Over Color Feature (White -> Hover Electric Blue) */}
            <p className="text-base sm:text-lg md:text-xl text-slate-300 font-normal leading-relaxed max-w-2xl">
              iThrive Software engineers high-performance, visually stunning <MouseOverText text="iOS & Android Mobile Applications" className="font-semibold" />, <MouseOverText text="Flutter & React Native cross-platform apps" className="font-semibold" />, and <MouseOverText text="AI-powered mobile solutions" className="font-semibold" /> for global enterprises and ambitious startups.
            </p>

            {/* Feature Highlights Grid */}
            <div className="grid grid-cols-2 sm:grid-cols-3 gap-3 pt-2 text-left">
              <div className="p-3.5 rounded-2xl bg-slate-900/80 border border-blue-500/30 hover:border-cyan-400/60 transition-colors shadow-lg">
                <div className="flex items-center gap-2 text-cyan-400 font-bold text-sm">
                  <Zap className="w-4 h-4" /> 60 FPS Smooth UI
                </div>
                <p className="text-[11px] text-slate-400 mt-1">Native Metal & SwiftUI 3D performance</p>
              </div>

              <div className="p-3.5 rounded-2xl bg-slate-900/80 border border-blue-500/30 hover:border-blue-400/60 transition-colors shadow-lg">
                <div className="flex items-center gap-2 text-blue-400 font-bold text-sm">
                  <ShieldCheck className="w-4 h-4" /> 100% IP & NDA
                </div>
                <p className="text-[11px] text-slate-400 mt-1">Full source code ownership & security</p>
              </div>

              <div className="p-3.5 rounded-2xl bg-slate-900/80 border border-purple-500/30 hover:border-purple-400/60 transition-colors shadow-lg col-span-2 sm:col-span-1">
                <div className="flex items-center gap-2 text-purple-400 font-bold text-sm">
                  <Code2 className="w-4 h-4" /> On-Device AI
                </div>
                <p className="text-[11px] text-slate-400 mt-1">Smart LLMs & offline mobile intelligence</p>
              </div>
            </div>

            {/* Action CTAs: ALL Buttons matching exact uploaded Pill format */}
            <div className="flex flex-wrap items-center justify-center md:justify-start gap-4 pt-4">
              <button
                onClick={onOpenConsultation}
                className="btn-ithrive-pill px-8 py-4 text-sm sm:text-base flex items-center gap-2 group"
              >
                <span>Request Free Proposal & Quote</span>
                <ArrowRight className="w-4 h-4 group-hover:translate-x-1 transition-transform" />
              </button>

              <a
                href="#estimator"
                className="btn-ithrive-outline px-7 py-4 text-sm sm:text-base flex items-center gap-2"
              >
                <Sparkles className="w-4 h-4 text-cyan-400" />
                <span>Estimate Mobile App Cost</span>
              </a>
            </div>

            {/* The three screen-selector buttons that stood here drove
                Phone3DCanvasV2, which the App Universe replaced. They were left
                pointing at nothing, so they are gone rather than decorative. */}

          </div>

          {/* Right column — the App Universe scene.
              Not a framed canvas any more: it bleeds into the hero background
              so it reads as part of the section rather than a widget dropped
              into it. AppUniverse is a thin wrapper over the vanilla scene in
              assets/js/universe.js. */}
          <div className="lg:col-span-5 relative">
            <AppUniverse />
          </div>

        </div>

      </div>
    </section>
  );
}
