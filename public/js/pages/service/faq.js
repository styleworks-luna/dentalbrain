$(function () {
    //강의 상세보기
    var arrowDown = $('.arrow-down');
    var question =  $('.question-content');

    arrowDown.click(function () {
        $(this).toggleClass('arrow-change');
        $(this).parent().parent().find('.answer').toggleClass('hide-show');
    })

    question.click(function(e) {
        e.preventDefault();
        $(this).parent().parent().parent().find('.arrow-down').toggleClass('arrow-change');
        $(this).parent().parent().parent().find('.answer').toggleClass('hide-show');
    });

});
