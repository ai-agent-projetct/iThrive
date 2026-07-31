/**
 * Dev server for the Ithrive site.
 *
 * This machine has no native PHP, so the site is served by real PHP 8.3
 * compiled to WebAssembly (@php-wasm/node). The project directory is mounted
 * into the PHP filesystem, so edits to .php files are picked up without a
 * restart.
 *
 *   node .tools/serve.mjs [port]
 */

import { createServer } from 'node:http';
import { request as httpsRequest } from 'node:https';
import { fileURLToPath } from 'node:url';
import path from 'node:path';

import { loadNodeRuntime, createNodeFsMountHandler } from '@php-wasm/node';
import { PHP, PHPRequestHandler } from '@php-wasm/universal';

const PORT = Number(process.argv[2] ?? 8100);
const PROJECT = path.resolve(fileURLToPath(new URL('..', import.meta.url)));
const DOCROOT = '/var/www';

// processId has no default outside php-wasm's own test suite; it only needs to
// be unique per worker, and this server runs a single PHP instance.
const runtime = await loadNodeRuntime('8.3', {
  emscriptenOptions: { processId: 1 },
});

const php = new PHP(runtime);

php.mkdir(DOCROOT);
await php.mount(DOCROOT, createNodeFsMountHandler(PROJECT));

const handler = new PHPRequestHandler({
  php,
  documentRoot: DOCROOT,
  absoluteUrl: `http://localhost:${PORT}`,
});

/**
 * Speech, synthesised in Node rather than in PHP — for local development only.
 *
 * php-wasm ships no CA bundle and cannot complete a TLS handshake, so every
 * outbound HTTPS call from PHP fails here with curl errno 60. That breaks
 * handlers/tts.php locally even though the same code works on a real host, and
 * the symptom is an assistant that goes silent in every language the device
 * has no installed voice for — which on Windows is all of the Indic ones.
 *
 * Node has a working TLS stack, so this intercepts the same endpoint and does
 * the identical work: same chunking, same backends, same content types. Nothing
 * about the site or the client changes.
 */

const TTS_CHUNK = 180;

function ttsChunks(text, limit = TTS_CHUNK) {
  const parts = text.split(/(?<=[.!?।॥])\s+/);
  const chunks = [];
  let buffer = '';

  for (let part of parts) {
    if (buffer && (buffer + ' ' + part).length > limit) {
      chunks.push(buffer);
      buffer = '';
    }
    while (part.length > limit) {
      chunks.push(part.slice(0, limit));
      part = part.slice(limit);
    }
    buffer = buffer ? buffer + ' ' + part : part;
  }
  if (buffer.trim()) chunks.push(buffer);

  return chunks.filter((c) => c.trim()).slice(0, 8);
}

/**
 * GET a URL as a Buffer.
 *
 * Uses node:https rather than fetch because `strict` has to be switchable:
 * some machines sit behind a TLS-intercepting proxy whose CA Node does not
 * trust, which fails the handshake with UNABLE_TO_VERIFY_LEAF_SIGNATURE. Only
 * the keyless Google call ever relaxes it, and only in this dev server — the
 * production path is handlers/tts.php, which always verifies.
 */
function httpsGet(url, headers, strict = true) {
  return new Promise((resolve, reject) => {
    const req = httpsRequest(url, { headers, rejectUnauthorized: strict }, (res) => {
      if (res.statusCode !== 200) {
        res.resume();
        reject(new Error(`HTTP ${res.statusCode}`));

        return;
      }
      const parts = [];
      res.on('data', (d) => parts.push(d));
      res.on('end', () => resolve(Buffer.concat(parts)));
    });

    req.on('error', reject);
    req.end();
  });
}

const BROWSER_HEADERS = {
  // The endpoint rejects requests without a browser user agent.
  'user-agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 '
              + '(KHTML, like Gecko) Chrome/120.0 Safari/537.36',
  referer: 'https://translate.google.com/',
};

let googleStrict = true;

