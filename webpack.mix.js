const mix = require('laravel-mix');
const webpack = require('webpack');
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

mix.webpackConfig({
    plugins: [
        new webpack.DefinePlugin({
            env: {
                APP_URL: JSON.stringify(process.env.APP_URL),
                NAVER_CLOUD_ID: JSON.stringify(process.env.NAVER_CLOUD_ID),
                FROALA_LICENSE_KEY: JSON.stringify(process.env.FROALA_LICENSE_KEY)
            }
        })
    ]
});

mix.options({
    processCssUrls: false,
    // watchOptions: {
    //     ignored: /node_modules/
    // }
});

// global
mix.js('resources/js/app/app.js', 'public/js/app')
    .sass('resources/sass/app.sass', 'public/css')
    .version();

// admin
mix.js('resources/js/app/admin/app.js', 'public/js/app/admin');

// Desktop

// pages TODO: 추후 수정
mix.sass('resources/sass/desktop/index.sass', 'public/css/desktop')
    .version();

// popup
mix.sass('resources/sass/desktop/pages/popup/ie-popup.sass', 'public/css/desktop/pages/popup');

// 소개 페이지
mix.sass('resources/sass/desktop/pages/introduce/about-us.sass', 'public/css/desktop/pages/introduce')
    .sass('resources/sass/desktop/pages/introduce/instructor.sass', 'public/css/desktop/pages/introduce')
    .sass('resources/sass/desktop/pages/introduce/community.sass', 'public/css/desktop/pages/introduce');

// 유료회원
mix.sass('resources/sass/desktop/pages/membership/membership.sass', 'public/css/desktop/pages/membership');

// 알바톡
mix.sass('resources/sass/desktop/pages/albatalk/albatalk-all.sass', 'public/css/desktop/pages/albatalk');
mix.sass('resources/sass/desktop/pages/albatalk/albatalk-post.sass', 'public/css/desktop/pages/albatalk');
mix.sass('resources/sass/desktop/pages/albatalk/albatalk-detail.sass', 'public/css/desktop/pages/albatalk');
mix.sass('resources/sass/desktop/pages/albatalk/albatalk-resume.sass', 'public/css/desktop/pages/albatalk');
mix.sass('resources/sass/desktop/pages/albatalk/albatalk-resume_detail.sass', 'public/css/desktop/pages/albatalk');

// 강의 페이지
mix.sass('resources/sass/desktop/pages/lecture/lecture-detail.sass', 'public/css/desktop/pages/lecture')
    .sass('resources/sass/desktop/pages/lecture/lecture-apply.sass', 'public/css/desktop/pages/lecture')
    .sass('resources/sass/desktop/pages/lecture/lecture-watch.sass', 'public/css/desktop/pages/lecture')
    .sass('resources/sass/desktop/pages/lecture/lecture-all.sass', 'public/css/desktop/pages/lecture')
    .sass('resources/sass/desktop/pages/lecture/lecture-list.sass', 'public/css/desktop/pages/lecture')
    .sass('resources/sass/desktop/pages/lecture/lecture-confirm.sass', 'public/css/desktop/pages/lecture');

// 회원가입, 로그인, 아이디 비밀번호 찾기
mix.sass('resources/sass/desktop/pages/user/register.sass', 'public/css/desktop/pages/user')
    .sass('resources/sass/desktop/pages/user/login.sass', 'public/css/desktop/pages/user')
    .sass('resources/sass/desktop/pages/user/find-id.sass', 'public/css/desktop/pages/user');

// 마이페이지
mix.sass('resources/sass/desktop/pages/user/mypage/mypage-login.sass', 'public/css/desktop/pages/user')
    .sass('resources/sass/desktop/pages/user/mypage/mypage-lecture.sass', 'public/css/desktop/pages/user')
    .sass('resources/sass/desktop/pages/user/mypage/mypage-albatalk.sass', 'public/css/desktop/pages/user')
    .sass('resources/sass/desktop/pages/user/mypage/mypage-offer.sass', 'public/css/desktop/pages/user')
    .sass('resources/sass/desktop/pages/user/mypage/mypage-payment.sass', 'public/css/desktop/pages/user')
    .sass('resources/sass/desktop/pages/user/mypage/mypage-question.sass', 'public/css/desktop/pages/user')
    .sass('resources/sass/desktop/pages/user/mypage/mypage-secession.sass', 'public/css/desktop/pages/user')
    .sass('resources/sass/desktop/pages/user/mypage/mypage-edit.sass', 'public/css/desktop/pages/user');

