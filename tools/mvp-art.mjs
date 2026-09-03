/**
 * Every picture the MVP Development page uses.
 *
 *     node tools/mvp-art.mjs
 *
 * Four sets, all rendered from markup and all in that page's own palette —
 * charcoal with signal amber and electric lime, which is deliberately not the
 * cyan-and-violet the AI Development Company page wears. A page that borrows
 * another page's components should not also borrow its colours.
 *
 *   playbook/   8 portrait pages for the 3D magazine in the hero
 *   why/        5 landscape cards for the card showcase
 *   inside/     5 backgrounds for the glass stack
 *   industry/   8 squares for the curved gallery arc
 *   compare/    2 for the before/after split reveal
 *
 * Written as one generator rather than five because they share a ground, a
 * grid and a type ramp — that shared chrome is what makes them read as one
 * page rather than five stock lookups.
 */
import { chromium } from 'file:///C:/Users/aakas/AppData/Roaming/npm/node_modules/playwright/index.mjs';
import { fileURLToPath } from 'node:url';
import { execFileSync } from 'node:child_process';
import path from 'node:path';
import fs from 'node:fs';

const FFMPEG = 'C:/Users/aakas/Downloads/Central Adventure/repo/node_modules/ffmpeg-static/ffmpeg.exe';

const here = path.dirname(fileURLToPath(import.meta.url));
const OUT  = path.join(here, '..', 'assets', 'img', 'mvp');

/* The page's palette, in one place. */
const AMBER = '#FF8A3D';
const LIME  = '#C6FF4A';
const INK   = '#F4F4F6';

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
    return `
    <div class="pg cover">
      <div class="grain"></div>
      <div class="rule"></div>
      <p class="issue">ITHRIVE SOFTWARE · MVP PRACTICE</p>
      <h1>THE<br>MVP<br>PLAY<span class="amber">BOOK</span></h1>
      <p class="sub">Twelve weeks from an idea to a number you can trust.</p>
      <div class="coverfoot">
        <span>CHENNAI · BANGALORE · COIMBATORE</span>
        <span class="lime">EDITION 04</span>
      </div>
    </div>`;
  }
  if (p.kind === 'back') {
    return `
    <div class="pg back">
      <div class="grain"></div>
      <p class="issue">THE LAST PAGE</p>
      <h2 class="bigq">Build only<br>what can be<br><span class="lime">wrong in public.</span></h2>
      <p class="sub">Everything else is a roadmap item pretending to be a requirement.</p>
      <div class="coverfoot"><span>ithrivesoftware.com</span><span class="amber">START YOUR MVP</span></div>
    </div>`;
  }

  return `
    <div class="pg">
      <div class="grain"></div>
      <div class="pghead"><span class="wk">${p.wk}</span><span class="pn">${p.n}</span></div>
      <h2>${p.t.replace(/\n/g, '<br>')}</h2>
      <p class="body">${p.b}</p>
      <div class="note"><span class="dot"></span>${p.note}</div>
      <div class="pgfoot">THE MVP PLAYBOOK · iTHRIVE SOFTWARE</div>
    </div>`;
}

/* ---- the five "why an MVP wins" cards ----------------------------------- */

const WHY = [
  ['01', 'Evidence over opinion', 'A room full of senior opinions is not data. Twelve weeks and a live cohort is.', 'lime'],
  ['02', 'A tenth of the burn', 'A full build spends the budget before the first user proves anything about it.', 'amber'],
  ['03', 'Traction raises rounds', 'Investors fund a curve. A pitch deck describes one; an MVP produces one.', 'lime'],
  ['04', 'The architecture survives', 'Small does not mean throwaway. What we build in week three is what scales in year two.', 'amber'],
  ['05', 'A real stop condition', 'If the number does not move, you stop — having spent twelve weeks instead of two years.', 'lime'],
];

/* ---- the five things inside an MVP -------------------------------------- */

const INSIDE = [
  ['The core loop', 'lime'],
  ['Auth, roles, billing', 'amber'],
  ['One real integration', 'lime'],
  ['Instrumentation', 'amber'],
  ['The admin screen', 'lime'],
];

/* ---- eight industries --------------------------------------------------- */

