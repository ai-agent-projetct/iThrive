/**
 * Every picture the ReactJS Development page uses.
 *
 *     node tools/react-art.mjs
 *
 * Same palette as the rest of the site, weighted a third way: the MVP page's
 * set is cyan around a magazine, the PoC page's is blue-violet around a
 * blueprint, and this one is CYAN-TEAL around a component graph — orbit rings,
 * connector hairlines and node clusters.
 *
 * Deliberately abstract, and explicitly not diagrams that only look
 * informative. Every one of these is superseded the moment the matching file
 * appears in assets/img/react/photo/, which tools/stock-photos.mjs fills and
 * the page's own $img() helper checks first.
 *
 *   deck/     6 cards for the hero's three.js deck
 *   compare/  2 for the draggable before/after
 *   doing/    6 for the "what we do" cards
 *   stack/    7 for the technology combinations
 *   sector/  10 tiles for the physics wall
 *   why/      5 for why choose us
 *   faq/      1 beside the questions
 *
 * Renders the way tools/poc-art.mjs does: one page of sized boxes,
 * screenshotted element by element, each through ffmpeg to a JPEG.
 */
import { chromium } from 'file:///C:/Users/aakas/AppData/Roaming/npm/node_modules/playwright/index.mjs';
import { fileURLToPath } from 'node:url';
import { execFileSync } from 'node:child_process';
import path from 'node:path';
import fs from 'node:fs';

const FFMPEG = 'C:/Users/aakas/Downloads/Central Adventure/repo/node_modules/ffmpeg-static/ffmpeg.exe';

const here = path.dirname(fileURLToPath(import.meta.url));
const OUT  = path.join(here, '..', 'assets', 'img', 'react');

/* style.css's own values, plus the teal this page leans on. */
const CYAN = '#00F2FE';
const TEAL = '#2FE0C8';
const BLUE = '#4EA8FF';
const INK  = '#0B0F17';

/* Seeded, so a re-run produces identical files and the diff stays empty when
   nothing about the art has changed. */
let seed = 20260904;
const rnd = () => (seed = (seed * 1103515245 + 12345) & 0x7fffffff) / 0x7fffffff;
const between = (a, b) => a + rnd() * (b - a);

const svg = (vb, body) =>
  `<svg viewBox="${vb}" preserveAspectRatio="xMidYMid meet" xmlns="http://www.w3.org/2000/svg">${body}</svg>`;

/* --------------------------------------------------------------------------
 * Vocabulary — small, so forty-odd pictures still read as one set
 * ----------------------------------------------------------------------- */

let gid = 0;

/** Ink, two soft washes, and a faint connector mesh. */
function ground(w, h, tint, tint2, lift = 1, base = INK) {
  const a = `r${gid++}`;
  const b = `r${gid++}`;
  const o = (v) => Math.min(0.95, v * lift).toFixed(3);

  return `
    <defs>
      <radialGradient id="${a}">
        <stop offset="0" stop-color="${tint}" stop-opacity="${o(0.36)}"/>
        <stop offset="0.55" stop-color="${tint}" stop-opacity="${o(0.13)}"/>
        <stop offset="1" stop-color="${tint}" stop-opacity="0"/>
      </radialGradient>
      <radialGradient id="${b}">
        <stop offset="0" stop-color="${tint2}" stop-opacity="${o(0.30)}"/>
        <stop offset="0.55" stop-color="${tint2}" stop-opacity="${o(0.10)}"/>
        <stop offset="1" stop-color="${tint2}" stop-opacity="0"/>
      </radialGradient>
    </defs>
    <rect width="${w}" height="${h}" fill="${base}"/>
    <ellipse cx="${w * 0.82}" cy="${h * 0.1}" rx="${w * 0.76}" ry="${h * 0.72}" fill="url(#${a})"/>
    <ellipse cx="${w * 0.1}" cy="${h * 0.92}" rx="${w * 0.7}" ry="${h * 0.66}" fill="url(#${b})"/>`;
}

/**
 * The orbit: React's own mark, abstracted.
 *
 * Three ellipses at 60 degrees to each other around a nucleus. It is the one
 * shape on this page that is unmistakably about React, so it carries the set
 * the way the corner tick carries the PoC page's.
 */
function orbit(cx, cy, r, c, tilt = 0) {
  let s = '';
  for (let i = 0; i < 3; i++) {
    s += `<ellipse cx="${cx}" cy="${cy}" rx="${r}" ry="${r * 0.38}" fill="none"
      stroke="${c}" stroke-opacity="0.5" stroke-width="2"
      transform="rotate(${tilt + i * 60} ${cx} ${cy})"/>`;
  }
  s += `<circle cx="${cx}" cy="${cy}" r="${r * 0.1}" fill="${c}" opacity="0.85"/>`;

  return s;
}

