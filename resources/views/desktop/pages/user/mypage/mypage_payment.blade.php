@extends('desktop.layouts.frames.basic_frame')

@section('script')
    <script type="text/javascript" src="{{ asset('js/pages/user/mypage-payment.js') }}"></script>
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
                        {{--강의 결제인경우--}}
                        @isset ($payment->student)
                            <li>
                                <div class="lecture-information">
                                    @if ($payment->student->program->is_online)
                                        <span class="online">온라인</span>
                                    @else
                                        <span class="offline">오프라인</span>
                                    @endif

                                    <h3 class="lecture-name">{{ $payment->student->program->title }}</h3>
                                </div>
                                <table class="payment-information">
                                    <tr>
                                        <th>결제금액</th>
                                        <th>결제상태</th>
                                        <th>결제수단</th>
                                        <th>결제일{{ $payment->cancel != 'null' ? "/취소일" : '' }}</th>
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
                                        <td>
                                            {{ changePaymentMethodName($payment->method) }}
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
                                                    <p>입금 계좌 : 신한은행 140-010-094358 </p>
                                                    <p>예금주 : (주)브레인스펙병원교육개발원</p>
                                                </div>
                                            @elseif($payment->method == '계좌입금' && ($payment->status == 'DONE' || $payment->status == 'ANOTHER_DONE'))
                                                <span class="tip">(영수증 관리자 문의)</span>
                                            @endif
                                            @isset($payment->receiptUrl)
                                                @if ($payment->status == 'DONE')
                                                    <a href="{{ $payment->receiptUrl }}" target="_blank">결제 영수증</a>
                                                @elseif($payment->status == 'CANCELED')
                                                    <a href="{{ $payment->receiptUrl }}" target="_blank">취소 영수증</a>
                                                @endif
                                            @endisset
                                        </td>
                                        <td>
                                            <div
                                                class="@isset($payment->full_response->cancels) payment-cancel @endisset">
                                                {{ date_format($payment->requestedAt ,'Y.m.d')}}
                                            </div>

                                            @isset($payment->full_response->cancels)
                                                {{'/ ' . date('Y.m.d',strtotime($payment->full_response->cancels[0]->canceledAt))}}
                                            @endisset
                                        </td>
                                    </tr>
                                </table>
                            </li>
                        @endisset
                        {{--멤버십 결제인 경우--}}
                        @isset($payment->membership)
                            <li>
                                <div class="lecture-information">
                                    <span class="membership">유료회원</span>
                                    <h3 class="lecture-name"> 유료회원 {{ $payment->membership->applied_days }}일권</h3>
                                </div>
                                <table class="payment-information">
                                    <tr>
                                        <th>결제금액</th>
                                        <th>결제상태</th>
                                        <th>결제수단</th>
                                        <th>결제일{{ $payment->cancel != 'null' ? "/취소일" : '' }}</th>
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
                                        <td>
                                            {{ changePaymentMethodName($payment->method) }}
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
                                                    <p>입금 계좌 : 신한은행 140-010-094358 </p>
                                                    <p>예금주 : (주)브레인스펙병원교육개발원</p>
                                                </div>
                                            @elseif($payment->method == '계좌입금' && ($payment->status == 'DONE' || $payment->status == 'ANOTHER_DONE'))
                                                <span class="tip">(영수증 관리자 문의)</span>
                                            @endif
                                            @isset($payment->receiptUrl)
                                                @if ($payment->status == 'DONE')
                                                    <a href="{{ $payment->receiptUrl }}" target="_blank">결제 영수증</a>
                                                @elseif($payment->status == 'CANCELED')
                                                    <a href="{{ $payment->receiptUrl }}" target="_blank">취소 영수증</a>
                                                @endif
                                            @endisset
                                        </td>
                                        <td>
                                            <div
                                                class="@isset($payment->full_response->cancels) payment-cancel @endisset">
                                                {{ date_format($payment->requestedAt ,'Y.m.d')}}
                                            </div>

                                            @isset($payment->full_response->cancels)
                                                {{'/ ' . date('Y.m.d',strtotime($payment->full_response->cancels[0]->canceledAt))}}
                                            @endisset
                                        </td>
                                    </tr>
                                </table>
                            </li>
                        @endisset
                    @empty
                        <li class="payment-none">결제내역이 없습니다.</li>
                    @endforelse
                </ul>
                <div class="paging-wrap">
                    {{ $payments->links() }}
                </div>
            </section>
        </div>
    </section>
@endsection
