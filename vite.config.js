import { defineConfig, loadEnv } from 'vite'
import laravel, { refreshPaths } from 'laravel-vite-plugin'

const env = loadEnv('', process.cwd(), '')

export default defineConfig({
  plugins: [
    laravel({
      input: [
        `${env.FRONT_RESOURCES}/js/app.js`,
        `${env.FRONT_RESOURCES}/scss/app.scss`,
        `${env.PANEL_RESOURCES}/js/app.js`,
        `${env.PANEL_RESOURCES}/scss/app.scss`,
      ],
      refresh: [
        ...refreshPaths,
        'app/Livewire/**',
        'app/Filament/**',
        'app/Providers/Filament/**',
      ],
    }),
  ],
})
