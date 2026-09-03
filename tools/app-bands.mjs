/**
 * The four picture bands for the two app pages.
 *
 *     node tools/app-bands.mjs
 *
 * /services/mobile-app-development.php and /services/flutter-app-development.php
 * are one React bundle serving two routes, and they were the last two pages on
 * the site carrying almost no picture — four images each across nine sections.
 *
 * Unlike the eleven service bands, these are not generated from page data:
 * the two subjects worth drawing here are the app's own architecture and the
 * road from a commit to a store listing, and neither is in any data file. Four
 * motifs, hand-specified, two per page — mobile and Flutter get different ones
 * because they genuinely differ (one Dart source targeting four platforms is
 * the Flutter argument, and it is not the mobile page's argument).
 *
 * Output: assets/img/pages/apps/<name>.jpg at 1680x640.
 */
import { chromium } from 'file:///C:/Users/aakas/AppData/Roaming/npm/node_modules/playwright/index.mjs';
import { fileURLToPath } from 'node:url';
import { execFileSync } from 'node:child_process';
import path from 'node:path';
import fs from 'node:fs';

const FFMPEG = 'C:/Users/aakas/Downloads/Central Adventure/repo/node_modules/ffmpeg-static/ffmpeg.exe';

const here = path.dirname(fileURLToPath(import.meta.url));
const out  = path.join(here, '..', 'assets', 'img', 'pages', 'apps');
fs.mkdirSync(out, { recursive: true });

/* ---- drawing helpers, shared by all four motifs ------------------------- */

const mono = "'JetBrains Mono','Fira Code',ui-monospace,monospace";
const sans = "'Space Grotesk','Outfit',system-ui,sans-serif";

const box = (x, y, w, h, label, sub, tint, strong = false) => `
  <g>
    <rect x="${x}" y="${y}" width="${w}" height="${h}" rx="14"
          fill="${strong ? `color-mix(in srgb, ${tint} 16%, transparent)` : 'rgba(255,255,255,.05)'}"
          stroke="${strong ? tint : 'rgba(255,255,255,.17)'}" stroke-width="${strong ? 3 : 2}"/>
    <text x="${x + w / 2}" y="${y + (sub ? h / 2 - 2 : h / 2 + 7)}" text-anchor="middle"
          font-family="${mono}" font-size="19" fill="rgba(240,246,255,.94)">${label}</text>
    ${sub ? `<text x="${x + w / 2}" y="${y + h / 2 + 22}" text-anchor="middle"
          font-family="${mono}" font-size="14" fill="rgba(232,238,248,.55)">${sub}</text>` : ''}
  </g>`;

const arrow = (x1, y1, x2, y2, tint, dashed = false) => `
  <path d="M${x1} ${y1} L${x2} ${y2}" stroke="${tint}" stroke-width="2.5"
        opacity=".8" ${dashed ? 'stroke-dasharray="7 7"' : ''} marker-end="url(#head)"/>`;

const chip = (x, y, label) => {
  const w = 26 + label.length * 10;
  return `<g>
    <rect x="${x}" y="${y}" width="${w}" height="34" rx="17"
          fill="rgba(255,255,255,.055)" stroke="rgba(255,255,255,.15)" stroke-width="1.5"/>
    <text x="${x + 13}" y="${y + 23}" font-family="${mono}" font-size="15"
          fill="rgba(232,238,248,.72)">${label}</text>
  </g>`;
};

const kicker = (t, tint) =>
  `<text x="110" y="66" font-family="${mono}" font-size="19" letter-spacing="5" fill="${tint}">${t}</text>`;

const heading = (t) =>
  `<text x="110" y="122" font-family="${sans}" font-size="38" font-weight="800"
         fill="#F2F7FF">${t}</text>`;

/* ---- the four motifs ---------------------------------------------------- */

const CYAN = '#22D3EE';
const BLUE = '#3B82F6';

