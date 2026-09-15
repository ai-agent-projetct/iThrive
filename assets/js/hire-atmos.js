/**
 * The hire page's atmosphere.
 *
 * One persistent WebGL field fixed behind the whole document — not a canvas
 * boxed into a single section — so scrolling feels like moving through one
 * continuous space rather than past a stack of panels. The section markers
 * float in that same space and are clickable, and content rises as it enters.
 *
 * Three rules it keeps:
 *
 *  - The markers are real <a href="#section"> anchors, positioned by projecting
 *    a 3D point through the field's camera. An anchor is focusable, announced,
 *    crawlable and keyboard-operable; a hit-tested pixel is none of those.
 *
 *  - Nothing here creates content or navigation. No WebGL, reduced motion, or
 *    this file blocked and the markers stay a plain wrapped row of in-page
 *    links and every section is still reachable. The CSS resting state is the
 *    visible one.
 *
 *  - It is decoration, so it stops when nobody is looking: the field pauses on
 *    a hidden tab, and the whole thing is skipped outright under reduced
 *    motion.
 */

import * as THREE from 'three';

const page = document.querySelector('.hire-atmos');
if (page) boot(page);

function boot(page) {
  const still = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  rise(page, still);
  if (still) return;

  const view = field(page);
  markers(page, view);
}

/* ---------------------------------------------------------------------------
   1. Content rises as it enters

   Same guarantee as everywhere else on this site: the hidden state is created
   by script, so it must never outlive what undoes it. A hidden document gets
   no IntersectionObserver callbacks at all, so nothing is hidden until the
   document is visibly rendering.
   --------------------------------------------------------------------------- */

function rise(page, still) {
  const targets = page.querySelectorAll('[data-rise]');
  if (!targets.length) return;

  // Reveal == back to the CSS resting state, which is already visible.
  const showAll = () => targets.forEach((el) => {
    el.classList.remove('is-armed');
    el.classList.add('is-in');
  });

  if (still || !('IntersectionObserver' in window)) { showAll(); return; }

  if (document.hidden) {
    // Nothing is armed here on purpose. A document that is not visibly
    // rendering receives no IntersectionObserver callbacks, so arming it now
    // would hide every section of the page with nothing able to unhide it.
    // Wait until it is genuinely being looked at.
    document.addEventListener('visibilitychange', function once() {
      if (document.hidden) return;
      document.removeEventListener('visibilitychange', once);
      arm();
    });
    return;
  }

  arm();

  function arm() {
    // Hide only now, when the observer below can be relied on to unhide.
    targets.forEach((el) => el.classList.add('is-armed'));

    let heard = false;
    const io = new IntersectionObserver((entries) => {
      heard = true;
      entries.forEach((e) => {
        if (!e.isIntersecting) return;
        e.target.classList.add('is-in');
        io.unobserve(e.target);
      });
    }, { rootMargin: '0px 0px -10% 0px', threshold: 0.08 });

    targets.forEach((el) => io.observe(el));

    // If the observer delivers nothing at all, it is broken rather than simply
    // waiting for a scroll — reveal everything rather than strand the page.
    setTimeout(() => { if (!heard) { showAll(); io.disconnect(); } }, 4000);
  }
}

/* ---------------------------------------------------------------------------
   2. The persistent field

   A slow drift of points filling the viewport, tinted from the page's own
   accents so the canvas and the CSS never disagree about what colour the page
   is. Scroll pushes it gently, which is what ties it to the document.
   --------------------------------------------------------------------------- */

