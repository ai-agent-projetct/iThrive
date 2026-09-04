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

import { StrictMode, Suspense, lazy } from 'react';
import { createRoot } from 'react-dom/client';

import InteractiveGrid from './components/originkit/interactive-grid.tsx';
import SwipeStack from './components/originkit/swipe-stack.tsx';
import StackedCarousel from './components/originkit/stacked-carousel.tsx';
/*
 * Framer's own components, unmodified — see components/framer/.
 *
 * coverflow-gallery came across as a single file; the rest were vendored with
 * tools/fetch-framer.mjs, which walks each module's own imports and rewrites
 * only the remote URLs. Everything else is byte-for-byte what Framer serves,
 * so any of them can be re-fetched and dropped over the old copy.
 */
import CoverflowGallery from './components/framer/coverflow-gallery.js';
/* The magazine carries its own WebGL engine — a megabyte on its own, and more
   than the whole rest of this bundle. Lazily imported so the pages that do not
   mount it never fetch it; vite splits it into its own chunk automatically. */
const Magazine3D = lazy(() => import('./components/framer/magazine-3d/index.js'));
import GradientMotionBg from './components/framer/gradient-motion-bg/index.js';
import CardShowcase from './components/framer/card-showcase/index.js';
import ScrollTimeline from './components/framer/scroll-timeline/index.js';
import CurvedGalleryArc from './components/framer/curved-gallery-arc/index.js';
import InfinityText from './components/framer/infinity-text/index.js';
import TypewriterEffect from './components/framer/typewriter-effect/index.js';
import SplitReveal from './components/framer/split-reveal/index.js';
import GlassStack from './components/framer/glass-stack/index.js';
import DitheringHover from './components/framer/dithering-hover/index.js';
import AnimatedPath from './components/framer/animated-path/index.js';
import ImageTrail from './components/framer/image-trail/index.js';
/* The PoC page's set. The 3D slider carries three.js, which is the same
   order of weight as the magazine's engine, so it is lazy for the same
   reason — only the one page that mounts it should pay for it. */
const Scroll3dSlider = lazy(() => import('./components/framer/scroll-3d-slider/index.js'));
import StepsFlow from './components/framer/steps-flow/index.js';
import DepthBlurCarousel from './components/framer/depth-blur-carousel/index.js';
/* The ReactJS page's set. The sticker wall carries matter-js, a real physics
   engine, so it is lazy for the same reason the magazine and the 3D slider
   are: only the one page that mounts it should pay for the download. */
import InteractivePattern from './components/framer/interactive-pattern/index.js';
const PhysicsStickerWall = lazy(() => import('./components/framer/physics-sticker-wall/index.js'));
/* The liquid-glass carousel is the ReactJS hero. It carries three.js AND gsap,
   so it is lazy for the same reason as the rest of the heavy set. */
const LiquidCarousel = lazy(() => import('./components/framer/liquid-carousel/index.js'));

const REGISTRY = {
  'interactive-grid': InteractiveGrid,
  'swipe-stack': SwipeStack,
  'stacked-carousel': StackedCarousel,
  'coverflow-gallery': CoverflowGallery,
  /* The MVP Development page's set. */
  'magazine-3d': Magazine3D,
  'gradient-motion-bg': GradientMotionBg,
  'card-showcase': CardShowcase,
  'scroll-timeline': ScrollTimeline,
  'curved-gallery-arc': CurvedGalleryArc,
  'infinity-text': InfinityText,
  'typewriter-effect': TypewriterEffect,
  'split-reveal': SplitReveal,
  'glass-stack': GlassStack,
  'dithering-hover': DitheringHover,
  'animated-path': AnimatedPath,
  'image-trail': ImageTrail,
  /* The PoC Development page's set. */
  'scroll-3d-slider': Scroll3dSlider,
  'steps-flow': StepsFlow,
  'depth-blur-carousel': DepthBlurCarousel,
  /* The ReactJS Development page's set. */
  'interactive-pattern': InteractivePattern,
  'physics-sticker-wall': PhysicsStickerWall,
  'liquid-carousel': LiquidCarousel,
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

  /* Suspense because some entries are lazy — see Magazine3D. The fallback is
     nothing on purpose: the host already has its own sizing and background, so
     a spinner would only add a flash before the real thing arrives. */
  createRoot(host).render(
    <StrictMode>
      <Suspense fallback={null}>
        <Component {...props} />
      </Suspense>
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
