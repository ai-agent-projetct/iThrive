import React, { useState, useEffect, useRef, useMemo, useCallback } from 'react';
import * as THREE from 'three';
import { SVGLoader } from 'three/examples/jsm/loaders/SVGLoader.js';

/**
 * Chromatic 3D Logo Component
 * Reverse-engineered from https://www.framer.com/marketplace/components/chromatic-logo/
 * 
 * Features:
 * - Real-time 3D SVG extrusion with smooth bevels and auto-centering
 * - Photorealistic MeshPhysicalMaterial with high metalness, zero roughness, clearcoat, and iridescence
 * - Dynamic PMREM cube-camera environment shader with animated chromatic wave equations
 * - Pointer drag rotation with inertia, damping, and tilt clamping
 * - Smooth auto-rotation on Y-axis
 * - Real-time preset switching (Animated, Extreme, Smooth, Metal)
 * - 16:9 full-screen responsive viewport layout
 */

const DEFAULT_ITHRIVE_SVG = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 500" width="500" height="500">
  <path d="M 81.78 104.68 L 77.29 105.62 L 73.00 107.27 L 69.09 109.63 L 65.75 112.66 L 62.99 116.27 L 60.58 120.20 L 59.16 124.49 L 58.65 129.02 L 58.36 133.57 L 58.20 138.12 L 58.14 142.68 L 58.14 147.24 L 58.17 151.80 L 58.21 156.36 L 58.23 160.92 L 58.24 165.48 L 58.24 170.04 L 58.24 174.60 L 58.23 179.16 L 58.22 183.71 L 58.21 188.27 L 58.20 192.83 L 58.19 197.39 L 58.19 201.95 L 58.19 206.51 L 58.20 211.07 L 58.21 215.63 L 58.22 220.19 L 58.23 224.75 L 58.22 229.31 L 58.20 233.86 L 58.19 238.42 L 58.37 243.03 L 57.52 247.38 L 54.95 251.21 L 51.93 254.69 L 48.87 258.06 L 45.99 261.57 L 43.43 265.33 L 41.00 269.22 L 38.53 273.04 L 36.14 276.87 L 34.11 280.95 L 32.29 285.15 L 30.44 289.30 L 28.55 293.40 L 26.79 297.58 L 25.29 301.90 L 24.08 306.29 L 23.06 310.72 L 22.12 315.16 L 21.24 319.63 L 20.52 324.12 L 20.04 328.65 L 19.85 333.21 L 19.91 337.78 L 20.15 342.33 L 20.49 346.85 L 20.69 351.40 L 21.28 355.88 L 22.35 360.31 L 23.35 364.75 L 24.39 369.18 L 25.60 373.57 L 27.00 377.91 L 28.55 382.19 L 30.27 386.42 L 32.12 390.59 L 34.09 394.70 L 36.19 398.75 L 38.40 402.73 L 40.75 406.62 L 43.25 410.43 L 45.89 414.13 L 48.67 417.74 L 51.57 421.25 L 54.59 424.66 L 57.72 427.98 L 60.96 431.19 L 64.29 434.29 L 67.73 437.29 L 71.26 440.16 L 74.88 442.92 L 78.59 445.56 L 82.37 448.09 L 86.21 450.52 L 90.11 452.89 L 94.03 455.20 L 98.01 457.44 L 102.05 459.55 L 106.17 461.50 L 110.39 463.22 L 114.70 464.69 L 119.11 465.87 L 123.43 467.34 L 127.65 469.01 L 132.11 469.75 L 136.57 470.81 L 141.10 471.92 L 144.21 474.93 L 147.42 477.60 L 152.06 478.22 L 156.53 479.18 L 160.95 480.03 L 165.55 480.19 L 170.12 479.93 L 174.62 479.47 L 179.13 478.94 L 183.72 478.44 L 188.02 477.12 L 191.83 474.64 L 195.79 472.45 L 200.07 470.97 L 204.52 469.85 L 208.96 468.73 L 213.35 467.49 L 217.69 466.12 L 221.98 464.62 L 226.22 462.99 L 230.42 461.20 L 234.57 459.27 L 238.65 457.19 L 242.63 455.01 L 246.46 452.73 L 250.23 450.16 L 254.10 446.58 L 254.46 443.25 L 249.83 441.76 L 245.14 441.69 L 240.62 441.91 L 236.07 441.91 L 231.54 441.66 L 227.00 441.29 L 222.47 440.83 L 217.95 440.27 L 213.44 439.58 L 208.96 438.74 L 204.51 437.73 L 200.10 436.55 L 195.75 435.17 L 191.46 433.60 L 187.24 431.85 L 183.12 429.91 L 179.09 427.78 L 175.17 425.47 L 171.37 422.98 L 167.70 420.30 L 164.18 417.44 L 160.81 414.40 L 157.61 411.18 L 154.58 407.77 L 151.75 404.19 L 149.12 400.44 L 146.70 396.54 L 144.52 392.50 L 142.60 388.34 L 140.93 384.08 L 139.56 379.74 L 138.48 375.32 L 137.71 370.86 L 137.21 366.36 L 136.92 361.83 L 136.78 357.27 L 136.75 352.71 L 136.77 348.14 L 136.80 343.57 L 136.83 339.01 L 136.85 334.45 L 136.87 329.90 L 136.87 325.34 L 136.86 320.78 L 136.84 316.22 L 136.81 311.66 L 136.80 307.09 L 136.80 302.54 L 136.83 297.98 L 136.89 293.42 L 136.92 288.87 L 136.87 284.31 L 136.70 279.73 L 136.68 275.16 L 137.38 270.62 L 139.78 267.13 L 144.14 265.31 L 148.52 263.40 L 152.39 264.84 L 153.33 269.08 L 153.01 273.84 L 152.89 278.43 L 152.92 282.94 L 153.06 287.45 L 153.26 292.00 L 153.52 296.57 L 153.86 301.12 L 154.30 305.65 L 154.88 310.15 L 155.66 314.64 L 156.62 319.09 L 157.75 323.50 L 159.03 327.88 L 160.47 332.21 L 162.06 336.49 L 163.80 340.70 L 165.68 344.85 L 167.72 348.93 L 169.90 352.93 L 172.22 356.85 L 174.69 360.67 L 177.31 364.40 L 180.06 368.02 L 182.96 371.54 L 185.99 374.94 L 189.16 378.22 L 192.47 381.37 L 195.92 384.38 L 199.49 387.23 L 203.18 389.90 L 206.98 392.37 L 210.89 394.64 L 214.92 396.74 L 219.04 398.67 L 223.27 400.41 L 227.58 401.95 L 231.96 403.26 L 236.39 404.31 L 240.88 405.09 L 245.40 405.57 L 249.94 405.78 L 254.49 405.74 L 259.04 405.48 L 263.57 405.01 L 268.08 404.29 L 272.53 403.31 L 276.92 402.04 L 281.22 400.49 L 285.39 398.69 L 289.41 396.63 L 293.34 394.40 L 297.28 392.08 L 301.31 389.76 L 305.17 387.23 L 308.53 384.23 L 311.02 380.50 L 312.15 375.94 L 310.16 372.13 L 305.82 370.16 L 301.29 369.54 L 296.77 369.17 L 292.31 368.27 L 287.86 367.18 L 283.46 366.01 L 279.10 364.68 L 274.81 363.17 L 270.60 361.44 L 266.51 359.46 L 262.55 357.21 L 258.73 354.71 L 255.07 352.00 L 251.57 349.11 L 248.23 346.03 L 245.06 342.76 L 242.06 339.32 L 239.25 335.73 L 236.63 331.99 L 234.22 328.11 L 232.03 324.12 L 230.07 320.03 L 228.33 315.83 L 226.83 311.55 L 225.55 307.19 L 224.50 302.76 L 223.70 298.27 L 223.16 293.75 L 222.84 289.20 L 222.70 284.64 L 222.68 280.07 L 222.74 275.50 L 222.83 270.95 L 222.89 266.41 L 222.92 261.88 L 222.90 257.33 L 222.82 252.75 L 222.66 248.11 L 222.47 243.42 L 223.83 239.53 L 227.79 237.30 L 232.22 235.95 L 236.50 234.41 L 240.64 232.55 L 244.69 230.49 L 248.69 228.27 L 252.59 225.88 L 256.37 223.32 L 260.00 220.55 L 263.43 217.57 L 266.64 214.36 L 269.59 210.90 L 272.30 207.22 L 274.84 203.41 L 277.26 199.52 L 279.63 195.65 L 281.67 191.62 L 283.00 187.19 L 284.22 182.81 L 285.43 178.50 L 286.43 174.06 L 287.01 169.34 L 286.27 164.82 L 283.02 163.52 L 278.42 165.20 L 273.93 166.64 L 269.57 167.82 L 265.25 168.96 L 260.89 170.23 L 256.49 171.54 L 252.06 172.76 L 247.61 173.83 L 243.17 174.77 L 238.76 175.63 L 234.35 176.42 L 229.70 177.21 L 224.90 177.63 L 222.78 174.72 L 222.79 169.80 L 222.85 165.25 L 222.82 160.72 L 222.79 156.17 L 222.78 151.61 L 222.81 147.04 L 222.83 142.47 L 222.85 137.90 L 222.84 133.34 L 222.78 128.81 L 222.73 124.28 L 222.77 119.71 L 223.03 115.05 L 222.73 110.52 L 219.51 107.57 L 215.21 108.78 L 211.33 111.55 L 207.63 114.07 L 203.66 116.34 L 199.73 118.65 L 195.87 121.03 L 192.00 123.42 L 188.12 125.82 L 184.25 128.26 L 180.46 130.81 L 176.79 133.49 L 173.28 136.36 L 170.00 139.48 L 166.98 142.88 L 164.26 146.57 L 161.85 150.50 L 159.75 154.59 L 157.95 158.76 L 156.44 162.99 L 155.18 167.33 L 154.16 171.80 L 153.57 176.31 L 153.30 180.83 L 153.02 185.34 L 153.18 190.06 L 152.37 194.20 L 148.38 196.44 L 143.84 197.80 L 139.14 198.68 L 137.10 195.59 L 136.77 190.76 L 136.74 186.15 L 136.80 181.62 L 136.85 177.09 L 136.88 172.55 L 136.88 168.00 L 136.88 163.45 L 136.86 158.88 L 136.83 154.30 L 136.80 149.71 L 136.78 145.14 L 136.78 140.57 L 136.81 136.03 L 136.87 131.52 L 136.96 127.02 L 136.96 122.49 L 136.78 117.83 L 136.26 113.08 L 134.86 108.82 L 131.89 105.90 L 127.44 104.57 L 122.60 104.31 L 118.18 104.51 L 113.71 104.58 L 109.11 104.50 L 104.50 104.47 L 99.93 104.51 L 95.39 104.54 L 90.85 104.49 L 86.31 104.41 L 81.78 104.68 Z M 55.11 339.36 L 55.95 339.08 L 56.54 339.35 L 57.25 339.72 L 58.03 340.09 L 58.28 340.85 L 58.15 341.85 L 58.20 342.66 L 58.46 343.37 L 58.74 344.16 L 58.97 345.01 L 59.08 345.88 L 59.00 346.71 L 58.75 347.51 L 58.44 348.30 L 58.21 349.10 L 58.14 349.93 L 58.22 350.78 L 58.38 351.63 L 58.56 352.44 L 58.72 353.22 L 58.86 354.00 L 58.97 354.83 L 59.04 355.72 L 59.07 356.64 L 59.00 357.55 L 58.81 358.37 L 58.48 359.06 L 57.97 359.57 L 57.27 359.87 L 56.46 359.92 L 55.72 359.69 L 55.16 359.21 L 54.70 358.57 L 54.26 357.88 L 53.84 357.16 L 53.46 356.42 L 53.13 355.68 L 52.85 354.94 L 52.60 354.20 L 52.35 353.46 L 52.06 352.70 L 51.73 351.92 L 51.40 351.14 L 51.11 350.34 L 50.92 349.53 L 50.84 348.72 L 50.86 347.91 L 50.96 347.11 L 51.15 346.31 L 51.41 345.52 L 51.71 344.75 L 52.07 344.00 L 52.45 343.27 L 52.85 342.56 L 53.25 341.86 L 53.64 341.18 L 54.01 340.50 L 54.46 339.87 L 55.11 339.36 Z" fill="#6A3FE0" fill-rule="evenodd"/>
  <path d="M 68.28 55.50 a 35.99 35.99 0 1 0 71.98 0 a 35.99 35.99 0 1 0 -71.98 0 Z" fill="#3EE1FF"/>
