@extends('desktop.layouts.frames.basic_frame')

@section('vue')
    <script type="text/javascript" src="{{ asset('js/app/app.js')}}"></script>
@endsection

@section('script')
@endsection

@section('style')
    <link rel="stylesheet" href="{{ mix('css/desktop/pages/albatalk/albatalk.css') }}">
    <link rel="stylesheet" href="{{ mix('css/desktop/pages/albatalk/albatalk-common.css') }}">
    <link rel="stylesheet" href="{{ mix('css/desktop/pages/albatalk/albatalk-list.css') }}">
@endsection

@section('content')
    <section class="albatalk-wrap">
        @include('desktop.layouts.navigation.albatalk')
        <div class="container">
            <albatalk-all></albatalk-all>
        </div>
    </section>
@endsection
