@extends('desktop.layouts.frames.basic_frame')

@section('script')
    <script type="text/javascript" src="{{ asset('js/jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.ui.emailbox.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/parsley.min.js') }}"></script>
    <script src="https://t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
    <script type="text/javascript" src="{{ asset('js/pages/lecture/lecture-apply.js') }}"></script>
@endsection

@section('style')
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
                                @if($program->is_online == true)
                                    <span class="online">온라인</span>
                                @else
                                    <span class="offline">오프라인</span>
                                @endif

                                <p class="lecture-subject">
                                    {{ $program->major_category_name }} &middot; {{ $program->minor_category_name}}</p>
                            </div>
                            <h2 class="lecture-title">{{ $program->title }}</h2>
                            <table>
                                @if($program->is_online == true)
                                    <tr>
                                        <th>강의시간</th>
                                        <td><p class="lecture-length">{{ $program->running_time }}</p></td>
                                    </tr>
                                @else
                                    <tr>
                                        <th>강의일시</th>
                                        <td>
                                            <p class="lecture-length">{{ carbonDate($program->place->started_at,'Y년 MMMM Do (ddd) HH:mm ') }}
                                                ~ {{ carbonDate($program->place->ended_at,'Y년 MMMM Do (ddd) HH:mm ') }}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>강의장소</th>
                                        <td>
                                            <p class="lecture-length">{{ $program->place->address.' , '.$program->place->address_detail }}</p>
                                        </td>
                                    </tr>
                                @endif
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
                                           id="email"
                                           name="email"
                                           class="email_box"
                                           data-parsley-required="true"
                                           data-parsley-type="email"
                                           data-parsley-class-handler=".ui-emailbox">
                                </td>
                            </tr>
                            <tr>
                                <th>휴대전화</th>
                                <td>
                                    <input type="text"
                                           id="phone"
                                           name="phone"
                                           class="phone">
                                </td>
                            </tr>
                        </table>
                    </section>
                    <section class="additional-information">
                        <h3>추가 정보 입력</h3>
                        <div class="multiple-single-choice">
                            <h4>객관식 단일 선택 질문 객관식 단일 선택 질문 <em>(필수)</em></h4>
                            <div class="choices">
                                <ul>
                                    <li class="radio-wrap">
                                        <input type="radio" id="choice-01" name="single-choice">
                                        <label for="choice-01">선택 1</label>
                                    </li>
                                    <li class="radio-wrap">
                                        <input type="radio" id="choice-02" name="single-choice">
                                        <label for="choice-02">선택 2</label>
                                    </li>
                                    <li class="radio-wrap">
                                        <input type="radio" id="choice-03" name="single-choice">
                                        <label for="choice-03">선택 3</label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="multiple-choice">
                            <h4>객관식 다중 선택 질문</h4>
                            <div class="choices">
                                <ul>
                                    <li class="checkbox-wrap">
                                        <input type="checkbox" id="multiple-choice-01" name="multiple-choice">
                                        <label for="multiple-choice-01">선택 1</label>
                                    </li>
                                    <li class="checkbox-wrap">
                                        <input type="checkbox" id="multiple-choice-02" name="multiple-choice">
                                        <label for="multiple-choice-02">선택 2</label>
                                    </li>
                                    <li class="checkbox-wrap">
                                        <input type="checkbox" id="multiple-choice-03" name="multiple-choice">
                                        <label for="multiple-choice-03">선택 3</label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="short-answer">
                            <h4>주관식 입력 질문 주관식 입력 질문</h4>
                            <div class="answers">
                                <input type="text" id="short-answer-response" name="short-answer-response"
                                       class="short-answer-response" placeholder="답변을 입력하세요.">
                            </div>
                        </div>
                        <div class="address-question">
                            <h4>주소 질문</h4>
                            <div class="answers">
                                <div class="address-form-wrap">
                                    <input type="button" class="btn-address" value="주소검색">
                                    <input type="text" id="address" name="address" class="address" disabled="disabled">
                                    <input type="text" id="address-detail" name="address-detail" class="address-detail"
                                           placeholder="상세주소를 입력하세요.">
                                </div>
                            </div>
                        </div>
                        <div class="file-question">
                            <h4>파일입력질문</h4>
                            <div class="answers">
                                <div class="file-wrap">
                                    <input type="file"
                                           id="file-upload"
                                           class="upload-hidden"
                                           accept=".Key, .PDF, .Doc, .PPT, .Pages, .pptx, .docx, .xlsx,
                                               .xls, .hwp, .JPG, .JPEG, .PNG, .GIF  .zip, .alz, .rar">
                                    <label for="file-upload" class="btn-file-upload">파일선택</label>
                                    <input type="text" id="file-name" name="file-name" class="file-name"
                                           value="파일을 업로드해주세요." disabled="disabled">
                                </div>
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
                                    <div class="radio-wrap">
                                        <input type="radio" id="credit" name="payment-method" class="payment-method">
                                        <label for="credit">신용카드</label>
                                    </div>
                                    <div class="radio-wrap">
                                        <input type="radio" id="bank-transform" name="payment-method"
                                               class="payment-method">
                                        <label for="bank-transform">실시간 계좌이체</label>
                                    </div>
                                    <div class="radio-wrap">
                                        <input type="radio" id="deposit" name="payment-method" class="payment-method">
                                        <label for="deposit">무통장입금(가상계좌)</label>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </section>
                    <section class="agree">
                        <h3>신청자 동의</h3>
                        <div class="agreement-all-wrap checkbox-wrap">
                            <input type="checkbox" id="agree-all" name="agree-all" class="agree-all">
                            <label for="agree-all">전체동의</label>
                        </div>
                        <div class="agreement-wrap">
                            <ul>
                                <li>
                                    <div class="checkbox-wrap">
                                        <input type="checkbox" id="offer-consent" name="offer-consent"
                                               class="offer-consent">
                                        <label for="offer-consent">(필수) 개인정보 제3자 제공 동의</label>
                                    </div>
                                    <p>신청자의 개인정보가 신청여부 확인 등 모임 진행을 위해 개설자에게 제공됩니다.</p>
                                    <a href="">내용보기</a>
                                </li>
                                <li>
                                    <div class="checkbox-wrap">
                                        <input type="checkbox" id="refund-consent" name="refund-consent"
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

