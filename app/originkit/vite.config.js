import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react';

/**
 * Builds the Origin Kit components into the PHP site's asset tree.
 *
 * These components are React, as the registry ships them, so they need a bundle
 * even though the site around them is PHP with vanilla JS. This is the same
 * arrangement app/mobile already uses.
 *
 * Filenames are fixed rather than hashed because a PHP template references them
 * directly, and the site's own asset() helper already appends a filemtime
 * cache-buster.
 */
export default defineConfig({
  plugins: [react()],

  /* Relative, because this bundle is served from /assets/dist/originkit/ rather
     than from the site root. With vite's default base of '/', the code-split
     chunks were emitted as absolute "/chunks/react-….js" and 404'd. */
  base: './',

  resolve: {
    /* One React, shared by the entry and every lazily-imported chunk. Without
       this the 3D magazine's chunk resolved its own copy and every hook inside
       it threw "Cannot read properties of null (reading 'useState')" — the
       dispatcher belongs to whichever copy is currently rendering. */
    dedupe: ['react', 'react-dom'],
    alias: {
      /* Framer's published components import its runtime. Only four symbols are
         used and none of them does real work off the Framer canvas, so this
         points them at a local stand-in — see components/framer/framer-shim.js.
         Aliasing rather than editing lets the component stay byte-for-byte what
         Framer serves, so it can be re-fetched and dropped in without a diff. */
      framer: '/src/components/framer/framer-shim.js',
    },
  },
  build: {
    outDir: '../../assets/dist/originkit',
    emptyOutDir: true,
    rollupOptions: {
      input: 'src/embed.jsx',
      output: {
        entryFileNames: 'originkit.js',
        assetFileNames: 'originkit.[ext]',
        chunkFileNames: 'chunks/[name]-[hash].js',

        /*
         * React has to live in a chunk of its own, and this is not an
         * optimisation — it is a correctness fix.
         *
         * The PHP page loads the entry through asset(), which appends a
         * filemtime cache-buster: originkit.js?v=1788459147. A lazily-imported
         * chunk, though, imports its shared code by RELATIVE path, and relative
         * resolution drops the query — so the lazy chunk pulled React from
         * `originkit.js` while the page was already running `originkit.js?v=…`.
         * Two URLs, two module instances, two Reacts: every hook inside the
         * lazily-loaded 3D magazine died on "Cannot read properties of null
         * (reading 'useState')", because the dispatcher belongs to whichever
         * copy is currently rendering.
         *
         * With React in its own chunk both the entry and the lazy chunk import
         * the same query-less URL, so there is exactly one of it. resolve.dedupe
         * does not help here: the duplication is in the browser's module map,
         * not in the bundle.
         */
        manualChunks(id) {
          /* Ids arrive with Windows separators here, so normalise before matching. */
          const p = id.split('\\').join('/');
          if (/\/node_modules\/(react|react-dom|scheduler)\//.test(p)) return 'react';
          /* three is only wanted by the PoC page's 3D slider and is far bigger
             than everything else here put together. Its own chunk keeps it out
             of the entry that every other page loads. */
          if (/\/node_modules\/three\//.test(p)) return 'three';

          return undefined;
        },
      },
    },
  },
});
