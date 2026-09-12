import React, { useEffect, useRef, useState } from 'react';

/**
 * Next.js Flare — Volumetric Light Flare for iThrive
 * Adapted directly from vgpu.sh/examples/nextjs-flare
 *
 * Implements:
 * 1. WebGPU pipeline (4 WGSL shader passes: logo, rim, separable Gaussian blur, 48-step raymarch composite)
 * 2. High-performance Canvas 2D Volumetric fallback
 * 3. iThrive Signature brand colors: Electric Ice Cyan, Sky Blue, Royal Blue, Electric Violet, Neon Magenta, Crystal Ice
 * 4. Autonomous organic light drift + smooth cursor interaction
 * 5. High-definition 3D ribbon mark and typography with zero shadow smudges
 */

const SIGNATURE_COLORS = [
  [0.55, 0.88, 1.00], // Electric Ice Cyan
  [0.38, 0.70, 1.00], // Sky Blue Flare
  [0.45, 0.55, 1.00], // Royal Cobalt
  [0.68, 0.48, 1.00], // Electric Violet
  [0.85, 0.40, 0.90], // Neon Magenta
  [0.70, 0.82, 1.00], // Crystalline Ice
];

const GAUSSIAN_TAPS = [
  [1.4850045, 0.1521519],
  [3.4650571, 0.1248206],
  [5.4452208, 0.0873976],
  [7.4255575, 0.0522290],
  [9.4061269, 0.0266389],
  [11.3869858, 0.0115959],
  [13.3681876, 0.0043079],
  [15.0, 0.0000000],
];

// Blue Noise 128 raw data generator
function getBlueNoiseTexture(device) {
  const size = 128;
  const data = new Uint8Array(size * size);
  for (let i = 0; i < size * size; i++) {
    const x = i % size;
    const y = Math.floor(i / size);
    data[i] = Math.floor(
      (Math.sin(x * 12.9898 + y * 78.233) * 43758.5453 - Math.floor(Math.sin(x * 12.9898 + y * 78.233) * 43758.5453)) * 255
    );
  }
  const texture = device.createTexture({
    size: [size, size, 1],
    format: 'r8unorm',
    usage: GPUTextureUsage.TEXTURE_BINDING | GPUTextureUsage.COPY_DST,
  });
  device.queue.writeTexture({ texture }, data, { bytesPerRow: size }, [size, size]);
  return texture;
}

const VERTEX_SHADER = /* wgsl */ `
struct VertexOutput {
  @builtin(position) position: vec4f,
  @location(0) uv: vec2f,
};
@vertex fn vs_main(@builtin(vertex_index) vi: u32) -> VertexOutput {
  var pos = array<vec2f, 6>(
    vec2f(-1.0, -1.0), vec2f( 1.0, -1.0), vec2f(-1.0,  1.0),
    vec2f(-1.0,  1.0), vec2f( 1.0, -1.0), vec2f( 1.0,  1.0)
  );
  var uv = array<vec2f, 6>(
    vec2f(0.0, 1.0), vec2f(1.0, 1.0), vec2f(0.0, 0.0),
    vec2f(0.0, 0.0), vec2f(1.0, 1.0), vec2f(1.0, 0.0)
  );
  var out: VertexOutput;
  out.position = vec4f(pos[vi], 0.0, 1.0);
  out.uv = uv[vi];
  return out;
}
`;

const LOGO_SHADER = /* wgsl */ `
struct Params {
  logoCenter: vec2f,
  logoScale: vec2f,
  uvInset: vec2f,
  edge: f32,
  _pad: f32,
};
@group(0) @binding(0) var logoSampler: sampler;
@group(0) @binding(1) var logoTexture: texture_2d<f32>;
@group(0) @binding(2) var<uniform> params: Params;

@fragment fn fs_main(@location(0) uv: vec2f) -> @location(0) vec4f {
  let local = (uv - params.logoCenter) / params.logoScale + vec2f(0.5);
  let inside = all(local >= vec2f(0.0)) && all(local <= vec2f(1.0));
  let sampleUv = mix(params.uvInset, vec2f(1.0) - params.uvInset, clamp(local, vec2f(0.0), vec2f(1.0)));
  let texel = textureSample(logoTexture, logoSampler, sampleUv);
  return select(vec4f(0.0), texel, inside);
}
`;

