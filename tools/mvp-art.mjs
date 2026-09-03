/**
 * Every picture the MVP Development page uses.
 *
 *     node tools/mvp-art.mjs
 *
 * All of it in the SITE's palette — ink #0B0F17 under the cyan #00F2FE through
 * #4EA8FF into violet #9D4EDD ramp that style.css defines and every other page
 * already wears. An earlier pass gave this page an amber-and-lime theme of its
 * own; it read as a different site rather than a different page, so the palette
 * is the shared one and only the layout is this page's.
 *
 *   playbook/   8 portrait pages for the 3D magazine in the hero
 *   intro/      1 wide band under the opening statement
 *   why/        5 landscape motifs for the card showcase
 *   advantage/  5 for the MVP-first advantages
 *   inside/     5 grounds that sit BEHIND the glass panels' own text
 *   industry/   8 squares for the curved gallery arc
 *   step/       6 for the process stepper's cards
 *   reason/     6 heads for the "why us" grid
 *   faq/        1 beside the accordion
 *
 * One generator rather than nine, because they share a ground, a grid and a
 * type ramp — that shared chrome is what makes them read as one page.
 */
import { chromium } from 'file:///C:/Users/aakas/AppData/Roaming/npm/node_modules/playwright/index.mjs';
import { fileURLToPath } from 'node:url';
import { execFileSync } from 'node:child_process';
import path from 'node:path';
import fs from 'node:fs';

const FFMPEG = 'C:/Users/aakas/Downloads/Central Adventure/repo/node_modules/ffmpeg-static/ffmpeg.exe';

const here = path.dirname(fileURLToPath(import.meta.url));
const OUT  = path.join(here, '..', 'assets', 'img', 'mvp');

/* style.css's own values, not near-misses. */
const CYAN   = '#00F2FE';
const BLUE   = '#4EA8FF';
const PURPLE = '#9D4EDD';
const INK    = '#0B0F17';
const TEXT   = '#EAF0FA';

/* Seeded, so re-running the generator produces the same files and the diff
   stays empty when nothing about the art has changed. */
let seed = 20260904;
const rnd = () => (seed = (seed * 1103515245 + 12345) & 0x7fffffff) / 0x7fffffff;

const svg = (vb, body) => `<svg viewBox="${vb}" preserveAspectRatio="xMidYMid meet">${body}</svg>`;

/* ---- the magazine: The MVP Playbook ------------------------------------- */

const PLAYBOOK = [
  { kind: 'cover' },
  { kind: 'page', n: '01', wk: 'WEEK 0', t: 'One metric,\nagreed in writing',
    b: 'Before anything is scoped we agree the single number that decides whether this MVP worked. Not "engagement" — a number with a threshold and a date.',
    note: 'If nobody will put a threshold on it, it is not the metric.' },
  { kind: 'page', n: '02', wk: 'WEEKS 1–2', t: 'Scope, negotiated\ndown',
    b: 'Your list has forty things on it. Six of them can move the metric. The other thirty-four go on a roadmap you can still see, and we start.',
    note: 'The hardest fortnight of the build, and the cheapest.' },
  { kind: 'page', n: '03', wk: 'WEEKS 3–8', t: 'The core loop,\nend to end',
    b: 'One complete journey a real person can finish: sign in, do the thing, get the result, come back tomorrow. Every sprint ends with something installable.',
    note: 'A demo that only works on the demo path is not an MVP.' },
  { kind: 'page', n: '04', wk: 'WEEKS 9–10', t: 'Production hygiene,\nnot polish',
    b: 'Auth, roles, backups, error tracking, rate limits and an admin screen. The unglamorous half that decides whether the MVP survives its first hundred users.',
    note: 'Skipping this is what turns an MVP into a rewrite.' },
  { kind: 'page', n: '05', wk: 'WEEKS 11–12', t: 'Real users,\nnot a demo day',
    b: 'We ship to a real cohort, instrument the loop, and watch the metric for two weeks. You get the numbers, not an opinion about the numbers.',
    note: 'The first honest signal you have had about this idea.' },
  { kind: 'page', n: '06', wk: 'DAY ONE', t: 'You own\nall of it',
    b: 'The repository, the cloud accounts, the domain, the signing keys and the Figma files transfer into your name — with commit history, not as a zip.',
    note: 'Including the right to take it to another team.' },
  { kind: 'back' },
];

