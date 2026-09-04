/**
 * The logo plate for the On-Demand Resources hero.
 *
 *     node tools/logo-plate.mjs
 *
 * Framer's Brush Reveal takes ONE image and rubs a cover off it under the
 * cursor, so everything the hero shows has to be baked into that single
 * picture — the mark, the wordmark, and the glass it sits on.
 *
 * The glass is built here rather than bought. Framer's Dynamic Glass Logo is a
 * paid component ($12) and publishes no module a third party can vendor, so
 * this reproduces the look it describes — a frosted plate, a bright top edge,
 * an inner shadow and a soft specular sweep — from the site's own logo and
 * palette. It is not that component and is not pretending to be.
 *
 * Two files:
 *   logo/plate.jpg   the finished plate, what Brush Reveal uncovers
 *   logo/cover.jpg   unused by the component (it takes a flat colour) but kept
 *                    as the poster's still, so the fallback and the live
 *                    version show the same thing
 */
import { chromium } from 'file:///C:/Users/aakas/AppData/Roaming/npm/node_modules/playwright/index.mjs';
import { fileURLToPath } from 'node:url';
import { execFileSync } from 'node:child_process';
import path from 'node:path';
import fs from 'node:fs';

const FFMPEG = 'C:/Users/aakas/Downloads/Central Adventure/repo/node_modules/ffmpeg-static/ffmpeg.exe';
const here = path.dirname(fileURLToPath(import.meta.url));
const ROOT = path.join(here, '..');
const OUT  = path.join(ROOT, 'assets', 'img', 'ondemand', 'logo');

/* The site's own mark, inlined so the plate does not depend on a file URL
   resolving inside the headless page. */
const MARK = fs.readFileSync(path.join(ROOT, 'assets', 'img', 'logo-mark.svg'), 'utf8')
  .replace(/^<\?xml[^>]*\?>\s*/, '');

const W = 1400;
const H = 900;

/**
 * The glass plate.
 *
 * backdrop-filter has nothing to blur in a headless screenshot with no page
 * behind it, so the frost is drawn: a soft radial wash for the light, a bright
 * 1px top edge, and a specular sweep at a shallow angle. Baked, because the
 * component only ever gets one flat image.
 */
const html = `<!doctype html><meta charset="utf-8">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@600;700&family=JetBrains+Mono:wght@600&display=swap">
<style>
  * { box-sizing: border-box; }
  body { margin: 0; }

  #plate {
    position: relative;
    width: ${W}px;
    height: ${H}px;
    display: grid;
    place-items: center;
    overflow: hidden;
    background:
      radial-gradient(58% 60% at 26% 18%, rgba(0, 242, 254, 0.20) 0%, transparent 62%),
      radial-gradient(52% 56% at 82% 84%, rgba(157, 78, 221, 0.20) 0%, transparent 62%),
      #0B0F17;
    font-family: 'Space Grotesk', system-ui, sans-serif;
  }

  /* The frosted card. */
  .card {
    position: relative;
    display: grid;
    place-items: center;
    gap: 26px;
    width: 720px;
    padding: 64px 72px 58px;
    border: 1px solid rgba(255, 255, 255, 0.16);
    border-radius: 34px;
    background:
      linear-gradient(157deg, rgba(255, 255, 255, 0.13) 0%, rgba(255, 255, 255, 0.04) 46%, rgba(255, 255, 255, 0.07) 100%);
    box-shadow:
      0 60px 120px -50px rgba(0, 0, 0, 0.95),
      inset 0 1px 0 rgba(255, 255, 255, 0.34),
      inset 0 -1px 0 rgba(255, 255, 255, 0.07);
  }

  /* The specular sweep — a shallow band of light across the plate. */
  .card::after {
    content: '';
    position: absolute;
    inset: 0;
    border-radius: inherit;
    background: linear-gradient(103deg, transparent 26%, rgba(255, 255, 255, 0.16) 42%, transparent 56%);
    pointer-events: none;
  }

  .mark { width: 232px; height: 232px; filter: drop-shadow(0 18px 40px rgba(0, 180, 255, 0.42)); }
  .mark svg { display: block; width: 100%; height: 100%; }

  .word {
    display: grid;
    justify-items: center;
    gap: 8px;
    text-align: center;
  }

  .name {
    font-size: 78px;
    font-weight: 700;
    letter-spacing: -0.045em;
    line-height: 1;
    background: linear-gradient(120deg, #00F2FE 0%, #4EA8FF 45%, #9D4EDD 100%);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
  }

  .sub {
    font-family: 'JetBrains Mono', monospace;
    font-size: 17px;
    font-weight: 600;
    letter-spacing: 0.42em;
    text-transform: uppercase;
    color: rgba(234, 240, 250, 0.72);
    padding-left: 0.42em;   /* the tracking pushes it left otherwise */
  }
</style>

<div id="plate">
  <div class="card">
    <div class="mark">${MARK}</div>
    <div class="word">
      <div class="name">iThrive</div>
      <div class="sub">Software</div>
    </div>
  </div>
</div>`;

const tmp = path.join(ROOT, '.logo-plate.html');
fs.writeFileSync(tmp, html);
fs.mkdirSync(OUT, { recursive: true });

const browser = await chromium.launch({ channel: 'chrome' });
const p = await browser.newPage({ viewport: { width: W + 40, height: H + 40 } });
p.on('pageerror', (e) => console.error('PAGE ERROR:', String(e).slice(0, 200)));
await p.goto('file:///' + tmp.split(path.sep).join('/'));
await p.waitForLoadState('networkidle');
await p.evaluate(() => document.fonts.ready);
await p.waitForTimeout(700);

const png = path.join(OUT, 'plate.png');
await (await p.$('#plate')).screenshot({ path: png });

for (const name of ['plate', 'cover']) {
  const jpg = path.join(OUT, name + '.jpg');
  execFileSync(FFMPEG, ['-hide_banner', '-loglevel', 'error', '-y', '-i', png, '-q:v', '3', jpg]);
  console.log(`logo/${name}.jpg  ${(fs.statSync(jpg).size / 1024).toFixed(0)}KB`);
}

fs.unlinkSync(png);
await browser.close();
fs.unlinkSync(tmp);
