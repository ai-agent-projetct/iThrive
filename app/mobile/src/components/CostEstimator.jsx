import React, { useState } from 'react';
import { 
  Calculator, Check, Smartphone, Sparkles, 
  CreditCard, ShieldCheck, ArrowRight, DollarSign, Clock, CheckCircle
} from 'lucide-react';
import MouseOverText from './MouseOverText';

export default function CostEstimator({ onOpenConsultation }) {
  const [platform, setPlatform] = useState('both'); // ios, android, both
  const [designLevel, setDesignLevel] = useState('premium'); // minimal, premium, 3d
  const [selectedFeatures, setSelectedFeatures] = useState(['auth', 'payments', 'push']);
  const [currency, setCurrency] = useState('INR'); // INR or USD

  const platforms = [
    { id: 'ios', label: 'Native iOS App', base: 180000, baseUSD: 2400 },
    { id: 'android', label: 'Native Android App', base: 180000, baseUSD: 2400 },
    { id: 'both', label: 'Cross-Platform (iOS + Android)', base: 280000, baseUSD: 3600 },
  ];

  const designLevels = [
    { id: 'minimal', label: 'Standard UI', mult: 1.0, desc: 'Clean native components' },
    { id: 'premium', label: 'Custom Luxury UI', mult: 1.25, desc: 'Custom micro-animations & dark mode' },
    { id: '3d', label: 'Interactive 3D UI & AR', mult: 1.5, desc: 'WebGL, 3D models & glassmorphism' },
  ];

  const features = [
    { id: 'auth', label: 'Biometric Auth & OTP', price: 25000, priceUSD: 350 },
    { id: 'payments', label: 'UPI / Stripe Payment Gateway', price: 35000, priceUSD: 450 },
    { id: 'push', label: 'Push Notifications & Messaging', price: 20000, priceUSD: 250 },
    { id: 'gps', label: 'Live GPS Location & Maps', price: 40000, priceUSD: 500 },
    { id: 'chat', label: 'Realtime Chat & Audio Calls', price: 45000, priceUSD: 600 },
    { id: 'ai', label: 'On-Device AI Assistant', price: 65000, priceUSD: 850 },
    { id: 'admin', label: 'Web Admin Dashboard & Analytics', price: 50000, priceUSD: 650 },
  ];

  const toggleFeature = (fId) => {
    setSelectedFeatures(prev => 
      prev.includes(fId) ? prev.filter(item => item !== fId) : [...prev, fId]
    );
  };

  const selectedPlatformObj = platforms.find(p => p.id === platform) || platforms[2];
  const selectedDesignObj = designLevels.find(d => d.id === designLevel) || designLevels[1];

  let featureSumINR = 0;
  let featureSumUSD = 0;

  selectedFeatures.forEach(fId => {
    const f = features.find(item => item.id === fId);
    if (f) {
      featureSumINR += f.price;
      featureSumUSD += f.priceUSD;
    }
  });

  const totalCostINR = Math.round((selectedPlatformObj.base + featureSumINR) * selectedDesignObj.mult);
  const totalCostUSD = Math.round((selectedPlatformObj.baseUSD + featureSumUSD) * selectedDesignObj.mult);

  const estimatedWeeks = Math.max(3, Math.round(4 + selectedFeatures.length * 0.8));

  return (
    <section id="estimator" className="py-20 md:py-28 relative bg-slate-950">
      
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {/* Section Header */}
        <div className="text-center max-w-3xl mx-auto space-y-4 mb-14">
          <div className="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-950/80 border border-emerald-500/30 text-emerald-400 text-xs font-semibold uppercase tracking-wider">
            <Calculator className="w-3.5 h-3.5" /> Transparent Pricing Calculator
          </div>

          <h2 className="text-3xl sm:text-4xl md:text-5xl font-black font-heading tracking-tight text-slate-100">
            Estimate Your <MouseOverText text="Mobile App Development Cost" variant="glow" className="text-cyan-400" />
          </h2>

          <p className="text-slate-300 text-base sm:text-lg">
            Configure your desired app features below to get an instant cost estimate and project timeline from iThrive Software Chennai.
          </p>
        </div>

        <div className="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
          
          {/* Options Column */}
          <div className="lg:col-span-7 space-y-8">
            
            {/* Step 1: Select Platform */}
            <div className="space-y-3">
              <h4 className="text-sm font-bold text-slate-200 uppercase tracking-wider flex items-center gap-2">
                <span className="w-6 h-6 rounded-full bg-cyan-500 text-slate-950 flex items-center justify-center text-xs font-extrabold">1</span>
                <span>Select Target Platform</span>
              </h4>
              <div className="grid grid-cols-1 sm:grid-cols-3 gap-3">
                {platforms.map(p => (
                  <button
                    key={p.id}
                    onClick={() => setPlatform(p.id)}
                    className={`p-3.5 text-left transition-all ${
                      platform === p.id 
                        ? 'btn-ithrive-pill' 
                        : 'btn-ithrive-outline opacity-70 hover:opacity-100'
                    }`}
                  >
                    <div className="text-xs font-bold">{p.label}</div>
                  </button>
                ))}
              </div>
            </div>

            {/* Step 2: Select Features */}
            <div className="space-y-3">
              <h4 className="text-sm font-bold text-slate-200 uppercase tracking-wider flex items-center gap-2">
                <span className="w-6 h-6 rounded-full bg-cyan-500 text-slate-950 flex items-center justify-center text-xs font-extrabold">2</span>
                <span>Select Key Features</span>
              </h4>
              <div className="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                {features.map(f => {
                  const isChecked = selectedFeatures.includes(f.id);
                  return (
                    <button
                      key={f.id}
                      onClick={() => toggleFeature(f.id)}
                      className={`p-3 rounded-full border text-left text-xs flex items-center justify-between transition-all ${
                        isChecked
                          ? 'bg-cyan-950/60 border-cyan-400 text-cyan-300 font-bold shadow-md shadow-cyan-500/20'
                          : 'bg-slate-900/40 border-slate-800 text-slate-300 hover:border-slate-700'
                      }`}
                    >
                      <span>{f.label}</span>
                      <div className={`w-4 h-4 rounded-full flex items-center justify-center ${isChecked ? 'bg-cyan-400 text-slate-950' : 'border border-slate-700'}`}>
                        {isChecked && <Check className="w-3 h-3 stroke-[3]" />}
                      </div>
                    </button>
                  );
                })}
              </div>
            </div>

            {/* Step 3: UI Design Complexity */}
            <div className="space-y-3">
              <h4 className="text-sm font-bold text-slate-200 uppercase tracking-wider flex items-center gap-2">
                <span className="w-6 h-6 rounded-full bg-cyan-500 text-slate-950 flex items-center justify-center text-xs font-extrabold">3</span>
                <span>UI/UX Design Level</span>
              </h4>
              <div className="grid grid-cols-1 sm:grid-cols-3 gap-3">
                {designLevels.map(d => (
                  <button
                    key={d.id}
                    onClick={() => setDesignLevel(d.id)}
                    className={`p-3 text-left transition-all ${
                      designLevel === d.id
                        ? 'btn-ithrive-pill'
                        : 'btn-ithrive-outline opacity-70 hover:opacity-100'
                    }`}
                  >
                    <div className="text-xs font-bold">{d.label}</div>
                  </button>
                ))}
              </div>
            </div>

          </div>

          {/* Result Output Card */}
          <div className="lg:col-span-5">
            <div className="glass-panel p-6 rounded-3xl border border-cyan-500/30 shadow-2xl space-y-6 sticky top-28">
              
              <div className="flex justify-between items-center pb-4 border-b border-slate-800">
                <h4 className="text-sm font-bold text-slate-200 uppercase tracking-wider">Estimated Investment</h4>
                <div className="flex items-center bg-slate-900 rounded-full p-1 border border-slate-800 text-xs">
                  <button
                    onClick={() => setCurrency('INR')}
                    className={`px-3 py-1 rounded-full font-bold transition-colors ${currency === 'INR' ? 'btn-ithrive-pill' : 'text-slate-400'}`}
                  >
                    ₹ INR
                  </button>
                  <button
                    onClick={() => setCurrency('USD')}
                    className={`px-3 py-1 rounded-full font-bold transition-colors ${currency === 'USD' ? 'btn-ithrive-pill' : 'text-slate-400'}`}
                  >
                    $ USD
                  </button>
                </div>
              </div>

              {/* Price Tag Display */}
              <div>
                <p className="text-xs text-slate-400">Estimated Budget Range</p>
                <div className="text-3xl sm:text-4xl font-black text-cyan-300 font-mono mt-1">
                  {currency === 'INR' ? `₹${totalCostINR.toLocaleString('en-IN')}` : `$${totalCostUSD.toLocaleString('en-US')}`}
                </div>
                <p className="text-[11px] text-cyan-400 mt-1 flex items-center gap-1 font-semibold">
                  <Clock className="w-3.5 h-3.5" /> Estimated Delivery: {estimatedWeeks} - {estimatedWeeks + 2} Weeks
                </p>
              </div>

              {/* Summary Items */}
              <div className="space-y-2 text-xs text-slate-300 pt-2 border-t border-slate-800">
                <div className="flex justify-between">
                  <span className="text-slate-400">Platform:</span>
                  <span className="font-semibold text-slate-100">{selectedPlatformObj.label}</span>
                </div>
                <div className="flex justify-between">
                  <span className="text-slate-400">Selected Features:</span>
                  <span className="font-semibold text-cyan-300">{selectedFeatures.length} Modules</span>
                </div>
                <div className="flex justify-between">
                  <span className="text-slate-400">Design Level:</span>
                  <span className="font-semibold text-slate-100">{selectedDesignObj.label}</span>
                </div>
                <div className="flex justify-between">
                  <span className="text-slate-400">Source Code & IP:</span>
                  <span className="font-semibold text-cyan-400">100% Owned by Client</span>
                </div>
              </div>

              <button
                onClick={onOpenConsultation}
                className="btn-ithrive-pill w-full py-4 text-sm font-black flex items-center justify-center gap-2"
              >
                <span>Request Formal Proposal with this Estimate</span>
                <ArrowRight className="w-4 h-4" />
              </button>

              <div className="text-[10px] text-slate-500 text-center">
                * Final cost is locked after detailed technical discovery & milestone agreement.
              </div>

            </div>
          </div>

        </div>

      </div>
    </section>
  );
}
