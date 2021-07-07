<table>
    <thead>
    <tr>
        <th>번호</th>
        <th>아이디</th>
        <th>이름</th>
        <th>이메일</th>
        <th>전화번호</th>
        <th>직업군</th>
        <th>종료일</th>
        <th>결제수단</th>
        <th>상태</th>
    </tr>
    </thead>
    <tbody>
    @foreach($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->login_id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->phone }}</td>
            <td>{{ $user->job_name }}</td>
            @isset($user->memberships[0])
                <td>
                    {{ $user->memberships[0]->started_at ?? '결제 전'}}
                </td>
                <td>
                    {{ $user->memberships[0]->expired_at ?? '결제 전'}}
                </td>
                <td>
                    {{ $user->memberships[0]->payment->method ?? '관리자등록'}}
                </td>

                <td>
                    @if($user->memberships[0]->started_at > now())
                        사용 전
                    @else
                        @if ($user->memberships[0]-> expired_at < now())
                            사용 후
                        @else
                            사용 중
                        @endif
                    @endif
                </td>
            @else
                <td>종료</td>
                <td>종료</td>
                <td>종료</td>
            @endisset

        </tr>
    @endforeach
    </tbody>
</table>
