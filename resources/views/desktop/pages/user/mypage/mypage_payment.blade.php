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
                @foreach($data as $key => $value)
                    <ul>
                        <li>
                            <div class="lecture-information">
                                <span class="online">{{ $value['ticket']['program']['is_online']  ? '온라인' : '오프라인' }}</span>
                                <h3 class="lecture-name">{{ $value['ticket']['name'] }}</h3>
                            </div>
                            <table class="payment-information">
                                <tr>
                                    <th>결제금액</th>
                                    <th>결제상태</th>
                                    <th>결제수단</th>
                                    <th>결제일{{ isset($value['payment']['deleted_at']) ? "/취소일" : '' }}</th>
                                </tr>
                                <tr>
                                    <td>{{ $value['payment']['totalAmount'] }}원</td>
                                    <td>{{ $value['payment']['status'] == 'DONE' ? '결제완료' : '결제취소' }}</td>
                                    <td>
                                        {{ $value['payment']['method'] }}
                                        <a href="{{ $value['payment']['receiptUrl'] }}">결제 영수증</a>
                                    </td>
                                    <td>{{ date('Y-m-d',strtotime($value['payment']['created_at'])) }} {{ isset($value['payment']['deleted_at']) ? '/'.date('Y-m-d',strtotime($value['payment']['deleted_at'])) : ''   }}</td>
                                </tr>
                            </table>
                        </li>
                    </ul>
                @endforeach
            </section>
        </div>
    </section>
@endsection
