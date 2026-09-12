/**
 * OriginKit Liquid Sphere WebGL2 Component (preset="base")
 * Exact raymarched glass liquid shader from OriginKit
 * https://www.originkit.dev/components/liquid-sphere?preset=base
 */

const VS_SOURCE = `#version 300 es
precision highp float;
const vec2 P[3] = vec2[3](vec2(-1.0, -1.0), vec2(3.0, -1.0), vec2(-1.0, 3.0));
void main() { gl_Position = vec4(P[gl_VertexID], 0.0, 1.0); }`;

const FS_SOURCE = `#version 300 es
// highp is mandatory here: the march tests against 4e-4 and the speculars go to
// pow(x, 380). See the file header.
precision highp float;

uniform vec2 uSize;
uniform float uTime;
uniform float uStyle;
uniform float uSpeed;
uniform float uWaveFreq;
uniform float uAmplitude;
// Uniform scale on the whole orb. An SDF scales linearly under uniform
// coordinate scaling, so evaluating goMap at p/uOrbSize and multiplying the
// result back by uOrbSize grows or shrinks the sphere without touching a
// single style's displacement numbers.
uniform float uOrbSize;
uniform vec3 uTint;
uniform vec3 uCore;
uniform vec3 uHighlight;
// xy: the pointer in the same uv space as the fragment. z: presence, 0..1.
uniform vec3 uPointer;
uniform float uHover;
uniform float uReach;
// xy: click position in uv space, same convention as uPointer. z: seconds
// since the last press \u2014 ages out through CLICK_LIFE below, no reset needed.
uniform vec3 uClick;
// The orb's own rotation. The ray is marched in its frame, not the world's.
uniform mat3 uRot;

// What Hover 100% is worth on each of the three things it moves. Constants, not
// dials: they are the SHAPE of the gesture, and splitting them into three
// sliders would be three dials for one decision (rule 11b).
const float HOVER_DEPTH = 1.6;    // extra ripple amplitude
const float HOVER_CLARITY = 0.55; // absorption removed, so the swell glows
const float HOVER_GLINT = 1.5;    // extra highlight on the crests

// A press launches a ring that expands outward from the click point and fades
// as it goes \u2014 the same three levers as Hover (deeper, clearer, brighter),
// driven by distance-from-ring instead of distance-from-pointer.
const float CLICK_DEPTH = 1.3;
const float CLICK_CLARITY = 0.6;
const float CLICK_GLINT = 1.8;
const float CLICK_SPEED = 1.4;  // ring radius growth, uv units per second
const float CLICK_WIDTH = 0.30; // ring thickness, uv units
const float CLICK_LIFE = 1.6;   // e-fold decay, seconds

out vec4 fragColor;

// Ray vs. bounding sphere - (near, far) hits, or (-1,-1) on a miss.
vec2 goSph(vec3 ro, vec3 rd, float rad) {
    float b = dot(ro, rd);
    float c = dot(ro, ro) - rad * rad;
    float h = b * b - c;
    if (h < 0.0) return vec2(-1.0);
    float hs = sqrt(h);
    return vec2(-b - hs, -b + hs);
}

// Per-style surface displacement. fr multiplies the ripple frequency, amp
// scales the depth - both 1.0 at default.
float goWaveDisp(vec3 p, float t, float fr, float amp, int style) {
    float disp = 0.0;
    if (style == 1) {                                   // Ember
        vec3 q = normalize(p) * 3.0;
        float uu = q.x * 0.90 + q.y * 0.45 + q.z * 0.25;
        uu = uu + 0.35 * sin(q.y * 1.5 + t * 0.50);
        uu = uu + 0.18 * sin(q.z * 2.1 - t * 0.55);
        float vv = q.z * 0.70 + q.x * 0.55 + q.y * 0.45;
        vv = vv + 0.30 * sin(q.x * 1.6 - t * 0.55);
        vv = vv + 0.16 * sin(q.y * 2.0 + t * 0.60);
        disp = 0.040 * sin(uu * 5.5 * fr) + 0.032 * sin(vv * 5.0 * fr);
    } else if (style == 2) {                            // Mint
        vec3 q = normalize(p) * 4.0;
        float uu = q.x * 0.85 + q.y * 0.50 + q.z * 0.20;
        uu = uu + 0.25 * sin(q.y * 1.1 + t * 0.28);
        uu = uu + 0.15 * sin(q.z * 1.9 - t * 0.30);
        float vv = q.z * 0.70 + q.x * 0.55 + q.y * 0.45;
        vv = vv + 0.22 * sin(q.x * 1.3 - t * 0.30);
        vv = vv + 0.13 * sin(q.y * 2.0 + t * 0.32);
        disp = 0.026 * sin(uu * 9.0 * fr) + 0.022 * sin(vv * 8.5 * fr);
    } else if (style == 3) {                            // Frost
        vec3 q = normalize(p) * 3.5;
        float uu = q.x * 0.85 + q.y * 0.50 + q.z * 0.20;
        uu = uu + 0.30 * sin(q.y * 1.2 + t * 0.20);
        uu = uu + 0.18 * sin(q.z * 2.1 - t * 0.25);
        uu = uu + 0.10 * sin(q.y * 3.5 + q.z * 2.8 + t * 0.18);
        float vv = q.z * 0.70 + q.x * 0.55 + q.y * 0.45;
        vv = vv + 0.28 * sin(q.x * 1.3 - t * 0.22);
        vv = vv + 0.16 * sin(q.y * 2.4 + t * 0.30);
        vv = vv + 0.09 * sin(q.x * 3.2 + q.z * 2.5 - t * 0.20);
        disp = 0.038 * sin(uu * 7.5 * fr) + 0.030 * sin(vv * 7.0 * fr);
    } else if (style == 4) {                            // Sky
        vec3 q = normalize(p) * 3.0;
        float uu = q.x * 0.85 + q.y * 0.50 + q.z * 0.20;
        uu = uu + 0.28 * sin(q.y * 1.0 + t * 0.18);
        uu = uu + 0.14 * sin(q.z * 1.6 - t * 0.22);
        float vv = q.z * 0.70 + q.x * 0.55 + q.y * 0.45;
        vv = vv + 0.25 * sin(q.x * 1.1 - t * 0.20);
        vv = vv + 0.12 * sin(q.y * 1.7 + t * 0.24);
        disp = 0.022 * sin(uu * 6.5 * fr) + 0.018 * sin(vv * 6.0 * fr);
    } else if (style == 5) {                            // Storm
        vec3 q = normalize(p) * 3.5;
        float uu = q.x * 0.85 + q.y * 0.50 + q.z * 0.20;
        uu = uu + 0.32 * sin(q.y * 1.6 + t * 0.50);
        uu = uu + 0.20 * sin(q.z * 2.3 - t * 0.60);
        float vv = q.z * 0.70 + q.x * 0.55 + q.y * 0.45;
        vv = vv + 0.28 * sin(q.x * 1.7 + t * 0.55);
        vv = vv + 0.18 * sin(q.y * 2.4 - t * 0.70);
        disp = 0.042 * sin(uu * 6.5 * fr)
             + 0.034 * sin(vv * 6.0 * fr)
             + 0.018 * sin((uu + vv) * 8.5 * fr + t * 0.4);
    } else if (style == 6) {                            // Coral
        vec3 q = normalize(p) * 3.3;
        float uu = q.x * 0.85 + q.y * 0.50 + q.z * 0.20;
        uu = uu + 0.32 * sin(q.y * 1.2 + t * 0.30);
        uu = uu + 0.18 * sin(q.z * 1.8 - t * 0.28);
        float vv = -q.x * 0.55 + q.z * 0.65 + q.y * 0.40;  // crossed band
        vv = vv + 0.28 * sin(q.x * 1.3 + t * 0.35);
        vv = vv + 0.16 * sin(q.y * 2.0 - t * 0.25);
        disp = 0.040 * sin(uu * 6.5 * fr) + 0.034 * sin(vv * 6.0 * fr);
    } else if (style == 7) {                            // Ice
        vec3 q = normalize(p) * 4.0;
        float uu = q.x * 0.85 + q.y * 0.50 + q.z * 0.20;
        uu = uu + 0.22 * sin(q.y * 1.4 + t * 0.22);
        uu = uu + 0.13 * sin(q.z * 2.3 - t * 0.18);
        float vv = q.z * 0.70 + q.x * 0.55 + q.y * 0.45;
        vv = vv + 0.20 * sin(q.x * 1.5 - t * 0.22);
        vv = vv + 0.12 * sin(q.y * 2.5 + t * 0.20);
        disp = 0.030 * sin(uu * 10.0 * fr) + 0.025 * sin(vv * 9.5 * fr);
    } else if (style == 8) {                            // Magenta
        vec3 q = normalize(p) * 4.0;
        float uu = q.x * 0.85 + q.y * 0.50 + q.z * 0.20;
        uu = uu + 0.25 * sin(q.y * 1.4 + t * 0.55);
        uu = uu + 0.14 * sin(q.z * 2.0 - t * 0.45);
        float vv = q.z * 0.70 + q.x * 0.55 + q.y * 0.45;
        vv = vv + 0.22 * sin(q.x * 1.5 - t * 0.50);
        vv = vv + 0.13 * sin(q.y * 2.2 + t * 0.45);
        disp = 0.030 * sin(uu * 9.5 * fr + t * 0.45) + 0.025 * sin(vv * 9.0 * fr - t * 0.40);
    } else {                                            // Wave (style 0)
        vec3 q = normalize(p) * 3.5;
        float uu = q.x * 0.85 + q.y * 0.50 + q.z * 0.20;
        uu = uu + 0.32 * sin(q.y * 1.0 + t * 0.30);
        uu = uu + 0.22 * sin(q.z * 1.3 - t * 0.35);
        uu = uu + 0.14 * sin(q.y * 1.9 + q.z * 1.6 + t * 0.25);
        float vv = q.z * 0.70 + q.x * 0.55 + q.y * 0.45;
        vv = vv + 0.30 * sin(q.x * 1.2 - t * 0.32);
        vv = vv + 0.20 * sin(q.y * 1.5 + t * 0.45);
        vv = vv + 0.14 * sin(q.z * 1.9 + q.x * 1.6 + t * 0.28);
        disp = 0.042 * sin(uu * 7.0 * fr) + 0.034 * sin(vv * 6.5 * fr);
    }
    return disp * amp;
}

float goMap(vec3 p, float t, float fr, float amp, int style) {
    return length(p) - 1.0 - goWaveDisp(p, t, fr, amp, style);
}

vec3 goNormal(vec3 p, float t, float e, float fr, float amp, int style) {
    vec2 k = vec2(1.0, -1.0);
    return normalize(
        k.xyy * goMap(p + k.xyy * e, t, fr, amp, style) +
        k.yyx * goMap(p + k.yyx * e, t, fr, amp, style) +
        k.yxy * goMap(p + k.yxy * e, t, fr, amp, style) +
        k.xxx * goMap(p + k.xxx * e, t, fr, amp, style)
    );
}

// Sum of a style's final-band amplitudes - sizes the bounding sphere so the
// displaced surface always fits inside it, at any amplitude.
float goAmpSum(int style) {
    if (style == 1) return 0.072;
    if (style == 2) return 0.048;
    if (style == 3) return 0.068;
    if (style == 4) return 0.040;
    if (style == 5) return 0.094;
    if (style == 6) return 0.074;
    if (style == 7) return 0.055;
    if (style == 8) return 0.055;
    return 0.076;
}

// Base Lipschitz divisor for safe sphere-tracing of each style.
float goLip(int style) {
    if (style == 1) return 2.5;
    if (style == 2) return 3.0;
    if (style == 3) return 2.8;
    if (style == 4) return 2.2;
    if (style == 5) return 3.0;
    if (style == 6) return 2.5;
    if (style == 7) return 3.5;
    if (style == 8) return 3.5;
    return 2.0;
}

vec3 goLight1(int style) {
    if (style == 1) return normalize(vec3(0.55, 0.80, 0.55));
    if (style == 2) return normalize(vec3(-0.45, 0.85, 0.55));
    if (style == 6) return normalize(vec3(-0.50, 0.85, 0.55));
    if (style == 7) return normalize(vec3(-0.50, 0.85, 0.55));
    if (style == 8) return normalize(vec3(-0.50, 0.85, 0.55));
    return normalize(vec3(-0.55, 0.85, 0.55));
}

vec3 goLight2(int style) {
    if (style == 1) return normalize(vec3(-0.40, 0.30, 0.80));
    if (style == 2) return normalize(vec3(0.50, 0.30, 0.75));
    if (style == 6) return normalize(vec3(0.50, 0.30, 0.75));
    if (style == 7) return normalize(vec3(0.45, 0.30, 0.80));
    if (style == 8) return normalize(vec3(0.45, 0.30, 0.80));
    return normalize(vec3(0.40, 0.30, 0.80));
}

void main() {
    vec2 size = uSize;
    // The source works in SwiftUI's top-left-origin position space, so the row
    // index is flipped out of GL's bottom-up gl_FragCoord before anything else.
    vec2 pos = vec2(gl_FragCoord.x, size.y - gl_FragCoord.y);
    vec2 uv = (pos - 0.5 * size) / min(size.x, size.y);
    uv = uv * 2.0;

    int style = int(uStyle);
    float fr = uWaveFreq;
    float t = uTime * uSpeed;

    vec3 ro = vec3(0.0, 0.0, 3.0);
    vec3 rd = normalize(vec3(uv, -1.8));

    float ampSum = goAmpSum(style);

    // The orb's own screen radius: a ray from this camera is tangent to a
    // sphere of radius R at |uv| = 1.8R / sqrt(9 - R*R). Reach is a fraction of
    // THAT, so it keeps meaning the same thing when Depth changes the bound.
    float rDial = (1.0 + ampSum * uAmplitude + 0.04) * uOrbSize;
    float orbUv = 1.8 * rDial / sqrt(max(9.0 - rDial * rDial, 1e-4));

    // Pointer influence, measured in SCREEN space so the swell follows the
    // cursor instead of sticking to a point on a turning surface.
    float reach = max(uReach * orbUv, 1e-4);
    // A plain smoothstep falloff, NOT squared: squaring pulls the whole
    // response into the last few pixels under the cursor, where it reads as
    // noise in the ripples rather than as a swell.
    float w = uPointer.z * (1.0 - smoothstep(0.0, reach, length(uv - uPointer.xy)));

    // The click ring: a Gaussian band at radius CLICK_SPEED\xB7age, fading with
    // age. Distance is measured in the same screen uv as the hover swell, so
    // both gestures compose through the same three levers below.
    float clickAge = max(uClick.z, 0.0);
    float ringR = clickAge * CLICK_SPEED;
    float ringDist = length(uv - uClick.xy) - ringR;
    float ring = exp(-(ringDist * ringDist) / (CLICK_WIDTH * CLICK_WIDTH))
               * exp(-clickAge / CLICK_LIFE);

    float amp = uAmplitude * (1.0 + HOVER_DEPTH * uHover * w + CLICK_DEPTH * ring);

    // Both of these follow the LOCAL amplitude, not the dial's: a deepened
    // ripple that pokes outside the bound is either clipped off or marched
    // into, and the Lipschitz divisor has to grow with it for the same reason.
    float boundRad = 1.0 + ampSum * amp + 0.04;
    float lip = goLip(style) * max(1.0, fr) * max(1.0, amp);

    // March in the ORB's frame. Rotating the ray in \u2014 and the lights with it \u2014
    // means every dot product below is already correct and no normal has to be
    // rotated back out. It also keeps the lights fixed in the world, so the
    // highlights sweep across the orb as it turns.
    mat3 rInv = transpose(uRot);
    vec3 roO = rInv * ro;
    vec3 rdO = rInv * rd;

    vec2 hh = goSph(roO, rdO, boundRad * uOrbSize);
    // Transparent, not black: the root's Background paints behind the orb.
    if (hh.x < 0.0) { fragColor = vec4(0.0); return; }

    float tHit = max(hh.x - 0.02 * uOrbSize, 0.0);
    float tMax = hh.y + 0.02 * uOrbSize;
    bool hit = false;
    vec3 pHit = vec3(0.0);
    for (int i = 0; i < 96; i++) {
        vec3 p = roO + rdO * tHit;
        float d = goMap(p / uOrbSize, t, fr, amp, style) * uOrbSize / lip;
        if (d < 0.0004 * uOrbSize) { hit = true; pHit = p; break; }
        tHit = tHit + d * 0.85;
        if (tHit > tMax) break;
    }
    if (!hit) { fragColor = vec4(0.0); return; }

    float chord = hh.y - hh.x;
    float graze = clamp(1.0 - chord / (2.5 * boundRad * uOrbSize), 0.0, 1.0);
    float nEps = mix(0.0015, 0.0070, graze);
    vec3 n = goNormal(pHit / uOrbSize, t, nEps, fr, amp, style);
    vec3 v = -rdO;
    float ndv = clamp(dot(n, v), 0.0, 1.0);

    vec3 L1 = rInv * goLight1(style);
    vec3 L2 = rInv * goLight2(style);
    vec3 baseTint = uTint * 2.0;
    // Core glow colour -> per-channel absorption: a bright channel is absorbed
    // little, so it survives to the deep valleys. Under the pointer the glass
    // absorbs LESS, so the swell lights up from inside rather than only
    // catching more highlight.
    vec3 absorption = 4.5 * (1.0 - uCore) * clamp(1.0 - HOVER_CLARITY * uHover * w - CLICK_CLARITY * ring, 0.0, 1.0);

    // March refracted into the body to the back surface for Beer-Lambert depth.
    vec3 rIn = refract(rdO, n, 1.0 / 1.45);
    float tBack = 0.01 * uOrbSize;
    vec3 pBack = pHit + rIn * tBack;
    for (int i = 0; i < 32; i++) {
        pBack = pHit + rIn * tBack;
        float d = goMap(pBack / uOrbSize, t, fr, amp, style) * uOrbSize;
        if (d > -0.0008 * uOrbSize) break;
        tBack = tBack + (-d) / lip * 0.85;
        if (tBack > 3.5 * uOrbSize) break;
    }
    // Divided back to MODEL units before Beer-Lambert: a bigger orb should
    // read as the same glass at a different size, not as thicker material.
    vec3 transmit = exp(-absorption * tBack / uOrbSize);

    vec3 nBack = goNormal(pBack / uOrbSize, t, nEps, fr, amp, style);
    float bDiff = (dot(nBack, L1) * 0.5 + 0.5) * 0.65
                + (dot(nBack, L2) * 0.5 + 0.5) * 0.40;
    vec3 interior = baseTint * (0.20 + bDiff) * transmit;

    float fres = pow(1.0 - ndv, 3.5);
    interior = interior + baseTint * fres * 0.55;

    float exp1 = mix(380.0, 90.0, graze);
    float exp2 = mix(240.0, 60.0, graze);
    vec3 H1 = normalize(L1 + v);
    vec3 H2 = normalize(L2 + v);
    float spec1 = pow(clamp(dot(n, H1), 0.0, 1.0), exp1);
    float spec2 = pow(clamp(dot(n, H2), 0.0, 1.0), exp2);
    float gloss = pow(clamp(dot(n, H1), 0.0, 1.0), 40.0) * 0.10;

    // The last of the three: the crests under the pointer catch more light,
    // which is where the speculars already live.
    vec3 hl = uHighlight * (1.0 + HOVER_GLINT * uHover * w + CLICK_GLINT * ring);
    vec3 col = interior;
    col = col + hl * spec1 * 6.5;
    col = col + hl * spec2 * 3.0;
    col = col + hl * gloss;

    col = col / (1.0 + col * 0.65);
    fragColor = vec4(col, 1.0);
}
`;

