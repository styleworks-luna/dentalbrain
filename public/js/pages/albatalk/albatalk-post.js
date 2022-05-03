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
    if (nullCheck($('.main-file-id').val())) {
        $('.thumbnail-check').val('N');
    } else {
        $('.thumbnail-check').val('Y');
    }

    $('.file-id').each((idx, x) => {
        if (nullCheck($(x).val())) {
            $(x).parent().find('.image-off').css('display', 'block');
            $(x).parent().find('.image-on').css('display', 'none');
        } else {
            $(x).parent().find('.image-off').css('display', 'none');
            $(x).parent().find('.image-on').css('display', 'block');
        }
    })

    function thumbnailValidation() {
        if (!$('.thumbnail-check').parsley().isValid()) {
            $('.main-thumbnail').css('border-color', '#FF0000');
            scrollTo(0,$('.main-thumbnail').offset().top - 500);
        } else {
            $('.main-thumbnail').css('border-color', '#d8d8d8');
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
            $(this).parents('.img-wrap').find('.thumbnail-image').attr('src', res.url);
            $(this).parents('.img-wrap').find('.file-id').val(res.id);

            $(this).parents('.img-wrap').find('.image-off').css('display', 'none');
            $(this).parents('.img-wrap').find('.image-on').css('display', 'block');

            if ($(this).parents('.img-wrap').hasClass('main-thumbnail-wrap')) {
                $('.thumbnail-check').val("Y");
                $('.thumbnail-check').parsley().validate();
                thumbnailValidation();
            }
        }).fail(err => {
            if (err.status === 422) {
                alert('이미지가 너무 큽니다.')
            } else {
                alert('오류가 발생하였습니다.')
            }

        });
    });

    $('.btn-delete-thumbnail').click(function () {
        $(this).parents('.img-wrap').find('.thumbnail-image').attr('src', "");
        $(this).parents('.img-wrap').find('.thumbnail-input').val("");
        $(this).parents('.img-wrap').find('.file-id').val("");

        if ($(this).parents('.img-wrap').hasClass('main-thumbnail-wrap')) {
            $('.thumbnail-check').val("N");
            $('.thumbnail-check').parsley().validate();
            thumbnailValidation();
        }

        $(this).parents('.img-wrap').find('.image-off').css('display', 'block');
        $(this).parents('.img-wrap').find('.image-on').css('display', 'none');
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

    // validation
    let studyValue

    $('.study').change(function () {
        studyValue = $('.study:checked').val();
        if (studyValue == "1") {
            $('.study-select-check').attr({
                'data-parsley-pattern': "[Y]",
                "data-parsley-pattern-message": "※ 학력을 선택해주세요.",
                "data-parsley-errors-container": ".study-type-error-container"
            });
            $('.study-select').on("selectmenuselect", function (event, ui) {
                if (event.target.value == "0") {
                    $('.study-select-check').val("N");
                    $('.study-select-check').parsley().validate();
                } else {
                    $('.study-select-check').val("Y");
                    $('.study-select-check').parsley().validate();
                }
            })
        } else {
            $('.study-select-check').parsley().destroy();
            $('.study-select-check').removeAttr(
                'data-parsley-pattern data-parsley-pattern-message data-parsley-errors-container'
            );
        }
    })

    let careerValue

    $('.career').change(function () {
        careerValue = $('.career:checked').val();
        if (careerValue == "2") {
            $('.career-select-check').attr({
                'data-parsley-pattern': "[Y]",
                "data-parsley-pattern-message": "※ 경력을 선택해주세요.",
                "data-parsley-errors-container": ".career-error-container"
            });
            $('.career-select').on("selectmenuselect", function (event, ui) {
                if (event.target.value == "0") {
                    $('.career-select-check').val("N");
                    $('.career-select-check').parsley().validate();
                } else {
                    $('.career-select-check').val("Y");
                    $('.career-select-check').parsley().validate();
                }
            });
        } else {
            $('.career-select-check').parsley().destroy();
            $('.career-select-check').removeAttr(
                'data-parsley-pattern data-parsley-pattern-message data-parsley-errors-container'
            );
        }
    });

    $('.salary').change(function () {
        salaryValue = $('.salary:checked').val();
        if (salaryValue == "4") {
            $('.salary-input').attr({
                'data-parsley-required': "[Y]",
                "data-parsley-required-message": "※ 내용을 입력해주세요.",
                "data-parsley-errors-container": ".salary-type-error-container"
            });
            $('.salary-input').parsley().validate();
        } else {
            $('.salary-input').parsley().destroy();
            $('.salary-input').removeAttr(
                'data-parsley-required data-parsley-required-message data-parsley-errors-container'
            );
        }
    });

    $('.work-day').change(function () {
        salaryValue = $('.work-day:checked').val();
        if (salaryValue == "4") {
            $('.work-day-input').attr({
                'data-parsley-required': "[Y]",
                "data-parsley-required-message": "※ 내용을 입력해주세요.",
                "data-parsley-errors-container": ".day-type-error-container"
            });
            $('.work-day-input').parsley().validate();
        } else {
            $('.work-day-input').parsley().destroy();
            $('.work-day-input').removeAttr(
                'data-parsley-required data-parsley-required-message data-parsley-errors-container'
            );
        }
    });

    let startDate = '';
    let endDate = '';

    let deadlineValue = $('.deadline:checked').val();;
    let dateCompareCheck;

    function dateCompareValidate() {
        let startTime = $('.start-time').val();
        let startFullDate = `${startDate} ${startTime}`;
        let endTime = $('.end-time').val();
        let endFullDate = `${endDate} ${endTime}`;
        dateCompareCheck = dateCompare(startFullDate, endFullDate);

        if (dateCompareCheck < 0) {
            $('.date-compare-check').val("N");
            $('.date-compare-check').parsley().validate();
        } else {
            $('.date-compare-check').val("Y");
            $('.date-compare-check').parsley().validate();
        }
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
        onSelect: function (s, e) {
            startDate = s;
            $('.start-date').parsley().validate();
            dateCompareValidate();
        },
        showMonthAfterYear: true,
        nextText: "",
        prevText: "",
        numberOfMonths: 1,
        monthNames: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
        dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
        minDate: null,
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
        onSelect: function (s, e) {
            endDate = s;
            $('.end-date').parsley().validate();
            dateCompareValidate();
        },
        nextText: "",
        prevText: "",
        numberOfMonths: 1,
        monthNames: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
        dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
        minDate: 0,
        yearSuffix: '.',
    });

    $('#start_time').timepicker({
        timeFormat: 'HH:mm',
        interval: 1,
        startTime: '00:00',
        dynamic: false,
        dropdown: true,
        scrollbar: true
    });

    $('#end_time').timepicker({
        timeFormat: 'HH:mm',
        interval: 1,
        startTime: '00:00',
        dynamic: false,
        dropdown: true,
        scrollbar: true
    });

    $('.end-date').focus(function (e) {
        $(this).addClass('on-show');
    });

    $('.end-date').blur(function () {
        $(this).removeClass('on-show');
    });

    $('.start-time').on("input change paste", function () {
        dateCompareValidate();
    });

    $('.end-time').on("input change paste", function () {
        dateCompareValidate();
    });

    function timeValidation() {
        if (deadlineValue == '1') {
            $('.start-date').attr({
                'data-parsley-required': "true",
                "data-parsley-required-message": "※ 시작일자를 선택해주세요.",
                "data-parsley-errors-container": ".deadline-error-container"
            });
            $('.start-time').attr({
                'data-parsley-required': "true",
                "data-parsley-required-message": "※ 시작시간을 입력해주세요.",
                "data-parsley-errors-container": ".deadline-error-container"
            });
            $('.end-date').attr({
                'data-parsley-required': "true",
                "data-parsley-required-message": "※ 마감일자를 선택해주세요.",
                "data-parsley-errors-container": ".deadline-error-container"
            });
            $('.end-time').attr({
                'data-parsley-required': "true",
                "data-parsley-required-message": "※ 마감시간을 입력해주세요.",
                "data-parsley-errors-container": ".deadline-error-container"
            });
            $('.date-compare-check').attr({
                'data-parsley-pattern': "[Y]",
                "data-parsley-pattern-message": "※ 시작 날짜를 마감 날짜보다 이르게 입력해주세요.",
                "data-parsley-errors-container": ".deadline-error-container"
            });
            dateCompareValidate();
        } else {
            $('.start-date').parsley().destroy();
            $('.start-time').parsley().destroy();
            $('.end-date').parsley().destroy();
            $('.end-time').parsley().destroy();
            $('.date-compare-check').parsley().destroy();

            $('.start-date').removeAttr(
                'data-parsley-required data-parsley-required-message data-parsley-errors-container'
            );
            $('.start-time').removeAttr(
                'data-parsley-required data-parsley-required-message data-parsley-errors-container'
            );
            $('.end-date').removeAttr(
                'data-parsley-required data-parsley-required-message data-parsley-errors-container'
            );
            $('.end-time').removeAttr(
                'data-parsley-required data-parsley-required-message data-parsley-errors-container'
            );
            $('.date-compare-check').removeAttr(
                'data-parsley-required data-parsley-required-message data-parsley-errors-container'
            );
        }
    }

    timeValidation();

    $('.deadline').change(function () {
        deadlineValue = $('.deadline:checked').val();
        timeValidation();

    })

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
            $('.end-time').attr('disabled', false);
        } else {
            $('.start-date').attr('disabled', true);
            $('.start-time').attr('disabled', true);
            $('.end-date').attr('disabled', true);
            $('.end-time').attr('disabled', true);
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

    $('.btn-submit').click(function () {
        if($('.career-select-check').parsley().isValid() == false) {
            scrollTo(0, $('.career').offset().top - 500);
        } else if($('.study-select-check').parsley().isValid() == false) {
            scrollTo(0, $('.career').offset().top - 500);
        }
        thumbnailValidation();
    });
});

function dateCompare(start, end) {
    let startDate = new Date(start);
    let endDate = new Date(end);

    return endDate.getTime() - startDate.getTime();
}