const INDUSTRY = [
  ['FINTECH', 'KYC, ledgers, reconciliation', 'amber'],
  ['HEALTHTECH', 'Triage, records, consent', 'lime'],
  ['LOGISTICS', 'Dispatch, tracking, proof', 'amber'],
  ['RETAIL', 'Catalogue, checkout, returns', 'lime'],
  ['EDTECH', 'Cohorts, progress, assessment', 'amber'],
  ['PROPTECH', 'Listings, tours, agreements', 'lime'],
  ['MANUFACTURING', 'Line data, quality, downtime', 'amber'],
  ['MEDIA', 'Ingest, rights, distribution', 'lime'],
];

/* ---- the before/after pair ---------------------------------------------- */

function compare(kind) {
  const rows = kind === 'before'
    ? Array.from({ length: 14 }, (_, i) => [`Feature ${String(i + 1).padStart(2, '0')}`, i < 2 ? 'core' : 'later'])
    : Array.from({ length: 14 }, (_, i) => [`Feature ${String(i + 1).padStart(2, '0')}`, i < 6 ? 'core' : 'cut']);

  return `
  <div class="cmp ${kind}">
    <div class="grain"></div>
    <p class="cmphead">${kind === 'before' ? 'THE ROADMAP YOU ARRIVED WITH' : 'THE MVP WE AGREED'}</p>
    <p class="cmpnum ${kind === 'before' ? 'amber' : 'lime'}">${kind === 'before' ? '14' : '6'}<span>${kind === 'before' ? ' features in v1' : ' features in v1'}</span></p>
    <div class="cmpgrid">
      ${rows.map(([label, cls]) => `<span class="cmpitem ${cls}">${label}</span>`).join('')}
    </div>
    <p class="cmpfoot">${kind === 'before'
      ? 'Nine months, and the first honest signal arrives after the money has gone.'
      : 'Twelve weeks, and the six that can actually move the number.'}</p>
  </div>`;
}

/* ---- the page that renders them all ------------------------------------- */

