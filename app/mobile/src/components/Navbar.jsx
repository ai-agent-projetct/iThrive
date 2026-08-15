import React, { useState, useEffect } from 'react';
import { 
  Smartphone, Sparkles, Phone, Menu, X, ChevronDown, 
  MapPin, ShieldCheck, Palette, Calculator, Volume2, VolumeX
} from 'lucide-react';
import MouseOverText from './MouseOverText';
import { toggleSound, playClickSound } from './AudioEngine';

export default function Navbar({ activePalette, onPaletteChange, onOpenConsultation }) {
  const [scrolled, setScrolled] = useState(false);
  const [mobileMenuOpen, setMobileMenuOpen] = useState(false);
  const [paletteMenuOpen, setPaletteMenuOpen] = useState(false);
  const [soundOn, setSoundOn] = useState(true);

  useEffect(() => {
    const handleScroll = () => {
      setScrolled(window.scrollY > 20);
    };
    window.addEventListener('scroll', handleScroll);
    return () => window.removeEventListener('scroll', handleScroll);
  }, []);

  const handleSoundToggle = () => {
    const nextState = !soundOn;
    setSoundOn(nextState);
    toggleSound(nextState);
    if (nextState) playClickSound();
  };

  const palettes = [
    { id: 'cyan-emerald', label: 'iThrive Electric Blue', color: '#00e5ff' },
    { id: 'violet-pink', label: 'Royal Violet & Pink', color: '#a855f7' },
    { id: 'gold-crimson', label: 'Solar Gold & Crimson', color: '#f59e0b' },
    { id: 'cyber-green', label: 'Emerald Matrix', color: '#10b981' },
  ];

  return (
    <nav className={`fixed top-0 left-0 right-0 z-50 transition-all duration-300 ${
      scrolled 
        ? 'bg-slate-950/90 backdrop-blur-xl border-b border-slate-800/80 py-3 shadow-2xl shadow-blue-950/30' 
        : 'bg-transparent py-5'
    }`}>
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between">
        
        {/* Brand Logo - Matching Uploaded Image */}
        <a href="#" className="flex items-center gap-3 group">
          <div className="relative w-10 h-10 flex items-center justify-center">
            <div className="absolute top-0 w-3.5 h-3.5 rounded-full bg-gradient-to-r from-cyan-400 to-blue-500 shadow-md shadow-cyan-400/50"></div>
            <div className="w-10 h-10 rounded-2xl bg-gradient-to-tr from-cyan-400 via-blue-600 to-purple-600 p-[2px] shadow-lg shadow-blue-600/30 group-hover:scale-105 transition-transform duration-300">
              <div className="w-full h-full bg-slate-950 rounded-[14px] flex items-center justify-center">
                <span className="font-black text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 via-blue-500 to-purple-500 text-lg font-heading">
                  it
                </span>
              </div>
            </div>
          </div>
          <div className="flex flex-col">
            <div className="flex items-center gap-1.5">
              <span className="text-2xl font-black text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 via-blue-500 to-purple-500 font-heading">
                ITHRIVE
              </span>
              <span className="text-2xl font-light text-white">SOFTWARE</span>
            </div>
            <div className="flex items-center gap-1 text-[10px] text-cyan-400 font-semibold tracking-wider uppercase">
              <MapPin className="w-2.5 h-2.5" /> Chennai • Mobile App Studio
            </div>
          </div>
        </a>

        {/* Desktop Navigation Links */}
        <div className="hidden lg:flex items-center gap-7 text-sm font-medium text-white">
          <a href="#services" className="hover:text-cyan-400 transition-colors py-1 relative group">
            <MouseOverText text="App Services" />
            <span className="absolute bottom-0 left-0 w-0 h-0.5 bg-cyan-400 transition-all duration-300 group-hover:w-full"></span>
          </a>

          <a href="#simulator" className="hover:text-cyan-400 transition-colors py-1 relative group flex items-center gap-1">
            <Sparkles className="w-3.5 h-3.5 text-cyan-400" />
            <MouseOverText text="3D Demo" />
            <span className="absolute bottom-0 left-0 w-0 h-0.5 bg-cyan-400 transition-all duration-300 group-hover:w-full"></span>
          </a>

          <a href="#app-builder" className="hover:text-cyan-400 transition-colors py-1 relative group">
            <MouseOverText text="3D App Studio" />
            <span className="absolute bottom-0 left-0 w-0 h-0.5 bg-cyan-400 transition-all duration-300 group-hover:w-full"></span>
          </a>

          <a href="#techstack" className="hover:text-cyan-400 transition-colors py-1 relative group">
            <MouseOverText text="Tech Stack" />
            <span className="absolute bottom-0 left-0 w-0 h-0.5 bg-cyan-400 transition-all duration-300 group-hover:w-full"></span>
          </a>

          <a href="#estimator" className="hover:text-cyan-400 transition-colors py-1 relative group flex items-center gap-1">
            <Calculator className="w-3.5 h-3.5 text-blue-400" />
            <MouseOverText text="Cost Estimator" />
            <span className="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-400 transition-all duration-300 group-hover:w-full"></span>
          </a>

          <a href="#chennai-hub" className="hover:text-cyan-400 transition-colors py-1 relative group">
            <MouseOverText text="Chennai Hub" />
            <span className="absolute bottom-0 left-0 w-0 h-0.5 bg-cyan-400 transition-all duration-300 group-hover:w-full"></span>
          </a>
        </div>

        {/* Action Controls & CTA Button matching uploaded Pill Format */}
        <div className="hidden sm:flex items-center gap-3">
          
          {/* Sound FX Toggle Button */}
          <button
            onClick={handleSoundToggle}
            className="p-2.5 rounded-full bg-slate-900 border border-slate-800 text-white hover:text-cyan-400 hover:border-blue-500/50 transition-all text-xs flex items-center gap-1"
            title={soundOn ? "Mute UI Sound FX" : "Enable UI Sound FX"}
          >
            {soundOn ? <Volume2 className="w-4 h-4 text-cyan-400" /> : <VolumeX className="w-4 h-4 text-slate-500" />}
          </button>

          {/* Palette Theme Selector Dropdown */}
          <div className="relative">
            <button
              onClick={() => {
                playClickSound();
                setPaletteMenuOpen(!paletteMenuOpen);
              }}
              className="p-2.5 rounded-full bg-slate-900 border border-slate-800 text-white hover:border-blue-500/50 transition-all flex items-center gap-1.5 text-xs"
              title="Change Text & Accent Color Theme"
            >
              <Palette className="w-4 h-4 text-cyan-400" />
              <span className="hidden md:inline">Hover Palette</span>
              <ChevronDown className="w-3 h-3 text-slate-500" />
            </button>

            {paletteMenuOpen && (
              <div className="absolute right-0 mt-2 w-56 bg-slate-900 border border-slate-800 rounded-2xl shadow-2xl p-2 z-50">
                <div className="text-[10px] font-semibold text-slate-500 uppercase px-3 py-1.5 tracking-wider">
                  Text Hover Theme
                </div>
                {palettes.map((p) => (
                  <button
                    key={p.id}
                    onClick={() => {
                      playClickSound();
                      onPaletteChange(p.id);
                      setPaletteMenuOpen(false);
                    }}
                    className={`w-full text-left px-3 py-2 rounded-xl text-xs flex items-center justify-between transition-colors ${
                      activePalette === p.id 
                        ? 'bg-slate-800 text-cyan-300 font-semibold' 
                        : 'text-slate-200 hover:bg-slate-800/60'
                    }`}
                  >
                    <span>{p.label}</span>
                    <span 
                      className="w-3 h-3 rounded-full border border-white/20"
                      style={{ backgroundColor: p.color }}
                    />
                  </button>
                ))}
              </div>
            )}
          </div>

          {/* Signature Pill CTA Button */}
          <button
            onClick={() => {
              playClickSound();
              onOpenConsultation();
            }}
            className="btn-ithrive-pill px-6 py-2.5 text-xs flex items-center gap-2"
          >
            <Phone className="w-3.5 h-3.5" />
            <span>Get Free Quote</span>
          </button>
        </div>

        {/* Mobile Hamburger Menu Toggle */}
        <button
          onClick={() => {
            playClickSound();
            setMobileMenuOpen(!mobileMenuOpen);
          }}
          className="lg:hidden p-2.5 rounded-full bg-slate-900 border border-slate-800 text-white hover:text-cyan-400"
        >
          {mobileMenuOpen ? <X className="w-6 h-6" /> : <Menu className="w-6 h-6" />}
        </button>
      </div>

      {/* Mobile Drawer Menu */}
      {mobileMenuOpen && (
        <div className="lg:hidden bg-slate-950 border-b border-slate-800 px-4 py-6 space-y-4 shadow-2xl">
          <a
            href="#services"
            onClick={() => setMobileMenuOpen(false)}
            className="block text-white hover:text-cyan-400 font-medium text-base"
          >
            App Services
          </a>
          <a
            href="#simulator"
            onClick={() => setMobileMenuOpen(false)}
            className="block text-white hover:text-cyan-400 font-medium text-base flex items-center gap-2"
          >
            <Sparkles className="w-4 h-4 text-cyan-400" /> 3D App Simulator
          </a>
          <a
            href="#app-builder"
            onClick={() => setMobileMenuOpen(false)}
            className="block text-white hover:text-cyan-400 font-medium text-base"
          >
            3D App Studio
          </a>
          <a
            href="#techstack"
            onClick={() => setMobileMenuOpen(false)}
            className="block text-white hover:text-cyan-400 font-medium text-base"
          >
            Tech Stack
          </a>
          <a
            href="#estimator"
            onClick={() => setMobileMenuOpen(false)}
            className="block text-white hover:text-cyan-400 font-medium text-base flex items-center gap-2"
          >
            <Calculator className="w-4 h-4 text-blue-400" /> Cost Estimator
          </a>
          <a
            href="#chennai-hub"
            onClick={() => setMobileMenuOpen(false)}
            className="block text-white hover:text-cyan-400 font-medium text-base"
          >
            Chennai Hub
          </a>

          <div className="pt-4 border-t border-slate-800 flex flex-col gap-3">
            <button
              onClick={() => {
                setMobileMenuOpen(false);
                onOpenConsultation();
              }}
              className="btn-ithrive-pill w-full py-3.5 text-sm flex items-center justify-center gap-2"
            >
              <Phone className="w-4 h-4" /> Book App Consultation
            </button>
          </div>
        </div>
      )}
    </nav>
  );
}
