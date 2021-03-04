@extends('desktop.layouts.frames.basic_frame')

@section('vue')
    <script type="text/javascript" src="{{ asset('js/app/app.js')}}"></script>
@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('js/jquery-ui.min.js') }}"></script>
    <script>
        $(function() {
            // select menu
            var select_menu = $('.select-menu');

            console.log(select_menu);

            if (select_menu.length > 0) {
                select_menu.selectmenu();
            }
        });
    </script>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ mix('css/desktop/pages/user/mypage-lecture.css') }}">
@endsection

@section('content')
    <section class="content">
        <div class="container">
            @include('desktop.layouts.navigation.account')
            <div class="mypage-content-wrap">
                    <lecture></lecture>
            </div>
        </div>
    </section>
@endsection
