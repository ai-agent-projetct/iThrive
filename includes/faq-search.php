<?php
/**
 * Finding the right answer among nine hundred, not just the exact question.
 *
 * The original matcher scored an entry by how many of the visitor's words
 * appeared in its question, every word counting the same. Over seventy entries
 * that worked. Over nine hundred it does not, for one reason: the words that
 * decide which answer is right are the rare ones. "How much does AI agent
 * development cost" shares "development" with four hundred entries and "agent"
 * with sixty, and the flat scorer lets the four hundred outvote the sixty.
 *
 * So each term is weighted by how rare it is across the corpus — inverse
 * document frequency, the same idea search engines have used for fifty years.
 * A term appearing in almost every entry contributes almost nothing; a term
 * appearing in three contributes a great deal. That alone is most of the
 * difference between "related to the question" and "shares a common word".
 *
 * Three more things the flat scorer could not do:
 *
 *   The ANSWER is searched, not only the question. A visitor who asks about
 *   "LoRA" gets the fine-tuning answer even though no question contains the
 *   word, because the answer does.
 *
 *   Synonyms are expanded, so "price" finds "cost", "how long" finds
 *   "timeline", and "bot" finds "chatbot" and "assistant". People do not use
 *   our vocabulary.
 *
 *   Results come back RANKED, not as a single winner. The best one is the
 *   answer; the next few are offered as related questions, which is what turns
 *   a lookup into something that feels like it understood.
 */

declare(strict_types=1);

require_once __DIR__ . '/faq-corpus.php';

/**
 * Words that mean the same thing to us but not to a string comparison.
 *
 * Expanded in one direction only — the visitor's words gain our vocabulary,
 * the corpus is left alone — so the index never has to be rebuilt to add one.
 */
const FAQ_SYNONYMS = [
    'price' => 'cost pricing', 'prices' => 'cost pricing', 'pricing' => 'cost',
    'charge' => 'cost', 'charges' => 'cost', 'rate' => 'cost', 'rates' => 'cost',
    'fee' => 'cost', 'fees' => 'cost', 'budget' => 'cost', 'quote' => 'cost estimate',
    'expensive' => 'cost', 'cheap' => 'cost', 'afford' => 'cost',

    'duration' => 'timeline long time weeks', 'deadline' => 'timeline',
    'fast' => 'timeline quick speed', 'quickly' => 'timeline quick',
    'when' => 'timeline', 'soon' => 'timeline',

    'bot' => 'chatbot assistant agent', 'bots' => 'chatbot assistant agent',
    'chatbot' => 'assistant agent chat', 'assistant' => 'chatbot agent',
    'llm' => 'ai model language', 'gpt' => 'ai model llm', 'genai' => 'generative ai',
    'ml' => 'machine learning ai', 'nlp' => 'language ai',

    'app' => 'application mobile', 'apps' => 'application mobile',
    'site' => 'website web', 'webpage' => 'website web', 'portal' => 'website web',
    'store' => 'ecommerce shop', 'shop' => 'ecommerce store',

    'hire' => 'hiring developers team', 'staff' => 'team developers hiring',
    'developer' => 'engineer developers', 'engineers' => 'developer team',
    'team' => 'developers engineers dedicated',

    'secure' => 'security', 'safety' => 'security safe', 'privacy' => 'data security',
    'gdpr' => 'compliance privacy data', 'hipaa' => 'compliance healthcare data',
    /* The stemmer turns "owns" into "own" but leaves "owner" alone, and a
       translator reaching for "Who is the owner of the code?" then matched
       nothing. Rather than stem more aggressively — which would collide short
       words across the whole index — the family is spelled out. */
    'own' => 'ownership ip', 'owns' => 'ownership ip', 'copyright' => 'ownership ip',
    'owner' => 'own ownership ip', 'owners' => 'own ownership ip',
    'owned' => 'own ownership ip', 'ownership' => 'own ip rights',
    'belong' => 'own ownership', 'belongs' => 'own ownership',

    'support' => 'maintenance after launch', 'maintain' => 'maintenance support',
    'fix' => 'support maintenance bug', 'bug' => 'support maintenance quality',

    'start' => 'begin engagement onboarding', 'begin' => 'start engagement',
    'process' => 'how we work discovery', 'steps' => 'process how',
    'contact' => 'reach email call talk',

    /* "What does your company make?" is the commonest opening question there
       is, and it reduced to two words the whole corpus uses. These point the
       generic openers at the entries that actually answer them. */
    'company' => 'ithrive software business', 'firm' => 'ithrive software company',
    'make' => 'build develop', 'makes' => 'build develop', 'making' => 'build develop',
    'build' => 'develop product', 'builds' => 'develop product',
    'offer' => 'services provide', 'offers' => 'services provide',
    'provide' => 'services offer', 'services' => 'offering capabilities do',
    'work' => 'services do', 'specialise' => 'services expertise',
    'specialize' => 'services expertise', 'expertise' => 'services capabilities',

    'late' => 'delay slip timeline overrun badly', 'delay' => 'late timeline slip',
    'overrun' => 'late budget scope', 'slip' => 'late timeline',
    'wrong' => 'badly mistake fail', 'fail' => 'badly wrong risk',
    'cancel' => 'exit notice terminate leave', 'leave' => 'exit handover notice',
    'migrate' => 'migration move switch', 'replace' => 'rebuild migration legacy',
    'legacy' => 'modernise old modernization', 'old' => 'legacy modernise',
    'integrate' => 'integration connect api', 'connect' => 'integration api',
    'scale' => 'scaling growth capacity', 'downtime' => 'uptime availability',
    'train' => 'training enablement learn', 'learn' => 'training enablement',
];

