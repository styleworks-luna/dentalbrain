@extends('mobile.layouts.frames.basic_frame')

@section('script')
    <script type="text/javascript" src="{{ asset('js/pages/user/find.js') }}"></script>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ mix('css/mobile/pages/user/find-id.css') }}">
@endsection

@section('title')
    <a href="" class="btn-back"></a>
    <h1>아이디 찾기</h1>
@endsection

@section('content')
    <section id="content">
        <div class="m-container">
            <article class="find-id">

                <div class="find-id-form find-form-common">
                    <p>아이디를 찾기 위해 다음 항목을 입력해주세요.</p>
                    <input type="text" id="name" name="name" class="name" placeholder="이름을 입력하세요">
                    <input type="text" id="phone" name="phone" class="phone" placeholder="휴대전화 번호를 입력하세요.(숫자만 입력)">
                    <input type="button" class="btn-find-id" value="확인">

                    <div class="message-wrap id-message"></div>
                </div>
            </article>
        </div>
    </section>
@endsection
