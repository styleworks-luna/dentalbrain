@extends('desktop.layouts.frames.basic_frame')

@section('vue')
    <script type="text/javascript" src="{{ asset('js/app/app.js')}}"></script>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ mix('css/desktop/pages/user/mypage-albatalk-resume.css') }}">
    <link rel="stylesheet" href="{{ mix('css/desktop/pages/albatalk/albatalk-list.css') }}">
@endsection

@section('content')
    <section class="content">
        <div class="container">
            @include('desktop.layouts.navigation.account')
            <div class="mypage-content-wrap">
                <div class="content-title">
                    <h2>구직정보</h2>
                    <a href="">구직 신청하러가기</a>
                </div>
                <albatalk :is_offer="true"></albatalk>
            </div>
        </div>
    </section>
@endsection
