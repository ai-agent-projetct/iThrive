/**
 * iThrive AI — voice assistant.
 *
 * Speech in via the Web Speech API, speech out via speechSynthesis, and the
 * answers come from handlers/chat.php — the same grounded agent behind the chat
 * widget, so it only ever talks about iThrive.
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
  const hands    = root.querySelector('[data-assistant-handsfree]');
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

  // Declared up here, not in the recognition section below, because speaking
  // finishes on browsers that have no recognition at all — a `let` down there
  // would leave these in their temporal dead zone on exactly those browsers.
  let handsFree = false;
  let relisten  = () => {};

  /**
   * Every path out of speaking ends here.
   *
   * In hands-free mode it reopens the microphone, which is what turns the
   * assistant from a question box into a conversation. Restarting only once the
   * voice has stopped is deliberate: an open microphone during playback
   * transcribes the assistant talking to itself.
   */
  function spokenEnd() {
    if (window.ithriveOrb) window.ithriveOrb.setLevel(0);
    setState('idle', str('prompt'));
    if (handsFree) relisten();
  }

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
        spokenEnd();
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
    if (!voiceOn || !voiceOn.checked) { spokenEnd(); return; }

    // Prefer a real installed voice; fall back to the server when the device
    // has none for this language (the usual case for the Indic languages).
    if (!voice && ttsUrl) {
      if (await speakViaServer(text)) return;

      // Both paths are gone. Say so, rather than sitting there mute — silence
      // is indistinguishable from a broken assistant, and this is exactly the
      // state a Windows desktop lands in for Tamil.
      support.textContent = str('novoice').replace('%s', lang.name);
      spokenEnd();

      return;
    }

    if (!canSpeak || !voice) {
      support.textContent = str('novoice').replace('%s', lang.name);
      spokenEnd();

      return;
    }

    speechSynthesis.cancel();
    const u = new SpeechSynthesisUtterance(text);
    if (voice) u.voice = voice;
    u.rate = 1.02;
    u.pitch = 1;

    // speechSynthesis exposes no amplitude, so drive the orb from word
    // boundaries — close enough to read as "it is talking".
    u.onstart    = () => setState('speaking', str('speaking'));
    u.onboundary = () => { if (window.ithriveOrb) window.ithriveOrb.setLevel(0.4 + Math.random() * 0.6); };
    u.onend      = () => spokenEnd();
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

  // The chip shows the visitor's language but asks the canonical English
  // question, so a suggested prompt always resolves to a real answer.
  const chips = Array.from(root.querySelectorAll('[data-assistant-ask]'));
  chips.forEach((b) => {
    b.addEventListener('click', () => ask(b.dataset.question || b.textContent.trim()));
  });

  const relabelChips = () => {
    chips.forEach((b) => {
      let labels = {};
      try { labels = JSON.parse(b.dataset.labels || '{}'); } catch { /* keep the label */ }
      const label = labels[lang.code] || labels.en;
      if (label) {
        b.textContent = label;
        b.lang = lang.code;
      }
    });
  };

  /* -------------------------------------------------------------- language */

  // Declared up here so the language handler can retarget it whether or not
  // this browser ends up creating one — a `const` below would leave the name
  // in its temporal dead zone on exactly the browsers this fix is for.
  let rec = null;

  // Wired before the recognition setup below, and independent of it. It used to
  // sit after an early `return` for browsers with no SpeechRecognition, which
  // silently pinned those browsers to English for good.
  root.querySelectorAll('[data-assistant-lang]').forEach((b) => {
    b.addEventListener('click', () => {
      lang = LANGS.find(l => l.code === b.dataset.assistantLang) || lang;

      root.querySelectorAll('[data-assistant-lang]').forEach((o) => {
        const on = o === b;
        o.classList.toggle('is-active', on);
        o.setAttribute('aria-pressed', String(on));
      });

      // Retarget speech recognition, re-pick the voice, and relabel the UI.
      if (rec) rec.lang = lang.bcp47;
      input.placeholder = str('placeholder');
      input.lang = lang.code;
      log.lang = lang.code;
      relabelChips();
      pickVoice();
      if (canSpeak) speechSynthesis.cancel();
      if (audio) audio.pause();
      setState('idle', str('prompt'));
    });
  });

  /* ---------------------------------------------------------------- listen */

  if (!canHear) return;

  /**
   * Hands-free mode — the Jarvis behaviour: keep the microphone open, answer,
   * then listen again, so a conversation needs no clicking at all.
   *
   * The Web Speech engine ends a session after every utterance and after a few
   * seconds of silence, so "continuous" is really a restart loop. The guards
   * matter: restarting while a session is already live throws, and restarting
   * while the assistant is talking makes it transcribe its own voice.
   */
  let restartTimer = 0;

  const startListening = () => {
    if (recognising || busy) return;
    try { rec.start(); } catch { /* already starting */ }
  };

  const listenSoon = (delay) => {
    clearTimeout(restartTimer);
    restartTimer = setTimeout(() => { if (handsFree) startListening(); }, delay);
  };

  const stopHandsFree = () => {
    handsFree = false;
    clearTimeout(restartTimer);
    if (recognising) { try { rec.stop(); } catch { /* not running */ } }
  };

  function reflectHandsFree() {
    root.classList.toggle('is-handsfree', handsFree);
    if (!hands) return;
    hands.classList.toggle('is-active', handsFree);
    hands.setAttribute('aria-pressed', String(handsFree));
  }

  rec = new SpeechRec();
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
    if (!finished) return;

    rec.stop();

    // "Jarvis, what does it cost" — address it by name and the name is not part
    // of the question. Stripped rather than required, so it stays optional.
    const asked = text.replace(/^\s*(hey\s+|ok\s+)?(jarvis|ithrive)[\s,.:-]+/i, '').trim();

    // A hands-free session picks up coughs and passing conversation; one or two
    // stray words are not a question worth spending a model call on.
    if (handsFree && asked.split(/\s+/).filter(Boolean).length < 2) {
      input.value = '';
      listenSoon(300);

      return;
    }

    ask(asked || text);
  };

  rec.onerror = (e) => {
    recognising = false;
    // A hands-free session hits `no-speech` and `aborted` constantly — those
    // are silence, not failure, and must not tear the loop down.
    if (e.error === 'not-allowed' || e.error === 'service-not-allowed') {
      handsFree = false;
      reflectHandsFree();
      setState('idle', 'Microphone blocked');

      return;
    }
    if (!handsFree) setState('idle', str('prompt'));
  };

  rec.onend = () => {
    recognising = false;
    if (window.ithriveOrb) window.ithriveOrb.setLevel(0);
    if (root.dataset.state === 'listening') setState('idle', str('prompt'));

    // Hands-free: the engine stops itself every utterance and after a few
    // seconds of silence, so the loop is kept alive by restarting it.
    if (handsFree && !busy) listenSoon(400);
  };

  // Now that the recognition loop exists, let speaking hand control back to it.
  relisten = () => listenSoon(500);

  mic.addEventListener('click', () => {
    if (recognising) { rec.stop(); return; }
    if (canSpeak) speechSynthesis.cancel();   // barge-in: stop talking to listen
    if (audio) audio.pause();
    startListening();
  });

  if (hands) {
    hands.hidden = false;
    hands.addEventListener('click', () => {
      if (handsFree) {
        stopHandsFree();
        reflectHandsFree();
        setState('idle', str('prompt'));

        return;
      }

      handsFree = true;
      reflectHandsFree();
      // The click is the user gesture the microphone permission prompt needs,
      // so start listening from inside it rather than on a timer.
      if (canSpeak) speechSynthesis.cancel();
      if (audio) audio.pause();
      startListening();
    });
  }

  // Leaving the page with the microphone open is not acceptable.
  window.addEventListener('pagehide', stopHandsFree);
  document.addEventListener('visibilitychange', () => {
    if (document.hidden) { clearTimeout(restartTimer); if (recognising) rec.stop(); }
    else if (handsFree) listenSoon(600);
  });
})();
