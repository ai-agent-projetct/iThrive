/**
 * Agent floor — a flat render turned into a 3D scene you can walk your pointer
 * across.
 *
 * The depth is real perspective rather than a parallax fake: the stage owns a
 * `perspective`, and the plate and the marker plane are siblings inside it at
 * different `translateZ`. Rotating the shared parent therefore swings the
 * markers through a wider arc than the plate behind them, which is what reads
 * as depth. Nothing here positions the markers per frame — they are placed
 * once, in percentages, and the browser's own projection does the rest.
 *
 * This file only writes two custom properties (--rx, --ry) and toggles
 * classes. All the transform maths lives in CSS, so it runs on the compositor
 * and a dropped frame costs nothing.
 *
 * Markup contract:
 *
 *   <div data-agent-floor>
 *     <div data-floor-tilt>            the element that rotates
 *       <img>                          the plate
 *       <div data-floor-markers>       the marker plane
 *         <button data-agent="…" style="--x:..%; --y:..%">
 *     <div data-floor-card>            detail panel, filled from the button
 */

const MAX_TILT = 7;      // degrees; past ~8 the plate's own perspective fights it
const EASE_BACK = 420;   // ms the stage takes to level out after the pointer leaves

export function initAgentFloor(root) {
  const tilt    = root.querySelector('[data-floor-tilt]');
  const card    = root.querySelector('[data-floor-card]');
  const buttons = [...root.querySelectorAll('[data-agent]')];
  if (!tilt || !buttons.length) return;

  const reduced = matchMedia('(prefers-reduced-motion: reduce)');
  let raf = 0, pending = null, settle = 0;

  /* One write per frame. Pointermove fires far faster than the compositor can
     use, and setting a custom property is a style invalidation either way. */
  function schedule(rx, ry) {
    pending = [rx, ry];
    if (raf) return;
    raf = requestAnimationFrame(() => {
      raf = 0;
      if (!pending) return;
      root.style.setProperty('--rx', pending[0].toFixed(2) + 'deg');
      root.style.setProperty('--ry', pending[1].toFixed(2) + 'deg');
    });
  }

  function onMove(e) {
    if (reduced.matches) return;
    const r = root.getBoundingClientRect();
    if (!r.width || !r.height) return;
    /* -0.5..0.5 from the centre. Y drives rotateX and is negated so the top
       edge leans away when the pointer is high — the direction a physical
       panel would tip. */
    const px = (e.clientX - r.left) / r.width  - 0.5;
    const py = (e.clientY - r.top)  / r.height - 0.5;
    clearTimeout(settle);
    root.classList.add('is-live');
    schedule(-py * MAX_TILT * 2, px * MAX_TILT * 2);
  }

  function level() {
    clearTimeout(settle);
    schedule(0, 0);
    /* Held on for the length of the transition so the class does not drop
       mid-ease and snap the stage flat. */
    settle = setTimeout(() => root.classList.remove('is-live'), EASE_BACK);
  }

  function select(btn) {
    buttons.forEach(b => b.classList.toggle('is-on', b === btn));
    if (!card) return;
    if (!btn) { card.hidden = true; return; }
    card.querySelector('[data-floor-card-n]').textContent    = btn.dataset.n || '';
    card.querySelector('[data-floor-card-name]').textContent = btn.dataset.agent;
    card.querySelector('[data-floor-card-desc]').textContent = btn.dataset.desc || '';
    card.hidden = false;
  }

  root.addEventListener('pointermove', onMove);
  root.addEventListener('pointerleave', () => { level(); select(null); });

  buttons.forEach(btn => {
    /* pointerenter rather than mouseover: it does not bubble from children and
       does not fire on touch, where the tap below is the real gesture. */
    btn.addEventListener('pointerenter', () => select(btn));
    btn.addEventListener('focus', () => select(btn));
    btn.addEventListener('click', e => {
      e.preventDefault();
      select(btn.classList.contains('is-on') ? null : btn);
    });
  });

  /* Escape clears the selection wherever focus happens to be inside the
     stage — a keyboard user should not have to tab out to dismiss the card. */
  root.addEventListener('keydown', e => {
    if (e.key === 'Escape') { select(null); root.blur(); }
  });

  reduced.addEventListener('change', () => { if (reduced.matches) schedule(0, 0); });
}

document.querySelectorAll('[data-agent-floor]').forEach(initAgentFloor);
