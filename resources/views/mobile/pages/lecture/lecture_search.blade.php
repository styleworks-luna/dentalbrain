@extends('mobile.layouts.frames.except_frame')

@section('vue')
    <script type="text/javascript" src="{{ asset('js/app/app.js')}}"></script>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ mix('css/mobile/pages/lecture/lecture-all.css') }}">
@endsection

@section('title')
    <a href="" class="btn-back"></a>
    <h1>검색 결과</h1>
@endsection

@section('content')
    <div id="content">
        <section class="search">
            <article class="lecture-title-wrap">
            </article>
            <div class="m-container">
                <div class="m-row">
                <article class="search-text-wrap">
                    <span class="search-text"></span>
                    <span>&nbsp;검색결과</span>
                </article>

                <article class="lecture-wrap">
                    <lecture-all :is_pagination="true" :per_page="12" :mobile="true"></lecture-all>
                </article>
                </div>
            </div>

        </section>
    </div>
@endsection
