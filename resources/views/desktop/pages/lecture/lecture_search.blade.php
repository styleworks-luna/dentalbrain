@extends('desktop.layouts.frames.basic_frame')

@section('vue')
    <script type="text/javascript" src="{{ asset('js/app/app.js')}}"></script>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ mix('css/desktop/pages/lecture/lecture-all.css') }}">
@endsection

@section('content')
    <div id="content">
        <section class="search">
            <article class="lecture-title-wrap">
                <h1>검색 결과</h1>
            </article>
            <div class="container">
                <article class="search-text-wrap">

                    <span class="search-text"></span>
                    <span>&nbsp;검색결과</span>
                </article>

                <article class="lecture-wrap">
                    <lecture-all :is_pagination="true" :per_page="12"></lecture-all>
                </article>
            </div>

        </section>
    </div>
@endsection
