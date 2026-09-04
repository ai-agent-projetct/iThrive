<?php
/**
 * faq — the mobile/Flutter FAQ section.
 *
 * The rest of this directory is markup captured from the rendered React page,
 * kept byte-for-byte so there is nothing to get subtly wrong. This file cannot
 * be, and that is the whole point of it:
 *
 * A rendered snapshot is ONE state. The capture was taken with the first
 * question open, so it froze eleven questions and exactly one answer — the
 * other ten had never been in the DOM to capture. Shipping that would have
 * published a FAQ that answers the first question and shrugs at the rest.
 *
 * So this section is rendered from data instead: MOBILE_FAQ, or FLUTTER_FAQ on
 * the Flutter page, both generated from app/mobile/src so the PHP and the React
 * cannot drift. The four other stateful partials — portfolio, techstack,
 * simulator, builder — still carry the same snapshot problem and still need the
 * same treatment.
 *
 * Toggling is <details>/<summary> rather than the React button and useState.
 * The DOM had to change anyway to carry ten more answers, and native disclosure
 * needs no JavaScript at all: the answers are open to find-in-page and to a
 * crawler, and the section still works if the bundle fails. Every Tailwind
 * class the capture used is kept on the element that used it.
 *
 * @var array $V Variant strings (mobile or flutter).
 */

declare(strict_types=1);

/*
 * The Flutter variant replaces the whole book, exactly as variant.js does for
 * the React build. Falling back to the mobile set matches FaqSection.jsx.
 */
$faqs = (isset($V['faqs']) && is_array($V['faqs'])) ? $V['faqs'] : MOBILE_FAQ;

$lead = $V['faqLead']
    ?? 'Everything you need to know about our mobile app development services in Chennai.';
?>
<?php /* Three rules Tailwind's built stylesheet cannot supply: it is compiled
         from the React source, which has no <details> in it. Kept here with the
         markup they belong to rather than sent through a rebuild of a bundle
         this section does not otherwise touch. */ ?>
<style>
  .faq-item > summary { list-style: none; }
  .faq-item > summary::-webkit-details-marker { display: none; }
  .faq-item[open] > summary .faq-chevron { transform: rotate(180deg); }
</style>

<section id="faq" class="py-20 md:py-28 relative bg-slate-950">
  <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

    <div class="text-center space-y-4 mb-14">
      <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-cyan-950/80 border border-cyan-500/30 text-cyan-400 text-xs font-semibold uppercase tracking-wider">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
             class="lucide lucide-circle-help w-3.5 h-3.5" aria-hidden="true"><circle cx="12" cy="12" r="10"></circle><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path><path d="M12 17h.01"></path></svg>
        Got Questions?
      </div>
      <h2 class="text-3xl sm:text-4xl md:text-5xl font-black font-heading tracking-tight text-slate-100">
        Frequently Asked <span class="transition-all duration-300 cursor-pointer text-cyan-400">Questions</span>
      </h2>
      <p class="text-slate-300 text-base sm:text-lg"><?= e($lead) ?></p>
    </div>

    <div class="space-y-4">
      <?php foreach ($faqs as $i => $faq): ?>
        <?php /* The first is open, which is the state the React section starts in. */ ?>
        <details class="faq-item glass-panel rounded-2xl border border-slate-800 overflow-hidden transition-all duration-300"<?= $i === 0 ? ' open' : '' ?>>
          <summary class="w-full p-5 text-left flex items-center justify-between gap-4 font-bold text-slate-100 hover:text-cyan-300 text-base transition-colors cursor-pointer">
            <span><?= e($faq['q']) ?></span>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                 class="faq-chevron lucide lucide-chevron-down w-5 h-5 text-cyan-400 flex-shrink-0 transition-transform duration-300" aria-hidden="true"><path d="m6 9 6 6 6-6"></path></svg>
          </summary>
          <div class="px-5 pb-5 text-sm text-slate-300 leading-relaxed border-t border-slate-800/60 pt-3">
            <?= e($faq['a']) ?>
          </div>
        </details>
      <?php endforeach; ?>
    </div>

  </div>
</section>
