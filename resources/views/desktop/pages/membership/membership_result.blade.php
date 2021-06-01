@extends('desktop.layouts.frames.basic_frame')

@section('script')
@endsection

@section('style')
    <link rel="stylesheet" href="{{ mix('css/desktop/pages/membership/membership.css') }}">
@endsection
@section('content')
    <section class="content">
        <div class="membership">
            {{ auth()->user()->name }}님 가입 축하합니다.

            {{ auth()->user()->membership->expired_at }} 까지 사용 가능합니다.
        </div>
    </section>
@endsection

