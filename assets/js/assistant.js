/**
 * Ithrive AI — voice assistant.
 *
 * Speech in via the Web Speech API, speech out via speechSynthesis, and the
 * answers come from handlers/chat.php — the same grounded agent behind the chat
 * widget, so it only ever talks about Ithrive.
 *
 * Both speech APIs are optional. Without recognition the mic button hides and
 * the typed form carries the whole feature; without synthesis the answer is
 * still shown as text.
 */

(function () {
  'use strict';

  const root = document.querySelector('[data-assistant]');
  if (!root) return;

  const endpoint = root.dataset.endpoint;
  const log      = root.querySelector('[data-assistant-log]');
  const form     = root.querySelector('[data-assistant-form]');
  const input    = root.querySelector('.assistant-input');
  const mic      = root.querySelector('[data-assistant-mic]');
  const stateEl  = root.querySelector('[data-assistant-state]');
  const support  = root.querySelector('[data-assistant-support]');
  const voiceOn  = root.querySelector('[data-assistant-voice]');

  const SpeechRec = window.SpeechRecognition || window.webkitSpeechRecognition;
  const canSpeak  = 'speechSynthesis' in window;
  const canHear   = Boolean(SpeechRec);

  const LANGS   = JSON.parse(root.dataset.langs || '[]');
  const STRINGS = JSON.parse(root.dataset.strings || '{}');
  const ttsUrl  = root.dataset.tts || '';

  let lang = LANGS[0] || { code: 'en', bcp47: 'en-IN', name: 'English' };
  const str = (k) => (STRINGS[lang.code] || STRINGS.en || {})[k] || '';

  let busy = false;
  let recognising = false;

  /* ------------------------------------------------------------------ state */

  const setState = (name, label) => {
    if (window.ithriveOrb) window.ithriveOrb.setState(name);
    root.dataset.state = name;
    if (label) stateEl.textContent = label;
  };

  /* ---------------------------------------------------------------- support */

  if (!canHear) {
    mic.hidden = true;
    stateEl.textContent = str('prompt');
    support.textContent = 'Voice input needs Chrome, Edge or Safari — typing works everywhere.';
  } else {
    support.textContent = 'Voice input runs in your browser; nothing is recorded.';
  }
  if (!canSpeak && voiceOn) {
    voiceOn.checked = false;
    voiceOn.disabled = true;
  }

  /* ------------------------------------------------------------------ speak */

  // Find the best installed voice for the active language. Most desktops ship
  // no Tamil/Malayalam/Kannada/Telugu voice at all, so this often returns null —
  // that is why the server TTS path below exists.
  let voice = null;
  const pickVoice = () => {
    if (!canSpeak) { voice = null; return; }
    const all = speechSynthesis.getVoices();
    const exact = all.filter(v => v.lang.toLowerCase() === lang.bcp47.toLowerCase());
    const loose = all.filter(v => v.lang.toLowerCase().startsWith(lang.code + '-'));
    const pool  = exact.length ? exact : loose;
    voice = pool.find(v => /natural|google|premium|neural/i.test(v.name)) || pool[0] || null;
    reportVoice();
  };

  function reportVoice() {
    if (voice || ttsUrl) { support.textContent = ''; return; }
    // Say plainly that this device cannot speak the chosen language rather than
    // going silent and looking broken.
    support.textContent = str('novoice').replace('%s', lang.name);
  }

  if (canSpeak) {
    pickVoice();
    speechSynthesis.onvoiceschanged = pickVoice;
  }

  let audio = null;

  async function speakViaServer(text) {
    try {
      const res = await fetch(ttsUrl, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        credentials: 'same-origin',
        body: JSON.stringify({ text, lang: lang.code }),
      });
      if (!res.ok) throw new Error(String(res.status));
      const url = URL.createObjectURL(await res.blob());
      if (audio) audio.pause();
      audio = new Audio(url);
      setState('speaking', str('speaking'));
      audio.onended = () => {
        URL.revokeObjectURL(url);
        if (window.ithriveOrb) window.ithriveOrb.setLevel(0);
        setState('idle', str('prompt'));
      };
      audio.onerror = audio.onended;
      // No amplitude analyser here — a steady pulse still reads as speech.
      if (window.ithriveOrb) window.ithriveOrb.setLevel(0.6);
      await audio.play();
      return true;
    } catch {
      return false;
    }
  }

  async function speak(text) {
    if (!voiceOn || !voiceOn.checked) { setState('idle', str('prompt')); return; }

    // Prefer a real installed voice; fall back to the server when the device
    // has none for this language (the usual case for the Indic languages).
    if (!voice && ttsUrl && await speakViaServer(text)) return;
    if (!canSpeak || !voice) { setState('idle', str('prompt')); return; }

    speechSynthesis.cancel();
    const u = new SpeechSynthesisUtterance(text);
    if (voice) u.voice = voice;
    u.rate = 1.02;
    u.pitch = 1;

    // speechSynthesis exposes no amplitude, so drive the orb from word
    // boundaries — close enough to read as "it is talking".
    u.onstart    = () => setState('speaking', str('speaking'));
    u.onboundary = () => { if (window.ithriveOrb) window.ithriveOrb.setLevel(0.4 + Math.random() * 0.6); };
    u.onend      = () => { if (window.ithriveOrb) window.ithriveOrb.setLevel(0); setState('idle', str('prompt')); };
    u.onerror    = u.onend;

    speechSynthesis.speak(u);
  }

  /* -------------------------------------------------------------- transcript */

  function add(role, text) {
    const p = document.createElement('p');
    p.className = 'assistant-msg assistant-msg--' + role;
    p.textContent = text;                     // never innerHTML — model output
    log.appendChild(p);
    log.scrollTop = log.scrollHeight;
    return p;
  }

  /* ----------------------------------------------------------------- ask */

  async function ask(question) {
    question = (question || '').trim();
    if (!question || busy) return;

    busy = true;
    add('user', question);
    input.value = '';
    setState('thinking', str('thinking'));

    const pending = add('bot', '…');

    try {
      const res = await fetch(endpoint, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        credentials: 'same-origin',
        body: JSON.stringify({ message: question, lang: lang.code }),
      });
      const data = await res.json().catch(() => ({}));
      const reply = data.reply || 'I could not reach my assistant service just now.';

      pending.textContent = reply;
      log.scrollTop = log.scrollHeight;
      speak(reply);
    } catch {
      pending.textContent = 'I could not reach the server. Try again, or email hello@ithrivesoftware.com.';
      setState('idle', str('prompt'));
    } finally {
      busy = false;
    }
  }

  form.addEventListener('submit', (e) => { e.preventDefault(); ask(input.value); });
  root.querySelectorAll('[data-assistant-ask]').forEach((b) => {
    b.addEventListener('click', () => ask(b.textContent.trim()));
  });

  /* ---------------------------------------------------------------- listen */

  if (!canHear) return;

  const rec = new SpeechRec();
  rec.lang = lang.bcp47;
  rec.interimResults = true;
  rec.continuous = false;

  rec.onstart = () => {
    recognising = true;
    setState('listening', str('listening'));
  };

  rec.onresult = (event) => {
    let text = '';
    let finished = false;
    for (let i = event.resultIndex; i < event.results.length; i++) {
      text += event.results[i][0].transcript;
      if (event.results[i].isFinal) finished = true;
    }
    input.value = text;
    // Louder speech tends to transcribe with higher confidence — a decent
    // stand-in for amplitude, which the API does not expose.
    if (window.ithriveOrb) {
      window.ithriveOrb.setLevel(Math.min(1, (event.results[0][0].confidence || 0.5) + 0.2));
    }
    if (finished) {
      rec.stop();
      ask(text);
    }
  };

  rec.onerror = (e) => {
    recognising = false;
    setState('idle', e.error === 'not-allowed' ? 'Microphone blocked' : str('prompt'));
  };

  rec.onend = () => {
    recognising = false;
    if (window.ithriveOrb) window.ithriveOrb.setLevel(0);
    if (root.dataset.state === 'listening') setState('idle', str('prompt'));
  };

  /* -------------------------------------------------------------- language */

  root.querySelectorAll('[data-assistant-lang]').forEach((b) => {
    b.addEventListener('click', () => {
      lang = LANGS.find(l => l.code === b.dataset.assistantLang) || lang;

      root.querySelectorAll('[data-assistant-lang]').forEach((o) => {
        const on = o === b;
        o.classList.toggle('is-active', on);
        o.setAttribute('aria-pressed', String(on));
      });

      // Retarget speech recognition, re-pick the voice, and relabel the UI.
      rec.lang = lang.bcp47;
      input.placeholder = str('placeholder');
      input.lang = lang.code;
      log.lang = lang.code;
      pickVoice();
      if (canSpeak) speechSynthesis.cancel();
      if (audio) audio.pause();
      setState('idle', str('prompt'));
    });
  });

  mic.addEventListener('click', () => {
    if (recognising) { rec.stop(); return; }
    if (canSpeak) speechSynthesis.cancel();   // barge-in: stop talking to listen
    try { rec.start(); } catch { /* already starting */ }
  });
})();
