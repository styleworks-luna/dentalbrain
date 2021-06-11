<table>
    <thead>
    <tr>
        <th>번호</th>
        <th>아이디</th>
        <th>이름</th>
        <th>이메일 주소</th>
        <th>전화번호</th>
        <th>직업군</th>
        <th>자격 번호</th>
        <th>이메일 수신동의</th>
        <th>sms 수신동의</th>
        <th>유료회원 시작일</th>
        <th>유료회원 종료일</th>
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
            <td>
                @isset($user->job)
                    {{ $user->job->license_num ?? '' }}
                @else
                    {{ '' }}
                @endisset
            </td>
            <td>
                {{ $user->allow_email ? 'Y' : 'N' }}
            </td>
            <td>
                {{ $user->allow_sms ? 'Y' : 'N' }}
            </td>
            <td>
                {{ $user->getMembershipStartedAt() }}
            </td>
            <td>
                {{ $user->getMembershipExpiredAt() }}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
