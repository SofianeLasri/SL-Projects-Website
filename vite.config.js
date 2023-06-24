import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';

const path = require('path')

export default defineConfig({
    resolve: {
        alias: {
            '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap'),
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
                'resources/js/app.js'
            ],
            refresh: true,
        }),
    ],
});
