<?php
/**
 * iThrive AIChat — the site-wide chat launcher and panel.
 *
 * Rendered on every page. chat.js activates it; without JavaScript the launcher
 * is simply not shown, and the contact routes still work.
 */

declare(strict_types=1);
?>
<div class="chat" id="chatWidget" data-endpoint="<?= e(url('handlers/chat.php')) ?>" hidden>
  <button class="chat-launcher" type="button" data-chat-toggle aria-expanded="false" aria-controls="chatPanel">
    <span class="chat-launcher-icon"><?= icon('message') ?></span>
    <span class="chat-launcher-close"><?= icon('close') ?></span>
    <span class="chat-launcher-label">Ask AIChat</span>
  </button>

  <section class="chat-panel" id="chatPanel" role="dialog" aria-label="iThrive AIChat" aria-modal="false">
    <header class="chat-head">
      <span class="chat-avatar"><?= icon('sparkles') ?></span>
      <div class="chat-head-text">
        <p class="chat-title">iThrive AIChat</p>
        <p class="chat-status"><span class="chat-dot"></span>Answers from our own case studies</p>
      </div>
      <button class="chat-close" type="button" data-chat-toggle aria-label="Close chat"><?= icon('close') ?></button>
    </header>

    <div class="chat-log" id="chatLog" role="log" aria-live="polite" aria-atomic="false">
      <div class="chat-msg chat-msg--bot">
        <p>I can answer questions about what we build, walk you through any of our ten case studies, and put you in front of an engineer when it is worth it. What are you working on?</p>
      </div>
    </div>

    <div class="chat-suggestions" id="chatSuggestions">
      <button class="chat-chip" type="button" data-chat-suggest>What do you build with Python and AI?</button>
      <button class="chat-chip" type="button" data-chat-suggest>Have you done anything in healthcare?</button>
      <button class="chat-chip" type="button" data-chat-suggest>How does an engagement start?</button>
    </div>

    <form class="chat-form" id="chatForm">
      <label class="chat-label" for="chatInput">Your message</label>
      <textarea class="chat-input" id="chatInput" rows="1" maxlength="2000"
                placeholder="Describe what you are trying to build…" autocomplete="off"></textarea>
      <button class="chat-send" type="submit" aria-label="Send message"><?= icon('arrow') ?></button>
    </form>

    <p class="chat-foot">
      AI assistant — it can be wrong. For anything binding, email
      <a href="mailto:<?= e(SITE_EMAIL) ?>"><?= e(SITE_EMAIL) ?></a>.
    </p>
  </section>
</div>
