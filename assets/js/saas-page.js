/**
 * The Micro-SaaS page's own behaviour.
 *
 * Three things: the hero stack turning under a drag, the framework cards
 * opening, and the vertical tabs.
 *
 * Every one of them writes a custom property or toggles a class and leaves the
 * look to CSS, so there is one place that decides how anything appears — and
 * the page is fully laid out before this file runs at all. That ordering is the
 * point: six Framer components on this site have rendered nothing because they
 * computed their layout in a frame that never came.
 *
 * Not here: the honeycomb (assets/js/hexbg.js draws it site-wide), the
 * reveal-on-scroll (main.js observes every [data-reveal]) and the lead modal
 * (main.js owns [data-modal-open]). Copies of those fought the originals on an
 * earlier page.
 */
(function () {
  'use strict';

  /* ======================================================================
     Hero — drag the stack
     ======================================================================

     --r is an offset in shards. CSS already places each one from its own --i;
     this only slides the whole run along, so a drag that never happens leaves
     a stack that is already correct.
     ====================================================================== */

  const stack = document.querySelector('[data-stack-inner]');

  if (stack) {
    /* --r slides the fan; CSS centres it on --n, so 0 is the resting state.
       Past about two shards either way the far end turns edge-on. */
    const LIMIT = 2;

    /* Pixels of travel per shard. Matches the 62px translateX in the CSS so
       the fan tracks what is under the pointer. */
    const PER_SHARD = 62;

    let offset = 0;
    let startX = 0;
    let startOffset = 0;
    let dragging = false;

    const apply = () => stack.style.setProperty('--r', offset.toFixed(3));

    stack.addEventListener('pointerdown', (e) => {
      dragging = true;
      startX = e.clientX;
      startOffset = offset;
      stack.classList.add('is-dragging');
      stack.setPointerCapture(e.pointerId);
    });

    stack.addEventListener('pointermove', (e) => {
      if (!dragging) return;
      offset = Math.min(LIMIT, Math.max(-LIMIT,startOffset - (e.clientX - startX) / PER_SHARD));
      apply();
    });

    const release = (e) => {
      if (!dragging) return;
      dragging = false;
      stack.classList.remove('is-dragging');
      if (e.pointerId !== undefined && stack.hasPointerCapture(e.pointerId)) {
        stack.releasePointerCapture(e.pointerId);
      }

      /* Settle on a whole shard so the stack always rests square. The class
         comes off first, so the CSS transition does the easing. */
      offset = Math.min(LIMIT, Math.max(-LIMIT,Math.round(offset)));
      apply();
    };

    stack.addEventListener('pointerup', release);
    stack.addEventListener('pointercancel', release);

    /* Tapping a shard swings it to the middle of the fan. On touch there is no
       hover, so without this the outer shards can only be reached by dragging.
       Guarded against firing at the end of a drag, where click also fires. */
    const shards = stack.querySelectorAll('.ms-shard');
    const middle = (shards.length - 1) / 2;

    shards.forEach((shard, i) => {
      shard.addEventListener('click', () => {
        if (Math.abs(offset - startOffset) > 0.08) return;  /* it was a drag */
        offset = Math.min(LIMIT, Math.max(-LIMIT, i - middle));
        apply();
      });
    });
  }

  /* ======================================================================
     Framework — one card open at a time
     ====================================================================== */

  const frameCards = Array.from(document.querySelectorAll('[data-frame-card]'));

  if (frameCards.length) {
    const open = (card) => {
      for (const other of frameCards) {
        const on = other === card;
        other.classList.toggle('is-open', on);
        other.setAttribute('aria-expanded', on ? 'true' : 'false');
      }
    };

    for (const card of frameCards) {
      card.addEventListener('click', () => open(card));

      /* role="button" carries no keyboard behaviour of its own. */
      card.addEventListener('keydown', (e) => {
        if (e.key !== 'Enter' && e.key !== ' ') return;
        e.preventDefault();
        open(card);
      });
    }
  }

  /* ======================================================================
     Verticals — tabs
     ====================================================================== */

  const verts = document.querySelector('[data-verts]');
  if (!verts) return;

  const tabs = Array.from(verts.querySelectorAll('[data-vert-tab]'));
  const panels = Array.from(verts.querySelectorAll('[data-vert-panel]'));
  if (!tabs.length || !panels.length) return;

  const show = (index) => {
    tabs.forEach((tab, i) => {
      const on = i === index;
      tab.classList.toggle('is-on', on);
      tab.setAttribute('aria-selected', on ? 'true' : 'false');
    });

    panels.forEach((panel, i) => { panel.hidden = i !== index; });
  };

  tabs.forEach((tab, i) => {
    tab.addEventListener('click', () => show(i));

    /* Arrow keys across a tablist, which is what a screen reader expects. */
    tab.addEventListener('keydown', (e) => {
      const step = e.key === 'ArrowRight' ? 1 : e.key === 'ArrowLeft' ? -1 : 0;
      if (!step) return;
      e.preventDefault();
      const next = (i + step + tabs.length) % tabs.length;
      show(next);
      tabs[next].focus();
    });
  });
}());
