/**
 * Every picture the Custom Product Development page uses.
 *
 *     node tools/custom-art.mjs
 *
 * Seventh set, in the site's own palette — #00F2FE into #4EA8FF into #9D4EDD on
 * ink. The Dedicated Team page tried a colour of its own and stopped looking
 * like the same website, so what makes a set its own here is the MOTIF, never
 * the hue.
 *
 * This one is STRATA: isometric plates stacked with air between them and the
 * seams lit, risers tying one down to the next. The page's whole argument is
 * that a custom product is layers built to fit each other — frontend, backend,
 * mobile, data, cloud, API — rather than one bought thing bent into shape, and
 * that is the shape of it. The other six sets are a magazine, a blueprint, a
 * component graph, a roster of seats, a board of signal bars and an aperture.
 *
 *   plate/    5 for the hero's CSS 3D strata stack
 *   flaw/     4 for the four ways an unaligned build hurts
 *   layer/    6 for the expertise bento
 *   step/     3 for the working process
 *   edge/     6 for the advantage grid
 *   model/    5 pages for the engagement-model book (cover, 3 inner, back)
 *   hero/     1 wide ground behind the hero
 *   faq/      1 beside the questions
 */
import { chromium } from 'file:///C:/Users/aakas/AppData/Roaming/npm/node_modules/playwright/index.mjs';
import { fileURLToPath } from 'node:url';
import { execFileSync } from 'node:child_process';
import path from 'node:path';
import fs from 'node:fs';

const FFMPEG = 'C:/Users/aakas/Downloads/Central Adventure/repo/node_modules/ffmpeg-static/ffmpeg.exe';
const here = path.dirname(fileURLToPath(import.meta.url));
const OUT  = path.join(here, '..', 'assets', 'img', 'custom');

const CYAN = '#00F2FE';
const BLUE = '#4EA8FF';
const PURPLE = '#9D4EDD';
const INK = '#0B0F17';
const TINTS = [CYAN, BLUE, PURPLE];

let seed = 20260905;
const rnd = () => (seed = (seed * 1103515245 + 12345) & 0x7fffffff) / 0x7fffffff;
const between = (a, b) => a + rnd() * (b - a);

const svg = (vb, body) =>
  `<svg viewBox="${vb}" preserveAspectRatio="xMidYMid meet" xmlns="http://www.w3.org/2000/svg">${body}</svg>`;

let gid = 0;

function ground(w, h, tint, tint2, lift = 1, base = INK) {
  const a = `g${gid++}`; const b = `g${gid++}`;
  const o = (v) => Math.min(0.95, v * lift).toFixed(3);

  return `
    <defs>
      <radialGradient id="${a}">
        <stop offset="0" stop-color="${tint}" stop-opacity="${o(0.34)}"/>
        <stop offset="0.55" stop-color="${tint}" stop-opacity="${o(0.12)}"/>
        <stop offset="1" stop-color="${tint}" stop-opacity="0"/>
      </radialGradient>
      <radialGradient id="${b}">
        <stop offset="0" stop-color="${tint2}" stop-opacity="${o(0.28)}"/>
        <stop offset="0.55" stop-color="${tint2}" stop-opacity="${o(0.10)}"/>
        <stop offset="1" stop-color="${tint2}" stop-opacity="0"/>
      </radialGradient>
    </defs>
    <rect width="${w}" height="${h}" fill="${base}"/>
    <ellipse cx="${w * 0.72}" cy="${h * 0.14}" rx="${w * 0.72}" ry="${h * 0.68}" fill="url(#${a})"/>
    <ellipse cx="${w * 0.18}" cy="${h * 0.9}" rx="${w * 0.68}" ry="${h * 0.6}" fill="url(#${b})"/>`;
}

/** One isometric plate — the rhombus you get looking down on a square. */
function plate(cx, cy, hw, hh, c, opacity, fill = 0.06) {
  const pts = `${cx},${cy - hh} ${cx + hw},${cy} ${cx},${cy + hh} ${cx - hw},${cy}`;

  return `<polygon points="${pts}" fill="${c}" fill-opacity="${fill}"
    stroke="${c}" stroke-opacity="${opacity}" stroke-width="2" stroke-linejoin="round"/>`;
}

/**
 * The strata: n plates with air between them, tied by risers at the corners.
 *
 * `lit` is the index of the seam that glows — the layer this particular picture
 * is about — so six cards built from the same stack each read as a different
 * layer without needing six different drawings.
 */
