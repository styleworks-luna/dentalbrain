@extends('desktop.layouts.frames.basic_frame')

@section('vue')
    <script type="text/javascript" src="{{ asset('js/app/app.js')}}"></script>
@endsection

@section('script')
@endsection

@section('style')
    <link rel="stylesheet" href="{{ mix('css/desktop/pages/albatalk/albatalk-all.css') }}">
@endsection

@section('content')
    <section class="albatalk-wrap">
        <div class="title-wrap">
            <div class="container">
                <div class="title">
                    <h1>알바톡</h1>
                </div>
            </div>
        </div>
        <div class="container">
            <albatalk></albatalk>
        </div>
    </section>
@endsection
