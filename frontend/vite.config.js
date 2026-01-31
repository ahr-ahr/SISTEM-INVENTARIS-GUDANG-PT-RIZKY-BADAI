import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react'
import tailwind from '@tailwindcss/vite'

export default defineConfig({
  plugins: [
    react(),
    tailwind(),
  ],

  server: {
    host: true,
    strictPort: true,
    port: 5173,

    https: false,

    allowedHosts: [
      'sig-pt-rizky-badai.com',
      'reverb.sig-pt-rizky-badai.com',
      'localhost',
    ],

    hmr: {
      protocol: 'wss',
      host: 'sig-pt-rizky-badai.com',
    },
  },
})
