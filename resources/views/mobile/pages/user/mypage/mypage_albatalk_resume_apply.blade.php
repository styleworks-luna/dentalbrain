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
    <h1>이력서 정보</h1>
@endsection

@section('content')
    <section class="content">
        <div class="container">
        </div>
    </section>
@endsection
