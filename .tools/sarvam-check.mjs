/**
 * Sarvam probe. Run in a window where SARVAM_API_KEY is set:
 *
 *     node .tools/sarvam-check.mjs
 *
 * Sarvam rejects a whole request with 400 and names ONE offending field at a
 * time, so fixing them one per round trip is slow. This walks the candidates
 * itself and reports the first combination that returns audio.
 *
 * The key is never printed or written — only its length.
 */

import { writeFileSync } from 'node:fs';

const key = process.env.SARVAM_API_KEY || '';
const out = [];
const say = (l) => { out.push(l); console.log(l); };
const done = () => writeFileSync('.tools/sarvam-result.txt', out.join('\n'), 'utf8');

say(`key present: ${key ? 'yes' : 'NO'}  length: ${key.length}`);
if (!key) { say('No key in this window.'); done(); process.exit(0); }

const models   = ['bulbul:v3', 'bulbul:v2'];
const speakers = ['anushka', 'vidya', 'manisha', 'arya', 'karun', 'hitesh', 'abhilash'];

let win = null;

outer:
for (const model of models) {
  for (const speaker of speakers) {
    const body = { text: 'வணக்கம்', target_language_code: 'ta-IN', speaker, model };
    try {
      const r = await fetch('https://api.sarvam.ai/text-to-speech', {
        method: 'POST',
        headers: { 'content-type': 'application/json', 'api-subscription-key': key },
        body: JSON.stringify(body),
      });
      if (r.ok) {
        const data = await r.json().catch(() => ({}));
        const audio = data?.audios?.[0];
        say(`OK   model=${model} speaker=${speaker} -> ${audio ? audio.length + ' b64 chars' : 'no audio field'}`);
        if (audio) { win = { model, speaker }; break outer; }
      } else {
        const t = await r.text();
        say(`${r.status}  model=${model} speaker=${speaker} -> ${t.slice(0, 180)}`);
      }
    } catch (e) {
      say(`ERR  model=${model} speaker=${speaker} -> ${e.message}`);
    }
  }
}

say(win ? `\nWORKING COMBINATION: model=${win.model} speaker=${win.speaker}`
        : '\nNo combination returned audio.');
done();
console.log('\nwritten to .tools/sarvam-result.txt');
