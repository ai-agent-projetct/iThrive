import React, { useEffect, useRef, useState, useMemo } from 'react';
import * as THREE from 'three';

const DISCIPLINE_DATA = [
  {
    num: '01',
    title: 'Full-stack developers',
    tagline: 'Architecture through UI',
    color: '#00F2FE',
    rgb: [0.00, 0.949, 0.996],
    desc: 'From system architecture down to optimistic UI state. Engineers who own the entire vertical slice so features never get stuck between layers.',
    tags: ['Next.js', 'React', 'Node.js', 'PostgreSQL', 'GraphQL'],
    image: '/assets/img/ondemand/role/01a.jpg',
  },
  {
    num: '02',
    title: 'Mobile app developers',
    tagline: 'Native-grade mobile UX',
    color: '#38BDF8',
    rgb: [0.22, 0.741, 0.973],
    desc: 'Flutter, React Native, Swift and Kotlin. Smooth 120fps gesture-driven interfaces, offline-first sync, and rock-solid state machines.',
    tags: ['Flutter', 'React Native', 'Swift', 'Kotlin', 'SQLite'],
    image: '/assets/img/ondemand/role/02a.jpg',
  },
  {
    num: '03',
    title: 'Front-end developers',
    tagline: 'Pixel-perfect, Web Vitals first',
    color: '#6366F1',
    rgb: [0.388, 0.400, 0.945],
    desc: 'React and TypeScript against a rigorous design system, measured on Core Web Vitals and accessibility rather than just a screenshot.',
    tags: ['React', 'TypeScript', 'Tailwind', 'Design Systems', 'Web Vitals'],
    image: '/assets/img/ondemand/role/03a.jpg',
  },
  {
    num: '04',
    title: 'Back-end developers',
    tagline: 'Fault-tolerant distributed systems',
    color: '#9D4EDD',
    rgb: [0.616, 0.306, 0.867],
    desc: 'Python, Go and Node behind resilient APIs designed for real-world failure modes, backpressure, queue processing and high concurrency.',
    tags: ['Python', 'Go', 'FastAPI', 'Redis', 'Docker', 'Kafka'],
    image: '/assets/img/ondemand/role/04a.jpg',
  },
  {
    num: '05',
    title: 'E-commerce developers',
    tagline: 'High-conversion storefronts',
    color: '#EC4899',
    rgb: [0.925, 0.282, 0.600],
    desc: 'Custom headless storefronts, checkout pipelines, and ERP/payment integrations where 100 milliseconds is directly measurable in revenue.',
    tags: ['Shopify Plus', 'Stripe', 'Headless', 'Medusa', 'Next Commerce'],
    image: '/assets/img/ondemand/role/05a.jpg',
  },
];

const VERTEX_SHADER = `
void main() {
  gl_Position = vec4(position, 1.0);
}
`;

