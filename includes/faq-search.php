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

    /* Words the suffix rules would merge with a different word. "officers"
       loses -ers and "offices" loses -es, both becoming "offic", so asking
       where the offices are suggested "What stops officers ignoring what they
       are assigned?". */
    if ($word === 'officer' || $word === 'officers') {
        return 'officer';
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

/**
 * A question reduced to its letters and digits, for exact lookup.
 *
 * Case, spacing and punctuation vary between how a question is written and how
 * a visitor types it back — "what is ithrive" for "What is iThrive?" — and none
 * of it changes which question it is. Marks are kept, because in the Indic
 * scripts a vowel sign is part of the word, not decoration.
 */
function faq_exact_key(string $text): string
{
    return preg_replace('/[^\p{L}\p{N}\p{M}]+/u', '', mb_strtolower(trim($text))) ?? '';
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
        if (is_array($data) && isset($data['docs'], $data['df'], $data['pfx'], $data['exact'])
            && ($data['format'] ?? 0) === 2) {
            return $index = $data;
        }
    }

    $docs  = [];
    $df    = [];
    /* faq_exact_key(question, any language) => list of [doc number, language].
       A list, because different English questions can translate to the same
       words: "What does it cost?" on three pages is one Telugu sentence. */
    $exact = [];

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

        // In corpus order, which is trust order: the answer book first.
        $exact[faq_exact_key($entry['q'])][] = [$n, 'en'];
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
                $exact[faq_exact_key($q)][] = [$n, $lang];
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

    $index = ['docs' => $docs, 'df' => $df, 'pfx' => $pfx, 'exact' => $exact, 'format' => 2, 'n' => count($docs)];

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
                /* Saturating: a term repeated ten times in a long answer is not
                   ten times the evidence. Caps the contribution near 3.
                   Raising this to 4, so that a question hit outranks three
                   answer mentions, was tried and reverted: it cost a case in
                   the English suite and moved the Malayalam price keyword onto
                   a worse answer, for no gain on the case that prompted it. */
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
    /* The (?!...) keeps the products out: "what does iThrive Chat do" is a
       question about the chat product, and the .{0,16} gap let it through to
       the general "what does iThrive do" answer. */
    '/\b(what|which)\b.{0,24}\b(do|does|are)\b.{0,16}\b(you|your (company|firm|team)|ithrive(?!\s+(chat|drive|ai)\b))\b.{0,16}\b(do|make|build|offer|provide|specialis|specializ)/i'
        => 'page:home:1',
    '/\bwho\s+(are|is)\s+(you|ithrive)\b/i'                        => 'page:home:1',
    '/\bwhat\s+(services|kind of (work|services))\b/i'             => 'page:services:1',
    '/\b(talk|speak|connect|put me)\b.{0,20}\b(human|person|someone|sales)\b/i'
        => 'page:contact:2',
    '/\bhow\s+(do|can)\s+(i|we)\s+(start|begin|get started)\b/i'   => 'page:contact:3',
    /* "Where are your offices", "what is your address", "which city are you
       in" — all the same question, and none of them matched when this asked
       only for "based" or "located". One landed on a case study about
       grievance escalation, which is the kind of answer that loses a visitor.
       The subject is named in every pattern rather than allowed to float,
       because "where is your data stored" and "where are the models hosted"
       are residency questions with their own answers, and a looser rule
       answered them with a street address. */
    '/\bwhere\s+(are|is)\s+(you|ithrive|your\s+(office|team|studio|compan|address|headquarter))/i'
        => 'page:home:2',
    '/\b(your|ithrive\'?s?)\s+(office|studio|address|head\s*office|registered\s+office)/i'
        => 'page:home:2',
    '/\bwhich\s+(city|cities|country)\s+(are|is)\s+(you|ithrive)\b/i' => 'page:home:2',
    '/\bare\s+you\s+(based|located)\b/i'                           => 'page:home:2',

    /* The company in a word or a short phrase, as a voice user says it. Each
       of these was refused or mis-routed by scoring: "vision" collides with
       computer vision, and "iThrive" alone is in half the corpus. */
    '/^\s*(about\s+)?ithrive\s*\??\s*$/i'                           => 'q452',
    '/\btell\s+me\s+about\s+(ithrive|your\s+company)\b/i'          => 'q452',
    '/^\s*(ithrive\'?s?\s+|your\s+|company\s+)?vision\s*\??\s*$/i'  => 'q454',
    '/^\s*(ithrive\'?s?\s+|your\s+|company\s+)?mission\s*\??\s*$/i' => 'q455',

    /* Hindi borrows विज़न for both meanings, so the bare word ties with
       "computer vision" — and Sarvam gives it back as "Vizan", a spelling
       rather than a translation, so the English rule above never sees it.
       Written with and without the nukta, because both are typed. */
    '/^\s*(iThrive\s+(का|की)\s+)?(विज़न|विजन)\s*[?।]?\s*$/u'          => 'q454',

    /* One word, and the answer should begin by saying what a copilot is. The
       older copilot entry is right on substance but opens mid-contrast —
       "Where it lives and who it serves" — which is no way to answer a word. */
    '/^\s*(an?\s+)?(ai\s+)?co-?pilots?\s*\??\s*$/i'                   => 'q470',
    '/^\s*(AI\s+)?கோபைலட்(கள்)?\s*\??\s*$/u'                            => 'q470',
    '/\bdo\s+(we|i)\s+own\b/i'                                     => 'page:home:5',
];