/** Tokens that carry no meaning of their own. */
const FAQ_SEARCH_STOPWORDS = [
    'the', 'a', 'an', 'and', 'or', 'but', 'is', 'are', 'was', 'were', 'be', 'been',
    'being', 'to', 'of', 'in', 'on', 'at', 'for', 'with', 'by', 'from', 'as', 'it',
    'its', 'this', 'that', 'these', 'those', 'i', 'we', 'you', 'your', 'our', 'us',
    'my', 'me', 'they', 'them', 'their', 'he', 'she', 'do', 'does', 'did', 'have',
    'has', 'had', 'can', 'could', 'would', 'should', 'will', 'shall', 'may', 'might',
    'must', 'if', 'then', 'than', 'so', 'not', 'no', 'yes', 'what', 'which', 'who',
    'whom', 'whose', 'there', 'here', 'about', 'into', 'over', 'up', 'out', 'any',
    'all', 'some', 'more', 'most', 'other', 'just', 'also', 'very', 'really', 'get',
    'got', 'am', 'please', 'tell', 'know', 'want', 'need', 'like', 'give',
];

/**
 * Split text into weighable terms.
 *
 * Splits on anything that is not a letter, a digit, a combining mark, or one of
 * the three characters that appear inside real technology names — c++, c#,
 * .net.
 *
 * Letters means Unicode letters, not a-z: the index carries Tamil, Malayalam,
 * Kannada, Telugu and Hindi alongside the English, and an a-z pattern reduced
 * every Indic sentence to nothing at all.
 *
 * Marks matter as much as letters, and leaving them out was worse than it
 * looked. In these scripts a vowel sign is a combining mark rather than a
 * letter, so \p{L} alone treats it as a separator: "செயற்கை" came apart into
 * three meaningless fragments, and every Tamil word in the index was shattered
 * the same way. Nothing errors — the index simply fills with rubbish that
 * matches nothing.
 *
 * The scripts cannot collide, which is what makes one shared index safe: no
 * Tamil token can ever equal an English one.
 */
function faq_search_terms(string $text): array
{
    $text  = mb_strtolower($text);
    $words = preg_split('/[^\p{L}\p{N}\p{M}+#.]+/u', $text, -1, PREG_SPLIT_NO_EMPTY) ?: [];
    $out   = [];

    foreach ($words as $w) {
        $w = trim($w, '.');
        if ($w === '' || mb_strlen($w) < 2) {
            continue;
        }
        if (in_array($w, FAQ_SEARCH_STOPWORDS, true)) {
            continue;
        }
        $out[] = $w;
    }

    return $out;
}

/**
 * Light stemming — enough to join "integrating" to "integration" without a
 * dictionary. Deliberately crude: over-stemming costs precision, and the IDF
 * weighting already handles the common words a stemmer would collapse.
 */
function faq_stem(string $word): string
{
    /* ASCII only. The suffix tests below count bytes, and an Indic word is
       three bytes per character — "வாரம்" would be trimmed mid-character and
       produce a token that matches nothing and corrupts the index. Those
       languages also do not form plurals with an English "s". */
    if (!preg_match('/^[a-z0-9+#.]+$/', $word)) {
        return $word;
    }

    foreach (['ations', 'ation', 'ingly', 'ing', 'ies', 'ied', 'ers', 'er', 'ed', 'es', 's'] as $suffix) {
        $len = strlen($suffix);
        if (strlen($word) > $len + 3 && substr($word, -$len) === $suffix) {
            $base = substr($word, 0, -$len);

            return $suffix === 'ies' ? $base . 'y' : $base;
        }
    }

    return $word;
}

