@extends('desktop.layouts.frames.simple_frame')

@section('script')
    <script src="https://js.tosspayments.com/v1"></script>
    <script type="text/javascript" src="{{ asset('js/jquery-ui.min.js') }}"></script>

    <script>
        $(function () {
            // select menu
            var select_menu = $('.select-menu');
            var clientKey = '{{ env('TOSS_PAYMENTS_CLIENT_KEY') }}';
            var tossPayments = TossPayments(clientKey);
            var message = 'msg';

            if (select_menu.length > 0) {
                select_menu.selectmenu();
            }

            $('.btn-payment').click(function (e) {
                var paymentObj;
                var cardCompany = $('.ui-selectmenu-text').text();
                var paymentMethod = $('.payment-method:checked').val();

                const amount = '';
                const orderId = '{{ \Illuminate\Support\Str::random(3) . time() }}';
                const orderName = '';
                const customerName = '{{ auth()->user()->name }}';
                const successUrl = '';
                const customerEmail = '{{ auth()->user()->email }}';
                const customerMobilePhone = '{{ auth()->user()->phone }}';

                e.preventDefault();

                if (paymentMethod === '가상계좌') {
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
                } else if (paymentMethod === '카드') {
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
                } else if (paymentMethod === '계좌이체') {
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

                tossPayments.requestPayment(paymentMethod, paymentObj).catch(function (err) {
                    alert('취소');
                });
            });
        });
        </script>
@endsection

@section('style')

@endsection

@section('content')
    <section id="content">
        <section class="membership-register">
            <div class="container">
                <h1>유료회원 가입</h1>

                <div class="payment-form-wrap">
                    <div class="radio-wrap">
                        <input type="radio" id="card" name="payment-method"
                               class="payment-method" value="카드" checked>
                        <label for="card" class="card-label">신용카드</label>
                    </div>
                    <div class="radio-wrap">
                        <input type="radio" id="transfer" name="payment-method"
                               class="payment-method" value="계좌이체">
                        <label for="transfer"
                               class="transfer-label">{{ changePaymentMethodName("계좌이체") }}</label>
                    </div>
                </div>

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
                <button class="btn-payment">결제하기</button>
            </div>
        </section>
    </section>
@endsection
