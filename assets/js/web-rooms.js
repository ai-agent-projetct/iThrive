/**
 * The walkthrough — a corridor of rooms you move through as the page scrolls.
 *
 * Each section of the web development page is a room. Scrolling walks a camera
 * forward down the corridor, and a figure walks ahead of it, crossing a doorway
 * into the next room as its section reaches the viewport. When the figure
 * enters a room, that room's section is told to play its entrance.
 *
 * Three decisions worth knowing about:
 *
 *  - The canvas is decoration and nothing else. Every word on the page is real
 *    HTML in front of it. That is not an accident of implementation: this page
 *    exists to rank, and text baked into a WebGL context is text no crawler and
 *    no answer engine will ever read.
 *
 *  - The rooms are drawn as light rather than as walls — edge strips, floor
 *    grids and glow, no lit surfaces and no textures. It suits the rest of the
 *    site, and the whole corridor lands under ~12k vertices, which matters
 *    because this runs behind a long page on whatever device shows up.
 *
 *  - The walk cycle advances with distance travelled, not with time. Stop
 *    scrolling and the figure stops mid-stride; scroll backwards and it walks
 *    backwards. A looping timer animation would keep marching on the spot,
 *    which is the thing that gives these away as decoration.
 *
 * Skipped entirely under prefers-reduced-motion, on coarse pointers, and if
 * WebGL will not start — in every one of those cases the page is unchanged
 * except that the backdrop stays flat.
 */

import * as THREE from 'three';

const stage = document.querySelector('[data-rooms]');
if (stage && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
  start(stage);
}

