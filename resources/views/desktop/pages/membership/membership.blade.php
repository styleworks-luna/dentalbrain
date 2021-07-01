@extends('desktop.layouts.frames.basic_frame')

@section('script')
@endsection

@section('style')
    <link rel="stylesheet" href="{{ mix('css/desktop/pages/membership/membership.css') }}">
@endsection

@section('content')
    <section class="content">
        <div class="membership">
            <div class="title-wrap">
                <div class="container">
                    <div class="title">
                        <h1>유료회원</h1>
                    </div>
                </div>
            </div>
            <div class="membership-information-wrap">
                <div class="container">
                    <div class="membership-information-title">
                        <h2><em>유료 멤버십 회원</em>이 되면<br>어떤점이 달라지나요?</h2>
                        <p>유료회원의 혜택(유료 멤버십 회원)을 위한 특별 혜택입니다.<br>
                            브레인스펙이 운영하는 온라인교육원 덴탈브레인의 전 교육 과정은 계속 업데이트 되며 혜택을 받을 수 있습니다. </p>
                    </div>
                    <div class="membership-information-content-wrap">
                        <div class="membership-information-content">
                            <div class="membership-information-content-item">
                                <img src="{{ asset('images/desktop/membership/membership_icon_1.svg') }}" alt="membership_icon_1">
                                <p>모든 강의를 1년 동안<br>
                                    특별 할인가에 수강 가능!</p>
                            </div>
                            <div class="membership-information-content-item">
                                <img src="{{ asset('images/desktop/membership/membership_icon_2.svg') }}" alt="membership_icon_2">
                                <p>유료 멤버십 회원 가입시<br>
                                    웰컴 기프트 증정!</p>
                            </div>
                            <div class="membership-information-content-item">
                                <img src="{{ asset('images/desktop/membership/membership_icon_3.svg') }}" alt="membership_icon_3">
                                <p>브레인스펙의<br>
                                    각종 행사와 특강 초대!</p>
                            </div>
                        </div>
                        <div class="membership-information-content">
                            <div class="membership-information-content-item item-wide">
                                <img src="{{ asset('images/desktop/membership/membership_icon_4.svg') }}" alt="membership_icon_4">
                                <p>브레인스펙의 치과컨설팅 등<br>
                                    치과내 원내 교육에 특별 할인 적용 가능!</p>
                            </div>
                            <div class="membership-information-content-item item-wide">
                                <img src="{{ asset('images/desktop/membership/membership_icon_5.svg') }}" alt="membership_icon_5">
                                <p>치과경영, 치과임상,<br>
                                    치과조직관리 등에 필요한 정보 제공!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="membership-price-wrap">
                <div class="container">
                    <h2>1년 365일 내내 <em>유료회원 가입 환영합니다!</em></h2>
                    @if($hasMembership)
                        <div class="membership-left-days">
                            회원님의 유료회원 잔여기간은 <em>{{ $membershipLeftDays }}</em>일 입니다.
                        </div>
                    @endif
                    <div class="membership-price-content">
                        <div class="membership-price-item">
                            <h3>유료회원 연 결제</h3>
                            <span class="price">99,000원/연</span>
                            <p class="price-tip">연 회비 99,000원을 결제하면 자동으로 유료회원이 되고, 결제일로부터<br>
                                1년 동안 무료강의와 할인 된 강의를 자유롭게 수강하실 수 있습니다.</p>
                            <a href="#" class="btn-apply">신청하기</a>
                        </div>
                        <div class="membership-price-item">
                            <h3>유료회원 월 결제</h3>
                            <span class="price">29,000원/월</span>
                            <p class="price-tip">월 회비 29,000원을 결제하면 자동으로 월 회원이 되고, 결제일로부터<br>
                                한달 동안 무료강의와 할인 된 강의를 자유롭게 수강할 수 있습니다.</p>
                            <a href="#" class="btn-apply">신청하기</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
