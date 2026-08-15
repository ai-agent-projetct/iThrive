import React, { useState } from 'react';
import { HelpCircle, ChevronDown, Sparkles } from 'lucide-react';
import MouseOverText from './MouseOverText';

export default function FaqSection() {
  const [openIdx, setOpenIdx] = useState(0);

  const faqs = [
    {
      q: 'Why should I choose iThrive Software for Mobile App Development in Chennai?',
      a: 'iThrive Software is Chennai’s premier mobile app engineering team. We specialize in high-performance native iOS (Swift), native Android (Kotlin), cross-platform (Flutter & React Native), and AI-powered mobile apps. We provide 100% IP ownership, transparent milestone pricing, strict NDAs, and guaranteed App Store approval.'
    },
    {
      q: 'How much does it cost to build a mobile app with iThrive Software?',
      a: 'Basic mobile applications start from ₹1,80,000 ($2,400 USD), while feature-rich enterprise apps (with payment gateways, live GPS, 3D graphics, or AI agents) typically range from ₹3,50,000 to ₹12,00,000+. Use our interactive Cost Estimator on this page to get an instant estimate!'
    },
    {
      q: 'How long will it take to design and launch our mobile application?',
      a: 'A standard MVP mobile app takes 4 to 6 weeks from discovery to App Store submission. Complex enterprise applications with backends and AI integrations usually take 8 to 12 weeks. We follow agile 2-week sprints with test builds delivered every Friday.'
    },
    {
      q: 'Do you handle Apple App Store & Google Play Store submission?',
      a: 'Yes, 100%! We handle the entire deployment pipeline including app signing, screenshot creation, privacy policy compliance, metadata optimization, and resolving any App Store review queries until your app is live.'
    },
    {
      q: 'Will I own the source code and intellectual property (IP)?',
      a: 'Yes! Upon project completion, 100% of the source code, design assets, GitHub repositories, and intellectual property rights are legally transferred to your company.'
    },
    {
      q: 'What post-launch support and maintenance do you provide?',
      a: 'We provide 60 days of free post-launch support covering bug fixes and OS compatibility. Afterward, we offer flexible monthly SLA maintenance plans for feature upgrades and server monitoring.'
    }
  ];

  return (
    <section id="faq" className="py-20 md:py-28 relative bg-slate-950">
      
      <div className="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {/* Section Header */}
        <div className="text-center space-y-4 mb-14">
          <div className="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-cyan-950/80 border border-cyan-500/30 text-cyan-400 text-xs font-semibold uppercase tracking-wider">
            <HelpCircle className="w-3.5 h-3.5" /> Got Questions?
          </div>

          <h2 className="text-3xl sm:text-4xl md:text-5xl font-black font-heading tracking-tight text-slate-100">
            Frequently Asked <MouseOverText text="Questions" variant="glow" className="text-cyan-400" />
          </h2>

          <p className="text-slate-300 text-base sm:text-lg">
            Everything you need to know about our mobile app development services in Chennai.
          </p>
        </div>

        {/* Accordion List */}
        <div className="space-y-4">
          {faqs.map((faq, idx) => {
            const isOpen = openIdx === idx;
            return (
              <div
                key={idx}
                className="glass-panel rounded-2xl border border-slate-800 overflow-hidden transition-all duration-300"
              >
                <button
                  onClick={() => setOpenIdx(isOpen ? null : idx)}
                  className="w-full p-5 text-left flex items-center justify-between gap-4 font-bold text-slate-100 hover:text-cyan-300 text-base transition-colors"
                >
                  <MouseOverText text={faq.q} />
                  <ChevronDown className={`w-5 h-5 text-cyan-400 flex-shrink-0 transition-transform duration-300 ${isOpen ? 'rotate-180' : ''}`} />
                </button>

                {isOpen && (
                  <div className="px-5 pb-5 text-sm text-slate-300 leading-relaxed border-t border-slate-800/60 pt-3">
                    {faq.a}
                  </div>
                )}
              </div>
            );
          })}
        </div>

      </div>
    </section>
  );
}