const css = `
  * { box-sizing:border-box; margin:0 }
  body { background:#050506; font-family:'Space Grotesk','Outfit',system-ui,sans-serif; padding:20px;
         display:flex; flex-wrap:wrap; gap:20px; width:2000px; color:${INK} }

  .shot { position:relative; overflow:hidden; background:#0B0B0E; }
  .grain { position:absolute; inset:0; pointer-events:none;
    background-image:
      linear-gradient(rgba(255,255,255,.035) 1px, transparent 1px),
      linear-gradient(90deg, rgba(255,255,255,.035) 1px, transparent 1px);
    background-size: 46px 46px;
    mask-image: radial-gradient(120% 100% at 50% 30%, #000 0%, transparent 84%); }
  .amber { color:${AMBER} } .lime { color:${LIME} }

  /* --- magazine pages: 900x1200, 3:4 --- */
  .pg { position:relative; width:900px; height:1200px; padding:78px 74px; overflow:hidden;
        background:
          radial-gradient(90% 70% at 12% 6%, rgba(255,138,61,.16) 0%, transparent 60%),
          radial-gradient(80% 60% at 92% 96%, rgba(198,255,74,.12) 0%, transparent 62%),
          linear-gradient(165deg, #131317 0%, #0A0A0D 58%, #101015 100%);
        display:flex; flex-direction:column; }
  .pg h2 { font-size:74px; font-weight:800; line-height:1.02; letter-spacing:-.03em; margin:34px 0 30px }
  .pg .body { font-family:'Inter',system-ui,sans-serif; font-size:26px; line-height:1.55; color:rgba(244,244,246,.72); max-width:660px }
  .pghead { display:flex; justify-content:space-between; align-items:baseline;
            border-top:2px solid ${AMBER}; padding-top:20px }
  .wk { font-family:'JetBrains Mono',monospace; font-size:20px; letter-spacing:.22em; color:${AMBER} }
  .pn { font-size:92px; font-weight:800; line-height:.8; color:rgba(244,244,246,.10) }
  .note { margin-top:auto; display:flex; align-items:flex-start; gap:14px; padding-top:26px;
          border-top:1px solid rgba(255,255,255,.12); font-family:'Inter',sans-serif;
          font-size:21px; line-height:1.5; color:${LIME} }
  .note .dot { flex:none; width:11px; height:11px; margin-top:9px; border-radius:50%; background:${LIME} }
  .pgfoot { margin-top:22px; font-family:'JetBrains Mono',monospace; font-size:15px;
            letter-spacing:.2em; color:rgba(244,244,246,.3) }

  .cover { justify-content:flex-end; }
  .cover .rule { position:absolute; left:74px; right:74px; top:210px; height:3px;
                 background:linear-gradient(90deg,${AMBER},${LIME}) }
  .issue { position:absolute; top:78px; left:74px; font-family:'JetBrains Mono',monospace;
           font-size:19px; letter-spacing:.26em; color:rgba(244,244,246,.55) }
  .cover h1 { font-size:152px; font-weight:800; line-height:.86; letter-spacing:-.05em; margin-bottom:34px }
  .sub { font-family:'Inter',sans-serif; font-size:28px; line-height:1.4; color:rgba(244,244,246,.7); max-width:600px }
  .coverfoot { display:flex; justify-content:space-between; margin-top:56px; padding-top:24px;
               border-top:1px solid rgba(255,255,255,.14); font-family:'JetBrains Mono',monospace;
               font-size:17px; letter-spacing:.16em; color:rgba(244,244,246,.5) }
  .back { justify-content:center }
  .bigq { font-size:86px; font-weight:800; line-height:1.02; letter-spacing:-.035em; margin-bottom:30px }

  /* --- why cards: 1200x800, 3:2 --- */
  .why { position:relative; width:1200px; height:800px; padding:70px; overflow:hidden;
         background:
           radial-gradient(90% 80% at 88% 10%, rgba(255,138,61,.18) 0%, transparent 58%),
           linear-gradient(150deg, #121216 0%, #08080B 62%, #0E0E13 100%);
         display:flex; flex-direction:column; justify-content:space-between }
  .why .n { font-size:150px; font-weight:800; line-height:.8; letter-spacing:-.05em;
            color:transparent; -webkit-text-stroke:2px rgba(244,244,246,.22) }
  .why h3 { font-size:62px; font-weight:800; line-height:1.05; letter-spacing:-.03em; margin:26px 0 20px }
  .why p { font-family:'Inter',sans-serif; font-size:27px; line-height:1.5; color:rgba(244,244,246,.7); max-width:820px }
  .why .whyglow { position:absolute; right:-180px; top:-180px; width:820px; height:820px;
                  border-radius:50%; filter:blur(120px); opacity:.30 }
  .why .whyn { position:absolute; left:70px; bottom:56px; font-size:210px; font-weight:800;
               line-height:.8; letter-spacing:-.06em; color:transparent;
               -webkit-text-stroke:2px rgba(244,244,246,.20) }
  .why svg { position:absolute; inset:0; width:100%; height:100% }

  /* --- inside backgrounds: 1200x800 --- */
  .ins { position:relative; width:1200px; height:800px; overflow:hidden;
         background:linear-gradient(150deg,#101015 0%,#07070A 70%) }
  .ins .glow { position:absolute; width:900px; height:900px; border-radius:50%; filter:blur(110px); opacity:.22 }
  /* No label: the glass panel prints its own title over this. */
  .ins svg { position:absolute; inset:0; width:100%; height:100% }

  /* --- industry squares: 900x900 --- */
  /* Centred, with a wide safe margin: the arc crops this square into a taller
     card and anything near an edge loses its first or last letters. */
  .ind { position:relative; width:900px; height:900px; padding:140px 120px; overflow:hidden;
         display:flex; flex-direction:column; align-items:center; justify-content:center;
         text-align:center; background:linear-gradient(155deg,#131318 0%,#08080B 66%) }
  .ind .halo { position:absolute; top:-160px; right:-160px; width:720px; height:720px;
               border-radius:50%; filter:blur(80px); opacity:.34 }
  .ind h3 { font-family:'JetBrains Mono',monospace; font-size:42px; letter-spacing:.08em; margin-bottom:20px }
  .ind p { font-family:'Inter',sans-serif; font-size:26px; line-height:1.45; color:rgba(244,244,246,.66) }
  .ind .idx { margin-bottom:26px; font-family:'JetBrains Mono',monospace;
              font-size:22px; letter-spacing:.24em; color:rgba(244,244,246,.4) }

  /* --- compare pair: 1400x900 --- */
  .cmp { position:relative; width:1400px; height:900px; padding:70px; overflow:hidden;
         background:linear-gradient(150deg,#121216 0%,#08080B 66%) }
  .cmphead { font-family:'JetBrains Mono',monospace; font-size:22px; letter-spacing:.24em;
             color:rgba(244,244,246,.5) }
  .cmpnum { font-size:132px; font-weight:800; line-height:1; letter-spacing:-.04em; margin:18px 0 34px }
  .cmpnum span { font-size:30px; font-weight:600; letter-spacing:0; color:rgba(244,244,246,.55) }
  .cmpgrid { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:14px 22px }
  .cmpitem { font-family:'JetBrains Mono',monospace; font-size:23px; padding:14px 20px; border-radius:10px;
             border:1px solid rgba(255,255,255,.13); color:rgba(244,244,246,.55) }
  .cmpitem.core { border-color:${LIME}; color:${LIME}; background:rgba(198,255,74,.08) }
  .cmpitem.later { border-color:rgba(255,138,61,.4); color:rgba(255,138,61,.85) }
  .cmpitem.cut { opacity:.3; text-decoration:line-through }
  .cmpfoot { position:absolute; left:70px; right:70px; bottom:56px; font-family:'Inter',sans-serif;
             font-size:26px; color:rgba(244,244,246,.62) }
`;

