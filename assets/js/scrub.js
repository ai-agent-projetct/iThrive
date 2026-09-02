/**
 * Generic scroll-scrubbed video.
 *
 * Any `[data-scrub]` section with a `[data-scrub-video]` inside it becomes a
 * pinned stage whose playhead is tied to how far you have scrolled through it.
 * Written to handle several on one page, unlike film.js, which predates it and
 * binds a single instance with its own chapter logic.
 *
 * Smoothness is mostly an encoding property — the sources are cut with a
 * keyframe every third frame so a seek never walks back to find one. On top of
 * that the playhead eases toward the scroll target, seeks are skipped while one
 * is already in flight, and the decoder is primed with a muted play/pause so
 * the very first seek paints.
 *
 * Skipped on touch and under prefers-reduced-motion, where seek-per-frame is
 * unreliable and unwanted; those play the clip inline instead.
 */

(function () {
  'use strict';

  const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  const coarse = window.matchMedia('(pointer: coarse)').matches;

  // A pinned stage only earns its scroll if there is room to lay it out. Below
  // this the stage stacks and shrinks, and pinning would spend three viewports
  // of scrolling on a picture the visitor can already see whole.
  const narrow = window.matchMedia('(max-width: 1100px)').matches;

  document.querySelectorAll('[data-scrub]').forEach((section) => {
    const video = section.querySelector('[data-scrub-video]');
    if (!video) return;

    const bar = section.querySelector('[data-scrub-bar]');

    /* ---- fallbacks ---------------------------------------------------- */

    if (reduceMotion || coarse || narrow) {
      section.classList.add('scrub--inline');
      video.loop = true;
      video.muted = true;

      if (!reduceMotion && 'IntersectionObserver' in window) {
        new IntersectionObserver(([e]) => {
          if (e.isIntersecting) { const p = video.play(); if (p) p.catch(() => {}); }
          else video.pause();
        }, { threshold: 0.3 }).observe(video);
      }

      return;
    }

    section.classList.add('scrub--live');

    /* ---- prime the decoder -------------------------------------------- */

    // A video that has never played will not seek promptly in Chrome. Muted
    // playback needs no gesture, so start it and stop it immediately.
    let primed = false;
    const prime = () => {
      if (primed) return;
      primed = true;
      const p = video.play();
      if (p && p.then) p.then(() => video.pause()).catch(() => {});
      else video.pause();
    };
    if (video.readyState >= 2) prime();
    else video.addEventListener('loadeddata', prime, { once: true });

    /* ---- the scrub ------------------------------------------------------ */

    let duration = parseFloat(section.dataset.scrubDuration) || 0;

    // Read it now AND on the event. This script is deferred, so a video whose
    // metadata is already in the cache has fired loadedmetadata before we could
    // listen for it — and a section with no data-scrub-duration to fall back on
    // would then sit at zero forever, with the frame loop returning early and
    // the playhead never moving.
    const readDuration = () => {
      if (isFinite(video.duration) && video.duration > 0) duration = video.duration;
    };
    readDuration();
    video.addEventListener('loadedmetadata', readDuration);

    // fastSeek skips the exact-frame search. With a keyframe every third frame
    // the nearest one is effectively the frame asked for.
    const seek = typeof video.fastSeek === 'function'
      ? (t) => video.fastSeek(t)
      : (t) => { video.currentTime = t; };

    const clamp = (v, a, b) => (v < a ? a : v > b ? b : v);

    /*
     * How hard the playhead is pulled toward the scroll position each frame.
     * Lower is smoother and laggier: the film glides into place instead of
     * snapping to it. Per section rather than global, because the right value
     * depends on how much film is mapped across how much scroll — a long clip
     * on a long track wants a gentler pull than a short one.
     */
    const ease = parseFloat(section.dataset.scrubEase) || 0.16;

    let target = 0;
    let current = 0;
    let visible = true;
    let raf = 0;

    const progress = () => {
      const rect = section.getBoundingClientRect();
      const range = rect.height - window.innerHeight;

      return range <= 0 ? 0 : clamp(-rect.top / range, 0, 1);
    };

    const frame = () => {
      raf = requestAnimationFrame(frame);
      if (!visible || duration <= 0) return;

      // Read the rect every frame rather than only on the scroll event: the
      // last event of a scroll fires before the browser has settled, and with
      // nothing after it the playhead would stop short of the end.
      target = progress() * duration;

      current += (target - current) * ease;
      if (Math.abs(target - current) < 0.004) current = target;

      if (!video.seeking && Math.abs(video.currentTime - current) > 1 / 48) {
        seek(clamp(current, 0, duration - 0.02));
      }

      if (bar) bar.style.width = ((current / duration) * 100).toFixed(1) + '%';
    };

    if ('IntersectionObserver' in window) {
      new IntersectionObserver(([entry]) => { visible = entry.isIntersecting; }, { threshold: 0 })
        .observe(section);
    }

    raf = requestAnimationFrame(frame);
  });
})();
