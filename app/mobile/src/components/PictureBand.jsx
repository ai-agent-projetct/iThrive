import React from 'react';

/**
 * A full-width picture band between two sections.
 *
 * These two pages were the last on the site with almost no picture — four
 * images across nine sections — while every other route has carried figure
 * bands for a while.
 *
 * The image lives on the PHP side, so the path goes through window.__ithriveBase
 * the same way TechMagnetSection and AppUniverse resolve theirs — BASE_URL can
 * be a subdirectory on some installs, and a leading-slash path would break there.
 *
 * Prefers the photograph in apps/photo/ and falls back to the drawing beside it,
 * which is the same preference page-figure.php applies on the PHP side. PHP can
 * test the file; a browser cannot, so the fallback rides on the img's own error
 * event — one attempt, guarded so a missing drawing cannot loop.
 *
 * The caption is the alt text: it carries information rather than mood, and a
 * screen reader should get it.
 */
export default function PictureBand({ img, caption }) {
  const base = (window.__ithriveBase || '/') + 'assets/img/pages/apps/';

  return (
    <section className="relative px-6 py-10 md:py-16">
      <figure className="mx-auto max-w-6xl">
        <div className="relative overflow-hidden rounded-2xl border border-white/10 bg-slate-950">
          <img
            src={base + 'photo/' + img + '.jpg'}
            onError={(e) => {
              const el = e.currentTarget;
              if (el.dataset.fellBack) return;
              el.dataset.fellBack = '1';
              el.src = base + img + '.jpg';
            }}
            alt={caption}
            width={1680}
            height={640}
            loading="lazy"
            decoding="async"
            className="block h-auto w-full"
          />
        </div>
        <figcaption className="mt-3 text-sm text-slate-400">{caption}</figcaption>
      </figure>
    </section>
  );
}
