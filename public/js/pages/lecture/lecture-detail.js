var player;

const tag = document.createElement('script');

function onYouTubeIframeAPIReady() {
    let previewId = document.getElementById('preview_id');
    if (previewId != null) {
        player = new YT.Player('player', {
            width: '100%',
            height: '100%',
            videoId: previewId.value,
            events: {
                'onReady': onPlayerReady,
                'onStateChange': onPlayerStateChange
            },
            playerVars: {
                modestbranding: true,
                autoplay: true,
                showinfo: 0,
            },
        });
    }
}

function onPlayerReady(event) {
}

function onPlayerStateChange(event) {
    if (event.data == YT.PlayerState.PLAYING) {
        //플레이어가 재생중일때 작성한 동작이 실행된다.
    }
}

$(function () {
    const preview_type = document.getElementById('preview_type');
    if (preview_type != null) {
        if (preview_type == 'wecandeo') {
            window.addEventListener('load', function () {
                var playerdiv = document.getElementById("video-wrap");
                var tempDiv = document.createElement('iframe');
                tempDiv.setAttribute('width', '100%');
                tempDiv.setAttribute('height', '100%');
                tempDiv.setAttribute('src', 'https://play.wecandeo.com/video/v/?key=' + document.getElementById('preview_id').value + '&auto=true');
                tempDiv.setAttribute('frameborder', '0');
                tempDiv.setAttribute('allowfullscreen', '');
                tempDiv.setAttribute('allow', 'autoplay;fullscreen;');
                playerdiv.appendChild(tempDiv);
            });
        } else {
            tag.src = "https://www.youtube.com/iframe_api";
            var firstScriptTag = document.getElementsByTagName('script')[0];
            firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
        }
    }


    //menu tab 클릭 이벤트
    var clickTabDetail = $('.menu-tab-detail');
    var clickTabList = $('.menu-tab-list');
    var clickTabComment = $('.menu-tab-comment');

    clickTabDetail.click(function () {
        clickTabDetail.addClass('active');
        clickTabComment.removeClass('active');
        clickTabList.removeClass('active');
    });

    clickTabList.click(function () {
        clickTabList.addClass('active');
        clickTabDetail.removeClass('active');
        clickTabComment.removeClass('active');
    });

    clickTabComment.click(function () {
        clickTabComment.addClass('active');
        clickTabDetail.removeClass('active');
        clickTabList.removeClass('active');
    });

    //mobile menu tab 클릭 이벤트
    var clickMTabDetail = $('.m-menu-tab-detail');
    var clickMTabList = $('.m-menu-tab-list');
    var clickMTabComment = $('.m-menu-tab-comment');

    clickMTabDetail.click(function (e) {
        clickMTabDetail.addClass('active');
        clickMTabList.removeClass('active');
        clickMTabComment.removeClass('active');
        e.preventDefault();
        $('.lecture-detail-content').css('display', 'block');
        $('.lecture-list').css('display', 'none');
        $('.lecture-comment').css('display', 'none');
    });

    clickMTabList.click(function (e) {
        clickMTabList.addClass('active');
        clickMTabDetail.removeClass('active');
        clickMTabComment.removeClass('active');
        e.preventDefault();
        $('.lecture-list').css('display', 'block');
        $('.lecture-detail-content').css('display', 'none');
        $('.lecture-comment').css('display', 'none');
    });

    clickMTabComment.click(function (e) {
        clickMTabComment.addClass('active');
        clickMTabDetail.removeClass('active');
        clickMTabList.removeClass('active');
        $('.lecture-comment').css('display', 'block');
        $('.lecture-detail-content').css('display', 'none');
        $('.lecture-list').css('display', 'none');
    });

    //댓글 갯수 이벤트
    var length = $('.comment-list > li').length + $('.child-comment-item').length;
    $('.comment-length').html('(' + length + ')');

    //댓글달기 클릭 이벤트
    var clickCommentWrite = $('.btn-comment-write');

    clickCommentWrite.click(function (e) {
        e.preventDefault();
        var target = $(this);
        var targetForm = target.parent().siblings('.child-comment-area').find('.comment-input-form');
        target.toggleClass('active');
        targetForm.toggleClass('hide');
    });

    // select 에 따른 가격 변동
    function findprice(value) {
        var price = $('.lecture-price');

        price.each(function () {
            if ($(this).data('price') == value) {
                $(this).removeClass('price-hidden');
                $(this).siblings('.lecture-price').addClass('price-hidden');
            }
        });
    }

    // 처음 randering시
    var value = $('.lecture-select-box').find('option:selected').data('price');
    findprice(value);

    //옵션값에 변화를주었을때
    // $('#ticket').change(function() {
    //     var data = $(this).find('option:selected').data('price');
    //     findprice(data);
    // });

    //하트 클릭 이벤트
    var clickLike = $('.like')
    var lectureIdx = $('.lecture-idx').val();
    var open = $('.open')

    open.click(function (e) {
        e.preventDefault();
        var program_id = $('#program_id').val();
        let isOnline = $('#program_is_online').val();
        let apiUrl = '';

        if (isOnline) {
            apiUrl = `/api/admin/lecture/online/${program_id}`;
        } else {
            apiUrl = `/api/admin/lecture/offline/${program_id}`;
        }

        $.ajax({
            url: apiUrl,
            type: "patch",
            success: function (data) {
                alert('변경되었습니다.')
                window.location.reload();
            },

            error: function (request, status, error) {
                if (request.status == 401) {
                    alert('로그인 후 이용해 주세요.');
                } else {
                    alert(request.responseJSON.msg);
                }
            }
        });
    })

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
                'like': like
            },
            success: function (res) {
                var cnt = res.cnt;

                clickLike.toggleClass('active');
                $('.like').text(cnt);
            },
            error: function (request, status, error) {
                if (request.status == 401) {
                    alert('로그인 후 이용해 주세요.');
                } else {
                    alert(request.responseJSON.msg);
                }
            }
        });
    });

    //지도보기 팝업
    $('.btn-map').click(function (e) {
        e.preventDefault();
        $('.dim').css('display', 'block');
        $('.popup-wrap').slideDown();
    });

    $('.btn-popup-close, .dim').click(function (e) {
        e.preventDefault();
        $('.dim').css('display', 'none');
        $('.popup-wrap').slideUp();
    });

    $('#mapzone').each(function () {
        var map_x = $('.map_x').val();
        var map_y = $('.map_y').val();

        if (map_x == '') {
            map_x = '127.105399';
        }
        if (map_y == '') {
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
                if (request.status == 401) {
                    alert('로그인 후 이용해 주세요.');
                } else {
                    alert(request.responseJSON.msg);
                }
            }
        });
    });

    $('.comment-child-submit').click(function () {
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
                if (request.status == 401) {
                    alert('로그인 후 이용해 주세요.');
                } else {
                    alert(request.responseJSON.msg);
                }
            }
        });
    });

    // 댓글 삭제
    $('.comment-delete').click(function () {
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
                if (request.status == 401) {
                    alert('로그인 후 이용해 주세요.');
                } else {
                    alert(request.responseJSON.msg);
                }
            }
        });
    });

    $('.comment-child-delete').click(function () {
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
                if (request.status == 401) {
                    alert('로그인 후 이용해 주세요.');
                } else {
                    alert(request.responseJSON.msg);
                }
            }
        });
    });

    // 댓글 수정
    $('.comment-modify').click(function () {
        var target = $(this).closest('form');

        var modify_input = target.parents('.comment-area').find('.modify-input');
        var image = target.parents('.comment-area').find('.profile-img');
        var write_info = target.parents('.comment-area').find('.write-info');
        var comment_btn = target.parents('.comment-area').find('.comment-btn-area');
        var write_content = target.parents().parents().find('.write-content');

        modify_input.css('display', 'block');
        image.css('display', 'none');
        write_info.css('display', 'none');
        comment_btn.css('display', 'none');
        write_content.css('display', 'none');
    });

    $('.comment-modify-submit').click(function () {
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
                if (request.status == 401) {
                    alert('로그인 후 이용해 주세요.');
                } else {
                    alert(request.responseJSON.msg);
                }
            }
        });
    });

    $('.comment-child-modify-submit').click(function () {
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
                if (request.status == 401) {
                    alert('로그인 후 이용해 주세요.');
                } else {
                    alert(request.responseJSON.msg);
                }
            }
        });
    });

    form_submit_check();
});



