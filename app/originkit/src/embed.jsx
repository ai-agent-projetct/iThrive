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
import FloatingGallery from './components/originkit/floating-gallery.tsx';
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

/* The Dedicated Team page's set — none of these is used by any other page. */
import CircleExpandCard from './components/framer/circle-expand-card/index.js';
import ImageScroller from './components/framer/image-scroller/index.js';
import StickyScrollStory from './components/framer/sticky-scroll-story/index.js';
import GradientBars from './components/framer/g-bars/index.js';
import AmbientBackground from './components/framer/ambient-background/index.js';
import StackRevealScroll from './components/framer/stack-reveal-scroll/index.js';

/* The On-Demand Resources page's set — again, none shared with any other page.
   The book carries its own 3D and the ripple its own WebGL, so both are lazy. */
const FlipBook3D = lazy(() => import('./components/framer/flip-book-3d/index.js'));
import ImageHoverReveal from './components/framer/image-hover-reveal/index.js';
import DotGridBg from './components/framer/dot-grid-bg/index.js';
import BentoGallery from './components/framer/bento-gallery/index.js';
import MotionGallery from './components/framer/motion-gallery/index.js';
const WaterRipple = lazy(() => import('./components/framer/ripple/index.js'));
import BrushReveal from './components/framer/brush-reveal/index.js';
import PixelateOnHover from './components/framer/pixelate-on-hover/index.js';
/* The Micro-SaaS page's set. Both were triaged first: neither creates a canvas
   nor drives its layout from requestAnimationFrame, which is what disqualified
   five other candidates. */
import LogoBlur from './components/framer/logo-blur/index.js';
/* Origin Kit registry components live here rather than under framer/: they
   ship as readable source with their defaults merged in, not as canvas exports. */
import TextLift from './components/originkit/text-lift.jsx';
/* Ours, not Framer's — it loads the client's own GLB. three.js again, so lazy. */
const Logo3D = lazy(() => import('./components/logo-3d.jsx'));

import NextjsFlare from './components/webgpu/NextjsFlare.jsx';
import CinematicCardDeck from './components/framer/cinematic-card-deck/index.js';
import MotionLayerScroller from './components/framer/motion-layer-scroller/index.js';
import ProcessRoadmap from './components/originkit/ProcessRoadmap.jsx';
const TechDropzone = lazy(() => import('./components/framer/dropzone/index.js'));
const EnergyBeamDisciplines = lazy(() => import('./components/framer/energy-beam/index.js'));
import BookmarkModels from './components/framer/bookmark-cards/index.js';
const InfiniteImageTunnel = lazy(() => import('./components/framer/infinite-tunnel/index.js'));
const InfinitePerspectiveGallery = lazy(() => import('./components/framer/infinite-perspective-gallery/index.js'));
const ChromaticLogo = lazy(() => import('./components/framer/chromatic-logo/index.js'));
import LightOnOff from './components/framer/light-on-off/index.js';
const PolaroidScroll = lazy(() => import('./components/framer/polaroid-scroll/index.js'));
const RoadPipeline3D = lazy(() => import('./components/framer/road-pipeline-3d/index.js'));
const CityCarRoadmap3D = lazy(() => import('./components/framer/city-car-roadmap-3d/index.js'));
const AnimosCard3D = lazy(() => import('./components/framer/animos-card-3d/index.js'));
const Arc3DWall = lazy(() => import('./components/framer/arc-3d-wall/index.js'));
const HoldUs3D = lazy(() => import('./components/framer/hold-us-3d/index.js'));
const EstimateDrivers3D = lazy(() => import('./components/framer/estimate-drivers-3d/index.js'));
const ScrollZoomReveal = lazy(() => import('./components/framer/scroll-zoom-reveal/index.js'));
const PolaroidTimeline = lazy(() => import('./components/framer/polaroid-timeline/index.js'));
import FibreArc from './components/framer/fibre-arc/index.js';

const REGISTRY = {
  'interactive-grid': InteractiveGrid,
  'swipe-stack': SwipeStack,
  'stacked-carousel': StackedCarousel,
  'floating-gallery': FloatingGallery,
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
  /* The Dedicated Team page's set. */
  'circle-expand-card': CircleExpandCard,
  'image-scroller': ImageScroller,
  'sticky-scroll-story': StickyScrollStory,
  'g-bars': GradientBars,
  'ambient-background': AmbientBackground,
  'stack-reveal-scroll': StackRevealScroll,
  /* The On-Demand Resources page's set. */
  'flip-book-3d': FlipBook3D,
  'image-hover-reveal': ImageHoverReveal,
  'dot-grid-bg': DotGridBg,
  'bento-gallery': BentoGallery,
  'motion-gallery': MotionGallery,
  'ripple': WaterRipple,
  'brush-reveal': BrushReveal,
  'pixelate-on-hover': PixelateOnHover,
  'logo-blur': LogoBlur,
  'text-lift': TextLift,
  'logo-3d': Logo3D,
  'nextjs-flare': NextjsFlare,
  'cinematic-card-deck': CinematicCardDeck,
  'motion-layer-scroller': MotionLayerScroller,
  'process-roadmap': ProcessRoadmap,
  'tech-dropzone': TechDropzone,
  'energy-beam-disciplines': EnergyBeamDisciplines,
  'bookmark-models': BookmarkModels,
  'infinite-image-tunnel': InfiniteImageTunnel,
  'infinite-perspective-gallery': InfinitePerspectiveGallery,
  'chromatic-logo': ChromaticLogo,
  'light-on-off': LightOnOff,
  'polaroid-scroll': PolaroidScroll,
  'road-pipeline-3d': RoadPipeline3D,
  'city-car-roadmap-3d': CityCarRoadmap3D,
  'animos-card-3d': AnimosCard3D,
  'arc-3d-wall': Arc3DWall,
  'hold-us-3d': HoldUs3D,
  'estimate-drivers-3d': EstimateDrivers3D,
  'scroll-zoom-reveal': ScrollZoomReveal,
  'polaroid-timeline': PolaroidTimeline,
  'fibre-arc': FibreArc,
};

function mount(host) {
  if (host.dataset.okReady === '1' || host.__ok_mounted) return;
  host.dataset.okReady = '1';
  host.__ok_mounted = true;

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

  /* layout.fitHeight / fitWidth: card size as a fraction of the host's box,
     whichever is tighter, keeping the authored width:height:gap ratios. Lets
     CSS size the box per breakpoint while components that only take pixels
     still fill it without overflowing it.
     ponytail: measured once at mount; a resize keeps the first size. */
  const L = props.layout;
  if (L?.fitHeight && L.cardHeight && host.clientHeight) {
    const k = Math.min(
      (host.clientHeight * L.fitHeight) / L.cardHeight,
      (host.clientWidth * (L.fitWidth ?? 1)) / L.cardWidth,
    );
    props.layout = { ...L, cardWidth: L.cardWidth * k, cardHeight: L.cardHeight * k, gap: (L.gap ?? 0) * k };
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
}

function init() {
  if (window.__originkit_initialized) return;
  window.__originkit_initialized = true;

  const hosts = Array.from(document.querySelectorAll('[data-ok]:not([data-ok-ready]):not([data-ok-observing])'));
  if (!hosts.length) return;

  if (!('IntersectionObserver' in window)
      || new URLSearchParams(location.search).get('ok') === 'eager') {
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

  hosts.forEach((h) => {
    h.dataset.okObserving = '1';
    io.observe(h);
  });
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', init);
} else {
  init();
}

