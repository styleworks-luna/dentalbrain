@extends('desktop.layouts.app')

@section('style')
    <link rel="stylesheet" href="{{ mix('css/desktop/pages/service/notice-detail.css') }}">
@endsection

@section('content')
    <section id="content">
        <div class="notice-detail-wrap">
            <div class="container">
                @include('desktop.layouts.navigation.service')

                <section class="notice-detail">
                    <h2>공지사항</h2>
                    <div class="notice-detail-text">
                        <div class="notice-detail-title">
                            <h3>코로나19로 인해 치과임상공부 집에서도 편하게하는 온라인세미나를 시작했습니다.</h3>
                            <div class="notice-info">
                                <span class="writer">관리자</span>
                                <span class="bar"></span>
                                <span class="date">2020.11.17 17:56:47</span>
                            </div>
                        </div>
                        <div class="notice-detail-content">
                            <p>
                                안녕하세요. 브레인스펙 대표 김민정입니다.
                                2020년 상반기를 코로나19와 함께 일상을 보내고 계신 치과선생님들께 응원메세지 드립니다.
                                너무나 고생많으셨고 앞으로도 이런 상황이 계속 될거라 생각합니다.
                                쉽사리 사그러들 바이러스가 아닌 듯 싶은데요.  환자와 더불어 선생님들의 감염관리에 철저하셔야 하겠습니다.
                                저희 브레인스펙은 온라인라이브세미나로 현장감을 100% 재현은 못하더라도 수장자분들과 소통하는 강의를 진행하고자
                                온라인세미나를 준비하고 있습니다.
                                매 달 온라인으로 찾아 뵐 수있도록 강사분들이 계속 노력하고 계십니다.
                                항상 브레인스펙교육에 관심가져주시는 선생님들께 감사드리며
                                저희 브레인스펙도 좋은 교육으로 찾아가겠습니다.

                                감사합니다.
                            </p>
                        </div>

                    </div>
                    <div class="btn-wrap">
                        <a href="" class="btn-prev">목록으로</a>
                    </div>
                </section>

            </div>
        </div>
    </section>
@endsection
