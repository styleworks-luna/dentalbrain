const mix = require('laravel-mix');
require('laravel-mix-alias');

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

mix.alias({
    '@': '/resources/js',
    '@sass': '/resources/sass'
});

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.sass', 'public/css');

mix.sass('resources/sass/desktop/index.sass', 'public/css/desktop');
mix.sass('resources/sass/desktop/pages/introduce/about-us.sass', 'public/css/desktop/pages/introduce');
mix.sass('resources/sass/desktop/pages/introduce/instructor.sass', 'public/css/desktop/pages/introduce');
mix.sass('resources/sass/desktop/pages/lecture/lecture-detail.sass', 'public/css/desktop/pages/lecture');
mix.sass('resources/sass/desktop/pages/lecture/lecture-apply.sass', 'public/css/desktop/pages/lecture');
mix.sass('resources/sass/desktop/pages/user/mypage-lecture.sass', 'public/css/desktop/pages/user');
mix.sass('resources/sass/desktop/pages/user/register.sass', 'public/css/desktop/pages/user');
mix.sass('resources/sass/desktop/pages/user/mypage-payment.sass', 'public/css/desktop/pages/user');
mix.sass('resources/sass/desktop/pages/user/mypage-question.sass', 'public/css/desktop/pages/user');
