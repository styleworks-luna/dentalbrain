@extends('desktop.layouts.frames.basic_frame')

@section('vue')
    <script type="text/javascript" src="{{ asset('js/app/app.js')}}"></script>
@endsection

@section('script')
@endsection

@section('style')
    <link rel="stylesheet" href="{{ mix('css/desktop/pages/albatalk/albatalk.css') }}">
    <link rel="stylesheet" href="{{ mix('css/desktop/pages/albatalk/albatalk-common.css') }}">
@endsection

@section('content')
    <section class="albatalk-wrap">
        <div class="title-wrap">
            <div class="container">
                <div class="albatalk-navigation">
                    <a href="#">헤드헌팅</a>
                    <a href="#">구인등록</a>
                    <a href="#">이력서 등록</a>
                </div>
            </div>
        </div>
        <div class="container">
            <albatalk-all></albatalk-all>
        </div>
    </section>
@endsection
