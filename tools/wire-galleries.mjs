/**
 * Put each AI service page's images into a 3D gallery.
 *
 * The fourteen images per page were sitting in card corners about 400px wide,
 * which is where a 1672px render goes to die. This gives each of the three
 * image sections its own gallery, sized to what that section holds:
 *
 *   section 3, six images  -> deck       a WebGL stack scrolled through
 *   section 5, five images -> coverflow  a 3D coverflow reel
 *   section 6, three images-> stack      a fanned deck you flick
 *
 * All three components are already vendored and registered in
 * app/originkit/src/embed.jsx and present in the built bundle, so nothing is
 * fetched, no dependency is added and the bundle does not grow.
 *
 * The per-card figures are switched off in sections 3 and 5, because the
 * gallery above now carries those same images and showing each one twice in a
 * section is worse than showing it once properly.
 *
 * Idempotent: a page that already has a gallery is skipped. Run with --check
 * to see what would happen without writing, and --only NN for one page.
 *
 *   node tools/wire-galleries.mjs --check
 *   node tools/wire-galleries.mjs --only 01
 *   node tools/wire-galleries.mjs
 */

import fs from 'node:fs';
import path from 'node:path';
import { fileURLToPath } from 'node:url';

const ROOT = path.resolve(fileURLToPath(new URL('..', import.meta.url)));
const CHECK = process.argv.includes('--check');
const ONLY = (() => {
  const i = process.argv.indexOf('--only');
  return i > -1 ? process.argv[i + 1] : null;
})();

/** [page number as written in svc_img(), file slug] */
const PAGES = [
  ['01', 'ai-consulting'],
  ['02', 'gen-ai-development'],
  ['03', 'ai-chatbot-development'],
  ['04', 'ai-copilot-development'],
  ['05', 'rag-development'],
  ['06', 'computer-vision-development'],
  ['07', 'agentic-ai-strategy'],
  ['08', 'custom-agent-development'],
  ['09', 'ai-agent-solutions'],
  ['10', 'multi-agent-orchestration'],
  ['11', 'agentic-ai-integration'],
  ['12', 'ai-integration'],
  ['13', 'autonomous-workflow-automation'],
  ['14', 'agent-operations-support'],
  ['15', 'rpa-development'],
  ['16', 'hire-agentic-ai-developers'],
];

const gallery = (n, section, count, variant, label) => {
  const imgs = Array.from({ length: count }, (_, k) => `svc_img('${n}', ${section}, ${k + 1})`).join(', ');
  return [
    `      <?php /* The ${count} images for this section, shown in depth rather than as`,
    `               card corners. Falls back to a plain grid of the same images if the`,
    `               island never mounts -- see includes/components/svc-gallery.php. */ ?>`,
    `      <?php component('svc-gallery', [`,
    `          'images'  => array_filter([${imgs}]),`,
    `          'variant' => '${variant}',`,
    `          'label'   => '${label}',`,
    `      ]); ?>`,
    '',
  ].join('\n');
};

let wired = 0, skipped = 0, failed = 0;

for (const [n, slug] of PAGES) {
  if (ONLY && ONLY !== n) continue;

  const file = path.join(ROOT, 'services', `${slug}.php`);
  if (!fs.existsSync(file)) { console.log(`  MISSING  ${slug}`); failed++; continue; }

  let s = fs.readFileSync(file, 'utf8');
  const nl = s.includes('\r\n') ? '\r\n' : '\n';

  if (s.includes("component('svc-gallery'")) {
    console.log(`  skip     ${slug} (already wired)`);
    skipped++;
    continue;
  }

  const before = s;
  const norm = (t) => t.split('\n').join(nl);

  /* --- section 3: gallery above the card grid, figures off in the cards --- */
  const grid3 = `      <div class="svc-cards-grid">`;
  if (s.includes(norm(grid3))) {
    s = s.replace(norm(grid3), norm(gallery(n, 3, 6, 'deck', 'Capability visuals')) + norm(grid3));
  }
  const fig3 = new RegExp(`<\\?php \\$fig = svc_img\\('${n}', 3, \\$i \\+ 1\\); \\?>`);
  s = s.replace(fig3, `<?php $fig = null; /* shown by the gallery above this grid */ ?>`);

  /* --- section 5: same, with the coverflow reel --- */
  const grid5 = `      <div class="svc-benefits-grid">`;
  if (s.includes(norm(grid5))) {
    s = s.replace(norm(grid5), norm(gallery(n, 5, 5, 'coverflow', 'Business impact visuals')) + norm(grid5));
  }
  const fig5 = new RegExp(`<\\?php \\$fig = svc_img\\('${n}', 5, \\$i \\+ 1\\); \\?>`);
  s = s.replace(fig5, `<?php $fig = null; /* shown by the gallery above this grid */ ?>`);

  /* --- section 6: the three stills replace the flat strip --- */
  const strip = new RegExp(
    `\\s*<\\?php\\s*\\$s6 = array_filter\\(\\[svc_img\\('${n}', 6, 1\\), svc_img\\('${n}', 6, 2\\), svc_img\\('${n}', 6, 3\\)\\]\\);\\s*\\?>` +
    `[\\s\\S]*?<\\?php endif; \\?>`,
    'm'
  );
  if (strip.test(s)) {
    s = s.replace(strip, nl + norm(gallery(n, 6, 3, 'stack', 'Delivery phase visuals')));
  }

  const changes = [
    ['section 3 gallery', s.includes(`'variant' => 'deck'`)],
    ['section 5 gallery', s.includes(`'variant' => 'coverflow'`)],
    ['section 6 gallery', s.includes(`'variant' => 'stack'`)],
  ];
  const missing = changes.filter(([, ok]) => !ok).map(([k]) => k);

  if (s === before) {
    console.log(`  NOCHANGE ${slug}`);
    failed++;
    continue;
  }

  if (!CHECK) fs.writeFileSync(file, s, 'utf8');
  console.log(`  ${CHECK ? 'would wire' : 'wired'}   ${slug}${missing.length ? '   MISSING: ' + missing.join(', ') : ''}`);
  if (missing.length) failed++; else wired++;
}

console.log(`\n${CHECK ? 'would wire' : 'wired'}: ${wired}   skipped: ${skipped}   problems: ${failed}`);
