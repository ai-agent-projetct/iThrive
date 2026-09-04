/**
 * The Game Development page's own behaviour.
 *
 * The hero is a playable endless flight — steer the ship, thread the spires,
 * the score counts what you pass. The recording the page was briefed from is a
 * game rather than a still, so the hero is a game.
 *
 * WHY IT IS BUILT THIS WAY. A game needs animation frames; that is not
 * negotiable. What IS negotiable is what happens when they do not come, and on
 * this site that matters more than usual — nine components have shipped
 * blank because they computed their layout inside requestAnimationFrame.
 *
 * So the game draws ON TOP of the CSS scene rather than replacing it. Every
 * moon, dune, spire and the ship itself are placed by CSS from their own custom
 * properties. With no script, a dead frame loop or reduced motion, the hero is
 * still the correct still landscape. The game only ever adds to it.
 *
 * Obstacles are DOM nodes moved by transform, not a canvas. A canvas would need
 * its own resize plumbing and would paint nothing at all if a frame were
 * missed, where these simply stop where they are.
 */
(function () {
  'use strict';

  const hero = document.querySelector('[data-flight]');

  /* ======================================================================
     Industries — one card open at a time.
     Set up first, so a failure in the game below cannot take it down.
     ====================================================================== */

  const cards = Array.from(document.querySelectorAll('[data-ind-card]'));

  if (cards.length) {
    const open = (card) => {
      for (const other of cards) {
        const on = other === card;
        other.classList.toggle('is-open', on);
        other.setAttribute('aria-expanded', on ? 'true' : 'false');
      }
    };

    for (const card of cards) {
      card.addEventListener('click', () => open(card));

      /* role="button" carries no keyboard behaviour of its own. */
      card.addEventListener('keydown', (e) => {
        if (e.key !== 'Enter' && e.key !== ' ') return;
        e.preventDefault();
        open(card);
      });
    }
  }

  if (!hero) return;

  const ship = hero.querySelector('[data-ship]');
  const field = hero.querySelector('[data-obstacles]');
  const overlay = hero.querySelector('[data-overlay]');
  const overlayTitle = hero.querySelector('[data-overlay-title]');
  const overlaySub = hero.querySelector('[data-overlay-sub]');
  const startBtn = hero.querySelector('[data-start]');
  const hud = hero.querySelector('[data-hud]');
  const scoreEl = hero.querySelector('[data-score]');
  const bestEl = hero.querySelector('[data-best]');

  if (!ship || !field || !overlay || !startBtn) return;

  /* ----------------------------------------------------------------------
     Tuning. All of it lives here rather than being scattered through the loop.
     ---------------------------------------------------------------------- */

  /* Lanes are in "world units" either side of centre. The ship and every
     obstacle share this space, so a collision is a comparison of two numbers. */
  const HALF_WIDTH = 1;

  /* z is depth: 1 at the horizon, 0 at the camera. */
  const SPAWN_Z = 1;
  const HIT_Z = 0.055;

  const START_SPEED = 0.34;      /* z units per second */
  const MAX_SPEED = 0.92;
  const RAMP = 0.016;            /* speed added per obstacle passed */

  const SPAWN_EVERY = 0.62;      /* seconds, at the start */
  const SPAWN_FLOOR = 0.3;

  const STEER = 2.1;             /* world units per second on the keyboard */
  const HIT_WIDTH = 0.17;        /* how close counts as a collision */

  /* A frame longer than this is a tab that was backgrounded, not a slow one.
     Without the clamp the ship teleports through a spire on the way back. */
  const MAX_STEP = 0.05;

  const reduced = window.matchMedia('(prefers-reduced-motion: reduce)');

  /* ----------------------------------------------------------------------
     State
     ---------------------------------------------------------------------- */

  let running = false;
  let raf = 0;
  let last = 0;
  let sinceSpawn = 0;

  let shipX = 0;        /* world units, -HALF_WIDTH .. HALF_WIDTH */
  let targetX = 0;      /* where the pointer wants it */
  let speed = START_SPEED;
  let score = 0;
  let best = 0;

  const keys = { left: false, right: false };
  const obstacles = [];

  try {
    best = Number(window.localStorage.getItem('ithrive-flight-best') || 0) || 0;
  } catch (e) {
    /* Private windows and blocked site data throw on access, not on read. */
    best = 0;
  }

  const showBest = () => {
    if (bestEl) bestEl.textContent = best ? 'best ' + best : '';
  };

  showBest();

  /* ----------------------------------------------------------------------
     Placing things
     ---------------------------------------------------------------------- */

  /*
   * Perspective, deliberately simple.
   *
   * An obstacle at depth z sits at screen position:
   *   scale  grows as z falls, so near things are big
   *   y      runs from the horizon down to the bottom of the stage
   *   x      is its lane offset from the ship, widened by the same scale
   *
   * Matching the CSS scene matters more than being physically correct: the
   * horizon in game.css is at 47%, so that is where z = 1 lands.
   */
  const HORIZON = 0.47;
  const FLOOR = 0.86;

  const place = (el, x, z) => {
    const k = 1 / (z + 0.22);
    const depth = 1 - z;

    const px = 50 + (x - shipX) * k * 15;
    const py = (HORIZON + (FLOOR - HORIZON) * depth * depth) * 100;

    el.style.transform =
      'translate3d(' + px.toFixed(2) + 'vw, ' + py.toFixed(2) + 'vh, 0)'
      + ' translate(-50%, -100%) scale(' + (k * 0.3).toFixed(3) + ')';
    el.style.opacity = z > 0.9 ? String((1 - z) * 10) : '1';
  };

  const placeShip = () => {
    /* The ship banks into its own movement, which is the only cue the player
       gets that a steer has registered before the position visibly changes. */
    const lean = (targetX - shipX) * 26;
    ship.style.setProperty('--lx', (shipX * 26).toFixed(2) + 'vw');
    ship.style.setProperty('--bank', lean.toFixed(2) + 'deg');
  };

  /* ----------------------------------------------------------------------
     The run
     ---------------------------------------------------------------------- */

  const spawn = () => {
    const el = document.createElement('span');
    el.className = 'gm-obstacle';

    /* Never directly on top of the ship at spawn — that is a death the player
       could not have avoided, which reads as the game cheating. */
    let x = (Math.random() * 2 - 1) * HALF_WIDTH;
    if (Math.abs(x - shipX) < 0.22) x += x >= shipX ? 0.3 : -0.3;
    x = Math.max(-HALF_WIDTH, Math.min(HALF_WIDTH, x));

    const tall = Math.random() < 0.72;
    el.classList.add(tall ? 'gm-obstacle--spire' : 'gm-obstacle--tree');
    if (!tall) {
      el.innerHTML =
        '<svg viewBox="0 0 40 60" aria-hidden="true">'
        + '<path d="M20 60 V22 M20 30 L9 16 M20 34 L31 20 M20 44 L11 34 M20 26 L26 12"'
        + ' stroke="currentColor" stroke-width="3.4" stroke-linecap="round" fill="none"/></svg>';
    }

    const ob = { el, x, z: SPAWN_Z, scored: false };
    place(el, x, SPAWN_Z);
    field.appendChild(el);
    obstacles.push(ob);
  };

  const clearField = () => {
    for (const ob of obstacles) ob.el.remove();
    obstacles.length = 0;
  };

  const setOverlay = (title, sub, button) => {
    if (overlayTitle) overlayTitle.textContent = title;
    if (overlaySub) overlaySub.textContent = sub;
    startBtn.innerHTML = button + startBtn.querySelector('svg').outerHTML;
  };

  const crash = () => {
    running = false;
    cancelAnimationFrame(raf);
    raf = 0;
    hero.classList.remove('is-playing');
    hero.classList.add('is-over');

    if (score > best) {
      best = score;
      try {
        window.localStorage.setItem('ithrive-flight-best', String(best));
      } catch (e) {
        /* Nothing to do — the score simply is not remembered here. */
      }
      showBest();
    }

    setOverlay('You hit one', 'Score ' + score + (best ? ' · best ' + best : ''), 'Again');
    overlay.hidden = false;
    startBtn.focus();
  };

  const frame = (now) => {
    raf = 0;
    if (!running) return;

    const dt = Math.min(MAX_STEP, (now - last) / 1000 || 0);
    last = now;

    /* Steering: the pointer sets a target, the keyboard nudges it. */
    if (keys.left) targetX -= STEER * dt;
    if (keys.right) targetX += STEER * dt;
    targetX = Math.max(-HALF_WIDTH, Math.min(HALF_WIDTH, targetX));

    /* Ease toward it rather than snapping, so the ship has some weight. */
    shipX += (targetX - shipX) * Math.min(1, dt * 9);
    placeShip();

    sinceSpawn += dt;
    const every = Math.max(SPAWN_FLOOR, SPAWN_EVERY - score * 0.006);
    if (sinceSpawn >= every) {
      sinceSpawn = 0;
      spawn();
    }

    for (let i = obstacles.length - 1; i >= 0; i--) {
      const ob = obstacles[i];
      ob.z -= speed * dt;

      if (ob.z <= HIT_Z && !ob.scored) {
        ob.scored = true;

        if (Math.abs(ob.x - shipX) < HIT_WIDTH) {
          place(ob.el, ob.x, Math.max(0.01, ob.z));
          crash();

          return;
        }

        score++;
        speed = Math.min(MAX_SPEED, speed + RAMP);
        if (scoreEl) scoreEl.textContent = String(score);
      }

      if (ob.z <= -0.12) {
        ob.el.remove();
        obstacles.splice(i, 1);

        continue;
      }

      place(ob.el, ob.x, Math.max(0.01, ob.z));
    }

    raf = requestAnimationFrame(frame);
  };

  const start = () => {
    clearField();
    running = true;
    speed = START_SPEED;
    score = 0;
    sinceSpawn = 0;
    shipX = 0;
    targetX = 0;
    last = performance.now();

    if (scoreEl) scoreEl.textContent = '0';
    placeShip();

    overlay.hidden = true;
    hero.classList.remove('is-over');
    hero.classList.add('is-playing');
    if (hud) hud.removeAttribute('aria-hidden');

    raf = requestAnimationFrame(frame);
  };

  startBtn.addEventListener('click', start);

  /* ----------------------------------------------------------------------
     Controls
     ---------------------------------------------------------------------- */

  hero.addEventListener('pointermove', (e) => {
    const r = hero.getBoundingClientRect();
    const nx = (e.clientX - (r.left + r.width / 2)) / (r.width / 2);
    targetX = Math.max(-HALF_WIDTH, Math.min(HALF_WIDTH, nx * 1.15));

    /* Before a run starts the ship still answers the pointer, so the hero is
       alive to touch even while it is only a scene. */
    if (!running) {
      shipX += (targetX - shipX) * 0.25;
      placeShip();
    }
  });

  hero.addEventListener('pointerleave', () => {
    if (running) return;
    targetX = 0;
    shipX = 0;
    placeShip();
  });

  /* Touch: dragging anywhere in the hero steers, and the page must not scroll
     out from under the run while it does. */
  hero.addEventListener('touchmove', (e) => {
    if (!running) return;
    const t = e.touches[0];
    if (!t) return;
    const r = hero.getBoundingClientRect();
    const nx = (t.clientX - (r.left + r.width / 2)) / (r.width / 2);
    targetX = Math.max(-HALF_WIDTH, Math.min(HALF_WIDTH, nx * 1.15));
    e.preventDefault();
  }, { passive: false });

  window.addEventListener('keydown', (e) => {
    if (!running) return;
    if (e.key === 'ArrowLeft' || e.key === 'a' || e.key === 'A') keys.left = true;
    else if (e.key === 'ArrowRight' || e.key === 'd' || e.key === 'D') keys.right = true;
    else return;
    e.preventDefault();
  });

  window.addEventListener('keyup', (e) => {
    if (e.key === 'ArrowLeft' || e.key === 'a' || e.key === 'A') keys.left = false;
    if (e.key === 'ArrowRight' || e.key === 'd' || e.key === 'D') keys.right = false;
  });

  /* A run that continues in a tab nobody is looking at is a run the player
     loses without seeing it. Pause instead. */
  document.addEventListener('visibilitychange', () => {
    if (!document.hidden || !running) return;
    running = false;
    cancelAnimationFrame(raf);
    raf = 0;
    hero.classList.remove('is-playing');
    setOverlay('Paused', 'Score ' + score, 'Resume');
    overlay.hidden = false;
  });

  /* ----------------------------------------------------------------------
     Reduced motion: offer it, never start it unasked.
     ---------------------------------------------------------------------- */

  if (reduced.matches) {
    setOverlay('Fly it', 'Motion-heavy — press play when you want it', 'Play anyway');
  }
}());
