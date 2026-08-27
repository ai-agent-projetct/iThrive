/**
 * The Aleph hero — a particle field that changes state as you scroll.
 *
 * After amaterasu.ai/aleph. The reference renders its entire page into two
 * WebGL canvases with the scroll virtualised inside them; what it *does* is
 * simpler than that and is what this reproduces:
 *
 *   - A field of particles sits over the figure's head.
 *   - Scrolling advances through named scenes, and each scene puts the field in
 *     a different state: scattered, gathering, or settled into a lattice.
 *   - The copy for the current scene fades in as the previous one fades out.
 *   - A small-caps label at the bottom names the scene you are in.
 *
 * Canvas 2D rather than WebGL. It is a few hundred points with no lighting and
 * no depth buffer; a GL context for that is a context to lose, and this runs on
 * anything.
 *
 * Nothing here is load-bearing. Without it the figure, the heading and all
 * three leads are already in the markup and simply read.
 */

(function () {
  'use strict';

  const HOST = document.querySelector('[data-aleph]');
  if (!HOST) return;

  const canvas = HOST.querySelector('[data-aleph-field]');
  const leads = Array.from(HOST.querySelectorAll('[data-aleph-lead]'));
  const labelText = HOST.querySelector('[data-aleph-label-text]');
  if (!canvas || !leads.length) return;

  const ctx = canvas.getContext('2d');
  if (!ctx) return;

  const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  /* ---- the field -------------------------------------------------------- */

  const COUNT = 460;
  const NAVY = '27, 41, 120';    // #1B2978, measured off the reference
  const AQUA = '117, 205, 214';  // #75CDD6

  let W = 0, H = 0, dpr = 1;

  function resize() {
    dpr = Math.min(window.devicePixelRatio || 1, 2);
    W = canvas.clientWidth;
    H = canvas.clientHeight;
    canvas.width = Math.round(W * dpr);
    canvas.height = Math.round(H * dpr);
    ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
  }
  resize();
  window.addEventListener('resize', resize);
  if ('ResizeObserver' in window) new ResizeObserver(resize).observe(canvas);

  /*
   * Three homes per particle, one per state, all in 0..1 of the box:
   *
   *   chaos    scattered, no structure at all
   *   order    drawn into a disc — the same points, gathered
   *   lattice  settled onto a grid, which is what "order" resolves into
   *
   * Computed once. The scene change is then a lerp between two arrays rather
   * than a layout being recalculated every frame.
   */
  const parts = [];
  const COLS = Math.ceil(Math.sqrt(COUNT));

  for (let i = 0; i < COUNT; i++) {
    // Deterministic, so the field is the same on every load and nobody sees a
    // different composition from the one that was designed.
    const r1 = Math.abs(Math.sin(i * 12.9898) * 43758.5453) % 1;
    const r2 = Math.abs(Math.sin(i * 78.233) * 43758.5453) % 1;
    const a = i * 2.39996;                 // golden angle
    const rad = Math.sqrt(i / COUNT);

    parts.push({
      // scattered
      cx: 0.08 + r1 * 0.84,
      cy: 0.06 + r2 * 0.88,
      // gathered into a disc
      ox: 0.5 + Math.cos(a) * rad * 0.42,
      oy: 0.5 + Math.sin(a) * rad * 0.42,
      // settled onto a lattice
      lx: 0.16 + ((i % COLS) / (COLS - 1)) * 0.68,
      ly: 0.14 + (Math.floor(i / COLS) / (COLS - 1)) * 0.72,
      x: 0, y: 0,
      seed: r1 * 6.283,
    });
  }

  const STATES = { chaos: 0, order: 1, lattice: 2 };
  let target = 0;      // the state index we are heading toward
  let blend = 0;       // eased position between states

  function homeFor(p, state) {
    if (state <= 0) return [p.cx, p.cy];
    if (state >= 2) return [p.lx, p.ly];

    return [p.ox, p.oy];
  }

  /* ---- scenes ----------------------------------------------------------- */

  /*
   * Driven by the hero's own position, not by a wheel counter: the scene has to
   * agree with where the page actually is, or leaving and coming back leaves the
   * field in a state that does not match the copy on screen.
   */
  const LABELS = Array.from(HOST.querySelectorAll('[data-aleph-lead]'))
    .map((el) => el.dataset.alephLead);
  const SCENE_LABELS = ['From scattered to systematic', 'From noise to signal', 'Clear paths ahead'];

  let current = -1;

  function scene(i) {
    if (i === current) return;
    current = i;
    target = STATES[LABELS[i]] ?? 0;

    leads.forEach((el, n) => el.classList.toggle('is-on', n === i));
    if (labelText) labelText.textContent = SCENE_LABELS[i] || '';
  }

  function measure() {
    const r = HOST.getBoundingClientRect();
    const range = r.height - window.innerHeight;
    const p = range <= 0 ? 0 : Math.min(1, Math.max(0, -r.top / range));
    // Three scenes over the hero's scroll length.
    scene(Math.min(leads.length - 1, Math.floor(p * leads.length)));
  }

  let ticking = false;
  window.addEventListener('scroll', () => {
    if (ticking) return;
    ticking = true;
    requestAnimationFrame(() => { ticking = false; measure(); });
  }, { passive: true });
  measure();

  /* ---- loop ------------------------------------------------------------- */

  let onScreen = true, raf = 0, t = 0, last = 0;

  if ('IntersectionObserver' in window) {
    new IntersectionObserver(([e]) => { onScreen = e.isIntersecting; }, { threshold: 0 }).observe(HOST);
  }

  function frame(now) {
    raf = requestAnimationFrame(frame);
    if (!onScreen || !W) { last = now; return; }

    const dt = last ? Math.min((now - last) / 1000, 0.05) : 0;
    last = now;
    t += dt;

    blend += (target - blend) * Math.min(1, dt * 2.4);

    ctx.clearRect(0, 0, W, H);

    const lo = Math.floor(blend);
    const hi = Math.min(2, lo + 1);
    const k = blend - lo;
    // 0 scattered, 1 settled — drives how tight and how bright the field reads.
    const settled = blend / 2;

    for (const p of parts) {
      const [ax, ay] = homeFor(p, lo);
      const [bx, by] = homeFor(p, hi);
      let x = ax + (bx - ax) * k;
      let y = ay + (by - ay) * k;

      // A slow drift that never stops, strongest while scattered — a field that
      // is perfectly still reads as a printed dot pattern rather than as points.
      if (!reduce) {
        const wob = 0.012 * (1 - settled * 0.75);
        x += Math.sin(t * 0.6 + p.seed) * wob;
        y += Math.cos(t * 0.48 + p.seed * 1.3) * wob;
      }

      p.x = x * W;
      p.y = y * H;

      const size = 1.1 + settled * 1.5;
      ctx.beginPath();
      ctx.arc(p.x, p.y, size, 0, Math.PI * 2);
      ctx.fillStyle = 'rgba(' + (settled > 0.55 ? AQUA : NAVY) + ',' + (0.3 + settled * 0.55).toFixed(3) + ')';
      ctx.fill();
    }

    /*
     * Once the field has settled, join near neighbours. Only then: drawing the
     * links while the points are still scattered turns the whole box into a
     * grey haze, which is the opposite of what the state is meant to say.
     */
    if (settled > 0.55) {
      const reach = 46 * (W / 460);
      ctx.lineWidth = 1;
      ctx.strokeStyle = 'rgba(' + AQUA + ',' + ((settled - 0.55) * 0.5).toFixed(3) + ')';
      ctx.beginPath();
      for (let i = 0; i < parts.length; i++) {
        for (let j = i + 1; j < parts.length; j++) {
          const dx = parts[i].x - parts[j].x;
          if (dx > reach || dx < -reach) continue;
          const dy = parts[i].y - parts[j].y;
          if (dy > reach || dy < -reach) continue;
          if (dx * dx + dy * dy > reach * reach) continue;
          ctx.moveTo(parts[i].x, parts[i].y);
          ctx.lineTo(parts[j].x, parts[j].y);
        }
      }
      ctx.stroke();
    }
  }

  raf = requestAnimationFrame(frame);
  HOST.classList.add('alx--live');
})();
