<?php
/**
 * Offline answering brain.
 *
 * The site should answer questions about itself whether or not an API key is
 * configured, so this is a retrieval matcher over the same content the model is
 * grounded in. It scores the visitor's question against every service, product
 * and case study and answers from the winning record.
 *
 * It is deliberately not a chatbot: it never invents, and when nothing scores
 * well enough it hands back one of the two off-topic replies rather than
 * guessing. When ANTHROPIC_API_KEY is present the model answers instead and
 * this is only the safety net.
 */

declare(strict_types=1);

require_once __DIR__ . '/config.php';

/** Words too common to carry meaning when scoring a match. */
const AI_STOPWORDS = [
    'what','which','who','whom','whose','when','where','why','how','is','are','was',
    'were','do','does','did','can','could','would','should','will','the','a','an',
    'of','for','to','in','on','at','by','with','and','or','but','you','your','yours',
    'we','our','us','i','me','my','it','its','they','them','their','this','that',
    'these','those','have','has','had','be','been','am','tell','about','more','any',
    'some','please','give','get','show','know','like','want','need','there','from',
];

/** Split a question into meaningful lowercase terms. */
function ai_terms(string $text): array
{
    $words = preg_split('/[^a-z0-9+#.]+/i', mb_strtolower($text)) ?: [];

    return array_values(array_filter(
        $words,
        static fn (string $w): bool => $w !== '' && mb_strlen($w) > 2 && !in_array($w, AI_STOPWORDS, true)
    ));
}

/**
 * Overlap score between the question's terms and a record's searchable text.
 * Exact phrase hits count double — "lotus eye" should beat a loose word match.
 */
function ai_score(array $terms, string $haystack, string $question): int
{
    $hay   = mb_strtolower($haystack);
    $score = 0;

    foreach ($terms as $t) {
        if (str_contains($hay, $t)) {
            $score += mb_strlen($t) > 5 ? 3 : 2;
        }
    }

    $q = trim(mb_strtolower($question));
    if (mb_strlen($q) > 6 && str_contains($hay, $q)) {
        $score += 8;
    }

    return $score;
}

/**
 * Answer a question from site content.
 *
 * @return array{text: string, matched: bool}
 */
