<?php
declare(strict_types=1);

$serviceSlug = 'ecommerce-development';

/* The film leads and the page's ordinary hero follows it as section two.
   550vh leaves 450vh of travel for a 10-second clip — about 420px of scroll per
   second of footage, the same walk the Software Development film runs at. */
$heroFilm = [
    'video' => 'ecom-film',
    'label' => 'E-commerce development at iThrive',
    'track' => '550vh',
    'ease'  => '0.06',
];

require dirname(__DIR__) . '/includes/templates/service-detail.php';
