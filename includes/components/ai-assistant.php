<?php
/**
 * Ithrive AI — the voice assistant section.
 *
 * The neural orb is the assistant's face: it changes colour, spin and pulse as
 * it listens, thinks and speaks. Voice in and voice out are the browser's own
 * Web Speech APIs, and the answers come from the same grounded agent behind
 * the chat widget, so it only ever talks about Ithrive.
 *
 * Everything degrades: no microphone support leaves a working typed
 * conversation, and no WebGL leaves the CSS orb.
 */

declare(strict_types=1);
?>
<section class="section assistant-section" id="ai-assistant">
  <div class="shell">
    <?php component('section-head', [
        'eyebrow' => 'Ithrive AI',
        'title'   => 'Ask it anything about what we build',
        'lead'    => 'A voice assistant wired to our own case studies and services. Ask out loud or type — it answers from what we have actually shipped, and says so plainly when it does not know.',
    ]); ?>

    <div class="assistant" data-assistant
         data-endpoint="<?= e(url('handlers/chat.php')) ?>"
         <?php /* Always available: tts.php synthesises server-side, so the
                  device needs no installed voice for any language. */ ?>
         data-tts="<?= e(url('handlers/tts.php')) ?>"
         data-langs='<?= e(json_encode(ASSISTANT_LANGUAGES, JSON_UNESCAPED_UNICODE)) ?>'
         data-strings='<?= e(json_encode(ASSISTANT_STRINGS, JSON_UNESCAPED_UNICODE)) ?>'>

      <div class="assistant-langs" role="group" aria-label="Assistant language">
        <?php foreach (ASSISTANT_LANGUAGES as $i => $l): ?>
          <button class="assistant-lang<?= $i === 0 ? ' is-active' : '' ?>" type="button"
                  data-assistant-lang="<?= e($l['code']) ?>"
                  data-bcp47="<?= e($l['bcp47']) ?>"
                  lang="<?= e($l['code']) ?>"
                  title="<?= e($l['name']) ?>"><?= e($l['native']) ?></button>
        <?php endforeach; ?>
      </div>

      <div class="assistant-stage" data-orb-stage>
        <div class="hero-orb"></div>
        <div class="assistant-canvas" data-orb-canvas role="img"
             aria-label="A neural orb that pulses while the Ithrive AI assistant is listening, thinking and speaking."></div>

        <button class="assistant-mic" type="button" data-assistant-mic
                aria-label="Ask by voice">
          <span class="assistant-mic-ring"></span>
          <?= icon('message', 'icon assistant-mic-icon') ?>
        </button>

        <p class="assistant-state" data-assistant-state>Tap to speak</p>
      </div>

      <div class="assistant-panel">
        <div class="assistant-log" data-assistant-log role="log" aria-live="polite">
          <p class="assistant-msg assistant-msg--bot">
            Ask me what Ithrive builds, how an engagement runs, or about any of our ten case
            studies. Try &ldquo;what did you build for Lotus Eye Hospital?&rdquo;
          </p>
        </div>

        <?php /* The label follows the chosen language; the question sent is always
                 the canonical English one from the answer book, so the match does
                 not depend on how a translation happens to land. */ ?>
        <div class="assistant-prompts">
          <?php foreach (ASSISTANT_PROMPTS as $id => $labels): ?>
            <?php $canonical = array_column(FAQ, 'q', 'id')[$id] ?? $labels['en']; ?>
            <button class="assistant-chip" type="button" data-assistant-ask
                    data-question="<?= e($canonical) ?>"
                    data-labels='<?= e(json_encode($labels, JSON_UNESCAPED_UNICODE)) ?>'><?= e($labels['en']) ?></button>
          <?php endforeach; ?>
        </div>

        <form class="assistant-form" data-assistant-form>
          <label class="chat-label" for="assistantInput">Ask Ithrive AI</label>
          <input class="assistant-input" id="assistantInput" type="text" autocomplete="off"
                 placeholder="Type a question, or tap the orb to speak…" maxlength="2000">
          <button class="assistant-send" type="submit" aria-label="Send"><?= icon('arrow') ?></button>
        </form>

        <div class="assistant-meta">
          <label class="assistant-toggle">
            <input type="checkbox" data-assistant-voice checked>
            <span>Speak answers aloud</span>
          </label>
          <p class="assistant-note" data-assistant-support></p>
        </div>
      </div>
    </div>
  </div>
</section>
