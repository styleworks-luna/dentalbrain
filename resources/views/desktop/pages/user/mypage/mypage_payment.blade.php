@extends('desktop.layouts.frames.basic_frame')

@section('script')
@endsection

@section('style')
    <link rel="stylesheet" href="{{ mix('css/desktop/pages/user/mypage-payment.css') }}">
@endsection

@section('content')
    <section class="content">
        <div class="container">
            @include('desktop.layouts.navigation.account')

            <section class="payment-history">
                <h2>결제내역</h2>
                <ul>
                    @forelse($payments as $payment)
                        <li>
                            <div class="lecture-information">
                                @if ($payment->student->ticket->program->is_online)
                                    <span class="online">'온라인'</span>
                                @else
                                    <span class="offline">오프라인</span>
                                @endif

                                <h3 class="lecture-name">{{ $payment->student->ticket->program->title }}</h3>
                            </div>
                            <table class="payment-information">
                                <tr>
                                    <th>결제금액</th>
                                    <th>결제상태</th>
                                    <th>결제수단</th>
                                    <th>결제일{{ isset($payment->cacel) ? "/취소일" : '' }}</th>
                                </tr>
                                <tr>
                                    <td>{{ number_format($payment->totalAmount) }}원</td>
                                    @switch($payment->status)
                                        @case('READY')
                                        @case('IN_PROGRESS')
                                        <td>진행 중</td>
                                        @break

                                        @case('WAITING_FOR_DEPOSIT')
                                        <td>입금 대기중</td>
                                        @break

                                        @case('DONE')
                                        <td>결제 완료</td>
                                        @break

                                        @case('ABORTED')
                                        <td>결제 오류</td>
                                        @break

                                        @case('CANCELED')
                                        @case('PARTIAL_CANCELED')
                                        <td>결제 취소</td>
                                        @break

                                        @default
                                        <td>확인 중</td>
                                    @endswitch
                                    <td>
                                        {{ changePaymentMethodName($payment->method) }}
                                        {{--TODO: 디자인 필요.--}}
                                        @if($payment->method == '가상계좌' && $payment->status =='WAITING_FOR_DEPOSIT')
                                            <p>입금 계좌 : {{ $payment->va_accountNumber }}</p>
                                            <p>예금주 : {{ $payment->va_customerName }}</p>
                                            <p>납입기한 : {{ date_format($payment->va_dueDate,'Y-m-d G:i:s') }}</p>
                                        @endif
                                        @isset($payment->receiptUrl)
                                            @if($payment->status == 'CANCELED')
                                                <a href="{{ $payment->receiptUrl }}">취소 결제 영수증</a>
                                            @else
                                                <a href="{{ $payment->receiptUrl }}">결제 영수증</a>
                                            @endif

                                        @endisset

                                    </td>
                                    <td>{{ date_format($payment->requestedAt ,'Y-m-d')}} {{ $payment->cancel ? '/' . date_format($payment->cancel->canceledAt,'Y-m-d') : ''   }}</td>
                                </tr>
                            </table>
                        </li>
                    @empty
                        <li class="payment-none">결제내역이 없습니다.</li>
                    @endforelse
                </ul>
            </section>
        </div>
    </section>
@endsection
