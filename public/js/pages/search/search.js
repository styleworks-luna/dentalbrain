$(function() {
    $('#keyword').keydown(function() {
        if ( $('#keyword').val() == "" ) {
            $('.btn-delete').css('display', 'none');
        } else {
            $('.btn-delete').css('display', 'block');
        }
    })
    $('.btn-delete').click(function() {
        $('#keyword').val('');
        $('.btn-delete').css('display', 'none');
    })
});
