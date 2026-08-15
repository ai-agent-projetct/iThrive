<?php
declare(strict_types=1);

// SITE_NAME is needed for the title before header.php would otherwise load it.
require_once __DIR__ . '/includes/config.php';

http_response_code(404);

$page      = 'home';
$pageTitle = 'Page not found';
$pageDesc  = 'That page does not exist. Browse our services, solutions or case studies instead.';

require __DIR__ . '/includes/header.php';

component('page-hero', [
    'art'     => 'notfound',
    'eyebrow' => 'Error 404',
    'title'   => 'That page is not here.',
    'lead'    => 'The link is either out of date or was never right. Everything the site does is one of the three below.',
    'actions' => [
        ['label' => 'Back to home', 'href' => 'index.php'],
        ['label' => 'All services',  'href' => 'services.php'],
    ],
]);
?>

<section class="section section--flush-top">
  <div class="shell">
    <div class="grid grid-3">
      <?php
      $routes = [
          ['icon' => 'layers', 'title' => 'Services',     'body' => 'Fifteen engineering services across AI, product, cloud and engagement models.', 'href' => 'services.php'],
          ['icon' => 'sparkles','title' => 'Solutions',   'body' => 'iThrive Insights and iThrive AIChat — two proprietary AI products ready to deploy.', 'href' => 'solutions.php'],
          ['icon' => 'target', 'title' => 'Case Studies', 'body' => 'Ten platforms in production across healthcare, mobility, manufacturing and retail.', 'href' => 'case-studies.php'],
      ];
      foreach ($routes as $i => $route) {
          component('feature-card', ['item' => $route, 'index' => $i]);
      }
      ?>
    </div>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
