import React from 'react';
import { 
  Smartphone, MapPin, Heart, ShieldCheck, ArrowUp 
} from 'lucide-react';
import MouseOverText from './MouseOverText';

export default function Footer() {
  const scrollToTop = () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  };

  return (
    <footer className="bg-slate-950 border-t border-slate-800 text-slate-400 text-xs py-12 relative">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        
        <div className="grid grid-cols-1 md:grid-cols-4 gap-8 pb-8 border-b border-slate-900">
          
          {/* Brand Col */}
          <div className="space-y-3 md:col-span-1">
            <div className="flex items-center gap-2">
              <div className="w-8 h-8 rounded-lg bg-gradient-to-tr from-cyan-500 to-emerald-400 flex items-center justify-center text-slate-950 font-bold">
                <Smartphone className="w-4 h-4" />
              </div>
              <span className="text-xl font-black text-slate-100 font-heading">iThrive <span className="font-light">Software</span></span>
            </div>
            <p className="text-slate-400 text-xs leading-relaxed">
              Premier Mobile App Development Company in Chennai. Building high-performance iOS, Android, Flutter, and AI mobile solutions for modern enterprises.
            </p>
            <div className="flex items-center gap-1 text-emerald-400 font-semibold text-[11px]">
              <MapPin className="w-3.5 h-3.5" /> OMR IT Corridor, Chennai
            </div>
          </div>

          {/* Services Links */}
          <div className="space-y-2">
            <h4 className="text-slate-200 font-bold text-sm">Mobile Services</h4>
            <ul className="space-y-1.5 text-slate-400">
              <li><a href="#services" className="hover:text-cyan-300 transition-colors"><MouseOverText text="Native iOS App Development" /></a></li>
              <li><a href="#services" className="hover:text-cyan-300 transition-colors"><MouseOverText text="Native Android Development" /></a></li>
              <li><a href="#services" className="hover:text-cyan-300 transition-colors"><MouseOverText text="Flutter Cross-Platform Apps" /></a></li>
              <li><a href="#services" className="hover:text-cyan-300 transition-colors"><MouseOverText text="React Native Mobile Apps" /></a></li>
              <li><a href="#services" className="hover:text-cyan-300 transition-colors"><MouseOverText text="AI-Powered Mobile Apps" /></a></li>
            </ul>
          </div>

          {/* Quick Links */}
          <div className="space-y-2">
            <h4 className="text-slate-200 font-bold text-sm">Quick Links</h4>
            <ul className="space-y-1.5 text-slate-400">
              <li><a href="#simulator" className="hover:text-cyan-300 transition-colors"><MouseOverText text="Interactive 3D Demo" /></a></li>
              <li><a href="#techstack" className="hover:text-cyan-300 transition-colors"><MouseOverText text="Technology Stack" /></a></li>
              <li><a href="#estimator" className="hover:text-cyan-300 transition-colors"><MouseOverText text="App Cost Calculator" /></a></li>
              <li><a href="#chennai-hub" className="hover:text-cyan-300 transition-colors"><MouseOverText text="Chennai Development Hub" /></a></li>
              <li><a href="#faq" className="hover:text-cyan-300 transition-colors"><MouseOverText text="Mobile Development FAQs" /></a></li>
            </ul>
          </div>

          {/* External website & Legal */}
          <div className="space-y-3">
            <h4 className="text-slate-200 font-bold text-sm">Official Portal</h4>
            <p className="text-slate-400 text-xs">
              Visit our corporate website at:
            </p>
            <a 
              href="https://ithrivesoftware.com/" 
              target="_blank" 
              rel="noreferrer"
              className="inline-block px-4 py-2 rounded-xl bg-slate-900 border border-slate-800 text-cyan-400 font-mono text-xs hover:border-cyan-500/50 transition-colors"
            >
              https://ithrivesoftware.com/
            </a>
          </div>

        </div>

        {/* Bottom copyright bar */}
        <div className="flex flex-col sm:flex-row items-center justify-between gap-4 text-[11px] text-slate-400">
          <div>
            © {new Date().getFullYear()} <span className="text-slate-200 font-semibold">iThrive Software Solutions</span>. All Rights Reserved. Mobile App Development Company in Chennai.
          </div>

          <div className="flex items-center gap-4">
            <button
              onClick={scrollToTop}
              className="p-2 rounded-full bg-slate-900 border border-slate-800 text-cyan-400 hover:text-cyan-300 transition-colors"
              title="Back to Top"
            >
              <ArrowUp className="w-4 h-4" />
            </button>
          </div>
        </div>

      </div>
    </footer>
  );
}
