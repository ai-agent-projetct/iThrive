<?php
/**
 * Shared template, lookup and form helpers.
 */

declare(strict_types=1);

/** Escape for HTML output. */
function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/** Build an absolute-from-root URL for an asset or page. */
function url(string $path): string
{
    return BASE_URL . '/' . ltrim($path, '/');
}

/** Cache-busting asset URL so CSS/JS edits show up immediately in dev. */
function asset(string $path): string
{
    $file = ROOT_PATH . '/' . ltrim($path, '/');
    $version = is_file($file) ? (string) filemtime($file) : SITE_YEAR;

    return url($path) . '?v=' . $version;
}

/** Render a partial with an isolated scope. */
function component(string $name, array $data = []): void
{
    extract($data, EXTR_SKIP);
    include ROOT_PATH . '/includes/components/' . $name . '.php';
}

/**
 * Inline SVG icon set, drawn on Lucide's 24x24 / 2px-stroke grid so the whole
 * site keeps one line weight. Unknown names fall back to the arrow.
 */
function icon(string $name, string $class = 'icon'): string
{
    static $paths = [
        // AI + engineering
        'brain'       => '<path d="M12 5a3 3 0 0 0-6 0 3 3 0 0 0-2 5.2A3 3 0 0 0 6 16a3 3 0 0 0 6 1Z"/><path d="M12 5a3 3 0 0 1 6 0 3 3 0 0 1 2 5.2A3 3 0 0 1 18 16a3 3 0 0 1-6 1Z"/><path d="M12 5v12"/>',
        'cpu'         => '<rect x="4" y="4" width="16" height="16" rx="2"/><rect x="9" y="9" width="6" height="6"/><path d="M9 2v2M15 2v2M9 20v2M15 20v2M2 9h2M2 15h2M20 9h2M20 15h2"/>',
        'sparkles'    => '<path d="M12 3l1.9 4.6L18.5 9.5l-4.6 1.9L12 16l-1.9-4.6L5.5 9.5l4.6-1.9Z"/><path d="M19 15l.8 2L22 17.8l-2.2.8L19 21l-.8-2.4-2.2-.8 2.2-.8Z"/>',
        'bot'         => '<rect x="4" y="8" width="16" height="12" rx="3"/><path d="M12 4v4M8 2h8"/><circle cx="9" cy="14" r="1"/><circle cx="15" cy="14" r="1"/><path d="M2 13v3M22 13v3"/>',
        'network'     => '<circle cx="12" cy="5" r="2.5"/><circle cx="5" cy="18" r="2.5"/><circle cx="19" cy="18" r="2.5"/><path d="M12 7.5v4M12 11.5 6.5 16M12 11.5 17.5 16"/>',
        'workflow'    => '<rect x="3" y="3" width="7" height="6" rx="1.5"/><rect x="14" y="15" width="7" height="6" rx="1.5"/><path d="M6.5 9v6a3 3 0 0 0 3 3H14"/>',
        'code'        => '<path d="m8 6-6 6 6 6M16 6l6 6-6 6"/>',
        'terminal'    => '<rect x="2.5" y="4" width="19" height="16" rx="2"/><path d="m7 9 3 3-3 3M13 15h4"/>',
        'database'    => '<ellipse cx="12" cy="6" rx="8" ry="3"/><path d="M4 6v12c0 1.7 3.6 3 8 3s8-1.3 8-3V6"/><path d="M4 12c0 1.7 3.6 3 8 3s8-1.3 8-3"/>',
        'cloud'       => '<path d="M17.5 19a4.5 4.5 0 0 0 .3-9A6.5 6.5 0 0 0 5.4 11 3.9 3.9 0 0 0 6 19Z"/>',
        'layers'      => '<path d="M12 3 3 8l9 5 9-5-9-5Z"/><path d="m3 13 9 5 9-5"/><path d="m3 17.5 9 5 9-5"/>',
        'package'     => '<path d="M12 2.5 20.5 7v10L12 21.5 3.5 17V7Z"/><path d="M3.5 7 12 11.7 20.5 7M12 11.7V21.5"/>',
        'git-branch'  => '<path d="M6 4v10.5A3.5 3.5 0 0 0 9.5 18H14"/><circle cx="6" cy="4" r="2"/><circle cx="17" cy="18" r="2"/><circle cx="17" cy="6" r="2"/><path d="M15 6H9.5"/>',
        'refresh'     => '<path d="M20.5 12a8.5 8.5 0 1 1-2.7-6.2"/><path d="M20.5 4v5h-5"/>',
        'shield'      => '<path d="M12 2.5 4.5 5.6v6c0 4.6 3.1 8.5 7.5 9.9 4.4-1.4 7.5-5.3 7.5-9.9v-6Z"/><path d="m9.3 12 2 2 3.5-3.8"/>',
        'lock'        => '<rect x="4.5" y="10.5" width="15" height="10" rx="2"/><path d="M8 10.5V7a4 4 0 0 1 8 0v3.5"/>',
        'zap'         => '<path d="M13 2 4 13.5h7L11 22l9-11.5h-7Z"/>',
        'rocket'      => '<path d="M5.5 14.5c-1.5 1.5-2 6-2 6s4.5-.5 6-2a3 3 0 0 0-4-4Z"/><path d="M14.5 12.5 11.5 9.5c1.5-4 5-7.5 9.5-7.5 0 4.5-3.5 8-7.5 9.5Z"/><path d="m9.5 9.5-4 1 1.5 3M14.5 12.5l-1 4 3 1.5"/>',
        'target'      => '<circle cx="12" cy="12" r="8.5"/><circle cx="12" cy="12" r="4.5"/><circle cx="12" cy="12" r="1"/>',
        'lightbulb'   => '<path d="M9 17.5h6"/><path d="M10 21h4"/><path d="M12 3a6 6 0 0 0-3.5 10.9c.6.4 1 1.1 1 1.9h5c0-.8.4-1.5 1-1.9A6 6 0 0 0 12 3Z"/>',
        'search'      => '<circle cx="11" cy="11" r="7"/><path d="m16.5 16.5 4 4"/>',
        'trending-up' => '<path d="m3 17 6-6 4 4 8-8"/><path d="M15 7h6v6"/>',
        'bar-chart'   => '<path d="M4 20V10M10 20V4M16 20v-7M22 20H2"/>',
        'gauge'       => '<path d="M4 18a9 9 0 1 1 16 0"/><path d="m12 14 4-4"/><circle cx="12" cy="15" r="1.5"/>',
        'edit'        => '<path d="M11 4H5.5A2.5 2.5 0 0 0 3 6.5v12A2.5 2.5 0 0 0 5.5 21h12a2.5 2.5 0 0 0 2.5-2.5V13"/><path d="M18.4 2.6a2 2 0 0 1 2.8 2.8L12.5 14 9 15l1-3.5Z"/>',
        'wrench'      => '<path d="M14.5 6.5a4.5 4.5 0 0 0 5.6 5.6L21 13l-8 8a2.8 2.8 0 0 1-4-4l8-8Z"/><path d="m7.5 13.5-4 4a2.8 2.8 0 0 0 4 4l4-4"/>',
        // Product + interface
        'smartphone'  => '<rect x="6.5" y="2" width="11" height="20" rx="2.5"/><path d="M11 18.5h2"/>',
        'monitor'     => '<rect x="2.5" y="4" width="19" height="12.5" rx="2"/><path d="M8.5 20.5h7M12 16.5v4"/>',
        'globe'       => '<circle cx="12" cy="12" r="8.5"/><path d="M3.5 12h17"/><path d="M12 3.5c2.4 2.5 3.7 5.4 3.7 8.5S14.4 18 12 20.5C9.6 18 8.3 15.1 8.3 12S9.6 6 12 3.5Z"/>',
        'cart'        => '<circle cx="9.5" cy="20" r="1.4"/><circle cx="18" cy="20" r="1.4"/><path d="M2.5 3h2.6l2.4 12.2a1.7 1.7 0 0 0 1.7 1.3h8.4a1.7 1.7 0 0 0 1.7-1.3L21 7.5H6"/>',
        'message'     => '<path d="M21 11.5a7.9 7.9 0 0 1-8.5 7.9c-1.1 0-2.2-.2-3.2-.6L3 21l2.2-6.3a7.9 7.9 0 0 1 7.3-11A7.9 7.9 0 0 1 21 11.5Z"/>',
        'users'       => '<circle cx="9" cy="8" r="3.5"/><path d="M2.5 20a6.5 6.5 0 0 1 13 0"/><path d="M16.5 4.8a3.5 3.5 0 0 1 0 6.4M17.5 20a6.5 6.5 0 0 0-2.2-4.9"/>',
        'heart'       => '<path d="M12 20.5C6.5 16.8 3.5 13.6 3.5 9.9A4.4 4.4 0 0 1 12 7.6a4.4 4.4 0 0 1 8.5 2.3c0 3.7-3 6.9-8.5 10.6Z"/>',
        'stethoscope' => '<path d="M5 3v5a4 4 0 0 0 8 0V3"/><path d="M5 3H3.5M13 3h1.5"/><path d="M9 12v2.5a5 5 0 0 0 10 0V13"/><circle cx="19" cy="11" r="2"/>',
        'car'         => '<path d="M4 16.5V19a1 1 0 0 0 1 1h2v-3.5M17 16.5V20h2a1 1 0 0 0 1-1v-2.5"/><path d="M3.5 16.5h17v-4l-2-5H5.5l-2 5Z"/><path d="M3.5 12.5h17"/><circle cx="7.5" cy="16.5" r="0"/>',
        'utensils'    => '<path d="M7 2v9M4.5 2v5a2.5 2.5 0 0 0 5 0V2M7 11v11"/><path d="M17.5 2c-1.7 1.3-2.5 3.3-2.5 5.5 0 2 .8 3.5 2.5 4.5V22"/>',
        'plane'       => '<path d="M21 15.5 13.5 12V5.5a1.5 1.5 0 0 0-3 0V12L3 15.5V18l7.5-2.2V19l-2 1.5V22l3.5-1 3.5 1v-1.5L13.5 19v-3.2L21 18Z"/>',
        'shirt'       => '<path d="M9 3 4 5.5 5.5 10l2-.7V21h9V9.3l2 .7L20 5.5 15 3a3 3 0 0 1-6 0Z"/>',
        'factory'     => '<path d="M3 21V10l5.5 3.5V10L14 13.5V7l6.5 4.2V21Z"/><path d="M7 17h1.5M12 17h1.5M17 17h1.5"/>',
        'building'    => '<rect x="4.5" y="2.5" width="15" height="19" rx="1.5"/><path d="M9 7h2M13 7h2M9 11h2M13 11h2M9 15h2M13 15h2M10 21.5v-3h4v3"/>',
        'drone'       => '<rect x="9" y="9" width="6" height="6" rx="1.5"/><path d="M9 9 5.5 5.5M15 9l3.5-3.5M9 15l-3.5 3.5M15 15l3.5 3.5"/><circle cx="4.5" cy="4.5" r="2"/><circle cx="19.5" cy="4.5" r="2"/><circle cx="4.5" cy="19.5" r="2"/><circle cx="19.5" cy="19.5" r="2"/>',
        'compass'     => '<circle cx="12" cy="12" r="8.5"/><path d="m15.5 8.5-2 5.5-5.5 2 2-5.5Z"/>',
        // Contact + chrome
        'mail'        => '<rect x="2.5" y="4.5" width="19" height="15" rx="2"/><path d="m3 6.5 9 6.5 9-6.5"/>',
        'phone'       => '<path d="M7 3.5h-2A2.5 2.5 0 0 0 2.5 6c0 8 6.5 14.5 14.5 14.5A2.5 2.5 0 0 0 19.5 18v-2l-4.5-2-2 2.5A13 13 0 0 1 7.5 11L10 9Z"/>',
        'pin'         => '<path d="M12 21.5s7-5.9 7-11.5a7 7 0 1 0-14 0c0 5.6 7 11.5 7 11.5Z"/><circle cx="12" cy="10" r="2.5"/>',
        'clock'       => '<circle cx="12" cy="12" r="8.5"/><path d="M12 7v5.2l3.2 2"/>',
        'calendar'    => '<rect x="3.5" y="5" width="17" height="16" rx="2"/><path d="M3.5 10h17M8 3v4M16 3v4"/>',
        'check'       => '<path d="m5 12.5 4.5 4.5L19 7.5"/>',
        'arrow'       => '<path d="M5 12h14M13 6l6 6-6 6"/>',
        'arrow-up-right' => '<path d="M7 17 17 7M8 7h9v9"/>',
        'chevron'     => '<path d="m6 9 6 6 6-6"/>',
        'external'    => '<path d="M14 4h6v6"/><path d="M20 4 11 13"/><path d="M18 14v4.5a1.5 1.5 0 0 1-1.5 1.5h-11A1.5 1.5 0 0 1 4 18.5v-11A1.5 1.5 0 0 1 5.5 6H10"/>',
        'play'        => '<path d="M8 5.5 19 12 8 18.5Z"/>',
        'quote'       => '<path d="M9.5 7C6.5 8 5 10.3 5 13.8V17h5v-5H7.6c.2-1.7 1-2.9 2.6-3.6Z"/><path d="M18.5 7c-3 1-4.5 3.3-4.5 6.8V17h5v-5h-2.4c.2-1.7 1-2.9 2.6-3.6Z"/>',
        'menu'        => '<path d="M4 7h16M4 12h16M4 17h16"/>',
        'close'       => '<path d="M6 6l12 12M18 6 6 18"/>',
        'star'        => '<path d="m12 3 2.6 5.6 6 .8-4.4 4.2 1.1 6.1-5.3-3-5.3 3 1.1-6.1L3.4 9.4l6-.8Z"/>',
    ];

    $body = $paths[$name] ?? $paths['arrow'];

    return '<svg class="' . e($class) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" '
        . 'stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">'
        . $body . '</svg>';
}

