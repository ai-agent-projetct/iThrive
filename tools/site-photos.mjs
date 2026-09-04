/**
 * Every photograph the site still wants, in one brief.
 *
 *     node tools/site-photos.mjs             # generate everything still missing
 *     node tools/site-photos.mjs services    # just one set
 *     node tools/site-photos.mjs --list      # print the plan and the credit cost
 *
 * Most of the site is already photographed — the twenty-one bands in
 * assets/img/pages and the whole assets/img/aidev set are real pictures. What
 * is left is the work that had to be DRAWN because no image generator was
 * reachable at the time:
 *
 *   services/      12 service-detail bands   (delivery-spine diagrams)
 *   apps/           4 mobile + Flutter bands (architecture and pipeline diagrams)
 *   capabilities/   6 panels on the two /solutions pages
 *   aidev-stack/    6 cards in the AI page's six-layer carousel
 *   mvp/…          36 slots across the MVP page
 *
 * Deliberately NOT here:
 *   - assets/img/aidev/cards — the credential cards set type like "ISO/IEC
 *     27001" and "TensorRT". A photograph cannot render those words, which is
 *     why they were designed cards in the first place.
 *   - assets/img/mvp/playbook — pages of a printed playbook, same reason.
 *   - the case-study sets, which the brief excludes.
 *
 * Resumable on purpose: it skips anything already on disk, so a run that stops
 * halfway, or a top-up that only covers part of the set, picks up exactly where
 * it left off. Delete a file to have it made again.
 *
 * The backend is OpenAI gpt-image-2 through the codex CLI, which authenticates
 * against the user's ChatGPT subscription — no API key and no image credits,
 * which is what makes finishing a set of this size practical. Each call takes a
 * few minutes because codex reasons before it draws, so this is a background
 * job, not something to wait on.
 */
import { execFileSync } from 'node:child_process';
import { fileURLToPath } from 'node:url';
import path from 'node:path';
import fs from 'node:fs';

import { PLAN, TARGET } from './photo-plan.mjs';

const FFMPEG = 'C:/Users/aakas/Downloads/Central Adventure/repo/node_modules/ffmpeg-static/ffmpeg.exe';
const ROOT   = path.join(path.dirname(fileURLToPath(import.meta.url)), '..');

/**
 * One house style, so sixty-odd photographs from sixty-odd prompts still read
 * as a single shoot — and as the same shoot as assets/img/pages, which is
 * already on the site.
 */
const STYLE = 'Editorial technology photography, 35mm, shallow depth of field, natural candid moment. '
  /* The grade is the site palette, named in hex so every frame lands on the
     same dark navy the pages are painted in rather than merely "dark and
     blue". Shadows at #0B0F17, practicals and screen spill at #00F2FE, the
     violet only as a rim. Warm light anywhere in frame breaks the set. */
  + 'Colour grade: near-black desaturated navy shadows #0B0F17, cyan #00F2FE practical and screen light, '
  + 'a violet #7C5CFF rim on edges only. Cool white balance throughout, no warm or orange tones anywhere. '
  + 'Dark moody interior, low-key lighting, strong cool window light. '
  + 'Real people at work in a modern Indian software office, no posing for camera. '
  + 'No text, no logos, no watermarks, no charts, no graphs, no diagrams, no UI screenshots.';

/*
 * The brief itself lives in tools/photo-plan.mjs, because tools/stock-photos.mjs
 * works from the same list and a second copy here would drift from it.
 */

const sets = process.argv.slice(2).filter((a) => !a.startsWith('--'));
const wanted = sets.length ? sets : Object.keys(PLAN);
const listOnly = process.argv.includes('--list');

const todo = [];
for (const set of wanted) {
  if (!PLAN[set]) { console.error('unknown set:', set); process.exit(1); }
  const { dir, ratio, items } = PLAN[set];
  for (const [name, subject] of items) {
    const file = path.join(ROOT, dir, name + '.jpg');
    if (!fs.existsSync(file)) todo.push({ set, name, subject, file, ratio, dir });
  }
}

