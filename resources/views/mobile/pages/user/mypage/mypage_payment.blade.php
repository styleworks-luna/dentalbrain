@extends('mobile.layouts.frames.except_frame')

@section('script')
    <script type="text/javascript" src="{{ asset('js/pages/user/mypage-payment.js') }}"></script>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ mix('css/mobile/pages/user/mypage/mypage-payment.css') }}">
@endsection

@section('title')
    <a href="" class="btn-back"></a>
    <h1>결제내역</h1>
@endsection

@section('content')
    <section class="content">
        <div class="m-container">

            <section class="payment-history">
                <ul>
                    @forelse($payments as $payment)
                        @isset($payment->student)
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
                                            <td>진행 중</td>
                                            @break

                                            @case('WAITING_FOR_DEPOSIT')
                                            <td>입금 대기중</td>
                                            @break

                                            @case('DONE')
                                            @case('ANOTHER_DONE')
                                            <td>결제 완료</td>
                                            @break

                                            @case('ABORTED')
                                            <td>결제 오류</td>
                                            @break

                                            @case('CANCELED')
                                            @case('PARTIAL_CANCELED')
                                            <td class="cancel">결제 취소</td>
                                            @break

                                            @case('ANOTHER_PROGRESS')
                                            <td>입금 대기</td>
                                            @break

                                            @case('ANOTHER_REJECTED')
                                            <td>신청 취소</td>
                                            @break

                                            @default
                                            <td>확인 중</td>
                                        @endswitch
                                    </div>
                                </div>

                                <div class="information-wrap">
                                    <div class="lecture-image">
                                        @isset($payment->student)
                                            <img src="{{ $payment->student->program->thumbnail->url }}" alt="">
                                        @else
                                            <img src="" alt="">
                                        @endisset

                                    </div>
                                    <div class="lecture-information">
                                        <h3 class="lecture-name">{{ $payment->student->program->title }}</h3>
                                        <div class="payment-information">
                                        <span class="payment-method">
                                            {{ changePaymentMethodName($payment->method) }}
                                        </span>
                                            <span
                                                class="payment-price">{{ number_format($payment->totalAmount) }}원</span>
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
                                    @elseif($payment->method == '계좌입금' && $payment->status == 'ANOTHER_PROGRESS')
                                        <a href="" class="waiting-deposit">자세히 보기</a>
                                        <div class="deposit-detail">
                                            <p>신한은행 140-010-094358 </p>
                                            <p>예금주 (주)브레인스펙병원교육개발원</p>
                                        </div>
                                    @elseif($payment->method == '계좌입금' && ($payment->status == 'DONE' || $payment->status == 'ANOTHER_DONE'))
                                        <p class="tip">영수증 관리자 문의</p>
                                    @endif
                                </div>

                            </li>
                        @endisset
                        @isset($payment->membership)
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
                                            <td>진행 중</td>
                                            @break

                                            @case('WAITING_FOR_DEPOSIT')
                                            <td>입금 대기중</td>
                                            @break

                                            @case('DONE')
                                            @case('ANOTHER_DONE')
                                            <td>결제 완료</td>
                                            @break

                                            @case('ABORTED')
                                            <td>결제 오류</td>
                                            @break

                                            @case('CANCELED')
                                            @case('PARTIAL_CANCELED')
                                            <td class="cancel">결제 취소</td>
                                            @break

                                            @case('ANOTHER_PROGRESS')
                                            <td>입금 대기</td>
                                            @break

                                            @case('ANOTHER_REJECTED')
                                            <td>신청 취소</td>
                                            @break

                                            @default
                                            <td>확인 중</td>
                                        @endswitch
                                    </div>
                                </div>

                                <div class="information-wrap">
                                    <div class="lecture-information">
                                        <h3 class="lecture-name">유료회원 {{ $payment->membership->applied_days }}일권</h3>
                                        <div class="payment-information">
                                        <span class="payment-method">
                                            {{ changePaymentMethodName($payment->method) }}
                                        </span>
                                            <span
                                                class="payment-price">{{ number_format($payment->totalAmount) }}원</span>
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
                                    @elseif($payment->method == '계좌입금' && $payment->status == 'ANOTHER_PROGRESS')
                                        <a href="" class="waiting-deposit">자세히 보기</a>
                                        <div class="deposit-detail">
                                            <p>신한은행 140-010-094358 </p>
                                            <p>예금주 (주)브레인스펙병원교육개발원</p>
                                        </div>
                                    @elseif($payment->method == '계좌입금' && ($payment->status == 'DONE' || $payment->status == 'ANOTHER_DONE'))
                                        <p class="tip">영수증 관리자 문의</p>
                                    @endif
                                </div>
                            </li>
                        @endisset
                    @empty
                        <li class="payment-none">결제내역이 없습니다.</li>
                    @endforelse
                </ul>
            </section>
        </div>
    </section>
@endsection
