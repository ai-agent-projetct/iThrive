<?php
/**
 * Mobile App Development — the one page that is not the shared service layout.
 *
 * The page itself is the React build from ai-agent-projetct/mobile-app-page,
 * mounted into this template so it renders exactly as designed, while the
 * site's real header, navigation, footer, chat widget and schema stay in place
 * around it. Source and build config live in app/mobile; see its README.
 *
 * Rebuild after changing anything under app/mobile/src:
 *     cd app/mobile && npm install && npm run build
 */

declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/config.php';

$svc = service('mobile-app-development');

$page      = 'services';
$pageTitle = 'Mobile App Development in Chennai';
$pageDesc  = 'iThrive Software engineers iOS, Android, Flutter and AI mobile apps for '
           . 'enterprises and startups, from studios in Chennai and Coimbatore.';
$ogImage   = 'service-' . $svc['group_slug'];

$schema = [
    '@type'       => 'Service',
    'name'        => $svc['title'],
    'serviceType' => $svc['group'],
    'description' => $svc['lead'],
    'areaServed'  => 'Worldwide',
    'url'         => canonical('services/mobile-app-development.php'),
];

// The page ships its own type ramp; these are the families the design was
// drawn in and are not in the site's global stylesheet.
$extraHead = '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>'
    . '<link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;600'
    . '&family=Outfit:wght@400;500;600;700;800;900'
    . '&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">'
    . '<link rel="stylesheet" href="' . e(asset('assets/dist/mobile/mobile-app.css')) . '">';

require dirname(__DIR__) . '/includes/header.php';
?>

<?php /* React mounts here. Without JavaScript the fallback below is what a
         visitor — or a crawler that does not execute scripts — gets, so the
         page is never an empty div. */ ?>
<div id="ithrive-mobile-root"></div>

<noscript>
  <section class="section">
    <div class="shell">
      <?php /* A real H1, not the shared section-head (which emits an H2). The
               page body is client-rendered, so without this a crawler that does
               not execute JavaScript sees no heading at all. */ ?>
      <p class="eyebrow"><?= e($svc['group']) ?></p>
      <h1 class="section-title">Mobile App Development Company in Chennai &amp; Coimbatore</h1>
      <p class="section-lead"><?= e($svc['lead']) ?></p>

      <div class="grid grid-3">
        <?php foreach ($svc['capabilities'] as $i => $cap): ?>
          <article class="card card--numbered">
            <span class="card-num"><?= str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT) ?></span>
            <h3 class="card-title"><?= e($cap['title']) ?></h3>
            <p class="card-body"><?= e($cap['body']) ?></p>
          </article>
        <?php endforeach; ?>
      </div>

      <div class="section-foot">
        <a class="btn btn-primary" href="<?= e(url('contact.php')) ?>">Start your project<?= icon('arrow') ?></a>
      </div>
    </div>
  </section>
</noscript>

<?php /* The hero's 3D scene loads its Three.js scripts at runtime, so it needs to
         know where the site root is — BASE_URL is empty at the domain root and
         a path when the site lives in a subdirectory. */ ?>
<?php /* Root-absolute, always. A bare relative path would resolve against
         /services/ and 404 — this page is one directory deep. */ ?>
<script>window.__ithriveBase = <?= json_encode(BASE_URL . '/') ?>;</script>
<script type="module" src="<?= e(asset('assets/dist/mobile/mobile-app.js')) ?>"></script>

<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
