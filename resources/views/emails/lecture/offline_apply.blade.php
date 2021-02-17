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
                오프라인 강의 신청 안내
            </h4>
        </td>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td width="720" height="75" style="padding-top: 30px; padding-bottom: 30px">
            <p style="line-height: 24px; margin: 0 0 0 20px; font-size: 12px;">
                <b>{{ $user->name }}</b>님의 <b>{{ $program[0]['title']  }}</b> 강의 신청이 완료되었습니다.<br>
                마이페이지 신청한 강의에서 확인 가능합니다.
            </p>
        </td>
    </tr>
    <tr>
        <td>
            <p style="line-height: 15px; margin: 0; padding-bottom: 10px; border-bottom: 2px solid #9b00d8; font-size: 15px; font-weight: bold; color: #333;">
                신청 내역
            </p>
            <table align="center" width="720" border="0" cellpadding="0" cellspacing="0"
                   style="border-collapse: collapse">
                <tbody>
                <tr>
                    <th align="left" colspan="1" rowspan="1" valign="top" width="150" bgcolor="#f8f8f8"
                        style="line-height: 24px; padding: 8px 0 8px 20px; border-bottom: 1px solid #d8d8d8;font-size: 12px; font-weight: bold; color: #333333; letter-spacing: -1px;">
                        강의명
                    </th>
                    <td width="570"
                        style="line-height: 24px; padding: 8px 0 8px 20px; border-bottom: 1px solid #d8d8d8; font-size: 12px;color: #333;">
                        <p style="float: left; max-width: 520px; margin: 0 10px 0 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            {{ $program[0]['title'] }}
                        </p>
                    </td>
                </tr>
                <tr>
                    <th align="left" colspan="1" rowspan="1" valign="top" width="150" bgcolor="#f8f8f8"
                        style="line-height: 24px; padding: 8px 0 8px 20px; border-top: 1px solid #d8d8d8; border-bottom: 1px solid #d8d8d8;font-size: 12px; font-weight: bold; color: #333333; letter-spacing: -1px;">
                        강의시간
                    </th>
                    <td width="570"
                        style="line-height: 24px; padding: 8px 0 8px 20px; border-top: 1px solid #d8d8d8;  border-bottom: 1px solid #d8d8d8; font-size: 12px; color: #333;">
                        <p style="float: left; max-width: 520px; margin: 0 10px 0 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            {{ $program[0]['place']['korean_time'] }}
                        </p>
                    </td>
                </tr>
                <tr>
                    <th align="left" colspan="1" rowspan="1" valign="top" width="150" bgcolor="#f8f8f8"
                        style="line-height: 24px; padding: 8px 0 8px 20px; border-top: 1px solid #d8d8d8; border-bottom: 1px solid #d8d8d8;font-size: 12px; font-weight: bold; color: #333333; letter-spacing: -1px;">
                        강의장소
                    </th>
                    <td width="570"
                        style="line-height: 24px; padding: 8px 0 8px 20px; border-top: 1px solid #d8d8d8;  border-bottom: 1px solid #d8d8d8; font-size: 12px; color: #333;">
                        <p style="float: left; max-width: 520px; margin: 0 10px 0 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            {{ $program[0]['place']['full_address'] }}
                        </p>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <p style="line-height: 15px; margin: 50px 0 0; padding-bottom: 10px; border-bottom: 2px solid #9b00d8; font-size: 15px; font-weight: bold; color: #333;">
                안내 사항
            </p>
            <p style="line-height: 21px; margin: 20px 0; padding-left: 20px; font-size: 12px; color: #333;">
                · 강의 장소와 강의 시간에 유의하여 주시기바랍니다.
            </p>
        </td>
    </tr>
    <tr>
        <td height="70"></td>
    </tr>
    <tr>
        <td style="line-height: 15px; padding: 23px 0 29px 30px; font-size: 12px; color: #666; background-color: #efefef">
            <h4 style="float: left; margin: 6px 22px 0 0">
                <img src="{{ asset('images/desktop/global/logo.png') }}" alt="bics" width="90" height="25">
            </h4>
            <p style="float: left; margin: 0; padding: 0; line-height: 24px">
                서울특별시 서초구 효령로 140 (방배동,3층) / 070-8222-3179<br>
                copyright © BRAINSPEC. ALL RIGHTS RESERVED
            </p>
        </td>
    </tr>
    </tbody>
</table>
