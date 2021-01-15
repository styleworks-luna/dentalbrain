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

    // select 에 따른 가격 변동
    function findprice(value) {
        var price = $('.lecture-price');

        price.each(function () {
            if($(this).data('price') == value) {
                $(this).removeClass('price-hidden');
                $(this).siblings('.lecture-price').addClass('price-hidden');
            }
        });
    }

    // 처음 randering시
    var value = $('.lecture-select-box').find('option:selected').data('price');
    findprice(value);

    //옵션값에 변화를주었을때
    $('#ticket').change(function() {
        var data = $(this).find('option:selected').data('price');
        findprice(data);
    });

    //하트 클릭 이벤트
    var clickLike = $('.like')
    var lectureIdx = $('.lecture-idx').val();

    clickLike.click(function (e) {
        e.preventDefault();
        if (!clickLike.hasClass('active')) {
            $.ajax({
                url: '/api/lectures/' + lectureIdx + '/like',
                type: 'post',
                data: {
                    'like' : 'true',
                },
                success: function(res) {
                    var cnt = res.cnt;

                    clickLike.toggleClass('active');
                    $('.like').text(cnt);
                }
            });
        } else {
            $.ajax({
                url: '/api/lectures/' + lectureIdx + '/like',
                type: 'post',
                data: {
                    'like' : 'false',
                },
                success: function(res) {
                    var cnt = res.cnt;

                    clickLike.toggleClass('active');
                    $('.like').text(cnt);
                }
            });
        }
    });

    //삭제 버튼 이벤트
    $('.btn-comment-delete').click(function (e) {
        e.preventDefault();
        var target = $(this);
        target.parent().parent().parent().parent().remove();
    });

});