function playbookPage(p) {
  if (p.kind === 'cover') {
    return `<div class="pg cover"><div class="grain"></div><div class="rule"></div>
      <p class="issue">ITHRIVE SOFTWARE · MVP PRACTICE</p>
      <h1>THE<br>MVP<br>PLAY<span class="cy">BOOK</span></h1>
      <p class="sub">Twelve weeks from an idea to a number you can trust.</p>
      <div class="coverfoot"><span>CHENNAI · BANGALORE · COIMBATORE</span><span class="pu">EDITION 04</span></div>
    </div>`;
  }
  if (p.kind === 'back') {
    return `<div class="pg back"><div class="grain"></div>
      <p class="issue">THE LAST PAGE</p>
      <h2 class="bigq">Build only<br>what can be<br><span class="cy">wrong in public.</span></h2>
      <p class="sub">Everything else is a roadmap item pretending to be a requirement.</p>
      <div class="coverfoot"><span>ithrivesoftware.com</span><span class="cy">START YOUR MVP</span></div>
    </div>`;
  }

  return `<div class="pg"><div class="grain"></div>
    <div class="pghead"><span class="wk">${p.wk}</span><span class="pn">${p.n}</span></div>
    <h2>${p.t.replace(/\n/g, '<br>')}</h2>
    <p class="body">${p.b}</p>
    <div class="note"><span class="dot"></span>${p.note}</div>
    <div class="pgfoot">THE MVP PLAYBOOK · iTHRIVE SOFTWARE</div>
  </div>`;
}

/* ---- motifs -------------------------------------------------------------- */

/** Why an MVP wins — the card showcase. Abstract: the component prints the words. */
function whyArt(i, tint) {
  const g = [];
  if (i === 0) {                       // evidence: a scatter settling on a trend
    for (let k = 0; k < 44; k++) {
      const x = 560 + k * 14;
      const y = 600 - k * 8.6 + (rnd() - 0.5) * 150;
      g.push(`<circle cx="${x}" cy="${y.toFixed(0)}" r="7" fill="${tint}" opacity="${(0.25 + rnd() * 0.6).toFixed(2)}"/>`);
    }
    g.push(`<path d="M560 600 L1170 220" stroke="${tint}" stroke-width="5" opacity=".9"/>`);
  } else if (i === 1) {                // burn: one tall bar against one short
    g.push(`<rect x="660" y="140" width="170" height="540" rx="12" fill="${tint}" opacity=".16"/>`);
    g.push(`<rect x="660" y="140" width="170" height="540" rx="12" fill="none" stroke="${tint}" stroke-width="3"/>`);
    g.push(`<rect x="900" y="626" width="170" height="54" rx="12" fill="${tint}" opacity=".95"/>`);
    g.push(`<path d="M660 700 H 1070" stroke="rgba(255,255,255,.16)" stroke-width="2"/>`);
  } else if (i === 2) {                // traction: a curve through a grid
    let d = 'M600 650';
    for (let k = 1; k <= 24; k++) d += ` L${600 + k * 24} ${(650 - Math.pow(k, 1.72) * 1.45).toFixed(0)}`;
    for (let k = 0; k < 6; k++) g.push(`<path d="M600 ${180 + k * 96} H 1180" stroke="rgba(255,255,255,.08)" stroke-width="2"/>`);
    g.push(`<path d="${d}" fill="none" stroke="${tint}" stroke-width="6" opacity=".95"/>`);
  } else if (i === 3) {                // architecture: nested frames that hold
    for (let k = 0; k < 5; k++) {
      const s = k * 54;
      g.push(`<rect x="${640 + s}" y="${160 + s}" width="${500 - s * 2}" height="${490 - s * 2}" rx="16"
        fill="none" stroke="${tint}" stroke-width="${k === 0 ? 4 : 2}" opacity="${(0.9 - k * 0.15).toFixed(2)}"/>`);
    }
  } else {                             // stop condition: a run that ends at a bar
    g.push(`<path d="M580 400 H 1030" stroke="${tint}" stroke-width="5" opacity=".9"/>`);
    g.push(`<rect x="1052" y="240" width="18" height="320" rx="9" fill="${tint}"/>`);
    for (let k = 0; k < 8; k++) g.push(`<circle cx="${620 + k * 56}" cy="400" r="10" fill="${tint}" opacity=".5"/>`);
  }

  return svg('0 0 1200 800', g.join(''));
}

/** The five advantages of building MVP-first. */
const ADVANTAGE = [
  ['01', 'Build What Users Actually Need',
   'Features are chosen from observed behaviour rather than from the loudest opinion in the room. The cohort decides what stays.',
   CYAN, 'need'],
  ['02', 'Reduce Development Costs by 60%',
   'Six features instead of forty, and no rebuild of work that was never wanted. The saving comes from what does not get built.',
   BLUE, 'cost'],
  ['03', 'Speed to Market With Real Insights',
   'Live in twelve weeks, instrumented from day one, so the second release is aimed by data instead of by another workshop.',
   PURPLE, 'speed'],
  ['04', 'Agile Product Development',
   'Two-week sprints against real data, with an installable build every Friday. Slippage shows up in week four, not month seven.',
   CYAN, 'agile'],
  ['05', 'Validate Your Hypothesis Quickly and Cheaply',
   'One number, one threshold, one date. If it does not move you stop — twelve weeks in rather than two years and a full budget.',
   BLUE, 'validate'],
];

