@extends('mobile.layouts.frames.except_frame')

@section('script')
    <script type="text/javascript" src="{{ asset('js/pages/user/mypage-question.js') }}"></script>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ mix('css/mobile/pages/user/mypage/mypage-question.css') }}">
@endsection

@section('content')
    <section class="content">
        <div class="m-container">

            <section class="question-history">
                <ul >

                    @forelse($question as $key => $value)
                        <li class="history-content">
                            <div class="question-information">
                                <div class="lecture-name content-common">
                                    {{ $value['lecture']['program']['title'] }}
                                </div>
                                <div class="question-content content-common">
                                    {{ $value['question'] }}
                                </div>
                                <div class="question-status">
                                    <span class="inquiry-date content-common">
                                        {{ date('Y.m.d H:m:s',strtotime($value['created_at'])) }}
                                    </span>
                                    <span
                                        class="response-status content-common {{ !empty($value['is_answer']) ? 'response-status-complete' : '' }}">
                                        {{ !empty($value['is_answer']) ? '메일 답변완료' : '답변대기' }}
                                    </span>
                                </div>
                                <span class="arrow-down content-common"></span>
                            </div>

                            <div class="question-detail">
                                <div class="question">
                                    <h3>강의 제목</h3>
                                    <p>{{ $value['lecture']['title'] }}</p>
                                    <h3 class="head">질문 내용</h3>
                                    <p> {{ $value['question'] }} </p>
                                </div>
                            </div>
                        </li>


                    @empty
                        <li class="history-content-none">질문내역이 없습니다.</li>
                    @endforelse
                </ul>
            </section>
        </div>
    </section>
@endsection
