/**
 * The stack that travels with the cursor.
 *
 * Ported from the Mobile App Development page's TechMagnetSection so the two
 * behave identically — the motion below is that component's, unchanged. What
 * differs is only how it is fed and dressed: the technologies arrive as JSON on
 * the element instead of being hardcoded in a module, each already carrying the
 * URL of its icon, so PHP owns the list and this file never has to work out a
 * base path. The section around it wears the site's own styles rather than the
 * React build's Tailwind, which means the home page does not have to load a
 * second stylesheet or the app bundle to show it.
 *
 * The behaviour worth naming, because it is not what it looks like: the icons
 * do not drift toward the pointer, they form a *chain* behind it. The first
 * tile chases the cursor, the second chases the first, the third the second —
 * so a flick of the mouse drags the whole stack after it as a snaking tail, and
 * pausing lets the tail coil up and settle. Clicking releases it and the stack
 * eases back to its scattered home positions.
 *
 * Drawn on a 2D canvas rather than in WebGL. Every tile is a rounded square
 * with a brand-coloured glyph, which is a texture-atlas problem in Three.js and
 * three lines of drawImage here — and it stays sharp at any DPR.
 */

(function () {
  'use strict';

  var TILE = 58;        // css px
  var SPACING = 0.031;  // gap between links, as a fraction of stage width

  function start(mount) {
    if (!mount || mount.dataset.magnetReady) return;

    var STACK;
    try {
      STACK = JSON.parse(mount.dataset.stack || '[]');
    } catch (e) {
      return;
    }
    if (!STACK.length) return;
    mount.dataset.magnetReady = '1';

    var canvas = document.createElement('canvas');
    canvas.className = 'tmagnet-canvas';
    mount.appendChild(canvas);
    var ctx = canvas.getContext('2d');
    if (!ctx) return;

    var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var W = 0, H = 0, dpr = 1;
    var ASPECT = 1;   // W/H, so spacing stays circular on a wide stage

    function resize() {
      dpr = Math.min(window.devicePixelRatio || 1, 2);
      W = mount.clientWidth;
      H = mount.clientHeight;
      canvas.width = W * dpr;
      canvas.height = H * dpr;
      canvas.style.width = W + 'px';
      canvas.style.height = H + 'px';
      ASPECT = H === 0 ? 1 : W / H;
      ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
    }
    resize();

    /* ---- one pre-rendered tile per technology ---------------------------- */

    var tiles = STACK.map(function (entry) {
      var colour = entry[1];
      var src = entry[2];

      var tile = document.createElement('canvas');
      tile.width = tile.height = TILE * 2;          // 2x for crispness
      var g = tile.getContext('2d');

      // The plate: a dark rounded square, like an app icon.
      var R = 26;
      g.beginPath();
      g.moveTo(R, 0);
      g.arcTo(TILE * 2, 0, TILE * 2, TILE * 2, R);
      g.arcTo(TILE * 2, TILE * 2, 0, TILE * 2, R);
      g.arcTo(0, TILE * 2, 0, 0, R);
      g.arcTo(0, 0, TILE * 2, 0, R);
      g.closePath();
      g.fillStyle = '#0E1626';
      g.fill();
      g.strokeStyle = 'rgba(255,255,255,.10)';
      g.lineWidth = 2;
      g.stroke();

      // Simple Icons ship a bare <path> with no fill, so it defaults to black.
      // Recolour to the brand hex before rasterising, or it is invisible.
      fetch(src)
        .then(function (r) { return r.ok ? r.text() : Promise.reject(new Error(String(r.status))); })
        .then(function (svg) {
          svg = svg
            .replace(/<svg([^>]*)>/, '<svg$1 width="72" height="72">')
            .replace(/<path/g, '<path fill="' + colour + '"');

          var img = new Image();
          img.onload = function () { g.drawImage(img, 26, 26, 72, 72); };
          img.src = 'data:image/svg+xml;charset=utf-8,' + encodeURIComponent(svg);
        })
        .catch(function () { /* a missing icon is an empty plate, not a crash */ });

      return tile;
    });

    /* ---- the chain ------------------------------------------------------- */

    // Everything starts scattered, so the section reads as a field before the
    // cursor ever arrives.
    var links = tiles.map(function (tile, i) {
      var a = i * 2.39996;
      var r = 0.16 + Math.sqrt(i / tiles.length) * 0.46;

      return {
        tile: tile,
        x: 0.5 + Math.cos(a) * r,     // fractions of the stage, so resize is free
        y: 0.5 + Math.sin(a) * r * 0.9,
        px: 0, py: 0,
        homeA: a, homeR: r
      };
    });

    var pointer = { x: 0.5, y: 0.5, active: false };

    function onMove(e) {
      var r = mount.getBoundingClientRect();
      var inside = e.clientX >= r.left && e.clientX <= r.right
                && e.clientY >= r.top  && e.clientY <= r.bottom;
      pointer.active = inside;
      if (!inside) return;
      pointer.x = (e.clientX - r.left) / r.width;
      pointer.y = (e.clientY - r.top) / r.height;
    }
    window.addEventListener('pointermove', onMove, { passive: true });
    mount.addEventListener('pointerleave', function () { pointer.active = false; });

    /**
     * Click to send the stack home.
     *
     * The chain follows the cursor for as long as it is over the field, so
     * without this there is no way to see the whole stack laid out again short
     * of moving the mouse away. A click releases it, and it eases back to its
     * scattered home positions.
     */
    var releasedUntil = 0;
    mount.addEventListener('click', function () { releasedUntil = performance.now() + 2600; });
    function isReleased() { return performance.now() < releasedUntil; }

    var visible = true;
    if ('IntersectionObserver' in window) {
      new IntersectionObserver(function (es) { visible = es[0].isIntersecting; }, { threshold: 0 }).observe(mount);
    }
    if ('ResizeObserver' in window) {
      new ResizeObserver(resize).observe(mount);
    }
    window.addEventListener('resize', resize);

    var t = 0;

    function frame() {
      requestAnimationFrame(frame);
      if (!visible || W === 0) return;

      t += 0.006;
      ctx.clearRect(0, 0, W, H);

      // --- 1. the head -----------------------------------------------------
      var head = links[0];
      var following = pointer.active && !reduce && !isReleased();

      if (following) {
        // Only the head is eased. Everything behind it is solved, not eased —
        // easing each link meant the tail could never satisfy its spacing and
        // simply piled up in the middle.
        head.x += (pointer.x - head.x) * 0.22;
        head.y += (pointer.y - head.y) * 0.22;
      } else {
        var ha = head.homeA + t * 0.35;
        head.x += ((0.5 + Math.cos(ha) * head.homeR) - head.x) * 0.035;
        head.y += ((0.5 + Math.sin(ha) * head.homeR * 0.9) - head.y) * 0.035;
      }

      // --- 2. the rest: follow the leader ---------------------------------
      for (var i = 1; i < links.length; i++) {
        var link = links[i];
        var lead = links[i - 1];

        if (following) {
          // Hold exactly SPACING behind the link in front, measured in a
          // square space so the gap is circular on a wide stage.
          var dx = link.x - lead.x;
          var dy = (link.y - lead.y) * ASPECT;
          var d = Math.hypot(dx, dy) || 1;
          link.x = lead.x + (dx / d) * SPACING;
          link.y = lead.y + (dy / d) * (SPACING / ASPECT);
        } else {
          var a = link.homeA + t * 0.35;
          link.x += ((0.5 + Math.cos(a) * link.homeR) - link.x) * 0.035;
          link.y += ((0.5 + Math.sin(a) * link.homeR * 0.9) - link.y) * 0.035;
        }
      }

      // --- 3. draw, back of the tail first so the head sits on top ---------
      for (var j = links.length - 1; j >= 0; j--) {
        var l = links[j];
        var cx = l.x * W;
        var cy = l.y * H;

        // Lean into the direction of travel — a static tile in a moving chain
        // reads as a bug.
        var vx = cx - l.px;
        var vy = cy - l.py;
        l.px = cx;
        l.py = cy;
        var tilt = Math.max(-0.4, Math.min(0.4, (vx + vy) * 0.010));

        var size = TILE * (1 - (j / links.length) * 0.14);

        ctx.save();
        ctx.translate(cx, cy);
        ctx.rotate(tilt);
        ctx.globalAlpha = 1 - (j / links.length) * 0.18;
        ctx.drawImage(l.tile, -size / 2, -size / 2, size, size);
        ctx.restore();
      }
    }
    frame();
  }

  function init() {
    document.querySelectorAll('[data-tech-magnet]').forEach(start);
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
