/**
 * Tailwind for the embedded mobile app page.
 *
 * Two things matter here. Preflight is OFF: it is a global reset, and this CSS
 * loads on a page that already has its own type and layout — preflight would
 * strip them. And the theme extension mirrors what upstream configured on the
 * CDN script tag, so the compiled classes resolve to the same values the
 * design was built against.
 */
export default {
  content: ['./src/**/*.{js,jsx}'],
  darkMode: 'class',
  corePlugins: { preflight: false },
  theme: {
    extend: {
      colors: {
        slate: { 950: '#02040a', 900: '#060b18', 800: '#0f172a' },
      },
      fontFamily: {
        heading: ['Outfit', 'Plus Jakarta Sans', 'sans-serif'],
        body: ['Inter', 'sans-serif'],
        sans: ['Inter', 'sans-serif'],
        mono: ['Fira Code', 'monospace'],
      },
    },
  },
};
