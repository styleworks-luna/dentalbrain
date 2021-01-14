@extends('desktop.layouts.app')

@section('script')
    <script type="text/javascript" src="{{ asset('js/pages/lecture-watch.js') }}"></script>
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
                                <h1>구강위생용품교육 전문과정</h1>
                                <h2>3강) 당신만 모르는 스케일링 꿀팁</h2>
                            </div>
                            <div class="lecture-file">
                                <a class="btn-download" href="{{ asset('/images/dummy/test.png') }}" download>강의 자료
                                    다운로드</a>
                            </div>
                        </div>
                        <div class="video-wrap">
                            <div id="player"></div>
                        </div>
                        <div class="lecture-question">
                            <p>질문하기</p>
                            <input type="text"
                                   id="question"
                                   name="question"
                                   class="question"
                                   placeholder="질문을 입력하세요.">
                            <button class="btn-submit">전송</button>
                        </div>
                    </div>
                    <div class="play-list">
                        <h3>플레이리스트</h3>
                        <ul>
                            <li>
                                <div class="thumbnail">
                                    <img src="{{ asset('/images/dummy/test.png') }}" alt="">
                                </div>
                                <p>1강) 선션이 제일 쉽다고? 천만의 말씀 만만의 콩떢!</p>
                            </li>
                            <li>
                                <div class="thumbnail">
                                    <img src="{{ asset('/images/dummy/test.png') }}" alt="">
                                </div>
                                <p>1강) 선션이 제일 쉽다고? 천만의 말씀 만만의 콩떢!</p>
                            </li>
                            <li class="active">
                                <div class="thumbnail">
                                    <img src="{{ asset('/images/dummy/test.png') }}" alt="">
                                </div>
                                <p>1강) 선션이 제일 쉽다고? 천만의 말씀 만만의 콩떢!</p>
                            </li>
                            <li>
                                <div class="thumbnail">
                                    <img src="{{ asset('/images/dummy/test.png') }}" alt="">
                                </div>
                                <p>1강) 선션이 제일 쉽다고? 천만의 말씀 만만의 콩떢!</p>
                            </li>
                            <li>
                                <div class="thumbnail">
                                    <img src="{{ asset('/images/dummy/test.png') }}" alt="">
                                </div>
                                <p>1강) 선션이 제일 쉽다고? 천만의 말씀 만만의 콩떢!</p>
                            </li>
                            <li>
                                <div class="thumbnail">
                                    <img src="{{ asset('/images/dummy/test.png') }}" alt="">
                                </div>
                                <p>1강) 선션이 제일 쉽다고? 천만의 말씀 만만의 콩떢!</p>
                            </li>
                            <li>
                                <div class="thumbnail">
                                    <img src="{{ asset('/images/dummy/test.png') }}" alt="">
                                </div>
                                <p>1강) 선션이 제일 쉽다고? 천만의 말씀 만만의 콩떢!</p>
                            </li>
                            <li>
                                <div class="thumbnail">
                                    <img src="{{ asset('/images/dummy/test.png') }}" alt="">
                                </div>
                                <p>1강) 선션이 제일 쉽다고? 천만의 말씀 만만의 콩떢!</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    </section>
@endsection
