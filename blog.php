<?php
declare(strict_types=1);

$page      = 'blog';
$pageTitle = 'Blog — Notes on AI engineering and product delivery | Ithrive Software Solutions';
$pageDesc  = 'Field notes from Ithrive engineers on agentic AI architecture, evaluation harnesses, strangler-fig modernisation and building AI products that survive contact with production.';

require __DIR__ . '/includes/header.php';

component('page-hero', [
    'art'     => 'blog',
    'eyebrow' => 'Blog',
    'title'   => 'Field notes from the builds, not thought leadership.',
    'lead'    => 'Written by the engineers who did the work, usually because something surprised us and we wanted it written down before we forgot.',
]);
?>

<section class="section section--flush-top">
  <div class="shell">
    <div class="grid grid-3">
      <?php foreach (BLOG_POSTS as $i => $post): ?>
        <article class="card" data-reveal style="--d:<?= $i % 3 ?>">
          <span class="card-icon"><?= icon($post['icon']) ?></span>

          <div class="post-meta">
            <span class="post-cat"><?= e($post['category']) ?></span>
            <time datetime="<?= e($post['date']) ?>"><?= e(date('j M Y', strtotime($post['date']))) ?></time>
            <span><?= e($post['read']) ?></span>
          </div>

          <h2 class="card-title"><?= e($post['title']) ?></h2>
          <p class="card-body"><?= e($post['excerpt']) ?></p>
        </article>
      <?php endforeach; ?>
    </div>

    <p class="section-lead" data-reveal style="text-align:center;margin:44px auto 0">
      Full articles are being migrated across. Want one of these as a conversation instead?
      <a class="btn-link" href="<?= e(url('contact.php')) ?>" style="margin-left:6px">Get in touch<?= icon('arrow') ?></a>
    </p>
  </div>
</section>

<?php
component('cta', ['cta' => [
    'eyebrow'   => 'Start Your Project',
    'title'     => 'Prefer the version where we look at your codebase?',
    'body'      => 'Most of these posts started as a client problem. Send us yours and we will tell you which lesson applies.',
    'primary'   => ['label' => 'Start Your Project', 'href' => 'contact.php'],
    'secondary' => ['label' => 'See our services', 'href' => 'services.php'],
]]);

require __DIR__ . '/includes/footer.php';