function strata(w, h, c, n, lit = -1) {
  const cx = w / 2;
  const hw = Math.min(w * 0.34, h * 0.62);
  const hh = hw * 0.5;
  const gap = Math.min(h * 0.115, hh * 0.86);
  const top = h * 0.5 - ((n - 1) * gap) / 2;

  let out = '';

  /* Risers first, so the plates sit on top of them. */
  for (let i = 0; i < n - 1; i++) {
    const y0 = top + i * gap;
    for (const dx of [-hw, hw, 0]) {
      const dy = dx === 0 ? hh : 0;
      out += `<line x1="${(cx + dx).toFixed(1)}" y1="${(y0 + dy).toFixed(1)}"
        x2="${(cx + dx).toFixed(1)}" y2="${(y0 + gap + dy).toFixed(1)}"
        stroke="${c}" stroke-opacity="0.22" stroke-width="1.5"/>`;
    }
  }

  for (let i = 0; i < n; i++) {
    const y = top + i * gap;
    const on = i === lit;
    const shrink = 1 - i * 0.045;
    out += plate(cx, y, hw * shrink, hh * shrink, c,
      on ? 0.95 : 0.34 - i * 0.02, on ? 0.16 : 0.05);
  }

  /* The lit seam gets a node at its centre. */
  if (lit >= 0) {
    const y = top + lit * gap;
    out += `<circle cx="${cx}" cy="${y.toFixed(1)}" r="7" fill="${c}" opacity="0.95"/>`;
    out += `<circle cx="${cx}" cy="${y.toFixed(1)}" r="16" fill="none" stroke="${c}" stroke-opacity="0.45" stroke-width="1.6"/>`;
  }

  return out;
}

/** Ports along a plate edge — the integration points a custom build exposes. */
function ports(w, h, c, n) {
  const cx = w / 2;
  const hw = Math.min(w * 0.34, h * 0.62);
  let out = '';
  for (let i = 0; i < n; i++) {
    const t = (i + 1) / (n + 1);
    const x = cx - hw + t * hw * 2;
    const y = h * 0.5 + (Math.abs(t - 0.5) * 2 - 1) * (hw * 0.5) * -1 + hw * 0.5;
    out += `<circle cx="${x.toFixed(1)}" cy="${y.toFixed(1)}" r="3.4" fill="${c}" opacity="${between(0.45, 0.9).toFixed(2)}"/>`;
  }

  return out;
}

/** A fault line — the fragmentation the page's second section is about. */
function fault(w, h, c) {
  const y = h * 0.5;
  let d = `M ${(w * 0.1).toFixed(1)} ${y.toFixed(1)}`;
  for (let x = w * 0.1; x < w * 0.9; x += w * 0.08) {
    d += ` L ${(x + w * 0.08).toFixed(1)} ${(y + between(-h * 0.06, h * 0.06)).toFixed(1)}`;
  }

  return `<path d="${d}" fill="none" stroke="${c}" stroke-opacity="0.75" stroke-width="2.4"
    stroke-linecap="round" stroke-dasharray="14 9"/>`;
}

/** Loose motes, texture only. */
function motes(w, h, c, n) {
  let out = '';
  for (let i = 0; i < n; i++) {
    out += `<circle cx="${between(w * 0.08, w * 0.92).toFixed(1)}" cy="${between(h * 0.08, h * 0.92).toFixed(1)}"
      r="${between(1.3, 3.2).toFixed(1)}" fill="${c}" opacity="${between(0.18, 0.55).toFixed(2)}"/>`;
  }

  return out;
}

const mono = (x, y, t, c, size = 15, anchor = 'start') => `
  <text x="${x}" y="${y}" text-anchor="${anchor}" font-family="IBM Plex Mono, monospace"
    font-size="${size}" letter-spacing="3.5" fill="${c}" fill-opacity="0.82">${t}</text>`;

/* -------------------------------------------------------------------------- */

/** A card tile: the stack with one seam lit. */
function tile(i, w, h, lit, lift = 1.2, extra = '') {
  const c = TINTS[i % 3];

  return svg(`0 0 ${w} ${h}`, `
    ${ground(w, h, c, TINTS[(i + 1) % 3], lift, '#101822')}
    ${strata(w, h, c, 5, lit)}
    ${extra}
    ${mono(34, h - 26, String(i + 1).padStart(2, '0'), c, 18)}`);
}

