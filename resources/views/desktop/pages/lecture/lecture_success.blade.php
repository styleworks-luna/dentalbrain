@extends('desktop.layouts.app')

@section('script')
@endsection

@section('style')
    <link rel="stylesheet" href="{{ mix('css/desktop/pages/lecture/lecture-success.css') }}">
@endsection

@section('content')
    <section class="content">
        <div class="container">
            <div class="row">
                <section class="apply-title">
                    <h1>신청내역 확인</h1>
                    <p>Step 1. 신청하기 <span class="for-padding">&gt;</span> <em>Step 2. 신청내역 확인</em></p>
                </section>

                <section class="lecture-information-wrap">
                    <div class="lecture-image">
                        <img src="{{ asset('/images/dummy/test.png') }}" alt="강의 사진">
                    </div>
                    <div class="lecture-information">
                        <div class="lecture-sort">
                            <span class="offline">오프라인</span>
                            <p class="lecture-subject">치과위생사 &middot; 위생</p>
                        </div>
                        <h2 class="lecture-title">치과위생사를 위한 예방 및 유지관리 전문가과정 치과위생사를 위한 예방 및 유지관리 전문가과정</h2>
                        <table>
                            <tr>
                                <th>강의시간</th>
                                <td><p class="lecture-length">2019년 10월 15일 (월) 15:00 ~ 2019년 10월 20일 (토) 17:20</p>
                                </td>
                            </tr>
                            <tr>
                                <th>강의장소</th>
                                <td><p class="lecture-length">서울시 서초구 강남대로 79길 59 새로나빌딩 3층 </p></td>
                            </tr>
                        </table>
                    </div>
                </section>

                <section class="applicant-information">
                    <h3>신청자 정보</h3>
                    <table>
                        <tr>
                            <th>이름</th>
                            <td><em>덴탈브레인</em></td>
                        </tr>
                        <tr>
                            <th>아이디</th>
                            <td><em>dentalbrain</em></td>
                        </tr>
                        <tr>
                            <th>이메일</th>
                            <td>
                                <em>dentalbrain@naver.com</em>
                            </td>
                        </tr>
                        <tr>
                            <th>휴대전화</th>
                            <td>
                                <em>010-1234-5678</em>
                            </td>
                        </tr>
                    </table>
                </section>

                <section class="additional-information">
                    <h3>추가 정보</h3>
                    <ul class="information-answers-list">
                        <li class="information-answers">
                            <h4>객관식 단일 선택 질문 객관식 단일 선택 질문 <em>(필수)</em></h4>
                            <div class="answer">
                                <ul>
                                    <li>선택1 선택1 선택1 선택1 선택1 선택1 선택1 선택1 선택1</li>
                                </ul>
                            </div>
                        </li>
                        <li class="information-answers">
                            <h4>객관식 다중 선택 질문</h4>
                            <div class="answer">
                                <ul>
                                    <li>선택1 선택1 선택1 선택1 선택1 선택1 선택1 선택1 선택1</li>
                                    <li>선택2</li>
                                </ul>
                            </div>
                        </li>
                        <li class="information-answers for-padding">
                            <h4>주관식 입력 질문 주관식 입력 질문</h4>
                            <div class="answer">
                                <ul>
                                    <li class="short-answer">
                                        주관식답변 답변주관식답변 답변주관식답변 답변주관식답변 답변주관식답변 답변주관식답변 답변주관식답변
                                        답변주관식답변 답변주관식답변 답변주관식답변
                                        답변주관식답변 답변주관식답변 답변주관식답변 답변주관식답변 답변주관식답변 답변주관식답변 답변주관식답변 답변주관식답변 답변
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="information-answers">
                            <h4>주소 질문</h4>
                            <div class="answer">
                                <p>서울시 서초구 강남대로 79길 59 새로나빌딩 3층 온오프믹스</p>
                            </div>
                        </li>
                        <li class="information-answers">
                            <h4>파일입력질문</h4>
                            <div class="answer">
                                <ul>
                                    <li><em>설문조사.doc</em></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </section>

                <section class="payment-information">
                    <h3>결제정보</h3>
                    <table>
                        <tr>
                            <th>결제금액</th>
                            <td><em>500,000원</em></td>
                        </tr>
                        <tr>
                            <th>결제방식</th>
                            <td>
                                <p>신용카드</p>
                            </td>
                        </tr>
                    </table>
                </section>

                <section class="btn-wrap">
                    <button class="btn-confirm">확인</button>
                </section>
            </div>
        </div>
    </section>
@endsection

