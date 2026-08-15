import React, { useState, useRef, useEffect } from 'react';
import { 
  Compass, Palette, Code2, ShieldCheck, Rocket, CheckCircle2, Sparkles, 
  ArrowRight, ChevronRight, ChevronLeft, Layers, RefreshCw, MoveHorizontal
} from 'lucide-react';
import MouseOverText from './MouseOverText';
import { playClickSound, playHoverSound } from './AudioEngine';

export default function ProcessSection() {
  const [activeStep, setActiveStep] = useState(0);
  const trackRef = useRef(null);
  const sectionRef = useRef(null);
  const activeStepRef = useRef(0);
  const exitArmed = useRef(false);

  useEffect(() => { activeStepRef.current = activeStep; }, [activeStep]);
  const isDragging = useRef(false);
  const startX = useRef(0);

  const steps = [
    {
      num: '01',
      title: 'Discovery & Architecture Blueprint',
      tagline: 'Technical Scope & Stack Selection',
      desc: 'We analyze your mobile app vision, target audience, feature scope, security requirements, and select the optimal stack (SwiftUI, Kotlin, Flutter, or React Native).',
      icon: Compass,
      inputs: 'Client Vision, API Schemas, Target OS',
      outputs: 'Signed Build Architecture Plan & Mutual NDA',
      duration: '1 Week',
      deliverable: 'System Specs & GitHub Repo'
    },
    {
      num: '02',
      title: 'UI/UX Design & 3D Prototyping',
      tagline: 'Figma 3D Interactive Flows',
      desc: 'Our design team crafts pixel-perfect mobile screen mockups, interactive micro-animations, design tokens, and clickable 3D prototypes in Figma.',
      icon: Palette,
      inputs: 'Brand Guidelines & User Flow Maps',
      outputs: 'Clickable Figma 3D Mobile Prototype',
      duration: '1-2 Weeks',
      deliverable: 'Figma Design System Tokens'
    },
    {
      num: '03',
      title: 'Agile Mobile Development Sprints',
      tagline: 'Bi-Weekly Native & Flutter Code Builds',
      desc: 'We code in bi-weekly sprints with continuous integration. You get testable TestFlight (iOS) & Firebase App Distribution (Android) builds after every sprint.',
      icon: Code2,
      inputs: 'Sprint Backlog & API Endpoints',
      outputs: 'TestFlight (iOS) & Firebase (Android) Builds',
      duration: '3-6 Weeks',
      deliverable: '100% Client-Owned Source Code'
    },
    {
      num: '04',
      title: 'Rigorous Security & QA Audit',
      tagline: '50+ Real Device Matrix Testing',
      desc: 'Automated UI unit testing, battery/RAM optimization, penetration testing, and compliance verification across 50+ real physical mobile devices.',
      icon: ShieldCheck,
      inputs: 'Compiled Mobile Binaries',
      outputs: 'Security Penetration & QA Audit Certificate',
      duration: '1 Week',
      deliverable: 'Zero-Defect Release Candidate'
    },
    {
      num: '05',
      title: 'App Store Deployment & Growth',
      tagline: 'Guaranteed Store Release & 24/7 SLA',
      desc: 'Guaranteed approval on Apple App Store & Google Play Store, analytics setup, serverless cloud deployment, and 24/7 post-launch maintenance SLA.',
      icon: Rocket,
      inputs: 'App Store Metadata & Signed IPA/AAB',
      outputs: 'Live App on Apple App Store & Google Play',
      duration: 'Ongoing',
      deliverable: '24/7 Post-Launch Support SLA'
    },
    {
      num: '06',
      title: 'Source Code & IP Handover',
      tagline: 'Repositories, Accounts & Documentation',
      desc: 'Repositories, cloud accounts, store listings and signing keys transfer into your name, with architecture notes and a working local environment so another team could pick this up without calling us.',
      icon: Layers,
      inputs: 'Signed Milestone Completion',
      outputs: 'Git Repositories & Infrastructure in Your Name',
      duration: '2 Days',
      deliverable: '100% IP & Source Code Transfer'
    },
    {
      num: '07',
      title: 'Analytics, Monitoring & Iteration',
      tagline: 'Crash Vitals, Funnels & Release Trains',
      desc: 'Sentry, Crashlytics and store vitals wired to a triage process, funnel analytics on the journeys that matter, and a fortnightly release train that ships against what the data actually shows.',
      icon: RefreshCw,
      inputs: 'Live Production Traffic',
      outputs: 'Weekly Vitals & Funnel Reporting',
      duration: 'Ongoing',
      deliverable: 'Measured Retention & Crash-Free Rate'
    },
    {
      num: '08',
      title: 'Scale, AI Enablement & Roadmap',
      tagline: 'Growth Features & On-Device Intelligence',
      desc: 'Once the core is stable we layer in what compounds: recommendation and assistant features, cost-optimised inference, and infrastructure that scales with the user base rather than ahead of it.',
      icon: Sparkles,
      inputs: 'Product Metrics & Business Goals',
      outputs: 'Quarterly Roadmap & AI Feature Rollout',
      duration: 'Quarterly',
      deliverable: 'Compounding Product Roadmap'
    }
  ];

  /**
   * Hold the page while all eight steps play out.
   *
   * The same contract the video stage uses: while this section fills the
   * viewport, the wheel advances the pipeline instead of the page, and once the
   * last step is reached the page starts scrolling again. Without it the whole
   * flow slid past in a single flick and nobody saw steps two to four.
   *
   * A wheel accumulator rather than one step per event: trackpads emit a stream
   * of small deltas, and stepping on each one would rip through all five in a
   * single gesture.
   */
  useEffect(() => {
    const sectionEl = sectionRef.current;
    if (!sectionEl) return;
    if (window.matchMedia('(pointer: coarse)').matches) return;   // never trap touch

    let accum = 0;
    let lastStepAt = 0;

    const STEP = 300;      // wheel px to arm one step
    // A full second between stages. Eight steps at half this ripped past
    // before any of them could be read, which is what 'jumping fast' meant.
    const COOLDOWN = 1000; // ms before another step can fire

    const onWheel = (e) => {
      const rect = sectionEl.getBoundingClientRect();
      const covers = rect.top <= 90 && rect.bottom >= window.innerHeight - 90;
      if (!covers) return;

      const last = steps.length - 1;
      const goingDown = e.deltaY > 0;
      const atEnd = goingDown ? activeStepRef.current >= last : activeStepRef.current <= 0;

      // At an end, the first further gesture is absorbed and only the second
      // releases the page. Without that pause the last step is on screen for a
      // fraction of a second before the page moves on, so nobody reads it.
      if (atEnd) {
        if (exitArmed.current) { exitArmed.current = false; return; }
        e.preventDefault();
        exitArmed.current = true;

        return;
      }
      exitArmed.current = false;

      e.preventDefault();
      accum += e.deltaY;

      // ONE step per gesture, never a burst. A wheel notch arrives as a train of
      // events and a trackpad flick as dozens; stepping on each one tore through
      // all five stages in a single movement, which is the "jumping very fast"
      // problem. The cooldown is what makes it five deliberate scrolls.
      const now = performance.now();
      if (now - lastStepAt < COOLDOWN) return;

      if (accum >= STEP) {
        accum = 0;
        lastStepAt = now;
        setActiveStep((p) => Math.min(p + 1, last));
      } else if (accum <= -STEP) {
        accum = 0;
        lastStepAt = now;
        setActiveStep((p) => Math.max(p - 1, 0));
      }
    };

    window.addEventListener('wheel', onWheel, { passive: false });

    return () => window.removeEventListener('wheel', onWheel);
  }, [steps.length]);

  // Drag still steps the track directly.
  const handleWheel = (e) => {
    if (Math.abs(e.deltaY) > 20) {
      if (e.deltaY > 0) {
        setActiveStep((prev) => Math.min(prev + 1, steps.length - 1));
      } else {
        setActiveStep((prev) => Math.max(prev - 1, 0));
      }
    }
  };

  const handleMouseDown = (e) => {
    isDragging.current = true;
    startX.current = e.clientX;
  };

  const handleMouseMove = (e) => {
    if (!isDragging.current) return;
    const deltaX = e.clientX - startX.current;
    if (Math.abs(deltaX) > 40) {
      if (deltaX < 0) {
        setActiveStep((prev) => Math.min(prev + 1, steps.length - 1));
      } else {
        setActiveStep((prev) => Math.max(prev - 1, 0));
      }
      isDragging.current = false;
    }
  };

  const handleMouseUp = () => {
    isDragging.current = false;
  };

  const currentStep = steps[activeStep];

  return (
    <section ref={sectionRef} id="process" className="py-20 md:py-28 relative bg-slate-950/90 border-t border-b border-slate-800/80 overflow-hidden">
      
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        {/* Section Header */}
        <div className="text-center max-w-3xl mx-auto space-y-4 mb-10">
          <h2 className="text-3xl sm:text-4xl md:text-5xl font-black font-heading tracking-tight text-slate-100">
            Our <MouseOverText text="Process Flow" variant="glow" className="text-cyan-400" />
          </h2>
        </div>

        {/* 3D SCROLLABLE PROCESS PIPELINE TRACK */}
        <div 
          ref={trackRef}
          onWheel={handleWheel}
          onMouseDown={handleMouseDown}
          onMouseMove={handleMouseMove}
          onMouseUp={handleMouseUp}
          className="relative py-12 cursor-grab active:cursor-grabbing select-none"
          style={{ perspective: '1200px' }}
        >
          {/* 3D Horizontal Flow Stage */}
          <div className="flex justify-center items-center gap-4 md:gap-6 min-h-[320px] transition-all duration-500">
            {steps.map((step, idx) => {
              const Icon = step.icon;
              const offset = idx - activeStep;
              const isActive = idx === activeStep;

              // Calculate 3D perspective transforms
              const rotateY = offset * -28; // Degree curve
              const translateZ = isActive ? 120 : -140 * Math.abs(offset); // Depth
              const translateX = offset * 20; // Lateral shift
              const opacity = isActive ? 1 : Math.max(0.35, 1 - Math.abs(offset) * 0.3);
              const scale = isActive ? 1.08 : 0.88;

              return (
                <div
                  key={idx}
                  onClick={() => {
                    playClickSound();
                    setActiveStep(idx);
                  }}
                  onMouseEnter={() => playHoverSound()}
                  className={`w-[260px] sm:w-[290px] p-6 rounded-3xl transition-all duration-500 flex flex-col justify-between group ${
                    isActive
                      ? 'bg-gradient-to-b from-slate-900 via-slate-900 to-slate-950 border-2 border-cyan-400 shadow-2xl shadow-cyan-500/30'
                      : 'bg-slate-950/80 border border-slate-800/80 hover:border-blue-500/40'
                  }`}
                  style={{
                    transform: `translateX(${translateX}px) translateZ(${translateZ}px) rotateY(${rotateY}deg) scale(${scale})`,
                    opacity: opacity,
                    zIndex: 50 - Math.abs(offset) * 10,
                    transformStyle: 'preserve-3d'
                  }}
                >
                  <div className="space-y-4">
                    
                    {/* Step Number & Node Icon */}
                    <div className="flex justify-between items-center">
                      <span className={`w-10 h-10 rounded-full flex items-center justify-center font-mono font-black text-sm transition-all ${
                        isActive ? 'btn-ithrive-pill text-slate-950 scale-110 shadow-lg' : 'bg-slate-900 text-slate-400 border border-slate-800'
                      }`}>
                        {step.num}
                      </span>

                      <div className={`p-3 rounded-2xl transition-transform ${
                        isActive ? 'bg-cyan-500/20 text-cyan-300 scale-110' : 'bg-slate-900 text-slate-400'
                      }`}>
                        <Icon className="w-5 h-5" />
                      </div>
                    </div>

                    {/* Step Title */}
                    <div>
                      <h3 className="text-base font-bold text-slate-100 group-hover:text-cyan-300 transition-colors">
                        <MouseOverText text={step.title} />
                      </h3>
                      <p className="text-xs text-cyan-400 font-semibold mt-1">
                        {step.tagline}
                      </p>
                    </div>

                    <p className="text-xs text-slate-300 leading-relaxed line-clamp-3">
                      {step.desc}
                    </p>
                  </div>

                  {/* Step Footer */}
                  <div className="pt-4 mt-4 border-t border-slate-800 flex justify-between items-center text-xs text-slate-400">
                    <span className="font-mono text-cyan-400 font-bold">{step.duration}</span>
                    <span className="text-[10px] text-slate-500">Click to Select</span>
                  </div>

                </div>
              );
            })}
          </div>

          {/* Navigation Controls */}
          <div className="flex justify-center items-center gap-4 mt-6">
            <button
              onClick={() => setActiveStep((prev) => Math.max(prev - 1, 0))}
              disabled={activeStep === 0}
              className="p-3 rounded-full bg-slate-900 border border-slate-800 text-slate-300 hover:text-cyan-400 disabled:opacity-40 transition-all"
            >
              <ChevronLeft className="w-5 h-5" />
            </button>

            {steps.map((_, idx) => (
              <button
                key={idx}
                onClick={() => setActiveStep(idx)}
                className={`h-2.5 rounded-full transition-all ${
                  activeStep === idx 
                    ? 'w-8 bg-gradient-to-r from-cyan-400 to-blue-600' 
                    : 'w-2.5 bg-slate-800 hover:bg-slate-700'
                }`}
              />
            ))}

            <button
              onClick={() => setActiveStep((prev) => Math.min(prev + 1, steps.length - 1))}
              disabled={activeStep === steps.length - 1}
              className="p-3 rounded-full bg-slate-900 border border-slate-800 text-slate-300 hover:text-cyan-400 disabled:opacity-40 transition-all"
            >
              <ChevronRight className="w-5 h-5" />
            </button>
          </div>
        </div>

        {/* 3D INSPECTOR DETAILS CARD */}
        <div className="glass-panel p-6 sm:p-8 rounded-3xl border border-cyan-500/40 shadow-2xl mt-8 grid grid-cols-1 lg:grid-cols-12 gap-6 items-center">
          <div className="lg:col-span-8 space-y-4">
            <div className="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-cyan-950 border border-cyan-500/40 text-cyan-300 text-xs font-semibold">
              <span>Step #{currentStep.num} Selected</span>
              <span>•</span>
              <span>{currentStep.duration} Duration</span>
            </div>

            <h3 className="text-2xl font-bold text-slate-100">
              <MouseOverText text={currentStep.title} variant="glow" />
            </h3>

            <p className="text-slate-300 text-sm leading-relaxed">
              {currentStep.desc}
            </p>

            <div className="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2">
              <div className="p-3.5 rounded-2xl bg-slate-900 border border-slate-800 text-xs space-y-1">
                <span className="text-[10px] text-slate-400 font-bold uppercase tracking-wider block">Input Requirements</span>
                <p className="font-semibold text-slate-200">{currentStep.inputs}</p>
              </div>

              <div className="p-3.5 rounded-2xl bg-slate-900 border border-slate-800 text-xs space-y-1">
                <span className="text-[10px] text-cyan-400 font-bold uppercase tracking-wider block">Output Deliverables</span>
                <p className="font-semibold text-cyan-300">{currentStep.outputs}</p>
              </div>
            </div>
          </div>

          <div className="lg:col-span-4 p-5 rounded-2xl bg-slate-950 border border-slate-800 space-y-3 text-center">
            <div className="w-12 h-12 rounded-full bg-gradient-to-tr from-cyan-400 via-blue-600 to-purple-600 flex items-center justify-center mx-auto text-white shadow-lg shadow-cyan-500/30">
              <CheckCircle2 className="w-6 h-6" />
            </div>
            <h4 className="text-sm font-bold text-slate-100">Deliverable Guarantee</h4>
            <p className="text-xs text-slate-400 leading-relaxed">
              "{currentStep.deliverable}"
            </p>
            <div className="pt-2">
              <button
                onClick={() => setActiveStep((prev) => (prev + 1) % steps.length)}
                className="btn-ithrive-pill px-6 py-2.5 text-xs font-bold"
              >
                <span>Advance to Step #{((activeStep + 1) % steps.length) + 1}</span>
                <ArrowRight className="w-3.5 h-3.5 ml-1" />
              </button>
            </div>
          </div>
        </div>

      </div>
    </section>
  );
}
