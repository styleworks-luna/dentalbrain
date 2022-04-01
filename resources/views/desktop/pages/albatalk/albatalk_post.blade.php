@extends('desktop.layouts.frames.basic_frame')

@section('script')
    <script type="text/javascript" src="{{ asset('js/parsley.min.js') }}"></script>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ mix('css/desktop/pages/albatalk/albatalk-post.css') }}">
@endsection

@section('content')
    <section class="albatalk-post-wrap">
        <div class="title-wrap">
            <div class="container">
                <a>이력서 등록</a>
                <a>구인등록</a>
                <a>헤드헌팅</a>
            </div>
        </div>
        <div class="container">
            <section class="wanted">
                <h2>구인 등록</h2>
                <form>
                    <div style="display: flex; float: right;">
                        <div class="inquire-form-wrap">
                            <table class="top">
                                <tr>
                                    <th>치과명 *</th>
                                    <td class="name-wrap">
                                        <input type="text"
                                               id="name"
                                               name="name"
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 치과명을 입력해주세요">
                                    </td>

                                    <th>담당자명 *</th>
                                    <td class="manager-wrap">
                                        <input type="text"
                                               id="manager"
                                               name="manager"
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 담당자명을 입력해주세요">
                                    </td>
                                </tr>
                                <tr>
                                    <th>대표자명 *</th>
                                    <td class="ceo-wrap">
                                        <input type="text"
                                               id="ceo"
                                               name="ceo"
                                               placeholder="대표자명 입력(최소 2자 이상)"
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 대표자명을 입력해주세요">
                                    </td>

                                    <th>담장자 전화번호 *</th>
                                    <td class="manager-phone-wrap">
                                        <input type="text"
                                               id="manager-phone"
                                               name="manager-phone"
                                               placeholder="‘-‘ 없이 입력"
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    </td>
                                </tr>
                                <tr>
                                    <th>사업자등록번호 *</th>
                                    <td class="num-wrap">
                                        <input type="text"
                                               id="num"
                                               name="num"
                                               placeholder="대표자명 입력(최소 2자 이상)"
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 사업자등록번호를 입력해주세요.">
                                    </td>

                                    <th>담장자 이메일 *</th>
                                    <td class="manager-email-wrap">
                                        <input type="text"
                                               id="manager-email"
                                               name="manager-email"
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 이메일을 입력해주세요.">
                                    </td>
                                </tr>
                                <tr>
                                    <th>전화번호 *</th>
                                    <td class="phone-wrap">
                                        <input type="text"
                                               id="phone"
                                               name="phone"
                                               placeholder="‘-‘ 없이 입력"
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    </td>
                                </tr>
                                <tr>
                                    <th>홈페이지 주소</th>
                                    <td class="page-wrap">
                                        <input type="text"
                                               id="page"
                                               name="page"
                                               data-parsley-required="false">
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="inquire-form-wrap">
                        <table style="border-top: 0">
                            <tr>
                                <th>주소입력 *</th>
                                <td class="address-wrap">
                                    <input type="button" class="btn-address" value="주소검색"
                                           data-index="test">
                                    <input type="text" id="address" name="surveys[test][address]"
                                           class="address"
                                           data-index="test"
                                           readonly="readonly"
                                           data-parsley-required-message="※ 주소를 입력해주세요.">
                                    <input type="text" id="address-detail"
                                           name="surveys[test][address_detail]"
                                           class="address-detail"
                                           placeholder="상세주소를 입력"
                                           data-parsley-required-message="상세주소를 입력하세요">
                                </td>
                            </tr>
                            <tr>
                                <th>인근 지하철역</th>
                                <td class="subway-wrap">
                                    <input type="text"
                                           id="subway"
                                           name="subway"
                                           placeholder="인근 지하철역을 입력해주세요.(ex: 7호선 신논현 도보 5분)"
                                           data-parsley-required="true"
                                           data-parsley-required-message="※ 전화번호을 입력해주세요">
                                </td>
                            </tr>
                            <tr>
                                <th>신청분야 *</th>
                                <td class="field-wrap">
                                    <input type="checkbox" id="field" name="field"
                                           data-parsley-required="true"
                                           data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    <label id="field">진료전반</label>
                                    <input type="checkbox" id="field" name="field"
                                           data-parsley-required="true"
                                           data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    <label id="field">상담/데스크</label>
                                    <input type="checkbox" id="field" name="field"
                                           data-parsley-required="true"
                                           data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    <label id="field">교정</label>
                                    <input type="checkbox" id="field" name="field"
                                           data-parsley-required="true"
                                           data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    <label id="field">보철</label>
                                    <input type="checkbox" id="field" name="field"
                                           data-parsley-required="true"
                                           data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    <label id="field">예방</label>
                                    <input type="checkbox" id="field" name="field"
                                           data-parsley-required="true"
                                           data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    <label id="field">구강외과</label>
                                    <input type="checkbox" id="field" name="field"
                                           data-parsley-required="true"
                                           data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    <label id="field">소아</label>
                                    <input type="checkbox" id="field" name="field"
                                           data-parsley-required="true"
                                           data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    <label id="field">스케일링</label>
                                    <input type="checkbox" id="field" name="field"
                                           data-parsley-required="true"
                                           data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    <label id="field">실장</label>
                                </td>
                            </tr>
                            <tr>
                                <th>근무형태 *</th>
                                <td class="work-type-wrap">
                                    <input type="radio" id="field" name="work-type"
                                           data-parsley-required="true"
                                           data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    <label for="field">정규직</label>
                                    <input type="radio" id="field" name="work-type"
                                           data-parsley-required="true"
                                           data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    <label id="field">계약직</label>
                                    <input type="radio" id="field" name="work-type"
                                           data-parsley-required="true"
                                           data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    <label id="field">아르바이트</label>
                                </td>
                            </tr>
                            <tr>
                                <th>직종 *</th>
                                <td class="job-wrap">
                                    <input type="radio" id="field" name="job"
                                           data-parsley-required="true"
                                           data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    <label id="field">치과위생사</label>
                                    <input type="radio" id="field" name="job"
                                           data-parsley-required="true"
                                           data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    <label id="field">간호조무사</label>
                                    <input type="radio" id="field" name="job"
                                           data-parsley-required="true"
                                           data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    <label id="field">관리 및 경영지원</label>
                                    <input type="radio" id="field" name="job"
                                           data-parsley-required="true"
                                           data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    <label id="field">코디네이터/리셉션</label>
                                    <input type="radio" id="field" name="job"
                                           data-parsley-required="true"
                                           data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    <label id="field">무관</label>
                                </td>
                            </tr>
                            <tr>
                                <th>급여 *</th>
                                <td class="pay-wrap">
                                    <input type="radio" id="field" name="pay"
                                           data-parsley-required="true"
                                           data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    <label id="field">협의 후 결정</label>
                                    <input type="radio" id="field" name="pay"
                                           data-parsley-required="true"
                                           data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    <label id="field">내규에 따름</label>
                                    <input type="radio" id="field" name="pay"
                                           data-parsley-required="true"
                                           data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    <label id="field">연봉제</label>
                                    <input type="radio" id="field" name="pay"
                                           data-parsley-required="true"
                                           data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    <label id="field">기타</label>
                                    <input type="text" placeholder="내용을 입력해주세요.">
                                </td>
                            </tr>
                            <tr>
                                <th>학력 *</th>
                                <td class="school-wrap">
                                    <input type="radio" id="field" name="school"
                                           data-parsley-required="true"
                                           data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    <input type="text" placeholder="학력선택">
                                    <input type="radio" id="field" name="school"
                                           data-parsley-required="true"
                                           data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    <label id="field">기타</label>
                                </td>
                            </tr>
                            <tr>
                                <th>경력 *</th>
                                <td class="career-wrap">
                                    <input type="radio" id="field" name="career"
                                           data-parsley-required="true"
                                           data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    <label id="field">신입</label>
                                    <input type="radio" id="field" name="career"
                                           data-parsley-required="true"
                                           data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    <label id="field" class="last">경력</label>
                                    <input type="text" placeholder="경력기간 선택">
                                </td>
                            </tr>
                            <tr>
                                <th>근무요일 *</th>
                                <td class="payday-wrap">
                                    <input type="radio" id="field" name="payday"
                                           data-parsley-required="true"
                                           data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    <label id="field">월~금(주 5일)</label>
                                    <input type="radio" id="field" name="payday"
                                           data-parsley-required="true"
                                           data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    <label id="field">월~토(토요일 격주 휴무)</label>
                                    <input type="radio" id="field" name="payday"
                                           data-parsley-required="true"
                                           data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    <label id="field">월~토</label>
                                    <input type="radio" id="field" name="payday"
                                           data-parsley-required="true"
                                           data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    <label id="field">기타</label>
                                    <input type="text" placeholder="내용을 입력해주세요.">
                                </td>
                            </tr>
                            <tr>
                                <th>복리후생 *</th>
                                <td class="welfare-wrap">
                                    <input type="checkbox" id="all" name="all"><label>점심식자</label>
                                    <input type="checkbox" id="all" name="all"><label>유니폼</label>
                                    <input type="checkbox" id="all" name="all"><label>주차</label>
                                    <input type="checkbox" id="all" name="all"><label>자기계발비</label>
                                    <input type="checkbox" id="all" name="all"><label>연월차지원</label>
                                    <input type="checkbox" id="all" name="all"><label class="last">휴가비지원</label>
                                    <input type="checkbox" id="all" name="all"><label>4대보험지원</label>
                                    <input type="checkbox" id="all" name="all"><label>연봉제</label>
                                    <input type="checkbox" id="all" name="all"><label>인센티브제</label>
                                    <input type="checkbox" id="all" name="all"><label>퇴직금지원</label>
                                    <input type="checkbox" id="all" name="all"><label class="last">야근수당지원</label>
                                </td>
                            </tr>
                            <tr>
                                <th>모집마감일 *</th>
                                <td class="deadline-wrap">
                                    <input type="radio" id="field" name="deadline"
                                           data-parsley-required="true"
                                           data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    <input type="text" placeholder="시작일자 선택">
                                    <input class="time" type="text" placeholder="HH:mm">
                                    <label id="field">부터</label>
                                    <input type="text" placeholder="마감일자 선택">
                                    <input class="time2" type="text" placeholder="HH:mm">
                                    <input type="radio" id="until-hiring" name="deadline">
                                    <label name="until-hiring" for="until-hiring">채용시까지</label>
                                </td>
                            </tr>
                            <tr>
                                <th>상세정보</th>
                                <td class="Detail-wrap">
                                </td>
                            </tr>
                            <tr>
                                <th>결제금액</th>
                                <td class="payment-wrap">
                                </td>
                            </tr>
                            <tr>
                                <th>결제방식 *</th>
                                <td class="paydeail-wrap">
                                    <span>
                                        <input type="radio" id="field" name="paydeail"
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 전화번호을 입력해주세요">
                                        <label id="field">신용카드</label>
                                        <input type="text" placeholder="신한">
                                    </span>
                                    <input class="last" type="radio" id="field" name="paydeail"
                                           data-parsley-required="true"
                                           data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    <label id="field">실시간 계좌이체</label>
                                </td>
                            </tr>
                        </table>
                    </div>
                </form>
                <button class="submit" type="submit">구인공고 등록</button>
            </section>
        </div>
    </section>
@endsection
