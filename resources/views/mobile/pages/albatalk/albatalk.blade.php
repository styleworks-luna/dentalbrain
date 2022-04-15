@extends('mobile.layouts.frames.basic_frame')

@section('vue')
    <script type="text/javascript" src="{{ asset('js/app/app.js')}}"></script>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ mix('css/mobile/pages/albatalk/albatalk.css') }}">
    <link rel="stylesheet" href="{{ mix('css/mobile/pages/albatalk/albatalk-common.css') }}">
    <link rel="stylesheet" href="{{ mix('css/mobile/pages/albatalk/albatalk-list.css') }}">
@endsection

@section('title')
    <div class="menu-btn-wrap">
        <a href="" class="menu-btn"></a>
    </div>
    <a href="" class="btn-back"></a>
    <h1>알바톡</h1>
@endsection

@section('content')
    <section class="albatalk-wrap">
        @include('mobile.layouts.navigation.albatalk')
        <div class="m-container">
            <albatalk-all :mobile="true"></albatalk-all>
        </div>
    </section>
@endsection
