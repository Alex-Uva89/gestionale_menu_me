import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    base: 'https://majestic-isle-royale-01245-f4e167ad8dbf.herokuapp.com/', // Assicurati di impostare l'URL di base qui
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    server: {
        https: true,
    },
    build: {
        rollupOptions: {
            output: {
                entryFileNames: 'build/assets/[name]-[hash].js',
                chunkFileNames: 'build/assets/[name]-[hash].js',
                assetFileNames: 'build/assets/[name]-[hash][extname]',
            },
        },
    },
});
