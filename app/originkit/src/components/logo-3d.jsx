import { useEffect, useRef } from 'react';
import * as THREE from 'three';
import { GLTFLoader } from 'three/examples/jsm/loaders/GLTFLoader.js';

/**
 * The logo as a real 3D object.
 *
 * Not a Framer component — nothing on the marketplace loads an arbitrary GLB,
 * and the model here is the client's own, exported from Meshy. three.js is
 * already a dependency (the PoC page's slider pulled it in), so this costs a
 * loader and about a hundred lines rather than a new package.
 *
 * Props:
 *   src        url of the .glb
 *   spin       degrees per second of idle rotation
 *   tilt       resting tilt, so it does not read as a flat cutout
 *
 * It drags to orbit and drifts on its own when left alone.
 *
 * On failure — no file, a 404, a malformed model, no WebGL — it renders
 * nothing and reports it to the host. The page's poster is sitting behind it
 * and simply stays, which is the same arrangement every other WebGL block on
 * this site now uses.
 */
export default function Logo3D({ src, spin = 14, tilt = -0.18 }) {
  const hostRef = useRef(null);

  useEffect(() => {
    const host = hostRef.current;
    if (!host || !src) return undefined;

    let renderer;
    let frame = 0;
    let disposed = false;

    try {
      renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
    } catch {
      return undefined;   /* no WebGL — the poster stays */
    }

    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(38, 1, 0.1, 100);
    camera.position.set(0, 0, 4.2);

    /* Key, fill and rim, roughly matching the site's ramp so the model reads
       as belonging to the page rather than lit by a default studio. */
    scene.add(new THREE.AmbientLight(0xffffff, 0.55));

    const key = new THREE.DirectionalLight(0x00f2fe, 2.1);
    key.position.set(2.5, 2.5, 3);
    scene.add(key);

    const fill = new THREE.DirectionalLight(0x9d4edd, 1.5);
    fill.position.set(-3, -1.5, 2);
    scene.add(fill);

    const rim = new THREE.DirectionalLight(0xffffff, 1.1);
    rim.position.set(0, 1.5, -3);
    scene.add(rim);

    const pivot = new THREE.Group();
    scene.add(pivot);

    const size = () => {
      const r = host.getBoundingClientRect();
      const w = Math.max(1, Math.round(r.width));
      const h = Math.max(1, Math.round(r.height));
      renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 2));
      renderer.setSize(w, h, false);
      camera.aspect = w / h;
      camera.updateProjectionMatrix();
    };

    renderer.domElement.style.width = '100%';
    renderer.domElement.style.height = '100%';
    renderer.domElement.style.display = 'block';
    renderer.domElement.style.cursor = 'grab';
    host.appendChild(renderer.domElement);
    size();

    const ro = new ResizeObserver(size);
    ro.observe(host);

    /* --- drag ----------------------------------------------------------- */

    let drag = null;
    let spun = 0;          /* radians the pointer has added */
    let lean = tilt;

    const down = (e) => { drag = { x: e.clientX, y: e.clientY, s: spun, l: lean };
      renderer.domElement.setPointerCapture(e.pointerId);
      renderer.domElement.style.cursor = 'grabbing'; };
    const move = (e) => {
      if (!drag) return;
      spun = drag.s + (e.clientX - drag.x) * 0.008;
      /* Clamped, or the model ends up upside down and never recovers. */
      lean = Math.max(-0.9, Math.min(0.9, drag.l + (e.clientY - drag.y) * 0.005));
    };
    const up = () => { drag = null; renderer.domElement.style.cursor = 'grab'; };

    renderer.domElement.addEventListener('pointerdown', down);
    renderer.domElement.addEventListener('pointermove', move);
    renderer.domElement.addEventListener('pointerup', up);
    renderer.domElement.addEventListener('pointercancel', up);

    /* --- model ---------------------------------------------------------- */

    new GLTFLoader().load(
      src,
      (gltf) => {
        if (disposed) return;
        const model = gltf.scene;

        /* Meshy exports arrive at wildly different scales and origins, so the
           model is measured and normalised rather than trusted: centred on its
           own bounding box and scaled so its longest edge is a known size. */
        const box = new THREE.Box3().setFromObject(model);
        const centre = box.getCenter(new THREE.Vector3());
        const span = box.getSize(new THREE.Vector3());
        const longest = Math.max(span.x, span.y, span.z) || 1;

        model.position.sub(centre);
        model.scale.setScalar(2.4 / longest);
        pivot.add(model);
      },
      undefined,
      () => { host.dataset.logo3dFailed = '1'; }   /* poster stays */
    );

    /* --- loop ----------------------------------------------------------- */

    const clock = new THREE.Clock();
    const tick = () => {
      frame = requestAnimationFrame(tick);
      const dt = clock.getDelta();
      if (!drag) spun += (spin * Math.PI / 180) * dt;
      pivot.rotation.y = spun;
      pivot.rotation.x = lean;
      renderer.render(scene, camera);
    };
    tick();

    return () => {
      disposed = true;
      cancelAnimationFrame(frame);
      ro.disconnect();
      renderer.domElement.removeEventListener('pointerdown', down);
      renderer.domElement.removeEventListener('pointermove', move);
      renderer.domElement.removeEventListener('pointerup', up);
      renderer.domElement.removeEventListener('pointercancel', up);
      renderer.dispose();
      if (renderer.domElement.parentNode === host) host.removeChild(renderer.domElement);
    };
  }, [src, spin, tilt]);

  return <div ref={hostRef} style={{ width: '100%', height: '100%' }} />;
}
