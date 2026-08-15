import React from 'react';
import { 
  MapPin, Phone, Mail, Clock, Award, ShieldCheck, 
  Users, Building, CheckCircle2, ArrowRight
} from 'lucide-react';
import MouseOverText from './MouseOverText';

export default function ChennaiPresence({ onOpenConsultation }) {
  return (
    <section id="chennai-hub" className="py-20 md:py-28 relative bg-slate-950/90 border-t border-b border-slate-800/80">
      
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div className="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
          
          {/* Left Column - Chennai Info */}
          <div className="lg:col-span-7 space-y-6">
            
            <div className="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-cyan-950/80 border border-cyan-500/30 text-cyan-400 text-xs font-semibold uppercase tracking-wider">
              <MapPin className="w-3.5 h-3.5 text-emerald-400 animate-bounce" />
              <span>Chennai Mobile App Studio</span>
            </div>

            <h2 className="text-3xl sm:text-4xl md:text-5xl font-black font-heading tracking-tight text-slate-100">
              Leading <MouseOverText text="Mobile App Development Company in Chennai" variant="glow" className="text-cyan-400" />
            </h2>

            <p className="text-slate-300 text-base sm:text-lg leading-relaxed">
              Headquartered in Chennai, Tamil Nadu, iThrive Software combines local engineering talent with global software standards. We help enterprises, healthcare networks, retail brands, and FinTech startups build world-class mobile apps.
            </p>

            {/* Chennai Advantages Grid */}
            <div className="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
              <div className="p-4 rounded-xl bg-slate-900/80 border border-slate-800 space-y-1">
                <h4 className="text-sm font-bold text-cyan-300 flex items-center gap-2">
                  <Building className="w-4 h-4 text-cyan-400" /> In-Person & Remote Agility
                </h4>
                <p className="text-xs text-slate-400">
                  Visit our Chennai office for face-to-face sprint reviews or collaborate seamlessly online.
                </p>
              </div>

              <div className="p-4 rounded-xl bg-slate-900/80 border border-slate-800 space-y-1">
                <h4 className="text-sm font-bold text-emerald-300 flex items-center gap-2">
                  <Users className="w-4 h-4 text-emerald-400" /> Dedicated Senior Engineers
                </h4>
                <p className="text-xs text-slate-400">
                  Top 1% mobile app developers in Swift, Kotlin, Flutter, React Native, and AI.
                </p>
              </div>

              <div className="p-4 rounded-xl bg-slate-900/80 border border-slate-800 space-y-1">
                <h4 className="text-sm font-bold text-purple-300 flex items-center gap-2">
                  <ShieldCheck className="w-4 h-4 text-purple-400" /> 100% IP & Source Code
                </h4>
                <p className="text-xs text-slate-400">
                  Full non-disclosure agreement (NDA), strict IP ownership transfer, and NDA guarantees.
                </p>
              </div>

              <div className="p-4 rounded-xl bg-slate-900/80 border border-slate-800 space-y-1">
                <h4 className="text-sm font-bold text-amber-300 flex items-center gap-2">
                  <Award className="w-4 h-4 text-amber-400" /> Cost Advantage
                </h4>
                <p className="text-xs text-slate-400">
                  Save up to 60% compared to Western app agencies without compromising code quality.
                </p>
              </div>
            </div>

            <div className="pt-4 flex flex-wrap items-center gap-4">
              <button
                onClick={onOpenConsultation}
                className="px-6 py-3.5 rounded-xl bg-gradient-to-r from-cyan-500 to-emerald-400 text-slate-950 font-bold text-sm flex items-center gap-2 shadow-lg shadow-cyan-500/20"
              >
                <span>Schedule Meeting at Chennai Hub</span>
                <ArrowRight className="w-4 h-4" />
              </button>
            </div>

          </div>

          {/* Right Column - Office Card & Map Preview */}
          <div className="lg:col-span-5">
            <div className="glass-panel p-6 rounded-3xl border border-cyan-500/30 shadow-2xl space-y-6">
              
              <div className="flex items-center justify-between border-b border-slate-800 pb-4">
                <div className="flex items-center gap-2">
                  <MapPin className="w-5 h-5 text-cyan-400" />
                  <span className="font-bold text-slate-100 text-base">iThrive Software Chennai Studio</span>
                </div>
                <span className="text-[10px] px-2.5 py-1 rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">Open 9AM - 8PM</span>
              </div>

              {/* Address details */}
              <div className="space-y-3 text-xs text-slate-300">
                <div className="flex items-start gap-3">
                  <Building className="w-4 h-4 text-slate-400 mt-0.5" />
                  <div>
                    <p className="font-semibold text-slate-200">OMR Tech Corridor / T. Nagar</p>
                    <p className="text-slate-400">Chennai, Tamil Nadu, India — 600096</p>
                  </div>
                </div>

                <div className="flex items-center gap-3">
                  <Phone className="w-4 h-4 text-cyan-400" />
                  <span className="font-mono text-cyan-300 font-semibold">+91 98765 43210</span>
                </div>

                <div className="flex items-center gap-3">
                  <Mail className="w-4 h-4 text-emerald-400" />
                  <span className="font-mono text-slate-300">contact@ithrivesoftware.com</span>
                </div>
              </div>

              {/* Simulated Map Visual */}
              <div className="w-full h-44 rounded-2xl bg-slate-900 border border-slate-800 relative overflow-hidden flex items-center justify-center">
                <div className="absolute inset-0 bg-grid-pattern opacity-40"></div>
                <div className="relative z-10 text-center space-y-2 p-4">
                  <div className="w-10 h-10 rounded-full bg-cyan-500/20 border border-cyan-500 flex items-center justify-center mx-auto text-cyan-400 animate-pulse">
                    <MapPin className="w-5 h-5" />
                  </div>
                  <p className="text-xs font-bold text-slate-200">iThrive Software Tech Hub • Chennai</p>
                  <p className="text-[10px] text-slate-400">Serving Chennai, Bengaluru, Mumbai & Global Clients</p>
                </div>
              </div>

              <div className="text-[11px] text-slate-400 text-center pt-2">
                Website: <a href="https://ithrivesoftware.com/" target="_blank" rel="noreferrer" className="text-cyan-400 hover:underline">https://ithrivesoftware.com/</a>
              </div>

            </div>
          </div>

        </div>

      </div>
    </section>
  );
}
