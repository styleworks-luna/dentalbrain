@extends('mobile.layouts.frames.basic_frame')

@section('script')
@endsection

@section('style')
    <link rel="stylesheet" href="{{ mix('css/mobile/pages/introduce/instructor.css') }}">
@endsection

@section('title')
    <a href="" class="btn-back"></a>
    <h1>강사소개</h1>
@endsection

@section('content')
    <section class="content">
        <div class="instructor-title-wrap">
            <img src="{{ asset("images/mobile/introduce/instructor_top_image.png") }}" alt="상단이미지">
        </div>
        <section class="instructor-content-wrap">
            <div class="m-container">
                <ul>
                    <li class="instructor-content">
                        <div class="instructor-head">
                            <img src="{{ asset('images/desktop/instructor/instructor_1.png') }}" alt="김민정 대표"
                                 class="instructor-photo">
                            <h2 class="instructor-name">김민정 대표</h2>
                        </div>
                        <div class="instructor-description">
                            <ul class="instructor-career">
                                <li>㈜브레인스펙병원교육개발원 대표</li>
                                <li>병의원 컨설팅 전문가</li>
                                <li>Harrison Assessment Debrifer</li>
                                <li>서울대학교치과병원 구강위생용품전시실운영</li>
                                <li>경희대학교치과병원 구강위생용품전시실운영</li>
                                <li>덴티움 USER 원장 및 스탭 강사</li>
                                <li>SDA스위스덴탈아카데미 강사</li>
                                <li>현)대한치과위생학회 회장</li>
                                <li>보아치과 OHC센터장</li>
                                <li>유튜브 MJTV 운영</li>
                                <li>분야 : 병의원컨설팅,진료프로세스구축,조직관리,
                                    <br>직원관리,계속구강관리,기구연마
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="instructor-content">
                        <div class="instructor-head">
                            <img src="{{ asset('images/desktop/instructor/instructor_2.png') }}" alt="김윤정 대표"
                                 class="instructor-photo">
                            <h2 class="instructor-name">김윤정</h2>
                        </div>
                        <div class="instructor-description">
                            <ul class="instructor-career">
                                <li>㈜브레인스펙병원교육개발원 이사</li>
                                <li>병의원 컨설팅 전문가</li>
                                <li>㈜덴티움 STAFF 강의 강사</li>
                                <li>국가공인텔레마케팅관리사</li>
                                <li>국가공인CS리더스관리사</li>
                                <li>이미지컨설팅 강사</li>
                                <li>Harrison Assessment Debrifer</li>
                                <li>Disc 전문강사</li>
                                <li>결정적 순간의 대화 강사</li>
                                <li>분야 : 병의원컨설팅,고객상담,직원관리,텔레마케팅</li>
                            </ul>
                        </div>
                    </li>
                    <li class="instructor-content">
                        <div class="instructor-head">
                            <img src="{{ asset('images/desktop/instructor/instructor_3.png') }}" alt="노강규"
                                 class="instructor-photo">
                            <h2 class="instructor-name">노강규</h2>
                        </div>
                        <div class="instructor-description">
                            <ul class="instructor-career">
                                <li>노무법인 이언 대표</li>
                                <li>공인노무사</li>
                                <li>고려대학교 법학과 졸업</li>
                                <li>고려대학교 일반대학원 노동법 석사수료</li>
                                <li>한진중공업 인력지원팀</li>
                                <li>분야 : 치과노무관리</li>
                            </ul>
                        </div>
                    </li>
                    <!--
                    <li class="instructor-content">
                        <div class="instructor-head">
                            <img src="{{ asset('images/desktop/instructor/instructor_4.png') }}" alt="정미"
                                 class="instructor-photo">
                            <h2 class="instructor-name">정미</h2>
                        </div>
                        <div class="instructor-description">
                            <ul class="instructor-career">
                                <li>㈜브레인스펙교육개발원 치과건강보험전문강사</li>
                                <li>치과건강보험연구소 대표</li>
                                <li>건강보험전문 유튜브 채널 치건연TV 운영자</li>
                                <li>아주대학교 경영대학원 병원경영MBA 수료</li>
                                <li>대한치과경영관리자협회 공인강사</li>
                                <li>서울치의학교육원 전임강사</li>
                                <li>전) 오스템임플란트 회원서비스팀 임상파트장</li>
                                <li>전) 대한치과위행사협회 건강보험특별위원회 위원</li>
                                <li>전) 대한치과위행사협회 사이버 보수교육 SME</li>
                                <li>전) 대한치과위행사협회 대외협력이사</li>
                                <li>분야 : 치과건강보험청구</li>
                            </ul>
                        </div>
                    </li>
                    -->
                    <li class="instructor-content">
                        <div class="instructor-head">
                            <img src="{{ asset('images/desktop/instructor/instructor_5.png') }}" alt="온은주"
                                 class="instructor-photo">
                            <h2 class="instructor-name">온은주</h2>
                        </div>
                        <div class="instructor-description">
                            <ul class="instructor-career">
                                <li>㈜브레인스펙병원교육개발원 전문강사</li>
                                <li>전)삼성소고운미치과 실장</li>
                                <li>CS 강사</li>
                                <li>DISC CS 강사</li>
                                <li>맥스웰리더십 강사</li>
                                <li>애니어그램 강사</li>
                                <li>경희대병원행정학 석사</li>
                                <li>분야 : 고객불만관리,조직관리,직원관리,고객관리</li>
                            </ul>
                        </div>
                    </li>
                    <li class="instructor-content">
                        <div class="instructor-head">
                            <img src="{{ asset('images/desktop/instructor/instructor_6.png') }}" alt="김보경"
                                 class="instructor-photo">
                            <h2 class="instructor-name">김보경</h2>
                        </div>
                        <div class="instructor-description">
                            <ul class="instructor-career">
                                <li>㈜브레인스펙병원교육개발원 전문강사</li>
                                <li>캐나다 온타리오주 치과위생사</li>
                                <li>서울대학교 구강병리학 석사</li>
                                <li>서울대학교 구강병리학 박사 수료</li>
                                <li>휴프리디 기구연마 강사</li>
                                <li>SDA(SWISS DENTL ACADEMY) 연수</li>
                                <li>전) 신구대학 치위생과 겸임 교수</li>
                                <li>전) 비앤에이치과 실장</li>
                                <li>전) 대한치과위생사협회 강의</li>
                                <li>전) 수산업협동조합연수원 강의</li>
                                <li>분야 : 구강병리,계속구강관리,기구연마,치과영어</li>
                            </ul>
                        </div>
                    </li>
                    <li class="instructor-content">
                        <div class="instructor-head">
                            <img src="{{ asset('images/desktop/instructor/instructor_7.png') }}" alt="박유진"
                                 class="instructor-photo">
                            <h2 class="instructor-name">박유진</h2>
                        </div>
                        <div class="instructor-description">
                            <ul class="instructor-career">
                                <li>㈜브레인스펙병원교육개발원 전문강사</li>
                                <li>오희영치과 총괄부장</li>
                                <li>임플란트 전문 치과위생사</li>
                                <li>휴프리디 기구연마 강사</li>
                                <li>SDA(SWISS DENTL ACADEMY) 연수</li>
                                <li>손해보험 FC</li>
                                <li>생명보험 FC</li>
                                <li>분야 : 고객상담,고객관리,치아사보험</li>
                            </ul>
                        </div>
                    </li>
                    <li class="instructor-content">
                        <div class="instructor-head">
                            <img src="{{ asset('images/desktop/instructor/instructor_8.png') }}" alt="박진아"
                                 class="instructor-photo">
                            <h2 class="instructor-name">박진아</h2>
                        </div>
                        <div class="instructor-description">
                            <ul class="instructor-career">
                                <li>㈜브레인스펙병원교육개발원 전문강사</li>
                                <li>월야치과 실장</li>
                                <li>임플란트 전문치과위생사과정 이수</li>
                                <li>한국병원서비스코디네이터교육 이수</li>
                                <li>대한치과보험청구교육 이수</li>
                                <li>오스템치과보험청구교육 이수</li>
                                <li>분야 : 고객상담, 직원관리, 계속구강관리</li>
                            </ul>
                        </div>
                    </li>
                    <li class="instructor-content">
                        <div class="instructor-head">

                            <img src="{{ asset('images/desktop/instructor/instructor_9.png') }}" alt="최규영"
                                 class="instructor-photo">
                            <h2 class="instructor-name">최규영</h2>
                        </div>
                        <div class="instructor-description">
                            <ul class="instructor-career">
                                <li>㈜브레인스펙병원교육개발원 전문강사</li>
                                <li>충청대학교 치위생과 겸임교수</li>
                                <li>보건학 박사</li>
                                <li>SDA(SWISS DENTAL ACADEMY) 교육수료</li>
                                <li>분야 : 치과방사선, 고객응대, 고객상담,<br>
                                    임플란트,치과방사선,조직관리
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="instructor-content">
                        <div class="instructor-head">
                            <img src="{{ asset('images/desktop/instructor/instructor_10.png') }}" alt="김수지"
                                 class="instructor-photo">
                            <h2 class="instructor-name">김수지</h2>

                        </div>
                        <div class="instructor-description">
                            <ul class="instructor-career">
                                <li>㈜브레인스펙병원교육개발원 전문강사</li>
                                <li>월야치과 팀장</li>
                                <li>SWISS DENTAL ACADEMY 일본 연수</li>
                                <li>분야 : 계속구강관리</li>
                            </ul>
                        </div>
                    </li>
                    <li class="instructor-content">
                        <div class="instructor-head">
                            <img src="{{ asset('images/desktop/instructor/instructor_11.png') }}" alt="김진"
                                 class="instructor-photo">

                            <h2 class="instructor-name">김진</h2>
                        </div>
                        <div class="instructor-description">
                            <ul class="instructor-career">
                                <li>㈜브레인스펙병원교육개발원 전문강사</li>
                                <li>전)한림성심대학교 치위생과 교수</li>
                                <li>분야 : 전문가구강관리프로그램</li>
                            </ul>
                        </div>
                    </li>
                    <li class="instructor-content">
                        <div class="instructor-head">
                            <img src="{{ asset('images/desktop/instructor/instructor_12.png') }}" alt="연태림"
                                 class="instructor-photo">

                            <h2 class="instructor-name">연태림</h2>
                        </div>
                        <div class="instructor-description">
                            <ul class="instructor-career">
                                <li>㈜브레인스펙병원교육개발원 전문강사</li>
                                <li>서울이오스치과 실장</li>
                                <li>보험청구협회 1급 자격증</li>
                                <li>분야 : 데스크업무,치과보험청구, 고객관리</li>
                            </ul>
                        </div>
                    </li>
                    <li class="instructor-content">
                        <div class="instructor-head">

                            <img src="{{ asset('images/desktop/instructor/instructor_13.png') }}" alt="강혜민"
                                 class="instructor-photo">
                            <h2 class="instructor-name">강혜민</h2>
                        </div>
                        <div class="instructor-description">
                            <ul class="instructor-career">
                                <li>㈜브레인스펙병원개발원 전문강사</li>
                                <li>수원과학대 치위생과 겸임교수</li>
                                <li>가톨릭대학교 보건학박사 수료</li>
                                <li>전)치과위생사 국가고시 실기시험 채점위원</li>
                                <li>병원코디네이터 자격시험 출제위원</li>
                                <li>강릉영동대 치위생과 겸임교수</li>
                                <li>경동대 응급구조학과 외래교수</li>
                                <li>분야 : 치아교정</li>
                            </ul>
                        </div>
                    </li>
                    <li class="instructor-content">
                        <div class="instructor-head">
                            <img src="{{ asset('images/desktop/instructor/instructor_14.png?20220106') }}" alt="변지은"
                                 class="instructor-photo">
                            <h2 class="instructor-name">변지은</h2>
                        </div>
                        <div class="instructor-description">
                            <ul class="instructor-career">
                                <li>브레인스펙 교육개발원 임상강사</li>
                                <li>서울 더좋은 치과 근무</li>
                                <li>충청대학교 치위생과 겸임교수</li>
                                <li>백석문화대학교 치위생과 시간강사</li>
                                <li>연세대학교 치의학 석사</li>
                                <li>분야 : 치과임상재료</li>
                            </ul>
                        </div>
                    </li>
                    <li class="instructor-content">
                        <div class="instructor-head">
                            <img src="{{ asset('images/desktop/instructor/instructor_15.png?20220106') }}" alt="이연아"
                                 class="instructor-photo">

                            <h2 class="instructor-name">이연아</h2>
                        </div>
                        <div class="instructor-description">
                            <ul class="instructor-career">
                                <li>㈜브레인스펙병원교육개발원 전문강사</li>
                                <li>서울이오스치과 총괄실장</li>
                                <li>분야: 치과매출분석관리, 고객상담, 데스크업무</li>
                            </ul>
                        </div>
                    </li>
                    <li class="instructor-content">
                        <div class="instructor-head">
                            <img src="{{ asset('images/desktop/instructor/instructor_16.png?20220106') }}" alt="이연아"
                                 class="instructor-photo">
                            <h2 class="instructor-name">김민정</h2>
                        </div>
                        <div class="instructor-description">
                            <ul class="instructor-career">
                                <li>연세하이디치과 실장</li>
                                <li>브레인스펙 전문강사</li>
                                <li>아바서비스커리어센터 강사</li>
                                <li>경희대학교 경영대학원 의료경영석사</li>
                                <li>전)강동대학교 겸임 교수</li>
                            </ul>
                        </div>
                    </li>
                    <li class="instructor-content">
                        <div class="instructor-head">
                            <img src="{{ asset('images/desktop/instructor/instructor_17?20220106.png') }}" alt="이연아"
                                 class="instructor-photo">
                            <h2 class="instructor-name">윤경희</h2>
                        </div>
                        <div class="instructor-description">
                            <ul class="instructor-career">
                                <li>(전)대한치과건강보험협회 공인강사</li>
                                <li>(현)브레인스펙 치과보험청구 전문강사</li>
                                <li>치과건강보험청구3급 실무이론 공동저자</li>
                                <li>대원대학교 치위생과 겸임교수</li>
                                <li>이즈치과 실장</li>
                                <li>전문분야 : 치과건강보험청구</li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </section>
    </section>
@endsection

