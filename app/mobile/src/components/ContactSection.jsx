import React, { useState } from 'react';
import { 
  Send, Phone, Mail, MapPin, CheckCircle2, 
  Sparkles, Clock, ShieldCheck, ArrowRight
} from 'lucide-react';
import MouseOverText from './MouseOverText';

export default function ContactSection({ isOpenModal, onCloseModal }) {
  const [submitted, setSubmitted] = useState(false);
  const [formData, setFormData] = useState({
    name: '',
    email: '',
    phone: '',
    platform: 'Cross-Platform (iOS + Android)',
    budget: '₹3 Lakhs - ₹6 Lakhs',
    details: ''
  });

  const handleSubmit = (e) => {
    e.preventDefault();
    setSubmitted(true);
  };

  return (
    <section id="contact" className="py-20 md:py-28 relative bg-slate-950/80 border-t border-slate-800/80">
      
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div className="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
          
          {/* Left Column Text */}
          <div className="lg:col-span-5 space-y-6">
            
            <div className="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-cyan-950/80 border border-cyan-500/30 text-cyan-400 text-xs font-semibold uppercase tracking-wider">
              <Sparkles className="w-3.5 h-3.5" /> Start Your Project
            </div>

            <h2 className="text-3xl sm:text-4xl md:text-5xl font-black font-heading tracking-tight text-slate-100">
              Let’s Build Your <MouseOverText text="Next Mobile App" variant="glow" className="text-cyan-400" />
            </h2>

            <p className="text-slate-300 text-base sm:text-lg leading-relaxed">
              Have a mobile app idea or need to modernize an existing application? Get in touch with iThrive Software's Mobile Solutions Architects in Chennai today.
            </p>

            <div className="space-y-4 pt-2">
              <div className="flex items-center gap-3 text-sm text-slate-200">
                <div className="w-9 h-9 rounded-xl bg-slate-900 border border-slate-800 flex items-center justify-center text-cyan-400">
                  <Phone className="w-4 h-4" />
                </div>
                <div>
                  <p className="text-xs text-slate-400">Direct Phone (Chennai)</p>
                  <p className="font-mono font-bold text-cyan-300">+91 98765 43210</p>
                </div>
              </div>

              <div className="flex items-center gap-3 text-sm text-slate-200">
                <div className="w-9 h-9 rounded-xl bg-slate-900 border border-slate-800 flex items-center justify-center text-emerald-400">
                  <Mail className="w-4 h-4" />
                </div>
                <div>
                  <p className="text-xs text-slate-400">Official Email Inquiry</p>
                  <p className="font-mono font-bold text-slate-200">contact@ithrivesoftware.com</p>
                </div>
              </div>

              <div className="flex items-center gap-3 text-sm text-slate-200">
                <div className="w-9 h-9 rounded-xl bg-slate-900 border border-slate-800 flex items-center justify-center text-purple-400">
                  <Clock className="w-4 h-4" />
                </div>
                <div>
                  <p className="text-xs text-slate-400">Response SLA</p>
                  <p className="font-bold text-emerald-400">Guaranteed Response within 2 Hours</p>
                </div>
              </div>
            </div>

            <div className="p-4 rounded-2xl bg-slate-900/60 border border-slate-800 text-xs text-slate-400 flex items-center gap-3">
              <ShieldCheck className="w-6 h-6 text-emerald-400 flex-shrink-0" />
              <span>We strictly sign a Mutual Non-Disclosure Agreement (NDA) before discussing proprietary business ideas.</span>
            </div>

          </div>

          {/* Right Form Card */}
          <div className="lg:col-span-7">
            <div className="glass-panel p-6 sm:p-8 rounded-3xl border border-cyan-500/30 shadow-2xl">
              
              {submitted ? (
                <div className="text-center py-12 space-y-4">
                  <div className="w-16 h-16 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center mx-auto border border-emerald-500/40 animate-bounce">
                    <CheckCircle2 className="w-8 h-8" />
                  </div>
                  <h3 className="text-2xl font-bold text-slate-100">Proposal Request Received!</h3>
                  <p className="text-slate-300 text-sm max-w-md mx-auto">
                    Thank you, <span className="text-cyan-300 font-bold">{formData.name || 'valued client'}</span>. An iThrive Mobile Architect from our Chennai studio will review your project requirements and call you within 2 hours.
                  </p>
                  <button
                    onClick={() => setSubmitted(false)}
                    className="btn-ithrive-pill px-6 py-2.5 text-xs"
                  >
                    Send Another Requirement
                  </button>
                </div>
              ) : (
                <form onSubmit={handleSubmit} className="space-y-4">
                  
                  <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                      <label className="block text-xs font-semibold text-slate-300 mb-1">Your Full Name *</label>
                      <input
                        type="text"
                        required
                        placeholder="e.g. Anand Ramakrishnan"
                        value={formData.name}
                        onChange={(e) => setFormData({...formData, name: e.target.value})}
                        className="w-full px-4 py-3 rounded-xl bg-slate-950 border border-slate-800 text-slate-100 text-sm focus:border-cyan-500 focus:outline-none transition-colors"
                      />
                    </div>

                    <div>
                      <label className="block text-xs font-semibold text-slate-300 mb-1">Work Email Address *</label>
                      <input
                        type="email"
                        required
                        placeholder="anand@company.com"
                        value={formData.email}
                        onChange={(e) => setFormData({...formData, email: e.target.value})}
                        className="w-full px-4 py-3 rounded-xl bg-slate-950 border border-slate-800 text-slate-100 text-sm focus:border-cyan-500 focus:outline-none transition-colors"
                      />
                    </div>
                  </div>

                  <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                      <label className="block text-xs font-semibold text-slate-300 mb-1">Phone Number (WhatsApp) *</label>
                      <input
                        type="tel"
                        required
                        placeholder="+91 98765 43210"
                        value={formData.phone}
                        onChange={(e) => setFormData({...formData, phone: e.target.value})}
                        className="w-full px-4 py-3 rounded-xl bg-slate-950 border border-slate-800 text-slate-100 text-sm focus:border-cyan-500 focus:outline-none transition-colors"
                      />
                    </div>

                    <div>
                      <label className="block text-xs font-semibold text-slate-300 mb-1">Target App Platform</label>
                      <select
                        value={formData.platform}
                        onChange={(e) => setFormData({...formData, platform: e.target.value})}
                        className="w-full px-4 py-3 rounded-xl bg-slate-950 border border-slate-800 text-slate-100 text-sm focus:border-cyan-500 focus:outline-none transition-colors"
                      >
                        <option>Cross-Platform (iOS + Android)</option>
                        <option>Native iOS (Swift / SwiftUI)</option>
                        <option>Native Android (Kotlin)</option>
                        <option>AI-Powered Mobile Application</option>
                      </select>
                    </div>
                  </div>

                  <div>
                    <label className="block text-xs font-semibold text-slate-300 mb-1">Project Scope & Features Overview</label>
                    <textarea
                      rows={3}
                      placeholder="Briefly describe your mobile app concept, key features, target audience, and timeline..."
                      value={formData.details}
                      onChange={(e) => setFormData({...formData, details: e.target.value})}
                      className="w-full px-4 py-3 rounded-xl bg-slate-950 border border-slate-800 text-slate-100 text-sm focus:border-cyan-500 focus:outline-none transition-colors"
                    ></textarea>
                  </div>

                  <button
                    type="submit"
                    className="btn-ithrive-pill w-full py-4 text-sm font-black flex items-center justify-center gap-2 uppercase tracking-wider"
                  >
                    <Send className="w-4 h-4" />
                    <span>Get Free Mobile App Proposal & NDA</span>
                  </button>

                </form>
              )}

            </div>
          </div>

        </div>

      </div>
    </section>
  );
}
