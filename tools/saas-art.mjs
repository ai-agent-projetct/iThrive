/**
 * Every picture the Micro-SaaS page uses.
 *
 *     node tools/saas-art.mjs
 *
 * Sixth set, in the site's own palette — #00F2FE into #4EA8FF into #9D4EDD on
 * ink. The Dedicated Team page tried a colour of its own and stopped looking
 * like the same website, so what makes a set its own here is the MOTIF.
 *
 * This one is the APERTURE: nested squares turning as they narrow, closing on
 * a single lit point. A micro-SaaS is a narrow product aimed at one job, and
 * that is the shape of it. The other five sets are a magazine, a blueprint, a
 * component graph, a roster of seats and a board of signal bars.
 *
 *   shard/    6 faces for the hero's CSS 3D stack
 *   frame/    6 for the framework cards
 *   vert/     5 for the vertical tabs
 *   adv/      4 for the advantage cards
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
const OUT  = path.join(here, '..', 'assets', 'img', 'saas');

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

/**
 * The aperture: nested squares, each turned a little further as it narrows.
 *
 * It is the one shape on this page that is about the subject — a product aimed
 * at exactly one job — and it carries the set the way the roster's seat mark
 * carries the Dedicated Team page's.
 */
function aperture(w, h, c, n) {
  const cx = w / 2;
  const cy = h * 0.48;
  const r0 = Math.min(w, h) * 0.36;

  let out = '';
  for (let i = 0; i < n; i++) {
    const r = r0 * (1 - i / (n + 0.6));
    const turn = i * (45 / n);
    out += `<rect x="${(cx - r).toFixed(1)}" y="${(cy - r).toFixed(1)}"
      width="${(r * 2).toFixed(1)}" height="${(r * 2).toFixed(1)}" rx="${(r * 0.14).toFixed(1)}"
      fill="none" stroke="${c}" stroke-opacity="${(0.5 - i * 0.05).toFixed(2)}" stroke-width="2"
      transform="rotate(${turn.toFixed(1)} ${cx.toFixed(1)} ${cy.toFixed(1)})"/>`;
  }
  out += `<circle cx="${cx}" cy="${cy}" r="${(r0 * 0.08).toFixed(1)}" fill="${c}" opacity="0.9"/>`;

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

/** A rule that narrows toward the point, rather than filling. */
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
    ${isCover ? pulse(W * 0.5, H * 0.44, c, 5, 70, 44) + aperture(W, H, c, 3) : aperture(W, H, c, 5)}
    ${capacity(W, H, c, isCover ? 0.9 : 0.3 + i * 0.12)}
    ${mono(W / 2, H - 56, isCover ? 'MICRO SAAS' : String(i + 1).padStart(2, '0'), '#FFFFFF', 24, 'middle')}`);
}

function tile(i, w, h, motif, lift = 1.2) {
  const c = TINTS[i % 3];
  const scenes = {
    bars: () => aperture(w, h, c, 5),
    pulse: () => pulse(w * 0.5, h * 0.46, c, 5, 46, 34) + aperture(w, h, c, 3),
    mixed: () => aperture(w, h, c, 4) + motes(w, h, c, 14),
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

for (let i = 0; i < 6; i++) add('shard', String(i + 1).padStart(2, '0'), 760, 1000, bookPage(i, i === 0));
for (let i = 0; i < 6; i++) add('frame', String(i + 1).padStart(2, '0'), 800, 500, tile(i, 800, 500, 'bars'));
for (let i = 0; i < 5; i++) add('vert',  String(i + 1).padStart(2, '0'), 900, 600, tile(i, 900, 600, 'mixed'));
for (let i = 0; i < 4; i++) add('adv',   String(i + 1).padStart(2, '0'), 800, 500, tile(i, 800, 500, 'pulse'));
add('hero', '01', 1800, 1000, tile(0, 1800, 1000, 'pulse', 2.0));
add('faq',  '01', 800, 600, tile(2, 800, 600, 'mixed'));

const boxes = JOBS.map((j) => `
  <div id="art-${j.set}-${j.name}" style="width:${j.w}px;height:${j.h}px;overflow:hidden">${j.markup}</div>`).join('\n');

const html = `<!doctype html><meta charset="utf-8">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;600;700&display=swap">
<style>body{margin:0;background:${INK}} svg{display:block;width:100%;height:100%}</style>
${boxes}
<script>window.__ids = ${JSON.stringify(JOBS.map((j) => `art-${j.set}-${j.name}`))};</script>`;

const tmp = path.join(here, '..', '.saas-art.html');
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
