@extends('desktop.layouts.frames.basic_frame')

@section('script')
    <script type="text/javascript" src="{{ asset('js/parsley.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/pages/albatalk/albatalk-detail.js') }}"></script>
@endsection

@section('style')
    <script type="text/javascript"
            src="https://openapi.map.naver.com/openapi/v3/maps.js?ncpClientId={{ env('NAVER_CLOUD_ID') }}&submodules=geocoder"></script>
    <link rel="stylesheet" href="{{ mix('css/desktop/pages/albatalk/albatalk-detail.css') }}">
    <link rel="stylesheet" href="{{ mix('css/desktop/pages/albatalk/albatalk-common.css') }}">
@endsection

@section('content')
    @include('desktop.layouts.navigation.albatalk')
    <div class="albatalk-recruit-detail-wrap">
        @csrf
        <div class="container">
            <div class="row">
                <section class="subtitle-wrap">
                    <h1>구인정보</h1>
                    @if( $authority->isOwner() )
                        <a href="/albatalk/recruit/{{$recruit->id}}/edit">구인정보 수정하기</a>
                    @endif
                </section>

                <section class="office-information-wrap">
                    <div class="thumbnail-wrap">
                        <div class="main-img-wrap">
                            <img class="main-thumbnail thumbnail-on" src="{{ $recruit->file->url ?? '' }}"
                                 alt="치과 사진">
                        </div>
                        <div class="sub-thumbnail-wrap">
                            <div class="img-wrap">
                                @if($recruit->file1)
                                    <img class="sub-thumbnail thumbnail-on" src="{{ $recruit->file1->url }}"
                                         alt="치과 사진">
                                @else
                                    <div class="sub-thumbnail none-image">
                                        <span class="none-image-icon"></span>
                                    </div>
                                @endif
                            </div>
                            <div class="img-wrap">
                                @if($recruit->file2)
                                    <img class="sub-thumbnail thumbnail-on" src="{{ $recruit->file2->url }}"
                                         alt="치과 사진">
                                @else
                                    <div class="sub-thumbnail none-image">
                                        <span class="none-image-icon"></span>
                                    </div>
                                @endif
                            </div>
                            <div class="img-wrap">
                                @if($recruit->file3)
                                    <img class="sub-thumbnail thumbnail-on" src="{{ $recruit->file3->url }}"
                                         alt="치과 사진">
                                @else
                                    <div class="sub-thumbnail none-image">
                                        <span class="none-image-icon"></span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="office-information">
                        <div class="office-title-wrap">
                            <h2>{{$recruit->company_name}}</h2>
                            <span>모집마감일 : {{ $recruit->ended_at == null? "채용시까지" : $recruit->ended_at->format('n월 d일까지') }}</span>
                        </div>
                        <div class="office-content-wrap">
                            <table>
                                <tr>
                                    <th>대표자명</th>
                                    <td><p>{{$recruit->company_leader}}</p></td>
                                    <th>담당자명</th>
                                    <td><p>{{$recruit->name}}</p></td>
                                </tr>
                                <tr>
                                    <th>사업자등록번호</th>
                                    <td><p>{{$recruit->company_license}}</p></td>
                                    <th>담당자 전화번호</th>
                                    <td><p>{{$recruit->phone}}</p></td>
                                </tr>
                                <tr>
                                    <th>전화번호</th>
                                    <td><p>{{$recruit->company_phone}}</p></td>
                                    <th>담당자 이메일</th>
                                    <td><p>{{$recruit->email}}</p></td>
                                </tr>
                                <tr>
                                    <th>홈페이지 주소</th>
                                    <td colspan="3"><p>{{$recruit->url}}</p></td>
                                </tr>
                                <tr>
                                    <th>주소</th>
                                    <td colspan="3">
                                        <div class="address-wrap">
                                            <p>{{$recruit->address}}</p>
                                            <a href="" class="btn-map">지도보기</a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>인근 지하철역</th>
                                    <td colspan="3"><p>{{$recruit->subway}}</p></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </section>

                <section class="recruit-detail-information-wrap">
                    <div class="information-title">
                        <h2>채용 정보</h2>
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
                        </table>
                        <table>
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
                                <td><p>@foreach($applications as $application)
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
                </section>

                <section class="recruit-writing">
                    <div class="information-title">
                        <h2>상세정보</h2>
                    </div>
                    <div class="recruit-writing-content">
                        {!! $recruit->content  !!}
                    </div>
                </section>
                <section class="btn-wrap">
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
                </section>
                <section class="applied-resume-status">
                    @if($authority->isAdmin() || $authority->isOwner() || $authority->isApplied())
                        <div class="information-title">
                            <h2>이력서 접수 상태 <em>{{ $appliedResumes->count() }}</em>건</h2>
                        </div>
                    @endif
                    @if($authority->isAdmin() || $authority->isOwner())
                        <table>
                            <thead>
                            <tr>
                                <th style="width: 100px">구분</th>
                                <th style="width: 250px">이름</th>
                                <th style="width: 250px">접수일시</th>
                                <th style="width: 250px">이력서 확인</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($appliedResumes as $appliedResume)
                                <tr>
                                    <td>{{ $loop->count - $loop->index }}</td>
                                    @if($appliedResume->status == \App\Models\Resume\AppliedResume::STATUS_CANCELED)
                                        <td>
                                            <p class="cancel-status">취소자</p>
                                        </td>
                                        <td>
                                            <p class="cancel-status">{{ $appliedResume->applied_at->format('Y년 n월 j일 G:i:s') }}</p>
                                        </td>
                                        <td>
                                            <p class="status-cancel">제출취소</p>
                                            <p class="cancel-date">{{ $appliedResume->canceled_at->format('Y년 n월 j일 G:i:s') }}</p>
                                        </td>
                                    @else
                                        <td>
                                            @if($appliedResume->is_recommended)
                                                <div class="recommend-person">
                                                    <span class="badge-recommend">관리자 추천</span>
                                                    <p>{{ $appliedResume->resume->user->name }}</p>
                                                </div>
                                            @else
                                                <div>
                                                    <p>{{ $appliedResume->resume->user->name }}</p>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <p>{{ $appliedResume->applied_at->format('Y년 n월 j일 G:i:s') }}</p>
                                        </td>
                                        <td>
                                            <a href="{{ route('albatalk.recruit.pdf',[$recruit->id, $appliedResume->resume->user->id]) }}"
                                               class="btn-resume">이력서 보기</a>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                @endif
                <!--<p class="none-resume">접수 된 이력서가 없습니다.</p>-->
                </section>
                <section class="popup-area">
                    <div class="dim"></div>
                    <div class="map-popup-wrap popup-wrap">
                        <div class="popup-header">
                            <h3>지도보기</h3>
                            <a href="#" class="btn-popup-close"></a>
                        </div>

                        <input type="hidden" class="map_x" value="{{$recruit->latitude}}">
                        <input type="hidden" class="map_y" value="{{$recruit->longitude}}">
                        <div id="mapzone" class="map"></div>

                        <p class="address">{{$recruit->address}}</p>
                    </div>
                    <div class="image-popup-wrap popup-wrap">
                        <div class="popup-header">
                            <a href="#" class="btn-popup-close"></a>
                        </div>
                        <div class="img-wrap">
                            <img src="" class="popup-img" alt="구인정보 이미지">
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection

