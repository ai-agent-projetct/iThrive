import React, { useEffect, useRef } from 'react';

/**
 * The App Universe 3D scene, mounted into the hero.
 *
 * The scene itself is vanilla Three.js in assets/js/universe.js — it is not
 * rewritten as a React component on purpose, so it stays a straight copy of the
 * source and can be re-synced when that file changes. This is only the mount
 * point and the loader for its scripts.
 *
 * The ids below are the ones the scene looks up (`canvas-container`, `loader`,
 * `tooltip`, `badge`, the three control buttons). The standalone version's
 * "App Universe / Realtime 3D Showcase" title block and FPS chip are left out:
 * inside a hero they read as a second page heading competing with the real one.
 */

const THREE_SCRIPTS = [
  'assets/vendor/three128/three.min.js',
  'assets/vendor/three128/OrbitControls.js',
  'assets/vendor/three128/CopyShader.js',
  'assets/vendor/three128/LuminosityHighPassShader.js',
  'assets/vendor/three128/EffectComposer.js',
  'assets/vendor/three128/RenderPass.js',
  'assets/vendor/three128/ShaderPass.js',
  'assets/vendor/three128/UnrealBloomPass.js',
  'assets/js/universe.js',
];

/** Load classic scripts strictly in order — each depends on the one before. */
function loadInOrder(urls) {
  return urls.reduce(
    (chain, url) => chain.then(() => new Promise((resolve, reject) => {
      const existing = document.querySelector(`script[data-universe="${url}"]`);
      if (existing) {
        if (existing.dataset.loaded) resolve();
        else existing.addEventListener('load', () => resolve(), { once: true });

        return;
      }

      const el = document.createElement('script');
      el.src = (window.__ithriveBase || '') + url;
      el.dataset.universe = url;
      el.onload = () => { el.dataset.loaded = '1'; resolve(); };
      el.onerror = () => reject(new Error('failed to load ' + url));
      document.head.appendChild(el);
    })),
    Promise.resolve()
  );
}

export default function AppUniverse() {
  const mountRef = useRef(null);

  useEffect(() => {
    let cancelled = false;

    loadInOrder(THREE_SCRIPTS)
      .then(() => {
        if (cancelled || !mountRef.current) return;
        if (typeof window.ithriveUniverse === 'function') window.ithriveUniverse(mountRef.current);
      })
      .catch((err) => {
        // A missing scene is a missing decoration, not a broken page.
        console.warn('App Universe did not load:', err.message);
      });

    return () => { cancelled = true; };
  }, []);

  return (
    <div className="app-universe relative w-full">
      <div className="app-universe-glow" aria-hidden="true" />
      <div id="canvas-container" ref={mountRef} className="app-universe-stage" />

      <div id="loader"><div className="ring" /><p>Assembling scene</p></div>

      <div className="controls">
        <div className="ctrl-btn active" id="btnRotate" title="Auto-rotate">⟳</div>
        <div className="ctrl-btn" id="btnBurst" title="Burst / Collapse">✺</div>
        <div className="ctrl-btn" id="btnReset" title="Reset view">⌂</div>
      </div>

      <div id="ios-tilt-btn">Enable Tilt Parallax</div>
      <div id="tooltip" />

      <div className="instruction-badge" id="badge">
        <span className="dot" /> Drag to rotate · Zoom to pop the apps out · Tap an app
      </div>
    </div>
  );
}
