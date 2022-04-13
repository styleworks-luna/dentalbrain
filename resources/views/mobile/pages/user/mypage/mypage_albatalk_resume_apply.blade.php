@extends('mobile.layouts.frames.except_frame')

@section('vue')
    <script type="text/javascript" src="{{ asset('js/app/app.js')}}"></script>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ mix('css/mobile/pages/user/mypage/mypage-albatalk-resume-apply.css') }}">
    <link rel="stylesheet" href="{{ mix('css/mobile/pages/albatalk/albatalk-list.css') }}">
@endsection

@section('title')
    <div class="menu-btn-wrap">
        <a href="" class="menu-btn"></a>
    </div>
    <a href="" class="btn-back"></a>
    <h1>구직정보</h1>
@endsection

@section('content')
    <section class="albatalk-wrap">
        <div class="m-container">
            <albatalk :is_offer="true" :mobile="true"></albatalk>
        </div>
        <div class="offer-btn-wrap">
            <a href="{{ url('albatalk') }}" class="btn-go-offer">구직 신청하러가기</a>
        </div>
    </section>
@endsection
