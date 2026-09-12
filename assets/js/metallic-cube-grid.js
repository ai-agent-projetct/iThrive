/**
 * Metallic Cube Grid — Exact Three.js implementation of Joshua Guo's Framer Component
 * (https://www.framer.com/marketplace/components/metallic-cube-grid/)
 *
 * Features:
 * - 3x3x3 grid of metallic rounded cubes with parametric RoundedBoxGeometry
 * - High-resolution PBR MeshMatcapMaterial with Chrome / PolishedMetal reflections
 * - 6 procedural animations: Wave, Float, Pulse, Rubik, Helix, Scatter
 * - 5 metallic finishes: PolishedMetal (Chrome), TechBlue, GoldMetal, DarkMetal, CleanSurface
 * - Smooth inertia OrbitControls (click & drag to rotate in 3D space)
 * - Self-contained responsive stage centered in the right hero column
 */
(function () {
  'use strict';

  // Matcap texture sources
  const MATCAPS = {
    PolishedMetal: '/assets/images/matcaps/PolishedMetal.png',
    TechBlue: '/assets/images/matcaps/TechBlue.png',
    GoldMetal: '/assets/images/matcaps/GoldMetal.png',
    DarkMetal: '/assets/images/matcaps/DarkMetal.png',
    CleanSurface: '/assets/images/matcaps/CleanSurface.png'
  };

  // Component configuration matching Framer live site
  const CONFIG = {
    countX: 3,
    countY: 3,
    countZ: 3,
    cubeSize: 1.5,
    cubeRadius: 0.1,
    gap: 0.2,
    rotateX: 15,
    rotateY: 40,
    rotateZ: 20,
    color: 0xffffff,
    cameraFov: 15,
    animationPreset: 'Wave',
    animationSpeed: 1.0,
    matcapPreset: 'PolishedMetal'
  };

  /**
   * UV Calculation Helper for RoundedBox faces
   */
  const _tempVec = new THREE.Vector3();
  function calcRoundedUV(faceDir, normal, axisU, axisV, radius, depth) {
    const arc = (2 * Math.PI * radius) / 4;
    const flat = Math.max(depth - 2 * radius, 0);
    const quarterPi = Math.PI / 4;

    _tempVec.copy(normal);
    _tempVec[axisU] = 0;
    _tempVec.normalize();

    const arcRatio = (0.5 * arc) / (arc + flat);
    const angleRatio = 1 - _tempVec.angleTo(faceDir) / quarterPi;

    return Math.sign(_tempVec[axisV]) === 1
      ? angleRatio * arcRatio
      : flat / (arc + flat) + arcRatio + arcRatio * (1 - angleRatio);
  }

  /**
   * RoundedBoxGeometry
   * Exact algorithm used by Framer component
   */
  class RoundedBoxGeometry extends THREE.BoxGeometry {
    constructor(width = 1, height = 1, depth = 1, segments = 2, radius = 0.1) {
      const segs = segments * 2 + 1;
      const rad = Math.min(width / 2, height / 2, depth / 2, radius);
      super(1, 1, 1, segs, segs, segs);

      if (segs === 1) return;

      const nonIndexed = this.toNonIndexed();
      this.index = null;
      this.attributes.position = nonIndexed.attributes.position;
      this.attributes.normal = nonIndexed.attributes.normal;
      this.attributes.uv = nonIndexed.attributes.uv;

      const pos = new THREE.Vector3();
      const norm = new THREE.Vector3();
      const boxSize = new THREE.Vector3(width, height, depth).divideScalar(2).subScalar(rad);
      const positions = this.attributes.position.array;
      const normals = this.attributes.normal.array;
      const uvs = this.attributes.uv.array;
      const faceLength = positions.length / 6;
      const faceDir = new THREE.Vector3();
      const offset = 0.5 / segs;

      for (let i = 0, uvi = 0; i < positions.length; i += 3, uvi += 2) {
        pos.fromArray(positions, i);
        norm.copy(pos);
        norm.x -= Math.sign(norm.x) * offset;
        norm.y -= Math.sign(norm.y) * offset;
        norm.z -= Math.sign(norm.z) * offset;
        norm.normalize();

        positions[i + 0] = boxSize.x * Math.sign(pos.x) + norm.x * rad;
        positions[i + 1] = boxSize.y * Math.sign(pos.y) + norm.y * rad;
        positions[i + 2] = boxSize.z * Math.sign(pos.z) + norm.z * rad;

        normals[i + 0] = norm.x;
        normals[i + 1] = norm.y;
        normals[i + 2] = norm.z;

        const face = Math.floor(i / faceLength);
        switch (face) {
          case 0:
            faceDir.set(1, 0, 0);
            uvs[uvi + 0] = calcRoundedUV(faceDir, norm, 'z', 'y', rad, depth);
            uvs[uvi + 1] = 1 - calcRoundedUV(faceDir, norm, 'y', 'z', rad, height);
            break;
          case 1:
            faceDir.set(-1, 0, 0);
            uvs[uvi + 0] = 1 - calcRoundedUV(faceDir, norm, 'z', 'y', rad, depth);
            uvs[uvi + 1] = 1 - calcRoundedUV(faceDir, norm, 'y', 'z', rad, height);
            break;
          case 2:
            faceDir.set(0, 1, 0);
            uvs[uvi + 0] = 1 - calcRoundedUV(faceDir, norm, 'x', 'z', rad, width);
            uvs[uvi + 1] = calcRoundedUV(faceDir, norm, 'z', 'x', rad, depth);
            break;
          case 3:
            faceDir.set(0, -1, 0);
            uvs[uvi + 0] = 1 - calcRoundedUV(faceDir, norm, 'x', 'z', rad, width);
            uvs[uvi + 1] = 1 - calcRoundedUV(faceDir, norm, 'z', 'x', rad, depth);
            break;
          case 4:
            faceDir.set(0, 0, 1);
            uvs[uvi + 0] = 1 - calcRoundedUV(faceDir, norm, 'x', 'y', rad, width);
            uvs[uvi + 1] = 1 - calcRoundedUV(faceDir, norm, 'y', 'x', rad, height);
            break;
          case 5:
            faceDir.set(0, 0, -1);
            uvs[uvi + 0] = calcRoundedUV(faceDir, norm, 'x', 'y', rad, width);
            uvs[uvi + 1] = 1 - calcRoundedUV(faceDir, norm, 'y', 'x', rad, height);
            break;
        }
      }
    }
  }

  function initMetallicCubeGrid() {
    const container = document.querySelector('.tm-metallic-hero');
    const canvas = document.getElementById('metallic-cube-grid-canvas');
    if (!container || !canvas || typeof THREE === 'undefined') return;

    // Scene
    const scene = new THREE.Scene();

    // Group for all cubes
    const group = new THREE.Group();
    scene.add(group);

    // Initial orientation matching Framer
    group.rotation.set(
      (CONFIG.rotateX * Math.PI) / 180,
      (CONFIG.rotateY * Math.PI) / 180,
      (CONFIG.rotateZ * Math.PI) / 180
    );

    // Centered inside stage
    group.position.set(0, 0.25, 0);

    let width = container.clientWidth;
    let height = container.clientHeight;

    function calcDistance() {
      const minDim = Math.min(width, height);
      if (minDim < 360) return 44;
      if (minDim < 460) return 39;
      if (minDim < 560) return 36;
      return 34;
    }

    const camera = new THREE.PerspectiveCamera(CONFIG.cameraFov, width / height, 0.1, 1000);
    camera.position.set(0, 0.25, calcDistance());
    camera.lookAt(0, 0.25, 0);

    // Renderer
    const renderer = new THREE.WebGLRenderer({
      canvas: canvas,
      antialias: true,
      alpha: true,
      powerPreference: 'high-performance'
    });
    renderer.setSize(width, height);
    renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 2));
    if (THREE.SRGBColorSpace) {
      renderer.outputColorSpace = THREE.SRGBColorSpace;
    } else if (THREE.sRGBEncoding) {
      renderer.outputEncoding = THREE.sRGBEncoding;
    }

    // Material with Matcap
    const material = new THREE.MeshMatcapMaterial({
      color: new THREE.Color(CONFIG.color)
    });

    const textureLoader = new THREE.TextureLoader();
    const loadedTextures = {};

    function loadMatcap(presetName) {
      const url = MATCAPS[presetName] || MATCAPS.PolishedMetal;
      if (loadedTextures[presetName]) {
        material.matcap = loadedTextures[presetName];
        material.needsUpdate = true;
        return;
      }
      textureLoader.load(
        url,
        (tex) => {
          if (THREE.SRGBColorSpace) {
            tex.colorSpace = THREE.SRGBColorSpace;
          } else if (THREE.sRGBEncoding) {
            tex.encoding = THREE.sRGBEncoding;
          }
          tex.needsUpdate = true;
          loadedTextures[presetName] = tex;
          material.matcap = tex;
          material.needsUpdate = true;
        },
        undefined,
        (err) => {
          console.warn('[MetallicCubeGrid] Matcap load failed:', url, err);
        }
      );
    }

    loadMatcap(CONFIG.matcapPreset);

    // Build Grid
    const geometry = new RoundedBoxGeometry(
      CONFIG.cubeSize,
      CONFIG.cubeSize,
      CONFIG.cubeSize,
      4,
      CONFIG.cubeRadius
    );

    const { countX, countY, countZ, cubeSize, gap } = CONFIG;
    const offsetX = ((countX - 1) * (cubeSize + gap)) / 2;
    const offsetY = ((countY - 1) * (cubeSize + gap)) / 2;
    const offsetZ = ((countZ - 1) * (cubeSize + gap)) / 2;

    const cubes = [];
    for (let x = 0; x < countX; x++) {
      for (let y = 0; y < countY; y++) {
        for (let z = 0; z < countZ; z++) {
          const mesh = new THREE.Mesh(geometry, material);
          const px = x * (cubeSize + gap) - offsetX;
          const py = y * (cubeSize + gap) - offsetY;
          const pz = z * (cubeSize + gap) - offsetZ;
          mesh.position.set(px, py, pz);
          mesh.userData = {
            initialPos: new THREE.Vector3(px, py, pz),
            gridIndex: { x, y, z }
          };
          group.add(mesh);
          cubes.push(mesh);
        }
      }
    }

    // OrbitControls for interactive 3D rotation
    let controls = null;
    if (typeof THREE.OrbitControls !== 'undefined') {
      controls = new THREE.OrbitControls(camera, renderer.domElement);
      controls.target.set(0, 0.25, 0);
      controls.enableDamping = true;
      controls.dampingFactor = 0.05;
      controls.enableZoom = false;
      controls.enablePan = false;
      controls.rotateSpeed = 0.85;

      controls.addEventListener('start', () => {
        container.classList.add('is-dragging');
      });

      controls.addEventListener('end', () => {
        container.classList.remove('is-dragging');
      });
    }

    // Animation loop & state
    let animPreset = CONFIG.animationPreset;
    let animSpeed = CONFIG.animationSpeed;
    let animTime = 0;
    const clock = new THREE.Clock();
    let animId = null;

    function animate() {
      animId = requestAnimationFrame(animate);

      if (controls) controls.update();

      const delta = clock.getDelta();
      animTime += delta * animSpeed;
      const l = animTime;

      if (animPreset !== 'None') {
        for (let i = 0; i < cubes.length; i++) {
          const cube = cubes[i];
          const init = cube.userData.initialPos;
          if (!init) continue;

          if (animPreset === 'Wave') {
            const n = (init.x + init.z) * 0.3;
            const r = init.y + Math.sin(l * 2 + n) * 0.3;
            cube.position.y = r;
            cube.scale.setScalar(1);
            cube.rotation.set(0, 0, 0);
          } else if (animPreset === 'Float') {
            const n = init.x * 12.3 + init.y * 4.5 + init.z * 6.7;
            cube.position.y = init.y + Math.sin(l + n) * 0.15;
            cube.rotation.x = Math.sin(l * 0.5 + n) * 0.1;
            cube.rotation.z = Math.cos(l * 0.3 + n) * 0.1;
            cube.scale.setScalar(1);
          } else if (animPreset === 'Pulse') {
            const n = Math.sqrt(init.x ** 2 + init.y ** 2 + init.z ** 2);
            const r = 1 + Math.sin(l * 3 - n * 0.5) * 0.15;
            cube.scale.setScalar(r);
            cube.position.copy(init);
            cube.rotation.set(0, 0, 0);
          } else if (animPreset === 'Rubik') {
            const n = l * (cube.userData.gridIndex.y % 2 === 0 ? 1 : -1);
            const r = Math.cos(n);
            const s = Math.sin(n);
            cube.position.x = init.x * r - init.z * s;
            cube.position.z = init.x * s + init.z * r;
            cube.position.y = init.y;
            cube.rotation.set(0, -n, 0);
            cube.scale.setScalar(1);
          } else if (animPreset === 'Helix') {
            const n = l + init.y * 0.5;
            const r = Math.sqrt(init.x ** 2 + init.z ** 2);
            const angle = Math.atan2(init.z, init.x);
            cube.position.x = r * Math.cos(angle + n);
            cube.position.z = r * Math.sin(angle + n);
            cube.position.y = init.y + Math.sin(l * 2 + init.x) * 0.2;
            cube.rotation.set(0, -n, 0);
            cube.scale.setScalar(1);
          } else if (animPreset === 'Scatter') {
            const n = init.clone().normalize();
            if (n.length() === 0) n.set(0, 1, 0);
            const r = (Math.sin(l) + 1) * 0.8;
            cube.position.copy(init).add(n.multiplyScalar(r * 3));
            cube.rotation.x = l + init.x;
            cube.rotation.y = l + init.y;
            cube.scale.setScalar(1);
          }
        }
      } else {
        for (let i = 0; i < cubes.length; i++) {
          const cube = cubes[i];
          if (cube.userData.initialPos) {
            cube.position.copy(cube.userData.initialPos);
            cube.rotation.set(0, 0, 0);
            cube.scale.setScalar(1);
          }
        }
      }

      renderer.render(scene, camera);
    }

    animate();

    // Resize handling
    function onResize() {
      if (!container) return;
      width = container.clientWidth;
      height = container.clientHeight;
      group.position.set(0, 0.25, 0);
      if (controls) controls.target.set(0, 0.25, 0);
      camera.aspect = width / height;
      camera.position.set(0, 0.25, calcDistance());
      camera.lookAt(0, 0.25, 0);
      camera.updateProjectionMatrix();
      renderer.setSize(width, height);
    }

    window.addEventListener('resize', onResize, { passive: true });

    // Interactive UI controls for modes & finishes
    const modeButtons = container.querySelectorAll('[data-cube-preset]');
    modeButtons.forEach((btn) => {
      btn.addEventListener('click', (e) => {
        e.stopPropagation();
        modeButtons.forEach((b) => b.classList.remove('is-active'));
        btn.classList.add('is-active');
        animPreset = btn.dataset.cubePreset;
      });
    });

    const matcapButtons = container.querySelectorAll('[data-cube-matcap]');
    matcapButtons.forEach((btn) => {
      btn.addEventListener('click', (e) => {
        e.stopPropagation();
        matcapButtons.forEach((b) => b.classList.remove('is-active'));
        btn.classList.add('is-active');
        loadMatcap(btn.dataset.cubeMatcap);
      });
    });

    // Expose control API on window for dev/script access
    window.MetallicCubeGrid = {
      setPreset: (preset) => { animPreset = preset; },
      setMatcap: (preset) => { loadMatcap(preset); },
      setSpeed: (speed) => { animSpeed = speed; },
      resetRotation: () => {
        if (controls) {
          controls.reset();
          controls.target.set(0, 0.25, 0);
        }
        camera.position.set(0, 0.25, calcDistance());
        camera.lookAt(0, 0.25, 0);
        group.rotation.set(
          (CONFIG.rotateX * Math.PI) / 180,
          (CONFIG.rotateY * Math.PI) / 180,
          (CONFIG.rotateZ * Math.PI) / 180
        );
      }
    };
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initMetallicCubeGrid);
  } else {
    initMetallicCubeGrid();
  }
})();
