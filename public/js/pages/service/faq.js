$(function () {
    //강의 상세보기
    var question =  $('.question-content');

    question.click(function(e) {
        e.preventDefault();
        $(this).toggleClass('arrow-change');
        $(this).parent().parent().parent().find('.answer').toggleClass('hide-show');
    });

});
