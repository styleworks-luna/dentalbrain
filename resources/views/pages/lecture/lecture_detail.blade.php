@extends('layouts.app')

@section('script')
@endsection

@section('style')
    <link rel="stylesheet" href="{{ mix('css/pages/lecture/lecture_detail.css') }}">
@endsection

@section('content')
    <section id="content" class="content">
        <div class="container">
            <div class="row">
            <section class="lecture-information">
                <img src="{{ asset('/images/dummy/test.png') }}" alt="" class="lecture-image">
                <div class="lecture-apply-form">
                    <div class="lecture-sort">
                        <span class="onoffline">온라인</span>
                        <p class="lecture-subject">치과 위생사 &middot; 위생</p>
                    </div>
                    <h2 class="lecture-title">치과위생사를 위한 예방 및 유지관리 전문가과정</h2>
                    <div class="lecture-information-text">
                        <table>
                            <tr>
                                <th>강의시간</th>
                                <td><p class="lecture-length">총 10강</p>・<p class="lecture-time">총 2시간 50분</p></td>
                            </tr>
                            <tr>
                                <th>옵션선택</th>
                                <td>
                                <select name="" id="" class="lecture-select-box">
                                    <option value="">3개월 수강권</option>
                                    <option value="">6개월 수강권</option>
                                    <option value="">9개월 수강권</option>
                                </select>
                                </td>
                            </tr>
                            <tr>
                                <th>결제금액</th>
                                <td class="lecture-price">500,000원</td>
                            </tr>
                        </table>
                    </div>
                    <div class="lecture-btn">
                        <a href="" class="apply-btn">신청하기</a>
                        <a href="" class="like">2355</a>
                    </div>
                </div>
            </section>
            <section class="lecture-detail">
                <div class="lecture-detail-menu">
                    <ul>
                        <li><a href="#content" class="active">상세정보</a></li>
                        <li><a href="#comment">댓글</a></li>
                    </ul>
                </div>
                <div class="lecture-detail-content">
                    <img src="{{ asset('/images/dummy/test.png') }}" alt="" class="lecture-detail-image">
                </div>
            </section>
            <section id="comment" class="lecture-comment">
                <div class="comment-title">
                    <h3>댓글</h3>
                    <p class="comment-length">(250)</p>
                </div>
                <form action="" class="comment-input-form">
                    <textarea name="" placeholder="댓글을 입력하세요." class="comment-input-text"></textarea>
                    <input type="submit" value="등록" class="comment-input-btn">
                </form>
                <ul class="comment-list">
                    <li class="comment-total-area">
                        <div class="comment-area">
                            <div class="profile-img">
                                <img src="{{ asset('/images/global/profile_default.png') }}" alt="profile image">
                            </div>
                            <div class="write-info">
                                <span class="write-name">홍길동</span>
                                <span class="date">2020-11-17 17:56:47</span>
                                <p class="comment-text">모임에 필요한 자료는 어떻게 다운받을 수 있을까요?</p>
                                <a href="#" class="btn-comment-write active">댓글달기</a>
                            </div>
                            <div class="comment-btn-area">
                                <form action="">
                                    <button type="submit" class="btn-comment-modified">수정</button>
                                    <button type="submit" class="btn-comment-delete">삭제</button>
                                </form>
                            </div>
                        </div>
                        <div class="child-comment-area">
                            <form action="" class="comment-input-form">
                                <textarea name="" placeholder="댓글을 입력하세요." class="comment-input-text"></textarea>
                                <input type="submit" value="등록" class="comment-input-btn">
                            </form>
                            <ul class="child-comment-list">
                                <li class="child-comment-item">
                                    <div class="comment-area">
                                        <div class="profile-img">
                                            <img src="{{ asset('/images/global/profile_default.png') }}" alt="profile image">
                                        </div>
                                        <div class="write-info">
                                            <span class="write-name">홍길동</span>
                                            <span class="date">2020-11-17 17:56:47</span>
                                            <p class="comment-text">모임에 필요한 자료는 어떻게 다운받을 수 있을까요?</p>
                                        </div>
                                        <div class="comment-btn-area">
                                            <form action="">
                                                <button type="submit" class="btn-comment-modified">수정</button>
                                                <button type="submit" class="btn-comment-delete">삭제</button>
                                            </form>
                                        </div>
                                    </div>
                                </li>
                                <li class="child-comment-item">
                                    <div class="comment-area">
                                        <div class="profile-img">
                                            <img src="{{ asset('/images/global/profile_default.png') }}" alt="profile image">
                                        </div>
                                        <div class="write-info">
                                            <span class="write-name">홍길동</span>
                                            <span class="date">2020-11-17 17:56:47</span>
                                            <p class="comment-text">모임에 필요한 자료는 어떻게 다운받을 수 있을까요?</p>
                                        </div>
                                        <div class="comment-btn-area">
                                            <form action="">
                                                <button type="submit" class="btn-comment-modified">수정</button>
                                                <button type="submit" class="btn-comment-delete">삭제</button>
                                            </form>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="comment-total-area">
                        <div class="comment-area">
                            <div class="profile-img">
                                <img src="{{ asset('/images/global/profile_default.png') }}" alt="profile image">
                            </div>
                            <div class="write-info">
                                <span class="write-name">홍길동</span>
                                <span class="date">2020-11-17 17:56:47</span>
                                <p class="comment-text">모임에 필요한 자료는 어떻게 다운받을 수 있을까요?</p>
                                <a href="#" class="btn-comment-write active">댓글달기</a>
                            </div>
                            <div class="comment-btn-area">
                                <form action="">
                                    <button type="submit" class="btn-comment-modified">수정</button>
                                    <button type="submit" class="btn-comment-delete">삭제</button>
                                </form>
                            </div>
                        </div>
                        <div class="child-comment-area">
                            <form action="" class="comment-input-form">
                                <textarea name="" placeholder="댓글을 입력하세요." class="comment-input-text"></textarea>
                                <input type="submit" value="등록" class="comment-input-btn">
                            </form>
                            <ul class="child-comment-list">
                                <li class="child-comment-item">
                                    <div class="comment-area">
                                        <div class="profile-img">
                                            <img src="{{ asset('/images/global/profile_default.png') }}" alt="profile image">
                                        </div>
                                        <div class="write-info">
                                            <span class="write-name">홍길동</span>
                                            <span class="date">2020-11-17 17:56:47</span>
                                            <p class="comment-text">모임에 필요한 자료는 어떻게 다운받을 수 있을까요?</p>
                                        </div>
                                        <div class="comment-btn-area">
                                            <form action="">
                                                <button type="submit" class="btn-comment-modified">수정</button>
                                                <button type="submit" class="btn-comment-delete">삭제</button>
                                            </form>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </section>
            </div>
        </div>
    </section>
@endsection