/**
 * The core topics a voice user says as a single word, in all six languages.
 *
 * One word gives scoring nothing to separate: the Hindi स्वामित्व is both
 * "ownership" and "proprietary" and landed on open-source versus proprietary
 * AI; कार्यालय matched "access your ERP from outside the office"; the Tamil
 * தொடர்பு is "contact" and "communication" at once. For these topics the
 * answer is an editorial choice, the same one the English word gets, so a
 * visitor who just says the word hears the general answer in any language.
 * Matched on the whole input, normalised by faq_exact_key(), so it never
 * fires on a word inside a longer question.
 */
const FAQ_KEYWORDS = [
    'page:home:4' => ['price', 'prices', 'pricing', 'cost', 'costs', 'rates', 'fees',
                      'விலை', 'செலவு', 'கட்டணம்', 'വില', 'ചെലവ്', 'ಬೆಲೆ', 'ವೆಚ್ಚ',
                      'ధర', 'ఖర్చు', 'कीमत', 'लागत', 'मूल्य', 'दाम'],
    'page:home:5' => ['ownership', 'code ownership', 'ip ownership', 'உரிமை', 'உரிமையாளர்',
                      'ഉടമസ്ഥാവകാശം', 'ഉടമസ്ഥത', 'ಮಾಲೀಕತ್ವ', 'యాజమాన్యం', 'స్వామ్యం', 'स्वामित्व'],
    'page:home:2' => ['office', 'offices', 'address', 'location', 'locations',
                      'அலுவலகம்', 'முகவரி', 'ഓഫീസ്', 'വിലാസം', 'ಕಚೇರಿ', 'ವಿಳಾಸ',
                      'కార్యాలయం', 'చిరునామా', 'कार्यालय', 'ऑफ़िस', 'ऑफिस', 'पता'],
    'q101'        => ['flutter', 'ஃப்ளட்டர்', 'ഫ്ലട്ടർ', 'ಫ್ಲಟರ್', 'ఫ్లట్టర్', 'फ़्लटर', 'फ्लटर'],
    'q15'         => ['agents', 'ai agents', 'ai agent', 'AI ஏஜென்ட்கள்', 'AI முகவர்கள்', 'AI ഏജന്റുകൾ',
                      'AI ಏಜೆಂಟ್‌ಗಳು', 'AI ఏజెంట్లు', 'AI एजेंट'],
    'q80'         => ['chatbot', 'chatbots', 'chat bot', 'சாட்பாட்', 'ചാറ്റ്ബോട്ട്', 'ಚಾಟ್‌ಬಾಟ್',
                      'చాట్‌బాట్', 'चैटबॉट', 'चैटबोट'],
    'q76'         => ['security', 'data security', 'privacy', 'பாதுகாப்பு', 'தரவுப் பாதுகாப்பு', 'സുരക്ഷ',
                      'ಭದ್ರತೆ', 'ಸುರಕ್ಷತೆ', 'భద్రత', 'సురక్షిత', 'सुरक्षा', 'डेटा सुरक्षा'],
    'q83'         => ['timeline', 'timelines', 'duration', 'how long', 'கால அளவு', 'காலக்கெடு',
                      'സമയപരിധി', 'ಸಮಯಾವಧಿ', 'ಕಾಲಾವಧಿ', 'కాలపరిమితి', 'समय-सीमा', 'समय सीमा', 'अवधि'],
    'q7'          => ['maintenance', 'support', 'after launch support', 'பராமரிப்பு', 'പരിപാലനം',
                      'ನಿರ್ವಹಣೆ', 'నిర్వహణ', 'रखरखाव'],
    'q431'        => ['contact', 'contact us', 'get started', 'தொடர்பு', 'தொடர்பு கொள்ள', 'ബന്ധപ്പെടുക',
                      'ಸಂಪರ್ಕ', 'సంప్రదించండి', 'సంప్రదింపు', 'संपर्क'],
    'q454'        => ['vision', 'தொலைநோக்கு', 'ദർശനം', 'ದೂರದೃಷ್ಟಿ', 'దార్శనికత', 'विज़न', 'विजन'],
    'q455'        => ['mission', 'பணி நோக்கம்', 'ദൗത്യം', 'ಧ್ಯೇಯ', 'ధ్యేయం', 'मिशन'],
    'q470'        => ['copilot', 'copilots', 'ai copilot', 'கோபைலட்', 'AI கோபைலட்', 'കോപൈലറ്റ്',
                      'AI കോപൈലറ്റ്', 'ಕೋಪೈಲಟ್', 'AI ಕೋಪೈಲಟ್', 'కోపైలట్', 'AI కోపైలట్', 'कोपायलट',
                      'AI कोपायलट'],
];

