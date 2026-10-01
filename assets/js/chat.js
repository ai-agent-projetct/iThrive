/**
 * iThrive AIChat widget.
 *
 * The markup ships hidden and this script reveals it, so a visitor with
 * JavaScript disabled never sees a launcher that cannot work.
 */

(function () {
  'use strict';

  const widget = document.getElementById('chatWidget');
  if (!widget) return;

  const endpoint    = widget.dataset.endpoint;
  const panel       = document.getElementById('chatPanel');
  const log         = document.getElementById('chatLog');
  const form        = document.getElementById('chatForm');
  const input       = document.getElementById('chatInput');
  const suggestions = document.getElementById('chatSuggestions');
  const langSelect  = document.getElementById('chatLang');
  const toggles     = widget.querySelectorAll('[data-chat-toggle]');

  /* The language to answer in. The endpoint also detects the language of the
     message itself, so typing Tamil answers in Tamil whatever this says; the
     picker is for the visitor who types English and wants Tamil back. */
  const answerLang = () => (langSelect && langSelect.value) || 'en';

  /* Everything the panel says, in all six languages (ASSISTANT_UI), and the
     starter questions for each — published questions with their entry ids. */
  const parse = (s) => { try { return JSON.parse(s || '{}'); } catch { return {}; } };
  const UI       = parse(widget.dataset.ui);
  const STARTERS = parse(widget.dataset.starters);
  const EMAIL    = widget.dataset.email || '';
  const ui = (key) => (UI[answerLang()] || UI.en || {})[key] || (UI.en || {})[key] || '';

  let busy = false;
  let open = false;
  let started = false;      // once the visitor has asked, the starters are replaced by suggestions

  widget.hidden = false;

  /* Put the panel's own words into the chosen language. The email in the
     disclaimer stays a link, so the sentence is rebuilt around it. */
  function applyLanguage() {
    widget.querySelectorAll('[data-ui-text]').forEach((el) => {
      const text = ui(el.dataset.uiText);
      if (text) el.textContent = text;
    });
    input.placeholder = ui('placeholder') || input.placeholder;
    input.lang = answerLang();
    log.lang = answerLang();

    const foot = widget.querySelector('[data-ui-foot]');
    const line = ui('disclaimer');
    if (foot && line) {
      const [before, after = ''] = EMAIL ? line.split(EMAIL) : [line];
      const a = document.createElement('a');
      a.href = 'mailto:' + EMAIL;
      a.textContent = EMAIL;
      foot.replaceChildren(before, ...(EMAIL && line.includes(EMAIL) ? [a, after] : []));
    }

    if (!started) showSuggestions(STARTERS[answerLang()] || STARTERS.en || []);
  }

  if (langSelect) langSelect.addEventListener('change', applyLanguage);

  /* ------------------------------------------------------------- open/close */

  function setOpen(next) {
    open = next;
    widget.classList.toggle('is-open', open);
    toggles.forEach((t) => t.setAttribute('aria-expanded', String(open)));
    if (open) setTimeout(() => input.focus(), 260);
  }

  toggles.forEach((t) => t.addEventListener('click', () => setOpen(!open)));

  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape' && open) setOpen(false);
  });

  // Let any element opt in to opening the chat, e.g. a CTA elsewhere on a page.
  document.querySelectorAll('[data-chat-open]').forEach((trigger) => {
    trigger.addEventListener('click', (event) => {
      event.preventDefault();
      setOpen(true);
      const seed = trigger.dataset.chatOpen;
      if (seed) {
        input.value = seed;
        autosize();
      }
    });
  });

  /* --------------------------------------------------------------- messages */

  function addMessage(role, text) {
    const wrap = document.createElement('div');
    wrap.className = 'chat-msg chat-msg--' + role;

    // Model output is inserted as text nodes only — never as HTML.
    String(text).split(/\n{2,}/).forEach((para) => {
      const p = document.createElement('p');
      p.textContent = para.trim();
      if (p.textContent) wrap.appendChild(p);
    });

    log.appendChild(wrap);
    log.scrollTop = log.scrollHeight;
    return wrap;
  }

  function addTyping() {
    const wrap = document.createElement('div');
    wrap.className = 'chat-msg chat-msg--bot chat-msg--typing';
    wrap.innerHTML = '<span></span><span></span><span></span>';
    log.appendChild(wrap);
    log.scrollTop = log.scrollHeight;
    return wrap;
  }

  function addNotice(text) {
    const note = document.createElement('p');
    note.className = 'chat-notice';
    note.textContent = text;
    log.appendChild(note);
    log.scrollTop = log.scrollHeight;
  }

  /* Offer the next questions the corpus can actually answer, in the language
     the answer came back in. A visitor who typed one keyword gets somewhere to
     go next without having to guess what we know. */
  function showSuggestions(related) {
    if (!suggestions) return;

    if (!Array.isArray(related) || related.length === 0) {
      suggestions.hidden = true;

      return;
    }

    suggestions.textContent = '';
    related.slice(0, 3).forEach((item) => {
      const text = typeof item === 'string' ? item : (item && item.q);
      if (!text) return;

      const chip = document.createElement('button');
      chip.className = 'chat-chip';
      chip.type = 'button';
      chip.setAttribute('data-chat-suggest', '');
      chip.textContent = text;
      // The entry it came from, so tapping it answers that entry and not a
      // different one that happens to read the same in this language.
      if (item && item.id) chip.dataset.faqId = item.id;
      suggestions.appendChild(chip);
    });
    suggestions.hidden = false;
  }

  /* ------------------------------------------------------------------ send */

  async function send(message, faqId = '') {
    if (busy || !message.trim()) return;

    busy = true;
    started = true;
    form.classList.add('is-busy');
    if (suggestions) suggestions.hidden = true;

    addMessage('user', message);
    input.value = '';
    autosize();

    const typing = addTyping();

    try {
      const response = await fetch(endpoint, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        credentials: 'same-origin',
        // The page, because "how long did it take?" means this case study.
        body: JSON.stringify({ message, lang: answerLang(), page: location.pathname, faq_id: faqId }),
      });

      const data = await response.json().catch(() => ({}));
      typing.remove();

      if (data.reply) {
        addMessage('bot', data.reply);
      } else {
        addMessage('bot', ui('error'));
      }

      if (data.captured)  addNotice(ui('captured'));
      if (data.escalated) addNotice(ui('escalated'));

      showSuggestions(data.related);
    } catch {
      typing.remove();
      addMessage('bot', ui('offline'));
    } finally {
      busy = false;
      form.classList.remove('is-busy');
      input.focus();
    }
  }

  form.addEventListener('submit', (event) => {
    event.preventDefault();
    send(input.value);
  });

  // Enter sends, Shift+Enter makes a new line.
  input.addEventListener('keydown', (event) => {
    if (event.key === 'Enter' && !event.shiftKey) {
      event.preventDefault();
      send(input.value);
    }
  });

  // Delegated, because the chips are replaced after every answer.
  document.addEventListener('click', (event) => {
    const chip = event.target.closest('[data-chat-suggest]');
    if (chip) send(chip.textContent.trim(), chip.dataset.faqId || '');
  });

  /* --------------------------------------------------------------- autosize */

  function autosize() {
    input.style.height = 'auto';
    input.style.height = Math.min(input.scrollHeight, 140) + 'px';
  }

  input.addEventListener('input', autosize);
  autosize();
})();
