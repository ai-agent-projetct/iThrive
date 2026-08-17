<?php
/**
 * 404 — the page that has to be useful, not clever.
 *
 * It carries the same mark as the home page's entry gate, watching the cursor.
 * On the gate that reads as the site sizing you up; here it reads as looking for
 * something, which is the right feeling for the page.
 *
 * The part that matters is underneath: the URL that was asked for is matched
 * against every real route on the site and the closest ones are offered as
 * links. A 404 that only says "not found" makes the visitor's problem their
 * own; one that says "you probably wanted this" solves it.
 */

declare(strict_types=1);

// SITE_NAME is needed for the title before header.php would otherwise load it.
require_once __DIR__ . '/includes/config.php';

http_response_code(404);

$page      = 'notfound';
$pageTitle = 'Page not found';
$pageDesc  = 'That page does not exist. Browse our services, solutions or case studies instead.';

/**
 * What was asked for.
 *
 * Apache reaches this page by internal redirect and sets REDIRECT_URL to the
 * original path; the dev server re-requests /404.php and passes the original in
 * a header instead. REQUEST_URI is the last resort, and is correct on a direct
 * visit to /404.php.
 *
 * All three are attacker-controlled, so the value is only ever used to score
 * suggestions and to print through e(). It is capped too: a 404 that echoes an
 * unbounded string is a 404 someone will try to stuff a payload into.
 */
$askedRaw = (string) (
    $_SERVER['REDIRECT_URL']
    ?? $_SERVER['HTTP_X_ORIGINAL_URL']
    ?? $_SERVER['REQUEST_URI']
    ?? ''
);
$askedRaw = strtok($askedRaw, '?') ?: '';
$asked    = substr(preg_replace('~[^\x20-\x7E]~', '', rawurldecode($askedRaw)) ?? '', 0, 120);

$suggestions = suggest_routes($asked);
$best        = $suggestions[0] ?? null;

require __DIR__ . '/includes/header.php';
?>

<section class="section notfound">
  <div class="shell">
    <div class="notfound-head">
      <?php component('watch-eyes', [
          'eyesId'    => 'nf',
          'eyesClass' => 'notfound-eyes',
          'eyesLabel' => 'Looking for that page',
      ]); ?>

      <p class="eyebrow">Error 404</p>
      <h1 class="notfound-title">We looked. That page is not here.</h1>

      <?php if ($asked !== '' && $asked !== '/'): ?>
        <p class="notfound-asked">
          You asked for <code><?= e($asked) ?></code>
        </p>
      <?php endif; ?>

      <?php if ($best !== null): ?>
        <?php /* The strongest match gets to be the main action, because it is
                 almost always the thing the visitor actually wanted. */ ?>
        <p class="notfound-didyou">Did you mean:</p>
        <a class="btn btn-primary notfound-best" href="<?= e(url($best['path'])) ?>">
          <?= e($best['label']) ?><?= icon('arrow') ?>
        </a>
        <p class="notfound-url"><?= e(rtrim(BASE_URL, '/') . '/' . $best['path']) ?></p>
      <?php else: ?>
        <p class="notfound-lead">
          The link is either out of date or was never right. Everything the site does
          is one of the three below.
        </p>
        <div class="notfound-actions">
          <a class="btn btn-primary" href="<?= e(url('index.php')) ?>">Back to home<?= icon('arrow') ?></a>
          <a class="btn btn-ghost" href="<?= e(url('services.php')) ?>">All services</a>
        </div>
      <?php endif; ?>
    </div>

    <?php if (count($suggestions) > 1): ?>
      <div class="notfound-others">
        <p class="notfound-others-head">Or one of these</p>
        <ul>
          <?php foreach (array_slice($suggestions, 1) as $s): ?>
            <li>
              <a href="<?= e(url($s['path'])) ?>">
                <span class="notfound-other-label"><?= e($s['label']) ?></span>
                <span class="notfound-other-url"><?= e(rtrim(BASE_URL, '/') . '/' . $s['path']) ?></span>
                <?= icon('arrow-up-right') ?>
              </a>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>
  </div>
</section>

<section class="section section--panel section--tight">
  <div class="shell">
    <?php component('section-head', [
        'eyebrow' => 'Everything Else',
        'title'   => 'The three places worth starting',
    ]); ?>

    <div class="grid grid-3">
      <?php
      $routes = [
          ['icon' => 'layers',  'title' => 'Services',     'body' => 'Fifteen engineering services across AI, product, cloud and engagement models.', 'href' => 'services.php'],
          ['icon' => 'sparkles','title' => 'Solutions',    'body' => 'iThrive Insights and iThrive AIChat — two proprietary AI products ready to deploy.', 'href' => 'solutions.php'],
          ['icon' => 'target',  'title' => 'Case Studies', 'body' => 'Ten platforms in production across healthcare, mobility, manufacturing and retail.', 'href' => 'case-studies.php'],
      ];
      foreach ($routes as $i => $route) {
          component('feature-card', ['item' => $route, 'index' => $i]);
      }
      ?>

      </div>

    <p class="notfound-sitemap">
      Or see <a href="<?= e(url('sitemap.php')) ?>">every page on the site</a>.
    </p>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