function advantageArt(kind, tint) {
  const g = [];
  if (kind === 'need') {               // a funnel of many wants to a few builds
    for (let k = 0; k < 14; k++) {
      const y = 120 + k * 34;
      const w = 300 - Math.abs(k - 6.5) * 12;
      g.push(`<rect x="${(600 - w / 2).toFixed(0)}" y="${y}" width="${w.toFixed(0)}" height="18" rx="9"
        fill="${tint}" opacity="${k > 4 && k < 10 ? 0.9 : 0.16}"/>`);
    }
    g.push(`<path d="M470 596 L600 700 L730 596" fill="none" stroke="${tint}" stroke-width="4" opacity=".8"/>`);
    g.push(`<text x="600" y="770" text-anchor="middle" class="lab">SIX THAT MOVE THE NUMBER</text>`);
  } else if (kind === 'cost') {        // two stacks: what a full build spends vs an MVP
    for (let k = 0; k < 10; k++) {
      g.push(`<rect x="330" y="${640 - k * 52}" width="200" height="40" rx="8" fill="${tint}" opacity=".16"/>`);
      g.push(`<rect x="330" y="${640 - k * 52}" width="200" height="40" rx="8" fill="none" stroke="${tint}" stroke-width="1.6" opacity=".5"/>`);
    }
    for (let k = 0; k < 4; k++) {
      g.push(`<rect x="670" y="${640 - k * 52}" width="200" height="40" rx="8" fill="${tint}" opacity=".92"/>`);
    }
    g.push(`<text x="430" y="712" text-anchor="middle" class="lab">FULL BUILD</text>`);
    g.push(`<text x="770" y="712" text-anchor="middle" class="lab">MVP · 60% LESS</text>`);
  } else if (kind === 'speed') {       // a short runway against a long one
    g.push(`<path d="M180 470 H 1020" stroke="rgba(255,255,255,.14)" stroke-width="3"/>`);
    g.push(`<path d="M180 470 H 520" stroke="${tint}" stroke-width="10" stroke-linecap="round"/>`);
    for (let k = 0; k <= 8; k++) {
      g.push(`<path d="M${180 + k * 105} 452 v 36" stroke="rgba(255,255,255,.2)" stroke-width="2"/>`);
      g.push(`<text x="${180 + k * 105}" y="530" text-anchor="middle" class="lab">${k * 3}</text>`);
    }
    g.push(`<circle cx="520" cy="470" r="17" fill="${tint}"/>`);
    g.push(`<text x="520" y="410" text-anchor="middle" class="lab">LIVE · WEEK 12</text>`);
    g.push(`<text x="600" y="600" text-anchor="middle" class="lab">MONTHS</text>`);
  } else if (kind === 'agile') {       // sprints, each ending in a build
    for (let k = 0; k < 6; k++) {
      const x = 150 + k * 155;
      g.push(`<rect x="${x}" y="380" width="120" height="120" rx="16" fill="${tint}" opacity="${(0.14 + k * 0.14).toFixed(2)}"/>`);
      g.push(`<rect x="${x}" y="380" width="120" height="120" rx="16" fill="none" stroke="${tint}" stroke-width="2"/>`);
      g.push(`<circle cx="${x + 60}" cy="560" r="9" fill="${tint}"/>`);
      if (k < 5) g.push(`<path d="M${x + 126} 440 h 22" stroke="${tint}" stroke-width="3" opacity=".7"/>`);
    }
    g.push(`<path d="M210 560 H 990" stroke="${tint}" stroke-width="2" opacity=".4"/>`);
    g.push(`<text x="600" y="640" text-anchor="middle" class="lab">A BUILD AT THE END OF EVERY SPRINT</text>`);
  } else {                             // validate: one threshold, pass or stop
    g.push(`<path d="M170 430 H 1030" stroke="${tint}" stroke-width="3" stroke-dasharray="10 10" opacity=".8"/>`);
    g.push(`<text x="170" y="404" class="lab">THRESHOLD</text>`);
    let d = 'M200 640';
    for (let k = 1; k <= 20; k++) {
      const x = 200 + k * 41;
      const y = 640 - k * 13 + (rnd() - 0.5) * 40;
      d += ` L${x} ${y.toFixed(0)}`;
    }
    g.push(`<path d="${d}" fill="none" stroke="${tint}" stroke-width="5"/>`);
    g.push(`<circle cx="1020" cy="392" r="16" fill="${tint}"/>`);
    g.push(`<text x="600" y="716" text-anchor="middle" class="lab">TWELVE WEEKS TO THE ANSWER</text>`);
  }

  return svg('0 0 1200 800', g.join(''));
}

