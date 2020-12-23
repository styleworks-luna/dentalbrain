@extends('layouts.app')

@section('script')
@endsection

@section('style')
    <link rel="stylesheet" href="{{ mix('css/pages/lecture/lecture_detail.css') }}">
@endsection

@section('content')
    <section class="content">
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
                        <li><a href="">상세정보</a></li>
                        <li><a href="">댓글</a></li>
                    </ul>
                </div>
                <div class="lecture-detail-content">
                    <img src="{{ asset('/images/dummy/test.png') }}" alt="" class="lecture-detail-image">
                </div>
            </section>
            <section class="lecture-comment">

            </section>
            </div>
        </div>
    </section>
@endsection
