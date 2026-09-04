/**
 * Every picture the Cloud & DevOps page uses.
 *
 *     node tools/cloud-art.mjs
 *
 * Ninth set, in the site's own palette — #00F2FE into #4EA8FF into #9D4EDD on
 * ink. The Dedicated Team page tried a colour of its own and stopped looking
 * like the same website, so what makes a set its own here is the MOTIF.
 *
 * This one is the ORBIT: concentric arcs with gates on them and a pulse part
 * way round. The page's whole argument is that cloud is not a setup you finish
 * but a circuit that keeps running — commit to production and round again — so
 * the shape is a loop that never closes on a final state, with the work always
 * somewhere on it.
 *
 * The eight earlier sets are a magazine, a blueprint, a component graph, a
 * roster of seats, a board of signal bars, an aperture, a stack of strata and a
 * strangler-fig lattice.
 *
 *   core/     1 for the middle of the hero's 3D orbit
 *   gain/     4 for what the practice buys you
 *   stage/    5 for the radial stage dial
 *   svc/      6 for the service cards
 *   step/     3 for the working process
 *   fit/      6 for why we are the better fit
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
const OUT  = path.join(here, '..', 'assets', 'img', 'cloud');

const CYAN = '#00F2FE';
const BLUE = '#4EA8FF';
const PURPLE = '#9D4EDD';
const INK = '#0B0F17';
const TINTS = [CYAN, BLUE, PURPLE];

let seed = 20260907;
const rnd = () => (seed = (seed * 1103515245 + 12345) & 0x7fffffff) / 0x7fffffff;
const between = (a, b) => a + rnd() * (b - a);

const svg = (vb, body) =>
  `<svg viewBox="${vb}" preserveAspectRatio="xMidYMid meet" xmlns="http://www.w3.org/2000/svg">${body}</svg>`;

let gid = 0;

function ground(w, h, tint, tint2, lift = 1, base = INK) {
  const a = `c${gid++}`; const b = `c${gid++}`;
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
    <ellipse cx="${w * 0.5}" cy="${h * 0.46}" rx="${w * 0.62}" ry="${h * 0.66}" fill="url(#${a})"/>
    <ellipse cx="${w * 0.12}" cy="${h * 0.9}" rx="${w * 0.6}" ry="${h * 0.58}" fill="url(#${b})"/>`;
}

/** A point on a circle, in SVG coordinates, measured clockwise from the top. */
const at = (cx, cy, r, turn) => {
  const a = (turn - 0.25) * Math.PI * 2;

  return [cx + r * Math.cos(a), cy + r * Math.sin(a)];
};

/** An arc from turn a to turn b on radius r. */
function arc(cx, cy, r, a, b, colour, opacity, width, dashed = false) {
  const [x0, y0] = at(cx, cy, r, a);
  const [x1, y1] = at(cx, cy, r, b);
  const large = (b - a) > 0.5 ? 1 : 0;

  return `<path d="M ${x0.toFixed(1)} ${y0.toFixed(1)} A ${r.toFixed(1)} ${r.toFixed(1)} 0 ${large} 1 ${x1.toFixed(1)} ${y1.toFixed(1)}"
    fill="none" stroke="${colour}" stroke-opacity="${opacity}" stroke-width="${width}"
    stroke-linecap="round" ${dashed ? 'stroke-dasharray="4 7"' : ''}/>`;
}

/**
 * The orbit.
 *
 * `rings` concentric tracks; `gates` markers spaced round the outermost; and
 * `pulse` where the work currently is, 0 to 1 round the loop. The track behind
 * the pulse is drawn lit and the track ahead of it dashed, so a still picture
 * still reads as something in motion rather than a diagram of a wheel.
 */
function orbit(w, h, c, rings, gates, pulse) {
  const cx = w / 2;
  const cy = h * 0.47;
  const r0 = Math.min(w, h) * 0.34;

  let out = '';

  for (let i = 0; i < rings; i++) {
    const r = r0 * (1 - i * 0.24);
    const o = 0.5 - i * 0.1;

    /* Behind the pulse: run. Ahead of it: still to come. */
    out += arc(cx, cy, r, 0, Math.max(0.02, pulse), c, o + 0.3, 2.2);
    out += arc(cx, cy, r, Math.max(0.02, pulse), 0.999, c, o * 0.55, 1.6, true);
  }

  /* Gates on the outer track. */
  for (let g = 0; g < gates; g++) {
    const t = g / gates;
    const [x, y] = at(cx, cy, r0, t);
    const done = t < pulse;
    out += `<rect x="${(x - 7).toFixed(1)}" y="${(y - 7).toFixed(1)}" width="14" height="14" rx="3"
      transform="rotate(${(t * 360).toFixed(1)} ${x.toFixed(1)} ${y.toFixed(1)})"
      fill="${done ? c : 'none'}" fill-opacity="${done ? 0.28 : 0}"
      stroke="${c}" stroke-opacity="${done ? 0.9 : 0.35}" stroke-width="2"/>`;
  }

  /* The pulse itself. */
  const [px, py] = at(cx, cy, r0, pulse);
  out += `<circle cx="${px.toFixed(1)}" cy="${py.toFixed(1)}" r="17" fill="none" stroke="${c}" stroke-opacity="0.4" stroke-width="1.6"/>`;
  out += `<circle cx="${px.toFixed(1)}" cy="${py.toFixed(1)}" r="7" fill="${c}" opacity="0.95"/>`;

  /* The core. */
  out += `<circle cx="${cx}" cy="${cy.toFixed(1)}" r="${(r0 * 0.16).toFixed(1)}" fill="none" stroke="${c}" stroke-opacity="0.55" stroke-width="1.8"/>`;
  out += `<circle cx="${cx}" cy="${cy.toFixed(1)}" r="${(r0 * 0.06).toFixed(1)}" fill="${c}" opacity="0.9"/>`;

  return out;
}

