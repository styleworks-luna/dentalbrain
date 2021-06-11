<table>
    <thead>
    <tr>
        <th>번호</th>
        <th>구분</th>
        <th>제목</th>
        <th>이름</th>
        <th>이메일 주소</th>
        <th>금액</th>
        <th>결제수단</th>
        <th>상태</th>
        <th>신청 시간</th>
        <th>결제 시간</th>
    </tr>
    </thead>
    <tbody>
    @foreach($payments as $payment)
        <tr>
            <td>{{ $payment->id }}</td>
            <td>
                @if ($payment->is_online === 1)
                    온라인
                @elseif ($payment->is_online === 0)
                    오프라인
                @else
                    유료회원
                @endif
            </td>
            <td>
                @isset ($payment->title)
                    {{ $payment->title }}
                @else
                    유료회원 결제
                @endisset
            </td>
            <td>{{ $payment->name }}</td>
            <td>{{ $payment->email }}</td>
            <td>{{ number_format($payment->totalAmount) }}</td>
            <td>{{ changePaymentMethodName($payment->method) }}</td>
            <td>{{ changePaymentStatusName($payment->status) }}</td>
            <td>{{ date('Y.m.d H:i:s',strtotime($payment->requestedAt)) }}</td>
            <td>
                @isset ($payment->approvedAt)
                    {{ date('Y.m.d H:i:s',strtotime($payment->approvedAt)) }}
                @else
                    결제 대기중
                @endisset
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
