$(function () {
    email_box('.email_box');

    //파일 업로드 file name 업데이트
    var fileTarget = $('.upload-hidden');

    fileTarget.on('change', function(){
        if (window.FileReader) {
            var filename = $(this)[0].files[0].name;
        } else {
            var filename = $(this).val().split('/').pop().split('\\').pop();
        }

        $(this).siblings('.file-name').val(filename);
    });

    // 전체 동의
    var agreeAll = $('input:checkbox[name=agree-all]')
    var agreeOffer = $("input:checkbox[name=offer-consent]");
    var agreeRefund = $("input:checkbox[name=refund-consent]");

    $('.agreement-all-wrap input[type="checkbox"]').change(function(){
        var check = $(this).is(':checked');
        $('.agreement-wrap input[type="checkbox"]').prop('checked', check);
    });

    $('.agreement-wrap > ul > li').change(function() {
        if (agreeOffer.is(':checked') == true && agreeRefund.is(':checked') == true) {
            agreeAll.prop('checked', true);
        } else {
            agreeAll.prop('checked', false);
        }
    });

    $('.btn-address').click(function(){
        DaumPostcode();
    });

});
function DaumPostcode() {
    new daum.Postcode({
        oncomplete: function(data) {
            // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

            // 도로명 주소의 노출 규칙에 따라 주소를 표시한다.
            // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
            var roadAddr = data.roadAddress; // 도로명 주소 변수

            // 우편번호와 주소 정보를 해당 필드에 넣는다.
            document.getElementById("address").value = roadAddr;
        },
    }).open({
        autoClose: true
    });
}
