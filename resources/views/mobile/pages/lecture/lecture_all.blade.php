@extends('mobile.layouts.frames.except_frame')

@section('vue')
    <script type="text/javascript" src="{{ asset('js/app/app.js')}}"></script>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ mix('css/mobile/pages/lecture/lecture-all.css') }}">
@endsection

@section('title')
    <a href="" class="btn-back"></a>
    <h1>전체강의</h1>
@endsection

@section('content')
    <div id="content">

        <section class="lecture-title-wrap">
        </section>

        <section class="lecture-wrap">
            <div class="m-container">
                <div class="m-row">
                    <lecture-all :is_pagination="true" :per_page="12" :mobile="true">
                    </lecture-all>
                </div>
            </div>
        </section>

    </div>
@endsection
