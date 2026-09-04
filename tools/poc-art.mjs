/**
 * Every picture the PoC Development page uses.
 *
 *     node tools/poc-art.mjs
 *
 * Same palette as the rest of the site, weighted to the BLUE-VIOLET end so the
 * page reads as its own thing beside the MVP page's cyan-forward set. The
 * vocabulary here is a blueprint: hairline grids, corner ticks, measurement
 * marks, sampled fields.
 *
 * Deliberately abstract. These are textures behind and beside text, not charts
 * — the brief on this site is photographs where a photograph can say something
 * and quiet geometry where one cannot, and explicitly NOT diagrams that only
 * look informative. Anything with a real subject is a photography slot instead:
 * every one of these is superseded the moment the matching file appears in
 * assets/img/poc/photo/, which is what tools/site-photos.mjs fills in and what
 * the page's own $img() helper checks first.
 *
 *   face/     6 square faces for the hero's three.js cube
 *   open/     1 portrait beside the opening argument
 *   gain/     3 for what a proof buys you
 *   inside/   8 for the scope cards
 *   step/     5 for the process flow
 *   sector/   6 for the carousel and its detail panel
 *   why/      4 for why choose us
 *   faq/      1 beside the questions
 *
 * Renders the same way tools/mvp-art.mjs does: one HTML page of sized boxes,
 * screenshotted element by element, each through ffmpeg to a JPEG.
 */
import { chromium } from 'file:///C:/Users/aakas/AppData/Roaming/npm/node_modules/playwright/index.mjs';
import { fileURLToPath } from 'node:url';
import { execFileSync } from 'node:child_process';
import path from 'node:path';
import fs from 'node:fs';

const FFMPEG = 'C:/Users/aakas/Downloads/Central Adventure/repo/node_modules/ffmpeg-static/ffmpeg.exe';

const here = path.dirname(fileURLToPath(import.meta.url));
const OUT  = path.join(here, '..', 'assets', 'img', 'poc');

/* style.css's own values. */
const BLUE   = '#4EA8FF';
const VIOLET = '#7C5CFF';
const PURPLE = '#9D4EDD';
const CYAN   = '#00F2FE';
const INK    = '#0B0F17';

/* Seeded, so a re-run produces byte-identical files and the diff stays empty
   when nothing about the art has changed. */
let seed = 20260904;
const rnd = () => (seed = (seed * 1103515245 + 12345) & 0x7fffffff) / 0x7fffffff;
const between = (a, b) => a + rnd() * (b - a);

/* --------------------------------------------------------------------------
 * Vocabulary — small on purpose, so thirty-four pictures still look like one
 * set rather than thirty-four ideas.
 * ----------------------------------------------------------------------- */

/**
 * The ground: ink, two soft washes, and the blueprint grid over it.
 *
 * The washes are radial GRADIENTS, not flat ellipses at low opacity — a solid
 * ellipse keeps its edge however far the opacity is dropped, and the first pass
 * of this file read as two hard discs sitting on the ink rather than as light.
 *
 * Gradient ids have to be unique across the whole render page, because every
 * picture is an inline <svg> in one document and ids there are global — two
 * pictures sharing "wash-a" would both resolve to whichever came first.
 */
let gid = 0;
function ground(w, h, tint, tint2, lift = 1, base = INK) {
  const a = `w${gid++}`;
  const b = `w${gid++}`;
  /*
   * `lift` brightens the washes. Everything on this page sits BEHIND or BESIDE
   * text on an already-dark page, so the default is dim. The hero's cube faces
   * are the exception: they are lit objects on a dark stage rather than a
   * ground under text, and at the page's usual weight they rendered as six
   * black rectangles in the WebGL scene. They pass lift ≈ 2.4.
   */
  const o = (v) => Math.min(0.95, v * lift).toFixed(3);

  const step = Math.round(Math.min(w, h) / 11);
  let lines = '';
  for (let x = step; x < w; x += step) {
    lines += `<line x1="${x}" y1="0" x2="${x}" y2="${h}" stroke="#fff" stroke-opacity="0.045" stroke-width="1"/>`;
  }
  for (let y = step; y < h; y += step) {
    lines += `<line x1="0" y1="${y}" x2="${w}" y2="${y}" stroke="#fff" stroke-opacity="0.045" stroke-width="1"/>`;
  }

  return `
    <defs>
      <radialGradient id="${a}">
        <stop offset="0" stop-color="${tint}" stop-opacity="${o(0.42)}"/>
        <stop offset="0.55" stop-color="${tint}" stop-opacity="${o(0.16)}"/>
        <stop offset="1" stop-color="${tint}" stop-opacity="0"/>
      </radialGradient>
      <radialGradient id="${b}">
        <stop offset="0" stop-color="${tint2}" stop-opacity="${o(0.36)}"/>
        <stop offset="0.55" stop-color="${tint2}" stop-opacity="${o(0.13)}"/>
        <stop offset="1" stop-color="${tint2}" stop-opacity="0"/>
      </radialGradient>
    </defs>
    <rect width="${w}" height="${h}" fill="${base}"/>
    <ellipse cx="${w * 0.18}" cy="${h * 0.08}" rx="${w * 0.78}" ry="${h * 0.74}" fill="url(#${a})"/>
    <ellipse cx="${w * 0.94}" cy="${h * 0.95}" rx="${w * 0.72}" ry="${h * 0.68}" fill="url(#${b})"/>
    ${lines}`;
}

