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
                    <img src="{{ $program->thumbnail->url }}" alt="" class="lecture-image">
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
                                            <p class="lecture-place">{{ $program->place->address.' , '.$program->place->address_detail }}</p>
                                            <a href="" class="btn-map">지도보기</a>
                                        </td>
                                    </tr>
                                @endif
                                <tr>
                                    <th>옵션선택</th>
                                    <td>
                                        <select name="ticket" id="ticket" class="lecture-select-box">
                                            @foreach($program->tickets as $ticket)
                                                <option value="{{$ticket->id}}"
                                                        data-price="{{ $ticket->price }}">{{ $ticket->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>결제금액</th>
                                    @foreach($program->tickets as $ticket)
                                        <td class="lecture-price price-hidden"
                                            data-price="{{ $ticket->price }}">{{ $ticket->price == 0 ? '무료' : $ticket->price.'원'}}
                                        </td>
                                    @endforeach
                                </tr>
                            </table>
                        </div>
                        <div class="lecture-btn">
                            <input type="hidden" name="lecture-idx" class="lecture-idx" value="{{ $program->id }}">
                            <a href="{{ route('lectures.apply',$program->id) }}" class="apply-btn">신청하기</a>
                            <a href=""
                               class="like {{ !$program->auth_like ?: 'active' }}">{{ $program->user_like_cnt }}</a>
                        </div>
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
                        {!! $program->content !!}
                    </div>
                </section>

                <section id="comment" class="lecture-comment">
                    <div class="comment-title">
                        <h3>댓글</h3>
                        <p class="comment-length"></p>
                    </div>
                    <form action="{{ route('lectures.comments.store',$program->id) }}" class="comment-input-form">
                        <textarea name="content" placeholder="댓글을 입력하세요." class="comment-input-text"></textarea>
                        <input type="submit" value="등록" class="comment-input-btn">
                    </form>
                    <ul class="comment-list">
                        @forelse($comments as $comment)
                            <li class="comment-total-area">
                                <div class="comment-area">
                                    <div class="profile-img">
                                        <img src="{{ asset('/images/desktop/global/profile_default.png') }}"
                                             alt="profile image">
                                    </div>
                                    <div class="write-info">
                                        <span class="write-name">{{ $comment->user->name }}</span>
                                        <span class="date">{{ $comment->created_at }}</span>
                                        <p class="comment-text">{{ $comment->content }}</p>
                                        <a href="#" class="btn-comment-write">댓글달기</a>
                                    </div>
                                    <div class="comment-btn-area">
                                        <form action="">
                                            @can('update',$comment)
                                                <button type="submit" class="btn-comment-modified">수정</button>
                                            @endcan
                                            @can('delete',$comment)
                                                <button type="submit" class="btn-comment-delete">삭제</button>
                                            @endcan
                                        </form>
                                    </div>
                                </div>
                                <div class="child-comment-area">
                                    <form action="{{ route('lectures.comments.store',$program->id) }}"
                                          class="comment-input-form hide">
                                        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                        <textarea name="content" placeholder="댓글을 입력하세요."
                                                  class="comment-input-text"></textarea>
                                        <input type="submit" value="등록" class="comment-input-btn">
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
                                                    <div class="write-info">
                                                        <span class="write-name">{{ $child->user->name }}</span>
                                                        <span class="date">{{ $child->created_at }}</span>
                                                        <p class="comment-text">{{ $child->content }}</p>
                                                    </div>
                                                    <div class="comment-btn-area">
                                                        <form action="">
                                                            <button type="submit" class="btn-comment-modified">수정
                                                            </button>
                                                            <button type="submit" class="btn-comment-delete">삭제
                                                            </button>
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
