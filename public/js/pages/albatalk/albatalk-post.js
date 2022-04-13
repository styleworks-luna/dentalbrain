$(function () {
    // parsley
    $("#albatalk_recruit_form").parsley({
        excluded: 'input[type=button], input[type=submit], input[type=reset]',
        inputs: 'div, input, textarea, select, input[type=hidden], :hidden',
    });

    // select menu
    var select_menu = $('.select-menu');
    if (select_menu.length > 0) {
        select_menu.selectmenu({
            width: 240
        })
    }

    // thumbnail
    $('.file-id').each( (idx,x) => {
        if(nullCheck($(x).val())) {
            $(x).parent().find('.image-off').css('display','block');
            $(x).parent().find('.image-on').css('display','none');
            $('.file-check').val('N');
        } else {
            $(x).parent().find('.image-off').css('display','none');
            $(x).parent().find('.image-on').css('display','block');
            $('.file-check').val('Y');
        }
    })

    function thumbnailValidation() {
        if(!$('.thumbnail-check').parsley().isValid()) {
            $('.main-thumbnail').css('border-color', '#FF0000')
        } else {
            $('.main-thumbnail').css('border-color', '#d8d8d8')
        }
    }

    $('.thumbnail-input').change(function () {
        var formData = new FormData();
        formData.append("image", $(this)[0].files[0]);

        $.ajax({
            url: '/api/albatalk/recruit/upload-thumbnail',
            method: 'POST',
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            data: formData,
        }).then(res => {
            $(this).parents('.img-wrap').find('.thumbnail-image').attr('src',res.url);
            $(this).parents('.img-wrap').find('.file-id').val(res.id);

            $(this).parents('.img-wrap').find('.image-off').css('display', 'none');
            $(this).parents('.img-wrap').find('.image-on').css('display','block');

            if($(this).parents('.img-wrap').hasClass('main-thumbnail-wrap')) {
                $('.thumbnail-check').val("Y");
                $('.thumbnail-check').parsley().validate();
                thumbnailValidation();
            }
        }).fail(err => {
            alert('오류가 발생하였습니다.')
        });
    });

    $('.btn-delete-thumbnail').click(function (){
        $(this).parents('.img-wrap').find('.thumbnail-image').attr('src',"");
        $(this).parents('.img-wrap').find('.thumbnail-input').val("");
        $(this).parents('.img-wrap').find('.file-id').val("");

        if($(this).parents('.img-wrap').hasClass('main-thumbnail-wrap')) {
            $('.thumbnail-check').val("N");
            $('.thumbnail-check').parsley().validate();
            thumbnailValidation();
        }

        $(this).parents('.img-wrap').find('.image-off').css('display', 'block');
        $(this).parents('.img-wrap').find('.image-on').css('display','none');
    });

    // search address
    function DaumPostcode() {
        new daum.Postcode({
            oncomplete: function (data) {
                var roadAddr = data.roadAddress;
                var addresses = $('.address');

                addresses.val(roadAddr);
                searchAddressToCoordinate(addresses.val());

                $('.address-hidden-sido').val(data.sido);
                $('.address-hidden-gugun').val(data.sigungu);
                $('.address-hidden-dong').val(data.bname);

                addresses.parsley().validate();
            },
        }).open({
            autoClose: true
        });
    }

    $('.btn-address').click(function () {
        DaumPostcode();
    });

    // naver map
    var mapOptions = {
        center: new naver.maps.LatLng(37.481431, 126.999342),
        zoom: 17
    };

    var map = new naver.maps.Map('map', mapOptions);

    var marker = new naver.maps.Marker({
        position: new naver.maps.LatLng(37.481431, 126.999342),
        map: map
    });

    function searchAddressToCoordinate(address) {
        naver.maps.Service.geocode({
            query: address
        }, function (status, response) {
            if (status !== naver.maps.Service.Status.OK) {
                return alert('오류가 발생하였습니다.');
            }

            var result = response.v2, // 검색 결과의 컨테이너
                item = result.addresses[0], // 검색 결과의 배열
                point = new naver.maps.Point(item.x, item.y);

            $('.address-hidden-latitude').val(result.addresses[0].x);
            $('.address-hidden-longitude').val(result.addresses[0].y);

            map.setCenter(point);
            marker.setPosition(point);
        });
    }

    //editor
    CKEDITOR.replace('editor', {
        height: 370,
        resize_enabled: false,
    });

    // date event
    $('.start-date').datepicker({
        dateFormat: "yy-mm-dd",
        beforeShow: function (input, inst) {
            setTimeout(function () {
                inst.dpDiv.css({
                    top: $('.start-date').offset().top + 35,
                    left: $('.start-date').offset().left
                });
            }, 0);
        },
        showMonthAfterYear: true,
        nextText: "",
        prevText: "",
        numberOfMonths: 1,
        monthNames: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
        dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
        minDate: 0,
        yearSuffix: '.',
    });

    $('.start-date').focus(function (e) {
        $(this).addClass('on-show');
    });

    $('.start-date').blur(function () {
        $(this).removeClass('on-show');
    });

    $('.end-date').datepicker({
        dateFormat: "yy-mm-dd",
        showMonthAfterYear: true,
        beforeShow: function (input, inst) {
            setTimeout(function () {
                inst.dpDiv.css({
                    top: $('.end-date').offset().top + 35,
                    left: $('.end-date').offset().left
                });
            }, 0);
        },
        nextText: "",
        prevText: "",
        numberOfMonths: 1,
        monthNames: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
        dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
        minDate: 0,
        yearSuffix: '.',
    });

    $('.end-date').focus(function (e) {
        $(this).addClass('on-show');
    });

    $('.end-date').blur(function () {
        $(this).removeClass('on-show');
    });

    // radio event
    $('.salary').change(function () {
        if ($(this).val() == '4') {
            $('.salary-input').attr('disabled', false);
        } else {
            $('.salary-input').attr('disabled', true);
        }
    });

    $('.study').change(function () {
        if ($(this).val() == '1') {
            $('.study-select').attr('disabled', false);
            $(".study-select").selectmenu("enable");
        } else {
            $('.study-select').attr('disabled', true);
            $(".study-select").selectmenu("disable");
        }
    });

    $('.career').change(function () {
        if ($(this).val() == '2') {
            $('.career-select').attr('disabled', false);
            $(".career-select").selectmenu("enable");
        } else {
            $('.career-select').attr('disabled', true);
            $(".career-select").selectmenu("disable");
        }
    });

    $('.work-day').change(function () {
        if ($(this).val() == '4') {
            $('.work-day-input').attr('disabled', false);
        } else {
            $('.work-day-input').attr('disabled', true);
        }
    });

    $('.deadline').change(function () {
        if ($(this).val() == '1') {
            $('.start-date').attr('disabled', false);
            $('.start-time').attr('disabled', false);
            $('.end-date').attr('disabled', false);
            $('.end-tme').attr('disabled', false);
        } else {
            $('.start-date').attr('disabled', true);
            $('.start-time').attr('disabled', true);
            $('.end-date').attr('disabled', true);
            $('.end-tme').attr('disabled', true);
        }
    });

    $('.pay-method').change(function () {
        if ($(this).val() == '카드') {
            $('.pay-method-select').attr('disabled', false);
            $(".pay-method-select").selectmenu("enable");
        } else {
            $('.pay-method-select').attr('disabled', true);
            $(".pay-method-select").selectmenu("disable");
        }
    });

    $('.btn-submit').click(function() {
        console.log(1);
        thumbnailValidation();
    });
});
