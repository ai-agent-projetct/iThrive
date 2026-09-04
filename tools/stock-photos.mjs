/**
 * Fill the photography brief from a licensed stock library, and grade the
 * results so they look like one shoot rather than a hundred downloads.
 *
 *     node tools/stock-photos.mjs                 # everything still missing
 *     node tools/stock-photos.mjs poc services    # just these sets
 *     node tools/stock-photos.mjs --list          # print the plan, download nothing
 *     node tools/stock-photos.mjs --dry poc       # search and report, download nothing
 *
 * Works from tools/photo-plan.mjs, the same brief tools/site-photos.mjs uses,
 * so the two are interchangeable per slot: whichever runs first fills the file,
 * and the other skips it.
 *
 * LICENSING — the reason this file only talks to two hosts:
 *
 *   Unsplash and Pexels both publish libraries that are free to use
 *   commercially, with no attribution required, through a documented API. That
 *   is what makes them safe to put on a client's commercial site.
 *
 *   Pinterest is deliberately NOT supported and should not be added. It is a
 *   bookmarking service, not a licensing one: almost everything on it is a
 *   copyrighted work owned by a photographer, brand or publisher who never
 *   licensed it for reuse, and re-hosting those on a commercial site invites a
 *   claim against the client. The same goes for image search results and
 *   scraped galleries.
 *
 * Both providers need a free API key. Put ONE of these in the environment:
 *
 *     UNSPLASH_ACCESS_KEY=...     unsplash.com/developers  ("Access Key")
 *     PEXELS_API_KEY=...          pexels.com/api
 *
 * or drop it in includes/secrets.php's sibling .env — which is git-ignored, and
 * where every other key on this site already lives. Never commit one.
 *
 * THE EDIT — the half that matters as much as the sourcing:
 *
 * A stock photograph dropped straight onto these pages looks like a stock
 * photograph: too bright, too warm, too saturated, and nothing like the eight
 * frames already on the site. Every download is therefore cropped to the slot's
 * ratio and pushed through one grade — cooled, desaturated, darkened, blacks
 * lifted toward the site's #0B0F17 navy — so the set holds together and sits on
 * the page instead of on top of it.
 */
import { execFileSync } from 'node:child_process';
import { fileURLToPath } from 'node:url';
import path from 'node:path';
import fs from 'node:fs';

import { PLAN, TARGET } from './photo-plan.mjs';

const FFMPEG = 'C:/Users/aakas/Downloads/Central Adventure/repo/node_modules/ffmpeg-static/ffmpeg.exe';
const ROOT   = path.join(path.dirname(fileURLToPath(import.meta.url)), '..');

/* ---------------------------------------------------------------------------
 * The grade
 * ------------------------------------------------------------------------ */

/**
 * One filter chain, applied to every download, in this order:
 *
 *   scale+crop   fill the slot's exact ratio from the middle, never letterbox
 *   eq           pull saturation well down and take a little light out; stock
 *                photography is graded for brightness and this page is not
 *   colorbalance cool it — blue up, red down, across shadows/mids/highlights,
 *                which is what turns a warm office into this site's office
 *   curves       lift the black point slightly and hold the top back, so the
 *                darkest pixels land near #0B0F17 rather than at true black
 *
 * Tuned to sit beside the eight gpt-image-2 frames already on the site, which
 * were prompted for the same grade in words.
 */
const GRADE = [
  'eq=contrast=1.05:saturation=0.62:brightness=-0.045:gamma=0.97',
  'colorbalance=rs=-0.14:gs=-0.03:bs=0.17:rm=-0.08:gm=-0.01:bm=0.11:rh=-0.05:bh=0.09',
  "curves=all='0/0.035 0.25/0.22 0.5/0.46 0.75/0.71 1/0.95'",
  /* A vignette last. Stock libraries are full of high-key frames shot against
     white, and cooling one of those still leaves a bright rectangle sitting on
     a near-black page. Pulling the corners down seats it. Mild on purpose —
     enough to close the edges, not enough to read as an effect. */
  'vignette=angle=PI/5:mode=forward',
].join(',');

/**
 * Appended to every search.
 *
 * The single biggest lever on whether a stock photograph fits this site is not
 * the grade, it is which photograph gets picked: a frame shot bright against
 * white cannot be graded into a dark moody interior, it can only be darkened
 * until it looks muddy. Asking the library for the right light in the first
 * place does more than the whole filter chain after it.
 */
