/**
 * Render tools/credential-cards.html into the six card images the AI
 * Development Company page's cover flow gallery shows.
 *
 *     node tools/render-cards.mjs
 *
 * Each .card is screenshotted at its own size — 520x660, twice the gallery's
 * 260x330 — into assets/img/aidev/cards/. Run it after editing the HTML; the
 * PNGs are committed, so nothing in the site build depends on this script.
 *
 * Playwright is not a project dependency: this runs once when the cards change,
 * not on every build. It resolves from the global install.
 */
import { chromium } from 'file:///C:/Users/aakas/AppData/Roaming/npm/node_modules/playwright/index.mjs';
import { fileURLToPath } from 'node:url';
import path from 'node:path';
import fs from 'node:fs';

const here = path.dirname(fileURLToPath(import.meta.url));
const page = 'file:///' + path.join(here, 'credential-cards.html').replace(/\\/g, '/');
const out = path.join(here, '..', 'assets', 'img', 'aidev', 'cards');
fs.mkdirSync(out, { recursive: true });

const browser = await chromium.launch({ channel: 'chrome' });
const p = await browser.newPage({ viewport: { width: 760, height: 900 } });
await p.goto(page);
// The cards use webfonts and a photograph each; wait for both to land or the
// screenshots catch fallback type and empty heads.
await p.waitForLoadState('networkidle');
await p.waitForTimeout(1200);

for (const id of await p.evaluate(() => window.__ids)) {
  const el = await p.$('#' + id);
  const box = await el.boundingBox();
  const file = path.join(out, id.replace('card-', '') + '.png');
  await el.screenshot({ path: file });
  console.log(`${id.padEnd(16)} ${Math.round(box.width)}x${Math.round(box.height)}  ->  ${path.relative(process.cwd(), file)}`);
}

await browser.close();