/** Spokes from the core out to the track — the paths a deploy takes. */
function spokes(w, h, c, n) {
  const cx = w / 2;
  const cy = h * 0.47;
  const r0 = Math.min(w, h) * 0.34;

  let out = '';
  for (let i = 0; i < n; i++) {
    const t = (i + 0.5) / n;
    const [x0, y0] = at(cx, cy, r0 * 0.2, t);
    const [x1, y1] = at(cx, cy, r0 * 0.94, t);
    out += `<line x1="${x0.toFixed(1)}" y1="${y0.toFixed(1)}" x2="${x1.toFixed(1)}" y2="${y1.toFixed(1)}"
      stroke="${c}" stroke-opacity="0.18" stroke-width="1.3" stroke-dasharray="2 6"/>`;
  }

  return out;
}

/** Loose motes, texture only. */
function motes(w, h, c, n) {
  let out = '';
  for (let i = 0; i < n; i++) {
    out += `<circle cx="${between(w * 0.05, w * 0.95).toFixed(1)}" cy="${between(h * 0.05, h * 0.95).toFixed(1)}"
      r="${between(1.2, 3).toFixed(1)}" fill="${c}" opacity="${between(0.16, 0.5).toFixed(2)}"/>`;
  }

  return out;
}

const mono = (x, y, t, c, size = 15, anchor = 'start') => `
  <text x="${x}" y="${y}" text-anchor="${anchor}" font-family="Azeret Mono, monospace"
    font-size="${size}" letter-spacing="3" fill="${c}" fill-opacity="0.85">${t}</text>`;

/* -------------------------------------------------------------------------- */

/** A card tile: the orbit caught at one point in its run. */
function tile(i, w, h, pulse, lift = 1.2, extra = '') {
  const c = TINTS[i % 3];

  return svg(`0 0 ${w} ${h}`, `
    ${ground(w, h, c, TINTS[(i + 1) % 3], lift, '#101822')}
    ${spokes(w, h, c, 8)}
    ${orbit(w, h, c, 3, 8, pulse)}
    ${extra}
    ${mono(32, h - 24, String(i + 1).padStart(2, '0'), c, 17)}`);
}

/** The core plate that sits at the middle of the hero's 3D orbit. */
function core() {
  const W = 620; const H = 620;

  return svg(`0 0 ${W} ${H}`, `
    ${ground(W, H, CYAN, PURPLE, 2.0, '#101a26')}
    ${spokes(W, H, CYAN, 12)}
    ${orbit(W, H, CYAN, 2, 12, 0.62)}
    ${motes(W, H, BLUE, 16)}`);
}

/* -------------------------------------------------------------------------- */

const JOBS = [];
const add = (set, name, w, h, markup) => JOBS.push({ set, name, w, h, markup });
const pad = (n) => String(n).padStart(2, '0');

add('core', '01', 620, 620, core());
for (let i = 0; i < 4; i++) add('gain',  pad(i + 1), 720, 520, tile(i, 720, 520, 0.3 + i * 0.16, 1.15));
for (let i = 0; i < 5; i++) add('stage', pad(i + 1), 760, 760, tile(i, 760, 760, (i + 1) / 5, 1.35, ''));
for (let i = 0; i < 6; i++) add('svc',   pad(i + 1), 820, 540, tile(i, 820, 540, 0.2 + (i % 5) * 0.16, 1.25));
for (let i = 0; i < 3; i++) add('step',  pad(i + 1), 860, 540, tile(i, 860, 540, 0.25 + i * 0.3, 1.3));
for (let i = 0; i < 6; i++) add('fit',   pad(i + 1), 760, 480, tile(i, 760, 480, 0.45 + (i % 4) * 0.14, 1.15));
add('hero', '01', 1800, 1000, tile(1, 1800, 1000, 0.58, 1.9, motes(1800, 1000, BLUE, 30)));
add('faq',  '01', 800, 620, tile(2, 800, 620, 0.74, 1.2));

const boxes = JOBS.map((j) => `
  <div id="art-${j.set}-${j.name}" style="width:${j.w}px;height:${j.h}px;overflow:hidden">${j.markup}</div>`).join('\n');

const html = `<!doctype html><meta charset="utf-8">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Azeret+Mono:wght@400;600;700&display=swap">
<style>body{margin:0;background:${INK}} svg{display:block;width:100%;height:100%}</style>
${boxes}
<script>window.__ids = ${JSON.stringify(JOBS.map((j) => `art-${j.set}-${j.name}`))};</script>`;

const tmp = path.join(here, '..', '.cloud-art.html');
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
