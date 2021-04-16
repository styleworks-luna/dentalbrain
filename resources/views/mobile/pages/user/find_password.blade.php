@extends('mobile.layouts.frames.basic_frame')

@section('script')
    <script type="text/javascript" src="{{ asset('js/pages/user/find.js') }}"></script>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ mix('css/mobile/pages/user/find-id.css') }}">
@endsection

@section('content')
    <section id="content">
        <div class="m-container">
            <article class="find-password">
                <div class="find-password-form find-form-common">
                    <p>비밀번호를 찾기 위해 다음 항목을 입력해주세요.</p>
                    <input type="text" id="email" name="email" class="email" placeholder="이메일을 입력하세요.">
                    <input type="button" class="btn-confirm btn-find-password" value="확인">

                    <div class="message-wrap password-message"></div>
                </div>
            </article>
        </div>
    </section>
@endsection