/** Google Translate's TTS endpoint — no key, covers all six languages. */
async function ttsGoogle(text, code) {
  const url = 'https://translate.google.com/translate_tts?' + new URLSearchParams({
    ie: 'UTF-8', q: text, tl: code, client: 'tw-ob',
    total: '1', idx: '0', textlen: String(text.length),
  });

  try {
    return await httpsGet(url, BROWSER_HEADERS, googleStrict);
  } catch (error) {
    if (googleStrict && /UNABLE_TO_VERIFY|SELF_SIGNED|CERT_/.test(String(error?.code ?? error))) {
      console.warn('        TLS chain not verifiable (proxy?) — retrying dev TTS unverified');
      googleStrict = false;

      return httpsGet(url, BROWSER_HEADERS, false).catch(() => null);
    }

    return null;
  }
}

/** Sarvam AI, when a key is in the environment — far better Indic voices. */
async function ttsSarvam(text, bcp47) {
  const r = await fetch('https://api.sarvam.ai/text-to-speech', {
    method: 'POST',
    headers: {
      'content-type': 'application/json',
      'api-subscription-key': process.env.SARVAM_API_KEY,
    },
    body: JSON.stringify({
      text,
      target_language_code: bcp47,
      speaker: process.env.SARVAM_SPEAKER || 'anushka',
      model: 'bulbul:v2',
    }),
  });

  if (!r.ok) {
    console.error(`        sarvam returned ${r.status}`);
    return null;
  }

  const data = await r.json();
  const audio = data?.audios?.[0];

  return typeof audio === 'string' ? Buffer.from(audio, 'base64') : null;
}

const BCP47 = { en: 'en-IN', ta: 'ta-IN', ml: 'ml-IN', kn: 'kn-IN', te: 'te-IN', hi: 'hi-IN' };

async function devTts(req, res, body) {
  const { text = '', lang = 'en' } = JSON.parse(body.toString('utf8') || '{}');
  const code = BCP47[lang] ? lang : 'en';

  if (!text.trim()) {
    res.writeHead(400).end();
    return;
  }

  const useSarvam = Boolean(process.env.SARVAM_API_KEY);
  const parts = [];

  for (const chunk of ttsChunks(text, useSarvam ? 450 : TTS_CHUNK)) {
    const part = useSarvam
      ? await ttsSarvam(chunk, BCP47[code])
      : await ttsGoogle(chunk, code);
    if (!part) break;
    parts.push(part);
  }

  if (parts.length === 0) {
    console.error(`502 <-- POST /handlers/tts.php (${code})`);
    res.writeHead(502).end();
    return;
  }

  // MP3 frames concatenate cleanly, which is why the parts play as one clip.
  const audio = Buffer.concat(parts);
  res.writeHead(200, {
    'content-type': useSarvam ? 'audio/wav' : 'audio/mpeg',
    'cache-control': 'private, max-age=600',
  });
  res.end(audio);

  console.log(`200   POST /handlers/tts.php (${code}, ${audio.length} bytes, `
            + `${useSarvam ? 'sarvam' : 'google'})`);
}

const server = createServer(async (req, res) => {
  const chunks = [];
  for await (const chunk of req) chunks.push(chunk);

  if (req.method === 'POST' && req.url.split('?')[0].endsWith('/handlers/tts.php')) {
    try {
      await devTts(req, res, Buffer.concat(chunks));
    } catch (error) {
      console.error('502 <-- POST /handlers/tts.php\n', error);
      if (!res.headersSent) res.writeHead(502).end();
    }
    return;
  }

  // PHPRequestHeaders is Record<string, string> — Node gives us arrays for
  // repeated headers, so collapse those the way HTTP does.
  const headers = {};
  for (const [key, value] of Object.entries(req.headers)) {
    headers[key] = Array.isArray(value) ? value.join(', ') : String(value);
  }

  try {
    const response = await handler.request({
      url: req.url,
      method: req.method,
      headers,
      body: chunks.length ? new Uint8Array(Buffer.concat(chunks)) : undefined,
    });

    res.writeHead(response.httpStatusCode, response.headers);
    res.end(Buffer.from(response.bytes));

    const flag = response.httpStatusCode >= 400 ? ' <-- ' : '  ';
    console.log(`${response.httpStatusCode}${flag}${req.method} ${req.url}`);
  } catch (error) {
    console.error(`500     ${req.method} ${req.url}\n`, error);
    res.writeHead(500, { 'content-type': 'text/plain' });
    res.end(String(error?.stack ?? error));
  }
});

server.listen(PORT, () => {
  console.log(`Ithrive running on http://localhost:${PORT}`);
  console.log(`Serving ${PROJECT} via PHP ${php.phpVersion ?? '8.3'} (wasm)`);
});
