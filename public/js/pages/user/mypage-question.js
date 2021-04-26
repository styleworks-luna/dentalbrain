$(function () {
    var question = $('.question-information');

    question.click(function () {
        $(this).next().toggleClass('hide-show');
        $(this).find('.arrow-down').toggleClass('arrow-change');
    });

});
