import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';

const path = require('path')

export default defineConfig({
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources/js'),
            '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap'),
            '~bootstrap-icons': path.resolve(__dirname, 'node_modules/bootstrap-icons'),
            '~quill': path.resolve(__dirname, 'node_modules/quill'),
            'ziggy': path.resolve(__dirname, 'vendor/tightenco/ziggy/src/js'),
        }
    },
    plugins: [
        laravel({
            input: [
                'resources/scss/app.scss',
                'resources/scss/websites/showcase/showcase.scss',
                'resources/scss/websites/auth/auth.scss',
                'resources/scss/websites/dashboard/dashboard.scss',
                'resources/scss/websites/sofianelasri/sofianelasri.scss',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    build: {
        assetsInlineLimit: "1024", // 1kb, normalement = 4kb
    },
});