/** The FAQ_KEYWORDS entry this whole input names, or null. */
function faq_keyword_id(string $question): ?string
{
    static $map = null;
    if ($map === null) {
        $map = [];
        foreach (FAQ_KEYWORDS as $id => $words) {
            foreach ($words as $w) {
                $map[faq_exact_key($w)] = $id;
            }
        }
    }

    return $map[faq_exact_key($question)] ?? null;
}

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
/**
 * A question the FAQ already asks, word for word, in any of the six languages.
 *
 * Scoring is the wrong tool for this case and it fails in a particular way.
 * "What is iThrive?" is made of the three commonest words in the corpus, so
 * word overlap had nothing to trust and the assistant refused it; "What is
 * iThrive's vision?" scored an answer about the Idea-to-Words workflow, and the
 * Tamil for "What is iThrive?" came back as "What is a Micro SaaS?" because
 * "what is" outweighed everything else. A visitor who types a question we
 * publish — or taps a suggestion chip, which sends exactly that text — should
 * get that question's answer, with nothing to score.
 *
 * @return array{matched: bool, entry: array|null, confidence: float, related: array, lang: string}
 */
/**
 * Whether a corpus url ("case-studies/madura-grandeur.php") is the page a
 * visitor is on ("/case-studies/madura-grandeur", "/ithrive/case-studies/…php").
 * Extensionless URLs are served by .htaccess, and the site may sit in a
 * subfolder, so the corpus path is matched against the end of the visitor's.
 */
function faq_same_page(string $url, string $page): bool
{
    $norm = static fn (string $p): string => preg_replace(
        ['#[?\#].*$#', '#\.php$#', '#/index$#', '#^/+|/+$#'], ['', '', '', ''], $p) ?? '';

    $url  = $norm($url);
    $page = $norm($page);
    if ($url === '' || $url === 'index') {
        return $page === '' || $page === 'index';
    }

    return $page === $url || str_ends_with($page, '/' . $url);
}