/** Corner ticks — the page's mark, repeated at picture scale. */
function ticks(w, h, c, inset = 26, len = 30) {
  const t = (x, y, sx, sy) => `<path d="M${x} ${y + sy * len} L${x} ${y} L${x + sx * len} ${y}"
    fill="none" stroke="${c}" stroke-opacity="0.55" stroke-width="2.5"/>`;

  return t(inset, inset, 1, 1)
    + t(w - inset, inset, -1, 1)
    + t(inset, h - inset, 1, -1)
    + t(w - inset, h - inset, -1, -1);
}

/** A drift of sampled points — evidence accumulating, not a scatter plot. */
function samples(w, h, c, n) {
  let s = '';
  for (let i = 0; i < n; i++) {
    const x = between(w * 0.1, w * 0.9);
    const y = between(h * 0.12, h * 0.88);
    const r = between(1.6, 4.6);
    s += `<circle cx="${x.toFixed(1)}" cy="${y.toFixed(1)}" r="${r.toFixed(1)}"
      fill="${c}" opacity="${between(0.18, 0.72).toFixed(2)}"/>`;
  }

  return s;
}

/** Concentric arcs, off-centre: a reading converging. */
function rings(cx, cy, c, n, r0, gap) {
  let s = '';
  for (let i = 0; i < n; i++) {
    s += `<circle cx="${cx}" cy="${cy}" r="${r0 + i * gap}" fill="none"
      stroke="${c}" stroke-opacity="${(0.42 - i * 0.045).toFixed(2)}" stroke-width="1.6"/>`;
  }

  return s;
}

/** A measured span with end stops — the threshold motif. */
function span(x1, x2, y, c, label) {
  return `
    <line x1="${x1}" y1="${y}" x2="${x2}" y2="${y}" stroke="${c}" stroke-opacity="0.7" stroke-width="2"/>
    <line x1="${x1}" y1="${y - 13}" x2="${x1}" y2="${y + 13}" stroke="${c}" stroke-opacity="0.7" stroke-width="2"/>
    <line x1="${x2}" y1="${y - 13}" x2="${x2}" y2="${y + 13}" stroke="${c}" stroke-opacity="0.7" stroke-width="2"/>
    ${label ? `<text x="${(x1 + x2) / 2}" y="${y - 22}" text-anchor="middle"
       font-family="JetBrains Mono, monospace" font-size="15" letter-spacing="3"
       fill="${c}" fill-opacity="0.75">${label}</text>` : ''}`;
}

/** Stacked planes at an angle — a system seen edge on. */
function planes(w, h, c, n) {
  let s = '';
  for (let i = 0; i < n; i++) {
    const y = h * 0.3 + i * (h * 0.115);
    const inset = w * (0.16 + i * 0.028);
    s += `<path d="M${inset} ${y} L${w - inset} ${y - h * 0.055} L${w - inset} ${y + h * 0.04} L${inset} ${y + h * 0.095} Z"
      fill="${c}" fill-opacity="${(0.16 - i * 0.02).toFixed(3)}"
      stroke="${c}" stroke-opacity="${(0.5 - i * 0.06).toFixed(2)}" stroke-width="1.4"/>`;
  }

  return s;
}

/** A tick mark: the verdict. */
function verdict(cx, cy, s, c) {
  return `<path d="M${cx - s} ${cy} L${cx - s * 0.25} ${cy + s * 0.7} L${cx + s} ${cy - s * 0.7}"
    fill="none" stroke="${c}" stroke-opacity="0.85" stroke-width="${s * 0.17}"
    stroke-linecap="round" stroke-linejoin="round"/>`;
}

const mono = (x, y, t, c, size = 15, anchor = 'start') => `
  <text x="${x}" y="${y}" text-anchor="${anchor}" font-family="JetBrains Mono, monospace"
    font-size="${size}" letter-spacing="3.5" fill="${c}" fill-opacity="0.8">${t}</text>`;

/* --------------------------------------------------------------------------
 * The sets
 * ----------------------------------------------------------------------- */