const MOOD = 'dark moody office low light';

/* ---------------------------------------------------------------------------
 * Providers
 * ------------------------------------------------------------------------ */

const UNSPLASH = process.env.UNSPLASH_ACCESS_KEY || '';
const PEXELS   = process.env.PEXELS_API_KEY || '';

/**
 * A search term from a slot's subject.
 *
 * The brief's subjects are art direction — full sentences with staging and
 * mood, written for an image model that reads them. A stock search engine wants
 * three or four nouns, so the filler is dropped and the first few content words
 * are kept.
 */
function terms(subject) {
  const stop = new Set(['a', 'an', 'the', 'of', 'in', 'on', 'at', 'to', 'and', 'or', 'with',
    'from', 'for', 'by', 'into', 'over', 'under', 'while', 'as', 'is', 'are', 'their', 'its',
    'one', 'two', 'three', 'four', 'five', 'six', 'his', 'her', 'them', 'they', 'someone',
    'something', 'behind', 'beside', 'between', 'across', 'out', 'up', 'down', 'off', 'that',
    'this', 'it', 'been', 'being', 'be', 'no', 'not', 'own', 'real', 'very', 'just', 'still']);

  return subject
    .toLowerCase()
    .replace(/[^a-z\s-]/g, ' ')
    .split(/\s+/)
    .filter((w) => w.length > 2 && !stop.has(w))
    .slice(0, 5)
    .join(' ');
}

/** Ask Unsplash. Returns a list of candidate image URLs, best first. */
async function searchUnsplash(q, ratio) {
  const orientation = ratio === '2:3' ? 'portrait' : ratio === '1:1' ? 'squarish' : 'landscape';
  const url = 'https://api.unsplash.com/search/photos'
    + `?query=${encodeURIComponent(q + ' ' + MOOD)}&per_page=8&orientation=${orientation}&content_filter=high`;

  const res = await fetch(url, { headers: { Authorization: `Client-ID ${UNSPLASH}` } });
  if (!res.ok) throw new Error(`unsplash ${res.status} ${(await res.text()).slice(0, 120)}`);

  const json = await res.json();

  return (json.results || []).map((r) => ({
    /* raw + explicit params rather than `regular`, so the crop has pixels to
       work with at 21:9 without upscaling. */
    url: `${r.urls.raw}&w=2400&q=85&fm=jpg`,
    credit: `${r.user?.name} (unsplash.com/@${r.user?.username})`,
    /* Unsplash asks API clients to ping this when an image is actually used.
       It is a requirement of their API terms, not analytics we want. */
    downloadPing: r.links?.download_location || null,
  }));
}

/** Ask Pexels. Same shape back. */
async function searchPexels(q, ratio) {
  const orientation = ratio === '2:3' ? 'portrait' : ratio === '1:1' ? 'square' : 'landscape';
  const url = 'https://api.pexels.com/v1/search'
    + `?query=${encodeURIComponent(q + ' ' + MOOD)}&per_page=8&orientation=${orientation}`;

  const res = await fetch(url, { headers: { Authorization: PEXELS } });
  if (!res.ok) throw new Error(`pexels ${res.status} ${(await res.text()).slice(0, 120)}`);

  const json = await res.json();

  return (json.photos || []).map((p) => ({
    url: p.src?.original ? `${p.src.original}?auto=compress&w=2400` : p.src?.large2x,
    credit: `${p.photographer} (${p.photographer_url})`,
    downloadPing: null,
  }));
}

const provider = UNSPLASH ? 'unsplash' : PEXELS ? 'pexels' : null;
const search = UNSPLASH ? searchUnsplash : searchPexels;

/* ---------------------------------------------------------------------------
 * Run
 * ------------------------------------------------------------------------ */

const argv = process.argv.slice(2);
const sets = argv.filter((a) => !a.startsWith('--'));
const listOnly = argv.includes('--list');
const dry = argv.includes('--dry');
const wanted = sets.length ? sets : Object.keys(PLAN);

