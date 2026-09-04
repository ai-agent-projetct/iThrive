/**
 * The ReactJS Development page's own behaviour.
 *
 * One thing only: the six "what we do" cards, one open at a time. Everything
 * else on the page is either a Framer island or plain CSS.
 *
 * Not here, deliberately:
 *   - the honeycomb, which assets/js/hexbg.js already draws on every page from
 *     includes/footer.php. The MVP page once carried a second copy and the two
 *     fought each other.
 *   - reveal-on-scroll, which main.js already runs for every [data-reveal] on
 *     the site, with the same --d stagger this page's cards use.
 */
(function () {
  'use strict';

  const doing = document.querySelector('[data-doing]');
  if (!doing) return;

  const cards = Array.from(doing.querySelectorAll('[data-doing-card]'));

  const open = (card) => {
    for (const c of cards) {
      const on = c === card;
      c.classList.toggle('is-open', on);
      c.setAttribute('aria-expanded', on ? 'true' : 'false');
    }
  };

  for (const card of cards) {
    card.addEventListener('click', () => open(card));

    /* role="button" gets keyboard activation from us, not the browser. Space is
       prevented so the page does not scroll out from under the press. */
    card.addEventListener('keydown', (e) => {
      if (e.key !== 'Enter' && e.key !== ' ') return;
      e.preventDefault();
      open(card);
    });
  }
}());