const STYLE_MAP = {
  wave: 0,
  ember: 1,
  mint: 2,
  frost: 3,
  sky: 4,
  storm: 5,
  coral: 6,
  ice: 7,
  magenta: 8,
};

const PRESETS = {
  logo3d: {
    orbStyle: 'mint',
    tint: '#00F2FE',
    core: '#7C3AED',
    highlight: '#FFFFFF',
    speed: 71,
    ripples: 125,
    amplitude: 104,
    size: 92,
    pointer: { hover: 130, reach: 92, sensitivity: 177 },
  },
  mint: {
    orbStyle: 'mint',
    tint: '#00FEFF',
    core: '#FFFFFF',
    highlight: '#FFFFFF',
    speed: 71,
    ripples: 125,
    amplitude: 104,
    size: 92,
    pointer: { hover: 123, reach: 92, sensitivity: 177 },
  },
  wave: {
    orbStyle: 'wave',
    tint: '#00F2FE',
    core: '#7C3AED',
    highlight: '#FFFFFF',
    speed: 65,
    ripples: 110,
    amplitude: 115,
    size: 92,
    pointer: { hover: 130, reach: 95, sensitivity: 180 },
  },
  frost: {
    orbStyle: 'frost',
    tint: '#B24BF3',
    core: '#00F2FE',
    highlight: '#FFFFFF',
    speed: 55,
    ripples: 140,
    amplitude: 95,
    size: 92,
    pointer: { hover: 120, reach: 90, sensitivity: 160 },
  },
  ember: {
    orbStyle: 'ember',
    tint: '#FF6B00',
    core: '#FF007A',
    highlight: '#FFF275',
    speed: 75,
    ripples: 120,
    amplitude: 110,
    size: 92,
    pointer: { hover: 140, reach: 95, sensitivity: 190 },
  },
  magenta: {
    orbStyle: 'magenta',
    tint: '#FF007A',
    core: '#7928CA',
    highlight: '#FFFFFF',
    speed: 68,
    ripples: 130,
    amplitude: 105,
    size: 92,
    pointer: { hover: 125, reach: 92, sensitivity: 170 },
  },
};

