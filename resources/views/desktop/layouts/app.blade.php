<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- og tag -->
    <meta property="og:title" content="덴탈브레인" />
    <meta property="og:image" content="{{ asset('/images/desktop/global/logo.png') }}" />
    <meta property="og:image:width" content="300" />
    <meta property="og:image:height" content="210" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>덴탈브레인</title>

    <!-- Scripts -->
    <script>
        window.onpageshow = function (event) {
            if (!(event.persisted || (window.performance && window.performance.navigation.type === 2))) {
                var msg = '{{Session::get('alert')}}';
                var exist = '{{Session::has('alert')}}';
                if (exist) {
                    alert(msg);
                }
            }
            var agent = navigator.userAgent.toLowerCase();

            if ( (navigator.appName == 'Netscape' && navigator.userAgent.search('Trident') != -1) || (agent.indexOf("msie") != -1) ) {

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
    @yield('script', '')

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.png') }}">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    @yield('style','')

</head>
<body>
<div id="app">
    @yield('frame')
</div>

@yield('vue', '')
</body>
</html>
