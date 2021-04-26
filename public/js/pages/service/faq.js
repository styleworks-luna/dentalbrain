$(function () {
    //강의 상세보기
    var question =  $('.question');

    question.click(function(e) {
        e.preventDefault();
        $(this).toggleClass('arrow-change');
        $(this).parent().parent().find('.answer').toggleClass('hide-show');
    })

    var mQuestion = $('.m-question');

    mQuestion.click(function(e) {
        $(this).next().toggleClass('hide')
        $(this).find('.arrow-down').toggleClass('change');
    })
});
