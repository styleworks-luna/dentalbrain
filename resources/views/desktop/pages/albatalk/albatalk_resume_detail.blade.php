@extends('desktop.layouts.frames.basic_frame')

@section('script')
    <script type="text/javascript" src="{{ asset('js/parsley.min.js') }}"></script>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ mix('css/desktop/pages/albatalk/albatalk-resume-detail.css') }}">
@endsection

@section('content')
    <section class="albatalk-resume-detail-wrap">
        @include('desktop.layouts.albatalk')
        <div class="container">
            <form>
                <div class="row">
                    <section class="title">
                        <h1>이력서 정보</h1>
                    </section>

                    <section class="resume-information-wrap">
                        <div class="resume-image">
                            <img src="http://dbv2020.onoffmix.test/storage/program/11/thumbnail/dasd.PNG" alt="강의 사진">
                        </div>
                        <div class="resume-information">
                            <h2 class="resume-title">{{ $resume->name }}</h2>
                            <div class="resume-card" style="display: flex">
                                <table class="first-card">
                                    <tr>
                                        <th>영문 이름</th>
                                        <td><p class="resume-length">{{ $resume->english_name }}</p></td>
                                    </tr>
                                    <tr>
                                        <th>생년 월일</th>
                                        <td><p class="resume-length">1900년 01월 01일</p></td>
                                    </tr>
                                    <tr>
                                        <th>휴대폰 번호</th>
                                        <td><p class="resume-length">{{ $resume->phone }}</p></td>
                                    </tr>
                                    <tr>
                                        <th>비상연락처</th>
                                        <td><p class="resume-length">{{ $resume->emergency_phone }}</p></td>
                                    </tr>
                                    <tr>
                                        <th>주소</th>
                                        <td><p class="resume-length">{{ $resume->address }}</p></td>
                                    </tr>

                                </table>
                                <table class="second-card">
                                    <tr>
                                        <th>희망 근무 지역</th>
                                        <td><p class="resume-length">{{ $resume->work_area }}</p></td>
                                    </tr>
                                    <tr>
                                        <th>희망 근무 요일</th>
                                        <td><p class="resume-length">{{ $resume->work_day }}</p></td>
                                    </tr>
                                    <tr>
                                        <th>희망 근무 시간</th>
                                        <td><p class="resume-length">{{ $resume->work_time }}</p></td>
                                    </tr>
                                </table>
                            </div>

                        </div>
                    </section>

                    <section class="detail-information">
                        <div class="detail-title">
                            <h3>학력 사항 및 희망순위</h3>
                        </div>
                        <div style="display: flex">
                            <table style="padding-top: 20px">
                                <tr>
                                    <th>학위취득년월</th>
                                    <td><p class="resume-length">{{ $resume->graduated_at }}</p></td>
                                </tr>
                                <tr>
                                    <th>출신학교</th>
                                    <td><p class="resume-length">{{ $resume->school }}</p></td>
                                </tr>
                                <tr>
                                    <th>학과(세부전공)</th>
                                    <td><p class="resume-length">{{ $resume->major }}</p></td>
                                </tr>
                                <tr>
                                    <th>학위</th>
                                    <td><p class="resume-length">{{ $resume->degree }}</p></td>
                                </tr>
                                <tr>
                                    <th>졸업구분</th>
                                    <td><p class="resume-length">{{ $resume->graduation_type }}</p></td>
                                </tr>
                            </table>
                            <table style="padding-top: 20px">
                                <tr>
                                    <th>희망 진료과</th>
                                    <td>
                                        <p class="resume-length">
                                            @if($resume->treatment_1) {{ '1순위 ' . $resume->treatment_1 }} @endif
                                            @if($resume->treatment_2) {{ ' | 2순위 ' . $resume->treatment_2 }} @endif
                                            @if($resume->treatment_3) {{ ' | 3순위 ' . $resume->treatment_3 }} @endif
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <th>희망 부서</th>
                                    <td>
                                        <p class="resume-length">
                                            @if($resume->department_1) {{ '1순위 ' . $resume->department_1 }} @endif
                                            @if($resume->department_2) {{ ' | 2순위 ' . $resume->department_2 }} @endif
                                            @if($resume->department_3) {{ ' | 3순위 ' . $resume->department_3 }} @endif
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="detail-title">
                            <h3>자기소개</h3>
                        </div>
                        <div class="second">
                            <div class="text">
                                {{ $resume->about_me }}
                            </div>
                        </div>

                        <div class="detail-title">
                            <h3>면허/자격증 보유 현황</h3>
                        </div>
                        <table class="certificate">
                            <tr>
                                <th style="width: 15%">구분</th>
                                <th>자격증명</th>
                                <th>취득년월</th>
                                <th>인가, 관리기관</th>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>{{ $resume->certificate_name_1 }}</td>
                                <td>{{ $resume->certificate_day_1 }}</td>
                                <td>{{ $resume->certificate_agency_1 }}</td>
                            </tr>
                            <tr>

                                <td>2</td>
                                <td>{{ $resume->certificate_name_2 }}</td>
                                <td>{{ $resume->certificate_day_2 }}</td>
                                <td>{{ $resume->certificate_agency_2 }}</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>{{ $resume->certificate_name_3 }}</td>
                                <td>{{ $resume->certificate_day_3 }}</td>
                                <td>{{ $resume->certificate_agency_3 }}</td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>{{ $resume->certificate_name_4 }}</td>
                                <td>{{ $resume->certificate_day_4 }}</td>
                                <td>{{ $resume->certificate_agency_4 }}</td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>{{ $resume->certificate_name_5 }}</td>
                                <td>{{ $resume->certificate_day_5 }}</td>
                                <td>{{ $resume->certificate_agency_5 }}</td>
                            </tr>
                        </table>

                        <div class="detail-title">
                            <h3>치과 업무 능력 자기 평가표</h3>
                        </div>
                        <table class="self-test">
                            <tr>
                                <th style="width: 14%">구분</th>
                                <th style="width: 16%"></th>
                                <th>자가평가 점수</th>
                                <th>교육가능 유무</th>
                                <th style="width: 14%">구분</th>
                                <th style="width: 16%"></th>
                                <th>자가평가 점수</th>
                                <th>교육가능 유무</th>
                            </tr>
                            <tr>
                                <td>임플란트</td>
                                <td>구치부싱글크라운 임시치아</td>
                                <td>매우잘함</td>
                                <td>●</td>
                                <td>보존</td>
                                <td>러버댐장착</td>
                                <td>매우잘함</td>
                                <td>●</td>
                            </tr>
                            <tr>
                                <td>임플란트</td>
                                <td>임플란트 인상채득</td>
                                <td>매우잘함</td>
                                <td>●</td>
                                <td>보존</td>
                                <td>인레이셋팅</td>
                                <td>매우잘함</td>
                                <td>●</td>
                            </tr>
                            <tr>
                                <td>임플란트</td>
                                <td>임플란트 셋팅</td>
                                <td>매우잘함</td>
                                <td>●</td>
                                <td>임플란트</td>
                                <td>전치부레진필링</td>
                                <td>매우잘함</td>
                                <td>●</td>
                            </tr>
                            <tr>
                                <td>임플란트</td>
                                <td>사용했던 임플란트 종류</td>
                                <td></td>
                                <td></td>
                                <td>보존</td>
                                <td>구치부 레진 필링</td>
                                <td>매우잘함</td>
                                <td>●</td>
                            </tr>
                            <tr>
                                <td>보철</td>
                                <td>어시스트</td>
                                <td>매우잘함</td>
                                <td>●</td>
                                <td>보존</td>
                                <td>CA 레진 필링</td>
                                <td>매우잘함</td>
                                <td>●</td>
                            </tr>
                            <tr>
                                <td>보철</td>
                                <td>구치부싱글크라운 인상채득</td>
                                <td>매우잘함</td>
                                <td>●</td>
                                <td>보존</td>
                                <td>base 도포</td>
                                <td>매우잘함</td>
                                <td>●</td>
                            </tr>
                            <tr>
                                <td>보철</td>
                                <td>구치부싱글크라운 임시치아</td>
                                <td>매우잘함</td>
                                <td>●</td>
                                <td>보존</td>
                                <td>실란트</td>
                                <td>매우잘함</td>
                                <td>●</td>
                            </tr>
                            <tr>
                                <td>보철</td>
                                <td>전치부싱글크라운 인상채득</td>
                                <td>매우잘함</td>
                                <td>●</td>
                                <td>보존</td>
                                <td>불소도포</td>
                                <td>매우잘함</td>
                                <td>●</td>
                            </tr>
                            <tr>
                                <td>보철</td>
                                <td>전치부싱글크라운 임시치아</td>
                                <td>매우잘함</td>
                                <td>●</td>
                                <td>보존</td>
                                <td>PA촬영(구내엑스레이촬영)</td>
                                <td>매우잘함</td>
                                <td>●</td>
                            </tr>
                            <tr>
                                <td>보철</td>
                                <td>구치부브릿지 인상채득</td>
                                <td>매우잘함</td>
                                <td>●</td>
                                <td>보존</td>
                                <td>pano촬영</td>
                                <td>매우잘함</td>
                                <td>●</td>
                            </tr>
                            <tr>
                                <td>보철</td>
                                <td>구치부브릿지 임시치아</td>
                                <td>매우잘함</td>
                                <td>●</td>
                                <td>교정</td>
                                <td>Ceph촬영</td>
                                <td>매우잘함</td>
                                <td>●</td>
                            </tr>
                            <tr>
                                <td>보철</td>
                                <td>전치부브릿지 인상채득</td>
                                <td>매우잘함</td>
                                <td>●</td>
                                <td>교정</td>
                                <td>교정환자 cleasing</td>
                                <td>매우잘함</td>
                                <td>●</td>
                            </tr>
                            <tr>
                                <td>보철</td>
                                <td>전치부브릿지 임시치아</td>
                                <td>매우잘함</td>
                                <td>●</td>
                                <td>교정</td>
                                <td>와이어 넣기</td>
                                <td>매우잘함</td>
                                <td>●</td>
                            </tr>
                            <tr>
                                <td>보철</td>
                                <td>싱글크라운셋팅</td>
                                <td>매우잘함</td>
                                <td>●</td>
                                <td>교정</td>
                                <td>와이어 결찰</td>
                                <td>매우잘함</td>
                                <td>●</td>
                            </tr>
                            <tr>
                                <td>보철</td>
                                <td>싱글크라운(여러개) 셋팅</td>
                                <td>매우잘함</td>
                                <td>●</td>
                                <td>교정</td>
                                <td>진단 모델 인상채득</td>
                                <td>매우잘함</td>
                                <td>●</td>
                            </tr>
                            <tr>
                                <td>보철</td>
                                <td>브릿지셋팅</td>
                                <td>매우잘함</td>
                                <td>●</td>
                                <td>교정</td>
                                <td>마운팅</td>
                                <td>매우잘함</td>
                                <td>●</td>
                            </tr>
                            <tr>
                                <td>보철</td>
                                <td>resin core</td>
                                <td>매우잘함</td>
                                <td>●</td>
                                <td>교정</td>
                                <td>E/O촬영</td>
                                <td>매우잘함</td>
                                <td>●</td>
                            </tr>
                            <tr>
                                <td>치주</td>
                                <td>스켈링</td>
                                <td>매우잘함</td>
                                <td>●</td>
                                <td>교정</td>
                                <td>I/O촬영</td>
                                <td>매우잘함</td>
                                <td>●</td>
                            </tr>
                            <tr>
                                <td>치주</td>
                                <td>Curette</td>
                                <td>매우잘함</td>
                                <td>●</td>
                                <td>교정</td>
                                <td>석고 붓기</td>
                                <td>매우잘함</td>
                                <td>●</td>
                            </tr>
                            <tr>
                                <td>미백</td>
                                <td>전문가미백</td>
                                <td>매우잘함</td>
                                <td>●</td>
                                <td>상담</td>
                                <td>임플란트 상담</td>
                                <td>매우잘함</td>
                                <td>●</td>
                            </tr>
                            <tr>
                                <td>미백</td>
                                <td>Curette</td>
                                <td>매우잘함</td>
                                <td>●</td>
                                <td>상담</td>
                                <td>보철 상담</td>
                                <td>매우잘함</td>
                                <td>●</td>
                            </tr>
                            <tr>
                                <td>보험청구</td>
                                <td>교정과 보험청구</td>
                                <td>매우잘함</td>
                                <td>●</td>
                                <td>상담</td>
                                <td>덴쳐상담</td>
                                <td>매우잘함</td>
                                <td>●</td>
                            </tr>
                            <tr>
                                <td>보험청구</td>
                                <td>교정외 보험청구</td>
                                <td>매우잘함</td>
                                <td>●</td>
                                <td>상담</td>
                                <td>교정상담</td>
                                <td>매우잘함</td>
                                <td>●</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>병원 OPEN</td>
                                <td>open&setting</td>
                                <td>매우잘함</td>
                                <td>●</td>
                            </tr>
                        </table>
                    </section>
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

