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

mix.options({
    processCssUrls: false
});

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.sass', 'public/css');

mix.sass('resources/sass/desktop/index.sass', 'public/css/desktop');

// 소개 페이지
mix.sass('resources/sass/desktop/pages/introduce/about-us.sass', 'public/css/desktop/pages/introduce')
    .sass('resources/sass/desktop/pages/introduce/instructor.sass', 'public/css/desktop/pages/introduce');

// 강의 페이지
mix.sass('resources/sass/desktop/pages/lecture/lecture-detail.sass', 'public/css/desktop/pages/lecture')
    .sass('resources/sass/desktop/pages/lecture/lecture-apply.sass', 'public/css/desktop/pages/lecture')
    .sass('resources/sass/desktop/pages/lecture/lecture-success.sass', 'public/css/desktop/pages/lecture');
    .sass('resources/sass/desktop/pages/lecture/lecture-watch.sass', 'public/css/desktop/pages/lecture');

// 회원가입, 로그인, 아이디 비밀번호 찾기
mix.sass('resources/sass/desktop/pages/user/register.sass', 'public/css/desktop/pages/user')
    .sass('resources/sass/desktop/pages/user/login.sass', 'public/css/desktop/pages/user')
    .sass('resources/sass/desktop/pages/user/find-id.sass', 'public/css/desktop/pages/user');

// 마이페이지
mix.sass('resources/sass/desktop/pages/user/mypage-login.sass', 'public/css/desktop/pages/user')
    .sass('resources/sass/desktop/pages/user/mypage-lecture.sass', 'public/css/desktop/pages/user')
    .sass('resources/sass/desktop/pages/user/mypage-payment.sass', 'public/css/desktop/pages/user')
    .sass('resources/sass/desktop/pages/user/mypage-question.sass', 'public/css/desktop/pages/user')
    .sass('resources/sass/desktop/pages/user/mypage-secession.sass', 'public/css/desktop/pages/user')
    .sass('resources/sass/desktop/pages/user/mypage-edit.sass', 'public/css/desktop/pages/user');

// 고객센터
mix.sass('resources/sass/desktop/pages/service/notice.sass', 'public/css/desktop/pages/service')
    .sass('resources/sass/desktop/pages/service/faq.sass', 'public/css/desktop/pages/service')
    .sass('resources/sass/desktop/pages/service/notice-detail.sass', `public/css/desktop/pages/service`)
    .sass('resources/sass/desktop/pages/service/inquire.sass', 'public/css/desktop/pages/service');
