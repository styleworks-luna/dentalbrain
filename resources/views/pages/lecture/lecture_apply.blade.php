@extends('layouts.app')

@section('script')
    <script type="text/javascript" src="{{ asset('js/pages/lecture-apply.js') }}"></script>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ mix('css/pages/lecture/lecture-apply.css') }}">
@endsection

@section('content')
    <section class="content">
        <div class="container">
            <div class="row">
                <section class="apply-title">
                    <h1>신청하기</h1>
                    <p><em>Step 1. 신청하기</em> <em class="for-padding">&gt;</em> Step 2. 신청내역 확인</p>
                </section>
                <section class="lecture-information-wrap">
                    <img src="{{ asset('/images/dummy/test.png') }}" alt="강의 사진" class="lecture-image">
                    <div class="lecture-information">
                        <div class="lecture-sort">
                            <span class="offline">오프라인</span>
                            <p class="lecture-subject">치과위생사 &middot; 위생</p>
                        </div>
                        <h2 class="lecture-title">치과위생사를 위한 예방 및 유지관리 전문가과정 치과위생사를 위한 예방 및 유지관리 전문가과정</h2>
                        <table>
                            <tr>
                                <th>강의일시</th>
                                <td><p class="lecture-length">2019년 10월 15일 (월) 15:00 ~ 2019년 10월 20일 (토) 17:20</p></td>
                            </tr>
                            <tr>
                                <th>강의장소</th>
                                <td><p class="lecture-length">서울시 서초구 강남대로 79길 59 새로나빌딩 3층 </p></td>
                            </tr>
                        </table>
                    </div>
                </section>
                <section class="applicant-information">
                    <h3>신청자 정보 입력</h3>
                    <table>
                        <tr>
                            <th>이름</th>
                            <td>덴탈브레인</td>
                        </tr>
                        <tr>
                            <th>아이디</th>
                            <td>dentalbrain</td>
                        </tr>
                        <tr>
                            <th>이메일</th>
                            <td>
                                <input type="text">
                                @
                                <select name="" id="">
                                    <option value="">naver.com</option>
                                    <option value="">google.com</option>
                                    <option value="">daum.com</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>휴대전화</th>
                            <td><input type="text"></td>
                        </tr>
                    </table>
                </section>
            </div>
        </div>
    </section>
@endsection

