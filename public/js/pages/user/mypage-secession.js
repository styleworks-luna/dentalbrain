$(function() {
    // 파슬리
    $('#form-secession').parsley();

    $('#secession-radio-06').click(function(){
       $('#secession-reason').attr({
           'readonly': false,
           'data-parsley-required': true
       });
    });

    $('#secession-radio-01, #secession-radio-02, #secession-radio-03, #secession-radio-04, #secession-radio-05').click(function(){
        $('#secession-reason').attr({
            'readonly': true,
            'data-parsley-required': false
        });
    });

});
