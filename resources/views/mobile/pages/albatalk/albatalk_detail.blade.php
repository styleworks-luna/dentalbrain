@extends('mobile.layouts.frames.except_frame')

@section('script')
    <script type="text/javascript" src="{{ asset('js/pages/albatalk/albatalk-detail.js') }}"></script>
@endsection

@section('vue')
    <script type="text/javascript" src="{{ asset('js/app/app.js')}}"></script>
@endsection

@section('style')
    <script type="text/javascript"
            src="https://openapi.map.naver.com/openapi/v3/maps.js?ncpClientId={{ env('NAVER_CLOUD_ID') }}&submodules=geocoder"></script>
    <link rel="stylesheet" href="{{ mix('css/mobile/pages/albatalk/albatalk-detail.css') }}">
    <link rel="stylesheet" href="{{ mix('css/mobile/pages/albatalk/albatalk-common.css') }}">
@endsection

@section('title')
    <div class="menu-btn-wrap">
        <a href="" class="menu-btn"></a>
    </div>
    <a href="" class="btn-back"></a>
    <h1>구인정보</h1>
@endsection

@section('content')
    <section class="albatalk-recruit-detail-wrap"></section>
@endsection