const todo = [];
for (const set of wanted) {
  if (!PLAN[set]) { console.error('unknown set:', set); process.exit(1); }
  const { dir, ratio, items } = PLAN[set];
  for (const [name, subject] of items) {
    const file = path.join(ROOT, dir, name + '.jpg');
    if (!fs.existsSync(file)) todo.push({ set, name, subject, file, ratio, dir });
  }
}

console.log(`${todo.length} slots still empty.`);

if (listOnly) {
  todo.forEach((t) => console.log(`  ${t.dir}/${t.name}.jpg  [${t.ratio}]  "${terms(t.subject)}"`));
  process.exit(0);
}

if (!provider) {
  console.error('\nNo stock API key found, so nothing can be downloaded.');
  console.error('Set ONE of these and run again:');
  console.error('  UNSPLASH_ACCESS_KEY   free at unsplash.com/developers  ("Access Key")');
  console.error('  PEXELS_API_KEY        free at pexels.com/api');
  console.error('\nBoth licences allow commercial use with no attribution.');
  process.exit(1);
}

console.log(`provider: ${provider}\n`);

const tmp = path.join(ROOT, '.photo-tmp');
fs.mkdirSync(tmp, { recursive: true });

/* Who took what, written beside the images. Neither licence requires credit,
   but knowing where a picture came from is worth having when one has to be
   swapped later. */
const creditsFile = path.join(ROOT, 'assets', 'img', 'CREDITS.md');
const credits = [];

let made = 0;
let failed = 0;

for (const t of todo) {
  const q = terms(t.subject);

  let hits;
  try {
    hits = await search(q, t.ratio);
  } catch (e) {
    failed++;
    console.error(`SEARCH FAIL ${t.set}/${t.name}: ${e.message}`);
    /* A bad key fails identically on every slot; stop rather than do it 117 times. */
    if (/401|403/.test(e.message)) { console.error('\nThe key was rejected — stopping.'); break; }
    continue;
  }

  if (!hits.length) {
    failed++;
    console.error(`NO RESULT   ${t.set}/${t.name}  "${q}"`);
    continue;
  }

  const pick = hits[0];

  if (dry) {
    console.log(`${(t.set + '/' + t.name).padEnd(30)} "${q}"  ->  ${pick.credit}`);
    continue;
  }

  fs.mkdirSync(path.dirname(t.file), { recursive: true });
  const raw = path.join(tmp, `${t.set}-${t.name}.src`);

  try {
    const img = await fetch(pick.url);
    if (!img.ok) throw new Error(`download ${img.status}`);
    fs.writeFileSync(raw, Buffer.from(await img.arrayBuffer()));

    const [w, h] = TARGET[t.ratio] || [1400, 933];
    execFileSync(FFMPEG, ['-hide_banner', '-loglevel', 'error', '-y', '-i', raw,
      '-vf', `scale=${w}:${h}:force_original_aspect_ratio=increase,crop=${w}:${h},${GRADE}`,
      '-q:v', '4', t.file]);

    fs.unlinkSync(raw);
  } catch (e) {
    failed++;
    console.error(`FAILED      ${t.set}/${t.name}: ${String(e.message).slice(0, 100)}`);
    continue;
  }

  /* Tell Unsplash the picture was used, which their API terms ask for. Best
     effort: a failed ping is not a reason to lose the image. */
  if (pick.downloadPing && UNSPLASH) {
    fetch(pick.downloadPing, { headers: { Authorization: `Client-ID ${UNSPLASH}` } }).catch(() => {});
  }

  credits.push(`- \`${t.dir}/${t.name}.jpg\` — ${pick.credit}, via ${provider}`);
  made++;
  console.log(`[${made}/${todo.length}] ${(t.set + '/' + t.name).padEnd(30)} `
    + `${(fs.statSync(t.file).size / 1024).toFixed(0).padStart(4)}KB  ${pick.credit}`);
}

if (credits.length) {
  const head = fs.existsSync(creditsFile)
    ? fs.readFileSync(creditsFile, 'utf8').trimEnd() + '\n'
    : '# Photography credits\n\nSourced through tools/stock-photos.mjs. Both Unsplash and Pexels\n'
      + 'allow commercial use without attribution; this list exists so a picture\n'
      + 'can be traced and swapped, not because a credit is owed.\n';
  fs.writeFileSync(creditsFile, head + credits.join('\n') + '\n');
}

console.log(`\ndone: ${made} made, ${failed} failed, of ${todo.length}`);
