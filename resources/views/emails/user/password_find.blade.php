<table align="center" width="720" border="0" cellpadding="0" cellspacing="0"
       style="font-family: 'Malgun Gothic', Dotum, '돋움', sans, sans-serif; border-collapse: collapse">
    <thead>
    <tr>
        <td width="720" height="60">
            <img src="{{ asset('images/desktop/global/logo.png') }}" style="display: block; margin-bottom: 10px; border: 0;" width="100" height="70">
        </td>
    </tr>
    <tr>
        <td width="720" height="100" bgcolor="#9b00d8">
            <h4 style="line-height: 100px; margin: 0; padding: 0 0 0 30px; font-size: 26px; font-weight: bold; color: #ffffff; letter-spacing: -1px">
                비밀번호 찾기
            </h4>
        </td>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td width="720" height="75" style="padding-top: 30px; padding-bottom: 30px">
            <p style="line-height: 24px; margin: 0 0 0 20px; font-size: 12px;">
                <b>{{ $user->name }}</b>님의 비밀번호 요청입니다.<br>
                <b>{{ $user->name }}</b>님의 비밀번호는 <b style="font-size: 14px;">{{ $newPassword }}</b>입니다.<br>
                임시비밀 번호이므로 마이페이지 회원정보 변경에서 비밀번호를 변경해 주시기 바랍니다.
            </p>
        </td>
    </tr>
    <tr>
        <td>
            <p style="line-height: 15px; margin: 50px 0 0; padding-bottom: 10px; border-bottom: 2px solid #9b00d8; font-size: 15px; font-weight: bold; color: #333;">
                안내 사항
            </p>
            <p style="line-height: 21px; margin: 20px 0; padding-left: 20px; font-size: 12px; color: #333;">
                · 임시 비밀번호 입니다.<br/>
                · 회원정보 변경 페이지에서 비밀번호를 변경해 이용해 주시기 바랍니다.
            </p>
        </td>
    </tr>
    <tr>
        <td height="70"></td>
    </tr>
    <tr>
        <td style="line-height: 15px; padding: 23px 0 29px 30px; font-size: 12px; color: #666; background-color: #efefef">
            <h4 style="float: left; margin: 6px 22px 0 0">
                <img src="{{ asset('images/desktop/global/logo.png') }}" alt="덴탈브레인" width="90" height="25">
            </h4>
            <p style="float: left; margin: 0; padding: 0; line-height: 24px">
                서울특별시 서초구 효령로 140 (방배동,3층) / 070-8222-3179<br>
                copyright © BRAINSPEC. ALL RIGHTS RESERVED
            </p>
        </td>
    </tr>
    </tbody>
</table>
