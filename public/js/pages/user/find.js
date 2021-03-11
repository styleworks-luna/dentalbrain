$(function() {
    // 아이디 찾기
    $('.btn-find-id').click(function(e) {
        var name = $('input[name="name"]').val();
        var phone = $('input[name="phone"]').val();
        var messageWrap = $(this).closest('.find-form-common').find('.message-wrap');

        e.preventDefault();

        messageWrap.html('');

        if (!name) {
            alert('이름을 입력해주세요.');
            return false;
        }

        if (!phone) {
            alert('휴대전화 번호를 입력해주세요.');
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
                } else {
                    messageWrap.html('<p class="error">' + res.message + '</p>');
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

        e.preventDefault();

        messageWrap.html('');

        if (!email) {
            alert('이메일을 입력해주세요.');
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
                } else {
                    messageWrap.html('<p class="error">' + res.message + '</p>');
                }
            },
            fail: function(err) {
                alert('오류');
            }
        });
    });

    form_submit_check();
});
