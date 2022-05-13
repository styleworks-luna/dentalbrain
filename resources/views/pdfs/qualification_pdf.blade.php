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
<body>
<h2>자격증</h2>
<h3>자격번호 : {{ $profile->certificate_number }}</h3>
<img src="{{ url($profile->file->url) }}" alt="" width="300" height="400">
<div>
    <table>
        <tr>
            <td>성 명</td>
            <td>{{ $profile->name }}</td>
        </tr>
        <tr>
            <td>생년월일</td>
            <td>{{ \Carbon\Carbon::parse($profile->birthday)->format('Y-m-d') }}</td>
        </tr>
        <tr>
            <td>자격등급</td>
            <td>{{ $certification->grade }}</td>
        </tr>
    </table>
    <div>
        {!! $certification->content !!}
    </div>
    <div>
        {{ now()->format('Y년 m월 d일') }}
    </div>
</div>
</body>
</html>
