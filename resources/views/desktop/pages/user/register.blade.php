@extends('desktop.layouts.app')

@section('script')
    <script type="text/javascript" src="{{ asset('js/jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.ui.emailbox.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/parsley.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/pages/register.js') }}"></script>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ ('css/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ mix('css/desktop/pages/user/register.css') }}">
@endsection

@section('content')
    <section id="content" class="content">
        <div class="small-container">
            <form action="">
                <section class="register">
                    <h2>회원가입</h2>
                    <table>
                        <tr>
                            <th><label for="name">이름</label></th>
                            <td>
                                <input type="text"
                                       id="name"
                                       placeholder="이름입력 (최소 2자 이상)">
                            </td>
                        </tr>
                        <tr>
                            <th class="th-center"><label for="uid">아이디</label></th>
                            <td>
                                <input type="text"
                                       id="uid"
                                       class="uid"
                                       placeholder="아이디입력 (최소 4자 이상)">
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
                                       data-parsley-class-handler=".ui-emailbox">
                            </td>
                        </tr>
                        <tr>
                            <th><label for="job">직업군</label></th>
                            <td>
                                <select name="job" id="job">
                                    <option value="">치과의사</option>
                                    <option value="">치과위생사</option>
                                    <option value="">치과조무사</option>
                                    <option value="">코디네이터</option>
                                    <option value="">학생</option>
                                    <option value="">기타</option>
                                </select>
                                <input type="text" placeholder="면허번호를 입력해주세요.">
                            </td>
                        </tr>
                        <tr>
                            <th><label for="upw">비밀번호</label></th>
                            <td>
                                <input type="text" id="upw" placeholder="비밀번호 입력 (최소 6자 이상)">
                            </td>
                        </tr>
                        <tr>
                            <th><label for="check-upw">비밀번호 확인</label></th>
                            <td>
                                <input type="text" id="check-upw" placeholder="위의 비밀번호를 다시 입력하세요.">
                            </td>
                        </tr>
                        <tr>
                            <th><label for="phone">휴대전화</label></th>
                            <td>
                                <input type="text"
                                       id="phone"
                                       class="phone"
                                       placeholder="'-' 없이 입력해주세요.">
                                <button class="btn-basic btn-certification">인증번호발송</button>

                                <input type="text"
                                       id="certification-number"
                                       class="certification-number"
                                       placeholder="인증번호 6자리를 입력">
                                <button class="btn-basic btn-certification mt-10">인증번호확인</button>

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
                                        <input type="checkbox" name="service-consent" id="service-consent"
                                               class="service-consent">
                                        <label for="service-consent">(필수) 이용약관 동의</label>
                                    </div>
                                    <a href="">내용보기</a>
                                </li>
                                <li>
                                    <div class="input-box">
                                        <input type="checkbox" name="privacy-consent" id="privacy-consent"
                                               class="privacy-consent">
                                        <label for="privacy-consent">(필수) 개인정보 수집 및 이용 동의</label>
                                    </div>
                                    <a href="">내용보기</a>
                                </li>
                                <li>
                                    <div class="input-box">
                                        <input type="checkbox" name="reception-consent" id="reception-consent"
                                               class="reception-consent">
                                        <label for="reception-consent"> (선택) 이메일 수신</label>
                                    </div>
                                    <a href="">내용보기</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </section>
                <section class="btn-wrap">
                    <button class="btn-purple btn-register">가입완료</button>
                </section>
            </form>
        </div>
    </section>
@endsection
