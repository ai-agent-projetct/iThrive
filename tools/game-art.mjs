/**
 * Every picture the Game Development page uses.
 *
 *     node tools/game-art.mjs
 *
 * Tenth set, in the site's own palette — #00F2FE into #4EA8FF into #9D4EDD on
 * ink. What makes a set its own here is the MOTIF, never the hue.
 *
 * This one is the SPRITE: a coarse pixel grid with cells lit to form a glyph,
 * a few pixels still in flight around it, and a scanline across the plate. It
 * is the oldest idea in the medium and the one that still reads instantly as a
 * game at any size, which the finer motifs on this site would not.
 *
 * The nine earlier sets are a magazine, a blueprint, a component graph, a
 * roster of seats, a board of signal bars, an aperture, a stack of strata, a
 * strangler-fig lattice and an orbit.
 *
 *   ind/      3 for the industries we build for
 *   cap/      5 for the capability cards
 *   work/     6 for the kinds of build
 *   step/     4 for the process
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
const OUT  = path.join(here, '..', 'assets', 'img', 'game');

const CYAN = '#00F2FE';
const BLUE = '#4EA8FF';
const PURPLE = '#9D4EDD';
const INK = '#0B0F17';
const TINTS = [CYAN, BLUE, PURPLE];

let seed = 20260908;
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
        <stop offset="0" stop-color="${tint2}" stop-opacity="${o(0.26)}"/>
        <stop offset="0.55" stop-color="${tint2}" stop-opacity="${o(0.09)}"/>
        <stop offset="1" stop-color="${tint2}" stop-opacity="0"/>
      </radialGradient>
    </defs>
    <rect width="${w}" height="${h}" fill="${base}"/>
    <ellipse cx="${w * 0.5}" cy="${h * 0.42}" rx="${w * 0.6}" ry="${h * 0.66}" fill="url(#${a})"/>
    <ellipse cx="${w * 0.14}" cy="${h * 0.92}" rx="${w * 0.58}" ry="${h * 0.56}" fill="url(#${b})"/>`;
}

/*
 * The glyphs, as bitmaps.
 *
 * Eight rows of eight, written out rather than generated, because the whole
 * point of a sprite is that a person placed every pixel. '1' is lit, '.' is
 * the dark grid behind it.
 */
const GLYPHS = {
  ship: [
    '...11...',
    '...11...',
    '..1111..',
    '..1111..',
    '.111111.',
    '11111111',
    '1.1111.1',
    '...11...',
  ],
  heart: [
    '.11..11.',
    '11111111',
    '11111111',
    '11111111',
    '.111111.',
    '..1111..',
    '...11...',
    '........',
  ],
  star: [
    '...11...',
    '...11...',
    '..1111..',
    '11111111',
    '.111111.',
    '..1111..',
    '.11..11.',
    '11....11',
  ],
  coin: [
    '..1111..',
    '.111111.',
    '11.11.11',
    '11.11.11',
    '11.11.11',
    '11.11.11',
    '.111111.',
    '..1111..',
  ],
  key: [
    '.1111...',
    '11..11..',
    '11..11..',
    '.1111...',
    '..11....',
    '..1111..',
    '..11....',
    '..111...',
  ],
  pad: [
    '........',
    '..1..1..',
    '.111..1.',
    '11111111',
    '11111111',
    '.111111.',
    '.1....1.',
    '........',
  ],
};

const GLYPH_NAMES = Object.keys(GLYPHS);

/** One sprite plate: the dark grid, the lit glyph, and pixels in flight. */
function sprite(w, h, c, name, loose = 6) {
  const rows = GLYPHS[name];
  const n = 8;
  const cell = Math.min(w, h) * 0.062;
  const gap = cell * 0.16;
  const step = cell + gap;
  const x0 = w / 2 - (step * n - gap) / 2;
  const y0 = h * 0.46 - (step * n - gap) / 2;

  let out = '';

  for (let r = 0; r < n; r++) {
    for (let q = 0; q < n; q++) {
      const on = rows[r][q] === '1';
      const x = x0 + q * step;
      const y = y0 + r * step;

      out += `<rect x="${x.toFixed(1)}" y="${y.toFixed(1)}" width="${cell.toFixed(1)}" height="${cell.toFixed(1)}"
        rx="${(cell * 0.16).toFixed(1)}" fill="${on ? c : '#FFFFFF'}"
        fill-opacity="${on ? 0.92 : 0.05}"/>`;
    }
  }

  /* Pixels that have left the grid — the sprite coming apart, or assembling. */
  for (let i = 0; i < loose; i++) {
    const side = rnd() < 0.5 ? -1 : 1;
    const x = w / 2 + side * between(step * 4.6, w * 0.44);
    const y = between(h * 0.12, h * 0.82);
    const sz = cell * between(0.5, 1);
    out += `<rect x="${x.toFixed(1)}" y="${y.toFixed(1)}" width="${sz.toFixed(1)}" height="${sz.toFixed(1)}"
      rx="${(sz * 0.18).toFixed(1)}" fill="${c}" fill-opacity="${between(0.25, 0.75).toFixed(2)}"/>`;
  }

  return out;
}

