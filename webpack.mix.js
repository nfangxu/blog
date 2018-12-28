const mix = require('laravel-mix');

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

mix.autoload({
    jquery: ['$', 'window.jQuery', "jQuery", "window.$", "jquery", "window.jquery"],
    'popper.js/dist/umd/popper.js': ['Popper']
});
mix.js([
    'node_modules/bootstrap/dist/js/bootstrap.min.js',
    'resources/js/app.js',
], 'public/js/app.js')
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/markdown.scss', 'public/css');
