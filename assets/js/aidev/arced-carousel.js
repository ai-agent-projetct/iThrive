/**
 * The arced focus carousel — the stack's six layers on a circle.
 *
 * After arcedfocuscarousel.framer.website. That is a published Framer site, not
 * a marketplace component, so there is no module to run; every constant below
 * was measured off the live page in Chrome at 1440x900 rather than eyeballed.
 * See the note in includes/components/aidev/ecosystem.php for the readings.
 *
 * The whole thing is four numbers per card, all derived from one integer: how
 * many places it sits from the focus.
 *
 *   angle   d * 23.5 degrees
 *   place   (R sin angle, R (1 - cos angle)) — a point on a circle whose top is
 *           the focus position, so cards fall away and outward together
 *   turn    the same angle again, so each card lies tangent to the arc
 *   size    1.5 at the focus, 0.94 one out, 0.80 beyond — measured, not a curve
 *
 * Six cards cannot sit symmetrically on a symmetric arc, so the wrap puts three
 * on the left and two on the right; the extra one is on the left, where layers
 * already passed belong.
 *
 * Everything is CSS transitions from there. There is no animation loop: a click
 * sets one index, the transforms are rewritten once, and the browser tweens
 * them. That is also why it survives a resize — the radius is read from the
 * stage each time it lays out.
 */

(function () {
  'use strict';

  const stage = document.querySelector('[data-arced]');
  if (!stage) return;

  const cards  = Array.from(stage.querySelectorAll('[data-arced-card]'));
  const panels = Array.from(stage.querySelectorAll('[data-arced-panel]'));
  const dots   = Array.from(stage.querySelectorAll('[data-arced-dot]'));
  if (cards.length < 2) return;

  const N    = cards.length;
  const HALF = Math.floor(N / 2);

  /* Measured off the reference. */
  const STEP    = 23.5;   // degrees between neighbours
  const RADIUS  = 0.46;   // of the stage's width
  const SCALES  = [1.5, 0.94, 0.80];                 // by distance, last repeats
  const FADES   = [1, 0.764, 0.668, 0.65];           // ditto

  const pick = (arr, d) => arr[Math.min(d, arr.length - 1)];

  let focus = 0;

  /** Signed distance from the focus, wrapped so the fan stays a fan. */
  function offset(i) {
    return ((i - focus + N + HALF) % N) - HALF;
  }

  function layout() {
    const R = stage.clientWidth * RADIUS;

    for (let i = 0; i < N; i++) {
      const d   = offset(i);
      const a   = d * STEP;
      const rad = a * Math.PI / 180;
      const dist = Math.abs(d);

      const x = R * Math.sin(rad);
      const y = R * (1 - Math.cos(rad));

      const card = cards[i];
      card.style.transform =
        'translate(-50%, -50%)' +
        ' translate(' + x.toFixed(1) + 'px, ' + y.toFixed(1) + 'px)' +
        ' rotate(' + a + 'deg)' +
        ' scale(' + pick(SCALES, dist) + ')';
      card.style.opacity = pick(FADES, dist);
      card.style.zIndex  = String(1000 - dist * 100);
      card.classList.toggle('is-focus', d === 0);
      /* A card behind the focus is decoration, not a control. */
      card.tabIndex = d === 0 ? -1 : 0;
    }

    for (let i = 0; i < panels.length; i++) {
      panels[i].classList.toggle('is-shown', i === focus);
    }

    for (let i = 0; i < dots.length; i++) {
      dots[i].classList.toggle('is-on', i === focus);
      dots[i].setAttribute('aria-selected', i === focus ? 'true' : 'false');
    }
  }

  function go(i) {
    focus = ((i % N) + N) % N;
    layout();
  }

  cards.forEach((c, i) => c.addEventListener('click', () => go(i)));
  dots.forEach((d, i) => d.addEventListener('click', () => go(i)));

  const prev = stage.querySelector('[data-arced-prev]');
  const next = stage.querySelector('[data-arced-next]');
  if (prev) prev.addEventListener('click', () => go(focus - 1));
  if (next) next.addEventListener('click', () => go(focus + 1));

  /* Arrow keys once anything in the stage has focus — the cards are buttons, so
     this is the behaviour a keyboard user will already be expecting. */
  stage.addEventListener('keydown', (e) => {
    if (e.key === 'ArrowLeft')  { go(focus - 1); e.preventDefault(); }
    if (e.key === 'ArrowRight') { go(focus + 1); e.preventDefault(); }
  });

  /* Swipe. Pointer events cover mouse drag and touch in one listener. */
  let downX = null;
  stage.addEventListener('pointerdown', (e) => { downX = e.clientX; });
  stage.addEventListener('pointerup', (e) => {
    if (downX === null) return;
    const dx = e.clientX - downX;
    downX = null;
    if (Math.abs(dx) > 60) go(focus + (dx < 0 ? 1 : -1));
  });

  /* The radius is a fraction of the stage, so a resize has to re-place. */
  let t = 0;
  window.addEventListener('resize', () => {
    clearTimeout(t);
    t = setTimeout(layout, 120);
  }, { passive: true });

  stage.classList.add('is-live');
  layout();
})();
