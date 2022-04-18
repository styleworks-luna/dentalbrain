$(function() {
    $('.btn-map').click(function (e) {
        e.preventDefault();
        $('.dim').css('display', 'block');
        $('.map-popup-wrap').slideDown();
    });

    $('.thumbnail-on').click(function (e) {
        e.preventDefault();
        let source = $(this).attr('src');

        $('.dim').css('display', 'block');
        $('.image-popup-wrap').slideDown();

        $('.popup-img').attr('src', source);
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
            center: new naver.maps.LatLng(map_y, map_x),
            zoom: 17
        });

        marker = new naver.maps.Marker({
            position: new naver.maps.LatLng(map_y, map_x),
            map: map
        });
    });

    // mobile swiper
    let mobileCheck = mobile_check();
    if(mobileCheck) {
        function numFormat(variable) {
            variable = Number(variable).toString();
            if (Number(variable) < 10 && variable.length == 1) variable = "0" + variable;
            return variable;
        }

        var mySwiper = new Swiper('.swiper-container', {
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            cssMode: true,
            pagination: {
                el: '.swiper-pagination',
                type: 'fraction',
                renderFraction: function (currentClass, totalClass) {
                    return '<span class="' + currentClass + '"></span>' +
                        '<span class="pagination-bar"></span>' +
                        '<span class="' + totalClass + '"></span>';
                },
                formatFractionCurrent: function (number) {
                    var Mynumber = numFormat(number)
                    return Mynumber;
                },
                formatFractionTotal: function (number) {
                    var Mynumber = numFormat(number)
                    return Mynumber;
                },
            },
        });
    }
});
