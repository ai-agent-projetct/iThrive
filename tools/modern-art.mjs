/**
 * Every picture the Product Modernization page uses.
 *
 *     node tools/modern-art.mjs
 *
 * Eighth set, in the site's own palette — #00F2FE into #4EA8FF into #9D4EDD on
 * ink. The Dedicated Team page tried a colour of its own and stopped looking
 * like the same website, so what makes a set its own here is the MOTIF.
 *
 * This one is the STRANGLER FIG, which is the name of the technique this page
 * sells: a routing layer goes in front of the legacy system and new services
 * take it over one endpoint at a time, both running until the last one moves.
 * So every picture is one lattice at a moment mid-migration — cells still on
 * the old side drawn dashed and dim, cells already carried over drawn solid and
 * lit, and a diagonal FRONT between them showing how far the work has got.
 *
 * The seven earlier sets are a magazine, a blueprint, a component graph, a
 * roster of seats, a board of signal bars, an aperture and a stack of strata.
 *
 *   face/     6 for the hero's 3D migration wall (3 legacy, 3 modern)
 *   risk/     4 for the cost of doing nothing
 *   adv/      5 for the competitive-advantage rolodex
 *   step/     5 for the journey
 *   why/      6 for the reasons
 *   model/    3 for the engagement options
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
const OUT  = path.join(here, '..', 'assets', 'img', 'modern');

const CYAN = '#00F2FE';
const BLUE = '#4EA8FF';
const PURPLE = '#9D4EDD';
const INK = '#0B0F17';
const TINTS = [CYAN, BLUE, PURPLE];

/* The legacy side is drawn in a desaturated slate rather than a new hue — it
   has to read as the SAME system before the work, not a different brand. */
const OLD = '#5C6C8C';

let seed = 20260906;
const rnd = () => (seed = (seed * 1103515245 + 12345) & 0x7fffffff) / 0x7fffffff;
const between = (a, b) => a + rnd() * (b - a);

const svg = (vb, body) =>
  `<svg viewBox="${vb}" preserveAspectRatio="xMidYMid meet" xmlns="http://www.w3.org/2000/svg">${body}</svg>`;

let gid = 0;

