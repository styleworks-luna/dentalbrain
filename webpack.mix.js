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

mix.sass('resources/sass/desktop/index.sass', 'public/css/desktop');
mix.sass('resources/sass/desktop/pages/introduce/about-us.sass', 'public/css/desktop/pages/introduce');
mix.sass('resources/sass/desktop/pages/introduce/instructor.sass', 'public/css/desktop/pages/introduce');
mix.sass('resources/sass/desktop/pages/lecture/lecture-detail.sass', 'public/css/desktop/pages/lecture');
mix.sass('resources/sass/desktop/pages/lecture/lecture-apply.sass', 'public/css/desktop/pages/lecture');
