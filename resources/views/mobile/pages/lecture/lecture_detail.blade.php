@extends('mobile.layouts.frames.except_frame')

@section('script')
    <script type="text/javascript"
            src="https://openapi.map.naver.com/openapi/v3/maps.js?ncpClientId={{ env('NAVER_CLOUD_ID') }}&submodules=geocoder"></script>
    <script type="text/javascript" src="{{ asset('js/pages/lecture/lecture-detail.js') }}"></script>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ mix('css/mobile/pages/lecture/lecture-detail.css') }}">
@endsection

@section('title')
    <a href="" class="btn-back"></a>
    <h1>강의상세</h1>
@endsection

@section('content')

    <section id="content" class="content">
        <div class="m-container">

            <section class="lecture-information-wrap">
                <img src="{{ $program->thumbnail->url }}" alt="강의 사진" class="lecture-image">
                <div class="lecture-information">
                    <div class="m-row">
                        <div class="lecture-sort">
                            <span class="lecture-type">{{$program->minor_category_name}}</span>

                            <p class="lecture-date">수강기간 10일</p>
                        </div>
                        <h2 class="lecture-title">{{ $program->title }}</h2>
                        <div class="lecture-information-text">
                            <ul>
                                @if($program->is_online == true)
                                    <li>
                                        <p class="lecture-length">{{ $program->running_time }}</p>
                                    </li>
                                @else
                                    <li>
                                        <p class="lecture-length">{{ carbonDate($program->place->started_at,'Y년 MMMM Do (ddd) HH:mm ') }}
                                            ~ {{ carbonDate($program->place->ended_at,'Y년 MMMM Do (ddd) HH:mm ') }}</p>
                                    </li>
                                    <li class="lecture-place-wrap">
                                        <p class="lecture-place">{{ $program->place->address}}  @isset($program->place->address_detail){{' , '.$program->place->address_detail }}@endisset</p>
                                        <a href="" class="btn-map">지도보기</a>
                                    </li>
                                @endif
                                <li>
                                    <p class="lecture-description">{{ $program->description }}</p>
                                </li>
                                <li class="lecture-price-wrap">
                                    @guest
                                        {{-- 비로그인 사용자 --}}
                                        @if($program->discount_rate != 0)
                                        <div class="price-individual">
                                            <span>결제금액</span>
                                            <p class="lecture-price"
                                               data-price="{{ $program->price }}">
                                                {{ $program->is_free ? '무료' : number_format($program->discounted_price).'원'}}
                                            </p>
                                            <p style="color: black; font-weight: normal">&nbsp;→&nbsp;</p>
                                            <p class="lecture-ogprice">{{ $program->is_free ? '무료' : number_format($program->price).'원'}}</p>
                                        </div>
                                        <p class="lecture-sale">{{ $program->discount_rate }}% 할인</p>
                                        @else
                                        <div class="price-individual">
                                            <span>결제금액</span>
                                            <p class="lecture-price"
                                               data-price="{{ $program->price }}">
                                                {{ $program->is_free ? '무료' : number_format($program->price).'원'}}
                                            </p>
                                        </div>
                                        @endif
                                        <div class="price-individual">
                                            <span>유료회원가</span>
                                            <p class="lecture-price" data-price="{{ $program->membership_price }}">
                                                {{ $program->membership_is_free ? '무료' :number_format($program->membership_price).'원' }}
                                            </p>
                                        </div>
                                    @else
                                        {{-- 로그인 사용자 --}}
                                        @if (auth()->user()->hasMembership)
                                            {{-- 유료회원인 경우 --}}
                                            @if($program->discount_rate != 0)
                                            <div class="price-individual">
                                                <span>결제금액</span>
                                                <p class="lecture-price"
                                                   data-price="{{ $program->price }}">
                                                    {{ $program->is_free ? '무료' : number_format($program->discounted_price).'원'}}
                                                </p>
                                                <p style="color: black; font-weight: normal">&nbsp;→&nbsp;</p>
                                                <p class="lecture-ogprice">{{ $program->is_free ? '무료' : number_format($program->price).'원'}}</p>
                                            </div>
                                            <p class="lecture-sale">{{ $program->discount_rate }}% 할인</p>
                                            @else
                                            <div class="price-individual">
                                                <span>결제금액</span>
                                                <p class="lecture-price"
                                                   data-price="{{ $program->price }}">
                                                    {{ $program->is_free ? '무료' : number_format($program->price).'원'}}
                                                </p>
                                            </div>
                                            @endif
                                            @if ($program->repeatable($student))
                                                {{-- 유료회원 + 재수강 --}}
                                                <div class="price-individual">
                                                    <span>유료회원가</span>
                                                    <p class="lecture-price"
                                                       data-price="{{ $student->getPrice() }}">
                                                        {{ $program->membership_is_free ? '무료' : '재수강 할인가 ' . number_format($student->getPrice()) }}
                                                    </p>
                                                </div>
                                            @else
                                                {{-- 유료회원 --}}
                                                <div class="price-individual">
                                                    <span>유료회원가</span>
                                                    <p class="lecture-price"
                                                       data-price="{{ $program->membership_price }}">
                                                        {{ $program->membership_is_free ? '무료' :number_format($program->membership_price).'원' }}
                                                    </p>
                                                </div>
                                            @endif
                                        @else
                                            {{-- 유료회원이 아닐 경우 --}}
                                            @if ($program->repeatable($student))
                                                {{--재수강--}}
                                                <div class="price-individual">
                                                    <span class="exclude-price">결제금액</span>
                                                    <p class="lecture-price lecture-exclude-price"
                                                       data-price="{{ $program->repeat_price }}">
                                                        {{ $program->is_free ? '무료' : '재수강 할인가 ' . number_format($program->repeat_price).'원'}}
                                                    </p>
                                                </div>
                                                <div class="price-individual">
                                                    <span>유료회원가</span>
                                                    <p class="lecture-price" data-price="{{ $student->getPrice() }}">
                                                        {{ $program->membership_is_free ? '무료' :'재수강 할인가 ' . number_format($student->getPrice()).'원' }}
                                                    </p>
                                                </div>
                                            @else
                                                {{--재수강 아닌 경우--}}
                                                @if($program->discount_rate != 0)
                                                <div class="price-individual">
                                                    <span>결제금액</span>
                                                    <p class="lecture-price"
                                                       data-price="{{ $program->price }}">
                                                        {{ $program->is_free ? '무료' : number_format($program->discounted_price).'원'}}
                                                    </p>
                                                    <p style="color: black; font-weight: normal">&nbsp;→&nbsp;</p>
                                                    <p class="lecture-ogprice">{{ $program->is_free ? '무료' : number_format($program->price).'원'}}</p>
                                                </div>
                                                <p class="lecture-sale">{{ $program->discount_rate }}% 할인</p>
                                                @else
                                                <div class="price-individual">
                                                    <span>결제금액</span>
                                                    <p class="lecture-price"
                                                       data-price="{{ $program->price }}">
                                                        {{ $program->is_free ? '무료' : number_format($program->price).'원'}}
                                                    </p>
                                                </div>
                                                @endif
                                                <div class="price-individual">
                                                    <span>유료회원가</span>
                                                    <p class="lecture-price"
                                                       data-price="{{ $program->membership_price }}">
                                                        {{ $program->membership_is_free ? '무료' : number_format($program->membership_price).'원' }}
                                                    </p>
                                                </div>
                                            @endif
                                        @endif
                                    @endguest
                                </li>
                            </ul>
                        </div>
                        <div class="lecture-btn">
                            <input type="hidden" name="lecture-idx" class="lecture-idx" value="{{ $program->id }}">
                            <a href=""
                               class="like {{ !$program->auth_like ?: 'active' }}">{{ $program->user_like_cnt }}
                            </a>
                            @if($program->waitDeposit($student) || $program->waitConfirmAnotherPay($student))
                                <div class="btn-wrap">
                                    <span class="btn-apply-complete">
                                        입금대기
                                    </span>
                                    <a href="{{ route('account.lectures.edit',$program->id) }}" class="edit">
                                        신청내역 수정
                                    </a>
                                </div>
                            @elseif ($program->alreadyApplied($student))
                                {{--이미 신청한 경우--}}
                                <div class="btn-wrap">
                                    @if($program->is_online && $program->alreadyPaid($student))
                                        {{--온라인 && 결제 완료됨 (= 시청 가능 상태)--}}
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
                                        {{--재수강 가능할 경우 (Paid, expired_at > now)--}}
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
                                @endif {{--온/오프라인 구분--}}
                            @endif {{--신청자 구분--}}

                        </div>
                    </div>
                </div>
            </section>

            <section class="lecture-detail">
                <div class="m-row">
                    <div class="lecture-detail-menu">
                        <ul>
                            <li><a href="#content" class="m-menu-tab-detail active">상세정보</a></li>
                            <li><a href="#list" class="m-menu-tab-list">강의목록</a></li>
                            <li><a href="#comment" class="m-menu-tab-comment">댓글</a></li>
                        </ul>
                    </div>
                    <div class="lecture-detail-content">
                        <div class="fr-element fr-view">
                            {!! $program->content !!}
                        </div>
                    </div>
                </div>
            </section>

            <sectrion id="list" class="lecture-list">
                <ul>
                    <li class="a"><a>1강</a>임플란트</li>
                    <li class="a"><a>1강</a>임플란트</li>
                    <li class="a"><a>1강</a>임플란트</li>
                </ul>
            </sectrion>


            <section id="comment" class="lecture-comment">
                <div class="m-row">
                    <input type="hidden" id="program_id" value="{{ $program->id }}">
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
                            <p class="list-none">댓글이 없습니다.</p>
                        @endforelse
                    </ul>
                </div>
            </section>

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
