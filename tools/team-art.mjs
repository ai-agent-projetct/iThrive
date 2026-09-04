/**
 * Every picture the Dedicated Engineering Team page uses.
 *
 *     node tools/team-art.mjs
 *
 * Fourth set on the site, and the fourth weighting of the same palette. The MVP
 * page is cyan on a magazine, the PoC page blue-violet on a blueprint, the
 * React page cyan-teal on a component graph. This one is AMBER INTO CYAN on a
 * ROSTER — seat marks, name plates, a signature rule, and small stacked rows
 * that read as people rather than systems.
 *
 * Amber appears nowhere else on the site. That is the point: four dark pages in
 * one palette start to blur, and one colour that belongs to a single page is
 * the cheapest way to keep them apart.
 *
 *   role/   10 square tiles for the hero arc and the scroller
 *   why/     4 for the circle-expand cards
 *   proof/   5 grounds behind the glass stack
 *   model/   3 for the hiring-model cards
 *   faq/     1 beside the questions
 *
 * Renders the way the other three do: one page of sized boxes, screenshotted
 * element by element, each through ffmpeg to a JPEG.
 */
import { chromium } from 'file:///C:/Users/aakas/AppData/Roaming/npm/node_modules/playwright/index.mjs';
import { fileURLToPath } from 'node:url';
import { execFileSync } from 'node:child_process';
import path from 'node:path';
import fs from 'node:fs';

const FFMPEG = 'C:/Users/aakas/Downloads/Central Adventure/repo/node_modules/ffmpeg-static/ffmpeg.exe';

const here = path.dirname(fileURLToPath(import.meta.url));
const OUT  = path.join(here, '..', 'assets', 'img', 'team');

const AMBER = '#FFB042';
const CYAN  = '#00F2FE';
const BLUE  = '#4EA8FF';
const INK   = '#0B0F17';

/* Seeded, so a re-run produces identical files. */
let seed = 20260904;
const rnd = () => (seed = (seed * 1103515245 + 12345) & 0x7fffffff) / 0x7fffffff;
const between = (a, b) => a + rnd() * (b - a);

const svg = (vb, body) =>
  `<svg viewBox="${vb}" preserveAspectRatio="xMidYMid meet" xmlns="http://www.w3.org/2000/svg">${body}</svg>`;

let gid = 0;