/* A little circuitry for the glass-stack backgrounds, seeded so re-runs match. */
let seed = 424242;
const rnd = () => (seed = (seed * 1103515245 + 12345) & 0x7fffffff) / 0x7fffffff;

/* One abstract motif per card, so the five read as a set without repeating the
   words the component already prints beside them. */
function whyArt(i, tint) {
  const g = [];
  if (i === 0) {           // evidence: a scatter settling onto a trend
    for (let k = 0; k < 42; k++) {
      const x = 620 + k * 13;
      const y = 560 - k * 8 + (rnd() - 0.5) * 150;
      g.push(`<circle cx="${x}" cy="${y.toFixed(0)}" r="6" fill="${tint}" opacity="${(0.25 + rnd() * 0.6).toFixed(2)}"/>`);
    }
    g.push(`<path d="M620 560 L1160 224" stroke="${tint}" stroke-width="4" opacity=".85"/>`);
  } else if (i === 1) {    // burn: one tall bar against one short one
    g.push(`<rect x="700" y="150" width="150" height="520" rx="10" fill="${tint}" opacity=".18"/>`);
    g.push(`<rect x="700" y="150" width="150" height="520" rx="10" fill="none" stroke="${tint}" stroke-width="3"/>`);
    g.push(`<rect x="920" y="618" width="150" height="52" rx="10" fill="${tint}" opacity=".9"/>`);
  } else if (i === 2) {    // traction: a curve going up through a grid
    let d = 'M640 640';
    for (let k = 1; k <= 22; k++) d += ` L${640 + k * 24} ${(640 - Math.pow(k, 1.7) * 1.5).toFixed(0)}`;
    g.push(`<path d="${d}" fill="none" stroke="${tint}" stroke-width="5" opacity=".95"/>`);
    for (let k = 0; k < 6; k++) g.push(`<path d="M640 ${180 + k * 92} H 1180" stroke="rgba(255,255,255,.09)" stroke-width="2"/>`);
  } else if (i === 3) {    // architecture: nested frames that hold
    for (let k = 0; k < 5; k++) {
      const s2 = k * 52;
      g.push(`<rect x="${660 + s2}" y="${170 + s2}" width="${480 - s2 * 2}" height="${470 - s2 * 2}" rx="14"
        fill="none" stroke="${tint}" stroke-width="${k === 0 ? 4 : 2}" opacity="${(0.85 - k * 0.14).toFixed(2)}"/>`);
    }
  } else {                 // stop condition: a line that ends in a bar
    g.push(`<path d="M620 400 H 1030" stroke="${tint}" stroke-width="5" opacity=".9"/>`);
    g.push(`<rect x="1052" y="250" width="16" height="300" rx="8" fill="${tint}"/>`);
    for (let k = 0; k < 7; k++) g.push(`<circle cx="${660 + k * 58}" cy="400" r="9" fill="${tint}" opacity=".55"/>`);
  }

  return `<svg viewBox="0 0 1200 800">${g.join('')}</svg>`;
}

