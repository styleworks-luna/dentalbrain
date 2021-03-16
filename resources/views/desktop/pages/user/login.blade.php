@extends('desktop.layouts.frames.simple_frame')

@section('style')
    <link rel="stylesheet" href="{{ mix('css/desktop/pages/user/login.css') }}">
@endsection

@section('content')
    <section id="content">
        <section class="login">
            <div class="container">
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <h1>로그인</h1>
                    <div class="login-form">
                        <input type="text" id="login_id" name="login_id"
                               class="login-id @error('login_failed') input-error @enderror @error('login_id') input-error @enderror"
                               placeholder=" 아이디를 입력"
                               value="{{ old('login_id') ?? '' }}">
                        <input type="password" id="password" name="password"
                               class="password @error('login_failed') input-error @enderror @error('password') input-error @enderror"
                               placeholder="비밀번호를 입력">
                        <input type="submit" class="btn-login" value="로그인">
                    </div>
                    @if($errors->any())
                        <div class="error-wrap">
                            <p class="error">{{$errors->first()}}</p>
                        </div>
                    @endif
                    <div class="login-addition">
                        <a href="{{ url('find') }}" class="find-id">아이디/비밀번호 찾기</a>
                        <a href="{{ url('register') }}" class="go-register">회원가입</a>
                    </div>
                </form>
            </div>
        </section>
    </section>
@endsection
