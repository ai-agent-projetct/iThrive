<?php
/**
 * The mark that watches the cursor.
 *
 * Two lenses in the site's gradient, each iris clipped by its own lens so it
 * cannot slide out of the eye however far the pointer goes. assets/js/eyes.js
 * drives any `[data-eyes]` element it finds, so this component only has to
 * describe the shape.
 *
 * Used twice — the home page's entry gate and the 404 — which is why the SVG
 * ids are prefixed. Two copies on one page with the same gradient id would have
 * the second silently steal the first's paint.
 *
 * @var string      $eyesId    Unique prefix for this instance's SVG ids.
 * @var string      $eyesLabel Accessible name.
 * @var string|null $eyesClass Extra class on the <svg>.
 */

declare(strict_types=1);

// Self-registering: the footer loads eyes.js only if this ran. A flag set by
// hand in each page is a flag someone eventually forgets, and the failure is
// silent — a mark that simply never blinks.
$GLOBALS['ithrive_needs_eyes'] = true;

$eyesId    = $eyesId    ?? 'eyes';
$eyesLabel = $eyesLabel ?? SITE_NAME;
$eyesClass = $eyesClass ?? '';
?>
<svg class="watch-eyes <?= e($eyesClass) ?>" viewBox="0 0 220 132" role="img"
     aria-label="<?= e($eyesLabel) ?>" focusable="false" data-eyes>
  <defs>
    <linearGradient id="<?= e($eyesId) ?>-stroke" x1="0" y1="0" x2="1" y2="1">
      <stop offset="0%"   stop-color="#00F2FE"/>
      <stop offset="55%"  stop-color="#4EA8FF"/>
      <stop offset="100%" stop-color="#9D4EDD"/>
    </linearGradient>
    <radialGradient id="<?= e($eyesId) ?>-iris" cx="38%" cy="34%" r="72%">
      <stop offset="0%"   stop-color="#BFF6FF"/>
      <stop offset="42%"  stop-color="#00F2FE"/>
      <stop offset="100%" stop-color="#2B2FA0"/>
    </radialGradient>
    <clipPath id="<?= e($eyesId) ?>-clip-l"><ellipse cx="72" cy="66" rx="46" ry="58"/></clipPath>
    <clipPath id="<?= e($eyesId) ?>-clip-r"><ellipse cx="148" cy="66" rx="46" ry="58"/></clipPath>
  </defs>

  <g clip-path="url(#<?= e($eyesId) ?>-clip-l)">
    <ellipse cx="72" cy="66" rx="46" ry="58" fill="rgba(0,242,254,.05)"/>
    <g data-eyes-iris>
      <circle cx="72" cy="66" r="21" fill="url(#<?= e($eyesId) ?>-iris)"/>
      <circle cx="72" cy="66" r="9"  fill="#04070F"/>
      <circle cx="65" cy="58" r="4"  fill="rgba(255,255,255,.85)"/>
    </g>
  </g>
  <g clip-path="url(#<?= e($eyesId) ?>-clip-r)">
    <ellipse cx="148" cy="66" rx="46" ry="58" fill="rgba(157,78,221,.05)"/>
    <g data-eyes-iris>
      <circle cx="148" cy="66" r="21" fill="url(#<?= e($eyesId) ?>-iris)"/>
      <circle cx="148" cy="66" r="9"  fill="#04070F"/>
      <circle cx="141" cy="58" r="4"  fill="rgba(255,255,255,.85)"/>
    </g>
  </g>

  <ellipse cx="72"  cy="66" rx="46" ry="58" fill="none" stroke="url(#<?= e($eyesId) ?>-stroke)" stroke-width="2.4"/>
  <ellipse cx="148" cy="66" rx="46" ry="58" fill="none" stroke="url(#<?= e($eyesId) ?>-stroke)" stroke-width="2.4"/>

  <?php /* Lids grow downward, so a blink is one animated property. */ ?>
  <g data-eyes-lids>
    <rect class="watch-lid" x="26"  y="8" width="92" height="0" fill="#070A12"/>
    <rect class="watch-lid" x="102" y="8" width="92" height="0" fill="#070A12"/>
  </g>
</svg>
