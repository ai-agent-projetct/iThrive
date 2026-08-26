/**
 * The staged, scroll-driven layer.
 *
 * After lusion.co, measured rather than remembered. What that site actually
 * does, once you strip the fact that all of it lives in one WebGL canvas:
 *
 *   - Content sits on rounded stages inset from the page edge, so the page
 *     reads as a series of framed plates rather than a continuous column.
 *   - A stage arrives: it scales up from slightly small and lifts as it
 *     crosses into view, rather than fading in place.
 *   - Headings resolve line by line, each line masked and pushed up from below.
 *   - Buttons and marks lean toward the cursor when it comes near them.
 *   - Everything is tied to scroll position, not to a timeline that runs once.
 *
 * Kept as a layer over ordinary markup instead of a canvas rewrite. lusion.co
 * renders its whole page into one canvas — measured: zero images, the document
 * never scrolls, the only DOM text is its navigation. It can afford that; a
 * service page that has to be read by a crawler and an answer engine cannot,
 * and this one was just written to rank. So the sections stay real elements and
 * this moves them.
 *
 * Scoped to body.lusion. Nothing here runs on any other page.
 */

(function () {
  'use strict';

  if (!document.body.classList.contains('lusion')) return;

  const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  const clamp = (v, a, b) => Math.min(b, Math.max(a, v));

  /* ---- 1. stages arrive ------------------------------------------------- */

  /*
   * Each stage's own progress across the viewport drives its transform, so
   * scrolling back up plays it backwards. A one-shot class would leave the
   * page fully resolved after a single pass, which is the thing that makes a
   * scroll site feel like a slideshow.
   */
  const stages = Array.from(document.querySelectorAll('[data-stage]'));

  /* ---- 2. headings resolve line by line --------------------------------- */

  /*
   * Split on rendered lines, not on words: a heading that wraps differently at
   * another width has to mask differently too. Range measurement gives the real
   * line boxes, so this survives any breakpoint.
   *
   * The original text is restored into an aria-hidden wrapper's sibling so the
   * heading still reads as one string to assistive technology.
   */
  function splitLines(el) {
    const text = el.textContent;
    const words = text.split(/(\s+)/);

    el.textContent = '';
    const probe = document.createElement('span');
    for (const w of words) {
      if (/^\s+$/.test(w)) { probe.appendChild(document.createTextNode(w)); continue; }
      const s = document.createElement('span');
      s.textContent = w;
      probe.appendChild(s);
    }
    el.appendChild(probe);

    // Group the word spans by their vertical offset — that is a line.
    const lines = [];
    let top = null;
    for (const s of probe.querySelectorAll('span')) {
      const y = Math.round(s.getBoundingClientRect().top);
      if (top === null || Math.abs(y - top) > 4) { lines.push([]); top = y; }
      lines[lines.length - 1].push(s.textContent);
    }
    if (!lines.length) { el.textContent = text; return null; }

    el.textContent = '';
    const holder = document.createElement('span');
    holder.className = 'lz-lines';
    holder.setAttribute('aria-hidden', 'true');
    lines.forEach((words, i) => {
      const line = document.createElement('span');
      line.className = 'lz-line';
      const inner = document.createElement('span');
      inner.className = 'lz-line-in';
      inner.style.setProperty('--i', String(i));
      inner.textContent = words.join(' ');
      line.appendChild(inner);
      holder.appendChild(line);
    });

    // The real string, for anything that reads rather than looks.
    const sr = document.createElement('span');
    sr.className = 'sr-only';
    sr.textContent = text;

    el.appendChild(sr);
    el.appendChild(holder);

    return holder;
  }

  const headings = [];
  if (!reduce) {
    for (const h of document.querySelectorAll('[data-lz-split]')) {
      const holder = splitLines(h);
      if (holder) headings.push(h);
    }
  }

  /* ---- 3. things lean toward the cursor --------------------------------- */

  /*
   * Magnetic, but bounded: the element moves a fraction of the distance to the
   * pointer and only within a radius of itself, so a button never wanders off
   * to meet a cursor on the far side of the page.
   */
  const magnets = reduce ? [] : Array.from(document.querySelectorAll('[data-magnet]'))
    .map((el) => ({ el, x: 0, y: 0, tx: 0, ty: 0 }));

  if (magnets.length) {
    window.addEventListener('pointermove', (e) => {
      for (const m of magnets) {
        const r = m.el.getBoundingClientRect();
        const dx = e.clientX - (r.left + r.width / 2);
        const dy = e.clientY - (r.top + r.height / 2);
        const radius = Math.max(r.width, r.height) * 1.15;
        const d = Math.hypot(dx, dy);

        if (d < radius) {
          const pull = (1 - d / radius) * 0.34;
          m.tx = dx * pull;
          m.ty = dy * pull;
        } else {
          m.tx = 0;
          m.ty = 0;
        }
      }
    }, { passive: true });
  }

  /* ---- the loop --------------------------------------------------------- */

  let ticking = false;

  function measure() {
    ticking = false;
    const vh = window.innerHeight;

    for (const stage of stages) {
      const r = stage.getBoundingClientRect();
      if (r.bottom < -200 || r.top > vh + 200) continue;

      // 0 while still below the fold, 1 once its top third has cleared.
      const p = clamp((vh - r.top) / (vh * 0.62), 0, 1);
      const eased = p * p * (3 - 2 * p);
      stage.style.setProperty('--in', eased.toFixed(3));
    }

    for (const h of headings) {
      const r = h.getBoundingClientRect();
      const p = clamp((vh - r.top) / (vh * 0.5), 0, 1);
      h.style.setProperty('--in', (p * p * (3 - 2 * p)).toFixed(3));
    }
  }

  function onScroll() {
    if (ticking) return;
    ticking = true;
    requestAnimationFrame(measure);
  }

  function frame() {
    requestAnimationFrame(frame);
    for (const m of magnets) {
      m.x += (m.tx - m.x) * 0.14;
      m.y += (m.ty - m.y) * 0.14;
      if (Math.abs(m.x) < 0.02 && Math.abs(m.y) < 0.02 && !m.tx && !m.ty) {
        m.el.style.transform = '';
        continue;
      }
      m.el.style.transform = 'translate3d(' + m.x.toFixed(2) + 'px,' + m.y.toFixed(2) + 'px,0)';
    }
  }

  window.addEventListener('scroll', onScroll, { passive: true });
  window.addEventListener('resize', onScroll);
  measure();
  if (magnets.length) requestAnimationFrame(frame);

  document.body.classList.add('lusion--live');
})();
