import { resolve } from 'path'
import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'

export default defineConfig({
  root: 'resources',
  plugins: [
    vue()
  ],
  resolve: {
    alias: {
      '@': resolve(__dirname, 'resources/js'),
      'Component': resolve(__dirname, 'resources/js/components'),
      'Layout': resolve(__dirname, 'resources/js/layouts'),
      'Store': resolve(__dirname, 'resources/js/stores'),
      'Composable': resolve(__dirname, 'resources/js/composables'),
      'Util': resolve(__dirname, 'resources/js/util'),
      'View': resolve(__dirname, 'resources/js/views'),
    },
  },
  server: {
    port: 5173
  },
  build: {
    manifest: true,
    emptyOutDir: true,
    outDir: '../../../public/vendor/admin',
    rollupOptions: {
      input: resolve(__dirname, 'resources/js/main.js'),
    }
  }
})
