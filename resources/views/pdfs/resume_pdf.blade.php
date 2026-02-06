<html>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<style>
    html, body, div, span, applet, object, iframe,
    h1, h2, h3, h4, h5, h6, p, blockquote, pre,
    a, abbr, acronym, address, big, cite, code,
    del, dfn, em, img, ins, kbd, q, s, samp,
    small, strike, strong, sub, sup, tt, var,
    b, u, i, center,
    dl, dt, dd, ol, ul, li,
    fieldset, form, label, legend,
    table, caption, tbody, tfoot, thead, tr, th, td,
    article, aside, canvas, details, embed,
    figure, figcaption, footer, header, hgroup,
    menu, nav, output, ruby, section, summary,
    time, mark, audio, video {
        margin: 0;
        padding: 0;
        border: 0;
        font-size: 14px;
        font-weight: normal;
        vertical-align: baseline;
    }

    /* HTML5 display-role reset for older browsers */
    article, aside, details, figcaption, figure,
    footer, header, hgroup, menu, nav, section {
        display: block;
    }

    body {
        line-height: 1;
    }

    ol, ul {
        list-style: none;
    }

    blockquote, q {
        quotes: none;
    }

    blockquote:before, blockquote:after,
    q:before, q:after {
        content: '';
        content: none;
    }

    table {
        border-collapse: collapse;
        border-spacing: 0;
    }
</style>
<style>
    @font-face {
        font-family: "SourceHanSansKR";
        font-weight: normal;
        src: url('fonts/SourceHanSansKR-Regular.otf');
    }

    @font-face {
        font-family: "SourceHanSansKR";
        font-weight: bold;
        src: url('fonts/SourceHanSansKR-Bold.otf');
    }

    * {
        font-family: 'SourceHanSansKR', 'Malgun Gothic', sans-serif;
    }

</style>

