/**
 * Render one picture band per service-detail page.
 *
 *     node tools/service-bands.mjs
 *
 * Eleven /services routes share includes/templates/service-detail.php and were
 * the only pages left on the site with no picture at all — six or seven images
 * each, every one of them a logo or a card chrome. They needed a band, and a
 * band each: reusing one across eleven pages is the repeat the brief rules out.
 *
 * Rather than eleven hand-drawn pictures, this draws ONE band from each
 * service's OWN data — the six capabilities the page already lists and the
 * stack tags already under them, scraped from the rendered page so the picture
 * cannot drift from the copy beside it. Eleven inputs, eleven different
 * pictures, one thing to maintain.
 *
 * The motif is the delivery shape every one of these services actually has: a
 * spine with six capabilities hanging off it, feeding one shipped thing, over
 * the technologies it is built on. What differs page to page is the words,
 * which is what makes each band that page's own.
 *
 * Output: assets/img/pages/services/<slug>.jpg at 1680x640 (21:8, the band
 * ratio page-figure defaults to), JPEG for the same reason as the stack cards.
 */
import { chromium } from 'file:///C:/Users/aakas/AppData/Roaming/npm/node_modules/playwright/index.mjs';
import { fileURLToPath } from 'node:url';
import { execFileSync } from 'node:child_process';
import path from 'node:path';
import fs from 'node:fs';

const FFMPEG = 'C:/Users/aakas/Downloads/Central Adventure/repo/node_modules/ffmpeg-static/ffmpeg.exe';
const BASE   = 'http://localhost:8100';

const here = path.dirname(fileURLToPath(import.meta.url));
const out  = path.join(here, '..', 'assets', 'img', 'pages', 'services');
fs.mkdirSync(out, { recursive: true });

/* Each service group keeps its own colour, so the eleven bands read as four
   families rather than eleven unrelated pictures. The ramps are the site's:
   cyan #00F2FE through blue into violet #9D4EDD. */
const TINTS = {
  'Core Services':                ['#00E5FF', '#0284C7'],
  'AI-First Product Development': ['#22D3EE', '#6366F1'],
  'Digital Product Engineering':  ['#3B82F6', '#7C3AED'],
  'Engagement Models':            ['#A855F7', '#DB2777'],
};

const SLUGS = [
  'ai-for-ecommerce', 'cloud-devops', 'custom-product-development',
  'dedicated-engineering-team', 'ecommerce-development', 'micro-saas-development',
  'mvp-development', 'on-demand-resources', 'poc-development',
  'product-modernization', 'reactjs-development',
  /* Also on the shared layout, and also without a picture of its own — it
     replaces the hero rather than the body, so everything below still applies. */
  'ai-native-product-development',
];

const browser = await chromium.launch({ channel: 'chrome' });
const reader  = await browser.newPage({ viewport: { width: 1440, height: 900 } });

/* Read each page's own words rather than duplicating them here. */
const services = [];
for (const slug of SLUGS) {
  await reader.goto(`${BASE}/services/${slug}.php`, { waitUntil: 'domcontentloaded', timeout: 60000 });
  services.push(await reader.evaluate((s) => ({
    slug: s,
    title: document.querySelector('h1')?.textContent.trim() ?? s,
    group: document.querySelector('.eyebrow')?.textContent.trim() ?? '',
    caps:  [...document.querySelectorAll('.card--numbered .card-title')].map(e => e.textContent.trim()).slice(0, 6),
    stack: [...document.querySelectorAll('.tag-row .tag')].map(e => e.textContent.trim()).slice(0, 9),
  }), slug));
}
await reader.close();

const esc = (s) => s.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');

