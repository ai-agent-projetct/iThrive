import React, { useEffect, useRef } from 'react';
import MouseOverText from './MouseOverText';

/**
 * Tech stack that comes to the pointer.
 *
 * A field of logo sprites drifting in 3D. Anything within reach of the cursor
 * is pulled toward it on a spring and scales up; let go and it eases back to
 * where it belongs. Nothing is on rails — the drift, the pull and the return
 * are all forces, which is what makes it feel physical rather than animated.
 *
 * Three.js r128 is already vendored for the hero's App Universe, so this
 * reuses that global rather than pulling a second copy into the bundle.
 */

const LOGOS = [
  'flutter', 'react', 'swift', 'kotlin',
  'typescript', 'nodedotjs', 'python', 'firebase',
  'graphql', 'postgresql', 'mongodb', 'redis',
  'docker', 'stripe', 'tailwindcss', 'amazonwebservices',
];

const THREE_SRC = 'assets/vendor/three128/three.min.js';

function loadThree() {
  if (window.THREE) return Promise.resolve();

  return new Promise((resolve, reject) => {
    const existing = document.querySelector(`script[data-universe="${THREE_SRC}"]`);
    if (existing) {
      if (existing.dataset.loaded) resolve();
      else existing.addEventListener('load', () => resolve(), { once: true });

      return;
    }
    const el = document.createElement('script');
    el.src = (window.__ithriveBase || '/') + THREE_SRC;
    el.dataset.universe = THREE_SRC;
    el.onload = () => { el.dataset.loaded = '1'; resolve(); };
    el.onerror = () => reject(new Error('three'));
    document.head.appendChild(el);
  });
}

