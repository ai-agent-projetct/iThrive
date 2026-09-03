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

/*
 * The motifs.
 *
 * These were bar charts, scatter plots and flow diagrams. Read back on the page
 * they looked like a slide deck — the brief was pictures, not graphs. They are
 * now compositions: layered light, glass planes, depth of field. Still drawn
 * rather than photographed, because no image generator is reachable from this
 * machine right now (see the note in the page's header comment) — but they read
 * as imagery instead of as diagrams, and every one of them is a swap away from
 * a photograph when a generator is back.
 */

/** A soft field of light: the base every scene is built on. */
function field(tint, seedShift = 0) {
  const g = [];
  for (let k = 0; k < 5; k++) {
    const cx = 180 + ((k * 7 + seedShift) % 5) * 220 + rnd() * 120;
    const cy = 140 + ((k * 3 + seedShift) % 4) * 160 + rnd() * 90;
    const r = 180 + rnd() * 240;
    g.push(`<circle cx="${cx.toFixed(0)}" cy="${cy.toFixed(0)}" r="${r.toFixed(0)}"
      fill="url(#blur-${seedShift})" opacity="${(0.16 + rnd() * 0.3).toFixed(2)}"/>`);
  }

  return `<defs>
    <radialGradient id="blur-${seedShift}">
      <stop offset="0" stop-color="${tint}" stop-opacity="0.9"/>
      <stop offset="1" stop-color="${tint}" stop-opacity="0"/>
    </radialGradient>
  </defs>${g.join('')}`;
}

/*
 * Glass planes catching the light.
 *
 * The first version stepped their heights down in order, which made every scene
 * read as a bar chart — exactly what these were drawn to stop being. Heights,
 * offsets and angles are all scattered now, so they look like panes at
 * different depths rather than a series.
 */
function planes(tint, n, skew) {
  const g = [];
  for (let k = 0; k < n; k++) {
    const w = 92 + rnd() * 120;
    const h = 200 + rnd() * 430;
    const x = -40 + rnd() * 1120;
    const y = 40 + rnd() * 420;
    const rot = skew + (rnd() - 0.5) * 16;
    const near = rnd();
    g.push(`<g transform="translate(${x.toFixed(0)} ${y.toFixed(0)}) rotate(${rot.toFixed(1)})">
      <rect x="0" y="0" width="${w.toFixed(0)}" height="${h.toFixed(0)}" rx="${(14 + rnd() * 16).toFixed(0)}"
        fill="rgba(255,255,255,${(0.012 + near * 0.05).toFixed(3)})"
        stroke="${tint}" stroke-width="${(0.8 + near * 1.8).toFixed(1)}"
        opacity="${(0.22 + near * 0.68).toFixed(2)}"/>
      <rect x="0" y="0" width="${w.toFixed(0)}" height="${(h * (0.2 + rnd() * 0.4)).toFixed(0)}"
        rx="${(14 + rnd() * 16).toFixed(0)}" fill="${tint}" opacity="${(0.04 + near * 0.14).toFixed(3)}"/>
    </g>`);
  }

  return g.join('');
}

/** Long streaks of light, as a camera would smear them. */
function streaks(tint, n, y0, spread) {
  const g = [];
  for (let k = 0; k < n; k++) {
    const y = y0 + k * spread + rnd() * 18;
    const x1 = -60 + rnd() * 300;
    const x2 = x1 + 500 + rnd() * 700;
    const w = 2 + rnd() * 9;
    g.push(`<rect x="${x1.toFixed(0)}" y="${y.toFixed(0)}" width="${(x2 - x1).toFixed(0)}" height="${w.toFixed(1)}"
      rx="${(w / 2).toFixed(1)}" fill="${tint}" opacity="${(0.12 + rnd() * 0.5).toFixed(2)}"/>`);
  }

  return g.join('');
}

/** Why an MVP wins — the card showcase. Abstract: the component prints the words. */
function whyArt(i, tint) {
  const scenes = [
    () => field(tint, 1) + streaks(tint, 14, 150, 42),
    () => field(tint, 2) + planes(tint, 5, -8),
    () => field(tint, 3) + streaks(tint, 9, 120, 66) + planes(tint, 3, 6),
    () => field(tint, 4) + planes(tint, 6, 4),
    () => field(tint, 5) + streaks(tint, 18, 90, 36),
  ];

  return svg('0 0 1200 800', scenes[i]());
}

