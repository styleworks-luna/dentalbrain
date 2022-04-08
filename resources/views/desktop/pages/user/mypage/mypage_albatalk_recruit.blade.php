@extends('desktop.layouts.frames.basic_frame')

@section('vue')
    <script type="text/javascript" src="{{ asset('js/app/app.js')}}"></script>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ mix('css/desktop/pages/user/mypage-albatalk-recruit.css') }}">
    <link rel="stylesheet" href="{{ mix('css/desktop/pages/albatalk/albatalk-list.css') }}">
@endsection

@section('content')
    <section class="content">
        <div class="container">
            @include('desktop.layouts.navigation.account')
            <div class="mypage-content-wrap">
                <div class="content-title">구인정보<a href="">구인 등록하기</a></div>
                <albatalk></albatalk>
            </div>
        </div>
    </section>
@endsection
