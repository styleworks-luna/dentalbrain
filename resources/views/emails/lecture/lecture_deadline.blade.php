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
                강의 신청 마감 D-3 안내
            </h4>
        </td>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td width="720" height="75" style="padding-top: 30px; padding-bottom: 30px">
            <p style="line-height: 24px; margin: 0 0 0 20px; font-size: 12px;">
                <b>{{ $user->name }}</b>님! 시청중이신 강의가 3일 후에 종료됩니다.
            </p>
        </td>
    </tr>
    <tr>
        <td>
            <p style="line-height: 15px; margin: 0; padding-bottom: 10px; border-bottom: 2px solid #9b00d8; font-size: 15px; font-weight: bold; color: #333;">
                강의 안내
            </p>
            <table align="center" width="720" border="0" cellpadding="0" cellspacing="0"
                   style="border-collapse: collapse">
                <tbody>
                <tr>
                    <th align="left" colspan="1" rowspan="1" valign="top" width="150"
                        style="line-height: 24px; padding: 8px 0 8px 20px;font-size: 12px; font-weight: bold; color: #333333; letter-spacing: -1px;">
                        신청강의
                    </th>
                    <td width="570"
                        style="line-height: 24px; padding: 8px 0 8px 20px; font-size: 12px; color: #333;">
                        <p style="float: left; max-width: 520px; margin: 0 10px 0 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            {{ $program['title'] }}
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
                덴탈브레인과 함께 하신 강의 시청 시간이 얼마 남지 않았습니다.<br>
                아직 부족한 부분이 있다면 남은 시간을 충분히 활용하여 수강하시기 바랍니다.<br>
                강의 후기를 남겨주신 고객님에게는 감사의 혜택이 있으니 꼭 참여하시기 바랍니다.<br>
            </p>
        </td>
    </tr>
    <tr>
        <td height="70"></td>
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
