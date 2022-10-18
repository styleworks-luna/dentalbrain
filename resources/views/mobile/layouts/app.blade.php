<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" translate="no">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2, user-scalable=yes">

    <!-- naver 웹마스터 -->
    <meta name="naver-site-verification" content="c28ce15a76c55f9c1c3928c13fdd50e0e425ab8c" />

    <!-- translate -->
    <meta name="google" content="notranslate">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->

    <!-- 네이버 애널리틱스 -->

    <script type="text/javascript" src="//wcs.naver.net/wcslog.js"></script>

    <script type="text/javascript">
        if(!wcs_add) var wcs_add = {};
        wcs_add["wa"] = "1567bbf9ce89e3";
        if(window.wcs) { wcs_do(); }
    </script>

    <script>
        window.onpageshow = function (event) {
            if (!(event.persisted || (window.performance && window.performance.navigation.type === 2))) {
                var msg = '{{Session::get('alert')}}';
                var exist = '{{Session::has('alert')}}';
                if (exist) {
                    alert(msg);
                }
            }
        }
    </script>

    <script type="text/javascript" src="{{ asset('js/jquery-1.11.3.min.js') }}"></script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script type="text/javascript" src="{{ asset('js/common/common.js') }}"></script>
    <script  type="text/javascript" src="{{ asset('js/common/m-common.js')}}"></script>
@yield('script', '')

<!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/mobile/app.css') }}">
    @yield('style','')

</head>
<body>
<div id="app">
    @yield('frame')
</div>

@yield('vue', '')
</body>
@yield('pop-script')
</html>
