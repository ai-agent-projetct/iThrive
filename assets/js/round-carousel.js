/**
 * Round Carousel — a port of Origin Kit's component to vanilla JS.
 *
 * The geometry and the motion are the component's, unchanged:
 *
 *   angle     360 / count
 *   factor    1 + spacing * 0.15
 *   radius    (imageWidth * factor) / (2 * tan(PI / count))
 *   degPerSec speed * 6, negated when direction is "left"
 *   ring      translateZ(-radius) rotateY(rot)
 *   item      rotateY(i * angle) translateZ(radius)
 *   drag      k = 0.3 * sensitivity;  rot += dx * k;  vel = dx * k * 60
 *   release   vel decays by 0.94 a frame until |vel| <= 0.01, then the
 *             constant spin resumes
 *
 * Every default matches too — imageWidth 300, imageHeight 300, spacing 3,
 * speed 7, direction right, sensitivity 5, tilt -7, perspective 3000,
 * cornerRadius 22, innerDim 3.5 — and each is overridable per instance from a
 * data attribute, the way the React props are.
 *
 * Two deliberate differences, both because this is a page that has to rank
 * rather than a component demo:
 *
 *  - The faces are real markup, not background images. Each one is a case
 *    study with a name, a headline and a link, so the section is readable by a
 *    crawler and reachable by a keyboard. The React version paints
 *    background-image on a div, which would leave ten empty boxes.
 *  - Auto-rotation stops on hover and on focus, and never starts under
 *    prefers-reduced-motion. A ring that keeps turning while you are trying to
 *    read or click a card is hostile.
 */

(function () {
  'use strict';

  const num = (el, key, fallback) => {
    const v = parseFloat(el.dataset[key]);

    return Number.isFinite(v) ? v : fallback;
  };

  document.querySelectorAll('[data-round-carousel]').forEach((stage) => {
    const ring = stage.querySelector('[data-rc-ring]');
    const items = Array.from(stage.querySelectorAll('[data-rc-item]'));
    const count = items.length;
    if (!ring || count < 2) return;

    /* ---- props, defaulting to the component's own ---------------------- */

    // The ring radius follows the card width, and the card shrinks on narrow
    // screens — reading the CSS value keeps the two in step instead of leaving
    // the ring sized for a card that is no longer that wide.
    const cssW = parseFloat(getComputedStyle(stage).getPropertyValue('--rc-w'));
    const imageWidth   = Number.isFinite(cssW) && cssW > 0 ? cssW : num(stage, 'imageWidth', 300);
    const spacing      = num(stage, 'spacing', 3);
    const speed        = num(stage, 'speed', 7);
    const sensitivity  = num(stage, 'sensitivity', 5);
    const tilt         = num(stage, 'tilt', -7);
    const perspective  = num(stage, 'perspective', 3000);
    const innerDim     = num(stage, 'innerDim', 3.5);
    const direction    = stage.dataset.direction === 'left' ? -1 : 1;
    const canDrag      = stage.dataset.drag !== 'false';

    const angle  = 360 / count;
    const factor = 1 + spacing * 0.15;
    const radius = (imageWidth * factor) / (2 * Math.tan(Math.PI / count));
    const degPerSec = speed * 6 * direction;

    /* ---- place the ring and its items ---------------------------------- */

    stage.style.perspective = perspective + 'px';
    const tiltEl = stage.querySelector('[data-rc-tilt]');
    if (tiltEl) tiltEl.style.transform = 'rotateX(' + tilt + 'deg)';

    items.forEach((item, i) => {
      item.style.transform = 'rotateY(' + (i * angle) + 'deg) translateZ(' + radius + 'px)';
      const back = item.querySelector('[data-rc-back]');
      // innerDim is a 0-10 dial in the component; brightness wants 0-1.
      if (back) back.style.filter = 'brightness(' + (innerDim / 10) + ')';
    });

    /* ---- motion --------------------------------------------------------- */

    const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    let rot = 0, vel = 0, last = 0, raf = 0;
    let dragging = false, dragX = 0, moved = 0, captured = false;
    let paused = false, onScreen = true;

    const apply = () => {
      ring.style.transform = 'translateZ(' + (-radius) + 'px) rotateY(' + rot + 'deg)';
    };
    apply();

    function draw(now) {
      raf = requestAnimationFrame(draw);

      const dt = last ? (now - last) / 1000 : 0;
      last = now;
      // The component clamps the step, so a backgrounded tab does not return
      // and jump the ring through half a turn in one frame.
      const f = Math.min(dt, 0.1);

      if (!onScreen) return;

      if (!dragging) {
        if (Math.abs(vel) > 0.01) {
          rot += vel * f;
          vel *= 0.94;
        } else if (!paused && !reduce) {
          rot += degPerSec * f;
        }
      }
      apply();
    }

    /* ---- drag ----------------------------------------------------------- */

    if (canDrag) {
      const k = 0.3 * sensitivity;

      /**
       * Capture is taken on the first real movement, not on pointerdown.
       *
       * Capturing immediately retargets the click that follows to the stage, so
       * the anchor under the cursor never receives it and a plain click on a
       * card did nothing at all. Waiting until the pointer has actually moved
       * means a click stays a click and only a drag captures.
       */
      stage.addEventListener('pointerdown', (e) => {
        dragging = true;
        dragX = e.clientX;
        moved = 0;
        captured = false;
        vel = 0;
        stage.classList.add('is-grabbing');
      });

      stage.addEventListener('pointermove', (e) => {
        if (!dragging) return;
        const dx = e.clientX - dragX;
        dragX = e.clientX;
        moved += Math.abs(dx);

        if (!captured && moved > 3) {
          captured = true;
          stage.setPointerCapture?.(e.pointerId);
        }

        rot += dx * k;
        vel = dx * k * 60;
      });

      const release = (e) => {
        if (!dragging) return;
        dragging = false;
        if (captured) {
          stage.releasePointerCapture?.(e.pointerId);
          captured = false;
        }
        stage.classList.remove('is-grabbing');
      };
      stage.addEventListener('pointerup', release);
      stage.addEventListener('pointercancel', release);

      /**
       * A drag must not navigate.
       *
       * The whole face is a link, so releasing after a drag fires a click on
       * whichever card happened to be under the cursor and the page changes on
       * its own. Captured before the anchor sees it, and cancelled if the
       * pointer actually travelled — ten pixels of slack, because a click on a
       * trackpad is never perfectly still.
       */
      stage.addEventListener('click', (e) => {
        if (moved > 10) {
          e.preventDefault();
          e.stopPropagation();
        }
      }, true);
    }

    /* ---- stop turning when someone is trying to read it ----------------- */

    const hold = () => { paused = true; };
    const resume = () => { paused = false; };
    stage.addEventListener('pointerenter', hold);
    stage.addEventListener('pointerleave', resume);
    stage.addEventListener('focusin', hold);
    stage.addEventListener('focusout', resume);

    if ('IntersectionObserver' in window) {
      new IntersectionObserver(([e]) => { onScreen = e.isIntersecting; }, { threshold: 0 }).observe(stage);
    }

    stage.classList.add('rc--live');
    raf = requestAnimationFrame(draw);
  });
})();
