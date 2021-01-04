$(function () {
    email_box('.email_box');

    var fileTarget = $('.upload-hidden');

    fileTarget.on('change', function(){
        if(window.FileReader){
            var filename = $(this)[0].files[0].name;
        }
        else {
            var filename = $(this).val().split('/').pop().split('\\').pop();
        }
        $(this).siblings('.file-name').val(filename);
    });
});