const MAX_DPR = 1.5;
const DT_MAX = 0.05;
const SPEED_SCALE = 50;
const SENSITIVITY_RAD = 0.4 * (Math.PI / 180);
const ROT_DAMPING = 2.2;
const MAX_VELOCITY = 12;
const HOVER_LERP = 8;

function clamp(v, min, max) {
  return v < min ? min : v > max ? max : v;
}

function parseColor(c, fallback) {
  if (!c) return fallback;
  const s = c.trim();
  if (s[0] === '#') {
    const hex = s.slice(1);
    const is3 = hex.length === 3 || hex.length === 4;
    const is6 = hex.length === 6 || hex.length === 8;
    if (!is3 && !is6) return fallback;
    const p = (i) => parseInt(is3 ? hex[i] + hex[i] : hex.slice(i * 2, i * 2 + 2), 16);
    const r = p(0), g = p(1), b = p(2);
    return [r, g, b].some(Number.isNaN) ? fallback : [r / 255, g / 255, b / 255];
  }
  const mRgb = s.match(/rgba?\(([^)]+)\)/i);
  if (mRgb) {
    const parts = mRgb[1].split(/[,/\s]+/).map((x) => parseFloat(x));
    if (parts.length >= 3 && parts.slice(0, 3).every((x) => !Number.isNaN(x))) {
      return [parts[0] / 255, parts[1] / 255, parts[2] / 255];
    }
  }
  return fallback;
}