</svg>`;

const PRESETS = {
  animated: {
    name: 'Animated',
    desc: 'Electric Cyan & Magenta Iridescence',
    styleVal: 1.0,
    color1: '#0B132B',
    color2: '#00F2FE',
    color3: '#B24BF3',
    metalness: 1.0,
    roughness: 0.0,
    iridescence: 1.0,
    iridescenceIOR: 1.35,
    envMapIntensity: 4.8,
  },
  extreme: {
    name: 'Extreme',
    desc: 'High-Energy Psychedelic Spectrum',
    styleVal: 2.0,
    color1: '#02040A',
    color2: '#38BDF8',
    color3: '#EC4899',
    metalness: 1.0,
    roughness: 0.01,
    iridescence: 1.0,
    iridescenceIOR: 1.5,
    envMapIntensity: 5.5,
  },
  smooth: {
    name: 'Smooth',
    desc: 'Prismatic Pearl Glass',
    styleVal: 0.0,
    color1: '#090D1A',
    color2: '#60A5FA',
    color3: '#C084FC',
    metalness: 0.95,
    roughness: 0.04,
    iridescence: 0.85,
    iridescenceIOR: 1.25,
    envMapIntensity: 3.8,
  },
  metal: {
    name: 'Metal',
    desc: 'Liquid Chrome & Cold Ice',
    styleVal: 0.5,
    color1: '#000000',
    color2: '#E0F2FE',
    color3: '#93C5FD',
    metalness: 1.0,
    roughness: 0.02,
    iridescence: 0.6,
    iridescenceIOR: 1.15,
    envMapIntensity: 4.2,
  },
};

export default function ChromaticLogo({
  svgUrl = null,
  autoRotate = true,
  autoRotateSpeed = 0.35,
  initialPreset = 'animated',
  extrudeDepth = 2.4,
  bevelSize = 0.35,
  bevelThickness = 1.2,
  scale = 0.72,
  showControls = true,
  interactiveHint = 'Drag to rotate 3D logo · Auto-rotating',
  style = {},
}) {
  const mountRef = useRef(null);
  const [activePresetKey, setActivePresetKey] = useState(initialPreset);
  const [isHovered, setIsHovered] = useState(false);
  const [isPointerDown, setIsPointerDown] = useState(false);

  // Three.js instances
  const sceneRef = useRef(null);
  const envSceneRef = useRef(null);
  const cameraRef = useRef(null);
  const rendererRef = useRef(null);
  const pmremGenRef = useRef(null);
  const cubeCameraRef = useRef(null);
  const cubeTargetRef = useRef(null);
  const envMeshRef = useRef(null);
  const uniformsRef = useRef(null);
  const logoGroupRef = useRef(null);
  const materialRef = useRef(null);
  const envMapTexRef = useRef(null);
  const rafIdRef = useRef(null);

  // Interaction tracking
  const rotTargetRef = useRef({ x: 0, y: 0 });
  const rotCurrentRef = useRef({ x: 0, y: 0 });
  const pointerStartRef = useRef({ x: 0, y: 0 });
  const isDraggingRef = useRef(false);
  const lastEnvUpdateRef = useRef(0);

  // Preset configuration
  const currentPreset = PRESETS[activePresetKey] || PRESETS.animated;

  // Initialize Three.js scene, camera, renderer, and offscreen environment
  useEffect(() => {
    const container = mountRef.current;
    if (!container) return;

    const width = container.clientWidth || 1200;
    const height = container.clientHeight || Math.round(width * 9 / 16);

    // 1. Scene
    const scene = new THREE.Scene();
    sceneRef.current = scene;

    // Specular and rim lights to accentuate metallic edges and bevels
    const ambientLight = new THREE.AmbientLight(0xffffff, 0.85);
    scene.add(ambientLight);

    const dirLight1 = new THREE.DirectionalLight(0x00f2fe, 2.5);
    dirLight1.position.set(30, 40, 30);
    scene.add(dirLight1);

    const dirLight2 = new THREE.DirectionalLight(0xb24bf3, 2.2);
    dirLight2.position.set(-30, -25, 25);
    scene.add(dirLight2);

    const pointLight = new THREE.PointLight(0x38bdf8, 3.2, 100);
    pointLight.position.set(0, 5, 35);
    scene.add(pointLight);

    const envScene = new THREE.Scene();
    envSceneRef.current = envScene;

    // 2. Camera: FOV 45 matching Framer Chromatic Logo
    const camera = new THREE.PerspectiveCamera(45, width / height, 0.1, 1000);
    camera.position.z = 45;
    cameraRef.current = camera;

    // 3. Renderer with ACESFilmicToneMapping & sRGB
    const renderer = new THREE.WebGLRenderer({
      antialias: true,
      alpha: true,
      powerPreference: 'high-performance',
    });
    renderer.setSize(width, height);
    renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 2));
    renderer.toneMapping = THREE.ACESFilmicToneMapping;
    renderer.toneMappingExposure = 1.15;
    renderer.outputColorSpace = THREE.SRGBColorSpace;
    container.innerHTML = '';
    container.appendChild(renderer.domElement);
    rendererRef.current = renderer;

    // 4. PMREM Generator & CubeCamera
    const pmremGenerator = new THREE.PMREMGenerator(renderer);
    pmremGenerator.compileCubemapShader();
    pmremGenRef.current = pmremGenerator;

    const cubeRenderTarget = new THREE.WebGLCubeRenderTarget(512, {
      generateMipmaps: false,
      minFilter: THREE.LinearFilter,
      magFilter: THREE.LinearFilter,
      format: THREE.RGBAFormat,
    });
    cubeTargetRef.current = cubeRenderTarget;

    const cubeCamera = new THREE.CubeCamera(0.1, 100, cubeRenderTarget);
    envScene.add(cubeCamera);
    cubeCameraRef.current = cubeCamera;

    // 5. Dynamic Chromatic Sky Sphere Shader
    const uniforms = {
      color1: { value: new THREE.Color(currentPreset.color1) },
      color2: { value: new THREE.Color(currentPreset.color2) },
      color3: { value: new THREE.Color(currentPreset.color3) },
      uTime: { value: 0 },
      uStyle: { value: currentPreset.styleVal },
    };
    uniformsRef.current = uniforms;

    const envMaterial = new THREE.ShaderMaterial({
      side: THREE.BackSide,
      uniforms: uniforms,
      vertexShader: `
        varying vec3 vWorldPosition;
        void main() {
          vec4 worldPosition = modelMatrix * vec4(position, 1.0);
          vWorldPosition = worldPosition.xyz;
          gl_Position = projectionMatrix * modelViewMatrix * vec4(position, 1.0);
        }
      `,
      fragmentShader: `
        uniform vec3 color1;
        uniform vec3 color2;
        uniform vec3 color3;
        uniform float uTime;
        uniform float uStyle;
        varying vec3 vWorldPosition;

        void main() {
          vec3 dir = normalize(vWorldPosition);

          float yFactor = smoothstep(-1.0, 1.0, dir.y);
          vec3 baseColorDef = mix(color1, color2, yFactor);
          float zFactorDef = pow(max(0.0, dir.z), 3.0) + pow(max(0.0, -dir.z), 3.0);
          float xFactorDef = pow(max(0.0, dir.x), 4.0);
          vec3 finalColorDef = mix(baseColorDef, color3, clamp(zFactorDef * 0.8 + xFactorDef * 0.5, 0.0, 1.0));

          float w1 = sin(dir.x * 8.0 + uTime * 1.2);
          float w2 = sin(dir.y * 8.0 - uTime * 1.5 + w1);
          float w3 = sin(dir.z * 8.0 + uTime * 0.8 - w2);
          vec3 denseColor = mix(color1, color2, (w1 + 1.0) * 0.5);
          denseColor = mix(denseColor, color3, (w2 + 1.0) * 0.5 * 0.6);
          denseColor += color3 * pow(max(0.0, 1.0 - abs(dir.z)), 2.0) * ((w3 + 1.0) * 0.5) * 0.8;

          float t = uTime * 0.8;
          float v1 = sin(dir.x * 12.0 + t);
          float v2 = sin(dir.y * 12.0 - t * 0.8 + v1);
          float v3 = sin(dir.z * 12.0 + t * 1.2 - v2);
          vec3 extremeColor = vec3(
            0.5 + 0.5 * sin(v3 * 3.0 + t),
            0.5 + 0.5 * cos(v1 * 4.0 - t),
            0.5 + 0.5 * sin(v2 * 5.0 + t * 1.5)
          );
          extremeColor += vec3(1.0) * pow(max(0.0, 1.0 - abs(dir.z)), 2.5) * 1.2;

          vec3 finalColor = mix(finalColorDef, denseColor, clamp(uStyle, 0.0, 1.0));
          finalColor = mix(finalColor, extremeColor, clamp(uStyle - 1.0, 0.0, 1.0));

          gl_FragColor = vec4(finalColor, 1.0);
          #include <tonemapping_fragment>
          #include <colorspace_fragment>
        }
      `,
    });

    const envSphere = new THREE.Mesh(new THREE.SphereGeometry(50, 32, 32), envMaterial);
    envSphere.frustumCulled = false;
    envScene.add(envSphere);
    envMeshRef.current = envSphere;

    // 6. Master Logo Holder
    const logoGroup = new THREE.Group();
    scene.add(logoGroup);
    logoGroupRef.current = logoGroup;

    // 7. Logo Physical Material
    const material = new THREE.MeshPhysicalMaterial({
      color: new THREE.Color('#ffffff'),
      metalness: currentPreset.metalness,
      roughness: currentPreset.roughness,
      clearcoat: 1.0,
      clearcoatRoughness: 0.0,
      iridescence: currentPreset.iridescence,
      iridescenceIOR: currentPreset.iridescenceIOR,
      envMapIntensity: currentPreset.envMapIntensity,
      dithering: true,
      side: THREE.FrontSide,
    });
    materialRef.current = material;

    // Initial cubemap snapshot
    cubeCamera.update(renderer, envScene);
    const initialEnv = pmremGenerator.fromCubemap(cubeRenderTarget.texture);
    envMapTexRef.current = initialEnv;
    scene.environment = initialEnv.texture;

    // Resize observer
    const resizeObserver = new ResizeObserver((entries) => {
      for (const entry of entries) {
        const w = entry.contentRect.width;
        const h = entry.contentRect.height;
        if (w > 0 && h > 0) {
          renderer.setSize(w, h);
          camera.aspect = w / h;
          camera.updateProjectionMatrix();
        }
      }
    });
    resizeObserver.observe(container);

    // Main animation loop
    let lastTime = 0;
    const animate = (timestamp) => {
      rafIdRef.current = requestAnimationFrame(animate);

      const delta = lastTime === 0 ? 0.016 : Math.min(0.05, (timestamp - lastTime) / 1000);
      lastTime = timestamp;

      // Auto-rotation when not dragging
      if (!isDraggingRef.current && autoRotate) {
        rotTargetRef.current.y += autoRotateSpeed * 0.012;
        rotTargetRef.current.x += (0.0 - rotTargetRef.current.x) * 0.02;
      }

      // Smooth inertia lerp
      rotCurrentRef.current.x += (rotTargetRef.current.x - rotCurrentRef.current.x) * 0.1;
      rotCurrentRef.current.y += (rotTargetRef.current.y - rotCurrentRef.current.y) * 0.1;

      // Clamp X tilt
      rotCurrentRef.current.x = Math.max(-Math.PI / 3, Math.min(Math.PI / 3, rotCurrentRef.current.x));

      // Apply rotation to 3D logo
      if (logoGroupRef.current) {
        logoGroupRef.current.rotation.set(rotCurrentRef.current.x, rotCurrentRef.current.y, 0);
      }

      // Update shader time & cubemap reflections
      if (uniformsRef.current) {
        uniformsRef.current.uTime.value += 0.018;
      }
      if (envMeshRef.current) {
        envMeshRef.current.rotation.y -= 0.006;
      }

      // Throttle dynamic cubemap regeneration to ~30-40 fps for silky GPU performance
      if (timestamp - lastEnvUpdateRef.current > 28) {
        lastEnvUpdateRef.current = timestamp;
        cubeCamera.update(renderer, envScene);
        const newEnv = pmremGenerator.fromCubemap(cubeRenderTarget.texture);
        if (envMapTexRef.current) {
          envMapTexRef.current.dispose();
        }
        envMapTexRef.current = newEnv;
        scene.environment = newEnv.texture;
      }

      renderer.render(scene, camera);
    };

    rafIdRef.current = requestAnimationFrame(animate);

    // Cleanup
    return () => {
      if (rafIdRef.current) cancelAnimationFrame(rafIdRef.current);
      resizeObserver.disconnect();
      if (envMapTexRef.current) envMapTexRef.current.dispose();
      cubeRenderTarget.dispose();
      pmremGenerator.dispose();
      renderer.dispose();
      if (renderer.domElement && container.contains(renderer.domElement)) {
        container.removeChild(renderer.domElement);
      }
    };
  }, []);

  // Update preset uniforms and material properties dynamically
  useEffect(() => {
    if (!materialRef.current || !uniformsRef.current) return;

    const p = currentPreset;
    const mat = materialRef.current;
    mat.metalness = p.metalness;
    mat.roughness = p.roughness;
    mat.iridescence = p.iridescence;
    mat.iridescenceIOR = p.iridescenceIOR;
    mat.envMapIntensity = p.envMapIntensity;
    mat.needsUpdate = true;

    uniformsRef.current.color1.value.set(p.color1);
    uniformsRef.current.color2.value.set(p.color2);
    uniformsRef.current.color3.value.set(p.color3);
    uniformsRef.current.uStyle.value = p.styleVal;

    if (rendererRef.current && envSceneRef.current && cubeCameraRef.current && pmremGenRef.current && cubeTargetRef.current) {
      cubeCameraRef.current.update(rendererRef.current, envSceneRef.current);
      const newEnv = pmremGenRef.current.fromCubemap(cubeTargetRef.current.texture);
      if (envMapTexRef.current) envMapTexRef.current.dispose();
      envMapTexRef.current = newEnv;
      if (sceneRef.current) sceneRef.current.environment = newEnv.texture;
    }
  }, [currentPreset]);

  // Load and extrude SVG logo into 3D geometry
  useEffect(() => {
    let active = true;

    const parseAndBuildLogo = (svgText) => {
      if (!active || !logoGroupRef.current || !materialRef.current) return;

      const loader = new SVGLoader();
      const svgData = loader.parse(svgText);
      const shapes = [];

      svgData.paths.forEach((path) => {
        shapes.push(...SVGLoader.createShapes(path));
      });

      if (shapes.length === 0) return;

      const group = logoGroupRef.current;
      while (group.children.length > 0) {
        const child = group.children[0];
        group.remove(child);
        if (child.geometry) child.geometry.dispose();
      }

      let minX = Infinity, minY = Infinity, maxX = -Infinity, maxY = -Infinity;
      shapes.forEach((shape) => {
        shape.getPoints().forEach((pt) => {
          if (pt.x < minX) minX = pt.x;
          if (pt.x > maxX) maxX = pt.x;
          if (pt.y < minY) minY = pt.y;
          if (pt.y > maxY) maxY = pt.y;
        });
      });

      const span = Math.max(maxX - minX, maxY - minY);
      const o = span > 0 ? span / 25 : 1;

      const subGroup = new THREE.Group();

      shapes.forEach((shape) => {
        const geom = new THREE.ExtrudeGeometry(shape, {
          depth: extrudeDepth * o,
          bevelEnabled: true,
          bevelSegments: 16,
          steps: 1,
          bevelSize: bevelSize * o,
          bevelThickness: bevelThickness * o,
          curveSegments: 36,
        });

        const mesh = new THREE.Mesh(geom, materialRef.current);
        mesh.matrixAutoUpdate = false;
        subGroup.add(mesh);
      });

      const box = new THREE.Box3().setFromObject(subGroup);
      const center = new THREE.Vector3();
      box.getCenter(center);

      subGroup.children.forEach((mesh) => {
        mesh.geometry.translate(-center.x, -center.y, -center.z);
        mesh.updateMatrix();
      });

      const size = new THREE.Vector3();
      box.setFromObject(subGroup).getSize(size);
      const maxDim = Math.max(size.x, size.y, size.z);
      if (maxDim > 0) {
        const factor = 25 / maxDim;
        subGroup.scale.set(factor * scale, -factor * scale, factor * scale);
      }

      group.add(subGroup);
    };

    if (svgUrl) {
      fetch(svgUrl)
        .then((res) => res.text())
        .then((text) => parseAndBuildLogo(text))
        .catch((err) => {
          console.warn('Could not fetch custom SVG, using iThrive SVG:', err);
          parseAndBuildLogo(DEFAULT_ITHRIVE_SVG);
        });
    } else {
      parseAndBuildLogo(DEFAULT_ITHRIVE_SVG);
    }

    return () => {
      active = false;
    };
  }, [svgUrl, extrudeDepth, bevelSize, bevelThickness, scale]);

  // Pointer drag interaction handlers
  const handlePointerDown = (e) => {
    isDraggingRef.current = true;
    setIsPointerDown(true);
    pointerStartRef.current = { x: e.clientX, y: e.clientY };
  };

  const handlePointerMove = (e) => {
    if (!isDraggingRef.current) return;
    const dx = e.clientX - pointerStartRef.current.x;
    const dy = e.clientY - pointerStartRef.current.y;
    pointerStartRef.current = { x: e.clientX, y: e.clientY };

    rotTargetRef.current.y += dx * 0.009;
    rotTargetRef.current.x += dy * 0.009;
  };

  const handlePointerUp = () => {
    isDraggingRef.current = false;
    setIsPointerDown(false);
  };

  return (
    <div
      style={{
        position: 'relative',
        width: '100%',
        aspectRatio: '16 / 9',
        minHeight: '460px',
        maxHeight: '85vh',
        background: 'transparent',
        overflow: 'visible',
        userSelect: 'none',
        touchAction: 'none',
        ...style,
      }}
      onMouseEnter={() => setIsHovered(true)}
      onMouseLeave={() => {
        setIsHovered(false);
        handlePointerUp();
      }}
      onPointerDown={handlePointerDown}
      onPointerMove={handlePointerMove}
      onPointerUp={handlePointerUp}
      onPointerCancel={handlePointerUp}
    >
      <div
        ref={mountRef}
        style={{
          position: 'absolute',
          inset: 0,
          width: '100%',
          height: '100%',
          cursor: isPointerDown ? 'grabbing' : 'grab',
        }}
      />

      <div
        style={{
          position: 'absolute',
          top: '50%',
          left: '50%',
          transform: 'translate(-50%, -50%)',
          width: '45%',
          height: '45%',
          background: 'radial-gradient(circle, rgba(0, 242, 254, 0.16) 0%, rgba(124, 58, 237, 0.12) 50%, rgba(0,0,0,0) 80%)',
          pointerEvents: 'none',
          filter: 'blur(40px)',
        }}
      />

      <div
        style={{
          position: 'absolute',
          top: '16px',
          left: '18px',
          display: 'flex',
          alignItems: 'center',
          gap: '8px',
          pointerEvents: 'none',
        }}
      >
        <span
          style={{
            fontFamily: "'JetBrains Mono', monospace",
            fontSize: '11px',
            fontWeight: 700,
            letterSpacing: '0.1em',
            textTransform: 'uppercase',
            color: '#00F2FE',
            background: 'rgba(0, 242, 254, 0.1)',
            border: '1px solid rgba(0, 242, 254, 0.35)',
            padding: '3px 8px',
            borderRadius: '6px',
            backdropFilter: 'blur(8px)',
          }}
        >
          3D Chromatic Engine
        </span>
        <span
          style={{
            fontFamily: "'Space Grotesk', sans-serif",
            fontSize: '11px',
            color: '#64748B',
            fontWeight: 500,
          }}
        >
          16:9 Interactive Hero
        </span>
      </div>

      {interactiveHint && (
        <div
          style={{
            position: 'absolute',
            top: '16px',
            right: '18px',
            display: 'flex',
            alignItems: 'center',
            gap: '8px',
            fontFamily: "'JetBrains Mono', monospace",
            fontSize: '11px',
            color: isPointerDown ? '#00F2FE' : '#94A3B8',
            background: 'rgba(3, 7, 18, 0.7)',
            border: '1px solid rgba(255, 255, 255, 0.1)',
            padding: '4px 10px',
            borderRadius: '20px',
            backdropFilter: 'blur(8px)',
            transition: 'all 0.2s ease',
            pointerEvents: 'none',
          }}
        >
          <span
            style={{
              width: '6px',
              height: '6px',
              borderRadius: '50%',
              backgroundColor: isPointerDown ? '#00F2FE' : '#38BDF8',
              boxShadow: isPointerDown ? '0 0 10px #00F2FE' : '0 0 6px #38BDF8',
            }}
          />
          {isPointerDown ? 'Rotating 3D Logo' : interactiveHint}
        </div>
      )}

      {showControls && (
        <div
          style={{
            position: 'absolute',
            bottom: '16px',
            left: '50%',
            transform: 'translateX(-50%)',
            display: 'flex',
            alignItems: 'center',
            gap: '6px',
            background: 'rgba(3, 7, 18, 0.85)',
            border: '1px solid rgba(0, 242, 254, 0.3)',
            borderRadius: '40px',
            padding: '6px',
            backdropFilter: 'blur(16px)',
            boxShadow: '0 15px 35px -5px rgba(0, 0, 0, 0.8), 0 0 20px rgba(0, 242, 254, 0.2)',
            zIndex: 10,
          }}
          onClick={(e) => e.stopPropagation()}
        >
          {Object.entries(PRESETS).map(([key, p]) => {
            const isActive = activePresetKey === key;
            return (
              <button
                key={key}
                type="button"
                onClick={() => setActivePresetKey(key)}
                style={{
                  background: isActive
                    ? 'linear-gradient(135deg, #00F2FE 0%, #3B82F6 100%)'
                    : 'transparent',
                  color: isActive ? '#030712' : '#94A3B8',
                  border: 'none',
                  borderRadius: '30px',
                  padding: '7px 15px',
                  fontFamily: "'Space Grotesk', sans-serif",
                  fontSize: '12px',
                  fontWeight: isActive ? 700 : 500,
                  cursor: 'pointer',
                  transition: 'all 0.2s cubic-bezier(0.16, 1, 0.3, 1)',
                  boxShadow: isActive ? '0 0 15px rgba(0, 242, 254, 0.4)' : 'none',
                }}
                onMouseEnter={(e) => {
                  if (!isActive) e.currentTarget.style.color = '#FFFFFF';
                }}
                onMouseLeave={(e) => {
                  if (!isActive) e.currentTarget.style.color = '#94A3B8';
                }}
              >
                {p.name}
              </button>
            );
          })}
        </div>
      )}
    </div>
  );
}