/**
 * Look up one service by slug. Services live in four groups inside SERVICES,
 * so this walks the groups rather than indexing a flat list.
 */
function service(string $slug): array
{
    foreach (SERVICES as $group) {
        foreach ($group['items'] as $item) {
            if ($item['slug'] === $slug) {
                return $item + ['group' => $group['title'], 'group_slug' => $group['slug']];
            }
        }
    }

    throw new RuntimeException("Unknown service: {$slug}");
}

/** Every service as one flat list, in navigation order. */
function all_services(): array
{
    $flat = [];
    foreach (SERVICES as $group) {
        foreach ($group['items'] as $item) {
            $flat[] = $item + ['group' => $group['title'], 'group_slug' => $group['slug']];
        }
    }

    return $flat;
}

/** Look up one case study by slug. */
function case_study(string $slug): array
{
    foreach (CASE_STUDIES as $study) {
        if ($study['slug'] === $slug) {
            return $study;
        }
    }

    throw new RuntimeException("Unknown case study: {$slug}");
}

/** The N case studies flagged `featured`, for the home page rail. */
function featured_case_studies(int $limit = 6): array
{
    $featured = array_values(array_filter(CASE_STUDIES, static fn (array $s): bool => !empty($s['featured'])));

    return array_slice($featured, 0, $limit);
}