<style>
    .page-break {
        page-break-after: always;
    }

    .resume-pdf {
        margin-top: 50px;
        margin-bottom: 80px;
    }

    .resume-pdf .row {
        padding: 0 70px;
    }

    .resume-pdf .content-title h1 {
        font-size: 30px;
    }

    .resume-pdf .user-information-wrap {
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid #d8d8d8;
    }

    .resume-pdf .user-information-wrap::after {
        display: block;
        content: "";
        clear: both;
    }

    .resume-pdf .user-information-wrap .user-image-wrap {
        border: 1px solid #d8d8d8;
        float: left;
    }

    .user-image-wrap img {
        width: 220px;
        height: 293px;
    }

    .resume-pdf .user-information-wrap .user-personal-information {
        margin-top: 5px;
        margin-left: 50px;
        float: left;
    }

    .user-personal-information .user-name {
        font-size: 24px;
        font-weight: bold;
    }

    .user-personal-information table {
        margin-top: 25px;
    }

    .user-personal-information table th {
        width: 100px;
        padding-top: 6px;
        padding-bottom: 6px;
        font-size: 14px;
        text-align: left;
        color: #777777;
        vertical-align: middle;
    }

    .user-personal-information table tr:first-child th {
        padding-top: 0;
    }

    .user-personal-information table tr:last-child th {
        padding-bottom: 0;
    }

    .user-personal-information table td {
        width: 245px;
        padding-left: 10px;
        padding-top: 6px;
        padding-bottom: 6px;
        vertical-align: middle;
    }

    .user-personal-information table .for-padding {
        padding-right: 80px;
    }

    .user-personal-information table td p {
        font-size: 16px;
        word-break: break-all;
    }

    .user-personal-information table tr:first-child td {
        padding-top: 0;
    }

    .user-personal-information table tr:last-child td {
        padding-bottom: 0;
    }

    .resume-pdf .study-information-wrap {
        margin-top: 100px;
    }

    .resume-pdf .information-title {
        padding-bottom: 18px;
        border-bottom: 2px solid #999;
    }

    .resume-pdf .information-title h2 {
        font-size: 24px;
        line-height: 26px;
    }

    .study-information-wrap .study-information-content {
        padding: 30px 70px 0 40px;
    }

    .study-information-wrap .study-information-content::after {
        display: block;
        content: "";
        clear: both;
    }

    .study-information-wrap .study-information-content th {
        width: 100px;
        padding-top: 17px;
        font-size: 14px;
        text-align: left;
        color: #777777;
        vertical-align: middle;
    }

    .study-information-wrap .study-information-content .study-information-left {
        float: left;
    }

    .study-information-wrap .study-information-left tr:first-child th {
        padding-top: 0;
    }

    .study-information-wrap .study-information-left td {
        padding-top: 17px;
        padding-left: 10px;
        vertical-align: middle;
    }

    .study-information-wrap .study-information-content td p {
        font-size: 16px;
        margin: 0;
        padding: 0;
    }

    .study-information-wrap .study-information-left tr:first-child td {
        padding-top: 0;
    }

    .study-information-wrap .study-information-content .study-information-right {
        float: right;
    }

    .study-information-wrap .study-information-right tr:first-child th {
        padding-top: 0;
    }

    .study-information-wrap .study-information-right td {
        padding-top: 25px;
        vertical-align: middle;
    }

    .study-information-wrap .study-information-right tr:first-child td {
        padding-top: 10px;
    }

    .study-information-wrap .study-information-content p {
        display: inline-block;
    }

    .study-information-wrap .study-information-content .bar {
        width: 1px;
        height: 16px;
        margin: 0 10px 3px 10px;
        background-color: #222;
    }

    .resume-pdf .self-information-wrap {
        margin-top: 65px;
    }

    .resume-pdf .self-information-wrap .self-information-content {
        padding: 40px 45px 0 45px;
        min-height: 100px;
    }

    .self-information-wrap .self-information-content .self-information-text {
        font-size: 16px;
    }

    .resume-pdf .career-information-wrap {
        margin-top: 100px;
    }

    .resume-pdf .certification-information-wrap {
        margin-top: 100px;
    }

    .career-information-wrap .career {
        width: 100%;
    }

    .certification-information-wrap .certificate {
        width: 100%;
    }

    .career-information-wrap .career th {
        padding: 14px 0;
        background-color: #f7f7f7;
        border-bottom: 1px solid #d8d8d8;
        color: #777;
    }

    .certification-information-wrap .certificate th {
        padding: 14px 0;
        background-color: #f7f7f7;
        border-bottom: 1px solid #d8d8d8;
        color: #777;
    }

    .career-information-wrap .career td {
        height: 62px;
        border-bottom: 1px solid #d8d8d8;
        font-size: 16px;
        vertical-align: middle;
        text-align: center;
    }

    .certification-information-wrap .certificate td {
        height: 62px;
        border-bottom: 1px solid #d8d8d8;
        font-size: 16px;
        vertical-align: middle;
        text-align: center;
    }

    .career-information-wrap .career tr:last-child td {
        border-bottom: 2px solid #d8d8d8;
    }

    .certification-information-wrap .certificate tr:last-child td {
        border-bottom: 2px solid #d8d8d8;
    }

    .resume-pdf .ability-information-wrap {
        margin-top: 60px;
    }

    .ability-information-wrap .ability-information-content::after {
        display: block;
        content: "";
        clear: both;
    }

    .ability-information-wrap .ability-information-content .table-wrap {
        width: 50%;
        float: left;
    }

    .ability-information-wrap .ability-information-content table {
        width: 100%;
    }

    .ability-information-wrap .ability-information-content .table-right {
        border-left: 1px solid #d8d8d8;
    }

    .ability-information-content table th {
        padding: 14px 0;
        background-color: #f7f7f7;
        border-bottom: 1px solid #d8d8d8;
        color: #777;
    }

    .ability-information-content table td {
        height: 54px;
        border-bottom: 1px solid #d8d8d8;
        vertical-align: middle;
        text-align: center;
    }