function band(svc) {
  const [tint, tint2] = TINTS[svc.group] ?? TINTS['Core Services'];

  /*
   * Six capability nodes, three above the spine and three below it.
   *
   * The label is the page's own wording and some of it is long — "Intent-based
   * merchandising" is 26 characters — so the box is sized for the longest of
   * them and the type steps down rather than the words being cut. A truncated
   * capability reads as a bug; a slightly smaller one does not.
   */
  const COLS = [300, 650, 1000];
  const nodes = svc.caps.map((label, i) => {
    const x  = COLS[i % 3];
    const up = i < 3;
    const y  = up ? 170 : 470;
    return `
      <g>
        <path d="M${x} ${up ? y + 43 : y - 43} V 320" stroke="${tint}" stroke-width="2"
              stroke-dasharray="6 7" opacity=".5"/>
        <rect x="${x - 165}" y="${y - 43}" width="330" height="86" rx="14"
              fill="rgba(255,255,255,.05)" stroke="rgba(255,255,255,.17)" stroke-width="2"/>
        <circle cx="${x - 137}" cy="${y}" r="6" fill="${tint}"/>
        <text x="${x - 117}" y="${y + 8}" font-family="'JetBrains Mono',ui-monospace,monospace"
              font-size="${label.length > 22 ? 17 : 20}" fill="rgba(232,238,248,.92)">${esc(label)}</text>
        <circle cx="${x}" cy="320" r="7" fill="${tint}"/>
      </g>`;
  }).join('');

  /*
   * The stack, as one row that stops at the frame rather than wrapping into it.
   * The previous version placed chips on a fixed 5-column pitch and let a second
   * row run off the bottom edge; laying them out by their own measured width and
   * cutting the row when it reaches the margin keeps every chip whole.
   */
  let cx = 232;
  const chips = [];
  for (const tag of svc.stack) {
    const w = 30 + tag.length * 11;
    if (cx + w > 1540) break;
    chips.push(`
      <g>
        <rect x="${cx}" y="${556}" width="${w}" height="40" rx="20"
              fill="rgba(255,255,255,.055)" stroke="rgba(255,255,255,.15)" stroke-width="1.5"/>
        <text x="${cx + 15}" y="${582}" font-family="'JetBrains Mono',ui-monospace,monospace"
              font-size="17" fill="rgba(232,238,248,.74)">${esc(tag)}</text>
      </g>`);
    cx += w + 16;
  }

  return `
<div class="band" id="band-${svc.slug}" style="--tint:${tint}; --tint2:${tint2}">
  <svg viewBox="0 0 1680 640" xmlns="http://www.w3.org/2000/svg">
    <defs>
      <!-- userSpaceOnUse, because the spine is a horizontal line: its bounding
           box has zero height, so a filter region in objectBoundingBox
           percentages resolves to nothing and the stroke never paints. -->
      <filter id="g-${svc.slug}" filterUnits="userSpaceOnUse"
              x="80" y="280" width="1140" height="80">
        <feGaussianBlur stdDeviation="7" result="b"/>
        <feMerge><feMergeNode in="b"/><feMergeNode in="SourceGraphic"/></feMerge>
      </filter>
    </defs>

    <path d="M120 320 H 1170" stroke="${tint}" stroke-width="4" opacity=".9"
          filter="url(#g-${svc.slug})"/>
    ${nodes}

    <g>
      <rect x="1226" y="266" width="316" height="108" rx="18"
            fill="color-mix(in srgb, ${tint} 15%, transparent)" stroke="${tint}" stroke-width="3"/>
      <text x="1384" y="314" text-anchor="middle" font-family="'Space Grotesk',system-ui,sans-serif"
            font-size="28" font-weight="700" fill="#F4F8FF">IN PRODUCTION</text>
      <text x="1384" y="346" text-anchor="middle" font-family="'JetBrains Mono',ui-monospace,monospace"
            font-size="16" fill="rgba(232,238,248,.62)">SOURCE AND IP · YOURS</text>
    </g>

    <text x="120" y="70" font-family="'JetBrains Mono',ui-monospace,monospace" font-size="20"
          letter-spacing="5" fill="${tint}">${esc(svc.group.toUpperCase())}</text>
    <text x="120" y="582" font-family="'JetBrains Mono',ui-monospace,monospace" font-size="16"
          letter-spacing="3" fill="rgba(255,255,255,.4)">BUILT ON</text>
    ${chips.join('')}
  </svg>
</div>`;
}

const html = `<!doctype html><meta charset="utf-8"><title>Service bands</title>
<style>
  * { box-sizing: border-box; margin: 0 }
  body { background:#05060F; display:flex; flex-direction:column; gap:16px; padding:16px; width:1712px }
  .band {
    position: relative; width:1680px; height:640px; overflow:hidden;
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
    background-size: 56px 56px;
    mask-image: radial-gradient(120% 110% at 40% 45%, #000 0%, transparent 82%);
  }
  .band svg { position:absolute; inset:0; width:100%; height:100% }
</style>
${services.map(band).join('\n')}
<script>window.__ids = [...document.querySelectorAll('.band')].map(b => b.id)</script>`;

const file = path.join(here, 'service-bands.html');
fs.writeFileSync(file, html);

const p = await browser.newPage({ viewport: { width: 1712, height: 900 } });
await p.goto('file:///' + file.split(path.sep).join('/'));
await p.waitForTimeout(600);

for (const id of await p.evaluate(() => window.__ids)) {
  const slug = id.replace('band-', '');
  const png = path.join(out, slug + '.png');
  const jpg = path.join(out, slug + '.jpg');
  await (await p.$('#' + id)).screenshot({ path: png });
  execFileSync(FFMPEG, ['-hide_banner', '-loglevel', 'error', '-y', '-i', png, '-q:v', '4', jpg]);
  fs.unlinkSync(png);
  console.log(`${slug.padEnd(30)} -> ${(fs.statSync(jpg).size / 1024).toFixed(0)}KB`);
}

await browser.close();
