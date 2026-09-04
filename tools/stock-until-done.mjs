/**
 * Keep running tools/stock-photos.mjs until the brief is full.
 *
 *     node tools/stock-until-done.mjs           # every set
 *     node tools/stock-until-done.mjs poc apps  # only these
 *
 * An Unsplash demo key allows 50 searches an hour, and the brief is well over
 * a hundred slots, so filling it is a matter of waiting out several windows
 * rather than of doing anything cleverer. This waits them out.
 *
 * A pass that stops on the rate limit sleeps until the window rolls over and
 * goes again. A pass that makes nothing stops for good — that is a real fault
 * (a rejected key, no network, every remaining query missing) and no amount of
 * waiting fixes it.
 *
 * Same shape as tools/photos-until-done.mjs, which does this for the codex
 * route, and for the same reason: stock-photos builds its worklist once at
 * startup, so anything added or retried needs a fresh run.
 */
import { spawnSync } from 'node:child_process';
import { fileURLToPath } from 'node:url';
import path from 'node:path';

const HERE = path.dirname(fileURLToPath(import.meta.url));
const JOB  = path.join(HERE, 'stock-photos.mjs');

const sets = process.argv.slice(2).filter((a) => !a.startsWith('--'));

const sleep = (ms) => Atomics.wait(new Int32Array(new SharedArrayBuffer(4)), 0, 0, ms);

/** How many slots the brief still wants. */
function remaining() {
  const r = spawnSync(process.execPath, [JOB, '--list', ...sets], { encoding: 'utf8' });
  const m = String(r.stdout).match(/^(\d+) slots to do/m);

  return m ? Number(m[1]) : 0;
}

/* Sixty-two minutes: the window is an hour, and a couple of minutes of margin
   costs nothing next to spending a whole pass discovering it was still shut. */
const WINDOW_MS = 62 * 60 * 1000;

for (let pass = 1; pass <= 12; pass++) {
  const before = remaining();
  if (before === 0) { console.log('\nbrief complete.'); break; }

  console.log(`\n=== pass ${pass}: ${before} slots left ===`);
  const r = spawnSync(process.execPath, [JOB, ...sets], { stdio: 'inherit' });

  const after = remaining();
  console.log(`pass ${pass}: ${before - after} made, ${after} left`);

  if (after === 0) { console.log('\nbrief complete.'); break; }

  /*
   * Exit 3 means the hourly window is shut, and that is the one case where a
   * pass that made nothing should still wait. Judging by the slot count alone
   * got this wrong: the first pass hit the limit on its very first request,
   * made nothing, and the runner called it a permanent fault and quit.
   */
  if (r.status !== 3 && after === before) {
    console.log('pass made nothing and was not rate-limited — stopping; this needs a person.');
    break;
  }

  const mins = Math.round(WINDOW_MS / 60000);
  console.log(`waiting ${mins} min for the next Unsplash window…`);
  sleep(WINDOW_MS);
}
