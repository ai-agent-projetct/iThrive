/**
 * Vendor a published Framer component, and everything it imports, into the
 * Origin Kit island.
 *
 *     node tools/fetch-framer.mjs <dir-name> <https://framer.com/m/...js@...>
 *     node tools/fetch-framer.mjs --all          (re-fetch everything in MANIFEST)
 *
 * Why vendor rather than import from Framer's CDN at runtime: the published
 * modules use bare specifiers — `react`, `react/jsx-runtime`, `framer`,
 * `framer-motion` — which a browser cannot resolve without an import map, and
 * shipping React twice (once in the island bundle, once as an ESM module for
 * the import map) is worse than a build step. Vendored, they go through the
 * same vite build as everything else and `framer` resolves to the local shim.
 *
 * What it does:
 *  - Follows the framer.com/m/ stub, which is a one-line re-export.
 *  - Walks every import that points at framerusercontent.com, framer.com/m/ or
 *    bundles.framercoder.com, fetching each once and rewriting the import to a
 *    sibling file. Bare specifiers are left exactly as they are.
 *  - Writes to app/originkit/src/components/framer/<dir-name>/, with index.js
 *    as the entry.
 *
 * The files are committed and are byte-for-byte what Framer serves apart from
 * those rewritten import URLs, so a component can be re-fetched and dropped
 * over the old copy with only the version line to review.
 */
import { fileURLToPath } from 'node:url';
import path from 'node:path';
import fs from 'node:fs';

/** Every component this site runs, so `--all` can refresh the set. */
const MANIFEST = {
  'magazine-3d':        'https://framer.com/m/ThreeD-magazine-framer-vWSZ.js@0T7JS6GmO5Ie67Z04tPC',
  'gradient-motion-bg': 'https://framer.com/m/GradientMotionBackground-WD0KcZ.js@0XzNSaACkRVeYaCYXGIe',
  'card-showcase':      'https://framer.com/m/CardShowcase-3qxj.js@1dwe9Z9NXC9obVzYe7mU',
  'motion-tiles':       'https://framer.com/m/Motion-Tiles-uUUM.js@1S25sQmvBZTCfWUwbc2C',
  'scroll-timeline':    'https://framer.com/m/Scrolltimeline-INOzsL.js@ccv8WeYmtnL7Lr8K5f2e',
  'curved-gallery-arc': 'https://framer.com/m/CurvedGalleryArc-qwHMD7.js@4uXxGoDMNzm1vKeQ36fA',
  'service-accordion':  'https://framer.com/m/Service-Accordion-9AKRk0.js@5705lIQS0zFn3fQ1EDtH',
  'infinity-text':      'https://framer.com/m/InfinityText-sCMW9t.js@jdbpeiMUt51NiAp1k7xZ',
  'typewriter-effect':  'https://framer.com/m/TypewriterEffect-BJ1p.js@1AITomapiVi0hbIN3aB3',
  'split-reveal':       'https://framer.com/m/SplitReveal-n3BRa5.js@xXdEGKzmBtkRyyv0W3kE',
  'glass-stack':        'https://framer.com/m/AppleGlassStack-1H0xTm.js@iHl3lDAeehdt4X1PnBEQ',
  'dithering-hover':    'https://framer.com/m/DitheringHover-M1Hdlx.js@qxYaCKUi7dg86wla4Z0g',
  'animated-path':      'https://framer.com/m/AnimatedPath-zpq9rv.js@POpugJ0TBxWL4GA458rY',
  'image-trail':        'https://framer.com/m/ImageTrailEffect-IfXEqc.js@9lwVyb8puGYVdiViqG1C',

  /* The PoC Development page's set, kept deliberately disjoint from the MVP
     page's so the two read as different pages rather than one template. */
  'scroll-3d-slider':   'https://framer.com/m/Scroll3dSlider-feA8su.js@2fWxUpTxmOoSNHrRJKeH',
  'steps-flow':         'https://framer.com/m/StepsFlow-sYFgLb.js@6lahIk3YSyL4zf6fOKn9',
  'depth-blur-carousel':'https://framer.com/m/Depth-Blur-Carousel-fvJ2lB.js@GXN6LrtdSMkVOzHCU8CD',

  /* The ReactJS Development page's set. */
  'interactive-pattern': 'https://framer.com/m/Dots-1-9hMKym.js@Io2EJNUHmQKXYcZgVePZ',
  'physics-sticker-wall':'https://framer.com/m/PhysicsStickerWall-zHPbfb.js@e1ECKBDS8JUJUEvoBub9',
  'liquid-carousel':    'https://framer.com/m/liquid-glass-carousel-SkrkTr.js@kpCFFax8ciLkuLf0kMrs',

  /* The Dedicated Team page's set. */
  'circle-expand-card':  'https://framer.com/m/CircleExpandCard-Hwe1Cb.js@3oVhqtycivGXKTvLWUxu',
  'image-scroller':      'https://framer.com/m/ImageScroller-kjnj.js@aP86nmOJy6tPfN0rRzeL',
  'sticky-scroll-story': 'https://framer.com/m/StickyScrollStory-2-x6oztN.js@3u60lLOoADWXFvcvY5Ek',
  'g-bars':              'https://framer.com/m/Gradient-bars-background-PBP7eD.js@1az5mj0YIKKWNeAX6WXF',
  'ambient-background':  'https://framer.com/m/Ambient-Background-VzUF.js@PZ8HSlw6f90FHl45XCV4',
};

