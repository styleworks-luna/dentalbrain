$(function() {
    // 아이디 찾기
    $('.btn-find-id').click(function(e) {
        var name = $('input[name="name"]').val();
        var phone = $('input[name="phone"]').val();
        var messageWrap = $(this).closest('.find-form-common').find('.message-wrap');

        e.preventDefault();

        messageWrap.html('');

        if (!name) {
            $('.name').addClass('input-error');
            $('.phone').removeClass('input-error');
            $('.id-message').append('<p class="error">※ 이름을 입력해주세요.</p>');
            return false;
        }

        if (!phone) {
            $('.phone').addClass('input-error');
            $('.name').removeClass('input-error');
            $('.id-message').append('<p class="error">※ 휴대전화 번호를 입력해주세요.</p>');
            return false;
        }

        $.ajax({
            url: '/api/find/id',
            method: 'post',
            data: {
                name: name,
                phone: phone
            },
            success: function(res) {
                if (res.success) {
                    messageWrap.html('<p class="success">가입된 사용자 아이디는 <strong>' + res.login_id + '</strong> 입니다.</p>');
                    $('.find-id-form').css('height', '338px');
                    $('.phone').removeClass('input-error');
                    $('.name').removeClass('input-error');
                } else {
                    messageWrap.html('<p class="error">' + '※ ' + res.message + '</p>');
                    $('.find-id-form').css('height', '322px');
                    $('.phone').removeClass('input-error');
                    $('.name').removeClass('input-error');
                }
            },
            fail: function(err) {
                alert('오류');
            }
        });
    });

    // 비밀번호 찾기
    $('.btn-find-password').click(function(e) {
        var email = $('input[name="email"]').val();
        var messageWrap = $(this).closest('.find-form-common').find('.message-wrap');
        var emailRule = /^[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*.[a-zA-Z]{2,3}$/i;

        e.preventDefault();

        messageWrap.html('');

        if (!email) {
            $('.email').addClass('input-error');
            $('.password-message').append('<p class="error">※ 이메일 주소를 입력해주세요.</p>');
            return false;
        }

        if(email.match(emailRule) == null) {
            $('.email').addClass('input-error');
            $('.password-message').append('<p class="error">※ 이메일 형식에 맞춰 입력해주세요.</p>');
            return false;
        }

        $.ajax({
            url: '/api/find/password',
            method: 'post',
            data: {
                email: email
            },
            success: function(res) {
                if (res.success) {
                    messageWrap.html('<p class="send">' + res.message + '</p>');
                    $('.email').removeClass('input-error');
                } else {
                    messageWrap.html('<p class="error">' + '※ ' + res.message + '</p>');
                    $('.email').removeClass('input-error');
                }
            },
            fail: function(err) {
                alert('오류');
            }
        });
    });

    form_submit_check();
});
