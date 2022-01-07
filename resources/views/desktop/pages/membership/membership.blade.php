@extends('desktop.layouts.frames.basic_frame')

@section('script')
    <script src="https://js.tosspayments.com/v1"></script>
    <script type="text/javascript" src="{{ asset('js/jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/pages/agreement/agreement.js') }}"></script>
    <script>
        $(function () {
            var days;
            var price;
            var authCheck = '{{ auth()->check() }}';

            var select_menu = $('.select-menu');
            var clientKey = '{{ env('TOSS_PAYMENTS_CLIENT_KEY') }}';
            var tossPayments = TossPayments(clientKey);
            var message = getParameter('message');
            var paymentmethod = $('.payment-method:checked').val();

            // 연간 이벤트
            $('.btn-apply-yearly').click(function (e) {
                e.preventDefault();

                if (authCheck) {
                    $('.yearly-membership-hidden').slideDown();
                    $('.btn-apply-yearly').css('display', 'none');
                    $('.btn-pay-yearly').css('display', 'block');
                } else {
                    alert('로그인 후 이용해주세요.');
                    location.href = "/login";
                }
            });

            $('.btn-pay-yearly').click(function (e) {
                days = 365;
                price = 99000;
            });

            // 결제 실패시 오류 메세지 출력
            paymentMessage(message);

            // select menu
            if (select_menu.length > 0) {
                select_menu.selectmenu();
            }

            $('#refund_consent').change(function () {
                if ($('#refund_consent').is(":checked") == true) {
                    $('.refund_error_wrap').text('');
                }
            });

            $('.payment-method').change(function () {
                paymentmethod = $('.payment-method:checked').val();
            });

            $('.btn-submit').click(function (e) {
                e.preventDefault();

                var paymentMethodResult;
                var cardCompany;
                var check = false;
                var isValid;

                e.target.classList.forEach(x => {
                    if (x == 'btn-pay-yearly') {
                        return check = true;
                    }
                });

                if (check) {
                    paymentMethodResult = paymentmethod;
                    cardCompany = $('#credit-button .ui-selectmenu-text').text();
                    isValid = $('#refund_consent').is(":checked");
                }

                if (isValid) {
                    if (paymentMethodResult == "계좌입금") {
                        $('.dim').css('display', 'block');
                        $('.payment-layer-wrapper .layer').css('display', 'block');
                    } else {
                        var paymentObj;

                        const amount = price; // 1
                        const orderId = '{{ \Illuminate\Support\Str::random(3) . time() }}';
                        const orderName = `유료회원 ${days}일권` // 2
                        const customerName = '{{ auth()->user()->name ?? '' }}';
                        const successUrl = '{{ route('membership.paymentSuccess') }}' + `?days=${days}`; // 3
                        const customerEmail = '{{ auth()->user()->email ?? '' }}';
                        const customerMobilePhone = '{{ auth()->user()->phone ?? '' }}';

                        if (paymentMethodResult === '가상계좌') {
                            paymentObj = {
                                amount: amount,
                                orderId: orderId,
                                orderName: orderName,
                                customerName: customerName,
                                successUrl: successUrl,
                                failUrl: window.location.href,
                                customerEmail: customerEmail,
                                customerMobilePhone: customerMobilePhone,
                            };
                        } else if (paymentMethodResult === '카드') {
                            var maxCardInstallmentPlan = (cardCompany === 'BC' ? 3 : 12);

                            paymentObj = {
                                amount: amount,
                                orderId: orderId,
                                orderName: orderName,
                                customerName: customerName,
                                successUrl: successUrl,
                                failUrl: window.location.href,
                                customerEmail: customerEmail,
                                customerMobilePhone: customerMobilePhone,

                                maxCardInstallmentPlan: maxCardInstallmentPlan,
                                cardCompany: cardCompany,
                            };
                        } else if (paymentMethodResult === '계좌이체') {
                            paymentObj = {
                                amount: amount,
                                orderId: orderId,
                                orderName: orderName,
                                customerName: customerName,
                                successUrl: successUrl,
                                failUrl: window.location.href,
                                customerEmail: customerEmail,
                                customerMobilePhone: customerMobilePhone,
                            };
                        }

                        tossPayments.requestPayment(paymentMethodResult, paymentObj).catch(function (err) {
                            alert('결제 요청에 실패하였습니다.');
                        });
                    }
                } else {
                    $('.refund_error_wrap').text('※ 취소/환불약관에 동의해 주세요.');
                }

            });

            // 계좌입금 pop-up
            $('.payment-layer-wrapper .btn-confirm').click(function (e) {
                const attrHref = '{{ route('membership.paymentAnother') }}' + `?days=${days}`;
                $('#separate_form').attr("action", `${attrHref}`).submit();
            });

            $('.payment-layer-wrapper .btn-cancel').click(function (e) {
                $('.dim').css('display', 'none');
                $('.payment-layer-wrapper .layer').css('display', 'none');
            })
        });

        function getParameter(param) {
            var paramData = window.location.search.substr(1).split('&').filter(function (i) {
                return i.split('=')[0] == param;
            });

            return paramData.length === 0 ? null : paramData[0].split('=')[1];
        }

        function paymentMessage(message) {
            if (message) {
                alert(decodeURI(message));
            }
        }
    </script>
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
                                <img src="{{ asset('images/desktop/membership/membership_icon_01.svg') }}"
                                     alt="membership_icon_1">
                                <p>모든 강의를 1년 동안<br>
                                    특별 할인가에 수강 가능!</p>
                            </div>
                            <div class="membership-information-content-item">
                                <img src="{{ asset('images/desktop/membership/membership_icon_02.svg') }}"
                                     alt="membership_icon_2">
                                <p>유료 멤버십 회원 가입시<br>
                                    웰컴 기프트 증정!</p>
                            </div>
                            <div class="membership-information-content-item">
                                <img src="{{ asset('images/desktop/membership/membership_icon_03.svg') }}"
                                     alt="membership_icon_3">
                                <p>브레인스펙의<br>
                                    각종 행사와 특강 초대!</p>
                            </div>
                        </div>
                        <div class="membership-information-content">
                            <div class="membership-information-content-item item-wide">
                                <img src="{{ asset('images/desktop/membership/membership_icon_04.svg') }}"
                                     alt="membership_icon_4">
                                <p>브레인스펙의 치과컨설팅 등<br>
                                    치과내 원내 교육에 특별 할인 적용 가능!</p>
                            </div>
                            <div class="membership-information-content-item item-wide">
                                <img src="{{ asset('images/desktop/membership/membership_icon_05.svg') }}"
                                     alt="membership_icon_5">
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
                                <em>1년 동안 무료강의와 할인 된 강의를 자유롭게 수강</em>하실 수 있습니다.</p>
                            <div class="yearly-membership-hidden">
                                <div class="membership-payment-method">
                                    <span class=" border-line">결제방식</span>
                                    <div class="radio-wrap">
                                        <input type="radio" id="card" name="payment-method"
                                               class="payment-method" value="카드" checked>
                                        <label for="card">신용카드</label>

                                        <select name="payment-method" id="credit" class="select-menu">
                                            <option value="신한">신한</option>
                                            <option value="현대">현대</option>
                                            <option value="삼성">삼성</option>
                                            <option value="우리">우리</option>
                                            <option value="BC">BC</option>
                                            <option value="국민">국민</option>
                                            <option value="롯데">롯데</option>
                                            <option value="농협">농협</option>
                                            <option value="하나">하나</option>
                                            <option value="씨티">씨티</option>
                                            <option value="카카오뱅크">카카오뱅크</option>
                                            <option value="수협">수협</option>
                                            <option value="전북">전북</option>
                                            <option value="우체국">우체국</option>
                                            <option value="새마을">새마을</option>
                                            <option value="저축">저축</option>
                                            <option value="제주">제주</option>
                                            <option value="광주">광주</option>
                                            <option value="신협">신협</option>
                                            <option value="JCB">JCB</option>
                                            <option value="유니온페이">유니온페이</option>
                                            <option value="마스터">마스터</option>
                                            <option value="비자">비자</option>
                                            <option value="다이너스">다이너스</option>
                                            <option value="디스커버">디스커버</option>
                                        </select>
                                    </div>
                                    <div class="radio-wrap transfer-wrap">
                                        <input type="radio" id="transfer" name="payment-method"
                                               class="payment-method" value="계좌이체">
                                        <label for="transfer">{{ changePaymentMethodName("계좌이체") }}</label>
                                    </div>
                                    <div class="radio-wrap separate-wrap">
                                        <input type="radio" id="separate" name="payment-method"
                                               class="payment-method" value="계좌입금">
                                        <label for="separate"
                                               class="transfer-label">계좌입금</label>
                                        <p class="separate-tip">신한은행 140-010-094358 예금주 : ㈜브레인스펙병원교육개발원</p>
                                    </div>
                                    {{--<div class="radio-wrap">
                                        <input type="radio" id="deposit" name="payment-method"
                                               class="payment-method" value="가상계좌">
                                        <label for="deposit">무통장입금(가상계좌)</label>
                                    </div>--}}
                                    </td>
                                </div>
                                <div class="membership-agreement">
                                    <span class="border-line">신청자 동의</span>

                                    <div class="checkbox-form">
                                        <div class="checkbox-wrap">
                                            <input type="checkbox" name="refund-consent"
                                                   id="refund_consent">
                                            <label for="refund_consent"> (필수) 취소/환불약관 동의</label>
                                        </div>
                                        <a href="" class="trigger-refund">내용보기</a>
                                    </div>
                                    <div class="refund_error_wrap"></div>
                                </div>
                            </div>
                            <a href="#" class="btn-apply btn-apply-yearly">신청하기</a>
                            <a href="#" class="btn-apply btn-submit btn-pay-yearly">결제하기</a>
                        </div>
                    </div>
                </div>
                <form method="POST" id="separate_form">
                    @csrf
                </form>
            </div>
        </div>
        @include('desktop.component.popup.payment.membership_pop')
        @include('desktop.component.popup.agreement.refund')
    </section>
@endsection
