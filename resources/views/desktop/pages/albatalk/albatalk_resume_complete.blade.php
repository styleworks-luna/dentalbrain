@extends('desktop.layouts.frames.basic_frame')

@section('script')
    <script type="text/javascript" src="{{ asset('js/parsley.min.js') }}"></script>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ mix('css/desktop/pages/albatalk/albatalk-resume-detail.css') }}">
    <link rel="stylesheet" href="{{ mix('css/desktop/pages/albatalk/albatalk-common.css') }}">
@endsection

@section('content')
    @include('desktop.layouts.navigation.albatalk')
    <section class="albatalk-resume-detail-wrap">
        <div class="container">
            <div class="row">
                <section class="detail-title">
                    <h1>이력서 정보</h1>
                </section>

                <section class="user-information-wrap">
                    <div class="user-image-wrap">
                        <img src="{{ $resume->file->url ?? '' }}" class="user-image" alt="강의 사진">
                    </div>
                    <div class="user-personal-information">
                        <h2 class="user-name">{{ $resume->name }}</h2>
                        <table>
                            <tr>
                                <th>영문 이름</th>
                                <td><p>{{ $resume->english_name }}</p></td>
                            </tr>
                            <tr>
                                <th>생년 월일</th>
                                <td><p>{{ $resume->birthday }}</p></td>
                            </tr>
                            <tr>
                                <th>휴대폰 번호</th>
                                <td><p>{{ $resume->phone }}</p></td>
                            </tr>
                            <tr>
                                <th>비상연락처</th>
                                <td><p>{{ $resume->emergency_phone }}</p></td>
                            </tr>
                            <tr>
                                <th>이메일</th>
                                <td><p>{{ $resume->email }}</p></td>
                            </tr>
                            <tr>
                                <th>주소</th>
                                <td><p>{{ $resume->address }}</p></td>
                            </tr>
                        </table>
                    </div>
                    <div class="user-hope-information">
                        <table>
                            <tr>
                                <th>희망 근무 지역</th>
                                <td><p>{{ $resume->work_area }}</p></td>
                            </tr>
                            <tr>
                                <th>희망 근무 요일</th>
                                <td><p>{{ $resume->work_day }}</p></td>
                            </tr>
                            <tr>
                                <th>희망 근무 시간</th>
                                <td><p>{{ $resume->work_time }}</p></td>
                            </tr>
                        </table>
                    </div>
                </section>

                <section class="study-information-wrap">
                    <div class="information-title">
                        <h2>학력 사항 및 희망순위</h2>
                    </div>
                    <div class="study-information-content">
                        <table>
                            <tr>
                                <th>학위취득년월</th>
                                <td><p>{{ $resume->graduated_at }}</p></td>
                            </tr>
                            <tr>
                                <th>출신학교</th>
                                <td><p>{{ $resume->school }}</p></td>
                            </tr>
                            <tr>
                                <th>학과(세부전공)</th>
                                <td><p>{{ $resume->major }}</p></td>
                            </tr>
                            <tr>
                                <th>학위</th>
                                <td><p>{{ $resume->degree }}</p></td>
                            </tr>
                            <tr>
                                <th>졸업구분</th>
                                <td><p>{{ $resume->graduation_type }}</p></td>
                            </tr>
                        </table>
                        <table>
                            <tr>
                                <th>희망 진료과</th>
                                <td>
                                    <div class="ranking-wrap">
                                        @if($resume->treatment_1)
                                            <p>{{ '1순위 ' . $resume->treatment_1 }}</p>
                                        @endif
                                        @if($resume->treatment_2)
                                            <p>{{ '2순위 ' . $resume->treatment_2 }}</p>
                                        @endif
                                        @if($resume->treatment_3)
                                            <p>{{ '3순위 ' . $resume->treatment_3 }}</p>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>희망 부서</th>
                                <td>
                                    <div class="ranking-wrap">
                                        @if($resume->department_1) <p>{{ '1순위 ' . $resume->department_1 }}</p> @endif
                                        @if($resume->department_2) <p>{{ '2순위 ' . $resume->department_2 }}</p> @endif
                                        @if($resume->department_3) <p>{{ '3순위 ' . $resume->department_3 }}</p> @endif
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </section>

                <section class="self-information-wrap">
                    <div class="information-title">
                        <h2>자기소개</h2>
                    </div>
                    <div class="self-information-content">
                        <p class="self-information-text">
                            {{ $resume->about_me }}
                        </p>
                    </div>
                </section>

                <section class="certification-information-wrap">
                    <div class="information-title">
                        <h2>면허/자격증 보유 현황</h2>
                    </div>
                    <div class="certification-information-content">
                        <table class="certificate">
                            <thead>
                            <tr>
                                <th>구분</th>
                                <th>자격증명</th>
                                <th>취득년월</th>
                                <th>인가, 관리기관</th>
                            </tr>
                            </thead>
                            <tbody>
                            <!-- TODO::resume 없는 경우 table 삭제 필요 -->
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
                            </tbody>
                        </table>
                    </div>
                </section>

                <section class="ability-information-wrap">
                    <div class="information-title">
                        <h2>치과 업무 능력 자기 평가표</h2>
                    </div>
                    <div class="ability-information-content">
                        <table>
                            <thead>
                            <tr>
                                <th>구분</th>
                                <th></th>
                                <th>자가평가 점수</th>
                                <th>교육가능 유무</th>
                            </tr>
                            </thead>
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
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </table>
                        <table>
                            <thead>
                            <tr>
                                <th>구분</th>
                                <th></th>
                                <th>자가평가 점수</th>
                                <th>교육가능 유무</th>
                            </tr>
                            </thead>
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
                    </div>
                </section>

                <div class="btn-wrap">
                    <a href="" class="btn-go-edit">이력서 수정</a>
                </div>

            </div>
        </div>
    </section>
@endsection

