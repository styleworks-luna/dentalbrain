<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', '덴탈 브레인') }}</title>

    <link rel="stylesheet" href="{{ mix('css/errors/503.css') }}">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
<body>
<div class="error">
    <div class="error-wrap">
        <div class="error-image">
            <img src="/images/desktop/global/logo.png" alt="">
        </div>
        <div class="error-text">
            서비스 점검중입니다.
        </div>
        <div class="error-sub-text">
            13:00 ~ 15:00
        </div>
    </div>
</div>

<script type="text/javascript" src="{{ mix('js/app/admin/app.js') }}"></script>
</body>
</html>
