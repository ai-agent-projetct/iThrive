/**
 * 3D scroll — the case studies grid on a curved surface.
 *
 * What unseen.co/projects actually does, measured rather than guessed: the page
 * has no scrollable document at all (body scrollHeight 0), no <img> elements,
 * and one full-viewport WebGL2 canvas. The entire grid — tiles, captions, the
 * arches down the sides — is rendered inside that context, and scroll is
 * captured and fed to a 3D scene. The tiles sit on a gently curved surface, so
 * they lean in from the sides and recede at the top and bottom as they pass.
 *
 * This reproduces the motion without rendering the section into a texture, and
 * that difference is deliberate. Their approach makes every word on the page a
 * pixel; this is a section of client names, outcomes and links on the page that
 * has to rank. Here the tiles are the real cards, transformed in CSS 3D, so the
 * text stays selectable, focusable and readable by a crawler.
 *
 * Three properties per card drive it:
 *
 *   --depth  -1 above the viewport centre, +1 below. Drives the lean and the
 *            recede, so a card straightens as it passes the middle.
 *   --side   -1 left column, +1 right. Drives the rotateY that bends the grid
 *            into a curved sheet rather than a flat plane.
 *   --vel    signed scroll velocity, for a little drag on the motion.
 *
 * Skipped under prefers-reduced-motion and on coarse pointers.
 */

(function () {
  'use strict';

  const scope = document.querySelector('[data-warp]');
  if (!scope) return;

  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
  if (window.matchMedia('(pointer: coarse)').matches) return;

  const items = Array.from(scope.querySelectorAll('[data-warp-item], .case-card'));
  if (items.length < 2) return;

  /* ---- which side of the grid is each card on? ------------------------- */

  // Read from laid-out position rather than assuming two columns, so the curve
  // still behaves if the grid reflows to one.
  function measureSides() {
    const lefts = items.map((el) => el.getBoundingClientRect().left);
    const min = Math.min(...lefts);
    const max = Math.max(...lefts);
    const span = max - min;

    items.forEach((el, i) => {
      const side = span < 40 ? 0 : ((lefts[i] - min) / span) * 2 - 1;
      el.style.setProperty('--side', side.toFixed(3));
    });
  }

  /* ---- state ----------------------------------------------------------- */

  let lastY = window.scrollY;
  let velocity = 0;
  let onScreen = false;

  const clamp = (v, a, b) => (v < a ? a : v > b ? b : v);

  function frame() {
    requestAnimationFrame(frame);

    // Tracked whether or not the section is visible: skipping it while away
    // makes the first frame back read the whole intervening scroll as one delta
    // and slam the grid to full deflection.
    const y = window.scrollY;
    const raw = onScreen ? y - lastY : 0;
    lastY = y;

    if (!onScreen) {
      if (velocity !== 0) {
        velocity = 0;
        scope.style.setProperty('--vel', '0');
      }
      return;
    }

    const target = clamp(raw / 40, -1.2, 1.2);
    velocity += (target - velocity) * (Math.abs(target) > Math.abs(velocity) ? 0.3 : 0.1);
    if (Math.abs(velocity) < 0.002) velocity = 0;

    scope.style.setProperty('--vel', velocity.toFixed(4));

    const mid = window.innerHeight / 2;
    for (const el of items) {
      const r = el.getBoundingClientRect();
      const centre = r.top + r.height / 2;

      // Normalised against a window slightly larger than the viewport, so a card
      // is already easing before it arrives rather than snapping in.
      el.style.setProperty('--depth', clamp((centre - mid) / (mid * 1.15), -1, 1).toFixed(4));
    }
  }

  if ('IntersectionObserver' in window) {
    new IntersectionObserver(([e]) => { onScreen = e.isIntersecting; }, { threshold: 0 }).observe(scope);
  } else {
    onScreen = true;
  }

  measureSides();
  window.addEventListener('resize', measureSides);

  scope.classList.add('warp--live');
  requestAnimationFrame(frame);
})();
