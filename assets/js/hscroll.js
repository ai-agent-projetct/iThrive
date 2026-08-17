/**
 * Horizontal scroll section — the way 2025.unseen.co moves.
 *
 * Measured rather than guessed: that site's <main> is
 * `scroll-container--horizontal` with a scrollWidth of 61,513 against a 1,600
 * viewport, and the document itself does not scroll at all (body scrollHeight
 * equals the viewport). Vertical wheel input is mapped to horizontal travel and
 * smoothed, so the whole site reads as one long sideways filmstrip. Unlike
 * their /projects/ page, the content is real DOM — actual <img> elements, not a
 * WebGL texture.
 *
 * Applied to one section rather than the whole site, the equivalent is a pinned
 * stage: the section is taller than the viewport, it sticks while you scroll
 * through it, and that scroll progress drives the track sideways. You scroll
 * down, the cards slide left, and the page carries on normally afterwards.
 *
 * The travel is eased toward its target rather than set from scroll position
 * directly. That is what produces the glide — jumping the transform to the
 * exact scroll offset every frame gives motion that stops dead with the wheel,
 * which is the tell of a cheap version of this.
 *
 * Touch and reduced-motion get a plain swipeable overflow strip instead: on a
 * phone this pinning fights the native scroll, and it is motion nobody asked
 * for.
 */

(function () {
  'use strict';

  const sections = Array.from(document.querySelectorAll('[data-hscroll]'));
  if (!sections.length) return;

  const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  const coarse = window.matchMedia('(pointer: coarse)').matches;

  sections.forEach((section) => {
    const track = section.querySelector('[data-hscroll-track]');
    const bar = section.querySelector('[data-hscroll-bar]');
    if (!track) return;

    if (reduce || coarse) {
      section.classList.add('hscroll--inline');

      return;
    }

    section.classList.add('hscroll--live');

    let travel = 0;      // how far the track can move, in px
    let current = 0;     // eased position
    let target = 0;
    let onScreen = false;

    /**
     * The section's height is what the visitor spends to cross the track, so it
     * is derived from the track's own overflow rather than a fixed multiple.
     * A hard-coded 300vh either runs out before the last card or leaves dead
     * scroll after it, depending on how many cards there are.
     */
    function measure() {
      travel = Math.max(0, track.scrollWidth - window.innerWidth);
      section.style.setProperty('--hscroll-height', (travel + window.innerHeight) + 'px');
    }

    function frame() {
      requestAnimationFrame(frame);
      if (!onScreen || travel <= 0) return;

      const rect = section.getBoundingClientRect();
      const range = rect.height - window.innerHeight;
      const progress = range <= 0 ? 0 : Math.min(1, Math.max(0, -rect.top / range));

      target = progress * travel;
      current += (target - current) * 0.09;
      if (Math.abs(target - current) < 0.4) current = target;

      track.style.transform = 'translate3d(' + (-current).toFixed(2) + 'px,0,0)';
      if (bar) bar.style.transform = 'scaleX(' + (travel ? current / travel : 0).toFixed(4) + ')';
    }

    if ('IntersectionObserver' in window) {
      new IntersectionObserver(([e]) => { onScreen = e.isIntersecting; }, { threshold: 0 }).observe(section);
    } else {
      onScreen = true;
    }

    // Re-measure when the images arrive: the track's width is the sum of the
    // cards, and before the shots load that is the wrong number.
    window.addEventListener('resize', measure);
    window.addEventListener('load', measure);
    track.querySelectorAll('img').forEach((img) => {
      if (!img.complete) img.addEventListener('load', measure, { once: true });
    });

    /**
     * Clips load and play only where they are wanted.
     *
     * Eight full-screen captures is far more than anyone scrolls through, so
     * nothing is fetched until its panel is near the viewport, and playback
     * stops the moment it leaves. Without this the section costs sixteen
     * megabytes on load to show two panels.
     */
    const vids = Array.from(section.querySelectorAll('[data-hpanel-video]'));
    if (vids.length && 'IntersectionObserver' in window) {
      const io = new IntersectionObserver((entries) => {
        entries.forEach((e) => {
          const v = e.target;
          if (e.isIntersecting) {
            if (!v.src && v.dataset.src) v.src = v.dataset.src;
            const play = v.play();
            if (play && play.catch) play.catch(() => {});
          } else {
            v.pause();
          }
        });
      }, { root: section.querySelector('.hscroll-stage'), rootMargin: '100% 0px', threshold: 0 });
      vids.forEach((v) => io.observe(v));
    }

    measure();
    requestAnimationFrame(frame);
  });
})();
