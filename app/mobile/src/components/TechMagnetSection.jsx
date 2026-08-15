import React, { useEffect, useRef } from 'react';
import MouseOverText from './MouseOverText';

/**
 * The stack that travels with the cursor.
 *
 * Matching the reference: the icons do not simply drift toward the pointer,
 * they form a *chain* behind it. The first tile chases the cursor, the second
 * chases the first, the third the second — so a flick of the mouse drags the
 * whole stack after it as a snaking tail, and pausing lets the tail coil up and
 * settle. That trailing behaviour, not attraction, is what the reference does.
 *
 * Drawn on a 2D canvas rather than in WebGL. Every tile is a rounded square
 * with a brand-coloured glyph, which is a texture-atlas problem in Three.js and
 * three lines of `drawImage` here — and it stays sharp at any DPR.
 */

/** Every stack we ship with, and the colour each mark is drawn in. */
const STACK = [
  ['flutter', '#54C5F8'], ['react', '#61DAFB'], ['swift', '#F05138'], ['kotlin', '#A97BFF'],
  ['typescript', '#3178C6'], ['nodedotjs', '#5FA04E'], ['python', '#FFD845'], ['firebase', '#FFCA28'],
  ['graphql', '#E10098'], ['postgresql', '#4169E1'], ['mongodb', '#47A248'], ['redis', '#FF4438'],
  ['docker', '#2496ED'], ['stripe', '#635BFF'], ['tailwindcss', '#38BDF8'], ['amazonwebservices', '#FF9900'],
  ['kubernetes', '#326CE5'], ['django', '#44B78B'], ['fastapi', '#009688'], ['nextdotjs', '#FFFFFF'],
  ['vuedotjs', '#4FC08D'], ['angular', '#DD0031'], ['php', '#777BB4'], ['laravel', '#FF2D20'],
  ['mysql', '#00758F'], ['googlecloud', '#4285F4'], ['azure', '#0078D4'], ['terraform', '#844FBA'],
  ['githubactions', '#2088FF'], ['jenkins', '#D33833'], ['grafana', '#F46800'], ['express', '#FFFFFF'],
  ['tensorflow', '#FF6F00'], ['pytorch', '#EE4C2C'], ['openai', '#FFFFFF'], ['langchain', '#FFFFFF'],
  ['pandas', '#E70488'], ['scikitlearn', '#F7931E'], ['celery', '#37814A'], ['apacheairflow', '#017CEE'],
  ['dbt', '#FF694B'], ['opensearch', '#005EB8'], ['shopify', '#7AB55C'], ['woocommerce', '#96588A'],
  ['razorpay', '#0C2451'], ['upi', '#5F259F'], ['vite', '#646CFF'], ['threedotjs', '#FFFFFF'],
  ['openjdk', '#FFFFFF'], ['dotnet', '#512BD4'],
];

const TILE = 58;      // css px
const SPACING = 0.031; // gap between links, as a fraction of stage width