/** The six process steps. */
const STEPS = [
  ['01', 'Start With Clear Goals', 'goals', CYAN],
  ['02', 'Identify the Essential Features', 'features', BLUE],
  ['03', 'Create the Basic Screens & Flow', 'flow', PURPLE],
  ['04', 'Build the Working MVP', 'build', CYAN],
  ['05', 'Test & Launch', 'launch', BLUE],
  ['06', 'Review & Iterate Next Steps', 'iterate', PURPLE],
];

function stepArt(kind, tint) {
  const g = [];
  if (kind === 'goals') {              // a target with one ring lit
    for (let k = 4; k >= 0; k--) {
      g.push(`<circle cx="600" cy="400" r="${70 + k * 62}" fill="none" stroke="${tint}"
        stroke-width="${k === 0 ? 5 : 2}" opacity="${(0.9 - k * 0.16).toFixed(2)}"/>`);
    }
    g.push(`<circle cx="600" cy="400" r="22" fill="${tint}"/>`);
    g.push(`<path d="M240 700 L590 412" stroke="${tint}" stroke-width="3" opacity=".55"/>`);
  } else if (kind === 'features') {     // a long list, six selected
    for (let k = 0; k < 16; k++) {
      const x = 340 + (k % 2) * 280;
      const y = 150 + Math.floor(k / 2) * 62;
      const on = [0, 1, 4, 5, 8, 11].includes(k);
      g.push(`<rect x="${x}" y="${y}" width="250" height="44" rx="10"
        fill="${on ? tint : 'rgba(255,255,255,.04)'}" opacity="${on ? 0.9 : 1}"
        stroke="${on ? tint : 'rgba(255,255,255,.14)'}" stroke-width="2"/>`);
    }
  } else if (kind === 'flow') {         // wireframe screens joined by arrows
    for (let k = 0; k < 3; k++) {
      const x = 190 + k * 300;
      g.push(`<rect x="${x}" y="250" width="200" height="310" rx="18" fill="rgba(255,255,255,.04)"
        stroke="${tint}" stroke-width="2.5"/>`);
      g.push(`<rect x="${x + 22}" y="286" width="120" height="14" rx="7" fill="${tint}" opacity=".8"/>`);
      for (let r = 0; r < 4; r++) g.push(`<rect x="${x + 22}" y="${324 + r * 30}" width="${156 - r * 22}" height="10" rx="5" fill="rgba(255,255,255,.22)"/>`);
      g.push(`<rect x="${x + 22}" y="482" width="100" height="34" rx="17" fill="${tint}" opacity=".9"/>`);
      if (k < 2) g.push(`<path d="M${x + 208} 405 h 76" stroke="${tint}" stroke-width="3" opacity=".8"/>`);
    }
  } else if (kind === 'build') {        // a stack assembling
    for (let k = 0; k < 6; k++) {
      g.push(`<rect x="${300 + k * 12}" y="${600 - k * 78}" width="600" height="62" rx="12"
        fill="${tint}" opacity="${(0.14 + k * 0.13).toFixed(2)}"
        stroke="${tint}" stroke-width="1.6"/>`);
    }
  } else if (kind === 'launch') {       // a checked release going out
    g.push(`<rect x="300" y="220" width="600" height="360" rx="22" fill="rgba(255,255,255,.04)" stroke="${tint}" stroke-width="2.5"/>`);
    for (let k = 0; k < 4; k++) {
      g.push(`<circle cx="360" cy="${290 + k * 74}" r="16" fill="none" stroke="${tint}" stroke-width="3"/>`);
      g.push(`<path d="M351 ${290 + k * 74} l7 8 12 -15" stroke="${tint}" stroke-width="3" fill="none"/>`);
      g.push(`<rect x="400" y="${281 + k * 74}" width="${420 - k * 60}" height="16" rx="8" fill="rgba(255,255,255,.2)"/>`);
    }
    g.push(`<path d="M900 400 h 160" stroke="${tint}" stroke-width="4"/>`);
    g.push(`<path d="M1030 380 l30 20 -30 20 z" fill="${tint}"/>`);
  } else {                              // iterate: a loop that comes back round
    g.push(`<path d="M600 200 A 200 200 0 1 1 400 400" fill="none" stroke="${tint}" stroke-width="6" stroke-linecap="round"/>`);
    g.push(`<path d="M372 356 l28 46 -56 0 z" fill="${tint}"/>`);
    for (let k = 0; k < 6; k++) {
      const a = (Math.PI * 2 * k) / 6 - Math.PI / 2;
      g.push(`<circle cx="${(600 + Math.cos(a) * 200).toFixed(0)}" cy="${(400 + Math.sin(a) * 200).toFixed(0)}" r="13" fill="${tint}" opacity="${(0.35 + k * 0.11).toFixed(2)}"/>`);
    }
    g.push(`<circle cx="600" cy="400" r="54" fill="none" stroke="${tint}" stroke-width="2" opacity=".5"/>`);
  }

  return svg('0 0 1200 800', g.join(''));
}

