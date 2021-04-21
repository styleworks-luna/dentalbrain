@extends('mobile.layouts.frames.except_frame')

@section('script')
    <script type="text/javascript" src="{{ asset('js/pages/user/mypage-payment.js') }}"></script>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ mix('css/mobile/pages/user/mypage/mypage-payment.css') }}">
@endsection

@section('content')
    <section class="content">
        <div class="m-container">

            <section class="payment-history">
                <ul>
                    @forelse($payments as $payment)
                        <li>

                            <div class="payment-status">
                                <div class="date">
                                    <span class="@if($payment->full_response->cancels != null) payment-cancel @endif">
                                        {{ date_format($payment->requestedAt ,'Y.m.d')}}
                                    </span>

                                    {{ $payment->full_response->cancels != null  ? '/ ' . date('Y.m.d',strtotime($payment->full_response->cancels[0]->canceledAt)) : ''   }}
                                </div>
                                <div class="status">
                                    @switch($payment->status)
                                        @case('READY')
                                        @case('IN_PROGRESS')
                                        <span>진행 중</span>
                                        @break

                                        @case('WAITING_FOR_DEPOSIT')
                                        <span>입금 대기중</span>
                                        @break

                                        @case('DONE')
                                        <span>결제 완료</span>
                                        @break

                                        @case('ABORTED')
                                        <span>결제 오류</span>
                                        @break

                                        @case('CANCELED')
                                        @case('PARTIAL_CANCELED')
                                        <span class="cancel">결제 취소</span>
                                        @break

                                        @default
                                        <span>확인 중</span>
                                    @endswitch
                                </div>
                            </div>

                            <div class="information-wrap">
                                <div class="lecture-image">
                                    <img src="{{ $payment->student->ticket->program->thumbnail->url }}" alt="">
                                </div>
                                <div class="lecture-information">
                                    <h3 class="lecture-name">{{ $payment->student->ticket->program->title }}</h3>
                                    <div class="payment-information">
                                        <span>
                                            {{ changePaymentMethodName($payment->method) }}
                                        </span>
                                        <span>{{ number_format($payment->totalAmount) }}원</span>
                                    </div>
                                </div>
                            </div>

                            <div class="receipt">
                                @isset($payment->receiptUrl)
                                    @if ($payment->status == 'DONE')
                                        <a href="{{ $payment->receiptUrl }}" target="_blank">결제 영수증</a>
                                    @elseif($payment->status == 'CANCELED')
                                        <a href="{{ $payment->receiptUrl }}" target="_blank">취소 영수증</a>
                                    @endif
                                @endisset
                                @if($payment->method == '가상계좌' && $payment->status =='WAITING_FOR_DEPOSIT')
                                    <a href="" class="waiting-deposit">자세히 보기</a>
                                    <div class="deposit-detail">
                                        <p>입금 계좌 : {{ $payment->va_accountNumber }}</p>
                                        <p>예금주 : {{ $payment->va_customerName }}</p>
                                        <p>납입기한 : {{ date_format($payment->va_dueDate,'Y.m.d G:i:s') }}</p>
                                    </div>
                                @endif
                                @isset($payment->cashRe)
                                @endisset
                            </div>

                        </li>
                    @empty
                        <li class="payment-none">결제내역이 없습니다.</li>
                    @endforelse
                </ul>
            </section>
        </div>
    </section>
@endsection
