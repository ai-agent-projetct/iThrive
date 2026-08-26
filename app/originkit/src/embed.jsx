/**
 * Mounts Origin Kit components into the PHP page.
 *
 * The components under src/components/originkit are the registry's own source,
 * pasted unmodified — same props, same defaults, same behaviour. Everything
 * that makes them fit this site lives here instead, so that when a component is
 * refetched it can be dropped straight over the old file with nothing to merge.
 *
 * PHP renders a placeholder:
 *
 *   <div data-ok="interactive-grid" data-props='{"columns":4, ...}'></div>
 *
 * and this finds every one, parses its props and renders the component into it.
 * Nothing is registered in two places: adding a component means one import and
 * one line in REGISTRY.
 *
 * Each island is mounted only once it is near the viewport. A page carrying
 * several of these would otherwise build all of them during load, and most are
 * far below the fold.
 */

import { StrictMode } from 'react';
import { createRoot } from 'react-dom/client';

import InteractiveGrid from './components/originkit/interactive-grid.tsx';
import SwipeStack from './components/originkit/swipe-stack.tsx';
import StackedCarousel from './components/originkit/stacked-carousel.tsx';

const REGISTRY = {
  'interactive-grid': InteractiveGrid,
  'swipe-stack': SwipeStack,
  'stacked-carousel': StackedCarousel,
};

function mount(host) {
  const name = host.dataset.ok;
  const Component = REGISTRY[name];
  if (!Component) {
    console.warn('[originkit] no component registered for', name);

    return;
  }

  let props = {};
  try {
    props = host.dataset.props ? JSON.parse(host.dataset.props) : {};
  } catch (e) {
    console.warn('[originkit] bad props on', name, e.message);
  }

  createRoot(host).render(
    <StrictMode>
      <Component {...props} />
    </StrictMode>
  );
  host.dataset.okReady = '1';
}

function init() {
  const hosts = Array.from(document.querySelectorAll('[data-ok]:not([data-ok-ready])'));
  if (!hosts.length) return;

  if (!('IntersectionObserver' in window)) {
    hosts.forEach(mount);

    return;
  }

  const io = new IntersectionObserver((entries) => {
    for (const entry of entries) {
      if (!entry.isIntersecting) continue;
      io.unobserve(entry.target);
      mount(entry.target);
    }
  }, { rootMargin: '300px' });

  hosts.forEach((h) => io.observe(h));
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', init);
} else {
  init();
}
