function readImage(input) {
    // 인풋 태그에 파일이 있는 경우
    if (input.files && input.files[0]) {
        // TODO : 이미지 파일인지 검사

        // FileReader 인스턴스 생성
        const reader = new FileReader()
        // 이미지가 로드가 된 경우
        reader.onload = e => {
            const previewImage = document.getElementById("profile-preview")
            previewImage.src = e.target.result
        }
        // reader가 이미지 읽도록 하기
        reader.readAsDataURL(input.files[0])
    }
}

$(function () {
    // parsley
    $("#albatalk_resume_form").parsley({
        excluded: 'input[type=button], input[type=submit], input[type=reset]',
        inputs: 'div, input, textarea, select, input[type=hidden], :hidden',
    });
    
    // select menu
    var select_menu = $('.select-menu');
    if (select_menu.length > 0) {
        select_menu.selectmenu({
            width: 112
        })
    }

    var profileInput = $('#profile-input');
    profileInput.change(e => {
        readImage(e.target);
    })
})
