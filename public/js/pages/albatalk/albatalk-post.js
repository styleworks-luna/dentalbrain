$(function () {
    // select menu
    var select_menu = $('.select-menu');
    if (select_menu.length > 0) {
        select_menu.selectmenu({
            width: 240
        })
    }

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

    $('.start-date').blur(function() {
        $(this).removeClass('on-show');
    })

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
    })

    $('.end-date').blur(function() {
        $(this).removeClass('on-show');
    });
});
