<?php
/**
 * Rebuild the FAQ search index, folding in every translation cached so far.
 *
 * Run this after tools/faq-warm.php. Until it runs, the index is whatever it
 * was: the search keeps working in English and the new languages are simply not
 * searchable yet. That is deliberate — see faq_index_signature().
 *
 *   php tools/faq-rebuild-index.php
 *   php tools/faq-rebuild-index.php --stats    report what is in it, change nothing
 */

declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    exit("This is a command line tool.\n");
}

require_once dirname(__DIR__) . '/includes/config.php';
require_once dirname(__DIR__) . '/includes/faq-answer.php';   // pulls in sarvam + search

$statsOnly = in_array('--stats', array_slice($argv, 1), true);

$corpus = faq_corpus();
printf("Corpus: %d entries.\n", count($corpus));

// How much of the corpus has been translated, per language.
$langs = array_diff(array_keys(SARVAM_LANGS), ['en']);
$have  = [];

foreach ($langs as $lang) {
    $q = 0;
    $a = 0;
    foreach ($corpus as $e) {
        if (sarvam_translate($e['q'], $lang, 'en', true) !== null) { $q++; }
        if (sarvam_translate($e['a'], $lang, 'en', true) !== null) { $a++; }
    }
    $have[$lang] = ['q' => $q, 'a' => $a];
    printf(
        "  %-10s questions %4d/%d   answers %4d/%d\n",
        assistant_language($lang)['name'],
        $q,
        count($corpus),
        $a,
        count($corpus)
    );
}

if ($statsOnly) {
    $file = STORAGE_PATH . '/cache/faq-index.gen';
    printf("\nIndex generation: %s\n", is_file($file) ? trim((string) file_get_contents($file)) : '0 (never rebuilt)');
    $index = faq_index();
    printf("Index: %d documents, %d distinct terms.\n", $index['n'], count($index['df']));

    exit(0);
}

// Bump the generation, which is what makes the old index file unreachable.
$dir = STORAGE_PATH . '/cache';
if (!is_dir($dir)) {
    @mkdir($dir, 0775, true);
}

$gen = substr(bin2hex(random_bytes(6)), 0, 12);
file_put_contents($dir . '/faq-index.gen', $gen);
printf("\nIndex generation -> %s\n", $gen);

// Drop every index file; the current one is rebuilt below, the rest are stale.
foreach (glob($dir . '/faq-index-*.json') ?: [] as $old) {
    @unlink($old);
}

$t = microtime(true);
$index = faq_index();
printf(
    "Rebuilt in %.1fs: %d documents, %d distinct terms.\n",
    microtime(true) - $t,
    $index['n'],
    count($index['df'])
);

// A term in a non-Latin script proves the translations actually landed.
$indic = 0;
foreach (array_keys($index['df']) as $term) {
    if (preg_match('/[\p{Tamil}\p{Malayalam}\p{Kannada}\p{Telugu}\p{Devanagari}]/u', (string) $term)) {
        $indic++;
    }
}
printf("Of those, %d are Indic-script terms.\n", $indic);