/**
 * Case studies most relevant to a given technology stack, ranked by how much
 * of it they share. Falls back to the featured list when nothing overlaps, so
 * a detail page always has something to show.
 */
function related_case_studies(array $stack, int $limit = 2): array
{
    $scored = [];

    foreach (CASE_STUDIES as $study) {
        $overlap = count(array_intersect($stack, $study['stack']));
        if ($overlap > 0) {
            $scored[] = ['score' => $overlap, 'study' => $study];
        }
    }

    usort($scored, static fn (array $a, array $b): int => $b['score'] <=> $a['score']);

    $related = array_slice(array_column($scored, 'study'), 0, $limit);

    return $related ?: featured_case_studies($limit);
}

/** Look up one proprietary solution by slug. */
function solution(string $slug): array
{
    foreach (AI_SOLUTIONS as $item) {
        if ($item['slug'] === $slug) {
            return $item;
        }
    }

    throw new RuntimeException("Unknown solution: {$slug}");
}

// ---------------------------------------------------------------------------
// SEO helpers
// ---------------------------------------------------------------------------

/**
 * Absolute origin for canonical and og:url tags.
 *
 * Prefers the SITE_URL env var (set it in production so canonicals are stable
 * regardless of which host header a request arrives on), and otherwise derives
 * the origin from the current request.
 */