/* Faint circuitry for the glass panels' grounds — these sit UNDER the panel's
   own title and body, so they have to stay well below reading contrast. */
function insideArt(tint) {
  const lines = [];
  for (let i = 0; i < 16; i++) {
    const y = 40 + i * 48;
    const x1 = rnd() * 500;
    const x2 = x1 + 180 + rnd() * 560;
    lines.push(`<path d="M${x1.toFixed(0)} ${y} H ${x2.toFixed(0)}" stroke="${tint}"
      stroke-width="${rnd() > 0.8 ? 2 : 1}" opacity="${(0.05 + rnd() * 0.14).toFixed(2)}"/>`);
    if (rnd() > 0.7) lines.push(`<circle cx="${x2.toFixed(0)}" cy="${y}" r="4" fill="${tint}" opacity=".3"/>`);
  }

  return svg('0 0 1200 800', lines.join(''));
}

const INSIDE = [
  ['The core loop', CYAN], ['Auth, roles, billing', BLUE], ['One real integration', PURPLE],
  ['Instrumentation', CYAN], ['The admin screen', BLUE],
];

const INDUSTRY = [
  ['FINTECH', 'KYC, ledgers, reconciliation', CYAN],
  ['HEALTHTECH', 'Triage, records, consent', BLUE],
  ['LOGISTICS', 'Dispatch, tracking, proof', PURPLE],
  ['RETAIL', 'Catalogue, checkout, returns', CYAN],
  ['EDTECH', 'Cohorts, progress, assessment', BLUE],
  ['PROPTECH', 'Listings, tours, agreements', PURPLE],
  ['MANUFACTURING', 'Line data, quality, downtime', CYAN],
  ['MEDIA', 'Ingest, rights, distribution', BLUE],
];

const REASONS = [
  ['01', 'scope', CYAN], ['02', 'senior', BLUE], ['03', 'friday', PURPLE],
  ['04', 'own', CYAN], ['05', 'survive', BLUE], ['06', 'warranty', PURPLE],
];

function reasonArt(kind, tint) {
  const g = [];
  const at = (x, y, r, o) => `<circle cx="${x}" cy="${y}" r="${r}" fill="${tint}" opacity="${o}"/>`;
  if (kind === 'scope')      { for (let k = 0; k < 9; k++) g.push(`<rect x="60" y="${40 + k * 46}" width="${420 - k * 34}" height="26" rx="13" fill="${tint}" opacity="${k < 3 ? 0.9 : 0.16}"/>`); }
  else if (kind === 'senior'){ for (let k = 0; k < 4; k++) { g.push(at(100 + k * 120, 200, 46, k < 4 ? 0.85 : 0.2)); g.push(`<rect x="${64 + k * 120}" y="262" width="72" height="86" rx="36" fill="${tint}" opacity=".55"/>`); } }
  else if (kind === 'friday'){ for (let k = 0; k < 5; k++) { g.push(`<rect x="${60 + k * 106}" y="150" width="82" height="140" rx="12" fill="none" stroke="${tint}" stroke-width="2.5" opacity=".8"/>`); g.push(at(101 + k * 106, 330, 12, 0.9)); } g.push(`<path d="M101 330 H 525" stroke="${tint}" stroke-width="2" opacity=".5"/>`); }
  else if (kind === 'own')   { g.push(`<rect x="120" y="90" width="360" height="260" rx="20" fill="none" stroke="${tint}" stroke-width="3"/>`); g.push(`<path d="M200 220 l50 52 110 -122" stroke="${tint}" stroke-width="7" fill="none" stroke-linecap="round"/>`); }
  else if (kind === 'survive'){ for (let k = 0; k < 5; k++) g.push(`<rect x="${90 + k * 18}" y="${300 - k * 52}" width="330" height="44" rx="10" fill="${tint}" opacity="${(0.16 + k * 0.16).toFixed(2)}" stroke="${tint}" stroke-width="1.4"/>`); }
  else                       { g.push(`<path d="M300 70 l150 62 v110 c0 92 -66 152 -150 176 -84 -24 -150 -84 -150 -176 V132 z" fill="${tint}" opacity=".14" stroke="${tint}" stroke-width="3"/>`); g.push(`<text x="300" y="250" text-anchor="middle" class="big">90</text>`); }

  return svg('0 0 600 420', g.join(''));
}

