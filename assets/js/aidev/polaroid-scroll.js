/**
 * The polaroid gallery's glide.
 *
 * After Soyeb's "Polaroid Scroll", whose description is the brief: each polaroid
 * moves across a large canvas as you scroll, "naturally changing composition and
 * focus to create depth". That component is paid and publishes no code, so this
 * is the behaviour built rather than the file copied.
 *
 * The rule: travel is driven by the SECTION's progress, not by each card's own.
 * Driving each card from its own position makes them arrive independently and
 * the wall stops reading as one object — the same mistake that made the stacked
 * deck on this page tip on the wrong schedule.
 *
 * Depth does three things at once, which is what sells it as a room rather than
 * a row: a near polaroid travels further, sits larger and stays sharp; a far one
 * drifts slowly, sits smaller and softens. Nothing here is required — with the
 * script absent the polaroids simply sit in their lanes.
 */

(function () {
  'use strict';

  const stage = document.querySelector('[data-polaroid]');
  if (!stage) return;

  const cards = Array.from(stage.querySelectorAll('.polaroid'));
  if (!cards.length) return;

  /* Someone who has asked for less motion gets the gallery, not the ride. */
  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    stage.classList.add('is-static');
    return;
  }

  /* How far the nearest card travels, in px. Far cards get a fraction of it,
     which is what opens the depth.
     420 was too much: at three lanes the cards rode out past the section's own
     edges and got clipped mid-sentence. This is enough to read as motion while
     every polaroid stays inside the frame. */
  const TRAVEL = 165;

  const clamp = (v, a, b) => (v < a ? a : v > b ? b : v);

  let raf = 0;
  let onScreen = false;

  function frame() {
    raf = 0;
    if (!onScreen) return;

    const r = stage.getBoundingClientRect();
    const vh = window.innerHeight;

    /*
     * 0 as the wall's top edge reaches the bottom of the screen, 1 once its
     * bottom edge has reached the top. One number for the whole section, so
     * every polaroid is placed against the same clock.
     */
    const p = clamp((vh - r.top) / Math.max(1, vh + r.height), 0, 1);

    for (const card of cards) {
      const depth = parseFloat(card.style.getPropertyValue('--depth')) || 0;
      // near (depth 0) travels the full distance; far (depth 1) a third of it
      const reach = TRAVEL * (1 - depth * 0.66);
      // lanes alternate direction, so the wall shears rather than slides
      const lane = parseInt(card.style.getPropertyValue('--lane'), 10) || 0;
      const dir = lane % 2 === 0 ? 1 : -1;

      card.style.setProperty('--glide', ((p - 0.5) * 2 * reach * dir).toFixed(2) + 'px');
    }

    schedule();
  }

  function schedule() {
    if (!raf && onScreen) raf = requestAnimationFrame(frame);
  }

  if ('IntersectionObserver' in window) {
    new IntersectionObserver(([e]) => {
      onScreen = e.isIntersecting;
      schedule();
    }, { rootMargin: '120px' }).observe(stage);
  } else {
    onScreen = true;
    schedule();
  }

  window.addEventListener('resize', schedule, { passive: true });
  stage.classList.add('is-live');
})();