/** A scanline band across the plate — the CRT the medium grew up on. */
function scanline(w, h, c) {
  const y = h * 0.63;
  const id = `s${gid++}`;

  return `
    <defs>
      <linearGradient id="${id}" x1="0" y1="0" x2="1" y2="0">
        <stop offset="0" stop-color="${c}" stop-opacity="0"/>
        <stop offset="0.5" stop-color="${c}" stop-opacity="0.5"/>
        <stop offset="1" stop-color="${c}" stop-opacity="0"/>
      </linearGradient>
    </defs>
    <rect x="0" y="${y.toFixed(1)}" width="${w}" height="2.5" fill="url(#${id})"/>`;
}

/** A row of lives, bottom-left — the other universal game glyph. */
function lives(w, h, c, n) {
  let out = '';
  for (let i = 0; i < 3; i++) {
    const x = 34 + i * 20;
    out += `<rect x="${x}" y="${(h - 40).toFixed(1)}" width="11" height="11" rx="2"
      fill="${c}" fill-opacity="${i < n ? 0.9 : 0.18}"/>`;
  }

  return out;
}

const mono = (x, y, t, c, size = 15, anchor = 'start') => `
  <text x="${x}" y="${y}" text-anchor="${anchor}" font-family="DM Mono, monospace"
    font-size="${size}" letter-spacing="3" fill="${c}" fill-opacity="0.85">${t}</text>`;

/* -------------------------------------------------------------------------- */

function tile(i, w, h, glyph, lift = 1.2) {
  const c = TINTS[i % 3];

  return svg(`0 0 ${w} ${h}`, `
    ${ground(w, h, c, TINTS[(i + 1) % 3], lift, '#101822')}
    ${sprite(w, h, c, glyph, 7)}
    ${scanline(w, h, c)}
    ${lives(w, h, c, 3 - (i % 3))}
    ${mono(w - 32, h - 30, 'P' + String(i + 1).padStart(2, '0'), c, 16, 'end')}`);
}

/* -------------------------------------------------------------------------- */

const JOBS = [];
const add = (set, name, w, h, markup) => JOBS.push({ set, name, w, h, markup });
const pad = (n) => String(n).padStart(2, '0');

const pick = (i) => GLYPH_NAMES[i % GLYPH_NAMES.length];

for (let i = 0; i < 3; i++) add('ind',  pad(i + 1), 860, 620, tile(i, 860, 620, pick(i), 1.3));
for (let i = 0; i < 5; i++) add('cap',  pad(i + 1), 760, 500, tile(i, 760, 500, pick(i + 1), 1.2));
for (let i = 0; i < 6; i++) add('work', pad(i + 1), 820, 560, tile(i, 820, 560, pick(i + 2), 1.25));
for (let i = 0; i < 4; i++) add('step', pad(i + 1), 800, 520, tile(i, 800, 520, pick(i + 3), 1.25));
add('hero', '01', 1800, 1000, tile(1, 1800, 1000, 'ship', 1.9));
add('faq',  '01', 800, 620, tile(2, 800, 620, 'pad', 1.2));

const boxes = JOBS.map((j) => `
  <div id="art-${j.set}-${j.name}" style="width:${j.w}px;height:${j.h}px;overflow:hidden">${j.markup}</div>`).join('\n');

const html = `<!doctype html><meta charset="utf-8">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=DM+Mono:wght@400;500&display=swap">
<style>body{margin:0;background:${INK}} svg{display:block;width:100%;height:100%}</style>
${boxes}
<script>window.__ids = ${JSON.stringify(JOBS.map((j) => `art-${j.set}-${j.name}`))};</script>`;

const tmp = path.join(here, '..', '.game-art.html');
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
