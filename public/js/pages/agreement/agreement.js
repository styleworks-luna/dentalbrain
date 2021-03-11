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

    $('.trigger-privacy-to-third').on('click', function () {
        $('.privacy-to-third-layer-wrapper .layer').slideDown();
        $('.dim').css('display', 'block');
        return false;
    });

    $('.trigger-refund').on('click', function () {
        $('.refund-layer-wrapper .layer').slideDown();
        $('.dim').css('display','block');
        return false
    });

    $('.btn-close, .dim').on('click', function (e) {
        e.preventDefault();

        $('.service-layer-wrapper .layer').slideUp();
        $('.privacy-to-third-layer-wrapper .layer').slideUp();
        $('.privacy-layer-wrapper .layer').slideUp();
        $('.refund-layer-wrapper .layer').slideUp();
        $('.dim').css('display', 'none');
    });
});
