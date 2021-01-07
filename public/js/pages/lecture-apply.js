$(function () {
    email_box('.email_box');

    //파일 업로드 file name 업데이트
    var fileTarget = $('.upload-hidden');

    fileTarget.on('change', function(){
        if (window.FileReader) {
            var filename = $(this)[0].files[0].name;
        } else {
            var filename = $(this).val().split('/').pop().split('\\').pop();
        }

        $(this).siblings('.file-name').val(filename);
    });

    // 전체 동의
    var agreeAll = $('input:checkbox[name=agree-all]')
    var agreeOffer = $("input:checkbox[name=offer-consent]");
    var agreeRefund = $("input:checkbox[name=refund-consent]");

    $('.agreement-all-wrap input[type="checkbox"]').change(function(){
        var check = $(this).is(':checked');
        $('.agreement-wrap input[type="checkbox"]').prop('checked', check);
    });

    $('.agreement-wrap > ul > li').change(function() {
        if (agreeOffer.is(':checked') == true && agreeRefund.is(':checked') == true) {
            agreeAll.prop('checked', true);
        } else {
            agreeAll.prop('checked', false);
        }
    });

});
