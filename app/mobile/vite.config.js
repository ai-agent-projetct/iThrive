import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react';

/**
 * Builds the page into the PHP site's asset tree.
 *
 * Filenames are fixed rather than hashed because a PHP template references them
 * directly, and the site's own asset() helper already appends a filemtime
 * cache-buster.
 */
export default defineConfig({
  plugins: [react()],
  build: {
    outDir: '../../assets/dist/mobile',
    emptyOutDir: true,
    rollupOptions: {
      input: 'src/embed.jsx',
      output: {
        entryFileNames: 'mobile-app.js',
        assetFileNames: 'mobile-app.[ext]',
      },
    },
  },
});
