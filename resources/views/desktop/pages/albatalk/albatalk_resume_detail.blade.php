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
                            <img src="{{ $resume->file->url ?? '' }}" alt="강의 사진">
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
                            </tr>
                            @foreach($leftList as $answer)
                                <tr>
                                    <td>{{ $answer->ability->category->name }}</td>
                                    <td>{{ $answer->ability->name }}</td>
                                    <td>
                                        @switch($answer->score)
                                            @case(1) 경험없음 @break
                                            @case(2) 미흡 @break
                                            @case(3) 보통 @break
                                            @case(4) 잘함 @break
                                            @case(5) 매우잘함 @break
                                            @default 보통
                                        @endswitch
                                    </td>
                                    <td>{{ $answer->can_learn ? '●': '' }}</td>
                                </tr>
                            @endforeach
                        </table>
                        <table class="self-test">
                            <tr>
                                <th style="width: 14%">구분</th>
                                <th style="width: 16%"></th>
                                <th>자가평가 점수</th>
                                <th>교육가능 유무</th>
                            </tr>
                            @foreach($rightList as $answer)
                                <tr>
                                    <td>{{ $answer->ability->category->name }}</td>
                                    <td>{{ $answer->ability->name }}</td>
                                    <td>
                                        @switch($answer->score)
                                            @case(1) 경험없음 @break
                                            @case(2) 미흡 @break
                                            @case(3) 보통 @break
                                            @case(4) 잘함 @break
                                            @case(5) 매우잘함 @break
                                            @default 보통
                                        @endswitch
                                    </td>
                                    <td>{{ $answer->can_learn ? '●': '' }}</td>
                                </tr>
                            @endforeach
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

