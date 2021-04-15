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

        var like = 'true';

        if (!clickLike.hasClass('active')) {
            like = 'true';
        } else {
            like = 'false';
        }
        
        $.ajax({
            url: '/api/lectures/' + lectureIdx + '/like',
            type: 'post',
            data: {
               'like' : like
            },
            success: function(res) {
                var cnt = res.cnt;

                clickLike.toggleClass('active');
                $('.like').text(cnt);
            },
            error: function (request, status, error) {
                if(request.status == 401) {
                    alert('로그인 후 이용해 주세요.');
                } else {
                    alert(request.responseJSON.msg);
                }
            }
        });
    });

    //지도보기 팝업
    $('.btn-map').click(function(e) {
        e.preventDefault();
        $('.dim').css('display', 'block');
        $('.popup-wrap').slideDown();
    });

    $('.btn-popup-close, .dim').click(function(e) {
        e.preventDefault();
        $('.dim').css('display', 'none');
        $('.popup-wrap').slideUp();
    });

    $('#mapzone').each(function(){
        var map_x = $('.map_x').val();
        var map_y= $('.map_y').val();

        if(map_x == ''){
            map_x = '127.105399';
        }
        if(map_y == ''){
            map_y = '37.3595704';
        }

        map = new naver.maps.Map('mapzone', {
            useStyleMap: true,
            center: new naver.maps.LatLng(map_y, map_x),
            zoom: 17
        });
        marker = new naver.maps.Marker({
            position: new naver.maps.LatLng(map_y, map_x),
            map: map
        });
    });

    // 댓글 등록
    $(".comment-submit").click(function () {
        var program_id = $('#program_id').val();
        var content = $('.comment-submit-content').val();
        var data = {
            "content": content,
        };

        $.ajax({
            url: `/api/lectures/${program_id}/comments`,
            type: "POST",
            data: data,
            success: function (data) {
                alert(data.msg);
                location.reload()
            },
            error: function (request, status, error) {
                if(request.status == 401) {
                    alert('로그인 후 이용해 주세요.');
                } else {
                    alert(request.responseJSON.msg);
                }
            }
        });
    });

    $('.comment-child-submit').click(function() {
        var target = $(this);

        var program_id = $('#program_id').val();
        var parent_id = target.parent().find('.parent_id').val();

        var content = target.parent().find('.comment-child-submit-content').val();
        var data = {
            "parent_id": parent_id,
            "content": content,
        };

        $.ajax({
            url: `/api/lectures/${program_id}/comments`,
            type: "POST",
            data: data,
            success: function (data) {
                alert(data.msg);
                location.reload()
            },
            error: function (request, status, error) {
                if(request.status == 401) {
                    alert('로그인 후 이용해 주세요.');
                } else {
                    alert(request.responseJSON.msg);
                }
            }
        });
    });

    // 댓글 삭제
    $('.comment-delete').click(function() {
        var target = $(this).closest('form');

        var program_id = $('#program_id').val();
        var comment_id = target.find('.comment_id').val();

        var content = $(this).closest('.comment-area').find('.comment-text').text();
        var data = {
            "content": content,
        };

        $.ajax({
            url: '/api/lectures/' + program_id + '/comments/' + comment_id,
            method: "DELETE",
            data: data,
            success: function (data) {
                alert(data.msg);
                location.reload()
            },
            error: function (request, status, error) {
                if(request.status == 401) {
                    alert('로그인 후 이용해 주세요.');
                } else {
                    alert(request.responseJSON.msg);
                }
            }
        });
    });

    $('.comment-child-delete').click(function() {
        var target = $(this).closest('form');

        var program_id = $('#program_id').val();
        var parent_id = target.find('.parent_id').val();
        var comment_id = target.find('.comment_id').val();

        var content = $(this).closest('.comment-area').find('.comment-text').text();
        var data = {
            "content": content,
            "parent_id": parent_id,
        };

        $.ajax({
            url: '/api/lectures/' + program_id + '/comments/' + comment_id,
            method: "DELETE",
            data: data,
            success: function (data) {
                alert(data.msg);
                location.reload()
            },
            error: function (request, status, error) {
                if(request.status == 401) {
                    alert('로그인 후 이용해 주세요.');
                } else {
                    alert(request.responseJSON.msg);
                }
            }
        });
    });

    // 댓글 수정
    $('.comment-modify').click(function() {
        var target = $(this).closest('form');

        var modify_input = target.parents('.comment-area').find('.modify-input');
        var image = target.parents('.comment-area').find('.profile-img');
        var write_info = target.parents('.comment-area').find('.write-info');
        var comment_btn = target.parents('.comment-area').find('.comment-btn-area');

        modify_input.css('display', 'block');
        image.css('display', 'none');
        write_info.css('display','none');
        comment_btn.css('display','none');
    });

    $('.comment-modify-submit').click(function() {
        var target = $(this).closest('form');

        var program_id = $('#program_id').val();
        var comment_id = target.parents('.comment-area').find('.comment-btn-area').find('.comment_id').val();

        var content = target.parents('.comment-area').find('.comment-submit-content').val();

        var data = {
            "content": content,
        };

        $.ajax({
            url: '/api/lectures/' + program_id + '/comments/' + comment_id,
            method: "PUT",
            data: data,
            success: function (data) {
                alert(data.msg);
                location.reload()
            },
            error: function (request, status, error) {
                if(request.status == 401) {
                    alert('로그인 후 이용해 주세요.');
                } else {
                    alert(request.responseJSON.msg);
                }
            }
        });
    });

    $('.comment-child-modify-submit').click(function() {
        var target = $(this).closest('form');

        var program_id = $('#program_id').val();
        var parent_id = target.parents('.child-comment-area').find('.parent_id').val();
        var comment_id = target.parents('.comment-area').find('.comment-btn-area').find('.comment_id').val();

        var content = target.parents('.comment-area').find('.comment-child-modify-content').val();

        var data = {
            "parent_id": parent_id,
            "content": content,
        };

        $.ajax({
            url: '/api/lectures/' + program_id + '/comments/' + comment_id,
            method: "PUT",
            data: data,
            success: function (data) {
                alert(data.msg);
                location.reload()
            },
            error: function (request, status, error) {
                if(request.status == 401) {
                    alert('로그인 후 이용해 주세요.');
                } else {
                    alert(request.responseJSON.msg);
                }
            }
        });
    });

    form_submit_check();
});



