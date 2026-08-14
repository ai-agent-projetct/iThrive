<?php
/**
 * Extra sections for /services/mobile-app-development.php.
 *
 * service-detail.php renders `service-extras-{slug}` when a component of that
 * name exists, so one service can grow without touching the other fourteen.
 *
 * Ported from ai-agent-projetct/mobile-app-page. That repository's PHP page is
 * a stub — it includes seventeen files of which two exist — and its working
 * implementation is a React/Vite app with Tailwind classes. This site has
 * neither a build step nor Tailwind, so the content and the arithmetic were
 * rebuilt on the components already here rather than copied.
 */

declare(strict_types=1);

$est = MOBILE_APP_ESTIMATOR;
?>

<section class="section section--panel">
  <div class="shell">
    <?php component('section-head', [
        'eyebrow' => 'What Every App Includes',
        'title'   => 'The parts of a mobile build that decide whether it survives',
        'lead'    => 'Six things that separate an app that ships from one that limps. None of them are optional here.',
    ]); ?>

    <div class="grid grid-3">
      <?php foreach (MOBILE_APP_FUNCTIONS as $i => $fn): ?>
        <?php component('feature-card', ['item' => $fn, 'index' => $i % 3]); ?>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section" id="estimator">
  <div class="shell">
    <?php component('section-head', [
        'eyebrow' => 'Transparent Pricing',
        'title'   => 'Estimate your build, before you talk to anyone',
        'lead'    => 'Pick the platform, the features and the design level. The number moves as you choose — '
                   . 'it is an opening range, not a quote, and it is locked only after discovery.',
    ]); ?>

    <div class="estimator" data-estimator
         data-config='<?= e(json_encode($est, JSON_UNESCAPED_UNICODE)) ?>'>

      <div class="estimator-options">
        <fieldset class="estimator-step">
          <legend><span class="estimator-num">1</span>Target platform</legend>
          <div class="estimator-choices">
            <?php foreach ($est['platforms'] as $p): ?>
              <label class="estimator-choice<?= $p['id'] === $est['defaults']['platform'] ? ' is-active' : '' ?>">
                <input type="radio" name="est-platform" value="<?= e($p['id']) ?>"
                       <?= $p['id'] === $est['defaults']['platform'] ? 'checked' : '' ?>>
                <span><?= e($p['label']) ?></span>
              </label>
            <?php endforeach; ?>
          </div>
        </fieldset>

        <fieldset class="estimator-step">
          <legend><span class="estimator-num">2</span>Key features</legend>
          <div class="estimator-choices estimator-choices--wrap">
            <?php foreach ($est['features'] as $f): ?>
              <?php $on = in_array($f['id'], $est['defaults']['features'], true); ?>
              <label class="estimator-choice estimator-choice--check<?= $on ? ' is-active' : '' ?>">
                <input type="checkbox" name="est-feature" value="<?= e($f['id']) ?>" <?= $on ? 'checked' : '' ?>>
                <span><?= e($f['label']) ?></span>
                <b class="estimator-tick" aria-hidden="true"><?= icon('check') ?></b>
              </label>
            <?php endforeach; ?>
          </div>
        </fieldset>

        <fieldset class="estimator-step">
          <legend><span class="estimator-num">3</span>UI &amp; design level</legend>
          <div class="estimator-choices">
            <?php foreach ($est['design'] as $d): ?>
              <label class="estimator-choice<?= $d['id'] === $est['defaults']['design'] ? ' is-active' : '' ?>">
                <input type="radio" name="est-design" value="<?= e($d['id']) ?>"
                       <?= $d['id'] === $est['defaults']['design'] ? 'checked' : '' ?>>
                <span><?= e($d['label']) ?></span>
                <em><?= e($d['note']) ?></em>
              </label>
            <?php endforeach; ?>
          </div>
        </fieldset>
      </div>

      <?php /* aria-live so the figure is announced as the choices change; without
               it a screen-reader user gets no feedback from this at all. */ ?>
      <aside class="estimator-result" aria-live="polite">
        <div class="estimator-result-head">
          <h3>Estimated investment</h3>
          <div class="estimator-currency" role="group" aria-label="Currency">
            <button type="button" class="is-active" data-estimator-currency="inr">&#8377; INR</button>
            <button type="button" data-estimator-currency="usd">$ USD</button>
          </div>
        </div>

        <p class="estimator-label">Opening range</p>
        <p class="estimator-total" data-estimator-total>&#8377;0</p>
        <p class="estimator-weeks"><?= icon('clock') ?><span data-estimator-weeks>—</span></p>

        <dl class="estimator-summary">
          <div><dt>Platform</dt><dd data-estimator-platform>—</dd></div>
          <div><dt>Features</dt><dd data-estimator-count>—</dd></div>
          <div><dt>Design level</dt><dd data-estimator-design>—</dd></div>
          <div><dt>Source code &amp; IP</dt><dd>100% yours</dd></div>
        </dl>

        <button class="btn btn-primary estimator-cta" type="button"
                data-modal-open data-modal-service="Mobile App Development">
          Request a formal proposal<?= icon('arrow') ?>
        </button>

        <p class="estimator-note">
          Final cost is fixed in writing after technical discovery. This figure is a starting
          range, not an offer.
        </p>
      </aside>
    </div>
  </div>
</section>
