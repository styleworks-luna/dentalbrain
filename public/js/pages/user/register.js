$(function () {
    // email box
    email_box('.email_box');

    // select menu
    var select_menu = $('.select-menu');

    if (select_menu.length > 0) {
        select_menu.selectmenu();
    }

    $("#register-form").parsley({
        excluded: 'input[type=button], input[type=submit], input[type=reset]',
        inputs: 'input, textarea, select, input[type=hidden], :hidden',
    });

    // 전체 동의
    var agreeAll = $('input:checkbox[name=agree-all]')
    var agreeService = $("input:checkbox[name=service-consent]");
    var agreePrivacy = $("input:checkbox[name=privacy-consent]");
    var agreeEmail = $("input:checkbox[name=email-consent]");

    $('.agreement-all-wrap input[type="checkbox"]').change(function () {
        var check = $(this).is(':checked');
        $('.agreement-wrap input[type="checkbox"]').prop('checked', check);
    });
    $('.agreement-wrap > ul > li').change(function () {
        if (agreeService.is(':checked') == true && agreePrivacy.is(':checked') == true && agreeEmail.is(':checked') == true) {
            agreeAll.prop('checked', true);
        } else {
            agreeAll.prop('checked', false);
        }
    });

    // 아이디 중복확인
    $("#login_id_confirm").click(function () {
        var login_id = $('#login_id').val();
        var data = {"login_id": login_id};

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "/api/check-id",
            type: "POST",
            data: data,
            success: function (data) {
                if(data.success == false) {
                    $('#login_id_check').val('N');
                } else {
                    $('#login_id_check').val('Y');
                }

                alert(data.message);
            },
            error: function (request, status, error) {
                alert(error);
            }
        });
    });

    $('#login_id').change(function () {
        $('#login_id_check').val('N');
    })

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
