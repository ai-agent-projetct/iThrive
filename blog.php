<?php
declare(strict_types=1);

$page      = 'blog';
$pageTitle = 'Blog — AI Engineering & Delivery Notes';
$pageDesc  = 'Field notes from iThrive Software engineers on agentic AI architecture, evaluation harnesses and building AI products that survive contact with production.';

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
        <?php
        /* A thumbnail once the photography run has produced one; the icon tile
           it replaces stays as the fallback, so this is safe before then. */
        $thumb = 'assets/img/blog/photo/post-' . str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT) . '.jpg';
        $hasThumb = is_file(ROOT_PATH . '/' . $thumb);
        ?>
        <article class="card<?= $hasThumb ? ' card--photo' : '' ?>" data-reveal style="--d:<?= $i % 3 ?>">
          <?php if ($hasThumb): ?>
            <figure class="card-figure">
              <img src="<?= e(asset($thumb)) ?>" width="600" height="400" alt="" loading="lazy" decoding="async">
              <span class="card-figure-icon"><?= icon($post['icon']) ?></span>
            </figure>
          <?php else: ?>
            <span class="card-icon"><?= icon($post['icon']) ?></span>
          <?php endif; ?>

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
?>

<section class="section section--tight">
  <div class="shell">
    <?php component('page-figure', ['src' => 'blog-desk', 'caption' => 'Written by the engineers who did the work, not by a content team.']); ?>
  </div>
</section>

<?php
?>

<section class="section section--tight">
  <div class="shell">
    <?php component('page-figure', ['src' => 'blog-benchmarks', 'caption' => 'Numbers we measured ourselves, with the method next to them.']); ?>
  </div>
</section>

<?php
?>

<section class="section section--tight">
  <div class="shell">
    <?php component('page-figure', ['src' => 'blog-idea', 'caption' => 'Most posts start as an argument nobody could settle.']); ?>
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
