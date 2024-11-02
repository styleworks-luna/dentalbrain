<html>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style>
    html,
    body,
    div,
    span,
    h1,
    h2,
    h3,
    p,
    pre,
    img {
        margin: 0;
        padding: 0;
        border: 0;
        font-size: 14px;
        font-weight: normal;
        vertical-align: baseline;
    }

    /* HTML5 display-role reset for older browsers */
    /*
    article, aside, details, figcaption, figure,
    footer, header, hgroup, menu, nav, section {
        display: block;
    }
    */

    body {
        line-height: 1;
    }

    /*
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
    */
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

    .certification-wrap .certificate-information-wrap {
        margin-top: 100px;
    }

    .certification-wrap .certificate-information-wrap::after {
        display: block;
        content: '';
        clear: both;
    }

    .certification-wrap .certificate-text-wrap {
        padding-top: 70px;
        float: left;
    }

    .certification-wrap .certificate-image-wrap {
        float: right;
    }

    .certification-wrap .thumbnail {
        width: 210px;
        height: 280px;
        border: 1px solid #d8d8d8;
    }

    .certification-wrap .certificate-name {
        font-size: 34px;
    }

    .certification-wrap .certificate-name .for-margin {
        display: inline-block;
        margin: 0 31px;
    }

    .certification-wrap .certificate-birth {
        margin-top: 15px;
        font-size: 34px;
    }

    .certification-wrap .certificate-grade {
        margin-top: 15px;
        font-size: 34px;
    }

    .certification-wrap .certificate-content {
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
        margin-top: 75px;
        margin-bottom: 75px;
        text-align: center;
    }

    .certification-wrap .certificate-associate span {
        font-size: 33px;
    }

    .certification-wrap .certificate-associate .margin-left {
        margin-left: 30px;
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

    .page-break {
        page-break-after: always;
    }

    .background-image {
        z-index: -99;
    }

    .certificate-logo {
        z-index: -98;
    }

    .certificate-background-logo {
        z-index: -97;
    }
</style>

<body>
    @yield('content')
</body>

</html>
