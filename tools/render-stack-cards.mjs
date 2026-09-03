/**
 * Render tools/stack-cards.html into the six 4:3 images the AI Development
 * Company page's arced focus carousel shows.
 *
 *     node tools/render-stack-cards.mjs
 *
 * Each .card is screenshotted at 1200x900 — twice the 480x360 the focus card is
 * ever displayed at — then encoded to JPEG, because a 1200x900 PNG of gradients
 * is about eight times the size for no visible gain at this scale.
 *
 * Playwright and ffmpeg are not project dependencies: this runs when the card
 * art changes, not on every build. The JPEGs are committed.
 */
import { chromium } from 'file:///C:/Users/aakas/AppData/Roaming/npm/node_modules/playwright/index.mjs';
import { fileURLToPath } from 'node:url';
import { execFileSync } from 'node:child_process';
import path from 'node:path';
import fs from 'node:fs';

const FFMPEG = 'C:/Users/aakas/Downloads/Central Adventure/repo/node_modules/ffmpeg-static/ffmpeg.exe';

const here = path.dirname(fileURLToPath(import.meta.url));
const page = 'file:///' + path.join(here, 'stack-cards.html').split(path.sep).join('/');
const out  = path.join(here, '..', 'assets', 'img', 'aidev', 'stack');
fs.mkdirSync(out, { recursive: true });

const browser = await chromium.launch({ channel: 'chrome' });
const p = await browser.newPage({ viewport: { width: 1280, height: 1000 } });
p.on('pageerror', (e) => console.error('PAGE ERROR:', String(e).slice(0, 200)));
await p.goto(page);
await p.waitForLoadState('networkidle');
await p.waitForTimeout(800);

for (const id of await p.evaluate(() => window.__ids)) {
  const png = path.join(out, id.replace('card-', 'layer-') + '.png');
  const jpg = png.replace(/\.png$/, '.jpg');
  await (await p.$('#' + id)).screenshot({ path: png });
  execFileSync(FFMPEG, ['-hide_banner', '-loglevel', 'error', '-y', '-i', png, '-q:v', '4', jpg]);
  fs.unlinkSync(png);
  console.log(`${id}  ->  ${path.relative(process.cwd(), jpg)}  ${(fs.statSync(jpg).size / 1024).toFixed(0)}KB`);
}

await browser.close();
