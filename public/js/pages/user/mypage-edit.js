$(function () {

    // select menu
    var select_menu = $('.select-menu');

    if (select_menu.length > 0) {
        select_menu.selectmenu();
    }

    // 파슬리
    $('#edit-from').parsley();
});