function site_origin(): string
{
    $configured = getenv('SITE_URL');
    if (is_string($configured) && $configured !== '') {
        return rtrim($configured, '/');
    }

    $https  = ($_SERVER['HTTPS'] ?? '') === 'on'
        || ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https';
    $host   = (string) ($_SERVER['HTTP_HOST'] ?? 'localhost');

    return ($https ? 'https://' : 'http://') . $host;
}

/** Absolute canonical URL for a path, or for the current request. */
function canonical(?string $path = null): string
{
    if ($path === null) {
        $path = strtok((string) ($_SERVER['REQUEST_URI'] ?? '/'), '?') ?: '/';
        // index.php is the directory default — canonicalise to the bare path.
        $path = preg_replace('#/index\.php$#', '/', $path) ?? $path;
    } else {
        $path = url($path);
    }

    return site_origin() . $path;
}

/**
 * Compose a title that fits the ~60 character SERP limit.
 *
 * The brand suffix is dropped rather than truncated when the page's own title
 * needs the room — a clipped brand name looks worse than none.
 */
function seo_title(string $primary, ?string $brand = null): string
{
    // Pages pass a plain, human title with NO brand in it — the brand is added
    // exactly once, here. Pages used to carry their own ' | iThrive Software
    // Solutions' suffix, which then got a second brand appended and the whole
    // thing truncated mid-name at 60 characters.
    $primary = trim(preg_replace('/\s+/', ' ', $primary) ?? $primary);
    $suffix  = ' | ' . ($brand ?? SITE_NAME);

    if (mb_strlen($primary) + mb_strlen($suffix) <= 60) {
        return $primary . $suffix;
    }

    if (mb_strlen($primary) <= 60) {
        return $primary;
    }

    $cut = mb_substr($primary, 0, 59);
    $sp  = mb_strrpos($cut, ' ');

    return rtrim($sp !== false && $sp > 30 ? mb_substr($cut, 0, $sp) : $cut, " ,.—-") . '…';
}