/** A phone, the layer behind it, and the services that layer talks to. */
function mobileArchitecture() {
  const t = CYAN;
  const services = ['Auth / SSO', 'Payments', 'Push & Deep links', 'Analytics'];
  return `
    ${kicker('MOBILE ARCHITECTURE', t)}
    ${heading('One app, and the three layers under it')}

    <!-- the device -->
    <rect x="122" y="216" width="176" height="316" rx="26"
          fill="rgba(255,255,255,.045)" stroke="${t}" stroke-width="3"/>
    <rect x="146" y="252" width="128" height="212" rx="8" fill="rgba(34,211,238,.10)"/>
    <rect x="188" y="228" width="44" height="8" rx="4" fill="rgba(255,255,255,.25)"/>
    <text x="210" y="562" text-anchor="middle" font-family="${mono}" font-size="15"
          fill="rgba(232,238,248,.6)">iOS · ANDROID</text>
    ${['Native UI', 'On-device AI', 'Offline cache'].map((l, i) =>
      `<text x="210" y="${296 + i * 56}" text-anchor="middle" font-family="${mono}"
             font-size="15" fill="rgba(240,246,255,.9)">${l}</text>`).join('')}

    ${arrow(310, 374, 386, 374, t)}
    ${box(398, 314, 250, 120, 'BFF / API', 'ONE CONTRACT PER SCREEN', t, true)}

    ${services.map((s, i) => {
      const y = 196 + i * 96;
      return arrow(660, 374, 736, y + 34, t, true) + box(748, y, 292, 68, s, '', t);
    }).join('')}

    ${arrow(1052, 374, 1128, 374, t)}
    ${box(1140, 296, 250, 156, 'DATA', 'POSTGRES · REDIS · S3', t, true)}

    <text x="110" y="592" font-family="${mono}" font-size="15" letter-spacing="3"
          fill="rgba(255,255,255,.4)">EVERY LAYER YOURS ON HANDOVER — SOURCE, KEYS AND ACCOUNTS</text>`;
}

/** Commit to store listing, with the two things that actually gate it. */
function mobileRelease() {
  const t = BLUE;
  const steps = [
    ['COMMIT', 'TRUNK'],
    ['CI BUILD', 'SIGNED'],
    ['DEVICE MATRIX', '18 REAL DEVICES'],
    ['INTERNAL TRACK', 'TESTFLIGHT / PLAY'],
    ['STORE REVIEW', 'METADATA READY'],
    ['LIVE', 'BOTH STORES'],
  ];
  return `
    ${kicker('RELEASE PIPELINE', t)}
    ${heading('From a commit to both stores, on a schedule')}

    ${steps.map(([a, b], i) => {
      const x = 110 + i * 262;
      return box(x, 268, 232, 104, a, b, t, i === steps.length - 1) +
        (i < steps.length - 1 ? arrow(x + 236, 320, x + 254, 320, t) : '');
    }).join('')}

    <!-- rollback, which is the half of a pipeline nobody draws -->
    <path d="M1450 392 C 1450 470, 300 470, 226 470 L 226 388" stroke="${t}"
          stroke-width="2.5" stroke-dasharray="8 8" opacity=".7" marker-end="url(#head)"/>
    <text x="740" y="500" text-anchor="middle" font-family="${mono}" font-size="16"
          fill="rgba(232,238,248,.62)">ROLLBACK IS ONE FLAG, NOT A HOTFIX RELEASE</text>

    <text x="110" y="592" font-family="${mono}" font-size="15" letter-spacing="3"
          fill="rgba(255,255,255,.4)">BUILT ON</text>
    ${['Fastlane', 'GitHub Actions', 'Firebase', 'Sentry', 'Crashlytics']
      .map((c, i) => chip(240 + i * 232, 566, c)).join('')}`;
}

/** The Flutter argument, drawn: one source, four targets. */
function flutterCodebase() {
  const t = CYAN;
  const targets = [
    ['iOS', 'APP STORE'],
    ['ANDROID', 'PLAY'],
    ['WEB', 'CANVASKIT'],
    ['DESKTOP', 'WIN · MACOS'],
  ];
  return `
    ${kicker('ONE CODEBASE', t)}
    ${heading('One Dart source, four places it runs')}

    ${box(110, 236, 300, 150, 'lib/', 'ONE DART CODEBASE', t, true)}
    <text x="260" y="410" text-anchor="middle" font-family="${mono}" font-size="15"
          fill="rgba(232,238,248,.6)">WIDGETS · STATE · TESTS</text>

    ${arrow(260, 424, 260, 452, t, true)}
    ${box(110, 464, 300, 76, 'PLATFORM CHANNELS', 'ONLY WHERE NATIVE IS UNAVOIDABLE', t)}

    ${arrow(422, 330, 486, 330, t)}
    ${box(498, 270, 226, 120, 'FLUTTER', 'ENGINE + SKIA', t)}

    ${targets.map(([a, b], i) => {
      const y = 168 + i * 100;
      return arrow(736, 330, 800, y + 34, t, true) + box(812, y, 280, 68, a, b, t);
    }).join('')}

    <text x="110" y="592" font-family="${mono}" font-size="15" letter-spacing="3"
          fill="rgba(255,255,255,.4)">BUILT ON</text>
    ${['Dart 3', 'Riverpod', 'Melos', 'Firebase', 'Isar']
      .map((c, i) => chip(500 + i * 210, 566, c)).join('')}`;
}

