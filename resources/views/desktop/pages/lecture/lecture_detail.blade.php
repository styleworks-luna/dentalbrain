@extends('desktop.layouts.frames.basic_frame')

@section('script')
<script type="text/javascript"
        src="https://openapi.map.naver.com/openapi/v3/maps.js?ncpClientId={{ env('NAVER_CLOUD_ID') }}&submodules=geocoder"></script>
<script type="text/javascript" src="{{ asset('js/pages/lecture/lecture-detail.js') }}"></script>
@endsection

@section('style')
<link rel="stylesheet" href="{{ mix('css/desktop/pages/lecture/lecture-detail.css') }}">
@endsection

@section('content')

<section id="content" class="content">
    <div class="container">
        <div class="row">
            <section class="lecture-information-wrap">
                <input type="hidden" id="program_is_online" value="{{$program->is_open}}">
                <div class="lecture-test">
                    <img src="{{ $program->thumbnail->url }}" alt="강의 사진" class="lecture-image">
                    @auth()
                        @if(auth()->user()->isAdmin())
                        <div class="admin-menu">
                            <ul>
                                @if($program->is_online == true)
                                <li><a href="/admin/lecture/online/{{$program->id}}/1">수정</a></li>
                                    @if($program->is_open == true)
                                    <li><a href="" class="open">공개</a></li>
                                    @else
                                    <li><a href="" class="open">비공개</a></li>
                                    @endif
                                <li><a href="/admin/lecture/online/{{$program->id}}/duplicate/1">복사</a></li>
                                <li><a href="/admin/lecture/online/{{$program->id}}/student">수강현황</a></li>

                                @else
                                <li><a href="/admin/lecture/offline/{{$program->id}}/1">수정</a></li>
                                    @if($program->is_open == true)
                                    <li><a href="" class="open">공개</a></li>
                                    @else
                                    <li><a href="" class="open">비공개</a></li>
                                    @endif
                                <li><a href="/admin/lecture/offline/{{$program->id}}/duplicate/1">복사</a></li>
                                <li><a href="/admin/lecture/offline/{{$program->id}}/student">수강현황</a></li>
                                @endif
                            </ul>
                        </div>
                        @endif
                    @endauth
                </div>
                <div class="lecture-information">
                    <div class="lecture-sort">
                        <span class="lecture-type">{{$program->minor_category_name}}</span>

                        <p class="lecture-date">수강기간 10일</p>
                    </div>
                    <h2 class="lecture-title">{{ $program->title }}</h2>
                    <div class="lecture-information-text">
                        <table>
                            @if($program->is_online == true)
                            <tr>
                                <th>강의시간</th>
                                <td><p class="lecture-length">{{ $program->running_time }}</p></td>
                            </tr>
                            @else
                            <tr>
                                <th>강의일시</th>
                                <td>
                                    <p class="lecture-length">
                                        {{ carbonDate($program->place->started_at, 'Y년 MMMM Do (ddd) HH:mm ') }}
                                        ~ {{ carbonDate($program->place->ended_at, 'Y년 MMMM Do (ddd) HH:mm ') }}</p>
                                </td>
                            </tr>
                            <tr>
                                <th>강의장소</th>
                                <td>
                                    <p class="lecture-place">{{ $program->place->address}}
                                        @isset($program->place->address_detail){{' , '.$program->place->address_detail
                                        }}@endisset</p>
                                    <a href="" class="btn-map">지도보기</a>
                                </td>
                            </tr>
                            @endif
                            <tr>
                                <th>강의정보</th>
                                <td>
                                    <select name="ticket" id="ticket" class="lecture-select-box">
                                        @if ($program->canRepeat($student) || $program->repeated($student))
                                        <option value="{{$program->id}}"
                                                data-price="{{ $program->repeat_price }}">{{ $program->description }}
                                        </option>
                                        @else
                                        <option value="{{$program->id}}"
                                                data-price="{{ $program->price }}">{{ $program->description }}
                                        </option>
                                        @endif
                                    </select>
                                </td>
                            </tr>
                            @guest
                            {{--비로그인 사용자--}}
                            <tr>
                                <th>결제금액</th>
                                <td class="lecture-price"
                                    data-price="{{ $program->price }}">
                                    {{ $program->is_free ? '무료' : number_format($program->price).'원'}}
                                </td>
                            </tr>
                            <tr>
                                <th>유료회원가</th>
                                <td class="lecture-price" data-price="{{ $program->membership_price }}">
                                    {{ $program->membership_is_free ? '무료' : number_format($program->membership_price).'원'
                                    }}
                                </td>
                            </tr>
                            @else
                            {{--로그인 사용자--}}
                            @if (auth()->user()->hasMembership)
                            {{--유료회원인 경우--}}
                            <tr>
                                <th class="exclude-price">결제금액</th>
                                <td class="lecture-price lecture-exclude-price"
                                    data-price="{{ $program->price }}">
                                    {{ $program->is_free ? '무료' : number_format($program->price).'원' }}
                                </td>
                            </tr>
                            @if ($program->repeatable($student))
                            {{--유료회원 + 재수강--}}
                            <tr>
                                <th>유료회원가</th>
                                <td class="lecture-price"
                                    data-price="{{ $student->getPrice() }}">
                                    {{ $program->membership_is_free ? '무료' : '재수강 할인가 '.number_format($student->getPrice()).'원'
                                    }}
                                </td>
                            </tr>
                            @else
                            {{--유료회원--}}
                            <tr>
                                <th>유료회원가</th>
                                <td class="lecture-price" data-price="{{ $program->membership_price }}">
                                    {{ $program->membership_is_free ? '무료' : number_format($program->membership_price).'원'
                                    }}
                                </td>
                            </tr>
                            @endif
                            @else
                            {{--유료회원이 아닐 경우--}}
                            @if ($program->repeatable($student))
                            {{--재수강--}}
                            <tr>
                                <th class="exclude-price">결제금액</th>
                                <td class="lecture-price lecture-exclude-price"
                                    data-price="{{ $program->repeat_price }}">
                                    {{ $program->is_free ? '무료' : '재수강 할인가 '.number_format($program->repeat_price).'원'}}
                                </td>
                            </tr>
                            <tr>
                                <th>유료회원가</th>
                                <td class="lecture-price" data-price="{{ $student->getPrice() }}">
                                    {{ $program->membership_is_free ? '무료' : '재수강 할인가 '.number_format($student->getPrice()).'원'
                                    }}
                                </td>
                            </tr>
                            @else
                            {{--재수강 아닌 경우--}}
                            <tr>
                                <th>결제금액</th>
                                <td class="lecture-price"
                                    data-price="{{ $program->price }}">
                                    <div style="display: flex; align-items: center">
                                        @if($program->discount_rate != 0)
                                        <span class="lecture-ogprice">{{ number_format($program->price).'원' }}</span><span
                                            style="color: black; font-weight: normal"> →</span>
                                        <span>{{ $program->is_free ? '무료' : number_format($program->discounted_price).'원'}}</span>
                                        <span class="lecture-sale">{{ $program->discount_rate }}% 할인</span>
                                        @else
                                        <span>{{ $program->is_free ? '무료' : number_format($program->price).'원'}}</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>유료회원가</th>
                                <td class="lecture-price" data-price="{{ $program->membership_price }}">
                                    {{ $program->membership_is_free ? '무료' : number_format($program->membership_price).'원'
                                    }}
                                </td>
                            </tr>
                            @endif
                            @endif
                            @endguest
                        </table>
                    </div>
                    <div class="lecture-btn">
                        <input type="hidden" name="lecture-idx" class="lecture-idx" value="{{ $program->id }}">
                        @if($program->waitDeposit($student) || $program->waitConfirmAnotherPay($student))
                        {{--특수상황--}}
                        <div class="btn-wrap">
                                    <span class="btn-apply-complete">
                                        입금 대기중
                                    </span>
                            <a href="{{ route('account.lectures.edit',$program->id) }}" class="edit">
                                신청내역 수정
                            </a>
                        </div>
                        @elseif ($program->alreadyApplied($student))
                        {{--이미 신청한 경우--}}
                        <div class="btn-wrap">
                            @if($program->is_online && $program->alreadyPaid($student))
                            {{--온라인 && 결제 완료됨(= 시청 가능 상태)--}}
                            <a href="{{route('lectures.watch',[$program->id])}}" class="apply-btn">
                                강의 시청하기
                            </a>
                            @else
                            {{--오프라인 || 결제 미완료됨--}}
                            <span class="btn-apply-complete">
                                            신청한 강의입니다
                                        </span>
                            @endif
                            <a href="{{ route('account.lectures.edit',$program->id) }}" class="edit">
                                신청내역 수정
                            </a>
                        </div>
                        @else
                        @if($program->is_online)
                        {{--온라인일 경우--}}
                        @if ($program->canRepeat($student))
                        {{--재수강 가능할 경우(Paid, expired_at > now)--}}
                        <div class="btn-wrap">
                            <a href="{{ route('lectures.apply',$program->id) }}" class="apply-btn">
                                재수강 신청하기
                            </a>
                        </div>
                        @else
                        {{--일반적 상황--}}
                        <div class="btn-wrap">
                            <a href="{{ route('lectures.apply',$program->id) }}" class="apply-btn">
                                신청하기
                            </a>
                        </div>
                        @endif
                        @else
                        {{--오프라인일 경우--}}
                        @if($program->ended_at > now())
                        {{--오프라인 강의 종료--}}
                        <div class="btn-wrap">
                                            <span class="btn-apply-complete">
                                                이미 종료된 강의 입니다
                                            </span>
                        </div>
                        @elseif($program->place->receipt_ended_at < now())
                        {{--오프라인 강의 신청 마감--}}
                        <div class="btn-wrap">
                                            <span class="btn-apply-complete">
                                                신청기간이 지난 강의 입니다
                                            </span>
                        </div>
                        @elseif($program->place->receipt_started_at > now())
                        {{--오프라인 강의 신청 마감--}}
                        <div class="btn-wrap">
                                            <span class="btn-apply-complete">
                                                신청기간이 아닌 강의 입니다
                                            </span>
                        </div>
                        @elseif ($program->exceedCapacity())
                        {{--강의 정원을 넘길 경우--}}
                        <div class="btn-wrap">
                                            <span class="btn-apply-complete">
                                                모집정원이 마감되었습니다.
                                            </span>
                        </div>
                        @else
                        {{--일반적 상황--}}
                        <div class="btn-wrap">
                            <a href="{{ route('lectures.apply',$program->id) }}" class="apply-btn">
                                신청하기
                            </a>
                        </div>
                        @endif {{--오프라인 상황 구분--}}
                        @endif {{--온 / 오프라인 구분--}}
                        @endif {{--신청자 구분--}}
                        <a href=""
                           class="like {{ !$program->auth_like ?: 'active' }}">{{ $program->user_like_cnt }}
                        </a>
                    </div>
                </div>
            </section>

            <section class="lecture-detail">
                <div class="lecture-detail-menu">
                    <ul>
                        <li><a href="#content" class="menu-tab-detail active">상세정보</a></li>
                        <li><a href="#list" class="menu-tab-list">강의목록</a></li>
                        <li><a href="#comment" class="menu-tab-comment">댓글</a></li>
                    </ul>
                </div>
                <div class="lecture-detail-content">
                    <div class="fr-element fr-view">
                        {!! $program->content !!}
                    </div>
                </div>
            </section>

            <section id="list" class="lecture-list">
                <div class="list-title">
                    <h3>강의목록</h3>
                </div>
                <ul>
                    <li><a>1강</a>치과치료</li>
                    <li><a>2강</a>치과치료</li>
                    <li><a>3강</a>치과치료</li>
                </ul>
            </section>

            <section id="comment" class="lecture-comment">
                <input type="hidden" id="program_id" value="{{ $program->id }}">
                <div class="comment-title">
                    <h3>댓글</h3>
                    <p class="comment-length"></p>
                </div>
                <form action="{{ route('api.lectures.comments.store',$program->id) }}" class="comment-input-form">
                    @csrf
                    <textarea name="content" placeholder="댓글을 입력하세요."
                              class="comment-input-text comment-submit-content"></textarea>
                    <input type="button" value="등록" class="comment-input-btn comment-submit">
                </form>
                <ul class="comment-list">
                    @forelse($comments as $comment)
                    <li class="comment-total-area">
                        <div class="comment-area">
                            <div class="profile-img">
                                <img src="{{ asset('/images/desktop/global/profile_default.png') }}"
                                     alt="profile image">
                            </div>
                            <div class="modify-input">
                                <form action="{{ route('api.lectures.comments.store',$program->id) }}"
                                      class="comment-input-form">
                                    @csrf
                                    <textarea name="content" placeholder="댓글을 입력하세요."
                                              class="comment-input-text comment-submit-content">{{ $comment->content }}</textarea>
                                    <input type="button" value="등록"
                                           class="comment-input-btn comment-modify-submit">
                                </form>
                            </div>
                            <div class="write-info">
                                <span class="write-name">{{ $comment->user->name }}</span>
                                <span class="date">{{ $comment->created_at }}</span>
                            </div>
                            <div class="comment-btn-area">
                                <form action="">
                                    <input type="hidden" name="comment_id" class="comment_id"
                                           value="{{ $comment->id }}">
                                    @can('update',$comment)
                                    <button type="button" class="btn-comment-modified comment-modify">수정
                                    </button>
                                    @endcan
                                    @can('delete',$comment)
                                    <button type="button" class="btn-comment-delete comment-delete">삭제
                                    </button>
                                    @endcan
                                </form>
                            </div>
                        </div>
                        <div class="write-content">
                            <p class="comment-text">{{ $comment->content }}</p>
                            <a href="#" class="btn-comment-write">댓글달기</a>
                        </div>
                        <div class="child-comment-area">
                            <form action="{{ route('api.lectures.comments.store',$program->id) }}"
                                  class="comment-input-form hide">
                                @csrf
                                <input type="hidden" name="parent_id" class="parent_id"
                                       value="{{ $comment->id }}">
                                <textarea name="content" placeholder="댓글을 입력하세요."
                                          class="comment-input-text comment-child-submit-content"></textarea>
                                <input type="button" value="등록" class="comment-input-btn comment-child-submit">
                            </form>
                            <ul class="child-comment-list">
                                @foreach($comment->children as $child)
                                <li class="child-comment-item">
                                    <div class="comment-area">
                                        <div class="profile-img">
                                            <img
                                                src="{{ asset('/images/desktop/global/profile_default.png') }}"
                                                alt="profile image">
                                        </div>
                                        <div class="modify-input">
                                            <form
                                                action="{{ route('api.lectures.comments.store',$program->id) }}"
                                                class="comment-input-form comment-modify-form">
                                                @csrf
                                                <textarea name="content" placeholder="댓글을 입력하세요."
                                                          class="comment-input-text comment-child-modify-content">{{ $child->content }}</textarea>
                                                <input type="button" value="등록"
                                                       class="comment-input-btn comment-child-modify-submit">
                                            </form>
                                        </div>
                                        <div class="write-info">
                                            <span class="write-name">{{ $child->user->name }}</span>
                                            <span class="date">{{ $child->created_at }}</span>
                                        </div>
                                        <div class="comment-btn-area">
                                            <form action="">
                                                <input type="hidden" name="comment_id" class="comment_id"
                                                       value="{{ $child->id }}">
                                                @can('update',$child)
                                                <button type="button"
                                                        class="btn-comment-modified comment-modify">수정
                                                </button>
                                                @endcan
                                                @can('delete',$child)
                                                <button type="button"
                                                        class="btn-comment-delete comment-child-delete">
                                                    삭제
                                                </button>
                                                @endcan
                                            </form>
                                        </div>
                                    </div>
                                    <div class="write-content">
                                        <p class="comment-text">{{ $child->content }}</p>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </li>
                    @empty
                    <p>댓글이 없습니다.</p>
                    @endforelse
                </ul>
            </section>
        </div>

        @if($program->is_online == false)
        <section class="popup-area">
            <div class="dim"></div>
            <div class="popup-wrap">
                <div class="popup-header">
                    <h3>강의 장소</h3>
                    <a href="#" class="btn-popup-close"></a>
                </div>

                <input type="hidden" class="map_x" value="{{ $program->place->longitude }}">
                <input type="hidden" class="map_y" value="{{ $program->place->latitude }}">
                <div id="mapzone" class="map"></div>

                <p class="lecture-length">{{ $program->place->address.' , '.$program->place->address_detail }}</p>
            </div>
        </section>
        @endif

    </div>
</section>
@endsection