const RIM_SHADER = /* wgsl */ `
struct Params {
  light: vec2f,
  sceneTexel: vec2f,
  aspect: vec2f,
  spotReach: f32,
  spotStroke: f32,
};
@group(0) @binding(0) var linearSampler: sampler;
@group(0) @binding(1) var sceneTexture: texture_2d<f32>;
@group(0) @binding(2) var<uniform> params: Params;

@fragment fn fs_main(@location(0) uv: vec2f) -> @location(0) vec4f {
  var sharp = 0.0;
  let radius = max(0.5, params.spotStroke);
  for (var j = -3; j <= 3; j++) {
    for (var i = -3; i <= 3; i++) {
      let offset = vec2f(f32(i), f32(j)) * (radius / 3.0);
      if (length(offset) <= radius + 0.001) {
        let sampleColor = textureSample(sceneTexture, linearSampler, uv + offset * params.sceneTexel);
        let val = max(sampleColor.a, dot(sampleColor.rgb, vec3f(0.299, 0.587, 0.114)));
        sharp = max(sharp, val);
      }
    }
  }
  let present = smoothstep(0.0015, 0.02, sharp);
  let distanceToLight = length((params.light - uv) * params.aspect);
  let falloff = mix(9.0, 0.4, params.spotReach);
  let lit = (sharp * sharp) * present / (1.0 + distanceToLight * distanceToLight * falloff);
  return vec4f(vec3f(lit), 1.0);
}
`;

const BLUR_SHADER = /* wgsl */ `
const MAX_TAPS: u32 = 8u;

struct Params {
  direction: vec2f,
  texelSize: vec2f,
  taps: array<vec4f, 8>,
  centerWeight: f32,
  tapCount: u32,
  _pad: vec2f,
};
@group(0) @binding(0) var linearSampler: sampler;
@group(0) @binding(1) var inputTexture: texture_2d<f32>;
@group(0) @binding(2) var<uniform> params: Params;

fn sampleClamped(uv: vec2f) -> f32 {
  let halfTexel = params.texelSize * 0.5;
  return textureSample(inputTexture, linearSampler, clamp(uv, halfTexel, vec2f(1.0) - halfTexel)).r;
}

@fragment fn fs_main(@location(0) uv: vec2f) -> @location(0) vec4f {
  var color = sampleClamped(uv) * params.centerWeight;
  for (var index = 0u; index < MAX_TAPS; index = index + 1u) {
    if (index >= params.tapCount) {
      break;
    }
    let tap = params.taps[index];
    color += sampleClamped(uv + params.direction * tap.x) * tap.y;
    color += sampleClamped(uv - params.direction * tap.x) * tap.y;
  }
  return vec4f(vec3f(color), 1.0);
}
`;