function faq_exact(string $question, string $page = '', string $preferId = ''): array
{
    $found = faq_index()['exact'][faq_exact_key($question)] ?? null;
    if ($found === null) {
        return ['matched' => false, 'entry' => null, 'confidence' => 0.0, 'related' => [], 'lang' => ''];
    }

    /* Several entries can share one wording — "How long did it take?" is a
       question on every case study. Choose, in order: the entry a suggestion
       chip named (honoured only because the text really is that entry's
       question, so a stale or forged id cannot pull in anything else), then
       the entry published on the page the visitor is reading, then the most
       trusted source. */
    $corpus = faq_corpus();
    $pick   = null;
    foreach ($found as $cand) {
        if ($preferId !== '' && $corpus[$cand[0]]['id'] === $preferId) {
            $pick = $cand;
            break;
        }
    }
    if ($pick === null && $page !== '') {
        foreach ($found as $cand) {
            if (faq_same_page($corpus[$cand[0]]['url'], $page)) {
                $pick = $cand;
                break;
            }
        }
    }
    $pick ??= $found[0];

    [$n, $lang] = $pick;
    $entry = $corpus[$n];

    /* Suggestions from the same set first. Nearest by words, "What is
       iThrive?" offered "What is a Micro SaaS?" — the words "what is" again,
       not the next thing a visitor asking about the company wants. Someone
       who asked one question from a set is best served by its neighbours. */
    $same = []; $other = [];
    foreach (faq_search($question, 12) as $h) {
        $e = $h['entry'];
        if ($e['id'] === $entry['id']) {
            continue;
        }
        $row = ['q' => $e['q'], 'url' => $e['url'], 'id' => $e['id']];
        // Same category and same page: a book category, or one service page's
        // own ten — "Service page" alone would lump all nineteen together.
        $e['label'] === $entry['label'] && $e['url'] === $entry['url'] ? $same[] = $row : $other[] = $row;
    }

    /* When word overlap finds none of the set, offer the set's own next
       questions anyway. "How do engagements usually start?" shares no
       distinctive words with "What does a typical project cost?", so the
       chips fell back to ROI measurement and e-commerce conversion — related
       to nothing the visitor had asked. The questions published beside it are
       the natural follow-ups. */
    if (count($same) < 3) {
        $have = array_column($same, 'id');
        $set  = array_values(array_filter($corpus, static fn ($e) =>
            $e['label'] === $entry['label'] && $e['url'] === $entry['url'] && $e['id'] !== $entry['id']));
        // Start after the asked question, wrapping round, so the next ones come first.
        $pos = array_flip(array_column($corpus, 'id'));
        $at  = $pos[$entry['id']];
        $len = count($corpus);
        usort($set, static fn ($x, $y) =>
            (($pos[$x['id']] - $at + $len) % $len) <=> (($pos[$y['id']] - $at + $len) % $len));
        foreach ($set as $e) {
            if (count($same) >= 3) { break; }
            if (!in_array($e['id'], $have, true)) {
                $same[] = ['q' => $e['q'], 'url' => $e['url'], 'id' => $e['id']];
            }
        }
    }

    return [
        'matched'    => true,
        'entry'      => $entry,
        'confidence' => 1.0,
        'related'    => array_slice([...$same, ...$other], 0, 3),
        'lang'       => $lang,
        'routed'     => true,     // decisive: nothing scored should replace it
    ];
}

function faq_best(string $question, ?float $floor = null): array
{
    $floor ??= defined('FAQ_MATCH_FLOOR') ? FAQ_MATCH_FLOOR : 0.35;

    $exact = faq_exact($question);
    if ($exact['matched']) {
        return $exact;
    }

    $hits = faq_search($question, 5);

    $no = static fn (float $c): array
        => ['matched' => false, 'entry' => null, 'confidence' => $c, 'related' => []];

    // A core topic said as one word, in any of the six languages.
    $kwId = faq_keyword_id($question);
    if ($kwId !== null && ($entry = faq_entry_by_id($kwId)) !== null) {
        $related = [];
        foreach (array_slice($hits, 0, 4) as $h) {
            if ($h['entry']['id'] !== $kwId) {
                $related[] = ['q' => $h['entry']['q'], 'url' => $h['entry']['url'], 'id' => $h['entry']['id']];
            }
        }

        return [
            'matched'    => true,
            'entry'      => $entry,
            'confidence' => 1.0,
            'related'    => array_slice($related, 0, 3),
            'routed'     => true,
        ];
    }

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
            'routed'     => true,     // an editorial decision, not a score
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
