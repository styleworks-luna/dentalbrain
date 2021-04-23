@extends('mobile.layouts.frames.except_frame')

@section('vue')
    <script type="text/javascript" src="{{ asset('js/app/app.js')}}"></script>
    </script>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ mix('css/mobile/pages/introduce/community.css') }}">
@endsection

@section('title')
    <a href="" class="btn-back"></a>
    <h1>커뮤니티</h1>
@endsection

@section('content')
    <section class="community-wrap">
        <div class="title-wrap"></div>
        <div class="m-container">
            <community :mobile="true"></community>
        </div>
    </section>
@endsection
