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
  const toggles     = widget.querySelectorAll('[data-chat-toggle]');

  let busy = false;
  let open = false;

  widget.hidden = false;

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

  /* ------------------------------------------------------------------ send */

  async function send(message) {
    if (busy || !message.trim()) return;

    busy = true;
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
        body: JSON.stringify({ message }),
      });

      const data = await response.json().catch(() => ({}));
      typing.remove();

      if (data.reply) {
        addMessage('bot', data.reply);
      } else {
        addMessage('bot', 'Something went wrong at my end. Email hello@ithrivesoftware.com and a person will pick it up.');
      }

      if (data.captured)  addNotice('Your details are with our team — expect a reply within two working days.');
      if (data.escalated) addNotice('Flagged for a human engineer to follow up.');
    } catch {
      typing.remove();
      addMessage('bot', 'I could not reach the server. Check your connection, or email hello@ithrivesoftware.com.');
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

  document.querySelectorAll('[data-chat-suggest]').forEach((chip) => {
    chip.addEventListener('click', () => send(chip.textContent.trim()));
  });

  /* --------------------------------------------------------------- autosize */

  function autosize() {
    input.style.height = 'auto';
    input.style.height = Math.min(input.scrollHeight, 140) + 'px';
  }

  input.addEventListener('input', autosize);
  autosize();
})();
