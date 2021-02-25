@extends('desktop.layouts.frames.basic_frame')

@section('script')
    <script type="text/javascript" src="{{ asset('js/pages/user/mypage-question.js') }}"></script>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ mix('css/desktop/pages/user/mypage-question.css') }}">
@endsection

@section('content')
    <section class="content">
        <div class="container">
            @include('desktop.layouts.navigation.account')

            <section class="question-history">
                <h2>질문 내역</h2>
                <ul>
                    <li class="history-header">
                        <span class="lecture-name header-common">강의 제목</span>
                        <span class="question-content header-common">질문 내용</span>
                        <span class="inquiry-date header-common">문의 일자</span>
                        <span class="response-status header-common">답변상태</span>
                    </li>
                    @forelse($question as $key => $value)
                        <li class="history-content">
                            <div class="question-information">
                                <span class="lecture-name content-common">{{ $value['lecture']['program']['title'] }}</span>
                                <span class="question-content content-common">{{ $value['question'] }}</span>
                                <span class="inquiry-date content-common">{{ $value['created_at'] }}</span>
                                <span class="response-status content-common {{ !empty($value['is_answer']) ? 'response-status-complete' : '' }}">{{ !empty($value['is_answer']) ? '답변완료' : '답변대기' }}</span>
                                <span class="arrow-down content-common"></span>
                            </div>
                            <div class="question-detail">
                                <div class="question">
                                    <h3>강의 제목</h3>
                                    <p>{{ $value['lecture']['title'] }}</p>
                                    <h3 class="mt-40">질문 내용</h3>
                                    <p> {{ $value['question'] }} </p>
                                </div>
                            </div>
                        </li>
                    @empty
                        <li>질문내역이 없습니다.</li>
                    @endforelse
                </ul>
            </section>
        </div>
    </section>
@endsection
