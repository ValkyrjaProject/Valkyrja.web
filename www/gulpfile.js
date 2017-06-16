var elixir = require('laravel-elixir');
require('laravel-elixir-webpack-advanced');
//require('laravel-elixir-vue');
require('laravel-elixir-vue-2');
/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.sass('app.scss');
    /*mix.webpack(
        'app.js'
    );*/
    mix.webpack(
        /**
         * You can simply write string: 'app' or 'app.js' => output: main.js
         * or object: { bundle: 'app.js' } ...
         */
        {
            app: 'app.js'},
        {
            entry: {
                // before start gulp task - you should install jquery (or other libs) by npm or bower
                vendor: ['./bootstrap.min.js', './bootstrap-toc.min.js', './sticky.js']
            }
        },
        /**
         * Global variables for vendor libs
         * No need to require jquery in all your modules
         */
        /*{
            $: 'jquery',
            jQuery: 'jquery',
            'window.jQuery': 'jquery'
        }*/
        {
            loaders: [
                {
                    test: /\.js$/,
                    loader: 'babel-loader',
                    query: {
                        presets: ["es2015"]
                    }
                },
                {
                    test: /\.vue$/,
                    loader: 'vue',
                },
            ]
        },
        {
            vue: {
                loaders: {
                    js: 'babel'
                }
            }
        }
    );
    mix.scripts([
        'bootstrap.min.js', 'bootstrap-toc.min.js', 'sticky.js'
    ]);
    /*mix.browserSync({
        proxy: 'botwinder.dev'
    });*/
});