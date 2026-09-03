/**
 * The MVP Development page's photography.
 *
 *     node tools/mvp-photos.mjs            # generate everything still missing
 *     node tools/mvp-photos.mjs advantage  # just one set
 *     node tools/mvp-photos.mjs --list     # print the plan and the credit cost
 *
 * Why this exists as a script rather than a one-off: the page needs 37
 * photographs and the generator charges per image, so this is written to be
 * resumable. It skips anything already on disk, so a run that stops halfway —
 * or a top-up that only covers part of the set — picks up exactly where it left
 * off. Delete a file to have it made again.
 *
 * It talks to the same Higgsfield endpoint the MCP tools use. The key comes from
 * the environment (HIGGSFIELD_API_KEY / HIGGSFIELD_SECRET) — nothing is
 * committed. Without those it prints the plan and stops, which is the useful
 * behaviour when the credits are not there either.
 *
 * The magazine pages in assets/img/mvp/playbook are NOT here on purpose. They
 * are the pages of a printed playbook — set type on a designed page, which is
 * what tools/mvp-art.mjs makes and what a photograph cannot be.
 */
import { execFileSync } from 'node:child_process';
import { fileURLToPath } from 'node:url';
import path from 'node:path';
import fs from 'node:fs';

const FFMPEG = 'C:/Users/aakas/Downloads/Central Adventure/repo/node_modules/ffmpeg-static/ffmpeg.exe';
const OUT    = path.join(path.dirname(fileURLToPath(import.meta.url)), '..', 'assets', 'img', 'mvp');

/**
 * One house style, so 37 photographs from 37 prompts still read as one shoot.
 * It is the grade the AI Development Company page's photography already uses —
 * cool blue and cyan, dark interiors, shallow depth of field — because these two
 * pages sit in the same site.
 */
const STYLE = 'Editorial technology photography, 35mm, shallow depth of field, natural candid moment. '
  + 'Dark moody interior, cool blue and cyan colour grade with a hint of violet, strong window light. '
  + 'Real people at work, no posing for camera. No text, no logos, no watermarks, no charts or graphs.';

/** set -> [aspect ratio, [filename, subject]...] */
const PLAN = {
  advantage: ['3:2', [
    ['01', 'a small startup product team of four at a glass wall covered in sticky notes and one printed wireframe, mid-discussion, one person pointing at a note'],
    ['02', 'a founder and a finance lead at a laptop in a quiet meeting room, going through a budget on screen, the founder leaning back thinking'],
    ['03', 'a developer watching a live analytics dashboard on a large monitor at dusk, city lights out of focus behind the glass'],
    ['04', 'a two-week sprint board on a wall with cards in three columns, two engineers standing at it moving a card across'],
    ['05', 'a single laptop open on an empty meeting table with one chart on screen, one person alone reading it closely, low warm lamp'],
  ]],

  why: ['3:2', [
    ['01', 'a user researcher watching a real person use a phone app across a small table, notebook open, one-way observation'],
    ['02', 'an almost empty open-plan office late in the evening, one desk lit, one engineer working, the rest of the floor dark'],
    ['03', 'a founder presenting to two investors across a small table, a laptop turned toward them showing a rising line'],
    ['04', 'a senior engineer at a whiteboard drawing a service architecture, another engineer watching with arms folded'],
    ['05', 'a team standing around a monitor reading a result together, mixed expressions, the honest moment of finding out'],
  ]],

  trail: ['2:3', [
    ['01', 'a close, vertical shot of hands using a mobile app, screen glow on the fingers, dark surroundings'],
    ['02', 'a vertical shot of a phone showing a login screen held up in a dim room, blue rim light'],
    ['03', 'a vertical shot of two monitors side on, an API response on one and a terminal on the other'],
    ['04', 'a vertical shot of a wall-mounted dashboard screen in a dark office, someone walking past out of focus'],
    ['05', 'a vertical shot over a support engineer\'s shoulder at a helpdesk queue on screen, headset on the desk'],
  ]],

  industry: ['1:1', [
    ['01', 'a fintech team at a desk with a payments dashboard and a card reader, focused, dark office'],
    ['02', 'a clinician using a tablet at a hospital workstation, monitors behind, calm blue light'],
    ['03', 'a logistics control room with route screens on the wall and a dispatcher at a desk'],
    ['04', 'a retail operations desk with a product catalogue on screen and stock shelves out of focus behind'],
    ['05', 'a small classroom of adult learners at laptops, an instructor beside a screen'],
    ['06', 'an estate agent showing a couple a property on a tablet in an empty modern apartment'],
    ['07', 'a factory floor engineer at a ruggedised terminal beside a production line, machinery in soft focus'],
    ['08', 'a media edit suite, a colourist at a large calibrated monitor, dark room, scopes glowing'],
  ]],

  step: ['3:2', [
    ['01', 'a discovery workshop, five people around a table covered in printed screens and sticky notes, one writing a single number on a card'],
    ['02', 'two people at a wall of feature cards, physically removing most of them and leaving a small group'],
    ['03', 'a designer at a large monitor showing a clickable prototype, a colleague tapping through it on a phone'],
    ['04', 'two engineers pair programming at a desk with two monitors of code, late light'],
    ['05', 'a QA engineer with a rack of test phones and tablets on a bench, one in hand'],
    ['06', 'a team at a screen of usage funnels a fortnight after launch, one person annotating on a tablet'],
  ]],

  reason: ['3:2', [
    ['01', 'a project lead crossing items off a printed scope document with a red pen'],
    ['02', 'two senior engineers at a whiteboard, no juniors, deep in a design argument'],
    ['03', 'a phone in hand showing a fresh build installing, Friday evening office behind'],
    ['04', 'a laptop screen showing a repository transfer confirmation, hands away from the keyboard'],
    ['05', 'a server rack aisle with blue indicator lights, an engineer at the far end'],
    ['06', 'a support engineer on a headset at a monitor, a clock on the wall behind'],
  ]],

  intro: ['21:9', [
    ['01', 'a wide shot of a product team along one side of a long table in a dark modern office, laptops open, one printed roadmap between them, city window light'],
  ]],

  faq: ['3:2', [
    ['01', 'a founder and an engineer talking across a desk, laptop closed, an honest conversation rather than a demo'],
  ]],
};

