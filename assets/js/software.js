/**
 * Interaction for the custom software development page.
 *
 * Everything here is progressive: the page is complete and readable with this
 * file blocked. The mode switcher renders every panel in the HTML and hides all
 * but one, the counters start at their final value, and the pipeline is fully
 * legible before any class is added to it.
 *
 * The 3D backdrop is a separate module (software-stage.js) so that a device
 * without WebGL still gets all of this.
 */

(function () {
  'use strict';

  const root = document.querySelector('[data-software-page]');
  if (!root) return;

  const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  /* ---- build-mode switcher --------------------------------------------- */

  const tabs   = Array.from(root.querySelectorAll('[data-mode-tab]'));
  const panels = Array.from(root.querySelectorAll('[data-mode-panel]'));

  function showMode(key, focus) {
    tabs.forEach((tab) => {
      const on = tab.dataset.modeTab === key;
      tab.classList.toggle('is-active', on);
      tab.setAttribute('aria-selected', on ? 'true' : 'false');
      // Roving tabindex: the tablist is one tab stop, arrows move within it.
      tab.tabIndex = on ? 0 : -1;
      if (on && focus) tab.focus();
    });
    panels.forEach((panel) => {
      const on = panel.dataset.modePanel === key;
      panel.hidden = !on;
      if (on && !reduced) {
        panel.classList.remove('is-entering');
        void panel.offsetWidth;          // restart the entrance animation
        panel.classList.add('is-entering');
      }
    });
  }

  tabs.forEach((tab, i) => {
    tab.addEventListener('click', () => showMode(tab.dataset.modeTab, false));
    tab.addEventListener('keydown', (e) => {
      const step = e.key === 'ArrowRight' ? 1 : e.key === 'ArrowLeft' ? -1 : 0;
      if (!step) return;
      e.preventDefault();
      const next = tabs[(i + step + tabs.length) % tabs.length];
      showMode(next.dataset.modeTab, true);
    });
  });

  if (tabs.length) showMode(tabs[0].dataset.modeTab, false);

  /* ---- the mock window turns with the pointer --------------------------- */

  // The window is inside a `perspective` frustum, so these are real rotations
  // in 3D space, not a skew. Fine pointers only: on a touch screen there is no
  // hover to drive it, and the resting angle already reads as dimensional.
  if (!reduced && window.matchMedia('(pointer: fine)').matches) {
    root.querySelectorAll('.sd-panel').forEach((panel) => {
      const win = panel.querySelector('.sd-window');
      if (!win) return;

      panel.addEventListener('pointermove', (e) => {
        const r = panel.getBoundingClientRect();
        const x = (e.clientX - r.left) / r.width - 0.5;
        const y = (e.clientY - r.top) / r.height - 0.5;
        win.style.setProperty('--ry', (-9 + x * 18).toFixed(2) + 'deg');
        win.style.setProperty('--rx', (-y * 10).toFixed(2) + 'deg');
        win.style.transitionDuration = '.12s';
      });

      panel.addEventListener('pointerleave', () => {
        win.style.removeProperty('--ry');
        win.style.removeProperty('--rx');
        win.style.transitionDuration = '';
      });
    });
  }

  /* ---- reveal on scroll ------------------------------------------------- */

  // The site's main.js already reveals [data-reveal]. This handles the page's
  // own two behaviours: the pipeline filling as it passes, and the comparison
  // rows striking through in order.
  const marks = Array.from(root.querySelectorAll('[data-sd-reveal]'));

  if (!('IntersectionObserver' in window) || reduced) {
    marks.forEach((el) => el.classList.add('is-in'));
  } else {
    const io = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) return;
        entry.target.classList.add('is-in');
        io.unobserve(entry.target);
      });
    }, { rootMargin: '0px 0px -12% 0px', threshold: 0.2 });

    marks.forEach((el) => io.observe(el));
  }

  /* ---- the service rail ------------------------------------------------- */

  // The sticky rail marks whichever service is currently level with the middle
  // of the viewport. It reads the same DOM the 3D stage reads, but stays
  // independent of it — the rail has to work on a device with no WebGL.
  const railItems = Array.from(root.querySelectorAll('[data-rail]'));
  const services  = Array.from(root.querySelectorAll('[data-service]'));

  if (railItems.length && services.length) {
    let queued = false;

    const syncRail = () => {
      queued = false;
      const mid = window.innerHeight / 2;
      let bestIndex = 0;
      let bestDist = Infinity;

      services.forEach((el) => {
        const rect = el.getBoundingClientRect();
        const dist = Math.abs(rect.top + rect.height / 2 - mid);
        if (dist < bestDist) { bestDist = dist; bestIndex = Number(el.dataset.service); }
      });

      railItems.forEach((li) => {
        li.classList.toggle('is-current', Number(li.dataset.rail) === bestIndex);
      });
    };

    window.addEventListener('scroll', () => {
      if (!queued) { queued = true; requestAnimationFrame(syncRail); }
    }, { passive: true });

    window.addEventListener('resize', syncRail, { passive: true });
    syncRail();
  }

  /* ---- counters --------------------------------------------------------- */

  // Counts up to the number already in the DOM, so the value is never invented
  // by JavaScript and never missing without it.
  const counters = Array.from(root.querySelectorAll('[data-count]'));

  if (counters.length && !reduced && 'IntersectionObserver' in window) {
    const parse = (text) => {
      const match = text.match(/([\d.]+)/);
      return match ? { num: parseFloat(match[1]), raw: text, at: text.indexOf(match[1]), len: match[1].length } : null;
    };

    const io = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) return;
        const el = entry.target;
        io.unobserve(el);

        const parsed = parse(el.textContent.trim());
        if (!parsed) return;

        const decimals = (String(parsed.num).split('.')[1] || '').length;
        const prefix = parsed.raw.slice(0, parsed.at);
        const suffix = parsed.raw.slice(parsed.at + parsed.len);
        const started = performance.now();
        const DURATION = 900;

        const tick = (now) => {
          const t = Math.min(1, (now - started) / DURATION);
          const eased = 1 - Math.pow(1 - t, 3);
          el.textContent = prefix + (parsed.num * eased).toFixed(decimals) + suffix;
          if (t < 1) requestAnimationFrame(tick);
          else el.textContent = parsed.raw;
        };

        requestAnimationFrame(tick);
      });
    }, { threshold: 0.6 });

    counters.forEach((el) => io.observe(el));
  }

  /* ---- read progress ---------------------------------------------------- */

  const bar = root.querySelector('[data-sd-progress]');
  if (bar) {
    let queued = false;
    const update = () => {
      queued = false;
      const max = document.documentElement.scrollHeight - window.innerHeight;
      bar.style.transform = 'scaleX(' + (max > 0 ? Math.min(1, window.scrollY / max) : 0) + ')';
    };
    window.addEventListener('scroll', () => {
      if (!queued) { queued = true; requestAnimationFrame(update); }
    }, { passive: true });
    update();
  }

  /* ---- accordion: one answer open at a time ----------------------------- */

  const faqs = Array.from(root.querySelectorAll('[data-sd-faq] details'));
  faqs.forEach((item) => {
    item.addEventListener('toggle', () => {
      if (!item.open) return;
      faqs.forEach((other) => { if (other !== item) other.open = false; });
    });
  });
})();
