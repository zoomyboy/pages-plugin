let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application, as well as bundling up your JS files.
 |
 */

mix.config.resourceRoot = '..';

mix.js('src/main.js', 'js/zgutenberg.build.js')
.postCss('css/main.css', 'css/zgutenberg.build.css', [ 
    require('postcss-import'), 
    require('tailwindcss'), 
    require('postcss-nested') 
]);
