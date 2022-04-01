@extends('desktop.layouts.frames.basic_frame')

@section('vue')
    <script type="text/javascript" src="{{ asset('js/app/app.js')}}"></script>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ mix('css/desktop/pages/user/mypage-offer.css') }}">
@endsection

@section('content')
    <section class="content">
        <div class="container">
            @include('desktop.layouts.navigation.account')
            <div class="mypage-content-wrap">
                <div class="content-title">구직정보<a href="">구직 신청하러가기</a></div>
                <albatalk :is_navigation="true" :is_offer="true"></albatalk>
            </div>
        </div>
    </section>
@endsection
