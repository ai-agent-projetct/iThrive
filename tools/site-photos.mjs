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

/**
 * dir       where the files go, relative to the repo root
 * ratio     aspect ratio asked of the model
 * items     [filename without extension, subject]
 *
 * The `photo/` subfolder is the convention includes/components/page-figure.php
 * looks in first, so a photograph landing there replaces the drawing with no
 * edit to any page.
 */
const PLAN = {
  services: {
    dir: 'assets/img/pages/services/photo', ratio: '21:9', items: [
      ['ai-for-ecommerce', 'a retail merchandising team at a wall of screens showing product grids, one person pointing at a row'],
      ['cloud-devops', 'two platform engineers at a standing desk with terminal windows and a deploy pipeline on a wall screen'],
      ['custom-product-development', 'a product team around a table of printed screens and a laptop, mid-argument about a flow'],
      ['dedicated-engineering-team', 'a ring-fenced squad of five at adjoining desks, one shared board behind them'],
      ['ecommerce-development', 'a checkout flow being tested on a phone held in front of a monitor of order data'],
      ['micro-saas-development', 'two founders at a small desk, one laptop each, a subscription dashboard on the wall'],
      ['mvp-development', 'a small startup team at a glass wall of sticky notes, narrowing a long list to a short one'],
      ['on-demand-resources', 'a specialist engineer joining a team mid-project, being shown a codebase on a monitor'],
      ['poc-development', 'a single engineer at a bench with a laptop and a whiteboard of one question'],
      ['product-modernization', 'an engineer beside an old rack and a new cloud dashboard, comparing the two'],
      ['reactjs-development', 'a front-end developer at a wide monitor of component work, a design file open beside it'],
      ['ai-native-product-development', 'a team watching a model evaluation run on a large screen in a dark room'],
    ],
  },

  apps: {
    dir: 'assets/img/pages/apps/photo', ratio: '21:9', items: [
      ['mobile-architecture', 'a mobile engineer with a phone in one hand and an API response on the monitor behind'],
      ['mobile-release', 'a bench of test phones and tablets mid-release, one engineer checking a build'],
      ['flutter-codebase', 'one laptop of Dart code with the same app running on an iPhone and an Android beside it'],
      ['flutter-flavours', 'three phones side by side showing dev, staging and production builds of one app'],
    ],
  },

  capabilities: {
    dir: 'assets/img/capabilities/photo', ratio: '3:2', items: [
      ['cap-01', 'an engineer tracing a multi-step agent workflow on a large monitor, a colleague watching'],
      ['cap-02', 'a researcher comparing a document on the desk with a retrieval result on screen'],
      ['cap-03', 'a test run finishing on a big screen while two engineers read the result'],
      ['cap-04', 'a security engineer at a terminal reviewing a blocked request, calm and deliberate'],
      ['cap-05', 'a reviewer working a queue on screen, approving one item and correcting another'],
      ['cap-06', 'an operations engineer watching live telemetry on a wall of monitors in a dark room'],
    ],
  },

  'aidev-stack': {
    dir: 'assets/img/aidev/stack/photo', ratio: '4:3', items: [
      ['layer-01', 'a data engineer at a terminal ingesting documents, storage racks softly lit behind'],
      ['layer-02', 'a GPU server aisle with an engineer at a laptop between the racks'],
      ['layer-03', 'a researcher reading a long document beside a monitor of search results'],
      ['layer-04', 'two engineers watching an autonomous run step through a task on a big screen'],
      ['layer-05', 'a compliance reviewer with a printed policy and an audit log on screen'],
      ['layer-06', 'a support engineer on a headset watching uptime dashboards at night'],
    ],
  },

  /* The MVP page. Its own PHP already prefers assets/img/mvp/photo. */
  mvp: {
    dir: 'assets/img/mvp/photo', ratio: '3:2', items: [
      ['advantage-02', 'a founder and a finance lead at a laptop in a quiet meeting room, going through a budget'],
      ['advantage-03', 'a developer watching a live analytics dashboard at dusk, city lights out of focus behind'],
      ['advantage-04', 'a sprint board on a wall with cards in three columns, two engineers moving one across'],
      ['advantage-05', 'a single laptop on an empty meeting table, one person alone reading a result'],
      ['why-01', 'a researcher watching a real person use a phone app across a small table, notebook open'],
      ['why-02', 'an almost empty open-plan office late in the evening, one desk lit and one engineer working'],
      ['why-03', 'a founder presenting to two investors across a small table, a laptop turned toward them'],
      ['why-04', 'a senior engineer at a whiteboard drawing an architecture, another watching with arms folded'],
      ['why-05', 'a team standing around a monitor reading a result together, mixed expressions'],
      ['step-01', 'a discovery workshop, five people around a table of printed screens, one writing on a card'],
      ['step-02', 'two people at a wall of feature cards, removing most and leaving a small group'],
      ['step-03', 'a designer at a monitor of a prototype while a colleague taps through it on a phone'],
      ['step-04', 'two engineers pair programming at a desk of two monitors, late light'],
      ['step-05', 'a QA engineer with a rack of test devices on a bench, one in hand'],
      ['step-06', 'a team at a screen of usage funnels a fortnight after launch, one annotating on a tablet'],
      ['reason-01', 'a project lead crossing items off a printed scope document with a pen'],
      ['reason-02', 'two senior engineers at a whiteboard, deep in a design argument'],
      ['reason-03', 'a phone in hand showing a fresh build installing, Friday evening office behind'],
      ['reason-04', 'hands away from a keyboard, a repository transfer confirmed on the laptop screen'],
      ['reason-05', 'a server rack aisle with blue indicator lights, an engineer at the far end'],
      ['reason-06', 'a support engineer on a headset at a monitor, a clock on the wall behind'],
      ['industry-01', 'a fintech team at a desk with a payments dashboard and a card reader'],
      ['industry-02', 'a clinician using a tablet at a hospital workstation, monitors behind'],
      ['industry-03', 'a logistics control room with route screens on the wall and a dispatcher at a desk'],
      ['industry-04', 'a retail operations desk with stock shelves out of focus behind'],
      ['industry-05', 'a small classroom of adult learners at laptops, an instructor beside a screen'],
      ['industry-06', 'an estate agent showing a couple a property on a tablet in an empty modern apartment'],
      ['industry-07', 'a factory floor engineer at a ruggedised terminal beside a production line'],
      ['industry-08', 'a media edit suite, a colourist at a large calibrated monitor, dark room'],
      ['intro-01', 'a wide shot of a product team along one side of a long table in a dark office'],
      ['faq-01', 'a founder and an engineer talking across a desk, laptop closed, an honest conversation'],
    ],
  },

  /* Portrait, because the image trail lays its pictures out tall. */
  'mvp-trail': {
    dir: 'assets/img/mvp/photo', ratio: '2:3', items: [
      ['trail-01', 'a close vertical shot of hands using a mobile app, screen glow on the fingers'],
      ['trail-02', 'a vertical shot of a phone showing a login screen held up in a dim room'],
      ['trail-03', 'a vertical shot of two monitors side on, an API response and a terminal'],
      ['trail-04', 'a vertical shot of a wall-mounted dashboard in a dark office, someone walking past'],
      ['trail-05', 'a vertical shot over a support engineer at a helpdesk queue, headset on the desk'],
    ],
  },

  /*
   * The card grids that were still icon-only after the bands were done — the
   * two /solutions feature grids, the about values, the careers perks and the
   * process commitments. includes/components/feature-card.php looks these up
   * by the slug in the content array and falls back to the icon tile until the
   * file lands, so nothing breaks part-way through a run.
   */
  cards: {
    dir: 'assets/img/cards/photo', ratio: '3:2', items: [
      ['about-01', 'a team reading one number on a large wall screen, nobody celebrating, just assessing'],
      ['about-02', 'two colleagues disagreeing across a whiteboard early in a project, respectful and direct'],
      ['about-03', 'an engineer walking a client through a runbook on a shared monitor'],
      ['about-04', 'a plain, well-kept server cabinet with an engineer closing its door'],

      ['careers-01', 'an engineer watching an autonomous agent work through a task on a large screen'],
      ['careers-02', 'four people at one cluster of desks, no partitions, talking across them'],
      ['careers-03', 'an office at a normal hour with people leaving, one lamp still on'],
      ['careers-04', 'an engineer at a desk with a technical book open beside a laptop of course material'],

      ['insights-01', 'a data engineer joining several source systems on one wide monitor'],
      ['insights-02', 'someone typing a plain-language question at a laptop, an answer forming above'],
      ['insights-03', 'a marketing analyst comparing channel performance across two screens'],
      ['insights-04', 'an alert catching an operator mid-stride in a dim monitoring room'],
      ['insights-05', 'a weekly planning meeting with a short ranked list on the screen'],
      ['insights-06', 'an analyst studying customer segments on a monitor, notes on paper beside'],

      ['aichat-01', 'a visitor browsing a website on a laptop while an assistant panel sits open beside'],
      ['aichat-02', 'a support lead checking an answer against the source document open on the desk'],
      ['aichat-03', 'a sales engineer taking notes while a qualification conversation runs on screen'],
      ['aichat-04', 'a salesperson picking up a headset as a hot lead notification arrives'],
      ['aichat-05', 'a calendar booking being confirmed on a laptop, a diary open beside it'],
      ['aichat-06', 'a security engineer reviewing a filtered conversation log at a terminal'],

      ['process-01', 'one figure written large on a whiteboard with two people standing in front of it'],
      ['process-02', 'a fortnightly demo, a laptop mirrored to a screen, four people watching'],
      ['process-03', 'an engineer checking backup and error-tracking status before a first deploy'],
      ['process-04', 'a discovery session where one person is clearly pushing back on a proposal'],
      ['process-05', 'a printed architecture document beside a laptop, being annotated by hand'],
      ['process-06', 'a laptop showing a repository being transferred, two people shaking hands behind'],
    ],
  },

  /* Blog thumbnails. The six post cards had icons and nothing else. */
  blog: {
    dir: 'assets/img/blog/photo', ratio: '3:2', items: [
      ['post-01', 'an architect at a whiteboard separating one service out from a large existing system'],
      ['post-02', 'an engineer watching an evaluation suite finish, reading the pass and fail counts'],
      ['post-03', 'an old system and a new one side by side on two monitors, one engineer between them'],
      ['post-04', 'a clothing warehouse aisle with someone measuring a garment beside a laptop'],
      ['post-05', 'a hospital reception workstation with a scheduling screen and a member of staff'],
      ['post-06', 'a single laptop of Python code with a model training run in a second window'],
    ],
  },
};

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

const TARGET = {
  '21:9': [1500, 643], '3:2': [1400, 933], '4:3': [1200, 900],
  '1:1': [1000, 1000], '2:3': [900, 1350],
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
