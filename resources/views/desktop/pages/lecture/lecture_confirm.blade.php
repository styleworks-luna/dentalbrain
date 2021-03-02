@extends('desktop.layouts.frames.except_frame')

@section('style')
    <link rel="stylesheet" href="{{ mix('css/desktop/pages/lecture/lecture-confirm.css') }}">
@endsection

@section('content')
    <section id="content">
        <section class="lecture-confirm">
            <div class="container">
                <div class="confirm-layer">
                    <h1>강의 시청 하시면 환불이 불가능합니다.<br>시청 하시겠습니까?</h1>
                    <div class="btn-wrap">
                    <a href="">확인</a>
                    <a href="#" onClick="history.back()">취소</a>
                    </div>
                </div>
            </div>
        </section>
    </section>
@endsection
