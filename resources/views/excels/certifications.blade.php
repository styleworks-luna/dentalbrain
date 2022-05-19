<table>
    <thead>
    <tr>
        <td>번호</td>
        <td>구분</td>
        <td>아이디</td>
        <td>이름</td>
        <td>이메일</td>
        <td>연락처</td>
        <td>생년월일</td>
        <td>대학교</td>
        <td>학번</td>
        <td>점수</td>
        <td>합격여부</td>
        <td>증명서 발급 상태</td>
    </tr>
    </thead>
    <tbody>
    @foreach($profiles as $profile)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $profile->type }}</td>
            <td>{{ $profile->login_id }}</td>
            <td>{{ $profile->name }}</td>
            <td>{{ $profile->email }}</td>
            <td>{{ $profile->phone }}</td>
            <td>{{ \Carbon\Carbon::parse($profile->birthday)->format('Y-m-d') }}</td>
            <td>{{ $profile->university ?? '없음' }}</td>
            <td>{{ $profile->student_number ?? '없음' }}</td>
            <td>{{ $profile->score }}</td>
            <td>
                @switch($profile->status)
                    @case(\App\Traits\HasCertificateStatus::$DO_NOT_PAID)
                    결제 전
                    @break
                    @case(\App\Traits\HasCertificateStatus::$WAITING)
                    대기 중
                    @break
                    @case(\App\Traits\HasCertificateStatus::$PASS)
                    합격
                    @break
                    @case(\App\Traits\HasCertificateStatus::$FAILED)
                    불합격
                    @break
                    @default
                    ERROR
                @endswitch
            </td>
            <td>
                {{ $profile->is_issued ? '발급' : '미발급' }}
            </td>
        </tr>
    @endforeach
    </tbody>

</table>