function field(page) {
  const host = page.querySelector('.hire-field');
  if (!host) return null;

  let renderer;
  try {
    renderer = new THREE.WebGLRenderer({ antialias: false, alpha: true, powerPreference: 'low-power' });
  } catch (err) {
    return null; // the CSS gradient behind it is a complete fallback
  }

  const W = () => window.innerWidth;
  const H = () => window.innerHeight;

  renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 1.5));
  renderer.setSize(W(), H());
  host.appendChild(renderer.domElement);

  const scene = new THREE.Scene();
  const camera = new THREE.PerspectiveCamera(55, W() / H(), 0.1, 300);
  camera.position.z = 40;

  const css = getComputedStyle(page);
  const tint = (name, fallback) => {
    try { return new THREE.Color(css.getPropertyValue(name).trim() || fallback); }
    catch (err) { return new THREE.Color(fallback); }
  };

  // Two drifting shells, one per accent, so the field carries the page's own
  // gradient rather than a single flat colour.
  const shells = [
    { colour: tint('--cyan', '#00F2FE'), count: 1400, spread: 78, size: 0.16, speed: 0.020 },
    { colour: tint('--purple', '#9D4EDD'), count: 900, spread: 92, size: 0.21, speed: 0.013 },
  ].map((s) => {
    const pos = new Float32Array(s.count * 3);
    for (let i = 0; i < s.count; i++) {
      pos[i * 3] = (Math.random() - 0.5) * s.spread;
      pos[i * 3 + 1] = (Math.random() - 0.5) * s.spread * 0.75;
      pos[i * 3 + 2] = (Math.random() - 0.5) * 70 - 10;
    }
    const geo = new THREE.BufferGeometry();
    geo.setAttribute('position', new THREE.BufferAttribute(pos, 3));
    const pts = new THREE.Points(geo, new THREE.PointsMaterial({
      size: s.size,
      color: s.colour,
      transparent: true,
      opacity: 0.55,
      blending: THREE.AdditiveBlending,
      depthWrite: false,
      sizeAttenuation: true,
    }));
    scene.add(pts);
    return { pts, speed: s.speed };
  });

  const ptr = { x: 0, y: 0, tx: 0, ty: 0 };
  window.addEventListener('pointermove', (e) => {
    ptr.tx = (e.clientX / window.innerWidth - 0.5) * 2;
    ptr.ty = (e.clientY / window.innerHeight - 0.5) * 2;
  }, { passive: true });

  let scrollN = 0, targetScrollN = 0, queued = false;
  const readScroll = () => {
    queued = false;
    const max = document.documentElement.scrollHeight - window.innerHeight;
    targetScrollN = max > 0 ? window.scrollY / max : 0;
  };
  window.addEventListener('scroll', () => {
    if (!queued) { queued = true; requestAnimationFrame(readScroll); }
  }, { passive: true });
  readScroll();

  const clock = new THREE.Clock();
  let running = true;

  document.addEventListener('visibilitychange', () => {
    const should = !document.hidden;
    if (should && !running) { running = true; clock.getDelta(); requestAnimationFrame(frame); }
    else if (!should) running = false;
  });

  function frame() {
    if (!running) return;
    requestAnimationFrame(frame);

    const dt = Math.min(clock.getDelta(), 0.05);
    const t = clock.elapsedTime;
    const k = 1 - Math.pow(0.02, dt);

    scrollN += (targetScrollN - scrollN) * k * 0.5;
    ptr.x += (ptr.tx - ptr.x) * k * 0.4;
    ptr.y += (ptr.ty - ptr.y) * k * 0.4;

    shells.forEach((s, i) => {
      s.pts.rotation.y = t * s.speed + scrollN * 0.5;
      s.pts.rotation.x = Math.sin(t * 0.07 + i) * 0.06 + scrollN * 0.18;
    });

    // Scroll travels the camera through the field, which is what makes the
    // whole document feel like one continuous space.
    camera.position.x = ptr.x * 3.2;
    camera.position.y = -ptr.y * 2 - scrollN * 10;
    camera.position.z = 40 - scrollN * 14;
    camera.lookAt(0, -scrollN * 8, 0);

    renderer.render(scene, camera);
  }
  frame();

  let timer;
  window.addEventListener('resize', () => {
    clearTimeout(timer);
    timer = setTimeout(() => {
      camera.aspect = W() / H();
      camera.updateProjectionMatrix();
      renderer.setSize(W(), H());
    }, 150);
  }, { passive: true });

  return { THREE, camera };
}

/* ---------------------------------------------------------------------------
   3. Section markers floating in the field
   --------------------------------------------------------------------------- */

