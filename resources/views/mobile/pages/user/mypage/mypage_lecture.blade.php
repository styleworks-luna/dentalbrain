@extends('mobile.layouts.frames.except_frame')

@section('vue')
    <script type="text/javascript" src="{{ asset('js/app/app.js')}}"></script>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ mix('css/mobile/pages/user/mypage/mypage-lecture.css') }}">
@endsection

@section('content')
    <section class="content">
        <div class="m-container">
            <div class="mypage-content-wrap">
                <lecture></lecture>
            </div>
        </div>
    </section>
@endsection
