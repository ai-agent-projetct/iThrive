<?php
/**
 * Every question the site publishes, in one searchable corpus.
 *
 * The assistant used to search one file — includes/faq.php, the answer book.
 * Meanwhile the service pages, the case studies, the two products and the hub
 * pages grew FAQ sections of their own, and a handful of pages carry the
 * questions inline in their own source. A visitor could read an answer on the
 * page and then be told by the assistant on that same page that the question
 * was outside what it covers. This gathers all of it.
 *
 * Sources, in the order they are trusted when two entries say the same thing:
 *
 *   1. FAQ              the answer book — written to be spoken, priced, checked
 *   2. SERVICE_FAQS     ten per service page
 *   3. SOLUTION_FAQS    ten per product
 *   4. CASE_FAQS        ten per case study
 *   5. PAGE_FAQS        ten per hub and company page
 *   6. inline $faqs     the few pages that predate the shared content files
 *
 * The sixth is read out of the page source by PHP's own tokeniser rather than
 * by executing the page, because executing it would render it. It is parsed,
 * not evaluated: only string literals and array structure are read, so nothing
 * in those files can run from here.
 *
 * Building the corpus walks six files and six page sources, so the result is
 * cached to storage/cache and rebuilt only when one of them changes.
 */

declare(strict_types=1);

/**
 * Pages that still declare their questions inline as a `$faqs` array.
 *
 * mvp-development.php is deliberately absent: it builds its list by filtering
 * the answer book by id, so its questions are already in the corpus and parsing
 * the page would only produce duplicates.
 */
const FAQ_INLINE_PAGES = [
    'services/poc-development.php',
    'services/micro-saas-development.php',
    'services/on-demand-resources.php',
    'services/dedicated-engineering-team.php',
];

/**
 * Pages whose FAQ is static markup rather than data — a heading and a paragraph
 * per card. Only the section carrying id="faq" is read, so the page's other
 * headings cannot be mistaken for questions.
 */
const FAQ_INLINE_HTML_PAGES = [
    'services/ecommerce-development.php',
];

/**
 * Pull `$faqs = [ ['question', 'answer'], ... ];` out of a page without running it.
 *
 * Uses token_get_all, so a quoted bracket inside an answer cannot end the array
 * early and a concatenated answer spanning five lines is reassembled correctly.
 * Anything that is not a plain string literal is skipped rather than guessed at.
 *
 * @return array<int, array{q: string, a: string}>
 */
function faq_parse_inline(string $file): array
{
    if (!is_file($file)) {
        return [];
    }

    $tokens = token_get_all((string) file_get_contents($file));
    $count  = count($tokens);

    // Find `$faqs` followed by `=` followed by `[`.
    $start = null;
    for ($i = 0; $i < $count; $i++) {
        $t = $tokens[$i];
        if (!is_array($t) || $t[0] !== T_VARIABLE || $t[1] !== '$faqs') {
            continue;
        }
        for ($j = $i + 1; $j < $count; $j++) {
            $n = $tokens[$j];
            if (is_array($n) && in_array($n[0], [T_WHITESPACE, T_COMMENT, T_DOC_COMMENT], true)) {
                continue;
            }
            if ($n === '=') {
                continue;
            }
            if ($n === '[') {
                $start = $j;
            }
            break;
        }
        if ($start !== null) {
            break;
        }
    }

    if ($start === null) {
        return [];
    }

    /* Walk the literal, collecting strings by nesting depth. Depth 1 is the
       outer list, depth 2 is one question-and-answer pair. */
    $out   = [];
    $depth = 0;
    $pair  = [];
    $piece = null;

    for ($i = $start; $i < $count; $i++) {
        $t = $tokens[$i];

        if ($t === '[') {
            $depth++;
            if ($depth === 2) {
                $pair = [];
            }

            continue;
        }

        if ($t === ']') {
            if ($piece !== null) {
                $pair[] = $piece;
                $piece = null;
            }
            $depth--;
            if ($depth === 1 && count($pair) >= 2) {
                $out[] = ['q' => trim($pair[0]), 'a' => trim($pair[1])];
            }
            if ($depth === 0) {
                break;
            }

            continue;
        }

        if ($t === ',' && $depth >= 2) {
            if ($piece !== null) {
                $pair[] = $piece;
                $piece = null;
            }

            continue;
        }

        if (is_array($t) && $t[0] === T_CONSTANT_ENCAPSED_STRING) {
            // Strip the quotes and unescape exactly as PHP would have.
            $lit = $t[1];
            $q   = $lit[0];
            $body = substr($lit, 1, -1);
            $body = $q === "'"
                ? str_replace(["\\'", '\\\\'], ["'", '\\'], $body)
                : stripcslashes($body);

            $piece = ($piece ?? '') . $body;      // '.' concatenation just accumulates
        }
    }

    return $out;
}

