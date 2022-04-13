@extends('desktop.layouts.frames.basic_frame')

@section('vue')
    <script type="text/javascript" src="{{ asset('js/app/app.js')}}"></script>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ mix('css/desktop/pages/user/mypage-albatalk-resume-apply.css') }}">
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
                <ul class="mypage-albatalk-navigation">
                    <li class="navigation-list active">
                        <a href="/account/offer">신청내역</a>
                    </li>
                    <li class="navigation-list ">
                        <a href="/account/resume">이력서 정보</a>
                    </li>
                </ul>
                <albatalk :is_offer="true"></albatalk>
            </div>
        </div>
    </section>
@endsection
