let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.sass('resources/assets/sass/app.scss', 'public/css').version();
mix.js(
    'resources/assets/js/app.js',
    'public/js'
)
    .version();
mix.scripts([
    'resources/assets/js/bootstrap.min.js',
    'resources/assets/js/bootstrap-toc.min.js'
], 'public/js/vendor.js');