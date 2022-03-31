@extends('desktop.layouts.frames.basic_frame')

@section('script')
    <script type="text/javascript" src="{{ asset('js/parsley.min.js') }}"></script>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ mix('css/desktop/pages/albatalk/albatalk-resume.css') }}">
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
                <h2>이력서 작성</h2>
                <form>
                    @csrf
                    <div style="padding-bottom: 40px" class="inquire-form-wrap">
                        <table class="head">
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
                        </table>
                    </div>
                    <div style="display: flex; flex-wrap: wrap; margin-bottom: 40px;">
                        <img class="imgcard" src="http://dbv2020.onoffmix.test/storage/program/2/thumbnail/123.jpg"></img>
                        <div class="inquire-form-wrap" style="float: right;">
                            <table class="middle" style="width: 1040px; margin-top: -18px; border-top: 0px">
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
                            </table>
                            <table style="width: 1040px;">
                                <tr style="border-top: 0px">
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
                        </div>
                        <div style="font-size: 12px; color: #777; margin-top: 10px">※ 2MB 이내의 JPG, JPEG, PNG, GIF </div>
                    </div>
                    <div style="display: flex; flex-wrap: wrap;">
                        <div class="inquire-form-wrap" style="margin-right: 40px">
                            <table class="middle2" style="width: 620px; margin-top: 10px;">
                                <div style="font-size: 16px; font-weight: bold;">학력사항</div>
                                <tr>
                                    <th>학위취득년월</th>
                                    <td class="school-day-wrap">
                                        <input type="text"
                                               id="subway"
                                               name="subway"
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    </td>
                                </tr>
                                <tr>
                                    <th>학위취득년월</th>
                                    <td class="school-day-wrap">
                                        <input type="text"
                                               id="subway"
                                               name="subway"
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    </td>
                                </tr>
                                <tr>
                                    <th>학위취득년월</th>
                                    <td class="school-day-wrap">
                                        <input type="text"
                                               id="subway"
                                               name="subway"
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    </td>
                                </tr>
                                <tr>
                                    <th>학위취득년월</th>
                                    <td class="school-day-wrap">
                                        <input type="text"
                                               id="subway"
                                               name="subway"
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    </td>
                                </tr>
                                <tr>
                                    <th>학위취득년월</th>
                                    <td class="school-day-wrap">
                                        <input type="text"
                                               id="subway"
                                               name="subway"
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="inquire-form-wrap">
                            <table class="middle3">
                                <div style="font-size: 16px; font-weight: bold;">희망 순위</div>
                                <tr>
                                    <th>구분</th>
                                    <th>1순위</th>
                                    <th>2순위</th>
                                    <th>3순위</th>
                                </tr>
                                <tr>
                                    <th>희망 진료과</th>
                                    <td class="first-department-wrap">
                                        <input type="text"
                                               id="subway"
                                               name="subway"
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    </td>
                                    <td class="second-department-wrap">
                                        <input type="text"
                                               id="subway"
                                               name="subway"
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    </td>
                                    <td class="third-department-wrap">
                                        <input type="text"
                                               id="subway"
                                               name="subway"
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    </td>
                                </tr>
                                <tr>
                                    <th>희망 부서</th>
                                    <td class="school-day-wrap">
                                        <input type="text"
                                               id="subway"
                                               name="subway"
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                        <div class="inquire-form-wrap" style="margin-top: 40px">
                            <table class="middle4">
                                <div style="font-size: 16px; font-weight: bold;">면허/자격증 보유 현황</div>
                                <tr>
                                    <th style="width: 13%;">구분</th>
                                    <th>자격증명</th>
                                    <th>취득년월</th>
                                    <th>인가, 관리기관</th>
                                </tr>
                                <tr>
                                    <th>1</th>
                                    <td class="first-department-wrap">
                                        <input type="text"
                                               id="subway"
                                               name="subway"
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    </td>
                                    <td class="second-department-wrap">
                                        <input type="text"
                                               id="subway"
                                               name="subway"
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    </td>
                                    <td class="third-department-wrap">
                                        <input type="text"
                                               id="subway"
                                               name="subway"
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    </td>
                                </tr>
                                <tr>
                                    <th>2</th>
                                    <td class="first-department-wrap">
                                        <input type="text"
                                               id="subway"
                                               name="subway"
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    </td>
                                    <td class="second-department-wrap">
                                        <input type="text"
                                               id="subway"
                                               name="subway"
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    </td>
                                    <td class="third-department-wrap">
                                        <input type="text"
                                               id="subway"
                                               name="subway"
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    </td>
                                </tr>
                                <tr>
                                    <th>3</th>
                                    <td class="first-department-wrap">
                                        <input type="text"
                                               id="subway"
                                               name="subway"
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    </td>
                                    <td class="second-department-wrap">
                                        <input type="text"
                                               id="subway"
                                               name="subway"
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    </td>
                                    <td class="third-department-wrap">
                                        <input type="text"
                                               id="subway"
                                               name="subway"
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    </td>
                                </tr>
                                <tr>
                                    <th>4</th>
                                    <td class="first-department-wrap">
                                        <input type="text"
                                               id="subway"
                                               name="subway"
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    </td>
                                    <td class="second-department-wrap">
                                        <input type="text"
                                               id="subway"
                                               name="subway"
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    </td>
                                    <td class="third-department-wrap">
                                        <input type="text"
                                               id="subway"
                                               name="subway"
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    </td>
                                </tr>
                                <tr>
                                    <th>5</th>
                                    <td class="first-department-wrap">
                                        <input type="text"
                                               id="subway"
                                               name="subway"
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    </td>
                                    <td class="second-department-wrap">
                                        <input type="text"
                                               id="subway"
                                               name="subway"
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    </td>
                                    <td class="third-department-wrap">
                                        <input type="text"
                                               id="subway"
                                               name="subway"
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="inquire-form-wrap" style="margin-top: 40px;">
                            <div style="font-size: 16px; font-weight: bold;">자기소개</div>
                            <input type="text"
                                   id="subway"
                                   name="subway"
                                   data-parsley-required="true"
                                   style="margin-top: 10px; width: 1280px; height: 250px; border-radius: 25px;"
                                   placeholder="자기소개를 1,000자 이내로 입력해 주세요.">
                        </div>
                    <div style="display: flex; flex-wrap: wrap;">
                        <div style="margin-top: 40px;font-size: 16px; font-weight: bold;">치과 업무 능력 자기 평가표<span style="margin-left: 10px; color: #222; font-weight: normal;">생각하는 업무 능력을 평가해주세요. 본 정보는 인재 능력을 평가 지표로 사용되며 추후 교육자료로 활용됩니다.</span></div>
                        <div class="inquire-form-wrap" style="margin-top: 0; margin-right: 20px;">
                            <table class="middle5">
                                <tr>
                                    <th style="width: 190px;">구분</th>
                                    <th style="width: 220px;"></th>
                                    <th>자가평가 점수</th>
                                    <th>교욱가능 유무</th>
                                </tr>
                                <tr>
                                    <th rowspan=4>임플란트</th>
                                    <td class="second-department-wrap">임플란트 수술 어시스트</td>
                                    <td style="padding-left: 0" class="second-department-wrap">
                                        <input type="text"
                                               id="subway"
                                               name="subway"
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    </td>
                                    <td class="third-department-wrap">
                                        <input type="checkbox"
                                               id="subway"
                                               name="subway"
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="second-department-wrap">임플란트 수술 어시스트</td>
                                    <td style="padding-left: 0" class="second-department-wrap">
                                        <input type="text"
                                               id="subway"
                                               name="subway"
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    </td>
                                    <td class="third-department-wrap">
                                        <input type="checkbox"
                                               id="subway"
                                               name="subway"
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="second-department-wrap">임플란트 수술 어시스트</td>
                                    <td style="padding-left: 0" class="second-department-wrap">
                                        <input type="text"
                                               id="subway"
                                               name="subway"
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    </td>
                                    <td class="third-department-wrap">
                                        <input type="checkbox"
                                               id="subway"
                                               name="subway"
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="second-department-wrap">임플란트 수술 어시스트</td>
                                    <td style="padding-left: 0" class="second-department-wrap">
                                        <input type="text"
                                               id="subway"
                                               name="subway"
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    </td>
                                    <td class="third-department-wrap">
                                        <input type="checkbox"
                                               id="subway"
                                               name="subway"
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="inquire-form-wrap" style="margin-top: 0">
                            <table class="middle5">
                                <tr>
                                    <th style="width: 190px;">구분</th>
                                    <th style="width: 220px;"></th>
                                    <th>자가평가 점수</th>
                                    <th>교욱가능 유무</th>
                                </tr>
                                <tr>
                                    <th rowspan=4>임플란트</th>
                                    <td class="second-department-wrap">임플란트 수술 어시스트</td>
                                    <td style="padding-left: 0" class="second-department-wrap">
                                        <input type="text"
                                               id="subway"
                                               name="subway"
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    </td>
                                    <td class="third-department-wrap">
                                        <input type="checkbox"
                                               id="subway"
                                               name="subway"
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="second-department-wrap">임플란트 수술 어시스트</td>
                                    <td style="padding-left: 0" class="second-department-wrap">
                                        <input type="text"
                                               id="subway"
                                               name="subway"
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    </td>
                                    <td class="third-department-wrap">
                                        <input type="checkbox"
                                               id="subway"
                                               name="subway"
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="second-department-wrap">임플란트 수술 어시스트</td>
                                    <td style="padding-left: 0" class="second-department-wrap">
                                        <input type="text"
                                               id="subway"
                                               name="subway"
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    </td>
                                    <td class="third-department-wrap">
                                        <input type="checkbox"
                                               id="subway"
                                               name="subway"
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="second-department-wrap">임플란트 수술 어시스트</td>
                                    <td style="padding-left: 0" class="second-department-wrap">
                                        <input type="text"
                                               id="subway"
                                               name="subway"
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    </td>
                                    <td class="third-department-wrap">
                                        <input type="checkbox"
                                               id="subway"
                                               name="subway"
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 전화번호을 입력해주세요">
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </form>
                <button class="submit" type="submit">이력서 등록</button>
            </section>
        </div>
    </section>
@endsection