const FRAGMENT_SHADER = `
uniform float uTime;
uniform vec2 uResolution;
uniform float uDpr;
uniform vec2 uBoxDim;
uniform vec2 uBoxCenter;
uniform vec3 uColorCenter;
uniform vec3 uColorGlow;
uniform vec3 uBgColor;
uniform float uBoxR;
uniform float uBeamWidth;
uniform float uBeamTaper;
uniform vec2 uBeamOffset;
uniform float uBeamAngle;
uniform float uSpread;
uniform float uAnimationScale;
uniform float uEffectScale;
uniform float uAuraSize;
uniform float uCoreSize;
uniform float uHover;
uniform float uOverdriveGlowMult;
uniform float uShowBeamDust;
uniform float uBeamDustIntensity;
uniform float uBeamDustSpeed;
uniform float uBeamDustScale;
uniform float uShowGrid;
uniform vec3 uGridColor;
uniform float uGridSize;
uniform float uGridDotSize;
uniform float uGridOpacity;

float smin(float a, float b, float k) {
  float h = clamp(0.5 + 0.5 * (b - a) / k, 0.0, 1.0);
  return mix(b, a, h) - k * h * (1.0 - h);
}

float sdBox(in vec2 p, in vec2 b, in float r) {
  vec2 d = abs(p) - b + r;
  return length(max(d, 0.0)) + min(max(d.x, d.y), 0.0) - r;
}

float hash12(vec2 p) {
  vec3 p3 = fract(vec3(p.xyx) * 0.1031);
  p3 += dot(p3, p3.yzx + 33.33);
  return fract((p3.x + p3.y) * p3.z);
}

float vnoise(vec2 p) {
  vec2 i = floor(p);
  vec2 f = fract(p);
  vec2 u = f * f * (3.0 - 2.0 * f);
  return mix(mix(hash12(i + vec2(0.0,0.0)), hash12(i + vec2(1.0,0.0)), u.x),
             mix(hash12(i + vec2(0.0,1.0)), hash12(i + vec2(1.0,1.0)), u.x), u.y);
}

float fbm(vec2 p) {
  float v = 0.0;
  float a = 0.5;
  mat2 rot = mat2(0.866, -0.5, 0.5, 0.866);
  for (int i = 0; i < 4; ++i) {
    v += a * vnoise(p);
    p = rot * p * 2.0;
    a *= 0.5;
  }
  return v;
}

void main() {
  vec2 p = gl_FragCoord.xy - uResolution.xy * 0.5;
  float t = uTime;

  // Box bounds
  vec2 boxP = p - uBoxCenter;
  float dBox = sdBox(boxP, uBoxDim, uBoxR * uDpr);

  // Directional beam mapping
  vec2 rp = p - (uBoxCenter + uBeamOffset);
  float c = cos(uBeamAngle);
  float s = sin(uBeamAngle);
  vec2 bp = vec2(rp.x * c - rp.y * s, rp.x * s + rp.y * c);
  vec2 np = bp * uAnimationScale;
  float symY = abs(np.y);

  float distToBox = max(dBox, 0.0);
  float taperRatio = exp(-distToBox / (70.0 * uDpr));
  float baseWidth = (uBeamWidth + uBeamTaper * taperRatio) * uDpr;

  float flowTime = t * 3.0;
  float n1 = fbm(vec2(np.x * 0.02, symY * 0.01 + flowTime * 0.4));
  float n2 = fbm(vec2(np.x * 0.05 - flowTime * 0.1, symY * 0.02 + flowTime * 0.7));
  float cloudSmoke = (n1 + n2) * 0.5;
  float streaks = fbm(vec2(np.x * 0.15, symY * 0.002 + flowTime * 1.0));
  float pulse = pow(sin(symY * 0.005 + t * 2.5) * 0.5 + 0.5, 12.0);

  float baseSmoke = smoothstep(0.2, 0.8, cloudSmoke) * 0.4 + smoothstep(0.3, 0.7, streaks) * 0.4;
  float smokyEffect = baseSmoke + pulse * 0.6;

  float beamThickening = mix(1.0, 1.25, uHover);
  float currentBeamWidth = baseWidth * (0.8 + 0.4 * baseSmoke * uEffectScale + 0.6 * pulse * uEffectScale) * beamThickening;
  float dBeam = abs(bp.x) - currentBeamWidth;

  float dMerge = smin(dBox, dBeam, uSpread * uDpr);
  float dist = max(dMerge, 0.0);

  float auraRadius = uAuraSize * uDpr;
  float coreRadius = uCoreSize * uDpr;

  float aura = pow(auraRadius / (dist + auraRadius), 2.2) * 0.5;
  float core = pow(coreRadius / (dist + coreRadius), 3.0) * 0.8;

  float awayFromBox = smoothstep(0.0, uSpread * uDpr * 1.5, distToBox);
  float hardMask = smoothstep(1.0, -1.0, dMerge);
  float innerMask = hardMask * mix(1.0, 0.0, awayFromBox);

  float softBeamCore = smoothstep(currentBeamWidth * 2.0, 0.0, max(dBeam, 0.0));
  float beamEnergy = softBeamCore * smokyEffect * awayFromBox;

  float overdriveGlow = mix(1.0, uOverdriveGlowMult, uHover);
  core += beamEnergy * 1.2 * overdriveGlow;
  aura += beamEnergy * 0.6 * overdriveGlow;

  vec3 finalCol = uBgColor;

  if (uShowGrid > 0.5) {
    float cellSize = max(uGridSize, 1.0) * uDpr;
    vec2 gridFract = fract((p - uBoxCenter) / cellSize) - 0.5;
    float dotDist = length(gridFract);
    float dotRadius = uGridDotSize * 0.5;
    float blur = 1.0 / cellSize;
    float dotMask = smoothstep(dotRadius + blur, dotRadius - blur, dotDist);
    finalCol = mix(finalCol, uGridColor, dotMask * uGridOpacity);
  }

  finalCol += uColorGlow * aura;
  finalCol += mix(uColorGlow, uColorCenter, 0.6) * core;
  finalCol = mix(finalCol, uColorCenter, innerMask * 0.15);

  // Beam particles
  if (uShowBeamDust > 0.5) {
    float dBeamArea = max(dBeam, 0.0);
    float beamMask = smoothstep(40.0 * uDpr, -10.0 * uDpr, dBeamArea);
    float boxFadeOut = smoothstep(-20.0 * uDpr, 50.0 * uDpr, dBox);

    if (beamMask > 0.0 && boxFadeOut > 0.0) {
      float dust = 0.0;
      for (int i = 0; i < 4; i++) {
        float fi = float(i);
        float layerScale = uBeamDustScale * (1.0 + fi * 0.35);
        vec2 uv = vec2(bp.x, abs(bp.y)) / max(uResolution.x, uResolution.y) * layerScale;
        float fallSpeed = uBeamDustSpeed * (1.2 + hash12(vec2(fi)) * 0.8);
        uv.y += uTime * fallSpeed;
        uv.x += sin(abs(bp.y) * 0.01 + uTime * 5.0 + fi) * 0.02;

        vec2 gridId = floor(uv);
        vec2 gridP = fract(uv);
        vec2 offset = vec2(hash12(gridId * 15.3 + fi), hash12(gridId * 3.7 - fi)) * 0.7 + 0.15;
        float dDist = length(gridP - offset);
        float particleRadius = (hash12(gridId * 7.1) * 0.02 + 0.005);
        float twinkle = 0.5 + 0.5 * sin(uTime * 20.0 + hash12(gridId) * 100.0);
        float particle = smoothstep(particleRadius + 0.04, particleRadius, dDist) * twinkle;
        float densityGate = step(0.5, hash12(gridId * 2.2));
        dust += particle * densityGate * (0.4 + 0.6 * hash12(gridId * 9.5));
      }
      finalCol += mix(uColorGlow, vec3(1.0), 0.7) * dust * uBeamDustIntensity * beamMask * boxFadeOut;
    }
  }

  gl_FragColor = vec4(finalCol, 1.0);
}
`;

