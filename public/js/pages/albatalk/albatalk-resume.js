$(function () {
    // parsley
    $("#albatalk_resume_form").parsley({
        excluded: 'input[type=button], input[type=submit], input[type=reset]',
        inputs: 'div, input, textarea, select, input[type=hidden], :hidden',
    });

    // select menu
    var select_menu = $('.select-menu');
    if (select_menu.length > 0) {
        select_menu.selectmenu({
            width: 112
        })
    }

    console.log(nullCheck($('.image-src').val()));

    if(nullCheck($('.image-src').val())) {
        $('.image-off').css('display','block');
        $('.image-on').css('display','none');
    } else {
        $('.image-off').css('display','none');
        $('.image-on').css('display','block');
    }

    function thumbnailValidation() {
        if(!$('#resume_image').parsley().isValid()) {
            $('.resume-profile').css('border-color', '#FF0000')
        } else {
            $('.resume-profile').css('border-color', '#d8d8d8')
        }
    }

    // thumbnail
    $('#resume_image').change(function () {
        var formData = new FormData();
        formData.append("image", $("#resume_image")[0].files[0]);

        $.ajax({
            url: '/api/albatalk/resume/upload-thumbnail',
            method: 'POST',
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            data: formData,
        }).then(res => {
            $('.resume-profile').attr('src',res.url);
            $('.image-file-id').val(res.id);
            $('.image-src').val(res.url);

            $('.image-off').css('display', 'none');
            $('.image-on').css('display','block');

            $('#resume_image').parsley().validate();
            thumbnailValidation();
        }).fail(err => {
            alert('오류가 발생하였습니다.')
        });
    });

    $('.btn-delete-thumbnail').click(function (){
        $('.resume-profile').attr('src',"");
        $('#resume_image').val("");
        $('#resume_image').parsley().validate();

        $('.image-file-id').val("");
        $('.image-src').val("");

        $('.image-off').css('display', 'block');
        $('.image-on').css('display','none');
        thumbnailValidation();
    });

    $('.btn-submit').click(function() {
        thumbnailValidation();
    });
})
