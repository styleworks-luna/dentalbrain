$(function(){
    // 약관 동의 내용보기
    $('.trigger-service').on('click', function () {
        $('.service-layer-wrapper .layer').slideDown();
        $('.dim').css('display', 'block');
        return false;
    });

    $('.trigger-privacy').on('click', function () {
        $('.privacy-layer-wrapper .layer').slideDown();
        $('.dim').css('display', 'block');
        return false;
    });

    $('.trigger-email').on('click', function () {
        $('.email-layer-wrapper .layer').slideDown();
        $('.dim').css('display', 'block');
        return false;
    });

    $('.btn-close, .dim').on('click', function (e) {
        e.preventDefault();

        $('.service-layer-wrapper .layer').slideUp();
        $('.privacy-layer-wrapper .layer').slideUp();
        $('.email-layer-wrapper .layer').slideUp();
        $('.dim').css('display', 'none');
    });
});
