@extends('desktop.layouts.app')

@section('script')
    <script type="text/javascript" src="{{ asset('js/jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.ui.emailbox.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.tmpl.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/parsley.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/pages/register.js') }}"></script>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('css/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ mix('css/desktop/pages/user/register.css') }}">
@endsection

@section('content')
    @foreach($errors as $error)
        <p>{{ $error }}</p>
    @endforeach
    <section id="content" class="content">
        <div class="small-container">
            <form action="{{ route('user.create') }}" method="POST" id="register-form">
                @csrf
                <section class="register">
                    <h2>회원가입</h2>
                    <table>
                        <tr>
                            <th><label for="name">이름</label></th>
                            <td>
                                <input type="text"
                                       id="name"
                                       name="name"
                                       placeholder="이름입력 (최소 2자 이상)"
                                       data-parsley-required="true"
                                       data-parsley-required-message="※ 이름을 입력해주세요.">
                            </td>
                        </tr>
                        <tr>
                            <th class="th-center"><label for="uid">아이디</label></th>
                            <td>
                                <input type="text"
                                       id="login_id"
                                       class="login_id"
                                       name="login_id"
                                       placeholder="아이디 입력 (최소 4자 이상)"
                                       data-parsley-required="true"
                                       data-parsley-required-message= "※ 아이디를 입력해주세요.">
                                <button class="btn-basic check-overlap-id">중복확인</button>
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
                                       data-parsley-required-message= "※ 이메일 주소를 입력해주세요.">
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
                                       name ='license_num'
                                       data-parsley-required="true"
                                       data-parsley-required-message= "※ 면허번호를 입력해주세요.">
                            </td>
                        </tr>
                        <tr>
                            <th><label for="upw">비밀번호</label></th>
                            <td>
                                <input type="text" id="password" name="password"
                                       placeholder="비밀번호 입력 (최소 6자 이상)"
                                       data-parsley-required="true"
                                       data-parsley-required-message= "※ 비밀번호를 입력해주세요.">
                            </td>
                        </tr>
                        <tr>
                            <th><label for="check-upw">비밀번호 확인</label></th>
                            <td>
                                <input type="text" id="password_confirmation" name="password_confirmation"
                                       placeholder="위의 비밀번호를 다시 입력하세요."
                                       data-parsley-required="true"
                                       data-parsley-required-message= "※ 비밀번호가 일치하지 않습니다.">
                            </td>
                        </tr>
                        <tr>
                            <th><label for="phone">휴대전화</label></th>
                            <td>
                                <input type="text"
                                       id="phone"
                                       name="phone"
                                       class="phone"
                                       placeholder="'-'없이 입력해주세요."
                                       data-parsley-required="true"
                                       data-parsley-required-message= "※ 휴대전화 번호를 입력해주세요.">
                                <button class="btn-basic btn-verification">인증번호발송</button>

                                <input type="text"
                                       id="verification_number"
                                       name="verification_number"
                                       class="verification_number"
                                       placeholder="인증번호 6자리를 입력"
                                       data-parsley-required="true"
                                       data-parsley-required-message= "※ 일치하지 않습니다.">
                                <button class="btn-basic btn-verification mt-10">인증번호확인</button>

                            </td>
                        </tr>
                    </table>
                </section>
                <section class="agree">
                    <h2>이용약관 / 개인정보 수집 및 이용 동의</h2>
                    <div class="agree-form">
                        <div class="agreement-all-wrap">
                            <input type="checkbox" name="agree-all" id="agree-all" class="agree-all">
                            <label for="agree-all">전체동의</label>
                        </div>
                        <div class="agreement-wrap">
                            <ul>
                                <li>
                                    <div class="input-box">
                                        <input type="checkbox" name="service-consent"
                                               id="service-consent"
                                               class="service-consent"
                                               data-parsley-required="true"
                                               data-parsley-required-message= "※ 이용약관을 동의해 주세요.">
                                        <label for="service-consent">(필수) 이용약관 동의</label>
                                    </div>
                                    <a href="">내용보기</a>
                                </li>
                                <li>
                                    <div class="input-box">
                                        <input type="checkbox" name="privacy-consent"
                                               id="privacy-consent"
                                               class="privacy-consent"
                                               data-parsley-required="true"
                                               data-parsley-required-message= "※ 개인정보 수집 및 이용 동의해 주세요.">
                                        <label for="privacy-consent">(필수) 개인정보 수집 및 이용 동의</label>
                                    </div>
                                    <a href="">내용보기</a>
                                </li>
                                <li>
                                    <div class="input-box">
                                        <input type="checkbox" name="email-consent"
                                               id="email-consent"
                                               class="email-consent">
                                        <label for="email-consent"> (선택) 이메일 수신</label>
                                    </div>
                                    <a href="">내용보기</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </section>
                <section class="btn-wrap">
                    <button class="btn-purple" type="submit" form="register-form">가입완료</button>
                </section>
            </form>
        </div>
    </section>
@endsection
