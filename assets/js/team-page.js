/**
 * The Dedicated Engineering Team page's own behaviour.
 *
 * One thing: the three hiring-model cards turn over when clicked. Everything
 * else on the page is a Framer island or plain CSS.
 *
 * Not here: the honeycomb (assets/js/hexbg.js draws it on every page) and
 * reveal-on-scroll (main.js observes every [data-reveal] site-wide). Both were
 * duplicated on an earlier page and the copies fought the originals.
 */
(function () {
  'use strict';

  const section = document.querySelector('[data-models]');
  if (!section) return;

  const cards = Array.from(section.querySelectorAll('[data-model]'));

  const turn = (card) => {
    const now = !card.classList.contains('is-turned');
    card.classList.toggle('is-turned', now);
    card.setAttribute('aria-pressed', now ? 'true' : 'false');
  };

  for (const card of cards) {
    card.addEventListener('click', () => turn(card));

    /* role="button" gets keyboard activation from us. Space is prevented so
       the page does not scroll out from under the press. */
    card.addEventListener('keydown', (e) => {
      if (e.key !== 'Enter' && e.key !== ' ') return;
      e.preventDefault();
      turn(card);
    });
  }
}());
