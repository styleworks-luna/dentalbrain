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
        font-family: "chosunGs";
        font-weight: normal;
        src: url('fonts/ChosunGs_pdf.ttf');
    }

    @font-face {
        font-family: "chosunGs";
        font-weight: bold;
        src: url('fonts/ChosunGs_pdf.ttf');
    }

    * {
        font-family: 'chosunGs', 'Malgun Gothic', sans-serif;
    }
    .background-image {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
    }

    .certification-wrap {
        padding: 0 170px;
    }

    .certification-wrap .img-wrap {
        margin-top: 100px;
        text-align: center;
    }

    .certification-wrap .img-wrap .certificate-logo {
        width: 200px;
    }

    .certification-wrap .certificate-background-logo {
        display: block;
        width: 500px;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .certification-wrap .certificate-number {
        margin-top: 50px;
        font-size: 33px;
    }

    .certification-wrap .certificate-title {
        margin-top: 30px;
        font-size: 100px;
        text-align: center;
    }

    .certification-wrap .certificate-name {
        font-size: 34px;
    }

    .certification-wrap .certificate-name .for-margin {
        display: inline-block;
        margin: 0 31px;
    }

    .certification-wrap .certificate-content {
        margin-top: 90px;
        text-align: center;
        font-size: 36px;
        min-height: 160px;
    }

    .certification-wrap .certificate-sub-content {
        margin-top: 90px;
        text-align: center;
        font-size: 36px;
        min-height: 160px;
    }

    .certification-wrap .certificate-date {
        font-size: 36px;
        text-align: center;
    }

    .certification-wrap .certificate-associate {
        margin-top: 50px;
        text-align: center;
    }

    .certification-wrap .certificate-associate span {
        font-size: 38px;
    }

    .certification-wrap .certificate-associate span:first-child {
        margin-right: 50px;
    }

    .certification-wrap .certificate-main-associate {
        position: relative;
        text-align: center;
        font-size: 50px;
        color: #1d1d1b;
        z-index: 10;
    }

    .certification-wrap .certificate-main-associate-wrap {
        margin-top: 50px;
        position: relative;
    }

    .certification-wrap .sign {
        width: 100px;
        position: absolute;
        right: 105px;
        top: -22px;
        z-index: 1;
    }

</style>
<body>
<div class="certification-wrap">
    <img src="{{ asset('/images/admin/certification_back.png') }}" class="background-image" alt="background-image">
    <div class="img-wrap">
        <img src="{{ asset('/images/admin/KDMA_mark.svg') }}" class="certificate-logo" alt="KDMA">
    </div>
    <img src="{{ asset('/images/admin/KDMA_light_mark.svg') }}" class="certificate-background-logo" alt="KDMA">
    <p class="certificate-number">자격번호 : {{ $profile->certificate_number }}</p>
    <h3 class="certificate-title">자 격 증</h3>
    <p class="certificate-name">성<span class="for-margin"></span>명 : {{ $profile->name }}</p>
    <pre class="certificate-content">{!! $certification->content !!}</pre>
    <p class="certificate-sub-content">{{ $certification->bottom_content }}</p>
    <p class="certificate-date"> {{ now()->format('Y년 m월 d일') }}</p>
    <div class="certificate-associate"><span>대한치과위생사협회</span> <span>대한치과의료관리학회</span></div>
    <div class="certificate-main-associate-wrap">
        <p class="certificate-main-associate">대한치과경영관리협회</p>
        <img src="{{ asset('/images/admin/sign.png') }}" class="sign" alt="SIGN">
    </div>
</div>
</body>
</html>