/**
 * Pull question-and-answer pairs out of a page that writes them as markup.
 *
 * Scoped to the element carrying id="faq" and to heading-then-paragraph pairs
 * inside it, so a heading elsewhere on the page cannot be read as a question.
 *
 * @return array<int, array{q: string, a: string}>
 */
function faq_parse_inline_html(string $file): array
{
    if (!is_file($file)) {
        return [];
    }

    $src = (string) file_get_contents($file);

    $at = strpos($src, 'id="faq"');
    if ($at === false) {
        return [];
    }

    // As far as the next section, or a generous window if this is the last one.
    $end = strpos($src, '</section>', $at);
    $body = substr($src, $at, ($end === false ? 12000 : $end - $at));

    if (!preg_match_all('#<h3[^>]*>(.*?)</h3>\s*<p[^>]*>(.*?)</p>#si', $body, $m, PREG_SET_ORDER)) {
        return [];
    }

    $clean = static function (string $s): string {
        $s = preg_replace('/<[^>]+>/', ' ', $s) ?? $s;
        $s = html_entity_decode($s, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        return trim(preg_replace('/\s+/', ' ', $s) ?? $s);
    };

    $out = [];
    foreach ($m as $pair) {
        $q = $clean($pair[1]);
        $a = $clean($pair[2]);
        // A PHP expression that survived the tag strip is not an answer.
        if ($q === '' || $a === '' || str_contains($q . $a, '<?')) {
            continue;
        }
        $out[] = ['q' => $q, 'a' => $a];
    }

    return $out;
}

/** Build the corpus from every source. Slow enough to be worth caching. */
function faq_corpus_build(): array
{
    $entries = [];
    $seen    = [];

    /* One entry, deduplicated on the question text so the same question
       published in two places does not appear twice in the results. */
    $add = static function (
        string $id,
        string $q,
        string $a,
        string $terms,
        string $source,
        string $label,
        string $url
    ) use (&$entries, &$seen): void {
        $q = trim($q);
        $a = trim($a);
        if ($q === '' || $a === '') {
            return;
        }

        $key = preg_replace('/[^a-z0-9]+/', '', mb_strtolower($q)) ?? '';
        if ($key === '' || isset($seen[$key])) {
            return;
        }
        $seen[$key] = true;

        $entries[] = [
            'id'     => $id,
            'q'      => $q,
            'a'      => $a,
            'terms'  => $terms,
            'source' => $source,
            'label'  => $label,
            'url'    => $url,
        ];
    };

    // 1. The answer book. First, so its wording wins any duplicate.
    if (defined('FAQ')) {
        foreach (FAQ as $f) {
            $add(
                $f['id'],
                $f['q'],
                $f['a'],
                $f['terms'] ?? '',
                'book',
                FAQ_CATEGORIES[$f['cat']] ?? 'iThrive FAQ',
                'faq.php'
            );
        }
    }

    // 2-5. The catalogues, each keyed by slug.
    $sets = [
        ['SERVICE_FAQS',  'service',  'services/%s.php',      'Service page'],
        ['SOLUTION_FAQS', 'solution', 'solutions/%s.php',     'Product page'],
        ['CASE_FAQS',     'case',     'case-studies/%s.php',  'Case study'],
    ];

    foreach ($sets as [$constant, $source, $pattern, $label]) {
        if (!defined($constant)) {
            continue;
        }
        foreach (constant($constant) as $slug => $faqs) {
            foreach ($faqs as $i => $f) {
                $add(
                    $source . ':' . $slug . ':' . ($i + 1),
                    $f['q'],
                    $f['a'],
                    '',
                    $source,
                    $label,
                    sprintf($pattern, $slug)
                );
            }
        }
    }

    // The hub and company pages, whose keys are not slugs.
    $pageUrls = [
        'home'                 => 'index.php',
        'services'             => 'services.php',
        'solutions'            => 'solutions.php',
        'blog'                 => 'blog.php',
        'case-studies'         => 'case-studies.php',
        'contact'              => 'contact.php',
        'about'                => 'company/about.php',
        'careers'              => 'company/careers.php',
        'process'              => 'company/process.php',
        'reactjs-development'  => 'services/reactjs-development.php',
    ];

    if (defined('PAGE_FAQS')) {
        foreach (PAGE_FAQS as $key => $faqs) {
            foreach ($faqs as $i => $f) {
                $add(
                    'page:' . $key . ':' . ($i + 1),
                    $f['q'],
                    $f['a'],
                    '',
                    'page',
                    'Site page',
                    $pageUrls[$key] ?? 'index.php'
                );
            }
        }
    }

    // 6. The pages that still hold their questions in their own source.
    foreach (FAQ_INLINE_PAGES as $rel) {
        foreach (faq_parse_inline(ROOT_PATH . '/' . $rel) as $i => $f) {
            $add(
                'inline:' . basename($rel, '.php') . ':' . ($i + 1),
                $f['q'],
                $f['a'],
                '',
                'inline',
                'Service page',
                $rel
            );
        }
    }

    foreach (FAQ_INLINE_HTML_PAGES as $rel) {
        foreach (faq_parse_inline_html(ROOT_PATH . '/' . $rel) as $i => $f) {
            $add(
                'markup:' . basename($rel, '.php') . ':' . ($i + 1),
                $f['q'],
                $f['a'],
                '',
                'inline',
                'Service page',
                $rel
            );
        }
    }

    return $entries;
}

/** A signature that changes whenever any source of the corpus changes. */
function faq_corpus_signature(): string
{
    $parts = [];

    foreach ([
        'faq.php', 'content-service-faqs.php', 'content-case-faqs.php',
        'content-solution-faqs.php', 'content-page-faqs.php',
    ] as $file) {
        $path = __DIR__ . '/' . $file;
        $parts[] = $file . ':' . (is_file($path) ? filemtime($path) : 0);
    }

    foreach (array_merge(FAQ_INLINE_PAGES, FAQ_INLINE_HTML_PAGES) as $rel) {
        $path = ROOT_PATH . '/' . $rel;
        $parts[] = $rel . ':' . (is_file($path) ? filemtime($path) : 0);
    }

    return substr(hash('sha256', implode('|', $parts)), 0, 16);
}

/**
 * The corpus, built once per process and cached to disk between requests.
 *
 * @return array<int, array{id: string, q: string, a: string, terms: string, source: string, label: string, url: string}>
 */
function faq_corpus(): array
{
    static $corpus = null;

    if ($corpus !== null) {
        return $corpus;
    }

    $sig   = faq_corpus_signature();
    $cache = STORAGE_PATH . '/cache/faq-corpus-' . $sig . '.json';

    if (is_file($cache)) {
        $data = json_decode((string) file_get_contents($cache), true);
        if (is_array($data) && $data !== []) {
            return $corpus = $data;
        }
    }

    $corpus = faq_corpus_build();

    // Best effort: a host with an unwritable storage directory still works, it
    // just rebuilds each request.
    if (!is_dir(dirname($cache))) {
        @mkdir(dirname($cache), 0775, true);
    }
    if (is_dir(dirname($cache))) {
        foreach (glob(STORAGE_PATH . '/cache/faq-corpus-*.json') ?: [] as $stale) {
            if ($stale !== $cache) {
                @unlink($stale);
            }
        }
        @file_put_contents($cache, json_encode($corpus, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }

    return $corpus;
}
