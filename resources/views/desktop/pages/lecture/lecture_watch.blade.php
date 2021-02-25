@extends('desktop.layouts.frames.except_frame')

@section('script')
    <script type="text/javascript" src="{{ asset('js/pages/lecture/lecture-watch.js') }}"></script>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ mix('css/desktop/pages/lecture/lecture-watch.css') }}">
@endsection

@section('content')
    <section id="content">
        <section class="lecture-watch">
            <div class="container">
                <div class="lecture-wrapper">
                    <div class="lecture-watch-content">
                        <div class="lecture-title-wrap">
                            <div class="lecture-title">
                                <h1>{{ $program->title }}</h1>
                                <h2>{{ $now->title }}</h2>
                            </div>
                            @isset($program->material)
                                <div class="lecture-file">
                                    <a class="btn-download" href="{{ $program->material->url }}" download>강의 자료
                                        다운로드</a>
                                </div>
                            @endisset
                        </div>
                        <div class="video-wrap">
                            <input type="hidden" id="youtube_id" value="{{$now->youtube_id}}">
                            <div id="player"></div>
                        </div>
                        <div class="lecture-question">
                            <p>질문하기</p>
                            <input type="text"
                                   id="question"
                                   name="question"
                                   class="question"
                                   placeholder="질문을 입력하세요.">
                            <button type="button" id="question_submit" class="btn-submit">전송</button>
                        </div>
                    </div>
                    <div class="play-list">
                        <h3>플레이리스트</h3>
                        <ul>
                            @foreach($lectures as $lecture)
                                <li @if($now->id == $lecture->id)class="active"@endif>
                                    <a href="{{ route('lectures.watch',[$program->id,$lecture->id]) }}">
                                        <div class="thumbnail">
                                            <img
                                                src="{{ $lecture->thumbnail ? $lecture->thumbnail->url : $program->thumbnail->url }}"
                                                alt="강의 썸네일">
                                        </div>
                                        <p>{{ $lecture->title }}</p>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <input type="hidden" id="lecture_id" value="{{$now->id}}">
                </div>
            </div>
        </section>
    </section>
@endsection
