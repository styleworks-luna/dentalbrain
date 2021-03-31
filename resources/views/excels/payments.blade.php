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
        <th>등록시간</th>
    </tr>
    </thead>
    <tbody>
        @foreach($payments as $payment)
        <tr>
            <td>{{ $payment->id }}</td>
            <td>{{ $payment->student->ticket->program->is_online ? '온라인' : '오프라인'}}</td>
            <td>{{ $payment->student->ticket->program->title }}</td>
            <td>{{ $payment->student->user->name }}</td>
            <td>{{ $payment->student->user->email }}</td>
            <td>{{ number_format($payment->totalAmount) }}</td>
            <td>{{ changePaymentMethodName($payment->method) }}</td>
            <td>{{ changePaymentStatusName($payment->status) }}</td>
            <td>{{ date('Y.m.d',strtotime($payment->requestedAt)) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
