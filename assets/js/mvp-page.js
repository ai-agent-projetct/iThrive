/**
 * The MVP Development page's own three behaviours.
 *
 *  1. The reactive hexagon field behind the page.
 *  2. The folder cards in the industries section.
 *  3. The wheel timeline in the process section.
 *  4. The sticky spiral in the "why choose us" section.
 *
 * Three of those are Framer marketplace components the page cannot run: Card —
 * Folder is $6, Wheel Timeline $14 and Sticky Spiral Steps $1, and a paid
 * listing publishes no module. Built here from their own published descriptions
 * instead, the same way the polaroid gallery on the AI Development page was —
 * see the notes on each below for what the description actually says.
 *
 * All four degrade to nothing: with this file absent the page keeps its
 * ordinary background, every folder shows its content, the wheel becomes a
 * plain list of six steps, and the spiral becomes an ordinary grid of six.
 */

(function () {
  'use strict';

  const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  /* ======================================================================
     1. The hexagon field
     ======================================================================

     After the mobile app page's HexagonGridBg, which this site already runs:
     a honeycomb that lights around the pointer, its colour taken from where
     the pointer sits across the width — cyan at the left edge, through blue,
     to violet at the right. Same seven stops, so the two pages agree.
     ====================================================================== */

  const canvas = document.querySelector('[data-mvp-hex]');

  if (canvas && !reduced) {
    const ctx = canvas.getContext('2d');

    const STOPS = [
      [0, 242, 254], [0, 190, 255], [78, 168, 255], [90, 130, 245],
      [120, 100, 235], [157, 78, 221], [190, 90, 230],
    ];

    const RADIUS = 26;
    /* Reach and alpha were both raised: at 210px and 0.16 the field was there
       but nobody could see it through the sections sitting over it. The
       sections are translucent now and this is bright enough to read through
       them. */
    const REACH = 300;
    const W = Math.sqrt(3) * RADIUS;
    const H = 1.5 * RADIUS;

    let w = 0;
    let h = 0;
    let mx = -9999;
    let my = -9999;
    let raf = 0;

    function size() {
      const dpr = Math.min(2, window.devicePixelRatio || 1);
      w = canvas.clientWidth;
      h = canvas.clientHeight;
      canvas.width = Math.round(w * dpr);
      canvas.height = Math.round(h * dpr);
      ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
    }

    function zone(ratio) {
      const t = Math.max(0, Math.min(1, ratio)) * (STOPS.length - 1);
      const i = Math.floor(t);
      const j = Math.min(STOPS.length - 1, i + 1);
      const f = t - i;
      const a = STOPS[i];
      const b = STOPS[j];

      return [
        Math.round(a[0] + (b[0] - a[0]) * f),
        Math.round(a[1] + (b[1] - a[1]) * f),
        Math.round(a[2] + (b[2] - a[2]) * f),
      ].join(', ');
    }

    function hexPath(x, y) {
      ctx.beginPath();
      for (let i = 0; i < 6; i++) {
        const a = (Math.PI / 3) * i - Math.PI / 6;
        const hx = x + RADIUS * Math.cos(a);
        const hy = y + RADIUS * Math.sin(a);
        if (i === 0) ctx.moveTo(hx, hy); else ctx.lineTo(hx, hy);
      }
      ctx.closePath();
    }

    function frame() {
      raf = 0;
      ctx.clearRect(0, 0, w, h);

      const rgb = zone(mx / Math.max(1, w));
      const cols = Math.ceil(w / W) + 2;
      const rows = Math.ceil(h / H) + 2;

      for (let r = -1; r < rows; r++) {
        for (let c = -1; c < cols; c++) {
          const x = c * W + (r % 2 ? W / 2 : 0);
          const y = r * H;

          const dx = mx - x;
          const dy = my - y;
          const d = Math.sqrt(dx * dx + dy * dy);
          if (d > REACH) continue;      // unlit cells are never drawn

          const lit = Math.pow(1 - d / REACH, 1.4);
          hexPath(x, y);
          ctx.fillStyle = `rgba(${rgb}, ${(lit * 0.30).toFixed(3)})`;
          ctx.fill();
          ctx.strokeStyle = `rgba(${rgb}, ${(lit * 0.95).toFixed(3)})`;
          ctx.lineWidth = 1.6;
          ctx.stroke();
        }
      }
    }

    /* Only the cells near the pointer, and only when it has moved: a
       full-screen honeycomb redrawn every frame was 6,000 paths a frame for a
       decoration nobody is looking at. */
    const schedule = () => { if (!raf) raf = requestAnimationFrame(frame); };

    window.addEventListener('pointermove', (e) => {
      mx = e.clientX;
      my = e.clientY;
      schedule();
    }, { passive: true });

    window.addEventListener('pointerleave', () => { mx = my = -9999; schedule(); }, { passive: true });
    window.addEventListener('resize', () => { size(); schedule(); }, { passive: true });

    size();
    canvas.classList.add('is-live');
  }

  /* ======================================================================
     2. Folder cards
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
     3. The wheel timeline
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
     4. The sticky spiral
     ======================================================================

     After Framer's "Sticky Spiral Steps" ($1, no published module). Its
     description is the whole spec: "Show your process as an animated spiral.
     It sticks in place while people scroll, and each step pops in one by one."

     So: the stage sticks for the length of a tall track, and the section's own
     scroll progress decides how many of the six have landed. The line draws
     with it, and the hub in the eye of the spiral carries whichever step
     arrived last.

     Progress is sampled per frame while the section is on screen, never on the
     scroll event — the last event of a gesture measures a rect the browser has
     not finished settling, and with nothing after it to correct the reading the
     final step never lands. That is the same lesson the roadmap on the mobile
     page already learned.
     ====================================================================== */

  const spiral = document.querySelector('[data-spiral]');

  if (spiral && !reduced && window.matchMedia('(min-width: 901px)').matches) {
    const track = spiral.querySelector('[data-spiral-track]');
    const cards = Array.from(spiral.querySelectorAll('[data-spiral-card]'));
    const line  = spiral.querySelector('[data-spiral-line]');
    const hubN  = spiral.querySelector('[data-spiral-hub-n]');
    const hubT  = spiral.querySelector('[data-spiral-hub-t]');
    const hubB  = spiral.querySelector('[data-spiral-hub-b]');
    const bar   = spiral.querySelector('[data-spiral-prog]');
    const n = cards.length;

    const len = line ? line.getTotalLength() : 0;
    if (line && len) {
      line.style.strokeDasharray = len;
      line.style.strokeDashoffset = len;
    }

    let raf = 0;
    let onScreen = false;
    let last = -1;

    function paint(p) {
      /* Each card owns a slice of the scroll and pops when it is reached. The
         0.06 lead means a card is already arriving as its slice opens rather
         than appearing exactly on the boundary. */
      let current = -1;
      for (let i = 0; i < n; i++) {
        const at = (i + 0.5) / n;
        const inYet = p >= at - 0.06;
        cards[i].classList.toggle('is-in', inYet);
        if (inYet) current = i;
      }

      cards.forEach((c, i) => c.classList.toggle('is-current', i === current));

      if (line && len) line.style.strokeDashoffset = len * (1 - Math.min(1, p * 1.12));
      if (bar) bar.style.width = Math.round(Math.min(1, p) * 100) + '%';

      if (current >= 0 && hubN) {
        const c = cards[current];
        hubN.textContent = c.dataset.n;
        hubT.textContent = c.dataset.title;
        hubB.textContent = c.dataset.body;
      }
    }

    function frame() {
      raf = requestAnimationFrame(frame);
      if (!onScreen) return;

      const r = track.getBoundingClientRect();
      const range = r.height - window.innerHeight;
      const p = range <= 0 ? 0 : Math.max(0, Math.min(1, -r.top / range));

      if (Math.abs(p - last) < 0.0006) return;
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
