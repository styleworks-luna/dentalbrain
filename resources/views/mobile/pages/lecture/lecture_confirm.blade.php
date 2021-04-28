@extends('mobile.layouts.frames.except_frame')

@section('script')
@endsection

@section('style')
    <link rel="stylesheet" href="{{ mix('css/mobile/pages/lecture/lecture-confirm.css') }}">
@endsection

@section('title')
    <a href="" class="btn-back"></a>
    <div class="logo-wrap">
        <a href="{{ url('/') }}" class="ir_pm header-logo">
            <img src="{{ asset('/images/mobile/global/logo.svg') }}" alt="덴탈브레인">
        </a>
    </div>
@endsection

@section('content')
    <section id="content">
        <section class="lecture-confirm">
            <div class="m-container">
                <div class="confirm-layer">
                    <div class="layer-title">
                        <h1>강의 시청 안내</h1>
                        <a href="#" class="close" onClick="history.back()"></a>
                    </div>
                    <div class="confirm-text">
                        <div class="img-wrap">
                            <img src="{{ asset('images/mobile/lecture/lecture_check.svg') }}" alt=""/>
                        </div>
                        <div class="text-wrap">
                            <p class="text">“여러분들을 위해 만든 교육의 가치를 지켜주세요”</p>
                            <p class="tip">
                                <em>저작권법 제136조</em>, 온・오프라인 등지에서 무단전재 및<br>
                                재배포, 영상녹화 캡쳐 등 영상물 재가공 시 <br>
                                <em>5년 이하의 징역 또는 5천만원의 벌금</em></p>
                            <p class="text-last">강의를 시청하시면 환불이 불가능 합니다</p>
                        </div>
                    </div>
                    <div class="btn-wrap">
                        <form action="{{ route('lectures.check-watch',['program' => $program]) }}" method="POST"
                              enctype="multipart/form-data">
                            @method('PATCH')
                            @csrf
                            <a href="#" onClick="history.back()">취소</a>
                            <button class="btn-confirm">확인</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </section>
@endsection
