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

    select_menu.on("selectmenuselect", function (event, ui) {
        if (event.target.value == "0") {
            $(this).parents('tr').find('.ability-check').val("N");
            $(this).parents('tr').find('.ability-check').parsley().validate();
            $(this).siblings('.ui-selectmenu-button').css('border-color', '#ff0000');
        } else {
            $(this).parents('tr').find('.ability-check').val("Y");
            $(this).parents('tr').find('.ability-check').parsley().validate();
            $(this).siblings('.ui-selectmenu-button').css('border-color', '#d8d8d8');
        }
    });

    // thumbnail
    if (nullCheck($('.image-file-id').val())) {
        $('.image-off').css('display', 'block');
        $('.image-on').css('display', 'none');
        $('.file-check').val('N');
    } else {
        $('.image-off').css('display', 'none');
        $('.image-on').css('display', 'block');
        $('.file-check').val('Y');
    }

    function thumbnailValidation() {
        if (!$('.file-check').parsley().isValid()) {
            $('.resume-profile').css('border-color', '#FF0000')
            scrollTo(0,$('.resume-profile').offset().top - 500);
        } else {
            $('.resume-profile').css('border-color', '#d8d8d8')
        }
    }

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
            $('.resume-profile').attr('src', res.url);
            $('.image-file-id').val(res.id);

            $('.image-off').css('display', 'none');
            $('.image-on').css('display', 'block');

            $('.file-check').val("Y");
            $('.file-check').parsley().validate();
            thumbnailValidation();
        }).fail(err => {
            alert('오류가 발생하였습니다.')
        });
    });

    $('.btn-delete-thumbnail').click(function () {
        $('.resume-profile').attr('src', "");
        $('#resume_image').val("");
        $('.file-check').val("N");
        $('.file-check').parsley().validate();

        $('.image-file-id').val("");

        $('.image-off').css('display', 'block');
        $('.image-on').css('display', 'none');
        thumbnailValidation();
    });

    $('.btn-submit').click(function () {
        thumbnailValidation();
        $('.ability-check').each( (idx,x) => {
            if($(x).parsley().isValid() == false) {
                $(x).parents('tr').find('.ui-selectmenu-button').css('border-color','#ff0000')
                scrollTo(0, $('.left-content-wrap').offset().top);
            }
        })
    });
})