export class LiquidSphere {
  constructor(container, options = {}) {
    this.container = typeof container === 'string' ? document.querySelector(container) : container;
    if (!this.container) {
      console.warn('LiquidSphere: Container element not found', container);
      return;
    }

    this.options = Object.assign({}, PRESETS.logo3d, options);
    this.options.pointer = Object.assign({}, PRESETS.logo3d.pointer, options.pointer || {});

    this.canvas = document.createElement('canvas');
    this.canvas.className = 'liquid-sphere-canvas';
    this.canvas.style.cssText = 'position:absolute;inset:0;width:100%;height:100%;display:block;touch-action:none;cursor:grab;z-index:2;';
    this.container.style.position = this.container.style.position || 'relative';
    this.container.appendChild(this.canvas);

    this.gl = this.canvas.getContext('webgl2', {
      alpha: true,
      antialias: false,
      premultipliedAlpha: true,
      powerPreference: 'high-performance'
    });

    if (!this.gl) {
      console.error('LiquidSphere: WebGL2 not supported on this browser/GPU');
      return;
    }

    this.initGL();
    this.initEvents();
    this.initUI();
    this.start();
  }

  initGL() {
    const gl = this.gl;
    const compile = (type, src) => {
      const sh = gl.createShader(type);
      gl.shaderSource(sh, src);
      gl.compileShader(sh);
      if (!gl.getShaderParameter(sh, gl.COMPILE_STATUS)) {
        console.error('LiquidSphere Shader Error:', gl.getShaderInfoLog(sh));
        gl.deleteShader(sh);
        return null;
      }
      return sh;
    };

    const vs = compile(gl.VERTEX_SHADER, VS_SOURCE);
    const fs = compile(gl.FRAGMENT_SHADER, FS_SOURCE);
    if (!vs || !fs) return;

    const prog = gl.createProgram();
    gl.attachShader(prog, vs);
    gl.attachShader(prog, fs);
    gl.linkProgram(prog);

    if (!gl.getProgramParameter(prog, gl.LINK_STATUS)) {
      console.error('LiquidSphere Link Error:', gl.getProgramInfoLog(prog));
      return;
    }

    this.program = prog;
    gl.useProgram(prog);

    this.uniforms = {
      size: gl.getUniformLocation(prog, 'uSize'),
      time: gl.getUniformLocation(prog, 'uTime'),
      style: gl.getUniformLocation(prog, 'uStyle'),
      speed: gl.getUniformLocation(prog, 'uSpeed'),
      waveFreq: gl.getUniformLocation(prog, 'uWaveFreq'),
      amplitude: gl.getUniformLocation(prog, 'uAmplitude'),
      orbSize: gl.getUniformLocation(prog, 'uOrbSize'),
      tint: gl.getUniformLocation(prog, 'uTint'),
      core: gl.getUniformLocation(prog, 'uCore'),
      highlight: gl.getUniformLocation(prog, 'uHighlight'),
      pointer: gl.getUniformLocation(prog, 'uPointer'),
      hover: gl.getUniformLocation(prog, 'uHover'),
      reach: gl.getUniformLocation(prog, 'uReach'),
      click: gl.getUniformLocation(prog, 'uClick'),
      rot: gl.getUniformLocation(prog, 'uRot'),
    };

    this.vao = gl.createVertexArray();
    gl.bindVertexArray(this.vao);

    this.w = 1;
    this.h = 1;
    this.resize();

    this.ro = new ResizeObserver(() => this.resize());
    this.ro.observe(this.canvas);
  }

