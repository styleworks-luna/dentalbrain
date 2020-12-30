// 이메일 박스 공통
function email_box(email){
    $(email).each(function(){
        $(this).emailbox({
            validate: true,
            validateRemote: true,
            triggerChange: true
        });

        $('.ui-emailbox-account').attr({
            'type': 'text',
            'placeholder': '이메일을 입력해주세요'
        });
        $('.ui-emailbox-domain').attr({
            'type': 'text',
            'placeholder': '직접입력'
        });
    });

    window.setTimeout(function() {
        $('.ui-emailbox-menu').css('display', 'none');
    }, 100);
}