export default function EnergyBeamDisciplines(props) {
  const disciplines = props.disciplines && props.disciplines.length > 0 ? props.disciplines : DISCIPLINE_DATA;
  const containerRef = useRef(null);
  const canvasRef = useRef(null);
  const cardRef = useRef(null);
  const [activeIndex, setActiveIndex] = useState(0);
  const [isHovered, setIsHovered] = useState(false);
  const uniformsRef = useRef(null);

  const activeDiscipline = disciplines[activeIndex] || disciplines[0];

  useEffect(() => {
    const canvas = canvasRef.current;
    const container = containerRef.current;
    if (!canvas || !container) return;

    let isCancelled = false;
    let rafId = 0;

    const renderer = new THREE.WebGLRenderer({
      canvas,
      alpha: true,
      antialias: false,
      powerPreference: 'high-performance',
    });
    const dpr = Math.min(window.devicePixelRatio || 1, 2);
    renderer.setPixelRatio(dpr);

    const scene = new THREE.Scene();
    const camera = new THREE.OrthographicCamera(-1, 1, 1, -1, 0, 1);
    const geometry = new THREE.PlaneGeometry(2, 2);

    const initialRgb = DISCIPLINE_DATA[0].rgb;
    const uniforms = {
      uTime: { value: 0 },
      uResolution: { value: new THREE.Vector2() },
      uDpr: { value: dpr },
      uBoxDim: { value: new THREE.Vector2(320, 240) },
      uBoxCenter: { value: new THREE.Vector2(0, 0) },
      uColorCenter: { value: new THREE.Color(1.0, 1.0, 1.0) },
      uColorGlow: { value: new THREE.Color(initialRgb[0], initialRgb[1], initialRgb[2]) },
      uBgColor: { value: new THREE.Color(0.02, 0.03, 0.07) },
      uBoxR: { value: 36 },
      uBeamWidth: { value: 6 },
      uBeamTaper: { value: 36 },
      uBeamOffset: { value: new THREE.Vector2(0, 24) },
      uBeamAngle: { value: 0 },
      uSpread: { value: 0 },
      uAnimationScale: { value: 0.4 },
      uEffectScale: { value: 0.25 },
      uAuraSize: { value: 280 },
      uCoreSize: { value: 45 },
      uHover: { value: 0 },
      uOverdriveGlowMult: { value: 2.4 },
      uShowBeamDust: { value: 1.0 },
      uBeamDustIntensity: { value: 2.8 },
      uBeamDustSpeed: { value: 0.12 },
      uBeamDustScale: { value: 50 },
      uShowGrid: { value: 1.0 },
      uGridColor: { value: new THREE.Color(0.85, 0.92, 1.0) },
      uGridSize: { value: 8 },
      uGridDotSize: { value: 0.95 },
      uGridOpacity: { value: 0.035 },
    };
    uniformsRef.current = uniforms;

    const material = new THREE.ShaderMaterial({
      vertexShader: VERTEX_SHADER,
      fragmentShader: FRAGMENT_SHADER,
      uniforms,
      depthTest: false,
      depthWrite: false,
    });

    const mesh = new THREE.Mesh(geometry, material);
    scene.add(mesh);

    const updateDimensions = () => {
      if (!container || !canvas) return;
      const width = container.clientWidth || 940;
      const height = container.clientHeight || 640;
      renderer.setSize(width, height, false);
      uniforms.uResolution.value.set(width * dpr, height * dpr);

      // Measure center card dimensions to perfectly sync shader SDF box
      if (cardRef.current) {
        const cw = cardRef.current.offsetWidth * dpr;
        const ch = cardRef.current.offsetHeight * dpr;
        uniforms.uBoxDim.value.set(cw * 0.5, ch * 0.5);
      }
    };

    updateDimensions();
    window.addEventListener('resize', updateDimensions);

    let startTime = performance.now();
    const targetGlowColor = new THREE.Color(...initialRgb);

    const animate = (time) => {
      if (isCancelled) return;
      const elapsed = (time - startTime) * 0.001;
      uniforms.uTime.value = elapsed;

      // Smooth color morphing to active discipline color
      uniforms.uColorGlow.value.lerp(targetGlowColor, 0.08);

      // Smooth hover lerp
      const targetHover = isHovered ? 1.0 : 0.0;
      uniforms.uHover.value += (targetHover - uniforms.uHover.value) * 0.1;

      renderer.render(scene, camera);
      rafId = requestAnimationFrame(animate);
    };

    rafId = requestAnimationFrame(animate);

    return () => {
      isCancelled = true;
      cancelAnimationFrame(rafId);
      window.removeEventListener('resize', updateDimensions);
      geometry.dispose();
      material.dispose();
      renderer.dispose();
    };
  }, []);

  // Update target glow color when active discipline changes
  useEffect(() => {
    if (uniformsRef.current && activeDiscipline) {
      const [r, g, b] = activeDiscipline.rgb;
      uniformsRef.current.uColorGlow.value.setRGB(r, g, b);
      if (cardRef.current && containerRef.current) {
        const dpr = Math.min(window.devicePixelRatio || 1, 2);
        const cw = cardRef.current.offsetWidth * dpr;
        const ch = cardRef.current.offsetHeight * dpr;
        uniformsRef.current.uBoxDim.value.set(cw * 0.5, ch * 0.5);
      }
    }
  }, [activeIndex, activeDiscipline]);

  return (
    <div
      ref={containerRef}
      style={{
        position: 'relative',
        width: '100%',
        minHeight: '640px',
        height: 'clamp(620px, 75vh, 760px)',
        overflow: 'hidden',
        background: '#02040A',
        borderRadius: '28px',
        border: '1px solid rgba(255, 255, 255, 0.08)',
        boxShadow: '0 30px 90px -20px rgba(0, 0, 0, 0.95)',
        display: 'flex',
        flexDirection: 'column',
        alignItems: 'center',
        justifyContent: 'center',
      }}
      onMouseEnter={() => setIsHovered(true)}
      onMouseLeave={() => setIsHovered(false)}
    >
      {/* Background Three.js Shader Canvas */}
      <canvas
        ref={canvasRef}
        style={{
          position: 'absolute',
          inset: 0,
          width: '100%',
          height: '100%',
          pointerEvents: 'none',
        }}
      />

      {/* Foreground Interactive Card (aligned with the volumetric beam suction) */}
      <div
        ref={cardRef}
        style={{
          position: 'relative',
          zIndex: 10,
          width: 'min(780px, 92%)',
          borderRadius: '36px',
          background: 'rgba(6, 11, 24, 0.92)',
          backdropFilter: 'blur(20px)',
          border: `1px solid ${activeDiscipline.color}66`,
          boxShadow: `0 24px 60px -15px rgba(0, 0, 0, 0.9), 0 0 40px ${activeDiscipline.color}26`,
          overflow: 'hidden',
          display: 'grid',
          gridTemplateColumns: 'minmax(0, 1.25fr) minmax(0, 1fr)',
          transition: 'border 0.4s ease, box-shadow 0.4s ease',
        }}
      >
        {/* Left Content Area */}
        <div
          style={{
            padding: 'clamp(24px, 3.5vw, 44px)',
            display: 'flex',
            flexDirection: 'column',
            justifyContent: 'space-between',
            zIndex: 2,
          }}
        >
          <div>
            <div
              style={{
                display: 'inline-flex',
                alignItems: 'center',
                gap: '8px',
                padding: '6px 14px',
                borderRadius: '999px',
                background: `${activeDiscipline.color}18`,
                border: `1px solid ${activeDiscipline.color}4d`,
                marginBottom: '18px',
              }}
            >
              <span
                style={{
                  fontFamily: 'Fira Code, monospace',
                  fontSize: '12px',
                  fontWeight: 800,
                  color: activeDiscipline.color,
                }}
              >
                {activeDiscipline.num}
              </span>
              <span
                style={{
                  fontSize: '11px',
                  fontWeight: 700,
                  color: '#E2E8F0',
                  letterSpacing: '0.06em',
                  textTransform: 'uppercase',
                }}
              >
                {activeDiscipline.tagline}
              </span>
            </div>

            <h3
              style={{
                fontSize: 'clamp(1.7rem, 2.5vw, 2.2rem)',
                fontWeight: 800,
                color: '#F8FAFC',
                lineHeight: 1.2,
                letterSpacing: '-0.02em',
                margin: '0 0 14px',
              }}
            >
              {activeDiscipline.title}
            </h3>

            <p
              style={{
                fontSize: 'clamp(0.9rem, 1.05vw, 1rem)',
                lineHeight: 1.65,
                color: '#94A3B8',
                margin: '0 0 20px',
              }}
            >
              {activeDiscipline.desc}
            </p>

            <div
              style={{
                display: 'flex',
                flexWrap: 'wrap',
                gap: '8px',
                marginBottom: '20px',
              }}
            >
              {activeDiscipline.tags.map((tag) => (
                <span
                  key={tag}
                  style={{
                    padding: '4px 10px',
                    borderRadius: '6px',
                    background: 'rgba(255, 255, 255, 0.05)',
                    border: '1px solid rgba(255, 255, 255, 0.08)',
                    fontSize: '11px',
                    fontFamily: 'Fira Code, monospace',
                    color: '#CBD5E1',
                  }}
                >
                  {tag}
                </span>
              ))}
            </div>
          </div>

          <div>
            <button
              type="button"
              className="od-btn od-btn--primary"
              data-modal-open
              data-modal-service={`Hire ${activeDiscipline.title}`}
              style={{
                background: `linear-gradient(90deg, ${activeDiscipline.color}, #3B82F6)`,
                color: '#040711',
                fontWeight: 800,
                boxShadow: `0 6px 20px ${activeDiscipline.color}40`,
                cursor: 'pointer',
              }}
            >
              Deploy this discipline →
            </button>
          </div>
        </div>

        {/* Right Relevant Image Showcase */}
        <div
          style={{
            position: 'relative',
            height: '100%',
            minHeight: '280px',
            overflow: 'hidden',
            background: '#040711',
            display: 'flex',
            alignItems: 'center',
            justifyContent: 'center',
          }}
        >
          <img
            src={activeDiscipline.image}
            alt={activeDiscipline.title}
            style={{
              width: '100%',
              height: '100%',
              objectFit: 'cover',
              filter: 'contrast(1.05) brightness(0.95)',
              transition: 'opacity 0.4s ease',
            }}
          />
          {/* Subtle gradient overlay on image */}
          <div
            style={{
              position: 'absolute',
              inset: 0,
              background: `linear-gradient(to right, rgba(6, 11, 24, 0.95) 0%, transparent 40%), linear-gradient(to top, rgba(6, 11, 24, 0.8) 0%, transparent 50%)`,
              pointerEvents: 'none',
            }}
          />
        </div>
      </div>

      {/* Discipline Navigation Tabs */}
      <div
        style={{
          position: 'relative',
          zIndex: 20,
          marginTop: '28px',
          display: 'flex',
          alignItems: 'center',
          gap: '10px',
          padding: '8px 16px',
          borderRadius: '999px',
          background: 'rgba(6, 11, 24, 0.85)',
          backdropFilter: 'blur(16px)',
          border: '1px solid rgba(255, 255, 255, 0.12)',
          boxShadow: '0 12px 36px rgba(0, 0, 0, 0.6)',
        }}
      >
        {disciplines.map((disc, idx) => {
          const isSelected = activeIndex === idx;
          return (
            <button
              key={disc.num}
              type="button"
              onClick={() => setActiveIndex(idx)}
              style={{
                display: 'flex',
                alignItems: 'center',
                gap: '6px',
                padding: isSelected ? '6px 14px' : '6px 10px',
                borderRadius: '999px',
                background: isSelected ? disc.color : 'transparent',
                color: isSelected ? '#040711' : 'rgba(226, 232, 240, 0.65)',
                fontWeight: isSelected ? 800 : 500,
                fontSize: '12px',
                fontFamily: 'Inter, sans-serif',
                border: 'none',
                cursor: 'pointer',
                transition: 'all 0.3s cubic-bezier(0.16, 1, 0.3, 1)',
              }}
            >
              <span>{disc.num}</span>
              {isSelected && <span>{disc.title.split(' ')[0]}</span>}
            </button>
          );
        })}
      </div>

      <p
        style={{
          position: 'relative',
          zIndex: 20,
          marginTop: '10px',
          fontSize: '11px',
          color: 'rgba(148, 163, 184, 0.7)',
          fontFamily: 'Fira Code, monospace',
          letterSpacing: '0.04em',
        }}
      >
        Click to switch disciplines & watch the flare pulse
      </p>
    </div>
  );
}