/** Hero cube faces — square, a big index and one motif each. */
function face(i) {
  const W = 1000;
  const tints = [BLUE, VIOLET, PURPLE, CYAN, BLUE, VIOLET];
  const c = tints[i];

  const motifs = [
    () => samples(W, W, c, 90),
    () => rings(W * 0.5, W * 0.52, c, 7, 90, 42),
    () => planes(W, W, c, 5),
    () => span(W * 0.18, W * 0.82, W * 0.52, c, 'THRESHOLD') + samples(W, W, c, 30),
    () => rings(W * 0.72, W * 0.3, c, 6, 70, 46) + samples(W, W, c, 40),
    () => verdict(W * 0.5, W * 0.5, 120, c),
  ];

  /* A base a couple of stops off the page's ink, plus lifted washes: these six
     are textures on a lit 3D object, and at the ground the rest of the page
     uses they came out as black panels in the WebGL scene. */
  return svg(`0 0 ${W} ${W}`, `
    ${ground(W, W, c, PURPLE, 2.4, '#131E31')}
    ${motifs[i]()}
    ${ticks(W, W, '#FFFFFF', 34, 42)}
    ${mono(52, W - 44, String(i + 1).padStart(2, '0'), '#FFFFFF', 34)}
    ${mono(W - 52, W - 44, 'PROOF', '#FFFFFF', 18, 'end')}`);
}

/** One portrait beside the opening argument. */
function open1() {
  const W = 900; const H = 1100;

  return svg(`0 0 ${W} ${H}`, `
    ${ground(W, H, BLUE, VIOLET)}
    ${planes(W, H, BLUE, 6)}
    ${samples(W, H, CYAN, 60)}
    ${span(W * 0.2, W * 0.8, H * 0.86, VIOLET, 'WEEK 01')}
    ${ticks(W, H, BLUE, 30, 38)}
    ${mono(46, 74, 'THE RISKY PART ONLY', BLUE, 17)}`);
}

/** What a proof buys you — three, 4:3. */
function gain(i) {
  const W = 800; const H = 600;
  const c = [BLUE, VIOLET, PURPLE][i];
  const motifs = [
    () => rings(W * 0.5, H * 0.5, c, 6, 58, 38) + samples(W, H, c, 44),
    () => planes(W, H, c, 5),
    () => verdict(W * 0.5, H * 0.48, 86, c) + rings(W * 0.5, H * 0.5, c, 3, 150, 34),
  ];

  return svg(`0 0 ${W} ${H}`, `
    ${ground(W, H, c, INK)}
    ${motifs[i]()}
    ${ticks(W, H, c, 24, 30)}
    ${mono(44, H - 38, ['DE-RISK', 'COST', 'EVIDENCE'][i], c, 16)}`);
}

/** The eight scope cards — 8:5. */
function inside(i) {
  const W = 800; const H = 500;
  const c = [BLUE, VIOLET, PURPLE, CYAN, BLUE, VIOLET, PURPLE, CYAN][i];
  const motifs = [
    () => samples(W, H, c, 70),
    () => planes(W, H, c, 5),
    () => rings(W * 0.28, H * 0.5, c, 6, 40, 34) + samples(W, H, c, 26),
    () => span(W * 0.16, W * 0.84, H * 0.5, c, '') + samples(W, H, c, 34),
    () => planes(W, H, c, 4) + samples(W, H, c, 22),
    () => rings(W * 0.5, H * 0.5, c, 5, 52, 36),
    () => verdict(W * 0.5, H * 0.48, 62, c),
    () => span(W * 0.2, W * 0.8, H * 0.62, c, 'NEXT') + planes(W, H, c, 3),
  ];

  return svg(`0 0 ${W} ${H}`, `
    ${ground(W, H, c, INK)}
    ${motifs[i]()}
    ${ticks(W, H, c, 20, 26)}
    ${mono(38, H - 30, String(i + 1).padStart(2, '0'), c, 20)}`);
}

/** The five process steps — 3:2. */
function step(i) {
  const W = 900; const H = 600;
  const c = [BLUE, VIOLET, PURPLE, CYAN, BLUE][i];
  const motifs = [
    () => rings(W * 0.5, H * 0.5, c, 5, 56, 40),
    () => span(W * 0.18, W * 0.82, H * 0.5, c, 'ONE QUESTION'),
    () => planes(W, H, c, 6),
    () => verdict(W * 0.5, H * 0.46, 78, c) + rings(W * 0.5, H * 0.5, c, 3, 140, 32),
    () => samples(W, H, c, 74) + span(W * 0.24, W * 0.76, H * 0.84, c, 'YOURS'),
  ];

  return svg(`0 0 ${W} ${H}`, `
    ${ground(W, H, c, PURPLE)}
    ${motifs[i]()}
    ${ticks(W, H, c, 24, 32)}
    ${mono(44, H - 36, 'STEP ' + String(i + 1).padStart(2, '0'), c, 18)}`);
}

