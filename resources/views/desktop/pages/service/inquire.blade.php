@extends('desktop.layouts.app')

@section('script')
    <script type="text/javascript" src="{{ asset('js/jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.ui.emailbox.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/parsley.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/pages/inquire.js') }}"></script>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ mix('css/desktop/pages/service/inquire.css') }}">
@endsection

@section('content')
    <section id="content">
        <section class="inquire-wrap">
            <div class="container">
                @include('desktop.layouts.navigation.service')

                <section class="inquire">
                    <h2>문의하기</h2>
                    <form action="">
                    <div class="inquire-form">
                        <table>
                            <tr>
                                <th>이름</th>
                                <td>
                                    <input type="text"
                                           id="name"
                                           name="name"
                                           placeholder="이름입력 (최소 2자 이상)"
                                           data-parsley-required="true"
                                           data-parsley-required-message="※ 이름을 입력해주세요.">
                                </td>

                                <th>연락처</th>
                                <td>
                                    <input type="text"
                                           id="phone"
                                           name="phone"
                                           class="phone"
                                           placeholder="'-' 없이 입력해주세요."
                                           data-parsley-required="true"
                                           data-parsley-required-message="※ 휴대전화 번호를 입력해주세요.">
                                </td>
                            </tr>
                            <tr>
                                <th>이메일</th>
                                <td>
                                    <input type="email"
                                           id="email"
                                           name="email"
                                           class="email_box"
                                           data-parsley-required="true"
                                           data-parsley-type="email"
                                           data-parsley-required-message="※ 이메일 주소를 입력해주세요."
                                           data-parsley-class-handler=".ui-emailbox"
                                           data-parsley-errors-container=".email-error-wrap">
                                    <p>※ 답변 받을 이메일 주소를 입력해주세요.</p>
                                    <div class="email-error-wrap parsley-error-wrap"></div>
                                </td>
                            </tr>
                            <tr>
                                <th>제목</th>
                                <td>
                                    <input type="text"
                                           id="title"
                                           name="title"
                                           class="title"
                                           data-parsley-required="true"
                                           data-parsley-required-message="※ 제목을 입력해주세요.">
                                </td>
                            </tr>
                            <tr>
                                <th>문의내용</th>
                                <td>
                                    <input type="text"
                                           id="inquire_content"
                                           name="inquire_content"
                                           class="inquire-content"
                                           data-parsley-required="true"
                                           data-parsley-required-message="※ 문의내용을 입력해주세요.">
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="btn-wrap">
                        <input type="submit" class="btn-submit" value="문의하기">
                    </div>
                    </form>
                </section>

            </div>
        </section>
    </section>
@endsection