/** Trim a meta description to the ~160 character SERP limit on a word boundary. */
function seo_description(string $text, int $limit = 158): string
{
    $text = trim(preg_replace('/\s+/', ' ', $text) ?? $text);

    if (mb_strlen($text) <= $limit) {
        return $text;
    }

    $cut = mb_substr($text, 0, $limit - 1);
    $sp  = mb_strrpos($cut, ' ');

    return rtrim($sp !== false && $sp > 80 ? mb_substr($cut, 0, $sp) : $cut, " ,.;:—-") . '…';
}

/** Render a JSON-LD block. */
function json_ld(array $data): string
{
    return '<script type="application/ld+json">'
        . json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
        . '</script>';
}

/**
 * A client's own logo, harvested from their site.
 *
 * These vary wildly — white-on-transparent (Jaumo), black line art (Coonoor
 * Club), vivid colour (Toing) — so they are always rendered on a light plate
 * rather than dropped straight onto the dark background, where roughly half of
 * them would vanish.
 */
function client_logo(array $study, string $class = ''): string
{
    if (empty($study['logo'])) {
        return '<span class="logo-plate logo-plate--text' . ($class !== '' ? ' ' . e($class) : '') . '">'
            . e($study['client']) . '</span>';
    }

    return '<span class="logo-plate' . ($class !== '' ? ' ' . e($class) : '') . '">'
        . '<img src="' . e(asset('assets/img/clients/' . $study['logo'])) . '" '
        . 'alt="' . e($study['client']) . ' logo" loading="lazy" decoding="async">'
        . '</span>';
}