export default function TechMagnetSection() {
  const mountRef = useRef(null);

  useEffect(() => {
    let stop = false;
    let cleanup = () => {};

    loadThree().then(() => {
      if (stop || !mountRef.current) return;

      const THREE = window.THREE;
      const mount = mountRef.current;
      const W = () => mount.clientWidth || 1;
      const H = () => mount.clientHeight || 1;

      const scene = new THREE.Scene();
      const camera = new THREE.PerspectiveCamera(46, W() / H(), 0.1, 100);
      camera.position.z = 15;

      let renderer;
      try {
        renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
      } catch {
        return;   // no WebGL: the logo list below still renders
      }
      renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
      renderer.setSize(W(), H());
      mount.appendChild(renderer.domElement);

      const base = (window.__ithriveBase || '/') + 'assets/img/tech/';
      const nodes = [];

      /**
       * Simple Icons ship a bare `<path>` with no fill, which defaults to
       * black — invisible on this background, and the reason the first attempt
       * rendered as black squares. So each icon is fetched, given an explicit
       * size and a white fill, and rasterised to a canvas texture.
       */
      function iconTexture(name) {
        const canvas = document.createElement('canvas');
        canvas.width = canvas.height = 128;
        const texture = new THREE.CanvasTexture(canvas);

        fetch(base + name + '.svg')
          .then((r) => (r.ok ? r.text() : Promise.reject(new Error(String(r.status)))))
          .then((svg) => {
            svg = svg
              .replace(/<svg([^>]*)>/, '<svg$1 width="128" height="128">')
              .replace(/<path/g, '<path fill="#EAF3FF"');

            const img = new Image();
            img.onload = () => {
              const g = canvas.getContext('2d');
              g.clearRect(0, 0, 128, 128);
              g.drawImage(img, 8, 8, 112, 112);
              texture.needsUpdate = true;
            };
            img.src = 'data:image/svg+xml;charset=utf-8,' + encodeURIComponent(svg);
          })
          .catch(() => { /* one missing icon is one missing sprite */ });

        return texture;
      }

      LOGOS.forEach((name, i) => {
        // Golden-angle placement so the field never looks gridded.
        const a = i * 2.39996;
        const r = 2.2 + Math.sqrt(i) * 1.55;
        const home = new THREE.Vector3(
          Math.cos(a) * r,
          Math.sin(a) * r * 0.62,
          (Math.random() - 0.5) * 3.5
        );

        const sprite = new THREE.Sprite(new THREE.SpriteMaterial({
          map: iconTexture(name),
          transparent: true,
          depthWrite: false,
        }));
        sprite.position.copy(home);
        sprite.scale.setScalar(1.5);
        scene.add(sprite);

        nodes.push({
          sprite,
          home,
          vel: new THREE.Vector3(),
          phase: Math.random() * Math.PI * 2,
          scale: 1.5,
          targetScale: 1.5,
        });
      });

      // Pointer in world units on the sprites' plane.
      const pointer = new THREE.Vector3(0, 0, 0);
      let hasPointer = false;

      const onMove = (e) => {
        const r = mount.getBoundingClientRect();
        if (e.clientX < r.left || e.clientX > r.right || e.clientY < r.top || e.clientY > r.bottom) {
          hasPointer = false;

          return;
        }
        hasPointer = true;
        const nx = ((e.clientX - r.left) / r.width) * 2 - 1;
        const ny = -((e.clientY - r.top) / r.height) * 2 + 1;
        // Unproject onto z=0 rather than guessing a scale factor.
        const v = new THREE.Vector3(nx, ny, 0.5).unproject(camera);
        const dir = v.sub(camera.position).normalize();
        pointer.copy(camera.position.clone().add(dir.multiplyScalar(-camera.position.z / dir.z)));
      };
      window.addEventListener('pointermove', onMove, { passive: true });

      const resize = () => {
        camera.aspect = W() / H();
        camera.updateProjectionMatrix();
        renderer.setSize(W(), H());
      };
      window.addEventListener('resize', resize);
      const ro = 'ResizeObserver' in window ? new ResizeObserver(resize) : null;
      if (ro) ro.observe(mount);

      let visible = true;
      const io = 'IntersectionObserver' in window
        ? new IntersectionObserver(([e]) => { visible = e.isIntersecting; }, { threshold: 0 })
        : null;
      if (io) io.observe(mount);

      const REACH = 4.2;
      const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
      const clock = new THREE.Clock();
      let raf = 0;

      const frame = () => {
        raf = requestAnimationFrame(frame);
        if (!visible) return;

        const t = clock.getElapsedTime();

        for (const n of nodes) {
          // Where it wants to be: its home, plus a slow idle drift.
          const target = n.home.clone();
          if (!reduce) {
            target.x += Math.sin(t * 0.5 + n.phase) * 0.28;
            target.y += Math.cos(t * 0.42 + n.phase) * 0.28;
          }

          n.targetScale = 1.5;

          if (hasPointer && !reduce) {
            const d = n.sprite.position.distanceTo(pointer);
            if (d < REACH) {
              // Closer means a stronger pull, and a bigger sprite.
              const pull = 1 - d / REACH;
              target.lerp(pointer, pull * 0.85);
              n.targetScale = 1.5 + pull * 1.15;
            }
          }

          // Spring toward the target, with damping so it settles.
          n.vel.add(target.sub(n.sprite.position).multiplyScalar(0.055));
          n.vel.multiplyScalar(0.86);
          n.sprite.position.add(n.vel);

          n.scale += (n.targetScale - n.scale) * 0.12;
          n.sprite.scale.setScalar(n.scale);
        }

        renderer.render(scene, camera);
      };
      frame();

      cleanup = () => {
        cancelAnimationFrame(raf);
        window.removeEventListener('pointermove', onMove);
        window.removeEventListener('resize', resize);
        if (ro) ro.disconnect();
        if (io) io.disconnect();
        renderer.dispose();
        if (renderer.domElement.parentNode) renderer.domElement.parentNode.removeChild(renderer.domElement);
      };
    }).catch(() => { /* the list below is the fallback */ });

    return () => { stop = true; cleanup(); };
  }, []);

  return (
    <section id="tech-magnet" className="py-20 md:py-28 relative bg-slate-950 border-t border-slate-800/80 overflow-hidden">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

        <div className="text-center max-w-3xl mx-auto space-y-4 mb-6">
          <h2 className="text-3xl sm:text-4xl md:text-5xl font-black font-heading tracking-tight text-slate-100">
            Always Building, <MouseOverText text="Always Growing." variant="glow" className="text-cyan-400" />
          </h2>
          <p className="text-slate-300 text-base sm:text-lg">
            Move your cursor through the stack — everything we build mobile products on comes to meet it.
          </p>
        </div>

        <div ref={mountRef} className="tech-magnet-stage" aria-hidden="true" />

        {/* The real list, for anyone without WebGL and for search engines. */}
        <ul className="sr-only">
          {LOGOS.map((l) => <li key={l}>{l}</li>)}
        </ul>

      </div>
    </section>
  );
}
