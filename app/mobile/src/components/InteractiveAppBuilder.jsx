import React, { useState } from 'react';
import { 
  Sparkles, Layers, ShieldCheck, Zap, CreditCard, 
  MapPin, MessageSquare, Cpu, Check, Plus, ArrowRight, Code2
} from 'lucide-react';
import MouseOverText from './MouseOverText';

export default function InteractiveAppBuilder({ onOpenConsultation }) {
  const [selectedModules, setSelectedModules] = useState(['auth', 'payment', 'push']);

  const availableModules = [
    { id: 'auth', name: 'Biometric Auth & FaceID', category: 'Security', icon: ShieldCheck, size: '2.4 MB', desc: 'Secure OAuth 2.0 & Apple/Google Single Sign-On' },
    { id: 'payment', name: 'UPI & Credit Card Gateway', category: 'FinTech', icon: CreditCard, size: '4.1 MB', desc: 'Sub-second Razorpay/Stripe checkout API' },
    { id: 'push', name: 'Smart Push Notifications', category: 'Engagement', icon: Zap, size: '1.2 MB', desc: 'Firebase Cloud Messaging & OneSignal integration' },
    { id: 'gps', name: 'Live GPS & Route Mapping', category: 'Logistics', icon: MapPin, size: '5.8 MB', desc: 'Google Maps 3D vector tile rendering' },
    { id: 'chat', name: 'Audio/Video & Instant Chat', category: 'Communication', icon: MessageSquare, size: '6.5 MB', desc: 'WebRTC end-to-end encrypted voice/video' },
    { id: 'ai', name: 'On-Device AI Neural Engine', category: 'Intelligence', icon: Cpu, size: '12.0 MB', desc: 'TensorFlow Lite / CoreML offline LLM model' },
  ];

  const toggleModule = (id) => {
    setSelectedModules(prev =>
      prev.includes(id) ? prev.filter(m => m !== id) : [...prev, id]
    );
  };

  const totalAppSize = selectedModules.reduce((acc, mId) => {
    const mod = availableModules.find(item => item.id === mId);
    return acc + (mod ? parseFloat(mod.size) : 0);
  }, 14.5).toFixed(1);

  return (
    <section id="app-builder" className="py-20 md:py-28 relative bg-slate-950/90 border-t border-b border-slate-800/80">
      
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {/* Section Header */}
        <div className="text-center max-w-3xl mx-auto space-y-4 mb-14">
          <div className="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-cyan-950/80 border border-cyan-500/30 text-cyan-400 text-xs font-semibold uppercase tracking-wider">
            <Layers className="w-3.5 h-3.5" /> Interactive 3D App Studio
          </div>

          <h2 className="text-3xl sm:text-4xl md:text-5xl font-black font-heading tracking-tight text-slate-100">
            Build Your <MouseOverText text="Custom Mobile App Architecture" variant="glow" className="text-cyan-400" />
          </h2>

          <p className="text-slate-300 text-base sm:text-lg">
            Toggle modules below to construct your custom iOS & Android mobile application stack in real time.
          </p>
        </div>

        <div className="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
          
          {/* Left Column: Modules Palette */}
          <div className="lg:col-span-7 grid grid-cols-1 sm:grid-cols-2 gap-4">
            {availableModules.map((mod) => {
              const Icon = mod.icon;
              const isSelected = selectedModules.includes(mod.id);
              return (
                <div
                  key={mod.id}
                  onClick={() => toggleModule(mod.id)}
                  className={`p-4 rounded-3xl border cursor-pointer transition-all duration-300 ${
                    isSelected
                      ? 'bg-slate-900 border-cyan-400 shadow-xl shadow-cyan-500/20 scale-[1.02]'
                      : 'bg-slate-900/40 border-slate-800 hover:border-slate-700 opacity-75'
                  }`}
                >
                  <div className="flex justify-between items-start">
                    <div className={`p-2.5 rounded-2xl ${isSelected ? 'btn-ithrive-pill' : 'bg-slate-800 text-slate-400'}`}>
                      <Icon className="w-5 h-5" />
                    </div>

                    <div className={`w-6 h-6 rounded-full border flex items-center justify-center ${isSelected ? 'btn-ithrive-pill' : 'border-slate-700'}`}>
                      {isSelected ? <Check className="w-3.5 h-3.5 stroke-[3]" /> : <Plus className="w-3.5 h-3.5 text-slate-500" />}
                    </div>
                  </div>

                  <h4 className="text-sm font-bold text-slate-100 mt-3">
                    <MouseOverText text={mod.name} />
                  </h4>
                  <p className="text-xs text-slate-400 mt-1 leading-normal">{mod.desc}</p>
                  
                  <div className="flex justify-between items-center mt-3 pt-2 border-t border-slate-800/80 text-[10px]">
                    <span className="text-cyan-400 font-semibold">{mod.category}</span>
                    <span className="text-slate-500 font-mono">+{mod.size}</span>
                  </div>
                </div>
              );
            })}
          </div>

          {/* Right Column: Live Compiled App Blueprint */}
          <div className="lg:col-span-5">
            <div className="glass-panel p-6 rounded-3xl border border-cyan-500/30 shadow-2xl space-y-6 sticky top-28">
              
              <div className="flex justify-between items-center pb-3 border-b border-slate-800">
                <div className="flex items-center gap-2">
                  <Code2 className="w-4 h-4 text-cyan-400" />
                  <span className="font-bold text-slate-100 text-sm">Compiled App Specs</span>
                </div>
                <span className="text-[10px] px-2.5 py-1 rounded-full bg-cyan-950 text-cyan-300 border border-cyan-500/40">
                  Ready to Build
                </span>
              </div>

              <div className="space-y-3">
                <div className="flex justify-between text-xs text-slate-300">
                  <span className="text-slate-400">Total Active Modules:</span>
                  <span className="font-bold text-cyan-300 font-mono">{selectedModules.length} Connected</span>
                </div>

                <div className="flex justify-between text-xs text-slate-300">
                  <span className="text-slate-400">Est. Binary Footprint:</span>
                  <span className="font-bold text-cyan-400 font-mono">~{totalAppSize} MB</span>
                </div>

                <div className="flex justify-between text-xs text-slate-300">
                  <span className="text-slate-400">Target Frameworks:</span>
                  <span className="font-bold text-slate-100">Swift 6 + Kotlin + Flutter</span>
                </div>

                <div className="flex justify-between text-xs text-slate-300">
                  <span className="text-slate-400">Deployment Hub:</span>
                  <span className="font-bold text-cyan-400">Chennai Studio (OMR)</span>
                </div>
              </div>

              {/* Selected Modules List */}
              <div className="p-3 rounded-2xl bg-slate-950 border border-slate-800 space-y-2 max-h-44 overflow-y-auto custom-scroll">
                <p className="text-[10px] text-slate-500 uppercase font-bold tracking-wider">Active Modules in Blueprint:</p>
                {selectedModules.map(mId => {
                  const item = availableModules.find(x => x.id === mId);
                  if (!item) return null;
                  return (
                    <div key={mId} className="flex justify-between items-center text-xs text-slate-200">
                      <span className="flex items-center gap-1.5 text-cyan-300 font-semibold">
                        <Check className="w-3.5 h-3.5 text-cyan-400" /> {item.name}
                      </span>
                      <span className="text-[10px] text-slate-500 font-mono">{item.size}</span>
                    </div>
                  );
                })}
              </div>

              <button
                onClick={onOpenConsultation}
                className="btn-ithrive-pill w-full py-4 text-sm font-black flex items-center justify-center gap-2 uppercase tracking-wider"
              >
                <span>Request Custom Proposal for this Stack</span>
                <ArrowRight className="w-4 h-4" />
              </button>

            </div>
          </div>

        </div>

      </div>
    </section>
  );
}
