<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
        transform: translateY(300px);">
    <div class="error-wrap">
        <div class="error-image">
            <img src="/images/desktop/global/logo.png" alt="dentalbrainon" style="display: block; width: 150px; margin: 0 auto;">
        </div>
        <div class="error-text" style="font-family: GmarketSans, 'dotum', sans-serif; font-size: 40px; margin-top: 30px;">
            서비스 점검중입니다.
        </div>
        <div class="error-sub-text" style="text-align: center; font-size: 25px;">
            10:00 ~ 11:00
        </div>
    </div>
</div>

<script type="text/javascript" src="{{ mix('js/app/admin/app.js') }}"></script>
</body>
</html>
