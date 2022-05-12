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
        </tr>
    @endforeach
    </tbody>

</table>
