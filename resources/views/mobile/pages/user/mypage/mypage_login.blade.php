@extends('mobile.layouts.frames.except_frame')

@section('script')
@endsection

@section('style')
    <link rel="stylesheet" href="{{ mix('css/mobile/pages/user/mypage/mypage-login.css') }}">
@endsection

@section('content')
    <section class="content">
        <div class="m-container">
            <section class="identification">
                <form action="{{ route('account.confirm') }}" method="POST">
                    @csrf
                    <div class="identification-form">
                        <p>본인확인을 위해 <em>로그인 비밀번호</em>를 한번 더 입력해주세요.</p>
                        <div class="input-wrap">
                            <input type="password" id="password" name="password" class="password" placeholder="비밀번호를 입력하세요." />
                        </div>
                        <div class="btn-wrap">
                            <input type="submit" class="btn-basic" value="확인" />
                        </div>
                    </div>
                </form>
            </section>
        </div>
    </section>
@endsection
