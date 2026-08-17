<?php
/**
 * Entry gate — the intro that sits over the home page's first section.
 *
 * Modelled on the way unseen.co opens: a mark that watches your cursor, the
 * studio name, a line about what it does, and a button you press to go in.
 *
 * The mark is ours, not theirs. Their eyes are their logo, and the thing worth
 * borrowing was never the drawing — it was the fact that the page looks back at
 * you before it lets you in. It lives in components/watch-eyes.php because the
 * 404 page uses it too.
 *
 * Three things this is careful about, because an interstitial on a page meant
 * to generate enquiries is a real cost if it is done carelessly:
 *
 *  - Nothing is hidden from a crawler. The hero and the whole page are in the
 *    markup exactly as before; this is an overlay painted on top, and the
 *    server response is unchanged.
 *  - It asks once, then stays away for twelve hours, across tabs.
 *  - It is not a trap. Enter takes focus, Escape or a click on the backdrop
 *    dismisses it, and under prefers-reduced-motion it never appears at all — a
 *    decorative interstitial is exactly what that setting is asking us to skip.
 */

declare(strict_types=1);
?>
<div class="gate" data-gate hidden>
  <div class="gate-inner">

    <?php /* The mark is shared with the 404 page; eyes.js drives both. */ ?>
    <?php component('watch-eyes', ['eyesId' => 'gate', 'eyesClass' => 'gate-eyes']); ?>

    <p class="gate-name"><?= e(SITE_NAME) ?><sup>&reg;</sup></p>
    <p class="gate-line">
      An AI-first product studio building intelligent platforms, web and mobile
      apps in Python — from Chennai, Coimbatore and Bangalore.
    </p>

    <div class="gate-actions">
      <button class="btn btn-primary gate-enter" type="button" data-gate-enter>
        Enter<?= icon('arrow') ?>
      </button>
    </div>

    <button class="gate-skip" type="button" data-gate-skip>Skip intro</button>
  </div>
</div>