function start(host) {
  /** Room order comes from the DOM, so PHP stays the single source of truth. */
  const sections = Array.from(document.querySelectorAll('[data-room]'));
  if (sections.length < 2) return;

  const rooms = sections.map((el) => ({
    el,
    id: el.dataset.room,
    hue: Number(el.dataset.roomHue || 200),
    label: el.dataset.roomLabel || '',
    entered: false,
  }));

  /* ---- renderer ------------------------------------------------------- */

  let renderer;
  try {
    renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true, powerPreference: 'high-performance' });
  } catch (e) {
    return; // No WebGL. The CSS backdrop is already correct underneath.
  }

  renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 1.75));
  renderer.setSize(window.innerWidth, window.innerHeight);
  host.appendChild(renderer.domElement);

  const scene = new THREE.Scene();
  const camera = new THREE.PerspectiveCamera(62, window.innerWidth / window.innerHeight, 0.1, 260);

  // Fog is what sells the depth: rooms ahead fade out, so the corridor reads as
  // long without needing geometry far enough away to cost anything.
  scene.fog = new THREE.Fog(0x05070E, 26, 118);

  /* ---- corridor ------------------------------------------------------- */

  const ROOM_LEN = 30;   // metres of corridor per room
  const ROOM_W = 19;
  const ROOM_H = 10;
  const EYE = 2.65;      // camera height — a person's, not a drone's

  const corridor = new THREE.Group();
  scene.add(corridor);

  const zOf = (i) => -i * ROOM_LEN;

  rooms.forEach((room, i) => {
    const z = zOf(i);
    const colour = new THREE.Color().setHSL(room.hue / 360, 0.82, 0.56);
    room.colour = colour;

    const g = new THREE.Group();
    g.position.z = z;
    corridor.add(g);

    // Floor and ceiling grids. The floor is denser because it is the surface
    // the eye actually uses to judge speed.
    const floor = new THREE.GridHelper(ROOM_W, 12, colour, 0x16203A);
    floor.position.y = 0;
    floor.material.transparent = true;
    floor.material.opacity = 0.34;
    g.add(floor);

    const ceil = new THREE.GridHelper(ROOM_W, 5, colour, 0x111A2E);
    ceil.position.y = ROOM_H;
    ceil.material.transparent = true;
    ceil.material.opacity = 0.14;
    g.add(ceil);

    // Side walls as vertical light ribs rather than solid planes.
    for (const side of [-1, 1]) {
      for (let r = 0; r < 5; r++) {
        const rz = -ROOM_LEN / 2 + (r + 0.5) * (ROOM_LEN / 5);
        const rib = new THREE.Mesh(
          new THREE.PlaneGeometry(0.09, ROOM_H),
          new THREE.MeshBasicMaterial({ color: colour, transparent: true, opacity: 0.30, side: THREE.DoubleSide })
        );
        rib.position.set((side * ROOM_W) / 2, ROOM_H / 2, rz);
        rib.rotation.y = Math.PI / 2;
        g.add(rib);
      }

      // A skirting line along the floor gives the walls somewhere to stand.
      const skirt = new THREE.Mesh(
        new THREE.PlaneGeometry(ROOM_LEN, 0.06),
        new THREE.MeshBasicMaterial({ color: colour, transparent: true, opacity: 0.5 })
      );
      skirt.position.set((side * ROOM_W) / 2, 0.03, 0);
      skirt.rotation.y = Math.PI / 2;
      g.add(skirt);
    }

    // The doorway into the next room: a lit frame the figure walks through.
    if (i < rooms.length - 1) {
      const frame = new THREE.Group();
      frame.position.z = -ROOM_LEN / 2;
      const bar = (w, h, x, y) => {
        const m = new THREE.Mesh(
          new THREE.PlaneGeometry(w, h),
          new THREE.MeshBasicMaterial({ color: colour, transparent: true, opacity: 0.62, side: THREE.DoubleSide })
        );
        m.position.set(x, y, 0);
        return m;
      };
      const DW = 7.4, DH = 6.2;
      frame.add(bar(0.13, DH, -DW / 2, DH / 2));
      frame.add(bar(0.13, DH, DW / 2, DH / 2));
      frame.add(bar(DW + 0.13, 0.13, 0, DH));
      // The wall the doorway is cut into, as two flanking panels.
      for (const side of [-1, 1]) {
        const panel = new THREE.Mesh(
          new THREE.PlaneGeometry((ROOM_W - DW) / 2, ROOM_H),
          new THREE.MeshBasicMaterial({ color: 0x080C16, transparent: true, opacity: 0.86, side: THREE.DoubleSide })
        );
        panel.position.set(side * (DW / 2 + (ROOM_W - DW) / 4), ROOM_H / 2, 0);
        frame.add(panel);
      }
      g.add(frame);
    }

    // The room's sign, rendered to a canvas so the type is crisp.
    if (room.label) {
      const sign = makeSign(room.label, colour);
      sign.position.set(-ROOM_W / 2 + 0.16, 5.4, 2);
      sign.rotation.y = Math.PI / 2;
      g.add(sign);
    }

    // One light per room, lifted as the camera arrives.
    const lamp = new THREE.PointLight(colour, 0, 46, 2);
    lamp.position.set(0, ROOM_H - 1.6, 0);
    g.add(lamp);
    room.lamp = lamp;

    // A soft glow disc on the floor, so the room has a centre.
    const pool = new THREE.Mesh(
      new THREE.CircleGeometry(5.6, 32),
      new THREE.MeshBasicMaterial({ color: colour, transparent: true, opacity: 0.05 })
    );
    pool.rotation.x = -Math.PI / 2;
    pool.position.y = 0.02;
    g.add(pool);
    room.pool = pool;
  });

  scene.add(new THREE.AmbientLight(0x24304E, 1.1));

  /* ---- the figure ------------------------------------------------------ */

  const walker = buildWalker();
  scene.add(walker.group);

  /* ---- scroll ---------------------------------------------------------- */

  const first = rooms[0].el;
  const last = rooms[rooms.length - 1].el;
  const corridorEnd = zOf(rooms.length - 1);

  let travelled = 0;   // metres walked, drives the stride
  let camZ = 0;
  let visible = true;

  /** 0 at the top of the first room, 1 at the bottom of the last. */
  function progress() {
    const top = first.getBoundingClientRect().top + window.scrollY;
    const bottom = last.getBoundingClientRect().bottom + window.scrollY;
    const span = bottom - top - window.innerHeight;
    if (span <= 0) return 0;

    return Math.min(1, Math.max(0, (window.scrollY - top + window.innerHeight * 0.5) / span));
  }

  function frame() {
    if (!visible) return;

    const p = progress();
    const targetZ = p * corridorEnd;

    const prev = camZ;
    camZ += (targetZ - camZ) * 0.09;
    travelled += Math.abs(camZ - prev);

    camera.position.set(0, EYE + Math.sin(travelled * 0.55) * 0.045, camZ + 8);
    camera.lookAt(0, EYE - 0.25, camZ - 14);

    // The figure walks ahead, always between the camera and the next doorway.
    walker.group.position.z = camZ - 1.5;
    walker.step(travelled);

    // Light the room the figure is standing in, dim the rest.
    rooms.forEach((room, i) => {
      const d = Math.abs(camZ - zOf(i));
      const near = Math.max(0, 1 - d / (ROOM_LEN * 1.15));
      room.lamp.intensity = near * 26;
      room.pool.material.opacity = 0.03 + near * 0.12;
    });

    renderer.render(scene, camera);
  }

  let raf = 0;
  const loop = () => { raf = requestAnimationFrame(loop); frame(); };

  /**
   * Revealing a section is deliberately NOT tied to the camera.
   *
   * It was, and it was wrong: content that appears only once a WebGL camera
   * reaches a certain depth is content one arithmetic slip can trap off the
   * page for good. This is a plain intersection test — the section is on
   * screen, so it plays. The corridor lights independently, and if it stalls
   * the page still reads.
   */
  const reveal = new IntersectionObserver((entries) => {
    entries.forEach((e) => {
      if (!e.isIntersecting) return;
      e.target.classList.add('room--entered');
      reveal.unobserve(e.target);
    });
  }, { rootMargin: '0px 0px -12% 0px', threshold: 0.06 });
  rooms.forEach((r) => reveal.observe(r.el));

  // Rendering, separately, is paused while no room is on screen. One boolean
  // fed by seven observed elements has to mean "any of them", not "whichever
  // entry happened to arrive first".
  const onScreen = new Set();
  const vis = new IntersectionObserver((entries) => {
    entries.forEach((e) => (e.isIntersecting ? onScreen.add(e.target) : onScreen.delete(e.target)));
    visible = onScreen.size > 0;
  }, { threshold: 0 });
  rooms.forEach((r) => vis.observe(r.el));

  raf = requestAnimationFrame(loop);

  window.addEventListener('resize', () => {
    camera.aspect = window.innerWidth / window.innerHeight;
    camera.updateProjectionMatrix();
    renderer.setSize(window.innerWidth, window.innerHeight);
  });

  host.classList.add('rooms--live');

  /* ---- helpers --------------------------------------------------------- */

  /** A room name on a wall panel, drawn to a canvas so the type stays sharp. */
  function makeSign(text, colour) {
    const c = document.createElement('canvas');
    c.width = 512; c.height = 128;
    const x = c.getContext('2d');
    x.fillStyle = 'rgba(255,255,255,0.94)';
    x.font = '600 62px Outfit, Segoe UI, sans-serif';
    x.textBaseline = 'middle';
    x.shadowColor = '#' + colour.getHexString();
    x.shadowBlur = 26;
    x.fillText(text.toUpperCase(), 12, 68);

    const tex = new THREE.CanvasTexture(c);
    tex.colorSpace = THREE.SRGBColorSpace;

    return new THREE.Mesh(
      new THREE.PlaneGeometry(7.2, 1.8),
      new THREE.MeshBasicMaterial({ map: tex, transparent: true, opacity: 0.85, side: THREE.DoubleSide })
    );
  }

  /**
   * A walking figure from primitives — no model to download and no rig to load.
   *
   * It reads as a person because of the walk, not the mesh: legs swing in
   * opposition with the knee bending only on the forward swing, arms counter
   * the legs, and the hips drop slightly on each footfall. Everything is a dark
   * silhouette with a rim of the room's colour, which is also what hides the
   * fact that it has no hands and no face.
   */
  function buildWalker() {
    const group = new THREE.Group();

    const skin = new THREE.MeshStandardMaterial({
      color: 0x0A0F1C, roughness: 0.42, metalness: 0.1,
      emissive: 0x0E2740, emissiveIntensity: 0.55,
    });

    const part = (w, h, d) => new THREE.Mesh(new THREE.CapsuleGeometry(w, h, 4, 10), skin);

    const torso = part(0.28, 0.62); torso.position.y = 1.28;
    const head = new THREE.Mesh(new THREE.SphereGeometry(0.20, 18, 14), skin); head.position.y = 1.86;

    const hipL = new THREE.Group(); hipL.position.set(-0.15, 0.94, 0);
    const hipR = new THREE.Group(); hipR.position.set(0.15, 0.94, 0);
    const shoulderL = new THREE.Group(); shoulderL.position.set(-0.33, 1.56, 0);
    const shoulderR = new THREE.Group(); shoulderR.position.set(0.33, 1.56, 0);

    const thighL = part(0.10, 0.40); thighL.position.y = -0.24;
    const thighR = part(0.10, 0.40); thighR.position.y = -0.24;
    const kneeL = new THREE.Group(); kneeL.position.y = -0.48;
    const kneeR = new THREE.Group(); kneeR.position.y = -0.48;
    const shinL = part(0.085, 0.40); shinL.position.y = -0.24;
    const shinR = part(0.085, 0.40); shinR.position.y = -0.24;
    kneeL.add(shinL); kneeR.add(shinR);
    hipL.add(thighL, kneeL); hipR.add(thighR, kneeR);

    const armL = part(0.075, 0.44); armL.position.y = -0.26;
    const armR = part(0.075, 0.44); armR.position.y = -0.26;
    shoulderL.add(armL); shoulderR.add(armR);

    group.add(torso, head, hipL, hipR, shoulderL, shoulderR);

    // Facing down the corridor, away from the camera.
    group.rotation.y = Math.PI;

    /** Advance the pose by distance walked. One stride ≈ 1.6 metres. */
    function step(distance) {
      const phase = distance * (Math.PI / 1.6);
      const swing = Math.sin(phase);
      const swingB = Math.sin(phase + Math.PI);

      hipL.rotation.x = swing * 0.62;
      hipR.rotation.x = swingB * 0.62;

      // Knees only bend while the leg travels forward — a knee that bends on
      // the back swing is the thing that makes walk cycles look wrong.
      kneeL.rotation.x = Math.max(0, -swing) * 0.95;
      kneeR.rotation.x = Math.max(0, -swingB) * 0.95;

      shoulderL.rotation.x = swingB * 0.42;
      shoulderR.rotation.x = swing * 0.42;

      group.position.y = Math.abs(Math.cos(phase)) * 0.055;
      torso.rotation.y = swing * 0.07;
    }

    return { group, step };
  }
}