/** The five advantages of building MVP-first. */
const ADVANTAGE = [
  ['01', 'Build What Users Actually Need',
   'Features are chosen from observed behaviour rather than from the loudest opinion in the room.',
   CYAN, 0],
  ['02', 'Reduce Development Costs by 60%',
   'Six features instead of forty, and no rebuild of work that was never wanted.',
   BLUE, 1],
  ['03', 'Speed to Market With Real Insights',
   'Live in twelve weeks, instrumented from day one.', PURPLE, 2],
  ['04', 'Agile Product Development',
   'Two-week sprints against real data, with an installable build every Friday.', CYAN, 3],
  ['05', 'Validate Your Hypothesis Quickly and Cheaply',
   'One number, one threshold, one date.', BLUE, 4],
];

function advantageArt(kind, tint) {
  const scenes = [
    () => field(tint, 11) + planes(tint, 6, -6) + streaks(tint, 6, 620, 30),
    () => field(tint, 12) + streaks(tint, 20, 110, 34),
    () => field(tint, 13) + streaks(tint, 8, 240, 60) + planes(tint, 4, 9),
    () => field(tint, 14) + planes(tint, 7, 3),
    () => field(tint, 15) + streaks(tint, 12, 160, 48) + planes(tint, 2, -10),
  ];

  return svg('0 0 1200 800', scenes[kind]());
}

/** The six process steps. */
const STEPS = [
  ['01', 'Start With Clear Goals', 0, CYAN],
  ['02', 'Identify the Essential Features', 1, BLUE],
  ['03', 'Create the Basic Screens & Flow', 2, PURPLE],
  ['04', 'Build the Working MVP', 3, CYAN],
  ['05', 'Test & Launch', 4, BLUE],
  ['06', 'Review & Iterate Next Steps', 5, PURPLE],
];

function stepArt(kind, tint) {
  const scenes = [
    () => field(tint, 21) + planes(tint, 4, -7),
    () => field(tint, 22) + streaks(tint, 16, 120, 40),
    () => field(tint, 23) + planes(tint, 6, 5),
    () => field(tint, 24) + planes(tint, 5, -4) + streaks(tint, 7, 560, 32),
    () => field(tint, 25) + streaks(tint, 11, 180, 52),
    () => field(tint, 26) + planes(tint, 3, 8) + streaks(tint, 13, 130, 44),
  ];

  return svg('0 0 1200 800', scenes[kind]());
}

/*
 * The image trail's pictures.
 *
 * These used to be a faint ground UNDER the glass panels' own text, so they were
 * drawn well below reading contrast. The section is now Framer's Image Trail
 * Effect, where they are the subject and follow the cursor at full strength —
 * so they are proper compositions, and portrait, which is the shape the trail
 * lays them out in.
 */
function trailArt(i, tint) {
  const scenes = [
    () => field(tint, 41) + planes(tint, 3, -8),
    () => field(tint, 42) + streaks(tint, 14, 90, 46),
    () => field(tint, 43) + planes(tint, 4, 6),
    () => field(tint, 44) + streaks(tint, 10, 120, 56) + planes(tint, 2, -5),
    () => field(tint, 45) + planes(tint, 5, 4) + streaks(tint, 6, 520, 40),
  ];

  return svg('0 0 760 950', scenes[i]());
}

const TRAIL = [CYAN, BLUE, PURPLE, CYAN, BLUE];

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
  ['01', 0, CYAN], ['02', 1, BLUE], ['03', 2, PURPLE],
  ['04', 3, CYAN], ['05', 4, BLUE], ['06', 5, PURPLE],
];

function reasonArt(kind, tint) {
  const scenes = [
    () => field(tint, 31) + planes(tint, 3, -6),
    () => field(tint, 32) + streaks(tint, 9, 60, 40),
    () => field(tint, 33) + planes(tint, 4, 5),
    () => field(tint, 34) + streaks(tint, 12, 40, 32),
    () => field(tint, 35) + planes(tint, 2, -9),
    () => field(tint, 36) + streaks(tint, 7, 70, 48),
  ];

  return svg('0 0 600 420', scenes[kind]());
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

  /* trail pictures — portrait, because that is the shape the trail lays out */
  .ins { position:relative; width:760px; height:950px; overflow:hidden;
         background:radial-gradient(80% 60% at 70% 12%, var(--wash) 0%, transparent 62%),
                    linear-gradient(155deg,#101825 0%,#070A11 70%) }
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
    ${svg('0 0 800 640', field(CYAN, 51) + streaks(BLUE, 16, 90, 34) + planes(PURPLE, 3, -6))}
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

${TRAIL.map((tint, i) => `
<div class="shot" id="s-trail-0${i + 1}">
  <div class="ins" style="--wash:${tint}34">
    ${trailArt(i, tint)}<div class="grain"></div>
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
    ${svg('0 0 1200 800', field(PURPLE, 61) + planes(CYAN, 5, -5) + streaks(BLUE, 9, 560, 38))}
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
