@extends('desktop.layouts.frames.basic_frame')

@section('vue')
    <script type="text/javascript" src="{{ asset('js/app/app.js')}}"></script>
@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('js/parsley.min.js') }}"></script>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ mix('css/desktop/pages/albatalk/albatalk-post.css') }}">
@endsection

@section('content')
    <section class="albatalk-wrap">
        <div class="title-wrap">
            <div class="container">
            </div>
        </div>
        <div class="container">
            <section class="wanted">
                <h2>구인 등록</h2>
                <form>
                    @csrf
                    <div class="inquire-form-wrap">
                        <table>
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
                                           placeholder="대표자명 입력(최소 2자 이상)"
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
                                           data-parsley-required-message="※ 대표자명을 입력해주세요">
                                </td>

                                <th>담장자 이메일 *</th>
                                <td class="manager-email-wrap">
                                    <input type="text"
                                           id="manager-email"
                                           name="manager-email"
                                           placeholder="대표자명 입력(최소 2자 이상)"
                                           data-parsley-required="true"
                                           data-parsley-required-message="※ 전화번호을 입력해주세요">
                                </td>
                            </tr>
                            <tr>
                                <th>전화번호 *</th>
                                <td class="phone-wrap">
                                    <input type="text"
                                           id="phone"
                                           name="phone"
                                           placeholder="대표자명 입력(최소 2자 이상)"
                                           data-parsley-required="true"
                                           data-parsley-required-message="※ 전화번호을 입력해주세요">
                                </td>
                            </tr>
                            <tr>
                                <th>홈페이지 주소 *</th>
                                <td class="page-wrap">
                                    <input type="text"
                                           id="page"
                                           name="page"
                                           placeholder="대표자명 입력(최소 2자 이상)"
                                           data-parsley-required="false"
                                           data-parsley-required-message="※ 전화번호을 입력해주세요">
                                </td>
                            </tr>
                        </table>
                        <table>
                            <tr>
                                <th>주소입력 *</th>
                                <td class="address-wrap">
                                    <input type="button" class="btn-address" value="주소검색"
                                           data-index="test">
                                    <input type="text" id="address" name="surveys[test][address]"
                                           class="address"
                                           data-index="test"
                                           readonly="readonly"
                                           data-parsley-required-message="주소를 검색해주세요.">
                                    <input type="text" id="address-detail"
                                           name="surveys[test][address_detail]"
                                           class="address-detail"
                                           placeholder="상세주소를 입력하세요."
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
                                    <input type="radio" id="field" name="field"
                                           data-parsley-required="true"
                                           data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    <label id="field">정규직</label>
                                    <input type="radio" id="field" name="field"
                                           data-parsley-required="true"
                                           data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    <label id="field">계약직</label>
                                    <input type="radio" id="field" name="field"
                                           data-parsley-required="true"
                                           data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    <label id="field">아르바이트</label>
                                </td>
                            </tr>
                            <tr>
                                <th>직종 *</th>
                                <td class="job-wrap">
                                    <input type="radio" id="field" name="field"
                                           data-parsley-required="true"
                                           data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    <label id="field">치과위생사</label>
                                    <input type="radio" id="field" name="field"
                                           data-parsley-required="true"
                                           data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    <label id="field">간호조무사</label>
                                    <input type="radio" id="field" name="field"
                                           data-parsley-required="true"
                                           data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    <label id="field">관리 및 경영지원</label>
                                    <input type="radio" id="field" name="field"
                                           data-parsley-required="true"
                                           data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    <label id="field">코디네이터/리셉션</label>
                                    <input type="radio" id="field" name="field"
                                           data-parsley-required="true"
                                           data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    <label id="field">무관</label>
                                </td>
                            </tr>
                            <tr>
                                <th>급여 *</th>
                                <td class="pay-wrap">
                                    <input type="radio" id="field" name="field"
                                           data-parsley-required="true"
                                           data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    <label id="field">협의 후 결정</label>
                                    <input type="radio" id="field" name="field"
                                           data-parsley-required="true"
                                           data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    <label id="field">내규에 따름</label>
                                    <input type="radio" id="field" name="field"
                                           data-parsley-required="true"
                                           data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    <label id="field">연봉제</label>
                                    <input type="radio" id="field" name="field"
                                           data-parsley-required="true"
                                           data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    <label id="field">기타</label>
                                    <input type="text" placeholder="내용을 입력해주세요.">
                                </td>
                            </tr>
                        </table>
                    </div>
                </form>
            </section>

        </div>
    </section>
@endsection