function ground(w, h, tint, tint2, lift = 1, base = INK) {
  const a = `m${gid++}`; const b = `m${gid++}`;
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
    <ellipse cx="${w * 0.82}" cy="${h * 0.12}" rx="${w * 0.7}" ry="${h * 0.7}" fill="url(#${a})"/>
    <ellipse cx="${w * 0.1}" cy="${h * 0.92}" rx="${w * 0.6}" ry="${h * 0.6}" fill="url(#${b})"/>`;
}

/**
 * The lattice, mid-migration.
 *
 * `front` is how far the work has got, 0 to 1, measured along the diagonal.
 * Cells before it are carried over — solid, lit, with a node. Cells after it
 * are still legacy — dashed, dim, and drawn in slate rather than a second hue,
 * because it is the same system on both sides of the line.
 */
function lattice(w, h, c, cols, rows, front) {
  const pad = Math.min(w, h) * 0.1;
  const cw = (w - pad * 2) / cols;
  const ch = (h - pad * 2) / rows;

  let out = '';

  for (let y = 0; y < rows; y++) {
    for (let x = 0; x < cols; x++) {
      /* Position along the diagonal, so the front sweeps corner to corner. */
      const t = (x / (cols - 1 || 1) + y / (rows - 1 || 1)) / 2;
      const done = t < front;

      const px = pad + x * cw + cw * 0.12;
      const py = pad + y * ch + ch * 0.12;
      const pw = cw * 0.76;
      const ph = ch * 0.76;

      out += `<rect x="${px.toFixed(1)}" y="${py.toFixed(1)}" width="${pw.toFixed(1)}" height="${ph.toFixed(1)}"
        rx="${(Math.min(pw, ph) * 0.16).toFixed(1)}" fill="${done ? c : 'none'}"
        fill-opacity="${done ? 0.1 : 0}" stroke="${done ? c : OLD}"
        stroke-opacity="${done ? 0.78 : 0.62}" stroke-width="${done ? 2 : 1.6}"
        ${done ? '' : 'stroke-dasharray="5 4"'}/>`;

      if (done) {
        out += `<circle cx="${(px + pw / 2).toFixed(1)}" cy="${(py + ph / 2).toFixed(1)}"
          r="${(Math.min(pw, ph) * 0.09).toFixed(1)}" fill="${c}" opacity="0.85"/>`;
      }
    }
  }

  return out;
}

/** The migration front itself — the line the work has reached. */
function frontLine(w, h, c, front) {
  const pad = Math.min(w, h) * 0.1;
  /* The diagonal t = front, drawn across the box. */
  const span = (w - pad * 2) + (h - pad * 2);
  const d = front * span;

  const x0 = pad + Math.min(d, w - pad * 2);
  const y0 = pad + Math.max(0, d - (w - pad * 2));
  const x1 = pad + Math.max(0, d - (h - pad * 2));
  const y1 = pad + Math.min(d, h - pad * 2);

  return `
    <line x1="${x0.toFixed(1)}" y1="${y0.toFixed(1)}" x2="${x1.toFixed(1)}" y2="${y1.toFixed(1)}"
      stroke="${c}" stroke-opacity="0.9" stroke-width="2.5" stroke-linecap="round"/>
    <circle cx="${x0.toFixed(1)}" cy="${y0.toFixed(1)}" r="5" fill="${c}"/>
    <circle cx="${x1.toFixed(1)}" cy="${y1.toFixed(1)}" r="5" fill="${c}"/>`;
}

/** A routing layer — the arrows that send traffic to the new side. */
function routes(w, h, c, n) {
  let out = '';
  for (let i = 0; i < n; i++) {
    const y = h * (0.24 + (i / Math.max(1, n - 1)) * 0.52);
    const x0 = w * 0.16;
    const x1 = w * 0.84;
    out += `<path d="M ${x0.toFixed(1)} ${y.toFixed(1)} L ${x1.toFixed(1)} ${y.toFixed(1)}"
      stroke="${c}" stroke-opacity="${(0.5 - i * 0.06).toFixed(2)}" stroke-width="1.6"
      stroke-dasharray="3 7" stroke-linecap="round"/>
      <circle cx="${x1.toFixed(1)}" cy="${y.toFixed(1)}" r="3.2" fill="${c}" opacity="0.8"/>`;
  }

  return out;
}

/** Loose motes, texture only. */
function motes(w, h, c, n) {
  let out = '';
  for (let i = 0; i < n; i++) {
    out += `<circle cx="${between(w * 0.06, w * 0.94).toFixed(1)}" cy="${between(h * 0.06, h * 0.94).toFixed(1)}"
      r="${between(1.2, 3).toFixed(1)}" fill="${c}" opacity="${between(0.16, 0.5).toFixed(2)}"/>`;
  }

  return out;
}

const mono = (x, y, t, c, size = 15, anchor = 'start') => `
  <text x="${x}" y="${y}" text-anchor="${anchor}" font-family="Space Mono, monospace"
    font-size="${size}" letter-spacing="3" fill="${c}" fill-opacity="0.85">${t}</text>`;

/* -------------------------------------------------------------------------- */

/** A card tile: the lattice caught at one point in the migration. */
function tile(i, w, h, front, lift = 1.2, extra = '') {
  const c = TINTS[i % 3];

  return svg(`0 0 ${w} ${h}`, `
    ${ground(w, h, c, TINTS[(i + 1) % 3], lift, '#101822')}
    ${lattice(w, h, c, 6, 4, front)}
    ${frontLine(w, h, c, front)}
    ${extra}
    ${mono(32, h - 24, String(i + 1).padStart(2, '0'), c, 17)}
    ${mono(w - 32, h - 24, Math.round(front * 100) + '%', '#FFFFFF', 15, 'end')}`);
}

/**
 * The hero wall's faces.
 *
 * Three legacy and three modern, because the wall flips between them: the
 * front of each tile is the system as it stands, the back is the same system
 * after the work. They have to read as a pair, so both use the same lattice —
 * one dashed and slate throughout, one solid and lit throughout.
 */
function face(i, isModern) {
  const W = 560; const H = 560;
  const c = TINTS[i % 3];

  return svg(`0 0 ${W} ${H}`, isModern ? `
    ${ground(W, H, c, TINTS[(i + 1) % 3], 1.8, '#101a26')}
    ${lattice(W, H, c, 5, 5, 1)}
    ${routes(W, H, c, 3)}
    ${mono(W / 2, H - 40, 'MODERN', '#FFFFFF', 22, 'middle')}` : `
    ${ground(W, H, OLD, OLD, 1.15, '#131926')}
    ${lattice(W, H, OLD, 5, 5, 0)}
    ${mono(W / 2, H - 40, 'LEGACY', OLD, 22, 'middle')}`);
}

/* -------------------------------------------------------------------------- */

const JOBS = [];
const add = (set, name, w, h, markup) => JOBS.push({ set, name, w, h, markup });
const pad = (n) => String(n).padStart(2, '0');

/* 01-03 legacy faces, 04-06 the modern ones they flip to. */
for (let i = 0; i < 3; i++) add('face', pad(i + 1), 560, 560, face(i, false));
for (let i = 0; i < 3; i++) add('face', pad(i + 4), 560, 560, face(i, true));

for (let i = 0; i < 4; i++) add('risk',  pad(i + 1), 720, 520, tile(i, 720, 520, 0.08 + i * 0.04, 1.0));
for (let i = 0; i < 5; i++) add('adv',   pad(i + 1), 820, 560, tile(i, 820, 560, 0.35 + i * 0.12, 1.3, routes(820, 560, TINTS[i % 3], 2)));
for (let i = 0; i < 5; i++) add('step',  pad(i + 1), 860, 540, tile(i, 860, 540, 0.15 + i * 0.2, 1.25));
for (let i = 0; i < 6; i++) add('why',   pad(i + 1), 760, 480, tile(i, 760, 480, 0.55 + (i % 3) * 0.14, 1.15));
for (let i = 0; i < 3; i++) add('model', pad(i + 1), 800, 500, tile(i, 800, 500, 0.4 + i * 0.22, 1.25));
add('hero', '01', 1800, 1000, tile(1, 1800, 1000, 0.52, 1.9, motes(1800, 1000, BLUE, 30)));
add('faq',  '01', 800, 620, tile(2, 800, 620, 0.72, 1.2));

const boxes = JOBS.map((j) => `
  <div id="art-${j.set}-${j.name}" style="width:${j.w}px;height:${j.h}px;overflow:hidden">${j.markup}</div>`).join('\n');

const html = `<!doctype html><meta charset="utf-8">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&display=swap">
<style>body{margin:0;background:${INK}} svg{display:block;width:100%;height:100%}</style>
${boxes}
<script>window.__ids = ${JSON.stringify(JOBS.map((j) => `art-${j.set}-${j.name}`))};</script>`;

const tmp = path.join(here, '..', '.modern-art.html');
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
