<?php
/**
 * A section's images, shown as a 3D gallery instead of static thumbnails.
 *
 * The AI service pages carry fourteen images each, and until now they sat in
 * card corners about 400px wide, which is where a 1672px render goes to die.
 * These present the same pictures at full size and in depth.
 *
 * Three variants, one per section, because the three sections hold different
 * counts and mean different things:
 *
 *   deck      section 3, six images -- a WebGL stack scrolled through
 *   coverflow section 5, five images -- a 3D coverflow reel
 *   stack     section 6, three images -- a fanned deck you flick
 *
 * All three components are already vendored and registered in
 * app/originkit/src/embed.jsx, so this adds no dependency and nothing to the
 * built bundle; it only mounts what is there.
 *
 * Progressive enhancement: the static images are rendered INSIDE the host.
 * embed.jsx mounts React into it and React replaces the children, so a visitor
 * with the island blocked, or before it lazily mounts, still sees every image
 * as a plain responsive grid. Nothing here is the only route to the content.
 *
 * @var string[] $images  absolute URLs, already filtered for existence
 * @var string   $variant deck|coverflow|stack
 * @var string   $label   accessible name for the group
 */

$images  = array_values(array_filter($images ?? []));
$variant = $variant ?? 'deck';
$label   = $label ?? 'Section images';

if (count($images) < 2) {
    return; // one picture is not a gallery; the page's own markup can have it
}

$COMPONENT = [
    'deck'      => 'stacked-carousel',
    'coverflow' => 'coverflow-gallery',
    'stack'     => 'swipe-stack',
];
$name = $COMPONENT[$variant] ?? 'stacked-carousel';

/* Per-variant sizing. The components size themselves from props rather than
   from CSS, so these have to be passed rather than styled. */
$PROPS = [
    'deck' => [
        'images'     => $images,
        'cardWidth'  => 760,
        'cardHeight' => 428,   // 16:9, matching the source images
        'style'      => ['minWidth' => 0, 'minHeight' => 0],
    ],
    'coverflow' => [
        'images' => $images,
        'style'  => ['minWidth' => 0, 'minHeight' => 0],
    ],
    'stack' => [
        /* swipe-stack reads url(image.src), not the bare string the other two
           take. Passing plain URLs here rendered url(undefined) on every card:
           the deck mounted and animated, showed nothing, and the page quietly
           asked the server for /services/undefined. */
        'images'         => array_map(static fn(string $src): array => ['src' => $src], $images),
        'cardWidth'      => 460,
        'cardHeight'     => 259,
        'cardRadius'     => 10,
        'swipeThreshold' => 50,
        'style'          => ['minWidth' => 0, 'minHeight' => 0],
    ],
];
$props = $PROPS[$variant] ?? $PROPS['deck'];

$GLOBALS['ithrive_needs_originkit'] = true;
?>
<div class="svc-gal svc-gal--<?= e($variant) ?>"
     role="group"
     aria-label="<?= e($label) ?>"
     data-ok="<?= e($name) ?>"
     data-props='<?= e(json_encode($props, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)) ?>'>
  <?php /* Replaced by the island on mount; the whole content until then. */ ?>
  <div class="svc-gal-fallback">
    <?php foreach ($images as $src): ?>
      <figure><img src="<?= e($src) ?>" alt="" loading="lazy" decoding="async"></figure>
    <?php endforeach; ?>
  </div>
</div>
