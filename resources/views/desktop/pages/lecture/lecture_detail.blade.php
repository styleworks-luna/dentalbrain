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
                    <img src="{{ $program->thumbnail->url }}" alt="강의 사진" class="lecture-image">
                    <div class="lecture-information">
                        <div class="lecture-sort">
                            @if($program->is_online == true)
                                <span class="online">온라인</span>
                            @else
                                <span class="offline">오프라인</span>
                            @endif

                            <p class="lecture-subject">
                                {{ $program->major_category_name }} &middot; {{ $program->minor_category_name}}</p>
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
                                            <p class="lecture-length">{{ carbonDate($program->place->started_at,'Y년 MMMM Do (ddd) HH:mm ') }}
                                                ~ {{ carbonDate($program->place->ended_at,'Y년 MMMM Do (ddd) HH:mm ') }}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>강의장소</th>
                                        <td>
                                            <p class="lecture-place">{{ $program->place->address}}  @isset($program->place->address_detail){{' , '.$program->place->address_detail }}@endisset</p>
                                            <a href="" class="btn-map">지도보기</a>
                                        </td>
                                    </tr>
                                @endif
                                <tr>
                                    <th>강의정보</th>
                                    <td>
                                        <select name="ticket" id="ticket" class="lecture-select-box">
                                            @foreach($program->tickets as $ticket)
                                                @if ($program->canRepeat() || $program->repeated())
                                                <option value="{{$ticket->id}}"
                                                        data-price="{{ $ticket->repeat_price }}">{{ $ticket->name }}</option>
                                                @else
                                                    <option value="{{$ticket->id}}"
                                                            data-price="{{ $ticket->price }}">{{ $ticket->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>결제금액</th>
                                    @foreach($program->tickets as $ticket)
                                        @if ($program->canRepeat() || $program->repeated())
                                            <td class="lecture-price"
                                                data-price="{{ $ticket->repeat_price }}">{{ $ticket->is_free ? '무료' : '재수강 할인가: ' . number_format($ticket->repeat_price).'원'}}
                                            </td>
                                        @else
                                            <td class="lecture-price"
                                                data-price="{{ $ticket->price }}">{{ $ticket->is_free ? '무료' : number_format($ticket->price).'원'}}
                                            </td>
                                        @endif
                                    @endforeach
                                </tr>
                            </table>
                        </div>
                        <div class="lecture-btn">
                            <input type="hidden" name="lecture-idx" class="lecture-idx" value="{{ $program->id }}">
                            @if ($program->alreadyApplied())
                                {{--이미 신청한 경우--}}
                                <div class="btn-wrap">
                                    @if($program->is_online && $program->alreadyPaid())
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
                                    <a href="{{ route('lectures.apply',$program->id) }}" class="edit">
                                        신청내역 확인
                                    </a>
                                </div>
                            @else
                                @if($program->is_online)
                                    {{--온라인일 경우--}}
                                    @if ($program->canRepeat())
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
                            <a href=""
                               class="like {{ !$program->auth_like ?: 'active' }}">{{ $program->user_like_cnt }}
                            </a>
                        </div>
                </section>

                <section class="lecture-detail">
                    <div class="lecture-detail-menu">
                        <ul>
                            <li><a href="#content" class="menu-tab-detail active">상세정보</a></li>
                            <li><a href="#comment" class="menu-tab-comment">댓글</a></li>
                        </ul>
                    </div>
                    <div class="lecture-detail-content">
                        <div class="fr-element fr-view">
                            {!! $program->content !!}
                        </div>
                    </div>
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
                                        <p class="comment-text">{{ $comment->content }}</p>
                                        <a href="#" class="btn-comment-write">댓글달기</a>
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
                                                        <p class="comment-text">{{ $child->content }}</p>
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
