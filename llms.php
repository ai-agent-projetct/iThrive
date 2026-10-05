<?php
/**
 * llms.txt — the site in one page of Markdown, for AI assistants.
 *
 * An assistant asked "who builds AI agents in Chennai" reads this rather than
 * crawling forty pages of 3D heroes. Generated from the same content layer as
 * the sitemap, so a new service or case study appears here the moment it
 * exists. Served at /llms.txt via the rewrite in .htaccess.
 */

declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';

header('Content-Type: text/plain; charset=utf-8');

$line = static fn (string $label, string $path, string $text = ''): string =>
    '- [' . $label . '](' . canonical($path) . ')' . ($text !== '' ? ': ' . trim($text) : '') . "\n";

$out  = '# ' . SITE_NAME . "\n\n";
$out .= '> ' . SITE_NAME . ' builds AI agents, AI-native platforms, web and mobile applications in Python '
      . 'for enterprises and startups. Studios in ' . SITE_HQ . "; clients across India, the US, Canada, "
      . "the UK and the Gulf.\n\n";

$out .= '- Email: ' . SITE_EMAIL . "\n";
if (site_phone() !== null) {
    $out .= '- Phone: ' . site_phone() . "\n";
}
$out .= "- Languages: English, Tamil, Malayalam, Kannada, Telugu and Hindi (the site assistant answers in all six)\n";
$out .= '- Offices:' . "\n";
foreach (OFFICES as $office) {
    $out .= '  - ' . $office['label'] . ': ' . implode(', ', office_lines($office)) . "\n";
}

$out .= "\n## Services\n\n";
$out .= $line('Custom Software Development in India', 'services/software-development.php',
    'Custom software, enterprise platforms and AI-native products.');
$out .= $line('AI Development Company in India', 'services/ai-development-company.php',
    'Custom LLMs, RAG, AI agents and computer vision.');
foreach (all_services() as $svc) {
    $out .= $line($svc['title'], 'services/' . $svc['slug'] . '.php', $svc['short']);
}

$out .= "\n## Products\n\n";
foreach (AI_SOLUTIONS as $sol) {
    $out .= $line($sol['name'], 'solutions/' . $sol['slug'] . '.php', $sol['tagline'] . ' ' . $sol['short']);
}

$out .= "\n## Case studies\n\n";
foreach (CASE_STUDIES as $study) {
    $out .= $line($study['title'], 'case-studies/' . $study['slug'] . '.php',
        $study['industry'] . '. ' . $study['summary']);
}

$out .= "\n## Locations\n\n";
foreach (LOCATIONS as $loc) {
    $out .= $line($loc['keyword'], 'locations/' . $loc['slug'] . '.php', $loc['lead']);
}
$out .= $line('Working with us from outside India', 'locations/global-delivery.php',
    'Time-zone overlap with US, UK, Canadian and Gulf teams, and your IP from day one.');

$out .= "\n## Company\n\n";
$out .= $line('About', 'company/about.php');
$out .= $line('How we work', 'company/process.php', 'Discovery, Clarity and Execution — three gates, each ending in a deliverable.');
$out .= $line('Careers', 'company/careers.php');
$out .= $line('Frequently asked questions', 'faq.php', 'Pricing, timelines, IP, support and AI.');
$out .= $line('Blog', 'blog.php');
$out .= $line('Contact', 'contact.php', 'A written build plan — scope, stack and timeline — within two working days.');

echo $out;
