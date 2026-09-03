/**
 * Run tools/site-photos.mjs over and over until the brief is empty.
 *
 *     node tools/photos-until-done.mjs
 *
 * site-photos.mjs is resumable — it skips anything already on disk — but it
 * builds its worklist once at startup, so slots added to the brief after it
 * began, and slots whose generation failed, are only picked up by a fresh run.
 * This just keeps starting fresh runs until there is nothing left.
 *
 * It waits for any site-photos.mjs already running to finish first. Two of them
 * at once is what caused the first two failures of the night: both shell out to
 * the same codex CLI, and the second call loses.
 *
 * Between passes it pauses, because an immediate retry of a slot that just
 * failed tends to fail the same way — a rate limit needs time, not another
 * request. It gives up on a pass that generates nothing, so a permanently
 * broken slot cannot spin forever.
 */
import { execFileSync, spawnSync } from 'node:child_process';
import { fileURLToPath } from 'node:url';
import path from 'node:path';

const HERE = path.dirname(fileURLToPath(import.meta.url));
const JOB  = path.join(HERE, 'site-photos.mjs');

const sleep = (ms) => Atomics.wait(new Int32Array(new SharedArrayBuffer(4)), 0, 0, ms);

/** Is another site-photos.mjs already going? */
function siblingRunning() {
  const r = spawnSync('powershell', ['-NoProfile', '-Command',
    "(Get-CimInstance Win32_Process -Filter \"Name='node.exe'\" |"
    + " Where-Object { $_.CommandLine -like '*site-photos.mjs*' } | Measure-Object).Count"],
    { encoding: 'utf8' });
  return Number(String(r.stdout).trim()) > 0;
}

/** How many slots the brief still wants. */
function remaining() {
  const out = execFileSync(process.execPath, [JOB, '--list'], { encoding: 'utf8' });
  const m = out.match(/^(\d+) to generate/m);
  return m ? Number(m[1]) : 0;
}

while (siblingRunning()) {
  console.log('waiting for the run already in progress…');
  sleep(60_000);
}

/* Ten passes is far more than a healthy night needs; it is a stop, not a plan. */
for (let pass = 1; pass <= 10; pass++) {
  const before = remaining();
  if (before === 0) { console.log('brief complete.'); break; }

  console.log(`\n=== pass ${pass}: ${before} left ===`);
  const r = spawnSync(process.execPath, [JOB], { stdio: 'inherit' });

  /* Exit 2 is site-photos saying the codex quota is spent, not that this slot
     went wrong. The reset is days away, so another pass buys nothing. */
  if (r.status === 2) {
    console.log('\nquota exhausted — stopping. Rerun this once codex resets.');
    break;
  }

  const after = remaining();
  console.log(`pass ${pass}: ${before - after} made, ${after} left`);

  if (after === 0) { console.log('brief complete.'); break; }
  if (after === before) {
    console.log('pass made nothing — stopping rather than looping on a broken slot.');
    break;
  }
  sleep(120_000);
}