/** A cluster of nodes joined by hairlines — a component tree, loosely. */
function graph(w, h, c, n) {
  const pts = [];
  for (let i = 0; i < n; i++) pts.push([between(w * 0.12, w * 0.88), between(h * 0.15, h * 0.85)]);

  let s = '';
  /* Join each node to its nearest neighbour only, so it reads as structure
     rather than as a mesh of everything to everything. */
  for (let i = 0; i < pts.length; i++) {
    let best = -1;
    let bd = Infinity;
    for (let j = 0; j < pts.length; j++) {
      if (i === j) continue;
      const d = (pts[i][0] - pts[j][0]) ** 2 + (pts[i][1] - pts[j][1]) ** 2;
      if (d < bd) { bd = d; best = j; }
    }
    s += `<line x1="${pts[i][0].toFixed(1)}" y1="${pts[i][1].toFixed(1)}"
      x2="${pts[best][0].toFixed(1)}" y2="${pts[best][1].toFixed(1)}"
      stroke="${c}" stroke-opacity="0.26" stroke-width="1.2"/>`;
  }
  for (const [x, y] of pts) {
    s += `<circle cx="${x.toFixed(1)}" cy="${y.toFixed(1)}" r="${between(2.5, 6).toFixed(1)}"
      fill="${c}" opacity="${between(0.35, 0.85).toFixed(2)}"/>`;
  }

  return s;
}

/** Nested rounded rectangles — composition, seen from the front. */
function nest(w, h, c, n) {
  let s = '';
  for (let i = 0; i < n; i++) {
    const inset = (Math.min(w, h) * 0.08) * (i + 1);
    s += `<rect x="${inset}" y="${inset}" width="${w - inset * 2}" height="${h - inset * 2}"
      rx="${14 + i * 4}" fill="none" stroke="${c}"
      stroke-opacity="${(0.42 - i * 0.07).toFixed(2)}" stroke-width="1.6"/>`;
  }

  return s;
}

/** A bar of stacked segments — a bundle, split. */
function bundle(w, h, c, n) {
  let s = '';
  const y = h * 0.5;
  let x = w * 0.14;
  const total = w * 0.72;
  for (let i = 0; i < n; i++) {
    const seg = total / n * between(0.6, 1.4);
    s += `<rect x="${x.toFixed(1)}" y="${(y - h * 0.055).toFixed(1)}" width="${Math.max(8, seg - 6).toFixed(1)}"
      height="${(h * 0.11).toFixed(1)}" rx="4" fill="${c}"
      opacity="${(0.5 - i * 0.05).toFixed(2)}"/>`;
    x += seg;
    if (x > w * 0.9) break;
  }

  return s;
}

const mono = (x, y, t, c, size = 15, anchor = 'start') => `
  <text x="${x}" y="${y}" text-anchor="${anchor}" font-family="JetBrains Mono, monospace"
    font-size="${size}" letter-spacing="3.5" fill="${c}" fill-opacity="0.8">${t}</text>`;

/* --------------------------------------------------------------------------
 * The sets
 * ----------------------------------------------------------------------- */

const TINTS = [CYAN, TEAL, BLUE];

/** Hero deck cards — brighter, because they are lit panels in a WebGL scene. */
function deck(i) {
  const W = 1200; const H = 860;
  const c = TINTS[i % 3];
  const motifs = [
    () => nest(W, H, c, 4),
    () => graph(W, H, c, 16),
    () => bundle(W, H, c, 7),
    () => orbit(W * 0.5, H * 0.5, 250, c, 12),
    () => nest(W, H, c, 3) + graph(W, H, c, 9),
    () => orbit(W * 0.5, H * 0.5, 210, c, 30) + graph(W, H, c, 8),
  ];

  /* lift 2.4 and a base off pure ink, for the same reason the PoC page's cube
     faces need it: at the page's usual weight they render as black panels. */
  return svg(`0 0 ${W} ${H}`, `
    ${ground(W, H, c, BLUE, 2.4, '#122530')}
    ${motifs[i]()}
    ${mono(46, H - 40, String(i + 1).padStart(2, '0'), '#FFFFFF', 30)}
    ${mono(W - 46, H - 40, 'REACT', '#FFFFFF', 17, 'end')}`);
}

/** The before/after pair. Same composition, different density and colour, so
    the drag reads as one product in two states rather than two pictures. */
function compare(i) {
  const W = 900; const H = 700;
  const before = i === 0;
  const c = before ? '#8FA0AE' : CYAN;

  return svg(`0 0 ${W} ${H}`, `
    ${ground(W, H, before ? '#7E8C99' : CYAN, before ? '#5A6570' : TEAL, before ? 0.8 : 1.5)}
    ${graph(W, H, c, before ? 26 : 12)}
    ${before ? '' : nest(W, H, TEAL, 3)}
    ${mono(40, H - 34, before ? 'BEFORE' : 'AFTER', c, 17)}`);
}