/** A hero plate — wide, one slab, seen close. */
function heroPlate(i) {
  const W = 760; const H = 460;
  const c = TINTS[i % 3];

  return svg(`0 0 ${W} ${H}`, `
    ${ground(W, H, c, TINTS[(i + 1) % 3], 1.7, '#111a26')}
    ${plate(W / 2, H * 0.5, W * 0.36, W * 0.18, c, 0.9, 0.14)}
    ${ports(W, H, c, 5)}
    ${motes(W, H, c, 12)}
    ${mono(W / 2, H - 34, ['FRONTEND', 'BACKEND', 'DATA', 'CLOUD', 'API'][i] || 'LAYER', '#FFFFFF', 20, 'middle')}`);
}

/** Book pages for the engagement-model flip book — portrait and lit. */
function bookPage(i, isCover, isBack) {
  const W = 700; const H = 950;
  const c = TINTS[i % 3];

  return svg(`0 0 ${W} ${H}`, `
    ${ground(W, H, c, TINTS[(i + 1) % 3], isCover || isBack ? 2.4 : 1.9, isCover || isBack ? '#132131' : '#111823')}
    ${strata(W, H, c, isCover ? 6 : 5, isCover ? -1 : i)}
    ${motes(W, H, c, isCover ? 20 : 10)}
    ${mono(W / 2, H - 56, isCover ? 'ENGAGEMENT' : isBack ? 'ITHRIVE' : String(i).padStart(2, '0'), '#FFFFFF', 24, 'middle')}`);
}

/* -------------------------------------------------------------------------- */

const JOBS = [];
const add = (set, name, w, h, markup) => JOBS.push({ set, name, w, h, markup });

const pad = (n) => String(n).padStart(2, '0');

for (let i = 0; i < 5; i++) add('plate', pad(i + 1), 760, 460, heroPlate(i));
for (let i = 0; i < 4; i++) add('flaw',  pad(i + 1), 720, 520, tile(i, 720, 520, -1, 1.15, fault(720, 520, TINTS[i % 3])));
for (let i = 0; i < 6; i++) add('layer', pad(i + 1), 900, 620, tile(i, 900, 620, i % 5, 1.25, ports(900, 620, TINTS[i % 3], 4)));
for (let i = 0; i < 3; i++) add('step',  pad(i + 1), 860, 540, tile(i, 860, 540, i + 1, 1.3));
for (let i = 0; i < 6; i++) add('edge',  pad(i + 1), 760, 480, tile(i, 760, 480, 4 - (i % 5), 1.15));
for (let i = 0; i < 5; i++) add('model', pad(i + 1), 700, 950, bookPage(i, i === 0, i === 4));
add('hero', '01', 1800, 1000, tile(1, 1800, 1000, 2, 2.0, motes(1800, 1000, BLUE, 26)));
add('faq',  '01', 800, 620, tile(2, 800, 620, 3, 1.2));

const boxes = JOBS.map((j) => `
  <div id="art-${j.set}-${j.name}" style="width:${j.w}px;height:${j.h}px;overflow:hidden">${j.markup}</div>`).join('\n');

const html = `<!doctype html><meta charset="utf-8">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;600;700&display=swap">
<style>body{margin:0;background:${INK}} svg{display:block;width:100%;height:100%}</style>
${boxes}
<script>window.__ids = ${JSON.stringify(JOBS.map((j) => `art-${j.set}-${j.name}`))};</script>`;

const tmp = path.join(here, '..', '.custom-art.html');
fs.writeFileSync(tmp, html);

const browser = await chromium.launch({ channel: 'chrome' });
const p = await browser.newPage({ viewport: { width: 1900, height: 1100 } });
p.on('pageerror', (e) => console.error('PAGE ERROR:', String(e).slice(0, 200)));
await p.goto('file:///' + tmp.split(path.sep).join('/'));
await p.waitForLoadState('networkidle');
await p.evaluate(() => document.fonts.ready);
await p.waitForTimeout(900);

let n = 0;
for (const id of await p.evaluate(() => window.__ids)) {
  const [, set, name] = id.split('-');
  const dir = path.join(OUT, set);
  fs.mkdirSync(dir, { recursive: true });
  const png = path.join(dir, name + '.png');
  const jpg = path.join(dir, name + '.jpg');

  await (await p.$('#' + id)).screenshot({ path: png });
  execFileSync(FFMPEG, ['-hide_banner', '-loglevel', 'error', '-y', '-i', png, '-q:v', '4', jpg]);
  fs.unlinkSync(png);

  n++;
  console.log(`${(set + '/' + name).padEnd(16)} ${(fs.statSync(jpg).size / 1024).toFixed(0).padStart(4)}KB`);
}

await browser.close();
fs.unlinkSync(tmp);
console.log(`\n${n} pictures.`);