const COMPOSITE_SHADER = /* wgsl */ `
struct Params {
  light: vec2f,          // 0..1 (8 bytes)
  aspect: vec2f,         // 2..3 (8 bytes)
  logoCenter: vec2f,     // 4..5 (8 bytes)
  _pad0: vec2f,          // 6..7 (8 bytes)
  flareColor: vec4f,     // 8..11 (16 bytes, RGB used)
  rimIntensity: f32,     // 12 (4 bytes)
  extension: f32,        // 13 (4 bytes)
  beamIntensity: f32,    // 14 (4 bytes)
  filmGrain: f32,        // 15 (4 bytes)
  smoothness: f32,       // 16 (4 bytes)
  logoOpacity: f32,      // 17 (4 bytes)
  spotFocus: f32,        // 18 (4 bytes)
  scatter: f32,          // 19 (4 bytes)
  rimFill: f32,          // 20 (4 bytes)
  verticalEdgeFade: f32, // 21 (4 bytes)
  frameIndex: u32,       // 22 (4 bytes)
  _pad1: f32,            // 23 (4 bytes)
};
@group(0) @binding(0) var linearSampler: sampler;
@group(0) @binding(1) var sceneTexture: texture_2d<f32>;
@group(0) @binding(2) var rimTexture: texture_2d<f32>;
@group(0) @binding(3) var rimBlurTexture: texture_2d<f32>;
@group(0) @binding(4) var blueNoiseTexture: texture_2d<f32>;
@group(0) @binding(5) var<uniform> params: Params;

fn resolveDarkColor(radiance: vec3f) -> vec3f {
  return max(vec3f(0.0), vec3f(1.0) - exp(-radiance * 1.3));
}

@fragment fn fs_main(@location(0) uv: vec2f) -> @location(0) vec4f {
  let logoTexel = textureSample(sceneTexture, linearSampler, uv);
  let logoMask = logoTexel.a;
  let rimSample = textureSample(rimTexture, linearSampler, uv).r;
  let rimBlur = textureSample(rimBlurTexture, linearSampler, uv).r;
  let direction = uv - params.light;
  let decay = mix(0.85, 0.975, params.extension);
  let density = mix(0.35, 1.15, params.extension);
  let delta = direction * (density / 48.0);
  let dimensions = textureDimensions(rimTexture);
  let pixel = vec2u(clamp(uv * vec2f(dimensions), vec2f(0.0), vec2f(dimensions) - vec2f(1.0)));
  let offset = vec2u(params.frameIndex * 73u, params.frameIndex * 23u);
  let noisePixel = (pixel + offset) & vec2u(127u);
  let blueNoise = textureLoad(blueNoiseTexture, vec2i(noisePixel), 0).r;
  let jitter = fract(blueNoise + f32(params.frameIndex) * 0.61803398875);
  var coordinate = uv - delta * jitter * params.smoothness;
  var illumination = 1.0;
  var illuminationSum = 0.0;
  var rimRays = 0.0;
  for (var i = 0; i < 48; i++) {
    coordinate -= delta;
    let sharpRay = textureSample(rimTexture, linearSampler, coordinate).r;
    let blurredRay = textureSample(rimBlurTexture, linearSampler, coordinate).r;
    rimRays += mix(sharpRay, blurredRay, params.smoothness) * illumination;
    illuminationSum += illumination;
    illumination *= decay;
  }
  rimRays = rimRays / max(illuminationSum, 0.001) * 4.102966;

  let haloDelta = (uv - params.light) * params.aspect;
  let haloRadius = mix(0.05, 0.6, params.spotFocus);
  let halo = exp(-dot(haloDelta, haloDelta) / (haloRadius * haloRadius));
  let lineCoverage = max(logoMask, rimBlur * 0.65);
  let haloLine = halo * lineCoverage * params.rimIntensity * 1.1;
  let spot = max(rimSample, rimBlur * 0.85 * params.rimFill) * (1.0 + halo * 1.5);
  let scatterSignal = rimRays * params.beamIntensity * params.scatter;

  let flareColor = params.flareColor.rgb;

  // 1. Ambient atmosphere with rich, subtle tint
  let ambient = mix(vec3f(0.012, 0.016, 0.038), flareColor * 0.04, 0.5);

  // 2. Soft, colored ambient shadow behind logo (never harsh or solid black)
  let shadowOffset = (uv - params.light) * 0.035;
  let shadowSample = textureSample(sceneTexture, linearSampler, uv - shadowOffset).a;
  let softShadow = smoothstep(0.05, 0.85, shadowSample) * (1.0 - logoMask) * 0.35;
  let baseSpace = mix(ambient * (1.0 - softShadow), flareColor * 0.06, softShadow * 0.25);

  // 3. Volumetric god rays and halo radiance in open canvas space
  var flareRadiance = baseSpace;
  flareRadiance += flareColor * haloLine * (1.0 - logoMask * 0.5);
  flareRadiance += mix(vec3f(1.0), flareColor, 0.4) * spot * params.rimIntensity * 0.70 * (1.0 - logoMask * 0.65);
  flareRadiance += flareColor * scatterSignal;

  // 4. Authentic 3D logo face with delicate specular highlight
  let specularSheen = clamp(spot * 0.55, 0.0, 0.85) * params.rimIntensity;
  let illuminatedLogo = mix(logoTexel.rgb, mix(logoTexel.rgb, vec3f(1.0), 0.45), specularSheen);

  // Smooth composite blend:
  var radiance = mix(flareRadiance, illuminatedLogo, smoothstep(0.02, 0.95, logoMask) * params.logoOpacity);

  let radialMask = smoothstep(1.35, 0.25, length((uv - params.logoCenter) * params.aspect));
  let color = resolveDarkColor(radiance * radialMask);
  let beamSignal = scatterSignal * radialMask;
  let verticalFadeWidth = max(params.verticalEdgeFade, 0.0001);
  let horizontalFadeWidth = verticalFadeWidth * params.aspect.y / max(params.aspect.x, 0.0001);
  let verticalEdgeMask = smoothstep(0.0, verticalFadeWidth, uv.y) * smoothstep(0.0, verticalFadeWidth, 1.0 - uv.y);
  let horizontalEdgeMask = smoothstep(0.0, horizontalFadeWidth, uv.x) * smoothstep(0.0, horizontalFadeWidth, 1.0 - uv.x);
  let edgeMask = verticalEdgeMask * horizontalEdgeMask;
  let composed = mix(vec3f(0.0), color, edgeMask);

  let grainOffset = vec2u(params.frameIndex * 37u + 53u, params.frameIndex * 109u + 17u);
  let grainPixel = (pixel * vec2u(3u, 5u) + grainOffset) & vec2u(127u);
  let grainSample = textureLoad(blueNoiseTexture, vec2i(grainPixel), 0).r;
  let grain = (fract(grainSample + f32(params.frameIndex) * 0.61803398875 + 0.38196601125) - 0.5) * 2.0;
  let beamGate = smoothstep(0.003, 0.05, beamSignal) * (1.0 - smoothstep(0.4, 1.0, beamSignal));
  let logoCoverage = max(logoMask, max(rimSample, rimBlur));
  let grainMask = beamGate * (1.0 - smoothstep(0.02, 0.3, logoCoverage)) * edgeMask;
  let grained = clamp(composed + vec3f(grain * params.filmGrain * grainMask), vec3f(0.0), vec3f(1.0));
  return vec4f(grained, 1.0);
}
`;

