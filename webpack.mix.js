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

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.sass', 'public/css');

mix.sass('resources/sass/pages/index.sass', 'public/css/pages');
mix.sass('resources/sass/pages/introduce/about_us.sass', 'public/css/pages/introduce');
mix.sass('resources/sass/pages/introduce/instructor.sass', 'public/css/pages/introduce');
mix.sass('resources/sass/pages/lecture/lecture_detail.sass', 'public/css/pages/lecture');