/**
 * The searchable index: per entry, the stemmed terms of its question, answer
 * and auxiliary terms, plus the document frequency of every term.
 */
/**
 * The index's cache key: the corpus signature, plus a generation the rebuild
 * tool controls.
 *
 * Folding in the translations makes the index depend on thousands of cache
 * files as well as on the content, and checking those on every request would
 * cost more than the search does. Worse, invalidating automatically the moment
 * a visitor's question produced one new translation would rebuild the whole
 * index mid-request. So rebuilding is deliberate: tools/faq-rebuild-index.php
 * bumps the generation, and nothing else does.
 */
function faq_index_signature(): string
{
    $gen  = '0';
    $file = STORAGE_PATH . '/cache/faq-index.gen';

    if (is_file($file)) {
        $read = trim((string) file_get_contents($file));
        if ($read !== '') {
            $gen = substr(preg_replace('/[^a-zA-Z0-9]/', '', $read) ?? '0', 0, 16);
        }
    }

    return faq_corpus_signature() . '-' . $gen;
}

function faq_index(): array
{
    static $index = null;

    if ($index !== null) {
        return $index;
    }

    $sig   = faq_index_signature();
    $cache = STORAGE_PATH . '/cache/faq-index-' . $sig . '.json';

    if (is_file($cache)) {
        $data = json_decode((string) file_get_contents($cache), true);
        if (is_array($data) && isset($data['docs'], $data['df'], $data['pfx'])) {
            return $index = $data;
        }
    }

    $docs = [];
    $df   = [];

    /* The other five languages, folded into the same index.
     *
     * Once a question has been translated and cached by tools/faq-warm.php, its
     * Tamil, Malayalam, Kannada, Telugu and Hindi wordings are indexed beside
     * the English one. A Tamil visitor then matches Tamil text directly: no
     * translation on the request path, no latency, and matching that keeps
     * working when Sarvam is unreachable. Until the warmer has run there is
     * simply nothing to fold in and the index is the English one.
     */
    $other = function_exists('sarvam_translate') && defined('SARVAM_LANGS')
        ? array_diff(array_keys(SARVAM_LANGS), ['en'])
        : [];

    foreach (faq_corpus() as $n => $entry) {
        /* The question is the strongest signal, so its terms are counted three
           times; the auxiliary terms twice; the answer once. Weighting at index
           time rather than at query time keeps the query cheap. */
        $bag = [];

        foreach (faq_search_terms($entry['q']) as $t) {
            $s = faq_stem($t);
            $bag[$s] = ($bag[$s] ?? 0) + 3;
        }
        foreach (faq_search_terms($entry['terms']) as $t) {
            $s = faq_stem($t);
            $bag[$s] = ($bag[$s] ?? 0) + 2;
        }
        foreach (faq_search_terms($entry['a']) as $t) {
            $s = faq_stem($t);
            $bag[$s] = ($bag[$s] ?? 0) + 1;
        }

        foreach ($other as $lang) {
            // Cache only: building an index must never make a network call.
            $q = sarvam_translate($entry['q'], $lang, 'en', true);
            if ($q !== null && $q !== '') {
                foreach (faq_search_terms($q) as $t) {
                    $bag[$t] = ($bag[$t] ?? 0) + 3;
                }
            }

            $a = sarvam_translate($entry['a'], $lang, 'en', true);
            if ($a !== null && $a !== '') {
                foreach (faq_search_terms($a) as $t) {
                    $bag[$t] = ($bag[$t] ?? 0) + 1;
                }
            }
        }

        $docs[$n] = $bag;

        foreach (array_keys($bag) as $term) {
            $df[$term] = ($df[$term] ?? 0) + 1;
        }
    }

    /* Non-Latin terms grouped by their leading characters, so an inflected form
       the visitor typed can be resolved to the one we published without
       scanning every term in the index. Latin terms are left out: the suffix
       stemmer handles English, and a prefix rule there would fuse "contain",
       "container" and "content". */
    $pfx = [];
    foreach (array_keys($df) as $term) {
        $term = (string) $term;
        if (mb_strlen($term) < FAQ_STEM_PREFIX || preg_match('/^[a-z0-9+#.]+$/', $term)) {
            continue;
        }
        $pfx[mb_substr($term, 0, FAQ_STEM_PREFIX)][] = $term;
    }

    $index = ['docs' => $docs, 'df' => $df, 'pfx' => $pfx, 'n' => count($docs)];

    if (!is_dir(dirname($cache))) {
        @mkdir(dirname($cache), 0775, true);
    }
    if (is_dir(dirname($cache))) {
        foreach (glob(STORAGE_PATH . '/cache/faq-index-*.json') ?: [] as $stale) {
            if ($stale !== $cache) {
                @unlink($stale);
            }
        }
        @file_put_contents($cache, json_encode($index, JSON_UNESCAPED_UNICODE));
    }

    return $index;
}

