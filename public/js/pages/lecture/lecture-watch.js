var player;

var preProgress = 0;

function isWecandeoVideo() {
    return video_type == 'wecandeo';
}

function createWecandeoPlayer() {
    const iFramePlayer = document.createElement('iframe');
    iFramePlayer.setAttribute('width', '100%');
    iFramePlayer.setAttribute('height', '100%');

    let url = new URL('https://play.wecandeo.com/video/v/');
    url.searchParams.append('key', youtube_id);
    url.searchParams.append('auto', true);
    url.searchParams.append('start', preProgress);

    iFramePlayer.setAttribute('src', url.toString());
    iFramePlayer.setAttribute('frameborder', '0');
    iFramePlayer.setAttribute('allowfullscreen', '');
    iFramePlayer.setAttribute('allow', 'autoplay;fullscreen;');
    return iFramePlayer;
}

function insertScriptForYoutube() {
    const tag = document.createElement('script');
    tag.src = "https://www.youtube.com/iframe_api";
    const firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
}

function onYouTubeIframeAPIReady() {
    player = new YT.Player('player', {
        width: '100%',
        height: '100%',
        videoId: youtube_id,
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

function onPlayerReady(event) {
    event.target.playVideo();//자동재생
}

function onPlayerStateChange(event) {
    if (event.data == YT.PlayerState.PLAYING) {
        //플레이어가 재생중일때 작성한 동작이 실행된다.
    }
}

function setUpPlayer(iFrame, lectureId = null) {
    function callProgressAPI(lectureId, time) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: `/api/lectures/${lectureId}/save-progress`,
            type: "POST",
            data: {
                time: time,
            }
        }).then(function (data) {
            console.log(data);
        }).fail(function (xhr, textStatus, errorThrown) {
            let response = xhr.responseJSON;
            console.log(response.msg);
        });
    }

    function updateProgress(lectureId, time) {
        if (Math.abs(time - preProgress) > 5) {
            preProgress = time;
            callProgressAPI(lectureId, time);
        }
    }

    const wrapper = document.getElementById("video-wrap");
    wrapper.appendChild(iFrame);
    var content = iFrame.contentWindow || iFrame.contentDocument;
    let iframeAPI = new smIframeAPI(content);

    iframeAPI.onEvent(smIframeEvent.READY, function () {
        // 플레이어 준비 완료 이벤트
    });

    iframeAPI.onEvent(smIframeEvent.PLAY, function () {
        callProgressAPI(lectureId, iframeAPI.getPosition());
    });

    iframeAPI.onEvent(smIframeEvent.PAUSE, function (data) {
        //영상 일시정지 이벤트
        updateProgress(lectureId, iframeAPI.getPosition());
    });

    iframeAPI.onEvent(smIframeEvent.COMPLETE, function () {
        //영상 재생 완료 이벤트
        callProgressAPI(lectureId, 0);
    });

    iframeAPI.onEvent(smIframeEvent.TIME, function (data) {
        //영상 재생시간 이벤트
        updateProgress(lectureId, data.position);
    });
}

$(function () {
    let lecture = $('#lecture_id').val()

    if (isWecandeoVideo()) {
        let iFrame = createWecandeoPlayer();
        setUpPlayer(iFrame, lecture);
    } else {
        insertScriptForYoutube();
    }

    $('#question_submit').click(function () {
        var question = $('#question').val();
        var data = {"question": question};

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: `/account/questions/${lecture}`,
            type: "POST",
            data: data,
            success: function (data) {
                alert('질문 등록이 완료되었습니다.');
                $('#question').val('');
            },
            error: function () {
                alert('질문 등록이 오류로 인해 수행하지 못하였습니다.')
            }
        });
    });


    //모바일 페이지 전용
    var mySwiper = new Swiper('.list-swiper-container', {
        slidesPerView: 2.05,
    });

    form_submit_check();
})
;