/** Flavours: the thing that stops staging data reaching a shipped build. */
function flutterFlavours() {
  const t = BLUE;
  const lanes = [
    ['dev', 'MOCKS · VERBOSE LOGS', 220],
    ['staging', 'REAL API · TEST KEYS', 330],
    ['prod', 'LIVE KEYS · NO LOGS', 440],
  ];
  return `
    ${kicker('FLAVOURS AND CHANNELS', t)}
    ${heading('Three builds from one source, and they cannot mix')}

    ${box(110, 280, 240, 120, 'lib/ + main_*', 'ONE ENTRY PER FLAVOUR', t, true)}

    ${lanes.map(([a, b, y]) =>
      arrow(362, 340, 430, y + 34, t, true) + box(442, y, 330, 68, a, b, t)).join('')}

    ${arrow(784, 340, 852, 340, t)}
    ${box(864, 280, 250, 120, 'CI', 'SIGNED PER FLAVOUR', t)}

    ${arrow(1126, 340, 1194, 296, t)}
    ${arrow(1126, 340, 1194, 384, t)}
    ${box(1206, 262, 250, 68, 'APP STORE', '', t, true)}
    ${box(1206, 350, 250, 68, 'PLAY', '', t, true)}

    <text x="110" y="592" font-family="${mono}" font-size="15" letter-spacing="3"
          fill="rgba(255,255,255,.4)">A PROD BUILD CANNOT REACH A TEST DATABASE — THAT IS THE POINT</text>`;
}

const BANDS = [
  ['mobile-architecture', CYAN, '#0284C7', mobileArchitecture()],
  ['mobile-release',      BLUE, '#7C3AED', mobileRelease()],
  ['flutter-codebase',    CYAN, '#0891B2', flutterCodebase()],
  ['flutter-flavours',    BLUE, '#6366F1', flutterFlavours()],
];

const html = `<!doctype html><meta charset="utf-8"><title>App bands</title>
<style>
  * { box-sizing:border-box; margin:0 }
  body { background:#05060F; display:flex; flex-direction:column; gap:16px; padding:16px; width:1712px }
  .band {
    position:relative; width:1680px; height:640px; overflow:hidden;
    background:
      radial-gradient(110% 140% at 8% 12%, color-mix(in srgb, var(--tint) 26%, transparent) 0%, transparent 58%),
      radial-gradient(100% 130% at 94% 92%, color-mix(in srgb, var(--tint2) 24%, transparent) 0%, transparent 62%),
      linear-gradient(140deg, #0B1020 0%, #05070F 60%, #080B16 100%);
  }
  .band::before {
    content:''; position:absolute; inset:0;
    background-image:
      linear-gradient(rgba(255,255,255,.04) 1px, transparent 1px),
      linear-gradient(90deg, rgba(255,255,255,.04) 1px, transparent 1px);
    background-size:56px 56px;
    mask-image: radial-gradient(120% 110% at 40% 45%, #000 0%, transparent 82%);
  }
  .band svg { position:absolute; inset:0; width:100%; height:100% }
</style>
${BANDS.map(([id, tint, tint2, body]) => `
<div class="band" id="band-${id}" style="--tint:${tint}; --tint2:${tint2}">
  <svg viewBox="0 0 1680 640" xmlns="http://www.w3.org/2000/svg">
    <defs>
      <marker id="head" viewBox="0 0 10 10" refX="9" refY="5" markerWidth="7" markerHeight="7"
              orient="auto-start-reverse">
        <path d="M0 0 L10 5 L0 10 z" fill="${tint}"/>
      </marker>
    </defs>
    ${body}
  </svg>
</div>`).join('\n')}
<script>window.__ids = [...document.querySelectorAll('.band')].map(b => b.id)</script>`;

const file = path.join(here, 'app-bands.html');
fs.writeFileSync(file, html);

const browser = await chromium.launch({ channel: 'chrome' });
const p = await browser.newPage({ viewport: { width: 1712, height: 900 } });
p.on('pageerror', (e) => console.error('PAGE ERROR:', String(e).slice(0, 200)));
await p.goto('file:///' + file.split(path.sep).join('/'));
await p.waitForTimeout(600);

for (const id of await p.evaluate(() => window.__ids)) {
  const name = id.replace('band-', '');
  const png  = path.join(out, name + '.png');
  const jpg  = path.join(out, name + '.jpg');
  await (await p.$('#' + id)).screenshot({ path: png });
  execFileSync(FFMPEG, ['-hide_banner', '-loglevel', 'error', '-y', '-i', png, '-q:v', '4', jpg]);
  fs.unlinkSync(png);
  console.log(`${name.padEnd(24)} -> ${(fs.statSync(jpg).size / 1024).toFixed(0)}KB`);
}

await browser.close();
