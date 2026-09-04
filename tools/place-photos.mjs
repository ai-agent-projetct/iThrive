/**
 * Put generated images into their slots.
 *
 *     node tools/place-photos.mjs <incoming-dir>          # place everything in it
 *     node tools/place-photos.mjs <incoming-dir> --grade  # and colour-grade on the way
 *     node tools/place-photos.mjs <file> poc/open-01      # place one, named explicitly
 *
 * The other two generators fetch AND place. This one only places, because the
 * third route does not go through a script at all: imagine.art and openart.ai
 * are MCP servers, so the generating happens through their tools in a session
 * and what comes back is a pile of files with no idea where they belong. This
 * turns that pile into the brief's slots — right crop, right ratio, right name,
 * right directory — in one command.
 *
 * Incoming files are matched by name: `<set>-<name>.<ext>`, so `poc-open-01.png`
 * lands as the poc set's open-01 at its 3:2 crop. Set names are matched longest
 * first, because two of them (`aidev-stack`, `mvp-trail`) contain a hyphen and
 * a naive split on the first one would file them under a set that does not
 * exist.
 *
 * --grade applies the same cooling pass tools/stock-photos.mjs uses. Off by
 * default: an image generated from this site's brief was already asked for the
 * palette in words, and grading it twice takes it grey.
 */
import { execFileSync } from 'node:child_process';
import { fileURLToPath } from 'node:url';
import path from 'node:path';
import fs from 'node:fs';

import { PLAN, TARGET } from './photo-plan.mjs';

const FFMPEG = 'C:/Users/aakas/Downloads/Central Adventure/repo/node_modules/ffmpeg-static/ffmpeg.exe';
const ROOT   = path.join(path.dirname(fileURLToPath(import.meta.url)), '..');

/* Same chain as tools/stock-photos.mjs, minus the crop, which is applied here
   per slot. Kept in step by hand deliberately: one is for photographs that were
   never asked to match, the other for images that already were. */
const GRADE = [
  'eq=contrast=1.05:saturation=0.62:brightness=-0.045:gamma=0.97',
  'colorbalance=rs=-0.14:gs=-0.03:bs=0.17:rm=-0.08:gm=-0.01:bm=0.11:rh=-0.05:bh=0.09',
  "curves=all='0/0.035 0.25/0.22 0.5/0.46 0.75/0.71 1/0.95'",
  'vignette=angle=PI/5:mode=forward',
].join(',');

/** Longest first, so `mvp-trail` is tried before `mvp`. */
const SETS = Object.keys(PLAN).sort((a, b) => b.length - a.length);

/** Find the slot a bare filename refers to, or null. */
function slotFor(stem) {
  for (const set of SETS) {
    if (!stem.startsWith(set + '-')) continue;
    const name = stem.slice(set.length + 1);
    const hit = PLAN[set].items.find(([n]) => n === name);
    if (hit) return { set, name, ratio: PLAN[set].ratio, dir: PLAN[set].dir };
  }

  return null;
}

/** Crop to the slot's ratio and write the JPEG. */
function place(src, slot, grade) {
  const [w, h] = TARGET[slot.ratio] || [1400, 933];
  const out = path.join(ROOT, slot.dir, slot.name + '.jpg');
  fs.mkdirSync(path.dirname(out), { recursive: true });

  const vf = `scale=${w}:${h}:force_original_aspect_ratio=increase,crop=${w}:${h}`
    + (grade ? ',' + GRADE : '');

  execFileSync(FFMPEG, ['-hide_banner', '-loglevel', 'error', '-y', '-i', src,
    '-vf', vf, '-q:v', '4', out]);

  return out;
}

const argv = process.argv.slice(2);
const grade = argv.includes('--grade');
const args = argv.filter((a) => !a.startsWith('--'));

if (!args.length) {
  console.error('usage: node tools/place-photos.mjs <incoming-dir> [--grade]');
  console.error('       node tools/place-photos.mjs <file> <set>/<name> [--grade]');
  process.exit(1);
}

/* One file, slot named explicitly. */
if (args.length === 2) {
  const [file, ref] = args;
  const [set, name] = ref.split('/');
  if (!PLAN[set] || !PLAN[set].items.some(([n]) => n === name)) {
    console.error(`no such slot: ${ref}`);
    process.exit(1);
  }
  const out = place(file, { set, name, ratio: PLAN[set].ratio, dir: PLAN[set].dir }, grade);
  console.log(`${ref}  ->  ${path.relative(ROOT, out)}  ${(fs.statSync(out).size / 1024).toFixed(0)}KB`);
  process.exit(0);
}

/* A directory of <set>-<name>.<ext>. */
const dir = args[0];
if (!fs.existsSync(dir) || !fs.statSync(dir).isDirectory()) {
  console.error(`not a directory: ${dir}`);
  process.exit(1);
}

let placed = 0;
const skipped = [];

for (const f of fs.readdirSync(dir)) {
  if (!/\.(png|jpe?g|webp)$/i.test(f)) continue;

  const slot = slotFor(f.replace(/\.[^.]+$/, ''));
  if (!slot) { skipped.push(f); continue; }

  const out = place(path.join(dir, f), slot, grade);
  placed++;
  console.log(`${(slot.set + '/' + slot.name).padEnd(30)} ${(fs.statSync(out).size / 1024).toFixed(0).padStart(4)}KB`);
}

console.log(`\nplaced ${placed}${grade ? ' (graded)' : ''}.`);
if (skipped.length) {
  console.log(`unmatched (name them <set>-<name>.png): ${skipped.slice(0, 8).join(', ')}`
    + (skipped.length > 8 ? ` +${skipped.length - 8} more` : ''));
}
