$(function () {
    let mobileCheck = mobile_check()

    // header banner event in desktop
    if (!mobileCheck) {
        var cookieData = document.cookie;
        if (cookieData.indexOf("close=Y") < 0) {
            $('.header-banner').addClass('active');
        } else {
            $('.header-banner').removeClass('active');
        }

        if ($('.header-banner').hasClass('active')) {
            $('.header').css({
                'padding-top': '51px',
                'transition': 'padding .5s ease-in-out',
            });
            $('.header-banner').slideDown(500);
        } else {
            $('.header').css({
                'padding-top': 0,
                'transition': 'padding .5s ease-in-out'
            });
            $('.header-banner').slideUp(500);
        }

        $('.btn-close-banner').click(function (e) {
            e.preventDefault();
            setCookie("close", "Y", 0.125);
            $('.header').css({
                'padding-top': 0,
                'transition': 'padding .5s ease-in-out'
            });
            $('.header-banner').slideUp(500);
        })
    }

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
        scrollbar: {
            el: '.swiper-scrollbar',
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });

    var mySwiper2 = new Swiper('.middle-swiper-container', {
        slidesPerView: 5,
        spaceBetween: 20,
        navigation: {
            nextEl: '.middle-swiper-button-next',
            prevEl: '.middle-swiper-button-prev',
        },
    });

    setTimeout(function() {
        var mySwiper3 = new Swiper('.middle-swiper-container2', {
            initialSlide: 0,
            slidesPerView: 4,
            spaceBetween: 19,
            navigation: {
                nextEl: '.middle-swiper-button-next2',
                prevEl: '.middle-swiper-button-prev2',
            },
            observer: true,
            observeParents: true,
            freeMode: true,
        });


        var mySwiper4 = new Swiper('.middle-swiper-container3', {
            initialSlide: 0,
            slidesPerView: 4,
            spaceBetween: 19,
            navigation: {
                nextEl: '.middle-swiper-button-next3',
                prevEl: '.middle-swiper-button-prev3',
            },
            observer: true,
            observeParents: true,
            freeMode: true,
        });
    }, 800)

    var mySwiper = new Swiper('.m-middle-swiper-container', {
        slidesPerView: 2.6,
    });

    var mySwiper = new Swiper('.m-middle-swiper-container2', {
        initialSlide: 0,
        slidesPerView: 2.1,
        observer: true,
        observeParents: true,
        freeMode: true,
    });

    var mySwiper = new Swiper('.m-middle-swiper-container3', {
        initialSlide: 0,
        slidesPerView: 2.1,
        observer: true,
        observeParents: true,
        freeMode: true,
    });

    var mySwiper = new Swiper('.bottom-swiper-container', {
        slidesPerView: 2,
        spaceBetween: 20,
        navigation: {
            nextEl: '.bottom-swiper-button-next',
            prevEl: '.bottom-swiper-button-prev',
        },
    });
});

function setCookie(cname, cvalue, exdays) {
    var todayDate = new Date();
    todayDate.setTime(todayDate.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + todayDate.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}

