@extends('desktop.layouts.frames.basic_frame')

@section('script')
    <script type="text/javascript" src="{{ asset('js/jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.ui.emailbox.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/parsley.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/ko.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/pages/user/mypage-edit.js') }}"></script>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ mix('css/desktop/pages/user/mypage-edit.css') }}">
@endsection

@section('content')
    <section class="content">
        <div class="container">
            @include('desktop.layouts.navigation.account')
            <form action="{{ route('account.update') }}" id="edit-form" method="POST">
                @csrf
                <section class="edit">
                    <h2>회원정보 수정</h2>
                    <table>
                        <tr>
                            <th><h3>이름</h3></th>
                            <td>
                                <p>{{ auth()->user()->name }}</p>
                            </td>
                        </tr>
                        <tr>
                            <th class="th-center"><h3>아이디</h3></th>
                            <td>
                                <p>{{ auth()->user()->login_id }}</p>
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
                                       data-parsley-errors-container=".email-error-wrap"
                                       value="{{ auth()->user()->email }}">
                                <div class="email-error-wrap error-wrap-common">
                                    <div class="error">
                                        @error('email')
                                        {{$message}}
                                        @enderror
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th><label for="job">직업군</label></th>
                            <td>
                                <select name="job" id="job" class="select-menu">
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}"
                                                @if ($category->id == auth()->user()->job->job_name_id)
                                                selected
                                            @endif
                                        >{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <input type="text" placeholder="면허번호를 입력해주세요."
                                       id='license_num'
                                       name='license_num'
                                       data-parsley-required="true"
                                       data-parsley-required-message="※ 면허번호를 입력해주세요."
                                       data-parsley-errors-container=".license-error-wrap"
                                       value="{{ auth()->user()->job->license_num }}">
                                <div class="license-error-wrap error-wrap-common">
                                    <div class="error">
                                        @error('license_num')
                                        {{$message}}
                                        @enderror
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th><label for="phone">휴대전화</label></th>
                            <td>
                                <div class="phone-wrap">
                                    <input type="text"
                                           id="phone"
                                           name="phone"
                                           class="phone"
                                           readonly="true"
                                           placeholder="'-' 없이 입력해주세요."
                                           data-parsley-required="true"
                                           data-parsley-required-message="※ 휴대전화 번호를 입력해주세요."
                                           data-parsley-errors-container=".phone-check-error-wrap"
                                           value="{{ auth()->user()->phone }}">
                                    <button type="button" id="send_authentication" class="btn-basic btn-verification">
                                        인증번호발송
                                    </button>
                                    <button type="button" id="edit_phone" class="btn-basic btn-edit-phone">변경</button>

                                    <p class="timer"></p>


                                </div>
                                <div class="phone-check-error-wrap error-wrap-common"></div>
                                <div class="phone-wrap">
                                    <input type="text"
                                           id="verification_number"
                                           name="verification_number"
                                           class="verification-number"
                                           readonly="true"
                                           placeholder="인증번호 6자리를 입력"
                                           data-parsley-required="false"
                                           data-parsley-required-message="※ 일치하지 않습니다."
                                           data-parsley-errors-container=".verification-check-error-wrap">
                                    <button type="button" id="confirm_authentication"
                                            class="btn-basic btn-verification mt-10">인증번호확인
                                    </button>

                                    <input type="hidden"
                                           name="phone-check"
                                           id="phone-check"
                                           value="Y"
                                           data-parsley-pattern="[Y]"
                                           data-parsley-errors-container=".verification-check-error-wrap"
                                           data-parsley-pattern-message="※ 인증번호 확인 요청.">
                                </div>
                                <div class="verification-check-error-wrap error-wrap-common"></div>

                            </td>
                        </tr>
                        <tr>
                            <th><label for="upw">비밀번호 변경</label></th>
                            <td>
                                <div class="password-wrap">
                                    <input type="password" id="password" name="password"
                                           placeholder="변경할 비밀번호를 입력해주세요."
                                           readonly="true"
                                           data-parsley-required="false"
                                           data-parsley-minlength="6"
                                           data-parsley-errors-message="※ 비밀번호를 입력해주세요."
                                           data-parsley-errors-container=".password-error-wrap">
                                    <button type="button" id="edit_password" class="btn-basic btn-edit-password">
                                        변경
                                    </button>
                                </div>
                                <div class="password-error-wrap error-wrap-common">
                                    <div class="error">
                                        @error('password')
                                        {{$message}}
                                        @enderror
                                    </div>
                                </div>

                            </td>
                        </tr>
                        <tr>
                            <th><label for="check-upw">비밀번호 확인</label></th>
                            <td>
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                       class="password_confirmation"
                                       readonly="true"
                                       placeholder="위의 비밀번호를 다시 입력하세요."
                                       data-parsley-minlength="6"
                                       data-parsley-equalto="#password"
                                       data-parsley-errors-message="※ 비밀번호가 일치하지 않습니다."
                                       data-parsley-errors-container=".password-check-error-wrap">
                                <div class="password-check-error-wrap error-wrap-common"></div>
                            </td>
                        </tr>
                    </table>
                    <div class="btn-wrap">
                        <input type="submit" class="btn-edit btn-common" value="수정완료">
                        <a href="/" class="btn-cancel btn-common">취소하기</a>
                    </div>
                </section>
            </form>
        </div>
    </section>
@endsection
