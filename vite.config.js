import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    define:{
        __VUE_PROD_HYDRATION_MISMATCH_DETAILS__: false,
    },
    server: {
        cors :{
            origin: '*',
        }
    },
    plugins: [
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            '@': '/resources/js',
            '@/Shared' : '/resources/js/Shared',
        }
    },
    esbuild: {
        logOverride: {
            typescript: "silent",
        },
    },
    optimizeDeps: {
        include: ["highlight.js"],
    },
});
