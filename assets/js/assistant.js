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
    stateEl.textContent = 'Type your question';
    support.textContent = 'Voice input needs Chrome, Edge or Safari — typing works everywhere.';
  } else {
    support.textContent = 'Voice input runs in your browser; nothing is recorded.';
  }
  if (!canSpeak && voiceOn) {
    voiceOn.checked = false;
    voiceOn.disabled = true;
  }

  /* ------------------------------------------------------------------ speak */

  // Prefer a natural en-GB/en-IN voice when the platform offers one.
  let voice = null;
  const pickVoice = () => {
    if (!canSpeak) return;
    const all = speechSynthesis.getVoices();
    voice = all.find(v => /en-(GB|IN)/i.test(v.lang) && /natural|google|premium/i.test(v.name))
         || all.find(v => /en-(GB|IN)/i.test(v.lang))
         || all.find(v => v.lang.startsWith('en'))
         || null;
  };
  if (canSpeak) {
    pickVoice();
    speechSynthesis.onvoiceschanged = pickVoice;
  }

  function speak(text) {
    if (!canSpeak || !voiceOn || !voiceOn.checked) { setState('idle', 'Tap to speak'); return; }

    speechSynthesis.cancel();
    const u = new SpeechSynthesisUtterance(text);
    if (voice) u.voice = voice;
    u.rate = 1.02;
    u.pitch = 1;

    // speechSynthesis exposes no amplitude, so drive the orb from word
    // boundaries — close enough to read as "it is talking".
    u.onstart    = () => setState('speaking', 'Speaking…');
    u.onboundary = () => { if (window.ithriveOrb) window.ithriveOrb.setLevel(0.4 + Math.random() * 0.6); };
    u.onend      = () => { if (window.ithriveOrb) window.ithriveOrb.setLevel(0); setState('idle', 'Tap to speak'); };
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
    setState('thinking', 'Thinking…');

    const pending = add('bot', '…');

    try {
      const res = await fetch(endpoint, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        credentials: 'same-origin',
        body: JSON.stringify({ message: question }),
      });
      const data = await res.json().catch(() => ({}));
      const reply = data.reply || 'I could not reach my assistant service just now.';

      pending.textContent = reply;
      log.scrollTop = log.scrollHeight;
      speak(reply);
    } catch {
      pending.textContent = 'I could not reach the server. Try again, or email hello@ithrivesoftware.com.';
      setState('idle', 'Tap to speak');
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
  rec.lang = 'en-IN';
  rec.interimResults = true;
  rec.continuous = false;

  rec.onstart = () => {
    recognising = true;
    setState('listening', 'Listening…');
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
    setState('idle', e.error === 'not-allowed' ? 'Microphone blocked' : 'Tap to speak');
  };

  rec.onend = () => {
    recognising = false;
    if (window.ithriveOrb) window.ithriveOrb.setLevel(0);
    if (root.dataset.state === 'listening') setState('idle', 'Tap to speak');
  };

  mic.addEventListener('click', () => {
    if (recognising) { rec.stop(); return; }
    if (canSpeak) speechSynthesis.cancel();   // barge-in: stop talking to listen
    try { rec.start(); } catch { /* already starting */ }
  });
})();
