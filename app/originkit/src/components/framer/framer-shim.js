/**
 * A stand-in for Framer's own `framer` module.
 *
 * coverflow-gallery.js is the component exactly as Framer publishes it, kept
 * byte-for-byte so it can be re-fetched and replaced without a diff. It imports
 * four things from `framer`, and none of them is doing real work outside the
 * Framer canvas:
 *
 *   addPropertyControls  registers the editor's sidebar controls. Off-canvas
 *                        there is no sidebar, so this is a no-op — but it must
 *                        exist, because the module calls it at import time and
 *                        would throw before rendering anything.
 *   ControlType          the enum those controls are described with. Only its
 *                        keys are read, never their values, so plain strings do.
 *   RenderTarget         which surface Framer is drawing to. Ours is always a
 *                        live browser, which is `canvas` in Framer's vocabulary.
 *   useIsStaticRenderer  true while Framer renders a still for the editor or an
 *                        export, and the component uses it to freeze autoplay
 *                        and animation. Always false here: this is a real page,
 *                        and the animation is the entire point.
 *
 * Aliased in vite.config.js, so the component's own import line is untouched.
 */

export const ControlType = {
  Array: 'array',
  Boolean: 'boolean',
  Color: 'color',
  ComponentInstance: 'componentinstance',
  Date: 'date',
  Enum: 'enum',
  File: 'file',
  Image: 'image',
  Link: 'link',
  Number: 'number',
  Object: 'object',
  PageScope: 'pagescope',
  ResponsiveImage: 'responsiveimage',
  RichText: 'richtext',
  Scroll: 'scroll',
  String: 'string',
  Transition: 'transition',
};

export function addPropertyControls() {
  /* The editor is not here to read them. */
}

export const RenderTarget = {
  canvas: 'CANVAS',
  export: 'EXPORT',
  preview: 'PREVIEW',
  thumbnail: 'THUMBNAIL',
  current: () => 'CANVAS',
  hasRestrictions: () => false,
};

export function useIsStaticRenderer() {
  return false;
}

/* Framer components sometimes reach for these; harmless to provide. */
export const Frame = 'div';
export const useLocaleInfo = () => ({ activeLocale: null, locales: [] });
export const withCSS = (Component) => Component;

/*
 * Framer collects the webfonts a component declares so its canvas can preload
 * them. Off the canvas there is nothing to preload — every page here loads its
 * own faces from a stylesheet in the document head — so this returns nothing
 * and the components that call it carry on.
 *
 * It is here because a component that merely IMPORTS a missing export fails
 * the whole build, not just itself — a Framer canvas export asking for
 * getFonts took the entire island down with it until this existed.
 */
export const getFonts = () => [];
export const getFontsFromSharedStyle = () => [];

/*
 * The rest of what the vendored components import from `framer`.
 *
 * Collected in one pass rather than discovered one build failure at a time —
 * grep every `import{…}from"framer"` across components/framer and this is the
 * union. A component that merely imports a name the shim lacks fails the WHOLE
 * bundle, not just itself, so a missing one takes every page down.
 *
 * These are all canvas-time concerns: variant plumbing, viewport measurement
 * for the Framer editor, font preloading, SVG templating. Off the canvas they
 * have nothing to do, so each is the smallest honest no-op — never a throw,
 * which would move the failure from build time to run time.
 */
export const getPropertyControls = (Component) => (Component && Component.propertyControls) || {};
export const addFonts = () => {};
export const fontStore = { loadWebFontsFromSelectors: () => {}, addFonts: () => {} };
export const cx = (...parts) => parts.filter(Boolean).join(' ');

/* Variants: nothing on this site drives one, so the hooks report a resting
   state and hand back callbacks that do nothing. */
export const useVariantState = () => ({ variants: [], baseVariant: null, gestureVariant: null, setVariant: () => {}, setGestureState: () => {} });
export const useActiveVariantCallback = () => ({ activeVariantCallback: (fn) => fn, delay: (fn) => fn });

/* Viewport and navigation: the editor's, not ours. */
export const useComponentViewport = () => undefined;
export const ComponentViewportProvider = ({ children }) => children;
export const useIsInCurrentNavigationTarget = () => true;
export const SmartComponentScopedContainer = ({ children }) => children;

export const useSVGTemplate = () => undefined;
export const forwardLoader = (Component) => Component;

/* Framer's Image/Link/RichText/Instance render as ordinary elements here. */
export const Image = 'img';
export const Link = 'a';
export const RichText = 'div';
export const Instance = 'div';
