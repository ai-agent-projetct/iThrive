<?php
/**
 * Ten questions and answers per solution page, keyed by solution slug.
 *
 * templates/solution-detail.php renders whatever it finds here and emits it as
 * FAQPage structured data. A slug with no entry simply renders no FAQ section,
 * so this file can be filled a product at a time.
 *
 * House rules for an answer here, the same ones content-service-faqs.php uses:
 *   - Answer the question asked in the first sentence, then justify it.
 *   - Name the real constraint. "It depends" is only useful with the "on what".
 *   - Where the honest answer is "you may not need this", say so.
 *
 * A product page has one failure mode a service page does not: it is read by
 * someone comparing three vendors, and the questions they arrive with are the
 * ones a feature list is designed not to answer. Those are the ones here.
 */

declare(strict_types=1);

const SOLUTION_FAQS = [

    /* ---- iThrive Insights ---------------------------------------------- */
    'ithrive-insights' => [
        ['q' => 'How is this different from a BI tool we already pay for?',
         'a' => 'A BI tool draws what you ask it to draw. The work it does not do is deciding which question was worth asking, and that is the work that actually takes your week. Insights unifies the sources into one semantic model so metrics mean the same thing everywhere, then puts an agent on top that reads the model and tells you what changed and what to do about it. If your team already knows exactly which five charts matter and looks at them every Monday, keep the BI tool.'],
        ['q' => 'Which data sources can you connect?',
         'a' => 'Google Ads, Meta, GA4, HubSpot, Shopify, Razorpay and your own Postgres out of the box, plus anything with a REST API or a warehouse table behind it. The connector is rarely the hard part. The hard part is that the same customer exists three times under three ids across those systems, and resolving that is most of what the first two weeks of an implementation is.'],
        ['q' => 'How long does implementation take?',
         'a' => 'Two to five weeks to a working model, depending on how many sources and how clean the identifiers are. A single storefront plus two ad platforms is the fast end. An organisation with a CRM that three teams have each customised differently is the slow end, and the time goes into agreeing what a "qualified lead" means, not into engineering.'],
        ['q' => 'Can we trust a number an agent produces?',
         'a' => 'You can check it, which is the only form of trust worth having. Every answer comes with the SQL it ran and the assumptions it made, so a figure can be traced to source rows by anyone who wants to. We would rather you audit the first twenty answers than take them on faith, and the design assumes you will.'],
        ['q' => 'What happens when it gets something wrong?',
         'a' => 'You see how it got there, which usually shows the model was right and the definition was wrong. The most common failure is not arithmetic, it is a metric defined differently from how your team means it — revenue including or excluding returns, for instance. That gets corrected once in the semantic model and every future answer inherits the fix.'],
        ['q' => 'Where does our data actually live?',
         'a' => 'In your own warehouse where you have one, or in a single-tenant database in the region you choose where you do not. We do not pool customer data, we do not train anything on it, and the model provider sees only the text of the question and the schema it needs to answer it — never the underlying rows unless you enable that explicitly.'],
        ['q' => 'How does attribution here differ from what our ad platforms report?',
         'a' => 'It contradicts them, on purpose. Every ad platform claims a conversion it touched, which is why the numbers in your three platforms add up to more revenue than you made. Insights models multi-touch contribution across paid, organic and direct from one set of events, so the totals reconcile to your actual accounts. Expect your best-looking channel to look less good.'],
        ['q' => 'What does it cost to run?',
         'a' => 'A platform fee plus the inference the analyst agent uses, and the second part is smaller than people expect because most questions are answered from cached model queries rather than fresh reasoning. We give a ceiling before you commit, and we would rather quote it against your real query volume than a bundled tier that assumes it.'],
        ['q' => 'Do we still need an analyst?',
         'a' => 'Yes, and they get better work. The agent removes the request queue — the forty small pulls a week that never needed a human — which is what usually consumes an analyst entirely. What it does not do is decide what the business should be measuring, design an experiment, or argue with a director about a definition. That is the job.'],
        ['q' => 'Can we start with one department rather than the whole company?',
         'a' => 'That is the recommended way in, and usually marketing or e-commerce because their data is already event-shaped. A whole-company rollout tends to stall on the department whose data needs the most work, while the departments that were ready wait. One source of truth built narrow and extended is how these succeed.'],
    ],

    /* ---- iThrive AIChat -------------------------------------------------- */
    'ithrive-aichat' => [
        ['q' => 'How is this different from the chat widget we already have?',
         'a' => 'Most widgets have one job: answer the question. AIChat scores buying intent on every message and changes its own objective based on it — inform a researcher, qualify a prospect, hand a buyer to a human now. A support widget that answers a pricing question perfectly and then lets the visitor leave has done its job and lost you the sale.'],
        ['q' => 'Where do its answers come from?',
         'a' => 'Your own site, documentation and pricing, with citations attached so the visitor can check. It is retrieval-grounded rather than a model talking from memory, and where it cannot ground a claim it is built to say it does not know and offer a human instead. An invented answer about your pricing costs more than an unanswered question.'],
        ['q' => 'How quickly can it tell a buyer from a browser?',
         'a' => 'Usually within two exchanges, because the score reads behaviour as well as words — which pages, in what order, how long, returning or first visit — not just the sentiment of the message. Someone who reads the pricing page twice and asks about implementation time is a different person from someone who asks the same question on their first page view.'],
        ['q' => 'What happens when a lead is hot?',
         'a' => 'It escalates into Slack or your CRM with the full transcript and the intent score attached, and where you want it, the visitor books a call inside the chat rather than being pushed to a form. The handover is the part worth getting right: a hot lead routed to an inbox nobody watches is the same as no lead.'],
        ['q' => 'Will it hallucinate or go off-topic?',
         'a' => 'It is constrained rather than trusted. Topic boundaries keep it on your business, prompt-injection filtering blocks visitors who try to talk it out of its instructions, and every conversation is logged for audit. It can still be wrong, which is why answers cite sources and why we recommend reading the first week of transcripts properly.'],
        ['q' => 'How long does it take to set up?',
         'a' => 'Days to a working assistant on your content, a couple of weeks to one that qualifies the way your sales team actually qualifies. The gap is entirely your criteria: what counts as a qualified lead, what disqualifies one, and who receives it. We can encode that quickly, but only once someone internally has decided it.'],
        ['q' => 'What languages does it handle?',
         'a' => 'The ones your customers use, including the Indian languages a visitor is most likely to switch into mid-conversation. Detection is automatic and it will follow a visitor who changes language halfway through, which happens more than English-only analytics suggests.'],
        ['q' => 'Does it replace our sales team?',
         'a' => 'No, and a vendor who says otherwise is selling you the wrong thing. It removes the hours a sales team spends answering the same six questions and being unavailable at eleven at night, and it hands over warmer conversations with context attached. Closing is still a person.'],
        ['q' => 'What does it cost?',
         'a' => 'A platform fee plus usage, and usage is driven by conversation volume rather than page views. We model it against your real traffic before you commit and we will tell you if your volume is too low to be worth it — under a few hundred meaningful conversations a month, a good contact form and a fast human reply beats this.'],
        ['q' => 'How do we know whether it worked?',
         'a' => 'By qualified conversations and booked calls, not by chat volume. Chat volume goes up the moment you install anything, which is why it is the metric most vendors report. The comparison worth running is a genuine holdout: the widget off for a share of traffic for a fortnight, and the pipeline from each half measured the same way.'],
    ],
];
