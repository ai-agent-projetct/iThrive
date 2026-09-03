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
  resolve: {
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
      },
    },
  },
});
