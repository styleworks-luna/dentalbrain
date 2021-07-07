@extends('mobile.layouts.frames.header_except_frame')

@section('script')
    <script type="text/javascript" src="{{ asset('js/pages/search/search.js') }}"></script>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ mix('css/mobile/pages/search/search.css') }}">
@endsection

@section('content')
    <section class="content">
        <div class="m-container">
            <div class="search-wrap">
                <a href="#" class="btn-back"></a>
                <form action="{{ route('lectures.search') }}" method="GET">
                    <div class="input-wrap">
                        <input type="text" id="keyword" name="keyword" placeholder="검색어를 입력하세요."/>
                    </div>
                    <span class="btn-delete"></span>
                    <button class="btn-search ir_pm">
                        검색
                        <span class="search-icon"></span>
                    </button>
                </form>
            </div>
        </div>
    </section>
@endsection
