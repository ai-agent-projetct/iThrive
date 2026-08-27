<?php
declare(strict_types=1);

$serviceSlug = 'ai-enablement';

// This page runs the Aleph treatment: its own palette, its own hero, and the
// scroll-driven scenes in assets/js/aleph.js. Everything is scoped to
// body.aleph, so no other route is touched.
$heroComponent = 'hero-aleph';
$bodyClass     = 'aleph';

require dirname(__DIR__) . '/includes/templates/service-detail.php';
