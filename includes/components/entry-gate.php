<?php
/**
 * Entry gate — the intro that sits over the home page's first section.
 *
 * Modelled on the way unseen.co opens: a mark that watches your cursor, the
 * studio name, a line about what it does, and a button you press to go in.
 *
 * The mark is ours, not theirs. Their eyes are their logo, and the thing worth
 * borrowing was never the drawing — it was the fact that the page looks back at
 * you before it lets you in. So this is two apertures in the site's own
 * geometry, with irises that track the pointer and get clipped by the lens so
 * they cannot slide out of the eye.
 *
 * Three things this is careful about, because an interstitial on a page meant
 * to generate enquiries is a real cost if it is done carelessly:
 *
 *  - Nothing is hidden from a crawler. The hero and the whole page are in the
 *    markup exactly as before; this is an overlay painted on top, and the
 *    server response is unchanged.
 *  - It asks once. Dismissal is remembered for the browsing session, so moving
 *    around the site and coming back does not gate you again.
 *  - It is not a trap. Enter takes focus, Escape or a click anywhere dismisses
 *    it, and under prefers-reduced-motion it never appears at all — a decorative
 *    interstitial is exactly what that setting is asking us to skip.
 */

declare(strict_types=1);
?>
<div class="gate" data-gate hidden>
  <div class="gate-inner">

    <?php /* The eyes. viewBox units are the tracking space; entry-gate.js moves
             the two iris groups and nothing else. */ ?>
    <svg class="gate-eyes" viewBox="0 0 220 132" role="img"
         aria-label="<?= e(SITE_NAME) ?>" focusable="false">
      <defs>
        <linearGradient id="gateStroke" x1="0" y1="0" x2="1" y2="1">
          <stop offset="0%"   stop-color="#00F2FE"/>
          <stop offset="55%"  stop-color="#4EA8FF"/>
          <stop offset="100%" stop-color="#9D4EDD"/>
        </linearGradient>
        <radialGradient id="gateIris" cx="38%" cy="34%" r="72%">
          <stop offset="0%"   stop-color="#BFF6FF"/>
          <stop offset="42%"  stop-color="#00F2FE"/>
          <stop offset="100%" stop-color="#2B2FA0"/>
        </radialGradient>
        <?php /* One clip per eye, so an iris chasing a cursor at the edge of the
                 screen is cut by the lens instead of drifting outside it. */ ?>
        <clipPath id="gateClipL"><ellipse cx="72" cy="66" rx="46" ry="58"/></clipPath>
        <clipPath id="gateClipR"><ellipse cx="148" cy="66" rx="46" ry="58"/></clipPath>
      </defs>

      <g clip-path="url(#gateClipL)">
        <ellipse cx="72" cy="66" rx="46" ry="58" fill="rgba(0,242,254,.05)"/>
        <g data-gate-iris data-eye="l">
          <circle cx="72" cy="66" r="21" fill="url(#gateIris)"/>
          <circle cx="72" cy="66" r="9"  fill="#04070F"/>
          <circle cx="65" cy="58" r="4"  fill="rgba(255,255,255,.85)"/>
        </g>
      </g>
      <g clip-path="url(#gateClipR)">
        <ellipse cx="148" cy="66" rx="46" ry="58" fill="rgba(157,78,221,.05)"/>
        <g data-gate-iris data-eye="r">
          <circle cx="148" cy="66" r="21" fill="url(#gateIris)"/>
          <circle cx="148" cy="66" r="9"  fill="#04070F"/>
          <circle cx="141" cy="58" r="4"  fill="rgba(255,255,255,.85)"/>
        </g>
      </g>

      <ellipse cx="72"  cy="66" rx="46" ry="58" fill="none" stroke="url(#gateStroke)" stroke-width="2.4"/>
      <ellipse cx="148" cy="66" rx="46" ry="58" fill="none" stroke="url(#gateStroke)" stroke-width="2.4"/>

      <?php /* The lids. Closed by a class, so the blink is one CSS transform. */ ?>
      <g data-gate-lids>
        <rect class="gate-lid" x="26"  y="8" width="92" height="0" fill="#070A12"/>
        <rect class="gate-lid" x="102" y="8" width="92" height="0" fill="#070A12"/>
      </g>
    </svg>

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
