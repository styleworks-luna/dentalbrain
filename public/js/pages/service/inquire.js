$(function() {
    // email box
    email_box('.email-box');

    // select menu
    var select_menu = $('.select-menu');

    if(select_menu.length > 0){
        select_menu.selectmenu();
    }

    // 보안문자 새로고침 (캐시를 타지 않도록 매번 다른 쿼리를 붙인다)
    var captcha_image = $('#captcha-image');

    if(captcha_image.length > 0){
        var captcha_url = captcha_image.attr('src').split('?')[0];

        $('#btn-captcha-reload').on('click', function() {
            captcha_image.attr('src', captcha_url + '?_=' + new Date().getTime());
            $('#captcha').val('').focus();
        });
    }

    // 파슬리
    $('#inquire-form').parsley();

    form_submit_check();
});
