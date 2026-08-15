import React, { useEffect, useState } from 'react';
import { ArrowRight, X, IndianRupee } from 'lucide-react';
import MouseOverText from './MouseOverText';

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
  ['E-commerce & retail apps',       '₹3,50,000',  '₹12,00,000', '3 – 6 months'],
  ['Healthcare & telemedicine apps', '₹4,50,000',  '₹15,00,000', '4 – 7 months'],
  ['FinTech & banking apps',         '₹5,00,000',  '₹18,00,000', '5 – 8 months'],
  ['Logistics & delivery apps',      '₹4,00,000',  '₹14,00,000', '4 – 7 months'],
  ['Real estate & property apps',    '₹3,50,000',  '₹12,50,000', '3 – 6 months'],
  ['Education & eLearning apps',     '₹3,80,000',  '₹13,00,000', '3 – 6 months'],
  ['Food delivery & restaurant apps','₹3,50,000',  '₹11,00,000', '3 – 5 months'],
  ['Corporate & business apps',      '₹3,00,000',  '₹10,00,000', '2 – 5 months'],
];

const SERVICE_RATES = [
  ['UI/UX design (wireframes & prototypes)',  '₹30,000',   '₹45,000',   '₹70,000'],
  ['Hybrid app build (Flutter / React Native)','₹1,50,000', '₹2,50,000', '₹4,00,000'],
  ['Native app build (Android / iOS)',        '₹2,00,000', '₹3,50,000', '₹5,00,000'],
  ['Backend (Node.js / Firebase / Python)',   '₹80,000',   '₹1,50,000', '₹2,50,000'],
  ['API integration & third-party services',  '₹40,000',   '₹70,000',   '₹1,20,000'],
  ['Web admin panel (React / Angular)',       '₹1,00,000', '₹1,80,000', '₹2,50,000'],
  ['Store deployment (Play Store / App Store)','₹20,000',  '₹25,000',   '₹30,000'],
  ['Annual maintenance & support',            '₹50,000',   '₹75,000',   '₹1,00,000'],
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
            aria-label="View mobile app development costs"
            title="View development costs"
            className="btn-ithrive-outline w-14 h-14 rounded-full flex items-center justify-center"
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
              <IndianRupee className="w-3.5 h-3.5" /> Indicative Indian market rates, 2026
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
