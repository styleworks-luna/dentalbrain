@extends('mobile.layouts.frames.except_frame')

@section('script')
    <script type="text/javascript" src="{{ asset('js/swiper-bundle.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/pages/lecture/lecture-watch.js') }}"></script>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('css/swiper-bundle.css') }}">
    <link rel="stylesheet" href="{{ mix('css/mobile/pages/lecture/lecture-watch.css') }}">
@endsection

@section('content')
    <section id="content">
        <section class="lecture-watch">
            <div class="m-container">
                <div class="lecture-wrapper">
                    <div class="lecture-watch-content">
                        <div class="video-wrap">
                            <input type="hidden" id="youtube_id" value="{{$now->youtube_id}}">
                            <div id="player"></div>
                        </div>
                        <div class="m-row">
                            <div class="lecture-title-wrap">
                                <div class="lecture-title">
                                    <h1><a href="{{ route('lectures.detail',$program->id) }}">{{ $program->title }}</a>
                                    </h1>
                                    <h2>{{ $now->title }}</h2>
                                </div>
                                @isset($program->material)
                                    <div class="lecture-file">
                                        <a class="btn-download" href="{{ $program->material->url }}" download>강의 자료
                                            다운로드</a>
                                    </div>
                                @endisset
                            </div>
                        </div>
                    </div>
                    <div class="play-list">

                        <h3>플레이 리스트</h3>
                        <div class="list-swiper-container">
                            <div class="swiper-wrapper">
                                @foreach($lectures as $lecture)
                                    <div class="swiper-slide">
                                        <a href="{{ route('lectures.watch',[$program->id,$lecture->id]) }}">
                                            <div class="thumbnail">
                                                <img
                                                    src="{{ $lecture->thumbnail ? $lecture->thumbnail->url : $program->thumbnail->url }}"
                                                    alt="강의 썸네일">
                                            </div>
                                            <p>{{ $lecture->title }}</p>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="lecture-question">
                        <input type="text"
                               id="question"
                               name="question"
                               class="question"
                               placeholder="질문을 입력하세요.">
                        <button type="button" id="question_submit" class="btn-submit">전송</button>
                    </div>
                    <input type="hidden" id="lecture_id" value="{{$now->id}}">
                </div>
            </div>
        </section>
    </section>
@endsection
