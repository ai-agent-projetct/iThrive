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
function ai_local_answer(string $question): array
{
    $terms = ai_terms($question);

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

    if (preg_match('/\b(contact|email|phone|call|reach|talk|speak|touch|address|located|where)\b/', $q)) {
        return ['matched' => true, 'text' =>
            'You can email ' . SITE_EMAIL . ' or call ' . SITE_PHONE . '. We are based in ' . SITE_HQ
            . '. Send a paragraph about the workflow you want to fix and you will get a written build plan — '
            . 'scope, stack and a realistic timeline — within two working days.'];
    }

    if (preg_match('/\b(process|engage|engagement|work with|how do you work|steps|timeline|start)\b/', $q)) {
        $steps = implode(' ', array_map(
            static fn (array $s): string => "{$s['number']} {$s['title']}: {$s['body']} You walk away with: {$s['output']}.",
            PROCESS['steps']
        ));

        return ['matched' => true, 'text' => 'Every engagement runs through three gates. ' . $steps];
    }

    if (preg_match('/\b(price|pricing|cost|budget|quote|rate|charge|how much)\b/', $q)) {
        return ['matched' => true, 'text' =>
            'Pricing depends on scope, so we do not publish a rate card — and I will not guess at a number. '
            . 'What happens instead: you describe the workflow, we run a discovery pass, and you get a fixed '
            . 'scope and price in writing before any production code is written. Email ' . SITE_EMAIL . ' to start that.'];
    }

    if (preg_match('/\b(hiring|career|job|vacancy|apply|recruit|work for)\b/', $q)) {
        $roles = implode('; ', array_map(static fn (array $r): string => $r['title'], CAREERS['roles']));

        return ['matched' => true, 'text' => "We are hiring: {$roles}. Everyone here writes code, talks to "
            . 'clients and owns something in production. Send your work to ' . SITE_EMAIL . '.'];
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
    return $best['score'] >= 4
        ? ['matched' => true, 'text' => $best['text']]
        : ['matched' => false, 'text' => ''];
}

/**
 * The reply for a question that is not about Ithrive.
 *
 * Two shapes, matching the two off-topic cases: a genuine question we do not
 * cover gets the product pitch; anything unreadable gets a nudge back on topic.
 */
function ai_offtopic_answer(string $question): string
{
    $looksLikeQuestion = str_contains($question, '?')
        || preg_match('/^\s*(what|who|when|where|why|how|is|are|can|could|do|does|did|should|would|tell|explain)\b/i', $question) === 1;

    if ($looksLikeQuestion) {
        return 'I only cover Ithrive — what we build, how we work, and the platforms we have shipped — '
            . 'so I am the wrong assistant for that one. An Ithrive AI Agent trained on your own business '
            . 'would answer questions like that properly, and that is exactly what we build. Want to talk about one? '
            . 'Email ' . SITE_EMAIL . '.';
    }

    return 'Ask me something about Ithrive or our services and I will give you a detailed answer — '
        . 'try "what do you build with Python and AI?" or "what did you build for Lotus Eye Hospital?".';
}