/** How many leading characters two Indic words must share to count as one. */
const FAQ_STEM_PREFIX = 6;

/**
 * An indexed word this one is probably an inflection of, or null.
 *
 * Only for non-Latin tokens — English has the suffix stemmer above, and a
 * prefix rule on English would happily fuse "container" with "contain" and
 * "content". The prefix table is built once with the index, so this is a hash
 * lookup rather than a scan of forty thousand terms.
 *
 * Where several indexed words share the prefix the commonest wins: it is the
 * likeliest base form, and among words sharing six leading characters in these
 * scripts a wrong guess is nearly always the same root anyway.
 */
function faq_resolve_inflection(string $term, array $index): ?string
{
    if (mb_strlen($term) < FAQ_STEM_PREFIX || preg_match('/^[a-z0-9+#.]+$/', $term)) {
        return null;
    }

    $candidates = $index['pfx'][mb_substr($term, 0, FAQ_STEM_PREFIX)] ?? null;
    if ($candidates === null) {
        return null;
    }

    $best   = null;
    $bestDf = 0;

    foreach ($candidates as $c) {
        $df = $index['df'][$c] ?? 0;
        if ($df > $bestDf) {
            $bestDf = $df;
            $best   = $c;
        }
    }

    return $best;
}

/**
 * The visitor's own words, and ours for the same things, kept apart.
 *
 * The separation matters. Synonyms exist to find entries the visitor's exact
 * wording would miss, but they are a guess about intent, not something the
 * visitor said. When they were mixed into one list they also raised the bar the
 * match is measured against, so expanding "late" into four related words made
 * a question about a late project score WORSE — every synonym that failed to
 * land counted against the entry that did. Core terms set the bar; the extras
 * only ever add evidence.
 *
 * @return array{core: array<int, string>, extra: array<int, string>}
 */
function faq_expand_query(string $question): array
{
    $core  = [];
    $extra = [];

    foreach (faq_search_terms($question) as $t) {
        $core[] = faq_stem($t);

        if (isset(FAQ_SYNONYMS[$t])) {
            foreach (explode(' ', FAQ_SYNONYMS[$t]) as $syn) {
                $extra[] = faq_stem($syn);
            }
        }
    }

    $core  = array_values(array_unique($core));
    $extra = array_values(array_diff(array_unique($extra), $core));

    return ['core' => $core, 'extra' => $extra];
}

/**
 * Ranked answers for a question.
 *
 * Scores with inverse document frequency, so a rare term decides the match and
 * a ubiquitous one barely moves it. The score is normalised by the best
 * possible score for that query, which makes the confidence comparable between
 * a two-word question and a twenty-word one — without that, a long question
 * always looks more confident than a short one and the threshold has to be
 * guessed per length.
 *
 * @return array<int, array{entry: array, score: float, confidence: float}>
 */