// Creates the logo bitmap with authentic 3D ribbon mark and typography
async function loadLogoCanvas() {
  const canvas = document.createElement('canvas');
  canvas.width = 1024;
  canvas.height = 1024;
  const ctx = canvas.getContext('2d');
  if (!ctx) return canvas;

  ctx.clearRect(0, 0, 1024, 1024);

  // 1. Try pre-rendered clean hero-flare-logo.png
  const img = new Image();
  img.crossOrigin = 'anonymous';
  img.src = '/assets/img/ondemand/hero-flare-logo.png';

  const loaded = await new Promise((resolve) => {
    if (img.complete && img.naturalWidth > 0) return resolve(true);
    img.onload = () => resolve(true);
    img.onerror = () => resolve(false);
    setTimeout(() => resolve(false), 2500);
  });

  if (loaded && img.naturalWidth > 0) {
    ctx.drawImage(img, 0, 0, 1024, 1024);
    return canvas;
  }

  // 2. Fallback: Draw logo-mark.png + typography
  const mark = new Image();
  mark.crossOrigin = 'anonymous';
  mark.src = '/assets/img/logo-mark.png';

  const markLoaded = await new Promise((res) => {
    if (mark.complete && mark.naturalWidth > 0) return res(true);
    mark.onload = () => res(true);
    mark.onerror = () => res(false);
    setTimeout(() => res(false), 2000);
  });

  if (markLoaded && mark.naturalWidth > 0) {
    const mw = 440;
    const mh = Math.round(mw * (mark.naturalHeight / mark.naturalWidth));
    const mx = (1024 - mw) / 2;
    const my = 120;
    ctx.drawImage(mark, mx, my, mw, mh);

    // Typography
    ctx.save();
    ctx.textAlign = 'center';
    ctx.textBaseline = 'top';

    const grad = ctx.createLinearGradient(0, my + mh + 16, 0, my + mh + 110);
    grad.addColorStop(0, '#3EE1FF');
    grad.addColorStop(0.5, '#1E7FFF');
    grad.addColorStop(1, '#9D4EDD');
    ctx.fillStyle = grad;
    ctx.font = 'bold 96px "Space Grotesk", "Segoe UI", sans-serif';
    ctx.fillText('iThrive', 512, my + mh + 16);

    ctx.fillStyle = 'rgba(210, 240, 255, 0.9)';
    ctx.font = '600 20px "JetBrains Mono", "Segoe UI", monospace';
    ctx.letterSpacing = '0.35em';
    ctx.fillText('SOFTWARE • ON-DEMAND', 512, my + mh + 116);
    ctx.restore();
  }

  return canvas;
}

