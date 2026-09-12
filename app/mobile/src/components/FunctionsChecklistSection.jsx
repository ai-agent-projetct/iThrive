import React from 'react';
import { 
  CheckCircle2, ShieldCheck, ArrowRight, Sparkles
} from 'lucide-react';
import MouseOverText from './MouseOverText';
import IntroAnimation from './ui/scroll-morph-hero';

export default function FunctionsChecklistSection({ onOpenConsultation }) {
  return (
    <section id="functions" className="py-16 md:py-24 relative bg-slate-950/80 border-t border-b border-slate-800/80">
      
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        {/* Section Header */}
        <div className="text-center max-w-3xl mx-auto space-y-4 mb-8">
          <div className="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-cyan-950/80 border border-cyan-500/30 text-cyan-400 text-xs font-semibold uppercase tracking-wider">
            <CheckCircle2 className="w-3.5 h-3.5" /> What Our Mobile Apps Include
          </div>

          <h2 className="text-3xl sm:text-4xl md:text-5xl font-black font-heading tracking-tight text-slate-100">
            Core Mobile Functions <MouseOverText text="Built Into Every App" variant="glow" className="text-cyan-400" />
          </h2>

          <p className="text-slate-300 text-base sm:text-lg">
            No line item here is aspirational — interact with all 20 production architecture modules we engineer and ship into live dual-store apps.
          </p>
        </div>

        {/* Scroll-Morph-Hero 3D Interactive Stage */}
        <div className="rounded-3xl border border-slate-800/80 bg-slate-950/90 shadow-2xl backdrop-blur-xl overflow-hidden">
          <IntroAnimation 
            darkMode={true}
            title="Engineered For High-Velocity Scale"
            subtitle="SCROLL OR CLICK CONTROLS TO MORPH 20 MODULES"
            heading="Core Mobile Functions Built Into Every App"
            description="Hover any card to flip its 3D specifications. Scroll or click controls above to morph between 3D orbit and bottom arc layouts."
            onOpenConsultation={onOpenConsultation}
          />
        </div>

        {/* Bottom Guarantee Banner */}
        <div className="mt-10 p-6 rounded-3xl bg-slate-900/60 border border-slate-800/80 flex flex-col sm:flex-row items-center justify-between gap-4">
          <div className="flex items-center gap-3">
            <div className="w-10 h-10 rounded-xl bg-cyan-500/20 border border-cyan-500/40 flex items-center justify-center text-cyan-400 flex-shrink-0">
              <ShieldCheck className="w-5 h-5" />
            </div>
            <div>
              <p className="text-sm font-bold text-slate-100">Enterprise Ready Production Architecture</p>
              <p className="text-xs text-slate-400">All 20 core mobile capabilities configured with clean architecture, strict unit tests, and zero vendor lock-in.</p>
            </div>
          </div>

          <button
            onClick={onOpenConsultation}
            className="btn-ithrive-pill px-6 py-3 text-xs font-bold uppercase tracking-wider flex items-center gap-2 whitespace-nowrap"
          >
            <span>Request Full Architecture Spec</span>
            <ArrowRight className="w-3.5 h-3.5" />
          </button>
        </div>

      </div>
    </section>
  );
}