function faq_search(string $question, int $limit = 5): array
{
    $index  = faq_index();
    $corpus = faq_corpus();
    $query  = faq_expand_query($question);
    $terms  = $query['core'];

    if ($terms === [] || $index['n'] === 0) {
        return [];
    }

    /*
     * Weight per term, and the best score this query could possibly achieve.
     *
     * A term we have never published still counts toward the ideal, and that is
     * the whole reason this loop looks odd. "Can you help me with my homework"
     * reduces to one word we do publish — "help" — and if the ideal were built
     * only from words we know, matching that one word would score a perfect
     * 1.00 and the assistant would confidently answer a question about
     * homework with an answer about digitising paper workflows. Counting the
     * unknown word at the rarest possible weight makes the unanswerable
     * question score near zero, which is what it should do.
     */
    $weight = [];
    $ideal  = 0.0;
    $maxIdf = log(1.0 + $index['n']);

    foreach ($terms as $t) {
        $seen = $index['df'][$t] ?? 0;

        if ($seen === 0) {
            /*
             * Before giving up on a word, try it as an inflection.
             *
             * Tamil, Malayalam, Kannada, Telugu and Hindi agglutinate, so the
             * visitor's form of a word is routinely not the form we published:
             * "பயன்படுத்தினீர்கள்" against our "பயன்படுத்துகிறீர்கள்", the same
             * verb, different ending, different token. Asked in Tamil why
             * PostGIS was used, four of six words were unseen for that reason
             * alone and the question scored 0.26 — refused, with the correct
             * answer sitting at the top of the list on a rare-term score of 6.8.
             *
             * Resolving the stem fixes that without weakening the penalty for a
             * word we genuinely never published, which is what keeps an
             * off-topic question failing.
             */
            $resolved = faq_resolve_inflection($t, $index);

            if ($resolved !== null) {
                $t    = $resolved;
                $seen = $index['df'][$t];
            } else {
                $ideal += $maxIdf * 3.0;     // unreachable: nothing can match it

                continue;
            }
        }

        // +1 inside the log so a term in every document scores ~0 rather than
        // negative, which would penalise entries for being on topic.
        $idf = log(1.0 + ($index['n'] / $seen));
        $weight[$t] = $idf;
        $ideal += $idf * 3.0;            // 3 = the weight of a hit in the question
    }

    if ($weight === [] || $ideal <= 0.0) {
        return [];
    }

    /* Our vocabulary for the visitor's words. These add evidence at a discount
       — they are an inference about meaning, not something that was said — and
       they are deliberately left out of the ideal above. */
    $bonus = [];
    foreach ($query['extra'] as $t) {
        $seen = $index['df'][$t] ?? 0;
        if ($seen > 0) {
            $bonus[$t] = log(1.0 + ($index['n'] / $seen)) * 0.5;
        }
    }

    $scored = [];
    $detail = [];

    foreach ($index['docs'] as $n => $bag) {
        $score   = 0.0;
        $hits    = 0;
        $bestIdf = 0.0;

        foreach ($weight as $term => $idf) {
            if (isset($bag[$term])) {
                // Saturating: a term repeated ten times in a long answer is not
                // ten times the evidence. Caps the contribution near 3.
                $score += $idf * min(3.0, $bag[$term]);
                $hits++;
                $bestIdf = max($bestIdf, $idf);
            }
        }

        $bonusHits = 0;

        foreach ($bonus as $term => $idf) {
            if (isset($bag[$term])) {
                $score += $idf * min(2.0, $bag[$term]);
                $bonusHits++;
            }
        }

        if ($score > 0.0) {
            $scored[$n] = $score;
            $detail[$n] = ['hits' => $hits, 'bonusHits' => $bonusHits, 'bestIdf' => $bestIdf];
        }
    }

    if ($scored === []) {
        return [];
    }

    arsort($scored);

    $out = [];
    foreach (array_slice($scored, 0, $limit, true) as $n => $score) {
        $out[] = [
            'entry'      => $corpus[$n],
            'score'      => round($score, 3),
            'confidence' => round(min(1.0, $score / $ideal), 3),
            'hits'       => $detail[$n]['hits'],
            'bonus_hits' => $detail[$n]['bonusHits'],
            'best_idf'   => round($detail[$n]['bestIdf'], 3),
        ];
    }

    return $out;
}

/**
 * The handful of questions that must not be left to word overlap.
 *
 * "What does your company do" is the commonest opening line a website
 * assistant hears, and it is exactly the question lexical scoring handles
 * worst: every word in it appears in hundreds of entries, so the winner is
 * decided by which specific answer happens to repeat "company" most — which
 * turned out to be a page about Flutter. The answer to a general question is
 * not a matter of scoring, it is a matter of editorial intent, so these few
 * are routed by hand.
 *
 * Matched against the question in lower case, first pattern wins, and each
 * points at a corpus id. An id that no longer exists is skipped rather than
 * breaking the search, so renaming an entry degrades to ordinary scoring.
 */
