/**
 * Scroll warp — the way unseen.co/projects behaves as you roll through it.
 *
 * Their version renders the whole page into a WebGL context and distorts the
 * texture. Measured at rest and mid-scroll, what that actually produces is:
 * cards shear and lean with scroll speed, their edges ripple while moving and
 * go crisp when you stop, colour splits slightly at the edges, and grain sits
 * over everything.
 *
 * All of that is reproduced here without a texture pass, for one reason worth
 * stating: rendering the DOM into WebGL means the text is pixels, and this is a
 * section full of client names and outcomes on a page that has to rank. The
 * shear, lean and colour split are CSS transforms fed one custom property; the
 * ripple is an SVG displacement filter whose scale this drives. The words stay
 * words.
 *
 * Two signals are published per frame:
 *
 *   --vel    signed scroll velocity, roughly -1..1 — drives shear and split
 *   --depth  where the card sits relative to the viewport centre, -1..1 —
 *            drives the perspective lean, so the grid has real depth standing
 *            still rather than only while moving
 *
 * Skipped under prefers-reduced-motion and on coarse pointers, where a
 * momentum-scrolling device would fight it.
 */

(function () {
  'use strict';

  const scope = document.querySelector('[data-warp]');
  if (!scope) return;

  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
  if (window.matchMedia('(pointer: coarse)').matches) return;

  const items = Array.from(scope.querySelectorAll('[data-warp-item], .case-card'));
  if (!items.length) return;

  /* ---- the ripple filter ----------------------------------------------- */

  // Injected rather than written into the page, because it is an implementation
  // detail of this effect and means nothing without the script.
  const NS = 'http://www.w3.org/2000/svg';
  const svg = document.createElementNS(NS, 'svg');
  svg.setAttribute('width', '0');
  svg.setAttribute('height', '0');
  svg.setAttribute('aria-hidden', 'true');
  svg.style.cssText = 'position:absolute;width:0;height:0;overflow:hidden';
  svg.innerHTML =
    '<filter id="warp-ripple" x="-6%" y="-6%" width="112%" height="112%" color-interpolation-filters="sRGB">'
    + '<feTurbulence type="fractalNoise" baseFrequency="0.006 0.013" numOctaves="2" seed="7" result="n"/>'
    + '<feDisplacementMap in="SourceGraphic" in2="n" scale="0" xChannelSelector="R" yChannelSelector="G"/>'
    + '</filter>';
  document.body.appendChild(svg);

  const displace = svg.querySelector('feDisplacementMap');
  const turbulence = svg.querySelector('feTurbulence');

  /* ---- state ----------------------------------------------------------- */

  let lastY = window.scrollY;
  let velocity = 0;     // smoothed, in pixels per frame
  let onScreen = false;
  let moving = false;
  let drift = 0;

  const clamp = (v, a, b) => (v < a ? a : v > b ? b : v);

  function frame() {
    requestAnimationFrame(frame);

    // lastY is updated whether or not the section is visible. Skipping it while
    // off screen meant the first frame back computed the whole intervening
    // scroll as one delta and slammed the grid to full deflection.
    const y = window.scrollY;
    const raw = onScreen ? y - lastY : 0;
    lastY = y;

    // Off screen, relax to rest and stop writing. Returning early instead left
    // the last velocity latched, so the cards stayed sheared and the ripple
    // stayed at whatever scale it had when the section left the viewport.
    if (!onScreen) {
      if (velocity !== 0 || moving) {
        velocity = 0;
        moving = false;
        scope.classList.remove('warp--moving');
        displace.setAttribute('scale', '0');
        scope.style.setProperty('--vel', '0');
        scope.style.setProperty('--speed', '0');
      }
      return;
    }

    // Heavier smoothing on the way down than up, so it snaps into the warp and
    // relaxes out of it. Symmetric easing reads like lag rather than momentum.
    const target = clamp(raw / 34, -1.6, 1.6);
    velocity += (target - velocity) * (Math.abs(target) > Math.abs(velocity) ? 0.34 : 0.11);
    if (Math.abs(velocity) < 0.002) velocity = 0;

    const speed = Math.abs(velocity);

    // The filter is expensive on large elements, so it is attached only while
    // there is actually something to see and detached the moment there is not.
    const shouldMove = speed > 0.012;
    if (shouldMove !== moving) {
      moving = shouldMove;
      scope.classList.toggle('warp--moving', moving);
    }

    if (moving) {
      // Capped as well as scaled: past about a dozen pixels of displacement the
      // cards stop reading as warped and start reading as broken.
      displace.setAttribute('scale', Math.min(13, speed * 17).toFixed(2));
      // Crawling the noise field stops the ripple from looking like a fixed
      // pane of bad glass the cards slide behind.
      drift += speed * 0.004;
      turbulence.setAttribute('baseFrequency', (0.006 + Math.sin(drift) * 0.0022).toFixed(5) + ' 0.013');
    }

    scope.style.setProperty('--vel', velocity.toFixed(4));
    scope.style.setProperty('--speed', speed.toFixed(4));

    const mid = window.innerHeight / 2;
    for (const el of items) {
      const r = el.getBoundingClientRect();
      const centre = r.top + r.height / 2;
      el.style.setProperty('--depth', clamp((centre - mid) / mid, -1, 1).toFixed(4));
    }
  }

  if ('IntersectionObserver' in window) {
    new IntersectionObserver(([e]) => { onScreen = e.isIntersecting; }, { threshold: 0 }).observe(scope);
  } else {
    onScreen = true;
  }

  scope.classList.add('warp--live');
  requestAnimationFrame(frame);
})();
