@extends('desktop.layouts.frames.basic_frame')

@section('script')
    <script type="text/javascript" src="{{ asset('js/parsley.min.js') }}"></script>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ mix('css/desktop/pages/albatalk/albatalk-detail.css') }}">
@endsection

@section('content')
    <section class="albatalk-detail-wrap">
        <div class="title-wrap">
            <div class="container">
                <a>이력서 등록</a>
                <a>구인등록</a>
                <a>헤드헌팅</a>
            </div>
        </div>
        <div class="container">
            <form id="albatalk-detail-form">
                <div class="row">
                    @csrf
                    <section class="albatalk-detail-title">
                        <h1>구인정보</h1>
                        <a href="http://dbv2020.onoffmix.test/albatalk/detail">구인정보 수정하기</a>
                    </section>

                    <section class="albatalk-information-wrap">
                        <div class="albatalk-image">
                            <img src="http://dbv2020.onoffmix.test/storage/program/11/thumbnail/dasd.PNG" alt="강의 사진">
                            <div style="display: flex">
                                <img class="frist-detail"src="http://dbv2020.onoffmix.test/storage/program/11/thumbnail/dasd.PNG" alt="강의 사진">
                                <img class="second-detail"src="http://dbv2020.onoffmix.test/storage/program/11/thumbnail/dasd.PNG" alt="강의 사진">
                                <img class="third-detail"src="http://dbv2020.onoffmix.test/storage/program/11/thumbnail/dasd.PNG" alt="강의 사진">
                            </div>
                        </div>
                        <div class="albatalk-information">
                            <h2 class="albatalk-title">서초 온오프믹스 치과</h2>
                            <div class="albatalk-card" style="display: flex; flex-wrap: wrap;">
                                <table class="first-card">
                                    <tr>
                                        <th>대표자명</th>
                                        <td><p class="albatalk-length">홍길동</p></td>
                                    </tr>
                                    <tr>
                                        <th>사업자등록번호</th>
                                        <td><p class="albatalk-length">123-123-12345</p></td>
                                    </tr>
                                    <tr>
                                        <th>전화번호</th>
                                        <td><p class="albatalk-length">02-123-12345</p></td>
                                    </tr>

                                </table>
                                <table class="second-card">
                                    <tr>
                                        <th>담당자명</th>
                                        <td><p class="albatalk-length">홍길순</p></td>
                                    </tr>
                                    <tr>
                                        <th>담당자 전화번호</th>
                                        <td><p class="albatalk-length">123-123-12345</p></td>
                                    </tr>
                                    <tr>
                                        <th>담당자 이메일</th>
                                        <td><p class="albatalk-length">hongildong@test.com</p></td>
                                    </tr>
                                </table>
                                <table class="third-card">
                                    <tr>
                                        <th>홈페이지 주소</th>
                                        <td><p class="albatalk-length">http://dbv2020.onoffmix.test</p></td>
                                    </tr>
                                    <tr>
                                        <th>주소</th>
                                        <td><p class="albatalk-length">서울시 서초구 강남대로79길 59 새로나빌딩 3층</p></td>
                                    </tr>
                                    <tr>
                                        <th>인근 지하철역</th>
                                        <td><p class="albatalk-length">7호선 논현역 1번 출구 도보 5분</p></td>
                                    </tr>
                                </table>
                            </div>

                        </div>
                    </section>

                    <section class="detail-information">
                        <div class="detail-title">
                            <h3>채용 정보</h3>
                        </div>
                        <div style="display: flex">
                            <table style="padding-top: 18px">
                                <tr>
                                    <th>신청분야</th>
                                    <td><p class="albatalk-length">진료전반, 상담/데스크, 교정, 보철, 예방</p></td>
                                </tr>
                                <tr>
                                    <th>근무형태</th>
                                    <td><p class="albatalk-length">정규직</p></td>
                                </tr>
                                <tr>
                                    <th>직종</th>
                                    <td><p class="albatalk-length">치과위생사</p></td>
                                </tr>
                                <tr>
                                    <th>급여</th>
                                    <td><p class="albatalk-length">협의 후 결정</p></td>
                                </tr>
                                <tr>
                                    <th>학력</th>
                                    <td><p class="albatalk-length">대학교 졸업(학사)</p></td>
                                </tr>
                            </table>
                            <table style="padding-top: 18px">
                                <tr>
                                    <th>경력</th>
                                    <td><p class="albatalk-length">신입</p></td>
                                </tr>
                                <tr>
                                    <th>근무요일</th>
                                    <td><p class="albatalk-length">월~금(주5일)</p></td>
                                </tr>
                                <tr>
                                    <th>복리후생</th>
                                    <td><p class="albatalk-length">점심식자 제공, 유니폼, 주차, 자기계발비, 연월차지원, 휴가비지원, 4대보험지원, 연봉제, 인센티브제, 퇴직금 지원, 야근수당지원</p></td>
                                </tr>
                            </table>
                        </div>
                        <div class="detail-title">
                            <h3>상세정보</h3>
                        </div>
                        <div class="second">
                            <div class="text">
                                안녕하세요 덴탈브레인 치과에서 사람을 구하고 있습니다. 많은 지원 부탁드립니다. 감사합니다.
                                안녕하세요 덴탈브레인 치과에서 사람을 구하고 있습니다. 많은 지원 부탁드립니다. 감사합니다.
                                안녕하세요 덴탈브레인 치과에서 사람을 구하고 있습니다. 많은 지원 부탁드립니다. 감사합니다.
                                안녕하세요 덴탈브레인 치과에서 사람을 구하고 있습니다. 많은 지원 부탁드립니다. 감사합니다.
                                안녕하세요 덴탈브레인 치과에서 사람을 구하고 있습니다. 많은 지원 부탁드립니다. 감사합니다.
                                안녕하세요 덴탈브레인 치과에서 사람을 구하고 있습니다. 많은 지원 부탁드립니다. 감사합니다.
                            </div>
                        </div>
                    </section>

                    <button type="submit" class="submit">이력서 제출</button>

                </div>
            </form>
            <div class="dim"></div>
            <div class="popup-control">
                @include('desktop.component.popup.agreement.privacy_to_third')
                @include('desktop.component.popup.agreement.refund')
            </div>
        </div>
    </section>
@endsection