  resize() {
    if (!this.canvas || !this.gl) return;
    const cw = this.canvas.clientWidth || 1;
    const ch = this.canvas.clientHeight || 1;
    const dpr = Math.min(window.devicePixelRatio || 1, MAX_DPR);
    const nw = Math.max(1, Math.round(cw * dpr));
    const nh = Math.max(1, Math.round(ch * dpr));

    if (this.canvas.width !== nw || this.canvas.height !== nh) {
      this.canvas.width = nw;
      this.canvas.height = nh;
    }
    this.w = nw;
    this.h = nh;
    this.gl.viewport(0, 0, nw, nh);
  }

  initEvents() {
    this.ptr = { fx: 0.5, fy: 0.5, presence: 0, target: 0 };
    this.click = { fx: 0.5, fy: 0.5, start: 0 };
    this.rot = { yaw: 0, pitch: 0.15, vYaw: 0, vPitch: 0 };
    this.isDragging = false;
    this.lastX = 0;
    this.lastY = 0;
    this.lastMoveTime = performance.now();

    const getSens = () => SENSITIVITY_RAD * Math.max(0, this.options.pointer.sensitivity) / 100;

    this.onPointerDown = (e) => {
      this.isDragging = true;
      this.canvas.style.cursor = 'grabbing';
      this.lastX = e.clientX;
      this.lastY = e.clientY;
      this.lastMoveTime = performance.now();
      this.rot.vYaw = 0;
      this.rot.vPitch = 0;

      const rect = this.canvas.getBoundingClientRect();
      if (rect.width > 0 && rect.height > 0) {
        this.click.fx = (e.clientX - rect.left) / rect.width;
        this.click.fy = (e.clientY - rect.top) / rect.height;
        this.click.start = performance.now();
      }
    };

    this.onPointerMove = (e) => {
      const rect = this.canvas.getBoundingClientRect();
      if (rect.width <= 0 || rect.height <= 0) return;

      const u = (e.clientX - rect.left) / rect.width;
      const v = (e.clientY - rect.top) / rect.height;
      this.ptr.fx = u;
      this.ptr.fy = v;

      const inside = u >= 0 && u <= 1 && v >= 0 && v <= 1;
      this.ptr.target = inside || this.isDragging ? 1 : 0;

      if (!this.isDragging) return;

      const now = performance.now();
      const dt = Math.max((now - this.lastMoveTime) / 1000, 1 / 240);
      this.lastMoveTime = now;

      const dx = e.clientX - this.lastX;
      const dy = e.clientY - this.lastY;
      this.lastX = e.clientX;
      this.lastY = e.clientY;

      const sens = getSens();
      this.rot.yaw += dx * sens;
      this.rot.pitch += dy * sens;
      this.rot.vYaw = clamp(dx * sens / dt, -MAX_VELOCITY, MAX_VELOCITY);
      this.rot.vPitch = clamp(dy * sens / dt, -MAX_VELOCITY, MAX_VELOCITY);
    };

    this.onPointerUp = () => {
      this.isDragging = false;
      this.canvas.style.cursor = 'grab';
    };

    this.onPointerLeave = () => {
      if (!this.isDragging) {
        this.ptr.target = 0;
      }
    };

    this.canvas.addEventListener('pointerdown', this.onPointerDown);
    this.canvas.addEventListener('pointerleave', this.onPointerLeave);
    window.addEventListener('pointermove', this.onPointerMove);
    window.addEventListener('pointerup', this.onPointerUp);
    window.addEventListener('pointercancel', this.onPointerUp);
  }

