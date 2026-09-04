/**
 * Every picture the On-Demand Resources page uses.
 *
 *     node tools/ondemand-art.mjs
 *
 * Fifth set on the site, in the site's own palette — #00F2FE into #4EA8FF into
 * #9D4EDD on ink, unchanged. The Dedicated Team page tried a colour of its own
 * and stopped looking like the same website; what makes a set its own here is
 * the MOTIF.
 *
 * This one is AVAILABILITY: signal bars, a pulse ring, and a capacity rule that
 * fills part way. Where the React set is a component graph, the PoC set a
 * blueprint and the Team set a roster of seats, this one reads as a board
 * showing who is free.
 *
 *   book/     cover + 6 pages for the hero's 3D book
 *   role/     5 disciplines x 2 (base and reveal, for the hover component)
 *   benefit/  5 for the bento grid
 *   step/     5 for the motion gallery
 *   model/    3 for the hiring models
 *   adv/      6 for the six reasons
 *   hero/     1 wide ground for the pixelate-on-hover hero
 *   close/    1 under the water ripple
 *   faq/      1 beside the questions
 */
import { chromium } from 'file:///C:/Users/aakas/AppData/Roaming/npm/node_modules/playwright/index.mjs';
import { fileURLToPath } from 'node:url';
import { execFileSync } from 'node:child_process';
import path from 'node:path';
import fs from 'node:fs';

const FFMPEG = 'C:/Users/aakas/Downloads/Central Adventure/repo/node_modules/ffmpeg-static/ffmpeg.exe';
const here = path.dirname(fileURLToPath(import.meta.url));
const OUT  = path.join(here, '..', 'assets', 'img', 'ondemand');

const CYAN = '#00F2FE';
const BLUE = '#4EA8FF';
const PURPLE = '#9D4EDD';
const INK = '#0B0F17';
const TINTS = [CYAN, BLUE, PURPLE];

let seed = 20260904;
const rnd = () => (seed = (seed * 1103515245 + 12345) & 0x7fffffff) / 0x7fffffff;
const between = (a, b) => a + rnd() * (b - a);

const svg = (vb, body) =>
  `<svg viewBox="${vb}" preserveAspectRatio="xMidYMid meet" xmlns="http://www.w3.org/2000/svg">${body}</svg>`;

let gid = 0;

