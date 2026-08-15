import React from 'react';
import { 
  CheckCircle2, Layers, WifiOff, Radio, Bell, Rocket, Activity, ShieldCheck, ArrowRight
} from 'lucide-react';
import MouseOverText from './MouseOverText';

export default function FunctionsChecklistSection({ onOpenConsultation }) {
  const functions = [
    {
      icon: Layers,
      title: 'Flutter & React Native Dual Store',
      tagline: 'Single Codebase, Dual Platform',
      desc: 'Chosen per project on real criteria — existing team skills, native module needs, and animation load — shipping to both Apple App Store & Google Play Store.'
    },
    {
      icon: WifiOff,
      title: 'Offline-First Data Sync Engine',
      tagline: 'Local Persistence & Conflict Resolution',
      desc: 'Local SQLite/Hive persistence with conflict-aware sync, so your mobile app stays 100% usable in elevators, basements, or rural low coverage areas.'
    },
    {
      icon: Radio,
      title: 'Real-Time WebSockets & GPS',
      tagline: 'Sub-Second Driver Tracking & Chat',
      desc: 'Live location tracking, instant chat, and user presence over WebSockets with battery-conscious location handling and background workers.'
    },
    {
      icon: Bell,
      title: 'Push Notifications & Deep Linking',
      tagline: 'Smart Segmentation & Cold-Start Landing',
      desc: 'Segmented push notifications and deep links that survive cold app starts and land the user directly on the right in-app screen.'
    },
    {
      icon: Rocket,
      title: 'Store Release Management',
      tagline: 'App Store & Play Console Guaranteed Review',
      desc: 'Complete submission management, staged rollouts, screenshot asset generation, and handling Apple/Google review cycles by experienced engineers.'
    },
    {
      icon: Activity,
      title: 'Crash & Performance Monitoring',
      tagline: 'Sentry & App Vitals from Day 1',
      desc: 'Sentry, Firebase Crashlytics, and store vitals wired from the first build, backed by a triage process rather than an unmonitored dashboard.'
    }
  ];

  return (
    <section className="py-20 md:py-28 relative bg-slate-950/80 border-t border-b border-slate-800/80">
      
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        {/* Section Header */}
        <div className="text-center max-w-3xl mx-auto space-y-4 mb-14">
          <div className="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-cyan-950/80 border border-cyan-500/30 text-cyan-400 text-xs font-semibold uppercase tracking-wider">
            <CheckCircle2 className="w-3.5 h-3.5" /> What Our Mobile Apps Include
          </div>

          <h2 className="text-3xl sm:text-4xl md:text-5xl font-black font-heading tracking-tight text-slate-100">
            Core Mobile Functions <MouseOverText text="Built Into Every App" variant="glow" className="text-cyan-400" />
          </h2>

          <p className="text-slate-300 text-base sm:text-lg">
            No line item here is aspirational — each one is something we have shipped on a platform that is live in production today.
          </p>
        </div>

        {/* Functions Grid */}
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          {functions.map((fn, idx) => {
            const Icon = fn.icon;
            return (
              <div
                key={idx}
                className="glass-panel p-6 rounded-3xl border border-slate-800 hover:border-cyan-500/50 transition-all duration-300 flex flex-col justify-between group hover:-translate-y-1.5"
              >
                <div className="space-y-4">
                  <div className="w-12 h-12 rounded-2xl bg-gradient-to-tr from-cyan-400 via-blue-600 to-purple-600 flex items-center justify-center text-white font-bold shadow-lg shadow-cyan-500/25 group-hover:scale-110 transition-transform">
                    <Icon className="w-6 h-6" />
                  </div>

                  <div>
                    <h3 className="text-lg font-bold text-slate-100 group-hover:text-cyan-300 transition-colors">
                      <MouseOverText text={fn.title} />
                    </h3>
                    <p className="text-xs text-cyan-400 font-medium mt-0.5">
                      {fn.tagline}
                    </p>
                  </div>

                  <p className="text-xs text-slate-300 leading-relaxed">
                    {fn.desc}
                  </p>
                </div>

                <div className="pt-4 mt-3 border-t border-slate-800/80 flex items-center gap-1.5 text-[11px] text-emerald-400 font-semibold">
                  <CheckCircle2 className="w-3.5 h-3.5" /> Guaranteed Functionality
                </div>
              </div>
            );
          })}
        </div>

        {/* CTA Bar */}
        <div className="mt-12 text-center">
          <button
            onClick={onOpenConsultation}
            className="btn-ithrive-pill px-8 py-4 text-sm sm:text-base inline-flex items-center gap-2"
          >
            <span>Talk to a Mobile Solutions Architect</span>
            <ArrowRight className="w-4 h-4" />
          </button>
        </div>

      </div>
    </section>
  );
}
