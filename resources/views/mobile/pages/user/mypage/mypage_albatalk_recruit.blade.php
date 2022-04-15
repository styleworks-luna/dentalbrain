@extends('mobile.layouts.frames.except_frame')

@section('vue')
    <script type="text/javascript" src="{{ asset('js/app/app.js')}}"></script>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ mix('css/mobile/pages/user/mypage/mypage-albatalk-recruit.css') }}">
    <link rel="stylesheet" href="{{ mix('css/mobile/pages/albatalk/albatalk-list.css') }}">
@endsection

@section('title')
    <div class="menu-btn-wrap">
        <a href="" class="menu-btn"></a>
    </div>
    <a href="" class="btn-back"></a>
    <h1>구인정보</h1>
@endsection

@section('content')
    <section class="albatalk-wrap">
        <div class="m-container">
            <albatalk :mobile="true"></albatalk>
        </div>
    </section>
    <section class="bottom-banner">구인 등록 및 수정은 PC에서만 가능합니다.</section>
@endsection
