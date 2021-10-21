var player;

var tag = document.createElement('script');

if(video_type == 'wecandeo') {
    window.addEventListener('load', function(){
    var playerdiv = document.getElementById("player");
    var tempDiv = document.createElement('iframe');
    tempDiv.setAttribute('width', '100%');
    tempDiv.setAttribute('height', '100%');
    tempDiv.setAttribute('src', 'https://play.wecandeo.com/video/v/?key='+document.getElementById('youtube_id').value+'&auto=true');
    tempDiv.setAttribute('frameborder', '0');
    tempDiv.setAttribute('allowfullscreen', '');
    tempDiv.setAttribute('allow', 'autoplay;fullscreen;');
    playerdiv.appendChild(tempDiv);
    });
}else{
    tag.src = "https://www.youtube.com/iframe_api";
    var firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
}

function onYouTubeIframeAPIReady() {
    player = new YT.Player('player', {
        width: '100%',
        height: '100%',
        videoId: document.getElementById('youtube_id').value,
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

$(function () {
    let lecture = $('#lecture_id').val()

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

    var mySwiper = new Swiper('.list-swiper-container', {
        slidesPerView: 2.05,
    });

    form_submit_check();
});
