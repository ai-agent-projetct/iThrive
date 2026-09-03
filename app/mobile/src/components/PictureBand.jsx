import React from 'react';

/**
 * A full-width picture band between two sections.
 *
 * These two pages were the last on the site with almost no picture — four
 * images across nine sections — while every other route has carried figure
 * bands for a while. The pictures are drawn rather than photographed
 * (tools/app-bands.mjs) because what is worth showing here is the app's own
 * architecture and the road from a commit to a store listing, and there is no
 * photograph of either.
 *
 * The image lives on the PHP side, so the path goes through window.__ithriveBase
 * the same way TechMagnetSection and AppUniverse resolve theirs — BASE_URL can
 * be a subdirectory on some installs, and a leading-slash path would break there.
 *
 * The caption is the alt text: each band is a labelled diagram, so it carries
 * information rather than mood, and a screen reader should get it.
 */
export default function PictureBand({ img, caption }) {
  const src = (window.__ithriveBase || '/') + 'assets/img/pages/apps/' + img + '.jpg';

  return (
    <section className="relative px-6 py-10 md:py-16">
      <figure className="mx-auto max-w-6xl">
        <div className="relative overflow-hidden rounded-2xl border border-white/10 bg-slate-950">
          <img
            src={src}
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