function insideArt(tint) {
  const lines = [];
  for (let i = 0; i < 16; i++) {
    const y = 40 + i * 48;
    const x1 = rnd() * 500;
    const x2 = x1 + 180 + rnd() * 560;
    /* Faint on purpose: the panel's own title and body sit on top of this, and
       at the opacity this started on the lines read as strikethrough. */
    lines.push(`<path d="M${x1.toFixed(0)} ${y} H ${x2.toFixed(0)}" stroke="${tint}"
      stroke-width="${rnd() > 0.8 ? 2 : 1}" opacity="${(0.05 + rnd() * 0.14).toFixed(2)}"/>`);
    if (rnd() > 0.7) lines.push(`<circle cx="${x2.toFixed(0)}" cy="${y}" r="4" fill="${tint}" opacity=".3"/>`);
  }

  return `<svg viewBox="0 0 1200 800">${lines.join('')}</svg>`;
}

const html = `<!doctype html><meta charset="utf-8"><title>MVP art</title>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;600;700&family=Space+Grotesk:wght@500;600;700&family=Outfit:wght@700;800;900&display=swap" rel="stylesheet">
<style>${css}</style>
<body>
${PLAYBOOK.map((p, i) => `<div class="shot" id="s-playbook-${String(i + 1).padStart(2, '0')}">${playbookPage(p)}</div>`).join('')}

${WHY.map(([n, , , tone], i) => `
<div class="shot" id="s-why-${String(i + 1).padStart(2, '0')}">
  <div class="why"><div class="grain"></div>
    <div class="whyglow" style="background:${tone === 'lime' ? LIME : AMBER}"></div>
    ${whyArt(i, tone === 'lime' ? LIME : AMBER)}
    <span class="whyn">${n}</span>
  </div>
</div>`).join('')}

${INSIDE.map(([t, tone], i) => `
<div class="shot" id="s-inside-${String(i + 1).padStart(2, '0')}">
  <div class="ins">
    <div class="glow" style="background:${tone === 'lime' ? LIME : AMBER}; left:${-200 + i * 90}px; top:${-160 + i * 40}px"></div>
    ${insideArt(tone === 'lime' ? LIME : AMBER)}
    <div class="grain"></div>
  </div>
</div>`).join('')}

${INDUSTRY.map(([t, b, tone], i) => `
<div class="shot" id="s-industry-${String(i + 1).padStart(2, '0')}">
  <div class="ind">
    <div class="halo" style="background:${tone === 'lime' ? LIME : AMBER}"></div>
    <div class="grain"></div>
    <span class="idx">${String(i + 1).padStart(2, '0')} / 08</span>
    <h3 class="${tone}">${t}</h3><p>${b}</p>
  </div>
</div>`).join('')}

<div class="shot" id="s-compare-before">${compare('before')}</div>
<div class="shot" id="s-compare-after">${compare('after')}</div>

<script>window.__ids = [...document.querySelectorAll('.shot')].map(s => s.id)</script>`;

const file = path.join(here, 'mvp-art.html');
fs.writeFileSync(file, html);

const browser = await chromium.launch({ channel: 'chrome' });
const p = await browser.newPage({ viewport: { width: 2000, height: 1200 } });
p.on('pageerror', (e) => console.error('PAGE ERROR:', String(e).slice(0, 200)));
await p.goto('file:///' + file.split(path.sep).join('/'));
await p.waitForLoadState('networkidle');
await p.waitForTimeout(1400);

for (const id of await p.evaluate(() => window.__ids)) {
  const [, set, name] = id.split('-').length > 3
    ? [null, id.split('-')[1], id.split('-').slice(2).join('-')]
    : [null, id.split('-')[1], id.split('-')[2]];
  const dir = path.join(OUT, set);
  fs.mkdirSync(dir, { recursive: true });
  const png = path.join(dir, name + '.png');
  const jpg = path.join(dir, name + '.jpg');
  await (await p.$('#' + id)).screenshot({ path: png });
  execFileSync(FFMPEG, ['-hide_banner', '-loglevel', 'error', '-y', '-i', png, '-q:v', '4', jpg]);
  fs.unlinkSync(png);
  console.log(`${(set + '/' + name).padEnd(26)} ${(fs.statSync(jpg).size / 1024).toFixed(0).padStart(4)}KB`);
}

await browser.close();