export function NextjsFlare({
  spotFocus = 0.08,
  beamIntensity = 0.95,
  extension = 0.60,
  scatter = 1.0,
  rimIntensity = 1.0,
}) {
  const containerRef = useRef(null);
  const canvasRef = useRef(null);
  const [pipelineType, setPipelineType] = useState(null); // 'webgpu' | 'canvas2d'

  const mouseRef = useRef({ x: 0.5, y: 0.38, targetX: 0.5, targetY: 0.38 });
  const hasInteractedRef = useRef(false);
  const lastInteractionRef = useRef(Date.now());

  useEffect(() => {
    const canvas = canvasRef.current;
    const container = containerRef.current;
    if (!canvas || !container) return;

    let isCancelled = false;
    let animId = null;

    // Check WebGPU support
    const initWebGPU = async () => {
      if (!navigator.gpu) return null;
      try {
        const adapter = await navigator.gpu.requestAdapter({ powerPreference: 'high-performance' });
        if (!adapter) return null;
        const device = await adapter.requestDevice();
        return device;
      } catch (e) {
        console.warn('WebGPU request failed, falling back to Canvas 2D:', e);
        return null;
      }
    };

    const run = async () => {
      const device = await initWebGPU();
      if (isCancelled) return;

      const logoCanvas = await loadLogoCanvas();
      if (isCancelled) return;

      if (device) {
        // --- WebGPU Pipeline ---
        setPipelineType('webgpu');

        const ctx = canvas.getContext('webgpu');
        const format = navigator.gpu.getPreferredCanvasFormat();
        ctx.configure({ device, format, alphaMode: 'opaque' });

        const vertModule = device.createShaderModule({ code: VERTEX_SHADER });
        const logoModule = device.createShaderModule({ code: LOGO_SHADER });
        const rimModule = device.createShaderModule({ code: RIM_SHADER });
        const blurModule = device.createShaderModule({ code: BLUR_SHADER });
        const compModule = device.createShaderModule({ code: COMPOSITE_SHADER });

        const dpr = Math.min(window.devicePixelRatio || 1, 2);
        const getDims = () => {
          const rect = container.getBoundingClientRect();
          const cw = Math.max(300, Math.floor((rect.width || 940) * dpr));
          const ch = Math.max(300, Math.floor((rect.height || 520) * dpr));
          return [cw, ch];
        };

        let [w, h] = getDims();
        canvas.width = w;
        canvas.height = h;

        const createTargets = (width, height) => ({
          scene: device.createTexture({ size: [width, height], format: 'rgba8unorm', usage: GPUTextureUsage.RENDER_ATTACHMENT | GPUTextureUsage.TEXTURE_BINDING }),
          rim: device.createTexture({ size: [width, height], format: 'r8unorm', usage: GPUTextureUsage.RENDER_ATTACHMENT | GPUTextureUsage.TEXTURE_BINDING }),
          blurH: device.createTexture({ size: [width, height], format: 'r8unorm', usage: GPUTextureUsage.RENDER_ATTACHMENT | GPUTextureUsage.TEXTURE_BINDING }),
          blurV: device.createTexture({ size: [width, height], format: 'r8unorm', usage: GPUTextureUsage.RENDER_ATTACHMENT | GPUTextureUsage.TEXTURE_BINDING }),
        });

        let targets = createTargets(w, h);

        // Uniform Buffers
        const logoBuffer = device.createBuffer({ size: 32, usage: GPUBufferUsage.UNIFORM | GPUBufferUsage.COPY_DST });
        const rimBuffer = device.createBuffer({ size: 32, usage: GPUBufferUsage.UNIFORM | GPUBufferUsage.COPY_DST });
        const blurHBuffer = device.createBuffer({ size: 160, usage: GPUBufferUsage.UNIFORM | GPUBufferUsage.COPY_DST });
        const blurVBuffer = device.createBuffer({ size: 160, usage: GPUBufferUsage.UNIFORM | GPUBufferUsage.COPY_DST });
        const compBuffer = device.createBuffer({ size: 96, usage: GPUBufferUsage.UNIFORM | GPUBufferUsage.COPY_DST });

        // Fill blur Gaussian taps
        const initBlur = (buffer, dirX, dirY, width, height) => {
          const b = new Float32Array(40);
          b[0] = dirX;
          b[1] = dirY;
          b[2] = 1.0 / width;
          b[3] = 1.0 / height;
          for (let i = 0; i < 8; i++) {
            b[4 + i * 4] = GAUSSIAN_TAPS[i][0];
            b[5 + i * 4] = GAUSSIAN_TAPS[i][1];
            b[6 + i * 4] = 0.0;
            b[7 + i * 4] = 0.0;
          }
          b[36] = 0.07994048; // centerWeight
          new Uint32Array(b.buffer)[37] = 8; // tapCount
          b[38] = 0.0;
          b[39] = 0.0;
          device.queue.writeBuffer(buffer, 0, b);
        };

        initBlur(blurHBuffer, 1.0 / w, 0.0, w, h);
        initBlur(blurVBuffer, 0.0, 1.0 / h, w, h);

        // Pipelines
        const makePipeline = (fragModule, colorFormat = 'r8unorm') => device.createRenderPipeline({
          layout: 'auto',
          vertex: { module: vertModule, entryPoint: 'vs_main' },
          fragment: { module: fragModule, entryPoint: 'fs_main', targets: [{ format: colorFormat }] },
          primitive: { topology: 'triangle-list' },
        });

        const logoPipeline = makePipeline(logoModule, 'rgba8unorm');
        const rimPipeline = makePipeline(rimModule, 'r8unorm');
        const blurPipeline = makePipeline(blurModule, 'r8unorm');
        const compPipeline = makePipeline(compModule, format);

        const linearSampler = device.createSampler({ minFilter: 'linear', magFilter: 'linear' });
        const blueNoiseTexture = getBlueNoiseTexture(device);

        // Upload Logo texture
        const logoTexture = device.createTexture({
          size: [logoCanvas.width, logoCanvas.height, 1],
          format: 'rgba8unorm',
          usage: GPUTextureUsage.TEXTURE_BINDING | GPUTextureUsage.COPY_DST | GPUTextureUsage.RENDER_ATTACHMENT,
        });
        device.queue.copyExternalImageToTexture(
          { source: logoCanvas },
          { texture: logoTexture },
          [logoCanvas.width, logoCanvas.height]
        );

        // ResizeObserver
        const resizeObserver = new ResizeObserver((entries) => {
          for (const entry of entries) {
            const nw = Math.max(300, Math.floor((entry.contentRect.width || 940) * dpr));
            const nh = Math.max(300, Math.floor((entry.contentRect.height || 520) * dpr));
            if (canvas.width !== nw || canvas.height !== nh) {
              canvas.width = nw;
              canvas.height = nh;
              w = nw;
              h = nh;
              targets = createTargets(w, h);
              initBlur(blurHBuffer, 1.0 / w, 0.0, w, h);
              initBlur(blurVBuffer, 0.0, 1.0 / h, w, h);
            }
          }
        });
        resizeObserver.observe(container);

        let frameIdx = 0;
        const renderLoop = (now) => {
          if (isCancelled) return;

          // Autonomous idle drift when user is not moving cursor
          const isIdle = !hasInteractedRef.current || (now - lastInteractionRef.current > 4000);
          if (isIdle) {
            const t = now * 0.001;
            const idleX = 0.5 + Math.sin(t * 0.85) * 0.16;
            const idleY = 0.38 + Math.cos(t * 1.15) * 0.10;
            mouseRef.current.targetX = idleX;
            mouseRef.current.targetY = idleY;
          }

          const m = mouseRef.current;
          m.x += (m.targetX - m.x) * 0.06;
          m.y += (m.targetY - m.y) * 0.06;

          // Signature Brand Color Cycle (Cyan, Sky Blue, Cobalt, Violet, Magenta, Ice)
          const timeSec = now * 0.00045;
          const cycle = timeSec % SIGNATURE_COLORS.length;
          const iA = Math.floor(cycle);
          const iB = (iA + 1) % SIGNATURE_COLORS.length;
          const f = cycle - iA;
          const cA = SIGNATURE_COLORS[iA];
          const cB = SIGNATURE_COLORS[iB];
          const flareColor = [
            cA[0] + (cB[0] - cA[0]) * f,
            cA[1] + (cB[1] - cA[1]) * f,
            cA[2] + (cB[2] - cA[2]) * f,
          ];

          const minDim = Math.min(w, h);
          const aspectX = w / minDim;
          const aspectY = h / minDim;

          const logoDim = 0.72 * minDim;
          const logoScaleX = logoDim / w;
          const logoScaleY = logoDim / h;
          const logoCenterX = 0.5;
          const logoCenterY = 0.46;

          // Logo Uniforms
          const lData = new Float32Array(8);
          lData[0] = logoCenterX;
          lData[1] = logoCenterY;
          lData[2] = logoScaleX;
          lData[3] = logoScaleY;
          lData[4] = 0.0;
          lData[5] = 0.0;
          lData[6] = 1.2;
          lData[7] = 0.0;
          device.queue.writeBuffer(logoBuffer, 0, lData);

          // Rim Uniforms
          const rData = new Float32Array(8);
          rData[0] = m.x;
          rData[1] = m.y;
          rData[2] = 1.0 / w;
          rData[3] = 1.0 / h;
          rData[4] = aspectX;
          rData[5] = aspectY;
          rData[6] = 0.50; // spotReach
          rData[7] = 0.90; // spotStroke
          device.queue.writeBuffer(rimBuffer, 0, rData);

          // Comp Uniforms (24 floats / 96 bytes)
          const cData = new Float32Array(24);
          cData[0] = m.x;
          cData[1] = m.y;
          cData[2] = aspectX;
          cData[3] = aspectY;
          cData[4] = logoCenterX;
          cData[5] = logoCenterY;
          cData[6] = 0.0; // _pad0
          cData[7] = 0.0; // _pad0
          cData[8] = flareColor[0];
          cData[9] = flareColor[1];
          cData[10] = flareColor[2];
          cData[11] = 1.0; // flareColor.w
          cData[12] = rimIntensity;
          cData[13] = extension;
          cData[14] = beamIntensity;
          cData[15] = 0.010; // filmGrain (silky smooth light shafts)
          cData[16] = 1.0; // smoothness
          cData[17] = 1.0; // logoOpacity
          cData[18] = spotFocus;
          cData[19] = scatter;
          cData[20] = 1.0; // rimFill
          cData[21] = 0.10; // verticalEdgeFade
          new Uint32Array(cData.buffer)[22] = frameIdx;
          cData[23] = 0.0; // _pad1
          device.queue.writeBuffer(compBuffer, 0, cData);

          // Render Passes
          const cmd = device.createCommandEncoder();

          // 1. Logo Pass (renders full RGBA color logo to targets.scene)
          const logoPass = cmd.beginRenderPass({
            colorAttachments: [{ view: targets.scene.createView(), clearValue: { r: 0, g: 0, b: 0, a: 0 }, loadOp: 'clear', storeOp: 'store' }]
          });
          logoPass.setPipeline(logoPipeline);
          logoPass.setBindGroup(0, device.createBindGroup({
            layout: logoPipeline.getBindGroupLayout(0),
            entries: [{ binding: 0, resource: linearSampler }, { binding: 1, resource: logoTexture.createView() }, { binding: 2, resource: { buffer: logoBuffer } }]
          }));
          logoPass.draw(6);
          logoPass.end();

          // 2. Rim Pass
          const rimPass = cmd.beginRenderPass({
            colorAttachments: [{ view: targets.rim.createView(), clearValue: { r: 0, g: 0, b: 0, a: 1 }, loadOp: 'clear', storeOp: 'store' }]
          });
          rimPass.setPipeline(rimPipeline);
          rimPass.setBindGroup(0, device.createBindGroup({
            layout: rimPipeline.getBindGroupLayout(0),
            entries: [{ binding: 0, resource: linearSampler }, { binding: 1, resource: targets.scene.createView() }, { binding: 2, resource: { buffer: rimBuffer } }]
          }));
          rimPass.draw(6);
          rimPass.end();

          // 3. Blur H Pass
          const blurHPass = cmd.beginRenderPass({
            colorAttachments: [{ view: targets.blurH.createView(), clearValue: { r: 0, g: 0, b: 0, a: 1 }, loadOp: 'clear', storeOp: 'store' }]
          });
          blurHPass.setPipeline(blurPipeline);
          blurHPass.setBindGroup(0, device.createBindGroup({
            layout: blurPipeline.getBindGroupLayout(0),
            entries: [{ binding: 0, resource: linearSampler }, { binding: 1, resource: targets.rim.createView() }, { binding: 2, resource: { buffer: blurHBuffer } }]
          }));
          blurHPass.draw(6);
          blurHPass.end();

          // 4. Blur V Pass
          const blurVPass = cmd.beginRenderPass({
            colorAttachments: [{ view: targets.blurV.createView(), clearValue: { r: 0, g: 0, b: 0, a: 1 }, loadOp: 'clear', storeOp: 'store' }]
          });
          blurVPass.setPipeline(blurPipeline);
          blurVPass.setBindGroup(0, device.createBindGroup({
            layout: blurPipeline.getBindGroupLayout(0),
            entries: [{ binding: 0, resource: linearSampler }, { binding: 1, resource: targets.blurH.createView() }, { binding: 2, resource: { buffer: blurVBuffer } }]
          }));
          blurVPass.draw(6);
          blurVPass.end();

          // 5. Composite Pass (blends volumetric flare with full RGBA color logo and colored shadow)
          const canvasView = ctx.getCurrentTexture().createView();
          const compPass = cmd.beginRenderPass({
            colorAttachments: [{ view: canvasView, clearValue: { r: 0.012, g: 0.016, b: 0.035, a: 1 }, loadOp: 'clear', storeOp: 'store' }]
          });
          compPass.setPipeline(compPipeline);
          compPass.setBindGroup(0, device.createBindGroup({
            layout: compPipeline.getBindGroupLayout(0),
            entries: [
              { binding: 0, resource: linearSampler },
              { binding: 1, resource: targets.scene.createView() },
              { binding: 2, resource: targets.rim.createView() },
              { binding: 3, resource: targets.blurV.createView() },
              { binding: 4, resource: blueNoiseTexture.createView() },
              { binding: 5, resource: { buffer: compBuffer } }
            ]
          }));
          compPass.draw(6);
          compPass.end();

          device.queue.submit([cmd.finish()]);
          frameIdx++;
          animId = requestAnimationFrame(renderLoop);
        };

        animId = requestAnimationFrame(renderLoop);

        return () => {
          isCancelled = true;
          resizeObserver.disconnect();
          if (animId) cancelAnimationFrame(animId);
        };
      } else {
        // --- Canvas 2D Volumetric Fallback ---
        setPipelineType('canvas2d');

        const ctx = canvas.getContext('2d');
        if (!ctx) return;

        const dpr = Math.min(window.devicePixelRatio || 1, 2);
        const getDims = () => {
          const rect = container.getBoundingClientRect();
          const cw = Math.max(300, Math.floor((rect.width || 940) * dpr));
          const ch = Math.max(300, Math.floor((rect.height || 520) * dpr));
          return [cw, ch];
        };

        let [w, h] = getDims();
        canvas.width = w;
        canvas.height = h;

        const resizeObserver = new ResizeObserver((entries) => {
          for (const entry of entries) {
            const nw = Math.max(300, Math.floor((entry.contentRect.width || 940) * dpr));
            const nh = Math.max(300, Math.floor((entry.contentRect.height || 520) * dpr));
            if (canvas.width !== nw || canvas.height !== nh) {
              canvas.width = nw;
              canvas.height = nh;
              w = nw;
              h = nh;
            }
          }
        });
        resizeObserver.observe(container);

        const render2D = (now) => {
          if (isCancelled) return;

          const isIdle = !hasInteractedRef.current || (now - lastInteractionRef.current > 4000);
          if (isIdle) {
            const t = now * 0.001;
            const idleX = 0.5 + Math.sin(t * 0.85) * 0.16;
            const idleY = 0.38 + Math.cos(t * 1.15) * 0.10;
            mouseRef.current.targetX = idleX;
            mouseRef.current.targetY = idleY;
          }

          const m = mouseRef.current;
          m.x += (m.targetX - m.x) * 0.06;
          m.y += (m.targetY - m.y) * 0.06;

          // Color Cycle
          const timeSec = now * 0.00045;
          const cycle = timeSec % SIGNATURE_COLORS.length;
          const iA = Math.floor(cycle);
          const iB = (iA + 1) % SIGNATURE_COLORS.length;
          const frac = cycle - iA;
          const cA = SIGNATURE_COLORS[iA];
          const cB = SIGNATURE_COLORS[iB];
          const r = Math.round((cA[0] + (cB[0] - cA[0]) * frac) * 255);
          const g = Math.round((cA[1] + (cB[1] - cA[1]) * frac) * 255);
          const b = Math.round((cA[2] + (cB[2] - cA[2]) * frac) * 255);

          // Deep dark cyberpunk space
          ctx.fillStyle = '#030712';
          ctx.fillRect(0, 0, w, h);

          const lx = m.x * w;
          const ly = m.y * h;

          // Volumetric Radial Glow
          const maxDim = Math.max(w, h);
          const grad = ctx.createRadialGradient(lx, ly, 10, lx, ly, maxDim * 0.75);
          grad.addColorStop(0, `rgba(${r}, ${g}, ${b}, 0.55)`);
          grad.addColorStop(0.25, `rgba(${r}, ${g}, ${b}, 0.22)`);
          grad.addColorStop(0.55, `rgba(${r}, ${g}, ${b}, 0.06)`);
          grad.addColorStop(1, 'rgba(3, 7, 18, 0)');
          ctx.fillStyle = grad;
          ctx.fillRect(0, 0, w, h);

          // Volumetric Light Ray Beams
          ctx.save();
          ctx.translate(lx, ly);
          const rays = 18;
          for (let i = 0; i < rays; i++) {
            const angle = (i / rays) * Math.PI * 2 + timeSec * 0.25;
            ctx.rotate(angle);
            ctx.beginPath();
            ctx.moveTo(0, 0);
            ctx.lineTo(maxDim, -16);
            ctx.lineTo(maxDim, 16);
            ctx.closePath();
            ctx.fillStyle = `rgba(${r}, ${g}, ${b}, 0.032)`;
            ctx.fill();
          }
          ctx.restore();

          // Draw Center Logo
          if (logoCanvas) {
            const minDim = Math.min(w, h);
            const logoW = Math.min(minDim * 0.72, 540);
            const logoH = logoW;
            const logoX = (w - logoW) / 2;
            const logoY = (h - logoH) / 2 - 12;

            // Directional soft colored shadow behind logo
            const shadowOffX = (logoX + logoW / 2 - lx) * 0.04;
            const shadowOffY = (logoY + logoH / 2 - ly) * 0.04;

            ctx.save();
            ctx.shadowColor = `rgba(${r}, ${g}, ${b}, 0.35)`;
            ctx.shadowBlur = 30;
            ctx.shadowOffsetX = shadowOffX;
            ctx.shadowOffsetY = shadowOffY;
            ctx.drawImage(logoCanvas, logoX, logoY, logoW, logoH);
            ctx.restore();
          }

          animId = requestAnimationFrame(render2D);
        };

        animId = requestAnimationFrame(render2D);

        return () => {
          isCancelled = true;
          resizeObserver.disconnect();
          if (animId) cancelAnimationFrame(animId);
        };
      }
    };

    let cleanup = null;
    run().then((cl) => { cleanup = cl; });

    return () => {
      isCancelled = true;
      if (cleanup) cleanup();
      if (animId) cancelAnimationFrame(animId);
    };
  }, [spotFocus, beamIntensity, extension, scatter, rimIntensity]);

  // Pointer Interaction
  const handlePointerMove = (e) => {
    const rect = canvasRef.current?.getBoundingClientRect();
    if (!rect) return;
    const nx = Math.min(Math.max((e.clientX - rect.left) / rect.width, 0.02), 0.98);
    const ny = Math.min(Math.max((e.clientY - rect.top) / rect.height, 0.02), 0.98);
    mouseRef.current.targetX = nx;
    mouseRef.current.targetY = ny;
    hasInteractedRef.current = true;
    lastInteractionRef.current = Date.now();
  };

  const handlePointerLeave = () => {
    hasInteractedRef.current = false;
  };

  return (
    <div
      ref={containerRef}
      onPointerMove={handlePointerMove}
      onPointerLeave={handlePointerLeave}
      style={{
        position: 'relative',
        width: '100%',
        height: '100%',
        minHeight: '480px',
        borderRadius: '24px',
        overflow: 'hidden',
        background: '#030712',
        cursor: 'crosshair',
        userSelect: 'none',
      }}
    >
      <canvas
        ref={canvasRef}
        style={{
          position: 'absolute',
          inset: 0,
          width: '100%',
          height: '100%',
          display: 'block',
          touchAction: 'none',
        }}
      />

      {pipelineType && (
        <div
          style={{
            position: 'absolute',
            bottom: '16px',
            right: '16px',
            zIndex: 20,
            pointerEvents: 'none',
            display: 'flex',
            alignItems: 'center',
            gap: '8px',
            padding: '6px 14px',
            borderRadius: '9999px',
            background: 'rgba(0, 0, 0, 0.65)',
            backdropFilter: 'blur(12px)',
            border: '1px solid rgba(255, 255, 255, 0.12)',
            fontSize: '11px',
            fontFamily: 'monospace',
            color: '#38bdf8',
          }}
        >
          <span
            style={{
              display: 'inline-block',
              width: '8px',
              height: '8px',
              borderRadius: '9999px',
              backgroundColor: '#38bdf8',
            }}
          />
          {pipelineType === 'webgpu' ? 'WebGPU Volumetric Flare' : 'Canvas 2D Volumetric Flare'}
        </div>
      )}
    </div>
  );
}

export default NextjsFlare;