</style>
<body>
<section class="resume-pdf">
    <div class="container">
        <div class="row">
            <section class="content-title">
                <h1>이력서 정보</h1>
            </section>

            <section class="user-information-wrap">
                <div class="user-image-wrap">
                    <img src="{{ $thumbnail }}" class="user-image" alt="이력서 사진">
                </div>
                <div class="user-personal-information">
                    <h2 class="user-name">{{ $resume->name }}</h2>
                    <table>
                        <tr>
                            <th>영문 이름</th>
                            <td colspan="3"><p>{{ $resume->english_name }}</p></td>
                        </tr>
                        <tr>
                            <th>생년 월일</th>
                            <td colspan="3"><p>{{ $resume->birthday }}</p></td>
                        </tr>
                        <tr>
                            <th>휴대폰 번호</th>
                            <td colspan="3"><p>{{ $resume->phone }}</p></td>
                        </tr>
                        <tr>
                            <th>비상연락처</th>
                            <td class="for-padding"><p>{{ $resume->emergency_phone }}</p></td>
                            <th>희망 근무 지역</th>
                            <td><p>{{ $resume->work_area }}</p></td>
                        </tr>
                        <tr>
                            <th>이메일</th>
                            <td class="for-padding"><p>{{ $resume->email }}</p></td>
                            <th>희망 근무 요일</th>
                            <td><p>{{ $resume->work_day }}</p></td>
                        </tr>
                        <tr>
                            <th>주소</th>
                            <td class="for-padding"><p>{{ $resume->address }}</p></td>
                            <th>희망 근무 시간</th>
                            <td><p>{{ $resume->work_time }}</p></td>
                        </tr>
                    </table>
                </div>
            </section>

            <section class="study-information-wrap">
                <div class="information-title">
                    <h2>학력 사항 및 희망순위</h2>
                </div>
                <div class="study-information-content">
                    <table class="study-information-left">
                        <tr>
                            <th>졸업년월</th>
                            <td><p>{{ $resume->graduated_at }}</p></td>
                        </tr>
                        <tr>
                            <th>출신학교 및 학과</th>
                            <td><p>{{ $resume->school }}</p></td>
                        </tr>
                        <tr>
                            <th>졸업구분</th>
                            <td><p>{{ $resume->graduation_type }}</p></td>
                        </tr>
                    </table>
                    <table class="study-information-right">
                        <tr>
                            <th>희망 진료과</th>
                            <td>
                                @if($resume->treatment_1)
                                    <p class="ranking">{{ '1순위 ' . $resume->treatment_1 }}</p>
                                @endif
                                @if($resume->treatment_2)
                                    <p class="bar"></p>
                                    <p class="ranking">{{ '2순위 ' . $resume->treatment_2 }}</p>
                                @endif
                                @if($resume->treatment_3)
                                    <p class="bar"></p>
                                    <p class="ranking">{{ '3순위 ' . $resume->treatment_3 }}</p>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>희망 부서</th>
                            <td>
                                <div class="ranking-wrap">
                                    @if($resume->department_1)
                                        <p>{{ '1순위 ' . $resume->department_1 }}</p>
                                    @endif
                                    @if($resume->department_2)
                                        <p class="bar"></p>
                                        <p>{{ '2순위 ' . $resume->department_2 }}</p>
                                    @endif
                                    @if($resume->department_3)
                                        <p class="bar"></p>
                                        <p>{{ '3순위 ' . $resume->department_3 }}</p>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </section>
            <section class="career-information-wrap">
                <div class="information-title">
                    <h2>경력사항</h2>
                </div>
                <div class="career-information-content">
                    <table class="career">
                        <thead>
                        <tr>
                            <th style="width: 250px;">근무기간</th>
                            <th style="width: 250px;">치과명</th>
                            <th style="width: 250px;">담당업무</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($resume->career_started_at_1 != null)
                            <tr>
                                <td>{{$resume->career_started_at_1}} ~ {{$resume->career_ended_at_1}}</td>
                                <td>{{$resume->career_company_1}}</td>
                                <td>{{$resume->career_task_1}}</td>
                            </tr>
                        @endif
                        @if($resume->career_started_at_2 != null)
                            <tr>
                                <td>{{$resume->career_started_at_2}} ~ {{$resume->career_ended_at_2}}</td>
                                <td>{{$resume->career_company_2}}</td>
                                <td>{{$resume->career_task_2}}</td>
                            </tr>
                        @endif
                        @if($resume->career_started_at_3 != null)
                            <tr>
                                <td>{{$resume->career_started_at_3}} ~ {{$resume->career_ended_at_3}}</td>
                                <td>{{$resume->career_company_3}}</td>
                                <td>{{$resume->career_task_3}}</td>
                            </tr>
                        @endif
                        @if($resume->career_started_at_4 != null)
                            <tr>
                                <td>{{$resume->career_started_at_4}} ~ {{$resume->career_ended_at_4}}</td>
                                <td>{{$resume->career_company_4}}</td>
                                <td>{{$resume->career_task_4}}</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </section>
            <section class="certification-information-wrap">
                <div class="information-title">
                    <h2>면허/자격증 보유 현황</h2>
                </div>
                <div class="certification-information-content">
                    <table class="certificate">
                        <thead>
                        <tr>
                            <th style="width: 100px;" class="first-child">구분</th>
                            <th style="width: 250px">자격증명</th>
                            <th style="width: 250px">취득년월</th>
                            <th style="width: 250px">인가, 관리기관</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php($i = 1)
                        @if($resume->certificate_name_1 != null)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $resume->certificate_name_1 }}</td>
                                <td>{{ $resume->certificate_day_1 }}</td>
                                <td>{{ $resume->certificate_agency_1 }}</td>
                            </tr>
                        @endif
                        @if($resume->certificate_name_2 != null)

                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $resume->certificate_name_2 }}</td>
                                <td>{{ $resume->certificate_day_2 }}</td>
                                <td>{{ $resume->certificate_agency_2 }}</td>
                            </tr>
                        @endif
                        @if($resume->certificate_name_3 != null)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $resume->certificate_name_3 }}</td>
                                <td>{{ $resume->certificate_day_3 }}</td>
                                <td>{{ $resume->certificate_agency_3 }}</td>
                            </tr>
                        @endif
                        @if($resume->certificate_name_4 != null)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $resume->certificate_name_4 }}</td>
                                <td>{{ $resume->certificate_day_4 }}</td>
                                <td>{{ $resume->certificate_agency_4 }}</td>
                            </tr>
                        @endif
                        @if($resume->certificate_name_5 != null)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $resume->certificate_name_5 }}</td>
                                <td>{{ $resume->certificate_day_5 }}</td>
                                <td>{{ $resume->certificate_agency_5 }}</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </section>
            <div class="page-break"></div>

            <section class="self-information-wrap">
                <div class="information-title">
                    <h2>자기소개</h2>
                </div>
                <div class="self-information-content">
                    <p class="self-information-text">
                        {{ $resume->about_me }}
                    </p>
                </div>
            </section>


            <div class="page-break"></div>

            <section class="ability-information-wrap">
                <div class="information-title">
                    <h2>치과 업무 능력 자기 평가표</h2>
                </div>
                <div class="ability-information-content">
                    <div class="table-wrap">
                        <table>
                            <thead>
                            <tr>
                                <th style="width: 100px">구분</th>
                                <th style="width: 190px"></th>
                                <th style="width: 90px">자가평가 점수</th>
                                <th style="width: 90px">교육가능 유무</th>
                            </tr>
                            </thead>
                            @foreach($leftList as $answer)
                                <tr>
                                    <td>{{ $categories[$answer->ability->category_id] }}</td>
                                    <td>{{ $answer->ability->name }}</td>
                                    @if($answer->ability->type == 'text')
                                        <td colspan="2">{{ $answer->content }}</td>
                                    @else
                                        <td>
                                            @switch($answer->score)
                                                @case(1) 경험없음 @break
                                                @case(2) 미흡 @break
                                                @case(3) 보통 @break
                                                @case(4) 잘함 @break
                                                @case(5) 매우잘함 @break
                                                @default 보통
                                            @endswitch
                                        </td>
                                        <td>{{ $answer->can_learn ? '●': '' }}</td>
                                    @endif
                                </tr>
                            @endforeach
                        </table>
                    </div>
                    <div class="table-wrap">
                        <table class="table-right">
                            <thead>
                            <tr>
                                <th style="width: 100px">구분</th>
                                <th style="width: 190px"></th>
                                <th style="width: 90px">자가평가 점수</th>
                                <th style="width: 90px">교육가능 유무</th>
                            </tr>
                            </thead>
                            @foreach($rightList as $answer)
                                <tr>
                                    <td>{{ $categories[$answer->ability->category_id] }}</td>
                                    <td>{{ $answer->ability->name }}</td>
                                    <td>
                                        @switch($answer->score)
                                            @case(1) 경험없음 @break
                                            @case(2) 미흡 @break
                                            @case(3) 보통 @break
                                            @case(4) 잘함 @break
                                            @case(5) 매우잘함 @break
                                            @default 보통
                                        @endswitch
                                    </td>
                                    <td>{{ $answer->can_learn ? '●': '' }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </section>
            @if($completedPrograms && $completedPrograms->count() > 0)
            <section class="certification-information-wrap">
                <div class="information-title">
                    <h2>직무 역량 교육 이수 현황</h2>
                </div>
                <div class="certification-information-content">
                    <table class="certificate">
                        <thead>
                        <tr>
                            <th style="width: 200px;" class="first-child">핵심역량</th>
                            <th style="width: 450px">교육과정명</th>
                            <th style="width: 200px">이수연월</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($completedPrograms as $index => $applied)
                            <tr>
                                <td>{{ $applied->program->major_category_name ?? '구분없음' }}</td>
                                
                                <td style="text-align: left; padding-left: 15px;">
                                    {{ $applied->program->title }}
                                </td>
                                
                                <td>
                                    @if($applied->applied_at instanceof \Carbon\Carbon)
                                        {{ $applied->applied_at->format('Y.m') }}
                                    @elseif($applied->applied_at)
                                        {{ date('Y.m', strtotime($applied->applied_at)) }}
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" style="padding: 20px 0; color: #666;">직무 역량 교육 이수 현황이 없습니다.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
            @endif
        </div>
    </div>
</section>
</body>
</html>
