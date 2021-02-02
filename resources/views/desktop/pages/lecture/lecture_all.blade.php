@extends('desktop.layouts.frames.basic_frame')

@section('vue')
    <script type="text/javascript" src="{{ asset('js/app/app.js')}}"></script>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ mix('css/desktop/pages/lecture/lecture-all.css') }}">
@endsection

@section('content')
    <div id="content">

        <section class="lecture-title-wrap">
                <h1>전체 강의</h1>
        </section>

        <section class="lecture-wrap">
            <div class="container">
            <lecture-all :is_pagination="true" :per_page="12"></lecture-all>
            </div>
        </section>

    </div>
@endsection
