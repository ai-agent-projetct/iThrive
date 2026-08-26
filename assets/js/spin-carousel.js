/**
 * Spin Carousel — a port of Origin Kit's component.
 *
 * A ring of cards rotating around a hidden hub, with drag momentum, wheel
 * scroll, and click-to-front snapping. Built to the component's documented
 * behaviour:
 *
 *   - Cards share one hub and lose scale, opacity and brightness in proportion
 *     to their angular distance from the front.
 *   - Releasing a drag projects the pointer's velocity forward, then snaps to
 *     the nearest card slot.
 *   - Pointer capture keeps a drag alive off the element; travel under 6px
 *     counts as a click and centres that card.
 *   - The source list repeats until at least ten cards fill the ring, so a
 *     short set still reads as a wheel.
 *   - Wheel scrolling spins freely and settles 150ms later.
 *
 * Props map to data attributes with the component's defaults: speed 100,
 * scale 64, aspect 136, rounded 24.
 *
 * One deliberate difference, the same one this repo made for Round Carousel:
 * the faces are real markup — a heading, a sentence, a list — not background
 * images. This is a page that has to rank, and ten divs painted with
 * background-image are ten empty boxes to a crawler.
 */

(function () {
  'use strict';

  const num = (el, key, fallback) => {
    const v = parseFloat(el.dataset[key]);

    return Number.isFinite(v) ? v : fallback;
  };

  document.querySelectorAll('[data-spin-carousel]').forEach((stage) => {
    if (stage.dataset.spinReady) return;
    stage.dataset.spinReady = '1';

    const ring = stage.querySelector('[data-spin-ring]');
    const sources = Array.from(stage.querySelectorAll('[data-spin-item]'));
    if (!ring || !sources.length) return;

    /* ---- props ---------------------------------------------------------- */

    const speed = num(stage, 'speed', 100);
    const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    /*
     * The ring repeats the source list until it holds at least ten cards, which
     * is the component's own rule: four case studies laid round a wheel leaves
     * three quarters of it empty and stops reading as a wheel at all.
     */
    const MIN = 10;
    const items = [];
    while (items.length < MIN) {
      for (const src of sources) {
        items.push(src);
        if (items.length >= MIN * 2) break;
      }
      if (items.length >= MIN && items.length % sources.length === 0) break;
    }

    // Clones fill the ring out; they are hidden from assistive technology
    // because they are the same cards a second and third time.
    const cards = items.map((src, i) => {
      if (i < sources.length) return src;
      const clone = src.cloneNode(true);
      clone.setAttribute('aria-hidden', 'true');
      clone.querySelectorAll('a, button').forEach((el) => el.setAttribute('tabindex', '-1'));
      clone.style.setProperty('--i', String(i));
      ring.appendChild(clone);

      return clone;
    });

    const count = cards.length;
    const step = 360 / count;

    /* ---- geometry ------------------------------------------------------- */

    let radius = 0;

    function measure() {
      const w = cards[0].offsetWidth || 300;
      // Far enough out that neighbours do not overlap at this card count.
      radius = (w * 1.08) / (2 * Math.tan(Math.PI / count));
      ring.style.setProperty('--spin-r', radius.toFixed(1) + 'px');
      // The per-card angle is CSS, so the count has to reach it.
      stage.style.setProperty('--spin-n', String(count));
    }
    measure();
    window.addEventListener('resize', measure);
    if ('ResizeObserver' in window) new ResizeObserver(measure).observe(stage);

    /* ---- state ---------------------------------------------------------- */

    let rot = 0, vel = 0, raf = 0, last = 0;
    let dragging = false, lastX = 0, moved = 0, captured = false, pointerId = null;
    let snapping = false, snapTo = 0;
    let wheelTimer = 0, onScreen = true, paused = false;

    function apply() {
      ring.style.transform = 'translateZ(' + (-radius) + 'px) rotateY(' + rot + 'deg)';

      // Scale, opacity and brightness by angular distance from the front.
      for (let i = 0; i < count; i++) {
        let a = ((i * step + rot) % 360 + 360) % 360;
        if (a > 180) a -= 360;
        const away = Math.abs(a) / 180;                 // 0 at the front, 1 at the back
        const card = cards[i];
        card.style.setProperty('--away', away.toFixed(3));
        card.style.zIndex = String(1000 - Math.round(away * 1000));
      }
    }

    function nearestSlot() {
      return -Math.round(rot / step) * step * -1;
    }

    function snap() {
      snapping = true;
      snapTo = Math.round(rot / step) * step;
    }

    /* ---- drag ----------------------------------------------------------- */

    stage.addEventListener('pointerdown', (e) => {
      dragging = true;
      snapping = false;
      lastX = e.clientX;
      moved = 0;
      captured = false;
      pointerId = e.pointerId;
      vel = 0;
      stage.classList.add('is-grabbing');
    });

    stage.addEventListener('pointermove', (e) => {
      if (!dragging) return;
      const dx = e.clientX - lastX;
      lastX = e.clientX;
      moved += Math.abs(dx);

      /*
       * Capture is taken on the first real movement, not on pointerdown.
       * Capturing immediately retargets the click that follows to the stage, so
       * a plain click on a card never reaches it — the same trap this repo hit
       * with Round Carousel.
       */
      if (!captured && moved > 6) {
        captured = true;
        stage.setPointerCapture?.(pointerId);
      }

      rot += dx * 0.22;
      vel = dx * 0.22 * 60;
      apply();
    });

    function release() {
      if (!dragging) return;
      dragging = false;
      if (captured) {
        stage.releasePointerCapture?.(pointerId);
        captured = false;
      }
      stage.classList.remove('is-grabbing');
      // Velocity carries on, then the ring settles on a slot.
      if (Math.abs(vel) < 12) snap();
    }
    stage.addEventListener('pointerup', release);
    stage.addEventListener('pointercancel', release);

    // Travel under 6px is a click: bring that card to the front.
    stage.addEventListener('click', (e) => {
      if (moved > 6) { e.preventDefault(); e.stopPropagation(); return; }
      const card = e.target.closest('[data-spin-item]');
      if (!card) return;
      const i = cards.indexOf(card);
      if (i < 0) return;
      // Turn the short way round to put slot i at the front.
      let want = -i * step;
      while (want - rot > 180) want -= 360;
      while (want - rot < -180) want += 360;
      snapping = true;
      snapTo = want;
    }, true);

    /* ---- wheel ---------------------------------------------------------- */

    stage.addEventListener('wheel', (e) => {
      if (!e.deltaY) return;
      snapping = false;
      vel += e.deltaY * 0.5;
      clearTimeout(wheelTimer);
      // Spins freely, then settles a moment after the wheel stops.
      wheelTimer = setTimeout(snap, 150);
    }, { passive: true });

    /* ---- hold while being read ------------------------------------------ */

    stage.addEventListener('pointerenter', () => { paused = true; });
    stage.addEventListener('pointerleave', () => { paused = false; });
    stage.addEventListener('focusin', () => { paused = true; });
    stage.addEventListener('focusout', () => { paused = false; });

    if ('IntersectionObserver' in window) {
      new IntersectionObserver(([e]) => { onScreen = e.isIntersecting; }, { threshold: 0 }).observe(stage);
    }

    /* ---- loop ------------------------------------------------------------ */

    function frame(now) {
      raf = requestAnimationFrame(frame);
      if (!onScreen) { last = now; return; }

      const dt = last ? Math.min((now - last) / 1000, 0.1) : 0;
      last = now;

      if (!dragging) {
        if (snapping) {
          rot += (snapTo - rot) * 0.12;
          if (Math.abs(snapTo - rot) < 0.05) { rot = snapTo; snapping = false; }
        } else if (Math.abs(vel) > 0.4) {
          rot += vel * dt;
          vel *= 0.94;
          if (Math.abs(vel) <= 0.4) snap();
        } else if (!paused && !reduce && speed) {
          rot += speed * 0.06 * dt * 60 / 6;
        }
        apply();
      }
    }

    apply();
    raf = requestAnimationFrame(frame);
    stage.classList.add('spin--live');
  });
})();
