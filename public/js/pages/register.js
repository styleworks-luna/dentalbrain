$(function() {
    // email box
    email_box('.email_box');

    // select menu
    var select_menu = $('.select-menu');

    if(select_menu.length > 0){
        select_menu.selectmenu();
    }

    // 파슬리
    $('#register-form').parsley();

    // 전체 동의
    var agreeAll = $('input:checkbox[name=agree-all]')
    var agreeService = $("input:checkbox[name=service-consent]");
    var agreePrivacy = $("input:checkbox[name=privacy-consent]");
    var agreeEmail = $("input:checkbox[name=email-consent]");

    $('.agreement-all-wrap input[type="checkbox"]').change(function(){
        var check = $(this).is(':checked');
        $('.agreement-wrap input[type="checkbox"]').prop('checked', check);
    });
    $('.agreement-wrap > ul > li').change(function(){
        if(agreeService.is(':checked') == true && agreePrivacy.is(':checked') == true && agreeEmail.is(':checked') == true) {
            agreeAll.prop('checked', true);
        } else {
            agreeAll.prop('checked', false);
        }
    })

    $('.trigger-service').on('click', function() {
        $('.service-layer-wrapper').addClass('open blur');
        return false;
    });

    $('.trigger-privacy').on('click', function() {
        $('.privacy-layer-wrapper').addClass('open blur');
        return false;
    });

    $('.trigger-email').on('click', function() {
        $('.email-layer-wrapper').addClass('open blur');
        return false;
    });

    $('.btn-close').on('click', function(e) {
        e.preventDefault();
        $('.service-layer-wrapper').removeClass('open blur');
        $('.privacy-layer-wrapper').removeClass('open blur');
        $('.email-layer-wrapper').removeClass('open blur');
    });

});
