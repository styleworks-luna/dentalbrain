$(function () {
    //강의 상세보기
    var arrowDown = $('.arrow-down');

    arrowDown.click(function () {
        $(this).toggleClass('arrow-change');
        $(this).parent().parent().find('.answer').toggleClass('hide-show');
    })
});