/* ---- the page --------------------------------------------------------------- */

const css = `
  * { box-sizing:border-box; margin:0 }
  body { background:#05070C; font-family:'Space Grotesk','Outfit',system-ui,sans-serif; padding:20px;
         display:flex; flex-wrap:wrap; gap:20px; width:2100px; color:${TEXT} }
  .shot { position:relative; overflow:hidden; background:${INK} }
  .grain { position:absolute; inset:0; pointer-events:none;
    background-image:
      linear-gradient(rgba(255,255,255,.032) 1px, transparent 1px),
      linear-gradient(90deg, rgba(255,255,255,.032) 1px, transparent 1px);
    background-size: 46px 46px;
    mask-image: radial-gradient(120% 100% at 50% 30%, #000 0%, transparent 84%) }
  .cy { color:${CYAN} } .bl { color:${BLUE} } .pu { color:${PURPLE} }
  .lab { font-family:'JetBrains Mono',monospace; font-size:19px; fill:rgba(234,240,250,.5); letter-spacing:.12em }
  .big { font-family:'Outfit',sans-serif; font-size:104px; font-weight:800; fill:${CYAN} }

  /* magazine pages 900x1200 */
  .pg { position:relative; width:900px; height:1200px; padding:78px 74px; overflow:hidden;
        background:
          radial-gradient(90% 70% at 10% 4%, rgba(0,242,254,.16) 0%, transparent 60%),
          radial-gradient(80% 60% at 94% 98%, rgba(157,78,221,.20) 0%, transparent 62%),
          linear-gradient(165deg,#111A28 0%,${INK} 58%,#131B2A 100%);
        display:flex; flex-direction:column }
  .pg h2 { font-size:74px; font-weight:800; line-height:1.02; letter-spacing:-.03em; margin:34px 0 30px }
  .pg .body { font-family:'Inter',sans-serif; font-size:26px; line-height:1.55; color:rgba(234,240,250,.7); max-width:660px }
  .pghead { display:flex; justify-content:space-between; align-items:baseline; border-top:2px solid ${CYAN}; padding-top:20px }
  .wk { font-family:'JetBrains Mono',monospace; font-size:20px; letter-spacing:.22em; color:${CYAN} }
  .pn { font-size:92px; font-weight:800; line-height:.8; color:rgba(234,240,250,.10) }
  .note { margin-top:auto; display:flex; align-items:flex-start; gap:14px; padding-top:26px;
          border-top:1px solid rgba(255,255,255,.12); font-family:'Inter',sans-serif;
          font-size:21px; line-height:1.5; color:${CYAN} }
  .note .dot { flex:none; width:11px; height:11px; margin-top:9px; border-radius:50%; background:${CYAN} }
  .pgfoot { margin-top:22px; font-family:'JetBrains Mono',monospace; font-size:15px; letter-spacing:.2em; color:rgba(234,240,250,.3) }
  .cover { justify-content:flex-end }
  .cover .rule { position:absolute; left:74px; right:74px; top:210px; height:3px;
                 background:linear-gradient(90deg,${CYAN},${BLUE} 45%,${PURPLE}) }
  .issue { position:absolute; top:78px; left:74px; font-family:'JetBrains Mono',monospace;
           font-size:19px; letter-spacing:.26em; color:rgba(234,240,250,.55) }
  .cover h1 { font-size:152px; font-weight:800; line-height:.86; letter-spacing:-.05em; margin-bottom:34px }
  .sub { font-family:'Inter',sans-serif; font-size:28px; line-height:1.4; color:rgba(234,240,250,.7); max-width:600px }
  .coverfoot { display:flex; justify-content:space-between; margin-top:56px; padding-top:24px;
               border-top:1px solid rgba(255,255,255,.14); font-family:'JetBrains Mono',monospace;
               font-size:17px; letter-spacing:.16em; color:rgba(234,240,250,.5) }
  .back { justify-content:center }
  .bigq { font-size:86px; font-weight:800; line-height:1.02; letter-spacing:-.035em; margin-bottom:30px }

  /* landscape motifs 1200x800 */
  .m { position:relative; width:1200px; height:800px; overflow:hidden;
       background:radial-gradient(80% 90% at 84% 8%, var(--wash) 0%, transparent 60%),
                  linear-gradient(150deg,#101825 0%,${INK} 64%,#121A29 100%) }
  .m svg { position:absolute; inset:0; width:100%; height:100% }
  .m .n { position:absolute; left:70px; bottom:56px; font-size:200px; font-weight:800; line-height:.8;
          letter-spacing:-.06em; color:transparent; -webkit-text-stroke:2px rgba(234,240,250,.18) }

  /* 4:3 advantage cards 1200x900 */
  .adv { position:relative; width:1200px; height:800px; overflow:hidden; padding:52px 70px;
         display:flex; flex-direction:column;
         background:radial-gradient(80% 70% at 88% 6%, var(--wash) 0%, transparent 58%),
                    linear-gradient(150deg,#101825 0%,${INK} 62%,#121A29 100%) }
  .adv .idx { font-family:'JetBrains Mono',monospace; font-size:22px; letter-spacing:.24em; color:var(--tint) }
  .adv .art { position:relative; flex:1; margin-top:8px }
  .adv .art svg { position:absolute; inset:0; width:100%; height:100% }

  /* inside grounds */
  .ins { position:relative; width:1200px; height:800px; overflow:hidden;
         background:linear-gradient(150deg,#0F1622 0%,#070A11 70%) }
  .ins .glow { position:absolute; width:900px; height:900px; border-radius:50%; filter:blur(110px); opacity:.22 }
  .ins svg { position:absolute; inset:0; width:100%; height:100% }

  /* industry squares 900x900 — centred, wide safe margin: the arc crops these */
  .ind { position:relative; width:900px; height:900px; padding:140px 120px; overflow:hidden;
         display:flex; flex-direction:column; align-items:center; justify-content:center; text-align:center;
         background:radial-gradient(70% 60% at 78% 14%, var(--wash) 0%, transparent 62%),
                    linear-gradient(155deg,#111926 0%,#070A11 68%) }
  .ind h3 { font-family:'JetBrains Mono',monospace; font-size:42px; letter-spacing:.08em; margin-bottom:20px; color:var(--tint) }
  .ind p { font-family:'Inter',sans-serif; font-size:26px; line-height:1.45; color:rgba(234,240,250,.66) }
  .ind .idx { margin-bottom:26px; font-family:'JetBrains Mono',monospace; font-size:22px;
              letter-spacing:.24em; color:rgba(234,240,250,.4) }

  /* reason heads 600x420 */
  .rea { position:relative; width:600px; height:420px; overflow:hidden;
         background:radial-gradient(70% 80% at 76% 10%, var(--wash) 0%, transparent 62%),
                    linear-gradient(150deg,#111926 0%,#080B13 68%) }
  .rea svg { position:absolute; inset:0; width:100%; height:100% }

  /* wide bands 1680x640 */
  .band { position:relative; width:1680px; height:640px; overflow:hidden; padding:72px 90px;
          display:flex; flex-direction:column; justify-content:center;
          background:radial-gradient(70% 90% at 10% 8%, rgba(0,242,254,.16) 0%, transparent 58%),
                     radial-gradient(60% 80% at 92% 94%, rgba(157,78,221,.18) 0%, transparent 60%),
                     linear-gradient(150deg,#101825 0%,${INK} 62%,#121A29 100%) }
  .band h3 { font-size:58px; font-weight:800; letter-spacing:-.03em; line-height:1.06; max-width:900px }
  .band p { margin-top:20px; font-family:'Inter',sans-serif; font-size:26px; line-height:1.5;
            color:rgba(234,240,250,.68); max-width:840px }
  .band svg { position:absolute; right:-40px; top:0; width:760px; height:100% }
`;

