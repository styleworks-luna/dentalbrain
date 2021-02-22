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
    var agreeAll = $('input:checkbox[name=agree-all]');
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

    // 타이머
    var timer = 0;

    function startTimer() {

        var SetTime = 180;

        $('#send_authentication').css('pointer-events', 'none');

        timer = setInterval(function() {
            m = Math.floor(SetTime / 60) + "분 " + (SetTime % 60) + "초";

            var msg = "시간: " + m;
            $('.timer').text(msg);

            SetTime--;

            if (SetTime < 0) {
                $('#send_authentication').css('pointer-events', 'auto');
                clearInterval(timer);
                alert("인증시간이 초과하였습니다. 다시 시도해주시기 바랍니다.");
            }
        }, 1000);
    }

    $("#edit_phone").click(function(){
        $('#phone').attr('readonly', false);
        clearInterval(timer);
        $('#send_authentication').css('pointer-events', 'auto');
        $('.timer').text("");
    });

    // 인증번호 발송
    $('#send_authentication').click(function(){
        var phone = $('#phone').val();
        var data = {"phone": phone};

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "/api/send-verification",
            type: "POST",
            data: data,
            success: function (data) {
                $('#phone').attr('readonly', true);
                startTimer();
                alert('인증번호를 전송하였습니다.');
            },
            error: function (request, status, error) {
                alert(error);
            }
        });
    });

    // 인증번호 확인
    $('#confirm_authentication').click(function() {
        var phone = $('#phone').val();
        var verificationNumber = $('#verification_number').val();
        var data = {"phone": phone , "verificationNumber": verificationNumber};

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "/api/compare-verification",
            type: "POST",
            data: data,
            success: function () {
                $('#verification_number').attr('readonly',true);
                clearInterval(timer);
                $('timer').text('');
                alert("인증번호 확인이 완료되었습니다.");
            },
            error: function (request, status, error) {
                alert(error);
            }
        });
    });

    $('#login_id').change(function () {
        $('#login_id_check').val('N');
    });

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