const here = path.dirname(fileURLToPath(import.meta.url));
const root = path.join(here, '..', 'app', 'originkit', 'src', 'components', 'framer');

const REMOTE = /^https:\/\/(framerusercontent\.com|framer\.com\/m|bundles\.framercoder\.com)/;

async function vendor(dirName, entryUrl) {
  const dir = path.join(root, dirName);
  fs.rmSync(dir, { recursive: true, force: true });
  fs.mkdirSync(dir, { recursive: true });

  /** url -> local filename, so a module shared by two imports is fetched once. */
  const seen = new Map();
  const names = new Set();

  /** A stable, unique filename from the URL's last segment. */
  function nameFor(url) {
    let base = url.split('?')[0].split('/').pop().replace(/\.js.*$/, '');
    base = base.replace(/[^A-Za-z0-9_-]/g, '_') || 'mod';
    let n = base + '.js';
    let i = 2;
    while (names.has(n)) n = `${base}-${i++}.js`;
    names.add(n);

    return n;
  }

  async function walk(url, forcedName) {
    if (seen.has(url)) return seen.get(url);

    const file = forcedName || nameFor(url);
    seen.set(url, file);

    const res = await fetch(url, { redirect: 'follow' });
    if (!res.ok) throw new Error(`${res.status} ${url}`);
    let src = await res.text();

    /* Every remote import becomes a sibling file. Done depth-first so a module
       is written only after the things it needs exist. */
    const specs = [...new Set([...src.matchAll(/from\s*["']([^"']+)["']/g)].map((m) => m[1]))];
    for (const spec of specs) {
      if (!REMOTE.test(spec)) continue;
      const child = await walk(spec);
      src = src.split(`"${spec}"`).join(`"./${child}"`).split(`'${spec}'`).join(`'./${child}'`);
    }

    fs.writeFileSync(path.join(dir, file), src);

    return file;
  }

  await walk(entryUrl, 'index.js');

  const files = fs.readdirSync(dir);
  const kb = files.reduce((n, f) => n + fs.statSync(path.join(dir, f)).size, 0) / 1024;
  console.log(`${dirName.padEnd(22)} ${String(files.length).padStart(2)} files  ${kb.toFixed(0).padStart(5)}KB`);

  /* A note beside the code saying where it came from, so the next person does
     not have to guess which marketplace listing this is. */
  fs.writeFileSync(path.join(dir, 'SOURCE.txt'),
    `${entryUrl}\n\nFetched by tools/fetch-framer.mjs. Do not hand-edit: only the\n` +
    `remote import URLs are rewritten, everything else is what Framer serves.\n`);
}

const [a, b] = process.argv.slice(2);
if (a === '--all') {
  for (const [name, url] of Object.entries(MANIFEST)) await vendor(name, url);
} else if (a && b) {
  await vendor(a, b);
} else {
  console.error('usage: node tools/fetch-framer.mjs <dir-name> <url>   |   --all');
  process.exit(1);
}
