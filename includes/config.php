<?php
/**
 * iThrive Software — global configuration.
 */

declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('SITE_NAME', 'iThrive Software');
define('SITE_SHORT', 'iThrive');
define('SITE_TAGLINE', 'AI-Powered Platforms, Web & Mobile Applications');
define('SITE_EMAIL', 'hello@ithrivesoftware.com');
define('SITE_PHONE', '+91 90000 00000');
define('SITE_HQ', 'Coimbatore, Tamil Nadu, India');
define('SITE_YEAR', '2026');

/**
 * Published Spline scene for the home hero.
 *
 * Must be an EXPORTED runtime URL (https://prod.spline.design/<id>/scene.splinecode),
 * not an app.spline.design editor link — those are account-gated and return 403
 * to visitors. Leave empty to use the built-in Three.js neural hero instead.
 *
 * In Spline: Export → Code → Public URL, then paste the .splinecode URL here.
 */
define('SPLINE_SCENE', getenv('SPLINE_SCENE') ?: '');

/**
 * Optional server-side text-to-speech, for reliable Indic voice output.
 *
 * Browsers only speak a language if a voice for it is installed, and Tamil,
 * Malayalam, Kannada and Telugu voices are absent on most desktops — so
 * in-browser speech cannot be relied on for them. Point this at a TTS service
 * (AI4Bharat's Indic-TTS is the obvious fit, and needs a GPU inference server)
 * and the assistant will use it whenever the device has no local voice.
 *
 * Contract: POST {"text": "...", "lang": "ta"} -> audio/mpeg or audio/wav.
 */
define('TTS_ENDPOINT', getenv('TTS_ENDPOINT') ?: '');

/**
 * Sarvam AI — speech for Indian languages.
 *
 * Sarvam's bulbul model covers Tamil, Malayalam, Kannada, Telugu, Hindi and
 * Indian English properly, which is exactly the gap the browser cannot fill.
 * Set the subscription key and it becomes the voice for every language.
 *
 * Key: https://dashboard.sarvam.ai  →  API keys
 */
define('SARVAM_API_KEY', getenv('SARVAM_API_KEY') ?: '');

/** Sarvam voice. Options include anushka, manisha, vidya, arya, karun, hitesh. */
define('SARVAM_SPEAKER', getenv('SARVAM_SPEAKER') ?: 'anushka');

define('ROOT_PATH', dirname(__DIR__));
define('STORAGE_PATH', ROOT_PATH . '/storage');

/**
 * URL path of the app root — empty when served from the document root,
 * `/ithrive` when served from a subdirectory.
 *
 * Derived from the running script's directory, then walked back up by however
 * many directories deep that script sits inside the app. Without that step,
 * pages in `services/` and `case-studies/` would resolve every link relative
 * to their own folder.
 */
define('BASE_URL', (static function (): string {
    $normalise = static fn (string $path): string => rtrim(str_replace('\\', '/', $path), '/');

    $base = rtrim(str_replace('\\', '/', dirname((string) ($_SERVER['SCRIPT_NAME'] ?? ''))), '/');
    if ($base === '.') {
        $base = '';
    }

    // How many directories below the app root does the running script sit?
    // realpath normalises separators and resolves any symlinked docroot.
    $scriptDir = realpath(dirname((string) ($_SERVER['SCRIPT_FILENAME'] ?? '')));
    $root      = realpath(ROOT_PATH);
    $depth     = 0;

    if ($scriptDir !== false && $root !== false) {
        $scriptDir = $normalise($scriptDir);
        $root      = $normalise($root);

        // Windows paths are case-insensitive; POSIX ones are not.
        $matches = DIRECTORY_SEPARATOR === '\\'
            ? stripos($scriptDir, $root) === 0
            : str_starts_with($scriptDir, $root);

        if ($matches && $scriptDir !== $root) {
            $depth = substr_count(trim(substr($scriptDir, strlen($root)), '/'), '/') + 1;
        }
    }

    for ($i = 0; $i < $depth && $base !== ''; $i++) {
        $base = rtrim(dirname($base), '/');
        if ($base === '.') {
            $base = '';
        }
    }

    return $base;
})());

/**
 * Primary navigation. Key = page slug used by `$page` in each template.
 *
 * Items carrying a `menu` render as a glass mega-dropdown; `columns` groups the
 * links into headed columns, `feature` is the promo panel on the right.
 */