const html = `<!doctype html><meta charset="utf-8"><title>MVP art</title>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;600;700&family=Space+Grotesk:wght@500;600;700&family=Outfit:wght@700;800;900&display=swap" rel="stylesheet">
<style>${css}</style>
<body>

${PLAYBOOK.map((p, i) => `<div class="shot" id="s-playbook-${String(i + 1).padStart(2, '0')}">${playbookPage(p)}</div>`).join('')}

<div class="shot" id="s-intro-01">
  <div class="band">
    <div class="grain"></div>
    ${(() => {
      const g = [];
      for (let k = 0; k < 22; k++) {
        const x = 90 + k * 30;
        const h = 40 + rnd() * 300;
        g.push(`<rect x="${x}" y="${(560 - h).toFixed(0)}" width="15" height="${h.toFixed(0)}" rx="7"
          fill="${k < 8 ? CYAN : k < 15 ? BLUE : PURPLE}" opacity="${(0.25 + k * 0.032).toFixed(2)}"/>`);
      }
      g.push(`<path d="M90 560 H 760" stroke="rgba(255,255,255,.18)" stroke-width="2"/>`);

      return svg('0 0 800 640', g.join(''));
    })()}
    <h3>Twelve weeks from an idea to a number<br>you can actually trust.</h3>
    <p>One metric, six features, a real cohort — and three honest outcomes at the end of it.</p>
  </div>
</div>

${['Evidence over opinion', 'A tenth of the burn', 'Traction raises rounds', 'The architecture survives', 'A real stop condition']
  .map((_, i) => {
    const tint = [CYAN, BLUE, PURPLE, CYAN, BLUE][i];

    return `<div class="shot" id="s-why-0${i + 1}">
      <div class="m" style="--wash:${tint}33">
        <div class="grain"></div>${whyArt(i, tint)}
        <span class="n">0${i + 1}</span>
      </div></div>`;
  }).join('')}

${ADVANTAGE.map(([n, , , tint, kind]) => `
<div class="shot" id="s-advantage-${n}">
  <div class="adv" style="--wash:${tint}30; --tint:${tint}">
    <div class="grain"></div>
    <span class="idx">ADVANTAGE ${n}</span>
    <div class="art">${advantageArt(kind, tint)}</div>
  </div>
