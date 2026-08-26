<?php
declare(strict_types=1);

$serviceSlug = 'ai-native-product-development';

// This one page gets the interactive robot hero instead of the shared
// title card; everything below the hero is the standard service layout.
$heroComponent = 'hero-robot';

// Opts the page into the staged, scroll-driven treatment in
// assets/js/lusion-stage.js and the .lusion-* rules in style.css.
$bodyClass = 'lusion';

require dirname(__DIR__) . '/includes/templates/service-detail.php';