const ratioOf = (set) => PLAN[set][0];
const itemsOf = (set) => PLAN[set][1];

const sets = process.argv.slice(2).filter((a) => !a.startsWith('--'));
const wanted = sets.length ? sets : Object.keys(PLAN);
const listOnly = process.argv.includes('--list');

/** Everything not already on disk. */
const todo = [];
for (const set of wanted) {
  if (!PLAN[set]) { console.error('unknown set:', set); process.exit(1); }
  for (const [name, subject] of itemsOf(set)) {
    const file = path.join(OUT, 'photo', `${set}-${name}.jpg`);
    if (!fs.existsSync(file)) todo.push({ set, name, subject, file, ratio: ratioOf(set) });
  }
}

console.log(`${todo.length} to generate — 1 credit each on nano_banana, so ${todo.length} credits.`);
if (listOnly || !todo.length) {
  todo.forEach((t) => console.log(`  ${t.set}/${t.name}  [${t.ratio}]  ${t.subject.slice(0, 70)}…`));
  process.exit(0);
}

const KEY    = process.env.HIGGSFIELD_API_KEY;
const SECRET = process.env.HIGGSFIELD_SECRET;
if (!KEY || !SECRET) {
  console.error('\nHIGGSFIELD_API_KEY / HIGGSFIELD_SECRET are not set, so nothing was generated.');
  console.error('Set them and run again, or generate these through the MCP tools instead —');
  console.error('the prompts above are the whole brief.');
  process.exit(2);
}

fs.mkdirSync(path.join(OUT, 'photo'), { recursive: true });

const api = async (url, body) => {
  const r = await fetch(url, {
    method: 'POST',
    headers: { 'content-type': 'application/json', 'hf-api-key': KEY, 'hf-secret': SECRET },
    body: JSON.stringify(body),
  });
  if (!r.ok) throw new Error(`${r.status} ${await r.text()}`);

  return r.json();
};

for (const t of todo) {
  const prompt = `${STYLE} Subject: ${t.subject}.`;
  const job = await api('https://platform.higgsfield.ai/v1/text2image/nano_banana', {
    params: { prompt, aspect_ratio: t.ratio },
  });

  /* Poll until it lands. The endpoint returns a job, not an image. */
  let url = null;
  for (let i = 0; i < 60 && !url; i++) {
    await new Promise((r) => setTimeout(r, 3000));
    const s = await (await fetch(`https://platform.higgsfield.ai/v1/job-sets/${job.id}`, {
      headers: { 'hf-api-key': KEY, 'hf-secret': SECRET },
    })).json();
    url = s?.jobs?.[0]?.results?.raw?.url ?? null;
    if (s?.jobs?.[0]?.status === 'failed') throw new Error(`failed: ${t.set}/${t.name}`);
  }
  if (!url) throw new Error(`timed out: ${t.set}/${t.name}`);

  const png = t.file.replace(/\.jpg$/, '.png');
  fs.writeFileSync(png, Buffer.from(await (await fetch(url)).arrayBuffer()));
  execFileSync(FFMPEG, ['-hide_banner', '-loglevel', 'error', '-y', '-i', png,
    '-vf', 'scale=1400:-1', '-q:v', '4', t.file]);
  fs.unlinkSync(png);

  console.log(`${(t.set + '/' + t.name).padEnd(16)} ${(fs.statSync(t.file).size / 1024).toFixed(0)}KB`);
}
