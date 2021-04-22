@extends('mobile.layouts.frames.except_frame')

@section('vue')
    <script type="text/javascript" src="{{ asset('js/app/app.js')}}"></script>
@endsection

@section('script')
@endsection

@section('style')
    <link rel="stylesheet" href="{{ mix('css/mobile/pages/introduce/community.css') }}">
@endsection

@section('content')
    <section class="community-wrap">
        <div class="title-wrap">
            <div class="m-container">
                <div class="title">
                    <h1>커뮤니티</h1>
                </div>
            </div>
        </div>
        <div class="m-container">
            <community></community>
        </div>
    </section>
@endsection
