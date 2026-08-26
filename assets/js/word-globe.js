/**
 * Word Globe — a port of Origin Kit's component to vanilla JS.
 *
 * A sphere woven entirely out of repeated text: characters laid along latitude
 * bands, the bands twisted into a helix, projected and drawn back-to-front so
 * the far side of the sphere shows through the near side.
 *
 * The component's props are all here, with its defaults, each readable from a
 * data attribute:
 *
 *   word           the string repeated to build the surface
 *   twist      50  how tightly the bands twist into a helix
 *   letterSpacing 800  glyph density across the surface
 *   speed       7  rotation speed
 *   rotationSide   clockwise | counterclockwise
 *   color   #FFFFFF  the character colour
 *   font           family, weight, size
 *
 * It also keeps the component's two performance manners: it respects
 * prefers-reduced-motion, and it stops entirely while off-screen.
 *
 * One deliberate difference. The reference repeats a single word; this is fed
 * the actual technology names from the section it sits in, so the sphere is
 * literally woven out of the stack it illustrates rather than out of decoration.
 * The names are also in the markup behind it, because a crawler cannot read a
 * canvas.
 */

(function () {
  'use strict';

  const num = (el, key, fallback) => {
    const v = parseFloat(el.dataset[key]);

    return Number.isFinite(v) ? v : fallback;
  };

  document.querySelectorAll('[data-word-globe]').forEach((mount) => {
    if (mount.dataset.globeReady) return;
    mount.dataset.globeReady = '1';

    /* ---- props, defaulting to the component's own ---------------------- */

    const word          = (mount.dataset.word || 'origin kit').trim();
    const twist         = num(mount, 'twist', 50);
    const letterSpacing = num(mount, 'letterSpacing', 800);
    const speed         = num(mount, 'speed', 7);
    const dir           = mount.dataset.rotationSide === 'clockwise' ? -1 : 1;
    const color         = mount.dataset.color || '#FFFFFF';
    const weight        = mount.dataset.fontWeight || '700';
    const family        = mount.dataset.fontFamily || 'Outfit, Segoe UI, sans-serif';
    const fontSize      = num(mount, 'fontSize', 15);

    const canvas = document.createElement('canvas');
    mount.appendChild(canvas);
    const ctx = canvas.getContext('2d');
    if (!ctx) return;

    let W = 0, H = 0, R = 0, dpr = 1;

    function resize() {
      dpr = Math.min(window.devicePixelRatio || 1, 2);
      W = mount.clientWidth;
      H = mount.clientHeight;
      canvas.width = W * dpr;
      canvas.height = H * dpr;
      canvas.style.width = W + 'px';
      canvas.style.height = H + 'px';
      ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
      R = Math.min(W, H) * 0.36;
    }
    resize();
    window.addEventListener('resize', resize);
    if ('ResizeObserver' in window) new ResizeObserver(resize).observe(mount);

    /* ---- the surface ---------------------------------------------------- */

    /*
     * Bands of characters, spaced so the sphere looks evenly covered rather
     * than crowded at the poles: the number of glyphs on a band follows the
     * cosine of its latitude, which is the band's actual circumference.
     */
    const chars = Array.from(word.replace(/\s+/g, ' '));
    const BANDS = 26;
    const glyphs = [];
    let n = 0;

    for (let b = 0; b < BANDS; b++) {
      // -PI/2..PI/2, skipping the exact poles where a band has no width.
      const lat = -Math.PI / 2 + (Math.PI * (b + 0.5)) / BANDS;
      const circumference = Math.cos(lat);
      const count = Math.max(1, Math.round((letterSpacing / 46) * circumference));

      for (let i = 0; i < count; i++) {
        glyphs.push({
          lat,
          lon: (i / count) * Math.PI * 2,
          // The helix: each band is phase-shifted by its own latitude, which is
          // what turns straight rings into a weave.
          skew: lat * (twist / 26),
          ch: chars[n++ % chars.length],
        });
      }
    }

    /* ---- motion --------------------------------------------------------- */

    const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    let rot = 0, last = 0, onScreen = false, raf = 0;

    // Tilt the pole away from vertical so the weave is legible as a sphere.
    const TILT = 0.42;
    const sinT = Math.sin(TILT), cosT = Math.cos(TILT);

    function draw(now) {
      raf = requestAnimationFrame(draw);
      if (!onScreen || !W) return;

      const dt = last ? Math.min((now - last) / 1000, 0.05) : 0;
      last = now;
      if (!reduce) rot += dir * speed * 0.06 * dt * Math.PI;

      ctx.clearRect(0, 0, W, H);
      ctx.textAlign = 'center';
      ctx.textBaseline = 'middle';

      const cx = W / 2, cy = H / 2;
      const depth = R * 3.2;   // perspective distance

      // Back to front, so the far side of the sphere reads through the near.
      const drawn = [];
      for (const g of glyphs) {
        const lon = g.lon + rot + g.skew;
        const cl = Math.cos(g.lat);

        // point on the sphere, then tilted about X
        const x = cl * Math.sin(lon);
        const yr = Math.sin(g.lat);
        const zr = cl * Math.cos(lon);
        const y = yr * cosT - zr * sinT;
        const z = yr * sinT + zr * cosT;

        drawn.push({ ch: g.ch, x: x * R, y: y * R, z: z * R });
      }
      drawn.sort((a, b) => a.z - b.z);

      for (const p of drawn) {
        const scale = depth / (depth - p.z);
        // Front of the sphere is bright and large; the back fades into it.
        const t = (p.z / R + 1) / 2;
        ctx.globalAlpha = 0.24 + t * 0.76;
        ctx.fillStyle = color;
        ctx.font = weight + ' ' + (fontSize * scale).toFixed(2) + 'px ' + family;
        ctx.fillText(p.ch, cx + p.x * scale, cy + p.y * scale);
      }
      ctx.globalAlpha = 1;
    }

    if ('IntersectionObserver' in window) {
      new IntersectionObserver(([e]) => {
        onScreen = e.isIntersecting;
        // Stopped rather than idled while off-screen, which is the component's
        // own behaviour and the difference between one rAF and none.
        if (onScreen && !raf) { last = 0; raf = requestAnimationFrame(draw); }
        if (!onScreen && raf) { cancelAnimationFrame(raf); raf = 0; }
      }, { threshold: 0 }).observe(mount);
    } else {
      onScreen = true;
      raf = requestAnimationFrame(draw);
    }

    mount.classList.add('is-live');
  });
})();
