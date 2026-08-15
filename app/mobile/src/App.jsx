import React, { useState, useEffect } from 'react';
import Navbar from './components/Navbar';
import HeroSection from './components/HeroSection';
import ServicesSection from './components/ServicesSection';
import FunctionsChecklistSection from './components/FunctionsChecklistSection';
import TechStackSection from './components/TechStackSection';
import AppSimulatorSection from './components/AppSimulatorSection';
import InteractiveAppBuilder from './components/InteractiveAppBuilder';
import CostEstimator from './components/CostEstimator';
import CaseStudiesSection from './components/CaseStudiesSection';
import ProcessSection from './components/ProcessSection';
import ChennaiPresence from './components/ChennaiPresence';
import FaqSection from './components/FaqSection';
import ContactSection from './components/ContactSection';
import ProposalModal from './components/ProposalModal';
import HexagonGridBg from './components/HexagonGridBg';
import Footer from './components/Footer';

export default function App() {
  // Global text hover color palette state
  const [activePalette, setActivePalette] = useState('cyan-emerald');
  
  // 3D Phone Finish Color
  const [finishColor, setFinishColor] = useState('cyan');
  
  // Active Simulated Screen on 3D Mobile
  const [activeScreen, setActiveScreen] = useState('fintech');

  // Consultation Modal State
  const [isConsultationModalOpen, setIsConsultationModalOpen] = useState(false);

  // Mouse Spotlight Position
  const [mousePos, setMousePos] = useState({ x: -500, y: -500 });

  useEffect(() => {
    document.body.dataset.palette = activePalette;
  }, [activePalette]);

  useEffect(() => {
    const handleMouseMove = (e) => {
      setMousePos({ x: e.clientX, y: e.clientY });
    };
    window.addEventListener('mousemove', handleMouseMove);
    return () => window.removeEventListener('mousemove', handleMouseMove);
  }, []);

  const openConsultationModal = () => {
    setIsConsultationModalOpen(true);
  };

  return (
    <div className="min-h-screen bg-slate-950 text-slate-100 font-sans relative selection:bg-cyan-500 selection:text-slate-950 overflow-x-hidden">
      
      {/* Hexagon Black Honeycomb Mouseover Layer (7 Mouse-X Zones) */}
      <HexagonGridBg />

      {/* Interactive Cursor Spotlight */}
      <div 
        className="cursor-spotlight hidden lg:block"
        style={{
          transform: `translate3d(${mousePos.x}px, ${mousePos.y}px, 0)`
        }}
      />

      {/* Global Header Navigation */}
      <Navbar 
        activePalette={activePalette}
        onPaletteChange={setActivePalette}
        onOpenConsultation={openConsultationModal}
      />

      <main className="relative z-10">
        {/* Banner Section with Banner Image Title & 3D Mobile Canvas */}
        <HeroSection
          finishColor={finishColor}
          onFinishChange={setFinishColor}
          activeScreen={activeScreen}
          onScreenChange={setActiveScreen}
          onOpenConsultation={openConsultationModal}
        />

        {/* Mobile App Development Services */}
        <ServicesSection 
          onOpenConsultation={openConsultationModal}
        />

        {/* Core Mobile Functions Checklist (Clear Content Breakdown) */}
        <FunctionsChecklistSection 
          onOpenConsultation={openConsultationModal}
        />

        {/* 3D Mobile App Screen Simulator */}
        <AppSimulatorSection
          activeScreen={activeScreen}
          onScreenChange={setActiveScreen}
          onOpenConsultation={openConsultationModal}
        />

        {/* Interactive 3D Custom App Architecture Builder */}
        <InteractiveAppBuilder 
          onOpenConsultation={openConsultationModal}
        />

        {/* Clear Tech Stack Showcase */}
        <TechStackSection />

        {/* App Cost & Timeline Estimator */}
        <CostEstimator 
          onOpenConsultation={openConsultationModal}
        />

        {/* Featured Case Studies (Official iThrive Portfolio) */}
        <CaseStudiesSection 
          onOpenConsultation={openConsultationModal}
        />

        {/* 5-Step Process Flow Diagram */}
        <ProcessSection />

        {/* Chennai Studio Presence */}
        <ChennaiPresence 
          onOpenConsultation={openConsultationModal}
        />

        {/* FAQs */}
        <FaqSection />

        {/* Proposal & Contact Form */}
        <ContactSection />
      </main>

      {/* Instant Proposal Popup Modal */}
      <ProposalModal 
        isOpen={isConsultationModalOpen}
        onClose={() => setIsConsultationModalOpen(false)}
      />

      {/* Footer */}
      <Footer />

    </div>
  );
}
