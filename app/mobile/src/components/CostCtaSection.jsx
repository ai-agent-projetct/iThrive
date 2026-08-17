import React, { useEffect, useState } from 'react';
import { ArrowRight, X, IndianRupee } from 'lucide-react';
import MouseOverText from './MouseOverText';
import V from '../variant';

/**
 * Cost CTA, in place of the old interactive estimator.
 *
 * Two targets in one control, which is the whole point: the button takes a
 * ready buyer straight to the contact page, and the arrow beside it opens the
 * rate card for someone who wants a number before they talk to anyone. A
 * configurator asked a browsing visitor to do work before it told them
 * anything; this answers first.
 *
 * Figures are indicative Indian market rates for 2026 and are labelled as
 * such — they are a starting range, not a quote.
 */

const INDUSTRY_RATES = [
  ['Corporate & business apps',       '₹2,20,000', '₹6,50,000',  '5 – 7 weeks'],
  ['Food delivery & restaurant apps', '₹2,60,000', '₹7,50,000',  '6 – 9 weeks'],
  ['Real estate & property apps',     '₹2,60,000', '₹8,00,000',  '6 – 9 weeks'],
  ['E-commerce & retail apps',        '₹2,80,000', '₹8,50,000',  '7 – 10 weeks'],
  ['Education & eLearning apps',      '₹2,80,000', '₹8,50,000',  '7 – 10 weeks'],
  ['Logistics & delivery apps',       '₹3,00,000', '₹9,50,000',  '8 – 11 weeks'],
  ['Healthcare & telemedicine apps',  '₹3,40,000', '₹10,50,000', '9 – 13 weeks'],
  ['FinTech & banking apps',          '₹3,80,000', '₹12,00,000', '10 – 14 weeks'],
];

const SERVICE_RATES = [
  ['UI/UX design (wireframes & prototypes)',   '₹25,000',   '₹40,000',   '₹60,000'],
  ['Hybrid app build (Flutter / React Native)','₹1,10,000', '₹1,90,000', '₹3,00,000'],
  ['Native app build (Android / iOS)',         '₹1,60,000', '₹2,70,000', '₹4,20,000'],
  ['Backend (Node.js / Firebase / Python)',    '₹65,000',   '₹1,20,000', '₹2,00,000'],
  ['API integration & third-party services',   '₹35,000',   '₹60,000',   '₹95,000'],
  ['Web admin panel (React / Angular)',        '₹80,000',   '₹1,40,000', '₹2,10,000'],
  ['Store deployment (Play Store / App Store)','₹20,000',   '₹25,000',   '₹30,000'],
  ['Annual maintenance & support',             '₹45,000',   '₹70,000',   '₹95,000'],
];

export default function CostCtaSection() {
  const [open, setOpen] = useState(false);

  // A modal that cannot be dismissed with Escape, or that lets the page behind
  // it scroll, is a trap on a long page like this one.
  useEffect(() => {
    if (!open) return;
    const onKey = (e) => { if (e.key === 'Escape') setOpen(false); };
    const prev = document.body.style.overflow;
    document.body.style.overflow = 'hidden';
    window.addEventListener('keydown', onKey);

    return () => {
      document.body.style.overflow = prev;
      window.removeEventListener('keydown', onKey);
    };
  }, [open]);

  const contactHref = (window.__ithriveBase || '/') + 'contact.php';

  return (
    <section id="estimator" className="py-20 md:py-28 relative bg-slate-950">
      <div className="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center">

        <h2 className="text-3xl sm:text-4xl md:text-5xl font-black font-heading tracking-tight text-slate-100">
          Looking for a reliable <MouseOverText text="mobile app development partner?" variant="glow" className="text-cyan-400" />
        </h2>

        <p className="text-slate-300 text-base sm:text-lg mt-4 max-w-3xl mx-auto">
          iThrive Software builds custom mobile apps, enterprise-grade platforms and AI-powered
          products for businesses that need to move faster than off-the-shelf software allows.
        </p>

        <div className="mt-10 flex items-center justify-center gap-3 flex-wrap">
          <a
            href={contactHref}
            className="btn-ithrive-pill px-9 py-4 text-sm sm:text-base font-extrabold uppercase tracking-wider"
          >
            Request a free project quote
          </a>

          {/* The arrow is its own control: costs, without leaving the page. */}
          <button
            type="button"
            onClick={() => setOpen(true)}
            aria-label={V.costLink}
            title="View development costs"
            className="cost-arrow w-14 h-14 rounded-full flex items-center justify-center"
          >
            <ArrowRight className="w-5 h-5" />
          </button>
        </div>

        <p className="text-slate-500 text-xs mt-4">
          Button goes to our team &middot; arrow opens current market pricing
        </p>
      </div>

      {open && (
        <div
          className="cost-modal-backdrop"
          role="dialog"
          aria-modal="true"
          aria-label="Mobile app development cost and timelines"
          onClick={(e) => { if (e.target === e.currentTarget) setOpen(false); }}
        >
          <div className="cost-modal">
            <button type="button" className="cost-modal-close" onClick={() => setOpen(false)} aria-label="Close">
              <X className="w-5 h-5" />
            </button>

            <h3 className="text-2xl sm:text-3xl font-black font-heading text-slate-100 text-center mb-1">
              Mobile app development cost &amp; timelines
            </h3>
            <p className="text-center text-slate-400 text-xs mb-7 flex items-center justify-center gap-1.5">
              <IndianRupee className="w-3.5 h-3.5" /> Indian market averages, 2026 — cross-platform build
            </p>

            <div className="cost-table-wrap">
              <table className="cost-table">
                <caption>By business category</caption>
                <thead>
                  <tr><th>Business category</th><th>Basic app</th><th>Advanced app</th><th>Time to launch</th></tr>
                </thead>
                <tbody>
                  {INDUSTRY_RATES.map(([cat, basic, adv, time]) => (
                    <tr key={cat}><td>{cat}</td><td>{basic}</td><td>{adv}</td><td>{time}</td></tr>
                  ))}
                </tbody>
              </table>
            </div>

            <div className="cost-table-wrap">
              <table className="cost-table">
                <caption>By service, and app size</caption>
                <thead>
                  <tr><th>Service</th><th>Basic (5 screens)</th><th>Medium (10 screens)</th><th>Advanced (15+ screens)</th></tr>
                </thead>
                <tbody>
                  {SERVICE_RATES.map(([svc, a, b, c]) => (
                    <tr key={svc}><td>{svc}</td><td>{a}</td><td>{b}</td><td>{c}</td></tr>
                  ))}
                </tbody>
              </table>
            </div>

            <p className="cost-modal-note">
              These are indicative. Final cost depends on features, industry, complexity and the
              stack chosen, and is fixed in writing after technical discovery.
            </p>

            <a href={contactHref} className="btn-ithrive-pill w-full py-4 text-sm font-extrabold uppercase tracking-wider mt-6">
              Get a fixed quote for your app
            </a>
          </div>
        </div>
      )}
    </section>
  );
}
