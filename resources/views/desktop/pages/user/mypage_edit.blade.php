@extends('desktop.layouts.app')

@section('script')
    <script type="text/javascript" src="{{ asset('js/jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.ui.emailbox.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/parsley.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/pages/mypage-edit.js') }}"></script>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ mix('css/desktop/pages/user/mypage-edit.css') }}">
@endsection

@section('content')
    <section class="content">
        <div class="container">
            @include('desktop.layouts.navigation.account')
            <form action="" id="edit-from">
            <section class="edit">
                <h2>회원정보 수정</h2>
                <table>
                    <tr>
                        <th><h3>이름</h3></th>
                        <td>
                            <p>홍길동</p>
                        </td>
                    </tr>
                    <tr>
                        <th class="th-center"><h3>아이디</h3></th>
                        <td>
                            <p>dentalbrain</p>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="email">이메일</label></th>
                        <td>
                            <input type="email"
                                   name="email"
                                   id="email"
                                   class="email_box"
                                   data-parsley-required="true"
                                   data-parsley-type="email"
                                   data-parsley-required-message="※ 이메일 주소를 입력해주세요."
                                   data-parsley-errors-container=".email-error-wrap">
                            <button class="btn-basic btn-email-change">변경</button>
                            <div class="email-error-wrap error-wrap-common"></div>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="job">직업군</label></th>
                        <td>
                            <select name="job" id="job" class="select-menu">
                                <option value="1">치과의사</option>
                                <option value="2">치과위생사</option>
                                <option value="3">치과조무사</option>
                                <option value="4">코디네이터</option>
                                <option value="5">학생</option>
                                <option value="6">기타</option>
                            </select>
                            <input type="text" placeholder="면허번호를 입력해주세요."
                                   id='license_num'
                                   name='license_num'
                                   data-parsley-required="true"
                                   data-parsley-required-message="※ 면허번호를 입력해주세요."
                                   data-parsley-errors-container=".license-error-wrap">
                            <div class="license-error-wrap error-wrap-common"></div>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="phone">휴대전화</label></th>
                        <td>
                            <input type="text"
                                   id="phone"
                                   name="phone"
                                   class="phone"
                                   placeholder="'-' 없이 입력해주세요."
                                   data-parsley-required="true"
                                   data-parsley-required-message="※ 휴대전화 번호를 입력해주세요."
                                   data-parsley-errors-container=".phone-check-error-wrap">
                            <button class="btn-basic btn-verification">인증번호발송</button>
                            <div class="phone-check-error-wrap error-wrap-common"></div>

                            <input type="text"
                                   id="verification_number"
                                   name="verification_number"
                                   class="verification-number"
                                   placeholder="인증번호 6자리를 입력"
                                   data-parsley-required="true"
                                   data-parsley-required-message="※ 일치하지 않습니다."
                                   data-parsley-errors-container=".verification-check-error-wrap">
                            <button class="btn-basic btn-verification mt-10">인증번호확인</button>
                            <div class="verification-check-error-wrap error-wrap-common"></div>

                        </td>
                    </tr>
                    <tr>
                        <th><label for="upw">비밀번호 변경</label></th>
                        <td>
                            <input type="text" id="password" name="password"
                                   placeholder="변경할 비밀번호를 입력해주세요."
                                   data-parsley-required="true"
                                   data-parsley-required-message="※ 비밀번호를 입력해주세요."
                                   data-parsley-errors-container=".password-error-wrap">

                            <div class="password-error-wrap error-wrap-common"></div>

                        </td>
                    </tr>
                    <tr>
                        <th><label for="check-upw">비밀번호 확인</label></th>
                        <td>
                            <input type="text" id="password_confirmation" name="password_confirmation"
                                   class="password_confirmation"
                                   placeholder="위의 비밀번호를 다시 입력하세요."
                                   data-parsley-required="true"
                                   data-parsley-required-message="※ 비밀번호가 일치하지 않습니다."
                                   data-parsley-errors-container=".password-check-error-wrap">
                            <button class="btn-basic btn-password-change">변경</button>
                            <div class="password-check-error-wrap error-wrap-common"></div>
                        </td>
                    </tr>
                </table>
                <div class="btn-wrap">
                    <button class="btn-edit btn-common">수정완료</button>
                    <button class="btn-cancel btn-common">취소하기</button>
                </div>
            </section>
            </form>
        </div>
    </section>
@endsection