function ai_local_answer(string $question, string $lang = 'en'): array
{
    $terms = ai_terms($question);
    $t     = ASSISTANT_ANSWERS[$lang] ?? ASSISTANT_ANSWERS['en'];

    $q = mb_strtolower($question);

    // ---- Off-topic guard, before anything else -----------------------------

    // Requests asking the assistant to *perform* general work will otherwise
    // score against our records on an incidental keyword — "write me a python
    // script" hits every service that lists Python. Catch the shape of the
    // request rather than its vocabulary.
    // "Do you build react apps?" asks what we do — that is on topic. "Write a
    // react component" asks us to do the work — that is not. The difference is
    // the imperative, so anchor on it: the verb starts the message, or the
    // visitor addresses it to themselves ("write me…", "build me…").
    $verb = 'write|generate|create|build|make|code|draft|compose|produce|design|fix|debug|solve';
    $doItForMe = '/^\s*(?:please\s+)?(?:' . $verb . ')\b/i'
        . '';
    $forMe = '/\b(?:' . $verb . ')\s+(?:me|us)\b/i';

    $generalKnowledge = '/\b(capital of|who is|who was|what year|weather|translate|'
        . 'meaning of life|population of|distance between|convert \d|solve|calculate|'
        . 'recipe for|lyrics|news about|score of|define)\b/';

    if (preg_match($doItForMe, $q) || preg_match($forMe, $q) || preg_match($generalKnowledge, $q)) {
        return ['matched' => false, 'text' => ''];
    }

    // ---- Intent shortcuts, checked before record matching ------------------

    // Term matching below is English-only, so a question asked in Tamil or
    // Hindi would otherwise fall through to the off-topic reply. These carry
    // the four highest-traffic intents in all six languages. (Full multilingual
    // understanding is the model's job — this is the no-API-key floor.)
    $ML = [
        'contact' => 'தொடர்பு|மின்னஞ்சல்|முகவரி|எங்கே|ബന്ധപ്പെട|ഇമെയിൽ|എവിടെ|ಸಂಪರ್ಕ|ಇಮೇಲ್|ಎಲ್ಲಿ|'
                   . 'సంప్రదించ|ఇమెయిల్|ఎక్కడ|संपर्क|ईमेल|पता|कहाँ|कहां',
        'price'   => 'விலை|காசு|கட்டணம்|எவ்வளவு|செலவு|വില|ചെലവ്|എത്ര|ಬೆಲೆ|ಎಷ್ಟು|ವೆಚ್ಚ|'
                   . 'ధర|ఎంత|ఖర్చు|कीमत|कितना|कितने|लागत|शुल्क',
        'process' => 'செயல்முறை|எப்படி|தொடங்க|പ്രക്രിയ|എങ്ങനെ|ಪ್ರಕ್ರಿಯೆ|ಹೇಗೆ|ప్రక్రియ|ఎలా|प्रक्रिया|कैसे',
        'hiring'  => 'வேலை|பணி|ജോലി|ಕೆಲಸ|ఉద్యోగ|नौकरी|भर्ती',
    ];

    if (preg_match('/\b(contact|email|phone|call|reach|talk|speak|touch|address|located|where)\b/', $q)
        || preg_match('/(' . $ML['contact'] . ')/u', $question)) {
        return ['matched' => true, 'text' => sprintf($t['contact'], SITE_EMAIL, SITE_PHONE, SITE_HQ)];
    }

    if (preg_match('/\b(process|engage|engagement|work with|how do you work|steps|timeline|start)\b/', $q)
        || preg_match('/(' . $ML['process'] . ')/u', $question)) {
        $steps = implode(' ', array_map(
            static fn (array $s): string => "{$s['number']} {$s['title']}: {$s['body']} You walk away with: {$s['output']}.",
            PROCESS['steps']
        ));

        return ['matched' => true, 'text' => $t['process'] . ' ' . $steps];
    }

    if (preg_match('/\b(price|pricing|cost|budget|quote|rate|charge|how much)\b/', $q)
        || preg_match('/(' . $ML['price'] . ')/u', $question)) {
        return ['matched' => true, 'text' => sprintf($t['price'], SITE_EMAIL)];
    }

    if (preg_match('/\b(hiring|career|job|vacancy|apply|recruit|work for)\b/', $q)
        || preg_match('/(' . $ML['hiring'] . ')/u', $question)) {
        $roles = implode('; ', array_map(static fn (array $r): string => $r['title'], CAREERS['roles']));

        return ['matched' => true, 'text' => sprintf($t['hiring'], $roles, SITE_EMAIL)];
    }

    // ---- Score every record ------------------------------------------------

    if ($terms === []) {
        return ['matched' => false, 'text' => ''];
    }

    $best = ['score' => 0, 'text' => ''];

    foreach (all_services() as $svc) {
        $hay = $svc['title'] . ' ' . $svc['short'] . ' ' . $svc['lead'] . ' ' . $svc['group']
            . ' ' . implode(' ', $svc['stack']);
        $s = ai_score($terms, $hay, $question);
        if ($s > $best['score']) {
            $best = ['score' => $s, 'text' =>
                "{$svc['title']} — {$svc['lead']} We deliver it on " . implode(', ', $svc['stack'])
                . '. Full detail: ' . url('services/' . $svc['slug'] . '.php')];
        }
    }

    foreach (CASE_STUDIES as $study) {
        $hay = $study['client'] . ' ' . $study['title'] . ' ' . $study['industry'] . ' '
            . $study['summary'] . ' ' . $study['challenge'] . ' ' . implode(' ', $study['stack']);
        $s = ai_score($terms, $hay, $question);
        if ($s > $best['score']) {
            $metrics = implode(', ', array_map(
                static fn (array $m): string => "{$m['value']} {$m['label']}",
                $study['metrics']
            ));
            $best = ['score' => $s, 'text' =>
                "{$study['client']} — {$study['solution']} Measured outcome: {$metrics}. "
                . 'Full case study: ' . url('case-studies/' . $study['slug'] . '.php')];
        }
    }

    foreach (AI_SOLUTIONS as $sol) {
        $hay = $sol['name'] . ' ' . $sol['tagline'] . ' ' . $sol['short'] . ' ' . $sol['lead'];
        $s = ai_score($terms, $hay, $question);
        if ($s > $best['score']) {
            $best = ['score' => $s, 'text' =>
                "{$sol['name']} — {$sol['lead']} More: " . url('solutions/' . $sol['slug'] . '.php')];
        }
    }

    // A single weak keyword hit is not an answer; make it clear the bar matters.
    if ($best['score'] < 4) {
        return ['matched' => false, 'text' => ''];
    }

    // Record detail (product names, stacks, metrics) stays in English because
    // that is how it is written in content.php; the lead-in keeps the reply in
    // the visitor's language. A key gives fully translated answers.
    return ['matched' => true, 'text' => $lang === 'en'
        ? $best['text']
        : $t['found'] . "

" . $best['text']];
}

/**
 * The reply for a question that is not about Ithrive.
 *
 * Two shapes, matching the two off-topic cases: a genuine question we do not
 * cover gets the product pitch; anything unreadable gets a nudge back on topic.
 */
function ai_offtopic_answer(string $question, string $lang = 'en'): string
{
    $strings = ASSISTANT_STRINGS[$lang] ?? ASSISTANT_STRINGS['en'];

    $looksLikeQuestion = str_contains($question, '?')
        || preg_match('/^\s*(what|who|when|where|why|how|is|are|can|could|do|does|did|should|would|tell|explain)\b/i', $question) === 1
        // Devanagari, Tamil, Telugu, Kannada and Malayalam blocks — a message in
        // one of these is a real attempt at a question even without a "?".
        || preg_match('/[\x{0900}-\x{0D7F}]/u', $question) === 1;

    return $looksLikeQuestion
        ? sprintf($strings['offtopic'], SITE_EMAIL)
        : $strings['nudge'];
}
