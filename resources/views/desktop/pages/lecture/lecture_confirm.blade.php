@extends('desktop.layouts.frames.except_frame')

@section('script')

@endsection

@section('style')
    <link rel="stylesheet" href="{{ mix('css/desktop/pages/lecture/lecture-confirm.css') }}">
@endsection

@section('content')
    <section id="content">
        <section class="lecture-confirm">
            <div class="container">
                <div class="confirm-layer">
                    <h1>강의 시청 안내</h1>
                    <div class="confirm-text">
                        <ul>
                            <li>
                                <div class="text-wrap">
                                    <span class="check"></span>
                                    <p class="text">“여러분들을 위해 만든 교육의 가치를 지켜주세요”</p>
                                </div>
                                <p class="tip"><em>저작권법 제136조</em>, 온・오프라인 등지에서 무단전재 및 재배포,<br>
                                    영상녹화 캡쳐 등 영상물 재가공 시 <em>5년 이하의 징역 또는 5천만원의 벌금</em></p>
                            </li>
                            <li>
                                <div class="text-wrap">
                                    <span class="check"></span>
                                    <p class="text">강의를 시청하시면 환불이 불가능 합니다</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="btn-wrap">
                        <form action="{{ route('lectures.check-watch',['program' => $program]) }}" method="POST"
                              enctype="multipart/form-data">
                            @method('PATCH')
                            @csrf
                            <button class="btn-confirm">확인</button>
                            <a href="#" onClick="history.back()">취소</a>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </section>
@endsection
