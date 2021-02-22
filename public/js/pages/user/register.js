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

    $('#login_id').change(function () {
        $('#login_id_check').val('N');
    });

    //초기화
    function reset() {
        $('.timer').text('');
        clearInterval(timer);

        $('#phone').val('').attr('readonly', false);
        $('#send_authentication').css('pointer-events', 'auto');

        $('#verification_number').val('').attr('readonly',true);
        $('#confirm_authentication').css('pointer-events', 'none');
        $('#phone-check').val('N');
    }

    // 타이머
    var timer = 0;

    function startTimer() {

        var SetTime = 180;

        timer = setInterval(function() {
            m = Math.floor(SetTime / 60) + "분 " + (SetTime % 60) + "초";

            var msg = "시간: " + m;
            $('.timer').text(msg);

            SetTime--;

            if (SetTime < 0) {
                reset();
                alert("인증시간이 초과하였습니다. 다시 시도해주시기 바랍니다.");
            }
        }, 1000);
    };

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
                console.log(data);
                if(data.code == 1000) {
                    startTimer();
                    $('#phone').attr('readonly', true);
                    $('#send_authentication').css('pointer-events', 'none');

                    $('#verification_number').attr('readonly',false);
                    $('#confirm_authentication').css('pointer-events', 'auto');

                    alert('인증번호를 전송하였습니다.');
                } else {
                    alert(data.description);
                }

            },
            error: function () {
                alert('인증번호를 전송하지 못하였습니다.');
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
            success: function (data) {
                if(data.success) {
                    clearInterval(timer);
                    $('.timer').text('');

                    $('#verification_number').attr('readonly',true);
                    $('#confirm_authentication').css('pointer-events', 'none');
                    $('#phone-check').val('Y');
                    alert('인증번호 확인이 완료되었습니다.');
                } else {
                    $('#phone-check').val('N');
                    alert(data.msg);
                }
            },
            error: function () {
                alert('인증번호를 다시 입력해 주시기 바랍니다.');
            }
        });
    });

    $('#verification_number').change(function() {
        $('#phone-check').val('N');
    });

    // 변경 버튼
    $('#edit_phone').click(function() {
        reset();
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
