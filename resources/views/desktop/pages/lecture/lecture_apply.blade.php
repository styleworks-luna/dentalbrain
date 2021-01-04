@extends('desktop.layouts.app')

@section('script')
    <script type="text/javascript" src="{{ asset('js/jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.ui.emailbox.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/parsley.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/pages/lecture-apply.js') }}"></script>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ ('css/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ mix('css/desktop/pages/lecture/lecture-apply.css') }}">
@endsection

@section('content')
    <section class="content">
        <div class="container">
            <div class="row">
                <form action="">
                    <section class="apply-title">
                        <h1>신청하기</h1>
                        <p><em>Step 1. 신청하기</em> <em class="for-padding">&gt;</em> Step 2. 신청내역 확인</p>
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
                        <h3>신청자 정보 입력</h3>
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
                                    <input type="email"
                                           name="email"
                                           class="email_box"
                                           data-parsley-required="true"
                                           data-parsley-type="email"
                                           data-parsley-class-handler=".ui-emailbox">
                                </td>
                            </tr>
                            <tr>
                                <th>휴대전화</th>
                                <td><input type="text"></td>
                            </tr>
                        </table>
                    </section>
                    <section class="additional-information">
                        <h3>추가 정보 입력</h3>
                        <div class="multiple-single-choice">
                            <h4>객관식 단일 선택 질문 객관식 단일 선택 질문 <em>(필수)</em></h4>
                            <div class="choices">
                                <ul>
                                    <li>
                                        <input type="radio" name="choice" id="choice-01">
                                        <label for="choice-01">선택 1</label>
                                    </li>
                                    <li>
                                        <input type="radio" name="choice" id="choice-02">
                                        <label for="choice-02">선택 2</label>
                                    </li>
                                    <li>
                                        <input type="radio" name="choice" id="choice-03">
                                        <label for="choice-03">선택 3</label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="multiple-choice">
                            <h4>객관식 다중 선택 질문</h4>
                            <div class="choices">
                                <ul>
                                    <li>
                                        <input type="checkbox" name="choice" id="multiple-choice-01">
                                        <label for="multiple-choice-01">선택 1</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" name="choice" id="multiple-choice-02">
                                        <label for="multiple-choice-02">선택 2</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" name="choice" id="multiple-choice-03">
                                        <label for="multiple-choice-03">선택 3</label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="short-answer">
                            <h4>주관식 입력 질문 주관식 입력 질문</h4>
                            <div class="answers">
                                <input type="text" placeholder="답변을 입력하세요." class="short-answer-response">
                            </div>
                        </div>
                        <div class="address-question">
                            <h4>주소 질문</h4>
                            <div class="answers">
                                <div class="address-form-wrap">
                                    <input type="text" class="address">
                                    <input type="text" placeholder="상세주소를 입력하세요." class="address-detail">
                                </div>
                            </div>
                        </div>
                        <div class="file-question">
                            <h4>파일입력질문</h4>
                            <div class="answers">
                                <input type="file" id="file-upload" class="upload-hidden">
                                <label for="file-upload" class="file-upload-btn">파일선택</label>
                                <input class="file-name" value="파일을 업로드해주세요." disabled="disabled">
                                <div class="tips">
                                    <p>
                                        ※ 파일 용량은 최대 2MB까지 등록할 수 있습니다.<br>
                                        ※ 첨부가능 확장자 : 문서파일 : Key, PDF, Doc, PPT, Pages, pptx, docx, xlsx, xls, hwp /
                                        이미지파일 :
                                        JPG, JPEG, PNG, GIF / 압축파일 : zip, alz, rar
                                    </p>
                                </div>
                            </div>
                        </div>
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
                                    <input type="radio" name="payment-method" id="credit" class="payment-method">
                                    <label for="credit">신용카드</label>
                                    <input type="radio" name="payment-method" id="bank-transform"
                                           class="payment-method">
                                    <label for="bank-transform">실시간 계좌이체</label>
                                    <input type="radio" name="payment-method" id="deposit" class="payment-method">
                                    <label for="deposit">무통장입금(가상계좌)</label>
                                </td>
                            </tr>
                        </table>
                    </section>
                    <section class="agree">
                        <h3>신청자 동의</h3>
                        <div class="agreement-all-wrap">
                            <input type="checkbox" name="agree-all" id="agree-all" class="agree-all">
                            <label for="agree-all">전체동의</label>
                        </div>
                        <div class="agreement-wrap">
                            <ul>
                                <li>
                                    <div class="input-box">
                                        <input type="checkbox" name="offer-consent" id="offer-consent"
                                               class="offer-consent">
                                        <label for="offer-consent">(필수) 개인정보 제3자 제공 동의</label>
                                    </div>
                                    <p>신청자의 개인정보가 신청여부 확인 등 모임 진행을 위해 개설자에게 제공됩니다.</p>
                                    <a href="">내용보기</a>
                                </li>
                                <li>
                                    <div class="input-box">
                                        <input type="checkbox" name="refund-consent" id="refund-consent"
                                               class="refund-consent">
                                        <label for="refund-consent">(필수) 취소/환불약관 동의</label>
                                    </div>
                                    <p>신청기간 마감 전까지 환불신청 가능(결제수단, 사유, 환불시점에 따라 수수료 차감)</p>
                                    <a href="">내용보기</a>
                                </li>
                            </ul>
                        </div>
                    </section>
                    <section class="btn-wrap">
                        <button class="make-pay">결제하기</button>
                        <button class="cancel">취소</button>
                    </section>
                </form>
            </div>
        </div>
    </section>
@endsection

