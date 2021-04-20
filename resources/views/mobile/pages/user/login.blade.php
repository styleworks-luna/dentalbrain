@extends('mobile.layouts.frames.basic_frame')

@section('style')
    <link rel="stylesheet" href="{{ mix('css/mobile/pages/user/login.css') }}">
@endsection

@section('content')
    <section id="content">
        <div class="m-container">
            <section class="login">
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <h1>로그인</h1>
                    <div class="login-form">
                        <input type="text" id="login_id" name="login_id"
                               class="login-id @error('login_failed') input-error @enderror @error('login_id') input-error @enderror"
                               placeholder=" 아이디 입력"
                               value="{{ old('login_id') ?? '' }}">
                        <input type="password" id="password" name="password"
                               class="password @error('login_failed') input-error @enderror @error('password') input-error @enderror"
                               placeholder="비밀번호 입력">
                        <input type="submit" class="btn-login" value="로그인">
                    </div>
                    @if($errors->any())
                        <div class="error-wrap">
                            <pre class="error">{{ $errors->first() }}</pre>
                        </div>
                    @endif
                    <div class="login-addition">
                        <div class="login-find">
                        <a href="{{ url('m-find') }}" class="find-id">아이디</a>
                        <a href="{{ url('m-find-ps') }}" class="find-id">비밀번호 찾기</a>
                        </div>
                        <div class="login-register">
                        <a href="{{ url('register') }}" class="go-register">회원가입</a>
                        </div>
                    </div>
                </form>
            </section>
        </div>

    </section>
@endsection
