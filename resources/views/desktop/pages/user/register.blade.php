@extends('desktop.layouts.frames.simple_frame')

@section('script')
    <script type="text/javascript" src="{{ asset('js/jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.ui.emailbox.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/parsley.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/ko.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/pages/user/register.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/pages/agreement/agreement.js') }}"></script>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ mix('css/desktop/pages/user/register.css') }}">
@endsection

@section('content')
    <section id="content" class="content">
        @if ($errors->any())
            <ul class="alert-danger">
                @foreach ($errors->all() as $error)
                    <li class="alert-danger-list">{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <div class="small-container">
            <form action="{{ route('register') }}" method="POST" id="register-form">
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
                                       placeholder="이름 입력 (최소 2자 이상)"
                                       data-parsley-required="true"
                                       data-parsley-required-message="※ 이름을 입력해주세요."
                                       data-parsley-errors-container=".name-error-wrap"
                                       value="{{ old('name') }}">

                                <div class="name-error-wrap parsley-error-wrap"></div>
                            </td>
                        </tr>
                        <tr>
                            <th class="th-center"><label for="uid">아이디</label></th>
                            <td>
                                <input type="text"
                                       id="login_id"
                                       name="login_id"
                                       class="login-id"
                                       placeholder="아이디 입력 (최소 4자 이상)"
                                       data-parsley-required="true"
                                       data-parsley-required-message="※ 아이디를 입력해주세요."
                                       data-parsley-errors-container=".id-error-wrap"
                                       value="{{ old('login_id') }}">
                                <button type="button" id="login_id_confirm" class="btn-basic check-overlap-id">중복확인
                                </button>

                                <input type="hidden"
                                       name="login_id_check"
                                       id="login_id_check"
                                       value="N"
                                       data-parsley-pattern="[Y]"
                                       data-parsley-errors-container=".id-error-wrap"
                                       data-parsley-pattern-message="※ 중복확인을 해 주세요.">

                                <div class="id-error-wrap parsley-error-wrap"></div>
                            </td>
                        </tr>
                        <tr>
                            <th><label for="email">이메일</label></th>
                            <td>
                                <input type="email"
                                       id="email"
                                       name="email"
                                       class="email_box"
                                       data-parsley-required="true"
                                       data-parsley-type="email"
                                       data-parsley-required-message="※ 이메일 주소를 입력해주세요."
                                       data-parsley-class-handler=".ui-emailbox"
                                       data-parsley-errors-container=".email-error-wrap"
                                       value="{{ old('email') }}">

                                <div class="email-error-wrap parsley-error-wrap"></div>
                            </td>
                        </tr>
                        <tr>
                            <th><label for="job">직업군</label></th>
                            <td>
                                <select name="job" id="job" class="select-menu">
                                    @foreach($jobs as $job)
                                        <option value="{{ $job->id }}"
                                                @if(old('job') == $job->id) selected @endif
                                        >{{ $job->name }}</option>
                                    @endforeach
                                </select>
                                <input type="text" placeholder="면허번호를 입력해주세요."
                                       id='license_num'
                                       name='license_num'
                                       data-parsley-required="true"
                                       data-parsley-required-message="※ 면허번호를 입력해주세요."
                                       data-parsley-errors-container=".license-error-wrap"
                                       value="{{ old('license_num') }}">

                                <div class="license-error-wrap parsley-error-wrap"></div>
                            </td>
                        </tr>
                        <tr>
                            <th><label for="work_address">근무지역</label></th>
                            <td>
                                <input type="text"
                                       id="work_address"
                                       name="work_address"
                                       class="work_address"
                                       placeholder="시/구까지 입력해주세요."
                                       value="{{ old('work_address') }}">
                            </td>
                        </tr>
                        <tr>
                            <th><label for="upw">비밀번호</label></th>
                            <td>
                                <input type="password" id="password" name="password"
                                       placeholder="비밀번호 (영문, 숫자 포함 최소 6자)"
                                       data-parsley-required="true"
                                       data-parsley-minlength="6"
                                       data-parsley-errors-container=".password-error-wrap"
                                       data-parsley-required-message="※ 비밀번호를 입력해주세요.">

                                <div class="password-error-wrap parsley-error-wrap"></div>
                            </td>
                        </tr>
                        <tr>
                            <th><label for="check-upw">비밀번호 확인</label></th>
                            <td>
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                       placeholder="비밀번호를 다시 입력해주세요."
                                       data-parsley-minlength="6"
                                       data-parsley-required="true"
                                       data-parsley-equalto="#password"
                                       data-parsley-required-message="※ 비밀번호가 일치하지 않습니다."
                                       data-parsley-errors-container=".password-check-error-wrap">

                                <div class="password-check-error-wrap parsley-error-wrap"></div>
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
                                       data-parsley-errors-container=".phone-check-error-wrap"
                                       value="{{ old('phone') }}">
                                <button type="button" id="send_authentication" class="btn-basic btn-verification">
                                    인증번호 발송
                                </button>
                                <button type="button" id="edit_phone" class="btn-basic btn-edit-phone">변경</button>

                                <p class="timer"></p>

                                <div class="phone-check-error-wrap parsley-error-wrap"></div>

                                <input type="text"
                                       id="verification_number"
                                       name="verification_number"
                                       class="verification-number"
                                       placeholder="인증번호 6자리를 입력"
                                       readonly="readonly"
                                       data-parsley-required="true"
                                       data-parsley-errors-container=".verification-check-error-wrap"
                                       data-parsley-required-message="※ 일치하지 않습니다.">
                                <button type="button" id="confirm_authentication"
                                        class="btn-basic btn-verification mt-10">인증번호 확인
                                </button>

                                <input type="hidden"
                                       name="phone-check"
                                       id="phone-check"
                                       value="N"
                                       data-parsley-pattern="[Y]"
                                       data-parsley-errors-container=".verification-check-error-wrap"
                                       data-parsley-pattern-message="※ 일치하지 않습니다.">

                                <div class="verification-check-error-wrap parsley-error-wrap"></div>
                            </td>
                        </tr>
                    </table>
                </section>

                <section class="agree">
                    <h2>이용약관 / 개인정보 수집 및 이용 동의</h2>
                    <div class="agree-form">
                        <div class="agreement-all-wrap checkbox-wrap">
                            <input type="checkbox" name="agree-all" id="agree-all" class="agree-all"
                                   @if(old('agree-all')) checked @endif>
                            <label for="agree-all">전체동의</label>
                        </div>
                        <div class="agreement-wrap">
                            <ul>
                                <li>
                                    <div class="checkbox-from">
                                        <div class="checkbox-wrap">
                                            <input type="checkbox" name="service-consent"
                                                   id="service-consent"
                                                   class="service-consent"
                                                   data-parsley-required="true"
                                                   data-parsley-required-message="※ 이용약관을 동의해 주세요."
                                                   data-parsley-errors-container=".service-check-error-wrap"
                                                   @if(old('service-consent')) checked @endif>

                                            <label for="service-consent">(필수) 이용약관 동의</label>
                                        </div>
                                        <a href="" class="trigger-service">내용보기</a>
                                    </div>

                                    <div class="service-check-error-wrap parsley-error-wrap"></div>
                                </li>
                                <li>
                                    <div class="checkbox-from">
                                        <div class="checkbox-wrap">
                                            <input type="checkbox" name="privacy-consent"
                                                   id="privacy-consent"
                                                   class="privacy-consent"
                                                   data-parsley-required="true"
                                                   data-parsley-required-message="※ 개인정보 수집 및 이용 동의해 주세요."
                                                   data-parsley-errors-container=".privacy-check-error-wrap"
                                                   @if(old('privacy-consent')) checked @endif>
                                            <label for="privacy-consent">(필수) 개인정보 수집 및 이용 동의</label>
                                        </div>
                                        <a href="" class="trigger-privacy">내용보기</a>
                                    </div>

                                    <div class="privacy-check-error-wrap parsley-error-wrap"></div>
                                </li>
                                <li>
                                    <div class="checkbox-from">
                                        <div class="checkbox-wrap">
                                            <input type="checkbox" name="email-consent"
                                                   id="email-consent"
                                                   @if(old('email-consent')) checked @endif>
                                            <label for="email-consent"> (선택) 이메일 수신</label>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="checkbox-from">
                                        <div class="checkbox-wrap">
                                            <input type="checkbox" name="sms-consent"
                                                   id="sms-consent"
                                                   @if(old('sms-consent')) checked @endif>
                                            <label for="sms-consent"> (선택) 문자 수신</label>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                </section>

                <div class="btn-wrap">
                    <input type="submit" class="btn-register btn-purple" value="가입완료">
                </div>

                <div class="dim"></div>
                <div class="popup-control">
                    @include('desktop.component.popup.agreement.service')
                    @include('desktop.component.popup.agreement.privacy')
                </div>
            </form>
        </div>
    </section>
@endsection
