/**
 * Clickable section nodes, orbiting inside the galaxy.
 *
 * The galaxy on services.php is decorative: you can drag it, but you cannot
 * click into it, and the links live in a flat grid underneath. Here the
 * sections of the page ARE the galaxy — each one is a marker sitting on the
 * disc, turning with it, and clicking one goes to that section.
 *
 * The markers are real <a href="#section"> elements, not shapes drawn into the
 * canvas. That matters: an anchor is focusable, announced by a screen reader,
 * followed by a crawler and works with the keyboard, none of which is true of
 * a hit-tested pixel. This script only positions them — it projects each one's
 * 3D point through the galaxy's own camera each frame and writes the result as
 * a transform.
 *
 * Which means the whole thing degrades into a plain list of in-page links: no
 * WebGL, reduced motion, or this file blocked and you still get every section
 * link, laid out by CSS. Nothing here creates content or navigation that does
 * not already exist without it.
 */

const stage = document.getElementById('galaxy-stage');
const layer = document.querySelector('[data-galaxy-nodes]');

if (stage && layer) {
  const nodes = [...layer.querySelectorAll('[data-galaxy-node]')];
  if (nodes.length) waitForGalaxy(stage, (view) => place(view, stage, layer, nodes));
}

/**
 * framer-galaxy.js boots asynchronously — it may still be importing Three.js —
 * so the hook it exposes is not there on our first look. Poll briefly, then
 * give up quietly and leave the CSS fallback in place.
 */
function waitForGalaxy(stage, ready) {
  if (stage.galaxyView) { ready(stage.galaxyView); return; }

  let tries = 0;
  const timer = setInterval(() => {
    if (stage.galaxyView) { clearInterval(timer); ready(stage.galaxyView); return; }
    if (++tries > 100) clearInterval(timer); // ~10s, then the flat list stands
  }, 100);
}

function place(view, stage, layer, nodes) {
  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

  const { THREE, camera } = view;

  layer.classList.add('is-live'); // CSS hands positioning over to us

  // Spread the markers around the disc, just outside the bright core so the
  // labels stay legible, and lift them off the plane a little so a marker at
  // the back is clearly behind rather than merely smaller.
  const RADIUS = 6.4;
  const points = nodes.map((el, i) => {
    const a = (i / nodes.length) * Math.PI * 2;
    return new THREE.Vector3(
      Math.cos(a) * RADIUS,
      Math.sin(a * 2) * 0.5,
      Math.sin(a) * RADIUS
    );
  });

  const v = new THREE.Vector3();
  const world = points.map(() => new THREE.Vector3());
  const dists = new Float64Array(points.length);
  const euler = new THREE.Euler();
  const mat = new THREE.Matrix4();

  let frame = 0;

  // Where the markers were when the pointer settled on one. The galaxy turns
  // continuously, and a link that is still drifting when you go to click it is
  // genuinely hard to hit -- badly so for anyone with a motor impairment, and
  // irritating for everyone else. So the moment a marker is hovered or focused
  // the whole ring holds still, and releases when you look away. The galaxy
  // behind carries on; only the navigation stops.
  let held = null;

  const hold = () => { if (!held) held = { rotX: view.rotX, rotY: view.rotY }; };
  const release = () => { held = null; };

  layer.addEventListener('pointerover', (e) => {
    if (e.target.closest('[data-galaxy-node]')) hold();
  });
  layer.addEventListener('pointerout', (e) => {
    // Ignore moving between two markers; only release on leaving them entirely.
    if (!e.relatedTarget || !e.relatedTarget.closest?.('[data-galaxy-node]')) release();
  });
  layer.addEventListener('focusin', hold);
  layer.addEventListener('focusout', release);

  function tick() {
    frame = requestAnimationFrame(tick);

    const rect = stage.getBoundingClientRect();
    if (!rect.width || !rect.height) return;

    // Match how Three applies an object's own rotation, so the markers turn
    // with the galaxy rather than drifting against it.
    euler.set(held ? held.rotX : view.rotX, held ? held.rotY : view.rotY, 0, 'XYZ');
    mat.makeRotationFromEuler(euler);

    // Rotate every marker into world space first, and measure how far each one
    // actually is from the camera.
    //
    // Deliberately NOT the z that .project() returns: that is normalised device
    // depth, which is strongly non-linear. With this camera's near plane at 0.1
    // and far at 100, every marker on a disc about seventeen units away lands
    // between 0.98 and 0.99, so using it made all seven the same size and the
    // same faint opacity. True distance separates them the way the eye expects.
    let near = Infinity, far = -Infinity;
    for (let i = 0; i < nodes.length; i++) {
      world[i].copy(points[i]).applyMatrix4(mat);
      const d = world[i].distanceTo(camera.position);
      dists[i] = d;
      if (d < near) near = d;
      if (d > far) far = d;
    }
    const span = far - near || 1;

    for (let i = 0; i < nodes.length; i++) {
      v.copy(world[i]).project(camera);

      const x = (v.x * 0.5 + 0.5) * rect.width;
      const y = (-v.y * 0.5 + 0.5) * rect.height;

      const depth = (dists[i] - near) / span; // 0 nearest, 1 furthest
      const scale = 1.04 - depth * 0.28;

      const el = nodes[i];
      el.style.transform = `translate(-50%, -50%) translate(${x}px, ${y}px) scale(${scale.toFixed(3)})`;
      // Never fade below 0.45: these are navigation, and a link nobody can read
      // is not navigation.
      el.style.opacity = (1 - depth * 0.55).toFixed(3);
      el.style.zIndex = String(1000 - Math.round(depth * 1000));
    }
  }

  tick();

  // Decoration: stop it when nobody is looking rather than spinning a phone's
  // GPU in a background tab.
  if ('IntersectionObserver' in window) {
    new IntersectionObserver(([e]) => {
      if (e.isIntersecting && !frame) tick();
      else if (!e.isIntersecting && frame) { cancelAnimationFrame(frame); frame = 0; }
    }).observe(stage);
  }

  document.addEventListener('visibilitychange', () => {
    if (document.hidden && frame) { cancelAnimationFrame(frame); frame = 0; }
    else if (!document.hidden && !frame) tick();
  });

  /* --- clicking versus dragging ---------------------------------------
     The galaxy starts a drag on pointerdown anywhere in the stage. Without
     this, grabbing the galaxy while the pointer happens to be over a marker
     would both spin it and then navigate on release. So a marker swallows the
     pointerdown, and only counts as a click if the pointer barely moved —
     a drag that begins on a marker still rotates the galaxy and goes nowhere. */

  nodes.forEach((el) => {
    let sx = 0, sy = 0, moved = false;

    el.addEventListener('pointerdown', (e) => {
      sx = e.clientX; sy = e.clientY; moved = false;
      e.stopPropagation();
    });

    el.addEventListener('pointermove', (e) => {
      if (Math.abs(e.clientX - sx) > 6 || Math.abs(e.clientY - sy) > 6) moved = true;
    }, { passive: true });

    el.addEventListener('click', (e) => {
      if (moved) { e.preventDefault(); return; }
      // Otherwise let the anchor do its own job: the href is a real fragment,
      // so history and the address bar stay correct without help.
    });
  });
}
