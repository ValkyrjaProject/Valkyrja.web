let mix = require("laravel-mix");
require("laravel-mix-eslint");

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

mix.sass("resources/assets/sass/app.scss", "public/css");
mix.js(
    "resources/assets/js/app.js",
    "public/js"
);
/*mix.eslint({
    fix: false,
    cache: false,
});*/

if (mix.inProduction()) {
    mix.version();
}

mix.webpackConfig({
    resolve: {
        modules: [path.resolve(__dirname, "resources/assets/js"), "node_modules",],
    },
});
