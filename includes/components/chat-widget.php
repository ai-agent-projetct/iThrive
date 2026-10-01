<?php
/**
 * iThrive AIChat — the site-wide chat launcher and panel.
 *
 * Rendered on every page. chat.js activates it; without JavaScript the launcher
 * is simply not shown, and the contact routes still work.
 *
 * Everything the panel says is available in all six languages. The English is
 * rendered; data-ui and data-starters carry the rest, and chat.js swaps them
 * in when the visitor picks a language, so a Tamil visitor never meets an
 * English greeting, placeholder or error.
 */

declare(strict_types=1);

$ui = [];
foreach (ASSISTANT_LANGUAGES as $l) {
    $ui[$l['code']] = assistant_ui($l['code']);
}

/* Starter chips are published questions, so each is answered exactly, and
   each carries its entry id so a tap can never land on a look-alike. */
$homeFaqs  = PAGE_FAQS['home'] ?? [];
$starterAt = [0, 2, 4];     // "What does iThrive actually do?", "How do engagements start?", "Do we own the code?"
$starters  = [];
foreach (ASSISTANT_LANGUAGES as $l) {
    foreach ($starterAt as $i) {
        if (isset($homeFaqs[$i]['q'])) {
            $starters[$l['code']][] = ['id' => 'page:home:' . ($i + 1), 'q' => ui_question($homeFaqs[$i]['q'], $l['code'])];
        }
    }
}
$en = $ui['en'];
?>
<div class="chat" id="chatWidget" data-endpoint="<?= e(url('handlers/chat.php')) ?>"
     data-ui='<?= e(json_encode($ui, JSON_UNESCAPED_UNICODE)) ?>'
     data-starters='<?= e(json_encode($starters, JSON_UNESCAPED_UNICODE)) ?>'
     data-email="<?= e(SITE_EMAIL) ?>" hidden>
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
        <p class="chat-status"><span class="chat-dot"></span><span data-ui-text="status"><?= e($en['status']) ?></span></p>
      </div>
      <?php /* The language the assistant answers in.
               Every answer on the site is held in all six, so this is a
               lookup rather than a translation on the request path. Without
               it the widget could only ever ask in English, whatever the
               visitor typed — which is why the translations were invisible. */ ?>
      <label class="chat-lang-label" for="chatLang">Language</label>
      <select class="chat-lang" id="chatLang" aria-label="Answer language">
        <?php foreach (ASSISTANT_LANGUAGES as $l): ?>
          <option value="<?= e($l['code']) ?>"><?= e($l['native']) ?></option>
        <?php endforeach; ?>
      </select>

      <button class="chat-close" type="button" data-chat-toggle aria-label="Close chat"><?= icon('close') ?></button>
    </header>

    <div class="chat-log" id="chatLog" role="log" aria-live="polite" aria-atomic="false">
      <div class="chat-msg chat-msg--bot" data-chat-greeting>
        <p data-ui-text="chatGreeting"><?= e($en['chatGreeting']) ?></p>
      </div>
    </div>

    <div class="chat-suggestions" id="chatSuggestions">
      <?php foreach ($starters['en'] ?? [] as $s): ?>
        <button class="chat-chip" type="button" data-chat-suggest data-faq-id="<?= e($s['id']) ?>"><?= e($s['q']) ?></button>
      <?php endforeach; ?>
    </div>

    <form class="chat-form" id="chatForm">
      <label class="chat-label" for="chatInput">Your message</label>
      <textarea class="chat-input" id="chatInput" rows="1" maxlength="2000"
                placeholder="<?= e($en['placeholder']) ?>" autocomplete="off"></textarea>
      <button class="chat-send" type="submit" aria-label="Send message"><?= icon('arrow') ?></button>
    </form>

    <?php /* The email stays a link; the sentence around it follows the language. */ ?>
    <p class="chat-foot" data-ui-foot><?= str_replace(
        e(SITE_EMAIL),
        '<a href="mailto:' . e(SITE_EMAIL) . '">' . e(SITE_EMAIL) . '</a>',
        e($en['disclaimer'])
    ) ?></p>
  </section>
</div>
