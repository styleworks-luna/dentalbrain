<table>
    <thead>
    <tr>
        <th>번호</th>
        <th>아이디</th>
        <th>이름</th>
        <th>이메일 주소</th>
        <th>전화번호</th>
        <th>직업군</th>
        <th>시작일</th>
        <th>종료일</th>
        <th>결제수단</th>
        <th>상태</th>
    </tr>
    </thead>
    <tbody>
    @foreach($memberships as $membership)
        <tr>
            <td>{{ $membership->id }}</td>
            <td>{{ $membership->user->login_id }}</td>
            <td>{{ $membership->user->name }}</td>
            <td>{{ $membership->user->email }}</td>
            <td>{{ $membership->user->phone }}</td>
            <td>{{ $membership->user->job_name }}</td>
            <td>
                @if($membership->started_at == null)
                    결제 전
                @else
                    {{ $membership->started_at }}
                @endif
            </td>
            <td>
                @if($membership->expired_at == null)
                    결제 전
                @else
                    {{ $membership->expired_at }}
                @endif
            </td>
            <td>
                {{ $membership->payment->method }}
            </td>
            <td>
                @if ($membership->started_at == null || $membership->expired_at == null)
                    결제 전
                @else
                    @if($membership->started_at > now())
                        사용 전
                    @else
                        @if ($membership->expired_at < now())
                            사용 후
                        @else
                            사용 중
                        @endif
                    @endif
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
