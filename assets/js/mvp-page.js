/**
 * The MVP Development page's own three behaviours.
 *
 *  1. The folder cards in the industries section.
 *  2. The wheel timeline in the process section.
 *  3. The sticky spiral in the "why choose us" section.
 *
 * Three of those are Framer marketplace components the page cannot run: Card —
 * Folder is $6, Wheel Timeline $14 and Sticky Spiral Steps $1, and a paid
 * listing publishes no module. Built here from their own published descriptions
 * instead, the same way the polaroid gallery on the AI Development page was —
 * see the notes on each below for what the description actually says.
 *
 * All three degrade to nothing: with this file absent every folder shows its
 * content, the wheel becomes a plain list of six steps, and the spiral becomes
 * an ordinary grid of six.
 */

(function () {
  'use strict';

  const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  /* The hexagon field that used to live here is gone. The site already draws
     one on every page from assets/js/hexbg.js — this page was painting an
     opaque background over it and then drawing a second, broken copy: a
     <canvas> is a replaced element, so inset:0 with width:auto left it at its
     intrinsic 300x150 in the top-left corner. */

  /* ======================================================================
     1. Folder cards
     ======================================================================

     After Framer's "Card — Folder" ($6, no published module). Its own
     description is the spec: "Modern, clean, folder-style cards… WOW effect,
     smooth hover animation, an engaging user experience", filed under
     "Encouraging to click".

     So: a folder with a tab, a picture sitting inside it, and a front flap
     that falls forward on hover to show what is in there. Clicking latches it
     open and reveals the rest of the copy. The CSS does the animation; this
     only holds which folders are open.
     ====================================================================== */

  const folders = Array.from(document.querySelectorAll('[data-folder]'));

  if (folders.length) {
    folders.forEach((f) => {
      const toggle = () => {
        const open = f.classList.toggle('is-open');
        f.setAttribute('aria-expanded', open ? 'true' : 'false');
      };

      f.addEventListener('click', toggle);
      f.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); toggle(); }
      });
    });

    /* Only now do the flaps start closed — without the script every folder is
       already open, which is what a reader with no JavaScript should get. */
    document.querySelector('[data-folders]')?.classList.add('is-live');
  }

  /* ======================================================================
     2. The wheel timeline
     ======================================================================

     After Framer's "Wheel Timeline" ($14, no published module), described as
     an "interactive wheel timeline dial… a premium rotary timeline component
     with Apple-inspired aesthetics".

     So: a dial carrying the six steps, which you turn — by dragging it, by
     clicking a marker, with the arrow keys, or with the two buttons. Whichever
     step reaches the top is the one whose card is shown.

     The ring rotates by `--ring`; every marker counter-rotates by the same
     amount so its number stays upright while the wheel moves under it.
     ====================================================================== */

  const wheel = document.querySelector('[data-wheel]');

  if (wheel) {
    const ring    = wheel.querySelector('[data-ring]');
    const marks   = Array.from(wheel.querySelectorAll('[data-mark]'));
    const cards   = Array.from(wheel.querySelectorAll('[data-wheelcard]'));
    const readout = wheel.querySelector('[data-wheel-readout]');
    const n = marks.length;
    const STEP = 360 / n;

    let active = 0;
    let dragging = false;
    let startAngle = 0;
    let startRing = 0;

    /** Where the pointer is, as an angle about the dial's centre. */
    function angleAt(e) {
      const r = ring.getBoundingClientRect();
      return Math.atan2(e.clientY - (r.top + r.height / 2),
                        e.clientX - (r.left + r.width / 2)) * 180 / Math.PI;
    }

    function show(i, spin) {
      active = ((i % n) + n) % n;

      /* The shortest way round, so stepping from 6 back to 1 turns one notch
         rather than five. */
      const current = parseFloat(ring.style.getPropertyValue('--ring')) || 0;
      const want = -active * STEP;
      const delta = ((want - current + 540) % 360) - 180;
      ring.style.setProperty('--ring', (spin === false ? want : current + delta).toFixed(2) + 'deg');

      marks.forEach((m, k) => {
        m.setAttribute('aria-selected', k === active ? 'true' : 'false');
        m.tabIndex = k === active ? 0 : -1;
      });
      cards.forEach((c, k) => c.classList.toggle('is-open', k === active));
      if (readout) readout.textContent = String(active + 1).padStart(2, '0');
    }

    marks.forEach((m, i) => {
      m.addEventListener('click', (e) => { e.stopPropagation(); show(i); });
      m.addEventListener('keydown', (e) => {
        const d = e.key === 'ArrowRight' || e.key === 'ArrowDown' ? 1
          : e.key === 'ArrowLeft' || e.key === 'ArrowUp' ? -1 : 0;
        if (!d) return;
        e.preventDefault();
        show(active + d);
        marks[active].focus();
      });
    });

    wheel.querySelector('[data-wheel-prev]')?.addEventListener('click', () => show(active - 1));
    wheel.querySelector('[data-wheel-next]')?.addEventListener('click', () => show(active + 1));

    /* Drag the dial round. On release it snaps to whichever marker is nearest
       the top, which is what makes it feel like a detent rather than a free
       spinner. */
    ring.addEventListener('pointerdown', (e) => {
      /* A marker handles its own click. Without this the same press also
         started a drag, and the release snapped the wheel back over whatever
         the marker had just selected. */
      if (e.target.closest('[data-mark]')) return;

      dragging = true;
      startAngle = angleAt(e);
      startRing = parseFloat(ring.style.getPropertyValue('--ring')) || 0;
      ring.setPointerCapture(e.pointerId);
      ring.classList.add('is-dragging');
    });

    ring.addEventListener('pointermove', (e) => {
      if (!dragging) return;
      const turned = startRing + (angleAt(e) - startAngle);
      ring.style.setProperty('--ring', turned.toFixed(2) + 'deg');
    });

    function release() {
      if (!dragging) return;
      dragging = false;
      ring.classList.remove('is-dragging');
      const turned = parseFloat(ring.style.getPropertyValue('--ring')) || 0;
      show(Math.round(-turned / STEP));
    }

    ring.addEventListener('pointerup', release);
    ring.addEventListener('pointercancel', release);

    wheel.classList.add('is-live');
    show(0, false);
  }


  /* ======================================================================
     3. The sticky spiral
     ======================================================================

     After Framer's "Sticky Spiral Steps" ($1, no published module) — built
     from its live demo at stickyspiral.framer.website rather than from the
     listing's one-line description, because "an animated spiral" does not say
     what it is and the first attempt at it, a flat 2D spiral, was nothing like
     the real thing.

     Measured off that demo: every card transform is a multiple of 45 degrees
     about Y under transform-style: preserve-3d. The cards are on a helix, and
     scroll turns the whole helix so each one swings to the front in turn.

     All this does is convert scroll into --a, "how far along the helix we
     are", in steps. The CSS does the rest.

     Progress is sampled per frame while the section is on screen, never on the
     scroll event: the last event of a gesture measures a rect the browser has
     not settled, and with nothing after it to correct the reading the helix
     stops short of the final card. Same lesson the mobile page's roadmap
     already learned.
     ====================================================================== */

  const spiral = document.querySelector('[data-spiral]');

  if (spiral && !reduced && window.matchMedia('(min-width: 901px)').matches) {
    const track = spiral.querySelector('[data-helix-track]');
    const helix = spiral.querySelector('[data-helix]');
    const cards = Array.from(spiral.querySelectorAll('[data-helix-card]'));
    const bar   = spiral.querySelector('[data-helix-bar]');
    const label = spiral.querySelector('[data-helix-label]');
    const n = cards.length;

    let raf = 0;
    let onScreen = false;
    let last = -1;

    function paint(p) {
      /* 0 puts card one at the front, 1 puts the last one there. */
      const a = p * (n - 1);
      helix.style.setProperty('--a', a.toFixed(4));

      const front = Math.round(a);
      cards.forEach((c, i) => c.classList.toggle('is-front', i === front));

      if (bar) bar.style.width = Math.round(p * 100) + '%';
      if (label) label.textContent = String(front + 1).padStart(2, '0') + ' / ' + String(n).padStart(2, '0');
    }

    function frame() {
      raf = requestAnimationFrame(frame);
      if (!onScreen) return;

      const r = track.getBoundingClientRect();
      const range = r.height - window.innerHeight;
      const p = range <= 0 ? 0 : Math.max(0, Math.min(1, -r.top / range));

      if (Math.abs(p - last) < 0.0004) return;
      last = p;
      paint(p);
    }

    if ('IntersectionObserver' in window) {
      new IntersectionObserver(([e]) => { onScreen = e.isIntersecting; }, { threshold: 0 })
        .observe(track);
    } else {
      onScreen = true;
    }

    raf = requestAnimationFrame(frame);
    spiral.classList.add('is-live');
    paint(0);
  }
})();