function ground(w, h, tint, tint2, lift = 1, base = INK) {
  const a = `o${gid++}`; const b = `o${gid++}`;
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
    <ellipse cx="${w * 0.76}" cy="${h * 0.16}" rx="${w * 0.7}" ry="${h * 0.66}" fill="url(#${a})"/>
    <ellipse cx="${w * 0.16}" cy="${h * 0.88}" rx="${w * 0.66}" ry="${h * 0.62}" fill="url(#${b})"/>`;
}

/** Signal bars — the availability mark. */
function bars(w, h, c, n, lit) {
  const bw = Math.min(w, h) * 0.055;
  const gap = bw * 0.7;
  const total = n * bw + (n - 1) * gap;
  const x0 = (w - total) / 2;
  const base = h * 0.62;

  let out = '';
  for (let i = 0; i < n; i++) {
    const bh = (h * 0.08) + i * (h * 0.055);
    out += `<rect x="${(x0 + i * (bw + gap)).toFixed(1)}" y="${(base - bh).toFixed(1)}"
      width="${bw.toFixed(1)}" height="${bh.toFixed(1)}" rx="${(bw * 0.28).toFixed(1)}"
      fill="${c}" fill-opacity="${i < lit ? 0.55 : 0.12}"
      stroke="${c}" stroke-opacity="${i < lit ? 0.85 : 0.3}" stroke-width="1.6"/>`;
  }

  return out;
}

/** A pulse: concentric rings from one point. */
function pulse(cx, cy, c, n, r0, gap) {
  let out = `<circle cx="${cx}" cy="${cy}" r="${r0 * 0.32}" fill="${c}" opacity="0.85"/>`;
  for (let i = 0; i < n; i++) {
    out += `<circle cx="${cx}" cy="${cy}" r="${r0 + i * gap}" fill="none" stroke="${c}"
      stroke-opacity="${(0.44 - i * 0.06).toFixed(2)}" stroke-width="1.7"/>`;
  }

  return out;
}

/** A capacity rule, filled part way. */
function capacity(w, h, c, frac) {
  const x0 = w * 0.16; const x1 = w * 0.84; const y = h * 0.82;

  return `
    <line x1="${x0}" y1="${y}" x2="${x1}" y2="${y}" stroke="${c}" stroke-opacity="0.2" stroke-width="5" stroke-linecap="round"/>
    <line x1="${x0}" y1="${y}" x2="${(x0 + (x1 - x0) * frac).toFixed(1)}" y2="${y}"
      stroke="${c}" stroke-opacity="0.8" stroke-width="5" stroke-linecap="round"/>`;
}

/** Loose motes, texture only. */
function motes(w, h, c, n) {
  let out = '';
  for (let i = 0; i < n; i++) {
    out += `<circle cx="${between(w * 0.08, w * 0.92).toFixed(1)}" cy="${between(h * 0.08, h * 0.92).toFixed(1)}"
      r="${between(1.4, 3.4).toFixed(1)}" fill="${c}" opacity="${between(0.2, 0.6).toFixed(2)}"/>`;
  }

  return out;
}

const mono = (x, y, t, c, size = 15, anchor = 'start') => `
  <text x="${x}" y="${y}" text-anchor="${anchor}" font-family="JetBrains Mono, monospace"
    font-size="${size}" letter-spacing="3.5" fill="${c}" fill-opacity="0.82">${t}</text>`;

/* -------------------------------------------------------------------------- */

/** Book pages — portrait, and lit, since they are pages of a 3D book. */
function bookPage(i, isCover) {
  const W = 700; const H = 950;
  const c = TINTS[i % 3];

  return svg(`0 0 ${W} ${H}`, `
    ${ground(W, H, c, TINTS[(i + 1) % 3], isCover ? 2.4 : 1.9, isCover ? '#132131' : '#111823')}
    ${isCover ? pulse(W * 0.5, H * 0.44, c, 5, 70, 44) : bars(W, H, c, 5, (i % 5) + 1)}
    ${capacity(W, H, c, isCover ? 0.9 : 0.3 + i * 0.12)}
    ${mono(W / 2, H - 56, isCover ? 'ON DEMAND' : String(i).padStart(2, '0'), '#FFFFFF', 24, 'middle')}`);
}

/** Role tiles: a and b, the pair the hover component swaps between. */
function role(i, variant) {
  const W = 700;
  const c = TINTS[i % 3];
  const lit = variant === 'b' ? 5 : (i % 3) + 1;

  return svg(`0 0 ${W} ${W}`, `
    ${ground(W, W, c, TINTS[(i + 2) % 3], variant === 'b' ? 2.2 : 1.3, '#121A24')}
    ${bars(W, W, c, 5, lit)}
    ${variant === 'b' ? pulse(W * 0.5, W * 0.3, c, 3, 34, 26) : motes(W, W, c, 16)}
    ${capacity(W, W, c, lit / 5)}
    ${mono(W / 2, W - 44, String(i + 1).padStart(2, '0'), '#FFFFFF', 24, 'middle')}`);
}

function tile(i, w, h, motif, lift = 1.2) {
  const c = TINTS[i % 3];
  const scenes = {
    bars: () => bars(w, h, c, 5, (i % 4) + 2),
    pulse: () => pulse(w * 0.5, h * 0.46, c, 5, 46, 34),
    mixed: () => bars(w, h, c, 4, (i % 3) + 1) + motes(w, h, c, 14),
  };

  return svg(`0 0 ${w} ${h}`, `
    ${ground(w, h, c, TINTS[(i + 1) % 3], lift, '#101822')}
    ${scenes[motif]()}
    ${capacity(w, h, c, 0.35 + (i % 4) * 0.15)}
    ${mono(36, h - 28, String(i + 1).padStart(2, '0'), c, 19)}`);
}

/* -------------------------------------------------------------------------- */

const JOBS = [];
const add = (set, name, w, h, markup) => JOBS.push({ set, name, w, h, markup });

add('book', 'cover', 700, 950, bookPage(0, true));
for (let i = 1; i <= 6; i++) add('book', String(i).padStart(2, '0'), 700, 950, bookPage(i, false));
for (let i = 0; i < 5; i++) {
  add('role', String(i + 1).padStart(2, '0') + 'a', 700, 700, role(i, 'a'));
  add('role', String(i + 1).padStart(2, '0') + 'b', 700, 700, role(i, 'b'));
}
for (let i = 0; i < 5; i++) add('benefit', String(i + 1).padStart(2, '0'), 800, 800, tile(i, 800, 800, 'pulse'));
for (let i = 0; i < 5; i++) add('step', String(i + 1).padStart(2, '0'), 900, 600, tile(i, 900, 600, 'bars'));
for (let i = 0; i < 3; i++) add('model', String(i + 1).padStart(2, '0'), 800, 600, tile(i, 800, 600, 'mixed'));
for (let i = 0; i < 6; i++) add('adv', String(i + 1).padStart(2, '0'), 800, 500, tile(i, 800, 500, 'bars'));
add('close', '01', 1600, 700, tile(1, 1600, 700, 'pulse', 1.6));
/* The hero's ground, for the pixelate-on-hover effect to reveal. Wide, lit
   more than the rest of the set, and carrying no logo — the mark was taken out
   of this hero deliberately. */
add('hero', '01', 1800, 1000, tile(0, 1800, 1000, 'pulse', 2.0));
add('faq', '01', 800, 600, tile(2, 800, 600, 'mixed'));

const boxes = JOBS.map((j) => `
  <div id="art-${j.set}-${j.name}" style="width:${j.w}px;height:${j.h}px;overflow:hidden">${j.markup}</div>`).join('\n');

const html = `<!doctype html><meta charset="utf-8">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;600;700&display=swap">
<style>body{margin:0;background:${INK}} svg{display:block;width:100%;height:100%}</style>
${boxes}
<script>window.__ids = ${JSON.stringify(JOBS.map((j) => `art-${j.set}-${j.name}`))};</script>`;

const tmp = path.join(here, '..', '.ondemand-art.html');
fs.writeFileSync(tmp, html);

const browser = await chromium.launch({ channel: 'chrome' });
const p = await browser.newPage({ viewport: { width: 1700, height: 1100 } });
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