export default function TechMagnetSection() {
  const mountRef = useRef(null);

  useEffect(() => {
    const mount = mountRef.current;
    if (!mount) return;

    const canvas = document.createElement('canvas');
    canvas.className = 'tech-magnet-canvas';
    mount.appendChild(canvas);
    const ctx = canvas.getContext('2d');

    const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    let W = 0, H = 0, dpr = 1;
    let ASPECT = 1;   // W/H, so spacing stays circular on a wide stage

    const resize = () => {
      dpr = Math.min(window.devicePixelRatio || 1, 2);
      W = mount.clientWidth;
      H = mount.clientHeight;
      canvas.width = W * dpr;
      canvas.height = H * dpr;
      canvas.style.width = W + 'px';
      canvas.style.height = H + 'px';
      ASPECT = H === 0 ? 1 : W / H;
      ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
    };
    resize();

    /* ---- one pre-rendered tile per technology ---------------------------- */

    const base = (window.__ithriveBase || '/') + 'assets/img/tech/';

    const tiles = STACK.map(([name, colour], i) => {
      const tile = document.createElement('canvas');
      tile.width = tile.height = TILE * 2;          // 2x for crispness
      const g = tile.getContext('2d');

      // The plate: a dark rounded square, like an app icon.
      const R = 26;
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
      fetch(base + name + '.svg')
        .then((r) => (r.ok ? r.text() : Promise.reject(new Error(String(r.status)))))
        .then((svg) => {
          svg = svg
            .replace(/<svg([^>]*)>/, '<svg$1 width="72" height="72">')
            .replace(/<path/g, `<path fill="${colour}"`);

          const img = new Image();
          img.onload = () => g.drawImage(img, 26, 26, 72, 72);
          img.src = 'data:image/svg+xml;charset=utf-8,' + encodeURIComponent(svg);
        })
        .catch(() => { /* a missing icon is an empty plate, not a crash */ });

      return { canvas: tile, name, i };
    });

    /* ---- the chain ------------------------------------------------------- */

    // Everything starts scattered, so the section reads as a field before the
    // cursor ever arrives.
    const links = tiles.map((t, i) => {
      const a = i * 2.39996;
      const r = 0.16 + Math.sqrt(i / tiles.length) * 0.46;

      return {
        tile: t,
        x: 0.5 + Math.cos(a) * r,     // fractions of the stage, so resize is free
        y: 0.5 + Math.sin(a) * r * 0.9,
        px: 0, py: 0,
        homeA: a, homeR: r,
      };
    });

    const pointer = { x: 0.5, y: 0.5, active: false };
    let isReleased = () => false;

    const onMove = (e) => {
      const r = mount.getBoundingClientRect();
      const inside = e.clientX >= r.left && e.clientX <= r.right
                  && e.clientY >= r.top  && e.clientY <= r.bottom;
      pointer.active = inside;
      if (!inside) return;
      pointer.x = (e.clientX - r.left) / r.width;
      pointer.y = (e.clientY - r.top) / r.height;
    };
    window.addEventListener('pointermove', onMove, { passive: true });
    mount.addEventListener('pointerleave', () => { pointer.active = false; });

    /**
     * Click to send the stack home.
     *
     * The chain follows the cursor for as long as it is over the field, so
     * without this there is no way to see the whole stack laid out again short
     * of moving the mouse away. A click releases it, and it eases back to its
     * scattered home positions.
     */
    let releasedUntil = 0;
    const onClick = () => { releasedUntil = performance.now() + 2600; };
    mount.addEventListener('click', onClick);
    isReleased = () => performance.now() < releasedUntil;

    let visible = true;
    const io = 'IntersectionObserver' in window
      ? new IntersectionObserver(([e]) => { visible = e.isIntersecting; }, { threshold: 0 })
      : null;
    if (io) io.observe(mount);

    const ro = 'ResizeObserver' in window ? new ResizeObserver(resize) : null;
    if (ro) ro.observe(mount);
    window.addEventListener('resize', resize);

    let raf = 0;
    let t = 0;

    const frame = () => {
      raf = requestAnimationFrame(frame);
      if (!visible || W === 0) return;

      t += 0.006;
      ctx.clearRect(0, 0, W, H);

      // --- 1. the head -----------------------------------------------------
      const head = links[0];

      const following = pointer.active && !reduce && !isReleased();

      if (following) {
        // Only the head is eased. Everything behind it is solved, not eased —
        // easing each link meant the tail could never satisfy its spacing and
        // simply piled up in the middle.
        head.x += (pointer.x - head.x) * 0.22;
        head.y += (pointer.y - head.y) * 0.22;
      } else {
        const a = head.homeA + t * 0.35;
        head.x += ((0.5 + Math.cos(a) * head.homeR) - head.x) * 0.035;
        head.y += ((0.5 + Math.sin(a) * head.homeR * 0.9) - head.y) * 0.035;
      }

      // --- 2. the rest: follow the leader ---------------------------------
      for (let i = 1; i < links.length; i++) {
        const link = links[i];
        const lead = links[i - 1];

        if (following) {
          // Hold exactly SPACING behind the link in front, measured in a
          // square space so the gap is circular on a wide stage.
          const dx = link.x - lead.x;
          const dy = (link.y - lead.y) * ASPECT;
          const d = Math.hypot(dx, dy) || 1;
          link.x = lead.x + (dx / d) * SPACING;
          link.y = lead.y + (dy / d) * (SPACING / ASPECT);
        } else {
          const a = link.homeA + t * 0.35;
          link.x += ((0.5 + Math.cos(a) * link.homeR) - link.x) * 0.035;
          link.y += ((0.5 + Math.sin(a) * link.homeR * 0.9) - link.y) * 0.035;
        }
      }

      // --- 3. draw, back of the tail first so the head sits on top ---------
      for (let i = links.length - 1; i >= 0; i--) {
        const link = links[i];
        const cx = link.x * W;
        const cy = link.y * H;

        // Lean into the direction of travel — a static tile in a moving chain
        // reads as a bug.
        const vx = cx - link.px;
        const vy = cy - link.py;
        link.px = cx;
        link.py = cy;
        const tilt = Math.max(-0.4, Math.min(0.4, (vx + vy) * 0.010));

        const size = TILE * (1 - (i / links.length) * 0.14);

        ctx.save();
        ctx.translate(cx, cy);
        ctx.rotate(tilt);
        ctx.globalAlpha = 1 - (i / links.length) * 0.18;
        ctx.drawImage(link.tile.canvas, -size / 2, -size / 2, size, size);
        ctx.restore();
      }
    };
    frame();

    return () => {
      cancelAnimationFrame(raf);
      window.removeEventListener('pointermove', onMove);
      mount.removeEventListener('click', onClick);
      window.removeEventListener('resize', resize);
      if (io) io.disconnect();
      if (ro) ro.disconnect();
      if (canvas.parentNode) canvas.parentNode.removeChild(canvas);
    };
  }, []);

  return (
    <section id="tech-magnet" className="py-20 md:py-28 relative bg-slate-950 border-t border-slate-800/80 overflow-hidden">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

        <div className="text-center max-w-3xl mx-auto space-y-4 mb-4">
          <h2 className="text-3xl sm:text-4xl md:text-5xl font-black font-heading tracking-tight text-slate-100">
            Always Building, <MouseOverText text="Always Growing." variant="glow" className="text-cyan-400" />
          </h2>
        </div>

        <div ref={mountRef} className="tech-magnet-stage" aria-hidden="true" />

        {/* The real list, for anyone without canvas and for search engines. */}
        <ul className="sr-only">
          {STACK.map(([name]) => <li key={name}>{name}</li>)}
        </ul>

      </div>
    </section>
  );
}
