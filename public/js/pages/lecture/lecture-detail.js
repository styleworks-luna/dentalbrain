$(function () {

    //menu tab 클릭 이벤트
    var clickTabDetail = $('.menu-tab-detail');
    var clickTabComment = $('.menu-tab-comment');

    clickTabDetail.click(function () {
        clickTabDetail.addClass('active');
        clickTabComment.removeClass('active');
    });

    clickTabComment.click(function () {
        clickTabComment.addClass('active');
        clickTabDetail.removeClass('active');
    });
    //댓글 갯수 이벤트
    var length = $('.comment-list > li').length + $('.child-comment-item').length;
    console.log(length);
    $('.comment-length').html('(' + length + ')');

    //댓글달기 클릭 이벤트
    var clickCommentWrite = $('.btn-comment-write');

    clickCommentWrite.click(function (e) {
        e.preventDefault();
        var target = $(this);
        var targetForm = target.parent().parent().next().children().eq(0);
        target.toggleClass('active');
        targetForm.toggleClass('hide');
    });

    //하트 클릭 이벤트
    var clickLike = $('.like');
    var likeNum = 0

    clickLike.click(function (e) {
        e.preventDefault();
        clickLike.toggleClass('active');
        if (clickLike.hasClass('active')) {
            likeNum++;
            '/api/lectures/5/like'
        } else {
            '/api/lectures/5/unlike'
        }
    });

    //삭제 버튼 이벤트
    $('.btn-comment-delete').click(function (e) {
        e.preventDefault();
        var target = $(this);
        target.parent().parent().parent().parent().remove();
    });

});



