import React, { useState } from 'react';
import { 
  Smartphone, Award, ExternalLink, ArrowRight, CheckCircle2, 
  Sparkles, Star, TrendingUp, ShieldCheck, Zap
} from 'lucide-react';
import MouseOverText from './MouseOverText';
import { playClickSound, playHoverSound } from './AudioEngine';

export default function CaseStudiesSection({ onOpenConsultation }) {
  const [activeFilter, setActiveFilter] = useState('all');

  const caseStudies = [
    {
      id: 'tada',
      title: 'Tada Taxi Booking App',
      category: 'taxi',
      categoryLabel: 'AI Ride Dispatch',
      client: 'Tada Mobility Chennai',
      image: '/images/ithrive_app_taxi.jpg',
      impact: '40% Reduction in Rider Wait Times',
      desc: 'Built custom AI driver dispatch engine with real-time GPS spatial indexing using Python, FastAPI, PostgreSQL PostGIS, and Redis.',
      stack: ['Python', 'FastAPI', 'PostGIS', 'Redis', 'Flutter'],
      metrics: [
        { label: 'Rider Wait Time', val: '-40%' },
        { label: 'Completed Rides', val: '2.4M+' },
        { label: 'App Store Rating', val: '4.9 ★' }
      ]
    },
    {
      id: 'toing',
      title: 'Toing Food & Grocery Delivery',
      category: 'food',
      categoryLabel: 'Food & Logistics',
      client: 'Toing Technologies',
      image: '/images/ithrive_app_food.jpg',
      impact: '+35% Increase in Repeat Orders',
      desc: 'High-concurrency food delivery mobile app with real-time restaurant order sync, live driver tracking, and instant UPI payments.',
      stack: ['Django', 'Celery', 'PostgreSQL', 'Kotlin', 'SwiftUI'],
      metrics: [
        { label: 'Repeat Orders', val: '+35%' },
        { label: 'Delivery Time', val: '22 Mins' },
        { label: 'Daily Orders', val: '45,000+' }
      ]
    },
    {
      id: 'lotus',
      title: 'CarePulse AI Healthcare App',
      category: 'health',
      categoryLabel: 'HealthTech & AI',
      client: 'Lotus Eye Hospital',
      image: '/images/ithrive_app_health.jpg',
      impact: '99.8% Patient Appointment SLA',
      desc: 'Agentic healthcare app with embedded CoreML vitals scanner, video tele-consultation over WebSockets, and HIPAA-compliant records.',
      stack: ['Swift 6', 'Kotlin', 'CoreML', 'WebRTC', 'AWS'],
      metrics: [
        { label: 'Vitals Accuracy', val: '99.8%' },
        { label: 'Tele-Consults', val: '180K+' },
        { label: 'HIPAA Compliant', val: '100%' }
      ]
    },
    {
      id: 'ipay',
      title: 'iPay Mobile FinTech Wallet',
      category: 'fintech',
      categoryLabel: 'FinTech Banking',
      client: 'iPay Financial Chennai',
      image: '/images/ithrive_app_fintech.jpg',
      impact: 'Sub-Second Payment Latency',
      desc: 'Bank-grade mobile wallet app with FaceID biometric authentication, instant UPI transfer, and encrypted transaction audit logs.',
      stack: ['Flutter', 'Node.js', 'PostgreSQL', 'Stripe API'],
      metrics: [
        { label: 'Txn Latency', val: '<14ms' },
        { label: 'Monthly Volume', val: '₹120 Cr' },
        { label: 'Security Score', val: '100/100' }
      ]
    }
  ];

  const filteredStudies = activeFilter === 'all' 
    ? caseStudies 
    : caseStudies.filter(c => c.category === activeFilter);

  return (
    <section id="portfolio" className="py-20 md:py-28 relative bg-slate-950/80 border-t border-b border-slate-800/80">
      
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        {/* Section Header (Trionova Style) */}
        <div className="text-center max-w-3xl mx-auto space-y-4 mb-14">
          <div className="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-cyan-950/80 border border-cyan-500/30 text-cyan-400 text-xs font-semibold uppercase tracking-wider">
            <Award className="w-3.5 h-3.5" /> Proven Mobile Success Stories
          </div>

          <h2 className="text-3xl sm:text-4xl md:text-5xl font-black font-heading tracking-tight text-slate-100">
            Real Mobile Apps <MouseOverText text="Built by iThrive Software" variant="glow" className="text-cyan-400" />
          </h2>

          <p className="text-slate-300 text-base sm:text-lg">
            Explore live mobile applications engineered by our Chennai studio with real metrics, high-performance backends, and battle-tested code.
          </p>

          {/* Filter Pills */}
          <div className="flex justify-center items-center gap-2.5 pt-2 flex-wrap">
            {[
              { id: 'all', label: 'All Projects' },
              { id: 'taxi', label: 'Ride Dispatch' },
              { id: 'food', label: 'Food Delivery' },
              { id: 'health', label: 'HealthTech AI' },
              { id: 'fintech', label: 'FinTech Wallet' }
            ].map(f => (
              <button
                key={f.id}
                onClick={() => {
                  playClickSound();
                  setActiveFilter(f.id);
                }}
                className={`px-4 py-2 text-xs font-bold transition-all ${
                  activeFilter === f.id
                    ? 'btn-ithrive-pill'
                    : 'btn-ithrive-outline opacity-70 hover:opacity-100'
                }`}
              >
                {f.label}
              </button>
            ))}
          </div>
        </div>

        {/* Case Studies Showcase Grid with Real Images */}
        <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
          {filteredStudies.map((study) => (
            <div
              key={study.id}
              className="glass-panel rounded-3xl border border-slate-800 hover:border-cyan-500/50 transition-all duration-300 overflow-hidden group hover:-translate-y-2 flex flex-col justify-between"
            >
              <div className="relative h-[280px] sm:h-[320px] overflow-hidden bg-slate-900 flex items-center justify-center p-4">
                {/* Real-time Mobile App Screenshot Image */}
                <img 
                  src={study.image} 
                  alt={study.title}
                  className="h-full object-contain drop-shadow-2xl rounded-2xl group-hover:scale-105 transition-transform duration-500"
                />
                
                {/* Top Category Badge Overlay */}
                <div className="absolute top-4 left-4 px-3 py-1 rounded-full bg-slate-950/90 border border-cyan-500/40 text-cyan-300 text-xs font-bold backdrop-blur-md">
                  {study.categoryLabel}
                </div>

                {/* Top Impact Tag */}
                <div className="absolute top-4 right-4 px-3 py-1 rounded-full bg-emerald-950/90 border border-emerald-500/40 text-emerald-300 text-xs font-extrabold backdrop-blur-md flex items-center gap-1">
                  <TrendingUp className="w-3.5 h-3.5" />
                  <span>{study.impact}</span>
                </div>
              </div>

              {/* Card Body */}
              <div className="p-6 space-y-4">
                
                <div>
                  <h3 className="text-2xl font-black text-slate-100 font-heading group-hover:text-cyan-300 transition-colors">
                    <MouseOverText text={study.title} variant="glow" />
                  </h3>
                  <p className="text-xs text-slate-400 font-semibold mt-0.5">
                    Client: {study.client}
                  </p>
                </div>

                <p className="text-xs text-slate-300 leading-relaxed">
                  {study.desc}
                </p>

                {/* Key Metrics Grid */}
                <div className="grid grid-cols-3 gap-2 p-3 rounded-2xl bg-slate-950 border border-slate-800 text-center">
                  {study.metrics.map((m, mIdx) => (
                    <div key={mIdx} className="space-y-0.5">
                      <span className="text-base font-black text-cyan-300 font-mono block">{m.val}</span>
                      <span className="text-[10px] text-slate-400 block">{m.label}</span>
                    </div>
                  ))}
                </div>

                {/* Tech Stack Chips */}
                <div className="flex flex-wrap gap-1.5">
                  {study.stack.map((st, sIdx) => (
                    <span key={sIdx} className="px-2.5 py-0.5 rounded-full bg-slate-900 border border-slate-800 text-[10px] font-mono text-slate-300">
                      {st}
                    </span>
                  ))}
                </div>

                {/* CTA Button */}
                <div className="pt-2 flex justify-between items-center">
                  <span className="text-[11px] text-emerald-400 font-semibold flex items-center gap-1">
                    <CheckCircle2 className="w-3.5 h-3.5" /> Live in App Stores
                  </span>

                  <button
                    onClick={onOpenConsultation}
                    className="btn-ithrive-pill px-5 py-2.5 text-xs font-bold flex items-center gap-1.5"
                  >
                    <span>Request Similar App</span>
                    <ArrowRight className="w-3.5 h-3.5" />
                  </button>
                </div>

              </div>
            </div>
          ))}
        </div>

      </div>
    </section>
  );
}