</div>`).join('')}

${INSIDE.map(([, tint], i) => `
<div class="shot" id="s-inside-0${i + 1}">
  <div class="ins">
    <div class="glow" style="background:${tint}; left:${-200 + i * 90}px; top:${-160 + i * 40}px"></div>
    ${insideArt(tint)}<div class="grain"></div>
  </div>
</div>`).join('')}

${INDUSTRY.map(([t, b, tint], i) => `
<div class="shot" id="s-industry-0${i + 1}">
  <div class="ind" style="--wash:${tint}30; --tint:${tint}">
    <div class="grain"></div>
    <span class="idx">${String(i + 1).padStart(2, '0')} / 08</span>
    <h3>${t}</h3><p>${b}</p>
  </div>
</div>`).join('')}

${STEPS.map(([n, , kind, tint]) => `
<div class="shot" id="s-step-${n}">
  <div class="m" style="--wash:${tint}33">
    <div class="grain"></div>${stepArt(kind, tint)}
    <span class="n">${n}</span>
  </div>
</div>`).join('')}

${REASONS.map(([n, kind, tint]) => `
<div class="shot" id="s-reason-${n}">
  <div class="rea" style="--wash:${tint}30">
    <div class="grain"></div>${reasonArt(kind, tint)}
  </div>
</div>`).join('')}

<div class="shot" id="s-faq-01">
  <div class="m" style="--wash:${PURPLE}33">
    <div class="grain"></div>
    ${(() => {
      const g = [];
      for (let k = 0; k < 6; k++) {
        const y = 130 + k * 100;
        g.push(`<rect x="200" y="${y}" width="800" height="72" rx="14" fill="rgba(255,255,255,.04)"
          stroke="${k === 2 ? CYAN : 'rgba(255,255,255,.14)'}" stroke-width="${k === 2 ? 3 : 2}"/>`);
        g.push(`<rect x="240" y="${y + 28}" width="${420 - k * 40}" height="16" rx="8"
          fill="${k === 2 ? CYAN : 'rgba(255,255,255,.24)'}"/>`);
        g.push(`<path d="M940 ${y + 30} l-14 14 -14 -14" stroke="${k === 2 ? CYAN : 'rgba(255,255,255,.4)'}"
          stroke-width="3" fill="none"/>`);
      }

      return svg('0 0 1200 800', g.join(''));
    })()}
  </div>
</div>

<script>window.__ids = [...document.querySelectorAll('.shot')].map(s => s.id)</script>`;

const file = path.join(here, 'mvp-art.html');
fs.writeFileSync(file, html);

const browser = await chromium.launch({ channel: 'chrome' });
const p = await browser.newPage({ viewport: { width: 2100, height: 1200 } });
p.on('pageerror', (e) => console.error('PAGE ERROR:', String(e).slice(0, 200)));
await p.goto('file:///' + file.split(path.sep).join('/'));
await p.waitForLoadState('networkidle');
await p.waitForTimeout(1500);

for (const id of await p.evaluate(() => window.__ids)) {
  const [, set, name] = id.split('-');
  const dir = path.join(OUT, set);
  fs.mkdirSync(dir, { recursive: true });
  const png = path.join(dir, name + '.png');
  const jpg = path.join(dir, name + '.jpg');
  await (await p.$('#' + id)).screenshot({ path: png });
  execFileSync(FFMPEG, ['-hide_banner', '-loglevel', 'error', '-y', '-i', png, '-q:v', '4', jpg]);
  fs.unlinkSync(png);
  console.log(`${(set + '/' + name).padEnd(20)} ${(fs.statSync(jpg).size / 1024).toFixed(0).padStart(4)}KB`);
}

await browser.close();
