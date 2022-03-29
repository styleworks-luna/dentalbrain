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
            'placeholder': '이메일 주소 입력'
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

function form_submit_check(element = 'form'){
    if(element == '' || element == null || element == 'undefined'){
        element = 'form';
    }

    $(element).submit(function(){
        var form = $(this);
        if (form.parsley().isValid()){
            form.find('input[type="submit"]').attr('disabled','disabled');
            form.find('button[type="submit"]').attr('disabled','disabled');
        }else{
            return false;
        }
    });
}
