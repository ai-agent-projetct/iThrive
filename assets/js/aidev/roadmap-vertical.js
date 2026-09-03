/**
 * The vertical roadmap — the mobile page's ProcessRoadmap, stood upright.
 *
 * Same three jobs as the original:
 *   1. Turn the section's scroll position into one number, 0 to 1.
 *   2. Lay the tarmac to that number and put the traveller on it.
 *   3. Light each stop as the traveller reaches it, and let it recede after.
 *
 * Two things are carried over deliberately because the original learned them
 * the hard way:
 *
 *  - Progress is sampled EVERY FRAME while the section is on screen, never on
 *    the scroll event. The last scroll event of a gesture measures a rect the
 *    browser has not finished settling, and since no further event fires there
 *    is nothing left to correct it — the road stops short of the end and the
 *    final stops never light. A per-frame sample cannot go stale.
 *  - The smoothing lives in CSS transitions on the road and the traveller, not
 *    in an eased follower here. A follower in its own loop drifts behind the
 *    scrollbar and stalls, which strands the last stop.
 *
 * What is new is the search: each stop knows its point on the road (the markup
 * carries it) but not its distance along it, and that distance is what decides
 * when it lights. Binary search on the path, once, at startup.
 */

(function () {
  'use strict';

  const section = document.querySelector('[data-vroad]');
  if (!section) return;

  const scene     = section.querySelector('[data-vroad-scene]');
  const road      = section.querySelector('[data-vroad-path]');
  const dashes    = section.querySelector('[data-vroad-dashes]');
  const traveller = section.querySelector('[data-vroad-traveller]');
  const bar       = section.querySelector('.vroad-progress span');
  const stops     = Array.from(section.querySelectorAll('[data-vroad-stop]'));
  const stems     = Array.from(section.querySelectorAll('[data-vroad-stem]'));
  if (!scene || !road || !stops.length) return;

  /* The scene's own coordinate space, straight off the SVG. */
  const box = road.ownerSVGElement.viewBox.baseVal;
  const W = box.width;
  const H = box.height;

  const len = road.getTotalLength();
  if (!len) return;

  const clamp = (v, a, b) => (v < a ? a : v > b ? b : v);

  /**
   * How far along the road a point sits, as a fraction of its length.
   *
   * The road descends monotonically, so a plain bisection on y converges — no
   * need for a nearest-point solver. 24 halvings puts it inside a pixel.
   */
  function distanceOf(y) {
    let lo = 0;
    let hi = len;

    for (let i = 0; i < 24; i++) {
      const mid = (lo + hi) / 2;
      if (road.getPointAtLength(mid).y < y) lo = mid; else hi = mid;
    }

    return ((lo + hi) / 2) / len;
  }

  /* Each stop's arrival point on the road, found rather than hand-timed. */
  const at = stops.map((s) => distanceOf(parseFloat(s.dataset.y)));

  /* Someone who asked for less motion gets the finished road and every card
     up — the content, without the ride. */
  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    paint(1);
    section.classList.add('is-static');
    return;
  }

  road.style.strokeDasharray = len;
  dashes.style.strokeDasharray = '18 22';

  function paint(p) {
    road.style.strokeDashoffset = len * (1 - p);
    dashes.style.strokeDashoffset = -p * len * 0.6;

    if (bar) bar.style.width = Math.round(p * 100) + '%';

    const t = road.getPointAtLength(Math.max(0.004, p) * len);
    traveller.style.left = (t.x / W * 100) + '%';
    traveller.style.top  = (t.y / H * 100) + '%';
    traveller.classList.add('is-riding');

    for (let i = 0; i < stops.length; i++) {
      /* Live a touch before the traveller physically arrives, so the card is
         readable by the time it is passed rather than after. */
      const live = p >= at[i] - 0.02;
      stops[i].classList.toggle('is-live', live);
      stops[i].classList.toggle('is-passed', p > at[i] + 0.11);

      const stem = stems[i];
      if (stem) stem.setAttribute('x2', live ? stem.dataset.x2 : stem.getAttribute('x1'));
    }
  }

  let raf = 0;
  let onScreen = true;
  let last = -1;

  function frame() {
    raf = requestAnimationFrame(frame);
    if (!onScreen) return;

    const r = section.getBoundingClientRect();
    const range = r.height - window.innerHeight;
    const p = range <= 0 ? 0 : clamp(-r.top / range, 0, 1);

    if (Math.abs(p - last) < 0.0004) return;
    last = p;
    paint(p);
  }

  if ('IntersectionObserver' in window) {
    new IntersectionObserver(([e]) => { onScreen = e.isIntersecting; }, { threshold: 0 })
      .observe(section);
  }

  raf = requestAnimationFrame(frame);
  section.classList.add('is-live');
})();
