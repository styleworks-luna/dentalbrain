<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    <title>{{ config('app.name', '덴탈 브레인') }}</title>

    <style>
        @font-face {
            font-family: "GmarketSans";
            font-weight: normal;
            src: url("/fonts/GmarketSansMedium.otf");
        }
    </style>
</head>
<body style="background-color: #fff">
<div class="error" style="display: flex;
        justify-content: center;
        transform: translateY(200px);">
    <div class="error-wrap">
        <div class="error-image">
            <img src="/images/desktop/global/logo.png" alt="dentalbrainon" style="display: block; width: 150px; margin: 0 auto;">
        </div>
        <div class="error-text" style="font-family: GmarketSans, 'dotum', sans-serif; font-size: 36px; margin-top: 30px; text-align: center;">
            요청이 너무 많습니다.
        </div>
        <div class="error-sub-text" style="text-align: center; font-size: 20px; margin-top: 10px; color: #666;">
            잠시 후 다시 시도해주세요.
        </div>
        <div style="text-align: center; margin-top: 30px;">
            <a href="{{ route('customer.inquiries.index') }}"
               style="display: inline-block; padding: 12px 28px; border: 1px solid #ccc; color: #333; text-decoration: none; font-size: 16px;">
                문의하기로 돌아가기
            </a>
        </div>
    </div>
</div>
</body>
</html>