/** The six sectors — 3:2. */
function sector(i) {
  const W = 900; const H = 600;
  const c = [BLUE, CYAN, VIOLET, PURPLE, BLUE, VIOLET][i];
  const label = ['RETAIL', 'HEALTHCARE', 'SAAS', 'LOGISTICS', 'FINTECH', 'E-COMMERCE'][i];

  /* Each sector gets a different density and centre, so the run of six reads
     as six places rather than one texture repeated. */
  const cx = [0.28, 0.7, 0.5, 0.34, 0.66, 0.5][i];
  const cy = [0.42, 0.55, 0.36, 0.62, 0.4, 0.56][i];

  return svg(`0 0 ${W} ${H}`, `
    ${ground(W, H, c, INK)}
    ${rings(W * cx, H * cy, c, 6, 46, 38)}
    ${samples(W, H, c, 52 + i * 8)}
    ${planes(W, H, c, 3)}
    ${ticks(W, H, c, 24, 32)}
    ${mono(44, H - 36, label, c, 18)}`);
}

/** Why choose us — 20:13. */
function why(i) {
  const W = 800; const H = 520;
  const c = [BLUE, VIOLET, PURPLE, CYAN][i];
  const motifs = [
    () => planes(W, H, c, 5),
    () => span(W * 0.16, W * 0.84, H * 0.5, c, 'THRESHOLD'),
    () => verdict(W * 0.5, H * 0.47, 70, c),
    () => rings(W * 0.5, H * 0.5, c, 6, 44, 34),
  ];

  return svg(`0 0 ${W} ${H}`, `
    ${ground(W, H, c, INK)}
    ${motifs[i]()}
    ${ticks(W, H, c, 22, 28)}
    ${mono(40, H - 32, String(i + 1).padStart(2, '0'), c, 19)}`);
}

/** One beside the FAQ. */
function faq1() {
  const W = 800; const H = 600;

  return svg(`0 0 ${W} ${H}`, `
    ${ground(W, H, VIOLET, BLUE)}
    ${rings(W * 0.5, H * 0.5, VIOLET, 7, 46, 36)}
    ${samples(W, H, BLUE, 46)}
    ${ticks(W, H, VIOLET, 24, 30)}
    ${mono(44, H - 36, 'ASK EARLY', VIOLET, 18)}`);
}

const svg = (vb, body) =>
  `<svg viewBox="${vb}" preserveAspectRatio="xMidYMid meet" xmlns="http://www.w3.org/2000/svg">${body}</svg>`;

/* --------------------------------------------------------------------------
 * Render
 * ----------------------------------------------------------------------- */

/** [set, name, width, height, svg] */
const JOBS = [];
const add = (set, name, w, h, markup) => JOBS.push({ set, name, w, h, markup });

for (let i = 0; i < 6; i++) add('face', String(i + 1).padStart(2, '0'), 1000, 1000, face(i));
add('open', '01', 900, 1100, open1());
for (let i = 0; i < 3; i++) add('gain', String(i + 1).padStart(2, '0'), 800, 600, gain(i));
for (let i = 0; i < 8; i++) add('inside', String(i + 1).padStart(2, '0'), 800, 500, inside(i));
for (let i = 0; i < 5; i++) add('step', String(i + 1).padStart(2, '0'), 900, 600, step(i));
for (let i = 0; i < 6; i++) add('sector', String(i + 1).padStart(2, '0'), 900, 600, sector(i));
for (let i = 0; i < 4; i++) add('why', String(i + 1).padStart(2, '0'), 800, 520, why(i));
add('faq', '01', 800, 600, faq1());

const boxes = JOBS.map((j) => `
  <div id="art-${j.set}-${j.name}" style="width:${j.w}px;height:${j.h}px;overflow:hidden">
    ${j.markup}
  </div>`).join('\n');

const html = `<!doctype html><meta charset="utf-8">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;600;700&display=swap">
<style>
  body { margin: 0; background: ${INK}; }
  div { display: block; }
  svg { display: block; width: 100%; height: 100%; }
</style>
${boxes}
<script>window.__ids = ${JSON.stringify(JOBS.map((j) => `art-${j.set}-${j.name}`))};</script>`;

const tmp = path.join(here, '..', '.poc-art.html');
fs.writeFileSync(tmp, html);

const browser = await chromium.launch({ channel: 'chrome' });
const p = await browser.newPage({ viewport: { width: 1400, height: 1200 } });
p.on('pageerror', (e) => console.error('PAGE ERROR:', String(e).slice(0, 200)));
await p.goto('file:///' + tmp.split(path.sep).join('/'));
await p.waitForLoadState('networkidle');
/* The mono face has to be there before anything is captured, or the labels
   fall back to a default and the set stops matching the page. */
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