const FAQ_INTENTS = [
    '/\b(what|which)\b.{0,24}\b(do|does|are)\b.{0,16}\b(you|your (company|firm|team)|ithrive)\b.{0,16}\b(do|make|build|offer|provide|specialis|specializ)/i'
        => 'page:home:1',
    '/\bwho\s+(are|is)\s+(you|ithrive)\b/i'                        => 'page:home:1',
    '/\bwhat\s+(services|kind of (work|services))\b/i'             => 'page:services:1',
    '/\b(talk|speak|connect|put me)\b.{0,20}\b(human|person|someone|sales)\b/i'
        => 'page:contact:2',
    '/\bhow\s+(do|can)\s+(i|we)\s+(start|begin|get started)\b/i'   => 'page:contact:3',
    '/\bwhere\s+are\s+you\s+(based|located)\b/i'                   => 'page:home:2',
    '/\bdo\s+(we|i)\s+own\b/i'                                     => 'page:home:5',
];

/** The corpus entry with this id, or null. */
function faq_entry_by_id(string $id): ?array
{
    foreach (faq_corpus() as $entry) {
        if ($entry['id'] === $id) {
            return $entry;
        }
    }

    return null;
}

/**
 * The single best answer, or no match.
 *
 * The threshold is a share of the ideal score rather than an absolute, for the
 * reason given above. 0.35 is where, on this corpus, a genuine paraphrase still
 * lands and an unrelated question stops landing: a question matching a third of
 * its own rare vocabulary is about the topic, and one matching less is not.
 *
 * It is measured, not guessed. Across a suite of two dozen questions that must
 * be answered and eight that must be refused, the weakest true answer scores
 * 0.42 ("why did you use PostGIS for the taxi app") and the strongest false one
 * 0.32 ("recommend a good restaurant in Chennai", which collides with a case
 * study about restaurant menus). 0.35 sits in that gap with margin either side.
 *
 * @return array{matched: bool, entry: array|null, confidence: float, related: array}
 */
function faq_best(string $question, ?float $floor = null): array
{
    $floor ??= defined('FAQ_MATCH_FLOOR') ? FAQ_MATCH_FLOOR : 0.35;
    $hits = faq_search($question, 5);

    $no = static fn (float $c): array
        => ['matched' => false, 'entry' => null, 'confidence' => $c, 'related' => []];

    // Editorial routing for the general openers, before any scoring is trusted.
    foreach (FAQ_INTENTS as $pattern => $id) {
        if (preg_match($pattern, $question) !== 1) {
            continue;
        }

        $entry = faq_entry_by_id($id);
        if ($entry === null) {
            continue;                 // renamed or removed: fall through to scoring
        }

        $related = [];
        foreach (array_slice($hits, 0, 3) as $h) {
            if ($h['entry']['id'] !== $id) {
                $related[] = ['q' => $h['entry']['q'], 'url' => $h['entry']['url'], 'id' => $h['entry']['id']];
            }
        }

        return [
            'matched'    => true,
            'entry'      => $entry,
            'confidence' => 1.0,
            'related'    => array_slice($related, 0, 3),
        ];
    }

    if ($hits === []) {
        return $no(0.0);
    }

    $top = $hits[0];

    if ($top['confidence'] < $floor) {
        return $no($top['confidence']);
    }

    /*
     * One ordinary word is not a subject.
     *
     * "Can you help me with my homework" keeps exactly one term we publish —
     * "help" — and it lands on whichever entry happens to use that word most.
     * A single term is only evidence when it is a term almost nothing else
     * uses: "LoRA", "DGCA", "PostGIS", "NDA". That is what a high inverse
     * document frequency means, so it is the test applied here rather than a
     * hand-kept list of acronyms — a new one added to the corpus tomorrow
     * qualifies on its own.
     *
     * 3.5 is roughly "published in under three per cent of entries".
     *
     * Synonym hits count toward the evidence. "Who is the owner of the code?"
     * keeps two content words, but "owner" appears in three entries out of
     * nine hundred and none of them is the one that answers it — the entries
     * that do say "own", "ownership" and "IP". Counting only the visitor's
     * literal words, that question had one matched term and was refused at a
     * confidence of 0.81 while the correct answer sat at the top of the list.
     */
    if (($top['hits'] + $top['bonus_hits']) < 2 && $top['best_idf'] < 3.5) {
        return $no($top['confidence']);
    }

    // Related questions worth showing: on topic, but not so close that they are
    // restatements of the one just answered.
    $related = [];
    foreach (array_slice($hits, 1) as $h) {
        if ($h['confidence'] >= $floor * 0.55) {
            $related[] = ['q' => $h['entry']['q'], 'url' => $h['entry']['url'], 'id' => $h['entry']['id']];
        }
    }

    return [
        'matched'    => true,
        'entry'      => $hits[0]['entry'],
        'confidence' => $hits[0]['confidence'],
        'related'    => array_slice($related, 0, 3),
    ];
}
