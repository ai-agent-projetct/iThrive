<?php
/**
 * Device mock frames for a case study — a browser window, a phone, or both.
 *
 * The "UI" inside is built from CSS blocks tinted with the study's accent
 * colour, so every card carries a plausible product preview without shipping
 * a screenshot we do not have the rights to.
 *
 * @var array       $study    One CASE_STUDIES entry.
 * @var string|null $variant  Override the study's own `mock` setting.
 * @var bool        $compact  Fewer rows, for use inside a grid card.
 */

declare(strict_types=1);

$variant = $variant ?? $study['mock'];
$compact = $compact ?? false;
$host    = parse_url($study['url'], PHP_URL_HOST) ?: $study['url'];
$path    = $compact ? '' : (parse_url($study['url'], PHP_URL_PATH) ?: '');

/** Deterministic bar heights so the chart does not change between renders. */
$bars = [];
$seed = crc32($study['slug']);
for ($i = 0; $i < 11; $i++) {
    $bars[] = 28 + (($seed >> ($i * 2)) % 68);
}
?>
<div class="mock<?= $variant === 'both' ? ' mock-stack' : '' ?>" style="--accent: <?= e($study['accent']) ?>" aria-hidden="true">

  <?php if ($variant === 'desktop' || $variant === 'both'): ?>
    <div class="mock-browser">
      <div class="mock-bar">
        <div class="mock-dots"><i></i><i></i><i></i></div>
        <div class="mock-url"><?= e($host . $path) ?></div>
      </div>
      <div class="mock-body">
        <div class="mock-head">
          <span class="mock-logo"><?= icon($study['icon']) ?></span>
          <span>
            <span class="mock-wordmark"><?= e($study['client']) ?></span>
            <span class="mock-tagline"><?= e($study['screens'][0]) ?></span>
          </span>
        </div>

        <div class="mock-metrics">
          <?php foreach (array_slice($study['metrics'], 0, 3) as $m): ?>
            <div class="mock-metric"><b><?= e($m['value']) ?></b><span><?= e($m['label']) ?></span></div>
          <?php endforeach; ?>
        </div>

        <div class="mock-chart">
          <?php foreach ($bars as $h): ?><i style="height: <?= (int) $h ?>%"></i><?php endforeach; ?>
        </div>

        <?php if (!$compact): ?>
          <div class="mock-rows">
            <?php foreach (array_slice($study['screens'], 1, 3) as $row): ?>
              <div class="mock-row"><i></i><i></i></div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
  <?php endif; ?>

  <?php if ($variant === 'mobile' || $variant === 'both'): ?>
    <div class="mock-phone">
      <div class="mock-phone-screen">
        <span class="mock-notch"></span>
        <div class="mock-head">
          <span class="mock-logo"><?= icon($study['icon']) ?></span>
          <span class="mock-wordmark"><?= e($study['client']) ?></span>
        </div>
        <div class="mock-hero-block"></div>
        <div class="mock-pills"><i></i><i></i><i></i></div>
        <div class="mock-rows">
          <div class="mock-row"><i></i><i></i></div>
          <div class="mock-row"><i></i><i></i></div>
          <?php if (!$compact): ?><div class="mock-row"><i></i><i></i></div><?php endif; ?>
        </div>
        <div class="mock-cta"></div>
      </div>
    </div>
  <?php endif; ?>
</div>

<?php if (!empty($study['badges'])): ?>
  <div class="store-badges">
    <?php foreach ($study['badges'] as $badge): ?>
      <?php
      [$badgeIcon, $badgeLabel] = match ($badge) {
          'play' => ['play',    'Google Play'],
          'app'  => ['smartphone', 'App Store'],
          default=> ['globe',   'Live on the web'],
      };
      ?>
      <span class="store-badge"><?= icon($badgeIcon) ?><?= e($badgeLabel) ?></span>
    <?php endforeach; ?>
  </div>
<?php endif; ?>