  initUI() {
    const stage = this.container.closest('.poc-3d-stage') || document;
    const presetBtns = stage.querySelectorAll('.poc-preset-btn');
    const chipLabel = document.getElementById('poc-hud-chip-label');

    presetBtns.forEach((btn) => {
      btn.addEventListener('click', (e) => {
        e.preventDefault();
        presetBtns.forEach((b) => b.classList.remove('active'));
        btn.classList.add('active');
        const style = btn.dataset.style;
        this.setPreset(style);
        if (chipLabel) {
          const name = style === 'logo3d' ? 'LOGO 3D COLOUR' : (style === 'mint' ? 'PRESET: BASE' : `STYLE: ${style.toUpperCase()}`);
          chipLabel.innerHTML = `<span class="poc-chip-pulse"></span>ORIGINKIT // LIQUID SPHERE [${name}]`;
        }
      });
    });

    const viewBtns = stage.querySelectorAll('.poc-view-btn');
    const cardsCarousel = document.getElementById('poc-cards-carousel');
    viewBtns.forEach((btn) => {
      btn.addEventListener('click', (e) => {
        e.preventDefault();
        viewBtns.forEach((b) => b.classList.remove('active'));
        btn.classList.add('active');
        const view = btn.dataset.view;
        if (cardsCarousel) {
          if (view === 'both') {
            cardsCarousel.style.display = 'flex';
            this.canvas.style.zIndex = '1';
            cardsCarousel.style.zIndex = '4';
          } else {
            cardsCarousel.style.display = 'none';
            this.canvas.style.zIndex = '2';
          }
        }
      });
    });
  }

