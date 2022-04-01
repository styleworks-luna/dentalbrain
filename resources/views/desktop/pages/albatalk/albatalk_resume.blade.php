@extends('desktop.layouts.frames.basic_frame')

@section('script')
    <script type="text/javascript" src="{{ asset('js/parsley.min.js') }}"></script>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ mix('css/desktop/pages/albatalk/albatalk-resume.css') }}">
@endsection

@section('content')
    <section class="albatalk-resume-wrap">
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
                                <th>희망 근무 지역</th>
                                <td class="work-area-wrap">
                                    <input type="text"
                                           id="work-area"
                                           name="work-area">
                                </td>
                            </tr>
                            <tr>
                                <th>희망 근무 요일</th>
                                <td class="work-day-wrap">
                                    <input type="text"
                                           id="work-day"
                                           name="work-day">
                                </td>
                            </tr>
                            <tr>
                                <th>희망 근무 시간</th>
                                <td class="work-time-wrap">
                                    <input type="text"
                                           id="work-time"
                                           name="work-time">
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div style="display: flex; flex-wrap: wrap; margin-bottom: 40px;">
                        <img class="imgcard" src="http://dbv2020.onoffmix.test/storage/program/2/thumbnail/123.jpg"></img>
                        <div class="inquire-form-wrap" style="float: right;">
                            <table class="middle" style="width: 1040px; margin-top: -18px; border-top: 0px">
                                <tr>
                                    <th>이름 *</th>
                                    <td class="name-wrap">
                                        <input type="text"
                                               id="name"
                                               name="name"
                                               placeholder="이름 입력 (최소 2자 이상)"
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 이름을 입력해주세요">
                                    </td>

                                    <th>영문 이름 *</th>
                                    <td class="english-name-wrap">
                                        <input type="text"
                                               id="english-name"
                                               name="english-name"
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 영문 이름을 입력해주세요.">
                                    </td>
                                </tr>
                                <tr>
                                    <th>생년 월일 *</th>
                                    <td class="birthday-wrap">
                                        <input type="text"
                                               id="birthday"
                                               name="birthday"
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 생년 월일을 입력해주세요.">
                                    </td>

                                    <th>휴대폰 번호 *</th>
                                    <td class="phone-wrap">
                                        <input type="text"
                                               id="phone"
                                               name="phone"
                                               placeholder="‘-‘ 없이 입력"
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 휴대폰 번호를 입력해주세요.">
                                    </td>
                                </tr>
                                <tr>
                                    <th>비상연락처 *</th>
                                    <td class="emer-phone-wrap">
                                        <input type="text"
                                               id="emer-phone"
                                               name="emer-phone"
                                               placeholder="‘-‘ 없이 입력"
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 비상연락처를 입력해주세요.">
                                    </td>

                                    <th>이메일 *</th>
                                    <td class="email-wrap">
                                        <input type="text"
                                               id="email"
                                               name="email"
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 이메일을 입력해주세요.">
                                    </td>
                                </tr>
                            </table>
                            <table style="width: 1040px;">
                                <tr style="border-top: 0px">
                                    <th>주소 *</th>
                                    <td class="address-wrap">
                                        <input type="text"
                                               id="address"
                                               name="address"
                                               style="width: 790px"
                                               data-parsley-required="true"
                                               data-parsley-required-message="※ 주소를 입력해주세요">
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
                                    <td class="grade-day-wrap">
                                        <input type="text"
                                               id="grade-day"
                                               name="grade-day">
                                    </td>
                                </tr>
                                <tr>
                                    <th>출신학교</th>
                                    <td class="school-wrap">
                                        <input type="text"
                                               id="school"
                                               name="school">
                                    </td>
                                </tr>
                                <tr>
                                    <th>학과(세부전공)</th>
                                    <td class="major-wrap">
                                        <input type="text"
                                               id="major"
                                               name="major">
                                    </td>
                                </tr>
                                <tr>
                                    <th>학위</th>
                                    <td class="degree-wrap">
                                        <input type="text"
                                               id="degree"
                                               name="degree">
                                    </td>
                                </tr>
                                <tr>
                                    <th>졸업구분</th>
                                    <td class="graduated-wrap">
                                        <input type="text"
                                               id="graduated"
                                               name="graduated">
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
                                    <td class="first-treatment-wrap">
                                        <input type="text"
                                               id="first-treatment"
                                               name="first-treatment"
                                               placeholder="ex. 교정">
                                    </td>
                                    <td class="second-treatment-wrap">
                                        <input type="text"
                                               id="second-treatment"
                                               name="second-treatment">
                                    </td>
                                    <td class="third-treatment-wrap">
                                        <input type="text"
                                               id="third-treatment"
                                               name="third-treatment">
                                    </td>
                                </tr>
                                <tr>
                                    <th>희망 부서</th>
                                    <td class="first-department-wrap">
                                        <input type="text"
                                               id="first-department"
                                               name="first-department"
                                               placeholder="ex. 진료실">
                                    </td>
                                    <td class="second-department-wrap">
                                        <input type="text"
                                               id="second-department"
                                               name="second-department">
                                    </td>
                                    <td class="third-department-wrap">
                                        <input type="text"
                                               id="third-department"
                                               name="third-department">
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
                                    <td class="first-certificate-name-wrap">
                                        <input type="text"
                                               id="first-certificate-name"
                                               name="first-certificate-name">
                                    </td>
                                    <td class="first-certificate-day-wrap">
                                        <input type="text"
                                               id="second-certificate-day"
                                               name="second-certificate-day">
                                    </td>
                                    <td class="first-certificate-agency-wrap">
                                        <input type="text"
                                               id="third-certificate-agency"
                                               name="third-certificate-agency">
                                    </td>
                                </tr>
                                <tr>
                                    <th>2</th>
                                    <td class="second-certificate-name-wrap">
                                        <input type="text"
                                               id="second-certificate-name"
                                               name="second-certificate-name">
                                    </td>
                                    <td class="second-certificate-day-wrap">
                                        <input type="text"
                                               id="second-certificate-day"
                                               name="second-certificate-day">
                                    </td>
                                    <td class="second-certificate-agency-wrap">
                                        <input type="text"
                                               id="second-certificate-agency"
                                               name="second-certificate-agency">
                                    </td>
                                </tr>
                                <tr>
                                    <th>3</th>
                                    <td class="third-certificate-name-wrap">
                                        <input type="text"
                                               id="third-certificate-name"
                                               name="third-certificate-name">
                                    </td>
                                    <td class="third-certificate-day-wrap">
                                        <input type="text"
                                               id="third-certificate-day"
                                               name="third-certificate-day">
                                    </td>
                                    <td class="third-certificate-agency-wrap">
                                        <input type="text"
                                               id="third-certificate-agency"
                                               name="third-certificate-agency">
                                    </td>
                                </tr>
                                <tr>
                                    <th>4</th>
                                    <td class="fourth-certificate-name-wrap">
                                        <input type="text"
                                               id="fourth-certificate-name"
                                               name="fourth-certificate-name">
                                    </td>
                                    <td class="fourth-certificate-day-wrap">
                                        <input type="text"
                                               id="fourth-certificate-day"
                                               name="fourth-certificate-day">
                                    </td>
                                    <td class="fourth-certificate-agency-wrap">
                                        <input type="text"
                                               id="fourth-certificate-agency"
                                               name="fourth-certificate-agency">
                                    </td>
                                </tr>
                                <tr>
                                    <th>5</th>
                                    <td class="fifth-certificate-name-wrap">
                                        <input type="text"
                                               id="fifth-certificate-name"
                                               name="fifth-certificate-name">
                                    </td>
                                    <td class="fifth-certificate-day-wrap">
                                        <input type="text"
                                               id="fifth-certificate-day"
                                               name="fifth-certificate-day">
                                    </td>
                                    <td class="fifth-certificate-agency-wrap">
                                        <input type="text"
                                               id="fifth-certificate-agency"
                                               name="fifth-certificate-agency">
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
                                    <td>임플란트 수술 어시스트</td>
                                    <td class="select-box">
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="checkbox">
                                    </td>
                                </tr>
                                <tr>
                                    <td>임플란트 인상채득</td>
                                    <td class="select-box">
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="checkbox">
                                    </td>
                                </tr>
                                <tr>
                                    <td>임플란트 셋팅</td>
                                    <td class="select-box">
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="checkbox">
                                    </td>
                                </tr>
                                <tr>
                                    <td>사용했던 임플란트 종류</td>
                                    <td class="select-box">
                                        <input type="text" placeholder="수기입력" style="width: 200px">
                                    </td>
                                </tr>
                                <tr>
                                    <th rowspan=13>보철</th>
                                    <td>어시스트</td>
                                    <td class="select-box">
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="checkbox">
                                    </td>
                                </tr>
                                <tr>
                                    <td>구치부싱글크라운 인상채득</td>
                                    <td class="select-box">
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="checkbox">
                                    </td>
                                </tr>
                                <tr>
                                    <td>구치부싱글크라운 임시치아</td>
                                    <td class="select-box">
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="checkbox">
                                    </td>
                                </tr>
                                <tr>
                                    <td>전치부싱글크라운 인상채득</td>
                                    <td class="select-box">
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="checkbox">
                                    </td>
                                </tr>
                                <tr>
                                    <td>전치부싱글크라운 임시치아</td>
                                    <td class="select-box">
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="checkbox">
                                    </td>
                                </tr>
                                <tr>
                                    <td>구치부브릿지 인상채득</td>
                                    <td class="select-box">
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="checkbox">
                                    </td>
                                </tr>
                                <tr>
                                    <td>구치부브릿지 임시치아</td>
                                    <td class="select-box">
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="checkbox">
                                    </td>
                                </tr>
                                <tr>
                                    <td>전치부브릿지 인상채득</td>
                                    <td class="select-box">
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="checkbox">
                                    </td>
                                </tr>
                                <tr>
                                    <td>전치부브릿지 임시치아</td>
                                    <td class="select-box">
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="checkbox">
                                    </td>
                                </tr>
                                <tr>
                                    <td>싱글크라운셋팅</td>
                                    <td class="select-box">
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="checkbox">
                                    </td>
                                </tr>
                                <tr>
                                    <td>싱글크라운(여러개) 셋팅</td>
                                    <td class="select-box">
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="checkbox">
                                    </td>
                                </tr>
                                <tr>
                                    <td>브릿지셋팅</td>
                                    <td class="select-box">
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="checkbox">
                                    </td>
                                </tr>
                                <tr>
                                    <td>resin core</td>
                                    <td class="select-box">
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="checkbox">
                                    </td>
                                </tr>
                                <tr>
                                    <th rowspan=2>치주</th>
                                    <td>스켈링</td>
                                    <td class="select-box">
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="checkbox">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Curette</td>
                                    <td class="select-box">
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="checkbox">
                                    </td>
                                </tr>
                                <tr>
                                    <th rowspan=2>미백</th>
                                    <td>전문가미백</td>
                                    <td class="select-box">
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="checkbox">
                                    </td>
                                </tr>
                                <tr>
                                    <td>자가미백</td>
                                    <td class="select-box">
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="checkbox">
                                    </td>
                                </tr>
                                <tr>
                                    <th rowspan=2>보험청구</th>
                                    <td>교정과 보험청구</td>
                                    <td class="select-box">
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="checkbox">
                                    </td>
                                </tr>
                                <tr>
                                    <td>교정외 보험청구</td>
                                    <td class="select-box">
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="checkbox">
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
                                    <th rowspan=11>보존</th>
                                    <td>러버댐장착</td>
                                    <td class="select-box">
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="checkbox">
                                    </td>
                                </tr>
                                <tr>
                                    <td>인레이셋팅</td>
                                    <td class="select-box">
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="checkbox">
                                    </td>
                                </tr>
                                <tr>
                                    <td>전치부레진필링</td>
                                    <td class="select-box">
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="checkbox">
                                    </td>
                                </tr>
                                <tr>
                                    <td>구치부 레진 필링</td>
                                    <td class="select-box">
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="checkbox">
                                    </td>
                                </tr>
                                <tr>
                                    <td>인레이셋팅</td>
                                    <td class="select-box">
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="checkbox">
                                    </td>
                                </tr>
                                <tr>
                                    <td>CA 레진 필링</td>
                                    <td class="select-box">
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="checkbox">
                                    </td>
                                </tr>
                                <tr>
                                    <td>base 도포</td>
                                    <td class="select-box">
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="checkbox">
                                    </td>
                                </tr>
                                <tr>
                                    <td>실란트</td>
                                    <td class="select-box">
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="checkbox">
                                    </td>
                                </tr>
                                <tr>
                                    <td>불소도포</td>
                                    <td class="select-box">
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="checkbox">
                                    </td>
                                </tr>
                                <tr>
                                    <td>PA촬영(구내엑스레이촬영)</td>
                                    <td class="select-box">
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="checkbox">
                                    </td>
                                </tr>
                                <tr>
                                    <td>pano촬영</td>
                                    <td class="select-box">
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="checkbox">
                                    </td>
                                </tr>
                                <tr>
                                    <th rowspan=9>교정</th>
                                    <td>Ceph촬영</td>
                                    <td class="select-box">
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="checkbox">
                                    </td>
                                </tr>
                                <tr>
                                    <td>교정환자 cleasing</td>
                                    <td class="select-box">
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="checkbox">
                                    </td>
                                </tr>
                                <tr>
                                    <td>와이어 넣기</td>
                                    <td class="select-box">
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="checkbox">
                                    </td>
                                </tr>
                                <tr>
                                    <td>와이어 결찰</td>
                                    <td class="select-box">
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="checkbox">
                                    </td>
                                </tr>
                                <tr>
                                    <td>진단 모델 인상채득</td>
                                    <td class="select-box">
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="checkbox">
                                    </td>
                                </tr>
                                <tr>
                                    <td>마운팅</td>
                                    <td class="select-box">
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="checkbox">
                                    </td>
                                </tr>
                                <tr>
                                    <td>E/O촬영</td>
                                    <td class="select-box">
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="checkbox">
                                    </td>
                                </tr>
                                <tr>
                                    <td>I/O촬영</td>
                                    <td class="select-box">
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="checkbox">
                                    </td>
                                </tr>
                                <tr>
                                    <td>석고 붓기</td>
                                    <td class="select-box">
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="checkbox">
                                    </td>
                                </tr>
                                <tr>
                                    <th rowspan=4>상담</th>
                                    <td>임플란트 상담</td>
                                    <td class="select-box">
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="checkbox">
                                    </td>
                                </tr>
                                <tr>
                                    <td>보철상담</td>
                                    <td class="select-box">
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="checkbox">
                                    </td>
                                </tr>
                                <tr>
                                    <td>덴쳐상담</td>
                                    <td class="select-box">
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="checkbox">
                                    </td>
                                </tr>
                                <tr>
                                    <td>교정상담</td>
                                    <td class="select-box">
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="checkbox">
                                    </td>
                                </tr>
                                <tr>
                                    <th>병원 OPEN</th>
                                    <td>open&setting</td>
                                    <td class="select-box">
                                        <input type="text">
                                    </td>
                                    <td>
                                        <input type="checkbox">
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
