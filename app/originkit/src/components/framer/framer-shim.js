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
