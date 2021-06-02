@extends('desktop.layouts.frames.basic_frame')

@section('script')
    <script src="https://js.tosspayments.com/v1"></script>
    <script type="text/javascript" src="{{ asset('js/jquery-ui.min.js') }}"></script>
    <script>
        $(function () {
            // select menu
            var select_menu = $('.select-menu');
            var clientKey = '{{ env('TOSS_PAYMENTS_CLIENT_KEY') }}';
            var tossPayments = TossPayments(clientKey);
            var message = getParameter('message');
            var paymentmethod = $('.payment-method:checked').val();

            // 결제 실패시 오류 메세지 출력
            paymentMessage(message);

            if (select_menu.length > 0) {
                select_menu.selectmenu();
            }

            $('.payment-method').change(function () {
                paymentmethod = $('.payment-method:checked').val();
            });

            $('.btn-submit').click(function (e) {
                e.preventDefault();
                if (paymentmethod == "계좌입금") {
                    $('.dim').css('display', 'block');
                    $('.payment-layer-wrapper .layer').css('display', 'block');
                } else {
                    var paymentObj;
                    var cardCompany = $('.ui-selectmenu-text').text();

                    const amount = {{ \App\Models\Membership::$PriceMap[$days] }};
                    const orderId = '{{ \Illuminate\Support\Str::random(3) . time() }}';
                    const orderName = '유료회원 {{ $days }}일권';
                    const customerName = '{{ auth()->user()->name }}';
                    const successUrl = '{{ route('membership.paymentSuccess',['days' => $days]) }}';
                    const customerEmail = '{{ auth()->user()->email }}';
                    const customerMobilePhone = '{{ auth()->user()->phone }}';

                    if (paymentmethod === '가상계좌') {
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
                    } else if (paymentmethod === '카드') {
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
                    } else if (paymentmethod === '계좌이체') {
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

                    tossPayments.requestPayment(paymentmethod, paymentObj).catch(function (err) {
                        alert('취소');
                    });
                }
            });

            // 계좌입금 pop-up
            $('.payment-layer-wrapper .btn-confirm').click(function (e) {
                $('#separate_form').submit();
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
        <div class="membership-payment">
            <div class="membership-payment-method">
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
                <div class="radio-wrap">
                    <input type="radio" id="transfer" name="payment-method"
                           class="payment-method" value="계좌이체">
                    <label for="transfer">{{ changePaymentMethodName("계좌이체") }}</label>
                </div>
                <div class="radio-wrap">
                    <div style="overflow: hidden">
                        <input type="radio" id="separate" name="payment-method"
                               class="payment-method" value="계좌입금">
                        <label for="separate"
                               class="transfer-label">계좌입금</label>
                    </div>
                    <p class="separate-tip">신한은행 140-010-094358 예금주 : ㈜브레인스펙병원교육개발원</p>
                </div>
                {{--<div class="radio-wrap">
                    <input type="radio" id="deposit" name="payment-method"
                           class="payment-method" value="가상계좌">
                    <label for="deposit">무통장입금(가상계좌)</label>
                </div>--}}
                </td>
            </div>
            <section class="btn-wrap">
                <button type="button" class="btn-confirm btn-submit">결제하기</button>
                <a href="{{ url()->previous() }}" class="btn-confirm btn-cancel">취소하기</a>
            </section>
            <form action="{{ route('membership.paymentAnother',['days' => $days]) }}" method="POST" id="separate_form">
                @csrf
            </form>
        </div>
        @include('desktop.component.popup.payment.payment_pop')
    </section>
@endsection
