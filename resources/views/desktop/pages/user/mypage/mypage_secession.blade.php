@extends('desktop.layouts.frames.basic_frame')

@section('script')
    <script type="text/javascript" src="{{ asset('js/pages/user/mypage-secession.js') }}"></script>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ mix('css/desktop/pages/user/mypage-secession.css') }}">
@endsection

@section('content')
    <section class="content">
        <div class="container">
            @include('desktop.layouts.navigation.account')
            <form action="" id="form-secession">
                <section class="secession">
                    <h2>회원탈퇴</h2>
                    <table>
                        <tr>
                            <th>탈퇴사유</th>
                            <td class="wrap">
                                <div class="radio-wrap">
                                    <input type="radio"
                                           id="secession-radio-01"
                                           name="secession-radio"
                                           class="secession-radio">
                                    <label for="secession-radio-01">다른 이메일을 사용하기 위해</label>
                                </div>
                                <div class="radio-wrap">
                                    <input type="radio"
                                           id="secession-radio-02"
                                           name="secession-radio"
                                           class="secession-radio">
                                    <label for="secession-radio-02">사용빈도가 낮고, 개인정보 유출이 우려되어서</label>
                                </div>
                                <div class="radio-wrap">
                                    <input type="radio"
                                           id="secession-radio-03"
                                           name="secession-radio"
                                           class="secession-radio">
                                    <label for="secession-radio-03">사이트 이용시 장애가 있어서</label>
                                </div>
                                <div class="radio-wrap">
                                    <input type="radio"
                                           id="secession-radio-04"
                                           name="secession-radio"
                                           class="secession-radio">
                                    <label for="secession-radio-04">서비스의 질에 대한 불만이 있어서</label>
                                </div>
                                <div class="radio-wrap">
                                    <input type="radio"
                                           id="secession-radio-05"
                                           name="secession-radio"
                                           class="secession-radio">
                                    <label for="secession-radio-05">사이트 이용시 고객응대가 나빠서</label>
                                </div>
                                <div class="radio-wrap">
                                    <input type="radio"
                                           id="secession-radio-06"
                                           name="secession-radio"
                                           class="secession-radio">
                                    <label for="secession-radio-06">기타</label>

                                    <input type="text"
                                           id="secession-reason"
                                           class="secession-reason"
                                           placeholder="사유를 입력해주세요">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>탈퇴 아이디</th>
                            <td>
                                <span class="id">dentalbrain</span>
                            </td>
                        </tr>
                        <tr>
                            <th>비밀번호 입력</th>
                            <td>
                                <div class="input-wrap">
                                    <input type="password"
                                           id="password"
                                           class="password"
                                           placeholder="본인인증을 위해 비밀번호를 입력해주세요.">
                                </div>
                                <div class="tips">
                                    <p>※ 시청중인 강의가 있을경우, 환불되지 않습니다.</p>
                                    <p>※ 신청 한 강의는 전부 취소 처리 됩니다.</p>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <div class="btn-wrap">
                        <button class="btn-cancel btn-common">취소하기</button>
                        <button class="btn-secession btn-common" form="form-secession">회원탈퇴</button>
                    </div>
                </section>
            </form>
        </div>
    </section>
@endsection
