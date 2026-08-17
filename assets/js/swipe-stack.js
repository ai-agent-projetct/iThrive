/**
 * Swipe Stack — a fanned 3D deck you flick through.
 *
 * After Origin Kit's component, built to its documented behaviour and defaults:
 * a draggable top card that flicks to the back of the stack past a threshold,
 * a fan whose tilt runs from `tiltAngleStart` on the front card to `tiltAngle`
 * on the back one, horizontal spread from `xOffset`, per-card scaling for depth,
 * spring motion throughout, and short swipes that snap back to centre.
 *
 *   cardRadius, cardWidth and cardHeight are CSS here rather than props —
 *   they belong to the design, not the behaviour.
 *
 * The cards are the real DOM: six elements with real headings and copy. That is
 * deliberate on a page that has to rank. A canvas version of this would read as
 * an empty box to everything except a human with a mouse, and the keyboard path
 * below would have nothing to move through.
 *
 * Order is tracked as an array of indices rather than by reordering nodes.
 * Moving DOM nodes on every swipe would drop focus and restart the CSS
 * transitions mid-flight; this only ever rewrites transforms.
 */

(function () {
  'use strict';

  document.querySelectorAll('[data-swipe-stack]').forEach(function (stack) {
    const cards = Array.from(stack.querySelectorAll('[data-swipe-card]'));
    if (cards.length < 2) return;

    const THRESHOLD = Number(stack.dataset.threshold || 50);   // px before it flicks
    const TILT_START = Number(stack.dataset.tiltStart || 0);   // front card
    const TILT_END = Number(stack.dataset.tilt || -45);        // back card
    const X_OFFSET = Number(stack.dataset.xOffset || 10);

    const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    // order[0] is the front card. Indices, not nodes — see the note above.
    let order = cards.map((_, i) => i);
    let dragging = false, startX = 0, startY = 0, dx = 0, dy = 0, pid = null;

    function layout(skipTransition) {
      const n = order.length;

      order.forEach((cardIndex, depth) => {
        const el = cards[cardIndex];
        const t = n > 1 ? depth / (n - 1) : 0;

        const tilt = TILT_START + (TILT_END - TILT_START) * t;
        const x = depth * X_OFFSET;
        const scale = 1 - depth * 0.045;
        const z = -depth * 46;

        el.style.transition = skipTransition ? 'none' : '';
        el.style.zIndex = String(n - depth);
        el.style.opacity = depth > 4 ? '0' : '1';   // deep cards are not worth drawing
        el.style.transform =
          'translate3d(' + x + 'px,0,' + z + 'px) rotate(' + tilt.toFixed(2) + 'deg) scale(' + scale.toFixed(3) + ')';

        el.classList.toggle('is-front', depth === 0);
        // Only the front card takes the pointer, or a drag started on a
        // half-hidden card behind it.
        el.style.pointerEvents = depth === 0 ? 'auto' : 'none';
        el.setAttribute('aria-hidden', depth === 0 ? 'false' : 'true');
        el.tabIndex = depth === 0 ? 0 : -1;
      });

      if (skipTransition) {
        // Force the layout so the next frame animates from here rather than
        // inheriting the skipped transition.
        void stack.offsetWidth;
        order.forEach((i) => { cards[i].style.transition = ''; });
      }
    }

    /** Send the front card to the back. */
    function cycle(direction) {
      const front = cards[order[0]];

      front.classList.add('is-leaving');
      front.style.transform =
        'translate3d(' + (direction * 140) + '%,-6%,0) rotate(' + (direction * 22) + 'deg) scale(.94)';
      front.style.opacity = '0';

      window.setTimeout(function () {
        front.classList.remove('is-leaving');
        order.push(order.shift());
        layout(true);
        stack.dispatchEvent(new CustomEvent('swipestack:change', { detail: { front: order[0] } }));
      }, reduce ? 0 : 260);
    }

    /* ---- drag ------------------------------------------------------------ */

    stack.addEventListener('pointerdown', function (e) {
      const card = e.target.closest('[data-swipe-card]');
      if (!card || cards.indexOf(card) !== order[0]) return;

      dragging = true;
      pid = e.pointerId;
      startX = e.clientX;
      startY = e.clientY;
      dx = dy = 0;
      card.setPointerCapture(pid);
      card.style.transition = 'none';
      stack.classList.add('is-dragging');
    });

    stack.addEventListener('pointermove', function (e) {
      if (!dragging || e.pointerId !== pid) return;

      dx = e.clientX - startX;
      dy = e.clientY - startY;

      const card = cards[order[0]];
      // Rotation tracks the drag, so the card pivots as though held at a corner.
      card.style.transform =
        'translate3d(' + dx + 'px,' + dy * 0.35 + 'px,0) rotate(' + (dx / 18).toFixed(2) + 'deg) scale(1.02)';
    });

    function release() {
      if (!dragging) return;
      dragging = false;
      stack.classList.remove('is-dragging');

      const card = cards[order[0]];
      card.style.transition = '';

      if (Math.abs(dx) >= THRESHOLD) {
        cycle(dx < 0 ? -1 : 1);
      } else {
        // Short swipe: snap home.
        layout(false);
      }
      dx = dy = 0;
    }

    stack.addEventListener('pointerup', release);
    stack.addEventListener('pointercancel', release);

    /* ---- keyboard -------------------------------------------------------- */

    // The deck is content, so it cannot be mouse-only. Arrows and space move it.
    stack.addEventListener('keydown', function (e) {
      if (e.key === 'ArrowLeft') { cycle(-1); e.preventDefault(); }
      else if (e.key === 'ArrowRight' || e.key === ' ' || e.key === 'Enter') { cycle(1); e.preventDefault(); }
    });

    const next = stack.parentElement.querySelector('[data-swipe-next]');
    if (next) next.addEventListener('click', function () { cycle(1); });

    stack.classList.add('swipe-stack--live');
    layout(true);
  });
})();
