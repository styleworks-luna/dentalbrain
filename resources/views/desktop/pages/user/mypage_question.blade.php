@extends('desktop.layouts.app')

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
                    <li class="history-content">
                        <div class="question-information">
                            <span class="lecture-name content-common">제4회교정진료베이직과정</span>
                            <span
                                class="question-content content-common">VOD강의를 신청하여 보고있는는데 종료후 재수강 할인율은 어떻게 되나요?</span>
                            <span class="inquiry-date content-common">2020.11.17 17:56:47</span>
                            <span class="response-status content-common">답변대기</span>
                            <span class="arrow-down content-common"></span>
                        </div>
                        <div class="question-detail">
                            <div class="question">
                                <h3>강의 제목</h3>
                                <p>제4회교정진료베이직과정</p>
                                <h3 class="mt-40">질문 내용</h3>
                                <p>VOD강의를 신청하여 보고있는데 종료후 재수강 할인율은 어떻게 되나요? VOD강의를 신청하여 보고있는데 종료후
                                    재수강 할인율은 어떻게 되나요?VOD강의를 신청하여 보고있는데 종료후 재수강 할인율은 어떻게 되나요?
                                    VOD강의를 신청하여 보고있는데 종료후 재수강 할인율은 어떻게 되나요? VOD강의를 신청하여 보고있는데
                                    종료후 재수강 할인율은 어떻게 되나요? VOD강의를 신청하여 보고있는데 종료후 재수강 할인율은 어떻게 되나요?
                                </p>
                            </div>
                        </div>
                    </li>
                    <li class="history-content">
                        <div class="question-information">
                            <span class="lecture-name content-common">제4회교정진료베이직과정</span>
                            <span class="question-content content-common">VOD강의를 신청하여 보고있는는데 종료후 재수강 할인율은 어떻게 되나요? VOD강의를 신청하여 보고있는는데 종료후 재수강 할인율은 어떻게 되나요?</span>
                            <span class="inquiry-date content-common">2020.11.17 17:56:47</span>
                            <span class="response-status content-common">답변대기</span>
                            <span class="arrow-down content-common"></span>
                        </div>
                        <div class="question-detail">
                            <div class="question">
                                <h3>강의 제목</h3>
                                <p>제4회교정진료베이직과정</p>
                                <h3 class="mt-40">질문 내용</h3>
                                <p>VOD강의를 신청하여 보고있는데 종료후 재수강 할인율은 어떻게 되나요? VOD강의를 신청하여 보고있는데 종료후
                                    재수강 할인율은 어떻게 되나요?VOD강의를 신청하여 보고있는데 종료후 재수강 할인율은 어떻게 되나요?
                                    VOD강의를 신청하여 보고있는데 종료후 재수강 할인율은 어떻게 되나요? VOD강의를 신청하여 보고있는데
                                    종료후 재수강 할인율은 어떻게 되나요? VOD강의를 신청하여 보고있는데 종료후 재수강 할인율은 어떻게 되나요?
                                </p>
                            </div>
                        </div>
                    </li>
                    <li class="history-content">
                        <div class="question-information">
                            <span class="lecture-name content-common">제4회교정진료베이직과정</span>
                            <span class="question-content content-common">VOD강의를 신청하여 보고있는는데 종료후 재수강 할인율은 어떻게 되나요? VOD강의를 신청하여 보고있는는데 종료후 재수강 할인율은 어떻게 되나요?</span>
                            <span class="inquiry-date content-common">2020.11.17 17:56:47</span>
                            <span class="response-status content-common">답변대기</span>
                            <span class="arrow-down content-common"></span>
                        </div>
                        <div class="question-detail">
                            <div class="question">
                                <h3>강의 제목</h3>
                                <p>제4회교정진료베이직과정</p>
                                <h3 class="mt-40">질문 내용</h3>
                                <p>VOD강의를 신청하여 보고있는데 종료후 재수강 할인율은 어떻게 되나요? VOD강의를 신청하여 보고있는데 종료후
                                    재수강 할인율은 어떻게 되나요?VOD강의를 신청하여 보고있는데 종료후 재수강 할인율은 어떻게 되나요?
                                    VOD강의를 신청하여 보고있는데 종료후 재수강 할인율은 어떻게 되나요? VOD강의를 신청하여 보고있는데
                                    종료후 재수강 할인율은 어떻게 되나요? VOD강의를 신청하여 보고있는데 종료후 재수강 할인율은 어떻게 되나요?
                                </p>
                            </div>
                        </div>
                    </li>
                    <li class="history-content">
                        <div class="question-information">
                            <span class="lecture-name content-common">제4회교정진료베이직과정</span>
                            <span class="question-content content-common">VOD강의를 신청하여 보고있는는데 종료후 재수강 할인율은 어떻게 되나요? VOD강의를 신청하여 보고있는는데 종료후 재수강 할인율은 어떻게 되나요?</span>
                            <span class="inquiry-date content-common">2020.11.17 17:56:47</span>
                            <span class="response-status content-common response-status-complete">답변완료</span>
                            <span class="arrow-down content-common"></span>
                        </div>
                        <div class="question-detail">
                            <div class="question question-hidden-wrap">
                                <h3>강의 제목</h3>
                                <p>제4회교정진료베이직과정</p>
                                <h3 class="mt-40">질문 내용</h3>
                                <p>VOD강의를 신청하여 보고있는데 종료후 재수강 할인율은 어떻게 되나요? VOD강의를 신청하여 보고있는데 종료후
                                    재수강 할인율은 어떻게 되나요?VOD강의를 신청하여 보고있는데 종료후 재수강 할인율은 어떻게 되나요?
                                    VOD강의를 신청하여 보고있는데 종료후 재수강 할인율은 어떻게 되나요? VOD강의를 신청하여 보고있는데
                                    종료후 재수강 할인율은 어떻게 되나요? VOD강의를 신청하여 보고있는데 종료후 재수강 할인율은 어떻게 되나요?
                                </p>
                            </div>
                            <div class="answer">
                                <div class="answer-title">
                                    <h3>답변내용</h3>
                                    <span class="answer-date">2020.11.18 17:56:47</span>
                                </div>
                                <p class="answer-content">
                                    안녕하세요, 덴탈브레인입니다. 질문하신 내용에 대해 안내 드립니다.

                                    결제한 강의의 재수강을 원하시면 다시 결제해주셔야 하며 재수강의 할인율은 기존 수강료의 30%를 할인해 드리고 있습니다.
                                    강의 수강기간은 동일하게 결제한 날짜로 부터 3개월(90일)입니다.

                                    감사합니다.</p>
                            </div>
                        </div>
                    </li>
                </ul>
            </section>
        </div>
    </section>
@endsection
