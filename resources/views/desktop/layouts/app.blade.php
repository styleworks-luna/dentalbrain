<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

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

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    @yield('style','')

</head>
<body>
<div id="app">
    @include('desktop.layouts.header')
    <main class="main">
        @yield('content')
    </main>
    @include('desktop.layouts.footer')
</div>

@yield('vue', '')
</body>
</html>
