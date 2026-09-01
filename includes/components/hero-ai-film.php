<?php
/**
 * AI Enablement hero — the film, scrubbed by scroll.
 *
 * The clip fills the viewport and its playhead is tied to how far you have
 * scrolled through the section, the same mechanism the "Why iThrive" film uses:
 * assets/js/scrub.js binds any [data-scrub] section holding a
 * [data-scrub-video].
 *
 * Encoded the way the reference site encodes its own banner — H.264 MP4 at
 * 1920x1080 inside a <video> with a <source>, muted and playsinline — with one
 * addition it does not need: a keyframe every third frame. That is the whole
 * difference between a scrub that lands on the frame you asked for and one that
 * walks backwards to find a keyframe first.
 *
 * The film carries nothing but itself. The copy that used to sit over it is the
 * section immediately below — which is also the only version of it a crawler
 * can read, since a scrubbed film is invisible to one. Two sections from one
 * component, so the order cannot be got wrong by whoever includes it.
 *
 * Degrades: touch and reduced-motion skip the scrub entirely and play the clip
 * inline, which scrub.js handles; no JavaScript at all leaves the poster frame
 * with the copy on top.
 *
 * @var array $svc The service, from service().
 */

declare(strict_types=1);

$src    = ROOT_PATH . '/videos/ai-film.mp4';
$mobile = ROOT_PATH . '/videos/ai-film-mobile.mp4';
$poster = ROOT_PATH . '/assets/img/ai-film-poster.jpg';
?>
<?php /* data-scrub-ease: a gentler pull than the 0.16 default, because this
         is a long clip over a long track and the default snaps. */ ?>
<section class="afilm" data-scrub data-scrub-ease="0.07" aria-label="<?= e($svc['title']) ?>">
  <div class="afilm-track">
    <div class="afilm-sticky">

      <?php if (is_file($src)): ?>
        <?php /* preload="auto": a scrub is only smooth once the frames are
                 buffered, and a seek into an unbuffered region shows nothing. */ ?>
        <video class="afilm-video" data-scrub-video
               muted playsinline preload="auto" disablepictureinpicture
               <?= is_file($poster) ? 'poster="' . e(asset('assets/img/ai-film-poster.jpg')) . '"' : '' ?>>
          <?php if (is_file($mobile)): ?>
            <source src="<?= e(asset('videos/ai-film-mobile.mp4')) ?>" type="video/mp4" media="(max-width: 860px)">
          <?php endif; ?>
          <source src="<?= e(asset('videos/ai-film.mp4')) ?>" type="video/mp4">
        </video>
      <?php endif; ?>

      <?php /* Only enough darkening at the top edge to keep the frame clear of
               the fixed header. Nothing sits on the film now, so there is
               nothing else to hold down. */ ?>
      <div class="afilm-scrim" aria-hidden="true"></div>

      <span class="afilm-progress" aria-hidden="true"><span data-scrub-bar></span></span>
    </div>
  </div>
</section>

<?php /* Section two: the page's own introduction, in ordinary markup below the
         film rather than over it. The h1 lives here. */ ?>
<section class="section afilm-intro">
  <div class="shell">
    <p class="eyebrow" data-reveal><?= e($svc['group']) ?></p>
    <h1 class="afilm-title" data-reveal style="--d:1"><?= e($svc['title']) ?></h1>
    <p class="afilm-lead" data-reveal style="--d:2"><?= e($svc['lead']) ?></p>

    <div class="afilm-actions" data-reveal style="--d:3">
      <a class="btn btn-primary" href="<?= e(url('contact.php')) ?>">
        Talk to an engineer<?= icon('arrow') ?>
      </a>
      <a class="btn btn-ghost" href="#what-we-add">See what we add</a>
    </div>
  </div>
</section>
