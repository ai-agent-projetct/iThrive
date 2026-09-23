<?php
/**
 * Translate the corpus into the five Indic languages, ahead of time.
 *
 * Both halves of every entry, and both for a reason:
 *
 *   ANSWERS   so the assistant replies in the visitor's language instantly,
 *             rather than making the first person to ask that question in that
 *             language wait on a network call.
 *
 *   QUESTIONS so the SEARCH works in that language too. Once a question exists
 *             in Tamil it goes into the index beside its English original, and
 *             a Tamil visitor matches Tamil text directly — no translation on
 *             the request path, and matching that still works when Sarvam is
 *             unreachable. See faq_index() in faq-search.php.
 *
 * Sarvam bills per character (Rs20 per 10,000), so batching saves no money —
 * it saves time. Eight in flight is about twenty minutes for the full corpus
 * against three hours one at a time.
 *
 * Usage, from the project root:
 *
 *   php tools/faq-warm.php                   everything, all 5 languages
 *   php tools/faq-warm.php --book            the 450 answer-book entries only
 *   php tools/faq-warm.php ta hi             only those languages
 *   php tools/faq-warm.php --answers         answers only, skip questions
 *   php tools/faq-warm.php --limit=100       first 100 entries only
 *   php tools/faq-warm.php --concurrency=4   gentler on the API
 *   php tools/faq-warm.php --dry             report the work, call nothing
 *
 * Safe to re-run and safe to interrupt: anything already cached is skipped, so
 * a stopped run resumes where it left off.
 */

declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    exit("This is a command line tool.\n");
}

require_once dirname(__DIR__) . '/includes/config.php';
require_once dirname(__DIR__) . '/includes/faq-answer.php';

$args        = array_slice($argv, 1);
$dry         = in_array('--dry', $args, true);
$answersOnly = in_array('--answers', $args, true);
$bookOnly    = in_array('--book', $args, true);
$limit       = 0;
$concurrency = 8;
$languages   = [];

foreach ($args as $a) {
    if (str_starts_with($a, '--limit=')) {
        $limit = (int) substr($a, 8);
    } elseif (str_starts_with($a, '--concurrency=')) {
        $concurrency = max(1, min(16, (int) substr($a, 14)));
    } elseif (!str_starts_with($a, '--') && isset(SARVAM_LANGS[$a]) && $a !== 'en') {
        $languages[] = $a;
    }
}

if ($languages === []) {
    $languages = ['ta', 'ml', 'kn', 'te', 'hi'];
}

if (!sarvam_enabled() && !$dry) {
    exit("SARVAM_API_KEY is not set (environment or includes/secrets.php), so there is nothing to warm.\n");
}

$corpus = faq_corpus();

/* --book: the 450 answer-book entries only, skipping the page, service, case
   study and product FAQs. The book is the authoritative set — written to be
   spoken, carrying the prices and timelines, and where most real questions
   land. Rs1,306 against Rs2,740 for the whole corpus. */
if ($bookOnly) {
    $corpus = array_values(array_filter($corpus, static fn ($e) => $e['source'] === 'book'));
}

/* --source=service  one group at a time, so the spend can be staged.
   book, service, case, solution, page, inline -- as reported by the corpus. */
foreach ($args as $a) {
    if (!str_starts_with($a, '--source=')) {
        continue;
    }

    $want  = substr($a, 9);
    $corpus = array_values(array_filter($corpus, static fn ($e) => $e['source'] === $want));

    if ($corpus === []) {
        exit("No entries with source '{$want}'. Try: book, service, case, solution, page, inline.\n");
    }
}

if ($limit > 0) {
    $corpus = array_slice($corpus, 0, $limit);
}

$answers   = array_values(array_unique(array_map('trim', array_column($corpus, 'a'))));
$questions = $answersOnly ? [] : array_values(array_unique(array_map('trim', array_column($corpus, 'q'))));
$texts     = array_values(array_unique(array_merge($answers, $questions)));

$chars = array_sum(array_map('mb_strlen', $texts)) * count($languages);

printf(
    "Corpus %d entries%s: %d distinct texts.\n%d languages = %s characters, about Rs%s at Rs20 per 10,000.\n%d in flight.%s\n\n",
    count($corpus),
    $bookOnly ? ' (answer book only)' : '',
    count($texts),
    count($languages),
    number_format($chars),
    number_format($chars / 10000 * 20, 0),
    $concurrency,
    $dry ? "\nDRY RUN - nothing will be called." : ''
);

$started    = microtime(true);
$translated = 0;
$cached     = 0;
$failed     = 0;

foreach ($languages as $lang) {
    printf("== %s ==\n", assistant_language($lang)['name']);
    $langStart = microtime(true);
    $seen      = 0;

    foreach (array_chunk($texts, 40) as $batch) {
        // What is already on disk, before anything is called.
        $missing = [];
        foreach ($batch as $t) {
            if (sarvam_translate($t, $lang, 'en', true) !== null) {
                $cached++;
            } else {
                $missing[] = $t;
            }
        }

        $seen += count($batch);

        if ($missing !== [] && !$dry) {
            $result = sarvam_translate_many($missing, $lang, 'en', $concurrency);

            foreach ($missing as $t) {
                if (($result[trim($t)] ?? null) === null) {
                    $failed++;
                } else {
                    $translated++;
                }
            }
        } elseif ($missing !== []) {
            $translated += count($missing);        // dry run: count as work to do
        }

        printf(
            "   %4d/%d  translated %d, cached %d, failed %d  (%.0fs)\n",
            $seen,
            count($texts),
            $translated,
            $cached,
            $failed,
            microtime(true) - $langStart
        );

        /* Stop on the reasons that will not improve by trying harder. Running
           out of credits is the one that matters: without this the job grinds
           through thousands of doomed calls reporting only "failed". */
        $code = $GLOBALS['sarvam_last_error_code'] ?? '';
        $last = $GLOBALS['sarvam_last_error'] ?? '';

        if ($code === 'insufficient_quota_error') {
            printf("\nStopped: Sarvam reports no credits available.\n  %s\n", $last);
            printf("Top up at https://dashboard.sarvam.ai and re-run — everything translated\n");
            printf("so far is cached, so this resumes rather than restarting.\n");
            exit(2);
        }

        if ($failed > 60) {
            printf("\nToo many failures - stopping. Last error from Sarvam:\n  %s\n", $last ?: '(none recorded)');
            exit(1);
        }
    }

    echo "\n";
}

printf(
    "Finished in %s. %d translated, %d already cached, %d failed.\n",
    gmdate('H:i:s', (int) (microtime(true) - $started)),
    $translated,
    $cached,
    $failed
);

if ($dry) {
    echo "Dry run: nothing was called and nothing was written.\n";
} else {
    echo "\nNow rebuild the search index so the translated questions are searchable:\n";
    echo "  php tools/faq-rebuild-index.php\n";
}