  setPreset(presetKey) {
    if (PRESETS[presetKey]) {
      const p = PRESETS[presetKey];
      Object.assign(this.options, p);
      this.options.pointer = Object.assign({}, p.pointer);
    } else if (presetKey in STYLE_MAP) {
      this.options.orbStyle = presetKey;
    }
  }

  start() {
    this.animTime = 0;
    this.lastFrame = performance.now();
    this.rotMatrix = new Float32Array(9);

    const render = (now) => {
      this.animId = requestAnimationFrame(render);
      if (!this.gl || !this.program) return;

      const dt = clamp((now - this.lastFrame) / 1000, 0, DT_MAX);
      this.lastFrame = now;

      const opt = this.options;
      this.animTime = (this.animTime + dt * (opt.speed / SPEED_SCALE)) % 100000;
      this.ptr.presence += (this.ptr.target - this.ptr.presence) * (1 - Math.exp(-dt * HOVER_LERP));

      if (!this.isDragging) {
        // Idle continuous drift
        this.rot.yaw += 0.003 + this.rot.vYaw * dt;
        this.rot.pitch += this.rot.vPitch * dt;
        const decay = Math.exp(-dt * ROT_DAMPING);
        this.rot.vYaw *= decay;
        this.rot.vPitch *= decay;
      }

      const cy = Math.cos(this.rot.yaw);
      const sy = Math.sin(this.rot.yaw);
      const cp = Math.cos(this.rot.pitch);
      const sp = Math.sin(this.rot.pitch);

      this.rotMatrix[0] = cy;
      this.rotMatrix[1] = 0;
      this.rotMatrix[2] = -sy;
      this.rotMatrix[3] = sy * sp;
      this.rotMatrix[4] = cp;
      this.rotMatrix[5] = cy * sp;
      this.rotMatrix[6] = sy * cp;
      this.rotMatrix[7] = -sp;
      this.rotMatrix[8] = cy * cp;

      const minDim = Math.min(this.w, this.h);
      const ptrX = ((this.ptr.fx - 0.5) * this.w * 2) / minDim;
      const ptrY = ((this.ptr.fy - 0.5) * this.h * 2) / minDim;

      const clickX = ((this.click.fx - 0.5) * this.w * 2) / minDim;
      const clickY = ((this.click.fy - 0.5) * this.h * 2) / minDim;
      const clickAge = (now - this.click.start) / 1000;

      const tint = parseColor(opt.tint, [0.0, 0.996, 1.0]);
      const core = parseColor(opt.core, [1.0, 1.0, 1.0]);
      const highlight = parseColor(opt.highlight, [1.0, 1.0, 1.0]);

      const styleNum = typeof opt.orbStyle === 'number' ? opt.orbStyle : (STYLE_MAP[opt.orbStyle] ?? 2);

      const gl = this.gl;
      gl.useProgram(this.program);
      gl.bindVertexArray(this.vao);

      gl.uniform2f(this.uniforms.size, this.w, this.h);
      gl.uniform1f(this.uniforms.time, this.animTime);
      gl.uniform1f(this.uniforms.speed, 1.0);
      gl.uniform1f(this.uniforms.style, styleNum);
      gl.uniform1f(this.uniforms.waveFreq, clamp(opt.ripples, 1, 400) / 100);
      gl.uniform1f(this.uniforms.amplitude, Math.max(0, opt.amplitude) / 100);
      gl.uniform1f(this.uniforms.orbSize, clamp(opt.size, 1, 400) / 100);
      gl.uniform3f(this.uniforms.tint, tint[0], tint[1], tint[2]);
      gl.uniform3f(this.uniforms.core, core[0], core[1], core[2]);
      gl.uniform3f(this.uniforms.highlight, highlight[0], highlight[1], highlight[2]);
      gl.uniform3f(this.uniforms.pointer, ptrX, ptrY, this.ptr.presence);
      gl.uniform3f(this.uniforms.click, clickX, clickY, clickAge);
      gl.uniform1f(this.uniforms.hover, Math.max(0, opt.pointer.hover) / 100);
      gl.uniform1f(this.uniforms.reach, clamp(opt.pointer.reach, 1, 200) / 100);
      gl.uniformMatrix3fv(this.uniforms.rot, false, this.rotMatrix);

      gl.clearColor(0, 0, 0, 0);
      gl.clear(gl.COLOR_BUFFER_BIT);
      gl.drawArrays(gl.TRIANGLES, 0, 3);
    };

    this.animId = requestAnimationFrame(render);
  }

  destroy() {
    if (this.animId) cancelAnimationFrame(this.animId);
    if (this.ro) this.ro.disconnect();
    this.canvas.removeEventListener('pointerdown', this.onPointerDown);
    this.canvas.removeEventListener('pointerleave', this.onPointerLeave);
    window.removeEventListener('pointermove', this.onPointerMove);
    window.removeEventListener('pointerup', this.onPointerUp);
    window.removeEventListener('pointercancel', this.onPointerUp);
    if (this.canvas.parentElement) {
      this.canvas.parentElement.removeChild(this.canvas);
    }
  }
}

// Auto-initialize
document.addEventListener('DOMContentLoaded', () => {
  const target = document.getElementById('poc-liquid-sphere-canvas');
  if (target) {
    const presetKey = target.dataset.preset || 'logo3d';
    const initialConfig = PRESETS[presetKey] || PRESETS.logo3d;
    window.liquidSphereInstance = new LiquidSphere(target, initialConfig);
  }
});