/** CSRF token for the contact form. */
function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

function csrf_verify(?string $token): bool
{
    return is_string($token)
        && !empty($_SESSION['csrf_token'])
        && hash_equals($_SESSION['csrf_token'], $token);
}

/** Pull one-shot flash data set by the contact handler. */
function flash_take(string $key): mixed
{
    if (!isset($_SESSION['flash'][$key])) {
        return null;
    }

    $value = $_SESSION['flash'][$key];
    unset($_SESSION['flash'][$key]);

    return $value;
}

function flash_set(string $key, mixed $value): void
{
    $_SESSION['flash'][$key] = $value;
}

/**
 * Every real page on the site, path => human label.
 *
 * One list, used by the sitemap and by the 404 page's suggestions. Keeping them
 * on separate lists was the obvious way to write it and the wrong one: a 404
 * that offers a URL the sitemap has dropped is worse than a 404 that offers
 * nothing, because the visitor clicks it and lands on another 404.
 *
 * @return array<string, string>
 */
function site_routes(): array
{
    static $routes = null;
    if ($routes !== null) {
        return $routes;
    }

    $routes = [
        'index.php'           => 'Home',
        'services.php'        => 'Services',
        'solutions.php'       => 'Solutions',
        'case-studies.php'    => 'Case Studies',
        'company/about.php'   => 'About iThrive',
        'company/process.php' => 'Our Process',
        'company/careers.php' => 'Careers',
        'faq.php'             => 'FAQ',
        'blog.php'            => 'Blog',
        'contact.php'         => 'Contact',
    ];

    foreach (all_services() as $svc) {
        $routes['services/' . $svc['slug'] . '.php'] = $svc['title'];
    }
    foreach (AI_SOLUTIONS as $sol) {
        $routes['solutions/' . $sol['slug'] . '.php'] = $sol['name'] ?? $sol['title'] ?? $sol['slug'];
    }
    foreach (CASE_STUDIES as $study) {
        $routes['case-studies/' . $study['slug'] . '.php'] = $study['client'] ?? $study['title'];
    }

    return $routes;
}

/**
 * Words that mean the same thing to a visitor, folded to one token.
 *
 * Without this, "web-design" scores no better against "web-development" than
 * against anything else with a hyphen in it, and the visitor who typed the term
 * the industry actually uses gets sent nowhere.
 *
 * @return array<string, string>
 */
function route_synonyms(): array
{
    static $map = null;
    if ($map !== null) {
        return $map;
    }

    $groups = [
        'development' => ['dev', 'develop', 'developer', 'developers', 'development', 'design', 'designing', 'designer', 'build', 'building'],
        'web'         => ['web', 'website', 'websites', 'site', 'sites', 'webdesign'],
        'app'         => ['app', 'apps', 'application', 'applications', 'mobile'],
        'ecommerce'   => ['ecommerce', 'ecom', 'commerce', 'shop', 'store', 'shopping', 'cart'],
        'faq'         => ['faq', 'faqs', 'question', 'questions', 'answers'],
        'blog'        => ['blog', 'blogs', 'news', 'article', 'articles', 'insight', 'insights'],
        'contact'     => ['contact', 'enquiry', 'enquire', 'inquiry', 'quote', 'reach'],
        'about'       => ['about', 'team', 'company', 'who', 'story', 'people'],
        'case'        => ['case', 'cases', 'work', 'works', 'portfolio', 'project', 'projects', 'client', 'clients'],
        'ai'          => ['ai', 'ml', 'artificial', 'intelligence', 'agentic', 'llm'],
        'career'      => ['career', 'careers', 'job', 'jobs', 'hiring', 'vacancy', 'vacancies'],
        'cloud'       => ['cloud', 'devops', 'infra', 'infrastructure', 'hosting'],
        'solution'    => ['solution', 'solutions', 'product', 'products'],
        'service'     => ['service', 'services'],
    ];

    $map = [];
    foreach ($groups as $canonical => $words) {
        foreach ($words as $word) {
            $map[$word] = $canonical;
        }
    }

    return $map;
}