function markers(page, view) {
  if (!view) return;

  const layer = page.querySelector('[data-nodes]');
  if (!layer) return;
  const nodes = [...layer.querySelectorAll('[data-node]')];
  if (!nodes.length) return;

  const { THREE, camera } = view;
  layer.classList.add('is-live');

  // A shallow ring, tilted, so the markers read as a constellation rather than
  // a carousel.
  const R = 11;
  const base = nodes.map((el, i) => {
    const a = (i / nodes.length) * Math.PI * 2;
    return new THREE.Vector3(Math.cos(a) * R, Math.sin(a * 2) * 1.6, Math.sin(a) * R * 0.55);
  });

  const world = base.map(() => new THREE.Vector3());
  const dists = new Float64Array(nodes.length);
  const v = new THREE.Vector3();
  const euler = new THREE.Euler();
  const mat = new THREE.Matrix4();

  // The markers turn on their own, slowly. Hovering or focusing one holds the
  // whole ring still: a link that drifts while you aim at it is hard to hit,
  // and considerably worse for anyone with a motor impairment.
  let spin = 0, held = null, frame = 0;
  const hold = () => { if (held === null) held = spin; };
  const release = () => { held = null; };

  layer.addEventListener('pointerover', (e) => { if (e.target.closest('[data-node]')) hold(); });
  layer.addEventListener('pointerout', (e) => {
    if (!e.relatedTarget || !e.relatedTarget.closest?.('[data-node]')) release();
  });
  layer.addEventListener('focusin', hold);
  layer.addEventListener('focusout', release);

  // A drag that starts on a marker should not also navigate on release.
  nodes.forEach((el) => {
    let sx = 0, sy = 0, moved = false;
    el.addEventListener('pointerdown', (e) => { sx = e.clientX; sy = e.clientY; moved = false; });
    el.addEventListener('pointermove', (e) => {
      if (Math.abs(e.clientX - sx) > 6 || Math.abs(e.clientY - sy) > 6) moved = true;
    }, { passive: true });
    el.addEventListener('click', (e) => { if (moved) e.preventDefault(); });
  });

  const clock = new THREE.Clock();

  function tick() {
    frame = requestAnimationFrame(tick);

    const rect = layer.getBoundingClientRect();
    if (!rect.width || !rect.height) return;

    spin += clock.getDelta() * 0.12;
    euler.set(0.16, held !== null ? held : spin, 0, 'XYZ');
    mat.makeRotationFromEuler(euler);

    // Distance to the camera, NOT the z that .project() returns: that is
    // normalised device depth and strongly non-linear, so every marker would
    // land at nearly the same value and render the same size.
    let near = Infinity, far = -Infinity;
    for (let i = 0; i < nodes.length; i++) {
      world[i].copy(base[i]).applyMatrix4(mat);
      const d = world[i].distanceTo(camera.position);
      dists[i] = d;
      if (d < near) near = d;
      if (d > far) far = d;
    }
    const span = far - near || 1;

    for (let i = 0; i < nodes.length; i++) {
      v.copy(world[i]).project(camera);

      const depth = (dists[i] - near) / span;
      const el = nodes[i];
      el.style.transform =
        `translate(-50%, -50%) translate(${(v.x * 0.5 + 0.5) * rect.width}px, ` +
        `${(-v.y * 0.5 + 0.5) * rect.height}px) scale(${(1.03 - depth * 0.26).toFixed(3)})`;
      // Never fade below 0.5 — these are navigation, and a link nobody can read
      // is not navigation.
      el.style.opacity = (1 - depth * 0.5).toFixed(3);
      el.style.zIndex = String(1000 - Math.round(depth * 1000));
    }
  }
  tick();

  if ('IntersectionObserver' in window) {
    new IntersectionObserver(([e]) => {
      if (e.isIntersecting && !frame) { clock.getDelta(); tick(); }
      else if (!e.isIntersecting && frame) { cancelAnimationFrame(frame); frame = 0; }
    }).observe(layer);
  }
}
