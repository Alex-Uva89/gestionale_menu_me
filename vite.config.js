import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';


export default defineConfig({
    base: 'https://gestionale-menu-mamma-elvira-1bd41f37f5f9.herokuapp.com/', // Assicurati di impostare l'URL di base qui
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
    // resolve: {
    //     alias: {
    //         '@': path.resolve(__dirname, 'resources/js'), // Qui setti l'alias @ alla cartella resources/js
    //     },
    // },
    server: {
        https: false // env('DEBUG_ENV') && env('DEBUG_ENV') === 'true' ? false : true,
    },
    build: {            
        rollupOptions: {
            output: {
                assetFileNames: 'assets/[name]-[hash][extname]',
                chunkFileNames: 'assets/[name]-[hash].js',
                entryFileNames: 'assets/[name]-[hash].js',
            },
        },
        sourcemap: true,
        assetsDir: 'assets',
        outDir: 'public/build',
    },
});