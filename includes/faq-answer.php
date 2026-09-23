<?php
/**
 * One question in, one grounded answer out, in the visitor's language.
 *
 * This is the piece the chat endpoint calls. It puts the three halves together:
 *
 *   1. LANGUAGE IN.  The question is brought into English, because that is what
 *      the corpus is indexed on. Sarvam translates a whole sentence properly;
 *      where it is unreachable the existing lexicon folds Indic vocabulary onto
 *      English terms. Either way the matcher sees English.
 *
 *   2. RETRIEVAL.    Searched against every question the site publishes — the
 *      answer book, the service pages, the case studies, the products, the hubs
 *      — ranked by how rare the matching words are, so the answer is chosen on
 *      the terms that distinguish it rather than the ones everything shares.
 *      Near misses come back too, as related questions.
 *
 *   3. LANGUAGE OUT. The answer is translated into the visitor's language and
 *      the translation is kept, so the same answer is never paid for twice.
 *
 * What it will not do is invent. If retrieval finds nothing above the
 * confidence floor, the demo boundary is returned — in the visitor's language,
 * as it always was. An assistant that answers everything proves nothing.
 */

declare(strict_types=1);

require_once __DIR__ . '/faq-search.php';
require_once __DIR__ . '/faq-brain.php';
require_once __DIR__ . '/sarvam.php';

/**
 * Phrase a retrieved answer conversationally, grounded in that answer alone.
 *
 * Optional by design. When the model is unreachable — or says something that
 * looks nothing like the source — the stored answer is returned verbatim, which
 * is always correct if occasionally stiff.
 */
function faq_phrase(string $question, string $answer, string $lang): ?string
{
    if (!sarvam_enabled()) {
        return null;
    }

    $name = assistant_language($lang)['name'];

    $reply = sarvam_chat([
        [
            'role'    => 'system',
            'content' => "You are iThrive Software's website assistant. Answer ONLY from the CONTEXT below. "
                . "Do not add facts, figures, timelines or prices that are not in it. "
                . "If the context does not answer the question, say you do not have that detail. "
                . "Reply in {$name}. Two or three sentences, plain spoken prose, no bullet points, no markdown.",
        ],
        [
            'role'    => 'user',
            'content' => "CONTEXT:\n{$answer}\n\nQUESTION:\n{$question}",
        ],
    ], 400, 0.2);

    if ($reply === null) {
        return null;
    }

    /* A grounded answer cannot be much longer than its source. This catches the
       case where the model ignores the instruction and starts composing. */
    if (mb_strlen($reply) > mb_strlen($answer) * 1.8 + 200) {
        return null;
    }

    return $reply;
}

/**
 * Answer a visitor's question.
 *
 * @param string $question Raw text as typed, in any of the six languages.
 * @param string $lang     The language chosen in the UI.
 * @param bool   $phrase   Let the model rephrase. Off for the strict demo voice.
 *
 * @return array{
 *     matched: bool, text: string, id: string, url: string, source: string,
 *     confidence: float, lang: string, translated: bool, related: array
 * }
 */
function faq_resolve(string $question, string $lang = 'en', bool $phrase = false): array
{
    $lang = isset(SARVAM_LANGS[$lang]) ? $lang : 'en';

    // ---- 1. into English ---------------------------------------------------
    $in       = sarvam_question_to_english($question, $lang);
    $english  = $in['text'];
    $lang     = $in['lang'];                    // may be corrected by detection

    /*
     * ---- 2. retrieval --------------------------------------------------
     *
     * Searched twice for a non-English question, and the better result wins.
     *
     * A translation is a lossy re-wording, so FAQ_LEXICON gets a turn as well —
     * it folds the visitor's own Indic vocabulary onto English concepts and can
     * land where a translation drifted.
     *
     * But it is a FALLBACK, not a competitor, and the two confidences must not
     * be compared. The lexicon strips every non-Latin character, so a Hindi
     * sentence reduces to the one or two broad concepts it recognised — "cost",
     * "timeline" — and matching both of two terms scores a perfect 1.00. Asked
     * whether we could make a website faster, that path scored 1.00 and
     * answered with website pricing, beating a correct but honestly-scored
     * translation. So the lexicon is consulted only when the real sentence
     * found nothing at all.
     */
    $hit = faq_best($english);

    /*
     * The visitor's own words, against their own language in the index.
     *
     * Once tools/faq-translate.php has run, every question in the corpus exists
     * in all six languages and its Tamil, Malayalam, Kannada, Telugu and Hindi
     * wordings are indexed beside the English. So the raw sentence is worth
     * searching directly — and it is often the better of the two, because it
     * skips the translation entirely. Asked in Tamil why PostGIS was used on
     * the taxi app, the English round trip scored 0.32 and declined while the
     * same question in English scores 0.42; the Tamil text matches the Tamil
     * question in the index without losing anything on the way.
     *
     * Both confidences are computed the same way over comparable term sets, so
     * unlike the lexicon below they can honestly be compared.
     */
    if ($lang !== 'en') {
        $sameLang = faq_best($question);
        if ($sameLang['matched'] && $sameLang['confidence'] > $hit['confidence']) {
            $hit = $sameLang;
        }
    }

    if (!$hit['matched'] && $lang !== 'en') {
        $native = faq_best(faq_normalise($question));
        if ($native['matched']) {
            $hit = $native;
        }
    }

    if (!$hit['matched']) {
        return [
            'matched'    => false,
            'text'       => faq_demo_reply($lang),
            'id'         => '',
            'url'        => '',
            'source'     => '',
            'confidence' => $hit['confidence'],
            'lang'       => $lang,
            'translated' => $lang !== 'en',      // the boundary is authored in all six
            'related'    => [],
        ];
    }

    $entry  = $hit['entry'];
    $answer = $entry['a'];

    // ---- 3. out into the visitor's language -------------------------------
    $translated = false;

    if ($lang !== 'en') {
        /* Rephrasing and translating are the same call when the model is
           available: asking it to answer in Tamil from English context gives
           better prose than translating a translation. */
        $spoken = $phrase ? faq_phrase($english, $answer, $lang) : null;

        if ($spoken !== null) {
            $answer     = $spoken;
            $translated = true;
        } else {
            $direct = sarvam_translate($answer, $lang, 'en');
            if ($direct !== null && $direct !== '') {
                $answer     = $direct;
                $translated = true;
            } else {
                // Neither worked. The old behaviour — an English answer behind a
                // line in the visitor's language — is still better than nothing.
                $lead   = FAQ_LEAD_IN[$lang] ?? '';
                $answer = $lead === '' ? $answer : $lead . ' ' . $answer;
            }
        }
    } elseif ($phrase) {
        $spoken = faq_phrase($english, $answer, 'en');
        if ($spoken !== null) {
            $answer = $spoken;
        }
    }

    /* Related questions travel too, but from cache only. Three more network
       round trips to translate three links the visitor may never click is the
       difference between a reply in one second and a reply in six, and the
       answer itself is what they are waiting for. Running
       tools/warm-translations.php fills these in ahead of time. */
    $related = [];
    foreach ($hit['related'] as $r) {
        $q = $lang === 'en' ? $r['q'] : (sarvam_translate($r['q'], $lang, 'en', true) ?? $r['q']);
        $related[] = ['q' => $q, 'url' => $r['url']];
    }

    return [
        'matched'    => true,
        'text'       => $answer,
        'id'         => $entry['id'],
        'url'        => $entry['url'],
        'source'     => $entry['source'],
        'confidence' => $hit['confidence'],
        'lang'       => $lang,
        'translated' => $translated,
        'related'    => $related,
    ];
}