// 고객센터
mix.sass('resources/sass/desktop/pages/service/notice.sass', 'public/css/desktop/pages/service')
    .sass('resources/sass/desktop/pages/service/faq.sass', 'public/css/desktop/pages/service')
    .sass('resources/sass/desktop/pages/service/notice-detail.sass', `public/css/desktop/pages/service`)
    .sass('resources/sass/desktop/pages/service/inquire.sass', 'public/css/desktop/pages/service');

// 이용약관
mix.sass('resources/sass/desktop/pages/term/term-common.sass', 'public/css/desktop/pages/term');

// mobile
mix.sass('resources/sass/mobile/app.sass', 'public/css/mobile')

// mobile pages
mix.sass('resources/sass/mobile/index.sass', 'public/css/mobile')

// mobile 회원가입, 로그인, 아이디 비밀번호 찾기
mix.sass('resources/sass/mobile/pages/user/login.sass', 'public/css/mobile/pages/user')
    .sass('resources/sass/mobile/pages/user/find-id.sass', 'public/css/mobile/pages/user')
    .sass('resources/sass/mobile/pages/user/register.sass', 'public/css/mobile/pages/user');

// mobile introduce
mix.sass('resources/sass/mobile/pages/introduce/instructor.sass', 'public/css/mobile/pages/introduce')
    .sass('resources/sass/mobile/pages/introduce/about-us.sass', 'public/css/mobile/pages/introduce')
    .sass('resources/sass/mobile/pages/introduce/community.sass', 'public/css/mobile/pages/introduce');

// mobile membership
mix.sass('resources/sass/mobile/pages/membership/membership.sass', 'public/css/mobile/pages/membership');

// mobile lecture
mix.sass('resources/sass/mobile/pages/lecture/lecture-all.sass', 'public/css/mobile/pages/lecture')
    .sass('resources/sass/mobile/pages/lecture/lecture-detail.sass', 'public/css/mobile/pages/lecture')
    .sass('resources/sass/mobile/pages/lecture/lecture-apply.sass', 'public/css/mobile/pages/lecture')
    .sass('resources/sass/mobile/pages/lecture/lecture-watch.sass', 'public/css/mobile/pages/lecture')
    .sass('resources/sass/mobile/pages/lecture/lecture-confirm.sass', 'public/css/mobile/pages/lecture');

// mobile mypage
mix.sass('resources/sass/mobile/pages/user/mypage/mypage-payment.sass', 'public/css/mobile/pages/user/mypage')
    .sass('resources/sass/mobile/pages/user/mypage/mypage-question.sass', 'public/css/mobile/pages/user/mypage')
    .sass('resources/sass/mobile/pages/user/mypage/mypage-lecture.sass', 'public/css/mobile/pages/user/mypage')
    .sass('resources/sass/mobile/pages/user/mypage/mypage-login.sass', 'public/css/mobile/pages/user/mypage')
    .sass('resources/sass/mobile/pages/user/mypage/mypage-edit.sass', 'public/css/mobile/pages/user/mypage')
    .sass('resources/sass/mobile/pages/user/mypage/mypage-secession.sass', 'public/css/mobile/pages/user/mypage');

// mobile service
mix.sass('resources/sass/mobile/pages/service/notice.sass', 'public/css/mobile/pages/service')
    .sass('resources/sass/mobile/pages/service/notice-detail.sass', 'public/css/mobile/pages/service')
    .sass('resources/sass/mobile/pages/service/faq.sass', 'public/css/mobile/pages/service')
    .sass('resources/sass/mobile/pages/service/inquire.sass', 'public/css/mobile/pages/service');

mix.sass('resources/sass/mobile/pages/search/search.sass', 'public/css/mobile/pages/search');

mix.version();
