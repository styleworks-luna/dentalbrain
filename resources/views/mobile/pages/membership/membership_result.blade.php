@extends('mobile.layouts.frames.basic_frame')

@section('script')
@endsection

@section('style')

@endsection

@section('title')
    <h1>유료회원</h1>
@endsection

@section('content')
    <section class="content">
        <div class="membership">
            {{ auth()->user()->name }}님 가입 축하합니다.
        </div>
        <div class="btn-zone">
            <a href="{{ url('/') }}">확인</a>
        </div>
    </section>
@endsection

