/**
 * Progressive text lighting for the stacking process panels.
 *
 * Each [data-lit] statement is split into words, and the words light in
 * sequence as its panel crosses the viewport — the detail that makes averlo's
 * section feel authored rather than laid out.
 *
 * Two decisions worth stating:
 *
 *  - The split happens here, not in PHP. The markup ships as one plain
 *    sentence, so it is one text node for a screen reader and one string for a
 *    crawler; wrapping every word in a span server-side would litter the
 *    document with meaningless elements for the benefit of an effect that may
 *    never run. The original text is kept on the element so the split can be
 *    undone, and aria-hidden is never used — the words are still the words.
 *
 *  - Progress is read per panel, not from the page. The panels stack, so a
 *    panel's own rect is the only thing that knows how far through its own
 *    travel it is; the document scroll position says nothing useful once three
 *    sticky elements are overlapping.
 *
 * Skipped under prefers-reduced-motion, where the text simply arrives lit.
 */

(function () {
  'use strict';

  const stack = document.querySelector('[data-pstack]');
  if (!stack) return;

  const panels = Array.from(stack.querySelectorAll('.ppanel'));
  if (!panels.length) return;

  const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  if (reduce) {
    stack.classList.add('pstack--lit');

    return;
  }

  // Split each statement into words once.
  const groups = panels.map((panel) => {
    const says = Array.from(panel.querySelectorAll('[data-lit]'));

    says.forEach((el) => {
      const text = el.textContent.replace(/\s+/g, ' ').trim();
      el.dataset.text = text;
      el.textContent = '';
      text.split(' ').forEach((word, i, all) => {
        const span = document.createElement('span');
        span.className = 'lit-word';
        // The space belongs inside the span, or the sentence loses its gaps
        // when the words are laid out as inline-blocks.
        span.textContent = i === all.length - 1 ? word : word + ' ';
        el.appendChild(span);
      });
    });

    return { panel, words: Array.from(panel.querySelectorAll('.lit-word')) };
  });

  const clamp = (v, a, b) => (v < a ? a : v > b ? b : v);

  /**
   * The fall.
   *
   * A panel does not tip on its own schedule — it tips by exactly how far the
   * next one has risen over it. Driving it from the panel's own position
   * instead would start the tilt while the panel is still the one being read.
   *
   * 0 while the next panel is still below the fold, 1 once it has covered this
   * one. CSS turns that into the rotation, the scale and the dimming.
   */
  function fall() {
    for (let i = 0; i < panels.length; i++) {
      const next = panels[i + 1];
      if (!next) { panels[i].style.setProperty('--exit', '0'); continue; }

      const top = next.getBoundingClientRect().top;
      const from = window.innerHeight;                    // next panel still below
      const to = parseFloat(getComputedStyle(panels[i]).top) || 0;  // fully covering
      const t = clamp((from - top) / Math.max(1, from - to), 0, 1);

      panels[i].style.setProperty('--exit', t.toFixed(4));
    }
  }

  let onScreen = new Set();
  const io = new IntersectionObserver((entries) => {
    entries.forEach((e) => (e.isIntersecting ? onScreen.add(e.target) : onScreen.delete(e.target)));
  }, { threshold: 0 });
  panels.forEach((p) => io.observe(p));

  function frame() {
    requestAnimationFrame(frame);
    if (!onScreen.size) return;

    fall();

    for (const { panel, words } of groups) {
      if (!onScreen.has(panel)) continue;

      const r = panel.getBoundingClientRect();
      // 0 as the panel settles into place, 1 by the time it has been read.
      // The window is deliberately short: lighting spread over the panel's
      // whole travel finishes long after the reader has moved on.
      const progress = clamp((window.innerHeight * 0.75 - r.top) / (window.innerHeight * 0.55), 0, 1);
      const lit = Math.round(progress * words.length);

      for (let i = 0; i < words.length; i++) {
        const on = i < lit;
        if (on !== (words[i].dataset.on === '1')) {
          words[i].dataset.on = on ? '1' : '0';
          words[i].classList.toggle('is-lit', on);
        }
      }
    }
  }

  stack.classList.add('pstack--live');
  requestAnimationFrame(frame);
})();
