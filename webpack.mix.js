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
mix.setPublicPath('public');

mix.js('resources/js/app.js', 'js').vue({ version: 2 }).extract(['jquery','vue','bootstrap','select2','datatables.net-bs4','query-mask-plugin'])
//.version()
;
mix.sass('resources/sass/app.scss', 'css');
