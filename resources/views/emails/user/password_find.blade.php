<table align="center" width="720" border="0" cellpadding="0" cellspacing="0"
       style="font-family: 'Malgun Gothic', Dotum, '돋움', sans, sans-serif; border-collapse: collapse">
    <thead>
    <tr>
        <td width="720" height="60">
            <img src="{{ asset('images/desktop/global/logo.png') }}" style="display: block; margin-left: 20px; margin-bottom: 10px; border: 0;" width="100" height="70">
        </td>
    </tr>
    <tr>
        <td width="720" height="100" bgcolor="#9b00d8">
            <h4 style="line-height: 100px; margin: 0; padding: 0 0 0 30px; font-size: 26px; font-weight: bold; color: #ffffff; letter-spacing: -1px">
                비밀번호 재설정 안내입니다.
            </h4>
        </td>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td width="720" height="40" style="padding-top: 30px; padding-bottom: 30px">
            <p style="line-height: 24px; margin: 0 0 0 20px; font-size: 12px;">
                <b>{{ $user->name }}</b>님! 사용하실 비밀번호 재설정 안내입니다.
            </p>
        </td>
    </tr>
    <tr>
        <td height="120" align="center">
            <b>{{ $user->name }}</b>님의 비밀번호는 <b>{{ $newPassword }}</b>입니다.
        </td>
    </tr>
    <tr>
        <td height="70" >
            <p style="line-height: 24px; margin: 0 0 0 20px; font-size: 12px;">
                덴탈브레인은 절대 비밀번호를 요구하지 않습니다.<br>
                만일 원치 않는 비밀번호 재설정 안내 메일을 수신하셨다면 ‘관리자＇에게 문의 바랍니다.
            </p>
        </td>
    </tr>
    <tr>
        <td style="line-height: 15px; padding: 23px 0 29px 30px; font-size: 12px; color: #666; background-color: #efefef">
            <h4 style="float: left; margin: 6px 22px 0 0"><img src="{{ asset('images/desktop/global/logo.png') }}" style="margin-top: 30px; margin-right: 20px;" alt="덴탈브레인" width="90" height="25"></h4>
            <p style="float: left; margin: 0; padding: 0; line-height: 24px">
                상호 : 주식회사 브레인스펙병원교육개발원  |  대표 : 김민정<br>
                등록번호 : 114-87-09709  |  통신판매업 신고번호 : 제 2013-서울서초-1488 호<br>
                사업장 소재지 : 서울특별시 서초구 효령로 140 (방배동,3층)  |  TEL : 070-8222-3179<br>
                © BRAINSPEC. ALL RIGHTS RESERVED
            </p>
        </td>
    </tr>
    </tbody>
</table>
