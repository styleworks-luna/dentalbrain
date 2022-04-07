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
        numberOfMonths: 1,
        monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
        dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
        minDate: 0,
        yearSuffix: '년'
    });
});
