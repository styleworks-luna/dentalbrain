$(function () {
    // select menu
    var select_menu = $('.select-menu');
    if (select_menu.length > 0) {
        select_menu.selectmenu({
            width: 240
        })
    }

    // search address
    function DaumPostcode() {
        new daum.Postcode({
            oncomplete: function (data) {
                var roadAddr = data.roadAddress;
                var addresses = $('.address');

                addresses.val(roadAddr);
                searchAddressToCoordinate(addresses.val());
            },
        }).open({
            autoClose: true
        });
    }

    $('.btn-address').click(function () {
        DaumPostcode();
    });

    // naver map
    var mapOptions = {
        center: new naver.maps.LatLng(37.481431, 126.999342),
        zoom: 17
    };

    var map = new naver.maps.Map('map', mapOptions);

    var marker = new naver.maps.Marker({
        position: new naver.maps.LatLng(37.481431, 126.999342),
        map: map
    });

    function searchAddressToCoordinate(address) {
        naver.maps.Service.geocode({
            query: address
        }, function (status, response) {
            if (status !== naver.maps.Service.Status.OK) {
                return alert('오류가 발생하였습니다.');
            }

            var result = response.v2, // 검색 결과의 컨테이너
                item = result.addresses[0], // 검색 결과의 배열
                point = new naver.maps.Point(item.x, item.y);

            map.setCenter(point);
            marker.setPosition(point);
        });
    }

    // date event
    $('.start-date').datepicker({
        dateFormat: "yy-mm-dd",
        beforeShow: function (input, inst) {
            setTimeout(function () {
                inst.dpDiv.css({
                    top: $('.start-date').offset().top + 35,
                    left: $('.start-date').offset().left
                });
            }, 0);
        },
        showMonthAfterYear: true,
        nextText: "",
        prevText: "",
        numberOfMonths: 1,
        monthNames: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
        dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
        minDate: 0,
        yearSuffix: '.',
    });

    $('.start-date').focus(function (e) {
        $(this).addClass('on-show');
    });

    $('.start-date').blur(function () {
        $(this).removeClass('on-show');
    });

    $('.end-date').datepicker({
        dateFormat: "yy-mm-dd",
        showMonthAfterYear: true,
        beforeShow: function (input, inst) {
            setTimeout(function () {
                inst.dpDiv.css({
                    top: $('.end-date').offset().top + 35,
                    left: $('.end-date').offset().left
                });
            }, 0);
        },
        nextText: "",
        prevText: "",
        numberOfMonths: 1,
        monthNames: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
        dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
        minDate: 0,
        yearSuffix: '.',
    });

    $('.end-date').focus(function (e) {
        $(this).addClass('on-show');
    });

    $('.end-date').blur(function () {
        $(this).removeClass('on-show');
    });
});