/**
 * Best guesses for a URL that does not exist.
 *
 * Scores every real route on how many of the words the visitor typed appear in
 * it, with string similarity of the final segment as a tie-breaker. Word overlap
 * leads because it is the stronger signal: "web-design" and "web-development"
 * are far apart as strings and obviously the same request.
 *
 * Two rules stop it from being confidently wrong, which is worse than useless
 * on a 404 — a visitor who clicks a bad guess lands on another dead end:
 *
 *  - Tokens must be at least three characters, on both sides. A one-letter
 *    token from "E-commerce" matching the "e" inside "nonsense" was enough to
 *    recommend the shop page to someone who typed gibberish.
 *  - At least half of what they typed has to appear somewhere in the route.
 *    Nothing is offered on string similarity alone.
 *
 * @return list<array{path: string, label: string, score: float}>
 */
function suggest_routes(string $requested, int $limit = 3): array
{
    $synonyms = route_synonyms();

    /** Split into canonical tokens of three characters or more. */
    $tokenise = static function (string $text) use ($synonyms): array {
        $words = preg_split('~[^a-z0-9]+~', strtolower($text)) ?: [];
        $out = [];
        foreach ($words as $word) {
            if (strlen($word) < 3) {
                continue;
            }
            $out[] = $synonyms[$word] ?? $word;
        }

        return array_values(array_unique($out));
    };

    $clean = strtolower(parse_url($requested, PHP_URL_PATH) ?? '');
    $clean = preg_replace('~\.(php|html?|aspx?)$~', '', trim($clean, '/')) ?? '';
    if ($clean === '') {
        return [];
    }

    $askedTokens = $tokenise($clean);
    if (!$askedTokens) {
        return [];
    }
    $askedTail = basename($clean);

    // "services" and "solutions" appear in most paths on this site, so on their
    // own they say nothing about which page was wanted.
    $weak = ['service' => true, 'solution' => true];
    $meaningful = array_filter($askedTokens, static fn (string $t): bool => !isset($weak[$t]));
    $denominator = max(1, count($meaningful) ?: count($askedTokens));

    $scored = [];

    foreach (site_routes() as $path => $label) {
        $target       = preg_replace('~\.php$~', '', $path) ?? $path;
        $targetTokens = $tokenise($target . ' ' . $label);

        $matched = 0;
        foreach (($meaningful ?: $askedTokens) as $token) {
            foreach ($targetTokens as $candidate) {
                $shorter = min(strlen($token), strlen($candidate));
                if ($token === $candidate
                    || ($shorter >= 4 && (str_contains($candidate, $token) || str_contains($token, $candidate)))) {
                    $matched++;
                    break;
                }
            }
        }

        $overlap = $matched / $denominator;
        if ($overlap < 0.5) {
            continue;
        }

        similar_text($askedTail, basename($target), $percent);

        $score = ($overlap * 0.72) + (($percent / 100) * 0.28);

        // Being in the right section is a real hint on a site this shape.
        foreach (['service' => 'services/', 'case' => 'case-studies/', 'solution' => 'solutions/'] as $token => $prefix) {
            if (in_array($token, $askedTokens, true) && str_starts_with($path, $prefix)) {
                $score += 0.10;
            }
        }

        if ($score >= 0.45) {
            $scored[] = ['path' => $path, 'label' => $label, 'score' => round($score, 3)];
        }
    }

    usort($scored, static fn (array $a, array $b): int => $b['score'] <=> $a['score']);

    return array_slice($scored, 0, $limit);
}