/** What we do — six, 8:5. */
function doing(i) {
  const W = 800; const H = 500;
  const c = TINTS[i % 3];
  const motifs = [
    () => nest(W, H, c, 4),
    () => bundle(W, H, c, 6),
    () => graph(W, H, c, 14),
    () => orbit(W * 0.5, H * 0.5, 150, c, 20),
    () => graph(W, H, c, 10) + nest(W, H, c, 2),
    () => bundle(W, H, c, 9) + graph(W, H, c, 6),
  ];

  return svg(`0 0 ${W} ${H}`, `
    ${ground(W, H, c, INK)}
    ${motifs[i]()}
    ${mono(36, H - 28, String(i + 1).padStart(2, '0'), c, 19)}`);
}

/** Technology combinations — seven, 8:5. */
function stack(i) {
  const W = 800; const H = 500;
  const c = TINTS[i % 3];

  /* Each stack gets a different node count, so the run of seven reads as seven
     arrangements rather than one texture repeated. */
  return svg(`0 0 ${W} ${H}`, `
    ${ground(W, H, c, TINTS[(i + 1) % 3])}
    ${graph(W, H, c, 8 + i * 2)}
    ${nest(W, H, c, 2)}
    ${mono(36, H - 28, String(i + 1).padStart(2, '0'), c, 19)}`);
}

/** Sector tiles for the physics wall — square, and readable when small. */
function sector(i) {
  const W = 600;
  const c = TINTS[i % 3];
  const motifs = [
    () => orbit(W * 0.5, W * 0.5, 190, c, 0),
    () => nest(W, W, c, 4),
    () => graph(W, W, c, 12),
    () => bundle(W, W, c, 5),
  ];

  return svg(`0 0 ${W} ${W}`, `
    ${ground(W, W, c, TINTS[(i + 2) % 3], 1.9, '#101F29')}
    ${motifs[i % 4]()}
    ${mono(W / 2, W - 40, String(i + 1).padStart(2, '0'), '#FFFFFF', 26, 'middle')}`);
}

/** Why choose us — five, 20:13. */
function why(i) {
  const W = 800; const H = 520;
  const c = TINTS[i % 3];
  const motifs = [
    () => bundle(W, H, c, 8),
    () => graph(W, H, c, 13),
    () => nest(W, H, c, 4),
    () => orbit(W * 0.5, H * 0.5, 150, c, 45),
    () => graph(W, H, c, 9) + bundle(W, H, c, 4),
  ];

  return svg(`0 0 ${W} ${H}`, `
    ${ground(W, H, c, INK)}
    ${motifs[i]()}
    ${mono(36, H - 28, String(i + 1).padStart(2, '0'), c, 19)}`);
}

function faq1() {
  const W = 800; const H = 600;

  return svg(`0 0 ${W} ${H}`, `
    ${ground(W, H, TEAL, CYAN)}
    ${orbit(W * 0.5, H * 0.5, 175, TEAL, 15)}
    ${graph(W, H, CYAN, 10)}
    ${mono(40, H - 32, 'ASK FIRST', TEAL, 17)}`);
}

/* --------------------------------------------------------------------------
 * Render
 * ----------------------------------------------------------------------- */

const JOBS = [];
const add = (set, name, w, h, markup) => JOBS.push({ set, name, w, h, markup });

for (let i = 0; i < 6; i++) add('deck', String(i + 1).padStart(2, '0'), 1200, 860, deck(i));
for (let i = 0; i < 2; i++) add('compare', String(i + 1).padStart(2, '0'), 900, 700, compare(i));
for (let i = 0; i < 6; i++) add('doing', String(i + 1).padStart(2, '0'), 800, 500, doing(i));
for (let i = 0; i < 7; i++) add('stack', String(i + 1).padStart(2, '0'), 800, 500, stack(i));
for (let i = 0; i < 10; i++) add('sector', String(i + 1).padStart(2, '0'), 600, 600, sector(i));
for (let i = 0; i < 5; i++) add('why', String(i + 1).padStart(2, '0'), 800, 520, why(i));
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
  svg { display: block; width: 100%; height: 100%; }
</style>
${boxes}
<script>window.__ids = ${JSON.stringify(JOBS.map((j) => `art-${j.set}-${j.name}`))};</script>`;

const tmp = path.join(here, '..', '.react-art.html');
fs.writeFileSync(tmp, html);

const browser = await chromium.launch({ channel: 'chrome' });
const p = await browser.newPage({ viewport: { width: 1400, height: 1000 } });
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