const NAV_ITEMS = [
    'services' => [
        'label' => 'Services',
        'href'  => 'services.php',
        'menu'  => [
            'columns' => [
                [
                    'heading' => 'AI-First Product Development',
                    'links'   => [
                        ['label' => 'AI-Native Product Development',    'href' => 'services/ai-native-product-development.php'],
                        ['label' => 'AI Enablement for Existing Products', 'href' => 'services/ai-enablement.php'],
                        ['label' => 'AI Solutions for eCommerce',       'href' => 'services/ai-for-ecommerce.php'],
                    ],
                ],
                [
                    'heading' => 'Digital Product Engineering',
                    'links'   => [
                        ['label' => 'Micro SaaS Development',      'href' => 'services/micro-saas-development.php'],
                        ['label' => 'Custom Product Development',  'href' => 'services/custom-product-development.php'],
                        ['label' => 'Product Modernization',       'href' => 'services/product-modernization.php'],
                        ['label' => 'Cloud & DevOps',              'href' => 'services/cloud-devops.php'],
                    ],
                ],
                [
                    'heading' => 'Engagement Models',
                    'links'   => [
                        ['label' => 'Dedicated Engineering Team',   'href' => 'services/dedicated-engineering-team.php'],
                        ['label' => 'Dedicated On-demand Resources', 'href' => 'services/on-demand-resources.php'],
                    ],
                ],
                [
                    'heading' => 'Core Services',
                    'links'   => [
                        ['label' => 'Mobile App Development', 'href' => 'services/mobile-app-development.php'],
                        ['label' => 'Web Development',        'href' => 'services/web-development.php'],
                        ['label' => 'E-commerce Development', 'href' => 'services/ecommerce-development.php'],
                        ['label' => 'React JS Development',   'href' => 'services/reactjs-development.php'],
                        ['label' => 'POC Development',        'href' => 'services/poc-development.php'],
                        ['label' => 'MVP Development',        'href' => 'services/mvp-development.php'],
                    ],
                ],
            ],
            'feature' => [
                'eyebrow' => 'Not sure where to start?',
                'title'   => 'Book a 30-minute AI discovery call',
                'body'    => 'We map your workflow, score the highest-leverage automation, and hand you a build plan — no obligation.',
                'cta'     => ['label' => 'Talk to an engineer', 'href' => 'contact.php'],
            ],
        ],
    ],
    'solutions' => [
        'label' => 'Solutions',
        'href'  => 'solutions.php',
        'menu'  => [
            'columns' => [
                [
                    'heading' => 'Proprietary AI Products',
                    'links'   => [
                        ['label' => 'iThrive Insights', 'href' => 'solutions/ithrive-insights.php'],
                        ['label' => 'iThrive AIChat',   'href' => 'solutions/ithrive-aichat.php'],
                    ],
                ],
                [
                    'heading' => 'By Industry',
                    'links'   => [
                        ['label' => 'Healthcare & Telemedicine', 'href' => 'solutions.php#healthcare'],
                        ['label' => 'On-Demand & Mobility',      'href' => 'solutions.php#mobility'],
                        ['label' => 'Retail & E-commerce',       'href' => 'solutions.php#retail'],
                        ['label' => 'Manufacturing & ERP',       'href' => 'solutions.php#manufacturing'],
                    ],
                ],
            ],
        ],
    ],
    'case-studies' => [
        'label' => 'Case Studies',
        'href'  => 'case-studies.php',
        'menu'  => [
            'columns' => [
                [
                    'heading' => 'Featured Work',
                    'links'   => [
                        ['label' => 'Lotus Eye Hospital — Agentic Healthcare', 'href' => 'case-studies/lotus-eye-hospital.php'],
                        ['label' => 'Mehala Carona — Enterprise AI ERP',       'href' => 'case-studies/mehala-carona.php'],
                        ['label' => 'Tada — AI Ride-Hailing',                  'href' => 'case-studies/tada-taxi-app.php'],
                        ['label' => 'Toing — Food Delivery',                   'href' => 'case-studies/toing-food-delivery.php'],
                    ],
                ],
                [
                    'heading' => 'Browse',
                    'links'   => [
                        ['label' => 'All Case Studies', 'href' => 'case-studies.php'],
                        ['label' => 'AI Apps',          'href' => 'case-studies.php#ai-apps'],
                        ['label' => 'Web Platforms',    'href' => 'case-studies.php#web-platforms'],
                        ['label' => 'Mobile',           'href' => 'case-studies.php#mobile'],
                    ],
                ],
            ],
        ],
    ],
    'company' => [
        'label' => 'Company',
        'href'  => 'company/about.php',
        'menu'  => [
            'columns' => [
                [
                    'heading' => 'iThrive',
                    'links'   => [
                        ['label' => 'About Us',      'href' => 'company/about.php'],
                        ['label' => 'How We Work',   'href' => 'company/process.php'],
                        ['label' => 'Careers',       'href' => 'company/careers.php'],
                        ['label' => 'FAQ',           'href' => 'faq.php'],
                        ['label' => 'Contact',       'href' => 'contact.php'],
                    ],
                ],
            ],
        ],
    ],
    'blog' => [
        'label' => 'Blog',
        'href'  => 'blog.php',
    ],
];

/** Footer link columns. */
const FOOTER_COLUMNS = [
    'Services' => [
        ['label' => 'AI-Native Product Development', 'href' => 'services/ai-native-product-development.php'],
        ['label' => 'AI Enablement',                 'href' => 'services/ai-enablement.php'],
        ['label' => 'Micro SaaS Development',        'href' => 'services/micro-saas-development.php'],
        ['label' => 'Cloud & DevOps',                'href' => 'services/cloud-devops.php'],
        ['label' => 'Mobile App Development',        'href' => 'services/mobile-app-development.php'],
        ['label' => 'All Services',                  'href' => 'services.php'],
    ],
    'Solutions' => [
        ['label' => 'iThrive Insights', 'href' => 'solutions/ithrive-insights.php'],
        ['label' => 'iThrive AIChat',   'href' => 'solutions/ithrive-aichat.php'],
        ['label' => 'All Solutions',    'href' => 'solutions.php'],
    ],
    'Company' => [
        ['label' => 'About Us',       'href' => 'company/about.php'],
        ['label' => 'How We Work',    'href' => 'company/process.php'],
        ['label' => 'Careers',        'href' => 'company/careers.php'],
        ['label' => 'Case Studies',   'href' => 'case-studies.php'],
        ['label' => 'FAQ',            'href' => 'faq.php'],
        ['label' => 'Blog',           'href' => 'blog.php'],
        ['label' => 'Contact',        'href' => 'contact.php'],
    ],
];

require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/content.php';
require_once __DIR__ . '/faq-brain.php';
