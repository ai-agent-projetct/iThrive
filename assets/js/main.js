/**
 * iThrive — interaction layer.
 *
 * Every widget here is progressive: the markup works without JavaScript, and
 * each initialiser bails quietly when its hook is absent from the page.
 */

(function () {
  'use strict';

  const $  = (sel, root) => (root || document).querySelector(sel);
  const $$ = (sel, root) => Array.from((root || document).querySelectorAll(sel));

  const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  const DESKTOP = () => window.matchMedia('(min-width: 961px)').matches;

  /* ---------------------------------------------------------------- header */

  const header = $('#siteHeader');
  if (header) {
    const onScroll = () => header.classList.toggle('is-stuck', window.scrollY > 12);
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
  }

  /* ------------------------------------------------------------ mobile nav */

  const navToggle = $('#navToggle');
  const siteNav = $('#siteNav');

  if (navToggle && siteNav) {
    navToggle.addEventListener('click', () => {
      const open = document.body.classList.toggle('nav-open');
      navToggle.setAttribute('aria-expanded', String(open));
      navToggle.setAttribute('aria-label', open ? 'Close menu' : 'Open menu');
      if (!open) closeAllMenus();
    });

    // Any navigation closes the drawer — except tapping a parent item that owns
    // a dropdown, which is how you expand that dropdown on mobile.
    siteNav.addEventListener('click', (event) => {
      const link = event.target.closest('a[href]');
      if (!link || !document.body.classList.contains('nav-open')) return;
      if (!DESKTOP() && link.matches('.nav-item.has-menu > .nav-link')) return;

      document.body.classList.remove('nav-open');
      navToggle.setAttribute('aria-expanded', 'false');
    });
  }

  /* --------------------------------------------------------- mega dropdown */

  const navItems = $$('.nav-item.has-menu');

  function closeAllMenus(except) {
    navItems.forEach((item) => {
      if (item === except) return;
      item.classList.remove('is-open');
      const link = $('.nav-link', item);
      if (link) link.setAttribute('aria-expanded', 'false');
    });
  }

  navItems.forEach((item) => {
    const link = $('.nav-link', item);
    let hoverTimer;

    const open = (state) => {
      item.classList.toggle('is-open', state);
      if (link) link.setAttribute('aria-expanded', String(state));
      if (state) closeAllMenus(item);
    };

    // Desktop: hover, with a small close delay so a diagonal mouse path to the
    // panel does not dismiss it.
    item.addEventListener('mouseenter', () => {
      if (!DESKTOP()) return;
      clearTimeout(hoverTimer);
      open(true);
    });
    item.addEventListener('mouseleave', () => {
      if (!DESKTOP()) return;
      hoverTimer = setTimeout(() => open(false), 160);
    });

    // Mobile: the parent link toggles its panel instead of navigating.
    link.addEventListener('click', (event) => {
      if (DESKTOP()) return;
      event.preventDefault();
      open(!item.classList.contains('is-open'));
    });

    // Keyboard: focus moving out of the item closes it.
    item.addEventListener('focusout', (event) => {
      if (!DESKTOP()) return;
      if (!item.contains(event.relatedTarget)) open(false);
    });
    item.addEventListener('focusin', () => { if (DESKTOP()) open(true); });
  });

  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') closeAllMenus();
  });

  /* --------------------------------------------------------------- reveals */

  const revealables = $$('[data-reveal]');
  if (reduceMotion || !('IntersectionObserver' in window)) {
    revealables.forEach((el) => el.classList.add('is-in'));
  } else {
    const observer = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) return;
        entry.target.classList.add('is-in');
        observer.unobserve(entry.target);
      });
    }, { rootMargin: '0px 0px -12% 0px', threshold: 0.08 });

    revealables.forEach((el) => observer.observe(el));
  }

  /* ----------------------------------------------------------- service tabs */

  $$('[data-tabs]').forEach((group) => {
    const tabs = $$('[data-tab]', group);
    const panels = $$('[data-panel]', group);

    tabs.forEach((tab) => {
      tab.addEventListener('click', () => {
        const key = tab.dataset.tab;
        tabs.forEach((t) => {
          const on = t === tab;
          t.classList.toggle('is-active', on);
          t.setAttribute('aria-selected', String(on));
        });
        panels.forEach((p) => p.classList.toggle('is-active', p.dataset.panel === key));
      });
    });
  });

  /* ------------------------------------------------------ case study filter */

  const filterRoot = $('[data-filters]');
  if (filterRoot) {
    const buttons = $$('[data-filter]', filterRoot);
    const cards = $$('.case-card');
    const empty = $('[data-filter-empty]');

    const apply = (key, push) => {
      let shown = 0;
      cards.forEach((card) => {
        const match = key === 'all' || card.dataset.categories.split(' ').includes(key);
        card.classList.toggle('is-shown', match);
        if (match) shown++;
      });

      buttons.forEach((b) => {
        const on = b.dataset.filter === key;
        b.classList.toggle('is-active', on);
        b.setAttribute('aria-pressed', String(on));
      });

      if (empty) empty.hidden = shown > 0;

      if (push) {
        const hash = key === 'all' ? ' ' : '#' + key;
        history.replaceState(null, '', hash);
      }
    };

    buttons.forEach((button) => {
      button.addEventListener('click', () => apply(button.dataset.filter, true));
    });

    // Deep links like /case-studies.php#mobile land pre-filtered.
    const initial = window.location.hash.replace('#', '');
    if (initial && buttons.some((b) => b.dataset.filter === initial)) apply(initial, false);
  }

  /* ---------------------------------------------------------------- slider */

  $$('[data-slider]').forEach((slider) => {
    const track = $('[data-slider-track]', slider);
    const slides = Array.from(track.children);
    const dotsWrap = $('[data-slider-dots]', slider);
    if (slides.length < 2) return;

    let index = 0;
    let timer;

    const dots = slides.map((_, i) => {
      const dot = document.createElement('button');
      dot.type = 'button';
      dot.className = 'slider-dot';
      dot.setAttribute('aria-label', `Testimonial ${i + 1} of ${slides.length}`);
      dot.addEventListener('click', () => go(i));
      dotsWrap.appendChild(dot);
      return dot;
    });

    function go(next) {
      index = (next + slides.length) % slides.length;
      track.style.transform = `translateX(-${index * 100}%)`;
      dots.forEach((d, i) => d.classList.toggle('is-active', i === index));
      slides.forEach((s, i) => s.setAttribute('aria-hidden', String(i !== index)));
      restart();
    }

    function restart() {
      if (reduceMotion) return;
      clearInterval(timer);
      timer = setInterval(() => go(index + 1), 7000);
    }

    $('[data-slider-next]', slider).addEventListener('click', () => go(index + 1));
    $('[data-slider-prev]', slider).addEventListener('click', () => go(index - 1));
    slider.addEventListener('mouseenter', () => clearInterval(timer));
    slider.addEventListener('mouseleave', restart);

    go(0);
  });

  /* ----------------------------------------------------------------- modal */

  const modal = $('#projectModal');
  if (modal) {
    const panel = $('.modal-panel', modal);
    let lastFocused = null;

    const openModal = (service) => {
      lastFocused = document.activeElement;
      modal.hidden = false;
      // Let the browser apply `hidden = false` before the transition starts.
      requestAnimationFrame(() => modal.classList.add('is-open'));
      document.body.style.overflow = 'hidden';

      if (service) {
        const select = $('#modal-service', modal);
        if (select && Array.from(select.options).some((o) => o.value === service)) {
          select.value = service;
        }
      }

      const first = $('input:not([tabindex="-1"]), textarea, select', panel);
      if (first) setTimeout(() => first.focus(), 240);
    };

    const closeModal = () => {
      modal.classList.remove('is-open');
      document.body.style.overflow = '';
      setTimeout(() => { modal.hidden = true; }, 280);
      if (lastFocused) lastFocused.focus();
    };

    $$('[data-modal-open]').forEach((trigger) => {
      trigger.addEventListener('click', () => openModal(trigger.dataset.modalService));
    });

    $$('[data-modal-close]', modal).forEach((b) => b.addEventListener('click', closeModal));
    modal.addEventListener('click', (event) => { if (event.target === modal) closeModal(); });

    document.addEventListener('keydown', (event) => {
      if (event.key === 'Escape' && modal.classList.contains('is-open')) closeModal();
    });

    // Keep tab focus inside the dialog while it is open.
    modal.addEventListener('keydown', (event) => {
      if (event.key !== 'Tab') return;
      const focusable = $$(
        'a[href], button:not([disabled]), input:not([tabindex="-1"]), select, textarea',
        panel
      ).filter((el) => el.offsetParent !== null);
      if (!focusable.length) return;

      const first = focusable[0];
      const last = focusable[focusable.length - 1];

      if (event.shiftKey && document.activeElement === first) {
        event.preventDefault();
        last.focus();
      } else if (!event.shiftKey && document.activeElement === last) {
        event.preventDefault();
        first.focus();
      }
    });
  }

  /* ------------------------------------------------------- form validation */

  $$('.enquiry-form').forEach((form) => {
    form.addEventListener('submit', (event) => {
      let firstBad = null;

      $$('[required]', form).forEach((input) => {
        const field = input.closest('.field');
        const empty = !input.value.trim();
        const badEmail = input.type === 'email' && input.value.trim() && !/^[^@\s]+@[^@\s]+\.[^@\s]+$/.test(input.value);
        const invalid = empty || badEmail;

        field.classList.toggle('has-error', invalid);

        let note = field.querySelector('.field-error');
        if (invalid) {
          if (!note) {
            note = document.createElement('p');
            note.className = 'field-error';
            field.appendChild(note);
          }
          note.textContent = badEmail ? 'That does not look like a valid email address.' : 'This field is required.';
          if (!firstBad) firstBad = input;
        } else if (note) {
          note.remove();
        }
      });

      if (firstBad) {
        event.preventDefault();
        firstBad.focus();
      }
    });
  });
})();
