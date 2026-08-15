/**
 * Embedded entry for the mobile app development page.
 *
 * The upstream App.jsx renders a whole standalone site — its own Navbar, its
 * own Footer, its own <html> shell. Here the page is one route inside a PHP
 * site that already has those, so this entry mounts the *sections only* into a
 * div the PHP template renders. Everything else is upstream's, unchanged.
 *
 * Keeping the section list in the same order as App.jsx is deliberate: when the
 * upstream repo adds a section, the diff between that file and this one is the
 * whole change.
 */

import React, { useState, useEffect } from 'react';
import ReactDOM from 'react-dom/client';

import HeroSection from './components/HeroSection';
import ServicesSection from './components/ServicesSection';
import FunctionsChecklistSection from './components/FunctionsChecklistSection';
import AppSimulatorSection from './components/AppSimulatorSection';
import InteractiveAppBuilder from './components/InteractiveAppBuilder';
import TechMagnetSection from './components/TechMagnetSection';
import TechStackSection from './components/TechStackSection';
import CostEstimator from './components/CostEstimator';
import CaseStudiesSection from './components/CaseStudiesSection';
import ProcessSection from './components/ProcessSection';
import ChennaiPresence from './components/ChennaiPresence';
import FaqSection from './components/FaqSection';
import ContactSection from './components/ContactSection';
import ProposalModal from './components/ProposalModal';
import HexagonGridBg from './components/HexagonGridBg';

import './embed.css';

function MobileAppPage() {
  const [finishColor, setFinishColor] = useState('cyan');
  const [activeScreen, setActiveScreen] = useState('fintech');
  const [isConsultationModalOpen, setIsConsultationModalOpen] = useState(false);
  const [mousePos, setMousePos] = useState({ x: -500, y: -500 });

  // Upstream sets this on <body>; the palette selector lived in the Navbar,
  // which this page does not render, so it is pinned to the default.
  useEffect(() => {
    document.body.dataset.palette = 'cyan-emerald';
  }, []);

  useEffect(() => {
    const onMove = (e) => setMousePos({ x: e.clientX, y: e.clientY });
    window.addEventListener('mousemove', onMove);

    return () => window.removeEventListener('mousemove', onMove);
  }, []);

  const openConsultationModal = () => setIsConsultationModalOpen(true);

  return (
    <div className="ithrive-mobile-app text-slate-100 font-sans relative">
      <HexagonGridBg />

      <div
        className="cursor-spotlight hidden lg:block"
        style={{ transform: `translate3d(${mousePos.x}px, ${mousePos.y}px, 0)` }}
      />

      <div className="relative z-10">
        <HeroSection
          finishColor={finishColor}
          onFinishChange={setFinishColor}
          activeScreen={activeScreen}
          onScreenChange={setActiveScreen}
          onOpenConsultation={openConsultationModal}
        />
        <ServicesSection onOpenConsultation={openConsultationModal} />
        <FunctionsChecklistSection onOpenConsultation={openConsultationModal} />
        <AppSimulatorSection
          activeScreen={activeScreen}
          onScreenChange={setActiveScreen}
          onOpenConsultation={openConsultationModal}
        />
        <InteractiveAppBuilder onOpenConsultation={openConsultationModal} />
        <TechMagnetSection />
        <TechStackSection />
        <CostEstimator onOpenConsultation={openConsultationModal} />
        <CaseStudiesSection onOpenConsultation={openConsultationModal} />
        <ProcessSection />
        <ChennaiPresence onOpenConsultation={openConsultationModal} />
        <FaqSection />
        <ContactSection />
      </div>

      <ProposalModal
        isOpen={isConsultationModalOpen}
        onClose={() => setIsConsultationModalOpen(false)}
      />
    </div>
  );
}

const mount = document.getElementById('ithrive-mobile-root');
if (mount) {
  ReactDOM.createRoot(mount).render(
    <React.StrictMode>
      <MobileAppPage />
    </React.StrictMode>
  );
}
