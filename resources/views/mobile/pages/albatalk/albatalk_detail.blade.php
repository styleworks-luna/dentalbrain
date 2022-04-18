@extends('mobile.layouts.frames.except_frame')

@section('script')
    <script type="text/javascript" src="{{ asset('js/pages/albatalk/albatalk-detail.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/swiper-bundle.min.js') }}"></script>
    <script type="text/javascript"
            src="https://openapi.map.naver.com/openapi/v3/maps.js?ncpClientId={{ env('NAVER_CLOUD_ID') }}&submodules=geocoder"></script>
@endsection

@section('vue')
    <script type="text/javascript" src="{{ asset('js/app/app.js')}}"></script>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('css/swiper-bundle.css') }}">
    <link rel="stylesheet" href="{{ mix('css/mobile/pages/albatalk/albatalk-detail.css') }}">
    <link rel="stylesheet" href="{{ mix('css/mobile/pages/albatalk/albatalk-common.css') }}">
@endsection

@section('title')
    <div class="menu-btn-wrap">
        <a href="" class="menu-btn"></a>
    </div>
    <a href="" class="btn-back"></a>
    <h1>구인정보</h1>
@endsection

@section('content')
    <section class="albatalk-recruit-detail-wrap">
        <div class="m-container">
            <div class="thumbnail-wrap">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <img class="main-thumbnail thumbnail-on" src="{{ $recruit->file->url ?? '' }}"
                                 alt="치과 사진">
                        </div>
                        @if($recruit->file1)
                            <div class="swiper-slide">
                                <img class="sub-thumbnail thumbnail-on" src="{{ $recruit->file1->url }}"
                                     alt="치과 사진">
                            </div>
                        @endif
                        @if($recruit->file2)
                            <div class="swiper-slide">
                                <img class="sub-thumbnail thumbnail-on" src="{{ $recruit->file2->url }}"
                                     alt="치과 사진">
                            </div>
                        @endif
                        @if($recruit->file3)
                            <div class="swiper-slide">
                                <img class="sub-thumbnail thumbnail-on" src="{{ $recruit->file3->url }}"
                                     alt="치과 사진">
                            </div>
                        @endif
                    </div>
                    <div class="swiper-controller-wrap">
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </div>
            <section class="office-information-wrap">
                <div class="m-row">
                    <div class="office-information">
                        <p class="ended-date">
                            모집마감일 : {{ $recruit->ended_at == null? "채용시까지" : $recruit->ended_at->format('n월 d일까지') }}
                        </p>
                        <h2>{{$recruit->company_name}}</h2>
                        <div class="office-content-wrap">
                            <table>
                                <tr>
                                    <th>대표자명</th>
                                    <td><p>{{$recruit->company_leader}}</p></td>
                                </tr>
                                <tr>
                                    <th>사업자등록번호</th>
                                    <td><p>{{$recruit->company_license}}</p></td>
                                </tr>
                                <tr>
                                    <th>전화번호</th>
                                    <td><p>{{$recruit->company_phone}}</p></td>
                                </tr>
                                <tr>
                                    <th>담당자명</th>
                                    <td><p>{{$recruit->name}}</p></td>
                                </tr>
                                <tr>
                                    <th>담당자 전화번호</th>
                                    <td><p>{{$recruit->phone}}</p></td>
                                </tr>
                                <tr>
                                    <th>담당자 이메일</th>
                                    <td><p>{{$recruit->email}}</p></td>
                                </tr>
                                <tr>
                                    <th>홈페이지 주소</th>
                                    <td><p>{{$recruit->url}}</p></td>
                                </tr>
                                <tr>
                                    <th>주소</th>
                                    <td>
                                        <div class="address-wrap">
                                            <p class="address">{{$recruit->address}}</p>
                                            <a href="" class="btn-map">지도보기</a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>인근 지하철역</th>
                                    <td><p>{{$recruit->subway}}</p></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
            <section class="recruit-detail-information-wrap">
                <div class="m-row">
                    <div class="information-title">
                        <h3>채용 정보</h3>
                    </div>
                    <div class="recruit-detail-information-content">
                        <table>
                            <tr>
                                <th>신청분야</th>
                                <td><p>
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
                                <td><p>{{$recruit->typeWork->type}}</p></td>
                            </tr>
                            <tr>
                                <th>직종</th>
                                <td><p>{{$recruit->typeJob->type}}</p></td>
                            </tr>
                            <tr>
                                <th>급여</th>
                                @if($salaries[0]->type_salary_id == 4)
                                    <td><p>{{$salaries[0]->value}}</p></td>
                                @else
                                    <td><p>{{$salaries[0]->type}}</p></td>
                                @endif

                            </tr>
                            <tr>
                                <th>학력</th>
                                <td><p>{{$recruit->typeStudy->type}}</p></td>
                            </tr>
                            <tr>
                                <th>경력</th>
                                <td><p>신입</p></td>
                            </tr>
                            <tr>
                                <th>근무요일</th>
                                @if($days[0]->type_day_id == 4)
                                    <td><p>{{$days[0]->value}}</p></td>
                                @else
                                    <td><p>{{$days[0]->type}}</p></td>
                                @endif
                            </tr>
                            <tr>
                                <th>복리후생</th>
                                <td>
                                    <p>
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
                        </table>
                    </div>
                </div>
            </section>
            <section class="recruit-writing">
                <div class="m-row">
                    <div class="information-title">
                        <h3>상세정보</h3>
                    </div>
                    <div class="recruit-writing-content">
                        {!! $recruit->content  !!}
                    </div>
                </div>
            </section>
            <section class="applied-resume-status">
                <div class="m-row">
                    @if($authority->isAdmin() || $authority->isOwner() || $authority->isApplied())
                        <div class="information-title">
                            <h3>이력서 접수 상태</h3>
                            <em>{{ $appliedResumes->count() }}건</em>
                        </div>
                    @endif
                    @if($authority->isAdmin() || $authority->isOwner())
                        <ul class="resume-list">
                            @foreach($appliedResumes as $appliedResume)
                                <li>
                                    @if($appliedResume->status == \App\Models\Resume\AppliedResume::STATUS_CANCELED)
                                        <div class="resume-user-wrap">
                                            <p class="cancel-status">취소자</p>
                                            <p class="status-cancel">제출취소</p>
                                        </div>
                                        <div class="resume-date-wrap">
                                            <p class="cancel-status">{{ $appliedResume->applied_at->format('Y년 n월 j일 G:i:s') }}</p>
                                            <p class="cancel-date">{{ $appliedResume->canceled_at->format('Y년 n월 j일 G:i:s') }}</p>
                                        </div>
                                    @else
                                        <div class="resume-user-wrap">
                                            @if($appliedResume->is_recommended)
                                                <div class="recommend-person">
                                                    <p>{{ $appliedResume->resume->user->name }}</p>
                                                    <span class="badge-recommend">관리자 추천</span>
                                                </div>
                                            @else
                                                <div class="none-recommend">
                                                    <p>{{ $appliedResume->resume->user->name }}</p>
                                                </div>
                                            @endif
                                            <a href="{{ route('albatalk.recruit.pdf',[$recruit->id, $appliedResume->resume->user->id]) }}" class="btn-resume">이력서 보기</a>
                                        </div>
                                        <div class="resume-date-wrap">
                                            <p>{{ $appliedResume->applied_at->format('Y년 n월 j일 G:i:s') }}</p>
                                        </div>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @endif
                <p class="none-resume">접수 된 이력서가 없습니다.</p>
                </div>
            </section>
        </div>
        <section class="btn-wrap">
            <div class="m-row">
                <form action="{{ route('albatalk.recruit.apply',$recruit->id) }}" method="post">
                    @csrf
                    @auth
                        @if(!$authority->isOwner())
                            @if($authority->hasResume())
                                @if($authority->isApplied())
                                    <button type="submit" class="btn-cancel">제출 취소</button>
                                @else
                                    <button type="submit" class="btn-submit">이력서 제출</button>
                                @endif
                            @else
                                <button type="submit" class="btn-submit">이력서 제출</button>
                            @endif
                        @endif
                    @else
                        <button type="submit" class="btn-submit">이력서 제출</button>
                    @endauth
                </form>
            </div>
        </section>
    </section>
    <section class="popup-area">
        <div class="dim"></div>
        <div class="map-popup-wrap popup-wrap">
            <div class="popup-header">
                <h4>주소</h4>
                <a href="#" class="btn-popup-close"></a>
            </div>

            <input type="hidden" class="map_x" value="{{$recruit->latitude}}">
            <input type="hidden" class="map_y" value="{{$recruit->longitude}}">
            <div id="mapzone" class="map"></div>

            <p class="address">{{$recruit->address}}</p>
        </div>
    </section>
@endsection
