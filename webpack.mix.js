const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/scss/app.scss', 'public/css');

// Fonts awesome
mix/*.js('resources/js/fontawesome/all.js', 'public/js/fontawesome/all.js')
    .js('resources/js/fontawesome/brands.js', 'public/js/fontawesome/brands.js')
    .js('resources/js/fontawesome/conflict-detection.js', 'public/js/fontawesome/conflict-detection.js')
    .js('resources/js/fontawesome/duotone.js', 'public/js/fontawesome/duotone.js')
    .js('resources/js/fontawesome/light.js', 'public/js/fontawesome/light.js')
    .js('resources/js/fontawesome/regular.js', 'public/js/fontawesome/regular.js')
    .js('resources/js/fontawesome/solid.js', 'public/js/fontawesome/solid.js')
    .js('resources/js/fontawesome/thin.js', 'public/js/fontawesome/thin.js')
    .js('resources/js/fontawesome/v4-shims.js', 'public/js/fontawesome/v4-shims.js')*/

    .sass('resources/scss/fontawesome/brands.scss', 'public/css/fontawesome/brands.css')
    .sass('resources/scss/fontawesome/duotone.scss', 'public/css/fontawesome/duotone.css')
    .sass('resources/scss/fontawesome/fontawesome.scss', 'public/css/fontawesome/fontawesome.css')
    .sass('resources/scss/fontawesome/light.scss', 'public/css/fontawesome/light.css')
    .sass('resources/scss/fontawesome/regular.scss', 'public/css/fontawesome/regular.css')
    .sass('resources/scss/fontawesome/solid.scss', 'public/css/fontawesome/solid.css')
    .sass('resources/scss/fontawesome/thin.scss', 'public/css/fontawesome/thin.css')
    .sass('resources/scss/fontawesome/v4-shims.scss', 'public/css/fontawesome/v4-shims.css');

// Videos
mix.copy('resources/videos/vitrine/starisland-1080p-2000kbps.webm', 'public/videos/vitrine/starisland-1080p-2000kbps.webm');

// Images
mix.copy('resources/images/', 'public/images/');