/** Ink under two washes. */
function ground(w, h, tint, tint2, lift = 1, base = INK) {
  const a = `t${gid++}`;
  const b = `t${gid++}`;
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
    <ellipse cx="${w * 0.2}" cy="${h * 0.14}" rx="${w * 0.74}" ry="${h * 0.7}" fill="url(#${a})"/>
    <ellipse cx="${w * 0.88}" cy="${h * 0.9}" rx="${w * 0.68}" ry="${h * 0.64}" fill="url(#${b})"/>`;
}

/**
 * A seat: the roster mark.
 *
 * A rounded square with a notch out of the top, read as a chair from above.
 * Repeating it in a row is what makes these look like a team rather than a
 * system diagram, which is the whole difference between this page's set and
 * the React page's.
 */
function seat(x, y, s, c, filled) {
  return `
    <rect x="${x}" y="${y}" width="${s}" height="${s}" rx="${s * 0.26}"
      fill="${filled ? c : 'none'}" fill-opacity="${filled ? 0.22 : 0}"
      stroke="${c}" stroke-opacity="${filled ? 0.75 : 0.32}" stroke-width="2"/>
    <circle cx="${x + s / 2}" cy="${y + s * 0.34}" r="${s * 0.15}"
      fill="${c}" opacity="${filled ? 0.8 : 0.3}"/>`;
}

/** A row of seats, some taken. */
function bench(w, h, c, cols, taken) {
  const s = Math.min(w, h) * 0.13;
  const gap = s * 0.5;
  const total = cols * s + (cols - 1) * gap;
  const x0 = (w - total) / 2;
  const y = h * 0.5 - s / 2;

  let out = '';
  for (let i = 0; i < cols; i++) out += seat(x0 + i * (s + gap), y, s, c, i < taken);

  return out;
}

/** A stack of name plates. */
function plates(w, h, c, n) {
  let out = '';
  for (let i = 0; i < n; i++) {
    const pw = w * between(0.34, 0.6);
    const y = h * 0.24 + i * (h * 0.52 / n);
    out += `<rect x="${(w * 0.2).toFixed(1)}" y="${y.toFixed(1)}" width="${pw.toFixed(1)}"
      height="${(h * 0.055).toFixed(1)}" rx="5" fill="${c}"
      opacity="${(0.42 - i * 0.05).toFixed(2)}"/>`;
  }

  return out;
}

/** The signature rule under a heading. */
function rule(w, h, c) {
  return `<line x1="${w * 0.16}" y1="${h * 0.76}" x2="${w * 0.84}" y2="${h * 0.76}"
    stroke="${c}" stroke-opacity="0.5" stroke-width="2"/>
    <circle cx="${w * 0.16}" cy="${h * 0.76}" r="4" fill="${c}" opacity="0.8"/>`;
}

/** A loose scatter, for texture only. */
function motes(w, h, c, n) {
  let out = '';
  for (let i = 0; i < n; i++) {
    out += `<circle cx="${between(w * 0.08, w * 0.92).toFixed(1)}"
      cy="${between(w * 0.08, h * 0.92).toFixed(1)}" r="${between(1.5, 3.6).toFixed(1)}"
      fill="${c}" opacity="${between(0.2, 0.6).toFixed(2)}"/>`;
  }

  return out;
}

const mono = (x, y, t, c, size = 15, anchor = 'start') => `
  <text x="${x}" y="${y}" text-anchor="${anchor}" font-family="JetBrains Mono, monospace"
    font-size="${size}" letter-spacing="3.5" fill="${c}" fill-opacity="0.82">${t}</text>`;

/* --------------------------------------------------------------------------
 * The sets
 * ----------------------------------------------------------------------- */

const TINTS = [AMBER, CYAN, BLUE];

/** Ten role tiles — square, and lit, because they ride a 3D arc. */
function role(i) {
  const W = 600;
  const c = TINTS[i % 3];

  return svg(`0 0 ${W} ${W}`, `
    ${ground(W, W, c, TINTS[(i + 1) % 3], 2.1, '#151A22')}
    ${bench(W, W, c, 4, (i % 4) + 1)}
    ${motes(W, W, c, 14)}
    ${mono(W / 2, W - 46, String(i + 1).padStart(2, '0'), '#FFFFFF', 26, 'middle')}`);
}

/** Four for the circle-expand cards — portrait, since they open tall. */
function why(i) {
  const W = 800; const H = 1000;
  const c = TINTS[i % 3];

  return svg(`0 0 ${W} ${H}`, `
    ${ground(W, H, c, AMBER, 1.5)}
    ${bench(W, H, c, 5, i + 2)}
    ${plates(W, H, c, 3)}
    ${motes(W, H, c, 20)}
    ${mono(44, H - 40, String(i + 1).padStart(2, '0'), c, 22)}`);
}

/** Five grounds behind the glass stack — these sit UNDER text, so quiet. */
function proof(i) {
  const W = 1000; const H = 700;
  const c = TINTS[i % 3];

  return svg(`0 0 ${W} ${H}`, `
    ${ground(W, H, c, INK, 0.85)}
    ${bench(W, H, c, 6, 6 - i)}
    ${rule(W, H, c)}`);
}

/** Three hiring-model cards. */
function model(i) {
  const W = 800; const H = 600;
  const c = [AMBER, CYAN, BLUE][i];

  return svg(`0 0 ${W} ${H}`, `
    ${ground(W, H, c, TINTS[(i + 2) % 3], 1.3)}
    ${plates(W, H, c, 4 + i)}
    ${bench(W, H, c, 3 + i, 2)}
    ${mono(38, H - 30, String(i + 1).padStart(2, '0'), c, 20)}`);
}

function faq1() {
  const W = 800; const H = 600;

  return svg(`0 0 ${W} ${H}`, `
    ${ground(W, H, AMBER, CYAN)}
    ${bench(W, H, AMBER, 5, 3)}
    ${rule(W, H, CYAN)}
    ${mono(40, H - 32, 'ASK US', AMBER, 17)}`);
}

/* --------------------------------------------------------------------------
 * Render
 * ----------------------------------------------------------------------- */

const JOBS = [];
const add = (set, name, w, h, markup) => JOBS.push({ set, name, w, h, markup });

for (let i = 0; i < 10; i++) add('role', String(i + 1).padStart(2, '0'), 600, 600, role(i));
for (let i = 0; i < 4; i++) add('why', String(i + 1).padStart(2, '0'), 800, 1000, why(i));
for (let i = 0; i < 5; i++) add('proof', String(i + 1).padStart(2, '0'), 1000, 700, proof(i));
for (let i = 0; i < 3; i++) add('model', String(i + 1).padStart(2, '0'), 800, 600, model(i));
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

const tmp = path.join(here, '..', '.team-art.html');
fs.writeFileSync(tmp, html);

const browser = await chromium.launch({ channel: 'chrome' });
const p = await browser.newPage({ viewport: { width: 1400, height: 1100 } });
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
  console.log(`${(set + '/' + name).padEnd(14)} ${(fs.statSync(jpg).size / 1024).toFixed(0).padStart(4)}KB`);
}

await browser.close();
fs.unlinkSync(tmp);
console.log(`\n${n} pictures.`);