console.log(`${todo.length} to generate, free on the ChatGPT subscription — a few minutes each.`);
if (listOnly || !todo.length) {
  todo.forEach((t) => console.log(`  ${t.dir}/${t.name}.jpg  [${t.ratio}]  ${t.subject.slice(0, 62)}…`));
  process.exit(0);
}

const BRIDGE = path.join(process.env.HOME || process.env.USERPROFILE,
  '.claude', 'skills', 'gpt-image-bridge', 'bin', 'gpt-image-2');

/*
 * gpt-image-2 draws at its own three sizes, so ask for the nearest one and let
 * ffmpeg take the target ratio out of the middle. Cropping a good photograph is
 * safer than asking the model for an aspect it does not offer and being handed
 * a letterboxed one back.
 */
const SOURCE = {
  '21:9': '1536x1024', '3:2': '1536x1024', '4:3': '1536x1024',
  '1:1': '1024x1024', '2:3': '1024x1536',
};


const tmp = path.join(ROOT, '.photo-tmp');
fs.mkdirSync(tmp, { recursive: true });

let made = 0;
let failed = 0;
let quota = false;   /* set when codex says the account is out, which ends the run */

for (const t of todo) {
  fs.mkdirSync(path.dirname(t.file), { recursive: true });

  /* POSIX separators: the path is handed to a bash script. */
  const png = path.join(tmp, `${t.set}-${t.name}.png`).split(path.sep).join('/');
  const prompt = `${STYLE} Subject: ${t.subject}. Cinematic, high detail.`;

  try {
    /* Fifteen minutes: codex reasons before it draws, and a slow call is
       still cheaper than losing the slot and regenerating it later. */
    /* Through bash, not directly. The wrapper is a shell script with a
       shebang, and Windows has no idea what to do with that — spawning it
       straight from node is an instant ENOENT on all 64. */
    execFileSync('bash', [BRIDGE, prompt, png, '--size', SOURCE[t.ratio] || '1536x1024'],
      { stdio: ['ignore', 'pipe', 'pipe'], timeout: 15 * 60 * 1000 });
  } catch (e) {
    /*
     * A quota that has run out is not this slot failing, it is every remaining
     * slot failing, and the reset is days away. Say so once and stop: the first
     * night this ran, 57 of 60 slots each took a full call to find that out,
     * and the log read like 57 unrelated faults instead of one exhausted
     * account. The wrapper prints codex's own message, reset time and all, so
     * the useful line is quoted rather than summarised.
     */
    const said = String(e.stderr || '') + String(e.stdout || '') + String(e.message || '');
    const limit = said.match(/[^\n]*usage limit[^\n]*/i);
    if (limit) {
      console.error(`\nSTOPPED at ${t.set}/${t.name} — the codex image quota is spent.`);
      console.error(`  ${limit[0].trim()}`);
      console.error(`  ${todo.length - made} of ${todo.length} still to do; rerun when it resets and`);
      console.error('  they will be picked up, since finished ones are skipped.');
      quota = true;
      break;
    }

    failed++;
    console.error(`FAILED   ${t.set}/${t.name}: ${String(e.message).slice(0, 110)}`);
    continue;
  }

  if (!fs.existsSync(png)) {
    failed++;
    console.error(`NO FILE  ${t.set}/${t.name}`);
    continue;
  }

  const [w, h] = TARGET[t.ratio] || [1400, 933];
  execFileSync(FFMPEG, ['-hide_banner', '-loglevel', 'error', '-y', '-i', png,
    '-vf', `scale=${w}:${h}:force_original_aspect_ratio=increase,crop=${w}:${h}`,
    '-q:v', '4', t.file]);
  fs.unlinkSync(png);

  made++;
  const kb = (fs.statSync(t.file).size / 1024).toFixed(0);
  console.log(`[${made}/${todo.length}] ${(t.set + '/' + t.name).padEnd(30)} ${kb}KB`);
}

console.log(`\ndone: ${made} made, ${failed} failed, of ${todo.length}`);

/* Exit 2 for an exhausted quota, so photos-until-done.mjs can tell "nothing
   left to do" apart from "nothing I can do until the quota resets", and stop
   rather than spending its remaining passes rediscovering the same thing. */
if (quota) process.exit(2);
