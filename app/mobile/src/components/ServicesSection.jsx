import React, { useState } from 'react';
import { 
  Smartphone, Apple, Cpu, Sparkles, Layers, ShieldCheck, 
  Zap, ArrowRight, Code2, Globe, Server, CheckCircle
} from 'lucide-react';
import MouseOverText from './MouseOverText';
import V from '../variant';

export default function ServicesSection({ onOpenConsultation }) {
  const [activeTab, setActiveTab] = useState('all');

  const services = [
    {
      id: 'ios',
      category: 'native',
      icon: Apple,
      title: 'Native iOS App Development',
      tagline: 'Swift & SwiftUI Engineering for iPhone & iPad',
      description: 'Custom iOS applications built with Apple’s native Swift, SwiftUI, and Metal graphics framework. Optimized for iOS 18+, Apple Watch, and Vision Pro integration.',
      features: ['Swift & SwiftUI Architecture', 'Apple Pay & HealthKit Integration', 'CoreML & On-Device AI', 'App Store Review Guarantee'],
      color: 'cyan'
    },
    {
      id: 'android',
      category: 'native',
      icon: Smartphone,
      title: 'Native Android App Development',
      tagline: 'Kotlin & Jetpack Compose Excellence',
      description: 'High-speed, scalable Android applications built using Kotlin, Jetpack Compose, and Material 3 design system. Compatible across 10,000+ Android devices.',
      features: ['Kotlin Coroutines & Flow', 'Google Play Billing 6.0', 'Background Workers & Push', 'Android 15 Optimization'],
      color: 'emerald'
    },
    {
      id: 'flutter',
      category: 'cross',
      icon: Layers,
      title: 'Cross-Platform Flutter & React Native',
      tagline: 'Single Codebase. Dual Platform Perfection',
      description: 'Accelerate your time-to-market by 50% with near-native performance across iOS and Android from a single unified codebase engineered by iThrive Software.',
      features: ['60 FPS Flutter Dart Animations', 'React Native Fabric Engine', 'Shared Business Logic', 'Instant Hot Reload Updates'],
      color: 'purple'
    },
    {
      id: 'ai-mobile',
      category: 'ai',
      icon: Sparkles,
      title: 'AI-Powered Mobile Applications',
      tagline: 'On-Device LLMs, Voice & Vision AI',
      description: 'Transform mobile apps into intelligent digital assistants with embedded AI models, real-time voice synthesis, optical document scanning, and predictive analytics.',
      features: ['TensorFlow Lite & CoreML', 'Offline AI Reasoning', 'Multimodal Voice & Vision', 'Custom Fine-Tuned LLMs'],
      color: 'amber'
    },
    {
      id: 'ui-ux',
      category: 'design',
      icon: Code2,
      title: 'Mobile UI/UX Design & 3D Prototyping',
      tagline: 'Interactive 3D Micro-Animations & Design Systems',
      description: 'Award-winning mobile UI design crafted for maximum user engagement, effortless navigation, accessibility compliance, and stunning 3D micro-interactions.',
      features: ['Interactive Figma Prototypes', 'Custom Dark & Glass Themes', 'Micro-Animation Storyboarding', 'Usability & Eye-Tracking QA'],
      color: 'pink'
    },
    {
      id: 'enterprise',
      category: 'enterprise',
      icon: Server,
      title: 'Enterprise Mobile Solutions & Cloud',
      tagline: 'Bank-Grade Security, AWS & Firebase Backends',
      description: 'End-to-end enterprise mobile ecosystems integrated with secure REST/GraphQL APIs, microservices, cloud databases, biometric authentication, and CI/CD pipelines.',
      features: ['SOC2 & HIPAA Compliance', 'AWS Lambda & Firebase Sync', 'Biometric SSO Authentication', '24/7 Enterprise SLA Support'],
      color: 'blue'
    }
  ];

  const filteredServices = activeTab === 'all' 
    ? services 
    : services.filter(s => s.category === activeTab);

  return (
    <section id="services" className="py-20 md:py-28 relative bg-slate-950/60 border-t border-b border-slate-800/80">
      
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {/* Section Header */}
        <div className="text-center max-w-3xl mx-auto space-y-4 mb-14">
          <div className="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-cyan-950/80 border border-cyan-500/30 text-cyan-400 text-xs font-semibold uppercase tracking-wider">
            <Zap className="w-3.5 h-3.5" /> What We Build
          </div>

          <h2 className="text-3xl sm:text-4xl md:text-5xl font-black font-heading tracking-tight text-slate-100">
            End-to-End <MouseOverText text={V.servicesTitle} variant="glow" className="text-cyan-400" />
          </h2>

          <p className="text-slate-300 text-base sm:text-lg">
            From initial wireframe to App Store #1 ranking, iThrive Software delivers cutting-edge iOS, Android, and cross-platform mobile solutions in Chennai.
          </p>
        </div>

        {/* Filter Tabs using btn-ithrive-pill */}
        <div className="flex justify-center items-center gap-3 mb-12 flex-wrap">
          {[
            { id: 'all', label: 'All Services' },
            { id: 'native', label: 'Native iOS & Android' },
            { id: 'cross', label: 'Cross-Platform' },
            { id: 'ai', label: 'AI Mobile' },
            { id: 'enterprise', label: 'Enterprise Cloud' }
          ].map(tab => (
            <button
              key={tab.id}
              onClick={() => setActiveTab(tab.id)}
              className={`px-5 py-2.5 text-xs sm:text-sm ${
                activeTab === tab.id
                  ? 'btn-ithrive-pill'
                  : 'btn-ithrive-outline opacity-70 hover:opacity-100'
              }`}
            >
              {tab.label}
            </button>
          ))}
        </div>

        {/* Services Cards Grid */}
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          {filteredServices.map((service) => {
            const Icon = service.icon;
            return (
              <div
                key={service.id}
                className="glass-panel p-6 rounded-3xl flex flex-col justify-between group transition-all duration-300 hover:-translate-y-2 border border-slate-800 hover:border-cyan-500/50"
              >
                <div className="space-y-4">
                  
                  {/* Service Icon Box */}
                  <div className="w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-600 to-purple-600 flex items-center justify-center text-white font-bold shadow-lg shadow-blue-500/30 group-hover:scale-110 transition-all duration-300">
                    <Icon className="w-6 h-6" />
                  </div>

                  {/* Title with MouseOver Text Color Change */}
                  <div>
                    <h3 className="text-xl font-bold text-slate-100 group-hover:text-cyan-300 transition-colors">
                      <MouseOverText text={service.title} variant="glow" />
                    </h3>
                    <p className="text-xs text-cyan-400 font-medium mt-1">
                      {service.tagline}
                    </p>
                  </div>

                  <p className="text-slate-300 text-sm leading-relaxed">
                    {service.description}
                  </p>

                  {/* Features List */}
                  <ul className="space-y-2 pt-2 border-t border-slate-800/80">
                    {service.features.map((feat, idx) => (
                      <li key={idx} className="flex items-center gap-2 text-xs text-slate-300">
                        <CheckCircle className="w-3.5 h-3.5 text-cyan-400 flex-shrink-0" />
                        <span>{feat}</span>
                      </li>
                    ))}
                  </ul>
                </div>

                {/* Bottom Action Button matching Pill Format */}
                <div className="pt-6 mt-4 border-t border-slate-800/50 flex items-center justify-between">
                  <span className="text-[11px] text-slate-400 font-mono uppercase tracking-wider">iThrive Engineered</span>
                  <button
                    onClick={onOpenConsultation}
                    className="btn-ithrive-pill px-4 py-2 text-xs flex items-center gap-1"
                  >
                    <span>Consult Architect</span>
                    <ArrowRight className="w-3.5 h-3.5" />
                  </button>
                </div>

              </div>
            );
          })}
        </div>

      </div>
    </section>
  );
}
