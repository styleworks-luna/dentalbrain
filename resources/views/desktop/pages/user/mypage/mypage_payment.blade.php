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
                    @forelse($data as $key => $value)
                        <li>
                            <div class="lecture-information">
                                <span
                                    class="{{ $value['students'][0]['ticket']['program']['is_online'] ? 'online' : 'offline' }}">{{ $value['students'][0]['ticket']['program']['is_online']  ? '온라인' : '오프라인' }}</span>
                                <h3 class="lecture-name">{{ $value['students'][0]['ticket']['program']['title'] }}</h3>
                            </div>
                            <table class="payment-information">
                                <tr>
                                    <th>결제금액</th>
                                    <th>결제상태</th>
                                    <th>결제수단</th>
                                    <th>결제일{{ $payment->cancel != 'null' ? "/취소일" : '' }}</th>
                                </tr>
                                <tr>
                                    <td>{{ number_format($value['totalAmount']) }}원</td>
                                    <td>{{ $value['status'] == 'DONE' ? '결제완료' : '결제취소' }}</td>
                                    <td>
                                        {{ changePaymentMethodName($value['method']) }}
                                        <a href="{{ $value['receiptUrl'] }}">결제 영수증</a>
                                    </td>
                                    <td>{{ date_format($payment->requestedAt ,'Y-m-d')}} {{ $payment->cancel != 'null'  ? '/' . date('Y-m-d',strtotime($payment->canceledAt)) : ''   }}</td>

                                </tr>
                            </table>
                        </li>
                    @empty
                        <li>결제내역이 없습니다.</li>
                    @endforelse
                </ul>
            </section>
        </div>
    </section>
@endsection
