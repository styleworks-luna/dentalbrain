$(function () {
    // 결제 진행중
    var deposit = $('.waiting-deposit');

    deposit.click(function (e) {
        e.preventDefault();
        $('.deposit-detail').slideToggle();
    });
});
