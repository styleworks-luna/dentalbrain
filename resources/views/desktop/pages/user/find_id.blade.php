@extends('desktop.layouts.frames.simple_frame')

@section('style')
    <link rel="stylesheet" href="{{ mix('css/desktop/pages/user/find-id.css') }}">
@endsection

@section('content')
    <section id="content">
        <section class="find">
            <div class="container">
                <div class="find-id">
                    <form action="{{ route('findIdWithNameAndPhone') }}" method="post">
                        @csrf
                        <h2>아이디 찾기</h2>
                        <div class="find-id-form find-form-common">
                            <p>아이디를 찾기 위해 다음 항목을 입력해주세요.</p>
                            <input type="text" id="name" name="name" class="name" placeholder="이름을 입력하세요.">
                            <input type="text" id="phone" name="phone" class="phone" placeholder="휴대전화 번호를 입력하세요. (숫자만 입력)">
                            <input type="submit" class="btn-confirm" value="확인">
                        </div>
                    </form>
                </div>
                <div class="find-password">
                    <form action="{{ route('sendPasswordMail')}}" method="post">
                        @csrf
                        <h2>비밀번호 찾기</h2>
                        <div class="find-password-form find-form-common">
                            <p>비밀번호를 찾기 위해 다음 항목을 입력해주세요.</p>
                            <input type="text" id="email" name="email" class="email" placeholder="이메일을 입력하세요.">
                            <input type="submit" class="btn-confirm" value="확인">
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </section>
@endsection
