@extends('desktop.layouts.frames.simple_frame')

@section('script')
    <script type="text/javascript" src="{{ asset('js/pages/user/find.js') }}"></script>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ mix('css/desktop/pages/user/find-id.css') }}">
@endsection

@section('content')
    <section class="content">
        <article class="find-id">
            <h2>아이디 찾기</h2>

            <div class="find-id-form find-form-common">
                <p>아이디를 찾기 위해 다음 항목을 입력해주세요.</p>
                <input type="text" id="name" name="name" class="name" placeholder="이름을 입력 (최소 2자 이상)">
                <input type="text" id="phone" name="phone" class="phone" placeholder="휴대전화 번호 입력 ('-'없이 숫자만 입력)">
                <input type="button" class="btn-confirm btn-find-id" value="확인">

                <div class="message-wrap id-message"></div>
            </div>
        </article>

        <article class="find-password">
            <h2>비밀번호 찾기</h2>

            <div class="find-password-form find-form-common">
                <p>비밀번호를 찾기 위해 다음 항목을 입력해주세요.</p>
                <input type="text" id="email" name="email" class="email" placeholder="이메일 주소 입력">
                <input type="button" class="btn-confirm btn-find-password" value="확인">

                <div class="message-wrap password-message"></div>
            </div>
        </article>
    </section>
@endsection
