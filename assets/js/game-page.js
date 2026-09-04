/**
 * The Game Development page's own behaviour.
 *
 * Only the industry cards. The hero is a three.js endless runner and lives in
 * assets/js/game-hero.js — a module, loaded separately, so a failure there
 * cannot take this with it.
 *
 * Not here: the honeycomb (assets/js/hexbg.js draws it site-wide), the
 * reveal-on-scroll (main.js observes every [data-reveal]) and the lead modal
 * (main.js owns [data-modal-open]).
 */
(function () {
  'use strict';

  /* One industry card open at a time. */
  const cards = Array.from(document.querySelectorAll('[data-ind-card]'));
  if (!cards.length) return;

  const open = (card) => {
    for (const other of cards) {
      const on = other === card;
      other.classList.toggle('is-open', on);
      other.setAttribute('aria-expanded', on ? 'true' : 'false');
    }
  };

  for (const card of cards) {
    card.addEventListener('click', () => open(card));

    /* role="button" carries no keyboard behaviour of its own. */
    card.addEventListener('keydown', (e) => {
      if (e.key !== 'Enter' && e.key !== ' ') return;
      e.preventDefault();
      open(card);
    });
  }
}());
