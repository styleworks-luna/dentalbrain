@extends('desktop.layouts.frames.basic_frame')

@section('script')
    <script type="text/javascript" src="{{ asset('js/parsley.min.js') }}"></script>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ mix('css/desktop/pages/albatalk/albatalk-detail.css') }}">
    <link rel="stylesheet" href="{{ mix('css/desktop/pages/albatalk/albatalk-common.css') }}">
@endsection

@section('content')
    <section class="albatalk-detail-wrap">
        @include('desktop.layouts.navigation.albatalk')
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
                                <img class="frist-detail"
                                     src="http://dbv2020.onoffmix.test/storage/program/11/thumbnail/dasd.PNG"
                                     alt="강의 사진">
                                <img class="second-detail"
                                     src="http://dbv2020.onoffmix.test/storage/program/11/thumbnail/dasd.PNG"
                                     alt="강의 사진">
                                <img class="third-detail"
                                     src="http://dbv2020.onoffmix.test/storage/program/11/thumbnail/dasd.PNG"
                                     alt="강의 사진">
                            </div>
                        </div>
                        <div class="albatalk-information">
                            <h2 class="albatalk-title">{{$recruit->company_name}}
                                <span>모집마감일 : {{$recruit->ended_at->format('n 월 d일까지')}}</span></h2>
                            <div class="albatalk-card" style="display: flex; flex-wrap: wrap;">
                                <table class="first-card">
                                    <tr>
                                        <th>대표자명</th>
                                        <td><p class="albatalk-length">{{$recruit->company_leader}}</p></td>
                                    </tr>
                                    <tr>
                                        <th>사업자등록번호</th>
                                        <td><p class="albatalk-length">{{$recruit->company_license}}</p></td>
                                    </tr>
                                    <tr>
                                        <th>전화번호</th>
                                        <td><p class="albatalk-length">{{$recruit->company_phone}}</p></td>
                                    </tr>

                                </table>
                                <table class="second-card">
                                    <tr>
                                        <th>담당자명</th>
                                        <td><p class="albatalk-length">{{$recruit->name}}</p></td>
                                    </tr>
                                    <tr>
                                        <th>담당자 전화번호</th>
                                        <td><p class="albatalk-length">{{$recruit->phone}}</p></td>
                                    </tr>
                                    <tr>
                                        <th>담당자 이메일</th>
                                        <td><p class="albatalk-length">{{$recruit->email}}</p></td>
                                    </tr>
                                </table>
                                <table class="third-card">
                                    <tr>
                                        <th>홈페이지 주소</th>
                                        <td><p class="albatalk-length">{{$recruit->url}}</p></td>
                                    </tr>
                                    <tr>
                                        <th>주소</th>
                                        <td><p class="albatalk-length">서울시 서초구 강남대로79길 59 새로나빌딩 3층</p></td>
                                    </tr>
                                    <tr>
                                        <th>인근 지하철역</th>
                                        <td><p class="albatalk-length">{{$recruit->subway}}</p></td>
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
                                    <td><p class="albatalk-length">
                                            @foreach($applications as $application)
                                                @if($loop->last)
                                                    {{$application->type}}
                                                @else
                                                    {{$application->type}},
                                                @endif
                                            @endforeach
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <th>근무형태</th>
                                    <td><p class="albatalk-length">{{$recruit->typeWork->type}}</p></td>
                                </tr>
                                <tr>
                                    <th>직종</th>
                                    <td><p class="albatalk-length">{{$recruit->typeJob->type}}</p></td>
                                </tr>
                                <tr>
                                    <th>급여</th>
                                    @if($salaries[0]->type_salary_id == 4)
                                        <td><p class="albatalk-length">{{$salaries[0]->value}}</p></td>
                                    @else
                                        <td><p class="albatalk-length">{{$salaries[0]->type}}</p></td>
                                    @endif

                                </tr>
                                <tr>
                                    <th>학력</th>
                                    <td><p class="albatalk-length">{{$recruit->typeStudy->type}}</p></td>
                                </tr>
                            </table>
                            <table style="padding-top: 18px">
                                <tr>
                                    <th>경력</th>
                                    <td><p class="albatalk-length">신입</p></td>
                                </tr>
                                <tr>
                                    <th>근무요일</th>
                                    @if($days[0]->type_day_id == 4)
                                        <td><p class="albatalk-length">{{$days[0]->value}}</p></td>
                                    @else
                                        <td><p class="albatalk-length">{{$days[0]->type}}</p></td>
                                    @endif
                                </tr>
                                <tr>
                                    <th>복리후생</th>
                                    <td><p class="albatalk-length">@foreach($applications as $application)
                                                @if($loop->last)
                                                    {{$application->type}}
                                                @else
                                                    {{$application->type}},
                                                @endif
                                            @endforeach
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="detail-title">
                            <h3>상세정보</h3>
                        </div>
                        <div class="second">
                            <div class="text">
                                {{$recruit->content}}
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

