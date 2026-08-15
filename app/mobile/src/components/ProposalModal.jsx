import React, { useState } from 'react';
import { 
  X, CheckCircle2, ShieldCheck, Download, Sparkles, 
  Send, Phone, MapPin, FileText
} from 'lucide-react';
import MouseOverText from './MouseOverText';
import { playClickSound } from './AudioEngine';

export default function ProposalModal({ isOpen, onClose }) {
  const [submitted, setSubmitted] = useState(false);
  const [name, setName] = useState('');
  const [email, setEmail] = useState('');
  const [phone, setPhone] = useState('');
  const [platform, setPlatform] = useState('Cross-Platform (iOS + Android)');

  if (!isOpen) return null;

  const handleSubmit = (e) => {
    e.preventDefault();
    playClickSound();
    setSubmitted(true);
  };

  return (
    <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-xl animate-fade-in select-none">
      <div className="relative w-full max-w-xl glass-panel p-6 sm:p-8 rounded-3xl border border-cyan-500/40 shadow-2xl space-y-6">
        
        {/* Close Button */}
        <button
          onClick={() => {
            playClickSound();
            onClose();
          }}
          className="absolute top-4 right-4 p-2 rounded-full bg-slate-900 text-slate-400 hover:text-white border border-slate-800 transition-colors"
        >
          <X className="w-5 h-5" />
        </button>

        {submitted ? (
          <div className="text-center py-8 space-y-4">
            <div className="w-16 h-16 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center mx-auto border border-emerald-500/40 animate-bounce">
              <CheckCircle2 className="w-8 h-8" />
            </div>
            <h3 className="text-2xl font-bold text-slate-100">Proposal Request Confirmed!</h3>
            <p className="text-slate-300 text-sm max-w-md mx-auto">
              Thank you, <span className="text-cyan-300 font-bold">{name || 'Client'}</span>! An iThrive Senior Architect from our Chennai studio will connect with you via WhatsApp & Email within 2 hours.
            </p>
            <div className="p-3 rounded-xl bg-slate-900 border border-slate-800 text-xs text-emerald-400 font-semibold flex items-center justify-center gap-2">
              <ShieldCheck className="w-4 h-4" /> Mutual NDA automatically initiated
            </div>
            <button
              onClick={() => {
                setSubmitted(false);
                onClose();
              }}
              className="btn-ithrive-pill px-6 py-2.5 text-xs font-extrabold"
            >
              Done & Return to Site
            </button>
          </div>
        ) : (
          <form onSubmit={handleSubmit} className="space-y-4">
            <div className="space-y-1">
              <div className="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-cyan-950/80 border border-cyan-500/30 text-cyan-400 text-[11px] font-semibold uppercase">
                <Sparkles className="w-3 h-3 text-cyan-400" /> Instant Mobile App Quote
              </div>
              <h3 className="text-2xl font-black text-slate-100 font-heading">
                <MouseOverText text="Book Free App Consultation" variant="glow" />
              </h3>
              <p className="text-xs text-slate-400">
                iThrive Software Solutions • OMR IT Hub, Chennai
              </p>
            </div>

            <div>
              <label className="block text-xs font-semibold text-slate-300 mb-1">Your Name *</label>
              <input
                type="text"
                required
                placeholder="e.g. Ramesh Kumar"
                value={name}
                onChange={(e) => setName(e.target.value)}
                className="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-slate-100 text-xs focus:border-cyan-500 focus:outline-none"
              />
            </div>

            <div className="grid grid-cols-1 sm:grid-cols-2 gap-3">
              <div>
                <label className="block text-xs font-semibold text-slate-300 mb-1">Work Email *</label>
                <input
                  type="email"
                  required
                  placeholder="ramesh@company.com"
                  value={email}
                  onChange={(e) => setEmail(e.target.value)}
                  className="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-slate-100 text-xs focus:border-cyan-500 focus:outline-none"
                />
              </div>

              <div>
                <label className="block text-xs font-semibold text-slate-300 mb-1">Phone / WhatsApp *</label>
                <input
                  type="tel"
                  required
                  placeholder="+91 98765 43210"
                  value={phone}
                  onChange={(e) => setPhone(e.target.value)}
                  className="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-slate-100 text-xs focus:border-cyan-500 focus:outline-none"
                />
              </div>
            </div>

            <div>
              <label className="block text-xs font-semibold text-slate-300 mb-1">Target Platform</label>
              <select
                value={platform}
                onChange={(e) => setPlatform(e.target.value)}
                className="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-slate-100 text-xs focus:border-cyan-500 focus:outline-none"
              >
                <option>Cross-Platform (iOS + Android Flutter)</option>
                <option>Native iOS (SwiftUI)</option>
                <option>Native Android (Kotlin)</option>
                <option>AI-Powered Mobile App</option>
              </select>
            </div>

            <button
              type="submit"
              className="btn-ithrive-pill w-full py-4 text-xs uppercase tracking-wider flex items-center justify-center gap-2"
            >
              <Send className="w-4 h-4" />
              <span>Submit & Receive NDA Proposal</span>
            </button>
          </form>
        )}

      </div>
    </div>
  );
}
