/**
 * Scroll-scrubbed services film.
 *
 * Scroll position drives the video's currentTime instead of a play button. Two
 * things make that feel smooth rather than steppy:
 *
 *  1. The source is encoded all-intra — every frame is a keyframe, see the
 *     README — so any time value decodes without walking back to an earlier
 *     keyframe. This is the whole ballgame; no amount of JavaScript rescues a
 *     video whose keyframes are two seconds apart.
 *  2. The playhead eases toward the scroll target rather than snapping to it,
 *     so a flick of the wheel glides to a stop instead of jumping.
 *
 * The only UI is the button, which follows the playhead: each card in the film
 * names a service, so whatever is on screen is what the button opens.
 *
 * Skipped on touch and under prefers-reduced-motion, where seek-per-frame is
 * unreliable and unwanted; those play the film inline instead.
 */

(function () {
  'use strict';

  const section = document.querySelector('[data-film]');
  if (!section) return;

  const video    = section.querySelector('[data-film-video]');
  const cta      = section.querySelector('[data-film-cta]');
  const ctaLabel = section.querySelector('[data-film-cta-label]');
  if (!video) return;

  let chapters = [];
  try { chapters = JSON.parse(section.dataset.filmChapters || '[]'); } catch { /* button stays put */ }

  const clamp = (v, a, b) => (v < a ? a : v > b ? b : v);

  /* --------------------------------------------------------- active chapter */

  let activeIndex = -1;

  function setActive(time) {
    if (chapters.length === 0 || !cta || !ctaLabel) return;

    let next = 0;
    for (let i = 0; i < chapters.length; i++) {
      if (time >= chapters[i].at - 0.35) next = i;
    }
    if (next === activeIndex) return;
    activeIndex = next;

    cta.setAttribute('href', chapters[next].href);
    ctaLabel.textContent = chapters[next].label;
  }

  setActive(0);

  /* ------------------------------------------------------------- fallbacks */

  const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  const coarse       = window.matchMedia('(pointer: coarse)').matches;

  if (reduceMotion || coarse) {
    // No scrubbing: play it inline, and keep the button tracking the playhead
    // so it still opens whatever service is on screen.
    section.classList.add('film--inline');
    video.loop = true;
    video.addEventListener('timeupdate', () => setActive(video.currentTime));

    if (!reduceMotion && 'IntersectionObserver' in window) {
      new IntersectionObserver(([entry]) => {
        if (entry.isIntersecting) { const p = video.play(); if (p) p.catch(() => {}); }
        else video.pause();
      }, { threshold: 0.3 }).observe(video);
    }

    return;
  }

  section.classList.add('film--scrub');

  /* ------------------------------------------------------------- readiness */

  // Priming the decoder: a video that has never played will not seek promptly
  // in Chrome. Muted playback needs no user gesture, so start and immediately
  // stop — after this, currentTime assignment paints straight away.
  let primed = false;

  const prime = () => {
    if (primed) return;
    primed = true;
    const p = video.play();
    if (p && p.then) p.then(() => video.pause()).catch(() => { /* seeking still works */ });
    else video.pause();
  };

  if (video.readyState >= 2) prime();
  else video.addEventListener('loadeddata', prime, { once: true });

  /* ------------------------------------------------------------- the scrub */

  let duration = parseFloat(section.dataset.filmDuration) || 0;
  video.addEventListener('loadedmetadata', () => {
    if (!isFinite(video.duration) || video.duration <= 0) return;
    duration = video.duration;
    curve = null;   // the dwell curve is built from duration; rebuild it
  });

  // fastSeek skips the exact-frame search. With an all-intra source the nearest
  // keyframe IS the frame asked for, so it is free accuracy. Chrome has no
  // implementation, hence the fallback.
  const seek = typeof video.fastSeek === 'function'
    ? (t) => video.fastSeek(t)
    : (t) => { video.currentTime = t; };

  let targetTime  = 0;
  let currentTime = 0;
  let running     = false;
  let visible     = true;

  /* ----------------------------------------------------- the scroll → time curve
   *
   * A straight linear mapping runs every card past the reader at the same
   * speed, which makes the film feel like it is fleeing and leaves no still
   * moment to aim at the button. So the curve alternates: travel between
   * chapters, then park on each one for a stretch of scroll where the frame
   * holds and the button stops moving.
   */

  const HOLD = 1.4;   // "seconds" of scroll spent parked on a chapter
  let curve = null;

  function buildCurve() {
    const stops = [];
    let prev = 0;

    for (const chapter of chapters) {
      if (chapter.at > prev) stops.push({ w: chapter.at - prev, from: prev, to: chapter.at });
      stops.push({ w: HOLD, from: chapter.at, to: chapter.at });   // the dwell
      prev = chapter.at;
    }
    if (duration > prev) stops.push({ w: duration - prev, from: prev, to: duration });

    curve = { stops, total: stops.reduce((sum, s) => sum + s.w, 0) };
  }

  function timeAt(p) {
    if (chapters.length === 0) return p * duration;
    if (!curve) buildCurve();

    const want = p * curve.total;
    let acc = 0;

    for (const s of curve.stops) {
      if (want <= acc + s.w) {
        return s.from + (s.to - s.from) * (s.w === 0 ? 0 : (want - acc) / s.w);
      }
      acc += s.w;
    }

    return duration;
  }

  function progress() {
    const rect  = section.getBoundingClientRect();
    const range = rect.height - window.innerHeight;

    return range <= 0 ? 0 : clamp(-rect.top / range, 0, 1);
  }

  function frame() {
    if (!running) return;
    requestAnimationFrame(frame);
    if (!visible || duration <= 0) return;

    // Ease toward the scroll target. 0.14 lands in about a fifth of a second —
    // enough to smooth a flick of the wheel, short enough that the film still
    // feels attached to the scrollbar rather than trailing it.
    currentTime += (targetTime - currentTime) * 0.14;

    // A 30fps source gains nothing from more than one seek per frame interval,
    // and seeking while a seek is in flight queues work the decoder discards.
    if (!video.seeking && Math.abs(video.currentTime - currentTime) > 1 / 40) {
      seek(clamp(currentTime, 0, duration - 0.02));
    }

    setActive(currentTime);
  }

  function onScroll() {
    targetTime = timeAt(progress());
  }

  window.addEventListener('scroll', onScroll, { passive: true });
  window.addEventListener('resize', onScroll);

  if ('IntersectionObserver' in window) {
    new IntersectionObserver(([entry]) => {
      visible = entry.isIntersecting;
      if (visible && !running) { running = true; requestAnimationFrame(frame); }
      if (!visible) running = false;
    }, { threshold: 0 }).observe(section);
  } else {
    running = true;
    requestAnimationFrame(frame);
  }

  onScroll();
  // Start on the right frame rather than easing up from zero on first paint.
  currentTime = targetTime;
})();
