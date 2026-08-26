/**
 * The hero film: framing, and a slow lean.
 *
 * The film is a wide shot with the robot small in it — right for a film, far
 * too small for a hero — so it is pushed in past "cover" and anchored on him:
 * a chosen point in the source frame is held at a chosen point on screen, so
 * he sits right of centre with the copy on the darkened left, at any window
 * size, without object-position guesswork.
 *
 * The only response to the pointer is the whole picture leaning a few pixels
 * against it. The footage holds still — across its twelve seconds his head
 * moves two pixels in a 1928-wide frame — so parallax is the one depth cue
 * available without pretending the figure is animated.
 */

(function () {
  'use strict';

  const HOST = document.querySelector('[data-film-robot]');
  if (!HOST) return;

  const video = HOST.querySelector('video');
  if (!video) return;

  const SRC_W = 1928, SRC_H = 1072;

  // His chest in the source frame, and where that point sits on screen.
  const SRC_X = 990 / SRC_W, SRC_Y = 470 / SRC_H;
  const DST_Y = 0.5;

  function layout() {
    const W = HOST.clientWidth;
    const H = HOST.clientHeight;
    if (!W || !H) return;

    // Narrow screens give the film its own band above the copy rather than
    // sitting behind it, so he is centred there and pushed in less.
    const narrow = W < 900;
    const dstX = narrow ? 0.5 : 0.62;
    const zoom = narrow ? 1.15 : 1.5;
    const scale = Math.max(W / SRC_W, H / SRC_H) * zoom;
    const w = SRC_W * scale;
    const h = SRC_H * scale;

    // Anchored on him, then clamped so no edge of the film pulls into frame.
    video.style.width = w + 'px';
    video.style.height = h + 'px';
    video.style.left = Math.min(0, Math.max(W - w, W * dstX - w * SRC_X)) + 'px';
    video.style.top = Math.min(0, Math.max(H - h, H * DST_Y - h * SRC_Y)) + 'px';
  }

  layout();
  window.addEventListener('resize', layout);
  if ('ResizeObserver' in window) new ResizeObserver(layout).observe(HOST);
  video.addEventListener('loadedmetadata', layout);

  /* ---- the lean --------------------------------------------------------- */

  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

  const aim = { x: 0, y: 0 };
  const cur = { x: 0, y: 0 };
  let onScreen = true, running = false;

  if ('IntersectionObserver' in window) {
    new IntersectionObserver(([e]) => {
      onScreen = e.isIntersecting;
      if (onScreen && !running) { running = true; requestAnimationFrame(frame); }
    }, { threshold: 0 }).observe(HOST);
  }

  window.addEventListener('pointermove', (e) => {
    aim.x = (e.clientX / window.innerWidth) * 2 - 1;
    aim.y = (e.clientY / window.innerHeight) * 2 - 1;
  }, { passive: true });

  function frame() {
    if (!onScreen) { running = false; return; }
    requestAnimationFrame(frame);

    cur.x += (-aim.x * 10 - cur.x) * 0.06;
    cur.y += (-aim.y * 6 - cur.y) * 0.06;
    video.style.transform =
      'translate3d(' + cur.x.toFixed(2) + 'px,' + cur.y.toFixed(2) + 'px,0) scale(1.02)';
  }

  running = true;
  requestAnimationFrame(frame);
})();
