/**
 * Dedicated Engineering Team Page Scripts
 * - Scroll Split Cards interaction
 * - Stack Reveal Scroll depth scaling
 * - 3D Hiring Model card flip interaction
 */
(function () {
  'use strict';

  /* ======================================================================
     1. Scroll Split Cards (Process section)
     ====================================================================== */
  const splitTrack = document.querySelector('[data-split-track]');
  if (splitTrack) {
    const splitCards = Array.from(splitTrack.querySelectorAll('[data-split-card]'));

    if ('IntersectionObserver' in window) {
      const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add('is-split-visible');
          }
        });
      }, { threshold: 0.15 });

      splitCards.forEach((card) => observer.observe(card));
    } else {
      splitCards.forEach((card) => card.classList.add('is-split-visible'));
    }

    // Interactive pointer response across cards
    splitCards.forEach((card) => {
      card.addEventListener('pointermove', (e) => {
        const rect = card.getBoundingClientRect();
        const x = (e.clientX - rect.left) / rect.width - 0.5;
        const y = (e.clientY - rect.top) / rect.height - 0.5;
        card.style.setProperty('--rx', (y * -6).toFixed(2) + 'deg');
        card.style.setProperty('--ry', (x * 8).toFixed(2) + 'deg');
      });

      card.addEventListener('pointerleave', () => {
        card.style.setProperty('--rx', '0deg');
        card.style.setProperty('--ry', '0deg');
      });
    });
  }

  /* ======================================================================
     2. Stack Reveal Scroll (Proof commitments)
     ====================================================================== */
  const stackContainer = document.querySelector('[data-stack-container]');
  if (stackContainer) {
    const stackCards = Array.from(stackContainer.querySelectorAll('[data-stack-card]'));

    const updateStack = () => {
      stackCards.forEach((card, i) => {
        const rect = card.getBoundingClientRect();
        const nextCard = stackCards[i + 1];

        if (nextCard) {
          const nextRect = nextCard.getBoundingClientRect();
          // How much the next card has overlapped this card
          const overlap = Math.max(0, Math.min(1, (rect.bottom - nextRect.top) / rect.height));
          const scale = 1 - overlap * 0.04;
          const brightness = 1 - overlap * 0.25;
          card.style.transform = `scale(${scale.toFixed(4)})`;
          card.style.filter = `brightness(${brightness.toFixed(4)})`;
        } else {
          card.style.transform = 'scale(1)';
          card.style.filter = 'brightness(1)';
        }
      });
    };

    window.addEventListener('scroll', updateStack, { passive: true });
    updateStack();
  }

  /* ======================================================================
     3. Hiring Models: 3D Flipping Cards
     ====================================================================== */
  const section = document.querySelector('[data-models]');
  if (section) {
    const cards = Array.from(section.querySelectorAll('[data-model]'));

    const turn = (card) => {
      const now = !card.classList.contains('is-turned');
      card.classList.toggle('is-turned', now);
      card.setAttribute('aria-pressed', now ? 'true' : 'false');
    };

    cards.forEach((card) => {
      card.addEventListener('click', () => turn(card));

      card.addEventListener('keydown', (e) => {
        if (e.key !== 'Enter' && e.key !== ' ') return;
        e.preventDefault();
        turn(card);
      });
    });
  }

}());
