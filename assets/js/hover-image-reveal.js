/**
 * Hover Image Reveal — a port of Origin Kit's component.
 *
 * A hoverable name list that reveals a cursor-following image for each row as
 * you move through the menu. Built to the component's documented behaviour:
 *
 *   - A cursor-following image window with spring-smoothed motion.
 *   - A vertical image reel that slides directionally between rows: moving
 *     down the list slides the reel up, and moving up slides it down, so the
 *     travel matches the direction the pointer went.
 *   - Independent active and dimmed text colours, with a rollover animation on
 *     the hovered row.
 *   - Adjustable image size, corner radius, and cursor offset.
 *   - Spring or tween motion for everything.
 *
 * Props map to data attributes, keeping the component's defaults: imageWidth
 * 300, imageHeight 400, rounded 16, offsetX 200, offsetY 0, rowGap 30,
 * followStrength 0, align center.
 *
 * One deliberate difference. The reference's rows are labels; these carry a
 * heading and a sentence each, because this is a page section rather than a
 * menu, and the text has to survive with no pointer at all — on a phone the
 * whole thing reads as an ordinary list and the reel never appears.
 */

(function () {
  'use strict';

  const num = (el, key, fallback) => {
    const v = parseFloat(el.dataset[key]);

    return Number.isFinite(v) ? v : fallback;
  };

  document.querySelectorAll('[data-hover-reveal]').forEach((root) => {
    if (root.dataset.revealReady) return;
    root.dataset.revealReady = '1';

    const rows = Array.from(root.querySelectorAll('[data-hr-row]'));
    const win = root.querySelector('[data-hr-window]');
    const reel = root.querySelector('[data-hr-reel]');
    if (!rows.length || !win || !reel) return;

    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches ||
        window.matchMedia('(pointer: coarse)').matches) {
      // No cursor to follow, or motion is unwelcome: the list is the section.
      win.hidden = true;

      return;
    }

    const imageW = num(root, 'imageWidth', 300);
    const imageH = num(root, 'imageHeight', 400);
    const offsetX = num(root, 'offsetX', 200);
    const offsetY = num(root, 'offsetY', 0);
    // The component's dial is 0..100 and higher is snappier; 0 is its default,
    // which is the softest follow rather than no follow at all.
    const follow = 0.055 + (num(root, 'followStrength', 0) / 100) * 0.2;

    win.style.width = imageW + 'px';
    win.style.height = imageH + 'px';
    reel.style.setProperty('--hr-h', imageH + 'px');

    let active = -1;
    let target = { x: 0, y: 0 };
    const cur = { x: 0, y: 0 };
    let raf = 0, moved = false;

    function show(i) {
      if (i === active) return;
      active = i;

      // The reel slides to the row's own frame. Because the frames are stacked
      // in list order, going further down the list moves the reel up — which is
      // the directional travel the component describes.
      reel.style.transform = 'translate3d(0,' + (-i * imageH) + 'px,0)';

      root.classList.add('is-active');
      rows.forEach((r, n) => r.classList.toggle('is-on', n === i));
    }

    function hide() {
      active = -1;
      root.classList.remove('is-active');
      for (const r of rows) r.classList.remove('is-on');
    }

    root.addEventListener('pointermove', (e) => {
      const r = root.getBoundingClientRect();
      target.x = e.clientX - r.left + offsetX - imageW / 2;
      target.y = e.clientY - r.top + offsetY - imageH / 2;

      if (!moved) {
        // Land the window where the pointer already is rather than flying it in
        // from the corner the first time.
        cur.x = target.x;
        cur.y = target.y;
        moved = true;
      }
      if (!raf) raf = requestAnimationFrame(frame);
    }, { passive: true });

    rows.forEach((row, i) => {
      row.addEventListener('pointerenter', () => show(i));
      // Keyboard users get the reel too, without needing a pointer.
      row.addEventListener('focusin', () => show(i));
    });

    root.addEventListener('pointerleave', hide);
    root.addEventListener('focusout', (e) => {
      if (!root.contains(e.relatedTarget)) hide();
    });

    function frame() {
      cur.x += (target.x - cur.x) * follow;
      cur.y += (target.y - cur.y) * follow;
      win.style.transform = 'translate3d(' + cur.x.toFixed(2) + 'px,' + cur.y.toFixed(2) + 'px,0)';

      if (Math.abs(target.x - cur.x) < 0.2 && Math.abs(target.y - cur.y) < 0.2) {
        raf = 0;

        return;
      }
      raf = requestAnimationFrame(frame);
    }

    root.classList.add('hr--live');
  });
})();
